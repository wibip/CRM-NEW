
<?php
    // $system_package = $_COOKIE["system_package"];
    // echo $system_package;
    if($user_type == 'MNO' || $user_type == 'SUPPORT' || $user_type == 'PROVISIONING'){

        $system_package_new = $system_package;
 
    }elseif($user_type == 'MVNO'){
        $q = "SELECT `mno_id` FROM `exp_mno_distributor` WHERE `distributor_code` = '$user_distributor';";
        $result=$db->select1DB($q);

        //$result = mysql_fetch_array($query_results);

        $mno_id = $result['mno_id'];


        $q2 = "SELECT `system_package` FROM `exp_mno` WHERE `mno_id` = '$mno_id';";
        $result2=$db->select1DB($q2);

        //$result2 = mysql_fetch_array($query_results2);

        $system_package_new = $result2['system_package'];
    }elseif($user_type == 'MVNO_ADMIN'){
        $q = "SELECT `mno_id` FROM `mno_distributor_parent` WHERE `parent_id` = '$user_distributor';";
        $result=$db->select1DB($q);

        //$result = mysql_fetch_array($query_results);

        $mno_id = $result['mno_id'];
        

        $q2 = "SELECT `system_package` FROM `exp_mno` WHERE `mno_id` = '$mno_id';";
        $result2=$db->select1DB($q2);

        //$result2 = mysql_fetch_array($query_results2);

        $system_package_new = $result2['system_package'];
    }


    $q = "SELECT * FROM `admin_product_controls_custom` WHERE `product_id` = '$system_package_new'";
    $result=$db->select1DB($q);

    //$row_count = mysql_num_rows($query_results);

    if($result) {

        //$result = mysql_fetch_array($query_results);

        $custom_data = json_decode($result['settings'],true);  


        $support_number = $custom_data['general']['SUPPORT_NUMBER']['options'];
        $logo_image_url = $custom_data['branding']['LOGO_IMAGE_URL']['options'];
        $favicon_image_url = $custom_data['branding']['FAVICON_IMAGE_URL']['options'];
    }

 


?>

<script type="text/javascript" src="layout/<?php echo $camp_layout; ?>/js/respo.js?v=4"></script>
<link id href="layout/<?php echo $camp_layout; ?>/css/respo.php?v=65&user_type=<?php echo $user_type; ?>&distributor_code=<?php echo $user_distributor; ?>&system_package=<?php echo $system_package; ?>" rel="stylesheet">

<link rel="shortcut icon" href="<?php echo $favicon_image_url; ?>" type="image/x-icon"/>