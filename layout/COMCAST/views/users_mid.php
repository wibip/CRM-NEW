
<div class="main">

		<div class="main-inner">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="widget ">

							<div class="widget-header">
								<!-- <i class="icon-user"></i> -->
								<h3>Roles Management</h3>
							</div>
							<!-- /widget-header -->

										<?php
										   if(isset($_SESSION['msg5'])){
											   echo $_SESSION['msg5'];
											   unset($_SESSION['msg5']);


											  }

										   if(isset($_SESSION['msg1'])){
											   echo $_SESSION['msg1'];
											   unset($_SESSION['msg1']);


											  }


												   if(isset($_SESSION['msg2'])){
													   echo $_SESSION['msg2'];
													   unset($_SESSION['msg2']);


													  }

												   if(isset($_SESSION['msg3'])){
													   echo $_SESSION['msg3'];
													   unset($_SESSION['msg3']);


													  }

												   if(isset($_SESSION['msg6'])){
													   echo $_SESSION['msg6'];
													   unset($_SESSION['msg6']);


													  }
											      ?>

							<div class="widget-content">



								<div class="tabbable">
									<ul class="nav nav-tabs">
										<li <?php if(isset($tab1) || isset($tab5)){?>class="active" <?php }?>><a href="#create_users" data-toggle="tab">Manage Users</a></li>
										<li <?php if(isset($tab3)){?>class="active" <?php }?>><a href="#create_roles" data-toggle="tab">Manage Roles</a></li>

    								<?php if($user_type!='SUPPORT'){ ?>

    									<li <?php if(isset($tab6)){?>class="active" <?php }?>><a href="#peer_admin" data-toggle="tab">Create Master Admin</a></li>

    								<?php } ?>

									</ul>

									<br>







							<div class="tab-content">








									<!-- +++++++++++++++++++++++++++++ create users ++++++++++++++++++++++++++++++++ -->
								<div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="create_users">
									<div id="response_d3">

								  	</div>

										<form autocomplete="off" id="edit_profile" action="users.php" method="post" class="form-horizontal" >




											<fieldset>
												<div class="control-group">

													<div class="controls col-lg-5 form-group">
													<label class="" for="access_role_1">Access Role<sup><font color="#FF0000" ></font></sup></label>
															<select class="span4 form-control" name="access_role_1" id="access_role_1">
																<option value="">Select Access Role</option>
															<?php


															if($user_type=='MNO'){
															//echo '<option value="'.$user_distributor.'_support">Support</option>';
															}

															//$key_query = "SELECT access_role,description FROM admin_access_roles WHERE distributor = '$user_distributor' ORDER BY description";

															if($user_type=='SUPPORT'){

																$key_query ="SELECT a.`access_role` ,a.description
																FROM `admin_access_roles` a , `admin_access_roles_modules` b
																WHERE a.`distributor` ='$user_distributor' AND a.`distributor`=b.`distributor` AND b.`module_name`='support' AND a.`access_role`=b.`access_role`
																GROUP BY a.`access_role` ORDER BY description";

															}else{
																$key_query = "SELECT `access_role` ,description
																FROM `admin_access_roles`
																WHERE `distributor` ='$user_distributor' ORDER BY description";
															}


															$query_results=mysql_query($key_query);
															while($row=mysql_fetch_array($query_results)){
																$access_role = $row[access_role];
																$description = $row[description];

																echo '<option value="'.$access_role.'">'.$description.'</option>';
															}

															?>

															</select>

													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->

												<?php
													echo '<input type="hidden" name="user_type" id="user_type1" value="'.$user_type.'">';
												 ?>

												<?php
													echo '<input type="hidden" name="loation" id="loation1" value="'.$user_distributor.'">';
												 ?>

												<div class="control-group">

													<div class="controls col-lg-5 form-group">
													<label class="" for="full_name_1">Full Name<sup><font color="#FF0000" ></font></sup></label>
															<input class="form-control span4" id="full_name_1" name="full_name_1" maxlength="25" type="text">
                                                    </div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->


												<div class="control-group">

													<div class="controls form-group col-lg-5">
													<label class="" for="email_1">Email<sup><font color="#FF0000" ></font></sup></label>
															<input class="form-control span4" id="email_1" name="email_1" placeholder="name@mycompany.com">
													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->


												<div class="control-group">

													<div class="controls form-group col-lg-5">
													<label class="" for="language_1">Language</label>
															<select class="form-control span4" name="language_1" id="language_1">

															<?php


															$key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";

															$query_results=mysql_query($key_query);
															while($row=mysql_fetch_array($query_results)){
																$language_code = $row[language_code];
																$language = $row[language];
																echo '<option value="'.$language_code.'">'.$language.'</option>';


															}

															?>

															</select>

													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->


												<div class="control-group">

													<div class="controls form-group col-lg-5">
													<label class="" for="mobile_1">Phone Number<sup><font color="#FF0000" ></font></sup></label>

															<input class="form-control span4" id="mobile_1" name="mobile_1" type="text" placeholder="xxx-xxx-xxxx" maxlength="12">


													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->
	                                   <script type="text/javascript">

                                        $(document).ready(function() {

											$("#mobile_1").keypress(function(event){
                                                                var ew = event.which;
																//alert(ew);
                                                                //if(ew == 8||ew == 0||ew == 46||ew == 45)
                                                                //if(ew == 8||ew == 0||ew == 45)
                                                                if(ew == 8||ew == 0)
                                                                    return true;
                                                                if(48 <= ew && ew <= 57)
                                                                    return true;
                                                                return false;
                                                            }); 

                                            $('#mobile_1').focus(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
                                            });

                                            $('#mobile_1').keyup(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
                                            });

                                            $("#mobile_1").keydown(function (e) {


                                                var mac = $('#mobile_1').val();
                                                var len = mac.length + 1;
                                                //console.log(e.keyCode);
                                                //console.log('len '+ len);

                                                if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                    mac1 = mac.replace(/[^0-9]/g, '');


                                                    //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                    //console.log(valu);
                                                    //$('#phone_num_val').val(valu);

                                                }
                                                else{

                                                    if(len == 4){
                                                        $('#mobile_1').val(function() {
                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                            //console.log('mac1 ' + mac);

                                                        });
                                                    }
                                                    else if(len == 8 ){
                                                        $('#mobile_1').val(function() {
                                                            return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                            //console.log('mac2 ' + mac);

                                                        });
                                                    }
                                                }

												//alert(e.keyCode);
                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
												//alert(e.keyCode);
                                             /*    if ($.inArray(e.keyCode, [8, 9, 27, 13]) !== -1 ||
                                                            // Allow: Ctrl+A, Command+A
                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+C, Command+C
                                                        (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+x, Command+x
                                                        (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+V, Command+V
                                                        (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: home, end, left, right, down, up
                                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    // let it happen, don't do anything
                                                    return;
                                                }
                                                // Ensure that it is a number and stop the keypress
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
													if(e.keyCode == 50){
														return false;
													}else{
                                                                   
                                                    e.preventDefault();
													}
                                                }
 */
											 	

                                                $('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');

                                            });


                                        });






                                        $(document).ready(function() {

                                            $('#mobile_2').focus(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#edit-user-profile').data('bootstrapValidator').updateStatus('mobile_2', 'NOT_VALIDATED').validateField('mobile_2');
                                            });

                                            $('#mobile_2').keyup(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#edit-user-profile').data('bootstrapValidator').updateStatus('mobile_2', 'NOT_VALIDATED').validateField('mobile_2');
                                            });

                                            $("#mobile_2").keydown(function (e) {


                                                var mac = $('#mobile_2').val();
                                                var len = mac.length + 1;
                                                //console.log(e.keyCode);
                                                //console.log('len '+ len);

                                                if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                    mac1 = mac.replace(/[^0-9]/g, '');


                                                    //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                    //console.log(valu);
                                                    //$('#phone_num_val').val(valu);

                                                }
                                                else{

                                                    if(len == 4){
                                                        $('#mobile_2').val(function() {
                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                            //console.log('mac1 ' + mac);

                                                        });
                                                    }
                                                    else if(len == 8 ){
                                                        $('#mobile_2').val(function() {
                                                            return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                            //console.log('mac2 ' + mac);

                                                        });
                                                    }
                                                }


                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                               /*  if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
                                                            // Allow: Ctrl+A, Command+A
                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+C, Command+C
                                                        (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+x, Command+x
                                                        (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+V, Command+V
                                                        (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: home, end, left, right, down, up
                                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    // let it happen, don't do anything
                                                    return;
                                                }
                                                // Ensure that it is a number and stop the keypress
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                    e.preventDefault();

                                                } */

												$("#mobile_2").keypress(function(event){
					var ew = event.which;
					//alert(ew);
					//if(ew == 8||ew == 0||ew == 46||ew == 45)
					if(ew == 8||ew == 0)
						return true;
					if(48 <= ew && ew <= 57)
						return true;
					return false;
				});

                                                $('#edit-user-profile').data('bootstrapValidator').updateStatus('mobile_2', 'NOT_VALIDATED').validateField('mobile_2');
                                            });


                                        });

                                        </script>

												<div class="form-actions">
													<button type="submit"  name="submit_1" id="submit_1" class="btn btn-primary">Save & Send Email Invitation</button>&nbsp; <strong><font color="#FF0000"></font><small></small></strong>
												</div>
												<!-- /form-actions -->
											</fieldset>
										</form>

<script type="text/javascript">

$(document).ready(function() {



	document.getElementById("submit_1").disabled = true;

});

function newus_ck(){

	var name=document.getElementById('full_name_1').value;
	var email=document.getElementById('email_1').value;
	var numb=document.getElementById('mobile_1').value;



	if(name==''||email==''||numb==''){
		document.getElementById("submit_1").disabled = true;

		}else{
			document.getElementById("submit_1").disabled = false;

			}

}


</script>










					<div id="response_d3">

								  	</div>

									<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<h3>Active Users</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto;" >
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Username</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Access Role</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Full Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Email</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Created By</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Edit</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Disable</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove</th>


															</tr>
														</thead>
														<tbody>

										<?php

											if($user_type == 'ADMIN'){
												/*echo $key_query = "SELECT id,user_name,full_name, access_role, user_type, user_distributor, email,is_enable,create_user
												FROM admin_users where user_type = '$user_type'  AND user_name<>'$user_name'";*/

												$key_query = "SELECT au.id,au.user_name,au.full_name, au.access_role, au.user_type, au.user_distributor, au.email,au.is_enable,au.create_user
                                                                ,IF(!ISNULL(aar.description),aar.description,IF(au.access_role='admin','Admin','')) AS description
                                                                FROM admin_users au LEFT JOIN admin_access_roles aar ON au.access_role = aar.access_role
                                                                WHERE user_type = '$user_type' AND user_name<>'admin'";
											}elseif($user_type == 'SUPPORT'){
												$key_query ="SELECT a.id,a.user_name,a.full_name, a.access_role, a.user_type, a.user_distributor, a.email,a.is_enable ,a.create_user
                                                  ,IF(!ISNULL(aar.description),aar.description,IF(a.access_role='admin','Admin','')) AS description
													FROM admin_users a LEFT JOIN admin_access_roles aar ON a.access_role=aar.access_role, `admin_access_roles_modules` b
													WHERE user_distributor = '$user_distributor' AND a.`access_role`=b.`access_role` AND b.`module_name`='support' OR user_distributor = 'MNO4' AND a.`user_type`='SUPPORT' AND user_name<>'$user_name'
													GROUP BY `user_name`";
											}
											else{

												 $key_query = "SELECT au.id,au.user_name,au.full_name, au.access_role, au.user_type, au.user_distributor, au.email,au.is_enable,au.create_user
                                                ,IF(!ISNULL(aar.description),aar.description,IF(au.access_role='admin','Admin','')) AS description
												FROM admin_users au LEFT JOIN admin_access_roles aar ON au.access_role = aar.access_role where user_type IN ('$user_type','SUPPORT','TECH') AND user_distributor = '$user_distributor' AND user_name<>'$user_name'";
											}


											//echo $key_query;

											$query_results=$db->selectDB($key_query);
											foreach($query_results['data'] AS $row){
												$id = $row[id];
												$user_name1 = $row[user_name];
												$full_name = $row[full_name];

												$access_role = $row[access_role];
                                                $access_role_desc = $row['description'];

												/*$q_desc_get = "SELECT description FROM `admin_access_roles` WHERE access_role = '$access_role'";
												$query_results_a=mysql_query($q_desc_get);
												while($row1=mysql_fetch_array($query_results_a)){
													$access_role_desc = $row1[description];

												}*/



												$user_type1 = $row[user_type];
												$user_distributor1 = $row[user_distributor];
												$email = $row[email];
												$is_enable=$row[is_enable];

												$create_user=$row[create_user];

												if($user_type1=='TECH'){


													$access_role_desc='Tech Admin';

												}
												else if($user_type1=='SUPPORT'){


													$access_role_desc='Support Admin';

												}


												if($is_enable=='1' || $is_enable=='2'){
												$btn_icon='thumbs-down';
												$show_value='<font color="#00CC00"><strong>Enable</strong></font>';
												$btn_color='warning';
												$btn_title='disable';
												$action_status=0;
												}else{

												$btn_icon='thumbs-up';
												$show_value='<font color="#FF0000"><strong>Disable</strong></font>';
												$btn_color='success';
												$btn_title='enable';
												$action_status=1;
													}

												echo '<tr>
												<td> '.$user_name1.' </td>
												<td> '.$access_role_desc.' </td>
												<td> '.$full_name.' </td>';
												//echo '<td> '.$user_type1.' </td><td> '.$user_distributor1.' </td>';
												echo '<td> '.$email.' </td>';
												echo '<td> '.$create_user.' </td>';

												/////////////////////////////////////////////

												echo '<td><a href="javascript:void();" id="APE_'.$id.'"  class="btn btn-small btn-primary">
												<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
												$(document).ready(function() {
												$(\'#APE_'.$id.'\').easyconfirm({locale: {
														title: \'Edit User\',
														text: \'Are you sure you want to edit this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
														button: [\'Cancel\',\' Confirm\'],
														closeText: \'close\'
													     }});
													$(\'#APE_'.$id.'\').click(function() {
														window.location = "?token='.$secret.'&t=5&edit_id='.$id.'"
													});
													});
												</script></td><td><a href="javascript:void();" id="LS_'.$id.'"  class="btn btn-small btn-'.$btn_color.'">
	                                            <i class="btn-icon-only icon-'.$btn_icon.'"></i>&nbsp;'.ucfirst($btn_title).'</a><script type="text/javascript">
	                                            $(document).ready(function() {
	                                            $(\'#LS_'.$id.'\').easyconfirm({locale: {
	                                                    title: \''.ucfirst($btn_title).' User\',
	                                                    text: \'Are you sure you want to '.$btn_title.' this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
	                                                    button: [\'Cancel\',\' Confirm\'],
	                                                    closeText: \'close\'
	                                                     }});
	                                                $(\'#LS_'.$id.'\').click(function() {
	                                                    window.location = "?token='.$secret.'&t=1&status_change_id='.$id.'&action_sts='.$action_status.'"
	                                                });
	                                                });
	                                            </script></td><td><a href="javascript:void();" id="RU_'.$id.'"  class="btn btn-small btn-danger">
	                                            <i class="btn-icon-only icon-remove"></i>&nbsp;Remove</a><script type="text/javascript">
	                                            $(document).ready(function() {
	                                            $(\'#RU_'.$id.'\').easyconfirm({locale: {
	                                                    title: \'Remove User\',
	                                                    text: \'Are you sure you want to remove ['.$user_name1.'] user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
	                                                    button: [\'Cancel\',\' Confirm\'],
	                                                    closeText: \'close\'
	                                                     }});
	                                                $(\'#RU_'.$id.'\').click(function() {
	                                                    window.location = "?token='.$secret.'&t=1&user_rm_id='.$id.'"
	                                                });
	                                                });
	                                            </script></td>';


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


									<!-- +++++++++++++++++++++++++++++ create Roles ++++++++++++++++++++++++++++++++ -->
								<div <?php if(isset($tab3)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="create_roles">




<?php
if(!(isset($_GET['role_edit_id']))){
?>


											<form autocomplete="off" id="assign_roles_submit" name="assign_roles_submit" method="post" class="form-horizontal" action="?t=3">
												<fieldset>

												<div id="response_d3">

											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>

													<div class="control-group">
														<div class="controls form-group col-lg-5">
														<label class="" for="access_role_name">Access Role Name</label>
															<input class="form-control span2" id="access_role_name" name="access_role_name" type="text" onblur="checkModules()">
														</div>
													</div>



													<div class="control-group">

														<div class="controls form-group col-lg-5">
															<label class="" for="my_select">Modules</label >
																<select class="form-control span4" multiple="multiple" id="my_select" name="my_select[]">
                                                                    <option value="" disabled="disabled"> Choose Module(s)</option>

																<?php

																if($user_type=='SUPPORT'){
																	if($system_package=='N/A'){
																		$q1 = "SELECT `module_name` ,`name_group` FROM `admin_access_modules` WHERE `user_type` ='$user_type' AND `module_name`<>'profile' AND `module_name` <>'users' AND is_enable=1";
																		$modules1 = $db->selectDB($q1);
																		$modules = $modules1['data'];
																	}else{

																		/*echo $q1="SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a ,`admin_product_controls` c
																		WHERE c.`source`=a.`module_name` AND c.`product_code`='$system_package' AND c.type='page' AND c.`access_method`='1'
																		AND a.`user_type` ='$user_type' AND `module_name`<>'profile' AND `module_name` <>'users' AND is_enable=1 AND c.user_type='$user_type'";
																		*/
																		$q11 = "SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a WHERE a.`user_type` ='$user_type' AND a.`module_name`<>'profile' AND a.`module_name` <>'users' AND a.is_enable=1";
                                                                        $modules1 = $db->selectDB($q11);


																		$q12 = "SELECT options FROM admin_product_controls WHERE product_code='$system_package' AND feature_code='ALLOWED_PAGE'";

                                                                        $modules2 = json_decode($db->select1DB($q12)['options']);
                                                                        //print_r($modules2);

                                                                        foreach ($modules1['data'] as $key=>$value ){
                                                                            if(!in_array($value['module_name'],$modules2)){

                                                                                unset($modules1['data'][$key]);

                                                                            }
                                                                        }

                                                                        $modules = $modules1['data'];
																	}

																}else{

																	if($system_package=='N/A'){
																		$q1 = "SELECT `module_name` ,`name_group` FROM `admin_access_modules` WHERE `user_type` ='$user_type' AND `module_name`<>'profile' AND `module_name` <>'users' AND is_enable=1";

                                                                        $modules1 = $db->selectDB($q1);
                                                                        $modules = $modules1['data'];

																	}else{

																		/*echo $q1="SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a ,`admin_product_controls` c
																		WHERE c.`source`=a.`module_name` AND c.`product_code`='$system_package' AND c.type='page' AND c.`access_method`='1'
																		AND a.`user_type` ='$user_type' AND `module_name`<>'profile' AND `module_name` <>'users' AND is_enable=1 AND c.user_type='$user_type'";
																		*/

                                                                        $q11 = "SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a WHERE a.`user_type` ='$user_type' AND a.`module_name`<>'profile' AND a.`module_name` <>'users' AND a.is_enable=1";
                                                                        $modules1 = $db->selectDB($q11);
                                                                        //print_r($modules1['data']);


                                                                        $q12 = "SELECT options FROM admin_product_controls WHERE product_code='$system_package' AND feature_code='ALLOWED_PAGE'";
                                                                        $modules2 = json_decode($db->select1DB($q12)['options']);
                                                                        //print_r($modules2);

                                                                        foreach ($modules1['data'] as $key=>$value ){
                                                                            if(!in_array($value['module_name'],$modules2)){

                                                                                unset($modules1['data'][$key]);

                                                                            }
                                                                        }

                                                                        $modules = $modules1['data'];
                                                                        //print_r($modules1['data']);

                                                                    }

																}



																$query_results=mysql_query($q1);
																foreach($modules as $row){
																	$module_name = $row[module_name];
																	$module = $row[name_group];
																	//$description = $row[description];

																	if($module_name=='support' && $user_type=='SUPPORT'){

																		echo "<option value='".$module_name."' selected class='disabled'>".$module."</option>";
																	}else{

																	echo "<option value='".$module_name."'>".$module."</option>";
																	}
																}
																?>


															    </select>
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->

													<div class="form-actions">
														<button type="submit" name="assign_roles_submita" id="assign_roles_submita" class="btn btn-primary">Save</button>

	                                                </div>
	                                            </fieldset>
											</form>

<script type="text/javascript">

$(document).ready(function() {


	document.getElementById("assign_roles_submita").disabled = true;

});


</script>




<?php
}

if(isset($_GET['role_edit_id'])){
?>


<script type="text/javascript">

$(document).ready(function() {



});


</script>


<form autocomplete="off" id="assign_roles_form" name="assign_roles_form" method="post" class="form-horizontal" action="?t=3">
												<fieldset>

												<div id="response_d3">

											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
														<script type="text/javascript">
															function get_roles(role_ID){
																window.location.href="users.php?t=3&role_ID="+role_ID+"&form_secreat="+'<?php echo $secret;?>'+"";
															}
														</script>

													<div class="control-group">
														<label class="control-label" for="access_role_field">Roles</label>
														<div class="controls col-lg-5 form-group">

														<input type="hidden" name="access_role_field" id="access_role_field11" value="<?php echo $_GET['role_ID']; ?>">
																<select class="span4 form-control" name="access_role_field11" id="access_role_field" disabled="disabled" onchange="get_roles(this.value)">
                                                                    <option value="">Select Role</option>
																	<?php


																	if($user_type=='SUPPORT'){

																$key_query ="SELECT a.`access_role` ,a.description
																		FROM `admin_access_roles` a , `admin_access_roles_modules` b
																		WHERE a.`distributor` ='$user_distributor' AND a.`distributor`=b.`distributor` AND b.`module_name`='support' AND a.`access_role`=b.`access_role`
																		GROUP BY a.`access_role`";

																	}else{
																		$key_query = "SELECT `access_role` ,description
																					FROM `admin_access_roles`
																					WHERE `distributor` ='$user_distributor'";
																	}

																	//echo $key_query;

																		if($user_type=='MNO'){

																			if(isset($_GET['role_ID'])){

																			//echo '<option selected value="'.$user_distributor.'_support">Support</option>';
																			}else{

																			//	echo '<option value="'.$user_distributor.'_support">Support</option>';

																			}
																		}

                                                                $query_results=mysql_query($key_query);
                                                                while($row=mysql_fetch_array($query_results)){
                                                                    $tag_name = $row[access_role];
                                                                    $description1 = $row[description];
																	if($role_id==$tag_name){
																		$selected='selected';
																	}else{
																		$selected='';
																	}
                                                                    echo '<option '.$selected.' value="'.$tag_name.'">'.$description1.'</option>';
                                                                }
																	?>
																</select>
														</div>
													</div>

													<div class="control-group">
															<label class="control-label" for="my_select_roles">Modules</label >

														<div class="controls col-lg-5 form-group">
																<select class="span4 form-control" multiple="multiple" id="my_select_roles" name="my_select_roles[]">
                                                                    <option value="" disabled="disabled"> Choose Module(s)</option>
																<?php


																if($user_type=='SUPPORT'){

																	if($system_package=='N/A'){
																		$q1 = "SELECT `module_name` ,`name_group` FROM `admin_access_modules` WHERE `user_type` ='$user_type' AND `module_name`<>'profile' AND `module_name` <>'users' AND is_enable=1";

                                                                        $modules1 = $db->selectDB($q1);
                                                                        $modules = $modules1['data'];

																	}else{

																		/*$q1="SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a ,`admin_product_controls` c
																		WHERE c.`source`=a.`module_name` AND c.`product_code`='$system_package' AND c.type='page' AND c.`access_method`='1'
																		AND a.`user_type` ='$user_type' AND `module_name`<>'profile' AND `module_name` <>'users' AND is_enable=1 AND c.user_type='$user_type'";

																		*/

                                                                        $q11 = "SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a WHERE a.`user_type` ='$user_type' AND a.`module_name`<>'profile' AND a.`module_name` <>'users' AND a.is_enable=1";
                                                                        $modules1 = $db->selectDB($q11);


                                                                        $q12 = "SELECT options FROM admin_product_controls WHERE product_code='$system_package' AND feature_code='ALLOWED_PAGE'";

                                                                        $modules2 = json_decode($db->select1DB($q12)['options']);
                                                                        //print_r($modules2);

                                                                        foreach ($modules1['data'] as $key=>$value ){
                                                                            if(!in_array($value['module_name'],$modules2)){

                                                                                unset($modules1['data'][$key]);

                                                                            }
                                                                        }

                                                                        $modules = $modules1['data'];

																	}


																}else{

																	if($system_package=='N/A'){
																		$q1 = "SELECT `module_name` ,`name_group` FROM `admin_access_modules` WHERE `user_type` ='$user_type' AND `module_name`<>'profile' AND `module_name` <>'users' AND is_enable=1";

                                                                        $modules1 = $db->selectDB($q1);
                                                                        $modules = $modules1['data'];

																	}else{

																		/*$q1="SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a ,`admin_product_controls` c
																		WHERE c.`source`=a.`module_name` AND c.`product_code`='$system_package' AND c.type='page' AND c.`access_method`='1'
																		AND a.`user_type` ='$user_type' AND `module_name`<>'profile' AND `module_name` <>'users' AND is_enable=1 AND c.user_type='$user_type'";
																		*/

                                                                        $q11 = "SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a WHERE a.`user_type` ='$user_type' AND a.`module_name`<>'profile' AND a.`module_name` <>'users' AND a.is_enable=1";
                                                                        $modules1 = $db->selectDB($q11);
                                                                        //print_r($modules1['data']);


                                                                        $q12 = "SELECT options FROM admin_product_controls WHERE product_code='$system_package' AND feature_code='ALLOWED_PAGE'";
                                                                        $modules2 = json_decode($db->select1DB($q12)['options']);
                                                                        //print_r($modules2);

                                                                        foreach ($modules1['data'] as $key=>$value ){
                                                                            if(!in_array($value['module_name'],$modules2)){

                                                                                unset($modules1['data'][$key]);

                                                                            }
                                                                        }

                                                                        $modules = $modules1['data'];

																	}

																}






																//$q1 = "SELECT A.`module_name`, M.`module`, M.`description` FROM `admin_access_modules` AS A, `admin_main_modules` AS M
																//WHERE A.`module_name` = M.`module_name` AND `user_type` = '$user_type' AND A.`module_name`<>'profile' AND A.`module_name` <>'users'";

                                                         /*    $query_results=mysql_query($q1);
															while($row=mysql_fetch_array($query_results)){ */
																
																foreach ($modules as $key => $row) {
                                                                $module_name = $row[module_name];
                                                                $module = $row[name_group];
																if(in_array($module_name,$role_array)){
																	$selected="selected";

																	if($module_name=='support' && $user_type=='SUPPORT'){

																		$selected="class='disabled' selected";
																	}


																}else{
																	$selected="";

																	if($module_name=='support' && $user_type=='SUPPORT'){

																		$selected="class='disabled' selected";
																	}
																}
                                                                echo "<option ".$selected." value='".$module_name."'>".$module."</option>";
                                                            }
																?>


															    </select>
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->

													<div class="form-actions">
														<button type="submit" name="assign_rolesa" id="assign_rolesa" class="btn btn-primary" disabled="disabled">Save</button>
														<button type="button" onclick="goto('?t=3')" class="btn btn-danger">Cancel</button>

	                                                </div>
	                                            </fieldset>
											</form>

<script type="text/javascript">

$(document).ready(function() {


	var e = document.getElementById("access_role_field");
	var manval = e.options[e.selectedIndex].value;

	if(manval==''){
		document.getElementById("assign_rolesa").disabled = true;

	}else{
		//document.getElementById("assign_rolesa").disabled = false;

		}

});


</script>

<?php } ?>








									<div class="widget widget-table action-table">
										<div class="widget-header">
											<!-- <i class="icon-th-list"></i> -->
											<h3>Existing Admin Roles</h3>
										</div>

										<div class="widget-content table_response">
											<div style="overflow-x:auto;" >
											<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
												<thead>
													<tr>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Access Role</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Modules Assigned</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Create Date</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Remove</th>
													</tr>
												</thead>
												<tbody>

											<?php


											if($user_type=='SUPPORT'){


												$key_query="SELECT r.id, r.`access_role`,r.`description`, GROUP_CONCAT(CONCAT('<li>',a.`name_group`,'</li>') SEPARATOR '') AS m_list,m.`module_name`,r.`create_date` FROM `admin_access_roles_modules` m LEFT JOIN `admin_access_roles` r
												ON r.`access_role`=m.`access_role`,
												`admin_access_modules` a
												WHERE r.`distributor`='$user_distributor'
												AND a.`module_name`=m.`module_name`
												AND a.`user_type`='$user_type' AND m.`module_name`='support'
												GROUP BY r.access_role
												ORDER BY r.`access_role`";


											}else{


											$key_query="SELECT r.id, r.`access_role`,r.`description`, GROUP_CONCAT(CONCAT('<li>',a.`name_group`,'</li>') SEPARATOR '') AS m_list,m.`module_name`,DATE_FORMAT(r.`create_date`,'%m/%d/%Y %h:%i %p') AS create_date FROM `admin_access_roles_modules` m LEFT JOIN `admin_access_roles` r
																ON r.`access_role`=m.`access_role`,
																`admin_access_modules` a
																WHERE r.`distributor`='$user_distributor'
																AND a.`module_name`=m.`module_name`
																AND a.`user_type`='$user_type'
																GROUP BY r.access_role
																ORDER BY r.`access_role`";

											}
												$query_results=mysql_query($key_query);
												while($row=mysql_fetch_array($query_results)){
													$access_role = $row[access_role];
													$description = $row[description];
													$create_date = $row[create_date];
													$id_access_role =$row[id];
													$m_list = $row[m_list];

													//check access Role use or not//
												$check_role=mysql_query("SELECT * FROM `admin_users` u WHERE u.`access_role`='$access_role'");

													echo '<tr>
													<td> '.$description.' </td>

													<td >  <a class="btn" id="'.$access_role.'"> View </a> ';
													echo '<script>
												        $(document).ready(function() {

												            $(\'#'.$access_role.'\').tooltipster({
												                content: $("'.$m_list.'"),
												                theme: \'tooltipster-shadow\',
												                animation: \'grow\',
												                onlyOne: true,
												                trigger: \'click\'

												            });


												        });
												    </script></td>'.
														'<td> '.$create_date.' </td>';
													/////////////////////////////////////////////

													echo '<td>';
											echo '<a href="javascript:void();" id="RE_'.$id_access_role.'"  class="btn btn-small btn-primary">
											<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Edit</a><script type="text/javascript">
											$(document).ready(function() {
											$(\'#RE_'.$id_access_role.'\').easyconfirm({locale: {
													title: \'Role Edit\',
													text: \'Are you sure you want to edit this Role?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
													button: [\'Cancel\',\' Confirm\'],
													closeText: \'close\'
												     }});
												$(\'#RE_'.$id_access_role.'\').click(function() {
													window.location = "?form_secreat='.$secret.'&t=3&role_ID='.$access_role.'&role_edit_id='.$id_access_role.'"
												});
												});
											</script>';
											echo '</td>';



													echo '<td>';
											if(mysql_num_rows($check_role)==0){
											echo '<a href="javascript:void();" id="AP_'.$id_access_role.'"  class="btn btn-small btn-primary">
											<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">
											$(document).ready(function() {
											$(\'#AP_'.$id_access_role.'\').easyconfirm({locale: {
													title: \'Role Remove\',
													text: \'Are you sure you want to remove this Role?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
													button: [\'Cancel\',\' Confirm\'],
													closeText: \'close\'
												     }});
												$(\'#AP_'.$id_access_role.'\').click(function() {
													window.location = "?token2='.$secret.'&t=3&remove_access_role='.$access_role.'&description='.$description.'&remove_id='.$id_access_role.'"
												});
												});
											</script>';
											}else{

											echo	'<a class="btn btn-small btn-primary" disabled>
											<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>';
												}

											echo '</td>';

												}

											?>





											</tbody>
											</table>
										</div>
										</div>
									</div>

								</div>



									<!-- +++++++++++++++++++++++++++++ Edit users ++++++++++++++++++++++++++++++++ -->
								<div <?php if(isset($tab5) && $tab5 == "set"){ ?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="edit_users" >
									<form autocomplete="off" id="edit-user-profile" action="?t=1" method="post" class="form-horizontal" >

									<?php
										/*$rowUser = mysql_fetch_array($r);

										$id =$rowUser[id];
										$user_name = $rowUser[user_name];
										$access_role_set = $rowUser[access_role];
										//$user_type = $rowUser[user_type];
										//$user_distributor = $rowUser[user_distributor];
										$full_name = $rowUser[full_name];
										$email = $rowUser[email];
										$language_set = $rowUser[language];
										$mobile = $rowUser[mobile];
										//$user_name = $rowUser[user_name];
										//$user_name = $rowUser[user_name];*/
										if($_GET['edit_id']){

													$id = $edit_user_data[0]->getId();
													$user_name =  $edit_user_data[0]->getUserName();
													$access_role_set = $edit_user_data[0]->getAccessRole();
													
													$full_name = $edit_user_data[0]->getFullName();
													$email = $edit_user_data[0]->getEmail();
													$language_set = $edit_user_data[0]->getLanguage();
													$mobile = $edit_user_data[0]->getMobile(); 

													}

										echo '<input type="hidden" name="form_secret" id="form_secret1" value="'.$_SESSION['FORM_SECRET'].'" />';
									?>

											<fieldset>
                                                <legend>Edit Profile</legend>
												<div class="control-group">
													<label class="control-label" for="access_role_2">Access Role<sup><font color="#FF0000" ></font></sup></label>

													<div class="controls form-group col-lg-5">
															<select class="form-control span4" name="access_role_2" id="access_role_2" value=<?php echo $access_role_set; ?>>
																<option value="admin">admin</option>
															<?php

															$key_query = "SELECT access_role,description FROM admin_access_roles WHERE distributor = '$user_distributor' ORDER BY description";


															$query_results=mysql_query($key_query);
															while($row=mysql_fetch_array($query_results)){
																	$access_role = $row[access_role];
																if ($access_role == $access_role_set) {
																	$description = $row[description];

																	echo '<option value="'.$access_role.'" selected>'.$description.'</option>';

																} else {
																	//$access_role = $row[access_role];
																	$description = $row[description];

																	echo '<option value="'.$access_role.'">'.$description.'</option>';

																}

															}

															?>

															</select>
													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->

												<?php
													echo '<input type="hidden" name="user_type" id="user_type2" value="'.$user_type.'">';
												 ?>

												<?php
													echo '<input type="hidden" name="loation" id="loation2" value="'.$user_distributor.'">';

													echo '<input type="hidden" name="id" id="id" value="'.$id.'">';
												 ?>

												<div class="control-group">
													<label class="control-label" for="full_name_2"_1>Full Name<sup><font color="#FF0000" ></font></sup></label>

													<div class="controls form-group col-lg-5">
															<input class="form-control span4" id="full_name_2" name="full_name_2" maxlength="25" type="text" value="<?php echo $full_name ?>">
													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->


												<div class="control-group">
													<label class="control-label" for="email_2">Email<sup><font color="#FF0000" ></font></sup></label>

													<div class="controls form-group col-lg-5">
															<input class="form-control span4" id="email_2" name="email_2" type="text" value="<?php echo $email ?>" >
                                                    </div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->

												<div class="control-group">
													<label class="control-label" for="language_2">Language</label>

													<div class="controls form-group col-lg-5">
															<select class="form-control span4" name="language_2" id="language_2">

															<?php


															$key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";

															$query_results=mysql_query($key_query);
															while($row=mysql_fetch_array($query_results)){
																$language_code = $row[language_code];
																$language = $row[language];
																if ($language_code == $language_set) {
																	echo '<option value="'.$language_code.'" selected>'.$language.'</option>';
																} else {
																	echo '<option value="'.$language_code.'">'.$language.'</option>';
																}



															}

															?>

															</select>
													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->

												<div class="control-group">
													<label class="control-label" for="mobile_2">Phone Number<sup><font color="#FF0000" ></font></sup></label>

													<div class="form-group controls col-lg-5">
															<input class="form-control span4" id="mobile_2" name="mobile_2" type="text" maxlength="12" value="<?php echo $mobile ?>">
													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->

												




												<div class="form-actions">
													<button type="submit"  name="edit-submita" id="edit-submita" class="btn btn-primary" disabled="disabled">Save</button>&nbsp; <strong><font color="#FF0000"></font><small></small></strong>
													<button type="button" onclick="goto('?t=1')" class="btn btn-danger">Cancel</button>&nbsp;

													<script type="text/javascript">
													function goto(url){
														window.location = url;
														}


												    function footer_submitfn() {
                                                        //alert("fn");
                                                        $("#edit-submita").prop('disabled', false);
                                                    }


													</script>


												</div>
												<!-- /form-actions -->
											</fieldset>
										</form>


                                    <form onkeyup="footer_submitfn1();" onchange="footer_submitfn1();" autocomplete="off" id="edit-user-password" action="?t=1" method="post" class="form-horizontal" >

                                        <?php

                                        echo '<input type="hidden" name="form_secret" id="form_secret2" value="'.$_SESSION['FORM_SECRET'].'" />';
                                        ?>

                                        <fieldset>
                                            <legend>Reset Password</legend>

                                            <?php
                                            echo '<input type="hidden" name="user_type" id="user_type3" value="'.$user_type.'">';
                                            ?>

                                            <?php
                                            echo '<input type="hidden" name="loation" id="loation3" value="'.$user_distributor.'">';

                                            echo '<input type="hidden" name="id" id="id1" value="'.$id.'">';
                                            ?>

                                            <div class="control-group">
                                                <label class="control-label" for="full_name_2"_1>Password<sup><font color="#FF0000" ></font></sup></label>

                                                <div class="controls col-lg-5">
                                                    <input class="span4" id="passwd" name="passwd"  type="password" required>
                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->


                                            <div class="control-group">
                                                <label class="control-label" for="email_2">Confirm Password<sup><font color="#FF0000" ></font></sup></label>

                                                <div class="controls col-lg-5">
                                                    <input class="span4" id="passwd_2" name="passwd_2" type="password"  required="required">
                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->


                                            <div class="form-actions">
                                                <button type="submit"  name="edit-submita-pass" id="edit-submita-pass" class="btn btn-primary" disabled="disabled">Save</button>&nbsp; <strong><font color="#FF0000"></font><small></small></strong>
                                                	<button type="button" onclick="goto('?t=1')" class="btn btn-danger">Cancel</button>&nbsp;
                                            </div>
                                            <!-- /form-actions -->
                                        </fieldset>
                                    </form>

                                    <script>
                                                    function footer_submitfn1() {
                                                        //alert("fn");
                                                        $("#edit-submita-pass").prop('disabled', false);
                                                    }
                                                </script>
								</div>




							<!-- +++++++++++++++++++++++++++++ create admin users ++++++++++++++++++++++++++++++++ -->
                            <div <?php if(isset($tab6)){?>class="tab-pane active" <?php }else {?> class="tab-pane" <?php }?> id="peer_admin">
                                <div id="response_d3">

                                </div>

                                    <form autocomplete="off" id="peer_profile" action="users.php?t=6" method="post" class="form-horizontal" >


										<fieldset>

                                            <?php if($user_type=='ADMIN'){?>


                                            <div class="control-group">

                                                <div class="controls col-lg-5 form-group">
                                                <label class="" for="access_role_peer">Access Role<sup><font color="#FF0000" ></font></sup></label>
                                                        <input class="span4 form-control" type="text" readonly value="Master Admin Peer" name="access_role_peer">

                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->



											<?php }elseif ($user_type=='MNO'){ ?>



											 <div class="control-group">

                                                <div class="controls col-lg-5 form-group">
                                                <label class="" for="language_peer">Access Role</label>
                                                        <select class="span4 form-control" name="access_role_peer" id="access_role_peer">

															<option value="">Choose Admin Type</option>
															<option value="Master Admin Peer">Master Admin Peer</option>
															<option value="Master Support Admin">Master Support Admin</option>

															<?php 

																$isTechAdmin = $package_functions->getOptions('MASTER_TECH_ADMIN',$system_package);

															 ?>

															<?php if($isTechAdmin== 'NO'){ ?>

																<!-- No need to display Master tech admin-->

															<?php }else{?>

																<option value="Master Tech Admin">Master Tech Admin </option>

															<?php } ?>

																<?php 
															
																$isSaleAdmin = $package_functions->getOptions('MASTER_SALES_ADMIN',$system_package);

																?>

															<?php if($isSaleAdmin== 'YES'){ ?>


																<option value="Sales Admin">Sales (ReadOnly) </option>

																<?php } ?>

                                                        </select>

                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->



											<?php }elseif ($user_type=='SUPPORT'){?>


											  <div class="control-group">

                                                <div class="controls col-lg-5 form-group">
                                                <label class="" for="access_role_peer">Access Role<sup><font color="#FF0000" ></font></sup></label>
                                                        <input class="span4 form-control" type="text" readonly value="Master Support Admin" name="access_role_peer">

                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->



											<?php }

                                                echo '<input type="hidden" name="user_type" id="user_type" value="'.$user_type.'">';

                                                $kmno_query = "SELECT mno_id FROM exp_mno_distributor where distributor_code = '$user_distributor'";

                                                $query_results=mysql_query($kmno_query);
                                                while($row=mysql_fetch_array($query_results)){
                                                	$dist = $row[mno_id];
                                                }


                                            echo '<input type="hidden" name="mno_id" id="mno_id" value="'.$dist.'">';


                                            if($user_type == 'ADMIN'){
                                            	echo '<input type="hidden" name="loation" id="loation" value="ADMIN">';

                                            }

                                            else{
                                                echo '<input type="hidden" name="loation" id="loation" value="'.$user_distributor.'">';
                                            }
                                             ?>

                                            <div class="control-group">

                                                <div class="controls col-lg-5 form-group">
                                                <label class="" for="full_name_peer">Full Name<sup><font color="#FF0000" ></font></sup></label>
                                                        <input class="span4 form-control" id="full_name_peer" name="full_name_peer" maxlength="25" type="text">
                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->


                                            <div class="control-group">

                                                <div class="controls col-lg-5 form-group">
                                                <label class="" for="email_peer">Email<sup><font color="#FF0000" ></font></sup></label>
                                                        <input class="span4 form-control" id="email_peer" name="email_peer" type="text" placeholder="info@tg.com">
                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->


                                            <div class="control-group">

                                                <div class="controls col-lg-5 form-group">
                                                <label class="" for="language_peer">Language</label>
                                                        <select class="span4 form-control" name="language_peer" id="language_peer">

                                                        <?php


                                                        $key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";

                                                        $query_results=mysql_query($key_query);
                                                        while($row=mysql_fetch_array($query_results)){
                                                            $language_code = $row[language_code];
                                                            $language = $row[language];
                                                            echo '<option value="'.$language_code.'">'.$language.'</option>';


                                                        }

                                                        ?>

                                                        </select>

                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->


                                            <div class="control-group">

                                                <div class="controls col-lg-5 form-group">
                                                <label class="" for="mobile_peer">Phone Number</label>

                                                        <input class="span4 form-control" id="mobile_peer" name="mobile_peer" type="text" placeholder="xxx-xxx-xxxx" maxlength="12">


                                                </div>
                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->
                                             <script type="text/javascript">

                                        $(document).ready(function() {

											$("#mobile_peer").keypress(function(event){
                                                                var ew = event.which;
																//alert(ew);
                                                                //if(ew == 8||ew == 0||ew == 46||ew == 45)
                                                                //if(ew == 8||ew == 0||ew == 45)
                                                                if(ew == 8||ew == 0)
                                                                    return true;
                                                                if(48 <= ew && ew <= 57)
                                                                    return true;
                                                                return false;
                                                            }); 

                                            $('#mobile_peer').focus(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#peer_profile').data('bootstrapValidator').updateStatus('mobile_peer', 'NOT_VALIDATED').validateField('mobile_peer');
                                            });

                                            $('#mobile_peer').keyup(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#peer_profile').data('bootstrapValidator').updateStatus('mobile_peer', 'NOT_VALIDATED').validateField('mobile_peer');
                                            });

                                            $("#mobile_peer").keydown(function (e) {


                                                var mac = $('#mobile_peer').val();
                                                var len = mac.length + 1;
                                                //console.log(e.keyCode);
                                                //console.log('len '+ len);

                                                if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                    mac1 = mac.replace(/[^0-9]/g, '');


                                                    //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                    //console.log(valu);
                                                    //$('#phone_num_val').val(valu);

                                                }
                                                else{

                                                    if(len == 4){
                                                        $('#mobile_peer').val(function() {
                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                            //console.log('mac1 ' + mac);

                                                        });
                                                    }
                                                    else if(len == 8 ){
                                                        $('#mobile_peer').val(function() {
                                                            return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                            //console.log('mac2 ' + mac);

                                                        });
                                                    }
                                                }

												
                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                              /*   if ($.inArray(e.keyCode, [8, 9, 27, 13]) !== -1 ||
                                                            // Allow: Ctrl+A, Command+A
                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+C, Command+C
                                                        (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+x, Command+x
                                                        (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+V, Command+V
                                                        (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: home, end, left, right, down, up
                                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    // let it happen, don't do anything
                                                    return;
                                                }
                                                // Ensure that it is a number and stop the keypress
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                    e.preventDefault();

                                                }
 */
                                                $('#peer_profile').data('bootstrapValidator').updateStatus('mobile_peer', 'NOT_VALIDATED').validateField('mobile_peer');
                                            });


                                        });

                                        </script>
											<input type="hidden" name="peer_secret" value="<?php echo $secret; ?>" >

                                            <div class="form-actions">
                                                <button type="submit"  name="submit_peer" id="submit_peer" class="btn btn-primary">Save & Send Email Invitation</button>&nbsp; <strong><font color="#FF0000"></font><small></small></strong>
                                            </div>
                                            <!-- /form-actions -->
                                        </fieldset>
                                    </form>

<script type="text/javascript">

$(document).ready(function() {

	document.getElementById("submit_peer").disabled = true;

});



</script>



                            </div>



							</div>




							</div>
							<!-- /widget-content -->

						</div>
                        </div>
						<!-- /widget -->

					</div>
					<!-- /span12 -->




				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

		</div>
		<!-- /main-inner -->

</div>
	<!-- /main -->