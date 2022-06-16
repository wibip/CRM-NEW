<?php
require_once __DIR__.'/../../classes/dbClass.php';
require_once __DIR__.'/../LOG/Logger.php';
require_once __DIR__.'/../../models/User_model.php';

class apClass{

    protected $db_class;
    protected $profile_name;
    protected $run_user_name;
    protected $realm;
    protected $distributor;
    public $vsz_zone_id;
    private $user;
    private $vsz;

    function __construct()
    {
        $this->db_class = new db_functions();
        $this->user = User_model::getInstance()->getUser();
        $this->run_user_name = $this->user->user_name;
        $this->realm=$this->db_class->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_name`='$this->run_user_name' LIMIT 1");

    }

    public function getConfig($field)
    {

        if (is_null($this->profile_name))
            $this->profile_name = $this->db_class->setVal("wag_ap_name", 'ADMIN');

        $data='';

        $query = "SELECT $field AS f FROM exp_wag_ap_profile WHERE wag_ap_name = '$this->profile_name;' LIMIT 1";
        $query_results = $this->db_class->selectDB($query);
        foreach($query_results['data'] AS $row){
            $data = $row['f'];
        }

        return $data;
    }

    public function setRealm($realm)
    {
        $this->realm = $realm;
    }

    public function setDistributor($distributor){
        $this->distributor = $distributor;
    }


    public function getController()
    {
        return $this->ap;
    }

    public function log($function, $function_name, $description, $method, $api_status, $api_details, $api_data, $rlm)
    {

        $logger = Logger::getLogger();
        $log = $logger->getObjectProvider()->getObjectVsz();

        //$log->

        $log->setFunction($function);
        $log->setFunctionName($function_name);
        $log->setDescription($description);
        $log->setApiMethod($method);
        $log->setApiStatus($api_status);
        $log->setApiDescription($api_details);
        $log->setApiData($api_data);
        $log->setRealm($rlm);



        $logger->InsertLog($log);

    }

    public function getZoneId(){

        if(is_null($this->vsz_zone_id)){
            $this->vsz_zone_id = $this->db_class->getValueAsf("SELECT zone_id as f FROM exp_mno_distributor WHERE verification_number='".$this->realm."'");;
        }

        return $this->vsz_zone_id;
    }

    public final function getControllerInst(){

        if(is_null($this->vsz)) {
            $ap_control_var = $this->db_class->setVal('ap_controller', 'ADMIN');

            $ap_q1 = "SELECT `ap_controller` AS f
                FROM `exp_mno_distributor`
                WHERE `distributor_code`='" . $this->user->user_distributor . "'
                LIMIT 1";

            $ack = $this->db_class->getValueAsf($ap_q1);

            if (!empty($ack)) {
                $ap_q2 = "SELECT `api_profile` AS f
                FROM `exp_locations_ap_controller`
                WHERE `controller_name`='$ack'
                LIMIT 1";

                $wag_ap_name2 = $this->db_class->getValueAsf($ap_q2);
            }

            $def_wag_q = "SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1";

            if ($ap_control_var == 'MULTIPLE') {

                if ($wag_ap_name2 == "") {
                    $wag_ap_name = $this->db_class->getValueAsf($def_wag_q);
                    include __DIR__.'/' . $wag_ap_name . '/index.php';
                }
                require_once __DIR__.'/' . $wag_ap_name2 . '/index.php';

                $ruckus_vsz = new ap_wag($ack);

            } else if ($ap_control_var == 'SINGLE') {

                $wag_ap_name = $this->db_class->getValueAsf($def_wag_q);

                require_once __DIR__.'/' . $wag_ap_name . '/index.php';
                $ruckus_vsz = new ap_wag();

            }

            $this->vsz = $ruckus_vsz;
        }

        return $this->vsz;
    }

    public function getBaseUrl(){
        return $this->baseurl;
    }

}