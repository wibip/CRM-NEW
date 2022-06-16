<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class otherModel extends baseModel implements ModelInterface{

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

        return new otherModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT * FROM other_api_logs WHERE 1=1";
        if(property_exists($log,'function') && !is_null($log->function))
            $q.=" AND type='$log->function'";
        if(property_exists($log,'realm') && !is_null($log->realm))
            $q.=" AND realm='$log->realm'";
        if(property_exists($log,'from') && !is_null($log->from))
            $q.=" AND unixtimestamp>='$log->from'";
        if(property_exists($log,'to') && !is_null($log->to))
            $q.=" AND unixtimestamp<='$log->to'";

        $q.=" ORDER BY id DESC";

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
        $q = "INSERT INTO other_api_logs(`api_url`,`api_data`,`api_responce`,  `realm`,  `voucher_code`, `mobile`,`type`, `mno_id`, `user_distributer`, `account_number`, `create_date`, `create_user`,`unixtimestamp`,`status_code`) VALUES (";
         
        $q.="'".self::$driver->escapeString($log->api_url)."',";
        $q.="'".self::$driver->escapeString($log->api_data)."',";
        $q.="'".self::$driver->escapeString($log->api_description)."',";
        $q.="'".self::$driver->escapeString($log->realm)."',";
        $q.="'".self::$driver->escapeString($log->voucher)."',";
        $q.="'".self::$driver->escapeString($log->mobile)."',";
        $q.="'".self::$driver->escapeString($log->function)."',";
        $q.="'".self::$driver->escapeString($log->mno_id)."',";
        $q.="'".self::$driver->escapeString($log->user_distributor)."',";
        $q.="'".self::$driver->escapeString($log->account_number)."',";
        $q.="'".self::$driver->escapeString($log->create_date)."',";
        $q.="'".self::$driver->escapeString($log->create_user)."',";
        $q.="'".self::$driver->escapeString($log->timestamp)."',";
        $q.="'".self::$driver->escapeString($log->status)."' )";

        return self::$driver->insert($q);
    }

    public function view($id)
    {
        $q = "SELECT * FROM other_api_logs WHERE id='$id'";
        return self::$driver->query($q);
    }
}