<?php ob_start();?>
<!DOCTYPE html>

<html lang="en">

<?php

if($_POST['button']== 'in'){
	
	
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$zip = $_POST['zip'];
	$file = 'subscribe/subscribe.csv';
	$current = file_get_contents($file);
	$current .= $email.",".$zip.",".$mobile."\n";
	$saved_file = file_put_contents($file, $current);
	
	    if (($saved_file === false) || ($saved_file == -1)) {
			echo 'Record update failed';
		}
		else{
			echo 'Record has been submitted';
		}

}
?>


<head>

<meta charset="utf-8">

<title>MP</title>
</head>
<body>

 <form method="POST">
                                <div class="form-row">
                                  <div class="form-group col-md-12 col-lg-8">                               
                                    <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Your Email">
                                  </div>                                 
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4 col-lg-3">                               
                                      <input type="number" name="zip" class="form-control" id="inputEmail4" placeholder="Zip Code">
                                    </div>
                                    <div class="form-group col-md-8 col-lg-5">                               
                                        <input type="number" name="mobile" class="form-control" id="inputEmail4" placeholder="Mobile Number">
                                      </div>                                 
                                  </div>
                                  <div class="form-row">
                                      <div class=" col-3 col-md-4 col-lg-3">
                                        <button type="submit" name="button" value="in" class="btn btn-primary btn-lg in-btn">I'm In</button>
                                      </div>
                                      <div class="col-9 col-md-8 col-lg-5 small">
                                          <p>By submitting your cell phone number you</p>
                                          <p>are agreeing to receive periodic text </p>
                                          <p>messages from JLP. Message and data rates</p>
                                          <p>may apply. Text STOP to stop receiving</p>
                                          <p>messages. Privacy Policy here.</p>
                                        
                                      </div>
                                  </div>                               
                              </form>



</body>

</html>