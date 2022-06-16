<!--       <h1 class="head">
    First impressions last,
make yours a splash page. <img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable webpage upon connection to your Guest Wi-Fi network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1> -->
 <ul class="nav nav-tabs">






                                        <?php if(in_array("POWER_SCHEDULE_CREATE",$features_array) || $package_features=="all"){ ?>
                                            <li <?php if(isset($tab1)){?>class="one_tab active" <?php } else{ echo 'class="one_tab"'; }?>><a href="#tab_1" data-toggle="tab"><?php echo _POWER_SCHEDULE_NAME_; ?>Schedule</a></li>
                                        <?php } ?>






                                </ul>
<style type="text/css">
 .intro_page{
        
    <?php 

    if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
        echo 'height: 337px;margin-top: -35px;background-size: 100%;';
    } 

     ?>

     height: 300px !important;
    margin-top: -35px !important; 
    background-repeat: no-repeat;
    background-size: cover !important;
    background-position: center !important;
        
        
    }

    .intro_page_txt{
           /* width: 960px;*/
            margin: auto;
            text-align: center;
            /* left: 20%; */
            padding-top: 70px;
    }

    .intro_page_txt h1{
        font-size: 47px;
        color: #fff;
        line-height: 50px;
    }

    .intro_page_txt h2{
        font-size: 36px;
        color: #fff;
         line-height: 45px;
    }

</style>
