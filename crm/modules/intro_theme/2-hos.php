
<div class="tab-pane <?php if (isset($tab_intro_theme )){ echo 'active'; } ?>" id="intro_theme">




<?php

if(isset($_SESSION['intro'])){

    echo $_SESSION['intro'];

    unset($_SESSION['intro']);





}?>



<div class="widget widget-table action-table">



    <?php if($message) echo "<p>$message</p>"; ?>



    <form enctype="multipart/form-data" id="submit_import_form" class="form-horizontal" method="POST" action="theme<?php echo $extension; ?>?active_tab=import_theme">





        <?php

        echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET_THEME'].'" />';

        ?>





        <fieldset>

            <?php

            $key_query1 = "SELECT DISTINCT tag_name FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor' ORDER BY tag_name ASC";

            $query_results1=$db->selectDB($key_query1);

            $count_ssid = $query_results1['rowCount'];



            if($count_ssid == 0){

               /*  $warning_text = '<div class="alert alert-warning" role="alert"><h3><i class="icon-warning-sign"></i> Warning! <small>';

                $warning_text .= '<br>Please create a <a href="location.php?t=3" class="alert-link">Group Tag / Location</a> before trying to create a theme';

                $warning_text .= '</small></h3></div>'; */



                echo $warning_text;

            }

            ?>

            <div class="control-group">

            <div class="header2_part1"><h2>What is a <?php echo ucwords(__THEME_TEXT__); ?>?</h2></div>



               <br>

               <script>




               </script>


    <!--<div class="" id="dum" style="display: inline-block;">  -->

    <div style="display: inline-block;">

                <p>A <?php echo __THEME_TEXT__; ?> provides a "walled garden" with internet access managed by a customizable webpage. Guests will automatically be redirected to the <?php echo __THEME_TEXT__; ?> when they connect to your Guest <?php echo __WIFI_TEXT__; ?> network.</p>


               <p>The <?php echo __THEME_TEXT__; ?> Creator allows you to customize your <?php echo __THEME_TEXT__; ?>. You can select images from our stock photo gallery, upload a company logo and customize the text fields.</p>


               <p>You can also create multiple <?php echo __THEME_TEXT__; ?>s for your location, but only one <?php echo __THEME_TEXT__; ?> may be enabled at a time. You can easily enable or disable a stored <?php echo __THEME_TEXT__; ?> from the "Manage" tab.</p>

               <p>Before you enable a <?php echo __THEME_TEXT__; ?>, review it in the "Manage <?php echo __THEME_TEXT__; ?>" tab, which allows you to review your design prior to publishing them to your Guest <?php echo __WIFI_TEXT__; ?> network.</p>

        </div>

        <!-- <div style="display: inline-block;" class="span2">
            <img  src="img/theme_img_002.jpg" alt="Welcome image" style="width:200px;height:300px;padding-right:70%;">
        </div>-->




                <div class="controls">



                </div>

                <!-- /controls -->

            </div>

            <!-- /control-group -->



            <div class="control-group">





                <div class="controls">

                    <div class="input-prepend input-append">







                    </div>

                </div>

                <!-- /controls -->

            </div>

            <!-- /control-group -->


        </fieldset>

    </form>





    <!-- /widget-content -->

</div>

<!-- /widget -->



</div>