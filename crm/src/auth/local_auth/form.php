<form action="<?php echo $login_main_url; ?>" method="post" autocomplete="off">


	<?php
	if($MMFailed == '0'){
		echo '<div class="alert alert-success">
		Login successful. Redirecting 23....
		</div>';
	}
	else{


	include 'layout/'.$camp_layout.'/login.html';

        $robot_verify_functions->form();

	if($MMFailed == '1'){
		echo '<div class="error-wrapper bubble-pointer mbubble-pointer submit-error" ><p>'.$MMFailedMassage.'</p></div><br/>';
	}

	?>
	<div class="login-actions">

	<button type="submit" name="sign_in" class="button btn btn-primary btn-large"style="background-color: <?php echo $camp_theme_color; ?>;"><font color="white">Sign In</font></button>

	</div> <!-- .actions -->
	<!--<a href="< ?php echo $veri_login; ?>">First Time User? Click here to Activate your Account</a>
	<br>-->
	<a href="<?php echo $reset_admin_main_url; ?>" class="">
		Forgot Password?
	</a>
	<!--<br>
	<a href="< ?php echo $reset_admin_main_url; ?>" class="">
		Forgot support or systems admin password?
	</a>-->
	<?php
	}
	?>


</form>