<?php

session_start();
$session_id = session_id();
$user_name = $_SESSION['user_name'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
header("Cache-Control: no-cache, must-revalidate");
require_once '../classes/dbClass.php';
include_once '../classes/systemPackageClass.php';
$db = new db_functions();
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);
/*classes & libraries*/
include '../classes/exportClass.php';


/*Encryption script*/
include_once '../classes/cryptojs-aes.php';

 $main_key = $_REQUEST['key'];

$data_secret = $db->select1DB("SELECT settings_value FROM exp_settings WHERE settings_code='data_secret' AND distributor='ADMIN'");
//$data_secret = mysql_fetch_assoc($data_secret);
$data_secret = $data_secret['settings_value'];



$request_data = cryptoJsAesDecrypt($data_secret, $main_key);

if(strlen($request_data)>0){}else{exit();}
parse_str($request_data,$request_data_arrya);

//print_r($request_data_arrya);

$exp = new export();

//echo $request_data_arrya['task'];

if($request_data_arrya['task']=='all_distributor_list_icoms'){
	$mno_id=$request_data_arrya['mno_id'];
	$uni_id_name=$request_data_arrya['uni_id_name'];
	$mno_id = htmlentities( urldecode($mno_id), ENT_QUOTES, 'utf-8' );
    $uni_id_name = htmlentities( urldecode($uni_id_name), ENT_QUOTES, 'utf-8' );
  $oth_name = 'Location/Realm ID';

    $mno_time_zone_query =$db->selectDB(sprintf("SELECT `timezones` FROM `exp_mno` WHERE `mno_id`  = '%s'",$mno_id));

    foreach ($mno_time_zone_query['data'] as $row) {

        $mno_time_zone=$row['timezones'];

    }


    $dtz = new DateTimeZone($mno_time_zone);
    $time_in_sofia = new DateTime('now', $dtz);


    $offset1 = $dtz->getOffset($time_in_sofia);
    $offset = formatOffset($offset1);

 $query_code_csv_string = "SELECT
  d.parent_id AS 'Business ID',
  d.`property_id` AS '$uni_id_name',
  d.`verification_number` AS '$oth_name',
  d.`product_name` AS 'Account Type', 
  d.`account_name` AS 'Business Account Name', 
  u.`email` AS 'Business Account Email', 
  d.`advanced_features` AS 'Advanced Features', 
  ic.`icome_values` AS 'ICOMS VALUES', 
  d.`network_type` AS 'Package Type', 
  d.`private_gateway_type` AS 'Private Gateway Type',
  d.`wag_profile` AS 'WAG info',
  dg.`description` AS 'Description',  
  pr.`product_name` AS 'Guest QoS Profile',  
  du.`profile_name` AS 'Duration Profile',  
  d.`zone_id` AS 'Zone ID',
  z.`name` AS 'Zone Name',
  d.`gateway_type` AS 'Guest Gateway Type',
  d.`ap_controller` AS 'AP Controller',
  d.`sw_controller` AS 'SW Controller',
  d.`groupsid` AS 'Group ID',
  d.`distributor_name` AS 'Property Name',
  d.`bussiness_type` AS 'Business Vertical',
  d.`bussiness_address2` AS 'City',
  REPLACE(d.`bussiness_address1`,',',' ')  AS `Business Address`,
  d.`country` AS 'Country',
  d.`state_region` AS 'State/Region',
  d.`zip` AS 'Zip Code',
  d.`phone1` AS 'Phone 1',
  d.`phone2` AS 'Phone 2',
  d.`phone3` AS 'Phone 3',
  d.`time_zone` AS 'Time Zone',
  d.create_date AS 'Create Date',
  DATE_FORMAT(CONVERT_TZ(v.create_date,'$offset',d.offset_val), '%Y-%m-%d %h:%i:%s') AS 'Activation Date',
  DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(u.`activation_email_date`),'+00:00','$offset'), '%Y-%m-%d %h:%i:%s') AS `Create Date`
FROM
  (SELECT do.*,ap.product_name,pr.account_name, DATE_FORMAT(CONVERT_TZ(pr.create_date, '$offset', do.offset_val), '%Y-%m-%d %h:%i:%s') as pr_create_date FROM mno_distributor_parent pr JOIN `exp_mno_distributor` do ON do.parent_id=pr.parent_id JOIN admin_product ap ON do.system_package=ap.product_code WHERE pr.mno_id='$mno_id') d   
  LEFT JOIN admin_users u ON d.`parent_id`=u.`user_distributor` 
  LEFT JOIN `exp_distributor_groups` dg ON dg.distributor = d.distributor_code 
  LEFT JOIN (SELECT duration_prof_code,product_id,distributor_code FROM `exp_products_distributor` WHERE `network_type` = 'GUEST') gpd ON gpd.distributor_code = d.distributor_code  
  LEFT JOIN exp_products_duration du ON du.profile_code=gpd.duration_prof_code
  LEFT JOIN exp_products pr ON pr.product_id=gpd.product_id
  LEFT JOIN (SELECT GROUP_CONCAT(i.icom SEPARATOR '/') AS icome_values ,i.distributor  FROM exp_icoms i GROUP BY i.`distributor`) ic ON ic.distributor = d.distributor_code 
  LEFT JOIN admin_users_varification v ON u.user_name = v.`user_name`
  LEFT JOIN `exp_distributor_zones` z ON z.zoneid=d.zone_id AND d.ap_controller = z.`ap_controller`
WHERE
  u.is_enable <>'2' GROUP BY d.verification_number  ,d.`parent_id` ORDER BY d.`parent_id` ASC";

/*
  $query_code_csv = sprintf($query_code_csv_string,GetSQLValueString($uni_id_name,'text'),GetSQLValueString($mno_id,'text'));*/

	$filename_csv = 'BI_Property_Export_'.date(ymdHis).'';

    $execute = $exp->downloadCSV_query($query_code_csv_string, $filename_csv, $uni_id_name,$oth_name);
    

}
else if($request_data_arrya['task']=='all_distributor_pending_list_icoms'){
	$mno_id=$request_data_arrya['mno_id'];
	$uni_id_name=$request_data_arrya['uni_id_name'];
	$mno_id = htmlentities( urldecode($mno_id), ENT_QUOTES, 'utf-8' );
    $uni_id_name = htmlentities( urldecode($uni_id_name), ENT_QUOTES, 'utf-8' );
    $oth_name = 'Location/Realm ID';



    $mno_time_zone_query =$db->selectDB(sprintf("SELECT `timezones` FROM `exp_mno` WHERE `mno_id`  = '%s'",$mno_id));

    foreach ($mno_time_zone_query['data'] as $row) {

        $mno_time_zone=$row['timezones'];

    }


    $dtz = new DateTimeZone($mno_time_zone);
    $time_in_sofia = new DateTime('now', $dtz);


    $offset1 = $dtz->getOffset($time_in_sofia);
    $offset = formatOffset($offset1);

$query_code_csv_string = "SELECT
  d.parent_id AS 'Business ID',
  d.`property_id` AS '$uni_id_name',
  d.`verification_number` AS '$oth_name',
  d.`product_name` AS 'Account Type', 
  d.`account_name` AS 'Business Account Name', 
  d.`email` AS 'Business Account Email', 
  d.`advanced_features` AS 'Advanced Features', 
  ic.`icome_values` AS 'ICOMS VALUES', 
  d.`network_type` AS 'Package Type', 
  d.`private_gateway_type` AS 'Private Gateway Type',
  d.`wag_profile` AS 'WAG info',
  dg.`description` AS 'Description',  
  pr.`product_name` AS 'Guest QoS Profile',  
  du.`profile_name` AS 'Duration Profile',  
  d.`zone_id` AS 'Zone ID',
  z.`name` AS 'Zone Name',
  d.`gateway_type` AS 'Guest Gateway Type',
  d.`ap_controller` AS 'AP Controller',
  d.`sw_controller` AS 'SW Controller',
  d.`groupsid` AS 'Group ID',
  d.`distributor_name` AS 'Property Name',
  d.`bussiness_type` AS 'Business Vertical',
  d.`bussiness_address2` AS 'City',
  REPLACE(d.`bussiness_address1`,',',' ')  AS `Business Address`,
  d.`country` AS 'Country',
  d.`state_region` AS 'State/Region',
  d.`zip` AS 'Zip Code',
  d.`phone1` AS 'Phone 1',
  d.`phone2` AS 'Phone 2',
  d.`phone3` AS 'Phone 3',
  d.`time_zone` AS 'Time Zone',
  d.create_date AS 'Create Date'
FROM
  (select tt1.* from (select u.email,t0.*
from (SELECT do.*,
                   ap.product_name,
                   pr.account_name,
                   DATE_FORMAT(CONVERT_TZ(pr.create_date, '+05:30', do.offset_val),
                               '%Y-%m-%d %h:%i:%s') as pr_create_date
            FROM `exp_mno_distributor` do
                     LEFT JOIN mno_distributor_parent pr ON do.parent_id = pr.parent_id
                     JOIN admin_product ap ON do.system_package = ap.product_code
            WHERE pr.mno_id = '$mno_id') t0
               LEFT JOIN admin_users u
                         ON t0.parent_id = u.user_distributor AND u.is_enable = 2
      WHERE u.user_name IS NOT NULL) tt1 LEFT JOIN (select u.email,t0.*
                                                    from (SELECT do.*,
                                                                 ap.product_name,
                                                                 pr.account_name,
                                                                 DATE_FORMAT(CONVERT_TZ(pr.create_date, '+05:30', do.offset_val),
                                                                             '%Y-%m-%d %h:%i:%s') as pr_create_date
                                                          FROM `exp_mno_distributor` do
                                                                   LEFT JOIN mno_distributor_parent pr ON do.parent_id = pr.parent_id
                                                                   JOIN admin_product ap ON do.system_package = ap.product_code
                                                          WHERE pr.mno_id = '$mno_id') t0
                                                             LEFT JOIN admin_users u
                                                                       ON t0.parent_id = u.user_distributor AND u.is_enable <> 2
                                                    WHERE u.user_name IS NOT NULL) tt2 ON tt1.parent_id=tt2.parent_id WHERE tt2.parent_id IS NULL) d 
   
  LEFT JOIN `exp_distributor_groups` dg ON dg.distributor = d.distributor_code 
  LEFT JOIN (SELECT duration_prof_code,product_id,distributor_code FROM `exp_products_distributor` WHERE `network_type` = 'GUEST') gpd ON gpd.distributor_code = d.distributor_code  
  LEFT JOIN exp_products_duration du ON du.profile_code=gpd.duration_prof_code
  LEFT JOIN exp_products pr ON pr.product_id=gpd.product_id
  LEFT JOIN (SELECT GROUP_CONCAT(i.icom SEPARATOR '/') AS icome_values ,i.distributor  FROM exp_icoms i GROUP BY i.`distributor`) ic ON ic.distributor = d.distributor_code
  LEFT JOIN `exp_distributor_zones` z ON z.zoneid=d.zone_id  AND d.ap_controller = z.`ap_controller`
 
  GROUP BY d.verification_number, d.`parent_id` ORDER BY d.`parent_id` ASC";

 /* $query_code_csv = sprintf($query_code_csv_string,GetSQLValueString($uni_id_name,'text'),GetSQLValueString($mno_id,'text'));*/

	$filename_csv = 'BI_Pending_Property_Export_'.date(ymdHis).'';

    $execute = $exp->downloadCSV_query($query_code_csv_string, $filename_csv, $uni_id_name,$oth_name);
    

}
else if($request_data_arrya['task']=='all_distributor_pending_list'){
  $mno_id=$request_data_arrya['mno_id'];
  $uni_id_name=$request_data_arrya['uni_id_name'];
  $mno_id = htmlentities( urldecode($mno_id), ENT_QUOTES, 'utf-8' );
  $uni_id_name = htmlentities( urldecode($uni_id_name), ENT_QUOTES, 'utf-8' );


    $mno_time_zone_query =$db->selectDB(sprintf("SELECT `timezones` FROM `exp_mno` WHERE `mno_id`  = '%s'",$mno_id));

    foreach ($mno_time_zone_query['data'] as $row) {
      
      $mno_time_zone=$row['timezones'];
      
    }


    $dtz = new DateTimeZone($mno_time_zone);
            $time_in_sofia = new DateTime('now', $dtz);
         
          
            $offset1 = $dtz->getOffset($time_in_sofia);
      $offset = formatOffset($offset1);
     
  $query_code_csv_string = "SELECT
  d.`parent_id` AS 'Business ID',
  d.`account_name` AS 'Business Account Name',
  u.`email` AS 'Business Account Email',  
  d.`verification_number` AS '$uni_id_name',
  d.`zone_id` AS 'Zone ID',
  z.`name` AS 'Zone Name',
  d.`gateway_type` AS 'Gateway',
  d.`ap_controller` AS 'AP Controller',
  d.`sw_controller` AS 'SW Controller',
  pd.`product_name` AS 'Guest QoS Profile',
  du.`profile_name` AS 'Duration Profile', 
  d.`hardware_installed` AS 'Hardware Installed',
  d.`groupsid` AS 'Group ID',
  d.`property_id` AS 'Unique Property ID',
  d.`distributor_name` AS 'Property Name',
  d.`bussiness_type` AS 'Business Vertical',
  d.`bussiness_address2` AS 'City',
  REPLACE(d.`bussiness_address1`,',',' ')  AS `Business Address`,
  d.`country` AS 'Country',
  d.`state_region` AS 'State/Region',
  d.`zip` AS 'Zip Code',
  d.`phone1` AS 'Phone 1',
  d.`phone2` AS 'Phone 2',
  d.`phone3` AS 'Phone 3',
  d.`time_zone` AS 'Time Zone',
  d.advanced_features,
  d.other_settings,
  d.features,
  d.dpsk_voucher,
  d.network_type,
  group_concat(DISTINCT ems.switch_code SEPARATOR '/') AS Switches,
  group_concat(DISTINCT REPLACE(emda.ap_code,'-',':') SEPARATOR '/') AS APs,
 DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(u.`activation_date`),'+00:00','$offset'), '%Y-%m-%d %h:%i:%s') AS `Activation Date`
FROM
  `exp_distributor_zones` z RIGHT JOIN
  (SELECT do.*,pr.`account_name`,pr.features FROM mno_distributor_parent pr JOIN `exp_mno_distributor` do ON do.parent_id=pr.parent_id WHERE pr.mno_id='$mno_id') d ON z.zoneid=d.zone_id AND d.ap_controller = z.`ap_controller`
  LEFT JOIN admin_users u ON d.`parent_id`=u.`user_distributor`
  LEFT JOIN (SELECT duration_prof_code,product_id,distributor_code FROM `exp_products_distributor` WHERE `network_type` = 'GUEST') gpd ON   d.distributor_code= gpd.distributor_code
  LEFT JOIN exp_products_duration du ON gpd.duration_prof_code=du.profile_code
  LEFT JOIN exp_products pd ON gpd.product_id=pd.product_id
  LEFT JOIN exp_mno_switchs ems ON d.distributor_code = ems.distributor_code
  LEFT JOIN exp_mno_distributor_aps emda ON emda.distributor_code=d.distributor_code
WHERE
  u.is_enable ='2' AND u.verification_number IS NOT NULL GROUP BY d.distributor_code ORDER BY d.`parent_id` ASC";

  //$query_code_csv = sprintf($query_code_csv_string,GetSQLValueString($uni_id_name,'text'),GetSQLValueString($mno_id,'text'));


      $filename_csv = 'BI_Pending_Property_Export_'.date(ymdHis).'';
    $ex_data = $db->selectDB($query_code_csv_string);
    $features_list=['CLOUD_PATH_DPSK','DPSK','VOUCHER','AD_PROFILE','CAMPAIGN_MODULE','PAYMENT_GATEWAY_NEW','other_multi_area','802.2x_authentication','dpsk'];

    $dist_datas = $ex_data['data'];
    foreach ($dist_datas as $data_key=> $dist_data){

        $mvno_network_type = explode('-',$dist_data['network_type']);
        unset($dist_data['network_type']);

        $mvno_voucher_type = $dist_data['dpsk_voucher'];
        unset($dist_data['dpsk_voucher']);

        $mvno_fe = json_decode($dist_data['advanced_features'],true);
        unset($dist_data['advanced_features']);

        $mvno_oth = json_decode($dist_data['other_settings'],true);
        unset($dist_data['other_settings']);

        $parent_fe = json_decode($dist_data['features'],true);
        unset($dist_data['features']);

        ////
        $dist_data['Multi Service Area'] = array_key_exists($features_list[6],$mvno_oth)&&$mvno_oth[$features_list[6]]==1?'On':'Off';
        $dist_data['Voucher'] = array_key_exists($features_list[2],$parent_fe)?'On/'.$mvno_voucher_type:'Off';
        $dist_data['802.2x Authentication'] = array_key_exists($features_list[7],$mvno_fe)&&$mvno_fe[$features_list[7]]==1?'On':'Off';
        $dist_data['DPSK'] = array_key_exists($features_list[1],$parent_fe)?'On':'Off';
        $dist_data['Cloudpath DPSK'] = array_key_exists($features_list[0],$parent_fe)?'On':'Off';
        $dist_data['Vtenant'] = $mvno_network_type[0]=='VT'?'On':'Off';
        $dist_data['Payment Gateway Support'] = array_key_exists($features_list[5],$parent_fe)?'On':'Off';
        $dist_data['AD Profile Support'] = array_key_exists($features_list[3],$parent_fe)?'On':'Off';

        //$dist_data['Campaign Module'] = array_key_exists($features_list[4],$parent_fe)?'On':'Off';

        //$dist_data['Property DPSK'] = array_key_exists($features_list[8],$mvno_fe)&&$mvno_fe[$features_list[8]]==1?'On':'Off';


        $dist_datas[$data_key]=$dist_data;

    }

    //$execute = $exp->downloadCSV($query_code_csv_string, $filename_csv);
    $exp->downloadCSVwithJson(json_encode($dist_datas),$filename_csv);

  
    

}
else if($request_data_arrya['task']=='all_distributor_list'){
  $mno_id=$request_data_arrya['mno_id'];
  $uni_id_name=$request_data_arrya['uni_id_name'];
  $mno_id = htmlentities( urldecode($mno_id), ENT_QUOTES, 'utf-8' );
    $uni_id_name = htmlentities( urldecode($uni_id_name), ENT_QUOTES, 'utf-8' );


    $mno_time_zone_query =$db->selectDB(sprintf("SELECT `timezones` FROM `exp_mno` WHERE `mno_id`  = '%s'",$mno_id));

    foreach ($mno_time_zone_query['data'] as $row) {
      
      $mno_time_zone=$row['timezones'];
      
    }


    $dtz = new DateTimeZone($mno_time_zone);
            $time_in_sofia = new DateTime('now', $dtz);
         
          
            $offset1 = $dtz->getOffset($time_in_sofia);
      $offset = formatOffset($offset1);
      

 

  $query_code_csv_string = "SELECT
  d.`parent_id` AS 'Business ID',
  d.`account_name` AS 'Business Account Name',
  u.`email` AS 'Business Account Email',  
  d.`verification_number` AS '$uni_id_name',
  d.`zone_id` AS 'Zone ID',
  z.`name` AS 'Zone Name',
  d.`gateway_type` AS 'Gateway',
  d.`ap_controller` AS 'AP Controller',
  d.`sw_controller` AS 'SW Controller',
  pd.`product_name` AS 'Guest QoS Profile',
  du.`profile_name` AS 'Duration Profile', 
  d.`groupsid` AS 'Group ID',
  d.`property_id` AS 'Unique Property ID',
  d.`distributor_name` AS 'Property Name',
  d.`bussiness_type` AS 'Business Vertical',
  d.`bussiness_address2` AS 'City',
  REPLACE(d.`bussiness_address1`,',',' ')  AS `Business Address`,
  d.`country` AS 'Country',
  d.`state_region` AS 'State/Region',
  d.`zip` AS 'Zip Code',
  d.`phone1` AS 'Phone 1',
  d.`phone2` AS 'Phone 2',
  d.`phone3` AS 'Phone 3',
  d.`time_zone` AS 'Time Zone', 
  d.advanced_features,
  d.other_settings,
  d.features,
  d.dpsk_voucher,
  d.network_type,
  DATE_FORMAT(CONVERT_TZ(u.`create_date`,'+00:00','$offset'), '%Y-%m-%d %h:%i:%s') AS cr_date,
  group_concat(DISTINCT ems.switch_code SEPARATOR '/') AS Switches,
  group_concat(DISTINCT REPLACE(emda.ap_code,'-',':') SEPARATOR '/') AS APs,
 DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(u.`activation_date`),'+00:00','$offset'), '%Y-%m-%d %h:%i:%s') AS `Activation Date`,
 DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(u.`activation_email_date`),'+00:00','$offset'), '%Y-%m-%d %h:%i:%s') AS `Create Date`
FROM
  `exp_distributor_zones` z RIGHT JOIN
  (SELECT do.*,pr.`account_name`,pr.features FROM mno_distributor_parent pr JOIN `exp_mno_distributor` do ON do.parent_id=pr.parent_id WHERE pr.mno_id='$mno_id') d ON z.zoneid=d.zone_id AND d.ap_controller = z.`ap_controller`
  LEFT JOIN admin_users u ON d.`parent_id`=u.`user_distributor`
  LEFT JOIN (SELECT duration_prof_code,product_id,distributor_code FROM `exp_products_distributor` WHERE `network_type` = 'GUEST') gpd ON   d.distributor_code= gpd.distributor_code
  LEFT JOIN exp_products_duration du ON gpd.duration_prof_code=du.profile_code
  LEFT JOIN exp_products pd ON gpd.product_id=pd.product_id
  LEFT JOIN exp_mno_switchs ems ON d.distributor_code = ems.distributor_code
  LEFT JOIN exp_mno_distributor_aps emda ON emda.distributor_code=d.distributor_code
WHERE
  u.is_enable <>'2' AND u.verification_number IS NOT NULL GROUP BY d.distributor_code ORDER BY d.`parent_id` ASC";

  //$query_code_csv = sprintf($query_code_csv_string,GetSQLValueString($uni_id_name,'text'),GetSQLValueString($mno_id,'text'));

  $filename_csv = 'BI_Property_Export_'.date(ymdHis).'';
  $ex_data = $db->selectDB($query_code_csv_string);
  $features_list=['CLOUD_PATH_DPSK','DPSK','VOUCHER','AD_PROFILE','CAMPAIGN_MODULE','PAYMENT_GATEWAY_NEW','other_multi_area','802.2x_authentication','dpsk'];

  $dist_datas = $ex_data['data'];
  foreach ($dist_datas as $data_key=> $dist_data){

      if(strlen($dist_data['Create Date'])<1){
        $dist_data['Create Date'] = $dist_data['cr_date'];
      }

      unset($dist_data['cr_date']);
      $mvno_network_type = explode('-',$dist_data['network_type']);
      unset($dist_data['network_type']);

      $mvno_voucher_type = $dist_data['dpsk_voucher'];
      unset($dist_data['dpsk_voucher']);

      $mvno_fe = json_decode($dist_data['advanced_features'],true);
      unset($dist_data['advanced_features']);

      $mvno_oth = json_decode($dist_data['other_settings'],true);
      unset($dist_data['other_settings']);

      $parent_fe = json_decode($dist_data['features'],true);
      unset($dist_data['features']);


      ////
      $dist_data['Multi Service Area'] = array_key_exists($features_list[6],$mvno_oth)&&$mvno_oth[$features_list[6]]==1?'On':'Off';
      $dist_data['Voucher'] = array_key_exists($features_list[2],$parent_fe)?'On/'.$mvno_voucher_type:'Off';
      $dist_data['802.2x Authentication'] = array_key_exists($features_list[7],$mvno_fe)&&$mvno_fe[$features_list[7]]==1?'On':'Off';
      $dist_data['DPSK'] = array_key_exists($features_list[1],$parent_fe)?'On':'Off';
      $dist_data['Cloudpath DPSK'] = array_key_exists($features_list[0],$parent_fe)?'On':'Off';
      $dist_data['Vtenant'] = $mvno_network_type[0]=='VT'?'On':'Off';
      $dist_data['Payment Gateway Support'] = array_key_exists($features_list[5],$parent_fe)?'On':'Off';
      $dist_data['AD Profile Support'] = array_key_exists($features_list[3],$parent_fe)?'On':'Off';

      //$dist_data['Campaign Module'] = array_key_exists($features_list[4],$parent_fe)?'On':'Off';

      //$dist_data['Property DPSK'] = array_key_exists($features_list[8],$mvno_fe)&&$mvno_fe[$features_list[8]]==1?'On':'Off';


      $dist_datas[$data_key]=$dist_data;

  }

    //$execute = $exp->downloadCSV($query_code_csv_string, $filename_csv);
    $exp->downloadCSVwithJson(json_encode($dist_datas),$filename_csv);

    

}
else if($request_data_arrya['task']=='bulk_backup'){
//echo "aa";
	$backup_id=$request_data_arrya['backup_id'];
	$backup_id = htmlentities( urldecode($backup_id), ENT_QUOTES, 'utf-8' );

	$backup_id = $db->escapeDB($backup_id);

	$query_code = "SELECT c.first_name,c.last_name,c.email,c.username,c.`password`,c.first_login_date,c.last_login_date,c.property_id,c.address,c.city,c.country,c.phone,c.service_profile,c.profile_type, DATE_FORMAT(FROM_UNIXTIME(c.`valid_from`), '%Y-%m-%d %h:%i:%s') AS valid_from, DATE_FORMAT(FROM_UNIXTIME(c.`valid_until`), '%Y-%m-%d %h:%i:%s') AS valid_until,group_concat( DISTINCT d.mac_address) AS `Sub Accounts`
					FROM mdu_customer_backup c LEFT JOIN mdu_customer_devices_backup d 
					ON c.email=d.email_address AND d.delete_id='$backup_id' WHERE c.delete_id='$backup_id'  GROUP BY c.email";
    $filename = 'MDU_Tenant_Backup_'.date(ymdHis).'';
    

    $execute = $exp->downloadCSV($query_code, $filename);
}
elseif($request_data_arrya['task']=='vt' || $request_data_arrya['task']=='mdu'){
  $searchid = $request_data_arrya['searchid'];
  $find_customers =$db->selectDB(sprintf("SELECT customer_list FROM `mdu_search_id` WHERE id = '%s'",$searchid));
  foreach ($find_customers['data'] as $row) {
      
    $customer_list=$row['customer_list'];
    
  }
 $query_code = "SELECT IF(CEIL(`first_name`),CONCAT('\'',`first_name`),`first_name`) AS First_Name,      IF(CEIL(`last_name`),CONCAT('\'',`last_name`),`last_name`) AS Last_Name,`email` AS Email,c.`username` AS User_Name,
    (SELECT o.`property_id` FROM `mdu_organizations` o WHERE o.property_number = c.`property_id` LIMIT 1) AS Group_Name,
    c.`property_id` as Group_Number, c.`vlan_id` as Vlan_ID, count(d.`mac_address`) AS Devices_Count,
    IF(CEIL(`address`),CONCAT('',`address`),`address`) AS Address, IF(CEIL(`city`),CONCAT('\'',`city`),`city`) AS City,`state` AS State,
    `country` AS Country,`phone` AS Mobile_Number,
    DATE_FORMAT(FROM_UNIXTIME(`valid_from`), '%Y-%m-%d %h:%i:%s') AS Account_Creation_Date,
    DATE_FORMAT(FROM_UNIXTIME(`valid_until`), '%Y-%m-%d %h:%i:%s') AS Accoutn_Expiration_Date
    FROM `mdu_vetenant` c LEFT JOIN `mdu_customer_devices` d ON c.`customer_id`= d.`customer_id` AND c.`username` = d.`user_name` WHERE c.`customer_id` IN ($customer_list) GROUP BY c.`customer_id` ORDER BY c.first_name ASC";
    $filename = 'MDU_Customer_Export_'.date(ymdHis).'';
    $execute = $exp->downloadCSV($query_code, $filename);

}
elseif($request_data_arrya['task']=='bulk_passcode'){

    

        $bulk_id = $request_data_arrya['bulk_id'];
        
      
        $query_code = "SELECT `voucher_number` FROM `exp_customer_vouchers` WHERE `bulk_id` = '$bulk_id'";
          $filename = 'Bulk_Passscode'.date(ymdHis).'';
      
          $execute = $exp->downloadCSV($query_code, $filename);    
}
elseif($request_data_arrya['task']=='csv_error'){
    $json = cryptoJsAesDecrypt($data_secret, $_POST['errors']);
        //$json = $request_data_arrya['error_json'];
        
        $filename = 'Account_Errors-'.date(ymdHis).'';
      
        $execute = $exp->downloadCSVwithJson($json, $filename,1);    
}
else if($request_data_arrya['task']=='session_mdu'){

    $searchid = $request_data_arrya['searchid'];

    $passed_array = $_SESSION['mac_array'];

		//unset($_SESSION['mac_array']);
		$mac_nums='\''.$passed_array[0];
		for ($i = 1; $i < count($passed_array); $i++) {
			$mac_nums = $mac_nums . '\',\'' . $passed_array[$i];
		}
		$mac_nums=$mac_nums.'\'';

		/* $query_code = "SELECT `mac` AS 'MAC',`account_state` AS 'Session State',`user_name` AS 'AAA-User-Name',DATE_FORMAT(FROM_UNIXTIME(`start_time`/1000), '%Y-%m-%d %h:%i:%s') AS 'Start Time',`duration` AS Duration,`idle_time` AS 'Idle Time',
		`device_type` AS 'Device Type',`sender_type` AS 'GW Type' FROM
                  `mdu_customer_sessions` WHERE `mac` IN($mac_nums)"; */

		$query_code = "SELECT `mac` AS 'MAC',`account_state` AS 'Session State',`user_name` AS 'AAA-User-Name',DATE_FORMAT(FROM_UNIXTIME(`start_time`/1000), '%Y-%m-%d %h:%i:%s') AS 'Start Time',IF (SEC_TO_TIME(`duration`) > 0, IF( HOUR(SEC_TO_TIME(`duration`))>0, CONCAT(HOUR(SEC_TO_TIME(`duration`)),'h ',MINUTE(SEC_TO_TIME(`duration`)),'m ',SECOND(SEC_TO_TIME(`duration`)),'s'),CONCAT(MINUTE(SEC_TO_TIME(`duration`)),'m ',SECOND(SEC_TO_TIME(`duration`)),'s')  ),'0' ) AS Duration,IF (SEC_TO_TIME(`idle_time`) > 0, IF( HOUR(SEC_TO_TIME(`idle_time`))>0, CONCAT(HOUR(SEC_TO_TIME(`idle_time`)),'h ',MINUTE(SEC_TO_TIME(`idle_time`)),'m ',SECOND(SEC_TO_TIME(`idle_time`)),'s'),CONCAT(MINUTE(SEC_TO_TIME(`idle_time`)),'m ',SECOND(SEC_TO_TIME(`idle_time`)),'s')  ),'0' )
 AS 'Idle Time',
		`device_type` AS 'Device Type',`sender_type` AS 'GW Type' FROM
                  `mdu_customer_sessions` WHERE `mac` IN($mac_nums)";
        $filename = 'MDU_Customer\'s_Sessions_Export_' . date("-d-m-Y_h:i:s") . '';
        

        $execute = $exp->downloadCSV($query_code, $filename);

}
else if($request_data_arrya['task']=='bulk_passcode'){

    $bulk_id = $request_data_arrya['bulk_id'];

		$query_code = "SELECT voucher_number FROM `exp_customer_vouchers` WHERE `bulk_id` = '$bulk_id'";
        $filename = 'Bulk_Passscode_' . date("-d-m-Y_h:i:s") . '';
        

        $execute = $exp->downloadCSV($query_code, $filename);

}

else if($request_data_arrya['task']=='all_blacklist'){


    $mno_id=$request_data_arrya['mno_id'];
    $mno_id = htmlentities( urldecode($mno_id), ENT_QUOTES, 'utf-8' );

    $useradmin=$request_data_arrya['user'];
    $useradmin = htmlentities( urldecode($useradmin), ENT_QUOTES, 'utf-8' );

    //$base_url = trim($db->setVal('portal_base_url',$dist));
    //$base_url = "sssss";

    $query_code_string = "SELECT CONCAT(LEFT(mac,2), ':',SUBSTRING(mac,3,2), ':' , SUBSTRING(mac,5,2),
        ':',SUBSTRING(mac,7,2), ':',SUBSTRING(mac,9,2), ':', 
       RIGHT(mac,2))  AS DEVICE_MAC,
         DATE_FORMAT(FROM_UNIXTIME(`bl_timestamp`), '%Y-%m-%d %h:%i:%p') AS BLACKLIST_DATE,
         `period_view` AS SUSPENSION,
         IF(`period`='indefinite','NA',DATE_FORMAT(FROM_UNIXTIME(`wl_timestamp`), '%Y-%m-%d %h:%i:%p')) AS WHITELIST_DATE
         FROM exp_customer_blacklist WHERE mno = '$mno_id'" ;

    // $query_code = sprintf($query_code_string,GetSQLValueString($mno_id,'text'));
    if ($useradmin=='cox') {
      $filename = 'BlockedMACs';
    }
    else{
      $filename = 'blacklist';
          }

    

    $execute = $exp->downloadXL($query_code_string, $filename);

}
else if($request_data_arrya['task']=='aup_data'){


    $mno_id=$request_data_arrya['mno_id'];
    $mno_id = htmlentities( urldecode($mno_id), ENT_QUOTES, 'utf-8' );

    $query_code_string = "SELECT v.`username` AS 'USER NAME',v.`first_name` AS 'FIRST NAME',v.`last_name` AS 'LAST NAME',v.`email` AS 'EMAIL',v.`property_id` AS 'REALM',v.`first_login_date` AS 'LOGIN DATE',v.`warning_message` AS 'WARNING MESSAGE',v.`violation` AS 'VIOLATION COUNT' FROM `mdu_vetenant` v,`mdu_distributor_organizations` m, `exp_mno_distributor` d  WHERE m.`property_id`=v.`property_id` AND d.`distributor_code`=m.`distributor_code` AND `mno_id`='$mno_id' 
        ORDER BY first_name ASC";

      $filename = 'aup_violation';
    

    $execute = $exp->downloadXL($query_code_string, $filename);

}
else if($request_data_arrya['task']=='all_sessions'){


    $realm=$request_data_arrya['realm'];
    $session_profile=$request_data_arrya['session_profile'];
    $network_name=$request_data_arrya['network_name'];
    $internal_url=$request_data_arrya['internal_url'];
    $realm = htmlentities( urldecode($realm), ENT_QUOTES, 'utf-8' );
    $session_profile = htmlentities( urldecode($session_profile), ENT_QUOTES, 'utf-8' );
    $network_name = htmlentities( urldecode($network_name), ENT_QUOTES, 'utf-8' );
    $internal_url = htmlentities( urldecode($internal_url), ENT_QUOTES, 'utf-8' );
    $user_distributor = htmlentities( urldecode($request_data_arrya['user_distributor']), ENT_QUOTES, 'utf-8' );

    $mno_product = $db->getValueAsf("SELECT m.system_package AS f FROM exp_mno m JOIN exp_mno_distributor emd on m.mno_id = emd.mno_id WHERE distributor_code='$user_distributor'");

    require_once('../src/sessions/'.$session_profile.'/index.php');
    $ale=new session_profile($network_name,$session_profile,$internal_url,$mno_product);

    $result=$ale->getSessionsbyrealm($realm,$tome_zone);
    $dataarr = json_decode($result,true);
    $bulk_session_data=array_values($dataarr['Description']);
    $jsonarr=json_encode($bulk_session_data);

    $filename = 'Session_Export_'.date(ymdHis).'';    

    $execute = $exp->downloadCSVwithJson($jsonarr, $filename);

}
else{
	
	
$dist = $request_data_arrya['dist'];
$product_code = $request_data_arrya['product_code'];

$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );

	//$base_url = trim($db->setVal('portal_base_url',$dist));
    //$base_url = "sssss";
    
    /* $query_code_string = "SELECT IF(first_name IS NULL OR first_name='','N/A',first_name) AS first_name,IF(last_name IS NULL OR last_name='','N/A',last_name) AS last_name,IF(mac IS NULL OR mac='','N/A',mac) AS mac,IF(email IS NULL OR email='','N/A',email) AS email,IF(mobile_number IS NULL OR mobile_number='','N/A',mobile_number) AS mobile_number,IF(gender IS NULL OR gender='','N/A',gender) AS gender,IF(proffession IS NULL OR proffession='','N/A',proffession) AS Profession,IF(login_media IS NULL OR login_media='','N/A',login_media) AS login_media,IF(social_media_id IS NULL OR social_media_id='','N/A',social_media_id) AS social_media_id,IF(social_media_url IS NULL OR social_media_url='','N/A',social_media_url) AS social_media_url,IF(birthday IS NULL,'N/A',birthday) AS birthday,IF(age_group = 'all','N/A',REPLACE(age_group,'_','-')) AS age_group,IF(street IS NULL,'N/A',street) AS street,IF(city IS NULL OR city='','N/A',city) AS city,IF(current_city IS NULL OR current_city='','N/A',current_city) AS current_city,IF(zip IS NULL,'N/A',zip) AS zip,IF(state IS NULL,'N/A',state) AS state,IF(country IS NULL OR country='','N/A',country) AS country,IF(current_country IS NULL OR current_country='','N/A',current_country) AS current_country,IF(timezone IS NULL,'N/A',timezone) AS timezone,first_login_date,last_login_date
	FROM exp_customer c, exp_customer_session s
		WHERE c.customer_id = s.customer_id
		AND s.location_id = %s
		AND s.session_status = '2'
				group by c.customer_id" ; */
if($product_code=='YES'){
  $value_access = $request_data_arrya['value_access'];
    $newarray=json_decode($value_access,true);
    //$aa=array();
    $spo = false;
    $advanced = json_decode($db->getValueAsf("SELECT advanced_features AS f FROM exp_mno_distributor WHERE distributor_code='$dist'"),true);
    if(array_key_exists('SPONSORED', $advanced) && $advanced['SPONSORED']==1){
      $spo = true;
    }

  if($package_functions->getOptions('CUSTOMER_REPORT_BY_TIMEZONE',$system_package)=="ENABLED"){
    date_default_timezone_set('Pacific/Chatham');
    $log_time_zone=$db->getValueAsf("SELECT `time_zone` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$dist'");

    $result = "";
    foreach ($newarray as $key => $value) {
        $value = ucwords(strtolower($value));
      if (strtoupper($value)==strtoupper('First Login Date')) {
        //$aa="FROM_UNIXTIME(first_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `".$value."`,";
        $aa="first_login_unixtimestamp AS `".$value."`,";
        $result .= $aa;
      }
      elseif (strtoupper($value)==strtoupper('Last Login Date')) {
        //$aa="FROM_UNIXTIME(last_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `".$value."`,";
        $aa="last_login_unixtimestamp AS `".$value."`,";
        $result .= $aa;
      }
      elseif (strtoupper($value)==strtoupper('Type')) {
        $aa="'Guest' AS `".$value."`,";
        $result .= $aa;
      }elseif (strtoupper($value)==strtoupper('Age Group')) {
        $aa="IF(age_group = 'all','N/A',REPLACE(age_group,'_','-')) AS `".$value."`,";
        $result .= $aa;
      }
      else{
        if($key=="zip_code"){
          if($spo){
            $key = 'c.zip';
          }else{
            continue;
          }
        }
        if($key == 'zip'){$key = 'd.zip';}
        $aa=$key.' AS '.$value.',';
        $aa="IF(".$key." IS NULL OR ".$key."='','N/A',".$key.") AS `".$value."`,";
        $result .= $aa;
      }
      //$test=$key.' As '.$value.','.$testarr;
      //array_push($testarr,$aa);
      //array_push($aa);
    }
                     
    $result1=rtrim($result,',');
    
    $query_code_string = "SELECT $result1
    FROM exp_customer c, exp_customer_session s, exp_mno_distributor d
      WHERE c.customer_id = s.customer_id
      AND s.`location_id` = d.`distributor_code` 
      AND s.location_id = '$dist'
      AND s.session_status IN ('1','2')
          group by c.customer_id ORDER BY s.id DESC" ;

  	$ex_data = $db->selectDB($query_code_string);
    $dist_data_arr = $ex_data['data'];
    foreach ($dist_data_arr as $data_key=> $dist_data){

        $first_login_unixtimestamp = $dist_data['First Login Date'];
        if($first_login_unixtimestamp!="N/A"){
          $dt = new DateTime("@$first_login_unixtimestamp");
          $dt->setTimezone(new DateTimeZone($log_time_zone));
          $display_value=$dt->format('Y-m-d h:i:s A');
          $dist_data_arr[$data_key]['First Login Date']=$display_value;
        }

        $last_login_unixtimestamp = $dist_data['Last Login Date'];
        if($last_login_unixtimestamp!="N/A"){
          $dt = new DateTime("@$last_login_unixtimestamp");
          $dt->setTimezone(new DateTimeZone($log_time_zone));
          $display_value=$dt->format('Y-m-d h:i:s A');
          $dist_data_arr[$data_key]['Last Login Date']=$display_value;
        }
      
    }

    $filename = 'export_customer';
    $execute = $exp->downloadCSVwithJson(json_encode($dist_data_arr),$filename);
  }else{
   $result = "";
    foreach ($newarray as $key => $value) {
        $value = ucwords(strtolower($value));
      if (strtoupper($value)==strtoupper('First Login Date')) {
        //$aa="FROM_UNIXTIME(first_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `".$value."`,";
        $aa="FROM_UNIXTIME(first_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `".$value."`,";
        $result .= $aa;
      }
      elseif (strtoupper($value)==strtoupper('Last Login Date')) {
        //$aa="FROM_UNIXTIME(last_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `".$value."`,";
        $aa="FROM_UNIXTIME(last_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `".$value."`,";
        $result .= $aa;
      }
      elseif (strtoupper($value)==strtoupper('Type')) {
        $aa="'Guest' AS `".$value."`,";
        $result .= $aa;
      }elseif (strtoupper($value)==strtoupper('Age Group')) {
        $aa="IF(age_group = 'all','N/A',REPLACE(age_group,'_','-')) AS `".$value."`,";
        $result .= $aa;
      }
      else{
        if($key=="zip_code"){
          if($spo){
            $key = 'c.zip';
          }else{
            continue;
          }
        }
        if($key == 'zip'){$key = 'd.zip';}
        $aa=$key.' AS '.$value.',';
        $aa="IF(".$key." IS NULL OR ".$key."='','N/A',".$key.") AS `".$value."`,";
        $result .= $aa;
      }
      //$test=$key.' As '.$value.','.$testarr;
      //array_push($testarr,$aa);
      //array_push($aa);
    }
                     
    $result1=rtrim($result,',');
  
  //print_r($aa);
   //echo $adads=json_encode($testarr);
  
   /* JSON_ARRAY($adads)
    $key_access = $request_data_arrya['key_access'];
    $i=0;
    $testarr=array();
    foreach ($key_access as $value) {
        $i=$i+1;
           $value1=$value; 
           if ($value1!='First Login Date'||$value1!='Last Login Date') {
             $array='$if($value_access[$i] IS NULL OR $value_access[$i]='','N/A',$value_access[$i]) AS $value1[$i]';
  
           }
           IF(mac IS NULL OR mac='','N/A',mac) AS `MAC`,FROM_UNIXTIME(first_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `First Login Date`,FROM_UNIXTIME(last_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `Last Login Date`
                                                                                   
    }*/
   $query_code_string = "SELECT $result1
    FROM exp_customer c, exp_customer_session s, exp_mno_distributor d
      WHERE c.customer_id = s.customer_id
      AND s.`location_id` = d.`distributor_code` 
      AND s.location_id = '$dist'
      AND s.session_status IN ('1','2')
          group by c.customer_id ORDER BY s.id DESC" ;
          
  
   /* $query_code_string = "SELECT IF(mac IS NULL OR mac='','N/A',mac) AS `MAC`,FROM_UNIXTIME(first_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `First Login Date`,FROM_UNIXTIME(last_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `Last Login Date`
    FROM exp_customer c, exp_customer_session s
      WHERE c.customer_id = s.customer_id
      AND s.location_id = '$dist'
      AND s.session_status IN ('1','2')
          group by c.customer_id" ;*/
  
      //$query_code = sprintf($query_code_string,GetSQLValueString($dist,'text'));
  
    $filename = 'export_customer';
  
    $execute = $exp->downloadCSV($query_code_string, $filename);
  }
  
}
else
{
	$query_code_string = "SELECT IF(first_name IS NULL OR first_name='' OR first_name='Guest','N/A',first_name) AS `First Name`,IF(last_name IS NULL OR last_name='' OR last_name='User','N/A',last_name) AS `Last Name`,IF(mac IS NULL OR mac='','N/A',mac) AS `MAC`,IF(act_email IS NULL OR act_email='','N/A',act_email) AS `Email`,IF(mobile_number IS NULL OR mobile_number='','N/A',mobile_number) AS `Mobile Number`,IF(gender IS NULL OR gender='' OR gender='all','N/A',CONCAT(UCASE(MID(gender,1,1)),MID(gender,2))) AS `Gender`,IF(age_group = 'all','N/A',REPLACE(age_group,'_','-')) AS `Age Group`,IF(birthday IS NULL OR birthday='' OR birthday='0000-00-00','N/A',birthday) AS `Birthday`,IF(login_media IS NULL OR login_media='','N/A',login_media) AS `Login Media`,FROM_UNIXTIME(first_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `First Login Date`,FROM_UNIXTIME(last_login_unixtimestamp, '%Y-%m-%d %h:%i:%s:%p') AS `Last Login Date`
  FROM exp_customer c, exp_customer_session s
    WHERE c.customer_id = s.customer_id
    AND s.location_id = '$dist'
    AND s.session_status IN ('1','2')
        group by c.customer_id" ;

    //$query_code = sprintf($query_code_string,GetSQLValueString($dist,'text'));

	$filename = 'export_customer';

	$execute = $exp->downloadCSV($query_code_string, $filename);
	
}
}


function formatOffset($offset) {
  $hours = $offset / 3600;
  $remainder = $offset % 3600;
  $sign = $hours > 0 ? '+' : '-';
  $hour = (int) abs($hours);
  $minutes = (int) abs($remainder / 60);
  if ($hour == 0 AND $minutes == 0) {
      $sign = ' ';
  }
  return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');

}





?>