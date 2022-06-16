<?php

require_once dirname(__FILE__).'/logObject.php';

class access_denied_log implements logObject
{

	private $id;
	private $mac; 
	private $src; 
	private $e_id; 
	private $e_desc;
	private $token;
	private $create_date;
	private $unix_timestamp;
	private $last_update;

    /**
     * access_denied_log constructor.
     * @param $id
     * @param $mac
     * @param $src
     * @param $e_id
     * @param $e_desc
     * @param $token
     * @param $create_date
     * @param $unix_timestamp
     * @param $last_update
     */
    public function __construct($id=null, $mac=null, $src=null, $e_id=null, $e_desc=null, $token=null, $create_date=null, $unix_timestamp=null, $last_update=null)
    {
        $this->id = $id;
        $this->mac = $mac;
        $this->src = $src;
        $this->e_id = $e_id;
        $this->e_desc = $e_desc;
        $this->token = $token;
        $this->create_date = $create_date;
        $this->unix_timestamp = $unix_timestamp;
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
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * @param mixed $mac
     */
    public function setMac($mac)
    {
        $this->mac = $mac;
    }

    /**
     * @return mixed
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param mixed $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * @return mixed
     */
    public function getEId()
    {
        return $this->e_id;
    }

    /**
     * @param mixed $e_id
     */
    public function setEId($e_id)
    {
        $this->e_id = $e_id;
    }

    /**
     * @return mixed
     */
    public function getEDesc()
    {
        return $this->e_desc;
    }

    /**
     * @param mixed $e_desc
     */
    public function setEDesc($e_desc)
    {
        $this->e_desc = $e_desc;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
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
    public function getUnixTimestamp()
    {
        return $this->unix_timestamp;
    }

    /**
     * @param mixed $unix_timestamp
     */
    public function setUnixTimestamp($unix_timestamp)
    {
        $this->unix_timestamp = $unix_timestamp;
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

