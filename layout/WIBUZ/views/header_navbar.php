
<style type="text/css">


	/*imported from introPage*/

 html{
 	min-height: 100%;
    position: relative;
 }

 body {
    margin-bottom: 120px;
}

.footer-main .extra {
    position: absolute;
    bottom: 0;
    width: 100%;
    margin-bottom: 71px;
}

.footer-main .footer {
    position: absolute;
    bottom: 0px;
    width: 100%;
    
}

 body .widget-content{
 	border: none !important;
 }

 .form-actions{
 	background-color: #ffffff;
    border-top: 1px solid #fff;
    margin-top: 0px;
 }

    @supports (-webkit-overflow-scrolling: touch) { /* CSS specific to iOS devices */ body{ cursor:pointer; } }


 .widget-content.table_response{
/*border: 1px solid #333333 !important;*/
 }
 .glyph{
 	top: 5px !important;
 }

 .subnavbar .container>ul>li>a{
 	padding: 0px !important;
 }

 .main .nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"]){
    background: #d9d9d6;
    margin-bottom: 20px;

    <?php if($introMnoPage=='NO'){ ?>
	margin-top: 60px; 
	<?php } ?>
}

.main .nav-tabs{
	background: #54585a;
	width: 960px !important;
    margin: auto;
    box-sizing: border-box;
    text-align: center;
    padding-left: 0px !important;
}


html body .subnavbar-inner{
background: black !important;
}


.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"]), #myTabContentDASH {
	width: 960px !important;
}

.nav-tabs>li{
	display: inline;
	float: none !important;
}

#myTabDash li>a{
	margin-right: 0px !important;
}

.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li>a{
	display: inline-block;
	    font-weight: bold;
    float: none !important;
    border-left: 1px solid #6d6e6f;
    padding: 35px;
    margin-right: -4px;
    background: none !important;
    color: #6d6e6f !important;
    border-radius: 0px 0px 0 0 !important;
}

  .nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li.active>a::before{
    content: "";
    width: 0px;
    height: 0px;
    border-left: 12px solid transparent;
    border-right: 12px solid transparent;
    position: absolute;
    bottom: -12px;
    left: 50%;
    margin-left: -10px;
    border-top: 12px solid #b7b7b7;
  }

.nav-tabs>li>a{
	display: inline-block;
	    font-weight: bold;
    float: none !important;
}

body .nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>.active>a, body .nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>.active>a:hover{
	border-left: 1px solid #6d6e6f;
	background-color: #b7b7b7 !important;
        position: relative;
        color: #fff !important;
}
.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li:nth-last-child(1)>a{
	border-right: 1px solid black;
}

h1.head {
    padding: 50px;
    width: 960px !important;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #000;
    font-family: Regular !important;
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


@media (max-width: 979px) and (min-width: 768px){

}

@media (max-width: 767px){
	.extra, .footer {
	    margin-right: 0px !important;
	    margin-left: 0px !important;
	}

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

}



@media (max-width: 480px){

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
		height: 280px !important;
		background-size: cover !important;
	}

	.parent_intro .intro-content p{
		font-size: 15px !important;
	}

	.intro-content{
		/*padding: 10px !important;
    padding-right: 20px !important;
    height: 62px !important;*/
    padding-right: 50px !important;
	}

	.resize_charts{
		    margin-left: -20px !important;
           margin-right: -20px !important;
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
		height: 280px !important;
	}
}

@media (max-width: 356px){
	.main_intro{
		height: 280px !important;
	}
}

@media (max-width: 310px){
	.main_intro{
		height: 280px !important;
	}
}

@media (max-width: 341px){
	.footer-inner{
		padding-bottom: 0px !important;
    	padding-top: 5px !important;
	}
}


@media (max-width: 979px){

	.form-horizontal .form-actions{
		margin: auto;
    width: 280px;
    padding-left: 0px;
    padding-right: 0px
	}

	body div.inline-btn, body select.inline-btn, body input.inline-btn, body button.inline-btn, body a.inline-btn{
		margin-left: 0px !important;
    	margin-top: 5px !important;
    	    display: block !important;
	}

	.alert {
	    top: 21px !important;
	    box-sizing: border-box;
	}


	 .main .nav-tabs{
		width: 100% !important;
		position: fixed;
    	top: 38px;
    	left: 0;
    	margin-top: 0px !important;
    	padding-top: 0px !important;
    	padding-bottom: 0px !important;
    	z-index: 555;

	}

	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li>a{
		padding: 10px !important;
	}

	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li:nth-last-child(1)>a{
		border-right:none;
	}
	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li:nth-child(1)>a{
		border-left:none;
	}

	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li.active>a::before{
		display: none;
	}

	.container{
		padding-right: 10px;
    padding-left: 10px;
	}

	.logo_img{
		max-width: 70% !important;
		margin-top: 5px;
	}

	#myTabDash, #myTabContentDASH{
		margin-left: 0px !important;
	}
	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"]), #myTabContentDASH {
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
    	right: -15px;
	}

	#myTabContentDASH .widget-header{
		left: -28px;
	}

	h1.head{
		padding-bottom: 20px !important;
    	width: auto !important;
    	padding-top: 10px !important;
    	    font-size: 28px !important;
	}

	.form-horizontal .controls{

		width: 280px;
    	margin: auto;
	}

	.tab-pane{
		padding-top: 20px !important;
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
}


.intro-content p{
		color: #000000 !important;
		font-weight: bold !important;
	}

	body .subnavbar .container>ul>li>ul{
 		z-index: 2147483647;
 		background-color: #54585a !important;
 	}
 	.intro-content a{
 		    font-size: 18px;
       /* position: absolute;*/
    bottom: 15px;
 	}

 	.intro-content{
 		position: absolute;
 	}

 	body{
 		font-family: Regular !important;
 		font-size: 12pt !important;
 	}

 	input, button, select, textarea, p , label{
    font-family: Open Sans !important;
    font-size: 14px !important;
}
.nav-tabs>li>a{
	font-family: Open Sans !important;
}

.subnavbar-inner{
	border-bottom: none !important;
}


@media (min-width: 980px){
	.subnavbar{
		    position: fixed;
    		top: 0px;
    		width: 100%;
    		z-index: 99999999999999999999;
	}

	.intro_page{
		/*margin-top: 60px !important;*/
	}

}

.subnavbar .dropdown .dropdown-menu{
	    border-radius: 0px;
    border: 1px solid #fff;
}

.subnavbar .dropdown .dropdown-menu a{
	text-transform: uppercase;
    color: #fff ;
}

.subnavbar .dropdown .dropdown-menu a:hover{
	color: #ffb77e !important;
}


.main .fixed-nav{
	position: fixed;
	padding-bottom: 15px !important;
	padding-top: 15px !important;
	top: 105px;
	border-top: 1px solid #fff;
	border-bottom: none !important;
	z-index: 2222;
}

/*.nav-tabs.fixed-nav>li>a {
    font-family: Altice !important;
}*/

.mainnav ul{
	box-shadow: rgba(0, 0, 0, 0.173) 0px 6px 12px 0px;
	    width: auto;
    text-align: left;
    box-sizing: border-box;
    min-width: 100%;
    padding-top: 10px;
    padding-bottom: 10px;
    height: auto !important;
}

.subnavbar .container>ul>li{
	position: relative;
}

.mainnav ul a{
	padding: 0px !important;
}

.mainnav ul li{
	float: none !important;
	padding: 5px 20px;
	margin-top: 0px !important;
}

.mainnav ul li:hover{
	/*background-color: #f5f5f5;*/
}

.dropdown-menu li:hover, body .dropdown-menu .active>a:hover, body .dropdown-menu li>a:hover{
	background-color: #54585a !important;
}



/*iend of mported from introPage*/

	.navbar-inner{
		border-top: none !important;
	}

	.no_arrow .glyph-angle-down{
		display: none !important;
	}
	@media (max-width: 979px){
		.navbar-fixed-top {
			display: block !important;
		}
	}
	.subnavbar .dropdown-menu::before, .subnavbar .dropdown-menu::after{
		content: none !important;
	}
	.dropdown{
		display: table;
	}

	.subnavbar .dropdown .dropdown-toggle{
		    vertical-align: middle;
    padding-left: 30px !important;
    display: table-cell !important;
    background : url('layout/<?php echo $camp_layout ?>/img/user.png') !important;
    background-size: 22px !important;
    background-repeat: no-repeat !important;
    background-position: 0px 16px !important;
    margin-top: 0px !important;
    position: relative;
    padding-right: 20px !important;
	}

	body .subnavbar-inner.black-background{
		    background: black !important;
	}

	body .subnavbar-inner{
		    background: transparent !important;
	}



	.glyph-angle-down:before {
    content: "\eA12";
}

/*body .subnavbar .container>ul>li{
	height: 30px;
}*/

/*body .subnavbar .container > ul{
	margin-top: 20px;
}*/

body .subnavbar .container>ul>li.active>a{
	border-bottom: none ;
}

body .subnavbar .container>ul>li>a>span:not(.glyph), body .subnavbar .container>ul>li>a{
	font-size: 14px !important;
    font-family: regular !important;
    line-height: 20px  !important;
}

	.dropdown .glyph{
        position: absolute !important;
    top: 0 !important;
    right: 0;
    display: inline-block !important;
    font-family: 'glyphs' !important;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 60px;
    -webkit-font-smoothing: antialiased;
}

.glyph{
        position: relative !important;
    top: 5px;
    display: inline-block !important;
    font-family: 'glyphs' !important;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
}

<?php 

if(sizeof($main_mod_array) >= 5){
 ?>

 .subnavbar .container>ul>li>a{
 	padding: 0px !important;
 }

  .subnavbar .container>ul>li{
 	max-width: 110px;
 }

<?php } ?>
</style>

<div class="navbar navbar-fixed-top"  <?php if($top_menu=='bottom'){ ?> style="display: none;" <?php } ?>>
  <div class="navbar-inner">


    <div id="container_id" class="container">

    <?php 

    $log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="layout/'.$camp_layout.'/img/top_logo.png" border="0">';
    
    if($top_menu=='bottom'){ 
		echo '<a href="intro">'.$log_img.'</a>';
	}
		?>
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </a>

         <?php 

         //$page_names = $package_functions->getOptions('HEADER_PAGE_NAMES',$system_package);

          //$page_names_arr = json_decode($page_names,true);

        
		/// PAGE TITLE IS HERE ?>

                    <?php
                   
                 
                    

                    if($top_menu!="bottom"){

						echo $log_img;
						echo $logo_title;
					}

                    ?>



             <?php /// END PAGE TITLE ?>








  <?php /// MENU STARTING ?>


      <div class="nav-collapse">

             <ul class="nav pull-right">

         	<?php

         $menutype = $db_class1->setVal('menu_type','ADMIN'); //echo NOW ONLY HAVE SUB MENU ;?>




          <?php

       
          if($menutype=="SUB_MENU"){

          	

          	foreach ($main_mod_array as $keym => $valuem){

          		if($main_menu_clickble=="NO"){

          			$main_menu_name2 = $valuem['name'];
          			$modarray = $valuem['module'];

          			ksort($modarray);


          			foreach ($modarray as $keyZ => $valueZ){

          				if(strlen($link_main_m_multy)==0)
          				 $link_main_m_multy =  $valueZ['link'];
          				 $sub_menu_new_link =  $valueZ['nw_link'];
          			}

					    if(strlen($page_names_arr[$main_menu_name2])>0){
						$main_menu_name2 = $page_names_arr[$main_menu_name2];
					}

				
				
				if($sub_menu_new_link==1){
          			echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
            		<a href="'.$link_main_m_multy.'" class="dropdown-toggle" data-toggle="dropdown"> '.$main_menu_name2.'<b class="caret"></b></a>';
				}
				else{
						echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
            		<a href="'.$link_main_m_multy.$extension.'" class="dropdown-toggle" data-toggle="dropdown"> '.$main_menu_name2.'<b class="caret"></b></a>';
					
				}

           			echo '<ul class="dropdown-menu">';

          			$link_main_m_multy = '';

          			foreach ($modarray as $keyY => $valueY){
          				$sub_menu_link = $valueY['link'];
          				$sub_menu_name = $valueY['name'];
          				$sub_menu_new_link =  $valueY['nw_link'];

          				if(strlen($page_names_arr[$sub_menu_name])>0){
							$sub_menu_name = $page_names_arr[$sub_menu_name];
						}
          				
          				if($sub_menu_new_link==1){
          				echo '<li><a href="'.$sub_menu_link.'"  class="new" style="padding:5px;">'.$sub_menu_name.'</a></li>';
          				}
          			
          				else{
          				echo '<li><a href="'.$sub_menu_link.$extension.'"  class="new" style="padding:5px;">'.$sub_menu_name.'</a></li>';
          				}
          			}
          			echo '</ul>';

                	echo '<li>';

          		}
          		else{

          			/// Single Item

          		if(sizeof($valuem['module'])==1){
          			foreach ($valuem['module'] as $keyY => $valueY){
          				$link_main_m =  $valueY['link'];
          				$menu_item_row_id = $valueY['menu_item'];
          			}
          			$main_menu_name = $valuem['name'];

          			if(strlen($page_names_arr[$main_menu_name])>0){
						$main_menu_name = $page_names_arr[$main_menu_name];
					}

          				echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
          				<a href="'.$link_main_m.$extension.'" class="dropdown-toggle" > '.$main_menu_name.'</a></li>';
          		}

          		/// Multy Item


          		else{
          			$main_menu_name2 = $valuem['name'];
          			$modarray = $valuem['module'];

          			ksort($modarray);


          			foreach ($modarray as $keyZ => $valueZ){

          				if(strlen($link_main_m_multy)==0)
          				 $link_main_m_multy =  $valueZ['link'];
          			}


          			if(strlen($page_names_arr[$main_menu_name2])>0){
						$main_menu_name2 = $page_names_arr[$main_menu_name2];
					}


          			echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
            		<a href="'.$link_main_m_multy.$extension.'" class="dropdown-toggle" data-toggle="dropdown"> '.$main_menu_name2.'<b class="caret"></b></a>';


           			echo '<ul class="dropdown-menu">';

          			$link_main_m_multy = '';

          			foreach ($modarray as $keyY => $valueY){
          				$sub_menu_link = $valueY['link'];
          				$sub_menu_name = $valueY['name'];
          				$sub_menu_new_link =  $valueY['nw_link'];


          				if(strlen($page_names_arr[$sub_menu_name])>0){
							$sub_menu_name = $page_names_arr[$sub_menu_name];
						}
          				
          				if($sub_menu_new_link==1){
          				echo '<li><a href="'.$sub_menu_link.'"  class="new" style="padding:5px;">'.$sub_menu_name.'</a></li>';
          				}
          			else{
          				echo '<li><a href="'.$sub_menu_link.$extension.'"  class="new" style="padding:5px;">'.$sub_menu_name.'</a></li>';
          				}
          			}
          			echo '</ul>';

                	echo '<li>';
          		}
          	}

          	}
          }

            $full_name = 'Profile';

    		$full_name1 = 'Profile';
          

          
          ?>





          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="icon-user"></i> <?php  echo $full_name; ?> <b class="caret"></b></a>

            <ul class="dropdown-menu">
				<?php

				if($script!='verification'){
					if(!(isset($_SESSION['p_token']))){
						if($no_profile != '1'){
					?>
              <li><a href="profile<?php echo $extension; ?>">Profile</a></li>
				<?php } 
					}
				}?>

				<?php  if($session_logout_btn_display != 'none'){ ?>

              <li><a href="#" id="logout_1">Logout</a></li>

              <?php } ?>
			  <script type="text/javascript">
																				$(document).ready(function() {
																					$("#logout_1").click(function(event) {
																						$('#logout-check-div').show();
																						$('#sess-front-div').show();
																						//clearInterval(intrval_func);
																						//window.location = 'logout.php?doLogout=true';
																					 });
																					});
																				</script>
			  
              <?php if($_SESSION['s_token']){ ?>

              <li>
				  <a href="support<?php echo $extension; ?>?back_sup=true">Back to Support</a></li>

              <?php } ?>
			  
			  <?php 
			  
			  if(isset($_SESSION['p_token'])){ ?>

              <li>
				  <a href="properties<?php echo $extension; ?>?back_master=true">Back to Properties Page</a></li>

              <?php } ?>
			  
            </ul>


          </li>
        </ul>

      </div>
      <!--/.nav-collapse -->
    </div>
    <!-- /container -->
  </div>
  <!-- /navbar-inner -->
</div>


<?php if($script!='verification'){ ?>

<div class="subnavbar" id="subnavbar_id">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">

<?php

if($top_menu=='bottom'){

	$full_name = trim($full_name);

	if(strlen($full_name) > 15){

			//$full_name1 = str_replace(" ","<br>",$full_name); 
			$full_name1_arr = explode(" ",$full_name);

			if(sizeof($full_name1_arr) == 2){

				$full_name1 = $full_name1_arr[0].'<br>'.$full_name1_arr[1];

			}
			else{

				$full_name1 = substr_replace($full_name,"<br>",13,0);
								
			}

			

			

          	$li_style = "float: right; ";
          	$a_style = "text-align: left;padding-right: 0px;margin-top: 10px";
          	$b_style = "margin-top: -2px;margin-left: 8px;";
    }
    else{
          	$full_name1 = $full_name;
          	$li_style = "float: right; line-height: 60px;";
          	$a_style = "text-align: left;padding-right: 0px";
          	$b_style = "margin-top: 28px;margin-left: 8px;";
    }

    $full_name = 'Profile';

    $full_name1 = 'Profile';
?>

	

<li class="dropdown" style="<?php echo $li_style; ?>"><a style="<?php echo $a_style; ?>" href="#" class="dropdown-toggle" data-toggle="dropdown">
           <?php echo $full_name1; ?> <span class="glyph glyph-angle-down"></span></a>

            <ul class="dropdown-menu" style="left: -30px">
				<?php

				if($script!='verification'){

				if(!(isset($_SESSION['p_token']))){
					if($no_profile != '1'){
				?>
              		<li><a href="profile<?php echo $extension; ?>">Profile</a></li>
				<?php }
					}
				}
				?>

				<?php  if($session_logout_btn_display != 'none'){ ?>

              <li><a href="#" id="logout_2">Logout</a></li>

              <?php } ?>
			  <!-- <li><a href="javascript:void();" id="logout_1">Logout</a></li> -->
			  <script type="text/javascript">
																				$(document).ready(function() {
																					$("#logout_2").click(function(event) {
																						$('#logout-check-div').show();
																						$('#sess-front-div').show();
																						
																						//window.location = 'logout.php?doLogout=true';
																					 });
																					});
																				</script>

              <?php if($_SESSION['s_token']){ ?>

              <li>
				  <a href="support<?php echo $extension; ?>?back_sup=true">Back to Support</a></li>

              <?php } ?>
              
              <?php if($_SESSION['p_token']){ ?>

              <li>
				  <a href="properties<?php echo $extension; ?>?back_master=true">Back to Properties Page</a></li>
              
              <?php } ?>
            </ul>


          </li>

          <?php } 

$menutype = $db_class1->setVal('menu_type','ADMIN');
if($menutype=="SUB_MENU"){

	if($top_menu=="bottom"){
				echo '<li class="no_arrow" style="line-height:60px; margin-right: 10px"><a href="intro" style="line-height: 60px !important;">'.$log_img.'</a></li>';
				echo '<style> .logo_img{ max-height: 40px !important; float: none !important; } </style>';
	}

	$mod_size_arr = sizeof($main_mod_array);

	if($mod_size_arr <5){
		$mod_size_arr =5;
	}
	if($mod_size_arr >6){
		$mod_size_arr = 6;
	}


	if($top_menu=="bottom"){
		$mod_size_arr = $mod_size_arr + 2;

		if($mod_size_arr == 7){
			$mod_size_arr = $mod_size_arr + 0.5;
		}
	}

	$width_li = intval(99)/$mod_size_arr.'%';
	//$width_li = intval(99)/intval(sizeof($main_mod_array));

/* 	if($user_type=="MNO" || $user_type=="ADMIN"){
		$width_li = "19.8%";
	}
	else{
		$width_li = "16.5%";
	} */


	if($style_type != 'light')
		$camp_theme_color = '#fff';

	$numItems = count($main_mod_array);
	$i = 0;

	$main_mod_array = array_reverse($main_mod_array);

	foreach ($main_mod_array as $keym => $valuem){
		if(++$i === $numItems) {
			//$css_right = 'border-right: 1px solid #d9d9d9;';
		}
		if(strlen($valuem['active'])){
			$scrpt_active_status = ' class="active"';
		}
		else{
			$scrpt_active_status = '';
		}


		if($main_menu_clickble=="NO"){

			$main_menu_name2 = $valuem['name'];
			$modarray = $valuem['module'];
			ksort($modarray);
			foreach ($modarray as $keyZ => $valueZ){

				if(strlen($link_main_m_multy)==0)
				 $link_main_m_multy =  $valueZ['link'];
			}

			if(strlen($page_names_arr[$main_menu_name2])>0){
					$main_menu_name2 = $page_names_arr[$main_menu_name2];
			}

			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.';float: right" '.$scrpt_active_status.'>
            <a id="hot_a" style="cursor: default">
			<span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">'.$main_menu_name2.'</span> <span class="glyph glyph-angle-down"></span></a>';

			if(sizeof($valuem['module'])==1){
				$style_tag1 = "min-width: 100%;width: auto";
				$style_tag2 = 'white-space: nowrap';
				$add_class = "single";
			}
			else{
				$style_tag1 = "";
				$add_class = "multi";
			}
			echo '<ul id="sami_'.$keym.'a" style="display: none;list-style-type: none;position: absolute; background-color: '.$camp_theme_color.';height: 30px; margin-left: -1.5px;border-width: 1px; border-style: solid; border-color: rgb(217, 217, 217);'.$style_tag1.'">';
			$link_main_m_multy = '';

			foreach ($modarray as $keyY => $valueY){
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];

				if(strlen($page_names_arr[$sub_menu_name])>0){
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}

				if($sub_menu_new_link==1){
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px;'.$style_tag1.'">
            		<a href="' . $sub_menu_link . '"  target="_blank"  class="new '.$add_class.'" style="padding:5px;'.$style_tag2.'">' . $sub_menu_name . '</a></li>';
				}else {
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px;'.$style_tag1.'">
            		<a href="' . $sub_menu_link . $extension . '" class="new '.$add_class.'" style="padding:5px;'.$style_tag2.'">' . $sub_menu_name . '</a></li>';
				}
			}

		echo '</ul> </li>';

		}
		else{
		/// Single Item

		if(sizeof($valuem['module'])==1){
			//print_r($valuem['module']);
			foreach ($valuem['module'] as $keyY => $valueY){
				$link_main_m =  $valueY['link'];
				$menu_item_row_id = $valueY['menu_item'];
			}
			$main_menu_name = $valuem['name'];

			$main_menu_name = $package_functions->getPageName($link_main_m,$system_package,$main_menu_name);

				if($scrpt_active_status==''){
					$scrpt_active_status = ' class="no_arrow"';
				}
				else{
					$scrpt_active_status = ' class="active no_arrow"';
				}

				if(strlen($page_names_arr[$main_menu_name])>0){
					$main_menu_name = $page_names_arr[$main_menu_name];
				}

				echo '<li style="float: right;width: '.$width_li.';'.$css_right.'" '.$scrpt_active_status.'>
				<a id="dash_'.$keym.'" href="'.$link_main_m.$extension.'">
				<span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">'.$main_menu_name.'</span><span class="glyph glyph-angle-down"></span> </a></li>';

		}

		/// Multy Item
		else{ 
			$main_menu_name2 = $valuem['name'];
			$modarray = $valuem['module'];
			ksort($modarray);
			foreach ($modarray as $keyZ => $valueZ){

				if(strlen($link_main_m_multy)==0)
				 $link_main_m_multy =  $valueZ['link'];
			}

			$main_menu_name2 = $package_functions->getPageName($link_main_m_multy,$system_package,$main_menu_name2);

			if(strlen($page_names_arr[$main_menu_name2])>0){
					$main_menu_name2 = $page_names_arr[$main_menu_name2];
				}


			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.'; float: right" '.$scrpt_active_status.'>
            <a id="hot_a" href="'.$link_main_m_multy.$extension.'">
			<span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">'.$main_menu_name2.'</span> <span class="glyph glyph-angle-down"></span></a>';


			echo '<ul id="sami_'.$keym.'a" style="display: none;list-style-type: none;position: absolute; background-color: '.$camp_theme_color.';height: 30px; margin-left: -1.5px;border-width: 1px; border-style: solid; border-color: rgb(217, 217, 217);">';
			$link_main_m_multy = '';

			foreach ($modarray as $keyY => $valueY){
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];

				if(strlen($page_names_arr[$sub_menu_name])>0){
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}

				if($sub_menu_new_link==1){
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px">
            		<a href="' . $sub_menu_link . '"  target="_blank"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
				}else {
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px">
            		<a href="' . $sub_menu_link . $extension . '" class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
				}
			}

		echo '</ul> </li>';
		}
	}
	}
}

?>

</ul>

</div>
</div>

</div>

<?php } ?>