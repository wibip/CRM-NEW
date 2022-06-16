<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class sessionModel extends baseModel implements ModelInterface{

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

        return new sessionModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT * FROM exp_session_profile_logs WHERE 1=1";
        if(property_exists($log,'function') && !is_null($log->function))
            $q.=" AND function_name='$log->function'";
        if(property_exists($log,'realm') && !is_null($log->realm))
            $q.=" AND realm='$log->realm'";
        if(property_exists($log,'mac') && !is_null($log->mac))
            $q.=" AND mac='$log->mac'";
        if(property_exists($log,'from') && !is_null($log->from))
            $q.=" AND unixtimestamp>='$log->from'";
        if(property_exists($log,'to') && !is_null($log->to))
            $q.=" AND unixtimestamp<='$log->to'";

        $q.=" ORDER BY `id` DESC";

        if(!is_null($log->limit)){
            $q.=" LIMIT $log->limit";
        }else{
            $q.=" LIMIT 100";
        }

        //echo $q;
        return self::$driver->query($q);

    }

    public function insert(Log $log)
    {

        $q = "INSERT INTO `exp_session_profile_logs`
        (mac,realm,`function`, function_name,description,api_method, api_status, api_description, api_data, create_date, create_user,ale_username,unixtimestamp) VALUES (";
        $q.="'".self::$driver->escapeString($log->mac)."',";
        $q.="'".self::$driver->escapeString($log->realm)."',";
        $q.="'".self::$driver->escapeString($log->function)."',";
        $q.="'".self::$driver->escapeString($log->function_name)."',";
        $q.="'".self::$driver->escapeString($log->description)."',";
        $q.="'".self::$driver->escapeString($log->api_method)."',";
        $q.="'".self::$driver->escapeString($log->api_status)."',";
        $q.="'".self::$driver->escapeString($log->api_description)."',";
        $q.="'".self::$driver->escapeString($log->api_data)."',";
        $q.="'".self::$driver->escapeString($log->create_date)."',";
        $q.="'".self::$driver->escapeString($log->create_user)."',";
        $q.="'".self::$driver->escapeString($log->ale_username)."',";
        $q.="'".self::$driver->escapeString($log->timestamp)."' )";


        self::$driver->insert($q); 

    }

    public function view($id)
    {
        $q = "SELECT * FROM exp_session_profile_logs WHERE id='$id'";
        return self::$driver->query($q);
    }
}