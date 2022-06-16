<script>
 /* set guest profile*/
 $(document).ready(function() {
       

    $('#auto_pass_submit').easyconfirm({locale: {
        title: 'Automated Passcode',
        text: 'Are you sure you want to update this Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
        button: ['Cancel',' Confirm'],
        closeText: 'close'
    }});
    $('#auto_pass_submit').click(function() {

    });


    });
    </script>

<div <?php if(isset($tab_guest_passcode)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guest_passcode">
    <?php if(isset($_SESSION['tab9'])){
        echo $_SESSION['tab9'];
        unset($_SESSION['tab9']);
    } ?>
    <?php if ($tooltip_enable=='Yes') { ?>

        <h1 class="head container">Setting Passcodes <img data-toggle="tooltip" title="<?php echo $tooltip_arr['Passcode']; ?>" src="layout/FRONTIER/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" ></h1>
        <!-- <p><b><i>&nbsp;&nbsp;&nbsp;&nbsp;So your guests can easily identify and connect</i></b></p> -->
    <?php } else{ ?>
        <h1 class="head container">Setting Passcodes</h1>
    <?php }?>



    <p>
        If you would like to restrict access to your Guest <?php echo __WIFI_TEXT__; ?> Network, you can set a passcode.<br/><br/>
    </p>

    <?php
    if ($ori_user_type!='SALES') {

        $manual_status=$db->getValueAsf("SELECT `voucher_status` AS f FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`='Manual'");
        $auto_status=$db->getValueAsf("SELECT `voucher_status` AS f FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`='Auto'");
    }
    else{
        $manual_status=$_SESSION['manual_status'];
        $auto_status=$_SESSION['auto_status'];
    }

    ?>

    <!-- ////////////// -->



    <!-- <select name="location">
        <?php
        // $key_query1 = "SELECT DISTINCT id,tag_name FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor' ORDER BY tag_name ASC";

        // $query_results1=mysql_query($key_query1);

        // while ($tag = mysql_fetch_assoc($query_results1)){
            ?>
            <option value="<?php //$tag['id']; ?>"><?php //echo$tag['tag_name']; ?></option>
        <?php //} ?>
    </select>


    <br>
    <br> -->



    <b><c style="font-size:24px;">Manual Passcode Option</c></b>&nbsp;&nbsp;&nbsp;
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


    <br>
    <br>

    <script>
        function changePasscodeM(value) {
            if(value=='on'){
                window.location ='?change_passcode=true&t=guest_passcode&manual_passcode=1&secret=<?php echo $secret; ?>';
            }else{
                window.location ='?change_passcode=true&t=guest_passcode&manual_passcode=0&secret=<?php echo $secret; ?>';
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


    <form id="tab5_form1" onkeyup="footer_submitfn();" onchange="footer_submitfn();" name="tab5_form1" method="post" action="?t=guest_passcode" class="form-horizontal" autocomplete="off">

        <fieldset>

            <p>
                Your passcode must be between 8-32 characters, and
                you may enter a combination of numbers, letters, and the characters: $ ! # @.
            </p>

            <p>
                Your passcode remains valid until you replace it with a new passcode.
            </p>
            <br>

            <div class="control-group" id="feild_gp_taddg_divt">
                <label class="control-label" for="gt_mvnx">Passcode Prefix</label>
                <div class="controls col-lg-5 form-group">
                    <input type="text" name="passcode_number" maxlength="32" id="passcode_number" class="span2" required value="<?php
                    echo$passcode=$db->getValueAsf("SELECT `voucher_number` AS f FROM `exp_customer_vouchers` WHERE `voucher_type` = 'DISTRIBUTOR' AND reference = '$user_distributor' AND `type`='Manual'");
                    ?>">
                    <button type="submit" name="passcode_submit" id="passcode_submit"  class="btn btn-primary" disabled="disabled">Set Manual Passcode</button>

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
        </fieldset>
    </form>




    <form id="tab5_form2" name="tab5_form2" method="post" action="?t=guest_passcode" class="form-horizontal" autocomplete="off">

        <fieldset>

            <b><c style="font-size:24px;">Automated Passcode Option</c></b>&nbsp;&nbsp;&nbsp;
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



            <br class="mobile-hide">
            <br>
            <script>
                function changePasscodeA(value) {
                    /*var value=$('#auto_passcode:checked').val();*/
                    /*alert(value);*/
                    if(value=='on'){
                        window.location ='?change_passcode&t=guest_passcode&auto_passcode=1&secret=<?php echo $secret; ?>';
                    }else{
                        window.location ='?change_passcode&t=guest_passcode&auto_passcode=0&secret=<?php echo $secret; ?>';
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

            <p>Create an optional passcode prefix that will be added to the beginning of randomly generated characters that will be attached to your prefix characters. </p>

            <p>
                The prefix can be a maximum of 16 characters consisting of numbers, letters, and the characters: $ ! # @.
            </p>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <label class="control-label" for="prefix">Passcode Prefix</label>
                <div class="controls col-lg-5 form-group">
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
                <label class="control-label" for="gt_mvnx">Number of characters in passcode</label>
                <div class="controls col-lg-5 form-group">

                    <select name="passcode_length" id="passcode_length" class="span4 form-control" >

                        <option value="">Select between 8 & 32 characters</option>

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
                <label class="control-label" for="gt_mvnx">Time of day the new passcode is refreshed</label>
                <div class="controls col-lg-5 form-group">

                    <select name="passcode_renewal_time" id="passcode_renewal_time" class="span4 form-control">

                        <option value="">Select time of day</option>

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


            <p>How often would you like your passcode refreshed?

            </p>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <div class="controls col-lg-5 form-group">
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

            <p>By default, your automated passcode will expire at the same time of day that you choose to refresh with a new automated passcode.  You may choose to add an additional buffer that will increase the amount of time that the expiring passcode remains valid past the time the generation was enabled.
            </p>

            <div class="control-group" id="feild_gp_taddg_divt1">
                <label class="control-label" for="gt_mvnx">Passcode Expiration Buffer</label>
                <div class="controls col-lg-5 form-group">
                    <input maxlength="2" type="text" class="span1" name="buffer_time" id="buffer_time" style="display: inline-block">&nbsp;hours
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

            <p>Please enter the email address you would like the automated passcodes to be sent. </p>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <label class="control-label" for="gt_mvnx">Passcode delivery email address</label>
                <div class="controls col-lg-5 form-group">
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
                <label class="control-label" for="gt_mvnx">Validate email address</label>
                <div class="controls col-lg-5 form-group">
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

                var net_ele = new Array("passcode_len","passcode_renewal", "frequency","buffer" ,"mail1","mail2");

                /* if(x=='prefix'){
                       x='passcode_len';
                }
*/
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


    <form method="post" action="?t=guest_passcode" id="auto_passcode_email_update" name="auto_passcode_email_update" class="form-horizontal" autocomplete="off" style="margin-bottom: 45px;">


        <h2>Update Automated Passcode Delivery Email:</h2> <br>

        <p>
            If you would like to update the email address used for Automated Passcode delivery, enter the new email address below and click, “update primary email.” If you would like to add an addition email address to receive your Automated Passcodes, click "Add Secondary Email" below.
        </p>

        <fieldset>
            <div class="control-group" id="feild_gp_taddg_divt1">
                <label class="control-label" for="gt_mvnx">New email address</label>
                <div class="controls col-lg-5 form-group" id="update_mail_parent">
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
                <label class="control-label" for="gt_mvnx">Validate email address</label>
                <div class="controls col-lg-5 form-group">
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
        $auto_passcode_q_res1=$db->selectDB($auto_passcode_q1);
        
        foreach ($auto_passcode_q_res1['data'] AS $auto_passcode_details1) {
            $secemail_jary1 = $auto_passcode_details1['secondry_email'];
            $secmails_array1=json_decode($secemail_jary1);

            $mail_count = sizeof($secmails_array1);
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
                    $auto_passcode_q_res=$db->selectDB($auto_passcode_q);
                   
                    foreach ($auto_passcode_q_res['data'] AS $auto_passcode_details) {
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
                            echo '<br/>'.strtolower($value).' '.'<a href="?t=guest_passcode&rmv_sc=1&rm_sc_mail='.$value.'"><img src="img/trash-ico.png" style="max-height:20px;max-width;20px;"></a>';

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