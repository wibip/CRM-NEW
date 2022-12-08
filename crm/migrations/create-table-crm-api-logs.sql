CREATE TABLE `crm_api_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `section` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_type` enum('ERROR','SUCCESS','OTHER') COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `response` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_code` int(4) DEFAULT NULL,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
