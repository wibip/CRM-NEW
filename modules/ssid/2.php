<?php
function product_name_convertion($mno_id,$db,$user_distributor)
{
    if ($GLOBALS['qos_ale_version'] == 'ale4') {
        $qos_q = "SELECT `product_id`,LEFT(`product_code`,LENGTH(`product_code`)-1) as `product_code`,pd.`duration` ,`product_code` AS `QOS` 
            FROM `exp_products` p JOIN `exp_products_duration` pd ON 1=1 AND pd.`distributor`='$mno_id' AND pd.`is_default`='1' WHERE p.`mno_id`='$mno_id' AND `network_type`='GUEST'
            ";
        $qos_data = $db->selectDB($qos_q);
    } else {
        $qos_q = "SELECT `product_id`,`product_code`,`QOS` FROM `exp_products` WHERE `mno_id`='$mno_id' AND `network_type`='GUEST' AND `default_product` = '1'";
        $qos_data = $db->selectDB($qos_q);
        if ($qos_data['rowCount'] == 0) {
            $qos_q = "SELECT `product_id`,`product_code`,`QOS` FROM `exp_products` WHERE `mno_id`='$mno_id' AND `network_type`='GUEST'";
            $qos_data = $db->selectDB($qos_q);
        }else{
            $qos_qs = "SELECT p.`product_id`,p.`product_code`,p.`QOS` FROM `exp_products` p INNER JOIN `exp_products_distributor` d ON p.`product_code` = d.`product_code` WHERE p.`mno_id`='$mno_id' AND p.`network_type`='GUEST' AND d.`distributor_code` = '$user_distributor'";
            $qos_data_sel = $db->select1DB($qos_qs);
            array_push($qos_data['data'], $qos_data_sel);
                      
        }
    }
    $list=$qos_data['data'];
    $qos=[];

    foreach ($list as $value) {
        $product_name_new = str_replace('_', '-', $value['product_code']);
        $qosspeed = substr(trim($value['QOS']), -1);
        $name_ar = explode('-', $product_name_new);
        if($GLOBALS['qos_ale_version']=='ale4'){
            try{
                $gap = "";
                $interval = new DateInterval($value['duration']);

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

            }catch(Exception $e){
                $gap="";
            }
            $gap_ar = explode(" ",$gap);
            $duration_val = $gap_ar[0];
        }else{
            $duration = explode('-',str_replace(' ', '-', split_from_num($name_ar[3])));
            $duration_val = $duration[0];
            $duration_type = $duration[1];
        }

        $qos_arr = explode('-', $value['QOS']);
        $n = sizeof($qos_arr)-1;
        $qos_new = substr($qos_arr[$n], 0,-1);
        $name_ar = explode('-', $product_name_new);
        if (strlen($name_ar[3])<1) {
          $name_ar[3] = $GLOBALS['qos_ale_version']=='ale4'?$gap:$name_ar[2];
          $name_ar[2] = $qos_new;
        }

        $dat_ar = ["product"=>split_from_num($name_ar[3]),"product_id"=>$value['product_code'],"id"=>$value['product_id'],"qos"=>$qosspeed,"duration_val"=>$duration_val];
        if(array_key_exists($name_ar[2], $qos)){
            array_push($qos[$name_ar[2]],$dat_ar );
        }else{
            $qos[$name_ar[2]]=[$dat_ar];
        }
        
    }
    //print_r($qos);
    //exit();
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
    $tab_secret = md5(uniqid(rand(), true));
    $_SESSION['guestnet_tab_1_MOD_SECRET'] = $tab_secret;
?>
<!-- <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />

<link rel="stylesheet" type="text/css" href="css/tooltipster.css" /> -->

<style type="text/css">

    @media (max-width: 480px){
        #feild_gp_taddg_divt1 .form-group .net_div{
            width: 100%;
        }

        #feild_gp_taddg_divt1 .net_div .net_div_child:nth-child(1){
            width: 50%;
            margin-bottom: 10px;
        }

    }

    label img{
        margin-left: 10px;
    }

</style>


<div <?php if(isset($tab_guestnet_tab_1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_1">
        <!-- Tab 1 start-->

    <div id="guest_modify_network"></div>

    <?php
    if (isset($_SESSION['msg2'])) {

        echo $_SESSION['msg2'];

        unset($_SESSION['msg2']);
    }
    ?>

        <?php if ($tooltip_enable=='Yes') { ?>

            <h2>SSID Name <img data-toggle="tooltip" title="<?php echo $tooltip_arr['SSID_name']; ?>" src="layout/FRONTIER/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" ></h2>
            <!-- <p><b><i>&nbsp;&nbsp;&nbsp;&nbsp;So your guests can easily identify and connect</i></b></p> -->
        <?php } else{ ?>
            <h2>SSID Name</h2>
        <?php }?>

        <p>
            By default only one of your SSIDs are actively broadcasting. Here you can change the name of your SSIDs, turn on/off
            broadcast or set it to broadcast per a specific schedule. In the splash page section you can pair a unique splash page
            with each SSID.
        </p>
    <p>
        You have the ability to manage the bandwidth allocation and active session duration per device. Use the chart below to review your current Guest Access Profile. If you'd like to increase or decrease the amount of bandwidth your guests can use, please contact us at <?php if(strlen($sup_mobile)){echo $sup_mobile;} ?>.
    </p>
    <p>
        You can configure a broadcast schedule for each SSID under the "Schedule" tab.
    </p>
    <p>Note: If the SSIDs are not showing, try the refresh button below.</p>


        <br/>

        <?php if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='NO' ) {

            ?>

            <div class="controls col-lg-5 form-group">
                <a href="?t=guestnet_tab_1&st=guestnet_tab_1&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary mar-top" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
            </div>


        <?php } ?>


        <div style="display: none" class='alert alert-danger all_na'><button type='button' class='close' data-dismiss='alert'>×</button><strong>


        <?php
                    $no_aps_installed = $message_functions->showMessage('no_aps_installed');;
                    $vars = array(
                        '{$support_number}' => $sup_mobile
                    );

                    $no_aps_installed = strtr($no_aps_installed, $vars);
                    echo $no_aps_installed; 
                ?>

            </strong>
        </div>



        <form id="update_default_qos_table" name="update_default_qos_table" class="form-horizontal" action="?t=guestnet_tab_1" method="post">

            <script>
            function checkChange(id,val,now){
                if(now.value==val){
                    $('#check_update'+id).val('no');
                }else{
                    $('#check_update'+id).val('yes');
                }
            }
            function checkChange1(id,val,now){
                if(now.value==val){
                    $('#check1_update'+id).val('no');
                }else{
                    $('#check1_update'+id).val('yes');
                }
            }
            </script>

            <div class="widget widget-table action-table" >
                <div class="widget-header">
                    <!-- <i class="icon-th-list"></i> -->
                    <h3></h3>
                </div>
                <div class="widget-content table_response" id="ssid_tbl" style="position: relative;width: 930px;">
                    <div style="overflow-x:auto;" >
                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap >
                            <thead>
                            <tr>
                                <th scope="col" colspan="2" data-tablesaw-sortable-col data-tablesaw-priority="persist">SSID Name</th>
                                
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Product <span style="text-transform: none;">(QoS & Duration)</span></th>
                                
                                <!--<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Duration</th>-->
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3" style="width: 10%;">Broadcast Status</th>
                                <!--<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Schedule</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /* $ssid_q="SELECT d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.`ssid`,s.`network_id`, l.`group_tag`
                                       FROM `exp_locations_ssid` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d,`exp_locations_ap_ssid` l
                                     WHERE s.`distributor`=d.`distributor_code`
                                     AND s.`distributor`= a.`distributor_code`
                                     AND a.`ap_code`=l.`ap_id`
                                     AND s.`distributor`='$user_distributor'
                                     AND l.`distributor`='$user_distributor'
                                 --    GROUP  BY  a.`ap_code`
                             GROUP  BY   s.`ssid`";  */

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

//                            $qos_q = "SELECT `product_id`,`product_code`,`QOS` FROM `exp_products` WHERE `mno_id`='$mno_id' AND `network_type`='GUEST'";
//                            $qos_data = $db->selectDB($qos_q);
                            $display_data = product_name_convertion($mno_id,$db,$user_distributor);

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
                                    //echo $get_ssid_product_q="SELECT p.product_code,s. AS f FROM exp_products p JOIN exp_locations_ssid s ON p.`product_id` =s.`product_id` WHERE s.distributor='$user_distributor' AND s.network_id='$ssid_name[network_id]' AND p.`network_type`='GUEST'";
                                    $get_ssid_product_q="SELECT p.product_code, d.`duration` FROM exp_products p JOIN exp_locations_ssid s ON p.`product_id` =s.`product_id`  
                                    JOIN exp_products_duration d ON s.`duration_id`=d.`profile_code`
                                    WHERE s.distributor='$user_distributor' AND s.network_id='$ssid_name[network_id]' AND p.`network_type`='GUEST'";
                                    $product_new_data = $db->select1DB($get_ssid_product_q);
                                    $product_new = $product_new_data['product_code'];
                                    //$product_new_due = ;
                                    /*
                                     * extract duration
                                     * */
                                    try{
                                        $gap = "";
                                        $interval = new DateInterval($product_new_data['duration']);

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

                                    }catch(Exception $e){
                                        $gap="";
                                    }
                                    /*
                                     * end
                                     * */

                                    if (strlen($product_new)<1) {
                                        $product_new = $ssid_name['product_code'];
                                    }
                                    $qos_profile = array();
                                    $qos_profile_k = array();
                                    if(count($display_data)>0){
                                        $selected_key = '';
                                        foreach ($display_data as $display_key=>$display_value) {
                                        if (strlen($display_key) >0) {
                                            $sel_0= '';
                                        foreach ($display_value as $display_value_value) {
                                            if($GLOBALS['qos_ale_version']=='ale4') {
//                                                $comp_ar = explode('-',$display_value_value['product_id']);
//                                                unset($comp_ar[0]);
                                                $comp_val = $display_value_value['product_id']."M";
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
                                            $comp_val = str_replace(" ","",$gap)==str_replace(" ","",$qos_value['product']);
                                        }else{
                                            $comp_val = $product_new==$qos_value['product_id'];;
                                        }
                                    if($comp_val){
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

                                    $ssidname = '<script id="script_'.$i.'" type="text/javascript">
                                    $(document).ready(function() {
                                        
                                    $(\'#update_ssid_' . $i . '\').easyconfirm({locale: {

                                            title: \'SSID Name \',

                                            text: \'Are you sure you want to update the SSID?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                            button: [\'Cancel\',\' Confirm\'],

                                            closeText: \'close\'

                                             }});
                                    $(\'#update_ssid_' . $i . '\').click(function() {
                                            var ssid_new = $("#mod_ssid_name_'.$i.'").val();

                                            if(ssid_new){
                                                window.location =  "?t=guestnet_tab_1&token=' . $tab_secret . '&update_ssid&n=' .$i.'&ssid_old=' .$ssid_name[ssid].'&network_id=' .$ssid_name[network_id].'&name=' .$ssid_name[wlan_name].'&ssid_new="+ssid_new
                                            }else{
                                                $("#ap_id").html("Please Set Network Name");
                                                $("#servicearr-check-div").show();
                                                $("#sess-front-div").show();
                                            }
                                            });
                                        });
                                    </script>';
                                   
                                        if(!empty($ssid_name['ssid'])){
                                            $ssids[]=$ssid_name['ssid'];
                                         echo  "<td  style='font-size:15.5px'>".$ssid_name['ssid']." <img data-toggle='tooltip' title='Easily change the network name that is broadcast by entering a new name in the field and click the UPDATE link.' src='layout/OPTIMUM/img/help.png' style='width: 18px;cursor: pointer;'></td>";
                                   
                                        }else{
                                            echo  "<td></td>";
                                        }
                                    echo '<td style="border-left-width: 0;>"
                                    <input type="hidden" id="ssid_name_'.$i.'" name="ssid_name_'.$i.'" value="'.$ssid_name['ssid'].'" data-bv-field="ssid_name"> 
                                    <input type="text" class="span2 form-control mod_ssid_name" id="mod_ssid_name_'.$i.'" name="mod_ssid_name_'.$i.'"  placeholder="Change Network Name"  data-bv-field="mod_ssid_name" onInput="ssidcheckLength(32,this);validateDuplicate(this,\'update_ssid_'.$i.'\',\'script_'.$i.'\');" > <img data-toggle="tooltip" title="Note: The SSID Name is limited to 32 characters and may include a combination of letters, numbers, and the special characters “_” and “-“ (other special characters are not available for SSID names). The SSID Name cannot start with prohibited words such as “guest,” “administrative,” “admin,” “test,” “demo,” or “production.” These words cannot be used without other descriptive words." src="layout/OPTIMUM/img/help.png" style="width: 18px;cursor: pointer;">
                                    <a style="margin-left: 8px;" type="submit" name="update_ssid_'.$i.'" id="update_ssid_'.$i.'" class="btn btn-small btn-primary">Update</a>'.$ssidname.$datanew.'
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

                                    if($ssid_name['ssid_broadcast']=='AlwaysOn'){
                                        $ssid_status ='1';
                                    }else if($ssid_name['ssid_broadcast']=='Customized'){
                                        $ssid_status ='2';
                                    }else{$ssid_status ='3';}
                                    $ssid_on = $ssid_status=='1'? '  checked   ':'';
                                    

                                                  $schedule2 = $ssid_status=='1'?'On':($ssid_status=='2'?'Schedule':'Off');
                                   // echo "<td >".$schedule."</td>";
                                    echo "<td ><a style='display: inline-block;min-width: 36px;font-size: 15px !important;color:#000;cursor: default;text-decoration: none !important;'>&nbsp;".$schedule2."</a>";
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
            </div><br/>

            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="ssid_name">Current SSID Name : </label>
                    <div class="controls col-lg-5 form-group">
                        <select required class="span4 form-control" id="ssid_name" name="ssid_name" <?php echo $ssidName; ?> onchange="loadSSIDForm(this.value)">
                            <option value="">Select SSID</option>
                            <?php
                            $ssid_q="SELECT s.`ssid`
                                                                                    FROM
                                                                                    `exp_mno_distributor` d
                                                                                    LEFT JOIN
                                                                                    `exp_locations_ssid` s
                                                                                    ON s.`distributor`=d.`distributor_code`
                                                                                    LEFT JOIN
                                                                                    `exp_mno_distributor_aps` a
                                                                                    ON s.`distributor`= a.`distributor_code`
                                                                                    LEFT JOIN
                                                                                    `exp_locations_ap_ssid` l
                                                                                    ON a.`ap_code`=l.`ap_id`

                                                                                    WHERE  d.`distributor_code`='$user_distributor' AND s.ssid<>''
                                                                                    GROUP  BY   s.`ssid`";
                            $ssid_res=$db->selectDB($ssid_q);
                            
                            foreach ($ssid_res['data'] AS $ssid_names) {
                                echo'<option value="'.$ssid_names[ssid].'">'.$ssid_names[ssid].'</option>';
                            }
                            ?>
                        </select>
                        <script>
                            function loadSSIDForm(ssid){

                                /*  alert(ssid);    */
                                var ssid=ssid;
                                var formData={ssid:ssid,dis:"<?php echo $user_distributor; ?>"};
                                $.ajax({
                                    url : "ajax/getSsidDetails.php",
                                    type: "POST",
                                    data : formData,
                                    success: function(data)
                                    {
                                        /*   alert(data);   */
                                        var data_array = data.split(',');

                                        document.getElementById("network_id").value=data_array[1];
                                        document.getElementById("wlan_name").value=data_array[0];
                                    },
                                    error: function (jqXHR, textStatus, errorThrown)
                                    {

                                    }
                                });



                            }
                        </script>
                        <input  id="wlan_name" name="wlan_name" type="hidden" value="" >
                        <input  id="network_id" name="network_id" type="hidden" value="" >
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="mod_ssid_name">New SSID Name : </label>
                    <div >
                        <div class="controls col-lg-5 form-group">
                            <input required class="span4 form-control" id="mod_ssid_name" name="mod_ssid_name" type="text" maxlength="32" value="<?php echo ''; ?>">
                            <small id="invalid_ssid" style="display: none;" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>SSID Name is invalid</p></small>

                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $('#mod_ssid_name').bind("cut copy paste", function (e) {
                                        e.preventDefault();
                                    });


                                    $("#mod_ssid_name").keypress(function (event) {
                                        var ew = event.which;
                                        if (ew == 8 || ew == 0 || ew == 45 || ew == 95)
                                            return true;
                                        if (48 <= ew && ew <= 57)
                                            return true;
                                        if (65 <= ew && ew <= 90)
                                            return true;
                                        if (97 <= ew && ew <= 122)
                                            return true;
                                        return false;


                                    });

                                    $("#mod_ssid_name").blur(function (event) {
                                        var temp_ssid_name = $('#mod_ssid_name').val();
                                        if (checkWords(temp_ssid_name.toLowerCase())) {

                                            $("#mod_ssid_name").val("");
                                            $('#invalid_ssid').css('display', 'inline-block');
                                            $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                            $('#update_ssid').attr('disabled', true);
                                        } else {
                                            $('#invalid_ssid').hide();
                                        }
                                    });

                                    $("#mod_ssid_name").keyup(function (event) {

                                        var temp_ssid_name;
                                        temp_ssid_name = $('#mod_ssid_name').val();
                                        var lastChar = temp_ssid_name.substr(temp_ssid_name.length - 1);
                                        var lastCharCode = lastChar.charCodeAt(0);

                                        if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 45 || lastCharCode == 95) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                            (65 <= lastCharCode && lastCharCode <= 90) ||
                                            (97 <= lastCharCode && lastCharCode <= 122))) {
                                            $("#mod_ssid_name").val(temp_ssid_name.substring(0, temp_ssid_name.length - 1));
                                        }

                                        temp_ssid_name = $('#mod_ssid_name').val();
                                        if (checkWords(temp_ssid_name.toLowerCase())) {

                                            $("#mod_ssid_name").val("");
                                            $('#invalid_ssid').css('display', 'inline-block');
                                            $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                            $('#update_ssid').attr('disabled', true);
                                        } else {
                                            $('#invalid_ssid').hide();
                                        }
                                    });


                                    function past() {

                                        setTimeout(function () {

                                            var temp_ssid_name = $('#mod_ssid_name').val();


                                            if (checkWords(temp_ssid_name.toLowerCase())) {

                                                $("#mod_ssid_name").val("");
                                                $('#invalid_ssid').css('display', 'inline-block');

                                                $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");

                                                $('#update_ssid').attr('disabled', true);
                                            } else {
                                                $('#invalid_ssid').hide();
                                            }


                                        }, 100);

                                    }


                                    function checkWords(inword) {

                                        var words =<?php
                                            $words = $db->getValueAsf("SELECT `policies` AS f FROM `exp_policies` WHERE `policy_code`='SSID_name'");
                                            $words_ar = explode(",", $words);
                                            $script_ar = '[';
                                            for ($i = 0; $i < count($words_ar); $i++) {
                                                $script_ar .= "\"" . $words_ar[$i] . "\",";
                                            }

                                            $script_ar = rtrim($script_ar, ",");
                                            $script_ar .= "]";
                                            echo $script_ar;

                                            ?>;

                                        if (words.indexOf(inword) >= 0) {

                                            return true;

                                        }
                                        else {

                                            var regex = /^[a-zA-Z0-9_-]+$/;

                                            if (regex.test(inword) == false) {

                                                $('#update_ssid').attr('disabled', true);
                                            }

                                            return false;

                                        }


                                    }
                                });
                            </script>

                        </div>
                        <br>
                        <small>
                            <b>Note: The SSID Name is limited to 32 characters and may use a combination of letters, numbers and special characters. The only special characters that may be used are the underscore symbol [_] or the hyphen symbol [-]. Other special characters are not available for SSID names. The SSID Name can not start with prohibited words such as "guest," "administrative," "admin," "test," "demo," or "production." These words cannot be used without other descriptive words. </b>
                        </small>
                    </div>
                </div>
                <?php
                if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='YES' || $package_features=="all") {
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Use
                            Existing Location : </label>

                        <div class="controls col-lg-5 form-group">
                            <div>
                                <select class="span4 form-control" id="old_location_name"
                                        name="old_location_name"
                                        onchange="setNewSSID(this.value)">
                                    <option value="">SELECT LOCATION
                                    </option>
                                    <?php
                                    $get_group_tag_q = "SELECT `tag_name` FROM `exp_mno_distributor_group_tag` WHERE `distributor`='$user_distributor' GROUP BY `tag_name`";
                                    $get_group_tag_r = $db->selectDB($get_group_tag_q);
                                    
                                    foreach ($get_group_tag_r['data'] AS $get_group_tag) {
                                        echo '<option value="' . $get_group_tag['tag_name'] . '">' . $get_group_tag['tag_name'] . '</option>';
                                    }
                                    ?>
                                </select> &nbsp;Or
                            </div>
                        </div>
                    </div>

                    <script>
                        function setNewSSID(grout_tag) {
                            if (grout_tag == '') {
                                document.getElementById("location_name").value = '';
                                document.getElementById("location_name").readOnly = false;
                                document.getElementById("loc_label").innerHTML = 'Create a New Location :';
                            } else {
                                document.getElementById("location_name").value = grout_tag;
                                document.getElementById("location_name").readOnly = true;
                                document.getElementById("loc_label").innerHTML = 'Assign Location :';
                            }
                        }
                    </script>

                    <div class="control-group">
                        <label class="control-label" for="radiobtns"
                               id="loc_label">Create a New Location
                            : </label>

                        <div>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="location_name"
                                       name="location_name" type="text"
                                       value="<?php echo ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </fieldset>


            <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET'];?>">
            <div class="form-actions">
                <button type="submit" name="update_ssid" id="update_ssid" class="btn btn-primary">Update</button>
            </div>
        </form>

    </div>
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
<script type="text/javascript">
    $('.bandwidthUpdate').click(function(event) {
        event.preventDefault();
    });
    
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
        var formData={qos:qos,dure:dure,dis:"<?php echo $user_distributor;?>",task:'updateBandwidth',network_id:net_id};
        console.log(formData);
        $.ajax({
            url: "ajax/updateSSIDBandwidth.php",
            type: "POST",
            data : formData,
            success: function(result){
                var obj = JSON.parse(result);
                if(obj.status=='success'){
                    $( "#guest_modify_network" ).append(obj.message);

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


