
<div class="parent-head">
<ul class="parent_intro">

<?php
$main_mod_array = array_reverse($main_mod_array);

$dashIntroArray = array('title' => 'NETWORK INFORMATION','desc' => 'Get an <b>instant health check</b> of your '.__WIFI_TEXT__.'
network with key performance indicators.
<br><br>
How <b>many visitors</b> are using your '.__WIFI_TEXT__.'?
What <b>day of the week</b> is the most visited?
What <b>hour of the day</b> is most popular?
How much <b>bandwidth</b> is consumed?
What <b>type of OS</b> is used?' , 'links' => array('Network-at-a-Glance'=>'home','Sessions Details'=>'home?t=1','Visitors Report'=>'customer'));

$guestIntroArray = array('title' => 'PUBLIC '.__WIFI_TEXT__,'desc' => 'Easily manage your '.__WIFI_TEXT__.' network settings 
and configuration options.<br><br>
Change the <b>SSID '.__WIFI_TEXT__.' name</b>.
Set your <b>SSID broadcast schedule</b>.
Create a <b>captive portal</b> theme with options
to authenticate via <b>SMS or click & connect</b>.' , 'links' => array('Manage SSID name'=>'network?t=7','Manage broadcast schedule'=>'network?t=2','Manage captive portal theme'=>'theme'));


$filterIntroArray = array('title' => 'FEATURES ','desc' => 'Set the QOS (time and speed) each 
visitor will be assigned upon registration.
<br><br>
Contact your sales agent to activate 
content filtering to keep your visitors
shielded from inappropriate content.
' , 'links' => array('Manage QOS'=>'content_filter?t=12','Manage content filtering'=>'content_filter'));

$profileIntroArray = array('title' => 'PROFILE ','desc' => 'Update your personal contact info used
to reset password in case you forget.
<br><br>
Ability to change the password.' , 'links' => array('Manage my profile'=>'profile'));

$fullintroArray = array('Welcome' =>  $dashIntroArray, 'Guest WiFi' => $guestIntroArray,  'Features' => $filterIntroArray,'Profile' => $profileIntroArray);

$i = 1;
$liTen = '';
$liFull = '';


foreach ($main_mod_array as $keym => $valuem){
		
    $main_menu_name2 = $valuem['name'];
    $modarray = $valuem['module'];
	
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
    
    if($link_main_m_multy!='venue_support'){

        $liFull .= "<li><div class='intro-head'>".$fullintroArray[$main_menu_name2]['title']."</div><div class='intro-content'>".$fullintroArray[$main_menu_name2]['desc']."</div><div class='intro-footer'>".$introFooter."</div></li>";
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

echo "<li ><div class='intro-head'>".$profileIntroArray['title']."</div><div class='intro-content'>".$profileIntroArray['desc']."</div><div class='intro-footer'>".$introFooter."</div></li>";
       
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

</div>

<script>
function manual_slider () {
    return true;
}
</script>
<style>
.parent-head{
    height: 480px;
    width: 100%;
    margin: auto;
    padding-bottom: 60px;
}

.parent_intro{
    height: 500px;
    width: 100%;
    text-align: center;
    margin: auto;
}

.parent_intro li {
    list-style-type: none;
    position: relative;
    display: inline-block;
    width: 20%;
    float: none;
    margin: 5px;
    background:#fff;
    vertical-align: top;
    border: 1px solid #888b8d;
}

.intro-content {
        width: 100%;
    padding: 20px 20px 18px;
    box-sizing: border-box;
    position: static;
    height:260px;
    font-size: 14px;
    color: #333;
    background:#f6f6f6;
    line-height: 1.42857143;
}

.middle{
    color: #6d6e71;
    font-weight: bold;
}

.intro-head{
    color: #fff;
    padding: 14px;
    font-size: 15px;
    font-weight: bold;
}

.intro-footer{
    border-top: 2px solid #b2b2b1;
    /*border-bottom: 2px solid #b2b2b1;*/
    padding-top: 12px;
    min-height: 90px;
    padding-bottom: 10px;
    background: #f6f6f6;
}

.intro-footer span{
    color: #000;
    font-weight: bold;
    font-size: 14px;
    display: block;
    margin-bottom: 10px;
}

.intro-footer a{
    display: block;
    font-size: 13px;
    /*padding-left: 17px;*/
    position: relative;
}

/*.intro-footer a::before{
    content: "";
    background: url('layout/WOW/img/check.png');
    position: absolute;
    width: 20px;
    left: -4px;
    height: 20px;
}*/

.parent_intro li:nth-child(1)  .intro-head{
    background : #eb0f2d;
}

.parent_intro li:nth-child(2)  .intro-head{
    background : #888b8d;
}

.parent_intro li:nth-child(3)  .intro-head{
    background : #eb0f2d;
}

.parent_intro li:nth-child(4)  .intro-head{
    background : #888b8d;
}

/*.parent_intro li  .intro-head{
    background : #eb0f2d;
}*/

.wifi-parent{
    width: 35px;
    text-align: center;
    margin: auto;
    height: 35px;
    line-height: 31px;
    border-radius: 50%;
    background: #58595b;
    margin-bottom: 20px;
}

.wifi-parent img{
    width: 21px;
}

.intro-head img{
    vertical-align: middle;
    width: 23px;
}

@media only screen and (max-width: 1024px) and (min-width: 480px){
    .parent_intro, .parent-head{
        height: auto;
    }

    .parent_intro li{
        width: 70%;
    }

    .parent_intro{
        padding-top: 18px;
    }
    .intro-content{
        height: 210px;
    }
}

@media (max-width: 480px){
    .parent_intro, .parent-head{
        height: auto;
    }

    .parent_intro li{
        width: 90%;
    }

    .parent_intro{
        padding-top: 18px;
    }
}
</style>