<?php
ini_set('display_errors', 1);
require 'vendor/autoload.php';
require 'cred.php';

use Jumbojett\OpenIDConnectClient;
$oidc = new OpenIDConnectClient($issuer, $cid, $secret);

$oidc->setCertPath('./certificate.crt');
// $oidc->providerConfigParam(array('token_endpoint'=>'https://auth.k8spre.arriswifi.com/connect/token'));
  
$oidc->authenticate();
// this assumes success (to validate check if the access_token property is there and a valid JWT) :
// $clientCredentialsToken = $oidc->requestClientCredentialsToken()->access_token;
// $clientCredentialsToken = $oidc->requestResourceOwnerToken(TRUE)->access_token;

// $oidc->setCertPath('./certificate.crt');

$name = $oidc->requestUserInfo('given_name');
var_dump($name);

