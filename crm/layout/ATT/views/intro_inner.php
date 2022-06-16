<link href="layout/<?php echo $camp_layout; ?>/css/swiper.css?v=26" rel="stylesheet">
<script type="text/javascript" src="layout/<?php echo $camp_layout; ?>/js/swiper.js?v=3"></script>
<!-- <h1 class="head">
    Take Charge Of Your Optimum WiFi Hotspot
</h1> -->
<div class="divhead">
    <h3>Quicklinks</h3>

    <?php if($user_type == 'MNO'){ ?>

        <div class="headbtn">
       <a href="location">Create Properties</a>
        <a href="config?t=21">Email Templates</a>
        <a href="terms">Resident Theme</a>
        <a href="session">Session Search</a>
        <!-- <a>Network at-a-Glance</a>
        <a>vTenant Management</a>
        <a>Theme Management</a>
        <a>Campaign Management</a> -->
    </div>

    <?php }else{ ?>
    <div class="headbtn">
        <a href="add_tenant">Add Resident</a>
        <a href="manage_tenant">Manage Existing Residents</a>
        <a href="communicate">Communicate With Residents</a>
        <a href="manage_tenant?tab=session">Device Session Search</a>
        <!-- <a>Network at-a-Glance</a>
        <a>vTenant Management</a>
        <a>Theme Management</a>
        <a>Campaign Management</a> -->
    </div>
<?php } ?>
</div>

<div class="parent-head">


    <div class="parent-h">
        
        <h2>Explore AT&T Managed <?php echo __WIFI_TEXT__; ?></h2>
        <h1>The tools and features you need to manage your <?php echo __WIFI_TEXT__; ?></h1>

    </div>

    <ul class="parent_intro">

<?php

$dashIntroArray = array('img' => '1.png','desc' => 'Dashboard' , 'extra' => "<p>Network-at-a Glance, Detailed statistics & Reports
  </p>");

$guestIntroArray = array('img' => '3.png','desc' => 'Guest '.__WIFI_TEXT__ , 'extra' => "<p>SSID & Password , Schedule, Themes and Campaigns</p>
</p>");

$privateIntroArray = array('img' => '4.png','desc' => 'Private '.__WIFI_TEXT__ , 'extra' => "<p>Encrypted SSID Schedule</p>");

$configIntroArray = array('img' => '5.png','desc' => 'Features' , 'extra' => "<p>QoS & Content Filtering</p>");

$locationIntroArray = array('img' => '2.png','desc' => 'Properties' , 'extra' => "<p>Set type of property and enable special features, Manage Sessions, AUP & Blacklist. 
  </p>");

$configurationIntroArray = array('img' => '6.png','desc' => 'Configuration' , 'extra' => "<p>Activation T & Cs, Email Templates & Tenant Theme create and Preview.</p>
</p>");

$RolesIntroArray = array('img' => '8.png','desc' => 'Roles' , 'extra' => "<p>Create ACLs for Regular Admins and Master Peers, Master Support, and Master Tech Admins.</p>");

$logsIntroArray = array('img' => '7.png','desc' => 'Logs' , 'extra' => "<p>Simple access log to track Operation Admin visits.</p>");

$vTenantArray = array('img' => '2.png','desc' => 'Tenantr' , 'extra' => "<p><a href='add_tenant' class='sp-link'>Manual Registration</a>, <a href='manage_tenant' class='sp-link'>Account Management</a>, <a href='manage_tenant?tab=session' class='sp-link'>Session Management</a></p>");

if(($package_functions->getOptions('VTENANT_MODULE',$system_package)=='Vtenant') && ($user_type != 'MNO')){
$fullintroArray = array('Tenant' => $vTenantArray,'Welcome' =>  $dashIntroArray, 'Guest WiFi' => $guestIntroArray, 'Private WiFi' => $privateIntroArray, 'Features' => $configIntroArray, 'Tenant' => $vTenantArray, 'Properties' => $locationIntroArray, 'Configuration' => $configurationIntroArray, 'Roles' => $RolesIntroArray, 'Logs' => $logsIntroArray);

}else{

$fullintroArray = array('Welcome' =>  $dashIntroArray, 'Guest WiFi' => $guestIntroArray, 'Private WiFi' => $privateIntroArray, 'Features' => $configIntroArray, 'Tenant' => $vTenantArray, 'Properties' => $locationIntroArray, 'Configuration' => $configurationIntroArray, 'Roles' => $RolesIntroArray, 'Logs' => $logsIntroArray);
}


/* print_r($fullintroArray); */

$i = 1;
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


    $background_image = 'class="main_intro no-background '.$ss.'"';
    


    if($link_main_m_multy!='venue_support'){

 ?>

 <?php if(($package_functions->getOptions('VTENANT_MODULE',$system_package)=='Vtenant') && ($user_type != 'MNO')){ 
     
     if($link_main_m_multy !='intro'){
     ?>
 <li <?php echo $background_image; ?>>
	<div class="intro-content">
        <a href="<?php  if($link_main_m_multy=='intro'){ echo 'home'; }else{ echo $link_main_m_multy; } ?>">
            <img src="layout/ATT/img/<?php echo $fullintroArray[$main_menu_name2]['img']; ?>">
            <span class="lg"><?php echo $fullintroArray[$main_menu_name2]['desc']; ?></span>
            <span class="sm"><?php echo $fullintroArray[$main_menu_name2]['extra']; ?></span>
        </a>
	</div>
 </li>

<?php } }else{ 

    if($link_main_m_multy !='intro'){
     ?>

    <li <?php echo $background_image; ?>>
	<div class="intro-content">

        <a href="<?php  if($link_main_m_multy=='intro'){ echo 'home'; }else{ echo $link_main_m_multy; } ?>">
            <img src="layout/ATT/img/<?php echo $fullintroArray[$main_menu_name2]['img']; ?>">
            <span class="lg"><?php echo $fullintroArray[$main_menu_name2]['desc']; ?></span>
            <span class="sm"><?php echo $fullintroArray[$main_menu_name2]['extra']; ?></span>
        </a>
	</div>
 </li>

<?php } } ?>
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




    if($link_main_m_multy1!='venue_support'){




 ?>



      

        <?php if(($package_functions->getOptions('VTENANT_MODULE',$system_package)=='Vtenant') && ($user_type != 'MNO')){ 
     
     if($link_main_m_multy1 !='intro'){
      ?>
<div class="swiper-slide">

      <li <?php echo $background_image; ?>>
	<div class="intro-content">
		<a href="<?php  if($link_main_m_multy=='intro'){ echo 'home'; }else{ echo $link_main_m_multy; } ?>">
            <img role="<?php echo $link_main_m_multy1; ?>" src="layout/ATT/img/<?php echo $fullintroArray[$main_menu_name2]['img']; ?>">
            <span class="lg"><?php echo $fullintroArray[$main_menu_name2]['desc']; ?></span>
            <span class="sm"><?php echo $fullintroArray[$main_menu_name2]['extra']; ?></span>
        </a>
	</div>
 </li>

 </div>

 <?php } }else{ 

    if($link_main_m_multy1 !='intro'){
     ?>

     <div class="swiper-slide">

      <li <?php echo $background_image; ?>>
    <div class="intro-content">
        <a href="<?php  if($link_main_m_multy=='intro'){ echo 'home'; }else{ echo $link_main_m_multy; } ?>">
            <img src="layout/ATT/img/<?php echo $fullintroArray[$main_menu_name2]['img']; ?>">
            <span class="lg"><?php echo $fullintroArray[$main_menu_name2]['desc']; ?></span>
            <span class="sm"><?php echo $fullintroArray[$main_menu_name2]['extra']; ?></span>
        </a>
    </div>
 </li>

 </div>

<?php } } ?>

      


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

.parent-h h2{
    text-align: center;
    font-family: 'font-bold';
}

.parent-h h1{
    font-family: Regular;
    text-align: center;
}

.parent-h{
    margin-bottom: 50px;
}

.divhead{
    background: #0568ae;
    color: #fff;
    height: 140px;
    padding-top: 20px;
    padding-bottom: 20px;
    box-sizing: border-box;
}

.divhead a{
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    font-size: 17px;
    color: white;
    background-color: transparent;
    border-radius: 25px;
    border: 2px solid white;
    font-family: Regular;
    min-width: 250px;
    margin-left: 20px;
    padding: 10px;
    display: inline-block;

}

.divhead a:nth-child(1) {
    margin-left: 0px;
}

.divhead h3{
    font-family: 'font-bold';
    text-align: center;
}

.headbtn{
    margin: auto;
    text-align: center;
    margin-top: 20px;
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
padding: 30px;
padding-right: 0px;
padding-left: 0px;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #fff;
    font-family: Rmedium;
    background: #0568ae;
}

.parent_intro{
        margin: auto;
        text-align: center;
    }

.parent-head{
        background: #fff;
    padding-top: 80px;
    /*margin-top: 150px;*/
    /*padding-bottom: 33px;*/
    }

.main_intro{
    margin-right: -4px;
        height: 300px;
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

  /*  .main_intro:nth-child(1){
        width: 785px;
    }*/

    .parent_intro{
        width: 600px;
    }

    .main_intro{
         width: 300px;
    }

.main_intro:nth-child(2){
        /*margin-left: 24px;*/

}

.main_intro:nth-child(4), .main_intro:nth-child(5){
       /* margin-left: 24px;*/

}

.main_intro:nth-child(7), .main_intro:nth-child(8){
    /*margin-left: 20px;*/
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
            font-size: 14px;
    color: #3a383d !important;
    font-family: Regular;
}



.intro-content p{
    font-family: Regular !important;
font-size: 18px !important;
font-weight: normal !important;
}


.intro-content a img{
    margin: auto;
    margin-bottom: 20px;
    display: block;
}

.intro-content .lg{
    font-family: Rmedium;
color: #000;
}
.intro-content a:not(.sp-link){
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

    .main_intro.img-only {
    background-size: 90%;
    background-position: center;
}

    .parent_intro li:nth-child(1){
        background-image: none !important;
    }

    .divhead a{
        width: 80%;
        margin-bottom: 10px;
        margin-left: 0px;
    }
    .divhead{
        height: 340px;
        padding-top: 60px;
        margin-left: -20px;
        margin-right: -20px;
    }

    .parent-head{
        padding-top: 20px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .parent-h{
        margin-bottom: 20px;
    }

    .parent-h h1, .parent-h h2{
        font-size: 16px;
        line-height: 20px;
        margin-bottom: 10px;
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
    background: #322222 !important;
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
    background-color: #000 !important;
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
