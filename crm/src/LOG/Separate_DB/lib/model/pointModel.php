<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class pointModel extends baseModel implements ModelInterface{

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

        return new pointModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT * FROM exp_points_logs WHERE 1=1";
        if(!is_null($log->username))
            $q.=" AND user_name='$log->username'";
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
        
        $q = "INSERT INTO `exp_points_logs`(`access_id`, `token`, `access_details`, `create_date`, `unixtimestamp`)
        VALUES (";
        $q.="'".self::$driver->escapeString($log->id)."',";
        $q.="'".self::$driver->escapeString($log->token)."',";
        $q.="'".self::$driver->escapeString($log->detail)."',";
        $q.="'".self::$driver->escapeString($log->create_date)."',";
        $q.="'".self::$driver->escapeString($log->timestamp)."' )";


        self::$driver->insert($q);
    }

    public function view($id)
    {
        $q = "SELECT * FROM exp_points_logs WHERE `id`='$id'";
        return self::$driver->query($q);
    }
}