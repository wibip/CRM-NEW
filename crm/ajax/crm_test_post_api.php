<?php
require_once '../classes/CommonFunctions.php';
$CommonFunctions = new CommonFunctions();
$url = $_POST['url'];
$username = $_POST['username'];
$password = $_POST['password'];
if($url != '' && $username != '' && $password != ''){
    $data = json_encode(['username'=>$username, 'password'=>$password]);
    // $payload = json_encode( array( "customer"=> $data ) );
    $apiReturn = json_decode($CommonFunctions->httpPost($url,$data,true) , true);
    // var_dump($apiReturn);die;
    if($apiReturn['status'] == 'success'){
        echo 'true';
    } else {
        echo $apiReturn['data']['message'];
    }
} else {
    echo 'empty';
}


?>