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

    public function getParents($operator_id,$category_id,$group_value) {
        $sql = "SELECT au.id,au.full_name FROM `crm_user_hierarchy` AS cuh 
                INNER JOIN `admin_users` AS au ON au.id= cuh.user_id
                WHERE cuh.`operator_id`='$operator_id' AND cuh.`category_id`='$category_id' ";
        if($group_value == 'ordering_agent') {
            $sql .= "AND (au.`group` = 'sales_manager' || au.`group` = 'ordering_agent')";
        } else {
            $sql .= "AND au.`group` = 'sales_manager'";
        }
        $sql .= " GROUP BY cuh.user_id";
        // echo $sql;
        $results = $this->db->selectDB($sql);
        return $results;
    }

    public function userHierarchySave($operator_id,$category_id,$user_id,$parent_id,$create_user) {
        $sql = "INSERT INTO crm_user_hierarchy(`operator_id`,`category_id`, `user_id`,`parent_id`,`is_enable`,`create_date`,`create_user`) 
                VALUES ('$operator_id',$category_id,$user_id,$parent_id,1,now(),'$create_user')";
        $results = $this->db->execDB($sql);
        return $results;
    }

    public function getParentDetails($parentId) {
        $parent = null;
        $sql = "SELECT * FROM `crm_user_hierarchy` WHERE `user_id`='$parentId'";
        $results = $this->db->selectDB($sql);
        if($results['rowCount'] > 0) {
            $parent = $results['data'][0];
        }
        return $parent;
    }
}