<style>
    div .intro-icon img{
        padding-top: 28px;
        margin-bottom: -15px;
        max-width: 50px;
    }
</style>
<div class="parent-head">
<ul class="parent_intro">

<?php
$main_mod_array = array_reverse($main_mod_array);
//print_r($main_mod_array);

$dash_links = [
    'Network-at-a-Glance'=>'home',
    'Sessions Details'=>'home?t=1',
];

if(in_array('customer',$allowed_pages)){
    $dash_links['Visitors Report'] = 'customer';
}
$dashIntroArray = array('title' => 'NETWORK INFORMATION','desc' => 'Get an instant health check of your '.__WIFI_TEXT__.'
network with key performance indicators.
<br><br>
How many visitors are using your '.__WIFI_TEXT__.'?
What day of the week is the most visited?
What hour of the day is most popular?
How much bandwidth is consumed?
What type of OS is used?' , 'links' => $dash_links, 'icon'=>'network_icon.png');

$guestIntroArray = array('title' => 'GUEST '.__WIFI_TEXT__,'desc' => 'Easily manage your '.__WIFI_TEXT__.' network settings 
and configuration options.<br><br>
Change the SSID '.__WIFI_TEXT__.' name.
Set your SSID broadcast schedule.
Create a captive portal theme with options
to authenticate via SMS or click & connect.' , 'links' => array('Manage SSID name'=>'network?t=guestnet_tab_1','Manage broadcast schedule'=>'network?t=guestnet_schedule','Manage captive portal theme'=>'theme'),'icon'=>'guest_icon.png');

$privateIntroArray = array('title' => 'PRIVATE '.__WIFI_TEXT__,'desc' => 'Your private network is a separate network from the guest and the resident networks. <br><br> Easily manage the network including changing SSID names, show or hide the SSID broadcast and set the WPA2 password.' , 'links' => array('Manage Private Network'=>'network_pr'),'icon'=>'private_icon.png');

$vTenantArray = array('title' => 'RESIDENT','desc' => 'Easily assist your residents if they have issues with their self care portal. Add new resident accounts manually, reset passwords and register devices. 
<br><br>In case residents have issues with a session you can reset the session and remove the device to allow them to reinitiate the session.' , 'links' => array('Manual Registration'=>'add_tenant','Account Management'=>'manage_tenant','Session Management'=>'manage_tenant?t=tenant_session'),'icon'=>'resident_icon.png');

$filterIntroArray = array('title' => 'FEATURES ','desc' => 'Set the QOS (time and speed) each 
visitor will be assigned upon registration.
<br><br>
Contact your sales agent to activate 
content filtering to keep your visitors
shielded from inappropriate content.
' , 'links' => array('Manage QOS'=>'content_filter?t=12'));

$profileIntroArray = array('title' => 'PROFILE ','desc' => 'Update your personal contact info used
to reset password in case you forget.
<br><br>
Ability to change the password.' , 'links' => array('Manage my profile'=>'profile'),'icon'=>'profile_icon.png' );

$fullintroArray = array('Welcome' =>  $dashIntroArray, 'Guest WiFi' => $guestIntroArray,  'Features' => $filterIntroArray,'Profile' => $profileIntroArray,  'Private WiFi' => $privateIntroArray,'Tenant' => $vTenantArray);

$i = 1;
$liTen = '';
$liFull = '';

//print_r($main_mod_array);
foreach ($main_mod_array as $keym => $valuem){
		
    $main_menu_name2 = $valuem['name'];
    $modarray = $valuem['module'];

    if(!isset($fullintroArray[$main_menu_name2]))
    {
        //echo $main_menu_name2.'-';
        continue;
    }

	//if($main_menu_name2 != 'Public WiFi'){
	

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


    if($link_main_m_multy=='intro'){
        $link_main_m_multy = 'home';
    }
    $introFooter = "<span>Jump directly to section: </span>";
    foreach ($fullintroArray[$main_menu_name2]['links'] as $key => $value) {
        $introFooter .= "<a href=".$value.">".$key."</a>";
    }
    
    if($link_main_m_multy!='venue_support' && $i<5){

        $liFull .= "<li><div><div class='intro-head'>".$fullintroArray[$main_menu_name2]['title']."</div>
                    <dev class=\"intro-icon\"><img src=\"layout/DYNAMIC/img/".$fullintroArray[$main_menu_name2]['icon']."\" ></dev>
                    <div class='intro-content'>".$fullintroArray[$main_menu_name2]['desc']."</div><div class='intro-footer'>".$introFooter."</div></div></li>";
        $link_main_m_multy = '';
        $i++;

    }
        $introFooter = "";
		
	//}
    }
	
echo $liFull;
echo $liTen;

foreach ($profileIntroArray['links'] as $key => $value) {
        $introFooter .= "<a href=".$value.">".$key."</a>";
    }

    if($i<5){
        $i++;
        echo "<li ><div><div class='intro-head'>".$profileIntroArray['title']."</div><dev class=\"intro-icon\"><img src=\"layout/DYNAMIC/img/".$profileIntroArray['icon']."\" ></dev><div class='intro-content'>".$profileIntroArray['desc']."</div><div class='intro-footer'>".$introFooter."</div></div></li>";
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
echo '<style> .parent_intro li{  width: '.(100/($i-1)).'%; } </style>';
 ?>


</ul>

</div>

<script>
function manual_slider () {
    return true;
}
</script>
