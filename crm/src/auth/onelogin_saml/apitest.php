<?php


include 'index.php';

$saml = new auth('SAML_Default');
//$saml = new auth('LOCAL_AUTH');


$jsonData1 = array(
				'firstname'   => 'Lady4',
				'lastname'   => 'GoGo4',
				'email'   => 'lady2@gogo17.com',
				'username'   => 'lady317',
				'password' => 'tsy@gd63gvDfs', 
				'access_role' => 'admin',
				'user_type' => 'ADMIN',
				'loation'  => 'loc1',
				'mobile'   => '515151515',
				'language'  => 'en',
				'account_state'  => '2',
				'created_by' => 'user1',
		);

		   $jsonData = array(
						'lastname'   => 'Gonzales-Jones',
						'state'   => 3,
					);
	

 
   $role_id_array = array("role_id_array"=>array(212717));
 // $jsonData2 = $role_id_array;


$json_pass  = array
	('password' => '{124}',
	 'password_confirmation' => '{124}' ,
					'validate_policy' => false );



$json_pass1 = array
	('password' => 'xxxxx637aead4030a653f29dae62f1542d67484342c00627a65066e05c5f0',
	 'password_confirmation' => 'xxxxx637aead4030a653f29dae62f1542d67484342c00627a65066e05c5f0' ,
	'password_algorithm' => 'salt+sha256',
	'password_salt' => '11xxxx1' );


	
$json_link = array('email' =>'niroshan@wifi.lk');

$jsonLogin = array(
						'username'   => 'admin',
						'password'   => 'ruckus1234!',
					);
   
//$saml->getUser(40144789);	
//$saml->getUser();	
//$id='38679827';
//$saml->addUser($jsonData1);
//$saml->editUser($jsonData1,40144789);
//$saml->removeUser('40067210');
//$saml->getRoles();
//$saml->getRolesforUser(38679827);
//$saml->assignRoles(39965835,$role_id_array);

//$saml->removeRoles(39965835,$role_id_array);
//$saml->setPasswordUC(39965835,$json_pass);
//$saml->setPasswordsha(39965835,$json_pass1);
//$saml->generatelink($json_link);
$saml->serviceTicket($jsonLogin);
echo "<br>";
//$saml->session();
//$saml->rkszones();
$saml->firmware($jsonLogin);
//$saml->aps();

?>