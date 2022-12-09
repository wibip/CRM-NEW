ALTER TABLE `crm_clients` 
DROP FOREIGN KEY `crm_clients_ibfk_1`; 

ALTER TABLE `crm_clients`  
ADD CONSTRAINT `crm_clients_ibfk_1` 
    FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE; 