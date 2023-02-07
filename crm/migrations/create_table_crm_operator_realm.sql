CREATE TABLE `crm_opr_realm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `range_from` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `range_to` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `service_type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,  
  `region` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `crm_opr_realm`  
ADD CONSTRAINT `crm_opr_realm_ibfk_1` 
FOREIGN KEY (`operator_code`) REFERENCES `crm_operators` (`operator_code`) ON DELETE CASCADE; 