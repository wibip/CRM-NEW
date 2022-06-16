<?php 

class Mysqli
{

    private $link = null;
    public $filter;
    static $inst = null;
    public static $counter = 0;



    public function __construct()
    {
        mb_internal_encoding( 'UTF-8' );
        mb_regex_encoding( 'UTF-8' );
        mysqli_report( MYSQLI_REPORT_STRICT );
        try {
            $this->link = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
            $this->link->set_charset( "utf8" );
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



}
?>