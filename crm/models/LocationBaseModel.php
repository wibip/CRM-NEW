<?php
require_once __DIR__ . 'Base_model.php';
require_once __DIR__ . '../DTO/PropertyAdmin.php';
require_once __DIR__ . '../DTO/Property.php';

class LocationBaseModel extends Base_model
{

    protected $propertyConfig = [
        "create"=>[""]
    ];

    protected function createParent(PropertyAdmin $parent){

    }

    private function createLocation(Location $location){

    }

    public function createProperty(Property $property)
    {
        $parent_code = strtoupper($_POST['parent_id']);
        $parent_ac_name = $this->db->escapeDB(trim($_POST['parent_ac_name']));
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

        $parent_enabel = $this->db->getValueAsf("SELECT is_enable as f FROM admin_users WHERE verification_number='$parent_code'");

        $location_name = $this->db->escapeDB(trim($_POST['location_name1']));
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


        $mno_first_name = $this->db->escapeDB(trim($_POST['mno_first_name']));
        $mno_last_name = $this->db->escapeDB(trim($_POST['mno_last_name']));
        $mvnx_full_name = $mno_first_name . ' ' . $mno_last_name;
        $mvnx_email = trim($_POST['mno_email']);
        $mvnx_address_1 = $this->db->escapeDB(trim($_POST['mno_address_1']));
        $mvnx_address_2 = $this->db->escapeDB(trim($_POST['mno_address_2']));
        $mvnx_address_3 = $this->db->escapeDB(trim($_POST['mno_address_3']));
        $mvnx_mobile_1 = $this->db->escapeDB(trim($_POST['mno_mobile_1']));
        $mvnx_mobile_2 = $this->db->escapeDB(trim($_POST['mno_mobile_2']));
        $mvnx_mobile_3 = $this->db->escapeDB(trim($_POST['mno_mobile_3']));
        $mvnx_country = $this->db->escapeDB(trim($_POST['mno_country']));
        $mvnx_state = $this->db->escapeDB(trim($_POST['mno_state']));
        $mvnx_zip_code = trim($_POST['mno_zip_code']);
        $mvnx_time_zone = $_POST['mno_time_zone'];
        $dtz = new DateTimeZone($mvnx_time_zone);

        $time_in_sofia = new DateTime('now', $dtz);
        $offset = $dtz->getOffset($time_in_sofia) / 3600;

        $timezone_abbreviation = $time_in_sofia->format('T');
        // get first 4 characters
        $timezone_abbreviation = substr($timezone_abbreviation, 0, 4);


        $offset1 = $dtz->getOffset($time_in_sofia);
        $offset_val = formatOffset($offset1);

        if ($offset_val == ' 00:00') {

            $offset_val = '+00:00';
        }


        $time_offset = ($offset < 0 ? $offset : "+" . $offset);


        /*$dateTime_zone = new DateTime();
        $dateTime_zone->setTimeZone(new DateTimeZone($mvnx_time_zone));*/

        //Create Group/Realm/Zone ID

        $zone_name = $this->db->escapeDB(trim($_POST['zone_name']));//Unique property ID


        $tunnel = $this->db->escapeDB(trim($_POST['tunnel']));

        $tunnel = $db->getValueAsf("SELECT g.tunnels AS f FROM exp_gateways g WHERE g.gateway_name='$gateway_type'");
        $tunnel = trim($tunnel, '["\"]');


        $pr_tunnel = $this->db->escapeDB(trim($_POST['pr_tunnel']));
        $pr_tunnel = $db->getValueAsf("SELECT g.tunnels AS f FROM exp_gateways g WHERE g.gateway_name='$pr_gateway_type'");
        $pr_tunnel = trim($pr_tunnel, '["\"]');


        $zone_dec = $this->db->escapeDB(trim($_POST['zone_dec']));//Description
        $realm = $this->db->escapeDB(trim($_POST['realm']));//Realm


        $ap_controller = $this->db->escapeDB(trim($_POST['conroller']));

        $zoneid = $this->db->escapeDB(trim($_POST['zone']));
        $groupid = $this->db->escapeDB(trim($_POST['groups']));

        $sw_controller = $this->db->escapeDB(trim($_POST['sw_conroller']));

        $groupsid = $this->db->escapeDB(trim($_POST['groups3']));

        if (empty($groupsid)) {
            $groupsid = $this->db->escapeDB(trim($_POST['groups2']));
            if (empty($groupsid)) {
                $groupsid = $this->db->escapeDB(trim($_POST['groups1']));
                if (empty($groupsid)) {
                    $groupsid = $this->db->escapeDB(trim($_POST['groups']));
                }
            }
        }


        $groupid = $groupsid;

        $newzone = $this->db->escapeDB(trim($_POST['new_zone']));

        //Assign Default QOS Profile

        $ap_control = $this->db->escapeDB(trim($_POST['AP_contrl']));
        $ap_control_time = $this->db->escapeDB(trim($_POST['AP_contrl_time']));
        $get_duration_details = $this->db->selectDB("SELECT duration,profile_code FROM exp_products_duration WHERE id='$ap_control_time'");
        foreach ($get_duration_details['data'] as $get_durations) {
            $ap_control_time1 = $get_durations[duration];
            $ap_control_time2 = $get_durations[profile_code];
        }

        $ap_control_guest = $this->db->escapeDB(trim($_POST['AP_contrl_guest']));

        /////////////
        /// vTenant QOS
        $qos_vt_guest_def = $this->db->escapeDB(trim($_POST['vt_guest_def']));
        $qos_vt_guest_pro = $this->db->escapeDB(trim($_POST['vt_guest_pro']));
        $qos_vt_guest_pri = $this->db->escapeDB(trim($_POST['vt_guest_pri']));
        ///////////////////////////////
        $subcribers_pro = $this->db->escapeDB(trim($_POST['subcribers_pro']));


        $ap_control_guest_time = $this->db->escapeDB(trim($_POST['AP_contrl_guest_time']));

        $get_guest_duration_details = $this->db->selectDB("SELECT duration,profile_code FROM exp_products_duration WHERE id='$ap_control_guest_time'");
        foreach ($get_guest_duration_details['data'] as $get_guest_durations) {
            $ap_control_guest_time1 = $get_guest_durations[duration];
            $ap_control_guest_time2 = $get_guest_durations[profile_code];
        }


        $live_user_name = $_SESSION['user_name'];
        $account_edit = $_POST['edit_account'];
        $edit_distributor_code = $_POST['edit_distributor_code'];
        $edit_distributor_id = $_POST['edit_distributor_id'];


        $user_type_current = "SELECT user_type FROM admin_users WHERE user_name = '$live_user_name'";
        $query_results = $this->db->selectDB($user_type_current);
        foreach ($query_results['data'] as $row) {
            $utype = $row[user_type];
        }


        if ($utype == 'MNO') {

            $query_code = "SELECT user_distributor FROM admin_users u WHERE u.user_name = '$live_user_name'";

            $query_results = $this->db->selectDB($query_code);
            foreach ($query_results['data'] as $row) {
                $mno_id = $row[user_distributor];
            }
        } else {

            $query_code = "SELECT user_distributor, d.id, d.mno_id
            FROM admin_users u, exp_mno_distributor d
            WHERE u.user_distributor = d.distributor_code AND u.user_name = '$live_user_name'";

            $query_results = $this->db->selectDB($query_code);
            foreach ($query_results['data'] as $row) {
                $user_distributor1 = $row[user_distributor];
                $mno_id = $row[mno_id];
            }

        }


        //////////////////

        if ($newzone != NULL || $newzone != '') {

            //echo 'enter';

            $profile1 = $db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$ap_controller'");
            if ($profile1 == '') {
                $profile1 = $db->setVal('wag_ap_name', 'ADMIN');
                if ($profile1 == '') {
                    $profile1 = "non";
                }
            }


            //echo $profile1;
            require_once 'src/AP/' . $profile1 . '/index.php';

            $wag_obj1 = new ap_wag($ap_controller);

            $create_zone = $wag_obj1->createzone($newzone, $newzone, 'Asf12#12');

            //print_r($create_zone);
            parse_str($create_zone);

            $json_zone = json_decode(urldecode($Description), true);

            $zoneid = $json_zone[id];

            if ($status_code == '200') {

                $query0 = "INSERT INTO exp_distributor_zones (zoneid,name,ap_controller,create_user,create_date)
                values ('$zoneid','$newzone','$ap_controller','',now())";

                $zoneq = $this->db->execDB($query0);

                if ($zoneq===true) {
                    $zonecreate = 1;
                } else {
                    $zonecreate = 0;
                }

            } else {
                $zonecreate = 0;
            }

        } else {
            $zonecreate = 1;
        }


        if ($create_location_btn_action == 'create_location_next' || $create_location_btn_action == 'add_location_next') {
            $edit_parent_id = $parent_code;
            $edit_parent_ac_name = $parent_ac_name;
            $edit_first_name = $mno_first_name;
            $edit_last_name = $mno_last_name;
            $edit_email = $mvnx_email;
            $edit_parent_package = $parent_package;
        }


        //1


        $password = randomPassword();
        $parend_password = randomPassword();

        $tz = $mvnx_time_zone;
        $theme = 'FB_MANUAL';
        $title = 'Welcome to ' . $this->db->escapeDB($location_name_s);

        // echo $wag_ap_name;
        if ($wag_ap_name == 'NO_PROFILE') {
            //API not call//
            $status_code = '200';
        } else {

            $api_details = $package_functions->callApi('ACC_CREATE_API', $system_package, 'YES');
            //print_r($api_details);
            if ($api_details['access_method'] == '1') { // 'YES' returns option column data

                $profile = $db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$ap_controller'");
                if ($profile == '') {
                    $profile = $db->setVal('wag_ap_name', 'ADMIN');
                    if ($profile == '') {
                        $profile = "non";
                    }
                }


                //echo $profile;
                require_once 'src/AP/' . $profile . '/index.php';

                $wag_obj = new ap_wag($ap_controller);
                $wag_obj->setRealm($icomme_number);
                $status_code = '0';

                $zon_details = $wag_obj->retrieveZonedata($zoneid);
                parse_str($zon_details, $zone_details_ar);


                if ($gateway_type == 'WAG' || $pr_gateway_type == 'WAG') {

                    if ($wag_enable == "on") {
                        $gre_profile_id = $db->getValueAsf("SELECT `filt_gre_profile` AS f FROM `exp_wag_profile` WHERE `wag_code`='$wag_name'");
                        $gre_profile_name = $db->getValueAsf("SELECT `profile_name` AS f FROM `exp_gre_profiles` WHERE `profile_id`='$gre_profile_id'");
                        $wag_enable = '1';
                    } else {
                        //$gre_profile_id = $db->getValueAsf("SELECT `reg_gre_profile` AS f FROM `exp_wag_profile` WHERE `wag_code`='$wag_name'");
                        //$gre_profile_name = $db->getValueAsf("SELECT `profile_name` AS f FROM `exp_gre_profiles` WHERE `profile_id`='$gre_profile_id'");
                        $wag_enable = '0';
                    }

                    //$modi_zone = $wag_obj->modifyzone($zoneid, $tunnel, $gre_profile_id, $gre_profile_name);
                    //parse_str($modi_zone,$modi_zone_res_ar);
                    //$modi_zone_res_ar['status_code']='200';

                }


                if ($zone_details_ar['status_code'] == '200') {

                    $ofset_ar = explode(':', $offset_val);

                    $time_Zone_update = $wag_obj->modifyZoneTimeZone($zoneid, $timezone_abbreviation, (int)$ofset_ar[0], (int)$ofset_ar[1], $mvnx_time_zone);
                    parse_str($time_Zone_update, $time_Zone_update_resp);


                    if (array_key_exists('advanced_features', $field_array) && !empty($advanced_features_arr)) {


                        $retrieveNetworkList = $wag_obj->retrieveNetworkList($zoneid);

                        parse_str($retrieveNetworkList);

                        //print_r($Description);

                        $result = urldecode($Description);

                        $result = (array)json_decode($result);

                        $result = (Array)$result['list'];

                        if (count($result) > 0) {
                            foreach ($result as $key => $value) {
                                $value = (array)$value;
                                $id = $value['id'];

                                $modifyavcEnabled = $wag_obj->modifyavcEnabled($zoneid, $id, $avcEnabled);

                                /*print_r($modifyavcEnabled);
                               echo "<br>";*/

                            }

                        }
                    }


                } else {
                    $time_Zone_update_resp['status_code'] = '0';
                }

                if ($wag_enable == "on") {

                    $wag_enable = 1;

                } else {

                    $wag_enable = 0;
                }

                if ($gateway_type == 'WAG' || $pr_gateway_type == 'WAG') {
                    if ($wag_enable == "1") {
                        $modufy_tunnel = $wag_obj->modifyTunnelProfile($zoneid, $gre_profile_id, $gre_profile_name);
                        parse_str($modufy_tunnel, $modufy_tunnel_resp);

                        if ($modufy_tunnel_resp['status_code'] == '200') {
                            $status_code = '200';
                        } else {
                            $status_code = '0';
                        }

                    } else {
                        $status_code = '200';
                    }


                } elseif ($network_type != 'VT' && $gateway_type != 'AC' && strlen($DNS_profile) > 0) {
                    if ($dns_profile_enable == '1') {

                        $get_dns_prof_deta_q = "SELECT cd.`content_filter_profile`,d.name,cd.regular_profile FROM `exp_controller_dns` cd join exp_dns_profile d ON cd.content_filter_profile=d.unique_id WHERE `profile_code`='$DNS_profile'";

                        $get_dns_prof_deta = $this->db->select1DB($get_dns_prof_deta_q);
                        //$get_dns_prof_deta = mysql_fetch_array($get_dns_prof_deta_r);
                        $dns_profile_id = $get_dns_prof_deta['content_filter_profile'];
                        $regular_profile = $get_dns_prof_deta['regular_profile'];
                        $dns_profile_name = $get_dns_prof_deta['name'];

                        $result = $wag_obj->retrieveDNSServerProfile();

                        parse_str($result);

                        $result = urldecode($Description);

                        $result = (array)json_decode($result);

                        $result = (Array)$result['list'];

                        if (count($result) > 0) {
                            foreach ($result as $key => $value) {
                                $value = (array)$value;
                                $id = $value['id'];

                                if ($id == $dns_profile_id) {

                                    $secondaryIp = $value['secondaryIp'];
                                    $primaryIp = $value['primaryIp'];
                                }

                            }

                            $result_dhcp = $wag_obj->getZoneDHCPProfile($zoneid);

                            parse_str($result_dhcp, $wag_respo_arr);

                            $data = json_decode($wag_respo_arr['Description'], true);

                            if (count($data['list']) > 0) {

                                $dhcp_is = 0;

                                foreach ($data['list'] as $value) {

                                    $vlanId = $value['vlanId'];

                                    if ($vlanId == '100') {
                                        $dhcp_id = $value['id'];
                                        $dhcp_arr = $value;
                                        $dhcp_is = 1;
                                        break;
                                    }

                                }

                                if ($dhcp_is == 1) {

                                    $dhcp_arr['primaryDnsIp'] = $primaryIp;
                                    $dhcp_arr['secondaryDnsIp'] = $secondaryIp;

                                    unset($dhcp_arr['zoneId']);
                                    unset($dhcp_arr['id']);

                                    $result_dhcp1 = $wag_obj->modifyDhcpProfile($zoneid, $dhcp_id, $dhcp_arr);

                                    parse_str($result_dhcp1, $wag_respo_arr2);

                                    if ($wag_respo_arr2['status_code'] == '200') {
                                        /* $this->db->selectDB("UPDATE exp_mno_distributor SET dns_profile_enable='1' WHERE distributor_code='$user_distributor'");
                                         $_SESSION['tab1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_success','2009')."</strong></div>";*/

                                        $status_code = '200';

                                    } else {
                                        /*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_fail','2009')."</strong></div>";*/

                                        $status_code = '0';

                                    }

                                } else {

                                    /* $_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/

                                    $status_code = '0';

                                }

                            } else {

                                $status_code = '0';

                                /*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
                            }


                        } else {

                            /*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dns','2009')."</strong></div>";*/

                            $status_code = '0';
                        }


                    } else {

                        $get_dns_prof_deta_q = "SELECT cd.`content_filter_profile`,d.name,cd.regular_profile FROM `exp_controller_dns` cd join exp_dns_profile d ON cd.content_filter_profile=d.unique_id WHERE `profile_code`='$DNS_profile'";

                        $get_dns_prof_deta = $this->db->select1DB($get_dns_prof_deta_q);
                        //$get_dns_prof_deta = mysql_fetch_array($get_dns_prof_deta_r);
                        $dns_profile_id = $get_dns_prof_deta['content_filter_profile'];
                        $regular_profile = $get_dns_prof_deta['regular_profile'];
                        $dns_profile_name = $get_dns_prof_deta['name'];

                        $result = $wag_obj->retrieveDNSServerProfile();

                        parse_str($result);

                        $result = urldecode($Description);
                        $result = (array)json_decode($result);
                        $result = (Array)$result['list'];

                        if (count($result) > 0) {
                            foreach ($result as $key => $value) {
                                $value = (array)$value;
                                $id = $value['id'];

                                if ($id == $regular_profile) {

                                    $secondaryIp = $value['secondaryIp'];
                                    $primaryIp = $value['primaryIp'];
                                }

                            }

                            $result_dhcp = $wag_obj->getZoneDHCPProfile($zoneid);
                            parse_str($result_dhcp, $wag_respo_arr);
                            $data = json_decode($wag_respo_arr['Description'], true);

                            if (count($data['list']) > 0) {

                                $dhcp_is = 0;

                                foreach ($data['list'] as $value) {

                                    $vlanId = $value['vlanId'];

                                    if ($vlanId == '100') {
                                        $dhcp_id = $value['id'];
                                        $dhcp_arr = $value;
                                        $dhcp_is = 1;
                                        break;
                                    }

                                }

                                if ($dhcp_is == 1) {

                                    $dhcp_arr['primaryDnsIp'] = $primaryIp;
                                    $dhcp_arr['secondaryDnsIp'] = $secondaryIp;

                                    unset($dhcp_arr['zoneId']);
                                    unset($dhcp_arr['id']);

                                    $result_dhcp1 = $wag_obj->modifyDhcpProfile($zoneid, $dhcp_id, $dhcp_arr);
                                    parse_str($result_dhcp1, $wag_respo_arr2);

                                    if ($wag_respo_arr2['status_code'] == '200') {
                                        /*$update_q = "UPDATE exp_mno_distributor SET dns_profile_enable='0' WHERE distributor_code='$user_distributor'";
                                        $this->db->selectDB($update_q);
                                        $_SESSION['tab1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_success','2009')."</strong></div>";*/
                                        $status_code = '200';

                                    } else {
                                        /*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_fail','2009')."</strong></div>";*/
                                        $status_code = '0';
                                    }

                                } else {

                                    /* $_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
                                    $status_code = '0';
                                }

                            } else {

                                /*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
                                $status_code = '0';
                            }


                        } else {

                            /*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dns','2009')."</strong></div>";*/
                            $status_code = '0';
                        }

                    }
                } else {

                    $status_code = '200';
                }
                //$status_code='0';


                if ($status_code == '200' && $time_Zone_update_resp['status_code'] == '200') {
                    $status_code = "200";
                } else {
                    $status_code = "0";
                }


                //////////////////////////////////////////
                //$private_password=randomPasswordlength(8);

                //$wag_obj->retrieveZonedata($zoneid);

            } else {
                $status_code = "200";
            }

            //$status_code = "200";

        }
        // echo $mvnx_id; $ap_controller  ap_controller

        ////////theme submit////////////

        //$status_code = "200" ;$zonecreate=1;
        if ($status_code == "200" && $zonecreate == 1) {//1
            $this->db->autoCommit();
            //$this->db->selectDB("START TRANSACTION");

            //new account insert//
            $rowe = $this->db->select1DB("SHOW TABLE STATUS LIKE 'exp_mno_distributor'");
            //$rowe = mysql_fetch_array($br);
            $auto_inc = $rowe['Auto_increment'];
            $mvnx_id = $user_type1 . $auto_inc;
            $mvnx = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
            $unique_id = '2' . $mvnx;

            $dis_user_name = uniqid($mvnx_id);
            $parent_user_name = str_replace(' ', '_', strtolower(substr($mvnx_full_name, 0, 5) . $auto_inc));


            $parent_product = $_POST['parent_package_type'];//$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);

            $mvnx_num_ssid = '0';
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
                     SELECT `qos_code`,`qos_id`,'$edit_distributor_code','1',NOW()
                     FROM `exp_qos` WHERE `id`='$selected'";
                    $this->db->execDB($query18);

                }
            }

            $query01 = "INSERT INTO `exp_mno_distributor` (`switch_group_id`,dns_profile,dns_profile_enable,content_filter_enable,parent_id,`gateway_type`,`private_gateway_type`,`offset_val`,`wag_profile_enable`,`wag_profile`,`property_id`,`verification_number`,`network_type`,`ap_controller`,`system_package`,`zone_id`,`tunnel_type`,`private_tunnel_type`,`unique_id`,`distributor_code`, `distributor_name`,`bussiness_type`, `distributor_type`,`category`,num_of_ssid, `mno_id`, `parent_code`,`bussiness_address1`,`bussiness_address2`,`bussiness_address3`,`country`,`state_region`,`zip`,`phone1`,`phone2`,`phone3`,theme,site_title,time_zone,`language`,`advanced_features`,`is_enable`,`create_date`,`create_user`,`sw_controller`,`groupsid`,`default_campaign_id`)
                    VALUES ('$groupid','$DNS_profile','$dns_profile_enable','$dns_profile_enable','$parent_code','$gateway_type','$pr_gateway_type','$offset_val','$wag_enable','$wag_name','$zone_name','$icomme_number','$network_type','$ap_controller','$customer_type','$zoneid','$tunnel','$pr_tunnel','$unique_id','$mvnx_id', '$location_name', '$business_type','$user_type1','$category_mvnx','$mvnx_num_ssid', '$mno_id', '$user_distributor1','$mvnx_address_1','$mvnx_address_2','$mvnx_address_3','$mvnx_country','$mvnx_state','$mvnx_zip_code','$mvnx_mobile_1','$mvnx_mobile_2','$mvnx_mobile_3','$theme','$title','$tz','en','$advanced_features','0',now(),'$live_user_name','$sw_controller', '$groupsid','0')";


            $query012 = "INSERT INTO mdu_distributor_organizations(distributor_code,property_id,create_user,create_date) 
                          VALUES('$mvnx_id','$vt_icomme_number','$user_name',NOW())";

            $query03 = "INSERT INTO mno_distributor_parent (account_name,parent_id, system_package, mno_id, create_date, create_user) VALUES ('$parent_ac_name','$parent_code', '$parent_product','$mno_id', NOW(),'$user_name')";

            $query02 = "INSERT INTO `admin_users` (`user_name`,`verification_number`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `is_enable`, `create_date`,`create_user`)
            VALUES ('$dis_user_name','$icomme_number',PASSWORD('$password'), 'admin', '$user_type1','$mvnx_id', '', '', '', '8', NOW(),'$user_name')";

            $query04 = "INSERT INTO `admin_users` (`user_name`,`verification_number`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `is_enable`, `create_date`,`create_user`)
            VALUES ('$parent_user_name','$parent_code',PASSWORD('$parend_password'), 'admin', 'MVNO_ADMIN','$parent_code', '$mvnx_full_name', '$mvnx_email', '$mvnx_mobile_1', '2', NOW(),'$user_name')";

            if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $customer_type) == 'NO') {
                $distributor_group = "INSERT INTO `exp_distributor_groups` (`group_name`,`description`,`group_number`,`distributor`,`create_date`)
                                VALUES ('$icomme_number','$zone_dec','$realm','$mvnx_id',NOW())";
            }
            $distributor_group_tag = "INSERT INTO `exp_mno_distributor_group_tag` (
                                  `tag_name`,
                                  `description`,
                                  `distributor`,
                                  `create_date`,
                                  `create_user`
                                )
                                VALUES
                                  (
                                    '$icomme_number',
                                    '$zone_dec',
                                    '$mvnx_id',
                                    NOW(),
                                    '$user_name'
                                  )";


            $profile_venue = "INSERT INTO `exp_products_distributor`
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
             SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$mvnx_id',`network_type`,
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


            if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'create_location_next') {
                $ex3 = $this->db->execDB($query03);
                if ($ex3===true) {
                    $create_par = 'yes';
                } else {
                    $create_par = '';
                }

            } else {
                $ex3 = 'true';
                $create_par = 'yes';
            }


            if ($create_par == 'yes') {
                $ex0 = $this->db->execDB($query01);
                // $this->db->execDB($apquery1);

                if ($network_type == 'VT' || $network_type == 'VT-GUEST' || $network_type == 'VT-PRIVATE' || $network_type == 'VT-BOTH') {
                    $this->db->execDB($query012);
                }

                // $ex10= $this->db->execDB($apmno_dis1);

                // if ($ap_mac2 != "") {
                //     $this->db->execDB($apquery2);
                //     $this->db->execDB($apmno_dis2);
                // }

                // if ($ap_mac3 != "") {

                //     $this->db->execDB($apquery3);
                //     $this->db->execDB($apmno_dis3);
                // }


                // $this->db->execDB($ssid_guest_query);
                // $this->db->execDB($ssid_private_query);

                $ex1 = $this->db->execDB($distributor_group);
                $ex2 = $this->db->execDB($distributor_group_tag);

                $ex3_1 = $this->db->execDB($profile_venue);
                $ex4 = $this->db->execDB($query_vt_qos_1);
                $ex5 = $this->db->execDB($query_vt_qos_2);
                $ex6 = $this->db->execDB($query_vt_qos_3);
                $ex7 = $this->db->execDB($duration_profil_1);
                $ex8 = $this->db->execDB($duration_profil_2);
                //$this->db->execDB($profile_venue2);
                $ex9 = $this->db->execDB($query_subcribers_qos_1);


                //create manual and auto  passcode
                $manua_passcode = randomPasswordlength(8);
                $auto_passcode = randomPasswordlength(8);
                $cust_vo = $this->db->execDB("INSERT INTO `exp_customer_vouchers`(`voucher_number`,`reference`,`voucher_type`,`type`,`redeem_count`,`voucher_status`,`create_date`,`create_user`) 
                              VALUES('$manua_passcode','$mvnx_id','DISTRIBUTOR','Manual','0','0',NOW(),'$user_name')");
                $ex0_1 = $this->db->execDB($query02);
                if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'create_location_next') {
                    $ex4_1 = $this->db->execDB($query04);
                }

                $passcode_renewal_time = "08:00:00";
                $r = 'DATE_ADD(CONVERT_TZ(NOW(),\'SYSTEM\',\'' . $offset_val . '\'),INTERVAL 1 WEEK)';
                $e = 'DATE_ADD(DATE_ADD(CONVERT_TZ(NOW(),\'SYSTEM\',\'' . $offset_val . '\'),INTERVAL 1 WEEK),INTERVAL 12 HOUR)';

                //echo $r = 'CONVERT_TZ(DATE_ADD(CONCAT(DATE_FORMAT(CONVERT_TZ(NOW(),\'SYSTEM\',\''.$offset_val.'\'),\'%Y-%m-%d \'),\''.$passcode_renewal_time.'\'),INTERVAL 1 WEEK),\''.$offset.'\',\'SYSTEM\') ';
                // echo $e = 'CONVERT_TZ(DATE_ADD(DATE_ADD(CONCAT(DATE_FORMAT(CONVERT_TZ(NOW(),\'SYSTEM\',\''.$offset_val.'\'),\'%Y-%m-%d \'),\''.$passcode_renewal_time.'\') ,INTERVAL 1 WEEK),INTERVAL 12 HOUR),\''.$offset.'\',\'SYSTEM\') ';

                $auto_pass_ins_q = "INSERT INTO `exp_customer_vouchers` (`voucher_prefix`,`reference_email`,`refresh_date`,frequency,buffer_duration,expire_date,start_date,type,`voucher_number`, `reference`, `voucher_type`,`redeem_count`, `voucher_status`, `create_date`, `create_user`)              
                                VALUES ('','$mvnx_email', $r ,'Weekly','12',$e , NOW(),'Auto','$auto_passcode', '$mvnx_id', 'DISTRIBUTOR', '0', '1', NOW(), '$user_name')";
                $insert_passcode = $this->db->execDB($auto_pass_ins_q);


            }
            $query_result = false;
            if ($create_location_btn_action == 'create_location_submit' || $create_location_btn_action == 'create_location_next') {
                if ($br && $ex0 && $ex1 && $ex2 && $ex3 && $ex3_1 && $ex4 && $ex5 && $ex6 && $ex7 && $ex8 && $ex9 && $cust_vo && $ex0_1 && $ex4_1 && $insert_passcode) {
                    $query_result = true;
                }
            } else {
                if ($br && $ex0 && $ex1 && $ex2 && $ex3 && $ex3_1 && $ex4 && $ex5 && $ex6 && $ex7 && $ex8 && $ex9 && $cust_vo && $ex0_1 && $insert_passcode) {
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

                $package_btitle = $package_functions->getOptions("BROWSER_TITLE", $system_package);

                if ($package_btitle == '' || $package_btitle == NULL) {

                    $package_btitle = 'Welcome to Guest WiFi Access';
                }

                //$theme_id=$mvnx_id.'_default';
                //$theme_name=$cusbiss_name.'-GUEST-ModernHorizontal-'.date("Y-m-d H:i:s");

                //$welcome_text='<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Courtesy Services Provided by '.$cusbiss_name.'</span></p>';

                //$query_them = "";
                $cusbiss_name = $this->db->escapeDB($cusbiss_name);
                $theme_vars = array(
                    '{$mvnx_id}' => $mvnx_id,
                    '{$cusbiss_name}' => $cusbiss_name,
                    '{$package_btitle}' => $package_btitle,
                    '{$user_name}' => $user_name,
                    '{$icomme_number}' => $icomme_number
                );

                $theme_q = $package_functions->getOptions('INIT_THEME', $customer_type);
                $query_them = strtr($theme_q, $theme_vars);


                $this->db->execDB($query_them);

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

                        $this->db->execDB($icmQ);
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

                    //  $ex10 = $this->db->execDB($query10);

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

                        $email_send_option = $package_functions->getOptions('EMAIL_SEND_OPTION', $system_package);

                        $vars = array(
                            '{$user_full_name}' => $mvnx_full_name,
                            '{$short_name}' => $db->setVal("short_title", $mno_id),
                            '{$account_type}' => $user_type1,
                            '{$business_id}' => $parent_code,
                            '{$account_number}' => $parent_code,
                            '{$user_name}' => $dis_user_name,
                            '{$password}' => $password,
                            '{$link}' => $link
                        );


                        $message_full = strtr($a, $vars);
                        $message = $this->db->escapeDB($message_full);

                        $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`send_options`,`user_name`, `create_date`)
                    VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id','$email_send_option', '$dis_user_name', now())";
                        $rrr = $this->db->execDB($qu);
                        //if (getOptions('VENUE_ACTIVATION_TYPE', $system_package, $user_type) == "ICOMMS NUMBER" || $package_features == "all") {

                        if ($email_send_option == 'SENT') {
                            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                            include_once 'src/email/' . $email_send_method . '/index.php';

                            //email template
                            $emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package);
                            $cunst_var = array();
                            if ($emailTemplateType == 'child') {
                                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $parent_product);
                            } elseif ($emailTemplateType == 'owen') {
                                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                            } elseif (strlen($emailTemplateType) > 0) {
                                $cunst_var['template'] = $emailTemplateType;
                            } else {
                                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                            }
                            $mail_obj = new email($cunst_var);
                            //echo "AA".$parent_enabel;
                            if (empty($parent_enabel) || $parent_enabel == '1') {
                                $mail_obj->mno_system_package = $system_package;
                                $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);
                            }

                        }


                    }

                }//2

                $this->db->commit();

                $_SESSION[$sess_id] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";


            } else {
                $this->db->rollback();
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

    }
}