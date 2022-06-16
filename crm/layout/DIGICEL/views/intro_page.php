<?php
//$page_img_url = 'layout/'.$camp_layout.'/img/'.$script.'_page_image.jpg';

$page_img_url = 'layout/'.$camp_layout.'/img/network_page_image.jpg';


echo '<div class="intro_page" style="position: relative">';


	switch ($script) {
		case 'home':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>'.__WIFI_TEXT__.' Network Information</h2></div>';

			break;

		case 'network':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Networks</h2></div>';


			break;

		case 'intro':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Welcome</h2></div>';

			break;

		case 'campaign':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Guest '.__WIFI_TEXT__.' Management</h2></div>';


			break;

		case 'power_schedule':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2></h2></div>';


			break;

		case 'customer':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Visitors Report</h2></div>';


			break;

		case 'theme':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Theme</h2></div>';

			break;

		case 'network_pr':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Private '.__WIFI_TEXT__.'</h2></div>';

			break;

		case 'venue_support':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Support & Resources</h2></div>';

			break;

		case 'properties':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Your Properties</h2></div>';


			break;

		case 'profile':

			echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Profile</h2></div>';


			break;

		case 'tech':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Tech Tool</h2></div>';
		//Installation Assistant


			break;

		case 'reports':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Reports</h2></div>';


			break;

		case 'payment':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Payment</h2></div>';


			break;

		case 'content_filter':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Features</h2></div>';


			break;

		case 'location':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Manage Properties</h2></div>';


			break;

		case 'session':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Reports</h2></div>';


			break;

		case 'config':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Configuration</h2></div>';


			break;

		case 'terms':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Theme Management</h2></div>';


			break;

		case 'adapter_config':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>API Config</h2></div>';


			break;

		case 'users':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Roles</h2></div>';


			break;

		case 'logs':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Logs</h2></div>';


			break;

		case 'support':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2>Support</h2></div>';


			break;


		default:

		echo '<div class="intro_page_top"></div><div class="intro_page_txt"><h1 style="color: white;text-shadow: 1px 1px 2px #636363;"><span style="">MANAGED</span> <span style="">NETWORKS PORTAL</span></h1><h2></h2></div>';

			break;
	}

	echo '</div>';

 ?>

 <style type="text/css">

body .intro_page_txt{
    position: relative;
    z-index: 7;
    padding-top: 70px;
    margin-left: 42%;

}

.intro_page_top{
position: absolute;
    top: 100px;
    /*background: rgba(68, 62, 62, 0.73);*/
    width: 100%;
    z-index: 1;
    height: 200px;
}







 	.intro_page{

 	<?php

 	if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
 		echo 'background-color: #fff;';
        echo 'height: 337px;margin-top: -40px;background-size: 100%;';
	}

 	 ?>

 	 height: 210px !important;
    /*margin-top: 60px !important;*/
    margin-top: 60px;
    background-repeat: no-repeat;
    background-size: cover !important;
    background-color: #fff !important;
	}

	@media (max-width: 979px){

		.intro_page{
			/*display: none !important;*/
			z-index: 0 !important;
			/* background-position: -100px -10px !important; */
		}

		.intro_page_txt h1{
			font-size: 30px !important;

		}

		body .intro_page_txt{
			padding-top: 60px;
			margin-left: 50%;
		}
	}

	@media (max-width: 520px) {
		.intro_page{
			display: none;
		}
	}

	body .parent-head{
		margin-top: 50px;
	}

	
 	.intro_page_txt{
 		   /* width: 960px;*/
		    margin: auto;
		    /* left: 20%; */
		    padding-top: 140px;
		    margin-bottom: 30px;
 	}

 	.intro_page_txt h1{
 		font-size: 40px;/*40*/
		font-family: poppinsregular, sans-serif;
		margin-bottom: 15px;
		color: #000;
		font-weight: 200 !important;
		color: #fff;
    	text-shadow: 3px 3px 3px #636363 !important;
 	}

 	.intro_page_txt h2{
 		font-size: 20px;
		font-family: poppinsregular, sans-serif;
		line-height: 30px;
		font-weight: 300;
		width: 80%;
		color: #fff;
    	text-shadow: 1px 1px 2px #636363
 	}

 	
 </style>

 <script type="text/javascript">
	$(document).scroll(function() {

		try{


          if(($(window).scrollTop() > 20) && ($(window).width() > 980)){
           		$('.subnavbar-inner').addClass('black-background');
           		
           }


           if($(window).scrollTop() <= 20){
           		$('.subnavbar-inner').removeClass('black-background');
           }
       }catch(err){

       }


       });
 </script>
