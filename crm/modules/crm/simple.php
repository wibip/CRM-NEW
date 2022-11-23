<style>
    #crm-create-progress{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(102 102 102);
        opacity: 0.75;
        z-index: 100;
        cursor: progress;
        display: none;
    }
</style>

<?php
    $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap,network_type
        FROM exp_products
        WHERE (network_type='GUEST' || network_type='PRIVATE' || network_type='VTENANT') AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";
    $query_results = $db->selectDB($q1);
    $arraym = array();
    $arrayk = array();
    $arrayo = array();
    $guest_product_arr = array();
    $pvt_product_arr = array();
    $vt_product_arr = array();

    foreach ($query_results['data'] as $row) {
    $dis_code = $row[product_code];
    $QOS = $row[QOS];
    $QOSLast = strtolower(substr($QOS, -1));
    $product_name_new = str_replace('_', '-', $row[product_code]);
    $name_ar = explode('-', $product_name_new);
    $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
    $duration_val = $duration[0];
    $qosvalarr = explode('*', $name_ar[2]);
    $ab = substr($name_ar[2], 0, 2);
    if (!is_numeric($ab)) {
        $ab = substr($name_ar[2], 0, 1);
    }
    $bb = substr($name_ar[2], -2);
    if (!is_numeric($bb)) {
        $bb = substr($name_ar[2], -1);
    }
    $row['duration'] = $duration_val;
    $row['qosval'] = $ab;
    $row['qosval2'] = $bb;
    if ($QOSLast == 'k') {
        array_push($arrayk, $row);
    } else if ($QOSLast == 'm') {
        array_push($arraym, $row);
    } else {
        array_push($arrayo, $row);
    }
}

CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
$arrayfinal = array();
if (empty($arrayk)) {
    $arrayfinal = $arraym;
} else {
    if (empty($arraym)) {
        $arrayfinal = $arrayk;
    } else {
        $arrayfinal = array_merge($arrayk, $arraym);
    }
}
if (!empty($arrayo)) {
    $arrayfinal = array_merge($arrayfinal,$arrayo);

}?>
<div <?php if (isset($tab_crm_create)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="crm_create">
    <div id="crm-create-progress"></div>
    <div id="msg27"></div>
    <?php
    if (isset($_SESSION['msg_crm_create'])) {
        echo $_SESSION['msg_crm_create'];
        unset($_SESSION['msg_crm_create']);
    }
    ?>
    <form onkeyup="" onchange="" autocomplete="off" id="crm_form" name="crm_form" method="post" class="form-horizontal" action="">
        <?php
        echo '<input type="hidden" name="form_secret5" id="form_secret5" value="' . $_SESSION['FORM_SECRET'] . '" />';
        ?>
        <style>
            .prov-sub-headers {padding: 0em 0em 0em 0.7em; line-height: unset; font-weight: bold;}
            div.flex {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                width: 100%;
            }
            .create_le {
                width: 100%;
            }
            .create_re {
                width: 100%;
                padding-left: 20px;
            }
            .form-horizontal .create_l .controls, .form-horizontal .create_le .controls, .form-horizontal .create_r .controls, .form-horizontal .create_re .controls, .fieldStep .controls {
                margin-left: 0px !important;
            }
            .actions.clearfix{
                width: 100%;
            }
        </style>
        <div>
            <div class="content clearfix">
                <fieldset id="customer_info" data-name="Customer Information ">
                    <div class="flex">
                        <div class="create_le">
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Business Name</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="business_name" id="business_name" class="span4 form-control" value="<?php echo $edit===true?$get_business_name:''?>">
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Contact Phone</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" class="mobile3_vali" type="text" name="contact_Phone" id="contact_Phone" class="span4 form-control"
                                        value="<?php echo $edit===true?$get_contact_phone:''?>">
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript">
                            $(document).ready(function() {

                                $('.mobile3_vali').focus(function() {
                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                    $('#crm_form').data('bootstrapValidator').updateStatus('contact_Phone', 'NOT_VALIDATED').validateField('contact_Phone');
                                });

                                $('.mobile3_vali').keyup(function() {
                                  var phone_1 = $(this).val().replace(/[^\d]/g, "");
                                  if (phone_1.length > 9) {
                                    //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
                                    var phone2 = phone_1.length;
                                    if (phone_1.length > 10) {
                                      var phone2 = phone_1.length;
                                      $('#crm_form')
                                                .bootstrapValidator('enableFieldValidators', 'contact_Phone', false);
                                      var phone_1 = phone_1.slice(0,10);

                                                }
                                              $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                                              //console.log(phone_1+'sss');
                                              if (phone2 == 10) {
                                                  $('#crm_form')
                                                .bootstrapValidator('enableFieldValidators', 'contact_Phone', true);
                                            }

                                              }
                                              else{
                                  $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                  $('#crm_form')
                                                .bootstrapValidator('enableFieldValidators', 'contact_Phone', true)
                                  }

                                $('#crm_form').bootstrapValidator('revalidateField', 'contact_Phone');
                              });

                                //$('#phone_number').val($('#phone_number').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));


                                $(".mobile3_vali").keydown(function(e) {


                                    var mac = $('.mobile3_vali').val();
                                    var len = mac.length + 1;
                                    //console.log(e.keyCode);
                                    //console.log('len '+ len);

                                    if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                                        mac1 = mac.replace(/[^0-9]/g, '');


                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                        //console.log(valu);
                                        //$('#phone_num_val').val(valu);

                                    } else {

                                        if (len == 4) {
                                            $('.mobile3_vali').val(function() {
                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                                //console.log('mac1 ' + mac);

                                            });
                                        } else if (len == 8) {
                                            $('.mobile3_vali').val(function() {
                                                return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                                //console.log('mac2 ' + mac);

                                            });
                                        }
                                    }


                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                                        // Allow: Ctrl+A, Command+A
                                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                        // Allow: Ctrl+C, Command+C
                                        (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                                        // Allow: Ctrl+x, Command+x
                                        (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                                        // Allow: Ctrl+V, Command+V
                                        (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
                                        // Allow: home, end, left, right, down, up
                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                        // let it happen, don't do anything
                                        return;
                                    }
                                    // Ensure that it is a number and stop the keypress
                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                        e.preventDefault();

                                    }
                                    $('#crm_form').data('bootstrapValidator').updateStatus('contact_Phone', 'NOT_VALIDATED').validateField('contact_Phone');
                                });


                            });
                        </script>

                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Account Number</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="account_number" id="account_number" class="span4 form-control" value="<?php echo $edit===true?$get_account_number:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Street</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="street" id="street" class="span4 form-control" value="<?php echo $edit===true?$get_street:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">State</label>
                                    <div class="controls col-lg-5 form-group">
                                        <select name="state" id="state" class="span4 form-control">
                                        <option value="">Select State</option>
                                        <?php
                                        $get_regions = $db->selectDB("SELECT
                                    `states_code`,
                                    `description`
                                    FROM
                                    `exp_country_states` ORDER BY description ASC");


                                        foreach ($get_regions['data'] as $state) {
                                            if (($edit===true?$get_state:'') == $state['states_code']) {
                                                echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                            } else {

                                                echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                            }
                                        }
                                        //echo '<option value="other">Other</option>';
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Service Type</label>
                                    <div class="controls col-lg-5 form-group">
                                        <select name="service_type" id="service_type" class="span4 form-control">
                                        <option value="ENT-SMB-NON-AP-VYOS">ENT-SMB-NON-AP-VYOS</option>
                                        <option value="ENT-SMB-NON-AP-FORTIGATE">ENT-SMB-NON-AP-FORTIGATE</option>
                                        <option value="ENT-SMB-NON-AP-MERAKI">ENT-SMB-NON-AP-MERAKI</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="create_re">
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Contact</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="contact" id="contact" class="span4 form-control" value="<?php echo $edit===true?$get_contact_name:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Contact Email</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="contact_email" id="contact_email" class="span4 form-control" value="<?php echo $edit===true?$get_contact_email:''?>">
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Order Number</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="order_number" id="order_number" class="span4 form-control" value="<?php echo $edit===true?$get_order_number:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">City</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="city" id="city" class="span4 form-control" value="<?php echo $edit===true?$get_city:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Zip</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="zip" id="zip" class="span4 form-control" value="<?php echo $edit===true?$get_zip:''?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <style>
                    .radio-controls label{
                        margin-bottom: 0;
                    }
                </style>
                <div class="actions clearfix">
                    <ul style="list-style: none;float: right;margin: 0;" role="menu" aria-label="Pagination">
                        <li class="{2} disabled" style="display: inline-block;margin-left: 5px;" aria-disabled="true"><button href="javascript:void(0)" data-type="previous" class="btn btn-primary" role="menuitem">Previous</button></li>
                        <li class="{2} disabled" style="display: inline-block;margin-left: 5px;" aria-hidden="false" aria-disabled="true"><button tabindex="119" href="javascript:void(0)" data-type="next" class="btn btn-primary" role="menuitem">Next</button></li>
                        <li class="finishStepone" style="display: none; margin-left: 5px;" aria-hidden="true"><a tabindex="120" href="#steponesubmit" class="btn btn-primary" name="location_submit_one" id="location_submit_one" role="menuitem">Update Account Info</a></li>
                        <li class="finishSteptwo" style="display: none; margin-left: 5px;" aria-hidden="true"><a href="#steptwosubmit" class="btn btn-primary" name="location_submit_two" id="location_submit_two" role="menuitem">Update Controller Info</a></li>
                        <li class="finishParent" style="display: none; margin-left: 5px;" aria-hidden="true">
                            <!-- <a href="#finish" class="btn btn-primary" name="create_location_submit" id="create_location_submit" role="menuitem" >Finish</a></li> -->
                            <button onmouseover="" type="submit" name="<?php if (isset($_GET['edit'])){echo 'update_crm_submit';}else{echo 'create_crm_submit';}?>" id="create_crm_submit" class="btn btn-primary">Save</button>
                            <li class="cancelform" style="display: none; margin-left: 5px;" aria-hidden="true"><a href="?token7=<?php echo $secret; ?>&t=edit_parent" class="btn btn-primary" role="menuitem">Cancel</a></li>
                        </ul>
                    </div>
                    </div>
                    </div>
                </form>
            </div>
            <script type="text/javascript">
                function stepList_crm(index, name) {
                    var clz = '';
                    if (index == 1) {
                        clz = 'current';
                    }
                    return '<li data-step="' + index + '" role="tab" class="{index' + index + '}" aria-disabled="false" aria-selected="true"><span>' + name + '</span></li>';
                }


                function stepSetter_crm(step, stepCount, action, stepListFull, edit_account){

                    if (stepListFull) {
                        let index = 1;
                        while (index <= stepCount) {
                            if (index < step) {
                                stepListFull = stepListFull.replace("{index" + index + "}", "done");
                            } else if (index == step) {
                                stepListFull = stepListFull.replace("{index" + index + "}", "current");
                            } else {
                                stepListFull = stepListFull.replace("{index" + index + "}", "");
                            }
                            index++;
                        }

                    } else {
                        if (action != 'previous') {

                            try {
                                $('#crm_form').data('bootstrapValidator').validate();
                                if (!$('#crm_form').data('bootstrapValidator').isValid()) {
                                    return false;
                                }
                            } catch (e) {
                                console.log(e);
                            }
                            if (step == 3) {
                                if (edit_account) {
                                    $("#create_crm_submit").prop("disabled", false);
                                } else {
                                    $("#create_crm_submit").prop("disabled", false);
                                }
                            }
                        }
                        $('.steps.clearfix li').removeClass('current').removeClass('done');
                        for (let index1 = 1; index1 < step; index1++) {
                            $('.steps.clearfix li:eq(' + (index1 - 1) + ')').addClass('done');
                        }
                        $('.steps.clearfix li:eq(' + (step - 1) + ')').addClass('current');
                        /*  console.log($('#create_property').offset().top); */
                        $('html, body').animate({
                            scrollTop: 100
                        }, 500);
                        $("#create_crm_submit").prop("disabled", false);
                    }


                    $('.fieldStep').hide();
                    $('.fieldStep.step' + step).css('display', 'block');

                    //console.log(bootstrapValidatorSteps);
                    if (step == 1) {
                        $('.actions.clearfix').find('button[data-type="previous"]').hide();
                        if (edit_account) {
                            $('.actions.clearfix').find('.finishStepone').css('display', 'inline-block');
                            $('.actions.clearfix').find('.finishSteptwo').hide();
                            $('.actions.clearfix').find('.cancelform').css('display', 'inline-block');
                        }

                        //bootstrapValidatorSteps.enableFieldValidators('zone', false);
                    } else if (step == 2) {
                        if (previousn_crm != 1) {
                            var bootstrapValidator = $('#crm_form').data('bootstrapValidator');
                            try {
                                bootstrapValidator.enableFieldValidators('groups', false);
                            } catch (e) {}
                        }
                        $('.actions.clearfix').find('button[data-type="previous"]').css('display', 'inline-block');
                        if (edit_account) {
                            $('.actions.clearfix').find('.finishStepone').hide();
                            $('.actions.clearfix').find('.finishSteptwo').css('display', 'inline-block');
                            $('.actions.clearfix').find('.cancelform').hide();
                        }
                        //if(document.getElementById("automation_property").checked){

                        //bootstrapValidatorSteps.enableFieldValidators('zone', true);
                        //}
                    } else {
                        $('.actions.clearfix').find('button[data-type="previous"]').css('display', 'inline-block');
                        if (edit_account) {
                            $('.actions.clearfix').find('.finishStepone').hide();
                            $('.actions.clearfix').find('.finishSteptwo').hide();
                            $('.actions.clearfix').find('.cancelform').hide();
                        }
                        //bootstrapValidatorSteps.enableFieldValidators('zone', false);
                    }

                    if (step == stepCount) {
                        $('.actions.clearfix').find('button[data-type="next"]').hide();
                        $('.actions.clearfix').find('.finishParent').css('display', 'inline-block');

                    } else {
                        $('.actions.clearfix').find('button[data-type="next"]').css('display', 'inline-block');
                        $('.actions.clearfix').find('.finishParent').hide();

                    }
                    //return stepListFull;
                    if(action=='ready'){
                        $('#crm_form').prepend(stepListFull);
                        //$(".finishParent").find('a[href$="#finish"]').replaceWith($('.submit-btn'));
                    }
                }

                async function setSteps_crm(step, stepCount, action, stepListFull) {
                    $('#msg27').empty();
                    var edit_account = "<?php echo $_GET['edit_loc_id']; ?>";
                    let submit_status;

                    /*if (action == 'next') {
                        await stepsubmit(step-1).then(function(res){
                            if(res===true){
                                stepSetter_crm(step, stepCount, action, stepListFull,edit_account);
                            }
                        });

                        return true;
                    }*/

                    stepSetter_crm(step, stepCount, action, stepListFull);
                }


                // $(document).ready(function(e) {
                //     var stepListFull = '<div class="steps clearfix" style="margin-top:20px"><ul role="tablist">';
                //     var stepCount = 0;
                //     $('#crm_form fieldset').each(function(index, element) {
                //         $(this).addClass('step' + (index + 1)).addClass('fieldStep');
                //         stepListFull += stepList_crm((index + 1), $(this).attr('data-name'));
                //         stepCount++;
                //     });
                //     stepListFull += '</ul></div>';

                //     setSteps_crm(1, stepCount, 'ready', stepListFull);

                // });

            var previousn_crm;
            $('.actions.clearfix').find('button[data-type="previous"]').bind('click', function(e) {
                previousn_crm = 1;
                setSteps_crm((parseInt($('.steps.clearfix li.current').attr('data-step')) - 1), $('#crm_form fieldset').length, 'previous', undefined);
                e.preventDefault();
            });

            $('.actions.clearfix').find('button[data-type="next"]').bind('click',async function(e) {
                let in_html = $(this).html();
                $(this).attr('disabled','disabled');
                $(this).html('<img src="img/loading_me.gif">');
                setSteps_crm((parseInt($('.steps.clearfix li.current').attr('data-step')) + 1), $('#crm_form fieldset').length, 'next', undefined);
                $(this).attr('disabled',false);
                $(this).html(in_html);
                e.preventDefault();
            });
    </script>