<?php
require_once dirname(__FILE__).'/baseModel.php';
require_once dirname(__FILE__).'/ModelInterface.php';
class propertyModel extends baseModel implements ModelInterface{

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

        return new propertyModel();
    }

    public function read(Log $log)
    {

        $q ="SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m-%d %h:%i:%s') as month, t.distributor_code as property  FROM admin_user_logs aul JOIN (".$log->select.") AS t ON aul.user_distributor=t.distributor_code WHERE 1=1";

        if(!is_null($log->from))
            $q.=" AND aul.unixtimestamp>='$log->from'";
        if(!is_null($log->to))
            $q.=" AND aul.unixtimestamp<='$log->to'";

         $q.=" ORDER BY aul.unixtimestamp";

        if(!is_null($log->limit)){
            $q.=" LIMIT $log->limit";
        }else{
            $q.=" LIMIT 100";
        }


        return self::$driver->query($q);

    }

     public function readcurrent(Log $log)
    {
        
        $q ="SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m-%d %h:%i:%s') as month, t.distributor_code as property  FROM admin_user_logs aul JOIN ($log->select) AS t ON aul.user_distributor=t.distributor_code WHERE FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m')='".$log->month."'";

      
        //return $q;
        return self::$driver->query($q);

    }

    public function propertyactivity(Log $log)
    {
        //create tmp table
        $tmp = "CREATE TEMPORARY TABLE IF NOT EXISTS exp_tmp_propertyModel (distributor_code VARCHAR(32) NOT NULL, PRIMARY KEY (distributor_code))";
        self::$driver->query($tmp);

        //Empty table
        $empty_tbl = "TRUNCATE TABLE exp_tmp_propertyModel";
        self::$driver->query($empty_tbl);

        //find and insert
        $pat1 = "/'[A-Z]{3}[0-9]{1,}'/i";
        $pat2 = "/'MVNO{1}[0-9]{1,}'/i";

        preg_match_all($pat1, $log->select, $matches1);
        preg_match_all($pat2, $log->select, $matches2);

        $full_arr = array_merge($matches1[0],$matches2[0]);
        $insert = 'insert into  exp_tmp_propertyModel(distributor_code) VALUES ('.implode('),(',$full_arr).')';
        $ins = self::$driver->insert($insert);

        //$q ="SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m-%d %h:%i:%s') as month, t.distributor_code as property  FROM admin_user_logs aul JOIN (SELECT * FROM exp_tmp_propertyModel) AS t ON aul.user_distributor=t.distributor_code WHERE FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') = FROM_UNIXTIME(UNIX_TIMESTAMP()-(60*60*24*30),'%Y-%m')";
        $q ="SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m-%d %h:%i:%s') as month, t.distributor_code as property  FROM admin_user_logs aul JOIN (SELECT * FROM exp_tmp_propertyModel) AS t ON aul.user_distributor=t.distributor_code WHERE aul.unixtimestamp>$log->st1 AND  aul.unixtimestamp<$log->st2";

        $data = self::$driver->query($q);
        //file_put_contents(__DIR__.'/../../../../../export/BusinessID_activity_log/debu'.uniqid().'.txt',$ins);
        return $data;

    }

    public function insert(Log $log)
    {
        /*$q = "INSERT INTO VSZ_LOG(FUNCTION,FUNCTION_NAME,DESCRIPTION,API_METHOD,API_STATUS,REALM,API_DESCRIPTION,API_DATA,CREATE_DATE,CREATE_USER,UNIX_TIMESTAMP) VALUES (";
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


        self::$driver->insert($q);*/
    }

    public function view($id)
    {
        $q = "SELECT * FROM admin_user_logs WHERE `id`='$id'";
        return self::$driver->query($q);
    }
}