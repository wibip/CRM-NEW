<?php 
/* ini_set('display_errors', 1);
error_reporting(E_ALL & E_NOTICE & E_WARNING); */
include_once 'src/statistics/Arris_Graph_API/index.php';
$ob = new index($user_distributor);
$a = $ob->getOverviewGraph('last_24_hours');
$server_count = 0;
$router_vm_count = 0;
$switch_count = 0;
$ap_count = 0;
$firewall_count = 0;
$server_up_count = 0;
$router_vm_up_count = 0;
$switch_up_count = 0;
$ap_up_count = 0;
$firewall_up_count = 0;

foreach ($a['details'] as $key => $value) {
    if($value['type']=='Switches'){
        $switch_count++;
        if($value['status']=='Connected'){
            $switch_up_count++;
        }
    }
    if($value['type']=='Router' || $value['type']=='Router VMs' ){
        $router_vm_count++;
        if($value['status']=='Connected'){
            $router_vm_up_count++;
        }
    }
    if($value['type']=='Firewall'){
        $firewall_count++;
        if($value['status']=='Connected'){
            $firewall_up_count++;
        }
    }
    if($value['type']=='Servers'){
        $server_count++;
        if($value['status']=='Connected'){
            $server_up_count++;
        }
    }
}

foreach ($a['apdetails'] as $key => $value) {
    $ap_count++;
    if($value['status']=='Connected'){
        $ap_up_count++;
    }
}

$server_img = ($server_count===$server_up_count && $server_count!=0) ? 'right.png' : 'wrong.png';
$router_vm_img = ($router_vm_count===$router_vm_up_count && $router_vm_count!=0) ? 'right.png' : 'wrong.png';
$switch_img = ($switch_count===$switch_up_count && $switch_count!=0) ? 'right.png' : 'wrong.png';
$ap_img = ($ap_count===$ap_up_count && $ap_count!=0) ? 'right.png' : 'wrong.png';
$firewall_img = ($firewall_count===$firewall_up_count && $firewall_count!=0) ? 'right.png' : 'wrong.png';


$gu_wlan_ar = array();
$pr_wlan_ar = array();
$vt_wlan_ar = array();
$last24_pr = 0;
$last24_gs = 0;

$wlan_q = "SELECT DISTINCT network_id,wlan_name,ssid,network_method AS type FROM `exp_locations_ssid` WHERE network_id IS NOT NULL AND network_id<>'' AND distributor = '$user_distributor' AND network_method<>'MDO'
UNION
SELECT DISTINCT network_id,wlan_name,ssid,'private' AS type FROM `exp_locations_ssid_private` WHERE network_id IS NOT NULL AND network_id<>'' AND distributor = '$user_distributor'
UNION 
SELECT DISTINCT network_id,wlan_name,ssid,'TENANT' AS type FROM `exp_locations_ssid_vtenant` WHERE network_id IS NOT NULL AND network_id<>'' AND distributor = '$user_distributor'";
$wlan_r=$db->selectDB($wlan_q);
foreach($wlan_r['data'] AS $row){
    if($row['type']=='GUEST'){
        array_push($gu_wlan_ar,$row['ssid']);
        $res_arr = $ob->getClientSessionDetails('last_24_hours',$row['wlan_name']);
        $response = json_decode($res_arr, true);
        $respo_description = json_decode($response['Description'], true);
        $last24_gs = $last24_gs + $respo_description['clientSessionDetails']['clientCount'];
    }elseif ($row['type']=='private'){
        array_push($pr_wlan_ar,$row['ssid']);
        $res_arr = $ob->getClientSessionDetails('last_24_hours',$row['wlan_name']);
        $response = json_decode($res_arr, true);
        $respo_description = json_decode($response['Description'], true);
        $last24_pr = $last24_pr + $respo_description['clientSessionDetails']['clientCount'];
    
    }elseif ($row['type']=='TENANT'){
        array_push($gu_wlan_ar,$row['ssid']);
        array_push($vt_wlan_ar,$row['ssid']);
    }
}

$ap_q1="SELECT `ap_controller`,`distributor_name`,`zone_id`
FROM `exp_mno_distributor`
WHERE `distributor_code`='$user_distributor'
LIMIT 1";

$query_results_ap=$db->selectDB($ap_q1);
foreach($query_results_ap['data'] AS $row){
    $ack = $row['ap_controller'];
    $distributor_name = $row['distributor_name'];
    $zone = $row['zone_id'];
}

$ap_q2="SELECT `api_profile`
FROM `exp_locations_ap_controller`
WHERE `controller_name`='$ack'
LIMIT 1";

$query_results_ap2=$db->selectDB($ap_q2);
foreach($query_results_ap2['data'] AS $row){
    $wag_ap_name2 = $row['api_profile'];
}
$ap_control_var = $db->setVal('ap_controller', 'ADMIN');


//  $wag_ap_name='NO_PROFILE';
if($wag_ap_name!='NO_PROFILE'){

    if($ap_control_var=='MULTIPLE'){

        //echo 'src/AP/' . $wag_ap_name2 . '/index.php';

        include 'src/AP/' . $wag_ap_name2 . '/index.php';
        if($wag_ap_name2==""){
            include 'src/AP/' . $wag_ap_name . '/index.php';
        }

        $wag_obj = new ap_wag($ack);

    }else if($ap_control_var=='SINGLE'){


        include 'src/AP/' . $wag_ap_name . '/index.php';
        $wag_obj = new ap_wag();

    }

}

$arr1 = array(array("type" => "ZONE","value" => $zone ));
$client = $wag_obj->queryClient($arr1);
parse_str($client,$client_arr);
$cln_arr = json_decode($client_arr['Description'],true);

$active_pr = 0;
$active_gs = 0;

foreach ($cln_arr['list'] as $key => $value) {
    if (in_array($value['ssid'], $gu_wlan_ar)){
        $active_gs++;
    }

    if (in_array($value['ssid'], $pr_wlan_ar)){
        $active_pr++;
    }
}


?>
<br><ul class="nav nav-tabs">  
    <li class=""><a href="#" data-toggle="tab1" data-div="camp_submit">Welcome</a></li>
    </ul>

<link href="layout/<?php echo $camp_layout; ?>/css/swiper.css?v=26" rel="stylesheet">
<script type="text/javascript" src="layout/<?php echo $camp_layout; ?>/js/swiper.js?v=3"></script>
<h1 class="head">
    Take Control Of Your <?php echo __WIFI_TEXT__; ?>
</h1>
<div class="parent-head">
<ul class="parent_intro">

<?php

$dashIntroArray = array('img' => '1.jpg?v=1','desc' => 'Dashboard' , 'extra' => "<p>View active and historical session reports, bandwidth information, and the type of devices used by the guests on your network. </p><p>In addition to these reports,  collect the profile info (gender, age-group, etc.) of customers accessing your network.
  </p>");

$vtenantIntroArray = array('img' => '','desc' => 'Manage Residents' , 'extra' => "<p>Manually add new resident accounts or assist a resident to add or remove devices, reset passwords or change their QoS profile. </p><p>[Optional] Create new or change the self registration onboarding voucher.</p>
</p>");

$guestIntroArray = array('img' => '','desc' => 'Guest '.__WIFI_TEXT__ , 'extra' => "<p>Customize your Guest ".__WIFI_TEXT__." network SSID, so your guests can easily identify your business.</p><p>Users will access your ".__WIFI_TEXT__." network through a splash page, with or without a passcode defined by you to restrict access to your ".__WIFI_TEXT__." network.</p>
</p>");

$privateIntroArray = array('img' => '','desc' => 'Private '.__WIFI_TEXT__ , 'extra' => "<p>Customize your Private ".__WIFI_TEXT__." network SSID.</p><p>This network is not accessible by your guests. Your Private ".__WIFI_TEXT__." SSID is protected by a WPA2 passcode, and can even be hidden from broadcasting.</p>");

$configIntroArray = array('img' => '','desc' => 'Features' , 'extra' => "<p>Control advanced features such as QoS, Guest Session Duration, Network Schedule for broadcasting your SSID's, and Content Filtering to restrict websites on your Guest $wifi_code Network or Private $wifi_code Network.</p>");

$toolsIntroArray = array('img' => '','desc' => 'Tools' , 'extra' => "<p>Manage devices and sessions incl. delete devices and remove sessions. In addition, easily manually onboard devices to any of your network</p><p>Blacklist and whitelist devices</p>");

$fullintroArray = array('Welcome' =>  $dashIntroArray,'Tenant' =>  $vtenantIntroArray, 'Guest WiFi' => $guestIntroArray, 'Private WiFi' => $privateIntroArray, 'Features' => $configIntroArray, 'Tools'=>$toolsIntroArray);

$splashIntroArray = array('class' => 'txt-only','img' => '','desc' => 'Splash Page' , 'extra' => "<p>Customize the splash portal page to accommodate the themes of your business. Your guests will see your branding and advertisement when they connect to your Guest ".__WIFI_TEXT__." network.</p><p>Explore multiple sign-in options for your guests, including personalized messages or a redirect to your business' website.</p>",'link' => 'theme');

$img1IntroArray = array('class' => 'img1-only', 'img' => '3.jpg?v=1','desc' => '' , 'extra' => "","link"=> $support_faq_link);

$campaignIntroArray = array('class' => 'txt-only','img' => '','desc' => 'Campaigns' , 'extra' => "<p>Engage with your guests when they connect to your $wifi_code network. Display an image with a message similar to a social media post, either informational or commercial in nature. For example, 'Please join us on Wednesday nights for Open Mic Night!' or 'Come to our Happy Hour every day between 5pm - 7pm and enjoy our 2 for 1 cocktails!'
</p>", 'link' => 'campaign');

$img2IntroArray = array('class' => 'img-only', 'img' => '4.jpg?v=1','desc' => '' , 'extra' => "");

$additionalArray = array('3' =>  $splashIntroArray, '4' => $img1IntroArray, '5' => $campaignIntroArray, '6' => $img2IntroArray);

$i = 1;
$additional_called = false;
foreach ($main_mod_array as $keym => $valuem){
    $main_menu_name2 = $valuem['name'];
    $modarray = $valuem['module'];

    ksort($modarray);
    

    foreach ($modarray as $keyZ => $valueZ){

        if(strlen($link_main_m_multy)==0)
        $link_main_m_multy =  $valueZ['link'];
    }

     if($i == 1){
            $ss = 'clicked';
     }
     else{
        $ss = '';
     }

    if(strlen($fullintroArray[$main_menu_name2]['img']) > 0){


    	$background_image = 'style="background-image: url(layout/'.$camp_layout.'/img/'.$fullintroArray[$main_menu_name2]['img'].');" class="main_intro '.$ss.'" ';
    }
    else{
    	$background_image = 'class="main_intro no-background '.$ss.'"';
    }

    if($i == 3 && !$additional_called && ((strpos($network_type, 'GUEST') !== false) || (strpos($network_type, 'BOTH') !== false))){
        $additional_called = true;
    	foreach ($additionalArray as $aa => $val){

    		if($val['class'] == 'img-only'){
    			$attr = 'style="background-image: url(layout/'.$camp_layout.'/img/'.$val['img'].');" class="main_intro '.$val['class'].'"';
                echo '<li '.$attr.'><div class="intro-content"><h1>'.$val['desc'].'</h1><p>'.$val['extra'].'</p></div></li>';

    		}
    		else if($val['class'] == 'img1-only'){
                if (!empty($support_faq_link)) {
    			$attr = 'style="background-image: url(layout/'.$camp_layout.'/img/'.$val['img'].');" class="main_intro '.$val['class'].'"';
                //echo '<li '.$attr.'><a class="intro-content" target="_blank" href="'.$val['link'].'">Customer Survey</a></li>';
                echo '<li '.$attr.'></li>';
                }else{
                $attr = 'style="background-image: url(layout/'.$camp_layout.'/img/'.$val['img'].');" class="main_intro '.$val['class'].'"';
                    //echo '<li '.$attr.'><a class="intro-content" target="_blank" >Customer Survey</a></li>'; 
                    echo '<li '.$attr.'></li>';
                    
                }
                

    		}
    		else{
    			$attr = 'class="main_intro '.$val['class'].'"';
                echo '<li '.$attr.'><div class="intro-content"><h1>'.$val['desc'].'</h1><p>'.$val['extra'].'</p><a href="'.$val['link'].'">Check it out</a></div></li>';

    		}
    		  	}

    }

    $module_pr = true;
    if($link_main_m_multy =='venue_support'){
        $fullintroArray[$main_menu_name2]['desc']='Tools';
        $fullintroArray[$main_menu_name2]['extra']='<p>Manage devices and sessions incl. delete devices and remove sessions. In addition, easily manually onboard devices to any of your network</p><p>Blacklist and whitelist devices</p>';
    }
    if($link_main_m_multy == $user_guide_link ){
        $module_pr = false;
    }

        if($module_pr){

 ?>


 <li <?php echo $background_image; ?>>
	<div class="intro-content <?php echo $main_menu_name2; ?>">
		<h1><?php echo $fullintroArray[$main_menu_name2]['desc']; ?></h1>
        <?php 
    if($main_menu_name2=='Welcome'){
        ?>
        <table class="dash-table">
            <tbody>
                <tr><th style="text-align: left">ELEMENTS</th><th style="text-align: center">QTY</th><th style="text-align: center">STATUS</th><th style="text-align: center"></th></tr>
    <?php if($server_count!=0){ ?><tr><td>Servers</td><td><?php echo $server_count; ?></td><td><?php echo $server_up_count; ?> of <?php echo $server_count; ?> UP</td><td><img style="max-width: 15px;" src="layout/<?php echo $camp_layout; ?>/img/<?php echo $server_img; ?>"></td></tr> <?php } ?>
    <?php if($router_vm_count!=0){ ?><tr><td>Router VMs</td><td><?php echo $router_vm_count; ?></td><td><?php echo $router_vm_up_count; ?> of <?php echo $router_vm_count; ?> UP</td><td><img style="max-width: 15px;" src="layout/<?php echo $camp_layout; ?>/img/<?php echo $router_vm_img; ?>"></td></tr>  <?php } ?>
    <?php if($switch_count!=0){ ?><tr><td>Switches</td><td><?php echo $switch_count; ?></td><td><?php echo $switch_up_count; ?> of <?php echo $switch_count; ?> UP</td><td><img style="max-width: 15px;" src="layout/<?php echo $camp_layout; ?>/img/<?php echo $switch_img; ?>"></td></tr><?php } ?>
    <?php if($ap_count!=0){ ?><tr><td>Access Points</td><td><?php echo $ap_count; ?></td><td><?php echo $ap_up_count; ?> of <?php echo $ap_count; ?> UP</td><td><img style="max-width: 15px;" src="layout/<?php echo $camp_layout; ?>/img/<?php echo $ap_img; ?>"></td></tr><?php } ?>
    <?php if($firewall_count!=0){ ?><tr><td>Firewall</td><td><?php echo $firewall_count; ?></td><td><?php echo $firewall_up_count; ?> of <?php echo $firewall_count; ?> UP</td><td><img style="max-width: 15px;" src="layout/<?php echo $camp_layout; ?>/img/<?php echo $firewall_img; ?>"></td></tr> <?php } ?>
            </tbody>
        </table>
        <table class="dash-table2">
            <tbody>
                <tr><th style="text-align: left">CLIENTS</th><th style="text-align: center">GUEST</th><th style="text-align: center">PRIVATE</th><th style="text-align: center"></th></tr>
                <tr><td>Active</td><td><?php echo $active_gs; ?></td><td><?php echo $active_pr; ?></td><td></td></tr> 
                <tr><td>Last 24 Hrs</td><td><?php echo $last24_gs; ?></td><td><?php echo $last24_pr; ?></td><td></td></tr>
            </tbody>
        </table>
        <?php 
    }else{
        echo $fullintroArray[$main_menu_name2]['extra'];
     } ?>
		<a href="<?php  if($link_main_m_multy=='intro'){ echo 'home'; }elseif($link_main_m_multy=='add_tenant'){ echo 'manage_tenant'; }else{ echo $link_main_m_multy; } ?>">Check it out</a>
	</div>
 </li>

<?php

$link_main_m_multy = '';

$i++;

}

}


echo '<ol class="mobile-menu" style="display: none;">';

for ($x = 0; $x < ($i +3); $x++){

    if($x == 0){
    echo '<li class="clicked" data-slide="0" class="">1</li>';

    }else{
    echo '<li data-slide="0" class="">1</li>';

    }
}

echo '</ol>';
 ?>


</ul>


<!--mobile slider-->

<div class="mobile-container" >
<div class="swiper-container" >
    <div class="swiper-wrapper">



<?php


$i = 1;
$additional_called = false;
foreach ($main_mod_array as $keym => $valuem){
    $main_menu_name2 = $valuem['name'];
    $modarray = $valuem['module'];

    ksort($modarray);


    foreach ($modarray as $keyZ => $valueZ){

        if(strlen($link_main_m_multy1)==0)
        $link_main_m_multy1 =  $valueZ['link'];
    }

     if($i == 1){
            $ss = 'clicked';
     }
     else{
        $ss = '';
     }

    /* if(strlen($fullintroArray[$main_menu_name2]['img']) > 0){


    	$background_image = 'style="background-image: url(layout/OPTIMUM/img/'.$fullintroArray[$main_menu_name2]['img'].');" class="main_intro '.$ss.'" ';
    }
    else{
    	$background_image = 'class="main_intro no-background '.$ss.'"';
    }
 */
    $background_image = 'class="main_intro no-background '.$ss.'"';

    if($i == 3 && !$additional_called && ((strpos($network_type, 'GUEST') !== false) || (strpos($network_type, 'BOTH') !== false))){
        $additional_called = true;
    	foreach ($additionalArray as $aa => $val){

    		if($val['class'] == 'img-only'){
    			$attr = 'style="background-image: url(layout/'.$camp_layout.'/img/'.$val['img'].');" class="main_intro '.$val['class'].'"';
                echo '  <div class="swiper-slide"><li '.$attr.'><div class="intro-content"><h1>'.$val['desc'].'</h1><p>'.$val['extra'].'</p></div></li></div>';

            }
            else if($val['class'] == 'img1-only'){
                if (!empty($support_faq_link)) {
    			$attr = 'style="background-image: url(layout/'.$camp_layout.'/img/'.$val['img'].');" class="main_intro '.$val['class'].'"';
                //echo '<div class="swiper-slide"><li '.$attr.'><a class="intro-content" target="_blank" href="'.$val['link'].'">Customer Survey</a></div></li>';
                echo '<div class="swiper-slide"><li '.$attr.'></div></li>';
               
            }else{
                $attr = 'style="background-image: url(layout/'.$camp_layout.'/img/'.$val['img'].');" class="main_intro '.$val['class'].'"';
                    //echo '<li '.$attr.'><a class="intro-content" target="_blank" >Customer Survey</a></li>'; 
                    echo '<li '.$attr.'></li>';
                }

    		}
    		else{
    			$attr = 'class="main_intro '.$val['class'].'"';
                echo '  <div class="swiper-slide"><li '.$attr.'><div class="intro-content"><h1>'.$val['desc'].'</h1><p>'.$val['extra'].'</p><a href="'.$val['link'].'">Check it out</a></div></li></div>';

    		}
    		  	}

    }


     $module_pr = true;
    if($link_main_m_multy1 =='venue_support'){
        $module_pr = false;
    }
    if($link_main_m_multy1 == $user_guide_link ){
        $module_pr = false;
    }

        if($module_pr){

 ?>



      <div class="swiper-slide">


      <li <?php echo $background_image; ?>>
	<div class="intro-content">
		<h1><?php echo $fullintroArray[$main_menu_name2]['desc']; ?></h1>
		<?php echo $fullintroArray[$main_menu_name2]['extra']; ?>
		<a href="<?php  if($link_main_m_multy1=='intro'){ echo 'home'; }else{ echo $link_main_m_multy1; } ?>">Check it out</a>
	</div>
 </li>

      </div>


      <?php

$link_main_m_multy1 = '';

$i++;

}

}

?>


    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
  </div>

</div>

</div>



<style type="text/css">

.intro-content.Welcome h1{
    margin-bottom: 10px;
}
.parent_intro .intro-content.Welcome{
    border-right: 24px solid #000;
}
.dash-table, .dash-table2{
    width: 100%;
    font-family: Altice-Regular !important;
    margin-bottom: 10px;
    font-size: 15px;
}

.dash-table2{
    margin-top: 20px;
}

.dash-table tbody tr:nth-child(even) td, .dash-table2 tbody tr:nth-child(even) td {
    background-color: #ececec;
}
.dash-table tr td:first-child, .dash-table2 tr td:first-child {
    width: 30%;
}
.dash-table tr td:nth-child(2), .dash-table2 tr td:nth-child(2) {
    width: 22%;
    text-align: center;
}
.dash-table tr td:nth-child(3), .dash-table2 tr td:nth-child(3) {
    width: 30%;
    text-align: center;
}
.dash-table td,.dash-table th,.dash-table2 td,.dash-table2 th  {
    padding: 5px 5px;
}
.dash-table th, .dash-table2 th  {
    font-size: 18px;
    font-family: 'Altice-Bold';
}
.contact{
    font-size: 16px;
    font-family: Rregular;
    color: #fff;
        margin-right: 50px;
}

.call span:not(.glyph), .footer-live-chat-link span:not(.glyph){
    font-family: Rmedium;
    font-size: 20px;
    color: #fff;
}

.number{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-live-chat-link{
        display: inline-block;
    margin-left: 50px;
}

.call a{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-inner a:hover{
    text-decoration: none !important;
    color: #fff;
}


.glyph{
    position: relative;
    top: 1px;
    display: inline-block;
    font-family: 'glyphs';
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
}

.glyph-phone:before {
    content: "\eA23";
}

.glyph-chat:before {
    content: "\eA04";
}

body{
    background: #ffffff !important;
        padding-bottom: 120px !important;
}

h1.head{
padding: 60px;
padding-right: 0px;
padding-left: 0px;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #000;
    font-family: Rbold;
}

.parent_intro{
        margin: auto;
        /*margin-top: 50px;*/
            /*margin-bottom: 50px;*/
    }

.parent-head{
        background: #000;
    padding-top: 50px;
    /*margin-top: 150px;*/
    padding-bottom: 33px;
    }

.main_intro{
    margin-right: -4px;
        height: 440px;
        display: inline-block;
        background-repeat: no-repeat;
    overflow: hidden;

    margin-bottom: 17px;
}

.main_intro:nth-child(1){
        background-position: 100% 0;
        background-size: contain;

}

@media (min-width: 980px){

    <?php if($introMnoPage=='NO'){ ?>

    h1.head{
        margin-top: 60px;
    }

<?php } ?>

    .main_intro:nth-child(1){
        width: 785px;
    }

    .parent_intro{
        width: 1200px;
    }

    .main_intro{
         width: 385px;
    }

.main_intro:nth-child(2){
        margin-left: 24px;

}

.main_intro:nth-child(4), .main_intro:nth-child(5){
        margin-left: 24px;

}

.main_intro:nth-child(7), .main_intro:nth-child(8){
    margin-left: 20px;
}
}




.intro-content{
    background-color: #fff;
    width: 65%;
    padding: 40px;
    padding-right: 30px;
    height: 100%;
    float: left;
    -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-size: 16px;
    color: #3a383d !important;
    font-family: Rregular;
}

.intro-content h1{
        margin-bottom: 30px;
               font-family: Altice-Bold;
    color: #000;
    font-size: 32px;
}

.intro-content p{
    font-family: Altice-Regular !important;
    font-size: 12pt !important;
    font-weight: normal !important;
}




.intro-content a{
    font-size: 26px;
    font-family: Altice-Bold !important;
}
.main_intro.img-only{
    background-size: cover;
}
.no-background .intro-content{
    width: 100%;
}

.img-only .intro-content{
    width: 0;
    height: 0;
    padding: 0;
}

.img1-only{
    position: relative;
    background-size: cover;
    display: inline-block;
}

.img1-only .intro-content{
    height: 60px;
    position: absolute;
    width: auto;
    color: #0084d6 !important;
    padding: 20px;
    left: 0px;
    right: 0px;
    text-align: center;
    bottom: 0px;
}
.img1-only .intro-content:hover{
    color: #545454 !important;
}

.img1-only .intro-content {
    font-size: 26px;
    font-family: Altice-Bold !important;
}
.txt-only .intro-content{
    width: 100%;
}


@media (max-width: 979px){
    .intro-content, .txt-only .intro-content, .no-background .intro-content, .img-only .intro-content{
        width: 100%;
        margin: auto;
    }

    .main_intro{
        padding-left: 20px;
    padding-right: 20px;
        box-sizing: border-box;
    width: 100%;
    }

    .main_intro.img-only{
    background-size: 90%;
    background-position: center;
}
.img1-only .intro-content{
    left: 20px;
    right: 20px;
}
.main_intro.img1-only{
    background-size: 90%;
    background-position: top;
}

    .parent_intro li:nth-child(1){
        background-image: none !important;
    }
}



.mobile-menu{
        margin: 0;
    padding: 0;
    border: none;
    list-style: none;
    text-align: center;
}


.mobile-menu li {
    display: inline-block;
    width: 20px;
    height: 20px;
    margin: 0 4px;
    background: transparent;
    border-radius: 20px;
    overflow: hidden;
    text-indent: -999em;
    border: 2px solid #fff;
    cursor: pointer;
}

.mobile-menu li.clicked{
    background: #fff;
}


/* slider */

.swiper-pagination-bullet {
    width: 20px !important;
    height: 20px !important;
    margin: 0 4px !important;
    background: transparent !important;
    border-radius: 20px !important;
    overflow: hidden !important;
    text-indent: -999em !important;
    border: 2px solid #fff !important;
    cursor: pointer !important;

    display: inline-block !important;

    opacity: 0.2 !important;
}


.swiper-pagination-bullet-active {
    width: 20px !important;
    height: 20px !important;
    margin: 0 4px !important;
    background-color: #fff !important;
    border-radius: 20px !important;
    overflow: hidden !important;
    text-indent: -999em !important;
    border: 2px solid #fff !important;
    cursor: pointer !important;
    opacity: 1 !important;

}

.swiper-pagination {

    position: static !important;

}

.nav-tabs{
    background: #000;
    width: 960px !important;
    margin: auto;
    box-sizing: border-box;
    margin-top: -22px;
    margin-left: auto !important;
    padding-top: 15px !important;
    padding-bottom: 15px !important;
    text-align: center;
    padding-left: 0px !important;
}

.nav-tabs>li>a{
    background: none !important;
    border: none !important;
    border-right: 1px solid white !important;
  }
  .nav-tabs>li>a{
        padding-top: 3px !important;
    padding-bottom: 3px !important;
    color: #fff !important;
    border-radius: 0px 0px 0 0 !important;
     border-right: none !important;
  }

  .nav-tabs>li:nth-child(2)>a{
    border-right: none !important;
  }
</style>

<script type="text/javascript">
    function manual_slider() {

    var index = $('.mobile-menu li.clicked').index();
    index = index +1;

    if($(window).width() < 980 ){

        $('.parent_intro li:not(.parent_intro li:nth-child('+ index +')):not(.mobile-menu li)').hide();
      //  $('.mobile-menu').show();
        $('.img-only').css('width', '100%');
        $('.mobile-container').show();
        $('.parent_intro').hide();

    }else{
        $('.parent_intro li:not(.mobile-menu li)').show();
        $('.mobile-menu').hide();
        $('.mobile-container').hide();
        $('.img-only').css('width', '385px');
        $('.parent_intro').show();
    }

}

 var swiper = new Swiper('.swiper-container', {
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '">' + (index + 1) + '</span>';
        },
      },
    });
</script>
