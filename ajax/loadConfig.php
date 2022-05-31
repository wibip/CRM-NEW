<?php 

$r_api_network_auth_method = $_GET['auth_method'];
$network_profile = $_GET['network_profile'];
$aaa_data = json_decode($_GET['aaa_data'],true);
include '../src/AAA/'.$r_api_network_auth_method.'/index.php';
$error = false;
$err_msg = 'AAA Group is not available';
$aaa = new aaa($network_profile,'ADMIN');
$zoneRes = json_decode($aaa->getAllZones(),true);
if($zoneRes['status']=='success'){
    foreach ($zoneRes['Description'] as $value) {
        if($value['Id']==$aaa_data['aaa_root_zone_id']){
            $aaa_root_zone = $value['Name'];
        }
    }
}else{
    $error = true;
}
$groupRes = json_decode($aaa->getAllGroupsNew(),true);
if($groupRes['status']=='success'){
    foreach ($groupRes['Description'] as $value) {
        if($value['Id']==$aaa_root_zone){
            $aaa_group_name = $value['Name'];
            $aaa_root_group_id = $value['Id'];
        }
    }
}else{
    $error = true;
}
if($error){
    $err_msg = 'AAA connection timed out';
    $arr = array('status' => 'error','data' => $err_msg );
}else{
    $arr = array('status' => 'success','data' => ['aaa_root_zone'=>$aaa_root_zone,'aaa_group_name'=>$aaa_group_name,'aaa_root_group_id'=>$aaa_root_group_id] );
}
echo json_encode($arr);
?>