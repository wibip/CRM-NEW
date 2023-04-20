ALTER TABLE `admin_access_roles_modules` 
ADD COLUMN `user_group` VARCHAR(35) DEFAULT NULL AFTER `access_role`;



UPDATE admin_access_roles_modules SET `user_group`='admin' WHERE id=1256;