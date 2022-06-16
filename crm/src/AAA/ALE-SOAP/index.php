<?php
header("Cache-Control: no-cache, must-revalidate");


include_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../../../classes/dbClass.php');
include_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../../../classes/systemPackageClass.php');

include_once('function.php');

require_once dirname(__FILE__) . '/../../LOG/logObjectProvider.php';
require_once dirname(__FILE__) . '/../../LOG/Logger.php';

class aaa

{


    private $system_package;

    public function __construct($network_name = null, $system_package = null)
    {

        $this->db_class = new db_functions();

        $this->network_name = $this->db_class->setVal("network_name", 'ADMIN');

        $this->lib_name = $network_name;

        $this->system_package = $system_package;
        $this->networkArr = $this->initialConfig($this->lib_name);


    }

    private function initialConfig($network)
    {

        $query = "SELECT * FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";

        $row = $this->db_class->select1DB($query);
        $isDynamic = package_functions::isDynamic($this->system_package);
        //$row = mysql_fetch_array($query_results);
        if ($isDynamic) {
            $q = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$this->system_package'";
            $qra = $this->db_class->select1DB($q);
            //$qra=mysql_fetch_assoc($qr);
            $qraj = json_decode($qra['settings'], true);
            $row['api_master_acc_type'] = $qraj['aaa_configuration']['AAA_PRODUCT_OWNER']['options'];
            $row['api_login'] = $qraj['aaa_configuration']['AAA_USERNAME']['options'];
            $row['api_password'] = $qraj['aaa_configuration']['AAA_PASSWORD']['options'];
            $row['api_acc_profile'] = $qraj['aaa_configuration']['AAA_TENANT']['options'];
        }
        return $row;
    }
    public function getoptdatabyrealm($realm){
        
        $data = json_decode($this->db_class->getValueAsf("SELECT m.aaa_data as f FROM exp_mno m JOIN exp_mno_distributor emd on m.mno_id = emd.mno_id WHERE emd.verification_number='$realm' LIMIT 1"),true);
        return $data;
    }
    public function getNetworkConfig($network, $field)

    {
        $networkArr = $this->networkArr;
        return $networkArr[$field];
        /* $query = "SELECT $field AS f FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";

        $query_results=mysql_query($query);

        while($row=mysql_fetch_array($query_results)){

          return $row['f'];

        } */

    }

    public function getAllZones(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function deleteLookupZone(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function deleteZone(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
    }

    
	public function getAllGroupsNew(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function createGroup(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function createZone(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}
    
    public function log($aaa_username, $function, $function_name, $description, $method, $api_status, $api_details, $api_data, $group_id = null, $mac = null)
    {
        /*   $query = "INSERT INTO `exp_aaa_logs`
         (`username`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,group_id,`unixtimestamp`)
         VALUES ('$aaa_username','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'Support','$group_id',UNIX_TIMESTAMP())";
         $query_results=mysql_query($query); */

        $mac = str_replace('-', '', $mac);
        $mac = str_replace(':', '', $mac);

        $log = Logger::getLogger()->getObjectProvider()->getObjectAaa();

        //$log->

        $log->setFunction($function);
        $log->setFunctionName($function_name);
        $log->setDescription($description);
        $log->setApiMethod($method);
        $log->setApiStatus($api_status);
        $log->setApiDescription($api_details);
        $log->setApiData($api_data);
        $log->setUsername($aaa_username);
        $log->setgroupid($group_id);
        $log->setMacid($mac);

        $logger = Logger::getLogger();

        $logger->InsertLog($log);
    }


    public function getGroup($token)
    {


        $query = "SELECT `group` from exp_security_tokens

    WHERE token_id = '$token'";


        $query_results = $this->db_class->selectDB($query);

        foreach ($query_results['data'] as $row) {

            $group = $row[group];

        }


        return $group;


        //$other_parameters_array = (array)json_decode($other_parameters);

        //return $other_parameters_array[realm];

    }


    public function getPurgeTime($realm)
    {


        $query = "SELECT purge_time AS f FROM `exp_products_distributor` p ,`exp_mno_distributor` d 
                  WHERE d.distributor_code=p.`distributor_code` 
                  AND d.`verification_number`='$realm'
                 AND p.network_type='guest'";


        $query_results = $this->db_class->selectDB($query);

        foreach ($query_results['data'] as $row) {

            $purg_time = $row[f];

        }


        return $purg_time;


        //$other_parameters_array = (array)json_decode($other_parameters);

        //return $other_parameters_array[realm];

    }


    public function getToken($mac)
    {


        $query = "SELECT token FROM exp_customer_sessions_mac WHERE mac = '$mac' LIMIT 1";


        $query_results = $this->db_class->selectDB($query);
        foreach ($query_results['data'] as $row) {
            $token = $row[token];

        }

        return $token;

    }

    public function updateAccount($account_type, $portal_number, $mac, $first_name, $last_name, $birthday, $gender, $relationship, $email, $mobile_number, $product, $timegap, $realm)
    {


        $base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');


        $timezone = $this->getNetworkConfig($this->network_name, 'api_time_zone');
        $tz_object = new DateTimeZone($timezone);

        $datetime = new DateTime(null, $tz_object);
        $begindate = $datetime->format('Y-m-d H:i:s');
        $datetime->add(new DateInterval($timegap));
        $enddate = $datetime->format('Y-m-d H:i:s');

        //$token_id = $this->getToken($mac);


        $organization = $realm;//$this->getGroup($token_id);
        $user_name_ale = $organization . '/' . $mac;


        if (strlen($organization) == '0') {

            $organization = $this->getNetworkConfig($this->network_name, 'api_acc_org');

        }


        include_once('lib/nusoap-update.php');


        $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $client = new nusoap_client_u("$base_url", false, '', '', '', '');

        $err = $client->getError();

        if ($err) {


            $this->log($user_name_ale, __FUNCTION__, 'Update Account', $base_url, 'SOAP', '1022', $client->response, $client->request, $organization, $mac);
            $json2 = array('status_code' => '1022',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;
            //return 'status=failed&status_code=1022&Description=Soap Constructor Error';

            // SOAP Constructor Error

        }


        $client->setUseCurl($useCURL);


        $product_list = explode(',', $product);
        $srvice_profile_array = array();
        foreach ($product_list as $key => $value) {

            $srvice_profile_array[$value] = 'ADD|true';

        }


        $user_date_array = array(

            'Gender' => $gender,
            'Age' => $birthday,

        );


        $purge_delay_time = $this->getPurgeTime($realm);
        if ($purge_delay_time == '') {
            $purge_delay_time = $this->getNetworkConfig($this->network_name, 'purge_delay_time');
        }


        if ($account_type == 'new') {

            $params_update = array(

                //'PAS-First-Name'    => $first_name,
                //'PAS-Last-Name'     => $last_name,

                'Valid-From' => $begindate,
                'Valid-Until' => $enddate,
                'Purge-Delay-Time' => $purge_delay_time,
                'Account-State' => "Active",
                'PAS-Account-Type' => 'REMOVE|',
                'Service-Profiles' => $srvice_profile_array,
                'PAS-Account-Locked' => 'False',
                'PAS-Allow-Extend' => 'True',
                'PAS-Allow-Overwrite' => 'True',
                'First-Access' => 'REMOVE|',
                'Last-Access' => 'REMOVE|',
                'EMAIL' => '',
                'User-Data' => $user_date_array,

            );

        } else if ($account_type == 'ex') {


            $params_update = array(

                'Purge-Delay-Time' => $purge_delay_time,
                'First-Access' => 'REMOVE|',
                'Last-Access' => 'REMOVE|',
                'Valid-Until' => $enddate,

            );

        }


        $result = $client->call('updateAccountRequest', $params_update, 'User-Name', $user_name_ale, $organization, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');


        if ($client->fault) {

            $this->log($user_name_ale, __FUNCTION__, 'Update Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
            $json2 = array('status_code' => '1021',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;
            //return 'status=failed&status_code=1021&Description=SOAP Eror';

            //SOAP Fault Error


        } else {

            $err = $client->getError();

            if ($err) {

                $this->log($user_name_ale, __FUNCTION__, 'Update Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
                $json2 = array('status_code' => '1021',
                    'status' => 'failed',
                    'Description' => '');
                $encoded2 = json_encode($json2);
                return $encoded2;
                //return 'status=failed&status_code=1021&Description=SOAP Fault Eror';

                // SOAP Fault Error


            } else {

                // Soap Success

                //print_r($client->response);


                $status_code = $result['!code'];
                $desc = $result['!message'];
                $status = $result['!status'];
                $details = $result['details'];
                $ref = $result['!reference'];


                /*  $myFile4 = "log/ale_update.txt";

                  $fh = fopen($myFile4, 'a') or die("can't open file");

                  $header = 'Request '.$client->request.' Response '.$client->response.'|';

                  fwrite($fh, $header); */


                $request_array = array(
                    'Purge-Delay-Time' => $purge_delay_time,
                    'First-Access' => 'REMOVE|',
                    'Last-Access' => 'REMOVE|',
                    'Valid-Until' => $enddate,
                    'Valid-From' => $begindate,
                    'Purge-Delay-Time' => $purge_delay_time,
                    'Account-State' => "Active",
                    'PAS-Account-Type' => 'REMOVE|',
                    'Service-Profiles' => $srvice_profile_array,
                    'PAS-Account-Locked' => 'False',
                    'PAS-Allow-Extend' => 'True',
                    'PAS-Allow-Overwrite' => 'True',
                    'First-Access' => 'REMOVE|',
                    'Last-Access' => 'REMOVE|',
                    'EMAIL' => $email,
                    'User-Data' => $user_date_array,
                    'User-name' => $user_name_ale
                );
                //  echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';

                //  echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
                $request_array = json_encode($request_array);
                $this->log($user_name_ale, __FUNCTION__, 'Update Account', $base_url, 'SOAP', $status_code, $client->response, $client->request, $organization, $mac);
                if ($status_code == '200') {
                    $json1 = array('status_code' => $status_code,
                        'status' => 'success',
                        'Description' => $client->response);
                    $encoded = json_encode($json1);
                    return $encoded;
                } else {
                    $json2 = array('status_code' => $status_code,
                        'status' => 'failed',
                        'Description' => '');
                    $encoded2 = json_encode($json2);
                    return $encoded2;

                }


                /*if($status_code == '200'){

                  $this->log($user_name_ale,__FUNCTION__, 'Update Account', $base_url, 'SOAP', $status_code, $client->response, $client->request,$organization);
                  return 'status=success&status_code='.$status_code.'&Description=Account Modified Success - '.$status_code;




                }

                else{

                  $this->log($user_name_ale,__FUNCTION__, 'Update Account', $base_url, 'SOAP', $status_code, $client->response, $client->request,$organization);
                  return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;

                  // SOAP Parameter Error


                }*/


            }

        }


        // echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';

        // echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

        // echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';


    }

    public function createAccount($portal_number, $mac, $first_name, $last_name, $birthday, $gender, $relationship, $email, $mobile_number, $product, $timegap, $realm, $internal_url, $token)
    {


        //echo $internal_url;//$db_class->setVal('camp_base_url','ADMIN');
        /*  $tz_object = new DateTimeZone($timezone);

          $datetime = new DateTime(null,$tz_object);

          $begindate = $datetime->format('Y-m-d H:i:s');

          $datetime->add(new DateInterval($timegap));

          $enddate = $datetime->format('Y-m-d H:i:s');  */


        $base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');
        $session_profile1 = $this->getNetworkConfig($this->network_name, 'ses_creation_method');
        require_once(str_replace('//', '/', dirname(__FILE__) . '/') . '../../sessions/' . $session_profile1 . '/index.php');
        $ale = new session_profile($this->network_name, $session_profile1, $internal_url);


        //$token_id = $this->getToken($mac);


        $organization = $realm;//$this->getGroup($token_id);


        if (strlen($organization) == '0') {

            $organization = $this->getNetworkConfig($this->network_name, 'api_acc_org');

        }


//echo 'src/AAA/'.$this->lib_name.'/lib/nusoap.php';
        include_once('lib/nusoap.php');


        $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';

        $client = new nusoap_client("$base_url", false, '', '', '', '');


        $err = $client->getError();

        if ($err) {
            //echo"1";
            $this->log($organization . '/' . $mac, __FUNCTION__, 'Create Account', $base_url, 'SOAP', '1022', $client->response, $client->request, $organization, $mac);
            $json2 = array('status_code' => '1022',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;
            //return 'status=failed&status_code=1022&Description=Soap Constructor Error';

            /* SOAP Constructor Error */
        }


        $product = (string)$product;

        /*    $srvice_profile_array = array(



                $product  => 'true'

            );

             */

        $client->setUseCurl($useCURL);

        // This is an archaic parameter list

        $params = array(

            'Password' => $organization . '/' . $mac,

            'User-Name' => $organization . '/' . $mac,

            'Group' => $organization, //'MSISDN,copy',  // copy="true"

            'Account-State' => 'Inactive', // Active or Inactive

            'PAS-Account-Type' => "",

            //'Service-Profiles' => $srvice_profile_array, //$this->network('PRODUCT'),

            'PAS-Account-Locked' => 'True',//$this->network('PAS_Account_Locked'),//'False',

            'PAS-Allow-Extend' => 'True',//$this->network('PAS_Allow_Extend'),//'True',

            'PAS-Allow-Overwrite' => 'True',//$this->network('PAS_Allow_Overwrite'),//'True',

            //'Valid-From'    => $begindate,  // 1415092796.2

            //'Valid-Until'   => $enddate


        );


        $result = $client->call('createAccountRequest', $params, $organization, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');


        /*  $myFile4 = "log/ale.txt";

          $fh = fopen($myFile4, 'a') or die("can't open file");

          $header = 'Request '.$client->request.' Response '.$client->response.'|';

          fwrite($fh, $header); */


        //echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';

        //echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';


        if ($client->fault) {
            //echo"2";
            $this->log($organization . '/' . $mac, __FUNCTION__, 'Create Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
            $json2 = array('status_code' => '1021',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;
            //return 'status=failed&status_code=1021&Description=SOAP Eror';

            /* SOAP Fault Error */

        } else {


            $err = $client->getError();

            if ($err) {
                //echo"3";
                $this->log($organization . '/' . $mac, __FUNCTION__, 'Create Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
                $json2 = array('status_code' => '1021',
                    'status' => 'failed',
                    'Description' => '');
                $encoded2 = json_encode($json2);
                return $encoded2;
                //return 'status=failed&status_code=1021&Description=SOAP Fault Eror';

                /* SOAP Fault Error */

            } else {

                // Soap Success

                //print_r($result);


                $status_code = $result['result']['!code'];

                $desc = $result['result']['!message'];

                $status = $result['result']['!status'];

                $details = $result['details'];

                $ref = $result['!reference'];


                $request_array = array(

                    'Password' => $organization . '/' . $mac,

                    'User-Name' => $organization . '/' . $mac,

                    'Group' => $organization, //'MSISDN,copy',  // copy="true"

                    'Account-State' => 'Inactive', // Active or Inactive

                    'PAS-Account-Type' => "",

                    //'Service-Profiles' => $srvice_profile_array, //$this->network('PRODUCT'),

                    'PAS-Account-Locked' => 'True',//$this->network('PAS_Account_Locked'),//'False',

                    'PAS-Allow-Extend' => 'True',//$this->network('PAS_Allow_Extend'),//'True',

                    'PAS-Allow-Overwrite' => 'True',//$this->network('PAS_Allow_Overwrite'),//'True',

                    //'Valid-From'    => $begindate,  // 1415092796.2

                    //'Valid-Until'   => $enddate
                );
                //  echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';

                //  echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
                $request_array = json_encode($request_array);

                $this->log($organization . '/' . $mac, __FUNCTION__, 'Create Account', $base_url, 'SOAP', $status_code, $client->response, $client->request, $organization, $mac);

                $result = $client->response;
                if ($status_code == '201' || $status_code == '200') {
                    $start_sessions_url = $ale->Startsession($mac, $realm, $token);
                    $json1 = array('status_code' => '200',
                        'status' => 'success',
                        'Description' => $result);
                    $encoded = json_encode($json1);
                    return $encoded;
                } else {
                    $json2 = array('status_code' => $status_code,
                        'status' => 'failed',
                        'Description' => '');
                    $encoded2 = json_encode($json2);
                    return $encoded2;

                }


                /*if($status_code == '200'){
                  $this->log($organization.'/'.$mac,__FUNCTION__, 'Create Account', $base_url, 'SOAP', $status_code, $client->response, $client->request,$organization);

                  return 'status=success&status_code='.$status_code.'&Description=Account Creation Success - '.$status_code;


                }

                else{
                  //echo"4";
                  $this->log($organization.'/'.$mac,__FUNCTION__, 'Create Account', $base_url, 'SOAP', $status_code, $client->response, $client->request,$organization);
                  return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;



                }*/


            }


        }

    }


    public function checkAccount($mac, $realm = NULL)
    {


        $base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');


        if (strlen($realm)) {
            $organization = $realm;
        } else {
            $token_id = $this->getToken($mac);
            $organization = $this->getGroup($token_id);

            if (strlen($organization) == '0') {
                $organization = $this->getNetworkConfig($this->network_name, 'api_acc_org');
            }
        }

        include_once('lib/nusoap-update2.php');

        $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $client = new nusoap_client("$base_url", false, '', '', '', '');

        $err = $client->getError();
        if ($err) {

            return 'status=failed&status_code=1022&Description=Soap Constructor Error';
            /* SOAP Constructor Error */
        }


        $client->setUseCurl($useCURL);
        // This is an archaic parameter list
        $params = array(
            'User-Name' => $organization . '/' . $mac,

        );

        $result = $client->call('getAccountRequest', $params, $organization, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');


        /*  $myFile4 = "log/ale_query.txt";
          $fh = fopen($myFile4, "a") or die("can't open file");
          $header = 'Request '.$client->request.' Response '.$client->response.'|';
          fwrite($fh, $header);*/


        //echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        //echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

        $this->log($organization . '/' . $mac, __FUNCTION__, 'Check Account', $base_url, 'SOAP', '1022', $client->response, $client->request, $organization, $mac);

        if ($client->fault) {
            return 'status=failed&status_code=1021&Description=SOAP Eror';
            /* SOAP Fault Error */
        } else {

            $err = $client->getError();
            if ($err) {
                return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
                /* SOAP Fault Error */
            } else {
                // Soap Success
                //print_r($result);

                $status_code = $result['result']['!code'];
                $desc = $result['result']['!message'];

                if (is_array($result[details][detail])) {
                    $desc = $result[details][detail]['!message'];
                }
                $data_array = $result[responses][response][parameter];

                foreach ($data_array as $key => $value) {
                    //print_r($value);
                    //echo $value['!name'];
                    //echo $value['!value'];
                    if ($value['!name'] == 'Valid-Until') {
                        //echo '---';
                        //print_r($value);
                        $valid_until = $value['!value'];
                    }

                    if ($value['!name'] == 'Account-State') {
                        //echo '---';
                        //print_r($value);
                        $account_state = $value['!value'];
                    }

                }

                if ($account_state == 'Active') {

                    $ac_state = 'Active';

                } else {

                    $ac_state = 'Inactive';

                }


                //print_r($data_array);

                $status = $result['result']['!status'];
                $details = $result['details'];
                $ref = $result['!reference'];

                $request_array = array(

                    'First-Access' => $organization . '/' . $mac

                );
                //  echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';

                //  echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
                $request_array = json_encode($request_array);

                $this->log($organization . '/' . $mac, __FUNCTION__, 'Update Account', $base_url, 'SOAP', $status_code, $details, $request_array, $organization, $mac);


                if ($status_code == '200') {
                    return 'status=success&status_code=' . $status_code . '&Description=Account Retrieving Success - ' . $status_code . '&expire=' . $valid_until . '&validity=' . $ac_state;

                } else {
                    return 'status=failed&status_code=' . $status_code . '&Description=' . $desc . ' - ' . $status_code;
                    /* SOAP Parameter Error */
                }

            }
        }
    }

    public function checkMacAccount($mac, $realm, $type){
        $q_get_realms = "SELECT network_realm FROM exp_network_realm WHERE realm='$realm'";
        $realms = $this->db_class->selectDB($q_get_realms);

        $return = [
            "status_code"=>200,
            "status"=>'success',
            "Description"=>[]
        ];
        if($realms['rowCount']>0){
        foreach ($realms['data'] as $row){
            $data = json_decode($this->checkNetworkMacAccount($mac,$row['network_realm'],$type),true);
            if($data['status']=='success'){
                $return["Description"] = array_merge($return["Description"],$data["Description"]);
            }
        }
        }else{
            $data = json_decode($this->checkNetworkMacAccount($mac,$realm,$type),true);
            if($data['status']=='success'){
                $return["Description"] = array_merge($return["Description"],$data["Description"]);
            }
        }

        return json_encode($return);
    }

    public function checkNetworkMacAccount($mac, $realm, $type)
    {


        $base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');

        $organization = $realm;
        $username = $organization . '/' . $mac;

        include_once('lib/nusoap-update2.php');

        $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $client = new nusoap_client_u2("$base_url", false, '', '', '', '');

        $err = $client->getError();
        if ($err) {

            $this->log($username, __FUNCTION__, 'Get Account', $base_url, 'SOAP', '1022', $client->response, $client->request, $organization);
            $json2 = array('status_code' => '1022',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;
            //return 'status=failed&status_code=1022&Description=Soap Constructor Error';
            /* SOAP Constructor Error */
        }


        $client->setUseCurl($useCURL);
        // This is an archaic parameter list
        $params = array(
            'User-Name' => $username,

        );

        $result = $client->call('getAccountRequest', $params, $organization, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');


        if ($client->fault) {
            $this->log($username, __FUNCTION__, 'Get Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
            $json2 = array('status_code' => '1021',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;

            //return 'status=failed&status_code=1021&Description=SOAP Eror';
            /* SOAP Fault Error */
        } else {

            $err = $client->getError();
            if ($err) {
                $this->log($username, __FUNCTION__, 'Get Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
                $json2 = array('status_code' => '1021',
                    'status' => 'failed',
                    'Description' => '');
                $encoded2 = json_encode($json2);
                return $encoded2;

                //return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
                /* SOAP Fault Error */
            } else {
                // Soap Success
                //print_r($result);
                /*
                        $status_code = $result['result']['!code'];
                        $desc = $result['result']['!message'];
                        $responses=$result['responses'];
                */
                if (is_array($result[result])) {
                    $status_code = $result[result]['!code'];
                    $desc = $result[result]['!message'];
                    $status = $result[result]['!status'];
                    $details = $result[result]['details'];
                    $ref = $result[result]['!reference'];

                    if (is_array($result[details][detail])) {
                        $desc = $result[details][detail]['!message'];
                    }
                } else {
                    $status_code = $result['!code'];
                    $desc = $result['!message'];
                    $status = $result['!status'];
                    $details = $result['details'];
                    $ref = $result['!reference'];
                }


                $profile_string_final = '';

                $master_array = $result[responses][response];
                //print_r($master_array);
                $master_array_size = sizeof($master_array);


                $key_array_1 = array_keys($master_array);


                //  $key_array_value = '1';
                $key_array_value = strtoupper($key_array_1[0]);

                if ($key_array_value == 'PARAMETER') {

                    //echo $key_array_value;

                    //  foreach ($master_array as $key_this => $obj){

                    $obj = $master_array;
                    $para_array = $obj['parameter'];
                    $group_array = $obj['group'];

                    //print_r($para_array);

                    $profile_string = '';

                    for ($i = 0; $i < sizeof($para_array); $i++) {
                        $obj_name = $obj['parameter'][$i]['!name'];
                        $obj_value = $obj['parameter'][$i]['!value'];
                        $profile_string .= $obj_name . '=' . $obj_value . '&';
                    }


                    for ($k = 0; $k < sizeof($group_array); $k++) {


                        $group_name = $group_array[$k]['!name'];
                        $sub_group_array = $group_array[$k]['parameter'];

                        if ($group_name == 'User-Data') {
                            for ($j = 0; $j < sizeof($sub_group_array); $j++) {

                                $sub_name = $sub_group_array[$j]['!name'];
                                $sub_val = $sub_group_array[$j]['!value'];

                                $sub_str_text = $sub_name . '=' . $sub_val . '&';
                                $profile_string .= $sub_str_text;

                            }
                        }

                        if ($group_name == 'Service-Profiles') {
                            //print_r($sub_group_array);
                            $service_profile_list = $sub_group_array[0]['!name'] . ',' . $sub_group_array[1]['!name'] . ',' . $sub_group_array[2]['!name'];
                            $profile_string .= 'Service-Profiles=' . $service_profile_list . '&';
                        }


                        /*
                         if($group_name == 'Credits'){
                         $profile_string .= 'Credits='.$sub_group_array['!name'].'#'.$sub_group_array['!value'].'&';
                         }

                         */

                    }


                    //echo $profile_string;
                    $profile_string_final .= $profile_string . '|';
                    //  }


                } else {

                    foreach ($master_array as $key_this => $obj) {

                        /* if main array has single element*/
                        if (($master_array_size == 1)) {
                            $obj = $master_array;
                        }
                        /* if main array has single element*/


                        $para_array = $obj['parameter'];
                        $group_array = $obj['group'];

                        //print_r($para_array);

                        $profile_string = '';

                        for ($i = 0; $i < sizeof($para_array); $i++) {
                            $obj_name = $para_array[$i]['!name'];
                            $obj_value = $para_array[$i]['!value'];
                            $profile_string .= $obj_name . '=' . $obj_value . '&';
                        }


                        for ($k = 0; $k < sizeof($group_array); $k++) {

                            $group_name = $group_array[$k]['!name'];
                            $sub_group_array = $group_array[$k]['parameter'];

                            if ($group_name == 'User-Data') {
                                for ($j = 0; $j < sizeof($sub_group_array); $j++) {

                                    $sub_name = $sub_group_array[$j]['!name'];
                                    $sub_val = $sub_group_array[$j]['!value'];

                                    $sub_str_text = $sub_name . '=' . $sub_val . '&';
                                    $profile_string .= $sub_str_text;

                                }
                            }

                            if ($group_name == 'Service-Profiles') {
                                $service_profile_list = $sub_group_array[0]['!name'] . ',' . $sub_group_array[1]['!name'] . ',' . $sub_group_array[2]['!name'];

                                $profile_string .= 'Service-Profiles=' . $service_profile_list . '&';
                            }


                            /*
                            if($group_name == 'Credits'){
                              $profile_string .= 'Credits='.$sub_group_array['!name'].'#'.$sub_group_array['!value'].'&';
                            }

                            */

                        }

                        //echo $profile_string;
                        $profile_string .= '|';
                        //echo $profile_string.'<br />';
                        //echo '<br><br><br>';
                        $profile_string_final .= $profile_string;
                    }
                }

                if (empty($profile_string_final)) {
                    $res_arr = array();
                    $res_arr3 = array();
                } else {
                    $single_profile_data = explode('|', $profile_string_final);

                    $res_arr = array();
                    $res_arr3 = array();

                    for ($k = 0; $k < sizeof($single_profile_data); $k++) {
                        parse_str($single_profile_data[$k], $array_get_profile_value);

                        //print_r($array_get_profile_value);
                        //echo'<br><br>';
                        $User_Name = $array_get_profile_value['User-Name'];


                        if (strlen($User_Name) > 0) {

                            $Master_Account = '';
                            $array_get_profile_value = '';


                            $macc = explode('/', $User_Name);
                            $mac = $macc['1'];
                            $realm = $macc['0'];

                            $station = $array_get_profile_value['Called-Station-Id'];
                            $AP_Mac = substr($station, 0, 17);

                            $newarray = array("Mac" => $mac,
                                "AP_Mac" => $AP_Mac,
                                "State" => $array_get_profile_value['State'],
                                "SSID" => $array_get_profile_value['SSID'],
                                "Realm" => $realm,
                                "GW_ip" => $array_get_profile_value['GW-NAS-IP-Address'],
                                "GW-Type" => $array_get_profile_value['Sender-Type'],
                                "Session-Start-Time" => $array_get_profile_value['START_TIME'],
                                "Device-Mac" => $mac,
                                "Ses_token" => $session_id,
                                "User-Name" => $User_Name,
                                "TYPE" => $type);

                            array_push($res_arr, $newarray);

                        }
                    }
                }
                $finalarray = $this->uniqueAssocArray($res_arr, 'User-Name');


                //print_r($responses);


                $this->log($username, __FUNCTION__, 'Get Account', $base_url, 'SOAP', $status_code, $client->response, $client->request, $organization, $mac);

                if ($status_code == '200') {
                    $json1 = array('status_code' => $status_code,
                        'status' => 'success',
                        'Description' => $finalarray);
                    $encoded = json_encode($json1);
                    return $encoded;
                } else {
                    $json2 = array('status_code' => $status_code,
                        'status' => 'failed',
                        'Description' => '');
                    $encoded2 = json_encode($json2);
                    return $encoded2;

                }


                /*if($status_code == '200'){
                  return 'status=success&status_code='.$status_code.'&Description='.urlencode($profile_string_final);;

                }
                else{
                  return 'status=failed&status_code='.$status_code.'&Description='.$desc;

                }*/

            }
        }
    }

    public function checkRealmAccount($realm, $type){
        $q_get_realms = "SELECT network_realm FROM exp_network_realm WHERE realm='$realm'";
        $realms = $this->db_class->selectDB($q_get_realms);

        $return = [
            "status_code"=>200,
            "status"=>'success',
            "Description"=>[]
        ];
        if($realms['rowCount']>0){
        foreach ($realms['data'] as $row){
            $data = json_decode($this->checkNetworkRealmAccount($row['network_realm'],$type),true);
            if($data['status']=='success'){
                $return["Description"] = array_merge($return["Description"],$data["Description"]);
            }
        }
        }else{
           $data = json_decode($this->checkNetworkRealmAccount($realm,$type),true);
            if($data['status']=='success'){
                $return["Description"] = array_merge($return["Description"],$data["Description"]);
            } 
        }


        return json_encode($return);

    }
    public function checkNetworkRealmAccount($realm, $type)
    {


        $base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');

        $organization = $realm;

        include_once('lib/nusoap-update2.php');

        $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $client = new nusoap_client_u2("$base_url", false, '', '', '', '');

        $err = $client->getError();
        if ($err) {

            $this->log('', __FUNCTION__, 'Get Account', $base_url, 'SOAP', '1022', $client->response, $client->request, $organization, $mac);
            $json2 = array('status_code' => '1022',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;
            //return 'status=failed&status_code=1022&Description=Soap Constructor Error';
            /* SOAP Constructor Error */
        }


        $client->setUseCurl($useCURL);
        // This is an archaic parameter list
        $params = array(
            'Group' => $organization,

        );

        $result = $client->call('getAccountRequest', $params, $organization, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');


        if ($client->fault) {
            $this->log('', __FUNCTION__, 'Get Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
            $json2 = array('status_code' => '1021',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;

            //return 'status=failed&status_code=1021&Description=SOAP Eror';
            /* SOAP Fault Error */
        } else {

            $err = $client->getError();
            if ($err) {
                $this->log('', __FUNCTION__, 'Get Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
                $json2 = array('status_code' => '1021',
                    'status' => 'failed',
                    'Description' => '');
                $encoded2 = json_encode($json2);
                return $encoded2;
                //return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
                /* SOAP Fault Error */
            } else {

                if (is_array($result[result])) {
                    $status_code = $result[result]['!code'];
                    $desc = $result[result]['!message'];
                    $status = $result[result]['!status'];
                    $details = $result[result]['details'];
                    $ref = $result[result]['!reference'];

                    if (is_array($result[details][detail])) {
                        $desc = $result[details][detail]['!message'];
                    }
                } else {
                    $status_code = $result['!code'];
                    $desc = $result['!message'];
                    $status = $result['!status'];
                    $details = $result['details'];
                    $ref = $result['!reference'];
                }


                $profile_string_final = '';

                $master_array = $result[responses][response];
                //print_r($master_array);
                $master_array_size = sizeof($master_array);


                $key_array_1 = array_keys($master_array);


                //  $key_array_value = '1';
                $key_array_value = strtoupper($key_array_1[0]);

                if ($key_array_value == 'PARAMETER') {

                    //echo $key_array_value;

                    //  foreach ($master_array as $key_this => $obj){

                    $obj = $master_array;
                    $para_array = $obj['parameter'];
                    $group_array = $obj['group'];

                    //print_r($para_array);

                    $profile_string = '';

                    for ($i = 0; $i < sizeof($para_array); $i++) {
                        $obj_name = $obj['parameter'][$i]['!name'];
                        $obj_value = $obj['parameter'][$i]['!value'];
                        $profile_string .= $obj_name . '=' . $obj_value . '&';
                    }


                    for ($k = 0; $k < sizeof($group_array); $k++) {


                        $group_name = $group_array[$k]['!name'];
                        $sub_group_array = $group_array[$k]['parameter'];

                        if ($group_name == 'User-Data') {
                            for ($j = 0; $j < sizeof($sub_group_array); $j++) {

                                $sub_name = $sub_group_array[$j]['!name'];
                                $sub_val = $sub_group_array[$j]['!value'];

                                $sub_str_text = $sub_name . '=' . $sub_val . '&';
                                $profile_string .= $sub_str_text;

                            }
                        }

                        if ($group_name == 'Service-Profiles') {
                            //print_r($sub_group_array);
                            $service_profile_list = $sub_group_array[0]['!name'] . ',' . $sub_group_array[1]['!name'] . ',' . $sub_group_array[2]['!name'];
                            $profile_string .= 'Service-Profiles=' . $service_profile_list . '&';
                        }


                    }


                    //echo $profile_string;
                    $profile_string_final .= $profile_string . '|';
                    //  }


                } else {

                    foreach ($master_array as $key_this => $obj) {

                        /* if main array has single element*/
                        if (($master_array_size == 1)) {
                            $obj = $master_array;
                        }
                        /* if main array has single element*/


                        $para_array = $obj['parameter'];
                        $group_array = $obj['group'];

                        //print_r($para_array);

                        $profile_string = '';

                        for ($i = 0; $i < sizeof($para_array); $i++) {
                            $obj_name = $para_array[$i]['!name'];
                            $obj_value = $para_array[$i]['!value'];
                            $profile_string .= $obj_name . '=' . $obj_value . '&';
                        }


                        for ($k = 0; $k < sizeof($group_array); $k++) {

                            $group_name = $group_array[$k]['!name'];
                            $sub_group_array = $group_array[$k]['parameter'];

                            if ($group_name == 'User-Data') {
                                for ($j = 0; $j < sizeof($sub_group_array); $j++) {

                                    $sub_name = $sub_group_array[$j]['!name'];
                                    $sub_val = $sub_group_array[$j]['!value'];

                                    $sub_str_text = $sub_name . '=' . $sub_val . '&';
                                    $profile_string .= $sub_str_text;

                                }
                            }

                            if ($group_name == 'Service-Profiles') {
                                $service_profile_list = $sub_group_array[0]['!name'] . ',' . $sub_group_array[1]['!name'] . ',' . $sub_group_array[2]['!name'];

                                $profile_string .= 'Service-Profiles=' . $service_profile_list . '&';
                            }


                        }

                        $profile_string .= '|';
                        $profile_string_final .= $profile_string;
                    }
                }

                if (empty($profile_string_final)) {
                    $res_arr = array();
                    $res_arr3 = array();
                } else {
                    $single_profile_data = explode('|', $profile_string_final);

                    $res_arr = array();
                    $res_arr3 = array();
                    for ($k = 0; $k < sizeof($single_profile_data); $k++) {
                        parse_str($single_profile_data[$k], $array_get_profile_value);
                        $User_Name = $array_get_profile_value['User-Name'];

                        //echo $single_profile_data[$k];
                        if (strlen($User_Name) > 0) {
                            //echo "string";

                            $Master_Account = '';
                            $array_get_profile_value = '';


                            $macc = explode('/', $User_Name);
                            $mac = $macc['1'];
                            $realm = $macc['0'];

                            //$station = $array_get_profile_value['Called-Station-Id'];
                            //$AP_Mac= substr($station, 0, 17);

                            $newarray = array("Mac" => $mac,
                                "AP_Mac" => $array_get_profile_value['AP_Mac'],
                                "State" => $array_get_profile_value['State'],
                                "SSID" => $array_get_profile_value['SSID'],
                                "Realm" => $realm,
                                "GW_ip" => $array_get_profile_value['GW-NAS-IP-Address'],
                                "GW-Type" => $array_get_profile_value['Sender-Type'],
                                "Session-Start-Time" => $array_get_profile_value['START_TIME'],
                                "Device-Mac" => $mac,
                                "Ses_token" => $session_id,
                                "User-Name" => $User_Name,
                                "TYPE" => $type);

                            array_push($res_arr, $newarray);

                        }
                    }
                    $finalarray = $this->uniqueAssocArray($res_arr, 'User-Name');

                    //print_r($responses);


                    $this->log('', __FUNCTION__, 'Get Account', $base_url, 'SOAP', $status_code, $client->response, $client->request, $organization, $mac);

                    if ($status_code == '200') {
                        $json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description' => $finalarray);
                        $encoded = json_encode($json1);
                        return $encoded;
                    } else {
                        $json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description' => '');
                        $encoded2 = json_encode($json2);
                        return $encoded2;

                    }


                }
            }
        }
    }

    public function uniqueAssocArray($array, $uniqueKey)
    {
        //print_r($array);
        if (!is_array($array)) {
            return array();
        }
        $uniqueKeys = array();
        foreach ($array as $key => $item) {
            if ((!in_array($item[$uniqueKey], $uniqueKeys))) {
                $uniqueKeys[$item[$uniqueKey]] = $item;
            }
        }
        return $uniqueKeys;
    }

    public function deleteAccount($mac, $realm)
    {


        include_once('lib/nusoap-delete.php');

        $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');
        $client = new nusoap_client("$base_url", false, '', '', '', '');
        $u_id = rand(1, 9) . uniqid() . rand(1111, 9999);

        //$network_user_arr=explode('/', $network_user);
        $organization = $realm;
        $network_user = $organization . '/' . $mac;


        $err = $client->getError();
        if ($err) {

            $desc = $client->getError();
            $json2 = array('status_code' => '1022',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;

            //return 'status=failed&status_code=1022&Description=Soap Constructor Error';
            /* SOAP Constructor Error */
        }


        $client->setUseCurl($useCURL);
        // This is an archaic parameter list
        $params = array(
            'User-Name' => $network_user
        );


        $result = $client->call('deleteAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');


        $request_html = $client->request;
        $response_html = $client->response;


        if ($client->fault) {

            $desc = $client->fault;


            $this->log($network_user, __FUNCTION__, 'Delete Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
            $json2 = array('status_code' => '1021',
                'status' => 'failed',
                'Description' => '');
            $encoded2 = json_encode($json2);
            return $encoded2;
            //return 'status=failed&status_code=1021&Description=SOAP Eror';
            /* SOAP Fault Error */
        } else {

            $err = $client->getError();
            if ($err) {

                $desc = $client->getError();

                $this->log($network_user, __FUNCTION__, 'Delete Account', $base_url, 'SOAP', '1021', $client->response, $client->request, $organization, $mac);
                $json2 = array('status_code' => '1021',
                    'status' => 'failed',
                    'Description' => '');
                $encoded2 = json_encode($json2);
                return $encoded2;
                //return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
                /* SOAP Fault Error */
            } else {
                // Soap Success
                //print_r($result);

                if (is_array($result[result])) {
                    $status_code = $result[result]['!code'];
                    $desc = $result[result]['!message'];
                    $status = $result[result]['!status'];
                    $details = $result[result]['details'];
                    $ref = $result[result]['!reference'];
                    if (is_array($result[details][detail])) {
                        $desc = $result[details][detail]['!message'];
                    }
                    //$desc = $result[details][detail]['!message'];
                } else {
                    $status_code = $result['!code'];
                    $desc = $result['!message'];
                    $status = $result['!status'];
                    $details = $result['details'];
                    $ref = $result['!reference'];
                }

                /*          $status_code = $result['result']['!code'];
                                        $desc = $result['result']['!message'];
                                        $status = $result['result']['!status'];
                                        $details = $result['details'];
                                        $ref = $result['!reference'];  */

                /*      if(strlen($status_code) == 0){
                                        $status_code = $result['!code'];
                                        $desc = $result['!message'];
                                    } */


                //$ex_1 = mysql_query($q_lo);

                $this->log($network_user, __FUNCTION__, 'Delete Account', $base_url, 'SOAP', $status_code, $client->response, $client->request, $organization, $mac);
                if ($status_code == '204' || $status_code == '200') {
                    $json1 = array('status_code' => '200',
                        'status' => 'success',
                        'Description' => '');
                    $encoded = json_encode($json1);
                    return $encoded;
                } else {
                    $json2 = array('status_code' => $status_code,
                        'status' => 'failed',
                        'Description' => '');
                    $encoded2 = json_encode($json2);
                    return $encoded2;

                }


            }
        }


    }


}

