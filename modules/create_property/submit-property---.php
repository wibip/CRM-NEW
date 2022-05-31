<?php 
/// Create Account  or Edit Account/////
if (isset($_POST['create_location_submit']) || isset($_POST['create_location_next']) || isset($_POST['add_location_submit']) || isset($_POST['add_location_next'])) {//5

        //echo $_POST['how_many_icoms']; exit();

        $create_location_btn_action = $_POST['btn_action'];


        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret5']) {//refresh validate

            $parent_code = strtoupper($_POST['parent_id']);
            $parent_ac_name = $db->escapeDB(trim($_POST['parent_ac_name']));
            $parent_package = $_POST['parent_package_type'];
            $user_type1 = $_POST['user_type'];

            $icomme_number = empty($_POST['icomme']) ? $_POST['vt_icomme'] : $_POST['icomme'];

            //  exit();
            $vt_icomme_number = $_POST['vt_icomme'];

            $customer_type = trim($_POST['customer_type']);
            $gateway_type = trim($_POST['gateway_type']);
            $pr_gateway_type = trim($_POST['pr_gateway_type']);
            $business_type = trim($_POST['business_type']);
            //$network_type = $_POST['network_type'];
            if ($user_type != 'SALES') {
                if (in_array('GUEST', $_POST['network_type']) && in_array('PRIVATE', $_POST['network_type']) && in_array('VT', $_POST['network_type'])) {
                    $network_type = 'VT-BOTH';
                } elseif (in_array('GUEST', $_POST['network_type']) && in_array('PRIVATE', $_POST['network_type'])) {
                    $network_type = 'BOTH';
                } elseif (in_array('GUEST', $_POST['network_type']) && in_array('VT', $_POST['network_type'])) {
                    $network_type = 'VT-GUEST';
                } elseif (in_array('VT', $_POST['network_type']) && in_array('PRIVATE', $_POST['network_type'])) {
                    $network_type = 'VT-PRIVATE';
                } elseif (in_array('GUEST', $_POST['network_type'])) {
                    $network_type = 'GUEST';
                } elseif (in_array('PRIVATE', $_POST['network_type'])) {
                    $network_type = 'PRIVATE';
                } elseif (in_array('VT', $_POST['network_type'])) {
                    $network_type = 'VT';
                }


                $advanced_features_arr = array();

                if (array_key_exists('advanced_features', $field_array)) {
                    $advanced_features_arr['network_at_a_glance'] = '1';
                    $advanced_features_arr['802.2x_authentication'] = '0';
                    $advanced_features_arr['top_applications'] = '1';
                    //$advanced_features_arr['DPSK'] = '0';
                }

                foreach ($_POST['advanced_features'] as $value) {
                    $advanced_features_arr[$value] = '1';
                }
//print_r($advanced_features_arr);
                if (array_key_exists("top_applications", $advanced_features_arr) && $advanced_features_arr['top_applications'] == '1') {
//echo '1';
                    $avcEnabled = true;
                } else {
//echo '2';
                    $avcEnabled = false;
                }

                $advanced_features = json_encode($advanced_features_arr);
                //print_r($advanced_features);

                $wag_name = $_POST['wag_name'];
                $wag_enable = $_POST['content_filter'];
                $DNS_profile = $_POST['DNS_profile'];
                $DNS_profile_control = $_POST['DNS_profile_control'];

                if ($DNS_profile_control == 'on') {
                    $dns_profile_enable = '1';
                } else {
                    // $DNS_profile ="";
                    $dns_profile_enable = '0';
                }

                $parent_enabel = $db->getValueAsf("SELECT is_enable as f FROM admin_users WHERE verification_number='$parent_code'");

                $location_name = $db->escapeDB(trim($_POST['location_name1']));
                $location_name_s = trim($_POST['location_name1']);

                //////////////////////////////////

                $pieces = explode(" ", $location_name_s);
                $namelen = strlen($pieces[0]);


                if (0 < $namelen && $namelen < 11) {

                    $cusbiss_name = $pieces[0];

                } else {

                    $cusbiss_name = substr($pieces[0], 0, 10);


                }
                //echo $location_name;
                $category_mvnx = $_POST['category_mvnx'];

                $dpsk_voucher = $db->escapeDB(trim($_POST['dpsk_voucher']));
                $mno_first_name = $db->escapeDB(trim($_POST['mno_first_name']));
                $mno_last_name = $db->escapeDB(trim($_POST['mno_last_name']));
                $mvnx_full_name = $mno_first_name . ' ' . $mno_last_name;
                $mvnx_email = trim($_POST['mno_email']);
                $mvnx_address_1 = $db->escapeDB(trim($_POST['mno_address_1']));
                $mvnx_address_2 = $db->escapeDB(trim($_POST['mno_address_2']));
                $mvnx_address_3 = $db->escapeDB(trim($_POST['mno_address_3']));
                $mvnx_mobile_1 = $db->escapeDB(trim($_POST['mno_mobile_1']));
                $mvnx_mobile_2 = $db->escapeDB(trim($_POST['mno_mobile_2']));
                $mvnx_mobile_3 = $db->escapeDB(trim($_POST['mno_mobile_3']));
                $mvnx_country = $db->escapeDB(trim($_POST['mno_country']));
                $mvnx_state = $db->escapeDB(trim($_POST['mno_state']));
                $mvnx_zip_code = trim($_POST['mno_zip_code']);
                $mvnx_time_zone = $_POST['mno_time_zone'];
                $dtz = new DateTimeZone($mvnx_time_zone);

                $time_in_sofia = new DateTime('now', $dtz);
                $offset = $dtz->getOffset($time_in_sofia) / 3600;

                $timezone_abbreviation = $time_in_sofia->format('T');
                // get first 4 characters
                $timezone_abbreviation = substr($timezone_abbreviation, 0, 4);


                $offset1 = $dtz->getOffset($time_in_sofia);
                $offset_val = CommonFunctions::formatOffset($offset1);

                if ($offset_val == ' 00:00') {

                    $offset_val = '+00:00';
                }


                $time_offset = ($offset < 0 ? $offset : "+" . $offset);


                /*$dateTime_zone = new DateTime();
            $dateTime_zone->setTimeZone(new DateTimeZone($mvnx_time_zone));*/

                //Create Group/Realm/Zone ID

                $zone_name = $db->escapeDB(trim($_POST['zone_name']));//Unique property ID


                $tunnel = $db->escapeDB(trim($_POST['tunnel']));

                $tunnel = $db->getValueAsf("SELECT g.tunnels AS f FROM exp_gateways g WHERE g.gateway_name='$gateway_type'");
                $tunnel = trim($tunnel, '["\"]');


                $pr_tunnel = $db->escapeDB(trim($_POST['pr_tunnel']));
                $pr_tunnel = $db->getValueAsf("SELECT g.tunnels AS f FROM exp_gateways g WHERE g.gateway_name='$pr_gateway_type'");
                $pr_tunnel = trim($pr_tunnel, '["\"]');


                $zone_dec = $db->escapeDB(trim($_POST['zone_dec']));//Description
                $realm = $db->escapeDB(trim($_POST['realm']));//Realm


                $ap_controller = $db->escapeDB(trim($_POST['conroller']));
                $old_ap_controller = $db->escapeDB(trim($_POST['old_conroller']));

                $zoneid = $db->escapeDB(trim($_POST['zone']));
                $groupid = $db->escapeDB(trim($_POST['groups']));

                $sw_controller = $db->escapeDB(trim($_POST['sw_conroller']));

                $groupsid = $db->escapeDB(trim($_POST['groups3']));

                if (empty($groupsid)) {
                    $groupsid = $db->escapeDB(trim($_POST['groups2']));
                    if (empty($groupsid)) {
                        $groupsid = $db->escapeDB(trim($_POST['groups1']));
                        if (empty($groupsid)) {
                            $groupsid = $db->escapeDB(trim($_POST['groups']));
                        }
                    }
                }


                $groupid = $groupsid;

                $newzone = $db->escapeDB(trim($_POST['new_zone']));

                //Assign Default QOS Profile

                $ap_control = $db->escapeDB(trim($_POST['AP_contrl']));
                $ap_control_time = $db->escapeDB(trim($_POST['AP_contrl_time']));
                $get_duration_details = $db->selectDB("SELECT duration,profile_code FROM exp_products_duration WHERE id='$ap_control_time'");
                
                foreach ($get_duration_details['data'] AS $get_durations) {
                    $ap_control_time1 = $get_durations[duration];
                    $ap_control_time2 = $get_durations[profile_code];
                }

                $ap_control_guest = $db->escapeDB(trim($_POST['AP_contrl_guest']));

                /////////////
                /// vTenant QOS
                $qos_vt_guest_def = $db->escapeDB(trim($_POST['vt_guest_def']));
                $qos_vt_guest_pro = $db->escapeDB(trim($_POST['vt_guest_pro']));
                $qos_vt_guest_pri = $db->escapeDB(trim($_POST['vt_guest_pri']));
                ///////////////////////////////
                $subcribers_pro = $db->escapeDB(trim($_POST['subcribers_pro']));


                $ap_control_guest_time = $db->escapeDB(trim($_POST['AP_contrl_guest_time']));

                $get_guest_duration_details = $db->selectDB("SELECT duration,profile_code FROM exp_products_duration WHERE id='$ap_control_guest_time'");
                
                foreach ($get_guest_duration_details['data'] AS $get_guest_durations) {
                    $ap_control_guest_time1 = $get_guest_durations[duration];
                    $ap_control_guest_time2 = $get_guest_durations[profile_code];
                }


                $live_user_name = $_SESSION['user_name'];
                $account_edit = $_POST['edit_account'];
                $edit_distributor_code = $_POST['edit_distributor_code'];
                $edit_distributor_id = $_POST['edit_distributor_id'];


                $user_type_current = "SELECT user_type FROM admin_users WHERE user_name = '$live_user_name'";
                $query_results = $db->selectDB($user_type_current);
               
                foreach ($query_results['data'] AS $row) {
                    $utype = $row[user_type];
                }


                if ($utype == 'MNO') {

                    $query_code = "SELECT user_distributor FROM admin_users u WHERE u.user_name = '$live_user_name'";

                    $query_results = $db->selectDB($query_code);
                   
                    foreach ($query_results['data'] AS $row) {
                        $mno_id = $row[user_distributor];
                    }
                } else {

                    $query_code = "SELECT user_distributor, d.id, d.mno_id
            FROM admin_users u, exp_mno_distributor d
            WHERE u.user_distributor = d.distributor_code AND u.user_name = '$live_user_name'";

                    $query_results = $db->selectDB($query_code);
                    
                    foreach ($query_results['data'] AS $row) {
                        $user_distributor1 = $row[user_distributor];
                        $mno_id = $row[mno_id];
                    }

                }
                if ($create_location_btn_action == 'create_location_next' || $create_location_btn_action == 'add_location_next') {
                    $edit_parent_id = $parent_code;
                    $edit_parent_ac_name = $parent_ac_name;
                    $edit_first_name = $mno_first_name;
                    $edit_last_name = $mno_last_name;
                    $edit_email = $mvnx_email;
                    $edit_parent_package = $parent_package;
                }

                if ($account_edit != '1') {
	                 //new account insert//
	                $br = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_mno_distributor'");
	                //$rowe = mysql_fetch_array($br);
	                $auto_inc = $br['Auto_increment'];
	                
	                $mvnx_id = $user_type1 . $auto_inc;
	                $distributor_code_new=$mvnx_id;
            	}else{
            		$distributor_code_new = $edit_distributor_code;
            	}

                ////////////////// call external api //////////////////
                $network_name = $package_functions->getOptions('NETWORK_PROFILE',$system_package);
                    if(strlen($network_name) == 0){
                        $network_name = $db->setVal('network_name','ADMIN');
                    }
                $profile = $db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$ap_controller'");
                if ($profile == '') {
                    $profile = $db->setVal('wag_ap_name', 'ADMIN');
                    if ($profile == '') {
                        $profile = "non";
                    }
                }
                $automation_property = $_POST['automation_property'];

                $location_common_data = array('name' => $user_name,
                							'contact' => array('name' => $parent_ac_name,
	        													'email' => $mvnx_email,
	        													'voice' => $mvnx_mobile_1),
                							'locations' => array('id' => $parent_code,
	        													'name' => $location_name,
	        													'address' => array('street' => $mvnx_address_1,
				        													'city' => $mvnx_address_2,
				        													'state' => $mvnx_state,
				        													'zip' => $mvnx_zip_code))
                							 );
              if (in_array('GUEST', $_POST['network_type']) && in_array('PRIVATE', $_POST['network_type']) && in_array('VT', $_POST['network_type'])) {
                    $network_type = 'VT-BOTH';
                } elseif (in_array('GUEST', $_POST['network_type']) && in_array('PRIVATE', $_POST['network_type'])) {
                    $network_type = 'BOTH';
                } elseif (in_array('GUEST', $_POST['network_type']) && in_array('VT', $_POST['network_type'])) {
                    $network_type = 'VT-GUEST';
                } elseif (in_array('VT', $_POST['network_type']) && in_array('PRIVATE', $_POST['network_type'])) {
                    $network_type = 'VT-PRIVATE';
                } elseif (in_array('GUEST', $_POST['network_type'])) {
                    $network_type = 'GUEST';
                } elseif (in_array('PRIVATE', $_POST['network_type'])) {
                    $network_type = 'PRIVATE';
                } elseif (in_array('VT', $_POST['network_type'])) {
                    $network_type = 'VT';
                }
                if ($network_type == 'VT' || $network_type == 'VT-PRIVATE'|| $network_type == 'VT-GUEST' || $network_type== 'VT-BOTH') {
                    $vt_wlan_count = $_POST['vt_nu_of_network'];
                }else{
                    $vt_wlan_count = 0;
                }
                if ($network_type == 'GUEST' || $network_type == 'VT-GUEST'|| $network_type == 'VT-BOTH' || $network_type== 'BOTH') {
                    $guest_wlan_count = $_POST['g_nu_of_network'];
                }else{
                    $guest_wlan_count = 0;
                }
                if ($network_type == 'PRIVATE' || $network_type == 'VT-PRIVATE'|| $network_type == 'VT-BOTH' || $network_type== 'BOTH') {
                    $pvt_wlan_count = $_POST['pr_nu_of_network'];
                }else{
                    $pvt_wlan_count = 0;
                }
               
                $data_arr = array('guest' => $guest_wlan_count,
            					'private' => $pvt_wlan_count,
            					'vtenant' => $vt_wlan_count,
            					'wag_name' => $wag_name,
            					'wag_enable' => $wag_enable,
            					'DNS_profile' => $DNS_profile,
            					'DNS_profile_control' => $DNS_profile_control,
            					'mvnx_time_zone' => $mvnx_time_zone,
            					'gateway_type' => $gateway_type,
            					'pr_gateway_type' => $pr_gateway_type,
            					'product' => $ap_control_guest,
            					'mno' => $user_distributor,
                                'old_conroller' => $old_ap_controller,
                                'network_type' => $network_type,
            					'distributor' => $distributor_code_new,
                                'account_edit' => $account_edit);
                

                include_once "external_servers.php";
                $external = new external($system_package,$network_name,$ap_controller,$sw_controller,$icomme_number,$location_name,$user_name,$zoneid,$groupid,$offset_val,$automation_property,$account_edit,$wag_ap_name,$_POST['wlan_automation'],$_POST['vt_icomme'],$data_arr,$field_array,$advanced_features_arr,$timezone_abbreviation,$location_common_data);
                $api_responce=$external->initialConfig();
                $status_code = $api_responce['status_code'];
                if (strlen($api_responce['zoneid'])>0) {
                	$zoneid = $api_responce['zoneid'];
                }
                $wlan_arr = json_encode(array('guest' => $_POST['g_nu_of_network'],
            					'private' => $_POST['pr_nu_of_network'],
            					'vtenant' => $_POST['vt_nu_of_network']));
                $zonecreate = 1; 
                /*$external->setAAAnetwork($network_name);
                $external->setAPController($ap_controller);
                $external->setRealm($icomme_number);
                $external->setZoneID($zoneid);
                $external->setOffset($offset_val);
                $external->setAutomation($automation_property);
                $external->setIsedit($account_edit);
                $external->setwagAp($wag_ap_name);
                $external->setAlematchentry($_POST['wlan_automation']);
                $external->setVTRealm($_POST['vt_icomme']);
                $external->setWlan($wlan_arr);*/

                if ($account_edit == '1') {

                    if ($create_location_btn_action != 'add_location_next') {
                        //1
                        //account update
                        //echo $edit_distributor_code;
                        $get_unique_q = "SELECT `unique_id`,`advanced_features`,`distributor_type`,other_settings FROM `exp_mno_distributor` WHERE `distributor_code`='$edit_distributor_code'";
                        //echo $get_unique_q;
                        $get_unique = $db->selectDB($get_unique_q);
                        $mvnx_num_ssid = 0;

                        foreach ($get_unique['data'] AS $row_u) {
                            $edit_unique_id = $row_u['unique_id'];
                            $advancejson = $row_u['advanced_features'];
                            $new_type = $row_u['distributor_type'];
                            $other_settings = json_decode($row_u['other_settings'],true);
                        }

                        if(isset($_POST['multi_area'])){
                            $other_settings['other_multi_area']=1;

                        }else{
                            $other_settings['other_multi_area']=0;
                        }
                        if(isset($_POST['big_properties'])){
                            $other_settings['big_properties']=1;

                        }else{
                            $other_settings['big_properties']=0;
                        }
                        /*print_r($other_settings);
                        exit();*/
                        
                        //$status_code='200';

                        if ($status_code == '200' && $zonecreate == 1) {

                            $query_cont = $db->select1DB("SELECT `content_filter_enable` FROM `exp_mno_distributor` WHERE `id` = '$edit_distributor_id'");
                            //$query_cont = mysql_fetch_array($sql_con);
                            $content_filter_last = $query_cont['content_filter_enable'];

                            $queryParent = "UPDATE mno_distributor_parent SET system_package='$parent_package'  WHERE parent_id='$parent_code'";

                            $other_settings_json = json_encode($other_settings);
                            $query01 = "UPDATE
                      `exp_mno_distributor`
                    SET
                      `other_settings` = '$other_settings_json',
                      `switch_group_id` = '$groupid',
                      `dpsk_voucher`= '$dpsk_voucher',
                      `gateway_type` = '$gateway_type',
                      `dns_profile` = '$DNS_profile',
                      `dns_profile_enable` = '$dns_profile_enable',
                      `content_filter_enable` = '$dns_profile_enable',
                      `private_gateway_type` = '$pr_gateway_type',
                      `offset_val`='$offset_val',
                      `wag_profile_enable`='$wag_enable',
                      `wag_profile`='$wag_name',
                      `ap_controller`='$ap_controller',
                      `sw_controller`='$sw_controller',
                      `groupsid`='$groupsid',
                      `property_id`='$zone_name',
                      `zone_id`='$zoneid',
                      `system_package`='$customer_type',
                      `bussiness_type` = '$business_type',
                      `network_type`='$network_type',
                      `distributor_name` = '$location_name',
                      `tunnel_type`='$tunnel',
                      `private_tunnel_type`='$pr_tunnel',
                      `category` = '$category_mvnx',
                      `num_of_ssid` = '$mvnx_num_ssid',
                      `bussiness_address1` = '$mvnx_address_1',
                      `bussiness_address2` = '$mvnx_address_2',
                      `bussiness_address3` = '$mvnx_address_3',
                      `country` = '$mvnx_country',
                      `state_region` = '$mvnx_state',
                      `zip` = '$mvnx_zip_code',
                      `phone1` = '$mvnx_mobile_1',
                      `phone2` = '$mvnx_mobile_2',
                      `phone3` = '$mvnx_mobile_3',
                      `time_zone`='$mvnx_time_zone',
                      `wlan_count`='$wlan_arr',
                      `advanced_features`='$advanced_features'
                     
                    WHERE `id` = '$edit_distributor_id'";

                            //UPDATE ICOMS
                            //if(isset($_POST['how_many_buildings'])){

                            $deleIcomQ = "DELETE FROM `exp_icoms` WHERE distributor='$edit_distributor_code'";
                            $db->execDB($deleIcomQ);

                            for ($x = 1; $x <= 25; $x++) {

                                if ($_POST['icom' . $x] != '') {
                                    $icm = $_POST['icom' . $x];

                                    $icmQ = "REPLACE INTO `exp_icoms` (`icom`,`distributor`,`mno_id`,`create_date`) VALUES ('$icm','$edit_distributor_code','$mno_id',NOW())";
                                    $db->execDB($icmQ);
                                }


                            }
                            //}


                            if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $customer_type) == 'NO') {
                                $query03 = "UPDATE
                  `exp_distributor_groups`
                SET

                  `group_name` = '$zone_name',
                  `description` = '$zone_dec',
                  `group_number` = '$realm',
                  `create_date` = NOW()
                WHERE `distributor` = '$edit_distributor_code' ";
                            }

                            $db->execDB(
                                "INSERT INTO `exp_products_distributor_archive`
            (
             `product_code`,
             `product_id`,
             `product_name`,
             `QOS`,
             `QOS_up_link`,
             `distributor_code`,
             `network_type`,
             `time_gap`,
             `max_session`,
             `session_alert`,
             `active_on`,
             `purge_time`,
             `distributor_type`,
             `create_user`,
             `is_enable`,
             `create_date`,
             `last_update`,
             `archive_by`,
             `archive_date`)
             SELECT
          `product_code`,
          `product_id`,
          `product_name`,
          `QOS`,
          `QOS_up_link`,
          `distributor_code`,
          `network_type`,
          `time_gap`,
          `max_session`,
          `session_alert`,
          `active_on`,
          `purge_time`,
          `distributor_type`,
          `create_user`,
          `is_enable`,
          `create_date`,
          `last_update`,
          '$user_name',
          NOW()
        FROM `exp_products_distributor`
        WHERE distributor_code='$edit_distributor_code'"
                            );

                            $deleteqos = "DELETE FROM `exp_qos_distributor` WHERE `distributor_code`='$edit_distributor_code'";
                            $db->execDB($deleteqos);

                            if (!empty($_POST['qos_probation'])) {
                                // Loop to store and display values of individual checked checkbox.
                                foreach ($_POST['qos_probation'] as $selected) {
                                    $query18 = "INSERT INTO `exp_qos_distributor`
                    (`qos_code`,
                     `qos_id`,
                     `distributor_code`,
                     `is_enable`,
                     `create_date`)
                     SELECT `qos_code`,`qos_id`,'$edit_distributor_code','1',NOW()
                     FROM `exp_qos` WHERE `id`='$selected'";
                                    $db->execDB($query18);
                                }
                            }


                            $db->execDB("DELETE FROM `exp_products_distributor` WHERE  `distributor_code`='$edit_distributor_code'");


                            $query04 = "INSERT INTO `exp_products_distributor`
            (`product_code`,
             `product_id`,
             `product_name`,
             `QOS`,
             `QOS_up_link`,
             `distributor_code`,
             `network_type`,
             `max_session`,
             `session_alert`,
             `purge_time`,
             `create_user`,
             `is_enable`,
             `create_date`)
             SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$edit_distributor_code',`network_type`,
             `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
             FROM `exp_products` WHERE `product_id` IN ('$ap_control_guest','$ap_control')";


                            $query_vt_qos_1 = "INSERT INTO `exp_products_distributor`
                        (`product_code`,
                         `product_id`,
                         `product_name`,
                         `QOS`,
                         `QOS_up_link`,
                         `distributor_code`,
                         `distributor_type`,
                         `network_type`,
                         `max_session`,
                         `session_alert`,
                         `purge_time`,
                         `create_user`,
                         `is_enable`,
                         `create_date`)
                         SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$edit_distributor_code','','VT-DEFAULT',
                         `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
                         FROM `exp_products` WHERE `product_id` ='$qos_vt_guest_def'";

                            $query_vt_qos_2 = "INSERT INTO `exp_products_distributor`
                        (`product_code`,
                         `product_id`,
                         `product_name`,
                         `QOS`,
                         `QOS_up_link`,
                         `distributor_code`,
                         `distributor_type`,
                         `network_type`,
                         `max_session`,
                         `session_alert`,
                         `purge_time`,
                         `create_user`,
                         `is_enable`,
                         `create_date`)
                         SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$edit_distributor_code','','VT-PROBATION',
                         `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
                         FROM `exp_products` WHERE `product_id` ='$qos_vt_guest_pro'";

                            $query_vt_qos_3 = "INSERT INTO `exp_products_distributor`
                        (`product_code`,
                         `product_id`,
                         `product_name`,
                         `QOS`,
                         `QOS_up_link`,
                         `distributor_code`,
                         `distributor_type`,
                         `network_type`,
                         `max_session`,
                         `session_alert`,
                         `purge_time`,
                         `create_user`,
                         `is_enable`,
                         `create_date`)
                         SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$edit_distributor_code','','VT-PREMIUM',
                         `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
                         FROM `exp_products` WHERE `product_id` ='$qos_vt_guest_pri'";


                            $query_subcribers_qos_1 = "INSERT INTO `exp_products_distributor`
                        (`product_code`,
                         `product_id`,
                         `product_name`,
                         `QOS`,
                         `QOS_up_link`,
                         `distributor_code`,
                         `distributor_type`,
                         `network_type`,
                         `max_session`,
                         `session_alert`,
                         `purge_time`,
                         `create_user`,
                         `is_enable`,
                         `create_date`)
                         SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$edit_distributor_code','','SUBCRIBE',
                         `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
                         FROM `exp_products` WHERE `product_id` ='$subcribers_pro'";


                            $duration_profil_1 = "UPDATE exp_products_distributor SET time_gap='$ap_control_guest_time1',duration_prof_code='$ap_control_guest_time2' WHERE distributor_code='$edit_distributor_code' AND network_type='guest'";
                            $duration_profil_2 = "UPDATE exp_products_distributor SET time_gap='$ap_control_time1',duration_prof_code='$ap_control_time2' WHERE distributor_code='$edit_distributor_code' AND network_type='private'";


                            $up01 = $db->execDB($query01);
                            $upPare = $db->execDB($queryParent);

                            if ($network_type == 'VT') {

                                $archive = "INSERT INTO mdu_distributor_organizations_archive (distributor_code, property_id, create_user, create_date,last_update, archive_by, archive_date)
SELECT distributor_code,property_id,create_user,create_date,last_update,'$user_name',NOW() FROM mdu_distributor_organizations WHERE distributor_code='$edit_distributor_code'";

                                $db->execDB($archive);

                                $del = "DELETE FROM mdu_distributor_organizations WHERE distributor_code='$edit_distributor_code'";
                                $db->execDB($del);

                                $query012 = "INSERT INTO mdu_distributor_organizations(distributor_code,property_id,create_user,create_date) 
                          VALUES('$edit_distributor_code','$vt_icomme_number','$user_name',NOW())";
                                $db->execDB($query012);

                                $update_user = "UPDATE admin_users SET verification_number='$vt_icomme_number' WHERE user_distributor='$edit_distributor_code' AND `verification_number` IS NOT NULL";
                                $db->execDB($update_user);

                                $update_dis = "UPDATE exp_mno_distributor SET verification_number='$vt_icomme_number' WHERE distributor_code='$edit_distributor_code'";
                                $db->execDB($update_dis);

                                $update_g_tag = "UPDATE exp_mno_distributor_group_tag SET tag_name='$vt_icomme_number' WHERE distributor='$edit_distributor_code'";
                                $db->execDB($update_g_tag);

                                if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $customer_type) == 'NO') {
                                    $update_groups = "UPDATE exp_distributor_groups SET group_name='$vt_icomme_number' WHERE distributor='$edit_distributor_code'";
                                    $db->execDB($update_groups);
                                }


                            } elseif ($network_type == 'VT-GUEST' || $network_type == 'VT-PRIVATE' || $network_type == 'VT-BOTH') {


                                $archive = "INSERT INTO mdu_distributor_organizations_archive (distributor_code, property_id, create_user, create_date,last_update, archive_by, archive_date)
SELECT distributor_code,property_id,create_user,create_date,last_update,'$user_name',NOW() FROM mdu_distributor_organizations WHERE distributor_code='$edit_distributor_code'";

                                $db->execDB($archive);

                                $theme_up = "UPDATE exp_themes SET ref_id='$icomme_number' WHERE distributor='$edit_distributor_code'";
                                $db->execDB($theme_up);

                                $del = "DELETE FROM mdu_distributor_organizations WHERE distributor_code='$edit_distributor_code'";
                                $db->execDB($del);

                                $query012 = "INSERT INTO mdu_distributor_organizations(distributor_code,property_id,create_user,create_date) 
                          VALUES('$edit_distributor_code','$vt_icomme_number','$user_name',NOW())";
                                $db->execDB($query012);

                                $update_user = "UPDATE admin_users SET verification_number='$icomme_number' WHERE user_distributor='$edit_distributor_code' AND `verification_number` IS NOT NULL";
                                $db->execDB($update_user);

                                $update_dis = "UPDATE exp_mno_distributor SET verification_number='$icomme_number' WHERE distributor_code='$edit_distributor_code'";
                                $db->execDB($update_dis);

                                $update_g_tag = "UPDATE exp_mno_distributor_group_tag SET tag_name='$icomme_number' WHERE distributor='$edit_distributor_code'";
                                $db->execDB($update_g_tag);

                                if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $customer_type) == 'NO') {
                                    $update_groups = "UPDATE exp_distributor_groups SET group_name='$icomme_number' WHERE distributor='$edit_distributor_code'";
                                    $db->execDB($update_groups);
                                }


                            } else {
                                $archive = "INSERT INTO mdu_distributor_organizations_archive (distributor_code, property_id, create_user, create_date,last_update, archive_by, archive_date)
SELECT distributor_code,property_id,create_user,create_date,last_update,'$user_name',NOW() FROM mdu_distributor_organizations WHERE distributor_code='$edit_distributor_code'";

                                $db->execDB($archive);

                                $theme_up = "UPDATE exp_themes SET ref_id='$icomme_number' WHERE distributor='$edit_distributor_code'";
                                $db->execDB($theme_up);

                                $del = "DELETE FROM mdu_distributor_organizations WHERE distributor_code='$edit_distributor_code'";
                                $db->execDB($del);

                                $update_user = "UPDATE admin_users SET verification_number='$icomme_number' WHERE user_distributor='$edit_distributor_code' AND `verification_number` IS NOT NULL";
                                $db->execDB($update_user);

                                $update_dis = "UPDATE exp_mno_distributor SET verification_number='$icomme_number' WHERE distributor_code='$edit_distributor_code'";
                                $db->execDB($update_dis);

                                $update_g_tag = "UPDATE exp_mno_distributor_group_tag SET tag_name='$icomme_number' WHERE distributor='$edit_distributor_code'";
                                $db->execDB($update_g_tag);

                                if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $customer_type) == 'NO') {
                                    $update_groups = "UPDATE exp_distributor_groups SET group_name='$icomme_number' WHERE distributor='$edit_distributor_code'";
                                    $db->execDB($update_groups);
                                }
                            }

                            $ssmsg = $message_functions->showNameMessage('property_send_email_failed', $location_name_s);

                            $advancearray = json_decode($advancejson, true);

                            //$db->execDB("SET AUTOCOMMIT=0");
                            //$db->execDB("START TRANSACTION");
                            $db->autoCommit();

                            $up03 = $db->execDB($query03);
                            $up04 = $db->execDB($query04);
                            $qos01 = $db->execDB($query_vt_qos_1);
                            $qos02 = $db->execDB($query_vt_qos_2);
                            $qos03 = $db->execDB($query_vt_qos_3);
                            $up05 = $db->execDB($duration_profil_1);
                            $up06 = $db->execDB($duration_profil_2);
                            //$up05 = mysql_query($query05);
                            $qos07 = $db->execDB($query_subcribers_qos_1);

                            /////////////////////support role/////////////////
                            //echo $up01."//".$up03."//".$up04."//".$up05."//".$up06."//".$qos01."//".$qos02."//".$qos03;

                            if ($up01===true && $up03===true && $up04===true && $up05===true && $up06===true && $qos01===true && $qos02===true && $qos03===true) {
                                //$db->execDB("COMMIT");
                                $db->commit();

                                if ($content_filter_last != $dns_profile_enable) {
                                    if ($dns_profile_enable == 1) {
                                        $db->changeFeature(new FeatureChange('CONTENT_FILTER', 'Activated', $edit_distributor_code, $new_type, ''));
                                    } else {
                                        $db->changeFeature(new FeatureChange('CONTENT_FILTER', 'Deactivated', $edit_distributor_code, $new_type, ''));
                                    }
                                }


                                $network_at_a_glancen = $advanced_features_arr['network_at_a_glance'];
                                $x_authenticationn = $advanced_features_arr['802.2x_authentication'];
                                $top_applicationsn = $advanced_features_arr['top_applications'];

                                foreach ($advancearray as $key => $value2) {

                                    if ($key == 'network_at_a_glance') {
                                        if ($network_at_a_glancen != $value2) {
                                            if ($network_at_a_glancen == 1) {
                                                $db->changeFeature(new FeatureChange('NETWORK_AT_A_GLANCE', 'Activated', $edit_distributor_code, $new_type, ''));
                                            } else {
                                                $db->changeFeature(new FeatureChange('NETWORK_AT_A_GLANCE', 'Deactivated', $edit_distributor_code, $new_type, ''));
                                            }
                                        }
                                    }
                                    if ($key == '802.2x_authentication') {
                                        if ($x_authenticationn != $value2) {
                                            if ($x_authenticationn == 1) {
                                                $db->changeFeature(new FeatureChange('802.1X', 'Activated', $edit_distributor_code, $new_type, ''));
                                            } else {
                                                $db->changeFeature(new FeatureChange('802.1X', 'Deactivated', $edit_distributor_code, $new_type, ''));
                                            }
                                        }
                                    }
                                    if ($key == 'top_applications') {
                                        if ($top_applicationsn != $value2) {
                                            if ($top_applicationsn == 1) {
                                                $db->changeFeature(new FeatureChange('TOP_10_APPLICATION', 'Activated', $edit_distributor_code, $new_type, ''));
                                            } else {
                                                $db->changeFeature(new FeatureChange('TOP_10_APPLICATION', 'Deactivated', $edit_distributor_code, $new_type, ''));
                                            }
                                        }
                                    }
                                }


                                //$db->execDB("COMMIT");
                                $db->commit();

                                $db->userLog($user_name, $script, 'Update Location', $location_name_s);
                                $success_msg = $message_functions->showNameMessage('property_creation_success', $location_name_s);// "Account [" . $location_name_s . "] has been updated";
                                $sess_msg_id = 'msg_location_update';
                                $_SESSION[msg5] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                            } else {
                                
                                //$db->execDB("ROLLBACK");
                                $db->rollback();

                                $success_msg = $message_functions->showNameMessage('property_creation_failed', $location_name_s, 2002); //"[2002] Account [" . $location_name_s . "] update failed";
                                $sess_msg_id = 'msg_location_update';
                                $_SESSION[msg5] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                            }
                        } else {
                            $success_msg = $message_functions->showNameMessage('property_creation_failed', $location_name_s, 2009); //"[2009] Account [" . $location_name_s . "] update failed";
                            $sess_msg_id = 'msg_location_update';
                            $_SESSION[msg5] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                        }

                        //$_SESSION[$sess_msg_id] = "<div class='alert alert-".$al_type."><strong>" . $success_msg . "</strong><button type='button' class='close' data-dismiss='alert'>×</button></div>";
                    }
                }
                else {//1

                    $other_settings = [];

                    if(isset($_POST['multi_area'])){
                        $other_settings['other_multi_area']=1;
                    }
                    if(isset($_POST['big_properties'])){
                        $other_settings['big_properties']=1;
                    }
                    $password = CommonFunctions::randomPassword();
                    $parend_password = CommonFunctions::randomPassword();

                    $tz = $mvnx_time_zone;
                    $theme = 'FB_MANUAL';
                    $title = 'Welcome to ' . $db->escapeDB($location_name_s);

                    // echo $wag_ap_name;
                    if ($wag_ap_name == 'NO_PROFILE') {
                        //API not call//
                        $status_code = '200';
                    } else {}
                    // echo $mvnx_id; $ap_controller  ap_controller

                    ////////theme submit////////////
                    $admin_features = $_POST['admin_features'];
                    $array1 = array();
                    foreach ($admin_features as $value) {
                        $parent_features_enable = $db->getValueAsf("SELECT feature_json as f FROM exp_service_activation_features WHERE service_id='$value'");
                        $access_type = json_decode($parent_features_enable, true)['id'];
                        $parent_features_access = $_POST[$access_type];
                        if (strlen($parent_features_access) < 1) {
                            $parent_features_access = 0;
                        }
                        $array = array($value => $parent_features_access);
                        $array1 = array_merge($array1, $array);
                    }
                    //print_r($array1);
                    $feature_jsonn = $db->escapeDB(json_encode($array1));
                    //$feature_jsonn=mysql_real_escape_string(json_encode($admin_features));

                    //$status_code = "200" ;$zonecreate=1;
                    if ($status_code == "200" && $zonecreate == 1) {//1
                       // $db->execDB("SET AUTOCOMMIT=0");
                        //$db->execDB("START TRANSACTION");
                        $db->autoCommit();

                        //new account insert//
                        /*$br = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_mno_distributor'");
                        //$rowe = mysql_fetch_array($br);
                        $auto_inc = $br['Auto_increment'];
                        
                        $mvnx_id = $user_type1 . $auto_inc;*/
                        $mvnx = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
                        $unique_id = '2' . $mvnx;

                        $dis_user_name = uniqid($mvnx_id);
                        $parent_user_name = str_replace(' ', '_', strtolower(substr($mvnx_full_name, 0, 5) . $auto_inc));


                        $parent_product = $_POST['parent_package_type'];//$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);

                        $mvnx_num_ssid = 0;
                        ///////////////////////////////

                        if (!empty($_POST['qos_probation'])) {
                            // Loop to store and display values of individual checked checkbox.
                            foreach ($_POST['qos_probation'] as $selected) {
                                $query18 = "INSERT INTO `exp_qos_distributor`
                    (`qos_code`,
                     `qos_id`,
                     `distributor_code`,
                     `is_enable`,
                     `create_date`)
                     SELECT `qos_code`,`qos_id`,'$mvnx_id','1',NOW()
                     FROM `exp_qos` WHERE `id`='$selected'";
                                $db->execDB($query18);

                            }
                        }
                        $other_settings_json = json_encode($other_settings);

                        $query01 = "INSERT INTO `exp_mno_distributor` (`other_settings`,`switch_group_id`,dns_profile,dns_profile_enable,content_filter_enable,parent_id,`gateway_type`,`private_gateway_type`,`offset_val`,`wag_profile_enable`,`wag_profile`,`property_id`,`verification_number`,`network_type`,`ap_controller`,`system_package`,`zone_id`,`tunnel_type`,`private_tunnel_type`,`unique_id`,`distributor_code`, `distributor_name`,`bussiness_type`, `distributor_type`,`category`,num_of_ssid, `mno_id`, `parent_code`,`bussiness_address1`,`bussiness_address2`,`bussiness_address3`,`country`,`state_region`,`zip`,`phone1`,`phone2`,`phone3`,theme,site_title,time_zone,`language`,`advanced_features`,`is_enable`,`create_date`,`create_user`,`sw_controller`,`groupsid`,`default_campaign_id`,`dpsk_voucher`)
                    VALUES ('$other_settings_json','$groupid','$DNS_profile','$dns_profile_enable','$dns_profile_enable','$parent_code','$gateway_type','$pr_gateway_type','$offset_val','$wag_enable','$wag_name','$zone_name','$icomme_number','$network_type','$ap_controller','$customer_type','$zoneid','$tunnel','$pr_tunnel','$unique_id','$mvnx_id', '$location_name', '$business_type','$user_type1','$category_mvnx','$mvnx_num_ssid', '$mno_id', '$user_distributor1','$mvnx_address_1','$mvnx_address_2','$mvnx_address_3','$mvnx_country','$mvnx_state','$mvnx_zip_code','$mvnx_mobile_1','$mvnx_mobile_2','$mvnx_mobile_3','$theme','$title','$tz','en','$advanced_features','0',now(),'$live_user_name','$sw_controller', '$groupsid','0','$dpsk_voucher')";


                        $query012 = "INSERT INTO mdu_distributor_organizations(distributor_code,property_id,create_user,create_date) 
                          VALUES('$mvnx_id','$vt_icomme_number','$user_name',NOW())";

                        $query03 = "INSERT INTO mno_distributor_parent (account_name,parent_id, system_package, mno_id, features, create_date, create_user) VALUES ('$parent_ac_name','$parent_code', '$parent_product','$mno_id','$feature_jsonn', NOW(),'$user_name')";

                        $query02 = "INSERT INTO `admin_users` (`user_name`,`verification_number`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `is_enable`, `create_date`,`create_user`)
            VALUES ('$dis_user_name','$icomme_number',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$password'))))), 'admin', '$user_type1','$mvnx_id', '', '', '', '8', NOW(),'$user_name')";

                        $query04 = "INSERT INTO `admin_users` (`user_name`,`verification_number`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `is_enable`, `create_date`,`create_user`)
            VALUES ('$parent_user_name','$parent_code',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$parend_password'))))), 'admin', 'MVNO_ADMIN','$parent_code', '$mvnx_full_name', '$mvnx_email', '$mvnx_mobile_1', '2', NOW(),'$user_name')";

                        if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $customer_type) == 'NO') {
                            $distributor_group = "INSERT INTO `exp_distributor_groups` (`group_name`,`description`,`group_number`,`distributor`,`create_date`)
                                VALUES ('$icomme_number','$zone_dec','$realm','$mvnx_id',NOW())";
                        }
                        $theme_tag_arr = array("en"=>$mvnx_id.'_default');
                        $mvnx_id_default = json_encode($theme_tag_arr);
                        $distributor_group_tag = "INSERT INTO `exp_mno_distributor_group_tag` (
                                  `tag_name`,
                                  `description`,
                                  `distributor`,
                                  `theme_name`,
                                  `create_date`,
                                  `create_user`
                                )
                                VALUES
                                  (
                                    '$icomme_number',
                                    '$zone_dec',
                                    '$mvnx_id',
                                    '$mvnx_id_default',
                                    NOW(),
                                    '$user_name'
                                  )";


                        $profile_venue = "INSERT INTO `exp_products_distributor`
            (distributor_type,
            `product_code`,
             `product_id`,
             `product_name`,
             `QOS`,
             `QOS_up_link`,
             `distributor_code`,
             `network_type`,
             `max_session`,
             `session_alert`,
             `purge_time`,
             `create_user`,
             `is_enable`,
             `create_date`)
             SELECT '',`product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$mvnx_id',`network_type`,
             `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
             FROM `exp_products` WHERE `product_id` IN ('$ap_control_guest','$ap_control')";

                        $query_vt_qos_1 = "INSERT INTO `exp_products_distributor`
                        (`product_code`,
                         `product_id`,
                         `product_name`,
                         `QOS`,
                         `QOS_up_link`,
                         `distributor_code`,
                         `distributor_type`,
                         `network_type`,
                         `max_session`,
                         `session_alert`,
                         `purge_time`,
                         `create_user`,
                         `is_enable`,
                         `create_date`)
                         SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$mvnx_id','','VT-DEFAULT',
                         `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
                         FROM `exp_products` WHERE `product_id` ='$qos_vt_guest_def'";

                        $query_vt_qos_2 = "INSERT INTO `exp_products_distributor`
                        (`product_code`,
                         `product_id`,
                         `product_name`,
                         `QOS`,
                         `QOS_up_link`,
                         `distributor_code`,
                         `distributor_type`,
                         `network_type`,
                         `max_session`,
                         `session_alert`,
                         `purge_time`,
                         `create_user`,
                         `is_enable`,
                         `create_date`)
                         SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$mvnx_id','','VT-PROBATION',
                         `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
                         FROM `exp_products` WHERE `product_id` ='$qos_vt_guest_pro'";

                        $query_vt_qos_3 = "INSERT INTO `exp_products_distributor`
                        (`product_code`,
                         `product_id`,
                         `product_name`,
                         `QOS`,
                         `QOS_up_link`,
                         `distributor_code`,
                         `distributor_type`,
                         `network_type`,
                         `max_session`,
                         `session_alert`,
                         `purge_time`,
                         `create_user`,
                         `is_enable`,
                         `create_date`)
                         SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$mvnx_id','','VT-PREMIUM',
                         `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
                         FROM `exp_products` WHERE `product_id` ='$qos_vt_guest_pri'";

                        $query_subcribers_qos_1 = "INSERT INTO `exp_products_distributor`
                        (`product_code`,
                         `product_id`,
                         `product_name`,
                         `QOS`,
                         `QOS_up_link`,
                         `distributor_code`,
                         `distributor_type`,
                         `network_type`,
                         `max_session`,
                         `session_alert`,
                         `purge_time`,
                         `create_user`,
                         `is_enable`,
                         `create_date`)
                         SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$mvnx_id','','SUBCRIBE',
                         `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
                         FROM `exp_products` WHERE `product_id` ='$subcribers_pro'";

                        $duration_profil_1 = "UPDATE exp_products_distributor SET time_gap='$ap_control_guest_time1',duration_prof_code='$ap_control_guest_time2' WHERE distributor_code='$mvnx_id' AND network_type='guest'";
                        $duration_profil_2 = "UPDATE exp_products_distributor SET time_gap='$ap_control_time1',duration_prof_code='$ap_control_time2' WHERE distributor_code='$mvnx_id' AND network_type='private'";

                        $network_wlan_ex = "INSERT INTO `exp_network_realm` (`id`, `realm`, `network_realm`, `network_type`, `wLan_id`, `wLan_name`, `vLan_id`, `create_user`, `create_date`, `last_update`) VALUES (NULL, '$icomme_number', '$icomme_number', '', '', '', '', '$mno_id', NOW(), NOW())";
                        $db->execDB($network_wlan_ex);

                        if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'create_location_next') {
                            $ex3 = $db->execDB($query03);
                            if ($ex3 === true) {
                                $create_par = 'yes';
                            } else {
                                $create_par = '';
                            }

                        } else {
                            $ex3 = true;
                            $create_par = 'yes';
                        }


                        if ($create_par == 'yes') {
                            $ex0 = $db->execDB($query01);
                            // mysql_query($apquery1);

                            if ($network_type == 'VT' || $network_type == 'VT-GUEST' || $network_type == 'VT-PRIVATE' || $network_type == 'VT-BOTH') {
                                $db->execDB($query012);
                            }

                            // $ex10= mysql_query($apmno_dis1);

                            // if ($ap_mac2 != "") {
                            //     mysql_query($apquery2);
                            //     mysql_query($apmno_dis2);
                            // }

                            // if ($ap_mac3 != "") {

                            //     mysql_query($apquery3);
                            //     mysql_query($apmno_dis3);
                            // }


                            // mysql_query($ssid_guest_query);
                            // mysql_query($ssid_private_query);

                            $ex1 = $db->execDB($distributor_group);
                            $ex2 = $db->execDB($distributor_group_tag);

                            $ex3_1 = $db->execDB($profile_venue);
                            $ex4 = $db->execDB($query_vt_qos_1);
                            $ex5 = $db->execDB($query_vt_qos_2);
                            $ex6 = $db->execDB($query_vt_qos_3);
                            $ex7 = $db->execDB($duration_profil_1);
                            $ex8 = $db->execDB($duration_profil_2);
                            //mysql_query($profile_venue2);
                            $ex9 = $db->execDB($query_subcribers_qos_1);


                            //create manual and auto  passcode
                            $manua_passcode = CommonFunctions::randomPasswordlength(8);
                            $auto_passcode = CommonFunctions::randomPasswordlength(8);
                            $cust_vo = $db->execDB("INSERT INTO `exp_customer_vouchers`(`voucher_number`,`reference`,`voucher_type`,`type`,`redeem_count`,`voucher_status`,`create_date`,`create_user`) 
                              VALUES('$manua_passcode','$mvnx_id','DISTRIBUTOR','Manual','0','0',NOW(),'$user_name')");
                            $ex0_1 = $db->execDB($query02);
                            if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'create_location_next') {
                                $ex4_1 = $db->execDB($query04);
                            }

                            $passcode_renewal_time = "08:00:00";
                            $r = 'DATE_ADD(CONVERT_TZ(NOW(),\'SYSTEM\',\'' . $offset_val . '\'),INTERVAL 1 WEEK)';
                            $e = 'DATE_ADD(DATE_ADD(CONVERT_TZ(NOW(),\'SYSTEM\',\'' . $offset_val . '\'),INTERVAL 1 WEEK),INTERVAL 12 HOUR)';

                            //echo $r = 'CONVERT_TZ(DATE_ADD(CONCAT(DATE_FORMAT(CONVERT_TZ(NOW(),\'SYSTEM\',\''.$offset_val.'\'),\'%Y-%m-%d \'),\''.$passcode_renewal_time.'\'),INTERVAL 1 WEEK),\''.$offset.'\',\'SYSTEM\') ';
                            // echo $e = 'CONVERT_TZ(DATE_ADD(DATE_ADD(CONCAT(DATE_FORMAT(CONVERT_TZ(NOW(),\'SYSTEM\',\''.$offset_val.'\'),\'%Y-%m-%d \'),\''.$passcode_renewal_time.'\') ,INTERVAL 1 WEEK),INTERVAL 12 HOUR),\''.$offset.'\',\'SYSTEM\') ';

                            $auto_pass_ins_q = "INSERT INTO `exp_customer_vouchers` (`voucher_prefix`,`reference_email`,`refresh_date`,frequency,buffer_duration,expire_date,start_date,type,`voucher_number`, `reference`, `voucher_type`,`redeem_count`, `voucher_status`, `create_date`, `create_user`)              
                                VALUES ('','$mvnx_email', $r ,'Weekly','12',$e , NOW(),'Auto','$auto_passcode', '$mvnx_id', 'DISTRIBUTOR', '0', '1', NOW(), '$user_name')";
                            $insert_passcode = $db->execDB($auto_pass_ins_q);


                        }
                        $query_result = false;
                        if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'create_location_next') {
                            if ($br && $ex0===true && $ex1===true && $ex2===true && $ex3===true && $ex3_1===true && $ex4===true && $ex5===true && $ex6===true && $ex7===true && $ex8===true && $ex9===true && $cust_vo===true && $ex0_1===true && $ex4_1===true && $insert_passcode===true) {
                                $query_result = true;
                            }
                        } else {
                            //echo $ex0.$ex1.$ex2.$ex3.$ex3_1.$ex4.$ex5.$ex6.$ex7.$ex8.$ex9.$cust_vo.$ex0_1.$insert_passcode;
                            if ($br && $ex0===true && $ex1===true && $ex2===true && $ex3===true && $ex3_1===true && $ex4===true && $ex5===true && $ex6===true && $ex7===true && $ex8===true && $ex9===true && $cust_vo===true && $ex0_1===true && $insert_passcode===true) {
                                $query_result = true;
                            }
                        }

                        if ($query_result) {
                            if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'add_location_submit') {

                                if ($_SESSION['new_location'] == 'yes') {
                                    $db->userLog($user_name, $script, 'New Location Create', $location_name_s);
                                    $success_msg = $message_functions->showNameMessage('venue_add_success', $location_name_s);
                                } else {
                                    $db->userLog($user_name, $script, 'Location Create', $location_name_s);
                                    $success_msg = $message_functions->showNameMessage('venue_create_success', $location_name_s);
                                }
                            } else {

                                if ($_SESSION['new_location'] == 'yes') {
                                    $db->userLog($user_name, $script, 'New Location Create', $location_name_s);
                                    $success_msg = $message_functions->showNameMessage('venue_add_success', $location_name_s);
                                } else {
                                    $db->userLog($user_name, $script, 'Location Create', $location_name_s);
                                    $success_msg = $message_functions->showNameMessage('venue_loc_add_success', $location_name_s);
                                }
                            }
                            $sess_id = 'msg5';

                            $exec_cmd = 'php -f'.dirname(__FILE__).'/ajax/createDummyGraphData.php '.$mvnx_id.' > /dev/null 2>&1 & echo $!; ';
                            $pid = exec($exec_cmd , $output);

                            $package_btitle = $package_functions->getOptions("BROWSER_TITLE", $system_package);

                            if ($package_btitle == '' || $package_btitle == NULL) {

                                $package_btitle = 'Welcome to Guest WiFi Access';
                            }

                            //$theme_id=$mvnx_id.'_default';
                            //$theme_name=$cusbiss_name.'-GUEST-ModernHorizontal-'.date("Y-m-d H:i:s");

                            //$welcome_text='<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Courtesy Services Provided by '.$cusbiss_name.'</span></p>';

                            //$query_them = "";
                            $cusbiss_name = $db->escapeDB($cusbiss_name);


                            $theme_create = $package_functions->getOptions('THEME_CREATE',$customer_type);

                            if ($theme_create == 'ADVANCED' || $hospitality_feature) {
                                $gt_template_optioncode = $package_functions->getOptions('TEMPLATE_ACTIVE', $customer_type, 'MVNO');
                                $pieces1 = explode(",", $gt_template_optioncode);
                                $query_them = $package_functions->getOptions('INIT_THEME', $customer_type);
                                $query_themarr = explode("||", $query_them);
                                $theme_q = $query_themarr[0];
                                $def_theme_details_id = $query_themarr[1];
                                $br = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_themes_details'");
                                //$rowe = mysql_fetch_array($br);
                                $auto_inc_theme_details_id = $br['Auto_increment'];

                                $isDynamic = package_functions::isDynamic($system_package);
                                $primary_color = '';
                                if($isDynamic){
                                    $primary_color = $package_functions->getOptionsBranding('PRIMARY_COLOR', $system_package);
                                    $row = $db->select1DB("SELECT theme_data FROM exp_themes_details WHERE  unique_id='$def_theme_details_id'");
                                    $theme_q1 = $row['theme_data'];
                                    $theme_vars1 = array(
                                        '{$primary_color}' => $primary_color
                                    );
                            
                                    $theme_data = strtr($theme_q1, $theme_vars1);
                                    $query1 = "INSERT INTO exp_themes_details
                                                (unique_id, theme_data,completed,create_date,updated_by)
                                                VALUES ('$auto_inc_theme_details_id', '$theme_data',1,NOW(),'admin')";
                                    $db->execDB($query1);
                                    
                                }else{
                                    $db->execDB("INSERT INTO `exp_themes_details` (
                                        `unique_id`,
                                        `theme_data`,
                                        `completed`,
                                        `create_date`,
                                        `updated_by`
                                    )SELECT 
                                        '$auto_inc_theme_details_id',
                                        `theme_data`,
                                                1,
                                        NOW(),
                                        `updated_by` FROM `exp_themes_details` WHERE `unique_id`='$def_theme_details_id'");
                                }
                                
                                

                                $theme_vars = array(
                                    '{$mvnx_id}' => $mvnx_id,
                                    '{$cusbiss_name}' => $cusbiss_name,
                                    '{$package_btitle}' => $package_btitle,
                                    '{$user_name}' => $user_name,
                                    '{$auto_inc_theme_details_id}' => $auto_inc_theme_details_id,
                                    '{$theme_name}' => $pieces1[0],
                                    '{$icomme_number}' => $icomme_number
                                );

                                $query_them = strtr($theme_q, $theme_vars);

                            } else {
                                $theme_vars = array(
                                    '{$mvnx_id}' => $mvnx_id,
                                    '{$cusbiss_name}' => $cusbiss_name,
                                    '{$package_btitle}' => $package_btitle,
                                    '{$user_name}' => $user_name,
                                    '{$icomme_number}' => $icomme_number
                                );
                                $theme_q = $package_functions->getOptions('INIT_THEME', $customer_type);
                                $query_themarr = explode("||", $theme_q);
                                $theme_q = $query_themarr[0];
                                $query_them = strtr($theme_q, $theme_vars);

                            }
                            $db->execDB($query_them);

                            if (strlen($DNS_profile) > 0) {

                                if ($dns_profile_enable == 1) {
                                    $db->changeFeature(new FeatureChange('CONTENT_FILTER', 'Activated', $mvnx_id, $user_type1, ''));

                                } else {
                                    //$db->changeFeature(new FeatureChange('CONTENT_FILTER', 'Deactivated', $mvnx_id, $user_type1, ''));

                                }

                            }
                            $advanced_featuresarr = $_POST['advanced_features'];
                            foreach ($advanced_featuresarr as $value) {
                                if ($value == 'network_at_a_glance') {
                                    $db->changeFeature(new FeatureChange('NETWORK_AT_A_GLANCE', 'Activated', $mvnx_id, $user_type1, ''));
                                }
                                if ($value == '802.2x_authentication') {
                                    $db->changeFeature(new FeatureChange('802.1X', 'Activated', $mvnx_id, $user_type1, ''));

                                }
                                if ($value == 'top_applications') {
                                    $db->changeFeature(new FeatureChange('TOP_10_APPLICATION', 'Activated', $mvnx_id, $user_type1, ''));

                                }


                            }


                            //INSERT
                            //if(isset($_POST['how_many_buildings'])){

                            for ($x = 1; $x <= 25; $x++) {

                                $icm = $_POST['icom' . $x];

                                if ($icm != '') {

                                    $icmQ = "REPLACE INTO `exp_icoms` (`icom`,`distributor`,`mno_id`,`create_date`) VALUES ('$icm','$mvnx_id','$mno_id',NOW())";

                                    $db->execDB($icmQ);
                                }
                            }
                            //}


                            if ($account_edit != '1') {//2
                                ///////////////Insert default settings////////////////////////////

                                $query10 = "INSERT INTO `exp_settings` (
              `settings_name`,
              `description`,
              `category`,
              `settings_code`,
              `settings_value`,
              `distributor`,
              `create_date`,
              `create_user`)
              (SELECT
              `settings_name`,
              `description`,
              `category`,
              `settings_code`,
              `settings_value`,
              '$mvnx_id',
              NOW(),
              '$live_user_name'
            FROM
              `exp_settings`
            WHERE distributor='ADMIN'
            AND settings_code IN ('ad_waiting','ad_welcome_page'))";

                                //  $ex10 = mysql_query($query10);

                                //////////////////////////////////////////////////

                                /*Email Notification*/
                                if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'add_location_submit' || $_SESSION['new_location'] == 'yes') {
                                    $to = $mvnx_email;
                                    $title = $db->setVal("short_title", $mno_id);

                                    /*if($_SESSION['new_location']!='yes' ){

                            $subject = $db->textTitle('MAIL',$mno_id);
                            if(strlen($subject)==0){
                                $subject=$db->textTitle('ICOMMS_MAIL','ADMIN');
                            }

                        }else{
                            $subject = $db->textTitle('NEW_LOCATION_MAIL',$mno_id);
                            if(strlen($subject)==0){
                                $subject=$db->textTitle('NEW_LOCATION_MAIL','ADMIN');
                            }
                        }*/


                                    $from = strip_tags($db->setVal("email", $mno_id));
                                    if ($from == '') {
                                        $from = strip_tags($db->setVal("email", 'ADMIN'));
                                    }


                                    $login_design = $package_functions->getSectionType("LOGIN_SIGN", $parent_product);
                                    if ($_SESSION['new_location'] != 'yes') {
                                        //old
                                        /*if($url_mod_override=='ON'){
                                //http://216.234.148.168/campaign_portal_demo/optimum/login
                                $link = $db->setVal("global_url", "ADMIN").'/'.$package_functions->getSectionType("LOGIN_SIGN", $parent_product).'/verification';
                            }else{
                                $link = $db->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin&login='.$package_functions->getSectionType('LOGIN_SIGN',$parent_product);
                            }*/


                                        $link = $db->getSystemURL('verification', $login_design);


                                        $email_content = $db->getEmailTemplate('PARENT_INVITE_MAIL', $system_package, 'MNO', $mno_id);
                                        $userQ = "UPDATE admin_users SET activation_email_date =UNIX_TIMESTAMP() WHERE user_name = '$parent_user_name'";
                                        /*$a = $db->textVal('MAIL', $mno_id);
                            if(strlen($a)<1){
                                $a = $db->textVal('MAIL', 'ADMIN');
                            }*/

                                        $a = $email_content[0]['text_details'];
                                        $subject = $email_content[0]['title'];

                                    } else {
                                        //new
                                        /*if($url_mod_override=='ON'){
                                //http://216.234.148.168/campaign_portal_demo/optimum/login
                                $link = $db->setVal("global_url", "ADMIN").'/'.$package_functions->getSectionType("LOGIN_SIGN", $parent_product).'/login';
                            }else{
                                $link = $db->setVal("global_url", "ADMIN") . '/index.php?login='.$package_functions->getSectionType('LOGIN_SIGN',$parent_product);
                            }*/
                                        $userQ1 = '';
                                        $link = $db->getSystemURL('login', $login_design);

                                        /*$a = $db->textVal('NEW_LOCATION_MAIL', $mno_id);
                            if(strlen($a)<1){
                                $a = $db->textVal('NEW_LOCATION_MAIL', 'ADMIN');
                            }*/

                                        $email_content = $db->getEmailTemplate('VENUE_NEW_LOCATION', $system_package, 'MNO', $mno_id);


                                        $parent_code = $icomme_number;

                                        $a = $email_content[0]['text_details'];
                                        $subject = $email_content[0]['title'];
                                    }
                                    $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $customer_type);

                                    $email_send_option = $package_functions->getOptions('EMAIL_SEND_OPTION', $system_package);

                                    $vars = array(
                                        '{$user_full_name}' => $mvnx_full_name,
                                        '{$short_name}' => $db->setVal("short_title", $mno_id),
                                        '{$account_type}' => $user_type1,
                                        '{$business_id}' => $parent_code,
                                        '{$account_number}' => $parent_code,
                                        '{$user_name}' => $dis_user_name,
                                        '{$password}' => $password,
                                        '{$support_number}' => $support_number,
                                        '{$link}' => $link
                                    );


                                    $message_full = strtr($a, $vars);
                                    //$message = mysql_escape_string($message_full);
                                    $message = $db->escapeDB($message_full);

                                    $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`send_options`,`user_name`, `create_date`)
                    VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id','$email_send_option', '$dis_user_name', now())";
                                    $rrr = $db->execDB($qu);
                                    //if (getOptions('VENUE_ACTIVATION_TYPE', $system_package, $user_type) == "ICOMMS NUMBER" || $package_features == "all") {

                                    if ($email_send_option == 'SENT') {
                                        $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                                        include_once 'src/email/' . $email_send_method . '/index.php';

                                        //email template
                                        //$emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package);
                                        $cunst_var = array();
                                        /*if ($emailTemplateType == 'child') {
                                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $parent_product);
                            } elseif ($emailTemplateType == 'owen') {
                                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                            } elseif (strlen($emailTemplateType) > 0) {
                                $cunst_var['template'] = $emailTemplateType;
                            } else {
                                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                            }*/
                                        $cunst_var['system_package'] = $parent_product;
                                        $cunst_var['mno_package'] = $system_package;
                                        $cunst_var['mno_id'] = $mno;
                                        $mail_obj = new email($cunst_var);
                                        //echo "AA".$parent_enabel;
                                        if (empty($parent_enabel) || $parent_enabel == '1') {
                                            $mail_obj->mno_system_package = $system_package;
                                            $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);
                                            if (strlen($userQ) > 0) {
                                                $userR = $db->execDB($userQ);
                                            }
                                        }

                                    }


                                }

                            }//2

                            //$db->execDB("COMMIT");
                            $db->commit();

                            $_SESSION[$sess_id] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";


                        } else {
                            //$db->execDB("ROLLBACK");
                            $db->rollback();
                            $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                            //rollbackaccount($parent_code,$mvnx_id,$db);

                            if ($_POST['add_new_location'] == '1') {

                                $success_msg = $message_functions->showNameMessage('venue_add_failed', $location_name_s, '2009');
                            } else {

                                $success_msg = $message_functions->showNameMessage('venue_create_failed', $location_name_s, '2009');
                            }

                            $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                        }


                    }//1

                    else {//1
                        $db->userErrorLog('2009', $user_name, 'script - ' . $script);

                        if ($_POST['add_new_location'] == '1') {

                            $success_msg = $message_functions->showNameMessage('venue_add_failed', $location_name_s, '2009');
                        } else {

                            $success_msg = $message_functions->showNameMessage('venue_create_failed', $location_name_s, '2009');
                        }

                        $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                    }//1
                }//1


            }//key validation
            else {
                $location_name = $db->escapeDB(trim($_POST['location_name1']));
                $location_name_s = trim($_POST['location_name1']);

                if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'add_location_submit') {
                    if ($_SESSION['new_location'] == 'yes') {
                        $db->userLog($user_name, $script, 'New Location Create', $location_name_s);
                        $success_msg = $message_functions->showNameMessage('venue_add_success', $location_name_s);
                    } else {
                        $db->userLog($user_name, $script, 'Location Create', $location_name_s);
                        $success_msg = $message_functions->showNameMessage('venue_create_success', $location_name_s);
                    }
                } else {

                    if ($_SESSION['new_location'] == 'yes') {
                        $db->userLog($user_name, $script, 'New Location Create', $location_name_s);
                        $success_msg = $message_functions->showNameMessage('venue_add_success', $location_name_s);
                    } else {
                        $db->userLog($user_name, $script, 'Location Create', $location_name_s);
                        $success_msg = $message_functions->showNameMessage('venue_loc_add_success', $location_name_s);
                    }
                }

                $sess_id = 'msg5';
                $_SESSION[$sess_id] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
            }
        } else {
            $db->userErrorLog('2004', $user_name, 'script - ' . $script);

            $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: location.php');

        }
    }
?>