<?php
session_start();

include_once '../../classes/systemPackageClass.php';
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);

include_once '../../classes/dbClass.php';
$db = new db_functions();

$module_array = array('theme','campaign');

if(!$package_functions->ajaxAccess($module_array,$system_package)){
	http_response_code(401);
	return false;
}
/*
*	!!! THIS IS JUST AN EXAMPLE !!!, PLEASE USE ImageMagick or some other quality image processing libraries
*/
include_once 'functions.php';

	$imagePath = "temp/";
	
// 	$files = glob($imagePath.'*'); // get all file names
// 	foreach($files as $file){ // iterate files
// 		if(is_file($file))
// 			unlink($file); // delete file
// 	}

$replace_arr = array("%", "@", "&", "}", "{", "#", "^");

$_FILES["img"]["name"] = str_replace($replace_arr,'0',$_FILES["img"]["name"]);

if($_FILES["img"]["size"]>(1024*600)){
	$response = Array(
			"status" => 'error',
			"message" => 'Image size is too large. Maximum size allowed is 600Kb'
			);
	print json_encode($response);
	return;
}
	
if (!empty($_FILES["img"]["error"]) )
		{
			 $response = array(
				"status" => 'error',
				"message" => 'Image size is too large. Maximum size allowed is 600Kb',
			);	
			print json_encode($response);
			return;
			
		}

	$allowedExts = array("gif", "jpeg", "jpg", "GIF", "JPEG", "JPG", "PNG", "png");
	//$temp = explode(".", $_FILES["img"]["name"]);
	//$extension = end($temp);
	//$file_mime_type = get_mime_type($_FILES["img"]["tmp_name"]);
	$extension = get_extension($_FILES["img"]["tmp_name"]);
	//exit();
	//Check write Access to Directory

	if(!is_writable($imagePath)){
		$response = Array(
			"status" => 'error',
			"message" => 'Can`t upload File; no write Access'
		);
		print json_encode($response);
		return;
	}
	
	if ( in_array($extension, $allowedExts))
	  {

	      $filename = $_FILES["img"]["tmp_name"];
		  list($width, $height) = getimagesize( $filename );

		  $new_temp_file_name = get_image_temp_name($extension);

		  move_uploaded_file($filename,  $imagePath . $new_temp_file_name);
		  
		  $response = array(
			"status" => 'success',
			"url" => 'plugins/img_upload/'.$imagePath.$new_temp_file_name,
			"width" => $width,
			"height" => $height
		  );
		  
	//	}
	  }
	else
	  {
	   $response = array(
			"status" => 'error',
			"message" => 'Invalid image format. Acceptable formats are: PNG, GIF, JPEG and JPG.',
		);
	  }

//something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini
	  
	  print json_encode($response);

?>
