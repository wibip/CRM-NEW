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

/*Second attempt- Request Client Credentials Token*/
$oidc->providerConfigParam(array('token_endpoint'=>'https://auth.k8spre.arriswifi.com/connect/token'));
$oidc->addScope('my_scope');
// this assumes success (to validate check if the access_token property is there and a valid JWT) :
$clientCredentialsToken = $oidc->requestClientCredentialsToken()->access_token;

