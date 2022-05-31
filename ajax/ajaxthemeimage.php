<?php
header("Cache-Control: no-cache, must-revalidate");

session_start();

include_once '../classes/systemPackageClass.php';
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);

$module_array = array('theme','theme_s','location');
require_once '../classes/dbClass.php';
$db =  new db_functions();

if(!$package_functions->ajaxAccess($module_array,$system_package)){
    http_response_code(401);
    return false;
}
if (!function_exists("get_mime_type")) { 
    function get_mime_type($file)
    {
        $mtype = false;
        if (function_exists('finfo_open')) {

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mtype = finfo_file($finfo, $file);
            finfo_close($finfo);
        } elseif (function_exists('mime_content_type')) {
            $mtype = mime_content_type($file);
        }
        return $mtype;
    }
}

$base_portal_folder = trim($db->setVal('portal_base_folder','ADMIN'),"/");
$globle_url = trim($db->setVal('global_url','ADMIN'),"/");
$retArr = array('status_code'=>'','response'=>'');
$resp2 = array();
$type = $_POST['type'];
$discode = $_POST['discode'];

	$valid_formats = array("jpeg","jpg", "png", "gif","JPEG","JPG","PNG","GIF");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			
			
			$path = "../".$base_portal_folder."/ads/temp/";
			$echo_path = $base_portal_folder ."/ads/temp/";
			$name = $_FILES['file']['name'];
			$size = $_FILES['file']['size'];
			$tmp = $_FILES['file']['tmp_name'];

			switch($type){

				case 'theme_img_logo' :
					$maxSize =  200;
			
					break;

				case 'img' :
					$maxSize =  200;
			
					break;

				case 'img_upload' :
					$maxSize =  200;
			
					break;

				case 'template_upload' :
					$maxSize =  200;
			
					break;

				case 'theme_img_background' :
					$maxSize =  1000;
			
					break;

				case 'campaign_img_logo' :
					$maxSize =  600;
			
					break;

				case 'campaign_img' :
					$maxSize =  600;
			
					break;

				case 'background' :
					$maxSize =  1000;
			
					break;

				case 'favicon_icon' :
					$maxSize =  200;
					$valid_formats = array("x-icon");

			
					break;
			}
				
			

			
			if(strlen($name))
				{
					
					/////////////////////////////
					$replace_arr = array("%", "@", "&", "}", "{", "#", "^");
						$name = str_replace($replace_arr,'0',$name);
					
					$parts = explode('.', $name);
					$last = array_pop($parts);
					$parts = array(implode('.', $parts), $last);
					
					$txt = $parts[0];
					//$ext = $parts[1];
					$ext = explode('/',get_mime_type($tmp))[1];

					
					////////////////////////////
					
					//list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
						if($size<(1024*$maxSize)){

							$actual_image_name = $discode."_".rand().".".$ext;

							if(move_uploaded_file($tmp, $path.$actual_image_name)){
								$retArr['status_code'] = '200';
								$resp2['srcdata'] = $globle_url."/".$echo_path.$actual_image_name;
								$resp2['img_name'] = $actual_image_name;
								$retArr['response'] = $resp2;
							}else{
								$retArr['status_code'] = '400';
								$retArr['response'] = 'Upload failed';
							}
						}else{
							$retArr['status_code'] = '400';
							$retArr['response'] = 'Image file size max '.$maxSize.' KB.';			
						}
					}else{

						$retArr['status_code'] = '400';
						if($type != 'favicon_icon'){
							$retArr['response'] = 'Invalid image format. Acceptable formats are: PNG, GIF, JPEG and JPG.';
						}else{
							$retArr['response'] = 'Invalid image format. Acceptable format is: ico.';
						}
						
						
					}
					
				}else{
					$retArr['status_code'] = '400';
					$retArr['response'] = 'Please select an image!';	
				}

	}else{
		$retArr['status_code'] = '400';
		$retArr['response'] = 'Invalid request';
	}

	echo json_encode($retArr);
?>