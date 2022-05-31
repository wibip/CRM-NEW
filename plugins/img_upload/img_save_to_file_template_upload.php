<?php
session_start();

include_once '../../classes/systemPackageClass.php';
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);

include_once '../../classes/dbClass.php';
$db = new db_functions();
$module_array = array('theme','campaign','theme_s');
if(!$package_functions->ajaxAccess($module_array,$system_package)){
	http_response_code(401);
	return false;
}

include_once 'functions.php';
$global_url = trim($db->setVal('global_url', 'ADMIN'), "/");

$imagePath = "temp/";
$baseportal= trim($db->setVal('portal_base_folder','ADMIN'),"/");
$replace_arr = array("%", "@", "&", "}", "{", "#", "^");
$_FILES["img"]["name"] = str_replace($replace_arr,'0',$_FILES["img"]["name"]);
$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG" ,"PNG" );
$extension = get_extension($_FILES['img']['tmp_name']); //end($temp);
$size = $_FILES['img']['size'];
$maxSize = $_POST['maxSize'];

if(!is_writable($imagePath)){
		$response = Array(
			"status" => 'error',
			"message" => 'Can`t upload File; no write Access'
		);
		print json_encode($response);
		return;
	}
	if($size<(1024*$maxSize)){
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
			"url" => $global_url.'/plugins/img_upload/'.$imagePath.$uni_file_name,
			"width" => $width,
			"height" => $height,
			"size" => filesize($imagePath . $uni_file_name),
		  	"uppath" =>$uppath
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
	}else{
		$response = array(
			"status" => 'error',
			"message" => 'Image size is too large. Maximum size allowed is '.$maxSize.'KB',
		);	
	}

//something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini
	  
	  print json_encode($response);

?>
