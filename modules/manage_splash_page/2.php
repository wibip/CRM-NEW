<style>
#snackbar {
  visibility: hidden;
  min-width: 100px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 8px;
  position: fixed;
  z-index: 1;
  left: 60%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}
</style>

<div <?php if (isset($tab_manageTheme)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="manageTheme">
                                            <?php
                                            if (isset($_SESSION['manageTheme'])) {

                                                echo $_SESSION['manageTheme'];

                                                unset($_SESSION['manageTheme']);
                                            }
                                            $theme_arr=array();

                                            $queryall="SELECT g.theme_name
                                                    FROM `exp_distributor_wlan_group_ssid` ss LEFT JOIN `exp_mno_distributor_group_tag` g ON  ss.`group_tag`= g.`tag_name`
                                                        WHERE ss.`distributor`='$user_distributor'";
                                            $results=$db->selectDB($queryall);
                                            foreach($results['data'] AS $rows){
                                                $theme_name=$rows[theme_name];
                                                $theme_name_n=json_decode($theme_name,true)['en'];
                                                array_push($theme_arr, $theme_name_n);
                                            }
                                            //print_r($theme_arr);
                                            ?>

                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <h3>Active <?php echo ucwords(__THEME_TEXT__); ?><img id="campcreate_loader_1" src="img/loading_ajax.gif" style="visibility: hidden;"></h3>
                                                </div>
                                                <div class="widget-content table_response" id="campcreate_div1">
                                                    <div style="overflow-x:auto">
                                                        <table id="active_theme_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><?php echo ucwords(__THEME_TEXT__); ?> Name</th>
                                                                    <?php if ($package_functions->getSectionType('LANGUAGE_ENABLE', $system_package) == '1') { ?>
                                                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Language(s)</th>
                                                                    <?php } ?>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1" style="min-width: 100px;">Test</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Edit</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>
                                                                    <?php if(false){ ?><th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><?php echo ucwords(__THEME_TEXT__); ?> group</th> <?php } ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
$network_name = trim($db->setVal('network_name', 'ADMIN'), "/");
$base_folder_path_preview = $db->setVal('portal_base_folder', 'ADMIN');
$base_folder_path_copy = $db->setVal('portal_base_url', 'ADMIN');

$row3 = $db->select1DB("SELECT p.`redirect_method`,p.`mac_parameter`,p.`ap_parameter`,p.`ssid_parameter`,p.`loc_string_parameter`,p.`network_ses_parameter` ,p.`ip_parameter`

													FROM `exp_network_profile` p WHERE p.`network_profile`='$network_name' LIMIT 1");

$mac_parameter = $row3['mac_parameter'];

                                                                $key_query = "SELECT id,ref_id,theme_id,title, theme_name, `LANGUAGE`, registration_type,create_date,is_enable,language_string,template_name FROM exp_themes
																WHERE distributor = '$user_distributor' AND theme_type = 'MASTER_THEME' ORDER BY ref_id,ABS(is_enable-1) ASC";
                                                                $query_results = $db->selectDB($key_query);

                                                                $array = array();
                                                                
                                                                foreach ($query_results['data'] AS $row) {

                                                                    $auto_id = $row['id'];
                                                                    $location_ssid = $row['ref_id'];
                                                                    $title = $row['title'];
                                                                    $registration_type = $row['registration_type'];
                                                                    $template_name = $row['template_name'];
                                                                    $theme_id = $row['theme_id'];
                                                                    if (in_array($theme_id, $theme_arr)) {
                                                                        $theme_remove='disable';
                                                                    }
                                                                    else{
                                                                         $theme_remove='enable';
                                                                    }
                                                                    $theme_name = $row['theme_name'];
                                                                    $LANGUAGE = $row['LANGUAGE'];
                                                                    $create_date = $row['create_date'];
                                                                    $is_enable = $row['is_enable'];
                                                                    $language_string = $row['language_string'];

                                                                    $them_url=$base_folder_path_copy.'/checkpoint'.$extension.'?'.$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile").'='.$db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1").'&'.$mac_parameter.'=DEMO_MAC&theme='.$theme_id;
                                                                    $them_url_copy=$base_folder_path_copy.'/checkpoint'.$extension.'?'.$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile").'='.$db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1").'&'.$mac_parameter.'=DEMO_MAC&theme='.$theme_id;

                                                                    echo '<tr>
																	<td> ' . $theme_name . ' </td>';

                                                                    if ($package_functions->getSectionType('LANGUAGE_ENABLE', $system_package) == '1') {

                                                                        echo '<td> ';

                                                                        //$theme_name =addslashes($theme_name);

                                                                        $list_lan_q = "SELECT `language`, `is_enable` FROM exp_themes WHERE ref_id = '$theme_id'";

                                                                        $list_lan_r = $db->selectDB($list_lan_q);

                                                                        $list_count = $list_lan_r['rowCount'];



                                                                        if ($list_count > 0) {



                                                                            $str = "<ul>";

                                                                            $str .= "<li> English </li>";



                                                                            
                                                                            foreach ($list_lan_r['data'] AS $rrrr) {

                                                                                $rr_language = $rrrr[language];

                                                                                $rr_is_enable = $rrrr[is_enable];



                                                                                $query_lan = "SELECT language FROM system_languages WHERE language_code = '$rr_language'";

                                                                                $r = $db->select1DB($query_lan);

                                                                                //$r = mysql_fetch_array($result_lan);

                                                                                $lan = $r[language];



                                                                                if ($rr_is_enable == 1) {

                                                                                    //$chek='checked';

                                                                                    $str .= "<li>" . $lan . " - <font color=green><strong>ENABLED</strong></font></li>";
                                                                                } else {

                                                                                    //$chek='';

                                                                                    $str .= "<li>" . $lan . " - <font color=red><strong>DISABLED</strong></font></li>";
                                                                                }

                                                                                //  echo   '<a id="EN_DIS_'.$auto_id.'"><input '.$chek.' onchange="changePasscodeM()" id="EN_DIS1_'.$auto_id.'" type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-width="60"></a>';



                                                                            }

                                                                            echo '<a id="' . str_replace(" ", "", $auto_id) . '">View </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';

                                                                            echo '<script>

                                                                                $(document).ready(function() {



                                                                                    $(\'#' . str_replace(" ", "", $auto_id) . '\').tooltipster({

                                                                                        content: $("' . $str . '"),

                                                                                        theme: \'tooltipster-shadow\',

                                                                                        animation: \'grow\',

                                                                                        onlyOne: true,

                                                                                        trigger: \'click\'



                                                                                    });





                                                                                });

                                                                            </script>';
                                                                        } else {

                                                                            echo 'English &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                                                                        }

                                                                        echo '<a href="?add_new_lan=new&token=' . $secret . '&id=' . $theme_id . '"><i class="icon-plus"></i></a></td>

																	 ';
                                                                    }

                                                                    if ($ori_user_type != 'SALES') {
                                                                        /*if ($is_enable == 1) {

                                                                            //echo '<td><font color=green><strong>ENABLED</strong></font></td>';

                                                                            echo   '<td><div class="toggle1"><input checked onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox"><span class="toggle1-on">ON</span>
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



																		window.location = "?t=manageTheme&token=' . $secret . '&modify=2&is_enable=0&id=' . $auto_id . '&ssid=' . $location_ssid . '&theme_name=' . addslashes($theme_name) . '"

																		});

																		});

																	</script>';
                                                                        } else {

                                                                            // echo '<td><font color=red><strong>DISABLED</strong></font></td>';

                                                                            echo   '<td><div class="toggle1"><input onchange="" type="checkbox" class="hide_checkbox">
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

																			window.location = "?t=manageTheme&token=' . $secret . '&modify=2&is_enable=1&id=' . $auto_id . '&theme_name=' . addslashes($theme_name) . '"

																		});

																		});

																	</script>';}*/

                                                                            echo '<script type="text/javascript">

                                                                $(document).ready(function() {

                                                                    $(\'#RE_' . $theme_id . '\').easyconfirm({locale: {

                                                                            title: \'Remove ' . ucwords(__THEME_TEXT__) . '\',

                                                                            text: \'Are you sure you want to remove this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#RE_' . $theme_id . '\').click(function() {

                                                                            window.location = "?t=manageTheme&token=' . $secret . '&remove=1&id=' . $theme_id . '&theme_name=' . urlencode(addslashes($theme_name)) . '&lan=' . $LANGUAGE . '"

                                                                        });

                                                                        });

                                                                    </script>';

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

                                                                            echo   '<td><div class="toggle1"><input checked onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox"><span class="toggle1-on">ON</span>
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



																		window.location = "?t=manageTheme&token=' . $secret . '&modify=2&is_enable=0&id=' . $auto_id . '&ssid=' . $location_ssid . '&theme_name=' . addslashes($theme_name) . '"

																		});

																		});

																	</script>';
                                                                        } else {

                                                                            // echo '<td><font color=red><strong>DISABLED</strong></font></td>';

                                                                            echo   '<td><div class="toggle1"><input onchange="" type="checkbox" class="hide_checkbox">
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

																			window.location = "?t=manageTheme&token=' . $secret . '&modify=2&is_enable=1&id=' . $auto_id . '&theme_name=' . addslashes($theme_name) . '"

																		});

																		});

																	</script>';

                                                                            echo '<script type="text/javascript">

                                                                $(document).ready(function() {

                                                                    $(\'#RE_' . $theme_id . '\').easyconfirm({locale: {

                                                                            title: \'Remove ' . ucwords(__THEME_TEXT__) . '\',

                                                                            text: \'Are you sure you want to remove this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#RE_' . $theme_id . '\').click(function() {

                                                                            window.location = "?t=manageTheme&token=' . $secret . '&remove=1&id=' . $theme_id . '&theme_name=' . urlencode(addslashes($theme_name)) . '&lan=' . $LANGUAGE . '"

                                                                        });

                                                                        });

                                                                    </script>';
                                                                        }
                                                                    }

                                                                    echo '</td><td>';
                                                                    echo '<a class="btn btn-info" target="_blank" href="'.$them_url.'">Test</a>';
                                                                   
                                                                    echo '<i data-toggle="tooltip" title="You can copy and paste the below URL in an email, messenger etc., to allow anyone anywhere to test the end-to-end experience on a device of their choice." 
                                                                    class="icon-copy show red-url highlight tooltip_hide tooltips tooltipstered" onclick="(function(){
                                                                        var value = \''.$them_url_copy.'\';
                                                                         
                                                                         var $temp = $(\'<input>\');
                                                                         $(\'body\').append($temp);
                                                                         $temp.val(value).select();
                                                                         document.execCommand(\'copy\');
                                                                         $temp.remove();
                                                                         myFunction()
                                                                       return false;
                                                                   })();" 
                                                                   data-uri="'.$them_url_copy.'"></i>';
                                                                   
                                                                    echo '</td><td>';
                                                                    echo '<a id="CM_' . $theme_id . '"  class="btn btn-small btn-primary"><i class="btn-icon-only icon-wrench"></i>Edit&nbsp;</a><script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#CM_' . $theme_id . '\').easyconfirm({locale: {

																			title: \'Manage ' . ucwords(__THEME_TEXT__) . ' [' . str_replace("'", " ", $theme_name) . ']\',

																			text: \'Are you sure you want to modify this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#CM_' . $theme_id . '\').click(function() {
																			window.location = "?t=createTheme&modify_s=1&id=' . $theme_id . '&lan=' . $LANGUAGE . '"
																		});
																		});

																	</script>';

                                                                    echo '</td><td>';

                                                                    if ($theme_remove=='enable') {
                                                                        echo '<a id="RE_' . $theme_id . '"  class="btn btn-small btn-danger"><i class="btn-icon-only icon-trash"></i>Remove&nbsp;</a>';
                                                                    }else{
                                                                    echo '<a id="REE_' . $theme_id . '"  class="btn  btn-danger" Disabled><i class="btn-icon-only icon-trash"></i>Remove&nbsp;</a>'; }
                                                                    /*JavaScript part move in to is_enable if condition else part*/

                                                                    if (in_array("THEME_IMPORT", $features_array) || $package_features == "all") {
                                                                        echo '<a id="DOWN_' . $theme_id . '"  class="btn btn-small btn-warning"><i class="btn-icon-only icon-download-alt"></i>Export</a><script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#DOWN_' . $theme_id . '\').easyconfirm({locale: {

																			title: \'Export ' . ucwords(__THEME_TEXT__) . '\',

																			text: \'Are you sure,you want to export this ' . __THEME_TEXT__ . '?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#DOWN_' . $theme_id . '\').click(function() {

																			window.location = "ajax/download_theme.php?&theme_id=' . $theme_id . '"

																		});

																		});

																	</script></td>';
                                                                    }


                                                                    if(false){ echo '<td>'; ?>
                                                                    <form id="add_group_tag_fo" name="add_group_tag_fo" method="post" action="theme.php">
                                                                        <select class="span2" id="grop_tag" name="grop_tag">

                                                                            <option value="">Select Group</option>
                                                                            <?php
                                                                                $qu_group = "SELECT * FROM `exp_mno_distributor_group_tag` WHERE `distributor` = '$user_distributor' ";
                                                                                $qu_group_ex = $db->selectDB($qu_group);
                                                                                
                                                                                foreach ($qu_group_ex['data'] AS $row_tag_name) {

                                                                                    $tag_name = $row_tag_name['tag_name'];
                                                                                    $tag_id = $row_tag_name['id'];
                                                                                    $tag_theme_name = $row_tag_name['theme_name'];
                                                                                    $th_get = json_decode($tag_theme_name, true);

                                                                                    $theme_id_gr = $th_get['en'];
                                                                                    ?>
                                                                                <option <?php if ($theme_id == $theme_id_gr) {
                                                                                                    echo 'selected';
                                                                                                } ?> value="<?php echo $tag_id; ?>"><?php echo $tag_name; ?></option>

                                                                            <?php
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                        <input type="hidden" id="theme_id_v" name="theme_id_v" value="<?php echo $theme_id; ?>">
                                                                        <button type="submit" name="add_group_tag" id="add_group_tag" class="btn btn-primary">Save</button>
                                                                    </form>

                                                                <?php echo '	</td>'; }
																									echo '</tr>';
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1000);
}
</script>

<div id="snackbar">copied</div>