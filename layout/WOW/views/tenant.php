<div>

		<div class="main-inner">

		

			<div class="container">

			<?php
  if(isset($_SESSION['vio_sub'])){
	  echo $_SESSION['vio_sub'];
	  unset($_SESSION['vio_sub']);
	  }
  
   ?>

			


				<div class="row">

					<div class="span12">

						<div class="widget">


							<div style="text-align: center; margin: 15px 0 40px 0;">
								   <img style="width: 220px;    margin-top: 10px;" src="<?php echo $login_screen_logo_path; ?>"> 
								<!-- <h3 class="h3-mobile" style="font-size: 34px;margin-top: 25px;margin-bottom: 20px;">my Account: A closer look</h3> -->
                               
							</div>
							<!-- /widget-header -->

	<div class="widget-content"  <?php if($violation_count == '3' ){ ?> style="background: none;border: none" <?php }else{ ?> style=";border: none" <?php } ?> >

			<div class="tab-content">

				<div class="tab-pane active" id="create_users">
									
                    <?php 
								   
					$secret=md5(uniqid(rand(), true));
					$_SESSION['FORM_SECRET'] = $secret;
								   
					 if(isset($manage_customer_enable)){ //show manage customer area ?>
  
  <?php
  if(isset($_SESSION['msg_edit'])){
	  echo $_SESSION['msg_edit'];
	  unset($_SESSION['msg_edit']);
	  }
  
   ?>
                                    
     <div class="panel-group" id="accordion">
     		<?php if($violation_count != '3'){ ?> 
        <div class="span11a " >
          
          <!-- /widget -->
          
          <!-- /widget -->
          <div class="widget panel panel-default widget-content main_border">
            <div class="panel-heading my_account_form">
              <h3 color="panel-title " style="font-size: 38px;margin-bottom: 20px"> MY ACCOUNT</h3>

              	<?php if($violation_count != '3'){ ?>
			<a class="accord_icon_a hide_mobile" data-toggle="collapse" data-target="#collapse1" href="JavaScript:Void(0);"><i  class="accord_icon"></i>
			  </a>
			  
			  <?php } ?>
			 
            </div>
			<!-- /widget-header -->
			
		

            <div class="panel-collapse collapse in hide_mobile" id="collapse1">
            <?php 
if($preview_theme_code==""){
?>
                           <form id="edit_customer_form" name="edit_customer_form" action="tenant_account.php" method="post"  class="form-horizontal my_account_form" enctype="multipart/form-data">
                           
                           <?php }else{?>
                        
                           
                           <form id="edit_customer_form" name="edit_customer_form" action="tenant_account.php?th=<?php echo $preview_theme_code; ?>" method="post"  class="form-horizontal my_account_form" enctype="multipart/form-data" onchange="customer_submitenable()">
						   <?php } ?>
            
								
									<?php
									
								echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" /><input type="hidden" name="search_id" id="search_id" value="'.$search_id.'" /><input type="hidden" name="mg_customer_id" id="mg_customer_id1" value="'.$mg_customer_id.'" />';
												
								?>
								
									<fieldset>

									
										<div id="response_d1"></div>
									
                                    
                                    <div class="control-group">
														<label class="control-label" for="radiobtns" >User ID</label>

														<div class="controls form-group">
															

																<input class="span4 form-control" id="email" name="email" type="hidden"  style="width:100%;"  value="<?php echo $mg_email; ?>" readonly>
                                                                <p style="margin-top:3px;"><?php echo $mg_email; ?></p>
																
															
														</div>
														<!-- /controls -->
													</div>

													    <div class="control-group">
											<label class="control-label" for="radiobtns">Current Password <a onclick="show_pass('old_password')" id="cpass" style="float:  right; display: none;">Show Passcode</a> </label>

														<div class="controls form-group">
															

					<input class="span4 form-control allow_char" id="old_password" placeholder="******" name="old_password" type="password" onkeyup="show_pass_buttton(this.value,'cpass')"   value="" style="width:100%;">
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->	

													
                                    
												
                                                    
                                                    <div class="control-group">
														<label class="control-label" for="radiobtns">Update Password <a onclick="show_pass('password')" id="upass" style="float:  right; display: none;">Show Passcode</a></label>

														<div class="controls form-group">
															

																<input class="span4 form-control allow_char" id="password" placeholder="******" name="password" type="password" onkeyup="show_pass_buttton(this.value,'upass')" style="width:100%;"  value="" >
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->													
													



                                       <div class="control-group">
											<label class="control-label" for="radiobtns">Verify Password <a onclick="show_pass('confirm_password')" id="vpass" style="float:  right; display: none;">Show Passcode</a></label>

														<div class="controls form-group">
															

					<input class="span4 form-control allow_char" id="confirm_password" placeholder="******" name="confirm_password" type="password" onkeyup="show_pass_buttton(this.value,'vpass')" onfocus="validatePass(document.getElementById('password'), this);" oninput="validatePass(document.getElementById('password'), this);"  value="" style="width:100%;">
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->	
                                                    
                                                   
                                                
                                                   
                                                    

													<div class="control-group form-di">
														<label class="control-label" for="radiobtns">First Name :</label>

														<div class="controls form-group">
															

																<input class="span4 form-control allow_char" id="first_name" placeholder="John" name="first_name" type="text" style="width:100%;" value="<?php echo $mg_first_name; ?>">
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->


<script type="text/javascript">

	function show_pass_buttton(pass_val,pass_id){
														//alert(pass_val.length);
		if(pass_val.length==0){
			document.getElementById(pass_id).style.display = "none";

		}else{
			document.getElementById(pass_id).style.display = "block";
			}
		}

	function show_pass(refer){

		if($('#'+refer).attr('type') != 'password'){	
			$('#'+refer).attr('type','password');
		}
		else{

			$('#'+refer).attr('type','text');
		}

	}
																	$("#first_name").keypress(function(event){
																		var ew = event.which;
																		
																		if(ew == 8||ew == 0)
																			return true;
																		//if(48 <= ew && ew <= 57)
//																			return true;
																		if(65 <= ew && ew <= 90)
																			return true;
																		if(97 <= ew && ew <= 122)
																			return true;
																		return false;
																	});
																	
																	$('#first_name').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

																
																</script>
													
													
													
													<div class="control-group form-di">
														<label class="control-label" for="radiobtns">Last Name :</label>

														<div class="controls form-group">
															

																<input class="span4 form-control allow_char" id="last_name" placeholder="Pole" name="last_name" type="text" style="width:100%;" value="<?php echo $mg_last_name; ?>" >
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->
													<script type="text/javascript">
																	$("#last_name").keypress(function(event){
																		var ew = event.which;
																		
																		if(ew == 8||ew == 0)
																			return true;
																		//if(48 <= ew && ew <= 57)
//																			return true;
																		if(65 <= ew && ew <= 90)
																			return true;
																		if(97 <= ew && ew <= 122)
																			return true;
																		return false;
																	});
																	
																	$('#last_name').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

																
																</script>
													
													
													
																										
													

												
													<!-- /control-group -->													
													

													
													
													
													
													
                                                    
                                                    
										
														
														
														
													<input id="room" name="room" type="hidden"  value="<?php echo $mg_room_apt_no; ?>">
													<input id="comp_name" name="comp_name" type="hidden" value="<?php echo $mg_company_name; ?>">
														
													<!-- 
													
													<div class="control-group">
														<label class="control-label" for="radiobtns">Room / Apt#</label>

														<div class="controls">
															<div class="input-prepend input-append">

																<input class="span4" id="room" name="room" type="text" style="width:170px;"  value="<?php //echo $mg_room_apt_no; ?>" required>
																
															</div>
														</div>
													</div>
													
													

											<div class="control-group">
														<label class="control-label" for="radiobtns">Company Name<sup><font color="#FF0000" >*</font></sup></label>

														<div class="controls">
															<div class="input-prepend input-append">

																<input class="span4" id="comp_name" placeholder="" name="comp_name" type="text" maxlength="64"   value="<?php //echo $mg_company_name; ?>" style="width:170px;" required>
																
															</div>
														</div>
													</div>
                                                     -->
                                                     <div class="control-group">
														<label class="control-label" for="radiobtns">Local mobile number</label>

														<div class="controls form-group">
															

																<input class="span4 form-control" id="phone" placeholder="xxx-xxx-xxxx" name="phone" type="text" maxlength="12" value="<?php echo $mg_phone; ?>" style="width:100%;"   oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" >
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->	 

                                                    <div class="control-group">
														<label class="control-label" for="radiobtns">Street Address</label>

														<div class="controls form-group">
															

															<textarea class="span4 form-control" name="street_address" id="street_address" cols="250" style="width:100%;height:100px;"  ><?php echo $mg_address; ?></textarea>
																
														  
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->	

													<div class="control-group ">
														<label class="control-label" for="radiobtns">Country</label>

														<div class="controls form-group">
															
																<select class="span4 form-control" name="country" id="country">
								<option value="">Select Country</option>
                                                    <?php
                                                    $count_results=mysql_query("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                                    UNION ALL
                                    SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");
                                                   while($row=mysql_fetch_array($count_results)){
                                                            if($row[a]==$get_edit_mno_country || $row[a]== "US"){
                                                               $select="selected";
                                                            }else{
                                                                $select="";
                                                            }

                                                       echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';

                                                   }
                                                    ?>
											 </select>															
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->	
					<script type="text/javascript">

// Countries
var country_arr = new Array( "United States of America","Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

// States
var s_a = new Array();
var s_a_val = new Array();
s_a[0] = "";
s_a_val[0] = "";
<?php

$get_regions=mysql_query("SELECT
				`states_code`,
				`description`
			  FROM 
			  `exp_country_states` ORDER BY description");

$s_a = '';
$s_a_val = '';

while($state=mysql_fetch_assoc($get_regions)){
$s_a .= $state['description'].'|';
$s_a_val .= $state['states_code'].'|';
}

$s_a = rtrim($s_a,"|");
$s_a_val = rtrim($s_a_val,"|");

?>
s_a[1] = "<?php echo $s_a; ?>";
s_a_val[1] = "<?php echo $s_a_val; ?>";
s_a[2] = "Others";
s_a[3] = "Others";
s_a[4] = "Others";
s_a[5] = "Others";
s_a[6] = "Others";
s_a[7] = "Others";
s_a[8] = "Others";
s_a[9] = "Others";
s_a[10] = "Others";
s_a[11] = "Others";
s_a[12] = "Others";
s_a[13] = "Others";
s_a[14] = "Others";
s_a[15] = "Others";
s_a[16] = "Others";
s_a[17] = "Others";
s_a[18] = "Others";
s_a[19] = "Others";
s_a[20] = "Others";
s_a[21] = "Others";
s_a[22] = "Others";
s_a[23] = "Others";
s_a[24] = "Others";
s_a[25] = "Others";
s_a[26] = "Others";
s_a[27] = "Others";
s_a[28] = "Others";
s_a[29] = "Others";
s_a[30] = "Others";
s_a[31] = "Others";
s_a[32] = "Others";
s_a[33] = "Others";
s_a[34] = "Others";
s_a[35] = "Others";
s_a[36] = "Others";
s_a[37] = "Others";
s_a[38] = "Others";
s_a[39] = "Others";
s_a[40] = "Others";
s_a[41] = "Others";
s_a[42] = "Others";
s_a[43] = "Others";
s_a[44] = "Others";
s_a[45] = "Others";
s_a[46] = "Others";
s_a[47] = "Others";
s_a[48] = "Others";
// <!-- -->
s_a[49] = "Others";
s_a[50] = "Others";
s_a[51] = "Others";
s_a[52] = "Others";
s_a[53] = "Others";
s_a[54] = "Others";
s_a[55] = "Others";
s_a[56] = "Others";
s_a[57] = "Others";
s_a[58] = "Others";
s_a[59] = "Others";
s_a[60] = "Others";
s_a[61] = "Others";
s_a[62] = "Others";
// <!-- -->
s_a[63] = "Others";
s_a[64] = "Others";
s_a[65] = "Others";
s_a[66] = "Others";
s_a[67] = "Others";
s_a[68] = "Others";
s_a[69] = "Others";
s_a[70] = "Others";
s_a[71] = "Others";
s_a[72] = "Others";
s_a[73] = "Others";
s_a[74] = "Others";
s_a[75] = "Others";
s_a[76] = "Others";
s_a[77] = "Others";
s_a[78] = "Others";
s_a[79] = "Others";
s_a[80] = "Others";
s_a[81] = "Others";
s_a[82] = "Others";
s_a[83] = "Others";
s_a[84] = "Others";
s_a[85] = "Others";
s_a[86] = "Others";
s_a[87] = "Others";
s_a[88] = "Others";
s_a[89] = "Others";
s_a[90] = "Others";
s_a[91] = "Others";
s_a[92] = "Others";
s_a[93] = "Others";
s_a[94] = "Others";
s_a[95] = "Others";
s_a[96] = "Others";
s_a[97] = "Others";
s_a[98] = "Others";
s_a[99] = "Others";
s_a[100] = "Others";
s_a[101] = "Others";
s_a[102] = "Others";
s_a[103] = "Others";
s_a[104] = "Others";
s_a[105] = "Others";
s_a[106] = "Others";
s_a[107] = "Others";
s_a[108] = "Others";
s_a[109] = "Others";
s_a[110] = "Others";
s_a[111] = "Others";
s_a[112] = "Others";
s_a[113] = "Others";
s_a[114] = "Others";
s_a[115] = "Others";
s_a[116] = "Others";
s_a[117] = "Others";
s_a[118] = "Others";
s_a[119] = "Others";
s_a[120] = "Others";
s_a[121] = "Others";
s_a[122] = "Others";
s_a[123] = "Others";
s_a[124] = "Others";
s_a[125] = "Others";
s_a[126] = "Others";
s_a[127] = "Others";
s_a[128] = "Others";
s_a[129] = "Others";
s_a[130] = "Others";
s_a[131] = "Others";
s_a[132] = "Others";
s_a[133] = "Others";
s_a[134] = "Others";
s_a[135] = "Others";
s_a[136] = "Others";
s_a[137] = "Others";
s_a[138] = "Others";
s_a[139] = "Others";
s_a[140] = "Others";
s_a[141] = "Others";
s_a[142] = "Others";
s_a[143] = "Others";
s_a[144] = "Others";
s_a[145] = "Others";
s_a[146] = "Others";
s_a[147] = "Others";
s_a[148] = "Others";
s_a[149] = "Others";
s_a[150] = "Others";
s_a[151] = "Others";
s_a[152] = "Others";
s_a[153] = "Others";
s_a[154] = "Others";
s_a[155] = "Others";
s_a[156] = "Others";
s_a[157] = "Others";
s_a[158] = "Others";
s_a[159] = "Others";
s_a[160] = "Others";
s_a[161] = "Others";
s_a[162] = "Others";
s_a[163] = "Others";
s_a[164] = "Others";
s_a[165] = "Others";
s_a[166] = "Others";
s_a[167] = "Others";
s_a[168] = "Others";
s_a[169] = "Others";
s_a[170] = "Others";
s_a[171] = "Others";
s_a[172] = "Others";
s_a[173] = "Others";
s_a[174] = "Others";
s_a[175] = "Others";
s_a[176] = "Others";
s_a[177] = "Others";
s_a[178] = "Others";
s_a[179] = "Others";
s_a[180] = "Others";
s_a[181] = "Others";
s_a[182] = "Others";
s_a[183] = "Others";
s_a[184] = "Others";
s_a[185] = "Others";
s_a[186] = "Others";
s_a[187] = "Others";
s_a[188] = "Others";
s_a[189] = "Others";
s_a[190] = "Others";
s_a[191] = "Others";
s_a[192] = "Others";
s_a[193] = "Others";
s_a[194] = "Others";
s_a[195] = "Others";
s_a[196] = "Others";
s_a[197] = "Others";
s_a[198] = "Others";
s_a[199] = "Others";
s_a[200] = "Others";
s_a[201] = "Others";
s_a[202] = "Others";
s_a[203] = "Others";
s_a[204] = "Others";
s_a[205] = "Others";
s_a[206] = "Others";
s_a[207] = "Others";
s_a[208] = "Others";
s_a[209] = "Others";
s_a[210] = "Others";
s_a[211] = "Others";
s_a[212] = "Others";
s_a[213] = "Others";
s_a[214] = "Others";
s_a[215] = "Others";
s_a[216] = "Others";
s_a[217] = "Others";
s_a[218] = "Others";
s_a[219] = "Others";
s_a[220] = "Others";
s_a[221] = "Others";
s_a[222] = "Others";
s_a[223] = "Others";
s_a[224] = "Others";
s_a[225] = "Others";
s_a[226] = "Others";
s_a[227] = "Others";
s_a[228] = "Others";
s_a[229] = "Others";
s_a[230] = "Others";
s_a[231] = "Others";
s_a[232] = "Others";
s_a[233] = "Others";
s_a[234] = "Others";
s_a[235] = "Others";
s_a[236] = "Others";
s_a[237] = "Others";
s_a[238] = "Others";
s_a[239] = "Others";
s_a[240] = "Others";
s_a[241] = "Others";
s_a[242] = "Others";
s_a[243] = "Others";
s_a[244] = "Others";
s_a[245] = "Others";
s_a[246] = "Others";
s_a[247] = "Others";
s_a[248] = "Others";
s_a[249] = "Others";
s_a[250] = "Others";
s_a[251] = "Others";
s_a[252] = "Others";


s_a_val[2] = "N/A";
s_a_val[3] = "N/A";
s_a_val[4] = "N/A";
s_a_val[5] = "N/A";
s_a_val[6] = "N/A";
s_a_val[7] = "N/A";
s_a_val[8] = "N/A";
s_a_val[9] = "N/A";
s_a_val[10] = "N/A";
s_a_val[11] = "N/A";
s_a_val[12] = "N/A";
s_a_val[13] = "N/A";
s_a_val[14] = "N/A";
s_a_val[15] = "N/A";
s_a_val[16] = "N/A";
s_a_val[17] = "N/A";
s_a_val[18] = "N/A";
s_a_val[19] = "N/A";
s_a_val[20] = "N/A";
s_a_val[21] = "N/A";
s_a_val[22] = "N/A";
s_a_val[23] = "N/A";
s_a_val[24] = "N/A";
s_a_val[25] = "N/A";
s_a_val[26] = "N/A";
s_a_val[27] = "N/A";
s_a_val[28] = "N/A";
s_a_val[29] = "N/A";
s_a_val[30] = "N/A";
s_a_val[31] = "N/A";
s_a_val[32] = "N/A";
s_a_val[33] = "N/A";
s_a_val[34] = "N/A";
s_a_val[35] = "N/A";
s_a_val[36] = "N/A";
s_a_val[37] = "N/A";
s_a_val[38] = "N/A";
s_a_val[39] = "N/A";
s_a_val[40] = "N/A";
s_a_val[41] = "N/A";
s_a_val[42] = "N/A";
s_a_val[43] = "N/A";
s_a_val[44] = "N/A";
s_a_val[45] = "N/A";
s_a_val[46] = "N/A";
s_a_val[47] = "N/A";
s_a_val[48] = "N/A";
// <!-- -->
s_a_val[49] = "N/A";
s_a_val[50] = "N/A";
s_a_val[51] = "N/A";
s_a_val[52] = "N/A";
s_a_val[53] = "N/A";
s_a_val[54] = "N/A";
s_a_val[55] = "N/A";
s_a_val[56] = "N/A";
s_a_val[57] = "N/A";
s_a_val[58] = "N/A";
s_a_val[59] = "N/A";
s_a_val[60] = "N/A";
s_a_val[61] = "N/A";
s_a_val[62] = "N/A";
// <!-- -->
s_a_val[63] = "N/A";
s_a_val[64] = "N/A";
s_a_val[65] = "N/A";
s_a_val[66] = "N/A";
s_a_val[67] = "N/A";
s_a_val[68] = "N/A";
s_a_val[69] = "N/A";
s_a_val[70] = "N/A";
s_a_val[71] = "N/A";
s_a_val[72] = "N/A";
s_a_val[73] = "N/A";
s_a_val[74] = "N/A";
s_a_val[75] = "N/A";
s_a_val[76] = "N/A";
s_a_val[77] = "N/A";
s_a_val[78] = "N/A";
s_a_val[79] = "N/A";
s_a_val[80] = "N/A";
s_a_val[81] = "N/A";
s_a_val[82] = "N/A";
s_a_val[83] = "N/A";
s_a_val[84] = "N/A";
s_a_val[85] = "N/A";
s_a_val[86] = "N/A";
s_a_val[87] = "N/A";
s_a_val[88] = "N/A";
s_a_val[89] = "N/A";
s_a_val[90] = "N/A";
s_a_val[91] = "N/A";
s_a_val[92] = "N/A";
s_a_val[93] = "N/A";
s_a_val[94] = "N/A";
s_a_val[95] = "N/A";
s_a_val[96] = "N/A";
s_a_val[97] = "N/A";
s_a_val[98] = "N/A";
s_a_val[99] = "N/A";
s_a_val[100] = "N/A";
s_a_val[101] = "N/A";
s_a_val[102] = "N/A";
s_a_val[103] = "N/A";
s_a_val[104] = "N/A";
s_a_val[105] = "N/A";
s_a_val[106] = "N/A";
s_a_val[107] = "N/A";
s_a_val[108] = "N/A";
s_a_val[109] = "N/A";
s_a_val[110] = "N/A";
s_a_val[111] = "N/A";
s_a_val[112] = "N/A";
s_a_val[113] = "N/A";
s_a_val[114] = "N/A";
s_a_val[115] = "N/A";
s_a_val[116] = "N/A";
s_a_val[117] = "N/A";
s_a_val[118] = "N/A";
s_a_val[119] = "N/A";
s_a_val[120] = "N/A";
s_a_val[121] = "N/A";
s_a_val[122] = "N/A";
s_a_val[123] = "N/A";
s_a_val[124] = "N/A";
s_a_val[125] = "N/A";
s_a_val[126] = "N/A";
s_a_val[127] = "N/A";
s_a_val[128] = "N/A";
s_a_val[129] = "N/A";
s_a_val[130] = "N/A";
s_a_val[131] = "N/A";
s_a_val[132] = "N/A";
s_a_val[133] = "N/A";
s_a_val[134] = "N/A";
s_a_val[135] = "N/A";
s_a_val[136] = "N/A";
s_a_val[137] = "N/A";
s_a_val[138] = "N/A";
s_a_val[139] = "N/A";
s_a_val[140] = "N/A";
s_a_val[141] = "N/A";
s_a_val[142] = "N/A";
s_a_val[143] = "N/A";
s_a_val[144] = "N/A";
s_a_val[145] = "N/A";
s_a_val[146] = "N/A";
s_a_val[147] = "N/A";
s_a_val[148] = "N/A";
s_a_val[149] = "N/A";
s_a_val[150] = "N/A";
s_a_val[151] = "N/A";
s_a_val[152] = "N/A";
s_a_val[153] = "N/A";
s_a_val[154] = "N/A";
s_a_val[155] = "N/A";
s_a_val[156] = "N/A";
s_a_val[157] = "N/A";
s_a_val[158] = "N/A";
s_a_val[159] = "N/A";
s_a_val[160] = "N/A";
s_a_val[161] = "N/A";
s_a_val[162] = "N/A";
s_a_val[163] = "N/A";
s_a_val[164] = "N/A";
s_a_val[165] = "N/A";
s_a_val[166] = "N/A";
s_a_val[167] = "N/A";
s_a_val[168] = "N/A";
s_a_val[169] = "N/A";
s_a_val[170] = "N/A";
s_a_val[171] = "N/A";
s_a_val[172] = "N/A";
s_a_val[173] = "N/A";
s_a_val[174] = "N/A";
s_a_val[175] = "N/A";
s_a_val[176] = "N/A";
s_a_val[177] = "N/A";
s_a_val[178] = "N/A";
s_a_val[179] = "N/A";
s_a_val[180] = "N/A";
s_a_val[181] = "N/A";
s_a_val[182] = "N/A";
s_a_val[183] = "N/A";
s_a_val[184] = "N/A";
s_a_val[185] = "N/A";
s_a_val[186] = "N/A";
s_a_val[187] = "N/A";
s_a_val[188] = "N/A";
s_a_val[189] = "N/A";
s_a_val[190] = "N/A";
s_a_val[191] = "N/A";
s_a_val[192] = "N/A";
s_a_val[193] = "N/A";
s_a_val[194] = "N/A";
s_a_val[195] = "N/A";
s_a_val[196] = "N/A";
s_a_val[197] = "N/A";
s_a_val[198] = "N/A";
s_a_val[199] = "N/A";
s_a_val[200] = "N/A";
s_a_val[201] = "N/A";
s_a_val[202] = "N/A";
s_a_val[203] = "N/A";
s_a_val[204] = "N/A";
s_a_val[205] = "N/A";
s_a_val[206] = "N/A";
s_a_val[207] = "N/A";
s_a_val[208] = "N/A";
s_a_val[209] = "N/A";
s_a_val[210] = "N/A";
s_a_val[211] = "N/A";
s_a_val[212] = "N/A";
s_a_val[213] = "N/A";
s_a_val[214] = "N/A";
s_a_val[215] = "N/A";
s_a_val[216] = "N/A";
s_a_val[217] = "N/A";
s_a_val[218] = "N/A";
s_a_val[219] = "N/A";
s_a_val[220] = "N/A";
s_a_val[221] = "N/A";
s_a_val[222] = "N/A";
s_a_val[223] = "N/A";
s_a_val[224] = "N/A";
s_a_val[225] = "N/A";
s_a_val[226] = "N/A";
s_a_val[227] = "N/A";
s_a_val[228] = "N/A";
s_a_val[229] = "N/A";
s_a_val[230] = "N/A";
s_a_val[231] = "N/A";
s_a_val[232] = "N/A";
s_a_val[233] = "N/A";
s_a_val[234] = "N/A";
s_a_val[235] = "N/A";
s_a_val[236] = "N/A";
s_a_val[237] = "N/A";
s_a_val[238] = "N/A";
s_a_val[239] = "N/A";
s_a_val[240] = "N/A";
s_a_val[241] = "N/A";
s_a_val[242] = "N/A";
s_a_val[243] = "N/A";
s_a_val[244] = "N/A";
s_a_val[245] = "N/A";
s_a_val[246] = "N/A";
s_a_val[247] = "N/A";
s_a_val[248] = "N/A";
s_a_val[249] = "N/A";
s_a_val[250] = "N/A";
s_a_val[251] = "N/A";
s_a_val[252] = "N/A";

function populateStates(countryElementId, stateElementId) {

var selectedCountryIndex = document.getElementById(countryElementId).selectedIndex;


var stateElement = document.getElementById(stateElementId);

stateElement.length = 0; // Fixed by Julian Woods
stateElement.options[0] = new Option('Select State', '');
stateElement.selectedIndex = 0;

var state_arr = s_a[selectedCountryIndex].split("|");
var state_arr_val = s_a_val[selectedCountryIndex].split("|");

if(selectedCountryIndex != 0){
for (var i = 0; i < state_arr.length; i++) {
stateElement.options[stateElement.length] = new Option(state_arr[i], state_arr_val[i]);
}
}

}

function populateCountries(countryElementId, stateElementId) {

var countryElement = document.getElementById(countryElementId);

if (stateElementId) {
countryElement.onchange = function () {
populateStates(countryElementId, stateElementId);
};
}
}

</script>

<script language="javascript">
populateCountries("country", "state");
// populateCountries("country");
</script>

								<div class="control-group">
														<label class="control-label" for="radiobtns">State/Province</label>

														<div class="controls form-group">
															

																<!-- <input class="span4 form-control" id="state" placeholder="e.g. MA" name="state" type="text" maxlength="64" style="width:100%;"   value="<?php echo $mg_state; ?>" > -->
																<select class="span4 form-control" id="state" name="state" autocomplete="false">
																<option value="">Select State</option>
																<option selected value="<?php echo $mg_state; ?>"><?php echo $mg_state; ?></option>
                                </select>
															
														</div>
														<!-- /controls -->
													</div>					

                                                
                                                <div class="control-group">
														<label class="control-label" for="radiobtns">City</label>

														<div class="controls form-group">
															

																<input class="span4 form-control" id="city" placeholder="" name="city" type="text" maxlength="64" style="width:100%;"   value="<?php echo $mg_city; ?>" >
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->	    
                                                    		<script type="text/javascript">
																	//$("#city").keypress(function(event){
//																		var ew = event.which;
//																		if(ew == 8||ew == 0)
//																			return true;
//																		//if(48 <= ew && ew <= 57)
////																			return true;
//																		if(65 <= ew && ew <= 90)
//																			return true;
//																		if(97 <= ew && ew <= 122)
//																			return true;
//																		return false;
//																	});
$('#city').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });
																</script>										
												
                                                
													<!-- /control-group -->		
												
                                                <div class="control-group">
														<label class="control-label" for="radiobtns">Postal Code</label>

														<div class="controls form-group">
															

																<input class="span4 form-control" id="postal_code" placeholder="xxxxx" name="postal_code" type="text" style="width:100%;"  value="<?php echo $mg_postal_code; ?>" maxlength="5" oninvalid="setCustomValidity('Invalid Postal Code')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"  >
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->	
													<script language="javascript">
            populateCountries("country", "state");
           // populateCountries("country");
        </script>
													<script language="javascript">
                            $( document ).ready(function() {

setTimeout(function(){ document.getElementById('country').value = '<?php echo $mg_country; ?>'; }, 1000);
setTimeout(function(){ populateStates("country", "state"); }, 1000);
setTimeout(function(){ document.getElementById('state').value = '<?php echo $mg_state; ?>'; }, 1000);



});
                        </script>
													<script>
    $('#postal_code').on('keydown', function(e){
        if(e.keyCode < 48 && e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 39){
            e.preventDefault();
        }else {
            if(e.keyCode > 105){
                e.preventDefault();
            }else{
                if(e.keyCode < 96 && e.keyCode > 57){
                    e.preventDefault();
                }else{

                }
            }
        }
    });
	
	$('#postal_code').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });
</script>
                                               
                                        		  
                                                	
                                               													
													
													
																		  <script type="text/javascript">

                                        $(document).ready(function() {

                                         	$('#phone').focus(function(){
                                        	    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                        	});
                                        	

                                        	$('#phone').keyup(function(){
                                        	    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                        	});

                                            
                                            $("#phone").keydown(function (e) {


                                                var mac = $('#phone').val();
                                                var len = mac.length + 1;
                                                //console.log(e.keyCode);
                                                //console.log('len '+ len);

                                                if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                    mac1 = mac.replace(/[^0-9]/g, '');


                                                    //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                    //console.log(valu);
                                                    //$('#phone_num_val').val(valu);

                                                }
                                                else{
													return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);
                                     
                                                   /*  if(len == 4){
                                                        $('#phone').val(function() {
                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                          

                                                        });
                                                    }
                                                    else if(len == 8 ){
                                                        $('#phone').val(function() {
                                                            return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                          

                                                        });
                                                    } */
                                                }


                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
                                                            // Allow: Ctrl+A, Command+A
                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+C, Command+C
                                                        (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+x, Command+x
                                                        (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+V, Command+V
                                                        (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: home, end, left, right, down, up
                                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    // let it happen, don't do anything
                                                    return;
                                                }
                                                // Ensure that it is a number and stop the keypress
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                    e.preventDefault();

                                                }
                                            });


                                        });

                                        </script>
							
												
												
													
											<div class="control-group form-di">
														<label class="control-label" for="radiobtns">Secret Question :</label>

														<div class="controls form-group">
															
																<select class="span4 form-control" name="question" id="question" style="width:100%;" >
                                          
																<?php 
																echo $key_query = "SELECT `question_id` AS a, `secret_question` AS b FROM `mdu_secret_questions` WHERE is_enable=1 AND  `secret_question`='".$mg_question_id."'";
								
																$query_results=mysql_query($key_query);
																while($row=mysql_fetch_array($query_results)){
																	$a = $row['a'];
																	$b = $row['b'];
																	
																	echo '<option value="'.$b.'">'.$b.'</option>';
																}
																
																
																echo $key_query = "SELECT `question_id` AS a, `secret_question` AS b FROM `mdu_secret_questions` WHERE is_enable=1  ORDER BY `question_id` ASC";
																
																$query_results=mysql_query($key_query);
																while($row=mysql_fetch_array($query_results)){
																	$a = $row['a'];
																	$b = $row['b'];
																		
																	echo '<option value="'.$b.'">'.$b.'</option>';
																}
																?>
																</select>																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->													
													
													
													
										
											<div class="control-group form-di">
														<label class="control-label" for="radiobtns">Answer :</label>

														<div class="controls form-group">
															

																<input class="span4 form-control" id="answer" placeholder="Answer" name="answer" type="text" style="width:100%;" value="<?php echo $mg_answer; ?>" >
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->


													

		
													<div class="form-actions" style="background-color: #fff;    border-top: 1.3px dotted #9c9b9b;padding-left: 0px; ">
														<button  type="submit" name="customer_submit" id="customer_submit" style="display: inline-block;padding-bottom: 5px; padding-top: 5px; float: right; " class="btn btn-primary">Update</button>&nbsp; <!--<strong><font color="#FF0000">*</font><font size="-2"> Required Field</font></strong>-->
															
													
                                                      </div>
													<!-- /form-actions -->
                                                
                                                    
                                                    
                                                    <!-- <div class="control-group">
														<label class="control-label" for="radiobtns" >Account Start Date :</label>

														<div class="controls form-group">
															

                                                                <p style="margin-top:3px; "><?php// echo $mg_start_time; ?></p>
																
															
														</div>
														
													</div>
                                                    
                                                    <div class="control-group">
														<label class="control-label" for="radiobtns" >Account Expiry Date:</label>

														<div class="controls form-group">
															

                                                                <p style="margin-top:3px;"><?php// echo $mg_end_time; ?></p>
																
															
														</div>
														
													</div> -->
                                                    
                                                    
                                                   
                                                  
                                                    
												</fieldset>
											</form>
                                            
                                            
                                            
                                             <script>

$(document).ready(function(){
   document.getElementById("customer_submit").disabled = true;
});

function customer_submitenable(){
	document.getElementById("customer_submit").disabled = false;
	}

</script>



			</div>
			

            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
        </div>
        <!-- /span6 -->

        <?php } ?>

        <?php if($violation_count != '3'){ ?> 

        <div class="span11a" >
          <div class="widget panel panel-default widget-content">
            <div class=" panel-heading">
			  <h3 class="panel-title"> MY DEVICES</h3>
			  
			  <?php if($violation_count != '3'){ ?>

              <a class="accord_icon_a" data-toggle="collapse" data-target="#collapse2" href="JavaScript:Void(0);"><i  class="accord_icon"></i>
			  </a>
			  
			  <?php } ?>
            </div>
			<!-- /widget-header -->
			
		   
            <div id="collapse2" class=" panel-collapse collapse in">
             
             
             <div class="col_pad table_response_half">
                 <?php


                 $key_query = "SELECT  id,`nick_name`,`email_address`,`description`,`mac_address` 
									FROM `mdu_customer_devices` WHERE `user_name`='$user_name'";



                 $query_results=mysql_query($key_query);
                 $number_of_results = mysql_num_rows($query_results);


                 
              //   if(isset($_GET['regNewSubAcc'])){
				 // echo "SELECT mac AS f FROM mdu_security_tokens WHERE token_id='$_SESSION[redirect_token]'";
                    if(strlen($_SESSION['redirect_token'])>0 && $number_of_results<$max_allowed_devices){
						 $new_add_mac=$db->getValueAsf("SELECT mac AS f FROM mdu_security_tokens WHERE token_id='$_SESSION[redirect_token]'");
						 
						 if($total_warnings_live > '0'){ 
						 }
						 else{
                         ?>
                         
                          <?php
if($preview_theme_code==""){
?>
                           <form method="post" id="auto_mac_creat" class="zero-padding" action="?auto_mac_add=true&form_secret=<?php echo $_SESSION['FORM_SECRET'] ?> " autocomplete="off">
                           
                           <?php }else{?>
                          <form method="post" id="auto_mac_creat" class="zero-padding" action="?auto_mac_add=true&form_secret=<?php echo $_SESSION['FORM_SECRET'] ?>&th=<?php echo $preview_theme_code; ?> " autocomplete="off">
                          
                           
						   <?php } ?>
                       
                             <h5 style="margin-left: 14px;">Add the device I am using</h5>
                             
                             <div style="">
                             <table class="res table table-striped table-bordered ">

														<thead>
															<tr>
																<th>NICKNAME</th>

																<th>MAC ID</th>
																<th>ADD</th>
															</tr>
														</thead>
														<tbody>




					<tr>
									<td><div class="form-group"> <input class="span4 form-controls" type='text' id="auto_nick_name" name='auto_nick_name'  placeholder="Nickname" > </div></td>


<script type="text/javascript">


																	$("#auto_nick_name").keypress(function(event){
																		var ew = event.which;
																		if(ew == 32||ew == 8||ew == 0)
																			return true;
																		if(48 <= ew && ew <= 57)
																			return true;
																		if(65 <= ew && ew <= 90)
																			return true;
																		if(97 <= ew && ew <= 122)
																			return true;
																		return false;
																	});
																</script>



									<td> <?php echo macDisplay($new_add_mac) ?> </td>
                        <td> 
						
						<button type="submit" style="border-radius: 0px;" href="javascript:void();" id="auto_mac_add_btn" class="btn btn-primary">
																Add the Device I am using</button></td>
                        <script type="text/javascript">
                        $(document).ready(function() {
                        $('#auto_mac_add_btn').easyconfirm({locale: {
                                title: 'Add Device ',
                                text: 'Are you sure you want to add this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                button: ['Cancel',' Confirm'],
                                closeText: 'close'
                                 }});
                            $('#auto_mac_add_btn').click(function() {

                            });
                            });
						</script>
						
						





								</tr></tbody>
        </table></div></form>

         <?php
                 //    }
				 }
				 
				}


                 ?>
                 
                 <div style="overflow-x:auto">
             <table class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>NICKNAME</th>

																<th>MAC ID</th>
																<th>REMOVE</th>
															</tr>
														</thead>
														<tbody>




					<?php

								while($row=mysql_fetch_array($query_results)){
									$id = $row['id'];
									$nick_name = $row['nick_name'];
									//$email_address = $row['email_address'];
									$description = $row['description'];
									 $mac_id = $row['mac_address'];

									$mac_relm = explode('@', $mac_id);




									echo '<tr>
									<td> '.$nick_name.' </td>
								
									<td> '.macDisplay($mac_relm[0]).' </td>';

echo '<td>';



if($preview_theme_code==""){
			
           echo ' <a  style="border-radius: 0px;" href="javascript:void();"  id="DR_'.$id.'"  class="btn btn-small">
																<i class="btn-icon-only icon-remove"></i></a></td><script type="text/javascript">
$(document).ready(function() {
$(\'#DR_'.$id.'\').easyconfirm({locale: {
		title: \'Remove Connected Device \',
		text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
		button: [\'Cancel\',\' Confirm\'],
		closeText: \'close\'
	     }});
	$(\'#DR_'.$id.'\').click(function() {
		window.location = "?s_token='.$secret.'&customer_id='.$mg_customer_id.'&search_id='.$search_id.'&rm_device_id='.$id.'"
	});
	});
</script>';

			}else{
				
				echo ' <a  style="border-radius: 0px;" href="javascript:void();"  id="DR_'.$id.'"  class="btn btn-small">
																<i class="btn-icon-only icon-remove"></i></a></td><script type="text/javascript">
$(document).ready(function() {
$(\'#DR_'.$id.'\').easyconfirm({locale: {
		title: \'Remove Connected Device \',
		text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
		button: [\'Cancel\',\' Confirm\'],
		closeText: \'close\'
	     }});
	$(\'#DR_'.$id.'\').click(function() {
		window.location = "?s_token='.$secret.'&customer_id='.$mg_customer_id.'&search_id='.$search_id.'&rm_device_id='.$id.'&th='.$preview_theme_code.'"
	});
	});
</script>';
				
				}

								}

					?>





								</tbody>
						</table>

						</div>
						
                        
                        
        <?php if($total_warnings_live > '0'){ ?>        

				<!-- <button type="submit" id="vio_submit1" class="btn btn-primary" style="margin-bottom: 20px;">Acknowledge Violation and Continue?</button> -->
                        
<?php

$secret2=md5(uniqid(rand(), true));
$_SESSION['FORM_SECRET'] = $secret2;

echo '<script>
$(document).ready(function() {
								$(\'#vio_submit\').easyconfirm({locale: {
										title: \'Re Enable Account\',
										text: \'Are you sure you want to Re Enable account &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
										button: [\'Cancel\',\' Confirm\'],
										closeText: \'close\'
									     }});
									$(\'#vio_submit\').click(function() {
										window.location = "?action=react&token_acknow='.$secret2.'&re_customer_id='.$user_name.'"
									});

								$(\'#vio_submit1\').easyconfirm({locale: {
										title: \'Re Enable Account\',
										text: \'Are you sure you want to Re Enable account &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
										button: [\'Cancel\',\' Confirm\'],
										closeText: \'close\'
									     }});
									$(\'#vio_submit1\').click(function() {
										window.location = "?action=react&token_acknow='.$secret2.'&re_customer_id='.$user_name.'"
									});
									});
									</script>';

									echo '</div>';

?>
		<?php } else { ?> 
		</div>  
          <div class="col_pad">
        <div class="span6a">
		<div class="line_dot"></div>
          <!-- /widget -->
          
          <!-- /widget -->
          <div class="widget">

            <div class="widget-content">
			
            <h3 style="margin-left: 14px;">Add the device manually</h3>
                <?php
if($preview_theme_code==""){
?>
                         <form id="device_form" name="device_form" action="tenant_account.php" method="post"  class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                           
                           <?php }else{?>
                        
                           <form id="device_form" name="device_form" action="tenant_account.php?th=<?php echo $preview_theme_code; ?>" method="post"  class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                           
						   <?php } ?>
            
            
								
									<?php
								echo '<input type="hidden" name="form_secret" id="form_secret1" value="'.$_SESSION['FORM_SECRET'].'" /><input type="hidden" name="search_id" id="search_id1" value="'.$search_id.'" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="'.$mg_customer_id.'" />';
												
								?>
								
									<fieldset>

									
										<div id="response_d2"></div>
									
													
													
													

													<?php 
													/*
													$key_query = "SELECT device_limit AS f FROM `system_organizations` WHERE `property_number`='$mg_property_id'";
													
													$query_results=mysql_query($key_query);
													while($row=mysql_fetch_array($query_results)){
														$settings_value = $row[f];	
														$max_allowed_devices_count = trim($settings_value);
														
													}   */
													
													//$max_allowed_devices_count = 10;
														//$max_allowed_devices = $max_allowed_devices_count-1;
													
														if($number_of_results>=$max_allowed_devices){
															echo '<font color="red">Max allowed device limit is reached and new devices can not be registered. </font><br>';
														}
													?>
													
													

													<div class="control-group">
														<label class="control-label" for="radiobtns">MAC Address <i data-toggle="tooltip" title='Example: 58:19:F8:B7:06:3F or 5819f8b7063f.  If you cannot find your MAC address then search the Internet for “How can I find the MAC address on my [product name]?”.' class="icon icon-question-sign " style="color : #078cc5;margin-top: 3px;"></i></label>

														<div class="controls form-group">
															

																<!-- <input class="span4 form-control"  id="mac_address" name="mac_address" maxlength="17" type="text" style="width:100%;"  oninvalid="setCustomValidity('Invalid MAC format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"   title="Format - xx:xx:xx:xx:xx:xx"  >
                                                                --> 
																<input class="span4 form-control"  id="mac_address" name="mac_address" maxlength="17" type="text" style="width:100%;"    title="Format - xx:xx:xx:xx:xx:xx"  >
                                                                
																
															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->
<!-- <script type="text/javascript">




function mac_val(element) {

	

	    setTimeout(function () { 
    	    var mac = $('#mac_address').val();

    	    var pattern = new RegExp( "[/-]", "g" );
    		var mac = mac.replace(pattern,"");

    	   // alert(mac);
    	    var result ='';
    	    var len = mac.length;

    	   // alert(len);
    	   
    	   var regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;

    	   

    	    if(regex.test(mac)==true){

    	 //  if( (len<5 && mac.charAt(3)==':') || (len<8 && mac.charAt(3)==':' && mac.charAt(6)==':') || (len<11 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':') || (len<14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':') || (len>14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':' && && mac.charAt(15)==':') ){

        	   }else{

    	    /*for (i = 0; i < len; i+=2) {
    	    	

    	    	
    	    	
    	    	if(i==10){

    	    		result+=mac.charAt(i)+mac.charAt(i+1);
        	    	
        	    	}else{   
	
    	    	result+=mac.charAt(i)+mac.charAt(i+1)+':';

        	    	}
    			
    	    	
    	    	 
    	    }*/

    	    var pattern = new RegExp( "[/-]", "g" );
    		var mac = mac.replace(pattern,"");
            var pattern1 = new RegExp( "[/:]", "g" );
    		mac = mac.replace(pattern1,"");
            
            var mac1 = mac.match(/.{1,2}/g).toString();
             
            var pattern = new RegExp( "[/,]", "g" );
            
    		var mac2 = mac1.replace(pattern,":");

    	    
    	    document.getElementById('mac_address').value = mac2;

    	    $('#device_form').formValidation('revalidateField', 'mac_address');


        	   }
    	    

	    }, 100);


}

$("#mac_address").on('paste',function(){

	 mac_val(this.value);
	
});


</script>
													
													
													

						  <script type="text/javascript">

                                        $(document).ready(function() {

                                         	$('#mac_address').change(function(){

												
                                        	    $(this).val($(this).val().replace(/(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})/,'$1:$2:$3:$4:$5:$6'))
                                                	
 
   											});

                                        	

                                        	$('#mac_address').keyup(function(e){
                                        	    var mac = $('#mac_address').val();
                                        	    var len = mac.length + 1;


                                        	    if(e.keyCode != 8){
                                               
	                                        	    if(len%3 == 0 && len != 0 && len < 18){
	                                        	        $('#mac_address').val(function() {
	                                        	            return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
	                                        	            //i++;
	                                        	        });
	                                        	    }
                                        	    }
   											});
   											

                                        	$('#mac_address').keydown(function(e){
                                        	    var mac = $('#mac_address').val();
                                        	    var len = mac.length + 1;


                                        	    if(e.keyCode != 8){

	                                        	    if(len%3 == 0 && len != 0 && len < 18){
	                                        	        $('#mac_address').val(function() {
	                                        	            return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
	                                        	            //i++;
	                                        	        });
	                                        	    }
                                        	    }



                                                                         	

                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
                                                            // Allow: Ctrl+A, Command+A
                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+C, Command+C
                                                        (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+x, Command+x
                                                        (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+V, Command+V
                                                        (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: home, end, left, right, down, up
                                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    // let it happen, don't do anything
                                                    return;
                                                }	
                                                // Ensure that it is a number and stop the keypress
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 65 || e.keyCode > 70)) {
                                                    e.preventDefault();

                                                }
                                            });


                                        });

                                        </script> -->
																				
													

<script>
/* $('#mac_address').on('keydown', function(){
    var mac = $('#mac_address').val();
    var len = mac.length + 1;

    if(len%3 == 0 && len != 0 && len < 18){
        $('#mac_address').val(function() {
            return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
            //i++;
        });
    }
}); */
</script>
													
													
													
													<div class="control-group">
														<label class="control-label" for="radiobtns">Nickname</label>

														<div class="controls form-group">
															

																<input class="span4 form-control allow_char" id="nick_name"  name="nick_name" type="text" style="width:100%;" >
																
															<script type="text/javascript">
																	$("#nick_name").keypress(function(event){
																		var ew = event.which;
																		if(ew == 32||ew == 8||ew == 0)
																			return true;
																		if(48 <= ew && ew <= 57)
																			return true;
																		if(65 <= ew && ew <= 90)
																			return true;
																		if(97 <= ew && ew <= 122)
																			return true;
																		return false;
																	});
																</script>

														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->
													
													
													
													
																										
													

														
													
													
<!-- 
													<div class="control-group">
														<label class="control-label" for="radiobtns">Email(Optional)</label>

														<div class="controls">
															<div class="input-prepend input-append">

																<input class="span4" id="email" placeholder="user@tg.com" name="email" type="email" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}$"  style="width:150px;" >
																
															</div>
														</div>
														
													</div>
													
													 -->
													<!-- /control-group -->													
													
									
		
		
													<div class="form-actions" class="form-actions" style="background-color: #fff;    border-top: 1.3px dotted #9c9b9b;padding-left: 0px">
													
														<?php 
														if($number_of_results>=$max_allowed_devices){?>
														<button type="button" class="btn btn-primary" disabled="disabled">Register</button>&nbsp; 
														<?php }													
														else{ ?>
														<button type="submit" name="device_submit" id="device_submit" style="display: inline-block;" class="btn btn-primary">Add a New Device Manually </button>&nbsp;<!-- <strong><font color="#FF0000">*</font><font size="-2"> Required</font></strong>-->
														<?php } ?>
													
                                                      </div>
													<!-- /form-actions -->
												</fieldset>
											</form>

              
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
        </div>
        <!-- /span3 -->
        
        
        <div class="span4a dis_content">
		<div class="line_dot"></div>
          <div class="widget">
            
            <div class="widget-content">
			<div class="dis_content_sub">
            <h3>Add or Remove a Device</h3>
			<p>Your registered devices are listed in the table above. <br/>
			<p>You can register up to <?php echo $max_allowed_devices; ?> devices. <br/>
			<p>To manually register a device fill in the MAC address and click “Add a New Device Manually".<br/>
			<p>The MAC address can usually be found on the back or bottom of the device and looks similar to 58:19:F8:B7:06:3F or 5819f8b7063f.<br/>
			<p>If you do not know how to find your MAC address, then search “How can I find the MAC address on my [product name]?".<br/>
          
		  </div>
			</div>
			
														<?php } ?>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          
          
          <!-- /widget --> 
          
          <!-- /widget -->
        </div>
        <!-- /span6 --> 


        <div class="span4a qos-content">
        	<div class="line_dot"></div>
        	<div class="widget">          
            	<div class="widget-content">
        			

        			<?php 
        				
        				$qos1 = mysql_query("SELECT v.`service_profile`,v.`qos_override`,q.`qos_code`,q.`network_type` FROM mdu_vetenant v LEFT JOIN exp_qos q ON v.`qos_override`=q.`qos_id` WHERE `username`= '$user_name'");

						$row_qos1=mysql_fetch_array($qos1);

						$service_profile =$row_qos1['service_profile'];
						$profile_type =$row_qos1['network_type'];
						$qos_override =$row_qos1['qos_override'];
						$qos_code =$row_qos1['qos_code'];

						$query_service_profilen1 = mysql_query("SELECT `product_code` as f FROM `exp_products_distributor` WHERE distributor_code='$user_distributor' AND `network_type` = 'VT-DEFAULT'");
							
						$prod=mysql_fetch_array($query_service_profilen1);

						$txt1 = 'Active Product:';
						$txt2 = $prod['f'];
						$txt3 = 'Active Profile:';
						$txt4 = '';
						$txt5 = '';

						if(empty($qos_override)){

							$get_qos = mysql_query("SELECT p.`QOS` as qos FROM exp_products p LEFT JOIN exp_mno_distributor m ON p.`mno_id` = m.`mno_id` WHERE m.`distributor_code`= '$user_distributor'");
							$qos_code_def = mysql_fetch_array($get_qos);
							$txt4 = $qos_code_def['qos'];
							$txt_def = 'Default';
						}else{

							$txt4 = $qos_code;
							$txt_def = 'Non-Default';
							
							if($profile_type == 'VT-Probation'){
								
								$txt5 = 'Your default product QOS has been temporarily downgraded.<br>Please contact your admin for further information.';
							}
						}
        			?>

        			<span class="qos-content-header2"><?php echo $txt1; ?><span class="qos-content-pro"><?php echo $txt2; ?></span></span>
        			<span class="qos-content-header">My Bandwidth Profile <span style="text-transform:none;display: inline-block;font-size: 18px !important;">(<?php echo $txt_def; ?>)</span></span>
        			<span class="qos-content-header2"><?php echo $txt3; ?><span class="qos-content-pro"><?php echo $txt4; ?></span></span>
        			<p class="qos-content-txt"><?php echo $txt5; ?></p>

        		</div>
        	</div>
        </div>


      </div>

        <style type="text/css">

        .qos-content-header{
        	font-size: 18px !important;
        	text-transform: uppercase;
        	margin-left: 10px;
        	padding-top: 30px !important;
        }

        .qos-content-pro{
        	color: #218fdd;
        	margin-left: 10px;
        	display: inline-block !important;
        }

        .qos-content-header2{
        	margin-left: 10px;
        	padding-top: 0px !important;
        }

        .qos-content-txt{
        	padding-top: 10px;
        	margin-left: 10px;
        }

        .dropdown-menu .active>a:hover, .dropdown-menu li>a:hover{
        	background: #ffffff !important;
        } 

        .accord_icon_a{
        	   float: left;
    left: 4%;
    position: absolute;
    top: 5%;
    text-align: center;
    width: 20px;
    border-radius: 50px;
    border: 1px solid #4473d8;
    height: 20px;
        }

        .accord_icon{
        	        height: 20px;
    text-align: center;
    width: 19px;
    line-height: 22px;
        }

        @media (max-width:979px) {

        	.accord_icon{
        		width: 21px;
        	}

        	.h3-mobile{
        		font-size: 26px !important;
        		padding-left: 15px;
        		padding-right: 15px;
        	}

        	.panel-title {
        		margin-bottom: 20px !important; 
        	}

        	.btn-navbar{
        		float: left;
        	}

        	.panel-collapse form{
        		    padding: 20px 15px 15px 15px;
        	}
 
        	.widget-content{
        	    padding: 20px 0px 0px !important; 
        	    border: none !important;
        	}
        	.widget-content.panel-default{
        		border: 1px solid #D5D5D5 !important;
        	}
        	.tab-content{
        	    width: 100%;
                margin: auto;
            }
            .panel-default{
            	
    background: #efeded;
    height: 100%;
            }
            .panel-heading{
            	position: relative;
            }
            .panel-collapse{
            	background: white;
            }
            .panel-default .widget-content{
            	    padding: 0px 0px 0px !important;
            }
            .widget{
      		margin-bottom: 0px !important;
      	}
      	.widget-content{
      		border-radius: 0px !important;
      	}
        }

      button.btn{
      	padding-bottom: 9px !important; 
      	padding-top: 9px !important; 
      	min-width: 200px;
      }

      .button-div{
      	margin-top: 30px;
      }

      body button.btn[disabled]{
      	    background: #d2d2d2 !important;
      }

      button.btn:hover{
      	text-shadow: none !important;
      }

      table a{
      	width: 25px;
    padding: 0px !important;
    border-radius: 5px;
    background-color: #171717 !important;
    color: #ffffff !important
      }

      table a i{
      	font-size: 18px;
      }
      	
      </style> 

      

                        
              	<?php  }else{ ?> 

              	<style type="text/css">
              		
              		body .span5a{
              			width: 100% !important;
              		}
              	</style> 

              	<?php } if($total_warnings_live > '0'){ ?> 





       <div class="span5a" >
          <div class="widget panel panel-default widget-content">
            <div class="panel-heading">
			  <h3 style="margin-bottom: 10px;" class="panel-title"> MY AUP VIOLATIONS</h3>

			   <?php if($violation_count != '3'){ ?>
			  
              <a class="accord_icon_a" data-toggle="collapse" data-target="#collapse3" href="JavaScript:Void(0);"><i  class="accord_icon"></i>
			  </a>

			  <?php } ?>
			
            </div>


            <div id="collapse3" class=" panel-collapse collapse in">
            	<div class="col_pad">
           
            	<?php 


            	  
					echo $vio; 
					echo $vio_up; 
			?>
            </div>
            </div>
        </div>
    </div>
    <?php }else{ ?>
      <!-- /row -->    

       <style type="text/css">
      	.span11a, .span5a{
      		width: 50%;
      	}

      	@media (max-width:979px) {
      		.span11a, .span5a{
      		width: 100%;
      	}
      	.widget{
      		margin-bottom: 0px !important;
      	}
      	.widget-content{
      		border-radius: 0px !important;
      	}
      	}
      </style>        
                        
                        <?php 

                        } ?>



						<?php  if($total_warnings_live == '0' && !empty($vio_up)){ ?> 





<div class="span4a" >
   <div class="widget ">
	 <div class="panel-heading">
	   <h3 style="margin-bottom: 10px;" class="panel-title"> MY AUP VIOLATIONS</h3>

	 </div>


	 <div id="collapse3" class=" panel-collapse collapse in">
		 <div class="col_pad">
	
		 <?php 


		   
			 echo $vio; 
			 echo $vio_up; 
	 ?>
	 </div>
	 </div>
 </div>
</div>
<?php } ?>
                        
                        
             
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          
          
          

          
          <!-- /widget -->
          
          <!-- /widget --> 
          
          <!-- /widget -->
        </div>
        <!-- /span6 --> 

       
      </div>
      <!-- /row --> 
                                    
                                    	
										
                                  <?php }?>
                                  
                                  
                                  
                                  
                                  
                                                    
                                                    
                                                    
												</div>
												<!-- /widget-content -->
											</div>
											<!-- /widget -->
								
								
								

	
									

									</div>


								</div>





							</div>
							<!-- /widget-content -->

						</div>
						<!-- /widget -->

					</div>
					<!-- /span8 -->




				</div>
				<!-- /row -->

			</div>
			<div class="footer_line_dot"></div>
			<!-- /container -->