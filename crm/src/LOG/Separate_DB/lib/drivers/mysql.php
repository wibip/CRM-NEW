<?php
require_once dirname(__FILE__).'/driverInterface.php';
class DriverConfig{
    public $host;
    public $db_user;
    public $db_password;
    public $db;
}
class mysql implements driverInterface {
    private static $connection=null;
    private static $instance=null;


    private function __construct(DriverConfig $driverConfig)
    {
        $connect = mysql_connect(
            $driverConfig->host,
            $driverConfig->db_user,
            $driverConfig->db_password,
            true
        );
        mysql_select_db($driverConfig->db,$connect);
        self::$connection = $connect;
    }

    public static function getConnection(DriverConfig $driverConfig)
    {
        if(!is_null(self::$instance))
            return self::$instance;

        return new mysql($driverConfig);
    }
    public function query($query){
        $results = mysql_query($query,self::$connection);
        $data = [];
        while ($row = mysql_fetch_assoc($results)){
            $data[] = $row;
        }
        return $data;
    }

    public function escapeString($scring){
        return mysql_real_escape_string($scring);
    }

    public function insert($query)
    {
        mysql_query($query);
        if(mysql_error(self::$connection)){
            return mysql_error(self::$connection);
        }else{
            return true;
        }
    }
}