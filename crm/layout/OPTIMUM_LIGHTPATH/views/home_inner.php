<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<style type="text/css">
  .nav-tabs a {
    color: #fff;
  }
  .WIFI_INFORMATION_BOX .widget-header {
    display: none;
  }

  /*overview css*/
  .THREE_GRAPH_BOX_ALT>.widget-header {
    display: none;
  }

  #reloadOverview {
    z-index: 1 !important;
    right: 10px !important;
  }

  #canVasDiv {
    z-index: 88;
  }

  .TreeStat .widget .resize_charts {
    border: 1px solid #ffffff;
    margin-right: 0px !important;
    margin-left: 0px !important;
  }

  #myTabContentDASH .TreeStat .widget-content {
    background: #ffffff;
    border-radius: 0px;
    padding-top: 30px;
  }

  .TreeStat .resize_charts {
    margin-left: 0px !important;
  }

  .cf .overviewDiv ul {
    background-color: #fff;
    position: static;
  }

  .treeDesc .table {
    margin-bottom: 0px;
  }

  .internet span {
    text-transform: uppercase;
  }

  .headlabel {
    text-align: left;
    padding-left: 3.2em;
    margin-top: 10px;
  }

  .headName {
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

  .treeDiv .internet {
    padding-left: 3.5em;
    height: 80px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
  }

  .treeDiv .internet img {
    height: 100%;
    display: inline-block;
    cursor: pointer;
  }

  .treeDiv .internet span {
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

  #canVasDiv .treeUl h3 {
    margin-bottom: 0px;
  }

  .treeUl li label.switch,
  .treeUl li label.ap,
  .treeUl li label.vedge,
  .treeUl li label.firewall {
    width: 150px;
    cursor: pointer;
    background-repeat: no-repeat;
    height: 30px;
    background-position: 0% 0%;
    background-size: 100% auto;
  }

  .treeUl li label.switch,
  .tree.treeUl>li:nth-child(2) {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwitchOpen.png);
  }

  .treeUl li input:checked~label.switch {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwithcClosed.png);
  }

  .treeUl li label.ap,
  .tree.treeUl>li:nth-child(3) {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/apOpen.png);
  }

  .treeUl li input:checked~label.ap {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/apClosed.png);
  }

  .treeUl li label.vedge,
  .tree.treeUl>li:nth-child(1) {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/RouterOpen.png);
  }

  .treeUl li input:checked~label.vedge {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/RouterClosed.png);
  }

  .treeUl li label.firewall,
  .tree.treeUl>li:nth-child(1) {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/firewallOpen.png);
  }

  .treeUl li input:checked~label.firewall {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/firewallClosed.png);
  }

  .tree.treeUl>li:nth-child(1),
  .tree.treeUl>li:nth-child(2),
  .tree.treeUl>li:nth-child(3) {
    background-size: 0;
  }

  .treeUl li .switchChild,
  .treeUl li .apChild,
  .treeUl li .vedgeChild,
  .treeUl li .firewallChild {
    background-repeat: no-repeat;
    background-size: contain;
    padding-left: 2.5em;
    cursor: pointer;
    text-align: left;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
  }

  .treeUl li .switchChild.Online {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwitchOn.png);
  }

  .treeUl li .switchChild.Offline {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/SwitchOff.png);
  }

  .treeUl li .apChild.Online {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/apOn.png);
  }

  .treeUl li .apChild.Offline {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/apOff.png);
  }

  .treeUl li .vedgeChild.Online {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/RouterOn.png);
  }

  .treeUl li .vedgeChild.Offline {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/RouterOff.png);
  }

  .treeUl li .firewallChild.Online {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/firewallOn.png);
  }

  .treeUl li .firewallChild.Offline {
    background-image: url(layout/<?php echo $camp_layout; ?>/img/firewallOff.png);
  }

  .treeUl li input[type="checkbox"]+label::before {
    display: none;
  }

  .detailsTree {
    display: inline-block;
    padding: 20px;
    text-align: left;
    overflow: auto;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    width: 60%;
    height: 500px;
    background: #fff;
    -webkit-transition: width 0.2s ease;
    -o-transition: width 0.2s ease;
    transition: width 0.2s ease;
  }

  .treeDesc table td {
    padding-left: 0px;
  }

  .treeDesc table td b {
    font-weight: normal;
  }

  .treeDesc table th {
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
  }

  .Treeloader {
    width: 100%;
    top: 0px;
    position: relative;
    padding-top: 30px;
  }

  .treeDivDetails table {
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

  .treeDiv.close .treeDivInner {
    border: none;
  }

  @media (max-width: 979px) {
    .TreeStat .widget {
      margin-right: -20px !important;
    }
  }

  @media (max-width: 767px) {

    .headlabel {
      padding-left: 1.1em;
    }

    .headName {
      padding-left: 0.5em;
    }

    span.arrow {
      display: inline-block;
    }

    .treeDiv {
      width: 100%;
    }

    .treeDivInner {
      margin-right: 0px;
    }

    .detailsTree {
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
  .tab-pane #big_stats .stat {
    width: 100%;
    display: block;
  }

  .resize_charts .ajax-loader {
    position: absolute;
    top: 20%;
    left: 0;
    right: 0px;
    max-width: 200px;
    margin-left: auto;
    margin-right: auto;
  }


  .zoom-msg {
    width: 70%;
    margin: auto;
    padding-top: 10px;
    text-align: center;
  }

  .bottom-foot {
    width: 100%;
    height: 150px;
    position: absolute;
    background: #000;
    /* top: 100%; */
    bottom: 50px;
  }

  .trans-wid {
    position: static !important;
  }

  .nav-tabs {
    border-bottom: none !important;
  }

  .trans-wid-con {
    background: transparent !important;
    border: 1px solid transparent !important;
  }

  .tree_graph {
    padding-top: 40px;
    padding-bottom: 40px;
    min-width: 100%;
    padding-right: 10px;
  }

  @media (max-width: 480px) {

    .tree_graph {
      min-width: 100%;
    }

    .resize_charts {
      margin-left: -5px !important;
    }

    .cf_min {
      margin-top: -40px;
    }
  }

  .trans-wid-con #big_stats {
    position: relative;
    padding-bottom: 60px;
  }

  #myQuickTab {
    position: absolute;
    bottom: 0px;
    left: 0px;
    top: 100%;
    z-index: 44;
    width: auto;
  }

  .intro_page {
    /*  height: 480px !important;
    margin-top: -35px;
    background-size: cover !important;
    background-position: center !important;*/
  }

  .home-white-top {
    width: 100%;
    position: absolute;
    height: 300px;
    left: 0px;
    background: #fff;
    top: 0px;
    z-index: -2;
  }

  .home-white-bottom {
    width: 100%;
    position: absolute;
    height: 100px;
    left: 0px;
    background: #fff;
    bottom: 0px;
    z-index: -2;
  }

  html body {
    font-size: 18px;
    font-weight: 400;
    padding-bottom: 58px !important;
    background: #000000 !important;
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

  .cf_min {
    position: absolute;
    right: 0px;
    width: 50%;
  }

  .cf_min .nav-tabs {
    max-width: 200px;

  }

  .cf_min ul {
    position: relative !important;
    display: inline-block !important;
    ;
  }

  /* .ssid_load{
  display: inline-block;
    float: left;
    position: relative ;
}
.ssid_load ul {
    position: absolute !important;
    } */

  .highcharts-container svg .highcharts-button tspan {
    fill: #000000 !important;
  }

  /*==========================================================
                           counter section style
            ============================================================*/

  .main_counter_area {
    background-size: cover;
    overflow: hidden;
  }

  .main_counter_area .main_counter_content .single_counter {
    background: #e0ff00;
    color: #000000;
  }

  .main_counter_area .main_counter_content .single_counter .highlight {
    color: #000000 !important;
  }

  .main_counter_area .main_counter_content .single_counter i {
    font-size: 36px;
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

  .col-md-3:nth-child(1) {
    padding-left: 0px;
  }

  .col-md-3:nth-child(4) {
    padding-right: 0px;
  }

  /*home styles*/

  .top-header-home {
    display: none;
  }

  .intro_page {
    z-index: -4;
  }

  #myTabDash {
    /*background: #000;
    width: 80% !important;
    margin: auto;
    margin-top: -45px;
    margin-left: auto !important;*/
    /*  padding-top: 35px !important;
    padding-bottom: 35px !important;*/
    z-index: 999999;
  }

  body #myTabDash>.active>a,
  body #myTabDash>.active>a:hover {
    background-color: #000000;
    border: none;
  }

  #myTabDash>li>a {
    background: none !important;
    border: none !important;
    border-right: 1px solid white !important;
  }

  #myTabDash>li>a {
    padding-top: 3px !important;
    padding-bottom: 3px !important;
    color: #fff !important;
    border-radius: 0px 0px 0 0 !important;
  }

  #myTabDash>li:last-child>a {
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

  .contact {
    font-size: 16px;
    font-family: Rregular;
    color: #fff;
    margin-right: 50px;
  }

  .call span:not(.glyph),
  .footer-live-chat-link span:not(.glyph) {
    font-family: Rmedium;
    font-size: 20px;
    color: #fff;
  }

  .number {
    font-family: Rmedium;
    font-size: 20px;
  }

  .footer-live-chat-link {
    display: inline-block;
    margin-left: 50px;
  }

  .call a {
    font-family: Rmedium;
    font-size: 20px;
  }

  .footer-inner a:hover {
    text-decoration: none !important;
    color: #fff;
  }

  .main-inner {
    position: relative;
    padding-bottom: 150px;
  }

  .main {
    padding-bottom: 0 !important;
  }


  ul.zg-ul-select {

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

  #myTabContentDASH .widget-header {
    position: absolute;
    z-index: 88;
    top: 20px;
    background: #000000 !important;
    border: 1px solid #000000;
  }

  #myTabContentDASH .widget-content {
    background: #000;
    border: 1px solid #000000;
  }


  #myTabContentDASH .tree_graph .widget-header {
    background: #ececec !important;
    border: 1px solid #d6d6d6;
    position: static;
  }

  #myTabContentDASH .tree_graph .widget-content {
    background: #FFF;
    border: 0;
  }

  .resize_charts {
    margin-top: 40px;
    background: #fff;
  }

  .icon-list-alt {
    display: none !important;

  }

  .widget-header h2 {

    text-shadow: none !important;
    color: #fff !important
  }

  #big_stats .stat {
    border-left: 1px solid #000 !important;
  }

  .cf ul {
    position: absolute;
    z-index: 4;
    right: 0;
    background-color: #000;
    text-align: right;
    /*margin-right: 9px;*/
  }

  .cf .nav-tabs>.active>a,
  .cf .nav-tabs>.active>a:hover {
    color: #ffffff;
    background-color: #000000;
    border: 1px solid #000;
  }

  .cf .nav-tabs>li>a:hover {
    border-color: #000000 #000000 #000000;
  }

  .cf .nav>li>a:hover {
    background-color: #000000;
    ;
    color: #fff;
  }

  .cf .nav-tabs>li,
  .cf .nav-pills>li {
    float: none;
  }

  .alert {
    position: absolute;
    top: 60px;
    width: 100%;
  }

  .cf .nav-tabs {
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

  .zg-ul-select:not(.active) li.active {
    background-image: url(layout/OPTIMUM/img/down.png);
    background-size: 20px;
    background-repeat: no-repeat;
    background-position: 100% 13px;
    padding-right: 20px;
  }


  .zg-ul-select.active>li:nth-child(1) {
    background-image: url(layout/OPTIMUM/img/up.png);
    background-size: 20px;
    background-repeat: no-repeat;
    background-position: 100% 13px;
  }

  .zg-ul-select.active>li {
    padding-right: 20px;
  }

  .mobile-menu {
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

  .mobile-menu span.clicked {
    background: #fff;
  }

  .col-md-3 {
    display: block;
  }


  @media (max-width: 768px) {

    .header-on {
      width: 50%;
    }

    .col-md-3 {
      width: 100% !important;
      padding-right: 0px !important;
      padding-left: 10px !important;
      display: none;
      float: none !important;
      max-width: 400px;
    }

    .col-md-3:nth-child(1) {
      display: block;
    }

    .mobile-menu {
      display: block;
    }



    .cf .nav-tabs:not(#myQuickTab) {
      margin-top: 60px !important;
    }

    #myQuickTab {
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

    #myQuickTab.active {
      height: 140px;
    }
  }

  .resize_charts .highcharts-data-table:last-of-type::before {
    color: #333;
  }

  .highcharts-data-table {
    background: #fff;
  }

  #myQuickTab li:not(.active) a {
    color: #8a8c8e;
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


  (function(root, ns, factory) {
    "use strict";

    if (typeof(module) !== 'undefined' && module.exports) { // CommonJS
      module.exports = factory(ns, root);
    } else if (typeof(define) === 'function' && define.amd) { // AMD
      define("detect-zoom", function() {
        return factory(ns, root);
      });
    } else {
      root[ns] = factory(ns, root);
    }

  }(window, 'detectZoom', function() {

    /**
     * Use devicePixelRatio if supported by the browser
     * @return {Number}
     * @private
     */
    var devicePixelRatio = function() {
      return window.devicePixelRatio || 1;
    };

    /**
     * Fallback function to set default values
     * @return {Object}
     * @private
     */
    var fallback = function() {
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
    var ie8 = function() {
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
    var ie10 = function() {
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
    var chrome = function() {
      var zoom = Math.round(((window.outerWidth) / window.innerWidth) * 100) / 100;
      return {
        zoom: zoom,
        devicePxPerCssPx: zoom * devicePixelRatio()
      };
    }

    /**
     * For safari (same as chrome)
     *
     */
    var safari = function() {
      var zoom = Math.round(((document.documentElement.clientWidth) / window.innerWidth) * 100) / 100;
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
    var webkitMobile = function() {
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
    var webkit = function() {
      var important = function(str) {
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

      return {
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
    var firefox4 = function() {
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
    var firefox18 = function() {
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
    var opera11 = function() {
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
    var mediaQueryBinarySearch = function(property, unit, a, b, maxIter, epsilon) {
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

        matchMedia = function(query) {
          style.sheet.insertRule('@media ' + query + '{.mediaQueryBinarySearch ' + '{text-decoration: underline} }', 0);
          var matched = getComputedStyle(div, null).textDecoration == 'underline';
          style.sheet.deleteRule(0);
          return {
            matches: matched
          };
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
    var detectFunction = (function() {
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
      else if (!!window.chrome && !(!!window.opera || navigator.userAgent.indexOf(' Opera') >= 0)) {
        func = chrome;
      }
      //safari
      else if (Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0) {
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
      zoom: function() {
        return detectFunction().zoom;
      },

      /**
       * Ratios.devicePxPerCssPx shorthand
       * @return {Number} devicePxPerCssPx level
       */
      device: function() {
        return detectFunction().devicePxPerCssPx;
      }
    });
  }));

  (function($, sr) {
    var debounce = function(func, threshold, execAsap) {
      var timeout;

      return function debounced() {
        var obj = this,
          args = arguments;

        function delayed() {
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
    jQuery.fn[sr] = function(fn) {
      return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
    };

  })(jQuery, 'smartresize');



  (function($, sr) {
    var debounce = function(func, threshold, execAsap) {
      var timeout;

      return function debounced() {
        var obj = this,
          args = arguments;

        function delayed() {
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
    jQuery.fn[sr] = function(fn) {
      return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
    };

  })(jQuery, 'smartresize');

  var bzoom;

  $(document).ready(function() {

    bzoom = detectZoom.zoom();

  });
  $(window).smartresize(function() {

    if (bzoom != detectZoom.zoom()) {
      $('.zoom-msg').show();
    }
  });

  $.fn.ulSelect = function() {
    var ul = $(this);

    if (!ul.hasClass('zg-ul-select')) {
      ul.addClass('zg-ul-select');
    }

    $(this).on('click', 'li', function(event) {

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
      } else {
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
    $(document).on('click', function(event) {
      if ($('ul.zg-ul-select').length) {
        if (!$('ul.zg-ul-select').has(event.target).length == 0) {
          return;
        } else {
          $('ul.zg-ul-select').removeClass('active');
          $('#selected--zg-ul-select').removeClass('active').text('');
          $('#ul-arrow').remove();
        }
      }
    });
  }




  function set_btn(a, this_val) {

    $(this_val).parent().parent().find('.col-md-3').hide();
    $(this_val).parent().find('span').removeClass('clicked');
    $(this_val).addClass('clicked');
    $(this_val).parent().parent().find('.col-md-3:nth-child(' + (a + 1) + ')').show();
  }
</script>

<script type="text/javascript">
  $(document).ready(function() {

    /*  $('#create_theme').addClass('in').addClass('active');*/


    $('#myTabDash li').removeClass('active');
    $('#myTabDash [data-toggle="tab"]').attr('data-toggle', 'tab1');



    $('#myTabDash [data-toggle="tab1"]').each(function(index, el) {

      var tabDiv = $(this).attr('href').replace('#', '');
      $(this).attr('href', 'javascript:void(0)');
      $(this).attr('data-div', tabDiv);
    });

    $('[data-toggle="tab1"]').click(function(event) {

      $('[data-toggle="tab1"]').removeClass('clicked');
      $(this).addClass('clicked');
      var tabDiv = $(this).attr('data-div');
      <?php foreach ($section_array as $jsKey => $jsValue) {
        echo "$('#dash_section_tab_" . $jsKey . "').removeClass('active');";
      } ?>



      /*var elmnt = document.getElementsByClassName('main-inner')[0];
      elmnt.scrollIntoView();*/

      $('#' + tabDiv).addClass('in');
      $('#' + tabDiv).addClass('active');

      $('html, body').animate({
        scrollTop: $(".main-inner").offset().top - 100
      }, 200, function() {

      });




    });
  });
</script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>