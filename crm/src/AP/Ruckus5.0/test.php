<?php

session_start();
$_SESSION['user_name']='MVNO5735c36513358581';

require_once '../../../classes/dbClass.php';

require_once 'index.php';
$wag_obj = new ap_wag();


$wag_obj = new ap_wag("Ruckus 5_0 Test");


//echo $ale->session();
$id='78:A6:E1:3F:B1:F6';
$zoneid='3df2fa85-83e7-4341-b9f3-9eae8bf3afd1';
$arr1 = array(array("type" => "ZONE","value" => $zoneid ));


echo $wag_obj->getSwitchesbyZone($arr1);
?>