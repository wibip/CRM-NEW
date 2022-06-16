<?php
include_once('index.php');

$arr = array('apserial' => '341602807529',
	'clusterip' => 'vsz-so.arrisi.com',
	'apname' => 'OPT-001',
	'zonename' => 'TestZone'
		 );;
$rnd=new rnd('RND_AUTH_PROFILE','LP_MNO_002');
echo $rnd->CreateAp($arr);
  ?>