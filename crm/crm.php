<?php 
    include 'header_new.php';

    /*classes & libraries*/
    $db = new db_functions();
    $package_functions = new package_functions();
    $CommonFunctions = new CommonFunctions();
    /*Encryption script*/
    include_once 'classes/cryptojs-aes.php';
    require_once dirname(__FILE__) . '/models/clientUserModel.php';
    // echo 'Username= ';
    require_once 'src/CRM/functions.php';
    $client_model = new clientUserModel();
    $client_data = $client_model->getClient($_SESSION['user_id'], 'user_id');
    $api_id = $client_data[0]['api_profile'];
    $api_details = $CommonFunctions->getApiDetails($api_id);

    $page = "CRM";
    $apiVersion = 0;
    $apiUrl = '';
    $apiUsername = '';
    $apiPassword = '';

    if(!empty($api_details['data'])) {
        $apiVersion = $api_details['data'][0]['controller_name'];
        $apiUrl = $api_details['data'][0]['api_url'];
        $apiUsername = $api_details['data'][0]['api_username'];
        $apiPassword = $api_details['data'][0]['api_password'];
    }

    if($user_type == 'ADMIN' || $user_type == 'SADMIN') {
        $operators = $CommonFunctions->getAllOperators();
        if(isset($_POST['load_operator'])) {
            $operatorsSystemPackage = null;
            $selected_operator = $_POST['selected_operator'];
            $operatorsPackage = $CommonFunctions->getSystemPackage($selected_operator);
            if($operatorsPackage['rowCount'] > 0){
                $operatorsSystemPackage = $operatorsPackage['data'][0]['f'];
                $camp_layout = $package_functions->getSectionType("CAMP_LAYOUT", $operatorsSystemPackage);
            }
        }
    }
   
    $data_secret = $db->setVal('data_secret', 'ADMIN');    
    require_once 'layout/' . $camp_layout . '/config.php';
    $edit = false;
    $opt_q = $package_functions->getSectionType("OPT_CODE", $system_package);
    $get_opt_code = (isset($opt_q)) ? $opt_q : 'SDL'; //$db->getValueAsf("SELECT api_prefix as f FROM exp_mno WHERE mno_id = '$user_distributor'");

    $priority_zone_array = array(
        "America/New_York",
        "America/Chicago",
        "America/Denver",
        "America/Los_Angeles",
        "America/Anchorage",
        "Pacific/Honolulu",
    );

    $view_type = isset($_GET['t']) ? $_GET['t'] : null;

    $formTitle = "Create Orders";
    $activatePopup = false;

    switch($view_type) {
        case 'crm_view' :
            $formTitle = "View";
            $tab_crm_create = 'set';
            $activatePopup = true;
        break;
        case 'crm_create' :
            $formTitle = "Create";
        break;
        case 'crm_edit' :
            $formTitle = "Edit";
        break;
    }

    $crm = new crm($api_id, $system_package);

    if (isset($_GET['edit'])) {
        $edit = true;
        $id = $_GET['id'];
        $result = $db->select1DB("SELECT * FROM exp_crm WHERE id = '$id'");
        $get_service_type = $result['service_type'];
        $get_business_name = $result['business_name'];
        $get_business_id = $result['business_id'];
        $get_contact_name = $result['contact_name'];
        $get_contact_phone = $result['contact_number'];
        $get_contact_email = $result['contact_email'];
        $get_order_number = $result['order_number'];
        $get_city = $result['city'];
        $get_zip = $result['zip'];
        $get_timezone = $result['timezone'];
        $get_account_number = $result['account_number'];
        $get_street = $result['street'];
        $get_state = $result['state'];
        $get_status= $result['status'];
        $wifi_unique = $result['property_id'];
        $get_wifi_unique = str_replace($get_opt_code, "", $wifi_unique);

        $result_wifi = json_decode($result['wifi_information'], true);
        $get_more_than_one_sites = $result_wifi['more_than_one_sites'];
        $get_guest_ssid = $result_wifi['guest_ssid'];
        $get_wifi_street = $result_wifi['wifi_street'];
        $get_wifi_state = $result_wifi['wifi_state'];
        $get_wifi_contact = $result_wifi['wifi_contact'];
        $get_wifi_email = $result_wifi['wifi_email'];
        $get_wifi_ins_time = $result_wifi['wifi_ins_time'];
        $get_wifi_site_name = $result_wifi['wifi_site_name'];
        $get_private_ssid = $result_wifi['private_ssid'];
        $get_wifi_city = $result_wifi['wifi_city'];
        $get_wifi_zip = $result_wifi['wifi_zip'];
        $get_wifi_phone = $result_wifi['wifi_phone'];
        $get_wifi_prop_type = $result_wifi['wifi_prop_type'];
        $get_wifi_ins_date = $result_wifi['wifi_ins_date'];
        $get_wifi_ins_start = $result_wifi['wifi_ins_start'];

        $result_product = json_decode($result['product_information'], true);
        $get_prod_order_type = $result_product['prod_order_type'];
        $get_prod_in_ap_quant = $result_product['prod_in_ap_quant'];
        $get_prod_content_filter = $result_product['prod_content_filter'];
        $get_prod_circuit_type = $result_product['prod_circuit_type'];
        $get_prod_guest = $result_product['prod_guest'];
        $get_prod_telco = $result_product['prod_telco'];
        $get_prod_cabling = $result_product['prod_cabling'];
        $get_prod_flow_plan = $result_product['prod_flow_plan'];
        $get_prod_cover_area = $result_product['prod_cover_area'];
        $get_prod_square_footage = $result_product['prod_square_footage'];
        $get_prod_outdoor = $result_product['prod_outdoor'];
        $get_prod_guest_capacity = $result_product['prod_guest_capacity'];
        $get_prod_circuit_size = $result_product['prod_circuit_size'];
        $get_prod_private = $result_product['prod_private'];
        $get_prod_rack_space = $result_product['prod_rack_space'];
        $get_prod_wiring_paths = $result_product['prod_wiring_paths'];
        $get_prod_telco_room = $result_product['prod_telco_room'];

        $result_qq = json_decode($result['qualifying_questions'], true);
        $get_qq_ceiling_hight = $result_qq['qq_ceiling_hight'];
        $get_qq_int_wall = $result_qq['qq_int_wall'];
        $get_qq_communicate_other = $result_qq['qq_communicate_other'];
        $get_qq_residential = $result_qq['qq_residential'];
        $get_qq_atmospheric = $result_qq['qq_atmospheric'];
        $get_qq_ceiling_type = $result_qq['qq_ceiling_type'];
        $get_qq_ext_wall = $result_qq['qq_ext_wall'];
        $get_qq_customizable_ui = $result_qq['qq_customizable_ui'];
        $get_qq_warehouse = $result_qq['qq_warehouse'];
        $get_qq_IoT_devices = $result_qq['qq-IoT-devices'];
    }

    if (isset($_POST['create_location_submit'])) {
        $crm_id = $_POST['crm_id'];        
        $business_id = $_POST['business_id'];
        $location_name = $_POST['location_name'];
        $location_unique = $get_opt_code .$_POST['location_unique'];
        $contact_name = $_POST['contact'];
        $contact_email = $_POST['contact_email'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];

        /* Add location */
        $locationSql = "INSERT INTO `crm_exp_mno_locations`(`crm_id`,`location_name`,`location_unique`,`contact_name`,`contact_email`,`street`,`city`,`state`,`zip`,`is_enable`,`create_user`) 
                        VALUES($crm_id,'".$location_name."','".$location_unique."','".$contact_name."','".$contact_email."','".$street."','".$city."','".$state."','".$zip."',2,'".$user_name."')";
        $locationResult = $db->execDB($locationSql);

        $data = [
                    'id' => $location_unique,
                    'name' => $location_name,
                    'address' => [
                        'street' => $street,
                        'city' => $city,
                        'state' => $state,
                        'zip' => $zip
                    ],
                    'contact' =>[
                        'name' => $contact_name,
                        'email' => $contact_email
                    ]
                ];
        
        $idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
        $jsondata = json_encode($data);

        $response = $crm->createLocation($business_id,$jsondata,$idContAutoInc);
        if ($response['status'] == 'success') {
            $ex = $db->execDB("UPDATE crm_exp_mno_locations SET `is_enable` = 1 WHERE id = '$idContAutoInc'");
            $success_msg = "New Location ".$property_name." addition is successful";
            $db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create CRM Location',$idContAutoInc,'3001',$success_msg);
            $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$success_msg."</strong></div>";
        } else {
            $success_msg = "New Location ".$property_name." addition is failed";
            $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create CRM Location',0,'2009',$success_msg);
            $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
        }
        
    }

    if(isset($_POST['update_location_submit'])) {
        $crm_id = $_POST['crm_id']; 
        $location_name = $_POST['location_name'];
        $business_id = $_POST['business_id'];       
        $location_id = $_POST['location_id'];
        $location_unique = $_POST['location_unique'];
        $contact_name = $_POST['contact'];
        $contact_email = $_POST['contact_email'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];

         /* Update location */

        $locationSql = "UPDATE `crm_exp_mno_locations` SET 
                                                        `location_name` = '".$location_name."',
                                                        `contact_name` = '".$contact_name."',
                                                        `contact_email` = '".$contact_email."',
                                                        `street` = '".$street."',
                                                        `city` = '".$city."',
                                                        `state` = '".$state."',
                                                        `zip` = '".$zip."' 
                        WHERE id=".$location_id;
              
        $locationResult = $db->execDB($locationSql);

        $data = [
            'name' => $location_name,
            'address' => [
                'street' => $street,
                'city' => $city,
                'state' => $state,
                'zip' => $zip
            ],
            'contact' =>[
                'name' => $contact_name,
                'email' => $contact_email
            ]
        ];

        $jsondata = json_encode($data);

        $response = $crm->updateLocation($business_id,$jsondata,$location_unique);

        if ($response['status'] == 'success') {
            $success_msg = "Location has been updated successfully";
            $db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Update CRM Location',$location_id,'3001',$success_msg);
            $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$success_msg."</strong></div>";
        } else {
            $success_msg = "Location updated has been failed";
            $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Update CRM Location',$location_id,'2009',$success_msg);
            $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
        }
    }

    if (isset($_POST['create_crm_submit'])) {
        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret5']) {
            $business_name = $_POST['business_name'];
            $contact_name = $_POST['contact'];
            $contact_phone = $_POST['contact_Phone'];
            $contact_email = $_POST['contact_email'];
            $order_number = isset($_POST['order_number']) ? $_POST['order_number'] : '';
            $city = $_POST['city'];
            $zip = $_POST['zip'];
            $timezone = $_POST['time_zone'];
            $account_number = isset($_POST['account_number']) ? $_POST['account_number'] : '';
            $street = $_POST['street'];
            $state = $_POST['state'];
            $method = (isset($_POST['method'])) ? $_POST['method'] : 'all';
            $service_type = $_POST['service_type'];
            $wifi_unique_key = isset($_POST['wifi_unique']) ? $_POST['wifi_unique'] : '';
            $wifi_unique = $get_opt_code . $wifi_unique_key;

            $more_than_one_sites = $_POST['more_than_one_sites'];
            $guest_ssid = $_POST['guest_ssid'];
            $wifi_street = $_POST['wifi_street'];
            $wifi_state = $_POST['wifi_state'];
            $wifi_contact = $_POST['wifi_contact'];
            $wifi_email = $_POST['wifi_email'];
            $wifi_ins_time = $_POST['wifi_ins_time'];
            $wifi_site_name = $_POST['wifi_site_name'];
            $private_ssid = $_POST['private_ssid'];
            $wifi_city = $_POST['wifi_city'];
            $wifi_zip = $_POST['wifi_zip'];
            $wifi_phone = $_POST['wifi_phone'];
            $wifi_prop_type = $_POST['wifi_prop_type'];
            $wifi_ins_date = $_POST['wifi_ins_date'];
            $wifi_ins_start = $_POST['wifi_ins_start'];

            $wifi_information_arr = array(
                'guest_ssid' => $guest_ssid,
                'wifi_street' => $wifi_street,
                'private_ssid' => $private_ssid,
                'wifi_state' => $wifi_state,
                'wifi_contact' => $wifi_contact,
                'wifi_email' => $wifi_email,
                'wifi_ins_time' => $wifi_ins_time,
                'wifi_site_name' => $wifi_site_name,
                'wifi_city' => $wifi_city,
                'wifi_zip' => $wifi_zip,
                'wifi_phone' => $wifi_phone,
                'wifi_prop_type' => $wifi_prop_type,
                'wifi_ins_date' => $wifi_ins_date,
                'wifi_ins_start' => $wifi_ins_start
            );
            $wifi_information = json_encode($wifi_information_arr);

            $prod_order_type = $_POST['prod_order_type'];
            $prod_in_ap_quant = $_POST['prod_in_ap_quant'];
            $prod_content_filter = $_POST['prod_content_filter'];
            $prod_circuit_type = $_POST['prod_circuit_type'];
            $prod_guest = $_POST['prod_guest'];
            $prod_telco = $_POST['prod_telco'];
            $prod_cabling = $_POST['prod_cabling'];
            $prod_flow_plan = $_POST['prod_flow_plan'];
            $prod_cover_area = $_POST['prod_cover_area'];
            $prod_square_footage = $_POST['prod_square_footage'];
            $prod_outdoor = $_POST['prod_outdoor'];
            $prod_guest_capacity = $_POST['prod_guest_capacity'];
            $prod_circuit_size = $_POST['prod_circuit_size'];
            $prod_private = $_POST['prod_private'];
            $prod_rack_space = $_POST['prod_rack_space'];
            $prod_wiring_paths = $_POST['prod_wiring_paths'];
            $prod_telco_room = $_POST['prod-telco-room'];

            $product_information_arr = array(
                'prod_order_type' => $prod_order_type,
                'prod_in_ap_quant' => $prod_in_ap_quant,
                'prod_content_filter' => $prod_content_filter,
                'prod_circuit_type' => $prod_circuit_type,
                'prod_guest' => $prod_guest,
                'prod_telco' => $prod_telco,
                'prod_cabling' => $prod_cabling,
                'prod_flow_plan' => $prod_flow_plan,
                'prod_cover_area' => $prod_cover_area,
                'prod_square_footage' => $prod_square_footage,
                'prod_outdoor' => $prod_outdoor,
                'prod_guest_capacity' => $prod_guest_capacity,
                'prod_circuit_size' => $prod_circuit_size,
                'prod_private' => $prod_private,
                'prod_rack_space' => $prod_rack_space,
                'prod_wiring_paths' => $prod_wiring_paths,
                'prod_telco_room' => $prod_telco_room
            );
            $product_information = json_encode($product_information_arr);

            $qq_ceiling_hight = $_POST['qq_ceiling_hight'];
            $qq_int_wall = $_POST['qq_int_wall'];
            $qq_communicate_other = $_POST['qq_communicate_other'];
            $qq_residential = $_POST['qq_residential'];
            $qq_atmospheric = $_POST['qq_atmospheric'];
            $qq_ceiling_type = $_POST['qq_ceiling_type'];
            $qq_ext_wall = $_POST['qq_ext_wall'];
            $qq_customizable_ui = $_POST['qq_customizable_ui'];
            $qq_warehouse = $_POST['qq_warehouse'];
            $qq_IoT_devices = $_POST['qq-IoT-devices'];

            $qualifying_questions_arr = array(
                'qq_ceiling_hight' => $qq_ceiling_hight,
                'qq_int_wall' => $qq_int_wall,
                'qq_communicate_other' => $qq_communicate_other,
                'qq_residential' => $qq_residential,
                'qq_atmospheric' => $qq_atmospheric,
                'qq_ceiling_type' => $qq_ceiling_type,
                'qq_ext_wall' => $qq_ext_wall,
                'qq_customizable_ui' => $qq_customizable_ui,
                'qq_warehouse' => $qq_warehouse,
                'qq_IoT_devices' => $qq_IoT_devices
            );
            $qualifying_questions = json_encode($qualifying_questions_arr);

            $query = "INSERT INTO `exp_crm`
                (`service_type`,
                `business_name`,
                 `contact_name`,
                 `contact_number`,
                 `contact_email`,
                 `account_number`,
                 `order_number`,
                 `street`,
                 `city`,
                 `state`,
                 `zip`,
                 `timezone`,
                 `wifi_information`,
                 `property_id`,
                 `product_information`,
                 `qualifying_questions`,
                 `mno_id`,
                 `status`,
                 `create_user`,
                 `create_date`,
                 `last_update`) VALUES (
                 '$service_type',
                 '$business_name',
                 '$contact_name',
                 '$contact_phone',
                 '$contact_email',
                 '$account_number',
                 '$order_number',
                 '$street',
                 '$city',
                 '$state',
                 '$zip',
                 '$timezone',
                 '$wifi_information',
                 '$wifi_unique',
                 '$product_information',
                 '$qualifying_questions',
                 '$user_distributor',
                 'Pending',
                 '$user_name',
                 NOW(),
                 NOW()
                )";

            $ex = $db->execDB($query);

            if ($ex === true) {
                $idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
                $result = $db->select1DB("SELECT * FROM exp_crm WHERE id = '$idContAutoInc'");
                $mno_id = $result['mno_id'];
                if ($method == 'simple') {
                    $data = [
                        'name' => $result['business_name'],
                        'contact' => [
                            'name' => $result['contact_name'],
                            'email' => $result['contact_email'],
                            'voice' => $result['contact_number']
                        ],
                        'locations' => [
                            [
                                'id' => $result['property_id'],
                                'name' => $result['contact_name'],
                                'address' => [
                                    'street' => $result['street'],
                                    'city' => $result['city'],
                                    'state' => $result['state'],
                                    'zip' => $result['zip']
                                ],
                                'timeZone'=> $timezone
                            ]
                        ]
                    ];
                } else {
                    $data = [
                        'name' => $result['business_name'],
                        'contact' => [
                            'name' => $result['contact_name'],
                            'email' => $result['contact_email'],
                            'voice' => $result['contact_number']
                        ],
                        'locations' => [
                            [
                                'id' => $result['property_id'],
                                'name' => $result['contact_name'],
                                'address' => [
                                    'street' => $result['street'],
                                    'city' => $result['city'],
                                    'state' => $result['state'],
                                    'zip' => $result['zip']
                                ],
                                'timeZone'=> $timezone
                            ]
                        ],
                        "operator-code" => "FRT",
                        "sub-operator" => "",
                        "service-type" => $result['service_type'],
                        "env" => "hosted"
                    ];
                }


                /* Add location */
                $locationSql = "INSERT INTO `crm_exp_mno_locations`(`crm_id`,`property_id`,`property_name`,`location_unique`,`contact_name`,`contact_email`,`street`,`city`,`state`,`zip`,`is_enable`,`create_user`) 
                                VALUES($idContAutoInc,'".$wifi_unique."','".$business_name."','".$property_id."','".$contact_name."','".$contact_email."','".$street."','".$city."','".$state."','".$zip."',2,'".$user_name."')";
                $locationResult = $db->execDB($locationSql);
                $idLocationAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");

                $ex = $db->execDB("UPDATE exp_crm SET `status` = 'Processing' WHERE id = '$idContAutoInc'");

                $jsondata = json_encode($data);
                $response = $crm->createParent($jsondata,$idContAutoInc);

                if ($response['status'] == 'success') {
                    $businesId = $response['data']['id'];
                    $ex1 = $db->execDB("UPDATE exp_crm SET `business_id`='".$businesId."',`status` = 'Completed' WHERE id = '$idContAutoInc'");
                    $ex2 = $db->execDB("UPDATE crm_exp_mno_locations SET `business_id`='".$businesId."', `is_enable` = 1 WHERE id = '$idLocationAutoInc'");
                    $success_msg = $message_functions->showNameMessage('venue_add_success', $business_name);
                    $db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create CRM property',$idContAutoInc,'3001',$success_msg);
                    $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>CRM Property creation is successful</strong></div>";
                } else {
                    $ex = $db->execDB("UPDATE exp_crm SET `status` = 'Failed' WHERE id = '$idContAutoInc'");
                    $success_msg = $message_functions->showNameMessage('venue_add_failed', $business_name, '2009');
                    $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create CRM property',$idContAutoInc,'2009',$success_msg);
                    $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                }
            } else {
                syslog(LOG_NOTICE,'account create failed - insert to exp_crm failed');
                $success_msg = $message_functions->showNameMessage('venue_add_failed', $business_name, '2009');
                $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create CRM property',0,'2009',$success_msg);
                $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
            }
        }
    }

    /* Remove a location */
    if (isset($_GET['remove_location'])) {
        $id = $_GET['id'];
        $token = $_GET['token'];
        $businessId = $_GET['business_id'];
        $locationId = $_GET['location_id'];
        $location_unique = $_GET['location_unique'];

        $response = $crm->deleteLocation($businessId, $location_unique);
    
        if($response == 200 || $response == 404) {
            $delete = $db->execDB("DELETE FROM crm_exp_mno_locations WHERE id = '$locationId'");
            
            if ($delete === true) {
                $success_msg = "Location has been successfully removed";
                $db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Delete CRM Location',$locationId,'3001',$success_msg);
                $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>CRM Property creation is successful</strong></div>";
            } else {                    
                $success_msg = "CRM Location deleting is failed.";
                $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Delete CRM Location',$locationId,'2009',$success_msg);
                $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
            }
        } else {
            $success_msg = "CRM Location deleting is failed.";
            $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Delete CRM Location',$locationId,'2009',$success_msg);
            $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
        }
        header('Location: crm?t=crm_view&token='.$token.'&edit&id='.$id);
    }

    /* Remove a property */
    if (isset($_GET['remove_id'])) {
        if ($_GET['token'] == $_SESSION['FORM_SECRET']) { 
            $remove_id = $_GET['remove_id'];
            $businessId = 0;
            $property_details = $CommonFunctions->getPropertyDetails($remove_id,'business_id');
            // var_dump($property_details);
            if(!empty($property_details['data'])) {
                $businessId = $property_details['data'][0]['business_id'];
            }
 
            $response = $crm->deleteParent($businessId);
    
            if($response == 200) {   
                $delete = $db->execDB("DELETE FROM exp_crm WHERE id='$remove_id'");
                if ($delete === true) {
                    $success_msg = "CRM Property is deleted successfully.";
                    $db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Delete CRM Property',$remove_id,'3001',$success_msg);
                    //delete form user
                    $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$success_msg ."</strong></div>";
                } else {                    
                    $success_msg = "CRM Property deleting is failed.";
                    $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Delete CRM Property',$remove_id,'2009',$success_msg);
                    $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$success_msg ."</strong></div>";
                }
            } else {
                $success_msg = "CRM Property deleting is failed. ".$response["data"]["message"];
                $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Delete CRM Property',$remove_id,'2009',$success_msg);
                $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
            }
        }
    }

    foreach ($modules[$user_type][$script] as $value) {
        $submit_form = 'modules/' . $value['submit'] . '.php';
        if (file_exists($submit_form)) {
            //require_once 'modules/' . $modules['tab_menu']['submit'] . '.php';
            require_once $submit_form;
        }
    }

    // TAB Organization
    if (isset($_GET['t'])) {
        $variable_tab = 'tab_' . $_GET['t'];
        $$variable_tab = 'set';
    }

    //Form Refreshing avoid secret key/////
    $secret = md5(uniqid(rand(), true));
    $_SESSION['FORM_SECRET'] = $secret;


?>
<style>
    #crm-create-progress{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(102 102 102);
        opacity: 0.75;
        z-index: 100;
        cursor: progress;
        display: none;
    }
    .pop-up{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: none;
        z-index: 122;
    }
    .pop-up.show{
        display: block;
    }
    .pop-up-bg{
        background-color: rgba(76, 78, 100, 0.5);
        position: fixed;
        width: 100%;
        top: 0;
        bottom: 0;
        z-index: -1;
    }
    .pop-up-main{
        height: 100%;
    overflow: auto;
    text-align: center;
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    }
    .pop-up-content{
        background: #fff;
    margin: auto;
    box-shadow: rgb(76 78 100 / 20%) 0px 6px 6px -3px;
    border-radius: 10px;
    padding: 40px;
    max-width: 800px;
    width: 100%;
    box-sizing: border-box;
    }
    .pop-up-content .form-double{
        display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
        -ms-flex-flow: row wrap;
            flex-flow: row wrap;
    -webkit-box-pack: justify;
        -ms-flex-pack: justify;
            justify-content: space-between;
    }
    .pop-up-content .form-double .control-group{
        width: 50%;
        text-align: left;
    }
    .pop-up-content .form-double .control-group input{
        width: 90% !important;
    }
    .pop-up-content form{
        margin-bottom: 0;
    }
    .pop-up-content form .actions{
        text-align: right;
    margin-top: 20px;
    }
    .pop-up-content form .actions button{
        margin-left: 5px;
    }.control-group.mask .controls div{
        position: relative;
        overflow: hidden;
    }
    .control-group.mask span{
        position: absolute;
        left: 0;
        height: 100%;
        background: #e4e4e4;
        border-radius: 10px;
        padding: 8px;
        box-sizing: border-box;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .control-group.mask input{
        /* padding-left: 50px; */
    }

</style>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget ">
                            <div class="widget-content">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="create_orders" data-bs-toggle="tab" data-bs-target="#create_orders-tab-pane" type="button" role="tab" aria-controls="create_orders" aria-selected="true">Create Orders</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                    <?php

                                        if (isset($_SESSION['msg20'])) {
                                            echo $_SESSION['msg20'];
                                            unset($_SESSION['msg20']);
                                        }
                                        if (isset($_SESSION['msg5'])) {
                                            echo $_SESSION['msg5'];
                                            unset($_SESSION['msg5']);
                                        }

                                    if($user_type == 'ADMIN' || $user_type == 'SADMIN') {
                                    ?>
                                    <div class="border card my-4">
                                        <div class="border-bottom card-header p-4">
                                            <div class="g-3 row">
                                                <h4>Select Operator</h4>
                                            </div>
                                        </div>
                                        <form class="row g-3 p-4" method="post">
                                            <div class="col-md-6">
                                                <label for="inputState" class="form-label">Operator</label>
                                                <select id="selected_operator" name="selected_operator" class="form-select">
                                                    <option value='0'>None</option>
                                                    <?php 
                                                        foreach($operators['data'] AS $operator){
                                                    ?>
                                                        <option value='<?=$operator['user_distributor']?>' <?=$selected_operator == $operator['user_distributor'] ? 'selected' : '' ?>><?=$operator['full_name']?></option>
                                                    <?php    
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" id="load_operator" name="load_operator" class="btn btn-primary">Load</button>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                    }
                                        //if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE' || $user_type == 'SUPPORT' || $user_type == 'SALES'){
                                        foreach ($modules[$user_type][$script] as $value) {
                                            //echo 'modules/'.$value['module'].'.php';
                                            include_once 'modules/' . $value['module'] . '.php';
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                    <!-- /span8 -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /main-inner -->
    </div>
    
    
    <script type="text/javascript" src="js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator_new.js?v=1"></script>

    <script type="text/javascript">
   
        $(document).ready(function() {
            $('.pop-up .actions button:nth-child(1)').click(function (e) {                 
                $('#locationForm').children('input').val('');
                e.preventDefault();                
                $('.pop-up').removeClass('show');
                $('body').css('overflow','auto');
            });
            $('.pop-up-open').click(function (e) { 
                e.preventDefault();
                $("#locationForm #wifi_unique").attr("value","<?=$wifi_unique?>");
                $("#locationForm #business_id").attr("value","<?=$get_business_id?>");
                $('.pop-up').addClass('show');
                $('body').css('overflow','hidden');
            });

            $('#create_location_submit').on('click', function(e){                
                $("#overlay").css("display","block");
                $('#locationForm').bootstrapValidator({
                    framework: 'bootstrap',
                    excluded: [':disabled', function($field, validator) {
                        return (!$field.is(':visible') || $field.is(':hidden'));
                    }],
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        location_unique: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        location_name: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        contact: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        contact_email: {
                            validators: {
                                <?php echo $db->validateField('email'); ?>
                            }
                        },
                        street: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        city: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        zip: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        state: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        }
                    }
                }).on('error.validator.bv', function(e, data) {
                    $("#overlay").css("display","none");
                }); 
            });

            // $('#update_location_submit').on('click',function(e){
            //     alert('fff');
            //     $("#overlay").css("display","block");
            //     $('#locationForm').bootstrapValidator({
            //         framework: 'bootstrap',
            //         excluded: [':disabled', function($field, validator) {
            //             return (!$field.is(':visible') || $field.is(':hidden'));
            //         }],
            //         feedbackIcons: {
            //             valid: 'glyphicon glyphicon-ok',
            //             invalid: 'glyphicon glyphicon-remove',
            //             validating: 'glyphicon glyphicon-refresh'
            //         },
            //         fields: {
            //             location_name: {
            //                 validators: {
            //                     < ?php echo $db->validateField('notEmpty'); ?>
            //                 }
            //             },
            //             contact: {
            //                 validators: {
            //                     < ?php echo $db->validateField('notEmpty'); ?>
            //                 }
            //             },
            //             contact_email: {
            //                 validators: {
            //                     < ?php echo $db->validateField('email'); ?>
            //                 }
            //             },
            //             street: {
            //                 validators: {
            //                     < ?php echo $db->validateField('notEmpty'); ?>
            //                 }
            //             },
            //             city: {
            //                 validators: {
            //                     < ?php echo $db->validateField('notEmpty'); ?>
            //                 }
            //             },
            //             zip: {
            //                 validators: {
            //                     < ?php echo $db->validateField('notEmpty'); ?>
            //                 }
            //             },
            //             state: {
            //                 validators: {
            //                     < ?php echo $db->validateField('notEmpty'); ?>
            //                 }
            //             }
            //         }
            //     }).on('error.validator.bv', function(e, data) {
            //         $("#overlay").css("display","none");
            //     }); 
            // });

            $('#crm_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: [':disabled', function($field, validator) {
                    return (!$field.is(':visible') || $field.is(':hidden'));
                }],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    wifi_unique: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    business_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    contact: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    contact_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>
                        }
                    },
                    street: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    city: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    zip: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    state: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    service_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    time_zone: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    contact_Phone: {
                        validators: {
                            <?php echo $db->validateField('mobile'); ?>
                        }
                    },
                    wifi_site_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    wifi_street: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    wifi_city: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    wifi_site_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    wifi_state: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    wifi_zip: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    wifi_contact: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    wifi_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>
                        }
                    }

                }
            }).on('error.validator.bv', function(e, data) {
                $("#overlay").css("display","none");
            });

        });
    </script>
    <?php


    include 'footer.php';

    ?>

    <!--Alert message-->
    <link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />

    <!--tool tip css-->
    <link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
    <link rel="stylesheet" type="text/css" href="css/tooltipster.css" />


    <!--jquery code for upload browse button-->
    <script src="js/jquery.filestyle.js" type="text/javascript" charset="utf-8">
    </script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
    <script src="js/select2-3.5.2/select2.min.js"></script>