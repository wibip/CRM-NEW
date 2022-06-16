<?php

require_once dirname(__FILE__).'/logObject.php';

class user_logs implements logObject
{

	

	private $id;
	private $user_name;
	private $module;
	private $module_id;
	private $task;
	private $reference;
	private $ip;
	private $user_distributor;
	private $create_date;
	private $unixtimestamp;
	private $last_update;
	
	public function __construct($id = null ,$user_name = null ,$module = null ,$module_id = null ,$task = null ,$reference = null ,$ip = null ,$user_distributor = null  ,$create_date = null ,$unixtimestamp = null ,$last_update = null)
	{
		
	$this->id = $id;	
	$this->user_name = $user_name;
	$this->module = $module;
	$this->module_id = $module_id;
	$this->task = $task;
	$this->reference = $reference;
	$this->ip = $ip;
	$this->user_distributor = $user_distributor;
	$this->create_date = $create_date;
	$this->last_update = $last_update;
	$this->unixtimestamp = $unixtimestamp;
	
	}
	
		/* ---- ID ----- */
	public function getId(){
		return $this->id;
		}

	public function setId($id){
		$this->id = $id;
		}
	
		/* ---- User name ----- */
	public function getUsername(){
		return $this->user_name;
		}

	public function setUsername($user_name){
		$this->user_name = $user_name;
		}

		/* ---- Module ----- */
	public function getModule(){
		return $this->module;
		}

	public function setModule($module){
		$this->module = $module;
		}

		/* ---- Module Id ----- */
	public function getModuleId(){
		return $this->module_id;
		}

	public function setModuleId($module_id){
		$this->module_id = $module_id;
		}

		/* ---- Task ----- */
	public function getTask(){
		return $this->task;
		}

	public function setTask($task){
		$this->task = $task;
		}

		
		/* ---- Reference ----- */
	public function getReference(){
		return $this->reference;
		}

	public function setReference($reference){
		$this->reference = $reference;
		}

		/* ---- IP ----- */
	public function getIP(){
		return $this->ip;
		}

	public function setIP($ip){
		$this->ip = $ip;
		}

		/* ---- User Distributor ----- */
	public function getUserDistributor(){
		return $this->user_distributor;
		}

	public function setUserDistributor($user_distributor){
		$this->user_distributor = $user_distributor;
		}


		/* ---- create date ----- */
	public function getCreateDate(){
		return $this->create_date;
		}

	public function setCreateDate($create_date){
		$this->create_date = $create_date;
		}

		/* ---- last update ----- */
	public function getLastUpdate(){
		return $this->last_update;
		}

	public function setLastUpdate($last_update){
		$this->last_update = $last_update;
		}

		/* ---- Unixtimestamp ----- */
	public function getUnixtimestamp(){
		return $this->unixtimestamp;
		}

	public function setUnixtimestamp($unixtimestamp){
		$this->unixtimestamp = $unixtimestamp;
		}

}

