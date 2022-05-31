<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class redirectionModel extends baseModel implements ModelInterface{

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

        return new redirectionModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT * FROM exp_redirection_log WHERE 1=1";
        if(property_exists($log,'mac') && !is_null($log->mac))
            $q.=" AND mac='$log->mac'";
        if(property_exists($log,'realm') && !is_null($log->realm))
            $q.=" AND group_id='$log->realm'";
        if(property_exists($log,'type') && !is_null($log->type))
            $q.=" AND acc_type='$log->type'";
        if(property_exists($log,'from') && !is_null($log->from))
            $q.=" AND unixtimestamp>='$log->from'";
        if(property_exists($log,'to') && !is_null($log->to))
            $q.=" AND unixtimestamp<='$log->to'";

        $q.=" ORDER BY ID DESC";

        if(!is_null($log->limit)){
            $q.=" LIMIT $log->limit";
        }else{
            $q.=" LIMIT 100";
        }

        return self::$driver->query($q);

    }

    public function insert(Log $log)
    {
        
        $q = "INSERT INTO `exp_redirection_log` (`page`, `mac`,`group_id`, `request_uri`, `referer`, `create_date`,`acc_type`,`unixtimestamp`) VALUES (";
        $q.="'".self::$driver->escapeString($log->page)."',";
        $q.="'".self::$driver->escapeString($log->mac)."',";
        $q.="'".self::$driver->escapeString($log->realm)."',";
        $q.="'".self::$driver->escapeString($log->url)."',";
        $q.="'".self::$driver->escapeString($log->reference)."',";
        $q.="'".self::$driver->escapeString($log->create_date)."',";
        $q.="'".self::$driver->escapeString($log->type)."',";
        $q.="'".self::$driver->escapeString($log->timestamp)."' )";


        self::$driver->insert($q);
    }

    public function view($id)
    {
        $q = "SELECT * FROM exp_redirection_log WHERE `id`='$id'";
        return self::$driver->query($q);
    }
}