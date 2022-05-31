<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL&~E_WARNING&~E_NOTICE);
if (isset($_POST['submit_theme_temp'])) {

	//echo $_SESSION['FORM_SECRET'] ." == ". $_POST['theme_temp_secret'];

	if ($_SESSION['FORM_SECRET'] == $_POST['theme_temp_secret']) {
		$temp_name = $_POST['temp_name'];
		$temp_id = $_POST['uploaded_temp_folder'];
		$old_zip_name = $_POST['old_zip_name'];
		mkdir($base_portal_folder . '/template/' . $temp_id, 0770);

		$temp_up_path = rtrim($db->setVal('captive_theme_up_tmp','ADMIN'),'/').'/';

		copy($temp_up_path . $temp_id . '/' . $old_zip_name, $base_portal_folder . '/template/' . $temp_id . '/' . $old_zip_name);

		if (copy($temp_up_path . $temp_id . '/' . $temp_id . '.zip', $base_portal_folder . '/template/' . $temp_id . '/' . $temp_id . '.zip')) {
			$zip2 = new ZipArchive;
			if ($zip2->open($base_portal_folder . '/template/' . $temp_id . '/' . $temp_id . '.zip')) {
				$n2 = $zip2->getNameIndex(0);
				$mainTemplateContents = $zip2->getFromName('Main.Template.html');
				preg_match('/<org_template>(.*?)<\/org_template>/', $mainTemplateContents, $match);
				$org_template = $match[1];
				$zip2->extractTo($base_portal_folder . '/template/' . $temp_id);
				$zip2->close();
			} else {
				$_SESSION['template_upload'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('upload_template_fail', '2004') . "</strong></div>";
			}
		} else {
			$_SESSION['template_upload'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('upload_template_fail', '2004') . "</strong></div>";
		}

		if ((strlen($temp_name) > 0) && (strlen($temp_id) > 0)) {

			$query_temp = "INSERT INTO `exp_template` (`id`, `template_id`, `name`, `is_enable`, `image_up_type`, `logo_details`, `hide_divs`, `create_date`, `options`, `cash_clear`, `default_theme`,`last_update`, `updated_by`) VALUES (NULL, '$temp_id', '$temp_name', '1', '{\"upload1\":\"1\",\"upload2\":\"0\",\"verticle\":\"1\",\"horizontal\":\"0\"}', '{\"upload1_name\":\"Logo\",\"upload1_desc\":\"(GIF, JPEG or PNG, Recommended 160px*60px)\",\"upload2_name\":\"Logo\",\"upload2_desc\":\"(GIF, JPEG or PNG, Recommended 130px*60px)\"}', 'mregbtn,step5,limg,wback,footera,backcolor,ios,ios2,social', NOW(), NULL, '[\"Main\",\"Click\",\"Pass\"]', '$temp_id' ,NOW(), '$user_name')";

			$query_temp_upload = "INSERT INTO `exp_template_upload` (`template_id`, `name`, `user_distributor`, `create_date`, `create_user`, `last_update`) VALUES ('$temp_id', '$temp_name', '$user_distributor', now(), '$user_name', now())";

			$ex_query_temp = $db->execDB($query_temp);
			$ex_query_temp_up = $db->execDB($query_temp_upload);

			if ($ex_query_temp === true && $ex_query_temp_up === true) {
				$err = 0;
				$activeTemplates = $package_functions->getOptions("TEMPLATE_ACTIVE", $system_package);
				$activeTemplates .= ',' . $temp_id;
				$activeTemplates = ltrim($activeTemplates, ',');
				$q = "REPLACE INTO `admin_product_controls` (`id`, `product_code`, `discription`, `feature_code`, `type`, `source`, `user_type`, `access_method`, `options`, `create_user`, `create_date`) VALUES (NULL, '$system_package', 'Templates assign', 'TEMPLATE_ACTIVE', 'option', 'Template', 'MVNO', '1', '$activeTemplates', 'system', NOW())";
				$qr = $db->execDB($q);

				if ($qr !== true) {
					$err = 1;

				}else{
                    $activeRegTypes = $package_functions->getOptions("THEME_REG_TYPE", $system_package);
                    $activeRegTypesArr = explode(',', $activeRegTypes);

                    $data_arr = json_decode($_POST['content'], true);
                    $img_content_arr = json_decode($_POST['img_content'], true);

                    foreach ($activeRegTypesArr as $value) {

                        if ($value == 'AUTH_DISTRIBUTOR_PASSCODE') {
                            $template_id_type = $temp_id . '_pas';
                            $org_template_type = $org_template . '_pas';
                        } else {
                            $template_id_type = $temp_id . '_' . $value;
                            $org_template_type = $org_template . '_' . $value;
                        }

                        if(strlen($org_template)<1){
                            $org_template_type = 'uploaded_theme';
                        }

                        $res = createTemplateInitTheme($temp_id, $template_name, $template_id_type,$org_template_type,$data_arr,$img_content_arr,$db);

                        if (!$res) {
                            $err = 1;
                            break;
                        }
                    }
                }

				if ($err == 0) {
					copy($temp_up_path . $temp_id . '/' . $temp_id . '.zip', 'export/template/' . $temp_id . '.zip');
					rmrf($temp_up_path . $temp_id);
					$_SESSION['template_upload'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('upload_template_success', '2000') . "</strong></div>";
				} else {
					rmrf($temp_up_path . $temp_id);
					$_SESSION['template_upload'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('upload_template_fail', '2004') . "</strong></div>";
				}
			} else {
				//echo "1";
				$_SESSION['template_upload'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('upload_template_fail', '2004') . "</strong></div>";
			}
		} else {
			//echo "1";
			$_SESSION['template_upload'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('upload_template_fail', '2004') . "</strong></div>";
		}
		/* } */
	} else {
		$_SESSION['template_upload'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transaction_failed', '2004') . "</strong></div>";
	}
}

//uploaded theme delete
if (isset($_GET['delete_template_id'])) {

	$delete_template_id = $_GET['delete_template_id'];


	$query_temp_upload_delete = "DELETE FROM `exp_template_upload` WHERE `template_id` = '$delete_template_id' ";
	$query_temp_delete = "DELETE FROM `exp_template` WHERE `template_id` = '$delete_template_id' ";

	$activeRegTypes = $package_functions->getOptions("THEME_REG_TYPE", $system_package);
	$activeRegTypesArr = explode(',', $activeRegTypes);

	foreach ($activeRegTypesArr as $value) {

		if ($value == 'AUTH_DISTRIBUTOR_PASSCODE') {
			$template_id_type = $delete_template_id . '_pas';
		} else {
			$template_id_type = $delete_template_id . '_' . $value;
		}
		$db->execDB("DELETE FROM `exp_themes_details` WHERE `unique_id` = '$template_id_type' ");
		$db->execDB("DELETE FROM `exp_themes` WHERE `theme_id` = '$template_id_type' ");
	}


	$ex_query_upload_temp = $db->execDB($query_temp_upload_delete);

	$ex_query_temp = $db->execDB($query_temp_delete);


	if ($ex_query_temp === true && $ex_query_upload_temp === true) {

		$path = $base_portal_folder . '/template/';
		$location = __DIR__ . '/' . $path . $delete_template_id;

		rrmdir($location);
		unlink('export/template/' . $delete_template_id . '.zip');

		$_SESSION['template_upload'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('delete_template_success', '2004') . "</strong></div>";
	} else {
		$_SESSION['template_upload'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('delete_template_fail', '2004') . "</strong></div>";
	}
}

function rrmdir($dir)
{
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir . "/" . $object) == "dir") rrmdir($dir . "/" . $object);
				else unlink($dir . "/" . $object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function rmrf($dir)
{
	foreach (glob($dir) as $file) {
		if (is_dir($file)) {
			rmrf("$file/*");
			rmdir($file);
		} else {
			unlink($file);
		}
	}
}

function createTemplateInitTheme($template_id, $template_name, $template_id_type,$org_template_type,$data_arr,$img_content_arr,  db_functions $db)
{
	$query = "INSERT INTO `exp_themes` (
			`theme_id`,
			`theme_name`,
			`theme_type`,
			`splash_url`,
			`template_name`,
			`ref_id`,
			`location_ssid`,
			`distributor`,
			`language`,
			`language_string`,
			`title`,
			`registration_type`,
			`social_login_txt`,
			`manual_login_txt`,
			`welcome_txt`,
			`greeting_txt`,
			`toc_txt`,
			`loading_txt`,
			`welcome_back_txt`,
			`registration_btn`,
			`connect_btn`,
			`fb_btn`,
			`first_name_text`,
			`last_name_text`,
			`male_field`,
			`female_field`,
			`email_field`,
			`age_group_field`,
			`gender_field`,
			`manual_login_fields`,
			 mobile_number_fields,
			 other_fields,
			 extra_fields,
			`login_name_field`,
			`login_secret_field`,
			`accept_text`,
			`cna_page_text`,
			`cna_button_text`,
			`btn_color`,
			`btn_color_disable`,
			`btn_border`,
			`btn_text_color`,
			`bg_color_1`,
			`bg_color_2`,
			`hr_color`,
			`theme_logo`,
			`theme_bg_image`,
			`theme_horizontal_image`,
			`theme_verticle_image`,
			`duotone_bg_color`,
			`duotone_form_color`,
			`theme_details_id`,
			`is_enable`,
			`create_date`,
			`last_update`,
			`updated_by`
		  )
		  SELECT
			'$template_id_type',
			'$template_name',
			`theme_type`,
			`splash_url`,
			'$template_id',
			`ref_id`,
			`location_ssid`,
			`distributor`,
			`language`,
			`language_string`,
			`title`,
			`registration_type`,
			`social_login_txt`,
			`manual_login_txt`,
			`welcome_txt`,
			`greeting_txt`,
			`toc_txt`,
			`loading_txt`,
			`welcome_back_txt`,
			`registration_btn`,
			`connect_btn`,
			`fb_btn`,
			`first_name_text`,
			`last_name_text`,
			`male_field`,
			`female_field`,
			`email_field`,
			`age_group_field`,
			`gender_field`,
			`manual_login_fields`,
			 mobile_number_fields,
			 other_fields,
			 extra_fields,
			`login_name_field`,
			`login_secret_field`,
			`accept_text`,
			`cna_page_text`,
			`cna_button_text`,
			`btn_color`,
			`btn_color_disable`,
			`btn_border`,
			`btn_text_color`,
			`bg_color_1`,
			`bg_color_2`,
			`hr_color`,
			`theme_logo`,
			`theme_bg_image`,
			`theme_horizontal_image`,
			`theme_verticle_image`,
			`duotone_bg_color`,
			`duotone_form_color`,
			'$template_id_type',
			`is_enable`,
			`create_date`,
			`last_update`,
			`updated_by`
		  FROM
			`exp_themes`
		  WHERE
		   `theme_id` ='$org_template_type'";

$query_results1=$db->selectDB("SELECT theme_data
FROM exp_themes_details
WHERE  unique_id='$org_template_type'");


foreach ($query_results1['data'] AS $row) {
	$theme_data0 = json_decode($row['theme_data'],true);
	$theme_data = $theme_data0['contenteditable_arr'];
	$theme_data_img = $theme_data0['upload_arr'];
}

foreach ($data_arr as $key => $value) {
	$new = array();
	$new['element']= $key;
	$new['value']= $value;
	array_push($theme_data,$new);
}

foreach ($img_content_arr as $key => $value) {
	$new = array();
	$new['element']= "[".$value['element']."]";
	$new['type']= 'template_upload';
	$new['value']= $value['img'];
	$new['folder']= $value['folder'];
	array_push($theme_data_img,$new);
}

$theme_data0['contenteditable_arr']= $theme_data;
$theme_data0['upload_arr']= $theme_data_img;
$theme_data0 = json_encode($theme_data0);

$theme_data0 = $db->escapeDB($theme_data0);

	 $query1 = "INSERT INTO exp_themes_details
	  (unique_id, theme_data,completed)
	  VALUES('$template_id_type','$theme_data0',1)";

	$query_results = $db->execDB($query);
	$query_results1 = $db->execDB($query1);

	if ($query_results === true && $query_results1 === true) {
		return true;
	} else {
		return false;
	}
}
