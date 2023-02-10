
INSERT INTO `admin_access_modules` (`module_name`,`name_group`,`user_type`,`is_enable`,`menu_item`,`order`,`main_module`,`main_module_order`,`create_date`,`create_user`,`last_update`) 
VALUES 
('properties','Properties','SADMIN',1,1,1,'Admin Config',5,'2023-02-08 16:14:26','admin','2023-02-080 06:36:35');

UPDATE admin_access_modules SET `main_module_order`=1 WHERE main_module='Users';
UPDATE admin_access_modules SET `main_module_order`=2 WHERE main_module='Admin Config';
UPDATE admin_access_modules SET `main_module_order`=3 WHERE main_module='Operations';
UPDATE admin_access_modules SET `main_module_order`=4 WHERE main_module='Clients';
UPDATE admin_access_modules SET `main_module_order`=5 WHERE main_module='Properties';
UPDATE admin_access_modules SET `main_module_order`=6 WHERE main_module='CRM';
UPDATE admin_access_modules SET `main_module_order`=7 WHERE main_module='Configuration';
UPDATE admin_access_modules SET `main_module_order`=8 WHERE main_module='Logs';

DELETE FROM admin_access_modules WHERE user_type='ADMIN' AND main_module='Admin Config';

INSERT INTO `admin_access_roles_modules` (`access_role`,`module_name`,`distributor`,`module_type`,`create_user`,`create_date`,`last_update`) 
VALUES ('SADMIN001','properties','SADMIN','default','admin','2023-02-08 15:53:32','2023-02-08 04:25:45');