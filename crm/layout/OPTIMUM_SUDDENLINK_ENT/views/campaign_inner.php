      <br><h1 class="head container">
    Engage your visitors, let them know &nbsp;<span> who you are.<img data-toggle="tooltip" title='You can create campaigns to communicate with all or a subset of all your visitors. They will see the campaign once they have registered via your splash page theme. Once a campaign is created you can edit, start/stop or delete that campaign. ' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>

<style type="text/css">
	  /*home styles*/

 hr {
    border-top: 1px solid #ffffff !important;
    border-bottom: 1px solid #9b9b9b !important;
}

h3 {
    color: #00c5aa;
    margin-bottom: 15px;
    margin-top: 15px;
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
    padding-left: 40% !important;
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

  .nav-tabs>li:nth-child(2)>a{
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
	padding-top: 50px;
 /*   border-bottom: 1px solid #000000;*/
}

.tab-pane:nth-child(1){
	padding-top: 0px;
}

.tab-pane:last-child{
	border-bottom: none;
}

h1.head span{
      display: inline-block;
}

@media (max-width: 480px){
  h1.head span{
      display: block;
}


}


.mobi_child{
      width: 120px;
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

        $('[data-toggle="tab1"]').removeClass('clicked');
        $(this).addClass('clicked');
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