<?php

session_start();
$_SESSION['user_name']='MVNO5735c36513358581';

require_once '../../../classes/dbClass.php';

require_once 'index.php';
$wag_obj = new ap_wag();


//echo $ale->session();
$id='233';
$zoneid='3df2fa85-83e7-4341-b9f3-9eae8bf3afd1';


echo $wag_obj->retrive802x($zoneid,$id);
?>