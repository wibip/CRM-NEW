<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class deniedModel extends baseModel implements ModelInterface{

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

        return new deniedModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT * FROM exp_access_deni_log WHERE 1=1";

        if(!is_null($log->mac))
            $q.=" AND mac='$log->mac'";
        if(!is_null($log->from))
            $q.=" AND unix_timestamp>='$log->from'";
        if(!is_null($log->to))
            $q.=" AND unix_timestamp<='$log->to'";

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
        $q = "INSERT INTO exp_access_deni_log(mac, src, e_id, e_desc, token, unix_timestamp,create_date) VALUES (";
        $q.="'".self::$driver->escapeString($log->mac)."',";
        $q.="'".self::$driver->escapeString($log->src)."',";
        $q.="'".self::$driver->escapeString($log->eId)."',";
        $q.="'".self::$driver->escapeString($log->e_description)."',";
        $q.="'".self::$driver->escapeString($log->token)."',";
        $q.="'".self::$driver->escapeString($log->timestamp)."',";
        $q.="'".self::$driver->escapeString($log->create_date)."' )";

        self::$driver->insert($q);
    }

    public function view($id)
    {
        $q = "SELECT * FROM exp_access_deni_log WHERE id='$id'";
        return self::$driver->query($q);
    }
}