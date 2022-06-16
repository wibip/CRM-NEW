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
  <ul class="nav nav-tabs">



                                        <?php
                                        
                                        if($user_type == 'MVNE' || $user_type == 'MVNO'){
                                            ?>
                                            <!--<li <?php //if(isset($tab1)){?>class="active" <?php //}?>><a href="#live_camp" data-toggle="tab">Active Networks</a></li>-->

                                            <?php if(in_array("NET_GUEST_INTRO",$features_array) || $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab8)){?>class="active" <?php }?>><a href="#guestnet_tab_intruduct" data-toggle="tab">Introduction</a></li>

                                            <?php } if(in_array("NET_GUEST_SSID",$features_array) || $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab7)){?>class="active" <?php }?>><a href="#guestnet_tab_1" data-toggle="tab">SSID</a></li>


                                            <?php } if(in_array("NET_PRODUCT",$features_array) || $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab75)){?>class="active" <?php }?>><a href="#tab_product" data-toggle="tab">Product</a></li>

                                            <?php } if(in_array("NET_GUEST_BANDWITH",$features_array) || $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab2)){?>class="active" <?php }?>><a href="#guestnet_tab_2" data-toggle="tab"><?php if($new_design=='yes'){ ?> QoS & Duration <?php }else{ ?>Bandwidth <?php    } ?></a></li>
                                            
                                            <?php } if(in_array("NET_GUEST_PASSCODE",$features_array)|| $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab9)){?>class="active" <?php }?>><a href="#guestnet_tab_9" data-toggle="tab">Passcode</a></li>

                                            <?php } if(in_array("NET_AP_NAME",$features_array)|| $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab15)){?>class="active" <?php }?>><a href="#guestnet_tab_15" data-toggle="tab">AP Name</a></li>
                                            <?php } ?>
                                            <?php if($edit_prof==1 || $edit_prof_timegap==1){?>
                                                <li <?php if(isset($subtab5)){?>class="active" <?php }?>><a href="#edit_product" data-toggle="tab">Edit Bandwidth</a></li>  <?php } ?>
                                            

                                            <!--<li <?php //if(isset($tab4)){?>class="active" <?php //}?>><a href="#asign_ssid" data-toggle="tab">Asign CPEs to Guest Network</a></li>
                                            <li <?php ///if(isset($tab10)){?>class="active" <?php //}?>><a href="#asign_gps" data-toggle="tab">SSID GEO Location</a></li>-->
                                            <?php
                                        }
                                        ?>

                                    </ul>
                                    <br>