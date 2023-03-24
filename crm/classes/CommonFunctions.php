<?php

require_once __DIR__.'/dbClass.php';
class CommonFunctions{
    private $db;
	public function  __construct(){
		$this->db = new db_functions();
	}
    public static function timeGapToString($value){
        $gap = '';
        try {
            $interval = new DateInterval($value);
            if($interval->y != 0){
                $gap .= $interval->y.' Years ';
            }
            if($interval->m != 0){
                $gap .= $interval->m.' Months ';
            }
            if($interval->d != 0){
                $gap .= $interval->d.' Days ';
            }
            if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
                $gap .= ' And ';
            }
            if($interval->i != 0){
                $gap .= $interval->i.' Minutes ';
            }
            if($interval->h != 0){
                $gap .= $interval->h.' Hours ';
            }
        } catch (Exception $e) {
            $gap = '0 Days';
        }

        return $gap;
    }

    public static function httpGet($url,$json=false){
        $ch = curl_init();
         curl_setopt($ch,CURLOPT_URL,$url);
         curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
         
        if($json==true) {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }

         $output=curl_exec($ch);

         curl_close($ch);
         return $output;
    }

    public static function clean($string) {
    //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
  
        return preg_replace('/[^A-Za-z0-9\- ]/', '', $string); // Removes special chars.
      }
    
    public static function formatOffset($offset) {
        $hours = $offset / 3600;
        $remainder = $offset % 3600;
        $sign = $hours > 0 ? '+' : '-';
        $hour = (int) abs($hours);
        $minutes = (int) abs($remainder / 60);
        if ($hour == 0 AND $minutes == 0) {
            $sign = ' ';
        }
        return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');

    }

    public static function httpPost($url,$data,$json=false)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        if($json==true) {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }
        

        // Receive server response ...
        //$header_parameters = "Content-Type: application/json;charset=UTF-8";
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        $server_output = curl_exec($ch);
        //echo $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        //$header = substr($server_output, 0, $header_size);
        //$message = substr($server_output, $header_size);
// var_dump($server_output);echo 'in func';die;
        return $server_output;
        curl_close ($ch);

    }
    public static function randomPasswordlength($length)
        {

            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@";
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < $length; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }

            return implode($pass); //turn the array into a string
        }

    public static function mob_format($mobile_no)
        {

            if (!empty($mobile_no)) {
                $mobile_no = str_replace("-", "", $mobile_no);
                $mobile_no = str_replace(".", "", $mobile_no);
                $mobile_no = str_replace("(", "", $mobile_no);
                $mobile_no = str_replace(")", "", $mobile_no);
                return $to = sprintf("%s-%s-%s",
                    substr($mobile_no, 0, 3),
                    substr($mobile_no, 3, 3),
                    substr($mobile_no, 6));
            }
        }
        
    public static function validate_mobile($mobile)
    {
      return preg_match("/^[1]{1}-[0-9]{3}-[0-9]{3}-[0-9]{4}|[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $mobile);
    }

    public static function checkMac($string){
      $string=str_replace('-','',$string);
      $string=str_replace(':','',$string);
      $string=strtolower($string);

      $string_arry=str_split($string);

      //cannot exists
      $cannot_exists=array('1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f');

      foreach ($string_arry as $key=>$value){
        if(!in_array($value,$cannot_exists)){
          return false;
        }
      }

      $length=strlen($string);
      return $length==12;


    }

    public static function getMac($string){
      $string=str_replace('-','',$string);
      $string=str_replace(':','',$string);
      $string=strtolower($string);
      return $string;


    }

    public static function checkFormat($string){ //IF string is a MAC ,Return TRUE
        $regex_mac = '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$|[0-9A-Fa-f]{12}$/';

        //** check regex mach
        if (preg_match($regex_mac,$string))
        {
            return "mac";
        }

        //** php email regex checker
        elseif(filter_var($string, FILTER_VALIDATE_EMAIL)){
            return "email";
        }
        else
        {
            return "name";
        }

    }
    public static  function uniqueAssocArray($array, $uniqueKey, $uniqueKey2) {
      if (!is_array($array)) {
        return array();
      }
      $uniqueKeys = array();
      foreach ($array as $key => $item) {
        if ((!in_array($item[$uniqueKey], $uniqueKeys)) AND (!in_array($item[$uniqueKey2], $uniqueKeys))) {
          $uniqueKeys[$item[$uniqueKey]] = $item;
        }
      }
      return $uniqueKeys;
    }
        
    public static function randomPassword($length=8) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); //turn the array into a string
}
    public static function macDisplay($mac_relm){

        $mac_relm = str_replace(':', '', $mac_relm);
        $mac_relm = str_replace('-', '', $mac_relm);

        $arr1 = str_split($mac_relm);

        $i = -1;

        foreach ($arr1 as $key => $value){
            $mac .= $value;
            if($i % 2 == 0){
                $mac .= ":";
            }
            $i++;
        }

        return trim($mac,':');
    }

    public static function listFolderFiles($dir,array $arr=[]){
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1)
            return $arr;

        //echo '<ol>';
        foreach($ffs as $ff){
            //echo '<li>'.$ff;
            if(is_dir($dir.'/'.$ff)) {
                $arr = self::listFolderFiles($dir.'/'.$ff,$arr);
            }else{
                $f = $dir.'/'.$ff;
                $fds = explode('.',$ff);
                $f_ext = $fds[count($fds)-1];
                $f_name = implode('.', explode('.', $ff, -1));
                //array_push($arr,$f);
                $arr[$f]=["name"=>$f_name,"ext"=>$f_ext];
            }
            //echo '</li>';
        }

        return $arr;

    }

    public static function removeDir($dir){
        //$dir = 'samples' . DIRECTORY_SEPARATOR . 'sampledirtree';
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

    public static function setUrlHttps($url){
        // Search the pattern 
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
              
            // If not exist then add http 
            $url = "https://" . $url; 
        } 
          
        // Return the URL 
        return $url;

    }

    public static function isJson($string) {
     json_decode($string);
     return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function aaasort(&$array, $key1=null, $key2=null,$key3=null) {
    $sorter=array();
    $sorternew=array();
    $ret=array();
    
    $length = count($array);

    for ($outer = 0; $outer < $length; $outer++) {
      for ($inner = 0; $inner < $length; $inner++) {
       if ($array[$outer][$key1] < $array[$inner][$key1]) {
            $tmp = $array[$outer];
            $array[$outer] = $array[$inner];
            $array[$inner] = $tmp;
       }
      }
    }
    if (strlen($key2)>0) {
    
    for ($outer = 0; $outer < $length; $outer++) {
      for ($inner = 0; $inner < $length; $inner++) {
       if ($array[$outer][$key1] == $array[$inner][$key1]) {
        if ($array[$outer][$key2] < $array[$inner][$key2]) {
            $tmp = $array[$outer];
            $array[$outer] = $array[$inner];
            $array[$inner] = $tmp;
        }
        
       }
      }
    }
    }

    if (strlen($key3)>0) {
    for ($outer = 0; $outer < $length; $outer++) {
      for ($inner = 0; $inner < $length; $inner++) {
       if ($array[$outer][$key1] == $array[$inner][$key1] && $array[$outer][$key2] == $array[$inner][$key2]) {
        if ($array[$outer][$key3] < $array[$inner][$key3]) {
            $tmp = $array[$outer];
            $array[$outer] = $array[$inner];
            $array[$inner] = $tmp;
        }
        
       }
      }
    }
    }

    }

    public static function split_from_num($a){

        $num = ['1','2','3','4','5','6','7','8','9','0'];
        for($i = 0 ; $i<strlen($a); $i++){
            if(!in_array($a[$i],$num)){
                $pos=$i;
                break;
            }
        }
        //echo $pos;
        //echo substr($a,0,$pos);
        //echo substr($a,$pos,strlen($a)-$pos);
        return substr($a,0,$pos);
        } 

    public static function convertToReadableSize($size, $type = 'DATA')
    {
        $x = 1024;
        if($type =="BANDWIDTH"){
            $x = 1000;
        } 
        $base = log($size) / log($x);
        $suffix_bandwidth = array("Bps", "Kbps", "Mbps", "Gbps", "Tbps");
        $suffix_data = array("B", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        $percentageChange = round(pow($x, $base - floor($base)), 1);

        if (is_nan($percentageChange) || is_infinite($percentageChange)) {
            $percentageChange = 0;
        }
        if ($type == 'DATA') {
            return $percentageChange . $suffix_data[$f_base];
        } else {
            return $percentageChange . $suffix_bandwidth[$f_base];
        }
    }

    public static function getServiceTypes($url,$token){
        // $url = "http://bi-development.arrisi.com/api/v1_0/service-types";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
        var_dump($url);
        echo '<br/>';
        var_dump($token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output=curl_exec($ch);
        
        return $output;
        curl_close($ch);
    }

    public function getSelectedApis($mno_id){
        $sql = "SELECT features FROM exp_mno WHERE mno_id ='".$mno_id."'";
        $result =  $this->db->selectDB($sql);
        return json_decode($result['data'][0]['features'], true);
    }

    public function getApiProfiles($api_ids){
        $result = null;
        $sql = "SELECT id,api_profile FROM exp_locations_ap_controller";
        if(!empty($api_ids)) {
            $ids = implode(",", $api_ids);
            $sql .= " WHERE id IN (".$ids.")";
        }
        $result =  $this->db->selectDB($sql);
        return $result;
    }

    public function getApiDetails($api_id){
        $sql = "SELECT controller_name,api_url,api_username,api_password FROM exp_locations_ap_controller WHERE id=".$api_id;
        $result =  $this->db->selectDB($sql);
        return $result;
    }

    public function getPropertyDetails($id,$column){
        $sql = "SELECT ".$column." FROM exp_crm WHERE id=".$id;
        $result =  $this->db->selectDB($sql);
        return $result;
    }

    public function getUserTypeFromAccessType($access_role){
        $sql = "SELECT role_type FROM admin_access_roles WHERE access_role='".$access_role."'"; 
        $result =  $this->db->selectDB($sql);
        $userType = null;
        if(count($result) > 0) {
            $roleType = $result['data'][0]['role_type'];
            switch($roleType) {
                case 'sadmin':
                    $userType = 'SADMIN';
                break;
                case 'salesmanager':
                    $userType = 'SMAN';
                break;
                case 'nadmin':
                    $userType = 'ADMIN';
                break;
                default:
                    $userType = 'ADMIN';
                break;
            }
        }
        return $userType;
    }

    public function getAdminUserDetails($column,$value,$retriveValue='*'){
        $sql = "SELECT ".$retriveValue." FROM admin_users WHERE ".$column."='".$value."'";
        $result =  $this->db->selectDB($sql);
        return $result;
    }

    public function getAdminUserDetailsFromClient($clientId,$column){
        $sql = "SELECT au.".$column." FROM crm_portal.crm_clients AS crmc
                INNER JOIN admin_users AS au ON au.id = crmc.user_id
                WHERE crmc.id=".$clientId;
        $result =  $this->db->selectDB($sql);
        return $result;
    }

    public function getPropertyForSM($access_role){
        $sqlProperties = "SELECT ec.id,ec.business_name,ec.property_id,ec.`status`,au.full_name,au.id AS client_id FROM exp_crm AS ec 
                            INNER JOIN admin_users AS au ON au.user_distributor = ec.mno_id 
                            INNER JOIN admin_access_account AS aaa ON  aaa.operation_id = au.id 
                            WHERE aaa.access_role='$access_role'";
        $result =  $this->db->selectDB($sqlProperties);
        return $result;
    }

    public function getAllOperators(){
        $sqlOperators = "SELECT full_name,user_distributor FROM crm_portal.admin_users WHERE user_type='MNO' AND is_enable=1";
        $result =  $this->db->selectDB($sqlOperators);
        return $result;
    }

    public function getSystemPackage($mno_id){
        $sqlSysPackage = "SELECT `system_package`, features FROM `exp_mno` WHERE `mno_id`='$mno_id'";
        $resultSysPackage =  $this->db->selectDB($sqlSysPackage);
        return $resultSysPackage;
    }

    public function getProperties($user_type,$user_name,$user_distributor,$city,$state,$zip,$start_date,$end_date,$limit=10,$client_name = null,$business_name=null,$status=null) {
		$subQuery = "";        
        $clientArray = [];
        $businessArray = [];
        $cityArray = [];
        $stateArray = [];
        $zipArray = [];
        $clientApiArray = [];
        
        $propertyQuery = "SELECT id,property_id,business_name,status,city,state,zip,create_user,create_date FROM exp_crm WHERE create_user IN ( SELECT user_name FROM admin_users ".$subQuery.")";
        switch($user_type ){
            case 'SADMIN' :
                $propertyQuery .= "";
            break;
            case 'ADMIN' :
                $propertyQuery .= "";
            break;
            case 'MNO' :
                $propertyQuery .= " AND mno_id='$user_distributor'";
            break;
            case 'SMAN' :
                $propertyQuery .= " AND mno_id='$user_distributor'";
            break;
            case 'PROVISIONING' :
                $propertyQuery .= " AND create_user='$user_name'";
            break;
        }

        /* get values for filters before filtering */
        $filter_results = $this->db->selectDB($propertyQuery);
        
        if ($filter_results['rowCount'] > 0) {
            foreach ($filter_results['data'] as $row) {
                $clientDetails = $this->getAdminUserDetails('user_name', $row['create_user']);
                if (!empty($clientDetails['data'])) {
                    $clientName = $clientDetails['data'][0]['full_name'];
                    $clientArray[$row['create_user']] = $clientName;

                    $mno_id = $clientDetails['data'][0]['user_distributor'];
                    $apiResult = $this->getApi($mno_id);
                    if($apiResult != null){
                        $clientApiArray[$row['id']] = $apiResult['data'][0]['features'];
                    }
                }
                $businessArray[$row['business_name']] = $row['business_name'];
                $cityArray[$row['city']] = $row['city'];
                $stateArray[$row['state']] = $row['state'];
                $zipArray[$row['zip']] = $row['zip'];
            }
        }

        if ($start_date != null && $end_date != null) {
			$propertyQuery .=" AND create_date BETWEEN '".$start_date."' AND '".$end_date."'";
		}

        /* Add filtering */
        if($business_name != null && $business_name != 'all') {
            $propertyQuery .= " AND business_name='".$business_name."'";
        }

        if($city != null && $city != 'all') {
            $propertyQuery .= " AND city='".$city."'";
        }

        if($state != null && $state != 'all') {
            $propertyQuery .= " AND `state`='".$state."'";
        }

        if($zip != null && $zip != 'all') {
            $propertyQuery .= " AND zip='".$zip."'";
        }

        if($status != null && $status != 'all') {
            $propertyQuery .= " AND status='".$status."'";
        }
        // echo $propertyQuery;
        $query_results = $this->db->selectDB($propertyQuery);

        $results = ['query_results'=>$query_results,'client_api' => $clientApiArray,'clientArray'=>$clientArray,'businessArray'=>$businessArray,'cityArray'=>$cityArray,'stateArray'=>$stateArray,'zipArray'=>$zipArray];
        return $results;
	}

    public function getApi($mno_id) {
        $sql = "SELECT features FROM `exp_mno` WHERE `mno_id`='$mno_id'";
        $results = $this->db->selectDB($sql);
        return $results;
    }

    public function getCategories($operator_id) {
        $sql = "SELECT * FROM `crm_user_categories` WHERE `operator_id`='$operator_id'";
        $results = $this->db->selectDB($sql);
        return $results;
    }

    
}