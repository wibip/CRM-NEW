<?php

include_once(__DIR__ . '/../bo/Vertical.php');
include_once(__DIR__ . '/../bo/Vtenant.php');
include_once(__DIR__ . '/../bo/Qos.php');
include_once(__DIR__ . '/../bo/Vlan.php');
include_once(__DIR__ . '/../classes/dbClass.php');

//include_once ('bo/Vertical.php');
//include_once ('bo/Vtenant.php');
//include_once ('bo/Qos.php');
//include_once ('bo/Vlan.php');

class vtenantModel
{
    private $db;

    function __construct()
    {
        $this->db = new db_functions();
    }

    public function getAllVtenants()
    {
        $vts = array();

        $sql = "SELECT o.*, v.`vlan_range` FROM `mdu_organizations` o LEFT JOIN `mdu_vlan` v ON v.`vlan_id`=o.`property_id`";
        $data = $this->db->selectDB($sql);

        if ($data['rowCount'] > 0) {
            foreach ($data['data'] as $row) {
                $vt = new Vtenant();

                $vt->setId($row['id']);
                $vt->setRealm($row['property_id']);
                $vt->setDescription($row['org_desc']);
                $vt->setName($row['org_name']);
                $vt->setType($row['property_type']);
                $vt->setValidityTime($row['validity_time']);
                $vt->setVLANIDRanges($row['vlan_range']);
                $vt->setVertical($this->getVertical($row['group_verticle'])->getName());
                $vt->setDelete_Status($row['delete_status']);

                array_push($vts, $vt);
            }
        }

        return $vts;
    }

    public function getUnusedAdminVtenants()
    {
        $vts = array();

        $sql = "SELECT o.property_id,o.id,o.property_type,o.org_desc,o.org_name, v.`mno` 
                FROM `mdu_organizations` o LEFT JOIN `mdu_mno_organizations` v ON v.`property_id`=o.`property_id` 
                WHERE v.mno IS null";

        $data = $this->db->selectDB($sql);

        if ($data['rowCount'] > 0) {
            foreach ($data['data'] as $row) {
                $vt = new Vtenant();

                $vt->setId($row['id']);
                $vt->setRealm($row['property_id']);
                $vt->setDescription($row['org_desc']);
                $vt->setName($row['org_name']);
                $vt->setType($row['property_type']);

                array_push($vts, $vt);
            }
        }

        return $vts;
    }

    public function getUnusedMNOVtenants($mno)
    {
        $vts = array();

        $sql = "SELECT t1.property_id,t1.id,t1.property_type,t1.org_desc,t1.org_name, t1.`mno` FROM
(SELECT o.property_id,o.id,o.property_type,o.org_desc,o.org_name, v.`mno`
FROM `mdu_mno_organizations` v JOIN `mdu_organizations` o  ON v.`property_id`=o.`property_id` AND mno='$mno') t1
  LEFT JOIN mdu_distributor_organizations do ON t1.property_id=do.property_id
 WHERE do.distributor_code IS null";

        $data = $this->db->selectDB($sql);

        if ($data['rowCount'] > 0) {
            foreach ($data['data'] as $row) {
                $vt = new Vtenant();

                $vt->setId($row['id']);
                $vt->setRealm($row['property_id']);
                $vt->setDescription($row['org_desc']);
                $vt->setName($row['org_name']);
                $vt->setType($row['property_type']);

                array_push($vts, $vt);
            }
        }

        return $vts;
    }

    public function getMNOVtenants($mno)
    {
        $vts = array();

        $sql = "SELECT o.property_id,o.id,o.property_type,o.org_desc,o.org_name, v.`mno` 
                FROM `mdu_organizations` o LEFT JOIN `mdu_mno_organizations` v ON v.`property_id`=o.`property_id` 
                WHERE v.mno ='$mno'";

        $data = $this->db->selectDB($sql);

        if ($data['rowCount'] > 0) {
            foreach ($data['data'] as $row) {
                $vt = new Vtenant();

                $vt->setId($row['id']);
                $vt->setRealm($row['property_id']);
                $vt->setDescription($row['org_desc']);
                $vt->setName($row['org_name']);
                $vt->setType($row['property_type']);

                array_push($vts, $vt);
            }
        }

        return $vts;
    }

    public function createVtenant(Vtenant $vt)
    {
        $str = "INSERT INTO `mdu_organizations` (`purge_days`,`master_purge_time`,`purge_type`,`device_limit`,`country`,`address1`,`address2`,`city`,`state`,`longitude`,`latitude`,`phone1`,`phone2`,`property_id`,`property_number`,`validity_time`,`org_name`,`org_desc`,`group_verticle`,`create_date`,`last_update`,`append_realm`,`property_type`,`ignore_on_search`,`default_prof`,`premium_profile`,`probation_prof`,`tenant_portal_link`,`redirection_url`,`footer_text`,`signup_status`)
		VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW(),NOW(),'%s','%s','%s',
		'%s','%s','%s','%s','%s','%s','%s')";

        $sql = sprintf(
            $str,
            $vt->getSubAccPurgeTime(),
            $vt->getMasterAccPurgeTime(),
            $vt->getPurgeType(),
            $vt->getDeviceLimit(),
            $vt->getCountry(),
            $vt->getAddress1(),
            $vt->getAddress2(),
            $vt->getCity(),
            $vt->getState(),
            $vt->getLongitude(),
            $vt->getLatitude(),
            $vt->getMobileNumber1(),
            $vt->getMobileNumber2(),
            $vt->getRealm(),
            $vt->getRealm(),
            $vt->getValidityTime(),
            $vt->getName(),
            $vt->getDescription(),
            $vt->getVertical(),
            $vt->getAppendRealm(),
            $vt->getType(),
            $vt->getIgnoreValidityOnSearch(),
            $vt->getDefaultDeviceProfile(),
            $vt->getPremiumDeviceProfile(),
            $vt->getProbationDeviceProfile(),
            $vt->getCompactLink(),
            $vt->getRedirectionURL(),
            $vt->getPortalFooterText(),
            $vt->getSignup_Status()
        );


        $new_vlan = new Vlan();

        $new_vlan->setName($vt->getName());
        $new_vlan->setVlanId($vt->getRealm());
        $new_vlan->setDescription($vt->getRealm());
        $new_vlan->setOnboardingVlanId($vt->getOnboardingVLANID());
        $new_vlan->setVlanRange($vt->getVLANIDRanges());
        $new_vlan->setVlanNotification($vt->getVLANNotificationLimit());

        $create_vlan = $this->createVlan($new_vlan);

        if ($create_vlan === true) {
            $res = $this->db->execDB($sql);
            return $res;
        } else {
            return $create_vlan;
        }
    }

    public function createVertical(Vertical $ob)
    {

        $vertical_uid = uniqid('VERTICAL');

        $sql = sprintf("INSERT INTO mdu_vertical_group(`unique_id`,`name`,`description`,`create_user`,create_date) VALUES ('%s','%s','%s','%s',NOW())", $vertical_uid, $ob->getName(), $ob->getDescription(), $ob->getCreateUser());

        return $this->db->execDB($sql);
    }

    public function getAllVerticals()
    {

        $return_ar = array();
        $sql = "SELECT v.unique_id,v.name,v.description,v.create_user,v.create_date,o.id AS check_remove FROM `mdu_vertical_group` v LEFT JOIN `mdu_organizations` o ON o.group_verticle=v.`unique_id` GROUP BY v.`unique_id`";
        $data = $this->db->selectDB($sql)['data'];

        foreach ($data as $value) {
            $vertical_ob = new Vertical();

            $vertical_ob->setUniqueId($value['unique_id']);
            $vertical_ob->setName($value['name']);
            $vertical_ob->setDescription($value['description']);
            $vertical_ob->setCreateUser($value['create_user']);
            $vertical_ob->setCreateDate($value['create_date']);

            if (is_null($value['check_remove'])) {
                $vertical_ob->setHaveOrganizations('NO');
            } else {
                $vertical_ob->setHaveOrganizations('YES');
            }

            array_push($return_ar, $vertical_ob);
        }


        return $return_ar;
    }

    public function getVertical($uid)
    {
        $sql = "SELECT `unique_id`,`name`,`description`,`create_user`,`create_date` FROM mdu_vertical_group WHERE unique_id='$uid'";

        $data_array = $this->db->select1DB($sql);

        $vertical_ob = new Vertical();
        $vertical_ob->setUniqueId($data_array['unique_id']);
        $vertical_ob->setName($data_array['name']);
        $vertical_ob->setDescription($data_array['description']);
        $vertical_ob->setCreateUser($data_array['create_user']);
        $vertical_ob->setCreateDate($data_array['create_date']);

        return $vertical_ob;
    }

    public function updateVertical(Vertical $edit_vertical)
    {
        $sql_str = "UPDATE mdu_vertical_group SET description='%s' WHERE unique_id='%s'";

        $query = sprintf($sql_str, $edit_vertical->getDescription(), $edit_vertical->getUniqueId());

        return $this->db->execDB($query);
    }


    public function createQOS(Qos $qos)
    {
        $qos_uid = uniqid('QOS');

        $sql = sprintf("INSERT INTO exp_products (`product_id`,`product_name`,`product_code`,`QOS`,QOS_up_link,network_type,create_user,create_date,mno_id) 
                                VALUES ('%s','%s','%s','%s','%s','%s','%s',NOW(),'%s')", $qos_uid, $qos->getProductName(), $qos->getProductCode(), $qos->getProductQos(), $qos->getProductQosUplink(), $qos->getProductType(), $qos->getCreateUser(), $qos->getMnoId());

        return $this->db->execDB($sql);
    }

    public function getAllDistributorQos($user_distributor)
    {
        $return_ar = array();
        $str = "SELECT `product_id`,`product_name`,`product_code`,`QOS`,QOS_up_link,network_type,create_user,create_date,mno_id  FROM `exp_products` v WHERE mno_id='%s'";
        $sql = sprintf($str, $user_distributor);
        $data = $this->db->selectDB($sql)['data'];

        foreach ($data as $value) {
            $qos_ob = new Qos();

            $qos_ob->setProductId($value['product_id']);

            $str2 = "SELECT id,property_id FROM mdu_organizations WHERE default_prof='%s'";
            $sql2 = sprintf($str2, $value['product_id']);
            $check_assigned = $this->db->selectDB($sql2);


            if ($check_assigned['rowCount'] > 0) {
                $qos_ob->setAssignedToVtenant('YES');

                foreach ($check_assigned['data'] as $vts) {

                    $vt = new Vtenant();
                    $vt->setRealm($vts['property_id']);

                    $qos_ob->setAssignedVtenants($vt);
                }
            } else {
                $qos_ob->setAssignedToVtenant('NO');
            }

            $qos_ob->setProductName($value['product_name']);
            $qos_ob->setProductCode($value['product_code']);
            $qos_ob->setProductQos($value['QOS']);
            $qos_ob->setProductQosUplink($value['QOS_up_link']);
            $qos_ob->setProductType($value['network_type']);
            $qos_ob->setMnoId($value['mno_id']);
            $qos_ob->setCreateUser($value['create_user']);
            $qos_ob->setCreatedDate($value['create_date']);

            array_push($return_ar, $qos_ob);
        }


        return $return_ar;
    }

    public function getQos($id)
    {
        $str = "SELECT `product_id`,`product_name`,`product_code`,`QOS`,QOS_up_link,network_type,create_user,create_date,mno_id  FROM `exp_products` v WHERE `product_id` ='%s'";
        $sql = sprintf($str, $id);

        $qos_from_db = $this->db->select1DB($sql);

        $qos = new Qos();

        $qos->setProductId($qos_from_db['product_id']);
        $qos->setProductName($qos_from_db['product_name']);
        $qos->setProductCode($qos_from_db['product_code']);
        $qos->setProductQos($qos_from_db['QOS']);
        $qos->setProductQosUplink($qos_from_db['QOS_up_link']);
        $qos->setProductType($qos_from_db['network_type']);
        $qos->setCreateUser($qos_from_db['create_user']);
        $qos->setCreatedDate($qos_from_db['create_date']);
        $qos->setMnoId($qos_from_db['mno_id']);

        return $qos;
    }

    public function updateQos(Qos $qos)
    {
        $str = "UPDATE exp_products SET product_name='%s',product_code='%s',QOS='%s',QOS_up_link='%s' WHERE product_id='%s'";
        $sql = sprintf($str, $qos->getProductName(), $qos->getProductCode(), $qos->getProductQos(), $qos->getProductQosUplink(), $qos->getProductId());

        return $this->db->execDB($sql);
    }

    public function deleteQos($delete_qos_id)
    {
        $str = "DELETE FROM exp_products WHERE product_id='%s'";
        $sql = sprintf($str, $delete_qos_id);

        return $this->db->execDB($sql);
    }

    private function createVlan(Vlan $new_vlan)
    {
        $vlane_pool =  $this->vlan_deploy($new_vlan->getVlanRange());
        $str = "INSERT INTO `mdu_vlan` (`vlan_id`,`name`,`description`,`onboarding_vlan_id`,`vlan_range`,`vlan_range_temp`,`vlan_pool`,`vlan_notification`,`create_user`,`create_date`,`last_update`)
		VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW(),NOW())";

        $sql = sprintf(
            $str,
            $new_vlan->getVlanId(),
            $new_vlan->getName(),
            $new_vlan->getDescription(),
            $new_vlan->getOnboardingVlanId(),
            $new_vlan->getVlanRange(),
            $new_vlan->getVlanRange(),
            $vlane_pool,
            $new_vlan->getVlanNotification(),
            $new_vlan->getCreateUser()
        );

        return $this->db->execDB($sql);
    }

    //////////////////////////vlan range generate json////////////////////////////

    public function vlan_deploy($range)
    {


        $range_ex = explode(',', $range);
        $vlane_pool = "";
        $a = array();
        foreach ($range_ex as $range_u) {

            $vlane_pool =  $this->vlan_get_json($range_u);

            array_push($a, $vlane_pool);
        }

        return json_encode($a);
    }

    public function vlan_range_sync($range)
    {


        $range_ex = explode(',', $range);
        $vlane_pool = "";
        $a = array();
        foreach ($range_ex as $range_u) {

            $range_ex = explode('-', $range_u);
            $fst_range = (int)$range_ex[0];
            $lst_range = (int)$range_ex[1];

            for ($i = $fst_range; $i <= $lst_range; $i++) {
                array_push($a, $i);
            }
        }

        return json_encode($a);
    }

    public function vlan_get_json($range)
    {

        $range_ex = explode('-', $range);
        $fst_range = (int)$range_ex[0];
        $lst_range = (int)$range_ex[1];

        $v = array();

        for ($i = $fst_range; $i <= $lst_range; $i++) {
            //$v[] = $i;
            $v[$range][] = (int)$i;
        }

        return $v;
    }


    //////////////////////////end vlan range generate json////////////////////////////	

    public function getVtenant($mrelm_id)
    {

        $vt = new Vtenant();

        $str = "SELECT
                  o.property_id,
                  o.property_number,
                  o.property_type,
                  o.validity_time,
                  o.org_name,
                  o.org_desc,
                  o.group_verticle,
                  o.device_limit,
                  o.append_realm,
                  o.address1,
                  o.address2,
                  o.country,
                  o.city,
                  o.state,
                  o.longitude,
                  o.latitude,
                  o.phone1,
                  o.phone2,
                  o.purge_days,
                  o.master_purge_time,
                  o.purge_type,
                  o.default_prof,
                  o.premium_profile,
                  o.probation_prof,
                  o.ignore_on_search,
                  o.tenant_portal_link,
                  o.redirection_url,
                  o.footer_text,
                  o.signup_status
                FROM mdu_organizations o WHERE o.property_id = '%s'";

        $sql = sprintf($str, $mrelm_id);

        $vtenant = $this->db->select1DB($sql);

        $vt->setSubAccPurgeTime($vtenant['purge_days']);
        $vt->setMasterAccPurgeTime($vtenant['master_purge_time']);
        $vt->setPurgeType($vtenant['purge_type']);
        $vt->setDeviceLimit($vtenant['device_limit']);
        $vt->setCountry($vtenant['country']);
        $vt->setAddress1($vtenant['address1']);
        $vt->setAddress2($vtenant['address2']);
        $vt->setCity($vtenant['city']);
        $vt->setState($vtenant['state']);
        $vt->setLongitude($vtenant['longitude']);
        $vt->setLatitude($vtenant['latitude']);
        $vt->setMobileNumber1($vtenant['phone1']);
        $vt->setMobileNumber2($vtenant['phone2']);
        $vt->setRealm($vtenant['property_number']);
        $vt->setValidityTime($vtenant['validity_time']);
        $vt->setName($vtenant['org_name']);
        $vt->setDescription($vtenant['org_desc']);
        $vt->setVertical($vtenant['group_verticle']);
        $vt->setAppendRealm($vtenant['append_realm']);
        $vt->setType($vtenant['property_type']);
        $vt->setIgnoreValidityOnSearch($vtenant['ignore_on_search']);
        $vt->setDefaultDeviceProfile($vtenant['default_prof']);
        $vt->setPremiumDeviceProfile($vtenant['premium_profile']);
        $vt->setProbationDeviceProfile($vtenant['probation_prof']);
        $vt->setCompactLink($vtenant['tenant_portal_link']);
        $vt->setRedirectionURL($vtenant['redirection_url']);
        $vt->setPortalFooterText($vtenant['footer_text']);
        $vt->setSignup_Status($vtenant['signup_status']);

        $vlan_data = $this->getVlan($mrelm_id);


        $vt->setOnboardingVLANID($vlan_data->getOnboardingVlanId());
        $vt->setVLANIDRanges($vlan_data->getVlanRange());
        $vt->setVLANNotificationLimit($vlan_data->getVlanNotification());
        $vt->setVLANIDRangesTemp($vlan_data->getVlanRangeTemp());


        return $vt;
    }


    public function getDistributorVtenant($distributor_code)
    {

        $vt = new Vtenant();

        $str = "SELECT
  o.property_id,
  o.property_number,
  o.property_type,
  o.validity_time,
  o.org_name,
  o.org_desc,
  o.group_verticle,
  o.device_limit,
  o.append_realm,
  o.address1,
  o.address2,
  o.country,
  o.city,
  o.state,
  o.longitude,
  o.latitude,
  o.phone1,
  o.phone2,
  o.purge_days,
  o.master_purge_time,
  o.purge_type,
  o.default_prof,
  o.premium_profile,
  o.probation_prof,
  o.ignore_on_search,
  o.tenant_portal_link,
  o.redirection_url,
  o.footer_text
FROM mdu_organizations o JOIN mdu_distributor_organizations do ON o.property_id=do.property_id WHERE do.distributor_code = '%s'";

        $sql = sprintf($str, $distributor_code);

        $vtenant = $this->db->select1DB($sql);

        if (is_array($vtenant) > 0) {
            $vt->setSubAccPurgeTime($vtenant['purge_days']);
            $vt->setMasterAccPurgeTime($vtenant['master_purge_time']);
            $vt->setPurgeType($vtenant['purge_type']);
            $vt->setDeviceLimit($vtenant['device_limit']);
            $vt->setCountry($vtenant['country']);
            $vt->setAddress1($vtenant['address1']);
            $vt->setAddress2($vtenant['address2']);
            $vt->setCity($vtenant['city']);
            $vt->setState($vtenant['state']);
            $vt->setLongitude($vtenant['longitude']);
            $vt->setLatitude($vtenant['latitude']);
            $vt->setMobileNumber1($vtenant['phone1']);
            $vt->setMobileNumber2($vtenant['phone2']);
            $vt->setRealm($vtenant['property_number']);
            $vt->setValidityTime($vtenant['validity_time']);
            $vt->setName($vtenant['org_name']);
            $vt->setDescription($vtenant['org_desc']);
            $vt->setVertical($vtenant['group_verticle']);
            $vt->setAppendRealm($vtenant['append_realm']);
            $vt->setType($vtenant['property_type']);
            $vt->setIgnoreValidityOnSearch($vtenant['ignore_on_search']);
            $vt->setDefaultDeviceProfile($vtenant['default_prof']);
            $vt->setPremiumDeviceProfile($vtenant['premium_profile']);
            $vt->setProbationDeviceProfile($vtenant['probation_prof']);
            $vt->setCompactLink($vtenant['tenant_portal_link']);
            $vt->setRedirectionURL($vtenant['redirection_url']);
            $vt->setPortalFooterText($vtenant['footer_text']);

            $vlan_data = $this->getVlan($vtenant['property_number']);


            $vt->setOnboardingVLANID($vlan_data->getOnboardingVlanId());
            $vt->setVLANIDRanges($vlan_data->getVlanRange());
            $vt->setVLANNotificationLimit($vlan_data->getVlanNotification());
            $vt->setVLANIDRangesTemp($vlan_data->getVlanRangeTemp());


            return $vt;
        } else {
            return false;
        }
    }

    public function getVlan($mrelm_id)
    {
        $str = "SELECT vlan_id,name,description,onboarding_vlan_id,vlan_range,vlan_range_temp,vlan_notification,vlan_pool
                FROM mdu_vlan 
                WHERE vlan_id='%s'";

        $sql = sprintf($str, $mrelm_id);

        $vlan_data = $this->db->select1DB($sql);

        $vlan = new Vlan();
        $vlan->setName($vlan_data['name']);
        $vlan->setDescription($vlan_data['description']);
        $vlan->setVlanId($vlan_data['vlan_id']);
        $vlan->setOnboardingVlanId($vlan_data['onboarding_vlan_id']);
        $vlan->setVlanRange($vlan_data['vlan_range']);
        $vlan->setVlanRangeTemp($vlan_data['vlan_range_temp']);
        $vlan->setVlanNotification($vlan_data['vlan_notification']);
        $vlan->setvlan_pool($vlan_data['vlan_pool']);

        return $vlan;
    }

    public function updateVtenant(Vtenant $vt)
    {
        $str = "UPDATE `mdu_organizations` 
              SET `purge_days` = '%s',
              `master_purge_time`= '%s',
              `purge_type`= '%s',
              `device_limit`= '%s',
              `country`= '%s',
              `address1`= '%s',
              `address2`= '%s',
              `city`= '%s',
              `state`= '%s',
              `longitude`= '%s',
              `latitude`= '%s',
              `phone1`= '%s',
              `phone2`= '%s',
              `validity_time`= '%s',
              `org_name`= '%s',
              `org_desc`= '%s',
              `group_verticle`= '%s',
              `append_realm`= '%s',
              `property_type`= '%s',
              `ignore_on_search`= '%s',
              `default_prof`= '%s',
              `premium_profile`= '%s',
              `probation_prof`= '%s',
              `tenant_portal_link`= '%s',
              `redirection_url`= '%s',
              `footer_text`= '%s', 
              `signup_status`= '%s' 
              WHERE `property_id`= '%s'";

        $sql = sprintf(
            $str,
            $vt->getSubAccPurgeTime(),
            $vt->getMasterAccPurgeTime(),
            $vt->getPurgeType(),
            $vt->getDeviceLimit(),
            $vt->getCountry(),
            $vt->getAddress1(),
            $vt->getAddress2(),
            $vt->getCity(),
            $vt->getState(),
            $vt->getLongitude(),
            $vt->getLatitude(),
            $vt->getMobileNumber1(),
            $vt->getMobileNumber2(),
            $vt->getValidityTime(),
            $vt->getName(),
            $vt->getDescription(),
            $vt->getVertical(),
            $vt->getAppendRealm(),
            $vt->getType(),
            $vt->getIgnoreValidityOnSearch(),
            $vt->getDefaultDeviceProfile(),
            $vt->getPremiumDeviceProfile(),
            $vt->getProbationDeviceProfile(),
            $vt->getCompactLink(),
            $vt->getRedirectionURL(),
            $vt->getPortalFooterText(),
            $vt->getSignup_Status(),
            $vt->getRealm()
        );

        return $this->db->execDB($sql);

        //return true;
    }

    public function a()
    {
        echo 'a';
    }

    public function deleteVertical($delete_vertical_id)
    {
        $str = "DELETE FROM mdu_vertical_group WHERE unique_id='%s'";

        $sql = sprintf($str, $delete_vertical_id);
        return $this->db->execDB($sql);
    }

    public function updateVlan(Vlan $vlan)
    {

        $realm_id = $vlan->getVlanId();
        $realm_name = $vlan->getName();
        $realm_dece = $vlan->getDescription();
        $evlanid_onbid = $vlan->getOnboardingVlanId();
        $change_id_v = $vlan->getVlane1();
        $used_id_v = $vlan->getVlane0();
        $last_used_range_v = $vlan->getLastUsevlanidrange();
        $use_temp_vlanrange = $vlan->getUseTempVlanrange();
        $last_non_used_id_v = $vlan->getLastUsevlanid();
        $vlanRange = $vlan->getVlanRange();
        $used_range_v = $vlan->getUsedRange();
        $newTemp = $vlan->getNewTemp();
        $evlan_notification = $vlan->getVlanNotification();

        //echo "<br>";
        //$query_v = "SELECT `vlan_range_temp` AS f FROM `mdu_vlan` WHERE `vlan_id`='$realm_id'";

        $new_useRange = $this->getVlan($realm_id)->getVlanRangeTemp(); //$db->getValueAsf($query_v);
        $hv_vlan_pool = $this->getVlan($realm_id)->getvlan_pool(); //$db->getValueAsf($query_v);
        $not_use_area = explode(',', $new_useRange);


        if (!empty($vlanRange)) {
            $vlan_jd = json_decode($hv_vlan_pool, true);
            $range = array();

            foreach ($vlan_jd as $vlan_data) {
                array_push($range, $vlan_data);
            }

            $range_ex = explode(',', $vlanRange);

            foreach ($range_ex as $range_u) {

                $vlane_pool =  $this->vlan_get_json($range_u);

                array_push($range, $vlane_pool);
            }

            $vlan_pool = json_encode($range);
        } else {
            $vlan_pool = $hv_vlan_pool;
        }
        //echo "<br>";
        //print_r($use_temp_vlanrange);
        //print_r($not_use_area);
        //	if(isset($_POST['use_temp_vlanrange'])){

        // if (in_array($use_temp_vlanrange, $not_use_area) || empty($use_temp_vlanrange))  {
        //  echo "Match found";

        $change_range_v = $used_id_v . '-' . $change_id_v;
        $temp_change_range_v = $last_non_used_id_v . '-' . $change_id_v;
        $new_range_v = str_replace($last_used_range_v, $change_range_v, $used_range_v);

        // $evlanid_renge=$new_range_v.','.$vlanRange;

        // $evlanid_renge=$_POST['used_range'].','.$_POST['vlanidrange'];
        // $etemp_edit=$_POST['last_vlanidrange'].','.$_POST['vlanidrange'];

        // if(!empty($last_non_used_id_v) && !empty($change_id_v) ){

        //     $etemp_edit=$temp_change_range_v.','.$vlanRange;
        // }else{
        //     $etemp_edit=$vlanRange;
        // }

        // $etemp_edit=trim($etemp_edit,',');


        $evlanid_renge = $newTemp . ',' . $vlanRange;
        $etemp_edit = trim($evlanid_renge, ',');
        $evlanid_renge = trim($evlanid_renge, ',');


        //$vlanedit=$vt->vlan_edit($etemp_edit,$realm_name,$realm_dece,$evlanid_onbid,$evlanid_renge,$realm_id,$evlan_notification);

        $str = "UPDATE mdu_vlan SET name = '%s',vlan_notification = '%s',vlan_range_temp = '%s',onboarding_vlan_id = '%s',description = '%s',vlan_range = '%s',`vlan_pool`='%s'
WHERE vlan_id = '%s'";

        $sql = sprintf($str, $realm_name, $evlan_notification, $etemp_edit, $evlanid_onbid, $realm_dece, $evlanid_renge, $vlan_pool, $realm_id);

        $update = $this->db->execDB($sql);


        if (strlen($update) > 1) {

            return 'failed';
        } else {

            return 'success';
        }

        //}
        //else
        // {
        //  echo "Match not found";
        // return 'used';
        //}
    }




    public function voucher_patterns($data)
    {



        $operator = $data['operator'];
        $word_count = $data['word_count'];
        $min_length = $data['min_length'];
        $max_length = $data['max_length'];
        $seperator = $data['seperator'];

        $voucher_type = $data['voucher_type'];
        $user_name = $data['user_name'];


        $patten_data = array();

        $patten_data['word_count'] = $word_count;
        $patten_data['min_length'] = $min_length;
        $patten_data['max_length'] = $max_length;
        $patten_data['seperator'] = $seperator;
        $pattenJSON = json_encode($patten_data);


        $patten = "";
        for ($i = 0; $i < $word_count; $i++) {
            $patten .= '[WORD]' . $seperator;
        }

        $voucher_patten = trim($patten, $seperator);




        $vt_q = "INSERT INTO `mdu_customer_voucher_patterns` (`voucher_pattern`,  `voucher_type`, `pattern_data`, `mno_id`, `create_date`, `create_user`, `last_update`) 
		VALUES ('$voucher_patten', '$voucher_type', '$pattenJSON','$operator', NOW(), '$user_name', NOW()); ";

        $vt_q_exe = $this->db->execDB($vt_q);

        if ($vt_q_exe === true) {

            return true;
        } else {
            return false;
        }
    }


    public function update_voucher_patterns($data)
    {



        $update_id = $data['update_id'];
        $word_count = $data['word_count'];
        $min_length = $data['min_length'];
        $max_length = $data['max_length'];
        $seperator = $data['seperator'];

        $voucher_type = $data['voucher_type'];
        $user_name = $data['user_name'];


        $patten_data = array();

        $patten_data['word_count'] = $word_count;
        $patten_data['min_length'] = $min_length;
        $patten_data['max_length'] = $max_length;
        $patten_data['seperator'] = $seperator;
        $pattenJSON = json_encode($patten_data);


        $patten = "";
        for ($i = 0; $i < $word_count; $i++) {
            $patten .= '[WORD]' . $seperator;
        }

        $voucher_patten = trim($patten, $seperator);




        $vt_q = "UPDATE `mdu_customer_voucher_patterns` SET `voucher_pattern` = '$voucher_patten' , `pattern_data` = '$pattenJSON' , `create_user` = '$user_name' WHERE `id` = '$update_id'";

        $vt_q_exe = $this->db->execDB($vt_q);

        if ($vt_q_exe === true) {

            return true;
        } else {
            return false;
        }
    }




    public function getAllVoucherPattern()
    {

        $return_ar = array();
        $sql = "SELECT`id`,`mno_id`,`voucher_type`,  GROUP_CONCAT(
            CASE 
                WHEN `voucher_type`='PASSWORD' 
                THEN `voucher_pattern`
                
            END)
         AS 'mno_password_patten',GROUP_CONCAT( 
        CASE 
                WHEN `voucher_type`='VOUCHER' 
                THEN `voucher_pattern`
                
            END )
         AS 'mno_voucher_pattern'
          FROM `mdu_customer_voucher_patterns` 
          GROUP BY `mno_id`;";

        $data = $this->db->selectDB($sql)['data'];

        foreach ($data as $value) {
            $vertical_ob = new Vertical();

            $mno_id = $value['mno_id'];
            $rcheck_q = "SELECT `mno_description` as f FROM `exp_mno` WHERE `mno_id` = '$mno_id'";


            $vertical_ob->voucher_id = $value['id'];
            $vertical_ob->mno_id = $mno_id;
            $vertical_ob->voucher_mno = $this->db->getValueAsf($rcheck_q);
            $vertical_ob->password_patten = $value['mno_password_patten'];
            $vertical_ob->voucher_pattern = $value['mno_voucher_pattern'];




            array_push($return_ar, $vertical_ob);
        }


        return $return_ar;
    }



    public function getVouchers($uid, $type)
    {
        $sql = "SELECT `id`,`voucher_type`,`pattern_data`,`mno_id` FROM `mdu_customer_voucher_patterns` WHERE `mno_id` ='$uid' and `voucher_type` ='$type'";

        $data_array = $this->db->select1DB($sql);

        $vertical_ob = new Vertical();

        // '{"word_count":"4","min_length":"3","max_length":"4","seperator":"-"}'
        $patten = $data_array['pattern_data'];
        $patten_ar = json_decode($patten, true);


        $vertical_ob->voucher_type = $data_array['voucher_type'];
        $vertical_ob->mno_id = $data_array['mno_id'];
        $vertical_ob->id = $data_array['id'];
        $vertical_ob->word_count = $patten_ar["word_count"];
        $vertical_ob->min_length = $patten_ar["min_length"];
        $vertical_ob->max_length = $patten_ar["max_length"];
        $vertical_ob->seperator = $patten_ar["seperator"];


        return $vertical_ob;
    }




    public function deleteVoucherPatten($delete_mno)
    {
        $str = "DELETE FROM mdu_customer_voucher_patterns WHERE `mno_id`='%s'";

        $sql = sprintf($str, $delete_mno);

        return $this->db->execDB($sql);
    }



    public function add_voucher($data)
    {

        $voucher = trim($data['voucher']);
        $dpsk_voucher_type = $data['voucher_type'];
        $user_distributor = $data['user_distributor'];
        $user_name = $data['user_name'];







        $sql = "SELECT * FROM `mdu_customer_voucher` WHERE `distributor` = '$user_distributor' AND `voucher_type` = '$dpsk_voucher_type' AND `status` = '1' ";
        $data = $this->db->selectDB($sql);

        if ($data['rowCount'] > 0) {

            $vt_q = " UPDATE `mdu_customer_voucher` SET `voucher_code` = '$voucher' WHERE `distributor` = '$user_distributor' AND `voucher_type` = '$dpsk_voucher_type' AND `status` = '1' ";
        } else {


            $vt_q = "INSERT INTO `mdu_customer_voucher` (`voucher_code`, `distributor`, `voucher_type`, `status`, `create_date`, `create_user`, `last_update`,`download_key`) 
        VALUES ('$voucher', '$user_distributor', '$dpsk_voucher_type', '1',  NOW(), '$user_name',  NOW(), '') ";
        }


        $vt_q_exe = $this->db->execDB($vt_q);

        if ($vt_q_exe === true) {

            return true;
        } else {
            return false;
        }
    }



    public function add_voucherBULK($data)
    {

        $voucher = trim($data['voucher']);
        $dpsk_voucher_type = $data['voucher_type'];
        $user_distributor = $data['user_distributor'];
        $user_name = $data['user_name'];
        $download_key = $data['download_key'];










        $vt_q = "INSERT INTO `mdu_customer_voucher` (`voucher_code`, `distributor`, `voucher_type`, `status`, `create_date`, `create_user`, `last_update`,`download_key`) 
        VALUES ('$voucher', '$user_distributor', '$dpsk_voucher_type', '1',  NOW(), '$user_name',  NOW(), '$download_key') ";




        $vt_q_exe = $this->db->execDB($vt_q);

        if ($vt_q_exe === true) {

            return true;
        } else {
            return false;
        }
    }


    public function getVoucher_code($user_distributor, $dpsk_voucher_type)
    {
        $sql = "SELECT `voucher_code` FROM `mdu_customer_voucher` WHERE `distributor` = '$user_distributor' AND `voucher_type` = '$dpsk_voucher_type' AND `status` = '1' ";

        $data_array = $this->db->select1DB($sql);


        return $data_array['voucher_code'];
    }

    public function getVoucher_uniq($user_distributor, $dpsk_voucher_type)
    {
        $sql = "SELECT  * FROM `mdu_customer_voucher` WHERE `voucher_type` = '$dpsk_voucher_type' AND `status` = 1 AND `distributor`='$user_distributor' AND `send_email` <> 1 LIMIT 1 ";

        $data_array = $this->db->select1DB($sql);


        return $data_array;
    }

    public function getVoucher_reminingCount($user_distributor, $dpsk_voucher_type)
    {


        return $this->db->getValueAsF("SELECT COUNT(`voucher_code`) AS f FROM `mdu_customer_voucher` WHERE `voucher_type` = '$dpsk_voucher_type' AND `status` = 1 AND `distributor`='$user_distributor'   AND `send_email` <> 1 ");
    }


    public function getuniqVoucherCode($uid)
    {
        $sql = "SELECT `id`,`voucher_type`,`pattern_data`,`mno_id` FROM `mdu_customer_voucher_patterns` WHERE `mno_id` ='$uid' and `voucher_type` ='VOUCHER'";
        $data_array = $this->db->select1DB($sql);

        $patten = $data_array['pattern_data'];

        if (empty($patten)) {
            $sql = "SELECT `id`,`voucher_type`,`pattern_data`,`mno_id` FROM `mdu_customer_voucher_patterns` WHERE `mno_id` ='ADMIN' and `voucher_type` ='VOUCHER'";

            $data_array = $this->db->select1DB($sql);

            $patten = $data_array['pattern_data'];
        }

        $patten_ar = json_decode($patten, true);




        $seperator = $patten_ar["seperator"];
        $pass_min_length = $patten_ar["min_length"];
        $pass_max_length = $patten_ar["max_length"];
        $word_count = $patten_ar["word_count"];
        $generate_count = 1;

        $need_words_count = $word_count * $generate_count;


        // $file = fopen("contacts.csv","r");
        // print_r(fgetcsv($file));
        // fclose($file);

        $key_bulk = array();

        //$key_array = file('../ajax/generater/key_txt.txt');
        $key_array = array("red", "FOOT", "CENT", "green", "blue", "yellow", "brown", "MORE", "JURY", "cum", "admit", "age", "agreement", "on", "me", "we", "middle", "might", "military", "million", "mind", "minute", "miss", "mission", "model");

        //echo count($key_bulk) ."-----". $need_words_count;

        while (count($key_bulk) < $need_words_count) {


            $rand_key = array_rand($key_array);
            $rand_keys_val = trim(strtoupper($key_array[$rand_key]));

            if (strlen($rand_keys_val) == $pass_min_length || strlen($rand_keys_val) == $pass_max_length) {

                $key_bulk[] = $rand_keys_val;
            }
        }


        //print_r($key_bulk);

        $keys = '';
        $keys_set = 0;

        for ($i = 0; $i < $need_words_count; $i++) {



            if ($keys_set < $word_count) {
                $keys_set++;

                $keys .= $key_bulk[$i];

                if ($keys_set != $word_count) {
                    $keys .= $seperator;
                }
            }

            if ($keys_set == $word_count) {

                trim($keys, $seperator);
                $keys_set = 0;
            }
        }

        return trim($keys);
    }





    public function add_voucher_uniq($data)
    {

        $dpsk_voucher_type = trim($data['voucher_type']);
        $user_distributor = $data['user_distributor'];
        $user_name = $data['user_name'];
        $mnoid = $data['mnoid'];
        $voucher = trim($this->getuniqVoucherCode($mnoid));







        $sql = "SELECT * FROM `mdu_customer_voucher` WHERE `distributor` = '$user_distributor' AND `voucher_type` = '$dpsk_voucher_type' AND `status` = '1' ";
        $data = $this->db->selectDB($sql);

        if ($data['rowCount'] > 0) {

            $vt_q = " UPDATE `mdu_customer_voucher` SET `voucher_code` = '$voucher' WHERE `distributor` = '$user_distributor' AND `voucher_type` = '$dpsk_voucher_type' AND `status` = '1' ";
        } else {


            $vt_q = "INSERT INTO `mdu_customer_voucher` (`voucher_code`, `distributor`, `voucher_type`, `status`, `create_date`, `create_user`, `last_update`,`download_key`) 
        VALUES ('$voucher', '$user_distributor', '$dpsk_voucher_type', '1',  NOW(), '$user_name',  NOW(), '') ";
        }


        $vt_q_exe = $this->db->execDB($vt_q);

        if ($vt_q_exe === true) {

            return true;
        } else {
            return false;
        }
    }
}
