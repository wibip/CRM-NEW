<?php
	//include_once("config.php");
	
	
	//Current Page URL
	$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	
	include_once( str_replace('//','/',dirname(__FILE__).'/') .'../db/db_config.php');
	
	
	
	class Connect
	{
			private $host;
  			private $dbUser;
 			private $dbUserPwd;
 			private $dbName;
			private static $instance=null;
			
			

			public static function getConnect()
			{
				if(self::$instance==null)
				{
					self::$instance=new connect();
					
				}
			
				return self::$instance; 
			
			}
		///////////////////////////////////////////////////////////////////////////
	
			
			function __construct()
			{
								
				$this->host=constant('DB_SERVER');
  				$this->dbUser=constant('DB_SERVER_USERNAME');
 				$this->dbUserPwd=constant('DB_SERVER_PASSWORD');
 				$this->dbName=constant('DB_DATABASE');
				
				
			
				$con=mysql_connect($this->host,$this->dbUser,$this->dbUserPwd);  // MAKE THE CONNECTION WITH MYSQL SERVER 
				$selection=mysql_select_db($this->dbName,$con);  // SELECT THE DATA BASE
				
		/* 		if($is_msg_show==true)
					if($con)
						echo "Successfuly connected!";
					else
						echo "Fail to connect".mysql_error(); */
				
								
			}
			
		
		////////////////////////////////////////////////////////////
		
			
			function disconnect()
			{
				mysql_close($con); // CLOSE THE CONNECTION
			}

			
	}
?>