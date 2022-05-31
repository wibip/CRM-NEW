<?php

session_start();
$session_id = session_id();
header("Cache-Control: no-cache, must-revalidate");
include_once '../classes/dbClass.php';
$db = new db_functions();
$upid = $_GET['upid'];

$key_query = "SELECT 
  `ap_code`,
  `mac_address`,
  `download_speed`,
  `upload_speed`,
    error_desc
FROM
  `exp_locations_ap_upload` 
WHERE up_id='$upid' AND is_transfered=0";
	
		$query_results=$db->selectDB($key_query);
		foreach($query_results['data'] AS $row){
			
			$ap_name = $row[ap_name];
			$ap_code = $row[ap_code];
			$mac_address = $row[mac_address];
			$ap_description = $row[ap_description];
			$ERROR = $row[ERROR];

			
			
			$data[] = array("CPE_Code" => $ap_name,"Upload_Speed" => $ap_code, "Download_Speed" => $ap_description, "Mac_Address" => $mac_address,"ERROR" => $ERROR);
			
		}
	
		
		$filename = "Error_CPE_List_". date('Ymd') . ".xls";
		$first_line = "";
		
	
	
	
	
	

















	
	function cleanData(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}
	
	// filename for download
	
	
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	
	$flag = false;
	foreach($data as $row) {
		if(!$flag) {
			// display field/column names as first row
			//echo $first_line;
			echo implode("\t", array_keys($row)) . "\r\n";
			
			$flag = true;
		}
		array_walk($row, 'cleanData');
		echo implode("\t", array_values($row)) . "\r\n";
	}
	exit;
	
		
		
		
		

?>

