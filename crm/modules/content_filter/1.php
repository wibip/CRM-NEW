<div <?php if(isset($tab_content_filter)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="content_filter">
                                            <!-- Tab 3 start-->



                                            <h1 class="head">
                                                Feature Details.
                                            </h1>

                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Content Filter</h3>
                                                </div>

                                                <div class="widget-content table_response" id="act_profile_tbl">

                                                <h3 style="display: inline-block;">Content Filtering<img data-toggle="tooltip" title="Content Filtering is add-on service, to activate content filtering, you must contact customer service at the phone number located at the bottom of the portal. Content Filtering is only applicable to your Guest WiFi SSIDs. Filtered content will be indicated by an informational block message." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>
                                                    <div style="overflow-x:auto;" >
                                                        <table class="table table-striped table-bordered" >
                                                            <thead>

                                                            <tr>
                                                                <th>Service</th>
                                                                <th>Status</th>
                                                            </tr>

                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>Content Filtering</td>
                                                                <td>
                                                                    <?php
                                                                    $dnssecret=md5(uniqid(rand(), true));
                                                                    $_SESSION['DNS_FORM_SECRET'] = $dnssecret;


                                                                    $dns_q = $db->selectDB("SELECT * FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");


                                                                    foreach ($dns_q['data'] as $row) {
                                                                        $content_filter=$row[dns_profile_enable];
                                                                        $content_filter_dns=$row[dns_profile];
                                                                        $content_filter_enable=$row[content_filter_enable];
                                                                    }

                                                                    if($content_filter_enable==1){

                                                                        if(empty($content_filter_dns)){
                                                                            // $is_d = 'disabled';

                                                                            $is_d = 'enabled';

                                                                        }else{
                                                                            $is_d = 'enabled';
                                                                        }

                                                                        if($content_filter=='1'){
                                                                            echo '<div style=" width: 145px; " class="toggle1 new"><input checked '.$is_d.' onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox"><span class="toggle1-on">Enabled</span>';
                                                                            if( $is_d == 'disabled'){ echo '<input  '.$is_d.'  onchange="" href="javascript:void();"   type="checkbox" class="hide_checkbox"><span class="toggle1-off-dis">Disabled</span>';
                                                                            }else{
                                                                                echo ' <a href="javascript:void();" id="DNSChange"><span class="toggle1-off-dis">Disabled</span>
                                    </a>'; }
                                                                            echo'  </div><img id="camplivead_loader_'.$ad_id.'" src="img/loading_ajax.gif" style="visibility: hidden; display: none"><script type="text/javascript">
$(document).ready(function() {
$(\'#DNSChange\').easyconfirm({locale: {
        title: \'Disable Content Filtering\',
        text: \'Are you sure you want to disable content filtering?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        button: [\'Cancel\',\' Confirm\'],
        closeText: \'close\'
         }});
    $(\'#DNSChange\').click(function() {
        window.location = "?token='.$dnssecret.'&t=content_filter&action=disable&changeContentFilter"
    });
    });
</script></td>';
                                                                        }else{
                                                                            echo '<div style=" width: 145px; " class="toggle1 new"><input checked '.$is_d.' onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox">';
                                                                            if( $is_d == 'disabled'){ echo '<input  '.$is_d.'  onchange="" href="javascript:void();"  type="checkbox" class="hide_checkbox"><span class="toggle1-on-dis">Enabled</span>';
                                                                            }else{
                                                                                echo ' <a href="javascript:void();" id="DNSChange"><span class="toggle1-on-dis">Enabled</span>
                                    </a>';} echo '<span class="toggle1-off">Disabled</span></div><img id="camplivead_loader_'.$ad_id.'" src="img/loading_ajax.gif" style="visibility: hidden; display: none"><script type="text/javascript">
$(document).ready(function() {
$(\'#DNSChange\').easyconfirm({locale: {
        title: \'Enable Content Filtering\',
        text: \'Are you sure you want to enable content filtering?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        button: [\'Cancel\',\' Confirm\'],
        closeText: \'close\'
         }});
    $(\'#DNSChange\').click(function() {
        window.location = "?token='.$dnssecret.'&t=content_filter&action=enable&changeContentFilter"
    });
    });
</script></td>';
                                                                        }

                                                                    }else{
                                                                        echo "Disabled";
                                                                    }


                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- <p>
                                                
                                                    Note: Filtered content will be indicated by an informational block message.
                                                
                                            </p> -->


                                            <br/>

                                            <?php
                                            if($package_functions->getSectionType('CONTENT_FILTER_CHANGE',$system_package)=="YES" || $package_features=="all") {

                                                ?>
                                                    <form id="tab2_form1" name="tab2_form1" method="post"
                                                      class="form-horizontal">

                                                    <fieldset>

                                                        <input <?php

                                                        if ($content_filter == '1') echo "  checked   " ?>
                                                            onchange="contentFilter()" id="content_filter_check"
                                                            name="content_filter_check" type="checkbox"
                                                            data-toggle="toggle" data-on="On" data-off="Off"
                                                            data-width="30">
                                                        <script>
                                                            function contentFilter() {
                                                                var value = $('#content_filter_check:checked').val();
                                                                /*alert(value);*/
                                                                if (value == 'on') {
                                                                    window.location = '?content_filter=1&t=content_filter&secret=<?php echo $secret; ?>';
                                                                } else {
                                                                    window.location = '?content_filter=0&t=content_filter&secret=<?php echo $secret; ?>';
                                                                }
                                                            }
                                                        </script>
                                                    </fieldset>
                                                </form>
                                                <?php
                                            }
                                            ?>



                                            <!-- Tab 3 End-->
                                        </div>