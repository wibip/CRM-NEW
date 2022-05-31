<style type="text/css">

#myTabContentDASH_WIFI_INFORMATION_BOX, #myTabDASHBOX_WIFI_INFORMATION_BOX,#myTabContentDASH_TOP20_CLIENT_DETAILS_BOX,#myTabDASHBOX_TOP20_CLIENT_DETAILS_BOX{
  border: none !important;
}
#myTabContentDASH_WIFI_INFORMATION_BOX .wifi-inf .headName,
#myTabContentDASH_WIFI_INFORMATION_BOX .wifi-inf .headlabel,
#myTabContentDASH_THREE_GRAPH_BOX_NEW .innerCanvasContainer .headName,
#myTabContentDASH_THREE_GRAPH_BOX_NEW .innerCanvasContainer .headlabel,
#myTabContentDASH_WIFI_INFORMATION_BOX .wifi-inf .wifi-inf1
{
  padding-left: 0;
}
#myTabContentDASH_WIFI_INFORMATION_BOX .wifi-inf a,
#myTabContentDASH_THREE_GRAPH_BOX_NEW a
{
  color: #0565a9;
}

.wifi-inf tr td:nth-child(1){
  width: 42% !important;
}
.wifi-inf .res-inf3 tr td:nth-child(1){
  width: 53% !important;
}
#myTabContentDASH_THREE_GRAPH_BOX_NEW .overviewDiv{
  margin-top: 35px;
}
#dashbox_TOP20_CLIENT_DETAILS_BOX_0 .widget-table,
#dashbox_TOP20_CLIENT_DETAILS_BOX_0 .widget-header
{
  padding: 0 !important;
}
.WIFI_INFORMATION_BOX .widget-header,
.TOP20_CLIENT_DETAILS_BOX .widget-header,
.THREE_GRAPH_BOX_NEW .widget-header
{
  height: 20px !important;
}
ul.zg-ul-select{
  border-bottom: 1px solid #ddd !important;
}
.TOP20_CLIENT_DETAILS_BOX .resize_charts .widget-header{
  height: 46px !important;
}

.ui-tooltip {
    background-color: #fff !important;
    color: #333 !important;
}
  /*overview css*/
  label.tree_label.selected{
    font-weight: bold;
  }
  .overview.a{
    position: absolute;
    top: 20px;
    color: #0565a9;
  }
  .innerCanvasContainer1 .treeDesc, .innerCanvasContainer1 .treeDivDetails{
    margin-top: 35px;
  }
  .innerCanvasContainer1 .treeDesc h2, .innerCanvasContainer1 .treeDesc label{
    text-align: center
  }
  .innerCanvasContainer1 .Treeloader{
    text-align: center
  }
  .THREE_GRAPH_BOX_COX_NEW::before {
    content: "Note: The information on the Network-at-a-Glance tab is informational and is intended to provide an informal summary of the health of the Managed WiFi network. It reflects near-real-time information, but actual status information may be delayed by internet traffic congestion and latency. Session, port usage, and client data may not reflect real-time observations. ";
    display: block;
    text-align: left;
    margin-bottom: 15px;
}
.treeDivDetails th, .treeDivDetails td {
    padding-right: 12px;
}
.THREE_GRAPH_BOX_COX_NEW>.widget-header {
    display: none;
}
.hide-details{
  position: relative;
  color: #0565a9;
}
  .innerCanvasContainer1{
   /*  margin-top: 30px; */
    min-height: 200px;
  }
  .innerCanvasContainer1.JsError{
    height: 100%;
    text-align: center;
    display: table;
    min-height: 200px;
    margin: auto;
  }
  .onJsError{
    margin: auto;
    display: table-cell;
    width: 500px;
    padding-left: 30px;
    max-width: 100%;
    padding-right: 30px;
    height: 200px;
    vertical-align: bottom;
  }
  .onJsError h3{
    color: #cdcdcd;
    font-weight: 700;
    font-family: Arial;
    font-size: 15px;
    text-align: left;
  }
  .onJsError h4{
    font-size: 15px !important;
    font-weight: normal !important;
    font-family: Open Sans;
    color: #cdcdcd !important;
    text-align: left;
  }
  .widget-header{
    display: block;
  }

  #canVasDiv1{
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

  .cf .overviewDiv1 ul{
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
     /* height: 500px; */
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
 
 .tree input:checked + label + ul {
     display: block
 }
 
 .tree li {
     padding: 1em 0 0 2em;
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
    font-size: 16px;
 }

 .treeUl li label.switch, .treeUl li label.ap, .treeUl li label.vedge{
    width: 150px;
    cursor: pointer;
    background-repeat: no-repeat;
    height: 30px;
    background-position: 0% 0%;
    background-size: 100% auto;
 }

 .treeUl li label.switchGroup, .treeUl li label.switchSingle{
    width: 100px;
    cursor: pointer;
    background-repeat: no-repeat;
    height: 30px;
    background-position: 0% 0%;
    text-indent: 110px;
    font-weight: 600;
    padding-top: 6px;
    background-size: 100% auto;
    margin-top: 10px;
    white-space: nowrap;
    
 }

 .tree h4 {
    font-size: 14px !important;
    margin-bottom: 10px !important;
    color: #000 !important;
}

.switchGroupInput.selected + label{
  font-weight: bold;
}

 .treeUl li label.switch, .tree.treeUl > li:nth-child(2){
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwitchOpen.png);
 }

 .treeUl li input:checked~label.switch{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwithcClosed.png);
 }

 .treeUl li label.switchGroup, .tree.treeUl > li:nth-child(2){
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwitchGroupClosed.png);
 }

 .treeUl li input:checked + label.switchGroup{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwtchGroupOpen.png);
    text-indent: 100%;
    overflow: hidden;
 }

 .treeUl li label.switchSingle, .tree.treeUl > li:nth-child(2){
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SingleSwitchClosed.png);
 }

 .treeUl li input:checked + label.switchSingle{
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SingleSwitchOpen.png);
    text-indent: 100%;
    overflow: hidden;
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

 .tree.treeUl > li:nth-child(1), .tree.treeUl > li:nth-child(2), .tree.treeUl > li:nth-child(3){
  background-size: 0;
 }

 .treeUl li .switchChild, .treeUl li .apChild, .treeUl li .vedgeChild {
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
     /* height: 500px; */
     background: #fff;
      -webkit-transition: width 0.2s ease;
     -o-transition: width 0.2s ease;
     transition: width 0.2s ease;
 }

 /* .treeDesc table td{
    padding-left: 0px;
 }
 */
 .treeDesc table th{
  padding-left: 0px;
 }
 
 .overviewDiv1 {
     text-align: left;
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

 .treeDivInner.treeLoad::before {
    width: 100%;
    height: 100%;
    content: "";
    position: absolute;
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
 
ul[id*="THREE_GRAPH_BOX"]{
      border-top: none !important;
    }
  body{
    background: #ffffff !important;
  }
  .footer-inner{
    height: 70px !important;
  }

  body .main-inner .widget-header{
    background: #ffffff !important;
    border: 1px solid #ffffff !important;
  }

  body .widget-content {
    background: #ffffff !important;
}

  .resize_charts {
    background: #fff;
}

   .intro_page{
        
    <?php 

    if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
        echo 'height: 337px;margin-top: -35px;background-size: 100%;';
    } 

     ?>

     height: 300px !important;
    margin-top: -35px !important; 
    background-repeat: no-repeat;
    background-size: cover !important;
    background-position: center !important;
        
        
    }

    .intro_page_txt{
           /* width: 960px;*/
            margin: auto;
            text-align: center;
            /* left: 20%; */
            padding-top: 70px;
    }

    .intro_page_txt h1{
        font-size: 47px;
        color: #fff;
        line-height: 50px;
    }

    .intro_page_txt h2{
        font-size: 36px;
        color: #fff;
         line-height: 45px;
    }

    @media (max-width: 979px){
        .resize_charts {
    margin-left: -20px !important;
    margin-right: -30px !important;
}
    }
</style>


 

<style type="text/css">

.trans-wid{
  position: static !important;
}

.widget-content{
	    background: #f2f2f2 !important;
}

#big_stats{
	margin-top: 0px !important;
}

.trans-wid-con{
  background: transparent !important;
    border: 1px solid transparent !important;
}


.trans-wid-con #big_stats{
    position: relative;
    padding-bottom: 60px;
}
#myQuickTab{
    position: absolute;
    bottom: -30px;
    left: 50%;
    margin-left: -243px;
    z-index: 44;
    width: auto;
}

#myQuickTab li.active a{
	background-color: #ffffff !important;
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
/*@media (max-width: 480px){

#myQuickTab {
    margin-left: -173px !important;
}

}*/
.cf_min .nav-tabs{

  float: none !important;
}
            /*==========================================================
                           counter section style
            ============================================================*/

            .main_counter_area{
                background-size: cover;
                overflow: hidden;
            }
            .main_counter_area .main_counter_content .single_counter{
                background: #03406A;
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



h1.head {
    padding: 50px;
    width: 100% !important;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #000;
    font-family: Rbold;
}


ul.zg-ul-select{

    border-bottom: 1px solid #000;
}


ul.zg-ul-select li {
  border-radius: 3px;
 /*  display: none; */
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


/*#counter .col-md-3{
  width: 100% !important;
  padding-right: 0px !important;
  display: none ;
}

#counter .col-md-3:nth-child(1){
  display: block;
}*/


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
    border: 2px solid #000;
    cursor: pointer;
}

.mobile-menu span.clicked{
    background: #000;
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

  #myQuickTab{
    bottom: 26px;
    left: 0;
    z-index: 44;
    width: 328px;
    right: 0;
    margin: auto;
  }

  #myQuickTab>li>a, #myQuickTab>li>a{
    padding-left: 5px;
    padding-right: 5px;
  }

/* .cf .nav-tabs:not(#myQuickTab){
	margin-top: 60px !important;
}

#myQuickTab{
  position: absolute;
    bottom: 0px;
    left: 50%;
    top: 90%;
    box-sizing: border-box;
   background-color: transparent !important;
   width: 170px !important;
    z-index: 777;
    margin: auto;
    right: 0px;
    margin-left: -85px !important;
}

#myQuickTab li.active a{
	background: none !important;
}

#myQuickTab.active{
   height: 140px;
}
}

#myQuickTab li a{
	    background: none !important;
    box-sizing: border-box;
    width: 170px;
}

#myQuickTab li.active a:after{
	    margin-top: 5px;
    margin-left: 5px;
} */

@media (max-width: 600px){
  .ssid_l{
    z-index: 10;
    width: 100% !important;
    top: 35px;
    text-align: left !important;
  }
  select.ssid_se{
    width: 115px;
  }
  .highcharts-container{
    margin-left: 10px;
  }

}
</style>

<script type="text/javascript">



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

<script type="text/javascript">





</script>