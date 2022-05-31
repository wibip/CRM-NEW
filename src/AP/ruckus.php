<?php
require_once __DIR__ . '/apClass.php';

class ruckus extends apClass
{

    protected $baseurl = '';
    protected $cookie = '';
    protected $switch_baseurl = '';
    protected $time_zone = 'UTC';
    protected $zoneListSize = 10000;


    function __construct()
    {
        parent::__construct();
        $input = $this->session();
        $this->baseurl = $input[baseurl];
        $this->switch_baseurl = $input[switch_baseurl];
        $this->cookie = $input[cookie];
    }

    /////////////////login data////////////////////
    protected function login($t = NULL)
    {

        //$ap_cnt = $this->ap;

        if ($this->ap == NULL) {

            return $inData = array(
                'username' => $this->getConfig('api_user_name'), //'admin',
                'password' => $this->getConfig('api_password'), //'ruckus1234!',
                'baseurl' => $this->getConfig('api_url')/*'https://10.1.6.8:7443'*/ . $this->url_postfix,
                'switch_baseurl' => $this->getConfig('api_url') . $this->switch_url_postfix
            );
        } else {

            $q = "SELECT `api_username`,`api_password`,`api_url`,`api_url_se`,`time_zone` FROM  `exp_locations_ap_controller` WHERE `controller_name`='$this->ap' LIMIT 1";
            $d = $this->db_class->select1DB($q);

            $this->time_zone = $d['time_zone'];
            $inData = array(
                'username' => $d['api_username'], //'admin',
                'password' => $d['api_password'], //'ruckus1234!',
                'switch_baseurl' => $d['api_url'] . $this->switch_url_postfix
            );

            if ($t == NULL || $t == 2) {
                $inData['baseurl'] = $d['api_url']/*'https://10.1.6.8:7443'*/ . $this->url_postfix;
            } else if ($t == 1) {

                //$url = $db_class->getValueAsf("SELECT `api_url_se` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");

                if ($d['api_url_se'] == NULL || $d['api_url_se'] == '') {

                    $d['api_url_se'] = $d['api_url'];
                    //$url = $db_class->getValueAsf("SELECT `api_url` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");

                }

                $inData['baseurl'] = $d['api_url_se']/*'https://10.1.6.8:7443'*/ . $this->url_postfix;
            }
            return $inData;
        }
    }

    protected final function formatResponse($success, $status, $status_code, $description)
    {
        return ['success' => $success, 'status' => $status, 'status_code' => $status_code, 'Description' =>  $description];
    }
    ///////////////session start/////////////////

    protected function session($c = NULL, $d = NULL)
    {

        if ($c == NULL) {

            $c = rand(1, 2);
        }

        if ($d == NULL) {

            $d = 1;
        } else {

            $d = 0;
        }

        $login = $this->login($c);

        //API Url
        $url = $login[baseurl] . '/session';

        //Initiate cURL.
        $ch = curl_init($url);

        //The JSON data.
        $jsonData = array(
            'username' => $login[username],
            'password' => $login[password]
        );

        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);

        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        //Execute the request
        $result = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $cookies = array();
        preg_match_all('/Set-Cookie:(?<cookie>\s{0,}.*)$/im', $result, $cookies);

        $cookies['cookie'][0]; // show harvested cookies

        $pieces = explode(";", $cookies['cookie'][0]);
        $pieces[0];

        $sus = json_decode($body, true);

        $results = array(
            'cookie' => $pieces[0],
            'baseurl' => $login[baseurl],
            'switch_baseurl' => $login[switch_baseurl]
        );

        if ($status != '200') {
            $this->log(__FUNCTION__, 'Login', $url, 'POST', $status, $body, $jsonDataEncoded, $this->realm);
        }
        if ($sus[controllerVersion]) {

            return $results;
            // session(1);
        } else if ($c == 1 && $d == 1) {

            return $this->session(2, 1);
        } else if ($c == 2 && $d == 1) {

            return $this->session(1, 1);
        } else {

            return $results;
        }
    }


    public static function FunctionList($array = false)
    {

        $jsonData_funtionlist = array(
            'queryClient' => 'Query Client From VSZ',
            'moveAPToZone' => 'Move AP to Zone',
            'createUTP' => 'Create UTP',
            'deleteAP' => 'Delete AP',
            'modifyZoneDNSServerProfile' => 'Modify DNS Server Profile',
            'modifyWLanDNSServerProfile' => 'Modify WLan DNS Server Profile',
            'disableWLanDNSServerProfile' => 'Disable WLan DNS Server Profile',
            'disableZoneDNSServerProfile' => 'Disable DNS Server Profile',
            'createzone' => 'Create Zones',
            'createap' => 'AP Creation',
            'createnetwork' => 'Create Network',
            'deleteeutp' => 'Delete UTP',
            'rkszones' => 'Check Zones',
            'retrieveNetworkList' => 'SSID List',
            'retrieveaplistzone' => 'APs retrieved from Zone ID',
            'modifynetwork' => 'Modify Network',
            'retrieveSchedulelist' => 'Retrieve scheduler List',
            'modifynetworkEncryption' => 'Modify Encryption',
            'retrieveOneNetwork' => 'Retrieve one SSID',
            'createScheduler' => 'Create Scheduler',
            'deleteeScheduler' => 'Delete Scheduler',
            'modifySchedule' => 'Modify Schedule',
            'retrieveTunnelGREProfile' => 'Retrieve Tunnel GRE',
            'modifyTunnelProfile' => 'Modify Tunnel Profile',
            'deletezone' => 'Delete zone',
            'retrieveZonedata' => 'Retrieve Zone details',
            'modifyZoneTimeZone' => 'Modify Zone Timezone',
            'modifyzone' => 'Modify Zone',
            'retrieveAPmac' => 'Retrieve APmac details',
            'retrieveSchedule' => 'RetrieveScheduler',
            'modifyPowerSchedule' => 'Modify Power Schedule',
            'retrieveAPMacList' => 'AP Client details',
            'retrieveAPOperationalSummary' => 'AP Operational Summary',
            'queryAP' => 'Query AP',
            'hideSSID' => 'Hide SSID',
            'getZoneDHCPProfile' => 'Get Zone DHCP Pool List',
            'retrieveDNSServerProfile' => 'Retrieve DNS Server Profile',
            'createDNSServerProfile' => 'Create DNS Server Profile',
            'disableAPmeshOption' => 'Disable AP Mesh Option',
            'rebootAP' => 'Reboot AP',
            'modifyZoneDHCPSiteConfig' => 'Modify Zone DHCP Site Config',
            'retrieveZoneMeshData' => 'Retrieve Zone Mesh Details',
            'modifyAp' => 'Modify AP',
            'retrieveDomains' => 'retrieve Domains',
            'createDomain' => 'Create Domain',
            'createZoneDual' => 'Create Zones Dual',
            'retrieveSubDomains' => 'Retrieve Sub Domains',
            'retrieveHotspotList' => 'Retrieve Hotspot List',
            'createSwitchGroup' => 'Create Switch Group',
            'getGreProfile' => 'Get GRE Profile',
            'getRadius' => 'Get Radius Details',
            'getfirewallProfiles' => 'Get Firewall Profiles',
            'getAccountingService' => 'Get Radius Accounting Service',
            'createHotspot' => 'Create hotspot',
            'createGuestSSID' => 'Create Guest SSID',
            'getSwitches' => 'Get Switches',
            'getSwitchGroup' => 'Get Switch Group',
            'getSwitchDetails' => 'Get Switch Details',
            'moveToSwitchGroup' => 'Move To Switch Group',
            'modifyDhcpProfile' => 'Modify DHCP Profile',
            'createZoneAAA' => 'Create New Zone AAA',
            'removeZoneAAA' => 'Delete Zone AAA',
            'retrieveZoneAAA' => 'Retrieve Zone AAA',
            'retrieveZoneAAAID' => 'Retrieve Zone AAA ID',
            'modifyZoneAAA' => 'Modify Zone AAA ID',
            'modifyavcEnabled' => 'Modify AVCEnabled',
            'create802' => 'Create New 802.1X',
            'modify802' => 'Modify 802.1X',
            'retrieveSystemTime' => 'Retrieve System Time',
            'deleteswitchgroup' => 'Delete Switch Group',
            'deleteSwitch' => 'Delete Switch',
            'addDPSKClient' => 'Add DPSK Client',
            'deleteDPSKClient' => 'Delete DPSK Client',
            'getDPSKClient' => 'Get DPSK Client',
            'retrieveaplist' => 'Retrieve AP List',
            'getAPGroups' => 'Retrieve AP Groups',
            'deleteAPGroup' => 'Delete AP Groups',
            'removeAPFromGroup' => 'Remove AP from AP Groups',
            'createAPGroup' => 'Create AP Groups',
            'addMemberToAPGroup' => 'Add Member to AP Groups',
            'getWLanGroups' => 'Get WlLan Groups',
            'getWLanGroup' => 'Get WlLan Group',
            'creatWLanGroups' => 'Create WlLan Groups',
            'addMemberToWLanGroups' => 'Add Member to WlLan Groups',
            'removeMemberFromWLanGroups' => 'Remove Member from WlLan Groups',
            'modifyWLanGroup24' => 'Modify WlLan Group 24',
            'modifyWLanGroup50' => 'Modify WlLan Group 50',
            'modifyAPGroup' => 'Modify AP Group',
            'getAPGroup' => 'Get AP Group Details',
            'removeWLanGroups' => 'Remove WLan Group',
            'CreateAp' => 'RND Creates AP',
            'DeleteAp' => 'RND Delete AP',
            'getZoneAffinity' => 'Get ZoneAffinity Profiles',
            'createHotspot20' => 'Create Hostspot 2.0',
            'getHotspot20Operators' => 'Get Hostspot 2.0 Operators',
            'getHotspot20IDPs' => 'Get Hostspot 2.0 Identity Provider',
            'createHotspot20SSID' => 'Create Hotspot 2.0 Wlan',
            'getZoneTunnelProfiles' => 'Get Available Tunnel Profile of Zone',
            'updateWlan' => 'Modify Wlan',
            'modifyTunnelProfile36' => 'Modify Tunnel Profile 3.6',
            'disconnectClient' => 'Disconnect Client',
            'disconnectClients' => 'Disconnect Clients',
            'getTotalTrafficTrend' => 'Get Total Traffic Trend',
        );

        if ($array) {
            return $jsonData_funtionlist;
        } else {
            return $data = json_encode($jsonData_funtionlist);
        }
    }


    protected function call($function, $url, $method = 'GET', $data = null, $file = false, $filePath = null)
    {
        $log_data = null;
        $ch = curl_init($url);

        if (!$file) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie:" . $this->cookie . "", 'Content-Type: application/json;charset=UTF-8'));
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie:" . $this->cookie . "", 'Content-Type: multipart/form-data'));
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        if (!is_null($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $log_data = $data;
        }

        if ($file) {
            $cfile = new CurlFile($filePath,  'text/csv');
            //curl file itself return the realpath with prefix of @
            $data = array('data-binary' => $cfile);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            //$log_data=$filePath;

            $file_handle = fopen($filePath, "r");

            $result = array();

            if ($file_handle !== FALSE) {

                $column_headers = fgetcsv($file_handle);
                foreach ($column_headers as $header) {
                    $result[$header] = array();
                }
                while (($data = fgetcsv($file_handle)) !== FALSE) {
                    $i = 0;
                    foreach ($result as &$column) {
                        $column[] = $data[$i++];
                    }
                }
                fclose($file_handle);
            }

            $log_data = json_encode($result);
        }


        //ADD FROM RACUS V5
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $resultl = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        //$header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $function_name = ruckus::FunctionList(true)[$function];
        $this->log($function, $function_name, $url, $method, $status, $message, $log_data, $this->realm);

        return ["status_code" => $status, "message" => $message];
    }


    public function getAPGroups($zone)
    {
        $url2 = $this->baseurl . '/rkszones/' . $zone . '/apgroups';
        $data = $this->call(__FUNCTION__, $url2, 'GET');
        if ($data['status_code'] == '200') {

            $res = json_decode($data['message'], true);

            return ['status' => true, "status_code" => 200, "data" => $res['list']];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }


    /*Get AP Group*/
    public function getAPGroup($zone, $id)
    {
        $url2 = $this->baseurl . '/rkszones/' . $zone . '/apgroups/' . $id;
        $data = $this->call(__FUNCTION__, $url2, 'GET');
        if ($data['status_code'] == '200') {

            $res = json_decode($data['message'], true);

            return ['status' => true, "status_code" => 200, "data" => $res];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }

    public function deleteAPGroup($zone_id, $id, array $macs = [])
    {

        foreach ($macs as $mac) {
            $mac = $this->db_class->macFormat($mac, '{"charCase":"upperCase","symbol":":"}');
            $this->removeAPFromGroup($zone_id, $id, $mac);
        }

        $url2 = $this->baseurl . '/rkszones/' . $zone_id . '/apgroups/' . $id;
        $data = $this->call(__FUNCTION__, $url2, 'DELETE');
        if ($data['status_code'] == '204') {

            //$res = json_decode($data['message'],true);

            return ['status' => true, "status_code" => 200, "data" => []];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }

    public function removeAPFromGroup($zone_id, $id, $mac)
    {

        $mac = $this->db_class->macFormat($mac, '{"charCase":"upperCase","symbol":":"}');
        $url2 = $this->baseurl . '/rkszones/' . $zone_id . '/apgroups/' . $id . '/members/' . $mac;
        $data = $this->call(__FUNCTION__, $url2, 'DELETE');
        if ($data['status_code'] == '204') {

            $res = json_decode($data['message'], true);

            return ['status' => true, "status_code" => 200, "data" => []];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }


    public function createAPGroup($zone_id, $name)
    {
        $url2 = $this->baseurl . '/rkszones/' . $zone_id . '/apgroups';
        $json_data = json_encode(["name" => $name, "description" => $name]);

        $data = $this->call(__FUNCTION__, $url2, 'POST', $json_data);
        if ($data['status_code'] == '201') {
            $res = json_decode($data['message'], true);
            return ['status' => true, "status_code" => 200, "data" => $res];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }



    public function modifyAPGroup($zone_id, $id, $name)
    {
        $url2 = $this->baseurl . '/rkszones/' . $zone_id . '/apgroups/' . $id;
        $json_data = json_encode(["name" => $name, "description" => $name]);

        $data = $this->call(__FUNCTION__, $url2, 'PATCH', $json_data);
        if ($data['status_code'] == '204') {
            $res = json_decode($data['message'], true);
            return ['status' => true, "status_code" => 200, "data" => $res];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }


    public function addMemberToAPGroup($zone_id, $id, array $macs = [])
    {
        $url2 = $this->baseurl . '/rkszones/' . $zone_id . '/apgroups/' . $id . '/members';

        $request_data = ['memberList' => []];
        //print_r($macs);
        foreach ($macs as $mac) {
            $mac = $this->db_class->macFormat($mac, '{"charCase":"upperCase","symbol":":"}');
            array_push($request_data['memberList'], ["apMac" => $mac]);
        }

        $json_data = json_encode($request_data);

        $data = $this->call(__FUNCTION__, $url2, 'POST', $json_data);
        if ($data['status_code'] == '201') {

            $res = json_decode($data['message'], true);

            return ['status' => true, "status_code" => 200, "data" => [$res]];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }


    ////////////////Get Wlan Groups/////////
    public function getWLanGroups($zone_id)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlangroups';
        $data = $this->call(__FUNCTION__, $url, 'GET');
        if ($data['status_code'] == '200') {
            $res = json_decode($data['message'], true);
            return ['status' => true, "status_code" => 200, "data" => $res];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }

    ////////////////Get Wlan Groups/////////
    public function getWLanGroup($zone_id, $wGroupId)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlangroups/' . $wGroupId;
        $data = $this->call(__FUNCTION__, $url, 'GET');
        if ($data['status_code'] == '200') {
            $res = json_decode($data['message'], true);
            return ['status' => true, "status_code" => 200, "data" => $res];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }



    ////////////////Get Wlan Groups/////////
    public function creatWLanGroups($zone_id, $name)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlangroups'; ///rkszones/{zoneId}/wlangroups
        $json_data = json_encode(["name" => $name, "description" => $name]);
        $data = $this->call(__FUNCTION__, $url, 'POST', $json_data);
        if ($data['status_code'] == '201') {
            $res = json_decode($data['message'], true);
            return ['status' => true, "status_code" => 200, "data" => $res];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }


    ////////////////Add Member to Wlan Groups/////////
    public function addMemberToWLanGroups($zone_id, $wGroupId, $member)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlangroups/' . $wGroupId . '/members'; ///rkszones/{zoneId}/wlangroups/{id}/members
        $json_data = json_encode(["id" => $member]);
        $data = $this->call(__FUNCTION__, $url, 'POST', $json_data);
        if ($data['status_code'] == '201') {
            //$res = json_decode($data['message'],true);
            return ['status' => true, "status_code" => 200, "data" => []];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }

    ////////////////Add Member to Wlan Groups/////////
    public function removeMemberFromWLanGroups($zone_id, $wGroupId, $member)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlangroups/' . $wGroupId . '/members/' . $member; ///rkszones/{zoneId}/wlangroups/{id}/members/{memberId}
        //$json_data = json_encode(["id"=>$member]);
        $data = $this->call(__FUNCTION__, $url, 'DELETE');
        if ($data['status_code'] == '204') {
            //$res = json_decode($data['message'],true);
            return ['status' => true, "status_code" => 200, "data" => []];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }


    ////////////////Add Member to Wlan Groups/////////
    public function removeWLanGroups($zone_id, $wGroupId)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlangroups/' . $wGroupId; ///rkszones/{zoneId}/wlangroups/{id}
        //$json_data = json_encode(["id"=>$member]);
        $data = $this->call(__FUNCTION__, $url, 'DELETE');
        if ($data['status_code'] == '204') {
            //$res = json_decode($data['message'],true);
            return ['status' => true, "status_code" => 200, "data" => []];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }


    ////////////////Modify  wlanGroup24 of AP Group/////////
    public function modifyWLanGroup24($zone_id, $groupId, $wlanGroupId, $wlanGroupName)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/apgroups/' . $groupId . '/wlanGroup24'; //PATCH/v7_0/rkszones/{zoneId}/apgroups/{id}/wlanGroup24

        $json_data = json_encode(["id" => $wlanGroupId, "name" => $wlanGroupName]);

        $data = $this->call(__FUNCTION__, $url, 'PATCH', $json_data);
        if ($data['status_code'] == '204') {
            //$res = json_decode($data['message'],true);
            return ['status' => true, "status_code" => 200, "data" => []];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }


    ////////////////Modify  wlanGroup50 of AP Group/////////
    public function modifyWLanGroup50($zone_id, $groupId, $wlanGroupId, $wlanGroupName)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/apgroups/' . $groupId . '/wlanGroup50'; //PATCH/v7_0/rkszones/{zoneId}/apgroups/{id}/wlanGroup24

        $json_data = json_encode(["id" => $wlanGroupId, "name" => $wlanGroupName]);

        $data = $this->call(__FUNCTION__, $url, 'PATCH', $json_data);
        if ($data['status_code'] == '204') {
            //$res = json_decode($data['message'],true);
            return ['status' => true, "status_code" => 200, "data" => []];
        } else {
            return ['status' => false, "status_code" => $data['status_code'], "error" => $data['message']];
        }
    }

    ////////////////Modify  wlanGroup of AP Group/////////
    public function modifyWLanGroup($zone_id, $groupId, $wlanGroupId, $wlanGroupName)
    {
        $g24 = $this->modifyWLanGroup24($zone_id, $groupId, $wlanGroupId, $wlanGroupName);
        $g50 = $this->modifyWLanGroup50($zone_id, $groupId, $wlanGroupId, $wlanGroupName);

        if ($g24['status'] === true && $g50['status'] === true) {
            //$res = json_decode($data['message'],true);
            return ['status' => true, "status_code" => 200, "data" => []];
        } else {
            return ['status' => false, "status_code" => '24-' . $g24['status_code'] . '/50-' . $g50['status_code'], "error" => '24-' . $g24['message'] . '/50-' . $g50['message']];
        }
    }


    public function queryAP(array $data)
    {

        //$input=$this->session();

        $url = $this->baseurl . '/query/ap';

        //$ch2 = curl_init($url2);

        //Encode the array into JSON.
        $jsonData = json_encode($data);

        $data = $this->call(__FUNCTION__, $url, 'POST', $jsonData);


        $message = urlencode($data['message']);

        if ($data['status_code'] == '200') {

            return 'status=success&status_code=200&Description=' . $message;
        } else {
            return 'status=failed&status_code=' . $data['status_code'] . '&Description=' . $message;
        }
    }

    public function rkszones($index = 0)
    {

        //$list_size = 10000;
        $url = $this->baseurl . '/rkszones?index=' . $index . '&listSize=' . $this->zoneListSize;

        $data = $this->call(__FUNCTION__, $url, 'GET');

        $desc = json_decode($data['message']);
        //sprint_r($desc);echo '<hr>';
        if ($desc->hasMore === true) {
            parse_str($this->rkszones($index + $this->zoneListSize), $more_list);
            $more_desc = json_decode($more_list['Description']);
            foreach ($more_desc->list as $value) {
                array_push($desc->list, $value);
            }
        }


        $desc->hasMore = 0;
        $message = urlencode(json_encode($desc));

        if ($data['status_code'] == 200) {

            return 'status=success&status_code=200&Description=' . $message;
        } else {
            return 'status=failed&status_code=' . $data['status_code'] . '&Description=' . $message;
        }
    }

    public function retrieveDomains($index = 0)
    {

        //$list_size = 10000;
        $url = $this->baseurl . '/domains?index=' . $index . '&listSize=' . $this->zoneListSize;

        $data = $this->call(__FUNCTION__, $url, 'GET');

        $desc = json_decode($data['message']);
        //sprint_r($desc);echo '<hr>';
        if ($desc->hasMore === true) {
            parse_str($this->retrieveDomains($index + $this->zoneListSize), $more_list);
            $more_desc = json_decode($more_list['Description']);
            foreach ($more_desc->list as $value) {
                array_push($desc->list, $value);
            }
        }


        $desc->hasMore = 0;
        $message = urlencode(json_encode($desc));

        if ($data['status_code'] == 200) {

            return 'status=success&status_code=200&Description=' . $message;
        } else {
            return 'status=failed&status_code=' . $data['status_code'] . '&Description=' . $message;
        }
    }

    public function retrieveSubDomains($domain_id,$index = 0)
    {

        //$list_size = 10000;
        $url = $this->baseurl . '/domains/' . $domain_id . '/subdomain?index=' . $index . '&listSize=' . $this->zoneListSize;

        $data = $this->call(__FUNCTION__, $url, 'GET');

        $desc = json_decode($data['message']);
        //sprint_r($desc);echo '<hr>';
        if ($desc->hasMore === true) {
            parse_str($this->retrieveSubDomains($domain_id,$index + $this->zoneListSize), $more_list);
            $more_desc = json_decode($more_list['Description']);
            foreach ($more_desc->list as $value) {
                array_push($desc->list, $value);
            }
        }


        $desc->hasMore = 0;
        $message = urlencode(json_encode($desc));

        if ($data['status_code'] == 200) {

            return 'status=success&status_code=200&Description=' . $message;
        } else {
            return 'status=failed&status_code=' . $data['status_code'] . '&Description=' . $message;
        }
    }

    public function updateWLanTunnel($zone_id, $WLan_id, $tunnelType, $id = null, $name = null)
    {
        //rkszones/{zoneId}/wlans/{id}
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlans/' . $WLan_id;

        if ($tunnelType == 'APLBO') {
            $data = [
                "accessTunnelType" => "APLBO",
                "accessTunnelProfile" => null
            ];
        } else {
            $data = [
                "accessTunnelType" => $tunnelType,
                "accessTunnelProfile" => [
                    "id" => $id,
                    "name" => $name
                ]
            ];
        }

        $jsonData = json_encode($data);

        $data = $this->call(__FUNCTION__, $url, 'PATCH', $jsonData);

        $message = urlencode($data['message']);

        if ($data['status_code'] == '200') {

            return ['success' => true, 'status' => 'success', 'status_code' => 200, 'Description' =>  $message];
        } else {
            return ['success' => false, 'status' => 'failed', 'status_code' => $data['status_code'], 'Description' =>  $message];
        }
    }

    public function getZoneAffinity()
    {
        $url = $this->baseurl . '/profiles/zoneAffinity';
        $data = $this->call(__FUNCTION__, $url, 'GET');

        $message = $data['message'];

        if ($data['status_code'] == '200') {

            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $data['status_code'], $message);
        }
    }

    public function createHotspot20($zone_id, $Post_data)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/hs20s';

        if (is_array($Post_data)) {
            $Post_data = json_encode($Post_data);
        }

        $data = $this->call(__FUNCTION__, $url, 'POST', $Post_data);

        $message = json_decode($data['message']);

        if ($data['status_code'] == '201') {

            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $data['status_code'], $message);
        }
    }

    public function getHotspot20Operators()
    {
        $url = $this->baseurl . '/profiles/hs20/operators';
        $data = $this->call(__FUNCTION__, $url, 'GET');

        $message = $data['message'];

        if ($data['status_code'] == '200') {

            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $data['status_code'], $message);
        }
    }

    public function getHotspot20IDPs()
    {
        $url = $this->baseurl . '/profiles/hs20/identityproviders';
        $data = $this->call(__FUNCTION__, $url, 'GET');

        $message = $data['message'];

        if ($data['status_code'] == '200') {

            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $data['status_code'], $message);
        }
    }

    public function createHotspot20SSID($zone_id, $Post_data)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlans/hotspot20';

        $Post_data['advancedOptions']['clientIsolationAutoVrrpEnabled'] = true;
        $Post_data['radiusOptions']['singleSessionIdAcctEnabled'] = true;

        if (is_array($Post_data)) {
            $Post_data = json_encode($Post_data);
        }

        $data = $this->call(__FUNCTION__, $url, 'POST', $Post_data);

        $message = $data['message'];

        if ($data['status_code'] == '201') {

            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $data['status_code'], $message);
        }
    }

    public function getZoneTunnelProfiles($zone_id)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/availableTunnelProfiles';
        $data = $this->call(__FUNCTION__, $url, 'GET');

        $message = $data['message'];

        if ($data['status_code'] == '201') {

            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $data['status_code'], $message);
        }
    }

    public function updateWlan($zone_id, $network_id, array $data)
    {
        $url = $this->baseurl . '/rkszones/' . $zone_id . '/wlans/' . $network_id;
        $payload = json_encode($data);

        $res = $this->call(__FUNCTION__, $url, 'PATCH', $payload);
        $message = $res['message'];
        if ($res['status_code'] == '204') {
            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $res['status_code'], $message);
        }
    }

    public function modifyTunnelProfile36($zoneid, $tunnelProfileID, $tunnelProfileName)
    {
        $data = array(
            'id' => $tunnelProfileID,
            'name' => $tunnelProfileName
        );
        $payload = json_encode($data);
        $url = $this->baseurl . '/rkszones/' . $zoneid . '/tunnelProfile';
        $res = $this->call(__FUNCTION__, $url, 'PATCH', $payload);
        $message = $res['message'];
        if ($res['status_code'] == '204') {
            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $res['status_code'], $message);
        }
    }

    public function disconnectClient($apMac, $clientMac)
    {
        $data = array(
            'mac' => $clientMac,
            'apMac' => $apMac
        );
        $payload = json_encode($data);
        $url = $this->baseurl . '/clients/disconnect';
        $res = $this->call(__FUNCTION__, $url, 'POST', $payload);
        $message = $res['message'];
        if ($res['status_code'] == '204') {
            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $res['status_code'], $message);
        }
    }
    public function disconnectClients(array $clients)
    {
        $data = array(
            'clientList' => $clients
        );
        $payload = json_encode($data);
        $url = $this->baseurl . '/clients/bulkDisconnect';
        $res = $this->call(__FUNCTION__, $url, 'POST', $payload);
        $message = $res['message'];
        if ($res['status_code'] == '204') {
            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $res['status_code'], $message);
        }
    }

    public function getTotalTrafficTrend($switchGroup, $switch, $start, $end)
    {
        $url = $this->switch_baseurl . '/traffic/total/trend' . '?serviceTicket=' . $this->getServiceTicket();

        $payload = json_encode([
            "filters" => [
                [
                    "type" => "SWITCH_GROUP", "value" => $switchGroup
                ]
            ],
            "extraFilters" => [
                ["type" => "SWITCH", "value" => $switch]
            ],
            "extraTimeRange" => [
                "start" => (int)$start,
                "end" => (int)$end,
                "interval" => 150000
            ],
            "limit" => 1000,
            "page" => 10
        ]);

        $res = $this->call(__FUNCTION__, $url, 'POST', $payload);
        $message = $res['message'];
        ///

        if ($res['status_code'] == '200') {
            return $this->formatResponse(true, 'success', 200, $message);
        } else {
            return $this->formatResponse(false, 'failed', $res['status_code'], $message);
        }
    }


    ////////////////Delete to ZoneAAA/////////
    public function removeZoneAAA($zoneid, $id)
    {
        $url = $this->baseurl . '/rkszones/' . $zoneid . '/aaa/radius/' . $id; //'/rkszones/'.$zoneid.'/aaa/radius/'.$id

        $data = $this->call(__FUNCTION__, $url, 'DELETE');
        if ($data['status_code'] == '204') {
        

            return 'status=success&status_code=200&Description='.$data['message'];
    
        }
        else{
            return 'status=failed&status_code='.$data['status_code'].'&Description='.$data['message'];
    
        }
    }
}
