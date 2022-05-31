<?php
require_once __DIR__.'/../view_default.php';
require_once __DIR__.'/page.php';
class group_default extends page {

    protected $layout_dir;

    protected $tabs = [
        "apGroup"=>[
            "name"=>"AP Groups"
        ],
        "themeGroup"=>[
            "name"=>"Theme Groups"
        ],
    ];

    protected $data=[
        "mainTitle"=>"Manage Theme Groups"
    ];

}