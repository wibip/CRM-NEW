<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class userModel extends baseModel implements ModelInterface{

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

        return new userModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT * FROM admin_user_logs WHERE 1=1";
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
        
        $q = "INSERT INTO admin_user_logs(user_name,module_id,module,task,reference,ip,user_distributor,create_date,unixtimestamp)
        VALUES (";
        $q.="'".self::$driver->escapeString($log->username)."',";
        $q.="'".self::$driver->escapeString($log->module_id)."',";
        $q.="'".self::$driver->escapeString($log->module_id)."',";
        $q.="'".self::$driver->escapeString($log->task)."',";
        $q.="'".self::$driver->escapeString($log->reference)."',";
        $q.="'".self::$driver->escapeString($log->ip)."',";
        $q.="'".self::$driver->escapeString($log->distributor)."',";
        $q.="'".self::$driver->escapeString($log->create_date)."',";
        $q.="'".self::$driver->escapeString($log->timestamp)."' )";
        

        self::$driver->insert($q);
    }

    public function view($id)
    {
        $q = "SELECT * FROM admin_user_logs WHERE ID='$id'";
        return self::$driver->query($q);
    }
}