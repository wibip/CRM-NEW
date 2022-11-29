<?php 


include_once( '../../../../classes/systemPackageClass.php');


class email
{
	
	private $template;
	
	
	public function __construct($array)
	{
        $this->get_pro = new package_functions();
        $admin_package = $this->get_pro->getAdminPackage();
        $this->system_package = $array['system_package'];
        $this->mno_package = $array['mno_package'];
        $this->verticle = $array['verticle'];

        if (strlen($this->system_package)>0) {
        	
        $emailTemplateType = $this->get_pro->getSectionType('EMAIL_TEMPLATE', $this->mno_package);
        if ($emailTemplateType == 'child') {
            $this->template = $this->get_pro->getOptions('EMAIL_TEMPLATE', $this->system_package);
        } elseif ($emailTemplateType == 'owen') {
            $this->template = $this->get_pro->getOptions('EMAIL_TEMPLATE', $this->mno_package);
        } elseif (strlen($emailTemplateType) > 0) {
            $this->template = $emailTemplateType;
        } else {
            $this->template = $this->get_pro->getOptions('EMAIL_TEMPLATE', $this->mno_package);
        }
    	}else{
    		$this->template = $array['template'];
    	}

        if(strlen($this->template)<1){
            $this->template=$this->get_pro->getOptions('EMAIL_TEMPLATE',$admin_package);
        }

		$this->logo = "";
		if(strlen($this->verticle)>0){
			$business_logo = "logo_" . strtolower($this->verticle).".png";
			$logo_location = str_replace('//','/',dirname(__FILE__).'/') ."../../../templates/email/" . $this->template . "/img/".$business_logo;
			if(file_exists($logo_location)){
				$this->logo = $business_logo;
			}
		}

    }

    	
	function sendEmail($from,$to,$subject,$body,$type,$etc){
        $get_pro = new package_functions();
	if(!is_null($this->mno_system_package) ){

        $from_name=$get_pro->getOptions('EMAIL_NAME',$this->mno_system_package);
        if(!empty($from_name)){
             $from_mail = $from_name.'<'.$from.'>';
        }else{
            $from_mail = $from;    
        }
        
    }
    else{
        $from_mail = $from;
        }
        //echo '<script> alert("AT&T Wi-Fi Services <noreply@att-wifi.com>")</script>';
        $from=htmlspecialchars_decode($from_mail);
       // AT&T Wi-Fi Services <noreply@att-wifi.com>

	   $logo = $this->logo;

//$from_mail='AT&T Wi-Fi Services <noreply@att-wifi.com>';
	$bound_text = "----*%$!$%*";
	$bound = "--".$bound_text."\r\n";
	$bound_last = "--".$bound_text."--\r\n";

	$headers = "From: ".$from."\r\n";
	$headers .= "MIME-Version: 1.0\r\n" .
	"Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ;

	$message = " you may wish to enable your email program to accept HTML \r\n".
	$bound;


	//define("_SUBJECT_", $subject,true);
	//define("_BODY_", $body,true);

	include( str_replace('//','/',dirname(__FILE__).'/') .'../../../templates/email/'.$this->template.'/index.php');
// echo $this->template."<br>";		
// echo $this->mno_package;
	 $message .= $message_template;



	 $mail_sent =  @mail($to, $subject, $message, $headers, "-f $from") ;
    
   
	return $mail_sent;

    }
    
    
    
    function sendEmailwithcc($from,$to,$subject,$body,$type,$etc){

    
    	$bound_text = "----*%$!$%*";
    	$bound = "--".$bound_text."\r\n";
    	$bound_last = "--".$bound_text."--\r\n";
    
    	$headers = "From: ".$from."\r\n";
    	$headers .= $etc;
    	$headers .= "MIME-Version: 1.0\r\n" .
    			"Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ;
    
    	$message = " you may wish to enable your email program to accept HTML \r\n".
    			$bound;
    
    
    			define("_SUBJECT_", $subject,true);
    			define("_BODY_", $body,true);

				$logo = $this->logo;
    
    			include( str_replace('//','/',dirname(__FILE__).'/') .'../../../templates/email/'.$this->template.'/index.php');
    
    
    			$message .= $message_template;
    
    
    
    			$mail_sent =  @mail($to, $subject, $message, $headers, "-f $from") ;
    			return $mail_sent;
    
    }
	
	
	function sendEmailwithBcc($from,$to,$subject,$body,$type,$etc){
    
    
    	$bound_text = "----*%$!$%*";
    	$bound = "--".$bound_text."\r\n";
    	$bound_last = "--".$bound_text."--\r\n";
	
		
		
    	 $headers  = "From: ".$from."\r\n";
		 $headers .= "Bcc: ".$etc."\r\n"; 
		

    	 $headers .= "MIME-Version: 1.0\r\n" .
				"Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ; 
				
			


    
    	$message = " you may wish to enable your email program to accept HTML \r\n".
    			$bound;
    
    
    			define("_SUBJECT_", $subject,true);
    			define("_BODY_", $body,true);

				$logo = $this->logo;
    
    			include( str_replace('//','/',dirname(__FILE__).'/') .'../../../templates/email/'.$this->template.'/index.php');
    
    
    			$message .= $message_template;
    
    
    
    			$mail_sent =  @mail($to, $subject, $message, $headers, "-f $from") ;
    			return $mail_sent;
    
    }
    

	public function log(dbTasks $dbTasks,$to,$subject,$message,$password_re,$distributor,$send_options){
        $q = "INSERT INTO admin_invitation_email (`to`,`subject`,`message`,`password_re`,`distributor`,`send_options`,`create_date`)
                VALUES ('$to','$subject','$message','$password_re','$distributor','$send_options',NOW())";
        $dbTasks->execDB($q);
	}
}


