
/*Add property menu*/
INSERT INTO `admin_access_modules` (`module_name`,`name_group`,`user_type`,`user_group`,`is_enable`,`menu_item`,`order`,`main_module`,`main_module_order`,`create_date`,`create_user`) 
VALUES ('properties','Properties','SADMIN','super_admin',1,1,1,'Property Info',5,'2023-01-23 16:14:26','admin'),
('property_additional','Property Additional Info','SADMIN','super_admin',1,1,2,'Property Info',5,'2023-01-23 16:14:26','admin'),
('properties','Properties','ADMIN','admin',1,1,1,'Property Info',5,'2023-01-23 16:14:26','admin'),
('property_additional','Property Additional Info','ADMIN','admin',1,1,2,'Property Info',5,'2023-01-23 16:14:26','admin'),
('properties','Properties','MNO','operation',1,1,1,'Property Info',5,'2023-01-23 16:14:26','admin'),
('property_additional','Property Additional Info','MNO','operation',1,1,2,'Property Info',5,'2023-01-23 16:14:26','admin'),
('properties','Properties','SMAN','sales_manager',1,1,1,'Property Info',5,'2023-01-23 16:14:26','admin'),
('property_additional','Property Additional Info','SMAN','sales_manager',1,1,2,'Property Info',5,'2023-01-23 16:14:26','admin');



UPDATE admin_product_controls SET options='["operators","operator_config","operator_regions","operator_realms","operator_ipscope","property_addressing","operation_list","central_db","api_profile","config","logs","profile","properties","property_additional", "crm","users"]' WHERE product_code='GENERIC_SADMIN_001' AND feature_code='ALLOWED_PAGE';
UPDATE admin_product_controls SET options='["operators","operator_config","operator_regions","operator_realms","operator_ipscope","property_addressing","operation_list","central_db","api_profile","config","users","logs","profile","properties","property_additional"]' WHERE product_code='GENERIC_ADMIN_001' AND feature_code='ALLOWED_PAGE';
UPDATE admin_product_controls SET options='["users","properties","property_additional","crm","profile"]' WHERE product_code='GENARIC_MNO_001' AND feature_code='ALLOWED_PAGE';
UPDATE admin_product_controls SET options='["users","properties","property_additional","crm","profile"]' WHERE product_code='GENERIC_SMAN_001' AND feature_code='ALLOWED_PAGE';

UPDATE admin_access_roles_modules SET user_group='super_admin'WHERE access_role='SADMIN001';
UPDATE admin_access_roles_modules SET user_group='admin'WHERE access_role='admin';
UPDATE admin_access_roles_modules SET user_group='sales_manager'WHERE access_role='1674137586salesmanagerSMAN';
UPDATE admin_access_roles_modules SET user_group='operation'WHERE access_role='operation';
UPDATE admin_access_roles_modules SET user_group='ordering_agent'WHERE access_role='client';


INSERT INTO `admin_access_roles_modules` (`access_role`,`user_group`,`module_name`,`distributor`,`module_type`,`create_user`,`create_date`) VALUES 
('SADMIN001','super_admin','property_additional','SADMIN','default','test_u3444','2023-04-05 14:10:42'),
('admin','admin','property_additional','ADMIN','default','test_u3444','2023-04-05 14:10:42'),
('operation','operation','property_additional','MNO267','default','test_u3444','2023-04-05 14:10:42'),
('1674137586salesmanagerSMAN','sales_manager','property_additional','SMAN','default','test_u3444','2023-04-05 14:10:42');



/*Add Order Menu*/

UPDATE admin_access_modules SET main_module_order=3 WHERE module_name='crm';

INSERT INTO `admin_access_modules` (`module_name`,`name_group`,`user_type`,`user_group`,`is_enable`,`menu_item`,`order`,`main_module`,`main_module_order`,`create_date`,`create_user`) 
VALUES ('order_templates','Order Templates','SADMIN','super_admin',1,1,2,'Orders',3,'2023-04-20 07:14:26','admin');

UPDATE admin_product_controls SET options='["operators","operator_config","operator_regions","operator_realms","operator_ipscope","property_addressing","operation_list","central_db","api_profile","config","logs","profile","properties","property_additional", "crm","order_templates","users"]' WHERE product_code='GENERIC_SADMIN_001' AND feature_code='ALLOWED_PAGE';

INSERT INTO `admin_access_roles_modules` (`access_role`,`user_group`,`module_name`,`distributor`,`module_type`,`create_user`,`create_date`) VALUES 
('SADMIN001','super_admin','order_templates','SADMIN','default','test_u3444','2023-04-05 14:10:42');