<?php
$index=1;
if($index==1){
	require_once'index.php';


	$aaa=new aaa('WIBIP_AAA','new');
	//$aaa=new createAccount($portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm,$urln,$token);
	//$create=$aaa->createAccount('cus01',$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,'PKG02','Asia/Colombo','123321123321','GMT-06:00');
	$create=$aaa->createAccount('cus01',$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,'NV200MB','0','123321123321','','');
	//$create=$aaa->sessionGet('123456','10.10.10.10');
	parse_str($create);
	echo $status_code;
}
else{
	require_once'index2.php';
	$aaa=new aaa();
	//$aaa->accountGet("tes","test12","1");//accountGet($wsuser, $wspass, $username)
	//$aaa->packageAdd('', '', '', '', '', '', '');//packageGET($wsuser, $wspass, $packageid);
	$aaa->packageGET('', '', '');//packageGET($wsuser, $wspass, $packageid);
}
	
?>