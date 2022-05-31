<?php

require_once dirname(__FILE__).'/logObject.php';

class camphaign_logs implements logObject
{

	

	private $id;
	private $ad_id;
	private $token;
	private $customer_id;
	private $create_date;
	private $last_update;
	
	public function __construct($id, $ad_id ,$token ,$customer_id ,$create_date ,$last_update)
	{
		
	$this->id = $id;
	$this->ad_id = $ad_id;
	$this->token = $token;
	$this->customer_id = $customer_id;
	$this->create_date = $create_date;
	$this->last_update = $last_update;
	
	
	}
	
		/* ---- ID ----- */
	public function getId(){
		return $this->id;
		}

	public function setId($id){
		$this->id = $id;
		}
	
		/* ---- ad_id ----- */
	public function getAD_id(){
		return $this->ad_id;
		}

	public function setAD_id($ad_id){
		$this->ad_id = $ad_id;
		}

		/* ---- Token ----- */
	public function getToken(){
		return $this->token;
		}

	public function setToken($token){
		$this->token = $token;
		}

		/* ---- Customer id ----- */
	public function getCustomer_id(){
		return $this->customer_id;
		}

	public function setCustomer_id($customer_id){
		$this->customer_id = $customer_id;
		}

		/* ---- Create Date ----- */
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

}

