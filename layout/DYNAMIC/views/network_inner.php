  <!--     <h1 class="head">
    It is your business, so let the SSID show it. <img data-toggle="tooltip" title="Tooltip test" src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1> -->


  <ul class="nav nav-tabs newTabs">




                                        <?php
                                        if($user_type == 'MVNE' || $user_type == 'MVNO'){
                                            ?>
                                            <!--<li <?php //if(isset($tab1)){?>class="active" <?php //}?>><a href="#live_camp" data-toggle="tab">Active Networks</a></li>-->

                                            <?php if(in_array("NET_GUEST_INTRO",$features_array) || $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab8)){?>class="active" <?php }?>><a href="#guestnet_tab_intruduct" data-toggle="tab">Introduction</a></li>
                                            <?php } if(in_array("NET_GUEST_SSID",$features_array) || $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab7)){?>class="active" <?php }?>><a href="#guestnet_tab_1" data-toggle="tab">SSID</a></li>
                                            <?php } if(in_array("NET_GUEST_BANDWITH",$features_array) || $package_features=="all"){ ?>
                                                <li <?php if(isset($subtab2)){?>class="active" <?php }?>><a href="#guestnet_tab_2" data-toggle="tab"><?php if($new_design=='yes'){ ?> Schedule <?php }else{ ?>Bandwidth <?php    } ?></a></li>
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
                                    
<style type="text/css">
	  /*home styles*/

  .widget-header{
        display: none;
  }
  .widget-content{
  	padding: 0px !important;
  	border: 1px solid #ffffff !important;
  }
  .intro_page{
    z-index: -4;
  }
  /*.nav-tabs{
    padding-left: 30% !important;
  }
  body .nav-tabs>.active>a, body .nav-tabs>.active>a:hover{
        background-color: #000000;
    border: none;
  }*/

  .nav-tabs>li>a{
    /*background: none !important;
    border: none !important;
    border-right: 1px solid white !important;*/
  }
  .nav-tabs>li>a{
       /* padding-top: 3px !important;
    padding-bottom: 3px !important;
    color: #fff !important;*/
    border-radius: 0px 0px 0 0 !important;
  }

  .nav-tabs>li:nth-child(3)>a{
  	border-right: none !important;
  }

  body {
    background: #ffffff !important;
}

h1.head {
    padding: 0px;
    padding-bottom: 35px;
    width: 960px;
    font-weight: bold !important;
    margin: auto;
    font-size: 25px;
    text-align: center;
    color: #5f5a5a;
    box-sizing: border-box;
}


/*footer styles*/

.contact{
    font-size: 16px;
    font-family: Rregular;
    color: #fff;
        margin-right: 50px;
}

.call span:not(.glyph), .footer-live-chat-link span:not(.glyph){
    font-family: Rmedium;
    font-size: 20px;
    color: #fff;
}

.number{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-live-chat-link{
        display: inline-block;
    margin-left: 50px;
}

.call a{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-inner a:hover{
    text-decoration: none !important;
    color: #fff;
}

.main-inner{
	position: relative;
}

.main {
    padding-bottom: 0 !important;
}

	/*network styles
*/

.tab-pane{
	padding-bottom: 50px;
/*	padding-top: 50px;*/
    /*border-bottom: 1px solid #000000;*/
}

.tab-pane:nth-child(1){
	padding-top: 0px;
}

.tab-pane:last-child{
	border-bottom: none;
}

.alert {
  /*position: absolute;
    top: 60px;*/
    width: 100%;
} 

</style>

<script type="text/javascript">
$(document).ready( function(){

 /* $('#create_theme').addClass('in').addClass('active');
  */




  });

	/*$('[data-toggle="tab1"]').click(function(event) {
		var tabDiv = $(this).attr('href').replace('#', '');

		$('html, body').animate({
        scrollTop: $("#" + tabDiv).offset().top
    }, 10000);

	});*/
</script>