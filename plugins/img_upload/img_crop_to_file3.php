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
$imgUrl = $_POST['imgUrl'];

$pos = 18;
$begin = substr($imgUrl, 0, $pos+1);
$end = substr($imgUrl, $pos+1);

$imgUrl = $end;

$discode=  $_GET['discode'];
$imgid = $_GET['id'];
$dirname=  $_GET['x'];
$baseportal=  $_GET['baseportal'];


// original sizes
$imgInitW = $_POST['imgInitW'];
$imgInitH = $_POST['imgInitH'];
// resized sizes
$imgW = $_POST['imgW'];
$imgH = $_POST['imgH'];
// offsets
$imgY1 = $_POST['imgY1'];
$imgX1 = $_POST['imgX1'];
// crop box
$cropW = $_POST['cropW'];
$cropH = $_POST['cropH'];

// resized sizes

$ww = 4;
$hh = 4;
// offsets
$imgY1 = $imgY1*$ww;
$imgX1 = $imgX1*$hh;

$imgW = $ww*$imgW;
$imgH = $hh*$imgH;

// crop box
$cropW = $ww*$cropW;
$cropH = $hh*$cropH;
// rotation angle
$angle = $_POST['rotation'];

$jpeg_quality = 400;

$output_filename = "../../$baseportal/ads/temp/".$discode."_".rand();

// uncomment line below to save the cropped image in the same location as the original image.
//$output_filename = dirname($imgUrl). "/croppedImg_".rand();

$what = getimagesize($imgUrl);
$ext = '.'.pathinfo($imgUrl, PATHINFO_EXTENSION);

switch(strtolower($what['mime']))
{
    case 'image/png':
        $img_r = imagecreatefrompng($imgUrl);
		$source_image = imagecreatefrompng($imgUrl);
		$type = '.png';
        break;
    case 'image/jpeg':
        $img_r = imagecreatefromjpeg($imgUrl);
		$source_image = imagecreatefromjpeg($imgUrl);
		error_log("jpg");
		$type = '.jpeg';
        break;
    case 'image/gif':
        $img_r = imagecreatefromgif($imgUrl);
		$source_image = imagecreatefromgif($imgUrl);
		$type = '.gif';
        break;
    default: die('image type not supported');
}


//Check write Access to Directory

if(!is_writable(dirname($output_filename))){
	$response = Array(
	    "status" => 'error',
	    "message" => 'Can`t write cropped File'
    );	
}else{

// resize the original image to size of editor
$resizedImage = imagecreatetruecolor($imgW, $imgH);
if ($type == '.png') {
@imagealphablending($resizedImage, false);
@imagesavealpha($resizedImage, true);
} else {
$white = @imagecolorallocate($resizedImage, 255, 255, 255);
@imagefill($resizedImage, 1, 1, $white);
}
imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
    // rotate the rezized image
    $rotated_image = imagerotate($resizedImage, -$angle, 0);
    // find new width & height of rotated image
    $rotated_width = imagesx($rotated_image);
    $rotated_height = imagesy($rotated_image);
    // diff between rotated & original sizes
    $dx = $rotated_width - $imgW;
    $dy = $rotated_height - $imgH;
// crop rotated image to fit into original rezized rectangle
$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
if ($type == '.png') {
@imagealphablending($cropped_rotated_image, false);
@imagesavealpha($cropped_rotated_image, true);
} else {
$white = @imagecolorallocate($cropped_rotated_image, 255, 255, 255);
@imagefill($cropped_rotated_image, 1, 1, $white);
}
imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
	// crop image into selected area
$final_image = imagecreatetruecolor($cropW, $cropH);
if ($type == '.png') {
@imagealphablending($final_image, false);
@imagesavealpha($final_image, true);
} else {
$white = @imagecolorallocate($final_image, 255, 255, 255);
@imagefill($final_image, 1, 1, $white);
}
imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
	// finally output png image
	//imagepng($final_image, $output_filename.$type, $png_quality);
switch ($type) {
case '.jpg':
imagejpeg($final_image, $output_filename.$ext, $jpeg_quality);
break;
case '.jpeg':
imagejpeg($final_image, $output_filename.$ext, $jpeg_quality);
break;
case '.png':
imagepng($final_image, $output_filename.$ext);
break;
case '.gif':
@imagegif($final_image, $output_filename.$ext, 100);
break;
}
	
	unlink($imgUrl);
	$response = Array(
	    "status" => 'success',
	    "url" => 'plugins/img_upload/'.$output_filename.$ext,
		"ori"  => $imgUrl,
		"name" => $output_filename.$ext	,
		"itag" => 'image_'.$imgid.'_name'	
    );
	

}

print json_encode($response);