<?php

require_once dirname(__FILE__).'/logObject.php';

class query_error_logs implements logObject
{

	private $id;
	private $affected_property_id;
	private $owner_user_distributor;
	private $affected_user_distributor;
	private $query_data;
	private $error_description;
	private $task;
	private $type;
	private $create_date;
	private $unixtimestamp;
	private $last_update;
	
	

}

