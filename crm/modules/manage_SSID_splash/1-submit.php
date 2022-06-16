<?php
//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);
 session_start();

require_once __DIR__.'/../../classes/systemPackageClass.php';
require_once __DIR__.'/../../classes/dbClass.php';
require_once __DIR__.'/../../models/userMainModel.php';
require_once __DIR__.'/../../src/AP/apClass.php';
require_once __DIR__.'/../../classes/messageClass.php';

function ACUse($user_distributor,$db,$ssid,$tm_name,$user_name){
    //Get all tags for related ssid
    $all_tags_q = "SELECT group_tag FROM exp_locations_ap_ssid WHERE distributor='$user_distributor' AND location_ssid='$ssid'";
    $all_tags = $db->selectDB($all_tags_q);
    foreach ($all_tags['data'] as $all_tag){
        $q = "INSERT INTO `exp_mno_distributor_group_tag` (
                    `tag_name`,
                    `distributor`,
                    `theme_name`,
                    `create_date`,
                    `create_user`,
                    `last_update`)
                     VALUES ('$all_tag[group_tag]','$user_distributor','$tm_name',NOW(),'$user_name',NOW())
                     ON DUPLICATE KEY UPDATE 
                    theme_name='$tm_name',
                    create_user='$user_name',
                    last_update=NOW()";
        $db->execDB($q);
    }
}

$db = new db_functions();
$user_model = User_model::getInstance()->getUser();
$user_distributor= $user_model->user_distributor;
$user_name = $user_model->user_name;
$system_package = $user_model->system_package;
$ob = new apClass();
$message_functions=new message_functions($system_package);


$ap_q1="SELECT `ap_controller`,zone_id
FROM `exp_mno_distributor`
WHERE `distributor_code`='$user_distributor'
LIMIT 1";

$query_results_ap=$db->select1DB($ap_q1);

$ack = $query_results_ap['ap_controller'];
$zone_id = $query_results_ap['zone_id'];

//$ap_q2="SELECT `api_profile`
//FROM `exp_locations_ap_controller`
//WHERE `controller_name`='$ack'
//LIMIT 1";
//
//$query_results_ap2=$db->selectDB($ap_q2);

// foreach ($query_results_ap2['data'] AS $row) {
//     $wag_ap_name2 = $row['api_profile'];
// }
// //  $wag_ap_name='NO_PROFILE';
// if($wag_ap_name!='NO_PROFILE'){

//     include_once 'src/AP/' . $wag_ap_name2 . '/index.php';
//     if($wag_ap_name2==""){
//         include_once 'src/AP/' . $wag_ap_name . '/index.php';
//     }

//     $wag_obj = new ap_wag($ack);

// }

$wag_obj = $ob->getControllerInst();

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
$a="SELECT  verification_number, gateway_type FROM exp_mno_distributor WHERE distributor_code ='$user_distributor'";
//$a="SELECT  `group_number` AS f FROM `exp_distributor_groups` WHERE `distributor`='$user_distributor'";
$user_dist_details = $db->select1DB($a);
$realm=$user_dist_details['verification_number'];
$gateway_type=$user_dist_details['gateway_type'];

//echo $message_functions->showNameMessage('ssid_group_tag_save_success',$mod_ssid);

if(isset($_POST['save_new_tag'])){ 

    if(/*$_POST['form_secret'] == $_SESSION['FORM_SECRET_N']*/true){
    	$rownumber= $_POST['row_number'];
        $id_new=$_POST['id_new'.$rownumber];
    	$ap_group_id=$_POST['ap_group_id_'.$rownumber];
        $defaultGroup = false;
        if($ap_group_id=='All APs'){
            $getDefAPGId = "SELECT group_id as f from exp_distributor_ap_group where distributor='$user_distributor' and `name`='default'";
            $ap_group_id = $db->getValueAsf($getDefAPGId);

            $defaultGroup = true;
        }
    	$ssidarr=explode('@', $_POST['ap_ssid_id_'.$rownumber]);

    	$network_id=$ssidarr['1'];
        $ssid=$ssidarr['0'];
    	$theme_id = $_POST['splash_theme_id_'.$rownumber];
        /*$ap_group_id = $_GET['group_id'];
        $ssid = $_GET['ssid'];
        $network_id = $_GET['network_id'];
        $theme_id = $_GET['theme_id'];*/
        if (strlen($_POST['ap_ssid_id_'.$rownumber])<1) {
            header("Location: ../../theme?t=manage_SSID_splash&save_new_tag=500");
        }
        else{

        $old_group_tag=$_POST['old_group_tag'.$rownumber];
        $old_ap_group_id=$_POST['old_ap_group_id_'.$rownumber];
            if($old_ap_group_id=='All APs'){
                $getDefAPGId = "SELECT group_id as f from exp_distributor_ap_group where distributor='$user_distributor' and `name`='default'";
                $old_ap_group_id = $db->getValueAsf($getDefAPGId);
                //$ap_group_id = $defAPGId;
            }

        $old_network_id=$_POST['old_network_id'.$rownumber];

        $group_tag_new=$old_group_tag;
        if (($ap_group_id != $old_ap_group_id || $network_id != $old_network_id) && !$defaultGroup) {
            $getApgroup = $wag_obj->getAPGroup($zone_id, $ap_group_id);
            $details = $getApgroup['data'];

            if (strlen($id_new) < 1) {
                //$group_tag=uniqid();
                $group_tag = $details['name'] . '-' . uniqid();
            } else {

                $group_tag = $db->getValueAsf("SELECT `name` AS f FROM `exp_distributor_wlan_group` WHERE `w_group_id` = '$ap_group_id'");

                if (empty($group_tag)) {
                    $group_tag = $details['name'] . '-' . uniqid();
                }


                $getApgroupo = $wag_obj->getAPGroup($zone_id, $old_ap_group_id);
                $detailso = $getApgroupo['data'];
                $wGroupIdd = $detailso['wlanGroup24']['id'];

                $removessid = $wag_obj->removeMemberFromWLanGroups($zone_id, $wGroupIdd, $old_network_id);

                $queryr = "DELETE FROM `exp_distributor_wlan_group_ssid` WHERE `ap_group_id` = '$old_ap_group_id' AND `network_id`='$old_network_id' AND `distributor`='$user_distributor'";
                $ex1 = $db->execDB($queryr);

                $queryd = "DELETE FROM `exp_mno_distributor_group_tag` WHERE `tag_name` = '$group_tag'";
                $ex = $db->execDB($queryd);

                $queryap_ssid = "UPDATE exp_locations_ap_ssid aps JOIN exp_locations_ap lap ON aps.ap_id=lap.ap_code SET aps.group_tag = '$realm' WHERE lap.ap_group_id='$old_ap_group_id'";
                $db->execDB($queryap_ssid);
            }


            if ((empty($details['wlanGroup24']) && empty($details['wlanGroup50'])) || ($details['wlanGroup24']['name'] == 'default' && $details['wlanGroup50']['name'] == 'default')) {

                $create_WL_Group = $wag_obj->creatWLanGroups($zone_id, $group_tag);
                $wGroupId = $create_WL_Group['data']['id'];
                $wGroupName = $create_WL_Group['data']['name'];
                $querygr = "INSERT INTO `exp_distributor_wlan_group` (
              `w_group_id`,
              `name`,
              `description`,
              `distributor`,
              `create_date`,
              `create_user`)
               VALUES ('$wGroupId','$wGroupName','','$user_distributor',NOW(),'$user_name')";
                $exg = $db->execDB($querygr);
                $wag_obj->modifyWLanGroup24($zone_id, $ap_group_id, $wGroupId, $group_tag);
                $wag_obj->modifyWLanGroup50($zone_id, $ap_group_id, $wGroupId, $group_tag);
            } else {
                $wGroupId = $details['wlanGroup50']['id'];
                $wGroupName = $details['wlanGroup50']['name'];
                $group_tag = $wGroupName;
            }

            $ad_member = $wag_obj->addMemberToWLanGroups($zone_id, $wGroupId, $network_id);
            if($create_WL_Group['status']===true){
                $get_resi_ssid_q = "SELECT `network_id` FROM `exp_locations_ssid_vtenant` WHERE distributor='$user_distributor'";
                $resi_ssids = $db->selectDB($get_resi_ssid_q);

                foreach ($resi_ssids['data'] as $resi_ssid) {
                    $test->addMemberToWLanGroups($zone_id, $wGroupId, $resi_ssid['network_id']);
                }
            }
            if ($ad_member['status_code'] == 200 || $ad_member['status_code'] == 403) {

                $querys = "SELECT `ap_code` FROM `exp_locations_ap` WHERE `ap_group_id`='$ap_group_id'";
                $result2 = $db->selectDB($querys);
                foreach ($result2['data'] AS $row) {
                    $ap_id = $row['ap_code'];
                    $query = "INSERT INTO `exp_locations_ap_ssid` (
			  `ap_id`,
			  `network_id`,
			  `location_ssid`,
			  `group_tag`,
			  `distributor`,
			  `distributor_type`)
			   VALUES ('$ap_id','$network_id','$ssid','$group_tag_new','$user_distributor','MVNO')
			   ON DUPLICATE KEY UPDATE 
			   ap_id='$ap_id',
              network_id='$network_id',
              location_ssid='$ssid',
              group_tag='$group_tag_new',
              distributor='$user_distributor',
              distributor_type='MVNO'";
                    $ex0 = $db->execDB($query);

                }
                $theme_id_arr = array('en' => $theme_id);
                $theme_json = json_encode($theme_id_arr);

                $queryt = "INSERT INTO `exp_mno_distributor_group_tag` (
			  `tag_name`,
			  `distributor`,
			  `theme_name`,
			  `create_date`,
			  `create_user`,
			  `last_update`)
			   VALUES ('$group_tag_new','$user_distributor','$theme_json',NOW(),'$user_name',NOW())
               ON DUPLICATE KEY UPDATE 
               tag_name='$group_tag_new',
              distributor='$user_distributor',
              theme_name='$theme_json',
              create_date=NOW(),
              create_user='$user_name',
              last_update=NOW()";
                $ex = $db->execDB($queryt);
                if($gateway_type=='AC'){
                    ACUse($user_distributor,$db,$ssid,$theme_json,$user_name);
                }


                $queryr = "INSERT INTO `exp_distributor_wlan_group_ssid` (
              `wlan_group_id`,
              `network_id`,
              `ssid`,
              `group_tag`,
              `ap_group_id`,
              `distributor`,
              `create_date`,
              `create_user`)
               VALUES ('$wGroupId','$network_id','$ssid','$group_tag_new','$ap_group_id','$user_distributor',NOW(),'$user_name')
               ON DUPLICATE KEY UPDATE 
               wlan_group_id='$wGroupId',
              network_id='$network_id',
              ssid='$ssid',
              group_tag='$group_tag_new',
              ap_group_id='$ap_group_id',
              distributor='$user_distributor',
              create_date=NOW(),
              create_user='$user_name'";
                $ex2 = $db->execDB($queryr);

            }

        }
        else{
            $tm_name = json_encode(["en"=>$theme_id]);
            $check_theme = "SELECT `theme_name` FROM `exp_mno_distributor_group_tag` WHERE tag_name = '$old_group_tag'";

            if($db->getNumRows($check_theme)>0){
            $q = "UPDATE exp_mno_distributor_group_tag SET theme_name='$tm_name' WHERE tag_name = '$old_group_tag'";

            }else{
                $q = "INSERT INTO `exp_mno_distributor_group_tag` (
                    `tag_name`,
                    `distributor`,
                    `theme_name`,
                    `create_date`,
                    `create_user`,
                    `last_update`)
                     VALUES ('$old_group_tag','$user_distributor','$tm_name',NOW(),'$user_name',NOW())
                     ON DUPLICATE KEY UPDATE 
                     tag_name='$old_group_tag',
                    distributor='$user_distributor',
                    theme_name='$tm_name',
                    create_date=NOW(),
                    create_user='$user_name',
                    last_update=NOW()";
            }

            if($gateway_type=='AC'){
                ACUse($user_distributor,$db,$ssid,$tm_name,$user_name);
            }

            $ex = $db->execDB($q);

            if($network_id != $old_network_id){
                //$realm
                $q2 = "update exp_locations_ap_ssid apssid
                            set apssid.group_tag='$realm'
                        where apssid.network_id='$old_network_id' and apssid.distributor='$user_distributor'";
                $ex21 = $db->execDB($q2);
                $q3 = "update exp_locations_ap_ssid apssid
                            set apssid.group_tag='$old_group_tag'
                        where apssid.network_id='$network_id' and apssid.distributor='$user_distributor'";
                $ex22 = $db->execDB($q3);
                if($ex21==true && $ex22==true){
                    $ex2 = true;
                }
            }else{
                $ex2 = true;
            }
        }

        $active_tab = 'manage_SSID_splash';
        if ($ex && $ex2) {
        	//$db->userLog($user_name,$script,'Guest SSID Update',$mod_ssid);
				
				$_SESSION['manage_SSID_splash'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showNameMessage('ssid_group_tag_save_success',$mod_ssid)."</strong></div>";
        header("Location: ../../theme?t=manage_SSID_splash&save_new_tag=200");
        exit();
      
      } else {


				$db->userErrorLog('2002', $user_name, 'script - ' . $script);

				$_SESSION['manage_SSID_splash'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showNameMessage('ssid_group_tag_save_failed',$mod_ssid,'2002')."</strong></div>";
       
        header("Location: ../../theme?t=manage_SSID_splash&save_new_tag=500");
			}

}
    }else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $active_tab = "manage_SSID_splash";

        $_SESSION['manage_SSID_splash']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

                 <strong> [2004] Transaction has failed</strong></div>";

        header("Location: ../../theme?t=manage_SSID_splash&save_new_tag=500");


    }

}
if(isset($_POST['remove_group'])){

    if($_POST['form_secret'] == $_SESSION['FORM_SECRET_N']){

        $rownumber= $_POST['row_number'];
        $ap_group_id=$_POST['ap_group_id_'.$rownumber];
        $defaultGroup = false;
        if($ap_group_id=='All APs'){
            $getDefAPGId = "SELECT group_id as f from exp_distributor_ap_group where distributor='$user_distributor' and `name`='default'";
            $ap_group_id = $db->getValueAsf($getDefAPGId);
            //$ap_group_id = $defAPGId;
            $defaultGroup = true;
        }

        $ssidarr=explode('@', $_POST['ap_ssid_id_'.$rownumber]);

        $network_id=$ssidarr['1'];
        $ssid=$ssidarr['0'];
        $theme_id = $_POST['splash_theme_id_'.$rownumber];


        ///start
        if(!$defaultGroup){
            $getApgroup = $wag_obj->getAPGroup($zone_id, $ap_group_id);
            $details = $getApgroup['data'];
            $wGroupId = $details['wlanGroup24']['id'];

            $getwlan = $wag_obj->getWLanGroup($zone_id, $wGroupId);
            $wlan_group_data = $getwlan['data'];

            $members_arr = $wlan_group_data['members'];
            $arr_count = count($members_arr);

            $removessid = $wag_obj->removeMemberFromWLanGroups($zone_id, $wGroupId, $network_id);
            $x = false;
            if ($arr_count < 2) {
                $x = true;

            }else{

                $vsz_net_ids = [];
                $local_net_ids = [];
                foreach ($members_arr as $member){
                    if($member['id']==$network_id)
                        continue;

                    $vsz_net_ids[]=$member['id'];
                }

                $get_resi_ssid_q = "SELECT `network_id` FROM `exp_locations_ssid_vtenant` WHERE distributor='$user_distributor'";
                $resi_ssids = $db->selectDB($get_resi_ssid_q);

                foreach ($resi_ssids['data'] as $resi_ssid){
                    $local_net_ids[]=$resi_ssid['network_id'];
                }

                sort($vsz_net_ids);
                sort($local_net_ids);
                if($vsz_net_ids==$local_net_ids){
                    $x = true;
                    foreach ($vsz_net_ids as $vsz_net_id){
                        $wag_obj->removeMemberFromWLanGroups($zone_id, $wGroupId, $vsz_net_id);
                    }
                }

            }
            if($x===true){
                $querys = "SELECT `w_group_id` AS f FROM `exp_distributor_wlan_group` WHERE `distributor`='$user_distributor' AND `name`='default'";
                $w_group_idd = $db->getValueAsf($querys);

                $wag_obj->modifyWLanGroup24($zone_id, $ap_group_id, $w_group_idd, 'default');
                $wag_obj->modifyWLanGroup50($zone_id, $ap_group_id, $w_group_idd, 'default');
                $removewlgr = $wag_obj->removeWLanGroups($zone_id, $wGroupId);
            }
        }////end

        $querys="SELECT `ap_code` FROM `exp_locations_ap` WHERE `ap_group_id`='$ap_group_id'";
        $result2=$db->selectDB($querys);
        foreach($result2['data'] AS $row){
            $ap_id=$row['ap_code'];
            $query_ag = "UPDATE `exp_locations_ap_ssid` SET `group_tag` = '$realm' WHERE `ap_id`='$ap_id' AND location_ssid='$ssid'";
            $ex0 =$db->execDB($query_ag);

        }
        $group_tag=$_POST['old_group_tag'.$rownumber];

         if ($removessid[status_code]==200 || $removessid[status_code]==404) {
            $queryr="DELETE FROM `exp_distributor_wlan_group_ssid` WHERE `ap_group_id` = '$ap_group_id' AND `network_id`='$network_id' AND `distributor`='$user_distributor'";
            $ex1 =$db->execDB($queryr);
            if ($x===true) {
                $getwln=$db->getValueAsf("SELECT wlan_group_id AS f FROM exp_distributor_wlan_group_ssid WHERE `ap_group_id`='$ap_group_id'");
                $queryd="DELETE FROM `exp_distributor_wlan_group` WHERE `w_group_id` = '$getwln' AND `distributor`='$user_distributor'";
                $exd =$db->execDB($queryd);
            }
        }

        $queryd="DELETE FROM `exp_mno_distributor_group_tag` WHERE `tag_name` = '$group_tag'";
        $ex =$db->execDB($queryd);


        $active_tab = 'manage_SSID_splash';
        if ($ex===true) {
            $db->userLog($user_name,$script,'Guest Group tag Update',$mod_ssid);
            //server log

            $_SESSION['manage_SSID_splash'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showNameMessage('delete_group_tag_success',$mod_ssid)."</strong></div>";
            header("Location: ../../theme?t=manage_SSID_splash");
            exit();
        } else {


            $db->userErrorLog('2002', $user_name, 'script - ' . $script);

            $_SESSION['manage_SSID_splash'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showNameMessage('delete_group_tag_failed',$mod_ssid,'2002')."</strong></div>";
            header("Location: ../../theme?t=manage_SSID_splash");
            exit();
        }


    }else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $active_tab = "manage_SSID_splash";

        $_SESSION['manage_SSID_splash']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong> [2004] Transaction has failed</strong></div>";

        header("Location: ../../theme?t=manage_SSID_splash");
        exit();
    }

}
?>