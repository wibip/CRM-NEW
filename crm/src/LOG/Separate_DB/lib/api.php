<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

/*HTTP Basic auth*/
function require_auth() {
    $AUTH_USER = 'bi-admin';
    $AUTH_PASS = 'bi-admin-log-api';
    header('Cache-Control: no-cache, must-revalidate, max-age=0');
    $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
    $is_not_authenticated = (
        !$has_supplied_credentials ||
        $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
        $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
    );
    if ($is_not_authenticated) {
        header('HTTP/1.1 401 Authorization Required');
        header('WWW-Authenticate: Basic realm="Access denied"');
        exit;
    }
}

require_auth();

require 'webApi.php';
use Vanen\Mvc\Api;
use Vanen\Mvc\ApiController;
use Vanen\Net\HttpResponse;
class Log
{

}
class LogsController extends ApiController
{
    private $logs = [];
    private $isXml = false;

    public function __controller()
    {
        $this->JSON_OPTIONS = JSON_PRETTY_PRINT;
        $this->RESPONSE_TYPE = $this->OPTIONS[0];
        $this->isXml = strcasecmp($this->RESPONSE_TYPE, 'xml') === 0;

    }

    /** :POST :/{controller}/{$type}.(json|xml)/ */
    public function read($type)
    {
        $jsonData = self::JsonData();

        switch ($type) {
            case 'vsz':
                include_once dirname(__FILE__) . '/model/vszModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = vszModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;

            case 'denied':
                include_once dirname(__FILE__) . '/model/deniedModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = deniedModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;

            case 'firwall':
                include_once dirname(__FILE__) . '/model/firwallModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = firwallModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;

            case 'other':
                include_once dirname(__FILE__) . '/model/otherModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = otherModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;

            case 'aaa':
                include_once dirname(__FILE__) . '/model/aaaModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = aaaModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;


            case 'session':
                include_once dirname(__FILE__) . '/model/sessionModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = sessionModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;
            case 'dsf':
                include_once dirname(__FILE__) . '/model/dsfModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = dsfModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;
            case 'zabbix':
                include_once dirname(__FILE__) . '/model/zabbixModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = zabbixModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;
            case 'user':
                include_once dirname(__FILE__) . '/model/userModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = userModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;
            case 'tech':
                include_once dirname(__FILE__) . '/model/techModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = techModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;
            case 'redirection':
                include_once dirname(__FILE__) . '/model/redirectionModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = redirectionModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;
            case 'point':
                include_once dirname(__FILE__) . '/model/pointionModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = pointModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;
                break;
            case 'property':

                include_once dirname(__FILE__) . '/model/propertyModel.php';

                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = propertyModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;

                break;
            case 'propertycurrent':
                include_once dirname(__FILE__) . '/model/propertyModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = propertyModel::getModel()->readcurrent($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;

                break;
            case 'propertyactivity':
                include_once dirname(__FILE__) . '/model/propertyModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = propertyModel::getModel()->propertyactivity($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;

                break;
            case 'access':
                include_once dirname(__FILE__) . '/model/accessModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = accessModel::getModel()->read($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;

                break;
            case 'error':
                include_once dirname(__FILE__) . '/model/accessModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = accessModel::getModel()->readerror($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;

                break;
            case 'api':
                include_once dirname(__FILE__) . '/model/accessModel.php';
                $filterLog = new Log();
                foreach ($jsonData as $key => $value) {
                    $filterLog->$key = $value;
                }

                //return array($filterLog);

                $data = accessModel::getModel()->readapi($filterLog);
                foreach ($data as $row) {
                    $resLog = new Log();
                    foreach ($row as $key => $value) {
                        $resLog->$key = $value;
                    }
                    $this->logs[] = $resLog;
                }

                return $this->isXml ? [
                    'logs' => $this->logs
                ] : $this->logs;

                break;
            default :
                return new HttpResponse(404, 'Not Found', (object)[
                    'exception' => (object)[
                        'type' => 'NotFoundApiException',
                        'message' => $type . ' not found',
                        'code' => 404
                    ]
                ]);
        }


    }

    /** :GET :/{controller}/{$type}/{$id}.(json|xml)/ */
    
    public function View($type,$id)
    {
        
        if(isset($id)){

            switch ($type){
                case 'vsz':
                    include_once dirname(__FILE__).'/model/vszModel.php';
                    
    
                    $data =  vszModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;

                case 'firwall':
                    include_once dirname(__FILE__).'/model/firwallModel.php';
                    
    
                    $data =  vszModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;
                case 'other':
                    include_once dirname(__FILE__).'/model/otherModel.php';
                   
                   
                    $data =  otherModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;
                
    
                case 'aaa':
                    include_once dirname(__FILE__).'/model/aaaModel.php';
                   
                   
                    $data =  aaaModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;
                
    
                case 'session':
                    include_once dirname(__FILE__).'/model/sessionModel.php';
                    
    
                    $data =  sessionModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;

                case 'dsf':
                    include_once dirname(__FILE__).'/model/dsfModel.php';
                   
                    $data =  dsfModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;
                case 'zabbix':
                    include_once dirname(__FILE__).'/model/zabbixModel.php';
                   
                    $data =  zabbixModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;

                case 'user':
                    include_once dirname(__FILE__).'/model/userModel.php';
                     
    
                    $data =  userModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;

                case 'tech':
                    include_once dirname(__FILE__).'/model/techModel.php';
                    
                    $data =  techModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;

                case 'redirection':
                    include_once dirname(__FILE__).'/model/redirectionModel.php';
    
                    $data =  redirectionModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;

                case 'point':
                    include_once dirname(__FILE__).'/model/pointionModel.php';
                    
                    $data =  pointModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
                    break;
                case 'property':
    
                    include_once dirname(__FILE__).'/model/propertyModel.php';
    
                    $data =  propertyModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
    
                    break;

                case 'propertycurrent':
                    include_once dirname(__FILE__).'/model/propertyModel.php';
                      
                    $data =  propertyModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
    
                    break;
                 case 'propertyactivity':
                    include_once dirname(__FILE__).'/model/propertyModel.php';
                      
                    $data =  propertyModel::getModel()->view($id);
                    foreach ($data as $row){
                        $resLog = new Log();
                        foreach ($row as $key=>$value){
                            $resLog->$key=$value;
                        }
                        $this->logs[] = $resLog;
                    }
    
                        return $this->isXml ? [
                            'logs' => $this->logs
                        ] : $this->logs;
    
                    break;
                default :
                    return new HttpResponse(404, 'Not Found', (object)[
                        'exception' => (object)[
                            'type' => 'NotFoundApiException',
                            'message' => $type.' not found',
                            'code' => 404
                        ]
                    ]);
            }

        }else{
        return new HttpResponse(404, 'Not Found', (object)[
            'exception' => (object)[
                'type' => 'NotFoundApiException',
                'message' => 'Product not found',
                'code' => 404
            ]
        ]);
            }
    }

    /** :POST :/{controller}/{$type}/{$action}.(json|xml)/ */
    public function Action($type,$action)
    {
        switch ($action){
            case 'create':
                return $this->create($type);
                break;
            default:
                return new HttpResponse(405, 'Not Allowed', (object)[
                    'exception' => (object)[
                        'type' => 'Action Not Allowed',
                        'message' => '('.$action.') Action Not Allowed',
                        'code' => 200
                    ]
                ]);

                break;
        }
    }

    private function create($type)
    {
        switch ($type){
            case 'vsz':
                include_once dirname(__FILE__).'/model/vszModel.php';
                $data = self::JsonData();
                $log = new Log();

                
                $log->function = isset($data["function"])?$data["function"]:'';
                $log->function_name = isset($data["function_name"])?$data["function_name"]:'';
                $log->description = isset($data["description"])?$data["description"]:'';
                $log->api_method = isset($data["api_method"])?$data["api_method"]:'';
                $log->api_status = isset($data["api_status"])?$data["api_status"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->api_description = isset($data["api_description"])?$data["api_description"]:'';
                $log->api_data = isset($data["api_data"])?$data["api_data"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return vszModel::getModel()->insert($log);
                break;
               // require_once dirname(__FILE__).'/model/vszModel.php';

            case 'denied':
                include_once dirname(__FILE__).'/model/deniedModel.php';
                $data = self::JsonData();
                $log = new Log();


                $log->mac = isset($data["mac"])?$data["mac"]:'';
                $log->eId = isset($data["e_id"])?$data["e_id"]:'';
                $log->e_description = isset($data["e_description"])?$data["e_description"]:'';
                $log->src = isset($data["src"])?$data["src"]:'';
                $log->token = isset($data["token"])?$data["token"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return deniedModel::getModel()->insert($log);
                break;
            // require_once dirname(__FILE__).'/model/vszModel.php';


            case 'firwall':
                include_once dirname(__FILE__).'/model/firwallModel.php';
                $data = self::JsonData();
                $log = new Log();

                
                $log->function = isset($data["function"])?$data["function"]:'';
                $log->function_name = isset($data["function_name"])?$data["function_name"]:'';
                $log->description = isset($data["description"])?$data["description"]:'';
                $log->api_method = isset($data["api_method"])?$data["api_method"]:'';
                $log->api_status = isset($data["api_status"])?$data["api_status"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->api_description = isset($data["api_description"])?$data["api_description"]:'';
                $log->api_data = isset($data["api_data"])?$data["api_data"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return firwallModel::getModel()->insert($log);
                break;
               // require_once dirname(__FILE__).'/model/firwallModel.php';   
            case 'other':
                include_once dirname(__FILE__).'/model/otherModel.php';
                $data = self::JsonData();
                $log = new Log();

                
                $log->function = isset($data["function"])?$data["function"]:'';
                $log->voucher = isset($data["voucher"])?$data["voucher"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->api_description = isset($data["api_description"])?$data["api_description"]:'';
                $log->api_url = isset($data["api_url"])?$data["api_url"]:'';
                $log->api_data = isset($data["api_data"])?$data["api_data"]:'';
                $log->mobile = isset($data["mobile"])?$data["mobile"]:'';
                $log->user_distributor = isset($data["user_distributor"])?$data["user_distributor"]:'';
                $log->mno_id = isset($data["mno_id"])?$data["mno_id"]:'';
                $log->create_date =  isset($data["create_date"])?$data["create_date"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->account = isset($data["account"])?$data["account"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';
                $log->status = isset($data["status"])?$data["status"]:'';

                return otherModel::getModel()->insert($log);
                break;

            case 'aaa':
                include_once dirname(__FILE__).'/model/aaaModel.php';
                $data = self::JsonData();
                $log = new Log();

                
                $log->function = isset($data["function"])?$data["function"]:'';
                $log->function_name = isset($data["function_name"])?$data["function_name"]:'';
                $log->description = isset($data["description"])?$data["description"]:'';
                $log->api_method = isset($data["api_method"])?$data["api_method"]:'';
                $log->api_status = isset($data["api_status"])?$data["api_status"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->mac = isset($data["mac"])?$data["mac"]:'';
                $log->api_description = isset($data["api_description"])?$data["api_description"]:'';
                $log->api_data = isset($data["api_data"])?$data["api_data"]:'';
                $log->create_date =  isset($data["create_date"])?$data["create_date"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->user_name = isset($data["username"])?$data["username"]:'';
                $log->ale_username = isset($data["ale_username"])?$data["ale_username"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return aaaModel::getModel()->insert($log);
                break;
            case 'session':
                include_once dirname(__FILE__).'/model/sessionModel.php';
                $data = self::JsonData();
                $log = new Log();

                
                $log->function = isset($data["function"])?$data["function"]:'';
                $log->function_name = isset($data["function_name"])?$data["function_name"]:'';
                $log->description = isset($data["description"])?$data["description"]:'';
                $log->api_method = isset($data["api_method"])?$data["api_method"]:'';
                $log->api_status = isset($data["api_status"])?$data["api_status"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->api_description = isset($data["api_description"])?$data["api_description"]:'';
                $log->api_data = isset($data["api_data"])?$data["api_data"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->mac = isset($data["mac"])?$data["mac"]:'';
                $log->ale_username = isset($data["ale_username"])?$data["ale_username"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return sessionModel::getModel()->insert($log);
                //require_once dirname(__FILE__).'/model/vszModel.php';
                break;
            case 'dsf':
                include_once dirname(__FILE__).'/model/dsfModel.php';
                $data = self::JsonData();
                $log = new Log();

                
                $log->function = isset($data["function"])?$data["function"]:'';
                $log->function_name = isset($data["function_name"])?$data["function_name"]:'';
                $log->description = isset($data["description"])?$data["description"]:'';
                $log->api_method = isset($data["api_method"])?$data["api_method"]:'';
                $log->api_status = isset($data["api_status"])?$data["api_status"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->api_description = isset($data["api_description"])?$data["api_description"]:'';
                $log->api_data = isset($data["api_data"])?$data["api_data"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return dsfModel::getModel()->insert($log);
                break;

            case 'zabbix':
                include_once dirname(__FILE__).'/model/zabbixModel.php';
                $data = self::JsonData();
                $log = new Log();

                
                $log->function = isset($data["function"])?$data["function"]:'';
                $log->function_name = isset($data["function_name"])?$data["function_name"]:'';
                $log->description = isset($data["description"])?$data["description"]:'';
                $log->api_method = isset($data["api_method"])?$data["api_method"]:'';
                $log->api_status = isset($data["api_status"])?$data["api_status"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->api_description = isset($data["api_description"])?$data["api_description"]:'';
                $log->api_data = isset($data["api_data"])?$data["api_data"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->create_user = isset($data["create_user"])?$data["create_user"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return zabbixModel::getModel()->insert($log);
                break;

            case 'user':
                include_once dirname(__FILE__).'/model/userModel.php';
                $data = self::JsonData();
                $log = new Log();

                
                $log->username = isset($data["username"])?$data["username"]:'';
                $log->module_name = isset($data["module_name"])?$data["module_name"]:'';
                $log->module_id = isset($data["module_id"])?$data["module_id"]:'';
                $log->task = isset($data["task"])?$data["task"]:'';
                $log->reference = isset($data["reference"])?$data["reference"]:'';
                $log->ip = isset($data["ip"])?$data["ip"]:'';
                $log->distributor = isset($data["distributor"])?$data["distributor"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return userModel::getModel()->insert($log);
                break;
            case 'tech':
                include_once dirname(__FILE__).'/model/techModel.php';
                $data = self::JsonData();
                $log = new Log();
                
                $log->ap_mac = isset($data["ap_mac"])?$data["ap_mac"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->ap_function = isset($data["ap_function"])?$data["ap_function"]:'';
                $log->action = isset($data["action"])?$data["action"]:'';
                $log->reference = isset($data["reference"])?$data["reference"]:'';
                $log->distributor = isset($data["create_user"])?$data["create_user"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return techModel::getModel()->insert($log);
                break;
            case 'redirection':
                include_once dirname(__FILE__).'/model/redirectionModel.php';
                $data = self::JsonData();
                $log = new Log();
                
                $log->url = isset($data["url"])?$data["url"]:'';
                $log->realm = isset($data["realm"])?$data["realm"]:'';
                $log->mac = isset($data["mac"])?$data["mac"]:'';
                $log->type = isset($data["type"])?$data["type"]:'';
                $log->page = isset($data["page"])?$data["page"]:'';
                $log->reference = isset($data["reference"])?$data["reference"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return redirectionModel::getModel()->insert($log);
                break;
            case 'point':
            echo dirname(__FILE__).'/model/pointModel.php';
                include_once dirname(__FILE__).'/model/pointModel.php';
                $data = self::JsonData();
                $log = new Log();
                
                $log->id = isset($data["id"])?$data["id"]:'';
                $log->token = isset($data["token"])?$data["token"]:'';
                $log->detail = isset($data["detail"])?$data["detail"]:'';
                $log->create_date = isset($data["create_date"])?$data["create_date"]:'';
                $log->timestamp = isset($data["timestamp"])?$data["timestamp"]:'';

                return pointModel::getModel()->insert($log);
                break;

                

        }
    }

    private static function JsonData(){
        return json_decode(file_get_contents('php://input'),true);
    }
}
$api = new Api();
$api->handle();