
<?php ob_start();?>
<!DOCTYPE html>

<html lang="en">

<?php

session_start();

include 'header_top.php';

//require_once('db/config.php');

/* No cache*/
//header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';


/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();

?>
<head>

    <meta charset="utf-8">
    <meta Http-Equiv="Cache-Control" Content="no-cache"/>
    <meta Http-Equiv="Pragma" Content="no-cache"/>
    <meta Http-Equiv="Expires" Content="0"/>
    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>  

<?php
include 'header.php';

?>
<script>

    $(window).resize(function(event) {
        manual_slider();
    });


$(document).ready(function(){

        manual_slider();


	var x = '130px';
    $(".inner_intro").click(function(){

    	if($(this).css( "height") == '130px'){ 
    		x = '100%'; 
    		$(this).addClass('down');
            $('.inner-hide', this).show();
    	}else{ 
    		x = '130px'; 
    		$(this).removeClass('down');
            $('.inner-hide', this).hide();
    	} 

        $(this).animate({height: x},'fast');
    });


    $('.mobile-menu li').click(function() {
      var index = $(this).index();

      $('.mobile-menu li').removeClass('clicked')
      $(this).addClass('clicked');

      index = index +1;

      $('.parent_intro li:not(.mobile-menu li):not(.li)').hide();

      $('.parent_intro li:nth-child('+ index +')').show();
  });


});




</script>

    <?php 
  

  include_once 'layout/'.$camp_layout.'/views/intro_inner.php';

        //echo $system_package;
     ?>
	


<?php include 'footer.php'; ?>

