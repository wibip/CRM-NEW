<div style="font-size: medium" <?php if(isset($tab_guestnet_tab_intruduct)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_intruduct">


    <?php

    if ($hospitality_feature) {
        $hospitality = 'Guest';
    }else{
        $hospitality = 'Guest';
    }

    $gst_wifi_intro=$message_functions->getPageContent('guest_wifi_introduction_content',$system_package);

    $txt_replace = array(

        '{$wifi_txt}' => __WIFI_TEXT__,
        '{$hospitality}' => $hospitality,
        '{$theme}' => __THEME_TEXT__,
        '{$themeUpper}' =>  ucwords(__THEME_TEXT__)
    );

    $gst_wifi_intro = strtr($gst_wifi_intro, $txt_replace);
    echo $gst_wifi_intro;
    ?>

</div>