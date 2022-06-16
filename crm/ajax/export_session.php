<?php

session_start();
$session_id = session_id();
$user_name = $_SESSION['user_name'];

header("Cache-Control: no-cache, must-revalidate");
require_once '../classes/dbClass.php';
$db = new db_functions();

include '../classes/exportClass.php';

/*Encryption script*/
include_once '../classes/cryptojs-aes.php';

$main_key = $_GET['key'];

$data_secret = $db->select1DB("SELECT settings_value FROM exp_settings WHERE settings_code='data_secret' AND distributor='ADMIN'");
//$data_secret = mysql_fetch_assoc($data_secret);
$data_secret = $data_secret['settings_value'];



$request_data = cryptoJsAesDecrypt($data_secret, $main_key);

if(strlen($request_data)>0){}else{exit();}
parse_str($request_data,$request_data_arrya);

$dist = $request_data_arrya['dist'];
$type = $request_data_arrya['type'];
$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );
$type = htmlentities( urldecode($type), ENT_QUOTES, 'utf-8' );

if($type=="total_sessions"){
    $interval = $_GET['interval'];
    $offset_val = $request_data_arrya['offset_val'];
    $interval = (int)htmlentities( urldecode($interval), ENT_QUOTES, 'utf-8' );
    $query_code = sprintf("SELECT first_name AS 'FIRST NAME',last_name AS 'LAST NAME',act_email AS 'EMAIL ADDRESS',mac AS MAC,mobile_number AS 'MOBILE NUMBER',first_login_date AS 'FIRST LOGIN DATE',s.session_auth_time AS 'LAST LOGIN DATE'
    FROM exp_customer c, exp_customer_session s
    WHERE c.customer_id = s.customer_id AND s.location_id = '%s' AND s.session_status = '2' AND DATE(CONVERT_TZ(NOW(),'SYSTEM',%s)) - INTERVAL %s DAY <= DATE(CONVERT_TZ(FROM_UNIXTIME(s.unixtimestamp),'SYSTEM',%s)) ORDER BY s.id DESC", $dist, $offset_val,$interval, $offset_val);
    
    $exp = new export();
    
    $filename = 'export_sessions';
    $execute = $exp->downloadCSV($query_code, $filename);

}else{

    $query_code = sprintf("SELECT DATE(s.session_auth_time) AS Session_date,TIME(s.session_auth_time) AS Session_start,HOUR(s.session_auth_time) AS Peak_hour,s.os_name AS Operating_system,s.network_username AS Uid,s.session_type AS new_Return,s.ssid AS SSID,s.ap AS AP,s.group_tag AS Group_Tag,first_name AS First_Name,last_name AS Last_Name,email AS Email,gender AS Gender,if(age_group = 'all','N/A',replace(age_group,'_','-')) AS age_group,city as Home_City, current_city as Current_City,locale as Locale, timezone as TimeZone, country as Country, s.mac AS MAC,s.is_mobile AS Is_mobile_User,first_login_date AS First_connect_date
    FROM exp_customer c, exp_customer_session s
    WHERE s.location_id = %s AND c.customer_id = s.customer_id AND s.session_status = '2' AND  DATE(s.session_auth_time) = CURDATE()", $dist);
    
    $exp = new export();
    
    $filename = 'export_sessions';
    $execute = $exp->downloadXL($query_code, $filename);
}

?>