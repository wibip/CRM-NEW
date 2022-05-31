<?php

    header("Content-type: text/css; charset: UTF-8"); //important

       
    $user_type = $_GET["user_type"];
    $distributor_code = $_GET["distributor_code"];
    $system_package = $_GET["system_package"];

 
    //require_once('../../../db/config.php');

    require_once '../../../classes/dbClass.php';
    $db = new db_functions();

 
    if($user_type == 'MNO' || $user_type == 'SUPPORT'){

        $system_package_new = $system_package;
 
    }elseif($user_type == 'MVNO'){
        $q = "SELECT `mno_id` FROM `exp_mno_distributor` WHERE `distributor_code` = '$distributor_code';";
        $result=$db->select1DB($q);

        //$result = mysql_fetch_array($query_results);

        $mno_id = $result['mno_id'];


        $q2 = "SELECT `system_package` FROM `exp_mno` WHERE `mno_id` = '$mno_id';";
        $result2=$db->select1DB($q2);

        //$result2 = mysql_fetch_array($query_results2);

        $system_package_new = $result2['system_package'];
    }elseif($user_type == 'MVNO_ADMIN'){
        $q = "SELECT `mno_id` FROM `mno_distributor_parent` WHERE `parent_id` = '$distributor_code';";
        $result=$db->select1DB($q);

        //$result = mysql_fetch_array($query_results);

        $mno_id = $result['mno_id'];


        $q2 = "SELECT `system_package` FROM `exp_mno` WHERE `mno_id` = '$mno_id';";
        $result2=$db->select1DB($q2);

        //$result2 = mysql_fetch_array($query_results2);

        $system_package_new = $result2['system_package'];
    }


    $q = "SELECT * FROM `admin_product_controls_custom` WHERE `product_id` = '$system_package_new'";
    $result=$db->select1DB($q);

    // $row_count = mysql_num_rows($query_results);

    if($result) {

        //$result = mysql_fetch_array($query_results);

        $custom_data = json_decode($result['settings'],true); 

        $main_color = $custom_data['branding']['PRIMARY_COLOR']['options'];
        $secondary_color = $custom_data['branding']['SECONDARY_COLOR']['options'];
        $logo_image_url = $custom_data['branding']['LOGO_IMAGE_URL']['options'];

        list($r, $g, $b) = sscanf($main_color, "#%02x%02x%02x");

        if (($r*0.299 + $g*0.587 + $b*0.114) > 186){
            $font_color = "#000";
        }else{
            $font_color = "#fff";
        }

        list($r2, $g2, $b2) = sscanf($secondary_color, "#%02x%02x%02x");

        if (($r2*0.299 + $g2*0.587 + $b2*0.114) > 186){
            $font_color2 = "#000";
        }else{
            $font_color2 = "#fff";
        }

    }else{
      
        $main_color = "#23002a";//sweetbay-#23002a
        $secondary_color = "#b21c24";
        $logo_image_url = '../img/sample-logo.png';
        $font_color = '#fff';
        $font_color2 = '#fff';
                   
    }

        





    
   
    $navbarColor = "#fff";
    $navbarTopColor  = "#f2f2f2";
    $selectColor = $main_color;
    $btnPrimary_color = $main_color;
    $btnPrimary_color_hover = $main_color;    
    $btnInfo_color = $secondary_color;
    $btnInfo_color_hover = $secondary_color;
    $linkColor = "#333333";
    $linkColor_hover = "#333333";

    

?>


@font-face {
  font-family: 'glyphs';
  src: url('../font/glyphs.woff');
  font-weight: normal;
  font-style: normal;
}

@font-face {
  font-family: 'Regular';
  src: url('../font/Regular.woff2');
  font-weight: normal;
  font-style: normal;
}


/* start location steps styles */

.step-list-block,
.clearfix {
    display: inline-table;
    width: 100%;
    margin-top: 20px;
}

.steps,
.tablist,
[role="tablist"] {
    list-style: none;
    margin: 0;
    padding: 0;
    display: table;
    table-layout: fixed;
    width: 100%;
    color: #333333;
    height: 4rem;
}

.steps>.step,
[role="tablist"]>[role="tab"] {
    position: relative;
    display: table-cell;
    text-align: center;
    font-size: 0.875rem;
    color: #333333;
    font-weight: 600;
}

.steps>.step:before,
[role="tablist"]>[role="tab"]:before {
    content: attr(data-step);
    display: block;
    margin: 0 auto;
    background: #ffffff;
    border: 1px solid #333333;
    color: #333333;
    width: 2rem;
    height: 2rem;
    text-align: center;
    margin-bottom: 10px;
    line-height: 1.9rem;
    border-radius: 100%;
    position: relative;
    z-index: 1;
    font-weight: 600;
    font-size: 1rem;
}

.steps>.step:after,
[role="tablist"]>[role="tab"]:after {
    content: '';
    position: absolute;
    display: block;
    background: #333333;
    width: 100%;
    height: 0.125rem;
    top: 1rem;
    left: 50%;
}

.steps>.step:last-child:after,
[role="tablist"]>[role="tab"]:last-child:after {
    display: none;
}

.steps>.step.is-complete,
[role="tablist"]>.done[role="tab"] {
    color: <?php echo $btnInfo_color; ?>;
}

.steps>.step.is-complete:before,
[role="tablist"]>.done[role="tab"]:before {
    color: #ffffff;
    background: <?php echo $btnInfo_color; ?>;
    border: 2px solid <?php echo $btnInfo_color; ?>;
}

.steps>.step.is-complete:after,
[role="tablist"]>.done[role="tab"]:after {
    background: <?php echo $btnInfo_color; ?>;
}

.steps>.step.is-active,
[role="tablist"]>.current[role="tab"] {
    color: <?php echo $btnInfo_color; ?>;
}

.steps>.step.is-active:before,
[role="tablist"]>.current[role="tab"]:before {
    color: <?php echo $btnInfo_color; ?>;
    border: 2px solid <?php echo $btnInfo_color; ?>;
}

.content.clearfix h3.title:not(.current) {
    display: none;
}

.content.clearfix select,
.content.clearfix input {
    width: 100%;
    box-sizing: border-box;
    height: 37px;
}

.content.clearfix,
.actions.clearfix {
    width: 80%;
    display: block;
    margin: auto;
    margin-top: 25px;
}

@media(max-width:767px) {
    .steps .step span {
        /* transform: rotate(400deg); */
        display: block;
        margin-top: 15px;
        font-size: 10px;
    }
}

@media (max-width:280px) {
    .steps .step span {
        font-size: 8px;
    }
    .steps>.step:before {
        width: 1.6rem;
        height: 1.6rem;
        line-height: 1.4rem;
    }
    .steps>.step:after {
        top: 0.8rem;
    }
}


/* start grid */

.grid * {
    box-sizing: border-box;
}

.grid .col-xl-6,
.grid .col-lg-6,
.grid .col-md-6,
.grid .col-sm-12,
.grid .col-xl-6,
.grid .col-lg-5,
.grid .col-sm-5,
.grid .col-sm-6,
.grid .col-md-5,
.grid .col-lg-1,
.grid .col-md-1,
.grid .col-sm-1 {
    float: left;
    position: relative;
    min-height: 1px;
    /* padding-left: 15px;
padding-right: 15px; */
}

@media (min-width: 200px) {
    .grid .col-sm-1 {
        width: 8.33333333%;
    }
    .grid .col-sm-6 {
        width: 50%;
    }
    .grid .col-sm-5 {
        width: 41.66666667%;
    }
    .grid .col-sm-12 {
        width: 100%;
    }
}

@media (min-width: 992px) {
    .grid .col-md-5 {
        width: 41.66666667%;
    }
    .grid .col-md-6 {
        width: 50%;
    }
    .grid .col-md-1 {
        width: 8.33333333%;
    }
}

@media (min-width: 1200px) {
    .grid .col-lg-6 {
        width: 50%;
    }
    .grid .col-lg-1 {
        width: 8.33333333%;
    }
    .grid .col-lg-5 {
        width: 41.66666667%;
    }
}

.grid {
    border: 1px solid #dddddd;
    border-radius: 5px;
    display: table;
    padding: 10px;
    width: 100%;
    box-sizing: border-box;
}

.grid .item-name {
    line-height: 25px;
}


/* end grid */

#parent_details .create_r{
    margin-bottom: 134px !important;
}
#network_control .toggle.btn.btn-xs{
    height: 10px !important;
    margin-top: 25px !important;
    min-height: 22px;
}
/* end location steps styles */

/* location edit parent */

#replace_user_lbl{
    float: none !important;
}
/* location edit parent */
.net_div_child {
    display: inline-block;
    min-width: 90px;
}

#myTabDash, #myTabContentDASH{
    margin-left: -10px !important;
    width: auto !important;
}
.net_div {
    display: inline-block;
}

.navbar .nav>li.dropdown>a{
        padding: 20px 10px 11px !important;
}


div.alert + .widget.widget-table, form#update_default_qos_table{
    margin-top: 40px;
}

input[type="checkbox"]:checked + label::before {
    background-position: 0 -358px;
}

input[type="checkbox"]:checked:focus + label::before {
    background-position: 0 -419px;
}

input[type="checkbox"]:focus + label::before {
    background-position: 0 -298px;
}

input[type="checkbox"] + label::before, input[type="radio"]:not(.hide_rad):not(.radio-black) + label::before {
    background-image: url(../img/form-fields-biz.png);
}

input[type="radio"].radio-black + label::before {
    background-image: url(../img/form-fields-biz-b.png);
    /*border: 2px solid #fff;
    border-radius: 20px;*/
}

input[type="checkbox"] + label::before {
    background-position: 0 -238px ;
}
input[type="checkbox"] + label::before{
    display: inline-block;
    width: 39px;
    height: 39px;
    margin: -6px 9px -6px -6px;
    margin-bottom: -15px;
    background-position: 0 -238px;
    background-repeat: no-repeat;
    content: " ";
    vertical-align: top;
}

input[type="checkbox"], input[type="radio"]:not(.hide_rad) {
    position: absolute;
    width: 28px;
    height: 28px;
    overflow: hidden;
    margin: -3px 0 0;
    padding: 0;
    outline: 0;
    opacity: 0;
    margin-top: 6px;
}

div.tablesaw-columntoggle-popup input[type="checkbox"]{
    position: static !important;
    width: 13px !important;
    height: 15px !important;
    overflow: hidden !important;
    margin: 0 0px 0 0 !important;
    padding: 0px !important;
    /* outline: initial !important; */
    opacity: 0 !important;
    display: inline-block;
}

div.tablesaw-columntoggle-popup input[type="checkbox"]+ label::before{
    display: inline-block;
    width: 24px !important;
    height: 24px !important;

    margin: -3px 4px -2px -15px !important;
    margin-bottom: -15px !important;
    background-position: 0 -112px;
    background-repeat: no-repeat;
    content: " ";
    vertical-align: top;
    background-size: 400px 400px;
}

div.tablesaw-columntoggle-popup input[type="checkbox"]:checked + label::before{
    background-position: 0 -169px;
}

.tablesaw-bar label {
    line-height: 10px !important;
}
.dataTables_wrapper .row {
    margin-left: 0px;
}
.dataTables_filter, .dataTables_length {
    display: none;
}

input[type="radio"]:checked:not(.hide_rad) + label::before{
    /*background-position: 0 -658px;*/
    background:none;
    content: "\f05d";    
    font-family: FontAwesome;
    position: relative;
    font-size: 35px;
    top: 9px;
    font-weight: 200;
    color: <?php echo $main_color; ?>;
    border: 0px;
}


input[type="radio"]:checked:focus:not(.hide_rad) + label::before{
    <!-- background-position: 0 -718px; -->
}
input[type="radio"]:focus:not(.hide_rad) + label::before{
  <!--   background-position: 0 -598px; -->
}

input[type="radio"]:not(.hide_rad) + label::before {
    display: inline-block;
    width: 32px;
    height: 32px;
    margin: -6px 9px -14px -6px;
    background-position: -6px -538px;
    background-repeat: no-repeat;
    content: " ";
    vertical-align: top;
}

.theme_response{
        margin-left: 190px;
    }

    #preview_btn{
  display: none !important;
}





td > a{
    min-width: 70px;
}

/*network_pr.php*/
meter {
    display: block !important;
    width: 300px;
}



.toggle1{
    width: 74px;
    height: 37px;
    display: inline-block;
    vertical-align: middle;
    position: relative;
    margin-left: 1%;
    background: #eeeeee;
    padding: 0px;
     -webkit-box-shadow: 1px 1px 1px #8e8e8e;
    box-shadow: 1px 1px 1px #8e8e8e;
}

.toggle1-l{
    width: 110px;
    height: 37px;
    display: inline-block;
    vertical-align: middle;
    position: relative;
    margin-left: 1%;
    background: #eeeeee;
    padding: 0px;
     -webkit-box-shadow: 1px 1px 1px #8e8e8e;
    box-shadow: 1px 1px 1px #8e8e8e;
}


.toggle1-on{
    color: white;
    line-height: 37px;
    display: inline-block;
    width: 50%;
    height: 37px;
    text-align: center;
    font-size: 14px !important;
    background: <?php echo $main_color; ?>;
    float: left;
}

.toggle1-on-dis{
    color: #555555;
    line-height: 37px;
    display: inline-block;
    width: 50%;
    height: 37px;
    text-align: center;
    font-size: 14px !important;
    background: #eeeeee;
    float: left;
}

.toggle1-off{
    display: inline-block;
    color: white;
    line-height: 37px;
    width: 50%;
    height: 37px;
    text-align: center;
    font-size: 14px !important;
    background: <?php echo $main_color; ?>;
   /*  margin-left: -1px; */
    clear: both;
}

.toggle1-off-dis{
    display: inline-block;
    color: #555555;
    line-height: 37px;
    width: 50%;
    height: 37px;
    text-align: center;
    font-size: 14px !important;
    background: rgb(238, 238, 238);
    /* margin-left: -1px; */
    clear: both;
}

.toggle1 input[type="checkbox"], .toggle1-l input[type="checkbox"]{
    position: absolute;
    width: 28px;
    height: 28px;
    overflow: hidden;
    margin: -3px 0 0;
    padding: 0;
    outline: 0;
    opacity: 0;
    margin-top: 6px;
}


div.tablesaw-columntoggle-popup input[type="checkbox"]{
    display: inline-block;
}

.widget, .widget-table{
    overflow: inherit !important;
}

.tablesaw-columntoggle-btnwrap.visible .tablesaw-columntoggle-popup{
    top: 40px !important;
}

.widget-header.home{
    background: none !important;
    border: none !important;
}

.widget-header h2 {
    font-size: 14px !important;
    margin-left: 10px !important;
}


.toggle1:hover{
    cursor: pointer;
}


.btn-warning {
    background-color: #54585a !important;
}

.btn-warning:hover{
    background-color: #54585a !important;
    /* box-shadow: 2px 2px 2px 0px rgba(0,0,0,0.75); */
}
.btn-danger {
    background-color: #54585a !important;
}

.btn-danger:hover{
    background-color: #54585a !important;
   /*  box-shadow: 2px 2px 2px 0px rgba(0,0,0,0.75); */
}

.btn-success {
    background-color: #54585a !important;
}

.btn-success:hover{
    background-color: #54585a !important;
    /* box-shadow: 2px 2px 2px 0px rgba(0,0,0,0.75); */
}

.csv-btn {
  height: 36px !important;
  border-radius: 4px;
  width: 110px !important;
}

.csv-btn::before{
  background-color: <?php echo $btnPrimary_color; ?> !important;
  height: 36px;
  color: #fff;
  padding: 6px 8px;
  border-radius: 4px;
  font-family: Open Sans, sans-serif !important;
  font-size: 14px;
  line-height: 23px;
  font-weight: bold;
}

.csv-btn:hover:before{
  background-color: <?php echo $btnPrimary_color; ?> !important;
}

a {
    color: <?php echo $linkColor; ?>;
    text-decoration: none;
}

a:hover, a:focus {
    color: <?php echo $linkColor_hover; ?>;
    text-decoration: none;
}



p {
    /*font: 14px 'Open Sans' !important;*/
    font-family: Open Sans, sans-serif !important;
}

h1, h2, h3, h4, h5, h6{
    font-weight: 500 !important;
}

.subnavbar .container>ul>li>a{
    color: #fff !important;
}

.subnavbar .container>ul>li.active>a{
    color: #fff !important;
    font-weight: 600 !important;
}


.subnavbar .container>ul>li>a:hover{
    
    text-decoration: none;
    transition: background-color .5s ease-in,color .5s ease-in;
}

.subnavbar .container>ul>li>a{
    font-weight: 500 !important;
    text-transform: none;
    font: 14px 'Open Sans' !important;
}

.subnavbar .container>ul>li>a>span{
    /*font: 14px 'Open Sans' !important;*/
}

/*.subnavbar .container>ul>li>ul{
    font-size: 13px !important;
}*/

.new{
    text-transform: none;
    color: #fff !important;
}

.new:hover {
    color: #000 !important;
    
    transition: background-color .5s ease-in,color .5s ease-in;
    font-weight: 600 !important;
}

.subnavbar .container>ul>li{
    background-color: transparent !important;
    border-left: none !important;
    border-bottom: none !important;
    height: 100px !important;
}





.subnavbar .container>ul>li>ul{
    background-color: rgb(87, 89, 92) !important;
    font-size: 13px !important;
    list-style-type: none;
    position: absolute;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(217, 217, 217);
    z-index: 3 !important;
    background-color: rgb(255, 255, 255) !important;
    min-width: 170px;
    text-align: left;
    height: auto !important;
}

.navbar .brand font{
    font-weight: 500 !important;
    color: #eaeaea !important;
    font-size: 18px !important;
}

.navbar .brand{
    margin-top: -5px !important;
}



.widget-header.home{
    background: none !important;
    border: none !important;
}

.widget-header h2 {
    font-size: 14px !important;
    margin-left: 10px !important;
}
.table .btn:not(.toggle-on):not(.toggle):not(.toggle-off):not(.toggle-handle) {
    padding: 0px !important;
    background: none !important;
    color: #0065e3;
    border: none !important;
    text-transform: uppercase;
    font-weight: bold;
    text-shadow: none !important;
    box-shadow: none !important;
    text-align: left !important;
}

.table-bordered thead{
    background: #f4f4f4 !important;
    border-top: 1px solid #ddd;
    box-shadow: 0 0 4px #ddd;
}
.table-bordered tbody tr:nth-of-type(even){
    background: #f4f4f4;
}

.table-striped tbody tr:nth-child(odd) td, .table-striped tbody tr:nth-child(odd) th {
    background-color: #ffffff;
}

.table-bordered td, .table-bordered th{
    border-left: none !important;
    border-top: none !important;
}

.table-bordered th{
    background: none !important;
    font-size: 14px;
}

i[class^="btn-icon-only icon"] {
    display: none !important;
}

.btn:focus {
    outline: none !important;
}
.dataTables_wrapper .row {
    margin-left: 0px;
}
.dataTables_filter, .dataTables_length {
    display: none;
}

.widget-header h2 {
    position: relative;
    top: 2px;
    left: 10px;
    display: inline-block;
    margin-right: 3em;
    font-size: 14px;
    font-weight: 800;
    color: #525252;
    line-height: 18px;
    text-shadow: 1px 1px 2px rgba(255,255,255,.5);
}

.alert{
	text-align: left !important;
    margin-top: 5px;
}
.alert{
    padding: 12px 35px 12px 14px !important;
}

.alert-success, .alert-info {
    background-color: #eefcff !important;
    border-color: #29a585 !important;
    border-style: solid !important;
    border-width: 1px 0 !important;
    -webkit-border-radius: 0px !important;
    border-radius: 0px !important;
    color: #6f6c6c !important;
}

.alert-danger, .alert-error{
    background-color: #fff3f6 !important;
    border-color: #ec2121 !important;
    border-style: solid !important;
    border-width: 1px 0 !important;
    -webkit-border-radius: 0px !important;
    border-radius: 0px !important;
    color: #e20606 !important;
}

div[id^="style_img"] {
	display: none !important;
}




.hidden{
    display: none !important;
}





.select_days{
    max-width: 120px;
}
.dropdown-menu .active>a:hover, .dropdown-menu li>a:hover{
    background: #fff !important;
	color: #000 !important;
    font-weight: bold;
}

#active_theme_table .hide_checkbox, #update_private_ssid .hide_checkbox, #guestnet_tab_9 .hide_checkbox, #schedule_tbl .hide_checkbox, #blacklist_search_table .hide_checkbox, #live_camp .hide_checkbox{
    cursor: default !important;
    z-index: -888 !important;
}

.toggle1.new{
    width: 90px;
}

.toggle1.new span{
    font-weight: bold;
    text-transform: none !important;
}



#sess-check-div .ui-dialog-content{
    max-height: none !important;
}

.cropControlRemoveCroppedImage {
    display: none !important;
}

#pre_id{
    display: none !important;
}

#template_image img{
    width: auto !important;
}

/* easy confirm styles */

.ui-widget-content{
  background: none !important;
  background-color: white !important;
  color: #797777;
}

.ui-widget-header{
  background: none !important;
  color: #252525 !important;
  border: none !important;
}

.ui-dialog{
  padding-top: 15px !important;
  padding-left: 30px !important;
  padding-right: 25px !important;
  padding-bottom: 30px !important;
  border-radius: initial !important;
}



button[class*="close"]:not(.fancy_close) {
    display: none !important;
}

.ui-dialog button.ui-dialog-titlebar-close{
  display:  inline-block !important;
  background: url(../img/close.png) no-repeat !important;
      background-position: center;
    background-size: cover !important;
    height: 30px !important;
    width: 30px !important;
  display: inline-block;
  margin-top: 0px;
  border: none !important;
  border-radius: initial;
  top: 0px !important;
  margin: 0px !important;
  /*! transform: scale(2); */
}

button[class*="close"]:not(.fancy_close):hover{
  border: none !important;
}

.ui-dialog .ui-dialog-titlebar{
  padding:  0px !important;
      font-size: 1.25rem;
}

.ui-dialog .ui-dialog-content{
  padding-top: 20px !important;
  padding-bottom: 20px !important;
  padding-left: 0px !important;
  padding-right: 30px !important;
  font-size: 1em;
  max-height: initial !important ;
}

.ui-widget-content{
  border: none !important;
}

.ui-dialog .ui-dialog-buttonpane{
  padding: 0px !important;
  padding-right: 5px !important;
}

.ui-dialog{

 /*  font-family: 'VM Circular Whisper',Helvetica, Arial, sans-serif !important; */
}


.ui-dialog-title{
    /* font-weight: initial !important; */
}

.ui-dialog .ui-dialog-buttonpane button{
  border-radius: 5px !important;
  background: <?php echo $btnInfo_color_hover; ?> !important;
  color: #fff !important;
  font-weight: bold !important;
      padding: 3px;
    border-radius: 3px !important;
    border: none !important;
}

.ui-dialog .ui-dialog-buttonpane button:hover{
    background-color: <?php echo $btnInfo_color_hover; ?> !important;
}

.ui-dialog-buttonset button:nth-child(2){
  
  color: #fff !important;
  border-radius: 5px !important;
  background: <?php echo $btnPrimary_color; ?> !important;
  font-weight: bold !important;
}

.ui-dialog-buttonset button:nth-child(2):hover{
    background-color: <?php echo $btnPrimary_color_hover; ?> !important;
}

.ui-button-icon-only .ui-icon{
  display: none !important;
}

.ui-dialog .ui-dialog-title{
  margin-top: 30px;
      font-size: 24px;
          font-weight: 500 !important;
  color: #1d1d1d;
  line-height: 40px;
}

.ui-front {
  border: 1px solid #c8c6ca !important;
}

.ui-dialog-buttonpane{
  margin-top: 10px !important;
}


.ui-state-hover{
    border: 1px solid #cccccc !important;
}

.ui-dialog button{
    border-radius: 0px !important;
    outline: none !important;
}

.ui-state-focus{
    outline: none !important;
    border: 1px solid #cccccc !important;
}

/* end easy confirm styles */


/*********************Jquery Datepicker stylesheet******************************************************/

.ui-icon{
    display: none !important;
}
.ui-widget-header {
    background: white !important;
    border: none !important;
    color: #252525 !important;
}
.ui-datepicker {
    display: none;
    padding: 15px 10px !important;
    width: 270px !important;
    background: #fff !important;
    border: 1px solid #9a9a9a !important;
    -webkit-box-shadow: #333 0 0 10px !important; /* FF3.5 - 3.6 */
    -moz-box-shadow: #333 0 0 10px !important; /* Saf3.0+, Chrome */
    box-shadow: #333 0 0 10px !important; /* Opera 10.5, IE9, FF4+, Chrome 10+ */
    border-radius: 0 !important;
    font-family: inherit !important;
}
/* .ui-datepicker:after,.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus {
    
    background: url(../img/carousel-controls.png) no-repeat !important;

} */

/*datepicker header style*/
.ui-datepicker-header {
    font-size: 23px !important;
    font-weight: 400 !important;
    margin-bottom: 5px !important;
}
.ui-datepicker-title {
    text-align: center !important;
    line-height: initial !important;
}
.ui-datepicker-prev,
.ui-datepicker-next {
    display: inline-block !important;
    width: 23px !important;
    height: 23px !important;
    text-align: center !important;
    cursor: pointer !important;
    background-repeat: no-repeat !important;
    line-height: 600% !important;
    overflow: hidden !important;
    background: url(../img/calendar-arrows.png) !important;
}

.ui-datepicker-prev {
    float: left !important;
    background-position: 0 0 !important;
}

.ui-datepicker-prev.ui-state-disabled {
    background-position: 0 -28px !important;
}

.ui-datepicker-next {
    float: right !important;
    background-position: 0 -56px !important;
}

.ui-datepicker-next.ui-state-disabled {
    background-position: 0 -84px !important;
}

/*datepicker table style*/
.ui-datepicker table {
    width: 100% !important;
    position: relative !important;
}

.ui-datepicker th {
    font-weight: bold !important;
    padding: 5px !important;
    text-align: center !important;
    font-size: 10px !important;
    border-bottom: 1px solid #dadadc !important;
}

.ui-datepicker td {
    text-align: center !important;
}

.ui-datepicker td span,
.ui-datepicker td a {
    
    display: inline-block !important;
    height: 30px !important;
    line-height: 30px !important;
    text-align: center !important;
    width: 30px !important;
    font-size: 0.750em !important;
    border-radius: 18px !important;
   
}

.ui-datepicker td a:not(.ui-state-highlight):not(.ui-state-active){
     background: none !important;
     border: 1px solid #fff !important;
     color: #252525 !important;
}



.ui-datepicker td a:hover{
    text-decoration: none !important;
    border: 1px solid #03406A !important;

}

.ui-datepicker-today a {
    border: 1px solid #000000 !important;
    background: none !important;
}

.ui-datepicker-unselectable .ui-state-default {
    color: #bababa !important;
}

.ui-datepicker-today a,
.ui-datepicker-today span { /* current day */
    -moz-border-radius: 18px !important;
    -webkit-border-radius: 18px !important;
    border-radius: 18px !important;
}
.ui-datepicker-current-day a { /* selected date */
    color: #fff !important;
    -moz-border-radius: 18px !important;
    -webkit-border-radius: 18px !important;
    border-radius: 18px !important;
    background: #000000 !important;
    border: 1px solid #000000 !important;
}
.ui-datepicker-due-date a { /* bill due date */
    border: 2px solid #00892d !important;
    -moz-border-radius: 18px !important;
    -webkit-border-radius: 18px !important;
    border-radius: 18px !important;
}




.password-strength-main{
	width: 53%;
 	background-color: rgba(0, 0, 0, 0.1);
  	height: 7px;
	}

	


.newTabs{
    background-color: #edeeee !important;
    border-top: 1px solid #e6e6e6;
    border-bottom: none !important;
}
/*.newTabs>li{
    background-color: #0066e3 !important;
    border: 3px solid #0066e3 !important;
    border-bottom: none !important;
    padding: 5px 20px 6.5px 20px !important;
    color: white !important;
    border-top-left-radius: 10px !important;
    border-top-right-radius: 10px !important;
    margin: 0 5px !important;
    cursor: pointer !important;
    margin-bottom: -3px !important;
    z-index: 2 !important;
    font-family: Open Sans, sans-serif !important;
    font-size: 12pt !important; 
    font-weight: unset;
}*/
.newTabs.newTabs>li.active{
    background-color: #e9e9e9;
    /*border-bottom: 4px solid #e9e9e9 !important;*/
    color: #0066e3 !important;
    cursor: auto !important;
    border-width: 3px 3px 1px 3px;
}
.newTabs.newTabs>li.active>a{
    font-size: 16px;
    border: none !important;
    border-top-color: currentcolor;
    border-top-style: none;
    border-top-width: medium;
    border-top: 3px solid <?php echo $main_color; ?> !important;
    background-color: #ffffff !important;
    cursor: pointer !important;
    color: #555 !important;
    
}
.newTabs.newTabs>li>a{
    padding-top: 12px;
    padding-bottom: 12px;
    padding-right: 15px;
    padding-left: 15px;
    font-size: 16px;
    margin-right: 0px !important;
    border: none !important;
    border-top-color: currentcolor;
    border-top-style: none;
    border-top-width: medium;
    border-top: 3px solid #edeeee;
    border-radius: 0px !important;
    line-height: 18px;
    color: #000 !important;
}
.nav.nav-tabs {
    padding-left: 0px !important;
}
/*.newTabs>li:nth-last-child(1)>a{
    border-right: 0px !important;
}*/
.newTabs + br{
    display: none;
}

.tabbable + br{
    display: none;
}

.highcharts-container svg .highcharts-button tspan{
    fill: #333 !important;
}

/*.custom-tabs{
    position: absolute;
    width: 100%;
    height: 22px;
    background: #ffffff;
    z-index: 0;
    border-bottom: 3px solid #0066e3 ;
}
.main{
    padding-bottom: 0px !important;
}*/


html body{
    background: #f2f2f2 !important;
    margin-bottom: 120px;
    font: 14px 'Open Sans' !important;
}

.form-actions.pd-zero-form-action {
    padding-left: 0px;
}

.tab-content{
    margin-top: 20px;
}
/*.tab-content:not(#myTabContentQuick){
    min-height: 350px;
}*/

/*#myTabContentDASH, #now, .parent-head{
    background-color: #e9e9e9 !important;
}*/
h1.head, #create_acc{
    margin-top: 20px !important;
}
h1.head:not(.en_display){
display: none !important;
}

@media (min-width: 520px)
.qos-sync-button {
margin-top: -17px !important
}


/*#guestnet_tab_intruduct, #create_camp, #live_camp, #guestnet_tab_1, #guestnet_tab_4, 
#guestnet_tab_2, #guestnet_tab_6, #tab_2, #tab_1,#create_product,#create_roles,#edit_users,
#payment_activity,#guestnet_tab_9,#active_theme,#preview_url, #create_users, #manage_users, #business_id_users,
#create_location, #assign_ap, #edit_parent, #mno_account, #active_mno, #saved_mno, #tab1, #tab2, #tab3,
#live_camp2, #live_camp3, #blacklist:not(.btn), #purge_logs, #create_camp, #toc, #vt_toc, #sys_controllers, #agreement2,
#agreement, #property_settings, #email:not(.form-controls):not(.span2), #registration, #live_cam3, #footer_config, #view_generic_theme,
#def_camp, #veryfi, #auth_con, #other_con, #peer_admin, #access_logs, #user_activity_logs, #auth_logs, #redirection_log, #guestnet_schedule,
#search,
#manually_add,
#support_log,
#support_log_api,
#error_logs,
#create_installation,
#de_acc,
#de_session,
#assign_loc_admin
{
    margin: 20px !important;
}*/

#agreement2 #edit_profile_b, #toc #submit_toc{
    margin-top: 30px;
    margin-left: 20px;
}

#blacklist #edit-profile, #email form{
    margin-left: 20px;
}

.tabbable .tab-content .tab-pane{
    margin: 20px !important;
}

#live_camp3 .img_logo {
    display: none!important;
}



.dropdown-menu a{
    white-space: unset;
}


.widget-content{
    padding: 0px !important;
}


.header2_part1 h2{
    padding: 0px !important;
}




/*.tab-pane:not(#dash_section_tab_0):not(#dash_section_tab_1):not(#dash_section_tab_2):not(#dash_tab_ARRIS_CDR_API_GRAPH_0)
:not(#dash_tab_ARRIS_CDR_API_GRAPH_1):not(#dashbox_THREE_GRAPH_BOX_NEW_0):not(.resize_charts)
{
    margin: 20px !important;
}*/

#tab2 #lawful_form #from_li_time, #tab2 #lawful_form #to_li_time{
    height: 30px;
    padding: 2px 38px 4px 8px;
}



.mainnav ul a{
white-space: inherit !important;
}
.mainnav ul li {
min-width: auto !important;
}




/*.tab-content {
        display: flow-root !important;
}*/

.highcharts-container, .highcharts-root{
        width: 100% !important;
    }

.ui-tooltip{
    z-index: 699 !important;
}

#welcome_validate{
    font-family: Open Sans !important;
    font-size: 14px !important;
}

#manually_add .head, #support_log .head, #error_logs .head, #support_log_api .head{
    padding: 0 0 10px 0px !important;
}

#dash_0>span{
    line-height: 18px !important;
}

#customer_div #all_customers{
    margin-bottom: 2em !important;
}



/*#del_1 [class^="icon-"]:not(.show), [class*=" icon-"]:not(.show), #del_2 [class^="icon-"]:not(.show), [class*=" icon-"]:not(.show),
#step3_del_2
{
    display: inline-block !important;
}*/

#ap_summary .hideIcon, #retrieve_ap .hideIcon, #step3_del_2{
    display: inline-block !important;
}

/*.select2-chosen{
    background: url(../img/form-fields-biz2.png) 0 -37px no-repeat,url(../img/form-fields-biz2.png) 100% 0 no-repeat !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important; 
    margin-right: 0px !important;
}*/

/* start de */
.form-horizontal .control-label{
    font-family: Open Sans, sans-serif !important;
    display: block;
    text-align: left;
    float: none;
}

h1.head{
    padding: 0px;
    padding-bottom: 15px;
    font-weight: 500 !important;
    margin-top: 20px !important;
    font-size: 24px !important;
    text-align: left !important;
    color: #333 !important;
    box-sizing: border-box;
}

h1.head.qos-head{
    display: block !important;
    padding: 20px;
    padding-top: 0px;
}

.form-horizontal .controls{
    margin-left: 0;
}

.tab-content #system1_response .alert, .tab-content > .alert{
    margin-left: 20px;
    margin-right: 20px;
}
.form-horizontal .form-actions{
    padding-left: 0px;
}
.form-horizontal {
    margin-left: 20px;
}
.form-horizontal .table_response {
    margin-left: -20px;
}
legend+.control-group{
    margin-top: 0px;
}
#gen_url{
    margin-left: 0px !important;
}
.widget-table .widget-header{
    background: #ffffff !important;
    border: 1px solid #ffffff !important;
}
.widget-table .widget-header h3{
    left: 9px;
    font-size: 16px !important;
    top: 9px;
}
#user_activity_logs{
    margin-top: 0px !important;
}
#se_te .form-horizontal, #session .form-horizontal .widget-content.table_response{
    margin-left: -5px;
}


.dataTables_info {
    text-align: right;
}

.paging_simple_numbers {
    float: right;
}

@media (max-width: 480px){
.form-horizontal {
    margin-left: 0px;
}
.form-horizontal .table_response {
    margin-left: 0px;
}
}

/* end de */
body input, body button, body select, body textarea, body p, body label{
    font-family: Open Sans, sans-serif !important;
}






/*#activeLocationsTable{
    margin-top: 30px;
}
.tablesaw-bar.tablesaw-mode-columntoggle:has(< table#activeLocationsTable) {
    top: -20px;
}*/

.perpage{
    top: -40px !important;
}



.perpage select{
    width: 80px;
}


#myTabDash{
    margin-right: -10px;
}

/*------------------------------------------------------------------------*/

html{
    min-height: 100%;
    position: relative;
 }


html body .subnavbar-inner{
    background: <?php echo $navbarColor; ?>;
    height: 100px;
    border-bottom: 1px solid #d6d6d6;
}


.intro_page{
    display:none;
}

.subnavbar .container > ul{
    height: 107px !important;
}

.footer-main .extra {
    position: absolute;
    bottom: 0;
    width: 100%;
    <!-- margin-bottom: 71px; -->
    border-top: none !important;
    border-bottom: none !important;
}

.footer-main .extra-inner{
    background: #2c2c2e !important;
}

.footer-main .footer{
    position: fixed;
    bottom: 0px;
    width: 100%;
    z-index: 9999999999999999;
}

.footer-inner{
    background: <?php echo $main_color; ?> !important;
    color: <?php echo $font_color; ?> !important;
    line-height: 40px;
}

/*.footer-inner::before {
    position: absolute;
    bottom: 100%;
    left: 50%;
    width: 0;
    height: 0;
    -webkit-transform: translateX(-50%);
    transform: translateX(-50%);
    border-right: 20px solid transparent;
    border-bottom: 15px solid #d9272d;
    border-left: 20px solid transparent;
    content: "";

}*/


.btn{
    padding: 6px 8px !important;
    background-image: none !important;
    text-shadow: none !important;
    font-weight: bold;
   /* color: #fff;*/
}


.btn-info {
    background-color: <?php echo $btnInfo_color; ?> !important;
    color: <?php echo $font_color2; ?>;
}

.btn-info:hover{
    background-color: <?php echo $btnInfo_color_hover; ?>;
    color: <?php echo $font_color2; ?>;
}

.btn-primary {
    background-color: <?php echo $btnPrimary_color; ?> !important;
    color: <?php echo $font_color; ?>;
}

.btn.btn-primary {
    color: <?php echo $font_color; ?>;
}

.btn-primary:hover{
    background-color: <?php echo $btnPrimary_color_hover; ?>;
    color: <?php echo $font_color; ?>;
}

.logo_img{
    max-width: 150px !important;
    max-height: 100px !important;
    vertical-align: middle;
    float: none !important;
}

select:not(.mini_select){
  /*background: url(../img/form-fields-biz2.png) 0 -37px no-repeat,url(../img/form-fields-biz2.png) 100% 0 no-repeat;
   -webkit-appearance: none;
    -moz-appearance: none !important; */
   padding: 4px 15px 4px 8px;
    height: 37px;
}
/*select::after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

select:parent::after {
    content: "\f078";
    font-family: FontAwesome;
    float: right;
    color: <?php echo $selectColor; ?>;
}*/

.power_box2 {
height: 517px !important;
}

/*.select2-chosen{
    margin-right: 0px !important;
}

.select2-chosen::after{
    content: "\f078";
    font-family: FontAwesome;
    float: right;
    color: <?php echo $selectColor; ?>;
}  

.control-group .select2-container .select2-choice .select2-arrow b{
    background: none !important;
    background-image: none !important;
}*/

.content.clearfix .select2-container{
    width: 100% !important;
}

.widget-header{
    background: #f2f2f2 !important;
    border: 1px solid #f2f2f2 !important;
    display: none;
}

.widget-header h3{
    color: #333 !important;
    /* font-family: 'NexaW01-Bold' !important; */
    font-size: 20px !important;
    font-weight: bold !important;
}

.subnavbar .container>ul>li.active>a>span>span, .subnavbar .container>ul>li:hover>a>span>span{
    font-weight: 600 !important;
    border-bottom: 2px solid #333 !important;
}


body .subnavbar .container>ul>li.active>a{
    border-bottom: none ;
  font-weight: 600 !important;
}

body .subnavbar .container>ul>li>a>span:not(.glyph), body .subnavbar .container>ul>li>a{

    color: #1d1d1d !important;
    display: block;
    font-size: 14px !important;
    height: 100% !important;
    padding-left: 3px !important;
    padding-right: 3px !important;
    position: relative !important;
    text-align: center !important;
    text-decoration: none !important;
    z-index: 2 !important;
    font-family: Open Sans, sans-serif !important;
}

.dropdown .glyph{
    position: absolute !important;
    top: 0 !important;
    right: 0;
    display: inline-block !important;
    font-family: 'glyphs' !important;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 40px;
    -webkit-font-smoothing: antialiased;
}

.glyph{
        position: relative !important;
    top: 5px;
    display: inline-block !important;
    font-family: 'glyphs' !important;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
}

.dropdown.open .dropdown-toggle {
    color: #000;
    background: transparent;
}

.navbar-inner{
    background: <?php echo $navbarColor; ?> !important;
}

.btn-navbar{
    background-image: none;
    background-color: #fff;
    border: none;
}

.btn-navbar .icon-bar{
    background-color: #000;
}


.btn-navbar.active, .btn-navbar.disabled, .btn-navbar:active, .btn-navbar:hover, .btn-navbar[disabled]{
    background-color: #fff;
    box-shadow: none;
}


.btn-primary.active, .btn-primary.disabled, .btn-primary:active, .btn-primary:hover, .btn-primary[disabled]{
    background-color: <?php echo $btnPrimary_color; ?>;
}


.mainnav ul li.subLi{
    color: #b7b7b7;
    padding: 6px 20px;
    padding-bottom: 0px;
    font-size: 12px;                                
}
hr.divid{
    background: #a9a9a9;
    border:none;
    height: 1px;
    margin-top: 5px;
    margin-left: 20px;
    margin-right: 20px;
    margin-bottom: 0px;
}
.mainnav ul li.subLi div{
    margin-left:10px;
    word-break: break-word;
}
.mainnav ul li.subLi div::before {
    content: "\f0a4";
    font-family: FontAwesome;
    margin-right: 5px;
}
.subLi{
    padding: 3px 15px;
}



.parent-head{
    height: auto;
    width: 100%;
    margin: auto;
    padding-bottom: 60px;
}

.parent_intro{
    /*height: 500px;*/
    width: 100%;
    text-align: center;
    margin: auto;
}

.parent_intro li{
    list-style-type: none;
    position: relative;
    display: inline-block;
    float: none;
    height: 92%;
    vertical-align: top;
}

.parent_intro li>div {
    margin: 5px;
    background:#fff;
    border: 1px solid black;
}

.intro-content {
    width: 100%;
    padding: 40px 20px 18px;
    box-sizing: border-box;
    position: static;
    height:250px;
    text-align: left;
    font-size: 14px;
}

.intro-content p{
    color: #000000 !important;
    font-weight: bold !important;
}

.intro-content a{
    font-size: 18px;
    bottom: 15px;
}

.parent_intro .intro-content p{
    font-size: 15px !important;
}

.intro-content{
    text-align: justify;
    /*padding: 10px !important;
    padding-right: 20px !important;
    height: 62px !important;
    padding-right: 50px !important;*/
}

.intro-head{
    color: #fff;
    padding: 8px;
    font-size: 13px;
    font-weight: bold;
    background-color: <?php echo $main_color; ?>
}

.intro-footer{
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    margin: 20px;
    text-align: left;
    padding-top: 12px;
    min-height: 90px;
    padding-bottom: 10px;
}

.intro-footer span{
    color: #000;
    font-weight: bold;
    font-size: 14px;
    display: block;
    margin-bottom: 10px;
}

.intro-footer a{
    display: block;
    font-size: 15px;
    position: relative;
    margin-bottom: 2px;
    text-decoration: underline;
}

.wifi-parent{
    width: 35px;
    text-align: center;
    margin: auto;
    height: 35px;
    line-height: 31px;
    border-radius: 50%;
    background: #58595b;
    margin-bottom: 20px;
}

.wifi-parent img{
    width: 21px;
}

.intro-head img{
    vertical-align: middle;
    width: 23px;
}

@media only screen and (max-width: 1024px) and (min-width: 480px){
    .parent_intro, .parent-head{
        height: auto;
    }

    .parent_intro li{
        width: 70% !important;
    }

    .parent_intro{
        padding-top: 18px;
    }
    .intro-content{
        height: 210px;
    }
}


section.counter{
    padding: 0 10px 0 10px;
}

.main_counter_area .main_counter_content .single_counter{
    background: <?php echo $main_color; ?>;
    color: #fff;
}


.power_box1 .ui-slider-horizontal .ui-slider-range {
    border: 1px solid <?php echo $main_color; ?> !important;
    box-shadow: 0 1px 0 <?php echo $main_color; ?> inset;
    background: <?php echo $main_color; ?> !important;
}

.power_box1 .ui-slider .ui-slider-handle::after {
    background: <?php echo $main_color; ?> !important;
    box-shadow: 0 1px 1px 1px <?php echo $main_color; ?> inset, 0 1px 0 0 #FFF !important;
}

.toggle.btn-xs{
    min-width: 50px;
    min-height: 20px;
    margin-top: 0px;
    border-radius: 22px;
    max-height: 23px;
}
.toggle-on.btn-xs{
    padding-right: 20px !important;
}

.toggle-off.btn-xs {
    padding-left: 20px !important;
}

.toggle-handle{
    height: 20px;
    width: 35px;
    border-radius: 20px;
}

.btn-success.toggle-on{
    background-color: <?php echo $secondary_color; ?> !important;
}

.btn-warning.toggle-off{
    background-color: <?php echo $secondary_color; ?> !important;
   
}

.s_toggle .btn-warning{
 
    border-radius: 20px !important;
    width: 62.5px !important;
}
.s_toggle .btn-success{
 
 border-radius: 20px !important;
 width: 62.5px !important;
}

.logo_image{
    background-image: url(<?php echo $logo_image_url; ?>);
    height: 100%;
    background-size: contain;
    background-repeat: no-repeat;
    min-width: 150px !important;
    min-height: 100px !important;
    max-width: 160px;
}

.ui-datepicker{
    z-index: 2 !important;
}

/*--------------------small devices----------------------*/


@media (min-width: 768px){
    #passcode_submit{
        /*network.php*/
        margin-left: 10px;
    }
}


@media (min-width: 767px) {
    div.inline-btn, a.inline-btn, button.inline-btn, input[type="submit"].inline-btn{
        margin-left: 10px !important;
        margin-top: 0px !important;
    }

    div.inline-btn, select.inline-btn, input.inline-btn, button.inline-btn, a.inline-btn{
        display: inline-block !important;
    }
}


@media screen and (min-width : 500px){
  .ui-dialog{
    min-width: 400px;
  }
  .ui-dialog .ui-dialog-title{
    margin-top: 15px !important;
  }
}


@media (max-width: 979px){
    /*.main {
        margin-top: 55px;
    }
    .custom-tabs{
        border-bottom: 0px !important;
        position: fixed !important;
        margin-top: -30px !important;
        z-index: 801 !important;
        background: #fff !important;
        height: 50px !important;
        
    }*/

    .big_stats .tab-content{
        margin-top: 30px !important;
        background-color: #e9e9e9 !important;
    }
    .navbar .nav>li>a, .navbar .dropdown-menu a{
        color: #000 !important;
    }

    .new{
        color: #000 !important;
    }

    .dropdown .caret{
        display: none;
    }

    .navbar .dropdown-menu a:hover, .navbar .nav>li>a:hover, body .dropdown-menu li:hover{
        background-color: transparent !important;
        color: #000 !important;
    }

    #myTabContentDASH .tab-content>.tab-pane{
       background-color: #fff;
    }

    #myTabContentDASH .tab-content>#dashbox_THREE_GRAPH_BOX_NEW_0{
       background-color: #fff;
    }

    #myTabContentDASH #dash_section_tab_0{
       background-color: #fff;
    }

    .tab-content{
        margin-top: 30px;
    }
    .tab-content:not(#myTabContentQuick){
        min-height: 400px !important;
    }
    .zg-ul-select:not(.active) li.active{
        float: right !important;
        width: max-content !important;
    }
    .main .nav-tabs {
    z-index: 10000 !important;
    }
    .navbar-fixed-top {
        z-index: 20000 !important;
    }
    .cf_min{
        z-index: 800 !important;
    }
    .trans-wid-con #big_stats{
        z-index: 800 !important;
    }

    .logo_image{
        min-height: 80px !important;
        margin-left: 20px;
        display:inline-block;
    }

}


@media (max-width: 767px){
    .input-prepend input[class*="span"], .input-append input[class*="span"] {
        width: 158px !important;
    }
    #passcode_submit{
        /*network.php*/
        width: 158px !important;
        padding-right: 8px !important;
        padding-left: 8px !important;
        margin-top: 10px;
    }
    div.inline-btn, a.inline-btn, button.inline-btn, input[type="submit"].inline-btn{
        margin-top: 10px !important;
        margin-left: 0px !important;
    }

    div.inline-btn, select.inline-btn, input.inline-btn, button.inline-btn, a.inline-btn{
        display: block !important;
    }

    /*.custom-tabs{
        margin-left: -20px !important;
    }*/

    body {
        padding-left: 0px;
        padding-right: 0px;
    }
}

@media screen and (max-width: 660px) and (min-width: 480px){
    .multi_sele_parent{
        display: block !important;
    }
    .ms-container{
        width: 100% !important;
    }
}

@media screen and (max-width: 480px) {
    .theme_response{
        margin-left: 0px !important;
    }
     body {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    .widget-content {
        max-width: 100% !important;
    }
    .extra, .footer {
        margin-right: 0px !important;
        margin-left: 0px !important;
    }

    .tab-content {
        display: block;
    }
    /*.main .custom-tabs{
        margin-left: 0px !important;
    }*/

        .tablesaw-minimap-mobile .tablesaw-advance{
        display: inline-block;
        float: right;
        text-align: right;
        width: 100%;
    }
    .tablesaw-minimap-mobile .tablesaw-bar .tablesaw-advance a.tablesaw-nav-btn{
        margin-top: 2px;
        margin-bottom: 0px;
    }

    .tablesaw-minimap-mobile .tablesaw-columntoggle-popup{
        text-align: left;
    }
    .tablesaw-minimap-mobile .tablesaw-advance.minimap{
        display: inline-block;
        float: right;
        height: 10px;
        margin-top: -5px;
        width: auto
    }
    .tablesaw-minimap-mobile .tablesaw-bar{
        top: -50px;
    }

    .tablesaw-minimap-mobile .widget-header{
        height: 50px;
    }

    #live_camp .action-table a:not(.btn-small){
        margin-bottom: 20px;
    }

    .parent_intro, .parent-head{
        height: auto;
        margin-top:0 !important;
    }

    .parent_intro li{
        width: 90% !important;
    }

    .parent_intro{
        padding-top: 18px;
    }

}

@media (max-width: 455px){
   .multi_sele_parent{
        display: block !important;
    }
    .ms-container{
        width: 100% !important;
    }
}

@media (max-width: 393px){
    .input-prepend input[class*="span"], .input-append input[class*="span"] {
        width: 100% !important;
    }

    input[class*="span"], select[class*="span"], textarea[class*="span"],/*network_pr.php*/meter[class*="span"], .uneditable-input {
        width: 100% !important;
    }
    .input-prepend{
        width: 100% !important;
        }
    .input-append{
        width: 100% !important;
    }
    #passcode_submit{
        /*network.php*/
        width: 100% !important;
    }
}



/* date picker modal display for mobile devices */
@media screen and (max-width: 767px) {
    .datepicker-modal-component {
        position: absolute !important;
        z-index: 2002 !important;
        background-color: #fff !important;
        border: 1px solid #9a9a9a !important;
        -webkit-box-shadow: #888 10px 10px 10px !important; /* FF3.5 - 3.6 */
        -moz-box-shadow: #888 10px 10px 10px !important; /* Saf3.0+, Chrome */
        box-shadow: #888 10px 10px 10px !important; /* Opera 10.5, IE9, FF4+, Chrome 10+ */
        font-size: 18px !important;
    }
    .datepicker-modal-component .datepicker-modal-component-content {
        margin: 30px 30px 40px !important;
    }
    .datepicker-modal-component .datepicker-modal-component-title {
        font-family: "open_sansregular", Arial, Helvetica, Sans-serif !important;
        font-size: 2.143em !important; /* 14*2.143 = 30.002px; base font-size taken as 14px; */
        line-height: .967em !important; /* 29px */
        margin: 30px 30px 50px !important;
    }
    .datepicker-modal-component .datepicker-modal-component-content .modal-inline-content > h2 {/* allow for title to be passed in content area instead of in title tag component and look like H1 */
        font-family: "open_sansregular", Arial, Helvetica, Sans-serif !important;
        font-size: 2.143em !important; /* 14*2.143 = 30.002px; base font-size taken as 14px; */
        line-height: .967em !important; /* 29px */
        margin-bottom: 50px !important;
    }
    .datepicker-modal-component .datepicker-modal-component-head {
        position: relative !important;
        border-bottom: 1px solid #b7b7b7 !important;
        height: 67px !important;
    }
    .datepicker-modal-component .datepicker-modal-component-head span.mpick-date-close {
        position: absolute !important;
        top: 20px !important;
        right: 30px !important;
        width: 27px !important;
        height: 27px !important;
        background: url(../img/close.png) no-repeat !important;
        cursor: pointer !important;
    }

    .datepicker-modal-component .datepicker-modal-component-buttons {
        border-top: 1px solid #b7b7b7 !important;
        margin: 65px -30px 0px !important;
        padding: 10px 0 0 !important;
    }

    /* loading date picker modal */
    .datepicker-modal-component .datepicker-modal-component-title h3.loading-title {
        font-family: "open_sansregular", Arial, Helvetica, Sans-serif;
        background: url(../img/loading-whitebg.gif) no-repeat top center !important;
        padding-top: 40px !important;
        text-align: center !important;
    }
    .datepicker-modal-component .datepicker-modal-component-content .loading-message p {
        text-align: center !important;
    }

    .modal-inline-content {
        display: none !important;
    }
    .datepicker-modal-component-content .modal-inline-content {
        display: block !important;
    }
    .datepicker-modal-component .ui-datepicker {
        left: -20px !important;
        position: relative !important;
        top: 0 !important;
        z-index: 0 !important;
        border: none !important;
        border-radius: none !important;
        box-shadow: none !important;
        width: 104% !important;
    }
    .date-modal-button, .date-modal-close {
        margin: 20px 20px 0px !important;
    }
    .datepicker-modal-component .ui-datepicker:after {
        left: -40px !important;
    }



}


@media (max-width: 380px) {
   .password-strength-main{
    width: 100% !important;
    
    }
}

@media (max-width: 768px) {
   .password-strength-main{
    width: 48% ;
    
    }

    #myTabContentDASH .widget-header h2{
        width: 100% !important;
        text-align: center;
    }
}



@media (max-width: 520px) {
   .newTabs>li {
        display: flex !important;
        float: none !important;
        margin: 0px !important;
        margin-top: -2px !important;
        border: 1px solid #dcdbdb !important;
        box-shadow: 0px 1px 0 1px #ffffff;
        border-top: none !important;
    }
    .newTabs>li::after {
        content: "\f078";
        font-family: FontAwesome;
        color: <?php echo $selectColor; ?>;
        position: relative;
        top: 10px;
        right: 15px;
    }
    .newTabs>li.active{
        box-shadow: 0px 1px 0 2px #ffffff;
        border-width: 2px 2px 2px 2px !important;
        background-color: #c6c6c6 !important;
    }
    .newTabs>li:last-child {
        margin-bottom: -3px !important;
        box-shadow: 0px -1px 0 0px #ffffff;
    }
    .tab-content{
        margin-top: 0px !important;
    }
    .newTabs>li>a{
        width: 100% !important;
        text-align: left !important;
        border-top: 0px;
    }

    body .main .newTabs{
        /*position: sticky !important;
        top: 55px;*/
        margin-top: -18px !important;
        background: #fff !important; 
        padding-right: 10px !important;
        padding-left: 10px !important;
    }
    /*.custom-tabs{
        display: none !important;
    }*/

    #def_camp img{
        width: 100%;
    }

    html body{
        background: #fff !important;
    }

    
    #SP_LINE_dashbox_REAL_TIME_SESSION_0, #BAR_COL_VERTICAL_ARRIS_API_dashbox_ARRIS_API_G_SESSIONS_0, #BAR_COL_VERTICAL_ARRIS_API_dashbox_ARRIS_API_G_BANDWIDTH_0, #BAR_COL_PIE_ARRIS_API_dashbox_ARRIS_API_G_OS_0{
        background-color: #fff !important;
    }

    .highcharts-container, .highcharts-root{
        width:100% !important;
    }

    .btn_bac{
        position: absolute !important;
        z-index: 10;
        top: 140px
    }

    /*.nav-tabs>li {
        display: flex !important;
        float: none !important;
    }
    .tab-content{
        margin-top: 180px;
    }*/


    .newTabs.newTabs>li.active>a{
        border-top: 1px solid #dcdbdb !important;
        background-color: #c6c6c6;
    }

}


@media (min-width: 1200px) {
    #location_info_div .toggle{
        /*margin-left: calc(100% - 89%);*/
        margin-bottom: 0px !important;
    }

    .container, .navbar-fixed-bottom .container, .navbar-fixed-top .container, .span12, .parent-head {
        width: 1200px;
    }
}

@media screen and (max-width: 1199px) and (min-width: 979px){
    #location_info_div .toggle{
        margin-left: calc(100% - 81%);
    }
}

@media screen and (max-width: 767px) and (min-width: 481px){
    .tab-content {
        display: grid !important;
    }

    .highcharts-container, .highcharts-root{
        width: 100% !important;
    }
}


@media (min-width: 979px){
    .btn_bac{
        position: absolute !important;
        z-index: 10;
        top: 280px
    }
}

@media screen and (max-width: 978px) and (min-width: 521px){
    .btn_bac{
        position: absolute !important;
        z-index: 10;
        top: 120px
    }

    /*.newTabs{
        margin-top: 35px;
    }*/
}




@media (max-width: 349px){
    #live_camp .action-table a:not(.btn-small), #assign_ap .btn#pendingLocationsSearch{
        margin-bottom: 30px;
    }
    .perpage{
        top: -60px !important;
    }

}


/*--------------------end-small devices----------------------*/



i.paas_toogle {
    top: 30px;
    position: absolute !important;
    margin-top: 0px !important;
    right: 5px;
}
input.pass_msg {
    padding-right: 5px;
    width: 360px !important;
}

#add_tenant h3.head, #vouche_ex{
    margin-left: 35px !important;
}


@media (max-width: 1200px){
    i.paas_toogle {
       right: 80px;
    }
    input.pass_msg {
        width: 290px !important;
    }
}

@media (max-width: 979px){
    i.paas_toogle {
        right: 100px;
    }
    input.pass_msg {
        width: 218px !important;
    }
    #add_tenant h3.head{
        width: 280px;
        margin: auto !important;
    }
    
}

@media (max-width: 768px){
    i.paas_toogle {
        right: 60px;
    }

}

@media (max-width: 767px){
    i.paas_toogle {
        right: 5px;
    }
}


#download_parent_list {
    margin-bottom: 20px;
}

