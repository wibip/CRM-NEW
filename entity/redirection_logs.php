<?php

require_once dirname(__FILE__).'/logObject.php';

class redirection_logs implements logObject
{

	private $id;
	private $page;
	private $mac;
	private $group_id;
	private $request_url;
	private $referer;
	private $acc_type;
	private $create_date;
	private $unixtimestamp;
	
	public function __construct($id=null ,$page=null ,$mac=null ,$group_id=null ,$request_url=null ,$referer=null ,$acc_type=null ,$create_date=null ,$unixtimestamp=null)
	{
		
	$this->id = $id;
	$this->page = $page;
	$this->mac = $mac;
	$this->group_id = $group_id;
	$this->request_url = $request_url;
	$this->referer = $referer;
	$this->acc_type = $acc_type;
	$this->create_date = $create_date;
	$this->unixtimestamp = $unixtimestamp;
	
	
	}
	
		/* ---- ID ----- */
	public function getId(){
		return $this->id;
		}

	public function setId($id){
		$this->id = $id;
		}
	
		/* ---- Page ----- */
	public function getPage(){
		return $this->page;
		}

	public function setPage($page){
		$this->page = $page;
		}

		/* ---- mac ----- */
	public function getmac(){
		return $this->mac;
		}

	public function setmac($mac){
		$this->mac = $mac;
		}

		/* ---- GroupId ----- */
	public function getGroupId(){
		return $this->group_id;
		}

	public function setGroupId($group_id){
		$this->group_id = $group_id;
		}

		/* ---- Request_url ----- */
	public function getRequest_url(){
		return $this->request_url;
		}

	public function setRequest_url($request_url){
		$this->request_url = $request_url;
		}

		/* ---- Referer ----- */
	public function getReferer(){
		return $this->referer;
		}

	public function setReferer($referer){
		$this->referer = $referer;
		}

		/* ---- AccType ----- */
	public function getAccType(){
		return $this->acc_type;
		}

	public function setAccType($acc_type){
		$this->acc_type = $acc_type;
		}

		/* ---- Create Date ----- */
	public function getCreateDate(){
		return $this->create_date;
		}

	public function setCreateDate($create_date){
		$this->create_date = $create_date;
		}

		/* ---- Unixtimestamp ----- */
	public function getUnixtimestamp(){
		return $this->unixtimestamp;
		}

	public function setUnixtimestamp($unixtimestamp){
		$this->unixtimestamp = $unixtimestamp;
		}


}

