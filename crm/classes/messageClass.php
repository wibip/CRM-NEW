<?php
include_once( str_replace('//','/',dirname(__FILE__).'/') .'../db/dbTasks.php');
include_once( str_replace('//','/',dirname(__FILE__).'/') .'systemPackageClass.php');

class message_functions
{

    private $product;

	public function __construct($product=null) 
	{
        $this->product = $product; 
        $this->dbT = new dbTasks();
        $this->package_function = new package_functions();
	}


	//set Product
    public function setProduct($product){
        $this->product = $product;
    }
	

	public function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
    }

    ////////////////////////////////////////////////////////////////////////

	public function showMessage($messageCode,$errorCode=null)
	{
		$query = "SELECT `message` AS f FROM `exp_messages` WHERE `message_code`='$messageCode'";
		$query_results=$this->dbT->selectDB($query);
		foreach( $query_results['data'] as $row ){
		
			$fullstring = $row['f'];
			$Tag_name = $this->get_string_between($fullstring, '{%', '%}');
			$ori_tag_code = '{%'.$Tag_name.'%}';
			
			// 1. get product from constructor
			// 2. get Message (replace code) from product table
		
			$query_replace = "SELECT `options` as f2 FROM `admin_product_controls` 
			WHERE `type` = 'message' AND `feature_code` = '$Tag_name' 
			AND `product_code` = '$this->product'";
			
            $error_display_type = "SELECT `options` as f4 FROM `admin_product_controls` 
			WHERE `type` = 'message' AND `feature_code` = 'MESSAGE_CODE_DISPLAY' 
			AND `product_code` = '$this->product'";
			
			$query_results2=$this->dbT->selectDB($query_replace);
			foreach( $query_results2['data'] as $row2 ){		
				$replace_code = $row2['f2'];
			}
			
			// 3. Error ID status (NO/LOCAL/VENUE_ID)
			$query_results4=$this->dbT->selectDB($error_display_type);
			foreach( $query_results4['data'] as $row4 ){		
				$error_id_status = $row4['f4'];
			}
			
			 
			$separator = ' : ';
			$error_id_code = '';
			
			// 4. if Venue, get error id from table

			if($error_id_status =='VENUE_ID'){
				$query_code_get = "SELECT `venue_code` as f3 FROM `exp_messages_codes` 
				WHERE `message_code` = '$messageCode' AND `product_code` = '$this->product'";
				
				$query_results3=$this->dbT->selectDB($query_code_get);
				foreach( $query_results3['data'] as $row3 ){
					if(strlen($row3['f3'])>0){
						$error_id_code = $row3['f3'].$separator;
					}
				}
			}
			else if($error_id_status =='LOCAL'){
				if(strlen($error_id_status)>0){
					$error_id_code = $errorCode.$separator;
				}
			}

			$message_ready = str_replace($ori_tag_code,$replace_code,$fullstring);
			$message = $error_id_code.$message_ready;

			if($errorCode === NULL){
				return $message;
			}else{
				return $message;
			}
		}
	}

	////////////////////////////////////////////////////////////////////////

	public function showNameMessage($messageCode,$name,$errorCode=null)
	{
		$query = "SELECT `message` AS f FROM `exp_messages` WHERE `message_code`='$messageCode'";
		$query_results=$this->dbT->selectDB($query);
		foreach( $query_results['data'] as $row ){
		
			$fullstring = $row['f'];
			$Tag_name = $this->get_string_between($fullstring, '{%', '%}');
			$ori_tag_code = '{%'.$Tag_name.'%}';
			
			// 1. get product from constructor
			// 2. get Message (replace code) from product table
		
			$query_replace = "SELECT `options` as f2 FROM `admin_product_controls` 
			WHERE `type` = 'message' AND `feature_code` = '$Tag_name' 
			AND `product_code` = '$this->product'";
			
			$error_display_type = "SELECT `options` as f4 FROM `admin_product_controls` 
			WHERE `type` = 'message' AND `feature_code` = 'MESSAGE_CODE_DISPLAY' 
			AND `product_code` = '$this->product'";
			
			$query_results2=$this->dbT->selectDB($query_replace);
			foreach( $query_results2['data'] as $row2 ){		
				$replace_code = $row2['f2'];
			}
			
			// 3. Error ID status (NO/LOCAL/VENUE_ID)
			$query_results4=$this->dbT->selectDB($error_display_type);
			foreach( $query_results4['data'] as $row4 ){		
				$error_id_status = $row4['f4'];
			}
			
			
			$separator = ' : ';
			$error_id_code = '';
			
			// 4. if Venue, get error id from table

			if($error_id_status =='VENUE_ID'){
				$query_code_get = "SELECT `venue_code` as f3 FROM `exp_messages_codes` 
				WHERE `message_code` = '$messageCode' AND `product_code` = '$this->product'";
				
				$query_results3=$this->dbT->selectDB($query_code_get);
				foreach( $query_results3['data'] as $row3 ){
					if(strlen($row3['f3'])>0){
						$error_id_code = $row3['f3'].$separator;
					}
				}
			}
			else if($error_id_status =='LOCAL'){
				if(strlen($error_id_status)>0){
					$error_id_code = $errorCode.$separator;
				}
			}
			
			
			
			
			$message_ready = str_replace($ori_tag_code,$replace_code,$fullstring);
			$message = $error_id_code.$message_ready;
			
			
			if($errorCode === NULL){
				return str_replace('<name>',$name,$message);

			}else{
				return str_replace('<name>',$name,$message);
			}
		}
	}

    ////////////////////////////////////////////////////////////////////////

	public function showNamesMessage($messageCode,array $names,$errorCode=null)
	{
		$query = "SELECT `message` AS f FROM `exp_messages` WHERE `message_code`='$messageCode'";
		$query_results=$this->dbT->selectDB($query);
		foreach( $query_results['data'] as $row ){ 

			$fullstring = $row['f'];
			$Tag_name = $this->get_string_between($fullstring, '{%', '%}');
			$ori_tag_code = '{%'.$Tag_name.'%}';

			// 1. get product from constructor
			// 2. get Message (replace code) from product table

			$query_replace = "SELECT `options` as f2 FROM `admin_product_controls` 
			WHERE `type` = 'message' AND `feature_code` = '$Tag_name' 
			AND `product_code` = '$this->product'";

			$error_display_type = "SELECT `options` as f4 FROM `admin_product_controls` 
			WHERE `type` = 'message' AND `feature_code` = 'MESSAGE_CODE_DISPLAY' 
			AND `product_code` = '$this->product'";

			$query_results2=$this->dbT->selectDB($query_replace);
			foreach( $query_results2['data'] as $row2 ){
				$replace_code = $row2['f2'];
			}

			// 3. Error ID status (NO/LOCAL/VENUE_ID)
			$query_results4=$this->dbT->selectDB($error_display_type);
			foreach( $query_results4['data'] as $row4 ){
				$error_id_status = $row4['f4'];
			}


			$separator = ' : ';
			$error_id_code = '';

			// 4. if Venue, get error id from table

			if($error_id_status =='VENUE_ID'){
				$query_code_get = "SELECT `venue_code` as f3 FROM `exp_messages_codes` 
				WHERE `message_code` = '$messageCode' AND `product_code` = '$this->product'";

				$query_results3=$this->dbT->selectDB($query_code_get);
				foreach( $query_results3['data'] as $row3 ){
					if(strlen($row3['f3'])>0){
						$error_id_code = $row3['f3'].$separator;
					}
				}
			}
			else if($error_id_status =='LOCAL'){
				if(strlen($error_id_status)>0){
					$error_id_code = $errorCode.$separator;
				}
			}




			$message_ready = str_replace($ori_tag_code,$replace_code,$fullstring);
			$message = $error_id_code.$message_ready;


			if($errorCode === NULL){
				return strtr($message, $names); //str_replace('<name>',$name,$message);

			}else{
				return strtr($message, $names); //str_replace('<name>',$name,$message);
			}
		}
	}

    ////////////////////////////////////////////////////////////////
	public function getPageContent($content_code,$product_code)
	{
		$system_package = $this->package_function->getOptions('PARENT_PRODUCT_CODE',$product_code);

		if (strlen($system_package)<1) {
			$system_package = $product_code;
		}
		

		$q="SELECT c.content AS content FROM exp_content c WHERE c.product_code='$system_package' AND c.content_code='$content_code'";
		$r_count = $this->dbT->getNumRows($q);
		if($r_count=='0'){
			$q="SELECT c.content AS content FROM exp_content c WHERE c.product_code='N/A' AND c.content_code='$content_code'";
		}

		$data = $this->dbT->select1DB($q);
		return $data['content'];
	}

	/////////////////////////////////////////////////////////////////////////
	public function getNamePageContent($content_code,$product_code,$tags)
	{
		$q="SELECT c.content AS content FROM exp_content c WHERE c.product_code='$product_code' AND c.content_code='$content_code'";
		$r_count = $this->dbT->getNumRows($q);
		if($r_count=='0'){
			$q="SELECT c.content AS content FROM exp_content c WHERE c.product_code='N/A' AND c.content_code='$content_code'";
		}

		$data = $this->dbT->select1DB($q);

		$content=$data['content'];

		foreach($tags as $key => $key_value){

			$content = str_replace($key,$key_value,$content);
		}
		
		return $content;
	}

}
?>