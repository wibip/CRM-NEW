<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL&~E_WARNING&~E_NOTICE);
require_once __DIR__.'/../../classes/systemPackageClass.php';

$ap_q1="SELECT `ap_controller`,zone_id
FROM `exp_mno_distributor`
WHERE `distributor_code`='$user_distributor'
LIMIT 1";

$query_results_ap=$db->select1DB($ap_q1);

$ack = $query_results_ap['ap_controller'];
$zone_id = $query_results_ap['zone_id'];

$ap_q2="SELECT `api_profile`
FROM `exp_locations_ap_controller`
WHERE `controller_name`='$ack'
LIMIT 1";

$query_results_ap2=$db->selectDB($ap_q2);

foreach ($query_results_ap2['data'] AS $row) {
    $wag_ap_name2 = $row['api_profile'];
}
//  $wag_ap_name='NO_PROFILE';
if($wag_ap_name!='NO_PROFILE'){

    include_once 'src/AP/' . $wag_ap_name2 . '/index.php';
    if($wag_ap_name2==""){
        include_once 'src/AP/' . $wag_ap_name . '/index.php';
    }

    $wag_obj = new ap_wag($ack);

}
$pack_func = new package_functions();
$aaa_preview_version = $pack_func->getOptions('AAA_PREVIEW_VERSION',$system_package);

if($aaa_preview_version == 'ALE_V5'){
    $redirection_from = 'ALE_V5';
    $reditection = 'CAPTIVE_ALE5_REDIRECTION';
}
else{
    $redirection_from = 'ALE_V4';
    $reditection = 'CAPTIVE_ALE4_REDIRECTION';
}

$admin_product = $pack_func->getAdminPackage();
$redirection_parameters = $pack_func->getOptions($reditection,$admin_product);
/*
$network_name = trim($db->setVal('network_name','ADMIN'),"/");
$get_parametrs=mysql_query("SELECT p.`redirect_method`,p.`mac_parameter`,p.`ap_parameter`,p.`ssid_parameter`,p.`loc_string_parameter`,p.`network_ses_parameter` ,p.`ip_parameter`
FROM `exp_network_profile` p WHERE p.`network_profile`='$network_name' LIMIT 1");

$row3=mysql_fetch_array($get_parametrs);
*/

if(strlen($redirection_parameters)=='0'){
    $redirection_parameters = '{"mac_parameter":"client_mac","ap_parameter":"ap","ssid_parameter":"ssid","ip_parameter":"IP","loc_string_parameter":"0","network_ses_parameter":"0","group_parameter":"realm","other_parameters":"0"}';
}
$red_decode = (array)json_decode($redirection_parameters);


$network_ses_parameter = $red_decode['network_ses_parameter'];
$ip_parameter = $red_decode['ip_parameter'];
$mac_parameter = $red_decode['mac_parameter'];
$loc_string_parameter = $red_decode['loc_string_parameter'];
$group_parameter = $red_decode['group_parameter'];
$ap_parameter=$red_decode['ap_parameter'];
$ssid_parameter=$red_decode['ssid_parameter'];



$SSL_ON=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='SSL_ON' LIMIT 1");

if($SSL_ON!='1'){
    $pageURL = "http://";
}else{
    $pageURL = "https://";
}


if ($_SERVER["SERVER_PORT"] != "80"){
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
}
else{
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

$base_folder_path_preview = $db->setVal('portal_base_folder', 'ADMIN');
$a="SELECT  verification_number,gateway_type,ap_sync FROM exp_mno_distributor WHERE distributor_code ='$user_distributor'";
//$a="SELECT  `group_number` AS f FROM `exp_distributor_groups` WHERE `distributor`='$user_distributor'";
$dist_data=$db->select1DB($a);
$realm = $dist_data['verification_number'];
$guest_gateway = $dist_data['gateway_type'];
$ap_sync = $dist_data['ap_sync'];

?>
<div <?php if (isset($tab_manage_SSID_splash)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="manage_SSID_splash">

    <div id="messageSpan"></div>
    <?php



    if (isset($_SESSION['manage_SSID_splash'])) {

        echo $_SESSION['manage_SSID_splash'];

        unset($_SESSION['manage_SSID_splash']);
    }


    $tooltip = $guest_gateway == 'AC'?'A service area is a set of grouped Access Points. You can select the Networks (SSID) that should show in the Service Area (all APs). In addition you can select the Splash Page to be used. Select the Network from the dropdown and then the Splash Page from its dropdown. You can add multiple Networks to the Service Area by clicking the plus sign.':
        'A service area is a set of grouped Access Points. You can select the Networks (SSID) that should show in Service Areas. In addition you can select the Splash Page to be used. Select the Service Area from the drop down, then select the Network from the dropdown and finally the Splash Page from its dropdown. You can add multiple Networks to a single Service Area by clicking the plus sign.';

    ?>

    <h1 class="head">
        Manage SSID by Service Area. <img data-toggle="tooltip" title="<?php echo $tooltip; ?>" src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
    </h1>
 <?php if($guest_gateway=='AC'){ ?>

    <p style="
    margin-bottom: 37px; margin-right: 1%; ">You can manage Service Areas, SSID and Splash Pages here. Updating Splash Page for an SSID will update the Splash Page on all Service Areas broadcasting the same SSID.</p>

    <?php
}

    $secretn=md5(uniqid(rand(), true));

    $_SESSION['FORM_SECRET_N'] = $secretn;

    ?>
    <button id="sync_div_btn" onclick="syncRefresh()" class="btn btn-primary" style="display: none;">Refresh</button>
    <style type="text/css">
        .td_btn_last{
            font-size: 12px !important;
        }
    </style>

    <div class="widget-content table_response " style="position: relative;">
        <div style="overflow-x:auto;" >
            <div id="sync_div" style="<?php echo $ap_sync==0?'display: none;':''; ?>" >
                <img id="sync_div_img" src="layout/<?php echo $camp_layout;?>/img/loading-whitebg.gif">
                
                <script>function syncRefresh(){
                        window.location.href= '?t=manage_SSID_splash';
                    }</script>
            </div>
            <script>
                function checkChange2(id,val,now){
                    if(now.value==val){
                        $('#check2_update'+id).val('no');
                    }else{
                        $('#check2_update'+id).val('yes');
                    }
                }
                function checkChange3(id,val,now){
                    if(now.value==val){
                        $('#check3_update'+id).val('no');
                    }else{
                        $('#check3_update'+id).val('yes');
                    }
                }
            </script>
            <table id="group_tag_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                <thead>
                <tr>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" style="min-width: 215px;">Service Area</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">SSID Broadcast</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3" style="min-width: 261px;">Splash Page</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Preview</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Remove</th>

                </tr>
                </thead>
                <tbody>

                <?php

                /*$queryall = $guest_gateway == 'AC' ? "SELECT t.id as id_new,t.tag_name as group_tag,'defult' as Wlan_group,ss.network_id as Network,'All APs' as AP_group,t.theme_name
                                                        FROM exp_mno_distributor_group_tag t JOIN exp_mno_distributor d ON t.distributor=d.distributor_code
                                                        LEFT JOIN exp_locations_ap_ssid ss ON t.tag_name=ss.group_tag
                                                        WHERE d.distributor_code='$user_distributor' AND t.tag_name<>d.verification_number
                                                        group by id_new,t.tag_name,group_tag,wlan_group,t.theme_name" : "SELECT ss.`id` AS 'id_new',ss.`group_tag` AS 'group_tag',ss.wlan_group_id AS 'Wlan_group',ss.`network_id` AS 'Network',ss.`ap_group_id` AS 'AP_group',g.theme_name
                                                        FROM `exp_distributor_wlan_group_ssid` ss JOIN exp_locations_ssid s ON ss.network_id=s.network_id AND s.distributor=ss.distributor LEFT JOIN `exp_mno_distributor_group_tag` g ON  ss.`group_tag`= g.`tag_name`
                                                        WHERE ss.`distributor`='$user_distributor' ORDER BY ss.`ap_group_id`,s.`ssid`";*/
                /*$queryall = "SELECT ss.`id` AS 'id_new',ss.`group_tag` AS 'group_tag',ss.wlan_group_id AS 'Wlan_group',ss.`network_id` AS 'Network',ss.`ap_group_id` AS 'AP_group',g.theme_name
                            FROM `exp_distributor_wlan_group_ssid` ss JOIN exp_locations_ssid s ON ss.network_id=s.network_id AND s.distributor=ss.distributor LEFT JOIN `exp_mno_distributor_group_tag` g ON  ss.`group_tag`= g.`tag_name`
                            WHERE ss.`distributor`='$user_distributor' ORDER BY ss.`ap_group_id`,s.`ssid`";*/

                $queryall = "SELECT ss.`id`          AS 'id_new',
       ss.`group_tag`   AS 'group_tag',
       elas.group_tag AS 'group_tag2',
       ss.wlan_group_id AS 'Wlan_group',
       ss.`network_id`  AS 'Network',
       ss.`ap_group_id` AS 'AP_group',
       g.theme_name
FROM `exp_distributor_wlan_group_ssid` ss
         JOIN exp_locations_ssid s ON ss.network_id = s.network_id AND s.distributor = ss.distributor
         LEFT JOIN `exp_mno_distributor_group_tag` g ON ss.`group_tag` = g.`tag_name`
        LEFT JOIN (SELECT a.*,ap.ap_group_id FROM exp_locations_ap_ssid a LEFT JOIN exp_locations_ap ap ON a.ap_id=ap.ap_code AND a.distributor=ap.mno WHERE a.distributor='$user_distributor') elas ON g.tag_name=elas.group_tag AND elas.distributor=g.distributor AND s.ssid=elas.location_ssid AND elas.ap_group_id=ss.ap_group_id
WHERE ss.`distributor` = '$user_distributor'
GROUP BY ss.`ap_group_id`, s.`ssid`
ORDER BY ss.`ap_group_id`, s.`ssid`";


                $results=$db->selectDB($queryall);
                $a=$results['rowCount'];
                $query="SELECT * FROM `exp_distributor_ap_group` WHERE `distributor`='$user_distributor' AND `name`!='default'";
                $resultnew=$db->selectDB($query);

                $query2="SELECT * FROM `exp_locations_ssid` WHERE `distributor`='$user_distributor'";
                $resultnew2=$db->selectDB($query2);

                $query3="SELECT * FROM `exp_themes` WHERE distributor = '$user_distributor'";
                $resultnew3=$db->selectDB($query3);
                $query4="SELECT * FROM `exp_locations_ap` a LEFT JOIN exp_distributor_ap_group g ON a.`ap_group_id`=g.`group_id` WHERE `mno`='$user_distributor'";
                $resultnew4=$db->selectDB($query4);

                /*if($guest_gateway=='AC') {
                    $arry_asign=array();
                    foreach($results['data'] AS $row){
                        $ssid_net=$row[Network];
                        array_push($arry_asign, $ssid_net);
                    }
                }*/
                $i=0;
                $existssid =array();
                foreach($results['data'] AS $rows){
                    $wlan_group=$rows[Wlan_group];
                    $ap_group_id=$rows[AP_group];
                    $ssid_network=$rows[Network];
                    $id_new=$rows[id_new];
                    $group_tag=$rows[group_tag];
                    $group_tag2=$rows[group_tag2];
                    if($group_tag!=$group_tag2){
                        //Rest update
                        $restQ = "UPDATE exp_locations_ap_ssid aps JOIN exp_locations_ap lap ON aps.ap_id=lap.ap_code SET aps.group_tag = '$group_tag' WHERE lap.ap_group_id='$ap_group_id' AND lap.mno='$user_distributor'";
                        $db->execDB($restQ);
                    }
                    $theme_name=$rows[theme_name];
                    $theme_name_n=json_decode($theme_name,true)['en'];

                    //if($guest_gateway!='AC') {
                        $arry_asign=array();
                        $querywl="SELECT network_id FROM `exp_distributor_wlan_group_ssid` WHERE `wlan_group_id`='$wlan_group' AND distributor='$user_distributor'";
                        $resultwl=$db->selectDB($querywl);

                        foreach($resultwl['data'] AS $row){
                            $network_idd=$row[network_id];
                            array_push($arry_asign, $network_idd);

                        }
                    //}
                    $opt = '';
                    echo '<form id="theme_ap_form'.$i.'" name="theme_ap_form'.$i.'" method="post" action="modules/manage_SSID_splash/1-submit?t=manage_SSID_splash">';
                    echo '<tr>';
                    echo '<td>';
                    echo '<input type="hidden" name="check1_update'.$i.'" class="check_update" id="check1_update'.$i.'" value="no">';
                    //if($guest_gateway!='AC'){
                        foreach ($resultnew['data'] as $row) {
                            $group_id = $row[group_id];
                            $group_name = $row[name];
                            $sele_val = "";

                            if ($group_id == $ap_group_id) {
                                $sele_val = $group_id;
                                $opt .= '<option selected value="' . $group_id . '">' . $group_name . '</option>';
                            } else {
                                $opt .= '<option value="' . $group_id . '">' . $group_name . '</option>';
                            }


                        }
                        echo '<select class="span2" onchange="change_Ap(\'' . $i . '\',\'' . $sele_val . '\',this);" id="ap_group_id_' . $i . '" name="ap_group_id_' . $i . '">';
                        echo $opt;
                        echo '</select>';
                    /*}else{
                        echo'<input value="All APs" type="text" readonly id="ap_group_id_' . $i . '" name="ap_group_id_' . $i . '">';
                    }*/

                    if ($i == ($a - 1)) {
                        echo '<button style="margin-left:7px;" id="add_row" class="btn btn-primary btn-xs clone-button btn-add add_row" type="button"  >+</button>';
                    }

                    $ap_arr = [];

                    foreach($resultnew4['data'] AS $row){
                        $ap_code=$row['ap_code'];
                        $group_id=$row['group_id'];
                        $ap_arr[$group_id]=$ap_code;
                    }
                    $opt2 = '';
                    foreach($resultnew2['data'] AS $row){
                        $ssid=$row[ssid];
                        $network_id=$row[network_id];
                        $sele1_val ="";
                        if ($network_id==$ssid_network) {
                            $newssid = $ssid.'@'.$network_id;
                            $sele1_val =$ssid.'@'.$network_id;
                            array_push($existssid, $newssid);
                            $opt2 .= '<option selected value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';
                        }else{
                            if (!in_array($network_id, $arry_asign)) {
                                $opt2 .= '<option value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';
                            }

                        }

                    }

                    echo '</td><td> <input type="hidden" name="check2_update'.$i.'" class="check_update" id="check2_update'.$i.'" value="no"><select onchange="checkChange2('.$i.',\''.$sele1_val.'\',this);" class="span2" id="ap_ssid_id_'.$i.'" name="ap_ssid_id_'.$i.'">';
                    echo $opt2;
                    echo '</select></td>';

                    $opt3 = '';
                    foreach($resultnew3['data'] AS $row){
                        $theme_id=$row[theme_id];
                        $registration_type=$row[registration_type];
                        $distributor=$row[distributor];
                        $template_name=$row[template_name];
                        $theme_name=$row[theme_name];
                        $sele2_val = "";
                        if ($theme_id==$theme_name_n) {
                            $theme_id_N=$theme_id;
                            $old_title=$row[title];
                            $sele2_val = $theme_id;
                            $opt3 .= '<option selected value="'.$theme_id.'" data-regtype="'.$registration_type.'" data-dist="'.$distributor.'" data-template="'.$template_name.'">'.$theme_name.'</option>';
                        }else{
                            $opt3 .= '<option value="'.$theme_id.'" data-regtype="'.$registration_type.'" data-dist="'.$distributor.'" data-template="'.$template_name.'">'.$theme_name.'</option>';
                        }
                    }
                    echo '<td><input type="hidden" name="check3_update'.$i.'" class="check_update" id="check3_update'.$i.'" value="no"><select onchange="checkChange3('.$i.',\''.$sele2_val.'\',this);" class="span2" id="splash_theme_id_'.$i.'" name="splash_theme_id_'.$i.'"><option value="">Select Splash Page</option>';
                    echo $opt3;
                    echo '</select><button style="margin-left:7px;" type="submit" name="save_new_tag" id="save_new_tag'.$i.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Update</button>';
                    echo '
                                                                          <script type="text/javascript">
                                                                    $(document).ready(function() {
                                                                $(\'#save_new_tag' . $i . '\').easyconfirm({locale: {
                                                                      title: \'Update Theme Group\',
                                                                      text: \'Are you sure you want to Update?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                      button: [\'Cancel\',\' Confirm\'],
                                                                      closeText: \'close\'
                                                                       }});    
                                                              $(\'#save_new_tag' . $i . '\').click(function(e) {
                                                                var ap_ssid_id = document.getElementById("ap_ssid_id_"+' . $i . ').value;
                                                                  if (ap_ssid_id =="") {
                                                                    testNEW();
                                                                    e.preventDefault();
                                                                  }else{

                                                                    go(\''.$i.'\');
                                                                  }
                                                              });
                                                              });
                                                            </script>                                                             
                                                              </td>';


                    /* echo '<td >';
                         echo '<a name="edit_theme" id="edit_theme_'.$i.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Edit</a>';

                     echo    '

                                 <script type="text/javascript">
                                 $(document).ready(function() {

                                         $(\'#edit_theme_'.$i.'\').easyconfirm({locale: {
                                         title: \'Edit Theme\',
                                         text: \'Are you sure you want to edit this theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                         button: [\'Cancel\',\' Confirm\'],
                                         closeText: \'close\'
                                             }});
                                     $(\'#edit_theme_'.$i.'\').click(function() {
                                       var theme = $(\'#splash_theme_id_'.$i.'\').val();
                                       window.location = "?token=' . $secretn . '&t=createTheme&modify_s=1&id="+theme+"&property_id='. $property_id .'&lan=en'.'"
                                         });
                                         });
                                     </script></td>';*/







                    ////////////////////////////////



                    echo '<td >';
                    echo '<a target="_blank" onclick="previewn(\''.$i.'\');" type="button" id="preview_theme_'.$i.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Preview</a></td>';


                    echo '<td><button type="submit" name="remove_group" id="remove_group_'.$i.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Remove</button>';

                    echo '
                            <script type="text/javascript">
                            $(document).ready(function() {
              $(\'#remove_group_' . $i . '\').easyconfirm({locale: {
                  title: \'Remove Theme Group\',
                  text: \'Are you sure you want to Remove?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                  button: [\'Cancel\',\' Confirm\'],
                  closeText: \'close\'
                   }});
                $(\'#remove_group_' . $i . '\').click(function() {
                });
                });
              </script></td>';

                    //echo '</td>';

                    ///////////////////////////////

                    echo '<input type="hidden" name="form_secret" id="form_secret'.$i.'" value="' . $_SESSION['FORM_SECRET_N'] . '" />';
                    echo '<input type="hidden" name="id_new'.$i.'" id="id_new'.$i.'" value="' . $id_new . '" />';
                    echo '<input type="hidden" name="theme_type" id="theme_type'.$i.'" value="new" />';
                    echo '<input type="hidden" name="row_number" id="row_number'.$i.'" value="' . $i . '" />';
                    echo '<input type="hidden" name="old_ap_group_id_'.$i.'" id="old_ap_group_id_'.$i.'" value="' . $ap_group_id . '" />';
                    echo '<input type="hidden" name="old_network_id'.$i.'" id="old_network_id'.$i.'" value="' . $ssid_network . '" />';
                    echo '<input type="hidden" name="old_group_tag'.$i.'" id="old_group_tag'.$i.'" value="' . $group_tag . '" />';
                    echo '<input type="hidden" name="old_theme_id'.$i.'" id="old_theme_id'.$i.'" value="' . $theme_id_N . '" />';
                    echo '<input type="hidden" name="old_title'.$i.'" id="old_title'.$i.'" value="' . $old_title . '" />';

                    //////////////////////////////////
                    ?>
                    <script type="text/javascript">
                        function testNEW(elm){
                            //console.log(elm.id);
                            $('#ap_id').empty();
                            $('#ap_id').append('Please Select SSID');
                            $('#servicearr-check-div').show();
                            $('#sess-front-div').show();

                        }

                        function go(i){
                            //document.getElementById("save_new_tag"+i).disabled = true;
                            //elm.disabled = true;
                            $("img[data-ref='save_new_tag"+i+"']").show();

                        }
                        function previewn(i){
                            /*                                                                var theme_id = $('#splash_theme_id_'+i).val();*/
                            var theme_id=document.getElementById("old_theme_id"+i).value;
                            var theme_type=document.getElementById("theme_type"+i).value;
                            var title=document.getElementById("old_title"+i).value;
                            var theme_ssid=document.getElementById("ap_ssid_id_"+i).value;
                            var ap_ssid_json = '<?php echo json_encode($ap_arr); ?>';

                            var ap_ssid_arr = JSON.parse(ap_ssid_json);
                            var ap_ssid = ap_ssid_arr[$('#ap_group_id_'+i).val()];
                            var mac = "DEMO_MAC";
                            var group = "<?php echo $db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1"); ?>";
                            var ipp = "10.1.1.45";

                            var mac_parameter="<?php echo $mac_parameter; ?>";
                            var ap_parameter="<?php echo $ap_parameter; ?>";
                            var ssid_parameter="<?php echo $ssid_parameter; ?>";
                            var loc_string_parameter="<?php echo $loc_string_parameter; ?>";
                            var network_ses_parameter="<?php echo $network_ses_parameter; ?>";
                            var ip_parameter="<?php echo $ip_parameter; ?>";
                            var group_parameter="<?php echo $group_parameter; ?>";

                            loc = mac_parameter+"="+mac;

                            if(ap_parameter.length>1)
                                loc = loc+"&"+ap_parameter+"="+ap_ssid;
                            if(ssid_parameter.length>1) {
                                var ar = theme_ssid.split('@');
                                ar.pop();
                                //alert();
                                loc = loc + "&" + ssid_parameter + "=" + ar.join('@');
                            }
                            if(ip_parameter.length>1)
                                loc = loc+"&"+ip_parameter+"="+ipp;
                            // if(network_ses_parameter.length>1)
                            //     loc = loc+"&"+network_ses_parameter+"="+network_key;
                            if(group_parameter.length>1)
                                loc = loc+"&"+group_parameter+"="+group;
                            <?php
                            if($aaa_preview_version == 'ALE_V5'){
                                echo 'loc = loc+"&tenant=test";';
                            }
                            ?>
                            var url_base = '<?php echo $pageURL; ?>';
                            var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

                             if(theme_type=='new'){
                            loc = myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;
                                                                }
                                                                else if(theme_type=='return'){
                                                                loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;
                                                                }

                                                                window.open(loc,"_newtab");


                        }
                        function change_Ap(i,sele,now) {
                            //var x="<?php echo $i; ?>"
                            if(now.value==sele){
                                $('#check1_update'+i).val('no');
                            }else{
                                $('#check1_update'+i).val('yes');
                            }
                            var ap_group_id = document.getElementById("ap_group_id_"+i).value;
                            var scrt_var="scrt_ssid";
                            $("#ap_ssid_id_"+i).empty();
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/get_ap_ssid.php',
                                data: { ap_group_id: ap_group_id, ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,user_distributor:"<?php echo $user_distributor; ?>"},
                                success: function(data) {
                                    $("#ap_ssid_id_"+i).empty();

                                    $("#ap_ssid_id_"+i).append(data);


                                    //document.getElementById("zones_loader").innerHTML = "";

                                },
                                error: function(){
                                    //document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                }

                            });
                        }
                    </script>
                    <?php
                    echo '</form>';
                    echo '</tr>';


                    $i=$i+1;
                }
                /*if($guest_gateway=='AC'){
                    $availablessid =array();

                    foreach($resultnew2['data'] AS $row){
                        $ssid=$row[ssid];
                        $network_id=$row[network_id];
                        $newssid = $ssid.'@'.$network_id;
                        if (!in_array($newssid, $existssid)) {
                            array_push($availablessid, $row);
                        }
                    }
                    $resultnew2['data'] = $availablessid;
                }*/
                if ($a==0) {
                    echo '<tr>';
                    /*echo '<form id="theme_ap_form'.$i.'" name="theme_ap_form'.$i.'" method="post" action="theme?t=manage_SSID_splash">';*/
                    echo '<td>';
                    //if($guest_gateway!='AC'){
                        echo '<select class="span2" id="ap_group_id_' . $i . '" name="ap_group_id_' . $i . '">';
                        echo '<option value="all" >All AP Group</option>';
                        foreach ($resultnew['data'] as $row) {
                            $group_id = $row[group_id];
                            $group_name = $row[name];
                            echo '<option value="' . $group_id . '">' . $group_name . '</option>';


                        }
                        echo '</select>';

                    /*}else{
                        echo'<input value="All APs" type="text" readonly id="ap_group_id_' . $i . '" name="ap_group_id_' . $i . '">';
                    }*/
                    if ($resultnew['rowCount']>0) {
                    echo '<button style="margin-left:7px;" id="add_row" class="btn btn-primary btn-xs clone-button btn-add add_row" type="button"  >+</button>';
                }
                    echo '</td><td><select class="span2" id="ap_ssid_id_'.$i.'" name="ap_ssid_id_'.$i.'">';

                    foreach($resultnew2['data'] AS $row){
                        $ssid=$row[ssid];
                        $network_id=$row[network_id];

                        if ($ssid==$location_ssid) {
                            echo '<option selected value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';
                        }else{
                            echo '<option value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';
                        }

                    }
                    echo '</select></td>';
                    echo '<td><select class="span2" id="splash_theme_id_'.$i.'" name="splash_theme_id_'.$i.'"><option value="">Select Splash Page</option>';
                    foreach($resultnew3['data'] AS $row){
                        $theme_id=$row[theme_id];
                        $registration_type=$row[registration_type];
                        $distributor=$row[distributor];
                        $template_name=$row[template_name];
                        $theme_name=$row[theme_name];

                        echo '<option value="'.$theme_id.'" data-regtype="'.$registration_type.'" data-dist="'.$distributor.'" data-template="'.$template_name.'">'.$theme_name.'</option>';


                    }
                    echo '</select>';
                    //if($guest_gateway!='AC' && $resultnew['rowCount']<1){
                    if($resultnew['rowCount']<1){

                        echo '<button onclick="test(this);" id="save_new_tag'.$i.'" style="margin-left:7px;" type="button" class="btn btn-small btn-info td_btn_last disabled" disabled><i class="btn-icon-only icon-wrench"></i>Update</button><img style="display:none;" data-ref="save_new_tag'.$i.'"  src="img/loading_ajax.gif">';
                    }else{
                        echo '<button onclick="test(this);" id="save_new_tag'.$i.'" style="margin-left:7px;" type="button" class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Update</button><img style="display:none;" data-ref="save_new_tag'.$i.'"  src="img/loading_ajax.gif">';
                    }
                    /*echo '
                                  <script type="text/javascript">
                                  $(document).ready(function() {
                    $(\'#save_new_tag' . $i . '\').easyconfirm({locale: {
                        title: \'Update Theme Group\',
                        text: \'Are you sure you want to Update?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                        button: [\'Cancel\',\' Confirm\'],
                        closeText: \'close\'
                         }});
                      $(\'#save_new_tag' . $i . '\').click(function() {

                      });
                      });
                    </script>'; */
                    echo '</td>';

                    echo '<td><a class="btn btn-small btn-info td_btn_last disabled"><i class="btn-icon-only icon-wrench"></i> Preview</a></td>';

                    echo '<td><button style="margin-left:7px;" type="button" class="btn btn-small btn-info td_btn_last disabled"> Remove</button></td>';
                    echo '<input type="hidden" name="form_secret" id="form_secret'.$i.'" value="' . $_SESSION['FORM_SECRET_N'] . '" />';
                    echo '<input type="hidden" name="row_number" id="row_number'.$i.'" value="' . $i . '" />';
                    /*echo '</form>';*/
                    echo '</tr>';

                }
                $rowdata='<tr>';
                $rowdata.='<td>';
                //if($guest_gateway!='AC'){
                    $rowdata .= '<select class="span2" onchange="change_Ap_group(' . $i . ');" name="ap_group_id_' . $i . '" id="ap_group_id_' . $i . '">';

                    $rowdata .= '<option value="all">All AP Group</option>';
                    foreach ($resultnew['data'] as $row) {
                        $group_id = $row[group_id];
                        $group_name = str_replace("'","\'",$row[name]);
                        $rowdata .= '<option value="' . $group_id . '">' . $group_name . '</option>';

                    }
                    $rowdata .= '</select>';

                /*}else{
                    $rowdata .='<input value="All APs" type="text" readonly id="ap_group_id_' . $i . '" name="ap_group_id_' . $i . '">';
                }*/
                $rowdata.='<button style="margin-left:7px;" id="add_row" class="btn btn-primary btn-xs clone-button btn-add" type="button" onclick="add_row()">+</button>';
                $rowdata.='</td><td><select class="span2" id="ap_ssid_id_'.$i.'" name="ap_ssid_id_'.$i.'">';
                foreach($resultnew2['data'] AS $row){
                    $ssid=$row[ssid];
                    $network_id=$row[network_id];
                    $rowdata.='<option value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';

                }
                $rowdata.='</select></td>';
                $rowdata.='<td><select class="span2" id="splash_theme_id_'.$i.'" name="splash_theme_id_'.$i.'"><option value="">Select Splash Page</option>';
                foreach($resultnew3['data'] AS $row){
                    $theme_id=$row[theme_id];
                    $theme_name=$row[theme_name];
                    $rowdata.='<option value="'.$theme_id.'">'.$theme_name.'</option>';

                }
                $rowdata.='</select>';
                $rowdata.='<button style="margin-left:7px;" type="button"  onclick="test(this);" id="save_new_tag'.$i.'" class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Update</button><img style="display:none;" data-ref="save_new_tag'.$i.'"  src="img/loading_ajax.gif"></td>';
                $rowdata.='<td><a class="btn btn-small btn-info td_btn_last disabled"><i class="btn-icon-only icon-wrench"></i> Preview</a></td>';
                $rowdata.='<td><button style="margin-left:7px;" type="button" class="btn btn-small btn-info td_btn_last disabled"> Remove</button></td>';

                $rowdata.= '</tr>';
                ?>
                </tbody>
            </table>
            <script type="text/javascript">
                // $(document).ready(function() {
                // var x=<?php echo $i; ?>;
                // $("#save_new_tag"+ x).easyconfirm({
                //       locale: {

                //           title: 'Update Theme Group',

                //           text: 'Are you sure you want to Update',

                //           button: ['Cancel', ' Confirm'],

                //           closeText: 'close'

                //       }
                //   });
                //   $("#save_new_tag"+ x).click(function() {});
                //   });
            </script>
            </td>
            <script type="text/javascript">
                function test(elm){
                    //console.log(elm.id);
                    elm.disabled = true;
                    $("img[data-ref='"+elm.id+"']").show();

                    var x=<?php echo $i; ?>;
                    var ap_group_id = document.getElementById("ap_group_id_"+x).value;
                    var ap_ssid_id = document.getElementById("ap_ssid_id_"+x).value;
                    var splash_theme_id = document.getElementById("splash_theme_id_"+x).value;
                    if (ap_group_id =="") {
                        $('#ap_id').empty();
                        $('#ap_id').append('Please Select Ap Group');
                        $('#servicearr-check-div').show();
                        $('#sess-front-div').show();
                        //alert("Please Select Ap Group");
                        elm.disabled = false;
                        $("img[data-ref='"+elm.id+"']").hide();
                    }else if (ap_ssid_id =="") {
                        $('#ap_id').empty();
                        $('#ap_id').append('Please Select SSID');
                        $('#servicearr-check-div').show();
                        $('#sess-front-div').show();
                        //alert("Please Select SSID");
                        elm.disabled = false;
                        $("img[data-ref='"+elm.id+"']").hide();
                    }else if (splash_theme_id =="") {
                        $('#ap_id').empty();
                        $('#ap_id').append('Please Select Splash Page');
                        $('#servicearr-check-div').show();
                        $('#sess-front-div').show();
                        //alert("Please Select SSID");
                        elm.disabled = false;
                        $("img[data-ref='"+elm.id+"']").hide();
                    }else{
                        //alert(ap_ssid_id);
                        var splash_theme_id = document.getElementById("splash_theme_id_"+x).value;
                        //console.log(ap_ssid_id);
                        var zone_id = '<?php echo $zone_id; ?>';

                        var scrt_var="create";
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/get_ap_ssid.php',
                            data: { ap_group_id: ap_group_id,ap_ssid_id: ap_ssid_id,zone_id: zone_id,splash_theme_id: splash_theme_id, ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,user_distributor:"<?php echo $user_distributor; ?>"},
                            success: function(data) {
                                window.location = "?t=manage_SSID_splash";
                            },
                            error: function(){
                                elm.disabled = false;
                                $("img[data-ref='"+elm.id+"']").hide();
                            }

                        });
                    }

                }
                function change_Ap_group(i) {
                    var x=<?php echo $i; ?>;
                    $("#ap_ssid_id_"+i).empty();
                    var ap_group_id = document.getElementById("ap_group_id_"+x).value;
                    var scrt_var="scrt_ssid";
                    $.ajax({
                        type: 'POST',
                        url: 'ajax/get_ap_ssid.php',
                        data: { ap_group_id: ap_group_id, ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,user_distributor:"<?php echo $user_distributor; ?>"},
                        success: function(data) {
                            $("#ap_ssid_id_"+x).empty();

                            $("#ap_ssid_id_"+x).append(data);


                            //document.getElementById("zones_loader").innerHTML = "";

                        },
                        error: function(){
                            //document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                        }

                    });
                }


                $(".add_row").on('click',function(){
                    $('.check_update').val('yes');
                    var elem = document.getElementById('add_row');
                    elem.parentNode.removeChild(elem);
                    var row='<?php echo $rowdata; ?>';
                    $('#group_tag_table').append(row);
                    new Tablesaw.Table("#group_tag_table").destroy();
                    Tablesaw.init();
                    $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;''></label>");

                });

                function add_row(){
                    $('.check_update').val('yes');
                    var elem = document.getElementById('add_row');
                    elem.parentNode.removeChild(elem);
                    var row='<?php echo $rowdata; ?>';
                    $('#group_tag_table').append(row);
                    new Tablesaw.Table("#group_tag_table").destroy();
                    Tablesaw.init();
                    $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;''></label>");

                }
            </script>
        </div>
    </div>
</div>
