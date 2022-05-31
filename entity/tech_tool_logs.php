<?php

require_once dirname(__FILE__).'/logObject.php';

class tech_tool_logs implements logObject
{
	  


	private $id;
	private $ap_mac;
	private $realm;
	private $ap_function;
	private $action;
	private $reference;
	private $create_date;
	private $create_user;
	private $last_update;
	private $unixtimestamp;
	
	public function __construct($id=null ,$ap_mac=null ,$realm=null ,$ap_function=null ,$action=null ,$reference=null ,$create_date=null ,$create_user=null ,$last_update=null ,$unixtimestamp=null)
	{
		
	$this->id = $id;
	$this->ap_mac = $ap_mac;
	$this->realm = $realm;
	$this->ap_function = $ap_function;
	$this->action = $action;
	$this->reference = $reference;
	$this->create_date = $create_date;
	$this->create_user = $create_user;
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
	
		/* ---- ap mac ----- */
	public function getAP_mac(){
		return $this->ap_mac;
		}

	public function setAP_mac($ap_mac){
		$this->ap_mac = $ap_mac;
		}

		/* ---- Realm ----- */
	public function getRealm(){
		return $this->realm;
		}

	public function setRealm($realm){
		$this->realm = $realm;
		}

		/* ---- AP function ----- */
	public function getAP_function(){
		return $this->ap_function;
		}

	public function setAP_function($ap_function){
		$this->ap_function = $ap_function;
		}

		/* ---- action ----- */
	public function getAction(){
		return $this->action;
		}

	public function setAction($action){
		$this->action = $action;
		}

		/* ---- Reference ----- */
	public function getReference(){
		return $this->reference;
		}

	public function setReference($reference){
		$this->reference = $reference;
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

}

