<div class="tab-pane fade in active" id="assign_location_admin">
    <div class="header2_part1"><h2>Assign Property Admin </h2></div>



    <p>Change the name and email to the person you want to assign as property admin and click the Assign button. The person will get an activation email with instructions how to activate the account. The assigned admin will log in directly to the property Admin from the general login using its own unique credentials. </p>
    <br><br>
    <form autocomplete="off" id="edit_profile_form" action="?token7=<?php echo $secret;?>&t=edit_parent&edit_parent_id=<?php echo $assign_edit_parent_id  ;?>" method="post" class="form-horizontal" >

        <fieldset>






            <div class="control-group">
                <label class="control-label" for="full_name_1">Property ID<sup><font color="#FF0000" ></font></sup></label>

                <div class="controls col-lg-5 form-group">
                    <input class="form-control span4" id="ed_property_id" name="ed_property_id" type="text" value="<?php echo  $assign_edit_propertyid; ?>" disabled>
                </div>
                <!-- /controls -->
            </div>


            <!-- /control-group -->


            <div class="control-group">
                <label class="control-label" for="full_name_1">Account Name <sup><font color="#FF0000" ></font></sup></label>

                <div class="controls col-lg-5 form-group">
                    <input class="form-control span4" id="ed_account_name" name="ed_account_name" type="text" value="<?php echo $assign_edit_distributor_name; ?>" disabled>
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->

            <input  id="ed_user_id" name="ed_user_id" type="hidden" value="<?php echo  $assign_ad_id; ?>" >
            <input  id="ed_distributor_code" name="ed_distributor_code" type="hidden" value="<?php echo  $assign_distributor_code; ?>" >
            <input  id="ed_verification_number" name="ed_verification_number" type="hidden" value="<?php echo  $assign_verification_number; ?>" >
            <input  id="ed_mno" name="ed_mno" type="hidden" value="<?php echo  $assign_mno_id; ?>" >

            <input  id="customer_type" name="customer_type" type="hidden" value="<?php echo  $assign_customer_type; ?>" >

            <input type="hidden" name="form_secret5" id="form_secret5" value="<?php echo $_SESSION['FORM_SECRET'] ?>" >

            <div class="control-group">
                <label class="control-label" for="full_name_1">Admin First Name <sup><font color="#FF0000" ></font></sup></label>

                <div class="controls col-lg-5 form-group">
                    <input class="form-control span4" id="ed_first_name" name="ed_first_name" type="text" value="<?php echo $assign_edit_first_name; ?>">
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->
            <div class="control-group">
                <label class="control-label" for="full_name_1">Admin Last Name <sup><font color="#FF0000" ></font></sup></label>

                <div class="controls col-lg-5 form-group">
                    <input class="form-control span4" id="ed_last_name" name="ed_last_name" type="text" value="<?php echo $assign_edit_last_name; ?> ">
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->


            <div class="control-group">
                <label class="control-label" for="email_1">Admin Email<sup><font color="#FF0000" ></font></sup></label>

                <div class="controls form-group col-lg-5">
                    <input class="form-control span4" id="ed_ad_email" name="ed_ad_email" value="<?php echo  $assign_edit_email; ?>" placeholder="name@mycompany.com" >
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->



            <div class="control-group">
                <label class="control-label" for="email_1">Phone Number<sup><font color="#FF0000" ></font></sup></label>

                <div class="controls form-group col-lg-5">
                    <input class="form-control span4" id="mobile_1" name="mobile_1" value="<?php echo  $assign_edit_phone; ?>" placeholder="xxx-xxx-xxxx" maxlength="12" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$">


                    <script type="text/javascript">

                        $(document).ready(function() {

                            $('#mobile_1').focus(function(){
                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                            });

                            $('#mobile_1').keyup(function(){
                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                            });

                            $("#mobile_1").keydown(function (e) {


                                var mac = $('#mobile_1').val();
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

                                    if(len == 4){
                                        $('#mobile_1').val(function() {
                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                            //console.log('mac1 ' + mac);

                                        });
                                    }
                                    else if(len == 8 ){
                                        $('#mobile_1').val(function() {
                                            return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                            //console.log('mac2 ' + mac);

                                        });
                                    }
                                }


                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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


                </div>
                <!-- /controls -->
            </div>


            <div class="form-actions">
                <button type="submit"  name="submit_assign_user" id="submit_assign_user" class="btn btn-primary" disabled="disabled">Assign</button>&nbsp; <strong><font color="#FF0000"></font><small></small></strong>

                <a href="?token7=<?php echo $secret;?>&t=edit_parent&edit_parent_id=<?php echo $assign_edit_parent_id  ;?>" style="text-decoration:none;" class="btn btn-info inline-btn">Cancel</a>
            </div>
            <!-- /form-actions -->

        </fieldset>
    </form>

</div>
