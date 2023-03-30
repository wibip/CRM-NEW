<?php
require_once '../classes/CommonFunctions.php';
$CommonFunctions = new CommonFunctions();
$url = $_POST['url'];

$username = $_POST['username'];
$password = $_POST['password'];

if($url != '' && $username != '' && $password != ''){
    if (preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $url)) {
        $apiReturn = json_decode($CommonFunctions->httpPost('Generate Token','get api token','API Token generation',$url,$data,true) , true);
       
        if($apiReturn['status'] == 'success'){
            echo 'true';
        } else {
            echo $apiReturn['data']['message'];
        }      
    } else {
        echo "Please use valid URL";  
    }
    
} else {
    echo 'empty';
}


?>