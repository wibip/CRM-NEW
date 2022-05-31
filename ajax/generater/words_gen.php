<?php


$pass_min_length = 2;
$pass_max_length = 7;



// $file = fopen("contacts.csv","r");
// print_r(fgetcsv($file));
// fclose($file);

$key_bulk=array();

$key_array = file("sample_key.txt");

$remove_key_array = file("remove_key.txt");

//echo count($key_bulk) ."-----". $need_words_count;

// while(count($key_bulk) < $need_words_count){ 
	

// 	$rand_key = array_rand($key_array);
// 	$rand_keys_val = trim(strtoupper($key_array[$rand_key])); 

	

// 		$key_bulk[]=$rand_keys_val;

	
	

// }


//print_r($key_bulk);

$keys;
$keys_set=0;

$key_bulk=array();

for($i=0; $i < count($key_array); $i++){

	

	if (!in_array($key_array[$i], $remove_key_array) && !in_array($key_array[$i], $key_bulk) && strpos($key_array[$i], "'") === false) {

	$keys .= $key_array[$i];
	$key_bulk[]=$key_array[$i];
}
	
	


}
 //echo $keys;

$filename ="Key_sample";

header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=$filename.txt");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$keys";


?>