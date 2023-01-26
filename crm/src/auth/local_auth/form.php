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

	if($MMFailed == '1' || (isset($_SESSION['open_error']) && $_SESSION['open_error'] == 1)){
		if(isset($_SESSION['open_error'])) {
				$MMFailedMassage = $_SESSION['open_error_msg'];
		}
		
		echo '<div class="error-wrapper bubble-pointer mbubble-pointer submit-error" ><p>'.$MMFailedMassage.'</p></div><br/>';
		$_SESSION['open_error'] = null;
		$_SESSION['open_error_msg'] = null;
		unset($_SESSION['open_error']);
		unset($_SESSION['open_error_msg']);
	}

	?>
	<div class="login-actions">

	<button type="submit" name="sign_in" class="button btn btn-primary btn-large"style="background-color: <?php echo $camp_theme_color; ?>;"><font color="white">Sign In</font></button>
	<a href="<?php echo $reset_admin_main_url; ?>" class="">
		Forgot Password?
	</a>
	</div> <!-- .actions -->
	<!--<a href="< ?php echo $veri_login; ?>">First Time User? Click here to Activate your Account</a>
	<br>-->

	<!--<br>
	<a href="< ?php echo $reset_admin_main_url; ?>" class="">
		Forgot support or systems admin password?
	</a>-->
	<?php
	}
	?>

	<h3 class="hr-lines">OR</h3>

	<a href="/OID" class="">
		Login with OpenID
	</a>


</form>