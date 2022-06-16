<?php 

require_once __DIR__.'../../classes/systemPackageClass.php';
$package_functions=new package_functions();
$db_class1 = new db_functions();
$network_name = $package_functions->getOptions('NETWORK_PROFILE',$mno_package[system_package]);

if(strlen($network_name) == 0){
    $network_name = $db_class1->setVal('network_name','ADMIN');
}
$network_profile=$db_class1->getValueAsf("SELECT api_network_auth_method as f FROM exp_network_profile WHERE network_profile='$network_name'");//$db_class1->getValueAsf("SELECT n.`api_network_auth_method` AS f FROM `exp_network_profile` n , `exp_settings` s
require_once('src/AAA/'.$network_profile.'/index.php');
$nf=new aaa($network_profile,$mno_package[system_package]);
?>