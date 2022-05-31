<?php

$get_help_text_q = "SELECT * FROM `exp_texts` WHERE `distributor`='$user_distributor' AND `text_code` = 'CAPTIVE_HELP_TEXT'";

$get_help_text = $db->selectDB($get_help_text_q);

if($get_help_text['rowCount'] > 0){
    foreach($get_help_text['data'] AS $row){
        $sup_link = $row['title'];
        //$jsonData = trim($row['text_details']);
        //$jsonData = stripslashes(html_entity_decode($row['text_details']));
        $jsonData = preg_replace('/[[:cntrl:]]/', '', $row['text_details']);
        $sup_json = $get_rm_settings = json_decode($jsonData, true);
        
        
        $sup_conf = $sup_json['help_text_config'];
        $sup_lang = $sup_json['support_language'];
        $sup_content = $sup_json['support_content'];
    }
}else{

    
    $get_help_text_q = "SELECT * FROM `exp_texts` WHERE `distributor`='$system_package' AND `text_code` = 'CAPTIVE_HELP_TEXT'";

    $get_help_text = $db->select1DB($get_help_text_q);

    $sup_link = $get_help_text['title'];


    $jsonData = preg_replace('/[[:cntrl:]]/', '', $get_help_text['text_details']);
    $sup_json = $get_rm_settings = json_decode($jsonData, true);
    //$sup_json = $get_rm_settings = json_decode($get_help_text['text_details'], true);
    $sup_conf = $sup_json['help_text_config'];
    $sup_lang = $sup_json['support_language'];
    $sup_content = $sup_json['support_content'];
}


?>

<style type="text/css">

    input[type="checkbox"].hide_checkbox{
        z-index: -1;
    }
</style>



<div <?php if (isset($_SESSION['submit_config']) || $_GET['t'] == 'config_splash_page'){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="config_splash_page">

    <?php

        if (isset($_SESSION['submit_config'])) {
            echo $_SESSION['submit_config'];
            unset($_SESSION['submit_config']);
        } 

    ?>

    <div id="response_d1">


    </div>

    <form autocomplete="nope" id="customer_form" name="customer_form" method="post"  class="form-horizontal" enctype="multipart/form-data" action="?t=config_splash_page"><!--action="?t=config_splash_page"-->
        <fieldset>
            <div class="control-group">

                <h2 style="display: inline-block;">Splash Page Config</h2>
                
                <div class="controls form-group" style="display: inline-block;margin-left: 20px;">
                                        

                        <?php if($sup_conf == '1'){ ?>

                            <div class="toggle1-l"><input class="hide_checkbox" type="checkbox" checked name="splash_page_config"><span class="toggle1-on">SHOW</span><a href="javascript:void();" id="hide_config"><span class="toggle1-off-dis">HIDE</span></a></div>


                            <script type="text/javascript">

                                $(document).ready(function() {

                                    $('#hide_config').easyconfirm({locale: {

                                        title: 'Hide Splash Page Config',

                                        text: 'Are you sure you want to hide splash page config?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',

                                        button: ['Cancel',' Confirm'],

                                        closeText: 'close'

                                    }});

                                    $('#hide_config').click(function() {

                                        window.location = "?t=config_splash_page&show_config=0";

                                    });

                                });

                            </script>



                            <?php }else{ ?>

                           
                            <div class="toggle1-l"><input type="checkbox" class="hide_checkbox"  name="splash_page_config"><a href="javascript:void();" id="show_conf"><span class="toggle1-on-dis">SHOW</span></a><span class="toggle1-off">HIDE</span></div>


                            <script type="text/javascript">

                                $(document).ready(function() {

                                    $('#show_conf').easyconfirm({locale: {

                                        title: 'Show Splash Page Config',

                                        text: 'Are you sure you want to show splash page config?&nbsp;&nbsp;&nbsp;&nbsp;',

                                        button: ['Cancel',' Confirm'],

                                        closeText: 'close'

                                    }});

                                    $('#show_conf').click(function() {

                                        window.location = "?t=config_splash_page&show_config=1";

                                    });

                                });

                            </script>


                            <?php } ?>
 

                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->

            <div class="control-group">

                <label class="control-label" for="">Support Language</label>
                
                <div class="controls form-group">
                                        
                    <input class="span4 form-control" id="sup_language" placeholder="" name="sup_language" type="text" value="<?php echo $sup_lang; ?>" autocomplete="nope">
                    
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->

            <div class="control-group">

                <label class="control-label" for="">Need Help Link</label>
                
                <div class="controls form-group">
                                        
                    <input class="span4 form-control" id="sup_link" placeholder="" name="sup_link" type="text" value="<?php echo $sup_link; ?>" autocomplete="nope">
                    
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->

            <div class="control-group">

                <label class="control-label" for="">Need Help Content</label>
                
                <div class="controls form-group">
                                        
                    
                    <textarea  width="100%" id="sup_content" name="sup_content" class="sup_content">
                        <?php echo $sup_content; ?>
                    </textarea>
                    
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->



            <div class="form-actions">
                <button type="submit" name="theme_config_submit" id="theme_config_submit" class="btn btn-primary">Save</button>

                <button type="button" class="btn btn-info inline-btn" onclick="gopto();">Cancel</button>
                              
            </div>

            <script type="text/javascript">
            $(document).ready(function() {
                $('#theme_config_submit').easyconfirm({locale: {
                    title: 'Splash Page Config',
                    text: 'Are you sure you want to save changes?',
                    button: ['Cancel',' Confirm'],
                    closeText: 'close'
                     }
                });
                $('#theme_config_submit').click(function() {
                    document.customer_form.submit();
                    
                });

                
                });

            function gopto(url){
                window.location = "?t=config_splash_page";
            }
            </script>

        </fieldset>
    </form>

</div>

