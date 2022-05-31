<?php
require_once 'active_theme.php';
?>
<div class="tab-pane <?php if (isset($tab_active_theme )){ echo 'active'; } ?>" id="active_theme">

                                            <div class="theme_head_visible" style="display:none;"><div class="header_hr"></div><div class="header_f1">
    First impressions last</div><img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable webpage upon connection to your Guest <?php echo __WIFI_TEXT__; ?> network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab.' src="layout/VERIZON/img/help.png" style="width: 25px;margin-bottom: 6px;cursor: pointer;margin-left: 4px;">
<br class="hide-sm"><br class="hide-sm"><div class="header_f2" style="width: fit-content;">make yours a splash page. </div></div>

                                            <?php

                                        

                                                if(isset($_SESSION['active_theme'])){

                                                echo $_SESSION['active_theme'];

                                                unset($_SESSION['active_theme']);



                                            }
                                            ?>




                                                  <h1 class="head" style="display: none;">
    First impressions last,
make yours a <?php echo __THEME_TEXT__; ?>. <img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable webpage upon connection to your Guest <?php echo __WIFI_TEXT__; ?> network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab.' src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>
<!-- <br>
<br> -->



<?php

$language_enable= $package_functions->getSectionType('LANGUAGE_ENABLE',$system_package,'MVNO');

?>


                                            <div class="widget widget-table action-table" >



                                                <div class="widget-header">

                                                    <!-- <i class="icon-th-list"></i> -->

                                                    <h3>Active <?php echo ucwords(__THEME_TEXT__); ?>s<img  id="campcreate_loader_1" src="img/loading_ajax.gif" style="visibility: hidden;"></h3>

                                                </div>

                                                <!-- /widget-header -->

                                                <div class="widget-content table_response" id="campcreate_div1">
                                                    <div style="overflow-x:auto">

                                                    <table id="active_theme_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                                                        <thead>

                                                            <tr>


                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><?php echo ucwords(__THEME_TEXT__); ?> Name</th>

                                                                <?php if($package_functions->getSectionType('LANGUAGE_ENABLE',$system_package)=='1'){ ?>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Language(s)</th>
                                                                <?php }?>
                                                            <!---   <th>Update date</th> -->
                                                                <?php
                                                                if($other_multi_area!=1){
                                                                ?>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Status</th>
                                                                <?php } ?>

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Customer Account #</th>


                                                                <!-- <th style="min-width: 290px;"></th> -->


                                                            </tr>

                                                        </thead>

                                                        <tbody>



                                                            <?php

                                                            $theme_arr=$theme_arr=active_theme::inst()->multiSSIDActiveThemes($user_distributor);

                                                                $key_query = "SELECT id,ref_id,theme_id, theme_name, `LANGUAGE`, registration_type,create_date,is_enable,language_string FROM exp_themes

                                                                WHERE distributor = '$user_distributor' AND theme_type = 'MASTER_THEME' ORDER BY ref_id,ABS(is_enable-1) ASC";



                                                                $query_results=$db->selectDB($key_query);


                                                                $array=array();
                                                                
                                                                foreach ($query_results['data'] AS $row) {

                                                                    $auto_id = $row['id'];

                                                                    $location_ssid = $row['ref_id'];

                                                                    $theme_id = $row['theme_id'];

                                                                    $theme_name = $row['theme_name'];

                                                                    $LANGUAGE = $row['LANGUAGE'];

                                                                    $create_date = $row['create_date'];

                                                                    $is_enable=$row['is_enable'];
                                                                    
                                                                    $language_string=$row['language_string'];
                                                                    if ($other_multi_area != 1) {
                                                                        if ($is_enable == 1) {
                                                                            $theme_remove='disable';
                                                                        }else{
                                                                            $theme_remove='enable';
                                                                        }
                                                                    }else{
                                                                       if (in_array($theme_id, $theme_arr)) {
                                                                            $theme_remove='disable';
                                                                        }
                                                                        else{
                                                                            $theme_remove='enable';
                                                                        } 
                                                                    }
                                                                    

                                                                    echo '<tr>





                                                                    <td> '.$theme_name.' </td>';

                                        if($package_functions->getSectionType('LANGUAGE_ENABLE',$system_package)=='1'){

                                                                    echo '<td> ';

                                                            //$theme_name =addslashes($theme_name);

                                                                    $list_lan_q = "SELECT `language`, `is_enable` FROM exp_themes WHERE ref_id = '$theme_id'";

                                                                    $list_lan_r = $db->selectDB($list_lan_q);

                                                                    $list_count = $list_lan_r['rowCount'];



                                                                        if($list_count > 0){



                                                                            $str = "<ul>";

                                                                            $str .= "<li> English </li>";



                                                                            
                                                                            foreach ($list_lan_r['data'] AS $rrrr) {

                                                                                $rr_language = $rrrr[language];

                                                                                $rr_is_enable = $rrrr[is_enable];



                                                                                $query_lan = "SELECT language FROM system_languages WHERE language_code = '$rr_language'";

                                                                                $result_lan = $db->select1DB($query_lan);

                                                                                //$r = mysql_fetch_array($result_lan);

                                                                                $lan = $result_lan[language];



                                                                                if($rr_is_enable == 1){

                                                                                    //$chek='checked';

                                                                                    $str .= "<li>".$lan." - <font color=green><strong>ENABLED</strong></font></li>";

                                                                                }else{

                                                                                    //$chek='';

                                                                                    $str .= "<li>".$lan." - <font color=red><strong>DISABLED</strong></font></li>";

                                                                                }

                                                                        //  echo   '<a id="EN_DIS_'.$auto_id.'"><input '.$chek.' onchange="changePasscodeM()" id="EN_DIS1_'.$auto_id.'" type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-width="60"></a>';



                                                                            }

                                                                            echo '<a id="'.str_replace(" ","",$auto_id).'">View </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';

                                                                            echo '<script>

                                                                                $(document).ready(function() {



                                                                                    $(\'#'.str_replace(" ","",$auto_id).'\').tooltipster({

                                                                                        content: $("'.$str.'"),

                                                                                        theme: \'tooltipster-shadow\',

                                                                                        animation: \'grow\',

                                                                                        onlyOne: true,

                                                                                        trigger: \'click\'



                                                                                    });





                                                                                });

                                                                            </script>';

                                                                        }else{

                                                                            echo 'English &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';

                                                                        }

                                                                    echo '<a href="?add_new_lan=new&token='.$secret.'&id='.$theme_id.'"><i class="icon-plus"></i></a></td>

                                                                     ';
                                                        }
                                                            if ($other_multi_area != 1) {
                                                                if ($ori_user_type != 'SALES') {
                                                                    if ($is_enable == 1) {

                                                                        //echo '<td><font color=green><strong>ENABLED</strong></font></td>';

                                                                        echo '<td><div class="toggle1"><input checked onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox"><span class="toggle1-on">ON</span>
                                                                        <a id="ST_' . $auto_id . '" href="javascript:void();" ><span class="toggle1-off-dis">OFF</span></a>
                                                                        </div>';

                                                                        echo '';

                                                                        echo '

                                                                    <script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#ST_' . $auto_id . '\').easyconfirm({locale: {

                                                                            title: \'Disable ' . ucwords(__THEME_TEXT__) . '\',

                                                                            text: \'Are you sure you want to disable this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#ST_' . $auto_id . '\').click(function() {



                                                                        window.location = "?t=active_theme&token=' . $secret . '&modify=2&is_enable=0&id=' . $auto_id . '&ssid=' . $location_ssid . '&theme_name=' . addslashes($theme_name) . '"

                                                                        });

                                                                        });

                                                                    </script>';


                                                                    } else {

                                                                        // echo '<td><font color=red><strong>DISABLED</strong></font></td>';

                                                                        echo '<td><div class="toggle1"><input onchange="" type="checkbox" class="hide_checkbox">
                                                                    <a href="javascript:void();" id="CE_' . $auto_id . '"><span class="toggle1-on-dis">ON</span></a>
                                                                    <span class="toggle1-off">OFF</span>
                                                                    </div>';

                                                                        echo '';

                                                                        echo '

                                                                <script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#CE_' . $auto_id . '\').easyconfirm({locale: {

                                                                            title: \'Activate ' . ucwords(__THEME_TEXT__) . '\',

                                                                            text: \'Are you sure you want to activate this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#CE_' . $auto_id . '\').click(function() {

                                                                            window.location = "?t=active_theme&token=' . $secret . '&modify=2&is_enable=1&id=' . $auto_id . '&theme_name=' . addslashes($theme_name) . '"

                                                                        });

                                                                        });

                                                                    </script>';

                                                                    }
                                                                } else {
                                                                    $test = $_SESSION['testarr'];
                                                                    $reversed = array_reverse($test);
                                                                    if (in_array($auto_id, $reversed)) {
                                                                        $key = array_search($auto_id, $reversed);
                                                                        $a = $key - 1;
                                                                        if ($reversed[$a] == 0) {
                                                                            $is_enable = 0;
                                                                        } else {
                                                                            //$is_enabl==0;
                                                                            $is_enable = 1;
                                                                        }

                                                                    }
                                                                    $test = array_reverse($reversed);
                                                                    $_SESSION['testarr'] = $test;
                                                                    if ($is_enable == 1) {

                                                                        //echo '<td><font color=green><strong>ENABLED</strong></font></td>';

                                                                        echo '<td><div class="toggle1"><input checked onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox"><span class="toggle1-on">ON</span>
                                                                        <a id="ST_' . $auto_id . '" href="javascript:void();" ><span class="toggle1-off-dis">OFF</span></a>
                                                                        </div>';

                                                                        echo '';

                                                                        echo '

                                                                    <script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#ST_' . $auto_id . '\').easyconfirm({locale: {

                                                                            title: \'Disable ' . ucwords(__THEME_TEXT__) . '\',

                                                                            text: \'Are you sure you want to disable this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#ST_' . $auto_id . '\').click(function() {



                                                                        window.location = "?t=active_theme&token=' . $secret . '&modify=2&is_enable=0&id=' . $auto_id . '&ssid=' . $location_ssid . '&theme_name=' . addslashes($theme_name) . '"

                                                                        });

                                                                        });

                                                                    </script>';


                                                                    } else {

                                                                        // echo '<td><font color=red><strong>DISABLED</strong></font></td>';

                                                                        echo '<td><div class="toggle1"><input onchange="" type="checkbox" class="hide_checkbox">
                                                                    <a href="javascript:void();" id="CE_' . $auto_id . '"><span class="toggle1-on-dis">ON</span></a>
                                                                    <span class="toggle1-off">OFF</span>
                                                                    </div>';

                                                                        echo '';

                                                                        echo '

                                                                <script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#CE_' . $auto_id . '\').easyconfirm({locale: {

                                                                            title: \'Activate ' . ucwords(__THEME_TEXT__) . '\',

                                                                            text: \'Are you sure you want to activate this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#CE_' . $auto_id . '\').click(function() {

                                                                            window.location = "?t=active_theme&token=' . $secret . '&modify=2&is_enable=1&id=' . $auto_id . '&theme_name=' . addslashes($theme_name) . '"

                                                                        });

                                                                        });

                                                                    </script>';


                                                                    }

                                                                }

                                                                echo '</td>';
                                                            }

                                                                    echo '<td><a id="CM_'.$theme_id.'"  class="btn btn-small btn-primary"><i class="btn-icon-only icon-wrench"></i>Edit&nbsp;</a><script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#CM_'.$theme_id.'\').easyconfirm({locale: {

                                                                            title: \'Manage '.ucwords(__THEME_TEXT__).' ['.str_replace("'"," ",$theme_name).']\',

                                                                            text: \'Are you sure you want to modify this '.__THEME_TEXT__.'?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#CM_'.$theme_id.'\').click(function() {

                                                                            window.location = "?t=create_theme&token='.$secret.'&modify=1&modify_s=1&id='.$theme_id.'&lan='.$LANGUAGE.'"

                                                                        });

                                                                        });

                                                                    </script>';

                                                                    echo '</td><td>';
                                                                    if ($theme_remove=='enable') {
                                                                        echo '<a id="RE_' . $theme_id . '"  class="btn btn-small btn-danger"><i class="btn-icon-only icon-trash"></i>Remove&nbsp;</a>';
                                                                        echo '<script type="text/javascript">

                                                                $(document).ready(function() {

                                                                    $(\'#RE_' . $theme_id . '\').easyconfirm({locale: {

                                                                            title: \'Remove ' . ucwords(__THEME_TEXT__) . '\',

                                                                            text: \'Are you sure you want to remove this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#RE_' . $theme_id . '\').click(function() {

                                                                            window.location = "?t=active_theme&token=' . $secret . '&remove=1&id=' . $theme_id . '&theme_name=' . urlencode(addslashes($theme_name)) . '&lan=' . $LANGUAGE . '"

                                                                        });

                                                                        });

                                                                    </script>';
                                                                    }else{
                                                                        echo '<a id="REE_' . $theme_id . '"  class="btn btn-small btn-danger" Disabled><i class="btn-icon-only icon-trash"></i>Remove&nbsp;</a>';
                                                                    }
                                                                        //echo '<a id="RE_'.$theme_id.'"  class="btn btn-small btn-danger"><i class="btn-icon-only icon-trash"></i>Remove&nbsp;</a>';
                                                                        /*JavaScript part move in to is_enable if condition else part*/


                                                            if(in_array("THEME_IMPORT",$features_array) || $package_features=="all"){   echo '<a id="DOWN_'.$theme_id.'"  class="btn btn-small btn-warning"><i class="btn-icon-only icon-download-alt"></i>Export</a><script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#DOWN_'.$theme_id.'\').easyconfirm({locale: {

                                                                            title: \'Export '.ucwords(__THEME_TEXT__).'\',

                                                                            text: \'Are you sure,you want to export this '.__THEME_TEXT__.'?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#DOWN_'.$theme_id.'\').click(function() {

                                                                            window.location = "ajax/download_theme.php?&theme_id='.$theme_id.'"

                                                                        });

                                                                        });

                                                                    </script></td>';}



                                                                                                        echo '<td> '.$location_ssid.' </td>';


                                                                                                    echo '</tr>';

                                                                }



                                                            ?>



                                                        </tbody>

                                                    </table>

                                                </div>
                                                </div>

                                                <!-- /widget-content -->

                                            </div>

                                            <!-- /widget -->



                                        </div>