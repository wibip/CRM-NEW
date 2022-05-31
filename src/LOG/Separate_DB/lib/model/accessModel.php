<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class accessModel extends baseModel implements ModelInterface{

    private static $driver;
    private static $instance = null;
    public function __construct()
    {
        require_once dirname(__FILE__).'/../../../../../db/log_db_config.php';

        $log_db_config = json_decode(_LOG_DB_CONFIG_,true);

        self::$driver = parent::connect($log_db_config);
    }

    public static function getModel(){
        if(!is_null(self::$instance))
            return self::$instance;

        return new accessModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT L.id AS id, E.`status_id`,E.`description`,L.`access_details`,S.`location_id`,S.`token_id`,S.`mac`,S.`ssid`,S.`customer_id`,C.`act_email` as email,L.`create_date`,L.`unixtimestamp` ,S.other_parameters
    FROM exp_points_logs L,exp_points E,exp_customer_session S
    left join `exp_customer` C
    on S.`customer_id`= C.`customer_id`
    WHERE E.`status_id`=L.`access_id`
    AND S.`token_id`=L.`token`

    AND S.`location_id`= '$log->distributor'";

         

        if(!empty($log->ssid)){
            $q.=" AND ssid ='$log->ssid'";
        }
        if(!empty($log->mac)){
            $q.= " AND mac ='$log->mac'";
        }
        else{
             $q.= " AND mac <>'DEMO_MAC'";
        }
        if(!empty($log->email)){
            
            $q.= " AND email ='$log->email'";
        }
        if(!empty($log->limit)){
            $log->limit = 100;
        }
        if(!empty($log->from)){
            $q.= " AND L.unixtimestamp >'$log->from'";
        }
        if(!empty($log->to)){
            $q.= " AND L.unixtimestamp <'$log->to'";
        }

        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;
      
        return self::$driver->query($q);

    }

    public function readerror(Log $log)
    {
        $q = "SELECT L.`id` AS id,E.`error_id`,E.`description`,L.`error_details`,S.`location_id`,S.`token_id`,S.`mac`,S.`ssid`,S.`customer_id`,C.`email`,L.`create_date`,L.`unixtimestamp`  
        FROM exp_error_log L,exp_errors E,exp_customer_session S
        left join `exp_customer` C
        on S.`customer_id`= C.`customer_id`
        WHERE E.`error_id`=L.`error_id`
        AND S.`token_id`=L.`token`
        AND S.`location_id`= '$log->distributor'";

         

        if(!empty($log->ssid)){
            $q.=" AND ssid ='$log->ssid'";
        }
        if(!empty($log->mac)){
            $q.= " AND mac ='$log->mac'";
        }
        else{
            $q.= " AND mac <>'DEMO_MAC'";
        }
        if(!empty($log->email)){
            
            $q.= " AND email ='$log->email'";
        }
        if(!empty($log->limit)){
            $log->limit = 100;
        }
        if(!empty($log->from)){
            $q.= " AND L.unixtimestamp >'$log->from'";
        }
        if(!empty($log->to)){
            $q.= " AND L.unixtimestamp <'$log->to'";
        }

        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;        

        return self::$driver->query($q);

    }

    public function readapi(Log $log)
    {
        $api_realm=$log->realm;

    $q = "SELECT * FROM `exp_wag_ap_profile_logs` WHERE realm='".$api_realm."'";

         

        if(!empty($log->function)){
            $q.=" AND function ='$log->function'";
        }

       
        if(!empty($log->limit)){
            $log->limit = 100;
        }
        if(!empty($log->from)){
            $q.= " AND unixtimestamp >'$log->from'";
        }
        if(!empty($log->to)){
            $q.= " AND unixtimestamp <'$log->to'";
        }

        $q.=" ORDER BY create_date DESC";

        $q.=" LIMIT ".$log->limit;        

        //return $q;
        return self::$driver->query($q);

    }

    public function insert(Log $log)
    {}

    public function view($id)
    {
    }
}