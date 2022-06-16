<?php

require_once dirname(__FILE__).'/baseEntity.php';

class service_activation_details extends baseEntity
{
	 

	private $id;
	private $service_id;
	private $activation_type;
	private $distributor;
	private $distributor_type;
	private $reference;
	private $create_date;
	private $create_user;
	private $last_update;
	private $unixtimestamp;

    /**
     * service_activation_details constructor.
     * @param $id
     * @param $service_id
     * @param $activation_type
     * @param $distributor
     * @param $distributor_type
     * @param $reference
     * @param $create_date
     * @param $create_user
     * @param $last_update
     * @param $unixtimestamp
     */
    public function __construct($id, $service_id, $activation_type, $distributor, $distributor_type, $reference, $create_date, $create_user, $last_update, $unixtimestamp)
    {
        $this->id = $id;
        $this->service_id = $service_id;
        $this->activation_type = $activation_type;
        $this->distributor = $distributor;
        $this->distributor_type = $distributor_type;
        $this->reference = $reference;
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
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * @param mixed $service_id
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;
    }

    /**
     * @return mixed
     */
    public function getActivationType()
    {
        return $this->activation_type;
    }

    /**
     * @param mixed $activation_type
     */
    public function setActivationType($activation_type)
    {
        $this->activation_type = $activation_type;
    }

    /**
     * @return mixed
     */
    public function getDistributor()
    {
        return $this->distributor;
    }

    /**
     * @param mixed $distributor
     */
    public function setDistributor($distributor)
    {
        $this->distributor = $distributor;
    }

    /**
     * @return mixed
     */
    public function getDistributorType()
    {
        return $this->distributor_type;
    }

    /**
     * @param mixed $distributor_type
     */
    public function setDistributorType($distributor_type)
    {
        $this->distributor_type = $distributor_type;
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

