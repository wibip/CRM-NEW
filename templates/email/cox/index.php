<?php 

//require_once '/var/www/html/campaign_portal/templates/email/cox/index.php';
include_once( str_replace('//','/',dirname(__FILE__).'/') .'../classes/dbClass.php');
include_once( str_replace('//','/',dirname(__FILE__).'/') .'../classes/systemPackageClass.php');

$db_query = new db_functions();
$package_functions=new package_functions();
$url_base = $db_query->setVal('global_url','ADMIN');
$this->mno_package."<br>".$this->system_package;


$support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER',$this->system_package,$this->verticle);
if (strlen($support_number)<1) {
	$support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $this->mno_package);
}
	
//$url_base = "http://216.234.148.168/campaign_portal";
$base_url = trim(($url_base),"/");

$message_template =
'Content-Type: text/html; charset=UTF-8'."\r\n".
'Content-Transfer-Encoding: 7bit'."\r\n\r\n".
'

<html xmlns="http://www.w3.org/1999/xhtml">
 
<head>
	<title> </title>
</head>
 
<body bgcolor="#eeeeee" style="background-color:#eeeeee;padding:0;margin=0;">
 
<!-- START MAIN WRAPPER (100%)-->
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" valign="top" bgcolor="#eeeeee" style="background-color:#eeeeee;padding:0;margin:0">
	<tr>
		<td width="100%" cellpadding="0" cellspacing="0" border="0" align="center" valign="top" bgcolor="#eeeeee" style="background-color:#eeeeee;padding:0;margin:0">
 
			<!-- START MAIN INTERIOR WRAPPER (480px) -->
			<table width="480" cellpadding="0" cellspacing="0" border="0" align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
				
				
 
				
				<tr>
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START LOGO BAR -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="140" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/logo.png" width="135" height="65" border="0" style="display:block;" alt="Cox Business" title="Cox Business" />
								</td>
								<td width="340" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<table width="340" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
										<tr>
											<td width="340" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
												<table width="330" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
													<tr>
														<td width="330" height="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
															<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="10" border="0" style="display:block;" />
														</td>
													</tr>
													<tr>
														<td width="330" height="25" cellpadding="0" cellspacing="0" border="0" align="right" valign="top" bgcolor="#ffffff" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ffffff;padding:0;margin:0;color:#333333;font-family:arial;font-size:11px;line-height:13px;">
															Customer Support: <span style="font-weight:bold;text-align:center">'.$support_number.'</span>
														</td>
													</tr>
													<tr>
														<td width="330" height="20" cellpadding="0" cellspacing="0" border="0" align="right" valign="bottom" bgcolor="#ffffff" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ffffff;padding:0;margin:0;color:#333333;font-family:arial;font-size:11px;line-height:11px;">
															<a href="http://www.coxbusiness.com/myaccount" target="_blank" style="color:#0072bc;">MyAccount</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END LOGO BAR-->
 
					</td>
				</tr>
 
				<tr>
					<td width="480" height="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START SPACER -->
						<table width="480" height="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="480" height="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="10" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END SPACER -->
 
					</td>
				</tr>
 
				<tr>
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START HEADER -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/header.jpg" width="480" height="190" border="0" style="display:block;" alt="Cox Business" title="Cox Business" />
								</td>
							</tr>
						</table>
						<!-- END HEADER -->
 
					</td>
				</tr>
 
				<tr>
					<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START SPACER -->
						<table width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END SPACER -->
 
					</td>
				</tr>
 
				<tr>
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START BODY -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="20" height="1" border="0" style="display:block;" />
								</td>
								<td width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<table width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
										<tr>
											<td width="440" cellpadding="0" cellspacing="0" border="0" align="center" valign="top" bgcolor="#ffffff" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ffffff;padding:0;margin:0;color:#2d426d;font-family:arial;font-size:14px;line-height:22px;">
												<center><span style="font-weight:bold;text-align:center;">'.$subject.'</span></center>
											</td>
										</tr>
										<tr>
											<td width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="15" border="0" style="display:block;" />
											</td>
										</tr>
										
										<tr>
											<td width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="15" border="0" style="display:block;" />
											</td>
										</tr>
										<tr>
											<td width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ffffff;padding:0;margin:0;color:#333333;font-family:arial;font-size:10px;line-height:18px;">
												'.$body.'
											</td>
										</tr>
									</table>
								</td>
								<td width="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="20" height="1" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END BODY -->
 
					</td>
				</tr>
 
				<tr>
					<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START SPACER -->
						<table width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END SPACER -->
 
					</td>
				</tr>
 
				
 
				<tr>
					<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START SPACER -->
						<table width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END SPACER -->
 
					</td>
				</tr>
 


 
				<tr>
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="background-color:#22305d;padding:0;margin:0">
 
						<!-- START FOOTER -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="background-color:#22305d;padding:0;margin:0">
							<tr>
								<td width="480" height="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="background-color:#22305d;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="10" border="0" style="display:block;" />
								</td>
							</tr>
							<tr>
								<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#22305d;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:11px;line-height:13px;">
									<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="background-color:#22305d;padding:0;margin:0">
										<tr>
											<td width="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="background-color:#22305d;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="10" height="1" border="0" style="display:block;" />
											</td>
											<td width="200" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#22305d;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:10px;line-height:11px;">
												<span style="color:#ffffff;"><span style="color:#ffffff;"><a href="http://www.cox.com/aboutus/policies/business-policies.cox" target="_blank" style="color:#0072bc;text-decoration:none;"><span style="color:#ffffff;">Privacy Policy</span></a></span>
											</td>
											<td width="260" cellpadding="0" cellspacing="0" border="0" align="right" valign="top" bgcolor="#22305d" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#22305d;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:10px;line-height:11px;">
												&copy; '.date("Y").' Cox Communications, Inc. All rights reserved.
											</td>
											<td width="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="background-color:#22305d;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="10" height="1" border="0" style="display:block;" />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="480" height="10"cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="background-color:#22305d;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="10" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END FOOTER -->
 
					</td>
				</tr>
 
				<tr>
					<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START SPACER -->
						<table width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END SPACER -->
 
					</td>
				</tr>
 
				<tr>
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START LEGAL -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
								<td width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ffffff;padding:0;margin:0;color:#333333;font-family:arial;font-size:11px;line-height:13px;">
								
									This email was sent by:<br />
									Cox Communications, Inc.<br />
									6205 Peachtree Dunwoody Road<br />
									Atlanta, GA 30328
								</td>
								<td width="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END LEGAL -->
 
					</td>
				</tr>
 
				<tr>
					<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START SPACER -->
						<table width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="480" height="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/cox/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END SPACER -->
 
					</td>
				</tr>
			</table>
			<!-- END MAIN INTERIOR WRAPPER (480px) -->
 
		</td>
	</tr>
</table>
<!-- END MAIN WRAPPER -->
 
</body>
 
</html>';



?>
