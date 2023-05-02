CREATE TABLE `crm_opr_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vertical` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `property_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `short_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,   
  `realm` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,   
  `property_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `clli` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `node_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `model_number` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `host_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `ip` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `vlan_netmask_gateway` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `crm_opr_property`  
ADD CONSTRAINT `crm_opr_property_ibfk_1` 
FOREIGN KEY (`operator_code`) REFERENCES `crm_operators` (`operator_code`) ON DELETE CASCADE; 