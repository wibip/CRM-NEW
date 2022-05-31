  <?php
  function product_name_convertion($mno_id, $db,$user_distributor)
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
    
    $list = $qos_data['data'];
    $qos = [];

    foreach ($list as $value) {
        $product_name_new = str_replace('_', '-', $value['product_code']);
        $qosspeed = substr($value['QOS'], -1);
        $name_ar = explode('-', $product_name_new);
        if ($GLOBALS['qos_ale_version'] == 'ale4') {
            try {
                $gap = "";
                $interval = new DateInterval($value['duration']);

                if ($interval->y != 0) {
                    $gap .= $interval->y . ' Years ';
                }
                if ($interval->m != 0) {
                    $gap .= $interval->m . ' Months ';
                }
                if ($interval->d != 0) {
                    $gap .= $interval->d . ' Days ';
                }
                if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0)) {
                    $gap .= ' And ';
                }
                if ($interval->i != 0) {
                    $gap .= $interval->i . ' Minutes ';
                }
                if ($interval->h != 0) {
                    $gap .= $interval->h . ' Hours ';
                }
            } catch (Exception $e) {
                $gap = "";
            }
            $gap_ar = explode(" ", $gap);
            $duration_val = $gap_ar[0];
            $name_ar = explode('-', $product_name_new);
        } else {
            $duration = explode('-', str_replace(' ', '-', split_from_num($name_ar[3])));
            $duration_val = $duration[0];
            //$duration_type = $duration[1];

            $duration_type = '';
            if ($duration[1] == 'Day') {
                $duration_type = 'Days';
            } else {
                $duration_type = $duration[1];
            }

            $name_ar[3] = $duration_val . " " . $duration_type;
        }

        $qos_arr = explode('-', $value['QOS']);
        $n = sizeof($qos_arr) - 1;
        $qos_new = substr($qos_arr[$n], 0, -1);

        if (strlen($name_ar[3]) < 1) {
            $name_ar[3] = $GLOBALS['qos_ale_version'] == 'ale4' ? $gap : $name_ar[2];
            $name_ar[2] = $qos_new;
        }

        $dat_ar = ["product" => split_from_num($name_ar[3]), "product_id" => $value['product_code'], "id" => $value['product_id'], "qos" => $qosspeed, "duration_val" => $duration_val];
        if (array_key_exists($name_ar[2], $qos)) {
            array_push($qos[$name_ar[2]], $dat_ar);
        } else {
            $qos[$name_ar[2]] = [$dat_ar];
        }
    }
    //print_r($qos);
    //exit();
    return $qos;
}

function split_from_num($a)
{

    $num = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
    for ($i = 0; $i < strlen($a); $i++) {
        if (!in_array($a[$i], $num)) {
            $pos = $i;
            break;
        }
    }
    //echo $pos;
    //echo substr($a,0,$pos);
    //echo substr($a,$pos,strlen($a)-$pos);
    return substr($a, 0, $pos) . " " . ucfirst(substr($a, $pos, strlen($a) - $pos));
}
   ?>
                                        <div <?php if(isset($tab_guestnet_bandwith)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guestnet_bandwith">
                                            <!-- Tab 7 start-->
                                            <div id="response_d1">

                                            </div>
                                            <h2 style="" id="GUEST_online">Bandwidth Profiles</h2>
                                           <!--  <p>Your guests want great <?php //echo __WIFI_TEXT__; ?> access with great Customer Service.</p>
                                            <br/> -->
                                            <?php if($package_functions->getOptions('NET_GUEST_BANDWIDTH_TEXT',$system_package,$user_type)=="COX_COMPLEX_001" || $package_features=="all"){?>
                                            <p><b>Step 1.</b> Set your SSID name, confirm bandwidth allocation and conserve
                                                energy by setting the hours
                                                of the day for when your customers can connect.
                                                <br/>
                                               <b><i> EX. Your plan is 50Mbps, allocate 40Mbps to Guest <?php echo __WIFI_TEXT__; ?>, and 10Mbps to Private <?php echo __WIFI_TEXT__; ?></i></b>
                                                </p><p>
                                                <br/>
                                                <b>Step 2.</b> Set the duration of the Free Internet session, you can set values from minutes,
                                                hours to days, months or even years. When a guest session expires, the guest is redirected
                                                to your captive portal and will be bale to activate a new session.
                                                <br/>
                                                <b><i>  EX. 30 minutes</i></b>
                                                <br/>
                                            </p><p>
                                                <b>Step 3.</b> Optionally you can create multiple bandwidth profiles and set the days of the week
                                                that each of the profiles should be applied.
                                                <br/>
                                                <b><i>  EX. 1h session on weekdays and 8h sessions on weekends </i></b>
                                            </p>
                                            <br>
                                                <?php }

                                            if($package_functions->getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                            ?>

                                            <form id="guest_profile" name="guest_profile" class="form-horizontal" method="post" action="?t=guestnet_bandwith" >
                                                <fieldset>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Bandwidth Profile Name : </label>
                                                        <div >
                                                            <div class="controls ">
                                                                <input class="span4 form-control" id="guest_profile_name" name="guest_profile_name" type="text" value="<?php echo ''; ?>" required >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                  /*  $get_default_Prof_q="SELECT p.`QOS`  FROM `exp_products_distributor` d , `exp_products` p
                                                                                                WHERE p.`product_code`=d.`product_code` AND d.`distributor_code`='$user_distributor'
                                                                                                AND d.network_type='PRIVATE' AND p.`mno_id`='$distributor_mno' LIMIT 1";
                                                    $get_default_Prof=$db->selectDB($get_default_Prof_q);
                                                    $default_QOS= mysql_fetch_assoc($get_default_Prof)['QOS']." Mbps"; */


                                                 /*   echo"SELECT p.`QOS` AS f FROM `exp_products_distributor` d , `exp_products` p
                                                                                                WHERE p.`product_code`=d.`product_code` AND d.`distributor_code`='$user_distributor'
                                                                                                AND d.network_type='PRIVATE' AND p.`mno_id`='$distributor_mno' LIMIT 1";
                                                 */

                                                    $default_QOS =$db->getValueAsf("SELECT p.`QOS` AS f FROM `exp_products_distributor` d , `exp_products` p
                                                                                                WHERE p.`product_code`=d.`product_code` AND d.`distributor_code`='$user_distributor'
                                                                                                AND d.network_type='PRIVATE' AND p.`mno_id`='$distributor_mno' LIMIT 1");


                                                    ?>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Bandwidth Allocation : </label>
                                                        <div >
                                                            <div class="controls " style="display: inline-block;margin-left:20px">
                                                                <select class="span2" id="guest_profile_bandwidth" name="guest_profile_bandwidth"  required >
                                                                    <option value="">Select Option</option>
                                                                    <?php
                                                                        $valid_Guest_QOS=(int)$default_QOS-5;
                                                                        $get_guest_prof_q="SELECT   `product_code`,`QOS` FROM `exp_products` WHERE `network_type`='GUEST'  AND `mno_id`='$distributor_mno' AND `QOS`<$valid_Guest_QOS";
                                                                       // $get_guest_prof_q="SELECT `product_code`,`QOS` FROM `exp_products` WHERE `network_type`='GUEST'  AND `mno_id`='$distributor_mno'";

                                                                        $get_guest_prof_res=$db->selectDB($get_guest_prof_q);
                                                                        foreach ($get_guest_prof_res['data'] AS $get_guest_prof) {
                                                                            echo"<option value=\"".$get_guest_prof[product_code]."/".$get_guest_prof[QOS]."\">".$get_guest_prof[QOS]."</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <strong>&nbsp;&nbsp;Mbps</strong>
                                                            </div><div  style="display: inline-block"><strong>{ Your Current Plan <?php echo $default_QOS." Mbps";  ?>}</strong></div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Internet Session Duration : </label>
                                                        <div >
                                                            <div class="controls ">
                                                                <input class="span1" id="session_time1" name="session_time1" type="number"  required max="30" min="0" onchange="setTimeGap()">
                                                                <select  class="span1" name="session_time_type" id="session_time_type" onchange="setTimeGap()">
                                                                    <option value="D">Days</option>
                                                                    <option value="M">Months</option>
                                                                    <option value="Y">Years</option>
                                                                </select>
                                                                <input class="span1" id="session_time2" name="session_time2" type="number"  required max="60" min="0" onchange="setTimeGap()">
                                                                <select class="span1" name="session_time2_type" id="session_time2_type" onchange="setTimeGap()">
                                                                    <option value="M">Mins</option>
                                                                    <option value="H">Hours</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="active_on">
                                                        <label class="control-label" for="radiobtns">Active : </label>
                                                        <div >
                                                            <script>
                                                                $(document).ready(function(){
                                                                    $("#active_all").click(function(){
                                                                        $("#a :input").prop('checked', this.checked);
                                                                    });

                                                                    $("#a :input").click(function(){
                                                                        if($('.x:checked').length == $('.x').length){
                                                                            $("#active_all").prop('checked', this.checked);
                                                                        }
                                                                        else{
                                                                            $('#active_all').attr('checked', false);
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                            <?php
                                                            $active_guest_on_q="SELECT  d.`active_on`
                                                                                    FROM `exp_products_distributor` d ,`exp_products` p
                                                                                    WHERE d.`product_code`=p.`product_code` AND`distributor_code`='$user_distributor'
                                                                                    AND p.`mno_id`='$distributor_mno' AND d.`network_type`='GUEST'";
                                                            $active_guest_on=$db->selectDB($active_guest_on_q);
                                                            $active_on=array();
                                                            foreach ($active_guest_on['data'] AS $activeon) {
                                                                array_push($active_on,$activeon['active_on']);
                                                            }
                                                          //  print_r($active_on);
                                                            ?>
                                                            <div class="controls ">
                                                                <input  id="active_all" name="active_all" type="checkbox"  value="all" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(count($active_on)>0){echo "disabled";}?> ><strong>&nbsp;&nbsp;All Week</strong></br>
                                                                <div id="a">
                                                                    <input  id="active_mon" name="active_mon" type="checkbox" class="x" value="Monday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Monday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Mon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_tue" name="active_tue" type="checkbox" class="x" value="Tuesday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Tuesday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Tue&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_wed" name="active_wed" type="checkbox" class="x" value="Wednesday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Wednesday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Wed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_thu" name="active_thu" type="checkbox" class="x" value="Thursday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Thursday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Thu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_fri" name="active_fri" type="checkbox" class="x" value="friday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("friday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Fri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_sat" name="active_sat" type="checkbox" class="x" value="Saturday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Saturday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Sat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_sun" name="active_sun" type="checkbox" class="x" value="Sunday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Sunday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Sun&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="guest_prof_secret" value="<?php echo $_SESSION['FORM_SECRET']?>"/>
                                                    <input type="hidden" name="guest_prof_timegap" id="guest_prof_timegap" value=""/>

                                                    <div class="form-actions">
                                                        <button type="submit" name="set_guest_prof" id="set_guest_prof" class="btn btn-primary">Set</button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                            <?php }


                                            if($package_functions->getOptions('NET_GUEST_BANDWIDTH_TEXT',$system_package,$user_type)=="COX_SIMPLE_001"){
                                            ?>

                                               <p>You have the ability to manage the bandwidth allocation and active session duration per device. Use the chart below to review your current Guest Access Profile. 

                                                <?php if($sup_available=='YES'){?>

                                                    If you'd like to increase or decrease the amount of bandwidth your guests can use, please contact us <?php if(strlen($sup_mobile)){echo 'at '.$sup_mobile;} ?>.

                                                <?php }?>


                                                   </p>
                                                   <br>
                                            <?php } ?>

                                            <!-- <h2>Active Profiles</h2>  -->
                                        <br>

                                                    <div class="widget widget-table action-table">
                                                        <div class="widget-header">
                                                            <!-- <i class="icon-th-list"></i> -->
                                                            <h3>Active Profiles</h3>
                                                        </div>

                                                        <div class="widget-content table_response" id="product_tbl">

                                                            <div style="overflow-x:auto;" >
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Download</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Upload</th>
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
                                                                $dist_guest_prof_q="SELECT d.id,d.`product_name`,p.`QOS`,p.`QOS_up_link`,d.`time_gap` , d.`active_on`, d.`duration_prof_code`
                                                                                    FROM `exp_products_distributor` d ,`exp_products` p
                                                                                    WHERE d.`product_code`=p.`product_code` AND`distributor_code`='$user_distributor'
                                                                                    AND p.`mno_id`='$distributor_mno' AND d.`network_type`='GUEST' AND p.`network_type`='GUEST'
                                                                                    GROUP BY d.id";
                                                                $dist_guest_prof_res=$db->selectDB($dist_guest_prof_q);
                                                            foreach ($dist_guest_prof_res['data'] AS $dist_guest_prof) {
                                                                $prof_id=$dist_guest_prof['id'];
                                                                echo "<tr><td>".$dist_guest_prof['product_name']."</td>";
                                                                $ale = false;
                                                                if ($dist_guest_prof['QOS_up_link'] == 0) {
                                                                    $ale = true;
                                                                    $productnew = $dist_guest_prof['product_name'];
                                                                    $productarr = explode("-", $productnew);
                                                                    $product_du = split_from_num($productarr[3]);

                                                                    $productarr = $productarr[2];

                                                                    $speed = explode("x", $productarr);

                                                                    $down = $speed[0];
                                                                    $up = $speed[1];
                                                                    if (empty($up)) {
                                                                        $up = $down;
                                                                    }
                                                                    echo "<td>".$down." Mbps</td>";
                                                                    echo "<td>".$up." Mbps</td>";
                                                                }else{
                                                                    echo "<td>".$dist_guest_prof['QOS']." Mbps</td>";
                                                                    echo "<td>".$dist_guest_prof['QOS_up_link']." Mbps</td>";}

                                                                $timegap1=$dist_guest_prof['time_gap'];
                                                                $du_pro_code=$dist_guest_prof['duration_prof_code'];


                                                                if ($ale != true) {
                                                                $d_proq="SELECT `duration`,profile_code
                                                                        FROM `exp_products_duration`
                                                                        WHERE `profile_code`='$du_pro_code'";
                                                                $dpro_exe=$db->selectDB($d_proq);
                                                                foreach ($dpro_exe['data'] AS $dup) {

                                                                    $timegap=$dup['duration'];
                                                                    $profile_code=$dup['profile_code'];

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

                                                                echo "<td><form style='margin-bottom:0px !important;' action='?t=guestnet_bandwith' method='post'>
                                                                        <select style='margin-bottom:0px !important;' name='du_value' class='span2'>";


                                                                if($timegap1==$timegap){

                                                                    $sel_0='selected';
                                                                }else{

                                                                    $sel_0='';
                                                                }

                                                                    echo "<option ".$sel_0." value='".$profile_code."'>".$gap."</option>";

                                                            $def_durationq="SELECT * FROM `exp_products_duration` WHERE `is_default`='1' AND `distributor`='$distributor_mno'";

                                                            $def_durationq_exe=$db->selectDB($def_durationq);
                                                            foreach ($def_durationq_exe['data'] AS $defduraw) {

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
                                                                        ";

                                                        echo '<input type="hidden" name="du_id" value="'.$prof_id.'">';
                                                        echo '<input type="hidden" name="product_id_a" value="0">';

                                                        echo "<button style='margin-left: 5px; margin-top: 5px;float: right;'
                                                            type='submit' name='du_pro_change' id='du_pro_change' class='btn btn-small btn-primary'>Update</button></td>";

                                                        }else{
                                                            echo "<td><form style='margin-bottom:0px !important;' action='?t=guestnet_bandwith' method='post'>
                                                                        <select style='margin-bottom:0px !important;' name='du_value' class='span2'>";
                                                            $display_data = product_name_convertion($mno_id, $db,$user_distributor)[$productarr];
                                                            foreach ($display_data as $key => $value) {
                                                                $product_time = $value['product'];
                                                                $product_id = $value['id'];
                                                               if ($product_du == $product_time) {
                                                                    $sel_1='selected';
                                                                }else{
                                                                    $sel_1='';
                                                                }
                                                               echo "<option ".$sel_1." value='".$product_id."'>".$product_time."</option>";
                                                            }
                                                            echo "</select>";

                                                            echo '<input type="hidden" name="product_id_a" value="1">';

                                                            echo "<button style='margin-left: 5px; margin-top: 5px;float: right;'
                                                                type='submit' name='du_pro_change' id='du_pro_change' class='btn btn-small btn-primary'>Update</button></td>";
                                                            
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
                                                                                window.location = "?prof_rm_token=' . $_SESSION['FORM_SECRET'] . '&t=guestnet_bandwith&remove_prof_id=' . $prof_id . '"
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
                                                                                window.location = "?prof_ed_token=' . $_SESSION['FORM_SECRET'] . '&t=guestnet_bandwith&edit_prof_id=' . $prof_id . '"
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
                                                </div>

                                            <!-- Tab 7 start-->
                                        </div>