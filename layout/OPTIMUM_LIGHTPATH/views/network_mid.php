
<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />

<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />

<style type="text/css">

@media (max-width: 480px){
    #feild_gp_taddg_divt1 .form-group .net_div{
        width: 100%;
    }

    #feild_gp_taddg_divt1 .net_div .net_div_child:nth-child(1){
            width: 50%;
    margin-bottom: 10px;
    }

}

label img{
        margin-left: 10px;
}

</style>


 <?php
                                        /**
                                         * 3/25/2016 9:30:01 AM
                                         * alert if sync now success or failed
                                         */


                                        if(isset($_SESSION['tab7'])){
                                            echo$_SESSION['tab7'];
                                            unset($_SESSION['tab7']);
                                        }


                                         if(isset($_SESSION['tab2'])){
                                             echo $_SESSION['tab2'];
                                             unset($_SESSION['tab2']);
                                                }

                                            if(isset($_SESSION['tab9'])){
                                                echo$_SESSION['tab9'];
                                                unset($_SESSION['tab9']);
                                            }

                                           /* if(isset($_SESSION['tab15'])){
                                            echo$_SESSION['tab15'];
                                            unset($_SESSION['tab15']);
                                        }*/

                                            ?>


<?php if(in_array("NET_GUEST_PASSCODE",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($subtab9)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guestnet_tab_9">


                                             <h1 class="head">
                                             An extra layer of security:
add a passcode to your splash page.<img data-toggle="tooltip" title="If you would like to restrict access to your Guest WiFi Network, you can select the passcode splash page theme. You have two options for setting passcodes:
1. Manual Passcode: Select this option to set a passcode that does not change and is valid until you replace it with a new one.
2. Automated Passcode: Select this option to allow the system to generate and deliver a unique passcode to emails of your choice on a predefined schedule." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
                                             </h1>
<p style="margin-bottom: 40px; margin-top: -60px;">
<b>Note:</b> If manual or automated passcode is activated your current active theme will be changed into a passcode theme.
In case there is no active theme you must create or activate a passcode theme. </p>

<br>

                                         <!--    <h2>Setting Passcodes</h2>
                                            <p>
                                               If you would like to restrict access to your Guest WiFi Network, you can set a passcode. You have two options for setting passcodes:<br/><br/>
                                                <strong>1. Manual Passcode:</strong> Select this option to set a passcode that does not change and is valid until you replace it with a new one.
                                            </p>
                                            <p>
                                                <strong>2. Automated Passcode:</strong> Select this option to allow the system to generate and deliver a unique passcode on a predefined schedule.
                                            </p> -->
                                            <?php
                                            if ($ori_user_type!='SALES') {
                                            $isthemeactive=$db->getValueAsf("SELECT `theme_id` AS f FROM `exp_themes` WHERE `distributor`='$user_distributor' AND `is_enable`='1'");

                                            $manual_status=$db->getValueAsf("SELECT `voucher_status` AS f FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`='Manual'");
                                            $auto_status=$db->getValueAsf("SELECT `voucher_status` AS f FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`='Auto'");
                                        }
                                        else{
                                            $manual_status=$_SESSION['manual_status'];
                                            $auto_status=$_SESSION['auto_status'];
                                        }

                                            ?>

                                             <div class="control-group form-horizontal">

                                                        <div class="controls col-lg-5 form-group">


                                            <b><c style="font-size:24px;">Manual Passcode</c></b>&nbsp;&nbsp;&nbsp;
                                            <!-- ////////////// -->



                                             <div class="toggle1">

                                             <input class="hide_checkbox" <?php if($manual_status=='1') echo "  checked   "?>  id="manual_passcode" type="checkbox">

                                             <?php if($manual_status=='1'){ ?>

                                             <span class="toggle1-on">ON</span>
                                             <a id="manual_passcode_link"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>

                                             <?php }else{ ?>
                                                <a id="manual_passcode_link"><span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                                             <span class="toggle1-off">OFF</span>

                                             <?php } ?>

                                            </div>

                                        </div>
                                    </div>




                                            <script>
                                                function changePasscodeM(value) {
                                                    /*var value=$('#manual_passcode:checked').val();*/
                                                    /*alert(value);*/
                                                    if(value=='on'){
                                                        window.location ='?change_passcode=true&t=9&manual_passcode=1&secret=<?php echo $secret; ?>';
                                                    }else{
                                                        window.location ='?change_passcode=true&t=9&manual_passcode=0&secret=<?php echo $secret; ?>';
                                                    }
                                                }
                                            </script>

                                            <?php if($manual_status=='1'){ ?>
                                            <script type="text/javascript">

                                            $(document).ready(function() {
                                                $('#manual_passcode_link').easyconfirm({locale: {
                                                    title: 'Manual Passcode',
                                                    text: 'Are you sure you want to disable the Manual Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#manual_passcode_link').click(function() {
                                                    changePasscodeM("off");
                                                });
                                            });
                                            </script>
                                            <?php }else{ ?>

                                            <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('#manual_passcode_link').easyconfirm({locale: {
                                                    title: 'Manual Passcode',
                                                    text: 'Are you sure you want to enable the Manual Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#manual_passcode_link').click(function() {
                                                    changePasscodeM("on");
                                                });
                                            });
                                            </script>

                                            <?php } ?>

                                            <!-- //////////////////// -->


                                            <form id="tab5_form1" onkeyup="footer_submitfn();" onchange="footer_submitfn();" name="tab5_form1" method="post" action="?t=9" class="form-horizontal" autocomplete="off">

                                                <fieldset>


                                                <br>

                                                    <div class="control-group" id="feild_gp_taddg_divt">

                                                        <div class="controls col-lg-5 form-group">

                                                            <label class="" for="gt_mvnx">Passcode<img data-toggle="tooltip" title="Choose your Manual Passcode. Your passcode must be between 8-32 characters and
                                                you may enter a combination of numbers, letters, and the characters: $ ! # @. Your Manual Passcode remains valid until you replace it with a new passcode." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                                            <input type="text" name="passcode_number" maxlength="32" id="passcode_number" class="span4" required value="<?php
                                                            echo$passcode=$db->getValueAsf("SELECT `voucher_number` AS f FROM `exp_customer_vouchers` WHERE `voucher_type` = 'DISTRIBUTOR' AND reference = '$user_distributor' AND `type`='Manual'");
                                                            ?>">


                                                           <script>
														    $('#passcode_number').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                    function footer_submitfn() {
                                                        //alert("fn");
                                                        if($("#passcode_number").val().length>7){
                                                        	$("#passcode_submit").prop('disabled', false);
                                                        }
                                                    }
                                               		 </script>


                                                            <input type="hidden" name="passcode_secret" value="<?php echo $_SESSION['FORM_SECRET'] ?>">
                                                            <script type="text/javascript">
                                                                $("#passcode_number").keypress(function(event){
                                                                    var ew = event.which;
                                                                    /*alert(ew);*/
                                                                    if(ew == 33 || ew == 35 || ew == 36 || ew ==  64 || ew==8 || ew==0 )
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;
                                                                    if(65 <= ew && ew <= 90)
                                                                        return true;
                                                                    if(97 <= ew && ew <= 122)
                                                                        return true;
                                                                    return false;
                                                                });


                                                                $("#passcode_number").keyup(function(event) {
                                                                    var passcode_number;
                                                                    passcode_number = $('#passcode_number').val();
                                                                    var lastChar = passcode_number.substr(passcode_number.length - 1);
                                                                    var lastCharCode = lastChar.charCodeAt(0);

                                                                    if (!(( lastCharCode == 8 ||lastCharCode == 0 ||lastCharCode == 36 ||lastCharCode == 33 ||lastCharCode == 64 ||lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                                        (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                        (97 <= lastCharCode && lastCharCode <= 122))) {
                                                                        $("#passcode_number").val(passcode_number.substring(0, passcode_number.length - 1));
                                                                    }
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">

                                                        <div class="controls col-lg-5 form-group">
                                                            <button type="submit" name="passcode_submit" id="passcode_submit"  class="btn btn-primary" disabled="disabled" style="margin-left: 0px !important;">Set Manual Passcode</button>
                                                            <?php if (strlen($isthemeactive)<1) {?>
                                                               <!--  <img data-toggle="tooltip" title="" src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 2px;cursor: pointer;"> -->
                                                           <?php } ?>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>




                                            <form id="tab5_form2" name="tab5_form2" method="post" action="?t=9" class="form-horizontal" autocomplete="off">

                                                <fieldset>

<br>
                                                      <div class="control-group form-horizontal">

                                                        <div class="controls col-lg-5 form-group">

                                            <b><c style="font-size:24px;">Automated Passcode</c></b>&nbsp;&nbsp;&nbsp;
<!-- ////////// -->



                                            <div class="toggle1">

                                            <input class="hide_checkbox" <?php if($auto_status=='1') echo "  checked   "?>  id="auto_passcode" type="checkbox">

                                            <?php if($auto_status=='1'){ ?>

                                            <span class="toggle1-on">ON</span>
                                            <a id="auto_passcode_link"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>

                                            <?php }else{ ?>
                                                <a id="auto_passcode_link"> <span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                                            <span class="toggle1-off">OFF</span>

                                            <?php } ?>

                                            </div>

                                           </div>
                                       </div>

                                            <br>
                                            <br>
                                            <script>
                                                function changePasscodeA(value) {
                                                    /*var value=$('#auto_passcode:checked').val();*/
                                                    /*alert(value);*/
                                                    if(value=='on'){
                                                        window.location ='?change_passcode&t=9&auto_passcode=1&secret=<?php echo $secret; ?>';
                                                    }else{
                                                        window.location ='?change_passcode&t=9&auto_passcode=0&secret=<?php echo $secret; ?>';
                                                    }
                                                }
                                            </script>
                                            <?php if($auto_status=='1'){ ?>
                                            <script type="text/javascript">

                                            $(document).ready(function() {
                                                $('#auto_passcode_link').easyconfirm({locale: {
                                                    title: 'Automated Passcode',
                                                    text: 'Are you sure you want to disable Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#auto_passcode_link').click(function() {
                                                    changePasscodeA("off");
                                                });
                                            });
                                            </script>
                                            <?php }else{ ?>

                                            <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('#auto_passcode_link').easyconfirm({locale: {
                                                    title: 'Automated Passcode',
                                                    text: 'Are you sure you want to enable Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#auto_passcode_link').click(function() {
                                                    changePasscodeA("on");
                                                });
                                            });
                                            </script>

                                            <?php } ?>

<!-- ////////// -->


                                                    <div class="control-group" id="feild_gp_taddg_divt1">

                                                        <div class="controls col-lg-5 form-group">

                                                            <label class="" for="prefix">Prefix<img data-toggle="tooltip" title='[Optional] You may choose to create an optional passcode "prefix" that will be added to the beginning of your generated passcode. This prefix will be added to the beginning of your automatically generated passcodes and helps make the passcode more readable. The prefix can be a maximum of 16 characters consisting of numbers, letters, and the characters: $ ! # @.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                                            <input type="text" class="span4 form-control" name="prefix" id="prefix" maxlength="16" >


                                                            <small id="prefix_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="prefix" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                        </div>
                                                    </div>


                                                            <script type="text/javascript">

                                                            $('#prefix').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                $("#prefix").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;
                                                                    if(65 <= ew && ew <= 90)
                                                                        return true;
                                                                    if(97 <= ew && ew <= 122)
                                                                        return true;
                                                                    return false;
                                                                });

                                                                $("#prefix").keyup(function(event) {
                                                                    var prefix;
                                                                    prefix = $('#prefix').val();
                                                                    var lastChar = prefix.substr(prefix.length - 1);
                                                                    var lastCharCode = lastChar.charCodeAt(0);

                                                                    if (!(( lastCharCode == 8 ||lastCharCode == 0 ||lastCharCode == 36 ||lastCharCode == 33 ||lastCharCode == 64 ||lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                                        (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                        (97 <= lastCharCode && lastCharCode <= 122))) {
                                                                        $("#prefix").val(prefix.substring(0, prefix.length - 1));
                                                                    }

                                                                    priflenchange();
                                                                });


                                                            </script>


                                            <script type="text/javascript">

                                            function priflenchange(){
                                                //alert("inprifchan");

                                            	$('#passcode_length').empty();

                                            	var prefix = document.getElementById('prefix').value;
                                                var le=32-prefix.length;

                                                var les=8-prefix.length;

                                                if(les<1){
                                                	les=1;
                                                    }

                                                $("#passcode_length").append('<option value=""> Select Length </option>');

                                                for (i = les; i <= le; i++) {
                                                	$("#passcode_length").append('<option value="'+i+'">'+i+'</option>');
                                                }


                                            }



                                            </script>



                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">

                                                            <label class="" for="prefix">Password length<img data-toggle="tooltip" title="Select how long you’d like your auto-generated passcode to be. The total length of your passcode (prefix + auto-generated) may not exceed 32 characters." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

																	<select name="passcode_length" id="passcode_length" class="span4 form-control" >

																	<option value="">Select Length</option>

																	<?php
																	for($i=8;$i<33;$i++){

																	echo '<option value="'.$i.'">'.$i.'</option>';

																	}

																	?>



																	</select>

                                                            <small id="passcode_length_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>


                                                        </div>
                                                    </div>


                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">

                                                             <label class="" for="prefix">Passcode delivery time<img data-toggle="tooltip" title="Select the time of day you would like your passcode to be renewed. An email with the new passcode will be sent out at the time selected to the emails defined below." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

																	<select name="passcode_renewal_time" id="passcode_renewal_time" class="span4 form-control">

																	<option value="">Select Time</option>

																	<?php
                                                                    $dt = new DateTime('GMT');
                                                                    $dt->setTime(0, 0);
                                                                    echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                    for($i=0;$i<95;$i++){
                                                                        $dt->add(new DateInterval('PT15M'));
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                    }

																	?>

																	</select>
                                                            <small id="passcode_renewal_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>


                                                        </div>
                                                    </div>


                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">

                                                            <label class="" for="prefix">Change Frequency  <img data-toggle="tooltip" title="Select how often you would like for your passcode to be renewed. Choose from the preset options below or choose a customized frequency in days." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"> </label>

                                                        <div class="net_div">
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="default_frequency" id="default_frequency1" value="Daily" style="display: inline-block">Daily&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="default_frequency" id="default_frequency2" value="Weekly" style="display: inline-block">Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        </div>
                                                        <div class="net_div">
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="default_frequency" id="default_frequency3" value="Bi-weekly" style="display: inline-block">Bi-Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="default_frequency" id="default_frequency4" value="Monthly" style="display: inline-block">Monthly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="net_div_child">
                                                            <input maxlength="3" type="text" class="span1" name="custom_frequency" id="custom_frequency"  style="display: inline-block">&nbsp;Days
                                                            <small id="frequency_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                            <small id="frequency_er1_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>Values starting with 0 are not valid. Valid values are 1-999</p></small>

                                                            <script>
                                                                $("#custom_frequency").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew==8 || ew==0)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;

                                                                    return false;
                                                                });
                                                            </script>
                                                        </div>
                                                        </div>
                                                        </div>
                                                    </div>

                                                 <!--   <p><strong> </strong>or set a customized frequency</p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="number" class="span1" min="1" name="custom_frequency" id="custom_frequency"  style="display: inline-block">&nbsp;Days
                                                        </div>
                                                    </div> -->


                                                    <div class="control-group" id="feild_gp_taddg_divt1">

                                                        <div class="controls col-lg-5 form-group">

                                                             <label class="" for="gt_mvnx">Passcode Expiration Buffer <img data-toggle="tooltip" title="[Optional] Your Automated Passcode will expire at the same time of day that the generation was enabled. You may choose to add an additional Passcode Expiration Buffer that will increase the amount of time that the expiring passcode remains valid past the time the generation was enabled. For example, if your passcode is generated at 10:30 AM with a generation frequency of weekly, that passcode will expire at 10:30 AM on the 7th day. If you added a Passcode Expiration Buffer of 8 hours, the old passcode would still be valid for 8 hours after the new passcode is generated." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"> </label>

                                                            <input maxlength="2" type="text" class="span1" name="buffer_time" id="buffer_time" style="display: inline-block">&nbsp;Hours
                                                            <small id="buffer_time_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>Values starting with 0 are not valid. Valid values are 1-24</p></small>
                                                            <script>
                                                                $("#buffer_time").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew==8 || ew==0)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;

                                                                    return false;
                                                                });
                                                            </script>

                                                        </div>
                                                    </div>


                                                    <div class="control-group" id="feild_gp_taddg_divt1">

                                                        <div class="controls col-lg-5 form-group">
                                                            <label class="" for="gt_mvnx">Set Email<img data-toggle="tooltip" title="Enter the email address you would like to use for Automated Passcode delivery. If you would like to change the delivery email or add an additional email recipient at a later date, you may update it below.  " src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                                            <input type="text" class="span4 form-control" name="set_mail" id="set_mail">
                                                            <small id="set_mail_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"></small>
                                                        </div>

                                                    </div>
                                                    <script>
                                                    $(document).ready(function(){
  													 $('#set_mail').bind("cut copy paste",function(e) {
    													  e.preventDefault();
 														 });
															});
                                                    </script>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">

                                                        <div class="controls col-lg-5 form-group">

                                                            <label class="" for="gt_mvnx">Validate Email</label>

                                                            <input type="text" class="span4 form-control" name="validate_mail" id="validate_mail">
                                                            <small id="validate_mail_er1_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                            <!-- <small id="validate_mail_er2_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>The email addresses you entered do not match</p></small> -->
                                                        </div>
                                                    </div>
                                                     <script>
                                                    $(document).ready(function(){
  													 $('#validate_mail').bind("cut copy paste",function(e) {
    													  e.preventDefault();
 														 });
															});
                                                    </script>

                                                    </fieldset>

                                                    <div class="form-actions">
                                                        <input type="hidden" name="auto_pass_secret" value="<?php echo$secret ?>">
                                                        <button type="submit" name="auto_pass_submit" id="auto_pass_submit" class="btn btn-primary">Set Automated Passcode</button>

                                                    </div>


                                                <script>

                                                    function check_prev(x){

                                                        var net_ele = new Array("prefix", "passcode_len","passcode_renewal", "frequency","buffer" ,"mail1","mail2");

                                                        if(x=='prefix'){
                                                               x='passcode_len';
                                                        }

                                                        var a = net_ele.indexOf(x);

                                                        if(x=='mail1'){
                                                                $('#validate_mail').val('');
                                                                $('#validate_mail_er1_msg').css("display", "none");
                                                                //$('#validate_mail_er2_msg').css("display", "none");
                                                        }


                                                        for (i = 0; i <= parseInt(a); i++) {

                                                            var ab = net_ele[i];

                                                            CheckValues(ab);
                                                        }

                                                    }

                                                    function CheckValues(element)
                                                        {
                                                            var error=0;

                                                            if(element=='prefix'){

                                                                $('#prefix_er_msg').css("display", "none");

                                                                if($("#prefix").val() == ''){

                                                                    $('#prefix_er_msg').css("display", "inline-block");

                                                                }
                                                            }



                                                            // set button disabled
                                                            $('#auto_pass_submit').attr("disabled", true);

                                                            // email regex
                                                            var reg2 = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


                                                            // check first mail set
                                                            var setMail = $("#set_mail").val();


                                                            if(setMail==''){
                                                                error++;
                                                            }else if(setMail.length>128){
                                                            error++;
                                                                if(element=='mail1'){

                                                                    $('#set_mail_er_msg').html('<p>This field value is too long</p>');

                                                                    $('#set_mail_er_msg').css("display", "inline-block");
                                                                }
                                                        }else{
                                                                if (!reg2.test(setMail)) {

                                                                    if(element=='mail1'){

                                                                        $('#set_mail_er_msg').html('<p>This is not a valid email address</p>');
                                                                        $('#set_mail_er_msg').css("display", "inline-block");
                                                                    }
                                                                    error++

                                                                }else{
                                                                    if(element=='mail1') {
                                                                        $('#set_mail_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }



                                                            //check first mail  === second mail
                                                            var validate_mail = $('#validate_mail').val();
                                                            if(validate_mail!=''){

                                                                if(setMail===validate_mail){
                                                                    if(element=='mail2') {
                                                                        $('#validate_mail_er1_msg').css("display", "none");
                                                                        //$('#validate_mail_er2_msg').css("display", "none");
                                                                    }
                                                                }
                                                                else{
                                                                    if(element=='mail2') {
                                                                        //$('#validate_mail_er1_msg').css("display", "none");
                                                                        $('#validate_mail_er1_msg').html('<p>The email addresses you entered do not match</p>');
                                                                        $('#validate_mail_er1_msg').css("display", "inline-block");
                                                                    }
                                                                    error++;
                                                                }
                                                            }else{
                                                                if(element=='mail2') {
                                                                    $('#validate_mail_er1_msg').html('<p>This is a required field</p>');
                                                                    //$('#validate_mail_er2_msg').css("display", "none");
                                                                    $('#validate_mail_er1_msg').css("display", "inline-block");
                                                                }
                                                                error++;
                                                            }

                                                            // check frquency set
                                                            var cus_freq = $("#custom_frequency").val();
                                                            //alert(cus_freq);
                                                            if( $('input[name=default_frequency]:checked').val()!=undefined || cus_freq !='') {
                                                                //1-24 validate regex
                                                                if(cus_freq !=''){
                                                                    var reg3 = /^[1-9][0-9][0-9]$|^[1-9][0-9]$|^[1-9]$/;
                                                                    if (reg3.test(cus_freq)) {
                                                                        if (element == 'frequency') {
                                                                            $('#frequency_er1_msg').css("display", "none");
                                                                            $('#frequency_er_msg').css("display", "none");
                                                                        }
                                                                    } else {
                                                                        if (element == 'frequency') {
                                                                            $('#frequency_er1_msg').css("display", "inline-block");
                                                                            $('#frequency_er_msg').css("display", "none");
                                                                        }
                                                                        error++;
                                                                    }
                                                                }else{
                                                                    if (element == 'frequency') {
                                                                        $('#frequency_er1_msg').css("display", "none");
                                                                        $('#frequency_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }else{
                                                                if(element=='frequency') {
                                                                    $('#frequency_er_msg').css("display", "inline-block");
                                                                    $('#frequency_er1_msg').css("display", "none");
                                                                }
                                                                //$('#auto_pass_submit').attr("disabled", true);
                                                                error++;
                                                            }


                                                            //1-24 validate regex
                                                            var reg1 = /^[1-9]$|^1[0-9]$|^2[0-4]$/;

                                                            var buffer_time = $('#buffer_time').val();

                                                            if(buffer_time!=''){
                                                                if (!reg1.test(buffer_time)) {

                                                                    //alert('false');
                                                                    if(element=='buffer') {

                                                                        $('#buffer_time_er_msg').css("display", "inline-block");
                                                                    }
                                                                    error++;

                                                                }else{

                                                                    //alert('true');
                                                                    if(element=='buffer') {
                                                                        $('#buffer_time_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }else{
                                                                if(element=='buffer') {
                                                                    $('#buffer_time_er_msg').css("display", "none");
                                                                }
                                                            }


                                                            var passcode_length = $('#passcode_length').val();
                                                            //alert(passcode_length);


                                                            if(passcode_length==''){
                                                                if(element=='passcode_len') {
                                                                    $('#passcode_length_er_msg').css("display", "inline-block");
                                                                }

                                                                error++;

                                                            }else{
                                                                if(element=='passcode_len') {
                                                                    $('#passcode_length_er_msg').css("display", "none");
                                                                }
                                                            }


                                                            var passcode_renewal_time = $('#passcode_renewal_time').val();


                                                            if(passcode_renewal_time==''){
                                                                if(element=='passcode_renewal') {
                                                                    //alert();

                                                                    $('#passcode_renewal_er_msg').css("display", "inline-block");
                                                                }

                                                                error++;

                                                            }else{
                                                                if(element=='passcode_renewal') {
                                                                    $('#passcode_renewal_er_msg').css("display", "none");
                                                                }
                                                            }

                                                            if(error==0){

                                                                $('#auto_pass_submit').attr("disabled", false);
                                                            }


                                                        }



                                                    $(document).ready(function(){


                                                        $('#auto_pass_submit').attr("disabled", true);





                                                        $(".frequency").click(function(e){


                                                            //var res = e.target.id.split('_');

                                                            $("#custom_frequency").val(null);

                                                            check_prev('frequency');

                                                        });

                                                        $("#custom_frequency").change(function(e){
                                                            //var res = e.target.id.split('_');

                                                            $("#default_frequency1").prop('checked', false);
                                                            $("#default_frequency2").prop('checked', false);
                                                            $("#default_frequency3").prop('checked', false);
                                                            $("#default_frequency4").prop('checked', false);

                                                            check_prev('frequency');

                                                        });

                                                        $("#custom_frequency").keyup(function(e){
                                                            $("#default_frequency1").prop('checked', false);
                                                            $("#default_frequency2").prop('checked', false);
                                                            $("#default_frequency3").prop('checked', false);
                                                            $("#default_frequency4").prop('checked', false);

                                                            check_prev('frequency');
                                                        });


                                                        $("#set_mail").keyup(function(e){
                                                            check_prev('mail1');
                                                        });
                                                        $("#validate_mail").keyup(function(e){
                                                            check_prev('mail2');
                                                        });

                                                        $("#set_mail").on("change",function(e){
                                                            check_prev('mail1');
                                                        });
                                                        $("#validate_mail").on("change",function(e){
                                                            check_prev('mail2');
                                                        });
                                                        $("#buffer_time").on("change",function(e){
                                                            check_prev('buffer');
                                                        });

                                                        $("#buffer_time").on("keyup",function(e){
                                                            check_prev('buffer');
                                                        });
                                                        $("#prefix").on("change",function(e){
                                                            check_prev('prefix');
                                                        });

                                                        $("#prefix").on("keyup",function(e){
                                                            check_prev('prefix');
                                                        });
                                                        $("#passcode_length").on("change",function(e){
                                                            check_prev('passcode_len');
                                                        });

                                                        $("#passcode_renewal_time").on("change",function(e){
                                                            check_prev('passcode_renewal');
                                                        });


                                                    });
                                                </script>



                                            </form>





<hr/>


                                            <form method="post" action="?t=9" id="auto_passcode_email_update" name="auto_passcode_email_update" class="form-horizontal" autocomplete="off">


                                                <div class="control-group">

                                                        <div class="controls col-lg-5 form-group">

                                                            <h2>Update Automated Passcode Delivery Email:</h2>
                                                        </div>
                                                </div>


                                                <fieldset>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">

                                                        <div class="controls col-lg-5 form-group" id="update_mail_parent">

                                                            <label class="" for="gt_mvnx">New Email <img data-toggle="tooltip" title='If you would like to update the email address used for Automated Passcode delivery, enter the new email address below. If you would like to add another email address to receive your Automated Passcodes, select "Add Secondary Email" below.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                                            <input type="text" class="span4 form-control" name="update_mail" id="update_mail">
                                                        </div>
                                                    </div>
                                                    <script>
                                                    $(document).ready(function(){
  													 $('#update_mail').bind("cut copy paste",function(e) {
    													  e.preventDefault();
 														 });
															});
                                                    </script>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">

                                                        <div class="controls col-lg-5 form-group">

                                                            <label class="" for="gt_mvnx">Validate New Email</label>

                                                            <input type="text" class="span4 form-control" name="validate_update_mail" id="validate_update_mail">

                                                        </div>
                                                    </div>
<script>
                                                    $(document).ready(function(){
  													 $('#validate_update_mail').bind("cut copy paste",function(e) {
    													  e.preventDefault();
 														 });
															});
                                                    </script>
                                                    </fieldset>

                                                    <?php
													$mail_count=0;
                                                    $auto_passcode_q1="SELECT * FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`IN('Auto','Buffer')";
                                                            $auto_passcode_q_res1=mysql_query($auto_passcode_q1);
                                                            while($auto_passcode_details1=mysql_fetch_assoc($auto_passcode_q_res1)){
																$secemail_jary1 = $auto_passcode_details1['secondry_email'];
                                                                $secmails_array1=json_decode($secemail_jary1);

															$mail_count	= sizeof($secmails_array1);
																	}

													?>

                                                    <div class="form-actions">
                                                        <input type="hidden" name="auto_pass_emailup_secret" value="<?php echo$secret ?>">
                                                        <button type="submit" name="auto_pass_email_update" onclick="pa_up(0);" id="auto_pass_email_update" value="0" class="btn btn-primary">Update Primary Email</button>

                                                        <?php if($mail_count < 5 ){ ?>

                                                        <button type="submit" name="auto_pass_email_update" onclick="pa_up(1);" id="auto_pass_sec_add" value="1" class="btn btn-danger inline-btn">Add Secondary Email</button>

                                                        <?php } ?>

                                                        <script type="text/javascript">
                                                            $(document).ready(function(){
                                                                function updatemailcheck(action) {

                                                                    if(action=='mail1'){
                                                                        $('#validate_update_mail').val('');
                                                                    }

                                                                    $('#auto_pass_email_update').attr("disabled", true);
                                                                    $('#auto_pass_sec_add').attr("disabled", true);

                                                                    var count = $('#tblAutomaticPasscodes tbody tr').length;
                                                                    //alert(count);
                                                                    if(count<1){
                                                                        return;
                                                                    }

                                                                    if($('#update_mail').val()!=''){
                                                                        if(($('#update_mail').val()==$('#validate_update_mail').val()) && !($("#update_mail_parent").hasClass("has-error")) ){
                                                                            $('#auto_pass_email_update').attr("disabled", false);
                                                                            $('#auto_pass_sec_add').attr("disabled", false);
                                                                        }
                                                                    }
                                                                }

                                                                updatemailcheck();

                                                                $('#update_mail').keyup(function (e) {
                                                                    updatemailcheck('mail1');
                                                                });
                                                                $('#validate_update_mail').keyup(function (e) {
                                                                    updatemailcheck('mail2');
                                                                    //$('#auto_passcode_email_update').bootstrapValidator('validate');
                                                                });

                                                            });


                                                            function pa_up(v){

                                                            	//alert(v);

                                                            	$('input[name="auto_pass_email_update"]').val(v);


                                                                }

                                                        </script>
                                                    </div>

                                            </form>


                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Active Passcode</h3>
                                                </div>

                                                <div class="widget-content table_response " id="product_tbl">
                                                    <div style="overflow-x:auto;" >
                                                        <table id="tblAutomaticPasscodes" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Passcode</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Email</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Frequency</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Valid From</th>

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Buffer</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Renewal Date</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Expiry Date</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Time Zone</th>


                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                            <?php


                                                            $offset_val=$db->getValueAsf("SELECT `offset_val` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");


                                                            $auto_passcode_q="SELECT *,
                                                            DATE_FORMAT(CONVERT_TZ(start_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS st_date,
                                                            DATE_FORMAT(CONVERT_TZ(refresh_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS en_date,
                                                            DATE_FORMAT(CONVERT_TZ(expire_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS ex_date
                                                            FROM `exp_customer_vouchers`
                                                            WHERE `reference`='$user_distributor' AND `type`IN('Auto','Buffer')";
                                                            $auto_passcode_q_res=mysql_query($auto_passcode_q);
                                                            while($auto_passcode_details=mysql_fetch_assoc($auto_passcode_q_res)){
                                                               // $prof_id=$auto_passcode_details['id'];
                                                                //`voucher_number``frequency``start_date``buffer_duration``refresh_date`
                                                                if($auto_passcode_details['frequency']!="Daily" && $auto_passcode_details['frequency']!="Weekly" && $auto_passcode_details['frequency']!="Bi-weekly" && $auto_passcode_details['frequency']!="Monthly"){
                                                                    $frequency_scale="Days";
                                                                }else{
                                                                    $frequency_scale="";
                                                                }
                                                                echo "<tr><td>".$auto_passcode_details['voucher_number']."</td>";

                                                                echo "<td>".strtolower($auto_passcode_details['reference_email']).' (Primary)';

                                                                $secemail_jary = $auto_passcode_details['secondry_email'];
                                                                $secmails_array=json_decode($secemail_jary);

                                                                foreach($secmails_array as $value){
                                                                	echo '<br/>'.strtolower($value).' '.'<a href="?t=9&rmv_sc=1&rm_sc_mail='.$value.'"><img src="img/trash-ico.png" style="max-height:20px;max-width;20px;"></a>';

                                                                }

                                                                echo "</td>";

                                                                echo "<td>".$auto_passcode_details['frequency']." ".$frequency_scale."</td>";

                                                                $start_date = $auto_passcode_details[st_date];
                                                                $refresh_date = $auto_passcode_details[en_date];
                                                                $expire_date = $auto_passcode_details[ex_date];
                                                                echo "<td>".$start_date."</td>";
                                                                echo "<td>".$auto_passcode_details['buffer_duration']."  Hours</td>";

                                                                echo "<td>".$refresh_date." </td>";
                                                                echo "<td>".$expire_date." </td>";
                                                                echo "<td>".$dis_time_zone." </td></tr>";


                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <?php  if(in_array("NET_GUEST_INTRO",$features_array) || $package_features=="all"){?>
                                              <div style="font-size: medium" <?php if(isset($subtab8)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_intruduct">


 <?php echo $message_functions->getPageContent('guest_wifi_introduction_content',$system_package);?>




                                                  </div>
                                        <?php } ?>
                                        <?php  if(in_array("NET_GUEST_SSID",$features_array) || $package_features=="all"){?>
                                          <div <?php if(isset($subtab7)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_1">
                                        <!-- Tab 1 start-->


                                        <h1 class="head">
    It is your business, so let the SSID show it. <img data-toggle="tooltip" title="Your account comes with a default SSID name. This name can be changed to fit your business. Name your network so your guests can easily identify and connect. " src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>






                                        <div id="guest_modify_network"></div>



                                              <div style="display: none" class='alert alert-danger all_na'><button type='button' class='close' data-dismiss='alert'>�</button><strong>


                                              <?php echo $message_functions->showMessage('no_aps_installed'); ?>

                                              </strong>
                                        </div>



                                              <form id="update_default_qos_table" name="update_default_qos_table" class="form-horizontal" action="?t=7" method="post">

                                                  <div class="widget widget-table action-table" >

                                                     <?php if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='NO' ) {

                                              ?>

                                            <!-- <div class="controls col-lg-5 form-group">
                                                <a href="?t=7&st=7&action=sync_data_tab1&tocken=<?php// echo $secret; ?>" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                            </div>
                                             <br/>-->
                                              </br>

                                              <?php } ?>

                                                      <div class="widget-header">
                                                          <!-- <i class="icon-th-list"></i> -->
                                                          <h3></h3>
                                                      </div>
                                                    <div class="widget-content table_response" id="ssid_tbl">
                                                        <div style="overflow-x:auto;" >
                                                      <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap >
                                                          <thead>
                                                              <tr>

                                                               <!-- <th>AP MAC Address</th> -->
                                                              <!--    <th>WLAN Name</th>  -->
                                                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Guest SSID</th>
                                                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Location Name</th>
                                                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Service Address</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                          <?php
                                                         /* $ssid_q="SELECT d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.`ssid`,s.`network_id`, l.`group_tag`
                                                                    FROM `exp_locations_ssid` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d,`exp_locations_ap_ssid` l
                                                                  WHERE s.`distributor`=d.`distributor_code`
                                                                  AND s.`distributor`= a.`distributor_code`
                                                                  AND a.`ap_code`=l.`ap_id`
                                                                  AND s.`distributor`='$user_distributor'
																  AND l.`distributor`='$user_distributor'
                                                              --    GROUP  BY  a.`ap_code`
                                                          GROUP  BY   s.`ssid`";  */

                                                          $all_na = '2';

                                                          $ssid_q="SELECT d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.`ssid`,s.`network_id` ,l.`group_tag`,d.bussiness_address1,d.state_region,d.bussiness_address2
                                                                FROM
                                                                `exp_mno_distributor` d
                                                                LEFT JOIN
                                                                `exp_locations_ssid` s
                                                                ON s.`distributor`=d.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_mno_distributor_aps` a
                                                                ON s.`distributor`= a.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_locations_ap_ssid` l
                                                                ON a.`ap_code`=l.`ap_id`

                                                                WHERE  d.`distributor_code`='$user_distributor'
                                                                GROUP  BY   s.`ssid`";
                                                          $ssid_res=mysql_query($ssid_q);
                                                          $i=0;

                                                          if(mysql_num_rows($ssid_res) > 0){

                                                          while($ssid_name=mysql_fetch_assoc($ssid_res)){
                                                           //   echo'<input type="hidden" name="network_id" value="'.$ssid_name['network_id'].'">';
                                                           //   echo'<input type="hidden" name="description" value="'.$ssid_name['description'].'">';
                                                          //    echo "<tr><td>".$ssid_name['ap_code']."</td>";

                                                              $gorup_tag = $ssid_name['group_tag'];

                                                              if(strlen($gorup_tag) < 1){
                                                                  $location_id = 'N/A';
                                                              }else{
                                                                  $location_id = $gorup_tag;
                                                                  $all_na = "0";
                                                              }

                                                            echo  "<td>".$ssid_name['ssid']."</td>";

    														echo	"<td>".$location_id."</td>";
    														echo	"<td>".$ssid_name['bussiness_address1']."&nbsp;,&nbsp;".$ssid_name['bussiness_address2']."&nbsp;".$ssid_name['state_region']."</td>";

                                                             echo "<input type='hidden' name='ap[$i]' value='$ssid_name[ap_code]'/>";

    														echo"</tr>";
                                                            //  $ssidName=$ssid_name['ssid'];
                                                            //  $wlanId=$ssid_name['wlan_name'];


                                                              $i++;
                                                          }

                                                          if($all_na != "0"){

                                                            echo '<style> .all_na{ display: block !important; } </style>';

                                                          }

                                                        }

                                                          ?>
                                                          </tbody>
                                                          </table>
                                                            </div>
                                                  </div>
                                              </div><br/>

                                                      <fieldset>
                                                          <div class="control-group">

                                                              <div class="controls col-lg-5 form-group">


                                                                <label class="" for="ssid_name">Current SSID Name : <img data-toggle="tooltip" title="Select the SSID name you wish to change from the drop-down below. Then, enter the new name of your Guest WiFi Network." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                                                      <select required class="span4 form-control" id="ssid_name" name="ssid_name" <?php echo $ssidName; ?> onchange="loadSSIDForm(this.value)">
                                                                          <option value="">Select SSID</option>
                                                                          <?php
                                                                          $ssid_q="SELECT s.`ssid`
                                                                                    FROM
                                                                                    `exp_mno_distributor` d
                                                                                    LEFT JOIN 
                                                                                    `exp_locations_ssid` s
                                                                                    ON s.`distributor`=d.`distributor_code`
                                                                                    LEFT JOIN
                                                                                    `exp_mno_distributor_aps` a
                                                                                    ON s.`distributor`= a.`distributor_code`
                                                                                    LEFT JOIN
                                                                                    `exp_locations_ap_ssid` l
                                                                                    ON a.`ap_code`=l.`ap_id`

                                                                                    WHERE  d.`distributor_code`='$user_distributor' AND s.ssid<>''
                                                                                    GROUP  BY   s.`ssid`";
                                                                          $ssid_res=mysql_query($ssid_q);
                                                                          while($ssid_names=mysql_fetch_assoc($ssid_res)){
                                                                              echo'<option value="'.$ssid_names[ssid].'">'.$ssid_names[ssid].'</option>';
                                                                          }
                                                                          ?>
                                                                      </select>

                                                                        <a href="?t=7&st=7&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary" style="align: left; margin-top: 5px;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>

                                                                      <script>
                                                                          function loadSSIDForm(ssid){

                                                                            /*  alert(ssid);    */
                                                                              var ssid=ssid;
                                                                              var formData={ssid:ssid,dis:"<?php echo $user_distributor; ?>"};
                                                                              $.ajax({
                                                                                  url : "ajax/getSsidDetails.php",
                                                                                  type: "POST",
                                                                                  data : formData,
                                                                                  success: function(data)
                                                                                  {
                                                                                   /*   alert(data);   */
                                                                                      var data_array = data.split(',');

                                                                                      document.getElementById("network_id").value=data_array[1];
                                                                                      document.getElementById("wlan_name").value=data_array[0];
                                                                                  },
                                                                                  error: function (jqXHR, textStatus, errorThrown)
                                                                                  {

                                                                                  }
                                                                              });



                                                                          }
                                                                      </script>
                                                                      <input  id="wlan_name" name="wlan_name" type="hidden" value="" >
                                                                      <input  id="network_id" name="network_id" type="hidden" value="" >


                                                              </div>
                                                          </div>
                                                          <div class="control-group">

                                                              <div >
                                                                  <div class="controls col-lg-5 form-group">

                                                                    <label class="" for="mod_ssid_name">New SSID Name :   <img data-toggle="tooltip" title='Note: The SSID Name is limited to 32 characters and may include a combination of letters, numbers, and the special characters “_” and “-“ (other special characters are not available for SSID names). The SSID Name cannot start with prohibited words such as “guest,” “administrative,” “admin,” “test,” “demo,” or “production.” These words cannot be used without other descriptive words.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                                                      <input required class="span4 form-control" id="mod_ssid_name" name="mod_ssid_name" type="text" maxlength="32" value="<?php echo ''; ?>">




                                                                      <small id="invalid_ssid" style="display: none;" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>SSID Name is invalid</p></small>

                                                                      <script type="text/javascript">
                                                                          $(document).ready(function () {
                                                                              $('#mod_ssid_name').bind("cut copy paste", function (e) {
                                                                                  e.preventDefault();
                                                                              });


                                                                              $("#mod_ssid_name").keypress(function (event) {
                                                                                  var ew = event.which;
                                                                                  if (ew == 8 || ew == 0 || ew == 45 || ew == 95)
                                                                                      return true;
                                                                                  if (48 <= ew && ew <= 57)
                                                                                      return true;
                                                                                  if (65 <= ew && ew <= 90)
                                                                                      return true;
                                                                                  if (97 <= ew && ew <= 122)
                                                                                      return true;
                                                                                  return false;


                                                                              });

                                                                              $("#mod_ssid_name").blur(function (event) {
                                                                                  var temp_ssid_name = $('#mod_ssid_name').val();
                                                                                  if (checkWords(temp_ssid_name.toLowerCase())) {

                                                                                      $("#mod_ssid_name").val("");
                                                                                      $('#invalid_ssid').css('display', 'inline-block');
                                                                                      $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                      $('#update_ssid').attr('disabled', true);
                                                                                  } else {
                                                                                      $('#invalid_ssid').hide();
                                                                                  }
                                                                              });

                                                                              $("#mod_ssid_name").keyup(function (event) {

                                                                                  var temp_ssid_name;
                                                                                  temp_ssid_name = $('#mod_ssid_name').val();
                                                                                  var lastChar = temp_ssid_name.substr(temp_ssid_name.length - 1);
                                                                                  var lastCharCode = lastChar.charCodeAt(0);

                                                                                  if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 45 || lastCharCode == 95) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                                                      (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                                      (97 <= lastCharCode && lastCharCode <= 122))) {
                                                                                      $("#mod_ssid_name").val(temp_ssid_name.substring(0, temp_ssid_name.length - 1));
                                                                                  }

                                                                                  temp_ssid_name = $('#mod_ssid_name').val();
                                                                                  if (checkWords(temp_ssid_name.toLowerCase())) {

                                                                                      $("#mod_ssid_name").val("");
                                                                                      $('#invalid_ssid').css('display', 'inline-block');
                                                                                      $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                      $('#update_ssid').attr('disabled', true);
                                                                                  } else {
                                                                                      $('#invalid_ssid').hide();
                                                                                  }
                                                                              });


                                                                              function past() {

                                                                                  setTimeout(function () {

                                                                                      var temp_ssid_name = $('#mod_ssid_name').val();


                                                                                      if (checkWords(temp_ssid_name.toLowerCase())) {

                                                                                          $("#mod_ssid_name").val("");
                                                                                          $('#invalid_ssid').css('display', 'inline-block');

                                                                                          $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");

                                                                                          $('#update_ssid').attr('disabled', true);
                                                                                      } else {
                                                                                          $('#invalid_ssid').hide();
                                                                                      }


                                                                                  }, 100);

                                                                              }


                                                                              function checkWords(inword) {

                                                                                  var words =<?php
                                                                                      $words = $db->getValueAsf("SELECT `policies` AS f FROM `exp_policies` WHERE `policy_code`='SSID_name'");
                                                                                      $words_ar = explode(",", $words);
                                                                                      $script_ar = '[';
                                                                                      for ($i = 0; $i < count($words_ar); $i++) {
                                                                                          $script_ar .= "\"" . $words_ar[$i] . "\",";
                                                                                      }

                                                                                      $script_ar = rtrim($script_ar, ",");
                                                                                      $script_ar .= "]";
                                                                                      echo $script_ar;

                                                                                      ?>;

                                                                                  if (words.indexOf(inword) >= 0) {

                                                                                      return true;

                                                                                  }
                                                                                  else {

                                                                                      var regex = /^[a-zA-Z0-9_-]+$/;

                                                                                      if (regex.test(inword) == false) {

                                                                                          $('#update_ssid').attr('disabled', true);
                                                                                      }

                                                                                      return false;

                                                                                  }


                                                                              }
                                                                          });
                                                                      </script>

                                                                  </div>
                                                                  <br>

                                                              </div>
                                                          </div>
                                                          <?php
                                                            if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='YES' || $package_features=="all") {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns">Use
                                                                        Existing Location : </label>

                                                                    <div class="controls col-lg-5 form-group">
                                                                        <div>
                                                                            <select class="span4 form-control" id="old_location_name"
                                                                                    name="old_location_name"
                                                                                    onchange="setNewSSID(this.value)">
                                                                                <option value="">SELECT LOCATION
                                                                                </option>
                                                                                <?php
                                                                                $get_group_tag_q = "SELECT `tag_name` FROM `exp_mno_distributor_group_tag` WHERE `distributor`='$user_distributor' GROUP BY `tag_name`";
                                                                                $get_group_tag_r = mysql_query($get_group_tag_q);
                                                                                while ($get_group_tag = mysql_fetch_assoc($get_group_tag_r)) {
                                                                                    echo '<option value="' . $get_group_tag['tag_name'] . '">' . $get_group_tag['tag_name'] . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select> &nbsp;Or
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <script>
                                                                    function setNewSSID(grout_tag) {
                                                                        if (grout_tag == '') {
                                                                            document.getElementById("location_name").value = '';
                                                                            document.getElementById("location_name").readOnly = false;
                                                                            document.getElementById("loc_label").innerHTML = 'Create a New Location :';
                                                                        } else {
                                                                            document.getElementById("location_name").value = grout_tag;
                                                                            document.getElementById("location_name").readOnly = true;
                                                                            document.getElementById("loc_label").innerHTML = 'Assign Location :';
                                                                        }
                                                                    }
                                                                </script>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns"
                                                                           id="loc_label">Create a New Location
                                                                        : </label>

                                                                    <div>
                                                                        <div class="controls col-lg-5 form-group">
                                                                            <input class="span4 form-control" id="location_name"
                                                                                   name="location_name" type="text"
                                                                                   value="<?php echo ''; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                            }
                                                          ?>

                                                           <div class="form-actions">
                                                          <button type="submit" name="update_ssid" id="update_ssid" class="btn btn-primary">Update</button>

                                                      </div>

                                                      </fieldset>


                                                      <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET'];?>">


                                                  </form>









                                              </div>
                                                <!-- Tab 1 End-->
                                        <?php  }

                                        ?>
                                        <?php if(in_array("NET_GUEST_BANDWITH",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($subtab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guestnet_tab_2">

                                              <h1 class="head">
    Broadcast your SSID,
but on your terms.<img data-toggle="tooltip" title='You can set a broadcast schedule for each of your SSIDs. This means your SSIDs will only be visible to your visitors during the hours you have specified for each day. Ex. your hours of operations. If you select “Always ON” the SSID is visible 24/7, while “Always Off” means the SSID is turned off.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>

                                                  <div class="widget widget-table action-table">
                                                      <div class="widget-header">
                                                          <!-- <i class="icon-th-list"></i> -->
                                                          <h3></h3>
                                                      </div>
                                                      <div class="widget-content table_response" id="ssid_tb2">


                                                          <div style="overflow-x:auto;" >

                                                      <table class="table table-striped table-bordered" >
                                                          <thead>

                                                          <tr>
                                                              <th>Guest SSID</th>
                                                              <th>SSID Status</th>


                                                          </tr>

                                                          </thead>

                                                          <tbody>
                                                          <?php
                                                            if ($ori_user_type!='SALES') {
                                                          $delete_from_schedule_assign="DELETE FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND `network_method`='GUEST'";
                                                          mysql_query($delete_from_schedule_assign);

                                                          $insert_schedule_assign_guest="INSERT INTO `exp_distributor_network_schedul_assign`(`network_id`,`ssid`,`distributor`,`network_method`,`create_date`,`create_user`)
                                                                                          SELECT  `network_id`,`ssid`,`distributor`,'GUEST',NOW(),'system' FROM `exp_locations_ssid` WHERE `distributor`='$user_distributor'";

                                                          mysql_query($insert_schedule_assign_guest);


                                                          $ssid_assign_q="SELECT ssid,ssid_broadcast,network_id FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND network_method='GUEST'";
                                                          $get_private_ssid_res_assign=mysql_query($ssid_assign_q);

                                                          while($row=mysql_fetch_assoc($get_private_ssid_res_assign)){

                                                            $ssid_name_a=$row['ssid'];
                                                            $b_cast=$row['ssid_broadcast'];
                                                            $netid=$row['network_id'];

                                                           // $zone_id = $db->getValueAsf("SELECT `zone_id` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

                                                            $network_sche_data=$wag_obj->retrieveOneNetwork($zone_id,$netid);

                                                            parse_str($network_sche_data);


                                                            $obj = (array)json_decode(urldecode($Description));
                                                            $she_ar=$obj['schedule'];
                                                            $api_ssid = $obj['ssid'];

                                                            $vlan_ar=$obj['vlan'];
                                                            $vl_ar = json_decode(json_encode($vlan_ar), True);
                                                            $vlanac=$vl_ar[accessVlan];



                                                            $data = get_object_vars($she_ar);

                                                          //  $data['type'];

                                                            //$ssid_name_a

                                                              if($data['id']==NULL){
                                                                  $data['id']="";
                                                              }
                                                              // $data['type'];
                                                              $assign_schedule_update="UPDATE `exp_distributor_network_schedul_assign`
                                                                            SET `ssid_broadcast`='".$data['type']."',`shedule_uniqu_id`='".$data['id']."'
                                                                            WHERE `network_id`='$netid' AND `distributor`='$user_distributor'";
                                                              mysql_query($assign_schedule_update);

                                                              echo'<tr><td>'.$ssid_name_a.'</td>';
                                                              echo'<td data-id="'.$netid.'" data-value="'.$data['type'].'">';

                                                              if($data['type']=='Customized'){

                                                                echo 'PowerSchedule';

                                                              }else{

                                                                echo $data['type'];
                                                              }
                                                              echo '</td>';
                                                          


                                                              
                                                              echo '</tr>';

                                                              $vlan_upq="UPDATE `exp_locations_ssid` SET `vlan` = '$vlanac' WHERE `network_id`='$netid'";

                                                              $vlan_upq_exe=mysql_query($vlan_upq);

                                                          }
                                                      }
                                                      else{
                                                        $ssid_assign_q="SELECT ssid,ssid_broadcast,network_id FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND network_method='GUEST'";
                                                          $get_private_ssid_res_assign=mysql_query($ssid_assign_q);

                                                          while($row=mysql_fetch_assoc($get_private_ssid_res_assign)){

                                                            $ssid_name_a=$row['ssid'];
                                                            $b_cast=$row['ssid_broadcast'];
                                                            $netid=$row['network_id'];
                                                        }
                                                        if (strlen($ssid_name_mode)==0) {
                                                            $ssid_name_mode='AlwaysOff';
                                                        }
                                                        echo'<tr><td>'.$ssid_name_a.'</td>';
                                                        echo'<td>'.$ssid_name_mode.'</td>';
                                                        echo '</tr>';
                                                      }
                                                          //echo $vlanac;

                                                          ?>

                                                          </tbody>
                                                          </table>
                                                              </div>
                                                      </div>

                                              </div>



                                              <?php include_once 'layout/'.$camp_layout.'/views/power_schedule_mid.php'; ?>

                                        </div>
                                        <?php
                                        } ?>

<!-- /////////////////////////////////////////// -->

                                     <?php  if(in_array("NET_AP_NAME",$features_array) || $package_features=="all"){?>
                                          <div <?php if(isset($subtab15)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_15">
                                        <!-- Tab 1 start-->

                                        <?php
                                        /**
                                         * 3/25/2016 9:30:01 AM
                                         * alert if sync now success or failed
                                         */
                                        if(isset($_SESSION['tab15'])){
                                            echo$_SESSION['tab15'];
                                            unset($_SESSION['tab15']);
                                        }

                                        ?>




                                        <div id="guest_modify_network"></div>

                                              <h2>SSID Name Modification</h2>
                                              <p><b><i>&nbsp;&nbsp;&nbsp;&nbsp;So your guests can easily identify and connect</i></b></p><br/>

                                              <p>
                                                  <b> Step 1.</b> Review and [optional] modify the SSID Name.
                                                  If this is your first log-in, the SSID shown in the table below is the one provided with your order,
                                                  else it is the name you modified last.
                                                  Note: The Location field is your ICOMS number.

                                              </p>
                                              <b><i>EX. 9th Avenue</i></b>
                                                    <br/>
                                                    <br/>

                                              <?php if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='NO' ) {

                                              ?>

                                            <div class="controls col-lg-5 form-group" style="display:inline-block;">
                                                <a href="?t=15&st=15&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                            </div>
                                             <br/>
                                              </br>

                                              <?php } ?>

                                              <form id="update_default_qos_table" name="update_default_qos_table" class="form-horizontal" action="?t=15" method="post">

                                                  <div class="widget widget-table action-table">
                                                      <div class="widget-header">
                                                          <!-- <i class="icon-th-list"></i> -->
                                                          <h3></h3>
                                                      </div>
                                                    <div class="widget-content table_response" id="ssid_tbl">
                                                        <div style="overflow-x:auto;" >
                                                      <table class="table table-striped table-bordered" >
                                                          <thead>
                                                              <tr>

                                                               <!-- <th>AP MAC Address</th> -->
                                                              <!--    <th>WLAN Name</th>  -->
                                                                  <th>Guest SSID</th>
                                                                  <th>AP Code</th>
                                                                  <th>ICOMS #</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                          <?php
                                                          $ssid_q="SELECT `ap_id`,`location_ssid`,`group_tag`
																		FROM `exp_locations_ap_ssid`
																		WHERE `distributor`='$user_distributor'";
                                                          $ssid_res=mysql_query($ssid_q);
                                                          $i=0;
                                                          while($ssid_name=mysql_fetch_assoc($ssid_res)){
                                                           //   echo'<input type="hidden" name="network_id" value="'.$ssid_name['network_id'].'">';
                                                           //   echo'<input type="hidden" name="description" value="'.$ssid_name['description'].'">';
                                                          //    echo "<tr><td>".$ssid_name['ap_code']."</td>";

                                                            echo "<input type='hidden' name='ap[$i]' value='$ssid_name[ap_code]'/>";

                                                            echo  "<td>".$ssid_name['location_ssid']."</td>";
                                                            echo  "<td>".$ssid_name['ap_id']."</td>";
    														echo	"<td>".$ssid_name['group_tag']."</td></tr>";
                                                            //  $ssidName=$ssid_name['ssid'];
                                                            //  $wlanId=$ssid_name['wlan_name'];


                                                              $i++;
                                                          }

                                                          ?>
                                                          </tbody>
                                                          </table>
                                                            </div>
                                                  </div>
                                              </div><br/>

                                                      <fieldset>
                                                          <div class="control-group">
                                                              <label class="control-label" for="ssid_name">Current SSID Name : </label>
                                                              <div class="controls col-lg-5 form-group">



                                                                      <select required class="span4 form-control" id="ssid_name" name="ssid_name" <?php echo $ssidName; ?> onchange="loadSSIDForm(this.value)">
                                                                          <option value="">Select SSID</option>
                                                                          <?php
                                                                          $ssid_q="SELECT s.`ssid`
                                                                                    FROM `exp_locations_ssid` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d
                                                                                  WHERE s.`distributor`=d.`distributor_code` AND s.`distributor`= a.`distributor_code` AND s.`distributor`='$user_distributor' GROUP BY s.`ssid`";
                                                                          $ssid_res=mysql_query($ssid_q);
                                                                          while($ssid_names=mysql_fetch_assoc($ssid_res)){
                                                                              echo'<option value="'.$ssid_names[ssid].'">'.$ssid_names[ssid].'</option>';
                                                                          }
                                                                          ?>
                                                                      </select>
                                                                      <script>
                                                                          function loadSSIDForm(ssid){
                                                                            /*  alert(ssid);    */
                                                                              var ssid=ssid;
                                                                              var formData={ssid:ssid,dis:"<?php echo $user_distributor; ?>"};
                                                                              $.ajax({
                                                                                  url : "ajax/getSsidDetails.php",
                                                                                  type: "POST",
                                                                                  data : formData,
                                                                                  success: function(data)
                                                                                  {
                                                                                   /*   alert(data);   */
                                                                                      var data_array = data.split(',');

                                                                                      document.getElementById("network_id").value=data_array[1];
                                                                                      document.getElementById("wlan_name").value=data_array[0];
                                                                                  },
                                                                                  error: function (jqXHR, textStatus, errorThrown)
                                                                                  {

                                                                                  }
                                                                              });
                                                                          }
                                                                      </script>
                                                                      <input  id="wlan_name" name="wlan_name" type="hidden" value="" >
                                                                      <input  id="network_id" name="network_id" type="hidden" value="" >


                                                              </div>
                                                          </div>
                                                          <div class="control-group">
                                                              <label class="control-label" for="mod_ssid_name">New SSID Name : </label>
                                                              <div >
                                                                  <div class="controls col-lg-5 form-group">
                                                                      <input required class="span4 form-control" id="mod_ssid_name" name="mod_ssid_name" type="text" value="<?php echo ''; ?>">
                                                                      <script type="text/javascript">

                                                                          $("#mod_ssid_name").keypress(function(event){
                                                                              var ew = event.which;
                                                                              if(ew==8 || ew==0 )
                                                                                  return true;
                                                                              if(48 <= ew && ew <= 57)
                                                                                  return true;
                                                                              if(65 <= ew && ew <= 90)
                                                                                  return true;
                                                                              if(97 <= ew && ew <= 122)
                                                                                  return true;
                                                                              return false;


                                                                          });

                                                                          $("#mod_ssid_name").blur(function(event){
                                                                              var temp_ssid_name=$('#mod_ssid_name').val();
                                                                              if(checkWords(temp_ssid_name.toLowerCase())){

                                                                                  $("#mod_ssid_name").val("");
                                                                                  $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                  $('#update_ssid').attr('disabled', true);
                                                                              }
                                                                          });

                                                                          $("#mod_ssid_name").keyup(function(event){

                                                                              var temp_ssid_name;
                                                                              temp_ssid_name=$('#mod_ssid_name').val();
                                                                              var lastChar = temp_ssid_name.substr(temp_ssid_name.length - 1);
                                                                              var lastCharCode = lastChar.charCodeAt(0);

                                                                              if(!((lastCharCode==8 || lastCharCode==0 )||(48 <= lastCharCode && lastCharCode <= 57) ||
                                                                                  (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                                  (97 <= lastCharCode && lastCharCode <= 122))){
                                                                                  $("#mod_ssid_name").val(temp_ssid_name.substring(0, temp_ssid_name.length-1));
                                                                              }

                                                                              temp_ssid_name=$('#mod_ssid_name').val();
                                                                              if(checkWords(temp_ssid_name.toLowerCase())){

                                                                                  $("#mod_ssid_name").val("");
                                                                                  $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                  $('#update_ssid').attr('disabled', true);
                                                                              }
                                                                          });


                                                                          function past(){

                                                                              setTimeout(function () {

                                                                                  var temp_ssid_name=$('#mod_ssid_name').val();
                                                                                  if(checkWords(temp_ssid_name.toLowerCase())){

                                                                                      $("#mod_ssid_name").val("");
                                                                                      $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                      $('#update_ssid').attr('disabled', true);
                                                                                  }

                                                                              }, 0);

                                                                          }


                                                                          function checkWords(inword){

                                                                              var words =<?php
                                                                                  $words=$db->getValueAsf("SELECT `policies` AS f FROM `exp_policies` WHERE `policy_code`='SSID_name'");
                                                                                  $words_ar=explode(",",$words);
                                                                                  $script_ar='[';
                                                                                  for($i=0;$i<count($words_ar);$i++){
                                                                                      $script_ar.="\"".$words_ar[$i]."\",";
                                                                                  }

                                                                                  $script_ar=rtrim($script_ar,",");
                                                                                  $script_ar.="]";
                                                                                  echo$script_ar;

                                                                                  ?>;

                                                                              if(words.indexOf(inword)>=0)
                                                                                  return true;
                                                                              return false;
                                                                          }
                                                                      </script>

                                                                  </div>
                                                              </div>
                                                          </div>

                                                          <div class="control-group">
                                                              <label class="control-label" for="ssid_name">AP Code : </label>
                                                              <div class="controls col-lg-5 form-group">



                                                                      <select required class="span4 form-control" id="ap_code" name="ap_code">
                                                                          <option value="">SELECT AP</option>
                                                                          <?php
                                                                          $ap_q="SELECT a.`ap_code`
                                                                                    FROM `exp_locations_ssid` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d
                                                                                  WHERE s.`distributor`=d.`distributor_code` AND s.`distributor`= a.`distributor_code` AND s.`distributor`='$user_distributor' GROUP BY a.`ap_code`";
                                                                          $ap_res=mysql_query($ap_q);
                                                                          while($ssid_names=mysql_fetch_assoc($ap_res)){
                                                                              echo'<option value="'.$ssid_names[ap_code].'">'.$ssid_names[ap_code].'</option>';
                                                                          }
                                                                          ?>
                                                                      </select>


                                                              </div>
                                                          </div>


                                                          <?php
                                                            if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='YES' || $package_features=="all") {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns">Use
                                                                        Existing Location : </label>

                                                                    <div class="controls col-lg-5 form-group">
                                                                        <div>
                                                                            <select class="span4 form-control" id="old_location_name"
                                                                                    name="old_location_name"
                                                                                    onchange="setNewSSID1(this.value)">
                                                                                <option value="">SELECT LOCATION
                                                                                </option>
                                                                                <?php
                                                                                $get_group_tag_q = "SELECT `tag_name` FROM `exp_mno_distributor_group_tag` WHERE `distributor`='$user_distributor' GROUP BY `tag_name`";
                                                                                $get_group_tag_r = mysql_query($get_group_tag_q);
                                                                                while ($get_group_tag = mysql_fetch_assoc($get_group_tag_r)) {
                                                                                    echo '<option value="' . $get_group_tag['tag_name'] . '">' . $get_group_tag['tag_name'] . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select> &nbsp;Or
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <script>
                                                                    function setNewSSID1(grout_tag) {
                                                                        if (grout_tag == '') {
                                                                            document.getElementById("location_name1").value = '';
                                                                            document.getElementById("location_name1").readOnly = false;
                                                                            document.getElementById("loc_label1").innerHTML = 'Create a New Location :';
                                                                        } else {
                                                                            document.getElementById("location_name1").value = grout_tag;
                                                                            document.getElementById("location_name1").readOnly = true;
                                                                            document.getElementById("loc_label1").innerHTML = 'Assign Location :';
                                                                        }
                                                                    }
                                                                </script>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns"
                                                                           id="loc_label1">Create a New Location
                                                                        : </label>

                                                                    <div>
                                                                        <div class="controls col-lg-5 form-group">
                                                                            <input class="span4 form-control" id="location_name1"
                                                                                   name="location_name" type="text"
                                                                                   value="<?php echo ''; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                            }
                                                          ?>
                                                      </fieldset>
                                              </br>

                                                      <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET'];?>">
                                                      <div class="form-actions">
                                                          <button type="submit" name="update_ssid_ap" id="update_ssid_ap" class="btn btn-primary">Update</button>
                                                      </div>

                                                  </form>



                                              </div>

                                              <?php
                                                            }
                                                          ?>
