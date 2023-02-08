<?php 
$icon_arr = [
	'Configuration'=> 'fa-solid fa-gear',
	'Operations'=> 'fa-solid fa-screwdriver-wrench',
	'Operators'=> 'fa-solid fa-user-gear',
	'Roles'=> 'fa-solid fa-users-gear',
	'Users'=> 'fa-solid fa-users',
	'Logs'=> 'fa-solid fa-inbox',
	'CRM'=> 'fa-solid fa-people-group',
	'OPSaaS'=> 'icon-group',
	'Clients'=> 'icon-group',
	'Properties'=> 'icon-building',
	'Admin Config'=> 'fa-solid fa-pen-to-square'
];
if ($script != 'verification') {

?>

<div class="sidebar">
	<ul>
		<li class="flex-center">
		<img src="layout/ARRIS/img/sm-logo.png" alt="" srcset="" style="max-height: 50px"><span>RUCKUS</span></li>
<?php 

$numItems = count($main_mod_array);
	
$i = 0;
$active_title = "Switch Accounts";
if($script == 'operation_list'){
	$active_title = "";
}
foreach ($main_mod_array as $keym => $valuem) {
	if (strlen($valuem['active'])) {
		$scrpt_active_status = ' class="active"';
	} else {
		$scrpt_active_status = '';
	}


	foreach($valuem['module'] as $key=>$checkVal){
		if(in_array( "Switch Accounts" ,$checkVal)){
			unset($valuem['module'][$key]);
		}
	}
		/// Single Item
			// echo $script;
		if (sizeof($valuem['module']) == 1) {
			//print_r($valuem['module']);
			foreach ($valuem['module'] as $keyY => $valueY) {
				$link_main_m =  $valueY['link'];
				$menu_item_row_id = $valueY['menu_item'];
			}
			$main_menu_name = $valuem['name'];

			$main_menu_name = $package_functions->getPageName($link_main_m, $system_package, $main_menu_name);

			if (strlen($page_names_arr[$main_menu_name]) > 0) {
				$main_menu_name = $page_names_arr[$main_menu_name];
			}
				;
			if($link_main_m==$script){
				$active = 'active';
				$active_title = $main_menu_name;
			}else{
				$active = '';
			}

			echo '<li class="'.$active.'"><div><i class="'.$icon_arr[$main_menu_name].' show"></i><span><a href="' . $link_main_m . '">'.$main_menu_name.'&nbsp;&nbsp;</a></span></div></li>';

		}

		/// Multy Item
		else {
			$main_menu_name2 = $valuem['name'];
			$modarray = $valuem['module'];
			ksort($modarray);
			foreach ($modarray as $keyZ => $valueZ) {

				if (strlen($link_main_m_multy) == 0)
					$link_main_m_multy =  $valueZ['link'];
			}

			$main_menu_name2 = $package_functions->getPageName($link_main_m_multy, $system_package, $main_menu_name2);

			if (strlen($page_names_arr[$main_menu_name2]) > 0) {
				$main_menu_name2 = $page_names_arr[$main_menu_name2];
			}

			$li = '';
			$main_active = '';
			foreach ($modarray as $keyY => $valueY) {
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];


				if (strlen($page_names_arr[$sub_menu_name]) > 0) {
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}
				if($sub_menu_link==$script){
					$active = 'active';
					$active_title = $main_menu_name;
					$main_active = 'active';
				}else{
					$active = '';
				}
				if($sub_menu_name != 'Switch Accounts'){
					$li .= '<li class="'.$active.'"><a href="' . $sub_menu_link . $extension . '">' . $sub_menu_name . '</a></li>';
				}
			}

			echo '<li class="'.$main_active.'"><div><i class="'.$icon_arr[$main_menu_name2].' show"></i><span><a>'.$main_menu_name2.'&nbsp;&nbsp;</a></span></div><ul class="scnd">'.$li.'</ul> </li>';
		}
}

// if($_SESSION['SADMIN'] == true && isset($_SESSION['section']) && $_SESSION['section'] != 'ADMIN') {
// // 	echo '<li><a href="./change_portal?section='.$_SESSION["section"].'">Change portal</a></li>';
// 	echo '<li><a href="./change_portal?section='.$_SESSION["section"].'"><div><i class="icon-signin show"></i><span>Switch Accounts&nbsp;&nbsp;</span></div></a></li>';
// }

?>
	</ul>
	<span class="footer"></span>
</div>
<div class="top-bar">
	<div class="title"><i class="icon-reorder show"></i><?php echo $active_title; ?></div>
	<div class="nav-right">
	<?php if($_SESSION['SADMIN'] == true) { ?>
		<li class="dropdown" style="margin-right: 20px;">
			<?=$loggedMessage?></li>
		<li class="dropdown" style="margin-right: 20px;">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-signin show"></i> </a>
			<ul class="dropdown-menu">
					<li class=<?=((isset($_SESSION['section']) && $_SESSION['section']== "ADMIN") ? "active" : "")?>><a href="./change_portal?section=ADMIN">Admin</a></li>
					<li class=<?=((isset($_SESSION['section']) && $_SESSION['section']== "MNO") ? "active" : "")?>><a href="./operation_list">Operations</a></li>
					<li class=<?=((isset($_SESSION['section']) && $_SESSION['section']== "PROVISIONING") ? "active" : "")?>><a href="./change_portal?section=PROVISIONING">Client</a></li>
			</ul>
		</li>
	<?php } ?>
	<li class="dropdown" style="<?php echo $li_style; ?>"><a style="<?php echo $a_style; ?>" href="#" class="dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
           <?php echo $full_name1; ?> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" tag="i" class="v-icon notranslate v-theme--dark v-icon--size-default iconify iconify--tabler" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="7" r="4"></circle><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"></path></g></svg></a>

            <ul class="dropdown-menu">
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
	</div>
</div>

<script>
	$(document).ready(function () {
		$('.sidebar').hover(function () {
				$(this).addClass('hover');
			}, function () {
				$(this).removeClass('hover');
			}
		);
		$('.title i').click(function (e) { 
			e.preventDefault();
			$('.sidebar').addClass('hover');
		});
	});
	$(document).mouseup(function(e){
		var container = $(".sidebar");
	
		// If the target of the click isn't the container
		if(!container.is(e.target) && container.has(e.target).length === 0){
			container.removeClass('hover');
		}
	});
</script>

<?php } ?>