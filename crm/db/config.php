<?php
$host="localhost";  $db="bi_portal";  $user="bisys_user";  $pass="W2h6344ss458";
//localhost
// $host="localhost";  $db="crm_live";  $user="root";  $pass="123456";
$con=mysql_connect($host,$user,$pass)or die("Unable to connect Database");
mysql_select_db($db);
?>