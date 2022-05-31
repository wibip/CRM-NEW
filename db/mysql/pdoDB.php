<?php 

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); */

//This class is responsible for doing all the mysqli related tasks in association with PHP

class pdoDB
{

    private $link = null;
    public $filter;
    static $inst = null;
    public static $counter = 0;



    public function __construct()
    {
        // mb_internal_encoding( 'UTF-8' );
        // mb_regex_encoding( 'UTF-8' );
        // mysqli_report( MYSQLI_REPORT_STRICT );
        try {
            $this->link = new PDO( DB_HOST, DB_USER, DB_PASS, DB_NAME );
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //  print('Connected to the databse using mysqli_connect()');
        } catch ( PDOException  $e ) {
            die( 'Unable to connect to database using pdo_connect()' );
        }
    }

    static function getInstance()
    {
        if( self::$inst == null )
        {
            self::$inst = new pdoDB();
        }
        return self::$inst;
    }

    public function get_results( $query, $object = false )
    {
        self::$counter++;
        //Overwrite the $row var to null
        $row = null;
        
        $results = $this->link->query( $query );
        if( $this->link->error )
        {
            return false;
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



}
?>