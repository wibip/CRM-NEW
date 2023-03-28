<?php
$qff = "SELECT `service_id`,`service_name` FROM `exp_service_activation_features`  WHERE `service_type`='MNO_FEATURES' AND `service_id`='VTENANT_MODULE'";

$vtenant_feature = $db->select1DB($qff);

$qfn = "SELECT `service_id`,`service_name` FROM `exp_service_activation_features`  WHERE `service_type`='MNO_FEATURES' AND `service_id`='CAMPAIGN_MODULE'";

$campaign_feature = $db->select1DB($qfn);
?>
<div <?php if (isset($tab_create_mno)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="create_mno">

    <div class="" style="display:none;">
        <div class="header_hr"></div>
        <div class="header_f1" style="width: 100%;">
            Historical Sessions
        </div>
        <br class="hide-sm"><br class="hide-sm">
        <div class="header_f2" style="width: 100%;"></div>
    </div>


    <form onkeyup="submit_mno_formfn();" onchange="submit_mno_formfn();" id="mno_form" name="mno_form" class="form-horizontal" method="POST" action="location.php?<?php if ($mno_edit == 1) {
                                                                                                                                                                        echo "t=create_mno&mno_edit=1&mno_edit_id=$edit_mno_id";
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "t=active_mno";
                                                                                                                                                                    } ?>">

        <?php
        echo '<input type="hidden" name="form_secret6" id="form_secret6" value="' . $_SESSION['FORM_SECRET'] . '" />';
        ?>

        <fieldset>

            <div id="response_mno">

            </div>


            <style type="text/css">
                .ms-container {
                    display: inline-block !important;
                }
            </style>
            <div class="control-group">
                <label class="control-label" for="AP_cont">
                    Controller<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <select multiple="multiple" name="AP_cont[]" id="AP_cont" class="span4 form-control">
                        <!--  <option value="">-- Select AP Controller --</option> -->
                        <?php

                        $q1 = "SELECT o.`controller_name`,o.`type` FROM `exp_locations_ap_controller` o
                                                           LEFT JOIN `exp_mno_ap_controller` m ON m.ap_controller = o.`controller_name`
                                                           WHERE m.ap_controller IS NULL
                                                           ORDER BY o.`controller_name`";


                        $query_results = $db->selectDB($q1);
                        foreach ($query_results['data'] as $row) {

                            $dis_code = $row['controller_name'];
                            $dis_type = $row['type'];

                            switch ($dis_type) {
                                case "SW":
                                    $dis_type_name = 'Switch';
                                    break;
                                case "FIREWALL CONTROLLER":
                                    $dis_type_name = 'Firewall';
                                    break;
                                default:
                                    $dis_type_name = $dis_type;
                            }

                            echo "<option value='" . $dis_code . "'>" . $dis_code . " (" . $dis_type_name . ")" . "</option>";
                        }
                        if ($mno_edit == "1") {

                            foreach ($ap_controler_array as &$value) {

                                switch ($value[1]) {
                                    case "SW":
                                        $dis_type_name = 'Switch';
                                        break;
                                    case "FIREWALL CONTROLLER":
                                        $dis_type_name = 'Firewall';
                                        break;
                                    default:
                                        $dis_type_name = $value[1];
                                }

                                echo "<option  selected value='" . $value[0] . "'>" . $value[0] . " (" . $dis_type_name . ")</option>";
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
                <label class="control-label" for="mno_wag_profiles">Assigned
                    WAG's<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">

                    <textarea style="resize: vertical;" class="span4 form-control" rows="5" id="mno_wag_profiles" name="mno_wag_profiles" readonly><?php echo $edit_wag_prof_string; ?></textarea>
                </div>
                <!-- /controls -->
            </div>


            <div class="control-group">
                <label class="control-label" for="mno_account_name"><?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'"); ?>
                    Name<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control form-control" id="mno_account_name" placeholder="Wifi Provider Ltd" name="mno_account_name" type="text" value="<?php echo $get_edit_mno_description; ?>">
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->

            <div class="control-group">
                <label class="control-label" for="mno_user_type">Account
                    Type<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5">
                    <?php if ($mno_edit == 1) { ?> <div class="sele-disable span4"></div> <?php } ?>
                    <select name="mno_user_type" id="mno_user_type" class="span4 form-control form-control" <?php if ($mno_edit == 1) echo "readonly"; ?>>
                        <option value="">Select Type of Account</option>
                        <?php
                        if ($user_group == 'admin' ) {
                            $mno_flow_q = "SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`in (1,4) AND `is_enable`=1";
                            
                            $mno_flow = $db->selectDB($mno_flow_q);

                            foreach ($mno_flow['data'] as $mno_flow_row) {
                                if ($get_edit_mno_user_type == $mno_flow_row['flow_type']) {
                                    $select = "selected";
                                } else {
                                    $select = "";
                                }
                                echo '<option ' . $select . ' value=' . $mno_flow_row['flow_type'] . '>' . $mno_flow_row['flow_name'] . '-' . $mno_flow_row['description'] . '</option>';
                            }
                        }

                        ?>
                    </select>
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->
            <script>
                $(function() {
                    $("#mno_user_type").on('change', function() {
                        var mno_user_type = $("select#mno_user_type").val();
                        if (mno_user_type == 'RESELLER_ADMIN') {
                            $('.mno_op_type').hide();
                            $('.mno_feature').hide();

                        } else {
                            $('.mno_op_type').show();
                            $('.mno_feature').show();
                        }


                    })


                });
            </script>

            <?php
            if ($user_type == 'RESELLER_ADMIN') {
                $mno_operator_check = "SELECT p.product_code,p.`product_name`,c.options
                                                                                                        FROM `admin_product` p LEFT JOIN admin_product_controls c ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                                                                                        WHERE `is_enable` = '1' AND p.`user_type` = 'MNO'  AND p.`level`= 4 ORDER BY p.`product_name` ASC ";
            } else {

                $mno_operator_check = "SELECT p.product_code,p.`product_name`,c.options
                                                                                                        FROM `admin_product` p LEFT JOIN admin_product_controls c ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                                                                                        WHERE `is_enable` = '1' AND p.`user_type` = 'MNO'  AND p.`level`in (1,4) ORDER BY p.`product_name` ASC ";
            }


            $mno_op = $db->selectDB($mno_operator_check);

            if ($mno_op['rowCount'] > 0) {


            ?>

                <div class="control-group mno_op_type">
                    <label class="control-label" for="mno_sys_package">Operations
                        Type<sup>
                            <font color="#FF0000"></font>
                        </sup></label>

                    <div class="controls col-lg-5 form-group">
                        <?php if ($mno_edit == 1) { ?> <div class="sele-disable span4"></div> <?php } ?>
                        <select name="mno_sys_package" id="mno_sys_package" onchange="customProduct(this);" class="span4 form-control form-control" <?php if ($mno_edit == 1) echo "readonly"; ?>>
                            <option value="">Select Type of Operator
                            </option>
                            <?php
                            if ($user_type == 'ADMIN' || $user_type == 'RESELLER_ADMIN') {

                                foreach ($mno_op['data'] as $mno_op_row) {


                                    if ($get_edit_mno_sys_pack == $mno_op_row[product_code]) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }

                                    echo '<option ' . $select . ' value=' . $mno_op_row[product_code] . ' data-vt="' . $mno_op_row[options] . '" >' . $mno_op_row[product_name] . '</option>';
                                }
                            }

                            ?>
                        </select>

                    </div>
                    <!-- /controls -->
                </div>
                <!-- /control-group -->


                <div id="custom_product_fields" <?php if ($mno_edit == 1 && $get_edit_mno_sys_pack == 'DYNAMIC_MNO_001') {
                                                    echo 'style="display:block"';
                                                } else {
                                                    echo 'style="display:none"';
                                                } ?>>
                    <style type="text/css">
                        .reseller_legend {
                            display: block;
                            width: max-content;
                            padding: 0 10px;
                            border-bottom: 0px;
                            font-size: 14px;
                            margin-left: 20px;
                            margin-bottom: 0px;
                            color: #827f7f;
                        }

                        .colorpicker-element .input-group-addon i,
                        .colorpicker-element .add-on i {
                            height: 25px !important;
                            width: 25px !important;
                            margin-top: -2px;
                        }

                        .no_crop {
                            color: transparent;
                            text-indent: -9999px;
                            outline: 0 !important;
                            position: absolute;
                            top: 0px;
                            right: 0px;
                            width: 30px !important;
                        }

                        .no_crop_label {
                            width: 30px;
                            height: 30px;
                            position: absolute;
                            top: 0px;
                            right: 0px;
                            content: ' ';
                            background-image: url(plugins/img_upload/assets/img/cropperIcons.png);
                            background-position: -150px 0px;
                            background-color: rgba(0, 0, 0, 0.35);
                            cursor: pointer;
                        }

                        .no_crop_label:hover {
                            background-color: rgb(0, 0, 0);
                        }

                        .no_crop_parent {
                            text-align: center;
                            height: auto !important;
                            min-height: 150px;
                        }

                        .no_crop_parent img.croppedImg {
                            max-width: 100%;
                        }

                        #logo_upload,
                        #email_upload,
                        #favicon_upload {
                            min-height: 71px;
                            width: 193px;
                            height: 71px;
                            position: relative;
                            border: 2px solid #b9b6b6;
                            border-top-right-radius: 0px;
                            margin-top: 0px;
                            background-image: url("plugins/img_upload/assets/img/uploadcackg.jpg");
                        }
                    </style>


                    <fieldset style="border: 1px solid #e1e1e1;">
                        <!--927-->
                        <legend class="reseller_legend">Reseller Details
                        </legend>
                        <div class="control-group">
                            <label class="control-label" for="mno_short_name">Short Name<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="mno_short_name" maxlength="12" placeholder="Short Name" name="mno_short_name" type="text" value="<?php echo $get_mno_short_name; ?>" autocomplete="off" style="text-transform:lowercase;" onkeypress="return (event.charCode > 96 && event.charCode < 123)">
                                <span id="error_short_name" style="color: #b94a48"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_about_url">About URL<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="mno_about_url" placeholder="http://wifi.com" name="mno_about_url" type="url" value="<?php echo $get_mno_about_url; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_privacy_url">Privacy
                                URL<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="mno_privacy_url" placeholder="http://wifi.com" name="mno_privacy_url" type="url" value="<?php echo $get_mno_privacy_url; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_privacy_url">TOC URL<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="mno_toc_url" placeholder="http://wifi.com" name="mno_toc_url" type="url" value="<?php echo $get_mno_toc_url; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_first_name">Primary
                                Color<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <div id="primary_div" class="input-group colorpicker-component">
                                    <input class="span4 form-control" id="mno_primary_color" name="mno_primary_color" type="text">
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_first_name">Secondary Color<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <div id="secondary_div" class="input-group colorpicker-component">
                                    <input class="span4 form-control" id="mno_secondary_color" name="mno_secondary_color" type="text">
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_privacy_url">Logo
                                image<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <div id="logo_upload" class="no_crop_parent" style="display: block;">

                                    <div class="cropControls cropControlsUpload"></div>

                                    <?php if ($mno_edit == 1 && $get_edit_mno_sys_pack == 'DYNAMIC_MNO_001') { ?>
                                        <img id="logo_img" class="croppedImg" src="<?php echo $upload_img->get_image($get_logo_name, 'logo'); ?>">
                                    <?php } ?>
                                    <label class="no_crop_label">
                                        <span>
                                            <input type="file" id="logo_img1" name="logo_img1" name="img" class="no_crop" onchange="UploadImg(this,'logo_upload','image_logo_name','theme_img_logo');">
                                        </span>
                                    </label>
                                </div>
                                <input type="hidden" name="image_logo_name" id="image_logo_name" value="<?php echo $get_logo_name; ?>" />
                                <input type="hidden" name="image_logo_name_prev" id="image_logo_name_prev" value="<?php echo $get_logo_name; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_privacy_url">Email
                                image<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <div id="email_upload" class="no_crop_parent" style="display: block;">

                                    <div class="cropControls cropControlsUpload"></div>

                                    <?php if ($mno_edit == 1 && $get_edit_mno_sys_pack == 'DYNAMIC_MNO_001') { ?>
                                        <img id="email_img" class="croppedImg" src="<?php echo $upload_img->get_image($get_email_name, 'welcome'); ?>">
                                    <?php } ?>
                                    <label class="no_crop_label">
                                        <span>
                                            <input type="file" id="email_img1" name="email_img1" name="img" class="no_crop" onchange="UploadImg(this,'email_upload','image_email_name','theme_img_logo');">
                                        </span>
                                    </label>
                                </div>
                                <input type="hidden" name="image_email_name" id="image_email_name" value="<?php echo $get_email_name; ?>" />
                                <input type="hidden" name="image_email_name_prev" id="image_email_name_prev" value="<?php echo $get_email_name; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_favicon_url">Favicon<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <div id="favicon_upload" class="no_crop_parent" style="display: block;">

                                    <div class="cropControls cropControlsUpload"></div>

                                    <?php if ($mno_edit == 1 && $get_edit_mno_sys_pack == 'DYNAMIC_MNO_001') { ?>
                                        <img id="favicon_img" class="croppedImg" src="<?php echo $upload_img->get_image($get_favicon_name, 'welcome'); ?>">
                                    <?php } ?>
                                    <label class="no_crop_label">
                                        <span>
                                            <input type="file" id="favicon_img1" name="favicon_img1" name="img" class="no_crop" onchange="UploadImg(this,'favicon_upload','image_favicon_name','favicon_icon');">
                                        </span>
                                    </label>
                                </div>
                                <input type="hidden" name="image_favicon_name" id="image_favicon_name" value="<?php echo $get_favicon_name; ?>" />
                                <input type="hidden" name="image_favicon_name_prev" id="image_favicon_name_prev" value="<?php echo $get_favicon_name; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_support_number">Support
                                Number<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="mno_support_number" maxlength="12" placeholder="xxx-xxx-xxxx" name="mno_support_number" type="text" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" value="<?php echo CommonFunctions::mob_format($get_mno_support_number); ?>" autocomplete="off">


                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#mno_support_number').focus(function() {
                                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                                        });
                                        $('#mno_support_number').keyup(function() {
                                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                                        });

                                        $("#mno_support_number").keydown(function(e) {
                                            var mac = $('#mno_support_number').val();
                                            var len = mac.length + 1;
                                            if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                                                mac1 = mac.replace(/[^0-9]/g, '');
                                            } else {
                                                if (len == 4) {
                                                    $('#mno_support_number').val(function() {
                                                        return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                                    });
                                                } else if (len == 8) {
                                                    $('#mno_support_number').val(function() {
                                                        return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
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
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mno_support_email">Support
                                Email<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="mno_support_email" placeholder="wifi@company.com" name="mno_support_email" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo $get_mno_support_email; ?>" autocomplete="off">
                            </div>
                        </div>

                        <legend class="reseller_legend">AAA Configuration
                        </legend>
                        <hr style="margin: 0px 10px 20px;">
                        <div class="control-group">
                            <label class="control-label" for="aaa_api_type">API
                                Type<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">

                                <select onchange="ale_change();" name="aaa_api_type" id="aaa_api_type" class="span4 form-control form-control">
                                    <option value="">Select Type of ALE</option>
                                    <?php if ($get_aaa_api_type == 'ALE53') {
                                        $select1 = "selected";
                                    } elseif ($get_aaa_api_type == 'ALE_5') {
                                        $select2 = "selected";
                                    } ?>
                                    <option <?php echo $select1; ?> value="ALE53">ALE 5.3</option>
                                    <option <?php echo $select2; ?> value="ALE_5">ALE 5</option>

                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="aaa_api_username">API
                                URL<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="aaa_api_url" placeholder="" name="aaa_api_url" type="text" pattern="" value="<?php echo $get_aaa_api_url; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="aaa_api_username">API
                                Username<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="aaa_api_username" placeholder="" name="aaa_api_username" type="text" pattern="" value="<?php echo $get_aaa_api_username; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="aaa_api_password">API
                                Password<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="aaa_api_password" placeholder="" name="aaa_api_password" type="password" pattern="" value="<?php echo $get_aaa_api_password; ?>" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="control-group ale_automation" style="display: none;">
                            <label class="control-label" for="vm_aaa_api_url">API
                                URL2<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="vm_aaa_api_url" placeholder="" name="vm_aaa_api_url" type="text" pattern="" value="<?php echo $get_vm_aaa_api_url; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group ale_automation" style="display: none;">
                            <label class="control-label" for="vm_aaa_api_username">VM API
                                Username<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="vm_aaa_api_username" placeholder="" name="vm_aaa_api_username" type="text" pattern="" value="<?php echo $get_vm_aaa_api_username; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group ale_automation" style="display: none;">
                            <label class="control-label" for="vm_aaa_api_password_2">VM API
                                Password <sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="vm_aaa_api_password" placeholder="" name="vm_aaa_api_password" type="password" pattern="" value="<?php echo $get_vm_aaa_api_password; ?>" autocomplete="new-password">
                            </div>
                        </div>
<<<<<<< HEAD
<<<<<<< .merge_file_a12520
                        <div class="control-group ale_automation" style="display: none;">
                            <label class="control-label" for="api_acc_org">Auth Security Token</label>
=======
=======
>>>>>>> 047d7f79f58994eeee6f942727f5bfca142db58e
                        <div class="control-group">
                            <label class="control-label"
                                   for="api_acc_org">Auth Security Token</label>
>>>>>>> .merge_file_a04996
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="api_acc_org" placeholder="" name="api_acc_org" type="text" pattern="" value="<?php echo $get_api_acc_org; ?>">
                            </div>
                        </div>
                        <div class="control-group">
<<<<<<< .merge_file_a12520
                            <label class="control-label" for="aaa_tenant">Tenant<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
=======
                            <label class="control-label"
                                   for="api_acc_org">API Root Zone Name</label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control"
                                       id="api_root_zone_name" placeholder=""
                                       name="api_root_zone_name"
                                       type="text" pattern=""
                                       value="<?php echo (strlen($get_api_root_zone_name)>0)?$get_api_root_zone_name:'Default'; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"
                                   for="api_acc_org">API Root Zone Name</label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control"
                                       id="api_root_zone_name" placeholder=""
                                       name="api_root_zone_name"
                                       type="text" pattern=""
                                       value="<?php echo (strlen($get_api_root_zone_name)>0)?$get_api_root_zone_name:'Default'; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="aaa_tenant">Tenant<sup><font
                                        color="#FF0000"></font></sup></label>
>>>>>>> .merge_file_a04996
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="aaa_tenant" placeholder="" name="aaa_tenant" type="text" pattern="" value="<?php echo $get_aaa_tenant; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="aaa_product_owner">Group<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="aaa_product_owner" placeholder="" name="aaa_product_owner" type="text" pattern="" value="<?php echo $get_aaa_product_owner; ?>" autocomplete="off">
                            </div>
                        </div>
                        <script type="text/javascript">
                            function ale_change() {
                                var val = $('#aaa_api_type').val();
                                if (val == 'ALE53') {
                                    $('.ale_automation').show();
                                } else {
                                    $('.ale_automation').hide();
                                }
                            }
                            $(document).ready(function() {
                                ale_change();
                            });
                        </script>

                        <legend class="reseller_legend">DSF Configuration
                        </legend>
                        <hr style="margin: 0px 10px 20px;">
                        <div class="control-group">
                            <label class="control-label" for="dsf_api_url">API
                                URL<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="dsf_api_url" placeholder="" name="dsf_api_url" type="text" pattern="" value="<?php echo $get_dsf_api_url; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="dsf_api_username">API
                                Username<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="dsf_api_username" placeholder="" name="dsf_api_username" type="text" pattern="" value="<?php echo $get_dsf_api_username; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="dsf_api_password">API
                                Password<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="dsf_api_password" placeholder="" name="dsf_api_password" type="password" pattern="" value="<?php echo $get_dsf_api_password; ?>" autocomplete="new-password">
                            </div>
                        </div>
                        <legend class="reseller_legend">Historical Report Configuration
                        </legend>
                        <hr style="margin: 0px 10px 20px;">
                        <div class="control-group">
                            <label class="control-label" for="abuse_api_url">API
                                URL<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="abuse_api_url" placeholder="" name="abuse_api_url" type="text" pattern="" value="<?php echo $get_abuse_api_url; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="abuse_api_username">API
                                Username<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="abuse_api_username" placeholder="" name="abuse_api_username" type="text" pattern="" value="<?php echo $get_abuse_api_username; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="abuse_api_password">API
                                Password<sup>
                                    <font color="#FF0000"></font>
                                </sup></label>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="dsf_api_password" placeholder="" name="abuse_api_password" type="password" pattern="" value="<?php echo $get_abuse_api_password; ?>" autocomplete="new-password">
                            </div>
                        </div>

                        <input type="hidden" name="mno_support_number_prev" id="mno_support_number_prev" value="<?php echo $get_mno_support_number; ?>" />
                        <input type="hidden" name="mno_support_email_prev" id="mno_support_email_prev" value="<?php echo $get_mno_support_email; ?>" />
                        <input type="hidden" value="<?php echo $get_dynamic_product_id; ?>" name="get_dynamic_product_id">
                        <input type="hidden" value="<?php echo $get_mno_short_name; ?>" name="prev_short_name">
                        <input type="hidden" value="<?php echo $get_edit_mno_description; ?>" name="mno_account_name_prev">
                        <input type="hidden" value="<?php echo $get_mno_about_url; ?>" name="prev_about_url">
                        <input type="hidden" value="<?php echo $get_mno_privacy_url; ?>" name="prev_privacy_url">
                        <input type="hidden" value="<?php echo $get_mno_toc_url; ?>" name="prev_toc_url">
                        <input type="hidden" value="<?php echo $get_mno_primary_color; ?>" name="prev_primary_color">
                        <input type="hidden" value="<?php echo $get_mno_secondary_color; ?>" name="prev_secondary_color">
                        <input type="hidden" value="<?php echo $get_image_logo_url; ?>" name="prev_image_logo_url">
                        <input type="hidden" value="<?php echo $get_image_email_url; ?>" name="prev_image_email_url">
                        <input type="hidden" value="<?php echo $get_aaa_api_username; ?>" name="prev_aaa_username">
                        <input type="hidden" value="<?php echo $get_aaa_api_password; ?>" name="prev_aaa_password">
                        <input type="hidden" value="<?php echo $get_aaa_tenant; ?>" name="prev_aaa_tenant">
                        <input type="hidden" value="<?php echo $get_aaa_product_owner; ?>" name="prev_aaa_product_owner">
                        <input type="hidden" value="<?php echo $get_dsf_api_url; ?>" name="prev_dsf_url">
                        <input type="hidden" value="<?php echo $get_dsf_api_username; ?>" name="prev_dsf_username">
                        <input type="hidden" value="<?php echo $get_dsf_api_password; ?>" name="prev_dsf_password">
                        <input type="hidden" value="<?php echo $get_abuse_api_url; ?>" name="prev_abuse_url">
                        <input type="hidden" value="<?php echo $get_abuse_api_username; ?>" name="prev_abuse_username">
                        <input type="hidden" value="<?php echo $get_abuse_api_password; ?>" name="prev_abuse_password">


                    </fieldset>

                    <br>
                </div>


            <?php

            } else {
                echo '<input type="hidden" name="mno_sys_package" id="mno_sys_package" value="' . $mno_op['data'][0][product_code] . '" />';
            }

            ?>

            <div class="control-group mno_feature" style="">
                <label class="control-label" for="feature_cont">Features<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group" readonly>
                    <select onchange="add_module(this)" multiple="multiple" name="feature_cont[]" id="feature_cont" class="span4 form-control">
                        <!--  <option value="">-- Select AP Controller --</option> -->
                        <?php

                        $qf = "SELECT `service_id`,`service_name` FROM `exp_service_activation_features`  WHERE `service_type`='MNO_FEATURES'
                                                                                   ORDER BY `service_id`";


                        $query_resultsf = $db->selectDB($qf);
                        foreach ($query_resultsf['data'] as $row) {

                            $feature_code = $row[service_id];
                            $feature_name = $row[service_name];

                            if (condition) {
                                # code...
                            }
                            if ($mno_edit == "1") {
                                if (in_array($feature_code, $features_controler_array)) {
                                    echo "<option selected value='" . $feature_code . "'>" . $feature_name . "</option>";
                                } elseif ($feature_code != 'VTENANT_MODULE') {
                                    echo "<option value='" . $feature_code . "'>" . $feature_name . "</option>";
                                }
                            } else {
                                if ($feature_code != 'VTENANT_MODULE') {
                                    echo "<option value='" . $feature_code . "'>" . $feature_name . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->
            <script type="text/javascript">
                function add_module(sel) {
                    /*
                                        
                                        console.log(sel.value);
                                        select_feature = $('#feature_cont').val();
                                        if (select_feature!='') {
                                        if(select_feature.indexOf("VTENANT_MODULE") >= 0){
                                            $('#vt-groups').show();

                                        }
                                    }
                                    */
                }
            </script>


            <div class="control-group" style="display: none" id="vt-groups">
                <label class="control-label" for="vt-group">Vtenant Group
                    <sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <select multiple="multiple" name="vt_group[]" id="vt_group" class="span4 form-control">
                        <!--  <option value="">-- Select AP Controller --</option> -->
                        <?php
                        $all_vt_groups = $vtenant_model->getUnusedAdminVtenants();
                        foreach ($all_vt_groups as $vt_group) {

                            $vt_code = $vt_group->getRealm();
                            $vt_type = $vt_group->getType() == 'VTENANT' ? 'VT' : 'MDU';

                            echo "<option value='" . $vt_code . "'>" . $vt_code . "(" . $vt_type . ")" . "</option>";
                        }
                        if ($mno_edit == "1") {

                            foreach ($vtenant_model->getMNOVtenants($edit_mno_id) as $value) {
                                $is_dis = 0;
                                $q01 = "SELECT `id` FROM `mdu_distributor_organizations` WHERE `property_id` = '" . $value->getRealm() . "';";
                                $res = $db->selectDB($q01);
                                if ($res['rowCount'] > 0) {
                                    $is_dis = 1;
                                }

                                $type = $value->getType() == "VTENANT" ? "VT" : "MDU";
                                //echo '<option  selected value="' . $value->getRealm() . '">' . $value->getRealm() . '(' . $type . ')</option>';
                        ?>

                                <?php if ($is_dis == 1) {
                                    //echo "<div class='span2' style='position: absolute;height: 25px;'></div>";  
                                } ?>
                                <option selected style="<?php if ($is_dis == 1) {
                                                            echo 'pointer-events: none';
                                                        } ?>" value="<?php echo $value->getRealm(); ?>"><?php echo $value->getRealm() . '(' . $type . ')'; ?></option>

                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- /controls -->
            </div>

            <?php if ($package_functions->getSectionType('OPERATOR_CODE', $system_package) == 'YES') { ?>
                <div class="control-group">
                    <label class="control-label" for="mno_api_prifix">Operator
                        Code<sup>
                            <font color="#FF0000"></font>
                        </sup></label>
                    <div class="controls col-lg-5 form-group">
                        <input type="text" class="span4 form-control" id="mno_api_prifix" name="mno_api_prifix" autocomplete="off" placeholder="Ex-: OPT" value="<?php echo $get_edit_mno_api_prefix; ?>">

                    </div>
                </div><?php } ?>

            <div class="control-group" style="display: none" id="ale-zones">
                <label class="control-label" for="mno_operator_zone">ALE Operator Zone<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_operator_zone" placeholder="Ex-: [ALE Operator Zone]" name="mno_operator_zone" type="text" value="<?php echo $get_edit_mno_operator_zone; ?>" autocomplete="off">
                </div>
            </div>

            <div class="control-group" style="display: none" id="ale-groups">
                <label class="control-label" for="mno_operator_group">ALE Operator Group<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_operator_group" placeholder="Ex-: [ALE Root Zone]...[ALE Operator Zone]" name="mno_operator_group" type="text" value="<?php echo $get_edit_mno_operator_group; ?>" autocomplete="off">
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" for="mno_first_name">Admin
                    First Name<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_first_name" maxlength="12" placeholder="First Name" name="mno_first_name" type="text" value="<?php echo $get_edit_mno_first_name; ?>" autocomplete="off">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="mno_last_name">Admin Last
                    Name<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_last_name" maxlength="12" placeholder="Last Name" name="mno_last_name" type="text" value="<?php echo $get_edit_mno_last_name; ?>" autocomplete="off">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="mno_email">Admin
                    Email<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com" value="<?php echo $get_edit_mno_email; ?>" autocomplete="off">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="mno_address_1">Address<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo $get_edit_mno_ad1; ?>" autocomplete="off">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="mno_address_2">City<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo $get_edit_mno_ad2; ?>" autocomplete="off">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="mno_country">Country<font color="#FF0000"></font></sup></label>

                <div class="controls col-lg-5 form-group">

                    <select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off">
                        <option value="">Select Country</option>
                        <?php
                        $count_results = $db->selectDB("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                                    UNION ALL
                                    SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");

                        foreach ($count_results['data'] as $row) {
                            if ($row[a] == $get_edit_mno_country || $row[a] == "US") {
                                $select = "selected";
                            } else {
                                $select = "";
                            }

                            echo '<option value="' . $row[a] . '" ' . $select . '>' . $row[b] . '</option>';
                        }
                        ?>


                    </select>

                </div>
            </div>
            <!-- /controls -->

            <script type="text/javascript">
                // Countries
                var country_arr = new Array("United States of America", "Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

                // States
                var s_a = new Array();
                var s_a_val = new Array();
                s_a[0] = "";
                s_a_val[0] = "";
                <?php

                $get_regions = $db->selectDB("SELECT
                                                                                      `states_code`,
                                                                                      `description`
                                                                                    FROM 
                                                                                    `exp_country_states` ORDER BY description");

                $s_a = '';
                $s_a_val = '';


                foreach ($get_regions['data'] as $state) {
                    $s_a .= $state['description'] . '|';
                    $s_a_val .= $state['states_code'] . '|';
                }

                $s_a = rtrim($s_a, "|");
                $s_a_val = rtrim($s_a_val, "|");

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

                    if (selectedCountryIndex != 0) {
                        for (var i = 0; i < state_arr.length; i++) {
                            stateElement.options[stateElement.length] = new Option(state_arr[i], state_arr_val[i]);
                        }
                    }

                }

                function populateCountries(countryElementId, stateElementId) {

                    var countryElement = document.getElementById(countryElementId);

                    if (stateElementId) {
                        countryElement.onchange = function() {
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
                <label class="control-label" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
                <div class="controls col-lg-5 form-group">
                    <!--   <input class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" type="text" value="<?php //echo $get_edit_mno_state_region
                                                                                                                                                ?>">  -->


                    <select <?php if ($field_array['region'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
                        <?php

                        $get_regions = $db->selectDB("SELECT
                                                                                      `states_code`,
                                                                                      `description`
                                                                                    FROM
                                                                                    `exp_country_states` ORDER BY description ASC");

                        echo '<option value="">Select State</option>';


                        foreach ($get_regions['data'] as $state) {
                            //edit_state_region , get_edit_mno_state_region
                            if ($get_edit_mno_state_region == $state['states_code']) {

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


            <div class="control-group">
                <label class="control-label" for="mno_region">ZIP
                    Code<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip ?>" autocomplete="off">
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {


                    $("#mno_zip_code").keydown(function(e) {


                        var mac = $('#mno_zip_code').val();
                        var len = mac.length + 1;
                        //console.log(e.keyCode);
                        //console.log('len '+ len);


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
                    });


                });
            </script>


            <?php


            ?>

            <div class="control-group">
                <label class="control-label" for="mno_mobile">Phone Number 1<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" value="<?php echo CommonFunctions::mob_format($get_edit_mno_mobile); ?>" autocomplete="off">
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {

                    $('#mno_mobile_1').focus(function() {
                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                    });

                    $('#mno_mobile_1').keyup(function() {
                        var phone_1 = $(this).val().replace(/[^\d]/g, "");
                        if (phone_1.length > 9) {
                            $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                        } else {
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                        }
                        $('#mno_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');
                    });
                    //$('#mno_mobile_1').val($('#mno_mobile_1').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));

                    $("#mno_mobile_1").keydown(function(e) {


                        var mac = $('#mno_mobile_1').val();
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
                                $('#mno_mobile_1').val(function() {
                                    return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                    //console.log('mac1 ' + mac);

                                });
                            } else if (len == 8) {
                                $('#mno_mobile_1').val(function() {
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
                    });


                });
            </script>


            <div class="control-group">
                <label class="control-label" for="mno_mobile">Phone Number 2<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">

                    <input class="span4 form-control" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" value="<?php echo CommonFunctions::mob_format($get_edit_mno_phone2); ?>" autocomplete="off">


                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {

                    $('#mno_mobile_2').focus(function() {
                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                    });

                    $('#mno_mobile_2').keyup(function() {
                        var phone_1 = $(this).val().replace(/[^\d]/g, "");
                        if (phone_1.length > 9) {
                            $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                        } else {
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                        }
                        $('#mno_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');
                    });

                    //$('#mno_mobile_2').val($('#mno_mobile_1').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));

                    $("#mno_mobile_2").keydown(function(e) {


                        var mac = $('#mno_mobile_2').val();
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
                                $('#mno_mobile_2').val(function() {
                                    return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                    //console.log('mac1 ' + mac);

                                });
                            } else if (len == 8) {
                                $('#mno_mobile_2').val(function() {
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
                    });


                });
            </script>


            <div class="control-group">
                <label class="control-label" for="mno_mobile">Phone Number 3<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" value="<?php echo CommonFunctions::mob_format($get_edit_mno_phone3); ?>" autocomplete="off">
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {

                    $('#mno_mobile_3').focus(function() {
                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                    });

                    $('#mno_mobile_3').keyup(function() {
                        var phone_1 = $(this).val().replace(/[^\d]/g, "");
                        if (phone_1.length > 9) {
                            $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                        } else {
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                        }
                        $('#mno_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                    });

                    $('#mno_mobile_3').val($('#mno_mobile_1').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));


                    $("#mno_mobile_3").keydown(function(e) {


                        var mac = $('#mno_mobile_3').val();
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
                                $('#mno_mobile_3').val(function() {
                                    return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                    //console.log('mac1 ' + mac);

                                });
                            } else if (len == 8) {
                                $('#mno_mobile_3').val(function() {
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
                    });


                });
            </script>

            <div class="control-group">
                <label class="control-label" for="mno_timezone">Time
                    Zone<sup>
                        <font color="#FF0000"></font>
                    </sup></label>
                <div class="controls col-lg-5 form-group">
                    <select class="span4 form-control" id="mno_time_zone" name="mno_time_zone" autocomplete="off">
                        <option value="">Select Time Zone</option>
                        <?php


                        $utc = new DateTimeZone('UTC');
                        $dt = new DateTime('now', $utc);
                        foreach ($priority_zone_array as $tz) {
                            $current_tz = new DateTimeZone($tz);
                            $offset = $current_tz->getOffset($dt);
                            $transition = $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                            $abbr = $transition[0]['abbr'];
                            if ($get_edit_mno_timezones == $tz) {
                                $select = "selected";
                            } else {
                                $select = "";
                            }
                            echo '<option ' . $select . ' value="' . $tz . '">' . $tz . ' [' . $abbr . ' ' . CommonFunctions::formatOffset($offset) . ']</option>';
                        }


                        foreach (DateTimeZone::listIdentifiers() as $tz) {

                            //Skip
                            if (in_array($tz, $priority_zone_array))
                                continue;

                            $current_tz = new DateTimeZone($tz);
                            $offset = $current_tz->getOffset($dt);
                            $transition = $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                            $abbr = $transition[0]['abbr'];
                            /*if($abbr=="EST" || $abbr=="CT" || $abbr=="MT" || $abbr=="PST" || $abbr=="AKST" || $abbr=="HST" || $abbr=="EDT"){
                                                        echo $get_edit_mno_timezones;*/
                            if ($get_edit_mno_timezones == $tz) {
                                $select = "selected";
                            } else {
                                $select = "";
                            }
                            echo '<option ' . $select . ' value="' . $tz . '">' . $tz . ' [' . $abbr . ' ' . CommonFunctions::formatOffset($offset) . ']</option>';
                            // $select="";
                            /*}*/
                        }

                        ?>
                    </select>
                </div>
            </div>


            <div class="form-actions">

                <button disabled type="submit" id="submit_mno_form" name="submit_mno_form" class="btn btn-primary"><?php if ($mno_edit == 1) {
                                                                                                                        echo "Update Account";
                                                                                                                    } else {
                                                                                                                        echo "Create Account";
                                                                                                                    } ?></button>
                <?php if ($mno_edit == 1) { ?>
                    <button type="button" class="btn btn-info inline-btn" onclick="goto();" class="btn btn-danger">Cancel
                    </button> <?php } ?>

            </div>
            <script>
                function submit_mno_formfn() {
                    //alert("fn");
                    $("#submit_mno_form").prop('disabled', false);
                }

                function goto(url) {
                    window.location = "?";
                }
            </script>


            <!-- /form-actions -->

        </fieldset>

    </form>


    <!-- /widget -->
    <script>
        $(function() {

            function enableVTGroups() {
                var select_group_vt_val = $('#mno_sys_package').find(':selected').data('vt');
                //var add_mno_form_validator = $('#mno_form').data('bootstrapValidator');
                var feature_code = '<?php echo $vtenant_feature['service_id']; ?>';
                var feature_name = '<?php echo $vtenant_feature['service_name']; ?>';
                var camp_feature_code = '<?php echo $campaign_feature['service_id']; ?>';
                var camp_feature_name = '<?php echo $campaign_feature['service_name']; ?>';
                if (select_group_vt_val == 'Vtenant') {
                    $('#vt-groups').show();
                    //$('#ale-groups').hide();
                    //$('#ale-zones').hide();
                    $("#feature_cont option[value='VTENANT_MODULE']").remove();
                    $("#feature_cont option[value='CAMPAIGN_MODULE']").remove();
                    //add_mno_form_validator.enableFieldValidators('vt_group[]', true);
                } else if (select_group_vt_val == 'Vtenant_ALE53') {
                    $('#vt-groups').show();
                    //$('#ale-groups').show();
                    //$('#ale-zones').show();
                    $("#feature_cont option[value='VTENANT_MODULE']").remove();
                    $("#feature_cont option[value='CAMPAIGN_MODULE']").remove();
                    //add_mno_form_validator.enableFieldValidators('vt_group[]', true);
                } else if (select_group_vt_val == 'ALE53') {
                    $('#vt-groups').hide();
                    //$('#ale-groups').show();
                    //$('#ale-zones').show();
                    $("#feature_cont option[value='VTENANT_MODULE']").remove();
                    $("#feature_cont option[value='CAMPAIGN_MODULE']").remove();
                    //add_mno_form_validator.enableFieldValidators('vt_group[]', true);
                } else if (select_group_vt_val == 'Vtenant_Dynamic') {
                    //$('#ale-groups').hide();
                    //$('#ale-zones').hide();

                    <?php if ($mno_edit == 1) {
                    ?>
                        if ($("#feature_cont option[value='VTENANT_MODULE']").length == 0) {
                            $('#vt-groups').hide();
                            $("#feature_cont").append('<option value="' + feature_code + '">' + feature_name + '</option>');
                        } else {
                            $('#vt-groups').show();
                            //$("#feature_cont").append('<option selected value="'+feature_code+'">'+feature_name+'</option>');
                        }
                    <?php
                    } else { ?>
                        $('#vt-groups').hide();
                        //$('#ale-groups').hide();
                        //$('#ale-zones').hide();
                        $("#feature_cont").append('<option value="' + camp_feature_code + '">' + camp_feature_name + '</option>');
                        $("#feature_cont").append('<option value="' + feature_code + '">' + feature_name + '</option>');
                    <?php
                    } ?>



                    //$("#feature_cont").multiSelect("refresh");
                } else {
                    $('#vt-groups').hide();
                    $("#feature_cont option[value='VTENANT_MODULE']").remove();
                    $("#feature_cont option[value='CAMPAIGN_MODULE']").remove();
                    //add_mno_form_validator.enableFieldValidators('vt_group[]', false);
                    $('#vt_group').multiSelect('deselect_all');
                }
            }

            $('#mno_sys_package').change(function() {
                enableVTGroups();
                $("#feature_cont").multiSelect("refresh");
            });
            <?php if ($mno_edit == 1) {
            ?>enableVTGroups();
        <?php
            } ?>



        });
        $(document).ready(function() {
            <?php if ($mno_edit != 1) {  ?>
                $("#feature_cont option[value='CAMPAIGN_MODULE']").remove();
            <?php }  ?>


        });
    </script>

</div>