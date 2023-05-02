CREATE TABLE `crm_opr_configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `service_type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qos_profile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `qos_profile_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,   
  `vsz_mapping` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,   
  `wag_magic` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `product_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `group` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `account_template` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `service_profile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `business_prefix` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `business_id_from` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_id_to` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `status` int(2) DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `crm_opr_configurations`  
ADD CONSTRAINT `crm_opr_configurations_ibfk_1` 
FOREIGN KEY (`operator_code`) REFERENCES `crm_operators` (`operator_code`) ON DELETE CASCADE; 