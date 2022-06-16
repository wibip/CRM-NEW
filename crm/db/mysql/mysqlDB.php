<?php 
require_once __DIR__.'/DB.php';
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);*/

//This class is responsible for doing all the mysql related tasks in association with PHP

class mysqlDB implements DB
{

	static private $link = null;
	static private $info = array(
		'last_query' => null,
		'num_rows' => null,
		'insert_id' => null
	);
	static private $connection_info = array();

	static private $where;
	static private $limit;
	static private $order;

	function __construct(){//Either pass connection parameters here or define them in constatnts file

		self::$connection_info = array('host' => DB_HOST, 'user' => DB_USER, 'pass' => DB_PASS, 'db' => DB_NAME);
	}

	static function getInstance()
    {
        if( self::$inst == null )
        {
            self::$inst = new mysqlDB();
        }
        return self::$inst;
    } 


	

	static private function connection(){
			if(!is_resource(self::$link) || empty(self::$link)){
				if(($link = mysql_connect(self::$connection_info['host'], self::$connection_info['user'], self::$connection_info['pass'])) && mysql_select_db(self::$connection_info['db'], $link)){
					self::$link = $link;
					mysql_set_charset('utf8');
				}else{
					throw new Exception('Could not connect to MySQL database.');
				}
			}
			return self::$link;
	}

	static private function set($field, $value){
			self::$info[$field] = $value;
	}

	static private function extra(){
		$extra = '';
		if(!empty(self::$where)) $extra .= ' '.self::$where;
		if(!empty(self::$order)) $extra .= ' '.self::$order;
		if(!empty(self::$limit)) $extra .= ' '.self::$limit;
		// cleanup
		self::$where = null;
		self::$order = null;
		self::$limit = null;
		return $extra;
	}

	public function num_rows($qry){ 
		$link =self::connection();
		self::set('last_query', $qry);  
		if(!($result = mysql_query($qry))){
			throw new Exception('Error executing MySQL query: '.$qry.'. MySQL error '.mysql_errno().': '.mysql_error());
		}elseif(is_resource($result)){
			$num_rows = mysql_num_rows($result);
		}else{
			$num_rows = 0;
		}
		mysql_free_result($result);
		return $num_rows;
	}

	public function get_row( $qry)
    {
        $link =self::connection();
		self::set('last_query', $qry);  
		if(!($result = mysql_query($qry))){
			throw new Exception('Error executing MySQL query: '.$qry.'. MySQL error '.mysql_errno().': '.mysql_error());
		}elseif(is_resource($result)){
			$data = mysql_fetch_assoc($result);
		}else{
			$data = false;
		}
		mysql_free_result($result);
		return $data;
    }

    public function get_row_array( $qry )
    {
        $link =self::connection();
		self::set('last_query', $qry);  
		if(!($result = mysql_query($qry))){
			throw new Exception('Error executing MySQL query: '.$qry.'. MySQL error '.mysql_errno().': '.mysql_error());
		}elseif(is_resource($result)){
			$data = mysql_fetch_array($result);
		}else{
			$data = false;
		}
		mysql_free_result($result);
		return $data;
    }

    public function executeQuery( $qry) 
    { 
        $link =self::connection();
      
        self::set('last_query', $qry); 
        if(!($result = mysql_query($qry)))
        {
            return 'Error executing MySQL query: '.$qry.'. MySQL error '.mysql_errno().': '.mysql_error();
        }
        else
        {
            return true;
        }
    }

    public function query($qry){ 
		
		$link =self::connection();
		self::set('last_query', $qry);
		if(!($result = mysql_query($qry))){
			throw new Exception('Error executing MySQL query: '.$qry.'. MySQL error '.mysql_errno().': '.mysql_error());
			$data = false;
		}elseif(is_resource($result)){
			$num_rows = mysql_num_rows($result);
			self::set('num_rows', $num_rows);
			if($num_rows === 0){
				$data = false;
			}else{
				$data = array();
				while($row = mysql_fetch_assoc($result)){
					$data[] = $row;
				}
			}
		}else{
			$data = false;
		}
		mysql_free_result($result);
		return $data;
	}

	public function escape_string($query) 
    {
        $link = self::connection();
        
        $results = mysql_real_escape_string($query);
        
        return $results;   
        
    }

	public function get($table, $select = '*'){
			$link = self::connection();
			if(is_array($select)){
				$cols = '';
				foreach($select as $col){
					$cols .= "`{$col}`,";
				}
				$select = substr($cols, 0, -1);
			}
			$sql = sprintf("SELECT %s FROM %s%s", $select, $table, self::extra());
			self::set('last_query', $sql);
			if(!($result = mysql_query($sql))){
				throw new Exception('Error executing MySQL query: '.$sql.'. MySQL error '.mysql_errno().': '.mysql_error());
				$data = false;
			}elseif(is_resource($result)){
				$num_rows = mysql_num_rows($result);
				self::set('num_rows', $num_rows);
				if($num_rows === 0){
					$data = false;
				}elseif(preg_match('/LIMIT 1/', $sql)){
					$data = mysql_fetch_assoc($result);
				}else{
					$data = array();
					while($row = mysql_fetch_assoc($result)){
						$data[] = $row;
					}
				}
			}else{
				$data = false;
			}
			mysql_free_result($result);
			return $data;
	}

	public function select($table,$column='*',array $conditions=[]){
        $link = self::connection();
        if(is_array($column)){
            $cols = '';
            foreach($column as $col){
                $cols .= "`{$col}`,";
            }
            $column = substr($cols, 0, -1);
        }

        if(count($conditions)>0){
            $wheres =' WHERE ';
            //[["AND","era",'=','ad']]
            $count = 0;
            foreach ($conditions as $condVal){
                if($count==0){
                    $wheres .= sprintf(" `%s`%s'%s' ", $condVal[1],$condVal[2], $this->escape_string($condVal[3]));
                }else{
                    $wheres .= sprintf("%s `%s`%s'%s' ", $condVal[0],$condVal[1],$condVal[2], $this->escape_string($condVal[3]));
                }

                $count++;
            }
            //$wheres = rtrim($wheres," AND ");
        }else{
            $wheres ='';
        }

        $sql = sprintf("SELECT %s FROM %s%s", $column, $table, $wheres);
        self::set('last_query', $sql);
        if(!($result = mysql_query($sql))){
            throw new Exception('Error executing MySQL query: '.$sql.'. MySQL error '.mysql_errno().': '.mysql_error());
            //$data = false;
        }else if(is_resource($result)){
            $num_rows = mysql_num_rows($result);
            self::set('num_rows', $num_rows);
            if($num_rows === 0){
                $data = false;
            }elseif(preg_match('/LIMIT 1/', $sql)){
                $data = mysql_fetch_assoc($result);
            }else{
                $data = array();
                while($row = mysql_fetch_assoc($result)){
                    $data[] = $row;
                }
            }
        }else{
            $data = false;
        }
        mysql_free_result($result);
        return $data;
    }

	public function insert($table, $data){
		$link = self::connection();
		$fields = '';
		$values = '';
		foreach($data as $col => $value){
			$fields .= sprintf("`%s`,", $col);

			if(is_array($value) && array_key_exists('SQL',$value)){
                $values .=sprintf("%s,", $value['SQL']);
            }else{
			    $values .= sprintf("'%s',", mysql_real_escape_string($value));
			}
		}
		$fields = substr($fields, 0, -1);
		$values = substr($values, 0, -1);
		$sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $fields, $values);
		self::set('last_query', $sql);
		if(!mysql_query($sql)){
			throw new Exception('Error executing MySQL query: '.$sql.'. MySQL error '.mysql_errno().': '.mysql_error());
		}else{
			self::set('insert_id', mysql_insert_id());
			return true;
		}
	}

	static private function __where($info, $type = 'AND'){
		$link = self::connection();
		$where = self::$where;
		foreach($info as $row => $value){
			if(empty($where)){
				$where = sprintf("WHERE `%s`='%s'", $row, mysql_real_escape_string($value));
			}else{
				$where .= sprintf(" %s `%s`='%s'", $type, $row, mysql_real_escape_string($value));
			}
		}
		self::$where = $where;
	}

	public function where($field, $equal = null){
		if(is_array($field)){
			self::__where($field);
		}else{
			self::__where(array($field => $equal));
		}
		return $this;
	}

	public function update($table, $info){
		if(empty(self::$where)){
			throw new Exception("Where is not set. Can't update whole table.");
		}else{
			$link = self::connection();
			$update = '';
			foreach($info as $col => $value){
				$update .= sprintf("`%s`='%s', ", $col, $this->escape_string($value));
			}
			$update = substr($update, 0, -2);
			$sql = sprintf("UPDATE %s SET %s%s", $table, $update, self::extra());
			self::set('last_query', $sql);
			if(!mysql_query($sql)){
				throw new Exception('Error executing MySQL query: '.$sql.'. MySQL error '.mysql_errno().': '.mysql_error());
			}else{
				return true;
			}
		}
	}

	public function delete($table){
		if(empty(self::$where)){
			throw new Exception("Where is not set. Can't delete whole table.");
		}else{
			$link = self::connection();
			$sql = sprintf("DELETE FROM %s%s", $table, self::extra());
			self::set('last_query', $sql);
			if(!mysql_query($sql)){
				throw new Exception('Error executing MySQL query: '.$sql.'. MySQL error '.mysql_errno().': '.mysql_error());
			}else{
				return true;
			}
		}
	}

	public function setAutoCommit() 
    { 
        $link =self::connection();
              
        mysql_query("SET AUTOCOMMIT=0");
        
        mysql_query("START TRANSACTION");
	    
	    return true;

    }

    public function commit() 
    { 
        $link =self::connection();
              
        $result = mysql_query("COMMIT");
        
        return true;
    }

    public function rollback() 
    { 
        $link =self::connection();
             
        $result = mysql_query("ROLLBACK");

        return true;

    }
	public function insert_id(){
        return mysql_insert_id();
    }

}


?>