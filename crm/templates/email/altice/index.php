<?php 

//require_once '/var/www/html/campaign_portal/templates/email/cox/index.php';
include_once( str_replace('//','/',dirname(__FILE__).'/') .'../classes/dbClass.php');

$db_query = $db_query = new db_functions();
$url_base = $db_query->setVal('global_url','ADMIN');
	
//$url_base = "http://216.234.148.168/campaign_portal";
$base_url = trim(($url_base),"/");

$message_template =
'Content-Type: text/html; charset=UTF-8'."\r\n".
'Content-Transfer-Encoding: 7bit'."\r\n\r\n".'

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
									<img src="'.$base_url.'/templates/email/altice/img/logoAltice.jpg" width="150" height="auto" border="0" style="display:block;" alt="Altice Business" title="Altice Business" />
								</td>
								<td width="340" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<table width="340" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
										<tr>
											<td width="340" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
												<table width="330" height="55" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
													<tr>
														<td width="330" height="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
															<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="10" border="0" style="display:block;" />
														</td>
													</tr>
													<tr>
														<td width="330" height="25" cellpadding="0" cellspacing="0" border="0" align="right" valign="top" bgcolor="#ffffff" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ffffff;padding:0;margin:0;color:#333333;font-family:arial;font-size:11px;line-height:13px;">
														
														</td>
													</tr>
													<tr>
														<td width="330" height="20" cellpadding="0" cellspacing="0" border="0" align="right" valign="bottom" bgcolor="#ffffff" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ffffff;padding:0;margin:0;color:#333333;font-family:arial;font-size:11px;line-height:11px;">
															
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="10" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/altice/img/headerAltice.jpg" width="480" height="190" border="0" style="display:block;" alt="Altice" title="Altice" />
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="20" height="1" border="0" style="display:block;" />
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
												<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="15" border="0" style="display:block;" />
											</td>
										</tr>
										
										<tr>
											<td width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="15" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="20" height="1" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END SPACER -->
 
					</td>
				</tr>
 


 
				<tr>
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#22305d" style="background-color:#22305d;padding:0;margin:0">
 
						<!-- START FOOTER -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ea7c31" style="background-color:#ea7c31;padding:0;margin:0">
							<tr>
								<td width="480" height="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ea7c31" style="background-color:#ea7c31;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="10" border="0" style="display:block;" />
								</td>
							</tr>
							<tr>
								<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ea7c31" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ea7c31;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:11px;line-height:13px;">
									<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ea7c31" style="background-color:#ea7c31;padding:0;margin:0">
										<tr>
											<td width="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ea7c31" style="background-color:#ea7c31;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="10" height="1" border="0" style="display:block;" />
											</td>
											<td width="200" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ea7c31" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ea7c31;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:10px;line-height:11px;">
												<span style="color:#ffffff;"><span style="color:#ffffff;"><a href="http://altice.net/terms-use" target="_blank" style="color:#0072bc;text-decoration:none;"><span style="color:#ffffff;">Privacy Policy</span></a></span>
											</td>
											<td width="260" cellpadding="0" cellspacing="0" border="0" align="right" valign="top" bgcolor="#ea7c31" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ea7c31;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:10px;line-height:11px;">
												&copy; '.date("Y").' Altice NV ,The Netherlands
											</td>
											<td width="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ea7c31" style="background-color:#ea7c31;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="10" height="1" border="0" style="display:block;" />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="480" height="10"cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ea7c31" style="background-color:#ea7c31;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="10" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
								<td width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#ffffff;padding:0;margin:0;color:#333333;font-family:arial;font-size:11px;line-height:13px;">
								
									This email was sent by:<br />
									Altice NV<br />
									The Netherlands<br />
								</td>
								<td width="20" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/altice/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
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
 
</html>
';
?>
