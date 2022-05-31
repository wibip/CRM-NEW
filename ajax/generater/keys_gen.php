<?php

$seperator = $_POST['seperator'];
$pass_min_length = $_POST['pass_min_length'];
$pass_max_length = $_POST['pass_max_length'];
$word_count = $_POST['word_count'];
$generate_count = $_POST['generate_count'];
$generate_type = $_POST['generate_type'];

$need_words_count = $word_count * $generate_count;


// $file = fopen("contacts.csv","r");
// print_r(fgetcsv($file));
// fclose($file);

$key_bulk=array();

$key_array = file("key_txt.txt");

//echo count($key_bulk) ."-----". $need_words_count;

while(count($key_bulk) < $need_words_count){ 
	

	$rand_key = array_rand($key_array);
	$rand_keys_val = trim(strtoupper($key_array[$rand_key])); 

	if(strlen($rand_keys_val)==$pass_min_length || strlen($rand_keys_val) == $pass_max_length ){

		$key_bulk[]=$rand_keys_val;

	}
	

}


//print_r($key_bulk);

$keys;
$keys_set=0;

for($i=0; $i < $need_words_count; $i++){

	

if($keys_set<$word_count){
	$keys_set++;

	$keys .= $key_bulk[$i];

	if($keys_set != $word_count){
	 $keys .= $seperator;
	}

}

if($keys_set == $word_count){

	trim($keys,$seperator);

	$keys .= "\n";
	$keys_set=0;
}


}

if($generate_type=='wifikey'){
	
	$wifikey = strtolower($keys);
   $wi=0;
   while($wi<strlen($wifikey)){
	   $tmp=$wifikey[$wi];
	   if(rand() % 2 ==0) $tmp=strtoupper($tmp);
	   else $tmp=strtolower($tmp);
	   $wifikey[$wi]=$tmp;
	   $wi++;
   }
   
   echo $wifikey;
   }else{
	   echo $keys;
   }
   


?>