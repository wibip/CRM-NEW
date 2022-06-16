<div>


<?php

session_start();
$session_id = session_id();
header("Cache-Control: no-cache, must-revalidate");

$user_name = $_SESSION['user_name'];

/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();
include_once '../classes/CommonFunctions.php';

////////////////////////////

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
// error_reporting(E_ALL);

////////////////////////////

$network_profile = $_GET['network_profile'];
$network_profile = htmlentities( urldecode($network_profile), ENT_QUOTES, 'utf-8' );

$q_select = sprintf("SELECT * FROM `exp_network_profile` WHERE `network_profile` = '%s'", $network_profile);
$r_select = $db->selectDB($q_select);
foreach ($r_select['data'] as $rrr) {
	$r_network_name = $rrr['network_name'];
	$r_mac_exists_return_flow = $rrr['mac_exists_return_flow'];
	$r_group = $rrr['group_parameter'];
	$r_verify_with_redirection = $rrr['verify_with_redirection'];
	$r_redirect_method = $rrr['redirect_method'];
	$r_mac_parameter = $rrr['mac_parameter'];
	$r_ap_parameter = $rrr['ap_parameter'];
	$r_ssid_parameter = $rrr['ssid_parameter'];
	$r_ip_parameter = $rrr['ip_parameter'];
	$r_loc_string_parameter = $rrr['loc_string_parameter'];
	$r_network_ses_parameter = $rrr['network_ses_parameter'];
	$r_ses_base_url = $rrr['ses_base_url'];
	$r_ses_deny_url = $rrr['ses_deny_url'];
	$r_ses_new_user_name = $rrr['ses_new_user_name'];
	$r_ses_new_password = $rrr['ses_new_password'];
	$r_ses_full_username = $rrr['ses_full_username'];
	$r_ses_full_password = $rrr['ses_full_password'];
	$r_ses_creation_method = $rrr['ses_creation_method'];
	$r_ses_creation_wating_time = $rrr['ses_creation_wating_time'];
	$r_ses_username_sufix = $rrr['ses_username_sufix'];
	
	$r_temp_account_creation = $rrr['temp_account_creation'];
	$r_temp_account_timegap = $rrr['temp_account_timegap'];
	$r_other_parameters = $rrr['other_parameters'];
	
	$r_temp_session_creation = $rrr['temp_session_creation'];
	$r_full_session_creation = $rrr['full_session_creation'];
	$r_return_user_session_creation = $rrr['return_user_session_creation'];
	$r_with_session_creation = $rrr['session_after_account_creation'];

	
	$r_ses_logout_url = $rrr['ses_logout_url'];
	$r_ses_logout = $rrr['ses_logout'];
	$r_api_network_auth_method = $rrr['api_network_auth_method'];
	$r_api_login = $rrr['api_login'];
	$r_api_password = $rrr['api_password'];
	$r_api_base_url = $rrr['api_base_url'];
	$r_api_time_zone = $rrr['api_time_zone'];
	$r_api_acc_org = $rrr['api_acc_org'];
	$r_api_acc_profile = $rrr['api_acc_profile'];
	$r_api_mater_timegap = $rrr['api_mater_timegap'];
	$r_api_master_acc_type = $rrr['api_master_acc_type'];
	$r_api_master_acces_type = $rrr['api_master_acces_type'];
	$r_api_master_service_profile = $rrr['api_master_service_profile'];
	$r_api_master_concurrent_login = $rrr['api_master_concurrent_login'];
	$r_api_sub_timegap = $rrr['api_sub_timegap'];
	$r_purge_delay_time = $rrr['purge_delay_time'];
	$r_api_sub_acc_type = $rrr['api_sub_acc_type'];
	$r_api_sub_acces_type = $rrr['api_sub_acces_type'];
	$r_api_sub_service_profile = $rrr['api_sub_service_profile'];
	$r_api_sub_concurrent_login = $rrr['api_sub_concurrent_login'];
	$r_post_url_method = $rrr['post_url_method'];
	$r_post_url = $rrr['post_url'];
	$r_api_base_url2 = $rrr['api_base_url_new'];
	$r_vm_api_user_name = $rrr['vm_api_username'];
	$r_vm_api_password = $rrr['vm_api_password'];
	$aaa_data = $rrr['aaa_data'];
	$aaa_data = (array)json_decode($aaa_data);
	
	$r_fields_json = $rrr['fields_json'];	
	
	$fields_display = (array)json_decode($r_fields_json);
	
	//print_r($fields_display);
}

?>

	<div id="network_edit_response"></div>
	<form id="edit_profile" class="form-horizontal">
		<fieldset>
		
		
		<input type="hidden" name="fieldslist" id="fieldslist" value="<?php echo $network_profile; ?>">
		<?php if($fields_display['platform_legend'] != '0'){
		echo '<legend>';
		if($fields_display['platform_legend'] != '1') echo $fields_display['platform_legend']; else echo 'Platform';
		echo '</legend>';
		}
		?>
			<div class="control-group" <?php if($fields_display['platform_selection'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2"  for="radiobtns">
				<?php 		
				if($fields_display['platform_selection'] != '1') echo $fields_display['platform_selection']; else echo 'Platform Identification';
				?>

				</label>

				<div class="controls" >
					<div class="input-prepend input-append">						
						<select name="network_name1" id="network_name1" class="span4" required>
						<?php
						
							 $q1 = "SELECT `plugin_code`,`description` FROM `exp_plugins` WHERE `type` = 'NETWORK'";
							$re1 = $db->selectDB($q1);
							
							foreach ($re1['data'] as $row) {
								$plugin_code = $row[plugin_code];
								$description = $row[description];
								if ($r_network_name == $plugin_code) {
									echo '<option value="'.$plugin_code.'" selected>'.$description.'</option>';
								} else {
									echo '<option value="'.$plugin_code.'">'.$description.'</option>';
								}								
							}
						?>
					</select>
					</div>
				</div>
			</div>
			
		<?php if($fields_display['redirect_legend'] != '0'){
				echo '<legend>';		
		if($fields_display['redirect_legend'] != '1') echo $fields_display['redirect_legend']; else echo 'Initial Redirection Configuration';
			echo '</legend>';
		//echo '<legend>Initial Redirection Configuration</legend>';
		}
		?>
		
			
			
			
			<div class="control-group" <?php if($fields_display['verify_with_redirection'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				<?php 
						if($fields_display['verify_with_redirection'] != '1') echo $fields_display['verify_with_redirection']; else echo 'Account Verify with Redirection';

				?>
				
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="verify_with_redirection" id="verify_with_redirection" class="span4" required>
						<option <?php if($r_verify_with_redirection=="YES"){echo "selected";}?> value="YES" >Verify AAA Account</option>
						<option <?php if($r_verify_with_redirection=="NO"){echo "selected";}?> value="NO" >No Verification</option>
						</select>
					</div>
				</div>
			</div>			
			
			
			
			
			
			
			<div class="control-group" <?php if($fields_display['redirection_method'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				<?php
				if($fields_display['redirection_method'] != '1') echo $fields_display['redirection_method']; else echo 'Captive Portal Redirection Method';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="redirect_method" id="redirect_method" class="span4" required>
						<?php
						
							$q2 = "SELECT `plugin_code`,`description` FROM `exp_plugins` WHERE `type` = 'REDIRECT'";
							$re2 = $db->selectDB($q2);
							
							foreach ($re2['data'] as $row) {
								$plugin_code = $row[plugin_code];
								$description = $row[description];
								if ($r_redirect_method == $plugin_code) {
									echo '<option value="'.$plugin_code.'" selected>'.$description.'</option>';
								} else {
									echo '<option value="'.$plugin_code.'">'.$description.'</option>';
								}								
							}
						?>
						</select>
					</div>
				</div>
			</div>
			
			
			
		<div class="control-group" <?php if($fields_display['redirect_to_return_flow'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['redirect_to_return_flow'] != '1') echo $fields_display['redirect_to_return_flow']; else echo 'Redirect to Return Flow (If MAC Exists in Local DB)';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="mac_exists_return_flow" id="mac_exists_return_flow" class="span4" required>
						<option <?php if($r_mac_exists_return_flow=="YES"){echo "selected";}?> value="YES" >Redirect to return user flow</option>
						<option <?php if($r_mac_exists_return_flow=="NO"){echo "selected";}?> value="NO" >New user flow</option>
						</select>
					</div>
				</div>
			</div>	
			
			
			

			<div class="control-group" <?php if($fields_display['mac_parameter'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['mac_parameter'] != '1') echo $fields_display['mac_parameter']; else echo 'MAC Parameter';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="mac_parameter" name="mac_parameter" value="<?php echo $r_mac_parameter; ?>" class="span4" placeholder="Ex: MAC">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['ap_parameter'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['ap_parameter'] != '1') echo $fields_display['ap_parameter']; else echo 'AP Parameter';
				?>
				 </label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ap_parameter" name="ap_parameter" value="<?php echo $r_ap_parameter; ?>" class="span4" placeholder="Ex: ap">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['ssid_parameter'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['ssid_parameter'] != '1') echo $fields_display['ssid_parameter']; else echo 'SSID Parameter';
				?>
				 </label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ssid_parameter" name="ssid_parameter" value="<?php echo $r_ssid_parameter; ?>" class="span4" placeholder="Ex: ssid">
					</div>
				</div>
			</div>
			
			<div class="control-group" <?php if($fields_display['group_parameter'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['group_parameter'] != '1') echo $fields_display['group_parameter']; else echo 'Group Parameter';
				?>
				 </label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="red_group" name="red_group" value="<?php echo $r_group; ?>" class="span4" placeholder="Ex: realm">
					</div>
				</div>
			</div>
			

			<div class="control-group" <?php if($fields_display['ip_parameter'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['ip_parameter'] != '1') echo $fields_display['ip_parameter']; else echo 'IP Parameter';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ip_parameter" name="ip_parameter" value="<?php echo $r_ip_parameter; ?>" class="span4" placeholder="Ex: IP">
					</div>
				</div>
			</div>

			
			<div class="control-group" <?php if($fields_display['op82_parameter'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['op82_parameter'] != '1') echo $fields_display['op82_parameter']; else echo 'Location String (Option82) Parameter';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="loc_string_parameter" name="loc_string_parameter" value="<?php echo $r_loc_string_parameter; ?>" class="span4" placeholder="Ex: LOC-String">
					</div>
				</div>
			</div>
			
			<input type="hidden" id="network_ses_parameter" name="network_ses_parameter">
			



			
			<div class="control-group" <?php if($fields_display['other_parameter'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
						<?php
				if($fields_display['other_parameter'] != '1') echo $fields_display['other_parameter']; else echo 'Other Parameters (Put as Comma Separated Values)';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="other_parameters" name="other_parameters" value="<?php echo $r_other_parameters; ?>" class="span4" placeholder="device_mac,timezone">
					</div>
				</div>
			</div>
			
			
		<?php if($fields_display['aaa_method_legend'] != 0){
		echo '<legend>';
				
				if($fields_display['aaa_method_legend'] != '1') echo $fields_display['aaa_method_legend']; else echo 'AAA Account creation Method';
				
		echo '</legend>';
		}
		?>			
			
		
			
			
			<div class="control-group" <?php if($fields_display['account_method'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
						<?php
				if($fields_display['account_method'] != '1') echo $fields_display['account_method']; else echo 'Account Creation Method';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="temp_account_creation" id="temp_account_creation" required class="span4">
						<?php
						
									if($r_temp_account_creation == 'YES'){
										echo '<option value="YES" selected>Temp Account creation and update</option>';
										echo '<option value="BTN">Account creation and update after registration</option>';
										echo '<option value="NO">Account creation after registration</option>';
									}
									else if($r_temp_account_creation == 'BTN'){
										echo '<option value="BTN" selected>Account creation and update after registration</option>';
										echo '<option value="YES">Temp Account creation and update</option>';
										echo '<option value="NO">Account creation after registration</option>';
									}
									else{
										echo '<option value="YES">Temp Account creation and update</option>';
										echo '<option value="BTN">Account creation and update after registration</option>';
										echo '<option value="NO" selected>Account creation after registration</option>';										
									}


						?>
					</select>
					</div>
				</div>
			</div>
			
			


            <?php
            $timegap = $r_temp_account_timegap;

            $gap = "";
            if($timegap != ''){

                $interval = new DateInterval($timegap);
                //echo $interval->m;



                if($interval->y != 0){
                    $mg_dis_select1 = 'Y';
                    $mg_dis_num1 = $interval->y;
                }
                if($interval->m != 0){
                    $mg_dis_select1 = 'M';
                    $mg_dis_num1 = $interval->m;
                }

                if($interval->d != 0){
                    $mg_dis_select1 = 'D';
                    $mg_dis_num1 = $interval->d;
                }

                if($interval->i != 0){
                    $mg_dis_select2 = 'M';
                    $mg_dis_num2 = $interval->i;
                }
                if($interval->h != 0){
                    $mg_dis_select2 = 'H';
                    $mg_dis_num2 = $interval->h;
                }
            }
            ?>


            <div class="control-group" <?php if($fields_display['temp_time_gap'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
                <label class="control-label" for="product_code">
							<?php
				if($fields_display['temp_time_gap'] != '1') echo $fields_display['temp_time_gap']; else echo 'Temp Account Time Gap';
				?>
				</label>
                <div class="controls col-lg-6">
                    <table>
                        <tr>
                            
                            <td>
                                <input type="number" value="<?php echo $mg_dis_num1; ?>" id="mg_dis_num1_1" name="mg_dis_num1_1" min="0" max="999" class="span1" onchange="setTimeGapEditDis()" value="0">
                            </td>
                            <td>
                                <select id="mg_dis_select1_1" name="mg_dis_select1_1" value="<?php echo $mg_dis_select1; ?>" class="span2" onchange="setTimeGapEditDis()">
                                    <?php
                                    if($mg_dis_select1 == "D"){
                                        echo '<option value="D" selected>Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    else if($mg_dis_select1 == "M"){
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M" selected>Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    else if($mg_dis_select1 == "Y"){
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y" selected>Years</option>';
                                    }else{
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    ?>

                                </select>
                            </td>
                            <td><b> + </b></td>
                            <td>
                                <input type="number" id="mg_dis_num2_2" name="mg_dis_num2_2" value="<?php echo $mg_dis_num2; ?>" class="span1" onchange="setTimeGapEditDis()" min="0" max="9999"  value="0">
                            </td>
                            <td>
                                <select id="mg_dis_select2_2" name="mg_dis_select2_2" class="span2" value="<?php echo $mg_dis_select2; ?>" onchange="setTimeGapEditDis()">
                                    <?php
                                    if($mg_dis_select2 == "M"){

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H">Hours</option>';
                                    }
                                    else if($mg_dis_select2 == "H"){

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H" selected>Hours</option>';
                                    }else{

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H" selected>Hours</option>';
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="temp_account_timegap" name="temp_account_timegap" value="<?php echo $r_temp_account_timegap; ?>">
                    <input type="hidden" id="mg_dis_id_1" name="mg_dis_id_1" value="<?php echo $mg_dis_id; ?>">
                </div>
            </div>


			
		<?php if($fields_display['aaa_config_legend'] != '0'){
		echo '<legend>';
		
				if($fields_display['aaa_config_legend'] != '1') echo $fields_display['aaa_config_legend']; else echo 'AAA Account Configuration';
		echo '</legend>';
		}
		?>			
		
			<div class="control-group" <?php if($fields_display['account_library'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['account_library'] != '1') echo $fields_display['account_library']; else echo 'Account Creation Library';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="api_network_auth_method" id="api_network_auth_method" class="span4">
						<?php
						
							 $q1 = "SELECT `plugin_code`,`description` FROM `exp_plugins` WHERE `type` = 'NETWORK_AUTH'";
							$re1 = $db->selectDB($q1);
							
							foreach ($re1['data'] as $row) {
								$plugin_code = $row[plugin_code];
								$description = $row[description];
								if ($r_api_network_auth_method == $plugin_code) {
									echo '<option value="'.$plugin_code.'" selected>'.$description.'</option>';
								} else {
									echo '<option value="'.$plugin_code.'">'.$description.'</option>';
								}								
							}
						?>
					</select>
					</div>
				</div>
			</div>

			

			
			<div class="control-group" <?php if($fields_display['aaa_api_username'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_api_username'] != '1') echo $fields_display['aaa_api_username']; else echo 'API Login Username';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_login" name="api_login" value="<?php echo $r_api_login; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_api_password'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_api_password'] != '1') echo $fields_display['aaa_api_password']; else echo 'API Login Password';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="password" id="api_password" name="api_password" value="<?php echo $r_api_password; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_base_url'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_base_url'] != '1') echo $fields_display['aaa_base_url']; else echo 'API Base URL';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_base_url" name="api_base_url" value="<?php echo $r_api_base_url; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['vm_api_user_name'] == '0' || strlen($fields_display['vm_api_user_name']) == 0){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['vm_api_user_name'] != '1') echo $fields_display['vm_api_user_name']; else echo 'VM  API User Name';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="vm_api_username" name="vm_api_username" value="<?php echo $r_vm_api_user_name; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['vm_api_password'] == '0' || strlen($fields_display['vm_api_password']) == 0){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['vm_api_password'] != '1') echo $fields_display['vm_api_password']; else echo 'VM  API Password';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="password" id="vm_api_password" name="vm_api_password" value="<?php echo $r_vm_api_password; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_base_url2'] == '0' || strlen($fields_display['aaa_base_url2']) == 0){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_base_url2'] != '1') echo $fields_display['aaa_base_url2']; else echo 'API Base URL';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_base_url2" name="api_base_url2" value="<?php echo $r_api_base_url2; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php 
			if($fields_display['aaa_root_zone'] == '0' || strlen($fields_display['aaa_root_zone']) == 0){ echo "style=\"position: absolute;visibility: hidden;\" >"; }else{ ?>>
				<?php } ?>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_root_zone'] != '1') echo $fields_display['aaa_root_zone']; else echo 'ALE Root Zone';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="aaa_root_zone" name="aaa_root_zone" class="span4" value="<?php echo $aaa_data['aaa_root_zone']; ?>">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_api_timezone'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_api_timezone'] != '1') echo $fields_display['aaa_api_timezone']; else echo 'API Time Zone';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">
						<select  id="api_time_zone" name="api_time_zone" class="span4">
						<option value="">- Select Time-zone -</option>
						<?php



						$utc = new DateTimeZone('UTC');
						$dt = new DateTime('now', $utc);


						foreach(DateTimeZone::listIdentifiers() as $tz) {
							$current_tz = new DateTimeZone($tz);
							$offset =  $current_tz->getOffset($dt);
							$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
							$abbr = $transition[0]['abbr'];
							if($r_api_time_zone==$tz){
								$select="selected";
							}
							echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
							$select="";
						}
						$select="";
						?>
						</select>
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_group'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_group'] != '1') echo $fields_display['aaa_group']; else echo 'Default Group/Organization';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_acc_org" name="api_acc_org" value="<?php echo $r_api_acc_org; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_access_profile'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_access_profile'] != '1') echo $fields_display['aaa_access_profile']; else echo 'Default Access Profile';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_acc_profile" name="api_acc_profile" value="<?php echo $r_api_acc_profile; ?>" class="span4">
					</div>
				</div>
			</div>

		



            <?php
            $timegap2 = $r_api_mater_timegap;

            $gap = "";
            if($timegap2 != ''){

                $interval = new DateInterval($timegap2);
                //echo $interval->m;



                if($interval->y != 0){
                    $mg_dis_select12 = 'Y';
                    $mg_dis_num12 = $interval->y;
                }
                if($interval->m != 0){
                    $mg_dis_select12 = 'M';
                    $mg_dis_num12 = $interval->m;
                }

                if($interval->d != 0){
                    $mg_dis_select12 = 'D';
                    $mg_dis_num12 = $interval->d;
                }

                if($interval->i != 0){
                    $mg_dis_select22 = 'M';
                    $mg_dis_num22 = $interval->i;
                }
                if($interval->h != 0){
                    $mg_dis_select22 = 'H';
                    $mg_dis_num22 = $interval->h;
                }
            }
            ?>


            <div class="control-group" <?php if($fields_display['aaa_time_gap'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
                <label class="span2" for="product_code">
					<?php
				if($fields_display['aaa_time_gap'] != '1') echo $fields_display['aaa_time_gap']; else echo 'Account Time Gap';
				?>
				</label>
                <div class="controls">
					<div class="input-prepend input-append">
                    <table>
                        <tr>
                            
                            <td>
                                <input type="number" value="<?php echo $mg_dis_num12; ?>" id="mg_dis_num1_12" name="mg_dis_num1_12" min="0" max="999" class="span1" onchange="setTimeGapEditDis12()" value="0">
                            </td>
                            <td>
                                <select id="mg_dis_select1_12" name="mg_dis_select1_12" value="<?php echo $mg_dis_select12; ?>" class="span2" onchange="setTimeGapEditDis12()">
                                    <?php
                                    if($mg_dis_select12 == "D"){
                                        echo '<option value="D" selected>Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    else if($mg_dis_select12 == "M"){
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M" selected>Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    else if($mg_dis_select12 == "Y"){
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y" selected>Years</option>';
                                    }else{
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    ?>

                                </select>
                            </td>
                            <td><b> + </b></td>
                            <td>
                                <input type="number" id="mg_dis_num2_22" name="mg_dis_num2_22" value="<?php echo $mg_dis_num22; ?>" class="span1" onchange="setTimeGapEditDis12()" min="0" max="9999"  value="0">
                            </td>
                            <td>
                                <select id="mg_dis_select2_22" name="mg_dis_select2_22" class="span2" value="<?php echo $mg_dis_select22; ?>" onchange="setTimeGapEditDis12()">
                                    <?php
                                    if($mg_dis_select22 == "M"){

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H">Hours</option>';
                                    }
                                    else if($mg_dis_select22 == "H"){

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H" selected>Hours</option>';
                                    }else{

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H" selected>Hours</option>';
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="api_mater_timegap" name="api_mater_timegap" value="<?php echo $r_api_mater_timegap; ?>">
                    <input type="hidden" id="mg_dis_id_12" name="mg_dis_id_12" value="<?php echo $mg_dis_id; ?>">
                	</div>
				</div>
            </div>





			<div class="control-group" <?php if($fields_display['aaa_account_type'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_account_type'] != '1') echo $fields_display['aaa_account_type']; else echo 'Account Type';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_master_acc_type" name="api_master_acc_type" value="<?php echo $r_api_master_acc_type; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_access_type'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['aaa_access_type'] != '1') echo $fields_display['aaa_access_type']; else echo 'Access Type';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_master_acces_type" name="api_master_acces_type" value="<?php echo $r_api_master_acces_type; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_service_profile'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['aaa_service_profile'] != '1') echo $fields_display['aaa_service_profile']; else echo 'Service Profile (Product)';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_master_service_profile" name="api_master_service_profile" value="<?php echo $r_api_master_service_profile; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_master_concurrent'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['aaa_master_concurrent'] != '1') echo $fields_display['aaa_master_concurrent']; else echo 'Number of Concurrent Logins';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_master_concurrent_login" name="api_master_concurrent_login" value="<?php echo $r_api_master_concurrent_login; ?>" class="span4">
					</div>
				</div>
			</div>

		


            <?php
            $timegap23 = $r_api_sub_timegap;

            $gap = "";
            if($timegap23 != ''){

                $interval = new DateInterval($timegap23);
                //echo $interval->m;



                if($interval->y != 0){
                    $mg_dis_select123 = 'Y';
                    $mg_dis_num123 = $interval->y;
                }
                if($interval->m != 0){
                    $mg_dis_select123 = 'M';
                    $mg_dis_num123 = $interval->m;
                }

                if($interval->d != 0){
                    $mg_dis_select123 = 'D';
                    $mg_dis_num123 = $interval->d;
                }

                if($interval->i != 0){
                    $mg_dis_select223 = 'M';
                    $mg_dis_num223 = $interval->i;
                }
                if($interval->h != 0){
                    $mg_dis_select223 = 'H';
                    $mg_dis_num223 = $interval->h;
                }
            }
            ?>
            
            
           <div class="control-group" <?php if($fields_display['aaa_purge_delay'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['aaa_purge_delay'] != '1') echo $fields_display['aaa_purge_delay']; else echo 'Purge Delay Time';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">
						<input type="text" id="purge_delay_time" name="purge_delay_time" value="<?php echo $r_purge_delay_time; ?>" class="span4">
					</div>
				</div>
			</div>


            <div class="control-group" <?php if($fields_display['aaa_sub_timegap'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
                <label class="control-label" for="product_code">
					<?php
				if($fields_display['aaa_sub_timegap'] != '1') echo $fields_display['aaa_sub_timegap']; else echo 'Sub Account Timegap';
				?>
				</label>
                <div class="controls col-lg-6">
                    <table>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                            <td>
                                <input type="number" value="<?php echo $mg_dis_num123; ?>" id="mg_dis_num1_123" name="mg_dis_num1_123" min="0" max="999" class="span1" onchange="setTimeGapEditDis123()" value="0">
                            </td>
                            <td>
                                <select id="mg_dis_select1_123" name="mg_dis_select1_123" value="<?php echo $mg_dis_select123; ?>" class="span2" onchange="setTimeGapEditDis123()">
                                    <?php
                                    if($mg_dis_select123 == "D"){
                                        echo '<option value="D" selected>Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    else if($mg_dis_select123 == "M"){
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M" selected>Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    else if($mg_dis_select123 == "Y"){
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y" selected>Years</option>';
                                    }else{
                                        echo '<option value="D">Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y">Years</option>';
                                    }
                                    ?>

                                </select>
                            </td>
                            <td><b> + </b></td>
                            <td>
                                <input type="number" id="mg_dis_num2_223" name="mg_dis_num2_223" value="<?php echo $mg_dis_num223; ?>" class="span1" onchange="setTimeGapEditDis123()" min="0" max="9999"  value="0">
                            </td>
                            <td>
                                <select id="mg_dis_select2_223" name="mg_dis_select2_223" class="span2" value="<?php echo $mg_dis_select223; ?>" onchange="setTimeGapEditDis123()">
                                    <?php
                                    if($mg_dis_select223 == "M"){

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H">Hours</option>';
                                    }
                                    else if($mg_dis_select223 == "H"){

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H" selected>Hours</option>';
                                    }else{

                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H" selected>Hours</option>';
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="api_sub_timegap" name="api_sub_timegap" value="<?php echo $r_api_sub_timegap; ?>">
                    <input type="hidden" id="mg_dis_id_12" name="mg_dis_id_123" value="<?php echo $mg_dis_id; ?>">
                </div>
            </div>






            <div class="control-group" <?php if($fields_display['aaa_sub_account_type'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['aaa_sub_account_type'] != '1') echo $fields_display['aaa_sub_account_type']; else echo 'Sub Account Account Type';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_sub_acc_type" name="api_sub_acc_type" value="<?php echo $r_api_sub_acc_type; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_sub_access_type'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['aaa_sub_access_type'] != '1') echo $fields_display['aaa_sub_access_type']; else echo 'Sub Account Access Type';
				?>
				
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_sub_acces_type" name="api_sub_acces_type" value="<?php echo $r_api_sub_acces_type; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_sub_service_profile'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['aaa_sub_service_profile'] != '1') echo $fields_display['aaa_sub_service_profile']; else echo 'Sub Account Service Profile (Product)';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_sub_service_profile" name="api_sub_service_profile" value="<?php echo $r_api_sub_service_profile; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['aaa_sub_concurrent_logs'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['aaa_sub_concurrent_logs'] != '1') echo $fields_display['aaa_sub_concurrent_logs']; else echo 'Sub Account Number of Concurrent Logins';
				?>
				
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="api_sub_concurrent_login" name="api_sub_concurrent_login" value="<?php echo $r_api_sub_concurrent_login; ?>" class="span4">
					</div>
				</div>
			</div>
			
			
			
			
		<?php if($fields_display['wag_session_legend'] != '0'){
		echo '<legend>';
		
			
				if($fields_display['wag_session_legend'] != '1') echo $fields_display['wag_session_legend']; else echo 'WAG Session Starting Method';
				
		echo '</legend>';
		}
		?>			
	
			
			<div class="control-group" <?php if($fields_display['wag_temp_ses_before'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['wag_temp_ses_before'] != '1') echo $fields_display['wag_temp_ses_before']; else echo 'Temp Account Session Start (Before Registration)';
				?>
				
				 </label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="temp_session_creation" id="temp_session_creation" required class="span4">
						<?php
						
									if($r_temp_session_creation == 'YES'){
										echo '<option value="YES" selected>YES</option>';
										echo '<option value="NO">NO</option>';
									}
									else{
										echo '<option value="YES">YES</option>';
										echo '<option value="NO" selected>NO</option>';										
									}


						?>
					</select>
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['wag_ses_just_after'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
					<?php
				if($fields_display['wag_ses_just_after'] != '1') echo $fields_display['wag_ses_just_after']; else echo 'Start Session Just After the Account Creation';
				?>
				
				 </label>

				<div class="controls">
					<div class="input-prepend input-append">
						<select name="with_session_creation" id="with_session_creation" required class="span4">
						<?php

									if($r_with_session_creation == 'YES'){
										echo '<option value="YES" selected>YES</option>';
										echo '<option value="NO">NO</option>';
									}
									else{
										echo '<option value="YES">YES</option>';
										echo '<option value="NO" selected>NO</option>';
									}


						?>
					</select>
					</div>
				</div>
			</div>
			
			
			<div class="control-group" <?php if($fields_display['wag_ses_final_redirection'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
						<?php
				if($fields_display['wag_ses_final_redirection'] != '1') echo $fields_display['wag_ses_final_redirection']; else echo 'Start Session with Final Redirection';
				?>
				
				 </label>

				<div class="controls">
					<div class="input-prepend input-append">
						<select name="full_session_creation" id="full_session_creation" required class="span4">
							<?php

							if($r_full_session_creation == 'YES'){
								echo '<option value="YES" selected>YES</option>';
								echo '<option value="NO">NO</option>';
							}
							else{
								echo '<option value="YES">YES</option>';
								echo '<option value="NO" selected>NO</option>';
							}


							?>
						</select>
					</div>
				</div>
			</div>
			
			

			<div class="control-group" <?php if($fields_display['wag_ses_ret_final_redirection'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
							<?php
				if($fields_display['wag_ses_ret_final_redirection'] != '1') echo $fields_display['wag_ses_ret_final_redirection']; else echo 'Return User Start Session with Final Redirection';
				?>
				
				 </label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="return_user_session_creation" id="return_user_session_creation" required class="span4">
						<?php
						
									if($r_return_user_session_creation == 'YES'){
										echo '<option value="YES" selected>YES</option>';
										echo '<option value="NO">NO</option>';
									}
									else{
										echo '<option value="YES">YES</option>';
										echo '<option value="NO" selected>NO</option>';										
									}


						?>
					</select>
					</div>
				</div>
			</div>
			
			
		<?php if($fields_display['wag_ses_config_legend'] != '0'){
		echo '<legend>';
		
						
				if($fields_display['wag_ses_config_legend'] != '1') echo $fields_display['wag_ses_config_legend']; else echo 'Session Start Configuration';
				
		
		
		echo '</legend>';
		}
		?>			
			
			
			<div class="control-group" <?php if($fields_display['wag_ses_method'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
								<?php
				if($fields_display['wag_ses_method'] != '1') echo $fields_display['wag_ses_method']; else echo 'Session Creation Method';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="ses_creation_method" id="ses_creation_method" required class="span4">
						<?php
						
							 $q3 = "SELECT `plugin_code`,`description` FROM `exp_plugins` WHERE `type` = 'SESSION'";
							$re3 = $db->selectDB($q3);
							
							foreach ($re3['data'] as $row) {
								$plugin_code = $row[plugin_code];
								$description = $row[description];
								if ($r_ses_creation_method == $plugin_code) {
									echo '<option value="'.$plugin_code.'" selected>'.$description.'</option>';
								} else {
									echo '<option value="'.$plugin_code.'">'.$description.'</option>';
								}								
							}
						?>
					</select>
					</div>
				</div>
			</div>
			
			

			<div class="control-group" <?php if($fields_display['wag_ses_base_url'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
								<?php
				if($fields_display['wag_ses_base_url'] != '1') echo $fields_display['wag_ses_base_url']; else echo 'Session Creation Base URL';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_base_url" name="ses_base_url" value="<?php echo $r_ses_base_url; ?>" class="span4" placeholder="http://10.1.1.1/ccs/account">
					</div>
				</div>
			</div>

			
			
			<div class="control-group" <?php if($fields_display['wag_ses_deny_url'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
							<?php
				if($fields_display['wag_ses_deny_url'] != '1') echo $fields_display['wag_ses_deny_url']; else echo 'Session Deny URL';
				?>
				
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_deny_url" name="ses_deny_url" value="<?php echo $r_ses_deny_url; ?>" class="span4" placeholder="/pas/parsed/tg/deniedPost.htm">
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['wag_ses_username'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
							<?php
				if($fields_display['wag_ses_username'] != '1') echo $fields_display['wag_ses_username']; else echo 'Session User Name';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_new_user_name" name="ses_new_user_name" value="<?php echo $r_ses_new_user_name; ?>" class="span4" >
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['wag_ses_password'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				<?php
				if($fields_display['wag_ses_password'] != '1') echo $fields_display['wag_ses_password']; else echo 'Session Password';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_new_password" name="ses_new_password" value="<?php echo $r_ses_new_password; ?>" class="span4" >
					</div>
				</div>
			</div>

			<div class="control-group" style="visibility: hidden; position:absolute;">
				<label class="span2" for="radiobtns">Final Session Redirection User Name (If Changed with First Username)</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_full_username" name="ses_full_username" value="<?php echo $r_ses_full_username; ?>" class="span4" >
					</div>
				</div>
			</div>

			<div class="control-group" style="visibility: hidden; position:absolute;">
				<label class="span2" for="radiobtns">Final Session Redirection Password (If Changed with First Username)</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_full_password" name="ses_full_password" value="<?php echo $r_ses_full_password; ?>" class="span4" >
					</div>
				</div>
			</div>

			<div class="control-group" style="visibility: hidden; position:absolute;">
				<label class="span2" for="radiobtns">Session Creation Waiting Time (Seconds)</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_creation_wating_time" name="ses_creation_wating_time" value="<?php echo $r_ses_creation_wating_time; ?>" class="span4">
					</div>
				</div>
			</div>
			
			
			<div class="control-group" <?php if($fields_display['wag_ses_username_suffix'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">Final Session Redirection User Name Suffix (username@wibip)</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_username_sufix" name="ses_username_sufix" value="<?php echo $r_ses_username_sufix; ?>" class="span4">
					</div>
				</div>
			</div>

			<div class="control-group" style="visibility: hidden; position:absolute;"> <!-- issue -->
				<label class="span2" for="radiobtns">Session Logout Method</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="ses_logout" id="ses_logout" required class="span4">
						<?php
						
							 $q4 = "SELECT `plugin_code`,`description` FROM `exp_plugins` WHERE `type` = 'LOGOUT'";
							$re4 = $db->selectDB($q4);
							
							foreach ($re4['data'] as $row) {
								$plugin_code = $row[plugin_code];
								$description = $row[description];
								if ($r_ses_logout == $plugin_code) {
									echo '<option value="'.$plugin_code.'" selected>'.$description.'</option>';
								} else {
									echo '<option value="'.$plugin_code.'">'.$description.'</option>';
								}								
							}
						?>
					</select>
					</div>
				</div>
			</div>

			
			<div class="control-group" style="visibility: hidden; position:absolute;">
				<label class="span2" for="radiobtns">Session Logout URL</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="ses_logout_url" name="ses_logout_url" value="<?php echo $r_ses_logout_url; ?>" class="span4">
					</div>
				</div>
			</div>
			
			
			
			
		<?php if($fields_display['platform_payment_gateway'] != '0'){
		echo '<legend>';
		
		
				if($fields_display['platform_payment_gateway'] != '1') echo $fields_display['platform_payment_gateway']; else echo 'Payment Gateway';
				
		echo '</legend>';
		}
		?>
			
			<div class="control-group" <?php if($fields_display['pg_name'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
				
				<?php
				if($fields_display['pg_name'] != '1') echo $fields_display['pg_name']; else echo 'Payment Gateway Name';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<select name="post_url_method" id="post_url_method" class="span4">
						<?php
						
							 $q5 = "SELECT `plugin_code`,`description` FROM `exp_plugins` WHERE `type` = 'ACTIVATION'";
							$re5 = $db->selectDB($q5);
							
							foreach ($re5['data'] as $row) {
								$plugin_code = $row[plugin_code];
								$description = $row[description];
								if ($r_post_url_method == $plugin_code) {
									echo '<option value="'.$plugin_code.'" selected>'.$description.'</option>';
								} else {
									echo '<option value="'.$plugin_code.'">'.$description.'</option>';
								}								
							}
						?>
					</select>
					</div>
				</div>
			</div>

			<div class="control-group" <?php if($fields_display['pg_url'] == '0'){echo "style=\"position: absolute;visibility: hidden;\""; } ?>>
				<label class="span2" for="radiobtns">
					<?php
				if($fields_display['pg_url'] != '1') echo $fields_display['pg_url']; else echo 'Payment Gateway URL';
				?>
				</label>

				<div class="controls">
					<div class="input-prepend input-append">						
						<input type="text" id="post_url" name="post_url" value="<?php echo $r_post_url; ?>" class="span4">
					</div>
				</div>
			</div>
			
			<!-- <legend>Save As</legend>

			<div class="control-group">
				<label class="span2" for="radiobtns">Network Profile</label>

				<div class="controls">
					<div >
						<input type="text" id="save_as_net_pro" name="save_as_net_pro"  class="span4" disabled><br>
						<input name="save_as" id="save_as" type="checkbox" onchange="activeSaveAs()">
						<label style="display: inline-block; margin-top: 10px"></label>
						Save as another profile name.

					</div>
				</div>
			</div> -->


			<div class="form-actions">
				<button type="button" class="btn btn-primary"  name="edit_profile_btn" id="edit_profile_btn" onclick="saveNetPro();">Update</button>
				<button type="button" class="btn btn-warning" id="cancel" onclick="cancelNetPro();" style='visibility:hidden'>Cancel</button>
				<img id="network_save_loader" src="img/loading_ajax.gif" style="visibility: hidden;">
			</div>

		</fieldset>
	</form>

</div>
