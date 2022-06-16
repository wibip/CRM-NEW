<?php
header("Cache-Control: no-cache, must-revalidate");


require_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../../classes/dbClass.php');
require_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../../classes/systemPackageClass.php');

require_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../../classes/CommonFunctions.php');
class external

{
	private $system_package;

	public function __construct($wired, $system_package, $network_name, $ap_controller, $sw_controller, $icomme_number, $location_name, $user_name, $zoneid, $groupid, $offset_val, $automation_property, $account_edit, $wag_ap_name, $ale_automation, $vt_icomme, $data_arr, $field_array, $advanced_features_arr, $timezone_abbreviation, $inputarr)
	{

		$this->db = new db_functions();

		//$this->network_name = $this->db_class->setVal("network_name",'ADMIN');
		$this->wired = $wired;
		$this->package_functions = new package_functions();
		$this->system_package = $system_package;
		$this->network_name = $network_name;
		$this->ap_controller = $ap_controller;
		$this->sw_controller = $sw_controller;
		$this->icomme_number = $icomme_number;
		$this->location_name = $location_name;
		$this->user_name = $user_name;
		$this->zoneid = $zoneid;
		$this->switch_group_id = $groupid;
		$this->offset_val = $offset_val;
		$this->automation_property = $automation_property;
		$this->account_edit = $account_edit;
		$this->wag_ap_name = $wag_ap_name;
		$this->ale_automation = $ale_automation;
		$this->vt_icomme = $vt_icomme;
		$this->dpsk = $data_arr['dpsk_enable'];
		$this->dpsklayout = $data_arr['dpsk_layout'];
		$this->vt_product = $data_arr['vtenant_product'];
		$this->account_edit = $data_arr['account_edit'];
		$this->guest_count = $data_arr['guest'];
		$this->pvt_count = $data_arr['private'];
		$this->vt_count = $data_arr['vtenant'];
		$this->gateway_type = strtolower($data_arr['gateway_type']);
		$this->pr_gateway_type = strtolower($data_arr['pr_gateway_type']);
		$this->mno_id = $data_arr['mno'];
		$this->product = $data_arr['product'];
		$this->distributor = $data_arr['distributor'];
		$this->location_name_old = $data_arr['location_name_old'];
		$this->smb = $data_arr['bussiness_type'];
		$this->wag_name = $data_arr['wag_name'];
		$this->wag_enable = $data_arr['wag_enable'];
		$this->DNS_profile = $data_arr['DNS_profile'];
		$this->DNS_profile_control = $data_arr['DNS_profile_control'];
		$this->mvnx_time_zone = $data_arr['mvnx_time_zone'];
		$this->old_conroller = $data_arr['old_conroller'];
		$this->network_type = $data_arr['network_type'];
		$this->multi_area = $data_arr['multi_area'];
		$this->flow_type = $data_arr['flow_type'];
		$this->dpsk_conroller = $data_arr['dpsk_conroller'];
		$this->dpsk_policies = $data_arr['dpsk_policies'];		
		$this->network_info = $data_arr['network_info'];
		$this->provision = $data_arr['provision'];

		$this->field_array = $field_array;
		$this->advanced_features_arr = $advanced_features_arr;
		$this->timezone_abbreviation = $timezone_abbreviation;
		$this->inputarr = $inputarr;

		if (array_key_exists("top_applications", $advanced_features_arr) && $advanced_features_arr['top_applications'] == '1') {
			$this->avcEnabled = true;
		} else {
			$this->avcEnabled = false;
		}
		//$this->initialConfig($this->system_package);

	}

	public function initialConfig($system_package)
	{

		if ($this->wired == 1) {
			$response = $this->alematchentry();

			return [
				'status_code' => $response,
				'zoneid' => 'noZone'
			];
		}

		$dummy_values = json_decode($this->package_functions->getOptions('API_DUMMY_VAL_JSON', $this->system_package), true);

		$this->private_encryption = $dummy_values['privte_ssid']['encryption']['method'] . '/' . $dummy_values['privte_ssid']['encryption']['algorithm'];
		$this->parent_package = $dummy_values['parent_package'];
		$this->customer_type = $dummy_values['customer_type'];
		$this->parent_product = $dummy_values['parent_product'];
		//$this->wag_name= $dummy_values['wag_name'];
		//$this->wag_enable = $dummy_values['wag_enable'];
		//$this->DNS_profile =$dummy_values['DNS_profile'];

		$this->zone_description = $dummy_values['zone_description'];

		$this->template_zone = $dummy_values['template_zone'];
		//$this->sw_controller_name = $dummy_values['sw_controller'];
		$this->privte_ssidarr = $dummy_values['privte_ssid'];
		$this->privte_ssid_new = $dummy_values['privte_ssid_new'];
		$this->guest_ssidarr = $dummy_values['guest_ssid'];
		$this->vt_ssidarr = $dummy_values['vtenant_ssid'];
		$this->hotspot = $dummy_values['hotspot'];;
		$this->DHCP_profile = $dummy_values['DHCP_profile'];

		$this->dhcp_pool = $dummy_values['DHCP_profile']['vlanId'];
		$this->primary_dns = $dummy_values['DHCP_profile']['primaryDnsIp'];
		$this->subnet = $dummy_values['DHCP_profile']['subnetNetworkIp'];
		$this->secondary_dns = $dummy_values['DHCP_profile']['secondaryDnsIp'];
		$this->subnetMask = $dummy_values['DHCP_profile']['subnetMask'];
		$this->primary_dns_filter = $dummy_values['DHCP_profile']['primaryDnsIp'];
		$this->guest_subnet_start = $dummy_values['DHCP_profile']['poolStartIp'];
		$this->secondary_dns_filter = $dummy_values['DHCP_profile']['secondaryDnsIp'];
		$this->guest_subnet_end = $dummy_values['DHCP_profile']['poolEndIp'];
		$this->dhcp_lease_time = $dummy_values['DHCP_profile']['leaseTimeMinutes'];
		$this->g_encryption = $dummy_values['guest_ssid']['encryption'];
		$this->dhcp_lease_hour = $dummy_values['DHCP_profile']['leaseTimeHours'];
		$this->switch_main_domain_name = $dummy_values['switch_main_domain_name'];
		$this->main_domain_name = $dummy_values['main_domain_name'];
		$this->max_subdomains = $dummy_values['max_subdomains'];

		$isDynamic = $this->package_functions->isDynamic($this->system_package);
		$reseller_automation_on = false;
		if ($isDynamic) {

			$features_sql = "SELECT `features` AS f FROM exp_mno  WHERE `mno_id`='$this->mno_id'";
			$features_json = $this->db->getValueAsf($features_sql);
			$features = json_decode($features_json, true);
			if (in_array("PREPAID_MODULE_N", $features)) {
				$this->isReadyTv = true;
			} else {
				$this->isReadyTv = false;
			}

			$automation_on = $this->package_functions->getSectionType('NETWORK_AUTOMATION', $this->system_package);
			$aaa_type = $this->package_functions->getOptionsAaa('AAA_TYPE', $this->system_package);
			if ($automation_on == 'Yes' && $aaa_type == 'ALE53') {
				$reseller_automation_on = true;
			}
			$getJson = $this->db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='DYNAMIC_MNO_001' AND `config_type`='api'");
		} else {
			$this->isReadyTv = false;
			$getJson = $this->db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='$this->system_package' AND `config_type`='api'");
		}

		$configFileArr = json_decode($getJson, true);
		$this->vlan_start = $configFileArr['Guest_vlan_id'];
		$this->p_vlan_start = $configFileArr['Private_vlan_id'];
		$this->vt_vlan_start = $configFileArr['vTenant_vlan_id'];
		//print_r($configFileArr);
		$this->product_pvt = $configFileArr['private_product'];

		if (!$reseller_automation_on && $this->provision != 1) {
			$external_json = $this->package_functions->getOptions('PROPERTY_CREATE_EXTERNAL_JSON', $this->system_package);
			$external_arr = json_decode($external_json, true);
			if (empty($external_arr)) {
				$external_arr = array('vsz' => array(
					'auto' =>  'ruckusautomation',
					'manual' =>  'ruckusmanual'
				));
			}

			if ($this->isReadyTv) {
				$external_arr = array('vsz' => array(
					'auto' =>  'ruckusautomation',
					'manual' =>  'ruckusmanual'
				), 'zabbix' => 'zabbix');
			}
		} else {
			$external_arr = array('vsz' => array(
				'auto' =>  'ruckusautomation',
				'manual' =>  'ruckusmanual'
			), 'aaa' => 'alematchentry', 'zabbix' => 'zabbix');
		}
		$ale = false;
		$vszauto = false;
		$this->automation_property;
		foreach ($external_arr as $key => $value) {
			if ($key == 'vsz') {
				if ($this->automation_property == 'on') {
					$vszauto = true;
					$function = strval($value['auto']);
					if (!$error) {
						$response = $this->$function();
						$zoneid_new = $response['zoneid'];
						if (strlen($zoneid_new) < 1) {
							$zoneid_new = $this->zoneid;
						}
					}
				} else {
					$function = strval($value['manual']);
					if (!$error) {
						$response = $this->$function();
						//$response= $this->ruckusmanual();
					}
				}
				if ($response['status_code'] != '200') {
					//$error = true;
				}
			} elseif ($key == 'aaa') {
				$ale = true;
				$value = strval($value);
				if (!$error) {
					$response = $this->$value();
					if ($response != '200') {
						$error = true;
					}
				}
			} else {
				if ($this->account_edit != 1 && $this->smb == 'SMB') {
					if (!$error) {
						$response = $this->$value();
					}

					if ($response != '200') {
						//$error = true;
					}
				}
			}
			if (!$error) {
				$status_code = 200;
			} else {
				$status_code = 0;
			}
		}
		//echo $status_code;
		if ($this->dpsk) {
			if ($status_code == 200) {
				$response = $this->cloudpathapi();
				if ($response == 200) {
					$status_code = 200;
				} else {
					$status_code = 0;
				}
			}
		}
		//$status_code=0;
		if ($status_code != 200 && $this->account_edit != 1) {
			if ($ale) {
				$response = $this->delalematchentry();
			}
			if ($vszauto) {
				$response = $this->delRuckuszone();
			}
		}
		return array(
			'status_code' => $status_code,
			'zoneid' => $zoneid_new
		);
	}

	public function delRuckuszone()
	{
		$ap_data = $this->db->select1DB("SELECT `id`,`api_profile` FROM `exp_locations_ap_controller` WHERE `controller_name` = '$this->ap_controller'");
		$profile = $ap_data['api_profile'];
		$ap_id = $ap_data['id'];
		$sw_data = $this->db->select1DB("SELECT `id`,`api_profile` FROM `exp_locations_ap_controller` WHERE `controller_name` = '$this->sw_controller'");
		$sw_profile = $sw_data['api_profile'];
		$sw_id = $sw_data['id'];

		if ($profile == '') {
			$profile = $this->db->setVal('wag_ap_name', 'ADMIN');
			if ($profile == '') {
				$profile = "non";
			}
		}
		if ($this->provision == 1) {
			require_once '../../src/AP/' . $profile . '/index.php';
		}else{
			require_once 'src/AP/' . $profile . '/index.php';
		}
		$wag_obj = new ap_wag($this->ap_controller);
		$wag_obj->setRealm($this->icomme_number);
		$wag_obj->AutoInc = $ap_id;

		$switch = 0;
		if ($sw_profile != $profile && strlen($sw_profile)>0) {
			require_once 'src/AP/' . $sw_profile . '/index.php';
			$wag_objSw = new ap_wag($this->sw_controller);
			$wag_objSw->setRealm($this->icomme_number);
			$wag_objSw->AutoInc = $sw_id;
		}
		//$wag_objSw->deleteswitchgroup($switch_group_id);

		$wag_obj->deletezone($zoneid);
	}

	public function delalematchentry()
	{
		$row1 = $this->db->select1DB("SELECT * FROM `exp_network_profile` WHERE network_profile = '$this->network_name'");
		$aaa_data = json_decode($row1['aaa_data'], true);
		$network_profile = $row1['api_network_auth_method'];
		$row = $this->db->select1DB("SELECT * FROM `exp_mno` WHERE mno_id='$this->mno_id'");
		$aaa_data_op = json_decode($row['aaa_data'], true);

		require_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../../src/AAA/' . $network_profile . '/index.php');

		$aaa = new aaa($this->network_name, $this->system_package);
		$aaa_data = $aaa->getNetworkConfig($this->network_name,'aaa_data');
		$property_zone_name = str_replace(" ", "-", $this->location_name . " " . $this->icommen);
		$property_zone_name = CommonFunctions::clean($property_zone_name);
		$all_zones = json_decode($aaa->getAllZones(), true);

		foreach ($all_zones['Description'] as $value) {
			if ($value['Id'] == $aaa_data['aaa_root_zone_id']) {

				foreach ($value['Sub-Zones'] as $value1) {
					if ($value1['Name'] == $aaa_data_op['operator_zone_name']) {
						$op_zone_exists = true;
						$op_zone_id = $value1['Id'];
						foreach ($value1['Sub-Zones'] as $value2) {
							if ($value2['Name'] == $property_zone_name) {
								$property_arr = $value2;
								$property_zone_id = $value2['Id'];
								if (!empty($value2['Sub-Zones'])) {
									$prop_sub_zones = $value2['Sub-Zones'];
								}
							}
						}
					}
				}
			}
		}
		//print_r($prop_sub_zones); exit();
		foreach ($prop_sub_zones as $valuen) {
			$lookupkey = $valuen['Zone-Data']['Location-Id'];
			$zone_id = $valuen['Id'];
			if (!empty($valuen['Sub-Zones'])) {
				foreach ($valuen['Sub-Zones'] as $valuenew) {
					$lookupkeysub = $valuenew['Zone-Data']['Location-Id'];
					$zone_idsub = $valuenew['Id'];
					$aaa->deleteLookupZone($lookupkeysub);
					$aaa->deleteZone($zone_idsub);
				}
			}
			$aaa->deleteLookupZone($lookupkey);
			$aaa->deleteZone($zone_id);
		}
		if (strlen($property_zone_id) > 0) {
			$aaa->deleteZone($property_zone_id);
		}
	}

	public function alematchentry()
	{
		$row1 = $this->db->select1DB("SELECT * FROM `exp_network_profile` WHERE network_profile = '$this->network_name'");
		$aaa_data = json_decode($row1['aaa_data'], true);
		$network_profile = $row1['api_network_auth_method'];
		$row = $this->db->select1DB("SELECT * FROM `exp_mno` WHERE mno_id='$this->mno_id'");
		$aaa_data_op = json_decode($row['aaa_data'], true);
		require_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../../src/AAA/' . $network_profile . '/index.php');
		$aaa = new aaa($this->network_name, $this->system_package);
		$aaa_data = $aaa->getNetworkConfig($this->network_name,'aaa_data');
		$loc_name = $this->location_name;
		$icom = $this->realm;
		$pr_arr = array();
		$guest_arr = array();
		$mdu_arr = array();
		$guest_wlan_count = $this->guest_count;
		$pvt_wlan_count = $this->pvt_count;
		$vt_wlan_count = $this->vt_count;
		if ($this->wired == 1) {
			//$this->smb = 'MDU';
			$vt_wlan_count = 1;
		}
		$pattern = '/R[1-9]+$/';
		$this->vt_icommenew = $this->vt_icomme;
		$icommen = preg_replace($pattern, '', $this->vt_icomme);
		$icomearr = explode('-', $icommen);
		$this->vt_icomme = $icomearr[0];

		$icomme_number = $this->icomme_number;
		$this->icommen = $icomme_number;
		$icommen = preg_replace($pattern, '', $this->icomme_number);
		$icomearr = explode('-', $icommen);
		$this->icomme_number = $icomearr[0];

		$row = $this->db->selectDB("SELECT * FROM `exp_lookup_entry` WHERE user_distributor = '$this->distributor' ORDER BY `id` DESC");
		$exisiting_wlan = $row['data'];

		//$vt_arr = array();
		$datanew = $this->db->selectDB("SELECT * FROM `exp_lookup_entry` WHERE realm = '$this->icomme_number'");
		$data_wlan = $datanew['data'];
		$wlan_array = 1;
		if (strlen($data_wlan['zone_id']) > 0) {
			$wlan_array = 0;
		}
		//print_r($this->account_edit);
		$lookup_keycreate = true;
		if ($this->gateway_type != 'wag') {
			//$lookup_keycreate = true;
		}
		if (empty($data_wlan) || $this->account_edit == 1 || $wlan_array == 0) {
			if ($this->account_edit != 1) {
				$del_map_q = "DELETE FROM `exp_lookup_entry` WHERE `realm` = '$this->icomme_number'";
				$this->db->execDB($del_map_q);
				$del_map_q2 = "DELETE FROM `exp_lookup_entry` WHERE `realm` = '$this->icommen'";
				$this->db->execDB($del_map_q2);
			}
			/*if ($this->wired == 1 && $this->smb == 'MDU') {
    		$mduname = 'resident-1';
    	$locationew = $this->icomme_number.'-R1';
        $mduaccessgroup = $this->icomme_number.'R'.$i;
		$mdu_arry=array(
                "Name"=>$mduname,
                "Access-Group"=> $mduaccessgroup,
                "Redirect-URL"=> $this->db->setVal("mdu_portal_base_url", "ADMIN").'/checkpoint.php',
                'Zone-Data' => array(
                    'Nas-Type'=> 'ac',
                    'Location-Id'=> $locationew
                )
                    );
        $mdu_arry['Description'] = 'This contains match table entry for mdu network (no vlan id)';
    	
        array_push($mdu_arr, $mdu_arry);
		}else{*/
			$vlan_start = $this->vlan_start;
			$mno_package = $this->db->select1DB("SELECT system_package FROM exp_mno WHERE mno_id='$this->mno_id' LIMIT 1");
			$mno_package = $mno_package[system_package];
			$lookup_entry_profile = $this->package_functions->getOptions('LOOKUP_ENTRY_PROFILE', $mno_package);
			$lookupdata_custom = $this->db->getValueAsf("SELECT `fearture_settings` AS f FROM `lookup_entry_config` WHERE feature_code='$lookup_entry_profile' AND `user_type`='MNO'");
			/*$settings_vars = array(
	                            '{$matchtablename}' => 'guest',
	                            '{$icomme_number}' => $icomme,
	                            '{$i}' => '1',
	                            '{$guest_url_parameter}' => $db_class->setVal("portal_base_url", "ADMIN"),
	                            '{$vlanstart}' => $vlan_start
	                        );
	    $lookupdata_custom = strtr($lookupdata_custom, $settings_vars);*/
			$lookupdata_custom = json_decode($lookupdata_custom, true);
			$guest_entry_config = json_encode($lookupdata_custom['guest'][$this->gateway_type]);
			$pvt_entry_config = json_encode($lookupdata_custom['pvt'][$this->pr_gateway_type]);
			$vt_entry_config = json_encode($lookupdata_custom['vt']);
			$mdu_entry_config = json_encode($lookupdata_custom['mdu']);
			$jsonconfig = false;

			if (!empty($lookupdata_custom)) {
				$jsonconfig = true;
			}

			for ($i = 1; $i < $guest_wlan_count + 1; $i++) {
				if ($jsonconfig) {
					$settings_vars = array(
						'{$icomme_number}' => $this->icomme_number,
						'{$location_id}' => $this->icomme_number,
						'{$i}' => $i,
						'{$guest_url_parameter}' => $this->db->setVal("portal_base_url", "ADMIN") . '/checkpoint.php',
						'{$vlanstart}' => $vlan_start
					);
					$guest_entry_config = strtr($guest_entry_config, $settings_vars);
					$g_arry = json_decode($guest_entry_config, true);
				} else {

					if ($this->gateway_type == 'wag') {
						//$location = 'Guest-G'.$i.$vlan_start;
						$gname = 'guest-' . $i;
						$gaccessgroup = $this->icomme_number . 'G' . $i;
						$location = $this->icomme_number . $vlan_start;
						//$location = $this->icomme_number.$vlan_start;
					} elseif ($this->gateway_type == 'ac') {
						$gname = 'guest-' . $i;
						$gaccessgroup = $this->icomme_number . 'G' . $i;
						if ($this->smb == 'MDU' || $this->smb == 'VTenant') {
							$location = $this->icomme_number . '-G' . $i;
						} else {
							$location = $this->icomme_number . '-G' . $i;
						}
					} else {
						$gname = 'guest-' . $i;
						$gaccessgroup = $this->icomme_number . 'G' . $i;
						$location = $this->icomme_number . $vlan_start;
					}

					$g_arry = array(
						"Name" => $gname,
						"Access-Group" => $gaccessgroup,
						"Redirect-URL" => $this->db->setVal("portal_base_url", "ADMIN") . '/checkpoint.php',
						'Zone-Data' => array(
							'Nas-Type' => $this->gateway_type,
							'Location-Id' => $location
						)
					);
					$g_arry['Description'] = 'This contains match table entry for guest network';
				}
				array_push($guest_arr, $g_arry);
				$vlan_start = $vlan_start + 1;
			}
			$product_new = $this->product_pvt;
			if (empty($product_new)) {
				$product_new = $this->db->getValueAsf("SELECT product_code as f FROM exp_products WHERE mno_id='$this->mno_id' AND `network_type` = 'PRIVATE' LIMIT 1");
			}

			$p_vlan_start = $this->p_vlan_start;
			for ($j = 1; $j < $pvt_wlan_count + 1; $j++) {
				if ($jsonconfig) {
					$settings_vars = array(
						'{$icomme_number}' => $this->icomme_number,
						'{$location_id}' => $this->icomme_number,
						'{$j}' => $j,
						'{$product_name}' => $product_new,
						'{$pvtvlanstart}' => $p_vlan_start
					);
					$pvt_entry_config = strtr($pvt_entry_config, $settings_vars);
					$p_arry = json_decode($pvt_entry_config, true);
				} else {
					if ($this->pr_gateway_type == 'wag') {
						$location = $this->icomme_number . $p_vlan_start;
						$pname = 'private-' . $j;
						$paccessgroup = $this->icomme_number . 'P' . $j;
						//$location = $this->icomme_number.$p_vlan_start;
					} elseif ($this->pr_gateway_type == 'ac') {
						$pname = 'private-' . $j;
						$paccessgroup = $this->icomme_number . 'P' . $j;
						if ($this->smb == 'MDU' || $this->smb == 'VTenant') {
							$location = $this->icomme_number . '-P' . $j;
						} else {
							$location = $this->icomme_number . '-P' . $j;
						}
					} else {
						$pname = 'private-' . $j;
						$paccessgroup = $this->icomme_number . 'P' . $j;
						$location = $this->icomme_number . $p_vlan_start;
					}
					$p_arry = array(
						"Name" => $pname,
						"Access-Group" => $paccessgroup,
						'Zone-Data' => array(
							'Nas-Type' => $this->pr_gateway_type,
							'Location-Id' => $location,
							'Free-Access' => $product_new
						)
					);
					$p_arry['Description'] = 'This contains match table entry for private network';
				}
				array_push($pr_arr, $p_arry);
				$p_vlan_start = $p_vlan_start + 1;
			}
			if ($vt_wlan_count > 0) {
				$vt_vlan_start = $this->db->getValueAsf("SELECT onboarding_vlan_id as f FROM mdu_vlan WHERE vlan_id='$this->vt_icommenew'");
			}

			if ($this->isReadyTv) {
				for ($k = 1; $k < $vt_wlan_count + 1; $k++) {
					$mduname = 'vTenant-' . $k;
					$mduaccessgroup = $this->icomme_number . 'R' . $k;
					//$location = $this->icomme_number;

					$mdu_arry = array(
						"Name" => $mduname,
						"Access-Group" => $this->vt_icomme,
						"Redirect-URL" => $this->db->setVal("mdu_portal_base_url", "ADMIN") . '/checkpoint.php',
						'Zone-Data' => array(
							'Nas-Type' => 'vsz',
							'Location-Id' => $this->vt_icomme
						)
					);
					$mdu_arry['Description'] = 'This contains match table entry for vsz network';
					array_push($mdu_arr, $mdu_arry);
				}
			} else {
				if ($this->smb == 'MDU') {
					for ($k = 1; $k < $vt_wlan_count + 1; $k++) {
						$jsonconfig = false;
						if ($jsonconfig) {
							$settings_vars = array(
								'{$icomme_number}' => $this->icomme_number,
								'{$vtenant_icomme_number}' => $this->vt_icomme,
								'{$tenant_redirect_url}' => $this->db->setVal("mdu_portal_base_url", "ADMIN") . '/checkpoint.php'
							);

							$mdu_entry_config = strtr($mdu_entry_config, $settings_vars);
							$mdu_arry = json_decode($mdu_entry_config, true);
						} else {
							$mduname = 'resident-' . $k;

							$newstring = substr($this->icomme_number, -2);
							if ($newstring == 'R1') {
								$pattern = '/R[1-9]+$/';
								$icommen = preg_replace($pattern, '', $this->icomme_number);
								$icomearr = explode('-', $icommen);
								$location = $icomearr[0] . '-R1';
								$mduaccessgroup = $icomearr[0] . 'R' . $k;
							} else {
								$location = $this->icomme_number . '-R1';
								$mduaccessgroup = $this->icomme_number . 'R' . $k;
							}

							$mdu_arry = array(
								"Name" => $mduname,
								"Access-Group" => $mduaccessgroup,
								"Redirect-URL" => $this->db->setVal("mdu_portal_base_url", "ADMIN") . '/checkpoint.php',
								'Zone-Data' => array(
									'Nas-Type' => 'ac',
									'Location-Id' => $location
								)
							);
							$mdu_arry['Description'] = 'This contains match table entry for mdu network (no vlan id)';
						}
						array_push($mdu_arr, $mdu_arry);
					}
				} else {

					for ($k = 1; $k < $vt_wlan_count + 1; $k++) {

						//$vt_vlan_start = $this->vt_vlan_start;
						$vt_icomme_number_new = empty($this->vt_icomme) ? $this->icomme_number . 'V' . $k : $this->vt_icomme;
						if ($jsonconfig) {
							$settings_vars = array(
								'{$icomme_number}' => $this->icomme_number,
								'{$vtenant_icomme_number}' => $vt_icomme_number_new,
								'{$vt_vlan_start}' => $vt_vlan_start,

								'{$tenant_redirect_url}' => $this->db->setVal("mdu_portal_base_url", "ADMIN") . '/checkpoint.php'
							);

							$vt_entry_config = strtr($vt_entry_config, $settings_vars);
							$vt_arry = json_decode($vt_entry_config, true);
							$valuevt = $vt_arry['vTenant'];
							$valuevsz = $vt_arry['vsz'];
							$valueac = $vt_arry['onboarding'];
							$valuesw = $vt_arry['switch'];
						} else {
							$vt_gateway_type = 'ac';

							if ($this->dpsk) {
								if ((substr($this->icomme_number, -2) === "R1")) {
									$dpsklookup = $this->icomme_number;
									$pattern = '/R[1-9]+$/';
									$icommen = preg_replace($pattern, '', $this->icomme_number);
									$icomearr = explode('-', $icommen);
									$dpsklookup = $icomearr[0] . '-R1';
								} else {
									$dpsklookup = $this->icomme_number . '-R1';
								}
								$vt_arr = array(
									array(
										"Name" => 'resident-' . $k,
										'vTenant' => array(
											"Name" => 'resident-' . $k,
											"Description" => "This contains match table entry for Resident network",
											"Access-Group" => $this->icomme_number . 'R1',
											"Zone-Data" => array(
												"onboardvlan" => (string)$vt_vlan_start
											)
										),
										'onboarding' => array(
											"Name" => 'onboarding-' . $k,
											"Description" => "This contains match table entry for Resident->onboard-ac network",
											"Redirect-URL" => $this->db->setVal("mdu_portal_base_url", "ADMIN") . '/checkpoint.php',
											'Zone-Data' => array(
												'Nas-Type' => 'ac',
												'Location-Id' => $this->icomme_number . '-O' . $k
											)
										),
										'switch' => array(
											"Name" => 'switch',
											"Description" => "This contains match table entry for Resident->switch network",
											'Zone-Data' => array(
												'Location-Id' => 'icxsw_' . $this->icomme_number
											)
										),
										'vsz' => array(
											"Name" => 'vsz',
											"Description" => "This contains match table entry for Resident->vsz network",
											'Zone-Data' => array(
												'Nas-Type' => 'ac',
												'Location-Id' => $this->icomme_number
											)
										),

										'dpsk' => array(
											"Name" => 'secure-' . $k,
											"Description" => "This contains match table entry for Resident->secure network",
											'Zone-Data' => array(
												'Nas-Type' => 'ac',
												'Location-Id' => $dpsklookup/*,
												'Free-Access' => $this->vt_product*/
											)
										)
									)

								);
							} else {
								if ($vt_gateway_type == 'ac') {
									$vt_arr = array(
										array(
											"Name" => 'resident-' . $k,
											'vTenant' => array(
												"Name" => 'resident-' . $k,
												"Description" => "This contains match table entry for Resident network",
												"Access-Group" => $this->icomme_number . 'R1',
												"Zone-Data" => array(
													"onboardvlan" => (string)$vt_vlan_start
												)
											),
											'onboarding' => array(
												"Name" => 'onboarding-' . $k,
												"Description" => "This contains match table entry for Resident->onboard-ac network",
												"Redirect-URL" => $this->db->setVal("mdu_portal_base_url", "ADMIN") . '/checkpoint.php',
												'Zone-Data' => array(
													'Nas-Type' => 'ac',
													'Location-Id' => $this->icomme_number . '-O' . $k
												)
											),
											'switch' => array(
												"Name" => 'switch',
												"Description" => "This contains match table entry for Resident->switch network",
												'Zone-Data' => array(
													'Location-Id' => 'icxsw_' . $this->icomme_number
												)
											),
											'vsz' => array(
												"Name" => 'vsz',
												"Description" => "This contains match table entry for Resident->vsz network",
												'Zone-Data' => array(
													'Nas-Type' => 'ac',
													'Location-Id' => $this->icomme_number
												)
											)
										)

									);
								} else {
									$vt_arr = array(
										array(
											"Name" => 'vTenant-' . $k,
											'vTenant' => array(
												"Name" => 'vTenant-' . $k,
												"Description" => "This contains match table entry for vTenant network",
												"Access-Group" => $vt_icomme_number_new,
												"Zone-Data" => array(
													"onboardvlan" => (string)$vt_vlan_start
												)
											),
											'onboarding' => array(
												"Name" => 'onboarding-ac',
												"Description" => "This contains match table entry for vTenant->onboard-ac network",
												"Redirect-URL" => $this->db->setVal("mdu_portal_base_url", "ADMIN") . '/checkpoint.php',
												'Zone-Data' => array(
													'Nas-Type' => 'ac',
													'Location-Id' => 'ac_' . $this->icomme_number
												)
											),
											'switch' => array(
												"Name" => 'switch',
												"Description" => "This contains match table entry for vTenant->switch network",
												'Zone-Data' => array(
													'Location-Id' => 'icxsw_' . $this->icomme_number
												)
											),
											'vsz' => array(
												"Name" => 'vsz',
												"Description" => "This contains match table entry for vTenant->vsz network",
												'Zone-Data' => array(
													'Location-Id' => $this->icomme_number . $vt_vlan_start
												)
											)
										)

									);
								}
							}
						}
						//array_push($vt_arr, $vt_arry);
					}
				}
			}
			//}
		} else {
			$get_map_q = "SELECT * FROM `exp_lookup_entry` WHERE `realm` = '$this->icomme_number'  ORDER BY `wlan_name` ASC";
			$get_map = $this->db->selectDB($get_map_q);
			$vtenant_exist = false;

			$z = 0;
			$array_vln = array();
			foreach ($get_map['data'] as $row) {
				$array_new = array($row['wlan_name'] => $row['vlan_id']);
				if ($z == 0) {
					$array_vln = $array_new;
				} else {
					$array_vln = array_merge($array_vln, $array_new);
				}
				$z = $z + 1;
			}
			if (strlen($this->account_edit) < 1) {
				$del_map_q = "DELETE FROM `exp_lookup_entry` WHERE `realm` = '$this->icomme_number'";
				$this->db->execDB($del_map_q);
				$del_map_q2 = "DELETE FROM `exp_lookup_entry` WHERE `realm` = '$this->icommen'";
				$this->db->execDB($del_map_q2);
			}

			foreach ($data_wlan as $value) {
				if ($value['wlan_type'] == 'Guest') {
					$g_arry = array(
						"Name" => $value['wlan_name'],
						"Access-Group" => $value['net_realm'],
						"Description" => $value['description'],
						"Redirect-URL" => $value['redirect_url'],
						'Zone-Data' => array(
							'Nas-Type' => $value['nas_type'],
							'Location-Id' => $value['lookup_key']
						)
					);
					array_push($guest_arr, $g_arry);
					# code...
				} else if ($value['wlan_type'] == 'Private') {
					$p_arry = array(
						"Name" => $value['wlan_name'],
						"Access-Group" => $value['net_realm'],
						"Description" => $value['description'],
						'Zone-Data' => array(
							'Nas-Type' => $value['nas_type'],
							'Location-Id' => $value['lookup_key'],
							'Free-Access' => $value['product']
						)
					);
					array_push($pr_arr, $p_arry);
				} else if ($value['wlan_type'] == 'Mdu') {
					$mdu_arry = array(
						"Name" => $value['wlan_name'],
						"Access-Group" => $value['net_realm'],
						"Description" => $value['description'],
						"Redirect-URL" => $value['redirect_url'],
						'Zone-Data' => array(
							'Nas-Type' => $value['nas_type'],
							'Location-Id' => $value['lookup_key']
						)
					);
					array_push($mdu_arr, $mdu_arry);
				} else {
					if ($value['wlan_type'] == 'vTenant') {
						$vtenantname = $value['wlan_name'];
						$valuevt = array(
							"Name" => $value['wlan_name'],
							"Description" => $value['description'],
							"Access-Group" => $value['net_realm'],
							"Zone-Data" => array(
								"onboardvlan" => (string)$value['onboard_vlan']
							)
						);
					}
					if ($value['wlan_type'] == 'onboarding-ac') {
						$valueac = array(
							"Name" => $value['wlan_name'],
							"Description" => $value['description'],
							"Redirect-URL" => $value['redirect_url'],
							'Zone-Data' => array(
								'Nas-Type' => 'ac',
								'Location-Id' => $value['lookup_key']
							)
						);
					}
					if ($value['wlan_type'] == 'switch') {
						$valuesw = array(
							"Name" => $value['wlan_name'],
							"Description" => $value['description'],
							'Zone-Data' => array(
								'Location-Id' => $value['lookup_key']
							)
						);
					}
					if ($value['wlan_type'] == 'vsz') {
						$valuevsz = array(
							"Name" => $value['wlan_name'],
							"Description" => $value['description'],
							'Zone-Data' => array(
								'Nas-Type' => 'ac',
								'Location-Id' => $value['lookup_key']
							)
						);
					}
					if ($value['wlan_type'] == 'secure') {
						$valuedpsk = array(
							"Name" => $value['wlan_name'],
							"Description" => $value['description'],
							'Zone-Data' => array(
								'Nas-Type' => 'ac',
								'Location-Id' => $value['lookup_key']/*,
								'Free-Access' => $value['product']*/
							)
						);
					}
				}
			}
			if (!empty($valuevt)) {
				if (!empty($valuedpsk)) {
					$product = $valuedpsk['Zone-Data']['Free-Access'];
					if (strlen($product)<1) {
						//$valuedpsk['Zone-Data']['Free-Access'] = $this->vt_product;
					}
				}
				$vt_arr = array(
					array(
						"Name" => $vtenantname,
						'vTenant' => $valuevt,
						'onboarding' => $valueac,
						'switch' => $valuesw,
						'vsz' => $valuevsz,
						'dpsk' => $valuedpsk,
					)
				);
			}
		}
		

		$all_zones = json_decode($aaa->getAllZones(), true);

		$op_zone_exists = false;
		$prop_zone_exists = false;
		$status_code = 200;
		$property_zone_name = str_replace(" ", "-", $loc_name . " " . $icomme_number);
		$property_zone_name = CommonFunctions::clean($property_zone_name);
		if ($this->account_edit == '1') {
			$property_zone_name_old = str_replace(" ", "-", $this->location_name_old . " " . $icomme_number);
			$property_zone_name_old = CommonFunctions::clean($property_zone_name_old);
			$property_zone_name_vt = str_replace(" ", "-", $this->location_name_old . " " . $this->vt_icommenew);
			$property_zone_name_vt = CommonFunctions::clean($property_zone_name_vt);
		}

		$prop_sub_zones = array();
		if ($all_zones['status'] == 'success') {
			$default_zone_ext = false;
			foreach ($all_zones['Description'] as $value) {
				if ($value['Id'] == $aaa_data['aaa_root_zone_id']) {

					foreach ($value['Sub-Zones'] as $value1) {
						if ($value1['Name'] == $aaa_data_op['operator_zone_name']) {
							$op_zone_exists = true;
							$op_zone_id = $value1['Id'];
							foreach ($value1['Sub-Zones'] as $value2) {
								if ($value2['Name'] == $property_zone_name || $value2['Name'] == $property_zone_name_old || $value2['Name'] == $property_zone_name_vt) {
									//print_r($value2['Name']);
									$old_vtacc = false;
									if ($property_zone_name_vt == $value2['Name']) {
										$old_vtacc = true;
									}

									$prop_zone_exists = true;
									$property_zone_id = $value2['Id'];
									if (!empty($value2['Sub-Zones'])) {
										$prop_sub_zones = $value2['Sub-Zones'];
									}
								}
							}
						}
					}
					$default_zone_ext = true;
				}
			}
			if ($guest_wlan_count == 0 && $pvt_wlan_count == 0) {
				$icomme_current = $this->vt_icomme;
				$old_vtacc = true;
			}
			if ($op_zone_exists && $default_zone_ext) {

				if (!$prop_zone_exists) {
					$create_zone = json_decode($aaa->createZone(array('Name' => $property_zone_name, 'Description' => 'This contains match table entries for property ' . $property_zone_name . '.', 'Parent-Zone' => $aaa_data_op['operator_zone_id'])), true);
					//print_r($create_zone); exit();
					if ($create_zone['status'] == 'success') {
						$property_zone_id = $create_zone['Description']['Id'];
					} else {
						$status_code = 0;
					}
				} elseif ($property_zone_name != $property_zone_name_old || ($property_zone_name != $property_zone_name_vt && $old_vtacc)) {
					if ($guest_wlan_count == 0 && $pvt_wlan_count == 0 && $this->account_edit == '1') {
						//$property_zone_name = $property_zone_name_vt;
					}
					$create_zone = json_decode($aaa->updateZone($property_zone_id, array('Id' => $property_zone_id, 'Name' => $property_zone_name, 'Description' => 'This contains match table entries for property ' . $property_zone_name . '.', 'Parent-Zone' => $aaa_data_op['operator_zone_id'])), true);
					if ($create_zone['status'] == 'success') {
						$property_zone_id = $create_zone['Description']['Id'];
					} else {
						$status_code = 0;
					}
				}

				if (!$error) {
					$status_code = 200;
					foreach ($exisiting_wlan as $value) {
						$wlan_type = $value['wlan_type'];
						$zone_id = $value['zone_id'];
						$lookup_key = $value['lookup_key'];
						$id = $value['id'];
						if ($guest_wlan_count == 0 && $wlan_type == 'Guest') {
							$status = '200';
							if (strlen($lookup_key) > 0) {
								$deleteLookup = $aaa->deleteLookupZone($lookup_key);
							}
							$aaa->deleteZone($zone_id);
							$this->db->execDB("DELETE FROM exp_lookup_entry WHERE `id` ='$id'");
						}
						if ($pvt_wlan_count == 0 && $wlan_type == 'Private') {
							$status = '200';
							if (strlen($lookup_key) > 0) {
								$deleteLookup = $aaa->deleteLookupZone($lookup_key);
							}
							$aaa->deleteZone($zone_id);
							$this->db->execDB("DELETE FROM exp_lookup_entry WHERE `id` ='$id'");
						}
						if ($wlan_type == 'vTenant') {
							$status = '200';
							if ($vt_wlan_count == 0 || $this->smb == 'MDU') {

								if (strlen($lookup_key) > 0) {
									$deleteLookup = $aaa->deleteLookupZone($lookup_key);
								}
								$aaa->deleteZone($zone_id);
								$this->db->execDB("DELETE FROM exp_lookup_entry WHERE `id` ='$id'");
							}
						}
						if ($wlan_type == 'Mdu') {
							$status = '200';
							if ($vt_wlan_count == 0 || $this->smb != 'MDU') {
								if (strlen($lookup_key) > 0) {
									$deleteLookup = $aaa->deleteLookupZone($lookup_key);
								}
								$aaa->deleteZone($zone_id);
								$this->db->execDB("DELETE FROM exp_lookup_entry WHERE `id` ='$id'");
							}
						}
					}
					foreach ($guest_arr as $value3) {
						$value3['Parent-Zone'] = $property_zone_id;
						if (array_search($value3['Name'], array_column($prop_sub_zones, 'Name')) === false) {
							$create_wlan_zone = json_decode($aaa->createZone($value3), true);
							$namen = $value3['Name'];
							$vlan_new = $array_vln[$namen];
							if (strlen($vlan_new) < 1) {
								$vlan_new = $this->vlan_start;
							}

							if ($create_wlan_zone['status'] == 'success') {
								$wlan_zone_id = $create_wlan_zone['Description']['Id'];
								if ($lookup_keycreate) {
									$create_lookup_zone = json_decode($aaa->createLookupEntry(array('Id' => $value3['Zone-Data']['Location-Id'], 'Description' => 'Lookup Key for guest network', 'Zone-List' => array($wlan_zone_id))), true);
									if ($create_lookup_zone['status'] != 'success') {
										//$status_code = 0;
									}
								}
								$access_group = $value3['Access-Group'];
								$networkname = $value3['Name'];
								$querynew = "INSERT IGNORE INTO `exp_network_realm` ( `realm`, `network_realm`,`network_type` ,`wLan_id`, `wLan_name`, `vLan_id`, `create_user`, `create_date`, `last_update`) 
    									VALUES ('$this->icomme_number', '$access_group','gues','$networkid', '$networkname',  '$vlan',  '$this->mno_id', NOW(), NOW())";
								$this->db->execDB($querynew);
							} else {
								$status_code = 0;
							}
						} else {
							foreach ($prop_sub_zones as $valuen) {
								//$wlanname = strtolower($valuen['Name']);
								if ($value3['Name'] == $valuen['Name'] && $value3['Zone-Data']['Nas-Type'] != $valuen['Zone-Data']['Nas-Type']) {
									$zoneid = $valuen['Id'];
									$valuen['Zone-Data']['Nas-Type'] = $this->gateway_type;
									$result = json_decode($aaa->updateZone($zoneid, $valuen), true);

									if ($result['status'] != 'success') {
										$status_code = 0;
									} else {
										$matchEntry = 'Lookup-Key : "' . $value3['Zone-Data']['Location-Id'] . '"<br> Zone Data"Nas-Type" : "' . $this->gateway_type . '", "Location-Id" : "' . $value3['Zone-Data']['Location-Id'] . '"<br> "Redirect_URL" : "' . $value3['Redirect-URL'] . '"';
										$this->db->execDB("UPDATE exp_lookup_entry SET match_entry='$matchEntry'  WHERE realm='$this->icomme_number' AND wlan_name='$valuen[Name]'");
									}
								}
							}
						}
					}
					foreach ($pr_arr as $value3) {
						$value3['Parent-Zone'] = $property_zone_id;
						if (array_search($value3['Name'], array_column($prop_sub_zones, 'Name')) === false) {
							$create_wlan_zone = json_decode($aaa->createZone($value3), true);
							$namen = $value3['Name'];
							$vlan_new = $array_vln[$namen];
							if (strlen($vlan_new) < 1) {
								$vlan_new = $this->p_vlan_start;
							}

							if ($create_wlan_zone['status'] == 'success') {
								$wlan_zone_id = $create_wlan_zone['Description']['Id'];
								$create_lookup_zone = json_decode($aaa->createLookupEntry(array('Id' => $value3['Zone-Data']['Location-Id'], 'Description' => 'Lookup Key for private network', 'Zone-List' => array($wlan_zone_id))), true);
								if ($create_lookup_zone['status'] != 'success') {
									//$status_code = 0;
								}
							} else {
								$status_code = 0;
							}
							$product_new = $value3['Zone-Data']['Free-Access'];
						} else {
							foreach ($prop_sub_zones as $valuen) {
								//$wlanname = strtolower($valuen['Name']);
								if ($value3['Name'] == $valuen['Name'] && $value3['Zone-Data']['Nas-Type'] != $valuen['Zone-Data']['Nas-Type']) {
									$zoneid = $valuen['Id'];
									$valuen['Zone-Data']['Nas-Type'] = $this->pr_gateway_type;
									$result = json_decode($aaa->updateZone($zoneid, $valuen), true);
									if ($result['status'] != 'success') {
										$status_code = 0;
									} else {
										$matchEntry = 'Lookup-Key : "' . $value3['Zone-Data']['Location-Id'] . '"<br> Zone Data"Nas-Type" : "' . $this->pr_gateway_type . '", "Location-Id" : "' . $value3['Zone-Data']['Location-Id'] . '"<br> "Free-Access" : "' . $product_new . '"';
										$this->db->execDB("UPDATE exp_lookup_entry SET match_entry='$matchEntry'  WHERE realm='$this->icomme_number' AND wlan_name='$valuen[Name]'");
									}
								}
							}
						}
					}
					foreach ($mdu_arr as $value3) {
						$value3['Parent-Zone'] = $property_zone_id;
						if (array_search($value3['Name'], array_column($prop_sub_zones, 'Name')) === false) {
							$create_wlan_zone = json_decode($aaa->createZone($value3), true);

							if ($create_wlan_zone['status'] == 'success') {
								$wlan_zone_id = $create_wlan_zone['Description']['Id'];

								$create_lookup_zone = json_decode($aaa->createLookupEntry(array('Id' => $value3['Zone-Data']['Location-Id'], 'Description' => 'Lookup Key for Mdu network', 'Zone-List' => array($wlan_zone_id))), true);
								if ($create_lookup_zone['status'] != 'success') {
									//$status_code = 0;
								}

								$access_group = $value3['Access-Group'];
								$networkname = $value3['Name'];
								$querynew = "INSERT IGNORE INTO `exp_network_realm` ( `realm`, `network_realm`,`network_type` ,`wLan_id`, `wLan_name`, `vLan_id`, `create_user`, `create_date`, `last_update`) 
    									VALUES ('$vt_icomme_number_new', '$access_group','vt','$networkid', '$networkname',  '$vlan',  '$this->mno_id', NOW(), NOW())";
								$this->db->execDB($querynew);
							} else {
								$status_code = 0;
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
									VALUES ('$vt_icomme_number_new', '$access_group','vt','$networkid', '$networkname',  '$vlan',  '$this->mno_id', NOW(), NOW())";
								$this->db->execDB($querynew);

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
										$create_lookup_zonesw = json_decode($aaa->createLookupEntry(array('Id' => $valuesw['Zone-Data']['Location-Id'], 'Description' => $Description, 'Zone-List' => array($wlan_zone_idsw))), true);

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
								if (!empty($value3['dpsk'])) {
									$valuedpsk = $value3['dpsk'];
									$valuedpsk['Parent-Zone'] = $wlan_zone_id;
									$create_wlan_zonedpsk = json_decode($aaa->createZone($valuedpsk), true);
									if ($create_wlan_zonedpsk['status'] == 'success') {
										$wlan_zone_iddpsk = $create_wlan_zonedpsk['Description']['Id'];
										$Description = 'Lookup Key for vTenant->secure network';
										$create_lookup_zonedpsk = json_decode($aaa->createLookupEntry(array('Id' => $valuedpsk['Zone-Data']['Location-Id'], 'Description' => $Description, 'Zone-List' => array($wlan_zone_iddpsk))), true);

										if ($create_lookup_zonedpsk['status'] != 'success') {
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
								$create_lookup_zonesw = json_decode($aaa->createLookupEntry(array('Id' => $valuesw['Zone-Data']['Location-Id'], 'Description' => $Description, 'Zone-List' => array($wlan_zone_idsw))), true);

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
						if (!empty($value3['dpsk']) && (array_search($value3['dpsk']['Name'], array_column($vt_sub_zone, 'Name')) === false)) {
							$valuedpsk = $value3['dpsk'];
							$valuedpsk['Parent-Zone'] = $wlan_zone_id;
							$create_wlan_zonedpsk = json_decode($aaa->createZone($valuedpsk), true);
							if ($create_wlan_zonedpsk['status'] == 'success') {
								$wlan_zone_iddpsk = $create_wlan_zonedpsk['Description']['Id'];
								$Description = 'Lookup Key for vTenant->secure network';
								$create_lookup_zonedpsk = json_decode($aaa->createLookupEntry(array('Id' => $valuedpsk['Zone-Data']['Location-Id'], 'Description' => $Description, 'Zone-List' => array($wlan_zone_iddpsk))), true);

								if ($create_lookup_zonedpsk['status'] != 'success') {
									//$status_code = 0;
								} else {
								}
							}
						}
						
						}
					}
				}
			} elseif (empty($all_zones['Description'])) {
				$status_code = 200;
			} else {
				$status_code = 0;
			}
		} else {
			$status_code = 0;
		}
		$this->icomme_number = $icomme_number;
		return $status_code;
	}

	public function cloudpathapi()
	{
		if ($this->account_edit != '1') {

			$dpsk_distributor_code = $this->distributor;
			$dpsk_mno_id = $this->mno_id;

			$operator = $this->db->getValueAsf("SELECT `mno_description` AS f FROM `exp_mno` WHERE `mno_id` ='$dpsk_mno_id' ");

			$dis_org = sprintf("SELECT `device_limit`, `property_id` FROM `mdu_organizations`  WHERE `property_id`='%s'", $this->vt_icomme);
			$org_data = $this->db->select1DB($dis_org);

			$device_limit = $org_data['device_limit'];
			$dpsk_property_id = $org_data['property_id'];

			$inputarr = $this->inputarr;
			$parent_ac_name = $inputarr['contact']['name'];
			$pool_name = $operator . $parent_ac_name . $dpsk_property_id . "-" . rand(10, 100);

			$internet_ssid = "CloudPath";
			$ssid_list = array();
			array_push($ssid_list, $internet_ssid);
			$ssid_list_json = json_encode($ssid_list);

			$data_fr = array();
			$data_fr['controller_name'] = $this->dpsk_conroller;
			$dpsks_factory = new dpsks_factory($data_fr);

			$token_ar = $dpsks_factory->create_token();
			$token_re = json_decode($token_ar, true);
			$token_data = json_decode($token_re['Description'], true);

			$data = array();
			$data['token'] = $token_data['token'];

			$data['device_count'] = $device_limit;
			$data['policies'] = $this->dpsk_policies;


			$data['displayName'] = $pool_name;
			$data['description'] = $pool_name;



			$data['ssidList'] = $ssid_list;
			$pdsk_pool_res = $dpsks_factory->create_dpsks_pool($data);
			$pdsk_pool_res_data = json_decode($pdsk_pool_res, true);
			$pdsk_pool_data = json_decode($pdsk_pool_res_data['Description'], true);
			$dpsk_pool_id = $pdsk_pool_data['guid'];


			$data['dpskspool_id'] = $dpsk_pool_id;

			$pdsk_policy_res = $dpsks_factory->assign_policy($data);
			$pdsk_policy_res_data = json_decode($pdsk_policy_res, true);
			$pdsk_policy_data = json_decode($pdsk_policy_res_data['Description'], true);


			if ($pdsk_pool_res_data['status_code'] == '200') {
				$query_dpsk_pool = "INSERT INTO `mdu_dpsk_pool` (`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`) 
    VALUES ('$dpsk_pool_id', '$pool_name', '$pool_name', '$ssid_list_json', '$device_limit', '$dpsk_distributor_code', '$dpsk_property_id', '$this->dpsk_policies',NOW(), 'syncAp', NOW())";

				$this->db->execDB($query_dpsk_pool);
			}
			return $pdsk_pool_res_data['status_code'];
		} else {
			$inputarr = $this->inputarr;
			$parent_code = $inputarr['locations']['id'];
			$parent_ac_name = $inputarr['contact']['name'];
			if ($this->dpsklayout) {

				$get_poolid = "SELECT `distributor_code`,`mno_id`  FROM `exp_mno_distributor`  WHERE `parent_id` = '$parent_code'";

				$get_poolid_data = $this->db->selectDB($get_poolid);

				$dpsk_property_ar = array();

				foreach ($get_poolid_data['data'] as $pool_data) {
					$dpsk_distributor_code = $pool_data['distributor_code'];
					$dpsk_mno_id = $pool_data['mno_id'];

					$operator = $this->db->getValueAsf("SELECT `mno_description` AS f FROM `exp_mno` WHERE `mno_id` ='$dpsk_mno_id' ");

					$dis_org = sprintf("SELECT o.`device_limit`, o.`property_id` FROM `mdu_organizations` o JOIN `mdu_distributor_organizations` d ON o.`property_id` = d.`property_id` WHERE `distributor_code`='%s'", $dpsk_distributor_code);
					$org_data = $this->db->select1DB($dis_org);

					$device_limit = $org_data['device_limit'];
					$dpsk_property_id = $org_data['property_id'];


					$pool_name = $operator . $parent_ac_name . $dpsk_property_id . "-" . rand(10, 100);

					$internet_ssid = "CloudPath";
					$ssid_list = array();


					$data_fr = array();
					$data_fr['controller_name'] = $this->dpsk_conroller;
					$dpsks_factory = new dpsks_factory($data_fr);

					$token_ar = $dpsks_factory->create_token();
					$token_re = json_decode($token_ar, true);
					$token_data = json_decode($token_re['Description'], true);

					$data = array();
					$data['token'] = $token_data['token'];

					$data['device_count'] = $device_limit;
					$data['policies'] = $this->dpsk_policies;


					$data['displayName'] = $pool_name;
					$data['description'] = $pool_name;

					$qu_vo = "SELECT `displayName`,`description`,`dpsk_pool_id`,`assign_policy`,`ssidList` FROM `mdu_dpsk_pool` WHERE `distributor` = '$dpsk_distributor_code'";

					if ($this->db->getNumRows($qu_vo) > 0) {
						$dpsk_pool_re = $this->db->select1DB($qu_vo);
						$dpsk_pool_id = $dpsk_pool_re['dpsk_pool_id'];

						$dpsk_old_displayName = $dpsk_pool_re['displayName'];

						$dpsk_displayName_ar = explode('-',$dpsk_old_displayName);
						$dpsk_displayName_endVal = end($dpsk_displayName_ar);
						$pool_name = $operator . $parent_ac_name . $dpsk_property_id . "-" . $dpsk_displayName_endVal;
						$data['displayName'] = $pool_name;
						$data['description'] = $pool_name;

						$query_results_ss = $this->db->selectDB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code'");
						$query_resident =   $this->db->select1DB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code' AND `wlan_name` LIKE '%resident%' ORDER BY `wlan_name` ASC LIMIT 1");
						$resident_ssid = $query_resident['ssid'];
					
						$query_vtenant =    $this->db->select1DB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code' AND `wlan_name` LIKE '%vtenant%' ORDER BY `wlan_name` ASC LIMIT 1");
						$vtenant_ssid = $query_vtenant['ssid'];

						
						$tenant_ssid = "";

						foreach ($query_results_ss['data'] as $row_s) {
							$ssid = $row_s['ssid'];
							$wlan_name = $row_s['wlan_name'];
							$networkNameLower = trim(strtolower($wlan_name));

							// if (substr($networkNameLower, 0, strlen("resident")) === "resident") {
							// 	$internet_ssid = $row_s['ssid'];
							// 	array_push($ssid_list, $internet_ssid);
							// }
							

							if (substr($networkNameLower, 0, strlen("tenant")) === "tenant") {
								$tenant_ssid = $row_s['ssid'];
							}
						}

						$internet_ssid = $resident_ssid;

						if (empty($internet_ssid)) {
							$internet_ssid = $vtenant_ssid;
						}

						if (empty($internet_ssid)) {
							$internet_ssid = $tenant_ssid;
						}

						if (!empty($internet_ssid)) {
							array_push($ssid_list, $internet_ssid);
						}

						if (empty($ssid_list)) {
							array_push($ssid_list, "CloudPath");
						}

						$ssid_list_json = json_encode($ssid_list);

						$data['ssidList'] = $ssid_list;
						$data['dpskspool_id'] = $dpsk_pool_id;


						$pdsk_pool_res = $dpsks_factory->update_dpsks_pool($data);
						$pdsk_pool_res_data = json_decode($pdsk_pool_res, true);
						$pdsk_pool_data = json_decode($pdsk_pool_res_data['Description'], true);
						//$dpsk_pool_id=$pdsk_pool_data['guid'];

						if ($pdsk_pool_res_data['status_code'] == '200') {
							$query_dpsk_pool_up = "UPDATE `mdu_dpsk_pool` SET `displayName` = '$pool_name' , `description` = '$pool_name' , `ssidList` = '$ssid_list_json' , `device_count` = '$device_limit' , `property_id` = '$dpsk_property_id' WHERE  `distributor` = '$dpsk_distributor_code' ";
							$this->db->execDB($query_dpsk_pool_up);
						  }

						//check curren dpsk pool
						$get_dpskpool_policy_res = $dpsks_factory->get_dpskpool_policies($data);
						$get_dpskpool_policy_res_data = json_decode($get_dpskpool_policy_res, true);
						$get_dpskpool_policy_data = json_decode($get_dpskpool_policy_res_data['Description'], true);

						foreach ($get_dpskpool_policy_data['contents'] as $content) {
							foreach ($content['links'] as $links) {
								if ($links['rel'] == 'policy' || $links['rel'] == 'policies') {
									$policie_url = $links['href'];
									$policie_url_ex = explode("/", $policie_url);
									$current_police_id = end($policie_url_ex);
									//print_r($policie_url_ex);
								}
							}
						}


						if (($this->dpsk_policies != $current_police_id) || empty($current_police_id)) {
							$data_delete = array();
							$data_delete['token'] = $token_data['token'];
							$data_delete['dpskspool_id'] = $dpsk_pool_id;
							$data_delete['policies'] = $current_police_id;

							if (!empty($current_police_id)) {
								$dpsk_policy_del = $dpsks_factory->Delete_dpskspool_policies($data_delete);
								$dpsk_policy_del_data = json_decode($dpsk_policy_del, true);
								$pdsk_policy_del_data = json_decode($dpsk_policy_del_data['Description'], true);
								$police_del_sts = $dpsk_policy_del_data['status_code'];
							}

							if ($police_del_sts == '200' || empty($current_police_id)) {
								$pdsk_policy_res = $dpsks_factory->assign_policy($data);
								$pdsk_policy_res_data = json_decode($pdsk_policy_res, true);
								$pdsk_policy_data = json_decode($pdsk_policy_res_data['Description'], true);






								if ($pdsk_policy_res_data['status_code'] == '200') {
									$query_dpsk_pool = "UPDATE `mdu_dpsk_pool` SET `assign_policy` = '$this->dpsk_policies' WHERE  `distributor` = '$dpsk_distributor_code' ";
									$this->db->execDB($query_dpsk_pool);
								}
							}
						}
					} else {

						$query_results_ss = $this->db->selectDB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code'");
						$query_resident =   $this->db->select1DB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code' AND `wlan_name` LIKE '%resident%' ORDER BY `wlan_name` ASC LIMIT 1");
						$resident_ssid = $query_resident['ssid'];
					
						$query_vtenant =    $this->db->select1DB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code' AND `wlan_name` LIKE '%vtenant%' ORDER BY `wlan_name` ASC LIMIT 1");
						$vtenant_ssid = $query_vtenant['ssid'];
						
						$tenant_ssid = "";

						foreach ($query_results_ss['data'] as $row_s) {
							$ssid = $row_s['ssid'];
							$wlan_name = $row_s['wlan_name'];
							$networkNameLower = trim(strtolower($wlan_name));

							// if(substr($networkNameLower, 0, strlen("vtenant")) === "vtenant"  || substr($networkNameLower, 0, strlen("resident")) === "resident" || substr($networkNameLower, 0, strlen("tenant")) === "tenant"){
							//     $internet_ssid = $row_s['ssid'];
							//     array_push($ssid_list, $internet_ssid);
							//                }


							if (substr($networkNameLower, 0, strlen("tenant")) === "tenant") {
								$tenant_ssid = $row_s['ssid'];
							}
						}

						$internet_ssid = $resident_ssid;

						if (empty($internet_ssid)) {
							$internet_ssid = $vtenant_ssid;
						}

						if (empty($internet_ssid)) {
							$internet_ssid = $tenant_ssid;
						}

						if (!empty($internet_ssid)) {
							array_push($ssid_list, $internet_ssid);
						}

						if (empty($ssid_list)) {
							array_push($ssid_list, "CloudPath");
						}

						$ssid_list_json = json_encode($ssid_list);

						$data['ssidList'] = $ssid_list;
						$pdsk_pool_res = $dpsks_factory->create_dpsks_pool($data);
						$pdsk_pool_res_data = json_decode($pdsk_pool_res, true);
						$pdsk_pool_data = json_decode($pdsk_pool_res_data['Description'], true);
						$dpsk_pool_id = $pdsk_pool_data['guid'];


						$data['dpskspool_id'] = $dpsk_pool_id;

						$pdsk_policy_res = $dpsks_factory->assign_policy($data);
						$pdsk_policy_res_data = json_decode($pdsk_policy_res, true);
						$pdsk_policy_data = json_decode($pdsk_policy_res_data['Description'], true);


						if ($pdsk_pool_res_data['status_code'] == '200') {
							$query_dpsk_pool = "INSERT INTO `mdu_dpsk_pool` (`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`) 
        VALUES ('$dpsk_pool_id', '$pool_name', '$pool_name', '$ssid_list_json', '$device_limit', '$dpsk_distributor_code', '$dpsk_property_id', '$this->dpsk_policies',NOW(), 'syncAp', NOW())";

							$this->db->execDB($query_dpsk_pool);

							if (!empty($dpsk_property_id)) {
								array_push($dpsk_property_ar, $dpsk_property_id);
							}
						}
					}
				}

				return 200;
				//dpskpool add
			} else {
				$query_code_mno = $this->db->getValueAsf("SELECT  d.mno_id as f
                        FROM admin_users u, mno_distributor_parent d
                        WHERE d.parent_id = '$parent_code' AND u.`verification_number`='$parent_code'");

				$get_poolid = "SELECT `distributor_code`,`dpsk_pool_id`, p.`id` AS mdu_pool_id  FROM `exp_mno_distributor` m JOIN `mdu_dpsk_pool` p ON m.`distributor_code`=p.`distributor` WHERE `parent_id` = '$parent_code'";

				$get_poolid_data = $this->db->selectDB($get_poolid);

				foreach ($get_poolid_data['data'] as $pool_data) {
					$dpsk_distributor_code = $pool_data['distributor_code'];
					$dpsk_pool_id = $pool_data['dpsk_pool_id'];
					$mdu_dpsk_pool_id = $pool_data['mdu_pool_id'];


					if (!empty($dpsk_pool_id)) {

						$data_fr = array();
						$data_fr['user_distributor'] = $dpsk_distributor_code;
						$dpsks_factory = new dpsks_factory($data_fr);


						$token_ar = $dpsks_factory->create_token();

						$token_re = json_decode($token_ar, true);
						$token_data = json_decode($token_re['Description'], true);



						$data = array();
						$data['token'] = $token_data['token'];
						$data['dpskspool_id'] = $dpsk_pool_id;

						$pdsk_pool_res = $dpsks_factory->Delete_dpsk_pool($data);
						$pdsk_pool_res_data = json_decode($pdsk_pool_res, true);
						$pdsk_pool_data = json_decode($pdsk_pool_res_data['Description'], true);

						$dpsk_up_status = $pdsk_pool_res_data['status_code'];

						if ($dpsk_up_status == 200 || $dpsk_up_status == 204) {
							$pool_ar = "INSERT INTO `mdu_dpsk_pool_archive` 
                        (`mdu_dpsk_pool_id`,`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`,`delete_by`,`delete_date`)
                        SELECT `id`,`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`,'Admin',NOW()
                        FROM `mdu_dpsk_pool` WHERE `id`='$mdu_dpsk_pool_id'";

							$pool_delete_q = "DELETE FROM `mdu_dpsk_pool` WHERE `id`='$mdu_dpsk_pool_id'";
							//  echo '<br>';
							$this->db->execDB($pool_ar);
							$this->db->execDB($pool_delete_q);
						}
					}
				}
				return 200;
				$this->dpsk_conroller = "";
				$this->dpsk_policies = "";
			}
		}
	}

	public function ruckusmanual()
	{
		$profile = $this->db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$this->ap_controller'");
		if ($this->DNS_profile_control == 'on') {
			$dns_profile_enable = '1';
		} else {
			// $DNS_profile ="";
			$dns_profile_enable = '0';
		}
		$wag_enable = $this->wag_enable;
		if ($this->account_edit == '1') {
			if ($this->wag_ap_name == 'NO_PROFILE') {
				//API not call//
				$status_code = '200';
			} else {
				$api_details = $this->package_functions->callApi('ACC_CREATE_API', $this->system_package, 'YES');
				//print_r($api_details);
				if ($api_details['access_method'] == '1') { // 'YES' returns option column data


					//echo $profile;
					if ($this->provision == 1) {
						require_once '../../src/AP/' . $profile . '/index.php';
					}else{
						require_once 'src/AP/' . $profile . '/index.php';
					}

					$wag_obj = new ap_wag($this->ap_controller);
					$wag_obj->setRealm($this->icomme_number);
					$zon_details = $wag_obj->retrieveZonedata($this->zoneid);
					parse_str($zon_details, $zon_detailsArr);
					$status_code = $zon_detailsArr['status_code'];
					if ($status_code == '200') {


						$ofset_ar = explode(':', $this->offset_val);

						$Description = (array)json_decode(urldecode($zon_detailsArr['Description']));
						$time_zone = (array)$Description[timezone];


						if (array_key_exists('advanced_features', $this->field_array) && !empty($this->advanced_features_arr)) {


							$retrieveNetworkList = $wag_obj->retrieveNetworkList($this->zoneid);

							parse_str($retrieveNetworkList, $retrieveNetworkListArr);

							//print_r($Description);

							$result = urldecode($retrieveNetworkListArr['Description']);

							$result = (array)json_decode($result);

							$result = (array)$result['list'];

							if (count($result) > 0) {
								foreach ($result as $key => $value) {
									$value = (array)$value;
									$id = $value['id'];

									$modifyavcEnabled = $wag_obj->modifyavcEnabled($this->zoneid, $id, $this->avcEnabled);
								}
							}
						}


						if ($time_zone['systemTimezone'] == NULL) {
							$cuzt_time_zone = (array)$time_zone['customizedTimezone'];

							if ((int)$cuzt_time_zone[gmtOffset] != (int)$ofset_ar[0] || (int)$cuzt_time_zone[gmtOffsetMinute] != (int)$ofset_ar[1]) {

								$time_Zone_update = $wag_obj->modifyZoneTimeZone($this->zoneid, $this->timezone_abbreviation, (int)$ofset_ar[0], (int)$ofset_ar[1], $this->mvnx_time_zone);
								parse_str($time_Zone_update, $time_Zone_updateArr);
								$status_code = $time_Zone_updateArr['status_code'];
								if ($status_code == '200') {
									$status_code2 = '200';
								}
							} else {
								$status_code2 = '200';
							}
						} else {

							if ($time_zone['systemTimezone'] != $this->mvnx_time_zone) {

								$time_Zone_update = $wag_obj->modifyZoneTimeZone($this->zoneid, $this->timezone_abbreviation, (int)$ofset_ar[0], (int)$ofset_ar[1], $this->mvnx_time_zone);

								parse_str($time_Zone_update, $time_Zone_updateArr);

								$status_code = $time_Zone_updateArr['status_code'];
								if ($status_code == '200') {
									$status_code2 = '200';
								}
							} else {
								$status_code2 = '200';
							}
						}
					}


					if ($wag_enable == "on") {

						$wag_enable = 1;
					} else {

						$wag_enable = 0;
					}

					if ($this->gateway_type == 'wag' || $this->pr_gateway_type == 'wag') {

						if ($wag_enable == 1) {

							$q = "SELECT `filt_gre_profile`,g.`profile_name` FROM `exp_wag_profile` w JOIN exp_gre_profiles g ON w.`filt_gre_profile`=g.`profile_id` WHERE `wag_code`='" . $this->wag_name . "' LIMIT 1";
							$wag_details = $this->db->select1DB($q);
							$gre_profile_id = $wag_details['filt_gre_profile'];
							$gre_profile_name = $wag_details['profile_name'];
							$wag_enable = '1';
						} else {
							$q = "SELECT `reg_gre_profile`,g.`profile_name` FROM `exp_wag_profile` w JOIN exp_gre_profiles g ON w.`reg_gre_profile`=g.`profile_id` WHERE `wag_code`='" . $this->wag_name . "' LIMIT 1";
							$wag_details = $this->db->select1DB($q);
							$gre_profile_id = $wag_details['reg_gre_profile'];
							$gre_profile_name = $wag_details['profile_name'];
							$wag_enable = '0';
						}
						if (!empty($this->wag_name)) {
							$modufy_tunnel = $wag_obj->modifyTunnelProfile($this->zoneid, $gre_profile_id, $gre_profile_name);
							parse_str($modufy_tunnel, $respo_wag);
							if ($respo_wag['status_code'] == '200') {
								$status_code_dns = '200';
							}
						} else {
							$status_code_dns = '200';
						}
					} elseif ($this->network_type != 'VT' && $this->gateway_type != 'AC' && strlen($this->DNS_profile) > 0) {

						if ($dns_profile_enable == '1') {

							$get_dns_prof_deta_q = "SELECT cd.`content_filter_profile`,d.name,cd.regular_profile FROM `exp_controller_dns` cd join exp_dns_profile d ON cd.content_filter_profile=d.unique_id WHERE `profile_code`='$this->DNS_profile'";

							$get_dns_prof_deta_r = $this->db->select1DB($get_dns_prof_deta_q);
							//$get_dns_prof_deta = mysql_fetch_array($get_dns_prof_deta_r);
							$dns_profile_id = $get_dns_prof_deta_r['content_filter_profile'];
							$regular_profile = $get_dns_prof_deta_r['regular_profile'];
							$dns_profile_name = $get_dns_prof_deta_r['name'];

							$result = $wag_obj->retrieveDNSServerProfile();

							parse_str($result, $resultArr);

							$result = urldecode($resultArr['Description']);

							$result = (array)json_decode($result);

							$result = (array)$result['list'];

							if (count($result) > 0) {
								foreach ($result as $key => $value) {
									$value = (array)$value;
									$id = $value['id'];

									if ($id == $dns_profile_id) {

										$secondaryIp = $value['secondaryIp'];
										$primaryIp = $value['primaryIp'];
									}
								}

								$result_dhcp = $wag_obj->getZoneDHCPProfile($this->zoneid);

								parse_str($result_dhcp, $wag_respo_arr);

								$data = json_decode($wag_respo_arr['Description'], true);

								if (count($data['list']) > 0) {

									$dhcp_is = 0;

									foreach ($data['list'] as $value) {

										$vlanId = $value['vlanId'];

										if ($vlanId == '100') {
											$dhcp_id = $value['id'];
											$dhcp_arr = $value;
											$dhcp_is = 1;
											break;
										}
									}

									if ($dhcp_is == 1) {

										$dhcp_arr['primaryDnsIp'] = $primaryIp;
										$dhcp_arr['secondaryDnsIp'] = $secondaryIp;

										unset($dhcp_arr['zoneId']);
										unset($dhcp_arr['id']);

										$result_dhcp1 = $wag_obj->modifyDhcpProfile($this->zoneid, $dhcp_id, $dhcp_arr);

										parse_str($result_dhcp1, $wag_respo_arr2);

										if ($wag_respo_arr2['status_code'] == '200') {
											/* mysql_query("UPDATE exp_mno_distributor SET dns_profile_enable='1' WHERE distributor_code='$user_distributor'");
	                             $_SESSION['tab1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_success','2009')."</strong></div>";*/

											$status_code_dns = '200';
										} else {
											/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_fail','2009')."</strong></div>";*/

											$status_code_dns = '0';
										}
									} else {

										/* $_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/

										$status_code_dns = '0';
									}
								} else {

									$status_code_dns = '0';

									/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
								}
							} else {

								/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dns','2009')."</strong></div>";*/

								$status_code_dns = '0';
							}
						} else {


							$get_dns_prof_deta_q = "SELECT cd.`content_filter_profile`,d.name,cd.regular_profile FROM `exp_controller_dns` cd join exp_dns_profile d ON cd.content_filter_profile=d.unique_id WHERE `profile_code`='$this->DNS_profile'";

							$get_dns_prof_deta_r = $this->db->select1DB($get_dns_prof_deta_q);
							//$get_dns_prof_deta = mysql_fetch_array($get_dns_prof_deta_r);
							$dns_profile_id = $get_dns_prof_deta_r['content_filter_profile'];
							$regular_profile = $get_dns_prof_deta_r['regular_profile'];
							$dns_profile_name = $get_dns_prof_deta_r['name'];

							$result = $wag_obj->retrieveDNSServerProfile();

							parse_str($result, $resultArr);

							$result = urldecode($resultArr['Description']);
							$result = (array)json_decode($result);
							$result = (array)$result['list'];

							if (count($result) > 0) {
								foreach ($result as $key => $value) {
									$value = (array)$value;
									$id = $value['id'];

									if ($id == $regular_profile) {

										$secondaryIp = $value['secondaryIp'];
										$primaryIp = $value['primaryIp'];
									}
								}

								$result_dhcp = $wag_obj->getZoneDHCPProfile($this->zoneid);
								parse_str($result_dhcp, $wag_respo_arr);
								$data = json_decode($wag_respo_arr['Description'], true);

								if (count($data['list']) > 0) {

									$dhcp_is = 0;

									foreach ($data['list'] as $value) {

										$vlanId = $value['vlanId'];

										if ($vlanId == '100') {
											$dhcp_id = $value['id'];
											$dhcp_arr = $value;
											$dhcp_is = 1;
											break;
										}
									}

									if ($dhcp_is == 1) {

										$dhcp_arr['primaryDnsIp'] = $primaryIp;
										$dhcp_arr['secondaryDnsIp'] = $secondaryIp;

										unset($dhcp_arr['zoneId']);
										unset($dhcp_arr['id']);

										$result_dhcp1 = $wag_obj->modifyDhcpProfile($this->zoneid, $dhcp_id, $dhcp_arr);
										parse_str($result_dhcp1, $wag_respo_arr2);

										if ($wag_respo_arr2['status_code'] == '200') {
											/*$update_q = "UPDATE exp_mno_distributor SET dns_profile_enable='0' WHERE distributor_code='$user_distributor'";
	                            mysql_query($update_q);
	                            $_SESSION['tab1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_success','2009')."</strong></div>";*/
											$status_code_dns = '200';
										} else {
											/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_fail','2009')."</strong></div>";*/
											$status_code_dns = '0';
										}
									} else {

										/* $_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
										$status_code_dns = '0';
									}
								} else {

									/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
									$status_code_dns = '0';
								}
							} else {

								/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dns','2009')."</strong></div>";*/
								$status_code_dns = '0';
							}
						}
					} else {

						$status_code_dns = '200';
					}

					//$zon_details=$wag_obj->retrieveZonedata($zoneid);

					//if multi area removed
					if ($this->multi_area == '0') {
						$ap_groups = $wag_obj->getAPGroups($this->zoneid);
						$wlan_groups = $wag_obj->getWLanGroups($this->zoneid);

						//get default wLan group id
						//						foreach ($wlan_groups['data'] as $wlan_group){
						//							if($wlan_group['name']=='default'){
						//								$default_wgroup_id = $wlan_group['id'];
						//								break;
						//							}
						//						}
						foreach ($wlan_groups['data']['list'] as $list_item) {
							if ($list_item['name'] == 'default') {
								$default_wlan_g = $list_item['id'];
							}
						}

						if ($ap_groups['status']) {

							//							foreach ($ap_groups['data'] as $datum) {
							//								if ($datum['name'] != 'default') {
							//									$default_group_id = $datum['id'];
							//									break;
							//								}
							//							}

							foreach ($ap_groups['data'] as $datum) {
								if ($datum['name'] == 'default')
									continue;

								$wag_obj->modifyWLanGroup($this->zoneid, $datum['id'], $default_wlan_g, 'default');

								$ap_group = $wag_obj->getAPGroup($this->zoneid, $datum['id']);
								if (!$ap_group['status'])
									continue;

								$aps = [];
								foreach ($ap_group['data']['members'] as $ap) {
									$aps[] = $ap['apMac'];
								}

								$wag_obj->deleteAPGroup($this->zoneid, $datum['id'], $aps);
							}
						}

						foreach ($wlan_groups['data']['list'] as $wlan_group) {
							if ($wlan_group['name'] == 'default') {
								continue;
							}
							$wag_obj->removeWLanGroups($this->zoneid, $wlan_group['id']);
						}
					}

					if ($status_code_dns == '200' && $status_code2 == '200') {
						$status_code = '200';
					} else {
						$status_code = '0';
					}

					//$wag_obj->retrieveZonedata($zoneid);
				} else {

					$status_code = "200";
				}
			}
		} else {

			if ($this->wag_ap_name == 'NO_PROFILE') {
				//API not call//
				$status_code = '200';
			} else {


				$api_details = $this->package_functions->callApi('ACC_CREATE_API', $this->system_package, 'YES');
				//print_r($api_details);
				if ($api_details['access_method'] == '1') { // 'YES' returns option column data

					$profile = $this->db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$this->ap_controller'");
					if ($profile == '') {
						$profile = $this->db->setVal('wag_ap_name', 'ADMIN');
						if ($profile == '') {
							$profile = "non";
						}
					}


					//echo $profile;
					if ($this->provision == 1) {
						require_once '../../src/AP/' . $profile . '/index.php';
					}else{
						require_once 'src/AP/' . $profile . '/index.php';
					}

					$wag_obj = new ap_wag($this->ap_controller);
					$wag_obj->setRealm($this->icomme_number);
					$status_code = '0';

					$zon_details = $wag_obj->retrieveZonedata($this->zoneid);
					parse_str($zon_details, $zone_details_ar);



					if ($this->gateway_type == 'wag' || $this->pr_gateway_type == 'wag') {


						if ($wag_enable == "on") {
							$q = "SELECT `filt_gre_profile`,g.`profile_name` FROM `exp_wag_profile` w JOIN exp_gre_profiles g ON w.`filt_gre_profile`=g.`profile_id` WHERE `wag_code`='" . $this->wag_name . "' LIMIT 1";
							$wag_details = $this->db->select1DB($q);
							$gre_profile_id = $wag_details['filt_gre_profile'];
							$gre_profile_name = $wag_details['profile_name'];
							$wag_enable = '1';
						} else {
							$q = "SELECT `reg_gre_profile`,g.`profile_name` FROM `exp_wag_profile` w JOIN exp_gre_profiles g ON w.`reg_gre_profile`=g.`profile_id` WHERE `wag_code`='" . $this->wag_name . "' LIMIT 1";
							$wag_details = $this->db->select1DB($q);
							$gre_profile_id = $wag_details['reg_gre_profile'];
							$gre_profile_name = $wag_details['profile_name'];
							$wag_enable = '0';
						}


						//$modi_zone = $wag_obj->modifyzone($zoneid, $tunnel, $gre_profile_id, $gre_profile_name);
						//parse_str($modi_zone,$modi_zone_res_ar);
						//$modi_zone_res_ar['status_code']='200';

					}


					if ($zone_details_ar['status_code'] == '200') {

						$ofset_ar = explode(':', $offset_val);

						$time_Zone_update = $wag_obj->modifyZoneTimeZone($this->zoneid, $this->timezone_abbreviation, (int)$ofset_ar[0], (int)$ofset_ar[1], $this->mvnx_time_zone);
						parse_str($time_Zone_update, $time_Zone_update_resp);


						if (array_key_exists('advanced_features', $this->field_array) && !empty($this->advanced_features_arr)) {


							$retrieveNetworkList = $wag_obj->retrieveNetworkList($this->zoneid);

							parse_str($retrieveNetworkList, $retrieveNetworkListArr);

							//print_r($Description);

							$result = urldecode($retrieveNetworkListArr['Description']);

							$result = (array)json_decode($result);

							$result = (array)$result['list'];

							if (count($result) > 0) {
								foreach ($result as $key => $value) {
									$value = (array)$value;
									$id = $value['id'];

									$modifyavcEnabled = $wag_obj->modifyavcEnabled($this->zoneid, $id, $this->avcEnabled);

									/*print_r($modifyavcEnabled);
			        echo "<br>";*/
								}
							}
						}
					} else {
						$time_Zone_update_resp['status_code'] = '0';
					}

					if ($wag_enable == "on") {

						$wag_enable = 1;
					} else {

						$wag_enable = 0;
					}

					if ($this->gateway_type == 'wag' || $this->pr_gateway_type == 'wag') {
						//echo $this->wag_name.'***'; exit();
						if (!empty($this->wag_name)) {
							//if ($wag_enable == "1") {
							$modufy_tunnel = $wag_obj->modifyTunnelProfile($this->zoneid, $gre_profile_id, $gre_profile_name);
							parse_str($modufy_tunnel, $modufy_tunnel_resp);

							if ($modufy_tunnel_resp['status_code'] == '200') {
								$status_code = '200';
							} else {
								$status_code = '0';
							}

							/*} else {
			    $status_code = '200';
			}*/
						} else {
							$status_code = '200';
						}
					} elseif ($this->network_type != 'VT' && $gateway_type != 'AC' && strlen($this->DNS_profile) > 0) {
						if ($dns_profile_enable == '1') {

							$get_dns_prof_deta_q = "SELECT cd.`content_filter_profile`,d.name,cd.regular_profile FROM `exp_controller_dns` cd join exp_dns_profile d ON cd.content_filter_profile=d.unique_id WHERE `profile_code`='$this->DNS_profile'";

							$get_dns_prof_deta = $this->db->select1DB($get_dns_prof_deta_q);
							//$get_dns_prof_deta = mysql_fetch_array($get_dns_prof_deta_r);
							$dns_profile_id = $get_dns_prof_deta['content_filter_profile'];
							$regular_profile = $get_dns_prof_deta['regular_profile'];
							$dns_profile_name = $get_dns_prof_deta['name'];

							$result = $wag_obj->retrieveDNSServerProfile();

							parse_str($result, $resultArr);

							$result = urldecode($resultArr['Description']);

							$result = (array)json_decode($result);

							$result = (array)$result['list'];

							if (count($result) > 0) {
								foreach ($result as $key => $value) {
									$value = (array)$value;
									$id = $value['id'];

									if ($id == $dns_profile_id) {

										$secondaryIp = $value['secondaryIp'];
										$primaryIp = $value['primaryIp'];
									}
								}

								$result_dhcp = $wag_obj->getZoneDHCPProfile($this->zoneid);

								parse_str($result_dhcp, $wag_respo_arr);

								$data = json_decode($wag_respo_arr['Description'], true);

								if (count($data['list']) > 0) {

									$dhcp_is = 0;

									foreach ($data['list'] as $value) {

										$vlanId = $value['vlanId'];

										if ($vlanId == '100') {
											$dhcp_id = $value['id'];
											$dhcp_arr = $value;
											$dhcp_is = 1;
											break;
										}
									}

									if ($dhcp_is == 1) {

										$dhcp_arr['primaryDnsIp'] = $primaryIp;
										$dhcp_arr['secondaryDnsIp'] = $secondaryIp;

										unset($dhcp_arr['zoneId']);
										unset($dhcp_arr['id']);

										$result_dhcp1 = $wag_obj->modifyDhcpProfile($this->zoneid, $dhcp_id, $dhcp_arr);

										parse_str($result_dhcp1, $wag_respo_arr2);

										if ($wag_respo_arr2['status_code'] == '200') {
											/* mysql_query("UPDATE exp_mno_distributor SET dns_profile_enable='1' WHERE distributor_code='$user_distributor'");
			                 $_SESSION['tab1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_success','2009')."</strong></div>";*/

											$status_code = '200';
										} else {
											/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_enable_fail','2009')."</strong></div>";*/

											$status_code = '0';
										}
									} else {

										/* $_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/

										$status_code = '0';
									}
								} else {

									$status_code = '0';

									/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
								}
							} else {

								/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dns','2009')."</strong></div>";*/

								$status_code = '0';
							}
						} else {

							$get_dns_prof_deta_q = "SELECT cd.`content_filter_profile`,d.name,cd.regular_profile FROM `exp_controller_dns` cd join exp_dns_profile d ON cd.content_filter_profile=d.unique_id WHERE `profile_code`='$this->DNS_profile'";

							$get_dns_prof_deta_r = $this->db->select1DB($get_dns_prof_deta_q);
							//$get_dns_prof_deta = mysql_fetch_array($get_dns_prof_deta_r);
							$dns_profile_id = $get_dns_prof_deta_r['content_filter_profile'];
							$regular_profile = $get_dns_prof_deta_r['regular_profile'];
							$dns_profile_name = $get_dns_prof_deta_r['name'];

							$result = $wag_obj->retrieveDNSServerProfile();

							parse_str($result, $resultArr);

							$result = urldecode($resultArr['Description']);
							$result = (array)json_decode($result);
							$result = (array)$result['list'];

							if (count($result) > 0) {
								foreach ($result as $key => $value) {
									$value = (array)$value;
									$id = $value['id'];

									if ($id == $regular_profile) {

										$secondaryIp = $value['secondaryIp'];
										$primaryIp = $value['primaryIp'];
									}
								}

								$result_dhcp = $wag_obj->getZoneDHCPProfile($this->zoneid);
								parse_str($result_dhcp, $wag_respo_arr);
								$data = json_decode($wag_respo_arr['Description'], true);

								if (count($data['list']) > 0) {

									$dhcp_is = 0;

									foreach ($data['list'] as $value) {

										$vlanId = $value['vlanId'];

										if ($vlanId == '100') {
											$dhcp_id = $value['id'];
											$dhcp_arr = $value;
											$dhcp_is = 1;
											break;
										}
									}

									if ($dhcp_is == 1) {

										$dhcp_arr['primaryDnsIp'] = $primaryIp;
										$dhcp_arr['secondaryDnsIp'] = $secondaryIp;

										unset($dhcp_arr['zoneId']);
										unset($dhcp_arr['id']);

										$result_dhcp1 = $wag_obj->modifyDhcpProfile($this->zoneid, $dhcp_id, $dhcp_arr);
										parse_str($result_dhcp1, $wag_respo_arr2);

										if ($wag_respo_arr2['status_code'] == '200') {
											/*$update_q = "UPDATE exp_mno_distributor SET dns_profile_enable='0' WHERE distributor_code='$user_distributor'";
			                mysql_query($update_q);
			                $_SESSION['tab1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_success','2009')."</strong></div>";*/
											$status_code = '200';
										} else {
											/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_disable_fail','2009')."</strong></div>";*/
											$status_code = '0';
										}
									} else {

										/* $_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
										$status_code = '0';
									}
								} else {

									/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dhcp','2009')."</strong></div>";*/
									$status_code = '0';
								}
							} else {

								/*$_SESSION['tab1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('content_filter_no_dns','2009')."</strong></div>";*/
								$status_code = '0';
							}
						}
					} else {

						$status_code = '200';
					}
					//$status_code='0';


					if ($status_code == '200' && $time_Zone_update_resp['status_code'] == '200') {
						$status_code = "200";
					} else {
						$status_code = "0";
					}


					//////////////////////////////////////////
					//$private_password=randomPasswordlength(8);

					//$wag_obj->retrieveZonedata($zoneid);

				} else {
					$status_code = "200";
				}

				//$status_code = "200";


			}
		}

		//return $status_code;
		return array(
			'status_code' => $status_code,
			'zoneid' => $this->zoneid
		);
	}

	public function ruckusautomation()
	{
		
		$inputarr = $this->inputarr;
		$status_code = 200;
		if ($this->provision == 1) {
			require_once '../../src/API/functions.php';
		}else{
			require_once 'src/API/functions.php';
		}
		$value = $inputarr['locations'];
		$parent_pref = strtoupper(substr($value['id'], 0, 3));

		$parent_package = $this->parent_package;
		$customer_type = $this->customer_type;
		$parent_product = $this->parent_product;
		$wag_name = $this->wag_name;
		$wag_enable = $this->wag_enable;
		$DNS_profile = $this->DNS_profile;
		$gateway_type = $this->gateway_type;
		$pr_gateway_type = $this->pr_gateway_type;
		$zone_description = $this->zone_description;

		$template_zone = $this->template_zone;
		$sw_controller_name = $this->sw_controller_name;
		$privte_ssid = $this->privte_ssidarr;
		$privte_ssid_new = $this->privte_ssid_new;
		$guest_ssid = $this->guest_ssidarr;
		$vt_ssid = $this->vt_ssidarr;
		$hotspot = $this->hotspot;
		$DHCP_profile = $this->DHCP_profile;

		$isDynamic = $this->package_functions->isDynamic($this->system_package);
		$mdo_disable = $this->package_functions->getOptions('MDO_DISABLE', $this->system_package);

		if ($isDynamic) {
			$getJson = $this->db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='DYNAMIC_MNO_001' AND `config_type`='api'");
		} else {
			$getJson = $this->db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='$this->system_package' AND `config_type`='api'");
		}

		$configFileArr = json_decode($getJson, true);
		//$business_type = $configFileArr['vertical'];
		//$this->smb = $business_type;
		$zone_name = $value['id'];
		$property_id = $zone_name;

		if ($this->provision == 1) {
			$guest_arr_n = $this->network_info['Guest']['data'];
		    $private_arr_n = $this->network_info['Private']['data'];
		    $vt_arr_n = $this->network_info['VTenant']['data'];
		}

		$state = strtoupper(trim($value['address']['state']));
		$city = ucwords(strtolower(trim($value['address']['city'])));
		$formattedAddr = $value['address']['street'] . '+' . $city . '+' . $state;
		$formattedAddr = str_replace(' ', '+', $formattedAddr);
		$addOutput = getCoordinates($formattedAddr, $this->db);
		$latitude  = (float)$addOutput['latitude'];
		$longitude = (float)$addOutput['longitude'];

		$ap_controller_name = $parent_pref . ' AP Controller API';
		$sw_controller_name = $parent_pref . ' Switch Controller API';
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

		if (strlen($configFileArr['switch_main_domain_name']) > 0) {
			$switch_main_domain_name = $configFileArr['switch_main_domain_name'];
		} else {
			$switch_main_domain_name = $this->switch_main_domain_name;
		}

		if (strlen($configFileArr['ap_main_domain_name']) > 0) {
			$main_domain_name = $configFileArr['ap_main_domain_name'];
		} else {
			$main_domain_name = $this->main_domain_name;
		}

		if (strlen($switch_main_domain_name) < 1) {
			$switch_main_domain_name = $main_domain_name;
		}
		$max_subdomains = $this->max_subdomains;
		if (strlen($max_subdomains) < 1) {
			$max_subdomains = 50;
		}

		$ap_data = $this->db->select1DB("SELECT `id`,`api_profile` FROM `exp_locations_ap_controller` WHERE `controller_name` = '$this->ap_controller'");
		$profile = $ap_data['api_profile'];
		$ap_id = $ap_data['id'];
		$sw_data = $this->db->select1DB("SELECT `id`,`api_profile` FROM `exp_locations_ap_controller` WHERE `controller_name` = '$this->sw_controller'");
		$sw_profile = $sw_data['api_profile'];
		$sw_id = $sw_data['id'];

		if ($profile == '') {
			$profile = $this->db->setVal('wag_ap_name', 'ADMIN');
			if ($profile == '') {
				$profile = "non";
			}
		}
		if ($this->provision == 1) {
			require_once '../../src/AP/' . $profile . '/index.php';
		}else{
			require_once 'src/AP/' . $profile . '/index.php';
		}
		
		$wag_obj = new ap_wag($this->ap_controller);
		$wag_obj->setRealm($this->icomme_number);
		$wag_obj->AutoInc = $ap_id;
		$zone_id = $this->db->getValueAsf("SELECT `zoneid` AS f FROM exp_distributor_zones WHERE `ap_controller` = '$this->ap_controller' AND `name` = '$this->icomme_number'");
		if ($this->ap_controller != $this->old_conroller) {/*
			$old_profile = $this->db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$this->old_conroller'");
			if ($old_profile == '') {
		    $old_profile = $this->db->setVal('wag_ap_name', 'ADMIN');    
			}
		require_once 'src/AP/' . $old_profile . '/index.php';
		$wag_objo = new ap_wag($this->old_controller);
		$wag_objo->setRealm($this->icomme_number);

		$wag_objo->deletezone($zone_id);

		*/
		}
		$zon_details = $wag_obj->retrieveZonedata($zone_id);
		parse_str($zon_details, $zon_detailsArr);
		$status_code_n = $zon_detailsArr['status_code'];
		if ($status_code_n == '200') {
			$this->zoneid = $zone_id;
			return $this->ruckusmanual();
		} else {
			if ($this->sw_controller) {
				$switch = 0;
				if ($sw_profile != $profile) {
					if ($this->provision == 1) {
						require_once '../../src/AP/' . $sw_profile . '/index.php';
					}else{
						require_once 'src/AP/' . $sw_profile . '/index.php';
					}
					$wag_objSw = new ap_wag($this->sw_controller);
					$wag_objSw->setRealm($this->icomme_number);
					$wag_objSw->AutoInc = $sw_id;
					//$sub_domain_create_switch = createDomainHierarchy($wag_objSw,$value,$switch_main_domain_name,$parent_pref,$this->db,$this->sw_controller);
					$sub_domain_create_switch = createDomainHierarchyNew($wag_objSw, $value, $switch_main_domain_name, $this->icomme_number, $this->db, $this->sw_controller, $max_subdomains);
				} else {

					$wag_objSw = $wag_obj;
				}
			}
			//$sub_domain_create = createDomainHierarchy($wag_obj,$value,$main_domain_name,$parent_pref,$this->db,$this->ap_controller);
			$sub_domain_create = createDomainHierarchyNew($wag_obj, $value, $main_domain_name, $this->icomme_number, $this->db, $this->ap_controller, $max_subdomains);
			print_r($sub_domain_create);
			$guest_wlan_count = $this->guest_count;
			$pvt_wlan_count = $this->pvt_count;
			$vt_wlan_count = $this->vt_count;
			if ($sub_domain_create['status'] == 'success') {

				$sub_domain_id = $sub_domain_create['data'];
				$sub_domain_id_switch = $sub_domain_create_switch['data'];

				$obj2 = array();
				$obj2['mesh']['ssid'] = 'mesh-' . uniqid();
				$obj2['mesh']['passphrase'] = uniqid() . randomPasswordLength(40);
				$obj2['location'] = $this->icomme_number;
				$getGreProfile = $wag_obj->getGreProfile();
				parse_str($getGreProfile, $getGreProfile_arr);
				$getGreProfile_obj = (array)json_decode(urldecode($getGreProfile_arr['Description']));
				$grelist = $getGreProfile_obj['list'];
				$grelist_ar = json_decode(json_encode($grelist[0]), True);
				$greId = $grelist_ar['id'];
				$obj2['tunnelProfile']['id'] = $greId;
				$obj2['tunnelProfile']['name'] = 'Default Tunnel Profile';
				$newzone = $this->icomme_number;
				$newzone = substr($newzone, -32);

				$obj2['description'] = $zone_description;
				$obj2['countryCode'] = 'US';
				$obj2['login']['apLoginName'] = $configFileArr['ap_controller_user_name'];
				$obj2['login']['apLoginPassword'] = $configFileArr['ap_controller_password'];
				$obj2['wifi24']['txPower'] = 'Full';
				$obj2['wifi24']['channelWidth'] = 0;
				$obj2['wifi24']['channel'] = 0;
				$obj2['wifi24']['channelRange'] = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
				$obj2['wifi50']['txPower'] = 'Full';
				$obj2['wifi50']['channelWidth'] = 40;
				$obj2['wifi50']['indoorChannel'] = 0;
				$obj2['wifi50']['outdoorChannel'] = 0;
				$obj2['smartMonitor']['intervalInSec'] = 10;
				$obj2['smartMonitor']['retryThreshold'] = 3;
				$obj2['clientLoadBalancing24']['adjacentRadioThreshold'] = 50;
				$obj2['clientLoadBalancing50']['adjacentRadioThreshold'] = 43;
				$obj2['bandBalancing']['mode'] = 'BASIC';
				$obj2['bandBalancing']['wifi24Percentage'] = 25;
				$obj2['apRebootTimeout']['gatewayLossTimeoutInSec'] = 1800;
				$obj2['apRebootTimeout']['serverLossTimeoutInSec'] = 7200;
				$obj2['autoChannelSelection24']['channelSelectMode'] = 'ChannelFly';
				$obj2['autoChannelSelection24']['channelFlyMtbc'] = 1440;
				$obj2['autoChannelSelection50']['channelSelectMode'] = 'ChannelFly';
				$obj2['autoChannelSelection50']['channelFlyMtbc'] = 1440;
				$obj2['altitude']['altitudeUnit'] = 'meters';
				$obj2['altitude']['altitudeValue'] = 0;
				$obj2['tunnelType'] = 'RuckusGRE';

				if ($mdo_disable != 'YES') {
					$obj2['zoneAffinityProfileId'] = getZoneAffinityProfile($this->db, $wag_obj, readAffinityConfig($this->db, $this->system_package, $state, $configFileArr));
				}
				//echo readAffinityConfig($this->db,$this->system_package,$state,$configFileArr);

				$create_zone = $wag_obj->createzone($newzone, '', '', $sub_domain_id, $latitude, $longitude, $obj2);

				parse_str($create_zone, $create_zone_arr);
				$json_zone = json_decode(urldecode($create_zone_arr['Description']), true);
				$zoneid = $json_zone[id];
				if ($create_zone_arr['status_code'] == '200') {

					if ($switch != 0) {
						$createSwitchGroup = $wag_objSw->createSwitchGroup($newzone, $newzone, $sub_domain_id_switch);
						parse_str($createSwitchGroup, $createSwitchGroup_arr);
					} else {
						$createSwitchGroup_arr['status_code'] = '200';
					}




					if ($createSwitchGroup_arr['status_code'] != '200') {

						$wag_obj->deletezone($zoneid);
						freeRealm($this->icomme_number, $this->db, true);
						$status_code = 0;
					}

					$switch_group_id_arr = (array)json_decode(urldecode($createSwitchGroup_arr['Description']), true);

					$switch_group_id = $switch_group_id_arr['id'];

					$query0 = "INSERT INTO exp_distributor_zones (zoneid,name,ap_controller,create_user,create_date)
                        values ('$zoneid','$newzone','$this->ap_controller','$this->user_name',now())";

					$zoneq = $this->db->execDB($query0);

					$getAccountingService = $wag_obj->getAccountingService();
					parse_str($getAccountingService, $getaservice_arr);
					$getServ_obj = (array)json_decode(urldecode($getaservice_arr['Description']));

					$Servelist = $getServ_obj['list'];

					foreach ($Servelist as $key2 => $value2) {

						$Servelist_ar = json_decode(json_encode($value2), True);

						if ($Servelist_ar['primary']['ip'] == $configFileArr['AAA_server_ip_address']) {

							$account_server_id = $Servelist_ar['id'];
							$account_server_name = $Servelist_ar['name'];
						}
					}

					if ($zoneq) {
						$zonecreate = 1;
						$getRadius = $wag_obj->getRadius();
						parse_str($getRadius, $getRadius_arr);
						$getRadius_obj = (array)json_decode(urldecode($getRadius_arr['Description']));
						$radiuslist = $getRadius_obj['list'];
						foreach ($radiuslist as $key1 => $value1) {

							$radiuslist_ar = json_decode(json_encode($value1), True);
							if ($radiuslist_ar['primary']['ip'] == $configFileArr['AAA_server_ip_address']) {

								$server_id = $radiuslist_ar['id'];
								$server_name = $radiuslist_ar['name'];
								$modify_server_id = $radiuslist_ar['modifierId'];
								$domainId_server_id = $radiuslist_ar['domainId'];
								$radiuslistmappings_ar = json_decode(json_encode($radiuslist_ar['mappings']), True);
								foreach ($radiuslistmappings_ar as $key4 => $value4) {

									if ($value4['groupAttr'] == $configFileArr['utp_profile_name']) {

										$radiuslistuserTrafficProf_ar = json_decode(json_encode($value4['userRole']), True);
										$radiuslistuserTrafficProfile_ar = json_decode(json_encode($radiuslistuserTrafficProf_ar['userTrafficProfile']), True);
										$userTrafficProfileId  = $radiuslistuserTrafficProfile_ar['id'];
										$userTrafficProfileName  = $radiuslistuserTrafficProfile_ar['name'];
										$firewallProfileId = $radiuslistuserTrafficProf_ar['firewallProfileId'];
									}
								}
							}
						}

						$add_data = array();

						$privatenetwork = 1;

						for ($i = 1; $i <= (int)$pvt_wlan_count; $i++) {
							$ssid = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $value['name'] . '-P' . $i);
							$add_data['description'] = $value['name'] . '-P' . $i;
							$add_data['encryption']['method'] = $privte_ssid['encryption']['method'];
							$add_data['encryption']['algorithm'] = $privte_ssid['encryption']['algorithm'];
							$add_data['encryption']['passphrase'] = $configFileArr['Private_SSID_WPA_key'];
							$add_data['encryption']['mfp'] = $privte_ssid['encryption']['mfp'];
							$add_data['radiusOptions']['nasIdType'] = $privte_ssid['radiusOptions']['nasIdType'];

							if (array_key_exists('accountingServiceOrProfile', $privte_ssid)) {
								$add_data['accountingServiceOrProfile'] = array("id" => $account_server_id, "name" => $account_server_name, "throughController" => $privte_ssid['accountingServiceOrProfile']['throughController'], "realmBasedAcct" => $privte_ssid['accountingServiceOrProfile']['realmBasedAcct'], "interimUpdateMin" => $privte_ssid['accountingServiceOrProfile']['interimUpdateMin'], "accountingDelayEnabled" => $privte_ssid['accountingServiceOrProfile']['accountingDelayEnabled']);
							}

							$add_data['radiusOptions']['calledStaIdType'] = $privte_ssid['radiusOptions']['calledStaIdType'];
							$add_data['advancedOptions']['clientFingerprintingEnabled'] = $privte_ssid['advancedOptions']['clientFingerprintingEnabled'];
							$add_data['advancedOptions']['clientIsolationEnabled'] = $privte_ssid['advancedOptions']['clientIsolationEnabled'];
							$add_data['advancedOptions']['ofdmOnlyEnabled'] = $privte_ssid['advancedOptions']['ofdmOnlyEnabled'];
							$add_data['advancedOptions']['bssMinRateMbps'] = $privte_ssid['advancedOptions']['bssMinRateMbps'];
							$add_data['advancedOptions']['mgmtTxRateMbps'] = $privte_ssid['advancedOptions']['mgmtTxRateMbps'];
							$add_data['vlan']['accessVlan'] = (int)$configFileArr['Private_vlan_id'];


							if ($configFileArr['private_accounting'] == 1) {
								$add_data['radiusOptions'] = $privte_ssid_new['radiusOptions'];
								$add_data['encryption'] = $privte_ssid_new['encryption'];
								$add_data['macAuth'] = $privte_ssid_new['macAuth'];
								$add_data['advancedOptions'] = $privte_ssid_new['advancedOptions'];
								$add_data['authServiceOrProfile'] = $privte_ssid_new['authServiceOrProfile'];
								$add_data['accountingServiceOrProfile'] = $privte_ssid_new['accountingServiceOrProfile'];
								$getAuthProfile = $wag_obj->retrieveAuthList();
								parse_str($getAuthProfile, $getAuthProfile);
								$getAuthProfile_data = json_decode($getAuthProfile['Description'], true);
								$AuthProfilelist = $getAuthProfile_data['list'];
								foreach ($AuthProfilelist as $value1) {
									if ($value1['domainId'] == $domainId_server_id) {
										$authServiceOrProfileID = $value1['id'];
										$authServiceOrProfileName = $value1['name'];
									}
								}
								$getAccProfile = $wag_obj->retrieveAccountList();
								parse_str($getAccProfile, $getAccProfile);
								$getAccProfile_data = json_decode($getAccProfile['Description'], true);
								$AccProfilelist = $getAccProfile_data['list'];
								foreach ($AccProfilelist as $value1) {
									if ($value1['domainId'] == $domainId_server_id) {
										$AccServiceOrProfileID = $value1['id'];
										$AccServiceOrProfileName = $value1['name'];
									}
								}
								$add_data['authServiceOrProfile']['id'] = $authServiceOrProfileID;
								$add_data['authServiceOrProfile']['name'] = $authServiceOrProfileName;

								$add_data['accountingServiceOrProfile']['id'] = $AccServiceOrProfileID;
								$add_data['accountingServiceOrProfile']['name'] = $AccServiceOrProfileName;
							}

							$wlan_name = 'Private-' . $i;
							if ($this->provision == 1) {
								foreach ($private_arr_n as $value) {
								if (strtolower($wlan_name) == $value['wlan_name']) {
						                $ssid = $value['SSID'];
						            }
						        }

							}
							$createnetwork = $wag_obj->createnetwork($zoneid, $wlan_name, $ssid, $add_data, $configFileArr['Private_vlan_id'], $configFileArr['private_accounting']);

							parse_str($createnetwork, $network_arr);
							$json_network_desc = json_decode(urldecode($network_arr['Description']), true);

							if ($network_arr['status_code'] != '200') {
								$privatenetwork = 0;
								$status_code = 2;
							}
						}
						if ($privatenetwork == 1) {

							if (!empty($hotspot['location'])) {
								if (array_key_exists('id', $hotspot['location'])) {
									$hotspot['location']['id'] = $this->icomme_number;
								}
								if (array_key_exists('name', $hotspot['location'])) {
									$hotspot['location']['name'] = $this->icomme_number;
								}
							}

							$hotspot['portalUrl'] = $configFileArr['portalUrl'];
							$hotspot['name'] = 'HotspotPortal';
							$hotspot['description'] = 'hotspot portal';
							$hotspot['walledGardens'] = $configFileArr['walled_garden_ip_addresses'];
							$hotspot_arr = $hotspot;

							$createHotspot = $wag_obj->createHotspot($zoneid, $hotspot_arr);
							parse_str($createHotspot, $createHotspot_arr);

							if ($mdo_disable != 'YES') {
								$hotspot20_arr = [];
								$hotspot20_arr['name'] = 'Altice MDO Profile HS20';
								$hotspot20_arr['description'] = 'Hotspot 2.0 Portal';

								$hotspot20_arr['operator'] = getHotspot20Operator($this->db, $wag_obj, $configFileArr['Wifi_Operator']);

								$hotspot20IDPs = getHotspot20IDP($this->db, $wag_obj, $configFileArr['Identity_provider']);

								$hotspot20_arr['defaultIdentityProvider'] = $hotspot20IDPs[0];
								//$hotspot20_arr['defaultIdentityProvider'] = ['id'=>$configFileArr['Default_identity_provider_id'],'name'=>$configFileArr['Default_identity_provider_name']];//$hotspot20IDPs[0];
								$hotspot20_arr['accessNetworkType'] = "PRIVATE";
								$hotspot20_arr['internetOption'] = true;
								$hotspot20_arr['ipv4AddressType'] = "SINGLE_NATED_PRIVATE";
								$hotspot20_arr['ipv6AddressType'] = "UNAVAILABLE";

								$createHotspot20_arr = $wag_obj->createHotspot20($zoneid, $hotspot20_arr);
							} else {
								$createHotspot20_arr = array();
								$createHotspot20_arr['success'] = true;
							}

							if ($createHotspot_arr['status_code'] == '200' && $createHotspot20_arr['success'] === true) {

								$createHotspot_obj = (array)json_decode(urldecode($createHotspot_arr['Description']));

								$hotspot_id = $createHotspot_obj['id'];

								$guestnetwork = 1;
								for ($i = 1; $i <= (int)$vt_wlan_count; $i++) {
									$wlan_name = 'vTenant-' . $i;
									$ssid_new = 'vTenant-V' . $i;
									if ($this->provision == 1) {
										foreach ($vt_arr_n as $value) {
										if (strtolower($wlan_name) == $value['wlan_name']) {
								                $ssid_new = $value['SSID'];
								            }
								        }

									}

									if ($this->isReadyTv) {

										$guest_arr = array(
											"name" => $wlan_name,
											"ssid" => $ssid_new,
											"description" => $ssid_new,
											"encryption" => $privte_ssid_new['encryption'],
											"portalServiceProfile" => array("id" => $hotspot_id, "name" => $hotspot['name']),
											"authServiceOrProfile" => array("id" => $server_id, "name" => $server_name, "throughController" => $guest_ssid['authServiceOrProfile']['throughController'], "realmBasedAuth" => $guest_ssid['authServiceOrProfile']['realmBasedAuth']),
											"accountingServiceOrProfile" => array("id" => $account_server_id, "name" => $account_server_name, "throughController" => $guest_ssid['accountingServiceOrProfile']['throughController'], "realmBasedAcct" => $guest_ssid['accountingServiceOrProfile']['realmBasedAcct'], "interimUpdateMin" => $guest_ssid['accountingServiceOrProfile']['interimUpdateMin'], "accountingDelayEnabled" => $guest_ssid['accountingServiceOrProfile']['accountingDelayEnabled']),
											"advancedOptions" => array("clientFingerprintingEnabled" => $guest_ssid['advancedOptions']['clientFingerprintingEnabled'], "clientIsolationEnabled" => $guest_ssid['advancedOptions']['clientIsolationEnabled'], "ofdmOnlyEnabled" => $guest_ssid['advancedOptions']['ofdmOnlyEnabled'], "bssMinRateMbps" => $guest_ssid['advancedOptions']['bssMinRateMbps'], "mgmtTxRateMbps" => $guest_ssid['advancedOptions']['mgmtTxRateMbps']),
											"radiusOptions" => array("nasIdType" => $guest_ssid['radiusOptions']['nasIdType'], "customizedNasId" => $guest_ssid['radiusOptions']['customizedNasId'], "calledStaIdType" => $guest_ssid['radiusOptions']['calledStaIdType']),
											"defaultUserTrafficProfile" => array("id" => $userTrafficProfileId, "name" => $userTrafficProfileName),
											"vlan" => array("accessVlan" => (int)$configFileArr['vTenant_vlan_id']),
										);
									} else {
										$guest_arr = array(
											"name" => $wlan_name,
											"ssid" => $ssid_new,
											"description" => $ssid_new,
											"portalServiceProfile" => array("id" => $hotspot_id, "name" => $hotspot['name']),
											"authServiceOrProfile" => array("id" => $server_id, "name" => $server_name, "throughController" => $guest_ssid['authServiceOrProfile']['throughController'], "realmBasedAuth" => $guest_ssid['authServiceOrProfile']['realmBasedAuth']),
											"accountingServiceOrProfile" => array("id" => $account_server_id, "name" => $account_server_name, "throughController" => $guest_ssid['accountingServiceOrProfile']['throughController'], "realmBasedAcct" => $guest_ssid['accountingServiceOrProfile']['realmBasedAcct'], "interimUpdateMin" => $guest_ssid['accountingServiceOrProfile']['interimUpdateMin'], "accountingDelayEnabled" => $guest_ssid['accountingServiceOrProfile']['accountingDelayEnabled']),
											"advancedOptions" => array("clientFingerprintingEnabled" => $guest_ssid['advancedOptions']['clientFingerprintingEnabled'], "clientIsolationEnabled" => $guest_ssid['advancedOptions']['clientIsolationEnabled'], "ofdmOnlyEnabled" => $guest_ssid['advancedOptions']['ofdmOnlyEnabled'], "bssMinRateMbps" => $guest_ssid['advancedOptions']['bssMinRateMbps'], "mgmtTxRateMbps" => $guest_ssid['advancedOptions']['mgmtTxRateMbps']),
											"radiusOptions" => array("nasIdType" => $guest_ssid['radiusOptions']['nasIdType'], "customizedNasId" => $guest_ssid['radiusOptions']['customizedNasId'], "calledStaIdType" => $guest_ssid['radiusOptions']['calledStaIdType']),
											"defaultUserTrafficProfile" => array("id" => $userTrafficProfileId, "name" => $userTrafficProfileName),
											"vlan" => array("accessVlan" => (int)$configFileArr['vTenant_vlan_id']),
										);
									}


									$createGuestSSID = $wag_obj->createGuestSSID($zoneid, $guest_arr);
									parse_str($createGuestSSID, $createGuestSSID_arr);
									$createGuestSSID_obj = (array)json_decode(urldecode($createGuestSSID_arr['Description']));
									if ($createGuestSSID_arr['status_code'] != '200') {
										$guestnetwork = 0;
										$status_code = 3;
									}
								}


								for ($i = 1; $i <= (int)$guest_wlan_count; $i++) {
									$wlan_name = 'Guest-' . $i;
									$ssid_new = 'Guest-G' . $i;

										if ($this->provision == 1) {
											foreach ($guest_arr_n as $value) {
											if (strtolower($wlan_name) == $value['wlan_name']) {
									                $ssid_new = $value['SSID'];
									            }
									        }

										}

									$guest_arr = array(
										"name" => $wlan_name,
										"ssid" => $ssid_new,
										"description" => $ssid_new,
										"portalServiceProfile" => array("id" => $hotspot_id, "name" => $hotspot['name']),
										"authServiceOrProfile" => array("id" => $server_id, "name" => $server_name, "throughController" => $guest_ssid['authServiceOrProfile']['throughController'], "realmBasedAuth" => $guest_ssid['authServiceOrProfile']['realmBasedAuth']),
										"accountingServiceOrProfile" => array("id" => $account_server_id, "name" => $account_server_name, "throughController" => $guest_ssid['accountingServiceOrProfile']['throughController'], "realmBasedAcct" => $guest_ssid['accountingServiceOrProfile']['realmBasedAcct'], "interimUpdateMin" => $guest_ssid['accountingServiceOrProfile']['interimUpdateMin'], "accountingDelayEnabled" => $guest_ssid['accountingServiceOrProfile']['accountingDelayEnabled']),
										"advancedOptions" => array("clientFingerprintingEnabled" => $guest_ssid['advancedOptions']['clientFingerprintingEnabled'], "clientIsolationEnabled" => $guest_ssid['advancedOptions']['clientIsolationEnabled'], "ofdmOnlyEnabled" => $guest_ssid['advancedOptions']['ofdmOnlyEnabled'], "bssMinRateMbps" => $guest_ssid['advancedOptions']['bssMinRateMbps'], "mgmtTxRateMbps" => $guest_ssid['advancedOptions']['mgmtTxRateMbps']),
										"radiusOptions" => array("nasIdType" => $guest_ssid['radiusOptions']['nasIdType'], "customizedNasId" => $guest_ssid['radiusOptions']['customizedNasId'], "calledStaIdType" => $guest_ssid['radiusOptions']['calledStaIdType']),
										"defaultUserTrafficProfile" => array("id" => $userTrafficProfileId, "name" => $userTrafficProfileName),
										"vlan" => array("accessVlan" => (int)$configFileArr['Guest_vlan_id']),
									);
									$guestAddParametres = array('firewallProfileId' => $firewallProfileId);
									if ($configFileArr['private_accounting'] == 1) {
										$guest_arr["radiusOptions"]["singleSessionIdAcctEnabled"] = true;
									}

									$createGuestSSID = $wag_obj->createGuestSSID($zoneid, $guest_arr, $guestAddParametres);
									parse_str($createGuestSSID, $createGuestSSID_arr);
									$createGuestSSID_obj = (array)json_decode(urldecode($createGuestSSID_arr['Description']));
									if ($createGuestSSID_arr['status_code'] != '200') {
										$guestnetwork = 0;
										$status_code = 3;
									}
								}

								if ($mdo_disable != 'YES') {

									$mdo_arr = setHotspot20SSIDConfig($this->db, $configFileArr, $greId, $createHotspot20_arr, $hotspot20_arr['name']);

									$createHotspot20SSID = $wag_obj->createHotspot20SSID($zoneid, $mdo_arr);
								} else {
									$createHotspot20SSID = array();
									$createHotspot20SSID['success'] = true;
								}
								//parse_str($createGuestSSID, $createGuestSSID_arr);

								if ($guestnetwork == 1 && $createHotspot20SSID['success'] === true) {

									$resultdns = $wag_obj->retrieveDNSServerProfile();
									parse_str($resultdns, $resultdns_arr);
									$resultdns_obj = (array)json_decode(urldecode($resultdns_arr['Description']));
									$resultdns_list = $resultdns_obj['list'];

									$dnsFilterExist = 0;
									$dnsRegExist = 0;

									if (count($resultdns_list) > 0) {

										foreach ($resultdns_list as $keydns => $valuedns) {
											$valuedns = (array)$valuedns;
											$name = $valuedns['name'];

											if ($name == 'DNS-API-ContentFiltering') {

												$dnsFilterExist = 1;

												$filter_primaryIp = $valuedns['primaryIp'];
												$filter_secondaryIp = $valuedns['secondaryIp'];
												$filter_id = $valuedns['id'];

												if (($configFileArr['guest_DHCP_pool-primary_filter-DNS'] != $filter_primaryIp) || ($configFileArr['guest_DHCP_pool-secondary_filter-DNS'] != $filter_secondaryIp)) {

													$filter_domainId = $valuedns['domainId'];
													$filter_id = $valuedns['id'];
													$filter_description = $valuedns['description'];
													$filter_primaryIp = $configFileArr['guest_DHCP_pool-primary_filter-DNS'];
													$filter_secondaryIp = $configFileArr['guest_DHCP_pool-secondary_filter-DNS'];
													$filter_tertiaryIp = $valuedns['tertiaryIp'];
													$filter_creatorId = $valuedns['creatorId'];
													$filter_modifierUsername = $valuedns['modifierUsername'];
													$filter_createDateTime = $valuedns['createDateTime'];
													$filter_creatorUsername = $valuedns['creatorUsername'];

													$dnArr = array("name" => $name, "description" => $filter_description, "primaryIp" => $filter_primaryIp, "secondaryIp" => $filter_secondaryIp, "tertiaryIp" => $filter_tertiaryIp);

													$modifyDNSServerProfile = $wag_obj->modifyDNSServerProfile($dnArr, $filter_id);
													parse_str($modifyDNSServerProfile, $modifyDNSServerProfile_arr);

													if ($modifyDNSServerProfile_arr['status_code'] == '200') {

														$q = "REPLACE INTO `exp_dns_profile` (`unique_id`,`domainId`,`name`,`controller`,`description`,`primaryIp`,`secondaryIp`,`tertiaryIp`,creatorId,modifierId,modifierUsername,creatorUsername,create_user,search_id)
                                       VALUES ('$filter_id','$filter_domainId','$name','$ap_controller','$filter_description','$filter_primaryIp','$filter_secondaryIp','$filter_tertiaryIp','$filter_creatorId','$modifierId','$filter_modifierUsername','filter_creatorUsername','API','$search_id')";

														$this->db->execDB($q);
													} else {
														if ($switch != 0) {
															$wag_objSw->deleteswitchgroup($this->switch_group_id);
														}
														$wag_obj->deletezone($zoneid);
														freeRealm($this->icomme_number, $this->db, true);
														$status_code = 4;
													}
												}
											}
											if ($name == 'DNS-API-Regular') {
												$dnsRegExist = 1;

												$reg_primaryIp = $valuedns['primaryIp'];
												$reg_secondaryIp = $valuedns['secondaryIp'];
												$reg_id = $valuedns['id'];

												if (($configFileArr['guest_DHCP_pool-primary_reg-DNS'] != $reg_primaryIp) || ($configFileArr['guest_DHCP_pool-secondary_reg-DNS'] != $reg_secondaryIp)) {

													$reg_domainId = $valuedns['domainId'];
													$reg_id = $valuedns['id'];
													$reg_description = $valuedns['description'];
													$reg_primaryIp = $configFileArr['guest_DHCP_pool-primary_reg-DNS'];
													$reg_secondaryIp = $configFileArr['guest_DHCP_pool-secondary_reg-DNS'];
													$reg_tertiaryIp = $valuedns['tertiaryIp'];
													$reg_creatorId = $valuedns['creatorId'];
													$reg_modifierUsername = $valuedns['modifierUsername'];
													$reg_createDateTime = $valuedns['createDateTime'];
													$reg_creatorUsername = $valuedns['creatorUsername'];

													$dnArr = array("name" => $name, "description" => $reg_description, "primaryIp" => $reg_primaryIp, "secondaryIp" => $reg_secondaryIp, "tertiaryIp" => $reg_tertiaryIp);

													$modifyDNSServerProfile = $wag_obj->modifyDNSServerProfile($dnArr, $reg_id);
													parse_str($modifyDNSServerProfile, $modifyDNSServerProfile_arr);

													if ($modifyDNSServerProfile_arr['status_code'] == '200') {

														$q = "REPLACE INTO `exp_dns_profile` (`unique_id`,`domainId`,`name`,`controller`,`description`,`primaryIp`,`secondaryIp`,`tertiaryIp`,creatorId,modifierId,modifierUsername,creatorUsername,create_user,search_id)
                       VALUES ('$reg_id','$reg_domainId','$name','$this->ap_controller','$reg_description','$reg_primaryIp','$reg_secondaryIp','$reg_tertiaryIp','$reg_creatorId','$modifierId','$reg_modifierUsername','reg_creatorUsername','API','$search_id')";

														$this->db->execDB($q);
													} else {

														if ($switch != 0) {
															$wag_objSw->deleteswitchgroup($switch_group_id);
														}
														$wag_obj->deletezone($zoneid);
														freeRealm($this->icomme_number, $this->db, true);
														$status_code = 5;
													}
												}
											}
										}
									}

									if ($dnsFilterExist != 1) {

										$filter_primaryIp = $configFileArr['guest_DHCP_pool-primary_filter-DNS'];
										$filter_secondaryIp = $configFileArr['guest_DHCP_pool-secondary_filter-DNS'];

										$dnArr = array("name" => "DNS-API-ContentFiltering", "description" => "DNS-API-ContentFiltering", "primaryIp" => $filter_primaryIp, "secondaryIp" => $filter_secondaryIp, "tertiaryIp" => "");

										$createDNSServerProfile = $wag_obj->createDNSServerProfile($dnArr);
										parse_str($createDNSServerProfile, $createDNSServerProfile_arr);

										$createDNSServerProfile_obj = (array)json_decode(urldecode($createDNSServerProfile_arr['Description']));

										if ($createDNSServerProfile_arr['status_code'] == '200') {

											$filter_id = $createDNSServerProfile_obj['id'];

											$q = "REPLACE INTO `exp_dns_profile` (`unique_id`,`domainId`,`name`,`controller`,`description`,`primaryIp`,`secondaryIp`,`tertiaryIp`,creatorId,modifierId,modifierUsername,creatorUsername,create_user,search_id)
                       VALUES ('$filter_id','','DNS-API-ContentFiltering','$ap_controller','DNS-API-ContentFiltering','$filter_primaryIp','$filter_secondaryIp','','','','','','API','$search_id')";

											$this->db->execDB($q);
										} else {
											if ($switch != 0) {
												$wag_objSw->deleteswitchgroup($this->switch_group_id);
											}
											$wag_obj->deletezone($zoneid);
											freeRealm($this->icomme_number, $this->db, true);
											$status_code = 6;
										}
									}

									if ($dnsRegExist != 1) {
										$reg_primaryIp = $configFileArr['guest_DHCP_pool-primary_reg-DNS'];
										$reg_secondaryIp = $configFileArr['guest_DHCP_pool-secondary_reg-DNS'];

										$dnArr = array("name" => "DNS-API-Regular", "description" => "DNS-API-Regular", "primaryIp" => $reg_primaryIp, "secondaryIp" => $reg_secondaryIp, "tertiaryIp" => "");

										$createDNSServerProfile = $wag_obj->createDNSServerProfile($dnArr);
										parse_str($createDNSServerProfile, $createDNSServerProfile_arr);

										$createDNSServerProfile_obj = (array)json_decode(urldecode($createDNSServerProfile_arr['Description']));

										if ($createDNSServerProfile_arr['status_code'] == '200') {

											$reg_id = $createDNSServerProfile_obj['id'];

											$q = "REPLACE INTO `exp_dns_profile` (`unique_id`,`domainId`,`name`,`controller`,`description`,`primaryIp`,`secondaryIp`,`tertiaryIp`,creatorId,modifierId,modifierUsername,creatorUsername,create_user,search_id)
                       VALUES ('$reg_id','','DNS-API-Regular','$this->ap_controller','DNS-API-Regular','$reg_primaryIp','$reg_secondaryIp','','','','','','API','$search_id')";

											$this->db->execDB($q);
										} else {
											if ($switch != 0) {
												$wag_objSw->deleteswitchgroup($this->switch_group_id);
											}
											$wag_obj->deletezone($zoneid);
											freeRealm($this->icomme_number, $this->db, true);
											$status_code = 7;
										}
									}

									$dns_name = $configFileArr['content_filter_profile_name'];

									//if($dnsFilterExist !=1 || $dnsRegExist !=1){

									$queryString = "SELECT profile_code,regular_profile,content_filter_profile FROM `exp_controller_dns` WHERE `name`='$dns_name'";
									$queryResult = $this->db->selectDB($queryString);
									if ($queryResult['rowCount'] > 0) {
										foreach ($queryResult['data'] as $row) {
											$dns_profile_code = $row['profile_code'];
											$dns_regular_profile = $row['regular_profile'];
											$dns_content_filter_profile = $row['content_filter_profile'];

											if (($dns_regular_profile != $reg_id) || ($dns_content_filter_profile != $filter_id)) {

												$q = "UPDATE `exp_controller_dns` SET regular_profile='$reg_id',content_filter_profile='$filter_id' WHERE profile_code='$dns_profile_code'";

												$this->db->execDB($q);
											}
										}
									} else {

										$differenceInSeconds = strtotime(date('Y-m-d h:i:s')) - strtotime('2016-08-30 00:00:00');
										$dns_code = $dns_name . "-" . base_convert($differenceInSeconds, 10, 36);

										$insert_wag_q = "INSERT INTO `exp_controller_dns` (`profile_code`,`name`,`controller`,`regular_profile`,`content_filter_profile`,`create_date`,`create_user`)
                                                VALUES('$this->dns_code','$this->dns_name','$this->ap_controller','$reg_id','$filter_id',NOW(),'$this->user_name')";

										$insert_wag = $this->db->execDB($insert_wag_q);
									}


									//}

									if ($dns_profile_enable == '1') {

										$primaryDnsIp = $filter_primaryIp;
										$secondaryDnsIp = $filter_secondaryIp;
										$queryString = "SELECT profile_code FROM `exp_controller_dns` WHERE `name`='$this->dns_name'";
										$queryResult = $this->db->selectDB($queryString);
										if ($queryResult['rowCount'] > 0) {
											foreach ($queryResult['data'] as $row) {
												$dns_profile_code = $row['profile_code'];
											}
										}
									} else {
										$dns_profile_code = '';
										$primaryDnsIp = $reg_primaryIp;
										$secondaryDnsIp = $reg_secondaryIp;
									}

									$DHCP_profile['name'] = 'guest-dhcppool-ruckusapi';
									$DHCP_profile['description'] = 'guest-dhcppool-ruckusapi';
									$DHCP_profile['vlanId'] = (int)$configFileArr['guest_DHCP_pool-vlan_id'];
									$DHCP_profile['subnetNetworkIp'] = $configFileArr['guest_DHCP_pool-subnet'];
									$DHCP_profile['subnetMask'] = $configFileArr['guest_DHCP_pool-subnet_mask'];
									$DHCP_profile['poolStartIp'] = $configFileArr['guest_DHCP_pool-pool_start_address'];
									$DHCP_profile['poolEndIp'] = $configFileArr['guest_DHCP_pool-pool_end_address'];
									$DHCP_profile['primaryDnsIp'] = $primaryDnsIp;
									$DHCP_profile['secondaryDnsIp'] = $secondaryDnsIp;
									$DHCP_profile['leaseTimeHours'] = (int)$configFileArr['guest_DHCP_pool-leaseTimeHours'];
									$DHCP_profile['leaseTimeMinutes'] = (int)$configFileArr['guest_DHCP_pool-leaseTimeMinutes'];

									$dhcpProfile_arr = $DHCP_profile;

									$createdhcpProfile = $wag_obj->createdhcpProfile($zoneid, $dhcpProfile_arr);
									parse_str($createdhcpProfile, $createdhcpProfile_arr);
									$createdhcpProfile_obj = (array)json_decode(urldecode($createdhcpProfile_arr['Description']));

									if ($createdhcpProfile_arr['status_code'] == '200') {
									} else {

										if ($switch != 0) {
											$wag_objSw->deleteswitchgroup($switch_group_id);
										}
										$wag_obj->deletezone($zoneid);

										freeRealm($this->icomme_number, $this->db, true);
										$status_code = 9;
									}

									if ($this->isReadyTv) {
										$DHCP_profile['name'] = 'resident-dhcp-pool';
										$DHCP_profile['description'] = 'resident-dhcp-pool';
										$DHCP_profile['vlanId'] = (int)$configFileArr['resident_DHCP_pool-vlan_id'];
										$DHCP_profile['poolStartIp'] = $configFileArr['resident_DHCP_pool-pool_start_address'];
										$DHCP_profile['poolEndIp'] = $configFileArr['resident_DHCP_pool-pool_end_address'];
										$DHCP_profile['subnetNetworkIp'] = $configFileArr['resident_DHCP_pool-subnet'];

										$dhcpProfile_arr = $DHCP_profile;
										$createdhcpProfile = $wag_obj->createdhcpProfile($zoneid, $dhcpProfile_arr);
										parse_str($createdhcpProfile, $createdhcpProfile_arr);
										$createdhcpProfile_obj = (array)json_decode(urldecode($createdhcpProfile_arr['Description']));

										if ($createdhcpProfile_arr['status_code'] == '200') {
										} else {

											if ($switch != 0) {
												$wag_objSw->deleteswitchgroup($switch_group_id);
											}
											$wag_obj->deletezone($zoneid);

											freeRealm($this->icomme_number, $this->db, true);
											$status_code = 9;
										}
									}
								} else {

									if ($switch != 0) {
										$wag_objSw->deleteswitchgroup($switch_group_id);
									}
									$wag_obj->deletezone($zoneid);

									freeRealm($this->icomme_number, $this->db, true);
									$status_code = 10;
								}
							} else {

								if ($switch != 0) {
									$wag_objSw->deleteswitchgroup($switch_group_id);
								}
								$wag_obj->deletezone($zoneid);

								freeRealm($this->icomme_number, $this->db, true);
								$status_code = 11;
							}
						} else {

							if ($switch != 0) {
								$wag_objSw->deleteswitchgroup($switch_group_id);
							}
							$wag_obj->deletezone($zoneid);

							freeRealm($this->icomme_number, $this->db, true);
							$status_code = 12;
						}
					} else {
						$status_code = 13;
					}
				} elseif ($create_zone_arr['status_code'] == '422') {
					$zone_id = $this->db->getValueAsf("SELECT `zoneid` AS f FROM exp_distributor_zones WHERE `ap_controller` = '$this->ap_controller' AND `name` = '$this->icomme_number'");


					$status_code = 200;
				} else {

					freeRealm($this->icomme_number, $this->db, true);
					$status_code = 14;
				}
			} else {
				freeRealm($this->icomme_number, $this->db, true);
				$status_code = 15;
			}

			return array(
				'status_code' => $status_code,
				'zoneid' => $zoneid
			);
		}
	}


	public function zabbix()
	{
		if ($this->provision == 1) {
			require_once '../../src/zabbix/index.php';
		}else{
			require_once 'src/zabbix/index.php';
		}
		$inputarr = $this->inputarr;
		$status_code = 200;

		$value = $inputarr['locations'];
		$parent_pref = strtoupper(substr($value['id'], 0, 3));
		$state = strtoupper(trim($value['address']['state']));
		$city = ucwords(strtolower(trim($value['address']['city'])));
		$req = array(
			'propertyIdentifier' => $this->icomme_number,
			'icomsNumber' => $this->icomme_number,
			'propertyName' => CommonFunctions::clean($value['name']),
			'operator' => $parent_pref,
			'vertical' => $this->smb,
			'address' => array('street' => $value['address']['street'], 'city' => $city, 'state' => $state),
			'devicesToMonitor' => array('ruckus-vsz'),
			'vmEdgeIP' => '0.0.0.0',
			'acIntIP' => '0.0.0.0',
			'switchIP' => '0.0.0.0',
			'clliCode' => 'NA',
			'businessIdentifier' => 'NA',
			'circuitId' => 'NA'
		);

		$zabbix = new zabbix($this->package_functions->getOptions('ZABBIX_API_PROFILE', $this->system_package), $this->system_package);
		$zabbixCreate = $zabbix->create($req);
		$decodedzabbixCreate = json_decode($zabbixCreate, true);

		if ($decodedzabbixCreate['status_code'] == '200') {
		} else {
			$title = $this->db->setVal("short_title", $this->mno_id);
			$to = strip_tags($this->package_functions->getOptions('TECH_BCC_EMAIL', $this->system_package));

			$from = strip_tags($this->db->setVal("email", $this->mno_id));
			if ($from == '') {
				$from = strip_tags($this->db->setVal("email", 'ADMIN'));
			}
			$email_content = $this->db->getEmailTemplate('ZABBIX_NOC', $this->system_package, 'MNO', $this->mno_id);
			$a = $email_content[0]['text_details'];
			$subject = $email_content[0]['title'];
			$operator_name = $this->db->getValueAsf("SELECT g.product_name AS f FROM admin_product g WHERE g.product_code='$this->system_package'");
			$vars = array(
				'{$operator_name}' => $operator_name,
				'{$icomme_number}' => $this->icomme_number,
				'{$url}' => $decodedzabbixCreate['url'],
				'{$property_name}' => CommonFunctions::clean($value['name']),
				'{$request}' => json_encode($req),
				'{$response}' => urldecode($decodedzabbixCreate['Description']),
				'{$status_code}' => $decodedzabbixCreate['status_code'],
				'{$date_time}' => date("Y-m-d H:i:s")
			);

			$message_full = strtr($a, $vars);

			$email_send_method = $this->package_functions->getSectionType("EMAIL_SYSTEM", $this->system_package);
			
			if ($this->provision == 1) {
				require_once '../../src/email/' . $email_send_method . '/index.php';
			}else{
				include_once 'src/email/' . $email_send_method . '/index.php';
			}

			$emailTemplateType = $this->package_functions->getSectionType('EMAIL_TEMPLATE', $this->system_package);
			$cunst_var = array();
			if ($emailTemplateType == 'child') {
				$cunst_var['template'] = $this->package_functions->getOptions('EMAIL_TEMPLATE', $this->parent_product);
			} elseif ($emailTemplateType == 'owen') {
				$cunst_var['template'] = $this->package_functions->getOptions('EMAIL_TEMPLATE', $this->system_package);
			} elseif (strlen($emailTemplateType) > 0) {
				$cunst_var['template'] = $emailTemplateType;
			} else {
				$cunst_var['template'] = $this->package_functions->getOptions('EMAIL_TEMPLATE', $this->system_package);
			}
			$mail_obj = new email($cunst_var);

			$mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);
		}

		return $status_code;
	}
}
