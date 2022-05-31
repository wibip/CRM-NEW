<?php
require_once __DIR__.'/../log_interface.php';
require_once __DIR__.'/../../../classes/dbClass.php';

class Separate_DB implements log_interface{

    private $connection;
    private static $api_auth = "bi-admin:bi-admin-log-api";
    private $db_functions;

    public function __construct($config)
    {
        $this->db_functions = new db_functions();
        $host = rtrim($this->db_functions->setVal('camp_base_url','ADMIN'),'/');
        $this->connection = $host.'/src/LOG/Separate_DB/lib/api.php/logs/';
    }

    private function setCurl($url,$method,$jsonData,$RETURNTRANSFER = true){

        $curl = curl_init();
        $opt = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => $RETURNTRANSFER,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Authorization: Basic ". base64_encode(self::$api_auth),
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Type: application/json",
                "accept-encoding: gzip, deflate",
                "cache-control: no-cache"
            ),
        );
        curl_setopt_array($curl,$opt );

        $response = curl_exec($curl);

        //$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function createLog_VSZ(vsz_logs $log)
    {
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getDescription()))
            $postData['description']=$log->getDescription();
        if(!is_null($log->getApiMethod()))
            $postData['api_method']=$log->getApiMethod();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->getApiDescription()))
            $postData['api_description']=$log->getApiDescription();
        if(!is_null($log->getApiData()))
            $postData['api_data']=$log->getApiData();
        if(!is_null($log->getApiStatus()))
            $postData['api_status']=$log->getApiStatus();
        $postData['create_user']='API';
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."vsz/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_VSZ(vsz_logs $log)
    {
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."vsz.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            //print_r($responses);
            foreach ($responses as $value){
                $data_array[] = new vsz_logs(
                    $value['id'],
                    $value['function'],
                    $value['function_name'],
                    $value['description'],
                    $value['api_method'],
                    $value['api_status'],
                    $value['realm'],
                    $value['api_description'],
                    $value['api_data'],
                    $value['create_date'],
                    $value['create_user'],
                    $value['last_update'],
                    $value['unixtimestamp']
                );
            }
        }

        return $data_array;
    }

    public function readLog_VSZ($id)
    {
        $url = $this->connection."vsz/".$id.".json";

        $response = $this->setCurl($url,"GET",'');
        //$data_array = array();
        
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            

            foreach ($responses as $value){
               
                require_once dirname(__FILE__).'/../../../entity/vsz_logs.php';
        $row_log = new vsz_logs(
                    
                    $value['id'],
                    $value['function'],
                    $value['function_name'],
                    $value['description'],
                    $value['api_method'],
                    $value['api_status'],
                    $value['realm'],
                    $value['api_description'],
                    $value['api_data'],
                    $value['create_date'],
                    $value['create_user'],
                    $value['last_update'],
                    $value['unixtimestamp']
        );

    }
}
        return $row_log;

    }

    public function getLogs_denied(access_denied_log $log)
    {
        $postData = array();

        if(!is_null($log->getMac()))
            $postData['mac']=$log->getMAC();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."denied.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            //print_r($responses);
            foreach ($responses as $value){
                $data_array[] = new access_denied_log(
                    $value['id'],
                    $value['mac'],
                    $value['src'],
                    $value['e_id'],
                    $value['e_desc'],
                    $value['token'],
                    $value['create_date'],
                    $value['unix_timestamp']
                );
            }
        }

        return $data_array;
    }

    public function createLog_AAA(aaa_logs $log)
    {
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getDescription()))
            $postData['description']=$log->getDescription();
        if(!is_null($log->getApiMethod()))
            $postData['api_method']=$log->getApiMethod();
        if(!is_null($log->getgroupid()))
            $postData['realm']=$log->getgroupid();
        if(!is_null($log->getMacid()))
            $postData['mac']=$log->getMacid();
        if(!is_null($log->getApiDescription()))
            $postData['api_description']=$log->getApiDescription();
        if(!is_null($log->getApiData()))
            $postData['api_data']=$log->getApiData();
        if(!is_null($log->getApiStatus()))
            $postData['api_status']=$log->getApiStatus();
        if(!is_null($log->getUsername()))
            $postData['username']=$log->getUsername();
        if(!is_null($log->getAleusername()))
            $postData['ale_username']=$log->getAleusername();
        $postData['create_user']='API';
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."aaa/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_AAA(aaa_logs $log)
    {
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getgroupid()))
            $postData['realm']=$log->getgroupid();
        if(!is_null($log->getMacid()))
            $postData['mac']=$log->getMacid();
        if(!is_null($log->getUsername()))
            $postData['username']=$log->getUsername();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."aaa.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            //print_r($responses);
            foreach ($responses as $value){
                $data_array[] = new aaa_logs(
                    $value['id'],
                    $value['function'],
                    $value['function_name'],
                    $value['description'],
                    $value['group_id'],
                    $value['mac_id'],
                    $value['username'],
                    $value['api_method'],
                    $value['api_status'],
                    $value['api_description'],
                    $value['api_data'],
                    $value['create_date'],
                    $value['create_user'],
                    $value['last_update'],
                    $value['unixtimestamp'],
                    $value['ale_username']


                );
            }
        }


        return $data_array;
    }

    public function readLog_AAA($id)
    {
         
        $url = $this->connection."aaa/".$id.".json";

        $response = $this->setCurl($url,"GET",'');
       // $data_array = array();
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            

            foreach ($responses as $value){
         require_once dirname(__FILE__).'/../../../entity/aaa_logs.php';
        $row_log = new aaa_logs(
            $value['id'],
            $value['function'],
            $value['function_name'],
            $value['description'],
            $value['group_id'],
            $value['mac_id'],
            $value['username'],
            $value['api_method'],
            $value['api_status'],
            $value['api_description'],
            $value['api_data'],
            $value['create_date'],
            $value['create_user'],
            $value['last_update'],
            $value['unixtimestamp'],
            $value['ale_username']
        );
        
    }
}


        return $row_log;
    }

    public function createLog_SESSION(session_logs $log)
    {
        $postData = array();
        $log->getRealm();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getDescription()))
            $postData['description']=$log->getDescription();
        if(!is_null($log->getApiMethod()))
            $postData['api_method']=$log->getApiMethod();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->getApiDescription()))
            $postData['api_description']=$log->getApiDescription();
        if(!is_null($log->getApiData()))
            $postData['api_data']=$log->getApiData();
        if(!is_null($log->getApiStatus()))
            $postData['api_status']=$log->getApiStatus();
        if(!is_null($log->getmac()))
            $postData['mac']=$log->getmac();
        if(!is_null($log->getAleusername()))
            $postData['ale_username']=$log->getAleusername();
        $postData['create_user']='API';
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."session/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_SESSION(session_logs $log)
    {
    $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->getmac()))
            $postData['mac']=$log->getmac();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."session.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            
            foreach ($responses as $value){
                $data_array[] = new session_logs(
                    $value['id'],
                    $value['function'],
                    $value['function_name'],
                    $value['description'],
                    $value['api_method'],
                    $value['api_status'],
                    $value['realm'],
                    $value['mac'],
                    $value['api_description'],
                    $value['api_data'],
                    $value['create_date'],
                    $value['create_user'],
                    $value['last_update'],
                    $value['unixtimestamp'],
                    $value['ale_username']

                );
            }
        }
        return $data_array;
    }

    public function readLog_SESSION($id)
    {
        $url = $this->connection."session/".$id.".json";

        $response = $this->setCurl($url,"GET",'');
       // $data_array = array();
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            

            foreach ($responses as $value){
                require_once dirname(__FILE__).'/../../../entity/session_logs.php';

            $row_log = new session_logs(
                $value['id'],
                    $value['function'],
                    $value['function_name'],
                    $value['description'],
                    $value['api_method'],
                    $value['api_status'],
                    $value['realm'],
                    $value['mac'],
                    $value['api_description'],
                    $value['api_data'],
                    $value['create_date'],
                    $value['create_user'],
                    $value['last_update'],
                    $value['unixtimestamp'],
                    $value['ale_username']
            );
        }
        } 
        return $row_log;
    }

    public function createLog_Other(other_logs $log)
    {
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getVoucher()))
            $postData['voucher']=$log->getVoucher();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->getApiDescription()))
            $postData['api_description']=$log->getApiDescription();
        if(!is_null($log->getApiUrl()))
            $postData['api_url']=$log->getApiUrl();
        if(!is_null($log->getApiData()))
            $postData['api_data']=$log->getApiData();
        if(!is_null($log->getMobile()))
            $postData['mobile']=$log->getMobile();
        if(!is_null($log->getUserDistributor()))
            $postData['user_distributor']=$log->getUserDistributor();
        if(!is_null($log->getMnoId()))
            $postData['mno_id']=$log->getMnoId();
        if(!is_null($log->getAccountNumbr()))
            $postData['account']=$log->getAccountNumbr();
        if(!is_null($log->getStatus()))
            $postData['status']=$log->getStatus();
        $postData['create_user']='API';
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();
        $jsonDataEncoded = json_encode($postData);

        $url = $this->connection."other/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_Other(other_logs $log)
    {
    $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."other.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            
            foreach ($responses as $value){
                $data_array[] = new other_logs(
                    $value['id'],
                    $value['api_url'],
                    $value['api_responce'],
                    $value['api_data'],
                    $value['voucher_code'],
                    $value['mobile'],
                    $value['type'],
                    $value['realm'],
                    $value['mno_id'],
                    $value['user_distributer'],
                    $value['create_date'],
                    $value['unixtimestamp'],
                    $value['account_number'],
                    $value['last_update'],
                    $value['status_code']

                );
            }
        }
        return $data_array;
    }

    public function readLog_Other($id)
    {
        $url = $this->connection."other/".$id.".json";

        $response = $this->setCurl($url,"GET",'');
       // $data_array = array();
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            

            foreach ($responses as $value){
                require_once dirname(__FILE__).'/../../../entity/other_logs.php';

            $row_log = new other_logs(
                    $value['id'],
                    $value['api_url'],
                    $value['api_responce'],
                    $value['api_data'],
                    $value['voucher_code'],
                    $value['mobile'],
                    $value['type'],
                    $value['realm'],
                    $value['mno_id'],
                    $value['user_distributer'],
                    $value['create_date'],
                    $value['unixtimestamp'],
                    $value['account_number'],
                    $value['last_update'],
                    $value['status_code']
            );
        }
        } 
        return $row_log;
    }

    public function createLog_AUTH(auth_logs $getData)
    {
        // TODO: Implement createLog_AUTH() method.
    }

    public function getLogs_AUTH(auth_logs $getData)
    {
        // TODO: Implement getLogs_AUTH() method.
    }

    public function readLog_AUTH($id)
    {
        // TODO: Implement readLog_AUTH() method.
    }

    public function createLog_USER(user_logs $getData)
    {
        $postData = array();
        if(!is_null($getData->getUsername()))
            $postData['username']=$getData->getUsername();
        if(!is_null($getData->getModule()))
            $postData['module_name']=$getData->getModule();
        if(!is_null($getData->getModuleId()))
            $postData['module_id']=$getData->getModuleId();
        if(!is_null($getData->getTask()))
            $postData['task']=$getData->getTask();
        if(!is_null($getData->getReference()))
            $postData['reference']=$getData->getReference();
        if(!is_null($getData->getIP()))
            $postData['ip']=$getData->getIP();
        if(!is_null($getData->getUserDistributor()))
            $postData['distributor']=$getData->getUserDistributor();
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."user/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_USER(user_logs $getData)
    {
        $postData = array();
        if(!is_null($getData->getUsername()))
            $postData['username']=$getData->getUsername();
        if(!is_null($getData->from))
            $postData['from']=$getData->from;
        if(!is_null($getData->to))
            $postData['to']=$getData->to;
        if(!is_null($getData->limit))
            $postData['limit']=$getData->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."user.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            //print_r($responses);
            foreach ($responses as $value){
                $data_array[] = new user_logs(
                    $value['id'],
                    $value['user_name'],
                    $value['module_id'],
                    $value['module'],
                    $value['task'],
                    $value['reference'],
                    $value['ip'],
                    $value['user_distributor'],
                    $value['create_date'],
                    $value['unixtimestamp']

                );
            }
        }
        //print_r($data_array);
        return $data_array;
    }

    public function readLog_USER($id)
    {
        $q = "SELECT * FROM admin_user_logs WHERE id='$id'";
        $data = mysql_query($q,$this->connection);

        $row_log = new session_logs();
        while ($row=mysql_fetch_assoc($data)){


            $row_log = new session_logs(
                $value['id'],
                $value['function'],
                $value['function_name'],
                $value['description'],
                $value['realm'],
                $value['mac'],
                $value['api_method'],
                $value['api_status'],
                $value['api_description'],
                $value['api_data'],
                $value['create_date'],
                $value['create_user'],
                $value['last_update'],
                $value['unixtimestamp']
            );
        }
        return $row_log;

    }

    public function createLog_REDIRECTION(redirection_logs $getData)
    {

        $postData = array();
        if(!is_null($getData->getRequest_url()))
            $postData['url']=$getData->getRequest_url();
        if(!is_null($getData->getPage()))
            $postData['page']=$getData->getPage();
        if(!is_null($getData->getReferer()))
            $postData['reference']=$getData->getReferer();
        if(!is_null($getData->getAccType()))
            $postData['type']=$getData->getAccType();
        if(!is_null($getData->getmac()))
            $postData['mac']=$getData->getmac();
        if(!is_null($getData->getGroupId()))
            $postData['realm']=$getData->getGroupId();
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."redirection/create.json";

       $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_REDIRECTION(redirection_logs $log)
    {

        $postData = array();
        if(!is_null($log->getmac()))
            $postData['mac']=$log->getmac();
        if(!is_null($log->getGroupId()))
            $postData['realm']=$log->getGroupId();
        if(!is_null($log->getAccType()))
            $postData['type']=$log->getAccType();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."redirection.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            //print_r($responses);
            foreach ($responses as $value){
                $data_array[] = new redirection_logs(
                $value['id'],
                $value['page'],
                $value['mac'],
                $value['group_id'],
                $value['request_uri'],
                $value['referer'],
                $value['acc_type'],
                $value['create_date'],
                $value['unixtimestamp']

                );
            }
        }

        return $data_array;

    
    }

    public function readLog_REDIRECTION($id)
    {
        $q = "SELECT * FROM admin_user_logs WHERE id='$id'";
        $data = mysql_query($q,$this->connection);

        $data_array = new redirection_logs();
        while ($row=mysql_fetch_assoc($data)){


            $data_array[] = new redirection_logs(
                $value['id'],
                $value['page'],
                $value['mac'],
                $value['group_id'],
                $value['request_uri'],
                $value['referer'],
                $value['acc_type'],
                $value['create_date'],
                $value['unixtimestamp']
            );
        }
        return $data_array;

    }

    public function createLog_DSF(dsf_logs $log)
    {
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getDescription()))
            $postData['description']=$log->getDescription();
        if(!is_null($log->getApiMethod()))
            $postData['api_method']=$log->getApiMethod();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->getApiDescription()))
            $postData['api_description']=$log->getApiDescription();
        if(!is_null($log->getApiData()))
            $postData['api_data']=$log->getApiData();
        if(!is_null($log->getApiStatus()))
            $postData['api_status']=$log->getApiStatus();
        $postData['create_user']='API';
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."dsf/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_DSF(dsf_logs $log)
    {
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $postData['function_type']='DSF';

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."dsf.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            //print_r($responses);
            foreach ($responses as $value){
                $data_array[] = new dsf_logs(
                    $value['id'],
                    $value['function'],
                    $value['function_name'],
                    $value['description'],
                    $value['api_method'],
                    $value['api_status'],
                    $value['realm'],
                    $value['api_description'],
                    $value['api_data'],
                    $value['create_date'],
                    $value['create_user'],
                    $value['last_update'],
                    $value['unixtimestamp']
                );
            }
        }

        return $data_array;
    }

    public function readLog_DSF($id)
    {
        
        $url = $this->connection."dsf/".$id.".json";

        $response = $this->setCurl($url,"GET",'');
       // $data_array = array();
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            

            foreach ($responses as $value){
                
        
        require_once dirname(__FILE__).'/../../../entity/dsf_logs.php';
        $row_log = new dsf_logs(
            $value['id'],
            $value['function'],
            $value['function_name'],
            $value['description'],
            $value['api_method'],
            $value['api_status'],
            $value['realm'],
            $value['api_description'],
            $value['api_data'],
            $value['create_date'],
            $value['create_user'],
            $value['last_update'],
            $value['unixtimestamp']
        );
    }
}
        return $row_log;
    }

    public function createLog_Zabbix(zabbix_logs $log)
    {
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getDescription()))
            $postData['description']=$log->getDescription();
        if(!is_null($log->getApiMethod()))
            $postData['api_method']=$log->getApiMethod();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->getApiDescription()))
            $postData['api_description']=$log->getApiDescription();
        if(!is_null($log->getApiData()))
            $postData['api_data']=$log->getApiData();
        if(!is_null($log->getApiStatus()))
            $postData['api_status']=$log->getApiStatus();
        $postData['create_user']='API';
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."zabbix/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    /*
        $function = $log->getFunction();
        $function_name = $log->getFunctionName();
        $description = $this->connection->escapeDB($log->getDescription());
        $method = $log->getApiMethod();
        $realm = $log->getRealm();
        $api_details = $this->connection->escapeDB($log->getApiDescription());
        $api_data = $this->connection->escapeDB($log->getApiData());
        $api_status = $log->getApiStatus();

        $q = "INSERT INTO `exp_api_graphs_logs`
        (`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,unixtimestamp)
        VALUES ('$realm','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API',UNIX_TIMESTAMP())";


        $query_results=$this->connection->execDB($q);
        if($query_results){
            return true;
        }else{
            return false;
        }
    */}

    public function getLogs_Zabbix(zabbix_logs $log)
    { 
        $postData = array();
        if(!is_null($log->getFunction()))
            $postData['function']=$log->getFunction();
        if(!is_null($log->getFunctionName()))
            $postData['function_name']=$log->getFunctionName();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;
        $postData['function_type']='ZABBIX';

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."zabbix.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            //print_r($responses);
            foreach ($responses as $value){
                $data_array[] = new zabbix_logs(
                    $value['id'],
                    $value['function'],
                    $value['function_name'],
                    $value['description'],
                    $value['api_method'],
                    $value['api_status'],
                    $value['realm'],
                    $value['api_description'],
                    $value['api_data'],
                    $value['create_date'],
                    $value['create_user'],
                    $value['last_update'],
                    $value['unixtimestamp']
                );
            }
        }

        /*$q = "SELECT g.* FROM exp_api_graphs_logs g JOIN exp_log_functions f ON g.function=f.function_name WHERE f.function_type='ZABBIX'";

        foreach(get_object_vars($log) as $property=>$value){

            if($property=='limit') continue;

            if($property=='from'){
                $q.=" AND unixtimestamp>'".$value."'";
                continue;
            }
            if($property=='to'){
                $q.=" AND unixtimestamp<'".$value."'";
                continue;
            }

            $q.=" AND ".$property."='".$value."'";
        }

        if(!empty($log->getFunction()) || !is_null($log->getFunction()) && $log->getFunction()!='all'){
            $q.=" AND function='".$log->getFunction()."'";
        }
        if(!empty($log->getRealm()) || !is_null($log->getRealm())){
            $q.=" AND realm='".$log->getRealm()."'";
        }

        //SET Order BY ID DESC
        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;

        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){
            $row_log = new zabbix_logs(
                $row['id'],
                $row['function'],
                $row['function_name'],
                $row['description'],
                $row['api_method'],
                $row['api_status'],
                $row['realm'],
                $row['api_description'],
                $row['api_data'],
                $row['create_date'],
                $row['create_user'],
                $row['last_update'],
                $row['unixtimestamp']
            );
            array_push($data_array,$row_log);
        }*/

        return $data_array;
    }

    public function readLog_Zabbix($id)
    {
        $url = $this->connection."zabbix/".$id.".json";

        $response = $this->setCurl($url,"GET",'');
       // $data_array = array();
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            

            foreach ($responses as $value){
                
        
        require_once dirname(__FILE__).'/../../../entity/zabbix_logs.php';
        $row_log = new zabbix_logs(
            $value['id'],
            $value['function'],
            $value['function_name'],
            $value['description'],
            $value['api_method'],
            $value['api_status'],
            $value['realm'],
            $value['api_description'],
            $value['api_data'],
            $value['create_date'],
            $value['create_user'],
            $value['last_update'],
            $value['unixtimestamp']
                );
            }
        }
        /*$q="SELECT g.* FROM exp_api_graphs_logs g JOIN exp_log_functions f ON g.function=f.function_name WHERE f.function_type='ZABBIX' AND g.id='$id'";

        $row = $this->connection->select1DB($q);
        require_once dirname(__FILE__).'/../../../entity/zabbix_logs.php';
        $row_log = new zabbix_logs(
            $row['id'],
            $row['function'],
            $row['function_name'],
            $row['description'],
            $row['api_method'],
            $row['api_status'],
            $row['realm'],
            $row['api_description'],
            $row['api_data'],
            $row['create_date'],
            $row['create_user'],
            $row['last_update'],
            $row['unixtimestamp']
        );*/
        return $row_log;
    }

    public function createLog_TECH(tech_tool_logs $log)
    {
        $postData = array();
        if(!is_null($log->getAP_mac()))
            $postData['ap_mac']=$log->getAP_mac();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->getAP_function()))
            $postData['ap_function']=$log->getAP_function();
        if(!is_null($log->getAction()))
            $postData['action']=$log->getAction();
        if(!is_null($log->getReference()))
            $postData['reference']=$log->getReference();
        if(!is_null($log->getCreateDate()))
            $postData['create_date']=$log->getCreateDate();
        if(!is_null($log->getCreateUser()))
            $postData['create_user']=$log->getCreateUser();
        if(!is_null($log->getUnixtimestamp()))
            $postData['timestamp']=$log->getUnixtimestamp();
        /*$postData['create_user']='API';
        $postData['create_date']=date('Y-m-d H:i:s');
        $postData['timestamp']=time();*/
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."tech/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_TECH(tech_tool_logs $log)
    {
            $postData = array();
        if(!is_null($log->getAP_mac()))
            $postData['ap_mac']=$log->getAP_mac();
        if(!is_null($log->getRealm()))
            $postData['realm']=$log->getRealm();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."tech.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            foreach ($responses as $value){
                $data_array[] = new tech_tool_logs(
                    $value['id'],
                    $value['ap_mac'],
                    $value['realm'],
                    $value['ap_function'],
                    $value['action'],
                    $value['reference'],
                    $value['create_date'],
                    $value['create_user'],
                    $value['unixtimestamp']
                );
            }
        }
        return $data_array;

    }

    public function readLog_TECH($id)
    {
        $q = "SELECT * FROM exp_tech_tool_logs WHERE id='$id'";

        $value = $this->connection->select1DB($q);
        require_once dirname(__FILE__).'/../../../entity/dsf_logs.php';
        $row_log = new dsf_logs(
            $value['id'],
            $value['function'],
            $value['function_name'],
            $value['description'],
            $value['api_method'],
            $value['api_status'],
            $value['realm'],
            $value['api_description'],
            $value['api_data'],
            $value['create_date'],
            $value['create_user'],
            $value['last_update'],
            $value['unixtimestamp']
        );
        return $row_log;

    }

    public function getProperty_current_activity_logs(object_data $log)
    {

        $mno_id = $log->mno_id;
        $final=[];

        $query="SELECT parent_id AS property FROM mno_distributor_parent  WHERE mno_id='$mno_id'";
        $query_results=$this->db_functions->selectDB($query);
        foreach ($query_results['data'] as $row){
            $final[]=["property"=>$row['property']];
        }

        $query1="SELECT distributor_code  AS property FROM exp_mno_distributor  WHERE mno_id='$mno_id'";
        $query_results1=$this->db_functions->selectDB($query1);
        foreach($query_results1['data'] as $row){
            $final[]=["property"=>$row['property']];
        }

        /*$final=array();
        if (!empty($resultarr)) {
            array_push($final,$resultarr);
        }
        if (!empty($resultarr1)){
            array_push($final,$resultarr1);
                }*/
       
        //$fullarr=array_push($resultarr,$resultarr1,$resultarr2);
        
        $i=0;
        $test="";
        foreach ($final as  $key => $value) {
            if ($i==0) {
                $test='SELECT '. "'$value[property]'" .'AS distributor_code';
            }
            else{
                $test.=' UNION SELECT '. "'$value[property]'";

            }
           
            $i=$i+1;
            
        }
       // $result=mysql_query($test);

        $postData = array();
        
        $postData['select']=$test;
        $postData['month']=date('Y-m');

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."propertycurrent.json";

       $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            foreach ($responses as $value){
               /*  $data_array[] = new object_data(
                    $value['id'],
                    $value['user_name'],
                    $value['module_id'],
                    $value['module'],
                    $value['task'],
                    $value['reference'],
                    $value['ip'],
                    $value['user_distributor'],
                    $value['create_date'],
                    $value['unixtimestamp']
                ); */

                $row_log = new object_data();
                $row_log->user_name=$value['user_name'];
                $row_log->module=$value['module'];
                $row_log->task=$value['task'];
                $row_log->reference=$value['reference'];
                $row_log->ip=$value['ip'];
                $row_log->property=$value['property'];
                $row_log->month=$value['month'];
                $row_log->unixtimestamp=$value['unixtimestamp'];
    
                
                array_push($data_array,$row_log);
            }
        }
        return $data_array;
        
    }

    public function getProperty_activity_logs(object_data $log)
    {
        $mno_id = $log->mno_id;
        $final=[];
        $query="SELECT parent_id AS property FROM mno_distributor_parent  WHERE mno_id='$mno_id'";
        $query_results=$this->db_functions->selectDB($query);
        foreach($query_results['data'] as $row){
            $final[]=$row;
        }

        $query1="SELECT distributor_code  AS property FROM exp_mno_distributor  WHERE mno_id='$mno_id'";
        $query_results1=$this->db_functions->selectDB($query1);
        foreach($query_results1['data'] as $row){
            $final[]=$row;
        }

       /* $final=array();
        if (!empty($resultarr)) {
            array_push($final,$resultarr);
        }
        if (!empty($resultarr1)){
            array_push($final,$resultarr1);
                }*/
       
        //$fullarr=array_push($resultarr,$resultarr1,$resultarr2);
        
        $i=0;
        $test="";
        foreach ($final as  $key => $value) {
            if ($i==0) {
                $test='SELECT '. "'$value[property]'" .'AS distributor_code';
            }
            else{
                $test.=' UNION SELECT '. "'$value[property]'";

            }
           
            $i=$i+1;
            
        }
        //$result=mysql_query($test);

        $postData = array();
        
        $postData['select']=$test;
        $postData['st1']=$log->stamp1;
        $postData['st2']=$log->stamp2;


        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."propertyactivity.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            foreach ($responses as $value){
                /* $data_array[] = new object_data(
                    $value['id'],
                    $value['user_name'],
                    $value['module_id'],
                    $value['module'],
                    $value['task'],
                    $value['reference'],
                    $value['ip'],
                    $value['user_distributor'],
                    $value['create_date'],
                    $value['unixtimestamp']
                                ); */

            $row_log = new object_data();
            $row_log->user_name=$value['user_name'];
            $row_log->module=$value['module'];
            $row_log->task=$value['task'];
            $row_log->reference=$value['reference'];
            $row_log->ip=$value['ip'];
            $row_log->property=$value['property'];
            $row_log->month=$value['month'];
            $row_log->unixtimestamp=$value['unixtimestamp'];

            
            array_push($data_array,$row_log);
                
            
            }
        }
        return $data_array;
        
    }

    public function propertyActivityLog(object_data $log){
       
        //print_r($data_array);
         $property_id = $log->property;
        //$mno_id = $log->mno_id;
        $final2=[];
        $query="SELECT parent_id AS distributor_code FROM mno_distributor_parent  WHERE parent_id='$property_id'";
        $query_results=$this->db_functions->selectDB($query);
        //print_r($query_results);
        //$resultarr = [];
        foreach ($query_results['data'] as $row){
            //$resultarr[]=["distributor_code"=>$row['distributor_code']];
            $final2[]=["distributor_code"=>$row['distributor_code']];
        }
        //$resultarr=mysql_fetch_assoc($query_results);

        $query2="SELECT distributor_code FROM exp_mno_distributor  WHERE distributor_code='$property_id'";
        $query_results2=$this->db_functions->selectDB($query2);
        //$resultarr2 = [];
        foreach ($query_results2['data'] as $row){
            //$resultarr2[]=["distributor_code"=>$row['distributor_code']];
            $final2[]=["distributor_code"=>$row['distributor_code']];
        }
        //$resultarr2=mysql_fetch_assoc($query_results2);

        $query1="SELECT distributor_code FROM exp_mno_distributor  WHERE parent_id='$property_id'";
        $query_results1=$this->db_functions->selectDB($query1);
        //$resultarr1=[];
        foreach ($query_results1['data'] as $row){
            //$resultarr1[]=["distributor_code"=>$row['distributor_code']];
            $final2[]=["distributor_code"=>$row['distributor_code']];
        }


        /*$final=array();
        if (!empty($resultarr)) {
            array_push($final,$resultarr);
        }
        if (!empty($resultarr1)){
            array_push($final,$resultarr1);
                }
        if (!empty($resultarr2)) {
            array_push($final,$resultarr2);
        }
        //$fullarr=array_push($resultarr,$resultarr1,$resultarr2);
        print_r($final);
        print_r($final2);*/

        $i=0;
        $test="";
        foreach ($final2 as  $key => $value) {

            if ($i==0) {
                $test='SELECT '. "'$value[distributor_code]'" .'AS distributor_code';
            }
            else{
                $test.=' UNION SELECT '. "'$value[distributor_code]'";

            }
           
            $i=$i+1;
            
        }
        /* $result=mysql_query($test); */

        $postData = array();
        
        $postData['select']=$test;
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."property.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
           /*  print_r($responses); */
            foreach ($responses as $value){
                /* $row_log[] = new object_data(
                     $value['id'],
                    $value['user_name'],
                    $value['module_id'],
                    $value['module'],
                    $value['task'],
                    $value['reference'],
                    $value['ip'],
                    $value['user_distributor'],
                    $value['create_date'],
                    $value['unixtimestamp'] 
                   
                ); */

                $row_log = new object_data();
                $row_log->id=$value['id'];
                $row_log->user_name=$value['user_name'];
                $row_log->module=$value['module'];
                $row_log->task=$value['task'];
                $row_log->reference=$value['reference'];
                $row_log->ip=$value['ip'];
                $row_log->property=$value['property'];
                $row_log->month=$value['month'];
                $row_log->user_distributor=$value['user_distributor'];
                $row_log->create_date=$value['create_date'];
                $row_log->unixtimestamp=$value['unixtimestamp'];

            array_push($data_array,$row_log);
            }
        }
        return $data_array;
    }

    public function createLog_POINT(points_logs $log){
        
        $postData = array();
        if(!is_null($log->getAccessId()))
            $postData['id']=$log->getAccessId();
        if(!is_null($log->getToken()))
            $postData['token']=$log->getToken();
        if(!is_null($log->getAccessDetails()))
            $postData['detail']=$log->getAccessDetails();
        if(!is_null($log->getCreateDate()))
            $postData['create_date']=$log->getCreateDate();
        if(!is_null($log->getUnixtimestamp()))
            $postData['timestamp']=$log->getUnixtimestamp();
        
        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."point/create.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {
            return true;
        }else{
            return false;
        }

    }

    public function getLogs_POINT(object_data $log){
           $postData = array();
        if(!is_null($log->getAccessId()))
            $postData['id']=$log->getAccessId();
        if(!is_null($log->getToken()))
            $postData['token']=$log->getToken();
        if(!is_null($log->getAccessDetails()))
            $postData['detail']=$log->getAccessDetails();
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."point.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            foreach ($responses as $value){
                $data_array[] = new tech_tool_logs(
                    $value['access_id'],
                    $value['token'],
                    $value['access_details'],
                    $value['create_date']
                      );
            }
        }
        return $data_array;
          

    }
    public function readLog_POINT($id){
        $q = "SELECT * FROM exp_tech_tool_logs WHERE id='$id'";

        $value = $this->connection->select1DB($q);
        require_once dirname(__FILE__).'/../../../entity/dsf_logs.php';
        $row_log[] = new dsf_logs(
            $value['access_id'],
            $value['token'],
            $value['access_details'],
            $value['create_date']
        );
        return $row_log;

    }

    public function accessLog(object_data $log){
        
        $postData = array();
        if(!is_null($log->ssid))
            $postData['ssid']=$log->ssid;
        if(!is_null($log->mac))
            $postData['mac']=$log->mac;
        if(!is_null($log->email))
            $postData['email']=$log->email;
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;
        if(!is_null($log->distributor))
            $postData['distributor']=$log->distributor;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."access.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            //print_r($responses);
            foreach ($responses as $row){

            $row_log = new object_data();
            $row_log->id=$row['id'];
            $row_log->status_id=$row['status_id'];
            $row_log->description=$row['description'];
            $row_log->access_details=$row['access_details'];
            $row_log->location_id=$row['location_id'];
            $row_log->token_id=$row['token_id'];
            $row_log->mac=$row['mac'];
            $row_log->ssid=$row['ssid'];
            $row_log->email=$row['email'];
            $row_log->customer_id=$row['customer_id'];
            $row_log->create_date=$row['create_date'];
            $row_log->unixtimestamp=$row['unixtimestamp'];
            $row_log->other_parameters=$row['other_parameters'];

            array_push($data_array,$row_log);
        }
        }
        //print_r($data_array);
        return $data_array;
    }



public function errorLog(object_data $log){

    $postData = array();
        if(!is_null($log->ssid))
            $postData['ssid']=$log->ssid;
        if(!is_null($log->mac))
            $postData['mac']=$log->mac;
        if(!is_null($log->email))
            $postData['email']=$log->email;
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;
        if(!is_null($log->distributor))
            $postData['distributor']=$log->distributor;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."error.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            foreach ($responses as $row){

            $row_log = new object_data();
            $row_log->id=$row['id'];
            $row_log->error_id=$row['error_id'];
            $row_log->description=$row['description'];
            $row_log->error_details=$row['error_details'];
            $row_log->location_id=$row['location_id'];
            $row_log->token_id=$row['token_id'];
            $row_log->mac=$row['mac'];
            $row_log->ssid=$row['ssid'];
            $row_log->email=$row['email'];
            $row_log->customer_id=$row['customer_id'];
            $row_log->create_date=$row['create_date'];
            $row_log->unixtimestamp=$row['unixtimestamp'];
            $row_log->other_parameters=$row['other_parameters'];

            array_push($data_array,$row_log);
        }
        }
        return $data_array;
    
    }

public function apiLog(object_data $log){
    //$api_realm=$log->realm;

    $postData = array();
        if(!is_null($log->realm))
            $postData['realm']=$log->realm;
        if(!is_null($log->function))
            $postData['function']=$log->function;
        if(!is_null($log->from))
            $postData['from']=$log->from;
        if(!is_null($log->to))
            $postData['to']=$log->to;
        if(!is_null($log->limit))
            $postData['limit']=$log->limit;

        $jsonDataEncoded = json_encode($postData);
        $url = $this->connection."api.json";

        $response = $this->setCurl($url,"POST",$jsonDataEncoded);
        $data_array = [];
        if (stripos($response,'cURL Error #:') === false) {

            $responses = json_decode($response,true);
            foreach ($responses as $row){

            $row_log = new object_data();
            $row_log->id=$row['id'];
            $row_log->function_name=$row['function_name'];
            $row_log->description=$row['description'];
            $row_log->api_status=$row['api_status'];
            $row_log->api_method=$row['api_method'];
            $row_log->api_description=$row['api_description'];
            $row_log->realm=$row['realm'];
            $row_log->create_date=$row['create_date'];
            $row_log->unixtimestamp=$row['unixtimestamp'];
            $row_log->other_parameters=$row['other_parameters'];

            array_push($data_array,$row_log);
        }
        }
        return $data_array;
    }





    

public function createLog_FIRWALL(firwall_logs $log)
{
    $postData = array();
    if(!is_null($log->getFunction()))
        $postData['function']=$log->getFunction();
    if(!is_null($log->getFunctionName()))
        $postData['function_name']=$log->getFunctionName();
    if(!is_null($log->getDescription()))
        $postData['description']=$log->getDescription();
    if(!is_null($log->getApiMethod()))
        $postData['api_method']=$log->getApiMethod();
    if(!is_null($log->getRealm()))
        $postData['realm']=$log->getRealm();
    if(!is_null($log->getApiDescription()))
        $postData['api_description']=$log->getApiDescription();
    if(!is_null($log->getApiData()))
        $postData['api_data']=$log->getApiData();
    if(!is_null($log->getApiStatus()))
        $postData['api_status']=$log->getApiStatus();
    $postData['create_user']='API';
    $postData['create_date']=date('Y-m-d H:i:s');
    $postData['timestamp']=time();
    $jsonDataEncoded = json_encode($postData);
    $url = $this->connection."firwall/create.json";

    $response = $this->setCurl($url,"POST",$jsonDataEncoded);
    $data_array = [];
    if (stripos($response,'cURL Error #:') === false) {
        return true;
    }else{
        return false;
    }
}

public function getLogs_FIRWALL(firwall_logs $log)
{
    $postData = array();
    if(!is_null($log->getFunction()))
        $postData['function']=$log->getFunction();
    if(!is_null($log->getFunctionName()))
        $postData['function_name']=$log->getFunctionName();
    if(!is_null($log->getRealm()))
        $postData['realm']=$log->getRealm();
    if(!is_null($log->from))
        $postData['from']=$log->from;
    if(!is_null($log->to))
        $postData['to']=$log->to;
    if(!is_null($log->limit))
        $postData['limit']=$log->limit;

    $jsonDataEncoded = json_encode($postData);
    $url = $this->connection."firwall.json";

    $response = $this->setCurl($url,"POST",$jsonDataEncoded);
    $data_array = [];
    if (stripos($response,'cURL Error #:') === false) {

        $responses = json_decode($response,true);
        //print_r($responses);
        foreach ($responses as $value){
            $data_array[] = new firwall_logs(
                $value['id'],
                $value['function'],
                $value['function_name'],
                $value['description'],
                $value['api_method'],
                $value['api_status'],
                $value['realm'],
                $value['api_description'],
                $value['api_data'],
                $value['create_date'],
                $value['create_user'],
                $value['last_update'],
                $value['unixtimestamp']
            );
        }
    }

    return $data_array;
}

public function readLog_FIRWALL($id)
{
    $url = $this->connection."firwall/".$id.".json";

    $response = $this->setCurl($url,"GET",'');
    //$data_array = array();
    
    if (stripos($response,'cURL Error #:') === false) {

        $responses = json_decode($response,true);
        

        foreach ($responses as $value){
           
            require_once dirname(__FILE__).'/../../../entity/firwall_logs.php';
    $row_log = new firwall_logs(
                
                $value['id'],
                $value['function'],
                $value['function_name'],
                $value['description'],
                $value['api_method'],
                $value['api_status'],
                $value['realm'],
                $value['api_description'],
                $value['api_data'],
                $value['create_date'],
                $value['create_user'],
                $value['last_update'],
                $value['unixtimestamp']
    );

}
}
    return $row_log;

}



}