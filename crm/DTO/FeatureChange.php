<?php
class FeatureChange{
    private $service_id;
    private $activation_type;
    private $distributor;
    private $distributor_type;
    private $reference;

    /**
     * FeatureChange constructor.
     * @param $service_id
     * @param $activation_type
     * @param $distributor
     * @param $distributor_type
     * @param $reference
     */
    public function __construct($service_id, $activation_type, $distributor, $distributor_type, $reference)
    {
        $this->service_id = $service_id;
        $this->activation_type = $activation_type;
        $this->distributor = $distributor;
        $this->distributor_type = $distributor_type;
        $this->reference = $reference;
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


}