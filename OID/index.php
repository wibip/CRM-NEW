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
$oidc->setResponseTypes(array('id_token'));
$oidc->addScope(array('openid'));
$oidc->setAllowImplicitFlow(true);
$oidc->addAuthParam(array('response_mode' => 'form_post'));
$oidc->setCertPath('./certificate.crt');
$oidc->authenticate();
$sub = $oidc->getVerifiedClaims('sub');
var_dump($sub);
