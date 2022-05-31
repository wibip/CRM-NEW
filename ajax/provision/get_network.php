<?php

session_start();

header("Cache-Control: no-cache, must-revalidate");
require_once '../../classes/dbClass.php';
require_once '../../classes/appClass.php';
require_once '../../classes/systemPackageClass.php';
require_once '../../classes/CommonFunctions.php';

$package_functions=new package_functions();
$db = new db_functions();

$module_array = array('provision');
$system_package = $package_functions->getPackage($_SESSION['user_name']);
if(!$package_functions->ajaxAccess($module_array,$system_package)){
    http_response_code(401);
    return false;
}

$user_distributor = $_POST['mno'];
$system_package = $_POST['system_package'];
$location_id = $_POST['location_id'];
$sync_type = $_POST['sync_type'];
$no_of_pvt= $_POST['no_of_pvt'];
$no_of_vt= $_POST['no_of_vt'];
$no_of_guest= $_POST['no_of_guest'];
$newval= $_POST['new_val'];
$network_name= $_POST['network_name'];
$product= $_POST['product'];
$update_id= $_POST['update_id'];
$number = $_POST['num']-1;


$user_distributor = htmlentities( urldecode($user_distributor), ENT_QUOTES, 'utf-8' );
$system_package = htmlentities( urldecode($system_package), ENT_QUOTES, 'utf-8' );
$sync_type = htmlentities( urldecode($sync_type), ENT_QUOTES, 'utf-8' );

function getPropertyDetails($id,$db,$mno_id){
    if(empty($id)){
        echo json_encode(['id not found']);
        http_response_code('404');
        exit();
    }

    $property_details = $db->getValueAsf("SELECT property_details AS f FROM exp_provisioning_properties WHERE id='$id' AND mno_id='$mno_id'");

    if(empty($property_details)){
        echo json_encode(['id not found']);
        http_response_code('404');
        exit();
    }

    return json_decode($property_details,true);
}

if($sync_type == 'network_sync'){
    $property_details_new = $db->getValueAsf("SELECT property_details AS f FROM exp_provisioning_properties WHERE id='$update_id' AND mno_id='$user_distributor'"); 
    $property_details = json_decode($property_details_new,true);
    
    $guest_arr = $property_details['property'][$number]['network_info']['Guest']['data'];
    $private_arr = $property_details['property'][$number]['network_info']['Private']['data'];
    $vt_arr = $property_details['property'][$number]['network_info']['VTenant']['data'];
    
    $network_info = array();
    $network_info['Guest']['count'] = $no_of_guest;
    $network_info['Private']['count'] = $no_of_pvt;
    $network_info['VTenant']['count'] = $no_of_vt;
    $network_info['Guest']['data'] = array();
    $network_info['Private']['data'] = array();
    $network_info['VTenant']['data'] = array();
    $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap,network_type
                                                        FROM exp_products
                                                        WHERE (network_type='GUEST' || network_type='PRIVATE' || network_type='VTENANT') AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";
    $query_results = $db->selectDB($q1);
   $arraym = array();
   $arrayk = array();
   $arrayo = array();
    $guest_product_arr = array();
    $pvt_product_arr = array();
    $vt_product_arr = array();

    foreach ($query_results['data'] as $row) {
    $dis_code = $row[product_code];
    $QOS = $row[QOS];
    $QOSLast = strtolower(substr($QOS, -1));
    $product_name_new = str_replace('_', '-', $row[product_code]);
    $name_ar = explode('-', $product_name_new);
    $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
    $duration_val = $duration[0];
    $qosvalarr = explode('*', $name_ar[2]);
    $ab = substr($name_ar[2], 0, 2);
    if (!is_numeric($ab)) {
        $ab = substr($name_ar[2], 0, 1);
    }
    $bb = substr($name_ar[2], -2);
    if (!is_numeric($bb)) {
        $bb = substr($name_ar[2], -1);
    }
    $row['duration'] = $duration_val;
    $row['qosval'] = $ab;
    $row['qosval2'] = $bb;
    if ($QOSLast == 'k') {
        array_push($arrayk, $row);
    } else if ($QOSLast == 'm') {
        array_push($arraym, $row);
    } else {
        array_push($arrayo, $row);
    }
}

CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
$arrayfinal = array();
if (empty($arrayk)) {
    $arrayfinal = $arraym;
} else {
    if (empty($arraym)) {
        $arrayfinal = $arrayk;
    } else {
        $arrayfinal = array_merge($arrayk, $arraym);
    }
}
if (!empty($arrayo)) {
    $arrayfinal = array_merge($arrayfinal,$arrayo);
}

    foreach ($arrayfinal as $row) {
        if ($row['network_type'] == 'PRIVATE'){
            array_push($pvt_product_arr, $row);  
        }elseif ($row['network_type'] == 'GUEST') {
            array_push($guest_product_arr, $row);  
        }elseif ($row['network_type'] == 'VTENANT') {
            array_push($vt_product_arr, $row);
        }
    }
    //print_r($vt_product_arr);

    if($manual_status!="1"){
        $checked = "checked";
    }else{
        $checked = "";
    }

    if ($no_of_pvt>0) {
      $pvt = '<tr><td class="prov-sub-headers" colspan="2">Private Networks
      </td><td></td><td></td><td></td><td></td></tr>';
    } else{
      $pvt = '';
    } 
    if ($no_of_guest>0) {
      $guest = '<tr><td class="prov-sub-headers" colspan="2">Guest Networks</td><td></td><td></td><td></td><td></td></tr>';
    } else{
      $guest = '';
    }

    if ($no_of_vt>0) {
        $vt = '<tr><td class="prov-sub-headers" colspan="2">vTenant Networks</td><td></td><td></td><td></td><td></td></tr>';
    } else{
        $vt = '';
    }


for ($i=1; $i < $no_of_pvt+1; $i++) {
    $wlan_name = 'private-'.$i;
    $product_p = '';
    if ($i==$newval) {
        $name_p = $network_name;
        $product_p = $product;
    }else{
        $name_p = 'Private-'.$i;
        foreach ($private_arr as $value) {
            if ($wlan_name == $value['wlan_name']) {
                $name_p = $value['SSID'];
                $product_p = $value['Product'];
            }

        }
    }
    $pvt_product = '<option>Select Product</option>';
    foreach ($pvt_product_arr as $row) {
        $product_id = $row['product_id'];
        $product_code = $row['product_code'];
        $select_v = "";
        if ($product_p == $product_id) {
           $select_p = "selected";
        }
        $pvt_product .= '<option '.$select_p.' value="'.$product_id.'">'.$product_code.'</option>'; 

    }
    
    $ssid_arr = array('wlan_name' => $wlan_name,
                     'SSID' => $name_p,
                     'Product' => $product_p);
    $broadcast = '<div class="toggle1">
    <input class="hide_checkbox" '.$checked.' id="broadcast'.$i.'" type="checkbox">';
    if($manual_status!="1"){
        $broadcast .= '<span class="toggle1-on">ON</span>
        <a id="broadcast_link_off'.$i.'"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>';
        $broadcast .= '<script type="text/javascript">
        
                $(document).ready(function() {
        
                $(\'#broadcast_link_off' . $i . '\').easyconfirm({locale: {
        
                        title: \'Disable Broadcast\',
        
                        text: \'Are you sure you want to disable this ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        
                        button: [\'Cancel\',\' Confirm\'],
        
                        closeText: \'close\'
        
                         }});
        
                    $(\'#broadcast_link_off' . $i . '\').click(function() {
        
                        alert(1);
        
                    });
        
                    });
        
                </script>';
    }else{
        $broadcast .= '<a id="broadcast_link_on'.$i.'"><span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
            <span class="toggle1-off">OFF</span>';
        $broadcast .= '<script type="text/javascript">
        
                $(document).ready(function() {
        
                $(\'#broadcast_link_on' . $i . '\').easyconfirm({locale: {
        
                        title: \'Enable Broadcast\',
        
                        text: \'Are you sure you want to enable this ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        
                        button: [\'Cancel\',\' Confirm\'],
        
                        closeText: \'close\'
        
                         }});
        
                    $(\'#broadcast_link_on' . $i . '\').click(function() {
        
                        alert(1);
        
                    });
        
                    });
        
                </script>';
    }
    $broadcast .= '</div>';
    $pvt .= '<tr>';
    $pvt .= '
        <td>'.$name_p.'</td>
        <td><input class="span3" maxlength="20" type="text" name="network_'.$i.'" id="network_'.$i.'"></td>
        <td><input class="span3" style="width:28px; height:28px;" type="checkbox" name="network_enable'.$i.'" id="network_enable'.$i.'"></td>
        <td><input value="'.$i.'" type="hidden" name="id'.$i.'" id="id'.$i.'"><select  style= "width:230px;" class="span3" id="product_'.$i.'" name="product_'.$i.'">'.$pvt_product.'</select><button  onclick="network_config('.$i.');" id="network_edit'.$i.'" name="network_edit'.$i.'" class="btn btn-small btn-info" type="button">&nbsp;Update</button></td>
        <td>'.$broadcast.'</td>';
    $pvt .= '</tr>';
    array_push($network_info["Private"]["data"], $ssid_arr);
}
$no_of_guest = $no_of_guest + $no_of_pvt;
for ($j=$no_of_pvt+1; $j < $no_of_guest+1; $j++) { 
    $z = $j - $no_of_pvt;
    $wlan_name = 'guest-'.$z;
    $product_g = '';
     if ($j==$newval) {
        $name_g = $network_name;
        $product_g = $product;
    }else{
        $name_g = 'Guest-'.$z;
        foreach ($guest_arr as $value) {
            if ($wlan_name == $value['wlan_name']) {
                $name_g = $value['SSID'];
                $product_g = $value['Product'];
            }

        }
    }
    $guest_product = '<option>Select Product</option>';
    foreach ($guest_product_arr as $row) {
        $product_id = $row['product_id'];
        $product_code = $row['product_code'];
        $select_g = "";
        if ($product_g == $product_id) {
           $select_g = "selected";
        }
        $guest_product .= '<option '.$select_g.' value="'.$product_id.'">'.$product_code.'</option>'; 

    }

    $ssid_arr = array('wlan_name' => $wlan_name,
                     'SSID' => $name_g,
                     'Product' => $product_g);
    $broadcast = '<div class="toggle1">
    <input class="hide_checkbox" '.$checked.' id="broadcast'.$j.'" type="checkbox">';
    if($manual_status!="1"){
        $broadcast .= '<span class="toggle1-on">ON</span>
        <a id="broadcast_link_off'.$j.'"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>';
        $broadcast .= '<script type="text/javascript">
        
                $(\'#broadcast_link_off' . $i . '\').easyconfirm({locale: {
        
                        title: \'Disable Broadcast\',
        
                        text: \'Are you sure you want to disable this ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        
                        button: [\'Cancel\',\' Confirm\'],
        
                        closeText: \'close\'
        
                         }});
        
                    $(\'#broadcast_link_off' . $i . '\').click(function() {
        
                        alert(1);
        
                    });
        
        
                </script>';
    }else{
        $broadcast .= '<a id="broadcast_link_on'.$j.'"><span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
            <span class="toggle1-off">OFF</span>';
            $broadcast .= '<script type="text/javascript">
        
                $(document).ready(function() {
        
                $(\'#broadcast_link_on' . $i . '\').easyconfirm({locale: {
        
                        title: \'Enable Broadcast\',
        
                        text: \'Are you sure you want to enable this ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        
                        button: [\'Cancel\',\' Confirm\'],
        
                        closeText: \'close\'
        
                         }});
        
                    $(\'#broadcast_link_on' . $i . '\').click(function() {
        
                        alert(1);
        
                    });
        
                    });
        
                </script>';
    }
    $broadcast .= '</div>';
    
    $guest .= '<tr>';
    $guest .= '
        <td>'.$name_g.'</td>
        <td><input class="span3" maxlength="20" type="text" name="network_'.$j.'" id="network_'.$j.'"></td>
        <td><input class="span3" type="checkbox" style="width:28px; height:28px;" name="network_enable'.$j.'" id="network_enable'.$j.'"></td>
        <td><input value="'.$j.'" type="hidden" name="id'.$j.'" id="id'.$j.'"><select style= "width:230px;" class="span3" id="product_'.$j.'" name="product_'.$j.'">'.$guest_product.'</select><button onclick="network_config('.$j.');" id="network_edit'.$j.'" name="network_edit'.$j.'" class="btn btn-small btn-info" type="button">&nbsp;Update</button></td>
        <td>'.$broadcast.'</td>';
    $guest .= '</tr>';
    array_push($network_info["Guest"]["data"], $ssid_arr);
    
}

if($no_of_vt==1){
    $j = $no_of_guest+$no_of_pvt+1;
    $wlan_name = 'vtenant-1';
    $product_v = '';
    if ($j==$newval) {
        $name_v = $network_name;
        $product_v = $product;
    }else{
        $name_v = 'vTenant-1';
        foreach ($vt_arr as $value) {
            if ($wlan_name == $value['wlan_name']) {
                $name_v = $value['SSID'];
                $product_v = $value['Product'];
            }

        }
    }
    $vt_product = '<option>Select Product</option>';
    foreach ($vt_product_arr as $row) {
        $product_id = $row['product_id'];
        $product_code = $row['product_code'];
        $select_v = "";
        if ($product_v == $product_id) {
           $select_v = "selected";
        }
        $vt_product .= '<option '.$select_v.' value="'.$product_id.'">'.$product_code.'</option>';

    }

    $ssid_arr = array('wlan_name' => $wlan_name,
        'SSID' => $name_v,
        'Product' => $product_v);
    $broadcast = '<div class="toggle1">
    <input class="hide_checkbox" '.$checked.' id="broadcast'.$j.'" type="checkbox">';
    if($manual_status!="1"){
        $broadcast .= '<span class="toggle1-on">ON</span>
        <a id="broadcast_link_off'.$j.'"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>';
        $broadcast .= '<script type="text/javascript">
        
                $(\'#broadcast_link_off' . $i . '\').easyconfirm({locale: {
        
                        title: \'Disable Broadcast\',
        
                        text: \'Are you sure you want to disable this ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        
                        button: [\'Cancel\',\' Confirm\'],
        
                        closeText: \'close\'
        
                         }});
        
                    $(\'#broadcast_link_off' . $i . '\').click(function() {
        
                        alert(1);
        
                    });
        
        
                </script>';
    }else{
        $broadcast .= '<a id="broadcast_link_on'.$j.'"><span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
            <span class="toggle1-off">OFF</span>';
        $broadcast .= '<script type="text/javascript">
        
                $(document).ready(function() {
        
                $(\'#broadcast_link_on' . $i . '\').easyconfirm({locale: {
        
                        title: \'Enable Broadcast\',
        
                        text: \'Are you sure you want to enable this ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        
                        button: [\'Cancel\',\' Confirm\'],
        
                        closeText: \'close\'
        
                         }});
        
                    $(\'#broadcast_link_on' . $i . '\').click(function() {
        
                        alert(1);
        
                    });
        
                    });
        
                </script>';
    }
    $broadcast .= '</div>';

    $vt .= '<tr>';
    $vt .= '
        <td>'.$name_v.'</td>
        <td><input class="span3" maxlength="20"  type="text" name="network_'.$j.'" id="network_'.$j.'"></td>
        <td><input class="span3" type="checkbox" style="width:28px; height:28px;" name="network_enable'.$j.'" id="network_enable'.$j.'"></td>
        <td><input value="'.$j.'" type="hidden" name="id'.$j.'" id="id'.$j.'"><select style= "width:230px;" class="span3" id="product_'.$j.'" name="product_'.$j.'">'.$vt_product.'</select><button onclick="network_config('.$j.');" id="network_edit'.$j.'" name="network_edit'.$j.'" class="btn btn-small btn-info" type="button">&nbsp;Update</button></td>
        <td>'.$broadcast.'</td>';
    $vt .= '</tr>';
    array_push($network_info["VTenant"]["data"], $ssid_arr);
}
//print_r($network_info);
//$network_info_json = json_encode($network_info);

$property_details['property'][$number]['network_info'] = $network_info;
$property_details = json_encode($property_details);
$status = $newval=='edit'?'status':3;
$q = "UPDATE exp_provisioning_properties SET`property_details` = '$property_details', `status`=$status WHERE id='$update_id' AND mno_id='$user_distributor'";

$update = $db->execDB($q);
}
//$data=json_encode(array('guest'=>$guest,'vtenant'=>$vt,'private'=>$pvt));
echo $guest.$pvt.$vt;
?>




