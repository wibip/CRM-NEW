<?php

require_once dirname(__FILE__).'/logObject.php';

class admin_error_logs implements logObject
{

	private $id;
	private $error_id;
	private $user_name;
	private $error_details;
	private $create_date;
	
	public function __construct($id ,$error_id ,$user_name ,$error_details ,$create_date)
	{
		
	$this->id = $id;
	$this->error_id = $error_id;
	$this->user_name = $user_name;
	$this->error_details = $error_details;
	$this->create_date = $create_date;
	
	
	}
	
		/* ---- ID ----- */
	public function getId(){
		return $this->id;
		}

	public function setId($id){
		$this->id = $id;
		}
	
		/* ---- Error_id ----- */
	public function getError_id(){
		return $this->error_id;
		}

	public function setError_id($error_id){
		$this->error_id = $error_id;
		}

		/* ---- user_name ----- */
	public function getUserName(){
		return $this->user_name;
		}

	public function setUserName($user_name){
		$this->user_name = $user_name;
		}

		/* ---- error_details ----- */
	public function getErrorDetails(){
		return $this->error_details;
		}

	public function setErrorDetails($error_details){
		$this->error_details = $error_details;
		}

		/* ---- Create Date ----- */
	public function getCreateDate(){
		return $this->create_date;
		}

	public function setCreateDate($create_date){
		$this->create_date = $create_date;
		}

}

