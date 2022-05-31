<?php

require_once dirname(__FILE__).'/logObject.php';

class admin_purge_logs implements logObject
{



	private $id;
	private $log_id; 
	private $log_name;
	private $reference; 
	private $type; 
	private $frequencies; 
	private $date_column; 
	private $last_run; 
	private $last_run_days; 
	private $last_run_user; 
	private $file_name;
	private $error_details; 
	private $is_enable; 
	private $create_date; 
	private $create_user; 
	private $last_update;
	
	
	public function __construct($id ,$log_id, $log_name ,$reference ,$type ,$frequencies ,$date_column ,$last_run ,$last_run_days, $last_run_user ,$file_name ,$error_details ,$is_enable ,$create_date ,$create_user ,$last_update)
	{
		
	$this->id = $id;
	$this->log_id = $log_id;
	$this->log_name = $log_name;
	$this->reference = $reference;
	$this->type = $type;
	$this->frequencies = $frequencies;
	$this->date_column = $date_column;
	$this->last_run = $last_run;
	$this->last_run_days = $last_run_days;
	$this->last_run_user = $last_run_user;
	$this->file_name = $file_name;
	$this->is_enable = $is_enable;
	$this->create_date = $create_date;
	$this->create_user = $create_user;
	$this->last_update = $last_update;
	
	
	}

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogId()
    {
        return $this->log_id;
    }

    /**
     * @param mixed $log_id
     */
    public function setLogId($log_id)
    {
        $this->log_id = $log_id;
    }

    /**
     * @return mixed
     */
    public function getLogName()
    {
        return $this->log_name;
    }

    /**
     * @param mixed $log_name
     */
    public function setLogName($log_name)
    {
        $this->log_name = $log_name;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getFrequencies()
    {
        return $this->frequencies;
    }

    /**
     * @param mixed $frequencies
     */
    public function setFrequencies($frequencies)
    {
        $this->frequencies = $frequencies;
    }

    /**
     * @return mixed
     */
    public function getDateColumn()
    {
        return $this->date_column;
    }

    /**
     * @param mixed $date_column
     */
    public function setDateColumn($date_column)
    {
        $this->date_column = $date_column;
    }

    /**
     * @return mixed
     */
    public function getLastRun()
    {
        return $this->last_run;
    }

    /**
     * @param mixed $last_run
     */
    public function setLastRun($last_run)
    {
        $this->last_run = $last_run;
    }

    /**
     * @return mixed
     */
    public function getLastRunDays()
    {
        return $this->last_run_days;
    }

    /**
     * @param mixed $last_run_days
     */
    public function setLastRunDays($last_run_days)
    {
        $this->last_run_days = $last_run_days;
    }

    /**
     * @return mixed
     */
    public function getLastRunUser()
    {
        return $this->last_run_user;
    }

    /**
     * @param mixed $last_run_user
     */
    public function setLastRunUser($last_run_user)
    {
        $this->last_run_user = $last_run_user;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * @return mixed
     */
    public function getErrorDetails()
    {
        return $this->error_details;
    }

    /**
     * @param mixed $error_details
     */
    public function setErrorDetails($error_details)
    {
        $this->error_details = $error_details;
    }

    /**
     * @return mixed
     */
    public function getisEnable()
    {
        return $this->is_enable;
    }

    /**
     * @param mixed $is_enable
     */
    public function setIsEnable($is_enable)
    {
        $this->is_enable = $is_enable;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param mixed $create_date
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return mixed
     */
    public function getCreateUser()
    {
        return $this->create_user;
    }

    /**
     * @param mixed $create_user
     */
    public function setCreateUser($create_user)
    {
        $this->create_user = $create_user;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param mixed $last_update
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
    }
	
		


}

