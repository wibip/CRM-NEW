<?php
interface ModelInterface{
    public static function getModel();
    public function read(Log $log);
    public function insert(Log $log);
    public function view($id);
}