<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<style type="text/css">

.highcharts-data-table table thead th{
  background: #E9E9E9;
    background: -moz-linear-gradient(top, #FAFAFA 0%, #E9E9E9 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #FAFAFA), color-stop(100%, #E9E9E9)) !important;
    background: -webkit-linear-gradient(top, #FAFAFA 0%, #E9E9E9 100%) !important;
    background: -o-linear-gradient(top, #FAFAFA 0%, #E9E9E9 100%) !important;
    background: -ms-linear-gradient(top, #FAFAFA 0%, #E9E9E9 100%) !important;
    background: linear-gradient(top, #FAFAFA 0%, #E9E9E9 100%) !important;
    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9');
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9')";
    font-size: 10px;
    color: #444;
    font-family: Montserrat-Regular !important;
    border-top: none !important;
    border-bottom: none !important;
    text-transform: uppercase;
    padding: 8px;
    line-height: 18px;
}
.highcharts-data-table table th, .highcharts-data-table table td{
  line-height: 18px;
  font-family: Montserrat-Regular !important;
    border: 1px solid #ddd;
    border-bottom: none;
    border-right: none;
}

.highcharts-data-table table td:first-child, .highcharts-data-table table th:first-child  {
    border-left: none;
}

.highcharts-data-table tbody tr:nth-child(odd), .highcharts-data-table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.highcharts-data-table tbody tr:hover td, .highcharts-data-table tbody tr:hover th {
    background-color: #f5f5f5;
}

.highcharts-data-table table tbody tr:nth-child(odd) td, .highcharts-data-table table tbody tr:nth-child(odd) th {
    background-color: transparent;
}
.WIFI_INFORMATION_BOX .widget-header {
    display: none !important;
}

.THREE_GRAPH_BOX .widget-header {
    position: static !important;
}
.THREE_GRAPH_BOX #big_stats, .THREE_GRAPH_BOX_ALT_ENT .resize_charts{
    margin-top: 0
}
.innerCanvasContainer{
  background: #ffffff;
    border-radius: 20px;
}
  /*overview css*/
  .THREE_GRAPH_BOX_ALT > .widget-header, .THREE_GRAPH_BOX > .widget-header{
    display: none;
  }

  .CLIENT_DETAILS_BOX #myTabContentDASH_CLIENT_DETAILS_BOX .client-header{
    color: #191919 !important;
    padding: 0 !important;
    font-size: 30px;
    padding-left: 1.6em !important;
    padding-bottom: 20px !important;
  }

  .CLIENT_DETAILS_BOX .resize_charts{
    margin-top: 0;
    background-color: #fff !important;
    padding-top: 30px;
  }

  .dt-button{
    color: #E57200;
    background: transparent;
    border: none;
    font-weight: 600;
    font-size: 16px !important;
  }

  #myTabContentDASH .CLIENT_DETAILS_BOX .widget-content, #myTabContentDASH .CLIENT_DETAILS_BOX .widget-header{
    background-color: transparent !important;
    border: none !important;
  }
  #clients_wrapper .tablesaw-advance-dots{
    position: static !important;
  }
  #clients{
    margin-top: 10px;
  }
  #reloadOverview{
    z-index: 1 !important;
    right: 10px !important;
  }
  #canVasDiv{
    z-index: 88;
  }

  .TreeStat .widget .resize_charts{
    margin-right: 0px !important;
    margin-left: 0px !important;
  }

  #myTabContentDASH .TreeStat .widget-content{
    background: #ffffff;
    border-radius: 0px;
    padding-top: 0px !important;
    border-radius: 20px;
  }

  #myTabContentDASH .widget .widget-content{
    padding-left: 10px !important;
    padding-top: 5px !important;
  }

  #myTabContentDASH_THREE_GRAPH_BOX .resize_charts{
    margin-top: 0;
    border-radius: 20px;
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

  .headlabel, .MOST_POP_FROM_ALL .para {
    text-align: left;
    padding-left: 3.4em;
    margin-top: 0 !important;
    width: 100% !important;
}

.headName {
    padding-left: 15px !important;
}

.headlabel {
    padding-left: 18px!important;
}

.wifi-inf .wifi-inf2, .wifi-inf .wifi-inf1{
  padding-left: 15px;
}

  .headName, .HEAD_MOST_POP {
    display: block !important;
    text-align: left;
    padding-left: 2.7em;
    font-size: 34px;
    color: #000;
    font-family: 'Montserrat-Bold';
}

.HEAD_MOST_POP {
    margin-top: 40px !important;
    padding-top: 5px;
}

.HEAD_MOST_POP2{
  margin-top: 40px !important;
    padding-top: 5px;
    text-align: left;
    padding-left: 50px;
    font-size: 34px !important;
    font-family: 'Montserrat-Bold';
}

.MOST_POP_FROM_ALL .HEAD_MOST_POP2{
  display: block !important;
}

.HEAD_MOST_POP2 {
    position: absolute;
    z-index: 1;
}

.MOST_POP_FROM_ALL .ARRIS_CDR_API_GRAPH_RUCKUS .highcharts-title{
  font-size: 14px !important;
    font-family: 'Montserrat-Regular';
    fill: #333333;
    font-weight: bold;
}
#myTabContentDASH .MOST_POP_FROM_ALL .widget-header{
  display: none !important;
}


  .TOP20_CLIENT_DETAILS_BOX .headlabel{
    color: #fff;
    padding-left: 3.2em;
  }

  .TOP20_CLIENT_DETAILS_BOX > .widget-header{
    display: none !important;
  }

  .TOP20_CLIENT_DETAILS_BOX .headlabel p{
    font-size: 16px !important;
    color: #191919;
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

 .treeUl li label.switch, .treeUl li label.ap, .treeUl li label.vedge, .treeUl li label.firewall{
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
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
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
 .treeDesc table td b{
  font-weight: normal;
 }
 .treeDesc table th{
  padding-left: 0px;
 }

 .overviewDiv {
     text-align: left;
     margin-top: 30px;
     background: white;
 }

 #big_stats .stat {
     display: block !important;
     width: 100% !important;
     border-left: none !important;
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

 .main-inner .container{
  padding: 0;
}


.main {
    width: 100%;
    max-width: 100%;
    padding: 0 70px;
    box-sizing: border-box;
}
#myTabContentDASH .widget-header h2 {
    margin-left: 3px !important;
    left: 0px !important;
    width: 100% !important;
    color: #191919 !important;
    font-size: 34px !important;
    font-family: 'Montserrat-Bold';
    padding-top: 40px;
    padding-left: 30px;
}
 @media (max-width: 1200px){
  .WIFI_INFORMATION_BOX #big_stats, .THREE_GRAPH_BOX_NEW #big_stats{
    margin-top: 0;
  }
  .headName, .HEAD_MOST_POP{
    padding-left: 0 !important;
    font-size: 22px;
  }
  #myTabContentDASH .widget-header h2, .MOST_POP_FROM_ALL .HEAD_MOST_POP2{
    font-size: 22px !important;
    padding-left: 0;
    padding-top: 0;
    line-height: 26px;
  }
  .cf_min {
    top: 12px !important;
    right: 0 !important;
}
  #myTabContentDASH .widget .widget-content{
    padding: 0 !important;
  }
  .main .main-inner {
    margin-top: 60px !important;
  }
  .main{
    padding: 0;
  }
  #myTabContentDASH .widget-nopad{
    border: none !important;
  }
  .main-inner .container{
    background: #fff;
    border: 3px solid #E57200;
    padding: 20px;
    border-radius: 10px;
  }
  .main .cf .nav.nav-tabs.zg-ul-select{
    padding-left: 0px !important;
  }
  #myTabDash{
    left: 0 !important;
    margin-left: -20px;
    margin-right: -20px;
    width: auto !important;
    border-bottom: 1px solid #D9D9D6 !important;
  }
  #myTabContentDASH .widget-header {
    left: 0 !important;
    width: 57%;
    top: 20px !important;
    padding-left: 0 !important;
  }
  .HEAD_MOST_POP2{
    padding-left: 0 !important;
    margin-top: 20px !important;
    width: 50%;
  }
  #myTabContentDASH .widget-header h2{
    display: -webkit-box !important;
    display: -ms-flexbox !important;
    display: flex !important;
  }
  .main .cf .nav-tabs{
    top: 9px !important;
  }
 }

 @media (max-width: 767px){

  .wifi-inf .wifi-inf1, .wifi-inf .wifi-inf2{
    padding-left: 5px;
  }

  .headlabel{
    padding-left: 3px !important;
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

  .tab-pane #big_stats .stat{
    width: 100%;
    display: block;
  }

  .resize_charts .ajax-loader{
    position: absolute;
    top: 20%;
    left: 0;
    right: 0px;
    max-width: 200px;
    margin-left: auto;
    margin-right: auto;
  }

.quick2{
  margin-bottom: 5px !important;
    border: 3px solid #E57200;
    background: #D9D9D6;
    border-radius: 10px;
}
.zoom-msg{
  width: 70%;
    margin: auto;
    padding-top: 10px;
    text-align: center;
}

.head.container{
  color: #fff;
}
.bottom-foot{
 width: 100%;
    height: 30px;
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
    border: none !important;
}
.tree_graph{
  padding-top: 40px;
  padding-bottom: 40px;
  min-width: 100%;
  padding-right: 10px;
}

.TOP20_CLIENT_DETAILS .headName{
  margin-top: 2px;
  display: inline-block !important;
  vertical-align: middle;
}

.TOP20_CLIENT_DETAILS .widget-header img[data-toggle="tooltip1"]{
  margin-bottom: -5px !important;
  vertical-align: middle;
}

.wifi-inf tr td {
  word-break: break-word !important;
}

@media (max-width: 480px){

  .resize_charts{
    padding: 5px 0 !important;
    border-radius: 0 !important;
  }

  .wifi-inf .wifi-inf1, .wifi-inf .wifi-inf2{
    padding-left: 0 !important;
    padding-right: 0;
  }

  .main .main-inner {
    margin-top: 40px !important;
  }
  .main{
    margin-top: 30px !important;
  }
  #myTabContentDASH_ARRIS_API_G_SESSIONS .stat,
  #myTabContentDASH_ARRIS_API_G_BANDWIDTH .stat,
  .ARRIS_CDR_API_GRAPH_RUCKUS #myTabContentDASH_MOST_POP_FROM_ALL .stat{
    margin-top: 40px;
  }
  .TOP20_CLIENT_DETAILS .stat{
    margin-top: -30px;
  }
  .NVI_TREE_SEC_COMCAST .headName, .WIFI_INFORMATION_BOX .headName{
    margin-top: -10px;
  }
  .TOP20_CLIENT_DETAILS .widget-table{
    padding: 0 !important;
  }
  .DSF_TOP_APP_COX .stat{
    margin-top: 30px;
  }
  #myTabContentDASH_PEAK_DATA_RATE .stat{
    margin-top: 25px;
  }
  #myTabContentDASH_ARRIS_API_G_OS .stat{
    margin-top: 15px;
  }
  .main-inner{
    margin-top: 160px !important;
  }
  #myTabContentDASH .WIFI_INFORMATION_BOX .TreeStat .widget-content, #myTabContentDASH  .THREE_GRAPH_BOX_NEW .TreeStat .widget-content{
    padding-top: 0px !important;
  }
  #myQuickTab.myQuickTab3.zg-ul-select,#myQuickTab.IotTab.zg-ul-select, #myQuickTab.myQuickTab2.zg-ul-select{
    top: 30px !important;
  }
  #big_stats .nav-tabs.dropdown_tabs>li>a{
    width: 100px;
    display: inline-block;
    text-align: right;
    font-size: 16px;
  }
  .quick2 .head.container, .quick3 .head.container{
    width: 250px;
  }
  .nav-tabs:not(.zg-ul-select):not(.dropdown_tabs){
    top: -120px !important;
  }
  .tree_graph{
  min-width: 100%;
}
.resize_charts {
    margin-left: -5px !important;
    margin-top: 0 !important;
}
.cf_min {
  margin-top: -5px;
}
}
.trans-wid-con #big_stats{
    position: relative;
    padding-bottom: 60px;
}
#myQuickTab{
    position: absolute;
    bottom: 0px;
    left: 0px;
    z-index: 44;
    width: auto;
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
    display: none;
}

.nav-tabs.newTabs:not(.zg-ul-select):not(.dropdown_tabs),
.nav-tabs.myQuickTab2:not(.zg-ul-select):not(.dropdown_tabs),
.nav-tabs.IotTab:not(.zg-ul-select):not(.dropdown_tabs),
.nav-tabs.myQuickTab3:not(.zg-ul-select):not(.dropdown_tabs){
  border-bottom: none !important
}

#myQuickTab.myQuickTab2, #myQuickTab.myQuickTab3, #myQuickTab.IotTab{
  top: -15px;
  bottom: auto;
}

body .myQuickTab2.nav-tabs:not(.zg-ul-select):not(.dropdown_tabs)>li>a,
body .IotTab.nav-tabs:not(.zg-ul-select):not(.dropdown_tabs)>li>a,
body .myQuickTab3.nav-tabs:not(.zg-ul-select):not(.dropdown_tabs)>li>a{
  color: #000 !important;
}

.quick2 .head.container, .quick3 .head.container{
  color: #000;
  display: none;
}


#myTabContentDASH .quick2 .widget-content, #myTabContentDASH .quick3 .widget-content{
  padding: 20px !important;
}

#myTabContentDASH .widget-nopad{
  border: 3px solid #E57200;
    background: #fff;
    border-radius: 10px;
}
.myQuickTab2.nav-tabs:not(.zg-ul-select):not(.dropdown_tabs)>li.active>a,
.IotTab.nav-tabs:not(.zg-ul-select):not(.dropdown_tabs)>li.active>a,
.myQuickTab3.nav-tabs:not(.zg-ul-select):not(.dropdown_tabs)>li.active>a{
  color: #000 !important;
}
.myQuickTab2.nav-tabs>.active>a, .myQuickTab2.nav-tabs>.active>a:hover,
.IotTab.nav-tabs>.active>a, .IotTab.nav-tabs>.active>a:hover,
.myQuickTab3.nav-tabs>.active>a, .myQuickTab3.nav-tabs>.active>a:hover{
  background-color: transparent;
}
.home-white-bottom{
	    width: 100%;
    position: absolute;
    height: 100px;
    left: 0px;
    background: #fff;
    bottom: 0px;
    z-index: -2;
    display: none;
}
.tablesaw-advance-dots{
    background-color: transparent !important;
  }

  .CLIENT_DETAILS_BOX .tablesaw-bar{
    width: auto;
    top: -16px;
    right: 0;
  }

  .CLIENT_DETAILS_BOX .dt-buttons{
    text-align: left;
  }

  .CLIENT_DETAILS_BOX .dt-button{
    color: #E57200;
    background: transparent;
    border: none;
    font-weight: 600;
    font-size: 16px !important;
  }

  .CLIENT_DETAILS_BOX
  .client-header{
    padding-left: 0 !important;
  }

     html body{
                font-size:18px;
                font-weight: 400;
                    padding-bottom: 58px !important;
                        background: #54585a !important;
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
    right: 25px;
    width: 50%;
    top: 40px;
}
.cf_min .nav-tabs{
  max-width: 100%;
}
.cf_min ul {
    position: relative !important;
    display: inline-block !important;;
    }
/* .ssid_load{
  display: inline-block;
    float: left;
    position: relative ;
}
.ssid_load ul {
    position: absolute !important;
    } */

            /*==========================================================
                           counter section style
            ============================================================*/

            .main_counter_area{
                background-size: cover;
                overflow: hidden;
            }
            .main_counter_area .main_counter_content .single_counter{
              border-radius: 20px;
    border: 1px solid #000;
    position: relative;
    height: 250px;
    background: #fff;
    color: #fff;
            }
            .main_counter_area .main_counter_content .single_counter div{
              position: absolute;
    bottom: -1px;
    background: #101820;
    right: -1px;
    left: -1px;
    border-bottom-right-radius: 18px;
    height: 50px;
    border-bottom-left-radius: 18px;
            }
            .main_counter_area .main_counter_content .single_counter i{
              color: #fff;
    position: absolute;
    right: 10px;
    bottom: 10px;
            }
            .main_counter_area .main_counter_content .single_counter h2{
              position: absolute;
    top: -113px;
    left: 0;
    right: 0;
    margin: auto;
    color: #000;
    font-size: 50px;
    font-weight: bold !important;
            }
            .main_counter_area .main_counter_content .single_counter font{
              position: absolute;
    bottom: 10px;
    left: 10px;
    width: 100%;
    text-align: left;
            }
            .main_counter_area .main_counter_content .single_counter br{
              display: none;
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
.col-md-3.quick-box {
  padding-right: 0px;
}
#big_stats {
    display: block !important;
  }
  .highcharts-container:not(.inline-container):not(.remove-full-width),  .highcharts-container:not(.inline-container):not(.remove-full-width) .highcharts-root {
    width: 100% !important;
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
  body #myTabDash>.active>a, body #myTabDash>.active>a:hover{
        background-color: #000000;
    border: none;
  }

  #myTabDash>li>a{
    background: none !important;
    border: none !important;
  }
  #myTabDash>li>a{
        padding-top: 3px !important;
    padding-bottom: 3px !important;
    border-radius: 0px 0px 0 0 !important;
  }

  #myTabDash>li:last-child>a{
  	border-right: none !important;
  }

  body {
    background: #ffffff !important;
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

.main-inner{
	position: relative;
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

  display: inline-block;
  text-align: right;
}

ul.zg-ul-select.active li {
      text-align: right;
  display: block;
}

#myTabContentDASH .widget-header{
  position: absolute;
    z-index: 88;
    top: 10px;
    background: transparent !important;
    border: none;
    display: block;
    padding-left: 20px;
}

#myTabContentDASH .IOT_BOX .widget-header{
  display: none;
}

#myTabContentDASH .TOP20_CLIENT_DETAILS_BOX .widget-header{
  padding-left: 0px;
  width: 100%;
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
    border-radius: 20px;
    overflow: hidden;
        background: #fff;
        padding: 5px;
        max-width: 100%;
}

.ARRIS_CDR_API_GRAPH_RUCKUS .resize_charts{
  margin-top: 40px;
}


.TOP20_CLIENT_DETAILS_BOX .resize_charts{
  border-radius: 20px;
  background-color: #ffffff !important;
  padding-top: 0px;
  margin-top: 0px;
}

#myTabContentDASH .TOP20_CLIENT_DETAILS_BOX .widget-header{
  background-color: transparent !important;
  border: none !important;
}
.zg-ul-select.nav-tabs>.active>a{
  background-color: transparent;
    border: none;
}

.icon-list-alt{
	display: none !important;

}

.widget-header h2{

text-shadow: none !important;
color: #fff !important
}

.cf ul{
	position: absolute;
    z-index: 4;
    right: 0;
        text-align: right;
        /*margin-right: 9px;*/
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

/* .MOST_POP_FROM_ALL .ARRIS_CDR_API_GRAPH_RUCKUS .tab-content>.tab-pane{
  display: block;
  opacity: 1;
}

.MOST_POP_FROM_ALL .ARRIS_CDR_API_GRAPH_RUCKUS .tab-content{
  display: -webkit-box !important;
     display: -ms-flexbox !important;
     display: flex !important;
} */

.zg-ul-select li.active{
  background-image: url(layout/<?php echo $camp_layout; ?>/img/form-fields-biz.png);
  background-repeat: no-repeat;
    background-position: 100% 0px;
    padding-right: 24px;
    border-radius: 10px;
    min-width: 80px;
}

  .zg-ul-select.active > li{
    padding-right: 20px;
  }

  .main .nav-tabs.zg-ul-select{
    background-color: #fff;
    border-radius: 10px;
    margin-left: 10px !important;
  }

  .zg-ul-select a:hover{
    border: none;
    background-color: transparent !important;
    color: #E57200;
  }

  .nav-tabs.dropdown_tabs>li>a{
    border-radius: 10px;
    border: none;
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


.IotTabClass{
  padding-top: 3em;
}

.cf .nav-tabs.IotTab{
  position: static !important;
  margin-top: 0 !important;
}

.IOT .IotTabClass {
    padding-top: 20px !important;
}

.tableColRight{
  padding-left: 0 !important;
}
.IOT .resize_charts{
  padding-left: 20px;
}
@media (max-width: 979px){
  .cf .nav-tabs.IotTab{
    margin-top: 0 !important;
  }
  .IOT .tab-pane{
    padding: 0 !important;
  }
  .IOT #big_stats{
    display: inline !important;
  }
  .IOT_BOX .widget-header{
    display: none;
  }
 }

@media (max-width: 768px){
  #myQuickTab.IotTab {
    padding-left: 0 !important;
  }
  .MOST_POP_FROM_ALL .ARRIS_CDR_API_GRAPH_RUCKUS .tab-content{
  display: block !important;
     display: block !important;
     display: block !important;
}

  .header-on{
    width: 50%;
  }

  .zg-ul-select.myQuickTab2 li.active,
  .zg-ul-select.IotTab li.active,
  .zg-ul-select.myQuickTab3 li.active{
    display: block;
    text-align: center;
  }
  .zg-ul-select.myQuickTab2.active li,
  .zg-ul-select.IotTab.active li,
  .zg-ul-select.myQuickTab3.active li{
    text-align: center;
    padding-right: 0;
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



.cf .nav-tabs:not(#myQuickTab){
	margin-top: 60px !important;
}

#myQuickTab{
  position: absolute;
    bottom: 0px;
    left: 0px;
    top: 90%;
    padding-right: 20px;
    box-sizing: border-box;
    padding-left: 20px !important;

    z-index: 777;
    margin: auto;
    width: 135px !important;
    right: 0px;
}

#myQuickTab.myQuickTab3, #myQuickTab.myQuickTab2 , #myQuickTab.IotTab{
  width: 100% !important;
  top: 15px !important;
  margin-left: 0 !important;
}


#myQuickTab.IotTab{
 top: -30px !important;
}

.quick3 #big_stats, .quick2 #big_stats{
  margin-top: 0;
}

.quick2 .main_counter_area, .quick3 .main_counter_area{
  margin-top: 25px;
}

#myQuickTab.active{
   height: 140px;
}
}

.resize_charts .highcharts-data-table:last-of-type::before{
    color:#333;
    display: none;
}
.resize_charts .highcharts-data-table{
  overflow: auto;
}

.highcharts-container svg{
  font-family: 'Montserrat-Regular' !important;
}
.highcharts-data-table {
    background: #fff;
}
svg .highcharts-button tspan{
  fill: #E57200 !important;
  font-family: 'Montserrat-Regular';
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


(function (root, ns, factory) {
    "use strict";

    if (typeof (module) !== 'undefined' && module.exports) { // CommonJS
        module.exports = factory(ns, root);
    } else if (typeof (define) === 'function' && define.amd) { // AMD
        define("detect-zoom", function () {
            return factory(ns, root);
        });
    } else {
        root[ns] = factory(ns, root);
    }

}(window, 'detectZoom', function () {

    /**
     * Use devicePixelRatio if supported by the browser
     * @return {Number}
     * @private
     */
    var devicePixelRatio = function () {
        return window.devicePixelRatio || 1;
    };

    /**
     * Fallback function to set default values
     * @return {Object}
     * @private
     */
    var fallback = function () {
        return {
            zoom: 1,
            devicePxPerCssPx: 1
        };
    };
    /**
     * IE 8 and 9: no trick needed!
     * TODO: Test on IE10 and Windows 8 RT
     * @return {Object}
     * @private
     **/
    var ie8 = function () {
        var zoom = Math.round((screen.deviceXDPI / screen.logicalXDPI) * 100) / 100;
        return {
            zoom: zoom,
            devicePxPerCssPx: zoom * devicePixelRatio()
        };
    };

    /**
     * For IE10 we need to change our technique again...
     * thanks https://github.com/stefanvanburen
     * @return {Object}
     * @private
     */
    var ie10 = function () {
        var zoom = Math.round((document.documentElement.offsetHeight / window.innerHeight) * 100) / 100;
        return {
            zoom: zoom,
            devicePxPerCssPx: zoom * devicePixelRatio()
        };
    };

  /**
  * For chrome
  *
  */
    var chrome = function()
    {
      var zoom = Math.round(((window.outerWidth) / window.innerWidth)*100) / 100;
        return {
            zoom: zoom,
            devicePxPerCssPx: zoom * devicePixelRatio()
        };
    }

  /**
  * For safari (same as chrome)
  *
  */
    var safari= function()
    {
      var zoom = Math.round(((document.documentElement.clientWidth) / window.innerWidth)*100) / 100;
        return {
            zoom: zoom,
            devicePxPerCssPx: zoom * devicePixelRatio()
        };
    }


    /**
     * Mobile WebKit
     * the trick: window.innerWIdth is in CSS pixels, while
     * screen.width and screen.height are in system pixels.
     * And there are no scrollbars to mess up the measurement.
     * @return {Object}
     * @private
     */
    var webkitMobile = function () {
        var deviceWidth = (Math.abs(window.orientation) == 90) ? screen.height : screen.width;
        var zoom = deviceWidth / window.innerWidth;
        return {
            zoom: zoom,
            devicePxPerCssPx: zoom * devicePixelRatio()
        };
    };

    /**
     * Desktop Webkit
     * the trick: an element's clientHeight is in CSS pixels, while you can
     * set its line-height in system pixels using font-size and
     * -webkit-text-size-adjust:none.
     * device-pixel-ratio: http://www.webkit.org/blog/55/high-dpi-web-sites/
     *
     * Previous trick (used before http://trac.webkit.org/changeset/100847):
     * documentElement.scrollWidth is in CSS pixels, while
     * document.width was in system pixels. Note that this is the
     * layout width of the document, which is slightly different from viewport
     * because document width does not include scrollbars and might be wider
     * due to big elements.
     * @return {Object}
     * @private
     */
    var webkit = function () {
        var important = function (str) {
            return str.replace(/;/g, " !important;");
        };

        var div = document.createElement('div');
        div.innerHTML = "1<br>2<br>3<br>4<br>5<br>6<br>7<br>8<br>9<br>0";
        div.setAttribute('style', important('font: 100px/1em sans-serif; -webkit-text-size-adjust: none; text-size-adjust: none; height: auto; width: 1em; padding: 0; overflow: visible;'));

        // The container exists so that the div will be laid out in its own flow
        // while not impacting the layout, viewport size, or display of the
        // webpage as a whole.
        // Add !important and relevant CSS rule resets
        // so that other rules cannot affect the results.
        var container = document.createElement('div');
        container.setAttribute('style', important('width:0; height:0; overflow:hidden; visibility:hidden; position: absolute;'));
        container.appendChild(div);

        document.body.appendChild(container);
        var zoom = 1000 / div.clientHeight;
        zoom = Math.round(zoom * 100) / 100;
        document.body.removeChild(container);

        return{
            zoom: zoom,
            devicePxPerCssPx: zoom * devicePixelRatio()
        };
    };

    /**
     * no real trick; device-pixel-ratio is the ratio of device dpi / css dpi.
     * (Note that this is a different interpretation than Webkit's device
     * pixel ratio, which is the ratio device dpi / system dpi).
     *
     * Also, for Mozilla, there is no difference between the zoom factor and the device ratio.
     *
     * @return {Object}
     * @private
     */
    var firefox4 = function () {
        var zoom = mediaQueryBinarySearch('min--moz-device-pixel-ratio', '', 0, 10, 20, 0.0001);
        zoom = Math.round(zoom * 100) / 100;
        return {
            zoom: zoom,
            devicePxPerCssPx: zoom
        };
    };

    /**
     * Firefox 18.x
     * Mozilla added support for devicePixelRatio to Firefox 18,
     * but it is affected by the zoom level, so, like in older
     * Firefox we can't tell if we are in zoom mode or in a device
     * with a different pixel ratio
     * @return {Object}
     * @private
     */
    var firefox18 = function () {
        return {
            zoom: firefox4().zoom,
            devicePxPerCssPx: devicePixelRatio()
        };
    };

    /**
     * works starting Opera 11.11
     * the trick: outerWidth is the viewport width including scrollbars in
     * system px, while innerWidth is the viewport width including scrollbars
     * in CSS px
     * @return {Object}
     * @private
     */
    var opera11 = function () {
        var zoom = window.top.outerWidth / window.top.innerWidth;
        zoom = Math.round(zoom * 100) / 100;
        return {
            zoom: zoom,
            devicePxPerCssPx: zoom * devicePixelRatio()
        };
    };

    /**
     * Use a binary search through media queries to find zoom level in Firefox
     * @param property
     * @param unit
     * @param a
     * @param b
     * @param maxIter
     * @param epsilon
     * @return {Number}
     */
    var mediaQueryBinarySearch = function (property, unit, a, b, maxIter, epsilon) {
        var matchMedia;
        var head, style, div;
        if (window.matchMedia) {
            matchMedia = window.matchMedia;
        } else {
            head = document.getElementsByTagName('head')[0];
            style = document.createElement('style');
            head.appendChild(style);

            div = document.createElement('div');
            div.className = 'mediaQueryBinarySearch';
            div.style.display = 'none';
            document.body.appendChild(div);

            matchMedia = function (query) {
                style.sheet.insertRule('@media ' + query + '{.mediaQueryBinarySearch ' + '{text-decoration: underline} }', 0);
                var matched = getComputedStyle(div, null).textDecoration == 'underline';
                style.sheet.deleteRule(0);
                return {matches: matched};
            };
        }
        var ratio = binarySearch(a, b, maxIter);
        if (div) {
            head.removeChild(style);
            document.body.removeChild(div);
        }
        return ratio;

        function binarySearch(a, b, maxIter) {
            var mid = (a + b) / 2;
            if (maxIter <= 0 || b - a < epsilon) {
                return mid;
            }
            var query = "(" + property + ":" + mid + unit + ")";
            if (matchMedia(query).matches) {
                return binarySearch(mid, b, maxIter - 1);
            } else {
                return binarySearch(a, mid, maxIter - 1);
            }
        }
    };

    /**
     * Generate detection function
     * @private
     */
    var detectFunction = (function () {
        var func = fallback;
        //IE8+
        if (!isNaN(screen.logicalXDPI) && !isNaN(screen.systemXDPI)) {
            func = ie8;
        }
        // IE10+ / Touch
        else if (window.navigator.msMaxTouchPoints) {
            func = ie10;
        }
    //chrome
    else if(!!window.chrome && !(!!window.opera || navigator.userAgent.indexOf(' Opera') >= 0)){
      func = chrome;
    }
    //safari
    else if(Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0){
      func = safari;
    }
        //Mobile Webkit
        else if ('orientation' in window && 'webkitRequestAnimationFrame' in window) {
            func = webkitMobile;
        }
        //WebKit
        else if ('webkitRequestAnimationFrame' in window) {
            func = webkit;
        }
        //Opera
        else if (navigator.userAgent.indexOf('Opera') >= 0) {
            func = opera11;
        }
        //Last one is Firefox
        //FF 18.x
        else if (window.devicePixelRatio) {
            func = firefox18;
        }
        //FF 4.0 - 17.x
        else if (firefox4().zoom > 0.001) {
            func = firefox4;
        }

        return func;
    }());


    return ({

        /**
         * Ratios.zoom shorthand
         * @return {Number} Zoom level
         */
        zoom: function () {
            return detectFunction().zoom;
        },

        /**
         * Ratios.devicePxPerCssPx shorthand
         * @return {Number} devicePxPerCssPx level
         */
        device: function () {
            return detectFunction().devicePxPerCssPx;
        }
    });
}));

(function($,sr){
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  }
  // smartresize
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');



(function($,sr){
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  }
  // smartresize
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

var bzoom;

$(document).ready(function() {

  bzoom = detectZoom.zoom();

});
$(window).smartresize(function(){

  if(bzoom!=detectZoom.zoom()){
    $('.zoom-msg').show();
  }
});

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
<script type="text/javascript" src="js/jquery-ui.min.js"></script>