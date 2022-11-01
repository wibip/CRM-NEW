<?php


class clientUserModel
{

    private $connection;

    public function __construct()
    {
        require_once dirname(__FILE__) . '/../classes/dbClass.php';

        $connect = new db_functions();

        //$connect = new Local_DB($logConnection);

        $this->connection = $connect;
    }

    public function createClient(crm_clients $data)
    {
        $UserName = $data->getUserName();
        $Password = $data->getPassword();
        $AccessRole = $data->getAccessRole();
        $UserType = $data->getUserType();
        $UserDistributor = $data->getUserDistributor();
        $FullName = $this->connection->escapeDB($data->getFullName());
        $Email = $data->getEmail();
        $Language = $data->getLanguage();
        $Mobile = $data->getMobile();
        $isEnable = $data->getisEnable();
        $VerificationNumber = $data->getVerificationNumber();
        $CreateUser = $data->getCreateUser();


        $q = "INSERT INTO crm_clients
		(`user_name`, `password`, access_role, user_type, user_distributor, full_name, email, `language`, mobile, verification_number, is_enable, create_date,create_user)
		VALUES ('$UserName',PASSWORD('$Password'),'$AccessRole','$UserType','$UserDistributor','$FullName','$Email','$Language','$Mobile'," . (($VerificationNumber == '') ? "NULL" : ("'" . $VerificationNumber . "'")) . ",'$isEnable',now(),'$CreateUser')";



        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }

    public function createArchiveClient(crm_clients $data)
    {
        $Archive_UserName = $data->Archive_UserName;
        $id = $data->getId();

        $q = "INSERT INTO `crm_clients_archive` (`user_name`,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
					SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$Archive_UserName',NOW(),last_update,'update'
                    FROM `crm_clients` WHERE id='$id'";

        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }

    public function getClient($id)
    {
        $q = sprintf("SELECT *
                      FROM crm_clients WHERE id =%s",  $this->connection->GetSQLValueString($id, "text"));
        $data = $this->connection->selectDB($q);

        require_once dirname(__FILE__) . '/../entity/crm_clients.php';

        $data_array = array();
        foreach ($data['data'] as $row) {
            $row_data = new crm_clients(
                $row['id'],
                $row['user_name'],
                '',
                $row['access_role'],
                $row['user_type'],
                $row['user_distributor'],
                $row['full_name'],
                $row['email'],
                $row['language'],
                $row['timezone'],
                $row['mobile'],
                $row['verification_number'],
                $row['is_enable'],
                $row['global_user_id'],
                $row['create_date'],
                $row['create_user'],
                $row['last_update'],
                $row['activation_date']
            );
            array_push($data_array, $row_data);
        }

        return $data_array;
    }

    public function deleteClient($id)
    {
        $q = "DELETE FROM `crm_clients`  WHERE `id` = '$id'";
        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }
// user status change
    public function changeStatusClient(crm_clients $data)
    {
        $Id = $data->getId();
        $IsEnable = $data->getisEnable();

        $q = "UPDATE  `crm_clients` SET `is_enable` = '$IsEnable' WHERE `id` = '$Id'";

        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }

    public function modifyClient(crm_clients $data)
    {
        $Id = $data->getId();
        $getUserName = $data->getUserName();
        $getPassword = $data->getPassword();
        $getAccessRole = $data->getAccessRole();
        $getUserType = $data->getUserType();
        $getUserDistributor = $data->getUserDistributor();
        $getFullName = $data->getFullName();
        $getEmail = $data->getEmail();
        $getLanguage = $data->getLanguage();
        $getMobile = $data->getMobile();
        $getVerificationNumber = $data->getVerificationNumber();
        $getisEnable = $data->getisEnable();
        $getGlobalUserId = $data->getGlobalUserId();


        $q1 = '';
        if (!empty($getUserName)) {
            $q1 .= ",`user_name` = '$getUserName'";
        }
        if (!empty($getPassword)) {
            $q1 .= ",`password` = '$getPassword'";
        }
        if (!empty($getAccessRole)) {
            $q1 .= ",`access_role` = '$getAccessRole'";
        }
        if (!empty($getUserType)) {
            $q1 .= ",`user_type` = '$getUserType'";
        }
        if (!empty($getUserDistributor)) {
            $q1 .= ",`user_distributor` = '$getUserDistributor'";
        }
        if (!empty($getFullName)) {
            $q1 .= ",`full_name` = '$getFullName'";
        }
        if (!empty($getEmail)) {
            $q1 .= ",`email` = '$getEmail'";
        }
        if (!empty($getLanguage)) {
            $q1 .= ",`language` = '$getLanguage'";
        }
        if (!empty($getMobile)) {
            $q1 .= ",`mobile` = '$getMobile'";
        }
        if (!empty($getVerificationNumber)) {
            $q1 .= ",`verification_number` = '$getVerificationNumber'";
        }
        if (!empty($getisEnable)) {
            $q1 .= ",`is_enable` = '$getisEnable'";
        }
        if (!empty($getGlobalUserId)) {
            $q1 .= ",`global_user_id` = '$getGlobalUserId'";
        }
        $q = "UPDATE `crm_clients` SET ";
        $q .= ltrim($q1, ',');
        $q .= " WHERE `id` = '$Id'";

        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }

    public function modifyPassword(crm_clients $data)
    {
        $Id = $data->getId();
        $Password = $data->getPassword();

        $q = sprintf("update crm_clients set password=%s where id=%s", $this->connection->GetSQLValueString($Password, "text"), $this->connection->GetSQLValueString($Id, "int"));
        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }


    public function getLocalPassword($password)
    {

        $q = "SELECT PASSWORD('$password') as f";
        $query_results = $this->connection->select1DB($q);

        return $query_results['f'];
    }



    public function getAutoIncrement()
    {

        $q = "SHOW TABLE STATUS LIKE 'crm_clients'";
        $data = $this->connection->selectDB($q);

        return $data[data][0]['Auto_increment'];
    }


    public function loginUser_Data($username)
    {
        require_once dirname(__FILE__) . '/../DTO/User.php';
        $row_data = new User();

        $q = sprintf("SELECT * FROM crm_clients WHERE user_name =%s",  $this->connection->GetSQLValueString($username, "text"));

        $data = $this->connection->selectDB($q);

        foreach ($data['data'] as $row) {

            $user_distributor = $row['user_distributor'];
            $user_type = $row['user_type'];

            $row_data->id = $row['id'];
            $row_data->user_name = $row['user_name'];
            $row_data->access_role = $row['access_role'];
            $row_data->user_type = $row['user_type'];
            $row_data->user_distributor = $row['user_distributor'];
            $row_data->full_name = $row['full_name'];
            $row_data->email = $row['email'];
            $row_data->language = $row['language'];
            $row_data->mobile = $row['mobile'];
            $row_data->verification_number = $row['verification_number'];
            $row_data->is_enable = $row['is_enable'];
            $row_data->global_user_id = $row['global_user_id'];
            $row_data->create_date = $row['create_date'];
            $row_data->create_user = $row['create_user'];
            $row_data->last_update = $row['last_update'];
            $row_data->activation_date = $row['activation_date'];
        }

        if ($user_type == "MNO" || $user_type == "ADMIN" || $user_type == "SUPPORT" || $user_type == "TECH" || $user_type == "SALES") {
            $q1 = "SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'";
        } else if ($user_type == "MVNO_ADMIN") {
            $q1 = "SELECT `system_package` AS f FROM `mno_distributor_parent` WHERE `parent_id`='$user_distributor'";
        } else if ($user_type == "MVNO" || $user_type == "MVNE" || $user_type == "MVNA") {
            $q1 = "SELECT `system_package` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'";
        }



        $query_results1 = $this->connection->select1DB($q1);

        $row_data->system_package = $query_results1['f'];


        return $row_data;
    }

    //get distributor id
    public function get_mnoid($user_distributor)
    {
        $q = "SELECT mno_id f FROM exp_mno_distributor where distributor_code = '$user_distributor'";
        $query_results = $this->connection->select1DB($q);

        return $query_results['f'];
    }

    //get random password
    function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    //get active useres(users.php)
    function get_activeClients()
    {
        $data_array = [];
        try {
            $query = "SELECT au.id,au.user_name,au.full_name, au.access_role, au.user_type, au.user_distributor, au.email,au.is_enable,au.create_user
                  FROM crm_clients au ";
            $data_array = $this->connection->selectDB($query);
            return $data_array;
        } catch(Exception $e) {
            return $data_array;
        }
            
    }


     //get api useres(users.php)
     function get_apiUseres()
     {
        
        
             $q = "SELECT *
             FROM crm_clients  where user_type = 'API'";
         
 
 
         $data = $this->connection->selectDB($q);
 
         $data_array = array();
         foreach ($data['data'] as $row) {
 
             $row_data = new User();
 
             $row_data->id = $row['id'];
             $row_data->user_name = $row['user_name'];
             $row_data->full_name = $row['full_name'];
             $row_data->timezone = $row['timezone'];
             
             $row_data->email = $row['email'];
             
 
             array_push($data_array, $row_data);
         }
 
 
       
         return $data_array;
     }

    // user log update
    function userUpdateLog($user_id, $action_type, $action_by)
    {

        $q = "INSERT INTO `crm_clients_update` (
             `user_name`,
             `password`,
             `access_role`,
             `user_type`,
             `user_distributor`,
             `full_name`,
             `email`,
             `language`,
             `mobile`,
             `is_enable`,
             `create_date`,
             `create_user`,
             `update_type`,
             `update_by`,
             `update_date`)
             (SELECT
             `user_name`,
             `password`,
             `access_role`,
             `user_type`,
             `user_distributor`,
             `full_name`,
             `email`,
             `language`,
             `mobile`,
             `is_enable`,
             `create_date`,
             `create_user`,
             '$action_type',
             '$action_by',
             NOW()
             FROM
             `crm_clients`
             WHERE id='$user_id')";

        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }

    //get unique key 
    function getUnique_key()
    {
        $q = "SELECT REPLACE(UUID(),'-','') as f";
        $query_results = $this->connection->select1DB($q);

        return $query_results['f'];
    }

    // admin reset password change status
    public function changeStatusAdminResPass(User $data)
    {
        $change_status = $data->change_status;
        $search_status = $data->search_status;
        $user_name = $data->user_name;

        $q = "UPDATE admin_reset_password SET status = '$change_status' WHERE user_name='$user_name' AND status='$search_status'";

        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }

    // admin reset password change status
    public function createAdminResPass(User $data)
    {
        
        $user_name = $data->user_name;

        $q = "INSERT INTO admin_reset_password (user_name, status, security_key,unique_key, ip, create_date) VALUES('$user_name', 'pending', '$encript_resetkey','$unique_key', '$ip', NOW())";

        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }


}
