<?php
require_once __DIR__.'/../../models/User_model.php';
require_once __DIR__.'/../../src/AP/apClass.php';
require_once __DIR__.'/../../classes/messageClass.php';
require_once __DIR__.'/../../classes/logClass.php';
require_once __DIR__.'/../../classes/dbClass.php';
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);*/
$db_class = new db_functions();
$global_base_url = trim($db_class->setVal('global_url','ADMIN'),"/");

$create_log=new logs('network',$user_name);

$user = User_model::getInstance()->getUser();
$ori_user = User_model::getInstance()->getOriginalUser();
$message_functions = new message_functions($user->system_package);


if(!function_exists('timeComvert')) {
    function timeComvert($from, $to, $time_start, $time_end, &$data_array, $day)
    {

        if ($from == $to) {
            array_push($data_array[$day], $time_start . '-' . $time_end);
            return;
        }

        //echo "no return";
        $dt1 = new DateTime($time_start, new DateTimeZone($from));
        $dt1->setTimezone(new DateTimeZone($to));
        $start = $dt1->format('Y-m-d/H:i');
        $dt2 = new DateTime($time_end, new DateTimeZone($from));
        $dt2->setTimezone(new DateTimeZone($to));
        $end = $dt2->format('Y-m-d/H:i');

        $values = setRange($start, $end);
        $values_ar = explode('/', $values);
        switch ($day) {
            case "mon": {
                //echo count($values_ar)."****";
                for ($i = 0; $i < count($values_ar); $i++) {
                    //echo $values_ar[$i];
                    $range = explode("@", $values_ar[$i]);
                    //print_r($range);
                    $rang_compare_r = explode("-", $range[1]);
                    if ($rang_compare_r[0] != $rang_compare_r[1]) {
                        switch ($range[0]) {
                            case "1": {
                                //echo $range[1];
                                array_push($data_array["sun"], $range[1]);
                                break;
                            }
                            case "2": {
                                //echo $range[1];
                                array_push($data_array["mon"], $range[1]);
                                break;
                            }
                            case "3": {
                                //echo $range[1];
                                array_push($data_array["tue"], $range[1]);
                                break;
                            }

                        }
                    }
                }
                break;
            }
            case "tue": {
                //echo count($values_ar)."****";
                for ($i = 0; $i < count($values_ar); $i++) {
                    //echo $values_ar[$i];
                    $range = explode("@", $values_ar[$i]);
                    //print_r($range);
                    $rang_compare_r = explode("-", $range[1]);
                    if ($rang_compare_r[0] != $rang_compare_r[1]) {
                        switch ($range[0]) {
                            case "1": {
                                //echo $range[1];
                                array_push($data_array["mon"], $range[1]);
                                break;
                            }
                            case "2": {
                                //echo $range[1];
                                array_push($data_array["tue"], $range[1]);
                                break;
                            }
                            case "3": {
                                //echo $range[1];
                                array_push($data_array["wed"], $range[1]);
                                break;
                            }

                        }
                    }
                }
                break;
            }
            case "wed": {
                //echo count($values_ar)."****";
                for ($i = 0; $i < count($values_ar); $i++) {
                    //echo $values_ar[$i];
                    $range = explode("@", $values_ar[$i]);
                    //print_r($range);
                    $rang_compare_r = explode("-", $range[1]);
                    if ($rang_compare_r[0] != $rang_compare_r[1]) {
                        switch ($range[0]) {
                            case "1": {
                                //echo $range[1];
                                array_push($data_array["tue"], $range[1]);
                                break;
                            }
                            case "2": {
                                //echo $range[1];
                                array_push($data_array["wed"], $range[1]);
                                break;
                            }
                            case "3": {
                                //echo $range[1];
                                array_push($data_array["thu"], $range[1]);
                                break;
                            }

                        }
                    }
                }
                break;
            }
            case "thu": {
                //echo count($values_ar)."****";
                for ($i = 0; $i < count($values_ar); $i++) {
                    //echo $values_ar[$i];
                    $range = explode("@", $values_ar[$i]);
                    //print_r($range);
                    $rang_compare_r = explode("-", $range[1]);
                    if ($rang_compare_r[0] != $rang_compare_r[1]) {
                        switch ($range[0]) {
                            case "1": {
                                //echo $range[1];
                                array_push($data_array["wed"], $range[1]);
                                break;
                            }
                            case "2": {
                                //echo $range[1];
                                array_push($data_array["thu"], $range[1]);
                                break;
                            }
                            case "3": {
                                //echo $range[1];
                                array_push($data_array["fri"], $range[1]);
                                break;
                            }

                        }
                    }
                }
                break;
            }
            case "fri": {
                //echo count($values_ar)."****";
                for ($i = 0; $i < count($values_ar); $i++) {
                    //echo $values_ar[$i];
                    $range = explode("@", $values_ar[$i]);
                    //print_r($range);
                    $rang_compare_r = explode("-", $range[1]);
                    if ($rang_compare_r[0] != $rang_compare_r[1]) {
                        switch ($range[0]) {
                            case "1": {
                                //echo $range[1];
                                array_push($data_array["thu"], $range[1]);
                                break;
                            }
                            case "2": {
                                //echo $range[1];
                                array_push($data_array["fri"], $range[1]);
                                break;
                            }
                            case "3": {
                                //echo $range[1];
                                array_push($data_array["sat"], $range[1]);
                                break;
                            }

                        }
                    }
                }
                break;
            }
            case "sat": {
                //echo count($values_ar)."****";
                for ($i = 0; $i < count($values_ar); $i++) {
                    //echo $values_ar[$i];
                    $range = explode("@", $values_ar[$i]);
                    //print_r($range);
                    $rang_compare_r = explode("-", $range[1]);
                    if ($rang_compare_r[0] != $rang_compare_r[1]) {
                        switch ($range[0]) {
                            case "1": {
                                //echo $range[1];
                                array_push($data_array["fri"], $range[1]);
                                break;
                            }
                            case "2": {
                                //echo $range[1];
                                array_push($data_array["sat"], $range[1]);
                                break;
                            }
                            case "3": {
                                //echo $range[1];
                                array_push($data_array["sun"], $range[1]);
                                break;
                            }

                        }
                    }
                }
                break;
            }
            case "sun": {
                //echo count($values_ar)."****";
                for ($i = 0; $i < count($values_ar); $i++) {
                    //echo $values_ar[$i];
                    $range = explode("@", $values_ar[$i]);
                    //print_r($range);
                    $rang_compare_r = explode("-", $range[1]);
                    if ($rang_compare_r[0] != $rang_compare_r[1]) {
                        switch ($range[0]) {
                            case "1": {
                                //echo $range[1];
                                array_push($data_array["sat"], $range[1]);
                                break;
                            }
                            case "2": {
                                //echo $range[1];
                                array_push($data_array["sun"], $range[1]);
                                break;
                            }
                            case "3": {
                                //echo $range[1];
                                array_push($data_array["mon"], $range[1]);
                                break;
                            }

                        }
                    }
                }
                break;
            }
        }
    }
}
if(!function_exists('setRange')) {
    function setRange($start, $end)
    {
        $today = DATE('Y-m-d');
        $start_ar = explode('/', $start);
        //print_r($start_ar);
        if (strtotime($start_ar[0]) < strtotime($today)) {
            $start_param = 'yesterday';
        } elseif (strtotime($start_ar[0]) > strtotime($today)) {
            $start_param = 'tomorrow';
        } else {
            $start_param = 'today';
        }


        $end_ar = explode('/', $end);
        //print_r($end_ar);
        if (strtotime($end_ar[0]) < strtotime($today)) {
            $end_param = 'yesterday';
        } elseif (strtotime($end_ar[0]) > strtotime($today)) {
            $end_param = 'tomorrow';
        } else {
            $end_param = 'today';
        }
        //echo "srart_par".$start_param;
        //echo "end_par".$end_param;
        switch (true) {
            case ($start_param == 'yesterday' and $end_param == 'yesterday'): {
                $result = "1@" . $start_ar[1] . "-" . $end_ar[1] . "@";
                break;
            }
            case ($start_param == 'yesterday' and $end_param == 'today'): {
                $result = $result = "1@" . $start_ar[1] . "-24:00@/2@00:00-" . $end_ar[1] . "@";
                break;
            }
            case ($start_param == 'today' and $end_param == 'today'): {
                $result = "2@" . $start_ar[1] . "-" . $end_ar[1] . "@";
                break;
            }
            case ($start_param == 'today' and $end_param == 'tomorrow'): {
                $result = "2@" . $start_ar[1] . "-24:00@/3@00:00-" . $end_ar[1] . "@";
                break;
            }
            case ($start_param == 'tomorrow' and $end_param == 'tomorrow'): {
                $result = "3@" . $start_ar[1] . "-" . $end_ar[1] . "@";
                break;
            }
        }
        //echo $result;
        return $result;
    }
}
if(!function_exists('getSliderPluginValues')) {
    function getSliderPluginValues($from1, $from2, $to1, $to2)
    {
        $return_ar = array('from' => 0, 'to' => 0);
        if ($from1 == '12' && $from2 == 'AM') {
            $return_ar['from'] = 0;
        } else {
            $return_ar['from'] = $from1 * 60;
        }

        if ($to1 == '12' && $to2 == 'AM') {
            $return_ar['to'] = 1439;
        } else {
            $return_ar['to'] = $from1 * 60;
        }

        return $return_ar;
    }
}
if(!function_exists('get_minutes')) {
    function get_minutes($time_string)
    {
        $parts = explode(":", $time_string);

        $hours = intval($parts[0]);
        $minutes = intval($parts[1]);

        return $hours * 60 + $minutes;
    }
}

if(isset($_POST['schedule_submit_mid'])) {

    $ap = new apClass();
    $wag_obj = $ap->getControllerInst();
    $zone_id = $ap->getZoneId();

    $schedule_name = $_POST['schedule_name'];
    $schedule_UUID = $_POST['schedule_UUID'];
    $WLanID = $_POST['WLanID'];
    $all = $_POST['all'];
    if ($ori_user->user_type!='SALES') {

        switch ($all) {
            case 'on': {

                parse_str($wag_obj->modifySchedule($zone_id, $WLanID, 'AlwaysOn','',''), $modify_sche_respo);

                if($modify_sche_respo['status_code']=='200'){
                    $db_class->userLog($user_name,$script,'Schedule AlwaysOn',$_SESSION['WLanSSID']);
                    $message=$message_functions->showMessage('schedule_update_success');
                    $create_log->save('3009',$message,$modify_sche_respo['Description']);
                    $_SESSION['tab9'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
                    $selq4="INSERT INTO exp_distributor_network_schedul_assign (`ssid_broadcast`,`network_id`,`distributor`) 
                    VALUES('AlwaysOn','$WLanID','$user->user_distributor') ON DUPLICATE KEY UPDATE
                    `ssid_broadcast`='AlwaysOn'";
                    $query_results4=$db_class->execDB($selq4);
                }else{
                    $message=$message_functions->showMessage('schedule_update_fail');
                    $create_log->save('2009',$message,$modify_sche_respo['Description']);
                    $_SESSION['tab9'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

                }

                break;
            }
            case 'off': {

                parse_str($wag_obj->modifySchedule($zone_id, $WLanID, 'AlwaysOff','',''), $modify_sche_respo);

                if($modify_sche_respo['status_code']=='200'){
                    $db_class->userLog($user_name,$script,'Schedule AlwaysOff',$_SESSION['WLanSSID']);
                    $message=$message_functions->showMessage('schedule_update_success');
                    $create_log->save('3009',$message,$modify_sche_respo['Description']);
                    $_SESSION['tab9'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
                    $selq4="INSERT INTO exp_distributor_network_schedul_assign (`ssid_broadcast`,`network_id`,`distributor`) 
                    VALUES('AlwaysOff','$WLanID','$user->user_distributor') ON DUPLICATE KEY UPDATE 
                    `ssid_broadcast`='AlwaysOff'";
                    $query_results4=$db_class->execDB($selq4);
                }else{
                    $message=$message_functions->showMessage('schedule_update_fail');
                    $create_log->save('2009',$message,$modify_sche_respo['Description']);
                    $_SESSION['tab9'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

                }

                break;
            }
            case 'custom': {

                $api_data_array = array("mon" => Array(), "tue" => Array(), "wed" => Array(), "thu" => Array(), "fri" => Array(), "sat" => Array(), "sun" => Array());
                //$api_data_array["name"] = $schedule_name;
                //$api_data_array["description"] = $schedule_name;

                $mon_all = $_POST['mon_all'];

                if ($_POST['mon_from2'] == 'PM') {

                    if (intval($_POST['mon_from1']) != 12) {
                        $_POST['mon_from1'] = intval($_POST['mon_from1']) + 12;
                    }
                } else {
                    if (intval($_POST['mon_from1']) == 12) {
                        $_POST['mon_from1'] = '00';
                    }
                }

                if ($_POST['mon_to2'] == 'PM') {

                    if (intval($_POST['mon_to1']) != 12) {
                        $_POST['mon_to1'] = intval($_POST['mon_to1']) + 12;
                    }
                } else {
                    if (intval($_POST['mon_to1']) == 12) {
                        $_POST['mon_to1'] = intval($_POST['mon_to1']) + 12;
                    }
                }


                $mon_from = $_POST['mon_from1'] . ":00";
                $mon_to = $_POST['mon_to1'] . ":00";
                if ($mon_all == "on") {
                    //Time Zone convert function
                    timeComvert($user->time_zone, $user->time_zone, '00:00', '24:00', $api_data_array, 'mon');

                    //$data_array["mon"] = array("00:00-24:00");
                } elseif ($mon_all == "off") {
                } else {
                    timeComvert($user->time_zone, $user->time_zone, $mon_from, $mon_to, $api_data_array, 'mon');
                }

                $tue_all = $_POST['tue_all'];

                if ($_POST['tue_from2'] == 'PM') {

                    if (intval($_POST['tue_from1']) != 12) {
                        $_POST['tue_from1'] = intval($_POST['tue_from1']) + 12;
                    }
                } else {
                    if (intval($_POST['tue_from1']) == 12) {
                        $_POST['tue_from1'] = '00';
                    }
                }
                if ($_POST['tue_to2'] == 'PM') {

                    if (intval($_POST['tue_to1']) != 12) {
                        $_POST['tue_to1'] = intval($_POST['tue_to1']) + 12;
                    }
                } else {
                    if (intval($_POST['tue_to1']) == 12) {
                        $_POST['tue_to1'] = intval($_POST['tue_to1']) + 12;
                    }
                }


                $tue_from = $_POST['tue_from1'] . ":00";
                $tue_to = $_POST['tue_to1'] . ":00";
                if ($tue_all == "on") {
                    //$api_data_array["tue"] = array("00:00-24:00");
                    timeComvert($user->time_zone, $user->time_zone, '00:00', '24:00', $api_data_array, 'tue');
                } elseif ($tue_all == "off") {
                } else {
                    timeComvert($user->time_zone, $user->time_zone, $tue_from, $tue_to, $api_data_array, 'tue');
                }

                $wed_all = $_POST['wed_all'];

                if ($_POST['wed_from2'] == 'PM') {

                    if (intval($_POST['wed_from1']) != 12) {
                        $_POST['wed_from1'] = intval($_POST['wed_from1']) + 12;
                    }
                } else {
                    if (intval($_POST['wed_from1']) == 12) {
                        $_POST['wed_from1'] = '00';
                    }
                }
                if ($_POST['wed_to2'] == 'PM') {

                    if (intval($_POST['wed_to1']) != 12) {
                        $_POST['wed_to1'] = intval($_POST['wed_to1']) + 12;
                    }
                } else {
                    if (intval($_POST['wed_to1']) == 12) {
                        $_POST['wed_to1'] = intval($_POST['wed_to1']) + 12;
                    }
                }


                $wed_from = $_POST['wed_from1'] . ":00";
                $wed_to = $_POST['wed_to1'] . ":00";
                if ($wed_all == "on") {
                    //$api_data_array["wed"] = array("00:00-24:00");
                    timeComvert($user->time_zone, $user->time_zone, '00:00', '24:00', $api_data_array, 'wed');
                } elseif ($wed_all == "off") {
                } else {
                    timeComvert($user->time_zone, $user->time_zone, $wed_from, $wed_to, $api_data_array, 'wed');
                }

                $thu_all = $_POST['thu_all'];

                if ($_POST['thu_from2'] == 'PM') {
                    if (intval($_POST['thu_from1']) != 12) {
                        $_POST['thu_from1'] = intval($_POST['thu_from1']) + 12;
                    }
                } else {
                    if (intval($_POST['thu_from1']) == 12) {
                        $_POST['thu_from1'] = '00';
                    }
                }
                if ($_POST['thu_to2'] == 'PM') {

                    if (intval($_POST['thu_to1']) != 12) {
                        $_POST['thu_to1'] = intval($_POST['thu_to1']) + 12;
                    }
                } else {
                    if (intval($_POST['thu_to1']) == 12) {
                        $_POST['thu_to1'] = intval($_POST['thu_to1']) + 12;
                    }
                }


                $thu_from = $_POST['thu_from1'] . ":00";
                $thu_to = $_POST['thu_to1'] . ":00";
                if ($thu_all == "on") {
                    //$api_data_array["thu"] = array("00:00-24:00");
                    timeComvert($user->time_zone, $user->time_zone, '00:00', '24:00', $api_data_array, 'thu');
                } elseif ($thu_all == "off") {
                } else {
                    timeComvert($user->time_zone, $user->time_zone, $thu_from, $thu_to, $api_data_array, 'thu');
                }

                $fri_all = $_POST['fri_all'];

                if ($_POST['fri_from2'] == 'PM') {

                    if (intval($_POST['fri_from1']) != 12) {
                        $_POST['fri_from1'] = intval($_POST['fri_from1']) + 12;
                    }
                } else {
                    if (intval($_POST['fri_from1']) == 12) {
                        $_POST['fri_from1'] = '00';
                    }
                }
                if ($_POST['fri_to2'] == 'PM') {
                    if (intval($_POST['fri_to1']) != 12) {
                        $_POST['fri_to1'] = intval($_POST['fri_to1']) + 12;
                    }
                } else {
                    if (intval($_POST['fri_to1']) == 12) {
                        $_POST['fri_to1'] = intval($_POST['fri_to1']) + 12;
                    }
                }


                $fri_from = $_POST['fri_from1'] . ":00";
                $fri_to = $_POST['fri_to1'] . ":00";
                if ($fri_all == "on") {
                    timeComvert($user->time_zone, $user->time_zone, '00:00', '24:00', $api_data_array, 'fri');
                    //$api_data_array["fri"] = array("00:00-24:00");
                } elseif ($fri_all == "off") {
                } else {
                    timeComvert($user->time_zone, $user->time_zone, $fri_from, $fri_to, $api_data_array, 'fri');
                }

                $sat_all = $_POST['sat_all'];

                if ($_POST['sat_from2'] == 'PM') {
                    if (intval($_POST['sat_from1']) != 12) {
                        $_POST['sat_from1'] = intval($_POST['sat_from1']) + 12;
                    }
                } else {
                    if (intval($_POST['sat_from1']) == 12) {
                        $_POST['sat_from1'] = '00';
                    }
                }
                if ($_POST['sat_to2'] == 'PM') {

                    if (intval($_POST['sat_to1']) != 12) {
                        $_POST['sat_to1'] = intval($_POST['sat_to1']) + 12;
                    }
                } else {
                    if (intval($_POST['sat_to1']) == 12) {
                        $_POST['sat_to1'] = intval($_POST['sat_to1']) + 12;
                    }
                }


                $sat_from = $_POST['sat_from1'] . ":00";
                $sat_to = $_POST['sat_to1'] . ":00";
                if ($sat_all == "on") {
                    timeComvert($user->time_zone, $user->time_zone, '00:00', '24:00', $api_data_array, 'sat');
                    //$api_data_array["sat"] = array("00:00-24:00");
                } elseif ($sat_all == "off") {
                } else {
                    timeComvert($user->time_zone, $user->time_zone, $sat_from, $sat_to, $api_data_array, 'sat');
                }

                $sun_all = $_POST['sun_all'];

                if ($_POST['sun_from2'] == 'PM') {
                    if (intval($_POST['sun_from1']) != 12) {
                        $_POST['sun_from1'] = intval($_POST['sun_from1']) + 12;
                    }
                } else {
                    if (intval($_POST['sun_from1']) == 12) {
                        $_POST['sun_from1'] = '00';
                    }
                }
                if ($_POST['sun_to2'] == 'PM') {

                    if (intval($_POST['sun_to1']) != 12) {
                        $_POST['sun_to1'] = intval($_POST['sun_to1']) + 12;
                    }
                } else {
                    if (intval($_POST['sun_to1']) == 12) {
                        $_POST['sun_to1'] = intval($_POST['sun_to1']) + 12;
                    }
                }


                $sun_from = $_POST['sun_from1'] . ":00";
                $sun_to = $_POST['sun_to1'] . ":00";
                if ($sun_all == "on") {
                    timeComvert($user->time_zone, $user->time_zone, '00:00', '24:00', $api_data_array, 'sun');
                    //$api_data_array["sun"] = array("00:00-24:00");
                } elseif ($sun_all == "off") {
                } else {
                    timeComvert($user->time_zone, $user->time_zone, $sun_from, $sun_to, $api_data_array, 'sun');
                }
                //print_r($api_data_array);
                //echo json_encode($api_data_array);

                if (strlen($schedule_UUID) > 0) {
                    parse_str($wag_obj->modifyPowerSchedule($zone_id, $schedule_UUID, $api_data_array, $WLanID, 'Customized', $_POST['schedule_name']), $modify_sche_respo);
                    //print_r($modify_sche_respo);
                    $new_schedule_id = json_decode(urldecode($modify_sche_respo['Description']), true)['id'];

                    if ($modify_sche_respo['status_code'] == '200') {
                        $db_class->userLog($user_name,$script,'Shedule Customized',$_SESSION['WLanSSID']);
                        $message=$message_functions->showMessage('schedule_update_success');
                        $create_log->save('3009',$message,$modify_sche_respo['Description']);
                        $_SESSION['tab9'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
                        $local_update_q = "INSERT INTO exp_distributor_network_schedul_assign (`ssid_broadcast`,`network_id`,`distributor`,`shedule_uniqu_id`) 
                    VALUES('Customized','$WLanID','$user->user_distributor','$schedule_UUID') ON DUPLICATE KEY UPDATE `ssid_broadcast`='Customized',`shedule_uniqu_id`='$schedule_UUID' ";
                        $db_class->execDB($local_update_q);
                    }else{
                        $message=$message_functions->showMessage('schedule_update_fail');
                        $create_log->save('2009',$message,$modify_sche_respo['Description']);
                        $_SESSION['tab9'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

                    }


                } else {

                    $api_data_array['name']= $schedule_name = $_POST['schedule_name']."-".uniqid();
                    $api_data_array['description']= $schedule_name = $_POST['schedule_name'];

                    parse_str($wag_obj->createScheduler($zone_id, $api_data_array), $new_schedule);
                    $new_schedule_id = json_decode(urldecode($new_schedule['Description']), true)['id'];

                    if ($new_schedule['status_code'] == '200') {
                        $modify_sche_respo = $wag_obj->modifySchedule($zone_id, $WLanID, 'Customized', $new_schedule_id, $schedule_name);

                        parse_str($modify_sche_respo,$modify_sche_respo_ar);
                        if($modify_sche_respo_ar['status_code']=='200'){

                            $local_update_q = "INSERT INTO exp_distributor_network_schedul_assign (`ssid_broadcast`,`network_id`,`distributor`,`shedule_uniqu_id`) 
                    VALUES('Customized','$WLanID','$user->user_distributor','$new_schedule_id') ON DUPLICATE KEY UPDATE shedule_uniqu_id = '$new_schedule_id',`ssid_broadcast`='Customized'";
                            $db_class->execDB($local_update_q);

                            $db_class->userLog($user_name,$script,'Shedule Customized',$_SESSION['WLanSSID']);
                            $message=$message_functions->showMessage('schedule_update_success');
                            $create_log->save('3009',$message,$modify_sche_respo_ar['Description']);
                            $_SESSION['tab9'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

                        }else{
                            $message=$message_functions->showMessage('schedule_update_fail');
                            $create_log->save('2009',$message,$modify_sche_respo_ar['Description']);
                            $_SESSION['tab9'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

                        }


                    }else{
                        $message=$message_functions->showMessage('schedule_update_fail');
                        $create_log->save('2009',$message,$new_schedule['Description']);
                        $_SESSION['tab9'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";

                    }

                }


                break;
            }
        }
    }
    else{
        switch ($all) {
            case'on':{
                $ssid_name_mode='AlwaysOn';
                break;

            }
            case'off':{
                $ssid_name_mode='AlwaysOff';
                break;
            }
            case'custom':{
                $ssid_name_mode='PowerSchedule';
                break;
            }
        }

        $message=$message_functions->showMessage('schedule_update_success');
        $_SESSION['tab9'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
    }
    $tab=$_GET['t'];
    $page=$_GET['script'];
    $_SESSION[$tab] = $_SESSION['tab9'];
    unset($_SESSION['tab9']);
    header("Location: ".$global_base_url."/".$page.$extension."?t=".$tab);
    exit();

}
