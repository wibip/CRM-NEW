<?php
//Current Page URL
$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
} else {
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
}
include_once(str_replace('//', '/', dirname(__FILE__) . '/') . 'dbClass.php');
include_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../db/dbTasks.php');
include_once __DIR__.'/../models/User_model.php';

class package_functions
{
    private $dbT;
    private $systemClass;
    private $classType;

    private function createClass($system_package)
    {
        $classType = $this->get_class_type($system_package);
        if($classType!=$this->classType){
            $this->systemClass=null;
            $this->classType=$classType;

        }
        if(is_null($this->systemClass)) {
            if ($classType == 'two') {
                include_once __DIR__ . '/SystemPackageTwo.php';
                $this->systemClass = SystemPackageTwo::getInstance();

            } else {

                include_once __DIR__ . '/SystemPackageOne.php';
                $this->systemClass = SystemPackageOne::getInstance();
            }
        }
        return $this->systemClass;
    }

    private function get_class_type($product)
    {
        //echo $product;
        $ar = explode('-',$product);
        switch ($ar[0]){
            case 'dy':
                return 'two';
                break;
            default:
                return 'one';
                break;
        }
    }

    public function __construct()
    {
        $this->dbT = new dbTasks();
    }

    public function getAdminPackage()
    {

        $q = "SELECT
              `system_package` AS a
            FROM
              `exp_mno` 
            WHERE `mno_id`='ADMIN'
            LIMIT 1";
        $data = $this->dbT->select1DB($q);
        return $data['a'];
    }

    public function getFeatureAccess($featureCode, $featureArray)
    {
        if (in_array($featureCode, $featureArray)) {
            return true;
        } else {
            return false;
        }
    }

    public function getPageFeature($page, $package_code)
    {
        $this->createClass($package_code);
        if ($package_code == "N/A" || $package_code == "") {
            return '1';
        } else {

            return $this->systemClass->getPageFeature($page, $package_code);

        }
    }


    public function getPageName($page, $package_code, $intName)
    {
        $this->createClass($package_code);
        return $this->systemClass->getPageName($page, $package_code, $intName);

    }

    public function getSectionType($feature_code, $system_package)
    {
        $this->createClass($system_package);
        return $this->systemClass->getSectionType($feature_code, $system_package);
    }

    public function getSectionTypeBranding($feature_code, $system_package)
    {
        $this->createClass($system_package);
        return $this->systemClass->getSectionTypeBranding($feature_code, $system_package);
    }

    public function getCaptiveSectionType($feature_code, $system_package)
    {
        $this->createClass($system_package);
        return $this->systemClass->getCaptiveSectionType($feature_code, $system_package);
    }

    public function getOptions($feature_code, $system_package)
    {
        $this->createClass($system_package);
        return $this->systemClass->getOptions($feature_code, $system_package);
    }

    public function getOptionsAaa($feature_code, $system_package)
    {

        $this->createClass($system_package);
        return $this->systemClass->getOptionsAaa($feature_code, $system_package);
    }
    
    public function getOptionsBranding($feature_code, $system_package)
    {

        $this->createClass($system_package);
        return $this->systemClass->getOptionsBranding($feature_code, $system_package);
    }

    public function ajaxAccess(array $modules,$system_package){

        $allowed_pages = $this->getOptions('ALLOWED_PAGE',$system_package);
        
        $intersect = array_intersect($modules,json_decode($allowed_pages,true));
        
        if(count($intersect)>0){
            return true;
        }else{
            http_response_code(401);
            exit();
        }
    }
    public function getMessageOptions($feature_code, $system_package, $vertical='all')
    {
        $this->createClass($system_package);
        return $this->advancedOption($feature_code,$this->systemClass->getMessageOptions($feature_code, $system_package),'',$vertical);
    }

    public function gettooltipOptions($feature_code, $system_package, $page_name)
    {
        $this->createClass($system_package);
        return $this->systemClass->gettooltipOptions($feature_code, $system_package, $page_name);

    }

    public function getPackage($user_name)
    {

        $get_user_details_q = "SELECT `user_distributor`,`user_type` FROM admin_users WHERE user_name='$user_name'";
        $get_user_details = $this->dbT->select1DB($get_user_details_q);;
        $get_user_code = $get_user_details['user_distributor'];
        $get_user_type = $get_user_details['user_type'];


        if ($get_user_type == "MVNO" || $get_user_type == "MVNE" || $get_user_type == "MVNA") {
            $table = 'exp_mno_distributor';
            $field = 'distributor_code';
        } elseif ($get_user_type == "MVNO_ADMIN") {
            $table = 'mno_distributor_parent';
            $field = 'parent_id';
        } else {
            $table = 'exp_mno';
            $field = 'mno_id';
        }

        $master_q = "SELECT `system_package` AS f FROM `" . $table . "` WHERE " . $field . "='$get_user_code'";
        return $this->dbT->getValueAsf($master_q);
    }

    public function getDynamicPackage($user_name)
    {

        $get_user_details_q = "SELECT `user_distributor`,`user_type` FROM admin_users WHERE user_name='$user_name'";
        $get_user_details = $this->dbT->select1DB($get_user_details_q);;
        $get_user_code = $get_user_details['user_distributor'];
        $get_user_type = $get_user_details['user_type'];


        if ($get_user_type == "MVNO" || $get_user_type == "MVNE" || $get_user_type == "MVNA") {
            $table = 'exp_mno_distributor';
            $field = 'distributor_code';
        } elseif ($get_user_type == "MVNO_ADMIN") {
            $table = 'mno_distributor_parent';
            $field = 'parent_id';
        } else {
            $table = 'exp_mno';
            $field = 'mno_id';
        }

        $master_q = "SELECT `dynamic_product_id` AS f FROM `" . $table . "` WHERE " . $field . "='$get_user_code'";
        return $this->dbT->getValueAsf($master_q);
    }


    public function getDistributorMONPackage($user_name)
    {

        if (isset($user_name) && !empty($user_name)) {
            $get_user_type = "SELECT user_type AS f FROM admin_users WHERE user_name = '$user_name'";
            $user_type = $this->dbT->getValueAsf($get_user_type);

            if ($user_type == '') {
                return 'User type is empty';
            } else {
                if ($user_type == 'MVNO') {

                    $master_q = "SELECT m.`system_package` AS f FROM `exp_mno` m,`exp_mno_distributor` d,`admin_users` u
                                WHERE u.`user_distributor`=d.`distributor_code`
                                AND d.`mno_id`=m.`mno_id`
                                AND u.`user_name`='$user_name' GROUP BY m.`system_package`";
                } elseif ($user_type == 'MVNO_ADMIN') {
                    $master_q = "SELECT m.`system_package` AS f FROM `exp_mno` m,`mno_distributor_parent` d,`admin_users` u
                                WHERE u.`user_distributor`=d.`parent_id`
                                AND d.`mno_id`=m.`mno_id`
                                AND u.`user_name`='$user_name' GROUP BY m.`system_package`";
                }
                return $this->dbT->getValueAsf($master_q);
            }

        } else {
            return 'Username is empty';
        }

    }

    public function callApi($feature_code, $system_package, $options = 'NO')
    { // if option YES return options column value
        $this->createClass($system_package);
        return $this->systemClass->callApi($feature_code, $system_package, $options);
    }

    //Get package name
    public function getPackageName($product)
    {
        $q = "SELECT discription FROM admin_product WHERE product_code='$product'";
        return $this->dbT->select1DB($q)['discription'];
    }

    //Get mno package by ralm
    public function getMNOPackageByRalm($realm)
    {
        $q = "SELECT m.system_package FROM exp_mno m JOIN exp_mno_distributor emd on m.mno_id = emd.mno_id WHERE emd.verification_number='$realm' LIMIT 1";

        $data = $this->dbT->select1DB($q);

        return $data['system_package'];
    }

    public static function isDynamic($product){
        $a = explode("-",$product);
        if($a[0]=='dy'){
            return true;
        }else{
            return false;
        }
    }


    private function advancedOption($feature_code,$value,$product='',$vertical='all'){
        $newValue = $value;

        switch ($feature_code){
            case 'SUPPORT_NUMBER':{

                if(is_array(json_decode($value,true))){
                    $newValue = $this->supportNumberMod($value);
                }

                $user = User_model::getInstance()->getUser();
                if($user->user_type=='MVNO'){
                    //echo $user->user_distributor;
                    $q = "select d.mno_id FROM exp_mno_distributor d
                            where d.distributor_code='$user->user_distributor'";
                    $d = $this->dbT->select1DB($q);

                    $numbers = json_decode($this->dbT->setVal('VERTICAL_SUPPORT_NUM',$d['mno_id']));
                    
                    if($numbers){
                        $newValue = !empty($numbers->$vertical)?$numbers->$vertical:$newValue;
                    }

                }elseif($user->user_type=='MVNO_ADMIN'){
                    //echo $user->user_distributor;
                    $q = "select p.mno_id,d.bussiness_type FROM mno_distributor_parent p left join `exp_mno_distributor` d
                                                                ON p.`parent_id`=d.`parent_id`
                            where p.parent_id='$user->user_distributor' LIMIT 1";
                    $d = $this->dbT->select1DB($q);

                    $numbers = json_decode($this->dbT->setVal('VERTICAL_SUPPORT_NUM',$d['mno_id']));
                    
                    if($numbers){
                        $newValue = !empty($numbers->$d['bussiness_type'])?$numbers->$d['bussiness_type']:$newValue;
                    }

                }else{
                    $numbers = json_decode($this->dbT->setVal('VERTICAL_SUPPORT_NUM',$user->user_distributor));
                    if($numbers){
                        $newValue = !empty($numbers->$vertical)?$numbers->$vertical:$newValue;
                    }
                }

                break;
            }
            default:{
              break;
            }
        }

        return $newValue;
    }

    private function supportNumberMod($values){
        $ar = json_decode($values,true);
        $user = User_model::getInstance()->getUser();

        if($user->user_type=='MVNO'){
            //echo $user->user_distributor;
            $q = "select d.network_type FROM exp_mno_distributor d
where d.distributor_code='$user->user_distributor'";
            $d = $this->dbT->select1DB($q);
            $d_ar = explode('-',$d['network_type']);
            if($d_ar[0]=='VT'){
                return $ar['MDU'];
            }else
            {
                return $ar['VTENANT'];
            }
        }else{
            return $ar['VTENANT'];
        }
    }
}

?>
