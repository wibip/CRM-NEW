<style>
@media screen and (max-width: 675px){
  .paas_toogle {
    position: absolute !important;
    margin-top: -21px !important;
    right: 2px !important;
}
}
@media (min-width: 1200px){
.pass_msg {
    width: 347px !important;
}
}
input::-ms-clear, input::-ms-reveal {
    display: none;
}

.pass_msg .help-block{
  display: block !important;
}
</style>

	
<style type="text/css">

	.control-group{
		width: 49%;
		display: inline-block;
		vertical-align: top;
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

	.control-group{
		width: 100%;

	}
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
//echo $user_name;
//echo $mno_id;
// echo $user_distributor;
// echo $distributer_code=$package_functions->getDistributorMONPackage($user_name);
?>

<script type="text/javascript">
$(document).ready(function() {
	
	
	$("#customer_submit").easyconfirm({locale: {
		title: 'New Tenant account',
		text: 'Are you sure you want to create this tenant account?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }});
	$("#customer_submit").click(function() {
	});
	

    
  });
  

  
</script>

<?php


$vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
   $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");


if (strlen($network_profile) > 0) {
    require_once 'src/AAA/' . $network_profile . '/index.php';
    $nf = new network_functions($vt_pro,'');
} else {
    $nf = null;
}



/////FORM SUBMIT/////////////////////////////////////////
if(isset($_POST['customer_submit'])){ //1

	if($_SESSION['FORM_SECRET'] == $_POST['form_secret']){//key validation


		//$vtenante_feature=$package_functions->getSectionType('VTENANT',$package_functions->getAdminPackage());

		$first_name = trim($_POST["first_name"]);
		$last_name = trim($_POST["last_name"]);
		$property_id=$_POST['property_id'];
		
		$qu1 ="SELECT delete_status,append_realm,property_type FROM mdu_organizations WHERE property_number='$property_id'";
		
		$data1 = $db->selectDB($qu1);

if($data1['rowCount']>0){
    $PropertyDeleteStatus = $data1['data'][0]['delete_status'];
    $append_realm = $data1['data'][0]['append_realm'];
    $property_type = $data1['data'][0]['property_type'];
}


	//	$PropertyDeleteStatus=$db->getValueAsf("SELECT delete_status AS f FROM mdu_organizations WHERE property_number='$property_id'");

	  if($PropertyDeleteStatus != 6 ){

/* 		$append_realm=$db->getValueAsf("SELECT append_realm AS f FROM mdu_organizations WHERE property_number='$property_id'");
		$property_type=$db->getValueAsf("SELECT property_type AS f FROM mdu_organizations WHERE property_number='$property_id'");
 */

		$user_email=strtolower($_POST["email"]);
		if($append_realm=='1'){
			$user_name_n = strtolower($_POST["email"]).'@'.$property_id;
		}else{
			$user_name_n = strtolower($_POST["email"]);
		}
		$password = trim($_POST["password"]);
		$passcode_key = trim($_POST["passcode_key"]);

		$room = trim($_POST["room"]);
		$customer_email = strtolower($_POST["email"]);
		$question = $_POST["question"];
		$answer = $_POST["answer"];
		$validity_time=$db->getValueAsf("SELECT validity_time AS f  FROM mdu_organizations 
									  WHERE property_number='$property_id'");

		$comp_name=trim($_POST['comp_name']);
		$street_address=trim($_POST['street_address']);
		$city=trim($_POST['city']);
		$postal_code=trim($_POST['postal_code']);
		$country=$_POST['country'];
		$phone=trim($_POST['phone']);
		$state=trim($_POST['state']);

		if($property_type=='VTENANT'){
			include_once 'classes/VlanID.php';
			$VlanIDOb=new VlanID();
			$vlan_id=$VlanIDOb->getVlanID($property_id);


			$user_date_string = "vlan_id=".$vlan_id."&usermessage=0&address2=".$room."&warning=0&country=".$country."&address=".$street_address."&violation=0&state=".$state."&zip=".$postal_code."&secret_question=".$question."&city=".$city."&secret_answer=".$answer."&company=".$comp_name;
		}else{
			$user_date_string = "usermessage=0&address2=".$room."&warning=0&country=".$country."&address=".$street_address."&violation=0&state=".$state."&zip=".$postal_code."&secret_question=".$question."&city=".$city."&secret_answer=".$answer."&company=".$comp_name;
		}



		if(($property_type=='VTENANT' && isset($vlan_id) && $vlan_id>0 ) || $property_type=='MDU'){
			/////////check customer email duplicate//////

			$customer_full_name=$first_name." ".$last_name;
			$to = $customer_email;
		//	$subject = $db->setVal("short_title","MANAGER").' Email Notification';

			//$from_email_add = strip_tags($db->setVal('FROM_EMAIL', $mdu_distributor_id));

			$mno_package=$package_functions->getDistributorMONPackage($user_name);

          //$MNO=$db->getValueAsf("SELECT mno_id AS f FROM exp_mno WHERE system_package='$mno_package'");
          
          
          $from=strip_tags($db->setVal("email", $mno_id));
          if (empty($from)) {
            $from=strip_tags($db->setVal("email", "ADMIN"));
          }
			//$title=$db->setVal("short_title", "ADMIN") ;
			$email_content = $db->getEmailTemplate('CUSTOMER_MAIL',$mno_package,'MNO',$mno_id);

		//$Full_name=$package_functions->getOptions('EMAIL_NAME',$mno_package);

    

			$a = $email_content[0]['text_details'];

			$subject = $email_content[0]['title'];


			/* 
			$headers = "From: ".$db->setVal("short_title","MANAGER")."<".$from_email_add. ">\r\n";
			$headers .= "Reply-To: ".$from_email_add. "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";

			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; */

			//$act_link=$db->setVal("activation_link","MANAGER");

			$act_link=$db->getValueAsf("SELECT tenant_portal_link AS f FROM mdu_organizations WHERE property_number='$property_id'");

			if($property_type=='VTENANT'){
				$base_link=$db->setVal("mdu_portal_base_url","ADMIN");
				$act_link = $base_link.'/user_checkpoint.php?realm='.$property_id;
			}

			$act_link = str_replace('<GROUPNUMBER>', $property_id, $act_link);

			//exit();

			$link = '<a href="'.$act_link.'">'.$act_link.'</a>';



		/* 	$a = $db->textVal('CUSTOMER_MAIL','MANAGER',$mdu_distributor_id);



			if(strlen($a)<= '0'){
				//if(empty($a)){ 
			   $a = $db->textVal('CUSTOMER_MAIL','MANAGER','TEMPLATE');
			} */




			$vars = array(
				'{$user_full_name}' => $customer_full_name,
				'{$short_name}'        => $title,
				'{$account_type}' => 'MNO',
				'{$user_name}' => $user_email,
				'{$password}' => $password,
				'{$link}' => $link

			);
	//		 $message_full = strtr($a, $vars);
			/*$message = $message_full; */

			$sys_user = $_SESSION['user_namem'];



/////////////////////////////////////////////
///// Product finding ///////////////////////
// MVNE HAS THEN MVNE PRODUCT ELSE GLOBAL PRODUCT

		//	$query_service_profile = "SELECT s.product_id FROM mdu_organizations o JOIN exp_products s ON o.default_prof=s.product_id WHERE property_number='$property_id'";
			
			//$query_service_profile = "SELECT `default_prof` AS product_id FROM `mdu_organizations` WHERE property_number='$property_id'";
			$query_service_profile = "SELECT `product_code`  
										FROM `exp_products_distributor`
										WHERE distributor_code='$user_distributor' AND `network_type` = 'VT-DEFAULT'";

			
			/*$query_service_profile ="SELECT `product_code` AS product_id FROM `mdu_organizations` o JOIN `exp_products` p ON o.default_prof = p.`product_id`  WHERE property_number='$property_id'";
		*/
			
			$query_results_profile=mysql_query($query_service_profile);
			while($row_s=mysql_fetch_array($query_results_profile)){

				$service_profile_product = $row_s['product_code'];
			}
			
////// End Profile Finding //////////////////
//////////////////////////////////////////////



			$query0 = "INSERT INTO `mdu_vetenant` (`email`,`first_name`,`last_name`,username,`password`,`dpsk_key`,room_apt_no,`question_id`,property_id,`answer`,create_date,email_sent,create_user,company_name,address,city,state,postal_code,country,phone,service_profile,registration_from,vlan_id,validity_time)
VALUES('$customer_email','$first_name','$last_name','$user_name_n','$password','$passcode_key','$room', '$question','$property_id','$answer',NOW(),'$email_sent','$sys_user','$comp_name','$street_address','$city','$state','$postal_code','$country','$phone','$service_profile_product','MDU_PORTAL','$vlan_id','$validity_time')";

			//////////////CALL APTILO API and Create Master Account/////////////


			$response = $nf->masterAcc($user_name_n, $password, $property_id,$service_profile_product, $first_name, $last_name, $customer_email, $phone, urlencode($user_date_string),$validity_time,$country,$street_address,$state,$city,$postal_code,$question,$answer,$vlan_id,$passcode_key);

			//print_r($response);
			parse_str($response);

			//$status_code = 200;


			if($status_code == 200 || $status == "success"){
				/*   $emailTemplate=$package_functions->getSectionType("EMAIL_TEMPLATE",$my_product);	
				$emailSystem=$package_functions->getSectionType("EMAIL_SYSTEM",$package_functions->getAdminPackage());
				if(strlen($emailSystem)>0){
					require_once ('src/email/'.$emailSystem.'/index.php');
					$emailSystemOb=new email(array('template'=>$emailTemplate));
					$mail_sent=$emailSystemOb->sendEmail($from_email_add,$to,$subject,$message,'','');
				}else {
					$mail_sent = @mail( $to, $subject, $message, $headers );
				}
 */

$message_full = strtr($a, $vars);
 $message = mysql_escape_string($message_full);

  $qu = "INSERT INTO `admin_invitation_email` (`to`,`subject`,`message`,`distributor`,`user_name`,`password_re`, `create_date`)
	VALUES ('$to', '$subject', '$message', '$mno_id', '$new_user_name','$password', now())";
$rrr = mysql_query($qu);

$rrr1 = mysql_query($qu1);

                $mno_sys_package = $package_functions->getDistributorMONPackage($user_name);

$email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $mno_sys_package);
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

$mail_obj->mno_system_package = $mno_package;

$mail_sent=$mail_obj->sendEmail($from,$to,$subject,$message_full,'',$title);


				//echo $mail_sent ? "Mail sent" : "Mail failed";

				/* if($mail_sent){
					$email_sent=1;

					

					$resend_q = "INSERT INTO `mdu_email_resend` (`to`, `subject`, `headers`, `mail_body`, `send_status`,email_type,property_id, `create_date`, `create_user`)
VALUES ('$to', '$subject', '$headers', '$message', '1','TENANT_RESEND','$property_id', NOW(), '$sys_user')";
					$resend = mysql_query($resend_q);
				


				}else{
					$email_sent=0;


				
					$resend_q = "INSERT INTO `mdu_email_resend` (`to`, `subject`, `headers`, `mail_body`, `send_status`,email_type, `create_date`, `create_user`) 
VALUES ('$to', '$subject', '$headers', '$message', '0', 'FAILED',NOW(),'$sys_user')";
					$resend = mysql_query($resend_q);
				


				} */

				$ex0 = mysql_query($query0);

				$_SESSION['msg'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
<strong>".$message_functions->showMessage('tenant_acc_creat_success','2001')."</strong></div>";

			}
			else{

				if($property_type=='VTENANT'){
					$VlanIDOb->addDeleteVlanID($property_id,$vlan_id);
				}

				$_SESSION['msg'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showNameMessage('tenant_acc_creat_failed',$property_id)."</strong></div>";

			}



		}//mail
		else{


			$_SESSION['msg'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showNameMessage('tenant_acc_creat_no_vlan',$property_id)."</strong></div>";
			//header('Location: ');

		}


	  } //proprty lock
		else{


		  $_SESSION['msg'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('property_lock','2001')."</strong></div>";
		  //header('Location: ');

	  }




	}//key validation
	else{


		$_SESSION['msg'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transaction_failed','2004')."</strong></div>";
		//header('Location: ');

	}


}

?>

<body>

<div class="main">
		<div class="main-inner">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="widget ">
						 
							
							<div class="widget-content" id="now">

								<div class="tabbable">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#create_acc" data-toggle="tab">Add Tenant</a></li>

									</ul>
									<br>

<?php 
if(isset($_SESSION['msg'])){
															   echo $_SESSION['msg'];
															   unset($_SESSION['msg']);
															   
															   }

?>


									<div class="tab-content">


                                            <!-- ******************* create camp ******************* -->
										<div class="tab-pane active" id="create_acc">
										<!-- 	<form id="edit-profile" class="form-horizontal" onsubmit="tableBox('customer'); return false;"> -->

									
											<!-- </form> -->

											



 <h1 class="head">Add Tenant<img data-toggle="tooltip" title="In case a tenant has issues during self-registration, you can assist the tenant by establishing an account. As the tenant logs-on for the first time, he/she can sign in using the temporary password you have assigned. The tenant should also be prompted to change his/her password as soon as they login. The Device Password is used to gain Internet access via the Internet SSID, this password should also be changed by the tenant once they login for the first time." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>




			<form autocomplete="nope" id="customer_form" name="customer_form" action="add_tenant.php" method="post"  class="form-horizontal" enctype="multipart/form-data">

	<?php

$secret=md5(uniqid(rand(), true));
$_SESSION['FORM_SECRET'] = $secret;
				
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
				
?>

	<fieldset>

	
		<div id="response_d1"></div>
	
					

					<div class="control-group">
						
						<div class="controls form-group">
							
							<label class="" for="radiobtns">First Name<span class="required-mark" style="color:#FF0000">*</span></label>

								<input class="span4 form-control" id="first_name" placeholder="Alex" name="first_name" type="text" autocomplete="nope">
								<script type="text/javascript">
									$("#first_name").keypress(function(event){
										var ew = event.which;
										
										if(ew == 8||ew == 0)
											return true;
										//if(48 <= ew && ew <= 57)
//																			return true;
										if(65 <= ew && ew <= 90)
											return true;
										if(97 <= ew && ew <= 122)
											return true;
										return false;
									});
									
									$('#first_name').bind("cut copy paste",function(e) {
											  e.preventDefault();
										   });

								
								</script>
								
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->



					
					
					
					<div class="control-group">
						
						<div class="controls form-group">
							
							<label class="" for="radiobtns">Last Name<span class="required-mark" style="color:#FF0000">*</span></label>

								<input class="span4 form-control" id="last_name" placeholder="John" name="last_name" type="text" autocomplete="nope">
								<script type="text/javascript">
									$("#last_name").keypress(function(event){
										var ew = event.which;
										if(ew == 8||ew == 0)
											return true;
										//if(48 <= ew && ew <= 57)
//																			return true;
										if(65 <= ew && ew <= 90)
											return true;
										if(97 <= ew && ew <= 122)
											return true;
										return false;
									});
									
									$('#last_name').bind("cut copy paste",function(e) {
											  e.preventDefault();
										   });
								</script>
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->
					
					
															

			
					
					
					<div class="control-group">
						
						<div class="controls form-group" style="position: relative;">
							
							<label class="" for="radiobtns">Password<span class="required-mark" style="color:#FF0000">*</span></label>

								<input class="span4 form-control pass_msg" id="password" placeholder="******" name="password" type="password" autocomplete="nope">
								<i toggle="#password" style="display:inline !important;margin-left: -25px; " class="paas_toogle btn-icon-only icon-eye-open toggle-password" id="n_pass"></i>

<script type="text/javascript">
                                         $(".toggle-password").click(function() {

$(this).toggleClass("icon-eye-close");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
//	$('#password').attr('type', 'text');
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

</script> 
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->													
					



	   <div class="control-group">
			
						<div class="controls form-group" style="position: relative;">
							
							<label class="" for="radiobtns">Re-enter Password<span class="required-mark" style="color:#FF0000">*</span></label>

							<input class="span4 form-control pass_msg" id="confirm_password" placeholder="******" name="confirm_password" type="password" autocomplete="nope">
							 <i toggle="#confirm_password" style="display:inline !important;margin-left: -25px; " class="paas_toogle btn-icon-only icon-eye-open com_toggle-password" id="n_pass"></i>

<script type="text/javascript">
                                         $(".com_toggle-password").click(function() {

$(this).toggleClass("icon-eye-close");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

</script> 
							
						</div>
						<!-- /controls -->
		</div>
					<!-- /control-group -->	


						<div class="control-group">
						

						<div class="controls form-group">
							
							<label class="" for="radiobtns">Street Address<span class="required-mark" style="color:#FF0000">*</span></label>

							<textarea class="span4 form-control" name="street_address" id="street_address" cols="250" autocomplete="nope"></textarea>
								<script type="text/javascript">
									$("#street_address").keypress(function(event){
										var ew = event.which;
										if(ew == 32 || ew == 35  )
											return true;
										if(48 <= ew && ew <= 57)
											return true;
										if(65 <= ew && ew <= 90)
											return true;
										if(97 <= ew && ew <= 122)
											return true;
										return false;
									});
									$('#street_address').bind("cut copy paste",function(e) {
											  e.preventDefault();
										
									});
								</script>
						  
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->	



					<div class="control-group">
						

						<div class="controls form-group">
							
							<label class="" for="radiobtns">Email Address<span class="required-mark" style="color:#FF0000">*</span></label>
								<input class="span4 form-control" id="email" placeholder="user@tg.com" name="email" type="text" autocomplete="nope">
								<div style="display: inline-block" id="img"></div>
							
						</div> 
						<!-- /controls -->
					</div>
					<!-- /control-group -->		
					
					
				<div class="control-group" style="display: none;">
						

						<div class="controls form-group">
							<label class="" for="radiobtns">Group / Realm<span class="required-mark" style="color:#FF0000">*</span></label>
								<select class="span4 form-control" name="property_id" id="property_id" onChange="ckgroup(this.value);">
								<option value="">Select Group / Realm</option>

								<?php
								
								$loggin_user_name = $_SESSION['user_name'];
										//   echo $user_distributor;


								// $key_query = "SELECT o.property_number,o.property_id, o.org_name 
								// FROM mdu_organizations o, mdu_system_user_organizations u
								// WHERE o.property_number = u.property_id
								// AND u.user_name = '$loggin_user_name' AND NOT o.`delete_status` = '6'";
						
								// $query_results=mysql_query($key_query);

								$query_results = $db->get_property($user_distributor);

								//while($row=mysql_fetch_array($query_results)){
								foreach($query_results as $row){
									$property_number = $row['property_number'];
									$property_id = $row['property_id'];
									$org_name = $row['org_name'];
									
									echo '<option selected value="'.$property_number.'">'.$org_name.'</option>';
								}
								
								?>
								
								
								</select>
								
							<div style="display: inline-block" id="validity_time_check"></div>																
								
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->
<script type="text/javascript">

function ckgroup(group_var){


$.ajax({
type: 'POST',
url: 'ajax/check_group.php',
data: { group: group_var },
success: function(data) {

//alert(data);

if(data==2){

document.getElementById("validity_time_check").innerHTML = "<p>Please set group validity time.</p>";

document.getElementById('property_id').value='';


}else if(data==1){

document.getElementById("validity_time_check").innerHTML = "";



}else{

document.getElementById("validity_time_check").innerHTML = "";

}


},
error: function(){

}

});


/* $('#customer_form').formValidation('revalidateField', 'email'); */



}



</script>						
					
					<input id="room" name="room" type="hidden">
					<input id="comp_name" name="comp_name" type="hidden">
					
					<!--
					<div class="control-group">
						<label class="control-label" for="radiobtns">Room / Apt#</label>

						<div class="controls">
							<div class="input-prepend input-append">

								<input class="span4" id="room" name="room" type="text">
								
							</div>
						</div>
					
					</div>
																
					
					

					<div class="control-group">
						<label class="control-label" for="radiobtns">Company Name<sup><font color="#FF0000" >*</font></sup></label>

						<div class="controls">
							<div class="input-prepend input-append">

								<input class="span4" id="comp_name" placeholder="" name="comp_name" type="text" maxlength="32">
								
							</div>
						</div>
						
					</div>
				
					  -->
					
				





		  <div class="control-group">
						
						<div class="controls form-group">

							<label class="" for="radiobtns">Country </sup></label>

							
								<select class="span4 form-control" name="country" id="country">
								<option value="">Select Country</option>
                                                    <?php
                                                    $count_results=mysql_query("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                                    UNION ALL
                                    SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");
                                                   while($row=mysql_fetch_array($count_results)){
                                                            if($row[a]==$get_edit_mno_country || $row[a]== "US"){
                                                               $select="selected";
                                                            }else{
                                                                $select="";
                                                            }

                                                       echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';

                                                   }
                                                    ?>
											 </select>															
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->	
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
			  `exp_country_states` ORDER BY description");

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
s_a[2] = "Others";
s_a[3] = "Others";
s_a[4] = "Others";
s_a[5] = "Others";
s_a[6] = "Others";
s_a[7] = "Others";
s_a[8] = "Others";
s_a[9] = "Others";
s_a[10] = "Others";
s_a[11] = "Others";
s_a[12] = "Others";
s_a[13] = "Others";
s_a[14] = "Others";
s_a[15] = "Others";
s_a[16] = "Others";
s_a[17] = "Others";
s_a[18] = "Others";
s_a[19] = "Others";
s_a[20] = "Others";
s_a[21] = "Others";
s_a[22] = "Others";
s_a[23] = "Others";
s_a[24] = "Others";
s_a[25] = "Others";
s_a[26] = "Others";
s_a[27] = "Others";
s_a[28] = "Others";
s_a[29] = "Others";
s_a[30] = "Others";
s_a[31] = "Others";
s_a[32] = "Others";
s_a[33] = "Others";
s_a[34] = "Others";
s_a[35] = "Others";
s_a[36] = "Others";
s_a[37] = "Others";
s_a[38] = "Others";
s_a[39] = "Others";
s_a[40] = "Others";
s_a[41] = "Others";
s_a[42] = "Others";
s_a[43] = "Others";
s_a[44] = "Others";
s_a[45] = "Others";
s_a[46] = "Others";
s_a[47] = "Others";
s_a[48] = "Others";
// <!-- -->
s_a[49] = "Others";
s_a[50] = "Others";
s_a[51] = "Others";
s_a[52] = "Others";
s_a[53] = "Others";
s_a[54] = "Others";
s_a[55] = "Others";
s_a[56] = "Others";
s_a[57] = "Others";
s_a[58] = "Others";
s_a[59] = "Others";
s_a[60] = "Others";
s_a[61] = "Others";
s_a[62] = "Others";
// <!-- -->
s_a[63] = "Others";
s_a[64] = "Others";
s_a[65] = "Others";
s_a[66] = "Others";
s_a[67] = "Others";
s_a[68] = "Others";
s_a[69] = "Others";
s_a[70] = "Others";
s_a[71] = "Others";
s_a[72] = "Others";
s_a[73] = "Others";
s_a[74] = "Others";
s_a[75] = "Others";
s_a[76] = "Others";
s_a[77] = "Others";
s_a[78] = "Others";
s_a[79] = "Others";
s_a[80] = "Others";
s_a[81] = "Others";
s_a[82] = "Others";
s_a[83] = "Others";
s_a[84] = "Others";
s_a[85] = "Others";
s_a[86] = "Others";
s_a[87] = "Others";
s_a[88] = "Others";
s_a[89] = "Others";
s_a[90] = "Others";
s_a[91] = "Others";
s_a[92] = "Others";
s_a[93] = "Others";
s_a[94] = "Others";
s_a[95] = "Others";
s_a[96] = "Others";
s_a[97] = "Others";
s_a[98] = "Others";
s_a[99] = "Others";
s_a[100] = "Others";
s_a[101] = "Others";
s_a[102] = "Others";
s_a[103] = "Others";
s_a[104] = "Others";
s_a[105] = "Others";
s_a[106] = "Others";
s_a[107] = "Others";
s_a[108] = "Others";
s_a[109] = "Others";
s_a[110] = "Others";
s_a[111] = "Others";
s_a[112] = "Others";
s_a[113] = "Others";
s_a[114] = "Others";
s_a[115] = "Others";
s_a[116] = "Others";
s_a[117] = "Others";
s_a[118] = "Others";
s_a[119] = "Others";
s_a[120] = "Others";
s_a[121] = "Others";
s_a[122] = "Others";
s_a[123] = "Others";
s_a[124] = "Others";
s_a[125] = "Others";
s_a[126] = "Others";
s_a[127] = "Others";
s_a[128] = "Others";
s_a[129] = "Others";
s_a[130] = "Others";
s_a[131] = "Others";
s_a[132] = "Others";
s_a[133] = "Others";
s_a[134] = "Others";
s_a[135] = "Others";
s_a[136] = "Others";
s_a[137] = "Others";
s_a[138] = "Others";
s_a[139] = "Others";
s_a[140] = "Others";
s_a[141] = "Others";
s_a[142] = "Others";
s_a[143] = "Others";
s_a[144] = "Others";
s_a[145] = "Others";
s_a[146] = "Others";
s_a[147] = "Others";
s_a[148] = "Others";
s_a[149] = "Others";
s_a[150] = "Others";
s_a[151] = "Others";
s_a[152] = "Others";
s_a[153] = "Others";
s_a[154] = "Others";
s_a[155] = "Others";
s_a[156] = "Others";
s_a[157] = "Others";
s_a[158] = "Others";
s_a[159] = "Others";
s_a[160] = "Others";
s_a[161] = "Others";
s_a[162] = "Others";
s_a[163] = "Others";
s_a[164] = "Others";
s_a[165] = "Others";
s_a[166] = "Others";
s_a[167] = "Others";
s_a[168] = "Others";
s_a[169] = "Others";
s_a[170] = "Others";
s_a[171] = "Others";
s_a[172] = "Others";
s_a[173] = "Others";
s_a[174] = "Others";
s_a[175] = "Others";
s_a[176] = "Others";
s_a[177] = "Others";
s_a[178] = "Others";
s_a[179] = "Others";
s_a[180] = "Others";
s_a[181] = "Others";
s_a[182] = "Others";
s_a[183] = "Others";
s_a[184] = "Others";
s_a[185] = "Others";
s_a[186] = "Others";
s_a[187] = "Others";
s_a[188] = "Others";
s_a[189] = "Others";
s_a[190] = "Others";
s_a[191] = "Others";
s_a[192] = "Others";
s_a[193] = "Others";
s_a[194] = "Others";
s_a[195] = "Others";
s_a[196] = "Others";
s_a[197] = "Others";
s_a[198] = "Others";
s_a[199] = "Others";
s_a[200] = "Others";
s_a[201] = "Others";
s_a[202] = "Others";
s_a[203] = "Others";
s_a[204] = "Others";
s_a[205] = "Others";
s_a[206] = "Others";
s_a[207] = "Others";
s_a[208] = "Others";
s_a[209] = "Others";
s_a[210] = "Others";
s_a[211] = "Others";
s_a[212] = "Others";
s_a[213] = "Others";
s_a[214] = "Others";
s_a[215] = "Others";
s_a[216] = "Others";
s_a[217] = "Others";
s_a[218] = "Others";
s_a[219] = "Others";
s_a[220] = "Others";
s_a[221] = "Others";
s_a[222] = "Others";
s_a[223] = "Others";
s_a[224] = "Others";
s_a[225] = "Others";
s_a[226] = "Others";
s_a[227] = "Others";
s_a[228] = "Others";
s_a[229] = "Others";
s_a[230] = "Others";
s_a[231] = "Others";
s_a[232] = "Others";
s_a[233] = "Others";
s_a[234] = "Others";
s_a[235] = "Others";
s_a[236] = "Others";
s_a[237] = "Others";
s_a[238] = "Others";
s_a[239] = "Others";
s_a[240] = "Others";
s_a[241] = "Others";
s_a[242] = "Others";
s_a[243] = "Others";
s_a[244] = "Others";
s_a[245] = "Others";
s_a[246] = "Others";
s_a[247] = "Others";
s_a[248] = "Others";
s_a[249] = "Others";
s_a[250] = "Others";
s_a[251] = "Others";
s_a[252] = "Others";


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



																	
				
				<div class="control-group">
						

						<div class="controls form-group">
							<label class="" for="radiobtns">State/Province<span class="required-mark" style="color:#FF0000">*</span></label>

								<select class="span4 form-control" id="state" name="state">
								<?php

$get_regions=mysql_query("SELECT
 `states_code`,
 `description`
FROM
`exp_country_states` ORDER BY description ASC");

echo '<option value="">Select State</option>';

while($state=mysql_fetch_assoc($get_regions)){
   //edit_state_region , get_edit_mno_state_region
   if($get_edit_mno_state_region==$state['states_code']) {

	   echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
   }else{

	   echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
   }
}
//echo '<option value="other">Other</option>';


?>
								 </select>
								
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->	
					
<script language="javascript">
/* populateCountries("country", "state");
// populateCountries("country"); */
</script> 												
							<script type="text/javascript">
							
// 																	$("#state").keypress(function(e){

										
// 																		if (e.which>32 && e.which < 48 || 
// 																			    (e.which > 57 && e.which < 65) || 
// 																			    (e.which > 90 && e.which < 97) ||
// 																			    e.which > 122) {
// 																			    e.preventDefault();
// 																			}

										
// 																	});
								</script>
					


<script type="text/javascript">

//$("#ms_num").attr('maxlength','6');


$("#country").on('change',function(){

var e = $("#country").val();


if(e=='United States of America'){

$("#postal_code").attr('maxlength','5');

}else{

$("#postal_code").attr('maxlength','10');

}

});




</script>														
				
				<div class="control-group">
						
						<div class="controls form-group">
							
							<label class="" for="radiobtns">Postal Code<span class="required-mark" style="color:#FF0000">*</span></label>

								<input class="span4 form-control" id="postal_code" placeholder="xxxxx" name="postal_code" type="text" maxlength="5" autocomplete="nope">
								
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->	
					
					
					
					
					
					<script>
$('#postal_code').on('keydown', function(e){
if(e.keyCode < 48 && e.keyCode != 8 && e.keyCode != 9 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 39){
e.preventDefault();
}else {
if(e.keyCode > 105){
e.preventDefault();
}else{
if(e.keyCode < 96 && e.keyCode > 57){
e.preventDefault();
}else{

}
}
}
});

$('#postal_code').bind("cut copy paste",function(e) {
											  e.preventDefault();
										   });
</script>


				
				<div class="control-group">
						
						<div class="controls form-group">
							
							<label class="" for="radiobtns">City<span class="required-mark" style="color:#FF0000">*</span></label>

								<input class="span4 form-control" id="city" placeholder="" name="city" type="text" autocomplete="nope">
								<script type="text/javascript">
									//$("#city").keypress(function(event){
//																		var ew = event.which;
//																		if(ew == 8||ew == 0)
//																			return true;
//																		//if(48 <= ew && ew <= 57)
////																			return true;
//																		if(65 <= ew && ew <= 90)
//																			return true;
//																		if(97 <= ew && ew <= 122)
//																			return true;
//																		return false;
//																	});

$('#city').bind("cut copy paste",function(e) {
											  e.preventDefault();
										   });
								</script>
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->	 
			   

			

					
			<div class="control-group">
						

						<div class="controls form-group">

							<label class="" for="radiobtns">Secret Question<span class="required-mark" style="color:#FF0000">*</span></label>
							
								<select name="question" id="question" class="span4 form-control">
								<option value="">Select Question</option>
								<?php 
								$key_query = "SELECT `question_id` AS a, `secret_question` AS b FROM `mdu_secret_questions` WHERE is_enable=1 ORDER BY `secret_question` ASC";

								$query_results=mysql_query($key_query);
								while($row=mysql_fetch_array($query_results)){
									$a = $row['a'];
									$b = $row['b'];
									
									echo '<option value="'.$b.'">'.$b.'</option>';
								}
								?>
								</select>																
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->													
					
					
					
		
			<div class="control-group">
						
						<div class="controls form-group">
							
							<label class="" for="radiobtns">Answer<span class="required-mark" style="color:#FF0000">*</span></label>

								<input class="span4 form-control" id="answer" placeholder="Answer" name="answer" type="text" autocomplete="nope">
								
							
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->
								<script type="text/javascript">
									$("#answer").keypress(function(event){
										var ew = event.which;
										//alert (ew);
										if(ew == 32 || ew == 35   )
											return true;
										if(48 <= ew && ew <= 57)
											return true;
										if(65 <= ew && ew <= 90)
											return true;
										if(97 <= ew && ew <= 122)
											return true;
											
										return false;
									});
									$('#answer').bind("cut copy paste",function(e) {
											  e.preventDefault();
										   });
								</script>
					
					

					<div class="control-group">
						
						<div class="controls form-group">
							
							<label class="" for="radiobtns">Mobile Number</label>

								<input class="span4 form-control mobile1_vali" id="phone" placeholder="xxx-xxx-xxxx" name="phone" type="text"  maxlength="12" autocomplete="nope">

								
					  </div>
					  <div class="form-actions">
								<button type="submit" name="customer_submit" id="customer_submit"  class="btn btn-primary" disabled>Save and Send Email Invitation</button> &nbsp; <strong><font color="#FF0000">*</font><font size="1"> Required Field</font></strong>
								</div>
						<!-- /controls -->
					</div>

					
					<!-- /control-group -->			
					<?php if($dpsk_enable){?>
						<div class="control-group">
						
						<div class="controls form-group">
							
							<label class="" for="radiobtns">Device Password<span class="required-mark" style="color:#FF0000">*</span></label>

							<input class="span4 form-control pass_msg" id="passcode_key" placeholder="Device Password" name="passcode_key" type="password" autocomplete="nope">
							<i toggle="#passcode_key" style="display:inline !important;margin-left: -25px; " class="paas_toogle btn-icon-only icon-eye-open passcode_toggle-password" id="n_pass"></i>

						<script type="text/javascript">
							 $(".passcode_toggle-password").click(function() {

							$(this).toggleClass("icon-eye-close");
							var input = $($(this).attr("toggle"));
							if (input.attr("type") == "password") {
							  input.attr("type", "text");
							} else {
							  input.attr("type", "password");
							}
							});

						</script> 
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->	
					<?php } ?>	
									

					
	
		

		
			   <!-- <div class="control-group">
						

						<div class="form-actions">
						<button type="submit" name="customer_submit" id="customer_submit"  class="btn btn-primary" disabled>Save and Send Email Invitation</button> &nbsp; <strong><font color="#FF0000">*</font><font size="1"> Required Field</font></strong>
							
					
					  </div>
					</div> -->
					<!-- /control-group -->	
					
					
					

					
					
						 
					<script type="text/javascript">

$(document).ready(function() {

	$('#phone').focus(function(){
		$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
	});

	$('#phone').keyup(function(){
		$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
	});

   $("#phone").keypress(function(event){
						var ew = event.which;
						//alert(ew);
						if(ew == 8||ew == 0||ew == 46||ew == 45)
							return true;
						if(48 <= ew && ew <= 57)
							return true;
						return false;
					});

	$("#phone").keydown(function (e) {


		var mac = $('#phone').val();
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
			return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);

			/*if(len == 4){
				$('#phone').val(function() {
					return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
					//console.log('mac1 ' + mac);

				});
			}
			else if(len == 8 ){
				$('#phone').val(function() {
					return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
					//console.log('mac2 ' + mac);

				});
			}*/
		}


		// Allow: backspace, delete, tab, escape, enter, '-' and .
		if ($.inArray(e.keyCode, [8, 9, 27, 13]) !== -1 ||
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


	$('.mobile1_vali').focus(function(){
																			$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
																			$('#customer_form').data('bootstrapValidator').updateStatus('phone', 'NOT_VALIDATED').validateField('phone');

																		});

																		$('.mobile1_vali').keyup(function(){
																			$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
																			 $('#customer_form').data('bootstrapValidator').updateStatus('phone', 'NOT_VALIDATED').validateField('phone');

																		});


});


</script>





					
					<!-- /form-actions -->
				</fieldset>
			</form>





		</div>
		
		
		
		
											

		



		
		
		













		
		
		
		
		

							








		
		








		
		











		
		
		
		
		
		
		
		
		






                                            <!-- ******************* live camp ******************* -->
										




                                        <!-- ******************* today sessions ******************* -->
										



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



<!-- <script src="js/jquery-1.7.2.min.js"></script> -->

	<!-- <script src="js/bootstrap.js"></script> -->
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
<script type="text/javascript" src="js/bootstrapValidator.js"></script>

	<script type="text/javascript">
 		$(document).ready(function() {

    		$('#customer_form').bootstrapValidator({
        
				
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
                

        					fields: {

	        					first_name: {
					                validators: {
					                    <?php echo $db->validateField('notEmpty'); ?>
					                }
					            },
					            last_name: {
					                validators: {
										<?php echo $db->validateField('notEmpty'); ?>
					                }
					            },
					            password: {
					                validators: {
										identical: {
   field: 'confirm_password',
   message: '<p>The Password and Confirm Password are not the same.</p>'
       } ,
										<?php echo $db->validateField('password_required'); ?>
					                }
					            },
					           /* email: {
					                 validators: {
										<?php// echo $db->validateField('email_not_valid'); ?>,
                                        remote: {
                                            url: 'ajax/check_email.php',
                                            // Send { realm: 'its value', email: 'its value' } to the back-end
                                            data: function(validator, $field, value) {
                                                return {
                                                    realm: validator.getFieldElements('property_id').val()
                                                };
                                            },
                                            message: '<p>Email already exists</p>',
                                            type: 'POST'
                                        }
                                    } 
					            },*/
					            email: {
				                    validators: {
				                        <?php echo $db->validateField('email'); ?>,
										remote: {
                                            url: 'ajax/check_email.php',
                                            // Send { realm: 'its value', email: 'its value' } to the back-end
                                            data: function(validator, $field, value) {
                                                return {
                                                    realm: validator.getFieldElements('property_id').val()
                                                };
                                            },
                                            message: '<p>Email already exists</p>',
                                            type: 'POST'
                                        }
				                    }
				                },
					            phone: {
					                validators: {
                                     <?php echo $db->validateField('mobile_non_req'); ?>
                                    }
					            },
					            confirm_password: {
								    validators: {
										<?php echo $db->validateField('pass_not_same'); ?>,
								        <?php echo $db->validateField('password_required'); ?>,
								        <?php echo $db->validateField('notEmpty'); ?>           
									}
								},
								<?php if($dpsk_enable){?>
								passcode_key: {
								    validators: {
								        <?php echo $db->validateField('notEmpty'); ?> ,
										<?php echo $db->validateField('dpsk_only'); ?>
										//  ,
										// remote: {                                
										//  url: 'ajax/dpsk_val.php',    
										//  type: "POST",                             
										//  // Send { username: 'its value', email: 'its value' } to the back-end                                 
										//  data: {  
                      					//    user_distributor: '<?php echo $user_distributor ?>',
										//    param: 'div_passcode_key'                            
										//   },                                
										//    message: 'This Passcode Key already exists'                            
										//     }           
									}
								},
							<?php }?>
					            property_id: {
								    validators: {
										<?php echo $db->validateField('notEmpty'); ?>
									}
								},
								street_address: {
								    validators: {
										<?php echo $db->validateField('notEmpty'); ?>             
									},
					                stringLength: {
					                        max: 256,
					                        message: 'The value must be less than 256 characters'
					                }
								},
								state: {
								    validators: {
										<?php echo $db->validateField('notEmpty'); ?>           
									}
								},
					            postal_code: {
								    validators: {
										<?php echo $db->validateField('zip_code'); ?>
									},
							
					            stringLength: {
					                        max: 5,
					                        message: 'The value must be less than 5 characters'
					                }
								},
								city: {
								    validators: {
										<?php echo $db->validateField('city_required'); ?>            
									},
					                stringLength: {
					                        max: 100,
					                        message: 'The value must be less than 100 characters'
					                }
								},
								country: {
								    validators: {
								          <?php echo $db->validateField('notEmpty'); ?>             
									}
								},
								answer: {
								    validators: {
										<?php echo $db->validateField('notEmpty'); ?>            
									},
					                stringLength: {
					                        max: 30,
					                        message: 'The value must be less than 30 characters'
					                }
								},
								question: {
								    validators: {
										<?php echo $db->validateField('notEmpty'); ?>             
									}
								}
        					}
        				});


        $('input').on('blur keyup', function() {

        	//check_val();
		 
	    });

    	

	 	$('select').on('change', function() {

	 		//check_val();
		
	    });  


	 	//check_val();

    	});

		

		
		function check_val(){
					/* var isValidForm = $('#customer_form').data('formValidation').isValid();  

					if(isValidForm){
						$('#customer_submit').prop('disabled', false);  
					}
					else{
						$('#customer_submit').prop('disabled', 'disabled');  
					} */  
		}


 	</script>	


		
</body>