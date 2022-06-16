<?php
interface driverInterface{
    public static function getConnection(DriverConfig $driverConfig);
    public function query($query);
    public function escapeString($string);
    public function insert($query);
}