<?php
require_once __DIR__.'/../../DEFAULT_LAYOUT/contents/themeGroupDefault.php';

class themeGroup extends themeGroupDefault {

    public function __construct(Controller $controller,view_default $html)
    {
        parent::__construct($controller);
        $this->HTML=$html;
    }

}