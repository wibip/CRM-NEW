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

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);



/*classes & libraries*/

require_once 'classes/dbClass.php';
require_once 'classes/appClass.php';
require_once 'classes/systemPackageClass.php';
require_once 'classes/dbApiClass.php';

$db = new db_functions();
$app = new app_functions();
$api_db = new api_db_functions();
$pack_func = new package_functions();
$base_url = trim($db->setVal('portal_base_url','ADMIN'),"/");



$base_portal_folder = trim($db->setVal('portal_base_folder','ADMIN'),"/");
$camp_base_url = trim($db->setVal('camp_base_url','ADMIN'),"/");

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


if(isset($_POST['theme_submit']) || isset($_POST['theme_update'])){
	$template_name = str_replace("'", "&#39;", $_POST['template_name']);
}else{

	$theme_data_set_for_img = $db->getTheme($_GET['id'],$_GET['lan']);
	$template_name =$theme_data_set_for_img[0]['template_name'];
}
///original theme Image Folder//
//$original_bg_Image_Folder=$base_portal_folder.'/assets/img/backgrounds/';
//$original_logo_Image_Folder=$base_portal_folder.'/assets/img/logo/';

$original_bg_Image_Folder=$base_portal_folder.'/template/'.$template_name.'/gallery/bg/';
$original_logo_Image_Folder=$base_portal_folder.'/template/'.$template_name.'/gallery/logo/';



//theme temp image folder///
$temp_Ads_Image_Folder=$base_portal_folder.'/ads/temp/';


?>


<head>

<meta charset="utf-8">

<title>Guest Wi-Fi - Theme</title>



<meta name="viewport"
content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="plugins/img_upload/croppic.js?v=4"></script>
<link href="plugins/img_upload/assets/css/croppic.css" rel="stylesheet">
<link href="css/bootstrap2-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/tablesaw.css">
<link href="css/bootstrap-colorpicker.css?v=19" rel="stylesheet">

<script src="js/bootstrap2-toggle.min.js"></script>

<style type="text/css">

	 #gradx_slider_controls{
   			display: none;
 	}
	@media screen and (max-width: 980px){

		form .bubble-pointer:before, form .bubble-pointer:after{
			display: none !important;
		}
	}

  #slideshow #yourId {
    border-radius: 16px;
    border: 2px solid #b9b6b6;
    border-top-right-radius: 0px;
      width: 150px;
      height: 208px;
      margin-top: 15px;
      position:relative; /* or fixed or absolute */
    }

 #slideshow input[type="radio"]:checked + label .croppedImg {
    width: 146px  !important;
    margin-top: -3px !important;
    margin-left: -1px !important;
  }
  #slideshow input[type="radio"] + label .croppedImg {
    width: 150px !important;
    margin-top: 0px !important;
    margin-left: 0px !important;
    }
 #slideshow .cropImgWrapper img, #slideshow .cropControlsCrop + img{
    border: none !important;
  }

  #slideshow .yourId_imgUploadForm{
    position: absolute;
  }

    #slideshow1 #yourId2 {
    border-radius: 16px;
    border: 2px solid #b9b6b6;
    border-top-right-radius: 0px;
      width: 150px;
      height: 75px;
     /*  margin-top: 11px;
	  position:absolute; */ /* or fixed or absolute */
	  margin-top: 15px;
    position: relative;
    }

	#slideshow1 input[type="radio"] + label .croppedImg {
    margin-top: 0px !important;
    margin-left: 0px !important;
    }

	#slideshow1 .cropImgWrapper img, #slideshow1 .cropControlsCrop + img{
    border: none !important;
  }

  #slideshow1 .yourId2_imgUploadForm{
    position: absolute;
  }






      #logo1_up  {
    border: 2px solid #b9b6b6;
    border-top-right-radius: 0px;
      width: 193px;
      height: 71px;
      margin-top: 0px;
      position:sticky; /* or fixed or absolute */
      background-image: url("plugins/img_upload/assets/img/uploadcackg.jpg");
    }

     #logo1_up_bc  {
    border: 2px solid #b9b6b6;
    border-top-right-radius: 0px;
      width: 300px;
      height: 150px;
      margin-top: 0px;
      position:sticky; /* or fixed or absolute */
      background-image: url("plugins/img_upload/assets/img/uploadcackg.jpg");
    }

    @media (max-width: 480px){
		 #logo1_up_bc  {
		 	width: 220px;
		 }
	}

       #logo2_up  {
    border: 2px solid #b9b6b6;
    border-top-right-radius: 0px;
      width: 200px;
      height: 114px;
      margin-top: 0px;
      position:sticky; /* or fixed or absolute */
      background-image: url("plugins/img_upload/assets/img/uploadcackg.jpg");
    }

	input[type="radio"] + label .croppedImg {
    margin-top: 0px !important;
    margin-left: 0px !important;
    }

	.cropImgWrapper img, .cropControlsCrop + img{
    border: none !important;


  }

  #logo1_up_bc .croppedImg{

  width:300px;

  }


  .logo1_up_imgUploadForm{
    position: absolute;
  }

    .logo1_up_bc_imgUploadForm{
    position: absolute;
  }

    .logo2_up_imgUploadForm{
    position: absolute;
  }


</style>


<style type="text/css">


#logo1_up .cropControls{

position:absolute !important;
float:right;

}

#logo2_up .cropControls{

position:absolute !important;
float:right;

}

#logo1_up_bc .cropControls{

position:absolute !important;
float:right;

}

#logo1_up,#logo2_up,#logo1_up_bc{

position:relative;
display:inline-block;

}


</style>

<!--Alert message -->
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<!--<link href="css/bootstrap-toggle.min.css" rel="stylesheet">  -->
<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<!-- Alert messages -->
<script type="text/javascript">

$(document).ready(function() {

	$("#theme_submit").easyconfirm({locale: {
		title: 'Theme Creation',
		text: 'Are you sure you want to create this theme?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }});

	$("#theme_submit").click(function(event) {

	        $("#verticle_img_invalid_msg").hide();
	        if ($('#varimg').css('display') == 'none'){
		    	try{
		    		document.getElementById("verticle_img").required = false;
		    		}catch(e){
		    		}
		        }

	        if ($('#horimg').css('display') == 'none'){

		    	try{
		    		document.getElementById("horizontal_img").required = false;
		    		}catch(e){

		    		}

		        }



			    if ($('#backimg').css('display') == 'none' && !$('#logo_txt1_enable').is(":checked")) {

			    	try{
			    		document.getElementById("image_1_name").required = false;
			    		}catch(e){

			    		}


			       // alert('none');
			    }else{

			    	try{
			    		document.getElementById("image_1_name").required = true;
			    		}catch(e){

			    		}


			    	//alert('display');

				    }


			    if ($('#logoimg').css('display') == 'none' && !$('#logo_txt2_enable').is(":checked")) {



			    	try{
			    		document.getElementById("image_2_name").required = false;
			    		}catch(e){

			    		}
			       // alert('none');
			    }else{


			    	try{
				    	document.getElementById("image_2_name").required = true;
			    		}catch(e){

			    		}


			    	//alert('display');

				    }


        if($('.hide_rad:checked').length == 0 && $('#varimg').css('display') != 'none'){


	    	try{
		    	document.getElementById("image_2_name").required = true;
	    		}catch(e){

	    		}
            event.preventDefault();
            $("#verticle_img_invalid_msg").show();

        }

	});







	$("#theme_update").easyconfirm({locale: {

		title: 'Theme Update',

		text: 'Are you sure you want to update this theme?',

		button: ['Cancel',' Confirm'],

		closeText: 'close'

	     }});

	$("#theme_update").click(function() {


        if ($('#varimg').css('display') == 'none'){

	    	try{
	    		document.getElementById("verticle_img").required = false;
	    		}catch(e){

	    		}

	        }

        if ($('#horimg').css('display') == 'none'){

	    	try{
	    		document.getElementById("horizontal_img").required = false;
	    		}catch(e){

	    		}

	        }


		setTimeout(function(){

		    if ($('#backimg').css('display') == 'none' && !$('#logo_txt1_enable').is(":checked")) {

		    	try{
		    		document.getElementById("image_1_name").required = false;
		    		}catch(e){

		    		}


		       // alert('none');
		    }else{

		    	//document.getElementById("image1").required = true;
		    	//alert('display');

			    }


		    if ($('#logoimg').css('display') == 'none' && !$('#logo_txt2_enable').is(":checked")) {

		    	try{
		    		document.getElementById("image_2_name").required = false;
		    		}catch(e){

		    		}


		       // alert('none');
		    }else{

		    	//document.getElementById("image2").required = true;
		    	//alert('display');

			    }


		}, 500);




	});





	$("#campign_update_cancel").easyconfirm({locale: {

		title: 'Theme Update Cancel',

		text: 'Are you sure you want to cancel this theme update?',

		button: ['No',' Yes'],

		closeText: 'close'

	     }});

	$("#campign_update_cancel").click(function() {

	//relaod current page//

	window.location.href = "theme.php?active_tab=active_theme";

	});





	 });

</script>







<style type="text/css">

    .verticle_img_invalid_msg:before{
        content: "";
        position: absolute;
        border-style: solid;
        border-width: 7px 14px 7px 0;
        border-color: transparent #d8544c;
        display: block;
        width: 0;
        left: -15px;
        top: 9px;
        bottom: auto;
    }
    .verticle_img_invalid_msg{
        background: #fbeeed;
        border: 1px solid #d8544c;
        display: inline-block;
        padding: 5px 2px 5px 10px;
        margin-left: 22px;
        position: absolute;
        text-indent: 0;
        color: #000;
        vertical-align: top;
        min-width: 210px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        z-index: 99 !important;
    }
    .verticle_img_invalid_msg p{
        background: url(layout/COX/img/error.png) 0 0 no-repeat;
        padding: 0 5px 0 31px;
        margin-bottom: 0;
    }

	.device-node {

	color: #FFFFB9;

	float: left;

	margin: 0 30px 30px 0;

	padding: 10px;

	-webkit-border-radius: 8px;

	border-radius: 8px;

	-webkit-box-shadow: 2px 2px 6px #333;

	box-shadow: 2px 2px 6px #333;

	background: #333;

}



</style>



<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

<!--[if lt IE 9]>

      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->



    <!--table colimn show hide-->
    <script type="text/javascript" src="js/tablesaw.js"></script>
    <script type="text/javascript" src="js/tablesaw-init.js"></script>


    <style type="text/css">



	label.filebutton {

		-moz-box-shadow:inset 1px 0px 0px 0px #000000;
		-webkit-box-shadow:inset 1px 0px 0px 0px #000000;
		box-shadow:inset 1px 0px 0px 0px #000000;
		background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #000000), color-stop(1, #030101));
		background:-moz-linear-gradient(top, #000000 5%, #030101 100%);
		background:-webkit-linear-gradient(top, #000000 5%, #030101 100%);
		background:-o-linear-gradient(top, #000000 5%, #030101 100%);
		background:-ms-linear-gradient(top, #000000 5%, #030101 100%);
		background:linear-gradient(to bottom, #000000 5%, #030101 100%);
		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#000000', endColorstr='#030101',GradientType=0);
		background-color:#000000;
		-moz-border-radius:4px;
		-webkit-border-radius:4px;
		border-radius:4px;
		border:1px solid #000000;
		display:inline-block;
		cursor:pointer;
		color:#ffffff;
		font-family:arial;
		font-size:15px;
		font-weight:bold;
		padding:5px 6px;
		text-decoration:none;
		text-shadow:0px 1px 0px #000000;

	}

	label.filebutton:hover {

		background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #030101), color-stop(1, #000000));
		background:-moz-linear-gradient(top, #030101 5%, #000000 100%);
		background:-webkit-linear-gradient(top, #030101 5%, #000000 100%);
		background:-o-linear-gradient(top, #030101 5%, #000000 100%);
		background:-ms-linear-gradient(top, #030101 5%, #000000 100%);
		background:linear-gradient(to bottom, #030101 5%, #000000 100%);
		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#030101', endColorstr='#000000',GradientType=0);
		background-color:#030101;

	}

	label.filebutton:active {

		position:relative;
		top:1px;

	}


label.filebutton_disabled {

		background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #CFCFCF), color-stop(1, #CFCFCF));
		background:-moz-linear-gradient(top, #CFCFCF 5%, #CFCFCF 100%);
		background:-webkit-linear-gradient(top, #CFCFCF 5%, #CFCFCF 100%);
		background:-o-linear-gradient(top, #CFCFCF 5%, #CFCFCF 100%);
		background:-ms-linear-gradient(top, #CFCFCF 5%, #CFCFCF 100%);
		background:linear-gradient(to bottom, #CFCFCF 5%, #CFCFCF 100%);
		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#CFCFCF', endColorstr='#CFCFCF',GradientType=0);
		background-color:#CFCFCF;
		-moz-border-radius:4px;
		-webkit-border-radius:4px;
		border-radius:4px;
		display:inline-block;
		cursor:default;
		color:#252525;
		font-family:arial;
		font-size:15px;
		font-weight:bold;
		padding:5px 6px;
		text-decoration:none;


	}

	label.filebutton_disabled:hover {
		background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #CFCFCF), color-stop(1, #CFCFCF));
		background:-moz-linear-gradient(top, #CFCFCF 5%, #CFCFCF 100%);
		background:-webkit-linear-gradient(top, #CFCFCF 5%, #CFCFCF 100%);
		background:-o-linear-gradient(top, #CFCFCF 5%, #CFCFCF 100%);
		background:-ms-linear-gradient(top, #CFCFCF 5%, #CFCFCF 100%);
		background:linear-gradient(to bottom, #CFCFCF 5%, #CFCFCF 100%);
		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#CFCFCF', endColorstr='#CFCFCF',GradientType=0);
		background-color:#030101;

	}


	label span input {
	    z-index: 999;
	    line-height: 0;
	    font-size: 50px;
	    position: absolute;
	    top: -2px;
	    left: -700px;
	    opacity: 0;
	    filter: alpha(opacity = 0);
	    -ms-filter: "alpha(opacity=0)";
	    cursor: pointer;
	    _cursor: hand;
	    margin: 0;
	    padding:0;
	}

</style>

<?php

require_once('db/config.php');

include 'header.php';

$hide_divs_gene = $pack_func->getOptions('THEME_DIV_HIDE',$system_package);
$hide_divs_gene_arr = explode(",",$hide_divs_gene);

//check passcode

$pass_type_q=mysql_query("SELECT * FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `voucher_status`=1");

while($pass_type_q_row=mysql_fetch_array($pass_type_q)){

	$voucher_number = $pass_type_q_row['voucher_number'];
	$pass_type = $pass_type_q_row['type'];
}

if($pass_type=='Auto'){
	$pass_type = 'Automated Passcode';
}
else{
	$pass_type = 'Manual Passcode';
}

?>


<style type="text/css">

#loading1 {
  width: 100%;
  height: 100%;
  top: 0px;
  left: 0px;
  position: fixed;
  display: none;
  opacity: 0.8;
  background-color: #fff;
  z-index: 99;
  text-align: center;
}

#loading-image {
  position: absolute;
  top: 45%;
  left: 50%;
  z-index: 100;
}
</style>
    <style>

        #slideshow{
            margin:0 auto;
            width:680px;
			height:260px;
			margin-top: 30px;
            overflow: hidden;
            position: relative;

        }

        #slideshow ul{
            list-style: none;
            margin:0;
            padding:0;
            position: absolute;
        }

        #slideshow li{
            float:left;
        }

        #slideshow a:hover{
            background: rgba(0,0,0,0.8);
            border-color: #000;
        }

        #slideshow a:active{
            background: #990;
        }

        .slideshow_prev, .slideshow_next{
            position: absolute;
            top:120px;
            font-size: 30px;
            text-decoration: none;
            color:#fff;
            background: rgba(0,0,0,0.5);
            padding: 5px;
            z-index:2;
        }

        .slideshow_prev{
            left:0px;
            border-left: 3px solid #fff;
        }

        .slideshow_next{
            right:0px;
            border-right: 3px solid #fff;
        }

        #slideshow1{
            margin:0 auto;
            width:680px;
			height:150px;
			margin-top: 30px;
            overflow: hidden;
            position: relative;

        }

        #slideshow1 ul{
            list-style: none;
            margin:0;
            padding:0;
            position: absolute;
        }

        #slideshow1 li{
            float:left;
        }

        #slideshow1 a:hover{
            background: rgba(0,0,0,0.8);
            border-color: #000;
        }

        #slideshow1 a:active{
            background: #990;
        }

        .slideshow_prev1, .slideshow_next1{
            position: absolute;
            top:30px;
            font-size: 30px;
            text-decoration: none;
            color:#fff;
            background: rgba(0,0,0,0.5);
            padding: 5px;
            z-index:2;
        }

        .slideshow_prev1{
            left:0px;
            border-left: 3px solid #fff;
        }

        .slideshow_next1{
            right:0px;
            border-right: 3px solid #fff;
        }
    </style>

<div id="loading1">
  <img  id="loading-image" src="img/loading_ajax.gif" alt="Loading..." />
</div>
<script language="javascript" type="text/javascript">
  $(window).load(function() {
    $('#loading1').hide();

  });

</script>



<?php







if(isset($_GET['active_tab'])){

    $active_tab = $_GET['active_tab'];

}else{

    $active_tab = "intro";

    if($new_design=='yes'){

    	$active_tab = "create_theme";
    }

}


//remove theme

if($_GET['remove']=="1"){
 $theme_id = $_GET['id'];
 $theme_name = urldecode($_GET['theme_name']);
 $active_tab = "active_theme";

 $q_ar= "INSERT INTO `exp_themes_archive` (
  `id`,
  `theme_id`,
  `theme_name`,
  `theme_type`,
  `splash_url`,
  `template_name`,
  `ref_id`,
  `location_ssid`,
  `distributor`,
  `language`,
  `language_string`,
  `title`,
  `registration_type`,
  `social_login_txt`,
  `manual_login_txt`,
  `welcome_txt`,
  `greeting_txt`,
  `toc_txt`,
  `loading_txt`,
  `welcome_back_txt`,
  `registration_btn`,
  `connect_btn`,
  `fb_btn`,
  `first_name_text`,
  `last_name_text`,
  `male_field`,
  `female_field`,
  `email_field`,
  `age_group_field`,
  `gender_field`,
  `manual_login_fields`,
   mobile_number_fields,
   other_fields,
  `login_name_field`,
  `login_secret_field`,
  `accept_text`,
  `cna_page_text`,
  `cna_button_text`,
  `btn_color`,
  `btn_color_disable`,
  `btn_border`,
  `btn_text_color`,
  `bg_color_1`,
  `bg_color_2`,
  `hr_color`,
  `theme_logo`,
  `theme_bg_image`,
  `theme_horizontal_image`,
  `theme_verticle_image`,
  `duotone_bg_color`, 
  `duotone_form_color`,
  `is_enable`,
  `create_date`,
  `last_update`,
  `updated_by`,
  `deleted_by`
)
SELECT
  `id`,
  `theme_id`,
  `theme_name`,
  `theme_type`,
  `splash_url`,
  `template_name`,
  `ref_id`,
  `location_ssid`,
  `distributor`,
  `language`,
  `language_string`,
  `title`,
  `registration_type`,
  `social_login_txt`,
  `manual_login_txt`,
  `welcome_txt`,
  `greeting_txt`,
  `toc_txt`,
  `loading_txt`,
  `welcome_back_txt`,
  `registration_btn`,
  `connect_btn`,
  `fb_btn`,
  `first_name_text`,
  `last_name_text`,
  `male_field`,
  `female_field`,
  `email_field`,
  `age_group_field`,
  `gender_field`,
  `manual_login_fields`,
   mobile_number_fields,
   other_fields,
  `login_name_field`,
  `login_secret_field`,
  `accept_text`,
  `cna_page_text`,
  `cna_button_text`,
  `btn_color`,
  `btn_color_disable`,
  `btn_border`,
  `btn_text_color`,
  `bg_color_1`,
  `bg_color_2`,
  `hr_color`,
  `theme_logo`,
  `theme_bg_image`,
  `theme_horizontal_image`,
  `theme_verticle_image`,
  `duotone_bg_color`, 
  `duotone_form_color`,
  `is_enable`,
  `create_date`,
  `last_update`,
  `updated_by`,
  '$user_name'
FROM
  `exp_themes`
WHERE
 `theme_id` ='$theme_id'";



 $archive_theme = mysql_query($q_ar);


 if ($archive_theme) {

$remove_q = mysql_query("DELETE FROM `exp_themes` WHERE `theme_id`='$theme_id'");
//echo "DELETE FROM `exp_themes` WHERE `theme_id`='$theme_id'";
 }
//echo mysql_affected_rows();
if(mysql_affected_rows()>0){
    $theme_rm_msg = $message_functions->showNameMessage('theme_remove_success',$theme_name);
    $_SESSION['msg1']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

               <strong>".$theme_rm_msg."</strong></div>";
}
else{
    $theme_rm_msg = $message_functions->showNameMessage('theme_remove_failed',$theme_name,'2003');
    $_SESSION['msg1']= "<div class='alert alert-fail'><button type='button' class='close' data-dismiss='alert'>×</button>

               <strong>".$theme_rm_msg."</strong></div>";
}

}


//////////////////////////import theme/////////////////////

if(isset($_POST['submit_import'])){



    $filename = $_FILES["zip_file"]["name"];

    $source = $_FILES["zip_file"]["tmp_name"];

    $type = $_FILES["zip_file"]["type"];



    $name = explode(".", $filename);

    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');

    foreach($accepted_types as $mime_type) {

        if($mime_type == $type) {

            $okay = true;

            break;

        }

    }



    $continue = strtolower($name[1]) == 'zip' ? true : false;

    if(!$continue) {

        $db->userErrorLog('2005', $user_name, 'script - '.$script);

        $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	<strong> [2005] Invalid theme file. Please try again</strong></div>";

        //$message = "The file you are trying to upload is not a .zip file. Please try again.";

    }

    else{





        /* PHP current path */

        $time = date("dmyhis");

        //$pa = explode(".", $filename);

        $path = $camp_base_url.'import/';

        $targetdir = 'import/'.$time.'/';  // target directory

        $filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)

        $filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)



        //var_dump($path.'<br>'.$targetdir);

        //$targetdir = $targetdir; // target directory

        $targetzip = $targetdir . $filename; // target zip file



        /* create directory if not exists', otherwise overwrite */

        /* target directory is same as filename without extension */

        if (is_dir($targetdir)){

            rmdir_recursive ($targetdir);

        }



        mkdir($targetdir, 0777);





        /* here it is really happening */



        if(move_uploaded_file($source, $targetzip)) {

            //exit();

            $zip = new ZipArchive();

            $x = $zip->open($targetzip);  // open the zip file to extract

            if ($x === true) {

                $zip->extractTo($targetdir); // place in the directory with same name

                $zip->close();



                //unlink($targetzip);

            }else {

                $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	<strong>There was a problem with the extract zip. Please try again</strong></div>";

                //$message = "There was a problem with the upload. Please try again.";

            }



            ///////////////////////////  check files are exist ////////////////



            $fi = new FilesystemIterator($targetdir.'/export/', FilesystemIterator::SKIP_DOTS);

            $files_count = iterator_count($fi);

            if($files_count == 4){



                if(is_file($targetdir."/export/master.xml")){  //master xml read and validation

                    $xml_master=simplexml_load_file($targetdir."/export/master.xml");

                    //print_r($xml_master);

                    $moduleType = $xml_master->moduleType;



                    if($moduleType == 'THEME'){

                        if(isset($_POST['location_ssid'])){

                            $xml_data = simplexml_load_file($targetdir."/export/data.xml");

                            $language = $xml_data->language;

                            $theme_logo = $xml_data->theme_logo;

                            $theme_bg_image = $xml_data->theme_bg_image;



                            $location_ssid_form = $_POST['location_ssid'];



                            //echo $registration_btn = $xml_data->registration_btn;

                            $language = $xml_data->language;

                            $br = mysql_query("SHOW TABLE STATUS LIKE 'exp_themes'");

                            $rowe = mysql_fetch_array($br);

                            $auto_increment = $rowe['Auto_increment'];

                            $theme_id_up = 'th_'.$language.'_'.$auto_increment;





                            /////////////////////////// Move Images /////////////////////////////////////

                            $base_portal_url = trim($db->setVal('portal_base_url','ADMIN'),"/");

                            $tmp_img_path = $targetdir.'export/';

                            $movepath_logo = $base_portal_url.'/assets/img/logo/';

                            $movepath_bg = $base_portal_url.'/assets/img/backgrounds/';





                            if(file_exists($movepath_logo.$theme_logo)!=1) {

                                $moveResult11 = rename($tmp_img_path.$theme_logo, $original_logo_Image_Folder.$theme_logo );

                                $moveResult22 = rename($tmp_img_path.$theme_bg_image, $original_bg_Image_Folder.$theme_bg_image );

                                //var_dump( $tmp_img_path . $theme_logo .'<br>'. $original_bg_Image_Folder.$theme_logo);

                            }

                            if($moveResult11 && $moveResult22) {



                                /////////////////////////// UPDATE Query /////////////////////////////////////

                                $str1 = "";

                                $str2 = "";

                                foreach($xml_data as $key => $value){

                                    //$$key = $value;

                                    if($key == 'id' || $key == 'last_update'){



                                    }

                                    else{

                                        $str1 .= $key.",";



                                        switch ($key) {

                                            case "theme_id" :

                                                $str2 .= "'".$theme_id_up."',";

                                                break;

                                            case "ref_id" :

                                                $str2 .= "'".$location_ssid_form."',";

                                                $ref_id_get = 1;

                                                break;

                                            case "theme_type" :

                                                $str2 .= "'MASTER_THEME',";

                                                $theme_type_get = 1;

                                                break;

                                            case "location_ssid" :

                                                $str2 .= "'',";

                                                break;

                                            case "language" :

                                                $str2 .= "'en',";

                                                break;

                                            case "distributor" :

                                                $str2 .= "'".$user_distributor."',";

                                                break;

                                            case "create_date" :

                                                $str2 .= "now(),";

                                                break;

                                            case "updated_by" :

                                                $str2 .= "'".$user_name."',";

                                                break;

                                            case "is_enable" :

                                                $str2 .= "'0',";

                                                break;

                                            default:

                                                $str2 .= "'".$value."',";



                                        }

                                    }

                                }



                                // 2015-9-8 SSID + Language combination change to the GROUP TAG

                                if($ref_id_get != 1){

                                    $str1 .= "ref_id,";

                                    $str2 .= "'".$location_ssid_form."',";

                                }

                                if($theme_type_get != 1){

                                    $str1 .= "theme_type,";

                                    $str2 .= "'MASTER_THEME',";

                                }



                                //echo $welcome_back_txt;

                                $query = "REPLACE INTO `exp_themes` (".trim($str1,',').") VALUES (".trim($str2,',').")";

                                $result = mysql_query($query);



                                if($result){

                                    $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	                <strong>Theme successfully uploaded</strong></div>";

                                }else{

                                    $db->userErrorLog('2001', $user_name, 'script - '.$script);

                                    $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	                <strong> [2001] There was a problem with the uploaded module. Please try again with THEME module</strong></div>";

                                }

                            }else{

                                $db->userErrorLog('2005', $user_name, 'script - '.$script);

                                $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	                <strong> [2005] There was a problem with the uploaded images. Please try again</strong></div>";

                            }



                        }



                    }else{

                        $db->userErrorLog('2008', $user_name, 'script - '.$script);

                        $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	        <strong> [2008] There was a problem with the uploaded module. Please try again with correct THEME module</strong></div>";

                    }

                }else{

                    $db->userErrorLog('2007', $user_name, 'script - '.$script);

                    $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	    <strong> [2007] Some files are missing. Please try again</strong></div>";

                }

            }else{

                $db->userErrorLog('2007', $user_name, 'script - '.$script);

                $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	<strong> [2007] Some files are missing. Please try again</strong></div>";

                //$message = "Your .zip file was uploaded and unpacked.";



            }



        } else {

            $db->userErrorLog('2005', $user_name, 'script - '.$script);

            $_SESSION['msg_up'] = "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	<strong> [2005] There was a problem with the upload. Please try again</strong></div>";

            //$message = "There was a problem with the upload. Please try again.";

        }

        //var_dump($targetdir);

        //exit();



        ////////////////////////////// delete content of import dir ///////////////////////

        $del_dir_cont = $app->deleteDirContent($targetdir);

    }







}



//////////////////////// add language for themes - back ///////////////////////////////////

if(isset($_GET['cansel'])){

    if($_GET['token'] == $_SESSION['FORM_SECRET_THEME']){

        $active_tab = 'active_theme';

    }else{

        $active_tab = "intro";

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $_SESSION['intro']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong> [2004] Transaction has failed</strong></div>";

        if($new_design=='yes'){
    	
    		$active_tab = "create_theme";

    		$_SESSION['create_theme'] = $_SESSION['intro'];
    	}

    }



}





//////////////////////// add language for themes - view part///////////////////////////////////

if(isset($_GET['add_new_lan'])){

    if($_GET['token'] == $_SESSION['FORM_SECRET_THEME']){

        $id_theme_lan = $_GET['id'];

        $new_tab = 'view';

        $active_tab = 'lan_view';

    }else{

        $active_tab = "intro";

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $_SESSION['intro']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong> [2004] Transaction has failed</strong></div>";

        if($new_design=='yes'){
    	
    		$active_tab = "create_theme";
    		$_SESSION['create_theme'] = $_SESSION['intro'];

    	}

    }



}





//////////////////////// add language for themes - add new language part///////////////////////////////////

if(isset($_GET['new_lan'])){

    if($_GET['token'] == $_SESSION['FORM_SECRET_THEME']){

        $id_theme_lan_master = $_GET['new_lan_id'];

        $new_tab = 'add';

        $active_tab = 'lan_add';

        $modify_mode_lan =0;

    }else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $active_tab = "intro";

        $_SESSION['intro']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong> [2004] Transaction has failed</strong></div>";

        if($new_design=='yes'){
    	
    		$active_tab = "create_theme";
    		$_SESSION['create_theme'] = $_SESSION['intro'];

    	}

    }

}





//////////////////////// update language of themes - update language part///////////////////////////////////

if(isset($_GET['manage_language'])){

    if($_GET['token'] == $_SESSION['FORM_SECRET_THEME']){

        $id_theme_lan_master = $_GET['new_lan_id_master'];

        $id_update_lan_theme = $_GET['id_update_lan_theme'];

        $new_tab = 'add';

        $active_tab = 'lan_add';

        $modify_mode_lan =10;

    }else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $active_tab = "intro";

        $_SESSION['intro']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong> [2004] Transaction has failed</strong></div>";


        if($new_design=='yes'){
    	
    		$active_tab = "create_theme";
    		$_SESSION['create_theme'] = $_SESSION['intro'];

    	}

    }

}





///////////////////////////////////theme update/submit Language//////////////////////////////////////

if(isset($_POST['theme_submit_lan']) || isset($_POST['theme_update_lan'])){//form





    if($_SESSION['FORM_SECRET_THEME'] == $_POST['form_secret']){//key validation



        $id_theme_lan_master = $_POST['id_theme_lan_master'];

        $escape = 0;

        if ($escape == 1) { //with mysql_real_escape_string()



            $theme_id_post = $_POST['theme_id_post'];

            $theme_name = trim($_POST['theme_name']);

            $reg_type = $_POST['reg_type'];

            $title_t = mysql_real_escape_string($_POST['title_t']);

            $language = $_POST['language'];

            $social_login = mysql_real_escape_string($_POST['social_login']);

            $create_account =mysql_real_escape_string( $_POST['create_account']);

            $sign_up = mysql_real_escape_string($_POST['sign_up']);

            $connectwifi = mysql_real_escape_string($_POST['connectwifi']);

            $welcome = mysql_real_escape_string($_POST['welcome']);

            $toc = mysql_real_escape_string($_POST['toc']);

            $welcome_back = mysql_real_escape_string($_POST['welcome_back']);

            $loading = mysql_real_escape_string($_POST['loading']);

            $login_with_facebook = mysql_real_escape_string($_POST['login_with_facebook']);

            $male = mysql_real_escape_string($_POST['male']);

            $female = mysql_real_escape_string($_POST['female']);

            $email = mysql_real_escape_string($_POST['email']);

            $age_group = mysql_real_escape_string($_POST['age_group']);

            $gender = mysql_real_escape_string($_POST['gender']);
            $mobile_field = mysql_real_escape_string($_POST['mobile_number']);

            $gender = mysql_real_escape_string($_POST['gender']);

            $login_name = mysql_real_escape_string($_POST['login_name']);

            $login_secret = mysql_real_escape_string($_POST['login_secret']);

            $button_color = mysql_real_escape_string($_POST['button_color']);

            $btn_color_disable = mysql_real_escape_string($_POST['btn_color_disable']);

            $button_ho_color = mysql_real_escape_string($_POST['button_ho_color']);

            $button_text_color = mysql_real_escape_string($_POST['button_text_color']);

            $location_ssid = mysql_real_escape_string($_POST['ref_id']);



            $first_name = mysql_real_escape_string($_POST['first_name']);

            $last_name = mysql_real_escape_string($_POST['last_name']);

            $cna_page = mysql_real_escape_string($_POST['cna_page']);

            $cna_button = mysql_real_escape_string($_POST['cna_button']);

            $acpt_text = mysql_real_escape_string($_POST['acpt_text']);

            $duotone_bg_color = strip_tags($_POST['duotone_bg']);

            $is_active = mysql_real_escape_string($_POST['is_active']);



        } else {



            $theme_id_post = $_POST['theme_id_post'];

            $theme_name = trim($_POST['theme_name']);

            $reg_type = $_POST['reg_type'];

            $title_t = str_replace("'", "&#39;", $_POST['title_t']);

            $language = $_POST['language'];

            $social_login = str_replace("'", "&#39;", $_POST['social_login']);

            $create_account =str_replace("'", "&#39;",  $_POST['create_account']);

            $sign_up = str_replace("'", "&#39;", $_POST['sign_up']);

            $connectwifi = str_replace("'", "&#39;", $_POST['connectwifi']);

            $welcome = str_replace("'", "&#39;", $_POST['welcome']);

            $toc = str_replace("'", "&#39;", $_POST['toc']);

            $welcome_back = str_replace("'", "&#39;", $_POST['welcome_back']);

            $loading = str_replace("'", "&#39;", $_POST['loading']);

            $login_with_facebook = str_replace("'", "&#39;", $_POST['login_with_facebook']);

            $male = str_replace("'", "&#39;", $_POST['male']);

            $female = str_replace("'", "&#39;", $_POST['female']);

            $email = str_replace("'", "&#39;", $_POST['email']);

            $age_group = str_replace("'", "&#39;", $_POST['age_group']);

            $gender = str_replace("'", "&#39;", $_POST['gender']);

            $login_name = str_replace("'", "&#39;", $_POST['login_name']);

            $login_secret = str_replace("'", "&#39;", $_POST['login_secret']);

            $button_color = str_replace("'", "&#39;", $_POST['button_color']);

            $btn_color_disable = str_replace("'", "&#39;", $_POST['btn_color_disable']);

            $button_ho_color = str_replace("'", "&#39;", $_POST['button_ho_color']);

            $button_text_color = str_replace("'", "&#39;", $_POST['button_text_color']);

            $location_ssid = str_replace("'", "&#39;", $_POST['ref_id']);

            $mobile_field = str_replace("'", "&#39;", $_POST['mobile_number']);

            $other_parameters = str_replace("'", "&#39;", $_POST['other_parameters']);

            $first_name = str_replace("'", "&#39;", $_POST['first_name']);

            $last_name = str_replace("'", "&#39;", $_POST['last_name']);

            $cna_page = str_replace("'", "&#39;", $_POST['cna_page']);

            $cna_button = str_replace("'", "&#39;", $_POST['cna_button']);

            $acpt_text = str_replace("'", "&#39;", $_POST['acpt_text']);

            $duotone_bg_color = strip_tags($_POST['duotone_bg']);

            $is_active = str_replace("'", "&#39;", $_POST['is_active']);





        }









        //if theme_modify=1 means update//

        $theme_modify=$_POST['theme_modify'];



        if($theme_modify == '0'){

            $theme_id_post = '';

        }





        //	$theme_mode = 'EX';



        if(strlen($theme_id_post)){

            $theme_unique_id = $theme_id_post;



            $tget_details=mysql_query("SELECT * FROM exp_themes WHERE theme_id='$theme_unique_id' LIMIT 1");

            $rowt=mysql_fetch_array($tget_details);

            $is_enable=$rowt['is_enable'];







        }

        else{



            $br = mysql_query("SHOW TABLE STATUS LIKE 'exp_themes'");

            $rowe = mysql_fetch_array($br);

            $auto_increment = $rowe['Auto_increment'];



            $theme_unique_id = 'th_'.$language.'_'.$auto_increment;



            $is_enable = '0';

        }



        $active_tab = "lan_view";

        $theme_display = $theme_unique_id;





        ///////////////////////////////Image Upload //////////////////////

        $img1_uploaded=1;

        $img2_uploaded=1;









        ///////////check images uploaded or not/////

        if($img1_uploaded==0 && $img2_uploaded==0){



            $form_submit=0;

            //$error='Error : Images have not been uploaded,please upload image & try again';

            $db->userErrorLog('2005', $user_name, 'script - '.$script);

            $img_no_upload_msg=$message_functions->showMessage('image_upload_failed_try','2005');

            echo "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           <strong>".$img_no_upload_msg."</strong></div>";



        }

        else{



            if ($is_active == 'on') {

                $active = 1;

                $q12 = "UPDATE `exp_themes` SET `is_enable` = '0' WHERE `ref_id` = '$id_theme_lan_master' AND `distributor`='$user_distributor' AND `language`='$language'";

                $ex_update12=mysql_query($q12);

            } else {

                $active = 0;

            }



            $query = "REPLACE INTO `exp_themes` (`theme_id`, `theme_name`, `distributor`, `language`,title, `registration_type`, `social_login_txt`, `manual_login_txt`, `welcome_txt`, `toc_txt`, `loading_txt`,

			`welcome_back_txt`, `registration_btn`, `connect_btn`, `fb_btn`,mobile_number_fields,other_fields, `first_name_text`, `last_name_text`, `male_field`, `female_field`,`email_field`, `age_group_field`, `gender_field`, `login_name_field`, `login_secret_field`, `accept_text`, `cna_page_text`, `cna_button_text`, `btn_color`, `btn_color_disable`, `btn_border`, `btn_text_color`, `duotone_bg_color` ,`create_date`, `updated_by`,theme_bg_image,theme_logo,ref_id,is_enable,theme_type)

			VALUES ('$theme_unique_id', '$theme_name', '$user_distributor', '$language', '$title_t','$reg_type', '$social_login', '$create_account', '$welcome', '$toc', '$loading', '$welcome_back', '$sign_up',

			'$connectwifi', '$login_with_facebook','$mobile_field','$other_parameters', '$first_name', '$last_name', '$male', '$female','$email', '$age_group', '$gender', '$login_name', '$login_secret', '$acpt_text', '$cna_page', '$cna_button', '$button_color', '$btn_color_disable', '$button_ho_color', '$button_text_color', '$duotone_bg_color' ,now(), '$user_name','$image1_name','$image2_name','$id_theme_lan_master','$active','LANGUAGE_THEME')";



            $ex = mysql_query($query);



            if($ex){





                /* ---------------------- Location SSID table update ---------------------------- */

                $qu = "SELECT `language`,`theme_id` FROM `exp_themes` WHERE `ref_id` = '$id_theme_lan_master' AND `distributor`='$user_distributor' AND `is_enable`= '1'";

                $rr = mysql_query($qu);

                while ($rowL = mysql_fetch_array($rr)) {

                    $lan = $rowL[language];

                    $the_id = $rowL[theme_id];



                    $lan_update_result[$lan] = $the_id;

                }

                $lan_update_result_json = json_encode($lan_update_result);







                if($lan_update_result_json == 'null'){

                    echo $ex_update4=mysql_query("UPDATE exp_themes SET language_string = NULL WHERE theme_id = '$id_theme_lan_master' AND `distributor`='$user_distributor' LIMIT 1");

                }else{

                    echo $ex_update4=mysql_query("UPDATE exp_themes SET language_string = '$lan_update_result_json' WHERE theme_id = '$id_theme_lan_master' AND `distributor`='$user_distributor' LIMIT 1");

                }





                /* -------------------------||---------------------------- */



                if($theme_modify==1){

                    $id_theme_lan = $id_theme_lan_master;

                    $new_tab = 'view';

                    $active_tab = 'lan_view';

                    echo "<div style=\"width:83.3%;\" class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

	           <strong>Theme [".$theme_name."] has been updated</strong></div>";

                }else{

                    $id_theme_lan = $id_theme_lan_master;

                    $new_tab = 'view';

                    $active_tab = 'lan_view';

                    echo "<div style=\"width:83.3%;\" class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

	           <strong>Theme [".$theme_name."] has been updated</strong></div>";



                }





            }

            else{

                $db->userErrorLog('2001', $user_name, 'script - '.$script);

                $went_wrong_msg = $message_functions->showMessage('something_went_wrong','2001');

                echo "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	<strong>".$went_wrong_msg."</strong></div>";

            }



        }







    }//key validation

    else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        //page refresh error//


        echo "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           	<strong> [2004] Transaction has failed</strong></div>";



        //header('Location: ');



    }





}//form









////////////////////////////// language Perent theme ACTIVE/DEACTIVE /////////////////////

if(isset($_GET['is_enable_lan'])){

    if($_GET['token'] == $_SESSION['FORM_SECRET_THEME']){

        $id_theme_lan = $_GET['parent_id'];

        $new_tab = 'view';

        $active_tab = 'lan_view';



        /*************************************************************************/

        //$table_id=$_GET['id'];

        $is_enable=$_GET['is_enable'];



        $get_details=mysql_query("SELECT theme_id,ref_id,theme_name,language FROM exp_themes WHERE  theme_id ='$id_theme_lan' LIMIT 1");

        $row2=mysql_fetch_array($get_details);

        $manage_ssid=$row2['ref_id'];

        $manage_theme_name=$row2['theme_name'];

        $theme_id = $row2['theme_id'];

        $language = $row2['language'];



        if($is_enable==0){

            ///disable theme///

            $ex_update=mysql_query("UPDATE `exp_themes` SET `is_enable` = '0' WHERE `theme_id` = '$id_theme_lan'");



            if($ex_update){
                $the_dis_msg = $message_functions->showNameMessage('theme_disable_success',$manage_theme_name);
                $_SESSION['msg1']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

           				<strong>".$the_dis_msg."</strong></div>";



            }else{

                $db->userErrorLog('2002', $user_name, 'script - '.$script);

                $went_wrong_msg = $message_functions->showMessage('something_went_wrong','2002');

                $_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong>".$went_wrong_msg."</strong></div>";

            }







        }else{

            //active theme//

            //first disable all theme related to SSID///

            $ex_update2=mysql_query("UPDATE `exp_themes` SET `is_enable` = '0' WHERE `ref_id` = '$manage_ssid' AND `distributor`='$user_distributor' AND `language`='$language'");

            //then active required one//

            $ex_update3=mysql_query("UPDATE `exp_themes` SET `is_enable` = '1' WHERE theme_id = '$id_theme_lan'");



            if($ex_update3){



                $_SESSION['msg1']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

           				<strong> Theme [".$manage_theme_name."] has been successfully activated</strong></div>";



            }else{

                $db->userErrorLog('2002', $user_name, 'script - '.$script);
                $went_wrong_msg = $message_functions->showMessage('something_went_wrong','2002');


                $_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong>".$went_wrong_msg."</strong></div>";

            }



        }



        /* ---------------------- Location SSID table update ---------------------------- */

        $qu = "SELECT `language`,`theme_id` FROM `exp_themes` WHERE `ref_id` = '$manage_ssid' AND `distributor`='$user_distributor' AND `is_enable`= '1'";

        $rr = mysql_query($qu);

        while ($rowL = mysql_fetch_array($rr)) {

            $lan = $rowL[language];

            $the_id = $rowL[theme_id];



            $lan_update_result[$lan] = $the_id;

        }

        $lan_update_result_json = json_encode($lan_update_result);



        if($lan_update_result_json == 'null'){

            $ex_update4=mysql_query("UPDATE exp_themes SET language_string = NULL WHERE theme_id = '$id_theme_lan' AND `distributor`='$user_distributor' LIMIT 1");

        }else{



            $ex_update4=mysql_query("UPDATE exp_themes SET language_string = '$lan_update_result_json' WHERE theme_id = '$id_theme_lan' AND `distributor`='$user_distributor' LIMIT 1");

        }



        /*************************************************************************/



    }else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $active_tab = "intro";

        $_SESSION['intro']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong> [2004] Transaction has failed</strong></div>";

        if($new_design=='yes'){
    	
    		$active_tab = "create_theme";
    		$_SESSION['create_theme'] = $_SESSION['intro'];

    	}

    }



}





////////////////////////////// language Child theme ACTIVE/DEACTIVE /////////////////////

if(isset($_GET['active_deactive'])){

    if($_GET['token'] == $_SESSION['FORM_SECRET_THEME']){

        $id_theme_lan = $_GET['id_theme_child'];

        $new_tab = 'view';

        $active_tab = 'lan_view';



        /*************************************************************************/

        //$table_id=$_GET['id'];

        $is_enable=$_GET['is_enable_lan'];



        $get_details=mysql_query("SELECT theme_id,ref_id,theme_name,language FROM exp_themes WHERE  theme_id ='$id_theme_lan' LIMIT 1");

        $row2=mysql_fetch_array($get_details);

        $manage_ssid=$row2['ref_id'];

        $manage_theme_name=$row2['theme_name'];

        $theme_id = $row2['theme_id'];

        $language = $row2['language'];



        if($is_enable==0){

            ///disable theme///

            $ex_update=mysql_query("UPDATE `exp_themes` SET `is_enable` = '0' WHERE `theme_id` = '$id_theme_lan'");



            if($ex_update){

                $_SESSION['msg10']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

           				<strong> Language has been successfully disabled</strong></div>";



            }else{

                $db->userErrorLog('2002', $user_name, 'script - '.$script);

                $went_wrong_msg = $message_functions->showMessage('something_went_wrong','2002');

                $_SESSION['msg10']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong>".$went_wrong_msg."</strong></div>";

            }







        }else{

            //active theme//

            //first disable all theme related to SSID///

            $ex_update2=mysql_query("UPDATE `exp_themes` SET `is_enable` = '0' WHERE `ref_id` = '$manage_ssid' AND `distributor`='$user_distributor' AND `language`='$language'");

            //then active required one//

            $ex_update3=mysql_query("UPDATE `exp_themes` SET `is_enable` = '1' WHERE theme_id = '$id_theme_lan'");



            if($ex_update3){







                $_SESSION['msg10']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

           				<strong> Language has been successfully activated</strong></div>";



            }else{

                $db->userErrorLog('2002', $user_name, 'script - '.$script);
                $went_wrong_msg = $message_functions->showMessage('something_went_wrong','2002');
                $_SESSION['msg10']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong>".$went_wrong_msg."</strong></div>";

            }



        }



        /* ---------------------- Location SSID table update ---------------------------- */

        $qu = "SELECT `language`,`theme_id` FROM `exp_themes` WHERE `ref_id` = '$manage_ssid' AND `distributor`='$user_distributor' AND `is_enable`= '1'";

        $rr = mysql_query($qu);

        while ($rowL = mysql_fetch_array($rr)) {

            $lan = $rowL[language];

            $the_id = $rowL[theme_id];



            $lan_update_result[$lan] = $the_id;

        }

        $lan_update_result_json = json_encode($lan_update_result);



        if($lan_update_result_json == 'null'){

            $q4 = "UPDATE exp_themes SET language_string = NULL WHERE theme_id = '$manage_ssid' AND `distributor`='$user_distributor' LIMIT 1";

            $ex_update4=mysql_query($q4);

        }else{

            $q4 = "UPDATE exp_themes SET language_string = '$lan_update_result_json' WHERE theme_id = '$manage_ssid' AND `distributor`='$user_distributor' LIMIT 1";

            $ex_update4=mysql_query($q4);

        }

        $id_theme_lan = $manage_ssid;

        $new_tab = 'view';

        $active_tab = 'lan_view';



        /*************************************************************************/



    }else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $_SESSION['intro']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong> [2004] Transaction has failed</strong></div>";

        if($new_design=='yes'){

        	$_SESSION['create_theme'] = $_SESSION['intro'];

    	}

    }



}


if(isset($_POST['up_theme_img'])){

	$active_tab = "image_up";

	$image3_name= $_POST['image_3_name'];




// 	echo $image3_name= $_POST['image3'];
 	$imagetype= $_POST['image_type'];
	$temp3_name= $_POST['template_name1'];


	$tmp_current_path =$temp_Ads_Image_Folder.$image3_name;

	$move_img_path='../Ex-Portal/template/'.$temp3_name.'/gallery/'.$imagetype.'/'.$image3_name;

	$moveResult3 = rename($tmp_current_path, $move_img_path);



	if($moveResult3){

	echo "<div style=\"width:83.3%;\" class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

	           <strong>Image Upload Success</strong></div>";

	}else{

		echo "<div style=\"width:83.3%;\" class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

	           <strong>Image Upload Failed</strong></div>";

	}

// 	$active_tab = "image_up";










}






///////////////////////////////////theme update//////////////////////////////////////

if(isset($_POST['theme_submit']) || isset($_POST['theme_update'])){//form





	if($_SESSION['FORM_SECRET_THEME'] == $_POST['form_secret']){//key validation


		if(isset($_POST['m_first_name'])){
			$toggle_f_name='1';
		}else{$toggle_f_name='0';}

		if(isset($_POST['m_last_name'])){
			$toggle_l_name='1';
		}else{$toggle_l_name='0';}

		if(isset($_POST['m_email'])){
			$toggle_email='1';
		}else{$toggle_email='0';}

		if(isset($_POST['m_gender'])){
			$toggle_gender='1';
		}else{$toggle_gender='0';}

		if(isset($_POST['m_age_group'])){
			$toggle_agegroup='1';
		}else{$toggle_agegroup='0';}

		if(isset($_POST['m_mobile'])){
			$toggle_mobile='1';
		}else{$toggle_mobile='0';}


		$toggle_manual = array(

				'first_name'   => $toggle_f_name,
				'last_name'   => $toggle_l_name,
				'email'   => $toggle_email,
				'gender'   => $toggle_gender,
				'age_group'   => $toggle_agegroup,
				'mobile_number'   => $toggle_mobile
		);

		//Encode the array into JSON.enabled itesms
		$toggle_m_data = json_encode($toggle_manual);

		/*$duotone_bg_full = strip_tags(urlencode($_POST['duotone_bg']));
		$duotone_bg_rgba1 = $_POST['duotone_bg_rgba1'];
		$duotone_bg_pos1 = $_POST['duotone_bg_pos1'];
		$duotone_bg_rgba2 = $_POST['duotone_bg_rgba2'];
		$duotone_bg_pos2 = $_POST['duotone_bg_pos2'];*/
		$duotone_color_bg = $_POST['duotone_color_bg'];
		$duotone_color = $_POST['duotone_color'];
		$duotone_color_bg_slider = $_POST['duotone_color_bg_slider'];

		/*$duotone_bg = array(

				'duotone_bg'   => $duotone_bg_full,
				'duotone_bg_rgba1'   => $duotone_bg_rgba1,
				'duotone_bg_pos1'   => $duotone_bg_pos1,
				'duotone_bg_rgba2'   => $duotone_bg_rgba2,
				'duotone_bg_pos2'   => $duotone_bg_pos2
		);*/

		$duotone_bg = array(

				'duotone_color_bg'   => $duotone_color_bg,
				'duotone_color'   => $duotone_color,
				'duotone_color_bg_slider'   => $duotone_color_bg_slider,
		);

		//Encode the array into JSON.enabled itesms
		$duotone_bg_data = json_encode($duotone_bg);


		$escape = 0;

		if ($escape == 1) { //with mysql_real_escape_string()



			$theme_id_post = $_POST['theme_id_post'];

			$theme_name = trim($_POST['theme_name']);

			$splash_url1 = trim($_POST['urlsecure']);
			$splash_url2 = trim($_POST['splash_url']);


			$splash_url = $splash_url1.$splash_url2;

			//$splash_url = addhttp($splash_url);

			$reg_type = $_POST['reg_type'];

			$title_t = mysql_real_escape_string($_POST['title_t']);

			$language = $_POST['language'];

			$social_login = mysql_real_escape_string($_POST['social_login']);

			$create_account =mysql_real_escape_string( $_POST['create_account']);

			$sign_up = mysql_real_escape_string($_POST['sign_up']);

			$connectwifi = mysql_real_escape_string($_POST['connectwifi']);

			$welcome = mysql_real_escape_string($_POST['welcome']);

			$toc = mysql_real_escape_string($_POST['toc']);

			$welcome_back = mysql_real_escape_string($_POST['welcome_back']);

			$loading = mysql_real_escape_string($_POST['loading']);

			$login_with_facebook = mysql_real_escape_string($_POST['login_with_facebook']);

			$male = mysql_real_escape_string($_POST['male']);

			$female = mysql_real_escape_string($_POST['female']);

			$email = mysql_real_escape_string($_POST['email']);

			$age_group = mysql_real_escape_string($_POST['age_group']);

			$gender = mysql_real_escape_string($_POST['gender']);

			$login_name = mysql_real_escape_string($_POST['login_name']);

			$login_secret = mysql_real_escape_string($_POST['login_secret']);

			$button_color = mysql_real_escape_string($_POST['button_color']);

			$btn_color_disable = mysql_real_escape_string($_POST['btn_color_disable']);

			$button_ho_color = mysql_real_escape_string($_POST['button_ho_color']);

			$button_text_color = mysql_real_escape_string($_POST['button_text_color']);

			$location_ssid = mysql_real_escape_string($_POST['location_ssid']);

			$mobile_number_fields = mysql_real_escape_string($_POST['mobile_number']);
			$other_fields = mysql_real_escape_string($_POST['other_parameters']);

			$first_name = mysql_real_escape_string($_POST['first_name']);

			$last_name = mysql_real_escape_string($_POST['last_name']);

			$cna_page = mysql_real_escape_string($_POST['cna_page']);

			$cna_button = mysql_real_escape_string($_POST['cna_button']);

			$acpt_text = mysql_real_escape_string($_POST['acpt_text']);

			$duotone_bg_color = $duotone_bg_data;

			$is_active = mysql_real_escape_string($_POST['is_active']);

			$hor_img = mysql_real_escape_string($_POST['horizontal_img']);
			$var_img = mysql_real_escape_string($_POST['verticle_img']);
			$template_name = mysql_real_escape_string($_POST['template_name']);

			$redirect_type = mysql_real_escape_string($_POST['redirect_type']);

			$fontcolor1 = str_replace("'", "&#39;", $_POST['fontcolor1']);
			$fontcolor2 = str_replace("'", "&#39;", $_POST['fontcolor2']);


		} else {



			$theme_id_post = $_POST['theme_id_post'];

			$theme_name = mysql_real_escape_string(trim($_POST['theme_name']));

			$reg_type = $_POST['reg_type'];

			$title_t1 = str_replace("'", "&#39;", $_POST['title_t']);
			$title_t2 = str_replace("\\", "&#92;", $title_t1);
			$title_t3 = str_replace("<", "&#60;", $title_t2);
			$title_t4 = str_replace(">", "&#62;", $title_t3);
			$title_t = str_replace('"', '&#34;', $title_t4);


            $loading = str_replace("'", "&#39;", $_POST['loading']);
            $loading = str_replace("\\", "&#92;", $loading);
            $loading = str_replace("<", "&#60;", $loading);
            $loading = str_replace(">", "&#62;", $loading);
            $loading = str_replace('"', '&#34;', $loading);

			$language = $_POST['language'];

			$social_login = str_replace("'", "&#39;", $_POST['social_login']);

			$create_account =str_replace("'", "&#39;",  $_POST['create_account']);

			$sign_up = str_replace("'", "&#39;", $_POST['sign_up']);

			$connectwifi = str_replace("'", "&#39;", $_POST['connectwifi']);

			$welcome1 = str_replace("'", "&#39;", $_POST['welcome']);

			$welcome = str_replace("\\", "&#92;", $welcome1);

			$toc = str_replace("'", "&#39;", $_POST['toc']);

			$welcome_back = str_replace("'", "&#39;", $_POST['welcome_back']);



			$login_with_facebook = str_replace("'", "&#39;", $_POST['login_with_facebook']);

			$male = str_replace("'", "&#39;", $_POST['male']);

			$female = str_replace("'", "&#39;", $_POST['female']);

			$email = str_replace("'", "&#39;", $_POST['email']);

			$age_group = str_replace("'", "&#39;", $_POST['age_group']);

			$gender = str_replace("'", "&#39;", $_POST['gender']);

            $login_name = str_replace("'", "&#39;", $_POST['login_name']);

            $login_secret = str_replace("'", "&#39;", $_POST['login_secret']);

			$button_color = str_replace("'", "&#39;", $_POST['button_color']);

			$btn_color_disable = str_replace("'", "&#39;", $_POST['btn_color_disable']);

			$button_ho_color = str_replace("'", "&#39;", $_POST['button_ho_color']);

			$button_text_color = str_replace("'", "&#39;", $_POST['button_text_color']);

			$location_ssid = str_replace("'", "&#39;", $_POST['location_ssid']);

			$mobile_number_fields = str_replace("'", "&#39;", $_POST['mobile_number']);

			$other_fields = str_replace("'", "&#39;", $_POST['other_parameters']);

			$duotone_bg_color = $duotone_bg_data;

			$first_name = str_replace("'", "&#39;", $_POST['first_name']);

			$last_name = str_replace("'", "&#39;", $_POST['last_name']);

			$cna_page = str_replace("'", "&#39;", $_POST['cna_page']);

			$cna_button = str_replace("'", "&#39;", $_POST['cna_button']);

			$acpt_text = str_replace("'", "&#39;", $_POST['acpt_text']);

			$greeting_txt = mysql_real_escape_string($_POST['greeting_txt']);

			$is_active = str_replace("'", "&#39;", $_POST['is_active']);


			$hor_img = str_replace("'", "&#39;", $_POST['horizontal_img']);
			$var_img = str_replace("'", "&#39;", $_POST['verticle_img']);
			$template_name = str_replace("'", "&#39;", $_POST['template_name']);


			$splash_url1 = str_replace("'", "&#39;", $_POST['urlsecure']);
			$splash_url2 = str_replace("'", "&#39;", $_POST['splash_url']);

			$splash_url = $splash_url1.$splash_url2;
			//$splash_url = addhttp($splash_url);

			$bcolor1 = str_replace("'", "&#39;", $_POST['bcolor1']);
			$bcolor2 = str_replace("'", "&#39;", $_POST['feild_color']);

			$fontcolor1 = str_replace("'", "&#39;", $_POST['fontcolor1']);

			$fontcolor2 = str_replace("'", "&#39;", $_POST['field_txt_color']);

			$hrbcolor = str_replace("'", "&#39;", $_POST['hrcolor']);


			/* $logo_1_text = str_replace("'", "&#39;", $_POST['logo_1_text']);
			$logo_2_text = str_replace("'", "&#39;", $_POST['logo_2_text']); */
			$logo_1_text = mysql_real_escape_string($_POST['logo_1_text']);
			$logo_2_text = mysql_real_escape_string($_POST['logo_2_text']);


			$redirect_type = str_replace("'", "&#39;", $_POST['redirect_type']);



		}







		//if theme_modify=1 means update//

		$theme_modify=$_POST['theme_modify'];



		if($theme_modify == '0'){

			$theme_id_post = '';

		}





		//	$theme_mode = 'EX';



		if(strlen($theme_id_post)){

			$theme_unique_id = $theme_id_post;

			$tget_details=mysql_query("SELECT * FROM exp_themes WHERE theme_id='$theme_unique_id' LIMIT 1");

			$rowt=mysql_fetch_array($tget_details);

			$is_enable=$rowt['is_enable'];

		}

		else{

			$br = mysql_query("SHOW TABLE STATUS LIKE 'exp_themes'");

			$rowe = mysql_fetch_array($br);

			$auto_increment = $rowe['Auto_increment'];

			$theme_unique_id = 'th_'.$language.'_'.$auto_increment;

			$is_enable = '0';

		}

		$active_tab = "active_theme";

		$theme_display = $theme_unique_id;

		///////////////////////////////Image Upload //////////////////////

		$img1_uploaded=1;

		$img2_uploaded=1;


		 //////Background Image////////////////////

			   ////////new upload image///
		$ed_temp_name = str_replace("'", "&#39;", $_POST['edit_template_name']);


		    if(strlen($_POST["image_1_name"])>0){//img1

			     //file name//

			    $image1_name=$_POST["image_1_name"];

				///check new img upload or not///

				if(file_exists($original_bg_Image_Folder.$image1_name)!=1){


			    	$tmp_img_path1 =$temp_Ads_Image_Folder.$image1_name;


			    	//if(isset($_POST['theme_update']) && $template_name!=$ed_temp_name){


			    		//$tmp_img_path1=$base_portal_folder.'/template/'.$ed_temp_name.'/gallery/bg/'.$image1_name;

			    		//$original_logo_edit_Folder=$base_portal_folder.'/template/'.$ed_temp_name.'/gallery/logo/'.$image1_name;

			    	//}

	            	////img file move to folder/////

	            	$moveResult1 = rename($tmp_img_path1, $original_bg_Image_Folder.$image1_name);

				 	if($moveResult1){

						$img1_uploaded=1;

					}else{

						 $img1_uploaded=0;

					}

				}

			}//img1

			else{

				// $img1_uploaded=0;

				if(strlen($logo_1_text)>0){

					$image1_name = '';

				}else{

               // $image1_name = $_POST["back_color"];
				}

			}

            



















			//////Logo Image////////////////////





			 //default imge set///

			 //file name//

			$image2_name=$_POST["default_img2"];





			   ////////new upload image///



		    if(strlen($_POST["image_2_name"])>0){//img2



			     //file name//

			    $image2_name=$_POST["image_2_name"];



				///check new img upload or not///

				if(file_exists($original_logo_Image_Folder.$image2_name)!=1){



			    	$tmp_img_path2 =$temp_Ads_Image_Folder.$image2_name;



			    	//if(isset($_POST['theme_update']) && $template_name!=$ed_temp_name){


			    		//$tmp_img_path1=$base_portal_folder.'/template/'.$ed_temp_name.'/gallery/bg/'.$image1_name;

			    		//$tmp_img_path2=$base_portal_folder.'/template/'.$ed_temp_name.'/gallery/logo/'.$image2_name;



			    	//}

//echo $original_logo_Image_Folder.$image2_name;

	            	////img file move to folder/////

	            	$moveResult2 = rename($tmp_img_path2, $original_logo_Image_Folder.$image2_name);

				 	if($moveResult2){

					 	$img2_uploaded=1;

					}else{

						$img2_uploaded=0;

					}

				}



			}//img2

			else{

				//$img2_uploaded=0;

				if(strlen($logo_2_text)>0){

					$image2_name = '';

				}else{

					$img2_uploaded=0;
				}

				}











		$form_submit=1;

		if(strlen($logo_1_text)){

			$img1_uploaded=1;
		}

		if(strlen($logo_2_text)){

			$img2_uploaded=1;
		}


		///////////check images uploaded or not/////

		if($img1_uploaded==0 && $img2_uploaded==0){



			$form_submit=0;

				//$error='Error : Images have not been uploaded,please upload image & try again';

            $db->userErrorLog('2005', $user_name, 'script - '.$script);

            $crop_img_msg = $message_functions->showMessage('image_upload_save_failed','2005');


			$_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           <strong>".$crop_img_msg."</strong></div>";



		}

		else{



			if ($is_active == 'on') {

				$active = 1;

				$q12 = "UPDATE `exp_themes` SET `is_enable` = '0' WHERE `ref_id` = '$location_ssid' AND `distributor`='$user_distributor' AND `language`='$language'";

				$ex_update12=mysql_query($q12);

			} else {

				$active = 0;

			}

			//echo $image1_name;
			if(strlen($logo_1_text)!=0){

				$image1_name=$logo_1_text;
			}

			if(strlen($logo_2_text)!=0){

				$image2_name=$logo_2_text;
			}

			if($_POST['background_img_check'] == '0') {
               $image1_name = $_POST["back_color"];
            }


			if($theme_modify==1){


			$ex_modify_archive=mysql_query("INSERT INTO `exp_themes_archive` (
					`id`,
					`theme_id`,
					`theme_name`,
					`theme_type`,
					`splash_url`,
					`redirect_type`,
					`template_name`,
					`ref_id`,
					`location_ssid`,
					`distributor`,
					`language`,
					`language_string`,
					`title`,
					`registration_type`,
					`social_login_txt`,
					`manual_login_txt`,
					`welcome_txt`,
					`greeting_txt`,
					`toc_txt`,
					`loading_txt`,
					`welcome_back_txt`,
					`registration_btn`,
					`connect_btn`,
					`fb_btn`,
					`first_name_text`,
					`last_name_text`,
					`male_field`,
					`female_field`,
					`email_field`,
					`age_group_field`,
					`gender_field`,
					`manual_login_fields`,
					mobile_number_fields,
					other_fields,
					`login_name_field`,
					`login_secret_field`,
					`accept_text`,
					`cna_page_text`,
					`cna_button_text`,
					`btn_color`,
					`btn_color_disable`,
					`btn_border`,
					`btn_text_color`,
					`bg_color_1`,
					`bg_color_2`,
					`font_color_1`,
					`font_color_2`,
					`hr_color`,
					`theme_logo`,
					`theme_bg_image`,
					`theme_horizontal_image`,
					`theme_verticle_image`,
					`is_enable`,
					`duotone_bg_color`,
					`create_date`,
					`last_update`,
					`updated_by`,
					`deleted_by`,
					`state_change`
					)
					SELECT
					`id`,

					`theme_id`,
					`theme_name`,
					`theme_type`,
					`splash_url`,
					`redirect_type`,
					`template_name`,
					`ref_id`,
					`location_ssid`,
					`distributor`,
					`language`,
					`language_string`,
					`title`,
					`registration_type`,
					`social_login_txt`,
					`manual_login_txt`,
					`welcome_txt`,
					`greeting_txt`,
					`toc_txt`,
					`loading_txt`,
					`welcome_back_txt`,
					`registration_btn`,
					`connect_btn`,
					`fb_btn`,
					`first_name_text`,
					`last_name_text`,
					`male_field`,
					`female_field`,
					`email_field`,
					`age_group_field`,
					`gender_field`,
					`manual_login_fields`,
					mobile_number_fields,
					other_fields,
					`login_name_field`,
					`login_secret_field`,
					`accept_text`,
					`cna_page_text`,
					`cna_button_text`,
					`btn_color`,
					`btn_color_disable`,
					`btn_border`,
					`btn_text_color`,
					`bg_color_1`,
					`bg_color_2`,
					`font_color_1`,
					`font_color_2`,
					`hr_color`,
					`theme_logo`,
					`theme_bg_image`,
					`theme_horizontal_image`,
					`theme_verticle_image`,
					`is_enable`,
					`duotone_bg_color`,
					`create_date`,
					`last_update`,
					`updated_by`,
					'$user_name',
					'Modify'
					FROM
					`exp_themes`
					WHERE
					`theme_id` ='$theme_unique_id'");


			}

			$template_name=mysql_real_escape_string($template_name);

			
            $query = "REPLACE INTO `exp_themes` (`redirect_type`,`bg_color_1`,`bg_color_2`,`font_color_1`,`font_color_2`,`hr_color`,`splash_url`,`template_name`,`theme_horizontal_image`,`theme_verticle_image`,`manual_login_fields`, `theme_id`, `theme_name`, `distributor`, `language`,title, `registration_type`,mobile_number_fields,other_fields, `social_login_txt`, `manual_login_txt`, `welcome_txt`, `greeting_txt`, `toc_txt`, `loading_txt`,

			`welcome_back_txt`, `registration_btn`, `connect_btn`, `fb_btn`, `first_name_text`, `last_name_text`, `male_field`, `female_field`,`email_field`, `age_group_field`, `gender_field`, `login_name_field`, `login_secret_field`, `accept_text`, `cna_page_text`, `cna_button_text`, `btn_color`, `btn_color_disable`, `btn_border`, `btn_text_color`, `duotone_bg_color`, `create_date`, `updated_by`,theme_bg_image,theme_logo,ref_id,is_enable,theme_type)

			VALUES ('$redirect_type','$bcolor1','$bcolor2','$fontcolor1','$fontcolor2','$hrbcolor','$splash_url','$template_name','$hor_img','$var_img','$toggle_m_data', '$theme_unique_id', '$theme_name', '$user_distributor', '$language', '$title_t','$reg_type','$mobile_number_fields','$other_fields', '$social_login', '$create_account', '$welcome', '$greeting_txt', '$toc', '$loading', '$welcome_back', '$sign_up',

			'$connectwifi', '$login_with_facebook', '$first_name', '$last_name', '$male', '$female','$email', '$age_group', '$gender', '$login_name', '$login_secret', '$acpt_text', '$cna_page', '$cna_button', '$button_color', '$btn_color_disable', '$button_ho_color', '$button_text_color', '$duotone_bg_color' ,now(), '$user_name','$image1_name','$image2_name','$location_ssid','$active','MASTER_THEME')";



			$ex = mysql_query($query);



			if($ex){





					/* ---------------------- Location SSID table update ---------------------------- */

				$qu = "SELECT `language`,`theme_id` FROM `exp_themes` WHERE `ref_id` = '$location_ssid' AND `distributor`='$user_distributor' AND `is_enable`= '1'";

				$rr = mysql_query($qu);

				while ($rowL = mysql_fetch_array($rr)) {

					$lan = $rowL[language];

					$the_id = $rowL[theme_id];



					$lan_update_result[$lan] = $the_id;

				}

				$lan_update_result_json = json_encode($lan_update_result);



                $lan_update_result_json = json_encode($lan_update_result);



                if($lan_update_result_json == 'null'){

                    $qq11 = "UPDATE exp_mno_distributor_group_tag SET theme_name = NULL WHERE tag_name = '$location_ssid' AND `distributor`='$user_distributor' LIMIT 1";

                    $ex_update4=mysql_query($qq11);

                }else{

                    $qq11 = "UPDATE exp_mno_distributor_group_tag SET theme_name = '$lan_update_result_json' WHERE tag_name = '$location_ssid' AND `distributor`='$user_distributor' LIMIT 1";

                    $ex_update4=mysql_query($qq11);

                }





                /* -------------------------||---------------------------- */



				if($theme_modify==1){
				    $them_up_msg = $message_functions->showNameMessage('theme_updated_success',$theme_name);

				$_SESSION['msg1']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

	           <strong>".$them_up_msg."</strong></div>";

			}else{
                    $them_create_msg = $message_functions->showNameMessage('theme_create_success',$theme_name);
					$_SESSION['msg1']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

	           <strong>".$them_create_msg."</strong></div>";



			}





			}

			else{

                $db->userErrorLog('2001', $user_name, 'script - '.$script);
                $them_create_msg = $message_functions->showMessage('theme_create_failed','2001');
				$_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

	           	<strong>".$them_create_msg."</strong></div>";

			}



		}







	}//key validation

	else{

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

					//page refresh error//

		$_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           	<strong> [2004] Creation failed</strong></div>";



					//header('Location: ');



	}





}//form









	if($_GET['modify'] == 1){

		$theme = $_GET['id'];

		$lan = $_GET['lan'];

		$active_tab = "create_theme";

		$modify_mode = 1;

	}

	else if($_GET['modify']==2){



		$active_tab = "active_theme";



		if($_SESSION['FORM_SECRET_THEME']==$_GET['token']){//refresh validation



			$table_id=$_GET['id'];

			$is_enable=$_GET['is_enable'];



			$get_details=mysql_query("SELECT theme_id,ref_id,theme_name,language FROM exp_themes WHERE  id='$table_id' LIMIT 1");

			$row2=mysql_fetch_array($get_details);

			$manage_ssid=$row2['ref_id'];

			$manage_theme_name=$row2['theme_name'];

			$theme_id = $row2['theme_id'];

			$language = $row2['language'];



			if($is_enable==0){

				$ex_update_archive=mysql_query("INSERT INTO `exp_themes_archive` (
				`id`,
				`theme_id`,
				`theme_name`,
				`theme_type`,
				`splash_url`,
				`template_name`,
				`ref_id`,
				`location_ssid`,
				`distributor`,
				`language`,
				`language_string`,
				`title`,
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
				`first_name_text`,
				`last_name_text`,
				`male_field`,
				`female_field`,
				`email_field`,
				`age_group_field`,
				`gender_field`,
				`manual_login_fields`,
				mobile_number_fields,
				other_fields,
				`login_name_field`,
				`login_secret_field`,
				`accept_text`,
				`cna_page_text`,
				`cna_button_text`,
				`btn_color`,
				`btn_color_disable`,
				`btn_border`,
				`btn_text_color`,
				`bg_color_1`,
				`bg_color_2`,
				`font_color_1`,
				`font_color_2`,
				`hr_color`,
				`theme_logo`,
				`theme_bg_image`,
				`theme_horizontal_image`,
				`theme_verticle_image`,
				`is_enable`,
				`duotone_bg_color`,
				`create_date`,
				`last_update`,
				`updated_by`,
				`deleted_by`,
				`state_change`
				)
				SELECT
				`id`,
				`theme_id`,
				`theme_name`,
				`theme_type`,
				`splash_url`,
				`template_name`,
				`ref_id`,
				`location_ssid`,
				`distributor`,
				`language`,
				`language_string`,
				`title`,
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
				`first_name_text`,
				`last_name_text`,
				`male_field`,
				`female_field`,
				`email_field`,
				`age_group_field`,
				`gender_field`,
				`manual_login_fields`,
				mobile_number_fields,
				other_fields,
				`login_name_field`,
				`login_secret_field`,
				`accept_text`,
				`cna_page_text`,
				`cna_button_text`,
				`btn_color`,
				`btn_color_disable`,
				`btn_border`,
				`btn_text_color`,
				`bg_color_1`,
				`bg_color_2`,
				`font_color_1`,
				`font_color_2`,
				`hr_color`,
				`theme_logo`,
				`theme_bg_image`,
				`theme_horizontal_image`,
				`theme_verticle_image`,
				`is_enable`,
				`duotone_bg_color`,
				`create_date`,
				`last_update`,
				`updated_by`,
				'$user_name',
				'Disable'
				FROM
				`exp_themes`
				WHERE
				`id` ='$table_id'");


				///disable theme///

				$ex_update=mysql_query("UPDATE `exp_themes` SET `is_enable` = '0' WHERE `id` = '$table_id'");

				//$ex_update_archive=mysql_query("UPDATE `exp_themes` SET `is_enable` = '0' WHERE `id` = '$table_id'");



				if($ex_update){
                    $the_dis_msg = $message_functions->showNameMessage('theme_disable_success',$manage_theme_name);
					$_SESSION['msg1']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

           				<strong>".$the_dis_msg."</strong></div>";



				}else{

                    $db->userErrorLog('2002', $user_name, 'script - '.$script);

                    $went_wrong_msg = $message_functions->showMessage('something_went_wrong','2002');

					$_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong>".$went_wrong_msg."</strong></div>";

				}







			}else{

					//active theme//

					//first disable all theme related to SSID///
	/*
				$ex_update2_archive=mysql_query("INSERT INTO `exp_themes_archive` (
						`id`,
						`theme_id`,
						`theme_name`,
						`theme_type`,
						`splash_url`,
						`template_name`,
						`ref_id`,
						`location_ssid`,
						`distributor`,
						`language`,
						`language_string`,
						`title`,
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
						`first_name_text`,
						`last_name_text`,
						`male_field`,
						`female_field`,
						`email_field`,
						`age_group_field`,
						`gender_field`,
						`manual_login_fields`,
						`login_name_field`,
						`login_secret_field`,
						`accept_text`,
						`cna_page_text`,
						`cna_button_text`,
						`btn_color`,
						`btn_color_disable`,
						`btn_border`,
						`btn_text_color`,
						`bg_color_1`,
						`bg_color_2`,
						`hr_color`,
						`theme_logo`,
						`theme_bg_image`,
						`theme_horizontal_image`,
						`theme_verticle_image`,
						`is_enable`,
						`create_date`,
						`last_update`,
						`updated_by`,
						`deleted_by`,
						`state_change`
						)
						SELECT
						`id`,
						`theme_id`,
						`theme_name`,
						`theme_type`,
						`splash_url`,
						`template_name`,
						`ref_id`,
						`location_ssid`,
						`distributor`,
						`language`,
						`language_string`,
						`title`,
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
						`first_name_text`,
						`last_name_text`,
						`male_field`,
						`female_field`,
						`email_field`,
						`age_group_field`,
						`gender_field`,
						`manual_login_fields`,
						`login_name_field`,
						`login_secret_field`,
						`accept_text`,
						`cna_page_text`,
						`cna_button_text`,
						`btn_color`,
						`btn_color_disable`,
						`btn_border`,
						`btn_text_color`,
						`bg_color_1`,
						`bg_color_2`,
						`hr_color`,
						`theme_logo`,
						`theme_bg_image`,
						`theme_horizontal_image`,
						`theme_verticle_image`,
						`is_enable`,
						`create_date`,
						`last_update`,
						`updated_by`,
						'$user_name',
						'Enable_".$table_id."'
						FROM
						`exp_themes`
						WHERE
						`ref_id` = '$manage_ssid' AND `distributor`='$user_distributor' AND `language`='$language'");

*/

				$ex_update2=mysql_query("UPDATE `exp_themes` SET `is_enable` = '0' WHERE `ref_id` = '$manage_ssid' AND `distributor`='$user_distributor' AND `language`='$language'");

				//then active required one//

				$ex_update3_archive=mysql_query("INSERT INTO `exp_themes_archive` (
						`id`,
						`theme_id`,
						`theme_name`,
						`theme_type`,
						`splash_url`,
						`template_name`,
						`ref_id`,
						`location_ssid`,
						`distributor`,
						`language`,
						`language_string`,
						`title`,
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
						`first_name_text`,
						`last_name_text`,
						`male_field`,
						`female_field`,
						`email_field`,
						`age_group_field`,
						`gender_field`,
						`manual_login_fields`,
						mobile_number_fields,
						other_fields,
						`login_name_field`,
						`login_secret_field`,
						`accept_text`,
						`cna_page_text`,
						`cna_button_text`,
						`btn_color`,
						`btn_color_disable`,
						`btn_border`,
						`btn_text_color`,
						`bg_color_1`,
						`bg_color_2`,
						`font_color_1`,
						`font_color_2`,
						`hr_color`,
						`theme_logo`,
						`theme_bg_image`,
						`theme_horizontal_image`,
						`theme_verticle_image`,
						`is_enable`,
						`duotone_bg_color`,
						`create_date`,
						`last_update`,
						`updated_by`,
						`deleted_by`,
						`state_change`
						)
						SELECT
						`id`,
						`theme_id`,
						`theme_name`,
						`theme_type`,
						`splash_url`,
						`template_name`,
						`ref_id`,
						`location_ssid`,
						`distributor`,
						`language`,
						`language_string`,
						`title`,
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
						`first_name_text`,
						`last_name_text`,
						`male_field`,
						`female_field`,
						`email_field`,
						`age_group_field`,
						`gender_field`,
						`manual_login_fields`,
						mobile_number_fields,
						other_fields,
						`login_name_field`,
						`login_secret_field`,
						`accept_text`,
						`cna_page_text`,
						`cna_button_text`,
						`btn_color`,
						`btn_color_disable`,
						`btn_border`,
						`btn_text_color`,
						`bg_color_1`,
						`bg_color_2`,
						`font_color_1`,
						`font_color_2`,
						`hr_color`,
						`theme_logo`,
						`theme_bg_image`,
						`theme_horizontal_image`,
						`theme_verticle_image`,
						`is_enable`,
						`duotone_bg_color`,
						`create_date`,
						`last_update`,
						`updated_by`,
						'$user_name',
						'Enable'
						FROM
						`exp_themes`
						WHERE
						id = '$table_id'");

				$ex_update3=mysql_query("UPDATE `exp_themes` SET `is_enable` = '1' WHERE id = '$table_id'");



				if($ex_update3){




                    $theme_activate_msg = $message_functions->showNameMessage('theme_activate_success',$manage_theme_name);


					$_SESSION['msg1']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>

           				<strong>".$theme_activate_msg."</strong></div>";



				}else{

                    $db->userErrorLog('2002', $user_name, 'script - '.$script);

                    $went_wrong_msg = $message_functions->showMessage('something_went_wrong','2002');

					$_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           			<strong>".$went_wrong_msg."</strong></div>";

				}



			}



				/* ---------------------- Location SSID table update ---------------------------- */

			$qu = "SELECT `language`,`theme_id` FROM `exp_themes` WHERE `ref_id` = '$manage_ssid' AND `distributor`='$user_distributor' AND `is_enable`= '1'";

			$rr = mysql_query($qu);

			while ($rowL = mysql_fetch_array($rr)) {

				$lan = $rowL[language];

				$the_id = $rowL[theme_id];



				$lan_update_result[$lan] = $the_id;

			}

			$lan_update_result_json = json_encode($lan_update_result);



            if($lan_update_result_json == 'null'){

                 $ex_update4=mysql_query("UPDATE exp_mno_distributor_group_tag SET theme_name = NULL WHERE tag_name = '$manage_ssid' AND `distributor`='$user_distributor' LIMIT 1");

            }else{

                 $ex_update4=mysql_query("UPDATE exp_mno_distributor_group_tag SET theme_name = '$lan_update_result_json' WHERE tag_name = '$manage_ssid' AND `distributor`='$user_distributor' LIMIT 1");

            }

				/* -------------------------||---------------------------- */



		}//key validation

		else{

            $db->userErrorLog('2004', $user_name, 'script - '.$script);

			//page refresh error//

			echo "<div style=\"width:83.3%;\" class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           		<strong> [2004] Transaction has failed</strong></div>";

					//header('Location: ');

		}











	}

	else{

		$theme = 'default_theme';// $mno_id;

		$lan = 'en';

		$modify_mode = 0;

	}





	$theme_data_set = $db->getTheme($theme,$lan);

//	print_r($theme_data_set);

	$theme_name_set = $theme_data_set[0]['theme_name'];


	$edit_splash_url = $theme_data_set[0]['splash_url'];



	$splasharray=explode("//",$edit_splash_url);


	 $secspalsh=$splasharray[0].'//';



	 $pathspalsh=$splasharray[1];


	$reditct_typ = $theme_data_set[0]['redirect_type'];


	$distributor = $theme_data_set[0]['distributor'];

	$title_t = $theme_data_set[0]['title'];

	$language = $theme_data_set[0]['language'];

	$registration_type = $theme_data_set[0]['registration_type'];

	$social_login_txt = $theme_data_set[0]['social_login_txt'];

	$manual_login_txt = $theme_data_set[0]['manual_login_txt'];

	$welcome_txt = $theme_data_set[0]['welcome_txt'];

	$welcome_txt = str_replace('"', "&quot;", $welcome_txt);

	$greeting_txt = $theme_data_set[0]['greeting_txt'];

	$toc_txt = $theme_data_set[0]['toc_txt'];

	$loading_txt = $theme_data_set[0]['loading_txt'];

	$welcome_back_txt = $theme_data_set[0]['welcome_back_txt'];

	$registration_btn = $theme_data_set[0]['registration_btn'];

	$connect_btn = $theme_data_set[0]['connect_btn'];

	$fb_btn = $theme_data_set[0]['fb_btn'];

	$male_field = $theme_data_set[0]['male_field'];

	$female_field = $theme_data_set[0]['female_field'];

	$email_field = $theme_data_set[0]['email_field'];

	$age_group_field = $theme_data_set[0]['age_group_field'];

	$gender_field = $theme_data_set[0]['gender_field'];

	$login_name_field1 = $theme_data_set[0]['login_name_field'];

	$login_secret_field1 = $theme_data_set[0]['login_secret_field'];

	$btn_color = $theme_data_set[0]['btn_color'];

	$btn_color_disable = $theme_data_set[0]['btn_color_disable'];

	$btn_border = $theme_data_set[0]['btn_border'];

	$btn_text_color = $theme_data_set[0]['btn_text_color'];

	$manual_login_fields = (array)json_decode($theme_data_set[0]['manual_login_fields']);
//print_r($manual_login_fields);
	$manual_fields = $api_db->getRegFields($user_distributor, $mno_id);


	$edit_bg_color1 = $theme_data_set[0]['bg_color_1'];
	$edit_bg_color2 = $theme_data_set[0]['bg_color_2'];
	$edit_hr_color = $theme_data_set[0]['hr_color'];


	$th_background_image = $theme_data_set[0]['theme_bg_image'];

	$th_logo_image = $theme_data_set[0]['theme_logo'];

	$edit_ref_id = $theme_data_set[0]['ref_id'];

	$edit_template_name = $theme_data_set[0]['template_name'];


	$edit_hor_img=$theme_data_set[0]['theme_horizontal_image'];

	$edit_var_img=$theme_data_set[0]['theme_verticle_image'];

	 $edit_mobile_number_fields=$theme_data_set[0]['mobile_number_fields'];
	$edit_other_fields=$theme_data_set[0]['other_fields'];




	$first_name_text = $theme_data_set[0]['first_name_text'];

	$last_name_text = $theme_data_set[0]['last_name_text'];

	$cna_page_field = $theme_data_set[0]['cna_page_text'];

	$cna_button_field = $theme_data_set[0]['cna_button_text'];

	$acpt_text_field = $theme_data_set[0]['accept_text'];

	$duotone_bg_color = $theme_data_set[0]['duotone_bg_color'];

	$duotone_bg_color_array = (array)json_decode($duotone_bg_color);

	/*$duotone_bg = urldecode($duotone_bg_color_array['duotone_bg']);*/
	$duotone_color_bg = $duotone_bg_color_array['duotone_color_bg'];
	$duotone_color_bg_slider = $duotone_bg_color_array['duotone_color_bg_slider'];
	$duotone_color = $duotone_bg_color_array['duotone_color'];

	
	$duotone_bg_rgba1 = $duotone_bg_color_array['duotone_bg_rgba1'];
	$duotone_bg_pos1 = $duotone_bg_color_array['duotone_bg_pos1'];
	$duotone_bg_rgba2 = $duotone_bg_color_array['duotone_bg_rgba2'];
	$duotone_bg_pos2 = $duotone_bg_color_array['duotone_bg_pos2'];

	$is_active1 = $theme_data_set[0]['is_enable'];

	$edit_fontcolor1 = $theme_data_set[0]['font_color_1'];
	$edit_fontcolor2 = $theme_data_set[0]['font_color_2'];


?>







<div class="main">

		<div class="main-inner">

			<div class="container">

				<div class="row">

					<div class="span12">

						<div class="widget ">



							<div class="widget-header">

								<!-- <i class="icon-leaf"></i> -->

								<h3>View and Manage Themes</h3>

							</div>

										   

							<!-- /widget-header -->



							<div class="widget-content">

								<?php

	                            $secret=md5(uniqid(rand(), true));

	                            $_SESSION['FORM_SECRET_THEME'] = $secret;

	                            ?>



								<div class="tabbable">

									<ul class="nav nav-tabs">


									<?php	if(in_array("THEME_INTRO",$features_array) || $package_features=="all"){?>
										<li <?php if($active_tab == 'intro') echo 'class="active"'; ?>><a href="#intro" id="tab-intro" data-toggle="tab">Introduction</a></li>
									<?php }if(in_array("THEME_CREATE",$features_array) || $package_features=="all"){?>
										<li <?php if($active_tab == 'create_theme') echo 'class="active"'; ?>><a href="#create_theme" id="tab-create_theme" data-toggle="tab">Create</a></li>
									<?php }if(in_array("THEME_IMPORT",$features_array) || $package_features=="all"){?>
										<li <?php if($active_tab == 'import_theme') echo 'class="active"'; ?>><a href="#import_theme" data-toggle="tab">Import</a></li>
									<?php }if(in_array("THEME_MANAGE",$features_array) || $package_features=="all"){?>
										<li <?php if($active_tab == 'active_theme') echo 'class="active"'; ?>><a href="#active_theme" id="tab-active_theme" data-toggle="tab">Manage</a></li>
									<?php }?>

									<?php if(in_array("THEME_IMAGE_UP",$features_array) || $package_features=="all"){?>
										<li <?php if($active_tab == 'image_up') echo 'class="active"'; ?>><a href="#image_up" data-toggle="tab">Image Upload</a></li>
									<?php }?>

                                        <!-- <li <?php //if($active_tab == 'upload_images') echo 'class="active"'; ?>><a href="#upload_images" data-toggle="tab">Upload Images</a></li> -->

									<?php	if(in_array("THEME_VIEW",$features_array) || $package_features=="all") { ?>
										<li <?php if($active_tab == 'preview') echo 'class="active"'; ?>><a href="#preview" id="tab-preview" data-toggle="tab">Preview</a></li>
									<?php } ?>
                                        <?php if($new_tab == 'view' || $new_tab == 'add'){ ?>

                                        <li <?php if($active_tab == 'lan_view' || $active_tab == 'lan_add') echo 'class="active"'; ?>><a href="#language" data-toggle="tab">Language Management</a></li>

                                        <?php } ?>

									</ul>

									<br>


<div>
                                    <?php 

                                    if($new_design=='yes'){

$theme_inner = 'layout/'.$camp_layout.'/views/theme_inner.php';

  if (file_exists($theme_inner)) {
        include_once $theme_inner;
  } 

}
  
 ?>


									<div class="tab-content">



										



                                            <!-- ****************** Import_theme ******************* -->

                                        <div style="display: none !important;"> class="tab-pane <?php if($active_tab == 'import_theme') echo 'active'; ?>" id="import_theme">



                                            <?php

                                            if(isset($_SESSION['msg_up'])){

                                                echo $_SESSION['msg_up'];

                                                unset($_SESSION['msg_up']);





                                            }?>



                                            <div class="widget widget-table action-table">



                                                <?php if($message) echo "<p>$message</p>"; ?>



                                                <form enctype="multipart/form-data" id="submit_import_form" class="form-horizontal" method="POST" action="theme<?php echo $extension; ?>?active_tab=import_theme">





                                                    <?php

                                                    echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET_THEME'].'" />';

                                                    ?>





                                                    <fieldset>

                                                        <?php

                                                        $key_query1 = "SELECT DISTINCT tag_name FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor' ORDER BY tag_name ASC";

                                                        $query_results1=mysql_query($key_query1);

                                                        $count_ssid = mysql_num_rows($query_results1);



                                                        if($count_ssid == 0){

                                                            /* $warning_text = '<div class="alert alert-warning" role="alert"><h3><i class="icon-warning-sign"></i> Warning! <small>';

                                                            $warning_text .= '<br>Please create a <a href="location.php?t=3" class="alert-link">Group Tag / Location</a> before trying to create a theme';

                                                            $warning_text .= '</small></h3></div>'; */



                                                            echo $warning_text;

                                                        }

                                                        ?>

                                                        <div class="control-group">

                                                            <label class="control-label" for="radiobtns">Group Tag / Location
                                                            </label>



                                                            <div class="controls">

                                                                <div class="input-prepend input-append">

                                                                <select id="location_ssid1" class="span5"name="location_ssid" required="required">





                                                                        <?php



                                                                        if($modify_mode == 1) {

                                                                            echo "<option value = \"".$edit_ref_id."\">".$edit_ref_id."</option>"; }

                                                                        else {

                                                                            echo "<option value =''> -- Select Group Tag / Location --</option>";

                                                                        }

                                                                        ?>



                                                                        <?php





                                                                        while($row1=mysql_fetch_array($query_results1)){



                                                                            $tag_name = $row1[tag_name];



                                                                            echo '<option value="'.$tag_name.'">'.$tag_name.'</option>';

                                                                        }



                                                                        ?>



                                                                    </select>



                                                                </div>

                                                            </div>

                                                            <!-- /controls -->

                                                        </div>

                                                        <!-- /control-group -->



                                                        <div class="control-group">

                                                            <label class="control-label" for="zip_file">Select a Theme</label>



                                                            <div class="controls">

                                                                <div class="input-prepend input-append">



                                                                    <input name="zip_file" type="file" id="zip_file" size="50" class="span4"/>



                                                                </div>

                                                            </div>

                                                            <!-- /controls -->

                                                        </div>

                                                        <!-- /control-group -->



                                                        <div class="form-actions">

                                                            <button type="submit"  name="submit_import" class="btn btn-primary">Import</button>

                                                        </div>

                                                    </fieldset>

                                                </form>





												<!-- /widget-content -->

											</div>

											<!-- /widget -->



										</div>




						 <!-- /////////////////////////////////////////////////////////////
						 ////////////////////////////////////////////////////////////////////-->

                                        <div class="tab-pane <?php  if((in_array("THEME_INTRO",$features_array) || $package_features=="all") && ($active_tab == 'intro')){ echo 'active'; } ?>" id="intro">

											


                                            <?php

                                            if(isset($_SESSION['intro'])){

                                                echo $_SESSION['intro'];

                                                unset($_SESSION['intro']);





                                            }?>



                                            <div class="widget widget-table action-table">



                                                <?php if($message) echo "<p>$message</p>"; ?>



                                                <form enctype="multipart/form-data" id="submit_import_form" class="form-horizontal" method="POST" action="theme<?php echo $extension; ?>?active_tab=import_theme">





                                                    <?php

                                                    echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET_THEME'].'" />';

                                                    ?>





                                                    <fieldset>

                                                        <?php

                                                        $key_query1 = "SELECT DISTINCT tag_name FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor' ORDER BY tag_name ASC";

                                                        $query_results1=mysql_query($key_query1);

                                                        $count_ssid = mysql_num_rows($query_results1);



                                                        if($count_ssid == 0){

                                                           /*  $warning_text = '<div class="alert alert-warning" role="alert"><h3><i class="icon-warning-sign"></i> Warning! <small>';

                                                            $warning_text .= '<br>Please create a <a href="location.php?t=3" class="alert-link">Group Tag / Location</a> before trying to create a theme';

                                                            $warning_text .= '</small></h3></div>'; */



                                                            echo $warning_text;

                                                        }

                                                        ?>

                                                        <div class="control-group">

                                                        <div class="header2_part1"><h2>What is a Captive Portal Theme?</h2></div>



                                                           <br>

														   <script>




														   </script>


												<!--<div class="" id="dum" style="display: inline-block;">  -->

												<div style="display: inline-block;">

															<p>A Captive Portal provides a "walled garden" with internet access managed by a customizable webpage. Guests will automatically be redirected to the Captive Portal when they connect to your Guest Wi-Fi network.</p>


														   <p>The Theme Creator allows you to customize your portal without any knowledge of web page programming. You can select images from our stock photo gallery, upload a company logo and customize the text fields.</p>


														   <p>You can also create multiple themes for your location, but you may only enable one theme at a time. You can easily enable or disable a stored theme from the "Manage" tab.</p>

														   <p>Before you enable a theme, review it in the "Preview" tab, which allows you to review your design and registration flows prior to publishing them to your Guest Wi-Fi network. Use our multiscreen viewer or "generate a URL" function to view your design on various screen sizes prior to publishing the theme to the Guest Wi-Fi network.</p>

													</div>

													<!-- <div style="display: inline-block;" class="span2">
														<img  src="img/theme_img_002.jpg" alt="Welcome image" style="width:200px;height:300px;padding-right:70%;">
													</div>-->




                                                            <div class="controls">



                                                            </div>

                                                            <!-- /controls -->

                                                        </div>

                                                        <!-- /control-group -->



                                                        <div class="control-group">





                                                            <div class="controls">

                                                                <div class="input-prepend input-append">







                                                                </div>

                                                            </div>

                                                            <!-- /controls -->

                                                        </div>

                                                        <!-- /control-group -->


                                                    </fieldset>

                                                </form>





												<!-- /widget-content -->

											</div>

											<!-- /widget -->



										</div>



							<!-- /////////////////////////////////////////////////////////////////
							////////////////////////////////////////////////////////////////////////
							//////////////////////////////////////////////////////////////////////////-->










								





                                        <!-- ******************* language view ********************* -->

                                        <div style="display: none !important"> class="tab-pane <?php if($active_tab == 'lan_view' && getSectionType('LANGUAGE_ENABLE',$system_package,'MVNO')=='1') echo 'active'; ?>" id="lan_view">



                                            <?php

                                            if(isset($_SESSION['msg10'])){

                                                echo $_SESSION['msg10'];

                                                unset($_SESSION['msg10']);





                                            }?>



                                            <?php

                                                $query = "SELECT * FROM exp_themes WHERE theme_id = '$id_theme_lan'";

                                                $result = mysql_query($query);

                                                $line = mysql_fetch_array($result);



                                                $theme_name = $line[theme_name];

                                            ?>



                                            <div align="right" style="border:1px" >

                                                <a href="javascript:void();" id="ADD_LAN" class="btn btn-medium btn-success" style="margin-bottom: 4px;"><i class="btn-icon-only icon-plus"></i> Add</a>

                                                <script type="text/javascript">

                                                    $(document).ready(function() {

                                                        $('#ADD_LAN').easyconfirm({locale: {

                                                            title: 'Add New Language',

                                                            text: 'Are you sure,you want to add new language?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',

                                                            button: ['Cancel',' Confirm'],

                                                            closeText: 'close'

                                                        }});

                                                        $('#ADD_LAN').click(function() {

                                                            <?php echo 'window.location = "?token='.$secret.'&new_lan=1&new_lan_id='.$id_theme_lan.'"'; ?>

                                                        });

                                                    });

                                                </script>



                                                <a href="javascript:void();" id="cansel_lan" class="btn btn-medium btn-default" style="margin-bottom: 4px;"><i class="btn-icon-only icon-chevron-left"></i> Back</a>

                                                <script type="text/javascript">

                                                    $(document).ready(function() {



                                                        $('#cansel_lan').click(function() {

                                                            <?php echo 'window.location = "?token='.$secret.'&cansel=1"'; ?>

                                                        });

                                                    });

                                                </script>

                                            </div>









                                            <div class="widget widget-table action-table" >

                                                <div class="widget-header ">

                                                  <!--   <i class="icon-th-list"></i> -->

                                                    <h3>Language Management - <?php echo $theme_name; ?></h3>

                                                </div>



                                                <!-- /widget-header -->

                                                <div class="widget-content table_response" id="campcreate_div">
                                                    <div style="overflow-x:auto;" >
                                                    <table class="table table-striped table-bordered">

                                                        <thead>

                                                        <tr>

                                                            <th>Theme ID</th>

                                                            <th>Language</th>

                                                            <th>Create date</th>

                                                            <th>Status</th>





                                                            <th></th>

                                                        </tr>

                                                        </thead>

                                                        <tbody>



                                                        <?php



                                                        $key_query = "SELECT id,ref_id,theme_id, theme_name, `LANGUAGE`, registration_type,create_date,is_enable,language_string FROM exp_themes

																WHERE distributor = '$user_distributor' AND theme_type = 'LANGUAGE_THEME' AND ref_id = '$id_theme_lan' ORDER BY ref_id,ABS(is_enable-1) ASC";



                                                        $query_results=mysql_query($key_query);



                                                        while($row=mysql_fetch_array($query_results)){

                                                            $auto_id = $row['id'];

                                                            $location_ssid = $row['ref_id'];

                                                            $theme_id = $row['theme_id'];

                                                            $theme_name = $row['theme_name'];

                                                            $LANGUAGE = $row['LANGUAGE'];

                                                            $create_date = $row['create_date'];

                                                            $is_enable=$row['is_enable'];

                                                            $language_string=$row['language_string'];



                                                            echo '<tr>

																	<td> '.$theme_id.' </td>

																	<td> ';









                                                                    $query_lan = "SELECT language FROM system_languages WHERE language_code = '$LANGUAGE'";

                                                                    $result_lan = mysql_query($query_lan);

                                                                    $r = mysql_fetch_array($result_lan);

                                                                    $lan = $r[language];





                                                                echo $lan;



                                                            echo '</td>';

                                                            echo '<td> '.$create_date.' </td>';



                                                            if($is_enable==1){

                                                                echo '<td><font color=green><strong>Enable</strong></font></td>';

                                                                echo '<td>';

                                                                echo '<a href="javascript:void();" id="STL_'.$auto_id.'"  class="btn btn-small btn-danger">

																	<i class="btn-icon-only icon-thumbs-down"></i> Disable</a>&nbsp;<img  id="campcreate_loader_'.$auto_id.'" src="img/loading_ajax.gif" style="visibility: hidden;"><script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#STL_'.$auto_id.'\').easyconfirm({locale: {

																			title: \'Disable Theme ['.str_replace("'"," ",$theme_name).']\',

																			text: \'Are you sure you want to disable this theme?&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#STL_'.$auto_id.'\').click(function() {



																		window.location = "?token='.$secret.'&active_deactive=1&is_enable_lan=0&id_theme_child='.$theme_id.'&parent_id='.$id_theme_lan.'"

																		});

																		});

																	</script>';



                                                            }else{

                                                                echo '<td><font color=red><strong>Disable</strong></font></td>';

                                                                echo '<td>';

                                                                echo '<a href="javascript:void();" id="CEL_'.$auto_id.'"  class="btn btn-small btn-success">

                                                                <i class="btn-icon-only icon-thumbs-up"></i> Active&nbsp;&nbsp;&nbsp;</a>&nbsp;<img  id="campcreate_loader_'.$auto_id.'" src="img/loading_ajax.gif" style="visibility: hidden;"><script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#CEL_'.$auto_id.'\').easyconfirm({locale: {

																			title: \'Active Theme ['.str_replace("'"," ",$theme_name).']\',

																			text: \'Are you sure you want to activate this theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#CEL_'.$auto_id.'\').click(function() {

																			window.location = "?token='.$secret.'&active_deactive=1&is_enable_lan=1&id_theme_child='.$theme_id.'&parent_id='.$id_theme_lan.'"

																		});

																		});

																	</script>';

                                                            }







                                                            echo '<a id="CML_'.$theme_id.'"  class="btn btn-small btn-info"><i class="btn-icon-only icon-wrench"></i>Modify</a><img  id="down_'.$theme_id.'" src="img/loading_ajax.gif" style="visibility: hidden;"><script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#CML_'.$theme_id.'\').easyconfirm({locale: {

																			title: \'Manage Theme ['.str_replace("'"," ",$theme_name).']\',

																			text: \'Are you sure,you want to manage this theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#CML_'.$theme_id.'\').click(function() {

																			window.location = "?token='.$secret.'&modify=10&id_update_lan_theme='.$theme_id.'&lan='.$LANGUAGE.'&manage_language=1&new_lan_id_master='.$id_theme_lan.'"

																		});

																		});

																	</script>';



                                                            echo '</td>';



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

$theme_mid = 'layout/'.$camp_layout.'/views/theme_mid.php';

if(($new_design=='yes') && file_exists($theme_mid)){ 

include_once $theme_mid;

}
else{ 

	?>

		<script type="text/javascript">

$(document).on("click", function(e){  
	<?php if($modify_mode != 1) {	?>         
  val_check1("is_active");
   <?php  }	?>
});

$(document).on("click","#logo2_up .cropControls", function(e){
	          
    val_check1("logo2_up");
});

$(document).on("click","#logo1_up_bc .cropControls", function(e){
           
    val_check1("logo1_up_bc");
});

$(document).on("click","#varimg", function(e){
           
    val_check1("varimg");
});

$(document).on("click","#horimg", function(e){
           
    val_check1("horimg");
});

$(document).on("click","textarea", function(e){
           
    val_check1("greeting_txt");
});

$(document).on("click","#is_active", function(e){
           
 //   val_check1("is_active");
 <?php if($modify_mode != 1) {	?>         
  val_check1("is_active");
   <?php  }	?>
});

$(document).on("click","#btncolor", function(e){
           
    val_check1("btncolor");
});
$(document).on("click","#logo_txt1_enable", function(e){
           
    val_check1("logo_txt1_enable");
});
$(document).on("click","#logo_txt2_enable", function(e){
           
    val_check1("logo_txt2_enable");
});

$(document).on("keyup change",".colorpicker-element input[type='text']", function(e){
	var x = e.target.id;   

	setTimeout( function(){
		valid_check($('#'+x).val(),x+'_validate');
	}, 100);       
    
});



										function val_check1(x) {  

											//alert(x);
										var theme_ele = new Array("theme_name1", "location_ssid","language", "title_t","loading" ,"redirect_type","splash_url","template_name", "reg_type" , "logo1_up_bc", "logo2_up", "logo_txt2_enable" , "varimg", "horimg", "btncolor" ,"welcome","greeting_txt","is_active");
											var a = theme_ele.indexOf(x);

											for (i = 0; i < parseInt(a); i++) { 
												var this_val = $('#'+theme_ele[i]).val();

											
												
												if ( $( '#'+theme_ele[i]+'_validate' ).length ) {
													
													if(theme_ele[i]=='logo1_up_bc' || theme_ele[i]=='logo2_up'){

														var logoo1 = "#logo1_up_bc img"; 
														var logoo2 = "#logo2_up img"; 

														if($('#divlogo1:visible').length != 0){

															if($(logoo1).hasClass("croppedImg")){
															$( '#logo1_up_validate' ).hide();
															}
															else{
																$( '#logo1_up_validate' ).css('display', 'inline-block');
															}
														}
														else{
															$( '#logo1_up_validate' ).hide();
														}
														if($('#divlogo2:visible').length != 0){

															if($(logoo2).hasClass("croppedImg")){
															$( '#logo2_up_validate' ).hide();
															}
															else{
																$( '#logo2_up_validate' ).css('display', 'inline-block');
															}
														}
														else{
															$( '#logo2_up_validate' ).hide();
														}
														
														
													}
													else if(theme_ele[i]=='varimg' || theme_ele[i]=='horimg'){

														var vertical_validate = $("#slideshow img").hasClass("croppedImg");

														if($('#varimg:visible').length == 0){

															vertical_validate = true;

														}

														var horizontal_validate = $("#slideshow1 img").hasClass("croppedImg");

														if($('#horimg:visible').length == 0){
															horizontal_validate = true;
														}


														if($('input[name=verticle_img]:not(#vari):checked').length){
															vertical_validate = true;

														}

														if($('input[name=horizontal_img]:not(#hori):checked').length){
															horizontal_validate = true;

														}

														if(vertical_validate){
															$( '#varimg_validate' ).hide();
														}
														else{
															$( '#varimg_validate' ).css('display', 'inline-block');
														}

														if(horizontal_validate){
															$( '#horimg_validate' ).hide();
														}
														else{
															$( '#horimg_validate' ).css('display', 'inline-block');
														}

													}

													else if(theme_ele[i]=='splash_url'){

														if($('#reurl:visible').length != 0){

															if(this_val!=""){
																$( '#splash_url_validate' ).hide();
															}
															else{
																
																$( '#splash_url_validate' ).css('display', 'inline-block');
															}
														}
														else{
															$( '#splash_url_validate' ).hide();
														}

													}
													else if(theme_ele[i]=='loading'){
														if ($('#chk1').is(':checked')){
															$( '#loading_validate' ).hide();
														}
														else{
															valid_check(this_val,theme_ele[i]+'_validate');
														}
													}
													else{
														valid_check(this_val,theme_ele[i]+'_validate');
													}
												
												}
											}

										}

											function valid_check(this_val,err_elem){

												//alert(this_val+" - "+err_elem);

												if(err_elem == 'welcome_validate'){

													if(this_val!="" && this_val!="#aN"){

														var patt = /[-!@#<*>$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/;
											    		var this_val = patt.test(this_val);

											    		if(this_val){
											    			$('#'+err_elem).html('special characters are not allowed');
											    			$('#'+err_elem).css('display', 'inline-block');
											    		}
											    		else{
											    			$('#'+err_elem).hide();
											    		}
													}
													else{
														$('#'+err_elem).html('This is a required section');
														$('#'+err_elem).css('display', 'inline-block');
													}

												}
												else{

													if(this_val!="" && this_val!="#aN"){
														$('#'+err_elem).hide();
													}
													else{
														$('#'+err_elem).css('display', 'inline-block');
													}

												}

												

												ck_topval();

											}

											function check_logo_valid(txt_ele,err_elem){

												if ($('#'+txt_ele).prop("disabled") == false) {

												if($('#'+txt_ele).val()!=""){
													$('#'+err_elem).hide();
												}
												else{
													$('#'+err_elem).css('display', 'inline-block');
												}

												}
												else{
													$('#'+err_elem).hide();
												}
											}

								    $(function () {
									
										$('#logo_1_text').on('input', function () {
											check_logo_valid('logo_1_text','logo_1_text_validate');
										});
										$('#logo_2_text').on('input', function () {
											check_logo_valid('logo_2_text','logo_2_text_validate');
										});

								        $("#logo_txt2_enable").click(function () {

											$("#logo2_up img").remove();

								            if ($(this).is(":checked")) {

								            	$('#logo_2_text').attr('disabled', false);
								            	document.getElementById("logo_2_text").required = true;
								            	$('#divlogo2').hide();
								            	document.getElementById("image_2_name").required = false;
								            	document.getElementById("image_2_name").value = "";

												


								            } else {

								            	document.getElementById("logo_2_text").required = false;
								            	$('#logo_2_text').attr('disabled', true);
								            	document.getElementById("logo_2_text").value = "";
								            	$('#divlogo2').show();
								            	document.getElementById("image_2_name").required = true;
								            }

											check_logo_valid('logo_2_text','logo_2_text_validate');

								        });
								    });
								</script>


										<!-- ******************* create_theme ********************* -->

										<div class="tab-pane <?php if($active_tab == 'create_theme') echo 'active'; ?>" id="create_theme">

											

											<div id="en_response"></div>
<input type="hidden" id="using">
											<div class="header2_part1"><h2>Theme Creator</h2></div>


                                                  <p>The face of your Guest Wi-Fi Service.</p>

                                                  <p class=""><b>Step 1.</b> <?php echo _THEME_STEP1_TEXT_; ?></p>
												<br>

											<form id="edit-profile1" name="editprofile" class="form-horizontal" method="POST" action="theme.php" autocomplete="off">



												<input type="hidden" name="theme_modify" value="<?php echo $modify_mode; ?>">

												<input type="hidden" name="theme_id_post" value="<?php echo $theme; ?>">
												<input type="hidden" id="check_update" value="0">

												<?php

													echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET_THEME'].'" />';

												?>





												<fieldset>

                                                    <?php

                                                        $key_query1 = "SELECT DISTINCT tag_name FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor' ORDER BY tag_name ASC";

                                                        $query_results1=mysql_query($key_query1);

                                                        $count_ssid = mysql_num_rows($query_results1);



                                                        if($count_ssid == 0){

                                                            $warning_text = '<div class="alert alert-warning" role="alert"><h3><i class="icon-warning-sign"></i> Warning! <small>';

                                                            $warning_text .= '<br>Please create a <a href="campaign.php?t=4" class="alert-link">Group Tag / Location</a> before trying to create a theme';

                                                            $warning_text .= '</small></h3></div>';



                                                            echo $warning_text;

                                                        }

                                                    ?>




												<div id="val_1">
													<div class="control-group">

														<label class="control-label" for="radiobtns">Theme Name</label>



														<div class="controls">

															<div class="input-prepend input-append">



															<input type="text" class="span5" id="theme_name1" name="theme_name" maxlength="32" onkeyup="valid_check(this.value,'theme_name1_validate')"

															<?php if($modify_mode == 1) echo "value = \"".$theme_name_set."\""; ?>

															 required="required" autocomplete="off">
                                                             
                                                             <!-- onkeyup="validateShedulname(this.value)" --> <div style="display:none;" class="help-block error-wrapper bubble-pointer mbubble-pointer" id="shedule_name_dup"><p>Theme name already exists</p></div>

                                                             
                                                             

															 <small id="theme_name1_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>


<?php if($modify_mode != 1){ ?>

													<script type="text/javascript">
                                                    
                                                    $('#theme_name1').on('keyup', function(event) {

														var tname = document.getElementById("theme_name1").value;
                                                    //  alert(tname);
													//  themname(tname);
													  
													   $.ajax({
                type: 'POST',
                url: 'ajax/validateThemeName.php',
                data: {user_distributor: "<?php echo $user_distributor; ?>",tname:tname},
                success: function(data) {
					
					if(data >0){
						document.getElementById('shedule_name_dup').style.display = 'inline-block';
						}else{
						 document.getElementById('shedule_name_dup').style.display = 'none';	
							
							}
					
					}
            });
													  
													  
                                                    });

                                                    </script>
<?php } ?>


                                                                <script type="text/javascript">

                                                                    $("#theme_name1").keypress(function(event){

                                                                        var ew = event.which;
																		
                                                                        if(ew == 32 || ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35 ||ew == 45 ||ew == 95)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57)
                                                                            return true;
                                                                        if(65 <= ew && ew <= 90)
                                                                            return true;
                                                                        if(97 <= ew && ew <= 122)
                                                                            return true;
                                                                        return false;
                                                                    });

																	$('#theme_name1').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                </script>



															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->





				                       				<div class="control-group">

														<label class="control-label" for="radiobtns">Group Tag / Location</label>



														<div class="controls">

															<div class="input-prepend input-append">

																<select id="location_ssid" class="span5" name="location_ssid" required="required" onchange="valid_check(this.value,'location_ssid_validate');">





																	<?php



																		if($modify_mode == 1) {

																			//echo "<option value = \"".$edit_ref_id."\">".$edit_ref_id."</option>";
																		}

																			else {

																				//echo "<option value =''> -- Select Group Tag --</option>";

																		}

																	?>



																	<?php


																	echo "<option value =''> Select Group Tag </option>";


																		while($row1=mysql_fetch_array($query_results1)){



																			$tag_name = $row1[tag_name];

																			if($edit_ref_id==$tag_name){

																				$select='selected';

																			}else{

																				$select='';
																			}



																			echo '<option '.$select.' value="'.$tag_name.'">'.$tag_name.'</option>';

																		}



																	?>



																</select>

																<small id="location_ssid_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>



															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->









													<div class="control-group">

														<label class="control-label" for="radiobtns">Language</label>



														<div class="controls">

															<div class="input-prepend input-append">

																<select name="language" class="span5" id="language" required>



																	<?php



																	/*$key_query = "SELECT `language` FROM system_languages WHERE language_code = '$language'";



																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){



																		$language_name = $row[language];





																	}





																	if($modify_mode == 1){

																	 echo "<option value = \"".$language."\">".$language_name."</option>";

																	 }else{

																	 	echo '<option value="en">English</option>';

																	 }





																	$key_query = "SELECT language_code, `language` FROM system_languages WHERE language_code <> '$lang' AND ex_portal_status = 1 ORDER BY `language`";



																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$language_code = $row[language_code];

																		$language = $row[language];





																			echo '<option value="'.$language_code.'">'.$language.'</option>';



																	}*/

                                                                    echo '<option value="en">English</option>';



																	?>



																</select>







															</div>

														</div>

															<!-- /controls -->

													</div>

														<!-- /control-group -->





													<div class="control-group">

														<label class="control-label" for="radiobtns">Browser Title</label>



														<div class="controls">

															<div class="input-prepend input-append">

																<input type="text" id="title_t" class="span5" name="title_t" value="<?php echo $title_t; ?>" required onkeyup="valid_check(this.value,'title_t_validate')">
																<small id="title_t_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>


															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->


<script type="text/javascript">

	function enableTextBox(){
		document.editprofile.loading.disabled=false;

		addListeners();
	}

	function toggleTextBox(e){
		checkbox = e.target;

		if(checkbox.checked == true){
			if(checkbox.name == "chk1"){
				document.editprofile.loading.disabled=true;

			//	$('#loading').val("fgg");
			}

		}
		else{
			document.editprofile.loading.disabled=false;
			//$('#loading').val("fgg");
		}
	}

	function addListeners(){
	 	check1 = document.editprofile.chk1;

		check1.addEventListener('click',toggleTextBox,true );
		//$('#loading').val("fgg");
	}
	window.onload = enableTextBox;

</script>


 <script>

Toggle();

function Toggle(){

if ($('#chk1').is(':checked')){

try{
document.editprofile.loading.value='';
}catch(e){


}

}

else{

try{
document.editprofile.loading.value='Loading';
}catch(e){



}

}

}

</script>



												<!-- *************************** Text ************************** -->

													<div class="control-group">

														<label class="control-label" for="radiobtns">Loading Text</label>



														<div class="controls">

															<div class="input-prepend input-append">




															<input  class="span5 test" id="loading" <?php echo strlen($loading_txt)==0?'disabled':'' ?> name="loading" type="text" value="<?php echo $loading_txt; ?>">
															
															<br>
															<input name="chk1" id="chk1" type="checkbox" <?php echo strlen($loading_txt)==0?'checked':'' ?> onClick="Toggle()" /> No Loader


															</div>

														</div>

														<!-- /controls -->

													</div>
<?php
$sys_pack = $system_package;
//$sys_pack=$db->getValueAsf("SELECT `system_package` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

$gt_template_optioncode= getOptions('TEMPLATE_ACTIVE',$sys_pack,'MVNO');

$pieces1 = explode(",", $gt_template_optioncode);

$len1 = count($pieces1);

$outstr1="";

for($i=0;$i<$len1;$i++){

	if($i==($len1-1)){

		$outstr1=$outstr1."'".$pieces1[$i]."'";

	}else{

		$outstr1=$outstr1."'".$pieces1[$i]."',";
	}


}




if ($sys_pack!='N/A') {

$key_query_t_name = "SELECT template_id, `name`  FROM exp_template WHERE `is_enable` ='1'

							AND template_id IN ($outstr1)";

}else{

$key_query_t_name = "SELECT template_id, `name`  FROM exp_template WHERE `is_enable` ='1'";


}




?>


													<div class="control-group">

														<label class="control-label" for="radiobtns">Redirect Type</label>

														<div class="controls">

															<div class="input-prepend input-append">


															<select onchange="retype();" class="span5" id="redirect_type" name="redirect_type" required="required">

                                                            <option value="">Select Redirect Type</option>
															<option <?php if($reditct_typ=='default'){echo 'selected';} ?> value="default">Default Website</option>
															<option <?php if($reditct_typ=='thankyou'){echo 'selected';} ?> value="thankyou">Thank You Page</option>
															<option <?php if($reditct_typ=='custom'){echo 'selected';} ?> value="custom">Custom URL</option>

															</select>

															<small id="redirect_type_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>



															</div>
															</div>


														</div>

</div>

<script>

function retype(){

var type =$("#redirect_type").val();

if(type=='custom'){

	$("#reurl").show();
}else{

	$("#reurl").hide();
}

var this_val = $('#redirect_type').val();

valid_check(this_val,'redirect_type_validate');

}

function retype_ready(){

var type =$("#redirect_type").val();

if(type=='custom'){

	$("#reurl").show();
}else{

	$("#reurl").hide();
}



}


$( document ).ready(function() {



	retype_ready();
});


</script>





													<div class="control-group" id="reurl">

														<label class="control-label" for="radiobtns">Redirect URL</label>



														<div class="controls">

															<div class="input-prepend input-append">



															<select class="span2" name="urlsecure"><option <?php if($secspalsh=='http://'){echo 'selected';} ?> value="http://">http://</option><option <?php if($secspalsh=='https://'){echo 'selected';} ?> value="https://">https://</option></select>
															<input type="text" class="span3" id="splash_url" name="splash_url" placeholder="<?php
                                  echo $package_functions->getOptions('splash_page_url',$system_package); ?>"

															value="<?php echo $pathspalsh;?>"

															 >

																<script type="text/javascript">
																
																
                                                                    $("#splash_urlno").keydown(function(e) {
                                                                        var oldvalue=$(this).val();
                                                                        var field=this;
                                                                        setTimeout(function () {
                                                                            if(field.value.indexOf('http://') !== 0 && field.value.indexOf('https://') !== 0) {
                                                                                $(field).val(oldvalue);
                                                                            }
                                                                        }, 1);
                                                                    });
/*
                                                                    $(document).ready(function(){

                                                                        $('#splash_url').on('paste',function(){

                                                                        alert();
                                                                            setTimeout(functon(){
                                                                                var str = $('#splash_url').val();
                                                                                var pieces = str.split(/[//:]+/);
                                                                                if(pieces[pieces.length-2]==null){
                                                                                    $('#splash_url').value=pieces[pieces.length-1];
                                                                                }
                                                                                else{

                                                                                    $('#splash_url').value=pieces[pieces.length-2]+'//:'+pieces[pieces.length-1];
                                                                                }
                                                                            },0);

                                                                        });

                                                                    }); */


                                                                    function urlck(){


																	setTimeout(function(){

                                                                        var str = $('#splash_url').val();
                                                                        var pieces = str.split("://");

                                                                         if(pieces[pieces.length-2]==null){

                                                                              document.getElementById("splash_url").value = pieces[pieces.length-1];

                                                                        }
                                                                        else{

                                                                        	document.getElementById("splash_url").value = pieces[pieces.length-2]+'://'+pieces[pieces.length-1];

                                                                        }

																		}, 100);


                                                                        }

                                                                </script>


															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



<input type="hidden" name="edit_template_name" value="<?php echo $edit_template_name; ?>">


													<div class="control-group">

														<label class="control-label" for="radiobtns">Template Name</label>

														<div class="controls">

															<div class="input-prepend input-append">




															<select onchange="choice2(this)" class="span5" id="template_name" name="template_name" required="required">





															<?php



             if($modify_mode == 1) {

             	$template_display_name=$db->getValueAsf("SELECT `name` as f  FROM exp_template WHERE `is_enable` ='1' AND template_id='$edit_template_name'");

             	echo '<option id="'.$template_display_name.'" value="'.$edit_template_name.'">'.$template_display_name.'</option>';

             }








														//	echo '<option id="'.$edit_template_name.'" value="'.$edit_template_name.'">'.$edit_template_name.'</option>';


																		$query_results1=mysql_query($key_query_t_name);

																		while($row=mysql_fetch_array($query_results1)){

																			$temp_id = $row[template_id];

																			$temp_name = $row[name];


                                      if($temp_id!=$edit_template_name || $modify_mode != 1){
																			echo '<option id="'.$temp_name.'" value="'.$temp_id.'">'.$temp_name.'</option>';
                                      }

																		}?>



															</select>
								<img  id="loading_ajax2" src="img/loading_ajax.gif" style="display:none"></img>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<div id="txtHint"></div>

    <script type="text/javascript">

    	var $before;
    	var $before_bac;
    	var welcome_old = '';
    	var first_name_old = '';
    	var last_name_old = '';
    	var email_old = '';
    	var mobile_number_old = '';
    	var age_group_old = '';
    	var gender_old = '';
    	var male_old = '';
    	var female_old = '';
    	var other_parameters_old = '';
    	var sign_up_old = '';
    	var first_name_check = "";
		var	last_name_check = "";
		var	email_check = "";
		var	mobile_number_check = "";
		var	gender_check = "";
		var	age_group_check = "";	

    function choice2(select) {

		//$("#logo2_up img").remove();
		//$("#logo1_up img").remove();

		$("#logo2_up img").remove();
		$("#logo2_up .cropControlRemoveCroppedImage").hide();
		$("#logo1_up_bc img").remove();
		$("#logo1_up_bc .cropControlRemoveCroppedImage").hide();

		var x = select.options[select.selectedIndex].value;



		<?php 

		if($modify_mode == 1){

		?>

		

		if(x=='<?php echo $edit_template_name; ?>'){
			$($before).insertBefore("#logo2_up .cropControls");
			$($before_bac).insertBefore("#logo1_up_bc .cropControls");
			$('#image_2_name').val("<?php echo $th_logo_image; ?>");
			$('#image_1_name').val("<?php echo $th_background_image; ?>");
			welcome_old = "<?php echo $welcome_txt; ?>";
			first_name_old = "<?php echo $first_name_text; ?>";
			last_name_old = "<?php echo $last_name_text; ?>";
			email_old = "<?php echo $email_field; ?>";
			mobile_number_old = "<?php echo $edit_mobile_number_fields; ?>";
			age_group_old = "<?php echo $age_group_field; ?>";
			gender_old = "<?php echo $gender_field; ?>";
			male_old = "<?php echo $male_field; ?>";
			female_old = "<?php echo $female_field; ?>";
			other_parameters_old = "<?php echo $edit_other_fields; ?>";
			sign_up_old = "<?php echo $registration_btn; ?>";

			first_name_check = "<?php echo $manual_login_fields['first_name']; ?>";
			last_name_check = "<?php echo $manual_login_fields['last_name']; ?>";
			email_check = "<?php echo $manual_login_fields['email']; ?>";
			mobile_number_check = "<?php echo $manual_login_fields['mobile_number']; ?>";
			gender_check = "<?php echo $manual_login_fields['gender']; ?>";
			age_group_check = "<?php echo $manual_login_fields['age_group']; ?>";

		/*	    gradX("#gradX", {
        direction: "top",
        name: "duotone_bg",
        sliders: [
		   {
		     color: "<?php //echo $duotone_bg_rgba1; ?>",
		     position: <?php //echo $duotone_bg_pos1; ?>
		   },
		   {
		     color: "<?php //echo $duotone_bg_rgba2; ?>",
		     position: <?php //echo $duotone_bg_pos2; ?>
		   }
		]
    });*/

		}
		else{
			welcome_old = '';
    	 first_name_old = 'Last Name';
    	 last_name_old = 'Last Name';
    	 email_old = 'Email';
    	 mobile_number_old = 'Mobile Number';
    	 age_group_old = 'Age Range';
    	 gender_old = 'Gender';
    	 male_old = 'Male';
    	 female_old = 'Female';
    	 other_parameters_old = '';
    	 sign_up_old = 'Register';	

    	 first_name_check = "";
			last_name_check = "";
			email_check = "1";
			mobile_number_check = "";
			gender_check = "1";
			age_group_check = "1";	

			    /*  gradX("#gradX", {
        direction: "top",
        name: "duotone_bg",
        sliders: [
		   {
		     color: "rgb(211, 89, 54)",
		     position: 7
		   },
		   {
		     color: "rgb(61, 0, 0)",
		     position: 86
		   }
		]
    });*/
    
    	}
			
		<?php

		}else{

		 ?>

		 welcome_old = '';
    	 first_name_old = 'Last Name';
    	 last_name_old = 'Last Name';
    	 email_old = 'Email';
    	 mobile_number_old = 'Mobile Number';
    	 age_group_old = 'Age Range';
    	 gender_old = 'Gender';
    	 male_old = 'Male';
    	 female_old = 'Female';
    	 other_parameters_old = '';
    	 sign_up_old = 'Register';	

    	 first_name_check = "";
			last_name_check = "";
			email_check = "1";
			mobile_number_check = "";
			gender_check = "1";
			age_group_check = "1";	

			   /*   gradX("#gradX", {
        direction: "top",
        name: "duotone_bg",
        sliders: [
		   {
		     color: "rgb(211, 89, 54)",
		     position: 7
		   },
		   {
		     color: "rgb(61, 0, 0)",
		     position: 86
		   }
		]
    });*/

		 <?php } ?>

		$('#logo_txt1_enable').attr('checked', false);
		$('#logo_1_text').attr('disabled', true);
		$('#logo_1_text').val('');
		$('#divlogo1').show(); 

        document.getElementById("loading_ajax2").style.display = "";
        

		try {
			$('.cropControlUpload').show(); 
			$('.new_upload').remove(); 
			$(".cropControlsUpload").removeClass('warning_img');
			$("#logo1_up").cropper("destroy");
			$("#logo2_up").cropper("destroy");
			$("#logo1_up_bc").cropper("destroy");
			cropContaineroutput.destroy();
		} catch (error) {
			
		}

        if(x=="default_theme" || x=="red_template" || x=="altice_business_default" || x=="frontier_business_default"){

        	$("#social_first").html('<p class=""><b>Step 3.</b> On the main registration screen, the Social Media button(s) will appear at the top based on your selection. In addition, you can select which Demographic Data to collect.</p>');

        	$("#social_second").hide();
        	$("#cmnlogintxt").hide();
        	//$("#manualbutton").hide();
        	$("#ios").hide();
        	$("#ios2").hide();

        	$("#first_name").val(first_name_old);
        	$("#last_name").val(last_name_old);
        	$("#email").val(email_old);
        	$("#mobile_number").val(mobile_number_old);
        	$("#age_group").val(age_group_old);
        	$("#gender").val(gender_old);
        	$("#male").val(male_old);
        	$("#female").val(female_old);
        	$("#other_parameters").val(other_parameters_old);
        	$("#sign_up").val(sign_up_old);

        	if(first_name_check == '1'){
				
				$('#m_first_name').prop('checked', true);
			}
			else{
				$('#m_first_name').prop('checked', false);
			}
			if(last_name_check == '1'){
				
				$('#m_last_name').prop('checked', true);
			}
			else{
				$('#m_last_name').prop('checked', false);
			}
			if(email_check == '1'){
				
				$('#m_email').prop('checked', true);
			}
			else{
				$('#m_email').prop('checked', false);
			}
			if(mobile_number_check == '1'){
				
				$('#m_mobile').prop('checked', true);
			}
			else{
				$('#m_mobile').prop('checked', false);
			}
			if(gender_check == '1'){
				
				$('#m_gender').prop('checked', true);
			}
			else{
				$('#m_gender').prop('checked', false);
			}
			if(age_group_check == '1'){
				
				$('#m_age_group').prop('checked', true);
			}
			else{
				$('#m_age_group').prop('checked', false);
			}

			manual_toggle($('#m_first_name')) ;
			manual_toggle($('#m_age_group')) ;
			manual_toggle_gender($('#m_gender')) ;
			manual_toggle($('#m_mobile')) ;
			manual_toggle($('#m_email')) ;
			manual_toggle($('#m_last_name')) ;
        }
        else{
            $("#social_first").html('<p class=""><b>Step 4.</b> On the main registration screen you can set the Social Media Registration Information text and the Social Media Button text. In addition you can set the Manual Registration Information text, select which Demographic Data to collect, and set the Manual Registration Button text.</p>');

            $("#social_second").show();
            $("#cmnlogintxt").show();
            $("#manualbutton").show();
            $("#ios").show();
        	$("#ios2").show();

        }


        if(x=="red_template" || x=="altice_business_default" || x=="frontier_business_default"){

        	$("#duotone").show();
        	$("#backcolor1n2").hide();

        }
        else{
        	$("#duotone").hide();
        	$("#backcolor1n2").show();
		}
		
		if((x=='res_cox_standard_template') || (x=='res_cox_modern_hori_template')){
			$('#logo_1_txt').html('Logo Alternative Text');
			$('#logo_1_title').html('Logo or Logo Alternative Text ');
		}
		else{
			$('#logo_1_title').html('Logo or Logo Alternative Text ');
			$('#logo_1_txt').html('Logo Alternative Text');
		}

		if((x=='res_cox_modern_hori_template')){
			$('#bgcolor_txt').html('Banner Background Color');
			$('#fontcolor_txt').html('Banner Font Color');
		}
		else{
			$('#bgcolor_txt').html('Banner & Greeting Background Color');
			$('#fontcolor_txt').html('Banner & Greeting Font Color');
		}
		
		if((x=='res_cox_standard_template')){
			$('#greeting_txt').attr('maxlength', '90');
			$('#greeting_txt_txt').html('<p><b>Note: You can add your customized message to the beginning of the default Greeting Text. It can have up to 90 characters with spaces.</b></p><p>If you are using the Passcode Registration Type your Greeting Text will be followed by: <br><b> Review and agree to the Terms of Use, enter the passcode and click SUBMIT.</b></p><p>If you are using the Click to Connect Registration Type your Greeting Text will be followed by:  <br> <b> Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.  </b></p>');
			$('#banner-label').html('Property Message');
			$('#banner-def-txt').hide();
			$('#banner-under-txt').html('<b>Note: You can add in Customizable description or message from the property. It can have up to 350 characters with spaces.</b>');
			$('#welcome').replaceWith('<textarea id="welcome" class="span4" onkeyup="valid_check(this.value,\'welcome_validate\')" maxlength="350" name="welcome"style="padding: 10px;border: 1px solid #979798;padding-left: 20px !important;padding-right: 20px !important;height: 72px;" ></textarea>');
			$('#welcome_validate').hide();
		}
		else{
			$('#greeting_txt').attr('maxlength', '90');
			$('#greeting_txt_txt').html('<p><b>Note: You can add your customized message to the beginning of the default  Greeting Text, it can have up to 90 characters with spaces.</b></p> <p>If you are using the Passcode Registration Type your Greeting Text will be followed by: <br> <p><b> Review and agree to the Terms of Use, enter the passcode and click SUBMIT.</b></p><p>If you are using the Click to Connect Registration Type your Greeting Text will be followed by: <br> <b> Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.  </b></p>');
			$('#banner-label').html('Banner Text');
			$('#banner-def-txt').show();
			$('#banner-under-txt').html('<b>Note: You can add in your business name to the end of the default Banner Text. It can have up to 30 characters with spaces.</b>');
			$('#welcome').replaceWith('<input type="text" id="welcome" onkeyup="valid_check(this.value,\'welcome_validate\')" maxlength="30" name="welcome" class="span4" required="required" placeholder="Enter customer name text" value="'+ welcome_old +'">');
			$('#welcome_validate').hide();
		}

		if((x=='res_cox_block_template')){
			$('#logo_txt2_enable').attr('checked', false);
			$('#logo_2_text').attr('disabled', true);
			$('#logo_2_text').val('');
			
		}
        // if(x=="default_theme"){

        // 	$("#backcolor").show();

        // }
        // else{
        //     $("#backcolor").hide();
        // }

        var z = 'x='+x+'&var_img=&hor_img='
		var z2 = '<?php echo $user_distributor; ?>';

        	$("#varimg").show();
        	$("#horimg").show();

             $("#img_ajax").html('');
            $.post("ajax/theme_image_load.php", {dir_name: z,discode: z2}, function(result){

                    var txtArr = result.split(":||:");


                    $("#up_logo_name1").html(txtArr[0]);
                    $("#up_logo_desc1").html(txtArr[1]);
                    $("#up_logo_name2").html(txtArr[2]);
                    $("#up_logo_desc2").html(txtArr[3]);
                    $("#img_ajax").html(txtArr[4]);
                    var check_img1=document.getElementById("check_img1").value;
                    var check_img2=document.getElementById("check_img2").value;
                    var check_img3=document.getElementById("check_img3").value;

                    if(check_img1 == 0){
                        $("#backimg").hide();

                    }
                    else{
                        $("#backimg").show();
                    }
                    if(check_img2 == 0){
                        $("#logoimg").hide();
                        $("#alttxt2").hide();


                    }
                    else{
                         $("#logoimg").show();
                         $("#alttxt2").show();
                    }
                    if(check_img3 == 0){

                         $("#varimg").hide();
                    }
                    else{
                         $("#varimg").show();
                    }

                    var width_2 = $(window).width();

                    var width_table_res = $(".main-inner").children().first().width();

                    var width_table_res1 = width_table_res - 30;
                    $(".table_response").css("width", width_table_res1);

                    if(width_2<463){
                        var width_table_res2 = width_table_res - 30;
                    }
                    else{
                        var width_table_res2 = width_table_res - 220;
                    }

                    $(".theme_response").css("width", width_table_res2);

                    });

        	//  }

          $.ajax({
                type: 'POST',
                url: 'ajax/template_hide_load.php',
				dataType : 'json',
                data: "id="+x,
                success: function(response) {

				var data = response.hide_divs;
				

				var obj = JSON.parse(response.options);
				
				try {
					$.map(obj, function(el, key) { 

					$.map( el, function( value ) {
							  if(key == 'text'){
									$('#'+value.id).html(value[key]);
							  }
							  else{
								  $('#'+value.id).attr(key, value[key]);
							  }
					});
					
				});
				
				}catch(err) {}
				

                var res = data.split(",");
                var alen = res.length;

	        	$("#backcolor").show();
                $("#mregbtn").show();
	        	$("#color").show();

	        	$("#mregbtn").show();

	        	$("#step5").show();
	        	$("#limg").show();
	        	$("#wback").show();
	        	$("#footera").show();
	        	$("#txt_hide").show();

				$("#hrcolor").show();
	        	$("#fontcolor").show();


				for (i = 0; i < alen; i++) {


					$('#'+res[i]).hide();

				}


                }
            });


temp_image();



    		}




    </script>

	<script type="text/javascript">


	$(document).ready(function() {

		$before = $("#logo_hi_2").clone(true);
		$before_bac = $("#logo1_up_bc").clone(true);

		var x = $("#template_name").val();
        var x1 = $("#reg_type").val();
		//console.log(x);

		if(x1=='AUTH_DISTRIBUTOR_PASSCODE'){
					var template_name1 = (x + '_pas');
				}
				else{
					var template_name1 = (x + '_' + x1);
				}

				<?php  

				$template_image_suffix = $pack_func->getOptions('template_image_suffix',$system_package); 

				if(strlen($template_image_suffix) > 0){

				?>

				var xx = x1 + '_<?php echo $template_image_suffix; ?>';

				<?php }else{ ?>

				var xx = x1;

				<?php } ?>
				
        var y = '<center><img src="<?php echo $base_portal_folder; ?>/template/'+x+'/img/'+xx+'.jpg?v=14" style="max-height:320px;width:60%;    max-width: 100%;"><p><a id="pre_id" class="fancybox fancybox.iframe" href="<?php echo $base_portal_folder; ?>/checkpoint.php?client_mac=DEMO_MAC&theme='+template_name1+'&realm=<?php echo $db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");?>">Preview Template Layout</a></center>';

       // console.log(y);
        document.getElementById("template_image").innerHTML=y;
	     //  var x = select.options[select.selectedIndex].value;


	        //if(x=="default_theme"){

	        	//$("#varimg").hide();
	        	//$("#horimg").hide();
	        	// document.getElementById("template_image").innerHTML='';

	           // }
	      //  else{


			if((x=='res_cox_standard_template') || (x=='res_cox_modern_hori_template')){
				$('#logo_1_txt').html('Logo Alternative Text');
			}
			else{
				$('#logo_1_txt').html('Logo Alternative Text');
			}

			if((x=='res_cox_modern_hori_template')){
			$('#bgcolor_txt').html('Banner Background Color');
			$('#fontcolor_txt').html('Banner Font Color');
		}
		else{
			$('#bgcolor_txt').html('Banner & Greeting Background Color');
			$('#fontcolor_txt').html('Banner & Greeting Font Color');
		}
		
		if((x=='res_cox_standard_template')){
			$('#greeting_txt').attr('maxlength', '90');
			$('#greeting_txt_txt').html('<p><b>Note: You can add your customized message to the beginning of the default Greeting Text. It can have up to 90 characters with spaces.</b></p><p>If you are using the Passcode Registration Type your Greeting Text will be followed by: <br><b> Review and agree to the Terms of Use, enter the passcode and click SUBMIT.</b></p><p>If you are using the Click to Connect Registration Type your Greeting Text will be followed by:  <br> <b> Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.  </b></p>');
			$('#banner-label').html('Property Message');
			$('#banner-def-txt').hide();
			$('#banner-under-txt').html('<b>Note: You can add in Customizable description or message from the property. It can have up to 350 characters with spaces.</b>');
			
			<?php if($modify_mode == 1) { 
				
			 	$txt_new = $welcome_txt ;

			}
			else{
				$txt_new = '' ;
			}
				
			?>
			
			$('#welcome').replaceWith('<textarea id="welcome" class="span4" onkeyup="valid_check(this.value,\'welcome_validate\')" maxlength="350" name="welcome"style="padding: 10px;border: 1px solid #979798;padding-left: 20px !important;padding-right: 20px !important;height: 72px;" ><?php echo $txt_new; ?></textarea>');
			$('#welcome_validate').hide();
			
		}
		else{


			<?php if($modify_mode == 1) { 
				
			 	$txt_new = $welcome_txt ;

			}
			else{
				$txt_new = '' ;
			}
				
			?>

			$('#greeting_txt').attr('maxlength', '90');
			$('#greeting_txt_txt').html('<p><b>Note: You can add your customized message to the beginning of the default  Greeting Text, it can have up to 90 characters with spaces.</b></p> <p>If you are using the Passcode Registration Type your Greeting Text will be followed by: <br> <b> Review and agree to the Terms of Use, enter the passcode and click SUBMIT.</b></p><p>If you are using the Click to Connect Registration Type your Greeting Text will be followed by: <br> <b> Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.  </b></p>');
			$('#banner-label').html('Banner Text');
			$('#banner-def-txt').show();
			$('#banner-under-txt').html('<b>Note: You can add in your business name to the end of the default Banner Text. It can have up to 30 characters with spaces.</b>');
			$('#welcome').replaceWith('<input type="text" id="welcome" onkeyup="valid_check(this.value,\'welcome_validate\')" maxlength="30" name="welcome" class="span4" required="required" placeholder="Enter customer name text" value="<?php echo $txt_new; ?>">');
			$('#welcome_validate').hide();
		}


	      var z = 'x='+x+'&var_img=<?php echo $edit_var_img; ?>&hor_img=<?php echo $edit_hor_img; ?>'
	      var z2 = '<?php echo $user_distributor; ?>';


	        	$("#varimg").show();
	        	$("#horimg").show();

	             $("#img_ajax").html('');

	            $.post("ajax/theme_image_load.php", {dir_name: z,discode: z2}, function(result){

	                    var txtArr = result.split(":||:");


	                    $("#up_logo_name1").html(txtArr[0]);
	                    $("#up_logo_desc1").html(txtArr[1]);
	                    $("#up_logo_name2").html(txtArr[2]);
	                    $("#up_logo_desc2").html(txtArr[3]);
	                    $("#img_ajax").html(txtArr[4]);

	                    var check_img1=document.getElementById("check_img1").value;
	                    var check_img2=document.getElementById("check_img2").value;
	                    var check_img3=document.getElementById("check_img3").value;

	                    if(check_img1 == 0){
	                        $("#backimg").hide();

	                    }
	                    else{
	                        $("#backimg").show();
	                    }
	                    if(check_img2 == 0){
	                        $("#logoimg").hide();
	                        $("#alttxt2").hide();

	                    }
	                    else{
	                         $("#logoimg").show();
	                         $("#alttxt2").show();
	                    }
	                    if(check_img3 == 0){

	                         $("#varimg").hide();
	                    }
	                    else{
	                         $("#varimg").show();
	                    }

	                    });

	        	//  }

	            $.ajax({
	                type: 'POST',
					url: 'ajax/template_hide_load.php',
					dataType : 'json',
	                data: "id="+x,
	                success: function(response) {

					var data = response.hide_divs;
					var obj = JSON.parse(response.options);

					try {
					$.map(obj, function(el, key) { 

					$.map( el, function( value ) {
							  if(key == 'text'){
									$('#'+value.id).html(value[key]);
							  }
							  else{
								  $('#'+value.id).attr(key, value[key]);
							  }
					});
					
					});
					
					}catch(err) {}

	                var res = data.split(",");
	                var alen = res.length;

		        	


					for (i = 0; i < alen; i++) {


						$('#'+res[i]).hide();

					}

					if($('#logo_txt2_enable').is(":checked")){
											$('#divlogo2').hide();
										}


	                }
	            });







////



















		var conceptName = $('#template_name').find(":selected").text();
		var x = document.getElementById("#template_name");


		if(conceptName=="Default Template" ){


        	$("#varimg").hide();
        	$("#horimg").hide();
        	//document.getElementById("template_image").innerHTML='';

        	$("#mregbtn").show();
        	$("#color").show();

        	$("#mregbtn").show();

        	$("#step5").show();
        	$("#limg").show();
        	$("#wback").show();
        	$("#footera").show();

            }
		else{

	       // document.getElementById("template_image").innerHTML='<center><img  src="<?php //echo $base_url; ?>/template/'+x+'/img/template_image.jpg" width="400px;"></center>';

        	/* $("#varimg").show();
        	$("#horimg").show();

        	$("#mregbtn").hide();
        	$("#color").hide();

        	$("#mregbtn").hide();

        	$("#step5").hide();
        	$("#limg").hide();
        	$("#wback").hide();
        	$("#footera").hide(); */

            }



});


</script>

	<script type="text/javascript">

	$(document).ready(function() {






});


</script>


													<!-- /control-group -->


													<div class="control-group">

														<label class="control-label" for="radiobtns">Registration Type</label>



														<div class="controls">

															<div class="input-prepend input-append">


	<script type="text/javascript" src="js/jquery.select.js"></script>

    <script type="text/javascript">

    function choice1(select) {
        var x = select.options[select.selectedIndex].value;
        document.getElementById("loading_ajax1").style.display = "";

        if(x=="CLICK"){


         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
         try {document.getElementById("m_first_name").checked = false;}catch(err) {}
         try {document.getElementById("m_last_name").checked = false;}catch(err) {}
         try {document.getElementById("m_email").checked = false;}catch(err) {}
         try {document.getElementById("m_gender").checked = false;}catch(err) {}
         try {document.getElementById("m_mobile").checked = false;}catch(err) {}
         try {document.getElementById("m_age_group").checked = false;}catch(err) {}

            }
        else if(x=="FB" ){

         try {$("#social").show();}catch(err) {}
         try {$("#ios").show();}catch(err) {}
         try {$("#ios2").show();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#manualbutton").hide();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
           }
        else if(x=="FB_MANUAL" ){

         try {$("#social").show();}catch(err) {}
         try {$("#ios").show();}catch(err) {}
         try {$("#ios2").show();}catch(err) {}
         try {$("#manual").show();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
           }
        else if(x=="MANUAL" ){

         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").show();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}
           }
        else if(x=="AUTH" ){

         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").show();}catch(err) {}
           }
        else if(x=="AUTH_DISTRIBUTOR_PASSCODE" ){

         try {$("#social").hide();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").hide();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}

           }
        else{
         try {$("#social").show();}catch(err) {}
         try {$("#ios").hide();}catch(err) {}
         try {$("#ios2").hide();}catch(err) {}
         try {$("#manual").show();}catch(err) {}
         try {$("#manualbutton").show();}catch(err) {}
         try {$("#voucher").hide();}catch(err) {}


            }

            var x = $("#template_name").val();

				if(x=="default_theme" || x=="red_template" || x=="altice_business_default" || x=="frontier_business_default"){

			        	$("#social_first").html('<p class=""><b>Step 3.</b> On the main registration screen, the Social Media button(s) will appear at the top based on your selection. In addition, you can select which Demographic Data to collect.</p>');

			        	$("#social_second").hide();
			        	$("#cmnlogintxt").hide();
			        	//$("#manualbutton").hide();
			        	$("#ios").hide();
        				$("#ios2").hide();

			    }
			    else{
			    		$("#ios").hide();
        				$("#ios2").hide();
			    }
			    

            temp_image();

      }

    </script>
    <script>
            function temp_image(){

                var template_name=document.getElementById("template_name").value;
                var reg_type=document.getElementById("reg_type").value;

				if(reg_type=='AUTH_DISTRIBUTOR_PASSCODE'){
					template_name1 = (template_name + '_pas');
				}
				else{
					template_name1 = (template_name + '_' + reg_type);
				}


				<?php  

				$template_image_suffix = $pack_func->getOptions('template_image_suffix',$system_package); 

				if(strlen($template_image_suffix) > 0){

				?>

				var xx = reg_type + '_<?php echo $template_image_suffix; ?>';

				<?php }else{ ?>

				var xx = reg_type;

				<?php } ?>



                $.post("ajax/temp_image_load.php", {template_name: template_name,template_name1: template_name1,image: xx ,reg_type: reg_type,rm:'<?php echo $db->getValueAsf("SELECT `group_number` AS f FROM `exp_distributor_groups` WHERE `distributor`='$user_distributor' LIMIT 1");?>'}, function(result){

                var txtArr = result.split(":||:");
                document.getElementById("using").innerHTML= txtArr[1];


                var check = document.getElementById("checking").value ;
                    if(check == "error"){

                    }
                    else{


$('#template_image').hide().html(txtArr[0]).fadeIn('slow');

                                 //document.getElementById("loading_ajax2").style = "display:none";
                                 //document.getElementById("loading_ajax1").style = "display:none";

                                 document.getElementById("loading_ajax2").style.display = "none";
                                 document.getElementById("loading_ajax1").style.display = "none";




                }
                });


            }

    </script>

<script type="text/javascript">

$(document).ready(function() {

	  //var conceptName = $('#reg_type').find(":selected").text();
	  var conceptName = $( "#reg_type" ).val()

	  if(conceptName=="FB_MANUAL" ){

	   try {$("#social").show();}catch(err) {}
	   try {$("#ios").show();}catch(err) {}
	   try {$("#ios2").show();}catch(err) {}
	   try {$("#manual").show();}catch(err) {}
	   try {$("#manualbutton").show();}catch(err) {}
	   try {$("#voucher").hide();}catch(err) {}

	            }
	  else if(conceptName=="CLICK"){

	   try {$("#social").hide();}catch(err) {}
	   try {$("#ios").hide();}catch(err) {}
	   try {$("#ios2").hide();}catch(err) {}
	   try {$("#manual").hide();}catch(err) {}
	   try {$("#voucher").hide();}catch(err) {}
	   try {document.getElementById("m_first_name").checked = false;}catch(err) {}
	   try {document.getElementById("m_last_name").checked = false;}catch(err) {}
	   try {document.getElementById("m_email").checked = false;}catch(err) {}
	   try {document.getElementById("m_gender").checked = false;}catch(err) {}
	   try {document.getElementById("m_mobile").checked = false;}catch(err) {}
	   try {document.getElementById("m_age_group").checked = false;}catch(err) {}

	            }
	  else if(conceptName=="FB" ){

	   try {$("#social").show();}catch(err) {}
	   try {$("#ios").show();}catch(err) {}
	   try {$("#ios2").show();}catch(err) {}
	   try {$("#manual").hide();}catch(err) {}
	   try {$("#manualbutton").hide();}catch(err) {}
	   try {$("#voucher").hide();}catch(err) {}
	           }
	  else if(conceptName=="MANUAL" ){

	   try {$("#social").hide();}catch(err) {}
	   try {$("#ios").hide();}catch(err) {}
	   try {$("#ios2").hide();}catch(err) {}
	   try {$("#manual").show();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").hide();}catch(err) {}
	           }
	        else if(conceptName=="AUTH" ){

	         try {$("#social").hide();}catch(err) {}
	         try {$("#ios").hide();}catch(err) {}
	         try {$("#ios2").hide();}catch(err) {}
	         try {$("#manual").hide();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").show();}catch(err) {}
	           }
	        else if(conceptName=="AUTH_DISTRIBUTOR_PASSCODE" ){

	         try {$("#social").hide();}catch(err) {}
	         try {$("#ios").hide();}catch(err) {}
	         try {$("#ios2").hide();}catch(err) {}
	         try {$("#manual").hide();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").hide();}catch(err) {}

	           }
	        else{

	         try {$("#social").show();}catch(err) {}
	         try {$("#ios").hide();}catch(err) {}
	         try {$("#ios2").hide();}catch(err) {}
	         try {$("#manual").show();}catch(err) {}
	         try {$("#manualbutton").show();}catch(err) {}
	         try {$("#voucher").hide();}catch(err) {}


	            }


	         var x = $("#template_name").val();

				if(x=="default_theme" || x=="red_template" || x=="altice_business_default" || x=="frontier_business_default"){

			        	$("#social_first").html('<p class=""><b>Step 3.</b> On the main registration screen, the Social Media button(s) will appear at the top based on your selection. In addition, you can select which Demographic Data to collect.</p>');

			        	$("#social_second").hide();
			        	$("#cmnlogintxt").hide();
			        	//$("#manualbutton").hide();
			        	$("#ios").hide();
        				$("#ios2").hide();

			    }
			    else{
			            $("#social_first").html('<p class=""><b>Step 4.</b> On the main registration screen you can set the Social Media Registration Information text and the Social Media Button text. In addition you can set the Manual Registration Information text, select which Demographic Data to collect, and set the Manual Registration Button text.</p>');

			            $("#social_second").show();
			            $("#cmnlogintxt").show();
			            $("#manualbutton").show();
			            $("#ios").show();
        				$("#ios2").show();

			    }

			    if(x=="red_template" || x=="altice_business_default" || x=="frontier_business_default"){

		        	$("#duotone").show();
		        	$("#backcolor1n2").hide();

		        }
		        else{
		        	$("#duotone").hide();
		        	$("#backcolor1n2").show();
		        }



	});

function change_back(){
                            var template_name = document.getElementById("template_name").value ;
                            if(template_name=="default_theme"){
                                document.getElementById("check_back").value = "0";
                                document.getElementById("check_color").value = "1";
                            }
}

</script>



<?php




$gt_reg_optioncode= getOptions('THEME_REG_TYPE',$sys_pack,'MVNO');

$pieces = explode(",", $gt_reg_optioncode);


$len = count($pieces);

$outstr="";

for($i=0;$i<$len;$i++){

	if($i==($len-1)){

		$outstr=$outstr."'".$pieces[$i]."'";

	}else{

		$outstr=$outstr."'".$pieces[$i]."',";
	}


}


?>
																<select id="reg_type" class="span5" name="reg_type" required="required" onchange="choice1(this)">





																	<?php







																		if($modify_mode == 1) {
                                                                            $key_query = "SELECT theme_name FROM exp_theme_manager WHERE theme_code = '$registration_type'";

                                                                            $query_results=mysql_query($key_query);

                                                                            while($row=mysql_fetch_array($query_results)){

                                                                                $theme_name = $row[theme_name];

                                                                            }
																		    echo "<option value = \"".$registration_type."\">".$theme_name."</option>";
																		}



																		if ($system_package!='N/A') {

																			$key_query = "SELECT theme_code, theme_name FROM exp_theme_manager WHERE theme_type = 'NEW' AND is_enable='1'

																			AND theme_code IN ($outstr)";

																		}else{

																			$key_query = "SELECT theme_code, theme_name FROM exp_theme_manager WHERE theme_type = 'NEW' AND is_enable='1'";


																		}









																		$query_results=mysql_query($key_query);

																		while($row=mysql_fetch_array($query_results)){

																		echo	$theme_id = $row[theme_code];

																			$theme_name = $row[theme_name];

                                      echo registration_type;

                                      if($registration_type!=$theme_id || $modify_mode != 1){
																			echo '<option id="'.$theme_name.'" value="'.$theme_id.'">'.$theme_name.'</option>';
                                      }

																		}



																	?>



																</select>


                                                <img  id="loading_ajax1" src="img/loading_ajax.gif" style="display:none"></img>

																		
															</div>
<p style="font-size: 90%;"><b>Note: If Passcode Authentication is selected, please validate your current passcode generation method or change it as desired. It is currently set to the following: <small class="a" style="color: #f91f1f !important;"><?php echo $pass_type.' - '.$voucher_number; ?></small></b>
														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->


<!-- ////////////////////////////////////////////////////// -->


	<script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

	            <script type="text/javascript">
				$(document).ready(function() {

					$("#pre_id").fancybox({
						'transitionIn'	:	'elastic',
						'transitionOut'	:	'elastic',
						'speedIn'		:	600,
						'speedOut'		:	200,
						'overlayShow'	:	false,
				        'width'         :   "90%",
				        'height'        :   "100%",
				        afterShow: function () {
					        var customContent = "<button id='fancy_close' style='margin-top: 30px; display: none'></button>";
 							$('.fancybox-skin').append(customContent);

 							$('#fancy_close').click(function(event) {
								$.fancybox.close();

							});
					    }
					});




				});
			</script>

			<style>
				.fancybox-skin{
					text-align: right ;
				}
			</style>




<div id="template_image" style="text-align: center;">

</div>





<div id="imgupload">


													<hr>
													<div class="control-group">
                                                    <p class=""><b>Step 2.</b> <!-- <small class="a" >Note all sections are required with exception of background color, font color and horizontal line color.</small>  -->Upload your company logo and a background image to give the Theme a familiar look & feel for your guests. You must click the "Save" icon to save the uploaded image.</p>
													</div>



													 



										<div id="backimg" >

                                            <?php //if($edit_template_name=='res_cox_block_template'){ ?>
										<!-- <h4 id="logo_1_title" style="display: inline-block">Logo 1 or Logo 1 Alternative Text</h4> -->
                                            <?php //}else{ ?>
                                            <h4 id="logo_1_title" style="display: inline-block">Logo or Logo Alternative Text</h4>
                                            <?php //} ?>
										<small id="logo1_up_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;margin-left: 40px;"><p>This is a required section</p></small>
										<br>
										<br>
										

				                                	
<div id="divlogo1" class="control-group">
														<label class="control-label" id="up_logo_name1" for="radiobtns">Logo </label>



														<div class="controls uprel">

				<?php

				$back_or_logo=$package_functions->getOptions('LOGO_OR_BACK',$sys_pack,'MVNO');


				if($back_or_logo=='logo'){ ?>

													<div id="logo1_up">
					<?php if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION)){?>
													<img id="logo_hi_1" class="croppedImg" src="<?php echo $original_bg_Image_Folder.$th_background_image; ?>" style="width: 193px;height: 71px;">
					<?php }?>
													</div>

													<input type="hidden" name="image_1_name" id="image_1_name" value="<?php echo $th_background_image; ?>" />
													
	<p style="font-size: 90%;"><b>Note: Upload your primary logo. Best aspect ratio is 8 Width x 3 Height and Max Size: 200Kb.</b>

	<!-- <img  src=" //$original_bg_Image_Folder.$th_background_image;  style='width:125px;height:100px; display:inline;'>  -->

		 <script>

	

		var croppicContaineroutputMinimallogo1 = {
				uploadUrl:'plugins/img_upload/img_save_to_file_png.php?baseportal=<?php echo $base_portal_folder; ?>&imname=image_1_name&himg=logo_hi_1',
				cropUrl:'plugins/img_upload/img_crop_to_file_logo1.php?discode=<?php echo $user_distributor; ?>&baseportal=<?php echo $base_portal_folder; ?>',
				modal:true,
				doubleZoomControls:false,
			    rotateControls: false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){   },
				onAfterImgUpload: function(){ $('.cropControlUpload').hide(); if($('.new_upload').length == 0) { $("div:not(#logo1_up) > .cropControlsUpload").append(" <p class='new_upload'>Please save Logo 1</p>"); $("div:not(#logo1_up) > .cropControlsUpload").addClass('warning_img'); } },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){  },
				onAfterImgCrop:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); },
				onReset:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); },
				onError:function(errormessage){ $('.cropControlUpload').show(); $('.new_upload').remove(); $("d.cropControlsUpload").removeClass('warning_img'); }
		}
		var cropContaineroutput = new Croppic('logo1_up', croppicContaineroutputMinimallogo1);



	</script>


<?php }else{ ?>


													<div id="logo1_up_bc">

														<div class="slider_change"></div>

					<?php if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION)){?>
													<img id="logo_hi_3" class="croppedImg" src="<?php echo $original_bg_Image_Folder.$th_background_image; ?>" style="width: 300px; height: 150px;">
						<?php }?>
													</div>

													<?php if($modify_mode==1 && pathinfo($th_background_image, PATHINFO_EXTENSION)){?>
												
						<input type="hidden" name="background_img_check" id="background_img_check" value="1" />
					<?php } else{ ?>
						<input type="hidden" name="background_img_check" id="background_img_check" value="0" />
					<?php } ?>

													<input type="hidden" name="image_1_name" id="image_1_name" value="<?php echo $th_background_image; ?>" />
												
	<p style="font-size: 90%;"><b></b>

	<!-- <img  src=" //$original_bg_Image_Folder.$th_background_image;  style='width:125px;height:100px; display:inline;'>  -->

		 <script>


		var croppicContaineroutputMinimallogo1 = {
				uploadUrl:'plugins/img_upload/img_save_to_file_png_bc.php?baseportal=<?php echo $base_portal_folder; ?>&imname=image_1_name&himg=logo_hi_3',
				cropUrl:'plugins/img_upload/img_crop_to_file_back1.php?discode=<?php echo $user_distributor; ?>&baseportal=<?php echo $base_portal_folder; ?>',
				modal:true,
				doubleZoomControls:false,
			    rotateControls: false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){  },
				onAfterImgUpload: function(){ $('.cropControlUpload').hide(); if($('.new_upload').length == 0) { $("div:not(#logo1_up_bc) > .cropControlsUpload").append(" <p class='new_upload'>Please save images</p>"); $("div:not(#logo1_up_bc) > .cropControlsUpload").addClass('warning_img'); }  },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCroplogo1_up_bc') },
				onAfterImgCrop:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); $('#background_img_check').val('1'); $('#logo1_up_bc').prepend('<div class="slider_change"></div>'); setColor($('.slider').slider("option", "value")); },
				onReset:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); $('#background_img_check').val('0'); },
				onError:function(errormessage){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); $('#background_img_check').val('0'); }
		}
		var cropContaineroutput = new Croppic('logo1_up_bc', croppicContaineroutputMinimallogo1);




	</script>




<?php }?>

     <?php





                                                        if(strlen($th_background_image)>0 && $_GET['modify'] == 1 && $edit_template_name=="default_theme"){

                                                             if(preg_match('/^#[a-f0-9]{6}$/i', $th_background_image)) //hex color is valid
                                                                {
                                                                    $bg_dft_img1 = $th_background_image ;
																}
															}
                                                                 ?>
                                                                 <!-- <div id="background_img_check_rem">
                                                                     <input type="checkbox" id="background_img_check" name="background_img_check">
                                                                     <lable>Use background color</lable>
                                                                 </div> -->
                                                                 



														</div>
														</div>

														<!-- /controls -->

<?php

$alernative_text=(array)json_decode($package_functions->getOptions('THEME_ALTERNATIVE_TEXT',$sys_pack,'MVNO'));
//print_r($alernative_text);

if($alernative_text['Background']=='1'){

?>

													<div class="control-group" id="logo_1_txt_div">

														<label class="control-label" id="logo_1_txt" for="altext">Logo Alternative Text</label>

														<div class="controls">
															<div class="input-prepend input-append">

															<input type="text" class="span4" id="logo_1_text" maxlength="20" name="logo_1_text" placeholder="Logo text"

															<?php if($modify_mode == 1 && !pathinfo($th_background_image, PATHINFO_EXTENSION) && $back_or_logo=='logo') {echo "value =\"".$th_background_image."\" ";} ?>

															 >

															
															 <a  style="display: inline-block"><input type="checkbox" id="logo_txt1_enable"/></a>
															 <small id="logo_1_text_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px; */"><p>This is a required field</p></small>

                                                                <p><b>Note: Check the box and add in your business name instead of a logo. It can have up to 20 characters with spaces.</b></p>

																<script type="text/javascript">

                                                                    $("#logo_1_text").keypress(function(event){

                                                                        var ew = event.which;
																		
                                                                        if(ew == 32 || ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35 ||ew == 45 ||ew == 95)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57)
                                                                            return true;
                                                                        if(65 <= ew && ew <= 90)
                                                                            return true;
                                                                        if(97 <= ew && ew <= 122)
                                                                            return true;
                                                                        return false;
                                                                    });

																	$('#logo_1_text').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                </script>

															</div>
														</div>
														<!-- /controls -->
													</div>

													<!-- /control-group -->
									    <?php
                          }
                          ?>

									<?php
									if($modify_mode == 1 && (!pathinfo($th_background_image, PATHINFO_EXTENSION) || !file_exists($original_bg_Image_Folder.$th_background_image))){
									?>
                                    <script type="text/javascript">

                                            $(document).ready(function() {

                                            	document.getElementById("logo_txt1_enable").checked = true;

								            	$('#logo_1_text').attr('disabled', false);
								            	<?php if($back_or_logo=='logo'){ ?>

								            	document.getElementById("logo_1_text").required = true;

												<?php } ?>

								            	$('#divlogo1').hide();
								            	document.getElementById("image_1_name").required = false;

                                            });
                                    </script>

									<?php
									}else{
									?>

                                    <script type="text/javascript">

                                            $(document).ready(function() {

                                            	document.getElementById("logo_txt1_enable").checked = false;


								            	document.getElementById("logo_1_text").required = false;
								            	$('#logo_1_text').attr('disabled', true);
								            	document.getElementById("logo_1_text").value = "";


								            	$('#divlogo1').show();
								            	document.getElementById("image_1_name").required = true;

                                            });
                                    </script>


									<?php }?>

									 <script type="text/javascript">
								    $(function () {

										if($('#logo_txt2_enable').is(":checked")){
											$('#divlogo2').hide();
										}
								        $("#logo_txt1_enable").click(function () {

											$("#logo1_up img").remove();

								            if ($(this).is(":checked")) {

								            	$('#logo_1_text').attr('disabled', false);
								            	document.getElementById("logo_1_text").required = true;
								            	$('#divlogo1').hide();
								            	document.getElementById("image_1_name").required = false;
								            	document.getElementById("image_1_name").value = "";


								            } else {
								            	document.getElementById("logo_1_text").required = false;
								            	$('#logo_1_text').attr('disabled', true);
								            	document.getElementById("logo_1_text").value = "";
								            	$('#divlogo1').show();
								            	document.getElementById("image_1_name").required = true;
								            }

											check_logo_valid('logo_1_text','logo_1_text_validate');

								        });
								    });
								</script>


									<!-- ///////////////// -->

													


												</div>

												

                                                    <div id="backcolor" class="control-group">

													

                                                        <label class="control-label" for="radiobtns">Background Color</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">


                                                          

                                                                	<div id="back_color_div" class="input-group colorpicker-component"><input id="back_color" name="back_color" type="text" value="primary" ><span class="input-group-addon"><i></i></span></div>

                                                                	<?php 

                                                                		if($bg_dft_img1!=""){

                                                                		}else{
                                                                			$bg_dft_img1 = '#ffffff';
                                                                		}

                                                                	 ?>
				
                                                                	<!-- <input style="width:30px !important; height:30px;" class="span5 jscolor {hash:true}" id="back_color" name="back_color" type="color" value="<?php //if($bg_dft_img1!=""){echo $bg_dft_img1;}else{echo '#ffffff';} ?>" required> -->
                                                                <lable>( ** Background color applies only if no background image is uploaded)</lable>
<input type="hidden" id="back_color1">
                                                             
                                                        </div>
                                                    </div>
                                                </div>
 
                                                <div class="control-group" id="duotone">

                                                        <label class="control-label" for="radiobtns">Duotone Overlay of background image</label>

                                                        <div class="controls">

                                                           <!--  <div class="input-prepend input-append">

                                                             <div id="gradX" ></div>

                                                             <input type="hidden" name="duotone_bg_rgba1" id="duotone_bg_rgba1">
                                                             <input type="hidden" name="duotone_bg_pos1" id="duotone_bg_pos1">
                                                             <input type="hidden" name="duotone_bg_rgba2" id="duotone_bg_rgba2">
                                                             <input type="hidden" name="duotone_bg_pos2" id="duotone_bg_pos2">



                                                			<input type="hidden" class="result">

                                                            </div> -->

                                                            <div class="" style="display: block;">

                                                            	<?php   if($modify_mode==1){
                                                            				$duotone_color = $duotone_color;
                                                            				$duotone_color_bg_slider = $duotone_color_bg_slider;
                                                            				$duotone_color_bg = $duotone_color_bg;

                                                            				if(strlen($duotone_color) < 1){
                                                            					$duotone_color = $duotone_bg_rgba1;
                                                            				}

                                                            				if(strlen($duotone_color_bg_slider) < 1){
                                                            					$duotone_color_bg_slider = '7';
                                                            				}
				                                                    	}else{
				                                                    		$duotone_color = "#0cbbaa";
				                                                    		$duotone_color_bg_slider = "50";
				                                                    		$duotone_color_bg = "";

				                                                    	} ?>

                                                            <div id="duotone_color_div" class="input-group colorpicker-component"><input id="duotone_color" name="duotone_color" type="text" value="<?php echo $duotone_color; ?>" ><span class="input-group-addon"><i></i></span>

															<small id="duotone_color_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;margin-top: 0px;"><p>Invalid color code</p></small>

															
														</div>


                                                             <div style="margin-top: 20px;max-width: 300px" class="slider"></div>

                                                             <script type="text/javascript">
function setColor(val){

                                                             		//val = (parseInt(val))*15/10;
                                                             		var val2 ; 

                                                             		val2 = 0.3;

                                                             		$('#duotone_color_bg').val("background: linear-gradient(to bottom, "+ $('#duotone_color').val() +" "+val+"%, rgba(0, 0, 0, "+val2+") 100%);background: -webkit-linear-gradient(top, "+ $('#duotone_color').val() +" "+val+"%, rgba(0, 0, 0, "+val2+") 100%);background: -o-linear-gradient(top, "+ $('#duotone_color').val() +", rgba(0, 0, 0, "+val2+") 100%)");

                                                             		$(".slider_change").css({ "background": "-webkit-linear-gradient(top, "+ $('#duotone_color').val() +" "+val+"%, rgba(0, 0, 0, "+val2+") 100%)", "background": "-o-linear-gradient(top, "+ $('#duotone_color').val() +", rgba(0, 0, 0, "+val2+") 100%)", "background": "linear-gradient(to bottom, "+ $('#duotone_color').val() +" "+val+"%, rgba(0, 0, 0, "+val2+") 100%)"});

                                                             		$("#duotone_color_bg_slider").val(val);


                                                             	}
                                                             	$(document).ready(function() {

                                                             		setColor('<?php echo $duotone_color_bg_slider; ?>');

                                                             		$('#duotone_color_div').colorpicker({
																			color: '<?php echo $duotone_color; ?>',
																			useAlpha: false,
																			align : 'left'
																        }).on('changeColor', function(e) {

																        	var val = $('.slider').slider("option", "value");
																        	setColor(val);
																        });
                                                             		
                                                             	$( ".slider" ).slider({
                                                             		value: parseInt("<?php echo $duotone_color_bg_slider; ?>"),
																  change: function( event, ui ) {

																  	setColor(ui.value);
																  }
																});

                                                             	});
                                                             </script>

                                                             <style type="text/css">
                                                             	.ui-slider.ui-widget-content {
																        border: 1px solid #dddddd !important;
																}
																.slider_change{
																	width: 100%;
																    height: 100%;
																    position: absolute;
																}
                                                             </style>

                                                            </div>

                                                        </div>
                                                </div>

                                             
                                                <input type="hidden" name="duotone_color_bg" id="duotone_color_bg" value="<?php echo $duotone_color_bg; ?>">
															<input type="hidden" name="duotone_color_bg_slider" id="duotone_color_bg_slider" value="<?php echo $duotone_color_bg_slider; ?>">
                                                <!-- <div class="control-group" id="duotone2">

                                                        <label class="control-label" for="radiobtns">Duotone Overlay of the form</label>

                                                        <div class="controls">

                                                            <div class="input-prepend input-append">

                                                             <div id="gradX2" >

                                                             </div>



                                                            </div>
                                                        </div>
                                                </div> -->

                                                <style>
                                                	#gradx_show_code, #gradx_show_presets, #gradx_add_slider, .gradx_slectboxes, .gradx .mce-tinymce{
                                                		display: none !important;
                                                	}
                                                </style>





											<div>

<div id="divlogo2">


<div id="logoimg" class="control-group">

<h4 id="logo_2_title" style="display: inline-block">Logo 2 or Logo 2 Alternative Text</h4>
<small id="logo2_up_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style=" display: none; margin-left: 40px; "><p>This is a required section</p></small>
<br>
<br>
															<label class="control-label" id="up_logo_name2" for="radiobtns">Logo 2</label>



															<div class="controls uprel">

													<div id="logo2_up">
					<?php if($modify_mode==1 && pathinfo($th_logo_image, PATHINFO_EXTENSION)){?>
													<img id="logo_hi_2" class="croppedImg" src="<?php echo $original_logo_Image_Folder.$th_logo_image; ?>" style="width: 200px;height: 114px;">
					<?php }?>
													</div>

													<input type="hidden" name="image_2_name" id="image_2_name" value="<?php echo $th_logo_image; ?>" />
													
	<p style="font-size: 90%;"><b id="logo2_img_note">Note: Upload your secondary logo. Best aspect ratio is 8 Width x 3 Height and Max Size: 200Kb.</b>

	<!-- <img  src=" //$original_bg_Image_Folder.$th_background_image;  style='width:125px;height:100px; display:inline;'>  -->

		 <script>


		var croppicContaineroutputMinimallogo2 = {
				uploadUrl:'plugins/img_upload/img_save_to_file_png.php?baseportal=<?php echo $base_portal_folder; ?>&imname=image_2_name&himg=logo_hi_2',
				cropUrl:'plugins/img_upload/img_crop_to_file_logo2.php?discode=<?php echo $user_distributor; ?>&baseportal=<?php echo $base_portal_folder; ?>',
				modal:true,
				doubleZoomControls:false,
			    rotateControls: false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){  },
				onAfterImgUpload: function(){ $('.cropControlUpload').hide(); if($('.new_upload').length == 0) { $("div:not(#logo2_up) > .cropControlsUpload").append(" <p class='new_upload'>Please save Logo 2</p>"); $("div:not(#logo2_up) > .cropControlsUpload").addClass('warning_img'); }},
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCroplogo2_up') },
				onAfterImgCrop:function(){$('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); },
				onReset:function(){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); },
				onError:function(errormessage){ $('.cropControlUpload').show(); $('.new_upload').remove(); $(".cropControlsUpload").removeClass('warning_img'); }
		}
		var cropContaineroutput = new Croppic('logo2_up', croppicContaineroutputMinimallogo2);




	</script>












															</div>


</div>															<!-- /controls -->

</div>


								<!-- ///////////////// -->
<?php
if($alernative_text['Logo']=='1'){
?>
													<div id="alttxt2" class="control-group">

														<label class="control-label" for="altext">Logo 2 Alternative Text</label>

														<div class="controls">
															<div class="input-prepend input-append">

															<input type="text" class="span4" id="logo_2_text" maxlength="20" name="logo_2_text" placeholder="Logo text"

															<?php if($modify_mode == 1 && !pathinfo($th_logo_image, PATHINFO_EXTENSION)){ echo "value =\"".$th_logo_image."\" ";} ?>

															 >

															

															 <a  style="display: inline-block"><input type="checkbox" id="logo_txt2_enable"/></a>
															 <small id="logo_2_text_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px; */"><p>This is a required field</p></small>

                                                                <p><b>Note: Check the box and add in your message instead of a logo. It can have up to 20 characters with spaces.</b></p>

																<script type="text/javascript">

                                                                    $("#logo_2_text").keypress(function(event){

                                                                        var ew = event.which;
																		
                                                                        if(ew == 32 || ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35 ||ew == 45 ||ew == 95)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57)
                                                                            return true;
                                                                        if(65 <= ew && ew <= 90)
                                                                            return true;
                                                                        if(97 <= ew && ew <= 122)
                                                                            return true;
                                                                        return false;
                                                                    });

																	$('#logo_2_text').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                </script>

															</div>
														</div>
														<!-- /controls -->
													</div>

													<!-- /control-group -->

										<?php } ?>

																	<?php
									if($modify_mode == 1 && (!pathinfo($th_logo_image, PATHINFO_EXTENSION) || !file_exists($original_logo_Image_Folder.$th_logo_image))){

										
									?>
                                    <script type="text/javascript">

                                            $(document).ready(function() {

                                            	document.getElementById("logo_txt2_enable").checked = true;

								            	$('#logo_2_text').attr('disabled', false);

												<?php if($back_or_logo=='logo'){ ?>

								            	document.getElementById("logo_1_text").required = true;

												<?php } ?>

								            	document.getElementById("image_2_name").required = false;

                                            });
                                    </script>

									<?php
									}else{
									?>

                                    <script type="text/javascript">

                                            $(document).ready(function() {

                                            	document.getElementById("logo_txt2_enable").checked = false;


								            	document.getElementById("logo_2_text").required = false;
								            	$('#logo_2_text').attr('disabled', true);
								            	document.getElementById("logo_2_text").value = "";

								            	
								            	document.getElementById("image_2_name").required = true;

                                            });
                                    </script>


									<?php }?>


						


									<!-- ///////////////// -->

</div>





                                                    <div id="backcolor1n2" class="control-group">

                                                        <label class="control-label" for="radiobtns" id="bgcolor_txt">Banner & Greeting Background Color</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">

															<!-- <input style="width:30px !important; height:30px;" class="span5 jscolor {hash:true}" id="bcolor1" name="bcolor1" type="color" value="<?php //echo $edit_bg_color1; ?>" > -->
															<div id="bcolor1_div" class="input-group colorpicker-component"><input id="bcolor1" name="bcolor1" type="hidden" value="primary" ><span class="input-group-addon"><i></i></span></div>


                                                        </div>
                                                    </div>
                                                </div>

												<div id="fontcolor" class="control-group">

                                                        <label class="control-label" for="radiobtns" id="fontcolor_txt">Banner & Greeting Font Color</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">

															<!-- <input style="width:30px !important; height:30px;" class="span5 jscolor {hash:true}" id="fontcolor1" name="fontcolor1" type="color" value="<?php //echo $edit_fontcolor1; ?>"> -->
															<div id="fontcolor1_div" class="input-group colorpicker-component"><input id="fontcolor1" name="fontcolor1" type="text" value="primary" ><span class="input-group-addon"><i></i></span></div>

															

                                                        </div>
                                                    </div>
												</div>
												
												<div id="hrcolor" class="control-group">

                                                        <label class="control-label" for="radiobtns" id="hrcolor_txt">Horizontal Bar Line</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">

															
															<!-- <input style="width:30px !important; height:30px;" class="span5 jscolor {hash:true}" id="hrcolor" name="hrcolor" type="color" value="<?php //echo $edit_hr_color; ?>" > -->
															  
															<div id="hrcolor_div" class="input-group colorpicker-component"><input id="hrcolor" name="hrcolor" type="hidden" value="primary" ><span class="input-group-addon"><i></i></span></div>

															  <!--<td width="25%" class="span2">Font Color 2</td> -->
														     


                                                        </div>
                                                    </div>
                                                </div>


<style>

/* CSS Document */


.button input[type="radio"] {
    display: none;
}

.button img {
    width: 150px;
    margin:10px;
    float:left;
    -webkit-border-radius: 15px;
    border-radius: 15px;
}

input[type="radio"]:checked + label img {
    width: 140px;
    border: 5px solid red;
    -webkit-border-radius: 15px;
    border-radius: 15px;
}
@media screen and (max-width: 780px) {

    .device-node{
        margin-left: 20px !important ;
    }

}
@media screen and (max-width: 300px) {

    .widget-header h3{
        margin-right: 0px !important ;
    }

}

</style>




<div id="img_ajax">


				                                	<div id="varimg" class="control-group">

														<label class="control-label" for="radiobtns">Vertical Image</label>



														<div class=""><!-- //removed controls class -->



                                                        <script>

                                                        function select_img(a) {

                                                        	var n=$(a).data( "role" );


                                                        	document.getElementById(n).checked = true;



                                                        }

													</script>





<div id="bg_img_select">


<!-- <Table border="0" width="100%">
<tr><td colspan="2"><h1></h1><td></tr>

<tr><td> -->
<div style="overflow-x:auto" class="theme_response">
    <div id="verticle_img_invalid_msg" style="display: none;" class="verticle_img_invalid_msg"><p>This field is required.</p></div>

    <div id="slideshow">
       <label class="slideshow_prev">&lsaquo;</label>
       <ul>
<?php

$dirname = $base_portal_folder."/template/cox_block_template/gallery/verticle_img/";
$images = glob($dirname."*.jpg");
foreach($images as $image) {


$imgnames1 =explode("/",$image);
$length1=count($imgnames1);
$imagename1=$imgnames1[$length1-1];

if($edit_var_img==$imagename1){

	$select_var_img='checked';

}else{

	$select_var_img='';
}



echo '<li><div class="button">
    <input class="hide_rad" '.$select_var_img.' type="radio" name="verticle_img" value="'.$imagename1.'" id="'.$image.'"/>
    <label data-role="'.$image.'" onClick="select_img(this)" for="'.$image.'"><img  src="'.$image.'" width="150"/></label>
</div>
</li>


';

}

?>
  </ul>
        <label class="slideshow_next">&rsaquo;</label>

    </div>
</div>


<!-- </td>

<td><h2></h2></td></tr>

</table> -->
</div>

															</div>
														</div>



											<div id="horimg" class="control-group">

														<label class="control-label" for="radiobtns">Horizontal Image</label>



														<div class="">

<div id="logo_img_select">
<!-- <Table border="0" width="100%">
<tr><td colspan="2"><h1></h1><td></tr>

<tr><td> -->
<div style="overflow-x:auto" class="theme_response">
<div id="slideshow1">
       <label class="slideshow_prev1">&lsaquo;</label>
       <ul>
<?php

$dirname = $base_portal_folder."/template/cox_block_template/gallery/Horizontal_img/";
$images = glob($dirname."*.jpg");
foreach($images as $image) {

	$imgnames2 =explode("/",$image);
	$length2=count($imgnames2);
	$imagename2=$imgnames2[$length2-1];

	if($edit_hor_img==$imagename2){

		$select_hor_img='checked';

	}else{

		$select_hor_img='';
	}



echo '<li><div class="button">
    <input class="hide_rad" '.$select_hor_img.' type="radio" name="horizontal_img" value="'.$imagename2.'" id="'.$image.'" />
    <label data-role="'.$image.'" onClick="select_img(this)" for="'.$image.'"><img  src="'.$image.'" width="150" height="180px"/></label>
</div></li>';

}

?>
 </ul>
        <label class="slideshow_next1">&rsaquo;</label>

    </div>
 </div>
<!-- </td>

<td><h2></h2></td></tr>

</table> -->
</div>
															</div>
														</div>
                                                        </div>



                                                        <script>

// $(window).on("load resize",function(){
//     theme_img_responsive();
//     theme_img_responsive1();
//  });

        //an image width in pixels
        var imageWidth1 = 680;


        //DOM and all content is loaded
        $(window).ready(function() {

            set_next1();


        });

         function set_next1(){

             var currentImage1 = 0;

            //set image count
            var allImages1 = $('#slideshow1 li div.dooo').length;

            //setup slideshow frame width
            $('#slideshow1 ul').width(allImages1*imageWidth1/4);

            //attach click event to slideshow buttons
            $('.slideshow_next1').click(function(){

                //increase image counter
                currentImage1 = currentImage1 + 1;
                //if we are at the end let set it to 0
                if(currentImage1>=allImages1/4) currentImage1 = 0;
                //calcualte and set position
                setFramePosition1(currentImage1);

            });

            $('.slideshow_prev1').click(function(){

                //decrease image counter
                currentImage1 = currentImage1 - 1;
                //if we are at the end let set it to 0
                if(currentImage1<0){
                    if(allImages1 % 4 === 0){
                        currentImage1 = (allImages1/4 - 1 );
                    }
                    else{
                    currentImage1 = Math.floor(allImages1/4) ;
                    }
                }
                //calcualte and set position
                setFramePosition1(currentImage1);

            });

         }

        //calculate the slideshow frame position and animate it to the new position
        function setFramePosition1(pos1){

            //calculate position


            var px1 = imageWidth1*pos1*-1;

            //set ul left position
            $('#slideshow1 ul').animate({
                left: px1
            }, 300);
        }
    </script>
    <script>
  var imageWidth = 680;


        //DOM and all content is loaded
        $(window).ready(function() {

            set_next();

        });
         function set_next(){

            var currentImage = 0;

            //set image count
            var allImages = $('#slideshow li div.dooo').length;

            //setup slideshow frame width
            $('#slideshow ul').width(allImages*imageWidth/4);

            //attach click event to slideshow buttons
            $('.slideshow_next').click(function(){

                //increase image counter
                currentImage = currentImage + 1;
                //if we are at the end let set it to 0
                if(currentImage>=allImages/4) currentImage = 0;
                //calcualte and set position
                setFramePosition(currentImage);

            });

            $('.slideshow_prev').click(function(){

                //decrease image counter
                currentImage = currentImage - 1;
                //if we are at the end let set it to 0
                if(currentImage<0){
                    if(allImages % 4 === 0){
                        currentImage = (allImages/4 - 1 );
                    }
                    else{
                    currentImage = Math.floor(allImages/4) ;
                    }
                }
                //calcualte and set position
                setFramePosition(currentImage);

            });

         }

        //calculate the slideshow frame position and animate it to the new position
        function setFramePosition(pos){

            //calculate position


            var px = imageWidth*pos*-1;

            //set ul left position
            $('#slideshow ul').animate({
                left: px
            }, 300);
        }

    </script>



<!-- //////////////////////////////////////////////////////// -->

<!-- ///////////////////////////////////////////////////////// -->



<div id="color">


														<!-- *************************** Color ************************** -->

													<div id="btncolor" class="control-group">

														<label class="control-label" for="radiobtns">Button Design</label>



														<div class="controls">

															<div class="input-prepend input-append">


														<div id="button_color_div" class="input-group colorpicker-component"><input id="button_color" name="button_color" type="text" value="primary" ><span class="input-group-addon"><i></i></span>
															<p>(Active)</p></div>

														<div id="btn_color_disable_div" class="input-group colorpicker-component"><input id="btn_color_disable" name="btn_color_disable" type="text" value="primary" ><span class="input-group-addon"><i></i></span>
														<p>(Disabled)</p></div>

														<div id="button_ho_color_div" class="input-group colorpicker-component"><input id="button_ho_color" name="button_ho_color" type="text" value="primary" ><span class="input-group-addon"><i></i></span>
														<p>(Border)</p></div>

														<div id="button_text_color_div" class="input-group colorpicker-component"><input id="button_text_color" name="button_text_color" type="text" value="primary" ><span class="input-group-addon"><i></i></span>
														<p>(Text)</p></div>


															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->





														<?php

															$qqq = "SELECT `bg_image`,`logo_image` FROM `exp_mno_distributor` WHERE `distributor_code` = '$user_distributor'";

															$rrr = mysql_query($qqq);

															while ($row1 = mysql_fetch_array($rrr)) {

																$bg_dft_img = $row1[bg_image];

																$logo_dft_img = $row1[logo_image];

															}

														 ?>


	<!--


	 	<link href="testapi/upld/assets/css/main.css" rel="stylesheet">
    <link href="testapi/upld/assets/css/croppic.css" rel="stylesheet">



			<div class="col-lg-4 ">
				<div class="vercls" id="cropContainerMinimal"></div>
			</div>



	<script src="testapi/upld/assets/js/jquery.mousewheel.min.js"></script>
   	<script src="testapi/upld/croppic.min.js"></script>
    <script src="testapi/upld/assets/js/main.js"></script>



    <script>


		var croppicContaineroutputMinimal = {
				uploadUrl:'testapi/upld/img_save_to_file.php',
				cropUrl:'testapi/upld/img_crop_to_file.php',
				modal:true,
				doubleZoomControls:false,
			    rotateControls: false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}
		var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);




	</script>



	 -->




</div>





<!-- /////////////////////////////////////////////////////////// -->






<div id="ios">

<hr>

													<div class="control-group">
                                                    <p class=""><b>Step 3.</b> You need to create a intial start screen for Apple devices. It is a simple
																page to inform them to start the connection process. </p>
													</div>




</div>



<div id="ios2">


												<!-- <h4 style="color:#3ACC53">iOS/OSX Page</h4> -->



                                           <div class="control-group">
                                            	<div class="control-group">

                                            <table >
											  <tr>

											    <td><img  src="img/theme_img_001.jpg" width="176px;"></td>
											    <td style="padding-left: 2%">



														<div class=""><sub>Default Apple Device text using recommended Font Size 14, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

															<textarea width="500px" id="cna_page" name="cna_page" class="jqte-test textarea-tiny"> <?php echo $cna_page_field; ?> </textarea>


															</div>



														<div class=""><sub>Default button text using recommended Font Size 8, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">


															<textarea width="500px" id="cna_button" name="cna_button"  class="jqte-test textarea-tiny"> <?php echo $cna_button_field; ?> </textarea>



															</div>



												</td>

											  </tr>

											  </table>

                                                 </div>

                                              <!-- /controls -->

                                            </div>

                                      <!-- /control-group -->








 </div>






         <div id="social">



                                                    <hr>
                                                    <div class="control-group" id="social_first">
                                                    <p class=""><b>Step 4.</b> On the main registration screen you can set the Social Media Registration Information text and the Social Media Button text. In addition you can set the Manual Registration Information text, select which Demographic Data to collect, and set the Manual Registration Button text.</p>
                                                    </div>




														<!-- ************************ text area **************************** -->

													<div class="control-group" id="social_second">

														<div class="control-group">

														<table>
														<tr>
														<td>


                                                            <img src="img/theme_img_002.jpg" width="176px;"></td>

														<td style="padding-left: 2%">


														<div class=""><sub>Default Social Media text using recommended Font Size 14, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

															<textarea width="500px" maxlength="10" id="social_login" name="social_login" class="jqte-test textarea-tiny"><?php echo $social_login_txt; ?></textarea>

															</div>


															<div class=""><sub>Facebook Button Text</sub></div>

															<div class="input-prepend input-append">

															<input class="span5" id="login_with_facebook" name="login_with_facebook" type="text" value="<?php echo $fb_btn; ?>" required>

															</div>




														</td>
														</tr>
														</table>



														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->


	</div>



	<div id="manual">

<hr>

<!-- files for toggle button -->

   <!--  <script type="text/javascript" src="js/on-off-switch.js"></script>
   <script type="text/javascript" src="js/on-off-switch-onload.js"></script>
   <link rel="stylesheet" type="text/css" href="css/on-off-switch.css"/> -->

<script type="text/javascript">

function remove_img(file_id,img_dir,template_name){
	

	$.get("ajax/ajaximage_remove.php", {img_dir: img_dir,template_name: template_name,file_id: file_id},
	function (data) {
		console.log(data);
		if(data='SUCCESS'){
			$("li[data-li-value='" + file_id + "']").remove();
		}
	});
}

function manual_toggle(a)
{

	var n=$(a).data( "role" );
	var n1=$(a).data( "role1" );

    if($(a).is(":checked")){
        $("#"+n).css('display', 'inline-block');
        $("#"+n1).prop('required', true);
    }else{
        $("#"+n).hide();
        $("#"+n1).removeAttr('required');
    }
}



function manual_toggle_gender(a)
{



    if($(a).is(":checked")) {
    	$("#m_male").css('display', 'inline-block');
		$("#m_female").css('display', 'inline-block');
		$("#genderfld").css('display', 'inline-block');
		$("#genderfld").prop('required', true);
		$("#m_female").prop('required', true);
		$("#m_male").prop('required', true);

    }else{

    	$("#m_male").hide();
		$("#m_female").hide();
		$("#genderfld").hide();
		$("#genderfld").removeAttr('required');
		$("#m_female").removeAttr('required');
		$("#m_male").removeAttr('required');
		}
    }
</script>

 													<h4 id="mnlogin" style="color:#3ACC53">Manual Login</h4>


													<!-- //////////// -->


													<div class="control-group" id="m_first_named">

														<label class="control-label" for="radiobtns">First Name</label>



														<div class="controls">

															<div class="">

															<?php

																/*$r = $db->getManualReg('first_name', $mno_id, $user_distributor);*/
																$r = $manual_login_fields['first_name'];

																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role="fnamefield" data-role1="first_name" name="m_first_name" id="m_first_name" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#fnamefield").css('display', 'inline-block');

																						});
																		</script>

																		<div id="fnamefield" >


															<input type="text" id="first_name" name="first_name" class="span5" value="<?php echo $first_name_text; ?>">
														</div>

																	<?php

																} else {

																	echo '<input onclick="manual_toggle(this)" name="m_first_name" data-role="fnamefield" data-role1="first_name" id="m_first_name" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																			<script type="text/javascript">

																		$(document).ready(function() {

																			$("#fnamefield").hide();

																		});
																	</script>

																	<div id="fnamefield" >


															<input type="text" id="first_name" name="first_name" class="span5" value="<?php echo $first_name_text; ?>">
														</div>

																<?php
																}

															?>

															<?php if(($manual_fields[0]['first_name'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_first_named").hide();
																			$("#fnamefield").hide();

																		});
																	</script>

															<?php } ?>

<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_first_name',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#fnamefield").css('display', 'inline-block');
															                }else{

															                	$("#fnamefield").hide();}
															        }
															    });
															</script>

<?php }?>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->




													<div class="control-group" id="m_last_named">

														<label class="control-label" for="radiobtns">Last Name</label>



														<div class="controls">

															<div class="">

															<?php

																//$r = $db->getManualReg('last_name', $mno_id, $user_distributor);
                                                                $r = $manual_login_fields['last_name'];

																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role="lnamefield" name="m_last_name" data-role1="last_name" id="m_last_name" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																	<script type="text/javascript">

																	$(document).ready(function() {

																	  $("#lnamefield").css('display', 'inline-block');

																		});
																		</script>

																		<div id="lnamefield">

																			<input type="text" id="last_name" name="last_name" class="span5" value="<?php echo $last_name_text; ?>">

																		</div>

																	<?php


																} else {

																	echo '<input onclick="manual_toggle(this)" data-role="lnamefield" name="m_last_name" data-role1="last_name" id="m_last_name" type="checkbox" >';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																	$(document).ready(function() {

																	$("#lnamefield").hide();

																	});
																	</script>

																	<div id="lnamefield">

																			<input type="text" id="last_name" name="last_name" class="span5" value="<?php echo $last_name_text; ?>">

																		</div>

																	<?php


																}

															?>

															<?php if(($manual_fields[0]['last_name'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_last_named").hide();
																			$("#lnamefield").hide();

																		});
																	</script>

															<?php } ?>

<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_last_name',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#lnamefield").css('display', 'inline-block');
															                }else{

															                	$("#lnamefield").hide();}
															        }
															    });
															</script>

<?php } ?>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->

													<div class="control-group" id="m_emaild">

														<label class="control-label" for="radiobtns">Email</label>



														<div class="controls">

															<div class="">

															<?php

																//$r = $db->getManualReg('email', $mno_id, $user_distributor);
                                                            $r = $manual_login_fields['email'];

																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role="emailfield" data-role1="email" name="m_email" id="m_email" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#emailfield").css('display', 'inline-block');

																						});
																		</script>

																		<div id="emailfield">
																			<input class="span5" id="email" name="email" type="text" value="<?php echo $email_field; ?>" required>
																		</div>
																	<?php
																} else {

																	echo '<input onclick="manual_toggle(this)" data-role1="email" data-role="emailfield" name="m_email" id="m_email" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#emailfield").hide();

																						});
																		</script>

																		<div id="emailfield">
																			<input class="span5" id="email" name="email" type="text" value="<?php echo $email_field; ?>" required>
																		</div>
																	<?php
																}

															?>

															<?php if(($manual_fields[0]['email'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_emaild").hide();
																			$("#emailfield").hide();

																		});
																	</script>

															<?php } ?>

<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_email',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#emailfield").css('display', 'inline-block');
															                }else{

															                	$("#emailfield").hide();}
															        }
															    });
															</script>
<?php } ?>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



													<!-- /control-group -->

													<div class="control-group" id="m_mobiled">

														<label class="control-label" for="radiobtns">Mobile Number</label>



														<div class="controls">

															<div class="">

															<?php

																//$r = $db->getManualReg('mobile_number', $mno_id, $user_distributor);
                                                            $r = $manual_login_fields['mobile_number'];
																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role="mobilefield" data-role1="mobile_number" name="m_mobile" id="m_mobile" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#mobilefield").css('display', 'inline-block');

																						});
																		</script>
																		<div id="mobilefield">
															<input class="span5" id="mobile_number" name="mobile_number" type="text" value="<?php echo $edit_mobile_number_fields; ?>">
													</div>
																	<?php
																} else {

																	echo '<input onclick="manual_toggle(this)" data-role1="mobile_number" data-role="mobilefield" name="m_mobile" id="m_mobile" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#mobilefield").hide();

																						});
																		</script>
																		<div id="mobilefield">
															<input class="span5" id="mobile_number" name="mobile_number" type="text" value="<?php echo $edit_mobile_number_fields; ?>">
													</div>
																	<?php
																}

															?>

															<?php if(($manual_fields[0]['mobile_number'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_mobiled").hide();
																			$("#mobilefield").hide();

																		});
																	</script>

															<?php } ?>

<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_mobile',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#mobilefield").css('display', 'inline-block');
															                }else{

															                	$("#mobilefield").hide();}
															        }
															    });
															</script>
<?php } ?>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->





<style type="text/css">


	@media (min-width: 980px){
input.span2a {
    width: 114px;
}
}

	@media (min-width: 1200px){
input.span2a {
    width: 144px;
}
}

	@media (max-width: 980px){
input.span2a {
    width: 280px;
}

#male, #female{

    margin-top: 20px;
    margin-left: 45px;
}

#m_male, #m_female{
	display: block !important;
}

}

@media (max-width: 980px){
input.span2a {
    width: 158px;
}
}

@media (max-width: 420px){

#male, #female{
    width: 77% !important;
}

#m_male, #m_female{
	display: inline-block !important;
}
}

</style>
													<div class="control-group" id="m_genderd">

														<label class="control-label" for="radiobtns">Gender</label>



														<div class="controls">

															<div class="">

															<?php

																//$r = $db->getManualReg('gender', $mno_id, $user_distributor);
                                                            $r = $manual_login_fields['gender'];
																if ($r == 1) {

																	echo '<input onclick="manual_toggle_gender(this)" name="m_gender" id="m_gender" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_male").css('display', 'inline-block');
																			$("#m_female").css('display', 'inline-block');
																			$("#genderfld").css('display', 'inline-block');

																						});
																		</script>

																		<div id="genderfld">
															<input class="span2a" id="gender" name="gender" type="text" value="<?php echo $gender_field; ?>" required>

													</div>
													<div id="m_male">
														<input class="span2a" id="male" name="male" type="text" value="<?php echo $male_field; ?>" required>
													</div>
													<div id="m_female">
															<input class="span2a" id="female" name="female" type="text" value="<?php echo $female_field; ?>" required>
													</div>


																	<?php
																} else {

																	echo '<input onclick="manual_toggle_gender(this)" name="m_gender" id="m_gender" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";


																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_male").hide();
																			$("#m_female").hide();
																			$("#genderfld").hide();

																						});
																		</script>

																		<div id="genderfld">
															<input class="span2a" id="gender" name="gender" type="text" value="<?php echo $gender_field; ?>" required>

													</div>
													<div id="m_male">
														<input class="span2a" id="male" name="male" type="text" value="<?php echo $male_field; ?>" required>
													</div>
													<div id="m_female">
															<input class="span2a" id="female" name="female" type="text" value="<?php echo $female_field; ?>" required>
													</div>
																	<?php
																}

															?>

															<?php if(($manual_fields[0]['gender'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#m_male").hide();
																			$("#m_female").hide();
																			$("#genderfld").hide();
																			$("#m_genderd").hide();

																		});
																	</script>

															<?php } ?>
<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_gender',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#m_male").css('display', 'inline-block');
																			$("#m_female").css('display', 'inline-block');
																			$("#genderfld").css('display', 'inline-block');
															                }else{

															                	$("#m_male").hide();
																				$("#m_female").hide();
																				$("#genderfld").hide();}
															        }
															    });
															</script>
<?php } ?>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->

													<div class="control-group" id="m_age_groupd">

														<label class="control-label" for="radiobtns">Age Group</label>



														<div class="controls">

															<div class="">

															<?php

																//$r = $db->getManualReg('age_group', $mno_id, $user_distributor);
                                                            $r = $manual_login_fields['age_group'];
																if ($r == 1) {

																	echo '<input onclick="manual_toggle(this)" data-role1="age_group" data-role="agegrp" name="m_age_group" id="m_age_group" type="checkbox" checked>';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#agegrp").css('display', 'inline-block');

																						});
																		</script>

																		<div id="agegrp">

															<input class="span5" id="age_group" name="age_group" type="text" value="<?php echo $age_group_field; ?>" required>

													</div>

																	<?php
																} else {

																	echo '<input onclick="manual_toggle(this)" data-role1="age_group" data-role="agegrp" name="m_age_group" id="m_age_group" type="checkbox">';

																	echo "<label style='display: inline-block; margin-top: 10px;''></label>";

																	?>
																	<script type="text/javascript">

																		$(document).ready(function() {

    																			$("#agegrp").hide();

																						});
																		</script>

																		<div id="agegrp">

															<input class="span5" id="age_group" name="age_group" type="text" value="<?php echo $age_group_field; ?>" required>

													</div>
																	<?php
																}

															?>

															<?php if(($manual_fields[0]['age_group'] != '1')){ ?>

															<script type="text/javascript">

																		$(document).ready(function() {

																			$("#agegrp").hide();
																			$("#m_age_groupd").hide();

																		});
																	</script>

															<?php } ?>
<?php if($system_package=='N/A'){?>
															<script type="text/javascript">
															    new DG.OnOffSwitch({
															        el: '#m_age_group',
															        textOn: 'On',
															        textOff: 'Off',
															        listener:function(name, checked){
															            if(checked==true){
															            	$("#agegrp").css('display', 'inline-block');
															                }else{

															                	$("#agegrp").hide();}
															        }
															    });
															</script>
<?php }?>
															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->


													<!-- /////////////// -->





<?php if(!in_array("manual_text", $hide_divs_gene_arr)){ ?>
											<div id="cmnlogintxt" class="control-group">

														<label class="control-label" for="radiobtns">Manual Login Text</label>



														<div class="controls">

														<div><sub>Default Manual Registration text using recommended Font Size 10, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

																<textarea width="500px" id="create_account" name="create_account" class="jqte-test textarea-tiny"><?php echo $manual_login_txt; ?></textarea>

															</div>

														</div>

														<!-- /controls -->

													</div>
                                                    <?php } ?>

													<!-- /control-group -->






</div>

<div id="field_color" class="control-group feild">

														<div class="controls">

															<h3 style="display: inline-block;">Field Color<img data-toggle="tooltip" title="You can set the color of the fields depending on the background used." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display: inline-block;"></h3>

															<div style="margin-left: 5px;">
																<input name="feild_color" class="black" id="feild_color_black" value="rgba(0, 0, 0, 0.75)" type="checkbox">
																<label style='display: inline-block; margin-top: 10px;''></label>
																<input name="feild_color" class="gray" id="feild_color_gray" value="rgba(140, 134, 134, 0.75)" type="checkbox">
																<label style='display: inline-block; margin-top: 10px;''></label>
																<input name="feild_color" class="white" id="feild_color_white" value="rgba(255, 255, 255, 0.75)" type="checkbox">
																<label style='display: inline-block; margin-top: 10px;''></label>
															</div>

														</div>
	
													</div>

													<div id="field_txt_color" class="control-group feild">

														<div class="controls">

															<h3 style="display: inline-block;">Field Text Color<img data-toggle="tooltip" title="You can set the color of the field text based on the field color used." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display: inline-block;"></h3>

															<div style="margin-left: 5px;">
																<input name="field_txt_color" class="black" id="field_txt_color_black" type="checkbox" value="black">
																<label style='display: inline-block; margin-top: 10px;''></label>
																<input name="field_txt_color" class="gray" id="field_txt_color_gray" type="checkbox" value="gray">
																<label style='display: inline-block; margin-top: 10px;''></label>
																<input name="field_txt_color" class="white" id="field_txt_color_white" type="checkbox" value="white">
																<label style='display: inline-block; margin-top: 10px;''></label>
															</div>

														</div>
	
													</div>

													<div id="field_preview" class="control-group">

														<div class="controls">

															<h3 style="display: inline-block;">Field Preview</h3>

															<div>

																<div class="login__row">
          															Age Range
          														</div>
																
															</div>

														</div>
	
													</div>

													<?php 


													if(strlen($edit_bg_color2) < 1){
														$edit_bg_color2 = 'rgba(0, 0, 0, 0.75)';
														$edit_fontcolor2 = 'white';
													}

													 ?>

													<script type="text/javascript">

														$(document).ready(function() {
															$('.login__row').css('background', "<?php echo $edit_bg_color2; ?>");
															$('input[name="field_txt_color"][value="<?php echo $edit_fontcolor2; ?>"]').prop('checked', true); 
															$('input[name="feild_color"][value="<?php echo $edit_bg_color2; ?>"]').prop('checked', true); 
															$('.login__row').css('color', "<?php echo $edit_fontcolor2; ?>");

															$('input[name="field_txt_color"]').prop('disabled', false);

														    $('input[name="field_txt_color"][class="'+$('input[name="feild_color"][value="<?php echo $edit_bg_color2; ?>"]').attr('class')+'"]').prop('disabled', true);

														     $('input[name="feild_color"]').prop('disabled', false);

														    $('input[name="feild_color"][class="'+$('input[name="field_txt_color"][value="<?php echo $edit_fontcolor2; ?>"]').attr('class')+'"]').prop('disabled', true);

														});

														/*function setFeild(val,val2,val3){

															$('input[name="'+val+'"]').not(this).prop('checked', false); 

														    $('input[name="'+val2+'"]').prop('disabled', false);

														     $('input[name="'+val+'"]').prop('disabled', false);
														    $(this).prop('disabled', true);

														    $('input[name="'+val2+'"][value="'+$(this).val()+'"]').prop('disabled', true);

														    $('.login__row').css(val3, $(this).val()); 

														}*/

														$('input[name="feild_color"]').on('change', function() {

														    $('input[name="feild_color"]').not(this).prop('checked', false); 

														    /*$('input[name="field_txt_color"]').prop('disabled', false);

														     $('input[name="feild_color"]').prop('disabled', false);
														    $(this).prop('disabled', true);

														    $('input[name="field_txt_color"][value="'+$(this).val()+'"]').prop('disabled', true);*/

														    $('.login__row').css('background', $(this).val()); 

														    $('input[name="field_txt_color"]').prop('disabled', false);

														    $('input[name="field_txt_color"][class="'+$(this).attr('class')+'"]').prop('disabled', true);

														});

														$('input[name="field_txt_color"]').on('change', function() {


														   $('input[name="field_txt_color"]').not(this).prop('checked', false);
														    $('.login__row').css('color', $(this).val()); 

														    $('input[name="feild_color"]').prop('disabled', false);

														    $('input[name="feild_color"][class="'+$(this).attr('class')+'"]').prop('disabled', true);

														    /*$('input[name="field_txt_color"]').prop('disabled', false);
														    $(this).prop('disabled', true);

														    $('input[name="feild_color"]').prop('disabled', false);

														    $('input[name="feild_color"][value="'+$(this).val()+'"]').prop('disabled', true);*/

														});

													</script>

													<style type="text/css">
														.login__row{
															    height: 48px;
															    background: rgb(0, 0, 0);
															    opacity: 0.7;
															    margin-bottom: 10px;
															    padding: 15px;
															    color: white;
															    box-sizing: border-box;
															    width: 300px;
														}

														.feild input[type="checkbox"]:checked + label::before{
															    box-sizing: border-box;
															    border: 3px solid #00cac8 !important;
														}

														.feild input[type="checkbox"] + label::before{
																width: 29px;
    															height: 29px;
														}

														.feild input[type="checkbox"].black + label::before{
																background: black;
														}

														.feild input[type="checkbox"].gray + label::before{
																background: gray;
														}

														.feild input[type="checkbox"].white + label::before{
																background: white;
																border: 1px solid black;
																box-sizing: border-box;
														}
													</style>

<div id="manualbutton">


												<div id="mregbtn" class="control-group">

														<label class="control-label" for="radiobtns">Button Text</label>



														<div class="controls">

														

															<div class="input-prepend input-append">

															<input type="text" maxlength="15" id="sign_up" name="sign_up" value="<?php echo $registration_btn ?>" onkeyup="valid_check(this.value,'buttontext_validate')">

															<small id="buttontext_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>

																<p id="sign_up_note">Up to 15 characters including space</p>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



</div>






<div id="voucher">


													<hr>

													 <h4 id="vlogin" style="color:#3ACC53">Voucher login</h4>





                                                    <div id="usernf" class="control-group">

                                                        <label class="control-label" for="radiobtns">User Name field</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">



                                                                <input class="span5" id="login_name" name="login_name" type="text" value="<?php echo $login_name_field1; ?>" required>



                                                            </div>

                                                        </div>

                                                        <!-- /controls -->

                                                    </div>

                                                    <!-- /control-group -->





                                                    <div id="userpw" class="control-group">

                                                        <label class="control-label" for="radiobtns">Passcode field</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">



                                                                <input class="span5" id="login_secret" name="login_secret" type="text" value="<?php echo $login_secret_field1; ?>" required>



                                                            </div>

                                                        </div>

                                                        <!-- /controls -->

                                                    </div>

                                                    <!-- /control-group -->








</div>

<?php if(!in_array("welcomepage", $hide_divs_gene_arr)){ ?>
<div id="welcomepage" class="control-group">

<div id="step5">

													<hr>

													<div class="controls">
                                                    <p class="">After a guest has registered the first time they are redirected to a Welcome Screen with a Button to connect to the Internet. When a guests returns after their sessions has expired, they get redirected back to the captive portal, and the Welcome Back screen. </p>
													</div>

</div>


<label class="control-label" for="radiobtns" id="banner-label">Banner Text</label>
													<div id="wtxt" class="controls">



<?php if(!in_array("welcome_text", $hide_divs_gene_arr)){ ?>
														<div id="txt_hide">
														

															<div class="input-prepend input-append">
															<p id="banner-def-txt" style="margin-right: 10px; display: inline-block">Courtesy Service Provided by</p>
															<input type="text" id="welcome" onkeyup="valid_check(this.value,'welcome_validate')" maxlength="30" name="welcome" class="span4 banner_txt_val" placeholder="Enter customer name text" required onkeyup="valid_check(this.value,'theme_name1_validate')" value="<?php echo $welcome_txt; ?>" autocomplete="off">
															<small id="welcome_validate" data-bv-validator="notEmpty" data-bv-validator-for="password" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none; margin-left: 40px;"><p>This is a required field</p></small>
															<div>
																<p id="banner-under-txt"><b>You can add in your business name to the end of the banner text. It can have up to 30 characters with spaces.</b></p></div>
															</div>
															<div>
														</div>
														

														</div>
                                                        <?php } ?>
<div id="wback">
															<div><sub>Default Welcome Back text using recommended Font Size 14, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

															<textarea width="500px" id="welcome_back" name="welcome_back" class="jqte-test textarea-tiny"><?php echo $welcome_back_txt; ?></textarea>

															</div>


															<div><sub>Default Button text using recommended Font Size 8, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">

															<textarea width="500px" id="connectwifi" name="connectwifi" class="jqte-test textarea-tiny"><?php echo $connect_btn; ?></textarea>

															</div>
                                                        </div>







													</div>

													<!-- /control-group -->







</div>
<?php } ?>

<br>

<div id="greeting_txt_div" class="control-group">

                                                        <label class="control-label" for="radiobtns">Greeting Text</label>



                                                        <div class="controls">

                                                            <div class="input-prepend input-append">



                                                                <textarea maxlength="90" id="greeting_txt" name="greeting_txt" class="span4" style="padding: 10px;border: 1px solid #979798;padding-left: 20px !important;padding-right: 20px !important;height: 72px;"><?php echo $greeting_txt; ?></textarea>

																<div>
														<p><b id="greeting_txt_txt">You can add your customized message to the beginning of the greeting text, it can have up to 90 characters with spaces.</b> </p></div>



                                                            </div>

                                                        </div>

                                                        <!-- /controls -->

                                                    </div>

													<!-- /control-group -->
													
<div id="footera">



													<hr>





													 <h4 id="footertxt" style="color:#3ACC53">Footer</h4>





													<div id="termsnc" class="control-group">

														<label class="control-label" for="radiobtns">Terms and Conditions text</label>



														<div class="controls">

														<div><sub>Default Terms & Condition text using recommended Font Size 8, Font Family "Ariel", Font Color "White"</sub></div>

															<div class="input-prepend input-append">



															<textarea width="500px" id="toc" name="toc" class="jqte-test textarea-tiny"><?php echo $toc_txt; ?></textarea>





															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->




















<?php if(!in_array("welcomepage", $hide_divs_gene_arr)){ ?>

													<div id="acptcbox" class="control-group">

														<label class="control-label" for="radiobtns">Accept Check Box Text</label>



														<div class="controls">

															<div class="input-prepend input-append">



															<textarea width="500px" id="acpt_text" name="acpt_text" class="jqte-test textarea-tiny"> <?php echo $acpt_text_field; ?> </textarea>



															</div>

														</div>

														<!-- /controls -->

													</div>
                                                    <?php } ?>

													<!-- /control-group -->











</div>









													<div id="isactive" class="control-group">

														<label class="control-label" for="radiobtns">Active</label>



														<div class="controls">

															<div class="">



															<input id="is_active" name="is_active" type="checkbox" <?php if ($is_active1 == 1) { ?> checked <?php } ?>

															data-toggle="tooltip" title="CHECKING THE BOX will activate this theme and make it visible to all your guests immediately. Or you can leave the box unchecked and enable the theme later from within the Manage section."

															>
                                                                <label for="is_active"></label>


															</div>
															<p><b>Note: Check this box to make this the active theme.</b></p>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->







													<div class="form-actions">

				                                        <?php if($modify_mode == 1) {?>

															<button type="submit" name="theme_update" id="theme_update"

																class="btn btn-primary" disabled>Update </button>&nbsp; <button type="button" name="campign_update_cancel" id="campign_update_cancel" class="btn btn-warning"  >Cancel</button>



				                                        <?php }else { ?>

				                                             <button type="submit" name="theme_submit" id="theme_submit" class="btn btn-primary">Save</button>

				                                        <?php } ?>



													</div>

												<!-- /form-actions -->

												</fieldset>


										<script type="text/javascript">


										function ck_topval(set_val){

											

											var tname=document.getElementById('theme_name1').value;
											var locid=document.getElementById('location_ssid').value;
											var redirect_type=document.getElementById('redirect_type').value;
											var welcome=document.getElementById('welcome').value;
											var sign_up=document.getElementById('sign_up').value;

										    if(welcome != ''){

												var patt = /[-!@<*>$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/;
										    	var welcome = patt.test(welcome);

											}
											else{
												welcome = true;
											}

											if(sign_up != ''){

												var patt = /[-!@<*>$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/;
												var sign_up = patt.test(sign_up);

											}
											else{
												sign_up = true;
											}

											
											if(!$('#welcome').is(":visible")){
												welcome = 'set';
												$('#welcome').removeAttr( "required" );

											} 

											var vertical_validate = $("#slideshow img").hasClass("croppedImg");

											if($('#varimg:visible').length == 0){

												vertical_validate = true;

											}

											var horizontal_validate = $("#slideshow1 img").hasClass("croppedImg");

											if($('#horimg:visible').length == 0){
												horizontal_validate = true;
											}


											if($('input[name=verticle_img]:not(#vari):checked').length){
												vertical_validate = true;

											}

											if($('input[name=horizontal_img]:not(#hori):checked').length){
												horizontal_validate = true;

											}

											if(horizontal_validate){
												$( '#horimg_validate' ).hide();
											}

											if(vertical_validate){
												$( '#varimg_validate' ).hide();
											}

											if($('#logo1_up_bc').length){

												var logo1_up_validate = $("#logo1_up_bc img").hasClass("croppedImg");

												if($('#divlogo1:visible').length == 0){

													logo1_up_validate = true;

													var logo_1_text_val=document.getElementById('logo_1_text').value;

													if(logo_1_text_val == ''){
														logo1_up_validate = false;
													}

												}
											}
											else{
												/* var logo1_up_validate = $("#logo1_up_bc img").hasClass("croppedImg");

												if($('#divlogo1:visible').length == 0){

													logo1_up_validate = true;

													var logo_1_text_val=document.getElementById('logo_1_text').value;

													if(logo_1_text_val == ''){
														logo1_up_validate = false;
													}

												} */
												var logo1_up_validate = true;
											}

											

											

											var logo2_up_validate = $("#logo2_up img").hasClass("croppedImg");

											if($('#divlogo2:visible').length == 0){

												logo2_up_validate = true;

												var logo_2_text_val=document.getElementById('logo_2_text').value;

												if(logo_2_text_val == ''){
													logo2_up_validate = false;
												}

											}

											if(($('#alttxt2:visible').length == 0) && ($('#logoimg:visible').length == 0)){

													logo2_up_validate = true;

											}

											if(logo1_up_validate){
												$( '#logo1_up_validate' ).hide();
											}

											if(logo2_up_validate){
												$( '#logo2_up_validate' ).hide();
											}

											

										if(tname=='' || !horizontal_validate || !vertical_validate || !logo2_up_validate || !logo1_up_validate || locid=='' || redirect_type == '' ||  welcome || sign_up){

											try {
												document.getElementById("theme_submit").disabled = true;
											}

											catch(err) {
												document.getElementById("theme_update").disabled = true;

												if($('#check_update').val()=='0'){
													$('#check_update').val('1')
												}
											}

											}else{

											try {
												document.getElementById("theme_submit").disabled = false;

											}

											catch(err) {

												
												document.getElementById("theme_update").disabled = false;
												
												
											}

											}


											}

                                            $(document).ready(function() {

                                                	ck_topval();

													$('#edit-profile1').on('change keyup click paste',function(e){

														ck_topval();

													});

													$('input[name=verticle_img]').on('change', function(event) {
														ck_topval();
													});

													
													$(document).ajaxStop(function(){

														ck_topval();

													});

                                                });

                                                </script>

											</form>

										</div>


											<!-- ******************* Preview ********************* -->

										<div class="tab-pane <?php if($active_tab == 'preview') echo 'active'; ?>" id="preview">


											

                                            <?php

                                            if(isset($_SESSION['msg_up'])){

                                                echo $_SESSION['msg_up'];

                                                unset($_SESSION['msg_up']);





                                            }?>



											<div class="widget widget-table action-table">







												<form id="tag_form" class="form-horizontal">

													<fieldset>



														<div class="control-group">

															<label class="control-label" for="radiobtns">Theme</label>



															<div class="controls">

																<div class="input-prepend input-append">

																	<select name="theme_id" class="span3" id="theme_id" onchange="loadap1();">

																	<option value="-1">Select Theme</option>

																	<?php

																	$key_query = "SELECT theme_id,theme_name FROM exp_themes WHERE distributor = '$user_distributor'";



																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$theme_id = $row[theme_id];

																		$theme_name = $row[theme_name];



																		echo '<option value="'.$theme_id.'">'.$theme_name.'</option>';

																	}

																	?>

																	</select>

																	<div id="error_msg" style="display: none;" class="error-wrapper bubble-pointer mbubble-pointer"><p>Please select a theme.</p></div>

																</div>

															</div>

															<!-- /controls -->

														</div>

														<!-- /control-group -->





														<div class="control-group" id="type_div">

															<label class="control-label" for="radiobtns">Type</label>



															<div class="controls">

																<div class="input-prepend input-append">

																	<select name="theme_type" class="span3" id="theme_type" required>

																	<option value="new">New User</option>

																	<option value="return">Return User</option>



																	</select>

																</div>

															</div>

															<!-- /controls -->

														</div>

														<!-- /control-group -->




														<?php if(getSectionType("THEME_PRIVIEW_SSID",$system_package,$user_type)=="multy" || $package_features=="all"){ ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">SSID / AP</label>
															<div class="controls">
																<div class="input-prepend input-append" id="aps_list">
																	<select name="theme_ssid" id="theme_ssid" required>
																	<option value="-1">Select SSID and AP</option>
																	<?php

																	 $key_query = "SELECT concat(location_ssid,'|',ap_id) as id, CONCAT(location_ssid,' - ',ap_id) AS detail
																	FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor'";

																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$id = $row[id];

																		$detail = $row[detail];

																		echo '<option value="'.$id.'">'.$detail.'</option>';
																	}
																	?>
																	</select>
																</div>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<?php } ?>


														<?php if(getSectionType("THEME_PRIVIEW_SSID",$system_package,$user_type)=="single"){ ?>

																<div class="input-prepend input-append" id="aps_list">
																	<input type="hidden"  name="theme_ssid" id="theme_ssid" required  value="<?php

																	 $key_query = "SELECT concat(location_ssid,'|',ap_id) as id, CONCAT(location_ssid,' - ',ap_id) AS detail
																	FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor' LIMIT 1";

																	$query_results=mysql_query($key_query);

																	while($row=mysql_fetch_array($query_results)){

																		$id = $row[id];

																		$detail = $row[detail];

																		echo $id;
																	}
																	?>" >
																</div>
															<!-- /controls -->

														<!-- /control-group -->
														<?php } ?>










														<div class="form-actions" >

															<button disabled="disabled" id="preview_btn" type="button" name="submit" onclick="preview();"

																class="btn btn-primary inline-btn" data-toggle="tooltip" title="The PREVIEW button will allow you to visualize the mobile view of the captive portal.">
																Preview
																</button>



															<button disabled="disabled" type="button" name="submit" id="gen_url" onclick="url_creation();"

																class="btn btn-danger inline-btn" data-toggle="tooltip" title="The GENERATE URL button creates a URL that can be shared electronically and will allow the recipient to test the captive portal layout natively on any device or browser.">
																Generate URL</button>


 <script>

			$(document).ready(function() {
					function checkthemeselect(){
							var a =$('#theme_id').val();
							if(a==-1){

									$('#preview_btn').prop('disabled', true);
									$('#gen_url').prop('disabled', true);
							}else{

									$('#preview_btn').prop('disabled', false);
									$('#gen_url').prop('disabled', false);
							}
						}

						checkthemeselect();

				   $( "#theme_id" ).on('change',function() {
										  checkthemeselect();
										});
			});

	</script>



							 <div id="new_div" class="inline-btn" style=""></div>
								<img  id="tag_loader" src="img/loading_ajax.gif" style="visibility: hidden;">
								</div>
							</fieldset>

						</form>



<?php




///////////////////////


$aaa_preview_version = $pack_func->getOptions('AAA_PREVIEW_VERSION',$system_package);

if($aaa_preview_version == 'ALE_V5'){
	$redirection_from = 'ALE_V5';
	$reditection = 'CAPTIVE_ALE5_REDIRECTION';
}
else{
	$redirection_from = 'ALE_V4';
	$reditection = 'CAPTIVE_ALE4_REDIRECTION';
}

$admin_product = $pack_func->getAdminPackage();
$redirection_parameters = $pack_func->getOptions($reditection,$admin_product);
/*
$network_name = trim($db->setVal('network_name','ADMIN'),"/");
$get_parametrs=mysql_query("SELECT p.`redirect_method`,p.`mac_parameter`,p.`ap_parameter`,p.`ssid_parameter`,p.`loc_string_parameter`,p.`network_ses_parameter` ,p.`ip_parameter`
FROM `exp_network_profile` p WHERE p.`network_profile`='$network_name' LIMIT 1");

$row3=mysql_fetch_array($get_parametrs);
*/

if(strlen($redirection_parameters)=='0'){
	$redirection_parameters = '{"mac_parameter":"client_mac","ap_parameter":"ap","ssid_parameter":"ssid","ip_parameter":"IP","loc_string_parameter":"0","network_ses_parameter":"0","group_parameter":"realm","other_parameters":"0"}';
}
$red_decode = (array)json_decode($redirection_parameters);


$network_ses_parameter = $red_decode['network_ses_parameter'];
$ip_parameter = $red_decode['ip_parameter'];
$mac_parameter = $red_decode['mac_parameter'];
$loc_string_parameter = $red_decode['loc_string_parameter'];
$group_parameter = $red_decode['group_parameter'];
$ap_parameter=$red_decode['ap_parameter'];
$ssid_parameter=$red_decode['ssid_parameter'];

function siteURL()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'].'/';
	return $protocol;
}
define( 'SITE_URL', siteURL() );

$SSL_ON=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='SSL_ON' LIMIT 1");

if($SSL_ON!='1'){
	$pageURL = "http://";
}else{
	$pageURL = "https://";
}


if ($_SERVER["SERVER_PORT"] != "80"){
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
}
else{
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

	$base_folder_path_preview = $db->setVal('portal_base_folder', 'ADMIN');

?>



<script type="text/javascript">

function url_creation(){
var theme_id=document.getElementById("theme_id").value;
var theme_type=document.getElementById("theme_type").value;
var theme_ssid=document.getElementById("theme_ssid").value;
var ap_ssid = theme_ssid.split('|');

var mac = "DEMO_MAC";
var ascii = "WLAN:wlandemo:30:"+ap_ssid[0]+":zf7762:"+ap_ssid[1]+":DEMO_MAC";
var network_key = "ggFFcsdyy734vFDcfd.81";
var hex_option_82 = toHex(ascii);
var group = "<?php echo $db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1"); ?>";
var ipp = "10.1.1.45";

var mac_parameter="<?php echo $mac_parameter; ?>";
var ap_parameter="<?php echo $ap_parameter; ?>";
var ssid_parameter="<?php echo $ssid_parameter; ?>";
var loc_string_parameter="<?php echo $loc_string_parameter; ?>";
var network_ses_parameter="<?php echo $network_ses_parameter; ?>";
var ip_parameter="<?php echo $ip_parameter; ?>";
var group_parameter="<?php echo $group_parameter; ?>";

loc = mac_parameter+"="+mac;

if(ap_parameter.length>1)
loc = loc+"&"+ap_parameter+"="+ap_ssid[1];
if(ssid_parameter.length>1)
loc = loc+"&"+ssid_parameter+"="+ap_ssid[0];
if(ip_parameter.length>1)
loc = loc+"&"+ip_parameter+"="+ipp;
if(network_ses_parameter.length>1)
loc = loc+"&"+network_ses_parameter+"="+network_key;
if(group_parameter.length>1)
loc = loc+"&"+group_parameter+"="+group;
<?php
if($aaa_preview_version == 'ALE_V5'){
	echo 'loc = loc+"&tenant=test";';
}
?>
var url_base = '<?php echo $pageURL; ?>';
var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

if(theme_type=='new'){
	loc = myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;
}
else if(theme_type=='return'){
	loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;
}



if(theme_id != -1){

	document.getElementById('preview_url').innerHTML = 'You can copy and paste the below URL in an email, messenger etc., to allow anyone anywhere to test the end-to-end experience on a device of their choice. <br><textarea id="genUrlTextArea" rows="3" style="margin: 0px 0px 9px; width: 95%; height: 79px;">'+loc+'</textarea><br><br>';
	document.getElementById('new_div').innerHTML = '<a href="'+loc+'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="The OPEN URL IN A NEW TAB button will allow you to launch the captive portal natively on the device and browser you are currently using.">Open URL in new tab</a>';
	var copyText = document.getElementById("genUrlTextArea");
	copyText.select();
	document.execCommand("Copy");

	$("#error_msg").hide();
	eval(document.getElementById('tootip_script').innerHTML);

}

else{
	/*document.getElementById('new_div').innerHTML = '<font size="small" color="brown"> Please select a theme.</font>';*/
	document.getElementById("error_msg").style = "display: inline-block";
}
}



function preview(){

var theme_id=document.getElementById("theme_id").value;
var theme_type=document.getElementById("theme_type").value;
var theme_ssid=document.getElementById("theme_ssid").value;
var ap_ssid = theme_ssid.split('|');
try {
	$('iframe').contents().find('#loading_img').show();
	} catch (error) {
}

var theme_id=document.getElementById("theme_id").value;
var theme_type=document.getElementById("theme_type").value;
var theme_ssid=document.getElementById("theme_ssid").value;
var ap_ssid = theme_ssid.split('|');

var mac = "DEMO_MAC";
var ascii = "WLAN:wlandemo:30:"+ap_ssid[0]+":zf7762:"+ap_ssid[1]+":DEMO_MAC";
var network_key = "ggFFcsdyy734vFDcfd.81";
var hex_option_82 = toHex(ascii);
var group = "<?php echo $db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1"); ?>";
var ipp = "10.1.1.45";

var mac_parameter="<?php echo $mac_parameter; ?>";
var ap_parameter="<?php echo $ap_parameter; ?>";
var ssid_parameter="<?php echo $ssid_parameter; ?>";
var loc_string_parameter="<?php echo $loc_string_parameter; ?>";
var network_ses_parameter="<?php echo $network_ses_parameter; ?>";
var ip_parameter="<?php echo $ip_parameter; ?>";
var group_parameter="<?php echo $group_parameter; ?>";

loc = mac_parameter+"="+mac;

if(ap_parameter.length>1)
loc = loc+"&"+ap_parameter+"="+ap_ssid[1];
if(ssid_parameter.length>1)
loc = loc+"&"+ssid_parameter+"="+ap_ssid[0];
if(ip_parameter.length>1)
loc = loc+"&"+ip_parameter+"="+ipp;
if(network_ses_parameter.length>1)
loc = loc+"&"+network_ses_parameter+"="+network_key;
if(group_parameter.length>1)
loc = loc+"&"+group_parameter+"="+group;
<?php
if($aaa_preview_version == 'ALE_V5'){
	echo 'loc = loc+"&tenant=test";';
}
?>
var url_base = '<?php echo $pageURL; ?>';
var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

if(theme_type=='new'){
	loc = myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;
}
else if(theme_type=='return'){
	loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;
}



if(theme_id != -1){

	document.getElementById('preview1').src = loc;
	document.getElementById('preview2').src = loc;
	document.getElementById('preview3').src = loc;
	try {
		document.getElementById('preview4').src = loc;
	}
	catch(err) {
		//document.getElementById("demo").innerHTML = err.message;
	}

	document.getElementById('new_div').innerHTML = '<a href="'+loc+'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="The OPEN URL IN A NEW TAB button will allow you to launch the captive portal natively on the device and browser you are currently using.">Open URL in new tab</a>';

	$("#error_msg").hide();
	eval(document.getElementById('tootip_script').innerHTML);
}

else{
	document.getElementById("error_msg").style = "display: inline-block";
}
}







function toHex(str) {
	var hex = '';
	for(var i=0;i<str.length;i++) {
		hex += ''+str.charCodeAt(i).toString(16);
	}
	return hex;
}

</script>







												<div id="preview_url"></div>



												<center>

													<div id="devices">




                                                    <div style="overflow-x: auto" class="table_response">
														<div class="device-node" align="center" style="margin-left:320px;">

												        <h4>Phone - 240 x 320</h4>

												        <div style="width:240px; height:320px; overflow:hidden"><iframe name="preview1" id="preview1" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="240" height="320"></iframe></div>

												        </div>
                                                    </div>




                                                    <div style="overflow-x: auto" class="table_response">
												        <div class="device-node" style="margin-left:280px;">

												        <h4>iPhone - 320 x 480</h4>

												        <div style="width:320px; height:480px; overflow:hidden"><iframe scrolling="yes" name="preview2" id="preview2" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="320" height="480"></iframe></div>

												        </div>
                                                    </div>






                                                    <div style="overflow-x: auto" class="table_response">
												        <div class="device-node" style="margin-left:200px;">

												        <h4>Tablet - 480 x 640</h4>

												        <div  style="width:480px; height:640px;overflow:hidden"><iframe scrolling="yes" name="preview3" id="preview3" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="480" height="640"></iframe></div>

												        </div>
                                                    </div>




<!-- <center>

												        <div class="device-node" style="margin-left:80px;">

												        <h4>iPad - 768 x 1024</h4>

												        <div style="width:768px; height:1024px; overflow:hidden"><iframe name="preview4" id="preview4" src="ajax/waiting.php" width="768" height="1024"></iframe></div>

												        </div>

												        </center> -->




											    	</div>

												</center>

												<script>


												</script>



												<!-- /widget-content -->

											</div>

											<!-- /widget -->



										</div>


<?php } ?>




			<!-- ******************* active_theme ********************* -->

										<div class="tab-pane <?php if($active_tab == 'active_theme') echo 'active'; ?>" id="active_theme">

											<?php

										   

									      		if(isset($_SESSION['msg1'])){

										   		echo $_SESSION['msg1'];

										   		unset($_SESSION['msg1']);


										   	
	  									    }
	  									    ?>


                                                  <h1 class="head" style="display: none;">
    First impressions last,
make yours a splash page. <img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable webpage upon connection to your Guest Wi-Fi network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>



<?php

$language_enable= getSectionType('LANGUAGE_ENABLE',$system_package,'MVNO');

?>


											<div class="widget widget-table action-table" >



												<div class="widget-header">

													<!-- <i class="icon-th-list"></i> -->

													<h3>Active Themes<img  id="campcreate_loader_1" src="img/loading_ajax.gif" style="visibility: hidden;"></h3>

												</div>

												<!-- /widget-header -->

												<div class="widget-content table_response" id="campcreate_div1">
                                                    <div style="overflow-x:auto">

													<table id="active_theme_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

														<thead>

															<tr>


																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Theme Name</th>

<?php if($package_functions->getSectionType('LANGUAGE_ENABLE',$system_package)=='1'){ ?>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Language(s)</th>
<?php }?>
															<!---	<th>Update date</th> -->

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Status</th>
<!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Update</th>  -->

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Customer Account #</th>


																<!-- <th style="min-width: 290px;"></th> -->


															</tr>

														</thead>

														<tbody>



															<?php



																$key_query = "SELECT id,ref_id,theme_id, theme_name, `LANGUAGE`, registration_type,create_date,is_enable,language_string FROM exp_themes

																WHERE distributor = '$user_distributor' AND theme_type = 'MASTER_THEME' ORDER BY ref_id,ABS(is_enable-1) ASC";



																$query_results=mysql_query($key_query);



																while($row=mysql_fetch_array($query_results)){

																	$auto_id = $row['id'];

																	$location_ssid = $row['ref_id'];

																	$theme_id = $row['theme_id'];

																	$theme_name = $row['theme_name'];

																	$LANGUAGE = $row['LANGUAGE'];

																	$create_date = $row['create_date'];

																	$is_enable=$row['is_enable'];

																	$language_string=$row['language_string'];



																	echo '<tr>





																	<td> '.$theme_name.' </td>';

										if($package_functions->getSectionType('LANGUAGE_ENABLE',$system_package)=='1'){

																	echo '<td> ';

															//$theme_name =addslashes($theme_name);

                                                                    $list_lan_q = "SELECT `language`, `is_enable` FROM exp_themes WHERE ref_id = '$theme_id'";

                                                                    $list_lan_r = mysql_query($list_lan_q);

                                                                    $list_count = mysql_num_rows($list_lan_r);



                                                                        if($list_count > 0){



                                                                            $str = "<ul>";

                                                                            $str .= "<li> English </li>";



                                                                            while($rrrr=mysql_fetch_array($list_lan_r)){

                                                                                $rr_language = $rrrr[language];

                                                                                $rr_is_enable = $rrrr[is_enable];



                                                                                $query_lan = "SELECT language FROM system_languages WHERE language_code = '$rr_language'";

                                                                                $result_lan = mysql_query($query_lan);

                                                                                $r = mysql_fetch_array($result_lan);

                                                                                $lan = $r[language];



                                                                                if($rr_is_enable == 1){

                                                                                	//$chek='checked';

                                                                                    $str .= "<li>".$lan." - <font color=green><strong>ENABLED</strong></font></li>";

                                                                                }else{

                                                                                	//$chek='';

                                                                                    $str .= "<li>".$lan." - <font color=red><strong>DISABLED</strong></font></li>";

                                                                                }

                                                                        //  echo   '<a id="EN_DIS_'.$auto_id.'"><input '.$chek.' onchange="changePasscodeM()" id="EN_DIS1_'.$auto_id.'" type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-width="60"></a>';



                                                                            }

                                                                            echo '<a id="'.str_replace(" ","",$auto_id).'">View </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';

                                                                            echo '<script>

                                                                                $(document).ready(function() {



                                                                                    $(\'#'.str_replace(" ","",$auto_id).'\').tooltipster({

                                                                                        content: $("'.$str.'"),

                                                                                        theme: \'tooltipster-shadow\',

                                                                                        animation: \'grow\',

                                                                                        onlyOne: true,

                                                                                        trigger: \'click\'



                                                                                    });





                                                                                });

                                                                            </script>';

                                                                        }else{

                                                                            echo 'English &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';

                                                                        }

                                                                    echo '<a href="?add_new_lan=new&token='.$secret.'&id='.$theme_id.'"><i class="icon-plus"></i></a></td>

																	 ';
														}


                                                                    if($is_enable==1){

																		//echo '<td><font color=green><strong>ENABLED</strong></font></td>';

																		echo   '<td><div class="toggle1"><input checked onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox"><span class="toggle1-on">ON</span>
																		<a id="ST_'.$auto_id.'" href="javascript:void();" ><span class="toggle1-off-dis">OFF</span></a>
																		</div>';

																	echo '';

																	echo '

																	<script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#ST_'.$auto_id.'\').easyconfirm({locale: {

																			title: \'Disable Theme\',

																			text: \'Are you sure you want to disable this theme?&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#ST_'.$auto_id.'\').click(function() {



																		window.location = "?token='.$secret.'&modify=2&is_enable=0&id='.$auto_id.'&ssid='.$location_ssid.'&theme_name='.addslashes($theme_name).'"

																		});

																		});

																	</script>';


                                                                }
                                                                else{

                                                                   // echo '<td><font color=red><strong>DISABLED</strong></font></td>';

                                                                    echo   '<td><div class="toggle1"><input onchange="" type="checkbox" class="hide_checkbox">
                                                                    <a href="javascript:void();" id="CE_'.$auto_id.'"><span class="toggle1-on-dis">ON</span></a>
                                                                    <span class="toggle1-off">OFF</span>
                                                                    </div>';

                                                                    echo '';

                                                                echo '

                                                                <script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#CE_'.$auto_id.'\').easyconfirm({locale: {

																			title: \'Activate Theme\',

																			text: \'Are you sure you want to activate this theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#CE_'.$auto_id.'\').click(function() {

																			window.location = "?token='.$secret.'&modify=2&is_enable=1&id='.$auto_id.'&theme_name='.addslashes($theme_name).'"

																		});

																		});

																	</script>';

                                                                    echo '<script type="text/javascript">

                                                                $(document).ready(function() {

                                                                    $(\'#RE_'.$theme_id.'\').easyconfirm({locale: {

                                                                            title: \'Remove Theme\',

                                                                            text: \'Are you sure you want to remove this theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#RE_'.$theme_id.'\').click(function() {

                                                                            window.location = "?token='.$secret.'&remove=1&id='.$theme_id.'&theme_name='.urlencode(addslashes($theme_name)).'&lan='.$LANGUAGE.'"

                                                                        });

                                                                        });

                                                                    </script>';



																		}




																		echo '</td><td>';


                                                                    echo '<a id="CM_'.$theme_id.'"  class="btn btn-small btn-primary"><i class="btn-icon-only icon-wrench"></i>Edit&nbsp;</a><script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#CM_'.$theme_id.'\').easyconfirm({locale: {

																			title: \'Manage Theme ['.str_replace("'"," ",$theme_name).']\',

																			text: \'Are you sure you want to modify this theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#CM_'.$theme_id.'\').click(function() {

																			window.location = "?token='.$secret.'&modify=1&id='.$theme_id.'&lan='.$LANGUAGE.'"

																		});

																		});

																	</script>';

                                                                    echo '</td><td>';

                                                                        echo '<a id="RE_'.$theme_id.'"  class="btn btn-small btn-danger"><i class="btn-icon-only icon-trash"></i>Remove&nbsp;</a>
                                                                ';/*JavaScript part move in to is_enable if condition else part*/


															if(in_array("THEME_IMPORT",$features_array) || $package_features=="all"){   echo '<a id="DOWN_'.$theme_id.'"  class="btn btn-small btn-warning"><i class="btn-icon-only icon-download-alt"></i>Export</a><script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#DOWN_'.$theme_id.'\').easyconfirm({locale: {

																			title: \'Export Theme\',

																			text: \'Are you sure,you want to export this theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#DOWN_'.$theme_id.'\').click(function() {

																			window.location = "ajax/download_theme.php?&theme_id='.$theme_id.'"

																		});

																		});

																	</script></td>';}



																										echo '<td> '.$location_ssid.' </td>
																										</tr>';

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







											<!-- ******************* upload_images ********************* -->

                              			<div style="display: none !important"> <?php if(isset($tab19)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="upload_images">





											<?php

												if($user_type == 'MNO'){

													$url = '?type=mno_logo&id='.$user_distributor;

												?>

												<h3>MNO Logo </h3>

												<p>Max Size (160 x 30)</p>



												<div style="width:600px">

												<form id="imageform" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>

												Upload your image <input type="file" name="photoimg" id="photoimg" />

												</form>



												<?php

												$key_query = "SELECT logo FROM exp_mno WHERE mno_id = '$user_distributor'";



												$query_results=mysql_query($key_query);

												while($row=mysql_fetch_array($query_results)){

													$logo = $row[logo];

												}

												?>





												<div id='img_preview'>

												<?php if(strlen($logo)){?>

												<img  width="160px;" src="<?php echo $base_url;?>/assets/img/logo/mno/<?php echo $logo; ?>" border="0" />

												<?php }

												else{

													echo 'No Images';

											}?>

												</div>

												</div>

											<?php

												}











												else if($user_type == 'MVNE' || $user_type == 'MVNO'){

													$url1 = '?type=mvne_bg&id='.$user_distributor;

													$url2 = '?type=mvne_logo&id='.$user_distributor;





													$key_query = "SELECT bg_image,logo_image,parent_code FROM exp_mno_distributor WHERE distributor_code = '$user_distributor'";



													$query_results=mysql_query($key_query);

													while($row=mysql_fetch_array($query_results)){

														$bg_image = $row[bg_image];

														$logo_image = $row[logo_image];

														$parent_code = $row[parent_code];

													}







													// Check Parent type

													if(strlen($parent_code)){

														$parent_query = "SELECT distributor_type FROM exp_mno_distributor d WHERE distributor_code = '$parent_code'";



														$query_results=mysql_query($parent_query);

														while($row=mysql_fetch_array($query_results)){

															$parent_type = $row[distributor_type];

														}

													}



												//	if($parent_type != 'MVNE'){

													?>

													<h3>Default Background </h3>

													<p>Max Size (1600 x 1000)</p>









													<div style="width:600px">

													<form id="imageform1" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url1; ?>'>

													Upload your image <input type="file" name="photoimg1" id="photoimg1" />

													</form>

													<div id='img_preview1'>

													<?php if(strlen($logo_image)){?>

													<img  width="600px;" src="<?php echo $base_url;?>/assets/img/backgrounds/<?php echo $bg_image; ?>" border="0" />

													<?php }

													else{

														echo 'No Images';

													}

													?>

													</div>

													</div>







													<br /><br />

													<?php// }

													?>



													<h3>Default Logo </h3>

													<p>Max Size (900 x 100)</p>



													<div style="width:600px">

													<form id="imageform3" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url2; ?>'>

													Upload your image <input type="file" name="photoimg3" id="photoimg3" />

													</form>

													<div id='img_preview3'>

													<?php if(strlen($logo_image)){?>

													<img  src="<?php echo $base_url;?>/assets/img/logo/<?php echo $logo_image; ?>" border="0" />

													<?php }

													else{

														echo 'No Images';

													}

													?>

													</div>

													</div>









												<?php

												}















												// This Part is not functioning -- START

												else if($user_type == 'MVNO'){

													$url = '?type=mvno_logo&id='.$user_distributor;

												?>

													<h3>MVNO - Logo </h3>

													<p>Max Size (900 x 40)</p>



													<?php

													$key_query = "SELECT logo_image FROM exp_mno_distributor WHERE distributor_code = '$user_distributor'";



													$query_results=mysql_query($key_query);

													while($row=mysql_fetch_array($query_results)){

														$logo_image = $row[logo_image];

													}

													?>



													<div style="width:600px">

													<form id="imageform4" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>

													Upload your image <input type="file" name="photoimg4" id="photoimg4" />

													</form>

													<div id='img_preview4'>

													<?php if(strlen($logo_image)){?>

													<img  src="<?php echo $base_url;?>/assets/img/logo/<?php echo $logo_image; ?>" border="0" />

													<?php }

													else{

														echo 'No Images';

													}

													?>



													</div>

													</div>





												<?php

												}

												// This Part is not functioning -- END



												?>

										</div>


<!-- //////////////////// -->

											<!-- ******************* image up hor and ver ********************* -->

										<div style="display: none !important"> class="tab-pane <?php if($active_tab == 'image_up') echo 'active'; ?>" id="image_up">



			                              	<?php

									      		if(isset($_SESSION['msgup'])){

										   		echo $_SESSION['msgup'];

										   		unset($_SESSION['msgup']);

	  									    }?>


											<div class="header2_part1"><h2>Upload Theme Images</h2></div>

											<form method="post" class="form-horizontal">

											<fieldset><br>


<?php
$sys_pack1 = $system_package;
//$sys_pack=$db->getValueAsf("SELECT `system_package` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

$gt_template_optioncode1= getOptions('TEMPLATE_ACTIVE',$sys_pack1,'MVNO');

$pieces11 = explode(",", $gt_template_optioncode1);

$len11 = count($pieces11);

$outstr11="";

for($i=0;$i<$len11;$i++){

	if($i==($len1-1)){

		$outstr11=$outstr11."'".$pieces11[$i]."'";

	}else{

		$outstr11=$outstr11."'".$pieces11[$i]."',";
	}


}




if ($sys_pack!='N/A') {

$key_query_t_name1 = "SELECT template_id, `name`  FROM exp_template WHERE `is_enable` ='1'

							AND template_id IN ($outstr11)";

}else{

$key_query_t_name1 = "SELECT template_id, `name`  FROM exp_template WHERE `is_enable` ='1'";


}

$gt_template_optiontype= getOptions('TEMPLATE_IMAGE_TYPE',$sys_pack1,'MVNO');

//$objtype = json_decode($gt_template_optiontype, true);

//print_r($objtype['res_cox_block_template']['vert']);


?>


<script type="text/javascript">


function typedrop(val2) {

	//alert(val2);

	var val2;

	var obj = JSON.parse('{"res_cox_block_template":[{"vert":0,"hori":0}],"res_cox_modern_template":[{"vert":0,"hori":2}],"res_cox_standard_template":[{"vert":0,"hori":0}],"res_cox_modern_hori_template":[{"vert":0,"hori":0}],"default_theme":[{"vert":0,"hori":0}]}');

	// alert(obj.this[val2][0].vert);

}



</script>



													<div class="control-group">

														<label class="control-label" for="radiobtns">Template name</label>

														<div class="controls">

															<div class="input-prepend input-append">




															<select onchange="typedrop(this.value)" class="span5" id="template_name1" name="template_name1" required="required">

															<option value="">--SELECT TEMPLATE--</option>
															<?php

																		$query_results1=mysql_query($key_query_t_name);

																		while($row=mysql_fetch_array($query_results1)){

																			$temp_id = $row[template_id];

																			$temp_name = $row[name];

																			echo '<option id="'.$temp_name.'" value="'.$temp_id.'">'.$temp_name.'</option>';


																		}?>



															</select>

															</div>

														</div>

														<!-- /controls -->

													</div>




													<div class="control-group">

														<label class="control-label" for="radiobtns">Image Type</label>

														<div class="controls">

															<div class="input-prepend input-append">




															<select onchange="" class="span5" id="image_type" name="image_type" required="required">

															<option value="">--SELECT IMAGE TYPE--</option>
															<option value="Horizontal_img">Horizontal</option>
															<option value="verticle_img">Vertical</option>




															</select>

															</div>

														</div>

														<!-- /controls -->

													</div>




												    <div id="verim" class="control-group">

															<label class="control-label" id="up_logo_name2" for="radiobtns">Upload Image</label>



															<div class="controls">

												           <div id="logo_img_up" class="input-prepend input-append" style="vertical-align:top;">

												                <label class="filebutton" id="brw_bt2">

												                <font size="1">
												                Browse Image
																</font>

												                <span><input class="span4" id="image3" name="image3" type="file" style="width:90px;" onchange="return ajaxFileUpload(3);" required></span>

												                </label>&nbsp;&nbsp;<img  id="loading_3" src="img/loading_ajax.gif" style="display:none;">
																<lable id="up_logo_desc3"> </lable>
															</div>

															<div class="input-prepend input-append" id="img_div3">

															</div>
															</div>






													<div class="form-actions">

				                                             <button type="submit" name="up_theme_img" id="up_theme_img" class="btn btn-primary">Upload</button>


													</div>



											</fieldset>

											</form>


											<!-- /widget -->

										</div>

										





<!-- //////////////////////////// -->

								</div>

							</div>

							</div>

						</div>

							<!-- /widget-content -->

					</div>

						<!-- /widget -->

				</div>

					<!-- / -->

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





<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/colorpicker.js"></script>
<!-- <script type="text/javascript" src="js/gradX.js?v=6"></script>
<link rel="stylesheet" type="text/css" href="css/gradX.css?v=6" /> -->
<link rel="stylesheet" type="text/css" href="css/colorpicker.css" />
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>



<!-- tool tip css -->

<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />

<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />





<script type="text/javascript" src="js/jquery.form.js"></script>

   <?php if($modify_mode == 1) {?>

   <script>

  /*  gradX("#gradX", {
        direction: "top",
        name: "duotone_bg",
        sliders: [
		   {
		     color: "<?php //echo $duotone_bg_rgba1; ?>",
		     position: <?php //echo $duotone_bg_pos1; ?>
		   },
		   {
		     color: "<?php //echo $duotone_bg_rgba2; ?>",
		     position: <?php //echo $duotone_bg_pos2; ?>
		   }
		]
    });*/



	</script>

   <?php }else{ ?>

   <script>

  /*  gradX("#gradX", {
        direction: "top",
        name: "duotone_bg",
        sliders: [
		   {
		     color: "rgb(211, 89, 54)",
		     position: 7
		   },
		   {
		     color: "rgb(61, 0, 0)",
		     position: 86
		   }
		]
    });*/



</script>

   <?php } ?>







<?php

	$textArea = 2;

	if ($textArea == 1) {

		?>



		<link type="text/css" rel="stylesheet" href="css/jquery-te-1.4.0.css">

		<script type="text/javascript" src="js/jquery-te-1.4.0.min.js" charset="utf-8"></script>



		<?php

	} else {

		?>



		<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>

		<script type="text/javascript">

	    tinymce.init({

	        selector: ".textarea-tiny",
	        theme: "modern",

	        menubar:false,
	        statusbar: false,


	        plugins: [


				"autoresize",
	            "contextmenu directionality paste textcolor"

	        ],

	        autoresize_max_height: 40,


	        toolbar: "fontselect | fontsizeselect | forecolor  ",

	        fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

	        font_formats: "Andale Mono=andale mono,times;"+

	        "Arial=arial,helvetica,sans-serif;"+

	        "Arial Black=arial black,avant garde;"+

	        "Book Antiqua=book antiqua,palatino;"+

	        "Comic Sans MS=comic sans ms,sans-serif;"+

	        "Courier New=courier new,courier;"+

	        "Georgia=georgia,palatino;"+

	        "Helvetica=helvetica;"+

	        "Impact=impact,chicago;"+

	        "Symbol=symbol;"+

	        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

	        "Terminal=terminal,monaco;"+

	        "Times New Roman=times new roman,times;"+

	        "Trebuchet MS=trebuchet ms,geneva;"+

	        "Verdana=verdana,geneva;"+

	        "Webdings=webdings;"+

	        "Wingdings=wingdings,zapf dingbats"

		});
		
		tinymce.init({
			
						selector: ".greeting_txt",
						theme: "modern",
			
						menubar:false,
						statusbar: false,
			
			
						plugins: [
			
			
							"autoresize",
							"contextmenu directionality paste textcolor"
			
						],
			
						autoresize_max_height: 80,
			
			
						toolbar: "fontselect | fontsizeselect | forecolor | alignleft aligncenter alignright alignjustify | code ",
			
						fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",
			
						font_formats: "Andale Mono=andale mono,times;"+
			
						"Arial=arial,helvetica,sans-serif;"+
			
						"Arial Black=arial black,avant garde;"+
			
						"Book Antiqua=book antiqua,palatino;"+
			
						"Comic Sans MS=comic sans ms,sans-serif;"+
			
						"Courier New=courier new,courier;"+
			
						"Georgia=georgia,palatino;"+
			
						"Helvetica=helvetica;"+
			
						"Impact=impact,chicago;"+
			
						"Symbol=symbol;"+
			
						"Tahoma=tahoma,arial,helvetica,sans-serif;"+
			
						"Terminal=terminal,monaco;"+
			
						"Times New Roman=times new roman,times;"+
			
						"Trebuchet MS=trebuchet ms,geneva;"+
			
						"Verdana=verdana,geneva;"+
			
						"Webdings=webdings;"+
			
						"Wingdings=wingdings,zapf dingbats"
			
					});
		
		

</script>



		<?php

	}



?>

























<!-- Ajax Image Upload-->

	<script type="text/javascript" src="js/ajaxfileupload.js"></script>

	<script type="text/javascript">

	function ajaxFileUpload(id)

	{

		$("#loading_"+id)

		.ajaxStart(function(){

			$(this).show();

		})

		.ajaxComplete(function(){

			$(this).hide();

		});



		$.ajaxFileUpload

		(

			{

				//url:'ajax/ajaximageupload.php?getid='+id,
                url:'ajax/ajaximageupload.php?getid='+id+'&template='+$("#template_name").val(),

				type: "GET",

				secureuri:false,

				fileElementId:'image'+id,

				dataType: 'json',

				data:{name:'logan', id:'id'},

				success: function (data, status)

				{

					if(typeof(data.error) != 'undefined')

					{

						if(data.error != '')

						{

							//alert(data.error);

							$("#img_div"+id).html(data.error);

						}else

						{

							//alert(data.msg);

							$("#img_div"+id).html(data.msg);
                            var template_name = document.getElementById("template_name").value ;
                            if(template_name=="default_theme"){
                                document.getElementById("check_back").value = "1";
                                document.getElementById("check_color").value = "0";
                            }

                            // var a1 = document.getElementById("backimg").style.display;
                            // var a2 = document.getElementById("logoimg").style.display;

                            // if(a1=="none" || a2=="none"){
                            //     $("#theme_submit").prop('disabled', false);
                            // }
                            // else{


                            //     if(id=="1"){

                            //         if(document.getElementById("image2").value != "") {
                            //         $("#theme_submit").prop('disabled', false);
                            //     }
                            // }
                            //     else{

                            //         if(document.getElementById("image1").value != "") {
                            //         $("#theme_submit").prop('disabled', false);
                            //     }
                            //     }


                            // }


						}

					}

				},

				error: function (data, status, e)

				{

					alert(e);

				}

			}

		)



		return false;



	}

	</script>













 <script type="text/javascript">













function default_image_set(id)

{





	var img_browse_btn = "image"+id;

	var img_div = "img_div"+id;

	var check_box="check_box"+id;

	var hidden_id="default_img"+id;

	var default_bg_image = "<?php echo $bg_image; ?>";

	var default_logo_image = "<?php echo $logo_image; ?>";



	if(id==1){

			var default_image_name=default_bg_image;



			}else{

				var default_image_name=default_logo_image;



				}





		if (document.getElementById(check_box).checked == true)

		{



			//document.getElementById(img_div).innerHTML='';

			document.getElementById(img_browse_btn).disabled=true;

			document.getElementById(hidden_id).value=default_image_name;





		} else{



			//document.getElementById(img_div).innerHTML='';

			document.getElementById(img_browse_btn).disabled=false;

			document.getElementById(hidden_id).value='';



			}







}





</script>








<?php if(getSectionType("THEME_PRIVIEW_SSID",$system_package,$user_type)=="multy" || $package_features=="all"){ ?>
<script type="text/javascript">
var xmlHttp3;
function loadap1()
{
	xmlHttp3=GetXmlHttpObject();
	if (xmlHttp3==null)
	 {
		 alert ("Browser does not support HTTP Request");
		 return;
	 }
	var theme_id=document.getElementById("theme_id").value;
	var url="ajax/loadAPS.php";
	url=url+"?theme_id="+theme_id+"&distributor=<?php echo $user_distributor; ?>";
	xmlHttp3.onreadystatechange=stateChanged;
	xmlHttp3.open("GET",url,true);
	xmlHttp3.send(null);
	function stateChanged()
	{
		if (xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
		{
		document.getElementById("aps_list").innerHTML=xmlHttp3.responseText;

		if($("#theme_id").val()!= '-1'){
			url_creation();
			preview();
		}
		
		
		}
	}
}

</script>
<?php }else{ ?>

<script type="text/javascript">
var xmlHttp3;
function loadap1()
{
	url_creation();
		preview();
		

	}

</script>

<?php } ?>






<script type="text/javascript">









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

<script src="js/jscolor.js"></script>


<script type="text/javascript" src="js/bootstrapValidator.js"></script>


<script type="text/javascript">

/* $(document).ready(function() {

	$(function() {

	setTimeout(function(){

	    $('#edit-profile1').bootstrapValidator({
	        framework: 'bootstrap',
	        excluded: ':disabled',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	            verticle_img: {
	                validators: {
	                    <?php //echo 'Select Image'; ?>
	                }
	            }
	        }
	    });


		}, 3000);



	});

});
 */

</script>

<script id="tootip_script">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});


/* $('a[data-toggle="tab"]').on('click', function (e) {
	var click_id = e.target.id;
}); */

<?php if($modify_mode == 1) {  ?>

$(document).ready(function() {

$("a[data-toggle='tab']:not(#tab-create_theme)").easyconfirm({locale: {
    title: 'Theme Update Cancel',
    text: 'Are you sure you want to cancel this theme update?',
    button: ['No',' Yes'],
    closeText: 'close'

}});

$("a[data-toggle='tab']:not(#tab-create_theme)").click(function(e) {
	var click_id = e.target.id;
	var click_id_arr = click_id.split("-");
	window.location = "?active_tab="+click_id_arr[1];
});

});

<?php } ?>

$('#imgupload').click(function (e) { 

																	
																	valid_check($('#theme_name1').val(),'theme_name1_validate');
																	valid_check($('#location_ssid').val(),'location_ssid_validate');
																	valid_check($('#title_t').val(),'title_t_validate');
																	valid_check($('#redirect_type').val(),'redirect_type_validate');
																
																
																	
																});

</script>
<script src="js/bootstrap-colorpicker.js?v=6"></script>


<script>
	$(document).ready(function () {
		$('#back_color_div').colorpicker({
			color: '<?php echo $bg_dft_img1; ?>',
			useAlpha: false,
			align : 'left'
        });$('#button_color_div').colorpicker({
			color: '<?php echo $btn_color; ?>',
			useAlpha: false,
			align : 'left'
        });
		$('#btn_color_disable_div').colorpicker({
			color: '<?php echo $btn_color_disable; ?>',
			useAlpha: false,
			align : 'left'
        });
		$('#button_ho_color_div').colorpicker({
			color: '<?php echo $btn_border; ?>',
			useAlpha: false,
			align : 'left'
        });
		$('#button_text_color_div').colorpicker({
			color: '<?php echo $btn_text_color; ?>',
			useAlpha: false,
			align : 'right'
        });
		$('#bcolor1_div').colorpicker({
			color: '<?php echo $edit_bg_color1; ?>',
			useAlpha: false,
			align : 'left'
        });
		$('#fontcolor1_div').colorpicker({
			color: '<?php echo $edit_fontcolor1; ?>',
			useAlpha: false,
			align : 'left'
        });
		$('#hrcolor_div').colorpicker({
			color: '<?php echo $edit_hr_color; ?>',
			useAlpha: false,
			align : 'left'
        });
	});
</script>

	<script type="text/javascript">

$(".banner_txt_val").keypress(function(event){

	var ew = event.which;
	//alert(ew);
	
	if(ew == 32 || ew == 8 ||ew == 0)
		return true;
	if(48 <= ew && ew <= 57)
		return true;
	if(65 <= ew && ew <= 90)
		return true;
	if(97 <= ew && ew <= 122)
		return true;
	return false;
});

$('.banner_txt_val').bind("cut copy paste",function(e) {
		  e.preventDefault();
	   });

</script>

<?php if($modify_mode == 1) {	
									
									?>
									<script> //alert("1");
										setTimeout(function(){  //alert();
											document.getElementById("theme_update").disabled = true;
										 }, 5000);
										
										</script>
								<?php }?>
</body>


</html>

