<?php

	include_once '../classes/dbClass.php';
    $db = new db_functions();

    $shortname = $_REQUEST['mno_short_name'];
    //$system_package = $_REQUEST['system_package'];
    $previous_short_name = $_REQUEST['previous_short_name'];

    if($shortname != $previous_short_name){

        $q0="SELECT * FROM admin_product_controls WHERE feature_code = 'CAMP_LAYOUT' AND type='option' AND product_code = '$shortname'";

    
        $result = $db->selectDB($q0);
       
        $row_count = $result['rowCount'];

        if($row_count > 0) {
            $isAvailable = false;
        }else{
          
            $isAvailable = true;
                       
        }
    }else{
        $isAvailable = true;
    }
    





    echo json_encode(array(
        'valid' => $isAvailable,
    ));

  ?> 