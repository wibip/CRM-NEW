
<style type="text/css">
    #preview_img{
        max-height: 320px!important;
    }
 #logo2_up  {

	width: 193px !important;

    }
	@media (max-width: 480px){
		h3 span{
			display: block;
		}
	}
	#logo1_up_bc .croppedImg {
        max-width: 100% !important;
}
</style>

<script type="text/javascript">
	<?php if($modify_mode == 1) {  ?>

$(document).ready(function() {

$("#tab-create_theme").easyconfirm({locale: {
    title: 'Theme Update Cancel',
    text: 'Are you sure you want to cancel this theme update?',
    button: ['No',' Yes'],
    closeText: 'close'

}});

$("#tab-create_theme").click(function(e) {
	var click_id = e.target.id;
	var click_id_arr = click_id.split("-");
	window.location = "?active_tab="+click_id_arr[1];
});

});

<?php } ?>
</script>


<div class="tab-pane <?php if($active_tab == 'create_theme') echo 'active'; ?>" id="create_theme">


	 <?php

                                            if(isset($_SESSION['create_theme'])){

                                                echo $_SESSION['create_theme'];

                                                unset($_SESSION['create_theme']);





                                            }?>

                                                  <h1 class="head">
    First impressions last,
make yours a splash page. <img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable webpage upon connection to your Guest WiFi network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>

											<div id="en_response"></div>
<input type="hidden" id="using">


											<form id="edit-profile1" name="editprofile" class="form-horizontal" method="POST" action="theme.php" autocomplete="off">



												<input type="hidden" name="theme_modify" value="<?php echo $modify_mode; ?>">

												<input type="hidden" name="theme_id_post" value="<?php echo $theme; ?>">
												<input type="hidden" id="check_update" value="0">

												<?php

													echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET_THEME'].'" />';

												?>





												<fieldset>




                                                    <?php

                                                        $key_query1 = "SELECT DISTINCT tag_name FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor' ORDER BY tag_name ASC";

                                                        $query_results1=mysql_query($key_query1);

                                                        $count_ssid = mysql_num_rows($query_results1);



                                                        if($count_ssid == 0){

                                                            $warning_text = '<div class="alert alert-warning" role="alert"><h3><i class="icon-warning-sign"></i> Warning! <small>';

                                                            $warning_text .= '<br>Please create a <a href="campaign.php?t=4" class="alert-link">Group Tag / Location</a> before trying to create a theme';

                                                            $warning_text .= '</small></h3></div>';



                                                            echo $warning_text;

                                                        }

                                                    ?>




												<div id="val_1">
													<div class="control-group">

														<!-- <label class="control-label" for="radiobtns">Theme Name</label> -->



														<div class="controls">

															<h3 style="display: inline-block;">Name & type of splash page <span> theme<img data-toggle="tooltip" title='Customize your Guest WiFi splash page by giving it a name, selecting your location where the theme should show, setting the redirect URL where the visitors will land after registration, choosing a template and selecting a registration type.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" ></span></h3>

															<div class="input-prepend input-append">



															<input type="text" class="span5" id="theme_name1" name="theme_name" maxlength="32" placeholder="Portal Name" onkeyup="valid_check(this.value,'theme_name1_validate')"

															<?php if($modify_mode == 1) echo "value = \"".$theme_name_set."\""; ?>

															 required="required" autocomplete="off">



                                                             <!-- onkeyup="validateShedulname(this.value)" --> <div style="display:none;" class="help-block error-wrapper bubble-pointer mbubble-pointer" id="shedule_name_dup"><p>Theme name already exists</p></div>




															 <small id="theme_name1_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>


<?php if($modify_mode != 1){ ?>

													<script type="text/javascript">

                                                    $('#theme_name1').on('keyup', function(event) {

														var tname = document.getElementById("theme_name1").value;
                                                    //  alert(tname);
													//  themname(tname);

													   $.ajax({
                type: 'POST',
                url: 'ajax/validateThemeName.php',
                data: {user_distributor: "<?php echo $user_distributor; ?>",tname:tname},
                success: function(data) {

					if(data >0){
						document.getElementById('shedule_name_dup').style.display = 'inline-block';
						}else{
						 document.getElementById('shedule_name_dup').style.display = 'none';

							}

					}
            });


                                                    });

                                                    </script>
<?php } ?>


                                                                <script type="text/javascript">

                                                                    $("#theme_name1").keypress(function(event){

                                                                        var ew = event.which;

                                                                        if(ew == 32 || ew == 8 ||ew == 0 ||ew == 45 ||ew == 95)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57)
                                                                            return true;
                                                                        if(65 <= ew && ew <= 90)
                                                                            return true;
                                                                        if(97 <= ew && ew <= 122)
                                                                            return true;
                                                                        return false;
                                                                    });

																	$('#theme_name1').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                </script>



															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->





				                       				<div class="control-group">

														<!-- <label class="control-label" for="radiobtns">Group Tag / Location</label> -->



														<div class="controls">

															<h3 style="display: inline-block;">Select  Location/Property<img data-toggle="tooltip" title='You can create a unique splash page for each of your locations.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

															<div class="input-prepend input-append">

																<select id="location_ssid" class="span5" name="location_ssid" required="required" onchange="valid_check(this.value,'location_ssid_validate');">





																	<?php



																		if($modify_mode == 1) {

																			//echo "<option value = \"".$edit_ref_id."\">".$edit_ref_id."</option>";
																		}

																			else {

																				//echo "<option value =''> -- Select Group Tag --</option>";

																		}

																	?>



																	<?php


																	echo "<option value =''> Location </option>";


																		while($row1=mysql_fetch_array($query_results1)){



																			$tag_name = $row1[tag_name];

																			if($edit_ref_id==$tag_name){

																				$select='selected';

																			}else{

																				$select='';
																			}



																			echo '<option '.$select.' value="'.$tag_name.'">'.$tag_name.'</option>';

																		}



																	?>



																</select>




																<small id="location_ssid_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>



															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->









													<div class="control-group">

														<!-- <label class="control-label" for="radiobtns">Language</label> -->



														<div class="controls">

															<h3 style="display: inline-block;">Select Language<img data-toggle="tooltip" title='[Coming soon] You can create multiple language versions of your splash page.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

															<div class="input-prepend input-append">

																<select name="language" class="span5" id="language" required>



																	<?php



																	/*$key_query = "SELECT `language` FROM system_languages WHERE language_code = '$language'";



																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){



																		$language_name = $row[language];





																	}





																	if($modify_mode == 1){

																	 echo "<option value = \"".$language."\">".$language_name."</option>";

																	 }else{

																	 	echo '<option value="en">English</option>';

																	 }





																	$key_query = "SELECT language_code, `language` FROM system_languages WHERE language_code <> '$lang' AND ex_portal_status = 1 ORDER BY `language`";



																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$language_code = $row[language_code];

																		$language = $row[language];





																			echo '<option value="'.$language_code.'">'.$language.'</option>';



																	}*/

                                                                    echo '<option value="en">English</option>';



																	?>



																</select>







															</div>

														</div>

															<!-- /controls -->

													</div>

														<!-- /control-group -->





													<div class="control-group">

														<!-- <label class="control-label" for="radiobtns">Browser Title</label> -->



														<div class="controls">

															<h3 style="display: inline-block;">Browser Heading<img data-toggle="tooltip" title='Set the text you want your user to see in the splash page browser window.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

															<div class="input-prepend input-append">

																<input type="text" id="title_t" class="span5" name="title_t" value="<?php echo $title_t; ?>" required onkeyup="valid_check(this.value,'title_t_validate')">


																<small id="title_t_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>


															</div>

														</div>
														<script type="text/javascript">

$("#title_t").keypress(function(event){

	var ew = event.which;

	if(ew == 32 || ew == 8 ||ew == 0 ||ew == 45 ||ew == 95)
		return true;
	if(48 <= ew && ew <= 57)
		return true;
	if(65 <= ew && ew <= 90)
		return true;
	if(97 <= ew && ew <= 122)
		return true;
	return false;
});

$('#title_t').bind("cut copy paste",function(e) {
		  e.preventDefault();
	   });

</script>
														<!-- /controls -->

													</div>

													<!-- /control-group -->


<script type="text/javascript">

	function enableTextBox(){
		document.editprofile.loading.disabled=false;

		addListeners();
	}

	function toggleTextBox(e){
		checkbox = e.target;

		if(checkbox.checked == true){
			if(checkbox.name == "chk1"){
				document.editprofile.loading.disabled=true;

			//	$('#loading').val("fgg");
			}

		}
		else{
			document.editprofile.loading.disabled=false;
			//$('#loading').val("fgg");
		}
	}

	function addListeners(){
	 	check1 = document.editprofile.chk1;

		check1.addEventListener('click',toggleTextBox,true );
		//$('#loading').val("fgg");
	}
	window.onload = enableTextBox;

</script>


 <script>

Toggle();

function Toggle(){

if ($('#chk1').is(':checked')){

try{
document.editprofile.loading.value='';
}catch(e){


}

valid_check('valid','loading_validate');

}

else{

try{
document.editprofile.loading.value='Loading';
}catch(e){



}

//valid_check($('#loading').val(),'loading_validate');

}

}

</script>



												<!-- *************************** Text ************************** -->

													<div class="control-group">

														<!-- <label class="control-label" for="radiobtns">Loading Text</label> -->



														<div class="controls">

															<h3 style="display: inline-block;">Progression<img data-toggle="tooltip" title='Set the progression text your visitors will see while the registration page is loading. Special characters allowed are _.-' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

															<div class="input-prepend input-append">




															<input  class="span5 test" id="loading" <?php echo strlen($loading_txt)==0?'disabled':'' ?> name="loading" type="text" value="<?php echo $loading_txt; ?>" onkeyup="valid_check(this.value,'loading_validate')" >


																<small id="loading_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>



															<br>
															<input name="chk1" id="chk1" type="checkbox" <?php echo strlen($loading_txt)==0?'checked':'' ?> onClick="Toggle()" /> No Loader


															</div>

														</div>
														<script type="text/javascript">

$("#loading").keypress(function(event){

	var ew = event.which;

	if(ew == 32 || ew == 8 ||ew == 0 ||ew == 45 ||ew == 95 ||ew == 46)
		return true;
	if(48 <= ew && ew <= 57)
		return true;
	if(65 <= ew && ew <= 90)
		return true;
	if(97 <= ew && ew <= 122)
		return true;
	return false;
});

$('#loading').bind("cut copy paste",function(e) {
		  e.preventDefault();
	   });

</script>
														<!-- /controls -->

													</div>
<?php
$sys_pack = $system_package;
//$sys_pack=$db->getValueAsf("SELECT `system_package` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

$gt_template_optioncode= getOptions('TEMPLATE_ACTIVE',$sys_pack,'MVNO');

$pieces1 = explode(",", $gt_template_optioncode);

$len1 = count($pieces1);

$outstr1="";

for($i=0;$i<$len1;$i++){

	if($i==($len1-1)){

		$outstr1=$outstr1."'".$pieces1[$i]."'";

	}else{

		$outstr1=$outstr1."'".$pieces1[$i]."',";
	}


}




if ($sys_pack!='N/A') {

$key_query_t_name = "SELECT template_id, `name`  FROM exp_template WHERE `is_enable` ='1'

							AND template_id IN ($outstr1)";

}else{

$key_query_t_name = "SELECT template_id, `name`  FROM exp_template WHERE `is_enable` ='1'";


}




?>


													<div class="control-group">

														<!-- <label class="control-label" for="radiobtns">Redirect Type</label> -->

														<div class="controls">

															<h3 style="display: inline-block;">Redirection<img data-toggle="tooltip" title='Set the redirection URL  where the visitor will land after finalizing the registration. The Custom URL is the URL of your choice. The Default Website is the URL of your service provider. The Thank You Page is a static local system page.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

															<div class="input-prepend input-append">


															<select onchange="retype();" class="span5" id="redirect_type" name="redirect_type" required="required">

                                                            <option value="">Select Redirect Type</option>
															<option <?php if($reditct_typ=='default'){echo 'selected';} ?> value="default">Default Website</option>
															<option <?php if($reditct_typ=='thankyou'){echo 'selected';} ?> value="thankyou">Thank You Page</option>
															<option <?php if($reditct_typ=='custom'){echo 'selected';} ?> value="custom">Custom URL</option>

															</select>



															<small id="redirect_type_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>



															</div>
															</div>


														</div>

</div>

<script>

function retype(){

var type =$("#redirect_type").val();

if(type=='custom'){

	$("#reurl").show();

	valid_check($('#splash_url').val(),'splash_url_validate')

}else{

	$("#reurl").hide();

	valid_check('valid','splash_url_validate')
}

var this_val = $('#redirect_type').val();

valid_check(this_val,'redirect_type_validate');

}

function retype_ready(){

var type =$("#redirect_type").val();

if(type=='custom'){

	$("#reurl").show();
}else{

	$("#reurl").hide();
}



}


$( document ).ready(function() {



	retype_ready();
});


</script>





													<div class="control-group" id="reurl">

														<!-- <label class="control-label" for="radiobtns">Redirect URL</label> -->



														<div class="controls">



															<div class="input-prepend input-append">



															<select class="span2" name="urlsecure"><option <?php if($secspalsh=='http://'){echo 'selected';} ?> value="http://">http://</option><option <?php if($secspalsh=='https://'){echo 'selected';} ?> value="https://">https://</option></select>
															<input type="text" class="span3" id="splash_url" name="splash_url" placeholder="<?php
                                  echo $package_functions->getOptions('splash_page_url',$system_package); ?>"

															value="<?php echo $pathspalsh;?>" onkeyup="valid_check(this.value,'splash_url_validate')"

															 >


																<small id="splash_url_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>

																<script type="text/javascript">


                                                                    $("#splash_urlno").keydown(function(e) {
                                                                        var oldvalue=$(this).val();
                                                                        var field=this;
                                                                        setTimeout(function () {
                                                                            if(field.value.indexOf('http://') !== 0 && field.value.indexOf('https://') !== 0) {
                                                                                $(field).val(oldvalue);
                                                                            }
                                                                        }, 1);
                                                                    });
/*
                                                                    $(document).ready(function(){

                                                                        $('#splash_url').on('paste',function(){

                                                                        alert();
                                                                            setTimeout(functon(){
                                                                                var str = $('#splash_url').val();
                                                                                var pieces = str.split(/[//:]+/);
                                                                                if(pieces[pieces.length-2]==null){
                                                                                    $('#splash_url').value=pieces[pieces.length-1];
                                                                                }
                                                                                else{

                                                                                    $('#splash_url').value=pieces[pieces.length-2]+'//:'+pieces[pieces.length-1];
                                                                                }
                                                                            },0);

                                                                        });

                                                                    }); */


                                                                    function urlck(){


																	setTimeout(function(){

                                                                        var str = $('#splash_url').val();
                                                                        var pieces = str.split("://");

                                                                         if(pieces[pieces.length-2]==null){

                                                                              document.getElementById("splash_url").value = pieces[pieces.length-1];

                                                                        }
                                                                        else{

                                                                        	document.getElementById("splash_url").value = pieces[pieces.length-2]+'://'+pieces[pieces.length-1];

                                                                        }

																		}, 100);


                                                                        }

                                                                </script>


															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



<input type="hidden" name="edit_template_name" value="<?php echo $edit_template_name; ?>">


													<div class="control-group">

														<!-- <label class="control-label" for="radiobtns">Template Name</label> -->

														<div class="controls">

															<h3 style="display: inline-block;">Template<img data-toggle="tooltip" title='[Coming soon] Select from a list of predefined templates to modify to fit your location.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

															<div class="input-prepend input-append">




															<select onchange="choice2(this)" class="span5" id="template_name" name="template_name" required="required">





															<?php



             if($modify_mode == 1) {

             	$template_display_name=$db->getValueAsf("SELECT `name` as f  FROM exp_template WHERE `is_enable` ='1' AND template_id='$edit_template_name'");

             	echo '<option id="'.$template_display_name.'" value="'.$edit_template_name.'">'.$template_display_name.'</option>';

             }








														//	echo '<option id="'.$edit_template_name.'" value="'.$edit_template_name.'">'.$edit_template_name.'</option>';


																		$query_results1=mysql_query($key_query_t_name);

																		while($row=mysql_fetch_array($query_results1)){

																			$temp_id = $row[template_id];

																			$temp_name = $row[name];


                                      if($temp_id!=$edit_template_name || $modify_mode != 1){
																			echo '<option id="'.$temp_name.'" value="'.$temp_id.'">'.$temp_name.'</option>';
                                      }

																		}?>



															</select>
								<img  id="loading_ajax2" src="img/loading_ajax.gif" style="display:none"></img>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<div id="txtHint"></div>

    <script type="text/javascript">

    	var $before;
    	var $before_bac;
    	var welcome_old = '';
    	var first_name_old = '';
    	var last_name_old = '';
    	var email_old = '';
    	var mobile_number_old = '';
    	var age_group_old = '';
    	var gender_old = '';
    	var male_old = '';
    	var female_old = '';
    	var other_parameters_old = '';
    	var sign_up_old = '';
    	var first_name_check = "";
		var	last_name_check = "";
		var	email_check = "";
		var	mobile_number_check = "";
		var	gender_check = "";
		var	age_group_check = "";

    function choice2(select) {

		//$("#logo2_up img").remove();
		//$("#logo1_up img").remove();

		$("#logo2_up img").remove();
		$("#logo2_up .cropControlRemoveCroppedImage").hide();
		$("#logo1_up_bc img").remove();
		$("#logo1_up_bc .cropControlRemoveCroppedImage").hide();

		var x = select.options[select.selectedIndex].value;



		<?php

		if($modify_mode == 1){

		?>



		if(x=='<?php echo $edit_template_name; ?>'){
			$($before).insertBefore("#logo2_up .cropControls");
			$($before_bac).insertBefore("#logo1_up_bc .cropControls");
			$('#image_2_name').val("<?php echo $th_logo_image; ?>");
			$('#image_1_name').val("<?php echo $th_background_image; ?>");
			welcome_old = "<?php echo $welcome_txt; ?>";
			first_name_old = "<?php echo $first_name_text; ?>";
			last_name_old = "<?php echo $last_name_text; ?>";
			email_old = "<?php echo $email_field; ?>";
			mobile_number_old = "<?php echo $edit_mobile_number_fields; ?>";
			age_group_old = "<?php echo $age_group_field; ?>";
			gender_old = "<?php echo $gender_field; ?>";
			male_old = "<?php echo $male_field; ?>";
			female_old = "<?php echo $female_field; ?>";
			other_parameters_old = "<?php echo $edit_other_fields; ?>";
			sign_up_old = "<?php echo $registration_btn; ?>";

			first_name_check = "<?php echo $manual_login_fields['first_name']; ?>";
			last_name_check = "<?php echo $manual_login_fields['last_name']; ?>";
			email_check = "<?php echo $manual_login_fields['email']; ?>";
			mobile_number_check = "<?php echo $manual_login_fields['mobile_number']; ?>";
			gender_check = "<?php echo $manual_login_fields['gender']; ?>";
			age_group_check = "<?php echo $manual_login_fields['age_group']; ?>";

			  /*  gradX("#gradX", {
        direction: "top",
        name: "duotone_bg",
        sliders: [
		   {
		     color: "<?php //echo $duotone_bg_rgba1; ?>",
		     position: <?php //echo $duotone_bg_pos1; ?>
		   },
		   {
		     color: "<?php //echo $duotone_bg_rgba2; ?>",
		     position: <?php //echo $duotone_bg_pos2; ?>
		   }
		]
    });*/

		}
		else{
			welcome_old = '';
    	 first_name_old = 'Last Name';
    	 last_name_old = 'Last Name';
    	 email_old = 'Email';
    	 mobile_number_old = 'Mobile Number';
    	 age_group_old = 'Age Range';
    	 gender_old = 'Gender';
    	 male_old = 'Male';
    	 female_old = 'Female';
    	 other_parameters_old = '';
    	 sign_up_old = 'Register';

    	 first_name_check = "";
			last_name_check = "";
			email_check = "1";
			mobile_number_check = "";
			gender_check = "1";
			age_group_check = "1";

			 /*     gradX("#gradX", {
        direction: "top",
        name: "duotone_bg",
        sliders: [
		   {
		     color: "rgb(211, 89, 54)",
		     position: 7
		   },
		   {
		     color: "rgb(61, 0, 0)",
		     position: 86
		   }
		]
    });*/

    	}

		<?php

		}else{

		 ?>

		 welcome_old = '';
    	 first_name_old = 'Last Name';
    	 last_name_old = 'Last Name';
    	 email_old = 'Email';
    	 mobile_number_old = 'Mobile Number';
    	 age_group_old = 'Age Range';
    	 gender_old = 'Gender';
    	 male_old = 'Male';
    	 female_old = 'Female';
    	 other_parameters_old = '';
    	 sign_up_old = 'Register';

    	 first_name_check = "";
			last_name_check = "";
			email_check = "1";
			mobile_number_check = "";
			gender_check = "1";
			age_group_check = "1";

			  /*    gradX("#gradX", {
        direction: "top",
        name: "duotone_bg",
        sliders: [
		   {
		     color: "rgb(211, 89, 54)",
		     position: 7
		   },
		   {
		     color: "rgb(61, 0, 0)",
		     position: 86
		   }
		]
    });*/

		 <?php } ?>

		$('#logo_txt1_enable').attr('checked', false);
		$('#logo_1_text').attr('disabled', true);
		$('#logo_1_text').val('');
		$('#divlogo1').show();

        document.getElementById("loading_ajax2").style.display = "";


		try {
			$('.cropControlUpload').show();
			$('.new_upload').remove();
			$(".cropControlsUpload").removeClass('warning_img');
			$("#logo1_up").cropper("destroy");
			$("#logo2_up").cropper("destroy");
			$("#logo1_up_bc").cropper("destroy");
			cropContaineroutput.destroy();
		} catch (error) {

		}

        if(x=="default_theme" || x=="red_template" || x=="altice_business_default"){

        	$("#social_first").html('<p class=""><b>Step 3.</b> On the main registration screen, the Social Media button(s) will appear at the top based on your selection. In addition, you can select which Demographic Data to collect.</p>');

        	$("#social_second").hide();
        	$("#cmnlogintxt").hide();
        	//$("#manualbutton").hide();
        	$("#ios").hide();
        	$("#ios2").hide();

        	$("#first_name").val(first_name_old);
        	$("#last_name").val(last_name_old);
        	$("#email").val(email_old);
        	$("#mobile_number").val(mobile_number_old);
        	$("#age_group").val(age_group_old);
        	$("#gender").val(gender_old);
        	$("#male").val(male_old);
        	$("#female").val(female_old);
        	$("#other_parameters").val(other_parameters_old);
        	$("#sign_up").val(sign_up_old);

        	if(first_name_check == '1'){

				$('#m_first_name').prop('checked', true);
			}
			else{
				$('#m_first_name').prop('checked', false);
			}
			if(last_name_check == '1'){

				$('#m_last_name').prop('checked', true);
			}
			else{
				$('#m_last_name').prop('checked', false);
			}
			if(email_check == '1'){

				$('#m_email').prop('checked', true);
			}
			else{
				$('#m_email').prop('checked', false);
			}
			if(mobile_number_check == '1'){

				$('#m_mobile').prop('checked', true);
			}
			else{
				$('#m_mobile').prop('checked', false);
			}
			if(gender_check == '1'){

				$('#m_gender').prop('checked', true);
			}
			else{
				$('#m_gender').prop('checked', false);
			}
			if(age_group_check == '1'){

				$('#m_age_group').prop('checked', true);
			}
			else{
				$('#m_age_group').prop('checked', false);
			}

			manual_toggle($('#m_first_name')) ;
			manual_toggle($('#m_age_group')) ;
			manual_toggle_gender($('#m_gender')) ;
			manual_toggle($('#m_mobile')) ;
			manual_toggle($('#m_email')) ;
			manual_toggle($('#m_last_name')) ;
        }
        else{
            $("#social_first").html('<p class=""><b>Step 4.</b> On the main registration screen you can set the Social Media Registration Information text and the Social Media Button text. In addition you can set the Manual Registration Information text, select which Demographic Data to collect, and set the Manual Registration Button text.</p>');

            $("#social_second").show();
            $("#cmnlogintxt").show();
            $("#manualbutton").show();
            $("#ios").show();
        	$("#ios2").show();

        }


        if(x=="red_template" || x=="altice_business_default"){

        	$("#duotone").show();
        	$("#backcolor1n2").hide();

        }
        else{
        	$("#duotone").hide();
        	$("#backcolor1n2").show();
		}

		if((x=='res_cox_standard_template') || (x=='res_cox_modern_hori_template')){
			$('#logo_1_txt').html('Logo Alternative Text');
			$('#logo_1_title').html('Logo or Logo Alternative Text ');
		}
		else{
			$('#logo_1_title').html('Logo or Logo Alternative Text ');
			$('#logo_1_txt').html('Logo Alternative Text');
		}

		if((x=='res_cox_modern_hori_template')){
			$('#bgcolor_txt').html('Banner Background Color');
			$('#fontcolor_txt').html('Banner Font Color');
		}
		else{
			$('#bgcolor_txt').html('Banner & Greeting Background Color');
			$('#fontcolor_txt').html('Banner & Greeting Font Color');
		}

		if((x=='res_cox_standard_template')){
			$('#greeting_txt').attr('maxlength', '90');
			$('#greeting_txt_txt').html('<p><b>Note: You can add your customized message to the beginning of the default Greeting Text. It can have up to 90 characters with spaces.</b></p><p>If you are using the Passcode Registration Type your Greeting Text will be followed by: <br><b> Review and agree to the Terms of Use, enter the passcode and click SUBMIT.</b></p><p>If you are using the Click to Connect Registration Type your Greeting Text will be followed by:  <br> <b> Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.  </b></p>');
			$('#banner-label').html('Property Message');
			$('#banner-def-txt').hide();
			$('#banner-under-txt').html('<b>Note: You can add in Customizable description or message from the property. It can have up to 350 characters with spaces.</b>');
			$('#welcome').replaceWith('<textarea id="welcome" class="span4" onkeyup="valid_check(this.value,\'welcome_validate\')" maxlength="350" name="welcome"style="padding: 10px;border: 1px solid #979798;padding-left: 20px !important;padding-right: 20px !important;height: 72px;" ></textarea>');
			$('#welcome_validate').hide();
		}
		else{
			$('#greeting_txt').attr('maxlength', '90');
			$('#greeting_txt_txt').html('<p><b>Note: You can add your customized message to the beginning of the default  Greeting Text, it can have up to 90 characters with spaces.</b></p> <p>If you are using the Passcode Registration Type your Greeting Text will be followed by: <br> <p><b> Review and agree to the Terms of Use, enter the passcode and click SUBMIT.</b></p><p>If you are using the Click to Connect Registration Type your Greeting Text will be followed by: <br> <b> Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.  </b></p>');
			$('#banner-label').html('Banner Text');
			$('#banner-def-txt').show();
			$('#banner-under-txt').html('<b>Note: You can add in your business name to the end of the default Banner Text. It can have up to 30 characters with spaces.</b>');
			$('#welcome').replaceWith('<input type="text" id="welcome" onkeyup="valid_check(this.value,\'welcome_validate\')" maxlength="30" name="welcome" class="span4 banner_txt_val" required="required" placeholder="Enter customer name text" value="'+ welcome_old +'">');
			$('#welcome_validate').hide();
		}

		if((x=='res_cox_block_template')){
			$('#logo_txt2_enable').attr('checked', false);
			$('#logo_2_text').attr('disabled', true);
			$('#logo_2_text').val('');

		}
        // if(x=="default_theme"){

        // 	$("#backcolor").show();

        // }
        // else{
        //     $("#backcolor").hide();
        // }

        var z = 'x='+x+'&var_img=&hor_img='
		var z2 = '<?php echo $user_distributor; ?>';

        	$("#varimg").show();
        	$("#horimg").show();

             $("#img_ajax").html('');
            $.post("ajax/theme_image_load.php", {dir_name: z,discode: z2}, function(result){

                    var txtArr = result.split(":||:");


                    $("#up_logo_name1").html(txtArr[0]);
                    $("#up_logo_desc1").html(txtArr[1]);
                    $("#up_logo_name2").html(txtArr[2]);
                    $("#up_logo_desc2").html(txtArr[3]);
                    $("#img_ajax").html(txtArr[4]);
                    var check_img1=document.getElementById("check_img1").value;
                    var check_img2=document.getElementById("check_img2").value;
                    var check_img3=document.getElementById("check_img3").value;

                    if(check_img1 == 0){
                        $("#backimg").hide();

                    }
                    else{
                        $("#backimg").show();
                    }
                    if(check_img2 == 0){
                        $("#logoimg").hide();
                        $("#alttxt2").hide();


                    }
                    else{
                         $("#logoimg").show();
                         $("#alttxt2").show();
                    }
                    if(check_img3 == 0){

                         $("#varimg").hide();
                    }
                    else{
                         $("#varimg").show();
                    }

                    var width_2 = $(window).width();

                    var width_table_res = $(".main-inner").children().first().width();

                    var width_table_res1 = width_table_res - 30;
                    $(".table_response").css("width", width_table_res1);

                    if(width_2<463){
                        var width_table_res2 = width_table_res - 30;
                    }
                    else{
                        var width_table_res2 = width_table_res - 220;
                    }

                    $(".theme_response").css("width", width_table_res2);

                    });

        	//  }

          $.ajax({
                type: 'POST',
                url: 'ajax/template_hide_load.php',
				dataType : 'json',
                data: "id="+x,
                success: function(response) {

				var data = response.hide_divs;


				var obj = JSON.parse(response.options);

				try {
					$.map(obj, function(el, key) {

					$.map( el, function( value ) {
							  if(key == 'text'){
									$('#'+value.id).html(value[key]);
							  }
							  else{
								  $('#'+value.id).attr(key, value[key]);
							  }
					});

				});

				}catch(err) {}


                var res = data.split(",");
                var alen = res.length;

	        	$("#backcolor").show();
                $("#mregbtn").show();
	        	$("#color").show();

	        	$("#mregbtn").show();

	        	$("#step5").show();
	        	$("#limg").show();
	        	$("#wback").show();
	        	$("#footera").show();
	        	$("#txt_hide").show();

				$("#hrcolor").show();
	        	$("#fontcolor").show();


				for (i = 0; i < alen; i++) {


					$('#'+res[i]).hide();

				}


                }
            });


temp_image();



    		}




    </script>

	<script type="text/javascript">


	$(document).ready(function() {

		$before = $("#logo_hi_2").clone(true);
		$before_bac = $("#logo1_up_bc").clone(true);

		var x = $("#template_name").val();
        var x1 = $("#reg_type").val();
		//console.log(x);

		if(x1=='AUTH_DISTRIBUTOR_PASSCODE'){
					var template_name1 = (x + '_pas');
				}
				else{
					var template_name1 = (x + '_' + x1);
				}

				<?php

				$template_image_suffix = $pack_func->getOptions('template_image_suffix',$system_package);

				if(strlen($template_image_suffix) > 0){

				?>

				var xx = x1 + '_<?php echo $template_image_suffix; ?>';

				<?php }else{ ?>

				var xx = x1;

				<?php } ?>

        var y = '<img src="<?php echo $base_portal_folder; ?>/template/'+x+'/img/'+xx+'.jpg?v=14" style="max-height:320px;width:60%;max-width: 100%"><p><a id="pre_id" class="fancybox fancybox.iframe" href="<?php echo $base_portal_folder; ?>/checkpoint.php?client_mac=DEMO_MAC&theme='+template_name1+'&realm=<?php echo $db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");?>">Preview Template Layout</a>';

       // console.log(y);
        document.getElementById("template_image").innerHTML=y;
	     //  var x = select.options[select.selectedIndex].value;


	        //if(x=="default_theme"){

	        	//$("#varimg").hide();
	        	//$("#horimg").hide();
	        	// document.getElementById("template_image").innerHTML='';

	           // }
	      //  else{


			if((x=='res_cox_standard_template') || (x=='res_cox_modern_hori_template')){
				$('#logo_1_txt').html('Logo Alternative Text');
			}
			else{
				$('#logo_1_txt').html('Logo Alternative Text');
			}

			if((x=='res_cox_modern_hori_template')){
			$('#bgcolor_txt').html('Banner Background Color');
			$('#fontcolor_txt').html('Banner Font Color');
		}
		else{
			$('#bgcolor_txt').html('Banner & Greeting Background Color');
			$('#fontcolor_txt').html('Banner & Greeting Font Color');
		}

		if((x=='res_cox_standard_template')){
			$('#greeting_txt').attr('maxlength', '90');
			$('#greeting_txt_txt').html('<p><b>Note: You can add your customized message to the beginning of the default Greeting Text. It can have up to 90 characters with spaces.</b></p><p>If you are using the Passcode Registration Type your Greeting Text will be followed by: <br><b> Review and agree to the Terms of Use, enter the passcode and click SUBMIT.</b></p><p>If you are using the Click to Connect Registration Type your Greeting Text will be followed by:  <br> <b> Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.  </b></p>');
			$('#banner-label').html('Property Message');
			$('#banner-def-txt').hide();
			$('#banner-under-txt').html('<b>Note: You can add in Customizable description or message from the property. It can have up to 350 characters with spaces.</b>');

			<?php if($modify_mode == 1) {

			 	$txt_new = $welcome_txt ;

			}
			else{
				$txt_new = '' ;
			}

			?>

			$('#welcome').replaceWith('<textarea id="welcome" class="span4 banner_txt_val" onkeyup="valid_check(this.value,\'welcome_validate\')" maxlength="350" name="welcome"style="padding: 10px;border: 1px solid #979798;padding-left: 20px !important;padding-right: 20px !important;height: 72px;" ><?php echo $txt_new; ?></textarea>');
			$('#welcome_validate').hide();

		}
		else{


			<?php if($modify_mode == 1) {

			 	$txt_new = $welcome_txt ;

			}
			else{
				$txt_new = '' ;
			}

			?>

			$('#greeting_txt').attr('maxlength', '90');
			$('#greeting_txt_txt').html('<p><b>Note: You can add your customized message to the beginning of the default  Greeting Text, it can have up to 90 characters with spaces.</b></p> <p>If you are using the Passcode Registration Type your Greeting Text will be followed by: <br> <b> Review and agree to the Terms of Use, enter the passcode and click SUBMIT.</b></p><p>If you are using the Click to Connect Registration Type your Greeting Text will be followed by: <br> <b> Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.  </b></p>');
			$('#banner-label').html('Banner Text');
			$('#banner-def-txt').show();
			$('#banner-under-txt').html('<b>Note: You can add in your business name to the end of the default Banner Text. It can have up to 30 characters with spaces.</b>');
			$('#welcome').replaceWith('<input type="text" id="welcome" onkeyup="valid_check(this.value,\'welcome_validate\')" maxlength="30" name="welcome" class="span4 banner_txt_val" required="required" placeholder="Enter customer name text" value="<?php echo $txt_new; ?>">');
			$('#welcome_validate').hide();
		}


	      var z = 'x='+x+'&var_img=<?php echo $edit_var_img; ?>&hor_img=<?php echo $edit_hor_img; ?>'
	      var z2 = '<?php echo $user_distributor; ?>';


	        	$("#varimg").show();
	        	$("#horimg").show();

	             $("#img_ajax").html('');

	            $.post("ajax/theme_image_load.php", {dir_name: z,discode: z2}, function(result){

	                    var txtArr = result.split(":||:");


	                    $("#up_logo_name1").html(txtArr[0]);
	                    $("#up_logo_desc1").html(txtArr[1]);
	                    $("#up_logo_name2").html(txtArr[2]);
	                    $("#up_logo_desc2").html(txtArr[3]);
	                    $("#img_ajax").html(txtArr[4]);

	                    var check_img1=document.getElementById("check_img1").value;
	                    var check_img2=document.getElementById("check_img2").value;
	                    var check_img3=document.getElementById("check_img3").value;

	                    if(check_img1 == 0){
	                        $("#backimg").hide();

	                    }
	                    else{
	                        $("#backimg").show();
	                    }
	                    if(check_img2 == 0){
	                        $("#logoimg").hide();
	                        $("#alttxt2").hide();

	                    }
	                    else{
	                         $("#logoimg").show();
	                         $("#alttxt2").show();
	                    }
	                    if(check_img3 == 0){

	                         $("#varimg").hide();
	                    }
	                    else{
	                         $("#varimg").show();
	                    }

	                    });

	        	//  }

	            $.ajax({
	                type: 'POST',
					url: 'ajax/template_hide_load.php',
					dataType : 'json',
	                data: "id="+x,
	                success: function(response) {

					var data = response.hide_divs;
					var obj = JSON.parse(response.options);

					try {
					$.map(obj, function(el, key) {

					$.map( el, function( value ) {
							  if(key == 'text'){
									$('#'+value.id).html(value[key]);
							  }
							  else{
								  $('#'+value.id).attr(key, value[key]);
							  }
					});

					});

					}catch(err) {}

	                var res = data.split(",");
	                var alen = res.length;




					for (i = 0; i < alen; i++) {


						$('#'+res[i]).hide();

					}

					if($('#logo_txt2_enable').is(":checked")){
											$('#divlogo2').hide();
										}


	                }
	            });







////



















		var conceptName = $('#template_name').find(":selected").text();
		var x = document.getElementById("#template_name");


		if(conceptName=="Default Template" ){


        	$("#varimg").hide();
        	$("#horimg").hide();
        	//document.getElementById("template_image").innerHTML='';

        	$("#mregbtn").show();
        	$("#color").show();

        	$("#mregbtn").show();

        	$("#step5").show();
        	$("#limg").show();
        	$("#wback").show();
        	$("#footera").show();

            }
		else{

	       // document.getElementById("template_image").innerHTML='<center><img  src="<?php //echo $base_url; ?>/template/'+x+'/img/template_image.jpg" width="400px;"></center>';

        	/* $("#varimg").show();
        	$("#horimg").show();

        	$("#mregbtn").hide();
        	$("#color").hide();

        	$("#mregbtn").hide();

        	$("#step5").hide();
        	$("#limg").hide();
        	$("#wback").hide();
        	$("#footera").hide(); */

            }



});


</script>

	<script type="text/javascript">

	$(document).ready(function() {






});


</script>


													<!-- /control-group -->


													<div class="control-group">

														<!-- <label class="control-label" for="radiobtns">Registration Type</label> -->



														<div class="controls">

															<h3 style="display: inline-block;">Registration Type<img data-toggle="tooltip" title=' Select the type of registration you would require your visitors to complete to gain access to the Internet.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

															<div class="input-prepend input-append">


	<script type="text/javascript" src="js/jquery.select.js"></script>

    <script type="text/javascript">

    function choice1(select) {
        var x = select.options[select.selectedIndex].value;
        document.getElementById("loading_ajax1").style.display = "";

        $('.pass_hide').hide();

        //alert(x);
        if(x=="CLICK"){


         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
         try {$("#sms_input").hide();}catch(err) {}
         try {document.getElementById("m_first_name").checked = false;}catch(err) {}
         try {document.getElementById("m_last_name").checked = false;}catch(err) {}
         try {document.getElementById("m_email").checked = false;}catch(err) {}
         try {document.getElementById("m_gender").checked = false;}catch(err) {}
         try {document.getElementById("m_mobile").checked = false;}catch(err) {}
         try {document.getElementById("m_age_group").checked = false;}catch(err) {}

            }
        else if(x=="FB" ){

         try {$("#social").show();}catch(err) {}
         try {$("#ios").show();}catch(err) {}
         try {$("#ios2").show();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#manualbutton").hide();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
         try {$("#sms_input").hide();}catch(err) {}
           }
        else if(x=="FB_MANUAL" ){

         try {$("#social").show();}catch(err) {}
         try {$("#ios").show();}catch(err) {}
         try {$("#ios2").show();}catch(err) {}
         try {$("#manual").show();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
         try {$("#sms_input").hide();}catch(err) {}
           }
        else if(x=="MANUAL" ){

         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").show();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
         try {$("#sms_input").hide();}catch(err) {}
           }
        else if(x=="PREMIUM"){

		   try {$("#social").hide();}catch(err) {}
		   try {$("#ios").hide();}catch(err) {}
		   try {$("#ios2").hide();}catch(err) {}
		   try {$("#manual").hide();}catch(err) {}
		   try {$("#voucher").hide();}catch(err) {}
		   try {$("#sms_input").hide();}catch(err) {}
		   try {document.getElementById("m_first_name").checked = false;}catch(err) {}
		   try {document.getElementById("m_last_name").checked = false;}catch(err) {}
		   try {document.getElementById("m_email").checked = false;}catch(err) {}
		   try {document.getElementById("m_gender").checked = false;}catch(err) {}
		   try {document.getElementById("m_mobile").checked = false;}catch(err) {}
		   try {document.getElementById("m_age_group").checked = false;}catch(err) {}

	            }
	    else if(x=="MANUAL_PREMIUM" ){

		   try {$("#social").hide();}catch(err) {}
		   try {$("#ios").hide();}catch(err) {}
		   try {$("#ios2").hide();}catch(err) {}
		   try {$("#manual").show();}catch(err) {}
		   try {$("#manualbutton").show();}catch(err) {}
		   try {$("#voucher").hide();}catch(err) {}
		   try {$("#sms_input").hide();}catch(err) {}
		           }
		 else if(x=="FB_PREMIUM" ){

		   try {$("#social").show();}catch(err) {}
		   try {$("#ios").show();}catch(err) {}
		   try {$("#ios2").show();}catch(err) {}
		   try {$("#manual").hide();}catch(err) {}
		   try {$("#manualbutton").hide();}catch(err) {}
		   try {$("#voucher").hide();}catch(err) {}
		   try {$("#sms_input").hide();}catch(err) {}
	           }
	     else if(x=="FB_MANUAL_PREMIUM" ){

		   try {$("#social").show();}catch(err) {}
		   try {$("#ios").show();}catch(err) {}
		   try {$("#ios2").show();}catch(err) {}
		   try {$("#manual").show();}catch(err) {}
		   try {$("#manualbutton").show();}catch(err) {}
		   try {$("#voucher").hide();}catch(err) {}
		   try {$("#sms_input").hide();}catch(err) {}
		            }
        else if(x=="SMS_PASSCODE" ){

         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
         try {$("#sms_input").show();}catch(err) {}
         try {document.getElementById("m_first_name").checked = false;}catch(err) {}
         try {document.getElementById("m_last_name").checked = false;}catch(err) {}
         try {document.getElementById("m_email").checked = false;}catch(err) {}
         try {document.getElementById("m_gender").checked = false;}catch(err) {}
         try {document.getElementById("m_age_group").checked = false;}catch(err) {}
           }
        else if(x=="AUTH" ){

         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").show();}catch(err) {}
         try {$("#sms_input").hide();}catch(err) {}
           }
        else if(x=="AUTH_DISTRIBUTOR_PASSCODE" ){

         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
         try {$("#sms_input").hide();}catch(err) {}

         $("#reg_type").after("<strong class='pass_hide' style='display: block; margin-top: 10px'>Note: If Passcode Authentication is selected, please validate your current passcode generation method or change it as desired. It is currently set to the following: <?php echo $pass_type.' - '.$voucher_number; ?></strong>");

           }
        else{
         try {$("#social").show();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").show();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
         try {$("#sms_input").hide();}catch(err) {}


            }


            var x = $("#template_name").val();

				if(x=="default_theme" || x=="red_template" || x=="altice_business_default" ){

			        	$("#social_first").html('<p class=""><b>Step 3.</b> On the main registration screen, the Social Media button(s) will appear at the top based on your selection. In addition, you can select which Demographic Data to collect.</p>');

			        	$("#social_second").hide();
			        	$("#cmnlogintxt").hide();
			        	//$("#manualbutton").hide();
			        	$("#ios").hide();
        				$("#ios2").hide();

			    }
			    else{
			    		$("#ios").hide();
        				$("#ios2").hide();
			    }


            temp_image();

      }

    </script>
    <script>
            function temp_image(){
                var template_name=document.getElementById("template_name").value;
                var reg_type=document.getElementById("reg_type").value;

				if(reg_type=='AUTH_DISTRIBUTOR_PASSCODE'){
					template_name1 = (template_name + '_pas');
				}
				else{
					template_name1 = (template_name + '_' + reg_type);
				}


				<?php

				$template_image_suffix = $pack_func->getOptions('template_image_suffix',$system_package);

				if(strlen($template_image_suffix) > 0){

				?>

				var xx = reg_type + '_<?php echo $template_image_suffix; ?>';

				<?php }else{ ?>

				var xx = reg_type;

				<?php } ?>



                $.post("ajax/temp_image_load.php", {template_name: template_name,template_name1: template_name1,image: xx ,reg_type: reg_type,rm:'<?php echo $db->getValueAsf("SELECT `group_number` AS f FROM `exp_distributor_groups` WHERE `distributor`='$user_distributor' LIMIT 1");?>'}, function(result){

                var txtArr = result.split(":||:");
                document.getElementById("using").innerHTML= txtArr[1];


                var check = document.getElementById("checking").value ;
                    if(check == "error"){

                    }
                    else{


$('#template_image').hide().html(txtArr[0]).fadeIn('slow');

                                 //document.getElementById("loading_ajax2").style = "display:none";
                                 //document.getElementById("loading_ajax1").style = "display:none";

                                 document.getElementById("loading_ajax2").style.display = "none";
                                 document.getElementById("loading_ajax1").style.display = "none";




                }
                });


            }

    </script>

<script type="text/javascript">

$(document).ready(function() {

	  //var conceptName = $('#reg_type').find(":selected").text();
	  var conceptName = $( "#reg_type" ).val()
	  //alert(conceptName);

	  if(conceptName=="FB_MANUAL" ){

	   try {$("#social").show();}catch(err) {}
	   try {$("#ios").show();}catch(err) {}
	   try {$("#ios2").show();}catch(err) {}
	   try {$("#manual").show();}catch(err) {}
	   try {$("#manualbutton").show();}catch(err) {}
	   try {$("#voucher").hide();}catch(err) {}
	   try {$("#sms_input").hide();}catch(err) {}
	            }
	   

	  else if(conceptName=="CLICK"){

	   try {$("#social").hide();}catch(err) {}
	   try {$("#ios").hide();}catch(err) {}
	   try {$("#ios2").hide();}catch(err) {}
	   try {$("#manual").hide();}catch(err) {}
	   try {$("#voucher").hide();}catch(err) {}
	   try {$("#sms_input").hide();}catch(err) {}
	   try {document.getElementById("m_first_name").checked = false;}catch(err) {}
	   try {document.getElementById("m_last_name").checked = false;}catch(err) {}
	   try {document.getElementById("m_email").checked = false;}catch(err) {}
	   try {document.getElementById("m_gender").checked = false;}catch(err) {}
	   try {document.getElementById("m_mobile").checked = false;}catch(err) {}
	   try {document.getElementById("m_age_group").checked = false;}catch(err) {}

	            }
	  else if(conceptName=="FB" ){

	   try {$("#social").show();}catch(err) {}
	   try {$("#ios").show();}catch(err) {}
	   try {$("#ios2").show();}catch(err) {}
	   try {$("#manual").hide();}catch(err) {}
	   try {$("#manualbutton").hide();}catch(err) {}
	   try {$("#voucher").hide();}catch(err) {}
	   try {$("#sms_input").hide();}catch(err) {}
	           }
	  else if(conceptName=="MANUAL" ){

	   try {$("#social").hide();}catch(err) {}
	   try {$("#ios").hide();}catch(err) {}
	   try {$("#ios2").hide();}catch(err) {}
	   try {$("#manual").show();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").hide();}catch(err) {}
	         try {$("#sms_input").hide();}catch(err) {}
	           }
	    else if(conceptName=="PREMIUM"){

		   try {$("#social").hide();}catch(err) {}
		   try {$("#ios").hide();}catch(err) {}
		   try {$("#ios2").hide();}catch(err) {}
		   try {$("#manual").hide();}catch(err) {}
		   try {$("#voucher").hide();}catch(err) {}
		   try {$("#sms_input").hide();}catch(err) {}
		   try {document.getElementById("m_first_name").checked = false;}catch(err) {}
		   try {document.getElementById("m_last_name").checked = false;}catch(err) {}
		   try {document.getElementById("m_email").checked = false;}catch(err) {}
		   try {document.getElementById("m_gender").checked = false;}catch(err) {}
		   try {document.getElementById("m_mobile").checked = false;}catch(err) {}
		   try {document.getElementById("m_age_group").checked = false;}catch(err) {}

	            }
	    else if(conceptName=="MANUAL_PREMIUM" ){

		   try {$("#social").hide();}catch(err) {}
		   try {$("#ios").hide();}catch(err) {}
		   try {$("#ios2").hide();}catch(err) {}
		   try {$("#manual").show();}catch(err) {}
		         try {$("#manualbutton").show();}catch(err) {}
		         try {$("#voucher").hide();}catch(err) {}
		   try {$("#sms_input").hide();}catch(err) {}
		           }
		 else if(conceptName=="FB_PREMIUM" ){

		   try {$("#social").show();}catch(err) {}
		   try {$("#ios").show();}catch(err) {}
		   try {$("#ios2").show();}catch(err) {}
		   try {$("#manual").hide();}catch(err) {}
		   try {$("#manualbutton").hide();}catch(err) {}
		   try {$("#voucher").hide();}catch(err) {}
		   try {$("#sms_input").hide();}catch(err) {}
	           }
	     else if(conceptName=="FB_MANUAL_PREMIUM" ){

		   try {$("#social").show();}catch(err) {}
		   try {$("#ios").show();}catch(err) {}
		   try {$("#ios2").show();}catch(err) {}
		   try {$("#manual").show();}catch(err) {}
		   try {$("#manualbutton").show();}catch(err) {}
		   try {$("#voucher").hide();}catch(err) {}
		   try {$("#sms_input").hide();}catch(err) {}
		            }
	     else if(conceptName=="SMS_PASSCODE" ){

	   try {$("#social").hide();}catch(err) {}
	   try {$("#ios").hide();}catch(err) {}
	   try {$("#ios2").hide();}catch(err) {}
	   try {$("#manual").hide();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").hide();}catch(err) {}
	         try {$("#sms_input").show();}catch(err) {}
	         try {document.getElementById("m_first_name").checked = false;}catch(err) {}
		   try {document.getElementById("m_last_name").checked = false;}catch(err) {}
		   try {document.getElementById("m_email").checked = false;}catch(err) {}
		   try {document.getElementById("m_gender").checked = false;}catch(err) {}
		   try {document.getElementById("m_age_group").checked = false;}catch(err) {}
	           }
	        else if(conceptName=="AUTH" ){

	         try {$("#social").hide();}catch(err) {}
	         try {$("#ios").hide();}catch(err) {}
	         try {$("#ios2").hide();}catch(err) {}
	         try {$("#manual").hide();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").show();}catch(err) {}
	         try {$("#sms_input").hide();}catch(err) {}
	           }
	        else if(conceptName=="AUTH_DISTRIBUTOR_PASSCODE" ){

	         try {$("#social").hide();}catch(err) {}
	         try {$("#ios").hide();}catch(err) {}
	         try {$("#ios2").hide();}catch(err) {}
	         try {$("#manual").hide();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").hide();}catch(err) {}
	         try {$("#sms_input").hide();}catch(err) {}

	           }
	        else{

	         try {$("#social").show();}catch(err) {}
	         try {$("#ios").hide();}catch(err) {}
	         try {$("#ios2").hide();}catch(err) {}
	         try {$("#manual").show();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").hide();}catch(err) {}
	         try {$("#sms_input").hide();}catch(err) {}


	            }


	         var x = $("#template_name").val();

				if(x=="default_theme" || x=="red_template" || x=="altice_business_default" ){

			        	$("#social_first").html('<p class=""><b>Step 3.</b> On the main registration screen, the Social Media button(s) will appear at the top based on your selection. In addition, you can select which Demographic Data to collect.</p>');

			        	$("#social_second").hide();
			        	$("#cmnlogintxt").hide();
			        	//$("#manualbutton").hide();
			        	$("#ios").hide();
        				$("#ios2").hide();

			    }
			    else{
			            $("#social_first").html('<p class=""><b>Step 4.</b> On the main registration screen you can set the Social Media Registration Information text and the Social Media Button text. In addition you can set the Manual Registration Information text, select which Demographic Data to collect, and set the Manual Registration Button text.</p>');

			            $("#social_second").show();
			            $("#cmnlogintxt").show();
			            $("#manualbutton").show();
			            $("#ios").show();
        				$("#ios2").show();

			    }

			    if(x=="red_template" || x=="altice_business_default"){

		        	$("#duotone").show();
		        	$("#backcolor1n2").hide();

		        }
		        else{
		        	$("#duotone").hide();
		        	$("#backcolor1n2").show();
		        }



	});

function change_back(){
                            var template_name = document.getElementById("template_name").value ;
                            if(template_name=="default_theme"){
                                document.getElementById("check_back").value = "0";
                                document.getElementById("check_color").value = "1";
                            }
}

</script>



<?php




$gt_reg_optioncode= getOptions('THEME_REG_TYPE',$sys_pack,'MVNO');

$pieces = explode(",", $gt_reg_optioncode);

if (in_array('SMS_PASSCODE', $pieces)) {
	$featuressql="SELECT `features` AS f FROM exp_mno  WHERE `mno_id`='$mno_id'";
	$featuresjson=$db->getValueAsf($featuressql);
	$features=json_decode($featuresjson,true);

	$piecesnew=array();
	foreach ($pieces as $value) {
	if ($value!='SMS_PASSCODE') {
		array_push($piecesnew, $value);
	}
	else{
		if (in_array('SMS_GATEWAY', $features)) {
		array_push($piecesnew, $value);
		}
	}
	}
	$pieces=$piecesnew;
}


$len = count($pieces);

$outstr="";

for($i=0;$i<$len;$i++){

	if($i==($len-1)){

		$outstr=$outstr."'".$pieces[$i]."'";

	}else{

		$outstr=$outstr."'".$pieces[$i]."',";
	}


}


?>
																<select id="reg_type" class="span5" name="reg_type" required="required" onchange="choice1(this);ck_topval();">





																	<?php







																		if($modify_mode == 1) {
                                                                            $key_query = "SELECT theme_name FROM exp_theme_manager WHERE theme_code = '$registration_type'";

                                                                            $query_results=mysql_query($key_query);

                                                                            while($row=mysql_fetch_array($query_results)){

                                                                                $theme_name = $row[theme_name];

                                                                            }
																		    echo "<option value = \"".$registration_type."\">".$theme_name."</option>";
																		}



																		if ($system_package!='N/A') {

																			$key_query = "SELECT theme_code, theme_name FROM exp_theme_manager WHERE theme_type = 'NEW' AND is_enable='1'

																			AND theme_code IN ($outstr)";

																		}else{

																			$key_query = "SELECT theme_code, theme_name FROM exp_theme_manager WHERE theme_type = 'NEW' AND is_enable='1'";


																		}









																		$query_results=mysql_query($key_query);

																		while($row=mysql_fetch_array($query_results)){

																		   $theme_id = $row[theme_code];

																			$theme_name = $row[theme_name];

                                      $registration_type;

                                      if($registration_type!=$theme_id || $modify_mode != 1){
																			echo '<option id="'.$theme_name.'" value="'.$theme_id.'">'.$theme_name.'</option>';
                                      }

																		}



																	?>



																</select>


                                                <img  id="loading_ajax1" src="img/loading_ajax.gif" style="display:none"></img>


															</div>
<!-- <p style="font-size: 90%;"><b>Note: If Passcode Authentication is selected, please validate your current passcode generation method or change it as desired. It is currently set to the following: <small class="a"><?php //echo $pass_type.' - '.$voucher_number; ?></small></b> -->
														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->


<!-- ////////////////////////////////////////////////////// -->


	<script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

	            <script type="text/javascript">
				$(document).ready(function() {

					$("#pre_id").fancybox({
						'transitionIn'	:	'elastic',
						'transitionOut'	:	'elastic',
						'speedIn'		:	600,
						'speedOut'		:	200,
						'overlayShow'	:	false,
				        'width'         :   "90%",
				        'height'        :   "100%",
				        afterShow: function () {
					        var customContent = "<button id='fancy_close' style='margin-top: 30px; display: none'></button>";
 							$('.fancybox-skin').append(customContent);

 							$('#fancy_close').click(function(event) {
								$.fancybox.close();

							});
					    }
					});




				});
			</script>

			<style>
				.fancybox-skin{
					text-align: right ;
				}
			</style>

<br>
<hr>
<br>

<div class="controls">
<h3 style="display: inline-block;">Illustrative rendering of the template </h3>
<div id="template_image" >

</div>

</div>



<br>
<hr>
<br>


<div id="imgupload">


													<!-- <hr> -->
													<!-- <div class="control-group">
                                                    <p class=""><b>Step 2.</b> <small class="a" >Note all sections are required with exception of background color, font color and horizontal line color.</small> Upload your company logo and a background image to give the Theme a familiar look & feel for your guests. You must click the "Save" icon to save the uploaded image.</p>
													</div> -->







										<div id="backimg" >

                                            <?php //if($edit_template_name=='res_cox_block_template'){ ?>
										<!-- <h4 id="logo_1_title" style="display: inline-block">Logo 1 or Logo 1 Alternative Text</h4> -->
                                            <?php //}else{ ?>
                                            <h4 id="logo_1_title" style="display: none">Logo or Logo Alternative Text</h4>
                                            <?php //} ?>

								<div id="divlogo1" class="control-group">
													<label class="control-label" id="up_logo_name1" for="radiobtns" style="display: none">Logo </label>



														<div class="controls uprel">

				<?php

				$back_or_logo=$package_functions->getOptions('LOGO_OR_BACK',$sys_pack,'MVNO');


				if($back_or_logo=='logo'){ ?>

													<div id="logo1_up">
					<?php //if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION) && file_exists($original_bg_Image_Folder.$th_background_image)){
						if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION) && $upload_img->is_exists($th_background_image,'bg') == 1){
						?>
													<!-- <img id="logo_hi_1" class="croppedImg" src="<?php //echo $original_bg_Image_Folder.$th_background_image; ?>" style="width: 193px;height: 71px;"> -->

													<img id="logo_hi_1" class="croppedImg" src="<?php echo $upload_img->get_image($th_background_image,'bg') ; ?>" style="width: 193px;height: 71px;">
					<?php }?>
													</div>

													<input type="hidden" name="image_1_name" id="image_1_name" value="<?php echo $th_background_image; ?>" />

													<input type="hidden" name="image_1_name_prev" id="image_1_name_prev" value="<?php echo $th_background_image; ?>" />

	<p style="font-size: 90%;"><b>Note: Upload your primary logo. Best aspect ratio is 8 Width x 3 Height and Max Size: 200Kb.</b>

	<!-- <img  src=" //$original_bg_Image_Folder.$th_background_image;  style='width:125px;height:100px; display:inline;'>  -->

		 <script>

		 	var img_id='';	
		 	var img_logo_id='';	

		function deleteImg(id){
			var id2 = id.split('_');
			
			if(id2[0].toLowerCase() == 'default'){
				id = '';
			}else{
				id = id;
			}
			
			$.ajax({
				type: 'POST',
				url: 'ajax/ajax_delete_img.php',
				data: 'img_id='+id
			});
		}

		var croppicContaineroutputMinimallogo1 = {
				uploadUrl:'plugins/img_upload/img_save_to_file_png.php?baseportal=<?php echo $base_portal_folder; ?>&imname=image_1_name&himg=logo_hi_1',
				cropUrl:'plugins/img_upload/img_crop_to_file_logo1.php?discode=<?php echo $user_distributor; ?>&baseportal=<?php echo $base_portal_folder; ?>',
				modal:true,
				doubleZoomControls:false,
			    rotateControls: false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ window.img_id = $('#image_1_name').val();  },
				onAfterImgUpload: function(){ $('.cropControlUpload').hide(); if($('.new_upload').length == 0) { $("div:not(#logo1_up) > .cropControlsUpload").append(" <p class='new_upload'>Please save Logo 1</p>"); $("div:not(#logo1_up) > .cropControlsUpload").addClass('warning_img'); } },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){  },
				onAfterImgCrop:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img');deleteImg(img_id);console.log('DeletedonAfterImgCrop') },
				onReset:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); },
				onError:function(errormessage){ $('.cropControlUpload').show(); $('.new_upload').remove(); $("d.cropControlsUpload").removeClass('warning_img'); }
		}
		var cropContaineroutput = new Croppic('logo1_up', croppicContaineroutputMinimallogo1);



	</script>


<?php }else{ ?>

<h3 style="display:  inline-block;">Upload background image</h3>
<img data-toggle="tooltip" title='Acceptable Image formats are: PNG, GIF, JPEG and JPG. Maximum size 1000KB. Recommended aspect ratio is 2 by 1.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;">

<small id="logo1_up_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;margin-left: 40px;"><p>This is a required section</p></small>
													<div id="logo1_up_bc" class="no_crop_parent" style="display: block;">

														<div class="slider_change"></div>

					<?php //if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION) && file_exists($original_bg_Image_Folder.$th_background_image)){
						if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION) && $upload_img->is_exists($th_background_image,'bg') == 1){
						?>
													<!-- <img id="logo_hi_3" class="croppedImg" src="<?php //echo $original_bg_Image_Folder.$th_background_image; ?>" style="max-width: 100%; height: 150px;"> -->

													<img id="logo_hi_3" class="croppedImg" src="<?php echo $upload_img->get_image($th_background_image,'bg') ; ?>" style="max-width: 100%; height: 150px;">
						<?php }?>

						<div class="cropControls cropControlsUpload"> </div>
 												<label class="no_crop_label">
 													<span>
														<input type="file" name="img" class="no_crop" onchange="UploadImg(this,'logo1_up_bc','image_1_name','theme_img_background');">
														</span>
														</label>
													</div>

													<?php //if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION) && file_exists($original_bg_Image_Folder.$th_background_image)){
														if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION) && $upload_img->is_exists($th_background_image,'bg') == 1){
															?>

						<input type="hidden" name="background_img_check" id="background_img_check" value="1" />
					<?php } else{ ?>
						<input type="hidden" name="background_img_check" id="background_img_check" value="0" />
					<?php } ?>
					

													<input type="hidden" name="image_1_name" id="image_1_name" value="<?php echo $th_background_image; ?>" />


													<input type="hidden" name="image_1_name_prev" id="image_1_name_prev" value="<?php echo $th_background_image; ?>" />

	<p style="font-size: 90%;"><b></b>

	<!-- <img  src=" //$original_bg_Image_Folder.$th_background_image;  style='width:125px;height:100px; display:inline;'>  -->

		 <script>

		var img_id='';	
		var img_logo_id='';	

		function deleteImg(id){
			var id2 = id.split('_');
			
			if(id2[0].toLowerCase() == 'default'){
				id = '';
			}else{
				id = id;
			}
			
			$.ajax({
				type: 'POST',
				url: 'ajax/ajax_delete_img.php',
				data: 'img_id='+id
			});
		}


		var croppicContaineroutputMinimallogo1 = {
				uploadUrl:'plugins/img_upload/img_save_to_file_png_bc.php?baseportal=<?php echo $base_portal_folder; ?>&imname=image_1_name&himg=logo_hi_3',
				cropUrl:'plugins/img_upload/img_crop_to_file_back1.php?discode=<?php echo $user_distributor; ?>&baseportal=<?php echo $base_portal_folder; ?>',
				modal:true,
				doubleZoomControls:false,
			    rotateControls: false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ window.img_id = $('#image_1_name').val(); },
				onAfterImgUpload: function(){ $('.cropControlUpload').hide(); if($('.new_upload').length == 0) { $("div:not(#logo1_up_bc) > .cropControlsUpload").append(" <p class='new_upload'>Please save images</p>"); $("div:not(#logo1_up_bc) > .cropControlsUpload").addClass('warning_img'); }  },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCroplogo1_up_bc') },
				onAfterImgCrop:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); $('#background_img_check').val('1'); $('#logo1_up_bc').prepend('<div class="slider_change"></div>'); setColor($('.slider').slider("option", "value"));deleteImg(img_id);console.log('DeletedonAfterImgCrop') },
				onReset:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); $('#background_img_check').val('0'); },
				onError:function(errormessage){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); $('#background_img_check').val('0'); }
		}
		var cropContaineroutput = new Croppic('logo1_up_bc2', croppicContaineroutputMinimallogo1);




	</script>


<?php } 



                                                        if(strlen($th_background_image)>0 && $_GET['modify'] == 1 && $edit_template_name=="default_theme"){

                                                             if(preg_match('/^#[a-f0-9]{6}$/i', $th_background_image)) //hex color is valid
                                                                {
                                                                    $bg_dft_img1 = $th_background_image ;
																}
															}
                                                                 ?>
                                                                 <!-- <div id="background_img_check_rem">
                                                                     <input type="checkbox" id="background_img_check" name="background_img_check">
                                                                     <lable>Use background color</lable>
                                                                 </div> -->




														</div>
														</div>

														<!-- /controls -->

<?php

$alernative_text=(array)json_decode($package_functions->getOptions('THEME_ALTERNATIVE_TEXT',$sys_pack,'MVNO'));
//print_r($alernative_text);

if($alernative_text['Background']=='1'){

?>

													<div class="control-group" id="logo_1_txt_div">

														<label class="control-label" id="logo_1_txt" for="altext">Logo Alternative Text</label>

														<div class="controls">
															<div class="input-prepend input-append">

															<input type="text" class="span4" id="logo_1_text" maxlength="20" name="logo_1_text" placeholder="Logo text"

															<?php if($modify_mode == 1 && !pathinfo($th_background_image, PATHINFO_EXTENSION) && $back_or_logo=='logo') {echo "value =\"".$th_background_image."\" ";} ?>

															 >


															 <a  style="display: inline-block"><input type="checkbox" id="logo_txt1_enable"/></a>
															 <small id="logo_1_text_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px; */"><p>This is a required field</p></small>

                                                                <p><b>Note: Check the box and add in your business name instead of a logo. It can have up to 20 characters with spaces.</b></p>

																<script type="text/javascript">

                                                                    $("#logo_1_text").keypress(function(event){

                                                                        var ew = event.which;

                                                                        if(ew == 32 || ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35 ||ew == 45 ||ew == 95)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57)
                                                                            return true;
                                                                        if(65 <= ew && ew <= 90)
                                                                            return true;
                                                                        if(97 <= ew && ew <= 122)
                                                                            return true;
                                                                        return false;
                                                                    });

																	$('#logo_1_text').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                </script>

															</div>
														</div>
														<!-- /controls -->
													</div>

													<!-- /control-group -->
									    <?php
                          }
                          ?>

									<?php
									//if($modify_mode == 1 && (!pathinfo($th_background_image, PATHINFO_EXTENSION) || !file_exists($original_bg_Image_Folder.$th_background_image))){

									if($modify_mode == 1 && (!pathinfo($th_background_image, PATHINFO_EXTENSION) || $upload_img->is_exists($th_background_image,'bg') != 1)){
									?>
                                    <script type="text/javascript">

                                            $(document).ready(function() {

                                            	document.getElementById("logo_txt1_enable").checked = true;

								            	$('#logo_1_text').attr('disabled', false);
								            	<?php if($back_or_logo=='logo'){ ?>

								            	document.getElementById("logo_1_text").required = true;

												<?php } ?>

								            	//$('#divlogo1').hide();
								            	//document.getElementById("image_1_name").required = false;

                                            });
                                    </script>

									<?php
									}else{
									?>

                                    <script type="text/javascript">

                                            $(document).ready(function() {

                                            	document.getElementById("logo_txt1_enable").checked = false;


								            	document.getElementById("logo_1_text").required = false;
								            	$('#logo_1_text').attr('disabled', true);
								            	document.getElementById("logo_1_text").value = "";


								            	$('#divlogo1').show();
								            	document.getElementById("image_1_name").required = true;

                                            });
                                    </script>


									<?php }?>

									 <script type="text/javascript">
								    $(function () {

										if($('#logo_txt2_enable').is(":checked")){
											$('#divlogo2').hide();
										}
								        $("#logo_txt1_enable").click(function () {

											$("#logo1_up img").remove();

								            if ($(this).is(":checked")) {

								            	$('#logo_1_text').attr('disabled', false);
								            	document.getElementById("logo_1_text").required = true;
								            	$('#divlogo1').hide();
								            	document.getElementById("image_1_name").required = false;
								            	document.getElementById("image_1_name").value = "";


								            } else {
								            	document.getElementById("logo_1_text").required = false;
								            	$('#logo_1_text').attr('disabled', true);
								            	document.getElementById("logo_1_text").value = "";
								            	$('#divlogo1').show();
								            	document.getElementById("image_1_name").required = true;
								            }

											check_logo_valid('logo_1_text','logo_1_text_validate');

								        });
								    });
								</script>


									<!-- ///////////////// -->




												</div>



                                                    <div id="backcolor" class="control-group">



                                                        <label class="control-label" for="radiobtns">Background Color</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">




                                                                	<div id="back_color_div" class="input-group colorpicker-component"><input id="back_color" name="back_color" type="text" value="primary" ><span class="input-group-addon"><i></i></span></div>

                                                                	<?php

                                                                		if($bg_dft_img1!=""){

                                                                		}else{
                                                                			$bg_dft_img1 = '#ffffff';
                                                                		}

                                                                	 ?>

                                                                	<!-- <input style="width:30px !important; height:30px;" class="span5 jscolor {hash:true}" id="back_color" name="back_color" type="color" value="<?php //if($bg_dft_img1!=""){echo $bg_dft_img1;}else{echo '#ffffff';} ?>" required> -->
                                                                <lable>( ** Background color applies only if no background image is uploaded)</lable>
<input type="hidden" id="back_color1">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="control-group" id="duotone">

                                                        <!-- <label class="control-label" for="radiobtns">Duotone Overlay of background image</label> -->

                                                        <div class="controls">
                                                        	<h3 style="display:  inline-block;">Duotone Overlay of background <span> image<img data-toggle="tooltip" title='Select the overlay color and use the slider to set the transparency.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></span></h3>


                                                            <div class="" style="display: block;">

                                                            	<?php   if($modify_mode==1){
                                                            				$duotone_color = $duotone_color;
                                                            				$duotone_color_bg_slider = $duotone_color_bg_slider;
                                                            				$duotone_color_bg = $duotone_color_bg;

                                                            				if(strlen($duotone_color) < 1){
                                                            					$duotone_color = $duotone_bg_rgba1;
                                                            				}

                                                            				if(strlen($duotone_color_bg_slider) < 1){
                                                            					$duotone_color_bg_slider = '80';
                                                            				}

				                                                    	}else{
				                                                    		$duotone_color = "#0cbbaa";
				                                                    		$duotone_color_bg_slider = "50";
				                                                    		$duotone_color_bg = "";
				                                                    	} ?>

                                                            <div id="duotone_color_div" class="input-group colorpicker-component"><input id="duotone_color" name="duotone_color" type="text" value="<?php echo $duotone_color; ?>" ><span class="input-group-addon"><i></i></span>

															<small id="duotone_color_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;margin-top: 0px;"><p>Invalid color code</p></small>


														</div>


                                                             <div style="margin-top: 20px;max-width: 300px" class="slider"></div>

                                                             <script type="text/javascript">

                                                             	function setColor(val){

                                                             		//val = (parseInt(val))*15/10;
                                                             		var val2 ;

                                                             		val2 = 0.3;

                                                             		$('#duotone_color_bg').val("background: linear-gradient(to bottom, "+ $('#duotone_color').val() +" "+val+"%, rgba(0, 0, 0, "+val2+") 100%);background: -webkit-linear-gradient(top, "+ $('#duotone_color').val() +" "+val+"%, rgba(0, 0, 0, "+val2+") 100%);background: -o-linear-gradient(top, "+ $('#duotone_color').val() +", rgba(0, 0, 0, "+val2+") 100%)");

                                                             		if ($('#duetone_enable').is(':checked')){
                                                             			$(".slider_change").css('background', 'none');
                                                             		}else{

                                                             		$(".slider_change").css({ "background": "-webkit-linear-gradient(top, "+ $('#duotone_color').val() +" "+val+"%, rgba(0, 0, 0, "+val2+") 100%)", "background": "-o-linear-gradient(top, "+ $('#duotone_color').val() +", rgba(0, 0, 0, "+val2+") 100%)", "background": "linear-gradient(to bottom, "+ $('#duotone_color').val() +" "+val+"%, rgba(0, 0, 0, "+val2+") 100%)"});

                                                             	}

                                                             		$("#duotone_color_bg_slider").val(val);


                                                             	}
                                                             	$(document).ready(function() {

                                                             		setColor('<?php echo $duotone_color_bg_slider; ?>');

                                                             		$('#duotone_color_div').colorpicker({
																			color: '<?php echo $duotone_color; ?>',
																			useAlpha: false,
																			align : 'left'
																        }).on('changeColor', function(e) {

																        	var val = $('.slider').slider("option", "value");
																        	setColor(val);
																        });

                                                             	$( ".slider" ).slider({
                                                             		value: parseInt("<?php echo $duotone_color_bg_slider; ?>"),
																  change: function( event, ui ) {

																  	setColor(ui.value);
																  }
																});

                                                             	});

                                                             	function due_enable(){


																	var val = $('.slider').slider("option", "value");
																    setColor(val);
																}
																
                                                             </script>

                                                             <style type="text/css">
                                                             	.ui-slider.ui-widget-content {
																        border: 1px solid #dddddd !important;
																}
																.slider_change{
																	width: 100%;
																    height: 100%;
																    position: absolute;
																}
                                                             </style>

                                                            </div>

                                                            <?php 

                                                            	if($duetone_enable=='OFF'){
                                                            		$duetone_enable = 'checked';
                                                            	}else{
                                                            		$duetone_enable = '';
                                                            	}

                                                             ?>

                                                        <input onclick="due_enable();" name="duetone_enable" id="duetone_enable" <?php echo $duetone_enable; ?> type="checkbox"> No Overlay

                                                        </div>
                                                </div>

                                                <input type="hidden" name="duotone_color_bg" id="duotone_color_bg" value="<?php echo $duotone_color_bg; ?>">
															<input type="hidden" name="duotone_color_bg_slider" id="duotone_color_bg_slider" value="<?php echo $duotone_color_bg_slider; ?>">

                                                <!-- <div class="control-group" id="duotone2">

                                                        <label class="control-label" for="radiobtns">Duotone Overlay of the form</label>

                                                        <div class="controls">

                                                            <div class="input-prepend input-append">

                                                             <div id="gradX2" >

                                                             </div>



                                                            </div>
                                                        </div>
                                                </div> -->

                                                <style>
                                                	#gradx_show_code, #gradx_show_presets, #gradx_add_slider, .gradx_slectboxes, .gradx .mce-tinymce{
                                                		display: none !important;
                                                	}
                                                </style>





											<div>

<div id="divlogo2">


<div id="logoimg" class="control-group">

<h4 id="logo_2_title" style="display: none;">Logo 2 or Logo 2 Alternative Text</h4>

<br>
<br>
															<label class="control-label" id="up_logo_name2" for="radiobtns" style="display: none;">Logo 2</label>



															<div class="controls uprel">

																<h3 style="display: inline-block;">Upload logo image<img data-toggle="tooltip" title="Acceptable Image formats are: PNG, GIF, JPEG and JPG. Maximum Size 200KB. Recommended aspect ratio is 8 by 3." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display: inline-block;"></h3>


                                                        	<small id="logo2_up_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style=" display: none; margin-left: 40px; "><p>This is a required section</p></small>

													<!-- <div id="logo2_up" style="display: block;">
					<?php //if($modify_mode==1 && pathinfo($th_logo_image, PATHINFO_EXTENSION)){?>
													<img id="logo_hi_2" class="croppedImg" src="<?php //echo $original_logo_Image_Folder.$th_logo_image; ?>" style="width: 193px;height: 71px;">
					<?php //} ?>
													</div> -->

													<div id="logo2_up" class="no_crop_parent" style="display: block;">

														<div class="cropControls cropControlsUpload"> </div>

														<?php if($modify_mode==1 && pathinfo($th_logo_image, PATHINFO_EXTENSION)){?>
													<!-- <img id="logo_hi_2" class="croppedImg" src="<?php //echo $original_logo_Image_Folder.$th_logo_image; ?>"> -->

													<img id="logo_hi_2" class="croppedImg" src="<?php echo $upload_img->get_image($th_logo_image, 'logo') ; ?>">
					<?php } ?>
 													<label class="no_crop_label">
 													<span>
														<input type="file" name="img" class="no_crop" onchange="UploadImg(this,'logo2_up','image_2_name','theme_img_logo');"> 
													</span>
												</label>
												</div>

													<input type="hidden" name="image_2_name" id="image_2_name" value="<?php echo $th_logo_image; ?>" />

													<input type="hidden" name="image_2_name_prev" id="image_2_name_prev" value="<?php echo $th_logo_image; ?>" />

	<p style="font-size: 90%;"><b id="logo2_img_note" style="display: none;"></b></p>
		<style type="text/css">
			.no_crop {
			    color: transparent;
			    text-indent: -9999px;
			    outline: 0 !important;
			    position: absolute;
			    top: 0px;
			    right: 0px;
			    width: 30px !important;
			}

			.no_crop_label{
				width: 30px;
			    height: 30px;
			    position: absolute;
			    top: 0px;
			    right: 0px;
			    content: ' ';
			    background-image: url(plugins/img_upload/assets/img/cropperIcons.png);
			    background-position: -150px 0px;
			    background-color: rgba(0,0,0,0.35);
			    cursor: pointer;
			}

			.no_crop_label:hover{
				background-color: rgb(0,0,0);
			}
			.no_crop_parent{
				text-align: center;
				height: auto !important;
    			min-height: 150px;
			}
			.no_crop_parent img.croppedImg{
				max-width: 100%;
			}
			#logo2_up{
				min-height: 71px;
			}
		</style>
		 <script>

		 	function UploadImg(that,parent,output,type) {

		 		var img_id = $('#'+output).val();
		 		var id2 = img_id.split('_');
			
				if(id2[0].toLowerCase() == 'default'){
					img_id = '';
				}else{
					img_id = img_id;
				}
				console.log(img_id);
				$.ajax({
					type: 'POST',
					url: 'ajax/ajax_delete_img.php',
					data: 'img_id='+img_id
				});

		 		var name = that.files[0].name;

		 		if(name.length==0){
		 			return false;
		 		}

		 		var form_data = new FormData();
		 		form_data.append("file", that.files[0]);
            	form_data.append("type", type);
            	form_data.append("discode", '<?php echo $user_distributor; ?>');

            	$.ajax({
					    url:"ajax/ajaxthemeimage.php",
					    method:"POST",
					    data: form_data,
					    contentType: false,
					    cache: false,
					    processData: false,
					    beforeSend:function(){

					    $('#'+parent).append('<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>');
					     
					    },    
					    success:function(data)
					    {
					    	$('#'+parent+' .loader.bubblingG').remove();
					    	var respo = JSON.parse(data);
					     	if(respo.status_code=='200'){
					     		$('#'+parent+' img.croppedImg').remove();
					     		$('#'+parent).append('<img class="croppedImg" src="'+respo.response.srcdata+'">');
					     		$('#'+output).val(respo.response.img_name);

					     		if(type=='theme_img_background'){
					     			$('#background_img_check').val('1');
					     		}

					     	}else{
					     		alert(respo.response);
					     	}
					    }
				});
		 	}


		var croppicContaineroutputMinimallogo2 = {
				uploadUrl:'plugins/img_upload/img_save_to_file_png.php?baseportal=<?php echo $base_portal_folder; ?>&imname=image_2_name&himg=logo_hi_2',
				cropUrl:'plugins/img_upload/img_crop_to_file_logo2.php?discode=<?php echo $user_distributor; ?>&baseportal=<?php echo $base_portal_folder; ?>',
				modal:true,
				doubleZoomControls:false,
			    rotateControls: false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ window.img_logo_id = $('#image_2_name').val(); },
				onAfterImgUpload: function(){ $('.cropControlUpload').hide(); if($('.new_upload').length == 0) { $("div:not(#logo2_up) > .cropControlsUpload").append(" <p class='new_upload'>Please save Logo 2</p>"); $("div:not(#logo2_up) > .cropControlsUpload").addClass('warning_img'); }},
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCroplogo2_up') },
				onAfterImgCrop:function(){$('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img');deleteImg(img_logo_id);console.log('DeletedonAfterImgCrop') },
				onReset:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); },
				onError:function(errormessage){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); }
		}
		var cropContaineroutput = new Croppic('logo2_upe', croppicContaineroutputMinimallogo2);




	</script>












															</div>


</div>															<!-- /controls -->

</div>


								<!-- ///////////////// -->
<?php
if($alernative_text['Logo']=='1'){
?>
													<div id="alttxt2" class="control-group">

														<label class="control-label" for="altext" style="display: none;">Logo 2 Alternative Text</label>


														<div class="controls">

																<h3 style="display: inline-block;">Logo Alternative Text  <img data-toggle="tooltip" title="Check the box and add in your message instead of a logo. You can use up to 20 characters including space." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display: inline-block;"></h3>


															<div class="input-prepend input-append">

															<input type="text" class="span4" id="logo_2_text" maxlength="20" name="logo_2_text" placeholder="Logo text"

															<?php if($modify_mode == 1 && (!pathinfo($th_logo_image, PATHINFO_EXTENSION) || $upload_img->is_exists($th_logo_image,'logo') != 1)){  echo "value =\"".$th_logo_image."\" "; } ?>

															 >



															 <a  style="display: inline-block"><input type="checkbox" id="logo_txt2_enable"/></a>
															 <small id="logo_2_text_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px; */"><p>This is a required field</p></small>


																<script type="text/javascript">

                                                                    $("#logo_2_text").keypress(function(event){

                                                                        var ew = event.which;

                                                                        if(ew == 32 || ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35 ||ew == 45 ||ew == 95)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57)
                                                                            return true;
                                                                        if(65 <= ew && ew <= 90)
                                                                            return true;
                                                                        if(97 <= ew && ew <= 122)
                                                                            return true;
                                                                        return false;
                                                                    });

																	$('#logo_2_text').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                </script>

															</div>
														</div>
														<!-- /controls -->
													</div>

													<!-- /control-group -->

										<?php } ?>

																	<?php
									//if($modify_mode == 1 && (!pathinfo($th_logo_image, PATHINFO_EXTENSION) || !file_exists($original_logo_Image_Folder.$th_logo_image))){

									if($modify_mode == 1 && (!pathinfo($th_logo_image, PATHINFO_EXTENSION) || $upload_img->is_exists($th_logo_image,'logo') != 1)){


									?>
                                    <script type="text/javascript">

                                            $(document).ready(function() {

                                            	document.getElementById("logo_txt2_enable").checked = true;

								            	$('#logo_2_text').attr('disabled', false);

												<?php if($back_or_logo=='logo'){ ?>

								            	document.getElementById("logo_1_text").required = true;

												<?php } ?>

								            	document.getElementById("image_2_name").required = false;

                                            });
                                    </script>

									<?php
									}else{
									?>

                                    <script type="text/javascript">

                                            $(document).ready(function() {

                                            	document.getElementById("logo_txt2_enable").checked = false;


								            	document.getElementById("logo_2_text").required = false;
								            	$('#logo_2_text').attr('disabled', true);
								            	document.getElementById("logo_2_text").value = "";


								            	document.getElementById("image_2_name").required = true;

                                            });
                                    </script>


									<?php }?>





									<!-- ///////////////// -->

</div>


<hr>

<br>


                                                    <div id="backcolor1n2" class="control-group">

                                                        <label class="control-label" for="radiobtns" id="bgcolor_txt">Banner & Greeting Background Color</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">

															<!-- <input style="width:30px !important; height:30px;" class="span5 jscolor {hash:true}" id="bcolor1" name="bcolor1" type="color" value="<?php //echo $edit_bg_color1; ?>" > -->
															<div id="bcolor1_div" class="input-group colorpicker-component"><input id="bcolor1" name="bcolor1" type="hidden" value="primary" ><span class="input-group-addon"><i></i></span></div>


                                                        </div>
                                                    </div>
                                                </div>


												<?php if(!in_array("welcomepage", $hide_divs_gene_arr)){ ?>
<div id="welcomepage" class="control-group">

<div id="step5">

													<hr>

													<div class="controls">
                                                    <p class="">After a guest has registered the first time they are redirected to a Welcome Screen with a Button to connect to the Internet. When a guests returns after their sessions has expired, they get redirected back to the captive portal, and the Welcome Back screen. </p>
													</div>

</div>


<label class="control-label" for="radiobtns" id="banner-label" style="display: none;">Banner Text</label>
													<div id="wtxt" class="controls">

															<h3 style="display: inline-block;">Banner text<img data-toggle="tooltip" title="You can use up to 30 characters including spaces" src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display: inline-block;"></h3>

<?php if(!in_array("welcome_text", $hide_divs_gene_arr)){ ?>
														<div id="txt_hide">


															<div class="input-prepend input-append">
															<p id="banner-def-txt" style="margin-right: 10px; display: inline-block">Courtesy Service Provided by</p>
															<input type="text" id="welcome" onkeyup="valid_check(this.value,'welcome_validate')" maxlength="30" name="welcome" class="span4 banner_txt_val" placeholder="Enter customer name text" required onkeyup="valid_check(this.value,'theme_name1_validate')" value="<?php echo $welcome_txt; ?>" autocomplete="off" >


															<small id="welcome_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>
															<div>
																<p id="banner-under-txt" style="display: none;"><b>You can add in your business name to the end of the banner text. It can have up to 30 characters with spaces.</b></p></div>
															</div>
															<div>
														</div>

														</div>


                                                        <?php } ?>


<div id="wback">
															<div><sub>Default Welcome Back text using recommended Font Size 14, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

															<textarea width="500px" id="welcome_back" name="welcome_back" class="jqte-test textarea-tiny"><?php echo $welcome_back_txt; ?></textarea>

															</div>


															<div><sub>Default Button text using recommended Font Size 8, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

															<textarea width="500px" id="connectwifi" name="connectwifi" class="jqte-test textarea-tiny"><?php echo $connect_btn; ?></textarea>

															</div>
                                                        </div>







													</div>

													<!-- /control-group -->







</div>
<?php } ?>

												<div id="fontcolor" class="control-group">

                                                        <label class="control-label" style="display: none;" for="radiobtns" id="fontcolor_txt">Banner & Greeting Font Color</label>



                                                        <div class="controls">

                                                        	<h3>Banner text color </h3>

                                                            <div class="input-prepend input-append">

															<!-- <input style="width:30px !important; height:30px;" class="span5 jscolor {hash:true}" id="fontcolor1" name="fontcolor1" type="color" value="<?php //echo $edit_fontcolor1; ?>"> -->
															<div id="fontcolor1_div" class="input-group colorpicker-component"><input id="fontcolor1" name="fontcolor1" type="text" value="primary" ><span class="input-group-addon"><i></i></span>

															<small id="fontcolor1_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;margin-top: 0px;"><p>Invalid color code</p></small>
														</div>





                                                        </div>
                                                    </div>
												</div>


												<div id="hrcolor" class="control-group">

                                                        <label class="control-label" for="radiobtns" id="hrcolor_txt">Horizontal Bar Line</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">


															<!-- <input style="width:30px !important; height:30px;" class="span5 jscolor {hash:true}" id="hrcolor" name="hrcolor" type="color" value="<?php //echo $edit_hr_color; ?>" > -->

															<div id="hrcolor_div" class="input-group colorpicker-component"><input id="hrcolor" name="hrcolor" type="hidden" value="primary" ><span class="input-group-addon"><i></i></span></div>

															  <!--<td width="25%" class="span2">Font Color 2</td> -->



                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="sms_input">
                                                	<br>
<hr>
<br>



                                                    <div class="control-group" id="sms_first">
                                                    <p class=""><b>Step 4.</b> On the main registration screen you can set the Social Media Registration Information text and the Social Media Button text. In addition you can set the Manual Registration Information text, select which Demographic Data to collect, and set the SMS Registration Button text.</p>
                                                    </div>




														<!-- ************************ text area **************************** -->

													<div class="control-group" id="recieved_number">





														<div class="controls">

															<label for="radiobtns">Mobile Number</label>

														
                                                            	<input onclick="" data-role="mobilefiel" data-role1="mobile_number" name="m_mobiles" id="m_mobiles" type="checkbox" disabled checked>
                                                            		<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#mobilefiel").css('display', 'inline-block');

																						});
																		</script>

																<div id="mobilefiel">
                                                            
															<input class="span5" id="mobile_numbers" name="mobile_numbers" type="text" value="<?php echo $edit_mobile_number_fields; ?>" >
													</div>
                                                          
                                                            	

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->

													<div class="control-group" id="sms_first_names">





														<div class="controls">

															<label for="radiobtns">First Name</label>

														<?php

																/*$r = $db->getManualReg('first_name', $mno_id, $user_distributor);*/
																$r = $manual_login_fields['first_name'];

																if ($r == 1) {

																	echo '<input onclick="sms_first()" data-role="fnamefields" data-role1="first_name" name="m_first_names" id="m_first_names" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#fnamefields").css('display', 'inline-block');

																						});
																		</script>

																		<div id="fnamefields" >


															<input type="text" id="first_names" name="first_names" class="span5" value="<?php echo $first_name_text; ?>">
														</div>

																	<?php

																} else {

																	echo '<input onclick="sms_first()" name="m_first_names" data-role="fnamefields" data-role1="first_name" id="m_first_names" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																			<script type="text/javascript">

																		$(document).ready(function() {

																			$("#fnamefields").hide();

																		});
																	</script>

																	<div id="fnamefields" >


															<input type="text" id="first_names" name="first_names" class="span5" value="<?php echo $first_name_text; ?>">
														</div>

																<?php
																}

															?>

													<script type="text/javascript">

																		function sms_first()
																	{

																		if(document.getElementById("m_first_names").checked == true){
																			$("#fnamefields").css('display', 'inline-block');
																		}
																		else{
																			$("#fnamefields").css('display', 'none');
																		}
																	}

																		</script>
                                                          
                                                            	

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->

													<div class="control-group" id="sms_last_names">





														<div class="controls">

															<label for="radiobtns">Last Name</label>

														<?php

																/*$r = $db->getManualReg('last_name', $mno_id, $user_distributor);*/
																$r = $manual_login_fields['last_name'];

																if ($r == 1) {

																	echo '<input onclick="sms_last()" data-role="lnamefields" data-role1="last_name" name="m_last_names" id="m_last_names" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#lnamefields").css('display', 'inline-block');

																						});
																		</script>

																		<div id="lnamefields" >


															<input type="text" id="last_names" name="last_names" class="span5" value="<?php echo $last_name_text; ?>">
														</div>

																	<?php

																} else {

																	echo '<input onclick="sms_last()" name="m_last_names" data-role="lnamefields" data-role1="last_name" id="m_last_names" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																			<script type="text/javascript">

																		$(document).ready(function() {

																			$("#lnamefields").hide();

																		});
																	</script>

																	<div id="lnamefields" >


															<input type="text" id="last_names" name="last_names" class="span5" value="<?php echo $last_name_text; ?>">
														</div>

																<?php
																}

															?>

													<script type="text/javascript">

																		function sms_last()
																	{

																		if(document.getElementById("m_last_names").checked == true){
																			$("#lnamefields").css('display', 'inline-block');
																		}
																		else{
																			$("#lnamefields").css('display', 'none');
																		}
																	}

																		</script>
                                                          
                                                            	

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->

													<div class="control-group" id="sms_email">





														<div class="controls">

															<label for="radiobtns">Email</label>

														<?php 
														$r = $manual_login_fields['email'];

																if ($r == 1) {

																	echo '<input onclick="sms_email()" data-role="emailfields" data-role1="email" name="m_emails" id="m_emails" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#emailfields").css('display', 'inline-block');

																						});
																		</script>

																		<div id="emailfields">
																			<input class="span5" id="emails" name="emails" type="text" value="<?php echo $email_field; ?>" required>
																		</div>
																	<?php
																} else {

																	echo '<input onclick="sms_email()" data-role1="email" data-role="emailfields" name="m_emails" id="m_emails" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#emailfields").hide();

																						});
																		</script>

																		<div id="emailfields">
																			<input class="span5" id="emails" name="emails" type="text" value="<?php echo $email_field; ?>" required>
																		</div>
																	<?php
																} ?>

													<script type="text/javascript">

																		function sms_email()
																	{

																		if(document.getElementById("m_emails").checked == true){

																			$("#emailfields").css('display', 'inline-block');
																		}
																		else{
																			$("#emailfields").css('display', 'none');
																		}
																	}

																		</script>
                                                          
                                                            	

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



												</div>




                                                	<div id="manual">

<br>
<hr>
<br>
<!-- files for toggle button -->

   <!--  <script type="text/javascript" src="js/on-off-switch.js"></script>
   <script type="text/javascript" src="js/on-off-switch-onload.js"></script>
   <link rel="stylesheet" type="text/css" href="css/on-off-switch.css"/> -->

<script type="text/javascript">

function remove_img(file_id,img_dir,template_name){


	$.get("ajax/ajaximage_remove.php", {img_dir: img_dir,template_name: template_name,file_id: file_id},
	function (data) {
		console.log(data);
		if(data='SUCCESS'){
			$("li[data-li-value='" + file_id + "']").remove();
		}
	});
}

function manual_toggle(a)
{

	var n=$(a).data( "role" );
	var n1=$(a).data( "role1" );

    if($(a).is(":checked")){
        $("#"+n).css('display', 'inline-block');
        $("#"+n1).prop('required', true);
    }else{
        $("#"+n).hide();
        $("#"+n1).removeAttr('required');
    }
}



function manual_toggle_gender(a)
{



    if($(a).is(":checked")) {
    	$("#m_male").css('display', 'inline-block');
		$("#m_female").css('display', 'inline-block');
		$("#genderfld").css('display', 'inline-block');
		$("#genderfld").prop('required', true);
		$("#m_female").prop('required', true);
		$("#m_male").prop('required', true);

    }else{

    	$("#m_male").hide();
		$("#m_female").hide();
		$("#genderfld").hide();
		$("#genderfld").removeAttr('required');
		$("#m_female").removeAttr('required');
		$("#m_male").removeAttr('required');
		}
    }
</script>

 													<h4 id="mnlogin" style="color:#3ACC53;display: none;">Manual Login</h4>


													<!-- //////////// -->

													<div class="control-group">

														<div class="controls">
															<h3 style="display: inline-block;">Select manual registration <span> fields<img data-toggle="tooltip" title='Collecting demographic data from your visitors will give you additional insights and will allow you to create targeted campaigns based on those demographics.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" ><span></h3>
														</div>
													</div>


													<div class="control-group" id="m_first_named">





														<div class="controls">

															<label for="radiobtns">First Name</label>

															<div class="">

															<?php

																/*$r = $db->getManualReg('first_name', $mno_id, $user_distributor);*/
																$r = $manual_login_fields['first_name'];

																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role="fnamefield" data-role1="first_name" name="m_first_name" id="m_first_name" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#fnamefield").css('display', 'inline-block');

																						});
																		</script>

																		<div id="fnamefield" >


															<input type="text" id="first_name" name="first_name" class="span5" value="<?php echo $first_name_text; ?>">
														</div>

																	<?php

																} else {

																	echo '<input onclick="manual_toggle(this)" name="m_first_name" data-role="fnamefield" data-role1="first_name" id="m_first_name" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																			<script type="text/javascript">

																		$(document).ready(function() {

																			$("#fnamefield").hide();

																		});
																	</script>

																	<div id="fnamefield" >


															<input type="text" id="first_name" name="first_name" class="span5" value="<?php echo $first_name_text; ?>">
														</div>

																<?php
																}

															?>

															<?php if(($manual_fields[0]['first_name'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_first_named").hide();
																			$("#fnamefield").hide();

																		});
																	</script>

															<?php } ?>

<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_first_name',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#fnamefield").css('display', 'inline-block');
															                }else{

															                	$("#fnamefield").hide();}
															        }
															    });
															</script>

<?php }?>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->




													<div class="control-group" id="m_last_named">





														<div class="controls">

															<label for="radiobtns">Last Name</label>

															<div class="">

															<?php

																//$r = $db->getManualReg('last_name', $mno_id, $user_distributor);
                                                                $r = $manual_login_fields['last_name'];

																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role="lnamefield" name="m_last_name" data-role1="last_name" id="m_last_name" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																	<script type="text/javascript">

																	$(document).ready(function() {

																	  $("#lnamefield").css('display', 'inline-block');

																		});
																		</script>

																		<div id="lnamefield">

																			<input type="text" id="last_name" name="last_name" class="span5" value="<?php echo $last_name_text; ?>">

																		</div>

																	<?php


																} else {

																	echo '<input onclick="manual_toggle(this)" data-role="lnamefield" name="m_last_name" data-role1="last_name" id="m_last_name" type="checkbox" >';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																	$(document).ready(function() {

																	$("#lnamefield").hide();

																	});
																	</script>

																	<div id="lnamefield">

																			<input type="text" id="last_name" name="last_name" class="span5" value="<?php echo $last_name_text; ?>">

																		</div>

																	<?php


																}

															?>

															<?php if(($manual_fields[0]['last_name'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_last_named").hide();
																			$("#lnamefield").hide();

																		});
																	</script>

															<?php } ?>

<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_last_name',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#lnamefield").css('display', 'inline-block');
															                }else{

															                	$("#lnamefield").hide();}
															        }
															    });
															</script>

<?php } ?>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->

													<div class="control-group" id="m_emaild">




														<div class="controls">

														<label for="radiobtns">Email</label>
															<div class="">

															<?php

																//$r = $db->getManualReg('email', $mno_id, $user_distributor);
                                                            $r = $manual_login_fields['email'];

																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role="emailfield" data-role1="email" name="m_email" id="m_email" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#emailfield").css('display', 'inline-block');

																						});
																		</script>

																		<div id="emailfield">
																			<input class="span5" id="email" name="email" type="text" value="<?php echo $email_field; ?>" required>
																		</div>
																	<?php
																} else {

																	echo '<input onclick="manual_toggle(this)" data-role1="email" data-role="emailfield" name="m_email" id="m_email" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#emailfield").hide();

																						});
																		</script>

																		<div id="emailfield">
																			<input class="span5" id="email" name="email" type="text" value="<?php echo $email_field; ?>" required>
																		</div>
																	<?php
																}

															?>

															<?php if(($manual_fields[0]['email'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_emaild").hide();
																			$("#emailfield").hide();

																		});
																	</script>

															<?php } ?>

<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_email',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#emailfield").css('display', 'inline-block');
															                }else{

															                	$("#emailfield").hide();}
															        }
															    });
															</script>
<?php } ?>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



													<!-- /control-group -->

													<div class="control-group" id="m_mobiled">




														<div class="controls">

														<label for="radiobtns">Mobile Number</label>
															<div class="">

															<?php
															$sms_auth=$pack_func->getSectionType('SMS_PROFILE',$system_package);
																//$r = $db->getManualReg('mobile_number', $mno_id, $user_distributor);
                                                            $r = $manual_login_fields['mobile_number'];
                                                            if ($sms_auth=='Yes2') {
                                                            	echo '<input onclick="manual_toggle(this)" data-role="mobilefield" data-role1="mobile_number" name="m_mobile" id="m_mobile" type="checkbox" checked disabled>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";
																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#mobilefield").css('display', 'inline-block');

																						});
																		</script>
																	
																		<div id="mobilefield">
                                                            
															<input class="span5" id="mobile_number" name="mobile_number" type="text" value="<?php echo $edit_mobile_number_fields; ?>">
													</div>
                                                           <?php 
                                                            }
                                                            else{
																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role="mobilefield" data-role1="mobile_number" name="m_mobile" id="m_mobile" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#mobilefield").css('display', 'inline-block');

																						});
																		</script>
																		<div id="mobilefield">
                                                            
															<input class="span5" id="mobile_number" name="mobile_number" type="text" value="<?php echo $edit_mobile_number_fields; ?>">
													</div>
																	<?php
																} else {

																	echo '<input onclick="manual_toggle(this)" data-role1="mobile_number" data-role="mobilefield" name="m_mobile" id="m_mobile" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#mobilefield").hide();

																						});
																		</script>
																		<div id="mobilefield">
															<input class="span5" id="mobile_number" name="mobile_number" type="text" value="<?php echo $edit_mobile_number_fields; ?>">
													</div>
																	<?php
																}
															}

															?>

															<?php if(($manual_fields[0]['mobile_number'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_mobiled").hide();
																			$("#mobilefield").hide();

																		});
																	</script>

															<?php } ?>

<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_mobile',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#mobilefield").css('display', 'inline-block');
															                }else{

															                	$("#mobilefield").hide();}
															        }
															    });
															</script>
<?php } ?>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->





<style type="text/css">


	@media (min-width: 980px){
input.span2a {
    width: 114px;
}
}

	@media (min-width: 1200px){
input.span2a {
    width: 144px;
}
}

	@media (max-width: 980px){
input.span2a {
    width: 280px;
}

#m_male, #m_female{

    margin-top: 20px;
    margin-left: 47px;
}

/*#m_male, #m_female{
	display: block !important;
}*/

}

@media (max-width: 768px){
input.span2a, input.span5 {
    width: 100% !important;
}
}
@media (max-width: 580px){
#new_div.inline-btn{
	    margin-top: 10px !important;
}
}

@media (max-width: 420px){

/*#male, #female{
    width: 81% !important;
}*/

/*#m_male, #m_female{
	display: inline-block !important;
}*/
}

</style>
													<div class="control-group" id="m_genderd">




														<div class="controls">

														<label for="radiobtns">Gender</label>

															<div class="">

															<?php

																//$r = $db->getManualReg('gender', $mno_id, $user_distributor);
                                                            $r = $manual_login_fields['gender'];
																if ($r == 1) {

																	echo '<input onclick="manual_toggle_gender(this)" name="m_gender" id="m_gender" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_male").css('display', 'inline-block');
																			$("#m_female").css('display', 'inline-block');
																			$("#genderfld").css('display', 'inline-block');

																						});
																		</script>

																		<div id="genderfld">
															<input class="span2a" id="gender" name="gender" type="text" value="<?php echo $gender_field; ?>" required>

													</div>
													<div id="m_male">
														<input class="span2a" id="male" name="male" type="text" value="<?php echo $male_field; ?>" required>
													</div>
													<div id="m_female">
															<input class="span2a" id="female" name="female" type="text" value="<?php echo $female_field; ?>" required>
													</div>


																	<?php
																} else {

																	echo '<input onclick="manual_toggle_gender(this)" name="m_gender" id="m_gender" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_male").hide();
																			$("#m_female").hide();
																			$("#genderfld").hide();

																						});
																		</script>

																		<div id="genderfld">
															<input class="span2a" id="gender" name="gender" type="text" value="<?php echo $gender_field; ?>" required>

													</div>
													<div id="m_male">
														<input class="span2a" id="male" name="male" type="text" value="<?php echo $male_field; ?>" required>
													</div>
													<div id="m_female">
															<input class="span2a" id="female" name="female" type="text" value="<?php echo $female_field; ?>" required>
													</div>
																	<?php
																}

															?>

															<?php if(($manual_fields[0]['gender'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_male").hide();
																			$("#m_female").hide();
																			$("#genderfld").hide();
																			$("#m_genderd").hide();

																		});
																	</script>

															<?php } ?>
<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_gender',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#m_male").css('display', 'inline-block');
																			$("#m_female").css('display', 'inline-block');
																			$("#genderfld").css('display', 'inline-block');
															                }else{

															                	$("#m_male").hide();
																				$("#m_female").hide();
																				$("#genderfld").hide();}
															        }
															    });
															</script>
<?php } ?>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->

													<div class="control-group" id="m_age_groupd">




														<div class="controls">
														<label for="radiobtns">Age Group</label>

															<div class="">

															<?php

																//$r = $db->getManualReg('age_group', $mno_id, $user_distributor);
                                                            $r = $manual_login_fields['age_group'];
																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role1="age_group" data-role="agegrp" name="m_age_group" id="m_age_group" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#agegrp").css('display', 'inline-block');

																						});
																		</script>

																		<div id="agegrp">

															<input class="span5" id="age_group" name="age_group" type="text" value="<?php echo $age_group_field; ?>" required>

													</div>

																	<?php
																} else {

																	echo '<input onclick="manual_toggle(this)" data-role1="age_group" data-role="agegrp" name="m_age_group" id="m_age_group" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#agegrp").hide();

																						});
																		</script>

																		<div id="agegrp">

															<input class="span5" id="age_group" name="age_group" type="text" value="<?php echo $age_group_field; ?>" required>

													</div>
																	<?php
																}

															?>

															<?php if(($manual_fields[0]['age_group'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#agegrp").hide();
																			$("#m_age_groupd").hide();

																		});
																	</script>

															<?php } ?>
<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_age_group',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#agegrp").css('display', 'inline-block');
															                }else{

															                	$("#agegrp").hide();}
															        }
															    });
															</script>
<?php }?>
															</div>

														</div>

														<!-- /controls -->

													</div>





													<!-- /control-group -->


													<!-- /////////////// -->





<?php if(!in_array("manual_text", $hide_divs_gene_arr)){ ?>
											<div id="cmnlogintxt" class="control-group">

														<label class="control-label" for="radiobtns">Manual Login Text</label>



														<div class="controls">

														<div><sub>Default Manual Registration text using recommended Font Size 10, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

																<textarea width="500px" id="create_account" name="create_account" class="jqte-test textarea-tiny"><?php echo $manual_login_txt; ?></textarea>

															</div>

														</div>

														<!-- /controls -->

													</div>
                                                    <?php } ?>

													<!-- /control-group -->






</div>

<div id="field_color" class="control-group feild">

														<div class="controls">

															<h3 style="display: inline-block;">Field Color<img data-toggle="tooltip" title="You can set the color of the fields depending on the background used." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display: inline-block;"></h3>

															<div style="margin-left: 5px;">
																<input name="feild_color" class="black" id="feild_color_black" value="rgba(0, 0, 0, 0.75)" type="checkbox">
																<label style='display: inline-block; margin-top: 10px;''></label>
																<input name="feild_color" class="gray" id="feild_color_gray" value="rgba(140, 134, 134, 0.75)" type="checkbox">
																<label style='display: inline-block; margin-top: 10px;''></label>
																<input name="feild_color" class="white" id="feild_color_white" value="rgba(255, 255, 255, 0.75)" type="checkbox">
																<label style='display: inline-block; margin-top: 10px;''></label>
															</div>

														</div>

													</div>

													<div id="field_txt_color" class="control-group feild">

														<div class="controls">

															<h3 style="display: inline-block;">Field Text Color<img data-toggle="tooltip" title="You can set the color of the field text based on the field color used." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display: inline-block;"></h3>

															<div style="margin-left: 5px;">
																<input name="field_txt_color" class="black" id="field_txt_color_black" type="checkbox" value="black">
																<label style='display: inline-block; margin-top: 10px;''></label>
																<input name="field_txt_color" class="gray" id="field_txt_color_gray" type="checkbox" value="gray">
																<label style='display: inline-block; margin-top: 10px;''></label>
																<input name="field_txt_color" class="white" id="field_txt_color_white" type="checkbox" value="white">
																<label style='display: inline-block; margin-top: 10px;''></label>
															</div>

														</div>

													</div>

													<div id="field_preview" class="control-group">

														<div class="controls">

															<h3 style="display: inline-block;">Field Preview</h3>

															<div>

																<div class="login__row">
          															Age Range
          														</div>

															</div>

														</div>

													</div>

													<?php


													if(strlen($edit_bg_color2) < 1){
														$edit_bg_color2 = 'rgba(0, 0, 0, 0.75)';
														$edit_fontcolor2 = 'white';
													}

													 ?>

													<script type="text/javascript">

														$(document).ready(function() {
															$('.login__row').css('background', "<?php echo $edit_bg_color2; ?>");
															$('input[name="field_txt_color"][value="<?php echo $edit_fontcolor2; ?>"]').prop('checked', true);
															$('input[name="feild_color"][value="<?php echo $edit_bg_color2; ?>"]').prop('checked', true);
															$('.login__row').css('color', "<?php echo $edit_fontcolor2; ?>");

															$('input[name="field_txt_color"]').prop('disabled', false);

														    $('input[name="field_txt_color"][class="'+$('input[name="feild_color"][value="<?php echo $edit_bg_color2; ?>"]').attr('class')+'"]').prop('disabled', true);

														     $('input[name="feild_color"]').prop('disabled', false);

														    $('input[name="feild_color"][class="'+$('input[name="field_txt_color"][value="<?php echo $edit_fontcolor2; ?>"]').attr('class')+'"]').prop('disabled', true);

														});

														/*function setFeild(val,val2,val3){

															$('input[name="'+val+'"]').not(this).prop('checked', false);

														    $('input[name="'+val2+'"]').prop('disabled', false);

														     $('input[name="'+val+'"]').prop('disabled', false);
														    $(this).prop('disabled', true);

														    $('input[name="'+val2+'"][value="'+$(this).val()+'"]').prop('disabled', true);

														    $('.login__row').css(val3, $(this).val());

														}*/

														$('input[name="feild_color"]').on('change', function() {

														    $('input[name="feild_color"]').not(this).prop('checked', false);

														    /*$('input[name="field_txt_color"]').prop('disabled', false);

														     $('input[name="feild_color"]').prop('disabled', false);
														    $(this).prop('disabled', true);

														    $('input[name="field_txt_color"][value="'+$(this).val()+'"]').prop('disabled', true);*/

														    $('.login__row').css('background', $(this).val());

														    $('input[name="field_txt_color"]').prop('disabled', false);

														    $('input[name="field_txt_color"][class="'+$(this).attr('class')+'"]').prop('disabled', true);

														});

														$('input[name="field_txt_color"]').on('change', function() {


														   $('input[name="field_txt_color"]').not(this).prop('checked', false);
														    $('.login__row').css('color', $(this).val());

														    $('input[name="feild_color"]').prop('disabled', false);

														    $('input[name="feild_color"][class="'+$(this).attr('class')+'"]').prop('disabled', true);

														    /*$('input[name="field_txt_color"]').prop('disabled', false);
														    $(this).prop('disabled', true);

														    $('input[name="feild_color"]').prop('disabled', false);

														    $('input[name="feild_color"][value="'+$(this).val()+'"]').prop('disabled', true);*/

														});

													</script>

													<style type="text/css">
														.login__row{
															    height: 48px;
															    background: rgb(0, 0, 0);
															    opacity: 0.7;
															    margin-bottom: 10px;
															    padding: 15px;
															    color: white;
															    box-sizing: border-box;
															    width: 300px;
														}

														.feild input[type="checkbox"]:checked + label::before{
															    box-sizing: border-box;
															    border: 3px solid #00cac8 !important;
														}

														.feild input[type="checkbox"] + label::before{
																width: 29px;
    															height: 29px;
														}

														.feild input[type="checkbox"].black + label::before{
																background: black;
														}

														.feild input[type="checkbox"].gray + label::before{
																background: gray;
														}

														.feild input[type="checkbox"].white + label::before{
																background: white;
																border: 1px solid black;
																box-sizing: border-box;
														}
													</style>

<br>
<hr>

<br>

<style>

/* CSS Document */


.button input[type="radio"] {
    display: none;
}

.button img {
    width: 150px;
    margin:10px;
    float:left;
    -webkit-border-radius: 15px;
    border-radius: 15px;
}

input[type="radio"]:checked + label img {
    width: 140px;
    border: 5px solid red;
    -webkit-border-radius: 15px;
    border-radius: 15px;
}
@media screen and (max-width: 780px) {

    .device-node{
        margin-left: 20px !important ;
    }

}
@media screen and (max-width: 300px) {

    .widget-header h3{
        margin-right: 0px !important ;
    }

}

</style>




<div id="img_ajax">


				                                	<div id="varimg" class="control-group">

														<label class="control-label" for="radiobtns">Vertical Image</label>



														<div class=""><!-- //removed controls class -->



                                                        <script>

                                                        function select_img(a) {

                                                        	var n=$(a).data( "role" );


                                                        	document.getElementById(n).checked = true;



                                                        }

													</script>





<div id="bg_img_select">


<!-- <Table border="0" width="100%">
<tr><td colspan="2"><h1></h1><td></tr>

<tr><td> -->
<div style="overflow-x:auto" class="theme_response">
    <div id="verticle_img_invalid_msg" style="display: none;" class="verticle_img_invalid_msg"><p>This field is required.</p></div>

    <div id="slideshow">
       <label class="slideshow_prev">&lsaquo;</label>
       <ul>
<?php

$dirname = $base_portal_folder."/template/cox_block_template/gallery/verticle_img/";
$images = glob($dirname."*.jpg");
foreach($images as $image) {


$imgnames1 =explode("/",$image);
$length1=count($imgnames1);
$imagename1=$imgnames1[$length1-1];

if($edit_var_img==$imagename1){

	$select_var_img='checked';

}else{

	$select_var_img='';
}



echo '<li><div class="button">
    <input class="hide_rad" '.$select_var_img.' type="radio" name="verticle_img" value="'.$imagename1.'" id="'.$image.'"/>
    <label data-role="'.$image.'" onClick="select_img(this)" for="'.$image.'"><img  src="'.$image.'" width="150"/></label>
</div>
</li>


';

}

?>
  </ul>
        <label class="slideshow_next">&rsaquo;</label>

    </div>
</div>


<!-- </td>

<td><h2></h2></td></tr>

</table> -->
</div>

															</div>
														</div>



											<div id="horimg" class="control-group">

														<label class="control-label" for="radiobtns">Horizontal Image</label>



														<div class="">

<div id="logo_img_select">
<!-- <Table border="0" width="100%">
<tr><td colspan="2"><h1></h1><td></tr>

<tr><td> -->
<div style="overflow-x:auto" class="theme_response">
<div id="slideshow1">
       <label class="slideshow_prev1">&lsaquo;</label>
       <ul>
<?php

$dirname = $base_portal_folder."/template/cox_block_template/gallery/Horizontal_img/";
$images = glob($dirname."*.jpg");
foreach($images as $image) {

	$imgnames2 =explode("/",$image);
	$length2=count($imgnames2);
	$imagename2=$imgnames2[$length2-1];

	if($edit_hor_img==$imagename2){

		$select_hor_img='checked';

	}else{

		$select_hor_img='';
	}



echo '<li><div class="button">
    <input class="hide_rad" '.$select_hor_img.' type="radio" name="horizontal_img" value="'.$imagename2.'" id="'.$image.'" />
    <label data-role="'.$image.'" onClick="select_img(this)" for="'.$image.'"><img  src="'.$image.'" width="150" height="180px"/></label>
</div></li>';

}

?>
 </ul>
        <label class="slideshow_next1">&rsaquo;</label>

    </div>
 </div>
<!-- </td>

<td><h2></h2></td></tr>

</table> -->
</div>
															</div>
														</div>
                                                        </div>



                                                        <script>

// $(window).on("load resize",function(){
//     theme_img_responsive();
//     theme_img_responsive1();
//  });

        //an image width in pixels
        var imageWidth1 = 680;


        //DOM and all content is loaded
        $(window).ready(function() {

            set_next1();


        });

         function set_next1(){

             var currentImage1 = 0;

            //set image count
            var allImages1 = $('#slideshow1 li div.dooo').length;

            //setup slideshow frame width
            $('#slideshow1 ul').width(allImages1*imageWidth1/4);

            //attach click event to slideshow buttons
            $('.slideshow_next1').click(function(){

                //increase image counter
                currentImage1 = currentImage1 + 1;
                //if we are at the end let set it to 0
                if(currentImage1>=allImages1/4) currentImage1 = 0;
                //calcualte and set position
                setFramePosition1(currentImage1);

            });

            $('.slideshow_prev1').click(function(){

                //decrease image counter
                currentImage1 = currentImage1 - 1;
                //if we are at the end let set it to 0
                if(currentImage1<0){
                    if(allImages1 % 4 === 0){
                        currentImage1 = (allImages1/4 - 1 );
                    }
                    else{
                    currentImage1 = Math.floor(allImages1/4) ;
                    }
                }
                //calcualte and set position
                setFramePosition1(currentImage1);

            });

         }

        //calculate the slideshow frame position and animate it to the new position
        function setFramePosition1(pos1){

            //calculate position


            var px1 = imageWidth1*pos1*-1;

            //set ul left position
            $('#slideshow1 ul').animate({
                left: px1
            }, 300);
        }
    </script>
    <script>
  var imageWidth = 680;


        //DOM and all content is loaded
        $(window).ready(function() {

            set_next();

        });
         function set_next(){

            var currentImage = 0;

            //set image count
            var allImages = $('#slideshow li div.dooo').length;

            //setup slideshow frame width
            $('#slideshow ul').width(allImages*imageWidth/4);

            //attach click event to slideshow buttons
            $('.slideshow_next').click(function(){

                //increase image counter
                currentImage = currentImage + 1;
                //if we are at the end let set it to 0
                if(currentImage>=allImages/4) currentImage = 0;
                //calcualte and set position
                setFramePosition(currentImage);

            });

            $('.slideshow_prev').click(function(){

                //decrease image counter
                currentImage = currentImage - 1;
                //if we are at the end let set it to 0
                if(currentImage<0){
                    if(allImages % 4 === 0){
                        currentImage = (allImages/4 - 1 );
                    }
                    else{
                    currentImage = Math.floor(allImages/4) ;
                    }
                }
                //calcualte and set position
                setFramePosition(currentImage);

            });

         }

        //calculate the slideshow frame position and animate it to the new position
        function setFramePosition(pos){

            //calculate position


            var px = imageWidth*pos*-1;

            //set ul left position
            $('#slideshow ul').animate({
                left: px
            }, 300);
        }

    </script>



<!-- //////////////////////////////////////////////////////// -->

<!-- ///////////////////////////////////////////////////////// -->


<div id="manualbutton">


												<div id="mregbtn" class="control-group">

														<!-- <label class="control-label" for="radiobtns">Button Text</label> -->



														<div class="controls">


															<h3 style="display: inline-block;">Button text<img data-toggle="tooltip" title="You can use up to 20 characters including spaces." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

															<div class="input-prepend input-append">

															<input type="text" maxlength="20" id="sign_up" name="sign_up" value="<?php echo $registration_btn ?>" onkeyup="valid_check(this.value,'buttontext_validate')">

																<!-- <p id="sign_up_note">Up to 15 characters including space</p> -->

																<small id="buttontext_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>

															</div>

														</div>

														 <script type="text/javascript">

$("#sign_up").keypress(function(event){

	var ew = event.which;

	//if(ew == 32 || ew == 8 ||ew == 0 ||ew == 45 ||ew == 95)
	if(ew == 32 || ew == 8 ||ew == 0 ||ew == 45 || ew == 46 ||ew == 95 ||ew == 33 || ew===63 || ew==39)
		return true;
	if(48 <= ew && ew <= 57)
		return true;
	if(65 <= ew && ew <= 90)
		return true;
	if(97 <= ew && ew <= 122)
		return true;
	return false;
});

$('#sign_up').bind("cut copy paste",function(e) {
		  e.preventDefault();
	   });

</script>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



</div>

<div id="color">


														<!-- *************************** Color ************************** -->

													<div id="btncolor" class="control-group">

														<!-- <label class="control-label" for="radiobtns">Button Design</label> -->



														<div class="controls">

															<div class="input-prepend input-append">
														<h3>Button text color </h3>
														<div id="button_text_color_div" class="input-group colorpicker-component"><input id="button_text_color" name="button_text_color" type="text" value="primary"><span class="input-group-addon"><i></i></span>

															<small id="button_text_color_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;margin-top: 0px;"><p>Invalid color code</p></small>

														</div>

														<h3 style="display: inline-block;">Button “active” state color </h3>
														<div id="button_color_div" class="input-group colorpicker-component"><input id="button_color" name="button_color" type="text" value="primary" ><span class="input-group-addon"><i></i></span>

															<small id="button_color_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;margin-top: 0px;"><p>Invalid color code</p></small>

															</div>

														<h3 style="display: inline-block;">Button “disabled” state color </h3>
														<div id="btn_color_disable_div" class="input-group colorpicker-component"><input id="btn_color_disable" name="btn_color_disable" type="text" value="primary"><span class="input-group-addon"><i></i></span>

															<small id="btn_color_disable_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;margin-top: 0px;"><p>Invalid color code</p></small>

														</div>

														<h3>Button border color </h3>
														<div id="button_ho_color_div" class="input-group colorpicker-component"><input id="button_ho_color" name="button_ho_color" type="text" value="primary" ><span class="input-group-addon"><i></i></span>

															<small id="button_ho_color_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;margin-top: 0px;"><p>Invalid color code</p></small>

														</div>




															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->





														<?php

															$qqq = "SELECT `bg_image`,`logo_image` FROM `exp_mno_distributor` WHERE `distributor_code` = '$user_distributor'";

															$rrr = mysql_query($qqq);

															while ($row1 = mysql_fetch_array($rrr)) {

																$bg_dft_img = $row1[bg_image];

																$logo_dft_img = $row1[logo_image];

															}

														 ?>


	<!--


	 	<link href="testapi/upld/assets/css/main.css" rel="stylesheet">
    <link href="testapi/upld/assets/css/croppic.css" rel="stylesheet">



			<div class="col-lg-4 ">
				<div class="vercls" id="cropContainerMinimal"></div>
			</div>



	<script src="testapi/upld/assets/js/jquery.mousewheel.min.js"></script>
   	<script src="testapi/upld/croppic.min.js"></script>
    <script src="testapi/upld/assets/js/main.js"></script>



    <script>


		var croppicContaineroutputMinimal = {
				uploadUrl:'testapi/upld/img_save_to_file.php',
				cropUrl:'testapi/upld/img_crop_to_file.php',
				modal:true,
				doubleZoomControls:false,
			    rotateControls: false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}
		var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);




	</script>



	 -->




</div>





<!-- /////////////////////////////////////////////////////////// -->






<div id="ios">

<!-- <hr>
 -->
												<!-- 	<div class="control-group">
                                                    <p class=""><b>Step 3.</b> You need to create a intial start screen for Apple devices. It is a simple
																page to inform them to start the connection process. </p>
													</div> -->




</div>



<div id="ios2">


												<!-- <h4 style="color:#3ACC53">iOS/OSX Page</h4> -->



                                           <div class="control-group">
                                            	<div class="control-group">

                                            <table >
											  <tr>

											    <!-- <td><img  src="img/theme_img_001.jpg" width="176px;"></td> -->
											    <td style="padding-left: 2%">



														<div class=""><sub>Default Apple Device text using recommended Font Size 14, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

															<textarea width="500px" id="cna_page" name="cna_page" class="jqte-test textarea-tiny"> <?php echo $cna_page_field; ?> </textarea>


															</div>



														<div class=""><sub>Default button text using recommended Font Size 8, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">


															<textarea width="500px" id="cna_button" name="cna_button"  class="jqte-test textarea-tiny"> <?php echo $cna_button_field; ?> </textarea>



															</div>



												</td>

											  </tr>

											  </table>

                                                 </div>

                                              <!-- /controls -->

                                            </div>

                                      <!-- /control-group -->








 </div>






         <div id="social">



                                                    <div class="control-group" id="social_first" style="display: none;">
                                                    <p class=""><b>Step 4.</b> On the main registration screen you can set the Social Media Registration Information text and the Social Media Button text. In addition you can set the Manual Registration Information text, select which Demographic Data to collect, and set the Manual Registration Button text.</p>
                                                    </div>




														<!-- ************************ text area **************************** -->

													<div class="control-group" id="social_second">

														<div class="control-group">

														<table>
														<tr>
														<td>


                                                            <!-- <img src="img/theme_img_002.jpg" width="176px;"> --></td>

														<td style="padding-left: 2%">


														<div class=""><sub>Default Social Media text using recommended Font Size 14, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

															<textarea width="500px" maxlength="10" id="social_login" name="social_login" class="jqte-test textarea-tiny"><?php echo $social_login_txt; ?></textarea>

															</div>


															<div class=""><sub>Facebook Button Text</sub></div>

															<div class="input-prepend input-append">

															<input class="span5" id="login_with_facebook" name="login_with_facebook" type="text" value="<?php echo $fb_btn; ?>" required>

															</div>




														</td>
														</tr>
														</table>



														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->


	</div>











<div id="voucher">

<br>
													<hr>
<br>
													 <h4 id="vlogin" style="color:#3ACC53">Voucher login</h4>





                                                    <div id="usernf" class="control-group">

                                                        <label class="control-label" for="radiobtns">User Name field</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">



                                                                <input class="span5" id="login_name" name="login_name" type="text" value="<?php echo $login_name_field1; ?>" required>



                                                            </div>

                                                        </div>

                                                        <!-- /controls -->

                                                    </div>

                                                    <!-- /control-group -->





                                                    <div id="userpw" class="control-group">

                                                        <label class="control-label" for="radiobtns">Passcode field</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">



                                                                <input class="span5" id="login_secret" name="login_secret" type="text" value="<?php echo $login_secret_field1; ?>" required>



                                                            </div>

                                                        </div>

                                                        <!-- /controls -->

                                                    </div>

                                                    <!-- /control-group -->








</div>



<br>

<div id="greeting_txt_div" class="control-group">

                                                        <label class="control-label" for="radiobtns">Greeting Text</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">



                                                                <textarea maxlength="90" id="greeting_txt" name="greeting_txt" class="span4" style="padding: 10px;border: 1px solid #979798;padding-left: 20px !important;padding-right: 20px !important;height: 72px;"><?php echo $greeting_txt; ?></textarea>

																<div>
														<p><b id="greeting_txt_txt">You can add your customized message to the beginning of the greeting text, it can have up to 90 characters with spaces.</b> </p></div>



                                                            </div>

                                                        </div>

                                                        <!-- /controls -->

                                                    </div>

													<!-- /control-group -->

<div id="footera">


<br>
													<hr>

<br>



													 <h4 id="footertxt" style="color:#3ACC53">Footer</h4>





													<div id="termsnc" class="control-group">

														<label class="control-label" for="radiobtns">Terms and Conditions text</label>



														<div class="controls">

														<div><sub>Default Terms & Condition text using recommended Font Size 8, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">



															<textarea width="500px" id="toc" name="toc" class="jqte-test textarea-tiny"><?php echo $toc_txt; ?></textarea>





															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->




















<?php if(!in_array("welcomepage", $hide_divs_gene_arr)){ ?>

													<div id="acptcbox" class="control-group">

														<label class="control-label" for="radiobtns">Accept Check Box Text</label>



														<div class="controls">

															<div class="input-prepend input-append">



															<textarea width="500px" id="acpt_text" name="acpt_text" class="jqte-test textarea-tiny"> <?php echo $acpt_text_field; ?> </textarea>



															</div>

														</div>

														<!-- /controls -->

													</div>
                                                    <?php } ?>

													<!-- /control-group -->











</div>









													<div id="isactive" class="control-group">


														<div class="controls">

															<h3>Active</h3>

															<div class="">



															<input id="is_active" name="is_active" type="checkbox" <?php if ($is_active1 == 1) { ?> checked <?php } ?>

															data-toggle="tooltip" title="CHECKING THE BOX will activate this theme and make it visible to all your guests immediately. Alternatively you can leave the box unchecked and enable the theme later from within the Manage section."

															>
                                                                <label for="is_active"></label>


															</div>
															<p><b>Note: Check this box to make this the active theme.</b></p>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->







													<div class="form-actions">

				                                        <?php if($modify_mode == 1) {?>

															<button type="submit" name="theme_update" id="theme_update"

																class="btn btn-primary" disabled>Update </button>&nbsp; <button type="button" name="campign_update_cancel" id="campign_update_cancel" class="btn btn-warning inline-btn"  >Cancel</button>



				                                        <?php }else { ?>

				                                             <button type="submit" name="theme_submit" id="theme_submit" class="btn btn-primary">Save</button>

				                                        <?php } ?>



													</div>

												<!-- /form-actions -->

												</fieldset>


										<script type="text/javascript">


										function ck_topval(set_val){

											//alert(set_val == null);
											//console.log(set_val == null);
											var tname=document.getElementById('theme_name1').value;
											var locid=document.getElementById('location_ssid').value;
											var redirect_type=document.getElementById('redirect_type').value;
											var welcome=document.getElementById('welcome').value;
											var sign_up=document.getElementById('sign_up').value;

											if(welcome != ''){

												var patt = /[-!@<*>$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/;
										    	var welcome = patt.test(welcome);

											}
											else{
												welcome = true;
											}

											if(sign_up != ''){

												var patt = /[-!@<*>$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/;
												var sign_up = patt.test(sign_up);

											}
											else{
												sign_up = true;
											}

											if(!$('#welcome').is(":visible")){
												welcome = 'set';
												$('#welcome').removeAttr( "required" );

											}

											var vertical_validate = $("#slideshow img").hasClass("croppedImg");

											if($('#varimg:visible').length == 0){

												vertical_validate = true;

											}

											var horizontal_validate = $("#slideshow1 img").hasClass("croppedImg");

											if($('#horimg:visible').length == 0){
												horizontal_validate = true;
											}


											if($('input[name=verticle_img]:not(#vari):checked').length){
												vertical_validate = true;

											}

											if($('input[name=horizontal_img]:not(#hori):checked').length){
												horizontal_validate = true;

											}

											if(horizontal_validate){
												$( '#horimg_validate' ).hide();
											}

											if(vertical_validate){
												$( '#varimg_validate' ).hide();
											}

											if($('#logo1_up_bc').length){

												var logo1_up_validate = $("#logo1_up_bc img").hasClass("croppedImg");

												if($('#divlogo1:visible').length == 0){

													logo1_up_validate = true;

													var logo_1_text_val=document.getElementById('logo_1_text').value;

													if(logo_1_text_val == ''){
														logo1_up_validate = false;
													}

												}
											}
											else{
												/* var logo1_up_validate = $("#logo1_up_bc img").hasClass("croppedImg");

												if($('#divlogo1:visible').length == 0){

													logo1_up_validate = true;

													var logo_1_text_val=document.getElementById('logo_1_text').value;

													if(logo_1_text_val == ''){
														logo1_up_validate = false;
													}

												} */
												var logo1_up_validate = true;
											}





											var logo2_up_validate = $("#logo2_up img").hasClass("croppedImg");

											if($('#divlogo2:visible').length == 0){

												logo2_up_validate = true;

												var logo_2_text_val=document.getElementById('logo_2_text').value;

												if(logo_2_text_val == ''){
													logo2_up_validate = false;
												}

											}

											if(($('#alttxt2:visible').length == 0) && ($('#logoimg:visible').length == 0)){

													logo2_up_validate = true;

											}

											if(logo1_up_validate){
												$( '#logo1_up_validate' ).hide();
											}

											if(logo2_up_validate){
												$( '#logo2_up_validate' ).hide();
											}



										if(tname=='' || !horizontal_validate || !vertical_validate || !logo2_up_validate || !logo1_up_validate || locid=='' || redirect_type == '' ||  welcome || sign_up || $('#loading_validate').is(":visible") || $('#splash_url_validate').is(":visible") || $('#title_t_validate').is(":visible") || $('#fontcolor1_validate').is(":visible") || $('#button_text_color_validate').is(":visible") || $('#button_color_validate').is(":visible") || $('#btn_color_disable_validate').is(":visible") || $('#button_ho_color_validate').is(":visible") || $("#shedule_name_dup").is(":visible") ){

											try {
												document.getElementById("theme_submit").disabled = true;
											}

											catch(err) {
												document.getElementById("theme_update").disabled = true;

												if($('#check_update').val()=='0'){
													$('#check_update').val('1')
												}
											}

											}else{

											try {
												document.getElementById("theme_submit").disabled = false;

											}

											catch(err) {


												document.getElementById("theme_update").disabled = false;


											}

											}


											}

                                            $(document).ready(function() {

												<?php if($modify_mode != 1) {	?>
                                                	ck_topval();



													$('#edit-profile1').on('change keyup click paste',function(e){

														ck_topval();

													});

													$('input[name=verticle_img]').on('change', function(event) {
														ck_topval();
													});


													$(document).ajaxStop(function(){

														ck_topval();

													});

											<?php }	?>

                                                });

                                                </script>

											</form>

										</div>

											<!-- ******************* Preview ********************* -->
											<?php if(in_array("THEME_VIEW",$features_array)){?>
										<div class="tab-pane <?php if($active_tab == 'preview') echo 'active'; ?>" id="preview">



                                            <?php

                                            if(isset($_SESSION['msg_up'])){

                                                echo $_SESSION['msg_up'];

                                                unset($_SESSION['msg_up']);





                                            }?>

                                                                                              <h1 class="head">
    First impressions last,
make yours a splash page. <img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable webpage upon connection to your Guest WiFi network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>



											<div class="widget widget-table action-table">







												<form id="tag_form" class="form-horizontal">

													<fieldset>



														<div class="control-group">





															<div class="controls">

																<!-- <label class="control-label" for="radiobtns">Theme</label> -->

																<h3 style="display: inline-block;">Theme</h3>

																<div class="input-prepend input-append">

																	<select name="theme_id" class="span5" id="theme_id" onchange="loadap1();">

																	<option value="-1">Select Theme</option>

																	<?php

																	$key_query = "SELECT theme_id,theme_name FROM exp_themes WHERE distributor = '$user_distributor'";



																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$theme_id = $row[theme_id];

																		$theme_name = $row[theme_name];



																		echo '<option value="'.$theme_id.'">'.$theme_name.'</option>';

																	}

																	?>

																	</select>

																	<div id="error_msg" style="display: none;" class="error-wrapper bubble-pointer mbubble-pointer"><p>Please select a theme.</p></div>

																</div>

															</div>

															<!-- /controls -->

														</div>

														<!-- /control-group -->





														<div class="control-group" id="type_div">





															<div class="controls">

																<h3 style="display: inline-block;">Type</h3>

																<div class="input-prepend input-append">

																	<select name="theme_type" class="span5" id="theme_type" required>

																	<option value="new">New User</option>

																	<option value="return">Return User</option>



																	</select>

																</div>

															</div>

															<!-- /controls -->

														</div>

														<!-- /control-group -->




														<?php if(getSectionType("THEME_PRIVIEW_SSID",$system_package,$user_type)=="multy" || $package_features=="all"){ ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">SSID / AP</label>
															<div class="controls">
																<div class="input-prepend input-append" id="aps_list">
																	<select name="theme_ssid" id="theme_ssid" required>
																	<option value="-1">Select SSID and AP</option>
																	<?php

																	 $key_query = "SELECT concat(location_ssid,'|',ap_id) as id, CONCAT(location_ssid,' - ',ap_id) AS detail
																	FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor'";

																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$id = $row[id];

																		$detail = $row[detail];

																		echo '<option value="'.$id.'">'.$detail.'</option>';
																	}
																	?>
																	</select>
																</div>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<?php } ?>


														<?php if(getSectionType("THEME_PRIVIEW_SSID",$system_package,$user_type)=="single"){ ?>

																<div class="input-prepend input-append" id="aps_list">
																	<input type="hidden"  name="theme_ssid" id="theme_ssid" required  value="<?php

																	 $key_query = "SELECT concat(location_ssid,'|',ap_id) as id, CONCAT(location_ssid,' - ',ap_id) AS detail
																	FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor' LIMIT 1";

																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$id = $row[id];

																		$detail = $row[detail];

																		echo $id;
																	}
																	?>" >
																</div>
															<!-- /controls -->

														<!-- /control-group -->
														<?php } ?>










														<div class="form-actions" >

															<button disabled="disabled" id="preview_btn" type="button" name="submit" onclick="preview();"

																class="btn btn-primary" data-toggle="tooltip" title="The PREVIEW button will allow you to visualize the mobile view of the captive portal.">
																Preview
																</button>



															<button disabled="disabled" type="button" name="submit" id="gen_url" onclick="url_creation();"

																class="btn btn-danger inline-btn" data-toggle="tooltip" title="The GENERATE URL button creates a URL that can be shared electronically and will allow the recipient to test the captive portal layout natively on any device or browser.">
																Generate URL</button>


																 <script>

																					                                                                                                $(document).ready(function() {
																					                                                                                                        function checkthemeselect(){
																					                                                                                                                var a =$('#theme_id').val();
																					                                                                                                                if(a==-1){

																					                                                                                                                        $('#preview_btn').prop('disabled', true);
																					                                                                                                                        $('#gen_url').prop('disabled', true);
																					                                                                                                                }else{

																					                                                                                                                        $('#preview_btn').prop('disabled', false);
																					                                                                                                                        $('#gen_url').prop('disabled', false);
																					                                                                                                                }
																				                                                                                                                }

																				                                                                                                                checkthemeselect();

																				                                                                                                           $( "#theme_id" ).on('change',function() {
																                                                                                                                                                  checkthemeselect();
																                                                                                                                                                });
																					                                                                                                });

																					                                                                                        </script>



													 <div id="new_div" class="inline-btn" style=""></div>



														<img  id="tag_loader" src="img/loading_ajax.gif" style="visibility: hidden;">





														</div>

														<!-- /form-actions -->

													</fieldset>

												</form>



												<?php



													/* Generate DEMO URL */



													/* function strToHex($string)

													{

														$hex='';

														for ($i=0; $i < strlen($string); $i++)

														{

														$hex .= dechex(ord($string[$i]));

														}

														return $hex;

													}



													$key_query = "SELECT location_ssid,ap_id,group_tag FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor' LIMIT 1";



													$query_results=mysql_query($key_query);

													while($row=mysql_fetch_array($query_results)){

														$ssid = $row[location_ssid];

														$ap_id = $row[ap_id];

														$group_tag = $row[group_tag];



													}	 */



													/*

													$mac = "DEMO_MAC";

													$ascii = "WLAN:wlandemo:30:".$ssid.":zf7762:".$ap_id.":DEMO_MAC";

													$network_key = "network-demo";

													echo $hex_option_82 = strToHex($ascii); */



													///network name////

													$network_name = trim($db->setVal('network_name','ADMIN'),"/");



													//get parameters//

													$get_parametrs=mysql_query("SELECT p.`redirect_method`,p.`mac_parameter`,p.`ap_parameter`,p.`ssid_parameter`,p.`loc_string_parameter`,p.`network_ses_parameter` ,p.`ip_parameter`

													FROM `exp_network_profile` p WHERE p.`network_profile`='$network_name' LIMIT 1");



													$row3=mysql_fetch_array($get_parametrs);



													$redirect_method=$row3['redirect_method'];

													$mac_parameter=$row3['mac_parameter'];

													$ap_parameter=$row3['ap_parameter'];

													$ssid_parameter=$row3['ssid_parameter'];

													$loc_string_parameter=$row3['loc_string_parameter'];

													$network_ses_parameter=$row3['network_ses_parameter'];

													$ip_parameter=$row3['ip_parameter'];


													/*Page URL */
													//$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

													function siteURL()
													{
														$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
														$domainName = $_SERVER['HTTP_HOST'].'/';
														return $protocol;
													}
													define( 'SITE_URL', siteURL() );

												/*
													if( isset($_SERVER['HTTPS'] ) ) {

														$pageURL = "https://";;
													}else{

														$pageURL = "http://";;
													}*/
											$SSL_ON=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='SSL_ON' LIMIT 1");

                                               // $pageURL = "https://";


                                               // if( !isset($_SERVER['HTTPS'] ) ) {

                                                	//$pageURL = "http://";;
                                               // }

                                                //$pageURL = SITE_URL;

											//echo $SSL_ON;

											if($SSL_ON!='1'){

												$pageURL = "http://";

											}else{

												$pageURL = "https://";


											}


													if ($_SERVER["SERVER_PORT"] != "80")
													{
														$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
													}
													else
													{
														$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
													}
													/* */


													$base_folder_path_preview = $db->setVal('portal_base_folder', 'ADMIN');

												?>









												<script type="text/javascript">



													function url_creation(){

														var theme_id=document.getElementById("theme_id").value;

														var theme_type=document.getElementById("theme_type").value;

														var theme_ssid=document.getElementById("theme_ssid").value;

														var ap_ssid = theme_ssid.split('|');



														var mac = "DEMO_MAC";

														var ascii = "WLAN:wlandemo:30:"+ap_ssid[0]+":zf7762:"+ap_ssid[1]+":DEMO_MAC";

														var network_key = "network-demo";

														var hex_option_82 = toHex(ascii);





														var redirect_method="<?php echo $redirect_method; ?>";

														var mac_parameter="<?php echo $mac_parameter; ?>";

														var ap_parameter="<?php echo $ap_parameter; ?>";

														var ssid_parameter="<?php echo $ssid_parameter; ?>";

														var loc_string_parameter="<?php echo $loc_string_parameter; ?>";

														var network_ses_parameter="<?php echo $network_ses_parameter; ?>";

														var ip_parameter="<?php echo $ip_parameter; ?>";







														if(theme_type=='new'){



															if(redirect_method=='OPTION82_STRING'){

																loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



															}else if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}

															else{



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}


															var url_base = '<?php echo $pageURL; ?>';
															var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);
															//var myDir2 = myDir.substring( 0, myDir.lastIndexOf( "/" ) + 1);
															//alert(myDir);

																loc = myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;



														}

													else if(theme_type=='return'){





														if(redirect_method=='OPTION82_STRING'){

																loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



															}else if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}

															else{



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}


														var url_base = '<?php echo $pageURL; ?>';
														var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

																loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;





														}


														loc=loc+"&<?php echo $rederect_prm_1=$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile");?>=<?php echo $db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");?>";




														if(theme_id != -1){

															document.getElementById('preview_url').innerHTML = 'You can copy and paste the below URL in an email, messenger etc., to allow anyone anywhere to test the end-to-end experience on a device of their choice. <br><textarea readonly id="genUrlTextArea" rows="3" style="margin: 0px 0px 9px; width: 95%; height: 79px;">'+loc+'</textarea><br><br>';

															document.getElementById('new_div').innerHTML = '<a href="'+loc+'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="The OPEN URL IN A NEW TAB button will allow you to launch the captive portal natively on the device and browser you are currently using.">Open URL in new tab</a>';

                                                            var copyText = document.getElementById("genUrlTextArea");
                                                            copyText.select();
                                                            document.execCommand("Copy");


															$("#error_msg").hide();
															eval(document.getElementById('tootip_script').innerHTML);


														}

														else{

															/*document.getElementById('new_div').innerHTML = '<font size="small" color="brown"> Please select a theme.</font>';*/
															document.getElementById("error_msg").style = "display: inline-block";



														}

													}























													function preview(){







														var theme_id=document.getElementById("theme_id").value;

														var theme_type=document.getElementById("theme_type").value;

														var theme_ssid=document.getElementById("theme_ssid").value;

														var ap_ssid = theme_ssid.split('|');

														try {

															$('iframe').contents().find('#loading_img').show();

														} catch (error) {

														}



														var mac = "DEMO_MAC";

														var ascii = "WLAN:wlandemo:30:"+ap_ssid[0]+":zf7762:"+ap_ssid[1]+":DEMO_MAC";

														var network_key = "network-demo";

														var hex_option_82 = toHex(ascii);





														var redirect_method="<?php echo $redirect_method; ?>";

														var mac_parameter="<?php echo $mac_parameter; ?>";

														var ap_parameter="<?php echo $ap_parameter; ?>";

														var ssid_parameter="<?php echo $ssid_parameter; ?>";

														var loc_string_parameter="<?php echo $loc_string_parameter; ?>";

														var network_ses_parameter="<?php echo $network_ses_parameter; ?>";

														var ip_parameter="<?php echo $ip_parameter; ?>";





														if(theme_type=='new'){



															if(redirect_method=='OPTION82_STRING'){

																loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



															}else  if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}

															else{



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}


															var url_base = '<?php echo $pageURL; ?>';
															var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

																loc =myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;



														}

													else if(theme_type=='return'){





														if(redirect_method=='OPTION82_STRING'){

																loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



															}else  if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}

															else{



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}


														var url_base = '<?php echo $pageURL; ?>';
														var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

																loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;





														}

 loc=loc+"&<?php echo $rederect_prm_1=$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile");?>=<?php echo $db->getValueAsf("SELECT `group_number` AS f FROM `exp_distributor_groups` WHERE `distributor`='$user_distributor' LIMIT 1");?>";







														//	alert(loc);

														if(theme_id != -1){

															document.getElementById('preview1').src = loc;

															document.getElementById('preview2').src = loc;

															document.getElementById('preview3').src = loc;

                                                            try {
                                                                document.getElementById('preview4').src = loc;
                                                            }
                                                            catch(err) {
                                                                //document.getElementById("demo").innerHTML = err.message;
                                                            }


															document.getElementById('new_div').innerHTML = '<a href="'+loc+'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="The OPEN URL IN A NEW TAB button will allow you to launch the captive portal natively on the device and browser you are currently using.">Open URL in new tab</a>';

															$("#error_msg").hide();
															eval(document.getElementById('tootip_script').innerHTML);

														}

														else{

															/*document.getElementById('new_div').innerHTML = '<font size="small" color="brown"> Please select a theme.</font>';*/

															document.getElementById("error_msg").style = "display: inline-block";

														}

													}







													function toHex(str) {

														var hex = '';

														for(var i=0;i<str.length;i++) {

															hex += ''+str.charCodeAt(i).toString(16);

														}

														return hex;

													}

												</script>







												<div id="preview_url"></div>



												<center>

													<div id="devices">




                                                    <div style="overflow-x: auto" class="table_response">
														<div class="device-node" align="center" style="margin-left:320px;">

												        <h4>Phone - 240 x 320</h4>

												        <div style="width:240px; height:320px; overflow:hidden"><iframe name="preview1" id="preview1" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="240" height="320"></iframe></div>

												        </div>
                                                    </div>




                                                    <div style="overflow-x: auto" class="table_response">
												        <div class="device-node" style="margin-left:280px;">

												        <h4>iPhone - 320 x 480</h4>

												        <div style="width:320px; height:480px; overflow:hidden"><iframe scrolling="yes" name="preview2" id="preview2" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="320" height="480"></iframe></div>

												        </div>
                                                    </div>






                                                    <div style="overflow-x: auto" class="table_response">
												        <div class="device-node" style="margin-left:200px;">

												        <h4>Tablet - 480 x 640</h4>

												        <div  style="width:480px; height:640px;overflow:hidden"><iframe scrolling="yes" name="preview3" id="preview3" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="480" height="640"></iframe></div>

												        </div>
                                                    </div>




<!-- <center>

												        <div class="device-node" style="margin-left:80px;">

												        <h4>iPad - 768 x 1024</h4>

												        <div style="width:768px; height:1024px; overflow:hidden"><iframe name="preview4" id="preview4" src="ajax/waiting.php" width="768" height="1024"></iframe></div>

												        </div>

												        </center> -->




											    	</div>

												</center>

												<script>


												</script>



												<!-- /widget-content -->

											</div>

											<!-- /widget -->



										</div>
												<?php }?>






<!-- ******************* assing ********************* -->
<?php if(in_array("THEME_ASSIGN",$features_array)){?>
										<div class="tab-pane <?php if($active_tab == 'assing') echo 'active'; ?>" id="assing">



                                            <?php

                                            if(isset($_SESSION['msg_ass'])){

                                                echo $_SESSION['msg_ass'];

                                                unset($_SESSION['msg_ass']);





                                            }?>

                                                                                              <h1 class="head">
 Theme Assignment. <img data-toggle="tooltip" title='Select the theme you would like to assign to multiple locations. Then select the locations and save.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>



											<div class="widget widget-table action-table">







												<form id="theme_tag_form" class="form-horizontal"  method="POST" action="">

													<fieldset>

													<div class="control-group">


														


<div class="controls form-group">

	<!-- <label class="control-label" for="radiobtns">Theme</label> -->

	<h3 style="display: inline-block;">Select Location/Property</h3>

	<div class="input-prepend input-append  ">

		<select name="theme_proprty_id" class="span5" id="theme_proprty_id" onchange="load_theme(this.value);">

		<option value="">Select Location/Property</option>

		<?php

		$key_query_property = "SELECT a.user_distributor,d.`verification_number`,d.`distributor_name`
		FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor 
		WHERE parent_id='$user_distributor'";



		$query_results_propert=mysql_query($key_query_property);

		while($row=mysql_fetch_array($query_results_propert)){

			$pa_verification_number= $row['verification_number'];
			$pa_user_distributor= $row['user_distributor'];

			


			echo '<option value="'.$pa_verification_number.'">'.$pa_verification_number.'</option>';

		}

		?>

		</select>

		
	</div>

</div>

<!-- /controls -->

</div>

<!-- /control-group -->

<script>

function load_theme(theme_verification_number_val){

	document.getElementById("theme_load").innerHTML = "<img src=\"img/loading_ajax.gif\">";
	var formData={theme_verification_number:theme_verification_number_val};
	var formData_ssid={theme_verification_number_ssid:theme_verification_number_val};
	$.ajax({
                                url : "ajax/getThemes_assign.php",
                                type: "POST",
                                data : formData,
                                success: function(data)
                                {
									$('#theme_id').html(data);
									document.getElementById("theme_load").innerHTML ="";
									//alert(data);
									//var theme_data = JSON.stringify(data);
									//var jsonObject = JSON.parse(data);

								//	alert(jsonObject[]);
									//theme_data.forEach(set_theme);
									/* $('#theme_id')
         .append($("<option></option>")
                    .attr("value",key)
                    .text(value));  */
                                   

                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    //$('#ssid_name_error').html('Network Error');
                                }
                            });


							$.ajax({
                                url : "ajax/getThemes_assign.php",
                                type: "POST",
                                data : formData_ssid,
                                success: function(data)
                                { //alert(data);
									//$('#theme_id').html(data);
									
									$('#theme_ssid').val(data);

                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    //$('#ssid_name_error').html('Network Error');
                                }
                            });	

}


</script>






														<div class="control-group">


														


															<div class="controls  form-group">

																<!-- <label class="control-label" for="radiobtns">Theme</label> -->

																<h3 style="display: inline-block;">Theme</h3>

																<div class="input-prepend input-append" id="load_theme">

																	<select name="theme_id" class="span5" id="theme_id" onchange="loadap1();">

																	<option value="">Select Theme</option>

																	<?php
/* 
																	$key_query = "SELECT theme_id,theme_name FROM exp_themes WHERE distributor = '$user_distributor'";



																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$theme_id = $row[theme_id];

																		$theme_name = $row[theme_name];



																		echo '<option value="'.$theme_id.'">'.$theme_name.'</option>';

																	} */

																	?>

																	</select> <div id="theme_load" style="display: inline-block;"></div>

																	<div id="error_msg" style="display: none;" class="error-wrapper bubble-pointer mbubble-pointer"><p>Please select a theme.</p></div>

																</div>

															</div>

															<!-- /controls -->

														</div>

														<!-- /control-group -->



														<div class="control-group" id="type_div" style="display:none;">





<div class="controls form-group" >

	<h3 style="display: inline-block;">Type</h3>

	<div class="input-prepend input-append">

		<select name="theme_type" class="span5" id="theme_type" required>

		<option value="new">New User</option>

		<option value="return">Return User</option>



		</select>

	</div>

</div>

<!-- /controls -->

</div>

<!-- /control-group -->



														<?php if(getSectionType("THEME_PRIVIEW_SSID",$system_package,$user_type)=="single"){ ?>

																<div class="input-prepend input-append" id="aps_list">
																	<input type="hidden"  name="theme_ssid" id="theme_ssid"   value="" >
																</div>
															<!-- /controls -->

														<!-- /control-group -->
														<?php } ?>




														<div class="form-actions" >

															<a  id="preview_btn" type="button" name="submit" onclick="preview();"

																class="btn btn-primary inline-btn" data-toggle="tooltip" title="The PREVIEW button will allow you to visualize the mobile view of the captive portal.">
																Preview
																</a>



														<!-- 	<button disabled="disabled" type="button" name="submit" id="gen_url" onclick="url_creation();"

																class="btn btn-danger inline-btn" data-toggle="tooltip" title="The GENERATE URL button creates a URL that can be shared electronically and will allow the recipient to test the captive portal layout natively on any device or browser.">
																Generate URL</button> -->


																 <script>

																					                                                                                                $(document).ready(function() {
																					                                                                                                        function checkthemeselect(){
																					                                                                                                                var a =$('#theme_id').val();
																					                                                                                                                if(a==-1){

																					                                                                                                                        $('#preview_btn').prop('disabled', true);
																					                                                                                                                        $('#gen_url').prop('disabled', true);
																					                                                                                                                }else{

																					                                                                                                                        $('#preview_btn').prop('disabled', false);
																					                                                                                                                        $('#gen_url').prop('disabled', false);
																					                                                                                                                }
																				                                                                                                                }

																				                                                                                                                checkthemeselect();

																				                                                                                                           $( "#theme_id" ).on('change',function() {
																                                                                                                                                                  checkthemeselect();
																                                                                                                                                                });
																					                                                                                                });

																					                                                                                        </script>



													 <div id="new_div" class="inline-btn" style=""></div>



														<img  id="tag_loader" src="img/loading_ajax.gif" style="visibility: hidden;">





														</div>

														<!-- /form-actions -->


														<div class="control-group">


														


<div class="controls form-group">

	<!-- <label class="control-label" for="radiobtns">Theme</label> -->

	<h3 style="display: inline-block;">Assing Location/Property</h3>

	<div class="input-prepend input-append" >
	<div class="input-prepend input-append multi_sele_parent">
	<select name="assing_property[]" id="assing_property"
																	multiple="multiple"  class="form-control">
																<?php

																	$query_results_property = mysql_query($key_query_property);

																	
																while ($row = mysql_fetch_array($query_results_property)) {
																	$pro_verification_number= $row['verification_number'];
																	$pro_distributor_name= $row['distributor_name'];

																	$set2 = '';
																	//check for edit//
																	/* if (isset($mg_ad_name)) {

																		if (in_array($tag_name, $group_tag_values_array)) {

																			$set2 = ' selected="selected"';
																		} else {

																			$set2 = '';
																		}


																	} */


																	echo '<option value="' . $pro_verification_number . '" ' . $set2 . '> ' . $pro_distributor_name . '</option>';
																}

																?>

															</select>
															</div>

															<input name="pr_chk1" id="pr_chk1" type="checkbox"  onClick="property_select()" />Select All

															<script>
      
         
			function property_select(){


		  if ($('#pr_chk1').is(':checked')){
			$('#assing_property').multiSelect('select_all');
			}else { 
			$('#assing_property').multiSelect('deselect_all');
			}


		 }

        
      </script>

	</div>

</div>

<!-- /controls -->

</div>

<!-- /control-group -->
<?php

													echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET_THEME'].'" />';

												?>

<div class="form-actions" >
<button type="submit"  name="submit_assign_theme" id="submit_assign_theme" class="btn btn-primary">Assign</button>&nbsp; <strong><font color="#FF0000"></font><small></small></strong>
</div>
														

													</fieldset>

												</form>



												<?php



													/* Generate DEMO URL */



													/* function strToHex($string)

													{

														$hex='';

														for ($i=0; $i < strlen($string); $i++)

														{

														$hex .= dechex(ord($string[$i]));

														}

														return $hex;

													}



													$key_query = "SELECT location_ssid,ap_id,group_tag FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor' LIMIT 1";



													$query_results=mysql_query($key_query);

													while($row=mysql_fetch_array($query_results)){

														$ssid = $row[location_ssid];

														$ap_id = $row[ap_id];

														$group_tag = $row[group_tag];



													}	 */



													/*

													$mac = "DEMO_MAC";

													$ascii = "WLAN:wlandemo:30:".$ssid.":zf7762:".$ap_id.":DEMO_MAC";

													$network_key = "network-demo";

													echo $hex_option_82 = strToHex($ascii); */



													///network name////

													$network_name = trim($db->setVal('network_name','ADMIN'),"/");



													//get parameters//

													$get_parametrs=mysql_query("SELECT p.`redirect_method`,p.`mac_parameter`,p.`ap_parameter`,p.`ssid_parameter`,p.`loc_string_parameter`,p.`network_ses_parameter` ,p.`ip_parameter`

													FROM `exp_network_profile` p WHERE p.`network_profile`='$network_name' LIMIT 1");



													$row3=mysql_fetch_array($get_parametrs);



													$redirect_method=$row3['redirect_method'];

													$mac_parameter=$row3['mac_parameter'];

													$ap_parameter=$row3['ap_parameter'];

													$ssid_parameter=$row3['ssid_parameter'];

													$loc_string_parameter=$row3['loc_string_parameter'];

													$network_ses_parameter=$row3['network_ses_parameter'];

													$ip_parameter=$row3['ip_parameter'];


													/*Page URL */
													//$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

													function siteURL()
													{
														$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
														$domainName = $_SERVER['HTTP_HOST'].'/';
														return $protocol;
													}
													define( 'SITE_URL', siteURL() );

												/*
													if( isset($_SERVER['HTTPS'] ) ) {

														$pageURL = "https://";;
													}else{

														$pageURL = "http://";;
													}*/
											$SSL_ON=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='SSL_ON' LIMIT 1");

                                               // $pageURL = "https://";


                                               // if( !isset($_SERVER['HTTPS'] ) ) {

                                                	//$pageURL = "http://";;
                                               // }

                                                //$pageURL = SITE_URL;

											//echo $SSL_ON;

											if($SSL_ON!='1'){

												$pageURL = "http://";

											}else{

												$pageURL = "https://";


											}


													if ($_SERVER["SERVER_PORT"] != "80")
													{
														$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
													}
													else
													{
														$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
													}
													/* */


													$base_folder_path_preview = $db->setVal('portal_base_folder', 'ADMIN');

												?>









												<script type="text/javascript">



													function url_creation(){

														var theme_id=document.getElementById("theme_id").value;

														var theme_type=document.getElementById("theme_type").value;

														var theme_ssid=document.getElementById("theme_ssid").value;

														var theme_proprty_id=document.getElementById("theme_proprty_id").value;

														var ap_ssid = theme_ssid.split('|');



														var mac = "DEMO_MAC";

														var ascii = "WLAN:wlandemo:30:"+ap_ssid[0]+":zf7762:"+ap_ssid[1]+":DEMO_MAC";

														var network_key = "network-demo";

														var hex_option_82 = toHex(ascii);





														var redirect_method="<?php echo $redirect_method; ?>";

														var mac_parameter="<?php echo $mac_parameter; ?>";

														var ap_parameter="<?php echo $ap_parameter; ?>";

														var ssid_parameter="<?php echo $ssid_parameter; ?>";

														var loc_string_parameter="<?php echo $loc_string_parameter; ?>";

														var network_ses_parameter="<?php echo $network_ses_parameter; ?>";

														var ip_parameter="<?php echo $ip_parameter; ?>";







														if(theme_type=='new'){



															if(redirect_method=='OPTION82_STRING'){

																loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



															}else if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}

															else{



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}


															var url_base = '<?php echo $pageURL; ?>';
															var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);
															//var myDir2 = myDir.substring( 0, myDir.lastIndexOf( "/" ) + 1);
															//alert(myDir);

																loc = myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;



														}

													else if(theme_type=='return'){





														if(redirect_method=='OPTION82_STRING'){

																loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



															}else if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}

															else{



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}


														var url_base = '<?php echo $pageURL; ?>';
														var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

																loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;





														}


														//loc=loc+"&<?php //echo $rederect_prm_1=$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile");?>=<?php //echo $db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");?>";
														loc=loc+"&<?php echo $rederect_prm_1=$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile");?>="+theme_proprty_id;


														//alert(loc);

														if(theme_id != -1){

														//	document.getElementById('preview_url').innerHTML = 'You can copy and paste the below URL in an email, messenger etc., to allow anyone anywhere to test the end-to-end experience on a device of their choice. <br><textarea readonly id="genUrlTextArea" rows="3" style="margin: 0px 0px 9px; width: 95%; height: 79px;">'+loc+'</textarea><br><br>';

															document.getElementById('new_div').innerHTML = '<a href="'+loc+'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="The OPEN URL IN A NEW TAB button will allow you to launch the captive portal natively on the device and browser you are currently using.">Open URL in new tab</a>';

                                                            /* var copyText = document.getElementById("genUrlTextArea");
                                                            copyText.select();
                                                            document.execCommand("Copy"); */


															$("#error_msg").hide();
															eval(document.getElementById('tootip_script').innerHTML);


														}

														else{

															/*document.getElementById('new_div').innerHTML = '<font size="small" color="brown"> Please select a theme.</font>';*/
															document.getElementById("error_msg").style = "display: inline-block";



														}

													}























													function preview(){







														var theme_id=document.getElementById("theme_id").value;

														var theme_type=document.getElementById("theme_type").value;

														var theme_ssid=document.getElementById("theme_ssid").value;

														var ap_ssid = theme_ssid.split('|');

														var theme_proprty_id=document.getElementById("theme_proprty_id").value;

														try {

															$('iframe').contents().find('#loading_img').show();

														} catch (error) {

														}



														var mac = "DEMO_MAC";

														var ascii = "WLAN:wlandemo:30:"+ap_ssid[0]+":zf7762:"+ap_ssid[1]+":DEMO_MAC";

														var network_key = "network-demo";

														var hex_option_82 = toHex(ascii);





														var redirect_method="<?php echo $redirect_method; ?>";

														var mac_parameter="<?php echo $mac_parameter; ?>";

														var ap_parameter="<?php echo $ap_parameter; ?>";

														var ssid_parameter="<?php echo $ssid_parameter; ?>";

														var loc_string_parameter="<?php echo $loc_string_parameter; ?>";

														var network_ses_parameter="<?php echo $network_ses_parameter; ?>";

														var ip_parameter="<?php echo $ip_parameter; ?>";





														if(theme_type=='new'){



															if(redirect_method=='OPTION82_STRING'){

																loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



															}else  if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}

															else{



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}


															var url_base = '<?php echo $pageURL; ?>';
															var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

																loc =myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;



														}

													else if(theme_type=='return'){





														if(redirect_method=='OPTION82_STRING'){

																loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



															}else  if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}

															else{



																loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

															}


														var url_base = '<?php echo $pageURL; ?>';
														var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

																loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;





														}

 loc=loc+"&<?php echo $rederect_prm_1=$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile");?>="+theme_proprty_id;







														//	alert(loc);

														if(theme_id != -1){

															document.getElementById('preview1').src = loc;

															document.getElementById('preview2').src = loc;

															document.getElementById('preview3').src = loc;

                                                            try {
                                                                document.getElementById('preview4').src = loc;
                                                            }
                                                            catch(err) {
                                                                //document.getElementById("demo").innerHTML = err.message;
                                                            }


															document.getElementById('new_div').innerHTML = '<a href="'+loc+'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="The OPEN URL IN A NEW TAB button will allow you to launch the captive portal natively on the device and browser you are currently using.">Open URL in new tab</a>';

															$("#error_msg").hide();
															eval(document.getElementById('tootip_script').innerHTML);

														}

														else{

															/*document.getElementById('new_div').innerHTML = '<font size="small" color="brown"> Please select a theme.</font>';*/

															document.getElementById("error_msg").style = "display: inline-block";

														}

													}







													function toHex(str) {

														var hex = '';

														for(var i=0;i<str.length;i++) {

															hex += ''+str.charCodeAt(i).toString(16);

														}

														return hex;

													}

												</script>







												<div id="preview_url"></div>



												<center>

													<div id="devices">




                                                    <div style="overflow-x: auto" class="table_response">
														<div class="device-node" align="center" style="margin-left:320px;">

												        <h4>Phone - 240 x 320</h4>

												        <div style="width:240px; height:320px; overflow:hidden"><iframe name="preview1" id="preview1" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="240" height="320"></iframe></div>

												        </div>
                                                    </div>




                                                    <div style="overflow-x: auto" class="table_response">
												        <div class="device-node" style="margin-left:280px;">

												        <h4>iPhone - 320 x 480</h4>

												        <div style="width:320px; height:480px; overflow:hidden"><iframe scrolling="yes" name="preview2" id="preview2" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="320" height="480"></iframe></div>

												        </div>
                                                    </div>






                                                    <div style="overflow-x: auto" class="table_response">
												        <div class="device-node" style="margin-left:200px;">

												        <h4>Tablet - 480 x 640</h4>

												        <div  style="width:480px; height:640px;overflow:hidden"><iframe scrolling="yes" name="preview3" id="preview3" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="480" height="640"></iframe></div>

												        </div>
                                                    </div>




<!-- <center>

												        <div class="device-node" style="margin-left:80px;">

												        <h4>iPad - 768 x 1024</h4>

												        <div style="width:768px; height:1024px; overflow:hidden"><iframe name="preview4" id="preview4" src="ajax/waiting.php" width="768" height="1024"></iframe></div>

												        </div>

												        </center> -->




											    	</div>

												</center>

												<script>


												</script>



												<!-- /widget-content -->

											</div>

											<!-- /widget -->



										</div>
												<?php }?>

												
												


											<script type="text/javascript">

/*$(document).on("click","input[type='text']", function(e){
	var x = e.target.id;
    val_check1(x);
});*/

/*$(document).on("click","select", function(e){
	var x = e.target.id;
    val_check1(x);
});*/

$(document).on("click", function(e){
	<?php if($modify_mode != 1) {	?>
  val_check1("is_active");
   <?php  }	?>
});

$(document).on("click","#logo2_up .cropControls", function(e){

    val_check1("logo2_up");
});

$(document).on("click","#logo1_up_bc .cropControls", function(e){

    val_check1("logo1_up_bc");
});

$(document).on("click","#varimg", function(e){

    val_check1("varimg");
});

$(document).on("click","#horimg", function(e){

    val_check1("horimg");
});

$(document).on("click","textarea", function(e){

    val_check1("greeting_txt");
});

$(document).on("click","#is_active", function(e){

 //   val_check1("is_active");
 <?php if($modify_mode != 1) {	?>
  val_check1("is_active");
   <?php  }	?>
});

$(document).on("click","#btncolor", function(e){

    val_check1("btncolor");
});
$(document).on("click","#logo_txt1_enable", function(e){

    val_check1("logo_txt1_enable");
});
$(document).on("click","#logo_txt2_enable", function(e){

    val_check1("logo_txt2_enable");
});

$(document).on("keyup change",".colorpicker-element input[type='text']", function(e){
	var x = e.target.id;

	setTimeout( function(){
		valid_check($('#'+x).val(),x+'_validate');
	}, 100);

});

<?php if($modify_mode == 1) {	?>
val_check1('logo_txt2_enable');
  <?php } ?>

										function val_check1(x) {

										var theme_ele = new Array("theme_name1", "location_ssid","language", "title_t","loading" ,"redirect_type","splash_url","template_name", "reg_type" , "logo1_up_bc", "logo2_up", "logo_txt2_enable" , "varimg", "horimg", "btncolor" ,"welcome","greeting_txt","is_active");
											var a = theme_ele.indexOf(x);

											for (i = 0; i < parseInt(a); i++) {
												var this_val = $('#'+theme_ele[i]).val();



												if ( $( '#'+theme_ele[i]+'_validate' ).length ) {

													if(theme_ele[i]=='logo1_up_bc' || theme_ele[i]=='logo2_up'){

														var logoo1 = "#logo1_up_bc img";
														var logoo2 = "#logo2_up img";

														if($('#divlogo1:visible').length != 0){


															if($(logoo1).hasClass("croppedImg")){
															$( '#logo1_up_validate' ).hide();
															}
															else{
																$( '#logo1_up_validate' ).css('display', 'inline-block');
															}
														}
														else{
															$( '#logo1_up_validate' ).hide();
														}
														if($('#divlogo2:visible').length != 0){

															if($(logoo2).hasClass("croppedImg")){
															$( '#logo2_up_validate' ).hide();
															}
															else{
																$( '#logo2_up_validate' ).css('display', 'inline-block');
															}
														}
														else{
															$( '#logo2_up_validate' ).hide();
														}


													}
													else if(theme_ele[i]=='varimg' || theme_ele[i]=='horimg'){

														var vertical_validate = $("#slideshow img").hasClass("croppedImg");

														if($('#varimg:visible').length == 0){

															vertical_validate = true;

														}

														var horizontal_validate = $("#slideshow1 img").hasClass("croppedImg");

														if($('#horimg:visible').length == 0){
															horizontal_validate = true;
														}


														if($('input[name=verticle_img]:not(#vari):checked').length){
															vertical_validate = true;

														}

														if($('input[name=horizontal_img]:not(#hori):checked').length){
															horizontal_validate = true;

														}

														if(vertical_validate){
															$( '#varimg_validate' ).hide();
														}
														else{
															$( '#varimg_validate' ).css('display', 'inline-block');
														}

														if(horizontal_validate){
															$( '#horimg_validate' ).hide();
														}
														else{
															$( '#horimg_validate' ).css('display', 'inline-block');
														}

													}

													else if(theme_ele[i]=='splash_url'){

														if($('#reurl:visible').length != 0){

															if(this_val!=""){
																$( '#splash_url_validate' ).hide();
															}
															else{

																$( '#splash_url_validate' ).css('display', 'inline-block');
															}
														}
														else{
															$( '#splash_url_validate' ).hide();
														}

													}
													else if(theme_ele[i]=='loading'){
														if ($('#chk1').is(':checked')){
															$( '#loading_validate' ).hide();
														}
														else{
															valid_check(this_val,theme_ele[i]+'_validate');
														}
													}
													else{
														valid_check(this_val,theme_ele[i]+'_validate');
													}

												}
											}

										}

											function valid_check(this_val,err_elem){

												//alert(this_val+" - "+err_elem);

												if(err_elem == 'welcome_validate'){

													if(this_val!="" && this_val!="#aN"){

														var patt = /[-!@#<*>$%^&*()_+|~=`{}\\[\]:";'<>?,.\/]/;
											    		var this_val = patt.test(this_val);

											    		if(this_val){
											    			$('#'+err_elem).html('special characters are not allowed');
											    			$('#'+err_elem).css('display', 'inline-block');
											    		}
											    		else{
											    			$('#'+err_elem).hide();
											    		}
													}
													else{
														$('#'+err_elem).html('This is a required section');
														$('#'+err_elem).css('display', 'inline-block');
													}

												}
												else{

													if(this_val!="" && this_val!="#aN"){
														$('#'+err_elem).hide();
													}
													else{
														$('#'+err_elem).css('display', 'inline-block');
													}

												}



												ck_topval();

											}

											function check_logo_valid(txt_ele,err_elem){

												if ($('#'+txt_ele).prop("disabled") == false) {

												if($('#'+txt_ele).val()!=""){
													$('#'+err_elem).hide();
												}
												else{
													$('#'+err_elem).css('display', 'inline-block');
												}

												}
												else{
													$('#'+err_elem).hide();
												}
											}

								    $(function () {

										$('#logo_1_text').on('input', function () {
											check_logo_valid('logo_1_text','logo_1_text_validate');
										});
										$('#logo_2_text').on('input', function () {
											check_logo_valid('logo_2_text','logo_2_text_validate');
										});

								        $("#logo_txt2_enable").click(function () {

											$("#logo2_up img").remove();

								            if ($(this).is(":checked")) {

								            	$('#logo_2_text').attr('disabled', false);
								            	document.getElementById("logo_2_text").required = true;
								            	$('#divlogo2').hide();
								            	document.getElementById("image_2_name").required = false;
								            	document.getElementById("image_2_name").value = "";




								            } else {

								            	document.getElementById("logo_2_text").required = false;
								            	$('#logo_2_text').attr('disabled', true);
								            	document.getElementById("logo_2_text").value = "";
								            	$('#divlogo2').show();
								            	document.getElementById("image_2_name").required = true;
								            }

											check_logo_valid('logo_2_text','logo_2_text_validate');

								        });
								    });

								</script>


								
<script type="text/javascript">

$( document ).ready(function() {

	/*$('#assing_property').multiSelect();*/
	

});



</script>
