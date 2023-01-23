<?php 
$icon_arr = [
	'Configuration'=> 'icon-cogs',
	'Operations'=> 'icon-cog',
	'Roles'=> 'icon-user',
	'Users'=> 'icon-user',
	'Logs'=> 'icon-file-text-alt',
	'CRM'=> 'icon-group',
	'OPSaaS'=> 'icon-group',
	'Clients'=> 'icon-group'
];
if ($script != 'verification') {

?>

<style>
	.dropdown-menu{
		display: block !important;
		opacity: 0;
		transition: all 0.25s;
	}
	.dropdown.open .dropdown-menu{
		opacity: 1;
		z-index: 9999;
	}
	body{
		transition: all .25s ease-in-out;
	}
	body.hover{
		margin-left: 120px;
	}
	.sidebar{
		position: fixed;
		top: 0;
		left: 0;
		bottom: 0;
		width: 80px;
		background: #525e6e;
		z-index: 5;
		overflow: hidden;
		transition: all 0.5s;
	}
	.sidebar.hover{
		width: 250px;
	}
	.sidebar li span {
		color: #fff;
		font-size: 16px;
		opacity: 0;
		transition: all 0.25s;
		overflow: hidden;
		position: relative;
		left: -40px;
	}

	.sidebar.hover li span {
		opacity: 1;
		left: 0;
	}
	.sidebar ul:not(.scnd){
		list-style-type: none;
		margin: 0;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.sidebar ul.scnd{
		margin: 0;
		margin-left: 65px;
		display: none;
	}

	.sidebar ul.scnd li{
		padding: 0;
		color: #fff;
		margin: 10px;
	}

	.sidebar ul.scnd li a{
		font-size: 14px;
		color: #cccccc;
	}

	.sidebar.hover ul.scnd {
		display: block;
	}

	.sidebar a{
		color: #fff;
	}
	.sidebar ul li{
    width: 100%;
			padding: 3px 15px;
			box-sizing: border-box;
			white-space: nowrap;
    text-overflow: ellipsis;
	}
	.sidebar ul li div{
		display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    border-radius: 6px;
    padding-right: 10px;
    -webkit-box-sizing: border-box;
            box-sizing: border-box;
	}
	.sidebar.hover ul li.active div{
    	background: #E57200;
	}
	.sidebar ul li div:hover {
		background: rgb(2 2 2 / 16%);
	}
	.flex-center{
		display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
	}
	.sidebar ul:not(.scnd)>li:nth-child(1){
		padding: 10px;
	}
	.sidebar ul:not(.scnd)>li:nth-child(1) span{
		font-family: 'Montserrat-Bold';
	}
	.sidebar ul li i {
		font-size: 21px;
		color: #fff;
		padding: 10px;
		width: 30px;
		min-width: 30px;
		text-align: center;
	}
	.sidebar ul li.active i{
		background: #E57200;
    	border-radius: 6px;
	}
	.sidebar.hover ul li.active div i{
		background: transparent;
	}
	.top-bar{
		display: flex;
		right: 0;
		margin-left: 80px;
		box-sizing: border-box;
		justify-content: space-between;
		background: #55585a;
		top: 0;
		color: #ffffff;
		backdrop-filter: blur(8px);
		padding: 20px;
		box-shadow: rgb(20 21 33 / 42%) 0px 4px 8px -4px;
		-webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
			position: relative;
    	z-index: 1;
	}
	.top-bar svg{
		width: 20px;
		height: 20px;
		padding: 5px;
		/* box-sizing: border-box; */
		border: 1px solid #fff;
		border-radius: 100%;
		margin-right: 10px;
	}
	.top-bar svg g{
		stroke: #fff;
	}
	.top-bar .title{
		font-size: 16px;
    line-height: 28px;
	display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
	}
	.top-bar .title i{
		margin-right: 16px;
    	font-size: 25px;
	}
	.footer{
		position: absolute;
		bottom: 0;
		font-size: 10px;
		color: #959595;
		left: 0;
		right: 0;
	}
	.top-bar .dropdown{
		list-style-type: none;
	}
	.top-bar .dropdown-menu{
		right: 0;
    	left: auto !important;
	}
	.top-bar .dropdown.open .dropdown-toggle{
		background: none;
	}
	.top-bar .title i{
		display: none;
	}

	.top-bar .nav-right{
		display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
	}
	.dropdown-menu li>a{
		padding: 6px 15px;
	}
	.dropdown-menu .active>a {
		color: #fff !important;
		background: #E57200 !important;
	}
	.top-bar .icon-signin{
		font-size: 28px;
	}
	@media screen and (max-width:767px) {
		.top-bar .title i{
			display: block;
		}
		.top-bar{
			margin-left: 0;
		}
		.sidebar:not(.hover){
			width: 0;
		}
		.container, .navbar-fixed-bottom .container, .navbar-fixed-top .container{
			margin-left: 20px;
		}
		.main {
			margin-top: 0;
		}
	}
</style>
<div class="sidebar">
	<ul>
		<li class="flex-center">
		<img src="layout/ARRIS/img/sm-logo.png" alt="" srcset="" style="max-height: 50px"><span>RUCKUS</span></li>
<?php 

$numItems = count($main_mod_array);
	
$i = 0;
$active_title = "Switch Accounts";
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


			echo '<li><div><i class="'.$icon_arr[$main_menu_name2].' show"></i><span><a>'.$main_menu_name2.'&nbsp;&nbsp;</a></span></div><ul class="scnd">';

			foreach ($modarray as $keyY => $valueY) {
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];


				if (strlen($page_names_arr[$sub_menu_name]) > 0) {
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}

				if($sub_menu_name != 'Switch Accounts'){
					echo '<li><a href="' . $sub_menu_link . $extension . '">' . $sub_menu_name . '</a></li>';
				}
			}

			echo '</ul> </li>';
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
					<li class=<?=((isset($_SESSION['section']) && $_SESSION['section']== "MNO") ? "active" : "")?>><a href="./change_portal?section=MNO">Operations</a></li>
					<li class=<?=((isset($_SESSION['section']) && $_SESSION['section']== "PROVISIONING") ? "active" : "")?>><a href="./change_portal?section=PROVISIONING">Provisioning</a></li>
			</ul>
		</li>
	<?php } ?>
	<li class="dropdown" style="<?php echo $li_style; ?>"><a style="<?php echo $a_style; ?>" href="#" class="dropdown-toggle" data-toggle="dropdown">
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