<?php

require_once dirname(__FILE__).'/logObject.php';

class other_logs implements logObject
{
	private $id;
	private $function;
	private $voucher_code;
	private $realm;
	private $api_responce;
	private $api_url;
	private $api_data;
	private $mobile;
	private $user_distributor;
	private $create_date;
	private $account_number;
	private $mno_id;
	private $last_update;
	private $unixtimestamp;
	private $status;

                    
	public function __construct($id=null,$api_url = null ,$api_responce = null ,$api_data = null ,$voucher_code = null ,$mobile = null ,$function = null ,$realm = null ,$mno_id = null,$user_distributor = null  ,$create_date = null ,$unixtimestamp = null,$account_number = null ,$last_update = null,$status = null)
	{
	$this->id = $id;
	$this->function = $function;
	$this->voucher_code = $voucher_code;
	$this->realm = $realm;
	$this->api_responce = $api_responce;
	$this->api_url = $api_url;
	$this->api_data = $api_data;
	$this->mobile = $mobile;
	$this->user_distributor = $user_distributor;
	$this->create_date = $create_date;
	$this->mno_id = $mno_id;
	$this->account_number = $account_number;
	$this->last_update = $last_update;
	$this->unixtimestamp = $unixtimestamp;
	$this->status = $status;
	
	}
		/* ---- ID ----- */
	public function getId(){
		return $this->id;
		}

	public function setId($id){
		$this->id = $id;
		}
	
		/* ---- ID ----- */
	public function getFunction(){
		return $this->function;
		}

	public function setFunction($function){
		$this->function = $function;
		}
	
		/* ---- User name ----- */
	public function getVoucher(){
		return $this->voucher_code;
		}

	public function setVoucher($voucher_code){
		$this->voucher_code = $voucher_code;
		}

		/* ---- Module ----- */
	public function getRealm(){
		return $this->realm;
		}

	public function setRealm($realm){
		$this->realm = $realm;
		}

		/* ---- Module Id ----- */
	public function getApiDescription(){
		return $this->api_responce;
		}

	public function setApiDescription($api_responce){
		$this->api_responce = $api_responce;
		}

		/* ---- Task ----- */
	public function getApiUrl(){
		return $this->api_url;
		}

	public function setApiUrl($api_url){
		$this->api_url = $api_url;
		}

		
		/* ---- Reference ----- */
	public function getApiData(){
		return $this->api_data;
		}

	public function setApiData($api_data){
		$this->api_data = $api_data;
		}

		/* ---- IP ----- */
	public function getMobile(){
		return $this->mobile;
		}

	public function setMobile($mobile){
		$this->mobile = $mobile;
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

	public function getMnoId(){
		return $this->mno_id;
		}

	public function setMnoId($mno_id){
		$this->mno_id = $mno_id;
		}

		/* ---- accountnumber ----- */
	public function getAccountNumbr(){
		return $this->account_number;
		}

	public function setAccountNumbr($account_number){
		$this->account_number = $account_number;
		}

	/* ---- Unixtimestamp ----- */
	public function getUnixtimestamp(){
		return $this->unixtimestamp;
		}

	public function setUnixtimestamp($unixtimestamp){
		$this->unixtimestamp = $unixtimestamp;
		}
	/* ---- Unixtimestamp ----- */
	public function getStatus(){
		return $this->status;
		}

	public function setStatus($status){
		$this->status = $status;
		}

}

