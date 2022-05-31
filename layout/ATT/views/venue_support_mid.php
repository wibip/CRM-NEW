<?php
//echo $user_distributor;
$hgtadle67 = $db->setVal('data_secret','ADMIN');
$private_module=$package_functions->getSectionType('private_module',$package_functions->getAdminPackage());
//$ale=new aaa();

function syncCustomernew($Response1=NULL,$Response2=NULL,$Response3=NULL,$search_id_up,$acc_type=NULL){
$bulk_profile_data2 = json_decode($Response2,true);
//print_r($bulk_profile_data2);

	    $bulk_profile_datasession=$bulk_profile_data2['Description'];
		
		$bulk_profile_data1 = json_decode($Response1,true);
		$bulk_profile_data=$bulk_profile_data1['Description'];

		$bulk_profile_data3 = json_decode($Response3,true);
        //print_r($bulk_profile_data3);
		$bulk_profile_data_pri=$bulk_profile_data3['Description'];
//print_r($bulk_profile_data_pri);        
		$res_arr=array();
		if (!empty($bulk_profile_datasession)>0) {
			if (empty($bulk_profile_data)) {
				$res_arr=$bulk_profile_data_pri;
			}
			elseif (empty($bulk_profile_data_pri)) {
				$res_arr=$bulk_profile_data;
			}
			elseif (empty($bulk_profile_data_pri) && empty($bulk_profile_data)) {
				$res_arr=array();
			}
			else{
				$res_arr=array_merge($bulk_profile_data,$bulk_profile_data_pri);
			}
			if (empty($res_arr)) {
				$res_arrnew=$bulk_profile_datasession;
			}
			else{
				$testarr=array();
				foreach ($res_arr as $key2 => $value2) {
					//print_r($value2['Mac']);
					$aa=$value2['User-Name'];
					array_push($testarr, $aa);
					
				}
				$merge_arr=array();
				foreach ($bulk_profile_datasession as $key => $value) {
					$bb=$value['User-Name'];
					
					if(in_array($bb, $testarr)){
						$newarray=array("Mac"=>$value['Mac'],
		                    "AP_Mac"=> $value['AP_Mac'],
		                    "State" => $value['State'],
		                    "SSID" => $value['SSID'],
		                    "Realm" => $value['Realm'],
		                    "GW_ip" => $value['GW_ip'],
		                    "GW-Type" => $value['GW-Type'],
		                    "Session-Start-Time" => $value['Session-Start-Time'],
		                    "Device-Mac" => $value['Mac'],
		                    "Ses_token"=> $value['Ses_token'],
                            "User-Name"=>$value['User-Name'],
		                    "TYPE"=> $value['TYPE']);
						array_push($merge_arr,$newarray);

					}
					else{
						array_push($merge_arr,$value);
					}
					}
				$res_arrnew=array_merge($res_arr,$merge_arr);
			}
			

		}
		else{
			if (empty($bulk_profile_data)) {
                
				$res_arr=$bulk_profile_data_pri;
			}
			elseif (empty($bulk_profile_data_pri)) {
				$res_arr=$bulk_profile_data;
			}
			else{
				$res_arr=array_merge($bulk_profile_data,$bulk_profile_data_pri);
               
			}
			$res_arrnew=$res_arr;
		}
		
		$resultArray = uniqueAssocArray($res_arrnew, 'User-Name', 'Realm');
		
		$new1=array();
		$new2=array();
		foreach ($resultArray as $value2){
	 	   if (empty($value2['State'])) {
	 	   	array_push($new2,$value2);
	 	   }
	 	   else{
	 	   	array_push($new1,$value2);
	 	   }
	 		}

	 	$finalarray=array_merge($new1,$new2);
		//$finalarray=array($result);
		

		return $finalarray;
	//return $updated;
		
	}


function uniqueAssocArray($array, $uniqueKey, $uniqueKey2) {
    //print_r($array);
  if (!is_array($array)) {
    return array();
  }
  $uniqueKeys = array();
  foreach ($array as $key => $item) {
    if ((!in_array($item[$uniqueKey], $uniqueKeys)) AND (!in_array($item[$uniqueKey2], $uniqueKeys))) {
      $uniqueKeys[$item[$uniqueKey]] = $item;
    }
  }
  return $uniqueKeys;
}


	function httpGet($url)
{
	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//  curl_setopt($ch,CURLOPT_HEADER, false);

	$output=curl_exec($ch);

	curl_close($ch);
	return $output;
}


////////////Tab open////

if(isset($_GET['t'])){

$variable_tab='tab'.$_GET['t'];

$$variable_tab='set';

}else{
	//initially page loading///

	$tab1="set";
}

$details = $db_class1->select1DB("SELECT m.system_package,d.time_zone FROM exp_mno_distributor d JOIN exp_mno m ON d.mno_id=m.mno_id WHERE distributor_code='$user_distributor' LIMIT 1");
//print_r($mno_package[system_package]);
$network_name = $package_functions->getOptions('NETWORK_PROFILE',$details[system_package]);
$tome_zone = $details['time_zone'];

if(strlen($network_name) == 0){
	$network_name = $db_class1->setVal('network_name','ADMIN');
}

$base_url=$db_class1->setVal('global_url','ADMIN');
$internal_url = $db_class1->setVal('camp_base_url','ADMIN');

$net_profile_q = "SELECT ses_creation_method,api_network_auth_method FROM exp_network_profile WHERE network_profile='$network_name'";

$net_profiles = $db_class1->select1DB($net_profile_q);

$session_profile = $net_profiles['ses_creation_method'];
$aaa_profile = $net_profiles['ses_creation_method'];
$network_profile = $net_profiles['api_network_auth_method'];


//$session_profile=$db_class1->getValueAsf("SELECT ses_creation_method as f FROM exp_network_profile WHERE network_profile='$network_name'");
//$aaa_profile=$db_class1->getValueAsf("SELECT ses_creation_method as f FROM exp_network_profile WHERE network_profile='$network_name'");
//$network_profile=$db_class1->getValueAsf("SELECT api_network_auth_method as f FROM exp_network_profile WHERE network_profile='$network_name'");//$db_class1->getValueAsf("SELECT n.`api_network_auth_method` AS f FROM `exp_network_profile` n , `exp_settings` s

//$product=$db_class1->getValueAsf("SELECT `product_code` AS f FROM `exp_products_distributor` WHERE `distributor_code`='$user_distributor' AND `network_type`='GUEST' AND is_enable='1'");
//$tome_zone=$db_class1->getValueAsf("SELECT `time_zone` AS f FROM `exp_mno_distributor` WHERE `distributor_code`=	'$user_distributor'");
$product_details=$db_class1->select1DB("SELECT d.`duration`,p.product_code FROM `exp_products_distributor` p , `exp_products_duration` d 
WHERE d.`profile_code`=p.`duration_prof_code`
AND `distributor_code`='$user_distributor' AND `network_type`='GUEST' AND d.`is_enable`='1'");

$product= $product_details['product_code'];
$time_gap = $product_details['duration'];

if (empty($product)) {
	$query_service_profile = "SELECT `product_code`  
										FROM `exp_products_distributor`
										WHERE distributor_code='$user_distributor' AND `network_type` = 'GUEST'";
$query_results_profile=mysql_query($query_service_profile);
while($row_s=mysql_fetch_array($query_results_profile)){
$product = $row_s['product_code'];
		}
}

$a="SELECT	verification_number AS f FROM exp_mno_distributor WHERE distributor_code ='$user_distributor'";
//$a="SELECT	`group_number` AS f FROM `exp_distributor_groups` WHERE `distributor`='$user_distributor'";
$realm=$db_class1->getValueAsf($a);
$pr_realm=$realm.'P';

require_once('src/sessions/'.$session_profile.'/index.php');
$ale=new session_profile($network_name,$session_profile,$internal_url);
$ale->private_module = $private_module;

require_once('src/AAA/'.$network_profile.'/index.php');
$nf=new aaa($network_name,'');

//add mac ********************************
	if(isset($_POST['add_mac_sessions'])){
		if($_POST[tocked]==$_SESSION['FORM_SECRET']){
		$add_mac=$_POST['add_mac'];
        $set_search_mac_sessions=$add_mac;
		$add_mac=str_replace(":",'',$add_mac);
		$add_mac=str_replace("-",'',$add_mac);
		$add_mac=strtolower($add_mac);
// echo 'src/AAA/'.$network_profile.'/index.php';

			// Set Portal Number (Unique Account Number for Each Device)
			$portal_id =getTempUserName(1);
			$query2 = "INSERT INTO exp_portal_id (assigned_date,portal_id_status,portal_id) values (now(),1,'$portal_id')";
			$query_results=mysql_query($query2);
			$portal_number = $portal_id;
			$token=$_GET['token'];
			//$update_sessions_url=$base_url.'/src/sessions/'.$session_profile.'/index.php?dl_device_sessions&mac='.$add_mac.'&ses_dl_realm='.$realm; //search_mac=device MAC Address
			//httpGet($update_sessions_url);
			/*$rm_device_realm=$_GET['ses_dl_realm'];
			$token=$_GET['token'];
			$sessionresult=$ale->disconnectUserSessions($add_mac,$realm,$token);*/

			 $q2="INSERT INTO `exp_customer` (`email`,`portal_id`,`login_media`,`device_count`,`last_update`) VALUE('$add_mac','$portal_number','MANUAL','1',NOW())";
			mysql_query($q2);

			 $q1="INSERT INTO `exp_customer_sessions_mac` ( `mac`,`distributor_code`,`customer_id`,`create_date`,`last_update`,`portal_id`)
															VALUES('$add_mac','$user_distributor',(SELECT customer_id from exp_customer WHERE portal_id='$portal_number'),NOW(),NOW(),$portal_number)";
			mysql_query($q1);

            $status_code='';
		$response=$nf->createAccount('$portal_number',$add_mac,'','','','','','','',$product,$time_gap,$realm,$internal_url,$token);
		//parse_str($response);
		$newarray= json_decode($response,true);
		//echo $newarray['status_code'];


		if($newarray['status_code']=='200'){
/*			$rm_device_realm=$_GET['rm_device_realm'];
				$token=$_GET['token'];*/
			//$start_sessions_url=$ale->Startsession($add_mac,$rm_device_realm,$token);

			$status_code='';
            $temp_acc = $nf->getNetworkConfig($network_name,'temp_account_creation');
            if($temp_acc=='YES' || $temp_acc == 'BTN'){
                $response2=$nf->updateAccount('new','$portal_number',$add_mac,'','','','','',$add_mac,'',$product,$time_gap,$realm);

                $newarray2= json_decode($response,true);
            }else{
                $newarray2['status_code']='200';
            }


			//parse_str($response2);


			if($newarray2['status_code']=='200'){

				$rm_device_realm=$_GET['rm_device_realm'];
				$token=$_GET['token'];
				/*$status_code='';
				$parameter_array=array();
				$parameter_array['mac']=$add_mac;
				$parameter_array['realm']=$realm;
				$parameter_array['token']=$token;*/

				//$start_sessions_url=$ale->Startsession($add_mac,$rm_device_realm,$token);
				
				if(true){
                    $add_mac_sessions_msg = $message_functions->showNameMessage('device_mac_add_success',$add_mac);
					$_SESSION[add_msg1] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'></button><strong>".$add_mac_sessions_msg."</strong></div>";
				}else{
                    $add_mac_sessions_msg = $message_functions->showNameMessage('device_mac_add_failed',$add_mac,'2009');

					$_SESSION[add_msg2] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'></button><strong>".$add_mac_sessions_msg."</strong></div>";

				}
			}elseif($newarray2['status_code']=='409'){
                $add_mac_sessions_msg = $message_functions->showNameMessage('device_mac_add_failed_duplicate',$add_mac,'2009');
                $_SESSION[msg1] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'></button><strong>".$add_mac_sessions_msg."</strong></div>";
            }else{
                $add_mac_sessions_msg = $message_functions->showNameMessage('device_mac_add_failed',$add_mac,'2009');
				$_SESSION[add_msg3] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'></button><strong>".$add_mac_sessions_msg."</strong></div>";
			}
		}
		elseif($newarray['status_code']=='409'){
            $add_mac_sessions_msg = $message_functions->showNameMessage('device_mac_add_failed_duplicate',$add_mac,'2009');
			$_SESSION[msg1] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'></button><strong>".$add_mac_sessions_msg."</strong></div>";
		}else{
            $add_mac_sessions_msg = $message_functions->showNameMessage('device_mac_add_failed',$add_mac,'2009');
			$_SESSION[msg1] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'></button><strong>".$add_mac_sessions_msg."</strong></div>";
		}
	}else{
            $add_mac_sessions_msg = $message_functions->showMessage('transection_fail','2004');
			$_SESSION[msg1] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'></button><strong>".$add_mac_sessions_msg."</strong></div>";
		}
	}

// delete device**********************
	if(isset($_GET['rm_device_mac'])){
		if($_GET['token']==$_SESSION['FORM_SECRET']){
			$rm_device_mac=$_GET['rm_device_mac'];
			$rm_device_realm=$_GET['rm_device_realm'];
			$rm_session_token=$_GET['rm_session_token'];
			$token=$_GET['token'];

			//DELETE DEVICE SESSIONS API
			//$update_sessions_url=$base_url.'/src/sessions/'.$session_profile.'/index.php?session_dl='.$row[session_id].'&mac='.$rm_device_mac.'&ses_realm='.$rm_device_realm; //
			//$sessionresult=$ale->disconnectUserSessions($rm_device_mac,$rm_device_realm ,$token);
                //httpGet($update_sessions_url);
           
            //$network_user=$rm_device_mac.'@'.$rm_device_realm;
			$response=$nf->deleteAccount($rm_device_mac, $rm_device_realm);
			


			$newarray= json_decode($response,true);
			$newarray['status_code'];
			
			if($newarray['status_code']=='200'){
				$responsenew=$ale->delSessions($rm_device_mac,$rm_device_realm,$rm_session_token);
			 	$rm_device_mac_msg = $message_functions->showMessage('device_demove_success');

				// $delete_mac = $rm_device_mac;
				$_SESSION[add_msg1] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'></button><strong>".$rm_device_mac_msg."</strong></div>";

			}else{
                $rm_device_mac_msg = $message_functions->showMessage('device_remove_failed','2009');

				$_SESSION[add_msg3] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'></button><strong>".$rm_device_mac_msg."</strong></div>";
			}
		}else{
            $rm_device_mac_msg = $message_functions->showMessage('transection_fail','2004');
			$_SESSION[msg1] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'></button><strong>".$rm_device_mac_msg."</strong></div>";
		}

		//sleep(8);
	}
// send log id**********************
	if(isset($_POST['submit_log'])){
		if($_POST['token']==$_SESSION['FORM_SECRET']){
			$log_id=$_POST['log_id'];

			$to=$db_class1->setVal('email','ADMIN');
			$subject = 'Error log submit';

			$headers = "From: " . $db_class1->getValueAsf("SELECT `email` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'") . " Admin <" . strip_tags($db_class1->getValueAsf("SELECT `email` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'")) . ">\r\n";
			$headers .= "Reply-To: " . strip_tags($db_class1->getValueAsf("SELECT `email` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'")) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


			$message = 'Error log id : '.$log_id.'<br/>Icomms Number :' .$db_class1->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'");


			$mail_sent = @mail( $to, $subject, $message, $headers );
			if($mail_sent){
				$_SESSION[msg2] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'> � </button><strong> Log ID submitted successfully </strong></div>";
			}else{
				$_SESSION[msg2] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> � </button><strong> Log ID submition failed</strong></div>";
			}
		}else{
			$_SESSION[msg2] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'> x </button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";

		}
	}

	// delete session**********************
	if(isset($_GET['rm_session_mac'])){
		if($_GET['token']==$_SESSION['FORM_SECRET']){
			//$rm_session_mac=$_GET['rm_session_mac'];

			 $mac=$_GET['mac'];
			 $state=$_GET['state'];
			 $token=$_GET['token'];
			 $rm_session_token=$_GET['rm_session_token'];
			 $rm_session_realm=$_GET['rm_session_realm'];

			 $removed_session_array = array();

				 //$rm_session_id_fom_all = $row1[session_id];



				 if(strlen($rm_session_realm)>0){

					 //$remove_session_url=$base_url.'/src/sessions/'.$session_profile.'/index.php?session_dl='.$rm_session_id_fom_all.'&mac='.$mac.'&ses_realm='.$realm; //rm_session=Session ID
					 //$responceold=httpGet($remove_session_url);
					 

					$response=$ale->delSessions($mac,$rm_session_realm,$rm_session_token);

					$newarray= json_decode($response,true);
					
					if($newarray['status_code']=='200'){

						// $delete_mac = $mac;
						 $_SESSION[add_msg3] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'> x </button><strong>".$message_functions->showMessage('session_remove_success','2009')."</strong></div>";

					}
					else{

						$failed = 1;
						$_SESSION[add_msg3] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> x </button><strong>".$message_functions->showMessage('session_remove_fail','2009')."</strong></div>";

					}

				 }

			

            sleep(5);

		}else{
			$_SESSION[msg1] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'> � </button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";

		}

	}


	//Search all sessions
	if(isset($_POST['all_search']) || isset($_GET['all_search'])){
		//$url_base_exp_sessions = $base_url . '/src/sessions/'.$session_profile.'/index.php?realm=' .$realm ;
		//echo $url_base_exp_sessions;
		/*
		$result1 = $ale->getSessionsbyrealm($realm);*/
		//$respon = httpGet($url_base_exp_sessions);


		$sessionresult=$ale->getSessionsbyrealm($realm,$tome_zone);
		//print_r($sessionresult);
		$result=$nf->checkRealmAccount($realm,'Guest');
		$search_id=uniqid();

		$newjsonvalue=syncCustomernew($result,$sessionresult,$result2,$search_id);
		

                if($private_module==1){
		//print_r($sessionresult);
		$result2=$nf->checkRealmAccount($pr_realm,'Private');
		$search_id=uniqid();
		$newjsonvalue=syncCustomernew($result,$sessionresult,$result2,$search_id);
                }        
	}

	//search session***********************
	if(isset($_POST['search_mac_sessions']) || isset($set_search_mac_sessions) || isset($_GET['search_mac_sessions']) ){
		if(isset($_POST['search_mac_sessions'])){
			$session_search_mac=$_POST['search_mac'];
		}elseif(isset($set_search_mac_sessions) ){
			$session_search_mac=$set_search_mac_sessions;
		}elseif(isset($_GET['search_mac_sessions'])){
			$session_search_mac=$_GET['search_mac_sessions'];
		}
		$session_search_mac=str_replace(":",'',$session_search_mac);
		$session_search_mac=str_replace("-",'',$session_search_mac);
		$session_search_mac=strtolower($session_search_mac);
				
		$sessionresult=$ale->getSessionsbymac($session_search_mac,$realm,$tome_zone);
		$result=$nf->checkMacAccount($session_search_mac,$realm,'Guest');
		
		$search_id=uniqid();
		$newjsonvalue=syncCustomernew($result,$sessionresult,$result2,$search_id);

		
		$aaa_user_name=$session_search_mac.'@'.$realm;
		//print_r($result);
		$search_id=uniqid();
                                
                if($private_module==1){ 
        $result2=$nf->checkMacAccount($session_search_mac,$pr_realm,'Private');
		//print_r($result);
		$search_id=uniqid();
		$newjsonvalue=syncCustomernew($result,$sessionresult,$result2,$search_id);
                }
	}




//
//if (isset($_POST['access_lg'])) {
//	//echo "string";
//	if($_SESSION['FORM_SECRET']==$_POST['form_secret']){
//
//		$query_2 = "SELECT L.id AS id, E.`status_id`,E.`description`,L.`access_details`,S.`location_id`,S.`token_id`,S.`mac`,S.`ssid`,S.`customer_id`,C.`email`,L.`create_date`
//									FROM exp_points_logs L,exp_points E,exp_customer_session S
//									left join `exp_customer` C
//									on S.`customer_id`= C.`customer_id`
//									WHERE E.`status_id`=L.`access_id`
//									AND S.`token_id`=L.`token`
//
//									AND S.`location_id`= '$user_distributor'";
//
//		/*"SELECT E`status_id`,E`description`,L.`token`,L.`access_details`,L.`create_date`
//                            FROM `exp_points` p, `exp_points_logs` l
//                            WHERE E`status_id`=L.`access_id`";*/
//
//		if ($_POST['ssid2'] != NULL) {
//			$ssid2 = $_POST['ssid2'];
//			$query_2 .= " AND `ssid`='".$ssid2."'";
//		}
//
//		if ($_POST['mac2'] != NULL) {
//			$mac2 = $_POST['mac2'];
//			$query_2 .= " AND `mac`='".$mac2."'";
//		}
//
//		if ($_POST['email_2'] != NULL) {
//			$email_2 = $_POST['email_2'];
//			//echo $email_2;
//			$query_2 .= " AND `email`='".$email_2."'";
//		}
//
//		if ($_POST['start_date2'] != NULL && $_POST['end_date2'] != NULL) {
//			$mg_end2 = $_POST['end_date2'];
//			$mg_start2 = $_POST['start_date2'];
//			$mg_start_date2 = date_format(date_create($_POST['start_date2']),'Y-m-d').' 00:00:00';
//			$mg_end_date2 = date_format(date_create($_POST['end_date2']),'Y-m-d').' 23:59:59';
//			$query_2 .= " AND L.`create_date` BETWEEN '".$mg_start_date2."' AND '".$mg_end_date2."'";
//		}else{
//			$mg_end_date2 = "";
//			$mg_start_date2 = "";
//		}
//
//		$query_2 .= " ORDER BY S.session_starting_time DESC, L.token DESC, L.id";
//
//		if ($_POST['limit2'] != NULL) {
//			$limit2 = $_POST['limit2'];
//			$query_2 .= " LIMIT ".$limit2;
//		}else{
//			$query_2 .= " LIMIT 50";
//		}
//
////				echo $query_2;
//		$query_results2 = mysql_query($query_2);
//	}
//}
//



//api_logs
/*if (isset($_POST['api_lg'])) {





	$limit_api = $_POST['limit_api'];

	$a="SELECT	`group_number` AS f FROM `exp_distributor_groups` WHERE `distributor`='$user_distributor'";
	$api_realm=$db_class1->getValueAsf($a);

	//$uname_ap_lg=$_SESSION['user_name'];
	//$api_realm = $db_class->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_name`='$uname_ap_lg' LIMIT 1");

	$start_date_apia = $_POST['start_date_api'];
	$end_date_apia = $_POST['end_date_api'];

	$function = $_POST['function_select'];

	if($_SESSION['FORM_SECRET']==$_POST['form_secret']){


		if ($_POST['start_date_api'] != NULL && $_POST['end_date_api'] != NULL) {
			if ($_POST['limit_api'] != NULL) {
				$limit_api = $_POST['limit_api'];
			}
			else {
				$limit_api = 100 ;
			}

			$start_date_api = date_format(date_create($_POST['start_date_api']),'Y-m-d').' 00:00:00';
			$end_date_api = date_format(date_create($_POST['end_date_api']),'Y-m-d').' 23:59:59';

			$d_start = new DateTime($start_date_api, new DateTimeZone($log_time_zone));
     		$mg_start_date_tz = $d_start->getTimestamp();

     		$d_end = new DateTime($end_date_api, new DateTimeZone($log_time_zone));
     		$mg_end_date_tz = $d_end->getTimestamp();

			if($_POST['function_select'] != NULL){
				$function = $_POST['function_select'];
				if ($function=="all"){



						$query_api = "SELECT * FROM `exp_wag_ap_profile_logs` WHERE realm='".$api_realm."' AND (unixtimestamp BETWEEN '".$mg_start_date_tz."' AND '".$mg_end_date_tz."') ORDER BY create_date DESC LIMIT $limit_api";
						$query_api_results = mysql_query($query_api);



				}
				else {



						$query_api = "SELECT * FROM `exp_wag_ap_profile_logs` WHERE realm='".$api_realm."' AND (function ='$function') AND (unixtimestamp BETWEEN '".$mg_start_date_tz."' AND '".$mg_end_date_tz."') ORDER BY create_date DESC LIMIT $limit_api";
						$query_api_results = mysql_query($query_api);



				}

			}
			else {



					$query_api = "SELECT * FROM `exp_wag_ap_profile_logs` WHERE realm='".$api_realm."' AND unixtimestamp BETWEEN '".$mg_start_date_tz."' AND '".$mg_end_date_tz."' ORDER BY create_date DESC LIMIT $limit_api";
					$query_api_results = mysql_query($query_api);


			}



		}else {
			if ($_POST['limit_api'] != NULL) {
				$limit_api = $_POST['limit_api'];
			}
			else {
				$limit_api = 100 ;
			}
			if ($function=="all"){



					$query_api = "SELECT * FROM `exp_wag_ap_profile_logs` WHERE realm='".$api_realm."' ORDER BY create_date DESC LIMIT $limit_api";
					$query_api_results = mysql_query($query_api);


			}
			else{



					$query_api = "SELECT * FROM `exp_wag_ap_profile_logs` WHERE realm='".$api_realm."' AND (function ='$function') ORDER BY create_date DESC LIMIT $limit_api";
					$query_api_results = mysql_query($query_api);




			}
		}





	}

	//echo $query_api;
}


//Error log search
if (isset($_POST['error_lg'])) {
	if($_SESSION['FORM_SECRET']==$_POST['form_secret']){


		$query_error_lg = "SELECT E.`error_id`,E.`description`,L.`error_details`,S.`location_id`,S.`token_id`,S.`mac`,S.`ssid`,S.`customer_id`,C.`email`,L.`create_date`
		FROM exp_error_log L,exp_errors E,exp_customer_session S
		left join `exp_customer` C
		on S.`customer_id`= C.`customer_id`
		WHERE E.`error_id`=L.`error_id`
		AND S.`token_id`=L.`token`
		AND S.`location_id`= '$user_distributor'";

		if ($_POST['ssid'] != NULL) {
			$ssid = $_POST['ssid'];
			$query_error_lg .= " AND `ssid`='".$ssid."'";
		}

		if ($_POST['mac3'] != NULL) {
			$mac3 = $_POST['mac3'];
			$query_error_lg .= " AND `mac`='".$mac3."'";
		}

		if ($_POST['email'] != NULL) {
			$email = $_POST['email'];
			$query_error_lg .= " AND `email`='".$email."'";
		}

		if ($_POST['start_date'] != NULL && $_POST['end_date'] != NULL) {

			$mg_end = $_POST['end_date'];
			$mg_start = $_POST['start_date'];

			$mg_start_date = date_format(date_create($_POST['start_date']),'Y-m-d').' 00:00:00';
			$mg_end_date = date_format(date_create($_POST['end_date']),'Y-m-d').' 23:59:59';
			$query_error_lg .= " AND L.`create_date` BETWEEN '".$mg_start_date."' AND '".$mg_end_date."'";
		}else{
			$mg_end_date = "";
			$mg_start_date = "";
		}

		$query_error_lg .= " ORDER BY L.`id` DESC";

		if ($_POST['limit'] != NULL) {
			$limit = $_POST['limit'];
			$query_error_lg .= " LIMIT ".$limit;
		}else{
			$limit=100;
			$query_error_lg .= " LIMIT ".$limit;
		}

//		echo $query_error_lg;
		$result_error_lgs = mysql_query($query_error_lg);
		if ($result_error_lgs) {

		}
	}
}*/


$secret=md5(uniqid(rand(), true));

$_SESSION['FORM_SECRET'] = $secret;


?>
<script type="text/javascript">
    function checkSessionDeleted(realm,mac,callback) {

        var URL = 'ajax/checkSessionDeleted.php';

        var init_auth_data = {realm:realm,mac:mac};
        init_auth_data= JSON.stringify(init_auth_data);
        init_auth_data = CryptoJS.AES.encrypt(JSON.stringify(init_auth_data), '<?php echo $hgtadle67; ?>', {format: CryptoJSAesJson}).toString();
        var returnData;
        $.ajax({
            url : URL,
            type: "POST",
            data : {key:init_auth_data},
            success: function(msg, status, jqXHR)
            {
                //alert(msg);
                callback(msg);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert("Network Error");
            }
        });

    }

</script>
<style type="text/css">
@media (max-width: 767px){
    .main {
        margin-top: 0px !important;
    }
}

</style>
<style type="text/css">
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
    padding-left: 30% !important;
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
  }

  body {
    background: #ffffff !important;
}

h1.head {
    padding: 0px;
    padding-bottom: 40px;
    width: 960px;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #000;
    font-family: Rbold;
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


</style>
<div class="main">

	<div class="main-inner">

		<div class="container">

			<div class="row">

				<div class="span12">

					<div class="widget ">

						<div class="widget-header" style="display: none;">

							<!-- <i class="icon-wrench"></i> -->

							<h3>Tier 1 Support</h3>

						</div>
                        <?php
                        if(isset($_SESSION['msg1'])){
                            echo $_SESSION['msg1'];
                            unset($_SESSION['msg1']);

                        }
                        if(isset($_SESSION['add_msg1'])){
                            echo $_SESSION['add_msg1'];
                            unset($_SESSION['add_msg1']);

                        }
                        if(isset($_SESSION['add_msg2'])){
                            echo $_SESSION['add_msg2'];
                            unset($_SESSION['add_msg2']);

                        }
                        if(isset($_SESSION['add_msg3'])){
                            echo $_SESSION['add_msg3'];
                            unset($_SESSION['add_msg3']);

                        }

                        if(isset($_SESSION['msg2'])){
                            echo $_SESSION['msg2'];
                            unset($_SESSION['msg2']);


                        }

                        if(isset($_SESSION['msg4'])){
                            echo $_SESSION['msg4'];
                            unset($_SESSION['msg4']);


                        }

                        if(isset($_SESSION['msg5'])){
                            echo $_SESSION['msg5'];
                            unset($_SESSION['msg5']);

                        }

                        ?>

						<!-- /widget-header -->



						<div class="widget-content">

							<div class="tabbable">

								<ul class="nav nav-tabs">

									<?php if(in_array('VEN_SUP_SUPPORT',$features_array) || $package_features=="all"){ ?>
										<li <?php if(isset($tab1)){?>class="active" <?php }?>><a href="#manually_add" data-toggle="tab">Tier 1 Support</a></li>
									<?php } if(in_array('VEN_SUP_ACCESSLOG',$features_array) || $package_features=="all"){ ?>
										<li <?php if(isset($tab2)){?>class="active" <?php }?>><a href="#support_log" data-toggle="tab">Access Logs</a></li>
									<?php } if(in_array('VEN_SUP_ERRORLOG',$features_array) || $package_features=="all"){ ?>
										<li <?php if(isset($tab4)){?>class="active" <?php }?>><a href="#error_logs" data-toggle="tab">Error Logs</a></li>
									<?php } if(in_array('VEN_SUP_APLOG',$features_array) || $package_features=="all"){ ?>
										<li <?php if(isset($tab3)){?>class="active" <?php }?>><a href="#support_log_api" data-toggle="tab">AP Controller Logs</a></li>
									<?php } ?>
								</ul>

							<div class="tab-content">
                                <br>

                                                                    <?php 

                                    if($new_design=='yes'){

$venue_inner = 'layout/'.$camp_layout.'/views/venue_inner.php';

  if (file_exists($venue_inner)) {
        include_once $venue_inner;
  } 
  }
 ?>

								<?php if(in_array('VEN_SUP_SUPPORT',$features_array) || $package_features=="all"){ ?>
								<div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="manually_add">


									<h1 class="head" style="display: none;">Manually onboard a customer device</h1>

									<h2>Device and Session Management</h2>
									<br/>


								
								<p><b>LIST ALL DEVICES: </b>Clicking this button will return a list of all devices currently registered at the location. The devices can either have active or inactive sessions.
								</p>
									<p><b>SEARCH FOR A DEVICE: </b>Enter the MAC Address of the device in the Search dialog and click "Search" to determine if the device is registered and has an active or inactive session.
									</p>
									<p><b>DELETE DEVICE OR REMOVE A SESSION: </b>Once you have identified a device you have the option to delete the device and/or remove the session. If a device is deleted, that device has to re-register to get online once its current session expires. If a session is removed, that device will automatically get a new session if the device is registered. Or if the device has been deleted, the session can be removed to immediately end that session.
									</p>

									<br/>

								<form action="?t=1" id="mac_search" class="form-horizontal" method="post">
									<fieldset>
										<div class="control-group">
										<div class="controls form-group">
                                            <input type="text" class="span3 form-control" name="search_mac" id="search_mac" placeholder="xx:xx:xx:xx:xx:xx" autocomplete="off" data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. Acceptable formats are: aa:bb:cc:dd:ee:ff, aa-bb-cc-dd-ee-ff, or aabbccddeeff in lowercase or all CAPS." />

                                            <button type="submit" name="search_mac_sessions" id="search_mac_sessions" class="btn btn-primary inline-btn"><i class="btn-icon-only icon-search"></i> Search</button>

                                            <a data-toggle="tooltip" title="List All devices button will display Active Authenticated Clients on Network" name="all_search" id="all_search" class="btn btn-info inline-btn"  onclick="manual_btn();"><i class="btn-icon-only icon-search"></i> List All Devices</a>
                                            <img id="tooltip1" data-toggle="tooltip" title="Use the List All Devices button to see how many devices are registered and online right now. Or use the field and Search button to find a specific device using its MAC address." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">
                                            <?php $session_down_key_string = "uni_id_name=Customer Sessions&task=all_sessions&user_distributor=".$user_distributor."&realm=".$realm."&session_profile=".$session_profile."&network_name=".$network_name."&internal_url=".$internal_url;
										
                                                                                                        
                                                    $session_down_key =  cryptoJsAesEncrypt($data_secret,$session_down_key_string);
                                                    $session_down_key =  urlencode($session_down_key);
                                                    ?>
                                                    <a href='ajax/export_customer.php?key=<?php echo $session_down_key?>' class="btn btn-primary" style="text-decoration:none">
                                                        <i class="btn-icon-only icon-download"></i> Download Sessions
                                                    </a>

									</div>
									<br/>
								
												<br/>
											<script type="text/javascript">

											function manual_btn() {
												window.location = "?all_search=1";
											}

											
											</script>

										</div>
									</fieldset>
								</form>

									<form action="?t=1" class="form-horizontal">
									<div class="widget widget-table action-table tablesaw-minimap-mobile">
										<div class="widget-header">
											<!-- <i class="icon-th-list"></i> -->
											<h3>Devices & Sessions</h3>
										</div>
										<div class="widget-content table_response">

											<?php 

												$default_table_rows=$db->setVal('tbl_max_row_count','ADMIN');

												if($default_table_rows=="" || $default_table_rows=="0"){
					                                 $default_table_rows=50;
					                            }

											 ?>
											<div style="overflow-x:auto">
								   <style>  
                                     .dataTables_length{
                                       padding: 5px;
                                       float: right !important;
                                     }
         
                                     .dataTables_length label{
                                       margin-bottom: 0px !important;
                                     }
                                     .dataTables_length select{
                                       margin-left: 5px !important;
                                       width: 80px !important;
                                     }
         
                                     #tenent_search_table th{
                                       border-top: 1px solid #ddd !important;
                                       background-color: #f4f4f4;
                                     }
           
                                     
                                     .dataTables_info{
                                       margin-left: 10px;
                                     }
                                   </style>
								<script type="text/javascript">
                                   $(document).ready(function(){
                                     $('#device_sessions').DataTable({
                                       "pageLength": <?php echo $default_table_rows; ?>,
                                       "columns": [
                                         null,
                                         null,
                                         null,
                                         <?php if($private_module==1){ ?>
                                         null,
                                         <?php } ?>
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         { "orderable": false },
                                         { "orderable": false }
                                       ],
                                       "autoWidth": false,
                                       "language": {
                                          "emptyTable": "No Device"
                                        },
                                       /*"language": {
                                         "lengthMenu": "Per page _MENU_ "
                                      },
         */
                                      "bFilter" : false,  
         
                                       "lengthMenu": '[[100, 250, 500, -1], [100, 250, 500, "All"]]'
         
                                     });
                                   });
                                 </script>
									<table id="device_sessions" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
										<thead>
										<tr>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Device MAC</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">AP MAC/GW MAC</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Session State</th>
										<?php	if($private_module==1){
										                ?>
										                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Session Type</th>     
										                <?php
										        }   
										?>
											
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">SSID</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Customer Account #</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">GW IP</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">GW Type</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Session Start Time</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Delete Device</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Remove Session
												<img id="tooltip1" data-toggle="tooltip" title="Redirect Session deletion may take up to several minutes to be recognized and removed from the table. If deletion is a success wait 2 minutes and then refresh this page." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 0px;cursor: pointer;display:  inline-block;"></th>
										</tr>

										</thead>
										<tbody>
										<?php
										if(isset($_POST['search_mac_sessions']) || isset(
											$set_search_mac_sessions) || isset($_GET['search_mac_sessions'])) {
											//print_r($newjsonvalue);
											if (!$newjsonvalue) {
												//echo "<td colspan=\"1\">No Device</td>";
												//echo "<td colspan=\"10\">No Sessions</td>";
											}
											$session_row_count=0;
											foreach ($newjsonvalue as $value2) {
												$next_search_pram='search_mac_sessions';
												$session_row_count=$session_row_count+1;
												
												echo "<tr>";
												$mac=($value2['Mac']);
												$AP_Mac=($value2['AP_Mac']);
												$nas_type=($value2['Nas-Type']);
												$newstate=($value2['State']);
												if (empty($value2['State'])) {
													$value2['State']="No Session/offline";
												}
												$state=($value2['State']);
												$ssid=($value2['SSID']);
												$GW_ip=($value2['GW_ip']);
												$sh_realm=($value2['Realm']);
												$GW_Type=($value2['GW-Type']);
												$start_time=($value2['Session-Start-Time']);
                                                $ses_type = $value2['session_type'];
                                                $device_mac= $value2['Device-Mac'];
                                                $type= $value2['TYPE'];
                                                $ses_id= $value2['Ses_token'];
												
												if (strlen($mac)<1) {
                                                    		$mac="N/A"; }
                                                if (strlen($AP_Mac)<1) {
                                                    		$AP_Mac="N/A"; }
                                                if (strlen($ssid)<1) {
                                                    		$ssid="N/A"; }
                                                if (strlen($type)<1) {
                                                    		$type="N/A"; }
                                                if (strlen($GW_ip)<1) {
                                                    		$GW_ip="N/A"; }
                                                if (strlen($sh_realm)<1) {
                                                    		$sh_realm="N/A"; }
                                                if (strlen($GW_Type)<1) {
                                                    		$GW_Type="N/A"; }
                                                if (strlen($start_time)<1) {
                                                    		$start_time="N/A"; }

												echo "<td>".$db->macFormat($mac,$mac_format)."</td>";
												echo "<td>".$AP_Mac."</td>";
												echo "<td>".$state."</td>";
												if($private_module==1){
										         echo "<td>".$type."</td>";
										        } 
												
												echo "<td>".$ssid."</td>";
												echo "<td>".$sh_realm."</td>";
												echo "<td>".$GW_ip."</td>";
												echo "<td>".$GW_Type."</td>";
												echo "<td>".$start_time."</td>";

											echo '<td>';
											
												if(strlen($device_mac)>0) {
													echo '<a id="' . $session_row_count . 'DEVICE_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>
														<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#' . $session_row_count . 'DEVICE_DELETE_' . $mac . '\').easyconfirm({locale: {
                                                                    title: \'Delete Device\',
                                                                    text: \'Are you sure you want to Delete this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#' . $session_row_count . 'DEVICE_DELETE_' . $mac . '\').click(function() {
                                                                    window.location = "?token=' . $secret . '&t=1&rm_device_realm='.$sh_realm.'&rm_session_token='.$ses_id.'&rm_device_mac=' . $mac . '&' . $next_search_pram . '=' . $mac . '"
                                                                });
                                                                });
                                                        </script>
														';
												}
												else{
													 echo '<a disabled   id="' . $session_row_count . 'DEVICE_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>'; 

														
												}
												echo '</td>';

											 echo '<td>';
											 if ($state=='Inactive' && $nas_type=='ac') {
												echo '<a  class="btn  btn-small td_btn_last disabled" data-toggle="tooltip" title="The system does not allow to delete inactive sessions">
                                      <i class="btn-icon-only icon-trash"></i>Remove</a>';
											}
											else{ 
													if(strlen($ses_id)>0 && $_GET['rm_session_mac']!=$mac){
													echo'<a href="" id="'.$session_row_count.'SESSION_DELETE_' . $mac .'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
														<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#'.$session_row_count.'SESSION_DELETE_' . $mac .'\').easyconfirm({locale: {
                                                                    title: \'Remove Session\',
                                                                    text: \'Are you sure you want to Remove this session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#'.$session_row_count.'SESSION_DELETE_' . $mac .'\').click(function() {
                                                                    window.location = "?token=' . $secret . '&rm_session_realm='.$sh_realm.'&rm_session_token='.$ses_id.'&mac='.$mac.'&state='.$state.'&t=1&rm_session_mac='.$mac.'&' . $next_search_pram . '=' . $mac . '"
                                                                });
                                                                });
                                                        </script>
														
														'; }
														elseif ($_GET['rm_session_mac']==$mac){
                                                        echo'<a disabled id="'.$session_row_count.'SESSION_DELETE_' . $mac.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
														<script type="text/javascript">
														var deleteSessionCheck'.$mac.' = function (){
														    checkSessionDeleted(\''.$sh_realm.'\',\''.$mac.'\',function(data){
														        
														    if(data == \'0\'){
														    
                                                                $(\'#'.$session_row_count.'SESSION_DELETE_'.$mac.'\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
														    }else{
														        deleteSessionCheck'.$mac.'();
														    }   
														});
														    
														}
														deleteSessionCheck'.$mac.'();
                                                        </script>
														';

                                                    }
														else{
															echo'<a disabled id="'.$session_row_count.'SESSION_DELETE_' . $mac.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>';
														}
													}
											echo'</td>'; 
											 echo "</tr>";
											}
											
										}


										//=============================================
										elseif(isset($_POST['all_search']) || isset($_GET['all_search'])){
											$next_search_pram='all_search';
                                            $next_search_value='all_search';
                                            if (!$newjsonvalue) {
                                            	//echo "<td colspan=\"1\">No Devices</td>";
												//echo "<td colspan=\"10\">No Sessions</td>";
												
											}

											
											$session_row_count=0;
											foreach ($newjsonvalue as $value2) {
												$session_row_count=$session_row_count+1;
												
												echo "<tr>";
												$mac=($value2['Mac']);
												$AP_Mac=($value2['AP_Mac']);
												$nas_type=($value2['Nas-Type']);
												$ssid=($value2['SSID']);
												$GW_ip=($value2['GW_ip']);
												$sh_realm=($value2['Realm']);
												$GW_Type=($value2['GW-Type']);
												$start_time=($value2['Session-Start-Time']);
												$newstatus=$value2['State'];
                                                $ses_type = $value2['session_type'];
                                                $device_mac= $value2['Device-Mac'];
                                                $type= $value2['TYPE'];
                                                $ses_id= $value2['Ses_token'];
												
												if (empty($value2['State'])) {
													$value2['State']="No Session/offline";
												}
												$state=($value2['State']);
												
												
                                                  if (strlen($mac)<1) {
                                                    		$mac="N/A"; }
                                                if (strlen($state)<1) {
                                                    		$state="N/A"; }
                                                if (strlen($type)<1) {
                                                    		$type="N/A"; }
                                                if (strlen($AP_Mac)<1) {
                                                    		$AP_Mac="N/A"; }
                                                if (strlen($ssid)<1) {
                                                    		$ssid="N/A"; }
                                                if (strlen($GW_ip)<1) {
                                                    		$GW_ip="N/A"; }
                                                if (strlen($sh_realm)<1) {
                                                    		$sh_realm="N/A"; }
                                                if (strlen($GW_Type)<1) {
                                                    		$GW_Type="N/A"; }
                                                if (strlen($start_time)<1) {
                                                    		$start_time="N/A"; }

												echo "<td>".$db->macFormat($mac,$mac_format)."</td>";
												echo "<td>".$AP_Mac."</td>";
												echo "<td>".$state."</td>";
												if($private_module==1){
										         echo "<td>".$type."</td>";
										        }
												echo "<td>".$ssid."</td>";
												echo "<td>".$sh_realm."</td>";
												echo "<td>".$GW_ip."</td>";
												echo "<td>".$GW_Type."</td>";
												echo "<td>".$start_time."</td>";
											 /*foreach ($value2 as $key => $value) {
											 	//$session_row_count++;

											 	if (strlen($value)<1) {
											 		$value="N/A";
											 		# code...
											 	}
											 	echo "<td>".$value."</td>";
											 	

											 }*/


											 echo '<td>';
												if(strlen($device_mac)>0) {
													echo '<a id="' . $session_row_count . 'DEVICE_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>
														<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#' . $session_row_count . 'DEVICE_DELETE_' . $mac . '\').easyconfirm({locale: {
                                                                    title: \'Delete Device\',
                                                                    text: \'Are you sure you want to Delete this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#' . $session_row_count . 'DEVICE_DELETE_' . $mac . '\').click(function() {
                                                                    window.location = "?token=' . $secret . '&t=1&rm_device_realm='.$sh_realm.'&rm_session_token='.$ses_id.'&rm_device_mac=' . $mac . '&' . $next_search_pram . '=' . $next_search_value . '"
                                                                });
                                                                });
                                                        </script>
														';
												}
												else{
													 echo '<a disabled   id="' . $session_row_count . 'DEVICE_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>'; 

														
												}
												echo '</td>';
												echo '<td>';
												if ($state=='Inactive' && $nas_type=='ac') {
												echo '<a  class="btn  btn-small td_btn_last disabled" data-toggle="tooltip" title="The system does not allow to delete inactive sessions">
                                     		 <i class="btn-icon-only icon-trash"></i>Remove</a>';
											}
											else{
													if(strlen($ses_id)>0 && $_GET['rm_session_mac']!=$mac ){
													echo'<a href="" id="'.$session_row_count.'SESSION_DELETE_' . $mac .'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
														<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#'.$session_row_count.'SESSION_DELETE_' . $mac .'\').easyconfirm({locale: {
                                                                    title: \'Remove Session\',
                                                                    text: \'Are you sure you want to Remove this session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#'.$session_row_count.'SESSION_DELETE_' . $mac .'\').click(function() {
                                                                    window.location = "?token=' . $secret . '&rm_session_realm='.$sh_realm.'&rm_session_token='.$ses_id.'&mac='.$mac.'&state='.$state.'&t=1&rm_session_mac='.$mac.'&' . $next_search_pram . '=' . $next_search_value . '"
                                                                });
                                                                });
                                                        </script>
														
														'; }elseif ($_GET['rm_session_mac']==$mac){
                                                        echo'<a disabled id="'.$session_row_count.'SESSION_DELETE_' . $mac.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
														<script type="text/javascript">
														var deleteSessionCheck'.$mac.' = function (){
														    checkSessionDeleted(\''.$sh_realm.'\',\''.$mac.'\',function(data){
														        //alert(data);
														    if(data == \'0\'){
														    
                                                                $(\'#'.$session_row_count.'SESSION_DELETE_'.$mac.'\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
														    }else{
														        deleteSessionCheck'.$mac.'();
														    }   
														});
														    
														}
														deleteSessionCheck'.$mac.'();
                                                        </script>
														';

                                                    }
														else{
															echo'<a disabled id="'.$session_row_count.'SESSION_DELETE_' . $session_id.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>';
														}
														echo'</td>'; 
											 //echo "<td><a href='#' disabled> REMOVE</a></td>";
											 echo "</tr>";
											}
										}

										}

										else{
											//echo "<td colspan=\"1\">No Devices</td>";
											//echo "<td colspan=\"10\">No Sessions</td>";
											
										}
										
										
										
										
										$vernum=$db->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'");
										$nettype=$db->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");
										
										if($nettype=='GUEST'){
											 
											$key_query.=" AND session_type='Guest'";
											 
										}elseif($nettype=='PRIVATE'){
											 
											$key_query.=" AND session_type='Private'";
										}
										
										

										?>

										</tbody>

									</table>
										</div>
										</div>
										</div>
								</form>

								
									<p><b>DETERMINE IF A SESSION IS AVAILABLE: </b>If no device or session is available you can add the device manually in Step 4 below. If a session is available, but the customer still cannot access the Internet, click Delete Device followed by deleting any sessions remaining for the device. Then add the device manually as per Step 4.
									</p>
									

									<p><b>ADD DEVICE:</b> Enter the MAC address in the Add dialog field and click "Add".
									</p>


									<form action="?t=1" class="form-horizontal" method="post" id="add_mac_form" name="add_mac_form">

                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls form-group">
												<input type="text"  name="add_mac" class="span4" id="add_mac" maxlength="17" placeholder="xx:xx:xx:xx:xx:xx" data-fv-regexp="true"  autocomplete="off"  data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. Acceptable formats are: aa:bb:cc:dd:ee:ff, aa-bb-cc-dd-ee-ff, or aabbccddeeff in lowercase or all CAPS."/>
                                                    <button type="submit" name="add_mac_sessions" id="add_mac_sessions" class="btn btn-primary inline-btn"> Add</button>
                                                    <input type="hidden" name="tocked" value="<?php echo $_SESSION['FORM_SECRET']?>">
                                                </div>
                                            </div>
                                        </fieldset>
										
									</form>

									<p><b>VERIFY ACTIVE SESSION: </b>After the device is added, verify the device has an active session using the Search function. Ask the customer to refresh their browser and verify access to the Internet. If the customer has Internet access, the issue has been resolved. If the customer still cannot access the Internet, click Delete Session to remove the session. To re-initiate the Device Session, ask the customer to refresh the browser once again. </p>
									

								</div>
								<?php }
								if(in_array('VEN_SUP_ACCESSLOG',$features_array) || $package_features=="all"){ ?>
								<div <?php if(isset($tab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="support_log">

									<h1 class="head" style="display: none">Access Logs</h1>
									<br>

									<div id="response_d3">

									</div>
									<p>Search logs to identify failures during the device onboarding process.</p>
									<br/>



									<p><b>Step 1. </b>REVIEW ACCESS LOGS:
										Enter the customer information in the search dialog fields below to filter the access logs as required and click Search.  
									</p>
									<p><b>Step 2. </b>LOGS:
										Please note the LOG ID for the first error reported during the onboarding process. Submit the LOG ID to the system administrator for review.  Return to the Support menu to onboard the customer's device manually.
									</p>



									<form id="error_log" name="error_log" method="post" class="form-horizontal" action="?t=2">
										<fieldset>


											<?php
											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
											?>
											<input type="hidden" name="access_lg" id="access_lg" value="access_lg" />



											<div class="control-group">
												<label class="control-label" for="mac2">MAC</label>
												<div class="controls">
													<input class="span2"  id="mac2" name="mac2" maxlength="17" type="text" oninvalid="setCustomValidity('Invalid MAC format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"  title="Format - xx:xx:xx:xx:xx:xx" pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$" >
												</div>
											</div>
											<script type="text/javascript">

         function mac_val(element) {



             setTimeout(function () {
               var mac = $('#mac2').val();

               var pattern = new RegExp( "[/-]", "g" );
               var mac = mac.replace(pattern,"");

              // alert(mac);
               var result ='';
               var len = mac.length;

              // alert(len);

              var regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;



               if(regex.test(mac)==true){

            //  if( (len<5 && mac.charAt(3)==':') || (len<8 && mac.charAt(3)==':' && mac.charAt(6)==':') || (len<11 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':') || (len<14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':') || (len>14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':' && && mac.charAt(15)==':') ){

                }else{

               /*for (i = 0; i < len; i+=2) {




                 if(i==10){

                   result+=mac.charAt(i)+mac.charAt(i+1);

                   }else{

                 result+=mac.charAt(i)+mac.charAt(i+1)+':';

                   }



               }*/

               var pattern = new RegExp( "[/-]", "g" );
               var mac = mac.replace(pattern,"");
               var pattern1 = new RegExp( "[/:]", "g" );
               mac = mac.replace(pattern1,"");

               var mac1 = mac.match(/.{1,2}/g).toString();

               var pattern = new RegExp( "[/,]", "g" );

               var mac2 = mac1.replace(pattern,":");


               document.getElementById('mac2').value = mac2;

               $('#device_form').formValidation('revalidateField', 'mac2');


                }


             }, 100);


         }

         $("#mac2").on('paste',function(){

          mac_val(this.value);

         });


         </script>




                     <script type="text/javascript">

                             $(document).ready(function() {

                              $('#mac2').change(function(){


                                 $(this).val($(this).val().replace(/(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})/,'$1:$2:$3:$4:$5:$6'))


                                });



                               $('#mac2').keyup(function(e){
                                 var mac = $('#mac2').val();
                                 var len = mac.length + 1;


                                 if(e.keyCode != 8){

                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac2').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }
                                });


                               $('#mac2').keydown(function(e){
                                 var mac = $('#mac2').val();
                                 var len = mac.length + 1;


                                 if(e.keyCode != 8){

                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac2').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }





                                 // Allow: backspace, delete, tab, escape, enter, '-' and .
                                 if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
                                       // Allow: Ctrl+A, Command+A
                                     (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+C, Command+C
                                     (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+x, Command+x
                                     (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+V, Command+V
                                     (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: home, end, left, right, down, up
                                     (e.keyCode >= 35 && e.keyCode <= 40)) {
                                   // let it happen, don't do anything
                                   return;
                                 }
                                 // Ensure that it is a number and stop the keypress
                                 if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 65 || e.keyCode > 70)) {
                                   e.preventDefault();

                                 }
                               });


                             });

                             </script>

											<div class="control-group">
												<label class="control-label" for="email_2">E-mail</label>
												<div class="controls">
													<?php echo '<input class="span2" id="email_2" name="email_2" value="'.$email_2.'" type="text">' ?>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="limit2">Limit</label>
												<div class="controls">
													<?php if(!isset($limit2)){$limit2=100;} echo '<input placeholder="50" class="span2" id="limit2" name="limit2" value="'.$limit2.'" type="text">' ?>
												</div>
											</div>
<script type="text/javascript">

                                             $("#limit2").keypress(function(event){
                                                                var ew = event.which;
                                                                if(ew == 8||ew == 0)
                                                                    return true;
                                                                if(48 <= ew && ew <= 57)
                                                                    return true;
                                                                return false;
                                                            });



                                            </script>

											<div class="control-group">
												<label class="control-label" for="radiobtns">Period</label>

												<div class="controls">
													<div class="input-prepend input-append">

														<input class="span2" id="start_date2" name="start_date2"
															   type="text"  max="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"),date("Y"))); ?>" value="<?php if(isset($mg_start_date2)){echo $mg_start2;} ?>">
														to
														<input class="span2" id="end_date2" name="end_date2" type="text" max=<?php echo  date("Y-m-d"); ?>
														value="<?php if(isset($mg_end_date2)){echo $mg_end2;} ?>">

													</div>
												</div>
												<!-- /controls -->
											</div>

											<div class="form-actions">
												<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">Search</button>
											</div>


										</fieldset>
									</form>

									<div class="widget widget-table action-table tablesaw-minimap-mobile">
										<div class="widget-header">
											<!-- <i class="icon-th-list"></i> -->
											<?php
											//echo $query_2;
											$row_count2 = count($query_results2);
											if ($row_count2>0) {
												?>
												<h3>Access Logs - <small> <?php echo $row_count2; ?> Result(s)</small></h3>
												<?php
											}else{
												?>
												<h3>Access Logs - <small> 0 Result(s)</small></h3>
												<?php
											}
											?>
										</div>
										<!-- /widget-header -->
										<div class="widget-content table_response">
											<div style="overflow-x:auto">
											<table  class="table table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
												<thead>
												<tr>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" width="10px">#</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Log ID</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">E-mail</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Description</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Access Details</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>


												</tr>
												</thead>
												<tbody>

												<?php


												$color_var = 1;
												$get_val = 0;
												$step = 0;
												foreach ($query_results2 as $row) {
													$ssid = $row->ssid;


                                                    if(empty($ssid) || $ssid=='NA' || $ssid=='N/A'){
                                                    	$ssid="N/A";
                                                        $other_param_array = json_decode($row->other_parameters,true);

                                                        if(array_key_exists('location-id',$other_param_array)){
                                                            //$ssid=$other_param_array['location-id'];
                                                        }
                                                    }


													$id = $row->id;
													$mac = $row->mac;
													$email = $row->email;
													$description = $row->description;
													$access_details = $row->access_details;
													$create_date = $row->create_date;
													$token_id = $row->token_id;
													//$row_log->id=$row['id'];

													if($color_var == 1 && $get_val == 0){
														$temp = $token_id;
														$get_val = $get_val+1;
													}

													if($temp != $token_id){
														$color_var = $color_var+1;
														$temp = $token_id;
														$step = 0;
													}

													$step = $step+1;

													echo '<tr';
													if ($color_var % 2 == 0) {
														echo ' bgcolor="#e0eeee"';
													}else{
														echo ' bgcolor="#fffac9"';
													}
													echo '>';


													if($mac==$email || $email==''){

														$email='N/A';
													}

													echo '<td> '.$step.' </td>
														<td> '.$id.' </td>
													
														<td> '.$db->macFormat($mac,$mac_format).' </td>
														<td> '.$email.' </td>
														<td> '.$description.' </td>
														<td> <input type="text" class="invisibletb" value="'.$access_details.'"/> </td>
														<td> '.$create_date.' </td>';

													//$token_id.'<br>'.$access_details

												}

												?>
												<style type="text/css">
													.invisibletb{
														border:none;
														width:100%;
														height:100%;
													}
												</style>


												</tbody>
											</table>
										</div>
										</div>
										<!-- /widget-content -->
									</div>
<!--
									<p><strong>Step 3. </strong> REVIEW ACTIVATION LOGS: Please enter the LOG ID for the step where the first error
										occurred. Submit the error log to system administrator for review. Proceed to add the customer device manually.
									</p>


									<form action="?t=2" class="form-horizontal" method="post" >
										<fieldset>
											<div class="control-group">

												<input type="text" name="log_id" class="span4" id="log_id" required />
												<input type="hidden" name="token" id="token"  value="<?php //echo $secret;?>" />
												<button type="submit" name="submit_log" class="btn btn-primary">Submit<i class="btn-icon-only icon-upload-alt"></i></button>
											</div>
										</fieldset>
									</form>
 -->

								</div>
								<?php }
								if(in_array('VEN_SUP_APLOG',$features_array) || $package_features=="all"){ ?>
	<!-- AP LOGS start -->
				<div <?php if(isset($tab3)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="support_log_api">
									<div id="response_d3">

										<h1 class="head" style="display: none">AP Controller Logs</h1>
									<br>


									<p>Search AP controller logs to identify failures that may be impacting the customer's experience.
									</p><br>
									<form id="api_logs" name="api_logs" method="post" class="form-horizontal" action="?t=3">
											<fieldset>


													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="api_lg" id="api_lg" value="api_lg" />

													<div class="control-group">
														<label class="control-label" for="name">Function</label>
														<div class="controls">




													<?php

													if(strlen($_POST['function_select'])){
														$selected_i = "all";
													}
													else{
														$selected_i = $_POST['function_select'];
													}

													$selected_i = "all";
													?>

													<script type="text/javascript">
																 jQuery(document).ready(function(){

 																 jQuery('select#function_select').val('<?php echo $selected_i; ?>');

 																});
																	</script>

															<div class="input-prepend input-append">
																<select name="function_select" class="span4" id="function_select">
																	<option  value="all"> All </option>

																	<?php

																	$functionsl=$test->Functionlist();

																	$array_function_list=json_decode($functionsl,true);

																	asort($array_function_list);

																	foreach ($array_function_list as $key => $value) {
																	?>
																	<option value="<?php echo $key ?>"><?php echo ucfirst($value)?>  </option>
																	<?php } ?>


																</select>
															</div>

														</div>
													</div>



													<div class="control-group">
														<label class="control-label" for="limit_api">Limit</label>
														<div class="controls">
															<?php if(!isset($limit_api)){$limit_api=100;} echo '<input placeholder="100" class="span2" id="limit_api" name="limit_api" value="'.$limit_api.'" placeholder="100" type="text">' ?>
														</div>
													</div>
<script type="text/javascript">

                                             $("#limit_api").keypress(function(event){
                                                                var ew = event.which;
																//alert(ew);
                                                                if(ew == 8||ew == 0)
                                                                    return true;
                                                                if(48 <= ew && ew <= 57)
                                                                    return true;
                                                                return false;
                                                            });



                                            </script>
													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">


																<input class="inline_error inline_error_1 span2 form-control" id="start_date_api" name="start_date_api"
																	type="text"   value="<?php if(isset($start_date_apia)){echo $start_date_apia;} ?>" placeholder="mm/dd/yyyy">

																	To
																	<input class="inline_error inline_error_1 span2 form-control" id="end_date_api" name="end_date_api" type="text" value="<?php if(isset($end_date_apia)){echo $end_date_apia;} ?>" placeholder="mm/dd/yyyy">

                                                                     <input type="hidden" name="date3" />


														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<?php
											 $row_count33 = count($query_api_results);
											 if ($row_count33<3) {
											 	$table_saw_style = 'style="margin-bottom: 60px !important;"';
											 }
											 else{
											 	$table_saw_style = '';
											 }
										 ?>

										<div class="widget widget-table action-table tablesaw-minimap-mobile" <?php echo $table_saw_style; ?>>
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php

													if ($row_count33>0) {
												?>
													<h3>AP/SSID Logs - <small> <?php echo $row_count33; ?> Result(s)</small></h3>
												<?php
													}else{
												?>
													<h3>AP/SSID Logs - <small> 0 Result(s)</small></h3>
												<?php
													}
												 ?>
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto">
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
														<tr>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Realm</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Function</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API Log</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">API Status</th>

															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Create Date</th>


														</tr>
													</thead>
													<tbody>

													<?php
													//echo $query_api;

													foreach ($query_api_results as  $row) {
														$function_name = $row->function_name;
														$description = $row->description;
														$api_status = $row->api_status;
														$api_method = $row->api_method;
														$api_description = $row->api_description;
														//$api_data = $row['api_data'];
														$create_date = $row->create_date;

														$unixtimestamp = (int) $row->unixtimestamp;

                                                        $dt2 = new DateTime($create_date, new DateTimeZone(date_default_timezone_get()));
                                                        $dt2->setTimezone(new DateTimeZone($tome_zone));
                                                        $create_date = $dt2->format('m/d/Y h:i:s A');

                                                        $dt = new DateTime("@$unixtimestamp");
														$dt->setTimezone(new DateTimeZone($log_time_zone));
														$unix_date=$dt->format('m/d/Y h:i:s A');


														$realm_a=$row->realm;
														$api_id = $row->id;

														echo '<tr>
														<td> '.$realm_a.' </td>
														<td> '.ucfirst($function_name).' </td>
														<td><a href=ajax/log_view.php?ap_log_id='.$api_id.' target="_blank"> View </a></td>

														<td> '.$api_status.' </td>

														<td> '.$unix_date.' </td>';


													}

													?>





												</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>




									</div>






				</div>

<!-- AP LOGS END --><?php }
                                if(in_array('VEN_SUP_ERRORLOG',$features_array) || $package_features=="all"){ ?>


									<!-- /* +++++++++++++++++++++++++++++++ Exp Error Logs +++++++++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab4)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="error_logs">

										<h1 class="head" style="display: none">Error Logs</h1>
									<br>

									<p>Search error logs to identify failures that may be impacting the customer's experience.
									</p><br>


										<form id="error_log" name="error_log" method="post" class="form-horizontal" action="?t=4">
											<fieldset>

												<div id="response_d3">
												<?php


													  if(isset($_POST['error_log_submit'])){
													  	$ssid_submit = $_POST['ssid'];
													  	$mac3_submit = $_POST['mac3'];
													  	$email_submit = $_POST['email'];
													  	$limit_submit = $_POST['limit'];

													  }
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="error_lg" id="error_lg" value="error_lg" />



											<div class="control-group">
												<label class="control-label" for="mac3">MAC</label>
												<div class="controls">
													<input class="span2"  id="mac3" name="mac3" maxlength="17" type="text" oninvalid="setCustomValidity('Invalid MAC format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"  title="Format - xx:xx:xx:xx:xx:xx" pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$" >
												</div>
											</div>
											<script type="text/javascript">

         function mac_vall(element) {



             setTimeout(function () {
               var mac = $('#mac3').val();

               var pattern = new RegExp( "[/-]", "g" );
               var mac = mac.replace(pattern,"");

              // alert(mac);
               var result ='';
               var len = mac.length;

              // alert(len);

              var regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;



               if(regex.test(mac)==true){

            //  if( (len<5 && mac.charAt(3)==':') || (len<8 && mac.charAt(3)==':' && mac.charAt(6)==':') || (len<11 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':') || (len<14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':') || (len>14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':' && && mac.charAt(15)==':') ){

                }else{

               /*for (i = 0; i < len; i+=2) {




                 if(i==10){

                   result+=mac.charAt(i)+mac.charAt(i+1);

                   }else{

                 result+=mac.charAt(i)+mac.charAt(i+1)+':';

                   }



               }*/

               var pattern = new RegExp( "[/-]", "g" );
               var mac = mac.replace(pattern,"");
               var pattern1 = new RegExp( "[/:]", "g" );
               mac = mac.replace(pattern1,"");

               var mac1 = mac.match(/.{1,2}/g).toString();

               var pattern = new RegExp( "[/,]", "g" );

               var mac3 = mac1.replace(pattern,":");


               document.getElementById('mac3').value = mac3;

               $('#device_form').formValidation('revalidateField', 'mac3');


                }


             }, 100);


         }

         $("#mac3").on('paste',function(){

          mac_vall(this.value);

         });


         </script>




                     <script type="text/javascript">

                             $(document).ready(function() {

                              $('#mac3').change(function(){


                                 $(this).val($(this).val().replace(/(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})/,'$1:$2:$3:$4:$5:$6'))


                                });



                               $('#mac3').keyup(function(e){
                                 var mac = $('#mac3').val();
                                 var len = mac.length + 1;


                                 if(e.keyCode != 8){

                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac3').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }
                                });


                               $('#mac3').keydown(function(e){
                                 var mac = $('#mac3').val();
                                 var len = mac.length + 1;


                                 if(e.keyCode != 8){

                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac3').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }





                                 // Allow: backspace, delete, tab, escape, enter, '-' and .
                                 if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
                                       // Allow: Ctrl+A, Command+A
                                     (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+C, Command+C
                                     (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+x, Command+x
                                     (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+V, Command+V
                                     (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: home, end, left, right, down, up
                                     (e.keyCode >= 35 && e.keyCode <= 40)) {
                                   // let it happen, don't do anything
                                   return;
                                 }
                                 // Ensure that it is a number and stop the keypress
                                 if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 65 || e.keyCode > 70)) {
                                   e.preventDefault();

                                 }
                               });


                             });

                             </script>

													<div class="control-group">
														<label class="control-label" for="email">E-mail</label>
														<div class="controls">
															<?php echo '<input class="span2" id="email" name="email" value="'.$email_submit.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="limit">Limit</label>
														<div class="controls">
															<?php if(!isset($limit_submit)){$limit_submit=100;} echo '<input placeholder="100" class="span2" id="limit" name="limit" value="'.$limit_submit.'"  type="text">' ?>
														</div>
													</div>

											<script type="text/javascript">

                                             $("#limit").keypress(function(event){
                                                                var ew = event.which;
                                                                if(ew == 8||ew == 0)
                                                                    return true;
                                                                if(48 <= ew && ew <= 57)
                                                                    return true;
                                                                return false;
                                                            });



                                            </script>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls">
															<div class="input-prepend input-append">

																<input class="span2" id="start_date" name="start_date"
																	type="text"  max="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"),date("Y"))); ?>" value="<?php if(isset($mg_start_date)){echo $mg_start;} ?>">
																	to
																	<input class="span2" id="end_date" name="end_date" type="text" max=<?php echo  date("Y-m-d"); ?>
																	 value="<?php if(isset($mg_end_date)){echo $mg_end;} ?>">

															</div>
														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table tablesaw-minimap-mobile">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
													$row_count = count($result_error_lgs);
													if ($row_count>0) {
												?>
													<h3>Error Logs - <small> <?php echo $row_count; ?> Result(s)</small></h3>
												<?php
													}else{
												?>
													<h3>Error Logs - <small> 0 Result(s)</small></h3>
												<?php
													}
												 ?>
											</div>
											<!-- /widget-header -->
											<div class="widget-content table_response">
												 <div style="overflow-x:auto">
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
														<tr>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">SSID</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">E-mail</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Error Description</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Error Comment</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Error Time</th>
														</tr>
													</thead>
													<tbody>
														<?php
														while($row=mysql_fetch_array($result_error_lgs)){
															echo "<tr>";

															echo "<td>".$db->macFormat($row[mac],$mac_format)."</td>";
															if($row[mac]==$row[email] || $row[email]=='' ){
																$row[email]='N/A';
															}
															echo "<td>".$row[email]."</td>";
															echo "<td>".$row[description]."</td>";
															echo "<td>".$row[error_details]."</td>";
															echo "<td>".$row[create_date]."</td>";
															echo "</tr>";
														}
														 ?>

													</tbody>
												</table>
											</div>
											</div>
										</div>
									</div>

								<?php }  ?>


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

	<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
