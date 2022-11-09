<?php
require __DIR__ . '/vendor/autoload.php';
require 'cred.php';
use Jumbojett\OpenIDConnectClient;

$oidc = new OpenIDConnectClient($issuer,
                                $cid,
                                $secret);
$oidc->providerConfigParam(array('token_endpoint'=>$issuer.'/connect/token'));
$oidc->addScope($scope);

//Add username and password
$oidc->addAuthParam(array('username'=>'test-client'));
$oidc->addAuthParam(array('password'=>'thah5eiQuov1'));

//Perform the auth and return the token (to validate check if the access_token property is there and a valid JWT) :
$token = $oidc->requestResourceOwnerToken(TRUE)->access_token;

print_r($token);
