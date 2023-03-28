<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/Model.php';
include_once __DIR__.'/../DTO/User.php';
require_once __DIR__.'/../classes/dbClass.php';
require_once __DIR__.'/../classes/systemPackageClass.php';


class User_model
{

    private $user;
    private $ori_User;
    private static $instance = null;
    private $db;
    private $layout;
    private $package_function;

    private function __construct()
    {
        $this->db = new db_functions();
        $this->package_function = new package_functions();
        $this->setUser();
    }
    private function setUser(){
        $user_name = $_SESSION['user_name'];
        if (strlen($user_name) < 1) {
            $user_name = $_SESSION['reset_user'];
        }

        if(is_null($this->user)){
            $q = "SELECT
                  u.id,u.user_name,u.password,u.access_role,u.email,u.mobile,u.language,u.is_enable,u.full_name,u.user_type,
                  m.mno_id AS user_distributor,m.system_package,m.timezones,u.verification_number
                FROM admin_users u JOIN exp_mno m ON u.user_distributor=m.mno_id where u.user_name='$user_name'
                UNION
                SELECT
                  u.id,u.user_name,u.password,u.access_role,u.email,u.mobile,u.language,u.is_enable,u.full_name,u.user_type,
                  m.distributor_code AS user_distributor,m.system_package,m.timezones,u.verification_number
                FROM admin_users u JOIN exp_mno_distributor m ON u.user_distributor=m.distributor_code where u.user_name='$user_name'
                UNION
                SELECT
                  u.id,u.user_name,u.password,u.access_role,u.email,u.mobile,u.language,u.is_enable,u.full_name,u.user_type,
                  m.parent_id AS user_distributor,m.system_package,'' AS timezones,u.verification_number
                FROM admin_users u JOIN mno_distributor_parent m ON u.user_distributor=m.parent_id where u.user_name='$user_name';";

            $user_q_data = $this->db->select1DB($q);

            $user = new User();
            $user->id = $user_q_data['id'];
            $user->user_name = $user_q_data['user_name'];
            $user->access_role = $user_q_data['access_role'];
            $user->email = $user_q_data['email'];
            $user->mobile = $user_q_data['mobile'];
            $user->language = $user_q_data['language'];
            $user->is_enable = $user_q_data['is_enable'];
            $user->full_name = $user_q_data['full_name'];
            $user->user_type = $user_q_data['user_type'];
            $user->user_distributor = $user_q_data['user_distributor'];
            $user->system_package = $user_q_data['system_package'];
            $user->timezones = $user_q_data['timezones'];
            $user->verification_number = $user_q_data['verification_number'];

            $this->user = $user;
        }

    }

    public function getUser(){
        return $this->user;
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new User_model();
        }

        return self::$instance;
    }

    public function getOriginalUser(){
        if(is_null($this->ori_User)){
            if(isset($_SESSION['s_token']) || isset($_SESSION['p_token'])){
                $ori_user_uname = $_SESSION['ori_user_uname'];

                $q = "SELECT user_distributor,user_group FROM admin_users WHERE user_name = '$ori_user_uname' LIMIT 1";
                $data = $this->db->select1DB($q);
                $ori_user_group=$data['user_group'];

                $ori_user_distributor=$data['user_distributor'];

                if($ori_user_group=="operation" || $ori_user_group=="admin"){
                    $ori_system_package=$this->db->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$ori_user_distributor'");
                }

                $session_logout_btn_display = $this->package_function->getOptions('SESSION_LOGOUT_BUTTON_DISPLAY',$ori_system_package);

                $logout_time = $this->package_function->getOptions('SESSION_LOGOUT_TIME',$ori_system_package);

                $user = new User();
                $user->user_group = $ori_user_group;
                $user->user_name = $ori_user_uname;
                $user->user_distributor = $ori_user_distributor;
                $user->system_package = $ori_system_package;
            }else{
                $this->ori_User = $this->user;
            }
        }

        return $this->ori_User;
    }
}