<?php

/* No cache*/
header("Cache-Control: no-cache, must-revalidate");

//require_once('../db/config.php');

/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();

require_once '../classes/systemPackageClass.php';
$package_functions=new package_functions();

$base_portal_folder = trim($db->setVal('portal_base_folder','ADMIN'),"/");
$mdu_base_portal_folder = trim($db->setVal('mdu_portal_base_folder','ADMIN'),"/");

	$error = "";
	$msg = "";
	//$fileElementName = 'fileToUpload';
	
	$fileElementName='image'.$_GET['getid'];
	$imgID=$_GET['getid'];
	$validextensions = array("jpeg", "jpg", "png","gif", "bmp","JPEG", "JPG", "PNG","GIF", "BMP");
	
	$temporary = explode(".", $_FILES[$fileElementName]["name"]); 
    $file_extension = end($temporary);
	
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>The uploaded file exceeds the upload_max_filesize directive in php.ini</strong></font>';
				break;
			case '2':
				$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form</strong></font>';
				break;
			case '3':
				$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>The uploaded file was only partially uploaded</strong></font>';
				break;
			case '4':
				$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>No file was uploaded</strong></font>';
				break;

			case '6':
				$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>Missing a temporary folder</strong></font>';
				break;
			case '7':
				$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>Failed to write file to disk</strong></font>';
				break;
			case '8':
				$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>File upload stopped by extension</strong></font>';
				break;
			case '999':
			default:
				$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>No error code avaiable</strong></font>';
		}
	}
	elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
	{
		$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>No file was uploaded..</strong></font>';
	}
	
		elseif(!in_array($file_extension, $validextensions))
	{
		$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>Invalid Image File Format</strong></font>';
	}
	
			elseif($_FILES[$fileElementName]["size"]/1024 > 20000)
	{
		$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>Max File Size should be 2MB</strong></font>';
		
	}
	
	
	
	else 
	{
			//$msg .= " File Name: " . $_FILES[$fileElementName]['name'] . ", ";
			//$msg .= " File Size: " . @filesize($_FILES[$fileElementName]['tmp_name']);
			
		//file name//
		$upload_img_name=$_FILES[$fileElementName]["name"];
		$tmp_img_path = $_FILES[$fileElementName]['tmp_name'];
		
		$file_extension = pathinfo($upload_img_name,PATHINFO_EXTENSION);
		$filename_part=date('dmyhis');
        $actual_image_name = $filename_part."_".$imgID.".".$file_extension;

	  	$isDynamic = $package_functions->isDynamic($_GET['system_package']);
        $template_name=$_GET['template'];

	    	 
	    /*if(isset($_GET['type']) && $_GET['type']=='VTENANT' && (isset($template_name)) && ($isDynamic==1)){
	    	$movepath='../'.$mdu_base_portal_folder .'/layout/'.$template_name.'/img/';
	    	$printpath='../'.$mdu_base_portal_folder .'/layout/'.$template_name.'/img/';
	    }else*/
	    if (isset($_GET['type']) && $_GET['type']=='VTENANT' ) {
	    	$movepath='../'.$mdu_base_portal_folder .'/img/logo/';
		    $printpath='../'.$mdu_base_portal_folder.'/img/logo/';
	    } else{
    		$movepath='../'.$base_portal_folder.'/ads/temp/';
    		$printpath=$base_portal_folder.'/ads/temp/';
	    }
	 

			
			
 if(move_uploaded_file($tmp_img_path, $movepath.$actual_image_name)){
			
						   
						  if($imgID==11){
						  	$msg .= "<img src='img/Ok.png' style='display:inline;'>&nbsp;<font color='#00CC00'><strong>Image Uploaded Successfully!</strong></font><br/>";
						  }
						  else{
						  	//<img src='img/Ok.png' style='display:inline;'>&nbsp;
						    $msg .= "<font color='#00CC00'><strong>Image Uploaded Successfully!</strong></font><br/>";
						  }
							$msg .= "&nbsp;&nbsp;<img src='".$printpath.$actual_image_name."' style='width:125px;height:100px; display:inline;'>";
							$msg .='<input type="hidden" name="image_'.$imgID.'_name" id="image_'.$imgID.'_name" value="'.$actual_image_name.'" />';
				
				
				}else{
					$error = '<img src="img/no.png" style="width:16px;height:16px;display:inline;">&nbsp;<font color="#FF0000"><strong>Image upload failed,try again</strong></font>';
					
					
					}
			
			
	}	
	
	
	if(strlen($error)>0){
		$error .='<input type="hidden" name="image_'.$imgID.'_name" id="image_'.$imgID.'_name" value="" />';
		
	}
	
	$aaa=true;
		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "'\n";
	echo "}";
?>