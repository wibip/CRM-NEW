<?php

include_once('index.php');

$ale = new network_functions;


//echo $ale->session();
$mac = '4152415251477';
$product='frontier-product-15min';
$realm='FrontierMagnusBlr';//frontier-product-15min
$account_type='new';
$cust_uname='Frontier@kjmctharanga@gmail.com';
$username='Frontier@kjmctharanga@gmail.com';
$password='1475281@FrontierMagnusBlr';
$organization='Frontier';
$service_profile_product='frontier-product-15min';
$first_name='aaaaa';
$last_name = 'bbbb';
$email = 'sdsd@dfsf.com';
$mobile_number = '07114872584';
$user_data_string='444';
$validity_time='15';
$aup_message_text='ghsaghxgh';
$vlan_id='20';
$search_parameter1='Group';
$fname='aaaaa';
$productlist='PREMIUM,QoS,100M';


$timegap='PT1M';
$email= 'man@yho.ci';
//$property_id='Frontier';

/*$device_count=0;
$subAcc_count=0;
$query_serach_id = "UPDATE `mdu_customer` SET search_id = '0' where property_id='$property_id'";	
$result_search_id = mysql_query($query_serach_id);*/

//echo $ale->findMasterUsers("Group", "Frontier", "Email", "awaw@dd.cc");
echo $ale->getSessions('FrontierMagnusBlr','Access-Group');
//echo $ale->findUsers("Group", "Frontier");

//echo $ale->findUsersByMaster($username);
//echo $ale->findUser($username);
//echo $ale->AUP($username,$user_message_text,$aup_message_text);
//echo $ale->AUP_Activate($username);

//echo $ale->masterAcc($username,$password,$organization,$service_profile_product,$first_name,$last_name,$email,$mobile_number,$user_data_string,$validity_time);
//echo $ale->subAcc($mac,$username,$organization,$first_name,$last_name,$email,$mobile_number,$vlan_id);
//echo $ale->modifyAcc($cust_uname,$email,$password,$first_name,$last_name,$organization,$mobile_number,$user_data_string);
//echo $ale->modifyProfile($username,$productlist,$password);
//echo $ale->delUser($mac);
//echo $ale->modifyValidityTime($username,$validity_time);

//echo $ale->session();
//echo $ale->getGroup();



?>

