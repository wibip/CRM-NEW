<?php

header("Cache-Control: no-cache, must-revalidate");

session_start();


/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();

require_once '../classes/systemPackageClass.php';
$package_functions=new package_functions();

$login = $_GET['login'];

$login = htmlentities( urldecode($login), ENT_QUOTES, 'utf-8' );
$list_of_packages = $package_functions->getOptions('LOGIN_RESTRICTION', $login);

if($_GET['type']=='property'){

    $usernames = array();

        if(isset($_GET['email'])) {

            $email=$_GET['email'];
            $email = htmlentities( urldecode($email), ENT_QUOTES, 'utf-8' );

            $q = sprintf("SELECT u.verification_number,u.user_name, u.user_distributor,m.system_package 
            FROM admin_users u, `exp_mno_distributor` m 
            WHERE m.distributor_code = u.user_distributor and 
            u.verification_number = '%s' AND u.user_type IN ('MVNO') AND u.is_enable=1", $email);

            $r = $db->selectDB($q);

            //$usernames = array();
            foreach ($r['data'] as $row) {
                
                $sys_pcg = $row['system_package'];
                $username = $row['user_name'];
                if (!empty($username)) {
                if ($list_of_packages=='ALL') {
                    array_push($usernames,$username);
                }
                elseif(in_array($sys_pcg,explode(',',$list_of_packages))){
                    array_push($usernames,$username);
                }
            }
            }

            $q1 = sprintf("SELECT u.verification_number,u.user_name, u.user_distributor,m.system_package 
            FROM admin_users u, `exp_mno_distributor` m 
            WHERE m.distributor_code = u.user_distributor and 
            m.property_id = '%s' AND u.user_type IN ('MVNO') AND u.is_enable=1", $email);

            $r1 = $db->selectDB($q1);

            //$usernames = array();
            foreach ($r1['data'] as $row1) {
                $sys_pcg = $row1['system_package'];
                $username = $row1['user_name'];
                if (!empty($username)) {
                if ($list_of_packages=='ALL') {
                array_push($usernames,$username);
                }
                elseif(in_array($sys_pcg,explode(',',$list_of_packages))){
              array_push($usernames,$username);
                }
            }
            }
            
            
            $q2 = sprintf("SELECT u.verification_number,u.user_name, u.user_distributor,m.system_package 
            FROM admin_users u, `mno_distributor_parent` m 
            WHERE m.parent_id = u.user_distributor and 
            u.user_distributor = '%s' AND u.user_type IN ('MVNO_ADMIN') AND u.is_enable=1", $email);

            $r2 = $db->selectDB($q2);

            //$usernames = array();
            foreach ($r2['data'] as $row2) {
                
                $sys_pcg2 = $row2['system_package'];
                $username2 = $row2['user_name'];
                if (!empty($username2)) {
                if ($list_of_packages=='ALL') {
                array_push($usernames,$username2);
                }
                elseif(in_array($sys_pcg2,explode(',',$list_of_packages))){
              array_push($usernames,$username2);
                }
            }
            }


        }
        $usernames = array_unique($usernames);
        echo implode(',',$usernames);

}
else{
    if(isset($_GET['MVNOemail'])) {
        $usernames = array();
        if(isset($_GET['email'])) {

            $email=$_GET['email'];
            $email = htmlentities( urldecode($email), ENT_QUOTES, 'utf-8' );

            $q = sprintf("SELECT u.verification_number, u.user_distributor,m.system_package 
			FROM admin_users u, `exp_mno_distributor` m 
			WHERE m.distributor_code = u.user_distributor and 
			u.email = '%s' AND u.user_type IN ('MVNO') AND u.is_enable=1",$email);

            $r = $db->selectDB($q);

            //$usernames = array();
            foreach ($r['data'] as $row) {
				
				$sys_pcg = $row['system_package'];
                $username = $row['verification_number'];
                if (!empty($username)) {
				if ($list_of_packages=='ALL') {
                    array_push($usernames,$username);
                }
                elseif(in_array($sys_pcg,explode(',',$list_of_packages))){
                    array_push($usernames,$username);
				}
            }
            }
			
			
			
			$q2 = sprintf("SELECT u.user_distributor AS verification_number, u.user_distributor,m.system_package 
			FROM admin_users u, `mno_distributor_parent` m 
			WHERE u.email = '%s' AND u.user_type IN ('MVNO_ADMIN') AND u.is_enable=1",$email);

            $r2 = $db->selectDB($q2);
var_dump($r2);
            //$usernames = array();
            foreach ($r2['data'] as $row2) {
				
				$sys_pcg2 = $row2['system_package'];
                $username2 = $row2['verification_number'];
                if (!empty($username2)) {
                
				if ($list_of_packages=='ALL') {
                    array_push($usernames,$username2);
                }
                elseif(in_array($sys_pcg2,explode(',',$list_of_packages))){
                    array_push($usernames,$username2);
				}
            }
            }


        }
        $usernames = array_unique($usernames);
        echo implode(',',$usernames);

    }
}

?>