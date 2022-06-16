<?php
require_once __DIR__.'/../classes/dbClass.php';
require_once __DIR__.'/../classes/systemPackageClass.php';

class Model
{
    protected $db;
    protected $layout;
    protected $package_function;
    private $vsz;

    function __construct()
    {
        $this->db = new db_functions();
        $this->package_function = new package_functions();

    }

    public final function user(){
        require_once __DIR__.'/User_model.php';
        return User_model::getInstance()->getUser();
    }

    public function getRuckusVSZ(){

        if(is_null($this->vsz)) {
            $ap_control_var = $this->db->setVal('ap_controller', 'ADMIN');

            $ap_q1 = "SELECT `ap_controller` AS f
                FROM `exp_mno_distributor`
                WHERE `distributor_code`='" . $this->user()->user_distributor . "'
                LIMIT 1";

            $ack = $this->db->getValueAsf($ap_q1);

            if (!empty($ack)) {
                $ap_q2 = "SELECT `api_profile` AS f
                FROM `exp_locations_ap_controller`
                WHERE `controller_name`='$ack'
                LIMIT 1";

                $wag_ap_name2 = $this->db->getValueAsf($ap_q2);
            }

            $def_wag_q = "SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1";

            if ($ap_control_var == 'MULTIPLE') {

                if ($wag_ap_name2 == "") {
                    $wag_ap_name = $this->db->getValueAsf($def_wag_q);
                    include 'src/AP/' . $wag_ap_name . '/index.php';
                }
                require_once 'src/AP/' . $wag_ap_name2 . '/index.php';

                $ruckus_vsz = new ap_wag($ack);

            } else if ($ap_control_var == 'SINGLE') {

                $wag_ap_name = $this->db->getValueAsf($def_wag_q);

                require_once 'src/AP/' . $wag_ap_name . '/index.php';
                $ruckus_vsz = new ap_wag();

            }

            $this->vsz = $ruckus_vsz;
        }

        return $this->vsz;
    }

}