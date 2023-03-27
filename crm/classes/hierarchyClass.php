<?php

require_once __DIR__.'/dbClass.php';
class Hierarchy{
    private $db;
	public function  __construct(){
		$this->db = new db_functions();
	}
    public function getCategories($operator_id) {
        $sql = "SELECT * FROM `crm_user_categories` WHERE `operator_id`='$operator_id'";
        $results = $this->db->selectDB($sql);
        return $results;
    }

    public function getParents($operator_id,$category_id ) {
        $sql = "SELECT au.id,au.full_name FROM `crm_user_hierarchy` AS cuh 
                INNER JOIN `admin_users` AS au ON au.id= cuh.parent_id
                WHERE `operator_id`='$operator_id' AND `category_id`='$category_id'";
        $results = $this->db->selectDB($sql);
        return $results;
    }
}