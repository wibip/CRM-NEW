
<div class="main" >
        <div class="main-inner" >
            <div class="container">
                <div class="row">
                    <div class="span12">
                    <?php if(isset($_GET['view_loc_code'])){ ?>
                           <a href="location.php" class="" style="font-size: 16px;  font-weight: 600; color: #0679CA;float:left; margin-top: 8px; position: relative; margin-left:20px;">
                            &lt; Back
                        </a>
                        <?php } ?>
                           <br><br>
                        <div class="widget ">

                                    
                                    
                                    
                            <div class="widget-header">
                                <!-- <i class="icon-sitemap"></i> -->
                            <?php if($user_type=='ADMIN'){
                                
                                    ?>
                                <h3>Manage Operations</h3>
                                
                                <?php }else {
                                if (isset($_GET['view_loc_code'])) {
                                    echo '<h3>View Property and AP information</h3>';
                                } else {


                                    echo '<h3>View and Manage Properties</h3>';
                                }
                            }?>
                            </div><!-- /widget-header -->
                            <?php

                            if(isset($_SESSION['msg10'])){
                                echo $_SESSION['msg10'];
                                unset($_SESSION['msg10']);

                            }


                            if(isset($_SESSION['msg9'])){
                                echo $_SESSION['msg9'];
                                unset($_SESSION['msg9']);
                            }


                            if(isset($_SESSION['msg3'])){
                                echo $_SESSION['msg3'];
                                unset($_SESSION['msg3']);
                            }


                            if(isset($_SESSION['msg14'])){
                                echo $_SESSION['msg14'];
                                unset($_SESSION['msg14']);
                            }


                            if(isset($_SESSION['msg24'])){
                                echo $_SESSION['msg24'];
                                unset($_SESSION['msg24']);
                            }



                            if(isset($_SESSION['msg6'])){
                                echo $_SESSION['msg6'];
                                unset($_SESSION['msg6']);
                            }





                            if(isset($_SESSION['msg11'])){
                                echo $_SESSION['msg11'];
                                unset($_SESSION['msg11']);
                            }


                            if(isset($_SESSION['msg5'])){
                                echo $_SESSION['msg5'];
                                unset($_SESSION['msg5']);
                            }


                            if(isset($_SESSION['msg12'])){
                                echo $_SESSION['msg12'];
                                unset($_SESSION['msg12']);
                            }

                            if(isset($_SESSION['msg13'])){
                                echo $_SESSION['msg13'];
                                unset($_SESSION['msg13']);
                            }



                            if(isset($_SESSION['msg7'])){
                                echo $_SESSION['msg7'];
                                unset($_SESSION['msg7']);
                            }



                            if(isset($_SESSION['msg20'])){
                                echo $_SESSION['msg20'];
                                unset($_SESSION['msg20']);
                            }

                            if(isset($tab11)){
                                }?>

                            <div class="widget-content">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs">

                                        <?php
                                            if($user_type == 'MNO' || $user_type == 'MVNE' || $user_type == 'MVNO' || $user_type == 'SUPPORT' || $user_type == 'SALES'){
                                        ?>
                                            <li <?php if(isset($tab1)){?>class="active" <?php }?>><a href="#live_camp" data-toggle="tab"><?php if(isset($_GET['view_loc_code'])){ echo 'View Account'; }else {echo 'Active';}?></a></li>

                                                <?php if($edit_parent_on ==1 ) { ?>
                                                    <li <?php if (isset($tab12)){ ?>class="active" <?php } ?>><a
                                                                href="#edit_parent"
                                                                data-toggle="tab"> Edit Business ID Profile </a></li>

                                                    <?php
                                                }
                                            }
                                        ?>



                                        <?php
                                            if($user_type == 'MVNE' || $user_type == 'MVNO') {

                                            }
                                            if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE' || $user_type == 'SUPPORT' || $user_type == 'SALES'){
                                                if(!in_array('support', $access_modules_list) || $edit_account=='1'||  $user_type == 'SALES') {
                                                    ?>

                                                    <li <?php if (isset($tab5)){ ?>class="active" <?php } ?>><a
                                                            href="#create_location"
                                                            data-toggle="tab"><?php if ($edit_account == '1') echo 'Edit SMB Account'; else echo 'Create'; ?></a>
                                                    </li>
                                                    <?php
                                                }

                                                if(in_array('support', $access_modules_list) && isset($_GET['assign_loc_admin'])) {
                                                    ?>

                                                    <li class="active" ><a
                                                                href="#assign_loc_admin"
                                                                data-toggle="tab">Assign Property Admin</a>
                                                    </li>
                                                    <?php
                                                }

                                        }
                                        
                                            if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE' || $user_type == 'SUPPORT' || $user_type == 'SALES'){
                                        ?>
                                            <li <?php if(isset($tab9)){?>class="active" <?php }?>><a href="#assign_ap" data-toggle="tab">Activate</a></li>
                                            <?php
                                        }

                                        if($user_type == 'ADMIN'){
                                            ?>

                                            <li <?php if(isset($tab8)){?>class="active" <?php }?>><a href="#active_mno" data-toggle="tab">Active <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></a></li>

                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if($user_type == 'ADMIN'){
                                        ?>
                                            <li <?php if(isset($tab6)){?>class="active" <?php }?>><a href="#mno_account" data-toggle="tab"><?php if($mno_edit==1){echo"Edit ". $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'")." Account";}else{echo"Create ". $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'")." Account";};?></a></li>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if($user_type == 'ADMIN'){
                                            ?>

                                            <li <?php if(isset($tab11)){?>class="active" <?php }?>><a href="#saved_mno" data-toggle="tab">Activate <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></a></li>

                                        <?php

                                        }
                                        ?>


                                    </ul>
                                    <br class="mobile-hide">


                                    <div class="tab-content">

                                        <?php if(isset($_GET['assign_loc_admin'])){ ?>
                                            <div class="tab-pane fade in active" id="assign_loc_admin">
                                                <div class="header2_part1"><h2>Assign Property Admin </h2></div>



                                                <p>Change the name and email to the person you want to assign as property admin and click the Assign button. The person will get an activation email with instructions how to activate the account. The assigned admin will log in directly to the property Admin from the general login using its own unique credentials. </p>
                                                <br><br>
                                                <form autocomplete="off" id="edit_profile_form" action="?token7=<?php echo $secret;?>&t=12&edit_parent_id=<?php echo $assign_edit_parent_id  ;?>" method="post" class="form-horizontal" >

                                                    <fieldset>






                                                        <div class="control-group">

                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="full_name_1">Property ID<sup><font color="#FF0000" ></font></sup></label>
                                                                <input class="form-control span4" id="ed_property_id" name="ed_property_id" type="text" value="<?php echo  $assign_edit_propertyid; ?>" disabled>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>


                                                        <!-- /control-group -->


                                                        <div class="control-group">

                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="full_name_1">Account Name <sup><font color="#FF0000" ></font></sup></label>
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

                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="full_name_1">Admin First Name <sup><font color="#FF0000" ></font></sup></label>
                                                                <input class="form-control span4" id="ed_first_name" name="ed_first_name" type="text" value="<?php echo $assign_edit_first_name; ?>">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">

                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="full_name_1">Admin Last Name <sup><font color="#FF0000" ></font></sup></label>
                                                                <input class="form-control span4" id="ed_last_name" name="ed_last_name" type="text" value="<?php echo $assign_edit_last_name; ?> ">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">

                                                            <div class="controls form-group col-lg-5">
                                                            <label class="" for="email_1">Admin Email<sup><font color="#FF0000" ></font></sup></label>
                                                                <input class="form-control span4" id="ed_ad_email" name="ed_ad_email" value="<?php echo  $assign_edit_email; ?>" placeholder="name@mycompany.com" >
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->



                                                        <div class="control-group">

                                                            <div class="controls form-group col-lg-5">
                                                            <label class="" for="email_1">Phone Number<sup><font color="#FF0000" ></font></sup></label>
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

                                                            <a href="?token7=<?php echo $secret;?>&t=12&edit_parent_id=<?php echo $assign_edit_parent_id  ;?>" style="text-decoration:none;" class="btn btn-info inline-btn">Cancel</a>
                                                        </div>
                                                        <!-- /form-actions -->

                                                    </fieldset>
                                                </form>

                                            </div>


                                        <?php } ?>

                                        <div <?php if(isset($tab12)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="edit_parent">

                                            <form action="?t=5<?php if(isset($get_edit_parent_id)) echo '&location_parent_id='.$get_edit_parent_id.'&token7='.$secret.'&t=12&edit_parent_id='.$get_edit_parent_id; ?>" id="parent_form" name="parent_form" class="form-horizontal" method="POST"   >

                                                <?php
                                                echo '<input type="hidden" name="form_secret12" id="form_secret12" value="'.$secret.'" />';
                                                ?>

                                                <fieldset>


                                                        <div class="control-group">
                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="mno_full_name">Business ID</label>
                                                                <input maxlength="12" readonly class="span4 form-control" id="up_parent_id" placeholder="" name="parent_id" type="text" value="<?php echo$get_edit_parent_id;?>">
                                                                <script type="text/javascript">
                                                                    $("#up_parent_id").keypress(function(event){
                                                                        var ew = event.which;
                                                                        if(ew == 32)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122 || ew == 0  || ew == 8 || ew == 189)
                                                                            return true;
                                                                        return false;
                                                                    });
                                                                </script>
                                                            </div>
                                                        </div>

                                                    <div class="control-group">
                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="mno_full_name">Business Account Name</label>
                                                                <input class="span4 form-control" id="parent_ac_name" placeholder="" name="parent_ac_name" type="text" value="<?php echo str_replace("\\",'',$get_edit_parent_ac_name); ?>">
                                                            </div>
                                                        </div>
                                                    <div class="control-group">
                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="mno_full_name">First Name</label>
                                                                <input class="span4 form-control pname" id="parent_first_name" placeholder="Full Name" name="parent_first_name" type="text" maxlength="12" value="<?php echo$edit_parent_first_name;?>">
                                                            </div>
                                                        </div>

                                                    <div class="control-group">
                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="mno_full_name">Last Name</label>
                                                                <input class="span4 form-control pname" id="parent_last_name" placeholder="Full Name" name="parent_last_name" type="text" maxlength="12" value="<?php echo$edit_parent_last_name;?>">
                                                            </div>
                                                        </div>
                                                    <script>
                                                    
                                                    $(".pname").keyup(function() {
                                                     $(this).val($(this).val().replace(/\s/g, ""));
                                                    });
                                                    
                                                    </script>

                                                        <div class="control-group">
                                                        <!--<div style="display: inline-block;width: 68%;">-->
                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="mno_email">Email</label>
                                                                <input class="span4 form-control" id="parent_email" name="parent_email" type="text" placeholder="wifi@company.com" value="<?php echo $edit_parent_email;?>">
                                                                <input type="checkbox" data-toggle="tooltip" title="Alert! Checking this box and submitting change will update/replace Business Admin Credentials. Submitting will also require update to User ID and Password." id="parent_username_change" name="parent_username_change"><font id="replace_user_lbl" style="width: 40%;">Update/Replace Business Admin Credentials</font>
                                                                <style type="text/css">
                                                                input[id="parent_username_change"] + label{
                                                                    margin-right: 0px !important;
                                                                }
                                                                    @media only screen and (min-width : 768px) {
                                                                        #replace_user_lbl {
                                                                            float: right;
                                                                        }
                                                                    }
                                                                </style>
                                                                <div style="display:none" id="parent_update_conf_msg" >Are you sure you want to update this account?</div>
                                                                <script type="text/javascript">
                                                                    $('#parent_username_change').click(function(){
                                                                        setTimeout(function () {
                                                                            if($('#parent_username_change').is(':checked')){
                                                                                $('#submit_p_form_confirm').addClass('parent-update-conf-div-long');
                                                                                $('#submit_p_form_confirm').removeClass('parent-update-conf-div-small');
                                                                                $('#parent_update_conf_msg').html('Warning! Submitting this change will update current Business Admin </br>or establish a New Business Admin credentials. Submitting will also</br> require update to User ID and Password');
                                                                            }else{
                                                                                $('#submit_p_form_confirm').addClass('parent-update-conf-div-small');
                                                                                $('#submit_p_form_confirm').removeClass('parent-update-conf-div-long');
                                                                                $('#parent_update_conf_msg').html('Are you sure you want to update this account?');
                                                                            }

                                                                            eval($('#easy_confirm').html());
                                                                        },5);
                                                                    })
                                                                </script>
                                                            </div>
                                                        <!--</div>-->
                                                            <!--<div style="display: inline-block;width: 31%;position: absolute;"> Update/Replace Business Admin Credentials</div>-->
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_email"></label>
                                                             <input type="hidden" id="check_p_email" value="<?php echo $edit_parent_email;?>">
                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control" id="change_0" name="change_0" type="hidden" placeholder="wifi@company.com" value="<?php echo $edit_parent_email;?>">
                                                            </div>
                                                        </div>
                                                       

                                                    <?php

                                                    $parent_package=$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);
                                                    $parent_package_array =explode(',',$parent_package);
                                                    //print_r($parent_package_array);
                                                    if(count($parent_package_array)>1){
                                                        
                                                        
                                                                                        ?>

                                                                                         <div class="control-group">
                                                                                            <div class="controls col-lg-5 form-group">
                                                                                            <label class="" for="parent_package_type">Admin Type</label>
                                                                                            <?php
                                                                                                    echo'<select class="span4 form-control" id="parent_package" name="parent_package_type">';
                                                                                                    echo '<option value="">Select Business ID type</option>';

                                                                                                    foreach($parent_package_array as $value){
                                                                                                        $parent_package_name = $db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");
                                                                                                        echo '<option value="'.$value.'"';
                                                                                                        if($edit_parent_system_package == $value){
                                                                                                            echo ' selected';
                                                                                                        }
                                                                                                        echo '>'.$parent_package_name.'</option>';
                                                                                                    }
                                                                                                         echo '</select>';
                                                                                                 ?>
                                                                                            </div>
                                                                                         </div>
                                                                                         <?php
                                                                                         
/*
                                                        ?>

                                                        <div class="control-group">
                                                            <label class="control-label" for="parent_package_type">Admin Type</label>
                                                            <div class="controls col-lg-5 form-group">

                                                                    <input readonly class="span4 form-control" type="text" placeholder=""   value="<?php echo $package_functions->getPackageName($edit_parent_system_package); ?>">
                                                                    <input  id="parent_package_type" name="parent_package_type" type="hidden" placeholder="BBB"   value="<?php echo $edit_parent_system_package; ?>">

                                                            </div>
                                                        </div>
                                                    <?php
*/
                                                    }else{
                                                        echo ' <div class="control-group"> <div class="controls col-lg-5 form-group"><input   id="parent_package_type" name="parent_package_type" type="hidden" value="'.$parent_package_array[0].'"></div></div>';
                                                    } ?>






                                                    <div class="form-actions">

                                                        <button onmouseover="parent_btn_action('submit_p_form');" disabled type="submit" id="submit_p_form" value="submit_p_form" name="submit_p_form" class="btn btn-primary" onClick="(function(){
                                                            $('#submit_p_form_confirm_text').html($('#parent_update_conf_msg').html());
                                                            $('.ui-widget-overlay').show();
                                                            $('#submit_p_form_confirm').show();
                                                                    return false;
                                                                })();return false;">Update Account</button>

                                                        <?php if(!in_array('support', $access_modules_list)){ ?>
                                                        <button onmouseover="parent_btn_action('add_location');" type="submit" name="add_location" id="add_location" value="add_location" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>
                                                        <?php } ?>
                                                        <button type="button" class="btn btn-info inline-btn"  onclick="gopto();" >Cancel</button>
                                                        <input type="hidden" name="p_update_button_action" id="p_update_button_action">

                                                    </div>
                                                        <script type="text/javascript">
                                                            function parent_btn_action(action) {
                                                                $('#p_update_button_action').val(action);
                                                            }

                                                        function gopto(url){
                                                            window.location = "?";
                                                        }
                                                    </script>
                                                    <!-- /form-actions -->

                                                </fieldset>

                                            </form>

                                                        <div class="widget widget-table action-table">

                                                            <div class="widget-header">

                                                            <!--  <i class="icon-th-list"></i> -->

                                                            <h3>Locations</h3>

                                                            </div>

                                                            <!-- /widget-header -->

                                                            <div class="widget-content table_response" id="location_div">
                                                            <div style="overflow-x:auto">

                                                            <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                                                                <?php  if(array_key_exists('how_many_buildings',$field_array)){ 

                                                            $location_q = "SELECT t.*,GROUP_CONCAT(' ',j.`icom`) AS icom FROM (SELECT DISTINCT  d.`gateway_type`,d.id AS dis_id,d.`distributor_code`,d.`distributor_name`,d.`distributor_type` ,d.`state_region` ,d.`mno_id`,d.`country`,u.id AS userid,u.`verification_number`,u.is_enable,u.user_name
                                                                                FROM `exp_mno_distributor` d
                                                                                LEFT JOIN admin_users u ON d.`distributor_code`=u.`user_distributor`
                                                                                WHERE d.parent_id = '$get_edit_parent_id'
                                                                                AND u.access_role='admin' ORDER BY u.`verification_number` ASC) t  LEFT JOIN `exp_icoms` j ON t.distributor_code=j.distributor GROUP BY j.distributor";
                                                        ?>

                                                        <thead>


                                                        <tr>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Location/Realm ID</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">ICOM(S)</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Name</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">GATEWAY</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                                                            <?php  if(in_array('support', $access_modules_list)){ ?>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">ASSIGNED ADMIN</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">UNASSIGNED ADMIN</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Resend</th>
                                                            <?php } ?>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Remove</th>

                                                        </tr>




                                                            </thead>

                                                            <tbody>



                                                            <?php





                                                            $query_results=$db->selectDB($location_q);
                                                            foreach($query_results['data'] AS $row){

                                                                $distributor_code = $row[distributor_code];
                                                                $distributor_name = str_replace("\\",'',$row[distributor_name]);
                                                                $distributor_type = $row[distributor_type];
                                                                $distributor_icoms = $row[verification_number];
                                                                $icomArr = $row[icom];

                                                                $distributor_gateway_type = $row[gateway_type];

                                                                $distributor_id_number = $row[dis_id];
                                                                $userid = $row[userid];
                                                                $distributor_user_name = $row['user_name'];
                                                                $is_enable = $row[is_enable];
                                                                if(empty($distributor_user_name)|| $is_enable==8){
                                                                    $pa_act_user = "NO";
                                                                }else{
                                                                    $pa_act_user= "YES";
                                                                }

                                                                $distributor_name_display=str_replace("'","\'",$distributor_name);

                                                                echo '<tr>';
                                                                echo '<!--<td> '.$db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'").' </td> -->

                                                                <td> '.$distributor_icoms.' </td>
                                                                <td> '.$icomArr.' </td>
                                                                <td> '.$distributor_name.' </td>
                                                                
                                                                <td> '.$distributor_gateway_type.' </td>';

                                                                echo '<td><a href="javascript:void();" id="EDITACCd_'.$distributor_id_number.'"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITACCd_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITACCd_'.$distributor_id_number.'\').click(function() {
                                                            window.location = "?token7='.$secret.'&t=5&edit_loc_id='.$distributor_id_number.'&location_parent_id='.$get_edit_parent_id.'"

                                                        });

                                                        });

                                                    </script></td>';


                                                              if(in_array('support', $access_modules_list)) {
                                                                  echo '<td>' . $pa_act_user . ' &nbsp;/';

                                                                  echo '<a href="javascript:void();" id="ed_' . $distributor_icoms . '"  class="btn btn-small btn-primary">
                                            <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Edit</a><script type="text/javascript">
                                            $(document).ready(function() {
                                            $(\'#ed_' . $distributor_icoms . '\').easyconfirm({locale: {
                                                    title: \'Assign Admin \',
                                                    text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                    button: [\'Cancel\',\' Confirm\'],
                                                    closeText: \'close\'
                                                     }});
                                                $(\'#ed_' . $distributor_icoms . '\').click(function() {
                                                    window.location = "?t=13tokene=' . $secret . '&assign_loc_admin=' . $distributor_id_number . '"
                                                });
                                                });
                                            </script>';


                                                                  echo '</td>';
                                                                  
                                                                  echo '<td>';
                                                                  if( $is_enable=='8'){
                                                                    echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                          <i class="btn-icon-only icon-envelope"></i>Unassign</a>';
                                                                }else{
                                                                    
                                                                    //t=12&edit_parent_id
                                                                    echo '<a href="javascript:void();" id="Unassign_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                          <i class="btn-icon-only icon-envelope"></i>Unassign</a><script type="text/javascript">
                                                          $(document).ready(function() {
                                                          $(\'#Unassign_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                  title: \'Unassign Admin\',
                                                                  text: \'Are you sure you want to Unassign this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                  button: [\'Cancel\',\' Confirm\'],
                                                                  closeText: \'close\'
                                                                   }});
                                                              $(\'#Unassign_'.$distributor_id_number.'\').click(function() {
                                                                window.location = "?t=12&tokene=' . $secret . '&unassign_loc_admin=' . $userid .'&edit_parent_id='.$get_edit_parent_id.'"
                                                              });
                                                              });
                                                          </script>';

                                                                
                                                                }

                                                                echo '</td>';
                                                                  
                                                                  
                                                                  echo '<td>';

                                                                  if($pa_act_user=='YES' && $is_enable=='2'){
                                                                      //t=12&edit_parent_id
                                                                      echo '<a href="javascript:void();" id="resend_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#resend_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                    title: \'Resend Email\',
                                                                    text: \'Are you sure you want to resend email?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#resend_'.$distributor_id_number.'\').click(function() {
                                                                    window.location = "?tokene='.$secret.'&e_resend_a='.$distributor_code.'&t=12&edit_parent_id='.$get_edit_parent_id.'"
                                                                });
                                                                });
                                                            </script>';

                                                                  }else{
                                                                      echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a>';
                                                                  }

                                                                  echo '</td>';



                                                               



                                                              }


                                                                echo '<td><a href="javascript:void();" id="DISTRI_'.$distributor_id_number.'"  class="btn btn-small btn-primary" >

                                <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><img id="distributor_loader_'.$distributor_id_number.'" src="img/loading_ajax.gif" style="display:none;"><script type="text/javascript">

                                    $(document).ready(function() {

                                    $(\'#DISTRI_'.$distributor_id_number.'\').easyconfirm({locale: {
                                            title: \'Account Remove\',
                                            text: "Are you sure you want to remove[ '.$distributor_icoms.' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#DISTRI_'.$distributor_id_number.'\').click(function() {
                                            window.location = "?token7='.$secret.'&t=12&remove_loc_code='.$distributor_code.'&remove_loc_name='.$distributor_name.'&remove_loc_id='.$distributor_id_number.'&edit_parent_id='.$get_edit_parent_id.'"
                                        });
                                        });
                                    </script></td>';





                                                                echo '</tr>';

                                                            }
                                                            ?>


                                                            </tbody>


                                                        <?php }else{ 

                                                            $location_q = "SELECT DISTINCT  d.`gateway_type`,d.id AS dis_id,d.`distributor_code`,d.`distributor_name`,d.`distributor_type` ,d.`state_region` ,d.`mno_id`,d.`country`,u.id AS userid,u.`verification_number`,u.is_enable,u.user_name
                                                                                FROM `exp_mno_distributor` d
                                                                                LEFT JOIN admin_users u ON d.`distributor_code`=u.`user_distributor`
                                                                                WHERE d.parent_id = '$get_edit_parent_id'
                                                                                AND u.access_role='admin' ORDER BY u.`verification_number` ASC";
                                                        ?>

                                                        <thead>


                                                        <tr>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Location/ Realm/ Property ID</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Name</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">GATEWAY</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                                                            <?php  if(in_array('support', $access_modules_list)){ ?>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">ASSIGNED ADMIN</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">UNASSIGNED ADMIN</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Resend</th>
                                                            <?php } ?>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>

                                                        </tr>




                                                            </thead>

                                                            <tbody>



                                                            <?php





                                                            $query_results=$db->selectDB($location_q);
                                                            foreach($query_results['data'] AS $row){

                                                                $distributor_code = $row[distributor_code];
                                                                $distributor_name = str_replace("\\",'',$row[distributor_name]);
                                                                $distributor_type = $row[distributor_type];
                                                                $distributor_icoms = $row[verification_number];

                                                                $distributor_gateway_type = $row[gateway_type];

                                                                $distributor_id_number = $row[dis_id];
                                                                $userid = $row[userid];
                                                                $distributor_user_name = $row['user_name'];
                                                                $is_enable = $row[is_enable];
                                                                if(empty($distributor_user_name)|| $is_enable==8){
                                                                    $pa_act_user = "NO";
                                                                }else{
                                                                    $pa_act_user= "YES";
                                                                }

                                                                $distributor_name_display=str_replace("'","\'",$distributor_name);

                                                                echo '<tr>';
                                                                echo '<!--<td> '.$db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'").' </td> -->

                                                                <td> '.$distributor_icoms.' </td>
                                                                <td> '.$distributor_name.' </td>
                                                                
                                                                <td> '.$distributor_gateway_type.' </td>';

                                                                echo '<td><a href="javascript:void();" id="EDITACCd_'.$distributor_id_number.'"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITACCd_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITACCd_'.$distributor_id_number.'\').click(function() {
                                                            window.location = "?token7='.$secret.'&t=5&edit_loc_id='.$distributor_id_number.'&location_parent_id='.$get_edit_parent_id.'"

                                                        });

                                                        });

                                                    </script></td>';


                                                              if(in_array('support', $access_modules_list)) {
                                                                  echo '<td>' . $pa_act_user . ' &nbsp;/';

                                                                  echo '<a href="javascript:void();" id="ed_' . $distributor_icoms . '"  class="btn btn-small btn-primary">
                                            <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Edit</a><script type="text/javascript">
                                            $(document).ready(function() {
                                            $(\'#ed_' . $distributor_icoms . '\').easyconfirm({locale: {
                                                    title: \'Assign Admin \',
                                                    text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                    button: [\'Cancel\',\' Confirm\'],
                                                    closeText: \'close\'
                                                     }});
                                                $(\'#ed_' . $distributor_icoms . '\').click(function() {
                                                    window.location = "?t=13tokene=' . $secret . '&assign_loc_admin=' . $distributor_id_number . '"
                                                });
                                                });
                                            </script>';


                                                                  echo '</td>';
                                                                  
                                                                  echo '<td>';
                                                                  if( $is_enable=='8'){
                                                                    echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                          <i class="btn-icon-only icon-envelope"></i>Unassign</a>';
                                                                }else{
                                                                    
                                                                    //t=12&edit_parent_id
                                                                    echo '<a href="javascript:void();" id="Unassign_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                          <i class="btn-icon-only icon-envelope"></i>Unassign</a><script type="text/javascript">
                                                          $(document).ready(function() {
                                                          $(\'#Unassign_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                  title: \'Unassign Admin\',
                                                                  text: \'Are you sure you want to Unassign this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                  button: [\'Cancel\',\' Confirm\'],
                                                                  closeText: \'close\'
                                                                   }});
                                                              $(\'#Unassign_'.$distributor_id_number.'\').click(function() {
                                                                window.location = "?t=12&tokene=' . $secret . '&unassign_loc_admin=' . $userid .'&edit_parent_id='.$get_edit_parent_id.'"
                                                              });
                                                              });
                                                          </script>';

                                                                
                                                                }

                                                                echo '</td>';
                                                                  
                                                                  
                                                                  echo '<td>';

                                                                  if($pa_act_user=='YES' && $is_enable=='2'){
                                                                      //t=12&edit_parent_id
                                                                      echo '<a href="javascript:void();" id="resend_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#resend_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                    title: \'Resend Email\',
                                                                    text: \'Are you sure you want to resend email?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#resend_'.$distributor_id_number.'\').click(function() {
                                                                    window.location = "?tokene='.$secret.'&e_resend_a='.$distributor_code.'&t=12&edit_parent_id='.$get_edit_parent_id.'"
                                                                });
                                                                });
                                                            </script>';

                                                                  }else{
                                                                      echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a>';
                                                                  }

                                                                  echo '</td>';



                                                               



                                                              }


                                                                echo '<td><a href="javascript:void();" id="DISTRI_'.$distributor_id_number.'"  class="btn btn-small btn-primary" >

                                <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><img id="distributor_loader_'.$distributor_id_number.'" src="img/loading_ajax.gif" style="display:none;"><script type="text/javascript">

                                    $(document).ready(function() {

                                    $(\'#DISTRI_'.$distributor_id_number.'\').easyconfirm({locale: {
                                            title: \'Account Remove\',
                                            text: "Are you sure you want to remove[ '.$distributor_icoms.' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#DISTRI_'.$distributor_id_number.'\').click(function() {
                                            window.location = "?token7='.$secret.'&t=12&remove_loc_code='.$distributor_code.'&remove_loc_name='.$distributor_name.'&remove_loc_id='.$distributor_id_number.'&edit_parent_id='.$get_edit_parent_id.'"
                                        });
                                        });
                                    </script></td>';





                                                                echo '</tr>';

                                                            }
                                                            ?>


                                                            </tbody>
                                                        <?php } ?>
                                                            </table>
                                                            </div>
                                                            </div>
                                                            </div>



                                                            </div>


                                        <!-- ******************************************************* -->
                                        <div <?php if(isset($tab6)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="mno_account">




                                            <form onkeyup="submit_mno_formfn();" onchange="submit_mno_formfn();" id="mno_form" name="mno_form" class="form-horizontal" method="POST" action="location.php?<?php if($mno_edit==1){echo "t=8&mno_edit=1&mno_edit_id=$edit_mno_id";}else{echo "t=6";}?>" >

                                                                     <?php
                                                                        echo '<input type="hidden" name="form_secret6" id="form_secret6" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                                     ?>

                                                                        <fieldset>

                                                                        <div id="response_mno">

                                                                        </div>



                                    <style type="text/css">
                                        .ms-container{
                                            display: inline-block !important;
                                        }
                                    </style>
                                         <div class="control-group">
                                              <div class="controls col-lg-5 form-group">
                                            <label class="" for="AP_cont">AP Controller<sup><font color="#FF0000"></font></sup></label>
                                               <select multiple="multiple" name="AP_cont[]" id="AP_cont"  class="span4 form-control">
                                                                                     <!--  <option value="">-- Select AP Controller --</option> -->
                                                    <?php

                                                          $q1 = "SELECT o.`controller_name`,o.`type` FROM `exp_locations_ap_controller` o
                                                           LEFT JOIN `exp_mno_ap_controller` m ON m.ap_controller = o.`controller_name`
                                                           WHERE m.ap_controller IS NULL
                                                           ORDER BY o.`controller_name`";


                                                               $query_results=$db->selectDB($q1);
                                                                foreach($query_results['data'] AS $row) {

                                                                    $dis_code = $row[controller_name];
                                                                    $dis_type = $row[type];

                                                                    echo "<option value='" . $dis_code . "'>" . $dis_code . "(" . $dis_type . ")" . "</option>";

                                                                }
                                                                if($mno_edit=="1") {

                                                                    foreach ($ap_controler_array as &$value) {

                                                                        echo "<option  selected value='" . $value[0] . "'>" . $value[0] . "(".$value[1].")</option>";
                                                                    }
                                                                }
                                                                           ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->





                                                                            <!-- /wag profiles -->

                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_wag_profiles">Assigned WAG's<sup><font color="#FF0000"></font></sup></label>

                                                                                    <textarea style="resize: vertical;" class="span4 form-control" rows="5" id="mno_wag_profiles" name="mno_wag_profiles" readonly ><?php echo $edit_wag_prof_string; ?></textarea>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>




                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_account_name"><?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?> Name<sup><font color="#FF0000"></font></sup></label>
                                                                                        <input class="span4 form-control form-control" id="mno_account_name" placeholder="Wifi Provider Ltd" name="mno_account_name" type="text" value="<?php echo$get_edit_mno_description;?>">
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5">
                                                                                <label class="" for="mno_user_type">Account Type<sup><font color="#FF0000"></font></sup></label>
                                                                                    <select name="mno_user_type" id="mno_user_type"  class="span4 form-control form-control" <?php if($mno_edit==1) echo "readonly";?>>
                                                                                        <option value="">Select Type of Account</option>
                                                                                        <?php
                                                                                            if($user_type == 'ADMIN'){

                                                                                                $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=1 AND `is_enable`=1";
                                                                                                $mno_flow=mysql_query($mno_flow_q);
                                                                                                while($mno_flow_row=mysql_fetch_assoc($mno_flow)){
                                                                                                    if($get_edit_mno_user_type==$mno_flow_row[flow_type]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                                                                                }

                                                                                        }

                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                                <?php



                                                                                $mno_operator_check="SELECT p.product_code,p.`product_name`,c.options
                                                                                                        FROM `admin_product` p LEFT JOIN admin_product_controls c ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                                                                                        WHERE `is_enable` = '1' AND p.`user_type` = 'MNO'";

                                                                                $mno_op=$db->selectDB($mno_operator_check);

                                                                                if ($mno_op['rowCount']>1) {



                                                                                    ?>

                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_sys_package">Operations Type<sup><font color="#FF0000"></font></sup></label>
                                                                                    <select name="mno_sys_package" id="mno_sys_package"  class="span4 form-control form-control" <?php if($mno_edit==1) echo "readonly";?>>
                                                                                        <option value="">Select Type of Operator</option>
                                                                                        <?php
                                                                                            if($user_type == 'ADMIN'){

                                                                                                foreach($mno_op['data'] AS $mno_op_row){


                                                                                                    if($get_edit_mno_sys_pack==$mno_op_row[product_code]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }

                                                                                                    echo '<option '.$select.' value='.$mno_op_row[product_code].' data-vt="'.$mno_op_row[options].'" >'.$mno_op_row[product_name].'</option>';
                                                                                                }

                                                                                        }

                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->


                                                                                    <?php

                                                                                }else{
                                                                                    echo '<input type="hidden" name="mno_sys_package" id="mno_sys_package" value="'.$mno_op['data'][0][product_code].'" />';

                                                                                   }

                                                                                ?>


                                                                            <div class="control-group" style="display: none" id="vt-groups">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="vt-group">Vtenat Group <sup><font color="#FF0000"></font></sup></label>
                                                                                    <select multiple="multiple" name="vt_group[]" id="vt_group"  class="span4 form-control">
                                                                                        <!--  <option value="">-- Select AP Controller --</option> -->
                                                                                        <?php
                                                                                        $all_vt_groups = $vtenant_model->getUnusedAdminVtenants();
                                                                                        foreach($all_vt_groups as $vt_group) {

                                                                                            $vt_code = $vt_group->getRealm();
                                                                                            $vt_type = $vt_group->getType()=='VTENANT'?'VT':'MDU';

                                                                                            echo "<option value='" . $vt_code . "'>" . $vt_code . "(" . $vt_type . ")" . "</option>";

                                                                                        }
                                                                                        if($mno_edit=="1") {

                                                                                            foreach ($vtenant_model->getMNOVtenants($edit_mno_id) as $value) {

                                                                                                $type = $value->getType()=="VTENANT"?"VT":"MDU";
                                                                                                echo '<option  selected value="' . $value->getRealm() . '">' . $value->getRealm() . '('.$type.')</option>';
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>

                                                                           <?php if($package_functions->getSectionType('OPERATOR_CODE',$system_package)=='YES'){ ?> <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_api_prifix">Operator Code<sup><font color="#FF0000"></font></sup></label>
                                                                                    <input type="text" class="span4 form-control" id="mno_api_prifix" name="mno_api_prifix" autocomplete="off" placeholder="Ex-: OPT" value="<?php echo $get_edit_mno_api_prefix;?>">

                                                                                </div>
                                                                            </div><?php } ?>

                                                                         <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_first_name">Admin First Name<sup><font color="#FF0000"></font></sup></label>
                                                                                    <input class="span4 form-control" id="mno_first_name" maxlength="12" placeholder="First Name" name="mno_first_name" type="text" value="<?php echo$get_edit_mno_first_name;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>

                                                                             <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_last_name">Admin Last Name<sup><font color="#FF0000"></font></sup></label>
                                                                                    <input class="span4 form-control" id="mno_last_name" maxlength="12" placeholder="Last Name" name="mno_last_name" type="text" value="<?php echo$get_edit_mno_last_name;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>

                                                                             <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_email">Admin Email<sup><font color="#FF0000"></font></sup></label>
                                                                                    <input class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com" value="<?php echo$get_edit_mno_email;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>


                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_address_1">Address<sup><font color="#FF0000"></font></sup></label>
                                                                                    <input class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo$get_edit_mno_ad1;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>


                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_address_2">City<sup><font color="#FF0000"></font></sup></label>
                                                                                    <input class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo$get_edit_mno_ad2;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>



                                                                            <div class="control-group">

                                                    <div class="controls col-lg-5 form-group">
                                                                        <label class="" for="mno_country" >Country<font color="#FF0000"></font></sup></label>

                                                    <select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off">
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
                                                                    </div>
                                                               <!-- /controls -->

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
                                                populateCountries("mno_country", "mno_state");
                                               // populateCountries("country");
                                            </script>

                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
                                                                                 <!--   <input class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" type="text" value="<?php //echo $get_edit_mno_state_region?>">  -->


                                                                               <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
                                                                                    <?php

                                                                                     $get_regions=mysql_query("SELECT
                                                                                      `states_code`,
                                                                                      `description`
                                                                                    FROM
                                                                                    `exp_country_states` ORDER BY description ASC");

                                                                                     echo '<option value="">Select State</option>';

                                                                                    while($state=mysql_fetch_assoc($get_regions)){
                                                                                        //edit_state_region , get_edit_mno_state_region
                                                                                        if($get_edit_mno_state_region==$state['states_code']) {

                                                                                            echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                                        }else{

                                                                                            echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                                        }
                                                                                    }
                                                                                    //echo '<option value="other">Other</option>';
                                                                                   
                                                                                    
                                                                                    ?>
                                                                                    </select>




                                                                                </div>
                                                                            </div>



                                                                             <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_region">ZIP Code<sup><font color="#FF0000"></font></sup></label>
                                                                                    <input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip?>" autocomplete="off">
                                                                                </div>
                                                                            </div>

                                                                            <script type="text/javascript">

                                                                            $(document).ready(function() {



                                                                                $("#mno_zip_code").keydown(function (e) {


                                                                                    var mac = $('#mno_zip_code').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);


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

                                                                            <div class="control-group">
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="mno_mobile">Phone Number 1<sup><font color="#FF0000"></font></sup></label>
                                                                                        <input class="span4 form-control" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_mobile?>" autocomplete="off">
                                                                                    </div>
                                                                            </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('#mno_mobile_1').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $('#mno_mobile_1').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $("#mno_mobile_1").keydown(function (e) {


                                                                                    var mac = $('#mno_mobile_1').val();
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
                                                                                            $('#mno_mobile_1').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('#mno_mobile_1').val(function() {
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



                                                                                     <div class="control-group">
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="mno_mobile">Phone Number 2<sup><font color="#FF0000"></font></sup></label>

                                                                                        <input class="span4 form-control" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone2?>" autocomplete="off" >




                                                                                    </div>
                                                                                </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('#mno_mobile_2').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $('#mno_mobile_2').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $("#mno_mobile_2").keydown(function (e) {


                                                                                    var mac = $('#mno_mobile_2').val();
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
                                                                                            $('#mno_mobile_2').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('#mno_mobile_2').val(function() {
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


                                                                               <div class="control-group">
                                                                                         <div class="controls col-lg-5 form-group">
                                                                                         <label class="" for="mno_mobile">Phone Number 3<sup><font color="#FF0000"></font></sup></label>
                                                                                             <input class="span4 form-control" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone3?>" autocomplete="off">
                                                                                         </div>
                                                                                     </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('#mno_mobile_3').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $('#mno_mobile_3').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $("#mno_mobile_3").keydown(function (e) {


                                                                                    var mac = $('#mno_mobile_3').val();
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
                                                                                            $('#mno_mobile_3').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('#mno_mobile_3').val(function() {
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

                                                                                     <div class="control-group">
                                                                                         <div class="controls col-lg-5 form-group">
                                                                                         <label class="" for="mno_timezone">Time Zone<sup><font color="#FF0000"></font></sup></label>
                                                                                             <select class="span4 form-control" id="mno_time_zone" name="mno_time_zone" autocomplete="off">
                                                                                                 <option value="">Select Time Zone</option>
                                                                                                 <?php



                                                                                                 $utc = new DateTimeZone('UTC');
                                                                                                 $dt = new DateTime('now', $utc);
                                                                                                 foreach ($priority_zone_array as $tz){
                                                                                                     $current_tz = new DateTimeZone($tz);
                                                                                                     $offset =  $current_tz->getOffset($dt);
                                                                                                     $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                                                     $abbr = $transition[0]['abbr'];
                                                                                                     if($get_edit_mno_timezones==$tz){
                                                                                                         $select="selected";
                                                                                                     }else{
                                                                                                         $select="";
                                                                                                     }
                                                                                                     echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                                                 }

                                                                                                 
                                                                                                 foreach(DateTimeZone::listIdentifiers() as $tz) {

                                                                                                     //Skip
                                                                                                     if(in_array($tz,$priority_zone_array))
                                                                                                         continue;

                                                                                                    $current_tz = new DateTimeZone($tz);
                                                                                                    $offset =  $current_tz->getOffset($dt);
                                                                                                    $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                                                    $abbr = $transition[0]['abbr'];
                                                                                                    /*if($abbr=="EST" || $abbr=="CT" || $abbr=="MT" || $abbr=="PST" || $abbr=="AKST" || $abbr=="HST" || $abbr=="EDT"){
                                                                                                    echo $get_edit_mno_timezones;*/
                                                                                                    if($get_edit_mno_timezones==$tz){
                                                                                                       $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                                                   // $select="";
                                                                                                   /*}*/
                                                                                                }

                                                                                                 ?>
                                                                                             </select>
                                                                                         </div>
                                                                                     </div>






                                                    <div class="form-actions">

                                                        <button disabled type="submit" id="submit_mno_form" name="submit_mno_form" class="btn btn-primary"><?php if($mno_edit==1){echo "Update Account";}else{echo "Create Account";}?></button>
                                                                            <?php if($mno_edit==1){ ?> <button type="button" class="btn btn-info inline-btn"  onclick="goto();" class="btn btn-danger">Cancel</button> <?php } ?>

                                                                    </div>
                                                                            <script>
                                                                                        function submit_mno_formfn() {
                                                                                            //alert("fn");
                                                                                            $("#submit_mno_form").prop('disabled', false);
                                                                                        }

                                                                                        function goto(url){
                                                                                        window.location = "?";
                                                                                        }
                                                                                    </script>



                                                        <!-- /form-actions -->

                                                            </fieldset>

                                                </form>

                                        <!-- /widget -->
                                        </div>



                                        <!-- ***************Activate Accounts******************* -->

                                        <div <?php if(isset($tab9)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="assign_ap">





                                    <p>To send an automatic email invitation to the SMB Manager, click on "Email" Button.<br/>
                                    This email contains the SMB account activation information.</p><br/>


                                    <div id="response_d1">

                                        </div>

                                        <br>
                                        <br>

                                    <div class="widget widget-table action-table">

                                                <div class="widget-header">

                                                   <!--  <i class="icon-th-list"></i> -->

                                                    <h3>Dormant</h3>

                                                    <img id="location_loader_1" src="img/loading_ajax.gif" style="visibility: hidden;">

                                                </div>

                                                <!-- /widget-header -->

                                                <div class="widget-content table_response" id="location_div">
                                                    <div style="overflow-x:auto">

                                                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                                                        <?php
                                                            if($user_type == 'MNO' || $user_type == 'SUPPORT'|| $user_type == 'SALES'){

                                                                /*
                                                                $query_1 = "SELECT d.`verification_number`, d.`gateway_type`,d.`country`,d.`state_region` ,d.`id` as d_id,d.`distributor_code`, d.`distributor_name`, d.`distributor_type`, d.`create_date`, u.`is_enable`, u.`id`
                                                                            FROM exp_mno_distributor  d
                                                                            LEFT JOIN admin_invitation_email i
                                                                            ON d.`distributor_code` = i.`distributor`
                                                                            LEFT JOIN admin_users u
                                                                            ON i.`user_name`=u.`user_name` WHERE d.`mno_id` = '$user_distributor' AND LENGTH(d.`parent_code`) = 0 AND u.`is_enable`=2 ORDER BY d.`verification_number` ASC";  */

                                                                $query_1 = "SELECT p.id , p.parent_id,count(distributor_code) as properties,group_concat(d.hardware_installed) AS hardware, u.full_name,p.account_name,p.create_date FROM exp_mno m JOIN mno_distributor_parent p ON m.mno_id = p.mno_id LEFT JOIN exp_mno_distributor d ON p.parent_id = d.parent_id LEFT JOIN admin_users u ON p.parent_id = u.verification_number 
                                                                          WHERE m.mno_id='$user_distributor' AND u.is_enable ='2' GROUP BY p.parent_id";

                                                            }
                                                            else{

                                                                 $query_1 = "SELECT d.`verification_number`, d.`gateway_type` ,d.`country` ,d.`state_region`, d.`id` as d_id,d.`distributor_code`, d.`distributor_name`, d.`distributor_type`, d.`create_date`, u.`is_enable`, u.`id`
                                                                            FROM exp_mno_distributor  d
                                                                            LEFT JOIN admin_invitation_email i
                                                                            ON d.`distributor_code` = i.`distributor`
                                                                            LEFT JOIN admin_users u
                                                                            ON i.`user_name`=u.`user_name`
                                                                            WHERE d.`parent_code` = '$user_distributor' AND u.`is_enable`=2 ORDER BY d.`verification_number` ASC";

                                                            }
                                                         ?>

                                                        <thead>

                                                            <tr>
                                                                <?php
                                                                $pending_tbl_column = json_decode($package_functions->getOptions('PENDING_PARENT_TBL_COLUMN',$system_package),true);

                                                                echo '<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Business ID</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Business Account Name</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">PROPERTIES</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Creation Date</th>';
                                                                if(array_key_exists('hardware_installed',$pending_tbl_column)) {
                                                                    echo '<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">'.
                                                                        $pending_tbl_column['hardware_installed']['title']
                                                                        .'</th>';
                                                                }
                                                                echo'<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Send</th>';
                                                                if($package_functions->getOptions('PENDING_PROPERTY_MAIL',$system_package)=='ACTIVE'){
                                                                    echo'<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Send</th>';
                                                                }
                                                                ?>
                                                            </tr>

                                                        </thead>

                                                        <tbody>



                                                            <?php





                                                                $query_results=$db->selectDB($query_1);
                                                                foreach($query_results['data'] AS $row){

                                                                    /*
                                                                    $distributor_code = $row[distributor_code];
                                                                    $distributor_name = $row[distributor_name];
                                                                    $distributor_type = $row[distributor_type];
                                                                    $distributor_icoms = $row[verification_number];
                                                                    $distributor_country = $row[country];
                                                                    $distributor_state_region = $row[state_region];
                                                                    $distributor_gateway_type = $row[gateway_type];
                                                                    $create_date = $row[create_date];
                                                                    $distributor_id_number = $row[d_id];
                                                                    $is_enable = $row[is_enable];

                                                                    $distributor_name_display=str_replace("'","\'",$distributor_name);  */
                                                                    
                                                                    $parent_id = $row['parent_id'];
                                                                    $parent_properties = $row['properties'];
                                                                    $parent_account_name = str_replace("\\",'',$row['account_name']);
                                                                    $parent_create_date = $row['create_date'];
                                                                    $parent_tbl_id = $row['id'];



                                                                    echo '<tr>';
                                                                   echo '<!--<td> '.$db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'").' </td> -->
                                    
                                                                    <td> '.$parent_id.' </td>
                                                                    <td> '.$parent_account_name.' </td>
                                                                    <td> '.$parent_properties.' </td>
                                                                    <td> '.$parent_create_date.' </td>';
                                                                    if(array_key_exists('hardware_installed',$pending_tbl_column)) {
                                                                        $hardware = explode(',',$row['hardware']);
                                                                        if(in_array('YES',$hardware)){
                                                                            $hardware_installed = 'YES';
                                                                        }else{
                                                                            $hardware_installed = 'NO';
                                                                        }
                                                                        echo '<td> ' . $hardware_installed . ' </td>';
                                                                    }



                                     echo '<td><a href="javascript:void();" id="DISTRI_'.$parent_tbl_id.'"  class="btn btn-small btn-primary" >
                                    
                                                                    <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><img id="distributor_loader_'.$parent_tbl_id.'" src="img/loading_ajax.gif" style="display:none;"><script type="text/javascript">
                                    
                                                                        $(document).ready(function() {
                                    
                                                                        $(\'#DISTRI_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                                                title: \'Account Remove\',
                                                                                text: \'Are you sure you want to remove[ '.$parent_id.' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#DISTRI_'.$parent_tbl_id.'\').click(function() {
                                                                                window.location = "?token5='.$secret.'&t=9&remove_par_code='.$parent_id.'&remove_par_id='.$parent_tbl_id.'"
                                                                            });
                                                                            });
                                                                        </script></td>';








                                                                    echo '<td><a href="javascript:void();" id="EDITACC1_'.$parent_tbl_id.'"  class="btn btn-small btn-info">
                                    
                                                                                            <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
                                    
                                                                                        $(document).ready(function() {
                                                                                        $(\'#EDITACC1_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                                                                title: \'Account Edit\',
                                                                                                text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                                closeText: \'close\'
                                                                                                 }});
                                    
                                                                                            $(\'#EDITACC1_'.$parent_tbl_id.'\').click(function() {
                                                                                                window.location = "?token7='.$secret.'&t=12&edit_parent_id='.$parent_id.'"
                                    
                                                                                            });
                                    
                                                                                            });
                                    
                                                                                        </script></td>';



                                                            echo '<td><a href="javascript:void();" id="SEMAIL_'.$parent_tbl_id.'"  class="btn btn-small btn-danger" >
                                    
                                                                    <i class="btn-icon-only icon-envelope"></i>&nbsp;Email</a><script type="text/javascript">
                                    
                                                                        $(document).ready(function() {
                                    
                                                                        $(\'#SEMAIL_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                                                title: \'Send Email\',
                                                                                text: \'Are you sure you want to send an email invitation? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#SEMAIL_'.$parent_tbl_id.'\').click(function() {
                                                                                window.location = "?form_secret5='.$secret.'&t=9&distributor_code='.$parent_id.'&distributor_name='.$distributor_name.'&resendMail=set"
                                                                            });
                                                                            });
                                                                        </script></td>';


                                                                    if($package_functions->getOptions('PENDING_PROPERTY_MAIL',$system_package)=='ACTIVE'){

                                                                        echo '<td><a href="javascript:void();" id="REMAIL_'.$parent_tbl_id.'"  class="btn btn-small btn-danger" >
                                    
                                                                        <i class="btn-icon-only icon-envelope"></i>&nbsp;Remind</a><script type="text/javascript">
                                        
                                                                            $(document).ready(function() {
                                        
                                                                            $(\'#REMAIL_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                                                    title: \'Send Email\',
                                                                                    text: \'Are you sure you want to send an email remind? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                                    closeText: \'close\'
                                                                                     }});
                                                                                $(\'#REMAIL_'.$parent_tbl_id.'\').click(function() {
                                                                                    window.location = "?form_secret5='.$secret.'&t=9&distributor_code='.$parent_id.'&distributor_name='.$distributor_name.'&remindMail=set"
                                                                                });
                                                                                });
                                                                            </script></td>';

                                                                    }


                                                                echo '</tr>';

                                                                    }
                                                            ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                                </div>
                                            </div>


                                    </div>

                                            <!-- ******************************************************* -->
                                        <div <?php if(isset($tab5)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="create_location">



                                                        <form onkeyup="location_formfn();" onchange="location_formfn();"   autocomplete="off"   id="location_form" name="location_form" method="post" class="form-horizontal"   action="<?php if($_POST['p_update_button_action']=='add_location' || isset($_GET['location_parent_id'])){echo '?token7='.$secret.'&t=12&edit_parent_id='.$edit_parent_id;}else{echo'?t=5';} ?>" >

                                                                <?php
                                                                  echo '<input type="hidden" name="form_secret5" id="form_secret5" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                                ?>

                                                                <fieldset>
                                                                            <div id="response_d1">

                                                                            </div>
                                                                            
                                                                            <div class="control-group">
                                                                            <div class="controls col-lg-5 form-group">

                                                                                <h3>Account Info</h3>
                                                                                <br class="mobile-hide">
                                                                            </div>
                                                                            </div>

                                                                        <?php
                                                                                if(array_key_exists('parent_id',$field_array) || $package_features=="all"){
                                                                            ?>


                                                                        <div class="control-group">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="customer_type">Business ID<?php if($field_array['parent_id']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <input <?php if(isset($edit_parent_id)){ ?>readonly<?php } ?> maxlength="12" type='text' class="span4 form-control" placeholder="SAN123456789" name='parent_id' id='parent_id' value="<?php echo $edit_parent_id; ?>" data-toggle="tooltip" title="The Business ID format: 3 alpha characters followed by 3-9 numeric characters. EX. SAN123 or SAN123456789">
                                                                            </div>
                                                                            <script type="text/javascript">
                                                                              $("#parent_id").keypress(function(event){
                                                                                var ew = event.which;
                                                                                //alert(ew);
                                                                                // if(ew == 32)
                                                                                //   return true;
                                                                                if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122  || ew == 0  || ew == 8 )
                                                                                  return true;
                                                                                return false; 
                                                                              });
                                                                            </script> 
                                                                        </div>
                                                                            <?php }

                                                                                if(array_key_exists('parent_ac_name',$field_array) || $package_features=="all"){
                                                                            ?>


                                                                        <div class="control-group">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="customer_type">Business Account Name<?php if($field_array['parent_ac_name']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <input <?php if(isset($edit_parent_ac_name)){ ?>readonly<?php } ?> type='text' class="span4 form-control" placeholder="joey's pizza" name='parent_ac_name' id='parent_ac_name' value="<?php echo str_replace("\\",'',$edit_parent_ac_name); ?>">
                                                                            </div>
                                                                        </div>
                                                                            <?php }

                                                                                if(array_key_exists('f_name',$field_array) || $package_features=="all"){
                                                                                    ?>

                                                                             <div class="control-group">
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="mno_first_name">Admin First Name<?php if($field_array['f_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                        <input <?php if(isset($edit_first_name)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_first_name" placeholder="First Name" name="mno_first_name" type="text" maxlength="12" value="<?php echo $edit_first_name; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <?php }
                                                                                if(array_key_exists('l_name',$field_array) || $package_features=="all"){
                                                                                    ?>
                                                                                 <div class="control-group">
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="mno_last_name">Admin Last Name<?php if($field_array['l_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                        <input <?php if(isset($edit_last_name)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_last_name" placeholder="Last Name" name="mno_last_name" maxlength="12" type="text" value="<?php echo $edit_last_name; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <?php }


                                                                                if(array_key_exists('email',$field_array) || $package_features=="all"){
                                                                                            ?>
                                                                                         <div class="control-group">
                                                                                            <div class="controls col-lg-5 form-group">
                                                                                            <label class="" for="mno_email">Admin Email<?php if($field_array['email']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                                <input <?php if(isset($edit_email)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com"   value="<?php echo $edit_email; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php }

                                                                                    $parent_package=$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);
                                                                                    $parent_package_array =explode(',',$parent_package);
                                                                                    //print_r($parent_package_array);
                                                                                    if(count($parent_package_array)>1){

                                                                                        ?>

                                                                                         <div class="control-group">
                                                                                            <div class="controls col-lg-5 form-group">
                                                                                            <label class="" for="parent_package_type">Admin Type</label>
                                                                                                <?php if(isset($edit_parent_package)){ ?>
                                                                                                <input id="parent_package1" name="parent_package_type" type="hidden" placeholder=""   value="<?php echo $edit_parent_package; ?>">
                                                                                                <input readonly class="span4 form-control" type="text" placeholder=""   value="<?php echo $package_functions->getPackageName($edit_parent_package); ?>">
                                                                                                <?php }else{
                                                                                                    echo'<select class="span4 form-control" id="parent_package1" name="parent_package_type">';
                                                                                                    echo '<option value="">Select Business ID type</option>';

                                                                                                    foreach($parent_package_array as $value){
                                                                                                        $parent_package_name = $db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");
                                                                                                        echo '<option value="'.$value.'">'.$parent_package_name.'</option>';
                                                                                                    }
                                                                                                         echo '</select>';
                                                                                                } ?>
                                                                                            </div>
                                                                                         </div>
                                                                                    <?php }else{

                                                                                        echo '<div class="control-group">
                                                                                            <div class="controls col-lg-5 form-group">
                                                                                        <input class="span4 form-control"  id="parent_package1" name="parent_package_type" type="hidden" value="'.$parent_package_array[0].'">
                                                                                        </div>
                                                                                         </div>
                                                                                        ';
                                                                                    }

                                                                                    ?>




                                    <hr>

                                                                  <div id="location_info_div" style="">
                                                                    <div class="control-group">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <h3>Location Info</h3>

                                                                        </div>
                                                                    </div>
                                                                    <?php


                                                                    if($field_array['unique_property_id']=='display_none'){


                                                                        ?>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                 $("#icomme").on('keyup change', function () {
                                                                                   $('#zone_name').val($(this).val());
                                                                                });

                                                                                 <?php 
                                                                                 if($edit_account==1){
                                                                                  ?>

                                                                                  $('#zone_name').val($("#icomme").val());

                                                                              <?php } ?>

                                                                            });
                                                                        </script>


                                                                        <?php
                                                                    }

                                                                    if(array_key_exists('icomms_number_m',$field_array)){ ?>
                                                                                    
                                                                            <div class="control-group" id="icomme_div" style="display: none;">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="customer_type"><?php if(strlen($field_array['icomme_field_name']) > 0){ echo $field_array['icomme_field_name']; }else{
                                                                                    echo 'Customer Account Number';
                                                                                } ?><?php if($field_array['icomms_number_m']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <input type="text" class="span4 form-control" id="icomme" name="icomme" onblur="check_icom(this)" value="<?php echo $edit_distributor_verification_number;?>" <?php if($edit_account==1){ ?>readonly <?php }else { ?><?php } ?>>
                                                                                    <div style="display: inline-block" id="img_icom"></div>
                                                                                </div>
                                                                                <script type="text/javascript">

                                                                                    $(document).ready(function() {

                                                                                        $("#icomme").keypress(function(event){
                                                                                var ew = event.which;
                                                                                //alert(ew);
                                                                                // if(ew == 32)
                                                                                //   return true;
                                                                                if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 96 <= ew && ew <= 122  || ew == 0  || ew == 8 || ew == 189 )
                                                                                  return true;
                                                                                return false; 
                                                                              });



                                                                                        /*$("#icomme").keydown(function (e) {


                                                                                            var mac = $('#icomme').val();
                                                                                            var len = mac.length + 1;
                                                                                            // console.log(e.keyCode);
                                                                                            //console.log('len '+ len);


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
                                                                                                //  (e.keyCode == 190 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                                // Allow: home, end, left, right, down, up
                                                                                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                                                // let it happen, don't do anything
                                                                                                return;
                                                                                            }
                                                                                            // Ensure that it is a number and stop the keypress
                                                                                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                                e.preventDefault();

                                                                                            }
                                                                                        });*/


                                                                                    });

                                                                                </script>
                                                                            </div>

                                                                        <div class="control-group" id="vt_icomme_div" style="display: none;">
                                                                            <div class="controls col-lg-5 form-group" style="position: relative">
                                                                            <label class="" for="customer_type">vTenant Account Number<?php if($field_array['icomms_number_m']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <?php if($edit_account==1){ echo '<div class="sele-disable span4" ></div>';} ?>

                                                                                <select type="text" onchange="fillrealm(this);" class="span4 form-control" id="vt_icomme" name="vt_icomme" <?php if($edit_account==1){ ?>readonly <?php } ?>>
                                                                                    <option value="">Select Option</option>
                                                                                    <?php
                                                                                    if($edit_account=='1'){
                                                                                        $edit_acc_realm=$vtenant_model->getDistributorVtenant($edit_distributor_code);
                                                                                        $vt_type = $edit_acc_realm->getType()=='VTENANT'?'(VT)':'(MDU)';
                                                                                        echo '<option selected value="'.$edit_acc_realm->getRealm().'">'.$edit_acc_realm->getRealm().$vt_type.'</option>';
                                                                                    }
                                                                                    $mno_vtenants = $vtenant_model->getUnusedMNOVtenants($user_distributor);
                                                                                    foreach ($mno_vtenants as $vtenant){
                                                                                        $vt_type = $vtenant->getType()=='VTENANT'?'(VT)':'(MDU)';
                                                                                        echo '<option value="'.$vtenant->getRealm().'">'.$vtenant->getRealm().$vt_type.'</option>';

                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <?php }
                                                                     if(array_key_exists('account_type',$field_array)){

                                                                         $js_array=array();


                                                                         foreach ($parent_package_array as $value){

                                                                             //$package_functions->getOptions('LOCATION_PACKAGE',$value);

                                                                             $location_package_ar=explode(',',$package_functions->getOptions('LOCATION_PACKAGE',$value));
                                                                             $produts = "'" . implode("','", $location_package_ar) . "'";
                                                                             $get_types_q="SELECT p.`product_name`,p.`product_code`,c.options FROM `admin_product` p LEFT JOIN admin_product_controls c
                                                                                                ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                                                                            WHERE `is_enable`='1' AND p.user_type='VENUE' AND p.product_code IN( $produts)";
                                                                             //"SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
                                                                             $get_types_r=$db->selectDB($get_types_q);

                                                                             $location_detail_ar = array();
                                                                             foreach($get_types_r['data'] as $get_types){
                                                                                 array_push($location_detail_ar ,array("code"=>$get_types[product_code],"name"=>$get_types[product_name],"vt"=>$get_types[options]));
                                                                             }

                                                                             $js_array[$value] = $location_detail_ar;

                                                                         }
                                                                         //print_r(json_encode($js_array));

                                                                        ?>


                                                                    <div class="control-group">
                                                                        <div class="controls col-lg-5 form-group">
                                                                        <label class="" for="customer_type">Account Type<?php if($field_array['account_type']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                            <select onchange="accountType('');" name="customer_type" id="customer_type" class="span4 form-control" <?php if($field_array['account_type']=="mandatory"){ ?>required<?php } ?>>
                                                                                <option value="">Select Type</option>
                                                                                <?php
                                                                                //echo'**'. $edit_parent_package.'**';
                                                                                //print_r($js_array[$edit_parent_package]);
                                                                                    if(isset($edit_parent_package)) {
                                                                                        $produts = $js_array[$edit_parent_package] ;
                                                                                        foreach($produts as $value){

                                                                                            if($edit_distributor_system_package==$value['code']){
                                                                                                ?>
                                                                                                <option selected value="<?php echo$value['code'];?>" data-vt="<?php echo$value['vt'];?>" data-feature="<?php echo $package_functions->getOptions('ADVANCED_FEATURE',$value['code']); ?>"><?php echo$value['name'];?></option>
                                                                                                <?php
                                                                                            }else{
                                                                                                ?>
                                                                                                <option value="<?php echo$value['code'];?>" data-vt="<?php echo$value['vt'];?>" data-feature="<?php echo $package_functions->getOptions('ADVANCED_FEATURE',$value['code']); ?>"><?php echo$value['name'];?></option>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                    }elseif(count($js_array)==1){
                                                                                        foreach($js_array as $adminValue) {

                                                                                            foreach ($adminValue as $value) {
                                                                                                    ?>
                                                                                                    <option value="<?php echo $value['code']; ?>" data-vt="<?php echo$value['vt'];?>" data-feature="<?php echo $package_functions->getOptions('ADVANCED_FEATURE',$value['code']); ?>"><?php echo $value['name']; ?></option>
                                                                                                    <?php
                                                                                                }
                                                                                        }
                                                                                    }
                                                                                    //$get_types_q="SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
                                                                                    //$get_types_r=mysql_query($get_types_q);
                                                                                    //while($get_types=mysql_fetch_assoc($get_types_r)){

                                                                                ?>
                                                                            </select>

                                                                        </div>
                                                                    </div>

                                                                    <script type="text/javascript">

                                                                        $(document).ready(function() {
                                                                            accountType('ready');
                                                                        });

                                                                        function accountType(check) {

                                                                            if(check!='ready'){
                                                                                try {

                                                                                $('#my_select7').multiSelect('deselect_all');

                                                                                }catch(err) {}
                                                                            }

                                                                            var x = $('#customer_type').find(':selected').attr('data-feature');

                                                                            if(x=='ON'){
                                                                                try {
                                                                                    $('.advFea').show();
                                                                                }catch(err) {}
                                                                            }else{
                                                                               try {
                                                                                    $('.advFea').hide();
                                                                                }catch(err) {}
                                                                            }
                                                                        }

                                                                    </script>
                                                                        <?php if(!isset($edit_parent_package)){    ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    var product_json = '<?php echo json_encode($js_array); ?>';
                                                                                    var product_array = JSON.parse(product_json);


                                                                                    $('#parent_package1').change(function () {
                                                                                        //alert('sssssssss');
                                                                                        var value = $(this).val();

                                                                                        if(value){
                                                                                        $('#customer_type').children('option:not(:first)').remove();
                                                                                        var apend_ob = product_array[value];
                                                                                        

                                                                                        apend_ob.forEach(function(element) {
                                                                                            //alert(element['code']);
                                                                                            $("#customer_type").append('<option value="'+element['code']+'" data-vt="'+element['vt']+'">'+element['name']+'</option>');

                                                                                        });
                                                                                        }
                                                                                    });

                                                                                });
                                                                            </script>
                                                                        <?php    } }
                                                                    if(array_key_exists('network_type',$field_array)){ ?>
                                                                        <input type="hidden"  id="old_network_type" name="old_network_type"  value="<?php echo $edit_distributor_network_type;?>" >
                                                                    
                                                                        <div class="control-group">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="location_name1">Package Type<?php if($field_array['network_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                                <select class="form-control span4" multiple="multiple" id="network_type" name="network_type[]">
                                                                                    <option value="" disabled="disabled"> Choose Package(s)</option>

                                                                                    <?php
                                                                                        $operator_vt_option = $package_functions->getOptions('VTENANT_MODULE',$system_package);
                                                                                        if($operator_vt_option == 'Vtenant'){
                                                                                    ?>
                                                                                    <option <?php if(($edit_distributor_network_type=='VT') || ($edit_distributor_network_type=='VT-BOTH')|| ($edit_distributor_network_type=='VT-PRIVATE')|| ($edit_distributor_network_type=='VT-GUEST')){ echo 'selected'; }else{
                                                                                        echo '';
                                                                                    } ?> value="VT">VTenant</option>
                                                                                <?php } ?>
                                                                                    <option <?php if(($edit_distributor_network_type=='GUEST') || ($edit_distributor_network_type=='VT-BOTH') || ($edit_distributor_network_type=='BOTH') || ($edit_distributor_network_type=='VT-GUEST')){ echo 'selected'; }else{
                                                                                        echo '';
                                                                                    } ?> value="GUEST">Guest</option>
                                                                                    <option  <?php if(($edit_distributor_network_type=='PRIVATE') || ($edit_distributor_network_type=='VT-BOTH') || ($edit_distributor_network_type=='BOTH') || ($edit_distributor_network_type=='VT-PRIVATE')){ echo 'selected'; }else{
                                                                                        echo '';
                                                                                    } ?> value="PRIVATE">Private</option>
                                                                                </select>

                                                                            <style type="text/css">

                                                                                div[id*="network_type"] ul {
                                                                                    height: 100px !important;
                                                                                }

                                                                            </style>

                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if(array_key_exists('advanced_features',$field_array)){ ?>
                                                                    
                                                                        <div class="control-group advFea">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="location_name1">Advanced Features<?php if($field_array['advanced_features']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                                <select class="form-control span4" multiple="multiple" id="my_select7" name="advanced_features[]">
                                                                                    <option value="" disabled="disabled"> Choose Feature(s)</option>

                                                                                    <option value="network_at_a_glance" <?php if($edit_advanced_features['network_at_a_glance']=='1'){ echo 'selected'; }else{ echo ''; } ?> >Network-at-a-Glance</option>
                                                                                    <option <?php if($edit_advanced_features['top_applications']=='1'){ echo 'selected'; }else{ echo ''; } ?> value="top_applications">Top Applications</option>
                                                                                    <option <?php if($edit_advanced_features['802.2x_authentication']=='1'){ echo 'selected'; }else{ echo ''; } ?> value="802.2x_authentication">802.1X Authentication</option>
                                                                                </select>
                                                                                <style type="text/css">

                                                                                div[id*="my_select7"] ul {
                                                                                    height: 150px !important;
                                                                                }

                                                                            </style>

                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if(array_key_exists('how_many_buildings',$field_array)){ ?>

                                                                    <?php  if($edit_account !=1){ ?>    

                                                                        <div id="icomsduplicate">
                                                                            <div class="control-group icomsDiv icom1">
                                                                                <label class="control-label icoms-label" for="mno_last_name">ICOMS 1</label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input data-toggle="tooltip" title="Please use the unique ICOMS ID provided by COX. Use one unique ICOMS per building." onblur="check_multiicom(this)" class="span4 form-control multiicom" placeholder="ICOMS 1" name="icom1" id="icom1" type="text" value="">
                                                                                    <button class="btn btn-primary btn-xs clone-button btn-add" type="button">&#x2b;</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        

                                                                        

                                                                    <?php }else{ 

                                                                	$get_icoms = "SELECT `icom` FROM `exp_icoms` WHERE `distributor`='$edit_distributor_code'";

                                                                	$icoms_res = mysql_query($get_icoms);
                                                                	$icoms_count=mysql_num_rows($icoms_res);
                                                                	$icom_count_plus_one=$icoms_count+1;
                                                                	$no_of_icoms=1;
                                                                    ?>
                                                                    <div id="icomsduplicate">
                                                                    <?php
                                                                	while($row_icoms=mysql_fetch_array($icoms_res)){

                                                                		?>
                                                                		
                                                                			<div class="control-group icomsDiv icom<?=$no_of_icoms ?>" id="icomsclonned<?=$no_of_icoms ?>">
                                                                				<label class="control-label icoms-label" for="mno_last_name">ICOMS <?=$no_of_icoms ?></label>
                                                                				<div class="controls col-lg-5 form-group">
                                                                					<input data-toggle="tooltip" title="Please use the unique ICOMS ID provided by COX. Use one unique ICOMS per building." onblur="check_multiicom(this)" class="span4 form-control multiicom" placeholder="ICOMS <?=$no_of_icoms ?>" name="icom<?=$no_of_icoms ?>" id="icom<?=$no_of_icoms ?>" type="text" value="<?=$row_icoms['icom'] ?>">
                                                                                    <?php if($no_of_icoms == $icoms_count){ ?>
                                                                                    <button class="btn btn-primary btn-xs clone-button btn-add" type="button">&#x2b;</button>
                                                                                    <?php }else{ ?>
                                                                					<button class="btn btn-danger btn-xs clone-button btn-remove" id="<?=$no_of_icoms ?>" type="button">&#10539;</button>
                                                                                    <?php } ?>
                                                                				</div>
                                                                			</div>
                                                                		
                                                                		<?php
                                                                		$no_of_icoms++;
                                                                	}

                                                                    ?>
                                                                    </div>
                                                                    <?php

                                                                	?>

                                                                    <?php } ?>


                                                                    <script type="text/javascript">

                                                                    	$(document).ready(function(){

                                                                    		var clonedLimit=25;
                                                                    		var edit_icoms='<?php echo $edit_account; ?>';
                                                                    		//alert(edit_icoms);


                                                                    		var i=1;
                                                                    		if(edit_icoms == 1){
                                                                    			i='<?php echo $icoms_count; ?>';
                                                                    		}

                                                                                //$('.btn-add').click(function(){
                                                                                	$(document).on('click', '.btn-add', function () {
                                                                                		var clonedLength= $('.icomsDiv').length;

                                                                                    //alert(clonedLength); 
                                                                                    if(parseInt(clonedLength) == 1){
                                                                                    	i=1;
                                                                                    }
                                                                                    i++;
                                                                                    if(clonedLength != clonedLimit) {
                                                                                    	$('#icomsduplicate').append('<div class="control-group icomsDiv icom'+i+'" id="icomsclonned'+i+'"> <label class="control-label icoms-label" for="mno_last_name">ICOMS '+i+'</label> <div class="controls col-lg-5 form-group"> <input data-toggle="tooltip" title="Please use the unique ICOMS ID provided by COX. Use one unique ICOMS per building." onblur="check_multiicom(this)" class="span4 form-control multiicom" placeholder="ICOMS '+i+'" name="icom'+i+'" id="icom'+i+'" type="text" value=""> <button class="btn btn-danger btn-xs clone-button btn-remove" id="'+i+'" type="button">&#10539;</button> </div> </div>'); 

                                                                                    	$(".multiicom").tooltip();
                                                                                        //$("#location_form").data('bootstrapValidator').resetForm();
                                                                                        var icom = 'icom'+i;
                                                                                        console.log($('#'+icom)); 

                                                                                        $('#location_form').bootstrapValidator('addField', $('#'+icom));


                                                                                        
                                                                                        var add_location_form_validator = $('#location_form').data('bootstrapValidator');
                                                                                        //console.log(add_location_form_validator); 
                                                                                        
                                                                                        //$("#how_many_icoms").val(parseInt(clonedLength));
                                                                                        //alert($("#how_many_icoms").val());
                                                                                    }
                                                                                });

                                                                                	$(document).on('click', '.btn-remove', function(){  
                                                                                		var button_id = $(this).attr("id"); 
                                                                                		console.log(button_id); 
                                                                                		$('#location_form').bootstrapValidator('removeField', $('#icom'+button_id));
                                                                                		$('#icomsclonned'+button_id+'').remove(); 
                                                                                		var icom = 'icom'+button_id;
                                                                                		var add_location_form_validator = $('#location_form').data('bootstrapValidator');
                                                                                		/*add_location_form_validator.enableFieldValidators(icom, false); */
                                                                                	}); 
                                                                                });

                                                                            </script>

                                                                        <script type="text/javascript">
                                                                            $(window).load(function() {
                                                                                howMany();
                                                                                $('#realmDiv').hide();
                                                                            });
                                                                            function howMany(){
                                                                                var buildCount = parseInt("<?php echo $buildCount; ?>");
                                                                                var add_location_form_validator = $('#location_form').data('bootstrapValidator');

                                                                                var how_many_buildings = parseInt($('#how_many_buildings').val());

                                                                                $('.icomIn').hide();

                                                                                for (var i = 0; i < buildCount; i++) {
                                                                                    var icom = 'icom'+(i+1);
                                                                                    add_location_form_validator.enableFieldValidators(icom, false);
                                                                                    if((i+1)>how_many_buildings){
                                                                                        //console.log(icom);
                                                                                        $("#"+icom).val("");
                                                                                    }
                                                                                }

                                                                                for (var i = 0; i < how_many_buildings; i++) {
                                                                                    var icom = 'icom'+(i+1);
                                                                                    add_location_form_validator.enableFieldValidators(icom, true);
                                                                                                              
                                                                                    $('.icom'+(i+1)).show();
                                                                                }
                                                                            }
                                                                        </script>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('.multiicom').on('keyup change', function () {
                                                                                    $(this).next().next("small[data-bv-validator='notEmpty']").html('<p>This is a required field</p>');
                                                                                });
                                                                                
                                                                            });
                                        

                                      function check_multiicom(icomval)
                                      {
                                        //console.log(icomval);


                                          if ( $(icomval).is('[readonly]') ) {


                                              }else{

                                                     var valic = icomval.value;
                                                     var valic = valic.trim();



                                                         if(valic!="") {
                                                            var uniq = true;
                                                            $('.multiicom').each(function(index, el) {
                                                                

                                                                if(($(el).attr('id')!=$(icomval).attr('id')) && $(el).val()==$(icomval).val()){
                                                                    uniq = false;
                                                                }
                                                            });

                                                            if(!uniq){

                                                                $(icomval).val('');
                                                                $(icomval).next().next("small[data-bv-validator='notEmpty']").html('<p>' + valic +' - ICOM exists.</p>');

                                                                     $('#location_form').data('bootstrapValidator').updateStatus($(icomval).attr('id'), 'NOT_VALIDATED').validateField($(icomval).attr('id'));

                                                                     return;
                                                            }
                                                            $(icomval).after('<img class="'+$(icomval).attr('id')+'" src="img/loading_ajax.gif">');
                                                             var formData = {icom: valic,distributor: "<?php echo $edit_distributor_code; ?>"};
                                                             $.ajax({
                                                                 url: "ajax/validateMultiIcom.php",
                                                                 type: "POST",
                                                                 data: formData,
                                                                 success: function (data) {
                                                                     /*  if:new ok->1
                                                                      * if:new exist->2 */


                                                                     if (data == '1') {
                                                                      
                                                                         $("img."+$(icomval).attr('id')).remove();


                                                                     } else if (data == '2') {
                                                                        
                                                                        $("img."+$(icomval).attr('id')).remove();
                                                                         $(icomval).val('');
                                                                     }


                                                                     $(icomval).next().next("small[data-bv-validator='notEmpty']").html('<p>' + valic +' - ICOM exists.</p>');

                                                                     $('#location_form').data('bootstrapValidator').updateStatus($(icomval).attr('id'), 'NOT_VALIDATED').validateField($(icomval).attr('id'));


                                                                 },
                                                                 error: function (jqXHR, textStatus, errorThrown) {
                                                                     alert("error");
                                                                     $(icomval).val('');


                                                                      }



                                                             });
                                                         }


                                                  }





                                      }

                                    </script>

                                                                        <?php echo $divBuild; ?>
                                                                         
                                                                    <?php }
                                                                    if(array_key_exists('icomms_number',$field_array)){ ?>
                                                                                    
                                                                            <div class="control-group" id="icomme_div" style="display: none;">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="customer_type"><?php if(strlen($field_array['icomme_field_name']) > 0){ echo $field_array['icomme_field_name']; }else{
                                                                                    echo 'Customer Account Number';
                                                                                } ?><?php if($field_array['icomms_number']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <input type="text" class="span4 form-control" id="icomme" name="icomme" onblur="check_icom(this)" value="<?php echo $edit_distributor_verification_number;?>" <?php if($edit_account==1){ ?>readonly<?php } ?>>
                                                                                    <div style="display: inline-block" id="img_icom"></div>
                                                                                </div>
                                                                                <script type="text/javascript">

                                                                                    $(document).ready(function() {

                                                                                        $("#icomme").keypress(function(event){
                                                                                var ew = event.which;
                                                                                //alert(ew);
                                                                                // if(ew == 32)
                                                                                //   return true;
                                                                                if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122  || ew == 0  || ew == 8 || ew == 189 )
                                                                                  return true;
                                                                                return false; 
                                                                              });



                                                                                        /*$("#icomme").keydown(function (e) {


                                                                                            var mac = $('#icomme').val();
                                                                                            var len = mac.length + 1;
                                                                                            // console.log(e.keyCode);
                                                                                            //console.log('len '+ len);


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
                                                                                                //  (e.keyCode == 190 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                                // Allow: home, end, left, right, down, up
                                                                                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                                                // let it happen, don't do anything
                                                                                                return;
                                                                                            }
                                                                                            // Ensure that it is a number and stop the keypress
                                                                                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                                e.preventDefault();

                                                                                            }
                                                                                        });*/


                                                                                    });

                                                                                </script>
                                                                            </div>

                                                                        <div class="control-group" id="vt_icomme_div" style="display: none;">
                                                                            <div class="controls col-lg-5 form-group" style="position: relative">
                                                                            <label class="" for="customer_type">vTenant Account Number<?php if($field_array['icomms_number']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <?php if($edit_account==1){ echo '<div class="sele-disable span4" ></div>';} ?>

                                                                                <select type="text" onchange="fillrealm(this);" class="span4 form-control" id="vt_icomme" name="vt_icomme" <?php if($edit_account==1){ ?>readonly <?php } ?>>
                                                                                    <option value="">Select Option</option>
                                                                                    <?php
                                                                                    if($edit_account=='1'){
                                                                                        $edit_acc_realm=$vtenant_model->getDistributorVtenant($edit_distributor_code);
                                                                                        $vt_type = $edit_acc_realm->getType()=='VTENANT'?'(VT)':'(MDU)';
                                                                                        echo '<option selected value="'.$edit_acc_realm->getRealm().'">'.$edit_acc_realm->getRealm().$vt_type.'</option>';
                                                                                    }
                                                                                    $mno_vtenants = $vtenant_model->getUnusedMNOVtenants($user_distributor);
                                                                                    foreach ($mno_vtenants as $vtenant){
                                                                                        $vt_type = $vtenant->getType()=='VTENANT'?'(VT)':'(MDU)';
                                                                                        echo '<option value="'.$vtenant->getRealm().'">'.$vtenant->getRealm().$vt_type.'</option>';

                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <?php }

                                                                    if(array_key_exists('gateway_type',$field_array)){
                                                                        ?>
                                                                        <div class="control-group" id="gu_geteway_div">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="gateway_type">Guest Gateway Type<?php if($field_array['gateway_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                                <select <?php if($field_array['gateway_type']=="mandatory" ){ ?>required<?php } ?> class="span4 form-control" id="gateway_type" name="gateway_type" >

                                                                                    <option value="">Select Gateway Type</option>
                                                                                    <?php

                                                                                    if(empty($edit_distributor_gateway_type)){
                                                                                        $edit_distributor_gateway_type ="VSZ";
                                                                                    }

                                                                                            $get_gatw_type_q="select gs.gateway_name ,gs.description from exp_gateways gs where `is_enable` ='1'";
                                                                                            $get_gatw_type_r=mysql_query($get_gatw_type_q);
                                                                                            while($gatw_row=mysql_fetch_assoc($get_gatw_type_r)){
                                                                                                    $gatw_row_gtw=$gatw_row['gateway_name'];
                                                                                                    $gatw_row_dis=$gatw_row['description'];
                                                                                                    ?>
                                                                                                            <option <?php $edit_distributor_gateway_type==$gatw_row_gtw ? print(" selected ") :print (""); ?> value="<?php echo $gatw_row_gtw ;?>"> <?php echo $gatw_row_dis; ?> </option>;

                                                                                    <?php } ?>
                                                                                </select>


                                                                            </div>
                                                                        </div>
                                                                    <?php }

                                                                    if(array_key_exists('pr_gateway_type',$field_array)){ ?>
                                                                        <div class="control-group" id="pr_geteway_div">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="pr_gateway_type">Private Gateway Type<?php if($field_array['pr_gateway_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                                <select class="span4 form-control" id="pr_gateway_type" name="pr_gateway_type" >

                                                                                    <option value="">Select Gateway Type</option>
                                                                                    <?php
                                                                                                    if(empty($edit_distributor_pr_gateway_type)){
                                                                                                        $edit_distributor_pr_gateway_type ="VSZ";
                                                                                                    }

                                                                                            $get_gatw_type_q="select gs.gateway_name ,gs.description from exp_gateways gs where `is_enable` ='1'";
                                                                                            $get_gatw_type_r=mysql_query($get_gatw_type_q);
                                                                                            while($gatw_row=mysql_fetch_assoc($get_gatw_type_r)){
                                                                                                    $gatw_row_gtw=$gatw_row['gateway_name'];
                                                                                                    $gatw_row_dis=$gatw_row['description'];
                                                                                                    ?>
                                                                                                            <option <?php $edit_distributor_pr_gateway_type==$gatw_row_gtw ? print(" selected ") :print (""); ?> value="<?php echo $gatw_row_gtw.'">'.$gatw_row_dis.'</option>';
                                                                                            }

                                                                                    ?>

                                                                                </select>


                                                                            </div>
                                                                        </div>
                                                                    <?php  }

                                                                    if(array_key_exists('uui_number',$field_array)){
                                                                            ?>
                                                                            <div class="control-group" id="icomme_div">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="uui_number">UUI Number<?php if($field_array['uui_number']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <input <?php if($field_array['uui_number']=="mandatory"){ ?>required<?php } ?> type="text" class="span4 form-control" id="icomme" onblur="check_icom(this)" name="icomme" value="<?php echo$edit_distributor_verification_number;?>" <?php if($edit_account==1){ ?>readonly<?php } ?>>
                                                                                    <div style="display: inline-block" id="img_icom"></div>
                                                                                </div>
                                                                            </div>
                                                                            <script type="text/javascript">

                                                                                $(document).ready(function() {



                                                                                    $("#icomme").keydown(function (event) {

                                                                                        var ew = event.which;
                                                                                //alert(ew);
                                                                                // if(ew == 32)
                                                                                //   return true;
                                                                                if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122  || ew == 0  || ew == 8 || ew == 189 )
                                                                                  return true;
                                                                                return false; 


                                                                                        /*var mac = $('#icomme').val();
                                                                                        var len = mac.length + 1;
                                                                                        //console.log(e.keyCode);
                                                                                        //console.log('len '+ len);


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

                                                                                        }*/
                                                                                    });


                                                                                });

                                                                            </script>
                                                                            <?php
                                                                        }
                                                                        ?>

                                      <script type="text/javascript">


                                        $('#icomme').on('keyup change', function () {
                                            $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>This is a required field</p>');
                                        });

                                      function check_icom(icomval)
                                      {

                                          if ( $('#icomme').is('[readonly]') ) {


                                              }else{

                                                     var valic = icomval.value;
                                                     var valic = valic.trim();



                                                         if(valic!="") {
                                                             document.getElementById("img_icom").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                             var formData = {icom: valic};
                                                             $.ajax({
                                                                 url: "ajax/validateIcom.php",
                                                                 type: "POST",
                                                                 data: formData,
                                                                 success: function (data) {
                                                                     /*  if:new ok->1
                                                                      * if:new exist->2 */


                                                                     if (data == '1') {
                                                                      /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                                         document.getElementById("img_icom").innerHTML ="";
                                                                         document.getElementById("realm").value =valic;
                                                                         <?php if($field_array['network_config']=='display_none'){ ?>
                                                                         document.getElementById("zone_name").value =valic;
                                                                         document.getElementById("zone_dec").value =valic;
                                                                         <?php } ?>


                                                                     } else if (data == '2') {
                                                                        //alert(data);
                                                                        document.getElementById("img_icom").innerHTML ="";
                                                                         document.getElementById('icomme').value = "";
                                                                         document.getElementById("realm").value ="";
                                                                         <?php if($field_array['network_config']=='display_none'){ ?>
                                                                         document.getElementById("zone_name").value ="";
                                                                         document.getElementById("zone_dec").value ="";
                                                                         <?php } ?>
                                                                         /* $('#mno_account_name').removeAttr('value'); */

                                                                         <?php if(strlen($field_array['icomme_field_name']) > 0){ echo 'document.getElementById("icomme").placeholder = "Please enter new '.$field_array['icomme_field_name'].'";'; }else{
                                                                            echo 'document.getElementById("icomme").placeholder = "Please enter new Customer Account Number";';
                                                                                } ?>
                                                                         
                                                                     }


                                                                     $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic +' - Customer Account exists.</p>');

                                                                     $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');


                                                                 },
                                                                 error: function (jqXHR, textStatus, errorThrown) {
                                                                     alert("error");
                                                                     document.getElementById('icomme').value = "";
                                                                     document.getElementById("realm").value ="";
                                                                     <?php if($field_array['network_config']=='display_none'){ ?>
                                                                     document.getElementById("zone_name").value ="";
                                                                     document.getElementById("zone_dec").value ="";
                                                                     <?php } ?>


                                                                        $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic +' - Customer Account exists.</p>');


                                                                        $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');


                                                                      }



                                                             });
                                                             var bootstrapValidator2 = $('#location_form').data('bootstrapValidator');
                                                             bootstrapValidator2.enableFieldValidators('realm', true);
                                                             <?php if($field_array['network_config']=='display_none'){ ?>
                                                             bootstrapValidator2.enableFieldValidators('zone_name', true);
                                                             bootstrapValidator2.enableFieldValidators('zone_dec', true);

                                                             <?php } ?>
                                                         }


                                                  }





                                      }

                                    </script>



                                                                        <?php
                                                                        if(array_key_exists('location_type',$field_array) || $package_features=="all"){
                                                                        ?>

                                                                            <div class="control-group" <?php if(array_key_exists('network_type',$field_array)){echo 'style="display:none"';} ?> >
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="user_type">Property Type<?php if($field_array['location_type']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                                        <select <?php if($field_array['location_type']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> name="user_type" id="user_type" class="span4 form-control" <?php  if(isset($edit_distributor_type)){ echo 'disabled';} ?>>

                                                                                            <option value=''>Select Account Type</option>
                                                                                            <?php // } ?>




                                                                                        <?php

                                                                                            if($user_type == 'MNO'|| $user_type == 'SALES'){

                                                                                                if(array_key_exists('network_type',$field_array)){ $edit_distributor_type='MVNO';}
                                                                                                $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=3 AND `is_enable`=1";
                                                                                                $mno_flow=mysql_query($mno_flow_q);
                                                                                                while($mno_flow_row=mysql_fetch_assoc($mno_flow)){
                                                                                                    if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                                                                                }


                                                                                                /*echo '
                                                                                                <option value="MVNA">MVNA - Re Seller</option>
                                                                                                <option value="MVNE">MVNE - Hoster</option>
                                                                                                <option value="MVNO">MVNO - Service Provider</option>';*/
                                                                                            }

                                                                                            else if($user_type == 'MVNA'){

                                                                                                $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=3 AND `is_enable`=1";
                                                                                                $mno_flow=mysql_query($mno_flow_q);
                                                                                                while($mno_flow_row=mysql_fetch_assoc($mno_flow)){
                                                                                                    if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                                                                                }

                                                                                                //echo '<option value="MVNO">MVNO - Service Provider</option>';
                                                                                            }

                                                                                            else if($user_type == 'MVNE'){

                                                                                                $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=2 AND `is_enable`=1";
                                                                                                $mno_flow=mysql_query($mno_flow_q);
                                                                                                while($mno_flow_row=mysql_fetch_assoc($mno_flow)){
                                                                                                    if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                                                                                }


                                                                                                //echo '<option value="MVNO">MVNO - Service Provider</option>';
                                                                                            }
                                                                                        ?>

                                                                                        </select>

                                                                                </div>
                                                                            </div>
                                                                        <?php }

                                                                        if(array_key_exists('business_type',$field_array)){
                                                                        ?>

                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="location_name1">Business Vertical<?php if($field_array['business_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                                    <select <?php if($field_array['business_type']=="mandatory" ){ ?>required<?php } ?> class="span4 form-control" id="business_type" name="business_type" >
                                                                                        <option value="">Select Business Type</option>
                                                                                        
                                                                                     <?php

                                                                                        $business_vertical=$package_functions->getOptions('VERTICAL_BUSINESS_TYPES',$system_package);

                                                                                        if(!empty($business_vertical)){
                                                                                            $business_vertical_array =explode(',',$business_vertical);

                                                                                            $bvlength = count($business_vertical_array);
                                                                                                for($b = 0; $b < $bvlength; $b++) {
                                                                                                    if($edit_distributor_business_type==$business_vertical_array[$b]){
                                                                                                        ?>
                                                                                                        <option selected value="<?php echo $business_vertical_array[$b];?>"><?php echo $business_vertical_array[$b];?></option>
                                                                                                        <?php
                                                                                                    }else{
                                                                                                        ?>
                                                                                                        <option  value="<?php echo $business_vertical_array[$b];?>"><?php echo $business_vertical_array[$b];?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                   
                                                                                            }

                                                                                        }else{

                                                                                        $get_businesses_q="SELECT `business_type`,`discription` FROM `exp_business_types` WHERE `is_enable`='1'";
                                                                                        $get_businesses_r=mysql_query($get_businesses_q);
                                                                                        while($get_businesses=mysql_fetch_assoc($get_businesses_r)){
                                                                                            $get_business=$get_businesses['business_type'];
                                                                                            if($edit_distributor_business_type==$get_business){
                                                                                                ?>
                                                                                                <option selected value="<?php echo $get_business;?>"><?php echo$get_businesses['discription'];?></option>
                                                                                                <?php
                                                                                            }else{
                                                                                                ?>
                                                                                                <option value="<?php echo $get_business;?>"><?php echo$get_businesses['discription'];?></option>
                                                                                                <?php
                                                                                            }
                                                                                        }

                                                                                    }
                                                                                        ?>


                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                        <?php }

                                                                         if(array_key_exists('account_name',$field_array) || $package_features=="all"){
                                                                        ?>



                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="location_name1">Account Name<?php if($field_array['account_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                                    <input <?php if($field_array['account_name']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="location_name1" placeholder="ABC Shopping Mall" name="location_name1" type="text" value="<?php echo str_replace("\\",'',$edit_distributor_name); ?>" />

                                                                                </div>
                                                                            </div>
                                                                        <?php }




                                                                            if(array_key_exists('add1',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_address_1">Address<?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <input <?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text"   value="<?php echo $edit_bussiness_address1; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <?php }
                                                                            if(array_key_exists('add2',$field_array) || $package_features=="all"){
                                                                                ?>

                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_address_2">City<?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <input <?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text"   value="<?php echo $edit_bussiness_address2; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <?php }
                                                                            if(array_key_exists('add3',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                             <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_address_3">Address 3<?php if($field_array['add3']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <input <?php if($field_array['add3']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_3" placeholder="Address Line 3" name="mno_address_3" type="text"   value="<?php echo $edit_bussiness_address3; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <?php }
                                                                            if(array_key_exists('country',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                            <div class="control-group">

                                                                        <div class="controls col-lg-5 form-group">
                                                                        <label class="" for="mno_country" >Country<?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                        <select <?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> name="mno_country" id="country" class="span4 form-control">
                                                                            <option value="">Select Country</option>
                                                                        <?php

                                                                        // if(isset($edit_country_code)){
                                                                        //  echo '<option value="'.$edit_country_code.'">'.$edit_country_name.'</option>';
                                                                        //  }

                                                                        $count_results=mysql_query("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                                                        UNION ALL
                                                        SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");
                                                                       while($row=mysql_fetch_array($count_results)){

                                                                        if($row[a]==$edit_country_code || $row[a]== "US"){
                                                                               $select="selected";
                                                                            }else{
                                                                                $select="";
                                                                            }
                                                                                echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';

                                                                                }
                                                                        ?>


                                                                      </select>


                                                                        </div>
                                                                    </div>

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
                                                               <!-- /controls -->
                                                                            <?php }
                                                                            if(array_key_exists('region',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_state">State/Region<?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="state" placeholder="State or Region" name="mno_state" >
                                                                                    <option value="">Select State</option>
                                                                                        <?php
                                                                                     $get_regions=mysql_query("SELECT
                                                                                      `states_code`,
                                                                                      `description`
                                                                                    FROM
                                                                                    `exp_country_states` ORDER BY description ASC");

                                                                                    while($state=mysql_fetch_assoc($get_regions)){
                                                                                        if($edit_state_region==$state['states_code']) {
                                                                                            echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                                        }else{

                                                                                            echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                                        }
                                                                                    }
                                                                                    //echo '<option value="other">Other</option>';
                                                                                    ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <?php }
                                                                            if(array_key_exists('zip_code',$field_array) || $package_features=="all"){
                                                                                ?>

                                                                             <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="mno_region">ZIP Code<?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <input <?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control zip_vali" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $edit_zip; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <script type="text/javascript">

                                                                            $(document).ready(function() {



                                                                                $(".zip_vali").keydown(function (e) {


                                                                                    var mac = $('.zip_vali').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);


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

                                                                            <?php }
                                                                            if(array_key_exists('phone1',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                            <div class="control-group">
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="mno_mobile">Phone Number 1<?php if($field_array['phone1']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></sup></label>
                                                                                        <input <?php if($field_array['phone1']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control mobile1_vali" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12"  value="<?php echo $edit_phone1; ?>">
                                                                                    </div>
                                                                                </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('.mobile1_vali').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                                                                                });

                                                                                $('.mobile1_vali').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                     $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                                                                                });

                                                                                $(".mobile1_vali").keydown(function (e) {


                                                                                    var mac = $('.mobile1_vali').val();
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
                                                                                            $('.mobile1_vali').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('.mobile1_vali').val(function() {
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

                                                                                     $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                                                                                });


                                                                            });

                                                                            </script>

                                                                            <?php }
                                                                            if(array_key_exists('phone2',$field_array) || $package_features=="all"){
                                                                                ?>

                                                                           <div class="control-group">
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="mno_mobile">Phone Number 2<?php if($field_array['phone2']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                        <input <?php if($field_array['phone2']=="mandatory"){ ?>required<?php } ?> class="span4 form-control mobile2_vali" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $edit_phone2; ?>">
                                                                                    </div>
                                                                                </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('.mobile2_vali').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                     $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');

                                                                                });

                                                                                $('.mobile2_vali').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                     $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');

                                                                                });

                                                                                $(".mobile2_vali").keydown(function (e) {


                                                                                    var mac = $('.mobile2_vali').val();
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
                                                                                            $('.mobile2_vali').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('.mobile2_vali').val(function() {
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
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');
                                                                                });


                                                                            });

                                                                            </script>

                                                                            <?php }
                                                                            if(array_key_exists('phone3',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                               <div class="control-group">
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="mno_mobile">Phone Number 3<?php if($field_array['phone3']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                        <input <?php if($field_array['phone3']=="mandatory"){ ?>required<?php } ?> class="span4 form-control mobile3_vali" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $edit_phone3; ?>">
                                                                                    </div>
                                                                                </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('.mobile3_vali').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                                                                                });

                                                                                $('.mobile3_vali').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                                                                                });

                                                                                $(".mobile3_vali").keydown(function (e) {


                                                                                    var mac = $('.mobile3_vali').val();
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
                                                                                            $('.mobile3_vali').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('.mobile3_vali').val(function() {
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
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                                                                                });


                                                                            });

                                                                            </script>

                                                                            <?php }
                                                                            if(array_key_exists('time_zone',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                                     <div class="control-group">
                                                                                         <div class="controls col-lg-5 form-group">
                                                                                         <label class="" for="mno_timezone">Time Zone <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                             <select <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_time_zone" name="mno_time_zone" >
                                                                                                 <option value="">Select Time Zone</option>
                                                                                                 <?php

                                                                                                 $utc = new DateTimeZone('UTC');
                                                                                                 $dt = new DateTime('now', $utc);
                                                                                                 foreach ($priority_zone_array as $tz){
                                                                                                     $current_tz = new DateTimeZone($tz);
                                                                                                     $offset =  $current_tz->getOffset($dt);
                                                                                                     $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                                                     $abbr = $transition[0]['abbr'];
                                                                                                     if($edit_timezone==$tz){
                                                                                                         $select="selected";
                                                                                                     }else{
                                                                                                         $select="";
                                                                                                     }
                                                                                                     echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                                                 }

                                                                                                 foreach(DateTimeZone::listIdentifiers() as $tz) {
                                                                                                     //Skip
                                                                                                     if(in_array($tz,$priority_zone_array))
                                                                                                         continue;

                                                                                                    $current_tz = new DateTimeZone($tz);
                                                                                                    $offset =  $current_tz->getOffset($dt);
                                                                                                    $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                                                    $abbr = $transition[0]['abbr'];
                                                                                                    if($edit_timezone==$tz){
                                                                                                        $select="selected";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                                                       $select="";


                                                                                                }

                                                                                            /*

                                                                                                 foreach(DateTimeZone::listIdentifiers() as $tz) {
                                                                                                     $current_tz = new DateTimeZone($tz);
                                                                                                     $offset =  $current_tz->getOffset($dt);
                                                                                                     $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                                                     $abbr = $transition[0]['abbr'];
                                                                                                     if($abbr!="EST" || $abbr!="CT" || $abbr!="MT" || $abbr!="PST" || $abbr!="AKST" || $abbr!="HST" || $abbr!="EDT"){
                                                                                                     if($edit_timezone==$tz){
                                                                                                         $select="selected";
                                                                                                     }
                                                                                                     echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                                                        $select="";

                                                                                                    }
                                                                                                 }*/

                                                                                                 ?>
                                                                                             </select>
                                                                                         </div>
                                                                                     </div>

                                                                         <?php }

                                                                    if(array_key_exists('network_config',$field_array)){

                                                                    ?>
                                                                    <div class="control-group">
                                                                                         <div class="controls col-lg-5 form-group has-feedback">
                                                                            <h3>Assign Network</h3>
                                                                            <br class="mobile-hide">
                                                                        </div>
                                                                    </div>



                                    <?php
                                    //echo $_SESSION['s_token'].'***********';
                                    //print_r($access_modules_list);
                                    if(!in_array('support', $access_modules_list) || $user_type == "SALES"){
                                    ?>
                                                                        <script>

                                                                            function seldns(scrt_var){


                                                                                var a = scrt_var.length;


                                                                                // document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";

                                                                                //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                                                                $.ajax({
                                                                                    type: 'POST',
                                                                                    url: 'ajax/refreshDNSProfiles.php',
                                                                                    data: { loc_GRE: "yes", ap_control_var: scrt_var,user: '<?php echo $user_distributor; ?>' },
                                                                                    success: function(data) {

                                                                                        //alert(data);
                                                                                        $('#DNS_profile').empty();

                                                                                        $("#DNS_profile").append(data);


                                                                                        // document.getElementById("zones_loader").innerHTML = "";

                                                                                    }

                                                                                });



                                                                            }

                                                                        </script>

                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="conroller">AP Controller<sup><font color="#FF0000"></font></sup></label>
                                                                                    <select onchange="updatevariable(); selwags(this.value);gotoNode(this.value);seldns(this.value);" name="conroller" id="conroller"  class="span4 form-control con_c" required>
                                                                                        <option value="">Select AP Controller</option>
                                                                                       <?php
                                                                                                    $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                                                                                FROM exp_mno_ap_controller
                                                                                                                LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='AP'";

                                                                                                    $query_results=mysql_query($q1);
                                                                                                    while($row=mysql_fetch_array($query_results)){

                                                                                                        //$mnoid=$row[mno_id];
                                                                                                        $apc=$row[ap_controller];

                                                                                                        $ap_controller = preg_replace('/\s+/', '', $apc);
                                                                                                        if($edit_distributor_ap_controller==$apc){
                                                                                                            $controller_sel='selected';
                                                                                                        }else{
                                                                                                            $controller_sel='';
                                                                                                        }

                                                                                                        echo "<option   ".$controller_sel."  class='".$ap_controller."' value='".$apc."'>".$apc."</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                    </select>

                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->


<?php
if(isset($edit_distributor_ap_controller)){



?>

<script>
$(document).ready(function() {
    gotoNode_edit('<?php echo $edit_distributor_ap_controller;?>','<?php echo $edit_distributor_zone_id; ?>');
});

 function gotoNode_edit(scrt_var,edit_zone){
    


var a = scrt_var.length;

    if(a==0){

        alert('Please Select Controller before Refresh!');

    }else{
        document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
        //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

     $.ajax({
        type: 'POST',
        url: 'ajax/get_zones.php',
        data: { wag_ap_name: "<?php echo $wag_ap_name; ?>", ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,mno:"<?php echo $user_distributor; ?>",mvno:"<?php echo $edit_distributor_code; ?>",edit_zone:edit_zone },
        success: function(data) {

/* alert(data); */
            $('#zone').empty();

            $("#zone").append(data);


            document.getElementById("zones_loader").innerHTML = "";

        },
         error: function(){
             document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
         }

    });



        }

}
</script>
<?php
}
?>


                                                                            <script type="text/javascript">
                                        var value = "test";
                                        function updatevariable() {
                                            var conceptName = $( "#conroller" ).val();
                                            value = conceptName;
                                            scrt_var = conceptName;

                                            $("#zone").select2();

                                        }

                                        $(document).ready(function() {
                                            updatevariable();
                                        });







                                        function gotoNode(scrt_var){


                                            var a = scrt_var.length;

                                                if(a==0){

                                                    alert('Please Select Controller before Refresh!');

                                                }else{
                                                    document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                    //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                                 $.ajax({
                                                    type: 'POST',
                                                    url: 'ajax/get_zones.php',
                                                    data: { wag_ap_name: "<?php echo $wag_ap_name; ?>", ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,mno:"<?php echo $user_distributor; ?>",mvno:"<?php echo $edit_distributor_code; ?>" },
                                                    success: function(data) {

                                         /* alert(data); */
                                                        $('#zone').empty();

                                                        $("#zone").append(data);


                                                        document.getElementById("zones_loader").innerHTML = "";

                                                    },
                                                     error: function(){
                                                         document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                     }

                                                });



                                                    }

                                            }



                                              function gotoSync(){

//var a = scrt_var.length;

    
        document.getElementById("sync_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
        //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

     $.ajax({
        type: 'POST',
        url: 'ajax/get_profile.php',
        data: { user_distributor: "<?php echo $user_distributor; ?>",system_package: "<?php echo $system_package; ?>",user_name: "<?php echo $user_name; ?>" },
        success: function(data) {

 //alert(data); 
            $('#AP_contrl_guest').empty();
            $("#AP_contrl_guest").append(data);

            $('#vt_guest_pri_id').empty();
            $("#vt_guest_pri_id").append(data);

            $('#vt_guest_def_id').empty();
            $("#vt_guest_def_id").append(data);

            $('#vt_guest_pro_id').empty();
            $("#vt_guest_pro_id").append(data);


            document.getElementById("sync_loader").innerHTML = "";

        },
         error: function(){
             document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
         }

    });



        

}   


                                     </script>



                                     <script src="js/select2-3.5.2/select2.min.js"></script>
                                    <link rel="stylesheet" href="js/select2-3.5.2/select2.css" />
                                    <link rel="stylesheet" href="css/select2-bootstrap/select2-bootstrap.css" />
                                    <script type="text/javascript">
                                    $(document).ready(function() {
                                      $("#zone").select2();
                                    });
                                    </script>





                                                                        <div class="control-group" style="margin-bottom: 3px !important;">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="zone">Zones<sup><font color="#FF0000"></font></sup></label>
                                                                                <select  name="zone" id="zone"  class="span4 form-control zone_c" >
                                                                                    <option value="">Select Zone</option>
                                                                                    <?php
                                                                                    $q1 = "SELECT t1. zname AS name, t1.zid AS zoneid , t1.controller AS ap_controller,t1.`bzname` FROM
                                                                                                            (SELECT IFNULL(bz.name,'1') AS bzname, z.`name` AS zname, z.zoneid AS zid, z.ap_controller AS controller, IFNULL(d.`distributor_code`,'1') AS ok
                                                                                                            FROM `exp_mno_ap_controller` c,
                                                                                                            exp_distributor_zones z LEFT JOIN  `exp_mno_distributor` d ON z.`zoneid`=d.`zone_id`
                                                                                                            LEFT JOIN `exp_distributor_block_zones` bz ON bz.`name`=z.`name`
                                                                                                            WHERE z.`ap_controller` = c.`ap_controller`
                                                                                                            AND c.`mno_id` = '$user_distributor') t1
                                                                                                            WHERE t1.bzname='1' AND t1.ok";//='1'";
                                                                                    if(isset($edit_distributor_zone_id)){
                                                                                        $q1.=" IN('1','$edit_distributor_code')";
                                                                                    }else{
                                                                                        $q1.=" ='1'";
                                                                                    }


                                                                                    $query_results=mysql_query($q1);
                                                                                    while($row=mysql_fetch_array($query_results)){
                                                                                        $zonename = $row[name];
                                                                                        $zoneid=$row[zoneid];
                                                                                        $ap_controller=$row[ap_controller];

                                                                                        $ap_controller = str_replace(' ', '', $ap_controller);

                                                                                        if($edit_distributor_zone_id==$zoneid){
                                                                                            $select="selected";
                                                                                            $edit_distributor_zone_name = $zonename;
                                                                                        }else{
                                                                                            $select="";
                                                                                            continue;

                                                                                        }

                                                                                        echo "<option ".$select." class='selectors ".$ap_controller."' value='".$zoneid."'>".$zonename."</option>";
                                                                                    }
                                                                                    //echo $q1;
                                                                                    ?>
                                                                                </select>




                                                                                <!-- <a style="display: inline-block; padding: 6px 20px !important;margin-bottom: 10px !important;" onclick="updatevariable();gotoNode(''+ scrt_var +'');" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a> -->
                                                                                <div style="display: inline-block" id="zones_loader"></div>


                                                                                <style>
                                                                                    .select2-container{
                                                                                        margin-right: 20px !important;
                                                                                        margin-bottom: 15px !important;
                                                                                    }
                                                                                </style>



                                                                            </div>

                                                                            <!-- /controls -->
                                                                        </div>
                                                                        <!-- /control-group -->
                                                                    <?php if(isset($edit_distributor_zone_id)){ ?>
                                                                        <div style="margin-top: -3px;" class="control-group"  <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?>  >
                                                                            <div style="margin-top: 0px;" class="controls col-lg-5 form-group">

                                                                                <small>Current Zone : <b><?php
                                                                                        echo empty($edit_distributor_zone_name)?
                                                                                            '<font color="red">Zone does not exists</font>'
                                                                                            :$edit_distributor_zone_name;
                                                                                        ?></b></small>

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>

                                                                        <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="sw_conroller">SW Controller<sup><font color="#FF0000"></font></sup></label>
                                                                                    <select onchange="updateSWvariable();gotoSWNode(this.value);"  name="sw_conroller" id="sw_conroller"  class="span4 form-control sw_con_c">
                                                                                        <option value="">Select SW Controller</option>
                                                                                       <?php
                                                                                                   $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                                                                                FROM exp_mno_ap_controller
                                                                                                                LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='SW'";

                                                                                                    $query_results=mysql_query($q1);
                                                                                                    while($row=mysql_fetch_array($query_results)){

                                                                                                        //$mnoid=$row[mno_id];
                                                                                                        $apc=$row[ap_controller];

                                                                                                        $ap_controller = preg_replace('/\s+/', '', $apc);
                                                                                                        if($edit_distributor_sw_controller==$apc){
                                                                                                            $controller_sel='selected';
                                                                                                        }else{
                                                                                                            $controller_sel='';
                                                                                                        }

                                                                                                        echo "<option   ".$controller_sel."  class='".$ap_controller."' value='".$apc."'>".$apc."</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                    </select>

                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                        <script type="text/javascript">
                                                                        var value = "test";
                                                                        function updateSWvariable() {
                                                                            var sw_data = $( "#sw_conroller" ).val();
                                                                            sw_value = sw_data;
                                                                            sw_scrt_var = sw_data;
                                                                            $("#groups").select2();

                                                                        }

                                                                        $(document).ready(function() {
                                                                            updateSWvariable();
                                                                        });






                                                                        function gotoSWNode(sw_scrt_var){


                                                                            var a = sw_scrt_var.length;

                                                                                if(a==0){

                                                                                    alert('Please Select Controller before Refresh!');

                                                                                }else{
                                                                                    document.getElementById("group_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                                                    //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                                                                 $.ajax({
                                                                                    type: 'POST',
                                                                                    url: 'ajax/get_swGroups.php',
                                                                                    data: { wag_ap_name: "<?php echo $wag_ap_name; ?>", ap_control_var: "<?php echo $ap_control_var; ?>",ackey:sw_scrt_var,mno:"<?php echo $user_distributor; ?>",mvno:"<?php echo $edit_distributor_code; ?>" },
                                                                                    success: function(data) {

                                                                         /* alert(data); */
                                                                                        $('#groups').empty();

                                                                                        $("#groups").append(data);


                                                                                        document.getElementById("group_loader").innerHTML = "";

                                                                                    },
                                                                                     error: function(){
                                                                                         document.getElementById("group_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                                                     }

                                                                                });



                                                                                    }

                                                                            }


                                                                        </script>

                                                                        <div class="control-group" style="margin-bottom: 3px !important;">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="groups">Groups<sup><font color="#FF0000"></font></sup></label>
                                                                                <select  name="groups" id="groups"  class="span4 form-control group_c" >
                                                                                    <option value="">Select Group</option>
                                                                                    <?php
                                                                                    if(!empty($edit_distributor_sw_group_id)) {
                                                                                        include_once 'classes/ICXSwitch.php';
                                                                                        $sync_obj = Sync_sw_group::withVerificationNumber($edit_distributor_verification_number);
                                                                                        try {
                                                                                            $sync_obj->syncGroupById($edit_distributor_sw_group_id);
                                                                                        } catch (Exception $e) {
                                                                                        }
                                                                                    }

                                                                                    $q1 = "SELECT DISTINCT t1.zid AS zoneid , t1. zname AS name,  t1.controller AS ap_controller,t1.`bzname` FROM
  (SELECT IFNULL(bz.name,'1') AS bzname, g.`name` AS zname, g.groupid AS zid, g.ap_controller AS controller, IFNULL(d.`distributor_code`,'1') AS ok
   FROM `exp_mno_ap_controller` c,
     exp_distributor_switch_groups g LEFT JOIN  `exp_mno_distributor` d ON g.`groupid`=d.switch_group_id
     LEFT JOIN `exp_distributor_block_zones` bz ON bz.`name`=g.`name`
   WHERE g.`ap_controller` = c.`ap_controller`
         AND c.`mno_id` = '$user_distributor') t1
WHERE t1.bzname='1' AND t1.ok";
                                                                                    if(isset($edit_distributor_sw_group_id)){
                                                                                        $q1.=" IN('1','$edit_distributor_code') AND t1.controller='".$edit_distributor_sw_controller."'";
                                                                                        $query_results=mysql_query($q1);
                                                                                    }/*else{
                                                                                        $q1.=" ='1'";
                                                                                    }*/


                                                                                    $query_results=mysql_query($q1);
                                                                                    while($row=mysql_fetch_array($query_results)){
                                                                                        $zonename = $row[name];
                                                                                        $zoneid=$row[zoneid];
                                                                                        $ap_controller=$row[ap_controller];

                                                                                        $ap_controller = str_replace(' ', '', $ap_controller);

                                                                                        if($edit_distributor_sw_group_id==$zoneid){
                                                                                            $select="selected";
                                                                                            $edit_distributor_zone_name = $zonename;
                                                                                        }else{
                                                                                            $select="";

                                                                                        }

                                                                                        echo "<option ".$select." class='selectors ".$ap_controller."' value='".$zoneid."'>".$zonename."</option>";
                                                                                    }
                                                                                    //echo $q1;
                                                                                    ?>
                                                                                </select>




                                                                                <a style="display: inline-block; padding: 6px 20px !important;margin-bottom: 10px !important;" onclick="updateSWvariable();gotoSWNode(sw_scrt_var);"  class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                                                                <div style="display: inline-block" id="group_loader"></div>


                                                                                <style>
                                                                                    .select2-container{
                                                                                        margin-right: 20px !important;
                                                                                        margin-bottom: 15px !important;
                                                                                    }
                                                                                </style>



                                                                            </div>

                                                                            <!-- /controls -->
                                                                        </div>
                                                                        <!-- /control-group -->



                                         <script>

                                         function selwags(scrt_var){


                                            var a = scrt_var.length;


                                                    // document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";

                                                    //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                                 $.ajax({
                                                     type: 'POST',
                                                     url: 'ajax/refreshGREProfiles.php',
                                                     data: { loc_GRE: "yes", ap_control_var: scrt_var,user: '<?php echo $user_distributor; ?>' },
                                                     success: function(data) {

                                           //alert(data);
                                                        $('#wag_name').empty();

                                                        $("#wag_name").append(data);


                                                        // document.getElementById("zones_loader").innerHTML = "";

                                                     },
                                                      error: function(){
                                                         // document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                      }

                                                 });



                                             }
                                            
                                      </script>

                                           
                                                                        <div class="control-group"  id="gateway" <?php  if($edit_distributor_gateway_type=='ac' || $field_array['ne_WAG']=='display_none' ){echo 'style="display: none; margin-bottom: 3px !important;"';}else{echo 'style="margin-bottom: 3px !important;"';}?> >
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="zone_name">WAG<sup><font color="#FF0000"></font></label>
                                                                                <select  class="span4 form-control" id="wag_name" name="wag_name" style="display: inline-block">
                                                                                   <?php echo'<option value="">Select Option</option>';

                                                                                   if($edit_distributor_wag_profile){

                                                                                    $sel_ap="AND  w.`ap_controller`='$edit_distributor_ap_controller'";

                                                                                   }else{

                                                                                    $sel_ap='';

                                                                                   }

                                                                                    $get_wags_per_controller="SELECT w.`wag_code`,w.`wag_name` FROM `exp_wag_profile` w , `exp_mno_ap_controller` c
                                                                                                                    WHERE w.`ap_controller`=c.`ap_controller` ".$sel_ap." AND c.`mno_id`='$user_distributor' GROUP BY w.`wag_code`";

                                                                                    $get_wags_per_controller_r=mysql_query($get_wags_per_controller);
                                                                                    while($get_wags_per_controller_d=mysql_fetch_assoc($get_wags_per_controller_r)){
                                                                                        if($edit_distributor_wag_profile==$get_wags_per_controller_d[wag_code]){
                                                                                            $wag_select="selected";
                                                                                        }else{
                                                                                            $wag_select='';
                                                                                        }
                                                                                        echo'<option '.$wag_select.' value="'.$get_wags_per_controller_d[wag_code].'">'.$get_wags_per_controller_d[wag_name].'</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select><input type="checkbox" <?php if($edit_distributor_wag_profile_enable=='1' || $edit_distributor_wag_profile_enable=='on' ){echo 'checked'; }?> name="content_filter" class="hide_checkbox" style="display: inline-block;" data-toggle="toggle" >
                                                                            </div>
                                                                            <small>Note: Turn switch to ON to enable content filtering</small>
                                                                        </div>

                                                                        <style>
                                                                                    #wag_name{
                                                                                        margin-right: 20px !important;
                                                                                        margin-bottom: 15px !important;
                                                                                    }

                                                                                    div.toggle{
                                                                                        margin-bottom: 15px !important;
                                                                                    }

                                                                                </style>




                                                                        <div class="control-group"  <?php if(($field_array['network_config']=='display_none')|| ($field_array['unique_property_id']=='display_none')){echo 'style="display:none"';} ?>  >
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="zone_name">Unique Property ID<sup><font color="#FF0000"></font></label>
                                                                                <input class="span4 form-control" id="zone_name" name="zone_name" type="text" placeholder="Circuit ID#" maxlength="32" value="<?php echo$edit_distributor_property_id;?>">
                                                                            </div>
                                                                        </div>

                                                                                    <script type="text/javascript">
                                                                              $("#zone_name").keypress(function(event){
                                                                                 
                                                                                var ew = event.which;
                                                                               // alert(ew);
                                                                               if(ew == 45 || ew == 95)
                                                                                  return true;
                                                                                if(ew == 32)
                                                                                  return true;
                                                                                if(ew == 47)
                                                                                  return true;
                                                                                if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122 || ew == 0  || ew == 8 || ew == 189)
                                                                                  return true;
                                                                                return false;
                                                                              });
                                                                            </script>


                                                                        <div class="control-group"  <?php if($field_array['network_config_des']=='display_none'){echo 'style="display:none"';} ?>  >
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="zone_dec">Description<sup><font color="#FF0000"></font></label>
                                                                                <input class="span4 form-control" id="zone_dec" name="zone_dec" type="text" placeholder="Coffeeshop chain" value="<?php echo$edit_distributor_group_description;?>">
                                                                            </div>
                                                                        </div>

                                                                        <div id="realmDiv" class="control-group" <?php if($field_array['network_config_realm']=='display_none'){echo 'style="display:none"';} ?>  >
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="zone_dec">Realm<sup><font color="#FF0000"></font></label>
                                                                                <input required  style="display: inline-block" class="span4 form-control" id="realm" name="realm" type="text" placeholder="123456789" onblur="vali_realm(this)" value="<?php echo $edit_distributor_realm;?>" <?php if(array_key_exists('icomms_number',$field_array) || array_key_exists('icomms_number_m',$field_array)){ if($edit_account==1) echo "readonly"; } ?>>
                                                                                <div style="display: inline-block" id="img"></div>
                                                                            </div>
                                                                        </div>

                                                                        <script>

                                                                            $(document).ready(function() {
                                                                                $("#zone_uid_nouse").keydown(function (e) {
                                                                                    // Allow: backspace, delete, tab, escape, enter and .
                                                                                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                                                            // Allow: Ctrl+A, Command+A
                                                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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
                                                                    <?php if($edit_account!=1){   ?>
                                                                        <script>
                                                                            function vali_realm(rlm) {
                                                                                var val = rlm.value;
                                                                                var val = val.trim();



                                                                                if(val!="") {
                                                                                    document.getElementById("img").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                                                    var formData = {realm: val};
                                                                                    $.ajax({
                                                                                        url: "ajax/validateRealm.php",
                                                                                        type: "POST",
                                                                                        data: formData,
                                                                                        success: function (data) {
                                                                                            /*  if:new ok->1
                                                                                             * if:new exist->2 */
                                                                                            /* alert(data);*/

                                                                                            if (data == '1') {
                                                                                                /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                                                                document.getElementById("img").innerHTML ="";

                                                                                            } else if (data == '2') {

                                                                                                document.getElementById("img").innerHTML = "<p style=\"display: inline-block; color:red\">"+val+" - Realm is already exists.</p>";
                                                                                                document.getElementById('realm').value = "";
                                                                                                /* $('#mno_account_name').removeAttr('value'); */
                                                                                                document.getElementById('realm').placeholder = "Please enter new realm";
                                                                                            }
                                                                                        },
                                                                                        error: function (jqXHR, textStatus, errorThrown) {
                                                                                            alert("error");
                                                                                            document.getElementById('realm').value = "";
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }
                                                                        </script>
                                                                    <?php }

                                                                     }
                                                                    else{
                                        ?>
                                                                        <div class="control-group">
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="conroller">Controller<sup><font color="#FF0000"></font></sup></label>
                                                                                <input readonly value="<?php echo $edit_distributor_ap_controller; ?>"  name="conroller" id="conroller"  class="span4 form-control "  required>
                                                                            </div>
                                                                            <!-- /controls -->
                                                                        </div>
                                                                        <!-- /control-group -->

                                                                            <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" for="zone">Zones<sup><font color="#FF0000"></font></sup></label>
                                                                                    <input type="text" readonly value="<?php echo $db->getValueAsf("SELECT `name` AS f FROM `exp_distributor_zones` WHERE `zoneid`='$edit_distributor_zone_id'");?>"    class="span4 form-control" >
                                                                                    <input type="hidden" readonly value="<?php echo $edit_distributor_zone_id;?>"  name="zone" id="zone"  >
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->





                                                                        <div class="control-group" <?php  if($edit_distributor_gateway_type=='ac' || $field_array['ne_WAG']=='display_none' ){echo 'style="display: none; margin-bottom: 3px !important;"';}else{echo 'style="margin-bottom: 3px !important;"';}?> >
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="zone_name">WAG<sup><font color="#FF0000"></font></label>
                                                                                <input readonly type="text"  value="<?php echo $db->getValueAsf("SELECT `wag_name` AS f FROM `exp_wag_profile` WHERE `wag_code`='$edit_distributor_wag_profile'"); ?>" required class="span4 form-control" style="display: inline-block">
                                                                                <input readonly type="hidden"  value="<?php echo $edit_distributor_wag_profile; ?>" id="wag_name" name="wag_name" style="display: inline-block">
                                                                                     <input  type="checkbox" <?php if($edit_distributor_wag_profile_enable=='1'){echo 'checked'; }?> name="content_filter" class="hide_checkbox" style="display: inline-block" data-toggle="toggle" >
                                                                            </div>
                                                                                <small>Note: Turn switch to ON to enable content filtering</small>
                                                                        </div>




                                                                        <div class="control-group" <?php

                                                                         if(($field_array['network_config']=='display_none')|| ($field_array['unique_property_id']=='display_none')){echo 'style="display:none"';} ?> >
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="zone_name">Unique Property ID<sup><font color="#FF0000"></font></label>
                                                                                        <input readonly class="span4 form-control" id="zone_name" name="zone_name" type="text" placeholder="Circuit ID#" value="<?php echo$edit_distributor_property_id;?>">
                                                                                    </div>
                                                                                </div>




                                                        <div class="control-group" <?php if($field_array['network_config_des']=='display_none'){echo 'style="display:none"';} ?> >
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                    <label class="" for="zone_dec">Description<sup><font color="#FF0000"></font></label>
                                                                                        <input readonly class="span4 form-control" id="zone_dec" name="zone_dec" type="text" placeholder="Coffeeshop chain" value="<?php echo$edit_distributor_group_description;?>">
                                                                                    </div>
                                                                                </div>

                                                                        <div class="control-group"  <?php if($field_array['network_config_realm']=='display_none'){echo 'style="display:none"';} ?> >
                                                                            <div class="controls col-lg-5 form-group">
                                                                            <label class="" for="zone_dec">Realm<sup><font color="#FF0000"></font></label>
                                                                                <input required  style="display: inline-block" class="span4 form-control" id="realm" name="realm" type="text" placeholder="123456789"  value="<?php echo $edit_distributor_realm;?>" <?php if(array_key_exists('icomms_number',$field_array) || array_key_exists('icomms_number_m',$field_array)){ if($edit_account==1) echo "readonly"; } ?>>
                                                                            </div>
                                                                        </div>



                                                                        <?php
                                                                    }
                                                                        $get_tunnel_q="SELECT CONCAT('{',GROUP_CONCAT('\"',g.gateway_name,'\":',g.tunnels),'}') AS a FROM exp_gateways g GROUP BY g.is_enable";

                                                                        $get_tunnels=mysql_query($get_tunnel_q);
                                                                        while($tunnels=mysql_fetch_assoc($get_tunnels)){
                                                                            $tunnelsa=$tunnels[a];
                                                                        }



                                                                         }
 
                                                                         echo '<div style="position: relative;">';
                                                                    if(array_key_exists('p_QOS',$field_array) || array_key_exists('g_QOS',$field_array) || ($package_functions->getOptions('VTENANT_MODULE',$system_package)=='Vtenant') ||  $package_features=="all") {
                                                                        ?>

                                                                        <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">

                                                                        <h3 id="pg_prof">Assign QoS Profiles</h3>

                                                                            </div>
                                                                        </div>

                                                                        <?php

                                                                        $json_sync_fields = $package_functions->getOptions('SYNC_PRODUCTS_FROM_AAA', $system_package);
                                                                        $sync_array = json_decode($json_sync_fields, true);

                                                                        ?>
                                                                        <style>
                                                                            @media (max-width: 520px){
                                                                                .qos-sync-button {
                                                                                    margin-bottom: 15px !important;
                                                                                }
                                                                            } 
                                                                            @media (min-width: 520px){
                                                                                .qos-sync-button {
                                                                                    margin-top: 20px !important;
                                                                                    float:right;
                                                                                    margin-right: 22%;
                                                                                }
                                                                            }
                                                                        </style>

                                                                        <div class="control-group">
                                                                                <div class="controls col-lg-5 form-group">

                                                                        <a <?php if ($sync_array['g_QOS_sync'] == 'display') {
                                                                            echo 'style="display: inline-block;padding: 6px 20px !important;"';
                                                                        } else {
                                                                            echo 'style="display:none"';
                                                                        } ?> onclick="gotoSync();"
                                                                             class="btn btn-primary qos-sync-button"
                                                                             style="align: left;"><i
                                                                                    class="btn-icon-only icon-refresh"></i>
                                                                            Sync</a>
                                                                        </div>
                                                                    </div>
                                                                        <div style=""
                                                                             id="sync_loader"></div>
                                                                        <?php
                                                                        if (array_key_exists('p_QOS', $field_array) || $package_features == "all") {
                                                                            ?>

                                                                            <div class="control-group"
                                                                                 id="p_prof2" <?php if ($field_array['p_QOS'] == 'display_none') {
                                                                                echo 'style="display:none"';
                                                                            } ?>>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class=""
                                                                                       for="AP_contrl">Private QoS
                                                                                    Profile<?php if ($field_array['p_QOS'] == "mandatory") { ?>
                                                                                        <font color="#FF0000"></font></sup><?php } ?>
                                                                                </label>
                                                                                    <select
                                                                                        <?php if ($field_array['p_QOS'] == "mandatory"){ ?>required<?php } ?>
                                                                                        name="AP_contrl" id="AP_contrl"
                                                                                        class="span4 form-control">
                                                                                        <option value="">Select
                                                                                            Profile
                                                                                        </option>
                                                                                        <?php
                                                                                        $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                                                                                FROM exp_products
                                                                                                                WHERE network_type='private' AND mno_id='$user_distributor'";

                                                                                        $query_results = mysql_query($q1);
                                                                                        while ($row = mysql_fetch_array($query_results)) {
                                                                                            $dis_code = $row[product_code];
                                                                                            $dis_id = $row[product_id];
                                                                                            $dis_name = $row[product_name];
                                                                                            $dis_QOS = $row[QOS];

                                                                                            if ($edit_distributor_product_id_p == $dis_id) {
                                                                                                $select = "selected";
                                                                                            } else {
                                                                                                $select = "";
                                                                                            }

                                                                                            echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_code . "</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->


                                                                            <div class="control-group"
                                                                                 id="pd_prof" <?php if ($field_array['pd_QOS'] == 'display_none') {
                                                                                echo 'style="display:none"';
                                                                            } ?>>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class=""
                                                                                       for="AP_contrl">Duration
                                                                                    Profile<?php if ($field_array['pd_QOS'] == "mandatory") { ?>
                                                                                        <font color="#FF0000"></font></sup><?php } ?>
                                                                                </label>
                                                                                    <select
                                                                                        <?php if ($field_array['pd_QOS'] == "mandatory"){ ?>required<?php } ?>
                                                                                        name="AP_contrl_time"
                                                                                        id="AP_contrl_time"
                                                                                        class="span4 form-control">
                                                                                        <option value="">Select
                                                                                            Profile
                                                                                        </option>
                                                                                        <?php
                                                                                        $q1 = "SELECT id,profile_code,profile_name,duration,profile_type
                                                                                                                FROM exp_products_duration
                                                                                                                WHERE profile_type IN('2','3') AND distributor='$user_distributor'";

                                                                                        $query_results = mysql_query($q1);
                                                                                        while ($row = mysql_fetch_array($query_results)) {
                                                                                            $select = "";
                                                                                            $dis_id = $row[id];
                                                                                            echo $dis_code = $row[profile_code];
                                                                                            $dis_name = $row[profile_name];
                                                                                            $timegap = $row[duration];
                                                                                            $gap = "";
                                                                                            if ($timegap != '') {

                                                                                                $interval = new DateInterval($timegap);

                                                                                                if ($interval->y != 0) {
                                                                                                    $gap .= $interval->y . ' Years';
                                                                                                }
                                                                                                if ($interval->m != 0) {
                                                                                                    $gap .= $interval->m . ' Months';
                                                                                                }
                                                                                                if ($interval->d != 0) {
                                                                                                    $gap .= $interval->d . ' Days';
                                                                                                }
                                                                                                if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0 || $interval->h != 0)) {
                                                                                                    $gap .= ' And ';
                                                                                                }
                                                                                                if ($interval->i != 0) {
                                                                                                    $gap .= $interval->i . ' Minutes';
                                                                                                }
                                                                                                if ($interval->h != 0) {
                                                                                                    $gap .= $interval->h . ' Hours';
                                                                                                }

                                                                                            }
                                                                                            if ($edit_distributor_product_id_p_time == $dis_code) {
                                                                                                $select = "selected";
                                                                                            }

                                                                                            echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_name . " (" . $gap . ")" . "</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>


                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                        <?php }
                                                                        if (array_key_exists('g_QOS', $field_array) || $package_features == "all") {
                                                                            ?>

                                                                            <div class="control-group" id="g_prof2">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class=""
                                                                                       for="AP_contrl_guest">Guest QoS
                                                                                    Profile<?php if ($field_array['g_QOS'] == "mandatory") { ?>
                                                                                        <font color="#FF0000"></font></sup><?php } ?>
                                                                                </label>
                                                                                    <select
                                                                                        <?php if ($field_array['g_QOS'] == "mandatory"){ ?>required<?php } ?>
                                                                                        name="AP_contrl_guest"
                                                                                        id="AP_contrl_guest"
                                                                                        class="span4 form-control"
                                                                                        style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                                                                        <option value="">Select Guest
                                                                                            Profile
                                                                                        </option>
                                                                                        <?php

                                                                                        $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                                                                                FROM exp_products
                                                                                                                WHERE network_type='GUEST' AND mno_id='$user_distributor'";

                                                                                        $query_results = mysql_query($q1);
                                                                                        while ($row = mysql_fetch_array($query_results)) {
                                                                                            $select = "";
                                                                                            $dis_code = $row[product_code];
                                                                                            $dis_g_id = $row[product_id];
                                                                                            $dis_name = $row[product_name];
                                                                                            $dis_QOS = $row[QOS];

                                                                                            if ($edit_distributor_product_id_g == $dis_g_id) {
                                                                                                $select = "selected";
                                                                                            }

                                                                                            echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . "</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->


                                                                            <?php if ($field_array['g_QOS_du'] == 'display_none') { ?>
                                                                                <style>
                                                                                    #gd_prof {
                                                                                        display: none !important;

                                                                                    }
                                                                                </style>

                                                                            <?php } ?>

                                                                            <div class="control-group" id="gd_prof">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class=""
                                                                                       for="AP_contrl">Duration
                                                                                    Profile<?php if ($field_array['p_QOS'] == "mandatory") { ?>
                                                                                        <font color="#FF0000"></font></sup><?php } ?>
                                                                                </label>
                                                                                    <select
                                                                                        <?php if ($field_array['g_QOS'] == "mandatory" && $field_array['g_QOS_du'] != 'display_none'){ ?>required<?php } ?>
                                                                                        name="AP_contrl_guest_time"
                                                                                        id="AP_contrl_guest_time"
                                                                                        class="span4 form-control">
                                                                                        <option value="">Select
                                                                                            Profile
                                                                                        </option>
                                                                                        <?php
                                                                                        $q1 = "SELECT id,profile_code,profile_name,duration,profile_type
                                                                                                                FROM exp_products_duration
                                                                                                                WHERE profile_type IN('1','3') AND distributor='$user_distributor'";

                                                                                        $query_results = mysql_query($q1);
                                                                                        while ($row = mysql_fetch_array($query_results)) {
                                                                                            $select = "";
                                                                                            $dis_id = $row[id];
                                                                                            $dis_code = $row[profile_code];
                                                                                            $dis_name = $row[profile_name];
                                                                                            $timegap = $row[duration];
                                                                                            $gap = "";
                                                                                            if ($timegap != '') {

                                                                                                $interval = new DateInterval($timegap);

                                                                                                if ($interval->y != 0) {
                                                                                                    $gap .= $interval->y . ' Years ';
                                                                                                }
                                                                                                if ($interval->m != 0) {
                                                                                                    $gap .= $interval->m . ' Months ';
                                                                                                }
                                                                                                if ($interval->d != 0) {
                                                                                                    $gap .= $interval->d . ' Days ';
                                                                                                }
                                                                                                if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0 || $interval->h != 0)) {
                                                                                                    $gap .= ' And ';
                                                                                                }
                                                                                                if ($interval->h != 0) {
                                                                                                    $gap .= $interval->h . ' Hours ';
                                                                                                }
                                                                                                if ($interval->i != 0) {
                                                                                                    $gap .= $interval->i . ' Minutes';
                                                                                                }


                                                                                            }
                                                                                            if ($edit_distributor_product_id_g_time == $dis_code) {
                                                                                                $select = "selected";
                                                                                            }
                                                                                            echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_name . " (" . $gap . ")" . "</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                        <?php }
                                                                        if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") {
                                                                            ?>

                                                                            <div class="control-group"
                                                                                 id="vt_guest_def">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class=""
                                                                                       for="AP_contrl_guest">vTenant
                                                                                    default QoSProfile
                                                                                </label>
                                                                                    <select
                                                                                        <?php if ($field_array['vt_QOS_def'] == "mandatory"){ ?>required<?php } ?>
                                                                                        name="vt_guest_def"
                                                                                        id="vt_guest_def_id"
                                                                                        class="span4 form-control"
                                                                                        style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                                                                        <option value="">Select
                                                                                            Profile
                                                                                        </option>
                                                                                        <?php

                                                                                        $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                                                                                FROM exp_products
                                                                                                                WHERE network_type='GUEST' AND mno_id='$user_distributor'";

                                                                                        $query_results = mysql_query($q1);
                                                                                        while ($row = mysql_fetch_array($query_results)) {
                                                                                            $select = "";
                                                                                            $dis_code = $row[product_code];
                                                                                            $dis_g_id = $row[product_id];
                                                                                            $dis_name = $row[product_name];
                                                                                            $dis_QOS = $row[QOS];

                                                                                            if ($edit_distributor_product_id_def == $dis_g_id) {
                                                                                                $select = "selected";
                                                                                            }

                                                                                            echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . "</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                        <?php }
                                                                        if ($package_functions->getSectionType('VTENANT_TYPE',$system_package)!='1' && (array_key_exists('vt_QOS_pro', $field_array) || $package_features == "all")) {
                                                                            ?>

                                                                            <div class="control-group"
                                                                                 id="vt_guest_pro">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class=""
                                                                                       for="AP_contrl_guest">vTenant
                                                                                    probation QoS Profile
                                                                                </label>
                                                                                    <select
                                                                                        <?php if ($field_array['vt_QOS_pro'] == "mandatory"){ ?>required<?php } ?>
                                                                                        name="vt_guest_pro"
                                                                                        id="vt_guest_pro_id"
                                                                                        class="span4 form-control"
                                                                                        style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                                                                        <option value="">Select
                                                                                            Profile
                                                                                        </option>
                                                                                        <?php

                                                                                        $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                                                                                FROM exp_products
                                                                                                                WHERE network_type='GUEST' AND mno_id='$user_distributor'";

                                                                                        $query_results = mysql_query($q1);
                                                                                        while ($row = mysql_fetch_array($query_results)) {
                                                                                            $select = "";
                                                                                            $dis_code = $row[product_code];
                                                                                            $dis_g_id = $row[product_id];
                                                                                            $dis_name = $row[product_name];
                                                                                            $dis_QOS = $row[QOS];

                                                                                            if ($edit_distributor_product_id_pro == $dis_g_id) {
                                                                                                $select = "selected";
                                                                                            }

                                                                                            echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . "</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                        <?php }
                                                                        if ($package_functions->getSectionType('VTENANT_TYPE',$system_package)!='1' && (array_key_exists('vt_QOS_pri', $field_array) || $package_features == "all")) {
                                                                            ?>

                                                                            <div class="control-group"
                                                                                 id="vt_guest_pri">
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class=""
                                                                                       for="AP_contrl_guest">vTenant
                                                                                    premium QoS Profile
                                                                                </label>
                                                                                    <select
                                                                                        <?php if ($field_array['vt_QOS_pri'] == "mandatory"){ ?>required<?php } ?>
                                                                                        name="vt_guest_pri"
                                                                                        id="vt_guest_pri_id"
                                                                                        class="span4 form-control"
                                                                                        style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                                                                        <option value="">Select
                                                                                            Profile
                                                                                        </option>
                                                                                        <?php

                                                                                        $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                                                                                FROM exp_products
                                                                                                                WHERE network_type='GUEST' AND mno_id='$user_distributor'";

                                                                                        $query_results = mysql_query($q1);
                                                                                        while ($row = mysql_fetch_array($query_results)) {
                                                                                            $select = "";
                                                                                            $dis_code = $row[product_code];
                                                                                            $dis_g_id = $row[product_id];
                                                                                            $dis_name = $row[product_name];
                                                                                            $dis_QOS = $row[QOS];

                                                                                            if ($edit_distributor_product_id_pri == $dis_g_id) {
                                                                                                $select = "selected";
                                                                                            }

                                                                                            echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . "</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                        <?php }

                                                                    }
                                                                    echo '</div>';
                                                                    if(array_key_exists('content_filter_dns',$field_array) ||  $package_features=="all"){
                                                                    ?>

                                                                    <div class="control-group" >
                                                                                <div class="controls col-lg-5 form-group">

                                                                        <h3 id="pg_prof">Optional Features</h3>
                                                                    </div>
                                                                </div>

                                                                <br class="mobile-hide">

                                                                <div class="control-group" >
                                                                                <div class="controls col-lg-5 form-group">
                                                                                <label class="" style="margin-top: 14px;" for="optona feature content filtering">Content Filtering<?php if($field_array['g_QOS']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <select <?php if($field_array['content_filter_dns']=="mandatory"){ ?>required<?php } ?> name="DNS_profile" id="DNS_profile"  class="span4 form-control" >
                                                                                        <?php echo'<option value="">Select Option</option>';

                                                                                        if($edit_distributor_dns_profile){
                                                                                            $sel_ap="AND  w.`controller`='$edit_distributor_ap_controller'";
                                                                                        }else{
                                                                                            $sel_ap='';
                                                                                        }

                                                                                        $get_wags_per_controller="SELECT w.`profile_code`,w.`name` FROM `exp_controller_dns` w , `exp_mno_ap_controller` c
                                                                                                                    WHERE w.`controller`=c.`ap_controller` ".$sel_ap." AND c.`mno_id`='$user_distributor' GROUP BY w.`profile_code`";

                                                                                        $get_wags_per_controller_r=mysql_query($get_wags_per_controller);
                                                                                        while($get_wags_per_controller_d=mysql_fetch_assoc($get_wags_per_controller_r)){
                                                                                            if($edit_distributor_dns_profile==$get_wags_per_controller_d[profile_code]){
                                                                                                $wag_select="selected";
                                                                                            }else{
                                                                                                $wag_select='';
                                                                                            }
                                                                                            echo'<option '.$wag_select.' value="'.$get_wags_per_controller_d[profile_code].'">'.$get_wags_per_controller_d[name].'</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                    
                                                                                    <input id="DNS_profile_control" name="DNS_profile_control" value="on" onchange="dns_control()" type="checkbox" data-size="mini" <?php if($edit_distributor_dns_profile_enable == 1 ){echo 'checked'; }?> data-toggle="toggle" data-onstyle="success" data-offstyle="warning">
                                                                                        <script>
                                                                                            
                                                                                        
                                                                                        function dns_control(){
                                                                                             var add_ap_form_validator = $('#location_form').data('bootstrapValidator');
                                                                                            var dnscheckBox = document.getElementById("DNS_profile_control");
                                                                                               // alert(dnscheckBox);
                                                                                         if (dnscheckBox.checked == true){
                                                                                            add_ap_form_validator.enableFieldValidators('DNS_profile', true);
                                                                                         } else {
                                                                                            add_ap_form_validator.enableFieldValidators('DNS_profile', false);
                                                                                                      } 
                                                                                            
                                                                                        }

                                                                                       
                                                                                        
                                                                                        </script>

                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                    <?php
                                                                        } ?>

                                                                    <div class="form-actions">

                                                                        <?php if($edit_account=='1')$btn_name='Update Location & Save';else $btn_name='Add Location & Save';

                                                                            if($create_location_btn_action=='create_location_next' || $create_location_btn_action=='add_location_next'  || $_POST['p_update_button_action']=='add_location' || $edit_account=='1'){
                                                                                echo '<button onmouseover="btn_action_change(\'add_location_submit\');" disabled type="submit" name="add_location_submit" id="add_location_submit" class="btn btn-primary">'.$btn_name.'</button><strong><font color="#FF0000"></font> </strong>';
                                                                                $location_count = $db->getValueAsf("SELECT count(id) as f FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'");
                                                                                if($location_count<1000  && !isset($_GET['edit_loc_id']) && !isset($_POST['p_update_button_action']) ){
                                                                                    echo '<button onmouseover="btn_action_change(\'add_location_next\');"  disabled type="submit" name="add_location_next" id="add_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';
                                                                                }

                                                                            }else{


                                                                                echo '<button onmouseover="btn_action_change(\'create_location_submit\');"  disabled type="submit" name="create_location_submit" id="create_location_submit"
                                                                        class="btn btn-primary">Create Account & Save</button><strong><font color="#FF0000"></font> </strong>';

                                                                                echo '<button onmouseover="btn_action_change(\'create_location_next\');"  disabled type="submit" name="create_location_next" id="create_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';

                                                                            }


                                                                            if($edit_account=='1' || $_POST['p_update_button_action']=='add_location' || $_POST['btn_action']=='add_location_next'){?>
                                                                            <a href="?token7=<?php echo $secret;?>&t=12&edit_parent_id=<?php echo $edit_parent_id  ;?>" style="text-decoration:none;" class="btn btn-info inline-btn" >Cancel</a>
                                                                        <?php } ?>


                                                                            <input type="hidden" name="edit_account" value="<?php echo $edit_account; ?>" />
                                                                            <input type="hidden" name="edit_distributor_code" value="<?php echo $edit_distributor_code; ?>" />
                                                                            <input type="hidden" name="edit_distributor_id" value="<?php echo $edit_loc_id; ?>" />
                                                                            <input type="hidden" name="btn_action"  id = "btn_action" value="" />
                                                                            <input type="hidden" name="add_new_location"  value="<?php echo  $_POST['p_update_button_action']=='add_location'?'1':'0' ?>" />
                                                                        <script type="text/javascript">
                                                                            function btn_action_change(action) {
                                                                                $('#btn_action').val(action);
                                                                            }

                                                                            $(document).ready(function() {
                                                                                $(window).keydown(function(event){
                                                                                    if(event.keyCode == 13) {
                                                                                        event.preventDefault();
                                                                                        return false;
                                                                                    }
                                                                                });
                                                                            });
                                                                        </script>

                                                                    </div>

                                                                    </div>

                                                        <!-- /form-actions -->
                                                        </fieldset>
                                                    </form>

                                    <script type="text/javascript">

                                    function location_formfn() {

                                        //document.getElementById("create_location_submit").disabled = false;

                                    }

                                    </script>


                                    <?php if(isset($_GET['create_location_next']) || isset($_GET['add_location_next']) ) {

                                        $props_q = "SELECT id,distributor_code,verification_number,property_id FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'";
                                        $props_r = mysql_query($props_q);

                                        ?>
                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Account Locations</h3>

                                                </div>

                                                <!-- /widget-header -->

                                                <div class="widget-content table_response">

                                                    <div style="overflow-x:auto">

                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Business ID</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Customer Account#</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Property ID</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">APS</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Remove</th>

                                                            </tr>

                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            while($props_row =  mysql_fetch_assoc($props_r)){
                                                                $cus_ac_num = $props_row['verification_number'];
                                                                $cus_prop_id =  $props_row['property_id'];
                                                                $cus_id = $props_row['id'];
                                                                $cus_code = $props_row['distributor_code'];

                                                                echo '<tr>';
                                                                    echo '<td>';
                                                                        echo $edit_parent_id;
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo $cus_ac_num;
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo $cus_prop_id;
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo 'view';
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo 'edit';
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo 'remove';
                                                                    echo '</td>';
                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php } ?>
                                        </div>

                                            <!-- ******************************************************* -->
                                        <div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp">

                                   <div id="response_d1">

                                        </div>

                                          <?php if(isset($_GET['view_loc_code'])){ //v1

                                                ///Show account mac details///////
                                                $view_loc_code=$_GET['view_loc_code'];
                                                $view_loc_name=$_GET['view_loc_name'];

                                                ?>



                                        <div id="response_d1">

                                        </div>



                                                <div class="widget widget-table action-table">
                                            <div class="widget-header">
                                                <!-- <i class="icon-th-list"></i> -->
                                                <h3>View Account</h3>


                                                    
                                                    
                                            </div>


                                        
                                                <!-- /widget-header -->

                                                <div class="widget-content table_response">
                                                
                                                <div style="overflow-x:auto">
                                                
                                                
                                                
                                                <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Business ID</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Customer Account#</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Serial</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Model</th>
                                                            <?php // echo$package_functions->getSectionType('AP_ACTIONS',$system_package);
                                                            if($package_functions->getSectionType('AP_ACTIONS',$system_package)=='1' || $system_package=='N/A') {   ?>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Actions</th>
                                                                <?php } ?>

                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php


                                                            /*echo  $key_query="SELECT  l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`
                                                                            FROM `exp_locations_ap` l INNER JOIN `exp_mno_distributor_aps` d
                                                                            ON d.`ap_code`= l.`ap_code`
                                                                            AND d.`distributor_code`='$view_loc_code' GROUP BY d.`ap_code`";*/
                                                           /* $key_query=  "SELECT l.serial,l.model, l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`,a.`distributor_name`,a.`verification_number`
                                                                            FROM `exp_locations_ap` l INNER JOIN `exp_mno_distributor_aps` d ON d.`ap_code`= l.`ap_code`, `exp_mno_distributor` a
                                                                            WHERE d.`distributor_code`='$view_loc_code' AND a.`distributor_code`=d.`distributor_code` GROUP BY d.`ap_code`"; */

                                                           $key_query = "SELECT l.serial,l.model, l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`,a.`distributor_name`,a.`verification_number`
                                                                        FROM `exp_mno_distributor` a LEFT JOIN `exp_mno_distributor_aps` d  ON a.`distributor_code`=d.`distributor_code` LEFT JOIN `exp_locations_ap` l ON d.`ap_code`= l.`ap_code`
                                                                        WHERE a.parent_id='$view_loc_code' GROUP BY d.`ap_code`,a.verification_number";

                                                                $query_results=mysql_query($key_query);

                                                                while($row=mysql_fetch_array($query_results)){

                                                                    $cpe_id = $row[id];
                                                                    $cpe_name = $row[ap_code];
                                                                    $ip = $row[distributor_name];
                                                                    
                                                                    if(empty($row[verification_number])){
                                                                        $icoms="N/A";
                                                                        }else{
                                                                    $icoms = $row[verification_number];
                                                                    }
                                                                    
                                                                    if(empty( $row[mac_address])){
                                                                        $mac_address="N/A";
                                                                        }else{
                                                                    $mac_address = $row[mac_address];
                                                                    }
                                                                    
                                                                    if(empty($row[create_date])){
                                                                        $created_date="N/A";
                                                                        }else{
                                                                    $created_date = $row[create_date];
                                                                    }
                                                                    
                                                                    if(empty($row[serial])){
                                                                        $serial="N/A";
                                                                        }else{
                                                                    $serial = $row[serial];
                                                                    }
                                                                    
                                                                    if(empty($row[model])){
                                                                        $model="N/A";
                                                                        }else{
                                                                    $model = $row[model];
                                                                    }
                                                                    
                                                                    
                                                                    



                                                                    echo '<tr>
                                                                    <td> '.$view_loc_code.' </td>
                                                                    <td> '.$icoms.' </td>
                                                                    <td> '.$mac_address.' </td>
                                                                    <td> '.$serial.' </td>

                                                                    <td> '.$model.' </td>';
                                                                if($package_functions->getSectionType('AP_ACTIONS',$system_package)=='1' || $system_package=='N/A') {
                                                                    echo '<td>';
                                                                //print_r($action_event=(array)json_decode($package_functions->getOptions('AP_ACTIONS',$system_package)));
                                                                $action_event=(array)json_decode($package_functions->getOptions('AP_ACTIONS',$system_package));

                                                                if(in_array('edit',$action_event) || $system_package=='N/A') {
                                                                    echo '<a href="javascript:void();" id="EDITAP_' . $cpe_id . '"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITAP_' . $cpe_id . '\').easyconfirm({locale: {
                                                            title: \'CPE Edit\',
                                                            text: \'Are you sure,you want to edit this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITAP_' . $cpe_id . '\').click(function() {
                                                            window.location = "?token7=' . $secret . '&t=2&edit_ap_id=' . $cpe_id . '&edit_loc_code=' . $view_loc_code . '&edit_loc_name=' . $view_loc_name . '"

                                                        });

                                                        });

                                                    </script>&nbsp;&nbsp;';
                                                                }
                                                                if(in_array('remove',$action_event)  || $system_package=='N/A') {


                                                                    echo '<a href="javascript:void();" id="REMAP_' . $cpe_id . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#REMAP_' . $cpe_id . '\').easyconfirm({locale: {
                                                            title: \'CPE Remove\',
                                                            text: \'Are you sure,you want to remove this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#REMAP_' . $cpe_id . '\').click(function() {
                                                            window.location = "?token7=' . $secret . '&t=1&view_loc_name=' . $view_loc_name . '&remove_ap_name=' . $cpe_name . '&rem_ap_id=' . $cpe_id . '&view_loc_code=' . $view_loc_code . '"

                                                        });

                                                        });

                                                    </script>';
                                                                }

                                                                    echo '</td>';
                                                                }               echo'</tr>';





                                                                }

                                                            ?>



                                                        </tbody>

                                                    </table>
                                                    </div>
                                                            </div>

                                                    <div class="controls col-lg-5 form-group" style="display:inline-block;padding-top:10px;">
                                                        <a href="?view_loc_name=<?php echo$view_loc_name; ?>&view_loc_code=<?php echo $view_loc_code?>&t=1&action=sync_data_tab1&token8=<?php echo $secret; ?>" class="btn btn-primary" style="align: left;"  data-toggle="tooltip" title="Please click on the Refresh button to reload the AP list if the AP information is not properly loaded."><i class="btn-icon-only icon-refresh" ></i>Refresh</a>
                                                        
                                                       <!-- <a href="location.php" style="text-decoration:none;" class="btn btn-info inline-btn" >Back</a>-->
                                                        
                                                    </div>


                                                <?php
                                                //////////////////////////////////////////////////
                                                }else {//v1
                                                ?>

                                                 <?php

                                                    if(isset($_SESSION['msg_location_update'])){
                                                        echo $_SESSION['msg_location_update'];
                                                        unset($_SESSION['msg_location_update']);

                                                    }

                                                    ?>



                                                <div class="widget widget-table action-table">

                                                    <?php
                                                    $customer_down_key_string = "uni_id_name=Unique Property ID&task=all_distributor_list&mno_id=".$user_distributor;
                                                    $customer_down_key =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string);
                                                    $customer_down_key =  urlencode($customer_down_key);
                                                    ?>
                                                    <a href='ajax/export_customer.php?key=<?php echo $customer_down_key?>' class="btn btn-primary" style="text-decoration:none">
                                                        <i class="btn-icon-only icon-download"></i> Download Business ID List
                                                    </a>
                                                    <br/> <br/>
                                            <div class="widget-header">
                                                <!-- <i class="icon-th-list"></i> -->
                                                <h3>Active</h3>

                                            </div>

                                                <!-- /widget-header -->

                                                <div class="widget-content table_response">
                                                <div style="overflow-x:auto">

                                                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">
                                                                <?php if(array_key_exists('icomms_number',$field_array) || array_key_exists('icomms_number_m',$field_array)){ ?>
                                                                    Business ID
                                                                <?php }elseif(array_key_exists('uui_number',$field_array)){ ?>
                                                                    UUI#
                                                                <?php } ?>
                                                                </th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Account Name</th>
                                                                <!-- th>Account Type</th> -->
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Properties</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Details</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>

                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php



                                                                if($user_type == 'MNO' || $user_type == 'SALES'){

                                                                    $check_column = "d.mno_id";
                                                                }

                                                                else{
                                                                     $check_column = "d.distributor_code";

                                                                }

                                                                /* $key_query="SELECT DISTINCT  d.`gateway_type`,d.id AS dis_id,d.`distributor_code`,d.`distributor_name`,d.`distributor_type` ,d.`state_region` ,d.`mno_id`,d.`country`,u.`verification_number`
                                                                                FROM `exp_mno_country` c ,`exp_mno_distributor` d
                                                                                LEFT JOIN admin_users u ON d.`distributor_code`=u.`user_distributor`
                                                                                WHERE d.mno_id = '$user_distributor'
                                                                                AND u.is_enable <>'2' AND u.access_role='admin' ORDER BY u.`verification_number` ASC";  */

                                                                $key_query = "SELECT p.id ,p.parent_id,count(distributor_code) as properties, u.full_name,p.account_name FROM exp_mno m JOIN mno_distributor_parent p ON m.mno_id = p.mno_id LEFT JOIN exp_mno_distributor d ON p.parent_id = d.parent_id LEFT JOIN admin_users u ON p.parent_id = u.verification_number 
                WHERE m.mno_id='$user_distributor' AND u.is_enable <>'2' GROUP BY p.parent_id";


                                                                $query_results=$db->selectDB($key_query);

                                                                foreach($query_results['data'] AS $row) {
                                                                    /*

                                                                    $distributor_code = $row[distributor_code];
                                                                    $distributor_name = $row[distributor_name];
                                                                    $distributor_type = $row[distributor_type];
                                                                    $country_name = $row[country];
                                                                    $state_region = $row[state_region];
                                                                    $distributor_id_number = $row[dis_id];
                                                                    $gatewtyp= $row[gateway_type];

                                                                    $icomm=$row[verification_number];;
                                                                    $distributor_name_display=str_replace("'","\'",$distributor_name);

                                                                    */

                                                                    $parent_id = $row['parent_id'];
                                                                    $parent_tbl_id = $row['id'];
                                                                    $parent_full_name = $row['full_name'];
                                                                    $parent_ac_name = str_replace("\\",'',$row['account_name']);
                                                                    $parent_properties = $row['properties'];
                                                                    echo '<tr>
                                                                    <td> ' . $parent_id . ' </td>
                                                                    <td> ' . $parent_ac_name . ' </td>';

                                                            //  echo '<td> ' . $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'") . ' </td>';
                                                                echo '<td> ' . $parent_properties . ' </td>';


                                            if($user_type!="MVNE"){
                                                                    echo '<td><a id="VIEWACC_' . $parent_tbl_id . '"  class="btn btn-small btn-primary">

                                                        <i class="btn-icon-only icon-info-sign"></i>&nbsp;View</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                        
                                    

                                                        $(\'#VIEWACC_' . $parent_tbl_id . '\').click(function() {
                                                            window.location = "?token8=' . $secret . '&t=1&view_loc_code=' . $parent_id . '&view_loc_name=' . $parent_full_name . '"

                                                        });

                                                        });

                                                    </script></td>';
                                                                }
                            echo '<td><a href="javascript:void();" id="EDITACC_'.$parent_tbl_id.'"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITACC_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITACC_'.$parent_tbl_id.'\').click(function() {
                                                            window.location = "?token7='.$secret.'&t=12&edit_parent_id='.$parent_id.'"

                                                        });

                                                        });

                                                    </script></td>';








                            echo '<td><a href="javascript:void();" id="REMACC_'.$parent_tbl_id.'"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#REMACC_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                            title: \'Account Remove\',
                                                            text: \'Are you sure you want to remove[ '.$parent_id.' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#REMACC_'.$parent_tbl_id.'\').click(function() {
                                                            window.location = "?token5='.$secret.'&t=1&remove_par_code='.$parent_id.'&remove_par_id='.$parent_tbl_id.'"

                                                        });

                                                        });

                                                    </script></td>';

                                                    echo '</tr>';





                                                                }

                                                            ?>











                                                        </tbody>

                                                    </table>
                                                    </div>
                                                   <?php } //v1 ?>







                                                </div>

                                                <!-- /widget-content -->

                    </div>

                                            <!-- /widget -->
    </div>

            <!-- ******************************************************* -->
                                        <!-- <div class="tab-pane" id="active_mno" -->
        <div <?php if(isset($tab8)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="active_mno">


                                            <div id="response_d1">



                                            </div>
                                            <div class="widget widget-table action-table">

                                                <div class="widget-header">

                                                    <!-- <i class="icon-th-list"></i> -->

                                                    <h3>Active <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></h3>

                                                </div>

                                                <!-- /widget-header -->

                                                <div class="widget-content table_response">
                                                    <div style="overflow-x:auto">

                                                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                                                        <thead>

                                                            <tr>

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></th>

                                                            <!--    <th><?php //echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?> Code</th>

                                                                <th>Full Name</th>

                                                                <th>Email</th> -->

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Controller</th>

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Remove</th>



                                                            </tr>

                                                        </thead>

                                                        <tbody>



                                                            <?php



                                                                $key_query = "SELECT m.mno_description,m.mno_id,u.full_name, u.email , u.verification_number
FROM exp_mno m, admin_users u
WHERE u.user_type = 'MNO' AND u.user_distributor = m.mno_id AND u.`is_enable`=1 AND u.`access_role`='admin'
GROUP BY m.mno_id
ORDER BY mno_description ";

                                                                $query_results=$db->selectDB($key_query);

                                                                foreach($query_results['data'] AS $row){

                                                                    $mno_description = $row[mno_description];
                                                                    $mno_id = $row[mno_id];
                                                                    $full_name = $row[full_name];
                                                                    $email = $row[email];
                                                                    $s= $row[s];
                                                                    $is_enable= $row[is_enable];
                                                                    $icomm_num=$row[verification_number];


                                                                $key_query01 = "SELECT ap_controller
                                                                            FROM exp_mno_ap_controller
                                                                            WHERE mno_id='$mno_id'";

                                                                $query_results01=mysql_query($key_query01);

                                                                $ap_c="";

                                                                while($row1=mysql_fetch_array($query_results01)){

                                                                    $apc=$row1[ap_controller];

                                                                    $ap_c.=$apc.',';


                                                                }



                                                                    echo '<tr>

                                                                    <td> '.$mno_description.' </td>
                                                                    <td> '.trim($ap_c, ",").' </td> ';



                                                                //echo '<td> '.$mno_id.' </td><td> '.$full_name.' </td><td> '.$email.' </td>';


                                                    echo '<td> '.

                                                                        //******************************** Edit ************************************
                                                            '<a href="javascript:void();" id="EDITMNOACC_'.$mno_id.'"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITMNOACC_'.$mno_id.'\').click(function() {
                                                            window.location = "?token10='.$secret.'&t=6&edit_mno_id='.$mno_id.'"

                                                        });

                                                        });

                                                    </script></td>';







                                                $distributor_exi = "SELECT * FROM `exp_mno_distributor` WHERE mno_id = '$mno_id'";

                                                $query_results01=mysql_query($distributor_exi);
                                                $count_records_exi = mysql_num_rows($query_results01);


                                                if($count_records_exi == 0){

                                                 //*********************************** Remove  *****************************************
                                                 echo '<td><a href="javascript:void();" id="REMMNOACC_'.$mno_id.'"  class="btn btn-small btn-danger">

                                                 <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                                        $(document).ready(function() {
                                                                        $(\'#REMMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                                                title: \'Account Remove\',
                                                                                text: \'Are you sure you want to remove[ '.mysql_real_escape_string($mno_description).' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});

                                                                            $(\'#REMMNOACC_'.$mno_id.'\').click(function() {
                                                                                window.location = "?token10='.$secret.'&t=8&remove_mno_id='.$mno_id.'"

                                                     });
                                                    });
                                                   </script>';


                                                }else{

                                                    echo '<td><a class="btn btn-small btn-warning" disabled >&nbsp;<i class="icon icon-lock"></i>Remove</a></center>';
                                                }


                                                                    //****************************************************************************************


                                                                    echo ' </td>';
                                                                    echo '</tr>';



                                                                }

                                                            ?>



                                                        </tbody>
                                                    </table>
                                                </div>
                                                </div>
                                                <!-- /widget-content -->
                                            </div>
                                            <!-- /widget -->
        </div>
<!--***********************************************************************************-->

<!--***************************************** Activate Accounts ******************************************-->


                                        <div <?php if(isset($tab11)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="saved_mno">


                        <p>To send an automatic email invitation to the Operations Manager, click on "Email" link.This email contains the Operations Admin account activation information.</p>
                        <div class="widget widget-table action-table">

                        <div class="widget-header">

                       <!--  <i class="icon-th-list"></i> -->

                        <h3>Saved <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></h3>

                        </div>

                        <!-- /widget-header -->

                        <div class="widget-content table_response">
                            <div style="overflow-x:auto">

                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                        <thead>

                        <tr>

                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></th>



                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">CONTROLLER</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">ADMIN</th>

                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Email</th>

                        
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Remove</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Edit</th>

                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">SEND</th>
                        



                        </tr>

                        </thead>

                        <tbody>



                        <?php



                        $key_query = "SELECT group_concat(DISTINCT c.ap_controller ) AS ap_cont, m.mno_description,m.mno_id,u.full_name, u.email,u.is_enable,'In Active' AS s
                        FROM exp_mno m LEFT JOIN `exp_mno_ap_controller` c ON c.mno_id=m.mno_id, admin_users u
                        WHERE u.user_type = 'MNO' AND u.user_distributor = m.mno_id AND u.`access_role`='admin' AND u.`is_enable`=2
                        GROUP BY m.mno_id
                        ORDER BY mno_description";

                        $query_results=$db->selectDB($key_query);

                        foreach($query_results['data'] AS $row){

                        $mno_description = $row[mno_description];
                        $mno_id = $row[mno_id];
                        $full_name = $row[full_name];
                        $email = $row[email];
                        $s= $row[s];
                        $is_enable= $row[is_enable];
                        $ap_cont= $row[ap_cont];


                        echo '<tr>

                        <td> '.$mno_description.' </td>
                        <td> '.$ap_cont.' </td>

                        <td> '.$full_name.' </td>
                        <td> '.$email.' </td>';

                        echo '<td><a href="javascript:void();" id="REMMNOACC_'.$mno_id.'"  class="btn btn-small btn-primary">

                                                                <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                            $(document).ready(function() {
                                                            $(\'#REMMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                                    title: \'Account Remove\',
                                                                    text: \'Are you sure you want to remove[ '.mysql_real_escape_string($mno_description).' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});

                                                                $(\'#REMMNOACC_'.$mno_id.'\').click(function() {
                                                                    window.location = "?token10='.$secret.'&t=6&remove_mno_id='.$mno_id.'"

                                                                });

                                                                });

                                                            </script></td>
                        '.
                        //*********************************** Remove  *****************************************

                            '<td><a href="javascript:void();" id="EDITMNOACC2_'.$mno_id.'" class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITMNOACC2_'.$mno_id.'\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITMNOACC2_'.$mno_id.'\').click(function() {
                                                            window.location = "?token10='.$secret.'&t=6&edit_mno_id='.$mno_id.'"

                                                        });

                                                        });

                                                    </script></td>'.
                        '<td>
                        <a href="javascript:void();" id="MAIL_'.$mno_id.'"  class="btn btn-danger btn-small">

                                                                <i class="btn-icon-only icon-envelope"></i>&nbsp;Email</a><script type="text/javascript">

                                                            $(document).ready(function() {
                                                            $(\'#MAIL_'.$mno_id.'\').easyconfirm({locale: {
                                                                    title: \'Send Mail\',
                                                                    text: \'Are you sure you want to send mail?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});

                                                                $(\'#MAIL_'.$mno_id.'\').click(function() {
                                                                    window.location = "?t=11&tokenmail='.$secret.'&send_mail_mno_id='.$mno_id.'"

                                                                });

                                                                });

                                                            </script></td>'
                        //****************************************************************************************
                        ;



                        echo '</tr>';



                        }

                        ?>



                        </tbody>
                        </table>
                        </div>
                        </div>
                        <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                        </div>
                                        <?php
                                        ?>

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
            <!-- /container -->
        </div>
        <!-- /main-inner -->
    </div>
    <!-- /main -->