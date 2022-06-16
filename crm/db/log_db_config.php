<?php

$conf = array(
    "drive"=>"mysql8",
    "host"=>"10.1.6.24",
    "db"=>"bi_opt_logs",
    "db_user"=>"log_user",
    "db_password"=>"arrisportal",
    "db_port"=>3600
);

$conf_j = json_encode($conf);
define('_LOG_DB_CONFIG_',$conf_j);