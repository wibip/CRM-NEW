<?php

require_once __DIR__.'/dbClass.php';
class adminConfig{
    private $db;
	public function  __construct(){
		$this->db = new db_functions();
	}
    public function saveRegions($post,$user_name,$user_group,$page){
        $result = false;
        if($post != null) {
            $sql = "INSERT INTO crm_opr_region(`operator_code`,
                                                `development_type`,
                                                `region_state`,
                                                `region`,
                                                `state_name`,
                                                `city`,
                                                `notes`,
                                                `status`,
                                                `create_user`,
                                                `create_date`)
                                        VALUES('".$post["operator_code"]."',
                                               '".$post["development_type"]."',
                                               '".$post["region_state"]."',
                                               '".$post["region"]."',
                                               '".$post["state_name"]."',
                                               '".$post["city"]."',
                                               '".$post["notes"]."',
                                               1,
                                               '".$user_name."',
                                               NOW()) ";
            $result = $this->db->execDB($sql);
            // var_dump($result);
            if ($result === true) {
                $idContAutoInc = $this->db->getValueAsf("SELECT LAST_INSERT_ID() as f");
                $this->db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Add property Region',$idContAutoInc,'3001',"Region has been successfully created");              
            } else {
                $this->db->addLogs($user_name, 'ERROR',$user_group, $page, 'Add property Region',0,'2002',"Error on creating Region. ".$result);               
            }

            return $result;
        }
    }

    public function getRegions($columns = "*", $where=null){
        $sql = "SELECT ".$columns." FROM crm_opr_region";
        if($where != null) {
            $sql .= " WHERE  ".$where;
        }
        $sql .= " ORDER BY id DESC";
        $reult = $this->db->selectDB($sql);
        return $reult;
    }

    public function saveRealm($post,$user_name,$user_group,$page){
        $result = false;
        if($post != null) {
            $sql = "INSERT INTO crm_opr_realm(`operator_code`,
                                                `sub_operator_code`,
                                                `range_from`,
                                                `range_to`,
                                                `service_type`,
                                                `region`,
                                                `prefix`,
                                                `notes`,
                                                `status`,
                                                `create_user`,
                                                `create_date`)
                                        VALUES('".$post["operator_code"]."',
                                               '".$post["sub_operator_code"]."',
                                               '".$post["range_from"]."',
                                               '".$post["range_to"]."',
                                               '".$post["service_type"]."',
                                               '".$post["region"]."',
                                               '".$post["prefix"]."',
                                               '".$post["notes"]."',
                                               1,
                                               '".$user_name."',
                                               NOW()) ";
            $result = $this->db->execDB($sql);
            // var_dump($result);
            if ($result === true) {
                $idContAutoInc = $this->db->getValueAsf("SELECT LAST_INSERT_ID() as f");
                $this->db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Add property Realm',$idContAutoInc,'3001',"Realm has been successfully created");              
            } else {
                $this->db->addLogs($user_name, 'ERROR',$user_group, $page, 'Add property Realm',0,'2002',"Error on creating Realm. ".$result);               
            }

            return $result;
        }
    }

    public function getRealms($columns = "*", $where=null){
        $sql = "SELECT ".$columns." FROM crm_opr_realm";
        if($where != null) {
            $sql .= " WHERE  ".$where;
        }
        $sql .= " ORDER BY id DESC";
        $reult = $this->db->selectDB($sql);
        return $reult;
    }

    public function saveIpScope($post){
        $result = false;
        
        if($post != null) {
            $operator_code = isset($post["operator_code"]) ? $post["operator_code"] : "";
            $sub_operator_code = isset($post["sub_operator_code"]) ? $post["sub_operator_code"] : "";
            $region = isset($post["region"]) ? $post["region"] : "";
            $range_from = isset($post["range_from"]) ? $post["range_from"] : "";
            $range_to = isset($post["range_to"]) ? $post["range_to"] : "";
            $ip_network = isset($post["ip_network"]) ? $post["ip_network"] : "";
            $netmask = isset($post["netmask"]) ? $post["netmask"] : "";
            $property_name = isset($post["property_name"]) ? $post["property_name"] : "";
            $peer_id = isset($post["peer_id"]) ? $post["peer_id"] : "";
            $firewall_public_net = isset($post["firewall_public_net"]) ? $post["firewall_public_net"] : "";
            $firewall_public_ip = isset($post["firewall_public_ip"]) ? $post["firewall_public_ip"] : "";
            $firewall_vlan50_ip = isset($post["firewall_vlan50_ip"]) ? $post["firewall_vlan50_ip"] : "";
            $firewall_serial_no = isset($post["firewall_serial_no"]) ? $post["firewall_serial_no"] : "";
            $vlan_static_ip = isset($post["vlan_static_ip"]) ? $post["vlan_static_ip"] : "";
            $underlay_net = isset($post["underlay_net"]) ? $post["underlay_net"] : "";
            $vlan_dhcp_ap_ip = isset($post["vlan_dhcp_ap_ip"]) ? $post["vlan_dhcp_ap_ip"] : "";
            $scope_type = isset($post["scope_type"]) ? $post["scope_type"] : "";
            $user_name = isset($post["user_name"]) ? $post["user_name"] : "";
            $user_group = isset($post["user_group"]) ? $post["user_group"] : "";
            $page = isset($post["page"]) ? $post["page"] : "";

            $sql = "INSERT INTO crm_opr_ip_scope(`operator_code`,
                                                `sub_operator_code`,
                                                `region`,
                                                `range_from`,
                                                `range_to`,
                                                `ip_network`,
                                                `netmask`,
                                                `property_name`,
                                                `peer_id`,
                                                `firewall_public_net`,  
                                                `firewall_public_ip`,  
                                                `firewall_vlan50_ip`,  
                                                `firewall_serial_no`,  
                                                `vlan_static_ip`, 
                                                `underlay_net`,  
                                                `vlan_dhcp_ap_ip`,
                                                `status`,
                                                `type`,
                                                `create_user`,
                                                `create_date`)
                                        VALUES('".$operator_code."',
                                               '".$sub_operator_code."',
                                               '".$region."',
                                               '".$range_from."',
                                               '".$range_to."',
                                               '".$ip_network."',
                                               '".$netmask."',
                                               '".$property_name."',
                                               '".$peer_id."',
                                               '".$firewall_public_net."',
                                               '".$firewall_public_ip."',
                                               '".$firewall_vlan50_ip."',
                                               '".$firewall_serial_no."',
                                               '".$vlan_static_ip."',
                                               '".$underlay_net."',
                                               '".$vlan_dhcp_ap_ip."',
                                               1,
                                               '".$scope_type."',
                                               '".$user_name."',
                                               NOW()) ";
            // echo $sql;
            $result = $this->db->execDB($sql);
            // var_dump($result);
            if ($result === true) {
                $idContAutoInc = $this->db->getValueAsf("SELECT LAST_INSERT_ID() as f");
                $this->db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Add property IP Scope',$idContAutoInc,'3001',"IP Scope has been successfully created");              
            } else {
                $this->db->addLogs($user_name, 'ERROR',$user_group, $page, 'Add property IP Scope',0,'2002',"Error on creating IP Scope. ".$result);               
            }

            return $result;
        }
    }
}