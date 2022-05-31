<?php

include_once '../zabbix/index.php';
include_once 'Exceptions.php';
$internalConfigJson = '{ 
                        "zabbixAutomation": 1 
                       }';
                       
$internalConfigArr = json_decode($internalConfigJson,true);

if (!function_exists('clean')){
function clean($string) {
    //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\- ]/', '', $string); // Removes special chars.
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

/////////////////  Set Curl Options  //////////////////////////
   function setCurlOptions($url,$headers,$method,array $data=null){

        //echo'</br>'.$url.'</br>';

        $ch = curl_init($url);


        //set request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        //set data
        if(!is_null($data)){
            $jsonEncodeData = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonEncodeData);
            //echo $jsonEncodeData.'</br>';
        }


        //set header options
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);

        //curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //SET connection time out
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

        return $ch;
    }

    function sendInternalErrorEmail($package_functions,$db,$system_package,$mno_id,$to,$parent_product,$data){
        $from = strip_tags($db->setVal("email", $mno_id));
        if ($from == '') {
            $from = strip_tags($db->setVal("email", 'ADMIN'));
        }
        $email_content = $db->getEmailTemplate('SERVER_ERROR_API', $system_package, 'MNO', $mno_id);
        $a = $email_content[0]['text_details'];
        $subject_full = $email_content[0]['title'];
        $vars_body = array(
            '{$url}' => ' '.$data['url'],
            '{$api}' => ' '.$data['api'],
            '{$method}' => ' '.$data['method'],
            '{$request}' => json_encode($data['request']),
            '{$response}' => json_encode($data['response']),
            '{$date_time}' => date("Y-m-d H:i:s"),
        );

        $message_full = strtr($a, $vars_body);

        $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
        include_once '../../src/email/' . $email_send_method . '/index.php';

        $emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package);
        $cunst_var = array();
        if ($emailTemplateType == 'child') {
            $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $parent_product);
        } elseif ($emailTemplateType == 'owen') {
            $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
        } elseif (strlen($emailTemplateType) > 0) {
            $cunst_var['template'] = $emailTemplateType;
        } else {
            $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
        }
        $mail_obj = new email($cunst_var);

        $mail_sent = $mail_obj->sendEmail($from, $to, $subject_full, $message_full, '', '');
    }

function getAccountByParentId($parent_id, $db, $property_id=null)
{
    if(is_null($property_id)){
        $loc_q = "SELECT * FROM `exp_mno_distributor` d LEFT JOIN `admin_users` u ON d.`distributor_code`=u.`user_distributor` WHERE d.parent_id='$parent_id'";
    }else{
        $loc_q = "SELECT * FROM `exp_mno_distributor` d LEFT JOIN `admin_users` u ON d.`distributor_code`=u.`user_distributor` WHERE d.parent_id='$parent_id' AND property_id='$property_id'";
    }
    $loc_qr = $db->selectDB($loc_q);

    if ($loc_qr['rowCount'] > 0) {

        $locArr = [];
        foreach ($loc_qr['data'] as $loc_r) {
            $user_distributor = $loc_r['distributor_code'];
            $hardwareArr = [];
            $hardware1_qr = $db->selectDB("SELECT * FROM `exp_locations_ap` WHERE mno='$user_distributor'");
            foreach ($hardware1_qr['data'] as $hardware_r) {
                $hardware = array(
                    'class' => 'AP',
                    'id' => str_replace("-", "", $hardware_r['ap_code']),
                    'model' => $hardware_r['model'],
                    'caption' => $hardware_r['ap_description'],
                    'tags' => []
                );
                array_push($hardwareArr, $hardware);
            }

            $hardware2_qr = $db->selectDB("SELECT * FROM `exp_mno_switchs` WHERE distributor_code='$user_distributor'");
            foreach ($hardware2_qr['data'] as $hardware_r) {
                $hardware = array(
                    'class' => 'Switch',
                    'id' => str_replace(":", "", $hardware_r['switch_code']),
                    'model' => $hardware_r['model'],
                    'caption' => $hardware_r['caption'],
                    'tags' => []
                );
                array_push($hardwareArr, $hardware);
            }
            $location = array(
                'id' => $loc_r['property_id'],
                'name' => $loc_r['distributor_name'],
                'address' => array(
                    'street' => $loc_r['bussiness_address1'],
                    'city' => $loc_r['bussiness_address2'],
                    'state' => $loc_r['state_region'],
                    'zip' => $loc_r['zip'],
                ),
                'timeZone' => stripslashes($loc_r['time_zone']),
                'contact' => array(
                    'name' => stripslashes($loc_r['full_name']),
                    'email' => stripslashes($loc_r['email']),
                ),
                'hardware' => $hardwareArr
            );
            array_push($locArr, $location);
        }

        $parent_row = $db->select1DB("SELECT p.account_name,u.full_name,u.email,u.mobile FROM mno_distributor_parent p,admin_users u WHERE u.verification_number=p.parent_id  AND u.verification_number='$parent_id' LIMIT 1");

        return array(
            'id' => $parent_id,
            'name' => $parent_row['account_name'],
            'contact' => array(
                'name' => $parent_row['full_name'],
                'email' => $parent_row['email'],
                'voice' => $parent_row['mobile'],
            ),
            'locations' => $locArr,
        );
    } else {
        return [];
    }
}

function httpGet($url)
{
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //  curl_setopt($ch,CURLOPT_HEADER, false);

    $output=curl_exec($ch);

    $err = curl_error($ch);

        if ($err) {
            $output = $err;
        }

    curl_close($ch);
    return $output;
}

function createMatchEntry($configFileArr,$icomme_number,$matchEntryArr,$db,$package_functions){
        /* $location_match_entryNasType = $configFileArr['location_match_entryNasType'];
        $location_match_entryTenant = $configFileArr['location_match_entryTenant'];
        $location_match_entryZone = $configFileArr['location_match_entryZone'];
        $location_match_entryLocationGroup = $configFileArr['location_match_entryLocationGroup'];
        $location_match_entryRedirectURL = $configFileArr['location_match_entryRedirectURL']; */
        $enableMatchEntry = true;
        if($enableMatchEntry){

        /* if(strlen($location_match_entryRedirectURL) > 0){


            $location_match_entry = array(
                "Location-Id"=>$realm,
                "Redirect-URL"=>$location_match_entryRedirectURL,
                "Nas-Type"=>$location_match_entryNasType,
                "Tenant"=>$location_match_entryTenant,
                "Zone"=>$location_match_entryZone,
                "Access-Group"=>$realm,
                "Location-Group"=>$location_match_entryLocationGroup
            );

            include_once '../AAA/WIBIP_AAA/index.php';

            $aaa = new aaa('WIBIP_AAA');

            $createLocation =  $aaa->createLocation($realm,$location_match_entry,'+05:30');

            return $createLocation;

            }else{ */
                $network_name = $matchEntryArr['network_name'];
                $aaa_data_op = $matchEntryArr['aaa_data_op'];
                $location_name = $matchEntryArr['location_name'];
                $distributor_code = $matchEntryArr['distributor_code'];
                $guest_count = $matchEntryArr['guest_count'];
                $private_count = $matchEntryArr['private_count'];
                $vlan_start = $matchEntryArr['vlan_start'];
                $vt_vlan_start = $matchEntryArr['vt_vlan_start'];
                $p_vlan_start = $matchEntryArr['p_vlan_start'];
                $gateway_type = strtolower($matchEntryArr['gateway_type']);
                $product_new = $matchEntryArr['product_new'];
                $network_type = $matchEntryArr['network_type'];
                $product_vt = $matchEntryArr['product_vt'];
                $system_package = $matchEntryArr['system_package'];
                $pr_gateway_type = strtolower($matchEntryArr['pr_gateway_type']);
                $operator_code = $matchEntryArr['operator_code'];
                $mno_id = $matchEntryArr['mno_id'];
                $zones_arr = [];
                $lookup_arr = [];

                $pr_arr = array();
                $guest_arr = array();
                $vt_arr = array();
        
                $row1 = $db->select1DB("SELECT * FROM `exp_network_profile` WHERE network_profile = '$network_name'");
                $aaa_data = json_decode($row1['aaa_data'], true);
                $network_profile=$row1['api_network_auth_method'];
                require_once('../AAA/'.$network_profile.'/index.php'); 
                $aaa=new aaa($network_name,$system_package);
                $aaa_data = $aaa->getNetworkConfig($network_name,'aaa_data');
                for ($i=1; $i < $guest_count+1; $i++) {
                    if ($gateway_type == 'wag') {
                        $location = 'Guest-G'.$i.$vlan_start;
                    }else{
                        $location = $icomme_number.$vlan_start;
                    } 
                    $g_arry=array(
                                    "Name"=>'Guest-'.$i,
                                    "Access-Group"=> $icomme_number.'G'.$i,
                                    "Redirect-URL"=> $db->setVal("portal_base_url", "ADMIN").'/checkpoint.php',
                                    'Zone-Data' => array(
                                        'Nas-Type'=> $gateway_type,
                                        'Location-Id'=> $location
                                    )
                                );
                    array_push($guest_arr, $g_arry);
                    $vlan_start = $vlan_start + 1;
                }
                for ($j=1; $j < $private_count+1; $j++) {
                    $p_arry=array(
                                    "Name"=>'Private-'.$j,
                                    "Access-Group"=> $icomme_number.'P'.$j,
                                    'Zone-Data' => array(
                                        'Nas-Type'=> $pr_gateway_type,
                                        'Location-Id'=> $icomme_number.$p_vlan_start,
                                        'Free-Access'=> $product_new
                                    )
                                );
                    array_push($pr_arr, $p_arry);
                    $p_vlan_start = $p_vlan_start + 1;
                }

                if (strpos($network_type, 'VT') !== false) {
                    $vt_url = $db->setVal("mdu_portal_base_url", "ADMIN");
                    $vt_url = rtrim($vt_url,"/");
                    $admin_package = $package_functions->getAdminPackage();
                    $switch_zone_postfix = $package_functions->getOptions('SWITCH_POSTFIX', $admin_package);
                    $switch_vars = array(
                        '{$operator_code}' => $operator_code
                    );
                    $switch_zone_postfix = strtr($switch_zone_postfix, $switch_vars);
                    $vt_arr = array(
                        array(
                            "Name" => 'resident-1',
                            'vTenant' => array(
                                "Name"=>'resident-1',
                                "Description" => "This contains match table entry for Resident network",
                                "Access-Group"=> $icomme_number.'R1',
                                "Zone-Data" => array(
                                    "onboardvlan"=>(string)$vt_vlan_start
                                )
                            ),
                            'onboarding' => array(
                                "Name" => 'onboarding-1',
                                "Description" => "This contains match table entry for Resident->onboard-ac network",
                                "Redirect-URL" => $vt_url . '/checkpoint.php',
                                'Zone-Data' => array(
                                    'Nas-Type' => 'ac',
                                    'Location-Id' => $icomme_number . '-O1'
                                )
                            ),
                            'switch' => array(
                                "Name" => 'switch',
                                "Description" => "This contains match table entry for Resident->switch network",
                                'Zone-Data' => array(
                                    'Location-Id' => getSwitchZonePostfix($icomme_number,$switch_zone_postfix)
                                )
                            ),
                            'vsz' => array(
                                "Name" => 'vsz',
                                "Description" => "This contains match table entry for Resident->vsz network",
                                'Zone-Data' => array(
                                    'Nas-Type' => 'ac',
                                    'Location-Id' => $icomme_number
                                )
                            )
                        )

                    );
                }

                $all_zones = json_decode($aaa->getAllZones(), true);
                $op_zone_exists = false;
                $prop_zone_exists = false;
                $status_code = 200;
                $property_zone_name = str_replace(" ","-",$location_name." ".$icomme_number);
                $property_zone_name = clean($property_zone_name);
                $prop_sub_zones = array();
                if ($all_zones['status'] == 'success') {
                    $default_zone_ext = false;
                    foreach ($all_zones['Description'] as $value) {
                        if($value['Id']==$aaa_data['aaa_root_zone_id']){
        
                            foreach ($value['Sub-Zones'] as $value1) {
                                if ($value1['Name'] == $aaa_data_op['operator_zone_name']) {
                                    //print_r($value1);
                                    $op_zone_exists = true;
                                    $op_zone_id = $value1['Id'];
                                    foreach ($value1['Sub-Zones'] as $value2) {
                                        if ($value2['Name'] == $property_zone_name) {
                                            //print_r($value2);
                                            $prop_zone_exists = true;
                                            $property_zone_id = $value2['Id'];
                                            if(!empty($value2['Sub-Zones'])){
                                                $prop_sub_zones = $value2['Sub-Zones'];
                                            }
                                        }
                                    }
                                }
                            }
                            $default_zone_ext = true;
                        }
                    }

                    if($op_zone_exists && $default_zone_ext){
	            
                        if (!$prop_zone_exists) {
                            $create_zone = json_decode($aaa->createZone(array('Name' => $property_zone_name,'Description'=>'This contains match table entries for property '.$property_zone_name.'.','Parent-Zone'=>$aaa_data_op['operator_zone_id'])), true);
                            //print_r($create_zone); exit();
                            if ($create_zone['status'] == 'success') {
                                $property_zone_id = $create_zone['Description']['Id'];
                                array_push($zones_arr,$property_zone_id);
                            }else{
                                $status_code = 0;
                            }
                        }

                        if(!$error){
                            $status_code = 200;

                            foreach ($guest_arr as $value3) {
                                $value3['Description'] = 'This contains match table entry for guest network';
                                $value3['Parent-Zone'] = $property_zone_id;
                                if(array_search($value3['Name'], array_column($prop_sub_zones, 'Name')) === false){
                                    $create_wlan_zone = json_decode($aaa->createZone($value3), true);
                                    
                                    if ($create_wlan_zone['status'] == 'success') {
                                        $wlan_zone_id = $create_wlan_zone['Description']['Id'];
                                        array_push($zones_arr,$wlan_zone_id);
                                        $create_lookup_zone = json_decode($aaa->createLookupEntry(array('Id'=>$value3['Zone-Data']['Location-Id'],'Description'=>'Lookup Key for guest network','Zone-List'=>array($wlan_zone_id))), true);
                                        if ($create_lookup_zone['status'] != 'success') {
                                            $status_code = 0;
                                        }else{
                                            array_push($lookup_arr,$create_lookup_zone['Description']['Id']);
                                        }
                                        $matchEntry='Lookup-Key : "'.$value3['Zone-Data']['Location-Id'].'"<br> Zone Date"Nas-Type" : "'.$gateway_type.'", "Location-Id" : "'.$value3['Zone-Data']['Location-Id'].'"<br> "Redirect_URL" : "'.$value3['Redirect-URL'].'"';
               
                                        $query="INSERT INTO `exp_lookup_entry`
                                            (`realm`,
                                             `net_realm`,
                                             `description`,
                                             `wlan_name`,
                                             `vlan_id`,
                                             `match_entry`,
                                             `user_distributor`,
                                             `nas_type`,
                                             `lookup_key`,
                                             `redirect_url`,
                                             `zone_id`,
                                             `distributor_zone`,
                                             `create_date`)
                                             VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW())";
                                             $sql = sprintf($query, $icomme_number,$value3['Access-Group'],$value3['Description'],$value3['Name'],$vlan_start,$matchEntry,$distributor_code,$value3['Zone-Data']['Nas-Type'],$value3['Zone-Data']['Location-Id'],$value3['Redirect-URL'],$wlan_zone_id,$property_zone_id);
                                        
                                              $db->execDB($sql);
                                              $access_group = $value3['Access-Group'];
                                              $networkname = $value3['Name'];

                                            $querynew = "INSERT INTO `exp_network_realm` ( `realm`, `network_realm`,`network_type` ,`wLan_id`, `wLan_name`, `vLan_id`, `create_user`, `create_date`, `last_update`) 
                                                VALUES ('$icomme_number', '$access_group','gues','$networkid', '$networkname',  '$vlan',  '$mno_id', NOW(), NOW())";
                                            $db->execDB($querynew);
                                    }else{
                                        $status_code = 0;
                                    }
                                }else{
                                    foreach ($prop_sub_zones as $valuen) {
                                        if($value3['Name'] == $valuen['Name'] && $value3['Zone-Data']['Nas-Type'] != $valuen['Zone-Data']['Nas-Type']){
                                            $zoneid = $valuen['Id'];
                                            $valuen['Zone-Data']['Nas-Type'] = $gateway_type;
                                            $result =json_decode($aaa->updateZone($zoneid,$valuen), true);
        
                                            if ($result['status'] != 'success') {
                                            $status_code = 0;
                                            }else{
                                            $matchEntry='Lookup-Key : "'.$value3['Zone-Data']['Location-Id'].'"<br> Zone Date"Nas-Type" : "'.$gateway_type.'", "Location-Id" : "'.$value3['Zone-Data']['Location-Id'].'"<br> "Redirect_URL" : "'.$value3['Redirect-URL'].'"';
                                            $db->execDB("UPDATE exp_lookup_entry SET match_entry='$matchEntry'  WHERE realm='$icomme_number' AND wlan_name='$valuen[Name]'");
                                            }
                                        }
                                    }
                                    
                                    
                                }
                            }

                            foreach ($pr_arr as $value3) {
                                $value3['Description'] = 'This contains match table entry for private network';
                                $value3['Parent-Zone'] = $property_zone_id;
                                if(array_search($value3['Name'], array_column($prop_sub_zones, 'Name')) === false){
                                    $create_wlan_zone = json_decode($aaa->createZone($value3), true);
        
                                    if ($create_wlan_zone['status'] == 'success') {
                                        $wlan_zone_id = $create_wlan_zone['Description']['Id'];
                                        array_push($zones_arr,$wlan_zone_id);
                                        $create_lookup_zone = json_decode($aaa->createLookupEntry(array('Id'=>$value3['Zone-Data']['Location-Id'],'Description'=>'Lookup Key for private network','Zone-List'=>array($wlan_zone_id))), true);
                                        if ($create_lookup_zone['status'] != 'success') {
                                            $status_code = 0;
                                        }else{
                                            array_push($lookup_arr,$create_lookup_zone['Description']['Id']);
                                        }
                                    }else{
                                        $status_code = 0;
                                    }
                                    $matchEntry='Lookup-Key : "'.$value3['Zone-Data']['Location-Id'].'"<br> Zone Date"Nas-Type" : "'.$pr_gateway_type.'", "Location-Id" : "'.$value3['Zone-Data']['Location-Id'].'"<br> "Free-Access" : "'.$product_new.'"';
        
                                    $query="INSERT INTO `exp_lookup_entry`
                                        (`realm`,
                                         `net_realm`,
                                         `description`,
                                         `wlan_name`,
                                         `vlan_id`,
                                         `match_entry`,
                                         `user_distributor`,
                                         `nas_type`,
                                         `lookup_key`,
                                         `product`,
                                         `zone_id`,
                                         `distributor_zone`,
                                         `create_date`)
                                         VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW())";
                                        $sql = sprintf($query, $icomme_number,$value3['Access-Group'],$value3['Description'],$value3['Name'],$p_vlan_start,$matchEntry,$distributor_code,$value3['Zone-Data']['Nas-Type'],$value3['Zone-Data']['Location-Id'],$product_new,$wlan_zone_id,$property_zone_id);
                                        $db->execDB($sql);
                                }else{
                                    foreach ($prop_sub_zones as $valuen) {
                                        if($value3['Name'] == $valuen['Name'] && $value3['Zone-Data']['Nas-Type'] != $valuen['Zone-Data']['Nas-Type']){
                                            $zoneid = $valuen['Id'];
                                            $valuen['Zone-Data']['Nas-Type'] = $pr_gateway_type;
                                            $result =json_decode($aaa->updateZone($zoneid,$valuen), true);
                                            if ($result['status'] != 'success') {
                                            $status_code = 0;
                                            }else{
                                             $matchEntry='Lookup-Key : "'.$value3['Zone-Data']['Location-Id'].'"<br> Zone Date"Nas-Type" : "'.$pr_gateway_type.'", "Location-Id" : "'.$value3['Zone-Data']['Location-Id'].'"<br> "Free-Access" : "'.$product_new.'"';
                                             $db->execDB("UPDATE exp_lookup_entry SET match_entry='$matchEntry'  WHERE realm='$icomme_number' AND wlan_name='$valuen[Name]'");
        
                                            }
                                        }
                                    }
                                 }
                            }

                            foreach ($vt_arr as $value3) {
                                $valuevt = $value3['vTenant'];
                                $valuevt['Parent-Zone'] = $property_zone_id;
                                if (array_search($value3['Name'], array_column($prop_sub_zones, 'Name')) === false) {
                                    $create_wlan_zone = json_decode($aaa->createZone($valuevt), true);
        
        
                                    if ($create_wlan_zone['status'] == 'success') {
                                        $wlan_zone_id = $create_wlan_zone['Description']['Id'];
        
                                        $onboardvlan = $valuevt['Zone-Data']['onboardvlan'];
                                        $matchEntry = 'onboardvlan : "' . $onboardvlan . '"';
        
                                        $access_group = $valuevt['Access-Group'];
                                        $networkname = $value3['Name'];
                                        $querynew = "INSERT IGNORE INTO `exp_network_realm` ( `realm`, `network_realm`,`network_type` ,`wLan_id`, `wLan_name`, `vLan_id`, `create_user`, `create_date`, `last_update`) 
                                            VALUES ('$icomme_number', '$access_group','vt','$networkid', '$networkname',  '$vlan',  '$mno_id', NOW(), NOW())";
                                        $db->execDB($querynew);
        
                                        if (!empty($value3['onboarding'])) {
                                            $valueac = $value3['onboarding'];
                                            $valueac['Parent-Zone'] = $wlan_zone_id;
                                            $create_wlan_zoneac = json_decode($aaa->createZone($valueac), true);
                                            if ($create_wlan_zoneac['status'] == 'success') {
                                                $wlan_zone_idac = $create_wlan_zoneac['Description']['Id'];
                                                $Description = 'Lookup Key for vTenant->' . $valueac["Name"] . ' network';
                                                $create_lookup_zoneac = json_decode($aaa->createLookupEntry(array('Id' => $valueac['Zone-Data']['Location-Id'], 'Description' => $Description, 'Zone-List' => array($wlan_zone_idac))), true);
        
                                                if ($create_lookup_zoneac['status'] != 'success') {
                                                    //$status_code = 0;
                                                } else {
                                                }
                                            }
                                        }
                                        if (!empty($value3['switch'])) {
                                            $valuesw = $value3['switch'];
                                            $valuesw['Parent-Zone'] = $wlan_zone_id;
                                            $create_wlan_zonesw = json_decode($aaa->createZone($valuesw), true);
                                            if ($create_wlan_zonesw['status'] == 'success') {
                                                $wlan_zone_idsw = $create_wlan_zonesw['Description']['Id'];
                                                $Description = 'Lookup Key for vTenant->' . $valuesw["Name"] . ' network';
                                                $create_lookup_zonesw = json_decode($aaa->createLookupEntry(array('Id' => getSwitchZonePostfix($valuesw['Zone-Data']['Location-Id'],$switch_zone_postfix), 'Description' => $Description, 'Zone-List' => array($wlan_zone_idsw))), true);
        
                                                if ($create_lookup_zonesw['status'] != 'success') {
                                                    //$status_code = 0;
                                                } else {
                                                }
                                            }
                                        }
                                        if (!empty($value3['vsz'])) {
                                            $valuevsz = $value3['vsz'];
                                            $valuevsz['Parent-Zone'] = $wlan_zone_id;
                                            $create_wlan_zonevsz = json_decode($aaa->createZone($valuevsz), true);
                                            if ($create_wlan_zonevsz['status'] == 'success') {
                                                $wlan_zone_idvsz = $create_wlan_zonevsz['Description']['Id'];
                                                $Description = 'Lookup Key for vTenant->' . $valuevsz["Name"] . ' network';
                                                $create_lookup_zonevsz = json_decode($aaa->createLookupEntry(array('Id' => $valuevsz['Zone-Data']['Location-Id'], 'Description' => $Description, 'Zone-List' => array($wlan_zone_idvsz))), true);
        
                                                if ($create_lookup_zonevsz['status'] != 'success') {
                                                    //$status_code = 0;
                                                } else {
                                                }
                                            }
                                        }
                                    } else {
                                        $status_code = 0;
                                    }
                                }else{
                                    
                                    foreach ($prop_sub_zones as $value) {
                                        if ($value['Name'] == $value3['Name']) {
                                            $wlan_zone_id = $value['Id'];
                                            $vt_sub_zone = $value['Sub-Zones'];
                                        }
                                        
                                    }
                                if (!empty($value3['onboarding']) && (array_search($value3['onboarding']['Name'], array_column($vt_sub_zone, 'Name')) === false)) {
                                    $valueac = $value3['onboarding'];
                                    $valueac['Parent-Zone'] = $wlan_zone_id;
                                    $create_wlan_zoneac = json_decode($aaa->createZone($valueac), true);
                                    if ($create_wlan_zoneac['status'] == 'success') {
                                        $wlan_zone_idac = $create_wlan_zoneac['Description']['Id'];
                                        $Description = 'Lookup Key for vTenant->' . $valueac["Name"] . ' network';
                                        $create_lookup_zoneac = json_decode($aaa->createLookupEntry(array('Id' => $valueac['Zone-Data']['Location-Id'], 'Description' => $Description, 'Zone-List' => array($wlan_zone_idac))), true);
        
                                        if ($create_lookup_zoneac['status'] != 'success') {
                                            //$status_code = 0;
                                        } else {
                                        }
                                    }
                                }
                                if (!empty($value3['switch']) && (array_search($value3['switch']['Name'], array_column($vt_sub_zone, 'Name')) === false)) {
                                    $valuesw = $value3['switch'];
                                    $valuesw['Parent-Zone'] = $wlan_zone_id;
                                    $create_wlan_zonesw = json_decode($aaa->createZone($valuesw), true);
                                    if ($create_wlan_zonesw['status'] == 'success') {
                                        $wlan_zone_idsw = $create_wlan_zonesw['Description']['Id'];
                                        $Description = 'Lookup Key for vTenant->' . $valuesw["Name"] . ' network';
                                        $create_lookup_zonesw = json_decode($aaa->createLookupEntry(array('Id' => getSwitchZonePostfix($valuesw['Zone-Data']['Location-Id'],$switch_zone_postfix), 'Description' => $Description, 'Zone-List' => array($wlan_zone_idsw))), true);
        
                                        if ($create_lookup_zonesw['status'] != 'success') {
                                            //$status_code = 0;
                                        } else {
                                        }
                                    }
                                }
                                if (!empty($value3['vsz']) && (array_search($value3['vsz']['Name'], array_column($vt_sub_zone, 'Name')) === false)) {
                                    $valuevsz = $value3['vsz'];
                                    $valuevsz['Parent-Zone'] = $wlan_zone_id;
                                    $create_wlan_zonevsz = json_decode($aaa->createZone($valuevsz), true);
                                    if ($create_wlan_zonevsz['status'] == 'success') {
                                        $wlan_zone_idvsz = $create_wlan_zonevsz['Description']['Id'];
                                        $Description = 'Lookup Key for vTenant->' . $valuevsz["Name"] . ' network';
                                        $create_lookup_zonevsz = json_decode($aaa->createLookupEntry(array('Id' => $valuevsz['Zone-Data']['Location-Id'], 'Description' => $Description, 'Zone-List' => array($wlan_zone_idvsz))), true);
        
                                        if ($create_lookup_zonevsz['status'] != 'success') {
                                            //$status_code = 0;
                                        } else {
                                        }
                                    }
                                }
                                
                                }
                            }
                        }
                    }elseif (empty($all_zones['Description'])) {
                        $status_code = 200;
                    }else{
                        $status_code = 0;
                    }
                        
                }else{
                    $status_code = 0;
                }

                if($status_code == 200){
                    $zones_arr = array_reverse($zones_arr);
                    $des = array('zone'=>$zones_arr,'lookup'=>$lookup_arr,'aaa'=>$aaa);
                    return json_encode(['status'=>'success','status_code'=>'200','Description'=>$des]);
                }else{
                    return json_encode(['status'=>'error','status_code'=>'0','Description'=>'']);
                }
            //}
        }else{
            return json_encode(['status'=>'success','status_code'=>'200','Description'=>'']);
        }
}

function getSwitchZonePostfix($val,$switch_zone_postfix)
	{
		if (substr($val, -(strlen($switch_zone_postfix))) == $switch_zone_postfix) {
			return $val;
		}
		return $val.$switch_zone_postfix;
	}

function randomPassword() {

    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); //turn the array into a string
}

function ContactNumberFormat($mobile) {

    $mvnx_mobile = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $mobile). "\n";

    return $mvnx_mobile; //turn the array into a string
}

function errorExit($errType){

            if($errType=='hardwareDeleteFailed'){
                $data = array('message' => 'Hardware deletion failed', 'errorCode' => '0');
                $resp_arr = array('status' => 'server-error', 'data' => $data);
                                        
            }elseif ($errType=='hardwareNotAvailable') {
                $resp_arr = array('status' => 'error', 'data' => array('message' => 'Invalid HTTP request body', 'errorCode' => '103',"errors" => array("Hardware id" => "Resource not available")));

            }elseif ($errType=='locationNotFound') {
                $validation_msg = array('message' => 'Invalid HTTP request body', 'errorCode' => '103',"errors" => array("Location id" => "Location not found"));
                $resp_arr = array('status' => 'error', 'data' => $validation_msg);

            }elseif ($errType=='invalidMac') {
                $validation_msg = array('message' => 'Invalid HTTP request body', 'errorCode' => '103',"errors" => array("Hardware id" => "Input invalid mac address"));
                $resp_arr = array('status' => 'error', 'data' => $validation_msg);

            }elseif ($errType=='accCreationFailed') {
                $validation_msg = array('message' => 'Invalid HTTP request body', 'errorCode' => '103',"errors" => array("Hardware id" => "Input invalid mac address"));
                $resp_arr = array('status' => 'error', 'data' => $validation_msg);

            }
            
            echo json_encode($resp_arr);
            exit();

}

function setObj($ap_controller,db_functions $db){

    $wag_ap_name = 'Ruckus5.0';

     $ap_q2="SELECT `api_profile`
FROM `exp_locations_ap_controller`
WHERE `controller_name`='$ap_controller'
LIMIT 1";

    $query_results_ap2=$db->select1DB($ap_q2);

        $wag_ap_name2 = $query_results_ap2['api_profile'];


    $ap_control_var = $db->setVal('ap_controller', 'ADMIN');


        if($ap_control_var=='MULTIPLE'){

            //echo 'src/AP/' . $wag_ap_name2 . '/index.php';

            include '../AP/' . $wag_ap_name2 . '/index.php';
            if($wag_ap_name2==""){
                include '../AP/' . $wag_ap_name . '/index.php';
            }

            $wag_obj = new ap_wag($ap_controller);

        }else if($ap_control_var=='SINGLE'){


            include '../AP/' . $wag_ap_name . '/index.php';
            $wag_obj = new ap_wag();

        }

        return $wag_obj;

}


function randomPasswordLength($length) {

    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); //turn the array into a string
}

function checkDomain($domain_dataarray,$main_domain_name){
    $domain_id = 0;
    foreach ($domain_dataarray AS $domain_detail) {

        if($main_domain_name==$domain_detail['name']){
            $domain_id = $domain_detail['id'];
            break;
        }
    }

    return $domain_id;
}

function checkSubDomain($sub_domain_dataarray,$sub_domain_name){
    $sub_domain_id = 0;
    foreach ($sub_domain_dataarray AS $sub_domain_detail) {

        if($sub_domain_name==$sub_domain_detail['name']){
            $sub_domain_id = $sub_domain_detail['id'];
            break;
        }

    }

    return $sub_domain_id;
}

function retrieveDomains($wag_ob){

    $retrieveDomains=$wag_ob->retrieveDomains();
    parse_str($retrieveDomains,$retrieveDomains_arr);
    $domain_obj = (array)json_decode(urldecode($retrieveDomains_arr['Description']),true);
    $domain_dataarray = $domain_obj['list'];
    return $domain_dataarray;

}

function retrieveSubDomains($wag_ob,$domain_id){

    $retrieveSubDomains=$wag_ob->retrieveSubDomains($domain_id);
    parse_str($retrieveSubDomains,$retrieveSubDomains_arr);

    $sub_domain_obj = (array)json_decode(urldecode($retrieveSubDomains_arr['Description']),true);

        $sub_domain_dataarray = $sub_domain_obj['list'];
        return $sub_domain_dataarray;

}

function insertDomains($domain_dataarray,db_functions $db,$ap_controller){
    $q = "INSERT INTO `api_domain` (
        `ap_controller`,
        `domains`,
        `create_date`,
        `unixtimestamp`
      )
      VALUES
        (
          '$ap_controller',
          '$domain_dataarray',
          NOW(),
          UNIX_TIMESTAMP()
        ) ON DUPLICATE KEY UPDATE `domains`='$domain_dataarray',`unixtimestamp`= UNIX_TIMESTAMP()
      ";
    $ex = $db->execDB($q);
}

function insertStateSubDomains($sub_domain_dataarray,db_functions $db,$ap_controller,$domain_name){
    $q = "INSERT INTO `api_state_subdomain` (
        `ap_controller`,
        `domain`,
        `sub_domains`,
        `create_date`,
        `unixtimestamp`
      )
      VALUES
        (
          '$ap_controller',
          '$domain_name',
          '$sub_domain_dataarray',
          NOW(),
          UNIX_TIMESTAMP()
        ) ON DUPLICATE KEY UPDATE `sub_domains`='$sub_domain_dataarray',`unixtimestamp`= UNIX_TIMESTAMP()
      ";
    $ex = $db->execDB($q);
}

function insertCitySubDomains($sub_domain_dataarray,db_functions $db,$ap_controller,$domain_name,$state_sub_domain){
    $q = "INSERT INTO `api_city_subdomain` (
        `ap_controller`,
        `domain`,
        `state_sub_domain`,
        `city_sub_domains`,
        `create_date`,
        `unixtimestamp`
      )
      VALUES
        (
          '$ap_controller',
          '$domain_name',
          '$state_sub_domain',
          '$sub_domain_dataarray',
          NOW(),
          UNIX_TIMESTAMP()
        ) ON DUPLICATE KEY UPDATE `city_sub_domains`='$sub_domain_dataarray',`unixtimestamp`= UNIX_TIMESTAMP()
      ";
    $ex = $db->execDB($q);
}

function domainMerge($wag_ob,$db,$main_domain_name,$ap_controller){
    $domains = retrieveDomains($wag_ob);
    $domain_exists = checkDomain($domains,$main_domain_name);
    if($domain_exists!==0){
        insertDomains(json_encode($domains),$db,$ap_controller);
    }

    return array($domains,$domain_exists);
}

function stateSubDomainMerge($wag_ob,$db,$main_domain_name,$ap_controller,$domain_id,$sub_domain_name1){
    $sub_domains = retrieveSubDomains($wag_ob,$domain_id);
    $sub_domain_exists = checkSubDomain($sub_domains,$sub_domain_name1);
    if($sub_domain_exists!==0){
        insertStateSubDomains(json_encode($sub_domains),$db,$ap_controller,$main_domain_name);
    }
    return array($sub_domains,$sub_domain_exists);
}

function citySubDomainMerge($wag_ob,$db,$main_domain_name,$ap_controller,$domain_id,$sub_domain_name2,$sub_domain_name1){
    $sub_domains = retrieveSubDomains($wag_ob,$domain_id);
    $sub_domain_exists = checkSubDomain($sub_domains,$sub_domain_name2);
    if($sub_domain_exists!==0){
        insertCitySubDomains(json_encode($sub_domains),$db,$ap_controller,$main_domain_name,$sub_domain_name1);
    }
    return array($sub_domains,$sub_domain_exists);
}

function createDomainAll($wag_ob,$db,$main_domain_name,$ap_controller){

        $domain_create = 0;
        $domain_id = '';
        $create_domain = $wag_ob->createDomain($main_domain_name);

        parse_str($create_domain,$create_domain_arr);

        $json_domain= (array)json_decode(urldecode($create_domain_arr['Description']),true);

        $query = "SELECT domains FROM `api_domain` WHERE `ap_controller`='$ap_controller'";
        $query_arr = $db->selectDB($query);
        if($query_arr['rowCount']>0){
            foreach ($query_arr['data'] as $row){
                $domains=json_decode($row['domains'],true);
            }
        }

        if($create_domain_arr['status_code']=='200'){
            $domain_create = 1;
            $domain_id = $json_domain['id'];
            $tArray = array('name'=>$main_domain_name,'id'=>$domain_id);
            array_push($domains,$tArray);
            insertDomains(json_encode($domains),$db,$ap_controller);
        }

        return array($domain_create,$domain_id);
}

function createSubDomainAll($wag_ob,$db,$main_domain_name,$ap_controller,$domain_id,$sub_domain_name1,$sub_domain_name2,$type){

        $sub_domain_create = 0;
        $sub_domain_id = '';
        
        if($type=='state'){
            $create_sub_domain = $wag_ob->createDomain(($sub_domain_name1),$domain_id);

            $query = "SELECT sub_domains FROM `api_state_subdomain` WHERE `ap_controller`='$ap_controller' AND domain='$main_domain_name'";
            $query_arr = $db->selectDB($query);
            if($query_arr['rowCount']>0){
                foreach ($query_arr['data'] as $row){
                    $sub_domains=json_decode($row['sub_domains'],true);
                }
            }
        }else{
            $create_sub_domain = $wag_ob->createDomain(($sub_domain_name2),$domain_id);
            $query = "SELECT city_sub_domains FROM `api_city_subdomain` WHERE `ap_controller`='$ap_controller' AND domain='$main_domain_name' AND state_sub_domain='$sub_domain_name1'";
            $query_arr = $db->selectDB($query);
            if($query_arr['rowCount']>0){
                foreach ($query_arr['data'] as $row){
                    $city_sub_domains=json_decode($row['city_sub_domains'],true);
                }
            }
        }


            parse_str($create_sub_domain,$create_sub_domain_arr);

            $json_sub_domain= (array)json_decode(urldecode($create_sub_domain_arr['Description']),true);

            if($create_sub_domain_arr['status_code']=='200'){
                $sub_domain_create = 1;
                $sub_domain_id = $json_sub_domain['id'];
                if($type=='state'){
                    $tArray = array('name'=>$sub_domain_name1,'id'=>$sub_domain_id);
                    array_push($sub_domains,$tArray);
                    insertStateSubDomains(json_encode($sub_domains),$db,$ap_controller,$main_domain_name);
                }else{
                    $tArray = array('name'=>$sub_domain_name2,'id'=>$sub_domain_id);
                    array_push($city_sub_domains,$tArray);
                    insertCitySubDomains(json_encode($subDomaincityArr),$db,$ap_controller,$main_domain_name,$sub_domain_name1);
                }
            }

        return array($sub_domain_create,$sub_domain_id);
}

function isExist($needle='', $haystack=array()){
    foreach ($haystack as $item) {
        if ($item['sub_domain_name']===$needle) {
            return array('status'=>true,'count'=>$item['count'],'sub_domain_id'=>$item['sub_domain_id'],'id'=>$item['id']);
        }
    }
    return array('status'=>false,'count'=>'','sub_domain_id'=>'','id'=>'');
}

function createDomainHierarchyNew($wag_ob,$value,$main_domain_name,$icomme_number,db_functions $db,$ap_controller,$max_subdomains,$subdomain_skip_min,$subdomain_skip_max){
    
    $domain_exists = 0;

    $query = "SELECT domains FROM `api_domain` WHERE `ap_controller`='$ap_controller'";
    $query_arr = $db->selectDB($query);
    if($query_arr['rowCount']>0){
        foreach ($query_arr['data'] as $row){
            $domains=json_decode($row['domains'],true);
        }
    }

    

    if(!empty($domains)){
        $domain_exists = checkDomain($domains,$main_domain_name);
        if($domain_exists===0){
            list($domains,$domain_exists) = domainMerge($wag_ob,$db,$main_domain_name,$ap_controller);
        }
    }else{
        list($domains,$domain_exists) = domainMerge($wag_ob,$db,$main_domain_name,$ap_controller);
    }

    $domain_id = $domain_exists;

    if($domain_exists === 0){

        list($domain_create,$domain_id) = createDomainAll($wag_ob,$db,$main_domain_name,$ap_controller);

    }else{

        $domain_create = 1;

    }
    
    if($domain_create === 1){
        $call_create = 0;
        $sub_domain_name = $main_domain_name.'1';
        $query1 = "SELECT id,sub_domain_id,sub_domain_name,`count` FROM `api_subdomains` WHERE ap_controller='$ap_controller' AND domain='$main_domain_name' ORDER BY sub_domain_name DESC";
        $query_arr2 = $db->selectDB($query1);

        $updated = 0;
        if($query_arr2['rowCount']<1){
            $sub_domains = retrieveSubDomains($wag_ob,$domain_id);
            foreach ($sub_domains as $value) {
               if(substr($value['name'], 0, strlen($main_domain_name)) === $main_domain_name && is_numeric(substr($value['name'], strlen($main_domain_name), (strlen($value['name'])-1)))){
                $sName = $value['name'];
                $sId = $value['id'];
                $sZoneCount = $value['zoneCount'];
                $q = "INSERT INTO `api_subdomains` ( `ap_controller`, `domain`, `sub_domain_id`, `sub_domain_name`, `count`, `create_date`, `unixtimestamp` ) VALUES ( '$ap_controller', '$main_domain_name', '$sId', '$sName', '$sZoneCount', NOW(), UNIX_TIMESTAMP() )";
                $qr = $db->execDB($q);
                if($qr!==true){
                    return array('status' => 'error', 'data' => 'Domain creation failed.');
                }
               }
            }

            $updated = 1;
        }

        if($updated == 1){
            $query_arr1 = $db->selectDB($query1);
        }else{
            $query_arr1 = $query_arr2;
        }

        if($query_arr1['rowCount']>0){
            for ($i=1; $i < 1000; $i++) { 
                $sub_domain_name = $main_domain_name.$i;
                if(((int)$i>=(int)$subdomain_skip_min) && ((int)$i<=(int)$subdomain_skip_max)){
                    continue;
                }
                $isExist = isExist($sub_domain_name,$query_arr1['data']);
                if($isExist['status']){
                    if($isExist['count']<(int)$max_subdomains){
                        $sub_domain_id=$isExist['sub_domain_id'];
                        $table_id=$isExist['id'];
                        if(!increaseCount($ap_controller, $main_domain_name, $sub_domain_name,$db)){
                            return array('status' => 'error', 'data' => 'Domain creation failed.');
                        }
                        break;
                    }
                }else{
                    $call_create = 1;
                    break;
                }
            }
        }else{
            
            $sub_domain_name = $main_domain_name.'1';
            $call_create = 1;
        }


        /* $query1 = "SELECT id,sub_domain_id,sub_domain_name,`count` FROM `api_subdomains` WHERE ap_controller='$ap_controller' AND domain='$main_domain_name' ORDER BY sub_domain_name DESC LIMIT 1";
        $query_arr2 = $db->selectDB($query1);
        $updated = 0;
        if($query_arr2['rowCount']<1){
            $sub_domains = retrieveSubDomains($wag_ob,$domain_id);
            foreach ($sub_domains as $value) {
               if(substr($value['name'], 0, strlen($main_domain_name)) === $main_domain_name && is_numeric(substr($value['name'], strlen($main_domain_name), (strlen($value['name'])-1)))){
                $sName = $value['name'];
                $sId = $value['id'];
                $sZoneCount = $value['zoneCount'];
                $q = "INSERT INTO `api_subdomains` ( `ap_controller`, `domain`, `sub_domain_id`, `sub_domain_name`, `count`, `create_date`, `unixtimestamp` ) VALUES ( '$ap_controller', '$main_domain_name', '$sId', '$sName', '$sZoneCount', NOW(), UNIX_TIMESTAMP() )";
                $qr = $db->execDB($q);
                if($qr!==true){
                    return array('status' => 'error', 'data' => 'Domain creation failed.');
                }
               }
            }

            $updated = 1;
        }

        if($updated == 1){
            $query_arr1 = $db->selectDB($query1);
        }else{
            $query_arr1 = $query_arr2;
        }

        if($query_arr1['rowCount']>0){
            foreach ($query_arr1['data'] as $row){
                $sub_domain_id=$row['sub_domain_id'];
                $sub_domain_name=$row['sub_domain_name'];
                $count=$row['count'];
                $table_id=$row['id'];
            }

            if($count>=(int)$max_subdomains){
                $domain_str = str_replace($main_domain_name, '', $sub_domain_name);
                    if(strlen($domain_str) > 0){
                        if(is_numeric($domain_str)){
                            $sub_domain_name = $main_domain_name.((int)$domain_str+1);
                        }
                    }
                $call_create = 1;
            }else{
                if(!increaseCount($ap_controller, $main_domain_name, $sub_domain_name,$db)){
                    return array('status' => 'error', 'data' => 'Domain creation failed.');
                }
            }
        }else{
            
            $sub_domain_name = $main_domain_name.'1';
            $call_create = 1;
        } */

        if($call_create == 1){

                $create_sub_domain = $wag_ob->createDomain(($sub_domain_name),$domain_id);
                parse_str($create_sub_domain,$create_sub_domain_arr);
                $json_sub_domain= (array)json_decode(urldecode($create_sub_domain_arr['Description']),true);
                $sub_domain_id = $json_sub_domain['id'];

            if($create_sub_domain_arr['status_code']=='200'){
                
                $q = "INSERT INTO `api_subdomains` ( `ap_controller`, `domain`, `sub_domain_id`, `sub_domain_name`, `count`, `create_date`, `unixtimestamp` ) VALUES ( '$ap_controller', '$main_domain_name', '$sub_domain_id', '$sub_domain_name', 1, NOW(), UNIX_TIMESTAMP() )";
                $qr = $db->execDB($q);
                
                if($qr===true){

                    $sq = "SELECT id FROM api_subdomains WHERE ap_controller='$ap_controller' AND domain='$main_domain_name' AND sub_domain_name='$sub_domain_name'";
                    $sqr = $db->select1DB($sq);
                    $table_id = $sqr['id'];
                    
                    $resp_arr = array('status' => 'success', 'data' => $sub_domain_id,'table_id'=>$table_id);
                }else{
                    $resp_arr = array('status' => 'error', 'data' => 'Domain creation failed.');
                }
            }else{
                $resp_arr = array('status' => 'error', 'data' => 'Domain creation failed.');
            }
        }else{
            $resp_arr = array('status' => 'success', 'data' => $sub_domain_id,'table_id'=>$table_id);
        }

    }else{
        $resp_arr = array('status' => 'error', 'data' => 'Domain creation failed.');
    }

    return $resp_arr;

}

function increaseCount($ap_controller, $domain, $sub_domain_name,$db)
{
    $q = "UPDATE api_subdomains SET `count` = `count` + 1 WHERE ap_controller = '$ap_controller' AND domain='$domain' AND sub_domain_name = '$sub_domain_name'";
    $qr = $db->execDB($q);
    if ($qr === true) {
        return true ;
    }else{
        return false;
    }
}

function decreaseCount($id,$db)
{
    $q = "UPDATE api_subdomains SET `count` = `count` - 1 WHERE id = '$id'";
    $qr = $db->execDB($q);
    if ($qr === true) {
        return true ;
    }else{
        return false;
    }
}

function stateName(){
    return [
        'AL'=>'Alabama',
        'AK'=>'Alaska',
        'AS'=>'American Samoa',
        'AZ'=>'Arizona',
        'AR'=>'Arkansas',
        'CA'=>'California',
        'CO'=>'Colorado',
        'CT'=>'Connecticut',
        'DE'=>'Delaware',
        'DC'=>'District Of Columbia',
        'FM'=>'Federated States Of Micronesia',
        'FL'=>'Florida',
        'GA'=>'Georgia',
        'GU'=>'Guam Gu',
        'HI'=>'Hawaii',
        'ID'=>'Idaho',
        'IL'=>'Illinois',
        'IN'=>'Indiana',
        'IA'=>'Iowa',
        'KS'=>'Kansas',
        'KY'=>'Kentucky',
        'LA'=>'Louisiana',
        'ME'=>'Maine',
        'MH'=>'Marshall Islands',
        'MD'=>'Maryland',
        'MA'=>'Massachusetts',
        'MI'=>'Michigan',
        'MN'=>'Minnesota',
        'MS'=>'Mississippi',
        'MO'=>'Missouri',
        'MT'=>'Montana',
        'NE'=>'Nebraska',
        'NV'=>'Nevada',
        'NH'=>'New Hampshire',
        'NJ'=>'New Jersey',
        'NM'=>'New Mexico',
        'NY'=>'New York',
        'NC'=>'North Carolina',
        'ND'=>'North Dakota',
        'MP'=>'Northern Mariana Islands',
        'OH'=>'Ohio',
        'OK'=>'Oklahoma',
        'OR'=>'Oregon',
        'PW'=>'Palau',
        'PA'=>'Pennsylvania',
        'PR'=>'Puerto Rico',
        'RI'=>'Rhode Island',
        'SC'=>'South Carolina',
        'SD'=>'South Dakota',
        'TN'=>'Tennessee',
        'TX'=>'Texas',
        'UT'=>'Utah',
        'VT'=>'Vermont',
        'VI'=>'Virgin Islands',
        'VA'=>'Virginia',
        'WA'=>'Washington',
        'WV'=>'West Virginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming',
        'AE'=>'Armed Forces Africa \ Canada \ Europe \ Middle East',
        'AA'=>'Armed Forces America (Except Canada)',
        'AP'=>'Armed Forces Pacific',
        'UU'=>'UU'
    ];
}

function createDomainHierarchy1($wag_ob,$value,$main_domain_name,$parent_pref,db_functions $db,$ap_controller){

    $us_state_abbrevs_names = stateName();

    $state = strtoupper(trim($value['address']['state']));

    if(strlen($us_state_abbrevs_names[$state]) > 0){
        $sub_domain_name1 = $us_state_abbrevs_names[$state];
    }else{
        $sub_domain_name1 = $state;
        throw new APIException('',1003);
    }

    $domains = array();
    $domain_exists = 10;
    $query = "SELECT domains FROM `api_domain` WHERE `ap_controller`='$ap_controller'";
    $query_arr = $db->selectDB($query);
    if($query_arr['rowCount']>0){
        foreach ($query_arr['data'] as $row){
            $domains=json_decode($row['domains'],true);
        }
    }


    if(!empty($domains)){
        $domain_exists = checkDomain($domains,$main_domain_name);
        if($domain_exists==0){
            list($domains,$domain_exists) = domainMerge($wag_ob,$db,$main_domain_name,$ap_controller);
        }
    }else{
        
        list($domains,$domain_exists) = domainMerge($wag_ob,$db,$main_domain_name,$ap_controller);
    }

    $domain_id = $domain_exists;

    if($domain_exists === 0){

        list($domain_create,$domain_id) = createDomainAll($wag_ob,$db,$main_domain_name,$ap_controller);

    }else{

        $domain_create = 1;

    }

    if($domain_create == 1){

        $sub_domains = array();
        $sub_domain_exists = 0;
        $query = "SELECT sub_domains FROM `api_state_subdomain` WHERE `ap_controller`='$ap_controller' AND domain='$main_domain_name'";
        $query_arr = $db->selectDB($query);
        if($query_arr['rowCount']>0){
            foreach ($query_arr['data'] as $row){
                $sub_domains=json_decode($row['sub_domains'],true);
            }
        }

        if(!empty($sub_domains)){
            $sub_domain_exists = checkSubDomain($sub_domains,$sub_domain_name1);
            if($sub_domain_exists==0){
                list($sub_domains,$sub_domain_exists) = stateSubDomainMerge($wag_ob,$db,$main_domain_name,$ap_controller,$domain_id,$sub_domain_name1);
            }
        }else{
            
            list($sub_domains,$sub_domain_exists) = stateSubDomainMerge($wag_ob,$db,$main_domain_name,$ap_controller,$domain_id,$sub_domain_name1);
        }

        $sub_domain_id = $sub_domain_exists;

        if($sub_domain_exists === 0){

            list($sub_domain_create,$sub_domain_id) = createSubDomainAll($wag_ob,$db,$main_domain_name,$ap_controller,$domain_id,$sub_domain_name1);
            
        }else{

            $sub_domain_create = 1;

        }

        if($sub_domain_create == 1){

            $city_sub_domains = array();
            $city_sub_domain_exists = 0;
            $query = "SELECT city_sub_domains FROM `api_city_subdomain` WHERE `ap_controller`='$ap_controller' AND domain='$main_domain_name' AND state_sub_domain='$sub_domain_name1'";
            $query_arr = $db->selectDB($query);
            if($query_arr['rowCount']>0){
                foreach ($query_arr['data'] as $row){
                    $city_sub_domains=json_decode($row['city_sub_domains'],true);
                }
            }

            $sub_domain_name2 =ucwords(strtolower(($value['address']['city'].' - '.$value['address']['zip'])));

            if(!empty($city_sub_domains)){
                $city_sub_domain_exists = checkSubDomain($city_sub_domains,$sub_domain_name2);
                if($city_sub_domain_exists==0){
                    list($city_sub_domains,$city_sub_domain_exists) = citySubDomainMerge($wag_ob,$db,$main_domain_name,$ap_controller,$sub_domain_id,$sub_domain_name2,$sub_domain_name1);
                }
            }else{
                
                list($city_sub_domains,$city_sub_domain_exists) = citySubDomainMerge($wag_ob,$db,$main_domain_name,$ap_controller,$sub_domain_id,$sub_domain_name2,$sub_domain_name1);
            }


            if($city_sub_domain_exists === 0){

                list($sub_domain_create2,$sub_domain_id2) = createSubDomainAll($wag_ob,$db,$main_domain_name,$ap_controller,$sub_domain_id,$sub_domain_name2);
                
            }else{

                $sub_domain_create2 = 1;

            }


            if($sub_domain_create2 == 1){
                $resp_arr = array('status' => 'success', 'data' => $sub_domain_id2);
            }else{
                $resp_arr = array('status' => 'error', 'data' => 'Domain creation failed.');
            }
 
        }else{
            $resp_arr = array('status' => 'error', 'data' => 'Domain creation failed.');
        }

    }else{
        $resp_arr = array('status' => 'error', 'data' => 'Domain creation failed.');
    }

    return $resp_arr;
}

function checkAlldomainTable($db,$ap_controller,$main_domain_name,$sub_domain_name1,$sub_domain_name2){
    
    $domain_exists = 0;
    $sub_domain_exists = 0;
    $city_sub_domain_exists = 0;
    $callApi = 0;

    $query = "SELECT domains FROM `api_domain` WHERE `ap_controller`='$ap_controller'";
    $query_arr = $db->selectDB($query);
    if($query_arr['rowCount']>0){
        foreach ($query_arr['data'] as $row){
            $domains=json_decode($row['domains'],true);
        }
    }

    $domain_exists = checkDomain($domains,$main_domain_name);

    $query = "SELECT sub_domains FROM `api_state_subdomain` WHERE `ap_controller`='$ap_controller' AND domain='$main_domain_name'";
        $query_arr = $db->selectDB($query);
        if($query_arr['rowCount']>0){
            foreach ($query_arr['data'] as $row){
                $sub_domains=json_decode($row['sub_domains'],true);
            }
        }
    $sub_domain_exists = checkSubDomain($sub_domains,$sub_domain_name1);
    
    $query = "SELECT city_sub_domains FROM `api_city_subdomain` WHERE `ap_controller`='$ap_controller' AND domain='$main_domain_name' AND state_sub_domain='$sub_domain_name1'";
            $query_arr = $db->selectDB($query);
            if($query_arr['rowCount']>0){
                foreach ($query_arr['data'] as $row){
                    $city_sub_domains=json_decode($row['city_sub_domains'],true);
                }
            }
    $city_sub_domain_exists = checkSubDomain($city_sub_domains,$sub_domain_name2);  
    
    if($domain_exists===0 || $sub_domain_exists===0 || $city_sub_domain_exists===0){
        $callApi = 1;
    }

    return array($callApi,$domain_exists,$sub_domain_exists,$city_sub_domain_exists);
}

function retrieveDomainsNew($wag_ob,$db,$ap_controller,$main_domain_name,$sub_domain_name1,$sub_domain_name2){
    
    $domainsArr = array();
    $domain_exists = 0;
    $sub_domain_exists = 0;
    $city_sub_domain_exists = 0;
    $arrr = array("filters" => array());
    $domains = $wag_ob->retrieveDomainsNew($arrr);
    parse_str($domains,$domainsFullArr);
    $Description = json_decode($domainsFullArr['Description'],true);
    foreach ($Description['children'] as $value) {
        if($value['type']=='DOMAIN'){
            $d = array('name'=>$value['domainName'],'id'=>$value['domainUUID']);
            array_push($domainsArr,$d);
            $subDomainArr = array();
            foreach ($value['children'] as $value1) {
                if($value1['type']=='DOMAIN'){
                    $e = array('name'=>$value1['domainName'],'id'=>$value1['domainUUID']);
                    array_push($subDomainArr,$e);
                    $subDomaincityArr = array();
                    foreach ($value1['children'] as $value2) {
                        if($value2['type']=='DOMAIN'){
                            $f = array('name'=>$value2['domainName'],'id'=>$value2['domainUUID']);
                            array_push($subDomaincityArr,$f);
                            if($value2['domainName']==$sub_domain_name2){
                                $city_sub_domain_exists = $value2['domainUUID'];
                            }
                        }
                    }

                    insertCitySubDomains(json_encode($subDomaincityArr),$db,$ap_controller,$value['domainName'],$value1['domainName']);
                    if($value1['domainName']==$sub_domain_name1){
                        $sub_domain_exists = $value1['domainUUID'];
                    }
                }
            }
            insertStateSubDomains(json_encode($subDomainArr),$db,$ap_controller,$value['domainName']);

            if($value['domainName']==$main_domain_name){
                $domain_exists = $value['domainUUID'];
            }
        }
    }

    insertDomains(json_encode($domainsArr),$db,$ap_controller);

    return array($domain_exists,$sub_domain_exists,$city_sub_domain_exists);
}

function createDomainHierarchy($wag_ob,$value,$main_domain_name,$parent_pref,db_functions $db,$ap_controller){
    
    $us_state_abbrevs_names = array(
    'AL'=>'Alabama',
    'AK'=>'Alaska',
    'AS'=>'American Samoa',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District Of Columbia',
    'FM'=>'Federated States Of Micronesia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'GU'=>'Guam Gu',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MH'=>'Marshall Islands',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'MP'=>'Northern Mariana Islands',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PW'=>'Palau',
    'PA'=>'Pennsylvania',
    'PR'=>'Puerto Rico',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VI'=>'Virgin Islands',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming',
    'AE'=>'Armed Forces Africa \ Canada \ Europe \ Middle East',
    'AA'=>'Armed Forces America (Except Canada)',
    'AP'=>'Armed Forces Pacific',
    'UU'=>'UU'
);



    $state = strtoupper(trim($value['address']['state']));

    if(strlen($us_state_abbrevs_names[$state]) > 0){
        $sub_domain_name1 = $us_state_abbrevs_names[$state];
    }else{
        $sub_domain_name1 = $state;
        throw new APIException('',1003);
    }

    $sub_domain_name2 =ucwords(strtolower(($value['address']['city'].' - '.$value['address']['zip'])));

    list($callApi,$domain_exists,$sub_domain_exists,$city_sub_domain_exists) = checkAlldomainTable($db,$ap_controller,$main_domain_name,$sub_domain_name1,$sub_domain_name2);
    
    if($callApi==1){
        list($domain_exists,$sub_domain_exists,$city_sub_domain_exists) = retrieveDomainsNew($wag_ob,$db,$ap_controller,$main_domain_name,$sub_domain_name1,$sub_domain_name2);
    }
    

    $domain_id = $domain_exists;
    if($domain_exists === 0){
        list($domain_create,$domain_id) = createDomainAll($wag_ob,$db,$main_domain_name,$ap_controller);
    }else{
        $domain_create = 1;
    }

    $sub_domain_id = $sub_domain_exists;
    if($sub_domain_exists === 0){
        list($sub_domain_create,$sub_domain_id) = createSubDomainAll($wag_ob,$db,$main_domain_name,$ap_controller,$domain_id,$sub_domain_name1,$sub_domain_name2,'state');   
    }else{
        $sub_domain_create = 1;
    }

    $sub_domain_id2 = $city_sub_domain_exists;
    if($city_sub_domain_exists === 0){
        list($sub_domain_create2,$sub_domain_id2) = createSubDomainAll($wag_ob,$db,$main_domain_name,$ap_controller,$sub_domain_id,$sub_domain_name1,$sub_domain_name2,'city'); 
    }else{
        $sub_domain_create2 = 1;
    }
    if($domain_create===1 && $sub_domain_create===1 && $sub_domain_create2===1){
        $resp_arr = array('status' => 'success', 'data' => $sub_domain_id2);
    }else{
        $resp_arr = array('status' => 'error', 'data' => 'Domain creation failed.');
    }
    return $resp_arr;
}



function getRealm(array $icom_pool,$prefix,db_functions $db)
{

    $icom_rang_min = $icom_pool['min'];
    $icom_rang_max = $icom_pool['max'];

    //Get deleted realms if exists
    $q = "SELECT id,suffix,icom,'0' as reuse FROM exp_api_icom_pool WHERE prefix='$prefix' ORDER BY id DESC LIMIT 1";
    //Always select 0 to prevent using used realm again
    $r = $db->selectDB($q);

    /*Parameterized*/
    $rowCount = $r['rowCount'];

    if ($rowCount == '0') {

        $suffix = $icom_rang_min;
        $icom = $suffix;
        $q_insert = "INSERT INTO exp_api_icom_pool(prefix, suffix, icom, status, create_date) VALUES('$prefix','$suffix','$icom','1',NOW())";
        $db->execDB($q_insert);
        $return_icom = $icom;

    } elseif ($rowCount > 0) {
        $reuse = $r['data'][0]['reuse'];
        $icom = $r['data'][0]['icom'];
        $suffix = $r['data'][0]['suffix'];
        $id = $r['data'][0]['id'];

        if ($reuse == '1') {
            $q_update = "UPDATE exp_api_icom_pool SET status='1' WHERE id='$id'";
            $db->execDB($q_update);
            $return_icom = $icom;

        }
        elseif ($reuse == '0') {

            if ($suffix < $icom_rang_min || $icom_rang_max < $suffix) {

                $suffix = $icom_rang_min - 1;

            }

            $loop_count = 0;
            $loop_condition = true;
            do {
                $loop_count++;

                /////
                $next_suffix = $suffix + $loop_count;
                $str_pad_length = strlen($icom_rang_min);
                if($str_pad_length>count($next_suffix)){
                    $next_suffix =  str_pad($next_suffix,$str_pad_length,0,STR_PAD_LEFT );
                }

                if ($icom_rang_min <= $next_suffix && $next_suffix <= $icom_rang_max) {
                    $next_icom = $next_suffix;
                    $q = "SELECT id as f FROM exp_mno_distributor WHERE verification_number='$next_icom'";
                    $used = $db->getValueAsf($q);

                    if (empty($used)) {
                        $q_next_icom_ins = "INSERT INTO exp_api_icom_pool(prefix, suffix, icom, status, create_date) VALUES ('$prefix','$next_suffix','$next_icom','1',NOW())";
                        $q_next_icom_insQ = $db->execDB($q_next_icom_ins);

                        if($q_next_icom_insQ===true){
                            $return_icom = $next_icom;
                            $loop_condition = false;
                        }
                        
                    }
                } else {
                    $error = "icom_range_full";
                    $loop_condition = false;
                }


            } while ($loop_condition);
        }
    }

    return array("icom"=>$return_icom,"error"=>$error);
}

if (!function_exists('freeRealm')){
function freeRealm($realm,db_functions $db,$delete=false){

    if($delete){
        $q = "DELETE FROM `exp_api_icom_pool` WHERE icom='$realm'";
    }else{
        $q = "UPDATE exp_api_icom_pool SET status='0' WHERE icom='$realm'";
    }

    $db->execDB($q);
}
}

function prefixConvert($api_prefix){
    return str_replace("_OLD","",$api_prefix);
}

function productSync($db,$network_name,$system_package,$product_name_def,$mno_id,$live_user_name){
    $row1 = $db->select1DB("SELECT * FROM `exp_network_profile` WHERE network_profile = '$network_name'");
                $network_profile=$row1['api_network_auth_method'];
                require_once('../AAA/'.$network_profile.'/index.php'); 
                $nf=new aaa($network_name,$system_package);

                $allproduct=$nf->getAllProducts("");

                $obj = json_decode($allproduct,true);

                foreach($obj as $key => $product) {
                    $product_name = trim($product['Id']);
                    
                    if($product_name==$product_name_def){
                        $product_id=uniqid();
                        $tm_gap  = $product['Account-Valid-Until-Time'];
                        $description  = $product['Service-Profiles']['0'];
                        $prod_q = "INSERT INTO `exp_products` (
                            `product_id`,
                            `product_name`,
                            `product_code`,
                            `QOS`,
                            `QOS_up_link`,
                            `network_type`,
                            `time_gap`,
                            `max_session`,
                            `session_alert`,
                            `purge_time`,
                            `mno_id`,
                            `create_date`,
                            `create_user`
                          )
                          VALUES
                            (
                              '$product_id',
                              '$product_name',
                              '$product_name',
                              '$description',
                              '',
                              'GUEST',
                              '$tm_gap',
                              '',
                              'You reached the maximum number of sessions per day. Please come back.',
                              '',
                              '$mno_id',
                              NOW(),
                              '$live_user_name'
                            )";
    
                    $db->execDB($prod_q);
                    }
                }
}

function setControllers($configFileArr,db_functions $db,$parent_pref,$mno_id,$property_id=null){

        $wag_ap_name = 'Ruckus5.0';
        $ap_controller_name = $parent_pref.' AP Controller API';
        $sw_controller_name = $parent_pref.' Switch Controller API';
        $api_profile = $configFileArr['ap_controller_version'];
        $api_url = $configFileArr['ap_controller_ip_address'];
        $api_uname = $configFileArr['ap_controller_user_name'];
        $api_pass = $configFileArr['ap_controller_password'];
        $switch_api_profile = $configFileArr['switch_controller_version'];
        $switch_api_url = $configFileArr['switch_controller_ip_address'];
        $switch_api_uname = $configFileArr['switch_controller_user_name'];
        $switch_api_pass = $configFileArr['switch_controller_password'];
        $icom_pool_min = $configFileArr['icom_range_min'];
        $icom_pool_max = $configFileArr['icom_range_max'];
        
        $api_controlQ = "SELECT id,api_profile,api_url,api_username,api_password,controller_name FROM exp_locations_ap_controller WHERE controller_name LIKE '%$ap_controller_name%' AND TYPE='AP' ORDER BY LENGTH(controller_name) DESC,controller_name DESC";
        //$api_controlQ = "SELECT l.id,l.api_profile,l.api_url,l.api_username,l.api_password,l.controller_name FROM exp_locations_ap_controller l,`exp_mno_ap_controller` m WHERE m.`mno_id`='$mno_id' AND m.`ap_controller`=l.`controller_name` AND l.controller_name LIKE '%$ap_controller_name%' AND l.`type`='AP' ORDER BY LENGTH(l.controller_name) DESC,l.controller_name DESC";

        $data2 = $db->selectDB($api_controlQ);

        $contrExists = 0;
        $cotrlSet = 0;

        if ($data2['rowCount']>0) {
            foreach($data2['data'] AS $row){
                if(($row['api_url']==$api_url) && ($row['api_profile']==$api_profile)){
                    $check_ap_controller = $row['controller_name'];
                    $dataMno = $db->selectDB("SELECT id FROM `exp_mno_ap_controller` WHERE ap_controller='$check_ap_controller' AND mno_id='$mno_id'");
                    if($dataMno['rowCount']>0){
                        $contrExists = 1;
                        $ap_controller = $row['controller_name'];
                        $exapi_url = $row['api_url'];
                        $exapi_username = $row['api_username'];
                        $exapi_pass = $row['api_pass'];
                        $apid = $row['id'];
                        break;
                    }
                }
                
                if($cotrlSet == 0){

                    $ap_controllerStr = str_replace($ap_controller_name, '', $row['controller_name']);

                    if(strlen($ap_controllerStr) > 0){
                        if(is_numeric($ap_controllerStr)){
                            $ap_controller = $ap_controller_name.((int)$ap_controllerStr+1);
                            $cotrlSet = 1;
                        }
                    }else{

                        if($ap_controller_name==$row['controller_name']){
                            $ap_controller = $ap_controller_name.'1';
                        }else{
                            $ap_controller = $ap_controller_name; 
                        }

                        $cotrlSet = 1;
                    }
                }
            }
        }else{
            $ap_controller = $ap_controller_name;
        }


        if($contrExists==0){

            $time_zone = 'America/New_York';
            $api_url_se = '';
            $ap_con_name = $ap_controller;
            $brand = 'RUCKUS';
            $model = 'Virtual SmartZone';
            $desc = $ap_controller;
            $ip_address = '';
            $user_namec = 'admin';
            $type = 'AP';
           
            $querycontroller = "INSERT INTO  `exp_locations_ap_controller` (`time_zone`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`controller_name`, `brand`, `model`, `description`, `ip_address`, `create_date`, `create_user`, `type`)
                VALUES ('$time_zone','$api_profile','$api_url','$api_url_se','$api_uname','$api_pass','$ap_con_name', '$brand', '$model', '$desc', '$ip_address', NOW(), '$user_namec', '$type')";
                
                $Rquerycontroller = $db->execDB($querycontroller);

                $apContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");

                if(!($Rquerycontroller===true)){
                    $db->queryLog($property_id, $mno_id, $mvnx_id,$querycontroller,'exp_locations_ap_controller insert','API',$Rquerycontroller);
                    throw new APIWithErrorsException('',0,array('database'=>'Query failed'));
                }

                $querycontrollerMno ="INSERT INTO `exp_mno_ap_controller` (`mno_id`, `ap_controller`, `create_user`, `create_date`)
                VALUES ('$mno_id', '$ap_controller', '$user_namec',NOW())";

                $RquerycontrollerMno = $db->execDB($querycontrollerMno);

                if(!($RquerycontrollerMno===true)){
                    $db->queryLog($property_id, $mno_id, $mvnx_id,$querycontrollerMno,'exp_mno_ap_controller insert','API',$RquerycontrollerMno);
                }

                $ap_control_var = $db->setVal('ap_controller', 'ADMIN');
                $wag_ap_name2 = $api_profile;
                    if($ap_control_var=='MULTIPLE'){

                        include '../AP/' . $wag_ap_name2 . '/index.php';
                        if($wag_ap_name2==""){
                            include '../AP/' . $wag_ap_name . '/index.php';
                        }

                        $wag_obj3 = new ap_wag($ap_controller);

                    }else if($ap_control_var=='SINGLE'){

                        include '../AP/' . $wag_ap_name . '/index.php';
                        $wag_obj3 = new ap_wag();
                    }



                        $getSystemTime = $wag_obj3->retrieveSystemTime();
                        parse_str($getSystemTime, $getSystemTime_arr);
                        $getSystemTime_obj = (array)json_decode(urldecode($getSystemTime_arr['Description']));

                        $systemTimeZOne = $getSystemTime_obj['timezone'];
                        
                        if(strlen($getSystemTime_obj['timezone']) > 0){
                            $db->execDB("UPDATE `exp_locations_ap_controller` SET `time_zone`='$systemTimeZOne' WHERE `controller_name`='$ap_controller'");
                        }

        }else{

            if(($exapi_username != $api_uname) || ($exapi_pass != $api_pass)){

                $db->execDB("UPDATE `exp_locations_ap_controller` SET api_url='$api_url',api_username='$api_uname',api_password='$api_pass' WHERE controller_name='$ap_controller' AND type='AP'");

            }
            $apContAutoInc = $apid;

            $ap_control_var = $db->setVal('ap_controller', 'ADMIN');
            $wag_ap_name2 = $api_profile;
            if($ap_control_var=='MULTIPLE'){

                include '../AP/' . $wag_ap_name2 . '/index.php';

                if($wag_ap_name2==""){
                    include '../AP/' . $wag_ap_name . '/index.php';
                }
                $a = '../AP/' . $wag_ap_name2 . '/index.php';

                $wag_obj3 = new ap_wag($ap_controller);

            }else if($ap_control_var=='SINGLE'){

                include '../AP/' . $wag_ap_name . '/index.php';
                $wag_obj3 = new ap_wag();
            }

        }
    $wag_obj3->AutoInc = $apContAutoInc;



        $api_controlswitchQ = "SELECT api_profile,api_url,api_username,api_password,controller_name FROM exp_locations_ap_controller WHERE controller_name LIKE '%$sw_controller_name%' AND TYPE='SW' ORDER BY LENGTH(controller_name) DESC,controller_name DESC";

         $data3 = $db->selectDB($api_controlswitchQ);

         $contrExistsSw = 0;
        $cotrlSetSw = 0;

        if ($data3['rowCount']>0) {
            foreach($data3['data'] AS $row){
                if(($row['api_url']==$switch_api_url) && ($row['api_profile']==$switch_api_profile)){
                    $check_switch_controller = $row['controller_name'];
                    $dataMno = $db->selectDB("SELECT id FROM `exp_mno_ap_controller` WHERE ap_controller='$check_switch_controller' AND mno_id='$mno_id'");
                    if($dataMno['rowCount']>0){
                        $contrExistsSw = 1;
                        $sw_controller = $row['controller_name'];
                        $exapi_url = $row['api_url'];
                        $exapi_username = $row['api_username'];
                        $exapi_pass = $row['api_pass'];
                        break;
                    }
                }
                
                if($cotrlSetSw == 0){

                    $ap_controllerStrSw = str_replace($sw_controller_name, '', $row['controller_name']);

                    if(strlen($ap_controllerStrSw) > 0){
                        if(is_numeric($ap_controllerStrSw)){
                            $sw_controller = $sw_controller_name.((int)$ap_controllerStrSw+1);
                            $cotrlSetSw = 1;
                        }
                    }else{

                        if($sw_controller_name==$row['controller_name']){
                            $sw_controller = $sw_controller_name.'1';
                        }else{
                            $sw_controller = $sw_controller_name; 
                        }
                        $cotrlSetSw = 1;
                    }
                }
            }
        }else{
            $sw_controller = $sw_controller_name;
        }



        if($contrExistsSw==0){

            $time_zone = 'America/New_York';
            $api_url_se = '';
            $brand = 'RUCKUS';
            $model = 'Virtual SmartZone';
            $ip_address = '';
            $user_namec = 'admin';
           
            $querycontroller1 = "INSERT INTO  `exp_locations_ap_controller` (`time_zone`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`controller_name`, `brand`, `model`, `description`, `ip_address`, `create_date`, `create_user`, `type`)
                VALUES ('$time_zone','$switch_api_profile','$switch_api_url','$api_url_se','$switch_api_uname','$switch_api_pass','$sw_controller', '$brand', '$model', '$sw_controller', '$ip_address', NOW(), '$user_namec', 'SW')";

                $Rquerycontroller1 = $db->execDB($querycontroller1);

                if(!($Rquerycontroller1===true)){
                    $db->queryLog($property_id, $mno_id, $mvnx_id,$querycontroller1,'exp_locations_ap_controller insert','API',$Rquerycontroller1);
                    throw new APIWithErrorsException('',0,array('database'=>'Query failed'));
                }

                $querycontroller2 ="INSERT INTO `exp_mno_ap_controller` (`mno_id`, `ap_controller`, `create_user`, `create_date`)
                VALUES ('$mno_id', '$sw_controller', '$user_namec',NOW())";

                $Rquerycontroller2 = $db->execDB($querycontroller2);

                if(!($Rquerycontroller2===true)){
                    $db->queryLog($property_id, $mno_id, $mvnx_id,$querycontroller2,'exp_mno_ap_controller insert','API',$Rquerycontroller2);
                }

                if($switch_api_url!=$api_url || $api_profile!=$switch_api_profile){

                     $ap_q2="SELECT `api_profile` AS f
            FROM `exp_locations_ap_controller`
            WHERE `controller_name`='$sw_controller'
            LIMIT 1";

                $wag_ap_name3 = $db->getValueAsf($ap_q2);
                $ap_control_var = $db->setVal('ap_controller', 'ADMIN');

                    if($ap_control_var=='MULTIPLE'){

                        include '../AP/' . $wag_ap_name3 . '/switch_index.php';
                        if($wag_ap_name3==""){
                            include '../AP/' . $wag_ap_name . '/switch_index.php';
                        }

                       $wag_objSw = new switch_wag($sw_controller);

                    }else if($ap_control_var=='SINGLE'){

                        include '../AP/' . $wag_ap_name . '/switch_index.php';
                        $wag_objSw = new switch_wag();

                    }


                }else{
                    $wag_objSw = $wag_obj3;
                }

                    $getSystemTime = $wag_objSw->retrieveSystemTime();
                    parse_str($getSystemTime, $getSystemTime_arr);
                    $getSystemTime_obj = (array)json_decode(urldecode($getSystemTime_arr['Description']));

                    $systemTimeZOne = $getSystemTime_obj['timezone'];
                        
                    if(strlen($getSystemTime_obj['timezone']) > 0){
                            $db->execDB("UPDATE `exp_locations_ap_controller` SET `time_zone`='$systemTimeZOne' WHERE `controller_name`='$sw_controller'");
                    }

        }else{

            $exapi_url = $data3['data'][0]['api_url'];
            $exapi_username = $data3['data'][0]['api_username'];
            $exapi_pass = $data3['data'][0]['api_pass'];

            if(($exapi_username != $switch_api_uname) || ($exapi_pass != $switch_api_pass)){

                $db->execDB("UPDATE `exp_locations_ap_controller` SET api_url='$switch_api_url',api_username='$switch_api_uname',api_password='$switch_api_pass' WHERE controller_name='$sw_controller' AND type='SW'");

            }

            if($switch_api_url!=$api_url || $api_profile!=$switch_api_profile){

                     $ap_q2="SELECT `api_profile` AS f
            FROM `exp_locations_ap_controller`
            WHERE `controller_name`='$sw_controller'
            LIMIT 1";

                $wag_ap_name3 = $db->getValueAsf($ap_q2);
                $ap_control_var = $db->setVal('ap_controller', 'ADMIN');

                    if($ap_control_var=='MULTIPLE'){

                        include '../AP/' . $wag_ap_name3 . '/switch_index.php';
                        if($wag_ap_name3==""){
                            include '../AP/' . $wag_ap_name . '/switch_index.php';
                        }

                       $wag_objSw = new switch_wag($sw_controller);

                    }else if($ap_control_var=='SINGLE'){

                        include '../AP/' . $wag_ap_name . '/switch_index.php';
                        $wag_objSw = new switch_wag();

                    }

                }else{
                    $wag_objSw = $wag_obj3;
                }

        }

        return array($wag_obj3,$wag_objSw,$sw_controller,$ap_controller);

}

function rollbackQuery($array,$db){

    foreach ($array as $value) {
        $result = $db->execDB($value);
        if(!($result===true)){
            $db->queryLog('', '', '',$value,'rollback','API',$result);
        }
    }
}

function getCoordinates($address,db_functions $db){
    $google_api_key = $db->setVal('google_api_key', 'ADMIN');
    $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&sensor=false&key='.$google_api_key); 
    $output = json_decode($geocodeFromAddr);
    $latitude  = number_format($output->results[0]->geometry->location->lat,6); 
    $longitude = number_format($output->results[0]->geometry->location->lng,6);
    return array("latitude"=>$latitude,"longitude"=>$longitude);
}

function getZoneAffinityProfile(db_functions $db,$wag,$state){
    $controllerID = $wag->AutoInc;
    $checkExistQ = "SELECT `profile_vsz_id`,`name` FROM exp_zoneAffinity_profile a join exp_locations_ap_controller c ON a.controller_id=c.id WHERE c.id='$controllerID'";

    $affinity_data = $db->selectDB($checkExistQ);
    $selectAffId = null;
    if($affinity_data['rowCount']>0){
        foreach ($affinity_data['data'] as $row){
            if($row['name']==$state){
                $selectAffId = $row['profile_vsz_id'];
                break;
            }
        }
    }else{
        $response = $wag->getZoneAffinity();
        if($response['success']){
            $data = json_decode($response['Description']);
            $ap='';
            foreach ($data->list as $item) {
                $other = json_encode(['zoneAffinityList'=>$item->zoneAffinityList,'zoneAffinityListWithPriority'=>$item->zoneAffinityListWithPriority]);
                $q = "INSERT INTO exp_zoneAffinity_profile(`controller_id`,`profile_vsz_id`,`name`,`description`,`other_option`,`create_user`,`create_date`)
                      VALUES ('$controllerID','$item->id','$item->name','$item->description','$other','sync',NOW())";
                $db->execDB($q);
                $ap.=$q;
                if($item->name==$state){
                    $selectAffId = $item->id;
                }

            }

        }
    }

    return$selectAffId;

}

function getHotspot20Operator(db_functions $db,$wag,$name){

    $opt = null;

    $res = $wag->getHotspot20Operators();
    if($res['success']===true){
        $list = json_decode($res['Description']);
        foreach ($list->list as $list_item){
            if($list_item->name==$name){
                $opt = ['id'=>$list_item->id,'name'=>$list_item->name];
                break;
            }
        }
    }

    return $opt;
}

function getHotspot20IDP(db_functions $db,$wag,$name)
{

    $pro = null;
    $res = $wag->getHotspot20IDPs();

    if($res['success']===true){
        $list = json_decode($res['Description']);
        foreach ($list->list as $list_item){
            if($list_item->name==$name){
                $pro[] = ['id'=>$list_item->id,'name'=>$list_item->name];
                //break;
            }
        }
    }

    return $pro;
}

function readAffinityConfig(db_functions $db,$system_package,$state,$apiConf){
    $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='$system_package' AND config_type='affi'");
    $ar = json_decode($getJson);
    if(!is_null($ar->$state->DPAffinityProfile)){
        return $ar->$state->DPAffinityProfile;
    }
    return $apiConf['Zone_affinity_profile'];
}

function overwriteControllerConfig(db_functions $db,$system_package,$state,&$apiConf){
    $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='$system_package' AND config_type='affi'");
    $ar = json_decode($getJson);
    //return $ar->$state;
    if(!empty($ar->$state->APControllerIP)){
        $apiConf['ap_controller_ip_address'] = $ar->$state->APControllerIP;
    }
    if(!empty($ar->$state->APControllerVersion)){
        $apiConf['ap_controller_version'] = $ar->$state->APControllerVersion;
    }
    if(!empty($ar->$state->APControllerUserName)){
        $apiConf['ap_controller_user_name'] = $ar->$state->APControllerUserName;
    }
    if(!empty($ar->$state->APControllerPassword)){
        $apiConf['ap_controller_password'] = $ar->$state->APControllerPassword;
    }
    if(!empty($ar->$state->SWControllerIP)){
        $apiConf['switch_controller_ip_address'] = $ar->$state->SWControllerIP;
    }
    if(!empty($ar->$state->SWControllerVersion)){
        $apiConf['switch_controller_version'] = $ar->$state->SWControllerVersion;
    }
    if(!empty($ar->$state->SWControllerUserName)){
        $apiConf['switch_controller_user_name'] = $ar->$state->SWControllerUserName;
    }
    if(!empty($ar->$state->SWControllerPassword)){
        $apiConf['switch_controller_password'] = $ar->$state->SWControllerPassword;
    }

    return $apiConf;
}

function setHotspot20SSIDConfig(db_functions $db,$configFileArr,$greID,$createHotspot20_arr,$hospotName){
    return $mdo_arr = array(
                        "name" => $configFileArr['Mdo_SSID_name'],
                        "ssid" => $configFileArr['Mdo_SSID'],
                        "description" => $configFileArr['Mdo_SSID_name'],
                        "hotspot20Profile" => ["id" => $createHotspot20_arr['Description']->id, "name" => $hospotName],
                        "encryption" => ["method" => "WPA2", "algorithm" => "AES", "mfp" => "disabled", "support80211rEnabled" => false, "mobilityDomainId" => 3],
                        "advancedOptions" => array(
                            "clientFingerprintingEnabled" => true,
                                "clientIsolationEnabled"=> true,
                                "uplinkEnabled"=>true,
                                "uplinkRate"=>20.0,
                                "downlinkEnabled"=>true,
                                "downlinkRate"=>150.0
                        ),
                        "radiusOptions" => array("nasIdType" => "Customized", "customizedNasId" => "RUCKUS_COM", "nasRequestTimeoutSec" => 3, "nasMaxRetry" => 2, "nasReconnectPrimaryMin" => 5, "calledStaIdType" => "WLAN_BSSID"),
                        "vlan" => array("accessVlan" => (int)$configFileArr['Mdo_vlan_id']),
                        "dpTunnelDhcpEnabled" => true,
                        "accessTunnelType"=> "RuckusGRE",
                        "accessTunnelProfile"=>["id"=>$greID,"name"=>"Default Tunnel Profile"]
                    );
}

function checkAccount(db_functions $db,$property_id,$parent_id){

    $q = "SELECT c.zone_id,z.name,c.mno_id,c.distributor_name,c.system_package AS dis_system_package,c.bussiness_type,c.sw_controller,m.system_package,m.api_prefix,c.state_region,c.zip,c.verification_number,u.user_name,c.ap_controller,c.sw_controller,c.distributor_code,c.verification_number,c.switch_group_id FROM exp_mno m JOIN admin_users u ON m.mno_id=u.user_distributor AND u.access_role='admin'
  LEFT JOIN exp_mno_distributor c ON m.mno_id=c.mno_id
  LEFT JOIN exp_distributor_zones z ON c.zone_id=z.zoneid
WHERE c.property_id='$property_id'  AND c.parent_id='$parent_id' ORDER BY m.id LIMIT 1";

    $data = $db->selectDB($q);

    if ($data['rowCount'] > 0) {
        return $data['data'][0];
    }else{
        $q_r12 = "SELECT * FROM mno_distributor_parent WHERE parent_id='$parent_id'";
        $dataq = $db->selectDB($q_r12);
        if ($dataq['rowCount'] < 1) {
            throw new APIException($parent_id, 1014);
        }
        throw new APIWithAccountException('', 1006, getAccountByParentId($parent_id, $db));
    }
}