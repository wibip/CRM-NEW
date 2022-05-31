<?php

require_once dirname(__FILE__).'/../classes/dbClass.php';
class serviceActivationController{

    private $connection;

    public function __construct()
    {
     $this->connection =   new db_functions();

    }

    public function create_ServiceActivationDetails(service_activation_details $data)
    {
        $service_id = $data ->getServiceId();
        $activation_type = $data ->getActivationType();
        $distributor = $data ->getDistributor();
        $distributor_type = $data ->getDistributorType();
        $reference = $data ->getReference();
        $create_user = $data ->getCreateUser();

         


        $q ="INSERT INTO `exp_service_activation_details`
		(`service_id`,`activation_type`, distributor,`distributor_type`,reference, `create_date`, `create_user`, `last_update`,unixtimestamp)
        VALUES ('$service_id','$activation_type','$distributor', '$distributor_type','$reference', NOW(), '$create_user',NOW(),UNIX_TIMESTAMP())";


        $query_results=$this->connection->execDB($q);
        if($query_results){
            return true;
        }else{
            return false;
        }

    }


}