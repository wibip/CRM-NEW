<?php

require_once dirname(__FILE__).'/logObject.php';

class auth_logs implements logObject
{

	private $id;
	private $function;
	private $function_name;
	private $description;
	private $api_method;
	private $api_status;
	private $realm;
	private $api_description;
	private $api_data;
	private $create_date;
	private $create_user;
	private $last_update;
	private $unixtimestamp;

    /**
     * auth_logs constructor.
     * @param $id
     * @param $function
     * @param $function_name
     * @param $description
     * @param $api_method
     * @param $api_status
     * @param $realm
     * @param $api_description
     * @param $api_data
     * @param $create_date
     * @param $create_user
     * @param $last_update
     * @param $unixtimestamp
     */
    public function __construct($id, $function, $function_name, $description, $api_method, $api_status, $realm, $api_description, $api_data, $create_date, $create_user, $last_update, $unixtimestamp)
    {
        $this->id = $id;
        $this->function = $function;
        $this->function_name = $function_name;
        $this->description = $description;
        $this->api_method = $api_method;
        $this->api_status = $api_status;
        $this->realm = $realm;
        $this->api_description = $api_description;
        $this->api_data = $api_data;
        $this->create_date = $create_date;
        $this->create_user = $create_user;
        $this->last_update = $last_update;
        $this->unixtimestamp = $unixtimestamp;
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
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param mixed $function
     */
    public function setFunction($function)
    {
        $this->function = $function;
    }

    /**
     * @return mixed
     */
    public function getFunctionName()
    {
        return $this->function_name;
    }

    /**
     * @param mixed $function_name
     */
    public function setFunctionName($function_name)
    {
        $this->function_name = $function_name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getApiMethod()
    {
        return $this->api_method;
    }

    /**
     * @param mixed $api_method
     */
    public function setApiMethod($api_method)
    {
        $this->api_method = $api_method;
    }

    /**
     * @return mixed
     */
    public function getApiStatus()
    {
        return $this->api_status;
    }

    /**
     * @param mixed $api_status
     */
    public function setApiStatus($api_status)
    {
        $this->api_status = $api_status;
    }

    /**
     * @return mixed
     */
    public function getRealm()
    {
        return $this->realm;
    }

    /**
     * @param mixed $realm
     */
    public function setRealm($realm)
    {
        $this->realm = $realm;
    }

    /**
     * @return mixed
     */
    public function getApiDescription()
    {
        return $this->api_description;
    }

    /**
     * @param mixed $api_description
     */
    public function setApiDescription($api_description)
    {
        $this->api_description = $api_description;
    }

    /**
     * @return mixed
     */
    public function getApiData()
    {
        return $this->api_data;
    }

    /**
     * @param mixed $api_data
     */
    public function setApiData($api_data)
    {
        $this->api_data = $api_data;
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

    /**
     * @return mixed
     */
    public function getUnixtimestamp()
    {
        return $this->unixtimestamp;
    }

    /**
     * @param mixed $unixtimestamp
     */
    public function setUnixtimestamp($unixtimestamp)
    {
        $this->unixtimestamp = $unixtimestamp;
    }
	
	

}

