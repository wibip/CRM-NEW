<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

//This class is responsible for doing all the mysqli related tasks in association with PHP
require_once __DIR__.'/DB.php';


class mysqliDB implements DB
{

    private $link = null;
    public $filter;
    static $inst = null;
    public static $counter = 0;
    public static $prefix = '';
    protected $_join = array();
    protected $_joinAnd = array();



    public function __construct() //Either pass connection parameters here or define them in constatnts.php file
    {
        mb_internal_encoding( 'UTF-8' );
        mb_regex_encoding( 'UTF-8' );
        mysqli_report( MYSQLI_REPORT_STRICT );
        try {
            // echo DB_HOST. DB_USER. DB_PASS. DB_NAME;
            $this->link = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
            $this->link->set_charset( "utf8" );
            // print('Connected to the databse using mysqli_connect()');
            // $a = $this->link->query("SELECT NOW()");
            // var_dump($a);
        } catch ( Exception $e ) {
            die( 'Unable to connect to database using mysqli_connect()' );
        }
    }

    static function getInstance()
    {
        if( self::$inst == null )
        {
            self::$inst = new mysqliDB();
        }
        return self::$inst;
    }

    public function num_rows( $query )
    {
        self::$counter++;
        $num_rows = $this->link->query( $query );
        if( $this->link->error )
        {
            return $this->link->error;
        }
        else
        {
            return $num_rows->num_rows;
        }
    }

    public function get_row( $query, $object = false )
    {
        self::$counter++;
        $row = $this->link->query( $query );
        if( $this->link->error )
        {
            return $this->link->error;
        }
        else
        {
            $r = ( !$object ) ? $row->fetch_assoc() : $row->fetch_object();
            return $r;   
        }
    }

    public function get_row_array( $query, $object = false )
    {
        self::$counter++;
        $row = $this->link->query( $query );
        if( $this->link->error )
        {
            return $this->link->error;
        }
        else
        {
            $r = ( !$object ) ? $row->fetch_array() : $row->fetch_object();
            return $r;   
        }
    }

    public function executeQuery( $query, $object = false ) 
    {
        self::$counter++;
      
        $results =$this->link->query( $query );
        if( $this->link->error )
        {
            return $this->link->error;
        }
        else
        {
            return true;
        }
    }

    public function query( $query, $object = false ) 
    {
        self::$counter++;
        //Overwrite the $row var to null
        $row = null;
        // echo $query = "select NOW()";
        $results = $this->link->query( $query );
        // var_dump($results);
        if( $this->link->error )
        {
            return $this->link->error;
        }
        else
        {
            $row = array();
            while( $r = ( !$object ) ? $results->fetch_assoc() : $results->fetch_object() )
            {
                $row[] = $r;
            }
            return $row;   
        }
    }

    public function queryWithSeekPointer( $query,$pointer, $object = false ) 
    {
        self::$counter++;
        //Overwrite the $row var to null
        $row = null;
        
        $results = $this->link->query( $query );
        $results->data_seek($pointer);
        if( $this->link->error )
        {
            return $this->link->error;
        }
        else
        {
            $row = array();
            while( $r = ( !$object ) ? $results->fetch_assoc() : $results->fetch_object() )
            {
                $row[] = $r;
            }
            return $row;   
        }
    }   

    public function escape_string($query) 
    {
        self::$counter++;
        //Overwrite the $row var to null
        
        $results = $this->link->real_escape_string( $query );
        if( $this->link->error )
        {
            return $this->link->error;
        }
        else
        {
            return $results;   
        }
    }


    public function insert( $table, $variables = array() )
    {
        self::$counter++;
        //Make sure the array isn't empty
        if( empty( $variables ) )
        {
            return false;
        }
        
        $sql = "INSERT INTO ". $table;
        $fields = array();
        $values = array();
        foreach( $variables as $field => $value )
        {
            $fields[] = $field;
            if(is_array($value) && array_key_exists('SQL',$value)){
                $values[] = $value['SQL'];
            }else {
                $values[] = "'".$value."'";
            }
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';
        
        $sql .= $fields .' VALUES '. $values;
        $query = $this->link->query( $sql );

        if( $this->link->error )
        {
            //return false; 
            return $this->link->error;
        }
        else
        {
            return true;
        }
    }

    public function update( $table, $variables = array(), $where = array(), $limit = '' )
    {
        self::$counter++;
        //Make sure the required data is passed before continuing
        //This does not include the $where variable as (though infrequently)
        //queries are designated to update entire tables
        if( empty( $variables ) )
        {
            return false;
        }
        $sql = "UPDATE ". $table ." SET ";
        foreach( $variables as $field => $value )
        {
            
            $updates[] = "`$field` = '$value'";
        }
        $sql .= implode(', ', $updates);
        
        //Add the $where clauses as needed
        if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;
                $clause[] = "$field = '$value'";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);   
        }
        
        if( !empty( $limit ) )
        {
            $sql .= ' LIMIT '. $limit;
        }
        $query = $this->link->query( $sql );
        if( $this->link->error )
        {
            return $this->link->error;
        }
        else
        {
            return true;
        }
    }

    public function delete( $table, $where = array(), $limit = '' )
    {
        self::$counter++;
        //Delete clauses require a where param, otherwise use "truncate"
        if( empty( $where ) )
        {
            return false;
        }
        
        $sql = "DELETE FROM ". $table;
        foreach( $where as $field => $value )
        {
            $value = $value;
            $clause[] = "$field = '$value'";
        }
        $sql .= " WHERE ". implode(' AND ', $clause);
        
        if( !empty( $limit ) )
        {
            $sql .= " LIMIT ". $limit;
        }
            
        $query = $this->link->query( $sql );
        if( $this->link->error )
        {
            //return false;
            return $this->link->error;
        }
        else
        {
            return true;
        }
    }


    public function join($joinTable, $joinCondition, $joinType = '')
    {
        $allowedTypes = array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER', 'NATURAL');
        $joinType = strtoupper(trim($joinType));
        if ($joinType && !in_array($joinType, $allowedTypes)) {
            throw new Exception('Wrong JOIN type: ' . $joinType);
        }
        if (!is_object($joinTable)) {
            $joinTable = self::$prefix . $joinTable;
        }
        $this->_join[] = Array($joinType, $joinTable, $joinCondition);
        return $this;
    }

    public function joinWhere($whereJoin, $whereProp, $whereValue = 'DBNULL', $operator = '=', $cond = 'AND')
    {
        $this->_joinAnd[self::$prefix . $whereJoin][] = Array ($cond, $whereProp, $operator, $whereValue);
        return $this;
    }


    public function get($table)
    {
        // TODO: Implement get() method.
    }

    public function select($table)
    {
        // TODO: Implement select() method.
    }

    public function where($field)
    {
        // TODO: Implement where() method.
    }

    public function setAutoCommit() 
    {
        self::$counter++;
      
        $this->link->autocommit(FALSE);

        return true;

    }

    public function commit() 
    {
        self::$counter++;
      
        $this->link->commit();
        
        return true;
        
    }

    public function rollback() 
    {
        self::$counter++;
      
        $this->link->rollback();
        
        return true;
        
    }

    public function insert_id(){
        return $this->link->insert_id;
    }
}
?>