CREATE TABLE `crm_operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operator_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_operator_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_operator_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `environment` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `operatros_codes` UNIQUE(`operator_code`,`sub_operator_code`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

