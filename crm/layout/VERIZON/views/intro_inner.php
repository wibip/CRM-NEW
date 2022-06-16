<link href="layout/<?php echo $camp_layout; ?>/css/swiper.css?v=1" rel="stylesheet">
<script type="text/javascript" src="layout/<?php echo $camp_layout; ?>/js/swiper.js?v=1"></script>

<div class="parent-head" style="position:relative">
<div class="header_hr" style="top:-20px"></div>
<div class="header_f1" style="margin-bottom: 40px;width: 100%;padding-left: 30px;box-sizing: border-box;">Managed WiFi</div>
<ul class="parent_intro">

<?php
$main_mod_array = array_reverse($main_mod_array);

$dashIntroArray = array('title' => 'Dashboard','desc' => 'Get an instant health check of your '.__WIFI_TEXT__.' network with key performance indicators.' , 'links' => array('Network-at-a-Glance'=>'home','Session Details'=>'home?t=1','Visitors Report'=>'reports'));

$guestIntroArray = array('title' => 'Guest '.__WIFI_TEXT__.' Management','desc' => 'Easily manage your guest '.__WIFI_TEXT__.' network settings 
and configuration options.' , 'links' => array('SSID name'=>'network?t=guestnet_tab_1','Broadcast schedule'=>'network?t=guestnet_schedule','Captive portal'=>'theme'));

$privateIntroArray = array('title' => 'Private '.__WIFI_TEXT__.' Management','desc' => 'Easily manage your private '.__WIFI_TEXT__.' network settings 
and configuration options.' , 'links' => array('SSID name'=>'network_pr?t=10','Broadcast schedule'=>'network_pr?t=2'));

$tenantIntroArray = array('title' => 'Resident ','desc' => 'Easily assist your residents if they have issues with their self care portal. Add new resident accounts manually, reset passwords and register devices.' , 'links' => array('Add Residents'=>'add_tenant','Manage Residents'=>'manage_tenant','Session Management'=>'manage_tenant?t=tenant_session'));


$filterIntroArray = array('title' => 'Features ','desc' => 'Set the QOS (time and speed) each 
visitor will be assigned upon registration.
<br><br>
Contact your sales agent to activate 
content filtering to keep your visitors
shielded from inappropriate content.
' , 'links' => array('Manage QOS'=>'content_filter?t=12','Manage content filtering'=>'content_filter'));

$profileIntroArray = array('title' => 'Profile ','desc' => 'Update your personal contact info used
to reset password in case you forget.' , 'links' => array('Manage my profile'=>'profile'));

$fullintroArray = array('Welcome' =>  $dashIntroArray, 'Tenant' =>  $tenantIntroArray, 'Guest Wi-Fi' => $guestIntroArray, 'Guest WiFi' => $guestIntroArray, 'Private WiFi' => $privateIntroArray,  'Features' => $filterIntroArray,'Profile' => $profileIntroArray);

$i = 1;
$liTen = '';
$liFull = '';


foreach ($main_mod_array as $keym => $valuem){

    if($i>4){
        break;
    }
		
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
    $introFooter = "";
    foreach ($fullintroArray[$main_menu_name2]['links'] as $key => $value) {
        $introFooter .= "<a href=".$value.">".$key."</a>";
    }
    
    if($link_main_m_multy!='venue_support'){

        $liFull .= "<li><div class='intro-img'><img src='layout/VERIZON/img/".$i.".jpg'></div><div class='intro-mid'><div class='intro-head'>".$fullintroArray[$main_menu_name2]['title']."</div><div class='intro-desc'>".$fullintroArray[$main_menu_name2]['desc']."</div><div class='intro-footer'>".$introFooter."</div></div></li>";
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
echo "<li ><div class='intro-img'><img src='layout/VERIZON/img/4.jpg'></div><div class='intro-mid'><div class='intro-head'>".$profileIntroArray['title']."</div><div class='intro-desc'>".$profileIntroArray['desc']."</div><div class='intro-footer'>".$introFooter."</div></div></li>";
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
<div class="swiper-container" style="overflow: inherit">
    <div class="swiper-wrapper">



<?php



$i = 1;
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


 
    //$background_image = 'class="main_intro no-background '.$ss.'"';

    $introFooter = "";
    foreach ($fullintroArray[$main_menu_name2]['links'] as $key => $value) {
        $introFooter .= "<a href=".$value.">".$key."</a>";
    }

    if($link_main_m_multy1!='venue_support'){

 ?>



      <div class="swiper-slide">


      <?php echo "<li><div class='intro-img'><img src='layout/VERIZON/img/".$i.".jpg'></div><div class='intro-mid'><div class='intro-head'>".$fullintroArray[$main_menu_name2]['title']."</div><div class='intro-desc'>".$fullintroArray[$main_menu_name2]['desc']."</div><div class='intro-footer'>".$introFooter."</div></div></li>";
        ?>
      </div>


      <?php

$link_main_m_multy1 = '';

$i++;

}

}
$introFooter = "";
foreach ($profileIntroArray['links'] as $key => $value) {
        $introFooter .= "<a href=".$value.">".$key."</a>";
    }

?>

<div class="swiper-slide">


      <?php echo "<li><div class='intro-img'><img src='layout/VERIZON/img/4.jpg'></div><div class='intro-mid'><div class='intro-head'>".$profileIntroArray['title']."</div><div class='intro-desc'>".$profileIntroArray['desc']."</div><div class='intro-footer'>".$introFooter."</div></div></li>";
        ?>
      </div>


    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
  </div>

</div>

</div>


<style>
    .parent_intro{
        width: 100%;
        padding: 20px;
        padding-left: 30px;
        padding-right: 30px;
        margin: 0;
        box-sizing: border-box;
    }
    .parent_intro >li {
        width: 25%;
        display: inline-block;
        position: relative;
        height: 500px;
        vertical-align: text-bottom;
    }
    .parent_intro li:last-of-type .intro-mid{
            border-right: 1px solid #dedede;
    }
    .intro-head{
        font-family: 'NHaasGroteskDSStd-75Bd';
        font-size: 25px;
        line-height: 25px;
        height: 40px;
        color: #000;
    }
    .intro-desc{
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .intro-mid{
        padding: 20px;
        border-bottom: 1px solid #dedede;
        border-left: 1px solid #dedede;
        height: 261px;
        -o-transition: .5s;
        -ms-transition: .5s;
        -moz-transition: .5s;
        -webkit-transition: .5s;
        transition: .5s;
        position: relative;
    }
    .intro-mid:hover{
        border-bottom: 5px solid #d52b1e;
        margin-top: -20px;
    }
    .intro-footer {
        position: absolute;
        top: 210px;
    }
    .intro-footer a{
        padding-right: 20px;
        position: relative;
        -webkit-transition: padding .25s ease-out;
           -o-transition: padding .25s ease-out;
           -ms-transition: padding .25s ease-out;
           -moz-transition: padding .25s ease-out;
           transition: padding .25s ease-out;
        font-family: 'NHaasGroteskDSStd-75Bd';
        font-size: 15px;
        display: table;
        padding-top: 3px;
        padding-bottom: 3px;
    }
    .intro-footer a::after{
        font-family: FontAwesome;
        font-weight: normal;
        font-style: normal;
        text-decoration: inherit;
        -webkit-font-smoothing: antialiased;
        content: "\f105";
        position: absolute;
        right: 7px;
        top: 3px;
        font-size: 16px;
    }
    .intro-footer a:hover{
        text-decoration: none;
        padding-right: 30px;
    }
    .intro-img img{
        max-width: 100%;
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
    width: 32px !important;
    height: 2px !important;
    margin: 0 4px !important;
    background: #000 !important;
    border-radius: 0px !important;
    overflow: hidden !important;
    text-indent: -999em !important;
    border:none !important;
    cursor: pointer !important;

    display: inline-block !important;

    opacity: 0.2 !important;
}


.swiper-pagination-bullet-active {
    width: 32px !important;
    height: 2px !important;
    margin: 0 4px !important;
    background-color: #000 !important;
    border-radius: 0px !important;
    overflow: hidden !important;
    text-indent: -999em !important;
    border: none !important;
    cursor: pointer !important;
    opacity: 1 !important;

}

.swiper-pagination {
    margin-bottom: 100px;
    position: static !important;

}
@media (max-width: 979px){
.intro-footer{
    position: static;
}
.intro-mid{
    height: auto 
}
.intro-img img{
    width: 100%;
}
.intro-mid{
    border-bottom: none;
}
}

@media (min-width: 521px){
    .header_hr {
        margin-left: 30px;
    }
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