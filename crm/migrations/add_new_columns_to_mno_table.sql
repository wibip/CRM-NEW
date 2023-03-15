ALTER TABLE `exp_mno` 
ADD COLUMN `operator_code` VARCHAR(70) DEFAULT NULL AFTER `unique_id`,
ADD COLUMN `operator_name` VARCHAR(70) DEFAULT NULL AFTER `operator_code`,
ADD COLUMN `sub_operator_code` VARCHAR(70) DEFAULT NULL AFTER `operator_name`,
ADD COLUMN `sub_operator_name` VARCHAR(70) DEFAULT NULL AFTER `sub_operator_code`;

ALTER TABLE `admin_users` 
ADD COLUMN `address` VARCHAR(70) DEFAULT NULL AFTER `email`,
ADD COLUMN `country` VARCHAR(70) DEFAULT NULL AFTER `address`,
ADD COLUMN `state_region` VARCHAR(70) DEFAULT NULL AFTER `country`,
ADD COLUMN `zip` VARCHAR(10) DEFAULT NULL AFTER `state_region`;


