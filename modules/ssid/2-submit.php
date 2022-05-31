<?php
require_once __DIR__.'/../../models/User_model.php';
require_once __DIR__.'/../../src/AP/apClass.php';
require_once __DIR__.'/../../classes/messageClass.php';
require_once __DIR__.'/../../classes/logClass.php';
require_once __DIR__.'/../../classes/dbClass.php';

$db = new db_functions();
$global_base_url = trim($db->setVal('global_url','ADMIN'),"/");

$create_log=new logs('network',$user_name);
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);*/
$user = User_model::getInstance()->getUser();
$message_functions = new message_functions($user->system_package);
if(isset($_GET['ssid_broadcast']) && $_SESSION['guestnet_tab_1_MOD_SECRET']==$_GET['secret']){
    $sel_network_id= $_GET['network_id'];
    $sel_ssid= $_GET['ssid'];
    $ssid_broadcast = $_GET['status']=='1'?'AlwaysOn':'AlwaysOff';

    $ap = new apClass();
    $wag_obj = $ap->getControllerInst();
    $zone_id = $ap->getZoneId();
    //$zone_id=$db->getValueAsf("SELECT `zone_id` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
    $private_modify_sche=$wag_obj->modifySchedule($zone_id,$sel_network_id,$ssid_broadcast,"","");



    parse_str($private_modify_sche,$private_modify_sche_res);

    if($private_modify_sche_res['status_code']=='200'){


        $selq3="INSERT INTO `exp_distributor_network_schedul_assign_archive`
		(`id`,`ssid_broadcast`, `shedule_uniqu_id`, `network_id` ,`ssid` ,`distributor`, `network_method`, `create_date`, `create_user`,`last_update`)
		SELECT * FROM `exp_distributor_network_schedul_assign` WHERE network_id='$sel_network_id' AND `distributor`='$user->user_distributor'";
        $query_results3=$db->execDB($selq3);


        /*$selq4="UPDATE `exp_distributor_network_schedul_assign`
                SET `ssid_broadcast`='$ssid_broadcast'
                WHERE `network_id`='$sel_network_id' AND `distributor`='$user->user_distributor'";*/
        $selq4="INSERT INTO `exp_distributor_network_schedul_assign` (`ssid`,`ssid_broadcast`, `shedule_uniqu_id`, `network_id`, `distributor`, `network_method`, `create_date`, `create_user`)
              VALUES ('$sel_ssid','$ssid_broadcast', '', '$sel_network_id', '$user->user_distributor', 'GUEST', NOW(), '$user->user_distributor') ON DUPLICATE KEY UPDATE 
              ssid_broadcast='$ssid_broadcast'";

        $query_results4=$db->execDB($selq4);

        //$num_rows = mysql_num_rows($query_results4);
        if($query_results4 === true) {

            /*  $selq5 = "INSERT INTO `exp_distributor_network_schedul_assign` (`ssid`,`ssid_broadcast`, `shedule_uniqu_id`, `network_id`, `distributor`, `network_method`, `create_date`, `create_user`)
              VALUES ('$sel_ssid','$ssid_broadcast', '$sel_schedule_id', '$sel_network_id', '$user_distributor', 'GUEST', 'NOW()', '$user_name')";
              $query_results5 = mysql_query($selq5);
  */

            //$db->userErrorLog('2009', $user_name, 'script - ' . $script);
            $message=$message_functions->showMessage('ssid_enable_update_success');
            $create_log->save('3002',$message,$private_modify_sche);
            $_SESSION['tab7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

        }else{
            $message=$message_functions->showMessage('ssid_enable_update_fail','2002');
            $create_log->save('2002',$message,$selq4);
            $_SESSION['tab7']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

        }

    }else{

        $message=$message_functions->showMessage('ssid_enable_update_fail','2009');
        $create_log->save('2009',$message,$private_modify_sche);
        $_SESSION['tab7']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";


    }

    header("Location: ".$global_base_url."/network".$extension."?t=guestnet_tab_1");
    exit();
}

elseif (isset($_GET['enable_p_schedule'])){
    $network_id = $_GET['network_id'];

    $ssid_broadcast = $db->getValueAsf("SELECT shedule_uniqu_id as f FROM exp_distributor_network_schedul_assign WHERE distributor='$user->user_distributor' AND network_id='$network_id'");

    $ap = new apClass();
    $wag_obj = $ap->getControllerInst();
    $zone_id = $ap->getZoneId();

    $active_schedule_name=$db->getValueAsf("SELECT s.uniqu_name AS f  FROM exp_distributor_network_schedul s
                          WHERE s.uniqu_id='$ssid_broadcast' AND s.distributor_id='$user->user_distributor' GROUP BY s.uniqu_name");
    $private_modify_sche=$wag_obj->modifySchedule($zone_id,$network_id,'Customized',$ssid_broadcast,$active_schedule_name);

    parse_str($private_modify_sche,$private_modify_sche_res);

    if($private_modify_sche_res['status_code']=='200'){
        $selq3="INSERT INTO `exp_distributor_network_schedul_assign_archive`
		(`id`,`ssid_broadcast`, `shedule_uniqu_id`, `network_id` ,`ssid` ,`distributor`, `network_method`, `create_date`, `create_user`,`last_update`)
		SELECT * FROM `exp_distributor_network_schedul_assign` WHERE network_id='$network_id' AND `distributor`='$user->user_distributor'";
        $query_results3=$db->execDB($selq3);


        $selq4="UPDATE `exp_distributor_network_schedul_assign`
                SET `ssid_broadcast`='Customized'
                WHERE `network_id`='$network_id' AND `distributor`='$user->user_distributor'";
        $query_results4=$db->execDB($selq4);

        //$num_rows = mysql_num_rows($query_results4);
        if($query_results4 === true) {


            $message=$message_functions->showMessage('ssid_enable_update_success');
            $create_log->save('3002',$message,$private_modify_sche);
            $_SESSION['tab7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

        }else{
            $message=$message_functions->showMessage('ssid_enable_update_fail','2002');
            $create_log->save('2002',$message,$selq4);
            $_SESSION['tab7']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

        }
    }else{

        $message=$message_functions->showMessage('ssid_enable_update_fail','2009');
        $create_log->save('2009',$message,$private_modify_sche);
        $_SESSION['tab7']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
    }

    header("Location: ".$global_base_url."/network".$extension."?t=guestnet_tab_1");
    exit();
}
else{
    header("Location: ".$global_base_url."/network".$extension);
    exit();
}