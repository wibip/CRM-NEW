CREATE TABLE `crm_opr_ip_scope` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `range_from` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `range_to` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_network` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `netmask` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `property_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,   
  `peer_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,   
  `firewall_public_net` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `firewall_public_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `firewall_vlan50_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `firewall_serial_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `vlan_static_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `underlay_net` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `vlan_dhcp_ap_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `status` int(2) DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `crm_opr_ip_scope`  
ADD CONSTRAINT `crm_opr_ip_scope_ibfk_1` 
FOREIGN KEY (`operator_code`) REFERENCES `crm_operators` (`operator_code`) ON DELETE CASCADE; 