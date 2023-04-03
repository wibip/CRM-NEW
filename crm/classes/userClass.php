<?php

require_once __DIR__.'/dbClass.php';
class Users{
    private $db;
	public function  __construct(){
		$this->db = new db_functions();
	}

    public function getUser($id) {
        $sql = "SELECT * FROM admin_users WHERE id =$id";
        $data = $this->db->selectDB($sql);
        return $data;
    }

    public function get_activeUseres($user_name,$user_superior_level) {
        $q = "SELECT au.id,au.user_name,au.full_name, au.group, au.email,au.is_enable,au.create_user
                        ,IF(!ISNULL(aar.description),aar.description,IF(au.access_role='admin','Admin','')) AS description
                        FROM admin_users au LEFT JOIN admin_access_roles aar ON au.access_role = aar.access_role";
        if($user_superior_level > 2){
            $q .= " WHERE au.create_user='$user_name'";
        }
// echo $q;
        $data = $this->db->selectDB($q);
        return $data;
    }

    public function getAllOperatorUsers($active=false){
        $sqlOperators = "SELECT id,full_name,user_distributor FROM admin_users WHERE `group`='operation' AND is_enable=1";
        if($active == true){
            $sqlOperators .= " AND is_enable=1";
        }
        $result =  $this->db->selectDB($sqlOperators);
        return $result;
    }

    public function getAllOperators() {
        $sqlOperators = "SELECT mno_id,mno_description FROM exp_mno WHERE mno_id NOT IN ('SADMIN', 'ADMIN', 'SMAN' )";
        $result =  $this->db->selectDB($sqlOperators);
        return $result;
    }

    public function userDistributors($userGroup) {
        $user_distributor = null;
        switch($userGroup) {
            case 'super_admin':
                $user_distributor = 'SADMIN';
            break;
            case 'admin':
                $user_distributor = 'ADMIN';
            break;
            case 'operation':
                $user_distributor = 'OPERATOR';
            break;
            case 'sales_manager':
                $user_distributor = 'SMAN';
            break;
            case 'ordering_agent':
                $user_distributor = 'ODERINGAGENT';
            break;
        }

        return $user_distributor;
    }
}