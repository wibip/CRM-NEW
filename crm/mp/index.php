<!doctype html>
<?php session_start(); ?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <title>Fayval Williams, MP</title>
  </head>
  <body>
      <div class="wrapper " >
          <!-- <div>
            <img src="img/user.png" height="955" alt="lady" class="lady-img">
          </div> -->
        <nav class="navbar">
            <a class="navbar-brand" href="#">
            <img src="img/logo.png" width="150" height="50" alt="" loading="lazy">
            </a>
        </nav>  
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 pt-col">
                        <div class="left-top">
                            <p>HONORABLE</p>
                            <p><b>Fayval Williams, MP</b></p>
                            <p>Creating a NEW JAMAICA</p>    
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-10 pt-col">
                                <div class="left-bottom">
                                    <h3>We're on  <br>the right track!</h3>
                                    <div class="row ">
                                        <div class="col-5 col-md-7 left-p mb-4">
                                            <p>lowest</p>
                                            <p>employment</p>
                                            <p>in history</p>
                                        </div>
                                        <div class="col-6 col-md-5 right-h">
                                            <h2>7.2%</h2>
                                        </div>
                                        <div class="col-5 col-md-7 left-p">
                                            <p>Longest period of</p>
                                            <p>economic growth</p>
                                            <p>20 straight quaters</p>
                                        </div>
                                        <div class="col-6 col-md-5 right-h">
                                            <h2>5 Yrs</h2>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>                      
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-3">
                        <img src="img/user.png" height="955" alt="lady" class="lady-img">
                    </div>
                    <div class="col-12 col-md-12 col-lg-5 pt-col">
                        <div class="right-top">
                            <h1>I want to hear <br> from you.</h1>
                            <h3>Share your opinion.</h3>
                            <a href="" class="btn btn-primary btn-lg" role="button">Email Me</a>
							
								<?php
                            $msg = "";
							if($_POST['button']== 'in'){
								
								   if($_POST['update_secret']==$_SESSION['FORM_SECRET']){	
									$email = $_POST['email'];
									$mobile = $_POST['mobile'];
									$zip = $_POST['zip'];
									$file = 'subscribe/subscribe.csv';
									$current = file_get_contents($file);
									$current .= $email.",".$zip.",".$mobile."\n";
									$saved_file = file_put_contents($file, $current);
									
										if (($saved_file === false) || ($saved_file == -1)) {
											$msg = '<div class="col-md-12 col-lg-10" style="margin-bottom: 5px;"><div style="background: #0000004f;color: #ffffff;">Record update failed</div></div>';
										}
										else{
											$msg = '<div class="col-md-12 col-lg-10" style="margin-bottom: 5px;"><div style="background: #0000004f;color: #ffffff;">Record has been submitted</div></div>';
										}
								   }


							}

								$secret=md5(uniqid(rand(), true));
								$_SESSION['FORM_SECRET'] = $secret;
								
								
							?>
							
							
                            <form method="POST">
                                <div class="form-row">
								 <?php echo $msg; ?>
                                  <div class="form-group col-md-12 col-lg-10">        
								<input type="hidden" name="update_secret" value="<?php echo $_SESSION['FORM_SECRET']; ?>">								  
                                    <input type="email" name="email"  class="form-control" id="inputEmail4" placeholder="Your Email" required>
                                  </div>                                 
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4 col-lg-4">                               
                                      <input type="number" name="zip" class="form-control" id="inputEmail4" placeholder="Zip Code" required>
                                    </div>
                                    <div class="form-group col-md-8 col-lg-6">                               
                                        <input type="number" name="mobile" class="form-control" id="inputEmail4" placeholder="Mobile Number" required>
                                      </div>                                 
                                  </div>
                                  <div class="form-row">
                                      <div class=" col-3 col-md-4 col-lg-4">
                                         <button type="submit" name="button" value="in" class="btn btn-primary btn-lg in-btn">I'm In</button>
                                      </div>
                                      <div class="col-9 col-md-8 col-lg-6 small">
                                          <p>By submitting your cell phone number you</p>
                                          <p>are agreeing to receive periodic text </p>
                                          <p>messages from JLP. Message and data rates</p>
                                          <p>may apply. Text STOP to stop receiving</p>
                                          <p>messages. Privacy Policy here.</p>
                                        
                                      </div>
                                  </div>                               
                              </form>
                        </div>
                        
                    </div>
                </div>
            </div>
    
        </section>      
      </div>
      
      <!-- Mobile Section -->
      
      <div class="mobi-wrapper" > 
        <div class="cotainer">
            <nav class="navbar">
                <div class="name-tag">
                    <p>HONORABLE</p>
                    <p><b>Fayval Williams, MP</b></p>
                    <p>Creating a NEW JAMAICA</p>    
                </div> 
                <a class="navbar-brand" href="#">
                <img src="img/logo.png" width="100" height="45" alt="" loading="lazy">
                </a>
                </nav>    
            <div class="mob-img" id="overlay">
                <img  src="img/user.png" height="680" alt="lady" class="mob-lady-img" >
            </div>
            
            <div class="content">               
                        <div class="top">
                            <h4>We're on  <br>the right track!</h4>
                            
                            <div class="row">
                                <div class="col-6 col-md-7 left-p mb-4">
                                    <p>lowest</p>
                                    <p>employment</p>
                                    <p>in history</p>
                                </div>
                                <div class="col-6 col-md-5 right-h">
                                    <h3>7.2%</h3>
                                </div>
                                <div class="col-6 col-md-7 left-p">
                                    <p>Longest period of</p>
                                    <p>economic growth</p>
                                    <p>20 straight quaters</p>
                                </div>
                                <div class="col-6 col-md-5 right-h">
                                    <h3>5 Yrs</h3>
                                </div>
                            </div>
                            
                        </div>
                                            
                <div class="bottom">
                    <h3>I want to hear <br> from you.</h3>
                    <h6>Share your opinion.</h6>
                    <a href="" class="btn btn-primary " role="button">Email Me</a>
                    <form method="POST">
                        <div class="form-row">
						 <?php echo $msg; ?>
                          <div class="form-group col-12 col-md-12 col-lg-10">      
							<input type="hidden" name="update_secret" value="<?php echo $_SESSION['FORM_SECRET']; ?>">						  
                            <input type="email" name="email"  class="form-control" id="inputEmail4" placeholder="Your Email" required>
                          </div>                                 
                        </div>
                        <div class="form-row">
                            <div class="form-group col-5 col-md-4 col-lg-4">                               
                              <input type="number" name="zip" class="form-control" id="inputEmail4" placeholder="Zip Code" required>
                            </div>
                            <div class="form-group col-7 col-md-8 col-lg-6">                               
                                <input type="number" name="mobile" class="form-control" id="inputEmail4" placeholder="Mobile Number" required>
                              </div>                                 
                          </div>
                          <div class="form-row">
                              <div class=" col-4 col-md-4 col-lg-4">
                                 <button type="submit" name="button" value="in" class="btn btn-primary btn-lg in-btn">I'm In</button>
                              </div>
                              <div class="col-8 col-md-8 col-lg-6 small">
                                  <p>By submitting your cell phone number you</p>
                                  <p>are agreeing to receive periodic text </p>
                                  <p>messages from JLP. Message and data rates</p>
                                  <p>may apply. Text STOP to stop receiving</p>
                                  <p>messages. Privacy Policy here.</p>
                                
                              </div>
                          </div>                               
                      </form>
                </div>
            </div>
        </div>
        
      </div>

      <!-- Mobile Section End-->
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>