<div <?php if(isset($subtab9_1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guestnet_tab_9_1">


    <!--    <h2>Setting Passcodes</h2> -->







    <form id="bulk_tab5_form2" name="bulk_tab5_form2" method="post" action="?t=9_1" class="form-horizontal" autocomplete="off">

        <fieldset>

            <!-- <b><c style="font-size:24px;">Automated Passcode</c></b>&nbsp;&nbsp;&nbsp;




                                            <div class="toggle1">

                                            <input class="hide_checkbox" <?php //if($auto_status=='1') echo "  checked   "?>  id="auto_passcode" type="checkbox">

                                            <?php // if($auto_status=='1'){ ?>

                                            <span class="toggle1-on">ON</span>
                                            <a id="auto_passcode_link"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>

                                            <?php //}else{ ?>
                                                <a id="auto_passcode_link"> <span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                                            <span class="toggle1-off">OFF</span>

                                            <?php // } ?>

                                            </div>



                                            <br>
                                            <br> -->
            <script>
                function changePasscodeA_bulk(value) {
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
                            changePasscodeA_bulk("off");
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
                            changePasscodeA_bulk("on");
                        });
                    });
                </script>

            <?php } ?>

            <!-- ////////// -->

            <p><strong>Step 1.</strong> You may choose to create an optional passcode "prefix" that will be added to the beginning of your generated passcode. This prefix will be added to the beginning of your automatically generated passcodes and helps make the passcode more readable. </p>

            <p>
                The prefix can be a maximum of 16 characters consisting of numbers, letters, and the characters: $ ! # @.
            </p>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <label class="control-label" for="bulk_prefix">Prefix</label>
                <div class="controls col-lg-5 form-group">
                    <input type="text" class="span4 form-control" name="bulk_prefix" id="bulk_prefix" maxlength="16" >
                    <small id="bulk_prefix_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_prefix" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                </div>
            </div>


            <script type="text/javascript">

                $('#bulk_prefix').bind("cut copy paste",function(e) {
                    e.preventDefault();
                });

                $("#bulk_prefix").keypress(function(event){
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

                $("#bulk_prefix").keyup(function(event) {
                    var prefix;
                    prefix = $('#bulk_prefix').val();
                    var lastChar = prefix.substr(prefix.length - 1);
                    var lastCharCode = lastChar.charCodeAt(0);

                    if (!(( lastCharCode == 8 ||lastCharCode == 0 ||lastCharCode == 36 ||lastCharCode == 33 ||lastCharCode == 64 ||lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                        (65 <= lastCharCode && lastCharCode <= 90) ||
                        (97 <= lastCharCode && lastCharCode <= 122))) {
                        $("#bulk_prefix").val(prefix.substring(0, prefix.length - 1));
                    }

                    bulk_priflenchange();
                });


            </script>


            <script type="text/javascript">

                function bulk_priflenchange(){
                    //alert("inprifchan");

                    $('#bulk_passcode_length').empty();

                    var prefix = document.getElementById('prefix').value;
                    var le=32-prefix.length;

                    var les=8-prefix.length;

                    if(les<1){
                        les=1;
                    }

                    $("#bulk_passcode_length").append('<option value=""> Select Length </option>');

                    for (i = les; i <= le; i++) {
                        $("#bulk_passcode_length").append('<option value="'+i+'">'+i+'</option>');
                    }


                }



            </script>


            <p><strong>Step 2. </strong>Select how long you’d like your auto-generated passcode to be. The total length of your passcode (prefix + auto-generated) may not exceed 32 characters.</strong></p>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <div class="controls col-lg-5 form-group">

                    <select name="bulk_passcode_length" id="bulk_passcode_length" class="span4 form-control" >

                        <option value="">Select Length</option>

                        <?php
                        for($i=8;$i<33;$i++){

                            echo '<option value="'.$i.'">'.$i.'</option>';

                        }

                        ?>



                    </select>
                    <small id="bulk_passcode_length_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>


                </div>
            </div>

            <p><strong>Step 3. </strong>Select the time of day you would like for your passcode to be renewed.
            </p>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <div class="controls col-lg-5 form-group">

                    <input class="span4 form-control" id="passcode_start_date" name="passcode_start_date"
                           type="text" value="<?php //echo $ses_time_start_date; ?>" placeholder="mm/dd/yyyy">
                    <br>
                    <br>

                    <select name="bulk_passcode_renewal_time" id="bulk_passcode_renewal_time" class="span4 form-control">

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
                    <small id="bulk_passcode_renewal_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>


                </div>
            </div>


            <p><strong>
                    Step 4. </strong>Select how often you would like for your passcode to be renewed. Choose from the preset options below or choose a customized frequency in days.

            </p>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <div class="controls col-lg-5 form-group">
                    <div class="net_div">
                        <!-- <div class="net_div_child">
                            <input type="radio" class="fixfreequency frequency" name="bulk_default_frequency" id="bulk_default_frequency1" value="Daily" style="display: inline-block">Daily&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="net_div_child">
                            <input type="radio" class="fixfreequency frequency" name="bulk_default_frequency" id="bulk_default_frequency2" value="Weekly" style="display: inline-block">Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        </div>
                        <div class="net_div">
                        <div class="net_div_child">
                            <input type="radio" class="fixfreequency frequency" name="bulk_default_frequency" id="bulk_default_frequency3" value="Bi-weekly" style="display: inline-block">Bi-Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="net_div_child">
                            <input type="radio" class="fixfreequency frequency" name="bulk_default_frequency" id="bulk_default_frequency4" value="Monthly" style="display: inline-block">Monthly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div> -->
                        <div class="net_div_child">
                            <input maxlength="2" max="60" type="text" class="span1" name="bulk_custom_frequency_val" id="bulk_custom_frequency_val"  style="display: inline-block">
                            <small id="bulk_frequency_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                            <small id="bulk_frequency_er1_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p> Values starting with 0 are not valid.Valid values are 1-60</p></small>

                            <script>
                                $("#bulk_custom_frequency_val").keypress(function(event){
                                    var ew = event.which;
                                    if(ew==8 || ew==0)
                                        return true;
                                    if(48 <= ew && ew <= 57)
                                        return true;

                                    return false;
                                });
                                $("#bulk_custom_frequency_val").keyup(function(){
                                    var value_p = document.getElementById("bulk_custom_frequency_val").value;
                                    //alert(value_p);
                                    if(value_p > 60){
                                        $('#bulk_frequency_er1_msg').css("display", "inline-block");
                                        //$('#bulk_frequency_er1_msg').css("display", "none");
                                    }else{
                                        $('#bulk_frequency_er1_msg').css("display", "none")
                                    }

                                });
                            </script>
                        </div>
                        <div class="net_div_child">
                            <select name="bulk_custom_frequency" id="bulk_custom_frequency" class="span2 form-control">

                                <option value="Days">Days</option>
                                <option value="Hours">Hours</option>
                                <option value="Minutes">Minutes</option>


                                ?>

                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!--   <p><strong> </strong>or set a customized frequency</p>
               <div class="control-group" id="feild_gp_taddg_divt1">
                   <div class="controls col-lg-5 form-group">
                       <input type="number" class="span1" min="1" name="bulk_custom_frequency" id="bulk_custom_frequency"  style="display: inline-block">&nbsp;Days
                   </div>
               </div> -->

            <!--  <p><strong>Step 5. </strong> Your Automated Passcode will expire at the same time of day that the generation was enabled. You may choose to add an additional Passcode Expiration Buffer that will increase the amount of time that the expiring passcode remains valid past the time the generation was enabled.
             </p>

             <p>
                 For example, if your passcode is generated at 10:30 AM with a generation frequency of weekly, that passcode will expire at 10:30 AM on the 7th day. If you added a Passcode Expiration Buffer of 8 hours, the old passcode would still be valid for 8 hours after the new passcode is generated.
             </p>
             <div class="control-group" id="feild_gp_taddg_divt1">
                 <label class="control-label" for="gt_mvnx">Passcode Expiration Buffer</label>
                 <div class="controls col-lg-5 form-group">
                     <input maxlength="2" type="text" class="span1" name="bulk_buffer_time" id="bulk_buffer_time" style="display: inline-block">&nbsp;Hours
                     <small id="bulk_buffer_time_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>Values starting with 0 are not valid. Valid values are 1-24</p></small>
                     <script>
                         $("#bulk_buffer_time").keypress(function(event){
                             var ew = event.which;
                             if(ew==8 || ew==0)
                                 return true;
                             if(48 <= ew && ew <= 57)
                                 return true;

                             return false;
                         });
                     </script>

                 </div>
             </div> -->

            <p><strong>Step 5. </strong>
            </p>


            <div class="control-group" id="feild_gp_taddg_divt1">
                <label class="control-label" for="gt_mvnx">Number of Passcodes </label>
                <div class="controls col-lg-5 form-group">
                    <input maxlength="3" max="100" type="text" class="span1" name="bulk_Passcodes_no" id="bulk_Passcodes_no" style="display: inline-block">
                    <small id="bulk_pass_no_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>Values starting with 0 are not valid. Valid values are 1-100</p></small>
                    <script>
                        $("#bulk_Passcodes_no").keypress(function(event){
                            var ew = event.which;
                            if(ew==8 || ew==0)
                                return true;
                            if(48 <= ew && ew <= 57)
                                return true;

                            return false;
                        });

                        $("#bulk_Passcodes_no").keyup(function(){
                            var value_p = document.getElementById("bulk_Passcodes_no").value;
                            //alert(value_p);
                            if(value_p > 100){
                                $('#bulk_pass_no_er_msg').css("display", "inline-block");
                                //$('#bulk_frequency_er1_msg').css("display", "none");
                            }else{
                                $('#bulk_pass_no_er_msg').css("display", "none")
                            }

                        });
                    </script>

                </div>
            </div>

            <p><strong>Step 6. </strong>Enter the email address you would like to use for Automated Passcode delivery. If you would like to change the delivery email or add an additional email recipient at a later date, you may update it below.
            </p>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <label class="control-label" for="gt_mvnx">Set Email</label>
                <div class="controls col-lg-5 form-group">
                    <input type="text" class="span4 form-control" name="bulk_set_mail" id="bulk_set_mail">
                    <small id="bulk_set_mail_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"></small>
                </div>

            </div>
            <script>
                $(document).ready(function(){
                    $('#bulk_set_mail').bind("cut copy paste",function(e) {
                        e.preventDefault();
                    });
                });
            </script>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <label class="control-label" for="gt_mvnx">Validate Email</label>
                <div class="controls col-lg-5 form-group">
                    <input type="text" class="span4 form-control" name="bulk_validate_mail" id="bulk_validate_mail">
                    <small id="bulk_validate_mail_er1_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                    <!-- <small id="bulk_validate_mail_er2_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>The email addresses you entered do not match</p></small> -->
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#bulk_validate_mail').bind("cut copy paste",function(e) {
                        e.preventDefault();
                    });
                });
            </script>

        </fieldset>

        <div class="form-actions">
            <input type="hidden" name="bulk_auto_pass_secret" value="<?php echo$secret ?>">
            <button type="submit" name="bulk_auto_pass_submit" id="bulk_auto_pass_submit" class="btn btn-primary">Set Bulk Passcodes</button>

        </div>


        <script>

            function bulk_check_prev(x){

                var net_ele = new Array("passcode_len","passcode_renewal", "frequency","buffer" ,"mail1","mail2");

                /* if(x=='prefix'){
                       x='passcode_len';
                }
*/
                var a = net_ele.indexOf(x);

                if(x=='mail1'){
                    $('#bulk_validate_mail').val('');
                    $('#bulk_validate_mail_er1_msg').css("display", "none");
                    //$('#bulk_validate_mail_er2_msg').css("display", "none");
                }


                for (i = 0; i <= parseInt(a); i++) {

                    var ab = net_ele[i];

                    bulk_CheckValues(ab);
                }

            }

            function bulk_CheckValues(element)
            {
                var error=0;

                if(element=='prefix'){

                    $('#bulk_prefix_er_msg').css("display", "none");

                    if($("#bulk_prefix").val() == ''){

                        $('#bulk_prefix_er_msg').css("display", "inline-block");

                    }
                }



                // set button disabled
                // $('#bulk_auto_pass_submit').attr("disabled", true);

                // email regex
                var reg2 = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


                // check first mail set
                var setMail = $("#bulk_set_mail").val();


                if(setMail==''){
                    error++;
                }else if(setMail.length>128){
                    error++;
                    if(element=='mail1'){

                        $('#bulk_set_mail_er_msg').html('<p>This field value is too long</p>');

                        $('#bulk_set_mail_er_msg').css("display", "inline-block");
                    }
                }else{
                    if (!reg2.test(setMail)) {

                        if(element=='mail1'){

                            $('#bulk_set_mail_er_msg').html('<p>This is not a valid email address</p>');
                            $('#bulk_set_mail_er_msg').css("display", "inline-block");
                        }
                        error++

                    }else{
                        if(element=='mail1') {
                            $('#bulk_set_mail_er_msg').css("display", "none");
                        }
                    }
                }



                //check first mail  === second mail
                var bulk_validate_mail = $('#bulk_validate_mail').val();
                if(bulk_validate_mail!=''){

                    if(setMail===bulk_validate_mail){
                        if(element=='mail2') {
                            $('#bulk_validate_mail_er1_msg').css("display", "none");
                            //$('#bulk_validate_mail_er2_msg').css("display", "none");
                        }
                    }
                    else{
                        if(element=='mail2') {
                            //$('#bulk_validate_mail_er1_msg').css("display", "none");
                            $('#bulk_validate_mail_er1_msg').html('<p>The email addresses you entered do not match</p>');
                            $('#bulk_validate_mail_er1_msg').css("display", "inline-block");
                        }
                        error++;
                    }
                }else{
                    if(element=='mail2') {
                        $('#bulk_validate_mail_er1_msg').html('<p>This is a required field</p>');
                        //$('#bulk_validate_mail_er2_msg').css("display", "none");
                        $('#bulk_validate_mail_er1_msg').css("display", "inline-block");
                    }
                    error++;
                }

                // check frquency set
                var cus_freq = $("#bulk_custom_frequency").val();
                //alert(cus_freq);
                if( $('input[name=bulk_default_frequency]:checked').val()!=undefined || cus_freq !='') {
                    //1-24 validate regex
                    if(cus_freq !=''){
                        var reg3 = /^[1-9][0-9][0-9]$|^[1-9][0-9]$|^[1-9]$/;
                        if (reg3.test(cus_freq)) {
                            if (element == 'frequency') {
                                $('#bulk_frequency_er1_msg').css("display", "none");
                                $('#bulk_frequency_er_msg').css("display", "none");
                            }
                        } else {
                            if (element == 'frequency') {
                                $('#bulk_frequency_er1_msg').css("display", "inline-block");
                                $('#bulk_frequency_er_msg').css("display", "none");
                            }
                            error++;
                        }
                    }else{
                        if (element == 'frequency') {
                            $('#bulk_frequency_er1_msg').css("display", "none");
                            $('#bulk_frequency_er_msg').css("display", "none");
                        }
                    }
                }else{
                    if(element=='frequency') {
                        $('#bulk_frequency_er_msg').css("display", "inline-block");
                        $('#bulk_frequency_er1_msg').css("display", "none");
                    }
                    //$('#bulk_auto_pass_submit').attr("disabled", true);
                    error++;
                }


                //1-24 validate regex
                var reg1 = /^[1-9]$|^1[0-9]$|^2[0-4]$/;

                var bulk_buffer_time = $('#bulk_buffer_time').val();

                if(bulk_buffer_time!=''){
                    if (!reg1.test(bulk_buffer_time)) {

                        //alert('false');
                        if(element=='buffer') {

                            $('#bulk_buffer_time_er_msg').css("display", "inline-block");
                        }
                        error++;

                    }else{

                        //alert('true');
                        if(element=='buffer') {
                            $('#bulk_buffer_time_er_msg').css("display", "none");
                        }
                    }
                }else{
                    if(element=='buffer') {
                        $('#bulk_buffer_time_er_msg').css("display", "none");
                    }
                }


                var bulk_passcode_length = $('#bulk_passcode_length').val();
                //alert(bulk_passcode_length);


                if(bulk_passcode_length==''){
                    if(element=='passcode_len') {
                        $('#bulk_passcode_length_er_msg').css("display", "inline-block");
                    }

                    error++;

                }else{
                    if(element=='passcode_len') {
                        $('#bulk_passcode_length_er_msg').css("display", "none");
                    }
                }


                var bulk_passcode_renewal_time = $('#bulk_passcode_renewal_time').val();


                if(bulk_passcode_renewal_time==''){
                    if(element=='passcode_renewal') {
                        //alert();

                        $('#bulk_passcode_renewal_er_msg').css("display", "inline-block");
                    }

                    error++;

                }else{
                    if(element=='passcode_renewal') {
                        $('#bulk_passcode_renewal_er_msg').css("display", "none");
                    }
                }

                if(error==0){

                    //$('#bulk_auto_pass_submit').attr("disabled", false);
                }


            }



            $(document).ready(function(){


                //$('#bulk_auto_pass_submit').attr("disabled", true);





                $(".frequency").click(function(e){


                    //var res = e.target.id.split('_');

                    $("#bulk_custom_frequency").val(null);

                    bulk_check_prev('frequency');

                });

                $("#bulk_custom_frequency").change(function(e){
                    //var res = e.target.id.split('_');

                    $("#bulk_default_frequency1").prop('checked', false);
                    $("#bulk_default_frequency2").prop('checked', false);
                    $("#bulk_default_frequency3").prop('checked', false);
                    $("#bulk_default_frequency4").prop('checked', false);

                    bulk_check_prev('frequency');

                });

                $("#bulk_custom_frequency").keyup(function(e){
                    $("#bulk_default_frequency1").prop('checked', false);
                    $("#bulk_default_frequency2").prop('checked', false);
                    $("#bulk_default_frequency3").prop('checked', false);
                    $("#bulk_default_frequency4").prop('checked', false);

                    bulk_check_prev('frequency');
                });


                $("#bulk_set_mail").keyup(function(e){
                    bulk_check_prev('mail1');
                });
                $("#bulk_validate_mail").keyup(function(e){
                    bulk_check_prev('mail2');
                });

                $("#bulk_set_mail").on("change",function(e){
                    bulk_check_prev('mail1');
                });
                $("#bulk_validate_mail").on("change",function(e){
                    bulk_check_prev('mail2');
                });
                $("#bulk_buffer_time").on("change",function(e){
                    bulk_check_prev('buffer');
                });

                $("#bulk_buffer_time").on("keyup",function(e){
                    bulk_check_prev('buffer');
                });
                $("#bulk_prefix").on("change",function(e){
                    bulk_check_prev('prefix');
                });

                $("#bulk_prefix").on("keyup",function(e){
                    bulk_check_prev('prefix');
                });
                $("#bulk_passcode_length").on("change",function(e){
                    bulk_check_prev('passcode_len');
                });

                $("#bulk_passcode_renewal_time").on("change",function(e){
                    bulk_check_prev('passcode_renewal');
                });


            });
        </script>



    </form>





    <hr/>


    <!-- <form method="post" action="?t=9_1" id="bulk_auto_passcode_email_update" name="bulk_auto_passcode_email_update" class="form-horizontal" autocomplete="off">


                                                <h2>Update Automated Passcode Delivery Email:</h2>

                                                <p>
                                                    If you would like to update the email address used for Automated Passcode delivery, enter the new email address below. If you would like to add another email address to receive your Automated Passcodes, select "Add Secondary Email" below.
                                                </p>

                                                <fieldset>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">New Email</label>
                                                        <div class="controls col-lg-5 form-group" id="bulk_update_mail_parent">
                                                            <input type="text" class="span4 form-control" name="bulk_update_mail" id="bulk_update_mail">
                                                        </div>
                                                    </div>
                                                    <script>
                                                    $(document).ready(function(){
                                                     $('#bulk_update_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Validate New Email</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="bulk_validate_update_mail" id="bulk_validate_update_mail">

                                                        </div>
                                                    </div>
<script>
                                                    $(document).ready(function(){
                                                     $('#bulk_validate_update_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>
                                                    </fieldset>

                                                    <?php
    /* $mail_count=0;
    $auto_passcode_q1="SELECT * FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`IN('Auto','Buffer')";
            $auto_passcode_q_res1=mysql_query($auto_passcode_q1);
            while($auto_passcode_details1=mysql_fetch_assoc($auto_passcode_q_res1)){
                $secemail_jary1 = $auto_passcode_details1['secondry_email'];
                $secmails_array1=json_decode($secemail_jary1);

            $mail_count = sizeof($secmails_array1);
                    }
*/
    ?>

                                                    <div class="form-actions">
                                                        <input type="hidden" name="bulk_auto_pass_emailup_secret" value="<?php echo$secret ?>">
                                                        <button type="submit" name="bulk_auto_pass_email_update" onclick="pa_up(0);" id="bulk_auto_pass_email_update" value="0" class="btn btn-primary">Update Primary Email</button>

                                                        <?php //if($mail_count < 5 ){ ?>

                                                        <button type="submit" name="bulk_auto_pass_email_update" onclick="pa_up(1);" id="bulk_auto_pass_sec_add" value="1" class="btn btn-danger inline-btn">Add Secondary Email</button>

                                                        <?php //} ?>

                                                        <script type="text/javascript">
                                                            $(document).ready(function(){
                                                                function updatemailcheck(action) {

                                                                    if(action=='mail1'){
                                                                        $('#bulk_validate_update_mail').val('');
                                                                    }

                                                                    $('#bulk_auto_pass_email_update').attr("disabled", true);
                                                                    $('#bulk_auto_pass_sec_add').attr("disabled", true);

                                                                    var count = $('#bulk_tblAutomaticPasscodes tbody tr').length;
                                                                    //alert(count);
                                                                    if(count<1){
                                                                        return;
                                                                    }

                                                                    if($('#bulk_update_mail').val()!=''){
                                                                        if(($('#bulk_update_mail').val()==$('#bulk_validate_update_mail').val()) && !($("#bulk_update_mail_parent").hasClass("has-error")) ){
                                                                            $('#bulk_auto_pass_email_update').attr("disabled", false);
                                                                            $('#bulk_auto_pass_sec_add').attr("disabled", false);
                                                                        }
                                                                    }
                                                                }

                                                                updatemailcheck();

                                                                $('#bulk_update_mail').keyup(function (e) {
                                                                    updatemailcheck('mail1');
                                                                });
                                                                $('#bulk_validate_update_mail').keyup(function (e) {
                                                                    updatemailcheck('mail2');
                                                                    //$('#bulk_auto_passcode_email_update').bootstrapValidator('validate');
                                                                });

                                                            });


                                                            function pa_up(v){

                                                                //alert(v);

                                                                $('input[name="bulk_auto_pass_email_update"]').val(v);


                                                                }

                                                        </script>
                                                    </div>

                                            </form> -->


    <div class="widget widget-table action-table">
        <div class="widget-header">
            <!-- <i class="icon-th-list"></i> -->
            <h3>Active Passcode</h3>
        </div>

        <div class="widget-content table_response " id="product_tbl">
            <div style="overflow-x:auto;" >
                <table id="bulk_tblAutomaticPasscodes" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                    <thead>

                    <tr>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Number of Passcode</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Email</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Frequency</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Valid From</th>

                        <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Buffer</th> -->
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Renewal Date</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Expiry Date</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Donload</th>
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
                                                            FROM `exp_customer_bulk_vouchers`
                                                            WHERE `reference`='$user_distributor' ";
                    $auto_passcode_q_res=$db->selectDB($auto_passcode_q);
                    
                    foreach ($auto_passcode_q_res['data'] AS $auto_passcode_details) {
                        // $prof_id=$auto_passcode_details['id'];
                        //`voucher_number``frequency``start_date``buffer_duration``refresh_date`
                        if($auto_passcode_details['frequency']!="Daily" && $auto_passcode_details['frequency']!="Weekly" && $auto_passcode_details['frequency']!="Bi-weekly" && $auto_passcode_details['frequency']!="Monthly"){
                            $frequency_scale="Days";
                        }else{
                            $frequency_scale="";
                        }
                        echo "<tr><td>".$auto_passcode_details['voucher_no']."</td>";
                        echo "<td>".$auto_passcode_details['email']."</td>";

                        /* echo "<td>".strtolower($auto_passcode_details['reference_email']).' (Primary)';

                        $secemail_jary = $auto_passcode_details['secondry_email'];
                        $secmails_array=json_decode($secemail_jary);

                        foreach($secmails_array as $value){
                            echo '<br/>'.strtolower($value).' '.'<a href="?t=9&rmv_sc=1&rm_sc_mail='.$value.'"><img src="img/trash-ico.png" style="max-height:20px;max-width;20px;"></a>';

                        }

                        echo "</td>"; */

                        echo "<td>".$auto_passcode_details['frequency']." ".$frequency_scale."</td>";

                        $start_date = $auto_passcode_details[st_date];
                        $refresh_date = $auto_passcode_details[en_date];
                        $expire_date = $auto_passcode_details[ex_date];
                        $bulk_id = $auto_passcode_details[bulk_id];

                        $bulk_down_key_string = "task=bulk_passcode&bulk_id=".$bulk_id;
                        $bulk_down_key =  cryptoJsAesEncrypt($data_secret,$bulk_down_key_string);
                        $bulk_down_key =  urlencode($bulk_down_key);


                        echo "<td>".$start_date."</td>";
                        /*  echo "<td>".$auto_passcode_details['buffer_duration']."  Hours</td>"; */

                        echo "<td>".$refresh_date." </td>";
                        echo "<td>".$expire_date." </td>";
                        echo "<td><a href='ajax/export_customer.php?key=".$bulk_down_key."'>Download</a></td>";
                        echo "<td>".$dis_time_zone." </td></tr>";


                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
