<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
class ModuleFunction{
    public static function filter($module_id,$reference){

        switch ($module_id){
            case 'create_property':{
                return $reference['create_location_on']==1;
                break;
            }
            case 'assign_location_admin':{
                return $reference['assign_location_admin']==1;
                break;
            }
            case 'edit_parent':{
                return $reference['edit_parent_on']==1;
                break;
            }
            case 'config_splash_page':{
                return isset($_SESSION['s_token']);
                break;
            }
            case 'guest_passcode':{
                return $reference['auth_passcode']==1;
                break;
            }
            default:{
                return true;
            }
        }
    }

    //private static function
    private static function getDB(){
        require_once __DIR__.'/../db/dbTasks.php';
        return new dbTasks();
    }
}