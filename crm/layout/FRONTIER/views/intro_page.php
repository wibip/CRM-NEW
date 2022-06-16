<?php 
$page_img_url = 'layout/'.$camp_layout.'/img/'.$script.'_page_image.jpg';
$default_page_img_url = 'layout/'.$camp_layout.'/img/home_page_image.jpg';


echo '<div class="intro_page" style="position: relative">';

	
	switch ($script) {
		case 'home':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Managed '.__WIFI_TEXT__.' Portal</h1></div>';
			
			break;

		case 'network':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';
			
			break;

		case 'intro':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Managed '.__WIFI_TEXT__.' Portal</h1></div>';
			
			break;

		case 'campaign':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';
			
			break;
			
		case 'power_schedule':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Features</h1></div>';
			
			break;

		case 'customer':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Managed '.__WIFI_TEXT__.' Portal</h1></div>';
			
			break;

		case 'theme':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Guest '.__WIFI_TEXT__.' Management</h1></div>';
			
			break;

		case 'network_pr':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Private '.__WIFI_TEXT__.' Management</h1></div>';
			
			break;

		case 'venue_support':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Support & Resources</h1></div>';
			
			break;

		case 'properties':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Master Business Admin</h1></div>';
			
			break;

		case 'profile':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Profile</h1></div>';
			
			break;

		case 'tech':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Installation Assistant</h1></div>';
			
			break;
		case 'add_tenant':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Add Resident</h1></div>';
			
			break;
		case 'manage_tenant':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Manage Resident</h1></div>';
			
			break;
		case 'communicate':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Communicate with Residents</h1></div>';
			
			break;
		case 'reports':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Reports</h1></div>';
			
			break;

		
		default:
		
		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Features</h1></div>';
		
			break;
	}

	echo '</div>';

 ?>

<style type="text/css">
	.widget-header h3{
		top: 0px !important;
		display: none ;
	}
	.intro_page{
        
    <?php 

    if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
        echo 'height: 337px;margin-top: -35px;background-size: 100%;';
    }else{
		echo 'background: url('.$default_page_img_url.');';
        echo 'height: 337px;margin-top: -35px;background-size: 100%;';
	} 

     ?>

     height: 300px !important;
    margin-top: -35px !important; 
    background-repeat: no-repeat;
    background-size: cover !important;
    background-position: center !important;
        
        
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
    line-height: 45px
</style>

 <script type="text/javascript">
	$(document).scroll(function() {

		try{

	
          if(($(window).scrollTop() > ($('.main').position().top - 200)) && ($(window).width() > 980)){
           		$('.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not(ul[id^="myTabDASHBOX"])').addClass('fixed-nav');
           		$('.alert').css('top', '15px');
           }

   
           if($(window).scrollTop() <= ($('.main').position().top - 200)){
           		$('.nav-tabs').removeClass('fixed-nav');
           		$('.alert').css('top', '60px');
           }
       }catch(err){

       }

          
       });
 </script>