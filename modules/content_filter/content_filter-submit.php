<?php
if(isset($_GET['content_filter'])) {
    $content_filter=$_GET['content_filter'];
    if ($_GET['secret'] == $_SESSION['FORM_SECRET']) {
        if($content_filter=="1"){

            $wag_name=$db->getValueAsf("SELECT `wag_profile` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
            $gre_profile_id=$db->getValueAsf("SELECT `filt_gre_profile` AS f FROM `exp_wag_profile` WHERE `wag_code`='$wag_name'");
            $gre_profile_name=$db->getValueAsf("SELECT `profile_name` AS f FROM `exp_gre_profiles` WHERE `profile_id`='$gre_profile_id'");
            $modufy_tunnel=$wag_obj->modifyTunnelProfile($zone_id,$gre_profile_id,$gre_profile_name);
            parse_str($modufy_tunnel);

            if($status_code=='200'){

                $db->execDB("UPDATE `exp_mno_distributor`
                            SET `wag_profile_enable`='1'
                            WHERE `distributor_code`='$user_distributor'");

                $_SESSION['content_filter'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong> Content filter enabled </strong></div>";
            }else{
                $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong> [2009] Content filter enabling is failed. </strong></div>";

            }
        }elseif($content_filter=="0"){

            $wag_name=$db->getValueAsf("SELECT `wag_profile` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
            $gre_profile_id=$db->getValueAsf("SELECT `reg_gre_profile` AS f FROM `exp_wag_profile` WHERE `wag_code`='$wag_name'");
            $gre_profile_name=$db->getValueAsf("SELECT `profile_name` AS f FROM `exp_gre_profiles` WHERE `profile_id`='$gre_profile_id'");
            $modufy_tunnel=$wag_obj->modifyTunnelProfile($zone_id,$gre_profile_id,$gre_profile_name);
            parse_str($modufy_tunnel);

            if($status_code=='200'){

                $db->execDB("UPDATE `exp_mno_distributor`
                            SET `wag_profile_enable`='0'
                            WHERE `distributor_code`='$user_distributor'");

                $_SESSION['content_filter'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong> Content filter disabled </strong></div>";
            }else{
                $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong> [2009] Content filter disabling is failed </strong></div>";

            }

        }
    } else {
        $db->userErrorLog('2004', $user_name, 'script - ' . $script);

        $_SESSION['content_filter'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong> [2004] Oops, It seems you have refreshed the page. Please try again</strong></div>";

    }

}

if(isset($_GET['changeContentFilter'])){
    if($_GET['token']==$_SESSION['DNS_FORM_SECRET']){
        require_once __DIR__.'/../../src/AP/apClass.php';
        $ap_controller = new apClass();
        $wag_obj_cf = $ap_controller->getControllerInst();
        if($_GET['action']=='enable'){

            $DNS_profile = $db->getValueAsf("SELECT d.`dns_profile` AS f FROM `exp_mno_distributor` d WHERE d.distributor_code='$user_distributor'");

            $zone_id = $db->getValueAsf("SELECT d.`zone_id` AS f FROM `exp_mno_distributor` d WHERE d.distributor_code='$user_distributor'");

            $get_dns_prof_deta_q = "SELECT cd.`content_filter_profile`,d.name,cd.regular_profile FROM `exp_controller_dns` cd join exp_dns_profile d ON cd.content_filter_profile=d.unique_id WHERE `profile_code`='$DNS_profile'";

            $get_dns_prof_deta = $db->select1DB($get_dns_prof_deta_q);
            //$get_dns_prof_deta = mysql_fetch_array($get_dns_prof_deta_r);
            $dns_profile_id = $get_dns_prof_deta['content_filter_profile'];
            $regular_profile = $get_dns_prof_deta['regular_profile'];
            $dns_profile_name = $get_dns_prof_deta['name'];

            $result=$wag_obj_cf->retrieveDNSServerProfile();

            parse_str($result);

            $result=urldecode($Description);

            $result=(array)json_decode($result);

            $result=(Array)$result['list'];

            if(count($result)>0) {
                foreach ($result as $key => $value) {
                    $value = (array)$value;
                    $id = $value['id'];

                    if($id==$dns_profile_id){

                        $secondaryIp = $value['secondaryIp'];
                        $primaryIp = $value['primaryIp'];
                    }

                }

                $result_dhcp=$wag_obj_cf->getZoneDHCPProfile($zone_id);

                parse_str($result_dhcp,$wag_respo_arr);

                $data = json_decode($wag_respo_arr['Description'],true);

                if(count($data['list'])>0) {

                    $dhcp_is = 0;

                    foreach ($data['list'] as $value){

                        $vlanId = $value['vlanId'];

                        if($vlanId=='100'){
                            $dhcp_id = $value['id'];
                            $dhcp_arr = $value;
                            $dhcp_is = 1;
                            break;
                        }

                    }

                    if($dhcp_is == 1){

                        $dhcp_arr['primaryDnsIp'] = $primaryIp;
                        $dhcp_arr['secondaryDnsIp'] = $secondaryIp;

                        unset($dhcp_arr['zoneId']);
                        unset($dhcp_arr['id']);

                        $result_dhcp1=$wag_obj_cf->modifyDhcpProfile($zone_id,$dhcp_id,$dhcp_arr);

                        parse_str($result_dhcp1,$wag_respo_arr2);

                        if ($wag_respo_arr2['status_code'] == '200') {
                            $db->execDB("UPDATE exp_mno_distributor SET dns_profile_enable='1' WHERE distributor_code='$user_distributor'");
                            $_SESSION['content_filter'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_success','2009')."</strong></div>";

                        }else{
                            $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_fail','2009')."</strong></div>";

                        }

                    }else{

                        $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_fail','2009')."</strong></div>";
                    }

                }else{

                    $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_fail','2009')."</strong></div>";
                }


            }else{

                $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_fail','2009')."</strong></div>";
            }


        }elseif($_GET['action']=='disable'){

            $DNS_profile = $db->getValueAsf("SELECT d.`dns_profile` AS f FROM `exp_mno_distributor` d WHERE d.distributor_code='$user_distributor'");

            $zone_id = $db->getValueAsf("SELECT d.`zone_id` AS f FROM `exp_mno_distributor` d WHERE d.distributor_code='$user_distributor'");

            $get_dns_prof_deta_q = "SELECT cd.`content_filter_profile`,d.name,cd.regular_profile FROM `exp_controller_dns` cd join exp_dns_profile d ON cd.content_filter_profile=d.unique_id WHERE `profile_code`='$DNS_profile'";

            $get_dns_prof_deta = $db->select1DB($get_dns_prof_deta_q);
            //$get_dns_prof_deta = mysql_fetch_array($get_dns_prof_deta_r);
            $dns_profile_id = $get_dns_prof_deta['content_filter_profile'];
            $regular_profile = $get_dns_prof_deta['regular_profile'];
            $dns_profile_name = $get_dns_prof_deta['name'];

            $result=$wag_obj_cf->retrieveDNSServerProfile();

            parse_str($result);

            $result=urldecode($Description);
            $result=(array)json_decode($result);
            $result=(Array)$result['list'];

            if(count($result)>0) {
                foreach ($result as $key => $value) {
                    $value = (array)$value;
                    $id = $value['id'];

                    if($id==$regular_profile){

                        $secondaryIp = $value['secondaryIp'];
                        $primaryIp = $value['primaryIp'];
                    }

                }

                $result_dhcp=$wag_obj_cf->getZoneDHCPProfile($zone_id);
                parse_str($result_dhcp,$wag_respo_arr);
                $data = json_decode($wag_respo_arr['Description'],true);

                if(count($data['list'])>0) {

                    $dhcp_is = 0;

                    foreach ($data['list'] as $value){

                        $vlanId = $value['vlanId'];

                        if($vlanId=='100'){
                            $dhcp_id = $value['id'];
                            $dhcp_arr = $value;
                            $dhcp_is = 1;
                            break;
                        }

                    }

                    if($dhcp_is == 1){

                        $dhcp_arr['primaryDnsIp'] = $primaryIp;
                        $dhcp_arr['secondaryDnsIp'] = $secondaryIp;

                        unset($dhcp_arr['zoneId']);
                        unset($dhcp_arr['id']);

                        $result_dhcp1=$wag_obj_cf->modifyDhcpProfile($zone_id,$dhcp_id,$dhcp_arr);
                        parse_str($result_dhcp1,$wag_respo_arr2);

                        if ($wag_respo_arr2['status_code'] == '200') {
                            $update_q = "UPDATE exp_mno_distributor SET dns_profile_enable='0' WHERE distributor_code='$user_distributor'";
                            $db->execDB($update_q);
                            $_SESSION['content_filter'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_success','2009')."</strong></div>";

                        }else{
                            $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_fail','2009')."</strong></div>";

                        }

                    }else{

                        $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_fail','2009')."</strong></div>";
                    }

                }else{

                    $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_fail','2009')."</strong></div>";
                }


            }else{

                $_SESSION['content_filter'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_fail','2009')."</strong></div>";
            }

        }

    }else{
        $_SESSION['content_filter']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
    }
}

