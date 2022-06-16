<?php 

//require_once '/var/www/html/campaign_portal/templates/email/cox/index.php';
include_once( str_replace('//','/',dirname(__FILE__).'/') .'../classes/dbClass.php');
include_once( str_replace('//','/',dirname(__FILE__).'/') .'../classes/systemPackageClass.php');

$db_query = $db_query = new db_functions();
$package_functions=new package_functions();
$url_base = $db_query->setVal('global_url','ADMIN');
	
//$url_base = "http://216.234.148.168/campaign_portal";
$base_url = trim(($url_base),"/");

$items = Array(1,2,3);
$img_item = $items[array_rand($items)];
$support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER',$this->mno_package,$this->verticle);
if (strlen($support_number)<1) {
	$support_number = '866-757-3851';
}
$img_name=$img_item.'.jpg';

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
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0">
							<tr>
								<td width="10" height="25" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0;">
								
								</td>
								<td width="140" height="25" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding-top:3px;margin:0;">
								<img src="'.$base_url.'/templates/email/att/img/top-logo.png" width="22" border="0" style="display:block;" alt="AT&T" title="AT&T" />
								</td>
								<td width="340" height="25" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0;">
									<table width="340" height="25" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0">
										<tr>
											<td width="340" height="25" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0;">
												<table width="330" height="25" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0">
													
													<tr>
														<td width="330" height="25" cellpadding="0" cellspacing="0" border="0" align="right" valign="top" bgcolor="#000" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#000;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:11px;line-height:25px;">
															Customer Support: <span style="font-weight:bold;text-align:center">'.$support_number.'</span>
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
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START LOGO BAR -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#fff" style="background-color:#fff;padding:0;margin:0">
							<tr>
							<td width="150"></td>
								<td width="180" height="50" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#fff" style="background-color:#fff;padding-top:10px;margin:0;">
									<img src="'.$base_url.'/templates/email/att/img/myatt-logo.png" width="180" border="0" style="display:block;" alt="AT&T" title="AT&T" />
								</td>
								<td width="150" height="50" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#fff" style="background-color:#fff;padding:0;margin:0;">
								
								</td>
							</tr>
						</table>
						<!-- END LOGO BAR-->
 
					</td>
				</tr>
				
				
				
				
 
			
 
 
 
 
				<tr>
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
 
						<!-- START HEADER -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0">
							<tr>
								<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
									<img src="'.$base_url.'/templates/email/att/img/'.$img_name.'" width="480" height="190" border="0" style="display:block;" alt="AT&T" title="AT&T" />
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
									<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="20" height="1" border="0" style="display:block;" />
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
												<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="1" height="15" border="0" style="display:block;" />
											</td>
										</tr>
										
										<tr>
											<td width="440" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="1" height="15" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="20" height="1" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
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
									<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="1" height="20" border="0" style="display:block;" />
								</td>
							</tr>
						</table>
						<!-- END SPACER -->
 
					</td>
				</tr>
 


 
				<tr>
					<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0">
 
						<!-- START FOOTER -->
						<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0">

						<tr>
								<td style="background-color:#ea7400;padding:0;margin:0;" width="480" valign="top" height="5" bgcolor="#ea7400" align="left">
									<table style="background-color:#ea7400;padding:0;margin:0;" width="480" cellspacing="0" cellpadding="0" border="0" bgcolor="#ea7400" align="left"><tbody><tr>
										<td>
											</td>
										</tr>
										</tbody>
                    
										</table>
								</td>
							</tr>
							
							<tr>
								<td width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#22305d;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:11px;line-height:13px;">
									<table width="480" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0">
										<tr>
											<td width="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="10" height="1" border="0" style="display:block;" />
											</td>
											<td width="200" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#000;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:10px;line-height:30px;vertical-align: middle;" height="30">
												<span style="color:#ffffff;"><span style="color:#ffffff;vertical-align: middle;"><a href="http://about.att.com/sites/privacy_policy" target="_blank" style="color:#0072bc;text-decoration:none;"><span style="color:#ffffff;">Privacy Policy</span></a></span>
											</td>
											<td width="260" cellpadding="0" cellspacing="0" border="0" align="right" valign="top" bgcolor="#000" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:100%;background-color:#000;padding:0;margin:0;color:#ffffff;font-family:arial;font-size:10px;line-height:30px;" height="30">
												&copy; AT&T Intellectual Property.
											</td>
											<td width="10" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" bgcolor="#000" style="background-color:#000;padding:0;margin:0;">
												<img src="'.$base_url.'/templates/email/att/img/1x1_trans.gif" width="10" height="1" border="0" style="display:block;" />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							
						</table>
						<!-- END FOOTER -->
 
			</table>
			<!-- END MAIN INTERIOR WRAPPER (480px) -->
 
		</td>
	</tr>
</table>
<!-- END MAIN WRAPPER -->
 
</body>
 
</html>';



?>
