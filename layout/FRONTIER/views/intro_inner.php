

<h1 class="head">
    Portal Overview
</h1>
<div class="parent-head">
<ul class="parent_intro">

<?php

$dashIntroArray = array('img' => '','desc' => 'Dashboard' , 'extra' => "<p>Get a snapshot of your network
performance.</p>",'class' => 'dash','txt' => 'dashboard');

$tenantIntroArray = array('img' => '','desc' => 'Resident' , 'extra' => "<p><a href='add_tenant' class=''>Manual Registration</a>, <a href='manage_tenant'>Account Management</a>, <a href='manage_tenant?tab=session' class=''>Session Management</a></p>",'class' => 'tenant','txt' => 'tenant');

$guestIntroArray = array('img' => '','desc' => 'Guest '.__WIFI_TEXT__ , 'extra' => "<p>Create a registration portal and create an optional campaign and much more.</p>",'class' => 'guest','txt' => 'guest '.__WIFI_TEXT__);

$privateIntroArray = array('img' => '','desc' => 'Private '.__WIFI_TEXT__ , 'extra' => "<p>Use this separate network for POS, printers and employees.</p>",'class' => 'private','txt' => 'private '.__WIFI_TEXT__);

$configIntroArray = array('img' => '','desc' => 'Features' , 'extra' => "<p>Create a network management
schedule. Order and
activate content filtering.</p>",'class' => 'feature','txt' => 'features');

$fullintroArray = array('Welcome' =>  $dashIntroArray, 'Tenant' =>  $tenantIntroArray, 'Guest WiFi' => $guestIntroArray, 'Guest Wi-Fi' => $guestIntroArray, 'Private WiFi' => $privateIntroArray, 'Features' => $configIntroArray);



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


 <li <?php echo $background_image; ?>>
	<div class="intro-content">
		<h2 class="<?php echo $fullintroArray[$main_menu_name2]['class']; ?>"><?php echo $fullintroArray[$main_menu_name2]['desc']; ?></h2>
        <div class="slider-content">
		<?php echo $fullintroArray[$main_menu_name2]['extra']; ?>
		<a class="btn btn-primary" style="" href="<?php  if($link_main_m_multy=='intro'){ echo 'home'; }else{ echo $link_main_m_multy; } ?>">See <?php echo $fullintroArray[$main_menu_name2]['txt']; ?></a>
    </div>
	</div>
 </li>

<?php

$link_main_m_multy = '';

$i++;

}

}


 ?>


</ul>



</div>


<style type="text/css">

.intro-content h2{
        margin-bottom: 10px;
            color: #0c4269;
}

.main_intro .intro-content{
    background-color: #ffffff;
}
.intro-content li{
    font-size: 15px;
    line-height: 20px;
}

.btn{
    padding: 5px 12px !important;
}

    @supports (-webkit-overflow-scrolling: touch) { /* CSS specific to iOS devices */ body{ cursor:pointer; } }


h1.head {
    padding: 50px;
    padding-left: 0px;
    width: 960px !important;
    margin: auto;
    font-size: 32px;
    text-align: left;
    color: #000;
    box-sizing: border-box;
}

h1.head span{
        display: inline-block;
}

h1.head span:nth-child(1){
        margin-left: -10px;
}



.btn-primary:after{
     content: "\f054";
    font-family: FontAwesome;
    display: inline-block;
    float: right;
    color: #ffffff;
    margin-left: 10px;
}

@media (min-width: 481px){
.slider-content{
    display: block;
}
}

@media (max-width: 480px){

    .parent-head{
        margin-left: -20px;
        margin-right: -20px;
    }

    html{
            overflow-x: hidden;
    }

    .main_intro{
        /*height: 340px !important;*/
    }

    .parent_intro .intro-content p{
        font-size: 14px !important;
    }

    .intro-content{
        padding: 20px !important;
    padding-right: 20px !important;
    }

    h1.head{
            padding-right: 25px !important;
            padding-left: 25px !important;
    }

    h2:after{
        content: "\f078";
    font-family: FontAwesome;
    display: inline-block;
    float: right;
    color: #0091b3;
}

h2.slide-hide:after{
    content: "\f077";
}

.intro-content h2{
    margin-bottom: 0px;
}

.slider-content{
    display: none;
}

.intro-content{
    cursor: pointer;
}

.intro-content h2{
    font-size: 21px !important;
}

}

@media (max-width: 420px){
    .main_intro{
        /*height: 340px !important;*/
    }
}

@media (max-width: 979px){

    .intro_page{
        display: none !important;
    }


    h1.head{
        padding-bottom: 20px !important;
        width: auto !important;
            font-size: 28px !important;
    }

}

    .intro_page{

    <?php

    if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
        echo 'height: 337px;margin-top: -35px;background-size: 100%;';
    }

     ?>

     height: 300px !important;
    margin-top: -35px !important;
    background-repeat: no-repeat;
    background-size: cover !important;
    background-position: center !important;


    }

    .intro-content p{
        color: #58595b !important;
    }
    .intro_page_txt{
           /* width: 960px;*/
            margin: auto;
            text-align: center;
            /* left: 20%; */
            padding-top: 70px;
    }

    .intro_page_txt h1{
        font-size: 47px;
        color: #fff;
        line-height: 50px;
    }

    .intro_page_txt h2{
        font-size: 36px;
        color: #fff;
        line-height: 45px;
    }

    .intro-content a{
        /*position: absolute;
    bottom: 20px;*/
    }

    .intro-content{
        position: relative;
    }



@media (min-width: 980px){

   /* .intro_page{
        margin-top: 60px !important;
    }*/

}
 </style>


 <style type="text/css">
 .intro-content h2:before {

        content: '';
        background-color: #0091b3;
    background-repeat: no-repeat;
    background-position: center;
    background-size: 60%;
    width: 40px;
    height: 40px;
    vertical-align: middle;
    border-radius: 50%;
    margin-right: 5px;
    display: inline-block;
}

.intro-content h2.dash:before {
    background-image: url(layout/FRONTIER/img/analytics.svg);
}
.intro-content h2.tenant:before {
    background-image: url(layout/FRONTIER/img/new-user.svg);
}
.intro-content h2.guest:before {
    background-image: url(layout/FRONTIER/img/deal.svg);
}
.intro-content h2.private:before {
    background-image: url(layout/FRONTIER/img/wifi.svg);
}
.intro-content h2.feature:before {
    background-image: url(layout/FRONTIER/img/calendar.svg);
}
.top-bar{
    background: #f2f2f2;
}
body{
    background: #ffffff !important;
}

.parent_intro{
        margin: auto;
        /*margin-top: 50px;*/
            /*margin-bottom: 50px;*/
    }

.parent-head{
            background: #f2f2f2;
    /* margin-top: 150px; */
    padding-bottom: 3px;
    padding-top: 25px;
    /* margin-bottom: 20px; */
    border-bottom: 40px solid white;
    }

.main_intro{
    margin-right: -4px;
        /*height: 220px;*/
        display: inline-block;
        background-repeat: no-repeat;
    overflow: hidden;

    margin-bottom: 17px;
}

/*
.main_intro:nth-child(1){
        background-position: 100% 0;
        background-size: contain;

}*/

@media (min-width: 980px){

    /*.main_intro:nth-child(1){
        width: 785px;
    }*/

    .parent_intro{
        width: 960px;
    }

    .main_intro{
         width: 400px;
    }

.main_intro:nth-child(2){
       float: right;

}

.main_intro:nth-child(4){
     float: right;
}
}


.intro-content{
    width: 65%;
    padding: 30px;
    padding-right: 20px;
    height: 100%;
    float: left;
    -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-size: 16px;
    color: #ffffff !important;
}

.intro-content h1{
        margin-bottom: 30px;
    color: #000;
    font-size: 32px;
}

.intro-content p{
    font-size: 16px !important;
    font-weight: normal !important;
    padding-top: 8px;
    padding-bottom: 8px
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
        /*padding-left: 20px;
    padding-right: 20px;*/
        box-sizing: border-box;
    width: 100%;
    margin-bottom: 0px
    }

    .main_intro.img-only {
    background-size: 90%;
    background-position: center;
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
    margin-bottom: 30px;
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
    border: 2px solid #000;
    cursor: pointer;
}

.mobile-menu li.clicked{
    background: #000;
}

</style>

<script type="text/javascript">
    function manual_slider() {

   /* var index = $('.mobile-menu li.clicked').index();
    index = index +1;

    if($(window).width() < 980 ){

        $('.parent_intro li:not(.parent_intro li:nth-child('+ index +')):not(.mobile-menu li):not(.li)').hide();
        $('.mobile-menu').show();
        $('.img-only').css('width', '100%');

    }else{
        $('.parent_intro li:not(.mobile-menu li):not(.li)').show();
        $('.mobile-menu').hide();
        $('.img-only').css('width', '304px');
    }*/

}

$('.intro-content').click(function(event) {
    if($(window).width() < 480 ){
        var that = this;
            $(this).children('.slider-content').toggle('slow', function(){
                if($(that).children('.slider-content').is(':hidden')){
                    $(that).children('h2').removeClass('slide-hide');
                }else{
                    $(that).children('h2').addClass('slide-hide');
                }
            });
    }
});
</script>
