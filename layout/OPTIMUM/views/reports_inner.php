      <h1 class="head"><span>
    Reports <img data-toggle="tooltip" title="The report contains information collected from the guests interaction with the campaign. The amount of data collected depends both on the type of campaign and the type of captive portal you have active." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></span>
</h1>

<style type="text/css">
    /*home styles*/



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
    padding-left: 42% !important;
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
     border-right: none !important;
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
}

.tab-pane:nth-child(1){
  padding-top: 0px;
}

.tab-pane:last-child{
  border-bottom: none;
}

.alert {
  position: absolute;
    top: 60px;
    width: 100%;
} 

.nav-tabs>li:nth-child(3)>a{
    border-right: none !important;
  }

</style>

<script type="text/javascript">
  $(document).ready( function(){

    $('.tab-pane').addClass('in').addClass('active');
    $('.nav-tabs li').removeClass('active');
    $('[data-toggle="tab"]').attr('data-toggle', 'tab1');

  

    $('[data-toggle="tab1"]').each(function(index, el) {

      var tabDiv = $(this).attr('href').replace('#', '');
      $( this ).attr('href', '#');
      $( this ).attr('data-div', tabDiv);
    });

    $('[data-toggle="tab1"]').click(function(event) {

    var tabDiv = $(this).attr('data-div');

    $('html, body').animate({
        scrollTop: $("#" + tabDiv).offset().top
    }, 2000);

  });
  });

  /*$('[data-toggle="tab1"]').click(function(event) {
    var tabDiv = $(this).attr('href').replace('#', '');

    $('html, body').animate({
        scrollTop: $("#" + tabDiv).offset().top
    }, 10000);

  });*/
</script>