<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once '../../db/dbTasks.php';
require_once '../../classes/systemPackageClass.php';
require_once '../../classes/CommonFunctions.php';
$db = new db_functions();
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);
$mno_id = $db->getValueAsf("SELECT user_distributor AS f FROM admin_users Where user_name='$_SESSION[user_name]'");

$module_array = array('provision');

if(!$package_functions->ajaxAccess($module_array,$system_package)){
    http_response_code(401);
    return false;
}

if(!isset($_GET['action']))
{http_response_code(404);echo json_encode(['Action required']);exit();}
$action = $_GET['action'];
// /*Encryption script*/
// include_once '../../classes/cryptojs-aes.php';

// $data_secret = $db->setVal('data_secret','ADMIN');

$main_key = $_POST;
//$main_key = cryptoJsAesEncrypt($data_secret,'asdfasdf');
// $request_data = cryptoJsAesDecrypt($data_secret, '{"ct":"jECRB6lplEF8tpIHoiGRwqy6SIIPP8QCqzuadtSnd0Y=","iv":"88d9a4ec05afe660e0aeea0dbc7d119e","s":"7bae7401b96498ca"}');
// if(strlen($request_data)>0){}else{echo'==';exit();}

function getPropertyDetails($id,$db,$mno_id){
    if(empty($id)){
        echo json_encode(['id not found']);
        http_response_code('404');
        exit();
    }

    $property_details = $db->getValueAsf("SELECT property_details AS f FROM exp_provisioning_properties WHERE id='$id' AND mno_id='$mno_id'"); 

    if(empty($property_details)){
        echo json_encode(['id not found']);
        http_response_code('404');
        exit();
    }

    return json_decode($property_details,true);
}

function generateParentID($mno, $db, $iteration=0, $pre_id=null){

    $opt_code_q = "SELECT `api_prefix` AS f FROM `exp_mno` WHERE mno_id='$mno'";
    $opt_code=$db->getValueAsf($opt_code_q);

    if($iteration==0){//get users table auto INC
        $br = $db->select1DB("SHOW TABLE STATUS LIKE 'admin_users'");
        $auto_inc = $br['Auto_increment'];
    }else{
        $auto_inc = $pre_id;
        //exit();
    }

    $number = (int)$auto_inc+(int)$iteration;
    $business_id = substr($opt_code,0,3).str_pad($number,9,'0',STR_PAD_LEFT);

    //reserve business id
    $user_name = 'tpu'.$business_id.uniqid();
    $pass = CommonFunctions::randomPassword(8);
    $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$business_id')";
    $reserve_bus_id = $db->execDB($rbiq);

    if($reserve_bus_id!==true){
        if(strpos($reserve_bus_id,'Duplicate entry')>=0){
            return generateParentID($mno,$db,$iteration+1,$auto_inc);
            //return [false];
        }else {
            return [false];
        }
    }
    return [$business_id,$user_name];
}

function generateLocationID($mno, $db, $system_package, $pre_id=null){

    /*$opt_code_q = "SELECT `api_prefix` AS f FROM `exp_mno` WHERE mno_id='$mno'";
    $opt_code=$db->getValueAsf($opt_code_q);

    if($iteration==0){//get users table auto INC
        $br = $db->select1DB("SHOW TABLE STATUS LIKE 'admin_users'");
        $auto_inc = $br['Auto_increment'];
    }else{
        $auto_inc = $pre_id;
        //exit();
    }

    $number = (int)$auto_inc+(int)$iteration;
    $business_id = substr($opt_code,0,3).str_pad($number,9,'0',STR_PAD_LEFT);

    //reserve business id
    $user_name = 'tpu'.$business_id.uniqid();
    $pass = CommonFunctions::randomPassword(8);
    $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$business_id')";
    $reserve_bus_id = $db->execDB($rbiq);

    if($reserve_bus_id!==true){
        if(strpos($reserve_bus_id,'Duplicate entry')>=0){
            return generateParentID($mno,$db,$iteration+1,$auto_inc);
            //return [false];
        }else {
            return [false];
        }
    }*/
    require_once '../../src/API/functions.php';
    $isDynamic = package_functions::isDynamic($system_package);
    if($isDynamic){
        $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='DYNAMIC_MNO_001' AND config_type='api'");
    }else{
        $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='$system_package' AND config_type='api'");
    }

    $configFileArr = json_decode($getJson, true);
    $icom_pool_min = $configFileArr['icom_range_min'];
    $icom_pool_max = $configFileArr['icom_range_max'];
    if (strlen($icom_pool_min)<1) {
        $icom_pool_min = '100000000000';
        $icom_pool_max = '199999999999';
    }
    $icom_pool = array("min" => $icom_pool_min, "max" => $icom_pool_max);
    $parent_pref = $db->getValueAsf("SELECT `api_prefix` AS f FROM `exp_mno` WHERE mno_id='$user_distributor'");
    $get_icom = getRealm($icom_pool, $parent_pref, $db);
    $icomme_number = $get_icom['icom'];

    $user_name = 'tpu'.$icomme_number.uniqid();
    $pass = CommonFunctions::randomPassword(8);
    $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$icomme_number')";
    $reserve_bus_id = $db->execDB($rbiq);

    if (strlen($get_icom['error'])> 0) {
        return false;
    }else{
        return [$icomme_number,$user_name];
    }
    
}
$i = $_POST['num']-1;
if($action=='create_account_info'){
    $business_id = $_POST['business_id'];
    $business_name = $_POST['business_name'];
    $bis_admin_first_name = $_POST['bis_admin_first_name'];
    $bis_admin_last_name = $_POST['bis_admin_last_name'];
    $email = $_POST['email'];
    $verify_email=$_POST['verify_email'];

    $property_details = json_encode([
        "account_info"=>[
            "business_id"=>$business_id,
            "business_name"=>$business_name,
            "first_name"=>$bis_admin_first_name,
            "last_name"=>$bis_admin_last_name,
            "email"=>$email
        ]
        /*,
        "location_info"=>[],
        "network_info"=>[]*/
    ]);

    $q = "INSERT INTO exp_provisioning_properties (`mno_id`,`property_details`,`status`,`create_user`,`create_date`)
    VALUES('$mno_id','$property_details',1,'$_SESSION[user_name]',NOW())";

    //reserve business id
    $user_name = 'tpu'.$business_id.uniqid();
    $pass = CommonFunctions::randomPassword(8);
    $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$business_id')";
    $reserve_bus_id = $db->execDB($rbiq);

    if($reserve_bus_id===true){
        $create = $db->execDB($q);
    }else{
        echo json_encode(["status"=>"failed",'message'=>'Business ID already used']);
        exit();
    }
    if($create === true){
        echo json_encode(["status"=>"success","id"=>$db->insert_id()]);
    }else{
        $revers_q = "DELETE FROM admin_users WHERE user_name='$user_name' AND verification_number='$business_id'";
        $db->execDB($revers_q);
        echo json_encode(["status"=>"failed"]);
        exit();
    }

}
if($action=='get_location_info'){
    $id=$_POST['id'];
    $property_details = getPropertyDetails($id,$db,$mno_id);
    $location_info_arr = $property_details['property'][$i]['location_info'][0];
    $network_info_arr = $property_details['property'][$i]['network_info'];
    $location_info_arr['no_of_guest_ssid'] = $network_info_arr['Guest']['count'];
    $location_info_arr['no_of_pvt_ssid'] = $network_info_arr['Private']['count'];
    $location_info_arr['no_of_vt_ssid'] = $network_info_arr['VTenant']['count'];
    echo json_encode($location_info_arr);
        exit();

}
if($action=='location_info'){
    $id=$_POST['id'];


    $property_details = getPropertyDetails($id,$db,$mno_id);

    $service_type = $_POST['service_type'];
    $location_id = $_POST['location_id'];
    $location_name = $_POST['location_name'];
    $vt_location_id = $_POST['vt_location_id'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $city=$_POST['city'];
    $country=$_POST['country'];
    $state=$_POST['state'];
    $time_zone=$_POST['time_zone'];
    $zip_code=$_POST['zip_code'];

    //$property_details = json_decode($property_details,true);
    $existing_location_id = isset($property_details['property'][$i]['location_info'][0]['location_id'])?$property_details['property'][$i]['location_info'][0]['location_id']:'';
    $location_id_state = strlen($existing_location_id)==0?1:2;

    $old_vt_location = $property_details['property'][$i]['location_info'][0]['vt_location_id'];
    $existing_vt_location_id = (isset($old_vt_location) && strlen($old_vt_location)>0)?$old_vt_location:'';
    $vt_location_id_state = (strlen($existing_vt_location_id)==0 && strlen($vt_location_id)>0)?1:2;

     $property_details['property'][$i]['location_info'] = [
        [
            "service_type"=>$service_type,
            "location_id"=>$location_id,
            "vt_location_id"=>$vt_location_id,
            "location_name"=>$location_name,
            "phone_number"=>$phone_number,
            "address"=>$address,
            "city"=>$city,
            "country"=>$country,
            "state"=>$state,
            "time_zone"=>$time_zone,
            "zip_code"=>$zip_code
        ]];

    $property_details = json_encode($property_details);
    $q = "UPDATE exp_provisioning_properties SET`property_details` = '$property_details', `status`=IF(`status`=1,2,`status`) WHERE id='$id' AND mno_id='$mno_id'";

    //reserve location id
    if($location_id_state==1){
        $user_name = 'tpu'.$location_id.uniqid();
        $pass = CommonFunctions::randomPassword(8);
        $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$location_id')";
        $reserve_location_id = $db->execDB($rbiq);
    }else{
        $reserve_location_id = true;
    }
    //reserve vt location id
    if($vt_location_id_state==1){
        $tmp_dis = 'tpo'.$location_id;
        //$pass = CommonFunctions::randomPassword(8);
        $rbiq = "INSERT INTO `mdu_distributor_organizations` (`distributor_code`,`property_id`,`create_user`,`create_date`)
                VALUES('$tmp_dis','$vt_location_id','$_SESSION[user_name]',NOW())";
        $reserve_vt_location_id = $db->execDB($rbiq);
    }else{
        $reserve_vt_location_id = true;
    }

    if($reserve_location_id=== true && $reserve_vt_location_id===true){
        $update = $db->execDB($q);
    }else{
//        $user_name = 'tpu'.$existing_location_id.uniqid();
//        $pass = CommonFunctions::randomPassword(8);
//        $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$existing_location_id')";
//        $db->execDB($rbiq);
        $del_q1 = "DELETE FROM admin_users WHERE verification_number = '$location_id'";
        $del_q2 = "DELETE FROM mdu_distributor_organizations WHERE distributor_code = '$tmp_dis'";
        $db->execDB($del_q1);
        $db->execDB($del_q2);
        $message = "Location saving is failed";

        if(strpos($reserve_vt_location_id,'Duplicate entry')>=0){
            $message = 'Vtenant Location ID already used';
        }
        if(strpos($reserve_location_id,'Duplicate entry')>=0){
            $message = 'Location ID already used';
        }
        echo json_encode(['status'=>"error",'message'=>$message]);
        exit();
    }

    if($update === true){
        echo json_encode(['status'=>"success"]);
    }else{
        $revers_q = "DELETE FROM admin_users WHERE user_name='$user_name' AND verification_number='$location_id'";
        $db->execDB($revers_q);

        if(!empty($existing_location_id)){
            $user_name = 'tpu'.$existing_location_id.uniqid();
            $pass = CommonFunctions::randomPassword(8);
            $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$existing_location_id')";
            $db->execDB($rbiq);
        }

        echo json_encode(['status'=>"error"]);
        exit();
    }

}
elseif($action=='update_account_info'){
    $id = $_GET['id'];

    $property_details = getPropertyDetails($id,$db,$mno_id);


    //$business_id = $_POST['business_id'];
    $business_name = $_POST['business_name'];
    $bis_admin_first_name = $_POST['bis_admin_first_name'];
    $bis_admin_last_name = $_POST['bis_admin_last_name'];
    $email = $_POST['email'];
    $verify_email=$_POST['verify_email'];

    $existing_business_id = $property_details['account_info']['business_id'];
    $business_id_state = 1;//$existing_business_id==$business_id?1:2;

    $property_details['account_info'] = [
        "business_id"=>$existing_business_id,
        "business_name"=>$business_name,
        "first_name"=>$bis_admin_first_name,
        "last_name"=>$bis_admin_last_name,
        "email"=>$email
    ];

    $property_details = json_encode($property_details);
    $q = "UPDATE exp_provisioning_properties SET`property_details` = '$property_details' WHERE id='$id' AND mno_id='$mno_id'";

    //reserve location id
    if($business_id_state==2){
        if(!empty($business_id_state)){
            $db->execDB("DELETE FROM admin_users WHERE verification_number='$existing_business_id'");
        }
        $user_name = 'tpu'.$business_id.uniqid();
        $pass = CommonFunctions::randomPassword(8);
        $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$business_id')";
        $reserve_bus_id = $db->execDB($rbiq);
    }else{
        $reserve_bus_id = true;
    }

    if($reserve_bus_id){
        $update = $db->execDB($q);
    }else{
        $user_name = 'tpu'.$existing_business_id.uniqid();
        $pass = CommonFunctions::randomPassword(8);
        $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$existing_business_id')";
        $db->execDB($rbiq);
        echo json_encode(["status"=>"failed",'message'=>'business ID already used']);
        exit();
    }

    if($update === true){
        echo json_encode(["status"=>"success","id"=>$id]);
    }else{
        $revers_q = "DELETE FROM admin_users WHERE user_name='$user_name' AND verification_number='$business_id'";
        $user_name = 'tpu'.$existing_business_id.uniqid();
        $pass = CommonFunctions::randomPassword(8);
        $rbiq = "INSERT INTO admin_users (user_name,password,verification_number) value ('$user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$pass'))))),'$existing_business_id')";
        $db->execDB($rbiq);
        $db->execDB($revers_q);
        echo json_encode(["status"=>"failed"]);
    }


    
}
elseif ($action=='generateParentID'){

    $business = generateParentID($mno_id,$db);

    if($business[0]===false){
        echo json_encode(["status"=>"failed","message"=>'Business ID generation is failed']);
        exit();
    }

    $property_details = json_encode([
        "account_info"=>[
            "business_id"=>$business[0],
            "business_name"=>'',
            "first_name"=>'',
            "last_name"=>'',
            "email"=>''
        ]/*,
        "location_info"=>[],
        "network_info"=>[]*/
    ]);

    $q = "INSERT INTO exp_provisioning_properties (`mno_id`,`property_details`,`status`,`create_user`,`create_date`)
    VALUES('$mno_id','$property_details',1,'$_SESSION[user_name]',NOW())";

    $create = $db->execDB($q);

    if($create === true){
        echo json_encode(["status"=>"success","id"=>$db->insert_id(),'business_id'=>$business[0]]);
    }else{
        $revers_q = "DELETE FROM admin_users WHERE user_name='$business[1]' AND verification_number='$business[0]'";
        $db->execDB($revers_q);
        echo json_encode(["status"=>"failed"]);
        exit();
    }
}
elseif ($action=='generateLocationID'){
    $id = $_POST['id'];

    $property_details = getPropertyDetails($id,$db,$mno_id);

    if(strlen($property_details['property'][$i]['location_info'][0]['location_id'])>0){
        echo json_encode(["status"=>"failed","message"=>'Location ID generation is failed']);
        exit();
    }

    $system_package = $_POST['system_package'];
    $location_id = generateLocationID($mno_id,$db,$system_package);
    
    if($location_id===false){
        echo json_encode(["status"=>"failed","message"=>'Location ID generation is failed']);
        exit();
    }


    $property_details['property'][$i]['location_info'] = [
        [
            "service_type"=> '',
            "location_id"=>$location_id[0],
            "vt_location_id"=> '',
            "location_name"=> '',
            "phone_number"=> '',
            "address"=> '',
            "city"=> '',
            "country"=> '',
            "state"=> '',
            "time_zone"=> '',
            "zip_code"=> '',
        ]
    ];


    $property_details = json_encode($property_details);
    $q = "UPDATE exp_provisioning_properties SET`property_details` = '$property_details', `status`=IF(`status`=1,2,`status`) WHERE id='$id' AND mno_id='$mno_id'";

    $update = $db->execDB($q);

    if($update === true){
        echo json_encode(["status"=>"success","id"=>$id,'location_id'=>$location_id[0]]);
    }else{
        $revers_q = "DELETE FROM admin_users WHERE user_name='$location_id[1]' AND verification_number='$location_id[0]'";
        $db->execDB($revers_q);
        echo json_encode(["status"=>"failed"]);
        exit();
    }

}
//print_r($main_key);