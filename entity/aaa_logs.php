<?php

require_once dirname(__FILE__).'/logObject.php';

class aaa_logs implements logObject
{

	static $type='aaa';
	

	private $id;
	private $function;
	private $function_name;
	private $description;
	private $api_method;
	private $group_id;
	private $mac_id;
	private $username;
	private $api_status;
	private $api_description;
	private $api_data;
	private $create_date;
	private $create_user;
	private $last_update;
	private $unixtimestamp;
	private $ale_username;
	
	public function __construct($id=null,$function=null,$function_name=null,$description=null,$group_id=null,$mac_id=null,$username=null,$api_method=null,$api_status=null,$api_description=null,$api_data=null,$create_date=null,$create_user=null,$last_update=null,$unixtimestamp=null,$ale_username=null)
	{
		

	$this->id = $id;
	$this->function = $function;
	$this->function_name = $function_name;
	$this->description = $description;
	$this->api_method = $api_method;
	$this->group_id = $group_id;
	$this->mac_id = $mac_id;
	$this->username = $username;
	$this->api_status = $api_status;
	$this->api_description = $api_description;
	$this->api_data = $api_data;
	$this->create_date = $create_date;
	$this->create_user = $create_user;
	$this->last_update = $last_update;
	$this->unixtimestamp = $unixtimestamp;
	$this->ale_username = $ale_username;
	
	}
	
		/* ---- ID ----- */
	public function getId(){
		return $this->id;
		}

	public function setId($id){
		$this->id = $id;
		}
	
		/* ---- Function ----- */
	public function getFunction(){
		return $this->function;
		}

	public function setFunction($function){
		$this->function = $function;
		}

		/* ---- Function name ----- */
	public function getFunctionName(){
		return $this->function_name;
		}

	public function setFunctionName($function_name){
		$this->function_name = $function_name;
		}

		/* ---- Description ----- */
	public function getDescription(){
		return $this->description;
		}

	public function setDescription($description){
		$this->description = $description;
		}

		/* ---- api method ----- */
	public function getApiMethod(){
		return $this->api_method;
		}

	public function setApiMethod($api_method){
		$this->api_method = $api_method;
		}

		/* ---- group id ----- */
	public function getgroupid(){
		return $this->group_id;
		}

	public function setgroupid($group_id){
		$this->group_id = $group_id;
		}

	/* ---- group id ----- */
	public function getMacid(){
		return $this->mac_id;
		}

	public function setMacid($mac_id){
		$this->mac_id = $mac_id;
		}

		/* ---- username ----- */
	public function getUsername(){
		return $this->username;
		}

	public function setUsername($username){
		$this->username = $username;
		}


		/* ---- api status ----- */
	public function getApiStatus(){
		return $this->api_status;
		}

	public function setApiStatus($api_status){
		$this->api_status = $api_status;
		}


		/* ---- api description ----- */
	public function getApiDescription(){
		return $this->api_description;
		}

	public function setApiDescription($api_description){
		$this->api_description = $api_description;
		}

		/* ---- api data ----- */
	public function getApiData(){
		return $this->api_data;
		}

	public function setApiData($api_data){
		$this->api_data = $api_data;
		}

		/* ---- create date ----- */
	public function getCreateDate(){
		return $this->create_date;
		}

	public function setCreateDate($create_date){
		$this->create_date = $create_date;
		}

			/* ---- Create User ----- */
	public function getCreateUser(){
		return $this->create_user;
		}

	public function setCreateUser($create_user){
		$this->create_user = $create_user;
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
		/* ---- Unixtimestamp ----- */
	public function getAleusername(){
		return $this->ale_username;
		}

	public function setAleusername($ale_username){
		$this->ale_username = $ale_username;
		}

}

