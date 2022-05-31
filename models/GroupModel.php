<?php
require_once __DIR__ . '/Model.php';
require_once __DIR__.'/../src/AP/apClass.php';

class GroupModel extends Model {

    public function getGroupFreeAPs()
    {
        $apg_q="SELECT  ap.id,mac_address,ap_description FROM exp_locations_ap ap JOIN exp_distributor_ap_group apg ON ap.ap_group_id=apg.group_id 
WHERE  apg.name = 'default' AND mno='".$this->user()->user_distributor."'";
        return $this->db->selectDB($apg_q);
    }

    public function getSSIDs()
    {
        $ssid_q = "SELECT s.id,s.ssid FROM exp_locations_ssid s LEFT JOIN exp_distributor_wlan_group g ON s.wlan_group=g.w_group_id
                WHERE s.distributor = '".$this->user()->user_distributor."' AND (g.name='default' OR g.name IS NULL OR g.name='')";
        return $this->db->selectDB($ssid_q);

    }
    public function getSSIDFreeAPGroups()
    {
        $ssid_q = "SELECT a.name,a.id FROM exp_distributor_ap_wlan_group g JOIN exp_distributor_wlan_group w ON g.wlan_group_id = w.w_group_id AND w.name='default'
        JOIN exp_distributor_ap_group a ON g.ap_group_id=a.group_id AND a.name<>'default' WHERE g.distributor='".$this->user()->user_distributor."' GROUP BY a.group_id";
        return $this->db->selectDB($ssid_q);
    }

    /*Create AP Group*/
    public function creteAPGroup(array $aps,$name){
        $ruckus_vsz = $this->getRuckusVSZ();

        $controller_group_create = false;
        $controller_ap_assign = false;

        $query_ids = explode(',',$aps);
        $query_ids = implode('\',\'',$aps);

        $get_mac_q = "SELECT ap_code FROM exp_locations_ap WHERE id IN ('".$query_ids."')";
        $macs = [];
        $db_res = $this->db->selectDB($get_mac_q);
        if($db_res['rowCount']>0){
            foreach ($db_res['data'] as $row){
                array_push($macs,$row['ap_code']);
            }
        }
    //print_r($macs);
        $creat_ap_g_res = $ruckus_vsz->createAPGroup($ruckus_vsz->getZoneId(),$name);

        if($creat_ap_g_res['status']){
            $controller_group_create=true;
            if(count($aps)>0){
                $add_ap_res = $ruckus_vsz->addMemberToAPGroup($ruckus_vsz->getZoneId(),$creat_ap_g_res['data']['id'],$macs);

                if($add_ap_res['status']){
                    $controller_ap_assign=true;
                }

            }else{
                $controller_ap_assign=true;
            }
        }

        if($controller_ap_assign && $controller_ap_assign) {
            $unque_id = $creat_ap_g_res['data']['id'];

            $insert_q = "INSERT INTO exp_distributor_ap_group (group_id, distributor, name, create_user, create_date) VALUES ('" . $unque_id . "', '" . $this->user()->user_distributor . "', '" . $name . "', '" . $this->user()->user_name . "', NOW())";
            $this->db->execDB($insert_q);


            $q = "UPDATE exp_locations_ap SET ap_group_id='" . $unque_id . "' WHERE id IN('" . $query_ids . "')";
            $this->db->execDB($q);


            return ["status" => "success"];

        }else{
            return ["status" => "failed"];
        }
    }

    public function creteThemeGroup(array $args){

        $tag = $args['group_tag'];
        $ap_group_id = "'".implode("','", $args["ap_group_id"])."'";
        $ssid = "'".implode("','", $args["SSID"])."'";

        /*Create WLan Group*/
        $_VSZ = $this->getRuckusVSZ();

        $create_WL_Group = $_VSZ->creatWLanGroups($_VSZ->getZoneId(),$tag);

        if($create_WL_Group['status']) {

            $wGroupId = $create_WL_Group['data']['id'];
//exit();
            $get_network_ids_q = "SELECT network_id,id FROM exp_locations_ssid WHERE id IN(" . $ssid . ")";
            $get_network_ids = $this->db->selectDB($get_network_ids_q);
            if ($get_network_ids['rowCount'] > 0) {
                foreach ($get_network_ids['data'] as $row) {
                    $_VSZ->addMemberToWLanGroups($_VSZ->getZoneId(), $wGroupId, $row['network_id']);
                    $update_wlan_q = "UPDATE exp_locations_ssid SET wlan_group='$wGroupId' WHERE id='".$row['network_id']."'";
                    $this->db->execDB($update_wlan_q);
                }
            }

            //Create group tag
            $theme = '{"en":"' . $this->user()->user_distributor . '_default"}';
            $q1 = "INSERT INTO exp_mno_distributor_group_tag (tag_name, description, distributor, theme_name, create_date, create_user) 
              VALUES ('" . $tag . "', '" . $tag . "', '" . $this->user()->user_distributor . "', '" . $theme . "', NOW(), '" . $this->user()->user_name . "')";

            $insert = $this->db->execDB($q1);

            $tag_row_pk_q = "SELECT id AS f FROM exp_mno_distributor_group_tag WHERE distributor='" . $this->user()->user_distributor . "' AND tag_name='" . $tag . "'";
            $tag_row_pk = $this->db->getValueAsf($tag_row_pk_q);
            if(!empty($tag_row_pk)) {

                /*Assign wlan group to ap group*/
                $get_ap_group_ids_q = "SELECT group_id FROM exp_distributor_ap_group WHERE id IN(" . $ap_group_id . ")";
                $get_ap_group_ids = $this->db->selectDB($get_ap_group_ids_q);

                if ($get_ap_group_ids['rowCount'] > 0) {

                    foreach ($get_ap_group_ids['data'] as $row) {

                        $_VSZ->modifyWLanGroup24($_VSZ->getZoneId(), $row['group_id'], $wGroupId, $tag);
                        $_VSZ->modifyWLanGroup50($_VSZ->getZoneId(), $row['group_id'], $wGroupId, $tag);
                        $update_ap_wlan_group_q = "UPDATE exp_distributor_ap_wlan_groups SET wlan_group_id='".$wGroupId."' WHERE ap_group_id='".$row['group_id']."' AND distributor='" . $this->user()->user_distributor . "'";
                        $this->db->execDB($update_ap_wlan_group_q);
                    }
                }
                //Update ap_ssid group_tag

                $q2 = " UPDATE
       exp_locations_ap_ssid aps
    JOIN exp_locations_ap loap ON aps.ap_id=loap.ap_code
    JOIN exp_locations_ssid ls ON aps.distributor=ls.distributor AND
                                  aps.location_ssid=ls.ssid
 SET aps.group_tag='" . $tag . "'
WHERE loap.ap_group_id IN(" . $ap_group_id . ")   AND ls.id IN(" . $ssid . ")";

                $update = $this->db->execDB($q2);


                if (empty($update)) {
                    return ["status" => "success"];
                } else {
                    return ["status" => "failed"];
                }

            } else {
                $_VSZ->removeWLanGroups($this->user()->user_distributor,$wGroupId);
                foreach ($get_network_ids['data'] as $row) {
                    $update_wlan_q = "UPDATE exp_locations_ssid SET wlan_group='' WHERE id='".$row['network_id']."'";
                    $this->db->execDB($update_wlan_q);
                }
                return ["status" => "failed"];
            }
        }else{
            return ["status" => "failed"];
        }

    }

    public function syncAPGroups(){
        $vsz = $this->getRuckusVSZ();

        $data = $vsz->getAPGroups($vsz->getZoneId());

        if($data['status']){
            $sync_id = uniqid($this->user()->user_distributor);
            foreach ($data['data'] as $row){

                $q = "INSERT INTO exp_distributor_ap_group (group_id,distributor,name,create_user,create_date,sync_id) 
                      VALUES ('".$row['id']."','".$this->user()->user_distributor."','".$row['name']."','sync-".$this->user()->user_name."',NOW(),'$sync_id')
                      ON DUPLICATE KEY UPDATE  name='".$row['name']."',sync_id='".$sync_id."'";
                $this->db->execDB($q);
            }

            $get_removed = "SELECT id FROM exp_distributor_ap_group WHERE distributor='".$this->user()->user_distributor."' AND sync_id <>'".$sync_id."'";
            $q_res = $this->db->selectDB($get_removed);
            if($q_res['rowCount']>0){
                foreach ($q_res['data'] as $db_row){
                    $this->deleteAPGroup($db_row['id'],false);
                }
            }
        }
        $this->syncWLanGroups();
        $this->syncWLanAPGroup();

    }

    public function syncWLanAPGroup(){
        $vsz = $this->getRuckusVSZ();
        $sync_id = uniqid('ap-wlan-');

        $get_apGroup_q = "SELECT group_id FROM exp_distributor_ap_group WHERE distributor='".$this->user()->user_distributor."'";
        $get_apGroup = $this->db->selectDB($get_apGroup_q);
//print_r($get_apGroup);
        if($get_apGroup['rowCount']>0)
        {
            foreach ($get_apGroup['data'] as $row)
            {
                $ap_group_detail = $vsz->getAPGroup($vsz->getZoneId(),$row['group_id']);

                if($ap_group_detail['status']){
                    $details = $ap_group_detail['data'];

                    if(empty($details['wlanGroup50'])){
                        $ap_wlan_insert_q = "INSERT INTO exp_distributor_ap_wlan_group (distributor,wlan_group_id,ap_group_id,wlan_type,create_user,create_date,sync_id)
                                                SELECT '".$this->user()->user_distributor."',w_group_id,'".$row['group_id']."','wlanGroup50','".$this->user()->user_name."',NOW(),'".$sync_id."' 
                                                FROM exp_distributor_wlan_group WHERE distributor='".$this->user()->user_distributor."' AND name='default' ON DUPLICATE KEY UPDATE sync_id='".$sync_id."'";
                    }else{
                        $ap_wlan_insert_q = "INSERT INTO exp_distributor_ap_wlan_group(distributor,wlan_group_id,ap_group_id,wlan_type,create_user,create_date,sync_id)
                                             VALUES ('".$this->user()->user_distributor."','".$details['wlanGroup50']['id']."','".$row['group_id']."','wlanGroup50','".$this->user()->user_name."',NOW(),'".$sync_id."') ON DUPLICATE KEY UPDATE sync_id='".$sync_id."'";
                    }
                    $this->db->execDB($ap_wlan_insert_q);

                    if(empty($details['wlanGroup24'])){
                        $ap_wlan_insert_q = "INSERT INTO exp_distributor_ap_wlan_group (distributor,wlan_group_id,ap_group_id,wlan_type,create_user,create_date,sync_id)
                                                SELECT '".$this->user()->user_distributor."',w_group_id,'".$row['group_id']."','wlanGroup24','".$this->user()->user_name."',NOW(),'".$sync_id."' 
                                                FROM exp_distributor_wlan_group WHERE distributor='".$this->user()->user_distributor."' AND name='default' ON DUPLICATE KEY UPDATE sync_id='".$sync_id."'";
                    }else{
                        $ap_wlan_insert_q = "INSERT INTO exp_distributor_ap_wlan_group(distributor,wlan_group_id,ap_group_id,wlan_type,create_user,create_date,sync_id)
                                             VALUES ('".$this->user()->user_distributor."','".$details['wlanGroup50']['id']."','".$row['group_id']."','wlanGroup24','".$this->user()->user_name."',NOW(),'".$sync_id."') ON DUPLICATE KEY UPDATE sync_id='".$sync_id."'";
                    }
                    //echo $ap_wlan_insert_q;
                    $this->db->execDB($ap_wlan_insert_q);
                }
            }

            $delete_old_q = "DELETE FROM exp_distributor_ap_wlan_group WHERE distributor='".$this->user()->user_distributor."' AND sync_id<>'".$sync_id."'";
            $this->db->execDB($delete_old_q);
        }
    }


    public function getAPGroups(){

        $this->syncAPGroups();

        $q = "SELECT g.id,g.create_date,group_id,name,CONCAT('{',group_concat(concat('\"',a.ap_description,'\":\"',a.ap_code,'\"') SEPARATOR ','),'}') as macs FROM exp_distributor_ap_group g LEFT JOIN exp_locations_ap a ON a.ap_group_id=g.group_id
WHERE g.distributor='".$this->user()->user_distributor."' AND g.name<>'default' GROUP BY g.id ";
        return $this->db->selectDB($q);


    }

    public function syncWLanGroups(){
        $_VSZ = $this->getRuckusVSZ();
        $wLan_res = $_VSZ->getWLanGroups($_VSZ->getZoneId());

        $sync_id = uniqid('wLan-gr');
        if($wLan_res['status'] && $wLan_res['data']['totalCount']>0){
            foreach ($wLan_res['data']['list'] as $data){
                $ins_q = "INSERT INTO exp_distributor_wlan_group(w_group_id,name,description,distributor,create_user,create_date,sync_id)
                            VALUES('".$data['id']."','".$data['name']."','".$data['description']."','".$this->user()->user_distributor."','".$this->user()->user_name."',NOW(),'".$sync_id."')
                            ON DUPLICATE KEY UPDATE name='".$data['name']."',description='".$data['description']."',sync_id='".$sync_id."'";

                $this->db->execDB($ins_q);

                if(count($data['members'])>0){
                    foreach ($data['members'] as $data_m){
                        $update_q = "UPDATE exp_locations_ssid SET wlan_group='".$data['id']."' WHERE distributor='".$this->user()->user_distributor."' AND network_id='".$data_m['id']."'";
                        $this->db->execDB($update_q);
                    }
                }
            }

            $del_q = "DELETE FROM exp_distributor_wlan_group WHERE sync_id<>'".$sync_id."' AND distributor='".$this->user()->user_distributor."'";
            $this->db->execDB($del_q);
        }else if ($wLan_res['status']){
            $del_q = "DELETE FROM exp_distributor_wlan_group WHERE sync_id<>'".$sync_id."' AND distributor='".$this->user()->user_distributor."'";
            $this->db->execDB($del_q);
        }
    }

    public function getThemeGroups(){

        $q = "SELECT gt.id AS GTid,gt.tag_name,apssid.id,GROUP_CONCAT(DISTINCT apgr.name) as ap_group ,CONCAT('AP:',GROUP_CONCAT(DISTINCT ap.ap_code)) as aps,GROUP_CONCAT(DISTINCT apssid.location_ssid) as ssids
FROM exp_mno_distributor_group_tag gt LEFT JOIN exp_locations_ap_ssid apssid ON gt.tag_name = apssid.group_tag AND gt.distributor=apssid.distributor
  LEFT JOIN exp_locations_ap ap ON apssid.ap_id = ap.ap_code AND ap.mno=apssid.distributor
  LEFT JOIN exp_distributor_ap_group apgr ON ap.ap_group_id=apgr.id
WHERE gt.distributor='".$this->user()->user_distributor."' group by gt.tag_name";
        return $this->db->selectDB($q);
    }

    /*Get Single AP Group*/
    public function getAPGroup($id){
        $q = "SELECT g.id,g.create_date,group_id,name,CONCAT('{',group_concat(concat('\"',a.id,'\":\[\"',a.ap_description,'\",\"',a.ap_code,'\"]') SEPARATOR ','),'}') as macs FROM exp_distributor_ap_group g LEFT JOIN exp_locations_ap a ON a.ap_group_id=g.group_id
WHERE g.distributor='".$this->user()->user_distributor."' AND g.id='".$id."' GROUP BY g.id";
        return $this->db->select1DB($q);
    }

    /*Update AP Group*/
    public function updateAPGroup($id,array $ap_list,$ap_group){
        $update_q = "UPDATE exp_distributor_ap_group SET name='".$ap_group."' WHERE id='".$id."'";

        $exists_ap_q = "SELECT ap_code FROM exp_locations_ap ap JOIN exp_distributor_ap_group apg ON ap.ap_group_id=apg.group_id WHERE apg.id = '".$id."'";
        $new_ap_q = "SELECT ap_code FROM exp_locations_ap ap WHERE ap.id IN ('".implode('\',\'',$ap_list)."')";

        $exists_ap = $this->db->selectDB($exists_ap_q);
        $new_ap = $this->db->selectDB($new_ap_q);

        $exists_ap_ind_ar = [];
        foreach ($exists_ap['data'] AS $row){
            array_push($exists_ap_ind_ar,$row['ap_code']);
        }
        $new_ap_ind_ar = [];
        foreach ($new_ap['data'] AS $row){
            array_push($new_ap_ind_ar,$row['ap_code']);
        }
        /*VSZ Group Id*/
        $group_id = $this->db->getValueAsf("SELECT group_id AS f FROM exp_distributor_ap_group WHERE id='".$id."'");

        $_VSZ = $this->getRuckusVSZ();

        foreach ($exists_ap_ind_ar AS $key=>$mac ){
            if(in_array($mac,$new_ap_ind_ar))
                continue;

            $remove_res = $_VSZ->removeAPFromGroup($_VSZ->getZoneId(),$group_id,$mac);
            if(!$remove_res['status']){
                unset($exists_ap_ind_ar[$key]);
            }
        }

        $fresh_new_array = [];

        foreach ($new_ap_ind_ar AS $key=>$mac){
            if(!in_array($mac,$exists_ap_ind_ar)){
                array_push($fresh_new_array,$mac);
            }else{
                if (($key = array_search($mac, $exists_ap_ind_ar)) !== false) {
                    unset($exists_ap_ind_ar[$key]);
                }
            }

        }

        if(count($fresh_new_array)>0){
            $add_res = $_VSZ->addMemberToAPGroup($_VSZ->getZoneId(),$group_id,$fresh_new_array);
        }

        /*Move To Default*/
        $rest_q = "UPDATE exp_locations_ap ap JOIN
    (SELECT group_id,distributor FROM exp_distributor_ap_group WHERE name='default' AND distributor='".$this->user()->user_distributor."') t1  ON ap.mno=t1.distributor
SET ap.ap_group_id=t1.group_id WHERE ap.ap_code='".implode('\',\'',$exists_ap_ind_ar)."'";
        $this->db->execDB($rest_q);

        /*Add APs*/
        if($add_res['status']){
            foreach ($ap_list as $value) {
                $q = "UPDATE exp_locations_ap SET ap_group_id='".$group_id."' WHERE id='".$value."'";
                $this->db->execDB($q);
            }
        }

//print_r($exists_ap_ind_ar);
        $gr_update_res = $_VSZ->modifyAPGroup($_VSZ->getZoneId(),$group_id,$ap_group);
        if($gr_update_res['status']) {
            $this->db->execDB($update_q);
            return["status"=>"success"];
        }else{
            return["status"=>"failed"];
        }
    }

    /*Delete AP Group*/
    public function deleteAPGroup($id,$vsz=true){

        if($vsz){
            $_vsz = $this->getRuckusVSZ();

            $q = "SELECT group_id,GROUP_CONCAT(ap_code) as aps FROM exp_distributor_ap_group apg LEFT JOIN exp_locations_ap ap ON apg.group_id=ap.ap_group_id WHERE apg.id='".$id."'";
            $vsz_id = $this->db->select1DB($q);
            //print_r($vsz_id['aps']);
            $res = $_vsz->deleteAPGroup($_vsz->getZoneId(),$vsz_id['group_id'],explode(',',$vsz_id['aps']));

            if($res['status']){

                $ap_unassign_q = "UPDATE exp_locations_ap ap JOIN
                                (SELECT group_id,distributor FROM exp_distributor_ap_group WHERE name='default' AND distributor='".$this->user()->user_distributor."') t1  ON ap.mno=t1.distributor
                                SET ap.ap_group_id=t1.group_id WHERE ap.ap_group_id='".$vsz_id['group_id']."'";

                $this->db->execDB($ap_unassign_q);
                $api = true;
            }else{
                $api = false;
            }

        }else{
            $api = true;
        }


        /*Remove APs*/
        if($api) {
            $relese_q = "UPDATE exp_locations_ap SET ap_group_id=NULL WHERE ap_group_id='" . $id . "'";

            $relese = $this->db->execDB($relese_q);

            if (empty($relese)) {
                $q = "DELETE FROM exp_distributor_ap_group WHERE id='" . $id . "'";
                $del = $this->db->execDB($q);

                if (empty($del)) {
                    return ["status" => "success"];
                } else {
                    return ["status" => "failed"];
                }
            } else {
                return ["status" => "failed"];
            }
        }else{
            return ["status" => "failed"];
        }
    }

    public function getThemeGroup($id){
        $q = "SELECT gt.id AS gId,gt.tag_name,ap.ap_group_id,ss.id FROM exp_mno_distributor_group_tag gt JOIN exp_locations_ap_ssid apss ON gt.tag_name=apss.group_tag AND gt.distributor = apss.distributor LEFT JOIN exp_locations_ap ap ON apss.ap_id=ap.ap_code 
LEFT JOIN exp_locations_ssid ss ON apss.location_ssid=ss.ssid AND apss.distributor=ss.distributor
WHERE gt.id='$id' AND apss.distributor='".$this->user()->user_distributor."' GROUP BY ap.ap_code,ss.ssid";

        $data = $this->db->selectDB($q);

        $ap_groups = [];
        $ssids = [];
        if($data['rowCount']>0){
            $theme_group_id = "";
            $theme_group_name = "";
            foreach ($data['data'] as $value){
                array_push($ap_groups,$value['ap_group_id']);
                array_push($ssids,$value['id']);
                $theme_group_id=$id;
                $theme_group_name=$value['tag_name'];
            }

        }

        $ap_groups = array_unique($ap_groups);
        $ssids = array_unique($ssids);

        return ["status"=>"success","data"=>['id'=>$theme_group_id,'name'=>$theme_group_name,'ap_groups'=>$ap_groups,'ssids'=>$ssids]];

    }

    public function updateThemeGroup($id,array $args){

        $tag = $args['group_tag'];

        $q1 = "UPDATE exp_mno_distributor_group_tag SET tag_name='".$tag."', description='".$tag."' WHERE id='".$id."'";

        //Relese
        $q2 = "UPDATE exp_locations_ap_ssid apss JOIN exp_mno_distributor_group_tag gt ON apss.group_tag=gt.tag_name AND apss.distributor=gt.distributor
    JOIN exp_mno_distributor d ON gt.distributor=d.distributor_code
    SET apss.group_tag=d.verification_number WHERE gt.id='".$id."'";

        $relese = $this->db->execDB($q2);

        if(empty($relese))
            $update = $this->db->execDB($q1);

        if(empty($update)) {
            //Update ap_ssid group_tag
            $ap_group_id = "'".implode("','", $args["ap_group_id"])."'";
            $ssid = "'".implode("','", $args["SSID"])."'";
            $q2 = " UPDATE
       exp_locations_ap_ssid aps
    JOIN exp_locations_ap loap ON aps.ap_id=loap.ap_code
    JOIN exp_locations_ssid ls ON aps.distributor=ls.distributor AND
                                  aps.location_ssid=ls.ssid
 SET aps.group_tag='".$tag."'
WHERE loap.ap_group_id IN(".$ap_group_id.")   AND ls.id IN(".$ssid.")";

            $update = $this->db->execDB($q2);

            if(empty($update)){
                return ["status"=>"success"];
            }else{
                return["status"=>"failed"];
            }

        }else{
            return["status"=>"failed"];
        }
    }

    public function deleteGroupTag($id){

        //$_vsz = $this->getRuckusVSZ();

        //$_vsz->

        $del_q = "DELETE FROM exp_mno_distributor_group_tag WHERE id='$id'";

        $q2 = "UPDATE exp_locations_ap_ssid apss JOIN exp_mno_distributor_group_tag gt ON apss.group_tag=gt.tag_name AND apss.distributor=gt.distributor
    JOIN exp_mno_distributor d ON gt.distributor=d.distributor_code
    SET apss.group_tag=d.verification_number WHERE gt.id='".$id."'";

        if(empty($this->db->execDB($q2))){
            $del = $this->db->execDB($del_q);
            if(empty($del)){
                return["status"=>"success"];
            }else{
                return["status"=>"failed"];
            }
        }else{
            return["status"=>"failed"];
        }

    }
}