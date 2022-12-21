<?php
ini_set('display_errors', 1);
require 'vendor/autoload.php';
require 'cred.php';


$oidc = new Jumbojett\OpenIDConnectClient($issuer, $cid, $secret);

// added by john - this is the scope that other apps are using, you need to send groups to receive them
$oidc->addScope($scope);

error_log('1');
$oidc->authenticate();
// var_dump($oidc);die;
error_log('2');
$oidc->requestUserInfo('sub');
error_log('3');

$session = array();
error_log('4');
foreach($oidc as $key=> $value) {

    if(is_array($value)){

            $v = implode(', ', $value);

    }else{

            $v = $value;

    }

    $session[$key] = $v;

}



session_start();

$_SESSION['attributes'] = $session;


header("Location: ./attributes.php");


?>
