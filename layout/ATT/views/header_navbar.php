
<style type="text/css">

	.mainnav ul li.subLi{
		color: #b7b7b7;
		padding: 6px 20px;
		padding-bottom: 0px;
		font-size: 12px;								
	}
	hr.divid{
		background: #a9a9a9;
		border:none;
		height: 1px;
		margin-top: 5px;
		margin-left: 20px;
		margin-right: 20px;
		margin-bottom: 0px;
	}
	.mainnav ul li.subLi div{
		margin-left:10px;
		word-break: break-word;
	}
	.mainnav ul li.subLi div::before {
		content: "\f0a4";
		font-family: FontAwesome;
		margin-right: 5px;
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
   /* background : url('layout/<?php echo $camp_layout ?>/img/user.png') !important;*/
    background-size: 22px !important;
    background-repeat: no-repeat !important;
    background-position: 0px 16px !important;
    margin-top: 0px !important;
    position: relative;
    padding-right: 20px !important;
	}

	body .subnavbar-inner{
			background-color: #191919 !important;
		   /* background-color: #1a2027 !important;*/
		    border-bottom: none;
	}



	.glyph-angle-down:before {
    content: "\eA12";
}
body .subnavbar .container>ul>li>a>span:not(.glyph), body .subnavbar .container>ul>li>a{
	font-size: 16px !important;
    font-family: Regular !important;
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
    line-height: 80px;
    -webkit-font-smoothing: antialiased;
}

.glyph{
        position: relative !important;
    top: 0;
    display: inline-block !important;
    font-family: 'glyphs' !important;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 80px;
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
		echo '<a href="intro">'.$log_img.'<span style="width: 100%;color: white;font-size: 15px;padding: 5px;font-family: Rlite;">AT&amp;T Business</span></a>';
	}
		?>
    <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
    <span class="icon-bar show"></span>
    <span class="icon-bar show"></span>
    <span class="icon-bar show"></span>
    </a>

         <?php 
        
		/// PAGE TITLE IS HERE ?>

                    <?php
                   
                 
                    //$page_names = $package_functions->getOptions('HEADER_PAGE_NAMES',$system_package);

          			//$page_names_arr = json_decode($page_names,true);


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
          				//if($sub_menu_link == $script) continue;
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
if($menutype=="SUB_MENU"){

	if($top_menu=="bottom"){
				echo '<li class="no_arrow" style="line-height:80px; margin-right: 10px"><a href="intro">'.$log_img.'</a></li>';
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

			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.'" '.$scrpt_active_status.'>
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
			//	if($sub_menu_link == $script) continue;
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
          	$li_style = "float: right; line-height: 80px;";
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
              
              <?php } 
			  
			  if($user_type=="MVNO"){

				$query="SELECT `property_id`,`parent_id`  FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'";

				$query=$db_class1->selectDB($query);
				foreach ($query['data'] as $row) {
					$parent_id = $row['parent_id'];
					$property_id = $row['property_id'];
				}

				echo '<hr class="divid"></hr><li class="subLi">Property ID  <div>'.$property_id.'</div></li>';
				echo '<li class="subLi" style="padding-top: 0px;">Business ID <div>'.$parent_id.'</div></li>';
			  }elseif($user_type=="MVNO_ADMIN"){

				echo '<hr class="divid"></hr><li class="subLi">Business ID  <div>'.$user_distributor.'</div></li>';
			  }
			  
			  ?>
            </ul>


          </li>

          <?php } ?>

</ul>

</div>
</div>

</div>

<?php } ?>