<?php
ini_set('display_errors', 1);
require 'vendor/autoload.php';
require 'cred.php';

use Jumbojett\OpenIDConnectClient;
$oidc = new OpenIDConnectClient($issuer, $cid, $secret);

$oidc->addScope($scope);

/*First attempt- Get user details*/
$oidc->setCertPath('./certificate.crt');
$oidc->addScope($scope);
// $oidc->providerConfigParam(array('token_endpoint'=>'https://auth.k8spre.arriswifi.com/connect/token'));
$oidc->authenticate();
// $oidc = $oidc->requestUserInfo();
// var_dump($oidc);

/*Second attempt- Request Client Credentials Token*/
try{
    $oidc = $oidc->requestUserInfo();
    $session = array();
    foreach($oidc as $key=> $value) {
        if(is_array($value)) {
    	    $v = implode(', ', $value);
        } else {
    	    $v = $value;
        }
        $session[$key] = $v;
    }

    session_start();
    $_SESSION['attributes'] = $session;

    // header("Location: ./attributes.php");
    header("Location: ../crm/src/auth/local_auth/login.php");
} catch(Exception $e){
    var_dump($e);
}


// $session = array();
// foreach($oidc as $key=> $value) {
//     if(is_array($value)) {
// 	    $v = implode(', ', $value);
//     } else {
// 	    $v = $value;
//     }
//     $session[$key] = $v;
// }

// session_start();
// $_SESSION['attributes'] = $session;

// header("Location: ./attributes.php");

?>
