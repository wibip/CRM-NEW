<?php

require_once dirname(__FILE__).'/logObject.php';

class reset_password_log implements logObject
{
	
	
	private $id;
	private $user_name;
	private $pass_changed_by;
	private $create_date;
	private $last_update;
	
}

