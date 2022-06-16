<?php
class logObjectProvider{

    private static $instance;

    private function __construct()
    {
    }

    public static function getLogObjectProvider(){
        if(!is_null(self::$instance)){
            return self::$instance;
        }

        return self::$instance = new logObjectProvider();
    }

    /*public function getLogObject($type){
        switch ($type){
            case 'vsz':
                require_once dirname(__FILE__).'/model/vsz_logs.php';
                return new vsz_logs();
                break;
            case 'dsf':
                require_once dirname(__FILE__).'/model/dsf_logs.php';
                return new dsf_logs();
                break;
            case 'aaa':
                require_once dirname(__FILE__).'/model/aaa_logs.php';
                return new aaa_logs();
                break;
            case 'session':
                require_once dirname(__FILE__).'/model/session_logs.php';
                return new session_logs();
                break;
            case 'auth':
                require_once dirname(__FILE__).'/model/auth_logs.php';
                return new auth_logs();
                break;
            case 'redirection':
                require_once dirname(__FILE__).'/model/redirection_logs.php';
                return new redirection_logs();
                break;
            case 'user':
                require_once dirname(__FILE__).'/model/user_logs.php';
                return new user_logs();
                break;
            case 'tech_tool':
                require_once dirname(__FILE__).'/model/tech_tool_logs.php';
                return new tech_tool_logs();
                break;
        }
    }*/

    public function getObjectVsz(){
        require_once dirname(__FILE__).'/../../entity/vsz_logs.php';
        return new vsz_logs();
    }

    public function getObjectFirwall(){
        require_once dirname(__FILE__).'/../../entity/firwall_logs.php';
        return new firwall_logs();
    }

    public function getObjectDsf(){
        require_once dirname(__FILE__).'/../../entity/dsf_logs.php';
        return new dsf_logs();
    }
    public function getObjectZabbix(){
        require_once dirname(__FILE__).'/../../entity/zabbix_logs.php';
        return new zabbix_logs();
    }

    public function getObjectAaa(){
        require_once dirname(__FILE__).'/../../entity/aaa_logs.php';
        return new aaa_logs();
    }

    public function getObjectSession(){
        require_once dirname(__FILE__).'/../../entity/session_logs.php';
        return new session_logs();
    }

    public function getObjectAuth(){
        require_once dirname(__FILE__).'/../../entity/auth_logs.php';
        return new auth_logs();
    }

    public function getObjectRedirection(){
        require_once dirname(__FILE__).'/../../entity/redirection_logs.php';
        return new redirection_logs();
    }

    public function getObjectUser(){
        require_once dirname(__FILE__).'/../../entity/user_logs.php';
        return new user_logs();
    }

    public function getObjectOther(){
        require_once dirname(__FILE__).'/../../entity/other_logs.php';
        return new other_logs();
    }

    public function getObjectTechTool(){
        require_once dirname(__FILE__).'/../../entity/tech_tool_logs.php';
        return new tech_tool_logs();
    }

    public function getObjectAbuse(){
        require_once dirname(__FILE__).'/../../entity/abuse_log.php';
        return new abuse_log();
    }

    public function getObjectDeni(){
        require_once dirname(__FILE__).'/../../entity/access_denied_log.php';
        return new access_denied_log();
    }
}