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
        $connect = mysqli_connect(
            $driverConfig->host,
            $driverConfig->db_user,
            $driverConfig->db_password,
            $driverConfig->db
        );
        //mysqli_select_db($connect,);
        self::$connection = $connect;
    }

    public static function getConnection(DriverConfig $driverConfig)
    {
        if(!is_null(self::$instance))
            return self::$instance;

        return new mysql($driverConfig);
    }
    public function query($query){
        $results = mysqli_query(self::$connection,$query);
        $data = [];
        while ($row = mysqli_fetch_assoc($results)){
            $data[] = $row;
        }
        return $data;
    }

    public function escapeString($scring){
        return mysqli_real_escape_string(self::$connection,$scring);
    }

    public function insert($query)
    {
        mysqli_query(self::$connection,$query);
        if(mysqli_error(self::$connection)){
            return mysqli_error(self::$connection);
        }else{
            return true;
        }
    }
}