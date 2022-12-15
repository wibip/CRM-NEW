<?php
$page_img_url = 'layout/'.$camp_layout.'/img/'.$script.'_page_image.jpg';



echo '<div class="intro_page" style="position: relative">';


	switch ($script) {
		case 'home':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1></div>';

			break;

		case 'network':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1><h2>Guest '.__WIFI_TEXT__.' Management</h2></div>';


			break;

		case 'intro':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1></div>';

			break;

		case 'campaign':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1><h2>Guest '.__WIFI_TEXT__.' Management</h2></div>';


			break;

		case 'power_schedule':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1></div>';


			break;

		case 'customer':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1></div>';


			break;

		case 'theme':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1><h2>Guest '.__WIFI_TEXT__.' Management</h2></div>';

			break;

		case 'network_pr':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1><h2>Private '.__WIFI_TEXT__.' Management</h2></div>';

			break;

		case 'venue_support':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1><h2>Support & Resources</h2></div>';

			break;

		case 'properties':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1><h2>Master Business Admin</h2></div>';


			break;

		case 'profile':

			echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1><h2>Profile</h2></div>';


			break;

		case 'tech':

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1><h2>Installation Assistant</h2></div>';


			break;


		default:

		echo '<div class="intro_page_top"></div><div class="intro_page_txt container"><h1><span style="color: #ff9e1b;">MANAGED</span> NETWORKS PORTAL</h1></div>';

			break;
	}

	echo '</div>';

 ?>

 <style type="text/css">

body .intro_page_txt{
    position: relative;
    z-index: 7;
        padding-top: 170px;
}

.intro_page_top{
position: absolute;
    top: 100px;
    background: rgba(68, 62, 62, 0.73);
    width: 100%;
    z-index: 1;
    height: 200px;
}


@media (max-width: 979px){

	.intro_page{
		display: none !important;
	}
}


 	.intro_page{

 	<?php

 	if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
        echo 'height: 337px;margin-top: -40px;background-size: 100%;';
	}

 	 ?>

 	 height: 300px !important;
    /*margin-top: 60px !important;*/
    background-repeat: no-repeat;
    background-size: cover !important;
    background-position: 0px -10px !important;


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
 		font-size: 40px;
		font-family: Regular;
		margin-bottom: 15px;
		color: #fff;
 	}

 	.intro_page_txt h2{
 		font-size: 20px;
		color: #fff;
		font-family: Regular;
		line-height: 30px;
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
