<?php
$page_img_url = 'layout/'.$camp_layout.'/img/'.$script.'_page_image.jpg';


echo '<div class="intro_page" style="position: relative"><div class="intro-linear">';

$intro_txt = $package_functions->getOptions("INTRO_TEXT",$system_package);

	switch ($script) {
		case 'home':

		echo '<div class="intro_page_txt container"><h2>Managed '.__WIFI_TEXT__.' Portal</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;

		case 'network':

		echo '<div class="intro_page_txt container"><h2>Guest '.__WIFI_TEXT__.'</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;

		case 'intro':

		echo '<div class="intro_page_txt container"><h2>Portal Overview</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;

		case 'campaign':

		echo '<div class="intro_page_txt container"><h2>Guest '.__WIFI_TEXT__.'</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;

		case 'power_schedule':

		echo '<div class="intro_page_txt container"><h2>Managed '.__WIFI_TEXT__.' Portal</h2><h1>AT&T MANAGED '.__WIFI_TEXT__.'</h1></div>';

			break;

		case 'customer':

		echo '<div class="intro_page_txt container"><h2>Managed '.__WIFI_TEXT__.' Portal</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;

		case 'theme':

		echo '<div class="intro_page_txt container"><h2>Guest '.__WIFI_TEXT__.'</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;

		case 'network_pr':

		echo '<div class="intro_page_txt container"><h2>Private '.__WIFI_TEXT__.'</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;

		case 'venue_support':

		echo '<div class="intro_page_txt container"><h2>Support & Resources</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;

		case 'properties':

		echo '<div class="intro_page_txt container"><h2>Your Properties</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
		
			break;

		case 'profile':

		echo '<div class="intro_page_txt container"><h2>Profile</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';


			break;

		case 'tech':

		echo '<div class="intro_page_txt container"><h2>Welcome to the Business Intelligence</h2><h1>Installation Assistant</h1></div>';

			break;

		case 'add_tenant':

		echo '<div class="intro_page_txt container"><h2>Add Resident</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'manage_tenant':

		echo '<div class="intro_page_txt container"><h2>Manage Resident</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'communicate':

		echo '<div class="intro_page_txt container"><h2>Communicate with Resident</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'location':

		echo '<div class="intro_page_txt container"><h2>Properties</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'session':

		echo '<div class="intro_page_txt container"><h2>Reports</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'config':

		echo '<div class="intro_page_txt container"><h2>Configuration</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'support':

		echo '<div class="intro_page_txt container"><h2>Resident Support</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'logs':

		echo '<div class="intro_page_txt container"><h2>Logs</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'users':

		echo '<div class="intro_page_txt container"><h2>Roles</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;
  
		case 'terms':

		echo '<div class="intro_page_txt container"><h2>Themes</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;
  
		case 'adapter_config':

		echo '<div class="intro_page_txt container"><h2>API Configurations</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
	
		break;

		case 'reports':

			echo '<div class="intro_page_txt container"><h2>Reports</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';
		
		break;

		default:

		echo '<div class="intro_page_txt container"><h2>Features</h2><h1>AT&T '.__WIFI_TEXT__.'</h1><h2 class="sm">'.$intro_txt.'</h2></div>';

			break;
	}

	echo '</div></div>';

 ?>

 <style type="text/css">

 	input, textarea, select, .uneditable-input{
 		height: 22px;
 		border-radius: 0px
 	}

 .tab-content > .active, .pill-content > .active{
 	width: 100% !important;
 }

.intro-linear{
 background: linear-gradient(to right,rgba(167, 167, 167, 0.6) 0,rgba(0,0,0,0) 100%);
height: 100%;
}


    @supports (-webkit-overflow-scrolling: touch) { /* CSS specific to iOS devices */ body{ cursor:pointer; } }


 .widget-content.table_response{
/*border: 1px solid #333333 !important;*/
 }
 .glyph{
 	/*top: 5px !important;*/
 }

 .subnavbar .container>ul>li>a{
 	padding: 0px !important;
 }

 .main .nav-tabs{
    background: #f2f2f2;
    width: 100% !important;
    margin: auto;
    box-sizing: border-box;
    margin-top: -1px;
    margin-left: auto !important;
  /*  padding-top: 35px !important;
    padding-bottom: 35px !important;*/
    text-align: center;
    padding-left: 0px !important;
}

#myTabDash, #myTabContentDASH {
	width: 960px !important;
}

 body .nav-tabs:not(.zg-ul-select)>.active>a, body .nav-tabs:not(.zg-ul-select)>.active>a:hover{
 	border-bottom: 4px solid #0568ae !important;
 }

.nav-tabs>li{
	display: inline;
	float: none !important;
}

.nav-tabs>li>a:not([href^="#dashbox"]){
	display: inline-block;
	padding-top: 25px !important;
	padding-bottom: 25px !important;
	font-size: 16px !important;
}

h1.head {
    padding: 20px;
    width: 960px !important;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #000;
    font-family: Rmedium !important;
    box-sizing: border-box;
}

h1.head span{
	    display: inline-block;
}

h1.head span:nth-child(1){
	    margin-left: -10px;
}

.alert {
	box-sizing: border-box;
}


@media (max-width: 978px){

	.form-horizontal .controls{
        width: 320px;
    }

    form.form-horizontal .form-actions{
        width: 300px;
    }

    .form-horizontal .contact.controls{
        width: 90%;
    }

    .tab-pane {
        padding-top: 0px !important;
    }

	.btn-navbar .icon-bar{
		height: 3px;
	}

	.logo_img{
		max-height: 35px !important;
	}

	.btn-navbar .icon-bar+.icon-bar {
	    margin-top: 3px;
	}

	.navbar .container{
		padding: 3px !important;
	}
	.navbar .btn-navbar{
		background-image: none;
		margin-top: 3px !important;
		background-color: #1a2027;
		box-shadow: none;
		border-color: #1a2027;
	}

	.alert {
	    top: 21px !important;
	    box-sizing: border-box;
	}

	.intro_page{
		display: none !important;
	}
	 .main .nav-tabs{
		width: 100% !important;
		position: fixed;
    	top: 50px;
    	left: 0;
    	margin-top: 0px !important;
    	padding-top: 0px !important;
    	padding-bottom: 0px !important;
    	z-index: 555;

	}

	#myTabDash, #myTabContentDASH {
	width: 100% !important;
}

	.main .cf .nav-tabs{
		width: 150px !important;
    	margin-top: 0px !important;
    	padding-left: 0px !important;
    	padding-top: 0px !important;
    	padding-bottom: 0px !important;
    	position: absolute;
    	margin-right: 0px;
    	top: 25px;
    	right: -25px;
	}

	#myTabContentDASH .widget-header{
		left: -28px;
	}

	h1.head, .header2_part1 h2{
		padding-bottom: 0px !important;
		padding-top: 20px !important;
		font-family: Rlite !important;
		padding-bottom: 30px !important;
    	width: auto !important;
    	    font-size: 24px !important;
	}

	.header2_part1{
		    text-align: center;
    margin-top: 20px;
	}	

	.form-horizontal .controls, .form-horizontal .form-actions{

		width: 280px;
    	margin: auto;
	}

	.tab-pane{
		padding-top: 20px !important;
	}

	#active_theme{
		padding-top: 50px !important;
	}

	#myTabContentDASH .widget, .stat{
		margin-bottom: 0px !important;
	}

	.tab-content .nav-tabs>li>a, .tab-content .nav-pills>li>a{
		padding-right: 0px !important;
		padding-left: 0px !important;
	}

	.main .cf .nav-tabs:not(#myQuickTab){
		margin-top: 0px !important;
	}

	.nav-tabs > li > a:not([href^="#dashbox"]){
		padding-top: 10px !important;
		padding-bottom: 10px !important;
	}

	.error-wrapper{
		margin-left: 0px !important;
	}
}


@media (max-width: 977px) and (min-width: 767px){

}

@media (max-width: 768px){

	input.span5, textarea.span5, .uneditable-input.span5, input[class*="span"], div[class*="span4"], select[class*="span"], textarea[class*="span"], .uneditable-input{
		width: 280px !important;
	}

	.footer-inner .container{
		text-align: center;
	}

	.footer-inner .contact{
		display: block;
        margin: auto;
        margin-bottom: 10px;
	}

	input, textarea, select, .uneditable-input{
 		height: 35px !important;
 	}

 	.form-horizontal .controls{
        width: 280px;
    }

    form.form-horizontal .form-actions{
        width: 260px;
        padding-left: 0px;
    }


    .form-horizontal .contact.controls{
        width: 100%;
    }

    select.inline-btn, input.inline-btn, button.inline-btn, a.inline-btn {
        display: block !important;
    }

    div.inline-btn, a.inline-btn, button.inline-btn, input[type="submit"].inline-btn {
        margin-top: 10px !important;
        margin-left: 0px !important;
    }

}

@media (max-width: 480px){

	form.form-horizontal .form-actions{
        width: 270px;
    }

	.footer-live-chat-link{
		margin-left : 0px !important;
		display: block !important;
		margin-top: 8px;
	}

	.parent-head{
		margin-left: -20px;
		margin-right: -20px;
	}

	html{
		    overflow-x: hidden;
	}

	.main_intro{
		height: 300px !important;
	}

	.parent_intro .intro-content p{
		font-size: 15px !important;
	}

	.intro-content{
		padding: 20px !important;
    padding-right: 20px !important;
	}

	.resize_charts{
		    margin-left: -20px !important;
           margin-right: -30px !important;
    }

    .tree_graph{
    	padding-left: 0px !important
    }

    h1.head{
    	    padding-right: 25px !important;
    	    padding-left: 25px !important;
    }

}

@media (max-width: 420px){
	.main_intro{
		height: 300px !important;
	}
}

@media (max-width: 356px){
	.main_intro{
		height: 300px !important;
	}
}

@media (max-width: 310px){
	.main_intro{
		height: 300px !important;
	}
}

 	.intro_page{

 	<?php

 	if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
        echo 'height: 337px;margin-top: -35px;background-size: 100%;';
	}

 	 ?>

 	 height: 200px !important;
    margin-top: -35px !important;
    background-repeat: no-repeat;
    background-size: cover !important;
    background-position: 0 0 !important;


	}

	.intro-content p{
		color: #000000 !important;
		font-weight: bold !important;
	}
 	.intro_page_txt{
 		   /* width: 960px;*/
		    margin: auto;
		    /* left: 20%; */
		    padding-top: 50px;
 	}

 	.intro_page_txt h1{
 		font-size: 48px;
		font-family: Rmedium;
		color: #fff;
 	}

 	.intro_page_txt h2.sm{
 		font-size: 22px;
		color: #fff;
		/*font-family: Rmedium;*/
		line-height: 40px;
 	}
 	.intro_page_txt h2:not(.sm){
 		font-size: 24px;
		color: #fff;
		font-family: Rmedium;
		line-height: 40px;
 	}

/* 	body .subnavbar .container>ul>li>ul{
 		z-index: 2147483647;
 		background-color: #ffffff !important;
 	}*/
 	.intro-content a{
 		    font-size: 18px;
    /*font-weight: bold;*/
        /*position: absolute;
    bottom: 40px;*/
 	}

 	.intro-content{
 		position: relative;
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

 </style>


