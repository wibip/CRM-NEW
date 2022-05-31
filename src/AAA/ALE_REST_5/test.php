<?php

include_once('index.php');

$ale = new aaa;


//echo $ale->session();
$mac = '958412587536523';
$product='frontier-product-15min';
$realm='FrontierMagnusBlr';//frontier-product-15min
$account_type='new';
//Aptilo-Demo-Product-15min


$timegap='PT1M';
$email= 'man@yho.ci';

//print_r($data_array);
//echo $ale->createAccount($portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm);
//echo $ale->updateAccount($account_type,$portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm);
//echo $ale->checkAccount($mac,$realm);
//echo $ale->deleteAccount($mac,$realm);
//echo $ale->checkMacAccount($mac,$realm);
echo $ale->checkRealmAccount($realm);
//echo $ale->getAllGroup();
//echo $ale->getAllProducts($realm);
?>