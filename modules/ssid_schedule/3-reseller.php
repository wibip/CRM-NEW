<div <?php if(isset($tab_guestnet_schedule)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guestnet_schedule">
    <?php if(isset($_SESSION['guestnet_schedule'])){
    echo $_SESSION['guestnet_schedule'];
    unset($_SESSION['guestnet_schedule']);
    } ?>
    <h2>Network Schedule</h2>
    <p>Control when your employees and guests have access to your network.</p>
    <p>With the network scheduler, you can control the hours that your employees and guests will be able to connect to your <?php echo __WIFI_TEXT__?> network.</p>
    <p>To set a schedule for one of your networks use the sliders to set the schedule between 12am and 11pm. Once your satisfied click the "Set" button to enable the schedule. Sliding the sliders to opposite ends enables "Always On". Sliding one slider on top of the other enables "Always Off".</p>
    <style type="text/css">

        .power_box2 h2{
            word-break: break-word;
        }

        @media (max-width: 980px){
            .power_box1, .power_box2{
                box-sizing: border-box;
                width: 100% !important;
                height: auto !important;
            }

            .ui-slider-horizontal{
                width: 100% !important;
            }
        }

        .days p:nth-child(1){
            font-weight: bold !important;
            width: 50%;
            display: inline-block;
        }

        .days p:nth-child(2){
            width: 49%;
            display: inline-block;
        }
        .ui-slider-horizontal {
            height: 8px;
            background: #D7D7D7 !important;
            border: 1px solid #BABABA !important;
            box-shadow: 0 1px 0 #FFF, 0 1px 0 #CFCFCF inset;
            clear: both;
            margin: 8px 0;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            -ms-border-radius: 6px;
            -o-border-radius: 6px;
            border-radius: 6px;
            width: 80%;
        }
        .ui-slider {
            position: relative;
            text-align: left;
        }
        .ui-slider-horizontal .ui-slider-range {
            top: -1px;
            height: 100%;
        }
        .ui-slider .ui-slider-range {
            position: absolute;
            z-index: 1;
            height: 8px;
            font-size: .7em;
            display: block;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            -khtml-border-radius: 6px;
            border-radius: 6px;
            background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
            background-size: 100%;
            background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #A0D4F5), color-stop(100%, #81B8F3));
            background-image: -webkit-linear-gradient(top, #A0D4F5, #81B8F3);
            background-image: -moz-linear-gradient(top, #A0D4F5, #81B8F3);
            background-image: -o-linear-gradient(top, #A0D4F5, #81B8F3);
            background-image: linear-gradient(top, #A0D4F5, #81B8F3);
        }
        .ui-slider .ui-slider-handle {
            border-radius: 50%;
            background: #F9FBFA !important;
            background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
            background-size: 100%;
            background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #C7CED6), color-stop(100%, #F9FBFA));
            background-image: -webkit-linear-gradient(top, #C7CED6, #F9FBFA);
            background-image: -moz-linear-gradient(top, #C7CED6, #F9FBFA);
            background-image: -o-linear-gradient(top, #C7CED6, #F9FBFA);
            background-image: linear-gradient(top, #C7CED6, #F9FBFA);
            width: 22px;
            height: 22px;
            -webkit-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
            -moz-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
            box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
            -webkit-transition: box-shadow .3s;
            -moz-transition: box-shadow .3s;
            -o-transition: box-shadow .3s;
            transition: box-shadow .3s;
        }
        .ui-slider .ui-slider-handle {
            position: absolute;
            z-index: 2;
            width: 22px;
            height: 22px;
            cursor: default;
            border: none;
            cursor: pointer !important;
        }
        .ui-slider .ui-slider-handle:after {
            content:"";
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            top: 50%;
            margin-top: -4px;
            left: 50%;
            margin-left: -4px;
        }
        .ui-slider-horizontal .ui-slider-handle {
            top: -.5em;
            margin-left: -.6em;
        }
        .ui-slider a:focus {
            outline:none;
        }

        #slider-range {
            width: 90%;
            margin: 0 auto;
        }
        #time-range {
            width: 400px;
        }
    </style>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.min.js"></script>

    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>

    <script type="text/javascript">

        function All(all,id){

            $('#schedule_submit'+id).prop('disabled', false);
            $('.all'+id).each(function(index, el) {
                $(this).val(all);
            });

            if(all=='on'){
                $(".slider-range-"+id).slider('values',0,0);
                $(".slider-range-"+id).slider('values',1,1440);

            }
            else if(all=='off'){
                $(".slider-range-"+id).slider('values',0,0);
                $(".slider-range-"+id).slider('values',1,0);
            }
            else{
                $(".slider-range-"+id).slider('values',0,540);
                $(".slider-range-"+id).slider('values',1,1020);
            }
        }


        /*$( 'input[name=all][value=custom]' ).prop( "checked", true );*/

        function updateSlider(e, ui,id) {
            $('#schedule_submit'+id).prop('disabled', false);



            var hours1 = Math.floor(ui.values[0] / 60);
            var minutes1 = ui.values[0] - (hours1 * 60);
            var hour24_from = hours1;

            if (hours1.length == 1) hours1 = '0' + hours1;
            if (minutes1.length == 1) minutes1 = '0' + minutes1;
            if (minutes1 == 0) minutes1 = '00';
            if (hours1 >= 12) {
                if (hours1 == 12) {
                    hours1 = hours1;
                    minutes1 = minutes1 + " PM";
                } else {
                    hours1 = hours1 - 12;
                    minutes1 = minutes1 + " PM";
                }
            } else {
                hours1 = hours1;
                minutes1 = minutes1 + " AM";
            }
            if (hours1 == 0) {
                hours1 = 12;
                minutes1 = minutes1;
            }


            var timeEle = $(this).data('time');

            var timeEle1 = 'slider-time-' + timeEle ;
            var timeEle2 = 'slider-time2-' + timeEle ;

            $('.'+ timeEle1).html(hours1 + ':' + minutes1);
            $('input[name='+ timeEle +'_from1]').val(("0" + hours1).slice(-2));

            var ampm1 = minutes1.split(" ")[1];

            $('input[name='+ timeEle +'_from2]').val(ampm1);

            var hours2 = Math.floor(ui.values[1] / 60);
            var minutes2 = ui.values[1] - (hours2 * 60);
            var hours3;
            var minutes3;
            var hour24_to = hours2;

            if (hours2.length == 1) hours2 = '0' + hours2;
            if (minutes2.length == 1) minutes2 = '0' + minutes2;
            if (minutes2 == 0) minutes2 = '00';
            if (hours2 >= 12) {
                if (hours2 == 12) {
                    hours2 = hours2;
                    minutes2 = minutes2 + " PM";
                    minutes3 = minutes2;
                    hours3 = hours2;
                } else if (hours2 == 24) {
                    hours2 = 11;
                    minutes2 = "59 PM";
                    hours3 = 12;
                    minutes3 = "00 AM";
                } else {
                    hours2 = hours2 - 12;
                    minutes2 = minutes2 + " PM";
                    hours3 = hours2;
                    minutes3 = minutes2;
                }
            } else {
                hours2 = hours2;
                hours3 = hours2;
                minutes2 = minutes2 + " AM";
                minutes3 = minutes2;
            }

            var difference = (hour24_to - hour24_from);
            var allVal;
            var allTxt;

            if(difference == 0){
                allVal = 'off';
                allTxt = 'Always Off';
                $('.slide_'+ timeEle ).hide();
                $('.txt_'+ timeEle ).css('display', 'inline-block');


            }
            else if(difference == 24){
                allVal = 'on';
                allTxt = 'Always On';
                $('.slide_'+ timeEle ).hide();
                $('.txt_'+ timeEle ).css('display', 'inline-block');
            }
            else{
                allVal = 'custom';
                allTxt = '';
                $('.slide_'+ timeEle ).show();
                $('.txt_'+ timeEle ).hide();
            }

            $('.txt_'+ timeEle ).html(allTxt);
            $('input[name='+ timeEle +'_all]').val(allVal);

            $('input[name='+ timeEle +'_to1]').val(("0" + hours3).slice(-2));

            var ampm2 = minutes3.split(" ")[1];

            $('input[name='+ timeEle +'_to2]').val(ampm2);

            $('.'+ timeEle2).html(hours2 + ':' + minutes2);
        }
    </script>

    <?php

    //Functions****************************************
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


    if(method_exists($wag_obj,'retrieveSchedule')){

        $ssid_q="SELECT s.network_id , s.ssid ,s.id FROM `exp_locations_ssid` s ,  `exp_mno_distributor` d
                 WHERE s.`distributor`=d.`distributor_code` AND s.`distributor`='$user_distributor' GROUP BY s.`ssid`";

        $ssid_res=$db->selectDB($ssid_q);

        if($ssid_res['rowCount']>0){

            foreach ($ssid_res['data'] as $row){

                $WLanID = $row['network_id'];
                $WLanSSID = $row['ssid'];
                $sID = $row['id'];

                /*CALL API*/
                parse_str($wag_obj->retrieveOneNetwork($zone_id,$WLanID),$WLan_respo);

                $WLan_respo = json_decode(urldecode($WLan_respo['Description']),true);

                $WLan_schedule = $WLan_respo['schedule'];
                $WLan_schedule_type = $WLan_schedule['type'];
                $WLan_schedule_ID = $WLan_schedule['id'];
                $WLan_schedule_name = $WLan_schedule['name'];
                if(strlen($WLan_schedule_name)<1){
                    $WLan_schedule_name = $WLanID.'-powerSchedule';
                }


                switch($WLan_schedule_type){
                    case 'Customized' : {
                        parse_str($wag_obj->retrieveSchedule($zone_id,$WLan_schedule_ID),$schedule);
                        if($schedule['status_code']=='200'){
                            $create_log->save('3009','get zone Schedules',$zone_id.json_encode($schedule));
                            $Description=json_decode(urldecode($schedule['Description']),true);


                            $day_arr=array('sun' => 'Sunday',
                                'mon' => 'Monday',
                                'tue' => 'Tuesday',
                                'wed' => 'Wednesday',
                                'thu' => 'Thursday',
                                'fri' => 'Friday',
                                'sat' => 'Saturday'
                            );

                            reset($day_arr);
                            $db_data_array_name="db_array";


                            //genarate_array_name
                            $db_data_array=$db_data_array_name.$x;

                            $$db_data_array = Array("mon"=>Array(),"tue"=>Array(),"wed"=>Array(),"thu"=>Array(),"fri"=>Array(),"sat"=>Array(),"sun"=>Array());

                            $schedule_array=$$db_data_array;

                            //time convert loop
                            foreach($day_arr as $key=>$val ) {
                                //echo $key;

                                $day_time_count=count($Description[$key]);

                                for($y=0;$y<$day_time_count;$y++) {

                                    $day_time = explode("-", $Description[$key][$y]);
                                    $day_time_start = $day_time[0];
                                    //echo"*".$day_time_start."/".$x.$y;
                                    $day_time_end = $day_time[1];
                                    //echo"*".$day_time_end."/".$x.$y;

                                    //convert timezone;
                                    timeComvert($user_time_zone,$user_time_zone,$day_time_start,$day_time_end,$schedule_array,$key);
                                }
                            }

                            $shedule_exists=$db->getValueAsf("SELECT `uniqu_name` AS f FROM `exp_distributor_network_schedul` WHERE `uniqu_name`='$new_schedule_name' GROUP BY`uniqu_name`");


                            //insert to db
                            //print_r($$db_data_array);
                            /*foreach($day_arr as $key=>$val ) {
                                $power_times="";
                                //echo $key;
                                $power_times_r=$schedule_array[$key];
                                //print_r($power_times_r);
                                foreach($power_times_r as $time_range){
                                    $power_times.=$time_range.",";
                                }
                                $power_times=rtrim($power_times," ,");
                                //echo $power_times;
                                //$$db_data_array[$key]
                                if ($shedule_exists != "") {
                                    $ins_q = "UPDATE `exp_distributor_network_schedul`
                                                                                        SET `active_fulltime`='$power_times'

                                                                                        WHERE `uniqu_name`='$new_schedule_name' AND `uniqu_id`='$new_schedule_id' AND `day`='$val'";
                                } else {

                                    $ins_q = "INSERT INTO `exp_distributor_network_schedul`
                                                                                    (`uniqu_id`,`uniqu_name`,`schedul_name`,`is_enable`,`schedul_description`,`network_method`,`distributor_id`,`day`,`active_fulltime`,`from`,`to`,`create_user`,`create_date`)
                                                                                VALUES	('$new_schedule_id','$new_schedule_name','$new_schedule_name','0','$new_schedule_des','','$user_distributor','$val','$power_times','','','$user_name',NOW())";
                                }
                                mysql_query($ins_q);
                            }*/

                            //print_r($schedule_array);
                            foreach ($schedule_array as $key=>$value){
                                /*$mon_from1 = '12';
                                $mon_from2 = 'AM';
                                $mon_to1 = '12';
                                $mon_to2 = 'AM';
                                $mon_all = 'on';
                                $mon_slider_val =getSliderPluginValues($mon_from1,$mon_from2,$mon_to1,$mon_to2);
                                $mon_slider_val_from=$mon_slider_val['from'];
                                $mon_slider_val_to=$mon_slider_val['to'];*/

                                $sf1 = $key.'_from1';
                                $sf2 = $key.'_from2';
                                $st1 = $key.'_to1';
                                $st2 = $key.'_to2';
                                $s = $key.'_all';
                                $sf0 = $key.'_slider_val_from';
                                $st0 = $key.'_slider_val_to';

                                if(strlen($value[0])>0){
                                    $time_array = explode('-',$value[0]);
                                    if($value[0]=='00:00-24:00'){
                                        $$s = 'on';
                                    }else{
                                        $$s = 'custom';
                                    }

                                }else{
                                    $time_array = array('00:00','00:00');
                                    $$s = 'off';
                                }


                                $date_from = new DateTime($time_array[0]);
                                $date_to = new DateTime($time_array[1]);
                                //echo $date->format('h:i A') ;

                                $$sf1 = $date_from->format('h');
                                $$sf2 = $date_from->format('A');
                                $$st1 = $date_to->format('h');
                                $$st2 = $date_to->format('A');

                                $$sf0 = get_minutes($time_array[0]);
                                $$st0 = get_minutes($time_array[1]);
                            }






                        }
                        break;
                    }
                    case 'AlwaysOn' : {

                        /*$check_local_set_schedule = "SELECT shedule_uniqu_id AS f FROM exp_distributor_network_schedul_assign WHERE distributor='$user_distributor' AND network_id='$WLanID'";
                        $WLan_schedule_ID = $db->getValueAsf($check_local_set_schedule);

                        if(strlen($WLan_schedule_ID)<1){*/

                        $controller_shID = array();
                        $local_shID = array();

                        /// GET Controller schedule list from API
                        parse_str($wag_obj->retrieveSchedulelist($zone_id),$schedule_in_controller);
                        $schedule_in_controller_ar = json_decode(urldecode($schedule_in_controller['Description']),true);
                        foreach ($schedule_in_controller_ar['list'] as $value){
                            array_push($controller_shID,$value['id']);
                        }
                        // print_r($controller_shID);

                        ///  Get Local schedule
                        $local_assigned_schedule_q = "SELECT shedule_uniqu_id FROM exp_distributor_network_schedul_assign WHERE distributor='$user_distributor'";
                        $local_assigned_schedule_r = $db->selectDB($local_assigned_schedule_q);
                        
                        foreach ($local_assigned_schedule_r['data'] AS $row) {
                            array_push($local_shID,$row['shedule_uniqu_id']);
                        }

                        //print_r($local_shID);
                        $unassign_scID = array_diff($controller_shID,$local_shID);
                        //print_r($unassign_scID);

                        if(count($unassign_scID)>0){
                            $WLan_schedule_ID = reset($unassign_scID);
                            $local_update_q = "UPDATE exp_distributor_network_schedul_assign SET shedule_uniqu_id = '$WLan_schedule_ID' WHERE distributor = '$user_distributor' AND network_id = '$WLanID'";
                            $db->execDB($local_update_q);
                        }

                        foreach ($schedule_in_controller_ar['list'] as $value){
                            if($value['id']==$WLan_schedule_ID)
                                $WLan_schedule_name=$value['name'];
                        }

                        /*}*/


                        $mon_from1 = '12';
                        $mon_from2 = 'AM';
                        $mon_to1 = '12';
                        $mon_to2 = 'AM';
                        $mon_all = 'on';
                        $mon_slider_val =getSliderPluginValues($mon_from1,$mon_from2,$mon_to1,$mon_to2);
                        $mon_slider_val_from=$mon_slider_val['from'];
                        $mon_slider_val_to=$mon_slider_val['to'];

                        $tue_from1 = '12';
                        $tue_from2 = 'AM';
                        $tue_to1 = '12';
                        $tue_to2 = 'AM';
                        $tue_all = 'on';
                        $tue_slider_val =getSliderPluginValues($tue_from1,$tue_from2,$tue_to1,$tue_to2);
                        $tue_slider_val_from=$tue_slider_val['from'];
                        $tue_slider_val_to=$tue_slider_val['to'];

                        $wed_from1 = '12';
                        $wed_from2 = 'AM';
                        $wed_to1 = '12';
                        $wed_to2 = 'AM';
                        $wed_all = 'on';
                        $wed_slider_val =getSliderPluginValues($wed_from1,$wed_from2,$wed_to1,$wed_to2);
                        $wed_slider_val_from=$wed_slider_val['from'];
                        $wed_slider_val_to=$wed_slider_val['to'];

                        $thu_from1 = '12';
                        $thu_from2 = 'AM';
                        $thu_to1 = '12';
                        $thu_to2 = 'AM';
                        $thu_all = 'on';
                        $thu_slider_val =getSliderPluginValues($thu_from1,$thu_from2,$thu_to1,$thu_to2);
                        $thu_slider_val_from=$thu_slider_val['from'];
                        $thu_slider_val_to=$thu_slider_val['to'];

                        $fri_from1 = '12';
                        $fri_from2 = 'AM';
                        $fri_to1 = '12';
                        $fri_to2 = 'AM';
                        $fri_all = 'on';
                        $fri_slider_val =getSliderPluginValues($fri_from1,$fri_from2,$fri_to1,$fri_to2);
                        $fri_slider_val_from=$fri_slider_val['from'];
                        $fri_slider_val_to=$fri_slider_val['to'];

                        $sat_from1 = '12';
                        $sat_from2 = 'AM';
                        $sat_to1 = '12';
                        $sat_to2 = 'AM';
                        $sat_all = 'on';
                        $sat_slider_val =getSliderPluginValues($sat_from1,$sat_from2,$sat_to1,$sat_to2);
                        $sat_slider_val_from=$sat_slider_val['from'];
                        $sat_slider_val_to=$sat_slider_val['to'];

                        $sun_from1 = '12';
                        $sun_from2 = 'AM';
                        $sun_to1 = '12';
                        $sun_to2 = 'AM';
                        $sun_all = 'on';
                        $sun_slider_val =getSliderPluginValues($sun_from1,$sun_from2,$sun_to1,$sun_to2);
                        $sun_slider_val_from=$sun_slider_val['from'];
                        $sun_slider_val_to=$sun_slider_val['to'];

                        break;
                    }
                    case 'AlwaysOff' : {

                        $controller_shID = array();
                        $local_shID = array();

                        /// GET Controller schedule list from API
                        parse_str($wag_obj->retrieveSchedulelist($zone_id),$schedule_in_controller);
                        $schedule_in_controller_ar = json_decode(urldecode($schedule_in_controller['Description']),true);
                        foreach ($schedule_in_controller_ar['list'] as $value){
                            array_push($controller_shID,$value['id']);
                        }
                        // print_r($controller_shID);

                        ///  Get Local schedule
                        $local_assigned_schedule_q = "SELECT shedule_uniqu_id FROM exp_distributor_network_schedul_assign WHERE distributor='$user_distributor'";
                        $local_assigned_schedule_r = $db->selectDB($local_assigned_schedule_q);
                       
                        foreach ($local_assigned_schedule_r['data'] AS $row) {
                            array_push($local_shID,$row['shedule_uniqu_id']);
                        }

                        //print_r($local_shID);
                        $unassign_scID = array_diff($controller_shID,$local_shID);
                        //print_r($unassign_scID);

                        if(count($unassign_scID)>0){
                            $WLan_schedule_ID = reset($unassign_scID);
                            $local_update_q = "UPDATE exp_distributor_network_schedul_assign SET shedule_uniqu_id = '$WLan_schedule_ID' WHERE distributor = '$user_distributor' AND network_id = '$WLanID'";
                            $db->execDB($local_update_q);
                        }

                        foreach ($schedule_in_controller_ar['list'] as $value){
                            if($value['id']==$WLan_schedule_ID)
                                $WLan_schedule_name=$value['name'];
                        }

                        /*}*/


                        $mon_from1 = '00';
                        $mon_from2 = 'AM';
                        $mon_to1 = '00';
                        $mon_to2 = 'AM';
                        $mon_all = 'on';
                        $mon_slider_val =getSliderPluginValues($mon_from1,$mon_from2,$mon_to1,$mon_to2);
                        $mon_slider_val_from=$mon_slider_val['from'];
                        $mon_slider_val_to=$mon_slider_val['to'];

                        $tue_from1 = '00';
                        $tue_from2 = 'AM';
                        $tue_to1 = '00';
                        $tue_to2 = 'AM';
                        $tue_all = 'on';
                        $tue_slider_val =getSliderPluginValues($tue_from1,$tue_from2,$tue_to1,$tue_to2);
                        $tue_slider_val_from=$tue_slider_val['from'];
                        $tue_slider_val_to=$tue_slider_val['to'];

                        $wed_from1 = '00';
                        $wed_from2 = 'AM';
                        $wed_to1 = '00';
                        $wed_to2 = 'AM';
                        $wed_all = 'on';
                        $wed_slider_val =getSliderPluginValues($wed_from1,$wed_from2,$wed_to1,$wed_to2);
                        $wed_slider_val_from=$wed_slider_val['from'];
                        $wed_slider_val_to=$wed_slider_val['to'];

                        $thu_from1 = '00';
                        $thu_from2 = 'AM';
                        $thu_to1 = '00';
                        $thu_to2 = 'AM';
                        $thu_all = 'on';
                        $thu_slider_val =getSliderPluginValues($thu_from1,$thu_from2,$thu_to1,$thu_to2);
                        $thu_slider_val_from=$thu_slider_val['from'];
                        $thu_slider_val_to=$thu_slider_val['to'];

                        $fri_from1 = '00';
                        $fri_from2 = 'AM';
                        $fri_to1 = '00';
                        $fri_to2 = 'AM';
                        $fri_all = 'on';
                        $fri_slider_val =getSliderPluginValues($fri_from1,$fri_from2,$fri_to1,$fri_to2);
                        $fri_slider_val_from=$fri_slider_val['from'];
                        $fri_slider_val_to=$fri_slider_val['to'];

                        $sat_from1 = '00';
                        $sat_from2 = 'AM';
                        $sat_to1 = '00';
                        $sat_to2 = 'AM';
                        $sat_all = 'on';
                        $sat_slider_val =getSliderPluginValues($sat_from1,$sat_from2,$sat_to1,$sat_to2);
                        $sat_slider_val_from=$sat_slider_val['from'];
                        $sat_slider_val_to=$sat_slider_val['to'];

                        $sun_from1 = '00';
                        $sun_from2 = 'AM';
                        $sun_to1 = '00';
                        $sun_to2 = 'AM';
                        $sun_all = 'on';
                        $sun_slider_val =getSliderPluginValues($sun_from1,$sun_from2,$sun_to1,$sun_to2);
                        $sun_slider_val_from=$sun_slider_val['from'];
                        $sun_slider_val_to=$sun_slider_val['to'];

                        break;
                    }
                }




                ?>
                <form id="tab5_form<?php echo$sID; ?>" name="tab5_form1" method="post" action="modules/ssid_schedule/1-submit?t=guestnet_schedule&script=<?php echo $script; ?>" class="form-horizontal">
                    <br/>
                    <fieldset class="fieset">
                        <br>
                        <div class="control-group" id="feild_gp_taddg_divt<?php echo$sID; ?>">
                            <!--<label class="control-label" for="gt_mvnx">Name</label>-->
                            <div class="controls ">
                                <input type="hidden" name="schedule_name" id="schedule_name<?php echo$sID; ?>" class="span4" maxlength="20" value="<?php echo $WLan_schedule_name; ?>"> <!-- onkeyup="validateShedulname(this.value)" -->
                                <div style="display:none;" class="help-block error-wrapper bubble-pointer mbubble-pointer" id="shedule_name_dup<?php echo$sID; ?>"><p><?php echo _POWER_SCHEDULE_NAME_; ?>Schedule name already exists</p></div>
                                <script type="text/javascript">

                                    $("#schedule_name<?php echo$sID; ?>").keypress(function(event){
                                        var ew = event.which;
                                        if(ew == 32 || ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35)
                                            return true;
                                        if(48 <= ew && ew <= 57)
                                            return true;
                                        if(65 <= ew && ew <= 90)
                                            return true;
                                        if(97 <= ew && ew <= 122)
                                            return true;
                                        return false;
                                    });

                                    $("#schedule_name<?php echo$sID; ?>").keyup(function(event) {
                                        var schedule_name;
                                        schedule_name = $('#schedule_name<?php echo$sID; ?>').val();
                                        var lastChar = schedule_name.substr(schedule_name.length - 1);
                                        var lastCharCode = lastChar.charCodeAt(0);

                                        if (!(( lastCharCode == 8 ||lastCharCode == 0 ||lastCharCode == 36 ||lastCharCode == 33 ||lastCharCode == 64 ||lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                            (65 <= lastCharCode && lastCharCode <= 90) ||
                                            (97 <= lastCharCode && lastCharCode <= 122))) {
                                            $("#schedule_name<?php echo$sID; ?>").val(schedule_name.substring(0, schedule_name.length - 1));
                                        }
                                    });

                                </script>

                                <input type="hidden" name="schedule_UUID" id="schedule_UUID<?php echo$sID; ?>" value="<?php echo $WLan_schedule_ID; ?>">
                                <input type="hidden" name="WLanID" id="WLanID<?php echo$sID; ?>" value="<?php echo $WLanID;?>">

                            </div>
                        </div>

                        <div>

                            <div class="power_box1" style="    padding: 30px;    border: 1px solid #dec8c8;    width: 60%;;float: left;">

                                <br>

                                <div class="days">
                                    <p>
                                        Monday
                                    </p>
                                    <p class="slide_mon" <?php echo 'style="display:'; echo $mon_all!='custom'?' none;"':'inline-block;"' ?> ><span class="slider-time-mon"><?php echo$mon_from1.' '.$mon_from2 ?></span> - <span class="slider-time2-mon"><?php echo$mon_to1.' '.$mon_to2 ?></span>
                                    </p>
                                    <p class="txt_mon" <?php echo 'style="display:'; echo $mon_all=='custom'?' none;"':'inline-block;"' ?>><?php echo $mon_all=='on'?'Always On':'Always Off'; ?>
                                    </p>
                                    <input type="hidden" name="mon_from1" value="<?php echo $mon_from1; ?>">
                                    <input type="hidden" name="mon_from2" value="<?php echo $mon_from2; ?>">
                                    <input type="hidden" name="mon_to1" value="<?php echo $mon_to1; ?>">
                                    <input type="hidden" name="mon_to2" value="<?php echo $mon_to2; ?>">
                                    <input type="hidden" name="mon_all" value="<?php echo $mon_all; ?>" class="all<?php echo$sID; ?>">
                                    <div class="slider-range slider-range-<?php echo$sID; ?>" id="slider-range-mon<?php echo$sID; ?>" data-time="mon"></div>

                                </div>

                                <div class="days">
                                    <p>
                                        Tuesday
                                    </p>
                                    <p class="slide_tue" <?php echo 'style="display:'; echo $tue_all!='custom'?' none;"':'inline-block;"' ?> ><span class="slider-time-tue"><?php echo$tue_from1.' '.$tue_from2 ?></span> - <span class="slider-time2-tue"><?php echo$tue_to1.' '.$tue_to2 ?></span>
                                    </p>
                                    <p class="txt_tue" <?php echo 'style="display:'; echo $tue_all=='custom'?' none;"':'inline-block;"' ?>><?php echo $tue_all=='on'?'Always On':'Always Off'; ?>
                                    </p>

                                    <input type="hidden" name="tue_from1" value="<?php echo $tue_from1; ?>">
                                    <input type="hidden" name="tue_from2" value="<?php echo $tue_from2; ?>">
                                    <input type="hidden" name="tue_to1" value="<?php echo $tue_to1; ?>">
                                    <input type="hidden" name="tue_to2" value="<?php echo $tue_to2; ?>">
                                    <input type="hidden" name="tue_all" value="<?php echo $tue_all; ?>" class="all<?php echo$sID; ?>">
                                    <div class="slider-range slider-range-<?php echo$sID; ?>" id="slider-range-tue<?php echo$sID; ?>" data-time="tue"></div>

                                </div>

                                <div class="days">
                                    <p>
                                        Wednesday
                                    </p>
                                    <p class="slide_wed" <?php echo 'style="display:'; echo $wed_all!='custom'?' none;"':'inline-block;"' ?> ><span class="slider-time-wed"><?php echo$wed_from1.' '.$wed_from2 ?></span> - <span class="slider-time2-wed"><?php echo$wed_to1.' '.$wed_to2 ?></span>
                                    </p>

                                    <p class="txt_wed" <?php echo 'style="display:'; echo $wed_all=='custom'?' none;"':'inline-block;"' ?>><?php echo $wed_all=='on'?'Always On':'Always Off'; ?>
                                    </p>

                                    <input type="hidden" name="wed_from1" value="<?php echo $wed_from1; ?>">
                                    <input type="hidden" name="wed_from2" value="<?php echo $wed_from2; ?>">
                                    <input type="hidden" name="wed_to1" value="<?php echo $wed_to1; ?>">
                                    <input type="hidden" name="wed_to2" value="<?php echo $wed_to2; ?>">
                                    <input type="hidden" name="wed_all" value="<?php echo $wed_all; ?>" class="all<?php echo$sID; ?>">
                                    <div class="slider-range slider-range-<?php echo$sID; ?>" id="slider-range-wed<?php echo$sID; ?>" data-time="wed"></div>

                                </div>

                                <div class="days">
                                    <p>
                                        Thursday
                                    </p>
                                    <p class="slide_thu" <?php echo 'style="display:'; echo $thu_all!='custom'?' none;"':'inline-block;"' ?> ><span class="slider-time-thu"><?php echo$thu_from1.' '.$thu_from2 ?></span> - <span class="slider-time2-thu"><?php echo$thu_to1.' '.$thu_to2 ?></span>
                                    </p>

                                    <p class="txt_thu" <?php echo 'style="display:'; echo $thu_all=='custom'?' none;"':'inline-block;"' ?>><?php echo $thu_all=='on'?'Always On':'Always Off'; ?>
                                    </p>

                                    <input type="hidden" name="thu_from1" value="<?php echo $thu_from1; ?>">
                                    <input type="hidden" name="thu_from2" value="<?php echo $thu_from2; ?>">
                                    <input type="hidden" name="thu_to1" value="<?php echo $thu_to1; ?>">
                                    <input type="hidden" name="thu_to2" value="<?php echo $thu_to2; ?>">
                                    <input type="hidden" name="thu_all" value="<?php echo $thu_all; ?>" class="all<?php echo$sID; ?>">
                                    <div class="slider-range slider-range-<?php echo$sID; ?>" id="slider-range-thu<?php echo$sID; ?>" data-time="thu"></div>

                                </div>

                                <div class="days">
                                    <p>
                                        Friday
                                    </p>
                                    <p class="slide_fri" <?php echo 'style="display:'; echo $fri_all!='custom'?' none;"':'inline-block;"' ?> ><span class="slider-time-fri"><?php echo$fri_from1.' '.$fri_from2 ?></span> - <span class="slider-time2-fri"><?php echo$fri_to1.' '.$fri_to2 ?></span>
                                    </p>
                                    <p class="txt_fri" <?php echo 'style="display:'; echo $fri_all=='custom'?' none;"':'inline-block;"' ?>><?php echo $fri_all=='on'?'Always On':'Always Off'; ?>
                                    </p>

                                    <input type="hidden" name="fri_from1" value="<?php echo $fri_from1; ?>">
                                    <input type="hidden" name="fri_from2" value="<?php echo $fri_from2; ?>">
                                    <input type="hidden" name="fri_to1" value="<?php echo $fri_to1; ?>">
                                    <input type="hidden" name="fri_to2" value="<?php echo $fri_to2; ?>">
                                    <input type="hidden" name="fri_all" value="<?php echo $fri_all; ?>" class="all<?php echo$sID; ?>">

                                    <div class="slider-range slider-range-<?php echo$sID; ?>" id="slider-range-fri<?php echo$sID; ?>" data-time="fri"></div>

                                </div>

                                <div class="days">
                                    <p>
                                        Saturday
                                    </p>
                                    <p class="slide_sat" <?php echo 'style="display:'; echo $sat_all!='custom'?' none;"':'inline-block;"' ?> ><span class="slider-time-sat"><?php echo$sat_from1.' '.$sat_from2 ?></span> - <span class="slider-time2-sat"><?php echo$sat_to1.' '.$sat_to2 ?></span>
                                    </p>
                                    <p class="txt_sat" <?php echo 'style="display:'; echo $sat_all=='custom'?' none;"':'inline-block;"' ?>><?php echo $sat_all=='on'?'Always On':'Always Off'; ?>
                                    </p>

                                    <input type="hidden" name="sat_from1" value="<?php echo $sat_from1; ?>">
                                    <input type="hidden" name="sat_from2" value="<?php echo $sat_from2; ?>">
                                    <input type="hidden" name="sat_to1" value="<?php echo $sat_to1; ?>">
                                    <input type="hidden" name="sat_to2" value="<?php echo $sat_to2; ?>">
                                    <input type="hidden" name="sat_all" value="<?php echo $sat_all; ?>" class="all<?php echo$sID; ?>">

                                    <div class="slider-range slider-range-<?php echo$sID; ?>" id="slider-range-sat<?php echo$sID; ?>" data-time="sat"></div>

                                </div>

                                <div class="days">
                                    <p>
                                        Sunday
                                    </p>
                                    <p class="slide_sun" <?php echo 'style="display:'; echo $sun_all!='custom'?' none;"':'inline-block;"' ?> ><span class="slider-time-sun"><?php echo$sun_from1.' '.$sun_from2 ?></span> - <span class="slider-time2-sun"><?php echo$sun_to1.' '.$sun_to2 ?></span>
                                    </p>
                                    <p class="txt_sun" <?php echo 'style="display:'; echo $sun_all=='custom'?' none;"':'inline-block;"' ?>><?php echo $sun_all=='on'?'Always On':'Always Off'; ?>
                                    </p>

                                    <input type="hidden" name="sun_from1" value="<?php echo $sun_from1; ?>">
                                    <input type="hidden" name="sun_from2" value="<?php echo $sun_from2; ?>">
                                    <input type="hidden" name="sun_to1" value="<?php echo $sun_to1; ?>">
                                    <input type="hidden" name="sun_to2" value="<?php echo $sun_to2; ?>">
                                    <input type="hidden" name="sun_all" value="<?php echo $sun_all; ?>" class="all<?php echo$sID; ?>">

                                    <div class="slider-range slider-range-<?php echo$sID; ?>" id="slider-range-sun<?php echo$sID; ?>" data-time="sun"></div>

                                </div>

                            </div>

                            <div class="power_box2" style="height: 559px;width: 30%;display: inline-block;    background: #d7d7d7;box-sizing: border-box;padding: 20px">
                                <h2>SSID :  <br>

                                    <?php echo $WLanSSID; ?></h2>

                                <br>

                                <input type="radio" class="radio-black" name="all" onclick="All(this.value,<?php echo$sID; ?>)" value="on" <?php if($WLan_schedule_type=='AlwaysOn'){ ?> checked="checked" <?php } ?>> Always On <br><br>
                                <input type="radio" class="radio-black" name="all" onclick="All(this.value,<?php echo$sID; ?>)" value="off" <?php if($WLan_schedule_type=='AlwaysOff'){ ?> checked="checked" <?php } ?>> Always Off <br><br>
                                <input type="radio" class="radio-black" name="all" onclick="All(this.value,<?php echo$sID; ?>)" value="custom" <?php if($WLan_schedule_type=='Customized'){ ?> checked="checked" <?php } ?>> Schedule <br><br>

                                <button type="submit" disabled="disabled" name="schedule_submit_mid" id="schedule_submit<?php echo$sID; ?>"  class="btn btn-primary">Set</button>

                            </div>
                        </div>

                        <input type="hidden" name="schedule_submit_secret" value="<?php echo $_SESSION['FORM_SECRET']?>">
                    </fieldset>

                </form>


                <script>
                    $("#slider-range-mon<?php echo$sID; ?>").slider({
                        range: true,
                        min: 0,
                        max: 1440,
                        step: 60,
                        values: [<?php echo $mon_slider_val_from; ?>, <?php echo $mon_slider_val_to; ?>],
                        change: updateSlider,
                        slide: function(e, ui) {
                            $( 'input[name=all][value=custom]' ).prop( "checked", true );
                            updateSlider(e, ui,<?php echo$sID; ?>);
                        }
                    });
                    $("#slider-range-tue<?php echo$sID; ?>").slider({
                        range: true,
                        min: 0,
                        max: 1440,
                        step: 60,
                        values: [<?php echo $tue_slider_val_from; ?>, <?php echo $tue_slider_val_to; ?>],
                        change: updateSlider,
                        slide: function(e, ui) {
                            $( 'input[name=all][value=custom]' ).prop( "checked", true );
                            updateSlider(e, ui,<?php echo$sID; ?>);
                        }
                    });
                    $("#slider-range-wed<?php echo$sID; ?>").slider({
                        range: true,
                        min: 0,
                        max: 1440,
                        step: 60,
                        values: [<?php echo $wed_slider_val_from; ?>, <?php echo $wed_slider_val_to; ?>],
                        change: updateSlider,
                        slide: function(e, ui) {
                            $( 'input[name=all][value=custom]' ).prop( "checked", true );
                            updateSlider(e, ui,<?php echo$sID; ?>);
                        }
                    });
                    $("#slider-range-thu<?php echo$sID; ?>").slider({
                        range: true,
                        min: 0,
                        max: 1440,
                        step: 60,
                        values: [<?php echo $thu_slider_val_from; ?>, <?php echo $thu_slider_val_to; ?>],
                        change: updateSlider,
                        slide: function(e, ui) {
                            $( 'input[name=all][value=custom]' ).prop( "checked", true );
                            updateSlider(e, ui,<?php echo$sID; ?>);
                        }
                    });
                    $("#slider-range-fri<?php echo$sID; ?>").slider({
                        range: true,
                        min: 0,
                        max: 1440,
                        step: 60,
                        values: [<?php echo $fri_slider_val_from; ?>, <?php echo $fri_slider_val_to; ?>],
                        change: updateSlider,
                        slide: function(e, ui) {
                            $( 'input[name=all][value=custom]' ).prop( "checked", true );
                            updateSlider(e, ui,<?php echo$sID; ?>);
                        }
                    });
                    $("#slider-range-sat<?php echo$sID; ?>").slider({
                        range: true,
                        min: 0,
                        max: 1440,
                        step: 60,
                        values: [<?php echo $sat_slider_val_from; ?>, <?php echo $sat_slider_val_to; ?>],
                        change: updateSlider,
                        slide: function(e, ui) {
                            $( 'input[name=all][value=custom]' ).prop( "checked", true );
                            updateSlider(e, ui,<?php echo$sID; ?>);
                        }
                    });
                    $("#slider-range-sun<?php echo$sID; ?>").slider({
                        range: true,
                        min: 0,
                        max: 1440,
                        step: 60,
                        values: [<?php echo $sun_slider_val_from; ?>, <?php echo $sun_slider_val_to; ?>],
                        change: updateSlider,
                        slide: function(e, ui) {
                            $( 'input[name=all][value=custom]' ).prop( "checked", true );
                            updateSlider(e, ui,<?php echo$sID; ?>);
                        }
                    });
                </script>


                <?php
            }
        }
    }
    ?>
</div>