<?php 


$globurl = trim($dbT->setVal('global_url','ADMIN'),"/");

	$get_product_id_q="SELECT `options` FROM `admin_product_controls` WHERE `product_code`='$login_design' AND `feature_code`='DEFAULT_PROFILE'";

    $get_product_id=$dbT->select1DB($get_product_id_q);
    //$get_product_id = mysql_fetch_assoc($get_product_id_res);
    $prod_id = $get_product_id['options'];


    $q = "SELECT * FROM `admin_product_controls_custom` WHERE `product_id` = '$prod_id'";
    $query_results=$dbT->selectDB($q);

    $row_count = $query_results['rowCount'];
	
	if($row_count > 0) {	
		//$result = mysql_fetch_array($query_results);

		foreach ($query_results['data'] AS $result) {
			$custom_data = json_decode($result['settings'],true); 
			$favicon_image_url = $custom_data['branding']['FAVICON_IMAGE_URL']['options'];
		}

		
		
	}

 ?>
<link href="<?php echo $globurl; ?>/layout/<?php echo $camp_layout; ?>/css/sign.php?v=18&product_id=<?php echo $login_design; ?>" rel="stylesheet">
<link rel="shortcut icon" href="<?php echo $favicon_image_url; ?>" type="image/x-icon"/>


<!--<link rel="shortcut icon" href="<?php //echo $globurl; ?>/layout/<?php //echo $camp_layout; ?>/img/favicon.ico" type="image/x-icon"/>-->