--- ADD new Page -----

--- Add new module ---
INSERT INTO `admin_access_modules` (`module_name`,`name_group`,`user_type`,`is_enable`,`menu_item`,`order`,`main_module`,`main_module_order`,`create_date`,`create_user`,`last_update`) 
VALUES 
('operators','Operators','ADMIN',1,1,1,'Admin Config',2,'2023-02-08 16:14:26','admin','2023-02-080 06:36:35'),
('operator_config','Operator Config','ADMIN',1,1,2,'Admin Config',2,'2023-02-08 16:14:26','admin','2023-02-080 06:36:35'),
('operator_regions','Operator Region','ADMIN',1,1,3,'Admin Config',2,'2023-02-08 16:14:26','admin','2023-02-080 06:36:35'),
('operator_realms','Operator Realm Scope','ADMIN',1,1,4,'Admin Config',2,'2023-02-08 16:14:26','admin','2023-02-080 06:36:35'),
('operator_ipscope','Operator IP Scope','ADMIN',1,1,5,'Admin Config',2,'2023-02-08 16:14:26','admin','2023-02-080 06:36:35'),
('property_addressing','Property Addressing','ADMIN',1,1,6,'Admin Config',2,'2023-02-08 16:14:26','admin','2023-02-080 06:36:35');

---- Update allow pages-----
UPDATE admin_product_controls SET options='["operators","operator_config","operator_regions","operator_realms","operator_ipscope","property_addressing","operations","operation_list","central_db","api_profile","config","users","logs","profile","clients","properties", "crm","change_portal"]' 
WHERE product_code='GENERIC_ADMIN_001' AND feature_code='ALLOWED_PAGE';

-----Add new record for current using pages---
INSERT INTO `admin_access_roles_modules` (`access_role`,`module_name`,`distributor`,`module_type`,`create_user`,`create_date`,`last_update`) 
VALUES ('SADMIN001','operators','ADMIN','default','admin','2023-02-08 15:53:32','2023-02-08 04:25:45'),
('SADMIN001','operator_config','ADMIN','default','admin','2023-02-08 15:53:32','2023-02-08 04:25:45'),
('SADMIN001','operator_regions','ADMIN','default','admin','2023-02-08 15:53:32','2023-02-08 04:25:45'),
('SADMIN001','operator_realms','ADMIN','default','admin','2023-02-08 15:53:32','2023-02-08 04:25:45'),
('SADMIN001','operator_ipscope','ADMIN','default','admin','2023-02-08 15:53:32','2023-02-08 04:25:45'),
('SADMIN001','property_addressing','ADMIN','default','admin','2023-02-08 15:53:32','2023-02-08 04:25:45');
