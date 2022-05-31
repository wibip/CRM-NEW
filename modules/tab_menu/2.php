<?php
require_once __DIR__ . '/../ModuleFunction.php';
if ((key_exists('user_type', $modules['tab_menu']) && $modules['tab_menu']['user_type'][$user_type] == '2') || !key_exists('user_type', $modules['tab_menu'])) {


    ?>
    <ul class="nav nav-tabs newTabs">
        <?php
        //require_once __DIR__ . '/../../modules/ModuleFunction.php';
        $tab_count = count($modules[$user_type][$script]);
        $one_tab_class="";
        if($tab_count==1){
            $one_tab_class = "class=\"one_tab\"";
        }
        foreach ($modules[$user_type][$script] as $tab) {
            if (!ModuleFunction::filter($tab['id'], $module_controls)) {
                continue;
            }



            if (!isset($_GET['t'])) {
                $_GET['t'] = $tab['id'];
                $variable_tab = 'tab_' . $_GET['t'];
                $$variable_tab = 'set';
            } else {
                $variable_tab = 'tab_' . $tab['id'];
            }
            
            if(isset($$variable_tab)){
                $active = 'class="active"';
                $a_active = 'clicked';
            }else{
                $active = '';
                $a_active = '';
            }
            echo '<li ' . $active . ' ><a href="#' . $tab['id'] . '" class="'.$a_active.'" data-toggle="tab" '.$one_tab_class.'>' . $tab['name'] . '</a></li>';
        }
        ?>
    </ul>
    <?php if ($new_design == 'yes' || $SUBMENU_VERTICALE == 'yes') { ?>
        <style type="text/css">
            /*home styles*/

            .nav-tabs>li>a.clicked {
                text-decoration: underline;
            }
            .widget-header {
                display: none;
            }

            .widget-content {
                padding: 0px !important;
                border: 1px solid #ffffff !important;
            }

            .intro_page {
                z-index: -4;
            }

            .nav-tabs {
                padding-left: 30% !important;
            }

            body .nav-tabs > .active > a, body .nav-tabs > .active > a:hover {
                background-color: #000000;
                border: none;
            }

            .nav-tabs > li > a {
                background: none !important;
                border: none !important;
                border-right: 1px solid white !important;
            }

            .nav-tabs > li > a {
                padding-top: 3px !important;
                padding-bottom: 3px !important;
                color: #fff !important;
                border-radius: 0px 0px 0 0 !important;
            }

            .nav-tabs > li:last-child > a {
                border-right: none !important;
            }

            body {
                background: #ffffff !important;
            }

            h1.head {
                padding: 50px;
                padding-bottom: 100px;
                width: 960px;
                margin: auto;
                font-size: 34px;
                text-align: center;
                color: #000;
                font-family: Rbold;
                box-sizing: border-box;
            }


            /*footer styles*/

            .contact {
                font-size: 16px;
                font-family: Rregular;
                color: #fff;
                margin-right: 50px;
            }

            .call span:not(.glyph), .footer-live-chat-link span:not(.glyph) {
                font-family: Rmedium;
                font-size: 20px;
                color: #fff;
            }

            .number {
                font-family: Rmedium;
                font-size: 20px;
            }

            .footer-live-chat-link {
                display: inline-block;
                margin-left: 50px;
            }

            .call a {
                font-family: Rmedium;
                font-size: 20px;
            }

            .footer-inner a:hover {
                text-decoration: none !important;
                color: #fff;
            }

            .main-inner {
                position: relative;
            }

            .main {
                padding-bottom: 0 !important;
            }

            /*network styles
        */

            .tab-pane {
                padding-bottom: 50px;
                /*	padding-top: 50px;*/
                /*border-bottom: 1px solid #000000;*/
            }

            .tab-pane:nth-child(1) {
                padding-top: 0px;
            }

            .tab-pane:last-child {
                border-bottom: none;
            }

            .alert {
                /*position: absolute;
                  top: 60px;*/
                width: 100%;
            }

            @media (max-width: 768px) {
                #product_tbl {
                    margin-top: 50px;
                }
            }

        </style>

        <script type="text/javascript">
            $(document).ready(function () {

                /* $('#create_theme').addClass('in').addClass('active');
                 */

                $('.nav-tabs li').removeClass('active');
                $('[data-toggle="tab"]').attr('data-toggle', 'tab1');


                $('[data-toggle="tab1"]').each(function (index, el) {

                    var tabDiv = $(this).attr('href').replace('#', '');
                    $(this).attr('href', 'javascript:void(0)');
                    $(this).attr('data-div', tabDiv);
                });

                $('[data-toggle="tab1"]').click(function (event) {

                    var tabDiv = $(this).attr('data-div');

                    $('[data-toggle="tab1"]').removeClass('clicked');
                    $(this).addClass('clicked');
                    
                    <?php 
                   
                    $cancel_title = "";
                    $cancel_description = "";

                    if($script=='network'){
                        $cancel_title = "Product Update Cancel";
                        $cancel_description = "Are you sure you want to cancel this product update?";
                    }elseif ($script=='theme') {
                        $cancel_title = "Service Area Update Cancel";
                        $cancel_description = "Are you sure you want to cancel this service area update?";
                    }

                    if($script=='network' || $script=='theme'){ ?>
                    
                try{

                    if(!$('#' + tabDiv).hasClass('active')){
                        var check = true;
                        $(".check_update").each(function(){
                            if($(this).val()=='yes'){
                                check = false;
                                return false;
                            }
                        });

                        if(!check){
                            $('#network-update-check').show();
                            $('#network-update-check-div').show();
                            return;
                        }
                    }

                }
                catch(err) {
                }

                <?php } ?>

                    $('.tab-pane').removeClass('active');

                    $('body').addClass('scrolling');
                    /*var elmnt = document.getElementsByClassName('main-inner')[0];
                    elmnt.scrollIntoView();*/

                    $('#' + tabDiv).addClass('in');
                    $('#' + tabDiv).addClass('active');
                    try{

                        if($(window).width() > 980 ){

                                if($(window).scrollTop() > ($('.main').position().top - 200)){
                                        $('.main').css('margin-top','40px');
                                        $('.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not(ul[id^="myTabDASHBOX"]):not(ul[id^="SSID_myTabDASHBOX"])').addClass('fixed-nav');
                                        $('.alert').css('top', '15px');
                                }else{
                                        $('.main').css('margin-top','0px');
                                        $('.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not(ul[id^="myTabDASHBOX"])').removeClass('fixed-nav');
                                        $('.alert').css('top', '60px');
                                }

                        }

                    }catch(err){

                    }
                    $('html, body').animate({
                        scrollTop: $(".main-inner").offset().top - 100
                    }, 200, function () {
                        $('body').removeClass('scrolling');
                    });


                });

                $('#network-update-check-closed').click(function(event) {
                    $('#network-update-check').hide();
                    $('#network-update-check-div').hide();
                });
                $('#network-update-check-close').click(function(event) {
                    $('#network-update-check').hide();
                    $('#network-update-check-div').hide();
                });
                $('#network-update-reload').click(function(event) {
                    var url = $('[data-toggle="tab1"].clicked').attr('data-div');
                    window.location.href = "<?php echo $script; ?>?t="+url;
                });

            });

           
            /*$('[data-toggle="tab1"]').click(function(event) {
                var tabDiv = $(this).attr('href').replace('#', '');

                $('html, body').animate({
                scrollTop: $("#" + tabDiv).offset().top
            }, 10000);

            });*/
        </script>
<div id="network-update-check" class="ui-widget-overlay ui-front" style="display: none;z-index: 100;"></div>
<div id="network-update-check-div" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="ui-id-3" aria-labelledby="ui-id-4" style="height: auto;width: auto;top: 55px;left: 50%;display: none;top: 30%;position: fixed;margin-left: -260px;z-index: 9999999999999999999999;">
<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
<span class="ui-dialog-title"><?php echo $cancel_title; ?></span>
<button type="button" id="network-update-check-close" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close">
<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">close</span></button></div>
	<div class="dialog confirm ui-dialog-content ui-widget-content" id="ui-id-3" style="display: block; width: auto; min-height: 0px; max-height: 0px; height: auto;">
	<?php echo $cancel_description; ?>
	</div>
	<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
		<div class="ui-dialog-buttonset">
        <button type="button" id="network-update-check-closed" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" role="button" aria-disabled="false"><span class="ui-button-text">No</span></button>
		<button type="button" id="network-update-reload" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">Yes</span></button>
			
		</div>
	</div>
</div>
        <?php
    }
} else {
    //echo '*****'.$user_type;
    $tab_module = __DIR__ . '/' . $modules['tab_menu']['user_type'][$user_type] . '.php';
    include_once $tab_module;
} ?>