CREATE TABLE `crm_user_hierarchy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11)  DEFAULT NULL,
  `is_enable` int(1) DEFAULT NULL,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `crm_user_hierarchy`  
ADD CONSTRAINT `crm_user_hierarchy_ibfk_1` 
FOREIGN KEY (`operator_id`) REFERENCES `exp_mno` (`mno_id`) ON DELETE CASCADE; 

ALTER TABLE `crm_user_hierarchy`  
ADD CONSTRAINT `crm_user_hierarchy_ibfk_2` 
FOREIGN KEY (`parent_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE; 

ALTER TABLE `crm_user_hierarchy`  
ADD CONSTRAINT `crm_user_hierarchy_ibfk_3` 
FOREIGN KEY (`category_id`) REFERENCES `crm_user_categories` (`id`) ON DELETE CASCADE; 




INSERT INTO `crm_user_hierarchy` (`operator_id`,`category_id`,`parent_id`,`is_enable`,`create_date`,`create_user`) 
VALUES ('MNO267',2,3443,1,'2023-02-08 16:14:26','admin');