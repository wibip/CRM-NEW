<?php



//Current Page URL
$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
if ($_SERVER["SERVER_PORT"] != "80")
{
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
}
else
{
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}



include_once '../db/dbTasks.php';
$dbT = new dbTasks();


//include_once( str_replace('//','/',dirname(__FILE__).'/') .'../config/db_config.php');





class package_functions
{

    public function __construct()
    {

        $this->dbT = new dbTasks();
    }

    public function getAdminPackage(){

        $q="SELECT
              `system_package` AS a
            FROM
              `exp_mno` 
            WHERE `mno_id`='ADMIN'
            LIMIT 1";
        $data = $this->dbT->select1DB($q);
        return $data['a'];
    }

    public function getFeatureAccess($featureCode,$featureArray){
        if(in_array($featureCode,$featureArray)){
                return true;
        }else{
                return false;
        }
    }
    public function getPageFeature($page,$package_code){

        if($package_code=="N/A" || $package_code=="") {
                return'1';
        }
        else{

           $q1="SELECT `options` AS f FROM `admin_product_controls` WHERE 
                   `product_code`='$package_code' AND `feature_code` ='ALLOWED_PAGE'";

           $page_ar= $this->dbT->getValueAsf($q1);
           $page_re =  json_decode($page_ar,true);

            if (in_array($page, $page_re)) {
                return '1';
            } else {
                return '0';
            } 

        }
    }


    public function getPageName($page,$package_code,$intName){
          
        $q = "SELECT c.`options` AS name  FROM `admin_product_controls` c
              WHERE c.`product_code`='$package_code' AND c.`type`='page' AND `source`='$page' AND c.`access_method`='1' ";
        $nameArr=$this->dbT->select1DB($q);
        $name = $nameArr['name'];
        if(strlen($name) > 0){
            return $name;
        }
        else{
            return $intName;
        }
            
    }

    public function getSectionType($feature_code,$system_package){

        $q="SELECT c.`access_method` FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='option'";
        $method=$this->dbT->select1DB($q);
        return $method['access_method'];
    }
    public function getCaptiveSectionType($feature_code,$system_package){

        $q="SELECT c.`access_method` FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='captive'";

            $method=$this->dbT->select1DB($q);
            return $method['access_method'];
    }

    public function getOptions($feature_code,$system_package){

        $q="SELECT c.`options` as a FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='option'";

        $option=$this->dbT->select1DB($q);
        return $option['a'];
    }
        
        
        
        
         public function getMessageOptions($feature_code,$system_package){

            $q="SELECT c.`options` as a FROM `admin_product_controls` c
                WHERE c.`product_code`='$system_package'
                AND c.`feature_code`='$feature_code'
                AND c.`type` ='message'";

            $option=$this->dbT->select1DB($q);
            return $option['a'];
        }

    public function gettooltipOptions($feature_code,$system_package,$page_name){

        $q="SELECT c.`options` as a FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='option'";

        $option=$this->dbT->select1DB($q);
        $textarr=json_decode($option['a'],true);
        $page_name=explode('.', $page_name);
        $page_name=$page_name['0'];
        $value=array();


        foreach ($textarr as $key => $value) {

            if ($key==$page_name) {

                $value=json_encode($value);
                return $value;
               
            }
        }
                    
    }

    public function getPackage($user_name){


        $get_user_details_q="SELECT `user_distributor`,`user_type` FROM admin_users WHERE user_name='$user_name'";
        $get_user_details=$this->dbT->select1DB($get_user_details_q);
        $get_user_code=$get_user_details['user_distributor'];
        $get_user_type=$get_user_details['user_type'];


        if($get_user_type=="MVNO" ||$get_user_type=="MVNE" ||$get_user_type=="MVNA"){
                $table='exp_mno_distributor';
                $field='distributor_code';
        }elseif($get_user_type=="MVNO_ADMIN"){
                $table='mno_distributor_parent';
                $field='parent_id';
        }else{
                $table='exp_mno';
                $field='mno_id';
        }

        $master_q="SELECT `system_package` AS f FROM `".$table."` WHERE ".$field."='$get_user_code'";
        return$SPCdb->getValueAsf($master_q);
    }
        
        
    public function getDistributorMONPackage($user_name){

 
        $get_user_type="SELECT user_type AS f FROM admin_users WHERE user_name = '$user_name'";
        $user_type = $this->dbT->getValueAsf($get_user_type);
        
        if($user_type=='MVNO'){

          $master_q="SELECT m.`system_package` AS f FROM `exp_mno` m,`exp_mno_distributor` d,`admin_users` u
                        WHERE u.`user_distributor`=d.`distributor_code`
                        AND d.`mno_id`=m.`mno_id`
                        AND u.`user_name`='$user_name' GROUP BY m.`system_package`";
        }elseif($user_type=='MVNO_ADMIN'){
          $master_q="SELECT m.`system_package` AS f FROM `exp_mno` m,`mno_distributor_parent` d,`admin_users` u
                        WHERE u.`user_distributor`=d.`parent_id`
                        AND d.`mno_id`=m.`mno_id`
                        AND u.`user_name`='$user_name' GROUP BY m.`system_package`";
        }
        return $this->dbT->getValueAsf($master_q);
    }

    public function callApi($feature_code,$system_package,$options='NO'){ // if option YES return options column value
        if($options=='YES'){
            $q="SELECT c.`access_method`,c.`options` FROM `admin_product_controls` c
                WHERE c.`product_code`='$system_package'
                AND c.`feature_code`='$feature_code'
                AND c.`type` ='api'";
            return $this->dbT->select1DBArray($q);
            
        }else{
            $q="SELECT c.`access_method` FROM `admin_product_controls` c
                WHERE c.`product_code`='$system_package'
                AND c.`feature_code`='$feature_code'
                AND c.`type` ='api'";
            $method=$this->dbT->select1DBArray($q);
            return ($method[0]=='1');

        }
    }



    //Get package name
    public function getPackageName($product){
        $q = "SELECT discription FROM admin_product WHERE product_code='$product'";
        return $this->dbT->select1DB($q)['discription'];
    }

    //Get mno package by ralm
    public function getMNOPackageByRalm($realm){
        $q = "SELECT m.system_package FROM exp_mno m JOIN exp_mno_distributor emd on m.mno_id = emd.mno_id WHERE emd.verification_number='$realm' LIMIT 1";

        $data = $this->dbT->select1DB($q);

        return $data['system_package'];
    }

}
?>
