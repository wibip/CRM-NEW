<style type="text/css">


@media screen and (min-width : 980px){
    
  .middle.form-horizontal .controls{
      width: 320px;
  }

}
    #ex-btn-div{
        text-align: center;
    }

    #ex-btn-div .tablesaw-bar{
        text-align: center;
        top: 30px;
    }

    #ex-btn-div .export-customer-a{
        margin-bottom: 20px;
    }

    .table_response{
        margin: auto;
    }
  .widget-header{
        display: none;
  }
  .widget-content{
    padding: 0px !important;
    border: 1px solid #ffffff !important;
  }
  .intro_page{
    z-index: -4;
  }
  .nav-tabs{
    /*padding-left: 30% !important;
  }
  body .nav-tabs>.active>a, body .nav-tabs>.active>a:hover{
        background-color: #000000;
    border: none;
  }

  .nav-tabs>li>a{
    background: none !important;
    border: none !important;
  }
  .nav-tabs>li>a{
    color: #0568ae !important;
    border-radius: 0px 0px 0 0 !important;
  }

  .nav-tabs>li:nth-child(3)>a{
    border-right: none !important;
  }*/

  body {
    background: #ffffff !important;
}

h1.head {
    padding: 0px;
    padding-bottom: 35px;
    width: 960px;
    font-weight: bold !important;
    margin: auto;
    font-size: 25px;
    text-align: center;
    color: #5f5a5a;
    box-sizing: border-box;
}


/*footer styles*/

.contact{
    font-size: 16px;
    font-family: Rregular;
    color: #fff;
        margin-right: 50px;
}

.call span:not(.glyph), .footer-live-chat-link span:not(.glyph){
    font-family: Rmedium;
    font-size: 20px;
    color: #fff;
}

.number{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-live-chat-link{
        display: inline-block;
    margin-left: 50px;
}

.call a{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-inner a:hover{
    text-decoration: none !important;
    color: #fff;
}

.main-inner{
  position: relative;
}

.main {
    padding-bottom: 0 !important;
}

  /*network styles
*/

.tab-pane{
  padding-bottom: 50px;
/*  padding-top: 50px;*/
    /*border-bottom: 1px solid #000000;*/
}

.tab-pane:nth-child(1){
  padding-top: 0px;
}

.tab-pane:last-child{
  border-bottom: none;
}

.alert {
  /*position: absolute;
    top: 60px;*/
    width: 100%;
} 

.form-horizontal .controls{
    width: 370px;
    margin: auto;
}

.form-horizontal .contact.controls{
    width: 700px;
}

form.form-horizontal .form-actions{
    width: 350px;
    margin: auto;
    background-color: #fff;
    padding-left: 0px;
}

form .qos-sync-button {
    float: none;
}

@media (max-width: 979px){
    .form-horizontal .controls{
        width: 320px;
    }

    form.form-horizontal .form-actions{
        width: 300px;
    }

    .form-horizontal .contact.controls{
        width: 90%;
    }

    .tab-pane {
        padding-top: 0px !important;
    }
}

@media (max-width: 768px){
    .form-horizontal .controls{
        width: 280px;
    }

    form.form-horizontal .form-actions{
        width: 260px;
    }


    .form-horizontal .contact.controls{
        width: 100%;
    }

    select.inline-btn, input.inline-btn, button.inline-btn, a.inline-btn {
        display: block !important;
    }

    a.inline-btn, button.inline-btn, input[type="submit"].inline-btn {
        margin-top: 10px !important;
        margin-left: 0px !important;
    }

}

@media (max-width: 480px){
    form.form-horizontal .form-actions{
        width: 270px;
    }
}
</style>

<?php 


$data_secret = $db->setVal('data_secret','ADMIN');
$distributercode=$package_functions->getDistributorMONPackage($user_name);


$active = 'im'; // tab id



function syncCustomer($Response1,$search_id_up){
	 
	parse_str($Response1);
		
	//echo $parameters;
		
	//$data = json_decode($parameters, true);
	$bulk_profile_data = urldecode($parameters);
		
	$single_profile_data = explode('|', $bulk_profile_data);
		
	for($k=0;$k<sizeof($single_profile_data);$k++){
		 
		//echo $single_profile_data;
		$single_profile_data[$k].'<br><br>';
		if(sizeof($single_profile_data[$k])>0){
	 		
			$Master_Account = '';
			$array_get_profile_value = '';
			//parse_str(str_replace('-','_',$single_profile_data[$k]));
	 		
			parse_str($single_profile_data[$k],$array_get_profile_value);
			
			//print_r($array_get_profile_value);
			
			$User_Name = $array_get_profile_value['User-Name'];
			
			$query_0 = "SELECT * FROM `mdu_vetenant` WHERE username = '$User_Name' ";
			//echo $Master_Account;
			$result_0 = mysql_query($query_0);
	 		
			$PAS_First_Name = mysql_real_escape_string($array_get_profile_value['PAS-First-Name']);
			$PAS_Last_Name = mysql_real_escape_string($array_get_profile_value['PAS-Last-Name']);
			$secret_question = mysql_real_escape_string($array_get_profile_value['secret_question']);
			$secret_answer = mysql_real_escape_string($array_get_profile_value['secret_answer']);
			$company = mysql_real_escape_string($array_get_profile_value['company']);
			$address = mysql_real_escape_string($array_get_profile_value['address']);
			$city = mysql_real_escape_string($array_get_profile_value['city']);
			$state = mysql_real_escape_string($array_get_profile_value['state']);
			$country = mysql_real_escape_string($array_get_profile_value['country']);
			$Email = $array_get_profile_value['Email'];
			$Password = $array_get_profile_value['Password'];
			$Group = $array_get_profile_value['Group'];
			$zip = $array_get_profile_value['zip']; 
			$Valid_From = $array_get_profile_value['Valid-From'];
			$Valid_Until = $array_get_profile_value['Valid-Until'];			
			$MSISDN = $array_get_profile_value['MSISDN'];
			$Master_Account = $array_get_profile_value['Master-Account'];
			$ser_prof = $array_get_profile_value['Service-Profiles'];
			
			if(mysql_num_rows($result_0) >= 1){
				 
				
				 
				$queryd = "UPDATE `mdu_vetenant` SET
				`email` = '$Email',
				`first_name` = '$PAS_First_Name',
				`last_name` = '$PAS_Last_Name',
				username = '$User_Name',
				password = '$Password',
				`question_id` = '$secret_question',
				property_id = '$Group',
				`answer` = '$secret_answer',
				company_name = '$company',
				address = '$address',
				city = '$city',
				state = '$state',
				postal_code = '$zip',
				country = '$country',
	            valid_from = '$Valid_From',
				valid_until = '$Valid_Until',				
				phone = '$MSISDN',
				search_id = '$search_id_up',
				service_profile = '$ser_prof'
				WHERE username = '$User_Name'";
				 
			}else {
				 
				$queryd = "REPLACE INTO `mdu_vetenant` (`email`,`first_name`,`last_name`,username,`password`,`question_id`,property_id,valid_from,valid_until,`answer`,company_name,address,city,state,postal_code,country,phone,create_date,service_profile,email_sent,search_id,create_user)
				VALUES('$Email','$PAS_First_Name','$PAS_Last_Name','$User_Name','$Password', '$secret_question','$Group','$Valid_From','$Valid_Until','$secret_answer','$company','$address','$city','$state','$zip','$country','$MSISDN',NOW(),'$ser_prof','','$search_id_up','API')";
				 
			}
	 		
			if(strlen($Master_Account)==0){
				if(strlen($User_Name)>0){
					//echo $queryd.'<br>';
					$ex1 = mysql_query($queryd);
						
						
				}
			}
	 		
	 		
	 		
			$User_Name = '';
			$Master_Account = '';
			$updated = 1;
	 		
			$Email = '';
			$EMAIL = '';
			$PAS_First_Name = '';
			$PAS_Last_Name = '';
			$User_Name = '';
			$secret_question = '';
			$Group = '';
			$secret_answer = '';
			$company = '';
			$address = '';
			$city = '';
			$state = '';
			$zip = '';
			$country = '';
			$MSISDN = '';
			 
	 		
	 		
		}
	}
	 
	return $updated;
	 
}
 





  if(isset($_POST['search_btn'])){ //1    
                                    
       if($_SESSION['FORM_SECRET'] == $_POST['form_secret']){//key validation	  

	
	$property_id = $_POST['property_id'];
	 $search_word = trim($_POST['search_word']);
	 
	 
	 if(strlen($search_word)>0) {
/////////////////*********APTILO Query & Show The Results*********************/////////////////////////////
		 ////////////////START DATA TRANSFER//////////////////////


		 ////////////////START DATA TRANSFER//////////////////////
		 $sql="SELECT o.property_id,o.validity_time FROM mdu_system_user_organizations uo,mdu_organizations o 
              WHERE o.property_number=uo.property_id AND  uo.user_name = '$user_name'";

         $search_id_up=uniqid("com");

		 $sql_r=mysql_query($sql);
		 while($sql_d=mysql_fetch_assoc($sql_r)) {



             $Response1 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"PAS-First-Name", $search_word);
             $updated1 = syncCustomer($Response1, $search_id_up);


             ///// Match With Last Name /////
             $Response2 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"PAS-Last-Name", $search_word);
             $updated2 = syncCustomer($Response2, $search_id_up);
             //parse_str($Response2);

             //syncCustomer($Response2,'');


             ///// Match With Email /////
             $Response3 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"Email", $search_word);
             $updated3 = syncCustomer($Response3, $search_id_up);
             //parse_str($Response3);
             //syncCustomer($Response3,'');




	 }
	 						/////////// END DATA TRANSFER ////////////////
	 	
	 
	 /////////// END DATA TRANSFER ////////////////
	 }//1
	 
	 
	
		//Query Set////
		if($property_id =="ALL" && strlen($search_word)==0){
			$query_set="";
		}
		elseif($property_id =="ALL" && strlen($search_word)>0){
			
			$query_set="WHERE ( property_id in (SELECT property_id FROM mdu_system_user_organizations WHERE user_name = '$user_name')) AND (`first_name` = '$search_word' OR `last_name` = '$search_word' OR `email` = '$search_word' OR `room_apt_no` = '$search_word')";
				
		}
		elseif($property_id !="ALL" && strlen($search_word)>0){
			
			$query_set="WHERE (property_id='$property_id') AND (`first_name` = '$search_word' OR `last_name` = '$search_word' OR `email` = '$search_word' OR `room_apt_no` = '$search_word')";
				
		}
		elseif($property_id !="ALL" && strlen($search_word)==0){
			$query_set="WHERE property_id='$property_id'";
				
		}	
	

		
	$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
	$rowe = mysql_fetch_array($br);
	$search_id = $rowe['Auto_increment'];
	
	$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");
	
	if(!$Ex_insert){
	$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
	$rowe = mysql_fetch_array($br);
	$search_id = $rowe['Auto_increment'];
	
	$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");
		
		}
		
	
	//////////////////////////////////////////////////////////////////////////	
		
	
			
		
	/////////////////////////////////////////////////////////////////////////////	
	
	
	///Temp Case: query from table-result update from search id//////////////
	
	$find_customers=mysql_query("SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set);
	
	if(mysql_num_rows($find_customers)>0){
		$record_found=1;
		$customer_list = '';
		while($row=mysql_fetch_array($find_customers)){
			
			$customer_id=$row['f'];
			$customer_list .= ','.$customer_id;
			//$update_result=mysql_query("UPDATE `mdu_vetenant` SET `search_id` = '$search_id' WHERE `customer_id` = '$customer_id'");
			
			}
	
			$customer_list = trim($customer_list,',');
			$update_result=mysql_query("UPDATE `mdu_search_id` SET `customer_list` = '$customer_list' WHERE `id` = '$search_id'");
					
		}else{
			$record_found=0;
			$msg_val="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('tenant_search_no_record','2004')."</strong></div>";
			
			
			}
		

  }//key validation
 else{
		$msg_val = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transaction_failed','2004')."</strong></div>";
					//header('Location: ');
					
					}  
                                    
									
}	//1





else if(isset($_POST['search_btn2'])){ //1

	if($_SESSION['FORM_SECRET4'] == $_POST['form_secret4']){//key validation


		$property_id = $_POST['property_id'];
		$search_word = trim($_POST['search_word']);
		 
		 
		 if(strlen($search_word)>0){//1
		 ////////////////START DATA TRANSFER//////////////////////
		 
		 	
		 	////////////////START DATA TRANSFER//////////////////////
			 $sql="SELECT o.property_id,o.validity_time FROM mdu_system_user_organizations uo,mdu_organizations o 
              WHERE o.property_number=uo.property_id AND  uo.user_name = '$user_name'";

             $search_id_up=uniqid("com");

			 $sql_r=mysql_query($sql);
			 while($sql_d=mysql_fetch_assoc($sql_r)) {

                 $Response1 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"PAS-First-Name", $search_word);
                 $updated1 = syncCustomer($Response1, $search_id_up);


                 ///// Match With Last Name /////
                 $Response2 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"PAS-Last-Name", $search_word);
                 $updated2 = syncCustomer($Response2, $search_id_up);
                 //parse_str($Response2);

                 //syncCustomer($Response2,'');


                 ///// Match With Email /////
                 $Response3 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"Email", $search_word);
                 $updated3 = syncCustomer($Response3, $search_id_up);
                 //parse_str($Response3);
                 //syncCustomer($Response3,'');

			 }
			 
		 						/////////// END DATA TRANSFER ////////////////
		 
		 /////////// END DATA TRANSFER ////////////////
		 }//1
		 


		//Query Set////
		if($property_id =="ALL" && strlen($search_word)==0){
			//$query_set="";
			//$query_set="WHERE ( property_id in (SELECT property_id FROM mdu_system_user_organizations WHERE user_name = '$user_name'))";
			$query_set="WHERE mdo.distributor_code='$user_distributor'";//"WHERE ( property_id in (SELECT verification_number FROM exp_mno_distributor WHERE distributor_code = '$user_distributor'))";
				
			
		}
		elseif($property_id =="ALL" && strlen($search_word)>0){
			
			//$query_set="WHERE ( property_id in (SELECT property_id FROM mdu_system_user_organizations WHERE user_name = '$user_name')) AND (`first_name` = '$search_word' OR `last_name` = '$search_word' OR `email` = '$search_word' OR `room_apt_no` = '$search_word')";
			$query_set="AND (mv.`first_name` LIKE  '%$search_word%' OR mv.`last_name` LIKE  '%$search_word%' OR mv.`email` LIKE  '%$search_word%' OR mv.`room_apt_no` LIKE  '%$search_word%')
WHERE mdo.distributor_code='$user_distributor'";
            //"WHERE ( property_id in (SELECT verification_number FROM exp_mno_distributor WHERE distributor_code = '$user_distributor')) AND (`first_name` LIKE  '%$search_word%' OR `last_name` LIKE  '%$search_word%' OR `email` LIKE  '%$search_word%' OR `room_apt_no` LIKE  '%$search_word%')";
				
		}
		elseif($property_id !="ALL" && strlen($search_word)>0){
			
			$query_set="AND (mv.`first_name` LIKE  '%$search_word%' OR mv.`last_name` LIKE  '%$search_word%' OR mv.`email` LIKE  '%$search_word%' OR mv.`room_apt_no` LIKE  '%$search_word%')
WHERE mdo.distributor_code='$user_distributor' AND mdo.property_id =  '$property_id'";
            //"WHERE (property_id LIKE  '%$property_id%') AND (`first_name` LIKE  '%$search_word%' OR `last_name` LIKE  '%$search_word%' OR `email` LIKE  '%$search_word%' OR `room_apt_no` LIKE  '%$search_word%')";
				
		}
		elseif($property_id !="ALL" && strlen($search_word)==0){
			$query_set="WHERE mdo.distributor_code='$user_distributor' AND mdo.property_id = '$property_id'";//"WHERE property_id LIKE '%$property_id%'";
				
		}
			

//echo $query_set;

		$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
		$rowe = mysql_fetch_array($br);
		$search_id2 = $rowe['Auto_increment'];

		$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`)
				VALUES('$search_id2','$user_name',NOW())");

		if(!$Ex_insert){
			$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
			$rowe = mysql_fetch_array($br);
			$search_id2 = $rowe['Auto_increment'];

			$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`)
					VALUES('$search_id2','$user_name',NOW())");

		}


		//////////////////////////////////////////////////////////////////////////

		/*********APTILO Query & Show The Results*********************/
			

		/////////////////////////////////////////////////////////////////////////////


		///Temp Case: query from table-result update from search id//////////////
		//echo "SELECT `customer_id` AS f FROM `mdu_vetenant` mv JOIN mdu_distributor_organizations mdo ON mv.property_id=mdo.property_id ".$query_set;

		$find_customers=mysql_query("SELECT `customer_id` AS f FROM `mdu_vetenant` mv JOIN mdu_distributor_organizations mdo ON mv.property_id=mdo.property_id ".$query_set);

		if(mysql_num_rows($find_customers)>0){
			/* $record_found2=1; */
			$customer_list = '';
			while($row=mysql_fetch_array($find_customers)){
					
				$customer_id=$row['f'];
				$customer_list .= ','.$customer_id;
					
				//$update_result=mysql_query("UPDATE `mdu_vetenant` SET `search_id` = '$search_id2' WHERE `customer_id` = '$customer_id'");
					
			}
			
			$customer_list = trim($customer_list,',');
			$update_result=mysql_query("UPDATE `mdu_search_id` SET `customer_list` = '$customer_list' WHERE `id` = '$search_id2'");
			



		} else{
			$record_found2=0;
			$msg_val="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>No records found</strong></div>";
				
				
		} 


	}//key validation
	else{
		//echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: Transaction is failed (err 1025)</strong></div>";
		//header('Location: ');
			
	}
	$record_found2=1;
	$active = 'im';
		
}else{

	$record_found2=1;
	$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
		$rowe = mysql_fetch_array($br);
		$search_id2 = $rowe['Auto_increment'];

		$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`)
				VALUES('$search_id2','$user_name',NOW())");

		if(!$Ex_insert){
			$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
			$rowe = mysql_fetch_array($br);
			$search_id2 = $rowe['Auto_increment'];

			$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`)
					VALUES('$search_id2','$user_name',NOW())");

		}
	$query_results = $db->get_property($user_distributor);
	while($row=mysql_fetch_array($query_results)){
			$property_id = $row[property_id];
																	  
	}
	$query_set="WHERE mdo.distributor_code='$user_distributor'";
	$find_customers=mysql_query("SELECT `customer_id` AS f FROM `mdu_vetenant` mv JOIN mdu_distributor_organizations mdo ON mv.property_id=mdo.property_id ".$query_set);

		if(mysql_num_rows($find_customers)>0){
			/* $record_found2=1; */
			$customer_list = '';
			while($row=mysql_fetch_array($find_customers)){
					
				$customer_id=$row['f'];
				$customer_list .= ','.$customer_id;
					
				//$update_result=mysql_query("UPDATE `mdu_vetenant` SET `search_id` = '$search_id2' WHERE `customer_id` = '$customer_id'");
					
			}
			
			$customer_list = trim($customer_list,',');
			$update_result=mysql_query("UPDATE `mdu_search_id` SET `customer_list` = '$customer_list' WHERE `id` = '$search_id2'");
			



		}

		
	
}	//1




 if(isset($_POST['submit_group'])){//2
	
	if($_SESSION['FORM_SECRET_G'] == $_POST['form_secret_g']){
		
		$active = 'gm'; // tab id
		$form_secret_g = $_POST['form_secret_g'];
		$property_id = $_POST['property_id'];
		$group_message = $_POST['group_message'];
		
		
		$disable_others = "UPDATE mdu_bulk_emails_template SET `status` = 0 WHERE distributor = '$mdu_distributor_id' and `status` <> '9'";
		$ex = mysql_query($disable_others);
		
		
		 $log1 = "INSERT INTO `mdu_bulk_emails_template` (`property_id`, `email`, distributor ,`create_date`, status, `create_user`) 
		VALUES ('$property_id', '$group_message','$mdu_distributor_id', NOW(),'1' ,'$user_name')";
		$ex1 = mysql_query($log1);
		 

	$query_update = "REPLACE INTO `exp_texts` (`text_code`, `text_details`, `user_type`, `distributor`, `create_date`, `updated_by`)
		VALUES ('GROUP_MAIL', '$MDU_GROUP_MAIL', 'MANAGER', '$mdu_distributor_id', NOW(), '$user_name')";
		
		$ex = mysql_query($query_update); 

	 $emails = "SELECT first_name, last_name, email, username FROM mdu_vetenant WHERE property_id = '$property_id' ";
		$query_results=mysql_query($emails);
		$count_rec = mysql_num_rows($query_results);
		while($row=mysql_fetch_array($query_results)){
			
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$email = $row[email];
			$username = $row[username];

	
			$customer_full_name=$first_name." ".$last_name;
			$to = $email;
			$subject = 'Message from Property Management Team';
			$mno_package=$package_functions->getDistributorMONPackage($user_name);
          $MNO=$db->getValueAsf("SELECT mno_id AS f FROM exp_mno WHERE system_package='$mno_package'");
          
          
          $from=strip_tags($db->setVal("email", $mno_id));
          if (empty($from)) {
            $from=strip_tags($db->setVal("email", "ADMIN"));
          }
            /* $from_email_add = strip_tags($db->getValueAsf("SELECT email AS f FROM admin_users WHERE user_name='$user_name'"));

            if($from_email_add == ''){
                $from_email_add = strip_tags($db->setValDistributor("email","MANAGER"));
            }
 */



			
			/* 
			$headers = "From: ".$db->setValDistributor("short_title","MANAGER")."<" . $from_email_add . ">\r\n";
			$headers .= "Reply-To: ". $from_email_add . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			 */
		
			$vars = array(
					'{$user_full_name}' => $customer_full_name,
					'{$short_name}'        => $db->setValDistributor("short_title","ADMIN")
						
			);
			
			//	 $emailTemplate=$package_functions->getSectionType("EMAIL_TEMPLATE",$my_product);
			$message_full = strtr($group_message, $vars);
			
			
			$message = $message_full;


			/* $emailSystem=$package_functions->getSectionType("EMAIL_SYSTEM",$package_functions->getAdminPackage());
                    if(strlen($emailSystem)>0){
                        require_once ('src/email/'.$emailSystem.'/index.php');
                        $emailSystemOb=new email(array('template'=>$emailTemplate));
                        $mail_sent=$emailSystemOb->sendEmail($from_email_add,$to,$subject,$message,'','');
                    }else {
                        $mail_sent = @mail($to, $subject, $message, $headers);
                    } */
			

            //echo $headers;
				
$email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
include_once 'src/email/'.$email_send_method.'/index.php';

//email template
$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
$cunst_var=array();
if($emailTemplateType=='child'){
	$cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$mno_sys_package);
}elseif($emailTemplateType=='owen'){
	$cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
}else{
	$cunst_var['template']=$emailTemplateType;
}

            $cunst_var['system_package'] = $system_package;
            $cunst_var['mno_package'] = $mno_package;
  $cunst_var['mno_id'] = $mno_id;



$mail_obj=new email($cunst_var);
//$mno_package=$package_functions->getDistributorMONPackage($user_name);
$mail_obj->mno_system_package = $mno_package;

$mail_sent=$mail_obj->sendEmail($from,$to,$subject,$message_full,'',$title);

			
			//echo $mail_sent ? "Mail sent" : "Mail failed";
            $log = "INSERT INTO `mdu_bulk_emails` (`property_id`, `email`, `username`, `create_date`, status, `create_user`) VALUES ('$property_id', '$message', '$username', NOW(),'1' ,'$user_name')";
            $ex = mysql_query($log);
			
			if($mail_sent){
				$email_sent=1;
			}else{
				$email_sent=0;
				
				//////// resend email //////////
				$sys_user = $_SESSION['user_namem'];
				$resend_q = "INSERT INTO `mdu_email_resend` (`to`, `subject`, `headers`, `mail_body`, `send_status`, `create_date`, `create_user`)
				VALUES ('$to', '$subject', '$headers', '$message', '0', NOW(), '$sys_user')";
				$resend = mysql_query($resend_q);
				//////// resend email ///////////
				
			}
			
			
		}
			
			if($email_sent == 1){
					
				$msg_val =  '<center><div   class="alert alert-success">'.$message_functions->showMessage('bulk_email_success','2004').'</div></center>';
			}
			else{
				$msg_val =  '<center><div   class="alert alert-warning">'.$message_functions->showNameMessage('replace_mdu_records_with_ale_rec',$count_rec).'</div></center>';
			
			}
	
	}
}//2
else if(isset($_POST['submit_aup'])){//3
	
	$active = 'aup'; // tab id
	$aup_message = $_POST['aup_message'];
	$full_name = $_POST['full_name'];
	$email = $_POST['email'];
    $username = $_POST['username'];
	$aup_message_text = trim($_POST['aup_msg']);
	$user_message_text = trim($_POST['user_msg']);

	
	if($_SESSION['FORM_SECRET_G']==$_POST['form_secret_g']){
		
		$log = "INSERT INTO `mdu_aup_violation` (username,customer_name,customer_email,aup_message,user_message,create_date,create_user)
		 VALUES ('$username','$full_name', '$email','$aup_message_text','$user_message_text', NOW(), '$user_name')";
		$ex = mysql_query($log);
		
		
		$customer_full_name=$full_name;
		$to = $email;
		$subject = 'AUP Violation';


        $from_email_add = strip_tags($db->setVal('FROM_EMAIL', $mdu_distributor_id));

        if($from_email_add == ''){
            $from_email_add = strip_tags($db->setVal("email","MANAGER"));
        }
			
			
		$headers = "From: ".$db->setVal("short_title","MANAGER")." " . $from_email_add . "\r\n";
		$headers .= "Reply-To: ". $from_email_add . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
			
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			
		
		$vars = array(
				'{$user_full_name}' => $customer_full_name,
				'{$user_email}'        => $email,
				'{$violation_message}'   => $aup_message_text
		
		);
			
		$message_full = strtr($aup_message, $vars);
			
			
		$message = $message_full;
			
		$mail_sent = @mail( $to, $subject, $message, $headers );
			
			
		//echo $mail_sent ? "Mail sent" : "Mail failed";
			
		if($mail_sent){
			$email_sent=1;
		}else{
			$email_sent=0;
			
			//////// resend email //////////
			$sys_user = $_SESSION['user_namem'];
			$resend_q = "INSERT INTO `mdu_email_resend` (`to`, `subject`, `headers`, `mail_body`, `send_status`, `create_date`, `create_user`)
			VALUES ('$to', '$subject', '$headers', '$message', '0', NOW(), '$sys_user')";
			$resend = mysql_query($resend_q);
			//////// resend email ///////////
			
		}
		
		
		
		
		
		
		$find_customers=mysql_query("SELECT * FROM `mdu_vetenant` WHERE email  = '$email'");
				
			while($row=mysql_fetch_array($find_customers)){
					
				$first_name=$row['first_name'];
				$room_apt_no=$row['room_apt_no'];
				$question_id=$row['question_id'];
				$answer=$row['answer'];
				$comp_name=$row['company_name'];
				$address=$row['address'];
				$city=$row['city'];
				$state=$row['state'];
				$postal_code=$row['postal_code'];
				$country=$row['country'];
				$phone=$row['phone'];
				
			}
		
		
		/// Send to CAMP
	//	$user_date_string = "usermessage=".$user_message_text."&address2=".$room_apt_no."&warning=".$aup_message_text."&country=".$country."&address=".$address."&violation=0&state=".$state."&zip=".$postal_code."&secret_question=".$question_id."&city=".$city."&secret_answer=".$answer."&company=".$comp_name;
		$response = $nf->AUP($email, $user_message_text,$aup_message_text);
		parse_str($response);
		
		
		if($status_code == 200 || $status == 200){
			$msg_val = '<center><div   class="alert alert-success">AUP message has been send to CAMP</div></center>';
				
		}
		else{
			$msg_val = '<center><div   class="alert alert-danger">AUP Message sending failed</div></center>';
				
		}
		
		if($email_sent == 1){
				
			$msg_val = '<center><div   class="alert alert-success">'.$message_functions->showMessage('tenant_email_sent_success','2004').'</div></center>';
		}
		else{
			$msg_val =  '<center><div   class="alert alert-danger">'.$message_functions->showMessage('tenant_email_sent_failed','2004').'</div></center>';
				
		}
	}

	
	
	
}//3









else if(isset($_POST['submit_ind'])){//3

//	echo $distributercode; 

	$active = 'im'; // tab id
	$aup_message = $_POST['aup_message'];
	$full_name = $_POST['full_name'];
	$email = $_POST['email'];
    $username = $_POST['username'];
	$user_msg = $_POST['user_msg'];


	
	if($_SESSION['FORM_SECRET_G3']==$_POST['form_secret_g3']){



		$log = "INSERT INTO `mdu_bulk_emails` (property_id,username,email,create_date,create_user)
		VALUES ('$full_name', '$username', '$aup_message', NOW(), '$user_name')";
		$ex = mysql_query($log); 


		$customer_full_name=$full_name;
		$to = $email;
		$subject = 'Notification';
		$mno_package=$package_functions->getDistributorMONPackage($user_name);
          $MNO=$db->getValueAsf("SELECT mno_id AS f FROM exp_mno WHERE system_package='$mno_package'");
          
          
          $from=strip_tags($db->setVal("email", $mno_id));
          if (empty($from)) {
            $from=strip_tags($db->setVal("email", "ADMIN"));
          }

        /* $from_email_add = strip_tags($db->getValueAsf("SELECT email AS f FROM admin_users WHERE user_name='$user_name'"));

        if($from_email_add == ''){

            $from_email_add = strip_tags($db->setVal("email","MANAGER"));
        } */
			
			
		/* $headers = "From: ".$db->setValDistributor("short_title","MANAGER")."<" . $from_email_add . ">\r\n";
		$headers .= "Reply-To: ". $from_email_add . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
			
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; */
			
			
//echo $user_msg;
		$vars = array(
				'{$user_full_name}' => $customer_full_name,
				'{$user_email}'        => $email,
				'{$user_message}'	=> $user_msg

		);
		
		/* $emailTemplate=$package_functions->getSectionType("EMAIL_TEMPLATE",$my_product);	
	 */
			
		$message_full = strtr($aup_message, $vars);
			
			
		 $message = $message_full;
		
//exit();			
		/* $emailSystem=$package_functions->getSectionType("EMAIL_SYSTEM",$package_functions->getAdminPackage());

		if(strlen($emailSystem)>0){
			require_once ('src/email/'.$emailSystem.'/index.php');
			$emailSystemOb=new email(array('template'=>$emailTemplate));
			$mail_sent=$emailSystemOb->sendEmail($from_email_add,$to,$subject,$message,'','');

		}else {
					$mail_sent = @mail( $to, $subject, $message, $headers );
				} */
			

		
$email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
include_once 'src/email/'.$email_send_method.'/index.php';

//email template
$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
$cunst_var=array();
if($emailTemplateType=='child'){
	$cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$mno_sys_package);
}elseif($emailTemplateType=='owen'){
	$cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
}else{
	$cunst_var['template']=$emailTemplateType;
}

            $cunst_var['system_package'] = $system_package;
            $cunst_var['mno_package'] = $mno_package;
 $cunst_var['mno_id'] = $mno_id;

$mail_obj=new email($cunst_var);
//$mno_package=$package_functions->getDistributorMONPackage($user_name);
$mail_obj->mno_system_package = $mno_package;
$mail_sent=$mail_obj->sendEmail($from,$to,$subject,$message_full,'',$title);

			
		//echo $mail_sent ? "Mail sent" : "Mail failed";
			
		if($mail_sent){
			$email_sent=1;
		}else{
			$email_sent=0;
			
			//////// resend email //////////
			$sys_user = $_SESSION['user_namem'];
			$resend_q = "INSERT INTO `mdu_email_resend` (`to`, `subject`, `headers`, `mail_body`, `send_status`, `create_date`, `create_user`)
			VALUES ('$to', '$subject', '$headers', '$message', '0', NOW(), '$sys_user')";
			$resend = mysql_query($resend_q); 
			//////// resend email ///////////
			
			
		}


		/*

		$response = $nf->UserMessage($email, $user_msg);
		parse_str($response);
		

		if($status_code == 200 || $status == 200){
			echo '<center><div   class="alert alert-success">User Message has been sent</div></center>';
				
		}
		else{
			echo '<center><div   class="alert alert-danger">User Message sending is failed</div></center>';
				
		}

		*/

		if($email_sent){

			$msg_val = '<center><div   class="alert alert-success">'.$message_functions->showMessage('tenant_email_sent_success','2004').'</div></center>';
		}
		else{
			$msg_val = '<center><div   class="alert alert-danger">'.$message_functions->showMessage('tenant_email_sent_failed','2004').'</div></center>';

		}
	}




}//3








else if($_GET['go'] == 'ind'){//4

	$active = 'im';
	//////////Customer Send Notice ///////////////
	if($_SESSION['FORM_SECRET4']==$_GET['token']){

	$mg_customer_id = $_GET['mg_customer_id'];
	$search_id = $_GET['search_id'];
	$record_found=1;


	$send_customer_mail_enable1=1;

	 $get_cust_name=mysql_query("SELECT c.`first_name`,c.`last_name`,c.`email`,c.username,c.`password`,c.room_apt_no,c.`property_id`,o.`org_name`,c.`question_id`,c.`answer`
			FROM `mdu_vetenant` c,`mdu_organizations` o WHERE c.`property_id`=o.`property_id` AND c.`customer_id`='$mg_customer_id' LIMIT 1");
	$rowc=mysql_fetch_array($get_cust_name);
	$mg_first_name=$rowc['first_name'];
	$mg_last_name=$rowc['last_name'];
	$mg_email=$rowc['email'];
			$mg_username=$rowc['username'];
					$mg_password=$rowc['password'];
					$mg_property_id=$rowc['property_id'];
					$mg_org_name=$rowc['org_name'];
					$mg_answer=$rowc['answer'];
			$mg_question_id=$rowc['question_id'];
	$mg_room_apt_no=$rowc['room_apt_no'];
	 
	 
	 
	 
	////////////////APTILO API Call & Get Connected Devices & Plan Details //////
	 
	 
	////////////////////////////////////////////////////////////////////////////////
	 
	 
	 
	 




}else{
	//refresh page error
	$_SESSION['msg']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Transaction is failed</strong></div>";
	header('Location: communicate.php');

}


}//4
















else if(isset($_GET['mg_customer_id'])){//4

	//////////Customer Send Notice ///////////////
	if($_SESSION['FORM_SECRET']==$_GET['token']){

	$mg_customer_id = $_GET['mg_customer_id'];
	$search_id = $_GET['search_id'];
	$record_found=1;


	$send_customer_mail_enable=1;

	$get_cust_name=mysql_query("SELECT c.`first_name`,c.`last_name`,c.`email`,c.username,c.`password`,c.room_apt_no,c.`property_id`,o.`org_name`,c.`question_id`,c.`answer`
			FROM `mdu_vetenant` c,`mdu_organizations` o WHERE c.`property_id`=o.`property_id` AND c.`customer_id`='$mg_customer_id' LIMIT 1");
	$rowc=mysql_fetch_array($get_cust_name);
	$mg_first_name=$rowc['first_name'];
	$mg_last_name=$rowc['last_name'];
	$mg_email=$rowc['email'];
			$mg_username=$rowc['username'];
					$mg_password=$rowc['password'];
					$mg_property_id=$rowc['property_id'];
					$mg_org_name=$rowc['org_name'];
					$mg_answer=$rowc['answer'];
			$mg_question_id=$rowc['question_id'];
	$mg_room_apt_no=$rowc['room_apt_no'];
	 
	 
	 
	 
	////////////////APTILO API Call & Get Connected Devices & Plan Details //////
	 
	 
	////////////////////////////////////////////////////////////////////////////////
	 


	}else{
		//refresh page error
		$_SESSION['msg']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Transaction is failed</strong></div>";
		header('Location: communicate.php');
	
	}


}//4








else if(isset($_GET['id'])){//4
	$active = 'gm_active'; // tab id

	//////////Customer Send Notice ///////////////
	if($_SESSION['FORM_SECRET3']==$_GET['token']){

		$message_id = $_GET['id'];
		
		$log = "UPDATE mdu_bulk_emails_template SET `status` = 9 WHERE id = '$message_id'";
		$ex = mysql_query($log);
	
		if($ex){
		
			$msg_val = '<center><div   class="alert alert-success">Message has been Removed</div></center>';
		}
		else{
			$msg_val =  '<center><div   class="alert alert-danger">Message Removing is failed</div></center>';
		
		}
	}

}











else if(isset($_GET['active'])){//4
	$active = 'gm_active'; // tab id

	//////////Customer Send Notice ///////////////
	if($_SESSION['FORM_SECRET3']==$_GET['token']){

		$message_id = $_GET['active'];

		 
		$disable_others = "UPDATE mdu_bulk_emails_template SET `status` = 0 where distributor = '$mdu_distributor_id' AND `status` <> '9'";
		$ex = mysql_query($disable_others);
		
		
		$get_cust_name=mysql_query("SELECT email FROM mdu_bulk_emails_template WHERE id = '$message_id'");
		$rowc=mysql_fetch_array($get_cust_name);
		$email_name=$rowc['email'];
		
		
/* 		$query_update = "UPDATE mdu_texts SET text_details = '$email_name' WHERE text_code = 'GROUP_MAIL'
		AND user_type='MANAGER' AND distributor = '$mdu_distributor_id'"; */
		
		$query_update = "REPLACE INTO `mdu_texts`(`text_code`,`text_details`,`user_type`,`distributor`,`create_date`,`updated_by`)
		VALUES
		('GROUP_MAIL','$email_name','MANAGER','$mdu_distributor_id',now(),'$user_name')";
		
		
		$ex = mysql_query($query_update);
		
		$log = "UPDATE mdu_bulk_emails_template SET `status` = 1 WHERE id = '$message_id'";
		$ex = mysql_query($log);
		
		

		if($ex){

			$msg_val = '<center><div   class="alert alert-success">Message has been Activated</div></center>';
		}
		else{
			$msg_val = '<center><div   class="alert alert-danger">Message Activation is failed</div></center>';

		}
	}

}
?>
	 <?php
	 if(isset($_GET['page_number'])){
		 $record_found2=1;
		 $search_id2=$_GET['search_id'];
	 }
	 ?>



<body>
<div class="main">
		<div class="main-inner">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="widget ">
							<!-- <div class="widget-header">
                               
								<h3>Add New Tenant Account</h3>
							</div> -->
							<!-- /widget-header -->

							<div class="widget-content" id="now">

								<div class="tabbable">
									<ul class="nav nav-tabs newTabs">
										<li class="active"><a href="#de_acc" data-toggle="tab">Individual Message</a></li>
									    <li><a href="#de_session" data-toggle="tab">Group Message</a></li>
									</ul>
									<br>



                                    <?php
                                    if(isset($_SESSION['msg'])){
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);

                                    }

                                    ?>
									<div class="tab-content">

										<?php echo $msg_val; ?>
                                            <!-- ******************* tenant details ******************* -->
										<div class="tab-pane active" id="de_acc">
									
										<?php if(isset($send_customer_mail_enable1)){ //show send mail area ?>         
                        
                        <h1 class="head"><span>
    Individual Message Editor <img data-toggle="tooltip" title="Please verify that the name in the greeting line is correct and add the description before posting." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>

					
						  
						  
						  
						  
  <form id="edit-profile" class="form-horizontal" method="POST">
								  
								  
								  <?php
								  
								  
								  $cust_query = "SELECT first_name,last_name,email,username FROM mdu_vetenant WHERE customer_id = '$mg_customer_id'";
								  
								  $query_results=mysql_query($cust_query);
								  while($row=mysql_fetch_array($query_results)){
									  $first_name = $row[first_name];
									  $last_name = $row[last_name];
									  $email = $row[email];
									  $username = $row[username];
									  
								  }
								  
								  
								  $secret=md5(uniqid(rand(), true));
								  $_SESSION['FORM_SECRET_G3'] = $secret;
												  
								  echo '<input type="hidden" name="form_secret_g3" id="form_secret_g" value="'.$_SESSION['FORM_SECRET_G3'].'" />';
								  echo '<input type="hidden" name="full_name" id="full_name" value="'.$first_name.' '.$last_name.'" />';
								  echo '<input type="hidden" name="email" id="email" value="'.$email.'" />';
								  echo '<input type="hidden" name="username" id="username" value="'.$username.'" />';
								  
								  $vars_aup = array(
										  '{$user_full_name}' => $first_name.' '.$last_name,
										  '{$user_email},'        => $email
								  
								  );
									  
								  $text_ind = $db->textVal('MDU_IND_MAIL',$distributercode);

							  
								  $message_full = strtr($text_ind, $vars_aup);
								  
								  ?>
								  
									  <fieldset>
									  
									  <!--
							   <div class="control-group">
							  <label class="control-label" for="radiobtns"><strong>User Message :</strong></label>
  
								  <div class="controls">
									  <div class="">	
			  
									  <textarea name="user_msg" id="user_msg" cols="150" style="width:560px; height:40px;" maxlength="256" required ></textarea>
	  
									</div>
								  </div>							
							  </div>   
									  -->				
													  
													  
										  <div class="control-group">
														  
													  </div>
													  
													  
													  
													  <!--  			
					  
												  <h6>TAG Description </h6>
												  User Message : {$user_message}&nbsp;&nbsp; 
												  -->
													  <textarea width="100%" id="aup_message" name="aup_message" class="group_message"><?php echo $message_full; ?></textarea>
																	  
																															  
								  <br>
														  <button type="submit" name="submit_ind" class="btn btn-primary"> Send</button>
			  												<a href="communicate.php?type=im" class="btn btn-primary btn-info-iefix" style="text-decoration:none"><i class="icon-white icon-chevron-left"></i> Go Back</a>
													  <!-- /form-actions -->
												  </fieldset>
											  </form>                        
						  
						  
						  
						  
						  
						  
						  
					   <?php }else{ ?>    

					   <h1 class="head"><span>
    Individual Message <img data-toggle="tooltip" title="You can use this feature to communicate via email directly with an individual tenant. The message will be sent to the tenant's email on record." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1> 
							
							  
							  
								  <div id="email_response"></div>
								  <form id="edit-profile" action="?type=im" method="post" class="form-horizontal middle" >
									 <?php 
									 
					  $secret4=md5(uniqid(rand(), true));
					  $_SESSION['FORM_SECRET4'] = $secret4;
									 
				  
																			  
								  echo '<input type="hidden" name="form_secret4" id="form_secret4" value="'.$_SESSION['FORM_SECRET4'].'" />';
												  
								  ?>
								  
									  <fieldset>
  
									  
													  
													  <div class="control-group" style="display: none;">
														 
														  <div class="controls">

														  	 <label class="" for="radiobtns">Limit Search to</label>
  

															  <div class="">
																  <select name="property_id" id="property_id" required>  
																  <option value="ALL">ALL Groups</option>
  
																  <?php
																  
																 /*  $key_query = "SELECT o.property_number,o.property_id, o.org_name 
																  FROM mdu_organizations o, mdu_system_user_organizations u
																  WHERE o.property_number = u.property_id
																  AND u.user_name = '$user_name'"; */

																  $query_results = $db->get_property($user_distributor);
														  
																 // $query_results=mysql_query($key_query);
																  while($row=mysql_fetch_array($query_results)){
																	  $property_number = $row[property_number];
																	  $property_id = $row[property_id];
																	  $org_name = $row[org_name];
																	  
																	  echo '<option value="'.$property_number.'">'.$property_id.'</option>';
																  }
																  
																  ?>
																  
																  
																  </select>
																  
																  
																  
															  </div>
														  </div>
														  <!-- /controls -->
													  </div>
													  <!-- /control-group -->
													  
																								  
													  
													  
													  <div class="control-group">
														 
														  <div class="controls">

														  	 <label class="" for="radiobtns">Search Tenants <img data-toggle="tooltip" title=" Note: You can search using First Name, Last Name or Email Address." src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"> </label>
  

															  <div class=""> 
																  <input type="text" name="search_word" id="search_word" >
																  <button class="btn btn-primary" type="submit" name="search_btn2" id="search_btn2">Search</button>
																  <br />
																 														
																  
															  </div>
														  </div>
														  <!-- /controls -->
													  </div>
													  <!-- /control-group -->													
										  </fieldset>
									  </form>
											  

											 <?php if($record_found2==1){
  
											 $s_id = "SELECT `customer_list` FROM `mdu_search_id` WHERE id = '$search_id2'";
											 $query_resultss=mysql_query($s_id);
											 $rows=mysql_fetch_array($query_resultss);
											 $customer_list = $rows['customer_list'];
											 $customer_list_array=explode(",",$customer_list);
											 $customer_list_array_count=count($customer_list_array);
											 $default_table_rows=$db->setVal('tbl_max_row_count','ADMIN');
											 if($default_table_rows=="" || $default_table_rows=="0"){
												 $default_table_rows=100;
											 }
											 $page_count=ceil($customer_list_array_count/$default_table_rows);
  
											 if(isset($_GET['page_number'])){
												 $page_number=$_GET['page_number'];
											 }else{
												 $page_number=1;
											 }
											 $start_row_count=($page_number*$default_table_rows)-$default_table_rows;
											 $end_row_count=($page_number*$default_table_rows);
											 $view_customer_list="";
											 for($i=$start_row_count;$i<min($end_row_count,$customer_list_array_count);$i++) {
												 $view_customer_list =$view_customer_list.",".$customer_list_array[$i];
												 $last_row_number=$i;
											 }
											 //  echo $view_customer_list;
											 $view_customer_list=ltrim($view_customer_list,",");
											 $view_customer_list=rtrim($view_customer_list,",");
											 if($page_count!=1){
											 ?>
  
  
										  
													  <?php
  
													  //for ($i = 1; $i <= $page_count; $i++) {
  //														if($page_number==$i){
  //															$active="class=\"active\"";
  //														}else{
  //															$active="";
  //														}
  //														echo "<li ".$active."><a href=\"?page_number=".$i."&search_id=".$search_id2."\">$i</a></li>";
  //
  //													}
													  }
  
													  ?>
											  
											  <script type="text/javascript">
             $(document).ready(function(){

                                    var table = $('#tenent_search_table').DataTable({
                                        dom: 'Bfrtip',
                                       "pageLength": 50,
                                       "language": {
                                          "emptyTable": "No Results"
                                        }
                                        
                                     });

                                    

              });

          </script>
  
												  <div class="widget widget-table action-table">
													  
												  <div class="widget widget-table action-table">
												  <div class="widget-header">
													  <i class="icon-th-list"></i>
													  <h3>Search Results</h3>
												  </div>
												  <!-- /widget-header -->
												  <div class="widget-content">
												  <div>
													  <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap id="tenent_search_table">
														  <thead>
															  <tr>
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><span>First Name</span><i class="icon-sort "></i></th>
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><span>Last Name</span><i class="icon-sort "></i></th>
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><span>Email</span><i class="icon-sort "></i></th>
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3"><span>Group / Realm</span></th>
  
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Action</th>
																  
																  
															  </tr>
														  </thead>
														  <tbody>
								  
					  <?php
  
								  
									  $key_query = "SELECT `username`,`customer_id`,`first_name`,`last_name`,`email`,`property_id`,`room_apt_no`,`first_login_date`
  FROM `mdu_vetenant` WHERE customer_id IN ($view_customer_list) ORDER BY first_name ASC";
					  
								  
  
								  $query_results=mysql_query($key_query);
								  while($row=mysql_fetch_array($query_results)){
									  $customer_id = $row['customer_id'];
									  $username = $row['username'];
									  $first_name = $row['first_name'];
									  $last_name = $row['last_name'];
									  $email = $row['email'];
									  $property_id = $row['property_id'];
									  $room_apt_no = $row['room_apt_no'];
  
									  $rrr = mysql_query("SELECT * FROM `mdu_aup_violation` WHERE username = '$username'");
									  $cunt = mysql_num_rows($rrr);
  
									  $total_warnings = $cunt;
									  
									  $get_property_id_get=mysql_query("SELECT property_id FROM `mdu_organizations` WHERE property_number='$property_id' LIMIT 1");
										  
									  while($rowe=mysql_fetch_array($get_property_id_get)){
										  $property_id_display = $rowe['property_id'];
									  }
																		  
									  echo '<tr>
									  <td> '.$first_name.' </td>
									  <td> '.$last_name.' </td>
									  <td> '.$email.' </td>
									  <td> '.$property_id_display.' </td>';
									  
									  
									  echo '<td class="td_btn">';							
									  echo 'Send Message <a id="C2MAIL_'.$customer_id.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-envelope"></i>&nbsp;GO&nbsp;</a><script type="text/javascript">
  $(document).ready(function() {
  $(\'#C2MAIL_'.$customer_id.'\').easyconfirm({locale: {
		  title: \'Send Customer Message ['.$first_name.' '.$last_name.']\',
		  text: \'Are you sure you want to send a message to this customer?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
		  button: [\'Cancel\',\' Confirm\'],
		  closeText: \'close\'
		   }});
	  $(\'#C2MAIL_'.$customer_id.'\').click(function() {
	  	window.location = "?go=ind&token='.$secret4.'&search_id='.$search_id2.'&mg_customer_id='.$customer_id.'"
		  
	  });
	  });
  </script></td></tr>';
  
  
  
  
  
									  
									  
								  }
  
					  ?>					
								  
								  
									
		  
								  
								  </tbody>
						  </table>
						  <!-- <br>
						  <div><p align="left">
														  Records  <?php echo$start_row_count+1 ?> - <?php echo$last_row_number+1 ?> of <?php echo$customer_list_array_count ?>
													  </p>
													  </div> -->
  
						   <!-- <script>
						   
									   $(document).ready(function() {
						   
										   /*$.fn.DataTable.ext.pager.numbers_length = 5;*/
						   
										   $('#tenent_search_table').DataTable({
											   processing: true,
											   autoWidth: false,
											   language: {
												   "processing": '<img src="layout/DEFAULT_LAYOUT/img/reload.gif" />'
											   },
											   dom: 'r<"top"><"table_response"<"table_response2"t>><"bottom"ip>',
											   serverSide: true,
											   pageLength: 1,
											   columnDefs: [
												   { "orderable": false, "targets": [3,4], }
											   ],
											   ajax: {
						   
												   url: 'ajax/datatable.php',
												   type: 'POST',
												   data: { 
													   length: 1, search_id: "<?php //echo $search_id2; ?>", token: "<?php //echo $secret4; ?>", action: "mdu_communicate"
												   },
												   complete: function(json){
						   
													   var obj = jQuery.parseJSON(json.responseText);
						   
													   document.getElementById('datatable_response').innerHTML=obj.extra;
						   
													   eval(document.getElementById('evalEasyConfirm').innerHTML);
						   
													   setEasyConfirm();
						   
												   }
						   
												
											   }
										   });
						   
									   });
						   
								   </script> -->
  
		  <div id="datatable_response" style="display: none;"></div>
  
						  </div>
													  <script type="text/javascript">
														/*   $(function(){
															  $('#tenent_search_table').tablesorter();
														  }); */
													  </script>
					   </div></div> </div>
					   <?php } else if($record_found2==0) {echo ''; } ?>   
					   
					   
						<?php }  ?>  
					   
  
											
											                        
                                  </div>







                                            <!-- ******************* email ******************* -->
										

<div class="tab-pane <?php if($tab == 'de_session') echo 'active';?>" id="de_session">
							
							

<h1 class="head"><span>
    Group Messaging Editor <img data-toggle="tooltip" title="You can use this feature to communicate via email directly with all tenants at a property. Select the property group to send the email to from the drop-down. The message goes to the tenant's email on record." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>


							
							
							
								<div id="toc_response"></div>
								<form id="edit-profile" class="form-horizontal" method="POST">
								
								
								<?php
								
								$secret=md5(uniqid(rand(), true));
								$_SESSION['FORM_SECRET_G'] = $secret;
												
								echo '<input type="hidden" name="form_secret_g" id="form_secret_g" value="'.$_SESSION['FORM_SECRET_G'].'" />';
												
								?>
								
									<fieldset>
													
													
													
										<div class="control-group" style="display: none;">
														
														<div class="controls">

															<label class="" for="radiobtns">Group / Realm</label>


															<div class="">
																<select name="property_id" id="property_id" onchange="f_change()" required>
																

																<?php
																
																/* $key_query = "SELECT o.property_number,o.property_id, o.org_name 
																FROM mdu_organizations o, mdu_system_user_organizations u
																WHERE o.property_number = u.property_id
																AND u.user_name = '$user_name'"; */

																$query_results = $db->get_property($user_distributor);
														


																//$query_results=mysql_query($key_query);
																//while($row=mysql_fetch_array($query_results)){
																	$property_number = $query_results[0][property_number];
																	$property_id = $query_results[0][property_id];
																	$org_name = $query_results[0][org_name];
																	
																	echo '<option value="'.$property_number.'">'.$org_name.'</option>';
																//}
																
																?>
																
																</select>
																
																
																
															</div>
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->	

										<!-- <div class="control-group">
														
														<div class="controls" style=""> -->

															<label class="" for="radiobtns"><h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;
															</label>


															<div class="">
																				
																<textarea width="100%;" id="group_message" name="group_message" class="group_message"><?php echo $db->textVal('MDU_GROUP_MAIL',$distributercode); ?></textarea>
																
																
																
															</div>
														<!-- </div>
													</div>	 -->	
									
																	
													<!-- <div class="form-actions">	 -->																	
									<br>
														<button type="submit" name="submit_group" class="btn btn-primary" id="email_sa" disabled>Send</button>

													<!-- </div> -->
			
													<!-- /form-actions -->
												</fieldset>
											</form>





										</div>


                                        <!-- *******************email ******************* -->
										



									</div>


								</div>





							</div>
							<!-- /widget-content -->

						</div>
						<!-- /widget -->

					</div>
					<!-- /span8 -->




				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

		</div>
		<!-- /main-inner -->

	</div>
	<!-- /main -->



<?php
include 'footer.php';
?>


<!-- 
<script src="js/jquery-1.7.2.min.js"></script>

	<script src="js/bootstrap.js"></script> -->
	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<!-- tool tip css -->
<link rel="stylesheet" type="text/css" href=    "css/tooltipster-shadow.css" />
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />

<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>



<script >
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

</script>

	<script type="text/javascript" charset="utf-8">

 $(document).ready(function() {
    $("#product_code").chained("#category");

  });
  </script>


	<script type="text/javascript">


	var xmlHttp5;

	function tableBox(type)
	{

		xmlHttp5=GetXmlHttpObject();
		if (xmlHttp5==null)
		 {
			 alert ("Browser does not support HTTP Request");
			 return;
		 }
		var loader = type+"_loader_1";
		var res_div = type+"_div";

		document.getElementById(loader).style.visibility= 'visible';
		var search_customer=document.getElementById("search_customer").value;

		var url="ajax/table_display.php";
		url=url+"?type="+type+"&q="+search_customer+"&dist=<?php echo $user_distributor;?>";


		xmlHttp5.onreadystatechange=stateChanged;
		xmlHttp5.open("GET",url,true);
		xmlHttp5.send(null);

		function stateChanged()
		{
			if (xmlHttp5.readyState==4 || xmlHttp5.readyState=="complete")
			{

				document.getElementById(res_div).innerHTML=xmlHttp5.responseText;
				document.getElementById(loader).style.visibility= 'hidden';
			}
		}
	}











function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

</script>



<!-- datatables js -->

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>


    <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
        tinymce.init({
            selector: "textarea.group_message",
            theme: "modern",
            removed_menuitems: 'visualaid',
            height: 250,
            plugins: [
                "lists charmap",
                "searchreplace wordcount code nonbreaking",
                "contextmenu directionality paste textcolor"
            ],

			init_instance_callback: function (editor) {
    editor.on('Change', function (e) {
  
  f_change();
     
    });
  },
            content_css: "css/content.css",
            toolbar: "undo redo | fontselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",
            font_formats: "Andale Mono=andale mono,times;"+
            "Arial=arial,helvetica,sans-serif;"+
            "Arial Black=arial black,avant garde;"+
            "Book Antiqua=book antiqua,palatino;"+
            "Comic Sans MS=comic sans ms,sans-serif;"+
            "Courier New=courier new,courier;"+
            "Georgia=georgia,palatino;"+
            "Helvetica=helvetica;"+
            "Impact=impact,chicago;"+
            "Symbol=symbol;"+
            "Tahoma=tahoma,arial,helvetica,sans-serif;"+
            "Terminal=terminal,monaco;"+
            "Times New Roman=times new roman,times;"+
            "Trebuchet MS=trebuchet ms,geneva;"+
            "Verdana=verdana,geneva;"+
            "Webdings=webdings;"+
            "Wingdings=wingdings,zapf dingbats"
        });
    </script>

<script>
	


	function f_change() {
		document.getElementById("email_sa").disabled = false;
	}
  </script>
	  
<script type="text/javascript">


    var all_customers=$('#all_customers').DataTable({
        "ordering": false,
        "pageLength": 50,
        "paging":   false,
        "info":     false
    });


    $('#search_customer').on( 'keyup', function () {

		//all_customers.search( this.value ).draw();

    	var new_input = " " + this.value;
      all_customers.search( new_input, false, false ).draw(); 

		
    } );

</script>

<!-- <script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="js/buttons.flash.min.js"></script>
     <script type="text/javascript" src="js/buttons.html5.min.js"></script> -->



</body>