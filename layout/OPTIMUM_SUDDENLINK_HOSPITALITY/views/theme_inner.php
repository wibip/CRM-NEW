<!--       <h1 class="head">
    First impressions last,
make yours a splash page. <img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable webpage upon connection to your Guest Wi-Fi network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1> -->

<style type="text/css">
	  /*home styles*/

    hr {
    border-top: 1px solid #ffffff !important;
    border-bottom: 1px solid #9b9b9b !important;
}

  h1.head{
    display: block !important;
    /*margin-bottom: 20px;*/
  }

h3 {
    color: #00c5aa;
    margin-bottom: 15px;
    margin-top: 15px;
    text-transform: capitalize;
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

  .nav-tabs>li:last-child>a{
  	border-right: none !important;
  }

  body {
    background: #ffffff !important;
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
	/*padding-top: 50px;*/
   /* border-bottom: 1px solid #000000;*/
}

.tab-pane:nth-child(1){
	padding-top: 0px;
}

.tab-pane:last-child{
	border-bottom: none;
}

.alert {
 /*  position: absolute;
   top: 60px; */
    width: 100%;
    box-sizing: border-box;
} 

@media (max-width: 768px){
  #preview_btn, #devices{
    display: none !important;

  }
}

</style>

<script type="text/javascript">
	/* $(document).ready( function(){


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
     

        $('#'+tabDiv).addClass('in');
      $('#'+tabDiv).addClass('active');

      $('html, body').animate({
                scrollTop: $(".main-inner").offset().top - 100
            }, 200 , function() {
   
  });


      

	});
	}); */
</script>