<?php
ini_set('display_errors', 1);
require 'vendor/autoload.php';
require 'cred.php';

use Jumbojett\OpenIDConnectClient;
$oidc = new OpenIDConnectClient($issuer, $cid, $secret);

/*First attempt- Get user details*/
// $oidc->setCertPath('./certificate.crt');
// // $oidc->providerConfigParam(array('token_endpoint'=>'https://auth.k8spre.arriswifi.com/connect/token'));
// $oidc->authenticate();
// $name = $oidc->requestUserInfo();
// var_dump($name);

/*Second attempt register a client*/
$oidc->register();
$client_id = $oidc->getClientID();
$client_secret = $oidc->getClientSecret();
var_dump($client_secret);

