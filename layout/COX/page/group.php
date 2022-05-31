<?php
require_once __DIR__.'/../../DEFAULT_LAYOUT/page/group_default.php';

class group extends group_default{

    /*Don't remove*/
    protected $layout_dir = __DIR__;
    /**************/

    protected $tabs = [
        "apGroup"=>[
            "name"=>"AP Groups"
        ],
        "themeGroup"=>[
            "name"=>__THEME_TEXT__." Groups"
        ],
    ];

    protected $data=[
        "mainTitle"=>"Manage ".__THEME_TEXT__." Groups"
    ];

}