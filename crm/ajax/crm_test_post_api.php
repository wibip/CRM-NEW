<?php
require_once '../classes/CommonFunctions.php';
$CommonFunctions = new CommonFunctions();
$url = $_POST['url'];

$username = $_POST['username'];
$password = $_POST['password'];

if($url != '' && $username != '' && $password != ''){
    if (preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $url)) {
 
        $data = json_encode(['username'=>$username, 'password'=>$password]);
        
        $apiReturn = json_decode($CommonFunctions->httpPost($url,$data,true) , true);
       
        if($apiReturn['status'] == 'success'){
            echo 'true';
        } else {
            echo $apiReturn['data']['message'];
        }      
    } else {
        echo "Please use valid valid URL";  
    }
    
} else {
    echo 'empty';
}


?>