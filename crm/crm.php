<?php ob_start(); ?>
<!DOCTYPE html>

<html lang="en">

<?php
session_start();
include 'header_top.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

/* No cache*/
//header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();
require_once 'classes/systemPackageClass.php';
$package_functions = new package_functions();

require_once './classes/CommonFunctions.php';
$CommonFunctions = new CommonFunctions();
/*Encryption script*/
include_once 'classes/cryptojs-aes.php';
require_once dirname(__FILE__) . '/models/clientUserModel.php';
// echo 'Username= ';
// var_dump($_SESSION['user_id']);
$client_model = new clientUserModel();
$client_data = $client_model->getClient($_SESSION['user_id'],'user_id');
$api_id = $client_data[0]['api_profile'];
$api_details = $CommonFunctions->getApiDetails($api_id);

?>

<head>

    <meta charset="utf-8">
    <title>CRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css?v=1" rel="stylesheet">
    <link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="js/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="css/select2-bootstrap/select2-bootstrap.css" />
    <link href="css/bootstrap-colorpicker.css?v=19" rel="stylesheet">
    <link href="plugins/img_upload/assets/css/croppic.css" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap-toggle.min.css" />
    <link rel="stylesheet" href="css/tablesaw.css?v1.2">

    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script src="js/locationpicker.jquery.js"></script>

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-toggle.min.js"></script>


    <!--Ajax File Uploading Function-->


    <!--table colimn show hide-->
    <script type="text/javascript" src="js/tablesawNew.js"></script>
    <!--Encryption -->
    <script type="text/javascript" src="js/aes.js"></script>
    <script type="text/javascript" src="js/aes-json-format.js"></script>

    <link rel="stylesheet" href="css/bootstrapValidator.css" />


    <?php
    $data_secret = $db->setVal('data_secret', 'ADMIN');
    include 'header.php';

    require_once 'layout/' . $camp_layout . '/config.php';
    $edit = false;
    $opt_q = $package_functions->getSectionType("OPT_CODE", $system_package);
    $get_opt_code = (isset($opt_q))?$opt_q:'FRT';//$db->getValueAsf("SELECT api_prefix as f FROM exp_mno WHERE mno_id = '$user_distributor'");

    $priority_zone_array = array(
                                "America/New_York",
                                "America/Chicago",
                                "America/Denver",
                                "America/Los_Angeles",
                                "America/Anchorage",
                                "Pacific/Honolulu",
                            );

    if(isset($_GET['edit'])){
        $edit = true;
        $id = $_GET['id'];
        $result = $db->select1DB("SELECT * FROM exp_crm WHERE id = '$id'");
             $get_service_type = $result['service_type'];
             $get_business_name = $result['business_name'];
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
             $wifi_unique = $result['property_id'];
             $get_wifi_unique = str_replace($get_opt_code,"",$wifi_unique);

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

    if(isset($_POST['create_crm_submit'])){
        if($_SESSION['FORM_SECRET'] == $_POST['form_secret5']) {
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
             $method = (isset($_POST['method']))?$_POST['method']:'all';
             $service_type = $_POST['service_type'];
             $wifi_unique_key = isset($_POST['wifi_unique']) ? $_POST['wifi_unique'] : '';
             $wifi_unique = $get_opt_code.$wifi_unique_key;

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

             $wifi_information_arr = array('guest_ssid' => $guest_ssid,
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
                                             'wifi_ins_start' => $wifi_ins_start);
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

             $product_information_arr = array('prod_order_type' => $prod_order_type,
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
                                             'prod_telco_room' => $prod_telco_room);
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

             $qualifying_questions_arr = array('qq_ceiling_hight' => $qq_ceiling_hight,
                                           'qq_int_wall' => $qq_int_wall,
                                           'qq_communicate_other' => $qq_communicate_other,
                                             'qq_residential' => $qq_residential,
                                             'qq_atmospheric' => $qq_atmospheric,
                                             'qq_ceiling_type' => $qq_ceiling_type,
                                             'qq_ext_wall' => $qq_ext_wall,
                                             'qq_customizable_ui' => $qq_customizable_ui,
                                             'qq_warehouse' => $qq_warehouse,
                                             'qq_IoT_devices' => $qq_IoT_devices);
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
                $idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");

                $exec_cmd = 'php -f'.dirname(__FILE__).'/src/CRM/CreateParent.php '.$idContAutoInc.' '.$api_id.' '.$method.' > /dev/null 2>&1 & echo $!; ';
                //$exec_cmd = "php -v";
                $pid = exec($exec_cmd , $output);
            var_dump($output);

            var_dump($exec_cmd);

            if($ex===true){
                $success_msg = $message_functions->showNameMessage('venue_add_success', $business_name);
                $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>CRM Property creation is successful</strong></div>";
            }else{
                $success_msg = $message_functions->showNameMessage('venue_add_failed', $business_name, '2009');
                $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
            }
        }
    }

    // if(isset($_POST['update_crm_submit'])){
    //     // echo 'update';die;
    //     if($_SESSION['FORM_SECRET'] == $_POST['form_secret5']) {
    //          $business_name = $_POST['business_name'];
    //          $contact_name = $_POST['contact'];
    //          $contact_phone = $_POST['contact_Phone'];
    //          $contact_email = $_POST['contact_email'];
    //          $order_number = isset($_POST['order_number']) ? $_POST['order_number'] : '';
    //          $city = $_POST['city'];
    //          $zip = $_POST['zip'];
    //          $timezone = $_POST['time_zone'];
    //          $account_number = isset($_POST['account_number']) ? $_POST['account_number'] : '';
    //          $street = $_POST['street'];
    //          $state = $_POST['state'];
    //          $service_type = $_POST['service_type'];
    //          $wifi_unique_key = isset($_POST['wifi_unique']) ? $_POST['wifi_unique'] : '';
    //          $wifi_unique = $get_opt_code.$wifi_unique_key;

    //          $more_than_one_sites = $_POST['more_than_one_sites'];
    //          $guest_ssid = $_POST['guest_ssid'];
    //          $wifi_street = $_POST['wifi_street'];
    //          $wifi_state = $_POST['wifi_state'];
    //          $wifi_contact = $_POST['wifi_contact'];
    //          $wifi_email = $_POST['wifi_email'];
    //          $wifi_ins_time = $_POST['wifi_ins_time'];
    //          $wifi_site_name = $_POST['wifi_site_name'];
    //          $private_ssid = $_POST['private_ssid'];
    //          $wifi_city = $_POST['wifi_city'];
    //          $wifi_zip = $_POST['wifi_zip'];
    //          $wifi_phone = $_POST['wifi_phone'];
    //          $wifi_prop_type = $_POST['wifi_prop_type'];
    //          $wifi_ins_date = $_POST['wifi_ins_date'];
    //          $wifi_ins_start = $_POST['wifi_ins_start'];

    //          $wifi_information_arr = array('guest_ssid' => $guest_ssid,
    //                                        'wifi_street' => $wifi_street,
    //                                        'private_ssid' => $private_ssid,
    //                                          'wifi_state' => $wifi_state,
    //                                          'wifi_contact' => $wifi_contact,
    //                                          'wifi_email' => $wifi_email,
    //                                          'wifi_ins_time' => $wifi_ins_time,
    //                                          'wifi_site_name' => $wifi_site_name,
    //                                          'wifi_city' => $wifi_city,
    //                                          'wifi_zip' => $wifi_zip,
    //                                          'wifi_phone' => $wifi_phone,
    //                                          'wifi_prop_type' => $wifi_prop_type,
    //                                          'wifi_ins_date' => $wifi_ins_date,
    //                                          'wifi_ins_start' => $wifi_ins_start);
    //          $wifi_information = json_encode($wifi_information_arr);

    //          $prod_order_type = $_POST['prod_order_type'];
    //          $prod_in_ap_quant = $_POST['prod_in_ap_quant'];
    //          $prod_content_filter = $_POST['prod_content_filter'];
    //          $prod_circuit_type = $_POST['prod_circuit_type'];
    //          $prod_guest = $_POST['prod_guest'];
    //          $prod_telco = $_POST['prod_telco'];
    //          $prod_cabling = $_POST['prod_cabling'];
    //          $prod_flow_plan = $_POST['prod_flow_plan'];
    //          $prod_cover_area = $_POST['prod_cover_area'];
    //          $prod_square_footage = $_POST['prod_square_footage'];
    //          $prod_outdoor = $_POST['prod_outdoor'];
    //          $prod_guest_capacity = $_POST['prod_guest_capacity'];
    //          $prod_circuit_size = $_POST['prod_circuit_size'];
    //          $prod_private = $_POST['prod_private'];
    //          $prod_rack_space = $_POST['prod_rack_space'];
    //          $prod_wiring_paths = $_POST['prod_wiring_paths'];
    //          $prod_telco_room = $_POST['prod-telco-room'];

    //          $product_information_arr = array('prod_order_type' => $prod_order_type,
    //                                        'prod_in_ap_quant' => $prod_in_ap_quant,
    //                                        'prod_content_filter' => $prod_content_filter,
    //                                          'prod_circuit_type' => $prod_circuit_type,
    //                                          'prod_guest' => $prod_guest,
    //                                          'prod_telco' => $prod_telco,
    //                                          'prod_cabling' => $prod_cabling,
    //                                          'prod_flow_plan' => $prod_flow_plan,
    //                                          'prod_cover_area' => $prod_cover_area,
    //                                          'prod_square_footage' => $prod_square_footage,
    //                                          'prod_outdoor' => $prod_outdoor,
    //                                          'prod_guest_capacity' => $prod_guest_capacity,
    //                                          'prod_circuit_size' => $prod_circuit_size,
    //                                          'prod_private' => $prod_private,
    //                                          'prod_rack_space' => $prod_rack_space,
    //                                          'prod_wiring_paths' => $prod_wiring_paths,
    //                                          'prod_telco_room' => $prod_telco_room);
    //          $product_information = json_encode($product_information_arr);

    //          $qq_ceiling_hight = $_POST['qq_ceiling_hight'];
    //          $qq_int_wall = $_POST['qq_int_wall'];
    //          $qq_communicate_other = $_POST['qq_communicate_other'];
    //          $qq_residential = $_POST['qq_residential'];
    //          $qq_atmospheric = $_POST['qq_atmospheric'];
    //          $qq_ceiling_type = $_POST['qq_ceiling_type'];
    //          $qq_ext_wall = $_POST['qq_ext_wall'];
    //          $qq_customizable_ui = $_POST['qq_customizable_ui'];
    //          $qq_warehouse = $_POST['qq_warehouse'];
    //          $qq_IoT_devices = $_POST['qq-IoT-devices']; 

    //          $qualifying_questions_arr = array('qq_ceiling_hight' => $qq_ceiling_hight,
    //                                        'qq_int_wall' => $qq_int_wall,
    //                                        'qq_communicate_other' => $qq_communicate_other,
    //                                          'qq_residential' => $qq_residential,
    //                                          'qq_atmospheric' => $qq_atmospheric,
    //                                          'qq_ceiling_type' => $qq_ceiling_type,
    //                                          'qq_ext_wall' => $qq_ext_wall,
    //                                          'qq_customizable_ui' => $qq_customizable_ui,
    //                                          'qq_warehouse' => $qq_warehouse,
    //                                          'qq_IoT_devices' => $qq_IoT_devices);
    //          $qualifying_questions = json_encode($qualifying_questions_arr);

    //          $query = "UPDATE `exp_crm` SET 
    //                     `service_type` = '$service_type',
    //                     `business_name` = '$business_name',
    //                     `contact_name` = '$contact_name',
    //                     `contact_number` = '$contact_phone',
    //                     `contact_email` = '$contact_email',
    //                     `account_number` = '$account_number',
    //                     `order_number` = '$order_number',
    //                     `street` = '$street',
    //                     `city` = '$city',
    //                     `state` = '$state',
    //                     `zip` = '$zip',
    //                     `timezone` = '$timezone',
    //                     `wifi_information` = '$wifi_information',
    //                     `property_id` = '$wifi_unique',
    //                     `product_information` = '$product_information',
    //                     `qualifying_questions` = '$qualifying_questions',
    //                     `mno_id` = '$user_distributor',
    //                     `last_update` = NOW()
    //                     ";

    //             $ex = $db->execDB($query);
    //             // $idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");

    //             // $exec_cmd = 'php -f'.dirname(__FILE__).'/src/CRM/CreateParent.php '.$idContAutoInc.' > /dev/null 2>&1 & echo $!; ';
    //             // $pid = exec($exec_cmd , $output);

    //         if($ex===true){
    //             $success_msg = $message_functions->showNameMessage('venue_add_success', $business_name);
    //             $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>CRM Property creation is successful</strong></div>";
    //         }else{
    //             $success_msg = $message_functions->showNameMessage('venue_add_failed', $business_name, '2009');
    //             $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
    //         }
    //     }
    // }

    if (isset($_GET['edit'])) {
        if ($_GET['token'] == $_SESSION['FORM_SECRET']) {
            $id = $_GET['id'];

            $q = "SELECT property_details,status FROM exp_provisioning_properties WHERE mno_id='$user_distributor' AND id='$id' AND status<>'4'";

            $data = $db->select1DB($q);
            //print_r($data);
            if(count($data)>0){
                $edit = true;
                //$_GET['t']='provision_create';
                $prop_details = json_decode($data['property_details'],true);
                $parent_properties_count = count($prop_details['property']);
                $prop_details_new = $prop_details['property'][0];
                $prop_service_type = $prop_details['location_info'][0]['service_type'];
                /*Service type options*/
//                $q2 = "SELECT `setting` FROM exp_provisioning_setting WHERE id='$prop_service_type' AND `mno_id`='$user_distributor'";
//                $service_details = json_decode($db->select1DB($q2)['setting'],true);
                //print_r($service_details);
                $edit_acc_state = $data['status'];

            }
        }
    }

    if(isset($_GET['remove_id'])){

        if ($_GET['token'] == $_SESSION['FORM_SECRET']) {
            $remove_id = $_GET['remove_id'];
            $delete = $db->execDB("DELETE FROM exp_crm WHERE id='$remove_id'");
            if($delete===true){
                //delete form user
                
                $_SESSION['msg20']='<div class="alert alert-success"> <strong>CRM Property is deleted successfully.</strong></div>';
            }else{
                $_SESSION['msg20']='<div class="alert alert-danger"> <strong>CRM Property deleting is failed.</strong></div>';
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
    <div class="main">
        <div class="custom-tabs"></div>
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <br class="hideBr"><br class="hideBr">
                        <div class="widget ">


                            <div class="widget-header">

                                <h3>View and Manage Properties</h3>


                            </div><!-- /widget-header -->


                            <div class="widget-content">
                                <div class="tabbable">
                                    <?php require_once 'modules/' . $modules['tab_menu']['module'] . '.php'; ?>
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
                                        //if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE' || $user_type == 'SUPPORT' || $user_type == 'SALES'){
                                        foreach ($modules[$user_type][$script] as $value) {
                                            //echo 'modules/'.$value['module'].'.php';
                                            include_once 'modules/' . $value['module'] . '.php';
                                        }
                                        //}
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
            $('#crm_form').bootstrapValidator({

                framework: 'bootstrap',
                excluded: [':disabled',function($field, validator) {
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
            });
            });
    </script>
        <?php


        include 'footer.php';

        ?>

            <!--Alert message-->
            <link rel = "stylesheet"
        href = "css/jquery-ui-alert.css"
        type = "text/css" />

            <!--tool tip css-->
            <link rel = "stylesheet"
        type = "text/css"
        href = "css/tooltipster-shadow.css" />
            <link rel = "stylesheet"
        type = "text/css"
        href = "css/tooltipster.css" />


            <!--jquery code for upload browse button-->
        <script src = "js/jquery.filestyle.js"
        type = "text/javascript"
        charset = "utf-8" >
    </script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
    <script src="js/select2-3.5.2/select2.min.js"></script>