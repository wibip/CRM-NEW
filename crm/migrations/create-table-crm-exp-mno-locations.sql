CREATE TABLE `crm_exp_mno_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) DEFAULT NULL,
  `location_unique` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_enable` int(1) NOT NULL DEFAULt 1,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `crm_exp_mno_locations`  
ADD CONSTRAINT `crm_exp_mno_locations_ibfk_1` 
    FOREIGN KEY (`crm_id`) REFERENCES `exp_crm` (`id`) ON DELETE CASCADE; 
