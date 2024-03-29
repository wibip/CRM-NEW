<?php


class userMainModel
{

    private $connection;

    public function __construct()
    {
        require_once dirname(__FILE__) . '/../db/dbTasks.php';

        $connect = new dbTasks();

        //$connect = new Local_DB($logConnection);

        $this->connection = $connect;
    }

    public function createUser(admin_users $data)
    {
        $UserName = $data->UserName;
        $Password = $data->Password;
        $AccessRole = $data->AccessRole;
        $UserType = $data->UserType;
        $UserDistributor = $data->UserDistributor;
        $FullName = $this->connection->escapeDB($data->FullName);
        $Email = $data->Email;
        $Language = $data->Language;
        $Mobile = $data->Mobile;
        $isEnable = $data->isEnable;
        $VerificationNumber = $data->VerificationNumber;
        $CreateUser = $data->CreateUser;

        if(empty($VerificationNumber)){
            $VerificationNumber = 'NULL';
        }

        $products=array(
            'user_name'=> $UserName,
            'password'=> $Password, 
            'access_role'=> $AccessRole,
            'user_type'=> $UserType,
            'user_distributor'=> $UserDistributor,
            'full_name'=> $FullName, 
            'email'=> $Email,
            'language'=> $Language,
            'mobile'=> $Mobile,
            'verification_number'=> $VerificationNumber,
            'is_enable'=> $isEnable,
            'create_date'=> date("Y-m-d h:i:s"),
            'create_user'=> $CreateUser
          );
       
        $inserted=$this->connection->insertData('admin_users',$products);

        if($inserted=='1'){
            return true;
        } else {
            return false;
        }




    }

    public function createArchiveUser(admin_users $data)
    {
        $Archive_UserName = $data->Archive_UserName;
        $id = $data->Id;

        $q = "INSERT INTO `admin_users_archive` (`id`,`user_name`,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
					SELECT `id`,`user_name`,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$Archive_UserName',NOW(),last_update,'update'
                    FROM `admin_users` WHERE id='$id'";

        $query_results = $this->connection->execDB($q);
        
        if($query_results=='1'){
            return true;
        } else {
            return false;
        }
    }

    public function getUser($id)
    {

        $q = sprintf("SELECT *
                      FROM admin_users WHERE id =%s",  $this->connection->GetSQLValueString($id, "text"));


        $data = $this->connection->selectDB($q);

        require_once dirname(__FILE__) . '/../entity/admin_users.php';

        $data_array = array();
        foreach ($data['data'] as $row) {
            $row_data = new admin_users(
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

    public function deleteUser($id)
    {
 
        $arr=array(
            'id'=> $id,
          );

        $deleted=$this->connection->deleteData('admin_users',$arr);

        if($deleted=='1'){
            return true;
        } else {
            return false;
        }
    }
// user status change
    public function changeStatusUser(admin_users $data)
    {
        $Id = $data->id;
        $IsEnable = $data->isEnable;

          $update_arr=array(
            'is_enable'=> $IsEnable,
          );

          $where_arr=array(
            'id'=> $Id,
          );


        $updated=$this->connection->updateData('admin_users',$update_arr,$where_arr);

        if($updated=='1'){
            return true;
        } else {
            return false;
        }
    }

    public function modifyUser(admin_users $data)
    {
        $Id = $data->id;
        $getUserName = $data->UserName;
        $getPassword = $data->Password;
        $getAccessRole = $data->AccessRole;
        $getUserType = $data->UserType;
        $getUserDistributor = $data->UserDistributor;
        $getFullName = $data->FullName;
        $getEmail = $data->Email;
        $getLanguage = $data->Language;
        $getMobile = $data->Mobile;
        $getVerificationNumber = $data->VerificationNumber;
        $getisEnable = $data->isEnable;
        $getGlobalUserId = $data->GlobalUserId;


        $update_arr=array();

        if (!empty($getUserName)) {
            $update_arr['user_name'] = $getUserName;
        }
        if (!empty($getPassword)) {
            $update_arr['password'] = $getPassword;
        }
        if (!empty($getAccessRole)) {
            $update_arr['access_role'] = $getAccessRole;
        }
        if (!empty($getUserType)) {
            $update_arr['user_type'] = $getUserType;
        }
        if (!empty($getUserDistributor)) {
            $update_arr['user_distributor'] = $getUserDistributor;
        }
        if (!empty($getFullName)) {
            $update_arr['full_name'] = $getFullName;
        }
        if (!empty($getEmail)) {
            $update_arr['email'] = $getEmail;
        }
        if (!empty($getLanguage)) {
            $update_arr['language'] = $getLanguage;
        }
        if (!empty($getMobile)) {
            $update_arr['mobile'] = $getMobile;
        }
        if (!empty($getVerificationNumber)) {
            $update_arr['verification_number'] = $getVerificationNumber;
        }
        if (!empty($getisEnable)) {
            $update_arr['is_enable'] = $getisEnable;
        }
        if (!empty($getGlobalUserId)) {
            $update_arr['global_user_id'] = $getGlobalUserId;
        }


          $where_arr=array(
            'id'=> $Id,
          );

        $updated=$this->connection->updateData('admin_users',$update_arr,$where_arr);

        if($updated=='1'){
            return true;
        } else {
            return false;
        }
    }

    public function modifyPassword(admin_users $data)
    {
        $Id = $data->getId();
        $Password = $data->getPassword();

        $q = sprintf("update admin_users set password=%s where id=%s", $this->connection->GetSQLValueString($Password, "text"), $this->connection->GetSQLValueString($Id, "int"));
        $query_results = $this->connection->execDB($q);
        if (empty($query_results)) {
            return true;
        } else {
            return false;
        }
    }

    public function loginUser(admin_users $data)
    {
        $username = $data->getUserName();

        $q = sprintf("SELECT *
                      FROM admin_users WHERE user_name =%s",  $this->connection->GetSQLValueString($username, "text"));


        $data = $this->connection->selectDB($q);


        $data_array = array();
        foreach ($data['data'] as $row) {
            $row_data = new admin_users(
                $row['id'],
                $row['user_name'],
                $row['password'],
                $row['access_role'],
                $row['user_type'],
                $row['user_distributor'],
                $row['full_name'],
                $row['email'],
                $row['language'],
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

    public function getLocalPassword($password)
    {

        $q = "SELECT PASSWORD('$password') as f";
        $query_results = $this->connection->select1DB($q);

        return $query_results['f'];
    }



    public function getAutoIncrement()
    {

        $q = "SHOW TABLE STATUS LIKE 'admin_users'";
        $data = $this->connection->selectDB($q);

        return $data[data][0]['Auto_increment'];
    }


    public function loginUser_Data($username)
    {
        require_once dirname(__FILE__) . '/../DTO/User.php';
        $row_data = new User();

        $q = sprintf("SELECT * FROM admin_users WHERE user_name =%s",  $this->connection->GetSQLValueString($username, "text"));

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
    function get_activeUseres(User $data)
    {
        $user_type = $data->user_type;
        $user_name = $data->user_name;

        if ($user_type == 'ADMIN') {

            $q = "SELECT au.id,au.user_name,au.full_name, au.access_role, au.user_type, au.user_distributor, au.email,au.is_enable,au.create_user
                            ,IF(!ISNULL(aar.description),aar.description,IF(au.access_role='admin','Admin','')) AS description
                            FROM admin_users au LEFT JOIN admin_access_roles aar ON au.access_role = aar.access_role
                            WHERE user_type = '$user_type' AND user_name<>'admin'";
        } elseif ($user_type == 'SUPPORT') {
            $user_distributor = $data->user_distributor;

            $q = "SELECT a.id,a.user_name,a.full_name, a.access_role, a.user_type, a.user_distributor, a.email,a.is_enable ,a.create_user
              ,IF(!ISNULL(aar.description),aar.description,IF(a.access_role='admin','Admin','')) AS description
                FROM admin_users a LEFT JOIN admin_access_roles aar ON a.access_role=aar.access_role, `admin_access_roles_modules` b
                WHERE user_distributor = '$user_distributor' AND a.`access_role`=b.`access_role` AND b.`module_name`='support' OR user_distributor = '$user_distributor' AND a.`user_type`='SUPPORT' AND a.`access_role`<>'admin' AND user_name<>'$user_name'
                GROUP BY `user_name`";
        } else {
            $user_distributor = $data->user_distributor;

            $q = "SELECT au.id,au.user_name,au.full_name, au.access_role, au.user_type, au.user_distributor, au.email,au.is_enable,au.create_user
            ,IF(!ISNULL(aar.description),aar.description,IF(au.access_role='admin','Admin','')) AS description
            FROM admin_users au LEFT JOIN admin_access_roles aar ON au.access_role = aar.access_role where user_type IN ('$user_type','SUPPORT','TECH','ordering_agent') AND user_distributor = '$user_distributor' AND user_name<>'$user_name'";
        }


        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row) {

            $row_data = new User();

            $row_data->id = $row['id'];
            $row_data->user_name = $row['user_name'];
            $row_data->full_name = $row['full_name'];
            $row_data->access_role = $row['access_role'];
            $row_data->description = $row['description'];
            $row_data->user_type = $row['user_type'];
            $row_data->user_distributor = $row['user_distributor'];
            $row_data->is_enable = $row['is_enable'];
            $row_data->email = $row['email'];
            $row_data->create_user = $row['create_user'];

            array_push($data_array, $row_data);
        }


      
        return $data_array;
    }

    // user log update
    function userUpdateLog($user_id, $action_type, $action_by)
    {

        $q = "INSERT INTO `admin_users_update` (
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
             `admin_users`
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
