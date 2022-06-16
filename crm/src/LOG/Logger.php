<?php
include_once dirname(__FILE__).'/logObjectProvider.php';
class Logger{
    private static $instance=null;

    private static $activeModule=null;

    private function __construct()
    {
        $this->getActiveModule();
    }

    public static function getLogger()
    {
        if(self::$instance==null)
        {
            self::$instance=new Logger();

        }

        return self::$instance;

    }

    public function InsertLog(logObject $new_log){
        $return = '';
        
        $type = $this->getLogInstance($new_log);

        switch($type){
            case 'vsz':
                $return = self::$activeModule->createLog_VSZ($new_log);
                break;

            case 'Firwall':
                $return = self::$activeModule->createLog_FIRWALL($new_log);
                break;

            case 'aaa':
                $return = self::$activeModule->createLog_AAA($new_log);
                break;

            case 'other':
                $return = self::$activeModule->createLog_Other($new_log);
                break;

            case 'dsf':
                $return = self::$activeModule->createLog_DSF($new_log);
                break;

            case 'zabbix':
                $return = self::$activeModule->createLog_Zabbix($new_log);
                break;

            case 'session':
                $return = self::$activeModule->createLog_SESSION($new_log);
                break;
            
            case 'user':
                $return = self::$activeModule->createLog_USER($new_log);
                break;    

            case 'auth':
                $return = self::$activeModule->createLog_AUTH($new_log);
                break;

            case 'tech':
                $return = self::$activeModule->createLog_TECH($new_log);
                break;

            case 'redirection':
                $return = self::$activeModule->createLog_REDIRECTION($new_log);
                break;
        }

        return $return;
    }

    public function GetLog(logObject $new_log){

        if(empty($new_log->limit)){
            $new_log->limit = 100;
        }

        $return = '';
        $type = $this->getLogInstance($new_log);
        switch($type){
            case 'vsz':
                $return = self::$activeModule->getLogs_VSZ($new_log);
                break;
            case 'Firwall':
                $return = self::$activeModule->getLogs_FIRWALL($new_log);
                break;
            case 'aaa':
                $return = self::$activeModule->getLogs_AAA($new_log);
                break;
            case 'other':
                $return = self::$activeModule->getLogs_Other($new_log);
                break;
            case 'session':
                $return = self::$activeModule->getLogs_SESSION($new_log);
                break;
            case 'auth':
                $return = self::$activeModule->getLogs_AUTH($new_log);
                break;
            case 'user':
                $return = self::$activeModule->getLogs_USER($new_log);
                break;
            case 'redirection':
                $return = self::$activeModule->getLogs_REDIRECTION($new_log);
                break;
            case 'dsf':
                $return = self::$activeModule->getLogs_DSF($new_log);
                break;
            case 'zabbix':
                $return = self::$activeModule->getLogs_Zabbix($new_log);
                break;
            case 'tech':
                $return = self::$activeModule->getLogs_TECH($new_log);
                break;
            case 'denied':
                $return = self::$activeModule->getLogs_denied($new_log);
                break;
        }

        return $return;
    }

    public function ReadLog($id,$type){

        switch($type){
            case 'vsz':
                $return = self::$activeModule->readLog_VSZ($id);
                break;
            case 'Firwall':
                $return = self::$activeModule->readLog_FIRWALL($id);
                break;    
            case 'aaa':
                $return = self::$activeModule->readLog_AAA($id);
                break;
            case 'other':
                $return = self::$activeModule->readLog_Other($id);
                break;
            case 'session':
                $return = self::$activeModule->readLog_SESSION($id);
                break;
            case 'auth':
                $return = self::$activeModule->readLog_AUTH($id);
                break;
            case 'user':
                $return = self::$activeModule->readLog_USER($id);
                break;
            case 'redirection':
                $return = self::$activeModule->readLog_REDIRECTION($id);
                break;
            case 'dsf':
                $return = self::$activeModule->readLog_DSF($id);
                break;
            case 'zabbix':
                $return = self::$activeModule->readLog_Zabbix($id);
                break;
            case 'tech':
                $return = self::$activeModule->readLog_TECH($id);
                break;
            default :
                $return=null;
                break;
        }
        return $return;
    }

    private function getActiveModule(){
        if(self::$activeModule==null)
        {
            $config_file = dirname(__FILE__).'/log_config.json';
            $config_json = file_get_contents($config_file);
            $config = json_decode($config_json,true);

            switch ($config['active']){
                case 'Local_DB':
                    require_once dirname(__FILE__).'/Local_DB/index.php';
                    self::$activeModule = new Local_DB($config['Configurations']['Local_DB']);
                    break;
                case 'Separate_DB':

                    require_once dirname(__FILE__).'/Separate_DB/index.php';
                    self::$activeModule = new Separate_DB($config['Configurations']['Separate_DB']);
                    break;

                case 'NodeJS_Service':

                    require_once dirname(__FILE__).'NodeJS_Service/index.php';

                    self::$activeModule = new NodeJS_Service($config['Configurations']['NodeJS_Service']['URL']);
                    break;

            }

        }
    }

    public function getCustom(object_data $data){ 
     //var_dump($data);
        switch($data->type){
            case 'property_current':
                return  self::$activeModule->getProperty_current_activity_logs($data);

                break;

            case 'property_activity':
                return  self::$activeModule->getProperty_activity_logs($data);

                break;

            case 'property_activity_ui':
                return  self::$activeModule->propertyActivityLog($data);

                break;

            case 'access':
                return  self::$activeModule->accessLog($data);

                break;
            case 'error':
                return  self::$activeModule->errorLog($data);

                break;
            case 'ap_controller':
                return  self::$activeModule->apilog($data);

                break;
        }
    }

    private function getLogInstance($log){
        if($log instanceof vsz_logs){
            return 'vsz';
        }elseif($log instanceof dsf_logs){
            return 'dsf';
        }elseif($log instanceof firwall_logs){
            return 'Firwall';
        }elseif($log instanceof zabbix_logs){
            return 'zabbix';
        }elseif($log instanceof redirection_logs){
            return 'redirection';
        }elseif($log instanceof aaa_logs){
            return 'aaa';
        }elseif($log instanceof session_logs){
            return 'session';
        }elseif($log instanceof auth_log){
            return 'auth';
        }elseif($log instanceof user_logs){
            return 'user';
        }elseif($log instanceof other_logs){
            return 'other';
        }elseif($log instanceof tech_tool_logs){
            return 'tech';
        }elseif ($log instanceof access_denied_log){
            return 'denied';
        }
    }


    public function getObjectProvider(){
        return logObjectProvider::getLogObjectProvider();
    }

}