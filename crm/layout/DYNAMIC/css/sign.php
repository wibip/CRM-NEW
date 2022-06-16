<?php
   

    header("Content-type: text/css; charset: UTF-8"); //important

   // require_once('../../../db/config.php');
    require_once '../../../classes/dbClass.php';
    $db = new db_functions();
    

    $login_design = $_GET["product_id"];

    $get_product_id_q="SELECT `options` FROM `admin_product_controls` WHERE `product_code`='$login_design' AND `feature_code`='DEFAULT_PROFILE'";

    $get_product_id=$db->select1DB($get_product_id_q);
    //$get_product_id = mysql_fetch_assoc($get_product_id_res);
    $prod_id = $get_product_id['options'];


    $q = "SELECT * FROM `admin_product_controls_custom` WHERE `product_id` = '$prod_id'";
    $query_results=$db->selectDB($q);

    $row_count = $query_results['rowCount'];

    if($row_count > 0) {

        //$result = mysql_fetch_array($query_results);
        foreach ($query_results['data'] AS $result) {
            $custom_data = json_decode($result['settings'],true); 
        }
       

        $main_color = $custom_data['branding']['PRIMARY_COLOR']['options'];
        $secondary_color = $custom_data['branding']['SECONDARY_COLOR']['options'];
        $logo_image_url = $custom_data['branding']['LOGO_IMAGE_URL']['options'];

        list($r, $g, $b) = sscanf($main_color, "#%02x%02x%02x");

        if (($r*0.299 + $g*0.587 + $b*0.114) > 186){
            $font_color = "#000";
        }else{
            $font_color = "#fff";
        }
        

    }else{
      
        $main_color = "#23002a";//sweetbay-#23002a
        $secondary_color = "#b21c24";
        $logo_image_url = '../img/sample-logo.png';
        $font_color = "#fff";
                   
    }


    $navbarColor = $main_color;
    $btnPrimary_color = $main_color;
    $btnPrimary_color_hover = $main_color;    
    $linkColor = "#333333";
    $linkColor_hover = "#333333";

    

?>

font b{
    color: #000 !important;
}

#password-strength-meter, #password-strength-text, i[data-bv-icon-for="password"]{
  display: none !important;
}

.widget .widget-header{
    background: #000000 !important;
}

.widget .widget-header h3{
    color: #ffffff !important;
}
.logo-top-img{
	background: url(<?php echo $logo_image_url; ?>);
    background-repeat: no-repeat;
    white-space: nowrap;
    text-indent: -9999px;
    height: 60px;
    background-size: contain;
    background-position: 50% 10%;
    position: relative;
    display: block;
	padding: 8px 20px 12px; 
	width:185px;
	margin: auto;
    margin-top: 20px;
    /* background: url(../img/logo.png); 
    width: 200px;
    position: absolute;
    text-align: center;
    top: 30px;
    font-weight: bold;
    font-size: 17px;
    background-size: 100%;
    left: 50%;
    color: #58595b;
    background-repeat: no-repeat;
    margin-left: -100px; */
}

.hideH{
    display: none;
}
.verification .logo-top-img::after {
    content: "ACTIVATE ACCOUNT"
}

.reset_pwd .logo-top-img::after,
.reset_pwd_admin .logo-top-img::after {
    content: "RESET PASSWORD"
}

.reset_pwd .content,
.reset_pwd_admin .content,
.verification .content{
    padding-top: 60px !important;
}

/* .logo-top-img::after {
    content: "SIGN IN"
} */
body{
        background: #ffffff !important;
    font-family: Open Sans !important;
}

.logo-center{
        display: none;
}

.navbar .brand{
        background: url(<?php echo $logo_image_url; ?>);
        background-repeat: no-repeat;
        width: 185px;
        white-space: nowrap;
        text-indent: -9999px;
        height: 60px;
        background-size: contain;
        background-position: center;
}

.account-container{

	  margin: 20px auto 0 auto !important;
	  background-color: #fff !important;
	  width: 365px !important;
	  box-shadow: 4px 6px 9px 0px #dadada, inset 0px -3px 0px #e6e6e6 !important;
	  border: 1px solid #c9c9c9 !important;
	  border-radius: 0px;
	  position: relative;
	  -webkit-border-radius: 0px;
	  -moz-border-radius: 0px;
	  -ms-border-radius: 0px;
	  -o-border-radius: 0px;
}



.navbar-fixed-top .navbar-inner{
      background: <?php echo $navbarColor; ?> !important;
      -webkit-box-shadow: none !important;
      box-shadow: none !important;
      height: 80px;
      padding: 10px 0 !important;
}

/*.navbar-fixed-top::after{
    background-image: url(../img/color-bar.svg);
    background-repeat: no-repeat;
    background-size: cover;
    height: 10px;
    content: "";
    position: absolute;
    width: 100%;
}*/

 .navbar-fixed-top{ 
  display: none;
} 
.login-fields input:not([type=radio]){
        background-color: #fff !important;
    border: 1px solid #ccc !important;
    box-shadow: 2px 3px 2px -2px rgba(0, 0, 0, .08) inset !important;
        padding: 7px 10px 7px 10px !important;
        background-image: none !important;
              width: 100% !important;
    box-sizing: border-box;
    height: 40px;
}


.login-fields label{
    display: block !important;
    font-weight: normal;
    font-size: 14px;
    color: #191919;
}

.btn-primary{
    background-color: <?php echo $btnPrimary_color; ?> !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    font-family: Open Sans;
    height: 45px;
    font-size: 15px !important;
    font-weight: 400;
    padding-top: 4px !important;
    padding-bottom: 4px !important;
    width: 100%;
    color: <?php echo $font_color; ?>;

}

.btn-primary font{
  color: <?php echo $font_color; ?>;
}

.btn-primary[name="submitverify"]{
    width: auto
}

.btn-primary:hover{
    background-color: <?php echo $btnPrimary_color_hover; ?> !important;
    background-position: unset !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;

}

.login-actions .btn{
    float: left;
}

input, textarea, select, .uneditable-input{
    border: 1px solid #8c8c8c !important;
}

a {
    color: <?php echo $linkColor; ?> !important;
    font-weight: 500 !important;
    font-size: 14px !important;
    font-family: Open Sans;
}

a:hover{
    color: <?php echo $linkColor_hover; ?> !important;
}

.navbar .container {
    margin-left: 30px ;
    margin-right: 100px ;
    width: auto !important;
}

.content {
    padding: 25px !important;
    background: #fff;
} 


.password-strength-main{
	width: 96%;
 	background-color: rgba(0, 0, 0, 0.1);
  	height: 7px;
	}

@media (max-width: 979px){
  .navbar .container {
      padding: 5px !important;
      margin: 0px !important;
  }

  .navbar-fixed-top .navbar-inner{
      height: 90px;
      padding: 00px 0 !important;
  }

  .navbar .brand{
    
  }
}


@media (max-width: 480px){
.account-container {
    width: 100% !important;
    margin-top: 35px;
}
.login-fields input:not([type=radio]){
  width: 100% !important;
}
.navbar .brand{
    width: 70px;
    height: 60px;
    margin-left: 6px;
}
.navbar-fixed-top::after{
    display: none;
}
}

/*
	
@media (max-width: 380px) {
   .password-strength-main{
	width: 100% !important;
	
	}
}

@media (max-width: 768px) {
   .password-strength-main{
	width: 45% ;
	
	}
}
*/



