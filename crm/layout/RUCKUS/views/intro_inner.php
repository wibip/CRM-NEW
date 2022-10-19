<link href="layout/<?php echo $camp_layout; ?>/css/swiper.css?v=26" rel="stylesheet">
<script type="text/javascript" src="layout/<?php echo $camp_layout; ?>/js/swiper.js?v=3"></script>
<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL & E_NOTICE & E_WARNING); */
$user_guide_link = "user_guide";
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
    if ($value['type'] == 'Switches') {
        $switch_count++;
        if ($value['status'] == 'Connected') {
            $switch_up_count++;
        }
    }
    if ($value['type'] == 'Router' || $value['type'] == 'Router VMs') {
        $router_vm_count++;
        if ($value['status'] == 'Connected') {
            $router_vm_up_count++;
        }
    }
    if ($value['type'] == 'Firewall') {
        $firewall_count++;
        if ($value['status'] == 'Connected') {
            $firewall_up_count++;
        }
    }
    if ($value['type'] == 'Servers') {
        $server_count++;
        if ($value['status'] == 'Connected') {
            $server_up_count++;
        }
    }
}

foreach ($a['apdetails'] as $key => $value) {
    $ap_count++;
    if ($value['status'] == 'Connected') {
        $ap_up_count++;
    }
}

$server_img = ($server_count === $server_up_count && $server_count != 0) ? 'yes.png' : 'no.png';
$router_vm_img = ($router_vm_count === $router_vm_up_count && $router_vm_count != 0) ? 'yes.png' : 'no.png';
$switch_img = ($switch_count === $switch_up_count && $switch_count != 0) ? 'yes.png' : 'no.png';
$ap_img = ($ap_count === $ap_up_count && $ap_count != 0) ? 'yes.png' : 'no.png';
$firewall_img = ($firewall_count === $firewall_up_count && $firewall_count != 0) ? 'yes.png' : 'no.png';


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
$wlan_r = $db->selectDB($wlan_q);
foreach ($wlan_r['data'] as $row) {
    if ($row['type'] == 'GUEST') {
        array_push($gu_wlan_ar, $row['ssid']);
        $res_arr = $ob->getClientSessionDetails('last_24_hours', $row['wlan_name']);
        $response = json_decode($res_arr, true);
        $respo_description = json_decode($response['Description'], true);
        $last24_gs = $last24_gs + $respo_description['clientSessionDetails']['clientCount'];
    } elseif ($row['type'] == 'private') {
        array_push($pr_wlan_ar, $row['ssid']);
        $res_arr = $ob->getClientSessionDetails('last_24_hours', $row['wlan_name']);
        $response = json_decode($res_arr, true);
        $respo_description = json_decode($response['Description'], true);
        $last24_pr = $last24_pr + $respo_description['clientSessionDetails']['clientCount'];
    } elseif ($row['type'] == 'TENANT') {
        array_push($vt_wlan_ar, $row['ssid']);
    }
}

$ap_q1 = "SELECT `ap_controller`,`distributor_name`,`zone_id`
FROM `exp_mno_distributor`
WHERE `distributor_code`='$user_distributor'
LIMIT 1";

$query_results_ap = $db->selectDB($ap_q1);
foreach ($query_results_ap['data'] as $row) {
    $ack = $row['ap_controller'];
    $distributor_name = $row['distributor_name'];
    $zone = $row['zone_id'];
}

$ap_q2 = "SELECT `api_profile`
FROM `exp_locations_ap_controller`
WHERE `controller_name`='$ack'
LIMIT 1";

$query_results_ap2 = $db->selectDB($ap_q2);
foreach ($query_results_ap2['data'] as $row) {
    $wag_ap_name2 = $row['api_profile'];
}
$ap_control_var = $db->setVal('ap_controller', 'ADMIN');


//  $wag_ap_name='NO_PROFILE';
if ($wag_ap_name != 'NO_PROFILE') {

    if ($ap_control_var == 'MULTIPLE') {

        //echo 'src/AP/' . $wag_ap_name2 . '/index.php';

        include 'src/AP/' . $wag_ap_name2 . '/index.php';
        if ($wag_ap_name2 == "") {
            include 'src/AP/' . $wag_ap_name . '/index.php';
        }

        $wag_obj = new ap_wag($ack);
    } else if ($ap_control_var == 'SINGLE') {


        include 'src/AP/' . $wag_ap_name . '/index.php';
        $wag_obj = new ap_wag();
    }
}

$arr1 = array(array("type" => "ZONE", "value" => $zone));
$client = $wag_obj->queryClient($arr1);
parse_str($client, $client_arr);
$cln_arr = json_decode($client_arr['Description'], true);

$active_pr = 0;
$active_gs = 0;
$active_vt = 0;

foreach ($cln_arr['list'] as $key => $value) {
    if (in_array($value['ssid'], $gu_wlan_ar)) {
        $active_gs++;
    }

    if (in_array($value['ssid'], $pr_wlan_ar)) {
        $active_pr++;
    }
    if (in_array($value['ssid'], $vt_wlan_ar)) {
        $active_vt++;
    }
}

$fullintroArray = [
    "Tenant" => [
        "title" => "Resident Network",
        "img"=> "tenant.jpg",
        "info" => "Add new resident accounts or assist them to manage their devices, reset passwords or change their QoS profile. [Optional] Create new or change the self registration or onboarding vouchers."
    ],
    "Guest WiFi" => [
        "title" => "Guest Networks",
        "img"=> "guest.png",
        "info" => "Name your Guest WiFi network SSID, assign QoS, set broadcast schedule, and easily create a custom splashpage with or without a custom campaign.",
    ],
    "Private WiFi" => [
        "title" => "Private Networks",
        "img"=> "private.jpg",
        "info" => "Customize this separate network that is not accessible by your guests and is protected by a WPA2 passcode, and it can even be hidden from broadcasting."
    ],
    "Features" => [
        "title" => "Add-On Features",
        "img"=> "features.jpg",
        "info" => "Add a preconfigured content filtering profile to one or more SSIDs.[Optional] Enterprise looks to Manage devices and sessions, and easily manually onboard devices to any of your network. "
    ],
    "User Guide" => [
        "title" => "User Guide",
        "img"=> "user_guide.jpg",
        "info" => "Download our user guide for indepth description of each sections of thi portal"
    ]
];

$sum_main = '';

$sum_div = '<div class="sum"> 
<div class="sum-h"> 
    <div class="m">
        <div class="h">
        Dashboard Summary
        </div>
        <div class="h-t">
        '.date('M d Y').'
        </div>
    </div>
    <a href="home">View My Dashboard</a>
</div>
<table class="dash-table">
            <thead>
            <tr>
                    <th style="text-align: left">ELEMENTS</th>
                    <th style="text-align: left">QTY</th>
                    <th style="text-align: left">STATUS</th>
                    <th style="text-align: left"></th>
                </tr>
            </thead>
            <tbody>';

            if ($server_count != 0) { 
                $sum_div .= '<tr>
                <td>Servers</td>
                <td>'.$server_count.'</td>
                <td>'.$server_up_count.' of '.$server_count.' UP</td>
                <td><img style="max-width: 15px;" src="layout/'.$camp_layout.'/img/.'.$server_img.'"></td>
            </tr>';
            }
            if ($router_vm_count != 0) {
                 $sum_div .= '<tr>
                 <td>Router VMs</td>
                 <td>'.$router_vm_count.'</td>
                 <td>'.$router_vm_up_count.' of '.$router_vm_count.' UP</td>
                 <td><img style="max-width: 15px;" src="layout/'.$camp_layout.'/img/'.$router_vm_img.'"></td>
             </tr>';
            }
            if ($switch_count != 0) {
                $sum_div .= '<tr>
                <td>Switches</td>
                <td>'.$switch_count.'</td>
                <td>'.$switch_up_count.' of '.$switch_count.' UP</td>
                <td><img style="max-width: 15px;" src="layout/'.$camp_layout.'/img/'.$switch_img.'"></td>
            </tr>';
            }
            $sum_div .= '<tr>
            <td>Access Points</td>
            <td>'.$ap_count.'</td>
            <td>'.$ap_up_count.' of '.$ap_count.' UP</td>
            <td><img style="max-width: 15px;" src="layout/'.$camp_layout.'/img/'.$ap_img.'"></td>
        </tr>';

        if ($firewall_count != 0) {
            $sum_div .= '<tr>
            <td>Firewall</td>
            <td>'.$firewall_count.'</td>
            <td>'.$firewall_up_count.' of '.$firewall_count.' UP</td>
            <td><img style="max-width: 15px;" src="layout/'.$camp_layout.'/img/'.$firewall_img.'"></td>
        </tr>';
        }

        $sum_div .= '</tbody>
        </table>
        <table class="dash-table2">
            <thead>
            <tr>
                    <th style="text-align: left">CLIENTS</th>
                    <th style="text-align: left">GUEST</th>
                    <th style="text-align: left">PRIVATE</th>
                    <th style="text-align: left">RESIDENTS</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td>Active</td><td>'.$active_gs.'</td>
                    <td>'.$active_pr.'</td>
                    <td>'.$active_vt.'</td>
                </tr>
                <tr>
                    <td>Last 24 Hrs</td>
                    <td>'.$last24_gs.'</td>
                    <td>'.$last24_pr.'</td>
                    <td>'.$active_vt.'</td>
                </tr>
            </tbody>
        </table>
    </div>';
        $sum_main .= $sum_div;
        $sum_mob = '<div class="swiper-slide">'.$sum_div.'</div>';
    $i = 1;
    foreach ($main_mod_array as $keym => $valuem) {
        $main_menu_name2 = $valuem['name'];
        $modarray = $valuem['module'];

        ksort($modarray);


        foreach ($modarray as $keyZ => $valueZ) {

            if (strlen($link_main_m_multy) == 0)
                $link_main_m_multy =  $valueZ['link'];
        }
        if (array_key_exists($main_menu_name2, $fullintroArray)) {
            $m = '<div class="img-bg" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url(\'layout/'.$camp_layout.'/img/'.$fullintroArray[$main_menu_name2]['img'].'\');">
            <div class="txt">
                <h2>'.$fullintroArray[$main_menu_name2]['title'].'</h2>
            </div>
            <div class="footer-info">
                <h2>'.$fullintroArray[$main_menu_name2]['title'].'</h2>
                <p>
                    '.$fullintroArray[$main_menu_name2]['info'].'
                </p>
                <a href="'.$link_main_m_multy.'" class="arrow"><img src="layout/'.$camp_layout.'/img/link-icon.png" alt=""></a>
            </div>
        </div>';
        $sum_div .= $m;
        $sum_main .= $m; 
        $sum_mob .= '<div class="swiper-slide">'.$m.'</div>';
        if($i==2){ $sum_main .= '</div><div class="fl-row">'; }
        $i++;
        }

        $link_main_m_multy = '';
    }

?>
<div class="fl-row">
    <?php
    echo $sum_main;
    ?>
</div>

<?php
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
<div class="mobile-container" >
<div class="swiper-container" >
    <div class="swiper-wrapper">
        <?php echo $sum_mob; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
</div>

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
<style>
    .img-bg {
        border-radius: 20px;
        width: 325px;
        height: 430px;
        background-repeat: no-repeat !important;
        position: relative;
        overflow: hidden;
        background-size: cover !important;
    }

    .sum-h{
        display: flex;
    align-items: center;
    margin-bottom: 20px;
    width: 100%;
    justify-content: space-between;
    }

    .sum-h .h{
    font-size: 24px;
    font-weight: 700;
    font-family: 'Altice-Bold';
    }

    .sum-h .h-t{
        font-size: 12px;
    color: #717171;
    }

    .sum-h a{
        float: right;
    font-size: 14px;
    color: #2760F0;
    font-weight: 700;
    }

    .fl-row {
        display: flex;
        justify-content: space-evenly;
        max-width: 1200px;
        margin: auto;
        margin-top: 60px;
    }

    .fl-row .sum{
        border-radius: 20px;
        padding: 30px;
        background: #fff;
        width: 40%;
        max-width: 400px;
    }

    .dash-table{
        width: 100%;
    margin-bottom: 20px;
    }

    .dash-table tbody tr, .dash-table2 tbody tr {
    border-bottom: 2px solid #F0F0F3;
}

.dash-table2 {
    width: 100%;
}

    .txt {
        position: absolute;
        bottom: 30px;
        color: #fff;
        left: 40px;
    }

    .txt h2 {
        font-size: 26px !important;
        font-weight: 700 !important;
    }

    .footer-info {
        position: absolute;
        bottom: 0;
        color: #fff;
        background: #2760F0;
        border-radius: 20px;
        max-height: 0;
        box-sizing: border-box;
        transition: max-height 0.15s ease-out;
    }

    .footer-info .arrow {
        padding-left: 38px;
        padding-bottom: 30px;
        display: block;
    }

    .footer-info h2 {
        margin-bottom: 10px;
        font-size: 26px !important;
        font-weight: 700 !important;
        padding: 38px;
        padding-bottom: 10px;
    }

    .img-bg:hover .footer-info {
        max-height: 500px;
        transition: max-height 0.25s ease-out;
    }

    .footer-info p {
        padding: 38px;
        padding-top: 0;
    }

    .mobile-container{
        margin-top: 45px;
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
    border: 2px solid #191919 !important;
    cursor: pointer !important;
    display: inline-block !important;
    opacity: 0.2 !important;
}


.swiper-pagination-bullet-active {
    width: 20px !important;
    height: 20px !important;
    margin: 0 4px !important;
    background-color: #F66608 !important;
    border-radius: 20px !important;
    overflow: hidden !important;
    text-indent: -999em !important;
    border: 2px solid #F66608 !important;
    cursor: pointer !important;
    opacity: 1 !important;
}

.swiper-pagination {

    position: static !important;
    margin: 20px;
    width: auto;
    padding-bottom: 50px;
}
.mobile-container{
    margin-top: 45px;
}

@media (max-width: 979px){
    .fl-row{
        display: none;
    }
}
</style>