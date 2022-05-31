<?php ob_start();?>
<!DOCTYPE html>

<html lang="en">

 <?php

session_start();

include 'header_top.php';


require_once('db/config.php');

/* No cache*/
//header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

/*classes & libraries*/
require_once 'classes/dbClass.php';
require_once 'classes/systemPackageClass.php';

 /*Encryption script*/
 include_once 'classes/cryptojs-aes.php';

$db = new db_functions();
  $wag_ap_name=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1");
//echo $wag_ap_name='NO_PROFILE';
 if($wag_ap_name!='NO_PROFILE') {

     $ap_control_var = $db->setVal('ap_controller', 'ADMIN');

     if($ap_control_var=='SINGLE'){
         include 'src/AP/' . $wag_ap_name . '/index.php';
    	$test = new ap_wag();


    }
 }


 $package_functions=new package_functions();
 


////////////randon pasword ////
 function randomPasswordlength($length) {

     $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@";
     $pass = array(); //remember to declare $pass as an array
     $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
     for ($i = 0; $i < $length; $i++) {
         $n = rand(0, $alphaLength);
         $pass[] = $alphabet[$n];
     }

     return implode($pass); //turn the array into a string
 }

?>

<head>

<meta charset="utf-8">
<title>Locations</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">


<link rel="stylesheet" href="css/bootstrapValidator.css"/>
    <link rel="stylesheet" href="css/bootstrap-toggle.min.css"/>
    <link rel="stylesheet" href="css/tablesaw.css?v1.0">

    <style>
        #mno_mobile_1:valid ~ small[data-bv-validator-for="mno_mobile_1"] { display:none !important;}
        #mno_mobile_2:valid ~ small[data-bv-validator-for="mno_mobile_2"] { display:none !important;}
        #mno_mobile_3:valid ~ small[data-bv-validator-for="mno_mobile_3"] { display:none !important;}
    </style>


	<!-- Add jQuery library -->
<!--<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>-->




    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script src="js/locationpicker.jquery.js"></script>

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-toggle.min.js"></script>


 <!--Ajax File Uploading Function-->


    <!--table colimn show hide-->
    <script type="text/javascript" src="js/tablesaw.js"></script>
    <script type="text/javascript" src="js/tablesaw-init.js"></script>





<?php
$data_secret = $db->setVal('data_secret','ADMIN');
include 'header.php';

function randomPassword() {

	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}

	return implode($pass); //turn the array into a string
}


?>


<script language="Javascript">



function uploaodSMBValidation() {

if(document.getElementById("smb_account_code").value==''){
		document.getElementById("upload_smb_account").style.display='';
		}else{
			document.getElementById("upload_smb_account").style.display='none';

			}


}


function fileUpload(form, action_url1,div_id) {

	//disable button//
	document.getElementById("upload_cont").disabled=true;
	var smb_account_code=document.getElementById("smb_account_code").value;
	var form_id="ap_bulk_upload";

	if(smb_account_code==''){
		document.getElementById("upload_smb_account").style.display='';
		document.getElementById("upload_cont").disabled=false;
		return false;
		}

	//php word search////
	var n = action_url1.search(".php");

	if(n=="-1"){
		//extension not available//
		var action_url=action_url1+"?smb_account_code="+smb_account_code;
		}else{
			var action_url=action_url1+"?smb_account_code="+smb_account_code;
			}


	//alert(action_url);
    // Create the iframe...
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id", "upload_iframe");
    iframe.setAttribute("name", "upload_iframe");
    iframe.setAttribute("width", "0");
    iframe.setAttribute("height", "0");
    iframe.setAttribute("border", "0");
    iframe.setAttribute("style", "width: 0; height: 0; border: none;");

    // Add to document...
    form.parentNode.appendChild(iframe);
    window.frames['upload_iframe'].name = "upload_iframe";

    iframeId = document.getElementById("upload_iframe");

    // Add event...
    var eventHandler = function () {

            if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
            else iframeId.removeEventListener("load", eventHandler, false);

            // Message from server...
            if (iframeId.contentDocument) {
                content = iframeId.contentDocument.body.innerHTML;
            } else if (iframeId.contentWindow) {
                content = iframeId.contentWindow.document.body.innerHTML;
            } else if (iframeId.document) {
                content = iframeId.document.body.innerHTML;
            }

            document.getElementById(div_id).innerHTML = content;
			//form rest
		   document.getElementById(form_id).reset();

            // Del the iframe...
            setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
        }

    if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
    if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);

    // Set properties of form...
    form.setAttribute("target", "upload_iframe");
    form.setAttribute("action", action_url);
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("encoding", "multipart/form-data");

    // Submit the form...
    form.submit();
    //document.getElementById("up_cont").disabled=true;
    document.getElementById(div_id).innerHTML = "<font color=#4B8DF7 size=3><strong><?php echo $message_functions->showMessage('file_upload_waiting'); ?></strong><br><img src=img/uploader1.gif><br><br>";
}

</script>

<?php

function formatOffset($offset) {
    $hours = $offset / 3600;
    $remainder = $offset % 3600;
    $sign = $hours > 0 ? '+' : '-';
    $hour = (int) abs($hours);
    $minutes = (int) abs($remainder / 60);
    if ($hour == 0 AND $minutes == 0) {
        $sign = ' ';
    }
    return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');

}

	// TAB Organization
	if(isset($_GET['t'])){
		$variable_tab='tab'.$_GET['t'];
		$$variable_tab='set';
	}else{
		//initially page loading///
		if($user_type == 'ADMIN'){
			$tab8="set";

		}else if($user_type == 'MVNA'){
			$tab5="set";

		}else {

			$tab1="set";

		}
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
?>





<?php

$key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'camp_base_url'";

$query_results=mysql_query($key_query);
while($row=mysql_fetch_array($query_results)){

	$settings_value = $row[settings_value];
	$base_url = trim($settings_value,"/");
}
$base_folder=$db->setVal('portal_base_folder','ADMIN');



//admin -> Service Provider form type
$key_query2 = "SELECT settings_value FROM exp_settings WHERE settings_code = 'service_account_form' LIMIT 1";
$query_result2=mysql_query($key_query2);
$row2=mysql_fetch_array($query_result2);
$mno_form_type = $row2[settings_value];
//echo $mno_form_type='basic_menu';

//check API call enbale or not///
//$wag_ap_name=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1");


//refresh zones
if(isset($_GET['refreshzone'])){

	$rsk1=$test->rkszones();
	$obj = (array)json_decode($rsk1);

	$dataarray =$obj['list'];

	$arrlength = count($dataarray);

	for($x = 0; $x < $arrlength; $x++) {


		$array = json_decode(json_encode($dataarray[$x]), True);
		//print_r($array);
		$zid=$array['id'];
		$zname=$array['name'];

		$query0 = "REPLACE INTO exp_distributor_zones (zoneid,name,create_user,create_date)

					values ('$zid','$zname','$user_name',now())";

		mysql_query($query0);


	}

}






	//Remove Aps///
else if(isset($_GET['remove_code'])){//3

	if($_SESSION['FORM_SECRET']==$_GET['token9']){//refresh validate

		$remove_ap_id =mysql_real_escape_string($_GET['remove_code']) ;
		$user_name = $_SESSION['user_name'];

		//archive
		$query_ap_archive = "INSERT INTO `exp_mno_distributor_aps_archive`
		(`distributor_code`, `ap_code`, `assign_date`, `assigned_by`, `archive_by`, `archive_date`)
		SELECT distributor_code,ap_code,assign_date,assigned_by,'$user_name',now()
		from exp_mno_distributor_aps where id = '$remove_ap_id'";

		$ex1 = mysql_query($query_ap_archive);

		if($ex1){

			//delete AP
			$ex0=mysql_query("DELETE FROM `exp_mno_distributor_aps` WHERE `id` = '$remove_ap_id' ");

		}

		if($ex0){

			$_SESSION['msg9']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('cpe_removing_success')."</strong></div>";
			$create_log->save('3003',$message_functions->showMessage('cpe_removing_success'),'');

		}else{

            $db->userErrorLog('2003', $user_name, 'script - '.$script);

			$_SESSION['msg9']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('cpe_removing_failed','2003')."</strong></div>";
			$create_log->save('2003',$message_functions->showMessage('cpe_removing_failed'),'');
		}


	}//key validation

	else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

		$_SESSION['msg9']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		header('Location: location.php?t=9');

	}
}//3



	///Admin - Create MNO Account//////
else if(isset($_POST['submit_mno_form'])){//6
    if(isset($_GET['mno_edit'])){
       	$edit_mno_id=$_GET['mno_edit_id'];

        $get_edit_get=1;

      $get_mno_unque_q="SELECT `unique_id` FROM `exp_mno` WHERE `mno_id`='$edit_mno_id'";
        $get_mno_unque=mysql_query($get_mno_unque_q);

        while($get_mno_unque_arr=mysql_fetch_assoc($get_mno_unque)){

            $mno_unque=$get_mno_unque_arr['unique_id'];
        }

    }

	if($_SESSION['FORM_SECRET']==$_POST['form_secret6']) {//refresh validate

        $mno_account_name =mysql_real_escape_string(trim($_POST['mno_account_name'])) ;

        $mno_user_type = trim($_POST['mno_user_type']);

        $mno_sys_package = trim($_POST['mno_sys_package']);



        if ($mno_form_type == 'advanced_menu') {//advanced_menu
            //$mno_customer_type = trim($_POST['mno_customer_type']);
            $mno_first_name =mysql_real_escape_string(trim($_POST['mno_first_name'])) ;
            $mno_last_name =mysql_real_escape_string(trim($_POST['mno_last_name'])) ;
            $mno_full_name = $mno_first_name . ' ' . $mno_last_name;
            $mno_email = trim($_POST['mno_email']);
            $mno_address_1 =mysql_real_escape_string(trim($_POST['mno_address_1'])) ;
            $mno_address_2 =mysql_real_escape_string(trim($_POST['mno_address_2'])) ;
            $mno_address_3 =mysql_real_escape_string(trim($_POST['mno_address_3'])) ;
            $mno_mobile_1 =mysql_real_escape_string(trim($_POST['mno_mobile_1'])) ;
            $mno_mobile_2 =mysql_real_escape_string(trim($_POST['mno_mobile_2'])) ;
            $mno_mobile_3 =mysql_real_escape_string(trim($_POST['mno_mobile_3'])) ;
            $mno_country = trim($_POST['mno_country']);
            $mno_state =mysql_real_escape_string(trim($_POST['mno_state'])) ;
            $mno_zip_code = trim($_POST['mno_zip_code']);
            $mno_time_zone = $_POST['mno_time_zone'];
              $dtz = new DateTimeZone($mno_time_zone);
              $time_in_sofia = new DateTime('now', $dtz);
              $offset = $dtz->getOffset( $time_in_sofia ) / 3600;
              $time_offset=($offset < 0 ? $offset : "+".$offset);


        } else {
            $mno_full_name =mysql_real_escape_string( trim($_POST['mno_full_name']));
            $mno_email = trim($_POST['mno_email']);
            $mno_mobile =mysql_real_escape_string(trim($_POST['mno_mobile'])) ;

        }


        $login_user_name = $_SESSION['user_name'];

        $br = mysql_query("SHOW TABLE STATUS LIKE 'exp_mno'");
        $rowe = mysql_fetch_array($br);
        $auto_inc = $rowe['Auto_increment'];
        $mno_id = "MNO" . $auto_inc;
        $u_id = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
         $unique_id = '1' . $u_id;

        $new_user_name = str_replace(' ', '_', strtolower(substr($mno_full_name, 0, 5) . 'm' . $auto_inc));
        $password = randomPassword();

if($get_edit_get==1){
    if ($wag_ap_name == 'NO_PROFILE') {
        //API not call//
        $status_code = '200';
    } else {

        $status_code = '200';
    }
}
else {
        if ($wag_ap_name == 'NO_PROFILE') {
            //API not call//
            $status_code = '200';
        } else {

            $status_code='200';
        }
    }
		if($status_code == '200') {//1

            ////////////MNO Default theme insert///////////////////////////////////
         if($get_edit_get==1) {


             //*************************UPDATE********************************************


             if ($mno_form_type == 'advanced_menu') {//advanced_menu
                 $query0 = "UPDATE `exp_mno`
                        SET
                          `system_package`='$mno_sys_package',
						  `mno_description`='$mno_account_name',
						  `ap_controller_name`='$Ap_controller',
						  `bussiness_address1`='$mno_address_1',
						  `bussiness_address2`='$mno_address_2',
						  `bussiness_address3`='$mno_address_3',
						  `country`='$mno_country',
						  `state_region`='$mno_state',
						  `zip`='$mno_zip_code',
						  `phone1`='$mno_mobile_1',
						  `phone2`='$mno_mobile_2',
						  `phone3`='$mno_mobile_3',
						  `timezones`='$mno_time_zone'
						 WHERE `mno_id`='$edit_mno_id'";

                 $query1 = "UPDATE
			  `admin_users`
			SET
			  `full_name` = '$mno_full_name',
			  `email` = '$mno_email'
			WHERE `user_distributor` = '$edit_mno_id'";

             } else {
                 $query0 = "UPDATE `exp_mno` SET `system_package`='$mno_sys_package',`full_name`='$mno_full_name',`email`='$mno_email' WHERE `user_distributor`='$edit_mno_id'`access_role`='admin'";

                 $query1 = "UPDATE
			  `admin_users`
			SET
			  `full_name` = '$mno_full_name',
			  `email` = '$mno_email'
			WHERE `user_distributor` = '$edit_mno_id'";

             }


             $ex0 = mysql_query($query0);
             $ex1 = mysql_query($query1);

             $query0_del="DELETE FROM exp_mno_ap_controller WHERE `mno_id`='$edit_mno_id'";
             $ex0del = mysql_query($query0_del);



           foreach($_POST['AP_cont'] as $selectedOptionap){
            	$ap = $selectedOptionap;
            	$query_01 = "INSERT INTO `exp_mno_ap_controller` (`mno_id`, `ap_controller`, `create_user`, `create_date`)
            	VALUES ('$edit_mno_id', '$ap', '$user_name',NOW())";
            	$ex01 = mysql_query($query_01);

            }



					//////////////////////////////////////////////////////////////////////////////////////////////////










             if($ex0){
             	
             	$create_log->save('3002',$message_functions->showMessage('operator_update_success'),'');
                 $_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('operator_update_success')."</strong></div>";

             }
         else {
                 $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                 $create_log->save('2001',$message_functions->showMessage('operator_update_failed','2001'),'');
                 $_SESSION['msg7'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('operator_update_failed','2001')."</strong></div>";

             }




            //******************************************************************




         }else {
            $q_theme_insert = "INSERT INTO `exp_themes` (
		  `theme_id`,
		  `theme_name`,
		  `distributor`,
		  `language`,
		  `registration_type`,
		  `social_login_txt`,
		  `manual_login_txt`,
		  `welcome_txt`,
		  `toc_txt`,
		  `loading_txt`,
		  `welcome_back_txt`,
		  `registration_btn`,
		  `connect_btn`,
		  `fb_btn`,
		  `male_field`,
		  `female_field`,
		  `email_field`,
		  `age_group_field`,
		  `gender_field`,
		  `btn_color`,
		  `btn_border`,
		  `btn_text_color`,
		  `create_date`,
		  `updated_by`)
		(SELECT

		  '$mno_id',
		  '$mno_id THEME',
		  'MNO',
		  `language`,
		  `registration_type`,
		  `social_login_txt`,
		  `manual_login_txt`,
		  `welcome_txt`,
		  `toc_txt`,
		  `loading_txt`,
		  `welcome_back_txt`,
		  `registration_btn`,
		  `connect_btn`,
		  `fb_btn`,
		  `male_field`,
		  `female_field`,
		  `email_field`,
		  `age_group_field`,
		  `gender_field`,
		  `btn_color`,
		  `btn_border`,
		  `btn_text_color`,
		  NOW(),
		  '$login_user_name'
		FROM
		  `exp_themes`
		WHERE `theme_id`='default_theme' LIMIT 1)";
            $ex_theme_insert = mysql_query($q_theme_insert);

            ////////////////////////////////////////////////////////////////////////////
            if ($mno_form_type == 'advanced_menu') {//advanced_menu
                $query0 = "INSERT INTO `exp_mno` (
						  `mno_id`,
						  `unique_id`,
						  `mno_description`,
						  `bussiness_address1`,
						  `bussiness_address2`,
						  `bussiness_address3`,
						  `country`,
						  `state_region`,
						  `zip`,
						  `phone1`,
						  `phone2`,
						  `phone3`,
						  `timezones`,
						  `is_enable`,
						  `create_date`,create_user,`system_package`)
						VALUES
						  ( '$mno_id',
						    '$unique_id',
							'$mno_account_name',
							'$mno_address_1',
							'$mno_address_2',
							'$mno_address_3',
							'$mno_country',
							'$mno_state',
							'$mno_zip_code',
							'$mno_mobile_1',
							'$mno_mobile_2',
							'$mno_mobile_3',
							'$mno_time_zone',
							'2',
							NOW(),'$login_user_name','$mno_sys_package')";

            } else {
                $query0 = "INSERT INTO `exp_mno` (`system_package`,`mno_id`, `mno_description`,  `is_enable`,create_user, `create_date`)
		VALUES ('$mno_sys_package','$mno_id', '$mno_account_name','0','$login_user_name', NOW())";




            }

            $ex0 = mysql_query($query0);


            foreach($_POST['AP_cont'] as $selectedOptionap){
            	$ap = $selectedOptionap;
            	$query_01 = "INSERT INTO `exp_mno_ap_controller` (`mno_id`, `ap_controller`, `create_user`, `create_date`)
            	VALUES ('$mno_id', '$ap', '$user_name',NOW())";
            	$ex01 = mysql_query($query_01);

            }



            if ($ex0) {

               $query0 = "INSERT INTO `admin_users` (`user_name`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `is_enable`,create_user, `create_date`)
			VALUES ('$new_user_name',PASSWORD('$password'), 'admin', '$mno_user_type', '$mno_id', '$mno_full_name', '$mno_email', '$mno_mobile', '2','$login_user_name', NOW())";
                $ex0 = mysql_query($query0);



                $to = $mno_email;
                $from=strip_tags($db->setVal("email", "ADMIN"));
                $title=$db->setVal("short_title", "ADMIN") ;
                $subject = $title. ' Setup Verification';


                $link = $db->setVal("global_url", "ADMIN");
                $a = $db->textVal('MAIL', 'ADMIN');

                $vars = array(

                    '{$user_full_name}' => $mno_full_name,
                    '{$short_name}' => $title,
                    '{$account_type}' => 'MNO',
                    '{$user_name}' => $new_user_name,
                    '{$password}' => $password,
                    '{$link}' => $link
                );

                $message_full = strtr($a, $vars);
                $message = mysql_escape_string($message_full);

                 $qu = "INSERT INTO `admin_invitation_email` (`to`,`subject`,`message`,`distributor`,`user_name`,`password_re`, `create_date`)
					VALUES ('$to', '$subject', '$message', '$mno_id', '$new_user_name','$password', now())";
                $rrr = mysql_query($qu);

                if(getOptions('VENUE_ACTIVATION_TYPE',$mno_sys_package,'MNO')=="ICOMMS NUMBER" ) {
                    $qu1 = "INSERT INTO `exp_texts` (`text_code`,`title`,`text_details`,`distributor`, `create_date`,`updated_by`)
					(SELECT 'MAIL',`title`,`text_details`,'$mno_id', now(),'admin' FROM `exp_texts` WHERE `distributor` = 'ADMIN' AND `text_code` = 'ICOMMS_MAIL')";
                }else{
                    $qu1 = "INSERT INTO `exp_texts` (`text_code`,`title`,`text_details`,`distributor`, `create_date`,`updated_by`)
					(SELECT `text_code`,`title`,`text_details`,'$mno_id', now(),'admin' FROM `exp_texts` WHERE `distributor` = '$user_distributor' AND `text_code` = 'MAIL')";
                }


                $rrr1 = mysql_query($qu1);

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


                $mail_obj=new email($cunst_var);


                $mail_sent=$mail_obj->sendEmail($from,$to,$subject,$message_full,'',$title);

                //$mail_sent = @mail($to, $subject, $message, $headers);

                //$_SESSION['msg6'] .= $mail_sent ? "Mail sent" : "Mail failed";

                if (isset($mno_sys_package)) {

                   // echo '1';

                    $access_role_id=$mno_id."_support";
                    $access_role_name= $mno_id." Support";


                    if(getSectionType("SUPPORT_AVAILABLE",$mno_sys_package,'MNO')=='1'){

                       // echo '2';


                        $query0 = "INSERT INTO `admin_access_roles` (`access_role`,`description`,`distributor`,`create_user`,`create_date`)
            		VALUES ('$access_role_id', 'Support', '$mno_id', '$user_name',now())";
                        $result0 = mysql_query($query0);



                        $sys_pack = $mno_sys_package;

                        $gt_support_optioncode=getOptions('SUPPORT_AVAILABLE',$sys_pack,'MNO');

                        $pieces1 = explode(",", $gt_support_optioncode);


                        //print_r($pieces1);

                        $len1 = count($pieces1);

                        for($i=0;$i<$len1;$i++){


                             	$query1 = "INSERT INTO `admin_access_roles_modules`
            			(`access_role`, `module_name`, `distributor` , `create_user`, `create_date`)
            			VALUES ('$access_role_id', '$pieces1[$i]', '$mno_id', '$user_name', now())";
                            $result1 = mysql_query($query1);


                        }


                    }

                }

                ///////////////////////////////////////////////

                $create_log->save('',$message_functions->showMessage('operator_create_success'),'');

                $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('operator_create_success')."</strong></div>";


            } else {
                $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                $create_log->save('2001',$message_functions->showMessage('operator_create_failed','2001'),'');
                $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('operator_create_failed','2001')."</strong></div>";

            }

        }

	}//1

		else{//1
            $db->userErrorLog('2009', $user_name, 'script - '.$script);
            $create_log->save('2001',$message_functions->showMessage('operator_create_failed','2009'),'');
			$_SESSION['msg6']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('operator_create_failed','2009')."</strong></div>";

		}//1

	}//key validation

	else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);
        
        $create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');

		$_SESSION['msg6']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
		header('Location: location.php');

		}
}//6



	/// Create Account  or Edit Account/////
else if(isset($_POST['create_location_submit']) || isset($_POST['create_location_next']) || isset($_POST['add_location_submit']) || isset($_POST['add_location_next'])){//5

$create_location_btn_action=$_POST['btn_action'];

	if($_SESSION['FORM_SECRET']==$_POST['form_secret5']) {//refresh validate

        $parent_code = strtoupper($_POST['parent_id']);
        $parent_ac_name = mysql_real_escape_string(trim($_POST['parent_ac_name']));
        $parent_package = $_POST['parent_package_type'];
        $user_type1 = $_POST['user_type'];
        $icomme_number = $_POST['icomme'];
        $customer_type = trim($_POST['customer_type']);
        $gateway_type = trim($_POST['gateway_type']);
        $pr_gateway_type = trim($_POST['pr_gateway_type']);
        $business_type = trim($_POST['business_type']);
        $network_type = $_POST['network_type'];
        $wag_name = $_POST['wag_name'];
        $wag_enable = $_POST['content_filter'];
        $location_name = mysql_real_escape_string(trim($_POST['location_name1']));
        $location_name_s = trim($_POST['location_name1']);

        //////////////////////////////////

        $pieces = explode(" ", $location_name_s);
        $namelen = strlen($pieces[0]);


        if(0<$namelen && $namelen<11){

            $cusbiss_name = $pieces[0];

        }else{

            $cusbiss_name = substr($pieces[0], 0, 10);


        }
        //echo $location_name;
        $category_mvnx = $_POST['category_mvnx'];


            $mno_first_name = mysql_real_escape_string(trim($_POST['mno_first_name']));
            $mno_last_name = mysql_real_escape_string(trim($_POST['mno_last_name']));
            $mvnx_full_name = $mno_first_name . ' ' . $mno_last_name;
            $mvnx_email = trim($_POST['mno_email']);
            $mvnx_address_1 = mysql_real_escape_string(trim($_POST['mno_address_1']));
            $mvnx_address_2 = mysql_real_escape_string(trim($_POST['mno_address_2']));
            $mvnx_address_3 = mysql_real_escape_string(trim($_POST['mno_address_3']));
            $mvnx_mobile_1 = mysql_real_escape_string(trim($_POST['mno_mobile_1']));
            $mvnx_mobile_2 = mysql_real_escape_string(trim($_POST['mno_mobile_2']));
            $mvnx_mobile_3 = mysql_real_escape_string(trim($_POST['mno_mobile_3']));
            $mvnx_country = mysql_real_escape_string(trim($_POST['mno_country']));
            $mvnx_state = mysql_real_escape_string(trim($_POST['mno_state']));
            $mvnx_zip_code = trim($_POST['mno_zip_code']);
            $mvnx_time_zone = $_POST['mno_time_zone'];
            $dtz = new DateTimeZone($mvnx_time_zone);
            
            $time_in_sofia = new DateTime('now', $dtz);
            $offset = $dtz->getOffset($time_in_sofia) / 3600;

            $timezone_abbreviation=$time_in_sofia->format('T');
            // get first 4 characters
            $timezone_abbreviation=substr($timezone_abbreviation,0,4);


            $offset1 = $dtz->getOffset($time_in_sofia);
           	$offset_val = formatOffset($offset1);
           
           if($offset_val==' 00:00'){
           	
           	$offset_val= '+00:00';
           }


            $time_offset = ($offset < 0 ? $offset : "+" . $offset);


            /*$dateTime_zone = new DateTime();
            $dateTime_zone->setTimeZone(new DateTimeZone($mvnx_time_zone));*/

            //Create Group/Realm/Zone ID

            $zone_name = mysql_real_escape_string(trim($_POST['zone_name']));//Unique property ID
            
            
            $tunnel = mysql_real_escape_string(trim($_POST['tunnel']));
            
            $tunnel =$db->getValueAsf("SELECT g.tunnels AS f FROM exp_gateways g WHERE g.gateway_name='$gateway_type'");
            $tunnel=trim($tunnel,'["\"]');
            
           
            $pr_tunnel = mysql_real_escape_string(trim($_POST['pr_tunnel']));
            $pr_tunnel =$db->getValueAsf("SELECT g.tunnels AS f FROM exp_gateways g WHERE g.gateway_name='$pr_gateway_type'");
            $pr_tunnel=trim($pr_tunnel,'["\"]');
            
            
            
            
            $zone_dec = mysql_real_escape_string(trim($_POST['zone_dec']));//Description
            $realm = mysql_real_escape_string(trim($_POST['realm']));//Realm


            $ap_controller = mysql_real_escape_string(trim($_POST['conroller']));

            $zoneid = mysql_real_escape_string(trim($_POST['zone']));
            
            $newzone=mysql_real_escape_string(trim($_POST['new_zone']));

            //Assign Default QOS Profile

            $ap_control = mysql_real_escape_string(trim($_POST['AP_contrl']));
            $ap_control_time = mysql_real_escape_string(trim($_POST['AP_contrl_time']));
            $get_duration_details=mysql_query("SELECT duration,profile_code FROM exp_products_duration WHERE id='$ap_control_time'");
            while($get_durations= mysql_fetch_assoc($get_duration_details) ){
                $ap_control_time1=$get_durations[duration];
                $ap_control_time2=$get_durations[profile_code];
            }

            $ap_control_guest = mysql_real_escape_string(trim($_POST['AP_contrl_guest']));
            $ap_control_guest_time = mysql_real_escape_string(trim($_POST['AP_contrl_guest_time']));

            $get_guest_duration_details=mysql_query("SELECT duration,profile_code FROM exp_products_duration WHERE id='$ap_control_guest_time'");
            while($get_guest_durations= mysql_fetch_assoc($get_guest_duration_details) ){
                $ap_control_guest_time1=$get_guest_durations[duration];
                $ap_control_guest_time2=$get_guest_durations[profile_code];
            }





        $live_user_name = $_SESSION['user_name'];
        $account_edit = $_POST['edit_account'];
        $edit_distributor_code = $_POST['edit_distributor_code'];
        $edit_distributor_id = $_POST['edit_distributor_id'];


        $user_type_current = "SELECT user_type FROM admin_users WHERE user_name = '$live_user_name'";
        $query_results = mysql_query($user_type_current);
        while ($row = mysql_fetch_array($query_results)) {
            $utype = $row[user_type];
        }


        if ($utype == 'MNO') {

            $query_code = "SELECT user_distributor FROM admin_users u WHERE u.user_name = '$live_user_name'";

            $query_results = mysql_query($query_code);
            while ($row = mysql_fetch_array($query_results)) {
                $mno_id = $row[user_distributor];
            }
        } else {

            $query_code = "SELECT user_distributor, d.id, d.mno_id
			FROM admin_users u, exp_mno_distributor d
			WHERE u.user_distributor = d.distributor_code AND u.user_name = '$live_user_name'";

            $query_results = mysql_query($query_code);
            while ($row = mysql_fetch_array($query_results)) {
                $user_distributor1 = $row[user_distributor];
                $mno_id = $row[mno_id];
            }

        }
        
        
        //////////////////
        
	        if($newzone!=NULL || $newzone!=''){
	        	
	        	//echo 'enter';
        	 
        	$profile1 = $db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$ap_controller'");
        	if ($profile1 == '') {
        		$profile1 = $db->setVal('wag_ap_name', 'ADMIN');
        		if ($profile1 == '') {
        			$profile1 = "non";
        		}
        	}
        	 
        	 
        	//echo $profile1;
        	require_once 'src/AP/' . $profile1 . '/index.php';
        	 
        	$wag_obj1 = new ap_wag($ap_controller);
        	 
        	$create_zone = $wag_obj1->createzone($newzone,$newzone,'Asf12#12');
        	 
        	//print_r($create_zone);
        	parse_str($create_zone);
        	 
        	$json_zone= json_decode($Description,true);
        	 
        	$zoneid=$json_zone[id];
        	 
        	if($status_code=='200'){
        		 
        		 $query0 = "INSERT INTO exp_distributor_zones (zoneid,name,ap_controller,create_user,create_date)
        		values ('$zoneid','$newzone','$ap_controller','',now())";
        		 
        		$zoneq=mysql_query($query0);
        		 
        		if($zoneq){        			 
        			$zonecreate=1;
        		}else{        			 
        			$zonecreate=0;
        		}
        		         		 
        	}else{        		 
        		$zonecreate=0;
        	}
        	         	 
        }else{        	 
        	$zonecreate=1;        	 
        }


        if($create_location_btn_action =='create_location_next' || $create_location_btn_action=='add_location_next'){
            $edit_parent_id = $parent_code;
            $edit_parent_ac_name = $parent_ac_name;
            $edit_first_name = $mno_first_name;
            $edit_last_name = $mno_last_name;
            $edit_email = $mvnx_email;
            $edit_parent_package = $parent_package;
        }
        
        if ($account_edit == '1') {
        if($create_location_btn_action!='add_location_next'){
            //1
            //account update
            //echo $edit_distributor_code;
            $get_unique_q = "SELECT `unique_id` FROM `exp_mno_distributor` WHERE `distributor_code`='$edit_distributor_code'";
            //echo $get_unique_q;
            $get_unique = mysql_query($get_unique_q);

            while ($row_u = mysql_fetch_assoc($get_unique)) {
                $edit_unique_id = $row_u['unique_id'];
            }

            if ($wag_ap_name == 'NO_PROFILE') {
                //API not call//
                $status_code = '200';
            } else {
                $api_details=$package_functions->callApi('ACC_CREATE_API', $system_package,'YES');
                //print_r($api_details);
                if( $api_details['access_method']=='1') { // 'YES' returns option column data

                    $profile = $db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$ap_controller'");
                    if ($profile == '') {
                        $profile = $db->setVal('wag_ap_name', 'ADMIN');
                        if ($profile == '') {
                            $profile = "non";
                        }
                    }


                    //echo $profile;
                    require_once 'src/AP/' . $profile . '/index.php';

                    $wag_obj = new ap_wag($ap_controller);
                    $zon_details=$wag_obj->retrieveZonedata($zoneid);
                    $status_code='0';

                    if($gateway_type=='WAG' || $pr_gateway_type=='WAG') {

                        if ($wag_enable == "on") {

                            $gre_profile_id = $db->getValueAsf("SELECT `filt_gre_profile` AS f FROM `exp_wag_profile` WHERE `wag_code`='$wag_name'");
                            $gre_profile_name = $db->getValueAsf("SELECT `profile_name` AS f FROM `exp_gre_profiles` WHERE `profile_id`='$gre_profile_id'");


                            //$modi_zone = $wag_obj->modifyzone($zoneid, $tunnel, $gre_profile_id, $gre_profile_name);


                            $modufy_tunnel = $wag_obj->modifyTunnelProfile($zoneid, $gre_profile_id, $gre_profile_name);
                            parse_str($modufy_tunnel);

                            $wag_enable = '1';

                            if ($status_code == '200') {
                                $status_code1 = '200';
                            }

                        } else {
                            $gre_profile_id = $db->getValueAsf("SELECT `reg_gre_profile` AS f FROM `exp_wag_profile` WHERE `wag_code`='$wag_name'");
                            $gre_profile_name = $db->getValueAsf("SELECT `profile_name` AS f FROM `exp_gre_profiles` WHERE `profile_id`='$gre_profile_id'");


                            //$modi_zone = $wag_obj->modifyzone($zoneid, $tunnel, $gre_profile_id, $gre_profile_name);


                            $modufy_tunnel = $wag_obj->modifyTunnelProfile($zoneid, $gre_profile_id, $gre_profile_name);
                            parse_str($modufy_tunnel);

                            $wag_enable = '0';

                            if ($status_code == '200') {
                                $status_code1 = '200';
                            }
                        }
                    }else{
                      if ($wag_enable == "on") {
                    		
                        $wag_enable = 1;
                        
                    	}else{
                    		
                    		$wag_enable = 0;
                    	}
                        $status_code1 = '200';
                    }
                    $status_code='0';

                     //$zon_details=$wag_obj->retrieveZonedata($zoneid);
                    parse_str($zon_details);
                    if($status_code=='200'){

                        $ofset_ar=explode(':',$offset_val);

                        $Description=(array)json_decode($Description);
                        $time_zone=(array)$Description[timezone];
                        if($time_zone['systemTimezone']==NULL){
                            $cuzt_time_zone=(array)$time_zone['customizedTimezone'];

                            if((int)$cuzt_time_zone[gmtOffset]!=(int)$ofset_ar[0] || (int)$cuzt_time_zone[gmtOffsetMinute]!=(int)$ofset_ar[1]){

                                $time_Zone_update=$wag_obj->modifyZoneTimeZone($zoneid,$timezone_abbreviation,(int)$ofset_ar[0],(int)$ofset_ar[1]);
                                parse_str($time_Zone_update);
                                if($status_code=='200'){
                                     $status_code2='200';
                                }
                            }else{
                                $status_code2='200';
                            }

                        }else{

                            if($time_zone['systemTimezone']!=$mvnx_time_zone){

                                $time_Zone_update=$wag_obj->modifyZoneTimeZone($zoneid,$timezone_abbreviation,(int)$ofset_ar[0],(int)$ofset_ar[1]);

                                parse_str($time_Zone_update);
                                if($status_code=='200'){
                                     $status_code2='200';
                                }
                            }else{
                                $status_code2='200';
                            }
                        }

                        if($status_code1=='200' && $status_code2=='200'){
                            $status_code='200';
                        }else{
                            $status_code='0';
                        }
                    }
                    $wag_obj->retrieveZonedata($zoneid);
                } else {

                    $status_code = "200";
                }

            }
            //$status_code='200';
            if ($status_code == '200' && $zonecreate==1) {

                $query01 = "UPDATE
					  `exp_mno_distributor`
					SET
					  `gateway_type` = '$gateway_type',
					  `private_gateway_type` = '$pr_gateway_type',
					  `offset_val`='$offset_val',
					  `wag_profile_enable`='$wag_enable',
					  `wag_profile`='$wag_name',
					  `ap_controller`='$ap_controller',
					  `property_id`='$zone_name',
					  `zone_id`='$zoneid',
					  `system_package`='$customer_type',
                      `bussiness_type` = '$business_type',
                      `network_type`='$network_type',
					  `distributor_name` = '$location_name',
					  `tunnel_type`='$tunnel',
					  `private_tunnel_type`='$pr_tunnel',
					  `category` = '$category_mvnx',
					  `num_of_ssid` = '$mvnx_num_ssid',
					  `bussiness_address1` = '$mvnx_address_1',
					  `bussiness_address2` = '$mvnx_address_2',
					  `bussiness_address3` = '$mvnx_address_3',
					  `country` = '$mvnx_country',
					  `state_region` = '$mvnx_state',
					  `zip` = '$mvnx_zip_code',
					  `phone1` = '$mvnx_mobile_1',
					  `phone2` = '$mvnx_mobile_2',
					  `phone3` = '$mvnx_mobile_3',
					  `time_zone`='$mvnx_time_zone'
					 
					WHERE `id` = '$edit_distributor_id'";

               /* $query02 = "UPDATE
			  `admin_users`
			SET
			`verification_number`='$icomme_number',
			  `full_name` = '$mvnx_full_name',
			  `email` = '$mvnx_email',
			  `mobile` = '$mvnx_mobile_1'
			WHERE `user_distributor` = '$edit_distributor_code' AND access_role='admin'"; */

                if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$customer_type)=='NO' ) {
                    $query03 = "UPDATE
                  `exp_distributor_groups`
                SET

                  `group_name` = '$zone_name',
                  `description` = '$zone_dec',
                  `group_number` = '$realm',
                  `create_date` = NOW()
                WHERE `distributor` = '$edit_distributor_code' ";
                }

                mysql_query(
                   "INSERT INTO `exp_products_distributor_archive`
            (
             `product_code`,
             `product_id`,
             `product_name`,
             `QOS`,
             `QOS_up_link`,
             `distributor_code`,
             `network_type`,
             `time_gap`,
             `max_session`,
             `session_alert`,
             `active_on`,
             `purge_time`,
             `distributor_type`,
             `create_user`,
             `is_enable`,
             `create_date`,
             `last_update`,
             `archive_by`,
             `archive_date`)
             SELECT
		  `product_code`,
		  `product_id`,
		  `product_name`,
		  `QOS`,
		  `QOS_up_link`,
		  `distributor_code`,
		  `network_type`,
		  `time_gap`,
		  `max_session`,
		  `session_alert`,
		  `active_on`,
		  `purge_time`,
		  `distributor_type`,
		  `create_user`,
		  `is_enable`,
		  `create_date`,
		  `last_update`,
		  '$user_name',
		  NOW()
		FROM `exp_products_distributor`
		WHERE distributor_code='$edit_distributor_code'"
        );


                mysql_query("DELETE FROM `exp_products_distributor` WHERE  `distributor_code`='$edit_distributor_code'");



              $query04="INSERT INTO `exp_products_distributor`
            (`product_code`,
             `product_id`,
             `product_name`,
             `QOS`,
             `QOS_up_link`,
             `distributor_code`,
             `network_type`,
             `max_session`,
             `session_alert`,
             `purge_time`,
             `create_user`,
             `is_enable`,
             `create_date`)
             SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$edit_distributor_code',`network_type`,
             `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
             FROM `exp_products` WHERE `product_id` IN ('$ap_control_guest','$ap_control')";


                $duration_profil_1="UPDATE exp_products_distributor SET time_gap='$ap_control_guest_time1',duration_prof_code='$ap_control_guest_time2' WHERE distributor_code='$edit_distributor_code' AND network_type='guest'";
                $duration_profil_2="UPDATE exp_products_distributor SET time_gap='$ap_control_time1',duration_prof_code='$ap_control_time2' WHERE distributor_code='$edit_distributor_code' AND network_type='private'";




                $up01 = mysql_query($query01);
                //$up02 = mysql_query($query02);
                $up03 = mysql_query($query03);
                $up04 = mysql_query($query04);
                $up05 = mysql_query($duration_profil_1);
                $up06 = mysql_query($duration_profil_2);
                //$up05 = mysql_query($query05);

                /////////////////////support role/////////////////

                
                $ssmsg=$message_functions->showNameMessage('property_send_email_failed',$location_name_s);
        
                
                
                

                if ($up01 &&  $up03 && $up04 && $up05 && $up06 ) {
                    $success_msg = $message_functions->showNameMessage('property_creation_success',$location_name_s);// "Account [" . $location_name_s . "] has been updated";
                    $sess_msg_id = 'msg_location_update';
                    $_SESSION[msg5] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                } else {
                    $success_msg = $message_functions->showNameMessage('property_creation_failed',$location_name_s,2002); //"[2002] Account [" . $location_name_s . "] update failed";
                    $sess_msg_id = 'msg_location_update';
                    $_SESSION[msg5] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                }
            } else {
                $success_msg = $message_functions->showNameMessage('property_creation_failed',$location_name_s,2009); //"[2009] Account [" . $location_name_s . "] update failed";
                $sess_msg_id = 'msg_location_update';
                $_SESSION[msg5] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
            }

            //$_SESSION[$sess_msg_id] = "<div class='alert alert-".$al_type."><strong>" . $success_msg . "</strong><button type='button' class='close' data-dismiss='alert'>×</button></div>";
}
        } else {//1

            //new account insert//
            $br = mysql_query("SHOW TABLE STATUS LIKE 'exp_mno_distributor'");
            $rowe = mysql_fetch_array($br);
            $auto_inc = $rowe['Auto_increment'];
            $mvnx_id = $user_type1 . $auto_inc;
            $mvnx = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
            $unique_id = '2' . $mvnx;

            $dis_user_name = uniqid($mvnx_id);
            $parent_user_name = str_replace(' ', '_', strtolower(substr($mvnx_full_name, 0, 5) . $auto_inc));
            $password = randomPassword();
            $parend_password = randomPassword();

            $tz = $mvnx_time_zone;
            $theme = 'FB_MANUAL';
            $title = 'Welcome to ' . mysql_real_escape_string($location_name_s);

            // echo $wag_ap_name;
            if ($wag_ap_name == 'NO_PROFILE') {
                //API not call//
                $status_code = '200';
            }
            else {

                $api_details=$package_functions->callApi('ACC_CREATE_API', $system_package,'YES');
                //print_r($api_details);
                if( $api_details['access_method']=='1') { // 'YES' returns option column data

                    $profile = $db->getValueAsf("SELECT `api_profile` AS f FROM `exp_locations_ap_controller` WHERE `controller_name` = '$ap_controller'");
                    if ($profile == '') {
                        $profile = $db->setVal('wag_ap_name', 'ADMIN');
                        if ($profile == '') {
                            $profile = "non";
                        }
                    }


                    //echo $profile;
                    require_once 'src/AP/' . $profile . '/index.php';

                    $wag_obj = new ap_wag($ap_controller);
                    $status_code = '0';

                    $zon_details=$wag_obj->retrieveZonedata($zoneid);
                    parse_str($zon_details,$zone_details_ar);


                    if ($gateway_type == 'WAG' || $pr_gateway_type=='WAG') {

                        if ($wag_enable == "on") {
                            $gre_profile_id = $db->getValueAsf("SELECT `filt_gre_profile` AS f FROM `exp_wag_profile` WHERE `wag_code`='$wag_name'");
                            $gre_profile_name = $db->getValueAsf("SELECT `profile_name` AS f FROM `exp_gre_profiles` WHERE `profile_id`='$gre_profile_id'");
                            $wag_enable = '1';
                        }else{
                            //$gre_profile_id = $db->getValueAsf("SELECT `reg_gre_profile` AS f FROM `exp_wag_profile` WHERE `wag_code`='$wag_name'");
                            //$gre_profile_name = $db->getValueAsf("SELECT `profile_name` AS f FROM `exp_gre_profiles` WHERE `profile_id`='$gre_profile_id'");
                            $wag_enable = '0';
                        }

                        //$modi_zone = $wag_obj->modifyzone($zoneid, $tunnel, $gre_profile_id, $gre_profile_name);
                        //parse_str($modi_zone,$modi_zone_res_ar);
                        //$modi_zone_res_ar['status_code']='200';

                    }


                    if($zone_details_ar['status_code']=='200'){

                        $ofset_ar=explode(':',$offset_val);

                        $time_Zone_update=$wag_obj->modifyZoneTimeZone($zoneid,$timezone_abbreviation,(int)$ofset_ar[0],(int)$ofset_ar[1]);
                        parse_str($time_Zone_update,$time_Zone_update_resp);

                    }


                    if ($gateway_type == 'WAG' || $pr_gateway_type=='WAG') {
                        if ($wag_enable == "1") {
                            $modufy_tunnel = $wag_obj->modifyTunnelProfile($zoneid, $gre_profile_id, $gre_profile_name);
                            parse_str($modufy_tunnel, $modufy_tunnel_resp);

                        }else{
                            $modufy_tunnel_resp['status_code']='200';
                        }
                    }else{
                    	
                    	if ($wag_enable == "on") {
                    		
                        $wag_enable = 1;
                        
                    	}else{
                    		
                    		$wag_enable = 0;
                    	}

                        $modufy_tunnel_resp['status_code'] = '200';
                    }
                    //$status_code='0';
         
                    if($modufy_tunnel_resp['status_code']=='200' && $time_Zone_update_resp['status_code']=='200'){
                        $status_code = "200";
                    }else{
                        $status_code = "0";
                    }

                    
                   ////////////////////////////////////////// 
                    //$private_password=randomPasswordlength(8);

                    $wag_obj->retrieveZonedata($zoneid);

                } else {
                    $status_code = "200";
                }

                //$status_code = "200";

            }
            // echo $mvnx_id; $ap_controller  ap_controller
            
            ////////theme submit////////////
            
            $package_btitle=$package_functions->getOptions("BROWSER_TITLE", $system_package);
            
            if($package_btitle==''||$package_btitle==NULL){
            	
            	$package_btitle ='Welcome to Guest WiFi Access';
            }
            
            //$theme_id=$mvnx_id.'_default';
            //$theme_name=$cusbiss_name.'-GUEST-ModernHorizontal-'.date("Y-m-d H:i:s");
            
            //$welcome_text='<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Courtesy Services Provided by '.$cusbiss_name.'</span></p>';
            
            //$query_them = "";

            $theme_vars = array(
                '{$mvnx_id}' => $mvnx_id,
                '{$cusbiss_name}' => $cusbiss_name,
                '{$package_btitle}' => $package_btitle,
                '{$user_name}' => $user_name,
                '{$icomme_number}' => $icomme_number
            );

            $theme_q=$package_functions->getOptions('INIT_THEME',$customer_type);
            $query_them = strtr($theme_q, $theme_vars);
            

            mysql_query($query_them);

            $parent_product = $_POST['parent_package_type'];//$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);
            
            ///////////////////////////////
            
            $query01 = "INSERT INTO `exp_mno_distributor` (parent_id,`gateway_type`,`private_gateway_type`,`offset_val`,`wag_profile_enable`,`wag_profile`,`property_id`,`verification_number`,`network_type`,`ap_controller`,`system_package`,`zone_id`,`tunnel_type`,`private_tunnel_type`,`unique_id`,`distributor_code`, `distributor_name`,`bussiness_type`, `distributor_type`,`category`,num_of_ssid, `mno_id`, `parent_code`,`bussiness_address1`,`bussiness_address2`,`bussiness_address3`,`country`,`state_region`,`zip`,`phone1`,`phone2`,`phone3`,theme,site_title,time_zone,`language`,`is_enable`,`create_date`,`create_user`)
				 	VALUES ('$parent_code','$gateway_type','$pr_gateway_type','$offset_val','$wag_enable','$wag_name','$zone_name','$icomme_number','$network_type','$ap_controller','$customer_type','$zoneid','$tunnel','$pr_tunnel','$unique_id','$mvnx_id', '$location_name', '$business_type','$user_type1','$category_mvnx','$mvnx_num_ssid', '$mno_id', '$user_distributor1','$mvnx_address_1','$mvnx_address_2','$mvnx_address_3','$mvnx_country','$mvnx_state','$mvnx_zip_code','$mvnx_mobile_1','$mvnx_mobile_2','$mvnx_mobile_3','$theme','$title','$tz','en','0',now(),'$live_user_name')";


            $query03 = "INSERT INTO mno_distributor_parent (account_name,parent_id, system_package, mno_id, create_date, create_user) VALUES ('$parent_ac_name','$parent_code', '$parent_product','$mno_id', NOW(),'$user_name')";

            $query02 = "INSERT INTO `admin_users` (`user_name`,`verification_number`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `is_enable`, `create_date`,`create_user`)
			VALUES ('$dis_user_name','$icomme_number',PASSWORD('$password'), 'admin', '$user_type1','$mvnx_id', '', '', '', '8', NOW(),'$user_name')";

            $query04 = "INSERT INTO `admin_users` (`user_name`,`verification_number`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `is_enable`, `create_date`,`create_user`)
			VALUES ('$parent_user_name','$parent_code',PASSWORD('$parend_password'), 'admin', 'MVNO_ADMIN','$parent_code', '$mvnx_full_name', '$mvnx_email', '$mvnx_mobile_1', '2', NOW(),'$user_name')";

            if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$customer_type)=='NO' ) {
                $distributor_group = "INSERT INTO `exp_distributor_groups` (`group_name`,`description`,`group_number`,`distributor`,`create_date`)
								VALUES ('$icomme_number','$zone_dec','$realm','$mvnx_id',NOW())";
            }
            $distributor_group_tag = "INSERT INTO `exp_mno_distributor_group_tag` (
                                  `tag_name`,
                                  `description`,
                                  `distributor`,
                                  `create_date`,
                                  `create_user`
                                )
                                VALUES
                                  (
                                    '$icomme_number',
                                    '$zone_dec',
                                    '$mvnx_id',
                                    NOW(),
                                    '$user_name'
                                  )";


            $profile_venue = "INSERT INTO `exp_products_distributor`
            (`product_code`,
             `product_id`,
             `product_name`,
             `QOS`,
             `QOS_up_link`,
             `distributor_code`,
             `network_type`,
             `max_session`,
             `session_alert`,
             `purge_time`,
             `create_user`,
             `is_enable`,
             `create_date`)
             SELECT `product_code`,`product_id`,`product_name`, `QOS`,`QOS_up_link`,'$mvnx_id',`network_type`,
             `max_session`,`session_alert`,`purge_time`,'$user_name','1',NOW()
             FROM `exp_products` WHERE `product_id` IN ('$ap_control_guest','$ap_control')";
            
            
            $duration_profil_1="UPDATE exp_products_distributor SET time_gap='$ap_control_guest_time1',duration_prof_code='$ap_control_guest_time2' WHERE distributor_code='$mvnx_id' AND network_type='guest'";
            $duration_profil_2="UPDATE exp_products_distributor SET time_gap='$ap_control_time1',duration_prof_code='$ap_control_time2' WHERE distributor_code='$mvnx_id' AND network_type='private'";

            if($create_location_btn_action=='create_location_submit' || $create_location_btn_action=='add_location_submit'){
                if($_SESSION['new_location']=='yes'){

                    $success_msg = $message_functions->showNameMessage('venue_add_success',$location_name_s);
                }else{
                    $success_msg = $message_functions->showNameMessage('venue_create_success',$location_name_s);
                }
            }else{

                if($_SESSION['new_location']=='yes'){

                    $success_msg = $message_functions->showNameMessage('venue_add_success',$location_name_s);
                }else{
                    $success_msg = $message_functions->showNameMessage('venue_loc_add_success',$location_name_s);
                }
            }
            $sess_id = 'msg5';
            //$status_code = "200" ;$zonecreate=1;
        if ($status_code == "200" && $zonecreate==1) {//1



            if($create_location_btn_action=='create_location_submit' || $create_location_btn_action=='create_location_next'){
                $ex3 = mysql_query($query03);
                if($ex3){
                    $create_par='yes';
                }else{
                    $create_par='';
                }
            }else{
               $create_par='yes';
            }


            if($create_par=='yes') {
                $ex0 = mysql_query($query01);
                mysql_query($apquery1);

                mysql_query($apmno_dis1);

                if ($ap_mac2 != "") {
                    mysql_query($apquery2);
                    mysql_query($apmno_dis2);
                }

                if ($ap_mac3 != "") {

                    mysql_query($apquery3);
                    mysql_query($apmno_dis3);
                }


                // mysql_query($ssid_guest_query);
                // mysql_query($ssid_private_query);

                mysql_query($distributor_group);
                mysql_query($distributor_group_tag);

                mysql_query($profile_venue);
                mysql_query($duration_profil_1);
                mysql_query($duration_profil_2);
                //mysql_query($profile_venue2);
            }


            if ($ex0) {

            //create manual and auto  passcode
                $manua_passcode=randomPasswordlength(8);
                $auto_passcode=randomPasswordlength(8);
                mysql_query("INSERT INTO `exp_customer_vouchers`(`voucher_number`,`reference`,`voucher_type`,`type`,`redeem_count`,`voucher_status`,`create_date`,`create_user`) 
                            VALUES('$manua_passcode','$mvnx_id','DISTRIBUTOR','Manual','0','0',NOW(),'$user_name')");
                $ex0 = mysql_query($query02);
                if($create_location_btn_action=='create_location_submit' || $create_location_btn_action=='create_location_next'){
                    $ex4 = mysql_query($query04);
                }

                $passcode_renewal_time="08:00:00";
                $r = 'DATE_ADD(CONVERT_TZ(NOW(),\'SYSTEM\',\''.$offset_val.'\'),INTERVAL 1 WEEK)';
                $e = 'DATE_ADD(DATE_ADD(CONVERT_TZ(NOW(),\'SYSTEM\',\''.$offset_val.'\'),INTERVAL 1 WEEK),INTERVAL 12 HOUR)';
                
                //echo $r = 'CONVERT_TZ(DATE_ADD(CONCAT(DATE_FORMAT(CONVERT_TZ(NOW(),\'SYSTEM\',\''.$offset_val.'\'),\'%Y-%m-%d \'),\''.$passcode_renewal_time.'\'),INTERVAL 1 WEEK),\''.$offset.'\',\'SYSTEM\') ';
               // echo $e = 'CONVERT_TZ(DATE_ADD(DATE_ADD(CONCAT(DATE_FORMAT(CONVERT_TZ(NOW(),\'SYSTEM\',\''.$offset_val.'\'),\'%Y-%m-%d \'),\''.$passcode_renewal_time.'\') ,INTERVAL 1 WEEK),INTERVAL 12 HOUR),\''.$offset.'\',\'SYSTEM\') ';

                $auto_pass_ins_q="INSERT INTO `exp_customer_vouchers` (`voucher_prefix`,`reference_email`,`refresh_date`,frequency,buffer_duration,expire_date,start_date,type,`voucher_number`, `reference`, `voucher_type`,`redeem_count`, `voucher_status`, `create_date`, `create_user`)              
                              VALUES ('','$mvnx_email', $r ,'Weekly','12',$e , NOW(),'Auto','$auto_passcode', '$mvnx_id', 'DISTRIBUTOR', '0', '1', NOW(), '$user_name')";
                $insert_passcode=mysql_query($auto_pass_ins_q);

                if ($account_edit != '1') {//2
                    ///////////////Insert default settings////////////////////////////

                    $query10 = "INSERT INTO `exp_settings` (
			  `settings_name`,
			  `description`,
			  `category`,
			  `settings_code`,
			  `settings_value`,
			  `distributor`,
			  `create_date`,
			  `create_user`)
			  (SELECT
			  `settings_name`,
			  `description`,
			  `category`,
			  `settings_code`,
			  `settings_value`,
			  '$mvnx_id',
			  NOW(),
			  '$live_user_name'
			FROM
			  `exp_settings`
			WHERE distributor='ADMIN'
			AND settings_code IN ('ad_waiting','ad_welcome_page'))";

                    //  $ex10 = mysql_query($query10);

                    //////////////////////////////////////////////////

                    /*Email Notification*/
                    if($create_location_btn_action=='create_location_submit' || $create_location_btn_action=='add_location_submit' || $_SESSION['new_location']=='yes'){
                    $to = $mvnx_email;
                    $title=$db->setVal("short_title", $mno_id);

                        if($_SESSION['new_location']!='yes' ){

                            $subject = $db->textTitle('MAIL',$mno_id);
                            if(strlen($subject)==0){
                                $subject=$db->textTitle('ICOMMS_MAIL','ADMIN');
                            }

                        }else{
                            $subject = $db->textTitle('NEW_LOCATION_MAIL',$mno_id);
                            if(strlen($subject)==0){
                                $subject=$db->textTitle('NEW_LOCATION_MAIL','ADMIN');
                            }
                        }



                    $from=strip_tags($db->setVal("email", $mno_id));
                    if($from==''){
                        $from=strip_tags($db->setVal("email", 'ADMIN'));
                    }


                    $link = $db->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin';


                        if($_SESSION['new_location']!='yes' ){
                            //old
                            $a = $db->textVal('MAIL', $mno_id);
                            if(strlen($a)<1){
                                $a = $db->textVal('MAIL', 'ADMIN');
                            }

                        }else{
                            //new
                            $link = $db->setVal("global_url", "ADMIN");

                            $a = $db->textVal('NEW_LOCATION_MAIL', $mno_id);
                            if(strlen($a)<1){
                                $a = $db->textVal('NEW_LOCATION_MAIL', 'ADMIN');
                            }
                            $parent_code=$icomme_number;
                        }

                        //echo $a;


                    if ($package_functions->getSectionType("VERIFI_METHORD", $system_package) == "number") {

                        $vars = array(
                            '{$user_full_name}' => $mvnx_full_name,
                            '{$short_name}' => $db->setVal("short_title", $mno_id),
                            '{$account_type}' => $user_type1,
                            '{$business_id}' => $parent_code,
                            '{$account_number}' => $parent_code,
                            '{$link}' => $link
                        );
                    }
                    else {
                        $vars = array(
                            '{$user_full_name}' => $mvnx_full_name,
                            '{$short_name}' => $db->setVal("short_title", $mno_id),
                            '{$account_type}' => $user_type1,
                            '{$user_name}' => $dis_user_name,
                            '{$password}' => $password,
                            '{$link}' => $link

                        );
                    }

                    $message_full = strtr($a, $vars);
                    $message = mysql_escape_string($message_full);

                    $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
					VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
                    $rrr = mysql_query($qu);
                    //if (getOptions('VENUE_ACTIVATION_TYPE', $system_package, $user_type) == "ICOMMS NUMBER" || $package_features == "all") {

                        $email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                        include_once 'src/email/'.$email_send_method.'/index.php';

                        //email template
                        $emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
                        $cunst_var=array();
                        if($emailTemplateType=='child'){
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$parent_product);
                        }elseif($emailTemplateType=='owen'){
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                        }elseif(strlen($emailTemplateType)>0){
                            $cunst_var['template']=$emailTemplateType;
                        }else{
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                        }
                        $mail_obj=new email($cunst_var);


                        $mail_sent=$mail_obj->sendEmail($from,$to,$subject,$message_full,'',$title);



                    }

                }//2


                $_SESSION[$sess_id] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";


            } else {
                $db->userErrorLog('2001', $user_name, 'script - ' . $script);

                if($_POST['add_new_location']='1'){

                    $success_msg = $message_functions->showNameMessage('venue_add_failed',$location_name_s,'2009');
                }else{

                    $success_msg = $message_functions->showNameMessage('venue_create_failed',$location_name_s,'2009');
                }

                $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$success_msg."</strong></div>";
            }


        }//1

            else {//1
                $db->userErrorLog('2009', $user_name, 'script - ' . $script);

                if($_POST['add_new_location']='1'){

                    $success_msg = $message_functions->showNameMessage('venue_add_failed',$location_name_s,'2009');
                }else{

                    $success_msg = $message_functions->showNameMessage('venue_create_failed',$location_name_s,'2009');
                }

                $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$success_msg."</strong></div>";
            }//1
        }//1



	}//key validation

	else{
        $db->userErrorLog('2004', $user_name, 'script - '.$script);

		$_SESSION['msg5']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
		header('Location: location.php');

		}
}//5


	////   Resend Email  /////
else
    if(isset($_POST['resendMail']) || isset($_GET['resendMail'])) {//5.1
	if($_SESSION['FORM_SECRET']==$_POST['form_secret5'] || $_SESSION['FORM_SECRET']==$_GET['form_secret5']){//refresh validate


		if(isset($_POST['resendMail'])){
            $distributor_code = $_POST['distributor_code'];
            $distributor_name = $_POST['distributor_name'];

        }else{
            $distributor_code = $_GET['distributor_code'];
            $distributor_name = $_GET['distributor_name'];
        }




		$query = "SELECT a.email,a.verification_number,a.full_name,a.user_type,e.* FROM admin_users a  LEFT JOIN `admin_invitation_email` e ON
                    a.user_distributor=e.distributor 
                    WHERE a.verification_number = '$distributor_code'";
		$result = mysql_query($query);

		while($row=mysql_fetch_array($result)){
            $resend_email=$row[email];
			$to = $row[to];
            $subject = $row[subject];
            $message = $row[message];
            $icomme_number=$row[verification_number];
            $f_name=$row[full_name];
            $user_type1=$row[user_type];
            
            $uname=$row[user_name];
            $pw_re=$row[password_re];
            
			//$header = $row[header];
			//$to = $row[to];
		}
        $customer_type=$db->getValueAsf("SELECT system_package AS f FROM mno_distributor_parent WHERE parent_id='$icomme_number'");
        $distributor_name=$db->getValueAsf("SELECT account_name AS f FROM mno_distributor_parent WHERE parent_id='$icomme_number'");

        $distributor_name=str_replace('\\','',$distributor_name);

        //$customer_type = 'COX_SIMP_001';

        if($resend_email!=$to){
            mysql_query("UPDATE admin_invitation_email SET `to`='$resend_email' WHERE `distributor` = '$distributor_code'");
        }

        $title=$db->setVal("short_title",$user_distributor);
     //   echo $user_distributor;
        $from=strip_tags($db->setVal("email", $user_distributor));
        if($from==''){
            $from=strip_tags($db->setVal("email", 'ADMIN'));
        }


        $email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
        include_once 'src/email/'.$email_send_method.'/index.php';

        //email template
        $emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
        $cunst_var=array();
        if($emailTemplateType=='child'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$customer_type);
        }elseif($emailTemplateType=='owen'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }elseif(strlen($emailTemplateType)>0){
            $cunst_var['template']=$emailTemplateType;
        }else{
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }

        $mail_obj=new email($cunst_var);
        
       
        
        
        
        
       // $to = $mvnx_email;
       // $title=$db->setVal("short_title", $mno_id);
        $subject = $subject = $db->textTitle('MAIL',$user_distributor);
        $link = $db->setVal("global_url", "ADMIN").'/verification_login.php?new_signin';
        

        
        
        if ($package_functions->getSectionType("VERIFI_METHORD", $system_package) == "number") {
        
        $vars = array(
        		'{$user_full_name}' => $f_name,
        		'{$short_name}' => $db->setVal("short_title", $user_distributor),
        		'{$account_type}' => $user_type1,
        		'{$business_id}' => $icomme_number,
        		'{$link}' => $link
        );
        } else {
        	$vars = array(
        			'{$user_full_name}' => $f_name,
        			'{$short_name}' => $db->setVal("short_title", $user_distributor),
        			'{$account_type}' => $user_type1,
        			'{$user_name}' => $uname,
        			'{$password}' => $pw_re,
        			'{$link}' => $link
        
        	);
        }        
        
        $a = $db->textVal('MAIL', $user_distributor);
        $message_full = strtr($a, $vars);


        $mail_sent=$mail_obj->sendEmail($from,$resend_email,$subject,$message_full,'',$title);

        if($mail_sent){
        	
        	$ssmsg=$message_functions->showNameMessage('property_send_email_suceess',$distributor_name);
        	
        	$create_log->save('3001',$ssmsg,'');
            $_SESSION['msg11']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$ssmsg."</strong></div>";
        }else{
        	
        	$ssmsg=$message_functions->showNameMessage('property_send_email_failed',$distributor_name);
        	 
        	$create_log->save('2001',$ssmsg,'');
            $_SESSION['msg11']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$ssmsg."</strong></div>";
        }
	}else{
        $db->userErrorLog('2004', $user_name, 'script - '.$script);
        $create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');

		$_SESSION['msg11']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
		//header('Location: location.php');

		}
}//5.1



	//Remove Locations///
else if(isset($_GET['remove_loc_id'])){//8



	if($_SESSION['FORM_SECRET']==$_GET['token7']){//refresh validate

        $remove_loc_id = $_GET['remove_loc_id'];
        $remove_loc_name =mysql_real_escape_string($_GET['remove_loc_name']) ;
        $remove_loc_code = $_GET['remove_loc_code'];
		$tab_display = $_GET['t'];

		if($tab_display=='1'){
			$session_id='msg12';
			}else{
				$session_id='msg11';
				}

        //$user_name = $_SESSION['user_name'];

        //archive distributor attached APs
        $rm_dis_unique_q="SELECT `unique_id` FROM `exp_mno_distributor` WHERE `id`='$remove_loc_id' LIMIT 1";
        $rm_dis_unique_arr=mysql_query($rm_dis_unique_q);
        while($row=mysql_fetch_assoc($rm_dis_unique_arr)){
            $rm_dis_unique=$row[unique_id];
        }


//	$wag_ap_name='NO_PROFILE';
        if ($wag_ap_name != 'NO_PROFILE') {


      //  echo $package_functions->callApi('ACC_DELETE_API',$system_package);
        if($package_functions->callApi('ACC_DELETE_API',$system_package)=='1') {

//echo $wag_ap_name2;

            $ap_control_var = $db->setVal('ap_controller', 'ADMIN');

                if ($ap_control_var == 'MULTIPLE') {

                    $get_distributor_zon_ap_q = "SELECT `zone_id`,`ap_controller` FROM `exp_mno_distributor` WHERE `distributor_code`='$remove_loc_code'";
                    $get_distributor_zon_ap_r = mysql_query($get_distributor_zon_ap_q);
                    while ($get_distributor_zon_ap = mysql_fetch_assoc($get_distributor_zon_ap_r)) {
                        $get_distributor_zon = $get_distributor_zon_ap[zone_id];
                        $get_distributor_ap = $get_distributor_zon_ap[ap_controller];
                    }

                    $ap_q2 = "SELECT `api_profile`
                    FROM `exp_locations_ap_controller`
                    WHERE `controller_name`='$get_distributor_ap'
                    LIMIT 1";

                    $query_results_ap2 = mysql_query($ap_q2);
                    while ($row = mysql_fetch_array($query_results_ap2)) {
                        $wag_ap_name2 = $row['api_profile'];
                    }

                    //echo 'src/AP/' . $wag_ap_name2 . '/index.php';

                    include 'src/AP/' . $wag_ap_name2 . '/index.php';
                    if ($wag_ap_name2 == "") {
                        include 'src/AP/' . $wag_ap_name . '/index.php';
                    }

                    $dis_wag_obj = new ap_wag($get_distributor_ap);

                } else if ($ap_control_var == 'SINGLE') {


                    include 'src/AP/' . $wag_ap_name . '/index.php';
                    $dis_wag_obj = new ap_wag();

                }

                $get_dis_schedule_q="SELECT `uniqu_id` FROM `exp_distributor_network_schedul` WHERE `distributor_id`='$remove_loc_code' GROUP BY `uniqu_id`";
                $get_dis_schedule_r=mysql_query($get_dis_schedule_q);
                while($get_dis_schedule=mysql_fetch_assoc($get_dis_schedule_r)) {
                    $dis_wag_obj->deleteeScheduler($get_distributor_zon, $get_dis_schedule[uniqu_id]);
                }

               // $remove_ruc_zone=$dis_wag_obj->deletezone($get_distributor_zon);
               // parse_str($remove_ruc_zone);

               //********************************delete network in zone////////////////////////////////////////////////
                $get_network_ids_q="SELECT network_id as id FROM exp_locations_ssid WHERE distributor='$remove_loc_code'
                                    UNION
                                    SELECT network_id as id FROM exp_locations_ssid_private WHERE distributor='$remove_loc_code'";
                $get_network_ids=mysql_query($get_network_ids_q);
                while($get_network_ids_r=mysql_fetch_assoc($get_network_ids)){
                    $dis_wag_obj->deleteSSID($get_distributor_zon,$get_network_ids_r['id']);
                }
                //echo $status_code."****";
                $status_code = 200; // NO API check with account deletion
                // end  $package_functions->callApi('ACC_DELETE_API',$system_package)=='1' *******************************************************
            }
            else{
            	$status_code = 200;
            }
        }else{
            $status_code =200;

        }

        if($status_code==200){


            //distributor aps archive
            $query_distrutor_aps_archive = "INSERT INTO `exp_mno_distributor_aps_archive` (
                  `id`,
                  `distributor_code`,
                  `ap_code`,
                  `assign_date`,
                  `assigned_by`,
                  `archive_by`,
                  `archive_date`
                  )(SELECT
                  `id`,
                  `distributor_code`,
                  `ap_code`,
                  `assign_date`,
                  `assigned_by`,
                   '$user_name',
                   NOW()
                FROM
                  `exp_mno_distributor_aps`
                WHERE distributor_code='$remove_loc_code') ";

            $ex1 = mysql_query($query_distrutor_aps_archive);



            //archive distributor

            $query_distrutor_archive = "INSERT INTO `exp_mno_distributor_archive` (

                                        id,
                                        verification_number,
                                        zone_id,
                                        ap_controller,
                                        tunnel_type,
                                        wag_profile,
                                        wag_profile_enable,
                                        distributor_code,
                                        property_id,
                                        distributor_name,
                                        bussiness_type,
                                        distributor_type,
                                        system_package,
                                        network_type,
                                        category,
                                        num_of_ssid,
                                        mno_id,
                                        parent_code,
                                        bussiness_address1,
                                        bussiness_address2,
                                        bussiness_address3,
                                        country,
                                        state_region,
                                        zip,
                                        phone1,
                                        phone2,
                                        phone3,
                                        bg_image,
                                        logo_image,
                                        theme,
                                        time_zone,
                                        language,
                                        site_title,
                                        theme_logo,
                                        theme_style_type,
                                        theme_top_line_color,
                                        camp_theme_color,
                                        theme_light_color,
                                        default_campaign_id,
                                        is_enable,
                                        create_date,
                                        create_user,
                                        last_update_ar,
                                        unique_id,
                                        archive_by,
                                        archive_date)

                   (
                  SELECT
                  id,
                                        verification_number,
                                        zone_id,
                                        ap_controller,
                                        tunnel_type,
                                        wag_profile,
                                        wag_profile_enable,
                                        distributor_code,
                                        property_id,
                                        distributor_name,
                                        bussiness_type,
                                        distributor_type,
                                        system_package,
                                        network_type,
                                        category,
                                        num_of_ssid,
                                        mno_id,
                                        parent_code,
                                        bussiness_address1,
                                        bussiness_address2,
                                        bussiness_address3,
                                        country,
                                        state_region,
                                        zip,
                                        phone1,
                                        phone2,
                                        phone3,
                                        bg_image,
                                        logo_image,
                                        theme,
                                        time_zone,
                                        language,
                                        site_title,
                                        theme_logo,
                                        theme_style_type,
                                        theme_top_line_color,
                                        camp_theme_color,
                                        theme_light_color,
                                        default_campaign_id,
                                        is_enable,
                                        create_date,
                                        create_user,
                                        last_update,
                                        unique_id,
                                        '$user_name',
                                      NOW()
                                    FROM
                                      exp_mno_distributor
                                      WHERE
                                    id='$remove_loc_id' LIMIT 1)";

            $ex2 = mysql_query($query_distrutor_archive);

            //admin user archive

                $query_admin_user_archive="INSERT INTO `admin_users_archive` (
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  `archive_by`,
                  `archive_date`,
                  `last_update`
                )

                  (
                SELECT
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  '$user_name',
                  NOW(),
                  `last_update`
                FROM `admin_users`
                WHERE
                  `user_distributor`='$remove_loc_code'
                  ) ";
            $ex3=mysql_query($query_admin_user_archive);



            //distributor group arcque
                $query_group_archive="INSERT INTO `exp_distributor_groups_archive` (
                      `id`,
                      `group_name`,
                      `description`,
                      `group_number`,
                      `distributor`,
                      `create_date`,
                      `last_update`,
                      `archive_by`,
                      `archive_date`
                    )

                      (
                    SELECT
                      `id`,
                      `group_name`,
                      `description`,
                      `group_number`,
                      `distributor`,
                      `create_date`,
                      `last_update`,
                       '$user_name',
                       NOW()
                    FROM
                      `exp_distributor_groups`
                      WHERE distributor='$remove_loc_code'
                      )";

            $ex4=mysql_query($query_group_archive);


//   schedule archive
            $archive_schedule_q="INSERT INTO `exp_distributor_network_schedul_archive` (
  `id`,
  `uniqu_id`,
  `uniqu_name`,
  `schedul_name`,
  `is_enable`,
  `schedul_description`,
  `network_method`,
  `distributor_id`,
  `day`,
  `active_fulltime`,
  `from`,
  `to`,
  `create_user`,
  `create_date`,
  `last_update`,
  `archive_by`,
  `archive_date`
)
SELECT
  `id`,
  `uniqu_id`,
  `uniqu_name`,
  `schedul_name`,
  `is_enable`,
  `schedul_description`,
  `network_method`,
  `distributor_id`,
  `day`,
  `active_fulltime`,
  `from`,
  `to`,
  `create_user`,
  `create_date`,
  `last_update`,
  '$user_name',
  NOW()
FROM
  `exp_distributor_network_schedul`
 WHERE `distributor_id`='$remove_loc_code'";


            $ex5=mysql_query($archive_schedule_q);



            //schedule assing archive

            $network_schedule_assign_archive_q="INSERT INTO `exp_distributor_network_schedul_assign_archive` (
  `id`,
  `ssid_broadcast`,
  `shedule_uniqu_id`,
  `network_id`,
  `ssid`,
  `distributor`,
  `network_method`,
  `create_date`,
  `create_user`,
  `last_update`
)
SELECT
  `id`,
  `ssid_broadcast`,
  `shedule_uniqu_id`,
  `network_id`,
  `ssid`,
  `distributor`,
  `network_method`,
  `create_date`,
  `create_user`,
  `last_update`
FROM
  `exp_distributor_network_schedul_assign`
  WHERE `distributor`='$remove_loc_code'";


            mysql_query($network_schedule_assign_archive_q);

            //distributor zone archive
            $distributor_zone_archive_q="INSERT INTO `exp_distributor_zones_archive` (
  `id`,
  `zoneid`,
  `search_id`,
  `name`,
  `ap_controller`,
  `create_user`,
  `create_date`,
  `last_update`,
  `archive_by`,
  `archive_date`
)
SELECT
  `id`,
  `zoneid`,
  `search_id`,
  `name`,
  `ap_controller`,
  `create_user`,
  `create_date`,
  `last_update`,
  '$user_name',
  NOW()
FROM
  `exp_distributor_zones`
WHERE `zoneid`='$get_distributor_zon'";

            mysql_query($distributor_zone_archive_q);
            
            
  $prduct_dist_ar="INSERT INTO `exp_products_distributor_archive` (
  `id`,
  `product_code`,
  `duration_prof_code`,
  `product_id`,
  `product_name`,
  `QOS`,
  `QOS_up_link`,
  `distributor_code`,
  `network_type`,
  `time_gap`,
  `max_session`,
  `session_alert`,
  `active_on`,
  `purge_time`,
  `distributor_type`,
  `create_user`,
  `is_enable`,
  `create_date`,
  `last_update`,
  `archive_by`,
  `archive_date`
) 
SELECT 
  `id`,
  `product_code`,
  `duration_prof_code`,
  `product_id`,
  `product_name`,
  `QOS`,
  `QOS_up_link`,
  `distributor_code`,
  `network_type`,
  `time_gap`,
  `max_session`,
  `session_alert`,
  `active_on`,
  `purge_time`,
  `distributor_type`,
  `create_user`,
  `is_enable`,
  `create_date`,
  `last_update`,
  '$user_name' ,
  NOW()  
FROM
  `exp_products_distributor` 
WHERE 
  distributor_code='$remove_loc_code'";

mysql_query($prduct_dist_ar);

            $voucher_ar =   "INSERT exp_customer_vouchers_archive
                    SELECT *,NOW(),'$user_name','delete mvno' FROM exp_customer_vouchers WHERE reference='$remove_loc_code'";

mysql_query($voucher_ar);

            if($ex1 && $ex2 && $ex3 && $ex4){

                //deloete disrtibutor attached aps
                $ex0=mysql_query("DELETE FROM `exp_mno_distributor_aps` WHERE `distributor_code` = '$remove_loc_code' ");

                //delete Distributor
                $ex9=mysql_query("DELETE FROM `exp_mno_distributor` WHERE `id` = '$remove_loc_id' ");

                //delete exp_settings
                $ex10=mysql_query("DELETE FROM `exp_settings` WHERE `distributor` = '$remove_loc_code' ");

                //delete admin_invitation_email
                $ex11=mysql_query("DELETE FROM `admin_invitation_email` WHERE `distributor` = '$remove_loc_code' ");
                //delete group
                $ex12=mysql_query("DELETE FROM `exp_distributor_groups` WHERE `distributor`='$remove_loc_code'");
                //delete admin users
                $ex13=mysql_query("DELETE FROM `admin_users` WHERE `user_distributor`='$remove_loc_code'");

                //delete power Schedule
                $ex14=mysql_query("DELETE FROM `exp_distributor_network_schedul` WHERE `distributor_id`='$remove_loc_code'");

                //delete power schedule assign
                $ex15=mysql_query("DELETE FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$remove_loc_code'");

                //delete zone
                $ex15=mysql_query("DELETE FROM `exp_distributor_zones` WHERE `zoneid`='$get_distributor_zon'");
                
                $ex16=mysql_query("DELETE FROM `exp_products_distributor` WHERE `distributor_code` = '$remove_loc_code'");

                $ex17=mysql_query("DELETE FROM exp_customer_vouchers WHERE reference='$remove_loc_code'");


            }

            if($ex0){

                $loc_rm_message = $message_functions->showNameMessage('account_remove_success',str_replace('\\','',$remove_loc_name));

                $_SESSION[$session_id]="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$loc_rm_message."</strong></div>";
            }

            else{
                $db->userErrorLog('2003', $user_name, 'script - '.$script);

                $loc_rm_message = $message_functions->showNameMessage('account_remove_failed',str_replace('\\','',$remove_loc_name),'2003');
                $_SESSION[$session_id]="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$loc_rm_message."</strong></div>";

            }
        }else{
            $db->userErrorLog('2009', $user_name, 'script - '.$script);

            $loc_rm_message = $message_functions->showNameMessage('account_remove_failed',str_replace('\\','',$remove_loc_name),'2009');

            $_SESSION[$session_id]="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$loc_rm_message."</strong></div>";

        }


        }//key validation

        else{

            $db->userErrorLog('2004', $user_name, 'script - '.$script);
            $_SESSION['msg5']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> ".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
            header('Location: location.php?t=5');
        }
    }//8

else if(isset($_GET['remove_par_id'])){

    $rm_par_q = "SELECT id, distributor_code FROM exp_mno_distributor WHERE parent_id='$_GET[remove_par_code]'";
    $rm_par_name_q = "SELECT account_name AS f FROM mno_distributor_parent WHERE parent_id='$_GET[remove_par_code]'";

    $rm_par_name = $db->getValueAsf($rm_par_name_q);

    $rm_par_r= mysql_query($rm_par_q);
    while($rm_row = mysql_fetch_assoc($rm_par_r)){
        $rmLocKey='remove_loc_id='.$rm_row['id'].'&remove_loc_code='.$rm_row['distributor_code'];
        $rmLocKey = cryptoJsAesEncrypt($data_secret,$rmLocKey);
        $rm_loc_url = $base_url.'/ajax/removeLocation.php?key='.urlencode($rmLocKey);
        httpGet($rm_loc_url);

    }

    mysql_query("DELETE FROM mno_distributor_parent WHERE parent_id='$_GET[remove_par_code]'");

    mysql_query("DELETE FROM admin_users WHERE verification_number='$_GET[remove_par_code]'");

    $loc_rm_message = $message_functions->showNameMessage('account_remove_success',str_replace('\\','',$rm_par_name));

    $_SESSION[msg5]="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$loc_rm_message."</strong></div>";


}


	//Edit Locations///
else if(isset($_GET['edit_loc_id'])){//8


if($_SESSION['FORM_SECRET']==$_GET['token7']){//refresh validate


$edit_loc_id=$_GET['edit_loc_id'];
$ex_get_q="SELECT d.property_id ,d.parent_id , d.gateway_type,d.private_gateway_type, d.wag_profile_enable,d.wag_profile, d.ap_controller,d.id, d.`zone_id`, d.`tunnel_type`,d.`private_tunnel_type`, d.`bussiness_type`, d.`network_type`, d.`distributor_code`,
 d.`distributor_name`, d.`distributor_type`, d.`system_package`, d.`category`, d.`num_of_ssid`,
 d.`bussiness_address1`, d.`bussiness_address2`, d.`bussiness_address3`, d.`country`, c.`country_name`,
  d.`state_region`, d.`zip`, d.`phone1`, d.`phone2`, d.`phone3`, d.`time_zone`, u.`full_name`,
  u.`email`, u.mobile, u.`verification_number`, g.`group_name`,
  g.`group_number`, g.`description`
FROM `exp_mno_distributor` d
LEFT JOIN exp_mno_country c ON d.`country` = c.`country_code`
LEFT JOIN `admin_users` u ON d.`distributor_code`=u.`user_distributor`
LEFT JOIN `exp_distributor_groups` g ON d.`distributor_code`=g.`distributor`
WHERE d.id='$edit_loc_id' LIMIT 1
";



    $ex_get=mysql_query($ex_get_q);

$rowE=mysql_fetch_array($ex_get);
$edit_distributor_code=$rowE[distributor_code];
$edit_distributor_ap_controller=$rowE[ap_controller];
$edit_distributor_group_name=$rowE[group_name];
$edit_distributor_property_id=$rowE[property_id];
$edit_distributor_group_description=$rowE[description];
$edit_distributor_wag_profile=$rowE[wag_profile];
$edit_distributor_wag_profile_enable=$rowE[wag_profile_enable];
$edit_distributor_group_number=$rowE[group_number];
$edit_distributor_zone_id=$rowE[zone_id];
$edit_distributor_tunnel_type=$rowE[tunnel_type];
$edit_distributor_pr_tunnel_type=$rowE[private_tunnel_type];
$edit_distributor_gateway_type=$rowE[gateway_type];
$edit_distributor_pr_gateway_type=$rowE[private_gateway_type];
$edit_distributor_business_type=$rowE[bussiness_type];
$edit_distributor_network_type=$rowE[network_type];
$edit_distributor_verification_number=$rowE[verification_number];
$edit_distributor_name=$rowE[distributor_name];
$edit_distributor_type=$rowE[distributor_type];
$edit_distributor_system_package=$rowE[system_package];
$edit_category=$rowE[category];
$edit_num_of_ssid=$rowE[num_of_ssid];
$edit_bussiness_address1=$rowE[bussiness_address1];
$edit_bussiness_address2=$rowE[bussiness_address2];
$edit_bussiness_address3=$rowE[bussiness_address3];
$edit_country_code=$rowE[country];
$edit_country_name=$rowE[country_name];
$edit_state_region=$rowE[state_region];
$edit_zip=$rowE[zip];
$edit_phone1=$rowE[phone1];
$edit_phone2=$rowE[phone2];
$edit_phone3=$rowE[phone3];
$edit_full_name=$rowE[full_name];
$exp_full_name=explode(' ',$edit_full_name);
$edit_first_name=$exp_full_name[0];
$edit_last_name=$exp_full_name[1];
$edit_email=$rowE[email];
$edit_mobile=$rowE[mobile];
$edit_timezone=$rowE[time_zone];
$edit_parent_id=$rowE[parent_id];

$edit_account=1;

 $query_realm_get = "SELECT `group_number` FROM `exp_distributor_groups` WHERE `distributor` = '$edit_distributor_code'";
$ex_get_ww=mysql_query($query_realm_get);
$rowf=mysql_fetch_array($ex_get_ww);
 $edit_distributor_realm=$rowf[group_number];
 $edit_distributor_product_id_p=$db->getValueAsf("SELECT product_id AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='PRIVATE' LIMIT 1");
 $edit_distributor_product_id_g=$db->getValueAsf("SELECT product_id AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='GUEST' LIMIT 1");
 $edit_distributor_product_id_p_time=$db->getValueAsf("SELECT duration_prof_code AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='PRIVATE' LIMIT 1");
 $edit_distributor_product_id_g_time=$db->getValueAsf("SELECT duration_prof_code AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='GUEST' LIMIT 1");
 $edit_distributor_product_id_g_time_default=$db->getValueAsf("SELECT time_gap AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='GUEST' LIMIT 1");



    $ex_parent_q = "SELECT p.account_name,u.full_name,email,p.system_package FROM mno_distributor_parent p JOIN admin_users u ON p.parent_id=u.verification_number WHERE p.parent_id='$edit_parent_id'";

    $ex_parent_R = mysql_query($ex_parent_q);
    while($prRow=mysql_fetch_assoc($ex_parent_R)){
        $edit_parent_ac_name = $prRow['account_name'];
        $edit_parent_package = $prRow['system_package'];
        $edit_email = $prRow['email'];
        $edit_full_name = $prRow['full_name'];
        $edit_full_name = explode(" ",$edit_full_name);
        $edit_first_name = $edit_full_name[0];
        $edit_last_name = $edit_full_name[1];
    }
//$edit_distributor_realm


}//key validation

        else{

            $db->userErrorLog('2004', $user_name, 'script - '.$script);
            $_SESSION['msg5']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
            header('Location: location.php?t=5');
        }



}//9




	//Edit CPE///
else if(isset($_GET['edit_ap_id'])){//10


if($_SESSION['FORM_SECRET']==$_GET['token7']){//refresh validate


$edit_ap_id=$_GET['edit_ap_id'];
$edit_loc_code=$_GET['edit_loc_code'];
$edit_loc_name=mysql_real_escape_string($_GET['edit_loc_name']) ;

$ex_get=mysql_query("SELECT * FROM `exp_locations_ap` a
WHERE a.id='$edit_ap_id' LIMIT 1
");

$rowE=mysql_fetch_array($ex_get);

    $guest_enable=$rowE[guest_enable];

    $edit_ap_name=$rowE[ap_name];
    $edit_ap_code=$rowE[ap_code];
    $edit_ap_description=$rowE[ap_description];
    $edit_ap_mac_address=$rowE[mac_address];
    $edit_ap_wifi_radio=$rowE[wifi_radio];
    $edit_ap_mno=$rowE[mno];
    $edit_ap_private_upload_cpe=$rowE[private_upload_cpe];
    $edit_ap_private_download_cpe=$rowE[private_download_cpe];
    $edit_ap_private_ip=$rowE[private_ip];
    $edit_ap_private_netmask=$rowE[private_netmask];
    $edit_ap_private_max_users=$rowE[private_max_users];
    $edit_ap_private_dns1=$rowE[private_dns1];
    $edit_ap_private_dns2=$rowE[private_dns2];
    $edit_ap_guest_upload_cpe=$rowE[guest_upload_cpe];
    $edit_ap_guest_download_cpe=$rowE[guest_download_cpe];
    $edit_ap_guest_ip = $rowE[guest_ip];
    $edit_ap_guest_netmask = $rowE[guest_netmask];
    $edit_ap_guest_max_users = $rowE[guest_max_users];
    $edit_ap_guest_dns1 = $rowE[guest_dns1];
    $edit_ap_guest_dns2 = $rowE[guest_dns2];
    $edit_ap_guest_high_security = $rowE[guest_high_security];
    $edit_ap_guest_medium_security = $rowE[guest_medium_security];
    $edit_ap_guest_low_security = $rowE[guest_low_security];
    $edit_ap_guest_custom_security = $rowE[guest_custom_security];
    $edit_ap_portal = $rowE[portal_address];


$edit_cpe_account=1;




}//key validation

        else{

            $db->userErrorLog('2004', $user_name, 'script - '.$script);
            $_SESSION['msg5']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
            header('Location: location.php?t=5');
        }



}//10



//Remove CPE Mac///
else if(isset($_GET['rem_ap_id'])){//11


if($_SESSION['FORM_SECRET']==$_GET['token7']){//refresh validate


$remove_ap_id=$_GET['rem_ap_id'];
$remove_ap_name=$_GET['remove_ap_name'];

$get_mac=$db->getValueAsf("SELECT `mac_address` AS f FROM `exp_locations_ap` WHERE `id` = '$remove_ap_id'");


	if($wag_ap_name=='NO_PROFILE'){
			//API not call//
			$status_code='200';
			}
		else{
		//include 'src/AP/'.$wag_ap_name.'/index.php';
		//$test =  new ap_wag();
		$response=$test->cpeDelete($get_mac);
		//status=success&status_code=200&Description=invalid json - colon unexpected
		parse_str($response);
		}

		if($status_code==200){
	     //archive
		 $query_ap_archive = "INSERT INTO `exp_locations_ap_archive` (
                                      `ap_name`, `ap_code`, `ap_description`,mac_address,wifi_radio,mno,private_upload_cpe,`private_download_cpe`,`private_ip`,`private_netmask`,`private_max_users`,`private_dns1`,`private_dns2`,`guest_enable`,`guest_upload_cpe`,`guest_download_cpe`,`guest_ip`,`guest_netmask`,`guest_max_users`,`guest_dns1`,`guest_dns2`,guest_high_security,guest_medium_security,guest_low_security,guest_custom_security,`portal_address`,`create_user`,`create_date`,
									  `update_user`,
									  `update_date`) SELECT
									  `ap_name`, `ap_code`, `ap_description`,mac_address,wifi_radio,mno,private_upload_cpe,`private_download_cpe`,`private_ip`,`private_netmask`,`private_max_users`,`private_dns1`,`private_dns2`,`guest_enable`,`guest_upload_cpe`,`guest_download_cpe`,`guest_ip`,`guest_netmask`,`guest_max_users`,`guest_dns1`,`guest_dns2`,guest_high_security,guest_medium_security,guest_low_security,guest_custom_security,`portal_address`,`create_user`,`create_date`,
									  '$user_name',
									  NOW()
									FROM
									  `exp_locations_ap`
									WHERE id='$remove_ap_id'";

		$ex1 = mysql_query($query_ap_archive);

		if($ex1){
			//delete AP
			$ex0=mysql_query("DELETE FROM `exp_locations_ap` WHERE `id` = '$remove_ap_id' ");

			}

		if($ex0){

		    $rm_cpe_msg = $message_functions->showNameMessage('cpe_removing_success',$remove_ap_name);

			$_SESSION['msg13']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$rm_cpe_msg."</strong></div>";
		}else{
            $db->userErrorLog('2003', $user_name, 'script - '.$script);
            $rm_cpe_msg = $message_functions->showNameMessage('cpe_removing_failed',$remove_ap_name);
			$_SESSION['msg13']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$rm_cpe_msg."</strong></div>";
		}

		}
		else{
            $db->userErrorLog('2004', $user_name, 'script - '.$script);
            $rm_cpe_msg = $message_functions->showNameMessage('cpe_removing_failed',$remove_ap_name);
			$_SESSION['msg13']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$rm_cpe_msg."</strong></div>";
		}



}//key validation

        else{

            $db->userErrorLog('2004', $user_name, 'script - '.$script);
            $_SESSION['msg13']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
            header('Location: location.php?t=1');
        }



}//11
elseif(isset($_GET['edit_mno_id'])){
    if($_SESSION['FORM_SECRET']==$_GET['token10']){
        $edit_mno_id=$_GET['edit_mno_id'];
        $get_edit_mno_details_q="SELECT * FROM `exp_mno` WHERE `mno_id`='$edit_mno_id'";
        $get_edit_mno_details=mysql_query($get_edit_mno_details_q);
        while($mno_data=mysql_fetch_assoc($get_edit_mno_details)){
            $get_edit_mno_id=$mno_data['id'];
            $get_edit_mno_mno_id=$mno_data['mno_id'];
            $get_edit_mno_unique_id=$mno_data['unique_id'];
            $get_edit_mno_description=$mno_data['mno_description'];
            $get_edit_mno_mno_type=$mno_data['mno_type'];
            $get_edit_mno_ad1=$mno_data['bussiness_address1'];
            $get_edit_mno_ad2=$mno_data['bussiness_address2'];
            $get_edit_mno_ad3=$mno_data['bussiness_address3'];
           	$get_edit_mno_country=$mno_data['country'];
            $get_edit_mno_state_region=$mno_data['state_region'];
            $get_edit_mno_zip=$mno_data['zip'];
            $get_edit_mno_phone1=$mno_data['phone1'];
            $get_edit_mno_phone2=$mno_data['phone2'];
            $get_edit_mno_phone3=$mno_data['phone3'];
            $get_edit_mno_timezones=$mno_data['timezones'];

            $get_edit_mno_sys_pack=$mno_data['system_package'];

        }

        $get_edit_mno_details_q="SELECT `full_name`,`email`,`user_type`,`mobile` FROM `admin_users` WHERE `user_distributor`='$edit_mno_id' AND `access_role`='admin' LIMIT 1";
        $get_edit_mno_details=mysql_query($get_edit_mno_details_q);
        while($mno_data=mysql_fetch_assoc($get_edit_mno_details)){
            $get_edit_mno_fulname=$mno_data['full_name'];
            $get_edit_mno_user_type=$mno_data['user_type'];
            $get_ful_name_array=explode(' ', $get_edit_mno_fulname,2);
            $get_edit_mno_first_name=$get_ful_name_array[0];
            $get_edit_mno_last_name=$get_ful_name_array[1];
            $get_edit_mno_email=$mno_data['email'];
            $get_edit_mno_mobile=$mno_data['mobile'];

        }

        $get_ap_controllers_q="SELECT ap_controller FROM `exp_mno_ap_controller` WHERE mno_id='$edit_mno_id'";
        $get_ap_controllers=mysql_query($get_ap_controllers_q);
        $ap_controler_array=Array();
        while($get_ap_controller=mysql_fetch_assoc($get_ap_controllers)){
            array_push($ap_controler_array,$get_ap_controller['ap_controller']);
        }

        //print_r($ap_controler_array);
         $get_mno_wags_q="SELECT w.`wag_code`,w.`wag_name` FROM `exp_wag_profile` w , `exp_mno_ap_controller` c
                                    WHERE w.`ap_controller`=c.`ap_controller` AND c.`mno_id`='$edit_mno_id' GROUP BY w.`wag_code`";
        $get_mno_wags_r=mysql_query($get_mno_wags_q);
        $edit_wag_prof_string='';
        while($get_mno_wags=mysql_fetch_assoc($get_mno_wags_r)){
            $edit_wag_prof_string.=$get_mno_wags[wag_name].'
 ';
        }
  $edit_wag_prof_string;
        $mno_edit=1;


    }//key validation
}//edit_mno

elseif(isset($_GET['remove_mno_id'])){
    if($_SESSION['FORM_SECRET']==$_GET['token10']){
        $remove_mno_id=$_GET['remove_mno_id'];



        //archive
        //*********************
        $archive_q="INSERT INTO `exp_mno_archive` (
                      `id`,
                      `mno_id`,
                      `unique_id`,
                      `mno_description`,
                      `mno_portal_text`,
                      `logo`,
                      `top_line_color`,
                      `mno_type`,
                      `bussiness_address1`,
                      `bussiness_address2`,
                      `bussiness_address3`,
                      `country`,
                      `state_region`,
                      `zip`,
                      `phone1`,
                      `phone2`,
                      `phone3`,
                      `is_enable`,
                      `top_line_size`,
                      `favicon_image`,
                      `top_bg_pattern_image`,
                      `theme_site_title`,
                      `theme_logo`,
                      `theme_style_type`,
                      `theme_top_line_color`,
                      `theme_color`,
                      `theme_light_color`,
                      `timezones`,
                      `create_user`,
                      `create_date`,
                      `last_update`,
                      `delete_by`,
                      `delete_date`
                    )
                    SELECT
                      `id`,
                      `mno_id`,
                      `unique_id`,
                      `mno_description`,
                      `mno_portal_text`,
                      `logo`,
                      `top_line_color`,
                      `mno_type`,
                      `bussiness_address1`,
                      `bussiness_address2`,
                      `bussiness_address3`,
                      `country`,
                      `state_region`,
                      `zip`,
                      `phone1`,
                      `phone2`,
                      `phone3`,
                      `is_enable`,
                      `top_line_size`,
                      `favicon_image`,
                      `top_bg_pattern_image`,
                      `theme_site_title`,
                      `theme_logo`,
                      `theme_style_type`,
                      `theme_top_line_color`,
                      `theme_color`,
                      `theme_light_color`,
                      `timezones`,
                      `create_user`,
                      `create_date`,
                      `last_update`,
                      '$username',
                      NOW()
                    FROM
                      `exp_mno` WHERE mno_id = '$remove_mno_id'";

        if($system_package=="COX_ADMIN_001"){
            $archive_ap_controller="INSERT INTO `exp_mno_ap_controller_archive`(`id`,`mno_id`,`ap_controller`,`create_user`,`create_date`,`last_update`)
                    SELECT * FROM `exp_mno_ap_controller` WHERE `mno_id`='";//";
        }



            //Deleate API
            $rm_unique_get=mysql_query("SELECT `unique_id` FROM `exp_mno` WHERE `mno_id`='$remove_mno_id'");
            $rm_unique_arr=mysql_fetch_array($rm_unique_get);
          $rm_unique=$rm_unique_arr['unique_id'];
            $rm_int_unique=(int)$rm_unique;
           //$responcerm = $test->accountDelete($rm_int_unique)parse_str($responcerm);
          // echo $status_code;
        $status_code=200;
        if($status_code==200){
            $keyquery=mysql_query($archive_q);
            $keyquery=mysql_query($archive_ap_controller);

            $delete = mysql_query("DELETE
                            FROM
                              `exp_mno`
                            WHERE `mno_id` = '$remove_mno_id'");

            $delete2 = mysql_query("DELETE FROM `exp_mno_ap_controller` WHERE `mno_id`='$remove_mno_id'");
            $delete2 = mysql_query("DELETE FROM `admin_users` WHERE `user_distributor`='$remove_mno_id'");



            if ($delete) {
                $db->userErrorLog('2004', $user_name, 'script - ' . $script);
                
                $create_log->save('3001',$message_functions->showNameMessage('operator_remove_success',$remove_mno_id,'3001'),'');
                $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showNameMessage('operator_remove_success',$remove_mno_id)."</strong></div>";

            } else {
                $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                $create_log->save('2001',$message_functions->showMessage('operator_remove_failed','2001'),'');
                $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('operator_remove_failed','2001')."</strong></div>";

            }

        }else{
            $db->userErrorLog('2009', $user_name, 'script - '.$script);
            
            $create_log->save('2009',$message_functions->showMessage('operator_remove_failed','2009'),'');
            
            $_SESSION['msg6']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('operator_remove_failed','2009')."</strong></div>";


        }




    }//key validation
    else{
        $db->userErrorLog('2004', $user_name, 'script - '.$script);
        $create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
        
        $_SESSION['msg6']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
        //header('Location: location.php?t=1');
    }
}//remove_mno_id




if(isset($_GET['send_mail_mno_id'])){

   $send_mail_mno_id=$_GET['send_mail_mno_id'];


    if($_SESSION['FORM_SECRET']==$_GET['tokenmail']){


        $query = "SELECT a.email,a.full_name,a.user_type,e.* FROM `admin_invitation_email` e LEFT JOIN admin_users a ON
                    a.user_distributor=e.distributor 
                    WHERE `distributor` = '$send_mail_mno_id'";
            //"SELECT * FROM `admin_invitation_email` WHERE `distributor` = '$send_mail_mno_id'";
        $result = mysql_query($query);

        while($row=mysql_fetch_array($result)){

            $resend_email=$row[email];
            $to = $row[to];
            $subject = $row[subject];
            //$message = $row[message];
            $f_name=$row[full_name];
            $user_type1=$row[user_type];
            $uname=$row[user_name];
            $pw_re=$row[password_re];
        }

        $customer_type=$db->getValueAsf("SELECT system_package AS f FROM exp_mno WHERE mno_id='$send_mail_mno_id'");

        $title=$db->setVal("short_title", "ADMIN");
        $from=strip_tags($db->setVal("email", "ADMIN"));


        $link = '<a href="' . $db->setVal("global_url", "ADMIN") . '">' . $db->setVal("global_url", "ADMIN") . '</a>';
        $a = $db->textVal('MAIL', 'ADMIN');

        $vars = array(

            '{$user_full_name}' => $f_name,
            '{$short_name}' => $title,
            '{$account_type}' => 'MNO',
            '{$user_name}' => $uname,
            '{$password}' => $pw_re,
            '{$link}' => $link
        );

        $message_full = strtr($a, $vars);
        $message = $message_full;

        $email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
        include_once 'src/email/'.$email_send_method.'/index.php';

        //email template
        $emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
        $cunst_var=array();
        if($emailTemplateType=='child'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$customer_type);
        }elseif($emailTemplateType=='owen'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }elseif(strlen($emailTemplateType)>0){
            $cunst_var['template']=$emailTemplateType;
        }else{
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }

        $mail_obj=new email($cunst_var);

        if($resend_email!=$to){
            mysql_query("UPDATE admin_invitation_email SET `to`='$resend_email' WHERE `distributor` = '$distributor_code'");
            $to=$resend_email;
        }

        $mail_sent=$mail_obj->sendEmail($from,$to,$subject,$message,'',$title);
        $send_email_msg = $message_functions->showNameMessage('property_send_email_suceess',$f_name);
        $create_log->save('2004',$send_email_msg,$message);
        $_SESSION['msg20']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$send_email_msg."</strong></div>";
    }else{
        $db->userErrorLog('2004', $user_name, 'script - '.$script);
        $send_email_msg =$message_functions->showMessage('transection_fail','2004');
        $create_log->save('2004',$send_email_msg,'');
        $_SESSION['msg20']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> ".$send_email_msg."</strong></div>";
        //header('Location: location.php');

    }
}//send mail


if($_POST['p_update_button_action']=='submit_p_form'){
    if($_POST['form_secret12']==$_SESSION['FORM_SECRET']){
        $parent_id = $_POST['parent_id'];
        $parent_ac_name = mysql_real_escape_string($_POST['parent_ac_name']);
        $parent_first_name = $_POST['parent_first_name'];
        $parent_last_name = $_POST['parent_last_name'];
        $parent_email = $_POST['parent_email'];
        $parent_username_change = $_POST['parent_username_change'];
        $full_name= $parent_first_name.' '.$parent_last_name;

        $parent_old_email=$db->getValueAsf("SELECT email as f FROM admin_users WHERE verification_number='$parent_id'");



        $p_update_q ="UPDATE admin_users SET full_name='$full_name' ,email='$parent_email' WHERE verification_number='$parent_id'";
        $p_update_q2 = "UPDATE mno_distributor_parent SET account_name='$parent_ac_name' WHERE parent_id='$parent_id'";

        $p_update_r=mysql_query($p_update_q);
        $p_update_r2=mysql_query($p_update_q2);

        if($p_update_r && $parent_username_change != 'on' && ($parent_old_email!=$parent_email)){
            $reset_method=$db->setVal("pass_reset_method",'ADMIN');

            $qcehck="SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.system_package AS 'user_system_package' 
                    FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                    WHERE u.`verification_number`='$parent_id' AND u.user_type IN ('MVNO_ADMIN') limit 1";

            $rcheck = mysql_query($qcehck);


                $cunst_var = array(
                    "template" => ""
                );

                while($row = mysql_fetch_assoc($rcheck)) {

                    $user_system_package = $row['user_system_package'];
                    $email = $row['email'];
                    $user_name = $row['user_name'];
                    $full_name = $row['full_name'];
                    $distributor = $row['user_distributor'];

                    $admin_id = $row['mno_id'];

                    $t = date("ymdhis", time());

                    $string = $user_name . '|' . $t . '|' . $email;

                    $encript_resetkey = $app->encrypt_decrypt('encrypt', $string);

                    $unique_key=$db->getValueAsf("SELECT REPLACE(UUID(),'-','') as f");

                
                    $qq = "UPDATE admin_reset_password SET status = 'cancel' WHERE user_name='$user_name' AND status='pending'";
                    $rr = mysql_query($qq);

                    if ($rr) {
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $q1 = "INSERT INTO admin_reset_password (user_name, status, security_key,unique_key, ip, create_date) VALUES('$user_name', 'pending', '$encript_resetkey','$unique_key', '$ip', NOW())";
                        $r1 = mysql_query($q1);
                    }

                    if ($r1) {

                        $to = $email;
                        $from = strip_tags($db->setVal("email", $admin_id));
                        $subject = $db->textTitle('PASSWORD_RESET_MAIL', $admin_id);
                        if (strlen($subject) == 0) {
                            $subject = $db->textTitle('PASSWORD_RESET_MAIL', 'ADMIN');
                        }
                        $title = $db->setVal("short_title", $dist);
                       
                        $link = $db->setVal("global_url", 'ADMIN') . '/reset_password.php?reset=pwd&reset_key='.$unique_key;


                        $vars = array(
                            '{$user_ID}' => $user_name,
                            '{$user_full_name}' => $full_name,
                            '{$link}' => $link
                        );

                        $mail_text = $db->textVal('PASSWORD_RESET_MAIL', $admin_id);
                        if (strlen($mail_text) == 0) {
                            $mail_text = $db->textVal('PASSWORD_RESET_MAIL', 'ADMIN');
                        }

                        $message = strtr($mail_text, $vars);

                        $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);

                        if (strlen($email_send_method) == 0) {
                            $email_send_method = 'PHP_MAIL';
                        }

                        include_once 'src/email/' . $email_send_method . '/index.php';

                        $cunst_var['template']  = $package_functions->getOptions('EMAIL_TEMPLATE', $user_system_package);

                        $mail_obj = new email($cunst_var);

                        $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message, '', $title);
                        $mail_obj = null;
                        unset($mail_obj);
                    }

            }

        }

        if ($parent_username_change == 'on' && ($parent_old_email!=$parent_email)) {

            $query_code = "SELECT user_distributor, d.id, d.mno_id, u.user_name
      FROM admin_users u, mno_distributor_parent d
      WHERE d.parent_id = '$parent_id' AND u.`verification_number`='$parent_id'";

            $query_results = mysql_query($query_code);
            while ($row = mysql_fetch_array($query_results)) {
                $user_distributor1 = $row[user_distributor];
                $mno_id = $row[mno_id];
                $user_name1 = $row[user_name];
            }


          $query_admin_user_archive="INSERT INTO `admin_users_archive` (
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  `archive_by`,
                  `archive_date`,
                  `last_update`
                )

                  (
                SELECT
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  '$user_name',
                  NOW(),
                  `last_update`
                FROM `admin_users`
                WHERE
                  `verification_number`='$parent_id'
                  ) ";

            $ex3 = mysql_query($query_admin_user_archive);

                if ($ex3) {

                    $user_update = "UPDATE `admin_users` SET `is_enable` = '2' WHERE verification_number='$parent_id'";
                    $ex_query_de = mysql_query($user_update);

                    $subject = $db->textTitle('MAIL',$mno_id);
                            if(strlen($subject)==0){
                                $subject=$db->textTitle('ICOMMS_MAIL','ADMIN');
                            }

                    $from=strip_tags($db->setVal("email", $mno_id));

                    if($from==''){
                        $from=strip_tags($db->setVal("email", 'ADMIN'));
                    }

                    $to = $mvnx_email;
                    $title=$db->setVal("short_title", $mno_id);

                    $link = $db->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin';

                    $a = $db->textVal('MAIL', $mno_id);

                    if(strlen($a)<1){
                        $a = $db->textVal('MAIL', 'ADMIN');
                    }

                    if ($package_functions->getSectionType("VERIFI_METHORD", $system_package) == "number") {

                        $vars = array(
                            '{$short_name}' => $db->setVal("short_title", $mno_id),
                            '{$business_id}' => $parent_id,
                            '{$link}' => $link,
                            '{$user_full_name}' => $full_name,
                            '{$account_type}' =>'MVNO_ADMIN',
                        );
                    }
                    else {
                        $vars = array(
                            '{$short_name}' => $db->setVal("short_title", $mno_id),
                            '{$user_name}' => $user_name1,
                            '{$password}' => $password,
                            '{$link}' => $link

                        );
                    }

                    $message_full = strtr($a, $vars);
                    $message = mysql_escape_string($message_full);

                    $qu = "INSERT INTO `admin_invitation_email` (`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
          VALUES ('$parent_email', '$subject', '$message', '$user_distributor1', '$user_name1', now())";
                    $rrr = mysql_query($qu);

                    $email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                        include_once 'src/email/'.$email_send_method.'/index.php';

                        //email template
                        $emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
                        $cunst_var=array();
                        if($emailTemplateType=='child'){
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$user_system_package);
                        }elseif($emailTemplateType=='owen'){
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                        }elseif(strlen($emailTemplateType)>0){
                            $cunst_var['template']=$emailTemplateType;
                        }else{
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                        }
                        $mail_obj=new email($cunst_var);


                        $mail_sent=$mail_obj->sendEmail($from,$parent_email,$subject,$message_full,'',$title);

                }


          
        }

        $show_message = $message_functions->showNameMessage('parent_update_success',str_replace('\\','',$parent_ac_name));
        $create_log->save('',$show_message,'');

            $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$show_message."</strong></div>";

    }else{
        $db->userErrorLog('2004', $user_name, 'script - '.$script);
        $create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
        $_SESSION['msg20']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> ".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
        //header('Location: location.php');

    }
}


if(isset($_GET['edit_parent_id']) && $_POST['p_update_button_action']!='add_location'){

        $edit_parent_q = "SELECT full_name,email,p.account_name FROM admin_users u, mno_distributor_parent p WHERE u.verification_number=p.parent_id  AND verification_number='$_GET[edit_parent_id]'";
        $edit_parent_r = mysql_query($edit_parent_q);
        while($row_ed_par = mysql_fetch_assoc($edit_parent_r)){
            $get_edit_parent_id = $_GET['edit_parent_id'];
            $get_edit_parent_ac_name = $row_ed_par['account_name'];
            $edit_parent_full_name = $row_ed_par['full_name'];
            $edit_parent_full_name = explode(" ",$edit_parent_full_name);
            $edit_parent_first_name = $edit_parent_full_name[0];
            $edit_parent_last_name = $edit_parent_full_name[1];
            $edit_parent_email = $row_ed_par['email'];
            $edit_parent_on = 1;
        }

}


//refresh function

if($_GET['action']=='sync_data_tab1' || isset($_GET['view_loc_code'])) {

    if ($wag_ap_name != 'NO_PROFILE') {
        if ($ap_control_var == 'MULTIPLE') {

            $sync_q = "SELECT distributor_code FROM exp_mno_distributor WHERE parent_id='$_GET[view_loc_code]'";
            $sync_r = mysql_query($sync_q);
            while ($sync_row = mysql_fetch_assoc($sync_r)) {

                $sync_ap_url = $base_url.'/ajax/syncAP.php?distributor='.$sync_row['distributor_code'];

                httpGet($sync_ap_url);
            }
        }

//*********************************************************************

    }
}


if($_POST['p_update_button_action']=='add_location'){
    $edit_parent_id = $_POST['parent_id'];
    $edit_parent_ac_name = mysql_real_escape_string($_POST['parent_ac_name']);
    $edit_parent_package = $_POST['parent_package_type'];
    $edit_first_name = $_POST['parent_first_name'];
    $edit_last_name = $_POST['parent_last_name'];
    $edit_email = $_POST['parent_email'];
    unset($tab12);
    $tab5='set';
    

    $_SESSION['new_location']='yes';
}else if($create_location_btn_action=='add_location_next'){
  
  
}else{
  $_SESSION['new_location']='';
  unset($_SESSION['new_location']);
}

//edt Property Admin
if(isset($_GET['assign_loc_admin'])){



$assign_dis_id=$_GET['assign_loc_admin'];

$query_ed_v = "SELECT d.`distributor_name`,d.`property_id`,a.`user_name`,a.`full_name`,a.`id` AS uid,a.`email`,a.mobile,d.`distributor_code`,d.`verification_number`,d.`mno_id`,d.`system_package` ,d.parent_id
     FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor WHERE d.`id`='$assign_dis_id'";

$query_ex_ed = mysql_query($query_ed_v);
if($ed_result= mysql_fetch_array($query_ex_ed)){

    $assign_edit_fulname=$ed_result['full_name'];

    $assign_ful_name_array=explode(' ', $assign_edit_fulname,2);
    $assign_edit_first_name=$assign_ful_name_array[0];
    $assign_edit_last_name=$assign_ful_name_array[1];

    $assign_edit_propertyid=$ed_result['property_id'];
    $assign_edit_distributor_name=$ed_result['distributor_name'];
    $assign_edit_email=$ed_result['email'];
    $assign_ad_id=$ed_result['uid'];
    $assign_distributor_code=$ed_result['distributor_code'];
    $assign_verification_number=$ed_result['verification_number'];
    $assign_mno_id=$ed_result['mno_id'];
    $assign_customer_type = $ed_result['system_package'];
    $assign_edit_phone = $ed_result['mobile'];
    $assign_edit_parent_id = $ed_result['parent_id'];

}

}//

if(isset($_POST['submit_assign_user'])){

    if($_SESSION['FORM_SECRET']==$_POST['form_secret5']) {

        $ed_de_user_id = $_POST['ed_user_id'];
        $ed_de_distributor_code = $_POST['ed_distributor_code'];
        $ed_de_first_name = $_POST['ed_first_name'];
        $ed_de_last_name = $_POST['ed_last_name'];
        $ed_de_user_email = $_POST['ed_ad_email'];
        $ed_de_verification_number = $_POST['ed_verification_number'];
        $mno_id =$_POST['ed_mno'];
        $mvnx_full_name = $ed_de_first_name." ".$ed_de_last_name;
        $user_type1 ="MVNO";
        $customer_type = trim($_POST['customer_type']);
        $mobile_1 = $_POST['mobile_1'];

        //$br = mysql_query("SHOW TABLE STATUS LIKE 'exp_mno_distributor'");
        //$rowe = mysql_fetch_array($br);
        //$auto_inc = $rowe['Auto_increment'];
        // $mvnx_id = $user_type1 . $auto_inc;
        ///$mvnx = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
        ///$unique_id = '2' . $mvnx;

        //$dis_user_name = str_replace(' ', '_', strtolower(substr($mvnx_full_name, 0, 5) . $auto_inc));
        $old_property_email=$db->getValueAsf("SELECT email AS f FROM admin_users WHERE user_distributor='$ed_de_distributor_code'");

        if($old_property_email!=$ed_de_user_email) {
            $br = mysql_query("SHOW TABLE STATUS LIKE 'admin_users'");
            $rowe = mysql_fetch_array($br);
            $auto_inc = $rowe['Auto_increment'];

            $dis_user_name = str_replace(' ', '_', strtolower(substr($ed_de_first_name, 0, 5) . 'u' . $auto_inc));


            $password = randomPassword();


            if (isset($_POST['ed_user_id'])) {
                //echo "ok";

                $query_admin_user_archive = "INSERT INTO `admin_users_archive` (
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  `archive_by`,
                  `archive_date`,
                  `last_update`
                )

                  (
                SELECT
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  '$user_name',
                  NOW(),
                  `last_update`
                FROM `admin_users`
                WHERE
                  `id`='$ed_de_user_id'
                  ) ";

                $ex3 = mysql_query($query_admin_user_archive);

                if ($ex3) {

                    $query_de = "delete from `admin_users` where id='$ed_de_user_id'";
                    $ex_query_de = mysql_query($query_de);

                }

            }


            $query02 = "INSERT INTO `admin_users` (`user_name`,`verification_number`,`password`,mobile, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `is_enable`, `create_date`)
			VALUES ('$dis_user_name','$ed_de_verification_number',PASSWORD('$password'),'$mobile_1', 'admin', 'MVNO','$ed_de_distributor_code', '$mvnx_full_name', '$ed_de_user_email', '2', NOW())";


            $ex_query02 = mysql_query($query02);


            /*Email Notification*/

            $to = $ed_de_user_email;
            $title = $db->setVal("short_title", $mno_id);
            $subject = $db->textTitle('ICOMMS_MAIL_SUB', $mno_id);
            if (strlen($subject) == 0) {
                $subject = $db->textTitle('ICOMMS_MAIL_SUB', 'ADMIN');
            }
            $from = strip_tags($db->setVal("email", $mno_id));
            if ($from == '') {
                $from = strip_tags($db->setVal("email", 'ADMIN'));
            }


            $link = $db->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin';
            //$system_package1 =  $db_class->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");

            $a = $db->textVal('ICOMMS_MAIL_SUB', $mno_id);

            if (strlen($a) == 0) {
                $a = $db->textVal('ICOMMS_MAIL_SUB', 'ADMIN');
            }

            if ($package_functions->getSectionType("VERIFI_METHORD", $system_package) == "number") {

                $vars = array(
                    '{$user_full_name}' => $mvnx_full_name,
                    '{$short_name}' => $db->setVal("short_title", $mno_id),
                    '{$account_type}' => $user_type1,
                    '{$property_id}' => $ed_de_verification_number,
                    '{$link}' => $link
                );
            } else {
                $vars = array(
                    '{$user_full_name}' => $mvnx_full_name,
                    '{$short_name}' => $db->setVal("short_title", $mno_id),
                    '{$account_type}' => $user_type1,
                    '{$user_name}' => $dis_user_name,
                    '{$password}' => $password,
                    '{$link}' => $link

                );
            }

            $message_full = strtr($a, $vars);
            $message = mysql_escape_string($message_full);


            if ($ex_query02) {


                $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
	 	VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
                $rrr = mysql_query($qu);

                // $package_functions->getSectionType('VENUE_ACTIVATION_TYPE',$system_package1);

                if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package) == "ICOMMS NUMBER" || $package_features == "all") {


                    $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                    include_once 'src/email/' . $email_send_method . '/index.php';

                    //email template
                    $emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package);
                    $cunst_var = array();
                    if ($emailTemplateType == 'child') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                    } elseif ($emailTemplateType == 'owen') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                    } elseif (strlen($emailTemplateType) > 0) {
                        $cunst_var['template'] = $emailTemplateType;
                    } else {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                    }
                    $mail_obj = new email($cunst_var);


                    $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);

                }


            }
        }else{
            $query_admin_user_archive = "INSERT INTO `admin_users_archive` (
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  `archive_by`,
                  `archive_date`,
                  `last_update`
                )

                  (
                SELECT
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  '$user_name',
                  NOW(),
                  `last_update`
                FROM `admin_users`
                WHERE
                  `id`='$ed_de_user_id'
                  ) ";

            $ex3 = mysql_query($query_admin_user_archive);

            $query02 = "UPDATE `admin_users` SET mobile='$mobile_1', `full_name`='$mvnx_full_name' WHERE  id='$ed_de_user_id'";


            $ex_query02 = mysql_query($query02);
        }


        if($ex_query02){

            $properties_edit_success = $message_functions->showMessage('properties_edit_success');

            $_SESSION['msg10'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$properties_edit_success."</strong></div>";
        }else{
            $properties_edit_error = $message_functions->showMessage('properties_edit_error');
            $_SESSION['msg10'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$properties_edit_error."</strong></div>";

        }
    }
}

//resend Property Admin invitation email
if(isset($_GET['e_resend_a'])) {
    if ($_SESSION['FORM_SECRET'] == $_GET['tokene']) {
        $resend_dist_code = $_GET['e_resend_a'];

        $q="SELECT u.email,u.full_name,u.user_type,u.verification_number,d.mno_id FROM admin_users u LEFT JOIN exp_mno_distributor d ON u.user_distributor=d.distributor_code WHERE d.distributor_code='$resend_dist_code'";
        $r=mysql_query($q);
        while ($row = mysql_fetch_assoc($r)){
            $re_user_email = $row['email'];
            $mno_id = $row['mno_id'];
            $mvnx_full_name = $row['full_name'];
            $user_type1 = $row['user_type'];
            $resend_verification_number = $row['verification_number'];
        }

        /*Email Notification*/

        $to = $re_user_email;
        $title = $db->setVal("short_title", $mno_id);
        $subject = $db->textTitle('ICOMMS_MAIL_SUB', $mno_id);
        if (strlen($subject) == 0) {
            $subject = $db->textTitle('ICOMMS_MAIL_SUB', 'ADMIN');
        }
        $from = strip_tags($db->setVal("email", $mno_id));
        if ($from == '') {
            $from = strip_tags($db->setVal("email", 'ADMIN'));
        }


        $link = $db->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin';
        $system_package1 = $db->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");

        $a = $db->textVal('ICOMMS_MAIL_SUB', $mno_id);

        if (strlen($a) == 0) {
            $a = $db->textVal('ICOMMS_MAIL_SUB', 'ADMIN');
        }

        if ($package_functions->getSectionType("VERIFI_METHORD", $system_package1) == "number") {

            $vars = array(
                '{$user_full_name}' => $mvnx_full_name,
                '{$short_name}' => $db->setVal("short_title", $mno_id),
                '{$account_type}' => $user_type1,
                '{$property_id}' => $resend_verification_number,
                '{$link}' => $link
            );
        } else {
            $vars = array(
                '{$user_full_name}' => $mvnx_full_name,
                '{$short_name}' => $db->setVal("short_title", $mno_id),
                '{$account_type}' => $user_type1,
                '{$user_name}' => $dis_user_name,
                '{$password}' => $password,
                '{$link}' => $link

            );
        }

        $message_full = strtr($a, $vars);
        $message = mysql_escape_string($message_full);

        $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
	 	VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
        $rrr = mysql_query($qu);

        // $package_functions->getSectionType('VENUE_ACTIVATION_TYPE',$system_package1);

        if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package1) == "ICOMMS NUMBER" || $package_features == "all") {


            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
            include_once 'src/email/' . $email_send_method . '/index.php';

            //email template
            $emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package);
            $cunst_var = array();
            if ($emailTemplateType == 'child') {
                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
            } elseif ($emailTemplateType == 'owen') {
                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
            } elseif (strlen($emailTemplateType) > 0) {
                $cunst_var['template'] = $emailTemplateType;
            }
            $mail_obj = new email($cunst_var);


            $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);

        }

        if ($mail_sent=='1') {
            $properties_edit_success = $message_functions->showNameMessage('property_send_email_suceess',$mvnx_full_name);

            $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
        } else {
            $properties_edit_error = $message_functions->showNameMessage('property_send_email_failed', $mvnx_full_name);

            $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";
        }

    }
}//




//Form Refreshing avoid secret key/////
	$secret=md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;




?>


<div class="main" >
		<div class="main-inner" >
			<div class="container">
				<div class="row">
					<div class="span12">
                    <?php if(isset($_GET['view_loc_code'])){ ?>
                           <a href="location.php" class="" style="font-size: 16px;  font-weight: 600; color: #0679CA;float:left; margin-top: 8px; position: relative; margin-left:20px;">
							&lt; Back
						</a>
                        <?php } ?>
                           <br><br>
						<div class="widget ">

									
                                    
                                    
							<div class="widget-header">
								<!-- <i class="icon-sitemap"></i> -->
							<?php if($user_type=='ADMIN'){
								
									?>
								<h3>Manage Operations</h3>
								
								<?php }else {
                                if (isset($_GET['view_loc_code'])) {
                                    echo '<h3>View Property and AP information</h3>';
                                } else {


                                    echo '<h3>View and Manage Properties</h3>';
                                }
                            }?>
							</div><!-- /widget-header -->
                            <?php

                            if(isset($_SESSION['msg10'])){
                                echo $_SESSION['msg10'];
                                unset($_SESSION['msg10']);

                            }


                            if(isset($_SESSION['msg9'])){
                                echo $_SESSION['msg9'];
                                unset($_SESSION['msg9']);
                            }


                            if(isset($_SESSION['msg3'])){
                                echo $_SESSION['msg3'];
                                unset($_SESSION['msg3']);
                            }


                            if(isset($_SESSION['msg14'])){
                                echo $_SESSION['msg14'];
                                unset($_SESSION['msg14']);
                            }


                            if(isset($_SESSION['msg24'])){
                                echo $_SESSION['msg24'];
                                unset($_SESSION['msg24']);
                            }



                            if(isset($_SESSION['msg6'])){
                                echo $_SESSION['msg6'];
                                unset($_SESSION['msg6']);
                            }





                            if(isset($_SESSION['msg11'])){
                                echo $_SESSION['msg11'];
                                unset($_SESSION['msg11']);
                            }


                            if(isset($_SESSION['msg5'])){
                                echo $_SESSION['msg5'];
                                unset($_SESSION['msg5']);
                            }


                            if(isset($_SESSION['msg12'])){
                                echo $_SESSION['msg12'];
                                unset($_SESSION['msg12']);
                            }

                            if(isset($_SESSION['msg13'])){
                                echo $_SESSION['msg13'];
                                unset($_SESSION['msg13']);
                            }



                            if(isset($_SESSION['msg7'])){
                                echo $_SESSION['msg7'];
                                unset($_SESSION['msg7']);
                            }



                            if(isset($_SESSION['msg20'])){
                                echo $_SESSION['msg20'];
                                unset($_SESSION['msg20']);
                            }

                            if(isset($tab11)){
                                }?>

							<div class="widget-content">
								<div class="tabbable">
									<ul class="nav nav-tabs">

										<?php
											if($user_type == 'MNO' || $user_type == 'MVNE' || $user_type == 'MVNO'){
										?>
											<li <?php if(isset($tab1)){?>class="active" <?php }?>><a href="#live_camp" data-toggle="tab"><?php if(isset($_GET['view_loc_code'])){ echo 'View Account'; }else {echo 'Active';}?></a></li>

                                                <?php if($edit_parent_on ==1 ) { ?>
                                                    <li <?php if (isset($tab12)){ ?>class="active" <?php } ?>><a
                                                                href="#edit_parent"
                                                                data-toggle="tab"> Edit Business ID Profile </a></li>

                                                    <?php
                                                }
											}
										?>



										<?php
											if($user_type == 'MVNE' || $user_type == 'MVNO') {

                                            }
											if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE'){
                                                if(!in_array('support', $access_modules_list) || $edit_account=='1') {
                                                    ?>

                                                    <li <?php if (isset($tab5)){ ?>class="active" <?php } ?>><a
                                                            href="#create_location"
                                                            data-toggle="tab"><?php if ($edit_account == '1') echo 'Edit SMB Account'; else echo 'Create'; ?></a>
                                                    </li>
                                                    <?php
                                                }

                                                if(in_array('support', $access_modules_list) && isset($_GET['assign_loc_admin'])) {
                                                    ?>

                                                    <li class="active" ><a
                                                                href="#assign_loc_admin"
                                                                data-toggle="tab">Assign Property Admin</a>
                                                    </li>
                                                    <?php
                                                }

										}
										
											if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE'){
										?>
											<li <?php if(isset($tab9)){?>class="active" <?php }?>><a href="#assign_ap" data-toggle="tab">Activate</a></li>
										    <?php
										}

                                        if($user_type == 'ADMIN'){
                                            ?>

                                            <li <?php if(isset($tab8)){?>class="active" <?php }?>><a href="#active_mno" data-toggle="tab">Active <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></a></li>

                                        <?php
                                        }
                                        ?>

										<?php
										if($user_type == 'ADMIN'){
										?>
											<li <?php if(isset($tab6)){?>class="active" <?php }?>><a href="#mno_account" data-toggle="tab"><?php if($mno_edit==1){echo"Edit ". $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'")." Account";}else{echo"Create ". $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'")." Account";};?></a></li>
										<?php
										}
										?>

                                        <?php
                                        if($user_type == 'ADMIN'){
                                            ?>

                                            <li <?php if(isset($tab11)){?>class="active" <?php }?>><a href="#saved_mno" data-toggle="tab">Activate <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></a></li>

                                        <?php

                                        }
                                        ?>


									</ul>
									<br>


									<div class="tab-content">

                                        <?php if(isset($_GET['assign_loc_admin'])){ ?>
                                            <div class="tab-pane fade in active" id="assign_loc_admin">
                                                <div class="header2_part1"><h2>Assign Property Admin </h2></div>



                                                <p>Change the name and email to the person you want to assign as property admin and click the Assign button. The person will get an activation email with instructions how to activate the account. The assigned admin will log in directly to the property Admin from the general login using its own unique credentials. </p>
                                                <br><br>
                                                <form autocomplete="off" id="edit_profile_form" action="?token7=<?php echo $secret;?>&t=12&edit_parent_id=<?php echo $assign_edit_parent_id  ;?>" method="post" class="form-horizontal" >

                                                    <fieldset>






                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Property ID<sup><font color="#FF0000" ></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="ed_property_id" name="ed_property_id" type="text" value="<?php echo  $assign_edit_propertyid; ?>" disabled>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>


                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Account Name <sup><font color="#FF0000" ></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="ed_account_name" name="ed_account_name" type="text" value="<?php echo $assign_edit_distributor_name; ?>" disabled>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                        <input  id="ed_user_id" name="ed_user_id" type="hidden" value="<?php echo  $assign_ad_id; ?>" >
                                                        <input  id="ed_distributor_code" name="ed_distributor_code" type="hidden" value="<?php echo  $assign_distributor_code; ?>" >
                                                        <input  id="ed_verification_number" name="ed_verification_number" type="hidden" value="<?php echo  $assign_verification_number; ?>" >
                                                        <input  id="ed_mno" name="ed_mno" type="hidden" value="<?php echo  $assign_mno_id; ?>" >

                                                        <input  id="customer_type" name="customer_type" type="hidden" value="<?php echo  $assign_customer_type; ?>" >

                                                        <input type="hidden" name="form_secret5" id="form_secret5" value="<?php echo $_SESSION['FORM_SECRET'] ?>" >

                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Admin First Name <sup><font color="#FF0000" ></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="ed_first_name" name="ed_first_name" type="text" value="<?php echo $assign_edit_first_name; ?>">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Admin Last Name <sup><font color="#FF0000" ></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="ed_last_name" name="ed_last_name" type="text" value="<?php echo $assign_edit_last_name; ?> ">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="email_1">Admin Email<sup><font color="#FF0000" ></font></sup></label>

                                                            <div class="controls form-group col-lg-5">
                                                                <input class="form-control span4" id="ed_ad_email" name="ed_ad_email" value="<?php echo  $assign_edit_email; ?>" placeholder="name@mycompany.com" >
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->



                                                        <div class="control-group">
                                                            <label class="control-label" for="email_1">Phone Number<sup><font color="#FF0000" ></font></sup></label>

                                                            <div class="controls form-group col-lg-5">
                                                                <input class="form-control span4" id="mobile_1" name="mobile_1" value="<?php echo  $assign_edit_phone; ?>" placeholder="xxx-xxx-xxxx" maxlength="12" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$">


                                                                <script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                        $('#mobile_1').focus(function(){
                                                                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                        });

                                                                        $('#mobile_1').keyup(function(){
                                                                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                        });

                                                                        $("#mobile_1").keydown(function (e) {


                                                                            var mac = $('#mobile_1').val();
                                                                            var len = mac.length + 1;
                                                                            //console.log(e.keyCode);
                                                                            //console.log('len '+ len);

                                                                            if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                                mac1 = mac.replace(/[^0-9]/g, '');


                                                                                //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                                //console.log(valu);
                                                                                //$('#phone_num_val').val(valu);

                                                                            }
                                                                            else{

                                                                                if(len == 4){
                                                                                    $('#mobile_1').val(function() {
                                                                                        return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                        //console.log('mac1 ' + mac);

                                                                                    });
                                                                                }
                                                                                else if(len == 8 ){
                                                                                    $('#mobile_1').val(function() {
                                                                                        return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                                        //console.log('mac2 ' + mac);

                                                                                    });
                                                                                }
                                                                            }


                                                                            // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                            if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                e.preventDefault();

                                                                            }
                                                                        });


                                                                    });

                                                                </script>


                                                            </div>
                                                            <!-- /controls -->
                                                        </div>


                                                        <div class="form-actions">
                                                            <button type="submit"  name="submit_assign_user" id="submit_assign_user" class="btn btn-primary" disabled="disabled">Assign</button>&nbsp; <strong><font color="#FF0000"></font><small></small></strong>

                                                            <a href="?token7=<?php echo $secret;?>&t=12&edit_parent_id=<?php echo $assign_edit_parent_id  ;?>" style="text-decoration:none;" class="btn btn-info inline-btn">Cancel</a>
                                                        </div>
                                                        <!-- /form-actions -->

                                                    </fieldset>
                                                </form>

                                            </div>


                                        <?php } ?>

                                        <div <?php if(isset($tab12)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="edit_parent">

                                            <form action="?t=5<?php if(isset($get_edit_parent_id)) echo '&location_parent_id='.$get_edit_parent_id.'&token7='.$secret.'&t=12&edit_parent_id='.$get_edit_parent_id; ?>" id="parent_form" name="parent_form" class="form-horizontal" method="POST"   >

                                                <?php
                                                echo '<input type="hidden" name="form_secret12" id="form_secret12" value="'.$secret.'" />';
                                                ?>

                                                <fieldset>


                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_full_name">Business ID</label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input maxlength="12" readonly class="span4 form-control" id="up_parent_id" placeholder="" name="parent_id" type="text" value="<?php echo$get_edit_parent_id;?>">
                                                                <script type="text/javascript">
                                                                    $("#up_parent_id").keypress(function(event){
                                                                        var ew = event.which;
                                                                        if(ew == 32)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122)
                                                                            return true;
                                                                        return false;
                                                                    });
                                                                </script>
                                                            </div>
                                                        </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="mno_full_name">Business Account Name</label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control" id="parent_ac_name" placeholder="" name="parent_ac_name" type="text" value="<?php echo str_replace("\\",'',$get_edit_parent_ac_name); ?>">
                                                            </div>
                                                        </div>
                                                    <div class="control-group">
                                                            <label class="control-label" for="mno_full_name">First Name</label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control" id="parent_first_name" placeholder="Full Name" name="parent_first_name" type="text" maxlength="12" value="<?php echo$edit_parent_first_name;?>">
                                                            </div>
                                                        </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="mno_full_name">Last Name</label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control" id="parent_last_name" placeholder="Full Name" name="parent_last_name" type="text" maxlength="12" value="<?php echo$edit_parent_last_name;?>">
                                                            </div>
                                                        </div>


                                                        <div class="control-group">
                                                        <!--<div style="display: inline-block;width: 68%;">-->
                                                            <label class="control-label" for="mno_email">Email</label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control" id="parent_email" name="parent_email" type="email" placeholder="wifi@company.com" value="<?php echo $edit_parent_email;?>">
                                                                <input type="checkbox" data-toggle="tooltip" title="Alert! Checking this box and submitting change will update/replace Business Admin Credentials. Submitting will also require update to User ID and Password." id="parent_username_change" name="parent_username_change"><font id="replace_user_lbl" style="width: 40%;">Update/Replace Business Admin Credentials</font>
                                                                <style type="text/css">
                                                                    @media only screen and (min-width : 768px) {
                                                                        #replace_user_lbl {
                                                                            float: right;
                                                                        }
                                                                    }
                                                                </style>
                                                                <div style="display:none" id="parent_update_conf_msg" >Are you sure you want to update this account?</div>
                                                                <script type="text/javascript">
                                                                    $('#parent_username_change').click(function(){
                                                                        setTimeout(function () {
                                                                            if($('#parent_username_change').is(':checked')){
                                                                                $('#submit_p_form_confirm').addClass('parent-update-conf-div-long');
                                                                                $('#submit_p_form_confirm').removeClass('parent-update-conf-div-small');
                                                                                $('#parent_update_conf_msg').html('Warning! Submitting this change will update current Business Admin </br>or establish a New Business Admin credentials. Submitting will also</br> require update to User ID and Password');
                                                                            }else{
                                                                                $('#submit_p_form_confirm').addClass('parent-update-conf-div-small');
                                                                                $('#submit_p_form_confirm').removeClass('parent-update-conf-div-long');
                                                                                $('#parent_update_conf_msg').html('Are you sure you want to update this account?');
                                                                            }

                                                                            eval($('#easy_confirm').html());
                                                                        },5);
                                                                    })
                                                                </script>
                                                            </div>
                                                        <!--</div>-->
                                                            <!--<div style="display: inline-block;width: 31%;position: absolute;"> Update/Replace Business Admin Credentials</div>-->
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_email"></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control" id="change_0" name="change_0" type="hidden" placeholder="wifi@company.com" value="<?php echo $edit_parent_email;?>">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="check_p_email" value="<?php echo $edit_parent_email;?>">

                                                    <?php

                                                    $parent_package=$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);
                                                    $parent_package_array =explode(',',$parent_package);
                                                    //print_r($parent_package_array);
                                                    if(count($parent_package_array)>1){

                                                        ?>

                                                        <div class="control-group">
                                                            <label class="control-label" for="parent_package_type">Admin Type</label>
                                                            <div class="controls col-lg-5 form-group">

                                                                    <input readonly class="span4 form-control" id="parent_package_type" name="parent_package_type" type="text" placeholder="wifi@company.com"   value="<?php echo $parent_package_array[0]; ?>">

                                                            </div>
                                                        </div>
                                                    <?php }else{
                                                        echo '<input   id="parent_package_type" name="parent_package_type" type="hidden" value="'.$parent_package_array[0].'">';
                                                    } ?>






                                                    <div class="form-actions">

                                                        <button onmouseover="parent_btn_action('submit_p_form');" disabled type="submit" id="submit_p_form" value="submit_p_form" name="submit_p_form" class="btn btn-primary" onClick="(function(){
                                                            $('#submit_p_form_confirm_text').html($('#parent_update_conf_msg').html());
                                                            $('.ui-widget-overlay').show();
                                                            $('#submit_p_form_confirm').show();
                                                                    return false;
                                                                })();return false;">Update Account</button>

                                                        <?php if(!in_array('support', $access_modules_list)){ ?>
                                                        <button onmouseover="parent_btn_action('add_location');" type="submit" name="add_location" id="add_location" value="add_location" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>
                                                        <?php } ?>
                                                        <button type="button" class="btn btn-info inline-btn"  onclick="gopto();" >Cancel</button>
                                                        <input type="hidden" name="p_update_button_action" id="p_update_button_action">

                                                    </div>
                                                        <script type="text/javascript">
                                                            function parent_btn_action(action) {
                                                                $('#p_update_button_action').val(action);
                                                            }

                                                        function gopto(url){
                                                            window.location = "?";
                                                        }
                                                    </script>
                                                    <!-- /form-actions -->

                                                </fieldset>

                                            </form>

                                                        <div class="widget widget-table action-table">

                                                            <div class="widget-header">

                                                            <!--  <i class="icon-th-list"></i> -->

                                                            <h3>Locations</h3>

                                                            </div>

                                                            <!-- /widget-header -->

                                                            <div class="widget-content table_response" id="location_div">
                                                            <div style="overflow-x:auto">

                                                            <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                                                        <?php

                                                            $location_q = "SELECT DISTINCT  d.`gateway_type`,d.id AS dis_id,d.`distributor_code`,d.`distributor_name`,d.`distributor_type` ,d.`state_region` ,d.`mno_id`,d.`country`,u.`verification_number`,u.is_enable,u.user_name
                                                                                FROM `exp_mno_distributor` d
                                                                                LEFT JOIN admin_users u ON d.`distributor_code`=u.`user_distributor`
                                                                                WHERE d.parent_id = '$get_edit_parent_id'
                                                                                AND u.access_role='admin' ORDER BY u.`verification_number` ASC";
                                                        ?>

                                                        <thead>


                                                        <tr>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Customer Account#</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Name</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">GATEWAY</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                                                            <?php  if(in_array('support', $access_modules_list)){ ?>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">ASSIGNED ADMIN</th>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Resend</th>
                                                            <?php } ?>
                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>

                                                        </tr>




                                                            </thead>

                                                            <tbody>



                                                            <?php





                                                            $query_results=mysql_query($location_q);
                                                            while($row=mysql_fetch_array($query_results)){

                                                                $distributor_code = $row[distributor_code];
                                                                $distributor_name = str_replace("\\",'',$row[distributor_name]);
                                                                $distributor_type = $row[distributor_type];
                                                                $distributor_icoms = $row[verification_number];

                                                                $distributor_gateway_type = $row[gateway_type];

                                                                $distributor_id_number = $row[dis_id];
                                                                $distributor_user_name = $row['user_name'];
                                                                $is_enable = $row[is_enable];
                                                                if(empty($distributor_user_name)|| $is_enable==8){
                                                                    $pa_act_user = "NO";
                                                                }else{
                                                                    $pa_act_user= "YES";
                                                                }

                                                                $distributor_name_display=str_replace("'","\'",$distributor_name);

                                                                echo '<tr>';
                                                                echo '<!--<td> '.$db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'").' </td> -->

                                                                <td> '.$distributor_icoms.' </td>
                                                                <td> '.$distributor_name.' </td>
                                                                
                                                                <td> '.$distributor_gateway_type.' </td>';

                                                                echo '<td><a href="javascript:void();" id="EDITACCd_'.$distributor_id_number.'"  class="btn btn-small btn-info">

														<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

													$(document).ready(function() {
													$(\'#EDITACCd_'.$distributor_id_number.'\').easyconfirm({locale: {
															title: \'Account Edit\',
															text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
															button: [\'Cancel\',\' Confirm\'],
															closeText: \'close\'
														     }});

														$(\'#EDITACCd_'.$distributor_id_number.'\').click(function() {
															window.location = "?token7='.$secret.'&t=5&edit_loc_id='.$distributor_id_number.'&location_parent_id='.$get_edit_parent_id.'"

														});

														});

													</script></td>';


                                                              if(in_array('support', $access_modules_list)) {
                                                                  echo '<td>' . $pa_act_user . ' &nbsp;/';

                                                                  echo '<a href="javascript:void();" id="ed_' . $distributor_icoms . '"  class="btn btn-small btn-primary">
											<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Edit</a><script type="text/javascript">
											$(document).ready(function() {
											$(\'#ed_' . $distributor_icoms . '\').easyconfirm({locale: {
													title: \'Assign Admin \',
													text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
													button: [\'Cancel\',\' Confirm\'],
													closeText: \'close\'
												     }});
												$(\'#ed_' . $distributor_icoms . '\').click(function() {
													window.location = "?t=13tokene=' . $secret . '&assign_loc_admin=' . $distributor_id_number . '"
												});
												});
											</script>';


                                                                  echo '</td><td>';

                                                                  if($pa_act_user=='YES' && $is_enable=='2'){
                                                                      //t=12&edit_parent_id
                                                                      echo '<a href="javascript:void();" id="resend_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#resend_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                    title: \'Resend Email\',
                                                                    text: \'Are you sure you want to resend email?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#resend_'.$distributor_id_number.'\').click(function() {
                                                                    window.location = "?tokene='.$secret.'&e_resend_a='.$distributor_code.'&t=12&edit_parent_id='.$get_edit_parent_id.'"
                                                                });
                                                                });
                                                            </script>';

                                                                  }else{
                                                                      echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a>';
                                                                  }

                                                                  echo '</td>';
                                                              }


                                                                echo '<td><a href="javascript:void();" id="DISTRI_'.$distributor_id_number.'"  class="btn btn-small btn-primary" >

                                <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><img id="distributor_loader_'.$distributor_id_number.'" src="img/loading_ajax.gif" style="display:none;"><script type="text/javascript">

                                    $(document).ready(function() {

                                    $(\'#DISTRI_'.$distributor_id_number.'\').easyconfirm({locale: {
                                            title: \'Account Remove\',
                                            text: \'Are you sure you want to remove this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#DISTRI_'.$distributor_id_number.'\').click(function() {
                                            window.location = "?token7='.$secret.'&t=12&remove_loc_code='.$distributor_code.'&remove_loc_name='.$distributor_name.'&remove_loc_id='.$distributor_id_number.'&edit_parent_id='.$get_edit_parent_id.'"
                                        });
                                        });
                                    </script></td>';





                                                                echo '</tr>';

                                                            }
                                                            ?>


                                                            </tbody>
                                                            </table>
                                                            </div>
                                                            </div>
                                                            </div>



                                                            </div>


                                        <!-- ******************************************************* -->
                                        <div <?php if(isset($tab6)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="mno_account">




                                            <form onkeyup="submit_mno_formfn();" onchange="submit_mno_formfn();" id="mno_form" name="mno_form" class="form-horizontal" method="POST" action="location.php?<?php if($mno_edit==1){echo "t=8&mno_edit=1&mno_edit_id=$edit_mno_id";}else{echo "t=6";}?>" >

                                                                     <?php
                                                                        echo '<input type="hidden" name="form_secret6" id="form_secret6" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                                     ?>

                                                                        <fieldset>

                                                                        <div id="response_mno">

                                                                        </div>



                                    <style type="text/css">
                                        .ms-container{
                                            display: inline-block !important;
                                        }
                                    </style>
                                                                        <div class="control-group">
                                                                                <label class="control-label" for="AP_cont">AP Controller<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <select multiple="multiple" name="AP_cont[]" id="AP_cont"  class="span4 form-control">
                                                                                     <!--  <option value="">-- Select AP Controller --</option> -->
                                                                                       <?php

                                                                                            $q1 = "SELECT o.`controller_name` FROM `exp_locations_ap_controller` o
                                                                                                            LEFT JOIN `exp_mno_ap_controller` m ON m.ap_controller = o.`controller_name`
                                                                                                            WHERE m.ap_controller IS NULL
                                                                                                            ORDER BY o.`controller_name`";


                                                                                                    $query_results=mysql_query($q1);
                                                                                                    while($row=mysql_fetch_array($query_results)){

                                                                                                        $dis_code = $row[controller_name];
                                                                                                        if(in_array($dis_code, $ap_controler_array)){
                                                                                                        echo "<option selected value='".$dis_code."'>".$dis_code."</option>";
                                                                                                        }else{

                                                                                                        echo "<option value='".$dis_code."'>".$dis_code."</option>";
                                                                                                        }
                                                                                                    }
                                                                                       if($mno_edit=="1"){

                                                                                           foreach ($ap_controler_array as &$value) {

                                                                                           echo "<option  ".$controller_sel."  selected value='".$value."'>".$value."</option>";
                                                                                           }
                                                                                       }
                                                                                                    ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->





                                                                            <!-- /wag profiles -->

                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_wag_profiles">Assigned WAG's<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">

                                                                                    <textarea style="resize: vertical;" class="span4 form-control" rows="5" id="mno_wag_profiles" name="mno_wag_profiles" readonly ><?php echo $edit_wag_prof_string; ?></textarea>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>




                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_account_name"><?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?> Name<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                        <input class="span4 form-control form-control" id="mno_account_name" placeholder="Wifi Provider Ltd" name="mno_account_name" type="text" value="<?php echo$get_edit_mno_description;?>">
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_user_type">Account Type<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5">
                                                                                    <select name="mno_user_type" id="mno_user_type"  class="span4 form-control form-control" <?php if($mno_edit==1) echo "readonly";?>>
                                                                                        <option value="">Select Type of Account</option>
                                                                                        <?php
                                                                                            if($user_type == 'ADMIN'){

                                                                                                $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=1 AND `is_enable`=1";
                                                                                                $mno_flow=mysql_query($mno_flow_q);
                                                                                                while($mno_flow_row=mysql_fetch_assoc($mno_flow)){
                                                                                                    if($get_edit_mno_user_type==$mno_flow_row[flow_type]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                                                                                }

                                                                                        }

                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                                <?php


                                    $mno_operator_check="SELECT product_code,`product_name` FROM `admin_product` WHERE `is_enable` = '1' AND `user_type` = 'MNO'";
                                    $mno_op_check=mysql_query($mno_operator_check);

                                    if (mysql_num_rows($mno_op_check)>1) {


                                    ?>

                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_sys_package">Operations Type<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <select name="mno_sys_package" id="mno_sys_package"  class="span4 form-control form-control" <?php if($mno_edit==1) echo "readonly";?>>
                                                                                        <option value="">Select Type of Operator</option>
                                                                                        <?php
                                                                                            if($user_type == 'ADMIN'){

                                                                                                $mno_operator_q="SELECT product_code,`product_name` FROM `admin_product` WHERE `is_enable` = '1' AND `user_type` = 'MNO'";
                                                                                                $mno_op=mysql_query($mno_operator_q);
                                                                                                while($mno_op_row=mysql_fetch_assoc($mno_op)){




                                                                                                    if($get_edit_mno_sys_pack==$mno_op_row[product_code]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }



                                                                                                    echo '<option '.$select.' value='.$mno_op_row[product_code].'>'.$mno_op_row[product_name].'</option>';
                                                                                                }

                                                                                        }

                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                    <?php

                                       }else{


                                        $mno_operator_q="SELECT product_code,`product_name` FROM `admin_product` WHERE `is_enable` = '1' AND `user_type` = 'MNO'";
                                        $mno_op=mysql_query($mno_operator_q);
                                        while($mno_op_row=mysql_fetch_assoc($mno_op)){

                                            echo '<input type="hidden" name="mno_sys_package" id="mno_sys_package" value="'.$mno_op_row[product_code].'" />';
                                        }


                                       }

                                    ?>



                                                                         <div class="control-group">
                                                                                <label class="control-label" for="mno_first_name">Admin First Name<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input class="span4 form-control" id="mno_first_name" maxlength="12" placeholder="First Name" name="mno_first_name" type="text" value="<?php echo$get_edit_mno_first_name;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>

                                                                             <div class="control-group">
                                                                                <label class="control-label" for="mno_last_name">Admin Last Name<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input class="span4 form-control" id="mno_last_name" maxlength="12" placeholder="Last Name" name="mno_last_name" type="text" value="<?php echo$get_edit_mno_last_name;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>

                                                                             <div class="control-group">
                                                                                <label class="control-label" for="mno_email">Admin Email<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input class="span4 form-control" id="mno_email" name="mno_email" type="email" placeholder="wifi@company.com" value="<?php echo$get_edit_mno_email;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>


                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_address_1">Address<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo$get_edit_mno_ad1;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>


                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_address_2">City<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo$get_edit_mno_ad2;?>" autocomplete="off">
                                                                                </div>
                                                                            </div>



                                                                            <div class="control-group">
                                                                        <label class="control-label" for="mno_country" >Country<font color="#FF0000"></font></sup></label>

                                                    <div class="controls col-lg-5 form-group">

                                                    <select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off">
                                                        <option value="">Select Country</option>
                                                    <?php
                                                    $count_results=mysql_query("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                                    UNION ALL
                                    SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");
                                                   while($row=mysql_fetch_array($count_results)){
                                                            if($row[a]==$get_edit_mno_country){
                                                               $select="selected";
                                                            }else{
                                                                $select="";
                                                            }

                                                       echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';

                                                   }
                                                    ?>


                                                  </select>

                                                                        </div>
                                                                    </div>
                                                               <!-- /controls -->

                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                 <!--   <input class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" type="text" value="<?php //echo $get_edit_mno_state_region?>">  -->


                                                                               <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
                                                                                    <?php
                                                                                     $get_regions=mysql_query("SELECT
                                                                                      `states_code`,
                                                                                      `description`
                                                                                    FROM
                                                                                    `exp_country_states`");

                                                                                     echo '<option value="">Select State</option>';

                                                                                    while($state=mysql_fetch_assoc($get_regions)){
                                                                                        if($get_edit_mno_state_region==$state['states_code']) {

                                                                                            echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                                        }else{

                                                                                            echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                                        }
                                                                                    }

                                                                                    ?>
                                                                                    </select>




                                                                                </div>
                                                                            </div>



                                                                             <div class="control-group">
                                                                                <label class="control-label" for="mno_region">ZIP Code<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip?>" autocomplete="off">
                                                                                </div>
                                                                            </div>

                                                                            <script type="text/javascript">

                                                                            $(document).ready(function() {



                                                                                $("#mno_zip_code").keydown(function (e) {


                                                                                    var mac = $('#mno_zip_code').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }
                                                                                });


                                                                            });

                                                                            </script>

                                                                            <div class="control-group">
                                                                                    <label class="control-label" for="mno_mobile">Phone Number 1<sup><font color="#FF0000"></font></sup></label>
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                        <input class="span4 form-control" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone1?>" autocomplete="off">
                                                                                    </div>
                                                                            </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('#mno_mobile_1').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $('#mno_mobile_1').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $("#mno_mobile_1").keydown(function (e) {


                                                                                    var mac = $('#mno_mobile_1').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);

                                                                                    if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                                        //console.log(valu);
                                                                                        //$('#phone_num_val').val(valu);

                                                                                    }
                                                                                    else{

                                                                                        if(len == 4){
                                                                                            $('#mno_mobile_1').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('#mno_mobile_1').val(function() {
                                                                                                return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                                                //console.log('mac2 ' + mac);

                                                                                            });
                                                                                        }
                                                                                    }


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }
                                                                                });


                                                                            });

                                                                            </script>



                                                                                     <div class="control-group">
                                                                                    <label class="control-label" for="mno_mobile">Phone Number 2<sup><font color="#FF0000"></font></sup></label>
                                                                                    <div class="controls col-lg-5 form-group">

                                                                                        <input class="span4 form-control" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone2?>" autocomplete="off" >




                                                                                    </div>
                                                                                </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('#mno_mobile_2').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $('#mno_mobile_2').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $("#mno_mobile_2").keydown(function (e) {


                                                                                    var mac = $('#mno_mobile_2').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);

                                                                                    if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                                        //console.log(valu);
                                                                                        //$('#phone_num_val').val(valu);

                                                                                    }
                                                                                    else{

                                                                                        if(len == 4){
                                                                                            $('#mno_mobile_2').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('#mno_mobile_2').val(function() {
                                                                                                return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                                                //console.log('mac2 ' + mac);

                                                                                            });
                                                                                        }
                                                                                    }


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }
                                                                                });


                                                                            });

                                                                            </script>


                                                                               <div class="control-group">
                                                                                         <label class="control-label" for="mno_mobile">Phone Number 3<sup><font color="#FF0000"></font></sup></label>
                                                                                         <div class="controls col-lg-5 form-group">
                                                                                             <input class="span4 form-control" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone3?>" autocomplete="off">
                                                                                         </div>
                                                                                     </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('#mno_mobile_3').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $('#mno_mobile_3').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                                });

                                                                                $("#mno_mobile_3").keydown(function (e) {


                                                                                    var mac = $('#mno_mobile_3').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);

                                                                                    if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                                        //console.log(valu);
                                                                                        //$('#phone_num_val').val(valu);

                                                                                    }
                                                                                    else{

                                                                                        if(len == 4){
                                                                                            $('#mno_mobile_3').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('#mno_mobile_3').val(function() {
                                                                                                return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                                                //console.log('mac2 ' + mac);

                                                                                            });
                                                                                        }
                                                                                    }


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }
                                                                                });


                                                                            });

                                                                            </script>

                                                                                     <div class="control-group">
                                                                                         <label class="control-label" for="mno_timezone">Time Zone<sup><font color="#FF0000"></font></sup></label>
                                                                                         <div class="controls col-lg-5 form-group">
                                                                                             <select class="span4 form-control" id="mno_time_zone" name="mno_time_zone" autocomplete="off">
                                                                                                 <option value="">Select Time Zone</option>
                                                                                                 <?php



                                                                                                 $utc = new DateTimeZone('UTC');
                                                                                                 $dt = new DateTime('now', $utc);


                                                                                                 foreach(DateTimeZone::listIdentifiers() as $tz) {
                                                                                                     $current_tz = new DateTimeZone($tz);
                                                                                                     $offset =  $current_tz->getOffset($dt);
                                                                                                     $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                                                     $abbr = $transition[0]['abbr'];

                                                                                                     echo $get_edit_mno_timezones;
                                                                                                     if($get_edit_mno_timezones==$tz){
                                                                                                        $select="selected";
                                                                                                     }else{
                                                                                                         $select="";
                                                                                                     }
                                                                                                     echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. formatOffset($offset). ']</option>';
                                                                                                    // $select="";
                                                                                                 }
                                                                                                // $select="";
                                                                                                 ?>
                                                                                             </select>
                                                                                         </div>
                                                                                     </div>





                                                    <div class="form-actions">

                                                        <button disabled type="submit" id="submit_mno_form" name="submit_mno_form" class="btn btn-primary"><?php if($mno_edit==1){echo "Update Account";}else{echo "Create Account";}?></button>
                                                                            <?php if($mno_edit==1){ ?> <button type="button" class="btn btn-info inline-btn"  onclick="goto();" class="btn btn-danger">Cancel</button> <?php } ?>

                                                                    </div>
                                                                            <script>
                                                                                        function submit_mno_formfn() {
                                                                                            //alert("fn");
                                                                                            $("#submit_mno_form").prop('disabled', false);
                                                                                        }

                                                                                        function goto(url){
                                                                                        window.location = "?";
                                                                                        }
                                                                                    </script>



                                                        <!-- /form-actions -->

                                                            </fieldset>

                                                </form>

                                        <!-- /widget -->
                                        </div>



                                        <!-- ***************Activate Accounts******************* -->

                                        <div <?php if(isset($tab9)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="assign_ap">


                                    <?php ?>


                                    <p>To send an automatic email invitation to the SMB Manager, click on "Email" Button.<br/>
                                    This email contains the SMB account activation information.</p><br/>


                                    <div id="response_d1">

                                        </div>


                                    <div class="widget widget-table action-table">

                                                <div class="widget-header">

                                                   <!--  <i class="icon-th-list"></i> -->

                                                    <h3>Dormant</h3>

                                                    <img id="location_loader_1" src="img/loading_ajax.gif" style="visibility: hidden;">

                                                </div>

                                                <!-- /widget-header -->

                                                <div class="widget-content table_response" id="location_div">
                                                    <div style="overflow-x:auto">

                                                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                                                        <?php
                                                            if($user_type == 'MNO'){

                                                                /*
                                                                $query_1 = "SELECT d.`verification_number`, d.`gateway_type`,d.`country`,d.`state_region` ,d.`id` as d_id,d.`distributor_code`, d.`distributor_name`, d.`distributor_type`, d.`create_date`, u.`is_enable`, u.`id`
                                                                            FROM exp_mno_distributor  d
                                                                            LEFT JOIN admin_invitation_email i
                                                                            ON d.`distributor_code` = i.`distributor`
                                                                            LEFT JOIN admin_users u
                                                                            ON i.`user_name`=u.`user_name` WHERE d.`mno_id` = '$user_distributor' AND LENGTH(d.`parent_code`) = 0 AND u.`is_enable`=2 ORDER BY d.`verification_number` ASC";  */

                                                               $query_1 = "SELECT p.id , p.parent_id,count(distributor_code) as properties, u.full_name,p.account_name,p.create_date FROM exp_mno m JOIN mno_distributor_parent p ON m.mno_id = p.mno_id LEFT JOIN exp_mno_distributor d ON p.parent_id = d.parent_id LEFT JOIN admin_users u ON p.parent_id = u.verification_number 
                                                                          WHERE m.mno_id='$user_distributor' AND u.is_enable ='2' GROUP BY p.parent_id";

                                                            }
                                                            else{

                                                                 $query_1 = "SELECT d.`verification_number`, d.`gateway_type` ,d.`country` ,d.`state_region`, d.`id` as d_id,d.`distributor_code`, d.`distributor_name`, d.`distributor_type`, d.`create_date`, u.`is_enable`, u.`id`
                                                                            FROM exp_mno_distributor  d
                                                                            LEFT JOIN admin_invitation_email i
                                                                            ON d.`distributor_code` = i.`distributor`
                                                                            LEFT JOIN admin_users u
                                                                            ON i.`user_name`=u.`user_name`
                                                                            WHERE d.`parent_code` = '$user_distributor' AND u.`is_enable`=2 ORDER BY d.`verification_number` ASC";

                                                            }
                                                         ?>

                                                        <thead>

                                                            <tr>
                                                                <!--<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Type of Account</th>-->

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Business ID</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Business Account Name</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">PROPERTIES</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Creation Date</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Send</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>



                                                            <?php





                                                                $query_results=mysql_query($query_1);
                                                                while($row=mysql_fetch_array($query_results)){

                                                                    /*
                                                                    $distributor_code = $row[distributor_code];
                                                                    $distributor_name = $row[distributor_name];
                                                                    $distributor_type = $row[distributor_type];
                                                                    $distributor_icoms = $row[verification_number];
                                                                    $distributor_country = $row[country];
                                                                    $distributor_state_region = $row[state_region];
                                                                    $distributor_gateway_type = $row[gateway_type];
                                                                    $create_date = $row[create_date];
                                                                    $distributor_id_number = $row[d_id];
                                                                    $is_enable = $row[is_enable];

                                                                    $distributor_name_display=str_replace("'","\'",$distributor_name);  */
                                                                    
                                                                    $parent_id = $row['parent_id'];
                                                                    $parent_properties = $row['properties'];
                                                                    $parent_account_name = str_replace("\\",'',$row['account_name']);
                                                                    $parent_create_date = $row['create_date'];
                                                                    $parent_tbl_id = $row['id'];



                                                                    echo '<tr>';
                                                                   echo '<!--<td> '.$db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'").' </td> -->
                                    
                                                                    <td> '.$parent_id.' </td>
                                                                    <td> '.$parent_account_name.' </td>
                                                                    <td> '.$parent_properties.' </td>
                                                                    <td> '.$parent_create_date.' </td>';



                                     echo '<td><a href="javascript:void();" id="DISTRI_'.$parent_tbl_id.'"  class="btn btn-small btn-primary" >
                                    
                                                                    <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><img id="distributor_loader_'.$parent_tbl_id.'" src="img/loading_ajax.gif" style="display:none;"><script type="text/javascript">
                                    
                                                                        $(document).ready(function() {
                                    
                                                                        $(\'#DISTRI_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                                                title: \'Account Remove\',
                                                                                text: \'Are you sure you want to remove this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#DISTRI_'.$parent_tbl_id.'\').click(function() {
                                                                                window.location = "?token5='.$secret.'&t=9&remove_par_code='.$parent_id.'&remove_par_id='.$parent_tbl_id.'"
                                                                            });
                                                                            });
                                                                        </script></td>';








                                                                    echo '<td><a href="javascript:void();" id="EDITACC1_'.$parent_tbl_id.'"  class="btn btn-small btn-info">
                                    
                                                                                            <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
                                    
                                                                                        $(document).ready(function() {
                                                                                        $(\'#EDITACC1_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                                                                title: \'Account Edit\',
                                                                                                text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                                closeText: \'close\'
                                                                                                 }});
                                    
                                                                                            $(\'#EDITACC1_'.$parent_tbl_id.'\').click(function() {
                                                                                                window.location = "?token7='.$secret.'&t=12&edit_parent_id='.$parent_id.'"
                                    
                                                                                            });
                                    
                                                                                            });
                                    
                                                                                        </script></td>';



                                                            echo '<td><a href="javascript:void();" id="SEMAIL_'.$parent_tbl_id.'"  class="btn btn-small btn-danger" >
                                    
                                                                    <i class="btn-icon-only icon-envelope"></i>&nbsp;Email</a><script type="text/javascript">
                                    
                                                                        $(document).ready(function() {
                                    
                                                                        $(\'#SEMAIL_'.$parent_tbl_id.'\').easyconfirm({locale: {
                                                                                title: \'Send Email\',
                                                                                text: \'Are you sure you want to send an email invitation? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#SEMAIL_'.$parent_tbl_id.'\').click(function() {
                                                                                window.location = "?form_secret5='.$secret.'&t=9&distributor_code='.$parent_id.'&distributor_name='.$distributor_name.'&resendMail=set"
                                                                            });
                                                                            });
                                                                        </script></td>';





                                                                echo '</tr>';

                                                                    }
                                                            ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                                </div>
                                            </div>


                                    </div>

                                            <!-- ******************************************************* -->
                                        <div <?php if(isset($tab5)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="create_location">



                                                        <form onkeyup="location_formfn();" onchange="location_formfn();"   autocomplete="off"   id="location_form" name="location_form" method="post" class="form-horizontal"	action="<?php if($_POST['p_update_button_action']=='add_location' || isset($_GET['location_parent_id'])){echo '?token7='.$secret.'&t=12&edit_parent_id='.$edit_parent_id;}else{echo'?t=5';} ?>" >

                                                                <?php
                                                                  echo '<input type="hidden" name="form_secret5" id="form_secret5" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                                ?>

                                                                <fieldset>
                                                                            <div id="response_d1">

                                                                            </div>
                                                                            <?php
                                                                            //***************Field Filtor******************
                                                                            $json_fields=$package_functions->getOptions('VENUE_ACC_CREAT_FIELDS',$system_package);
                                                                            $field_array=(array)json_decode($json_fields);
                                                                          //  print_r($field_array);
                                                                            ?>


                                                                            <h3>Account Info</h3>
                                                                            <br>


                                                                        <?php
                                                                                if(array_key_exists('parent_id',$field_array) || $package_features=="all"){
                                                                            ?>


                                                                        <div class="control-group">
                                                                            <label class="control-label" for="customer_type">Business ID<?php if($field_array['parent_id']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <input <?php if(isset($edit_parent_id)){ ?>readonly<?php } ?> maxlength="12" type='text' class="span4 form-control" placeholder="SAN123456789" name='parent_id' id='parent_id' value="<?php echo $edit_parent_id; ?>" data-toggle="tooltip" title="The Business ID format: 3 alpha characters followed by 3-9 numeric characters. EX. SAN123 or SAN123456789">
                                                                            </div>
                                                                            <script type="text/javascript">
                                                                              $("#parent_id").keypress(function(event){
                                                                                var ew = event.which;
                                                                                if(ew == 32)
                                                                                  return true;
                                                                                if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122)
                                                                                  return true;
                                                                                return false;
                                                                              });
                                                                            </script> 
                                                                        </div>
                                                                            <?php }

                                                                                if(array_key_exists('parent_ac_name',$field_array) || $package_features=="all"){
                                                                            ?>


                                                                        <div class="control-group">
                                                                            <label class="control-label" for="customer_type">Business Account Name<?php if($field_array['parent_ac_name']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <input <?php if(isset($edit_parent_ac_name)){ ?>readonly<?php } ?> type='text' class="span4 form-control" placeholder="joey's pizza" name='parent_ac_name' id='parent_ac_name' value="<?php echo str_replace("\\",'',$edit_parent_ac_name); ?>">
                                                                            </div>
                                                                        </div>
                                                                            <?php }

                                                                                if(array_key_exists('f_name',$field_array) || $package_features=="all"){
                                                                                    ?>

                                                                             <div class="control-group">
                                                                                    <label class="control-label" for="mno_first_name">Admin First Name<?php if($field_array['f_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                        <input <?php if(isset($edit_first_name)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_first_name" placeholder="First Name" name="mno_first_name" type="text" maxlength="12" value="<?php echo $edit_first_name; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <?php }
                                                                                if(array_key_exists('l_name',$field_array) || $package_features=="all"){
                                                                                    ?>
                                                                                 <div class="control-group">
                                                                                    <label class="control-label" for="mno_last_name">Admin Last Name<?php if($field_array['l_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                        <input <?php if(isset($edit_last_name)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_last_name" placeholder="Last Name" name="mno_last_name" maxlength="12" type="text" value="<?php echo $edit_last_name; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <?php }


                                                                                if(array_key_exists('email',$field_array) || $package_features=="all"){
                                                                                            ?>
                                                                                         <div class="control-group">
                                                                                            <label class="control-label" for="mno_email">Admin Email<?php if($field_array['email']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                            <div class="controls col-lg-5 form-group">
                                                                                                <input <?php if(isset($edit_email)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_email" name="mno_email" type="email" placeholder="wifi@company.com"   value="<?php echo $edit_email; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php }

                                                                                    $parent_package=$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);
                                                                                    $parent_package_array =explode(',',$parent_package);
                                                                                    //print_r($parent_package_array);
                                                                                    if(count($parent_package_array)>1){

                                                                                        ?>

                                                                                         <div class="control-group">
                                                                                            <label class="control-label" for="parent_package_type">Admin Type</label>
                                                                                            <div class="controls col-lg-5 form-group">
                                                                                                <?php if(isset($edit_parent_package)){ ?>
                                                                                                <input readonly class="span4 form-control" id="parent_package" name="parent_package_type" type="text" placeholder="wifi@company.com"   value="<?php echo $edit_parent_package; ?>">
                                                                                                <?php }else{
                                                                                                    echo'<select class="span4 form-control" id="parent_package" name="parent_package_type">';
                                                                                                    echo '<option value="">Select Business ID type</option>';

                                                                                                    foreach($parent_package_array as $value){
                                                                                                        $parent_package_name = $db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");
                                                                                                        echo '<option value="'.$value.'">'.$parent_package_name.'</option>';
                                                                                                    }
                                                                                                         echo '</select>';
                                                                                                } ?>
                                                                                            </div>
                                                                                         </div>
                                                                                    <?php }else{

                                                                                        echo '<div class="control-group">
                                                                                            <div class="controls col-lg-5 form-group">
                                                                                        <input class="span4 form-control"  id="parent_package" name="parent_package_type" type="hidden" value="'.$parent_package_array[0].'">
                                                                                        </div>
                                                                                         </div>
                                                                                        ';
                                                                                    }

                                                                                    ?>




                                    <hr>

                                                                  <div id="location_info_div" style="">
                                                                            <h3>Location Info</h3>


                                                                    <?php
                                                                     if(array_key_exists('account_type',$field_array)){

                                                                         $js_array=array();


                                                                         foreach ($parent_package_array as $value){

                                                                             //$package_functions->getOptions('LOCATION_PACKAGE',$value);

                                                                             $location_package_ar=explode(',',$package_functions->getOptions('LOCATION_PACKAGE',$value));
                                                                             $produts = "'" . implode("','", $location_package_ar) . "'";
                                                                             $get_types_q="SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
                                                                             $get_types_r=mysql_query($get_types_q);

                                                                             $location_detail_ar = array();
                                                                             while($get_types=mysql_fetch_assoc($get_types_r)){
                                                                                 array_push($location_detail_ar ,array("code"=>$get_types[product_code],"name"=>$get_types[product_name]));
                                                                             }

                                                                             $js_array[$value] = $location_detail_ar;

                                                                         }
                                                                         //print_r(json_encode($js_array));

                                                                        ?>


                                                                    <div class="control-group">
                                                                        <label class="control-label" for="customer_type">Account Type<?php if($field_array['account_type']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                        <div class="controls col-lg-5 form-group">
                                                                            <select name="customer_type" id="customer_type" class="span4 form-control" <?php if($field_array['account_type']=="mandatory"){ ?>required<?php } ?>>
                                                                                <option value="">Select Type</option>
                                                                                <?php
                                                                                //echo'**'. $edit_parent_package.'**';
                                                                                //print_r($js_array[$edit_parent_package]);
                                                                                    if(isset($edit_parent_package)) {
                                                                                        $produts = $js_array[$edit_parent_package] ;
                                                                                        foreach($produts as $value){

                                                                                            if($edit_distributor_system_package==$value['code']){
                                                                                                ?>
                                                                                                <option selected value="<?php echo$value['code'];?>"><?php echo$value['name'];?></option>
                                                                                                <?php
                                                                                            }else{
                                                                                                ?>
                                                                                                <option value="<?php echo$value['code'];?>"><?php echo$value['name'];?></option>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                    }elseif(count($js_array)==1){
                                                                                        foreach($js_array as $adminValue) {

                                                                                            foreach ($adminValue as $value) {
                                                                                                    ?>
                                                                                                    <option value="<?php echo $value['code']; ?>"><?php echo $value['name']; ?></option>
                                                                                                    <?php
                                                                                                }
                                                                                        }
                                                                                    }
                                                                                    //$get_types_q="SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
                                                                                    //$get_types_r=mysql_query($get_types_q);
                                                                                    //while($get_types=mysql_fetch_assoc($get_types_r)){

                                                                                ?>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                        <?php if(!isset($edit_parent_package)){    ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    var product_json = '<?php echo json_encode($js_array); ?>';
                                                                                    var product_array = JSON.parse(product_json);


                                                                                    $('#parent_package').change(function () {
                                                                                        var value = $('#parent_package').val();
                                                                                        $('#customer_type').children('option:not(:first)').remove();
                                                                                        var apend_ob = product_array[value];

                                                                                        apend_ob.forEach(function(element) {
                                                                                            //alert(element['code']);
                                                                                            $("#customer_type").append('<option value="'+element['code']+'">'+element['name']+'</option>');

                                                                                        });
                                                                                    });

                                                                                });
                                                                            </script>
                                                                        <?php    } ?>

                                                                                <?php }
                                                                    if(array_key_exists('icomms_number',$field_array)){ ?>
                                                                            <div class="control-group" id="icomme_div">
                                                                                <label class="control-label" for="customer_type">Customer Account Number<?php if($field_array['icomms_number']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input type="text" class="span4 form-control" id="icomme" name="icomme" onblur="check_icom(this)" pattern="[0-9]{12}$" maxlength="12" value="<?php echo$edit_distributor_verification_number;?>" <?php if($edit_account==1){ ?>readonly<?php } ?>>
                                                                                    <div style="display: inline-block" id="img_icom"></div>
                                                                                </div>
                                                                            </div>

                                                                            <script type="text/javascript">

                                                                            $(document).ready(function() {



                                                                                $("#icomme").keydown(function (e) {


                                                                                    var mac = $('#icomme').val();
                                                                                    var len = mac.length + 1;
                                                                                  // console.log(e.keyCode);
                                                                                    //console.log('len '+ len);


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                                                                                                // Allow: Ctrl+A, Command+A
                                                                                            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                                // Allow: Ctrl+C, Command+C
                                                                                            (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                                // Allow: Ctrl+x, Command+x
                                                                                            (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                                // Allow: Ctrl+V, Command+V
                                                                                            (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                                // Allow: home, end, left, right, down, up
                                                                                        //	(e.keyCode == 190 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                                // Allow: home, end, left, right, down, up
                                                                                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                                        // let it happen, don't do anything
                                                                                        return;
                                                                                    }
                                                                                    // Ensure that it is a number and stop the keypress
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }
                                                                                });


                                                                            });

                                                                            </script>




                                                                        <?php }
                                                                    if(array_key_exists('network_type',$field_array)){
                                                                        ?>

                                                                        <div class="control-group">
                                                                            <label class="control-label" for="location_name1">Package Type<?php if($field_array['network_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                            <div class="controls col-lg-5 form-group">

                                                                                <select <?php if($field_array['network_type']=="mandatory" ){ ?>required<?php } ?> class="span4 form-control" id="network_type" name="network_type" >
                                                                                    <option <?php $edit_distributor_network_type=="" ? print(" selected ") :print (""); ?> value=""> --Select Property Type-- </option>
                                                                                    <option <?php $edit_distributor_network_type=="GUEST" ? print(" selected ") :print (""); ?> value="GUEST"> Guest Only </option>
                                                                                    <option <?php $edit_distributor_network_type=="PRIVATE" ? print(" selected ") :print (""); ?> value="PRIVATE"> Private Only </option>
                                                                                    <option <?php $edit_distributor_network_type=="BOTH" ? print(" selected ") :print (""); ?> value="BOTH">Guest & Private</option>

                                                                                </select>


                                                                            </div>
                                                                        </div>
                                                                    <?php }


                                                                    if(array_key_exists('gateway_type',$field_array)){
                                                                        ?>
                                                                        <div class="control-group" id="gu_geteway_div">
                                                                            <label class="control-label" for="gateway_type">Guest Gateway Type<?php if($field_array['gateway_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                            <div class="controls col-lg-5 form-group">

                                                                                <select <?php if($field_array['gateway_type']=="mandatory" ){ ?>required<?php } ?> class="span4 form-control" id="gateway_type" name="gateway_type" >

                                                                                    <option value="">Select Gateway Type</option>
                                                                                    <?php
                                                                                            $get_gatw_type_q="select gs.gateway_name ,gs.description from exp_gateways gs";
                                                                                            $get_gatw_type_r=mysql_query($get_gatw_type_q);
                                                                                            while($gatw_row=mysql_fetch_assoc($get_gatw_type_r)){
                                                                                                    $gatw_row_gtw=$gatw_row['gateway_name'];
                                                                                                    $gatw_row_dis=$gatw_row['description'];
                                                                                                    ?>
                                                                                                            <option <?php $edit_distributor_gateway_type==$gatw_row_gtw ? print(" selected ") :print (""); ?> value="<?php echo $gatw_row_gtw ;?>"> <?php echo $gatw_row_dis; ?> </option>;

                                                                                    <?php } ?>
                                                                                </select>


                                                                            </div>
                                                                        </div>
                                                                    <?php }

                                                                    if(array_key_exists('pr_gateway_type',$field_array)){ ?>
                                                                        <div class="control-group" id="pr_geteway_div">
                                                                            <label class="control-label" for="pr_gateway_type">Private Gateway Type<?php if($field_array['pr_gateway_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                            <div class="controls col-lg-5 form-group">

                                                                                <select class="span4 form-control" id="pr_gateway_type" name="pr_gateway_type" >

                                                                                    <option value="">Select Gateway Type</option>
                                                                                    <?php
                                                                                            $get_gatw_type_q="select gs.gateway_name ,gs.description from exp_gateways gs";
                                                                                            $get_gatw_type_r=mysql_query($get_gatw_type_q);
                                                                                            while($gatw_row=mysql_fetch_assoc($get_gatw_type_r)){
                                                                                                    $gatw_row_gtw=$gatw_row['gateway_name'];
                                                                                                    $gatw_row_dis=$gatw_row['description'];
                                                                                                    ?>
                                                                                                            <option <?php $edit_distributor_pr_gateway_type==$gatw_row_gtw ? print(" selected ") :print (""); ?> value="<?php echo $gatw_row_gtw.'">'.$gatw_row_dis.'</option>';
                                                                                            }

                                                                                    ?>

                                                                                </select>


                                                                            </div>
                                                                        </div>
                                                                    <?php  }

                                                                    if(array_key_exists('uui_number',$field_array)){
                                                                            ?>
                                                                            <div class="control-group" id="icomme_div">
                                                                                <label class="control-label" for="uui_number">UUI Number<?php if($field_array['uui_number']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input <?php if($field_array['uui_number']=="mandatory"){ ?>required<?php } ?> type="text" maxlength="12" class="span4 form-control" id="icomme" onblur="check_icom(this)" name="icomme" value="<?php echo$edit_distributor_verification_number;?>" <?php if($edit_account==1){ ?>readonly<?php } ?>>
                                                                                    <div style="display: inline-block" id="img_icom"></div>
                                                                                </div>
                                                                            </div>
                                                                            <script type="text/javascript">

                                                                                $(document).ready(function() {



                                                                                    $("#icomme").keydown(function (e) {


                                                                                        var mac = $('#icomme').val();
                                                                                        var len = mac.length + 1;
                                                                                        //console.log(e.keyCode);
                                                                                        //console.log('len '+ len);


                                                                                        // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                        if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                            e.preventDefault();

                                                                                        }
                                                                                    });


                                                                                });

                                                                            </script>
                                                                            <?php
                                                                        }
                                                                        ?>

                                      <script type="text/javascript">


                                        $('#icomme').on('keyup change', function () {
                                            $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>This is a required field</p>');
                                        });

                                      function check_icom(icomval)
                                      {

                                          if ( $('#icomme').is('[readonly]') ) {


                                              }else{

                                                     var valic = icomval.value;
                                                     var valic = valic.trim();



                                                         if(valic!="") {
                                                             document.getElementById("img_icom").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                             var formData = {icom: valic};
                                                             $.ajax({
                                                                 url: "ajax/validateIcom.php",
                                                                 type: "POST",
                                                                 data: formData,
                                                                 success: function (data) {
                                                                     /*  if:new ok->1
                                                                      * if:new exist->2 */


                                                                     if (data == '1') {
                                                                      /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                                         document.getElementById("img_icom").innerHTML ="";
                                                                         document.getElementById("realm").value =valic;
                                                                         <?php if($field_array['network_config']=='display_none'){ ?>
                                                                         document.getElementById("zone_name").value =valic;
                                                                         document.getElementById("zone_dec").value =valic;
                                                                         <?php } ?>


                                                                     } else if (data == '2') {
                                                                        //alert(data);
                                                                        document.getElementById("img_icom").innerHTML ="";
                                                                         document.getElementById('icomme').value = "";
                                                                         document.getElementById("realm").value ="";
                                                                         <?php if($field_array['network_config']=='display_none'){ ?>
                                                                         document.getElementById("zone_name").value ="";
                                                                         document.getElementById("zone_dec").value ="";
                                                                         <?php } ?>
                                                                         /* $('#mno_account_name').removeAttr('value'); */
                                                                         document.getElementById('icomme').placeholder = "Please enter new Customer Account number";
                                                                     }


                                                                     $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic +' - Customer Account exists.</p>');

                                                                     $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');


                                                                 },
                                                                 error: function (jqXHR, textStatus, errorThrown) {
                                                                     alert("error");
                                                                     document.getElementById('icomme').value = "";
                                                                     document.getElementById("realm").value ="";
                                                                     <?php if($field_array['network_config']=='display_none'){ ?>
                                                                     document.getElementById("zone_name").value ="";
                                                                     document.getElementById("zone_dec").value ="";
                                                                     <?php } ?>


                                                                        $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic +' - Customer Account exists.</p>');


                                                                        $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');


                                                                      }



                                                             });
                                                             var bootstrapValidator2 = $('#location_form').data('bootstrapValidator');
                                                             bootstrapValidator2.enableFieldValidators('realm', true);
                                                             <?php if($field_array['network_config']=='display_none'){ ?>
                                                             bootstrapValidator2.enableFieldValidators('zone_name', true);
                                                             bootstrapValidator2.enableFieldValidators('zone_dec', true);

                                                             <?php } ?>
                                                         }


                                                  }





                                      }

                                    </script>



                                                                        <?php
                                                                        if(array_key_exists('location_type',$field_array) || $package_features=="all"){
                                                                        ?>

                                                                            <div class="control-group" <?php if(array_key_exists('network_type',$field_array)){echo 'style="display:none"';} ?> >
                                                                                <label class="control-label" for="user_type">Property Type<?php if($field_array['location_type']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">

                                                                                        <select <?php if($field_array['location_type']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> name="user_type" id="user_type" class="span4 form-control" <?php  if(isset($edit_distributor_type)){ echo 'disabled';} ?>>

                                                                                            <option value=''>Select Account Type</option>
                                                                                            <?php // } ?>




                                                                                        <?php

                                                                                            if($user_type == 'MNO'){

                                                                                                if(array_key_exists('network_type',$field_array)){ $edit_distributor_type='MVNO';}
                                                                                                $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=3 AND `is_enable`=1";
                                                                                                $mno_flow=mysql_query($mno_flow_q);
                                                                                                while($mno_flow_row=mysql_fetch_assoc($mno_flow)){
                                                                                                    if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                                                                                }


                                                                                                /*echo '
                                                                                                <option value="MVNA">MVNA - Re Seller</option>
                                                                                                <option value="MVNE">MVNE - Hoster</option>
                                                                                                <option value="MVNO">MVNO - Service Provider</option>';*/
                                                                                            }

                                                                                            else if($user_type == 'MVNA'){

                                                                                                $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=3 AND `is_enable`=1";
                                                                                                $mno_flow=mysql_query($mno_flow_q);
                                                                                                while($mno_flow_row=mysql_fetch_assoc($mno_flow)){
                                                                                                    if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                                                                                }

                                                                                                //echo '<option value="MVNO">MVNO - Service Provider</option>';
                                                                                            }

                                                                                            else if($user_type == 'MVNE'){

                                                                                                $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=2 AND `is_enable`=1";
                                                                                                $mno_flow=mysql_query($mno_flow_q);
                                                                                                while($mno_flow_row=mysql_fetch_assoc($mno_flow)){
                                                                                                    if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                                                                        $select="selected";
                                                                                                    }else{
                                                                                                        $select="";
                                                                                                    }
                                                                                                    echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                                                                                }


                                                                                                //echo '<option value="MVNO">MVNO - Service Provider</option>';
                                                                                            }
                                                                                        ?>

                                                                                        </select>

                                                                                </div>
                                                                            </div>
                                                                        <?php }

                                                                        if(array_key_exists('business_type',$field_array)){
                                                                        ?>

                                                                            <div class="control-group">
                                                                                <label class="control-label" for="location_name1">Business Vertical<?php if($field_array['business_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">

                                                                                    <select <?php if($field_array['business_type']=="mandatory" ){ ?>required<?php } ?> class="span4 form-control" id="business_type" name="business_type" >
                                                                                        <option value="">Select Business Type</option>
                                                                                        <?php
                                                                                        $get_businesses_q="SELECT `business_type`,`discription` FROM `exp_business_types` WHERE `is_enable`='1'";
                                                                                        $get_businesses_r=mysql_query($get_businesses_q);
                                                                                        while($get_businesses=mysql_fetch_assoc($get_businesses_r)){
                                                                                            $get_business=$get_businesses['business_type'];
                                                                                            if($edit_distributor_business_type==$get_business){
                                                                                                ?>
                                                                                                <option selected value="<?php echo$get_business;?>"><?php echo$get_businesses['discription'];?></option>
                                                                                                <?php
                                                                                            }else{
                                                                                                ?>
                                                                                                <option value="<?php echo$get_business;?>"><?php echo$get_businesses['discription'];?></option>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                        <?php }

                                                                         if(array_key_exists('account_name',$field_array) || $package_features=="all"){
                                                                        ?>



                                                                            <div class="control-group">
                                                                                <label class="control-label" for="location_name1">Account Name<?php if($field_array['account_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">

                                                                                    <input <?php if($field_array['account_name']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="location_name1" placeholder="ABC Shopping Mall" name="location_name1" type="text" value="<?php echo str_replace("\\",'',$edit_distributor_name); ?>" />

                                                                                </div>
                                                                            </div>
                                                                        <?php }




                                                                            if(array_key_exists('add1',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_address_1">Address<?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input <?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text"   value="<?php echo $edit_bussiness_address1; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <?php }
                                                                            if(array_key_exists('add2',$field_array) || $package_features=="all"){
                                                                                ?>

                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_address_2">City<?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input <?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text"   value="<?php echo $edit_bussiness_address2; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <?php }
                                                                            if(array_key_exists('add3',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                             <div class="control-group">
                                                                                <label class="control-label" for="mno_address_3">Address 3<?php if($field_array['add3']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input <?php if($field_array['add3']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_3" placeholder="Address Line 3" name="mno_address_3" type="text"   value="<?php echo $edit_bussiness_address3; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <?php }
                                                                            if(array_key_exists('country',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                            <div class="control-group">
                                                                        <label class="control-label" for="mno_country" >Country<?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                                                        <div class="controls col-lg-5 form-group">

                                                                        <select <?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> name="mno_country" id="country" class="span4 form-control">
                                                                            <option value="">Select Country</option>
                                                                        <?php

                                                                        // if(isset($edit_country_code)){
                                                                        // 	echo '<option value="'.$edit_country_code.'">'.$edit_country_name.'</option>';
                                                                        // 	}

                                                                        $count_results=mysql_query("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                                                        UNION ALL
                                                        SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");
                                                                       while($row=mysql_fetch_array($count_results)){

                                                                        if($row[a]==$edit_country_code){
                                                                               $select="selected";
                                                                            }else{
                                                                                $select="";
                                                                            }
                                                                                echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';

                                                                                }
                                                                        ?>


                                                                      </select>


                                                                        </div>
                                                                    </div>

                                                                    <script type="text/javascript">

                                                                      // Countries
                                    var country_arr = new Array( "United States of America","Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

                                    // States
                                    var s_a = new Array();
                                    var s_a_val = new Array();
                                    s_a[0] = "";
                                    s_a_val[0] = "";
                                    <?php

                                    $get_regions=mysql_query("SELECT
                                                                                      `states_code`,
                                                                                      `description`
                                                                                    FROM
                                                                                    `exp_country_states`");

                                    $s_a = '';
                                    $s_a_val = '';

                                    while($state=mysql_fetch_assoc($get_regions)){
                                        $s_a .= $state['description'].'|';
                                        $s_a_val .= $state['states_code'].'|';
                                    }

                                    $s_a = rtrim($s_a,"|");
                                    $s_a_val = rtrim($s_a_val,"|");

                                      ?>
                                    s_a[1] = "<?php echo $s_a; ?>";
                                    s_a_val[1] = "<?php echo $s_a_val; ?>";
                                    s_a[2] = "No states available";
                                    s_a[3] = "No states available";
                                    s_a[4] = "No states available";
                                    s_a[5] = "No states available";
                                    s_a[6] = "No states available";
                                    s_a[7] = "No states available";
                                    s_a[8] = "No states available";
                                    s_a[9] = "No states available";
                                    s_a[10] = "No states available";
                                    s_a[11] = "No states available";
                                    s_a[12] = "No states available";
                                    s_a[13] = "No states available";
                                    s_a[14] = "No states available";
                                    s_a[15] = "No states available";
                                    s_a[16] = "No states available";
                                    s_a[17] = "No states available";
                                    s_a[18] = "No states available";
                                    s_a[19] = "No states available";
                                    s_a[20] = "No states available";
                                    s_a[21] = "No states available";
                                    s_a[22] = "No states available";
                                    s_a[23] = "No states available";
                                    s_a[24] = "No states available";
                                    s_a[25] = "No states available";
                                    s_a[26] = "No states available";
                                    s_a[27] = "No states available";
                                    s_a[28] = "No states available";
                                    s_a[29] = "No states available";
                                    s_a[30] = "No states available";
                                    s_a[31] = "No states available";
                                    s_a[32] = "No states available";
                                    s_a[33] = "No states available";
                                    s_a[34] = "No states available";
                                    s_a[35] = "No states available";
                                    s_a[36] = "No states available";
                                    s_a[37] = "No states available";
                                    s_a[38] = "No states available";
                                    s_a[39] = "No states available";
                                    s_a[40] = "No states available";
                                    s_a[41] = "No states available";
                                    s_a[42] = "No states available";
                                    s_a[43] = "No states available";
                                    s_a[44] = "No states available";
                                    s_a[45] = "No states available";
                                    s_a[46] = "No states available";
                                    s_a[47] = "No states available";
                                    s_a[48] = "No states available";
                                    // <!-- -->
                                    s_a[49] = "No states available";
                                    s_a[50] = "No states available";
                                    s_a[51] = "No states available";
                                    s_a[52] = "No states available";
                                    s_a[53] = "No states available";
                                    s_a[54] = "No states available";
                                    s_a[55] = "No states available";
                                    s_a[56] = "No states available";
                                    s_a[57] = "No states available";
                                    s_a[58] = "No states available";
                                    s_a[59] = "No states available";
                                    s_a[60] = "No states available";
                                    s_a[61] = "No states available";
                                    s_a[62] = "No states available";
                                    // <!-- -->
                                    s_a[63] = "No states available";
                                    s_a[64] = "No states available";
                                    s_a[65] = "No states available";
                                    s_a[66] = "No states available";
                                    s_a[67] = "No states available";
                                    s_a[68] = "No states available";
                                    s_a[69] = "No states available";
                                    s_a[70] = "No states available";
                                    s_a[71] = "No states available";
                                    s_a[72] = "No states available";
                                    s_a[73] = "No states available";
                                    s_a[74] = "No states available";
                                    s_a[75] = "No states available";
                                    s_a[76] = "No states available";
                                    s_a[77] = "No states available";
                                    s_a[78] = "No states available";
                                    s_a[79] = "No states available";
                                    s_a[80] = "No states available";
                                    s_a[81] = "No states available";
                                    s_a[82] = "No states available";
                                    s_a[83] = "No states available";
                                    s_a[84] = "No states available";
                                    s_a[85] = "No states available";
                                    s_a[86] = "No states available";
                                    s_a[87] = "No states available";
                                    s_a[88] = "No states available";
                                    s_a[89] = "No states available";
                                    s_a[90] = "No states available";
                                    s_a[91] = "No states available";
                                    s_a[92] = "No states available";
                                    s_a[93] = "No states available";
                                    s_a[94] = "No states available";
                                    s_a[95] = "No states available";
                                    s_a[96] = "No states available";
                                    s_a[97] = "No states available";
                                    s_a[98] = "No states available";
                                    s_a[99] = "No states available";
                                    s_a[100] = "No states available";
                                    s_a[101] = "No states available";
                                    s_a[102] = "No states available";
                                    s_a[103] = "No states available";
                                    s_a[104] = "No states available";
                                    s_a[105] = "No states available";
                                    s_a[106] = "No states available";
                                    s_a[107] = "No states available";
                                    s_a[108] = "No states available";
                                    s_a[109] = "No states available";
                                    s_a[110] = "No states available";
                                    s_a[111] = "No states available";
                                    s_a[112] = "No states available";
                                    s_a[113] = "No states available";
                                    s_a[114] = "No states available";
                                    s_a[115] = "No states available";
                                    s_a[116] = "No states available";
                                    s_a[117] = "No states available";
                                    s_a[118] = "No states available";
                                    s_a[119] = "No states available";
                                    s_a[120] = "No states available";
                                    s_a[121] = "No states available";
                                    s_a[122] = "No states available";
                                    s_a[123] = "No states available";
                                    s_a[124] = "No states available";
                                    s_a[125] = "No states available";
                                    s_a[126] = "No states available";
                                    s_a[127] = "No states available";
                                    s_a[128] = "No states available";
                                    s_a[129] = "No states available";
                                    s_a[130] = "No states available";
                                    s_a[131] = "No states available";
                                    s_a[132] = "No states available";
                                    s_a[133] = "No states available";
                                    s_a[134] = "No states available";
                                    s_a[135] = "No states available";
                                    s_a[136] = "No states available";
                                    s_a[137] = "No states available";
                                    s_a[138] = "No states available";
                                    s_a[139] = "No states available";
                                    s_a[140] = "No states available";
                                    s_a[141] = "No states available";
                                    s_a[142] = "No states available";
                                    s_a[143] = "No states available";
                                    s_a[144] = "No states available";
                                    s_a[145] = "No states available";
                                    s_a[146] = "No states available";
                                    s_a[147] = "No states available";
                                    s_a[148] = "No states available";
                                    s_a[149] = "No states available";
                                    s_a[150] = "No states available";
                                    s_a[151] = "No states available";
                                    s_a[152] = "No states available";
                                    s_a[153] = "No states available";
                                    s_a[154] = "No states available";
                                    s_a[155] = "No states available";
                                    s_a[156] = "No states available";
                                    s_a[157] = "No states available";
                                    s_a[158] = "No states available";
                                    s_a[159] = "No states available";
                                    s_a[160] = "No states available";
                                    s_a[161] = "No states available";
                                    s_a[162] = "No states available";
                                    s_a[163] = "No states available";
                                    s_a[164] = "No states available";
                                    s_a[165] = "No states available";
                                    s_a[166] = "No states available";
                                    s_a[167] = "No states available";
                                    s_a[168] = "No states available";
                                    s_a[169] = "No states available";
                                    s_a[170] = "No states available";
                                    s_a[171] = "No states available";
                                    s_a[172] = "No states available";
                                    s_a[173] = "No states available";
                                    s_a[174] = "No states available";
                                    s_a[175] = "No states available";
                                    s_a[176] = "No states available";
                                    s_a[177] = "No states available";
                                    s_a[178] = "No states available";
                                    s_a[179] = "No states available";
                                    s_a[180] = "No states available";
                                    s_a[181] = "No states available";
                                    s_a[182] = "No states available";
                                    s_a[183] = "No states available";
                                    s_a[184] = "No states available";
                                    s_a[185] = "No states available";
                                    s_a[186] = "No states available";
                                    s_a[187] = "No states available";
                                    s_a[188] = "No states available";
                                    s_a[189] = "No states available";
                                    s_a[190] = "No states available";
                                    s_a[191] = "No states available";
                                    s_a[192] = "No states available";
                                    s_a[193] = "No states available";
                                    s_a[194] = "No states available";
                                    s_a[195] = "No states available";
                                    s_a[196] = "No states available";
                                    s_a[197] = "No states available";
                                    s_a[198] = "No states available";
                                    s_a[199] = "No states available";
                                    s_a[200] = "No states available";
                                    s_a[201] = "No states available";
                                    s_a[202] = "No states available";
                                    s_a[203] = "No states available";
                                    s_a[204] = "No states available";
                                    s_a[205] = "No states available";
                                    s_a[206] = "No states available";
                                    s_a[207] = "No states available";
                                    s_a[208] = "No states available";
                                    s_a[209] = "No states available";
                                    s_a[210] = "No states available";
                                    s_a[211] = "No states available";
                                    s_a[212] = "No states available";
                                    s_a[213] = "No states available";
                                    s_a[214] = "No states available";
                                    s_a[215] = "No states available";
                                    s_a[216] = "No states available";
                                    s_a[217] = "No states available";
                                    s_a[218] = "No states available";
                                    s_a[219] = "No states available";
                                    s_a[220] = "No states available";
                                    s_a[221] = "No states available";
                                    s_a[222] = "No states available";
                                    s_a[223] = "No states available";
                                    s_a[224] = "No states available";
                                    s_a[225] = "No states available";
                                    s_a[226] = "No states available";
                                    s_a[227] = "No states available";
                                    s_a[228] = "No states available";
                                    s_a[229] = "No states available";
                                    s_a[230] = "No states available";
                                    s_a[231] = "No states available";
                                    s_a[232] = "No states available";
                                    s_a[233] = "No states available";
                                    s_a[234] = "No states available";
                                    s_a[235] = "No states available";
                                    s_a[236] = "No states available";
                                    s_a[237] = "No states available";
                                    s_a[238] = "No states available";
                                    s_a[239] = "No states available";
                                    s_a[240] = "No states available";
                                    s_a[241] = "No states available";
                                    s_a[242] = "No states available";
                                    s_a[243] = "No states available";
                                    s_a[244] = "No states available";
                                    s_a[245] = "No states available";
                                    s_a[246] = "No states available";
                                    s_a[247] = "No states available";
                                    s_a[248] = "No states available";
                                    s_a[249] = "No states available";
                                    s_a[250] = "No states available";
                                    s_a[251] = "No states available";
                                    s_a[252] = "No states available";

                                  
 s_a_val[2] = "N/A";
                                    s_a_val[3] = "N/A";
                                    s_a_val[4] = "N/A";
                                    s_a_val[5] = "N/A";
                                    s_a_val[6] = "N/A";
                                    s_a_val[7] = "N/A";
                                    s_a_val[8] = "N/A";
                                    s_a_val[9] = "N/A";
                                    s_a_val[10] = "N/A";
                                    s_a_val[11] = "N/A";
                                    s_a_val[12] = "N/A";
                                    s_a_val[13] = "N/A";
                                    s_a_val[14] = "N/A";
                                    s_a_val[15] = "N/A";
                                    s_a_val[16] = "N/A";
                                    s_a_val[17] = "N/A";
                                    s_a_val[18] = "N/A";
                                    s_a_val[19] = "N/A";
                                    s_a_val[20] = "N/A";
                                    s_a_val[21] = "N/A";
                                    s_a_val[22] = "N/A";
                                    s_a_val[23] = "N/A";
                                    s_a_val[24] = "N/A";
                                    s_a_val[25] = "N/A";
                                    s_a_val[26] = "N/A";
                                    s_a_val[27] = "N/A";
                                    s_a_val[28] = "N/A";
                                    s_a_val[29] = "N/A";
                                    s_a_val[30] = "N/A";
                                    s_a_val[31] = "N/A";
                                    s_a_val[32] = "N/A";
                                    s_a_val[33] = "N/A";
                                    s_a_val[34] = "N/A";
                                    s_a_val[35] = "N/A";
                                    s_a_val[36] = "N/A";
                                    s_a_val[37] = "N/A";
                                    s_a_val[38] = "N/A";
                                    s_a_val[39] = "N/A";
                                    s_a_val[40] = "N/A";
                                    s_a_val[41] = "N/A";
                                    s_a_val[42] = "N/A";
                                    s_a_val[43] = "N/A";
                                    s_a_val[44] = "N/A";
                                    s_a_val[45] = "N/A";
                                    s_a_val[46] = "N/A";
                                    s_a_val[47] = "N/A";
                                    s_a_val[48] = "N/A";
                                    // <!-- -->
                                    s_a_val[49] = "N/A";
                                    s_a_val[50] = "N/A";
                                    s_a_val[51] = "N/A";
                                    s_a_val[52] = "N/A";
                                    s_a_val[53] = "N/A";
                                    s_a_val[54] = "N/A";
                                    s_a_val[55] = "N/A";
                                    s_a_val[56] = "N/A";
                                    s_a_val[57] = "N/A";
                                    s_a_val[58] = "N/A";
                                    s_a_val[59] = "N/A";
                                    s_a_val[60] = "N/A";
                                    s_a_val[61] = "N/A";
                                    s_a_val[62] = "N/A";
                                    // <!-- -->
                                    s_a_val[63] = "N/A";
                                    s_a_val[64] = "N/A";
                                    s_a_val[65] = "N/A";
                                    s_a_val[66] = "N/A";
                                    s_a_val[67] = "N/A";
                                    s_a_val[68] = "N/A";
                                    s_a_val[69] = "N/A";
                                    s_a_val[70] = "N/A";
                                    s_a_val[71] = "N/A";
                                    s_a_val[72] = "N/A";
                                    s_a_val[73] = "N/A";
                                    s_a_val[74] = "N/A";
                                    s_a_val[75] = "N/A";
                                    s_a_val[76] = "N/A";
                                    s_a_val[77] = "N/A";
                                    s_a_val[78] = "N/A";
                                    s_a_val[79] = "N/A";
                                    s_a_val[80] = "N/A";
                                    s_a_val[81] = "N/A";
                                    s_a_val[82] = "N/A";
                                    s_a_val[83] = "N/A";
                                    s_a_val[84] = "N/A";
                                    s_a_val[85] = "N/A";
                                    s_a_val[86] = "N/A";
                                    s_a_val[87] = "N/A";
                                    s_a_val[88] = "N/A";
                                    s_a_val[89] = "N/A";
                                    s_a_val[90] = "N/A";
                                    s_a_val[91] = "N/A";
                                    s_a_val[92] = "N/A";
                                    s_a_val[93] = "N/A";
                                    s_a_val[94] = "N/A";
                                    s_a_val[95] = "N/A";
                                    s_a_val[96] = "N/A";
                                    s_a_val[97] = "N/A";
                                    s_a_val[98] = "N/A";
                                    s_a_val[99] = "N/A";
                                    s_a_val[100] = "N/A";
                                    s_a_val[101] = "N/A";
                                    s_a_val[102] = "N/A";
                                    s_a_val[103] = "N/A";
                                    s_a_val[104] = "N/A";
                                    s_a_val[105] = "N/A";
                                    s_a_val[106] = "N/A";
                                    s_a_val[107] = "N/A";
                                    s_a_val[108] = "N/A";
                                    s_a_val[109] = "N/A";
                                    s_a_val[110] = "N/A";
                                    s_a_val[111] = "N/A";
                                    s_a_val[112] = "N/A";
                                    s_a_val[113] = "N/A";
                                    s_a_val[114] = "N/A";
                                    s_a_val[115] = "N/A";
                                    s_a_val[116] = "N/A";
                                    s_a_val[117] = "N/A";
                                    s_a_val[118] = "N/A";
                                    s_a_val[119] = "N/A";
                                    s_a_val[120] = "N/A";
                                    s_a_val[121] = "N/A";
                                    s_a_val[122] = "N/A";
                                    s_a_val[123] = "N/A";
                                    s_a_val[124] = "N/A";
                                    s_a_val[125] = "N/A";
                                    s_a_val[126] = "N/A";
                                    s_a_val[127] = "N/A";
                                    s_a_val[128] = "N/A";
                                    s_a_val[129] = "N/A";
                                    s_a_val[130] = "N/A";
                                    s_a_val[131] = "N/A";
                                    s_a_val[132] = "N/A";
                                    s_a_val[133] = "N/A";
                                    s_a_val[134] = "N/A";
                                    s_a_val[135] = "N/A";
                                    s_a_val[136] = "N/A";
                                    s_a_val[137] = "N/A";
                                    s_a_val[138] = "N/A";
                                    s_a_val[139] = "N/A";
                                    s_a_val[140] = "N/A";
                                    s_a_val[141] = "N/A";
                                    s_a_val[142] = "N/A";
                                    s_a_val[143] = "N/A";
                                    s_a_val[144] = "N/A";
                                    s_a_val[145] = "N/A";
                                    s_a_val[146] = "N/A";
                                    s_a_val[147] = "N/A";
                                    s_a_val[148] = "N/A";
                                    s_a_val[149] = "N/A";
                                    s_a_val[150] = "N/A";
                                    s_a_val[151] = "N/A";
                                    s_a_val[152] = "N/A";
                                    s_a_val[153] = "N/A";
                                    s_a_val[154] = "N/A";
                                    s_a_val[155] = "N/A";
                                    s_a_val[156] = "N/A";
                                    s_a_val[157] = "N/A";
                                    s_a_val[158] = "N/A";
                                    s_a_val[159] = "N/A";
                                    s_a_val[160] = "N/A";
                                    s_a_val[161] = "N/A";
                                    s_a_val[162] = "N/A";
                                    s_a_val[163] = "N/A";
                                    s_a_val[164] = "N/A";
                                    s_a_val[165] = "N/A";
                                    s_a_val[166] = "N/A";
                                    s_a_val[167] = "N/A";
                                    s_a_val[168] = "N/A";
                                    s_a_val[169] = "N/A";
                                    s_a_val[170] = "N/A";
                                    s_a_val[171] = "N/A";
                                    s_a_val[172] = "N/A";
                                    s_a_val[173] = "N/A";
                                    s_a_val[174] = "N/A";
                                    s_a_val[175] = "N/A";
                                    s_a_val[176] = "N/A";
                                    s_a_val[177] = "N/A";
                                    s_a_val[178] = "N/A";
                                    s_a_val[179] = "N/A";
                                    s_a_val[180] = "N/A";
                                    s_a_val[181] = "N/A";
                                    s_a_val[182] = "N/A";
                                    s_a_val[183] = "N/A";
                                    s_a_val[184] = "N/A";
                                    s_a_val[185] = "N/A";
                                    s_a_val[186] = "N/A";
                                    s_a_val[187] = "N/A";
                                    s_a_val[188] = "N/A";
                                    s_a_val[189] = "N/A";
                                    s_a_val[190] = "N/A";
                                    s_a_val[191] = "N/A";
                                    s_a_val[192] = "N/A";
                                    s_a_val[193] = "N/A";
                                    s_a_val[194] = "N/A";
                                    s_a_val[195] = "N/A";
                                    s_a_val[196] = "N/A";
                                    s_a_val[197] = "N/A";
                                    s_a_val[198] = "N/A";
                                    s_a_val[199] = "N/A";
                                    s_a_val[200] = "N/A";
                                    s_a_val[201] = "N/A";
                                    s_a_val[202] = "N/A";
                                    s_a_val[203] = "N/A";
                                    s_a_val[204] = "N/A";
                                    s_a_val[205] = "N/A";
                                    s_a_val[206] = "N/A";
                                    s_a_val[207] = "N/A";
                                    s_a_val[208] = "N/A";
                                    s_a_val[209] = "N/A";
                                    s_a_val[210] = "N/A";
                                    s_a_val[211] = "N/A";
                                    s_a_val[212] = "N/A";
                                    s_a_val[213] = "N/A";
                                    s_a_val[214] = "N/A";
                                    s_a_val[215] = "N/A";
                                    s_a_val[216] = "N/A";
                                    s_a_val[217] = "N/A";
                                    s_a_val[218] = "N/A";
                                    s_a_val[219] = "N/A";
                                    s_a_val[220] = "N/A";
                                    s_a_val[221] = "N/A";
                                    s_a_val[222] = "N/A";
                                    s_a_val[223] = "N/A";
                                    s_a_val[224] = "N/A";
                                    s_a_val[225] = "N/A";
                                    s_a_val[226] = "N/A";
                                    s_a_val[227] = "N/A";
                                    s_a_val[228] = "N/A";
                                    s_a_val[229] = "N/A";
                                    s_a_val[230] = "N/A";
                                    s_a_val[231] = "N/A";
                                    s_a_val[232] = "N/A";
                                    s_a_val[233] = "N/A";
                                    s_a_val[234] = "N/A";
                                    s_a_val[235] = "N/A";
                                    s_a_val[236] = "N/A";
                                    s_a_val[237] = "N/A";
                                    s_a_val[238] = "N/A";
                                    s_a_val[239] = "N/A";
                                    s_a_val[240] = "N/A";
                                    s_a_val[241] = "N/A";
                                    s_a_val[242] = "N/A";
                                    s_a_val[243] = "N/A";
                                    s_a_val[244] = "N/A";
                                    s_a_val[245] = "N/A";
                                    s_a_val[246] = "N/A";
                                    s_a_val[247] = "N/A";
                                    s_a_val[248] = "N/A";
                                    s_a_val[249] = "N/A";
                                    s_a_val[250] = "N/A";
                                    s_a_val[251] = "N/A";
                                    s_a_val[252] = "N/A";

                                    function populateStates(countryElementId, stateElementId) {

                                        var selectedCountryIndex = document.getElementById(countryElementId).selectedIndex;


                                        var stateElement = document.getElementById(stateElementId);

                                        stateElement.length = 0; // Fixed by Julian Woods
                                        stateElement.options[0] = new Option('Select State', '');
                                        stateElement.selectedIndex = 0;

                                        var state_arr = s_a[selectedCountryIndex].split("|");
                                        var state_arr_val = s_a_val[selectedCountryIndex].split("|");

                                        if(selectedCountryIndex != 0){
                                          for (var i = 0; i < state_arr.length; i++) {
                                            stateElement.options[stateElement.length] = new Option(state_arr[i], state_arr_val[i]);
                                          }
                                        }

                                    }

                                    function populateCountries(countryElementId, stateElementId) {

                                        var countryElement = document.getElementById(countryElementId);

                                        if (stateElementId) {
                                            countryElement.onchange = function () {
                                                populateStates(countryElementId, stateElementId);
                                            };
                                        }
                                    }

                                                                    </script>

                                                                    <script language="javascript">
                                                populateCountries("country", "state");
                                               // populateCountries("country");
                                            </script>
                                                               <!-- /controls -->
                                                                            <?php }
                                                                            if(array_key_exists('region',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                            <div class="control-group">
                                                                                <label class="control-label" for="mno_state">State/Region<?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="state" placeholder="State or Region" name="mno_state" >
                                                                                    <option value="">Select State</option>
                                                                                        <?php
                                                                                     $get_regions=mysql_query("SELECT
                                                                                      `states_code`,
                                                                                      `description`
                                                                                    FROM
                                                                                    `exp_country_states`");

                                                                                    while($state=mysql_fetch_assoc($get_regions)){
                                                                                        if($edit_state_region==$state['states_code']) {
                                                                                            echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                                        }else{

                                                                                            echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                                        }
                                                                                    }

                                                                                    ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <?php }
                                                                            if(array_key_exists('zip_code',$field_array) || $package_features=="all"){
                                                                                ?>

                                                                             <div class="control-group">
                                                                                <label class="control-label" for="mno_region">ZIP Code<?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input <?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control zip_vali" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $edit_zip; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <script type="text/javascript">

                                                                            $(document).ready(function() {



                                                                                $(".zip_vali").keydown(function (e) {


                                                                                    var mac = $('.zip_vali').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }
                                                                                });


                                                                            });

                                                                            </script>

                                                                            <?php }
                                                                            if(array_key_exists('phone1',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                            <div class="control-group">
                                                                                    <label class="control-label" for="mno_mobile">Phone Number 1<?php if($field_array['phone1']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></sup></label>
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                        <input <?php if($field_array['phone1']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control mobile1_vali" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12"  value="<?php echo $edit_phone1; ?>">
                                                                                    </div>
                                                                                </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('.mobile1_vali').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                                                                                });

                                                                                $('.mobile1_vali').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                     $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                                                                                });

                                                                                $(".mobile1_vali").keydown(function (e) {


                                                                                    var mac = $('.mobile1_vali').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);

                                                                                    if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                                        //console.log(valu);
                                                                                        //$('#phone_num_val').val(valu);

                                                                                    }
                                                                                    else{

                                                                                        if(len == 4){
                                                                                            $('.mobile1_vali').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('.mobile1_vali').val(function() {
                                                                                                return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                                                //console.log('mac2 ' + mac);

                                                                                            });
                                                                                        }
                                                                                    }


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }

                                                                                     $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                                                                                });


                                                                            });

                                                                            </script>

                                                                            <?php }
                                                                            if(array_key_exists('phone2',$field_array) || $package_features=="all"){
                                                                                ?>

                                                                           <div class="control-group">
                                                                                    <label class="control-label" for="mno_mobile">Phone Number 2<?php if($field_array['phone2']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                        <input <?php if($field_array['phone2']=="mandatory"){ ?>required<?php } ?> class="span4 form-control mobile2_vali" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $edit_phone2; ?>">
                                                                                    </div>
                                                                                </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('.mobile2_vali').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                     $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');

                                                                                });

                                                                                $('.mobile2_vali').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                     $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');

                                                                                });

                                                                                $(".mobile2_vali").keydown(function (e) {


                                                                                    var mac = $('.mobile2_vali').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);

                                                                                    if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                                        //console.log(valu);
                                                                                        //$('#phone_num_val').val(valu);

                                                                                    }
                                                                                    else{

                                                                                        if(len == 4){
                                                                                            $('.mobile2_vali').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('.mobile2_vali').val(function() {
                                                                                                return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                                                //console.log('mac2 ' + mac);

                                                                                            });
                                                                                        }
                                                                                    }


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');
                                                                                });


                                                                            });

                                                                            </script>

                                                                            <?php }
                                                                            if(array_key_exists('phone3',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                               <div class="control-group">
                                                                                    <label class="control-label" for="mno_mobile">Phone Number 3<?php if($field_array['phone3']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                        <input <?php if($field_array['phone3']=="mandatory"){ ?>required<?php } ?> class="span4 form-control mobile3_vali" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $edit_phone3; ?>">
                                                                                    </div>
                                                                                </div>

                                                                        <script type="text/javascript">

                                                                            $(document).ready(function() {

                                                                                $('.mobile3_vali').focus(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                                                                                });

                                                                                $('.mobile3_vali').keyup(function(){
                                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                                                                                });

                                                                                $(".mobile3_vali").keydown(function (e) {


                                                                                    var mac = $('.mobile3_vali').val();
                                                                                    var len = mac.length + 1;
                                                                                    //console.log(e.keyCode);
                                                                                    //console.log('len '+ len);

                                                                                    if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                                        //console.log(valu);
                                                                                        //$('#phone_num_val').val(valu);

                                                                                    }
                                                                                    else{

                                                                                        if(len == 4){
                                                                                            $('.mobile3_vali').val(function() {
                                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                                //console.log('mac1 ' + mac);

                                                                                            });
                                                                                        }
                                                                                        else if(len == 8 ){
                                                                                            $('.mobile3_vali').val(function() {
                                                                                                return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                                                //console.log('mac2 ' + mac);

                                                                                            });
                                                                                        }
                                                                                    }


                                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();

                                                                                    }
                                                                                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                                                                                });


                                                                            });

                                                                            </script>

                                                                            <?php }
                                                                            if(array_key_exists('time_zone',$field_array) || $package_features=="all"){
                                                                                ?>
                                                                                     <div class="control-group">
                                                                                         <label class="control-label" for="mno_timezone">Time Zone <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                         <div class="controls col-lg-5 form-group">
                                                                                             <select <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_time_zone" name="mno_time_zone" >
                                                                                                 <option value="">Select Time Zone</option>
                                                                                                 <?php

                                                                                                 $utc = new DateTimeZone('UTC');
                                                                                                 $dt = new DateTime('now', $utc);


                                                                                                 foreach(DateTimeZone::listIdentifiers() as $tz) {
                                                                                                     $current_tz = new DateTimeZone($tz);
                                                                                                     $offset =  $current_tz->getOffset($dt);
                                                                                                     $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                                                     $abbr = $transition[0]['abbr'];
                                                                                                     if($edit_timezone==$tz){
                                                                                                         $select="selected";
                                                                                                     }
                                                                                                     echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. formatOffset($offset). ']</option>';
                                                                                                        $select="";
                                                                                                 }

                                                                                                 ?>
                                                                                             </select>
                                                                                         </div>
                                                                                     </div>

                                                                         <?php }

                                                                    if(array_key_exists('network_config',$field_array)){

                                                                    ?>
                                                                            <h3>Assign Network</h3>
                                                                            <br>




                                    <?php
                                    //echo $_SESSION['s_token'].'***********';
                                    //print_r($access_modules_list);
                                    if(!in_array('support', $access_modules_list)){
                                    ?>

                                                                            <div class="control-group">
                                                                                <label class="control-label" for="conroller">Controller<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <select onchange="updatevariable(this.value); selwags(this.value);gotoNode(this.value);" name="conroller" id="conroller"  class="span4 form-control con_c" required>
                                                                                        <option value="">Select Controller</option>
                                                                                       <?php
                                                                                                    $q1 = "SELECT mno_id,ap_controller
                                                                                                                FROM exp_mno_ap_controller WHERE mno_id='$user_distributor'";

                                                                                                    $query_results=mysql_query($q1);
                                                                                                    while($row=mysql_fetch_array($query_results)){

                                                                                                        //$mnoid=$row[mno_id];
                                                                                                        $apc=$row[ap_controller];

                                                                                                        $ap_controller = preg_replace('/\s+/', '', $apc);
                                                                                                        if($edit_distributor_ap_controller==$apc){
                                                                                                            $controller_sel='selected';
                                                                                                        }else{
                                                                                                            $controller_sel='';
                                                                                                        }

                                                                                                        echo "<option   ".$controller_sel."  class='".$ap_controller."' value='".$apc."'>".$apc."</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                    </select>

                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->



                                                                            <script type="text/javascript">
                                        var value = "test";
                                        function updatevariable(data) {
                                            value = data;
                                            scrt_var = data;

                                            $("#zone").select2();

                                        }

                                        $(document).ready(function() {


                                            var conceptName = $( "#conroller" ).val()
                                            updatevariable(conceptName);


                                        });







                                        function gotoNode(scrt_var){


                                            var a = scrt_var.length;

                                                if(a==0){

                                                    alert('Please Select Controller before Refresh!');

                                                }else{
                                                    document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                    //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                                 $.ajax({
                                                    type: 'POST',
                                                    url: 'ajax/get_zones.php',
                                                    data: { wag_ap_name: "<?php echo $wag_ap_name; ?>", ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,mno:"<?php echo $user_distributor; ?>",mvno:"<?php echo $edit_distributor_code; ?>" },
                                                    success: function(data) {

                                         /* alert(data); */
                                                        $('#zone').empty();

                                                        $("#zone").append(data);


                                                        document.getElementById("zones_loader").innerHTML = "";

                                                    },
                                                     error: function(){
                                                         document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                     }

                                                });



                                                    }

                                            }
                                     </script>



                                     <script src="js/select2-3.5.2/select2.min.js"></script>
                                    <link rel="stylesheet" href="js/select2-3.5.2/select2.css" />
                                    <link rel="stylesheet" href="css/select2-bootstrap/select2-bootstrap.css" />
                                    <script type="text/javascript">
                                    $(document).ready(function() {
                                      $("#zone").select2();
                                    });
                                    </script>


                                                                        <div class="control-group" style="margin-bottom: 3px !important;">
                                                                            <label class="control-label" for="zone">Zones<sup><font color="#FF0000"></font></sup></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <select  name="zone" id="zone"  class="span4 form-control zone_c" >
                                                                                    <option value="">Select Zone</option>
                                                                                    <?php
                                                                                    $q1 = "SELECT t1. zname AS name, t1.zid AS zoneid , t1.controller AS ap_controller,t1.`bzname` FROM
                                                                                                            (SELECT IFNULL(bz.name,'1') AS bzname, z.`name` AS zname, z.zoneid AS zid, z.ap_controller AS controller, IFNULL(d.`distributor_code`,'1') AS ok
                                                                                                            FROM `exp_mno_ap_controller` c,
                                                                                                            exp_distributor_zones z LEFT JOIN  `exp_mno_distributor` d ON z.`zoneid`=d.`zone_id`
                                                                                                            LEFT JOIN `exp_distributor_block_zones` bz ON bz.`name`=z.`name`
                                                                                                            WHERE z.`ap_controller` = c.`ap_controller`
                                                                                                            AND c.`mno_id` = '$user_distributor') t1
                                                                                                            WHERE t1.bzname='1' AND t1.ok";//='1'";
                                                                                    if(isset($edit_distributor_zone_id)){
                                                                                        $q1.=" IN('1','$edit_distributor_code')";
                                                                                    }else{
                                                                                        $q1.=" ='1'";
                                                                                    }


                                                                                    $query_results=mysql_query($q1);
                                                                                    while($row=mysql_fetch_array($query_results)){
                                                                                        $zonename = $row[name];
                                                                                        $zoneid=$row[zoneid];
                                                                                        $ap_controller=$row[ap_controller];

                                                                                        $ap_controller = str_replace(' ', '', $ap_controller);

                                                                                        if($edit_distributor_zone_id==$zoneid){
                                                                                            $select="selected";
                                                                                        }else{
                                                                                            $select="";

                                                                                        }

                                                                                        echo "<option ".$select." class='selectors ".$ap_controller."' value='".$zoneid."'>".$zonename."</option>";
                                                                                    }
                                                                                    //echo $q1;
                                                                                    ?>
                                                                                </select>


                                                                                <a style="display: inline-block; padding: 6px 20px !important;margin-bottom: 10px !important;" onclick="gotoNode(''+ scrt_var +'');" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                                                                <div style="display: inline-block" id="zones_loader"></div>

                                                                                <style>
                                                                                    .select2-container{
                                                                                        margin-right: 20px !important;
                                                                                        margin-bottom: 15px !important;
                                                                                    }
                                                                                </style>



                                                                            </div>
                                                                            <!-- /controls -->
                                                                        </div>
                                                                        <!-- /control-group -->



                                         <script>

                                         function selwags(scrt_var){


                                            var a = scrt_var.length;


                                                    // document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";

                                                    //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                                 $.ajax({
                                                     type: 'POST',
                                                     url: 'ajax/refreshGREProfiles.php',
                                                     data: { loc_GRE: "yes", ap_control_var: scrt_var,user: '<?php echo $user_distributor; ?>' },
                                                     success: function(data) {

                                           //alert(data);
                                                        $('#wag_name').empty();

                                                        $("#wag_name").append(data);


                                                        // document.getElementById("zones_loader").innerHTML = "";

                                                     },
                                                      error: function(){
                                                         // document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                      }

                                                 });



                                             }
                                      </script>

                                                                        <div class="control-group" style="margin-bottom: 3px !important;" id="gateway" <?php if($edit_distributor_gateway_type=='ac'){echo 'style="display: none;"';}?> >
                                                                            <label class="control-label" for="zone_name">WAG<sup><font color="#FF0000"></font></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <select required class="span4 form-control" id="wag_name" name="wag_name" style="display: inline-block">
                                                                                   <?php echo'<option value="">Select Option</option>';

                                                                                   if($edit_distributor_wag_profile){

                                                                                    $sel_ap="AND  w.`ap_controller`='$edit_distributor_ap_controller'";

                                                                                   }else{

                                                                                    $sel_ap='';

                                                                                   }

                                                                                    $get_wags_per_controller="SELECT w.`wag_code`,w.`wag_name` FROM `exp_wag_profile` w , `exp_mno_ap_controller` c
                                                                                                                    WHERE w.`ap_controller`=c.`ap_controller` ".$sel_ap." AND c.`mno_id`='$user_distributor' GROUP BY w.`wag_code`";

                                                                                    $get_wags_per_controller_r=mysql_query($get_wags_per_controller);
                                                                                    while($get_wags_per_controller_d=mysql_fetch_assoc($get_wags_per_controller_r)){
                                                                                        if($edit_distributor_wag_profile==$get_wags_per_controller_d[wag_code]){
                                                                                            $wag_select="selected";
                                                                                        }else{
                                                                                            $wag_select='';
                                                                                        }
                                                                                        echo'<option '.$wag_select.' value="'.$get_wags_per_controller_d[wag_code].'">'.$get_wags_per_controller_d[wag_name].'</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select><input type="checkbox" <?php if($edit_distributor_wag_profile_enable=='1' || $edit_distributor_wag_profile_enable=='on' ){echo 'checked'; }?> name="content_filter" class="hide_checkbox" style="display: inline-block;" data-toggle="toggle" >
                                                                            </div>
                                                                            <small>Note: Turn switch to ON to enable content filtering</small>
                                                                        </div>

                                                                        <style>
                                                                                    #wag_name{
                                                                                        margin-right: 20px !important;
                                                                                        margin-bottom: 15px !important;
                                                                                    }

                                                                                    div.toggle{
                                                                                        margin-bottom: 15px !important;
                                                                                    }

                                                                                </style>




                                                                        <div class="control-group"  <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?>  >
                                                                            <label class="control-label" for="zone_name">Unique Property ID<sup><font color="#FF0000"></font></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <input class="span4 form-control" id="zone_name" name="zone_name" type="text" placeholder="Starbucks" value="<?php echo$edit_distributor_property_id;?>">
                                                                            </div>
                                                                        </div>




                                                                        <div class="control-group"  <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?>  >
                                                                            <label class="control-label" for="zone_dec">Description<sup><font color="#FF0000"></font></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <input class="span4 form-control" id="zone_dec" name="zone_dec" type="text" placeholder="Coffeeshop chain" value="<?php echo$edit_distributor_group_description;?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group" <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?>  >
                                                                            <label class="control-label" for="zone_dec">Realm<sup><font color="#FF0000"></font></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <input required  style="display: inline-block" class="span4 form-control" id="realm" name="realm" type="text" placeholder="123456789" onblur="vali_realm(this)" value="<?php echo $edit_distributor_realm;?>" <?php if(array_key_exists('icomms_number',$field_array)){ if($edit_account==1) echo "readonly"; } ?>>
                                                                                <div style="display: inline-block" id="img"></div>
                                                                            </div>
                                                                        </div>

                                                                        <script>

                                                                            $(document).ready(function() {
                                                                                $("#zone_uid_nouse").keydown(function (e) {
                                                                                    // Allow: backspace, delete, tab, escape, enter and .
                                                                                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                                                            // Allow: Ctrl+A, Command+A
                                                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                            // Allow: home, end, left, right, down, up
                                                                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                                        // let it happen, don't do anything
                                                                                        return;
                                                                                    }
                                                                                    // Ensure that it is a number and stop the keypress
                                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                        e.preventDefault();
                                                                                    }
                                                                                });
                                                                            });


                                                                        </script>
                                                                    <?php if($edit_account!=1){   ?>
                                                                        <script>
                                                                            function vali_realm(rlm) {
                                                                                var val = rlm.value;
                                                                                var val = val.trim();



                                                                                if(val!="") {
                                                                                    document.getElementById("img").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                                                    var formData = {realm: val};
                                                                                    $.ajax({
                                                                                        url: "ajax/validateRealm.php",
                                                                                        type: "POST",
                                                                                        data: formData,
                                                                                        success: function (data) {
                                                                                            /*  if:new ok->1
                                                                                             * if:new exist->2 */
                                                                                            /* alert(data);*/

                                                                                            if (data == '1') {
                                                                                                /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                                                                document.getElementById("img").innerHTML ="";

                                                                                            } else if (data == '2') {

                                                                                                document.getElementById("img").innerHTML = "<p style=\"display: inline-block; color:red\">"+val+" - Realm is already exists.</p>";
                                                                                                document.getElementById('realm').value = "";
                                                                                                /* $('#mno_account_name').removeAttr('value'); */
                                                                                                document.getElementById('realm').placeholder = "Please enter new realm";
                                                                                            }
                                                                                        },
                                                                                        error: function (jqXHR, textStatus, errorThrown) {
                                                                                            alert("error");
                                                                                            document.getElementById('realm').value = "";
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }
                                                                        </script>
                                                                    <?php }

                                                                     }
                                                                    else{
                                        ?>
                                                                        <div class="control-group">
                                                                            <label class="control-label" for="conroller">Controller<sup><font color="#FF0000"></font></sup></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <input readonly value="<?php echo $edit_distributor_ap_controller; ?>"  name="conroller" id="conroller"  class="span4 form-control con_c"  required>
                                                                            </div>
                                                                            <!-- /controls -->
                                                                        </div>
                                                                        <!-- /control-group -->

                                                                            <div class="control-group">
                                                                                <label class="control-label" for="zone">Zones<sup><font color="#FF0000"></font></sup></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <input type="text" readonly value="<?php echo $db->getValueAsf("SELECT `name` AS f FROM `exp_distributor_zones` WHERE `zoneid`='$edit_distributor_zone_id'");?>"    class="span4 form-control zone_c" >
                                                                                    <input type="hidden" readonly value="<?php echo $edit_distributor_zone_id;?>"  name="zone" id="zone"  " >
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->





                                                                        <div class="control-group" <?php if($edit_distributor_gateway_type=='ac'){echo 'style="display: none;"';}?> >
                                                                            <label class="control-label" for="zone_name">WAG<sup><font color="#FF0000"></font></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <input readonly type="text"  value="<?php echo $db->getValueAsf("SELECT `wag_name` AS f FROM `exp_wag_profile` WHERE `wag_code`='$edit_distributor_wag_profile'"); ?>" required class="span4 form-control" style="display: inline-block">
                                                                                <input readonly type="hidden"  value="<?php echo $edit_distributor_wag_profile; ?>" id="wag_name" name="wag_name" style="display: inline-block">
                                                                                     <input  type="checkbox" <?php if($edit_distributor_wag_profile_enable=='1'){echo 'checked'; }?> name="content_filter" class="hide_checkbox" style="display: inline-block" data-toggle="toggle" >
                                                                            </div>
                                                                                <small>Note: Turn switch to ON to enable content filtering</small>
                                                                        </div>




                                                                        <div class="control-group" <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?> >
                                                                                    <label class="control-label" for="zone_name">Unique Property ID<sup><font color="#FF0000"></font></label>
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                        <input readonly class="span4 form-control" id="zone_name" name="zone_name" type="text" placeholder="Starbucks" value="<?php echo$edit_distributor_property_id;?>">
                                                                                    </div>
                                                                                </div>




                                                        <div class="control-group" <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?> >
                                                                                    <label class="control-label" for="zone_dec">Description<sup><font color="#FF0000"></font></label>
                                                                                    <div class="controls col-lg-5 form-group">
                                                                                        <input readonly class="span4 form-control" id="zone_dec" name="zone_dec" type="text" placeholder="Coffeeshop chain" value="<?php echo$edit_distributor_group_description;?>">
                                                                                    </div>
                                                                                </div>

                                                                        <div class="control-group"  <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?> >
                                                                            <label class="control-label" for="zone_dec">Realm<sup><font color="#FF0000"></font></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <input required  style="display: inline-block" class="span4 form-control" id="realm" name="realm" type="text" placeholder="123456789"  value="<?php echo $edit_distributor_realm;?>" <?php if(array_key_exists('icomms_number',$field_array)){ if($edit_account==1) echo "readonly"; } ?>>
                                                                            </div>
                                                                        </div>



                                                                        <?php
                                                                    }
                                                                        $get_tunnel_q="SELECT CONCAT('{',GROUP_CONCAT('\"',g.gateway_name,'\":',g.tunnels),'}') AS a FROM exp_gateways g GROUP BY g.is_enable";

                                                                        $get_tunnels=mysql_query($get_tunnel_q);
                                                                        while($tunnels=mysql_fetch_assoc($get_tunnels)){
                                                                            $tunnelsa=$tunnels[a];
                                                                        }



                                                                         }
                                                                    if(array_key_exists('p_QOS',$field_array) || array_key_exists('g_QOS',$field_array) ||  $package_features=="all"){
                                                                    ?>

                                                                        <h3 id="pg_prof">Assign QoS Profiles</h3>

                                                                <br>
                                                                    <?php
                                                                    if(array_key_exists('p_QOS',$field_array) || $package_features=="all"){
                                                                    ?>

                                                                <div class="control-group" id="p_prof2">
                                                                                <label class="control-label" for="AP_contrl">Private QoS Profile<?php if($field_array['p_QOS']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <select <?php if($field_array['p_QOS']=="mandatory"){ ?>required<?php } ?> name="AP_contrl" id="AP_contrl"  class="span4 form-control" >
                                                                                        <option value="">Select Profile</option>
                                                                                       <?php
                                                                                                    $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                                                                                FROM exp_products
                                                                                                                WHERE network_type='private' AND mno_id='$user_distributor'";

                                                                                                    $query_results=mysql_query($q1);
                                                                                                    while($row=mysql_fetch_array($query_results)){
                                                                                                        $dis_code = $row[product_code];
                                                                                                        $dis_id = $row[product_id];
                                                                                                        $dis_name = $row[product_name];
                                                                                                        $dis_QOS = $row[QOS];

                                                                                                        if($edit_distributor_product_id_p==$dis_id) {
                                                                                                            $select = "selected";
                                                                                                        }else{
                                                                                                            $select="";
                                                                                                        }

                                                                                                        echo "<option ".$select." value='".$dis_id."'>".$dis_code."</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                <div class="control-group" id="pd_prof">
                                                                                <label class="control-label" for="AP_contrl">Duration Profile<?php if($field_array['p_QOS']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <select <?php if($field_array['p_QOS']=="mandatory"){ ?>required<?php } ?> name="AP_contrl_time" id="AP_contrl_time"  class="span4 form-control" >
                                                                                        <option value="">Select Profile</option>
                                                                                       <?php
                                                                                                    $q1 = "SELECT id,profile_code,profile_name,duration,profile_type
                                                                                                                FROM exp_products_duration
                                                                                                                WHERE profile_type IN('2','3') AND distributor='$user_distributor'";

                                                                                                    $query_results=mysql_query($q1);
                                                                                                    while($row=mysql_fetch_array($query_results)){
                                                                                                        $dis_id = $row[id];
                                                                                                        echo $dis_code = $row[profile_code];
                                                                                                        $dis_name = $row[profile_name];
                                                                                                        $timegap = $row[duration];
                                                                                                        $gap = "";
                                                                                                        if($timegap != ''){

                                                                                                            $interval = new DateInterval($timegap);

                                                                                                            if($interval->y != 0){
                                                                                                                $gap .= $interval->y.' Years';
                                                                                                            }
                                                                                                            if($interval->m != 0){
                                                                                                                $gap .= $interval->m.' Months';
                                                                                                            }
                                                                                                            if($interval->d != 0){
                                                                                                                $gap .= $interval->d.' Days';
                                                                                                            }
                                                                                                            if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
                                                                                                                $gap .= ' And ';
                                                                                                            }
                                                                                                            if($interval->i != 0){
                                                                                                                $gap .= $interval->i.' Minutes';
                                                                                                            }
                                                                                                            if($interval->h != 0){
                                                                                                                $gap .= $interval->h.' Hours';
                                                                                                            }

                                                                                                        }
                                                                                                        if($edit_distributor_product_id_p_time==$dis_code) {
                                                                                                            $select = "selected";
                                                                                                        }else{
                                                                                                            $select="";
                                                                                                        }

                                                                                                        echo "<option ".$select." value='".$dis_id."'>".$dis_name." (".$gap.")"."</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->

                                                                    <?php }
                                                                    if(array_key_exists('g_QOS',$field_array) || $package_features=="all"){
                                                                        ?>

                                                                <div class="control-group" id="g_prof2">
                                                                                <label class="control-label" for="AP_contrl_guest">Guest QoS Profile<?php if($field_array['g_QOS']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                                <div class="controls col-lg-5 form-group">
                                                                                    <select <?php if($field_array['g_QOS']=="mandatory"){ ?>required<?php } ?> name="AP_contrl_guest" id="AP_contrl_guest"  class="span4 form-control" >
                                                                                        <option value="">Select Guest Profile</option>
                                                                                       <?php
                                                                                        $edit_distributor_product_id_g;
                                                                                                     $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                                                                                FROM exp_products
                                                                                                                WHERE network_type='GUEST' AND mno_id='$user_distributor'";

                                                                                                    $query_results=mysql_query($q1);
                                                                                                    while($row=mysql_fetch_array($query_results)){
                                                                                                        $dis_code = $row[product_code];
                                                                                                        $dis_g_id = $row[product_id];
                                                                                                        $dis_name = $row[product_name];
                                                                                                        $dis_QOS = $row[QOS];

                                                                                                        if($edit_distributor_product_id_g==$dis_g_id) {
                                                                                                            $select = "selected";
                                                                                                        }else{
                                                                                                            $select="";
                                                                                                        }

                                                                                                        echo "<option ".$select." value='".$dis_g_id."'>".$dis_code."</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                    </select>
                                                                                </div>
                                                                                <!-- /controls -->
                                                                            </div>
                                                                            <!-- /control-group -->


                                                                        <div class="control-group" id="gd_prof">
                                                                            <label class="control-label" for="AP_contrl">Duration Profile<?php if($field_array['p_QOS']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <select <?php if($field_array['p_QOS']=="mandatory"){ ?>required<?php } ?> name="AP_contrl_guest_time" id="AP_contrl_guest_time"  class="span4 form-control" >
                                                                                    <option value="">Select Profile</option>
                                                                                    <?php
                                                                                    $q1 = "SELECT id,profile_code,profile_name,duration,profile_type
                                                                                                                FROM exp_products_duration
                                                                                                                WHERE profile_type IN('1','3') AND distributor='$user_distributor'";

                                                                                    $query_results=mysql_query($q1);
                                                                                    while($row=mysql_fetch_array($query_results)){
                                                                                        $dis_id = $row[id];
                                                                                        $dis_code = $row[profile_code];
                                                                                        $dis_name = $row[profile_name];
                                                                                        $timegap = $row[duration];
                                                                                        $gap = "";
                                                                                        if($timegap != ''){

                                                                                            $interval = new DateInterval($timegap);

                                                                                            if($interval->y != 0){
                                                                                                $gap .= $interval->y.' Years ';
                                                                                            }
                                                                                            if($interval->m != 0){
                                                                                                $gap .= $interval->m.' Months ';
                                                                                            }
                                                                                            if($interval->d != 0){
                                                                                                $gap .= $interval->d.' Days ';
                                                                                            }
                                                                                            if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
                                                                                                $gap .= ' And ';
                                                                                            }
                                                                                            if($interval->h != 0){
                                                                                                $gap .= $interval->h.' Hours ';
                                                                                            }
                                                                                            if($interval->i != 0){
                                                                                                $gap .= $interval->i.' Minutes';
                                                                                            }


                                                                                        }
                                                                                        if($edit_distributor_product_id_g_time==$dis_code) {
                                                                                            if($edit_distributor_product_id_g_time_default!=$timegap){
                                                                                                $res=mysql_query("SELECT id,profile_name FROM exp_products_duration
                                                                                                            WHERE duration='$edit_distributor_product_id_g_time_default' AND distributor='$user_distributor' AND is_default=1");
                                                                                                $resq=mysql_fetch_array($res);
                                                                                                $gapDef = "";
                                                                                                if($edit_distributor_product_id_g_time_default != ''){

                                                                                                    $interval = new DateInterval($edit_distributor_product_id_g_time_default);

                                                                                                    if($interval->y != 0){
                                                                                                        $gapDef .= $interval->y.' Years ';
                                                                                                    }
                                                                                                    if($interval->m != 0){
                                                                                                        $gapDef .= $interval->m.' Months ';
                                                                                                    }
                                                                                                    if($interval->d != 0){
                                                                                                        $gapDef .= $interval->d.' Days' ;
                                                                                                    }
                                                                                                    if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
                                                                                                        $gapDef .= ' And ';
                                                                                                    }
                                                                                                    if($interval->h != 0){
                                                                                                        $gapDef .= $interval->h.' Hours ';
                                                                                                    }
                                                                                                    if($interval->i != 0){
                                                                                                        $gapDef .= $interval->i.' Minutes';
                                                                                                    }


                                                                                                }
                                                                                                echo "<option selected value='".$resq['id']."'>".$resq['profile_name']." (".$gapDef.")"."</option>";
                                                                                            }else{
                                                                                                $select = "selected";
                                                                                            }
                                                                                        }else{
                                                                                            $select="";
                                                                                        }



                                                                                        echo "<option ".$select." value='".$dis_id."'>".$dis_name." (".$gap.")"."</option>";
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <!-- /controls -->
                                                                        </div>
                                                                        <!-- /control-group -->

                                                                    <?php }} ?>

                                                                    <div class="form-actions">

                                                                        <?php if($edit_account=='1')$btn_name='Update Location & Save';else $btn_name='Add Location & Save';

                                                                            if($create_location_btn_action=='create_location_next' || $create_location_btn_action=='add_location_next'  || $_POST['p_update_button_action']=='add_location' || $edit_account=='1'){
                                                                                echo '<button onmouseover="btn_action_change(\'add_location_submit\');" disabled type="submit" name="add_location_submit" id="add_location_submit" class="btn btn-primary">'.$btn_name.'</button><strong><font color="#FF0000"></font> </strong>';
                                                                                $location_count = $db->getValueAsf("SELECT count(id) as f FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'");
                                                                                if($location_count<1000  && !isset($_GET['edit_loc_id']) && !isset($_POST['p_update_button_action']) ){
                                                                                    echo '<button onmouseover="btn_action_change(\'add_location_next\');"  disabled type="submit" name="add_location_next" id="add_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';
                                                                                }

                                                                            }else{


                                                                                echo '<button onmouseover="btn_action_change(\'create_location_submit\');"  disabled type="submit" name="create_location_submit" id="create_location_submit"
                                                                        class="btn btn-primary">Create Account & Save</button><strong><font color="#FF0000"></font> </strong>';

                                                                                echo '<button onmouseover="btn_action_change(\'create_location_next\');"  disabled type="submit" name="create_location_next" id="create_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';

                                                                            }


                                                                            if($edit_account=='1' || $_POST['p_update_button_action']=='add_location' || $_POST['btn_action']=='add_location_next'){?>
                                                                            <a href="?token7=<?php echo $secret;?>&t=12&edit_parent_id=<?php echo $edit_parent_id  ;?>" style="text-decoration:none;" class="btn btn-info inline-btn" >Cancel</a>
                                                                        <?php } ?>


                                                                            <input type="hidden" name="edit_account" value="<?php echo $edit_account; ?>" />
                                                                            <input type="hidden" name="edit_distributor_code" value="<?php echo $edit_distributor_code; ?>" />
                                                                            <input type="hidden" name="edit_distributor_id" value="<?php echo $edit_loc_id; ?>" />
                                                                            <input type="hidden" name="btn_action"  id = "btn_action" value="" />
                                                                            <input type="hidden" name="add_new_location"  value="<?php echo  $_POST['p_update_button_action']=='add_location'?'1':'0' ?>" />
                                                                        <script type="text/javascript">
                                                                            function btn_action_change(action) {
                                                                                $('#btn_action').val(action);
                                                                            }

                                                                            $(document).ready(function() {
                                                                                $(window).keydown(function(event){
                                                                                    if(event.keyCode == 13) {
                                                                                        event.preventDefault();
                                                                                        return false;
                                                                                    }
                                                                                });
                                                                            });
                                                                        </script>

                                                                    </div>

                                                                    </div>

                                                        <!-- /form-actions -->
                                                        </fieldset>
                                                    </form>

                                    <script type="text/javascript">

                                    function location_formfn() {

                                        //document.getElementById("create_location_submit").disabled = false;

                                    }

                                    </script>


                                    <?php if(isset($_GET['create_location_next']) || isset($_GET['add_location_next']) ) {

                                        $props_q = "SELECT id,distributor_code,verification_number,property_id FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'";
                                        $props_r = mysql_query($props_q);

                                        ?>
                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Account Locations</h3>

                                                </div>

                                                <!-- /widget-header -->

                                                <div class="widget-content table_response">

                                                    <div style="overflow-x:auto">

                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Business ID</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Customer Account#</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Property ID</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">APS</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Remove</th>

                                                            </tr>

                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            while($props_row =  mysql_fetch_assoc($props_r)){
                                                                $cus_ac_num = $props_row['verification_number'];
                                                                $cus_prop_id =  $props_row['property_id'];
                                                                $cus_id = $props_row['id'];
                                                                $cus_code = $props_row['distributor_code'];

                                                                echo '<tr>';
                                                                    echo '<td>';
                                                                        echo $edit_parent_id;
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo $cus_ac_num;
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo $cus_prop_id;
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo 'view';
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo 'edit';
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                        echo 'remove';
                                                                    echo '</td>';
                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php } ?>
                                        </div>

                                            <!-- ******************************************************* -->
                                        <div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp">

	                               <div id="response_d1">

										</div>

                                          <?php if(isset($_GET['view_loc_code'])){ //v1

												///Show account mac details///////
                                                $view_loc_code=$_GET['view_loc_code'];
												$view_loc_name=$_GET['view_loc_name'];

												?>



                                        <div id="response_d1">

                                        </div>



                                                <div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<h3>View Account</h3>


                                                    
                                                    
											</div>


										
												<!-- /widget-header -->

												<div class="widget-content table_response">
                                                
                                                <div style="overflow-x:auto">
                                                
                                                
                                                
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Business ID</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Customer Account#</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Serial</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Model</th>
                                                            <?php // echo$package_functions->getSectionType('AP_ACTIONS',$system_package);
                                                            if($package_functions->getSectionType('AP_ACTIONS',$system_package)=='1' || $system_package=='N/A') {   ?>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Actions</th>
                                                                <?php } ?>

															</tr>

														</thead>
														<tbody>
															<?php


															/*echo	$key_query="SELECT  l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`
                                                                            FROM `exp_locations_ap` l INNER JOIN `exp_mno_distributor_aps` d
                                                                            ON d.`ap_code`= l.`ap_code`
                                                                            AND d.`distributor_code`='$view_loc_code' GROUP BY d.`ap_code`";*/
                                                           /* $key_query=  "SELECT l.serial,l.model, l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`,a.`distributor_name`,a.`verification_number`
                                                                            FROM `exp_locations_ap` l INNER JOIN `exp_mno_distributor_aps` d ON d.`ap_code`= l.`ap_code`, `exp_mno_distributor` a
                                                                            WHERE d.`distributor_code`='$view_loc_code' AND a.`distributor_code`=d.`distributor_code` GROUP BY d.`ap_code`"; */

                                                           $key_query = "SELECT l.serial,l.model, l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`,a.`distributor_name`,a.`verification_number`
                                                                        FROM `exp_mno_distributor` a LEFT JOIN `exp_mno_distributor_aps` d  ON a.`distributor_code`=d.`distributor_code` LEFT JOIN `exp_locations_ap` l ON d.`ap_code`= l.`ap_code`
                                                                        WHERE a.parent_id='$view_loc_code' GROUP BY d.`ap_code`,a.verification_number";

																$query_results=mysql_query($key_query);

																while($row=mysql_fetch_array($query_results)){

																	$cpe_id = $row[id];
																	$cpe_name = $row[ap_code];
																	$ip = $row[distributor_name];
																	
																	if(empty($row[verification_number])){
																		$icoms="N/A";
																		}else{
																	$icoms = $row[verification_number];
																	}
																	
																	if(empty( $row[mac_address])){
																		$mac_address="N/A";
																		}else{
																	$mac_address = $row[mac_address];
																	}
																	
																	if(empty($row[create_date])){
																		$created_date="N/A";
																		}else{
																	$created_date = $row[create_date];
																	}
																	
																	if(empty($row[serial])){
																		$serial="N/A";
																		}else{
																	$serial = $row[serial];
																	}
																	
																	if(empty($row[model])){
																		$model="N/A";
																		}else{
																	$model = $row[model];
																	}
																	
																	
																	



																	echo '<tr>
																	<td> '.$view_loc_code.' </td>
																	<td> '.$icoms.' </td>
																	<td> '.$mac_address.' </td>
																	<td> '.$serial.' </td>

																	<td> '.$model.' </td>';
							                                    if($package_functions->getSectionType('AP_ACTIONS',$system_package)=='1' || $system_package=='N/A') {
                                                                    echo '<td>';
                                                                //print_r($action_event=(array)json_decode($package_functions->getOptions('AP_ACTIONS',$system_package)));
                                                                $action_event=(array)json_decode($package_functions->getOptions('AP_ACTIONS',$system_package));

                                                                if(in_array('edit',$action_event) || $system_package=='N/A') {
                                                                    echo '<a href="javascript:void();" id="EDITAP_' . $cpe_id . '"  class="btn btn-small btn-info">

														<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

													$(document).ready(function() {
													$(\'#EDITAP_' . $cpe_id . '\').easyconfirm({locale: {
															title: \'CPE Edit\',
															text: \'Are you sure,you want to edit this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
															button: [\'Cancel\',\' Confirm\'],
															closeText: \'close\'
														     }});

														$(\'#EDITAP_' . $cpe_id . '\').click(function() {
															window.location = "?token7=' . $secret . '&t=2&edit_ap_id=' . $cpe_id . '&edit_loc_code=' . $view_loc_code . '&edit_loc_name=' . $view_loc_name . '"

														});

														});

													</script>&nbsp;&nbsp;';
                                                                }
                                                                if(in_array('remove',$action_event)  || $system_package=='N/A') {


                                                                    echo '<a href="javascript:void();" id="REMAP_' . $cpe_id . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

													$(document).ready(function() {
													$(\'#REMAP_' . $cpe_id . '\').easyconfirm({locale: {
															title: \'CPE Remove\',
															text: \'Are you sure,you want to remove this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
															button: [\'Cancel\',\' Confirm\'],
															closeText: \'close\'
														     }});

														$(\'#REMAP_' . $cpe_id . '\').click(function() {
															window.location = "?token7=' . $secret . '&t=1&view_loc_name=' . $view_loc_name . '&remove_ap_name=' . $cpe_name . '&rem_ap_id=' . $cpe_id . '&view_loc_code=' . $view_loc_code . '"

														});

														});

													</script>';
                                                                }

                                                                    echo '</td>';
                                                                }               echo'</tr>';





																}

															?>



														</tbody>

													</table>
                                                    </div>

                                                    <div class="controls col-lg-5 form-group" style="display:inline-block;padding-top:10px;">
                                                        <a href="?view_loc_name=<?php echo$view_loc_name; ?>&view_loc_code=<?php echo $view_loc_code?>&t=1&action=sync_data_tab1&token8=<?php echo $secret; ?>" class="btn btn-primary" style="align: left;"  data-toggle="tooltip" title="Please click on the Refresh button to reload the AP list if the AP information is not properly loaded."><i class="btn-icon-only icon-refresh" ></i>Refresh</a>
                                                        
                                                       <!-- <a href="location.php" style="text-decoration:none;" class="btn btn-info inline-btn" >Back</a>-->
                                                        
                                                    </div>


												<?php
												//////////////////////////////////////////////////
												}else {//v1
												?>

												 <?php

                                                    if(isset($_SESSION['msg_location_update'])){
                                                        echo $_SESSION['msg_location_update'];
                                                        unset($_SESSION['msg_location_update']);

                                                    }

                                                    ?>



                                                <div class="widget widget-table action-table">
                                                    <?php
                                                    $customer_down_key_string = "uni_id_name=Customer Account Number&task=all_distributor_list&mno_id=".$user_distributor;
                                                    $customer_down_key =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string);
                                                    $customer_down_key =  urlencode($customer_down_key);
                                                    ?>
                                                    <a href='ajax/export_customer.php?key=<?php echo $customer_down_key?>' class="btn btn-primary" style="text-decoration:none">
                                                        <i class="btn-icon-only icon-download"></i> Download Business ID List
                                                    </a>
                                                    <br/> <br/>
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<h3>Active</h3>

											</div>

												<!-- /widget-header -->

												<div class="widget-content table_response">
                                                <div style="overflow-x:auto">

													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">
                                                                <?php if(array_key_exists('icomms_number',$field_array)){ ?>
																    Business ID
                                                                <?php }elseif(array_key_exists('uui_number',$field_array)){ ?>
                                                                    UUI#
                                                                <?php } ?>
                                                                </th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Account Name</th>
																<!-- th>Account Type</th> -->
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Properties</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Details</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>

															</tr>

														</thead>
														<tbody>
															<?php



																if($user_type == 'MNO'){

																	$check_column = "d.mno_id";
																}

																else{
																	 $check_column = "d.distributor_code";

																}

																/* $key_query="SELECT DISTINCT  d.`gateway_type`,d.id AS dis_id,d.`distributor_code`,d.`distributor_name`,d.`distributor_type` ,d.`state_region` ,d.`mno_id`,d.`country`,u.`verification_number`
                                                                                FROM `exp_mno_country` c ,`exp_mno_distributor` d
                                                                                LEFT JOIN admin_users u ON d.`distributor_code`=u.`user_distributor`
                                                                                WHERE d.mno_id = '$user_distributor'
                                                                                AND u.is_enable <>'2' AND u.access_role='admin' ORDER BY u.`verification_number` ASC";  */

																$key_query = "SELECT p.id ,p.parent_id,count(distributor_code) as properties, u.full_name,p.account_name FROM exp_mno m JOIN mno_distributor_parent p ON m.mno_id = p.mno_id LEFT JOIN exp_mno_distributor d ON p.parent_id = d.parent_id LEFT JOIN admin_users u ON p.parent_id = u.verification_number 
                WHERE m.mno_id='$user_distributor' AND u.is_enable <>'2' GROUP BY p.parent_id";


																$query_results=mysql_query($key_query);

																while($row=mysql_fetch_array($query_results)) {
																    /*

                                                                    $distributor_code = $row[distributor_code];
                                                                    $distributor_name = $row[distributor_name];
                                                                    $distributor_type = $row[distributor_type];
                                                                    $country_name = $row[country];
                                                                    $state_region = $row[state_region];
                                                                    $distributor_id_number = $row[dis_id];
                                                                    $gatewtyp= $row[gateway_type];

                                                                    $icomm=$row[verification_number];;
                                                                    $distributor_name_display=str_replace("'","\'",$distributor_name);

																    */

																    $parent_id = $row['parent_id'];
																    $parent_tbl_id = $row['id'];
																    $parent_full_name = $row['full_name'];
																    $parent_ac_name = str_replace("\\",'',$row['account_name']);
																    $parent_properties = $row['properties'];
                                                                    echo '<tr>
																	<td> ' . $parent_id . ' </td>
																	<td> ' . $parent_ac_name . ' </td>';

															//	echo '<td> ' . $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'") . ' </td>';
                                                                echo '<td> ' . $parent_properties . ' </td>';


                                            if($user_type!="MVNE"){
                                                                    echo '<td><a href="javascript:void();" id="VIEWACC_' . $parent_tbl_id . '"  class="btn btn-small btn-primary">

														<i class="btn-icon-only icon-info-sign"></i>&nbsp;View</a><script type="text/javascript">

													$(document).ready(function() {
														
									

														$(\'#VIEWACC_' . $parent_tbl_id . '\').click(function() {
															window.location = "?token8=' . $secret . '&t=1&view_loc_code=' . $parent_id . '&view_loc_name=' . $parent_full_name . '"

														});

														});

													</script></td>';
                                                                }
							echo '<td><a href="javascript:void();" id="EDITACC_'.$parent_tbl_id.'"  class="btn btn-small btn-info">

														<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

													$(document).ready(function() {
													$(\'#EDITACC_'.$parent_tbl_id.'\').easyconfirm({locale: {
															title: \'Account Edit\',
															text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
															button: [\'Cancel\',\' Confirm\'],
															closeText: \'close\'
														     }});

														$(\'#EDITACC_'.$parent_tbl_id.'\').click(function() {
															window.location = "?token7='.$secret.'&t=12&edit_parent_id='.$parent_id.'"

														});

														});

													</script></td>';








		                    echo '<td><a href="javascript:void();" id="REMACC_'.$parent_tbl_id.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

													$(document).ready(function() {
													$(\'#REMACC_'.$parent_tbl_id.'\').easyconfirm({locale: {
															title: \'Account Remove\',
															text: \'Are you sure you want to remove this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
															button: [\'Cancel\',\' Confirm\'],
															closeText: \'close\'
														     }});

														$(\'#REMACC_'.$parent_tbl_id.'\').click(function() {
															window.location = "?token5='.$secret.'&t=1&remove_par_code='.$parent_id.'&remove_par_id='.$parent_tbl_id.'"

														});

														});

													</script></td>';

													echo '</tr>';





																}

															?>











														</tbody>

													</table>
                                                    </div>
                                                   <?php } //v1 ?>







												</div>

												<!-- /widget-content -->

					</div>

											<!-- /widget -->
	</div>

			<!-- ******************************************************* -->
										<!-- <div class="tab-pane" id="active_mno" -->
		<div <?php if(isset($tab8)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="active_mno">


											<div id="response_d1">



											</div>
											<div class="widget widget-table action-table">

												<div class="widget-header">

													<!-- <i class="icon-th-list"></i> -->

													<h3>Active <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></h3>

												</div>

												<!-- /widget-header -->

												<div class="widget-content table_response">
                                                    <div style="overflow-x:auto">

													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

														<thead>

															<tr>

																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></th>

															<!-- 	<th><?php //echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?> Code</th>

																<th>Full Name</th>

																<th>Email</th> -->

																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Controller</th>

																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Edit</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Remove</th>



															</tr>

														</thead>

														<tbody>



															<?php



																$key_query = "SELECT m.mno_description,m.mno_id,u.full_name, u.email , u.verification_number
FROM exp_mno m, admin_users u
WHERE u.user_type = 'MNO' AND u.user_distributor = m.mno_id AND u.`is_enable`=1 AND u.`access_role`='admin'
GROUP BY m.mno_id
ORDER BY mno_description ";

																$query_results=mysql_query($key_query);

																while($row=mysql_fetch_array($query_results)){

																	$mno_description = $row[mno_description];
																	$mno_id = $row[mno_id];
																	$full_name = $row[full_name];
																	$email = $row[email];
																	$s= $row[s];
																	$is_enable= $row[is_enable];
																	$icomm_num=$row[verification_number];


																$key_query01 = "SELECT ap_controller
																			FROM exp_mno_ap_controller
																			WHERE mno_id='$mno_id'";

																$query_results01=mysql_query($key_query01);

																$ap_c="";

																while($row1=mysql_fetch_array($query_results01)){

																	$apc=$row1[ap_controller];

																	$ap_c.=$apc.',';


																}



																	echo '<tr>

																	<td> '.$mno_description.' </td>
																	<td> '.trim($ap_c, ",").' </td>	';



    															//echo '<td> '.$mno_id.' </td><td> '.$full_name.' </td><td> '.$email.' </td>';


													echo '<td> '.

                                                                        //******************************** Edit ************************************
                                                            '<a href="javascript:void();" id="EDITMNOACC_'.$mno_id.'"  class="btn btn-small btn-info">

														<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

													$(document).ready(function() {
													$(\'#EDITMNOACC_'.$mno_id.'\').easyconfirm({locale: {
															title: \'Account Edit\',
															text: \'Are you sure you want to edit this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
															button: [\'Cancel\',\' Confirm\'],
															closeText: \'close\'
														     }});

														$(\'#EDITMNOACC_'.$mno_id.'\').click(function() {
															window.location = "?token10='.$secret.'&t=6&edit_mno_id='.$mno_id.'"

														});

														});

													</script></td>';







												$distributor_exi = "SELECT * FROM `exp_mno_distributor` WHERE mno_id = '$mno_id'";

												$query_results01=mysql_query($distributor_exi);
												$count_records_exi = mysql_num_rows($query_results01);


												if($count_records_exi == 0){

                                                 //*********************************** Remove  *****************************************
                                                 echo '<td><a href="javascript:void();" id="REMMNOACC_'.$mno_id.'"  class="btn btn-small btn-danger">

                                                 <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                                        $(document).ready(function() {
                                                                        $(\'#REMMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                                                title: \'Account Remove\',
                                                                                text: \'Are you sure you want to remove this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});

                                                                            $(\'#REMMNOACC_'.$mno_id.'\').click(function() {
                                                                                window.location = "?token10='.$secret.'&t=8&remove_mno_id='.$mno_id.'"

                                                     });
                                                    });
                                                   </script>';


												}else{

													echo '<td><a class="btn btn-small btn-warning" disabled >&nbsp;<i class="icon icon-lock"></i>Remove</a></center>';
												}


                                                                    //****************************************************************************************


                                                 					echo ' </td>';
																	echo '</tr>';



																}

															?>



														</tbody>
													</table>
												</div>
                                                </div>
												<!-- /widget-content -->
											</div>
											<!-- /widget -->
        </div>
<!--***********************************************************************************-->

<!--***************************************** Activate Accounts ******************************************-->


                                        <div <?php if(isset($tab11)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="saved_mno">


                        <p>To send an automatic email invitation to the Operations Manager, click on "Email" link.This email contains the Operations Admin account activation information.</p>
                        <div class="widget widget-table action-table">

                        <div class="widget-header">

                       <!--  <i class="icon-th-list"></i> -->

                        <h3>Saved <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></h3>

                        </div>

                        <!-- /widget-header -->

                        <div class="widget-content table_response">
                            <div style="overflow-x:auto">

                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                        <thead>

                        <tr>

                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");?></th>



                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">CONTROLLER</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">ADMIN</th>

                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Email</th>

                        
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Remove</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Edit</th>

                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">SEND</th>
                        



                        </tr>

                        </thead>

                        <tbody>



                        <?php



                        $key_query = "SELECT group_concat(DISTINCT c.ap_controller ) AS ap_cont, m.mno_description,m.mno_id,u.full_name, u.email,u.is_enable,'In Active' AS s
                        FROM exp_mno m LEFT JOIN `exp_mno_ap_controller` c ON c.mno_id=m.mno_id, admin_users u
                        WHERE u.user_type = 'MNO' AND u.user_distributor = m.mno_id AND u.`access_role`='admin' AND u.`is_enable`=2
                        GROUP BY m.mno_id
                        ORDER BY mno_description";

                        $query_results=mysql_query($key_query);

                        while($row=mysql_fetch_array($query_results)){

                        $mno_description = $row[mno_description];
                        $mno_id = $row[mno_id];
                        $full_name = $row[full_name];
                        $email = $row[email];
                        $s= $row[s];
                        $is_enable= $row[is_enable];
                        $ap_cont= $row[ap_cont];


                        echo '<tr>

                        <td> '.$mno_description.' </td>
                        <td> '.$ap_cont.' </td>

                        <td> '.$full_name.' </td>
                        <td> '.$email.' </td>';

                        echo '<td><a href="javascript:void();" id="REMMNOACC_'.$mno_id.'"  class="btn btn-small btn-primary">

                                                                <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                            $(document).ready(function() {
                                                            $(\'#REMMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                                    title: \'Account Remove\',
                                                                    text: \'Are you sure you want to remove this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});

                                                                $(\'#REMMNOACC_'.$mno_id.'\').click(function() {
                                                                    window.location = "?token10='.$secret.'&t=6&remove_mno_id='.$mno_id.'"

                                                                });

                                                                });

                                                            </script></td>
                        '.
                        //*********************************** Remove  *****************************************

                            '<td><a href="javascript:void();" id="EDITMNOACC2_'.$mno_id.'" class="btn btn-small btn-info">

														<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

													$(document).ready(function() {
													$(\'#EDITMNOACC2_'.$mno_id.'\').easyconfirm({locale: {
															title: \'Account Edit\',
															text: \'Are you sure you want to edit this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
															button: [\'Cancel\',\' Confirm\'],
															closeText: \'close\'
														     }});

														$(\'#EDITMNOACC2_'.$mno_id.'\').click(function() {
															window.location = "?token10='.$secret.'&t=6&edit_mno_id='.$mno_id.'"

														});

														});

													</script></td>'.
                        '<td>
                        <a href="javascript:void();" id="MAIL_'.$mno_id.'"  class="btn btn-danger btn-small">

                                                                <i class="btn-icon-only icon-envelope"></i>&nbsp;Email</a><script type="text/javascript">

                                                            $(document).ready(function() {
                                                            $(\'#MAIL_'.$mno_id.'\').easyconfirm({locale: {
                                                                    title: \'Send Mail\',
                                                                    text: \'Are you sure you want to send mail?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});

                                                                $(\'#MAIL_'.$mno_id.'\').click(function() {
                                                                    window.location = "?t=11&tokenmail='.$secret.'&send_mail_mno_id='.$mno_id.'"

                                                                });

                                                                });

                                                            </script></td>'
                        //****************************************************************************************
                        ;



                        echo '</tr>';



                        }

                        ?>



                        </tbody>
                        </table>
                        </div>
                        </div>
                        <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                        </div>
                                        <?php
                                        ?>

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



<script type="text/javascript" src="js/bootstrapValidator.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
            //create ssid form validation
        $('#ssid_form').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                network_ssid: {
                    validators: {
                        <?php echo $db->validateField('network_ssid'); ?>
                    }
                },
                ssid_description: {
                    validators: {
                        <?php echo $db->validateField('description'); ?>
                    }
                },
                gt_mvnx : {
                    validators: {
                        <?php echo $db->validateField('dropdown'); ?>
                    }
                },
                my_select : {
                    validators: {
                        <?php echo $db->validateField('multi_select'); ?>
                    }
                }
            }
        });

        //assign ssid - ip form validation
        $('#ssid_asign_form').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                asign_ssid: {
                    validators: {
                        <?php echo $db->validateField('dropdown'); ?>
                    }
                },
                grp_tg : {
                    validators: {
                        <?php echo $db->validateField('dropdown'); ?>
                    }
                },
                my_select4 : {
                    validators: {
                        <?php echo $db->validateField('multi_select'); ?>
                    }
                }
            }
        });



        //Update AP(s)
        $('#location_update').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                category_ass_mvnx: {
                    validators: {
                        <?php echo $db->validateField('dropdown'); ?>
                    }
                },
                my_select3 : {
                    validators: {
                        <?php echo $db->validateField('multi_select'); ?>
                    }
                }
            }
        });


        //Create AP(s)
        $('#ap_form').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {

				<?php if($edit_cpe_account !='1'){ ?>
                ap_code: {
                    validators: {
                        <?php echo $db->validateField('ap_code'); ?>
                    }
                },
                mac_address: {
                    validators: {
                        <?php echo $db->validateField('mac_address'); ?>
                    }
                },
				<?php }else { ?>

				mac_address: {
                    validators: {
                        <?php echo $db->validateField('edit_mac_address'); ?>
                    }
                },


				<?php } ?>

                category_ass_mvnx: {
                    validators: {
                        <?php echo $db->validateField('dropdown'); ?>
                    }
                },
                private_upload_cpe: {
                    validators: {
                        <?php echo $db->validateField('internet_speed'); ?>
                    }
                },
                private_download_cpe: {
                    validators: {
                        <?php echo $db->validateField('internet_speed'); ?>
                    }
                },
                private_ip_address: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                private_netmask: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                private_max_users: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                private_dns1: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                private_dns2: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                guest_upload_cpe: {
                    validators: {
                        <?php echo $db->validateField('internet_speed'); ?>
                    }
                },
                guest_download_cpe: {
                    validators: {
                        <?php echo $db->validateField('internet_speed'); ?>
                    }
                },
                guest_ip_address: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                guest_netmask: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                guest_max_users: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                guest_dns1: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                guest_dns2: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                },
                wifi_radio: {
                    validators: {
                        <?php echo $db->validateField('ip_address'); ?>
                    }
                }

            }
        });

        // create mno account
        $('#mno_form').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                mno_account_name: {
                    validators: {
                        <?php echo $db->validateField('name'); ?>
                    }
                },mno_user_type: {
                    validators: {
                        <?php echo $db->validateField('dropdown'); ?>
                    }
                },

                'AP_cont[]': {
                    validators: {
                        <?php echo $db->validateField('list'); ?>
                    }
                }



                ,mno_customer_type: {
                    validators: {
                        <?php echo $db->validateField('dropdown'); ?>
                    }
                },
				mno_first_name: {
                    validators: {
                        <?php echo $db->validateField('person_full_name'); ?>
                    }
                },
				mno_last_name: {
                    validators: {
                        <?php echo $db->validateField('person_full_name'); ?>
                    }
                },
				mno_email: {
                    validators: {
                        <?php echo $db->validateField('email'); ?>
                    }
                },
				mno_address_1: {
                    validators: {
                        <?php echo $db->validateField('text_box'); ?>
                    }
                },
                mno_address_2: {
                    validators: {
                        <?php echo $db->validateField('text_box'); ?>
                    }
                },
                mno_address_3: {
                    validators: {
                        <?php echo $db->validateField('text_box'); ?>
                    }
                },
				mno_state: {
                    validators: {
                        <?php echo $db->validateField('text_box'); ?>
                    }
                },
                mno_country : {
                    validators: {
                        <?php echo $db->validateField('text_box'); ?>
                    }
                },
				mno_mobile_1: {
                    validators: {
                        <?php echo $db->validateField('mobile'); ?>
                    }
                },
                mno_mobile_2: {
                    validators: {
                        <?php echo $db->validateField('mobile_non_req'); ?>
                    }
                },
                mno_mobile_3: {
                    validators: {
                        <?php echo $db->validateField('mobile_non_req'); ?>
                    }
                },
                mno_time_zone: {
                    validators: {
                        <?php echo $db->validateField('dropdown'); ?>
                    }
                },
                mno_zip_code: {
                    validators: {
                        <?php echo $db->validateField('text_box'); ?>
                    }
                }

            }
        });



            //create_location / MVN(X) account
            $('#location_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {

                    <?php if($field_array['parent_id']=="mandatory"){ ?>
                    parent_id: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>,
                            <?php echo $db->validateField('parent_id'); ?>

                        <?php if($edit_account!='1' && !isset($edit_parent_id)){ ?>
                            ,remote: {
                                url: 'ajax/validateIcom.php',
                                // Send { username: 'its value', email: 'its value' } to the back-end
                                data: function(validator, $field, value) {
                                    return {
                                        //email: validator.getFieldElements('email').val()
                                    };
                                },
                                message: '<p>Business ID Account exists</p>',
                                type: 'POST'
                            }
                            <?php } ?>
                        }
                    },
                    <?php } ?>


                parent_package_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },

                    <?php if($field_array['parent_ac_name']=="mandatory"){ ?>
                    parent_ac_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php } ?>
                    <?php if($field_array['icomms_number']=="mandatory"){ ?>
                    icomme: {
                        validators: {
                            <?php echo $db->validateField('icom'); ?>
                        }
                    },
                    <?php } ?>

                    <?php if($field_array['pr_gateway_type']=="mandatory"){ ?>
                    pr_gateway_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php } ?>

                    <?php if($field_array['account_type']=="mandatory"){ ?>
                    customer_type: {
                        validators: {
                            <?php echo $db->validateField('customer_type'); ?>
                        }
                    },
                    <?php } ?>
                    <?php if(array_key_exists('business_type',$field_array)){  if($field_array['business_type']=="mandatory"){ ?>
                    business_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php } } ?>
                    <?php if(array_key_exists('add2',$field_array) || $package_features=="all"){  if($field_array['add2']=="mandatory" || $package_features=="all"){ ?>
                    mno_address_2: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php } } ?>
                    <?php if(array_key_exists('country',$field_array) || $package_features=="all"){  if($field_array['country']=="mandatory" || $package_features=="all"){ ?>
                    mno_country: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php } } ?>
                    <?php if(array_key_exists('zip_code',$field_array) || $package_features=="all"){  if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?>
                    mno_zip_code: {
                        validators: {
                            <?php echo $db->validateField('zip_code'); ?>
                        }
                    },
                    <?php } } ?>
                    <?php if(array_key_exists('time_zone',$field_array) || $package_features=="all"){  if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?>
                    mno_time_zone: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php } } ?>

                    <?php if(array_key_exists('p_QOS',$field_array) || $package_features=="all"){  if($field_array['p_QOS']=="mandatory" || $package_features=="all"){ ?>
                    AP_contrl: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php } } ?>

                    <?php if(array_key_exists('g_QOS',$field_array) || $package_features=="all"){  if($field_array['g_QOS']=="mandatory" || $package_features=="all"){ ?>
                    AP_contrl_guest: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php } } ?>

                    AP_contrl_guest_time: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },AP_contrl_time: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },network_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },conroller: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    wag_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    zone: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    gateway_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    realm: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    user_type: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    location_name1: {
                        validators: {
                            <?php echo $db->validateField('name'); ?>
                        }
                    },
                    category_mvnx: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    }
                    <?php if($mno_form_type == 'advanced_menu'){//advanced_menu?>

                    ,mno_first_name: {
                        validators: {
                            <?php echo $db->validateField('person_full_name'); ?>
                        }
                    },
                    mno_last_name: {
                        validators: {
                            <?php echo $db->validateField('person_full_name'); ?>
                        }
                    },
                    mno_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>
                        }
                    },
                    mno_address_1: {
                        validators: {
                            <?php echo $db->validateField('text_box'); ?>
                        }
                    },
                    mno_state: {
                        validators: {
                            <?php echo $db->validateField('text_box'); ?>
                        }
                    },
                    mno_mobile_1: {
                        validators: {
                            <?php echo $db->validateField('mobile'); ?>
                        }
                    },
                    mno_mobile_2: {
                        validators: {
                            <?php echo $db->validateField('mobile_non_req'); ?>
                        }
                    },
                    mno_mobile_3: {
                        validators: {
                            <?php echo $db->validateField('mobile_non_req'); ?>
                        }
                    },
                    zone_name: {
                        validators: {
                            <?php echo $db->validateField('person_full_name'); ?>
                        }
                    },
                    zone_dec: {
                        validators: {
                            <?php echo $db->validateField('description'); ?>
                        }
                    },
                    zone_uid: {
                        validators: {
                            <?php echo $db->validateField('name'); ?>
                        }
                    },
                    wlan1_name: {
                        validators: {
                            <?php echo $db->validateField('name'); ?>
                        }
                    },
                    wlan1_ssid: {
                        validators: {
                            <?php echo $db->validateField('name'); ?>
                        }
                    },
                    wlan2_name: {
                        validators: {
                            <?php echo $db->validateField('name'); ?>
                        }
                    },
                    wlan2_ssid: {
                        validators: {
                            <?php echo $db->validateField('name'); ?>
                        }
                    },
                    apmac1: {
                        validators: {
                            <?php echo $db->validateField('mac'); ?>
                        }
                    }


                    <?php } else { ?>
                    ,mvnx_full_name: {
                        validators: {
                            <?php echo $db->validateField('person_full_name'); ?>
                        }
                    },
                    mvnx_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>
                        }
                    },
                    mvnx_mobile: {
                        validators: {
                            <?php echo $db->validateField('mobile'); ?>
                        }
                    },
                    mvnx_num_ssid: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    }

                    <?php } ?>
                }
            });

        });
    </script>
            <script>
                $(document).ready(function(){
                    $('#edit_profile_form').bootstrapValidator({
                        framework: 'bootstrap',
                        excluded: ':disabled',
                        feedbackIcons: {
                            valid: 'glyphicon glyphicon-ok',
                            invalid: 'glyphicon glyphicon-remove',
                            validating: 'glyphicon glyphicon-refresh'
                        },
                        fields: {
                            ed_first_name: {
                                validators: {
                                    <?php echo $db->validateField('person_full_name'); ?>
                                }
                            },
                            ed_last_name: {
                                validators: {
                                    <?php echo $db->validateField('person_full_name'); ?>
                                }
                            },
                            ed_ad_email: {
                                validators: {
                                    <?php echo $db->validateField('email'); ?>
                                }
                            },
                            mobile_1: {
                                validators: {
                                    <?php echo $db->validateField('mobile'); ?>
                                }
                            }
                        }
                    });
                });
            </script>
  <script>
      $(document).ready(function() {
      //Update Parents
      $('#parent_form').bootstrapValidator({
          framework: 'bootstrap',
          excluded: ':disabled',
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
              parent_ac_name: {
                  validators: {
                  <?php echo $db->validateField('notEmpty'); ?>,
                  <?php echo $db->validateField('parent_id'); ?>
              }
          },parent_ac_name: {
              validators: {
                  <?php echo $db->validateField('notEmpty'); ?>
              }
          },
          parent_first_name: {
              validators: {
                  <?php echo $db->validateField('notEmpty'); ?>
              }
          },
          parent_last_name : {
              validators: {
                  <?php echo $db->validateField('notEmpty'); ?>
              }
          },
          parent_email : {
              validators: {
                  <?php echo $db->validateField('email'); ?>
                
              }
          },
          change_0 : {
            validators: {
                  <?php echo $db->validateField('parent_email_change'); ?>
            }
          }
      }
      });

       if($('#parent_username_change').is(':checked')){

           $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', true);
        }
        else{
           $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', false)
        }

        $('#submit_p_form').prop('disabled', true);
       

      });

      $('#parent_username_change').click(function(event) {

        if($('#parent_username_change').is(':checked')){

           $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', true);
        }
        else{
           $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', false)
        }
          
        $('#parent_form')
                    .bootstrapValidator('validateField','change_0');
        
      });

       $('#parent_email').keyup(function(event) {

 if($('#parent_username_change').is(':checked')){

           $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', true);
        }
        else{
           $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', false)
        }
          
        $('#parent_form')
                    .bootstrapValidator('validateField','change_0');

       });

  </script>

<script src="js/jquery.multi-select.js" type="text/javascript"></script>

<script type="text/javascript">

    $( document ).ready(function() {

        $('#my_select').multiSelect();
        $('#my_select2').multiSelect();
        $('#my_select3').multiSelect({ cssClass: "template",keepOrder: true  });
        $('#my_select4').multiSelect();
        $('#my_select5').multiSelect();

        $('#AP_cont').multiSelect();

    });


    $(document).on('change', '#AP_cont', function (event) {

            $select = $(event.target),
            val     = $select.val(),/*selected items after event*/

        /* Store the array of selected elements  */
            $select.data('selected', val);

            /* console.log(val); */

        /* convert to json*/
        var wagdata = JSON.stringify(val);

        var formData={loadWAG:true,wags:wagdata};

        /* alert(formData);  */

        $.ajax({
            url : "ajax/loadWAGs.php",
            type: "POST",
            data : formData,
            success: function(data)
            {
                //alert(data);



                $('#mno_wag_profiles').val(data);
                //$('#getGREProfiles_error').html('');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                /*alert(textStatus);*/
                //$('#getGREProfiles_error').html('<font color="red">Network error</font>');
            }
        });

    });

</script>




<?php

include 'footer.php';

?>

<!--Alert message -->
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />

<!-- tool tip css -->
<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />



<!--jquery code for upload browse button-->
<script src="js/jquery.filestyle.js" type="text/javascript" charset="utf-8"></script>



<script type="text/javascript" charset="utf-8">

    $(function() {
        $("input.browse").filestyle({
            image:"img/choosefile.gif",
            imageheight : 30,
            imagewidth : 82,
            width : 100,
            height : 10
        });
    });

</script>


<!-- Alert messages -->
  <?php
  if($mno_edit==1){
      ?>
  <script type="text/javascript">
      $(document).ready(function() {
          $("#submit_mno_form").easyconfirm({locale: {

              title: 'MNO Account',
              text: 'Are you sure you want to edit this MNO Account?',
              button: ['Cancel',' Confirm'],
              closeText: 'close'

          }});

          $("#submit_mno_form").click(function() {
          });
      })
  </script>

  <?php
  }else{?>
      <script type="text/javascript">
          $(document).ready(function() {
              $("#submit_mno_form").easyconfirm({locale: {

                  title: 'Operator Account',
                  text: 'Are you sure you want to create this Operator account?',
                  button: ['Cancel',' Confirm'],
                  closeText: 'close'

              }});

              $("#submit_mno_form").click(function() {
              });
          })
      </script>
  <?php }?>



<script type="text/javascript">
    $(document).ready(function() {



        $("#create_location_submit").easyconfirm({locale: {
            title: 'SMB Account <?php if($edit_account=='1'){ $set_name='edit';  echo 'Edit';}else{ $set_name='create'; echo 'Creation';}?>',
            text: 'Are you sure you want to <?php echo $set_name; ?> this account?',
            button: ['Cancel',' Confirm'],
            closeText: 'close'

        }});

        $("#create_location_submit").click(function() {
        });


        $("#create_location_next").easyconfirm({locale: {
            title: 'SMB Account Creation',
            text: 'Are you sure you want to create this account?',
            button: ['Cancel',' Confirm'],
            closeText: 'close'

        }});

        $("#create_location_next").click(function() {
        });

        <?php if($edit_account!='1'){ ?>
        $("#add_location_submit").easyconfirm({locale: {
            title: 'Add Location',
            text: 'Are you sure you want to add this location and finish account <?php if($_POST['p_update_button_action']=='add_location'){ echo 'update'; }else{echo 'creation';} ?>?',
            button: ['Cancel',' Confirm'],
            closeText: 'close'

        }});
        <?php }else{ ?>
        $("#add_location_submit").easyconfirm({locale: {
            title: 'Update Location',
            text: 'Are you sure you want to update this location?',
            button: ['Cancel',' Confirm'],
            closeText: 'close'

        }});
        <?php } ?>

        $("#add_location_submit").click(function() {
        });

<?php if($edit_account!='1'){ ?>
        $("#add_location_next").easyconfirm({locale: {
            title: 'Add Location',
            text: 'Are you sure you want to add this location?',
            button: ['Cancel',' Confirm'],
            closeText: 'close'

        }});

        $("#add_location_next").click(function() {
        });

<?php } ?>


        $("#submit_assign_user").easyconfirm({locale: {
            title: 'Assign User',
            text: 'Are you sure you want to assign this user?',
            button: ['Cancel',' Confirm'],
            closeText: 'close'

        }});

        $("#submit_assign_user").click(function() {
        });


    });

</script>
<script type="text/javascript" id="easy_confirm">
    $(document).ready(function() {
        /*$("#submit_p_form").easyconfirm({locale: {
            title: 'Update Account',
            text: $("#parent_update_conf_msg").html(),

            button: ['Cancel',' Confirm'],
            closeText: 'close'

        }});*/

        $("#submit_p_form").click(function() {
        });
    });
</script>
            <style>
                #submit_p_form_confirm.parent-update-conf-div-long{
                    margin-left: -300px;
                }

                #submit_p_form_confirm.parent-update-conf-div-small{
                    margin-left: -220px;
                }
                @media (max-width: 520px){
                    #submit_p_form_confirm {
                        left: auto !important;
                        margin: 10px !important;
                    }
                }
            </style>
            <div id="submit_p_form_confirm" class="parent-update-conf-div-small ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" style="height: auto; width: auto; top: 30%; left: 50%; display: none;" tabindex="-1" role="dialog" aria-describedby="ui-id-133" aria-labelledby="ui-id-134">
                <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                    <span  class="ui-dialog-title">Update Account</span>
                    <button id="submit_p_form_confirm_cancel0" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close">
                        <span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
                        <span class="ui-button-text">close</span>
                    </button>
                </div>
                <div id="submit_p_form_confirm_text" class="dialog confirm ui-dialog-content ui-widget-content"  style="display: block; width: auto; min-height: 0px; max-height: 0px; height: auto;">
                </div>
                <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                    <div class="ui-dialog-buttonset">
                        <button id="submit_p_form_confirm_cancel" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                            <span class="ui-button-text">Cancel</span>
                        </button>
                        <button id="submit_p_form_confirm_ok" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                            <span class="ui-button-text"> Confirm</span>
                        </button>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $("#submit_p_form_confirm_cancel").click(function(event) {
                        $('#submit_p_form_confirm').hide();
                        $('.ui-widget-overlay').hide();
                    });
                    $("#submit_p_form_confirm_cancel0").click(function(event) {
                        $('#submit_p_form_confirm').hide();
                        $('.ui-widget-overlay').hide();
                    });
                    $("#submit_p_form_confirm_ok").click(function(event) {
                        $( "#submit_p_form" ).submit();
                    });
                });
            </script>
<script src="js/jquery.chained.js"></script>
<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        $("#product_code").chained("#category");
    });

</script>

<script type="text/javascript" src="js/jquery.form.js"></script>

<script type="text/javascript" >

    $(document).ready(function() {

        $('#photoimg').on('change', function(){
            $("#preview").html('');
            $("#preview").html('<img src="img/loader.gif" alt="Uploading...."/>');
            $("#imageform").ajaxForm({
                target: '#preview'
            }).submit();
        });

    });

</script>

<script type="text/javascript" >

    $(document).ready(function() {

        $('#photoimg1').on('change', function()			{
            $("#preview1").html('');
            $("#preview1").html('<img src="img/loader.gif" alt="Uploading...."/>');
            $("#imageform1").ajaxForm({
                target: '#preview1'
            }).submit();
        });
    });

</script>

<script type="text/javascript" >

    $(document).ready(function() {
        $('#photoimg3').on('change', function()			{
            $("#preview3").html('');
            $("#preview3").html('<img src="img/loader.gif" alt="Uploading...."/>');
            $("#imageform3").ajaxForm({
                target: '#preview3'
            }).submit();
        });
    });
</script>




<script type="text/javascript" >

    $(document).ready(function() {
        $('#photoimg4').on('change', function()			{
            $("#preview4").html('');
            $("#preview4").html('<img src="img/loader.gif" alt="Uploading...."/>');
            $("#imageform4").ajaxForm({
                target: '#preview4'
            }).submit();
        });
    });
</script>


<!-- Uploaded file type check-->

<script type="text/javascript">
    function check_extension(filename) {

        var re = /\..+$/;
        //get file extension
        var ext = filename.match(re);
        var upper_ext=ext.toString().substring(1);
        var y=upper_ext.toUpperCase();
        if (y=="CSV") {
            document.getElementById("upload_cont").disabled = false;
            return true;
        } else {
            alert("Invalid file type, Please Select a valid CSV file");
            document.getElementById("upload_cont").disabled = true;
            return false;
        }
    }
</script>
<script type="text/javascript">
                $(document).ready(function(){

                    var val=$('#network_type').val();
                    var gateway=$('#gateway_type').val();

                    function changeProfileArea(val){
                        switch(val){
                            //AP_contrl_guest_time

                            case 'GUEST':{
                                //$('#pg_prof').html('Assign Guest Profiles');
                                $('#g_prof2').show();

                                $('#gd_prof').show();

                                $('#p_prof2').hide();

                                $('#pd_prof').hide();

                                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                bootstrapValidator.enableFieldValidators('AP_contrl_time', false);
                                bootstrapValidator.enableFieldValidators('AP_contrl', false);
                                bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', true);
                                bootstrapValidator.enableFieldValidators('AP_contrl_guest', true);
                                break;
                            }
                            case 'PRIVATE':{
                                //$('#pg_prof').html('Assign Private Profiles');
                                $('#p_prof2').show();

                                $('#pd_prof').show();

                                $('#g_prof2').hide();

                                $('#gd_prof').hide();
                                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                bootstrapValidator.enableFieldValidators('AP_contrl_time', true);
                                bootstrapValidator.enableFieldValidators('AP_contrl', true);
                                bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', false);
                                bootstrapValidator.enableFieldValidators('AP_contrl_guest', false);
                                break;
                            }
                            case 'BOTH':{
                                //$('#pg_prof').html('Assign Private and Guest Profiles');
                                $('#p_prof2').show();

                                $('#pd_prof').show();

                                $('#g_prof2').show();

                                $('#gd_prof').show();
                                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                bootstrapValidator.enableFieldValidators('AP_contrl_time', true);
                                bootstrapValidator.enableFieldValidators('AP_contrl', true);
                                bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', true);
                                bootstrapValidator.enableFieldValidators('AP_contrl_guest', true);
                                break;
                            }
                        }
                    }
                    
                    function changeGetwayArea(val){
                        switch(val){
                            //AP_contrl_guest_time

                            case 'GUEST':{
                                //$('#pg_prof').html('Assign Guest Profiles');
                                $('#pr_geteway_div').hide();

                                $('#gu_geteway_div').show();

                                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                bootstrapValidator.enableFieldValidators('pr_gateway_type', false);
                                bootstrapValidator.enableFieldValidators('gateway_type', true);
                                
                                break;
                            }
                            case 'PRIVATE':{
                                //$('#pg_prof').html('Assign Private Profiles');
                                $('#pr_geteway_div').show();

                                $('#gu_geteway_div').hide();

                                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                bootstrapValidator.enableFieldValidators('pr_gateway_type', true);
                                bootstrapValidator.enableFieldValidators('gateway_type', false);
                                
                                break;
                            }
                            case 'BOTH':{
                                //$('#pg_prof').html('Assign Private and Guest Profiles');
                                $('#pr_geteway_div').show();

                                $('#gu_geteway_div').show();

                                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                bootstrapValidator.enableFieldValidators('pr_gateway_type', true);
                                bootstrapValidator.enableFieldValidators('gateway_type', true);
                                break;
                            }
                        }
                    }



                    $('#network_type').bind('change',function(){
                        val=$('#network_type').val();
                        changeProfileArea(val);
                        changeGetwayArea(val);
                    });
                    function changeContentFilterArea(gateway){
                        switch(gateway){

                            case 'wag':{
                                $('#wag_name').prop('required',true);
                                $('#gateway').show();
                                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                bootstrapValidator.enableFieldValidators('wag_name', true);
                                break;
                            }
                            case 'ac':{
                                $('#wag_name').prop('required',false);
                                $('#gateway').hide();
                                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                bootstrapValidator.enableFieldValidators('wag_name', false);

                                break;
                            }
                        }

                    }

                    $('#gateway_type').bind('change',function(){
                        gateway=$('#gateway_type').val();
                        changeContentFilterArea(gateway);
                    });

                    changeProfileArea(val);
                    changeGetwayArea(val);

                });
            </script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</body>
</html>
