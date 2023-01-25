ALTER TABLE `admin_access_roles` 
ADD COLUMN `oid_group` VARCHAR(70) DEFAULT NULL AFTER `access_role`;