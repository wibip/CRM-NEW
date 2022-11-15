<?php
error_log('-3');
error_log(json_encode($_REQUEST));
require 'vendor/autoload.php';
require 'cred.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$oidc = new Jumbojett\OpenIDConnectClient($issuer, $cid, $secret);

error_log('0');
// added by john - this is the scope that other apps are using, you need to send groups to receive them
$oidc->addScope($scope);

// error_log('1');
$test = $oidc->authenticate();
var_dump($test);die;
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
