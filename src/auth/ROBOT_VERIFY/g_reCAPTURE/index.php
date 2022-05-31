<?php
if(isset($_POST['sign_in'])) {

    require_once(str_replace('//','/',dirname(__FILE__).'/').'../../../../bo/RobotVerifyUser.php');

    $robot_v_user = new RobotVerifyUser();

    $robot_v_user->g_recaptcha_response = $_POST['g-recaptcha-response'];
}

class robot_verify{

    public function __construct()
    {
        $this->db_functions = new db_functions();

    }

    private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    private function getRecaptureEnable(){
        $g_reCAPTCHA = $this->db_functions->setVal("g-reCAPTCHA",'ADMIN');
        $g_reCAPTCHA_site_key = $this->db_functions->setVal("g-reCAPTCHA-site-key",'ADMIN');

        if(empty($g_reCAPTCHA) || empty($g_reCAPTCHA_site_key)){
            return false;
        }

        return true;
    }

    public function login($response){

        /*check Enable*/
        if(!$this->getRecaptureEnable()){
            
            return true;
        }

        /*Abuse Verification*/
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $ch = curl_init($url);

        $jsonData = array(

            'secret' => $this->db_functions->setVal('g-reCAPTCHA','ADMIN'),
            'response' => $response->g_recaptcha_response,
            'remoteip' => $this->get_client_ip()
        );

        //Encode the array into JSON.
        //echo $jsonDataEncoded2 = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        //output is ID

        $result = curl_exec($ch);
        curl_close($ch);
        $result_ar = json_decode($result, true);

        if ($result_ar['success']) {
            return true;
        }else{
            return false;
        }
    }


    public function form(){

        /*check Enable*/
        if(!$this->getRecaptureEnable()){
            return;
        }

        $reCAPTCHA_site_key = $this->db_functions->setVal('g-reCAPTCHA-site-key','ADMIN');

        echo $div = '<div class="g-recaptcha" data-sitekey="'.$reCAPTCHA_site_key.'"></div>';

        echo $styles = '<style>
        .g-recaptcha > div{
        	width: 100% !important;
        }
                            #rc-imageselect, .g-recaptcha {
                                   
                                   /* -webkit-transform:scale(0.84);
                                    transform-origin:0 0;*/
                                    
                            }

                            @media (max-width: 480px) {
	
                                #rc-imageselect, .g-recaptcha {
                                   
                                     -webkit-transform: scale(0.87);
							            -ms-transform: scale(0.87);
							                transform: scale(0.87);
							    -webkit-transform-origin: 0 0;
							        -ms-transform-origin: 0 0;
							            transform-origin: 0 0;
                                    
                            }

                            @media (max-width: 320px) {
	
                                #rc-imageselect, .g-recaptcha {
                                   
                                    -webkit-transform: scale(0.74);
							            -ms-transform: scale(0.74);
							                transform: scale(0.74);
							    -webkit-transform-origin: 0 0;
							        -ms-transform-origin: 0 0;
							            transform-origin: 0 0;
                                    
                            }

                            }
                            
                           .rc-anchor-normal-footer {
                               margin-left: -15% !important;
                           }
                           .rc-anchor-pt {
                                margin-right: 17% !important;
                            }
                            .rc-anchor.rc-anchor-normal.rc-anchor-light {
                                width: 84% !important;
                            }
                        </style>';

    }


}