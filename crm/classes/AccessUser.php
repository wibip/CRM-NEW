<?php

class AccessUser {

    private $group,$level;

    public function __construct($group,$level)
    {
        $this->group = $group;
        $this->level = $level;
    }

    public function getGroup(){
        return $this->group;
    }

    public function getLevel(){
        return $this->level;
    }

    
}