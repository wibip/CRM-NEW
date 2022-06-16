<?php

interface DB{
    public function num_rows($qry);
    public function get_row($qry);
    public function get_row_array($qry);
    public function executeQuery($qry);
    public function query($qry);
    public function escape_string($query);
    public function get($table);
    public function select($table);
    public function insert($table,$data);
    public function where($field);
    public function update($table,$info);
    public function delete($table);
}