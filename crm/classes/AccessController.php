<?php
require_once __DIR__.'/Access.php';

class AccessFeature{

    const ACTIONCREATE = 'create';
    const ACTIONEDIT = 'edit';
    const ACTIONDELETE = 'delete';

    private $featureCode;
    private $hasAccess;

    public function __construct($featureCode)
    {
        $this->featureCode = $featureCode;
        $this->setAccess(false);
    }

    public function getFeatureCode(){
        return $this->featureCode;
    }
    
    public function getAccess():bool{
        return $this->hasAccess;
    }

    public function setAccess(bool $access){
        $this->hasAccess = $access;
    }
}

class AccessController {

    private $db;
    private $user;
    private $accessedModule;
    private $accessedUser=[];
    private $globalURL;

    /* Contorlls */
    
    private $controlls = ACCESS;
    /*  */

    public function __construct($db,AccessUser $user){
        $this->db = $db;
        $this->user = $user;
    }

    public function getAccessedUser():array{
        if(empty($this->accessedUser)){
            $this->accessedUser = $this->controlls[$this->user->getGroup()];
        }
        return $this->accessedUser;
    }

    public function moduleAccess($module):bool{

        $module = strtolower($module);

        /* Check if valid user */
        if(!array_key_exists($this->user->getGroup(),$this->controlls)){
            return false;
        }


        if(!array_key_exists($module,$this->getAccessedUser()['modules']))
        {
            return false;
        }

        
        return true;
    }

    public function loadModule($module):void{

        $module = strtolower($module);
        if(!$this->moduleAccess($module)){
            echo 'Permission denied';
            exit();
        }
        $this->accessedModule = $this->accessedUser['modules'][$module];
    }

    /* Check if user have access to feature and action  */
    public function featureAccess(AccessFeature &$feature,$action):AccessFeature{
        if(
            /* Check feature access */
            array_key_exists($feature->getFeatureCode(),$this->accessedModule) 
            && in_array($action,$this->accessedModule[$feature->getFeatureCode()])
            ){
            $feature->setAccess(true);
        }

        return $feature;

    }

    public function loginSuccess(){
        $redirect_url = trim($this->getGlobalUrl(),'/').'/'.$this->getAccessedUser()['home'];
        header( "Location: $redirect_url");	
        exit();
    }

    private function getGlobalUrl(){
        if(is_null($this->globalURL)){
            $this->globalURL = $this->db->setVal('global_url','ADMIN');
        }

        return $this->globalURL;
    }
}