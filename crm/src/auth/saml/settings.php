<?php

include_once 'classes/systemPackageClass.php';
include_once 'classes/dbClass.php';
include_once '../../../classes/systemPackageClass.php';
include_once '../../../classes/dbClass.php';


$package_function=new package_functions();
$db = new db_functions();

$extension = $db->setVal("extentions","ADMIN");
$global_base_url = trim($db->setVal('global_url','ADMIN'),"/");



$login = $_GET['login'];

	$auth_profile_config = $package_function->getOptions("AUTH_PROFILE_CONFIG", $login);
	$query = "SELECT * from exp_auth_profile WHERE profile_name = '$auth_profile_config'";
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			$entityId = $row[reference1];
			$singleSignOnServiceurl = $row[reference2];
			$singleLogoutServiceurl = $row[reference3];
			$entity_id = $row[reference5];
			$x509cert = $row[reference4];
		}
	
    //$spBaseUrl = 'https://<your_domain>'; //or http://<your_domain>
	$spBaseUrl = $global_base_url; //'http://216.234.148.168/campaign_portal_demo'; //or http://<your_domain>

    $settingsInfo = array (
        'sp' => array (
            'entityId' => $entity_id, //$spBaseUrl.'/src/auth/saml/metadata.php?login='.$login,
            'assertionConsumerService' => array (
                'url' => $spBaseUrl.'/'.$login.'/login?acs',
            ),
            'singleLogoutService' => array (
                'url' => $spBaseUrl.'/logout?doLogout=true&amp;login='.$login,
            ),
            'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:entity',
        ),
        'idp' => array (
            'entityId' => $entityId,
            'singleSignOnService' => array (
                'url' => $singleSignOnServiceurl,
            ),
            'singleLogoutService' => array (
                'url' => $singleLogoutServiceurl,
            ),
            'x509cert' => $x509cert,
        ),
    );
