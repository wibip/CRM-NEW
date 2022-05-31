<?php
session_start();
$session_id = session_id();
$user_name = $_SESSION['user_name'];
$dist = $_GET['dist'];
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ERROR);
header("Cache-Control: no-cache, must-revalidate");

include_once dirname(__FILE__).'/../classes/cryptojs-aes.php';

require_once '../classes/exportClass.php';
require_once '../classes/dbClass.php';

$db_class=new db_functions();

$exp = new export();


include_once '../classes/systemPackageClass.php';
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);

$module_array = array('logs','session','reports','audit');

if(!$package_functions->ajaxAccess($module_array,$system_package)){
    http_response_code(401);
    return false;
}


$base_portal_url=$db_class->setVal('camp_base_url','ADMIN');
	// POST SUBMIT Customer #reports
if (isset($_GET['property_activity_current_logs'])) {

	$mno_id = $_GET['mno_id'];

	$query_code = "SELECT t.user_name AS 'USER ID',t.module AS 'MODULE NAME',t.task AS 'TASK',t.reference AS 'REFERENCE',t.ip AS 'IP',t.create_date AS 'DATE' FROM (
            SELECT aul.* FROM admin_user_logs aul JOIN mno_distributor_parent mdp ON aul.user_distributor=mdp.parent_id
            WHERE mdp.mno_id='$mno_id' AND FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
            UNION
            SELECT aul.* FROM admin_user_logs aul JOIN exp_mno_distributor emd ON aul.user_distributor=emd.distributor_code
            WHERE emd.mno_id='$mno_id' AND FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
        ) t
        ORDER BY t.unixtimestamp";
	$filename = 'BI_Property_Activity_Logs'.date('ymdHis');
	$execute = $exp->downloadCSV($query_code, $filename);
}
if (isset($_GET['customer_submit'])) {

	$from_date_cus = $_GET['from_date_cus'];
	$to_date_cus = $_GET['to_date_cus'];
	$dist = $_GET['dist'];
	$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );
	$from_date_cus = htmlentities( urldecode($from_date_cus), ENT_QUOTES, 'utf-8' );
	$to_date_cus = htmlentities( urldecode($to_date_cus), ENT_QUOTES, 'utf-8' );

	$query_code = "SELECT first_name,last_name,email,mobile_number,gender,proffession,c.portal_id,login_media,social_media_id,social_media_url,birthday,age_group,street,city,current_city,zip,state,country,current_country,locale,timezone,first_login_date,last_login_date
	FROM exp_customer c, exp_customer_session s WHERE c.customer_id = s.customer_id AND s.location_id = '%s' AND s.session_status = '2' AND c.`email` LIKE '%@%.%'";

    $query_code = sprintf($query_code,$dist);

	if ($from_date_cus && $to_date_cus) {
		$query_code .=	sprintf(" AND c.first_login_date BETWEEN '%s 00:00:00' AND '%s 23:59:59'",$from_date_cus,$to_date_cus);
	} else {
		$from_date_cus = "";
		$to_date_cus = "";
	}

	$query_code .=	" GROUP BY c.customer_id" ;

	//echo $query_code;

	$filename = 'export_customer'.date('ymdHis');
	$execute = $exp->downloadXL($query_code, $filename);

}


	// POST SUBMIT Sessions

if (isset($_GET['session_submit'])) {

	$from_date_sess = $_GET['from_date_sess'];
	$to_date_sess = $_GET['to_date_sess'];
	$dist = $_GET['dist'];
	$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );
	$from_date_sess = htmlentities( urldecode($from_date_sess), ENT_QUOTES, 'utf-8' );
	$to_date_sess = htmlentities( urldecode($to_date_sess), ENT_QUOTES, 'utf-8' );

	$query_code2_string ="SELECT `network_username` AS `USERID`, `aaa_multi_session_id` AS `SESSIONID`,`aaa_calledstationid` AS `CALLEDSTATIONID`,`mac` AS `MAC`,`aaa_download` AS `DOWNLOAD`,`aaa_upload` AS `UPLOAD`,aaa_eventtime AS `EVENTTIME`,`aaa_wisprlocid` AS `WISPRLOCID`,`first_name` AS `First Name` , `last_name` AS `Last Name` , `email` AS `E-mail` , `gender` AS `Gender` , `age_group` AS `Age Group` ,
	HOUR( `session_starting_time` ) AS `Peak Time` , `os_name` AS `Operating System` , `session_type` AS `New Return` ,
	`exp_camphaign_ads`.`ad_name` AS `Ad Name` , `exp_camphaign_ads`.`ad_type` AS `Ad Type` , `exp_camphaign_ads`.`ad_category` AS `Ad Catagory` ,
	`group_tag` AS `Group Tag` , `ssid` AS `SSID` , `exp_camphaign_ads`.`survey_top_text` AS `Survey Question` 
	, 
	IF(`exp_camphaign_ad_survey_option_results_hits`.`result_id`='1',`exp_camphaign_ad_survey_option`.`option_1`,
	IF(`exp_camphaign_ad_survey_option_results_hits`.`result_id`='2',`exp_camphaign_ad_survey_option`.`option_2`,
	`exp_camphaign_ad_survey_option`.`option_3`)) AS `Survey Answer`
	FROM `exp_camphaign_ad_survey_option`
	RIGHT JOIN 
	`exp_camphaign_ad_survey_option_results_hits` 
	ON `exp_camphaign_ad_survey_option`.`ad_id`= `exp_camphaign_ad_survey_option_results_hits`.`ad_id`
	 RIGHT JOIN  
	`dashboard_graph_local_data`  
	ON `exp_camphaign_ad_survey_option_results_hits`.`token`=`dashboard_graph_local_data`.`token_id`
	LEFT JOIN`exp_camphaign_ads`  
	ON  `dashboard_graph_local_data`.`ad_id`=`exp_camphaign_ads`.`ad_id`
	WHERE `location_id`='%s'";

    $query_code2 = sprintf($query_code2_string,$dist);

    /* "SELECT DATE(s.session_auth_time) AS Session_date,TIME(s.session_auth_time) AS Session_start,HOUR(s.session_auth_time) AS Peak_hour,s.os_name AS Operating_system,s.network_username AS Uid,s.session_type AS new_Return,s.ssid AS SSID,s.ap AS AP,s.group_tag AS Group_Tag,first_name AS First_Name,last_name AS Last_Name,email AS Email,gender AS Gender,birthday AS Birthday,city as Home_City, current_city as Current_City,locale as Locale, timezone as TimeZone, country as Country, s.mac AS MAC,s.is_mobile AS Is_mobile_User,first_login_date AS First_connect_date
		FROM exp_customer c, exp_customer_session s
		WHERE s.location_id = '$dist' AND c.customer_id = s.customer_id AND s.session_status = '2'";  */
	

	if ($from_date_sess && $to_date_sess) {
		//$from_date_sess=$db_class->GetSQLValueString($from_date_sess,'date');
		//$to_date_sess=$db_class->GetSQLValueString($to_date_sess,'date');
		$query_code2 .=	sprintf(" AND session_starting_time BETWEEN '%s 00:00:00' AND '%s 23:59:59'",$from_date_sess,$to_date_sess);
	} else {
		$from_date_sess = "";
		$to_date_sess = "";
	}

	//echo $query_code2;

	$filename = 'export_session'.date('ymdHis');
	$execute = $exp->downloadXL($query_code2, $filename);

}


	// POST SUBMIT Camp

if (isset($_GET['camp_submit'])) {

	$from_date_camp = $_GET['from_date_camp'];
	$to_date_camp = $_GET['to_date_camp'];
	$dist = $_GET['dist'];
	$set_query = "";
	$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );
	$from_date_camp = htmlentities( urldecode($from_date_camp), ENT_QUOTES, 'utf-8' ).' 00:00:00';
	$to_date_camp = htmlentities( urldecode($to_date_camp), ENT_QUOTES, 'utf-8' ).' 23:59:59';


	if ($from_date_camp && $to_date_camp) {
		//$from_date_camp=$from_date_camp;//$db_class->GetSQLValueString($from_date_camp,'date')
		//$to_date_camp=$to_date_camp; //$db_class->GetSQLValueString()
		$set_query = sprintf(" AND l.create_date BETWEEN '%s' AND '%s'",$from_date_camp,$to_date_camp);
	} else {

		$from_date_camp = "";
		$to_date_camp = "";
	}

	$query_code3 = "SELECT CASE WHEN a.`ad_name` IS NULL THEN 'NA' ELSE a.`ad_name` END                                   AS 'Campaign Name',
       CASE WHEN a.`ad_type` IS NULL THEN 'NA' ELSE a.`ad_type` END                                   AS 'Campaign Type',
       CASE WHEN a.`mac` = 'DEMO_MAC' OR a.`mac` IS NULL THEN 'NA' ELSE a.`mac` END                   AS 'Device MAC',
       CASE WHEN a.`group_tag` IS NULL THEN 'NA' ELSE a.`group_tag` END                               AS 'Location',
       CASE WHEN a.`ap` IS NULL THEN 'NA' ELSE a.`ap` END                                             AS 'AP MAC',
       CASE WHEN a.`ssid` IS NULL THEN 'NA' ELSE a.`ssid` END                                         AS 'Network Name',
       CASE WHEN a.`email` IS NULL THEN 'NA' ELSE a.`email` END                                       AS 'Email',
       CASE WHEN a.`first_name` = 'Guest' OR a.`first_name` IS NULL THEN 'NA' ELSE a.`first_name` END AS 'First name',
       CASE WHEN a.`last_name` = 'User' OR a.`last_name` IS NULL THEN 'NA' ELSE a.`last_name` END     AS 'Last name',
       a.`gender`                                     AS 'Gender',
       CASE WHEN a.`age_group` IS NULL THEN 'NA' ELSE a.`age_group` END                               AS 'Age Group',
       CASE WHEN a.`survey_top_text` IS NULL THEN 'NA' ELSE a.`survey_top_text` END                       AS 'Survey question',
       CASE WHEN r.`result_data` IS NULL THEN 'NA' ELSE r.`result_data` END                           AS 'Survey answer'
FROM (SELECT a.`ad_name`,
             a.`ad_type`,
             a.`ad_category`,
             a.`top_text`,
             l.`token`,
             l.`customer_id`,
             s.`mac`,
             s.`group_tag`,
             s.`ap`,
             s.`ssid`,
             s.`browser_name`,
             s.`browser_version`,
             s.`os_version`,
             s.`location_id`,
             c.`act_email`       as email,
             c.`first_name`,
             c.`last_name`,
             c.`gender`,
             c.age_group,
             a.`survey_top_text`
      FROM `exp_camphaign_ads` a,
           `exp_camphaign_logs` l,
           `exp_customer_session` s,
           `exp_customer` c
      WHERE a.`ad_id` = l.`ad_id`
        AND l.`token` = s.`token_id`
        AND s.`customer_id` = c.`customer_id`
        AND s.location_id = '%s'
        AND s.session_status = '2'
        ".$set_query.") a
         LEFT JOIN `exp_camphaign_ad_survey_option_results_hits` r ON a.`token` = r.`token`
UNION
SELECT CASE WHEN a.`ad_name` IS NULL THEN 'NA' ELSE a.`ad_name` END                                   AS 'Campaign Name',
       CASE WHEN a.`ad_type` IS NULL THEN 'NA' ELSE a.`ad_type` END                                   AS 'Campaign Type',
       CASE WHEN a.`mac` = 'DEMO_MAC' OR a.`mac` IS NULL THEN 'NA' ELSE a.`mac` END                   AS 'Device MAC',
       CASE WHEN a.`group_tag` IS NULL THEN 'NA' ELSE a.`group_tag` END                               AS 'Location',
       CASE WHEN a.`ap` IS NULL THEN 'NA' ELSE a.`ap` END                                             AS 'AP MAC',
       CASE WHEN a.`ssid` IS NULL THEN 'NA' ELSE a.`ssid` END                                         AS 'Network Name',
       CASE WHEN a.`email` IS NULL THEN 'NA' ELSE a.`email` END                                       AS 'Email',
       CASE WHEN a.`first_name` = 'Guest' OR a.`first_name` IS NULL THEN 'NA' ELSE a.`first_name` END AS 'First name',
       CASE WHEN a.`last_name` = 'User' OR a.`last_name` IS NULL THEN 'NA' ELSE a.`last_name` END     AS 'Last name',
       a.`gender`                                     AS 'Gender',
       CASE WHEN a.`age_group` IS NULL THEN 'NA' ELSE a.`age_group` END                               AS 'Age Group',
       CASE WHEN a.`survey_top_text` IS NULL THEN 'NA' ELSE a.`survey_top_text` END                       AS 'Survey question',
       CASE WHEN r.`result_data` IS NULL THEN 'NA' ELSE r.`result_data` END                           AS 'Survey answer'
FROM (SELECT a.`ad_name`,
             a.`ad_type`,
             a.`ad_category`,
             a.`top_text`,
             l.`token`,
             l.`customer_id`,
             s.`mac`,
             s.`group_tag`,
             s.`ap`,
             s.`ssid`,
             s.`browser_name`,
             s.`browser_version`,
             s.`os_version`,
             s.`location_id`,
             c.`act_email`       as email,
             c.`first_name`,
             c.`last_name`,
             c.`gender`,
             c.`age_group`,
             a.`survey_top_text`
      FROM `exp_camphaign_ads` a,
           `exp_camphaign_logs` l,
           `exp_customer_session` s,
           `exp_customer` c
      WHERE a.`ad_id` = l.`ad_id`
        AND l.`token` = s.`token_id`
        AND s.`customer_id` = c.`customer_id`
        AND s.location_id = '%s'
        AND s.session_status = '2'
        ".$set_query.") a
         RIGHT JOIN `exp_camphaign_ad_survey_option_results_hits` r ON a.`token` = r.`token`
WHERE a.ad_name IS NOT NULL";

    $query_code3 = sprintf($query_code3,$dist,$dist);
//echo $query_code3;exit();
	//echo $query_code3; die();

	$filename = 'Campaign_Export_Report_'.date('ymdHis');
	$execute = $exp->downloadXL($query_code3, $filename);

}


//li report #session
if (isset($_GET['li_report'])) {

    $li_id=$_GET['li_report'];
    $user_name=$_GET['user_name'];
    $li_id = htmlentities( urldecode($li_id), ENT_QUOTES, 'utf-8' );
	$user_name = htmlentities( urldecode($user_name), ENT_QUOTES, 'utf-8' );
   // echo $_SESSION['li_download_id'];
  if($li_id==$_SESSION['li_download_id']){

    $db_class->execDB(sprintf("INSERT INTO `exp_li_report_log` (
		  `unique_id`,
		  `type`,
		  `create_user`,
		  `create_date`
		) 
		VALUES
		  (
			'%s',
			'download',
			'%s',
			NOW()
		  )",$li_id,$user_name));
		/*IF(l.`session_start_time`='0','',DATE_FORMAT(l.`session_start_time`,'%m/%d/%Y %h:%i %p')) AS 'START TIME',
		 IF(l.`session_end_time`='0','',DATE_FORMAT(l.`session_end_time`,'%m/%d/%Y %h:%i %p')) AS 'END TIME',*/

	 	$query_code4 = "SELECT
		IF(nas_type = 'ac',l.nas_ip_address,l.`framed_ip_address`) AS 'PUBLIC IP',
		 IF(LENGTH(IF(l.`realm` IS NULL,'N/A',l.`realm`))=0,'N/A',IF(l.`grp_realm` IS NULL,'N/A',l.`realm`)) AS 'CUSTOMER ACCOUNT NUMBER',
		 IF(l.`session_start_time`='0','',FROM_UNIXTIME(l.`session_start_time`,'%m/%d/%Y %h:%i:%s %p')) AS 'START TIME',
         IF(l.`session_end_time`='0','',FROM_UNIXTIME(l.`unixtimestamp`,'%m/%d/%Y %h:%i:%s %p')) AS 'END TIME',
		 IF(LENGTH(IF(l.`acct_session_time` IS NULL,'N/A',l.`acct_session_time`))=0,'N/A',IF(l.`acct_session_time` IS NULL,'N/A',l.`acct_session_time`)) AS 'DURATION (SEC)',

		 IF(LENGTH(IF(l.`session_mac` IS NULL,'N/A',l.`session_mac`))=0,'N/A',IF(l.`session_mac` IS NULL,'N/A',l.`session_mac`)) AS 'DEVICE MAC',
		 IF(LENGTH(IF(l.`called_station_id` IS NULL,'N/A',l.`called_station_id`))=0,'N/A',IF(l.`called_station_id` IS NULL,'N/A',l.`called_station_id`)) AS 'AP/AC MAC',

		 IF(LENGTH(IF(l.`nas_type` IS NULL,'N/A',UPPER(l.`nas_type`)))=0,'N/A',IF(l.`nas_type` IS NULL,'N/A',UPPER(l.`nas_type`))) AS 'AC/WAG',


IF(LENGTH(IF(l.`vlan_id` IS NULL,'N/A',l.`vlan_id`))=0,'N/A',IF(l.`vlan_id` IS NULL,'N/A',IF(l.`vlan_id`=0,'N/A',l.`vlan_id`))) AS 'VLAN',
		 IF(LENGTH(IF(l.`acct_input_octets` IS NULL,'N/A',l.`acct_input_octets`))=0,'N/A',IF(l.`acct_input_octets` IS NULL,'N/A',l.`acct_input_octets`)) AS 'DL (BYTES)',
		 IF(LENGTH(IF(l.`acct_output_octets` IS NULL,'N/A',l.`acct_output_octets`))=0,'N/A',IF(l.`acct_output_octets` IS NULL,'N/A',l.`acct_output_octets`)) AS 'UP (BYTES)',
		 IF(LENGTH(IF(d.`property_id` IS NULL,'N/A',d.`property_id`))=0,'N/A',IF(d.`property_id` IS NULL,'N/A',d.`property_id`))  AS 'Property ID',
		 IF(LENGTH(IF(l.`nas_port_id` IS NULL,'N/A',l.`nas_port_id`))=0,'N/A',IF(l.`nas_port_id` IS NULL,'N/A',l.`nas_port_id`)) AS 'SSID/NETWORK',
		 IF(LENGTH(IF(l.`nas_port_from` IS NULL,'N/A',l.`nas_port_from`))=0,'N/A',IF(l.`nas_port_from` IS NULL,'N/A',IF(l.`nas_port_from`=0,'N/A',l.`nas_port_from`))) AS 'PORT RANGE FROM',
		 IF(LENGTH(IF(l.`nas_port_to` IS NULL,'N/A',l.`nas_port_to`))=0,'N/A',IF(l.`nas_port_to` IS NULL,'N/A',IF(l.`nas_port_to`=0,'N/A',l.`nas_port_to`))) AS 'PORT RANGE TO',
		 `dhcp_ip` AS 'INTERNAL IP'


	 FROM
		 `exp_li_report` l LEFT JOIN `exp_mno_distributor` d
		 ON l.`realm`=d.`verification_number`
                    WHERE
                    `uniqid_id`='$li_id'";

                    //IF(nas_type = 'ac',l.framed_ip_address,'N/A') AS 'INTERNAL IP'
       /* $query_code4 = sprintf($query_code4,GetSQLValueString($li_id,'text'));*/

	//echo $query_code3;

	$filename = 'BI_historical_session_report_'.date('ymdHis');
	$execute = $exp->downloadCSV($query_code4, $filename);
    }else{
        echo 'Invalid request';
    }

}

//quarterly li report #session
if (isset($_GET['li_report_q'])) {

    $li_id=$_GET['li_report_q'];
    $user_name=$_GET['user_name'];
    $li_id = htmlentities( urldecode($li_id), ENT_QUOTES, 'utf-8' );
	$user_name = htmlentities( urldecode($user_name), ENT_QUOTES, 'utf-8' );
   // echo $_SESSION['li_download_id'];
  if($li_id==$_SESSION['li_download_id2']){

    $db_class->execDB(sprintf("INSERT INTO `exp_li_report_log` (
		  `unique_id`,
		  `type`,
		  `create_user`,
		  `create_date`
		) 
		VALUES
		  (
			'%s',
			'download',
			'%s',
			NOW()
		  )",$li_id,$user_name));


	 	$query_code4 = "SELECT
                      IF(nas_type = 'ac',l.nas_ip_address,l.`framed_ip_address`) AS 'PUBLIC IP',
                      IF(LENGTH(IF(l.`grp_realm` IS NULL,'N/A',l.`grp_realm`))=0,'N/A',IF(l.`grp_realm` IS NULL,'N/A',l.`grp_realm`)) AS 'CUSTOMER ACCOUNT NUMBER',
                      IF(l.`session_start_time`='0','',FROM_UNIXTIME(l.`session_start_time`,'%m/%d/%Y %h:%i:%s %p')) AS 'START TIME',
                      FROM_UNIXTIME(l.`unixtimestamp`,'%m/%d/%Y %h:%i:%s %p') AS 'END TIME',
                      IF(LENGTH(IF(l.`acct_session_time` IS NULL,'N/A',l.`acct_session_time`))=0,'N/A',IF(l.`acct_session_time` IS NULL,'N/A',l.`acct_session_time`)) AS 'DURATION (SEC)',

                      IF(LENGTH(IF(l.`session_mac` IS NULL,'N/A',l.`session_mac`))=0,'N/A',IF(l.`session_mac` IS NULL,'N/A',l.`session_mac`)) AS 'DEVICE MAC',
                      IF(LENGTH(IF(l.`called_station_id` IS NULL,'N/A',l.`called_station_id`))=0,'N/A',IF(l.`called_station_id` IS NULL,'N/A',l.`called_station_id`)) AS 'AP/AC MAC',
                      
                      IF(LENGTH(IF(l.`nas_identifier1` IS NULL,'N/A',UPPER(l.`nas_identifier1`)))=0,'N/A',IF(l.`nas_identifier1` IS NULL,'N/A',UPPER(l.`nas_identifier1`))) AS 'AC/WAG',
                      
                      
		      IF(LENGTH(IF(l.`vlan_id` IS NULL,'N/A',l.`vlan_id`))=0,'N/A',IF(l.`vlan_id` IS NULL,'N/A',l.`vlan_id`)) AS 'VLAN',
                      IF(LENGTH(IF(l.`acct_input_octets` IS NULL,'N/A',l.`acct_input_octets`))=0,'N/A',IF(l.`acct_input_octets` IS NULL,'N/A',l.`acct_input_octets`)) AS 'DL (BYTES)',
                      IF(LENGTH(IF(l.`acct_output_octets` IS NULL,'N/A',l.`acct_output_octets`))=0,'N/A',IF(l.`acct_output_octets` IS NULL,'N/A',l.`acct_output_octets`)) AS 'UP (BYTES)',                 
                      IF(LENGTH(IF(d.`property_id` IS NULL,'N/A',d.`property_id`))=0,'N/A',IF(d.`property_id` IS NULL,'N/A',d.`property_id`)) AS 'PROPERTY ID',

                      IF(LENGTH(IF(l.`nas_port_id` IS NULL,'N/A',l.`nas_port_id`))=0,'N/A',IF(l.`nas_port_id` IS NULL,'N/A',l.`nas_port_id`)) AS 'SSID/NETWORK',
                      IF(LENGTH(IF(l.`nas_port_from` IS NULL,'N/A',l.`nas_port_from`))=0,'N/A',IF(l.`nas_port_from` IS NULL,'N/A',l.`nas_port_from`)) AS 'PORT RANGE FROM',
                      IF(LENGTH(IF(l.`nas_port_to` IS NULL,'N/A',l.`nas_port_to`))=0,'N/A',IF(l.`nas_port_to` IS NULL,'N/A',l.`nas_port_to`)) AS 'PORT RANGE TO',
                      `dhcp_ip`  AS 'INTERNAL IP'
                      
                    FROM
                      `exp_li_report` l LEFT JOIN `exp_mno_distributor` d
                      ON l.`grp_realm`=d.`verification_number`
                    WHERE
                    `uniqid_id`='$li_id'";


       /* $query_code4 = sprintf($query_code4,GetSQLValueString($li_id,'text'));*/

	//echo $query_code3;

	$filename = 'BI_quarterly_historical_session_report_'.date('ymdHis');
	$execute = $exp->downloadCSV($query_code4, $filename);
    }else{
        echo 'Invalid request';
    }

}





//Property Activity Logs
if(isset($_GET['property_activity_logs'])){
    $filename = 'BI_Property_Activity_Logs'.date('ymdHis');
    $json_data = $_SESSION[$_GET['property_activity_logs']];
    $exp->downloadCSVwithJson($json_data, $filename);
}


//Finance Audit Report
if(isset($_REQUEST['query'])){
    $data_secret = $db_class->setVal('data_secret','ADMIN');

    $main_key = $_REQUEST['query'];
    $request_data_ar = cryptoJsAesDecrypt($data_secret, $main_key);
//print_r($request_data_ar);
    if(count($request_data_ar)>0){}else{ print_r('Invalid Request');exit();}
    $filename = 'BI_APCF_Audit_Report'.date('ymdHis');
    $exp->downloadCSV($request_data_ar,$filename);
}

if(isset($_GET['plan_activation'])){

	$dist = $db_class->GetSQLValueString($_GET['dist'],'string');

    $date_format = 'Y-m-d H:i:s';

    $log_time_zone = $db_class->GetSQLValueString($_GET['user_timestamp'],'string');

    $from_str = $db_class->GetSQLValueString($_GET['from_date_prepaid'],'string').' 00:00:00';
    $from = DateTime::createFromFormat('m/d/Y H:i:s',$from_str)->format($date_format);

    $to_str = $db_class->GetSQLValueString($_GET['to_date_prepaid'],'string').' 23:59:59';
    $to = DateTime::createFromFormat('m/d/Y H:i:s',$to_str)->format($date_format);

    $d_start_ses = new DateTime($from, new DateTimeZone($log_time_zone));
	$start_date_tz = $d_start_ses->getTimestamp();

	$d_end_ses = new DateTime($to, new DateTimeZone($log_time_zone));
	$end_date_tz = $d_end_ses->getTimestamp();


    $mno = $db_class->GetSQLValueString($_GET['dist'],'string');
    $type = $db_class->GetSQLValueString($_GET['dist_type'],'string');

    $q = "SELECT
		  p.mobile_number AS 'Phone Number',
		  p.mac_address AS 'Device Mac',
		  p.full_name AS 'Customer Name',
		  p.realm  AS 'Customer Account Number',
		  p.parent_id  AS 'Property Admin',
		  p.ap_mac  AS 'Ap Mac',
		  ap.ap_name  AS 'Ap Name',
		  p.ssid  AS 'SSID',
		  p.bussiness_type  AS 'Bussiness Type',
		  p.amount AS 'Amount',
		  p.quota AS 'Quota',
		  p.data_volume AS 'Data Volume',
		  p.sf_account AS 'Prepaid Account Number',
		  p.activate_date  AS 'Activated Date' 
		  FROM exp_report_prepaid p LEFT JOIN exp_locations_ap ap  ON p.ap_mac=ap.ap_code WHERE p.mno_id = '$mno' AND p.unixtimestamp  BETWEEN '$start_date_tz' AND '$end_date_tz'";


    $filename = 'BI_Prepaid_report_'.date('ymdHis');
    $exp->downloadCSV($q, $filename);
}

if(isset($_GET['property_activation'])){

    $dist = $db_class->GetSQLValueString($_GET['dist'],'string');

    $date_format = 'Y-m-d H:i:s';

    $from_str = $db_class->GetSQLValueString($_GET['from_date_camp'],'string').' 00:00:00';
    $from = DateTime::createFromFormat('m/d/Y H:i:s',$from_str)->format($date_format);


    $to_str = $db_class->GetSQLValueString($_GET['to_date_camp'],'string').' 23:59:59';
    $to = DateTime::createFromFormat('m/d/Y H:i:s',$to_str)->format($date_format);

    $mno = $db_class->GetSQLValueString($_GET['dist'],'string');
    $type = $db_class->GetSQLValueString($_GET['dist_type'],'string');
    if($type=='SUPPORT' || $type=='MNO') {
        /*echo $q = "SELECT
       DATE_FORMAT(STR_TO_DATE(t.month, \"%Y-%m\"), \"%Y/%M\")        AS Month,
       t.parent_id                                                AS 'Business ID',
       DATE_FORMAT(FROM_UNIXTIME(t.parent_activation_email), '%Y-%m-%d %H:%i:%s') AS 'Business ID Activation Email Sent Date(UTC)',
       GROUP_CONCAT(DISTINCT t.parent_active_date)                AS 'Business ID Activated',
       t.verification_number                                      AS 'Customer Account #',
       IF(GROUP_CONCAT(DISTINCT t.active_date) IS NULL, '0', '1') AS 'Property Activated with Customer Account Registration',
       GROUP_CONCAT(DISTINCT t.active_date)                       AS 'Activated',
       SUM(t.theme_count)                                         AS 'Themes Count',
       GROUP_CONCAT(DISTINCT t.active_theme_date)                 AS 'Active Theme create Date',
       SUM(t.ads_count)                                           AS 'Campaign Created',
       SUM(t.content_filter_status)                               AS 'Content filtering',
       IF(
           GROUP_CONCAT(DISTINCT t.content_filter_active) IS NULL ,
           GROUP_CONCAT(DISTINCT t.parent_active_date),
             IF(GROUP_CONCAT(DISTINCT t.parent_active_date) IS NULL,NULL,
               IF(GROUP_CONCAT(DISTINCT t.parent_active_date) < GROUP_CONCAT(DISTINCT t.content_filter_active),GROUP_CONCAT(DISTINCT t.content_filter_active),GROUP_CONCAT(DISTINCT t.parent_active_date))
           )
       )
                        AS 'Content filtering Activated',
       GROUP_CONCAT(DISTINCT t.content_filter)                    AS 'Content filtering history'
     FROM (SELECT
             *,
             NULL AS parent_active_date,
             NULL AS parent_activation_email
           FROM (SELECT
                   camp.month,
                   camp.verification_number,
                   camp.distributor_code,
                   camp.parent_id,
                   SUM(camp.theme_count)                                                   AS theme_count,
                   GROUP_CONCAT(active_theme_date)                                         AS active_theme_date,
                   SUM(camp.ads_count)                                                     as ads_count,
                   GROUP_CONCAT(DISTINCT camp.activ_date)                                  AS active_date,
                   IF(mno_dist.dns_profile_enable IS NULL, 0, mno_dist.dns_profile_enable) AS content_filter_status,
                   GROUP_CONCAT(DISTINCT camp.content_filter_active)                       AS content_filter_active,
                   GROUP_CONCAT(DISTINCT camp.content_filter)                              AS content_filter
                 FROM (SELECT
                         DATE_FORMAT(t.create_date, '%Y-%m') AS month,
                         d.verification_number,
                         d.distributor_code,
                         d.parent_id,
                         0                                   AS ads_count,
                         count(t.theme_id)                   AS theme_count,
                         GROUP_CONCAT(CASE WHEN t.is_enable = '1'
                           THEN t.create_date
                                      ELSE NULL END)         AS active_theme_date,
                         NULL                                AS activ_date,
                         0                                   AS content_filter_status,
                         NUll                                AS content_filter_active,
                         NULL                                AS content_filter
                       FROM exp_themes t
                         JOIN exp_mno_distributor d ON t.distributor = d.distributor_code
                       WHERE d.mno_id = '$mno' AND t.create_date BETWEEN '$from' AND '$to'
                       GROUP BY t.distributor, month
                       HAVING theme_count > 0
                       UNION ALL SELECT
                                   DATE_FORMAT(c.create_date, '%Y-%m') AS month,
                                   d.verification_number,
                                   d.distributor_code,
                                   d.parent_id,
                                   count(c.ad_id)                      AS ads_count,
                                   0                                   AS theme_count,
                                   NULL                                AS active_theme_date,
                                   NULL                                AS activ_date,
                                   0                                   AS content_filter_status,
                                   NUll                                AS content_filter_active,
                                   NULL                                AS content_filter
                                 FROM exp_camphaign_ads c
                                   JOIN exp_mno_distributor d ON d.distributor_code = c.distributor
                                 WHERE d.mno_id = '$mno' AND
                                       c.create_date BETWEEN '$from' AND '$to'
                                 GROUP BY c.distributor, month
                       UNION ALL SELECT
                                   DATE_FORMAT(v.create_date, '%Y-%m') AS month,
                                   d.verification_number,
                                   d.distributor_code,
                                   d.parent_id,
                                   0                                   AS ads_count,
                                   0                                   AS theme_count,
                                   NULL                                AS active_theme_date,
                                   v.create_date                       AS activ_date,
                                   0                                   AS content_filter_status,
                                   NUll                                AS content_filter_active,
                                   NULL                                AS content_filter
                                 FROM exp_mno_distributor d
                                   JOIN admin_users u ON d.distributor_code = u.user_distributor
                                   JOIN admin_users_varification v ON u.user_name = v.user_name
                                 WHERE d.mno_id = '$mno' AND
                                       v.create_date BETWEEN '$from' AND '$to'
                       UNION ALL SELECT
                                   DATE_FORMAT(s.create_date, '%Y-%m')                                        AS month,
                                   d.verification_number,
                                   d.distributor_code,
                                   d.parent_id,
                                   0                                                                          AS ads_count,
                                   0                                                                          AS theme_count,
                                   NULL                                                                       AS active_theme_date,
                                   NULL                                                                       AS activ_date,
                                   0                                                                          AS content_filter_status,
                                   MIN(s.create_date)                                                         AS content_filter_active,
                                   GROUP_CONCAT(CONCAT(s.activation_type, '-', s.create_date) SEPARATOR
                                                '| ')                                                         AS content_filter
                                 FROM exp_mno_distributor d
                                   JOIN exp_service_activation_details s
                                     ON d.distributor_code = s.distributor AND service_id = 'CONTENT_FILTER'
                                 WHERE d.mno_id = '$mno' AND
                                       s.create_date BETWEEN '$from' AND '$to'
                                 GROUP BY s.distributor, month) camp LEFT JOIN exp_mno_distributor mno_dist
                     ON camp.distributor_code = mno_dist.distributor_code
                 GROUP BY camp.verification_number, camp.month) t1
           UNION ALL SELECT
                       DATE_FORMAT(v.create_date, '%Y-%m') AS month,
                       NULL                                AS verification_number,
                       NULL                                AS distributor_code,
                       p.parent_id,
                       0                                   AS ads_count,
                       0                                   AS theme_count,
                       NULL                                AS active_theme_date,
                       NULL                                AS activ_date,
                       0                                   AS content_filter_status,
                       NULL                                AS content_filter_active,
                       NULL                                AS content_filter,
                       v.create_date                       AS parent_active_date,
                       u.activation_email_date             AS parent_activation_email
                     FROM mno_distributor_parent p
                       JOIN admin_users u ON p.parent_id = u.user_distributor
                       JOIN admin_users_varification v ON u.user_name = v.user_name
                     WHERE p.mno_id = '$mno' AND v.create_date BETWEEN '$from' AND '$to') t
     GROUP BY t.parent_id, t.verification_number, t.month
     ORDER BY STR_TO_DATE(t.month, \"%Y-%m\");";*/
        $q = "select tbl_2.parent_id                                    as `Business ID`,
       tbl_2.emal_sent                                    as `Activation Date/Email Sent Date`,
       tbl_2.verification_number                          as `Customer Account #`,
       if(tbl_2.content_filter_enable = '1', 'Yes', 'No') as `Content Filter status`,
       tbl_2.content_filter_activated                     as `Content Filter Activated`,
       f.history                                          as `Content Filter History`,
       tbl_2.ap_count                                     as `AP Count`
from (select tbl_1.*,
             if(f.active_time is null and tbl_1.content_filter_enable = '1', tbl_1.emal_sent,
                f.active_time) as content_filter_activated
      from (select tbl_0.parent_id,
                   tbl_0.emal_sent,
                   d.distributor_code,
                   d.verification_number,
                   d.content_filter_enable,
                   d.hardware_installed,
                   COUNT(DISTINCT  ap.id) AS ap_count
            FROM (select e.distributor as parent_id, e.distributor as distributor, min(e.last_update) as emal_sent
                  FROM mno_distributor_parent p
                           left join admin_invitation_email e ON p.parent_id = e.distributor
                  WHERE e.distributor IS NOT NULL
                    AND e.send_options = 'SENT'
                  group by e.distributor
                  union all
                  select t2.*
                  from (select distinct p.parent_id, e.distributor, min(e.last_update) as emal_sent
                        from exp_mno_distributor d
                                 LEFT JOIN admin_invitation_email e ON d.distributor_code = e.distributor
                                 LEFT JOIN mno_distributor_parent p on d.parent_id = p.parent_id
                        where e.send_options = 'SENT'
                          and p.parent_id is not null
                        group by e.distributor
                        order by distributor) t2
                           left join (select distinct e.distributor as parent_id
                                      FROM mno_distributor_parent p
                                               left join admin_invitation_email e ON p.parent_id = e.distributor
                                      WHERE e.distributor IS NOT NULL
                                        AND e.send_options = 'SENT') t1 on t1.parent_id = t2.parent_id
                  WHERE t1.parent_id is null) tbl_0
                     left join exp_mno_distributor d on tbl_0.parent_id = d.parent_id
                     LEFT JOIN exp_locations_ap ap ON d.distributor_code = ap.mno
            WHERE mno_id = '$mno'
              and emal_sent between '$from' AND '$to' GROUP BY d.distributor_code) tbl_1
               left join (select distributor, max(create_date) as active_time
                          from exp_service_activation_details
                          WHERE service_id = 'CONTENT_FILTER'
                            AND activation_type = 'Activated'
                          group by distributor) f on tbl_1.distributor_code = f.distributor) tbl_2
         left join (select distributor,
                           group_concat(concat(activation_type, ':', create_date) SEPARATOR ' | ') as history
                    from exp_service_activation_details
                    WHERE service_id = 'CONTENT_FILTER'
                    group by distributor) f on f.distributor = tbl_2.distributor_code
order BY tbl_2.emal_sent";
    } elseif(/*$type=='MNO'*/false){
        $q = "SELECT
  DATE_FORMAT(STR_TO_DATE(t.month, \"%Y-%m\"), \"%Y/%M\") AS Month,
  t.parent_id                                         AS 'Business ID',
  GROUP_CONCAT(DISTINCT t.parent_active_date)         AS 'Business ID Activated',
  t.verification_number                               AS 'Customer Account #',
  IF(GROUP_CONCAT(DISTINCT t.active_date) IS NULL , '0','1') AS 'Property Activated with Customer Account Registration',
  GROUP_CONCAT(DISTINCT t.active_date)                AS 'Activated'
FROM (SELECT
        *,
        NULL AS parent_active_date
      FROM (SELECT
              camp.month,
              camp.verification_number,
              camp.distributor_code,
              camp.parent_id,
              SUM(camp.theme_count)                      AS theme_count,
              GROUP_CONCAT(active_theme_date)                                AS active_theme_date,
              SUM(camp.ads_count)                        as ads_count,
              GROUP_CONCAT(DISTINCT camp.activ_date)     AS active_date,
              IF(mno_dist.dns_profile_enable IS NULL ,0,mno_dist.dns_profile_enable)                 AS content_filter_status,
              GROUP_CONCAT(DISTINCT camp.content_filter) AS content_filter
            FROM (SELECT
                              DATE_FORMAT(v.create_date, '%Y-%m') AS month,
                              d.verification_number,
                              d.distributor_code,
                              d.parent_id,
                              0                                   AS ads_count,
                              0                                   AS theme_count,
                              NULL                                AS active_theme_date,
                              v.create_date                       AS activ_date,
                              0                                   AS content_filter_status,
                              NULL                                AS content_filter
                            FROM exp_mno_distributor d
                              JOIN admin_users u ON d.distributor_code = u.user_distributor
                              JOIN admin_users_varification v ON u.user_name = v.user_name
                            WHERE d.mno_id = '$mno' AND v.create_date BETWEEN '$from' AND '$to'
                 ) camp LEFT JOIN exp_mno_distributor mno_dist ON camp.distributor_code=mno_dist.distributor_code
            GROUP BY camp.verification_number, camp.month) t1
      UNION ALL SELECT
                  DATE_FORMAT(v.create_date, '%Y-%m') AS month,
                  NULL                                AS verification_number,
                  NULL                                AS distributor_code,
                  p.parent_id,
                  0                                   AS ads_count,
                  0                                   AS theme_count,
                  NULL                                AS active_theme_date,
                  NULL                                AS activ_date,
                  0                                   AS content_filter_status,
                  NULL                                AS content_filter,
                  v.create_date                       AS parent_active_date
                FROM mno_distributor_parent p
                  JOIN admin_users u ON p.parent_id = u.user_distributor
                  JOIN admin_users_varification v ON u.user_name = v.user_name
                WHERE p.mno_id = '$mno' AND v.create_date BETWEEN '$from' AND '$to') t
GROUP BY t.parent_id, t.verification_number, t.month
ORDER BY STR_TO_DATE(t.month, \"%Y-%m\")";
    }elseif ($type=='MVNO_ADMIN') {
	$q = "SELECT
  DATE_FORMAT(STR_TO_DATE(t.month, \"%Y-%m\"), \"%Y/%M\") AS Month,
  t.parent_id                                         AS 'Business ID',
  GROUP_CONCAT(DISTINCT t.parent_active_date)         AS 'Business ID Activated',
  t.verification_number                               AS 'Customer Account #',
  IF(GROUP_CONCAT(DISTINCT t.active_date) IS NULL , '0','1') AS 'Property Activated with Customer Account Registration',
  GROUP_CONCAT(DISTINCT t.active_date)                AS 'Activated'
FROM (SELECT
        *,
        NULL AS parent_active_date
      FROM (SELECT
              camp.month,
              camp.verification_number,
              camp.distributor_code,
              camp.parent_id,
              SUM(camp.theme_count)                      AS theme_count,
              GROUP_CONCAT(active_theme_date)                                AS active_theme_date,
              SUM(camp.ads_count)                        as ads_count,
              GROUP_CONCAT(DISTINCT camp.activ_date)     AS active_date,
              IF(mno_dist.dns_profile_enable IS NULL ,0,mno_dist.dns_profile_enable)                 AS content_filter_status,
              GROUP_CONCAT(DISTINCT camp.content_filter) AS content_filter
            FROM (SELECT
                              DATE_FORMAT(v.create_date, '%Y-%m') AS month,
                              d.verification_number,
                              d.distributor_code,
                              d.parent_id,
                              0                                   AS ads_count,
                              0                                   AS theme_count,
                              NULL                                AS active_theme_date,
                              v.create_date                       AS activ_date,
                              0                                   AS content_filter_status,
                              NULL                                AS content_filter
                            FROM exp_mno_distributor d
                              JOIN admin_users u ON d.distributor_code = u.user_distributor
                              JOIN admin_users_varification v ON u.user_name = v.user_name
                            WHERE d.mno_id = '$mno' AND v.create_date BETWEEN '$from' AND '$to'
                 ) camp LEFT JOIN exp_mno_distributor mno_dist ON camp.distributor_code=mno_dist.distributor_code
            GROUP BY camp.verification_number, camp.month) t1
      UNION ALL
      SELECT
                  DATE_FORMAT(v.create_date, '%Y-%m') AS MONTH,
                  p.verification_number            AS verification_number,
                  NULL                                AS distributor_code,
                  p.parent_id,
                  0                                   AS ads_count,
                  0                                   AS theme_count,
                  NULL                                AS active_theme_date,
                  NULL                                AS activ_date,
                  0                                   AS content_filter_status,
                  NULL                                AS content_filter,
                  v.create_date                       AS parent_active_date
                FROM exp_mno_distributor p
                  JOIN admin_users u ON p.distributor_code = u.user_distributor
                  JOIN exp_service_activation_details v ON p.distributor_code = v.distributor
                  WHERE p.parent_id = '$mno' AND v.create_date BETWEEN '$from' AND '$to'
      UNION ALL SELECT
                  DATE_FORMAT(v.create_date, '%Y-%m') AS month,
                  NULL                                AS verification_number,
                  NULL                                AS distributor_code,
                  p.parent_id,
                  0                                   AS ads_count,
                  0                                   AS theme_count,
                  NULL                                AS active_theme_date,
                  NULL                                AS activ_date,
                  0                                   AS content_filter_status,
                  NULL                                AS content_filter,
                  v.create_date                       AS parent_active_date
                FROM mno_distributor_parent p
                  JOIN admin_users u ON p.parent_id = u.user_distributor
                  JOIN admin_users_varification v ON u.user_name = v.user_name
                WHERE p.parent_id = '$mno' AND v.create_date BETWEEN '$from' AND '$to') t
GROUP BY t.parent_id, t.verification_number, t.month
ORDER BY STR_TO_DATE(t.month, \"%Y-%m\")";
}

    $filename = 'BI_Property_Summery_report_'.date('ymdHis');
    $exp->downloadCSV($q, $filename);

}

