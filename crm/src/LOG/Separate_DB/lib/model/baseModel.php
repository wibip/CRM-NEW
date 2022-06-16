<?php
class baseModel{
    protected static function connect($config)
    {


        require_once dirname(__FILE__) . '/../drivers/'.$config['drive'].'.php';
        $driverConfig = new DriverConfig();
        $driverConfig->host = $config['host'];
        $driverConfig->db_user = $config['db_user'];
        $driverConfig->db_password = $config['db_password'];
        $driverConfig->db = $config['db'];
        return mysql::getConnection($driverConfig);
        



        /*switch ($config['drive']) {
            case 'mysql':
                require_once dirname(__FILE__) . '/../drivers/mysql.php';
                $driverConfig = new DriverConfig();
                $driverConfig->host = $config['host'];
                $driverConfig->db_user = $config['db_user'];
                $driverConfig->db_password = $config['db_password'];
                $driverConfig->db = $config['db'];
                return mysql::getConnection($driverConfig);
                break;
            case 'mysqli':
                require_once dirname(__FILE__) . '/../drivers/mysql.php';
                $driverConfig = new DriverConfig();
                $driverConfig->host = $config['host'];
                $driverConfig->db_user = $config['db_user'];
                $driverConfig->db_password = $config['db_password'];
                $driverConfig->db = $config['db'];
                return mysql::getConnection($driverConfig);
                break;
        }*/

    }
}