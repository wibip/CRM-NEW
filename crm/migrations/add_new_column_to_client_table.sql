SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `crm_clients` 
ADD COLUMN `api_profile` INT(11) NOT NULL AFTER `user_id`, 
ADD FOREIGN KEY fk_crm_clients_table_user_id(user_id) REFERENCES exp_locations_ap_controller(id) ON DELETE CASCADE; 