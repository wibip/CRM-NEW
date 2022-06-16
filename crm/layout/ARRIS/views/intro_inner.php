<link href="layout/<?php echo $camp_layout; ?>/css/swiper.css?v=26" rel="stylesheet">
<script type="text/javascript" src="layout/<?php echo $camp_layout; ?>/js/swiper.js?v=3"></script>
<!-- <h1 class="head">
    Portal Overview
</h1> -->
<div class="parent-head">
<ul class="parent_intro">

<?php

$main_mod_array = array_reverse($main_mod_array);

$dashIntroArray = array('img' => '1.jpg','desc' => 'DASHBOARD' , 'extra' => "NETWORK STATUS AND USAGE INFORMATION<span class='ar-right'></span>");

$guestIntroArray = array('img' => '2.jpg','desc' => 'GUEST '.__WIFI_TEXT__ , 'extra' => "GUEST ACCESS AND MARKETING<span class='ar-right'></span>");

$privateIntroArray = array('img' => '4.jpg','desc' => 'PRIVATE '.__WIFI_TEXT__ , 'extra' => "SEPARATE AND SECURE NETWORK FOR YOUR BUSINESS<span class='ar-right'></span>");

$vTenantArray = array('img' => '5.jpg','desc' => 'TENANT ' , 'extra' => "ACCOUNT MANAGEMENT<span class='ar-right'></span>");

$configIntroArray = array('img' => '3.jpg','desc' => 'FEATURES' , 'extra' => "FILTERING AND SCHEDULING<span class='ar-right'></span>");

$fullintroArray = array('Welcome' =>  $dashIntroArray, 'Guest WiFi' => $guestIntroArray, 'Features' => $configIntroArray, 'Private WiFi' => $privateIntroArray,'Tenant' => $vTenantArray);

$splashIntroArray = array('class' => 'txt-only','img' => '','desc' => 'Splash Page' , 'extra' => "<p>Customize the splash portal page to accommodate the themes of your business. Your guests will see your branding and advertisement when they connect to your Guest ".__WIFI_TEXT__." network.</p><p>Explore multiple sign-in options for your guests, including personalized messages or a redirect to your business' website.</p>",'link' => 'theme');

$img1IntroArray = array('class' => 'img-only', 'img' => '3.jpg','desc' => '' , 'extra' => "");

$campaignIntroArray = array('class' => 'txt-only','img' => '','desc' => 'Campaigns' , 'extra' => "<p>Engage with your guests when they connect to your ".__WIFI_TEXT__." network. Display an image with a message similar to a social media post, either informational or commercial in nature. For example, 'Please join us on Wednesday nights for Open Mic Night!' or 'Come to our Happy Hour every day between 5pm - 7pm and enjoy our 2 for 1 cocktails!'
</p>", 'link' => 'campaign');

$img2IntroArray = array('class' => 'img-only', 'img' => '4.jpg','desc' => '' , 'extra' => "");

$additionalArray = array('3' =>  $splashIntroArray, '4' => $img1IntroArray, '5' => $campaignIntroArray, '6' => $img2IntroArray);

$i = 1;
$liTen = '';
$liFull = '';

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


    	$background_image = 'style="background-image: url(layout/ARRIS/img/'.$fullintroArray[$main_menu_name2]['img'].');" class="main_intro '.$ss.'" ';
    }
    else{
    	$background_image = 'class="main_intro no-background '.$ss.'"';
    }

    if($link_main_m_multy=='intro'){
        $link_main_m_multy = 'home';
    }
    

    if($link_main_m_multy!='venue_support'){

          if($main_menu_name2=='Tenant'){
            $liTen = "<li ".$background_image."><div class='intro-content'><a href='".$link_main_m_multy."'><b>".$fullintroArray[$main_menu_name2]['desc'].": </b>".$fullintroArray[$main_menu_name2]['extra']."</a></div></li>";
          }else{
            $liFull .= "<li ".$background_image."><div class='intro-content'><a href='".$link_main_m_multy."'><b>".$fullintroArray[$main_menu_name2]['desc'].": </b>".$fullintroArray[$main_menu_name2]['extra']."</a></div></li>";
          }


$link_main_m_multy = '';

$i++;

}

}

echo $liFull;
echo $liTen;

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

    if(strlen($fullintroArray[$main_menu_name2]['img']) > 0){


    	$background_image = 'style="background-image: url(layout/ARRIS/img/'.$fullintroArray[$main_menu_name2]['img'].');" class="main_intro '.$ss.'" ';
    }
    else{
    	$background_image = 'class="main_intro no-background '.$ss.'"';
    }
 
    //$background_image = 'class="main_intro no-background '.$ss.'"';



    if($link_main_m_multy1!='venue_support'){

 ?>



      <div class="swiper-slide">


      <li <?php echo $background_image; ?>>
	<div class="intro-content">
		<a href="<?php  if($link_main_m_multy1=='intro'){ echo 'home'; }else{ echo $link_main_m_multy1; } ?>"><b><?php echo $fullintroArray[$main_menu_name2]['desc']; ?>: </b> <?php echo $fullintroArray[$main_menu_name2]['extra']; ?></a>
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





.contact{
    font-size: 16px;
    font-family: Rregular;
    color: #fff;
        margin-right: 50px;
}

.call span:not(.glyph), .footer-live-chat-link span:not(.glyph){
    font-family: Regular;
    font-size: 20px;
    color: #fff;
}

.number{
    font-family: Regular;
    font-size: 20px;
}

.footer-live-chat-link{
        display: inline-block;
    margin-left: 50px;
}

.call a{
    font-family: Regular;
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
        /*padding-bottom: 120px !important;*/
}

h1.head{
padding: 60px;
padding-right: 0px;
padding-left: 0px;
    margin: auto;
    font-size: 34px;
    text-align: left;
    color: #e87722;
    font-family: Regular;
}

.parent_intro{
        margin: auto;
        /*margin-top: 50px;*/
            /*margin-bottom: 50px;*/
    }

.parent-head{
        background: #fff;
    margin-top: 110px;
    padding-bottom: 33px;
    }

.main_intro{
    margin-right: -4px;
        height: 295px;
        display: inline-block;
        background-repeat: no-repeat;
    overflow: hidden;
        position: relative;
    margin-bottom: 17px;
}

.main_intro{
        background-position: 100% 0;
        background-size: 100%;

}
@media screen and (max-width: 1024px) and (min-width: 980px){
    .parent_intro{
        max-width: 100%;
        margin-left: 2px;
    }


    .main_intro{
         width: 500px !important;
         background-size: cover !important;
    }


}

@media (min-width: 980px){

    .main_intro:nth-child(4){
        width: 385px;
    }
    .main_intro:nth-child(3){
        
        width: 780px;
    }

    .parent_intro{
        width: 1200px;
    }

    .main_intro{
         width: 580px;
    }

.main_intro:nth-child(2){
        margin-left: 24px;

}

.main_intro:nth-child(4){
        margin-left: 24px;

}

.main_intro:nth-child(7), .main_intro:nth-child(8){
    margin-left: 20px;
}
}




.intro-content{
    background-color: rgba(0,0,0,.65);
    width: 100%;
    height: 50px;
    bottom: 0px;
    padding-left: 20px;
    padding: 20px;
    -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-size: 16px;
    color: #3a383d !important;
    font-family: Rregular;
    display: inline-table;
    vertical-align: middle;
}

.intro-content h1{
        margin-bottom: 30px;
               font-family: Regular;
    color: #000;
    font-size: 32px;
}

.intro-content p{
    font-family: Regular !important;
    font-size: 12pt !important;
    font-weight: normal !important;
}




.intro-content a{
    font-size: 16px;
    color: #ffffff;
    font-family: Regular !important;
}

.intro-content a:hover{
color: #e87722;
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
}



@media screen and (max-width: 768px) and (min-width: 481px){

    .parent-head{
        padding: 20% 0;
        margin-top: 0px !important
    }

    .main_intro{
        height: 400px !important;
        background-size: cover !important;
        padding-right: 0px;
        padding-left: 0px;
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
    background: #595959 !important;
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
    background-color: #ed9655 !important;
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
