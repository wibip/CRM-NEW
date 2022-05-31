
 

<style type="text/css">


  /*overview css*/
  label.total_clients_label {
    display: inline-block;
    min-width: 50px;
    height: 30px;
    text-align: center;
    margin-left: -20%;
    border: 1px solid #d2d2d2;
    margin-top: 10px;
    padding: 6px;
}
#total_clients_action{
  width: auto !important;
  text-decoration: none !important;
  cursor: pointer
}
#total_clients_loader{
  max-height: 18px;
    margin-top: -3px;
}
  .widget-header{
    display: block;
  }

  #canVasDiv{
    z-index: 88;
  }

  .TreeStat .widget .resize_charts{
    border: 1px solid #ffffff;
  }

  #myTabContentDASH .TreeStat .widget-content{
    background: #ffffff;
    border-radius: 0px;
    padding-top: 30px;
  }

  .TreeStat .resize_charts{
    margin-left: 0px !important;
  }

  .cf .overviewDiv ul{
      background-color: #fff;
      position: static;
  }

  .treeDesc .table{
    margin-bottom: 0px;
  }

  .internet span{
    text-transform: uppercase;
  }

  .headlabel{
    text-align: left;
    padding-left: 3.5em;
  }

  .headName{
    text-align: left;
    padding-left: 1.6em;
  }

  span.arrow {
     font-size: 18px;
     font-weight: 700;
     max-width: 80px;
     display: none;
     width: 100%;
     /*position: absolute;*/
     left: 17px;
     top: -22px;
     cursor: pointer;
  }
 
  span.arrow:before {
    content: "\f104";
    font-family: FontAwesome;
    font-size: 23px;
  }

 label.node_txt {
      margin-top: 15px;
 }
 
 .treeDiv {
     width: 40%;
     height: 500px;
     position: relative;
     box-sizing: border-box;
     -webkit-box-sizing: border-box;
     display: inline-block;
     float: left;
     background: #fff; 
      -webkit-transition: width 0.2s ease;
     -o-transition: width 0.2s ease;
     transition: width 0.2s ease;
 }

 .treeDiv .internet{
      padding-left: 3.5em;
      height: 80px;
      display: -webkit-box;
     display: -ms-flexbox;
     display: flex;
 }

 .treeDiv .internet img{
      height: 100%;
      display: inline-block;
      cursor: pointer;
 }

 .treeDiv .internet span{
      vertical-align: top;
      padding: 1em;
      padding-left: 1em;
 }
 
/* ul.tree {
     background: url(https://bi-dmz-2.arrisi.com/campaign_portal_demo/layout/COMCAST/img/internet.png);
     background-repeat: no-repeat;
     background-size: 60px;
     padding-top: 70px;
     background-position: 50% 0%;
     padding-left: 64px
 }*/
 
 .tree {
     margin: 1em
 }
 
 .tree input {
     position: absolute;
     clip: rect(0, 0, 0, 0)
 }
 
 .tree input~ul {
     display: none;
     margin-left: 0px;
 }
 
 .tree input:checked~ul {
     display: block
 }
 
 .tree li {
     padding: 0 0 1em 2em;
     list-style-type: none;
 }
 
 .tree>li:nth-child(1) {
     border-top: 2px dotted black;
 }
 
 .tree ul li {
     padding: 0.5em 0 0 0;
     list-style-type: none
 }
 
 .tree>li:last-child {
     padding-bottom: 0
 }
 
 #canVasDiv .treeUl h3{
    margin-bottom: 0px;
 }

 .treeUl li label.switch, .treeUl li label.ap, .treeUl li label.vedge,.treeUl li label.firewall{
    width: 150px;
    cursor: pointer;
    background-repeat: no-repeat;
    height: 30px;
    background-position: 0% 0%;
    background-size: 100% auto;
 }

 .treeUl li label.switch, .tree.treeUl > li:nth-child(2){
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwitchOpen.png);
 }

 .treeUl li input:checked~label.switch{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwithcClosed.png);
 }

 .treeUl li label.ap, .tree.treeUl > li:nth-child(3){
    background-image: url(layout/<?php echo $camp_layout; ?>/img/apOpen.png);
 }

 .treeUl li input:checked~label.ap{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/apClosed.png);
 }

 .treeUl li label.vedge, .tree.treeUl > li:nth-child(1){
    background-image: url(layout/<?php echo $camp_layout; ?>/img/RouterOpen.png);
 }

 .treeUl li input:checked~label.vedge{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/RouterClosed.png);
 }

 .treeUl li label.firewall, .tree.treeUl > li:nth-child(1){
    background-image: url(layout/<?php echo $camp_layout; ?>/img/firewallOpen.png);
 }

 .treeUl li input:checked~label.firewall{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/firewallClosed.png);
 }

 .tree.treeUl > li:nth-child(1), .tree.treeUl > li:nth-child(2), .tree.treeUl > li:nth-child(3){
  background-size: 0;
 }

 .treeUl li .switchChild, .treeUl li .apChild, .treeUl li .vedgeChild, .treeUl li .firewallChild {
    background-repeat: no-repeat;
    background-size: contain;
    padding-left: 2.5em;
    cursor: pointer;
    text-align: left;
    background-size: auto 18px;
 } 

 .treeUl li .switchChild.Online{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwitchOn.png);
 }

 .treeUl li .switchChild.Offline{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwitchOff.png);
 }

 .treeUl li .apChild.Online{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/apOn.png);
 }

 .treeUl li .apChild.Offline{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/apOff.png);
 }

 .treeUl li .vedgeChild.Online{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/RouterOn.png);
 }

 .treeUl li .vedgeChild.Offline{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/RouterOff.png);
 }

 .treeUl li .firewallChild.Online{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/firewallOn.png);
 }

 .treeUl li .firewallChild.Offline{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/firewallOff.png);
 }

 .treeUl li input[type="checkbox"] + label::before{
    display: none;
 }

 .detailsTree {
     display: inline-block;
     padding: 20px;
     text-align: left;
     overflow: auto;
     box-sizing: border-box;
     -webkit-box-sizing: border-box;
     width: 60% ;
     height: 500px;
     background: #fff;
      -webkit-transition: width 0.2s ease;
     -o-transition: width 0.2s ease;
     transition: width 0.2s ease;
 }

 .treeDesc table td{
    padding-left: 0px;
 }

 .treeDesc table th{
  padding-left: 0px;
 }
 
 .overviewDiv {
     text-align: left;
     margin-top: 30px;
 }
 
 #big_stats .stat {
     display: block !important;
     width: 100% !important;
 }
 
 .Treeloader {
     width: 100%;
     top: 0px;
     position: relative;
     padding-top: 30px;
 }

 .treeDivDetails table{
    margin-top: 20px;
 }

 .treeDivDetails table tr {
     border-top: none !important
 }
 
 .treeDivDetails table td {
     line-height: 30px;
 }
 
 #big_stats .stat.TreeStat {
     border: none !important;
 }
 
 .TreeStat .resize_charts {
     margin-top: 0px
 }
 
 .treeDivInner {
     margin-right: 30px;
     padding-bottom: 20px;
     padding-top: 20px;
     overflow: auto;
     height: 100%
 }

 .treeDiv.close .treeDivInner{
  border: none;
 }


 @media (max-width: 767px){

  .headlabel{
    padding-left: 1.1em;
  }

  .headName{
    padding-left: 0.5em;
  }

  span.arrow{
    display: inline-block;
  }
  .treeDiv{
    width: 100%;
  }
  .treeDivInner{
    margin-right: 0px;
  }
  .detailsTree{
    width: 0%;
    display: none;
  }
  /*.treeDiv .internet{
    text-align: center;
  }*/
  /*.treeDiv:not(.close) .treeDivInner{
    width: 60%;
    margin: auto;
    min-width: 220px;
  }*/
 }

 /* end overview css*/

.nav-tabs a[href^="#dashbox"]{
  border-bottom: 2px solid #fff !important;
}

.zg-ul-select{
  background: #fff !important;
}

.widget .resize_charts{
  border: 1px solid #f2f2f2;
}
.widget{
  margin-bottom: 0em;
}
.bottom-foot{
 width: 100%;
    height: 150px;
    position: absolute;
    background: #000;
    /* top: 100%; */
    bottom: 50px;
}
.trans-wid{
  position: static !important;
}

.nav-tabs{
  border-bottom: none !important;
}

.trans-wid-con{
  background: transparent !important;
    border: 1px solid transparent !important;
}
.tree_graph{
  padding-top: 40px;
  padding-bottom: 40px;
  min-width: 100%;
  padding-right: 10px;
}

@media (max-width: 480px){

  .tree_graph{
  min-width: 100%;
}
.resize_charts {
    margin-left: -5px !important;
}
.cf_min {
  position: static !important;
  width:100% !important;
}
}
.trans-wid-con #big_stats{
    position: relative;
    padding-bottom: 10px; /* changed 60px to 10px */
}
#myQuickTab{
    position: absolute;
    /*bottom: 0px;*/
    left: 0px;
    top: 90px;
    z-index: 44;
    width: auto !important;
}
.intro_page{
/*  height: 480px !important;
    margin-top: -35px;
    background-size: cover !important;
    background-position: center !important;*/
}
.home-white-top{
	    width: 100%;
    position: absolute;
    height: 300px;
    left: 0px;
    background: #fff;
    top: 0px;
    z-index: -2;
}

.home-white-bottom{
	    width: 100%;
    position: absolute;
    height: 100px;
    left: 0px;
    background: #fff;
    bottom: 0px;
    z-index: -2;
}
     html body{
                font-size:18px;
                font-weight: 400;
                    padding-bottom: 58px !important;
                        background: #fff !important;
            }
.p-y-2 {
    padding-top: 45px;
    padding-bottom: 45px;
}
.p-y-3 {
   /* padding-top: 45px;
    padding-bottom: 45px;*/
}
.m-b-1 {
    margin-bottom: 18px;
}
.m-t-1 {
   /* margin-top: 18px;*/
}

.cf_min{
  position: absolute;
    right: 0px;
    width: 50%;
}
.cf_min .nav-tabs{
  max-width: 200px;
  
}
.cf_min ul {
    position: relative !important;
    display: inline-block !important;;
    }
.cf_min .nav-tabs>li>a{
    
    padding-top: 12px !important;
    padding-bottom: 12px !important;
  }    
            /*==========================================================
                           counter section style
            ============================================================*/

            .main_counter_area{
                background-size: cover;
                overflow: hidden;
            }
            .main_counter_area .main_counter_content .single_counter{
                background: #0568ae;
                    color: #fff;
            }
            .main_counter_area .main_counter_content .single_counter i{
                font-size:36px;
            }

            .col-md-3 {
    /* display: inline-block; */
    width: 25%;
    float: left;
    text-align: center;
    padding-right: 15px;
    box-sizing: border-box;
    padding-left: 15px;
}

	.col-md-3:nth-child(1){
		padding-left: 0px;
	}

.col-md-3:nth-child(4){
		padding-right: 0px;
	}


.top-header-home{
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
  }
  .nav-tabs>li>a{
    color: #0568ae !important;
    border-radius: 0px 0px 0 0 !important;
    
  }

  .nav-tabs>li:nth-child(3)>a{
    border-right: none !important;
  }

  body {
    background: #ffffff !important;
}

h1.head {
    padding: 0px;
    padding-bottom: 60px;
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
/*  padding-top: 50px;*/
    /*border-bottom: 1px solid #000000;*/
}

.tab-pane:nth-child(1){
  padding-top: 0px;
}

.tab-pane:last-child{
  border-bottom: none;
}

.alert {
  /*position: absolute;
    top: 60px;*/
    width: 100%;
} 


ul.zg-ul-select{

    border-bottom: 1px solid #000;
}


ul.zg-ul-select li {
  border-radius: 3px;
  display: none;
      text-align: right;
}
ul.zg-ul-select li.active {

  display: flex;
  text-align: right;
}

ul.zg-ul-select.active li {
      text-align: right;
  display: block;
}

#myTabContentDASH .widget-header{
    position: absolute;
    z-index: 88;
    /* top: 30px; */
    background: #fff !important;
    border: 1px solid #fff;
}
/* start most popular graph css */
#myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
    right: 175px;
    width: 100px;
    bottom: 377px;
    top: auto;
    background: transparent !important;
    border: 1px solid transparent !important;
}

#myTabContentDASH .widget-header h2{
    width:100% !important;
    margin-right:0px;
    margin-left: 0px !important;
}

@media (max-width: 979px){

#myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
    bottom: 365px;
    left: auto;
}
}

@media (max-width: 768px){
  #myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
    bottom: 289px;
    right: 167px;
}
}

@media (max-width: 480px){
  #myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
        bottom: auto;
    left: -10px;
}
.para{
  text-align: center !important;
}
#myTabContentDASH .MOST_POP_FROM_ALL .para{
    margin-top: 46px !important;
    margin-bottom: 10px;
}
#myTabContentDASH .widget-header{
  top: 12px;
  left: -10px;
    background: transparent !important;
    border: 1px solid transparent !important;
}
.main .cf .nav-tabs:not(#myQuickTab){
  float: left !important;
}
.zg-ul-select{
  border-top: 4px solid #0568ae !important;
}
.main .cf .nav-tabs{
  width: auto !important;
  margin-right: 20px;
    top: 30px;
}
}
/* end most popular graph css */
#myTabContentDASH .widget-content{
	  background: #fff;
    border: 1px solid #ffffff;
}

.stat svg .highcharts-button text, .stat svg .highcharts-button tspan{
  fill: #0568ae !important;
  font-weight: 500;
}

#myTabContentDASH .tree_graph .widget-header{
  background: #ececec !important;
  border: 1px solid #d6d6d6;
  position: static;
}

#myTabContentDASH .tree_graph .widget-content{
  background: #FFF;
  border: 0;
}
.resize_charts {
    margin-top: 40px;
        background: #fff;
}

.icon-list-alt{
	display: none !important;

}

.widget-header h2{
	
text-shadow: none !important;
color: #000 !important
}

#big_stats .stat{
	border-left: 1px solid #fff !important;
}

.cf ul{
	position: absolute;
    z-index: 4;
    right: 0;
    background-color: #000;
        text-align: right;
        /*margin-right: 9px;*/
}

.cf .nav-tabs>.active>a, .cf .nav-tabs>.active>a:hover{
	    color: #ffffff;
    background-color: #000000;
    border: 1px solid #000;
}

.cf .nav-tabs>li>a:hover{
	border-color: #000000 #000000 #000000;
}
.cf .nav>li>a:hover{
	background-color: #000000;;
	color: #fff;
}

.cf .nav-tabs>li, .cf .nav-pills>li{
	float: none;
}
.alert {
  position: absolute;
    top: 60px;
    width: 100%;
} 

.cf .nav-tabs{
  width: auto !important;
  margin-top: 0px !important;
  padding-left: 0px !important;
  padding-top: 0px !important;
  padding-bottom: 0px !important;
  z-index: 1;
}

/*#counter .col-md-3{
  width: 100% !important;
  padding-right: 0px !important;
  display: none ;
}

#counter .col-md-3:nth-child(1){
  display: block;
}*/

#counter{
    margin-top: 80px;
}

#big_stats{
  margin-top: 0px;
}
.zg-ul-select:not(.active) li.active{
  background-image: url(layout/ATT/img/down.png);
    background-size: 20px;
    background-repeat: no-repeat;
    background-position: 100% 13px;
    padding-right: 20px;
}

.zg-ul-select.active > li:nth-child(1){
    background-image: url(layout/ATT/img/up.png);
    background-size: 20px;
    background-repeat: no-repeat;
    background-position: 100% 13px;
  }

  .zg-ul-select.active > li{
    padding-right: 20px;
  }

.mobile-menu{
        margin: 0;
    padding: 0;
    padding-top: 40px;
    display: none;
    border: none;
    list-style: none;
    text-align: center;
}


.mobile-menu span {
    display: inline-block;
    width: 20px;
    height: 20px;
    margin: 0 4px;
    background: transparent;
    border-radius: 20px;
    overflow: hidden;
    text-indent: -999em;
    border: 2px solid #fff;
    cursor: pointer;
}

.mobile-menu span.clicked{
    background: #fff;
}

.col-md-3{
	display: block;
}


@media (max-width: 768px){

  .header-on{
    width: 50%;
  }
	.col-md-3{
		width: 100% !important;
		padding-right: 0px !important;
		padding-left: 10px !important;
		display: none ;
		float: none !important;
		max-width: 400px;
	}

	.col-md-3:nth-child(1){
		display: block ;
	}

	.mobile-menu{
		display: block;
	}



.cf .nav-tabs:not(#myQuickTab){
	margin-top: 60px !important;
}

}

@media (max-width: 767px){
  
#myQuickTab{
  position: absolute;
    /* bottom: 0px; */
    left: 0px;
    top: 90px;
    padding-right: 20px;
    box-sizing: border-box;
    padding-left: 20px !important;
   
    z-index: 777;
    margin: auto;
    width: 140px !important;
    right: 0px;
}

#myQuickTab.active{
   height: 150px;
}
}
</style>

<!-- 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
 -->
<script type="text/javascript">
      // Counter 
          /*  jQuery('.statistic-counter').counterUp({
                delay: 10,
                time: 2000
            });*/


$.fn.ulSelect = function(){
  var ul = $(this);

  if (!ul.hasClass('zg-ul-select')) {
    ul.addClass('zg-ul-select');
  }

  $(this).on('click', 'li', function(event){
    
    // Remove div#selected if it exists
    if ($('#selected--zg-ul-select').length) {
      $('#selected--zg-ul-select').remove();
    }
    ul.before('<div id="selected--zg-ul-select"></div>');
    var selected = $('#selected--zg-ul-select');
    $('li #ul-arrow', ul).remove();
    ul.toggleClass('active');
    // Remove active class from any <li> that has it...
    ul.children().removeClass('active');
    // And add the class to the <li> that gets clicked
    $(this).toggleClass('active');

    var selectedText = $(this).text();
    if (ul.hasClass('active')) {
      //selected.text(selectedText).addClass('active').append(arrow);
    }
    else {
      selected.text('').removeClass('active'); 
     // $('li.active', ul).append(arrow);
    }

    var tabDiv = $(this).find('a').attr('href').replace('#', '');
    $($('#' + tabDiv).parent()).find('.tab-pane').removeClass('active').removeClass('in').addClass('fade');
    $('#' + tabDiv).addClass('in').addClass('active');

    });
    // Make ul tabbable
    /*$(ul).focus(function(){
     $(this).keydown(function(e) {
      if(e.which == 38 || 40) { // Up or down keypress
        $(this).addClass('active');
        var liActive =  $('li.active', ul);
        var liPrev = $('li.active', ul).prev();
        var liNext =  $('li.active', ul).next();
        if(e.which == 38) { // Down
          liActive.removeClass('active');
          liPrev.addClass('active');
        }
        if(e.which == 40) { // Down
          liActive.removeClass('active');
          liNext.addClass('active');
        }
      }
     });
     $(this).keydown(function(){
        if(e.which == 13) { // Down
          ul.removeClass('active');
        }
      });
    });*/
    // Close the faux select menu when clicking outside it 
    $(document).on('click', function(event){
    if($('ul.zg-ul-select').length) {
     if(!$('ul.zg-ul-select').has(event.target).length == 0) {
      return;
    }
    else {
      $('ul.zg-ul-select').removeClass('active');
      $('#selected--zg-ul-select').removeClass('active').text('');
      $('#ul-arrow').remove();
    } 
    }
    });
  }


function  set_btn(a,this_val){

	$(this_val).parent().parent().find('.col-md-3').hide();
	$(this_val).parent().find('span').removeClass('clicked');
	$(this_val).addClass('clicked');
	$(this_val).parent().parent().find('.col-md-3:nth-child('+ (a + 1) +')').show();
}
</script>

<!--<script type="text/javascript">



    $(document).ready( function(){

/*  $('#create_theme').addClass('in').addClass('active');*/
  

    $('#myTabDash li').removeClass('active');
    $('#myTabDash [data-toggle="tab"]').attr('data-toggle', 'tab1');

  

    $('#myTabDash [data-toggle="tab1"]').each(function(index, el) {

      var tabDiv = $(this).attr('href').replace('#', '');
      $( this ).attr('href', 'javascript:void(0)');
      $( this ).attr('data-div', tabDiv);
    });

    $('[data-toggle="tab1"]').click(function(event) {


      var tabDiv = $(this).attr('data-div');

      $('#dash_section_tab_0').removeClass('active');;
      $('#dash_section_tab_1').removeClass('active');;
      $('#dash_section_tab_2').removeClass('active');;
     

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



</script>-->