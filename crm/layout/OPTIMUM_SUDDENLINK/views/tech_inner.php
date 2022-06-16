  <!--     <h1 class="head">
    It is your business, so let the SSID show it. <img data-toggle="tooltip" title="Tooltip test" src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1> -->

<style type="text/css">
	  /*home styles*/

    .form-horizontal .controls {
    margin-left: 190px !important;
    widows: auto !important;
}

#search_circuit_main{
  margin-bottom: 50px;
}

@media (max-width: 480px){
  .form-horizontal .controls {
    margin-left: 0px !important;
  }

  .ctr_main:nth-child(1){
        margin-right: 0px;
        margin-bottom: 20px;
  }

  h2{
    margin-bottom: 20px;
  }
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
    border-right: 1px solid white !important;
  }
  .nav-tabs>li>a{
        padding-top: 3px !important;
    padding-bottom: 3px !important;
    color: #fff !important;
    border-radius: 0px 0px 0 0 !important;
  }

  .nav-tabs>li:nth-child(1)>a{
  	border-right: none !important;
  }

  body {
    background: #ffffff !important;
}

h1.head {
    padding: 50px;
    padding-bottom: 50px;
    width: 960px;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #000;
    font-family: Rbold;
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
/*	padding-top: 50px;*/
    /*border-bottom: 1px solid #000000;*/
}

.tab-pane:nth-child(1){
	padding-top: 0px;
}

.tab-pane:last-child{
	border-bottom: none;
}

.alert:not(#conf_complete_alert):not(#add_ap_complete_alert):not(.tech_config_alert) {
  position: absolute;
    top: 52px;
    width: 100%;
} 

h1.head {
    padding-top: 55px !important;
}

</style>

<script type="text/javascript">
$(document).ready( function(){

 /* $('#create_theme').addClass('in').addClass('active');
  */

    $('.nav-tabs li').removeClass('active');
    $('[data-toggle="tab"]').attr('data-toggle', 'tab1');

  

    $('[data-toggle="tab1"]').each(function(index, el) {

      var tabDiv = $(this).attr('href').replace('#', '');
      $( this ).attr('href', 'javascript:void(0)');
      $( this ).attr('data-div', tabDiv);
    });

    $('[data-toggle="tab1"]').click(function(event) {


      var tabDiv = $(this).attr('data-div');

      $('.tab-pane').removeClass('active');;
     

      /*var elmnt = document.getElementsByClassName('main-inner')[0];
      elmnt.scrollIntoView();*/

        $('#'+tabDiv).addClass('in');
      $('#'+tabDiv).addClass('active');

      $('html, body').animate({
                scrollTop: $(".main-inner").offset().top - 100
            }, 200 , function() {
   
  });


      

  });
  });

	/*$('[data-toggle="tab1"]').click(function(event) {
		var tabDiv = $(this).attr('href').replace('#', '');

		$('html, body').animate({
        scrollTop: $("#" + tabDiv).offset().top
    }, 10000);

	});*/
</script>

 <script type="text/javascript">
  $(document).scroll(function() {

    try{


    if($(window).width() > 980){

           if($(window).scrollTop() > ($('.main').position().top - 200)){
              $('.main').css('margin-top','40px');
              $('.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not(ul[id^="myTabDASHBOX"]):not(ul[id^="SSID_myTabDASHBOX"])').addClass('fixed-nav');
              $('.alert').css('top', '0px');
           }else{
                $('.main').css('margin-top','0px');
                $('.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not(ul[id^="myTabDASHBOX"])').removeClass('fixed-nav');
              $('.alert').css('top', '52px');
           }

       }

       }catch(err){

       }


       });
 </script>