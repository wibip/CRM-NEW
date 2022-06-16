<?php

//echo $_POST['content'];

if($_FILES)
{
$resultArray = array();
	foreach ( $_FILES as $file){
             	$fileName = $file['name'];
             	$tmpName = $file['tmp_name'];
             	$fileSize = $file['size'];
             	$fileType = $file['type'];
             	if ($file['error'] != UPLOAD_ERR_OK)
             	{
                 		error_log($file['error']);
                 		echo JSON_encode(null);
             	}
             	$fp = fopen($tmpName, 'r');
             	$content = fread($fp, filesize($tmpName));
             	fclose($fp);
            	$result=array(
                 		'name'=>$file['name'],
                 		'type'=>'image',
                 		'src'=>"data:".$fileType.";base64,".base64_encode($content),
                 		'height'=>350,
                 		'width'=>250
             	); 
		// we can also add code to save images in database here.
              	//array_push($resultArray,$result);
 	}    
//$response = array( 'data' => $resultArray );
$target_dir = "../layout/VERIZON/img/uploads/";
$x=$file['name'];
$i=0;
while(file_exists($target_dir . $x)){
    $arr=explode(".",$file['name']);
    $x=$arr[0]."(".++$i.").".$arr[1];
}

//$path = "https://office.wifi.lk/portal/testing/froala/uploads/".$file['name'];
$path = "layout/VERIZON/img/uploads/".$x;
$response = array( 'link' => $path );
//$response = $result;
echo json_encode($response); 

	 // Allowed extentions.
	 $allowedExts = array("gif", "jpeg", "jpg", "png");

	 // Get filename.
	 
	 
	 $temp = explode(".", $file['name']);
	 
	 // Get extension.
	 $extension = end($temp);
	 
	 // An image check is being done in the editor but it is best to
	 // check that again on the server side.
	 
	 /*switch ($file['name']) {
		 case 'image/gif':
		 case 'image/jpg':
		 case 'image/png':
		 case 'image/pjpeg':
		 case 'image/x-png':
		 case 'image/jpeg':*/
			 if(in_array($extension, $allowedExts)){
				 // Generate new random name.
				 $name = sha1(microtime()) . "." . $extension;
	 
				 // Save file in the uploads folder.
				 //move_uploaded_file($file['name'], getcwd() . "uploads/" . $name);
				// $target_dir = "uploads/";
				// $target_file = $target_dir . basename($file['name']);
				$target_file = $target_dir . $x;
				 //if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				move_uploaded_file($file['tmp_name'], $target_file);
				
					//echo "uploaded";
			// Generate response.
				
				// echo stripslashes(json_encode($response));
			 }
			 //break;
		 //default:
			 //echo in_array($extension, $allowedExts);
			 
	// }
	 

}
?>