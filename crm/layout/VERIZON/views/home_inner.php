
 

<style type="text/css">

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

  /* start most popular graph css */
#myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
    right: 185px;
    width: 100px;
    bottom: 310px;
    top: auto;
}

#myTabContentDASH .MOST_POP_FROM_ALL .widget-header h2{
    width:100% !important;
    margin-right:0px;
}

.MOST_POP_FROM_ALL{
    text-align: left;
  }

  .HEAD_MOST_POP{
    display: block !important;
    width: 70%;
      padding-left: 0px;
      border-top: 5px solid black;
      font-size: 64px;
      text-align: left;
      padding-top: 20px;
      margin-top: 29px;
      margin-bottom: 30px;
      margin-left: 0px;
      color: #000;
      font-family: "NHaasGroteskDSStd-75Bd";
  }
  .para{
    font-size: 13px;
    width:100% !important;
  }

@media (max-width: 979px){

#myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
    bottom: 365px;
    left: auto;
}
}

@media (max-width: 768px){
  #myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
    bottom: 295px;
    right: 178px;
}
}

@media (max-width: 480px){
  #myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
    bottom: 397px;
    right: 187px;
}
}
/* end most popular graph css */
  
  /*overview css*/

  #myTabContentDASH .TreeStat .widget-content{
    background: #ffffff;
    border-radius: 0px;
    padding-top: 30px;
  }

  
  #myTabDash,
  #myTabContentDASH {
      margin-left: -10px !important;
      width: auto !important;
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
 }

 .treeDiv .internet img{
      height: 100%;
      display: inline-block;
      cursor: pointer;
 }

 .treeDiv .internet span{
      vertical-align: top;
      padding: 1em;
      width: 50%;
      padding-top: 0px;
      display: inline-block;
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
  .container{
    padding-left: 0px !important;
    padding-right: 0px !important;
}
 .main-inner .container{
    padding-left: 30px !important;
    padding-right: 30px !important;
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

 .resize_charts .ajax-loader{
    position: absolute;
    top: 20%;
    left: 0;
    right: 0px;
    max-width: 200px;
    margin-left: auto;
    margin-right: auto;
  }

.single_counter i, .single_counter h2, .single_counter font {
    color: #fff !important;
}

#myQuickTab li {
    border-bottom: none !important;
    padding: 5px 20px 4.5px 20px !important;
    color: #000 !important;
    margin: 0 5px !important;
    cursor: pointer !important;
    margin-bottom: -3px !important;
    z-index: 2 !important;
    font-size: 12pt !important;
    font-weight: unset;
    border-right: 1px solid #CFCECE;
}

#myQuickTab>li:nth-last-child(1), #myQuickTab>li:nth-last-child(1)>a {
    border-right: 0px !important;
}

#myQuickTab li a:hover, .cf .nav-tabs.zg-ul-select li a:hover{
    border: 1px solid transparent;
}

#myQuickTab li.active a:hover, .cf .nav-tabs.zg-ul-select li.active a:hover{
    border: none;
}

@media (max-width: 979px){
  #myQuickTab{
    width: auto !important;
    margin-top: -25px !important;
}
#myQuickTab>li>a{
  padding-right: 10px !important;
    padding-left: 10px !important;
}
#big_stats .stat{
  width: 100% !important;
}
.main .cf .nav-tabs{
  right: -22px !important; 
}
}
@media (max-width: 767px){
html body {
    padding-left: 0px  !important;
    padding-right: 0px !important;
}

.footer-main{
  margin-left: 0px;
    margin-right: 0px;
}
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

@media (max-width: 520px){
  .main-inner .container{
    padding-left: 0px !important;
    padding-right: 0px !important;
  }

  .tab-content{
        padding-left: 10px !important;
    padding-right: 10px !important;
    background-color: transparent !important;
  }
  #myTabDash, #myTabContentDASH{
    margin-left: 0px !important;
  }
}


.trans-wid-con #big_stats{
    position: relative;
    padding-bottom: 60px;
}
#myQuickTab{
    position: absolute;
    left: 0px;
    top: 100px;
    text-align:center;
    z-index: 44;
    width: auto;
}

h2.head.container{
  margin-bottom: 30px;
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
    background: #e9e9e9;
    bottom: 0px;
    z-index: -2;
}
     html body{
                font-size:18px;
                font-weight: 400;
                    /*padding-bottom: 58px !important;*/
                      /*   background: #e9e9e9 !important; */
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

            /*==========================================================
                           counter section style
            ============================================================*/

            .main_counter_area{
                background-size: cover;
                overflow: hidden;
            }
            .main_counter_area .main_counter_content .single_counter{
                background: #000;
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

  /*home styles*/

  .top-header-home{
        display: none;
  }
  .intro_page{
    z-index: -4;
  }
  #myTabDash{
    /*background: #000;
    width: 80% !important;
    margin: auto;
    margin-top: -45px;
    margin-left: auto !important;*/
  /*  padding-top: 35px !important;
    padding-bottom: 35px !important;*/
    z-index: 999999;
  }


body .nav-tabs>.active>a, body .nav-tabs>.active>a:hover{

border: none ;
}


.tab-pane .widget:last-child{
      margin-bottom: 0px !important;
}

  body {
    background: #e9e9e9 !important;
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

.tab-content{
  padding-top: 0px !important;
    padding-bottom: 0px !important;
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
	/*padding-bottom: 50px;*/
  background-color: #fff !important;
}

.main {
    padding-bottom: 0 !important;
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
    top: 18px;
    background: transparent !important;
    border: 1px solid transparent;
    margin-left: 20px;
}

#myTabContentDASH .widget-content{
	  background: #fff;
    border: 1px solid #54585a;
}

#myTabContentDASH .THREE_GRAPH_BOX_NEW .widget-content{
	  background: #ffffff;
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
color: #000 !important;
}

#big_stats .stat{
	border-left: 0px solid #54585a !important;
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
	   color: #000;
    background-color: #fff;
    font-weight: 600;
    text-decoration: none;
}

.cf .nav-tabs>li>a:hover{
	border: none;
}
.cf .nav>li>a:hover{
	background-color: #fff;
  color: #000;
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
  padding-bottom: 0px !important
}

/*#counter .col-md-3{
  width: 100% !important;
  padding-right: 0px !important;
  display: none ;
}

#counter .col-md-3:nth-child(1){
  display: block;
}*/

.zg-ul-select:not(.active) li.active{
  /*background-image: url(layout/ARRIS/img/down2.png);*/
    background-image: url(layout/<?php echo $camp_layout; ?>/img/down2.png);
    background-size: 20px;
    background-repeat: no-repeat;
    background-position: 100% 13px;
    padding-right: 20px;
}

 .zg-ul-select.active > li:nth-child(1){
    /*background-image: url(layout/ARRIS/img/up2.png);*/
    background-image: url(layout/<?php echo $camp_layout; ?>/img/up2.png);
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
        width: 32px !important;
    height: 2px !important;
    margin: 0 4px !important;
    background: #000 !important;
    border-radius: 0px !important;
    overflow: hidden !important;
    text-indent: -999em !important;
    border: none !important;
    cursor: pointer !important;
    display: inline-block !important;
    opacity: 0.2 !important;
}

.mobile-menu span.clicked {
    width: 32px !important;
    height: 2px !important;
    margin: 0 4px !important;
    background-color: #000 !important;
    border-radius: 0px !important;
    overflow: hidden !important;
    text-indent: -999em !important;
    border: none !important;
    cursor: pointer !important;
    opacity: 1 !important;
}

.mobile-menu span.clicked{
    background: #fff;
}

.col-md-3{
	display: block;
}


@media (max-width: 767px){

  .header-on{
    width: 50%;
  }
	.col-md-3{
		width: 100% !important;
		padding-right: 0px !important;
		padding-left: 0px !important;
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
  position: absolute;
    left: 0px;
    top: 100px;
    padding-right: 0px;
    box-sizing: border-box;
    padding-left: 0px !important;
    z-index: 777;
    margin: auto;
    width: 145px !important;
    right: 0px;
}

#myQuickTab.active{
   height: 180px;
}

#myQuickTab{
      margin-top: -5px !important;
}

#myQuickTab li{
  border-right: none;
}
}

@media (max-width: 480px){

  .tree_graph{
  min-width: 100%;
}
.resize_charts {
    margin-left: 0px !important;
    margin-right: 0px !important;
}
.cf_min {
/*   margin-top: -40px; */
}

.main .cf .nav-tabs{
  top: 15px;
  left: -11px;
      right: 2px !important;
}
#myQuickTab{
  margin-top: -25px !important;
}
}
.custom-tabs{
    position: absolute;
    width: 100%;
    height: 25px;
    background: #ffffff;
    z-index: 0;
    border-bottom: 3px solid #0066e3;
}

#myTabDash.newTabs{
  margin-left: 0px !important;
}

#myTabContentDASH{
  margin-left: 0px !important;
}
 
/*#sami_pro a{
  width: 100px !important;
  white-space: nowrap !important;
}*/
#sami_proa{
  width: 140px !important;
}
#sami_pro:hover .drop_new{
      width: 140px !important;
}
#sami_pro>a{
  width: 95px !important;
}

#sami_pro>li:last-child>a {
     line-height: 20px !important;
 }

@media (max-width: 520px){

  #myTabDash.newTabs{
  margin-left: 0px !important;
}

}

#innerCanvasContainer .headName, h2.head.container, .wifi-inf .headName{
    width: 70%;
    padding-left: 0px;
    border-top: 5px solid black;
    font-size: 64px;
    padding-top: 20px;
    margin-bottom: 30px;
    margin-left: 0px;
    color: #000;
    font-family: "NHaasGroteskDSStd-75Bd";

}

h2.head.container{
    text-align: left;
    padding-left: 0px !important;
    padding-bottom: 20px;
}

#innerCanvasContainer .headlabel, .wifi-inf .headlabel{
    padding-left: 0px;

}

@media screen and (max-width: 979px) and (min-width: 521px){
  #innerCanvasContainer .headName, h2.head.container, .wifi-inf .headName {
      font-size: 45px !important;
  }
  #myQuickTab{
    top: 120px;
  }
}

@media (max-width: 520px){
  #innerCanvasContainer .headName, h2.head.container, .wifi-inf .headName {
      font-size: 30px !important;
      border-top: 0px;
      width: 100%;
      margin-left: 0px;
  }
}

.subnavbar .dropmenu_new li{
  height: 40px;
}

@media (max-width: 979px){
  .tab-pane {
       padding-top: 0px; 
  }
}

.widget-nopad .widget-header {
     display: block !important; 
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

