<?php
ini_set('display_errors', 1);
require 'vendor/autoload.php';
require 'cred.php';

use Jumbojett\OpenIDConnectClient;
$oidc = new OpenIDConnectClient($issuer, $cid, $secret);

$oidc->addScope($scope);

/*First attempt- Get user details*/
$oidc->setCertPath('./certificate.crt');
// $oidc->providerConfigParam(array('token_endpoint'=>'https://auth.k8spre.arriswifi.com/connect/token'));
$oidc->authenticate();
$oidc = $oidc->requestUserInfo();
// var_dump($oidc);

/*Second attempt- Request Client Credentials Token*/
// $oidc->setResponseTypes(array('token'));
// $oidc->addScope(array('openid'));
// $oidc->setAllowImplicitFlow(true);
// $oidc->addAuthParam(array('response_mode' => 'form_post'));
// $oidc->setCertPath('./certificate.crt');
// $oidc->authenticate();
// $sub = $oidc->getVerifiedClaims('sub');
// var_dump($sub);

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

header("Location: ./attributes.php");

?>
