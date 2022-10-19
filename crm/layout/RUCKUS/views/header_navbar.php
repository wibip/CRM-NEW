

<?php if($new_design=='yes'){ ?>

<style type="text/css">



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

 .main .nav-tabs{
    margin: auto;
    box-sizing: border-box;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    text-align: center;
	border-bottom: none;
}


body .nav-tabs:not(.zg-ul-select):not(.dropdown_tabs)>li>a{
	display: inline-block;
	font-size: 18px;
	color: #fff !important;
}

.controls.se_ownload_cr{
	text-align: left !important;
}

.middle.form-horizontal .middle-large{
	width: 100% !important;
}

h2{
	font-family: 'Montserrat-Bold';
    font-size: 20px;
}


.alert {
	box-sizing: border-box;
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

@media (max-width: 979px) and (min-width: 768px){

}

@media (max-width: 768px){

	.colorpicker-component input{
		width: 270px;
	}

	input.span5, textarea.span5, .uneditable-input.span5, input[class*="span"], div[class*="span4"], select[class*="span"], textarea[class*="span"], .uneditable-input{
		width: 250px !important;
		box-sizing: border-box;
		min-height: 28px;
	}

	div.inline-btn, a.inline-btn, button.inline-btn, input[type="submit"].inline-btn{
		margin-left: 0px !important;
    	margin-top: 10px !important;
	}

	.btn-primary:not(.toggle-on):not(.toggle-off):not(.toggle):not(.toggle-handle), .btn-danger:not(.toggle-on):not(.toggle-off):not(.toggle):not(.toggle-handle), .btn-info:not(.toggle-on):not(.toggle-off):not(.toggle):not(.toggle-handle), .btn-warning:not(.toggle-on):not(.toggle-off):not(.toggle):not(.toggle-handle){
		box-sizing: border-box;
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
		height: 400px !important;
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

}

@media (max-width: 420px){
	.main_intro{
		height: 480px !important;
	}
}

@media (max-width: 356px){
	.main_intro{
		height: 500px !important;
	}
}

@media (max-width: 310px){
	.main_intro{
		height: 515px !important;
	}
}


@media (max-width: 1200px){


	.alert {
	    top: 21px !important;
	    box-sizing: border-box;
	}


	.intro_page{
		display: none !important;
	}
	 .main .nav-tabs{
		position: fixed;
    	top: 49px;
    	left: 0;
    	z-index: 555;
	}
	body .nav-tabs:not(.zg-ul-select):not(.dropdown_tabs)>li>a{
		color: #54585A !important;
	}

	#myTabDash, #myTabContentDASH {
	width: 100% !important;
}

	.main .cf .nav-tabs:not(.zg-ul-select):not(.IotTab){
		width: 150px !important;
		padding-left: 0px !important;
	}

	.main .cf .nav-tabs{
    	margin-top: 0px !important;
    	padding-top: 0px !important;
    	padding-bottom: 0px !important;
    	position: absolute;
    	margin-right: 0px;
    	top: 25px;
    	right: -25px;
	}

	.main .cf .nav-tabs.zg-ul-select{
		padding-left: 20px !important;
	}

	#myTabContentDASH .widget-header{
		left: -28px;
	}

	.widget-header h2{
		left: 20px;
	}

	h2{
		font-size: 18px;
		line-height: 24px;
	}

	img[data-toggle="tooltip"] {
		width: 24px !important;
	}

	.form-horizontal .controls, .form-actions{
		padding: 0px !important;
    	margin: auto;
		display: block;
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

body .subnavbar .container>ul>li>ul.dropdown-menu{
	border: none;
}
body .subnavbar .container>ul>li>ul:not(.dropdown-menu){
 		z-index: 2147483647;
 		background-color: #f0f0f3 !important;
		 position: fixed !important;
    	padding: 20px 45px;
    	left: 0;
    	right: 0;
    	box-sizing: content-box;
		display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
 	}

	.tab_links{
		display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
	}

	.tab_links a {
    display: block;
    margin-top: 15px;
    font-size: 16px;
    color: rgb(84,88,90);
}


.tab_links a::before{
    content:
    "";
    -webkit-transition: width .3s cubic-bezier(.39,.575,.565,1),background .3s ease;
    transition: width .3s cubic-bezier(.39,.575,.565,1),background .3s ease;
    background: #E57200;
    height: 2px;
    position: absolute;
    width: 0;
    left: auto;
    right: 0;
    bottom: -4px;
    z-index: 11;
}

.tab_links a:hover::before{
    width:100%;
    right:auto;
    left:0
}

.tab_links a{
    position:relative
}

.tab_links h2 {
	font-size: 22px;
    font-family: 'Montserrat-Medium';
}
 	body{
 		font-family: Montserrat-Regular !important;
 		font-size: 12pt !important;
 	}

.subnavbar-inner{
	height: 100px !important;
	border-bottom: none !important;
	background-color: #fff !important;
}

.subnavbar .container>ul>li.active>a>span:not(.glyph):after{
	top: 70px !important;
}

.subnavbar-inner .container{
	width: 100%;
    padding: 0 60px;
    box-sizing: border-box;
}

h3{
	font-size: 16px;
    font-family: Montserrat-Light;
}

.toastify{
	z-index: 9999999999999999;
	border: 1px solid #D9D9D6;
	border-radius: 10px;
}

@media (min-width: 980px){
	.subnavbar{
		    position: fixed;
    		top: 0px;
    		width: 100%;
    		z-index: 9999999;
	}

	.intro_page{
		margin-top: 100px !important;
	}

}




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
	margin-right: 25px !important;
	height: 100px !important;
	min-width: auto !important;
	line-height: 100px !important;
}

.mainnav ul a{
	padding: 0px !important;
}

.mainnav ul li{
	float: none !important;
	padding: 5px 20px;
	margin-top: 0px !important;
	margin-right: 80px;
}

.dropdown.open .dropdown-toggle{
	background-color: transparent !important;
}
</style>

<?php if($introMnoPage=='NO'){ ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('.main').css('margin-top','100px');
        $('.alert').css('top', '30px');
	});
</script>

<?php } ?>


<?php } ?>

<style type="text/css">

	.no_arrow .glyph-angle-down{
		display: none !important;
	}
	@media (max-width: 1200px){
		.navbar-fixed-top {
			display: block !important;
			position: fixed !important;
		}
		.subnavbar {
			display: none !important;
		}
		.intro_page{
			display: none !important;
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
    background-size: 22px !important;
    background-repeat: no-repeat !important;
    background-position: 0px 37px !important;
    margin-top: 0px !important;
    position: relative;
    padding-right: 20px !important;
	}

	.glyph-angle-down:before {
    content: "\eA12";
}
body .subnavbar .container>ul>li>a>span:not(.glyph), body .subnavbar .container>ul>li>a{
	font-size: 20px !important;
    font-family: 'Montserrat-Light';
}

	.dropdown .glyph{
        position: absolute !important;
    top: 40% !important;
    right: 0;
    display: inline-block !important;
    font-family: 'glyphs' !important;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 1;
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

<?php } ?>
</style>

<div class="navbar navbar-fixed-top"  <?php if($top_menu=='bottom'){ ?> style="display: none;" <?php } ?>>
  <div class="navbar-inner">



    <div id="container_id" class="container">

    <?php

    if($top_menu=='bottom'){
		echo '<a href="intro">'.$log_img.'</a>';
	}
		?>
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
    <span class="icon-bar show"></span>
    <span class="icon-bar show"></span>
    <span class="icon-bar show"></span>
    </a>

         <?php

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

            $full_name = 'My Profile';

    		$full_name1 = 'My Profile';



          ?>





          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="icon-user"></i> <?php  echo $full_name; ?> <b class="caret"></b></a>

            <ul class="dropdown-menu">
				<?php

				if($script!='verification'){
					if(!(isset($_SESSION['p_token']))){
						if($no_profile != '1'){
					?>
              <li><a href="profile<?php echo $extension; ?>">My Profile</a></li>
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
$menutype = $db_class1->setVal('menu_type','ADMIN');
$tab_links = $package_functions->getOptions('TAB_LINKS',$system_package);
			   $tab_links = json_decode($tab_links,true);
if($menutype=="SUB_MENU"){

	if($top_menu=="bottom"){
				echo '<li class="no_arrow" style="line-height:60px; margin-right: 10px"><a href="intro">'.$log_img.'</a></li>';
				echo '<style> .logo_img{ max-height: 70px !important; float: none !important; } </style>';
	}

	$mod_size_arr = sizeof($main_mod_array);

	if($mod_size_arr <5){
		$mod_size_arr =5;
	}


	if($top_menu=="bottom"){
		$mod_size_arr = $mod_size_arr + 2;

		if($mod_size_arr >= 7){
			$mod_size_arr = $mod_size_arr + 0.5;
		}
	}

	$width_li = intval(99)/$mod_size_arr.'%';
	$css = "";
	if($mod_size_arr >6){
		$width_li = 'auto';
		$css = "margin-right: 2px;";
	}

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
	foreach ($main_mod_array as $keym => $valuem){
		if(++$i === $numItems) {
			$css_right = 'border-right: 1px solid #d9d9d9;';
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

			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.$css.'" '.$scrpt_active_status.'>
            <a id="hot_a" style="cursor: default">
			<span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">'.$main_menu_name2.'</span> <span class="glyph glyph-angle-down"></span></a>';

			if(sizeof($valuem['module'])==1){
				$style_tag1 = "width: auto";
				$style_tag2 = 'white-space: nowrap';
				$add_class = "single";
			}
			else{
				$style_tag1 = "";
				$add_class = "multi";
			}
			echo '<ul id="sami_'.$keym.'a" style="display: none;list-style-type: none;position: absolute; background-color: '.$camp_theme_color.';height: 30px; margin-left: -1.5px;border-width: 1px; border-style: solid; border-color: rgb(217, 217, 217);'.$style_tag1.'"><div class="tab_links">';
			$link_main_m_multy = '';
			foreach ($modarray as $keyY => $valueY){
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];

				if(strlen($page_names_arr[$sub_menu_name])>0){
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}

				if($sub_menu_link=='home'){

					$feture_section_array= json_decode($package_functions->getOptions('DASH_SECTIONS',$system_package),true);

				  $q = "SELECT ssid,wlan_name FROM exp_locations_ssid_private WHERE distributor='$user_distributor'
   UNION
   SELECT ssid,wlan_name FROM exp_locations_ssid WHERE distributor = '$user_distributor'
   UNION
   SELECT ssid,wlan_name FROM exp_locations_ssid_vtenant WHERE distributor = '$user_distributor'";

$network_names = $db_class1->selectDB($q);

$graph_number = 0;

$graph_number1 = 0;

////Dash Board Sections//////////
$get_section_code_q = "SELECT u.`section_code` AS a,s.`section_name` AS b FROM `dashboard_sections` s,`dashboard_sections_user_type` u  WHERE u.`section_code`=s.`section_code`
AND `dashboard_code`='DASH01' AND u.user_type='$user_type' AND u.is_enable=1 ORDER BY order_number ASC";
$get_section_code=$db_class1->selectDB($get_section_code_q);

$section_array=array();
$a=0;

$features=$db_class1->getValueAsf("SELECT `features` AS f FROM `exp_mno_distributor` d JOIN mno_distributor_parent p ON d.`parent_id` = p.`parent_id` WHERE `distributor_code`='$user_distributor'");
$features = json_decode($features,true);
$Iot_enable = false;
foreach ($features as $key => $value) {
	if ($key == 'IOT') {
		$Iot_enable = true;
	}
}
//$feture_section_guest_array= explode(",",$package_functions->getOptions('DASH_GUEST_SECTIONS',$system_package));
//print_r($feture_section_guest_array);
//$feture_section_private_array= explode(",",$package_functions->getOptions('DASH_PRIVATE_SECTIONS',$system_package));

$vernum=$db_class1->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'");
$nettype=$db_class1->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");
//print_r($feture_section_array['guest']);
if($nettype=='BOTH' || $nettype=='PUBLIC-PRIVATE'){

$fesegparray=array_merge($feture_section_array['guest'],$feture_section_array['private']);

}elseif($nettype=='GUEST' || $nettype=='PUBLIC'){

$fesegparray=$feture_section_array['guest'];

}elseif($nettype=='PRIVATE'){

$fesegparray=$feture_section_array['private'];
}elseif($nettype=='VT'){
$fesegparray=$feture_section_array['vt'];
}elseif($nettype=='VT-BOTH'){
$fesegparray=array_merge($feture_section_array['vt'],$feture_section_array['guest'],$feture_section_array['private']);
}elseif($nettype=='VT-GUEST'){

$fesegparray=array_merge($feture_section_array['vt'],$feture_section_array['guest']);
}elseif($nettype=='VT-PRIVATE'){

$fesegparray=array_merge($feture_section_array['vt'],$feture_section_array['private']);
}else{

$fesegparray=array();

}

$fesegparray = array_unique($fesegparray);
/*print_r($fesegparray);*/

$WLAN_select_graph_list = json_decode($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT',$system_package),true);
$WLAN_select_graph_list_des = $package_functions->getSectionType('DSF_GRAPH_WLAN_SELECT',$system_package);
//$WLAN_select_graph_list_drop = json_decode($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT_DROP',$system_package),true);
//print_r($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT',$system_package));
$advanced_features=$db_class1->getValueAsf("SELECT `advanced_features` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");
$overview_disabele= false;

if(strlen($advanced_features) > 0){

$advanced_features = json_decode($advanced_features,true);

foreach ($fesegparray as $key => $value) {
/*if($advanced_features[$value] == '0'){
unset($fesegparray[$key]);
}*/

if($advanced_features['network_at_a_glance']=='0' && $value=='NVI_TREE_SEC_COX'){

$overview_disabele= "disabele";
unset($fesegparray[$key]);
}

if($advanced_features['top_applications']=='0' && $value=='DSF_TOP_APP_COX'){
unset($fesegparray[$key]);
}
}
}


$psndg_count=count($fesegparray);

$cl_arr = [];
$inf_arr = [];
$ses_arr = [];
$iot_arr = [];
foreach ($get_section_code['data'] as $rows) {//dashsections
$section_code=$rows[a];
$section_name=$rows[b];

if ($section_code == 'NVI_TREE_SEC_ALT' && $property_business_type != 'SMB')
			continue;

			if (($section_code == 'CLIENT_DETAILS' || $section_code == 'DSF_TOP_APP_COX') && $property_wired == '1')
			continue;

			if ($section_code == 'NVI_TREE_SEC_OPT' && $property_business_type == 'SMB' && ($system_package == 'LP_SIMP_001_New' || $system_package == 'LP_SIMP_Optimum_New' || $system_package == 'LP_SIMP_Suddenlink_New'))
			continue;

if ($section_name == 'Network') {
$section_name = 'Summary';
}
$section_name = str_replace('{$wifi_txt}', '', $section_name);


if($psndg_count==0){

if(in_array($section_code,$feture_section_array) || $package_features=="all")   {
	if($section_code == 'CLIENT_DETAILS' || $section_code == 'TOP20_CLIENT_DETAILS' ){
		array_push($cl_arr,["tab"=>$a,"section_name"=>$section_name]);
	}
	if($section_code == 'WIFI_INFORMATION' || $section_code == 'NVI_TREE_SEC_COMCAST' ){
		array_push($inf_arr,["tab"=>$a,"section_name"=>$section_name]);
	}
	if($section_code == 'ARRIS_CDR_API_GRAPH_RUCKUS' || $section_code == 'DSF_TOP_APP_COX' || $section_code == 'MOST_POP_FROM_ALL_SESSIONS'){
		array_push($ses_arr,["tab"=>$a,"section_name"=>$section_name]);
	}
	if($section_code == 'IOT' && $Iot_enable){
		array_push($iot_arr,["tab"=>$a,"subtab"=>'1',"section_name"=>"Floor Plan"]);
		array_push($iot_arr,["tab"=>$a,"subtab"=>'2',"section_name"=>"Cameras"]);
		array_push($iot_arr,["tab"=>$a,"subtab"=>'3',"section_name"=>"Devices"]);
		array_push($iot_arr,["tab"=>$a,"subtab"=>'4',"section_name"=>"Event Logs"]);
		array_push($iot_arr,["tab"=>$a,"subtab"=>'5',"section_name"=>"IoT Insights"]);
	}
  $section_array[$a]=$section_code;
  $a++;
}

}else{

if(in_array($section_code,$fesegparray) || $package_features=="all")   {
	if($section_code == 'CLIENT_DETAILS' || $section_code == 'TOP20_CLIENT_DETAILS' ){
		array_push($cl_arr,["tab"=>$a,"section_name"=>$section_name]);
	}
	if($section_code == 'WIFI_INFORMATION' || $section_code == 'NVI_TREE_SEC_COMCAST' ){
		array_push($inf_arr,["tab"=>$a,"section_name"=>$section_name]);
	}
	if($section_code == 'ARRIS_CDR_API_GRAPH_RUCKUS' || $section_code == 'DSF_TOP_APP_COX' || $section_code == 'MOST_POP_FROM_ALL_SESSIONS'){
		array_push($ses_arr,["tab"=>$a,"section_name"=>$section_name]);
	}
	if($section_code == 'IOT' && $Iot_enable){
		array_push($iot_arr,["tab"=>$a,"subtab"=>'1',"section_name"=>"Floor Plan"]);
		array_push($iot_arr,["tab"=>$a,"subtab"=>'2',"section_name"=>"Cameras"]);
		array_push($iot_arr,["tab"=>$a,"subtab"=>'3',"section_name"=>"Devices"]);
		array_push($iot_arr,["tab"=>$a,"subtab"=>'4',"section_name"=>"Event Logs"]);
		array_push($iot_arr,["tab"=>$a,"subtab"=>'5',"section_name"=>"IoT Insights"]);
	}
  $section_array[$a]=$section_code;

  $a++;

}

}



}

if(!empty($inf_arr)){

	echo '<li><h2>Network Information</h2>';
	foreach ($inf_arr as $value) {
		echo '<a href="home?t='.$value["tab"].'">' . $value["section_name"] . '</a>';
	}
	echo '</li>';
}
if(!empty($cl_arr)){
echo '<li><h2>Client Information</h2>';
foreach ($cl_arr as $value) {
	echo '<a href="home?t='.$value["tab"].'">' . $value["section_name"] . '</a>';
}
echo '</li>';
}
if(!empty($ses_arr)){
echo '<li><h2>Session Information</h2>';
foreach ($ses_arr as $value) {
	echo '<a href="home?t='.$value["tab"].'">' . $value["section_name"] . '</a>';
}
echo '</li>';
}
if(!empty($iot_arr)){
echo '<li><h2>IoT</h2>';
foreach ($iot_arr as $value) {
	echo '<a href="home?t='.$value["tab"].'&ts='.$value["subtab"].'">' . $value["section_name"] . '</a>';
}
echo '</li>';
}

			  }elseif($sub_menu_link=='network_pr'){
				echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px"><h2>'.$sub_menu_name.'</h2>';
				echo '<a href="'.$sub_menu_link.'">SSID</a>';
				echo '<a href="'.$sub_menu_link.'?t=2">Schedule</a>';
			  }
			  else{

if($sub_menu_name=="Content Filter" || $sub_menu_name=="User Guide"){
	$target = "";
	if($sub_menu_name=="User Guide"){
		$target = "_blank";
	}
	echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px"><h2>'.$sub_menu_name.'</h2>
	<a href="' . $sub_menu_link . '"  target="'.$target.'"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
}else{
	if($sub_menu_new_link==1){
		echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px">
		<a href="' . $sub_menu_link . '"  target="_blank"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
	}else{
		echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px"><h2>'.$sub_menu_name.'</h2>';
	}
	foreach ($modules[$user_type][$sub_menu_link] as $value) {
		echo '<a href="'.$sub_menu_link.'?t='.$value['id'].'">'.$value['name'].'</a>';
	}
			}
			}
		}

		echo '</div></ul> </li>';

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


				echo '<li style="width: '.$width_li.';'.$css_right.'" '.$scrpt_active_status.'>
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

			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.'" '.$scrpt_active_status.'>
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

				if(!empty($tab_links[$sub_menu_link])){
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px"><h2>'.$sub_menu_name.'</h2>';
					foreach ($tab_links[$sub_menu_link] as $key => $value) {

						switch ($key) {
							case 'DEFAULT':
								foreach ($value as $value1) {
									echo '<a href="'.$value1[0].'">'.$value1[1].'</a>';
								}
								break;
							case 'USERTYPE!SUPPORT':
								if($user_type!="SUPPORT"){
									foreach ($value as $value1) {
										echo '<a href="'.$value1[0].'">'.$value1[1].'</a>';
									}
								}
								break;
							case 'USERTYPESUPPORT':
								if($user_type=="SUPPORT"){
									foreach ($value as $value1) {
										echo '<a href="'.$value1[0].'">'.$value1[1].'</a>';
									}
								}
								break;
							case 'USERTYPEMNO':
								if($user_type=="MNO"){
									foreach ($value as $value1) {
										echo '<a href="'.$value1[0].'">'.$value1[1].'</a>';
									}
								}
								break;
							case 'USERTYPEMVNO_ADMIN':
								if($user_type=="MVNO_ADMIN"){
									foreach ($value as $value1) {
										echo '<a href="'.$value1[0].'">'.$value1[1].'</a>';
									}
								}
								break;
							case 'USERTYPEMNO||SUPPORT!ACCESSSUPPORT':
								if($user_type=="SUPPORT" || $user_type=="MNO"){
									if(!in_array('support', $access_modules_list)){
										foreach ($value as $value1) {
											echo '<a href="'.$value1[0].'">'.$value1[1].'</a>';
										}
									}
								}
								break;

							default:
								if(in_array($key,$features_array) || $package_features=="all"){
									echo '<a href="'.$value[0].'">'.$value[1].'</a>';
								}
								break;
						}
					}

					echo '</li>';
				}
			}

		echo '</ul> </li>';
		}
	}
	}
}

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

    $full_name = 'My Profile';

    $full_name1 = 'My Profile';
?>



<li class="dropdown" style="<?php echo $li_style; ?>"><a style="<?php echo $a_style; ?>" href="#" class="dropdown-toggle" data-toggle="dropdown">
           <?php echo $full_name1; ?> <span class="glyph glyph-angle-down"></span></a>

            <ul class="dropdown-menu" style="left: -30px">
				<?php

				if($script!='verification'){

				if(!(isset($_SESSION['p_token']))){
					if($no_profile != '1'){
				?>
              		<li><a href="profile<?php echo $extension; ?>">My Profile</a></li>
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

          <?php } ?>

</ul>

</div>
</div>

</div>

<?php } ?>