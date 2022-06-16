<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);
require_once __DIR__.'/../../classes/systemPackageClass.php';
require_once __DIR__.'/../../src/AP/apClass.php';
$ap_class = new apClass();
$wag_obj = $ap_class->getControllerInst();
$pack_func = new package_functions();
$aaa_preview_version = $pack_func->getOptions('AAA_PREVIEW_VERSION',$system_package);

if($aaa_preview_version == 'ALE_V5'){
$redirection_from = 'ALE_V5';
$reditection = 'CAPTIVE_ALE5_REDIRECTION';
}
else{
$redirection_from = 'ALE_V4';
$reditection = 'CAPTIVE_ALE4_REDIRECTION';
}

$admin_product = $pack_func->getAdminPackage();
$redirection_parameters = $pack_func->getOptions($reditection,$admin_product);
/*
$network_name = trim($db->setVal('network_name','ADMIN'),"/");
$get_parametrs=mysql_query("SELECT p.`redirect_method`,p.`mac_parameter`,p.`ap_parameter`,p.`ssid_parameter`,p.`loc_string_parameter`,p.`network_ses_parameter` ,p.`ip_parameter`
FROM `exp_network_profile` p WHERE p.`network_profile`='$network_name' LIMIT 1");

$row3=mysql_fetch_array($get_parametrs);
*/

if(strlen($redirection_parameters)=='0'){
$redirection_parameters = '{"mac_parameter":"client_mac","ap_parameter":"ap","ssid_parameter":"ssid","ip_parameter":"IP","loc_string_parameter":"0","network_ses_parameter":"0","group_parameter":"realm","other_parameters":"0"}';
}
$red_decode = (array)json_decode($redirection_parameters);


$network_ses_parameter = $red_decode['network_ses_parameter'];
$ip_parameter = $red_decode['ip_parameter'];
$mac_parameter = $red_decode['mac_parameter'];
$loc_string_parameter = $red_decode['loc_string_parameter'];
$group_parameter = $red_decode['group_parameter'];
$ap_parameter=$red_decode['ap_parameter'];
$ssid_parameter=$red_decode['ssid_parameter'];


$isdynamic =$pack_func->isDynamic($system_package);
$SSL_ON=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='SSL_ON' LIMIT 1");

if($SSL_ON!='1'){
$pageURL = "http://";
}else{
$pageURL = "https://";
}


if ($_SERVER["SERVER_PORT"] != "80"){
$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
}
else{
$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

$base_folder_path_preview = $db->setVal('portal_base_folder', 'ADMIN');

?>
<div <?php if (isset($tab_service_area_pr)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="service_area_pr">

<div id="messageSpan"></div>
  <?php
                                            if (isset($_SESSION['manage_SSID_splash'])) {

                                                echo $_SESSION['manage_SSID_splash'];

                                                unset($_SESSION['manage_SSID_splash']);
                                            }
                                            if ($isdynamic) {?>
                                                
<h2 class="head">
    Manage SSID by Service Area. <img data-toggle="tooltip" title="A Service Area is a set of grouped Access Points, you can select which Networks (SSID) that should show in which Service Area. You can add multiple Networks to a single Service Area by clicking the plus sign and select the Service Area from the dropdown, then select the Network from the dropdown." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">
</h2>
                                            
                                            <?php } else{?>

<h1 class="head">
    Manage SSID by Service Area. <img data-toggle="tooltip" title="A Service Area is a set of grouped Access Points, you can select which Networks (SSID) that should show in which Service Area. You can add multiple Networks to a single Service Area by clicking the plus sign and select the Service Area from the dropdown, then select the Network from the dropdown." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>
                                            <?php }?>


<br>
</br>

<?php

$secret=md5(uniqid(rand(), true));

$_SESSION['FORM_SECRET'] = $secret;

	                            ?>
<div class="widget widget-table action-table">
        <div class="widget-header">
        </div>
<div class="widget-content table_response " style="position: relative;">
                                                    <div style="overflow-x:auto;" >
                                                        <table id="group_tag_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" style="min-width: 215px;">Service Area</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">SSID Broadcast</th>

                                                                <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Edit</th> -->
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>


                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            <?php
                                                            $queryall="SELECT a.id,b.network_id,a.distributor,b.ssid,a.wlan_group_id,a.ap_group_id FROM exp_distributor_wlan_group_ssid a
    JOIN exp_locations_ssid_private b ON
        a.network_id=b.network_id
            AND a.distributor=b.distributor
WHERE a.distributor='$user_distributor'";
                                															$results=$db->selectDB($queryall);
                                                                                           $a=$results['rowCount'];
                                															$query="SELECT * FROM `exp_distributor_ap_group` WHERE `distributor`='$user_distributor' AND `name`!='default'";
                                                                                            $resultnew=$db->selectDB($query);

                                															$query2="SELECT * FROM `exp_locations_ssid_private` WHERE `distributor`='$user_distributor'";
                                                                                            $resultnew2=$db->selectDB($query2);


                                                             
                                                             $i=0;
                                                             foreach($results['data'] AS $rows){
                                                             	$wlan_group=$rows[Wlan_group];
                                                             	$ap_group_id=$rows[ap_group_id];
                                                             	$ssid_network=$rows[network_id];
                                                                $id_new=$rows[id];


                                                            //print_r($arry_asign);
                                                            echo '<form id="theme_ap_form'.$i.'" name="theme_ap_form'.$i.'" method="post" action="service_area?t=service_area_pr">';
                                                            echo '<tr>';
															    echo '<td><select class="span2" onchange="change_Ap(\''.$i.'\');" id="ap_group_id_'.$i.'" name="ap_group_id_'.$i.'">';

															    
                                                            foreach($resultnew['data'] AS $row){
                                                            	$group_id=$row[group_id];
                                                            	$group_name=$row[name];
                                                            	if ($group_id==$ap_group_id) {
                                                            		echo '<option selected value="'.$group_id.'">'.$group_name.'</option>';
                                                            	}else{
                                                            		echo '<option value="'.$group_id.'">'.$group_name.'</option>';
                                                            	}
                                                            	
 
                                                            }
                                                            echo '</select>';
                                                            if ($i==($a-1)) {
                                                            	echo '<button style="margin-left:7px;" id="add_row" class="btn btn-primary btn-xs clone-button btn-add add_row" type="button"  >+</button></td>';
                                                            }else{
                                                            	echo '</td>';
                                                            }


															 echo '<td><select class="span2" id="ap_ssid_id_'.$i.'" name="ap_ssid_id_'.$i.'">';
                                                            foreach($resultnew2['data'] AS $row){
                                                            	$ssid=$row[ssid];
                                                            	$network_id=$row[network_id];
                                                            	
                                                            	if ($network_id==$ssid_network) {
                                                            		echo '<option selected value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';
                                                            	}else{
                                                                    if (!in_array($network_id, $arry_asign)) {
                                                                        echo '<option value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';
                                                                    }
                                                            		
                                                            	}
 
                                                            }
                                                            echo '</select><button style="margin-left:7px;" type="submit" name="save_new_tag" id="save_new_tag'.$i.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Update</button><img style="display:none;" data-ref="save_new_tag'.$i.'"  src="img/loading_ajax.gif">';
                                                                 echo '<script type="text/javascript">
                                                            
                                                              $(\'#save_new_tag' . $i . '\').click(function(e) {
                                                               var ap_ssid_id = document.getElementById("ap_ssid_id_"+' . $i . ').value;
                                                               
                                                               if (ap_ssid_id =="") {
                                                                    testNEW(e);
                                                                    e.preventDefault();
                                                                  }else{

                                                                    go(\''.$i.'\');
                                                                  }
                                                                
                                                              });

                                                            </script>  '; 
                                                              echo '</td>';




                                                                    
                                                                   


                                                                    ////////////////////////////////
                                                                    
                                                    echo '<td><button type="submit" name="remove_group" id="remove_group_'.$i.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Remove</button>';
                                                                    
                                                                    echo '
                            <script type="text/javascript">
                            $(document).ready(function() {
							$(\'#remove_group_' . $i . '\').easyconfirm({locale: {
									title: \'Remove SSID FROM Service Area\',
									text: \'Are you sure you want to Remove?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
									button: [\'Cancel\',\' Confirm\'],
									closeText: \'close\'
									 }});
								$(\'#remove_group_' . $i . '\').click(function() {
								});
								});
							</script></td>';





                                                echo '</td>';

              ///////////////////////////////

                                                                    echo '<input type="hidden" name="form_secret" id="form_secret'.$i.'" value="' . $_SESSION['FORM_SECRET_N'] . '" />';
                                                                    echo '<input type="hidden" name="id_new'.$i.'" id="id_new'.$i.'" value="' . $id_new . '" />';
                                                                    echo '<input type="hidden" name="theme_type" id="theme_type'.$i.'" value="new" />';
                                                                    echo '<input type="hidden" name="row_number" id="row_number'.$i.'" value="' . $i . '" />';
                                                                    echo '<input type="hidden" name="old_ap_group_id_'.$i.'" id="old_ap_group_id_'.$i.'" value="' . $ap_group_id . '" />';
                                                                    echo '<input type="hidden" name="old_network_id'.$i.'" id="old_network_id'.$i.'" value="' . $ssid_network . '" />';
                                                                    echo '<input type="hidden" name="old_group_tag'.$i.'" id="old_group_tag'.$i.'" value="' . $group_tag . '" />';
                                                                    echo '<input type="hidden" name="old_theme_id'.$i.'" id="old_theme_id'.$i.'" value="' . $theme_id_N . '" />';

                                                                                                //////////////////////////////////
                            ?>
                                                            <script type="text/javascript">
                                                                function testNEW(elm){
                                                            //console.log(elm.id);
                                                                elm.disabled = false;
                                                                $("img[data-ref='"+elm.id+"']").hide();
                                                                $('#ap_id').empty();
                                                                $('#ap_id').append('Please Select SSID');
                                                                $('#servicearr-check-div').show();
                                                                $('#sess-front-div').show();
                                                              
                                                            }
                                                            function go(i){
                                                                $("img[data-ref='save_new_tag"+i+"']").show();
                                                                
                                                            }


                                                            function change_Ap(i) {
                                                              //var x="<?php echo $i; ?>"
                                                              var ap_group_id = document.getElementById("ap_group_id_"+i).value;
                                                              var scrt_var="scrt_ssid_pr";
                                                              $("#ap_ssid_id_"+i).empty();
                                                              $.ajax({
                                                                type: 'POST',
                                                                url: 'ajax/get_ap_ssid.php',
                                                                data: { ap_group_id: ap_group_id, ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,user_distributor:"<?php echo $user_distributor; ?>"},
                                                                success: function(data) {
                                                                    $("#ap_ssid_id_"+i).empty();

                                                                    $("#ap_ssid_id_"+i).append(data);


                                                                    //document.getElementById("zones_loader").innerHTML = "";

                                                                },
                                                                error: function(){
                                                                    //document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                                }

                                                            });
                                                            }
                                                             </script>
                                                             <?php 
                                                            echo '</form>';
                                                                    echo '</tr>';

                                                                
															$i=$i+1;
                                                            }
                                                            if ($a==0) {
                                                            	echo '<tr>';
                                                            /*echo '<form id="theme_ap_form'.$i.'" name="theme_ap_form'.$i.'" method="post" action="theme?t=manage_SSID_splash">';*/
															echo '<td><select class="span2" id="ap_group_id_'.$i.'" name="ap_group_id_'.$i.'">';
                                                            echo '<option value="all">All Ap Group</option>';
                                                            foreach($resultnew['data'] AS $row){
                                                            	$group_id=$row[group_id];
                                                            	$group_name=$row[name];

                                                            	echo '<option value="'.$group_id.'">'.$group_name.'</option>';

                                                            	
 
                                                            }
                                                            echo '</select>';

                                                            if ($resultnew['rowCount']>0) {
                                                            	echo '<button style="margin-left:7px;" id="add_row" class="btn btn-primary btn-xs clone-button btn-add add_row" type="button"  >+</button></td>';
                                                            }
                                                            
                                                            
                                                            
															echo '<td><select class="span2" id="ap_ssid_id_'.$i.'" name="ap_ssid_id_'.$i.'">';
                                                            foreach($resultnew2['data'] AS $row){
                                                            	$ssid=$row[ssid];
                                                            	$network_id=$row[network_id];
                                                            	echo '<option value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';

 
                                                            }
                                                            echo '</select>
                                                                <button style="margin-left:7px;" onclick="test(this);"  type="button" name="save_new_tag" id="save_new_tag'.$i.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Update</button><img style="display:none;" data-ref="save_new_tag'.$i.'"  src="img/loading_ajax.gif">';
                                                            // echo '<script type="text/javascript">
                                                            //               $(document).ready(function() {
                                                            // $(\'#save_new_tag' . $i . '\').easyconfirm({locale: {
                                                            //     title: \'Update Theme Group\',
                                                            //     text: \'Are you sure you want to Update?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            //     button: [\'Cancel\',\' Confirm\'],
                                                            //     closeText: \'close\'
                                                            //      }});
                                                            //   $(\'#save_new_tag' . $i . '\').click(function() {
                                                            //     test();
                                                            //   });
                                                            //   });
                                                            // </script>                                                             
                                                            //   </td>';
                                                           
                                                            echo '<td></td>';
                                                             echo '<input type="hidden" name="form_secret" id="form_secret'.$i.'" value="' . $_SESSION['FORM_SECRET_N'] . '" />';
                                                            echo '<input type="hidden" name="row_number" id="row_number'.$i.'" value="' . $i . '" />';
                                                            /*echo '</form>';*/
                                                            echo '</tr>';
                                                           
                                                            }
                                                            $rowdata='<tr>';
                                                            $rowdata.='<td><select class="span2" onchange="change_Ap_group('.$i.');" name="ap_group_id_'.$i.'" id="ap_group_id_'.$i.'">';
                                                            $rowdata.='<option value="all">All AP Groups</option>';
                                                            foreach($resultnew['data'] AS $row){
                                                            	$group_id=$row[group_id];
                                                            	$group_name = str_replace("'","\'",$row[name]);
                                                            	$rowdata.='<option value="'.$group_id.'">'.$group_name.'</option>';
 
                                                            }
                                                            $rowdata.='</select><button style="margin-left:7px;" id="add_row" class="btn btn-primary btn-xs clone-button btn-add" type="button" onclick="add_row()">+</button></td>';
                                                            $rowdata.='<td><select class="span2" id="ap_ssid_id_'.$i.'" name="ap_ssid_id_'.$i.'">';
                                                            foreach($resultnew2['data'] AS $row){
                                                            	$ssid=$row[ssid];
                                                                $network_id=$row[network_id];
                                                            	$rowdata.='<option value="'.$ssid.'@'.$network_id.'">'.$ssid.'</option>';
 
                                                            }

                                                            $rowdata.='</select><button style="margin-left:7px;" onclick="test(this);"  type="button" name="save_new_tag" id="save_new_tag'.$i.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Update</button><img style="display:none;" data-ref="save_new_tag'.$i.'"  src="img/loading_ajax.gif"></td>';
                                                            $rowdata.='<td></td>';

                                                            
                                                                    
                                                     $rowdata.= '</tr>';
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                        <script type="text/javascript" id="confirm_script">
                                                            /*$(document).ready(function() {            
                                                            var x=<?php echo $i; ?>;
                                                            
                                                              $("#save_new_tag"+ x).click(function(e) {
                                                                test(e);
                                                              });
                                                              });*/
                                                            </script>                                                             
                                                              </td>
                                                        <script type="text/javascript">
                                                          function test(elm){
                                                            elm.disabled = true;
                                                            $("img[data-ref='"+elm.id+"']").show();
                                                            var x=<?php echo $i; ?>;
                                                              var ap_group_id = document.getElementById("ap_group_id_"+x).value;
                                                              var ap_ssid_id = document.getElementById("ap_ssid_id_"+x).value;
                                                              if (ap_group_id =="") {
                                                                $('#ap_id').empty();
                                                                $('#ap_id').append('Please Select Ap Group');
                                                                $('#servicearr-check-div').show();
                                                                $('#sess-front-div').show();
                                                                elm.disabled = false;
                                                                $("img[data-ref='"+elm.id+"']").hide();
                                                              }else if (ap_ssid_id =="") {
                                                                $('#ap_id').empty();
                                                                $('#ap_id').append('Please Select SSID');
                                                                $('#servicearr-check-div').show();
                                                                $('#sess-front-div').show();
                                                                elm.disabled = false;
                                                                $("img[data-ref='"+elm.id+"']").hide();
                                                              }else{
                                                              var zone_id = '<?php echo $zone_id; ?>';
                                                              
                                                              var scrt_var="create_pr";
                                                              $.ajax({
                                                                type: 'POST',
                                                                url: 'ajax/get_ap_ssid.php',
                                                                data: { ap_group_id: ap_group_id,ap_ssid_id: ap_ssid_id,zone_id: zone_id, ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,user_distributor:"<?php echo $user_distributor; ?>"},
                                                                success: function(data) {
                                                                  window.location = "?t=service_area_pr";
                                                                },
                                                                error: function(){
                                                                    //document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                                }

                                                            });
                                                            }
                                                            
                                                          }
                                                          function change_Ap_group(i) {
                                                              var x=<?php echo $i; ?>;
                                                              $("#ap_ssid_id_"+i).empty();
                                                              var ap_group_id = document.getElementById("ap_group_id_"+x).value;
                                                              var scrt_var="scrt_ssid_pr";
                                                              $.ajax({
                                                                type: 'POST',
                                                                url: 'ajax/get_ap_ssid.php',
                                                                data: { ap_group_id: ap_group_id, ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,user_distributor:"<?php echo $user_distributor; ?>"},
                                                                success: function(data) {
                                                                    $("#ap_ssid_id_"+x).empty();

                                                                    $("#ap_ssid_id_"+x).append(data);


                                                                    //document.getElementById("zones_loader").innerHTML = "";

                                                                },
                                                                error: function(){
                                                                    //document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                                }

                                                            });
                                                            }

                                                            
                                                        	$(".add_row").on('click',function(){ 

                                                            var elem = document.getElementById('add_row');
                                                             elem.parentNode.removeChild(elem);
                                                        		var row='<?php echo $rowdata; ?>';
                                                            $('#group_tag_table').append(row);
                                                            new Tablesaw.Table("#group_tag_table").destroy();
                                                            Tablesaw.init();
                                                            $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;''></label>");

                                    eval(document.getElementById('confirm_script').innerHTML);
                                    
                            
                                  });
                                  
                                  function add_row(){ 

                                    var elem = document.getElementById('add_row');
                                        elem.parentNode.removeChild(elem);
                                    var row='<?php echo $rowdata; ?>';
                                    $('#group_tag_table').append(row);
                                    new Tablesaw.Table("#group_tag_table").destroy();
                                    Tablesaw.init();
                                    $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;''></label>");


                            
                                  }
                                                        </script>
                                                    </div>
                                                </div>
</div>
<script id="tootip_script">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
