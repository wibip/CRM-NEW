<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class dsfModel extends baseModel implements ModelInterface{

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

        return new dsfModel();
    }

    public function read(Log $log)
    {
        $q = "SELECT g.* FROM exp_api_graphs_logs g JOIN exp_log_functions f ON g.function=f.function_name WHERE f.function_type='$log->function_type'";
        if(!is_null($log->function))
            $q.=" AND g.function='$log->function'";
        if(!is_null($log->realm))
            $q.=" AND g.realm='$log->realm'";
        if(!is_null($log->from))
            $q.=" AND g.unixtimestamp>='$log->from'";
        if(!is_null($log->to))
            $q.=" AND g.unixtimestamp<='$log->to'";

        $q.=" ORDER BY `id` DESC";

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
        $q = "INSERT INTO exp_api_graphs_logs(`function`, function_name, description, api_method, api_status, realm, api_description, api_data, create_date, create_user,unixtimestamp) VALUES (";
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
        $q = "SELECT * FROM exp_api_graphs_logs WHERE ID='$id'";
        return self::$driver->query($q);
    }
}