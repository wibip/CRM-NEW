<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class techModel extends baseModel implements ModelInterface{

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

        return new techModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT * FROM exp_tech_tool_logs WHERE 1=1";
        if(!is_null($log->ap_mac))
            $q.=" AND ap_mac='$log->ap_mac'";
        if(!is_null($log->getRealm))
            $q.=" AND realm='$log->getRealm'";
        if(!is_null($log->from))
            $q.=" AND unixtimestamp>='$log->from'";
        if(!is_null($log->to))
            $q.=" AND unixtimestamp<='$log->to'";

        $q.=" ORDER BY id DESC";

        if(!is_null($log->limit)){
            $q.=" LIMIT $log->limit";
        }else{
            $q.=" LIMIT 100";
        }

        return self::$driver->query($q);

    }

    public function insert(Log $log)
    {
        
        $q = "INSERT INTO exp_tech_tool_logs(ap_mac,realm,ap_function,action,reference,create_date,create_user,unixtimestamp)
        VALUES (";
        $q.="'".self::$driver->escapeString($log->ap_mac)."',";
        $q.="'".self::$driver->escapeString($log->realm)."',";
        $q.="'".self::$driver->escapeString($log->ap_function)."',";
        $q.="'".self::$driver->escapeString($log->action)."',";
        $q.="'".self::$driver->escapeString($log->reference)."',";
        $q.="'".self::$driver->escapeString($log->create_date)."',";
        $q.="'".self::$driver->escapeString($log->timestamp)."' )";


        self::$driver->insert($q);
    }

    public function view($id)
    {
        $q = "SELECT * FROM TECH_TOOL_LOG WHERE ID='$id'";
        return self::$driver->query($q);
    }
}