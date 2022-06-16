<?php
require_once __DIR__.'/../../db/dbTasks.php';

class active_theme
{
    private $db;
    private static $inst = null;
    private function __construct()
    {
        $this->db = new dbTasks();
    }

    public static function inst(){
        if(is_null(self::$inst)){
            self::$inst = new active_theme();
        }

        return self::$inst;
    }

    private function gatewayType($distributor){
        $q = "SELECT gateway_type AS f FROM exp_mno_distributor WHERE distributor_code='$distributor'";
        return $this->db->getValueAsf($q);
    }

    public function multiSSIDActiveThemes($distributor){
        if($this->gatewayType($distributor) == 'AC'){
            $queryall = "SELECT DISTINCT g.theme_name
                        FROM `exp_mno_distributor_group_tag` g JOIN `exp_locations_ap_ssid` s ON g.`distributor`=s.`distributor`
                        WHERE g.`distributor`='$distributor'";
        }else{
            $queryall = "SELECT g.theme_name
                        FROM `exp_distributor_wlan_group_ssid` ss LEFT JOIN `exp_mno_distributor_group_tag` g ON  ss.`group_tag`= g.`tag_name`
                            WHERE ss.`distributor`='$distributor'";
        }
        $theme_arr=array();
        $results=$this->db->selectDB($queryall);
        foreach($results['data'] AS $rows){
            $theme_name=$rows[theme_name];
            $theme_name_n=json_decode($theme_name,true)['en'];
            array_push($theme_arr, $theme_name_n);
        }

        return $theme_arr;
    }

}