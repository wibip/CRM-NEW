<?php
require_once __DIR__ . '/../db/dbTasks.php';

class SystemPackageOne
{
    private $dbT;
    private static $instance = null;

    private function __construct()
    {
        $this->dbT = new dbTasks();
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new SystemPackageOne();
        }

        return self::$instance;
    }

    public function getPageFeature($page, $package_code)
    {

        if ($package_code == "N/A" || $package_code == "") {
            return '1';
        } else {

            $q1 = "SELECT `options` AS f FROM `admin_product_controls` WHERE 
                   `product_code`='$package_code' AND `feature_code` ='ALLOWED_PAGE'";
var_dump($page);
echo '<br/>'.$q1;
            $page_ar = $this->dbT->getValueAsf($q1);
            $page_re = json_decode($page_ar, true);
var_dump($page_ar);
            if (in_array($page, $page_re)) {
                return '1';
            } else {
                return '0';
            }

        }
    }

    public function getPageName($page, $package_code, $intName)
    {

        $q = "SELECT c.`options` AS name  FROM `admin_product_controls` c
              WHERE c.`product_code`='$package_code' AND c.`type`='page' AND `source`='$page' AND c.`access_method`='1' ";
        $nameArr = $this->dbT->select1DB($q);
        $name = $nameArr['name'];
        if (strlen($name) > 0) {
            return $name;
        } else {
            return $intName;
        }

    }

    public function getSectionType($feature_code, $system_package)
    {

        $q = "SELECT c.`access_method` FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='option'";
        $method = $this->dbT->select1DB($q);
        return $method['access_method'];
    }

    public function getSectionTypeBranding($feature_code, $system_package)
    {
        return "false";
    }

    public function getCaptiveSectionType($feature_code, $system_package)
    {

        $q = "SELECT c.`access_method` FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='captive'";

        $method = $this->dbT->select1DB($q);
        return $method['access_method'];
    }

    public function getOptions($feature_code, $system_package)
    {

        $q = "SELECT c.`options` as a FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='option'";

        $option = $this->dbT->select1DB($q);
        return $option['a'];
    }

    public function getOptionsBranding($feature_code, $system_package)
    {
        return "false";
    }

    public function getMessageOptions($feature_code, $system_package)
    {

        $q = "SELECT c.`options` as a FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='message'";

        $option = $this->dbT->select1DB($q);
        return $option['a'];
    }

    public function gettooltipOptions($feature_code, $system_package, $page_name)
    {

        $q = "SELECT c.`options` as a FROM `admin_product_controls` c
            WHERE c.`product_code`='$system_package'
            AND c.`feature_code`='$feature_code'
            AND c.`type` ='option'";

        $option = $this->dbT->select1DB($q);
        $textarr = json_decode($option['a'], true);
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
        if ($options == 'YES') {
            $q = "SELECT c.`access_method`,c.`options` FROM `admin_product_controls` c
                WHERE c.`product_code`='$system_package'
                AND c.`feature_code`='$feature_code'
                AND c.`type` ='api'";
            return $this->dbT->select1DBArray($q);

        } else {
            $q = "SELECT c.`access_method` FROM `admin_product_controls` c
                WHERE c.`product_code`='$system_package'
                AND c.`feature_code`='$feature_code'
                AND c.`type` ='api'";
            $method = $this->dbT->select1DBArray($q);
            return ($method[0] == '1');

        }
    }

    public function getOptionsAaa($feature_code, $system_package)
    {
        //return "Not Allowed6";
        return $this->getOptions($feature_code, $system_package);

    }
}

