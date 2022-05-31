<div <?php if (isset($tab_createTheme)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="createTheme">
    <?php
    if (isset($_SESSION['msg1'])) {

        echo $_SESSION['msg1'];

        unset($_SESSION['msg1']);
    }
    $secretn = md5(uniqid(rand(), true));
    $_SESSION['FORM_SECRET_createTheme'] = $secretn;

    ?>
    <h1 class="head">
First impressions last,
make yours a splash page. <img data-toggle="tooltip" title="Guests will automatically be redirected to your customizable webpage upon connection to your Guest WiFi network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>
    <div class="widget widget-table action-table">
        <form enctype="multipart/form-data" id="theme_create_form" class="form-horizontal" method="POST"  action="<?php echo $script; ?>">
            <div class="control-group">
                <div class="controls">
                    <label class="" for="radiobtns"><?php echo ucwords(__THEME_TEXT__); ?> Name
                    <img data-toggle="tooltip" title="Customize your Guest WiFi splash page by giving it a name, selecting your location where the theme should show, setting the redirect URL where the visitors will land after registration, choosing a template and selecting a registration type." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;">
                    </label>
                    <input type="text" class="span5" id="theme_name" name="theme_name" value="<?php echo $edit_theme_name ?>">
                    <small class="help-block" style="display: none;" id="theme_name_validate"><p>This is a required field</p></small>
                    <div style="display:none;" class="help-block error-wrapper bubble-pointer mbubble-pointer" id="shedule_name_dup"><p><?php echo ucwords(__THEME_TEXT__); ?>name already exists</p></div>
                </div>
            </div>


            <?php if($modify_mode != 1){ ?>

                <script type="text/javascript">

                $('#theme_name').on('keyup', function(event) {

                    if($('#theme_name').val().length < 1){
                        $('#theme_name_validate').show();
                    }else{
                        $('#theme_name_validate').hide();
                    }

                    var tname = document.getElementById("theme_name").value;
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
            <!--  <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Select Location/Property
                                                        </label>
                                                        <div class="controls">
                                                            <select id="location_ssid" class="span5" name="location_ssid" required="required">
                                                                <option value=''> Location </option>
                                                                <?php
                                                                /*  $query_results = mysql_query("SELECT DISTINCT tag_name FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor' ORDER BY tag_name ASC");
                                                                while ($row1 = mysql_fetch_array($query_results)) {
                                                                    $tag_name = $row1[tag_name];
                                                                    if ($edit_location_ssid == $tag_name) {
                                                                        $sele = "selected";
                                                                    } else {
                                                                        $sele = "";
                                                                    }
                                                                    echo '<option ' . $sele . ' value="' . $tag_name . '">' . $tag_name . '</option>';
                                                                } */
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div> -->
            <?php
            echo '<input type="hidden" name="form_secret_createTheme" id="form_secret_createTheme" value="' . $_SESSION['FORM_SECRET_createTheme'] . '" />';
            echo '<input type="hidden" name="location_ssid" id="location_ssid" value="' . $db->getValueAsf("SELECT verification_number as f FROM `admin_users` WHERE `user_distributor` = '$user_distributor' ") . '" />';

            ?>
            <div class="control-group">

                <div class="controls">
                <label class="" for="radiobtns">Browser Heading
                    <img data-toggle="tooltip" title="Set the text you want your user to see in the splash page browser window." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;">
                    </label>
                    <input type="text" id="title_t" class="span5" name="title_t" value="<?php echo $edit_title_t; ?>">
                    <small class="help-block" style="display: none;" id="title_t_validate"><p>This is a required field</p></small>                                            
                </div>

                <!-- /controls -->

            </div>
            <input type="hidden" name="theme_modify" value="<?php echo $_GET['modify']; ?>">
            <!-- /control-group -->

            <div class="control-group">

                <div class="controls">

                <label class="" for="radiobtns">Redirection
                    <img data-toggle="tooltip" title="Set the redirection URL  where the visitor will land after finalizing the registration. The Custom URL is the URL of your choice. The Default Website is the URL of your service provider. The Thank You Page is a static local system page." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;">
                    </label>
                    <select onchange="retype1();" class="span5" id="redirect_type" name="redirect_type">

                        <option value="">Select Redirect Type</option>
                        <option <?php if ($edit_reditct_typ == 'default') {
                                    echo 'selected';
                                } ?> value="default">Default Website</option>
                        <option <?php if ($edit_reditct_typ == 'thankyou') {
                                    echo 'selected';
                                } ?> value="thankyou">Thank You Page</option>
                        <option <?php if ($edit_reditct_typ == 'custom') {
                                    echo 'selected';
                                } ?> value="custom">Custom URL</option>

                    </select>
                    <small class="help-block" style="display: none;" id="redirect_type_validate"><p>This is a required field</p></small>
                </div>


            </div>

            <div class="control-group" id="reurl">

                <div class="controls">
                    <select class="span2" name="urlsecure" id="urlsecure">
                        <option <?php if ($secspalsh_t == 'http://') {
                                    echo 'selected';
                                } ?> value="http://">http://</option>
                        <option <?php if ($secspalsh_t == 'https://') {
                                    echo 'selected';
                                } ?> value="https://">https://</option>
                    </select>
                    <input type="text" class="span3" id="splash_url" name="splash_url" placeholder="<?php
                                                                                                    echo $package_functions->getOptions('splash_page_url', $system_package); ?>" value="<?php echo $pathspalsh_t; ?>">
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->

            <div class="control-group">

                <div class="controls">
                <label class="" for="radiobtns">Template
                    <img data-toggle="tooltip" title="[Coming soon] Select from a list of predefined templates to modify to fit your location." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;">
                    </label>
                    <select class="span5" id="template_name" name="template_name" required="required" >

                        <?php
                        $gt_template_optioncode = $package_functions->getOptions('TEMPLATE_ACTIVE', $system_package, 'MVNO');
                        $pieces1 = explode(",", $gt_template_optioncode);
                        $len1 = count($pieces1);
                        $outstr1 = "";
                        for ($i = 0; $i < $len1; $i++) {
                            if ($i == ($len1 - 1)) {
                                $outstr1 = $outstr1 . "'" . $pieces1[$i] . "'";
                            } else {
                                $outstr1 = $outstr1 . "'" . $pieces1[$i] . "',";
                            }
                        }

                        $key_query_t_name = "SELECT template_id, `name`,`archive`  FROM exp_template WHERE `is_enable` ='1'
                                                                        AND template_id IN ($outstr1)";

                        $query_results1 = $db->selectDB($key_query_t_name);
                        
                        foreach ($query_results1['data'] AS $row) {
                            $temp_id = $row[template_id];
                            $temp_name = $row[name];
                            $template_achive = $row[archive];
                            if ($edit_template_name1 == $temp_id) {
                                $sele = "selected";
                            } else {
                                $sele = "";
                            }
                            if (!$template_achive) {
                               echo '<option ' . $sele . ' id="' . $temp_name . '" value="' . $temp_id . '">' . $temp_name . '</option>';
                            }
                            
                        }
                        ?>


                    </select>
                    <?php echo '<input type="hidden" name="edit_template_name1" value="' . $edit_template_name1 . '">' ?>
                </div>

            </div>

            <div class="control-group">
                <div class="controls">
                <label class="" for="radiobtns">Registration Type
                    <img data-toggle="tooltip" title=" Select the type of registration you would require your visitors to complete to gain access to the Internet." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;">
                    </label>
                    <select id="reg_type" class="span5" name="reg_type" required="required">
                        <?php
                        $gt_reg_optioncode = $package_functions->getOptions('THEME_REG_TYPE', $system_package, 'MVNO');
                        $pieces = explode(",", $gt_reg_optioncode);
                        $len = count($pieces);
                        $outstr = "";

                        for ($i = 0; $i < $len; $i++) {
                            if ($i == ($len - 1)) {
                                $outstr = $outstr . "'" . $pieces[$i] . "'";
                            } else {
                                $outstr = $outstr . "'" . $pieces[$i] . "',";
                            }
                        }
                        $key_query = "SELECT theme_code, theme_name FROM exp_theme_manager WHERE theme_type = 'NEW' AND is_enable='1' AND theme_code IN ($outstr)";
                        $query_results = $db->selectDB($key_query);

                        
                        foreach ($query_results['data'] AS $row) {

                            $theme_code = $row[theme_code];
                            $theme_name = $row[theme_name];
                            if ($edit_registration_type == $theme_code) {
                                $sele = "selected";
                            } else {
                                $sele = "";
                            }
                            echo '<option ' . $sele . ' id="' . $theme_name . '" value="' . $theme_code . '">' . $theme_name . '</option>';
                        }
                        ?>
                    </select>
                    <?php echo '<input type="hidden" name="edit_registration_type" value="' . $edit_registration_type . '">' ?>
<p style="font-size: 90%;"><b>Note: If Passcode Authentication is selected, please validate your current passcode generation method or change it as desired. It is currently set to the following: <small class="a" style="color: #f91f1f !important;"><?php echo $pass_type.' - '.$voucher_number; ?></small></b>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="radiobtns"></label>
                <div class="controls">
                    <input type="hidden" name="enc" id="enc" value="<?php echo $edit_enc; ?>">
                    <input type="hidden" name="old_enc" id="old_enc" value="<?php echo $old_enc; ?>">
                    <input type="hidden" name="theme_id" id="theme_id" value="<?php echo $theme_id; ?>">
                    <!-- <a class="fancybox fancybox.iframe" id="appLink" allowfullscreen allow="autoplay; fullscreen" href="">Change Appearance</a> -->
                    <a id="appLink" href="" style="font-weight: 600">Customize this template <i style="display: inline-block !important;font-size: 13px;" class="icon-chevron-right"></i></a>
                </div>
            </div>
            <div class="control-group" style="<?php if($other_multi_area==1){ echo 'display: none'; } ?>">
                <div class="controls">
                    <label class="" for="radiobtns">Active</label>
                <?php
                $checked = '';
                if($other_multi_area==1){
                    $checked = 'checked';
                 }else{
                    if ($edit_is_active == 1) { 
                        $checked = 'checked';
                    }
                    if (!isset($edit_is_active)) {
                        $checked = 'checked';
                    }
                 } 
                 ?>
                    <!-- <input id="is_active" name="is_active" type="checkbox" <?php //if ($edit_is_active == 1) { 
                                                                                ?> checked <?php //} 
                                                                                            ?> data-toggle="tooltip" title="CHECKING THE BOX will activate this <?php //echo __THEME_TEXT__; 
                                                                                                                                                                ?> and make it visible to all your guests immediately. Or you can leave the box unchecked and enable the <?php //echo __THEME_TEXT__; 
                                                                                                                                                                                                                                                                            ?> later from within the Manage section."> -->
                    <input id="is_active" name="is_active" type="checkbox" <?php echo $checked; ?>>
                    <label for="is_active"></label>
                    <p><b>Check this box to make this the active theme.</b></p>
                </div>
            </div>
            <div class="form-actions">
                
                <?php if($modify_mode == 1){ ?>
                    <button type="submit" name="<?php echo $theme_submit; ?>" id="<?php echo $theme_submit; ?>" class="btn btn-primary">Update</button>&nbsp; <button type="button" name="theme_update_cancel" id="theme_update_cancel" class="btn btn-warning"  >Cancel</button>
                <?php }else{ ?>
                    <button type="submit" name="<?php echo $theme_submit; ?>" id="<?php echo $theme_submit; ?>" class="btn btn-primary">Save</button>
                    
                <?php } ?>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">

$('#title_t').on('keyup', function(event) {
    if($('#title_t').val().length < 1){
        $('#title_t_validate').show();
    }else{
        $('#title_t_validate').hide();
    }
});

    function themeValidate(){
        var valid = true;
        if($('#theme_name').val().length < 1){
            $('#theme_name').focus();
            $('#theme_name_validate').show();
            valid = false;
        }
        if($('#title_t').val().length < 1){
            if(valid){
                $('#title_t').focus();
            }
            $('#title_t_validate').show();
            valid = false;
        }
        if($('#redirect_type').val().length < 1){
            if(valid){
                $('#redirect_type').focus();
            }
            $('#redirect_type_validate').show();
            valid = false;
        }
        return valid;
    }

    $(document).on('submit','#theme_create_form',function (e) {
        if(!themeValidate()){
            return false;
        }
    });

    $("#splash_urlno").keydown(function(e) {
        var oldvalue = $(this).val();
        var field = this;
        setTimeout(function() {
            if (field.value.indexOf('http://') !== 0 && field.value.indexOf('https://') !== 0) {
                $(field).val(oldvalue);
            }
        }, 1);
    });

    function urlck() {

        setTimeout(function() {
            var str = $('#splash_url').val();
            var pieces = str.split("://");
            if (pieces[pieces.length - 2] == null) {
                document.getElementById("splash_url").value = pieces[pieces.length - 1];
            } else {
                document.getElementById("splash_url").value = pieces[pieces.length - 2] + '://' + pieces[pieces.length - 1];
            }
        }, 100);

    }
    $(document).ready(function() {

        $("#reg_type, #template_name").change(function() {
            setHref(1);
        });

        $("#theme_update_s").easyconfirm({
            locale: {

                title: '<?php echo ucwords(__THEME_TEXT__); ?> Update',

                text: 'Are you sure you want to update this <?php echo __THEME_TEXT__; ?>?',

                button: ['Cancel', ' Confirm'],

                closeText: 'close'

            }
        });
        $("#theme_update_s").click(function() { });

        $("#theme_submit_s").easyconfirm({
            locale: {
                title: '<?php echo ucwords(__THEME_TEXT__); ?> Creation',
                text: 'Are you sure you want to create this <?php echo __THEME_TEXT__; ?>?',
                button: ['Cancel', ' Confirm'],
                closeText: 'close'
            }
        });

        $("#theme_submit_s").click(function() { });

        $("#theme_update_cancel").easyconfirm({locale: {

            title: '<?php echo ucwords(__THEME_TEXT__); ?> Update Cancel',

            text: 'Are you sure you want to cancel this <?php echo __THEME_TEXT__ ; ?> update?',

            button: ['No',' Yes'],

            closeText: 'close'

         }});

    $("#theme_update_cancel").click(function() {

    //relaod current page//

    window.location.href = "theme.php?t=createTheme";

    });

        // $(".fancybox").fancybox({
        //     'transitionIn': 'elastic',
        //     'transitionOut': 'elastic',
        //     'speedIn': 600,
        //     'speedOut': 200,
        //     'overlayShow': false,
        //     'fullScreen': {
        //         autoStart: true
        //     },
        //     afterShow: function() {
        //         var customContent = "<button id='fancy_close' style='margin-top: 30px; display: none'></button>";
        //         $('.fancybox-skin').append(customContent);
        //         $('#fancy_close').click(function(event) {
        //             $.fancybox.close();

        //         });
        //     }
        // });

        retype_ready();
        setHref(0);
    });

    function retype1() {
        var type = $("#redirect_type").val();
        if(type < 1){
            $('#redirect_type_validate').show();
        }else{
            $('#redirect_type_validate').hide();
        }
        if (type == 'custom') {
            $("#reurl").show();
        } else {
            $("#reurl").hide();
        }
    }

    function retype_ready() {
        var type = $("#redirect_type").val();
        if (type == 'custom') {
            $("#reurl").show();
        } else {
            $("#reurl").hide();
        }
    }

    function setHref(action) {
        if (action == 1) {
            //$('#enc').val(''); fancybox method
            document.cookie = "enc=";
            $('#enc').val('');
        }
        //$('#appLink').attr("href", "plugins/theme_create/themeView.php?reg_type=" + $('#reg_type').val() + "&template_name=" + $('#template_name').val() + "&dist=<?php //echo $user_distributor; 
                                                                                                                                                                    ?>&theme_id=" + $('#theme_id').val() + "&enc=" + $('#enc').val()); fancybox method

        $('#appLink').attr("href", "plugins/theme_create/themeView.php?reg_type=" + $('#reg_type').val() + "&page=theme&template_name=" + $('#template_name').val() + "&dist=<?php echo $user_distributor; ?>&theme_id=" + $('#theme_id').val() + "&enc=" + $('#enc').val()+"&modify_st=<?php echo $modify_mode; ?>");
    }
    $('#appLink').click(function(e) {
        if(!themeValidate()){
            return false;
        }
        e.preventDefault();
        setHref(0);
        var is_select_val = $('#is_active').is(':checked')?'1':'0';
        document.cookie = "theme_name=" + $('#theme_name').val();
        document.cookie = "location_ssid=" + $('#location_ssid').val();
        document.cookie = "title_t=" + $('#title_t').val();
        document.cookie = "redirect_type=" + $('#redirect_type').val();
        document.cookie = "splash_url=" + $('#splash_url').val();
        document.cookie = "splash_url_http=" + $('#urlsecure').val();
        document.cookie = "template_name=" + $('#template_name').val();
        document.cookie = "reg_type=" + $('#reg_type').val();
        document.cookie = "is_active=" + is_select_val;
        document.cookie = "theme_submit=<?php echo $theme_submit; ?>";
        window.location = $(this).attr("href");
    });

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
</script>
<style>
    .fancybox-overlay-fixed {
        z-index: 9999999999;
    }

    iframe {
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        z-index: 999999999999999999999;
        left: 0;
    }

    html {
        overflow: scroll;
        overflow-x: hidden;
    }
</style>