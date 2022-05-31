<?php

	include_once '../classes/dbClass.php';
    $db = new db_functions();

	$path_q=$db->selectDB("SELECT settings_value FROM exp_settings WHERE settings_code = 'portal_base_folder' AND distributor='ADMIN'");
        foreach($path_q['data'] AS $path_r){
            $base_url = $path_r['settings_value'];
        }

    $image_path = "../".$base_url."/ads/temp";
    $image_to_delete = $_REQUEST["img_id"]; 
    
    
    $file_to_delete = $image_path."/".$image_to_delete;


    if(@unlink($file_to_delete)) {
      return "old image deleted"; 

    }else{
        return "old image deletion faild";
    }

  ?> 