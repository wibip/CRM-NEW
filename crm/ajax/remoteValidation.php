<?php
include '../classes/dbClass.php';
$db = new db_functions();

if(isset($_GET['type']) || $_GET['type']=='compact_link_unique'){

    if(isset($_GET['edit'])){
        $q = "SELECT id,property_id FROM mdu_organizations WHERE tenant_portal_link='".$db->escapeDB($_GET['activation_link'])."'";
        $num =$db->numRows($q);
        if($num==0){
            echo json_encode(array(
                'valid' => true,
            ));
        }else{
            $data = $db->select1DB($q);
            if($data['property_id']==$_GET['edit']){
                echo json_encode(array(
                    'valid' => true,
                ));
            }else{
                echo json_encode(array(
                    'valid' => false,
                ));
            }
        }

    }
    else{
        $q = "SELECT id FROM mdu_organizations WHERE tenant_portal_link='".$db->escapeDB($_GET['activation_link'])."'";

        $num =$db->numRows($q);
        echo json_encode(array(
            'valid' => $num==0,
        ));
    }

}

else{
    echo json_encode(array(
        'valid' => false,
    ));
}