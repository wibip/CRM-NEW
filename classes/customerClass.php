<?php

//Current Page URL
$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
} else {
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
}


//include_once("connect.php");
include_once 'dbClass.php';
include_once 'VlanID.php';



//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//error_reporting(E_ALL);


class customer
{
    private $db;
    private $base_url;
    private  $device_data;
    private  $vlan_functions;

    private $state_array;

    public function __construct()
    {
        $this->db = new db_functions();
        $this->base_url = $this->db->setVal('global_url', 'ADMIN');
        $this->device_data = array();
        $this->vlan_functions = new VlanID();
    }

    private function getStateCode($state)
    {
        if (is_null($this->state_array)) {
            $db_states = $this->db->selectDB("SELECT states_code,description FROM exp_country_states WHERE country_code='US'");
            $this->state_array = $db_states['data'];
        }

        foreach ($this->state_array as $db_state) {
            if ($db_state['states_code'] == $state || $db_state['description'] == $state) {
                $state = $db_state['states_code'];
                break;
            }
        }
        return $state;
    }

    public function syncCustomer($Response, $search_id_up, $group = null, $backup = false)
    {

        $sub_acc = 0;
        $master_user_ar = array();

        $decoded = json_decode($Response, true);
        $bulk_profile_data = $decoded['Description'];

        $newarray = array();
        foreach ($bulk_profile_data as $value2) {
            //print_r($value2);
            $user_name = ($value2['User-Name']);
            $master_acc = ($value2['Master-Account']);
            //echo $user_name;
            if (strpos($user_name, '/') !== false) {
                $groups = explode('/', $user_name);
                $b = sizeof($groups);
                $a = $b - 1;
                $organization = $groups[$a];
            } else {
                $groups = explode('@', $user_name);
                $b = sizeof($groups);
                $a = $b - 1;
                $organization = $groups[$a];
            }
            if ($organization == $group && empty($master_acc)) {
                array_push($newarray, $value2);
                # code...
            }
        }


        if (empty($newarray)) {
        } else {
            if ($newarray['User_Name']) {
                $single_profile_data1 = 1;
                $newarray[0] = $newarray;
            } else {
                $single_profile_data1 = sizeof($newarray);
            }

            $test_ar = array();


            $arr_new = array();
            for ($k = 0; $k < $single_profile_data1; $k++) {

                $single_profile_data1;
                $array_get_profile_value = $newarray[$k];
                $Master_Account = '';


                $User_Name = $array_get_profile_value['User-Name'];
                //$MSISDN = $array_get_profile_value['MSISDN'];
                $PAS_First_Name = $this->db->escapeDB(trim(str_replace("\\","",$array_get_profile_value['PAS-First-Name'])));
                $PAS_Last_Name = $this->db->escapeDB(trim(str_replace("\\","",$array_get_profile_value['PAS-Last-Name'])));
                $secret_question = $this->db->escapeDB($array_get_profile_value['secret_question']);
                $secret_answer = $this->db->escapeDB($array_get_profile_value['secret_answer']);
                $company = $this->db->escapeDB($array_get_profile_value['company']);
                $Email = $array_get_profile_value['Email'];
                $Password = $array_get_profile_value['Password'];
                //$Group = $array_get_profile_value['Group'];
                $zip = $this->db->escapeDB($array_get_profile_value['zip']);
                $Valid_From = $array_get_profile_value['Valid-From'];
                $Valid_Until = $array_get_profile_value['Valid-Until'];
                $MSISDN = $array_get_profile_value['MSISDN'];
                $Master_Account = $array_get_profile_value['Master-Account'];
                $ser_prof = $array_get_profile_value['Service-Profiles'];
                if (count($array_get_profile_value['User-Data']) > 0) {
                    $vlan_id = $array_get_profile_value['User-Data']['VT-Vlan-Id'];
                    $secret_question = $this->db->escapeDB($array_get_profile_value['User-Data']['secret_question']);
                    $secret_answer = $this->db->escapeDB($array_get_profile_value['User-Data']['secret_answer']);
                    $country = $this->db->escapeDB($array_get_profile_value['User-Data']['country']);
                    $state = $this->db->escapeDB($array_get_profile_value['User-Data']['state']);
                    $zip = $this->db->escapeDB($array_get_profile_value['User-Data']['zip']);
                    $city = $this->db->escapeDB($array_get_profile_value['User-Data']['city']);
                    $address = $this->db->escapeDB($array_get_profile_value['User-Data']['address']);
                    $violation = $this->db->escapeDB($array_get_profile_value['User-Data']['violation']);
                    $warning = $this->db->escapeDB($array_get_profile_value['User-Data']['warning']);
                } else {
                    $vlan_id = $array_get_profile_value['VT-Vlan-Id'];
                    $secret_question = $this->db->escapeDB($array_get_profile_value['secret_question']);
                    $secret_answer = $this->db->escapeDB($array_get_profile_value['secret_answer']);
                    $country = $this->db->escapeDB($array_get_profile_value['country']);
                    $state = $this->db->escapeDB($array_get_profile_value['state']);
                    $zip = $this->db->escapeDB($array_get_profile_value['zip']);
                    $city = $this->db->escapeDB($array_get_profile_value['city']);
                    $address = $this->db->escapeDB($array_get_profile_value['address']);
                    $violation = $array_get_profile_value['violation'];
                    $warning = $array_get_profile_value['warning'];
                }

                //find state code
                $state = $this->getStateCode($state);

                $Validity_Time_cal = $Valid_Until - $Valid_From;
                $Validity_Time = empty($Validity_Time_cal) ? 0 : $Validity_Time_cal;

                //$Validity_Time = empty($array_get_profile_value['Validity-Time'])?0:$array_get_profile_value['Validity-Time'];

                array_push($arr_new, $vlan_id);



                if (!$backup) {
                    $query_0 = "SELECT customer_id FROM `mdu_vetenant` WHERE username = '$User_Name'";
                    //echo '</br>';
                    //echo $Master_Account;
                    $result_0 = $this->db->selectDB($query_0);
                    $row_count = $result_0['rowCount'];

                    if ($row_count > 0) {




                        $queryd = "UPDATE `mdu_vetenant` SET
                                    `email` = '$Email',
                                    `vlan_id` = '$vlan_id',
                                    `first_name` = '$PAS_First_Name',
                                    `last_name` = '$PAS_Last_Name',
                                    `username` = '$User_Name',
                                    `property_id` = '$group',
                                    `question_id` = '$secret_question',
                                    `answer` = '$secret_answer',
                                    `phone` = '$MSISDN',
                                    `country` = '$country',
                                    `state` = '$state',
                                    `postal_code` = '$zip',
                                    `city` = '$city',
                                    `valid_until` = '$Valid_Until',
                                    `valid_from` = '$Valid_From',
                                    `warning_message` = '$warning',
                                    `validity_time` = '$Validity_Time',
                                    `violation` = '$violation',
                                    `address` = '$address',
                                    `search_id` = '$search_id_up'
                                    WHERE username = '$User_Name'";
                    } else {

                        $queryd = "REPLACE INTO `mdu_vetenant` 
					(`validity_time`,`warning_message`,`violation`,`vlan_id`,`email`,`first_name`,`last_name`,username,`question_id`,property_id,valid_from,valid_until,`answer`,company_name,address,city,state,postal_code,country,phone,create_date,service_profile,email_sent,search_id,create_user)
					VALUES
					('$Validity_Time','$warning','$violation','$vlan_id','$Email','$PAS_First_Name','$PAS_Last_Name','$User_Name', '$secret_question','$group','$Valid_From','$Valid_Until','$secret_answer','$company','$address','$city','$state','$zip','$country','$MSISDN',NOW(),'$ser_prof','0','$search_id_up','API')";
                    }
                } else {
                    $queryd = "INSERT INTO `mdu_customer_backup` (`validity_time`,`warning_message`,`violation`,`email`,`first_name`,`last_name`,username,`password`,`question_id`,property_id,valid_from,valid_until,`answer`,company_name,address,city,state,postal_code,country,phone,create_date,service_profile,delete_id,email_sent,create_user)
					VALUES('$Validity_Time','$warning','$violation','$Email','$PAS_First_Name','$PAS_Last_Name','$User_Name','$Password', '$secret_question','$group','$Valid_From','$Valid_Until','$secret_answer','$company','$address','$city','$state','$zip','$country','$MSISDN',NOW(),'$ser_prof','$search_id_up','0','API')";
                }

                if (strlen($Master_Account) == 0) {
                    if (strlen($User_Name) > 0) {
                        //echo $queryd.'<br>';

                        //$Master_user=$User_Name;
                        $ex1 = $this->db->execDB($queryd);


                        array_push($master_user_ar, $User_Name);
                    }
                } else {

                    $sub_acc++;
                }



                $User_Name = '';
                $Master_Account = '';
                $updated = 1;

                $Email = '';
                $EMAIL = '';
                $PAS_First_Name = '';
                $PAS_Last_Name = '';
                $User_Name = '';
                $secret_question = '';
                $Group = '';
                $secret_answer = '';
                $company = '';
                $address = '';
                $city = '';
                $state = '';
                $zip = '';
                $country = '';
                $MSISDN = '';
                $Valid_From = '';
                $Valid_Until = '';
                $vlan_id = '';
                $ser_prof = '';
                $violation = '';
                $warning = '';
            }
        }

        foreach ($arr_new as $acc_vl) {

            $have_vlane = $this->vlan_functions->checkVlanID_Random($group, $acc_vl);
            // echo $acc_vl."-".$have_vlane."<br>";

            if ($have_vlane) {
                $have_vlane = $this->vlan_functions->DeleteVlanID_Random($group, $acc_vl);
            }
        }


        if (($decoded['status'] = 'success' && $ex1) || ($decoded['status'] = 'success' && empty($master_user_ar))) {

            $del_q = "SELECT `vlan_id` FROM `mdu_vetenant` WHERE (`search_id`<> '$search_id_up' OR `search_id` IS NULL) AND `property_id`='$group' ";

            $del_q_ex = $this->db->selectDB($del_q);
            foreach ($del_q_ex['data'] as $row_del) {

                $del_vlan = $row_del[vlan_id];

                $del_vlan_id = $this->vlan_functions->addDeleteVlanID($group, $del_vlan);
            }

            $vlan_range = $this->db->getValueAsf("SELECT `vlan_range` AS f FROM `mdu_vlan` WHERE `vlan_id`='$group'");

            $range_ex = explode(',', $vlan_range);
            $vt_pool = array();
            foreach ($range_ex as $range_u) {

                $range_ex = explode('-', $range_u);
                $fst_range = (int)$range_ex[0];
                $lst_range = (int)$range_ex[1];

                for ($i = $fst_range; $i <= $lst_range; $i++) {
                    array_push($vt_pool, $i);
                }
            }
            foreach ($vt_pool as $value) {
                if (!in_array($value, $arr_new)) {
                    $del_vlan_id = $this->vlan_functions->addDeleteVlanID($group, $value);
                }
            }

            $this->mdu_vtenet_archive_searchID($search_id_up, $group, 'Sync'); // archive mdu master account

            $sync_del_q = "DELETE FROM mdu_vetenant WHERE property_id ='$group' AND (search_id<>'$search_id_up' OR search_id IS NULL)";
            $this->db->execDB($sync_del_q);
        }

        $re_val = array("master_acc" => $master_user_ar, "sub_acc" => $sub_acc);
        //print_r($master_user_ar);
        return $re_val;
    }

    public function syncCustomerDevices($Response, $customer_username, $search_id, $backup = false)
    {

        //parse_str($Response);

        $decoded = json_decode($Response, true);

        $bulk_profile_data = $decoded['Description'];

        $session_profile_data = $decoded['status'];


        $res_arrr = array();
        $res_arrr2 = array();
        $res_arrr3 = array();
        $res_arrr4 = array();
        foreach ($session_profile_data as $value) {
            $mac_uname = $value['Login-User-Name'];
            $session_mac = $value['Session-MAC'];
            $Access_Profile = $value['Access-Profile'];
            $newdata['Session_IP'] = $value['IPv4'];
            $newdata['Device-Family'] = $value['Device-Family'];
            array_push($res_arrr, $mac_uname);
            array_push($res_arrr2, $Access_Profile);
            array_push($res_arrr3, $session_mac);
            array_push($res_arrr4, $newdata);
        }


        $cus_devices = array();

        if (!$backup) {
            $get_cus_id_q = "SELECT customer_id AS f FROM mdu_vetenant WHERE username = '$customer_username'";
        } else {
            $get_cus_id_q = "SELECT id AS f FROM mdu_customer_backup WHERE username='$customer_username' AND delete_id='$search_id'";
        }
        $customer_id = $this->db->getValueAsf($get_cus_id_q);


        //print_r($data = json_decode($parameters, true));
        $status_code = $decoded['status_code'];
        if ($status_code == '200' || $status_code == '404') {
            // if(!$backup){
            //     $query_del_devices = "DELETE FROM `mdu_customer_devices` WHERE `user_name` = '$customer_username'";
            //     $$this->db->execDB_delete_mac = $this->db->execDB($query_del_devices);
            // }



            for ($i = 0; $i < sizeof($bulk_profile_data); $i++) {

                if (sizeof($bulk_profile_data[$i]) > 0) {

                    $array_value = $bulk_profile_data[$i];
                    $User_Name = $array_value['User-Name'];


                    $Group = $array_value['Group'];
                    $firstname = $this->db->escapeDB(trim(str_replace("\\","",$array_value['PAS-First-Name'])));
                    $PAS_Last_Name = $this->db->escapeDB(trim(str_replace("\\","",$array_value['PAS-Last-Name'])));
                    $contact = $array_value['MSISDN'];
                    $group = $array_value['Group'];
                    $purge = $array_value['Purge-Delay-Time'];
                    $uuid = $array_value['UUID'];
                    $password = $array_value['Password'];
                    $profile = $array_value['Service-Profiles'];
                    $Master_Account = $array_value['Master-Account'];

                    if (strpos($Master_Account, '/') !== false) {

                        $master = explode('/', $Master_Account);
                        $b = sizeof($master);
                        $email_new = $master[0];
                        $a = $b - 1;
                        $organization = $master[$a];
                    } else {
                        $master = explode('@', $Master_Account);
                        $b = sizeof($master);
                        $email_new = $master[0] . '@' . $master[1];
                        $a = $b - 1;
                        $organization = $master[$a];
                    }


                    if (!empty($User_Name)) {


                        // $query_0 = "SELECT id FROM `mdu_customer_devices` WHERE mac_address = '$User_Name'";

                        // $result_0 = $this->db->execDB($query_0);

                        $PAS_Last_Name = $this->db->escapeDB($PAS_Last_Name);


                        //echo $User_Name;
                        if (strpos($User_Name, '/') !== false) {
                            $mac_original_array = explode("/", $User_Name);
                            $mac_original_val = $mac_original_array[0];
                        } else {
                            $mac_original_array = explode("@", $User_Name);
                            $mac_original_val = $mac_original_array[0];
                        }

                        if (in_array($User_Name, $res_arrr) || in_array($mac_original_val, $res_arrr3)) {
                            $a = array_search($mac_original_val, $res_arrr3, true);
                            $acc_stat = $res_arrr2[$a];
                            $arraynew = $res_arrr4[$a];
                            /*$arraynew = array(
                                    'Session_IP' => $Session_IP);*/
                            $json_other = json_encode($arraynew);
                            if ($acc_stat == 'REDIRECT') {
                                $state = 'Inactive';
                            } else {
                                $state = 'Active';
                            }
                        } else {
                            //$arraynew = array();
                            $json_other = null;
                            $state = 'Inactive';
                        }



                        if (!$backup) {
                            // if (mysql_num_rows($result_0) >= 1) {

                            //     $queryd = "UPDATE `mdu_customer_devices` SET
                            //      `customer_id` = '$customer_id',
                            //      `email_address` = '$email_new',
                            //      `mac_address` = '$User_Name',
                            //       `group` = '$Group',
                            //      description = '$mac_original_val',
                            //      `user_name` = '$Master_Account',
                            //      nick_name = '$PAS_Last_Name',
                            //      `create_user` = '$state',
                            //      `create_date`  = NOW()
                            //      WHERE mac_address = '$User_Name'";
                            // } else {
                            //     $queryd = "INSERT INTO `mdu_customer_devices`
                            //         (`customer_id`, `email_address`,nick_name, `group`, `mac_address`,description, `user_name`, `create_user`, `create_date`)
                            //         VALUES ('$customer_id', '$email_new','$PAS_Last_Name','$Group', '$User_Name','$mac_original_val', '$Master_Account', '$state', NOW())";
                            // }

                            $queryd = "INSERT INTO `mdu_customer_devices`
                                    (`customer_id`, `email_address`,nick_name, `other_parameters`, `group`, `mac_address`,`description`, `user_name`, `create_user`, `create_date`,`search_id`)
                                    VALUES ('$customer_id', '$email_new','$PAS_Last_Name','$json_other','$Group', '$User_Name','$mac_original_val', '$Master_Account', '$state', NOW(),'$search_id') 
                                    ON DUPLICATE KEY UPDATE 
                                    `customer_id` = '$customer_id',
                                    `email_address` = '$email_new',
                                    `mac_address` = '$User_Name',
                                    `group` = '$organization',
                                     description = '$mac_original_val',
                                    `user_name` = '$Master_Account',
                                    nick_name = '$PAS_Last_Name',
                                    other_parameters = '$json_other',
                                    `create_user` = '$state',
                                    `create_date`  = NOW(),
                                    `search_id` ='$search_id' ";
                        } else {

                            $queryd = "INSERT INTO `mdu_customer_devices_backup`
(`customer_id`,`email_address`,nick_name,  `mac_address`,description, `user_name`, `create_user`, `create_date`,delete_id)
VALUES ('$customer_id','$email_new','$PAS_Last_Name', '$User_Name','$mac_original_val', '$Master_Account', 'API', NOW(),'$search_id')";
                        }

                        if (strlen($User_Name) > 0) {

                            $this->db->execDB($queryd);


                            array_push($cus_devices, $User_Name);

                            /* Call Session API */
                            $url_base_mdu_sessions = $this->base_url . '/ajax/update_sessions.php?mac=' . $mac_original_val;
                        }
                    }

                    $User_Name = '';
                    $PAS_Last_Name = '';
                    $Master_Account = '';
                    $EMAIL = '';
                    $Group = '';
                    $mac_original_val = '';
                }
            }



            if (!$backup) {
                $query_del_devices = "DELETE FROM `mdu_customer_devices` WHERE `user_name` = '$customer_username'  AND (search_id <> '$search_id' OR search_id IS NULL)";

                //    $this->db->execDB("INSERT INTO `mdu_customer_devices_archive` 
                //     (`id`,`customer_id`,`email_address`,`nick_name`,`group`,`description`,`mac_address`,`user_name`,`create_user`,`create_date`,`archived_by`)
                //       SELECT `id`,`customer_id`,`email_address`,`nick_name`,`group`,`description`,`mac_address`,`user_name`,`create_user`,`create_date`,'Sync'
                //       FROM `mdu_customer_devices` WHERE `user_name` = '$customer_username'  AND (search_id <> '$search_id' OR search_id IS NULL) ");

                $this->mdu_customer_devices_archive_searchID($search_id, $customer_username, 'Sync'); // mdu customer devices archive


                $mysql_query_delete_mac = $this->db->execDB($query_del_devices);
            }
        }
        $cus_devices = array_unique($cus_devices);
        return $cus_devices;
    }

    //----------------------------------
    public function syncMemoryCustomer($Response, $search_id_up, $group = null, $backup = false)
    {

        $count = 0;
        $sub_acc = 0;
        $master_user_ar = array();

        $decoded = json_decode($Response, true);
        $bulk_profile_data = $decoded['Description'];

        $newarray = array();
        foreach ($bulk_profile_data as $value2) {
            //print_r($value2);
            $user_name = ($value2['User-Name']);
            $master_acc = ($value2['Master-Account']);
            //echo $user_name;
            if (strpos($user_name, '/') !== false) {
                $groups = explode('/', $user_name);
                $b = sizeof($groups);
                $a = $b - 1;
                $organization = $groups[$a];
            } else {
                $groups = explode('@', $user_name);
                $b = sizeof($groups);
                $a = $b - 1;
                $organization = $groups[$a];
            }
            if ($organization == $group && empty($master_acc)) {
                array_push($newarray, $value2);
                # code...
            }
        }


        if (empty($newarray)) {
        } else {
            if ($newarray['User_Name']) {
                $single_profile_data1 = 1;
                $newarray[0] = $newarray;
            } else {
                $single_profile_data1 = sizeof($newarray);
            }

            $test_ar = array();
            if (!$backup) {
                $queryd = "REPLACE INTO `mdu_customer_memory` 
        (`validity_time`,`warning_message`,`violation`,`vlan_id`,`email`,`first_name`,`last_name`,username,`password`,`question_id`,property_id,valid_from,valid_until,`answer`,company_name,address,city,state,postal_code,country,phone,create_date,service_profile,search_id,create_user)
        VALUES";
            } else {
                $queryd = "REPLACE INTO `mdu_customer_backup` 
        (`validity_time`,`warning_message`,`violation`,`vlan_id`,`email`,`first_name`,`last_name`,username,`password`,`question_id`,property_id,valid_from,valid_until,`answer`,company_name,address,city,state,postal_code,country,phone,create_date,service_profile,search_id,create_user)
        VALUES";
            }


            $arr_new = array();
            for ($k = 0; $k < $single_profile_data1; $k++) {

                $single_profile_data1;
                $array_get_profile_value = $newarray[$k];
                $Master_Account = '';
                $count++;


                $User_Name = $array_get_profile_value['User-Name'];
                //$MSISDN = $array_get_profile_value['MSISDN'];
                $PAS_First_Name = $this->db->escapeDB(trim(str_replace("\\","",$array_get_profile_value['PAS-First-Name'])));
                $PAS_Last_Name = $this->db->escapeDB(trim(str_replace("\\","",$array_get_profile_value['PAS-Last-Name'])));
                $secret_question = $this->db->escapeDB($array_get_profile_value['secret_question']);
                $secret_answer = $this->db->escapeDB($array_get_profile_value['secret_answer']);
                $company = $this->db->escapeDB($array_get_profile_value['company']);
                $Email = $array_get_profile_value['Email'];
                $Password = $array_get_profile_value['Password'];
                //$Group = $array_get_profile_value['Group'];
                $zip = $this->db->escapeDB($array_get_profile_value['zip']);
                $Valid_From = $array_get_profile_value['Valid-From'];
                $Valid_Until = $array_get_profile_value['Valid-Until'];
                $MSISDN = $array_get_profile_value['MSISDN'];
                $Master_Account = $array_get_profile_value['Master-Account'];
                $ser_prof = $array_get_profile_value['Service-Profiles'];
                if (count($array_get_profile_value['User-Data']) > 0) {
                    $vlan_id = $array_get_profile_value['User-Data']['VT-Vlan-Id'];
                    $secret_question = $this->db->escapeDB($array_get_profile_value['User-Data']['secret_question']);
                    $secret_answer = $this->db->escapeDB($array_get_profile_value['User-Data']['secret_answer']);
                    $country = $this->db->escapeDB($array_get_profile_value['User-Data']['country']);
                    $state = $this->db->escapeDB($array_get_profile_value['User-Data']['state']);
                    $zip = $this->db->escapeDB($array_get_profile_value['User-Data']['zip']);
                    $city = $this->db->escapeDB($array_get_profile_value['User-Data']['city']);
                    $address = $this->db->escapeDB($array_get_profile_value['User-Data']['address']);
                    $violation = $array_get_profile_value['User-Data']['violation'];
                    $warning = $array_get_profile_value['User-Data']['warning'];
                } else {
                    $vlan_id = $array_get_profile_value['VT-Vlan-Id'];
                    $secret_question = $this->db->escapeDB($array_get_profile_value['secret_question']);
                    $secret_answer = $this->db->escapeDB($array_get_profile_value['secret_answer']);
                    $country = $this->db->escapeDB($array_get_profile_value['country']);
                    $state = $this->db->escapeDB($array_get_profile_value['state']);
                    $zip = $this->db->escapeDB($array_get_profile_value['zip']);
                    $city = $this->db->escapeDB($array_get_profile_value['city']);
                    $address = $this->db->escapeDB($array_get_profile_value['address']);
                    $violation = $array_get_profile_value['violation'];
                    $warning = $array_get_profile_value['warning'];
                }

                $state = $this->getStateCode($state);

                $Validity_Time_cal = $Valid_Until - $Valid_From;
                $Validity_Time = empty($Validity_Time_cal) ? 0 : $Validity_Time_cal;

                //$Validity_Time = empty($array_get_profile_value['Validity-Time'])?0:$array_get_profile_value['Validity-Time'];

                array_push($arr_new, $vlan_id);






                if (strlen($Master_Account) == 0) {
                    if (strlen($User_Name) > 0) {
                        //echo $queryd.'<br>';

                        //$Master_user=$User_Name;
                        $queryd .= "('$Validity_Time','$warning','$violation','$vlan_id','$Email','$PAS_First_Name','$PAS_Last_Name','$User_Name','$Password', '$secret_question','$group','$Valid_From','$Valid_Until','$secret_answer','$company','$address','$city','$state','$zip','$country','$MSISDN',NOW(),'$ser_prof','$search_id_up','API'),";



                        array_push($master_user_ar, $User_Name);
                    }
                } else {

                    $sub_acc++;
                }



                $User_Name = '';
                $Master_Account = '';
                $updated = 1;

                $Email = '';
                $EMAIL = '';
                $PAS_First_Name = '';
                $PAS_Last_Name = '';
                $User_Name = '';
                $secret_question = '';
                $Group = '';
                $secret_answer = '';
                $company = '';
                $address = '';
                $city = '';
                $state = '';
                $zip = '';
                $country = '';
                $MSISDN = '';
                $Valid_From = '';
                $Valid_Until = '';
                $vlan_id = '';
                $ser_prof = '';
                $violation = '';
                $warning = '';
            }
        }



        $queryd_ex = rtrim($queryd, ", ");

        // echo $queryd_ex;
        // echo "<br><br>";
        $ex1 = $this->db->execDB($queryd_ex);

        if ($ex1 === true) {

            //print_r($arr_new);

            foreach ($arr_new as $acc_vl) {

                $have_vlane = $this->vlan_functions->checkVlanID_Random($group, $acc_vl);
                // echo $acc_vl."-".$have_vlane."<br>";

                if ($have_vlane) {
                    $have_vlane = $this->vlan_functions->DeleteVlanID_Random($group, $acc_vl);
                }
            }
            // echo "<br><br><br><br><br>";
            $re_val = array("master_acc" => $master_user_ar, "count" => $count, "systuts" => '200');

            return $re_val;
        } else {
            $re_val = array("master_acc" => $master_user_ar, "systuts" => '500');

            return $re_val;
        }
    }

    public function syncMemoryCustomerDevices($Response, $customer_username, $search_id, $backup = false)
    {


        $count = 0;


        //parse_str($Response);

        $decoded = json_decode($Response, true);

        $bulk_profile_data = $decoded['Description'];

        $session_profile_data = $decoded['status'];


        $res_arrr = array();
        $res_arrr2 = array();
        foreach ($session_profile_data as $value) {
            $mac_uname = $value['Login-User-Name'];
            $Access_Profile = $value['Access-Profile'];
            array_push($res_arrr, $mac_uname);
            array_push($res_arrr2, $Access_Profile);
        }






        //print_r($data = json_decode($parameters, true));
        $status_code = $decoded['status_code'];
        if ($status_code == '200' || $status_code == '404') {




            for ($i = 0; $i < sizeof($bulk_profile_data); $i++) {

                if (sizeof($bulk_profile_data[$i]) > 0) {

                    $array_value = $bulk_profile_data[$i];
                    $User_Name = $array_value['User-Name'];




                    $Group = $array_value['Group'];
                    $firstname = $this->db->escapeDB(trim(str_replace("\\","",$array_value['PAS-First-Name'])));
                    $PAS_Last_Name = $this->db->escapeDB(trim(str_replace("\\","",$array_value['PAS-Last-Name'])));
                    $contact = $array_value['MSISDN'];
                    $group = $array_value['Group'];
                    $purge = $array_value['Purge-Delay-Time'];
                    $uuid = $array_value['UUID'];
                    $password = $array_value['Password'];
                    $profile = $array_value['Service-Profiles'];
                    $Master_Account = $array_value['Master-Account'];
                    $First_Access = $array_value['First-Access'];
                    $Last_Access = $array_value['Last-Access'];

                    if (strpos($Master_Account, '/') !== false) {

                        $master = explode('/', $Master_Account);
                        $b = sizeof($master);
                        $email_new = $master[0];
                        $a = $b - 1;
                        $organization = $master[$a];
                    } else {
                        $master = explode('@', $Master_Account);
                        $b = sizeof($master);
                        $email_new = $master[0] . '@' . $master[1];
                        $a = $b - 1;
                        $organization = $master[$a];
                    }


                    if (!empty($User_Name)) {



                        $PAS_Last_Name = $this->db->escapeDB($PAS_Last_Name);

                        $count++;
                        //echo $User_Name;
                        if (strpos($User_Name, '/') !== false) {
                            $mac_original_array = explode("/", $User_Name);
                            $mac_original_val = $mac_original_array[0];
                        } else {
                            $mac_original_array = explode("@", $User_Name);
                            $mac_original_val = $mac_original_array[0];
                        }



                        $cus_devices['User-Name'] = $User_Name;
                        $cus_devices['Email'] = $email_new;
                        $cus_devices['Group'] = $organization;
                        $cus_devices['PAS_Last_Name'] = $PAS_Last_Name;
                        $cus_devices['Mac_original_val'] = $mac_original_val;
                        $cus_devices['Master-Account'] = $Master_Account;
                        $cus_devices['First_Access'] = $First_Access;
                        $cus_devices['Last_Access'] = $Last_Access;
                        $cus_devices['search_id'] = $search_id;

                        array_push($this->device_data, $cus_devices);
                    }

                    $User_Name = '';
                    $PAS_Last_Name = '';
                    $Master_Account = '';
                    $EMAIL = '';
                    $Group = '';
                    $mac_original_val = '';
                }
            }
        }




        return $count;
    }


    public function syncCustomerDevicesEx($ex = false, $backup = false)
    {

        if ($ex) {

            if (!$backup) {
                $queryd = "INSERT INTO `mdu_customer_devices_memory`
            (`email_address`,nick_name, `group`, `mac_address`,`description`, `user_name`,`First_Access`,`Last_Access`, `create_user`, `create_date`)
            VALUES";
                foreach ($this->device_data as $key => $values) {

                    $User_Name = $values['User-Name'];
                    $PAS_Last_Name = $values['PAS_Last_Name'];
                    $Master_Account = $values['Master-Account'];
                    $EMAIL = $values['Email'];
                    $Group = $values['Group'];
                    $First_Access = $values['First_Access'];
                    $Last_Access = $values['Last_Access'];
                    $mac_original_val = $values['Mac_original_val'];

                    $queryd .= "( '$EMAIL','$PAS_Last_Name','$Group', '$User_Name','$mac_original_val', '$Master_Account', '$First_Access', '$Last_Access', 'syc', NOW()),";
                }
            } else {

                $queryd = "INSERT INTO `mdu_customer_devices_backup`
            (`customer_id`,`email_address`,nick_name,  `mac_address`,description, `user_name`, `create_user`, `create_date`,delete_id) VALUES";



                foreach ($this->device_data as $key => $values) {

                    $User_Name = $values['User-Name'];
                    $PAS_Last_Name = $values['PAS_Last_Name'];
                    $Master_Account = $values['Master-Account'];
                    $EMAIL = $values['Email'];
                    $Group = $values['Group'];
                    $First_Access = $values['First_Access'];
                    $Last_Access = $values['Last_Access'];
                    $mac_original_val = $values['Mac_original_val'];
                    $search_id = $values['search_id'];

                    $queryd .= "('$EMAIL','$PAS_Last_Name', '$User_Name','$mac_original_val', '$Master_Account', 'API', NOW(),'$search_id'),";
                }
            }
            $queryd_ex = rtrim($queryd, ", ");

            $this->db->execDB($queryd_ex);
        }
    }
    /*customer*/
    public function addCustomer($property_id, $search_id)
    {

        $query = "INSERT INTO `mdu_vetenant`
        (`validity_time`,`warning_message`,`violation`,`vlan_id`,`email`,`first_name`,`last_name`,username,`question_id`,property_id,valid_from,valid_until,`answer`,company_name,address,city,state,postal_code,country,phone,create_date,service_profile,search_id,create_user)
        SELECT `validity_time`,`warning_message`,`violation`,`vlan_id`,`email`,`first_name`,`last_name`,username,`question_id`,property_id,valid_from,valid_until,`answer`,company_name,address,city,state,postal_code,country,phone,create_date,service_profile,'$search_id',create_user  FROM mdu_customer_memory m WHERE property_id='$property_id'
        ON DUPLICATE KEY UPDATE
          `validity_time`=m.validity_time,
          `warning_message`=m.warning_message,
          `violation`=m.violation,
          `vlan_id`=m.vlan_id,
          `email`=m.email,
          `first_name`=m.first_name,
          `last_name`=m.last_name,
          `question_id`=m.question_id,
          valid_from=m.valid_from,
          valid_until=m.valid_until,
          `answer`=m.answer,
          company_name=m.company_name,
          address=m.address,
          city=m.city,
          state=m.state,
          postal_code=m.postal_code,
          country=m.country,
          phone=m.phone,
          service_profile=m.service_profile,search_id='$search_id'";


        $this->db->execDB($query);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    /*device*/
    public function addCustomerDevices($property_id)
    {

        $query = "INSERT INTO mdu_customer_devices(customer_id,`email_address`,nick_name, `group`, `mac_address`,`description`, `user_name`,`create_user`, `create_date`)
        SELECT c.customer_id,`email_address`,nick_name, `group`, `mac_address`,`description`, `user_name`,m.`create_user`, m.`create_date`
        FROM mdu_customer_devices_memory m JOIN mdu_vetenant c ON m.user_name=c.username WHERE `group`='$property_id'
    ON DUPLICATE KEY UPDATE
      customer_id = c.customer_id,
      `email_address`=m.email_address,
      nick_name=m.nick_name,
      `group`=m.`group`,
      `description`=m.description,
      `user_name`=m.user_name,
      `create_user`=m.create_user,
      `create_date`=m.create_date";


        $ex = $this->db->execDB($query);

        if ($ex === true) {
            return true;
        } else {
            return false;
        }
    }

    public function syncCustomerPurgeData($property_id)
    {

        $query = "INSERT INTO mdu_purge_accounts(`first_name`, `last_name`,vlan_id, `email`, `username`, `property_id`, `valid_from`, `valid_until`, `device_list`, `number_of_devices`, `master_age`, `device_min_age`, create_date, `create_user`)
        SELECT
          c.first_name,
          c.last_name,
          c.vlan_id,
          c.email,
          c.username,
          c.property_id,
          c.valid_from,
          c.valid_until,
          CONCAT('[',GROUP_CONCAT( CASE WHEN d.Last_Access <> \"\" THEN CONCAT('{\"',d.mac_address,'\":\"',d.Last_Access,'\"}') ELSE NULL END SEPARATOR \",\" ),']') AS device_list,
          count(d.mac_address) AS number_of_devices,
          valid_until-UNIX_TIMESTAMP() AS master_age,
         
          UNIX_TIMESTAMP()-
          MIN( CASE
               WHEN d.Last_Access IS NULL THEN UNIX_TIMESTAMP()
               WHEN d.Last_Access = '' THEN UNIX_TIMESTAMP()
               ELSE d.Last_Access
               END) AS device_min_age,
          c.create_date,
          c.create_user
        FROM mdu_customer_memory c LEFT JOIN mdu_customer_devices_memory d ON c.username=d.user_name
        WHERE c.property_id='$property_id' GROUP BY c.username
        ON DUPLICATE KEY UPDATE 
        `first_name`=VALUES(first_name), `last_name`=VALUES(last_name), `valid_from`=VALUES(valid_from), `valid_until`=VALUES(valid_until), `device_list`=VALUES(device_list), `number_of_devices`=VALUES(number_of_devices), `master_age`=VALUES(master_age), `device_min_age`=VALUES(device_min_age)";


        $this->db->execDB($query);

        $query1 = "INSERT INTO mdu_mastera_acc_purge (`username`,`count`,`create_user`,`create_date`)
          SELECT username,1,'purge_script',NOW() FROM mdu_purge_accounts WHERE number_of_devices=0 AND property_id='$property_id'
          ON DUPLICATE KEY UPDATE `count`=`count`+1";

        $this->db->execDB($query1);

        $query1_1 = "DELETE FROM `mdu_mastera_acc_purge`
          WHERE `username`=ANY(
          SELECT `username` FROM mdu_purge_accounts
          WHERE `number_of_devices` >0)";

        $this->db->execDB($query1_1);

        $query2 = "DELETE FROM mdu_purge_device_accounts WHERE device IN (SELECT `mac_address` FROM mdu_customer_devices_memory
          WHERE `group`='$property_id' AND `Last_Access` <> '' )";

        $this->db->execDB($query2);

        $query2_1 = "INSERT INTO mdu_purge_device_accounts (`username`, `property_id`,`device`,`count`,`sync_status`,`create_user`,`create_date`)         
          SELECT user_name,`group`,mac_address,1,1,'purge_script',NOW() FROM mdu_customer_devices_memory
          WHERE `group`='$property_id' AND (Last_Access ='' OR Last_Access IS NULL )
          ON DUPLICATE KEY UPDATE `count`=`count`+1, `sync_status` =1";


        $this->db->execDB($query2_1);
    }

    //----------------------------------------------------------------------

    public function syncDevice($Response, $search_id, $group = null, $backup = false)
    {

        $return_ar = array();


        $responce_array = array();
        //parse_str($Response,$responce_array);
        $decoded = json_decode($Response, true);

        $bulk_profile_data = $decoded['Description'];

        $newarray = array();
        foreach ($bulk_profile_data as $value2) {

            $user_name = ($value2['User-Name']);
            $master_acc = ($value2['Master-Account']);

            $groups = explode('@', $user_name);
            $b = sizeof($groups);
            $a = $b - 1;
            $organization = $groups[$a];

            if ($organization == $group && !empty($master_acc)) {
                array_push($newarray, $value2);
                # code...
            }
        }

        $status_code = $decoded['status_code'];
        if ($status_code == '200' || $status_code == '404') {


            for ($k = 0; $k < sizeof($newarray); $k++) {
                if (sizeof($newarray[$k]) > 0) {
                    $single_profile_data_ar = $newarray[$k];


                    $User_Name = $this->db->escapeDB($single_profile_data_ar['User-Name']);
                    $PAS_Last_Name = $this->db->escapeDB($single_profile_data_ar['PAS-Last-Name']);
                    $Master_Account = $this->db->escapeDB($single_profile_data_ar['Master-Account']);
                    $EMAIL = $this->db->escapeDB($single_profile_data_ar['Email']);
                    $Group = $group; //$this->db->escapeDB($single_profile_data_ar['Group']);
                    $customer_id = $this->db->getValueAsf("SELECT customer_id AS f FROM mdu_vetenant WHERE username='$Master_Account'");

                    $master = explode('@', $Master_Account);
                    $b = sizeof($master);
                    $email_new = $master[0] . '@' . $master[1];
                    $a = $b - 1;
                    $organization = $master[$a];


                    $query_0 = "SELECT id FROM `mdu_customer_devices` WHERE mac_address = '$User_Name'";

                    $result_0 = $this->db->selectDB($query_0);

                    $mac_original_array = explode("@", $User_Name);
                    $mac_original_val = $mac_original_array[0];

                    if (!$backup) {
                        if ($result_0['rowCount'] >= 1) {

                            $queryd = "UPDATE `mdu_customer_devices` SET
                                 `customer_id` = '$customer_id',
                                 `email_address` = '$email_new',
                                 `mac_address` = '$User_Name',
                                  `group` = '$Group',
                                 description = '$mac_original_val',
                                 `user_name` = '$Master_Account',
                                 nick_name = '$PAS_Last_Name',
                                 `create_user` = 'API',
                                 `create_date`  = NOW()
                                 WHERE mac_address = '$User_Name'";
                        } else {
                            $queryd = "REPLACE INTO `mdu_customer_devices`
                                    (`customer_id`, `email_address`,nick_name, `group`, `mac_address`,description, `user_name`, `create_user`, `create_date`)
                                    VALUES ('$customer_id', '$email_new','$PAS_Last_Name','$Group', '$User_Name','$mac_original_val', '$Master_Account', 'API', NOW())";
                        }
                    } else {
                        $queryd = "INSERT INTO `mdu_customer_devices_backup`
                                            (`customer_id`,`email_address`,nick_name,  `mac_address`,description, `user_name`, `create_user`, `create_date`,delete_id)
                                            VALUES ('$customer_id','$email_new','$PAS_Last_Name', '$User_Name','$mac_original_val', '$Master_Account', 'API', NOW(),'$search_id')";
                    }

                    if (strlen($User_Name) > 0) {

                        $this->db->execDB($queryd);


                        array_push($return_ar, $Master_Account);
                    }



                    $User_Name = '';
                    $PAS_Last_Name = '';
                    $Master_Account = '';
                    $EMAIL = '';
                    $Group = '';
                    $mac_original_val = '';
                }
            }
        }
        //print_r( $Master_Account);
        return $return_ar;
    }

    public function mdu_vtenet_archive($master_user, $archived_by)
    {

        $this->db->execDB("INSERT INTO `mdu_vetenant_archive`
    (`customer_id`, `first_name`, `last_name`, `email`, `username`, `password`,	`dpsk_key`, `first_login_date`, `last_login_date`, `property_id`, `qos_override`, `room_apt_no`, `question_id`, `answer`, `company_name`, `address`, `city`, `state`, `postal_code`, `country`, `phone`, `vlan_id`, `is_enable`, `email_sent`, `registration_from`, `device_count`, `valid_from`, `valid_until`, `service_profile`, `profile_type`, `violation`, `warning_message`, `duration`, `validity_time`, `cloud_path_id`, `create_user`, `create_date`, `search_id`, `last_update`,`archived_by`)
    SELECT `customer_id`, `first_name`, `last_name`, `email`, `username`, `password`,  `dpsk_key`, `first_login_date`, `last_login_date`, `property_id`, `qos_override`, `room_apt_no`, `question_id`, `answer`, `company_name`, `address`, `city`, `state`, `postal_code`, `country`, `phone`, `vlan_id`, `is_enable`, `email_sent`, `registration_from`, `device_count`, `valid_from`, `valid_until`, `service_profile`, `profile_type`, `violation`, `warning_message`, `duration`, `validity_time`, `cloud_path_id`, `create_user`, `create_date`, `search_id`, `last_update`, '$archived_by' 
    FROM mdu_vetenant  WHERE `username`='$master_user' ");
    }

    public function mdu_customer_devices_archive($mac_address, $archived_by)
    {

        $this->db->execDB("INSERT INTO `mdu_customer_devices_archive` 
    (`id`,`customer_id`,`email_address`,`nick_name`,`group`,`cloutpath_id`,`description`,`mac_address`,`user_name`,`create_user`,`create_date`,`archived_by`)
      SELECT `id`,`customer_id`,`email_address`,`nick_name`,`group`,`cloutpath_id`,`description`,`mac_address`,`user_name`,`create_user`,`create_date`,'$archived_by'
      FROM `mdu_customer_devices` WHERE `mac_address` = '$mac_address' ");
    }

    public function mdu_vtenet_archive_searchID($search_id, $property_id, $archived_by)
    {

        $this->db->execDB("INSERT INTO `mdu_vetenant_archive`
    (`customer_id`, `first_name`, `last_name`, `email`, `username`, `password`, `dpsk_key`,`first_login_date`, `last_login_date`, `property_id`, `qos_override`, `room_apt_no`, `question_id`, `answer`, `company_name`, `address`, `city`, `state`, `postal_code`, `country`, `phone`, `vlan_id`, `is_enable`, `email_sent`, `registration_from`, `device_count`, `valid_from`, `valid_until`, `service_profile`, `profile_type`, `violation`, `warning_message`, `duration`, `validity_time`, `cloud_path_id`,`create_user`, `create_date`, `search_id`, `last_update`, `archived_by`)
    SELECT `customer_id`, `first_name`, `last_name`, `email`, `username`, `password`,  `dpsk_key`, `first_login_date`, `last_login_date`, `property_id`, `qos_override`, `room_apt_no`, `question_id`, `answer`, `company_name`, `address`, `city`, `state`, `postal_code`, `country`, `phone`, `vlan_id`, `is_enable`, `email_sent`, `registration_from`, `device_count`, `valid_from`, `valid_until`, `service_profile`, `profile_type`, `violation`, `warning_message`, `duration`, `validity_time`, `cloud_path_id`, `create_user`, `create_date`, `search_id`, `last_update`, '$archived_by' 
    FROM mdu_vetenant  WHERE (`search_id`<> '$search_id' OR `search_id` IS NULL) AND `property_id`='$property_id'");
    }

    public function mdu_customer_devices_archive_searchID($search_id, $customer_username, $archived_by)
    {

        $this->db->execDB("INSERT INTO `mdu_customer_devices_archive` 
    (`id`,`customer_id`,`email_address`,`nick_name`,`group`,`cloutpath_id`,`description`,`mac_address`,`user_name`,`create_user`,`create_date`,`archived_by`)
      SELECT `id`,`customer_id`,`email_address`,`nick_name`,`group`,`cloutpath_id`,`description`,`mac_address`,`user_name`,`create_user`,`create_date`,'$archived_by'
      FROM `mdu_customer_devices` WHERE `user_name` = '$customer_username'  AND (search_id <> '$search_id' OR search_id IS NULL) ");
    }

    // response data convert to array
    function convertResToArray($data_set)
    {

        $urlExploded =  explode("&", $data_set);
        $return = array();
        foreach ($urlExploded as $param) {
            $explodedPar = explode("=", $param);
            $return[$explodedPar[0]] = $explodedPar[1];
        }
        return $return;
    }
}
