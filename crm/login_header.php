<link
 href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
 rel="stylesheet">
<?php  

include_once( str_replace('//','/',dirname(__FILE__).'/') .'db/dbTasks.php'); 
include_once( str_replace('//','/',dirname(__FILE__).'/') .'classes/systemPackageClass.php');   
$dbT = new dbTasks();
$package_functions=new package_functions();

/* No cache*/
header("Cache-Control: no-cache, must-revalidate");

//server log class
require_once 'classes/logClass.php';


require_once 'classes/messageClass.php';

foreach ($_POST as $key => $value) {
    if(strpos($value,'<script') !== false){
        $_POST[$key] = strip_tags($value);
    }
    else{
        
    }
}

foreach ($_GET as $key => $value) {
    if(strpos($value,'<script') !== false){
        $_GET[$key] = strip_tags($value);
    }
    else{
        
    }

}


$script = basename($_SERVER['PHP_SELF'],".php");


$login_profile = json_decode($dbT->setVal('ALLOWED_LOGIN_PROFILES','ADMIN'),true);

//Unset disable login
foreach ($login_profile as $key => $value){
    if($value=='0'){
        unset($login_profile[$key]);
    }
}
$login_profile_count = count($login_profile);

if(isset( $_REQUEST['login'])){
	
	$admin_system_package = $_REQUEST['login'];

	//security validation
	if(preg_match("/^[a-zA-Z]+$/", $admin_system_package) == 1) {

		$admin_system_package = htmlentities( urldecode($admin_system_package), ENT_QUOTES, 'utf-8' );  
		$login_design = $admin_system_package;

		if(!key_exists($login_design,$login_profile)){
            if($login_profile_count==1){
                foreach ($login_profile as $key=>$value){
                    header("location:".$dbT->getSystemURL('login',$key));
                    exit();
                }
            }else{
                foreach ($login_profile as $key=>$value){
                    header("location:".$dbT->getSystemURL('login',$key));
                    exit();
                }
            }
        }

	}
	else{
		$admin_system_package = '';
	}   
}else{
    if($login_profile_count==1){
        foreach ($login_profile as $key=>$value){
            header("location:".$dbT->getSystemURL('login',$key));
            exit();
        }
    }else{
        foreach ($login_profile as $key=>$value){
            header("location:".$dbT->getSystemURL('login',$key));
            exit();
        }
    }
}

$message_functions = new message_functions($admin_system_package);

	 $login_main_url = $dbT->getSystemURL('login',$login_design);
	 $reset_main_url = $dbT->getSystemURL('reset_pwd',$login_design);
	 $reset_admin_main_url = $dbT->getSystemURL('reset_admin',$login_design);	
	 $veri_login = $dbT->getSystemURL('verification',$login_design);	

	
if(strlen($admin_system_package) < 1){
     $admin_system_package = $package_functions->getAdminPackage();
}

$camp_layout = $package_functions->getSectionType("CAMP_LAYOUT", $admin_system_package);

if(strlen($camp_layout) < 1){
    $admin_system_package = $package_functions->getAdminPackage();
    $camp_layout = $package_functions->getSectionType("CAMP_LAYOUT", $admin_system_package);
}

$login_logo_position = $package_functions->getSectionType("LOGIN_LOGO_POSI", $admin_system_package);
$login_title_position = $package_functions->getSectionType("LOGIN_TITLE_POSI", $admin_system_package);


            $key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_THEME_COLOR'";

            $key_result=$dbT->selectDB($key_query);

            foreach( $key_result['data'] as $row ){
                $camp_theme_color = $row['settings_value'];

            }

            
            ?>

        

        <?php 
                require_once 'layout/'.$camp_layout.'/login_index.php';

         ?>
                <style>


        

        .dropdown-menu li>a:hover, .dropdown-menu .active>a, .dropdown-menu .active>a:hover { background:<?php echo $camp_theme_color; ?>;}
        <?php 
            
            if($camp_layout=="COX"){
         ?>


        input.error:focus{
            border: 1px solid #D3544C !important;
            box-shadow: 0 0 5px #e29e9a !important;
            outline: initial !important;
        }

         input.error{
            background-color: #fbeeed !important;
            border: 1px solid #D3544C!important;
         }
         .btn-primary {
            background: #03406A !important;
        /*     background: -webkit-gradient(linear,0 0,0 bottom,from(#2757a7),to(#3264b7)) !important; */
            margin-bottom: 2px;
        }
        .btn-primary:hover {
            background: #03406A !important;
            /* background: -webkit-gradient(linear,0 0,0 bottom,from(#2757a7),to(#3264b7)) !important; */
        }

         select:focus,input:focus {
                border: 1px solid #146ea6 !important;
                box-shadow: 0 0 5px #146ea6 !important;
            }
         .error{
            background: #fbeeed !important;
            
         }
        /* form:not(.not_index) .error-wrapper:not(.submit-error){
            background: none !important;
            border: none !important;
            display: block !important;
            padding:5px 2px 5px 10px;
            margin-left: 0px !important;
            position: static !important;
            text-indent:0;
            color:#000;
            vertical-align:top;
            min-width: 10px !important;
            box-sizing:border-box;
            -moz-box-sizing:border-box;
            -webkit-box-sizing:border-box
            }

        form:not(.not_index) .error-wrapper p{
            background:url('layout/COX/img/error.png') 0 0 no-repeat;
            padding:0 5px 0 31px;
            margin-bottom:0
        } */
		
		
        .navbar-inner {
            padding: 7px 0;

            background: linear-gradient(#045690,#0679ca) repeat 0 0 rgba(0,0,0,0) !important;

            -moz-border-radius: 0;
            -webkit-border-radius: 0;
            border-radius: 0;
        }   
        body {
            color: #252525 !important;
            background: #fff !important;
        }  
        .clearfix{
            border-radius: 0px !important;
            background: #f1f1f1 !important;  
        }
        .btn-success{
            background: #03406a !important;/* 
            background: -webkit-gradient(linear,0 0,0 bottom,from(#2757a7),to(#3264b7)) !important; */
            margin-bottom: 2px;
        }
        .btn-success:hover{
            background: #03406a !important;/* 
            background: -webkit-gradient(linear,0 0,0 bottom,from(#2757a7),to(#3264b7)) !important; */
        }  
        .username-field {
            background: #fdfdfd ;
            border-radius: 3px;
            box-shadow: initial !important;
        }
        .password-field {
            background: #fdfdfd ;
            border-radius: 3px;
            box-shadow: initial !important;
        }
        .login-fields input {
            padding: 11px 15px 10px 10px !important;
        }
        form > a{
                color: #2757a7!important;
        }
        .login-fields input {
            width: 302px;
        }
        
         .login-fields select {
         	background: url(layout/COX/img/form-fields-biz.png) 0 -37px no-repeat,url(layout/COX/img/form-fields-biz.png) 100% 0 no-repeat;
			-webkit-appearance: none;
			-moz-appearance: none !important;           
            width: 330px;
            height: 37px;
        }
		 select.login-fields_f  {
         	background: url(layout/COX/img/form-fields-biz.png) 0 -37px no-repeat,url(layout/COX/img/form-fields-biz.png) 100% 0 no-repeat;
			-webkit-appearance: none;
			-moz-appearance: none !important;           
            width: 300px;
            height: 37px;
        }
        @media (max-width: 768px) {
            .login-fields input {
                width: 100%;
            }
            
            .login-fields select {
                width: 100%;
            }
            .account-container{
                width: 380px;
            }
            .login-actions button{
                width: 100%;
            }
            .container{
                text-align: center;
            }
        }

        input[type="text"], input[type="tel"], input[type="password"], textarea {
            border-radius: 0px !important;
          /*  background-color: #ffffff;*/
            box-shadow: inset 0 1px 1px rgba(0,0,0,.4);
            -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,.4);
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.4);
        }

        .account-container{
            box-shadow: none !important;
            border: none !important;
            -webkit-border-radius: 0px !important;
            border-radius: 0px !important;
            margin-top: 25px !important;
        }

        .login-fields label{
                display: block !important;
                font-size: 14px !important;
                margin-bottom: 15px !important;
                font-weight: bold !important;
        }
        .login-fields input[type="text"], input[type="tel"], input[type="password"], textarea {
            border: 1px solid #979798 ;
            padding-top: 8px !important;
            padding-bottom: 7px !important;
            box-sizing: border-box;
            -moz-box-sizing:border-box;
            -webkit-box-sizing:border-box;
            height: 100%;
        }

        input[type="text"]::-webkit-input-placeholder,input[type="password"]::-webkit-input-placeholder { /* Chrome/Opera/Safari */
          font-size: 15px !important;
        }
        input[type="text"]::-moz-placeholder,input[type="password"]::-moz-placeholder { /* Firefox 19+ */
          font-size: 15px !important;
        }
        input[type="text"]:-ms-input-placeholder,input[type="password"]:-ms-input-placeholder { /* IE 10+ */
          font-size: 15px !important;
        }
        input[type="text"]:-moz-placeholder,input[type="password"]:-moz-placeholder { /* Firefox 18- */
          font-size: 15px !important;
        }


        .login-actions button{
            font-weight: bold !important;
            float: left !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        .account-container a{
            font-weight: bold !important;
            cursor: pointer !important;
        }
        input[type="checkbox"]{
            position: absolute;
            width: 28px;
            height: 28px;
            overflow: hidden;
            margin: -3px 0 0;
            padding: 0;
            outline: 0;
            opacity: 0;
        }
   

        input[type="checkbox"] + label::before{
                background-position: 0 -238px;
        }

        input[type="checkbox"] + label::before{
                display: inline-block;
                width: 39px;
                height: 39px;
                margin: -6px 9px -6px -6px;
                background-position: 0 -238px;
                background-repeat: no-repeat;
                content: " ";
                vertical-align: top;
        }

        input[type="checkbox"]:checked + label::before{
                background-position: 0 -358px;
        }

        btn[disabled], .btn:disabled {
            background-color: #dadadc !important;
            color: #979798 !important;
            font-size: 16px !important;
        }
                
         <?php }else{ ?>

        .navbar-inner {
            padding: 7px 0;

            background: <?php echo $camp_theme_color; ?> !important;

            -moz-border-radius: 0;
            -webkit-border-radius: 0;
            border-radius: 0;
        }
        <?php } ?>
    </style>
    
    </head>
    
    <body>

<div class="navbar navbar-fixed-top">

    <div class="navbar-inner">

        <div class="container">

        <?php


        $key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_LOGO'";

        $key_result=$dbT->selectDB($key_query);
        foreach( $key_result['data'] as $row ){
            $logo2 = $row['settings_value'];
        }


        if($login_logo_position=="header_left"){

        if(isset($logo2) && $logo2 != "") {

            if(file_exists("image_upload/welcome/".$logo2)){ 

                ?>

                 <img src="<?php echo $global_base_url; ?>/image_upload/welcome/<?php echo $logo2; ?>" border="0" style="max-height:50px;" />


            <?php }
        }
            }else{ ?>

            <a class="brand" href="">
                <?php echo $dbT->setVal("login_title","ADMIN"); ?>
            </a>

            <?php } ?>

           



            </div><!--/.nav-collapse -->

        </div> <!-- /container -->

    </div> <!-- /navbar-inner -->

</div> <!-- /navbar -->


<div class="container">

<?php if ($script!="index") {



	?>

	<a class="back" href="<?php echo $login_main_url; ?>" class="" style="font-size: 16px; font-weight: 600; color: #0679CA;float:left; margin-top: 8px; position: relative;">
	< Back
	</a>
	<?php 
}

?>

</div>