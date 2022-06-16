<script>
    /* set guest profile*/
    $(document).ready(function () {


        $('#auto_pass_submit').easyconfirm({
            locale: {
                title: 'Automated Passcode',
                text: 'Are you sure you want to update this Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                button: ['Cancel', ' Confirm'],
                closeText: 'close'
            }
        });
        $('#auto_pass_submit').click(function () {

        });


    });
</script>
<?php
require_once __DIR__.'/../../classes/systemPackageClass.php';
$pack_func = new package_functions();
    $isdynamic =$pack_func->isDynamic($system_package);
 ?>

<div
    <?php if (isset($tab_guest_passcode)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
    id="guest_passcode">

    <?php
    
    if (isset($_SESSION['tab9'])) {
        echo $_SESSION['tab9'];
        unset($_SESSION['tab9']);
    }
    
    if ($isdynamic) {
    ?>
                                                
<h2 class="head">
        An extra layer of security:
        add a passcode to your splash page.<img data-toggle="tooltip" title="If you would like to restrict access to your Guest WiFi Network, you can select the passcode splash page theme. You have two options for setting passcodes:
1. Manual Passcode: Select this option to set a passcode that does not change and is valid until you replace it with a new one.
2. Automated Passcode: Select this option to allow the system to generate and deliver a unique passcode to emails of your choice on a predefined schedule."
                                                src="layout/OPTIMUM/img/help.png"
                                                style="width: 20px;margin-bottom: 6px;cursor: pointer;">
</h2>
                                            
                                            <?php } else{?>

    <h1 class="head">
        An extra layer of security:
        add a passcode to your splash page.<img data-toggle="tooltip" title="If you would like to restrict access to your Guest WiFi Network, you can select the passcode splash page theme. You have two options for setting passcodes:
1. Manual Passcode: Select this option to set a passcode that does not change and is valid until you replace it with a new one.
2. Automated Passcode: Select this option to allow the system to generate and deliver a unique passcode to emails of your choice on a predefined schedule."
                                                src="layout/OPTIMUM/img/help.png"
                                                style="width: 30px;margin-bottom: 6px;cursor: pointer;">
    </h1>
     <?php }?>
    
        <?php if ($other_multi_area==1) { ?>
            <!-- <p style="margin-bottom: 40px; margin-top: -60px; cursor: pointer;">
             <b>Note:</b> Currently, it does not make sense in Multi SSID context where when the user sets manual / automated passcode, the theme does not become active. The theme becomes active only when user assigns it to a Service Area. </p> -->
        <?php }else{
            if ($isdynamic) {
                ?>
            <p style="margin-bottom: 40px; cursor: pointer;">
             <?php }else{
                ?>
            <p style="margin-bottom: 40px; margin-top: -60px; cursor: pointer;">
            <?php }
    ?>
       
        <b>Note:</b> If manual or automated passcode is activated your current active theme will be changed into a
        passcode theme.
        In case there is no active theme you must create or activate a passcode theme. </p>
    
    <?php } ?>
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
    if ($ori_user_type != 'SALES') {
        $isthemeactive = $db->getValueAsf("SELECT `theme_id` AS f FROM `exp_themes` WHERE `distributor`='$user_distributor' AND `is_enable`='1'");

        $isthemeactivepasscode = $db->getValueAsf("SELECT `theme_id` AS f FROM `exp_themes` WHERE `distributor`='$user_distributor' AND `is_enable`='1' AND `registration_type` = 'AUTH_DISTRIBUTOR_PASSCODE'");
        $manual_status = $db->getValueAsf("SELECT `voucher_status` AS f FROM `exp_customer_vouchers` WHERE `reference`='$theme_Pass_user_distributor' AND `type`='Manual'");
        $auto_status = $db->getValueAsf("SELECT `voucher_status` AS f FROM `exp_customer_vouchers` WHERE `reference`='$theme_Pass_user_distributor' AND `type`='Auto'");
        if (($user_distributor == $theme_Pass_user_distributor) && strlen($isthemeactivepasscode)<1 && $other_multi_area!=1) {
            $auto_status = 0;
            $manual_status = 0;
        }
    } else {
        $manual_status = $_SESSION['manual_status'];
        $auto_status = $_SESSION['auto_status'];
    }

    ?>

    <div class="control-group form-horizontal">

        <div class="controls col-lg-5 form-group">
            <form class="form-horizontal" action="?t=guest_passcode" method="POST">
                <?php if ($hospitality_feature === true) { ?>
                    <b>
                        <c style="font-size:24px;"><?php echo ucwords(__THEME_TEXT__); ?></c>
                    </b>&nbsp;&nbsp;&nbsp;
                        <!-- ////////////// -->


                    <select name="themes_data" onchange="this.form.submit(); automated_pass()">
                        <option value="default">Default</option>
                        <?php
                        $key_query1 = "SELECT `theme_id`, `theme_name` FROM `exp_themes` WHERE `distributor` = '$user_distributor' ORDER BY theme_name ASC";

                        $query_results1 = $db->selectDB($key_query1);


                        foreach ($query_results1['data'] as $tag) {
                            ?>
                            <option <?php if ($theme_Pass_id == $tag['theme_id']) {
                                echo 'selected';
                            } ?> value="<?php echo $tag['theme_id']; ?>"><?php echo $tag['theme_name']; ?></option>
                        <?php } ?>
                    </select>
                    <br>
                    <br>
                <?php } else { ?>

                    <select name="themes_data" onchange="this.form.submit(); automated_pass()" style="display:none;">
                        <option value="default">Default</option>

                    </select>

                <?php } ?>
            </form>


            <b>
                <c style="font-size:24px;">Manual Passcode</c>
            </b>&nbsp;&nbsp;&nbsp;
            <!-- ////////////// -->


            <div class="toggle1">

                <input class="hide_checkbox" <?php if ($manual_status == '1') echo "  checked   " ?>
                       id="manual_passcode" type="checkbox">

                <?php if ($manual_status == '1') { ?>

                    <span class="toggle1-on">ON</span>
                    <a id="manual_passcode_link"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>
                    

                <?php } else { ?>
                    <a id="manual_passcode_link"><span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                    <span class="toggle1-off">OFF
                    </span>

                <?php } ?>

            </div>
            <?php if ($manual_status == '1') { ?>
                <img data-toggle="tooltip" title="To reset the default theme to its original state as a click and connect splash page click this button." src="layout/OPTIMUM/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">
            <?php } ?>

        </div>
    </div>

    <?php $manual_pass_val = $db->getValueAsf("SELECT `voucher_number` AS f FROM `exp_customer_vouchers` WHERE `voucher_type` = '$voucher_type' AND reference = '$theme_Pass_user_distributor'"); ?>
    <script>
        function automated_pass(){ }
        function changePasscodeM(value) {
            if(value=='on'){

                var passcode_val = '<?php echo $manual_pass_val; ?>';

                if(passcode_val == ''){

                    $('#tab5_form1') .data('bootstrapValidator').revalidateField('passcode_number');
                }else{
                    window.location ='?change_passcode=true&t=guest_passcode&manual_passcode=1&secret=<?php echo $secret; ?>&themes_data=<?php echo $theme_Pass_id; ?>';

                }
            }else{
                window.location ='?change_passcode=true&t=guest_passcode&manual_passcode=0&secret=<?php echo $secret; ?>&themes_data=<?php echo $theme_Pass_id; ?>';
            }
        }

    </script>

    <?php if ($manual_status == '1') { ?>
        <script type="text/javascript">

            $(document).ready(function () {
                $('#manual_passcode_link').easyconfirm({
                    locale: {
                        title: 'Manual Passcode',
                        text: 'Are you sure you want to disable the Manual Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $('#manual_passcode_link').click(function () {
                    changePasscodeM("off");
                });
            });
        </script>
    <?php }else{ ?>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#manual_passcode_link').easyconfirm({
                    locale: {
                        title: 'Manual Passcode',
                        text: 'Are you sure you want to enable the Manual Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $('#manual_passcode_link').click(function () {
                    changePasscodeM("on");
                });
            });
        </script>

    <?php } ?>

    <!-- //////////////////// -->


    <form id="tab5_form1" onkeyup="footer_submitfn();" onchange="footer_submitfn();" name="tab5_form1" method="post"
          action="?t=guest_passcode" class="form-horizontal" autocomplete="off">

        <fieldset>


            <br>

            <div class="control-group" id="feild_gp_taddg_divt">

                <div class="controls col-lg-5 form-group">

                    <label class="" for="gt_mvnx">Passcode<img data-toggle="tooltip" title="Choose your Manual Passcode. Your passcode must be between 8-32 characters and
                                                you may enter a combination of numbers, letters, and the characters: $ ! # @. Your Manual Passcode remains valid until you replace it with a new passcode."
                                                               src="layout/OPTIMUM/img/help.png"
                                                               style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                    <input type="text" name="passcode_number" maxlength="32" id="passcode_number" class="span4" required
                           value="<?php
                           echo $passcode = $db->getValueAsf("SELECT `voucher_number` AS f FROM `exp_customer_vouchers` WHERE `voucher_type` = '$voucher_type' AND reference = '$theme_Pass_user_distributor' AND `type`='Manual'");
                           ?>">


                    <script>
                        $('#passcode_number').bind("cut copy paste", function (e) {
                            e.preventDefault();
                        });

                        function footer_submitfn() {
                            //alert("fn");
                            if ($("#passcode_number").val().length > 7) {
                                $("#passcode_submit").prop('disabled', false);
                            }
                        }
                    </script>


                    <input type="hidden" name="passcode_secret" value="<?php echo $_SESSION['FORM_SECRET'] ?>">
                    <script type="text/javascript">
                        $("#passcode_number").keypress(function (event) {
                            var ew = event.which;
                            /*alert(ew);*/
                            if (ew == 33 || ew == 35 || ew == 36 || ew == 64 || ew == 8 || ew == 0)
                                return true;
                            if (48 <= ew && ew <= 57)
                                return true;
                            if (65 <= ew && ew <= 90)
                                return true;
                            if (97 <= ew && ew <= 122)
                                return true;
                            return false;
                        });


                        $("#passcode_number").keyup(function (event) {
                            var passcode_number;
                            passcode_number = $('#passcode_number').val();
                            var lastChar = passcode_number.substr(passcode_number.length - 1);
                            var lastCharCode = lastChar.charCodeAt(0);

                            if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 36 || lastCharCode == 33 || lastCharCode == 64 || lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
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
                    <input type="hidden" name="themes_data" value="<?php echo $theme_Pass_id ?>">
                    <button type="submit" name="passcode_submit" id="passcode_submit" class="btn btn-primary"
                            disabled="disabled" style="margin-left: 0px !important;">Set Manual Passcode
                    </button>
                    <?php if (strlen($isthemeactive) < 1) { ?>
                        <!-- <img data-toggle="tooltip" title="" src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 2px;cursor: pointer;"> -->
                    <?php } ?>

                </div>


            </div>
        </fieldset>
    </form>


    <form id="tab5_form2" name="tab5_form2" method="post" action="?t=guest_passcode" class="form-horizontal"
          autocomplete="off" enctype="multipart/form-data">

        <fieldset>

            <br>
            <div class="control-group form-horizontal">

                <div class="controls col-lg-5 form-group">

                    <b>
                        <c style="font-size:24px;">Automated Passcode</c>
                    </b>&nbsp;&nbsp;&nbsp;
                    <!-- ////////// -->


                    <div class="toggle1">

                        <input class="hide_checkbox" <?php if ($auto_status == '1') echo "  checked   " ?> id="auto_passcode" type="checkbox">

                        <?php
                        $auto_passcode_q="SELECT * FROM `exp_customer_vouchers`
                            WHERE `reference`='$theme_Pass_user_distributor' AND `type`IN('Auto','Buffer') AND (`voucher_status` = '0' OR `voucher_status` = '1')";
                        $auto_passcode_q_res=$db->selectDB($auto_passcode_q);
                        $passcode_auto=$auto_passcode_q_res['rowCount'];
                        if($auto_status=='1'){ ?>

                        <span class="toggle1-on">ON</span>
                        <a id="auto_passcode_link"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>

                        <?php }else{
                        if ($passcode_auto >0) { ?>
                        <a id="auto_passcode_link"> <span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                        <span class="toggle1-off">OFF</span>

                        <?php }
                        else{ ?>
                        <a id="auto_passcode_link_block"><span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                        <span class="toggle1-off">OFF</span>
                        <?php } } ?>

                    </div>

                </div>
            </div>

            <br>
            <div class="control-group">
            <div class="controls">
                            <input type="checkbox" class="automated" name="automated[]" value="automated"> System Generated &nbsp;&nbsp;
                            <input type="checkbox" class="automated" name="automated[]" value="csv_upload"> Upload List (<a href="import/passcode/random_passwords_template.csv">CSV Template</a>)
                            <small id="automated_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="automated" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>
                            This is a required field</p></small>
            </div>
            </div>
            <br>
            <script>
                $(document).ready(function () {
                    $(".automated").change(function() {
                        $('.automated').not(this).prop('checked', false);
                        if($(this).val()=='automated') {
                            $('#feild_gp_taddg_divt1').show();
                            $('#feild_gp_taddg_divt2').show();
                            $('#csv').hide();
                        }
                        if($(this).val()=='csv_upload') {
                            $('#feild_gp_taddg_divt1').hide();
                            $('#feild_gp_taddg_divt2').hide();
                            $('#csv').show();
                        }
                        check_prev('automated');
                    });
                });
                function changePasscodeA(value) {
                    /*var value=$('#auto_passcode:checked').val();*/
                    /*alert(value);*/
                    if (value == 'on') {
                        window.location = '?change_passcode&t=guest_passcode&auto_passcode=1&secret=<?php echo $secret; ?>';
                    } else {
                        window.location = '?change_passcode&t=guest_passcode&auto_passcode=0&secret=<?php echo $secret; ?>';
                    }
                }
            </script>
            <?php if ($auto_status == '1') { ?>
                <script type="text/javascript">

                    $(document).ready(function () {
                        $('#auto_passcode_link').easyconfirm({
                            locale: {
                                title: 'Automated Passcode',
                                text: 'Are you sure you want to disable Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                button: ['Cancel', ' Confirm'],
                                closeText: 'close'
                            }
                        });
                        $('#auto_passcode_link').click(function () {
                            changePasscodeA("off");
                        });
                    });
                    $(document).ready(function() {
                        $('#auto_passcode_link_block').click(function() {
                            $('#ap_id').empty();
                            $("#header_msg span").empty();
                            $("#header_msg span").text("Automated Passcode");
                            $('#ap_id').append('The Automated Passcode can be only enabled if a passcode has been configured. Please create a passcode and try again. ');
                            $('#servicearr-check-div').show();
                            $('#sess-front-div').show();
                        });
                    });
                </script>
            <?php }else{ ?>

                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#auto_passcode_link').easyconfirm({
                            locale: {
                                title: 'Automated Passcode',
                                text: 'Are you sure you want to enable Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                button: ['Cancel', ' Confirm'],
                                closeText: 'close'
                            }
                        });
                        $('#auto_passcode_link').click(function () {
                            changePasscodeA("on");
                        });
                    });
                    $(document).ready(function() {
                        $('#auto_passcode_link_block').click(function() {
                            $('#ap_id').empty();
                            $("#header_msg span").empty();
                            $('#ui-id-4').append('Automated Passcode');
                            $("#header_msg span").text("Automated Passcode");
                            $('#ap_id').append('The Automated Passcode can be only enabled if a passcode has been configured. Please create a passcode and try again. ');
                            $('#servicearr-check-div').show();
                            $('#sess-front-div').show();
                        });
                    });
                </script>

            <?php } ?>

            <!-- ////////// -->


            <div class="control-group" id="feild_gp_taddg_divt1">

                <div class="controls col-lg-5 form-group">

                    <label class="" for="prefix">Prefix<img data-toggle="tooltip"
                                                            title='[Optional] You may choose to create an optional passcode "prefix" that will be added to the beginning of your generated passcode. This prefix will be added to the beginning of your automatically generated passcodes and helps make the passcode more readable. The prefix can be a maximum of 16 characters consisting of numbers, letters, and the characters: $ ! # @.'
                                                            src="layout/OPTIMUM/img/help.png"
                                                            style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                    <input type="text" class="span4 form-control" name="prefix" id="prefix" maxlength="16">


                    <small id="prefix_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="prefix"
                           class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>
                            This is a required field</p></small>
                </div>
            </div>


            <script type="text/javascript">

                $('#prefix').bind("cut copy paste", function (e) {
                    e.preventDefault();
                });

                $("#prefix").keypress(function (event) {
                    var ew = event.which;
                    if (ew == 8 || ew == 0 || ew == 36 || ew == 33 || ew == 64 || ew == 35)
                        return true;
                    if (48 <= ew && ew <= 57)
                        return true;
                    if (65 <= ew && ew <= 90)
                        return true;
                    if (97 <= ew && ew <= 122)
                        return true;
                    return false;
                });

                $("#prefix").keyup(function (event) {
                    var prefix;
                    prefix = $('#prefix').val();
                    var lastChar = prefix.substr(prefix.length - 1);
                    var lastCharCode = lastChar.charCodeAt(0);

                    if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 36 || lastCharCode == 33 || lastCharCode == 64 || lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                        (65 <= lastCharCode && lastCharCode <= 90) ||
                        (97 <= lastCharCode && lastCharCode <= 122))) {
                        $("#prefix").val(prefix.substring(0, prefix.length - 1));
                    }

                    priflenchange();
                });


            </script>


            <script type="text/javascript">

                function priflenchange() {
                    //alert("inprifchan");

                    $('#passcode_length').empty();

                    var prefix = document.getElementById('prefix').value;
                    var le = 32 - prefix.length;

                    var les = 8 - prefix.length;

                    if (les < 1) {
                        les = 1;
                    }

                    $("#passcode_length").append('<option value=""> Select Length </option>');

                    for (i = les; i <= le; i++) {
                        $("#passcode_length").append('<option value="' + i + '">' + i + '</option>');
                    }


                }


            </script>


            <div class="control-group" id="feild_gp_taddg_divt2">
                <div class="controls col-lg-5 form-group">

                    <label class="" for="prefix">Password length<img data-toggle="tooltip"
                                                                     title="Select how long you’d like your auto-generated passcode to be. The total length of your passcode (prefix + auto-generated) may not exceed 32 characters."
                                                                     src="layout/OPTIMUM/img/help.png"
                                                                     style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                    <select name="passcode_length" id="passcode_length" class="span4 form-control">

                        <option value="">Select Length</option>

                        <?php
                        for ($i = 8; $i < 33; $i++) {

                            echo '<option value="' . $i . '">' . $i . '</option>';

                        }

                        ?>


                    </select>

                    <small id="passcode_length_er_msg" data-bv-validator="notEmpty"
                           data-bv-validator-for="passcode_number"
                           class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>
                            This is a required field</p></small>


                </div>
            </div>


            <div class="control-group" id="feild_gp_taddg_divt1">
                <div class="controls col-lg-5 form-group">

                    <label class="" for="prefix">Passcode delivery time<img data-toggle="tooltip"
                                                                            title="Select the time of day you would like your passcode to be renewed. An email with the new passcode will be sent out at the time selected to the emails defined below."
                                                                            src="layout/OPTIMUM/img/help.png"
                                                                            style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                    <select name="passcode_renewal_time" id="passcode_renewal_time" class="span4 form-control">

                        <option value="">Select Time</option>

                        <?php
                        $dt = new DateTime('GMT');
                        $dt->setTime(0, 0);
                        echo '<option value="' . $dt->format('H:i:s') . '">' . $dt->format('h:i A') . '</option>';
                        for ($i = 0; $i < 95; $i++) {
                            $dt->add(new DateInterval('PT15M'));
                            echo '<option value="' . $dt->format('H:i:s') . '">' . $dt->format('h:i A') . '</option>';
                        }

                        ?>

                    </select>
                    <small id="passcode_renewal_er_msg" data-bv-validator="notEmpty"
                           data-bv-validator-for="passcode_number"
                           class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>
                            This is a required field</p></small>


                </div>
            </div>


            <div class="control-group" id="feild_gp_taddg_divt1">
                <div class="controls col-lg-5 form-group">

                    <label class="" for="prefix">Change Frequency <img data-toggle="tooltip"
                                                                       title="Select how often you would like for your passcode to be renewed. Choose from the preset options below or choose a customized frequency in days."
                                                                       src="layout/OPTIMUM/img/help.png"
                                                                       style="width: 30px;margin-bottom: 6px;cursor: pointer;">
                    </label>

                    <div class="net_div">
                        <div class="net_div_child">
                            <input type="radio" class="fixfreequency frequency" name="default_frequency"
                                   id="default_frequency1" value="Daily" style="display: inline-block">Daily&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="net_div_child">
                            <input type="radio" class="fixfreequency frequency" name="default_frequency"
                                   id="default_frequency2" value="Weekly" style="display: inline-block">Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="net_div">
                        <div class="net_div_child">
                            <input type="radio" class="fixfreequency frequency" name="default_frequency"
                                   id="default_frequency3" value="Bi-weekly" style="display: inline-block">Bi-Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="net_div_child">
                            <input type="radio" class="fixfreequency frequency" name="default_frequency"
                                   id="default_frequency4" value="Monthly" style="display: inline-block">Monthly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="net_div_child">
                            <input maxlength="3" type="text" class="span1" name="custom_frequency" id="custom_frequency"
                                   style="display: inline-block">&nbsp;Days
                            <small id="frequency_er_msg" data-bv-validator="notEmpty"
                                   data-bv-validator-for="passcode_number"
                                   class="help-block error-wrapper bubble-pointer mbubble-pointer"
                                   style="display: none;"><p>This is a required field</p></small>
                            <small id="frequency_er1_msg" data-bv-validator="notEmpty"
                                   data-bv-validator-for="passcode_number"
                                   class="help-block error-wrapper bubble-pointer mbubble-pointer"
                                   style="display: none;"><p>Values starting with 0 are not valid. Valid values are
                                    1-999</p></small>

                            <script>
                                $("#custom_frequency").keypress(function (event) {
                                    var ew = event.which;
                                    if (ew == 8 || ew == 0)
                                        return true;
                                    if (48 <= ew && ew <= 57)
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

                    <label class="" for="gt_mvnx">Passcode Expiration Buffer <img data-toggle="tooltip"
                                                                                  title="[Optional] Your Automated Passcode will expire at the same time of day that the generation was enabled. You may choose to add an additional Passcode Expiration Buffer that will increase the amount of time that the expiring passcode remains valid past the time the generation was enabled. For example, if your passcode is generated at 10:30 AM with a generation frequency of weekly, that passcode will expire at 10:30 AM on the 7th day. If you added a Passcode Expiration Buffer of 8 hours or 5 days, the old passcode would still be valid for 8 hours or 5 days after the new passcode is generated."
                                                                                  src="layout/OPTIMUM/img/help.png"
                                                                                  style="width: 30px;margin-bottom: 6px;cursor: pointer;">
                    </label>
                    <div class="buff-rad" style="margin-bottom: 15px;">
                    <input type="radio" class="fixfreequency buffer_frequency" name="buffer_frequency" id="buffer_frequency1" value="Days" style="display: inline-block"> Days &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" class="fixfreequency buffer_frequency" name="buffer_frequency" id="buffer_frequency2" value="Hours" style="display: inline-block" checked="checked"> Hours &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <input maxlength="2" type="text" class="span1" name="buffer_time" id="buffer_time"
                           style="display: inline-block">&nbsp;<span id="buffer_time_txt">Hours</span> 
                    <small id="buffer_time_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number"
                           class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>
                            Values starting with 0 are not valid. Valid values are 1-24</p></small>
                    <script>
                        $("#buffer_time").keypress(function (event) {
                            var ew = event.which;
                            if (ew == 8 || ew == 0)
                                return true;
                            if (48 <= ew && ew <= 57)
                                return true;

                            return false;
                        });
                    </script>

                </div>
            </div>


            <div class="control-group" id="feild_gp_taddg_divt1">

                <div class="controls col-lg-5 form-group">
                    <label class="" for="gt_mvnx">Set Email<img data-toggle="tooltip"
                                                                title="Enter the email address you would like to use for Automated Passcode delivery. If you would like to change the delivery email or add an additional email recipient at a later date, you may update it below.  "
                                                                src="layout/OPTIMUM/img/help.png"
                                                                style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                    <input type="text" class="span4 form-control" name="set_mail" id="set_mail">
                    <small id="set_mail_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number"
                           class="help-block error-wrapper bubble-pointer mbubble-pointer"
                           style="display: none;"></small>
                </div>

            </div>
            <script>
                $(document).ready(function () {
                    $('input[name=buffer_frequency]').on('change', function() {
                        $('#buffer_time_txt').html($('input[name=buffer_frequency]:checked').val()); 
                    });
                    $('#set_mail').bind("cut copy paste", function (e) {
                        e.preventDefault();
                    });
                });
            </script>
            <div class="control-group" id="feild_gp_taddg_divt1">

                <div class="controls col-lg-5 form-group">

                    <label class="" for="gt_mvnx">Validate Email</label>

                    <input type="text" class="span4 form-control" name="validate_mail" id="validate_mail">
                    <small id="validate_mail_er1_msg" data-bv-validator="notEmpty"
                           data-bv-validator-for="passcode_number"
                           class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>
                            This is a required field</p></small>
                    <!-- <small id="validate_mail_er2_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>The email addresses you entered do not match</p></small> -->
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#validate_mail').bind("cut copy paste", function (e) {
                        e.preventDefault();
                    });
                });
            </script>

        </fieldset>

        <div class="form-actions">
            <input type="hidden" name="auto_pass_secret" value="<?php echo $secret ?>">
            <input type="hidden" name="themes_data" value="<?php echo $theme_Pass_id ?>">
            <input type="file" style="display: none;" class="form-control csv-btn" name="csv" id="csv" data-fv-field="csv">
            <button type="submit" name="auto_pass_submit" id="auto_pass_submit" class="btn btn-primary">Set Automated
                Passcode
            </button>
            <small id="csv_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>
                            This is a required field</p></small>
        </div>

                <style>
                
                input[name="csv"]::before {
                    width: 100%;
                    content: 'Select CSV file';
                    min-width: 70px !important;
                    cursor: pointer;
                    position: absolute;
                }
                                                    input[name="csv"] {
                                                        color: transparent;
                                                        outline: 0 !important;
                                                        width: 139px;
                                                        position: relative;
                                                    }
                </style>
        <script>

            function check_prev(x) {

                var net_ele = new Array("prefix", "passcode_len", "passcode_renewal", "frequency", "buffer", "mail1", "mail2","automated");

                if (x == 'prefix') {
                    x = 'passcode_len';
                }

                var a = net_ele.indexOf(x);

                if (x == 'mail1') {
                    $('#validate_mail').val('');
                    $('#validate_mail_er1_msg').css("display", "none");
                    //$('#validate_mail_er2_msg').css("display", "none");
                }


                for (i = 0; i <= parseInt(a); i++) {

                    var ab = net_ele[i];

                    CheckValues(ab);
                }

            }

            function CheckValues(element) {
                var error = 0;
                // set button disabled
                $('#auto_pass_submit').attr("disabled", true);

                // email regex
                var reg2 = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


                // check first mail set
                var setMail = $("#set_mail").val();


                if (setMail == '') {
                    error++;
                } else if (setMail.length > 128) {
                    error++;
                    if (element == 'mail1') {

                        $('#set_mail_er_msg').html('<p>This field value is too long</p>');

                        $('#set_mail_er_msg').css("display", "inline-block");
                    }
                } else {
                    if (!reg2.test(setMail)) {

                        if (element == 'mail1') {

                            $('#set_mail_er_msg').html('<p>This is not a valid email address</p>');
                            $('#set_mail_er_msg').css("display", "inline-block");
                        }
                        error++

                    } else {
                        if (element == 'mail1') {
                            $('#set_mail_er_msg').css("display", "none");
                        }
                    }
                }


                //check first mail  === second mail
                var validate_mail = $('#validate_mail').val();
                if (validate_mail != '') {

                    if (setMail === validate_mail) {
                        if (element == 'mail2') {
                            $('#validate_mail_er1_msg').css("display", "none");
                            //$('#validate_mail_er2_msg').css("display", "none");
                        }
                    } else {
                        if (element == 'mail2') {
                            //$('#validate_mail_er1_msg').css("display", "none");
                            $('#validate_mail_er1_msg').html('<p>The email addresses you entered do not match</p>');
                            $('#validate_mail_er1_msg').css("display", "inline-block");
                        }
                        error++;
                    }
                } else {
                    if (element == 'mail2') {
                        $('#validate_mail_er1_msg').html('<p>This is a required field</p>');
                        //$('#validate_mail_er2_msg').css("display", "none");
                        $('#validate_mail_er1_msg').css("display", "inline-block");
                    }
                    error++;
                }

                // check frquency set
                var cus_freq = $("#custom_frequency").val();
                //alert(cus_freq);
                if ($('input[name=default_frequency]:checked').val() != undefined || cus_freq != '') {
                    //1-24 validate regex
                    if (cus_freq != '') {
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
                    } else {
                        if (element == 'frequency') {
                            $('#frequency_er1_msg').css("display", "none");
                            $('#frequency_er_msg').css("display", "none");
                        }
                    }
                } else {
                    if (element == 'frequency') {
                        $('#frequency_er_msg').css("display", "inline-block");
                        $('#frequency_er1_msg').css("display", "none");
                    }
                    //$('#auto_pass_submit').attr("disabled", true);
                    error++;
                }


                //1-24 validate regex
                var reg1 = /^[1-9]$|^1[0-9]$|^2[0-4]$/;

                var buffer_time = $('#buffer_time').val();

                if (buffer_time != '') {
                    if (!reg1.test(buffer_time)) {

                        //alert('false');
                        if (element == 'buffer') {

                            $('#buffer_time_er_msg').css("display", "inline-block");
                        }
                        error++;

                    } else {

                        //alert('true');
                        if (element == 'buffer') {
                            $('#buffer_time_er_msg').css("display", "none");
                        }
                    }
                } else {
                    if (element == 'buffer') {
                        $('#buffer_time_er_msg').css("display", "none");
                    }
                }


                var passcode_length = $('#passcode_length').val();
                //alert(passcode_length);
                var auto_selected = false;
                var is_automated = false;
                $("input[name='automated[]']").each( function () {
                    if($(this).is(':checked')){
                        auto_selected = true;
                        if($(this).val()=='automated'){
                            is_automated = true;
                        }
                    }
                });

                if(!auto_selected) {

                    if (passcode_length == '') {
                        if (element == 'passcode_len') {
                            $('#passcode_length_er_msg').css("display", "inline-block");
                        }

                        error++;

                    } else {
                        if (element == 'passcode_len') {
                            $('#passcode_length_er_msg').css("display", "none");
                        }
                    }

                    $('#automated_er_msg').css("display", "inline-block");
                    error++;
                }else{

                    if(is_automated) {

                        if (passcode_length == '') {
                            if (element == 'passcode_len') {
                                $('#passcode_length_er_msg').css("display", "inline-block");
                            }

                            error++;

                        } else {
                            if (element == 'passcode_len') {
                                $('#passcode_length_er_msg').css("display", "none");
                            }
                        }

                        $('#csv_er_msg').css("display", "none");

                    }else{
                        if ($('#csv')[0].files.length === 0) { 
                            $('#csv_er_msg').css("display", "block");
                            error++;
                        }else{
                            $('#csv_er_msg').css("display", "none");
                        }
                    }

                    $('#automated_er_msg').css("display", "none");
                }

                var passcode_renewal_time = $('#passcode_renewal_time').val();


                if (passcode_renewal_time == '') {
                    if (element == 'passcode_renewal') {
                        //alert();

                        $('#passcode_renewal_er_msg').css("display", "inline-block");
                    }

                    error++;

                } else {
                    if (element == 'passcode_renewal') {
                        $('#passcode_renewal_er_msg').css("display", "none");
                    }
                }

                if (error == 0) {

                    $('#auto_pass_submit').attr("disabled", false);
                }


            }


            $(document).ready(function () {


                $('#auto_pass_submit').attr("disabled", true);


                $(".frequency").click(function (e) {


                    //var res = e.target.id.split('_');

                    $("#custom_frequency").val(null);

                    check_prev('frequency');

                });

                $("#custom_frequency").change(function (e) {
                    //var res = e.target.id.split('_');

                    $("#default_frequency1").prop('checked', false);
                    $("#default_frequency2").prop('checked', false);
                    $("#default_frequency3").prop('checked', false);
                    $("#default_frequency4").prop('checked', false);

                    check_prev('frequency');

                });

                $("#csv").change(function (e) {
                    //var res = e.target.id.split('_');
                    check_prev('automated');
                });

                $("#custom_frequency").keyup(function (e) {
                    $("#default_frequency1").prop('checked', false);
                    $("#default_frequency2").prop('checked', false);
                    $("#default_frequency3").prop('checked', false);
                    $("#default_frequency4").prop('checked', false);

                    check_prev('frequency');
                });


                $("#set_mail").keyup(function (e) {
                    check_prev('mail1');
                });
                $("#validate_mail").keyup(function (e) {
                    check_prev('mail2');
                });

                $("#set_mail").on("change", function (e) {
                    check_prev('mail1');
                });
                $("#validate_mail").on("change", function (e) {
                    check_prev('mail2');
                });
                $("#buffer_time").on("change", function (e) {
                    check_prev('buffer');
                });

                $("#buffer_time").on("keyup", function (e) {
                    check_prev('buffer');
                });
                $("#prefix").on("change", function (e) {
                    check_prev('prefix');
                });

                $("#prefix").on("keyup", function (e) {
                    check_prev('prefix');
                });
                $("#passcode_length").on("change", function (e) {
                    check_prev('passcode_len');
                });

                $("#passcode_renewal_time").on("change", function (e) {
                    check_prev('passcode_renewal');
                });


            });
        </script>


    </form>


    <hr/>


    <form method="post" action="?t=guest_passcode" id="auto_passcode_email_update" name="auto_passcode_email_update"
          class="form-horizontal" autocomplete="off"  style="margin-bottom: 45px;">


        <div class="control-group">

            <div class="controls col-lg-5 form-group">

                <h2>Update Automated Passcode Delivery Email:</h2>
            </div>
        </div>


        <fieldset>
            <div class="control-group" id="feild_gp_taddg_divt1">

                <div class="controls col-lg-5 form-group" id="update_mail_parent">

                    <label class="" for="gt_mvnx">New Email <img data-toggle="tooltip"
                                                                 title='If you would like to update the email address used for Automated Passcode delivery, enter the new email address below. If you would like to add another email address to receive your Automated Passcodes, select "Add Secondary Email" below.'
                                                                 src="layout/OPTIMUM/img/help.png"
                                                                 style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                    <input type="text" class="span4 form-control" name="update_mail" id="update_mail">
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#update_mail').bind("cut copy paste", function (e) {
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
                $(document).ready(function () {
                    $('#validate_update_mail').bind("cut copy paste", function (e) {
                        e.preventDefault();
                    });
                });
            </script>
        </fieldset>

        <?php
        $mail_count = 0;
        $auto_passcode_q1 = "SELECT * FROM `exp_customer_vouchers` WHERE `reference`='$theme_Pass_user_distributor' AND `type`IN('Auto','Buffer')";
        $auto_passcode_q_res1 = $db->selectDB($auto_passcode_q1);

        foreach ($auto_passcode_q_res1['data'] as $auto_passcode_details1) {
            $secemail_jary1 = $auto_passcode_details1['secondry_email'];
            $secmails_array1 = json_decode($secemail_jary1);

            $mail_count = sizeof($secmails_array1);
        }

        ?>

        <div class="form-actions">
            <input type="hidden" name="auto_pass_emailup_secret" value="<?php echo $secret ?>">
            <input type="hidden" name="themes_data" value="<?php echo $theme_Pass_id ?>">
            <button type="submit" name="auto_pass_email_update" onclick="pa_up(0);" id="auto_pass_email_update"
                    value="0" class="btn btn-primary">Update Primary Email
            </button>

            <?php if ($mail_count < 5) { ?>

                <button type="submit" name="auto_pass_email_update" onclick="pa_up(1);" id="auto_pass_sec_add" value="1"
                        class="btn btn-danger inline-btn">Add Secondary Email
                </button>

            <?php } ?>

            <script type="text/javascript">
                $(document).ready(function () {
                    function updatemailcheck(action) {

                        if (action == 'mail1') {
                            $('#validate_update_mail').val('');
                        }

                        $('#auto_pass_email_update').attr("disabled", true);
                        $('#auto_pass_sec_add').attr("disabled", true);

                        var count = $('#tblAutomaticPasscodes tbody tr').length;
                        //alert(count);
                        if (count < 1) {
                            return;
                        }

                        if ($('#update_mail').val() != '') {
                            if (($('#update_mail').val() == $('#validate_update_mail').val()) && !($("#update_mail_parent").hasClass("has-error"))) {
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


                function pa_up(v) {

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
            <div style="overflow-x:auto;">
                <table id="tblAutomaticPasscodes" class="table table-striped table-bordered tablesaw"
                       data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
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


                    $offset_val = $db->getValueAsf("SELECT `offset_val` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");


                    $auto_passcode_q = "SELECT *,
                                                            DATE_FORMAT(CONVERT_TZ(start_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS st_date,
                                                            DATE_FORMAT(CONVERT_TZ(refresh_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS en_date,
                                                            DATE_FORMAT(CONVERT_TZ(expire_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS ex_date
                                                            FROM `exp_customer_vouchers`
                                                            WHERE `reference`='$theme_Pass_user_distributor' AND `type`IN('Auto','Buffer') AND (`voucher_status` = '0' OR `voucher_status` = '1')";
                    $auto_passcode_q_res = $db->selectDB($auto_passcode_q);

                    foreach ($auto_passcode_q_res['data'] as $auto_passcode_details) {
                        // $prof_id=$auto_passcode_details['id'];
                        //`voucher_number``frequency``start_date``buffer_duration``refresh_date`
                        if ($auto_passcode_details['frequency'] != "Daily" && $auto_passcode_details['frequency'] != "Weekly" && $auto_passcode_details['frequency'] != "Bi-weekly" && $auto_passcode_details['frequency'] != "Monthly") {
                            $frequency_scale = "Days";
                        } else {
                            $frequency_scale = "";
                        }
                        echo "<tr><td>" . $auto_passcode_details['voucher_number'] . "</td>";

                        echo "<td>" . strtolower($auto_passcode_details['reference_email']) . ' (Primary)';

                        $secemail_jary = $auto_passcode_details['secondry_email'];
                        $secmails_array = json_decode($secemail_jary);

                        foreach ($secmails_array as $value) {
                            echo '<br/>' . strtolower($value) . ' ' . '<a href="?t=guest_passcode&rmv_sc=1&rm_sc_mail=' . $value . '"><img src="img/trash-ico.png" style="max-height:20px;max-width;20px;"></a>';

                        }

                        echo "</td>";

                        echo "<td>" . $auto_passcode_details['frequency'] . " " . $frequency_scale . "</td>";

                        $start_date = $auto_passcode_details[st_date];
                        $refresh_date = $auto_passcode_details[en_date];
                        $expire_date = $auto_passcode_details[ex_date];
                        echo "<td>" . $start_date . "</td>";
                        echo "<td>" . $auto_passcode_details['buffer_duration'] . "  Hours</td>";

                        echo "<td>" . $refresh_date . " </td>";
                        echo "<td>" . $expire_date . " </td>";
                        echo "<td>" . $dis_time_zone . " </td></tr>";


                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>