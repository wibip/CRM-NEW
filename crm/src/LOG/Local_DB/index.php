<?php

require_once dirname(__FILE__).'/../log_interface.php';
class Local_DB implements log_interface {

    private $connection;

    public function __construct($config)
    {
        require_once dirname(__FILE__).'/../../../classes/dbClass.php';

        $connect = new db_functions();

        //$connect = new Local_DB($logConnection);

        $this->connection = $connect;
    }

    public function createLogs_denied( access_denied_log $log)
    {
        $mac = $log->getMac();
        $description = $this->connection->escapeDB($log->getEDesc());
        $eId = $log->getEId();
        $src = $log->getSrc();
        $token = $this->connection->escapeDB($log->getToken());

        

        $q = "INSERT INTO `exp_access_deni_log`
		(mac, src, e_id, e_desc, token, create_date,unix_timestamp)
        VALUES ('$mac','$src','$description', '$token',NOW(),UNIX_TIMESTAMP())";
        

        $query_results=$this->connection->execDB($q);
        if($query_results){
            return true;
        }else{
            return false;
        }
    }


    public function createLog_VSZ( vsz_logs $log)
    {
        $function = $log->getFunction();
        $function_name = $log->getFunctionName();
        $description = $this->connection->escapeDB($log->getDescription());
        $method = $log->getApiMethod();
        $realm = $log->getRealm();
        $api_details = $this->connection->escapeDB($log->getApiDescription());
        $api_data = $this->connection->escapeDB($log->getApiData());
        $api_status = $log->getApiStatus();



        $q = "INSERT INTO `exp_wag_ap_profile_logs`
		(`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,unixtimestamp)
        VALUES ('$realm','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API',UNIX_TIMESTAMP())";


        $query_results=$this->connection->execDB($q);
        if($query_results){
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_VSZ(vsz_logs $log)
    {


        $q = "SELECT * FROM exp_wag_ap_profile_logs WHERE 1=1";

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

        if(!empty($log->getFunction()) || !is_null($log->getFunction())){
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
            $row_log = new vsz_logs(
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
        }

        return $data_array;
    }

    public function readLog_VSZ($id)
    {
        $q = "SELECT * FROM exp_wag_ap_profile_logs WHERE id='$id'";

        $row = $this->connection->select1DB($q);
        require_once dirname(__FILE__).'/../../../entity/vsz_logs.php';
        $row_log = new vsz_logs(
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
        return $row_log;
    }

    public function getLogs_denied(access_denied_log $log)
    {


        $q = "SELECT * FROM exp_access_deni_log WHERE 1=1";

        if(!empty($log->getMac())){
            $q.=" AND mac='".$log->getMac()."'";
        }

        foreach(get_object_vars($log) as $property=>$value){

            if($property=='limit') continue;

            if($property=='from'){
                $q.=" AND unix_timestamp>'".$value."'";
                continue;
            }
            if($property=='to'){
                $q.=" AND unix_timestamp<'".$value."'";
                continue;
            }

            $q.=" AND ".$property."='".$value."'";
        }

        //SET Order BY ID DESC
        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;


        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){
            $row_log = new access_denied_log(
                $row['id'],
                $row['mac'],
                $row['src'],
                $row['e_id'],
                $row['e_desc'],
                $row['token'],
                $row['create_date'],
                $row['unix_timestamp']
            );
            array_push($data_array,$row_log);
        }

        return $data_array;
    }

    public function createLog_AAA(aaa_logs $log)
    {
        $function = $log->getFunction();
        $function_name = $log->getFunctionName();
        $description = $this->connection->escapeDB($log->getDescription());
        $method = $log->getApiMethod();
        $realm = $log->getgroupid();
        $mac = $log->getMacid();
        $api_details = $this->connection->escapeDB($log->getApiDescription());
        $api_data = $this->connection->escapeDB($log->getApiData());
        $api_status = $log->getApiStatus();
        $username = $log->getUsername();
        $ale_username = $log->getAleusername();

        $q = "INSERT INTO `exp_aaa_logs`
		(`group_id`,`mac_id`,`function`, `function_name`,`description`,`username`,`api_method`, `api_status`, `api_description`, `api_data`,`ale_username`, `create_date`, `create_user`,`unixtimestamp`)
        VALUES ('$realm','$mac','$function','$function_name', '$description','$username','$method', '$api_status', '$api_details', '$api_data','$ale_username', NOW(), 'API',UNIX_TIMESTAMP())";


        $query_results=$this->connection->execDB($q);
        if($query_results){
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_AAA(aaa_logs $log)
    {
        $q = "SELECT * FROM exp_aaa_logs WHERE 1=1";

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

        if(!empty($log->getFunction()) || !is_null($log->getFunction())){
            $q.=" AND function_name='".$log->getFunction()."'";
        }
        if(!empty($log->getgroupid()) || !is_null($log->getgroupid())){
            $q.=" AND group_id='".$log->getgroupid()."'";
        }
        if(!empty($log->getMacid()) || !is_null($log->getMacid())){
            $q.=" AND mac_id='".$log->getMacid()."'";
        }

        //SET Order BY ID DESC
        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;


        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){
            $row_log = new aaa_logs(
                $row['id'],
                $row['function'],
                $row['function_name'],
                $row['description'],
                $row['group_id'],
                $row['mac_id'],
                $row['username'],
                $row['api_method'],
                $row['api_status'],
                $row['api_description'],
                $row['api_data'],
                $row['create_date'],
                $row['create_user'],
                $row['last_update'],
                $row['unixtimestamp'],
                $row['ale_username']
            );
            array_push($data_array,$row_log);
        }

        return $data_array;
    }

    public function readLog_AAA($id)
    {
        $q = "SELECT * FROM exp_aaa_logs WHERE id='$id'";

        $row = $this->connection->select1DB($q);
        require_once dirname(__FILE__).'/../../../entity/aaa_logs.php';
        $row_log = new aaa_logs(
            $row['id'],
                $row['function'],
                $row['function_name'],
                $row['description'],
                $row['group_id'],
                $row['mac_id'],
                $row['username'],
                $row['api_method'],
                $row['api_status'],
                $row['api_description'],
                $row['api_data'],
                $row['create_date'],
                $row['create_user'],
                $row['last_update'],
                $row['unixtimestamp'],
                $row['ale_username']
        );
        return $row_log;
    }

    public function createLog_Other(other_logs $log)
    {
        $function = $log->getFunction();
        $voucher = $log->getVoucher();
        $account_number = $log->getAccountNumbr();
        $realm = $log->getRealm();
        $sf_payment_url = $log->getApiUrl();
        $api_responce = $this->connection->escapeDB($log->getApiDescription());
        $api_data = $this->connection->escapeDB($log->getApiData());
        $mobile = $log->getMobile();
        $mno_id = $log->getMnoId();
        $user_distributor = $log->getUserDistributor();
        $status_code = $log->getStatus();

        $q = "INSERT INTO `other_api_logs`
        (`api_url`,`api_data`,`api_responce`,  `realm`, `status_code`, `voucher_code`, `mobile`,`type`, `mno_id`, `user_distributer`, `account_number`, `create_date`, `create_user`,`unixtimestamp`)
        VALUES ('$sf_payment_url','$api_data','$api_responce', '$realm', '$status_code', '$voucher','$mobile', '$function', '$mno_id', '$user_distributor', '$account_number', NOW(), 'admin', UNIX_TIMESTAMP())";


        $query_results=$this->connection->execDB($q);
        if($query_results){
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_Other(other_logs $log)
    {
        $q = "SELECT * FROM other_api_logs WHERE 1=1";

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

        if(!empty($log->getRealm()) || !is_null($log->getRealm())){
            $q.=" AND realm='".$log->getRealm()."'";
        }
        if(!empty($log->getUserDistributor()) || !is_null($log->getUserDistributor())){
            $q.=" AND mno_id='".$log->getUserDistributor()."'";
        }
        if(!empty($log->getFunction()) || !is_null($log->getFunction())){
            $q.=" AND type='".$log->getFunction()."'";
        }

        //SET Order BY ID DESC
        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;


        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $value){
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
            array_push($data_array,$row_log);
        }

        return $data_array;
    }

    public function readLog_Other($id)
    {
        $q = "SELECT * FROM other_api_logs WHERE id='$id'";

        $value = $this->connection->select1DB($q);
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
        return $row_log;
    }

    public function createLog_SESSION(session_logs $log)
    {
        $function = $log->getFunction();
        $function_name = $log->getFunctionName();
        $description = $this->connection->escapeDB($log->getDescription());
        $method = $log->getApiMethod();
        $realm = $log->getRealm();
        $mac = $log->getmac();
        $api_details = $this->connection->escapeDB($log->getApiDescription());
        $api_data = $this->connection->escapeDB($log->getApiData());
        $api_status = $log->getApiStatus();
        $ale_username = $log->getAleusername();
        //exp_wag_ap_profile_logs
        $q = "INSERT INTO `exp_session_profile_logs`
		(`realm`,`mac`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`,`ale_username`, `create_date`, `create_user`,unixtimestamp)
        VALUES ('$realm','$mac','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data','$ale_username', NOW(), 'API',UNIX_TIMESTAMP())";


        $query_results=$this->connection->execDB($q);
        if($query_results){
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_SESSION(session_logs $log)
    {
        $q = "SELECT * FROM exp_session_profile_logs WHERE 1=1";

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

        if(!empty($log->getFunction()) || !is_null($log->getFunction())){
            $q.=" AND function_name='".$log->getFunction()."'";
        }
        if(!empty($log->getRealm()) || !is_null($log->getRealm())){
            $q.=" AND realm='".$log->getRealm()."'";
        }

     
        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;

       
        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){
         

            $row_log = new session_logs(
                $row['id'],
                $row['function'],
                $row['function_name'],
                $row['description'],
                $row['api_method'],
                $row['api_status'],
                $row['realm'],
                $row['mac'],
                $row['api_description'],
                $row['api_data'],
                $row['create_date'],
                $row['create_user'],
                $row['last_update'],
                $row['unixtimestamp'],
                $row['ale_username']
            );
            array_push($data_array,$row_log);
        }

        return $data_array;
    }

    public function readLog_SESSION($id)
    {
        $q = "SELECT * FROM exp_session_profile_logs WHERE id='$id'";

        $row = $this->connection->select1DB($q);
        require_once dirname(__FILE__).'/../../../entity/session_logs.php';
        $row_log = new session_logs(

            $row['id'],
            $row['function'],
            $row['function_name'],
            $row['description'],
            $row['api_method'],
            $row['api_status'],
            $row['realm'],
            $row['mac'],
            $row['api_description'],
            $row['api_data'],
            $row['create_date'],
            $row['create_user'],
            $row['last_update'],
            $row['unixtimestamp'],
            $row['ale_username']
        );
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
        $user_name = $getData->getUsername();
        $module= $getData->getModuleId();
        $task= $getData->getTask();
        $ref=$getData->getReference();
        $ip = $getData->getIP();
        $user_distributor = $getData->getUserDistributor();

        $q = "INSERT INTO admin_user_logs (`user_name`,module_id,`module`,task,reference,ip,user_distributor,`create_date`,`unixtimestamp`)
  SELECT '$user_name',admin_access_modules.module_name,name_group,'$task','$ref','$ip',admin_users.user_distributor,now(),UNIX_TIMESTAMP()
  FROM admin_access_modules LEFT JOIN admin_users ON admin_access_modules.user_type=admin_users.user_type
  WHERE module_name='$module' AND user_distributor='$user_distributor' LIMIT 1";


        $query_results=$this->connection->execDB($q);
        if($query_results){
            return true;
        }else{
            return false;
        }
    }

    public function getLogs_USER(user_logs $log)
    {
        //$q = "SELECT * FROM exp_session_profile_logs WHERE 1=1";
        $q = "SELECT l.* FROM admin_user_logs l, admin_users u
					WHERE l.user_name = u.user_name";
//AND u.user_distributor = '$user_distributor' AND u.user_type = '$user_type'
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

        }

        if(!empty($log->getUserDistributor()) || !is_null($log->getUserDistributor())){
            $q.=" AND u.user_distributor='".$log->getUserDistributor()."'";
        }
        if(!empty($log->getUserName()) || !is_null($log->getUsername())){
            $q.=" AND u.user_name='".$log->getUserName()."'";
        }


        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;

        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){


            $row_log = new user_logs(
                $row['id'],
                $row['user_name'],
                $row['module'],
                $row['module_id'],
                $row['task'],
                $row['reference'],
                $row['ip'],
                $row['user_distributor'],
                $row['create_date'],
                $row['unixtimestamp'],
                $row['last_update']
            );
            array_push($data_array,$row_log);
        }

        return $data_array;
    }

    public function readLog_USER($id)
    {
        // TODO: Implement readLog_USER() method.
    }

    public function createLog_REDIRECTION(redirection_logs $log)
    {
        $url = urldecode($log->getRequest_url());
        $page = $log->getPage();
        $ref = $log->getReferer();
        $type = $log->getAccType();
        $mac = $log->getmac();
        $group = $log->getGroupId();

        $query = sprintf("INSERT INTO `exp_redirection_log` (`page`, `mac`,`group_id`, `request_uri`, `referer`, `create_date`,`acc_type`,`unixtimestamp`) 
		VALUES ('$page', %s,%s, '$url', '$ref', NOW(), '$type', UNIX_TIMESTAMP())", $mac, $group);

		$this->connection->execDB($query);
    }

    public function getLogs_REDIRECTION(redirection_logs $log)
    {
        $q = "SELECT * FROM exp_redirection_log WHERE `acc_type`='".$log->getAccType()."' ";

        foreach(get_object_vars($log) as $property=>$value){

            if($property=='limit') continue;

            if($property=='from'){
                $q.=" AND `unixtimestamp` >'".$value."'";
                continue;
            }
            if($property=='to'){
                $q.=" AND `unixtimestamp` <'".$value."'";
                continue;
            }

            $q.=" AND ".$property."='".$value."'";
        }

        if(!empty($log->getmac()) || !is_null($log->getmac())){
            $q.=" AND mac='".$log->getmac()."'";
        }
       
        if(!empty($log->getGroupId()) || !is_null($log->getGroupId())){
            $q.=" AND group_id='".$log->getGroupId()."'";
        }

     
        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;

      // echo $q;
        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){
         

            $row_log = new redirection_logs(
                $row['id'],
                $row['page'],
                $row['mac'],
                $row['group_id'],
                $row['request_uri'],
                $row['referer'],
                $row['acc_type'],
                $row['create_date'],
                $row['unixtimestamp']
               
            );
            array_push($data_array,$row_log);
        }

        return $data_array;

    }

    public function readLog_REDIRECTION($id)
    {
        // TODO: Implement readLog_REDIRECTION() method.
    }

    public function createLog_DSF(dsf_logs $log)
    {
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
    }
    public function createLog_Zabbix(zabbix_logs $log)
    {
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
    }

    public function getLogs_DSF(dsf_logs $log)
    {
        $q = "SELECT g.* FROM exp_api_graphs_logs g JOIN exp_log_functions f ON g.function=f.function_name WHERE f.function_type='DSF'";

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
            $row_log = new dsf_logs(
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
        }

        return $data_array;
    }

    public function getLogs_Zabbix(zabbix_logs $log)
    { 
        $q = "SELECT g.* FROM exp_api_graphs_logs g JOIN exp_log_functions f ON g.function=f.function_name WHERE f.function_type='ZABBIX'";

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
        }

        return $data_array;
    }

    public function readLog_DSF($id)
    {
        $q="SELECT g.* FROM exp_api_graphs_logs g JOIN exp_log_functions f ON g.function=f.function_name WHERE f.function_type='DSF' AND g.id='$id'";

        $row = $this->connection->select1DB($q);
        require_once dirname(__FILE__).'/../../../entity/dsf_logs.php';
        $row_log = new dsf_logs(
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
        return $row_log;
    }

    public function readLog_Zabbix($id)
    {
        $q="SELECT g.* FROM exp_api_graphs_logs g JOIN exp_log_functions f ON g.function=f.function_name WHERE f.function_type='ZABBIX' AND g.id='$id'";

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
        );
        return $row_log;
    }

    public function createLog_TECH(tech_tool_logs $log)
    {
        $ap_mac=$log->getAP_mac();
        $realm=$log->getRealm();
        $function=$log->getAP_function();
        $action=$log->getAction();
        $reference=$log->getReference();
        $create_user=$log->getCreateUser();

        $log_q = "INSERT INTO exp_tech_tool_logs(ap_mac, realm, ap_function, action, reference, create_date, create_user,unixtimestamp) 
  VALUE ('$ap_mac','$realm','$function','$action','$reference',NOW(),'$create_user',UNIX_TIMESTAMP())";

        $this->connection->execDB($log_q);
    }

    public function getLogs_TECH(tech_tool_logs $log)
    {
        $q = "SELECT * FROM exp_tech_tool_logs WHERE 1=1 ";

        foreach(get_object_vars($log) as $property=>$value){

            if($property=='limit') continue;

            if($property=='from'){
                $q.=" AND `unixtimestamp` >'".$value."'";
                continue;
            }
            if($property=='to'){
                $q.=" AND `unixtimestamp` <'".$value."'";
                continue;
            }

            $q.=" AND ".$property."='".$value."'";
        }

        if(!empty($log->getAP_mac()) || !is_null($log->getAP_mac())){
            $q.=" AND ap_mac='".$log->getAP_mac()."'";
        }
       
        if(!empty($log->getRealm()) || !is_null($log->getRealm())){
            $q.=" AND realm='".$log->getRealm()."'";
        }
     
        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;

      //  echo $q;
        $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){
         

            $row_log = new tech_tool_logs(
                $row['id'],
                $row['ap_mac'],
                $row['realm'],
                $row['ap_function'],
                $row['action'],
                $row['reference'],
                $row['create_date'],
                $row['create_user'],
                $row['last_update'],
                $row['unixtimestamp']
               
            );
            array_push($data_array,$row_log);
        }

        return $data_array;

    }

    public function readLog_TECH($id)
    {
        // TODO: Implement readLog_TECH() method.
    }

    public function getProperty_current_activity_logs(object_data $log)
    {
        $mno_id = $log->mno_id;

        $q = "SELECT * FROM (
            SELECT aul.*, parent_id AS property FROM admin_user_logs aul JOIN mno_distributor_parent mdp ON aul.user_distributor=mdp.parent_id
            WHERE mdp.mno_id='$mno_id' AND FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
            UNION
            SELECT aul.*, emd.verification_number  AS property FROM admin_user_logs aul JOIN exp_mno_distributor emd ON aul.user_distributor=emd.distributor_code
            WHERE emd.mno_id='$mno_id' AND FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
            ) t
            ORDER BY t.unixtimestamp";

            $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){
         
          
           //a require_once dirname(__FILE__).'/../../../DTO/object_data.php';
            $row_log = new object_data();
            $row_log->user_name=$row['user_name'];
            $row_log->module=$row['module'];
            $row_log->task=$row['task'];
            $row_log->reference=$row['reference'];
            $row_log->ip=$row['ip'];
            $row_log->property=$row['property'];
            $row_log->month=$row['month'];
            $row_log->unixtimestamp=$row['unixtimestamp'];

            
            array_push($data_array,$row_log);
        }
        //print_r($data_array);
        return $data_array;
        
    }

    public function getProperty_activity_logs(object_data $log)
    {
        $mno_id = $log->mno_id;

        $q = "SELECT * FROM (
            SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') as month, parent_id AS property  FROM admin_user_logs aul JOIN mno_distributor_parent mdp ON aul.user_distributor=mdp.parent_id
            WHERE mdp.mno_id='$mno_id' AND FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') = FROM_UNIXTIME(UNIX_TIMESTAMP()-(60*60*24*30),'%Y-%m')
            UNION
            SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') as month, emd.verification_number  AS property FROM admin_user_logs aul JOIN exp_mno_distributor emd ON aul.user_distributor=emd.distributor_code
            WHERE emd.mno_id='$mno_id' AND FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m') = FROM_UNIXTIME(UNIX_TIMESTAMP()-(60*60*24*30),'%Y-%m')
        ) t
        ORDER BY t.unixtimestamp";

            $data = $this->connection->selectDB($q);

        $data_array = array();
        foreach ($data['data'] as $row){
         
          
           //a require_once dirname(__FILE__).'/../../../DTO/object_data.php';
            $row_log = new object_data();
            $row_log->user_name=$row['user_name'];
            $row_log->module=$row['module'];
            $row_log->task=$row['task'];
            $row_log->reference=$row['reference'];
            $row_log->ip=$row['ip'];
            $row_log->property=$row['property'];
            $row_log->month=$row['month'];
            $row_log->unixtimestamp=$row['unixtimestamp'];

            
            array_push($data_array,$row_log);
        }
        //print_r($data_array);
        return $data_array;
        
    }

    public function propertyActivityLog(object_data $log){
        $property_id = $log->property;
        if(empty($log->limit)){
            $log->limit = 100;
        }
        if(!empty($log->from)){
            $from = " AND aul.unixtimestamp >'$log->from'";
        }
        if(!empty($log->to)){
            $to = " AND aul.unixtimestamp <'$log->to'";
        }


        $q = "SELECT * FROM (
                SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m-%d %h:%i:%s') as month, parent_id AS property  FROM admin_user_logs aul JOIN mno_distributor_parent mdp ON aul.user_distributor=mdp.parent_id
                WHERE mdp.parent_id='".$property_id."'".$from.$to."
                UNION
                SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m-%d %h:%i:%s') as month, emd.verification_number  AS property FROM admin_user_logs aul JOIN exp_mno_distributor emd ON aul.user_distributor=emd.distributor_code
                WHERE emd.parent_id='".$property_id."' ".$from.$to."
                UNION
                SELECT aul.* ,FROM_UNIXTIME(aul.unixtimestamp,'%Y-%m-%d %h:%i:%s') as month, emd.verification_number  AS property FROM admin_user_logs aul JOIN exp_mno_distributor emd ON aul.user_distributor=emd.distributor_code
                WHERE emd.distributor_code='".$property_id."' ".$from.$to."
              ) t
ORDER BY t.unixtimestamp LIMIT ".$log->limit;

        $data = $this->connection->selectDB($q);
//print_r($data);
        $data_array = array();
        foreach ($data['data'] as $row){

            $row_log = new object_data();
            /* $row_log->user_name=$row['user_name'];
            $row_log->module=$row['module'];
            $row_log->task=$row['task'];
            $row_log->reference=$row['reference'];
            $row_log->ip=$row['ip'];
            $row_log->property=$row['property'];
            $row_log->month=$row['month'];
            $row_log->unixtimestamp=$row['unixtimestamp']; */
            $row_log->id=$row['id'];
            $row_log->user_name=$row['user_name'];
            $row_log->module=$row['module'];
            $row_log->task=$row['task'];
            $row_log->reference=$row['reference'];
            $row_log->ip=$row['ip'];
            $row_log->property=$row['property'];
            $row_log->month=$row['month'];
            $row_log->user_distributor=$row['user_distributor'];
            $row_log->create_date=$row['create_date'];
            $row_log->unixtimestamp=$row['unixtimestamp'];

            array_push($data_array,$row_log);
        }
        //print_r($data_array);
        return $data_array;
    }

   /*  public function accessLog(object_data $log){

        $q = "SELECT L.id AS id, E.`status_id`,E.`description`,L.`access_details`,S.`location_id`,S.`token_id`,S.`mac`,S.`ssid`,S.`customer_id`,C.`email`,L.`create_date`,L.`unixtimestamp` ,S.other_parameters
									FROM exp_points_logs L,exp_points E,exp_customer_session S
									left join `exp_customer` C
									on S.`customer_id`= C.`customer_id`
									WHERE E.`status_id`=L.`access_id`
									AND S.`token_id`=L.`token`

									AND S.`location_id`= '$user_distributor'";
    } */


public function accessLog(object_data $log){

    $q = "SELECT L.id AS id, E.`status_id`,E.`description`,L.`access_details`,S.`location_id`,S.`token_id`,S.`mac`,S.`ssid`,S.`customer_id`,C.`act_email` as email,L.`create_date`,L.`unixtimestamp` ,S.`other_parameters`
    FROM exp_points_logs L,exp_points E,exp_customer_session S
    left join `exp_customer` C
    on S.`customer_id`= C.`customer_id`
    WHERE E.`status_id`=L.`access_id`
    AND S.`token_id`=L.`token`

    AND S.`location_id`= '$log->distributor'";

         

        if(!empty($log->ssid)){
            $q.=" AND ssid ='$log->ssid'";
        }
        if(!empty($log->mac)){
            $q.= " AND mac ='$log->mac'";
        }
        else{
            $q.= " AND mac <>'DEMO_MAC'";
        }
        if(!empty($log->email)){
            
            $q.= " AND email ='$log->email'";
        }
        if(!empty($log->limit)){
            $log->limit = 100;
        }
        if(!empty($log->from)){
            $q.= " AND L.unixtimestamp >'$log->from'";
        }
        if(!empty($log->to)){
            $q.= " AND L.unixtimestamp <'$log->to'";
        }

        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;
        $data = $this->connection->selectDB($q);
        
//print_r($data);
        $data_array = array();
        foreach ($data['data'] as $row){

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
        //print_r($data_array);
        return $data_array;
    }

public function errorLog(object_data $log){

    $q = "SELECT L.`id` AS id,E.`error_id`,E.`description`,L.`error_details`,S.`location_id`,S.`token_id`,S.`mac`,S.`ssid`,S.`customer_id`,C.`email`,L.`create_date`,L.`unixtimestamp`  
        FROM exp_error_log L,exp_errors E,exp_customer_session S
        left join `exp_customer` C
        on S.`customer_id`= C.`customer_id`
        WHERE E.`error_id`=L.`error_id`
        AND S.`token_id`=L.`token`
        AND S.`location_id`= '$log->distributor'";

         

        if(!empty($log->ssid)){
            $q.=" AND ssid ='$log->ssid'";
        }
        if(!empty($log->mac)){
            $q.= " AND mac ='$log->mac'";
        }
        else{
            $q.= " AND mac <>'DEMO_MAC'";
        }
        if(!empty($log->email)){
            
            $q.= " AND email ='$log->email'";
        }
        if(!empty($log->limit)){
            $log->limit = 100;
        }
        if(!empty($log->from)){
            $q.= " AND L.unixtimestamp >'$log->from'";
        }
        if(!empty($log->to)){
            $q.= " AND L.unixtimestamp <'$log->to'";
        }

        $q.=" ORDER BY id DESC";

        $q.=" LIMIT ".$log->limit;
     // print_r($q);
        $data = $this->connection->selectDB($q);
        

        $data_array = array();
        foreach ($data['data'] as $row){

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
        //print_r($data_array);
        return $data_array;
    }
public function apiLog(object_data $log){
    $api_realm=$log->realm;

    $q = "SELECT * FROM `exp_wag_ap_profile_logs` WHERE realm='".$api_realm."'";

         

        if(!empty($log->function)){
            $q.=" AND function ='$log->function'";
        }

       
        if(!empty($log->limit)){
            $log->limit = 100;
        }
        if(!empty($log->from)){
            $q.= " AND unixtimestamp >'$log->from'";
        }
        if(!empty($log->to)){
            $q.= " AND unixtimestamp <'$log->to'";
        }

        $q.=" ORDER BY create_date DESC";

        $q.=" LIMIT ".$log->limit;
      //print_r($q);
        $data = $this->connection->selectDB($q);
        

        $data_array = array();
        foreach ($data['data'] as $row){

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
        //print_r($data_array);
        return $data_array;
    }



    

public function createLog_FIRWALL( firwall_logs $log)
{
    $function = $log->getFunction();
    $function_name = $log->getFunctionName();
    $description = $this->connection->escapeDB($log->getDescription());
    $method = $log->getApiMethod();
    $realm = $log->getRealm();
    $api_details = $this->connection->escapeDB($log->getApiDescription());
    $api_data = $this->connection->escapeDB($log->getApiData());
    $api_status = $log->getApiStatus();

    

    $q = "INSERT INTO `exp_firwall_profile_logs`
    (`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,unixtimestamp)
    VALUES ('$realm','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API',UNIX_TIMESTAMP())";
    

    $query_results=$this->connection->execDB($q);
    if($query_results){
        return true;
    }else{
        return false;
    }
}

public function getLogs_FIRWALL(firwall_logs $log)
{


    $q = "SELECT * FROM exp_firwall_profile_logs WHERE 1=1";

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

    if(!empty($log->getFunction()) || !is_null($log->getFunction())){
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
        $row_log = new firwall_logs(
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
    }

    return $data_array;
}

public function readLog_FIRWALL($id)
{
    $q = "SELECT * FROM exp_firwall_profile_logs WHERE id='$id'";

    $row = $this->connection->select1DB($q);
    require_once dirname(__FILE__).'/../../../entity/firwall_logs.php';
    $row_log = new firwall_logs(
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
    return $row_log;
}




}