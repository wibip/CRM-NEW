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
	
	$baseportal=  $_GET['baseportal'];
	$imname=  $_GET['imname'];
	
	$img_h=  $_GET['himg'];
	
// 	$files = glob($imagePath.'*'); // get all file names
// 	foreach($files as $file){ // iterate files
// 		if(is_file($file))
// 			unlink($file); // delete file
// 	}
	
	$replace_arr = array("%", "@", "&", "}", "{", "#", "^");

	$_FILES["img"]["name"] = str_replace($replace_arr,'0',$_FILES["img"]["name"]);

	$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG" ,"PNG" );
	//$temp = explode(".", $_FILES["img"]["name"]);
	$extension = get_extension($_FILES['img']['tmp_name']); //end($temp);
	
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
	  if ($_FILES["img"]["error"] > 0)
		{
			 $response = array(
				"status" => 'error',
				"message" => 'Image size is too large. Maximum size allowed is 200Kb',
			);			
		}
	  else
		{
			
	      $filename = $_FILES["img"]["tmp_name"];
		  list($width, $height) = getimagesize( $filename );

            $uni_file_name = get_image_temp_name($extension);

		  copy($filename, '../../'.$baseportal.$uni_file_name);

		  move_uploaded_file($filename,  $imagePath . $uni_file_name);
		  $uppath=$uni_file_name;
	
		  
		  if(filesize($imagePath . $_FILES["img"]["name"])>1000000){
		  	$response = Array(
		  			"status" => 'error',
		  			"message" => 'Image size is too large. Maximum size allowed is 1000Kb'
		  			);
		  	print json_encode($response);
		  	return;
		  }		  
		  
		  

		  $response = array(
			"status" => 'success',
			"url" => 'plugins/img_upload/'.$imagePath.$uni_file_name,
			"width" => $width,
			"height" => $height,
			"size" => filesize($imagePath . $uni_file_name),
		  	"uppath" =>$uppath,
		  	"uptag"=>$imname,
		  	"hi_tag"=>$img_h
		  );
		  
		}
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
