
<?php

require_once __DIR__.'/dbClass.php';
class OperatorClass{
    private $db;
	public function  __construct(){
		$this->db = new db_functions();
	}
    public function getOperators(){
        $query_results = null;
        try {
            $key_query = "SELECT m.mno_description,m.mno_id, m.features,m.is_enable,u.full_name, u.email, u.mobile , u.verification_number
                            FROM exp_mno m, admin_users u
                            WHERE u.group = 'operation' AND u.user_distributor = m.mno_id AND u.`access_role`='operation'
                            GROUP BY m.mno_id
                            ORDER BY mno_description";
            $query_results = $this->db->selectDB($key_query);
        } catch (Exception $e) {
            $query_results = null;
        }

        return $query_results;
    }


}