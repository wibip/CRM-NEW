ALTER TABLE `admin_access_modules` 
ADD COLUMN `user_group` VARCHAR(70) DEFAULT NULL AFTER `user_type`;

UPDATE admin_access_modules SET user_group='super_admin' WHERE user_type='SADMIN';
UPDATE admin_access_modules SET user_group='admin' WHERE user_type='ADMIN';
UPDATE admin_access_modules SET user_group='operation' WHERE user_type='MNO';
UPDATE admin_access_modules SET user_group='sales_manager' WHERE user_type='SMAN';
UPDATE admin_access_modules SET user_group='ordering_agent' WHERE user_type='PROVISIONING';