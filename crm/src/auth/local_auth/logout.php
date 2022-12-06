<?php
$user_name = $_SESSION['user_name'];
	//$log_query = "INSERT INTO admin_user_logs (user_name,module,create_date,unixtimestamp) 
	//VALUES ('$user_name','Logout',now(),UNIX_TIMESTAMP())";
	//$query_ex_log=mysql_query($log_query);

  $db->userLog($user_name,'logout','Logout','N/A','N/A');

	$redirect_url = $global_base_url; //"index".$extension; 
	//header( "Refresh:0; url=$redirect_url", true, 303);

	
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['user_name'] = NULL;
  $_SESSION['access_role'] = NULL;
  $_SESSION['login'] = NULL;
  $_SESSION['full_name'] = NULL;
  $_SESSION['default_key'] = NULL;
  
  $_SESSION['s_detail'] = NULL;
  $_SESSION['s_token'] = NULL;  
  
  unset($_SESSION['user_name']);
  unset($_SESSION['access_role']);
  unset($_SESSION['login']);
  unset($_SESSION['full_name']);
  unset($_SESSION['default_key']);
  
  unset($_SESSION['s_detail']);
  unset($_SESSION['s_token']);
  unset($_SESSION['full_name_old']);
  unset($_SESSION['remote']);
  unset($_SESSION['ori_user_uname']);
  unset($_SESSION['user_distributor']);

  unset($_SESSION['SADMIN']);
	setcookie('timeout', '', 0, '/'); 
	session_write_close();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);
?>