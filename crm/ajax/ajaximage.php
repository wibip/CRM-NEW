<?php
header("Cache-Control: no-cache, must-revalidate");

session_start();

/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();
include_once '../classes/systemPackageClass.php';
$package_functions = new package_functions();
include_once '../classes/CommonFunctions.php';
$system_package = $package_functions->getPackage($_SESSION['user_name']);

$module_array = array('config');

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



$id = $_GET['id'];
$type = $_GET['type'];

$id=$db->escapeDB($id);
//$id = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($id) : mysql_escape_string($id);


	$valid_formats = array("jpeg","jpg", "png", "gif", "bmp", "ico","JPEG","JPG","PNG","GIF","BMP","ICO");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			
			
			
			switch($type){
				case 'mno_logo' :
					
					$path = "../".$base_portal_folder."/image_upload/logo/";
					$echo_path = $base_portal_folder ."/image_upload/logo/";
					$query1 = "UPDATE exp_mno SET logo = '";
					$query2 = "' WHERE mno_id = '$id'";
					$name = $_FILES['photoimg']['name'];
					$size = $_FILES['photoimg']['size'];
					$tmp = $_FILES['photoimg']['tmp_name'];
			
					break;
					
					
				case 'mvnx_tlogo' :

					$path = "../image_upload/logo/";
					$echo_path = "image_upload/logo/";
					$query1 = "UPDATE exp_mno_distributor SET theme_logo = '";
					$query2 = "' WHERE distributor_code = '$id'";
					$name = $_FILES['photoimg2']['name'];
					$size = $_FILES['photoimg2']['size'];
					$tmp = $_FILES['photoimg2']['tmp_name'];
						
					break;
					
					
					
				case 'admin_tlogo' :
				
					$path = "../image_upload/logo/";
					$echo_path = "image_upload/logo/";
					$query1 = '';//"UPDATE exp_settings SET settings_value = '";
					$query2 = '';//"' WHERE settings_code = 'site_logo'";
					$name = $_FILES['photoimg5']['name'];
					$size = $_FILES['photoimg5']['size'];
					$tmp = $_FILES['photoimg5']['tmp_name'];
				
					break;
					

					
				case 'mno_tlogo' :
				
					$path = "../image_upload/logo/";
					$echo_path = "image_upload/logo/";
					$query1 = '';//"UPDATE exp_mno SET theme_logo = '";
					$query2 = '';//"' WHERE mno_id = '$id'";
					$name = $_FILES['photoimg']['name'];
					$size = $_FILES['photoimg']['size'];
					$tmp = $_FILES['photoimg']['tmp_name'];
				
					break;					
				
					
					
					
					
				case 'mno_themelogo' :
						
					$path = "../".$base_portal_folder."/image_upload/logo/";
					$echo_path = $base_portal_folder."/image_upload/logo/";
					$query1 = "UPDATE exp_mno SET theme_logo = '";
					$query2 = "' WHERE mno_id = '$id'";
					$name = $_FILES['photoimg']['name'];
					$size = $_FILES['photoimg']['size'];
					$tmp = $_FILES['photoimg']['tmp_name'];
						
					break;
							
			
				case 'mvne_bg' :
					
					$path = "../".$base_portal_folder."/image_upload/backgrounds/";
					$echo_path = $base_portal_folder."/image_upload/backgrounds/";
					$query1 = "UPDATE exp_mno_distributor SET bg_image = '";
					$query2 = "' WHERE distributor_code = '$id'";
					$name = $_FILES['photoimg1']['name'];
					$size = $_FILES['photoimg1']['size'];
					$tmp = $_FILES['photoimg1']['tmp_name'];
			
					break;
			
				case 'mvne_logo' :
					
					$path = "../image_upload/logo/";
					$echo_path = "image_upload/logo/";
					$query1 = "UPDATE exp_mno_distributor SET logo_image = '";
					$query2 = "' WHERE distributor_code = '$id'";
					$name = $_FILES['photoimg3']['name'];
					$size = $_FILES['photoimg3']['size'];
					$tmp = $_FILES['photoimg3']['tmp_name'];
			
					break;
			
				case 'mvno_logo' :
					
					$path = "../image_upload/logo/";
					$echo_path = "image_upload/logo/";
					$query1 = "UPDATE exp_mno_distributor SET logo_image = '";
					$query2 = "' WHERE distributor_code = '$id'";
					$name = $_FILES['photoimg3']['name'];
					$size = $_FILES['photoimg3']['size'];
					$tmp = $_FILES['photoimg3']['tmp_name'];
			
					break;
					
					
				case 'mno_favicon' :
						
					$path = "../".$base_portal_folder."/image_upload/favicon/";
					$echo_path = $base_portal_folder."/image_upload/favicon/";
					$query1 = "UPDATE exp_mno SET favicon_image = '";
					$query2 = "' WHERE mno_id = '$id'";
					$name = $_FILES['photoimg2']['name'];
					$size = $_FILES['photoimg2']['size'];
					$tmp = $_FILES['photoimg2']['tmp_name'];
						
					break;

					
					
					
				case 'mno_bg_pattern' :
						
					$path = "../".$base_portal_folder."/image_upload/background/";
					$echo_path = $base_portal_folder."/image_upload/background/";
					$query1 = "UPDATE exp_mno SET top_bg_pattern_image = '";
					$query2 = "' WHERE mno_id = '$id'";
					$name = $_FILES['photoimg3']['name'];
					$size = $_FILES['photoimg3']['size'];
					$tmp = $_FILES['photoimg3']['tmp_name'];
						
					break;

                case 'login_screen' :

                    $path = "../image_upload/welcome/";
                    $echo_path = "image_upload/welcome/";

                    $query1 = '';//"UPDATE exp_settings SET  settings_value = '";
                    $query2 = '';//"' WHERE settings_code = 'LOGIN_SCREEN_LOGO'";


                    $name = $_FILES['photoimg23']['name'];
                    $size = $_FILES['photoimg23']['size'];
                    $tmp = $_FILES['photoimg23']['tmp_name'];

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
					if($size<(1024*1024))
						{
							$actual_image_name = time().'_'.$id.'_'.substr(str_replace(" ", "_", $txt), 0, 5).".".$ext;
							//$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{

									

									$query = $query1.$actual_image_name.$query2;
									$ex = $db->execDB($query);
									
									echo "<img src='".$globle_url."/".$echo_path.$actual_image_name."'  class='preview'>";
									if($type=='admin_tlogo' || $type=='mno_tlogo' || $type=='login_screen')
									echo ','.$actual_image_name;
								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "<script> alert('Invalid image format. Acceptable formats are: PNG, GIF, JPEG and JPG.'); </script>";
					/* 	echo "Invalid file format.."; */	
					
				}
				
			else
				echo "Please select an image!";
				
			exit;
		}
?>