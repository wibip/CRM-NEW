<?php
$page_img_url = 'layout/'.$camp_layout.'/img/'.$script.'_page_image.jpg';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


echo '<div class="intro_page" style="position: relative">';

if ($property_business_type=='ENT') {
	switch ($script) {
		case 'home':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Enterprise Managed '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'network':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';

			break;

		case 'intro':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Enterprise Managed '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'campaign':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';

			break;

		case 'power_schedule':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Enterprise Managed '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'customer':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Enterprise Managed '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'theme':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';

			break;

		case 'network_pr':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Private '.__WIFI_TEXT__.' Management</h1></div>';

			break;

		case 'venue_support':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Support & Resources</h1></div>';

			break;

		case 'properties':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Master Business Admin</h1></div>';

			break;

		case 'profile':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Profile</h1></div>';

			break;

		case 'tech':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Installation Assistant</h1></div>';

			break;


		case 'network_mdo':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Mobile Data Offload</h1></div>';

			break;

		case 'manage_tenant':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Manage Residents</h1></div>';

			break;

		case 'add_tenant':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Add Resident</h1></div>';

			break;
		case 'communicate':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Communicate</h1></div>';

			break;


		default:

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Features</h1></div>';

			break;
	}
}else{
		case 'home':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Optimum Business SMART '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'network':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';

			break;

		case 'intro':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Optimum Business SMART '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'campaign':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';

			break;

		case 'power_schedule':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Optimum Business SMART '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'customer':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Optimum Business SMART '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'theme':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';

			break;

		case 'network_pr':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Private '.__WIFI_TEXT__.' Management</h1></div>';

			break;

		case 'venue_support':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence Portal</h2><h1>Support & Resources</h1></div>';

			break;

		case 'properties':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Master Business Admin</h1></div>';

			break;

		case 'profile':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Profile</h1></div>';

			break;

		case 'tech':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Installation Assistant</h1></div>';

			break;


		case 'network_mdo':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Mobile Data Offload</h1></div>';

			break;

		case 'manage_tenant':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Manage Residents</h1></div>';

			break;

		case 'add_tenant':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Add Resident</h1></div>';

			break;
		case 'communicate':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Communicate</h1></div>';

			break;


		default:

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence  Portal</h2><h1>Features</h1></div>';

			break;
	}

	echo '</div>';

 ?>

 <style type="text/css">


 	.intro_page{

 	<?php

 	if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
        echo 'height: 337px;margin-top: -35px;background-size: 100%;';
	}

 	 ?>

 	 height: 400px !important;
    margin-top: -41px ;
    background-repeat: no-repeat;
    background-size: cover !important;
    background-position: center !important;


	}

	.intro-content p{
		color: #000000 !important;
		font-weight: bold !important;
	}
 	.intro_page_txt{
 		   /* width: 960px;*/
		    margin: auto;
		    /* left: 20%; */
		    padding-top: 70px;
 	}

 	.intro_page_txt h1{
 		font-size: 40px;
		font-family: Montserrat-SemiBold;
		color: #fff;
 	}

 	.intro_page_txt h2{
 		font-size: 21px;
		color: #fff;
		font-family: Montserrat-Regular;
		line-height: 40px;
 	}

 	
 	.intro-content a{
 		    font-size: 18px;
    font-weight: bold;
        position: absolute;
    bottom: 40px;
 	}

 	.intro-content{
 		position: relative;
 	}

 	

 </style>

 <script type="text/javascript">
	$(document).scroll(function() {

		try{


		if($(window).width() > 980){

           if($(window).scrollTop() > ($('.main').position().top - 200)){
           		$('.main').css('margin-top','40px');
           		$('.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not(ul[id^="myTabDASHBOX"]):not(ul[id^="SSID_myTabDASHBOX"])').addClass('fixed-nav');
           		$('.alert').css('top', '15px');
           }else{
           	    $('.main').css('margin-top','0px');
           	    $('.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not(ul[id^="myTabDASHBOX"])').removeClass('fixed-nav');
           		$('.alert').css('top', '60px');
           }

       }

       }catch(err){

       }


       });
 </script>
