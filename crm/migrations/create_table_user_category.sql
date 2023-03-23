CREATE TABLE `crm_user_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator_id` int(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_category` varchar(20)  DEFAULT NULL,
  `is_enable` int(1) DEFAULT NULL,
  `create_user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `last_updae` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `crm_user_categories`  
ADD CONSTRAINT `crm_user_categories_ibfk_1` 
FOREIGN KEY (`operator_id`) REFERENCES `exp_mno` (`id`) ON DELETE CASCADE; 


INSERT INTO `crm_user_categories` (`operator_id`,`category`,`parent_category`,`is_enable`,`create_user`,`create_date`) 
VALUES (267,'Default','Default',1,'admin','2023-03-23 05:15:34'),
(267,'Regional','Default',1,'admin','2023-03-23 05:15:34'),
(267,'Provincial','Default',1,'admin','2023-03-23 05:15:34'),
(324,'Default','Default',1,'admin','2023-03-23 05:15:34'),
(324,'Regional','Default',1,'admin','2023-03-23 05:15:34'),
(324,'Provincial','Default',1,'admin','2023-03-23 05:15:34');