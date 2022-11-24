<?php
class CommonFunctions{
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

    public static function httpGet($url){
        $ch = curl_init();
         curl_setopt($ch,CURLOPT_URL,$url);
         curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
         //  curl_setopt($ch,CURLOPT_HEADER, false);

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
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $output=curl_exec($ch);

        curl_close($ch);
        return $output;
    }
}