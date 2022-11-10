<?php
require_once __DIR__ . '/../db/dbTasks.php';

class SystemPackageTwo
{
    private static $instance = null;

    private $dbT;

    private static $product_data = [];

    private function __construct()
    {
        $this->dbT = new dbTasks();
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new SystemPackageTwo();
        }

        return self::$instance;
    }

    private function loadData($product){

        if(!key_exists($product,self::$product_data)){
            $q = "SELECT settings,product_name FROM admin_product_controls_custom WHERE product_id='".$product."'";
            $q_data = $this->dbT->select1DB($q);
            $dataarr =json_decode($q_data['settings'],true);
            if ($q_data['product_name'] =='Operator') {
                $default_productn = 'default';
                $dataarr['general']['PRODUCT_TYPE']['access_method'] =$default_productn;
            }elseif ($q_data['product_name'] == 'MVNO') {
                $default_productn = 'default_mvno';
                $dataarr['general']['PRODUCT_TYPE']['access_method'] =$default_productn;
            }elseif ($q_data['product_name'] == 'MVNO Admin'){
                $default_productn = 'default_mvno_admin';
                $dataarr['general']['PRODUCT_TYPE']['access_method'] =$default_productn;
            }
            self::$product_data[$product] = $dataarr;
        }
    }


    public function getPageFeature($page, $package_code)
    {

        if ($package_code == "N/A" || $package_code == "") {
            return '1';
        } else {
            $this->loadData($package_code);
            $page_ar = self::$product_data[$package_code]['general']['ALLOWED_PAGE']['options'];
            
            $default_product = self :: $product_data[$package_code]['general']['PRODUCT_TYPE']['access_method'];
            $this->loadData($default_product);
            $data =self::$product_data[$default_product]['general']['ALLOWED_PAGE']['options'];
            

            if (empty($page_ar)) {
             $page_ar = $data;
            }else{
                //$page_ar = array_merge($data,$page_ar);
            }

            if (in_array($page, $page_ar)) {
                return '1';
            } else {
                return '0';
            }

        }
    }

    public function getPageName($page, $package_code, $intName)
    {
        return $intName;
    }

    public function getSectionType($feature_code, $system_package)
    {
        $this->loadData($system_package);
        $access_method = self::$product_data[$system_package]['general'][$feature_code]['access_method'];
        if (empty($access_method)) {
            $default_product = self :: $product_data[$system_package]['general']['PRODUCT_TYPE']['access_method'];
            $this->loadData($default_product);
            return self::$product_data[$default_product]['general'][$feature_code]['access_method'];
        }else{
            return $access_method;
        }
        //return self::$product_data[$system_package]['general'][$feature_code]['access_method'];

    }

    public function getSectionTypeBranding($feature_code, $system_package)
    {
        $this->loadData($system_package);
        $access_method = self::$product_data[$system_package]['branding'][$feature_code]['access_method'];
        if (empty($access_method)) {
            $default_product = self :: $product_data[$system_package]['general']['PRODUCT_TYPE']['access_method'];
            $this->loadData($default_product);
            return self::$product_data[$default_product]['branding'][$feature_code]['access_method'];
        }else{
            return $access_method;
        }

    }

    public function getCaptiveSectionType($feature_code, $system_package)
    {
        return $this->getSectionType($feature_code,$system_package);
    }

    public function getOptions($feature_code, $system_package)
    {
        $this->loadData($system_package);
        file_put_contents('/var/log/wibip/api.txt',json_encode(self::$product_data[$system_package]['general'][$feature_code]));
        $data = self::$product_data[$system_package]['general'][$feature_code]['options'];
        $default_product = self :: $product_data[$system_package]['general']['PRODUCT_TYPE']['access_method'];
        $this->loadData($default_product);
        $datanew =self::$product_data[$default_product]['general'][$feature_code]['options'];
        
        if (empty($data) || (!is_array($datanew) && !empty($datanew))) {
            $data = $datanew;
             return is_array($data)?json_encode($data):$data;
        }else{
               
            if(is_array($datanew)){
                $data = array_merge($datanew,$data);
            }
            return is_array($data)?json_encode($data):$data;
        }
        
    }

    public function getOptionsBranding($feature_code, $system_package)
    {
        $this->loadData($system_package);
        $data = self::$product_data[$system_package]['branding'][$feature_code]['options'];
        $access_method = self::$product_data[$system_package]['branding'][$feature_code]['options'];
        if (empty($access_method)) {
            $default_product = self :: $product_data[$system_package]['general']['PRODUCT_TYPE']['access_method'];
            $this->loadData($default_product);
            return self::$product_data[$default_product]['branding'][$feature_code]['options'];
        }else{
            return is_array($data)?json_encode($data):$data;
        }//print_r(self::$product_data[$system_package]);
        
    }

    public function getOptionsAaa($feature_code, $system_package)
    {
        $this->loadData($system_package);
        $data = self::$product_data[$system_package]['aaa_configuration'][$feature_code]['options'];
        
        return is_array($data)?json_encode($data):$data;
        
    }


    public function getMessageOptions($feature_code, $system_package)
    {
        return $this->getOptions($feature_code,$system_package);
    }

    public function gettooltipOptions($feature_code, $system_package, $page_name)
    {

        $textarr = json_decode($this->getOptions($feature_code,$system_package), true);
        $page_name = explode('.', $page_name);
        $page_name = $page_name['0'];
        $value = array();


        foreach ($textarr as $key => $value) {

            if ($key == $page_name) {

                $value = json_encode($value);
                return $value;

            }
        }

    }

    public function callApi($feature_code, $system_package, $options = 'NO')
    { // if option YES return options column value
        $this->loadData($system_package);
        if ($options == 'YES') {
             return [
                 "access_method"=>$this->getSectionType($feature_code,$system_package),//self::$product_data[$system_package]['general'][$feature_code]['access_method'],
                 "options"=>$this->getOptions($feature_code,$system_package)
             ];

        } else {
            $method = $this->getSectionType($feature_code,$system_package);
            return ($method == '1');
        }
    }

}

