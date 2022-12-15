<?php
require_once __DIR__.'/../../DEFAULT_LAYOUT/contents/apGroupDefault.php';

class apGroup extends apGroupDefault{

    public function __construct(Controller $controller,view_default $html)
    {
        parent::__construct($controller);
        $this->HTML=$html;
    }



}