<?php

$conf = array(
    "drive"=>"mysql",
    "host"=>"localhost",
    "db"=>"bi_opt_logs",
    "db_user"=>"root",
    "db_password"=>"arrisportal",
    "db_port"=>3600
);

/*localhost*/
// $conf = array(
//     "drive"=>"mysql",
//     "host"=>"localhost",
//     "db"=>"crm_live",
//     "db_user"=>"root",
//     "db_password"=>"123456",
//     "db_port"=>3600
// );


$conf_j = json_encode($conf);
define('_LOG_DB_CONFIG_',$conf_j);