<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class vszModel extends baseModel implements ModelInterface{

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

        return new vszModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT * FROM exp_wag_ap_profile_logs WHERE 1=1";
        if(!is_null($log->function))
            $q.=" AND `function`='$log->function'";
        if(!is_null($log->realm))
            $q.=" AND realm='$log->realm'";
        if(!is_null($log->from))
            $q.=" AND unixtimestamp>='$log->from'";
        if(!is_null($log->to))
            $q.=" AND unixtimestamp<='$log->to'";

        $q.=" ORDER BY ID DESC";

        if(!is_null($log->limit)){
            $q.=" LIMIT $log->limit";
        }else{
            $q.=" LIMIT 100";
        }

        //return $q;
        return self::$driver->query($q);

    }

    public function insert(Log $log)
    {
        $q = "INSERT INTO exp_wag_ap_profile_logs(`function`,function_name,description,api_method,api_status,realm,
        api_description,api_data,create_date,create_user,unixtimestamp) VALUES (";
        $q.="'".self::$driver->escapeString($log->function)."',";
        $q.="'".self::$driver->escapeString($log->function_name)."',";
        $q.="'".self::$driver->escapeString($log->description)."',";
        $q.="'".self::$driver->escapeString($log->api_method)."',";
        $q.="'".self::$driver->escapeString($log->api_status)."',";
        $q.="'".self::$driver->escapeString($log->realm)."',";
        $q.="'".self::$driver->escapeString($log->api_description)."',";
        $q.="'".self::$driver->escapeString($log->api_data)."',";
        $q.="'".self::$driver->escapeString($log->create_date)."',";
        $q.="'".self::$driver->escapeString($log->create_user)."',";
        $q.="'".self::$driver->escapeString($log->timestamp)."' )";

 
        self::$driver->insert($q);
    }

    public function view($id)
    {
        $q = "SELECT * FROM exp_wag_ap_profile_logs WHERE id='$id'";
        return self::$driver->query($q);
    }
}