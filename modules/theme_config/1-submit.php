<?php

//help text configuration
if (isset($_POST['theme_config_submit'])) {
	

	$splash_page_config = $_POST['splash_page_config'];
	if($splash_page_config == 'on'){
		$splash_page_config = '1';
	}else{
		$splash_page_config = '0';
	}

	$sup_language = $_POST['sup_language'];
	$sup_link = $_POST['sup_link'];
	$sup_content = $_POST['sup_content'];


	$text_details['help_text_config'] = $splash_page_config;
	$text_details['support_language'] = $sup_language;
	$text_details['support_content'] = $sup_content;

	$text_details_new = $db->escapeDB(json_encode($text_details));


    $query1 = "REPLACE INTO `exp_texts` (`text_code`,`title`,`text_details`,`vertical`,`distributor`,`create_date`,`updated_by`) VALUES ('CAPTIVE_HELP_TEXT','$sup_link','$text_details_new','all','$user_distributor',NOW(),'$user_distributor')";

    $update_texts = $db->execDB($query1);

    if($update_texts === true){
    	
    	$them_up_msg = $message_functions->showNameMessage('theme_config_updated_success', ''); 
        $them_up_msg = strtr($them_up_msg, $txt_replace);
    	$_SESSION['submit_config'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$them_up_msg."</strong></div>";
    	   	
    }else{
    	$them_up_msg = $message_functions->showNameMessage('theme_config_updated_fail', ''); 
        $them_up_msg = strtr($them_up_msg, $txt_replace);
    	$_SESSION['submit_config'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$them_up_msg."</strong></div>";
    	   	
    }


}


if (isset($_GET['show_config'])) {
	
	$splash_page_config = $_GET['show_config'];

	$get_help_text_q = "SELECT `text_details` FROM `exp_texts` WHERE `distributor`='$user_distributor' AND `text_code` = 'CAPTIVE_HELP_TEXT'";

	$get_help_text = $db->selectDB($get_help_text_q);

	if($get_help_text['rowCount'] > 0){

		foreach($get_help_text['data'] AS $row){
	        
	        $jsonData = preg_replace('/[[:cntrl:]]/', '', $row['text_details']);
	        $sup_json = json_decode($jsonData, true);
	        
	        
	        $sup_conf = $sup_json['help_text_config'];
	        $sup_lang = $sup_json['support_language'];
	        $sup_content = $sup_json['support_content'];
	    }

	    $text_details['help_text_config'] = $splash_page_config;
		$text_details['support_language'] = $sup_lang;
		$text_details['support_content'] = $sup_content;

		$text_details_new = $db->escapeDB(json_encode($text_details));

	    $query1 = "UPDATE `exp_texts` SET `text_details`='$text_details_new' WHERE `distributor`='$user_distributor' AND `text_code`='CAPTIVE_HELP_TEXT'";

	}else{

	    
	    $get_help_text_q = "SELECT * FROM `exp_texts` WHERE `distributor`='$system_package' AND `text_code` = 'CAPTIVE_HELP_TEXT'";

	    $get_help_text = $db->select1DB($get_help_text_q);

	    $sup_link = $get_help_text['title'];
	    $jsonData = preg_replace('/[[:cntrl:]]/', '', $get_help_text['text_details']);
        $sup_json = json_decode($jsonData, true);
        
        
        $sup_conf = $sup_json['help_text_config'];
        $sup_lang = $sup_json['support_language'];
        $sup_content = $sup_json['support_content'];

        $text_details['help_text_config'] = $splash_page_config;
		$text_details['support_language'] = $sup_lang;
		$text_details['support_content'] = $sup_content;

		$text_details_new = $db->escapeDB(json_encode($text_details));

	    $query1 = "REPLACE INTO `exp_texts` (`text_code`,`title`,`text_details`,`vertical`,`distributor`,`create_date`,`updated_by`) VALUES ('CAPTIVE_HELP_TEXT','$sup_link','$text_details_new','all','$user_distributor',NOW(),'$user_distributor')";
	}



    $update_texts = $db->execDB($query1);

    if($update_texts === true){
    	
    	$them_up_msg = $message_functions->showNameMessage('theme_config_updated_success', ''); 
        $them_up_msg = strtr($them_up_msg, $txt_replace);
    	$_SESSION['submit_config'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$them_up_msg."</strong></div>";
    	   	
    }else{
    	$them_up_msg = $message_functions->showNameMessage('theme_config_updated_fail', ''); 
        $them_up_msg = strtr($them_up_msg, $txt_replace);
    	$_SESSION['submit_config'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$them_up_msg."</strong></div>";
    	   	
    }
}

?>