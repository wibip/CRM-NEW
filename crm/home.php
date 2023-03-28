<!DOCTYPE html>
<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL & E_NOTICE & E_WARNING);
//require_once('db/config.php');

/* No cache*/
//header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

header('Content-Type: text/html; charset=utf-8');


/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();


include 'header_top.php';

include_once 'classes/cryptojs-aes.php';

require_once 'classes/CommonFunctions.php';



///admin_report_dash_quick_view/////
$rowc = $db->select1DB("SELECT `settings_value` AS f  FROM `exp_settings` s WHERE s.`settings_code`='dash_quick_view_top_value' LIMIT 1");
//$rowc=mysql_fetch_array($find_quick_data_type);
$dash_quick_view_top_value = $rowc['f'];


if ($dash_quick_view_top_value == 'icon') {
  $slider_container_1_height = '105px';
  $middle_text_h_style = 'h3';
} else {
  $slider_container_1_height = '80px';
  $middle_text_h_style = 'h2';
}


function httpGet($url)
{
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //  curl_setopt($ch,CURLOPT_HEADER, false);

  $output = curl_exec($ch);

  curl_close($ch);
  return $output;
}

$data_secret = $db->setVal('data_secret', 'ADMIN');


?>

<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
  <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet"> -->
  <link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

  <link href="css/font-awesome.css" rel="stylesheet">
  <link href="css/style.css?v=1" rel="stylesheet">
  <link href="css/pages/dashboard.css" rel="stylesheet">
  <link href="css/tree_style.css?v=2" rel="stylesheet">
  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->






  <!-- Add jQuery library -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/excanvas.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  <!-- Tab JS-->
  <!-- <script type="text/javascript" src="js/transition.js"></script>
<script type="text/javascript" src="js/tab.js"></script> -->


  <!-- Slider JS code-->
  <!--  <script type="text/javascript" src="js/jssor.js"></script>
 <script type="text/javascript" src="js/jssor.slider.js"></script>
 -->




  <?php

  include 'header.php';


  /*Graph*/
  require_once 'classes/graphClass.php';
  $graphDB = new graph_functions($user_distributor);

  $base_portal_url = $db->setVal('camp_base_url', 'ADMIN');


  $dash_link_group = $package_functions->getOptions('DASH_LINK_GROUP', $system_package);

  ?>

  <!--    //*******geture controls*****-->
  <?php
  $feture_section_array = json_decode($package_functions->getOptions('DASH_SECTIONS', $system_package), true);

  $home_dropdown_enable = $package_functions->getOptions('HOME_DROPDOWN_ENABLE', $system_package);
  ?>

  <!--    //*******geture controls*****-->






  <!--Graph JS Scripts-->
  <script type="text/javascript" src="js/highcharts.js?v=1"></script>
  <script src="js/no-data-to-display.js"></script>


  <style type="text/css">
    .highcharts-no-data tspan:nth-child(1) {
      fill: #cdcdcd;
      font-weight: 700;
      font-family: Arial;
      font-size: 15px;
    }

    .ajax-loader {}

    .loader_class {
      position: absolute;
      top: 20%;
      left: 35%;
    }

    svg .highcharts-button rect {
      fill: white !important;
      stroke-width: 0 !important;
    }

    /*
  svg .highcharts-button text{
     fill: #23d2bd !important;
     cursor: pointer !important;
     font-weight: 600;
     font-size: 16px;
  }*/

    svg .highcharts-button tspan {
      fill: #23d2bd;
      cursor: pointer !important;
      font-weight: 600;
      font-size: 16px;
    }

    .highcharts-table-caption {
      margin-bottom: 5px;
      font-family: sans-serif;
      font-size: 14pt;
    }

    .highcharts-data-table table {
      border-collapse: collapse;
      border-spacing: 0;
      background: white;
      min-width: 100%;
      margin-top: 10px;
    }

    .highcharts-data-table td,
    .highcharts-data-table th {
      text-align: center;
      font-family: sans-serif;
      font-size: 10pt;
      border: 1px solid silver;
      padding: 0.5em;
    }

    .highcharts-data-table tr:nth-child(even),
    .highcharts-data-table thead tr {
      background: #f8f8f8;
    }



    .highcharts-data-table thead th {
      font-family: open_sansregular, Arial, Helvetica, sans-serif;
      font-weight: 600;
      font-size: 16px;
      padding: 12px 15px;
      color: #252525;
      border-radius: 0px !important;
      background: #ffffff !important;
      border-top: 5px solid #252552 !important;
      border-bottom: 1px solid #dddddd !important;
      /* vertical-align: middle; */
    }

    .highcharts-data-table thead th.selected {
      background-color: #0a3167;
    }

    .highcharts-data-table thead th a {
      color: #fff;
    }

    /* table cell */
    .highcharts-data-table td,
    .highcharts-data-table th {
      /* vertical-align: top; */
      font-family: open_sansregular, Arial, Helvetica, sans-serif;
      background-color: rgb(255, 255, 255);
      padding: 10px 15px;
      font-size: 16px;
      font-weight: 500;
      color: #252525;
      border-left: 1px solid #fff;
    }

    /* Set base table background so cells and columns can mix transparent colors */
    .IE8 .highcharts-data-table td,
    .IE9 .highcharts-data-table td {
      background-color: transparent;
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#fafafafa, endColorstr=#fafafafa);
    }

    /* Add mixer for odd rows */
    .highcharts-data-table tbody tr:nth-child(odd) td,
    .highcharts-data-table tbody tr:nth-child(odd) th {
      background-color: rgba(234, 234, 234, 0.6);
    }

    .IE9 .highcharts-data-table tbody tr:nth-child(odd) td,
    .IE9 .highcharts-data-table tbody tr:nth-child(odd) th {
      background-color: transparent;
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#f2f2f2f2, endColorstr=#f2f2f2f2);
    }

    /* Add mixer for selected column */
    .highcharts-data-table col.selected {
      background-color: rgba(64, 143, 173, 0.35);
    }

    .IE8 .highcharts-data-table col.selected,
    .IE9 .highcharts-data-table col.selected {
      background-color: #0a3167;
    }

    /* selected cell for tables that cannot support the colgroup option, like AEM tables */
    .highcharts-data-table tr td.selected {
      background-color: #dee9ed;
      filter: none;
    }

    .highcharts-data-table tr:nth-child(odd) td.selected {
      background-color: #d6e1e5;
      filter: none;
    }


    .highcharts-table-caption {
      display: none;
    }

    .resize_charts .highcharts-data-table:nth-child(2) {
      display: none
    }

    .highcharts-data-table table tbody tr:nth-of-type(20)~tr,
    .dataTables_info {
      display: none
    }


    .highcharts-data-table table thead tr th:nth-child(2),
    .highcharts-data-table table thead tr th:nth-child(3) {
      display: none;
    }

    .highcharts-data-table table tbody tr td:nth-child(2),
    .highcharts-data-table table tbody tr td:nth-child(3) {
      display: none;
    }

    .resize_charts .highcharts-data-table {
      display: none
    }

    .resize_charts .highcharts-data-table:last-of-type {
      display: block;
    }

    .resize_charts {
      position: relative;
      min-height: 300px;
      margin-bottom: -8px;
    }

    .resize_charts_inner {
      position: absolute;
      height: 100%;
      width: 100%;
      background: white;
      z-index: 77;
      display: none;
    }

    .ajax-loader {
      position: absolute;
      top: 20%;
      left: 50%;
      -webkit-box-align: 67;
      z-index: 78;
    }

    #myTabDASHBOX_REAL_TIME_SESSION {
      margin-top: 30px;
    }

    .widget {

      margin-bottom: 0.5em !important;

    }

    .resize_charts .highcharts-data-table:last-of-type {
      position: relative
    }

    .resize_charts .highcharts-data-table:last-of-type::before {
      content: "The summary table below provides the Application by Category, total clients using that application for the time period and the applications usage.  Usage is provided in megabits by total, download and upload.";
      font-size: 15px;
      text-align: left;
      float: left;
      margin-left: 5px;

    }
  </style> 
  <script type="text/javascript" src="js/exporting_new.js?v=104"></script>
  <script type="text/javascript" src="js/export-data.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.min.js"></script>

  <script type="text/javascript" src="js/data.js?v=1"></script>
  <script type="text/javascript" src="js/drilldown.js?v=1"></script>
  <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/tooltipster.css">
  <link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css">
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <!-- highcharts download symbol styles -->



  <style type="text/css">
    #loading {
      width: 100%;
      height: 100%;
      top: 0px;
      left: 0px;
      position: fixed;
      display: block;
      opacity: 0.8;
      background-color: #fff;
      z-index: 99;
      text-align: center;
    }

    #loading-image {
      position: absolute;
      top: 45%;
      left: 50%;
      z-index: 100;
    }


    .verticalLine {
      border-left: medium #999999 solid;
      position: absolute;
      vertical-align: super;
      height: 2500px;
    }







    /*Start Drop Down*/




    .btn-group>.btn:first-child {
      margin-left: 0;
    }

    .btn-group-vertical>.btn,
    .btn-group>.btn {
      position: relative;
      float: left;
    }




    button,
    input,
    optgroup,
    select,
    textarea {
      margin: 15px;
      font: inherit;
      color: inherit;
    }

    * {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }

    user agent stylesheetinput,
    textarea,
    keygen,
    select,
    button {
      text-rendering: auto;
      color: initial;
      letter-spacing: normal;
      word-spacing: normal;
      text-transform: none;
      text-indent: 0px;
      text-shadow: none;
      display: inline-block;
      text-align: start;
      margin: 0.5em 0em 0em 0em;
      font: 13.3333px Arial;
    }


    /*End Drop Down*/



    /**********Slider Arraow CSS************/
    .jssora03l,
    .jssora03r,
    .jssora03ldn,
    .jssora03rdn {
      position: absolute;
      cursor: pointer;
      display: block;
      background: url(img/a03.png) no-repeat;
      overflow: hidden;
    }

    .jssora03l {
      background-position: -3px -33px;
    }

    .jssora03r {
      background-position: -63px -33px;
    }

    .jssora03l:hover {
      background-position: -243px -33px;
    }

    .jssora03r:hover {
      background-position: -303px -33px;
    }

    .jssora03ldn {
      background-position: -243px -33px;
    }

    .jssora03rdn {
      background-position: -303px -33px;
    }

    /**************************/
    @media (max-width:768px) {
      .widget-content {
        min-height: 180px;
      }

      .innerCanvasContainer_refresh {
        position: relative;
        /*  margin-left: 100px; */

      }
    }

    @media (max-width:480px) {
      .widget-content {
        min-height: 120px;
      }
    }

    @media (max-width:415px) {
      .widget-content {
        min-height: 120px;
      }
    }

    @media (max-width:375px) {
      .widget-content {
        min-height: 120px;
      }
    }

    @media (max-width:360px) {
      .widget-content {
        min-height: 120px;
      }
    }

    @media (max-width:330px) {
      .widget-content {
        min-height: 130px;
      }
    }
  </style>
  <style>
    .widget-header {
      height: 46px !important;
    }

    .tab-content {
      display: block !important;
    }

    /* .container {
      padding-left: 10px !important;
      padding-right: 10px !important;
    } */

    h2#THREE_GRAPH_BOX_NEW {
      display: none !important;
    }
  </style>
</head>

<body>

  <!-- start main container -->
  <div class="main">
    <div class="main-inner">
      <div class="custom-tabs"></div>
      <div class="container" style="">

        <div class="widget-header top-header-home" style="margin-left: -10px !important;">

          <?php
          define(__NETWORK_TEXT__, 'Network');
          $get_service_address = $db->selectDB("SELECT * FROM `exp_mno_distributor` WHERE distributor_code='$user_distributor'");


          foreach ($get_service_address['data'] as $rows_add) {

            $bussiness_address1 = $rows_add['bussiness_address1'];
            $bussiness_address2 = $rows_add['bussiness_address2'];
            $bussiness_address3 = $rows_add['bussiness_address3'];

            $bussiness_address = $bussiness_address1 . ', ' . $bussiness_address2 . ', ' . $bussiness_address3;
          }

          ?>
          <!-- <i class="icon-cloud"></i> -->
          <h3><?php if($property_wired != 1){ echo __WIFI_TEXT__;}
           ?> Network Information ( <?php echo trim($bussiness_address, ', '); ?> )</h3>
        </div><!-- /widget-header -->

        <!--Dash Section Tabs -->
        <ul id="myTabDash" class="nav nav-tabs newTabs">

          <?php
          $graph_number = 0;

          $graph_number1 = 0;

          ////Dash Board Sections//////////
          $get_section_code_q = "SELECT u.`section_code` AS a,s.`section_name` AS b FROM `dashboard_sections` s,`dashboard_sections_user_type` u  WHERE u.`section_code`=s.`section_code`
AND `dashboard_code`='DASH01' AND u.user_group='$user_group' AND u.is_enable=1 ORDER BY order_number ASC";
          $get_section_code = $db->selectDB($get_section_code_q);

          $section_array = array();
          $a = 0;


          //$feture_section_guest_array= explode(",",$package_functions->getOptions('DASH_GUEST_SECTIONS',$system_package));
          //print_r($feture_section_guest_array);
          //$feture_section_private_array= explode(",",$package_functions->getOptions('DASH_PRIVATE_SECTIONS',$system_package));

          $vernum = $db->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'");
          $nettype = $db->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
          //print_r($feture_section_array['guest']);
          if ($nettype == 'BOTH' || $nettype == 'PUBLIC-PRIVATE') {
            $q = "SELECT ssid,wlan_name FROM exp_locations_ssid_private WHERE distributor='$user_distributor'
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid WHERE distributor = '$user_distributor' AND network_method<>'MDO'";

            $fesegparray = array_merge($feture_section_array['guest'], $feture_section_array['private']);
          } elseif ($nettype == 'GUEST' || $nettype == 'PUBLIC') {
            $q = "SELECT ssid,wlan_name FROM exp_locations_ssid WHERE distributor = '$user_distributor' AND network_method<>'MDO'";

            $fesegparray = $feture_section_array['guest'];
          } elseif ($nettype == 'PRIVATE') {
            $q = "SELECT ssid,wlan_name FROM exp_locations_ssid_private WHERE distributor='$user_distributor'";

            $fesegparray = $feture_section_array['private'];
          } elseif ($nettype == 'VT') {
            $q = "SELECT ssid,wlan_name FROM exp_locations_ssid_vtenant WHERE distributor = '$user_distributor'";
            $fesegparray = $feture_section_array['vt'];
          } elseif ($nettype == 'VT-BOTH') {
            $q = "SELECT ssid,wlan_name FROM exp_locations_ssid_private WHERE distributor='$user_distributor'
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid WHERE distributor = '$user_distributor' AND network_method<>'MDO'
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid_vtenant WHERE distributor = '$user_distributor'";
            $fesegparray = array_merge($feture_section_array['vt'], $feture_section_array['guest'], $feture_section_array['private']);
          } elseif ($nettype == 'VT-GUEST') {
            $q = "SELECT ssid,wlan_name FROM exp_locations_ssid WHERE distributor = '$user_distributor' AND network_method<>'MDO'
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid_vtenant WHERE distributor = '$user_distributor'";

            $fesegparray = array_merge($feture_section_array['vt'], $feture_section_array['guest']);
          } elseif ($nettype == 'VT-PRIVATE') {
            $q = "SELECT ssid,wlan_name FROM exp_locations_ssid_private WHERE distributor='$user_distributor'         
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid_vtenant WHERE distributor = '$user_distributor'";

            $fesegparray = array_merge($feture_section_array['vt'], $feture_section_array['private']);
          } else {
            $q = "SELECT ssid,wlan_name FROM exp_locations_ssid_private WHERE distributor='$user_distributor'
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid WHERE distributor = '$user_distributor' AND network_method<>'MDO'
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid_vtenant WHERE distributor = '$user_distributor'";

            $fesegparray = array();
          }
          $network_names = $db->selectDB($q);

          $fesegparray = array_unique($fesegparray);
          /*print_r($fesegparray);*/

          $WLAN_select_graph_list = json_decode($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT', $system_package), true);
          $WLAN_select_graph_list_des = $package_functions->getSectionType('DSF_GRAPH_WLAN_SELECT', $system_package);
          //$WLAN_select_graph_list_drop = json_decode($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT_DROP',$system_package),true);
          //print_r($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT',$system_package));
          //$advanced_features=$db->getValueAsf("SELECT `advanced_features` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");
          $row = $db->select1DB("SELECT `advanced_features`,`other_settings`,`ap_controller` FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");
          $advanced_features = $row['advanced_features'];
          $other_settings = $row['other_settings'];
          $ap_controller = $row['ap_controller'];
          $controller_query = "SELECT api_profile FROM `exp_locations_ap_controller` WHERE controller_name='$ap_controller'";
          $controller_query_results = $db->select1DB($controller_query);

          $noQueryClientApi = false;

          if (strpos($controller_query_results['api_profile'], 'Ruckus') !== false) {
            $v = substr(preg_replace('/[^0-9]/', '', $controller_query_results['api_profile']), 0, 2);
            if($v < 35){
              $noQueryClientApi = true;
            }
          }

          $other_settings = json_decode($other_settings, true);
          $big_properties = false;
          if (array_key_exists("big_properties", $other_settings)) {
            if ($other_settings['big_properties'] == 1) {
              $big_properties = true;
            }
          }

          $srch1 = array_search('NVI_TREE_SEC_COX', $fesegparray);
          $srch2 = array_search('NVI_TREE_SEC_COX_NEW', $fesegparray);
          if ($srch1 !== false && $srch2 !== false) {
            if ($big_properties) {
              unset($fesegparray[$srch1]);
            } else {
              unset($fesegparray[$srch2]);
            }
          }
          $overview_disabele = false;

          if (strlen($advanced_features) > 0) {

            $advanced_features = json_decode($advanced_features, true);

            foreach ($fesegparray as $key => $value) {
              /*if($advanced_features[$value] == '0'){
      unset($fesegparray[$key]);
    }*/

              if ($advanced_features['network_at_a_glance'] == '0' && $value == 'NVI_TREE_SEC_COX') {

                $overview_disabele = "disabele";
                unset($fesegparray[$key]);
              }

              if ($advanced_features['top_applications'] == '0' && $value == 'DSF_TOP_APP_COX') {
                unset($fesegparray[$key]);
              }
            }
          }


          $psndg_count = count($fesegparray);

          //dashsections
          foreach ($get_section_code['data'] as $rows) {

            $section_code = $rows[a];
            if ($property_wired == 1) {
              if ($rows['b'] == 'Network') {
                $rows['b'] = 'Summary';
              }
              $section_name = str_replace('{$wifi_txt}', '', $rows['b']);
            }else{
              if ($rows['b'] == 'Network') {
                $rows['b'] = 'Summary';
              }
              $section_name = str_replace('{$wifi_txt}', '', $rows['b']);
            }
            

            if ($section_code == 'NVI_TREE_SEC_ALT' && $property_business_type != 'SMB')
              continue;

            if (($section_code == 'CLIENT_DETAILS' || $section_code == 'DSF_TOP_APP_COX') && $property_wired == '1')
              continue;
              
            if ($section_code == 'CLIENT_DETAILS' && $noQueryClientApi)
              continue;

            if ($section_code == 'NVI_TREE_SEC_OPT' && $property_business_type == 'SMB' && ($system_package == 'LP_SIMP_001_New' || $system_package == 'LP_SIMP_Optimum_New' || $system_package == 'LP_SIMP_Suddenlink_New'))
              continue;


            if ($psndg_count == 0) {

              if (in_array($section_code, $feture_section_array) || $package_features == "all") {
                $section_array[$a] = $section_code;

                if (isset($_GET['t'])) {

                  if ($a == $_GET['t']) {
                    $tab_open = 'class="active"';
                    $i_open = 'class="clicked"';
                  } else {
                    $tab_open = '';
                    $i_open = '';
                  }
                } else {

                  if ($a == 0) {
                    $tab_open = 'class="active"';
                    $i_open = 'class="clicked"';
                  } else {
                    $tab_open = '';
                    $i_open = '';
                  }
                }


                echo '<li ' . $tab_open . '><a ' . $i_open . ' href="#dash_section_tab_' . $a . '" data-toggle="tab">' . $section_name . '</a></li>';


                $a++;
              }
            } else {

              if (in_array($section_code, $fesegparray) || $package_features == "all") {
                $section_array[$a] = $section_code;

                if (isset($_GET['t'])) {

                  if ($a == $_GET['t']) {
                    $tab_open = 'class="active"';
                    $i_open = 'class="clicked"';
                  } else {
                    $tab_open = '';
                    $i_open = '';
                  }
                } else {

                  if ($a == 0) {
                    $tab_open = 'class="active"';
                    $i_open = 'class="clicked"';
                  } else {
                    $tab_open = '';
                    $i_open = '';
                  }
                }


                echo '<li ' . $tab_open . '><a ' . $i_open . ' href="#dash_section_tab_' . $a . '" data-toggle="tab">' . $section_name . '</a></li>';

                $a++;
              }
            }
          } //dashsections

          ?>
        </ul>

        <!--Dash Section Start All Tabs-->

        <?php

        $new_design = 'yes';
        if ($new_design == 'yes') {

          $home_inner = 'layout/' . $camp_layout . '/views/home_inner.php';

          if (file_exists($home_inner)) {
            include_once $home_inner;
          }
        }

        ?>
        <div id="myTabContentDASH" class="tab-content">
          <?php
          //print_r($feture_section_array);
          //print_r($section_array);
          $b = 0;

          foreach ($section_array as $secKey => $section_code) { //section_body
            //if(in_array($section_code,$feture_section_array) || $package_features=="all"){


            if ($section_code == 'NVI_TREE_SEC_ALT' && $property_business_type != 'SMB')
              continue;

            if ($section_code == 'CLIENT_DETAILS' && $property_wired == '1')
              continue;

            if ($section_code == 'NVI_TREE_SEC_OPT' && $property_business_type == 'SMB' && ($system_package == 'LP_SIMP_001_New' || $system_package == 'LP_SIMP_Optimum_New' || $system_package == 'LP_SIMP_Suddenlink_New'))
              continue;

            if (isset($_GET['t'])) {
              if ($b == $_GET['t']) {
                $section_tab = 'in active';
              } else {

                $section_tab = 'fade';
              }
            } else {

              if ($b == 0) {
                $section_tab = 'in active';
              } else {

                $section_tab = 'fade';
              }
            }
          ?>
            <!-- Tab 1 start-->
            <div class="tab-pane <?php echo $section_tab; ?>" id="dash_section_tab_<?php echo $secKey; ?>" align="center">

              <!-- do not remove this div - it is here because of a purpose -->
              <?php

              $var24 = 'graphGroup24' . $secKey;
              $var7 = 'graphGroup7' . $secKey;
              $var30 = 'graphGroup30' . $secKey;
              $var12 = 'graphGroup12' . $secKey;
              $varqua = 'graphGroupQua' . $secKey;
              $$var24 = '';
              $$var7 = '';
              $$var30 = '';
              $$var12 = '';
              $$varqua = '';

              /////quick view tabs///
              $quick_tab_array = array();

              /*echo $tab_name_q = "SELECT DISTINCT b.tab_name AS a FROM dashboard_quick_data d , dashboard_quick_menu_box b,dashboard_quick_menu m
     WHERE b.menu_code=m.menu_code AND d.box_code=b.box_code AND d.distributor='$user_distributor' AND m.section_code='$section_code'";*/
              $tab_name_q = "SELECT DISTINCT  b.tab_name AS a
FROM dashboard_quick_menu m JOIN dashboard_quick_menu_box b ON b.menu_code = m.menu_code
WHERE m.section_code='$section_code'";

              //$tab_name_q = "SELECT DISTINCT d.`tab_name` AS a,m.description as b FROM `dashboard_quick_menu_data` d,`dashboard_quick_menu` m WHERE d.`menu_code`=m.`menu_code` AND m.`section_code`='$section_code' AND d.`distributor`='$user_distributor'";

              $tab_data_ex = $db->selectDB($tab_name_q);

              if ($tab_data_ex['rowCount'] > 0) { ////quick_view
                ///

                $c = 0;
                foreach ($tab_data_ex['data'] as $rows) { //w1

                  $quick_tab_array[$c][0] = strtoupper($rows[a]);
                  $quick_tab_array[$c][1] = $rows[a];
                  //$quick_view_box_name=$rows[b];


                  $c++;
                } //w1


                //print_r($quick_tab_array);

                //////////////////////////////////////////////////////////////////////////////

              ?>

                <!--Slider JS Start-->
                <script>
                  jQuery(document).ready(function($) {

                    <?php if (false) {  ?>
                      var options = {
                        $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                        $AutoPlaySteps: 3, //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                        $AutoPlayInterval: 4000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                        $PauseOnHover: 1, //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                        $ArrowKeyNavigation: true, //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                        $SlideDuration: 160, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                        $MinDragOffsetToSlide: 20, //[Optional] Minimum drag offset to trigger slide , default value is 20
                        $SlideWidth: 150, //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                        //$SlideHeight: 150,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                        $SlideSpacing: 10, //[Optional] Space between each slide in pixels, default value is 0
                        $DisplayPieces: 6, //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                        $ParkingPosition: 0, //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                        $UISearchMode: 1, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                        $PlayOrientation: 1, //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                        $DragOrientation: 1, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                        $BulletNavigatorOptions: { //[Optional] Options to specify and enable navigator or not
                          $Class: $JssorBulletNavigator$, //[Required] Class to create navigator instance
                          $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                          $AutoCenter: 0, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                          $Steps: 1, //[Optional] Steps to go for each navigation request, default value is 1
                          $Lanes: 1, //[Optional] Specify lanes to arrange items, default value is 1
                          $SpacingX: 0, //[Optional] Horizontal space between each item in pixel, default value is 0
                          $SpacingY: 0, //[Optional] Vertical space between each item in pixel, default value is 0
                          $Orientation: 1 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                        },

                        $ArrowNavigatorOptions: {
                          $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                          $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                          $AutoCenter: 2, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                          $Steps: 3 //[Optional] Steps to go for each navigation request, default value is 1
                        }
                      };



                      <?php



                      if (sizeof($quick_tab_array) > 0) {
                        $d = 0;
                        foreach ($quick_tab_array as $tab_data_key => $tab_data) { ?>
                          var jssor_slider_tab_<?php echo $section_code . '_' . $d; ?> = new $JssorSlider$("slider_container_<?php echo $section_code . '_' . $d;  ?>", options);
                      <?php
                          $d++;
                        }
                      }
                      ?>



                      //responsive code begin
                      //you can remove responsive code if you don't want the slider scales while window resizes
                      function ScaleSlider() {
                        var bodyWidth = document.body.clientWidth;
                        if (bodyWidth) {
                          <?php
                          if (sizeof($quick_tab_array) > 0) {
                            $e = 0;
                            foreach ($quick_tab_array as $tab_data_key => $tab_data) { ?>
                              jssor_slider_tab_<?php echo $section_code . '_' . $e; ?>.$ScaleWidth(Math.min(bodyWidth, 960));
                          <?php
                              $e++;
                            }
                          }
                          ?>



                        } else {
                          window.setTimeout(ScaleSlider, 30);
                        }
                      }
                      ScaleSlider();

                      $(window).bind("load", ScaleSlider);
                      $(window).bind("resize", ScaleSlider);
                      //  $(window).bind("orientationchange", ScaleSlider);
                      //   $('#loading').hide();
                      //responsive code end


                    <?php } ?>




                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                  });
                </script>


                <!-- Silder JS end -->









                <?php if (sizeof($quick_tab_array) > 0) { //q  
                ?>
                  <div class="widget widget-nopad trans-wid quick<?php echo $b; ?>" style="margin-bottom: 5px !important;">
                    <!--  <div class="widget-header"><div style="text-align:left;"><i class="icon-list-alt"></i>
              <h3> <?php //echo $quick_view_box_name;
                    ?> </h3></div>

            </div> -->

                    <!-- /widget-header -->
                    <div class="widget-content trans-wid-con">
                      <div class="widget big-stats-container trans-wid">

                        <div class="widget-content trans-wid-con">

                          <div class="home-white-top">

                          </div>
                          <div class="home-white-bottom">

                          </div>

                          <div id="big_stats" class="cf">

                            <!--<script type="text/javascript">


                                 $(document).ready( function(){
                                     $( ".replace_div_<?php /*echo $b;*/ ?>" ).replaceWith( $( ".quick<?php /*echo $b;*/ ?>" ) );
                                 });
                             </script>-->

                            <!-- Tabs -->
                            <ul id="myQuickTab" class="nav nav-tabs myQuickTab<?php echo $b; ?>" style="border-bottom:unset;">

                              <?php
                              $new_design = 'yes';
                              if ($new_design == 'yes') { ?>

                                <script type="text/javascript">
                                  $(document).ready(function() {

                                    if ($(window).width() < 768) {
                                      $('.myQuickTab<?php echo $b; ?>').ulSelect();
                                    }

                                  });
                                </script>


                              <?php

                              }
                              $f = 0; //print_r($quick_tab_array);
                              foreach ($quick_tab_array as $tab_data_key => $tab_data) {


                                switch ($tab_data[0]) {
                                  case '24-HOURS': {
                                      $postfix = '24H';
                                      $range = 'last_24_hours';
                                      break;
                                    }
                                  case '7-DAYS': {
                                      $postfix = '7D';
                                      $range = 'last_7_days';
                                      break;
                                    }
                                  case '30-DAYS': {
                                      $postfix = '30D';
                                      $range = 'last_30_days';
                                      break;
                                    }
                                  case '12-MONTHS': {
                                      $postfix = '12M';
                                      $range = 'last_12_months';
                                      break;
                                    }
                                  case 'QUARTERLY': {
                                      $postfix = '12MQ';
                                      $range = 'quarterly';
                                      break;
                                    }
                                }


                                $onclick = 'load_data_to_DSF_total_sessions_total_visit_' . $postfix . '("sessions","' . $range . '","API");' . 'load_data_to_DSF_total_download_' . $postfix . '("bandwidth","' . $range . '","API");' . 'load_data_to_DSF_os_trend_' . $postfix . '("os","' . $range . '","API");';
                                if ($f == 0) {
                                  $dash_tab_open = 'class="active"';
                                  $onclick_init = $onclick;
                                } else {
                                  $dash_tab_open = '';
                                }

                                $onclickGroup = '';

                                switch ($tab_data[0]) {
                                  case '24-HOURS': {
                                      $$var24 .= $onclick;
                                      $onclickGroup = $var24 . '();';
                                      break;
                                    }
                                  case '7-DAYS': {
                                      $$var7 .= $onclick;
                                      $onclickGroup = $var7 . '();';
                                      break;
                                    }
                                  case '30-DAYS': {
                                      $$var30 .= $onclick;
                                      $onclickGroup = $var30 . '();';
                                      break;
                                    }
                                  case '12-MONTHS': {
                                      $$var12 .= $onclick;
                                      $onclickGroup = $var12 . '();';
                                      break;
                                    }
                                  case 'QUARTERLY': {
                                      $$varqua .= $onclick;
                                      $onclickGroup = $varqua . '();';
                                      break;
                                    }
                                }

                                if ($dash_link_group == 'ENABLE') {
                                  $onclickWithGroup = $onclickGroup;
                                } else {
                                  $onclickWithGroup = $onclick;
                                }

                              ?>
                                <li <?php echo $dash_tab_open; ?>><a href="#dash_tab_<?php echo $section_code . '_' . $f; ?>" data-toggle="tab" onclick='<?php echo $onclickWithGroup; ?>'><?php echo $tab_data[1]; ?></a></li>

                              <?php

                                $f++;
                              }

                              if ($dash_link_group == 'ENABLE') {
                                /*if ($b == 2) {
                                  echo '<li><a href="javascript:void(0)" data-toggle="tab" onclick="' . $varqua . '();">Quarterly</a></li>';
                                }
                                if ($b == 3) {
                                  echo '<li><a href="javascript:void(0)" data-toggle="tab" onclick="' . $varqua . '();">Total Sessions</a></li>';
                                }*/
                                  if ($section_code == 'ARRIS_CDR_API_GRAPH') {
                                      echo '<li><a href="javascript:void(0)" data-toggle="tab" onclick="' . $varqua . '();">Quarterly</a></li>';
                                  }
                                  if ($section_code == 'Gender_Age_Group_GENERIC') {
                                      echo '<li><a href="javascript:void(0)" data-toggle="tab" onclick="' . $varqua . '();">Total Sessions</a></li>';
                                  }
                              }

                              ?>
                            </ul>


                            <!--tab start-->
                            <div id="myTabContentQuick" class="tab-content" style="border:none;!important;">

                              <div class="tab-pane" id="dash_tab_ARRIS_CDR_API_GRAPH_1_QUA<?php echo $b; ?>" align="center">
                                <!-- Tab Quick View  start-->

                                <!-- Jssor Slider Begin -->
                                <!-- You can move inline styles to css file or css block. -->




                                <div class="secs_container" id="">

                                  <h2 class="head container">
                                    Some Highlights First..

                                  </h2>
                                  <br>
                                  <br>

                                  <section id="counter" class="counter">
                                    <div class="main_counter_area">
                                      <div class="overlay p-y-3">
                                        <div class="containyer">
                                          <div class="">
                                            <div class="main_counter_content text-center white-text wow fadeInUp">


                                              <div class="col-md-3 quick-box sessions last_7_days">
                                                <div class="single_counter p-y-2 m-t-1">

                                                  <div id="" style=""><i id="" class="show icon- highlight icon-group" style="color:#fff;visibility: hidden;"></i>
                                                    <h2 id="">N/A</h2><br>
                                                    <font id="" style="visibility: hidden;">Unique<br>Clients</font>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-3 quick-box sessions last_7_days">
                                                <div class="single_counter p-y-2 m-t-1">

                                                  <div id="" style=""><i id="" class="show icon- highlight icon-group" style="color:#fff;visibility: hidden;"></i>
                                                    <h2 id="">N/A</h2><br>
                                                    <font id="" style="visibility: hidden;">Unique<br>Clients</font>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-3 quick-box sessions last_7_days">
                                                <div class="single_counter p-y-2 m-t-1">

                                                  <div id="" style=""><i id="" class="show icon- highlight icon-group" style="color:#fff;visibility: hidden;"></i>
                                                    <h2 id="">N/A</h2><br>
                                                    <font id="" style="visibility: hidden;">Unique<br>Clients</font>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-3 quick-box sessions last_7_days">
                                                <div class="single_counter p-y-2 m-t-1">

                                                  <div id="" style=""><i id="" class="show icon- highlight icon-group" style="color:#fff;visibility: hidden;"></i>
                                                    <h2 id="">N/A</h2><br>
                                                    <font id="" style="visibility: hidden;">Unique<br>Clients</font>
                                                  </div>
                                                </div>
                                              </div>
                                              <?php if ($b == 2) { ?>
                                                <div class="col-md-3 quick-box sessions last_7_days">
                                                  <div class="single_counter p-y-2 m-t-1">

                                                    <div id="" style=""><i id="" class="show icon- highlight icon-group" style="color:#fff;visibility: hidden;"></i>
                                                      <h2 id="">N/A</h2><br>
                                                      <font id="" style="visibility: hidden;">Unique<br>Clients</font>
                                                    </div>
                                                  </div>
                                                </div>
                                              <?php } ?>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="mobile-menu"><span class="clicked" onclick="set_btn(0,this);">f</span><span onclick="set_btn(1,this);">f</span><span onclick="set_btn(2,this);">f</span><span onclick="set_btn(3,this);">f</span><span onclick="set_btn(4,this);">f</span></div>
                                    </div>
                                  </section><!-- End of counter Section -->


                                </div>



                                <!-- Jssor Slider End -->



                                <!-- Tab Quick View End-->
                              </div>
                              <?php
                              $g = 0;

                              foreach ($quick_tab_array as $tab_data_key => $tab_data) { //for1
                                if ($g == 0) {
                                  $dash_tab_contain_tag = 'in active';
                                } else {
                                  $dash_tab_contain_tag = 'fade';
                                }

                                $value_a = $tab_data[0];
                                $value_b = $tab_data[1];


                              ?>

                                <div class="tab-pane <?php echo $dash_tab_contain_tag; ?>" id="dash_tab_<?php echo $section_code . '_' . $g; ?>" align="center">
                                  <!-- Tab Quick View  start-->

                                  <!-- Jssor Slider Begin -->
                                  <!-- You can move inline styles to css file or css block. -->

                                  <?php
                                  $new_design = 'yes';
                                  if ($new_design != 'yes') { ?>


                                    <div id="slider_container_<?php echo $section_code . '_' . $g; ?>">


                                      <section id="counter" class="counter">
                                        <div class="main_counter_area">
                                          <div class="overlay p-y-3">
                                            <div class="containyer">
                                              <div class="">
                                                <div class="main_counter_content text-center white-text wow fadeInUp old-style">


                                                  <?php


                                                  $testi = 0;


                                                  $query = "SELECT d.icon,d.top_text,d.value,d.bottom_text,t0.data_loading_type , t0.tab_name ,t0.box_code FROM
                                                  (SELECT t1.*,t2.*
                                                    FROM
                                                    (
                                                      SELECT b.box_code,b.tab_name,b.tab_number,b.data_loading_type
                                                      FROM dashboard_quick_menu m JOIN dashboard_quick_menu_box b ON b.menu_code = m.menu_code
                                                      WHERE m.section_code='$section_code' AND b.tab_name='$value_b'
                                                    ) t1 LEFT JOIN (SELECT distributor_code FROM exp_mno_distributor WHERE distributor_code = '$user_distributor') t2 ON 1=1
                                                  ) t0
                                                 LEFT JOIN dashboard_quick_data d ON d.box_code=t0.box_code AND d.distributor = t0.distributor_code";



                                                  $query_results = $db->selectDB($query);
                                                  if ($query_results['rowCount'] == '0') {
                                                    $top_text = 'Total';
                                                    $bottom_text = 'Users';
                                                    $val_text = '0';

                                                    if ($dash_quick_view_top_value == 'icon') {
                                                      echo '<i class="show icon-group" style="color:#fff;"></i>';
                                                    } else {
                                                      echo $top_text;
                                                    }

                                                    echo '<' . $middle_text_h_style . ' >' . $val_text . '</' . $middle_text_h_style . '><font color="#fff;">' . $bottom_text . '</font></div>';
                                                  } else {

                                                    foreach ($query_results['data'] as $row) {

                                                      $top_text = $row['top_text'];
                                                      $bottom_text = $row['bottom_text'];
                                                      $val_text = $row['value'];
                                                      $icon = $row['icon'];
                                                      $data_loading_type = $row['data_loading_type'];
                                                      $box_code = $row['box_code'];

                                                      if ($data_loading_type == 'ajax') {
                                                        $loading_display = 'unset';
                                                        $div_display = 'none';
                                                      } else {
                                                        $loading_display = 'none';
                                                        $div_display = 'unset';
                                                      }

                                                      echo '<div class="col-md-3 old-style">
                                    <div class="single_counter p-y-2 m-t-1">
                                    <img class="ajax-loader" id="loading_' . $box_code . '" src="img/rm_loading.gif" style="padding-bottom: 5px; width: 125px;display: ' . $loading_display . '">
                                    <div id="quick-box-' . $box_code . '" style="display: ' . $div_display . '" >';

                                                      //Top Icon or Top text//
                                                      if ($dash_quick_view_top_value == 'icon') {

                                                        $icon_array = explode(",", $icon);
                                                        echo '<i id="box-icon1-' . $box_code . '" class="show icon-' . $icon_array[0] . '" style="color: #fff;display: block!important;"></i>';

                                                        if (strlen($icon_array[1]) > 0) {
                                                          echo '&nbsp;<i id="box-icon2-' . $box_code . '" class="show icon-' . $icon_array[1] . '" style="color:#fff;"></i>';
                                                        }
                                                      } else {
                                                        echo $top_text;
                                                      }


                                                      //Value///
                                                      echo '<h2 id="quick_box_h2' . $box_code . '" >' . $val_text . '</h2>';


                                                      if ($dash_quick_view_top_value == 'icon') {

                                                        echo '<br/><font id="box-font-' . $box_code . '" >' . $top_text . '<br> ' . $bottom_text . '</font>';
                                                      } else {

                                                        echo '<br/><font id="box-font-' . $box_code . ' >' . $bottom_text . '</font>';
                                                      }

                                                      if ($data_loading_type == 'ajax') {
                                                        echo '<script>

                                                                var load_data_to_' . $box_code . '_run=false;
                                                                function load_data_to_' . $box_code . '(category,range,type)
                                                                {
                                                                  /*type="local";*/
                                                                    var data_parm = {category:category,range:range};
                                                                    var api_data = JSON.stringify(data_parm);


                                                                    if(load_data_to_' . $box_code . '_run) {return false}
                                                                    load_data_to_' . $box_code . '_run = true;

                                                                    var data = {quick_box_code: "' . $box_code . '",distributor:"' . $user_distributor . '",source:type,type:"quick",graphData:api_data};
                                                                    $.ajax({
                                                                        url: "ajax/arris_graphs.php",
                                                                        type: "POST",
                                                                        data: data,
                                                                        success: function (data) {

                                                                            var icon=$(\'#box-icon1-' . $box_code . '\');
                                                                            var h2=$(\'#quick_box_h2' . $box_code . '\');
                                                                            var font=$(\'#box-font-' . $box_code . '\');

                                                                            icon.removeClass(function (index, className) {
                                                                                return (className.match (/(^|\s)icon-\S+/g) || []).join(\' \');
                                                                            });

                                                                            var obj = JSON.parse(data);

                                                                            if(obj.icon==null){
                                                                                obj.icon = "exclamation";
                                                                            }
                                                                            if(obj.value==null){
                                                                                obj.value = "0";
                                                                            }
                                                                            if(obj.top_text==null && obj.bottom_text==null){
                                                                                obj.top_text = "No Data";
                                                                                obj.bottom_text = "Available";
                                                                            }
                                                                              $("#' . $box_code . '").addClass(category);
                                                                              $("#' . $box_code . '").addClass(range);
                                                                              $("#' . $box_code . '").append(obj.click_jump_script.jsScript);
                                                                              eval(document.getElementById(obj.click_jump_script.script_id));
                                                                            icon.addClass("icon-"+obj.icon);                                                                          
                                                                            icon.addClass("icon-"+obj.icon);
                                                                            h2.html(obj.value);
                                                                            font.html(obj.top_text+"<br>"+obj.bottom_text);
                                                                            $("#loading_' . $box_code . '").hide();
                                                                            $("#quick-box-' . $box_code . '").show();
                                                                        }
                                                                    });

                                                                }
                                                                </script>';
                                                      }

                                                      echo '</div></div></div>';

                                                      $testi++;
                                                    }
                                                  }
                                                  ?>


                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <?php

                                          /*echo '<div class="mobile-menu">';
                                                         for ($i = 0; $i < $testi ; $i++) {

                                                             if($i == 0){
                                                                 echo '<span class="clicked" onclick="set_btn('.$i.',this);">f</span>';
                                                             }
                                                             else{
                                                                 echo '<span onclick="set_btn('.$i.',this);">f</span>';

                                                             }
                                                         }

                                                         echo '</div>';*/

                                          ?>
                                        </div>
                                      </section><!-- End of counter Section -->


                                    </div>
                                  <?php } else { ?>



                                    <div class="secs_container" id="slider_container_<?php echo $section_code . '_' . $g; ?>">

                                      <h2 class="head container">
                                        Some Highlights First..

                                      </h2>
                                      <br>
                                      <br>

                                      <section id="counter" class="counter">
                                        <div class="main_counter_area">
                                          <div class="overlay p-y-3">
                                            <div class="containyer">
                                              <div class="">
                                                <div class="main_counter_content text-center white-text wow fadeInUp">


                                                  <?php

                                                  $ent_box = ['AAA_session_24H', 'AAA_session_7D', 'AAA_session_30D', 'AAA_session_12M'];


                                                  $testi = 0;


                                                  $query = "SELECT d.icon,d.top_text,d.value,d.bottom_text,t0.data_loading_type , t0.tab_name ,t0.box_code FROM
                                                                                  (SELECT t1.*,t2.*
                                                                                    FROM
                                                                                    (
                                                                                      SELECT b.id, b.box_code,b.tab_name,b.tab_number,b.data_loading_type
                                                                                      FROM dashboard_quick_menu m JOIN dashboard_quick_menu_box b ON b.menu_code = m.menu_code
                                                                                      WHERE m.section_code='$section_code' AND b.tab_name='$value_b'
                                                                                    ) t1 LEFT JOIN (SELECT distributor_code FROM exp_mno_distributor WHERE distributor_code = '$user_distributor') t2 ON 1=1
                                                                                  ) t0
                                                                                 LEFT JOIN dashboard_quick_data d ON d.box_code=t0.box_code AND d.distributor = t0.distributor_code ORDER BY t0.id";



                                                  $query_results = $db->selectDB($query);
                                                  if ($query_results['rowCount'] == '0') {
                                                    $top_text = 'Total';
                                                    $bottom_text = 'Users';
                                                    $val_text = '0';

                                                    if ($dash_quick_view_top_value == 'icon') {
                                                      echo '<i class="show icon-group" style="color:#fff;"></i>';
                                                    } else {
                                                      echo $top_text;
                                                    }

                                                    echo '<' . $middle_text_h_style . ' >' . $val_text . '</' . $middle_text_h_style . '><font color="#fff;">' . $bottom_text . '</font></div>';
                                                  } else {

                                                    foreach ($query_results['data'] as $row) {



                                                      $top_text = $row['top_text'];
                                                      $bottom_text = $row['bottom_text'];
                                                      $val_text = $row['value'];
                                                      $icon = $row['icon'];
                                                      $data_loading_type = $row['data_loading_type'];
                                                      $box_code = $row['box_code'];

                                                      if (in_array($box_code, $ent_box) && $property_business_type != 'ENT')
                                                        continue;
                                                      //echo $property_business_type;
                                                      if ($data_loading_type == 'ajax') {
                                                        $loading_display = 'unset';
                                                        $div_display = 'none';
                                                      } else {
                                                        $loading_display = 'none';
                                                        $div_display = 'unset';
                                                      }

                                                      echo '<div class="col-md-3 quick-box" id="' . $box_code . '" >';
                                                      if ($data_loading_type == 'ajax') {
                                                        if (strpos($box_code, 'DSF_total_visit') !== false) {
                                                          $hr = substr($box_code, 15);
                                                          echo '<script type="text/javascript">

                                                                let load_data_to_DSF_total_sessions_total_visit' . $hr . '_run=false;
                                                                function load_data_to_DSF_total_sessions_total_visit' . $hr . '(category,range,type)
                                                                {
                                                                  /*type="local";*/
                                                                    var data_parm = {category:category,range:range};
                                                                    var api_data = JSON.stringify(data_parm);


                                                                    if(load_data_to_DSF_total_sessions_total_visit' . $hr . '_run) {return false}
                                                                    load_data_to_DSF_total_sessions_total_visit' . $hr . '_run = true;

                                                                    var data = {quick_box_code: "' . $box_code . '",distributor:"' . $user_distributor . '",source:type,type:"quick",graphData:api_data};
                                                                    $.ajax({
                                                                        url: "ajax/arris_graphs.php",
                                                                        type: "POST",
                                                                        data: data,
                                                                        success: function (data) {
                                                                        
                                                                       
                                                                            var icon=$(\'#box-icon1-' . $box_code . '\');
                                                                            var h2=$(\'#quick_box_h2' . $box_code . '\');
                                                                            var font=$(\'#box-font-' . $box_code . '\');
                                                                       
                                                                            var icon1=$(\'#box-icon1-DSF_total_sessions' . $hr . '\');
                                                                            var h21=$(\'#quick_box_h2DSF_total_sessions' . $hr . '\');
                                                                            var font1=$(\'#box-font-DSF_total_sessions' . $hr . '\');

                                                                            icon.removeClass(function (index, className) {
                                                                                return (className.match (/(^|\s)icon-\S+/g) || []).join(\' \');
                                                                            });

                                                                            var obj = JSON.parse(data);

                                                                            if(obj.icon==null){
                                                                                obj.icon = "exclamation";
                                                                            }
                                                                            if(obj.value==null){
                                                                                obj.value = "0";
                                                                            }
                                                                            if(obj.top_text==null && obj.bottom_text==null){
                                                                                obj.top_text = "No Data";
                                                                                obj.bottom_text = "Available";
                                                                            }
                                                                              $("#' . $box_code . '").addClass(category);
                                                                              $("#' . $box_code . '").addClass(range);
                                                                              $("#' . $box_code . '").append(obj.click_jump_script.jsScript);
                                                                              eval(document.getElementById(obj.click_jump_script.script_id));
                                                                            icon.addClass("icon-"+obj.icon);                                                                          
                                                                            icon.addClass("icon-"+obj.icon);
                                                                            h2.html(obj.value);
                                                                            font.html(obj.top_text+"<br>"+obj.bottom_text);
                                                                            $("#loading_' . $box_code . '").hide();
                                                                            $("#quick-box-' . $box_code . '").show();

                                                                            icon1.removeClass(function (index, className) {
                                                                                return (className.match (/(^|\s)icon-\S+/g) || []).join(\' \');
                                                                            });

                                                                            if(obj.icon1==null){
                                                                                obj.icon1 = "exclamation";
                                                                            }
                                                                            if(obj.value1==null){
                                                                                obj.value1 = "0";
                                                                            }
                                                                            if(obj.top_text1==null && obj.bottom_text1==null){
                                                                                obj.top_text1 = "No Data";
                                                                                obj.bottom_text1 = "Available";
                                                                            }
                                                                              $("#DSF_total_sessions' . $hr . '").addClass(category);
                                                                              $("#DSF_total_sessions' . $hr . '").addClass(range);
                                                                              $("#DSF_total_sessions' . $hr . '").append(obj.click_jump_script.jsScript);
                                                                              eval(document.getElementById(obj.click_jump_script.script_id));
                                                                            icon1.addClass("icon-"+obj.icon1);                                                                          
                                                                            icon1.addClass("icon-"+obj.icon1);
                                                                            h21.html(obj.value1);
                                                                            font1.html(obj.top_text1+"<br>"+obj.bottom_text1);
                                                                            $("#loading_DSF_total_sessions' . $hr . '").hide();
                                                                            $("#quick-box-DSF_total_sessions' . $hr . '").show();
                                                                        }
                                                                    });

                                                                }
                                                                </script>';
                                                        } elseif (strpos($box_code, 'DSF_total_sessions') !== false) {
                                                        } else {
                                                          echo '<script type="text/javascript">

                                                                let load_data_to_' . $box_code . '_run=false;
                                                                function load_data_to_' . $box_code . '(category,range,type)
                                                                {
                                                                  /*type="local";*/
                                                                    var data_parm = {category:category,range:range};
                                                                    var api_data = JSON.stringify(data_parm);


                                                                    if(load_data_to_' . $box_code . '_run) {return false}
                                                                    load_data_to_' . $box_code . '_run = true;

                                                                    var data = {quick_box_code: "' . $box_code . '",distributor:"' . $user_distributor . '",source:type,type:"quick",graphData:api_data};
                                                                    $.ajax({
                                                                        url: "ajax/arris_graphs.php",
                                                                        type: "POST",
                                                                        data: data,
                                                                        success: function (data) {
                                                                        
                                                                       
                                                                            var icon=$(\'#box-icon1-' . $box_code . '\');
                                                                            var h2=$(\'#quick_box_h2' . $box_code . '\');
                                                                            var font=$(\'#box-font-' . $box_code . '\');

                                                                            icon.removeClass(function (index, className) {
                                                                                return (className.match (/(^|\s)icon-\S+/g) || []).join(\' \');
                                                                            });

                                                                            var obj = JSON.parse(data);

                                                                            if(obj.icon==null){
                                                                                obj.icon = "exclamation";
                                                                            }
                                                                            if(obj.value==null){
                                                                                obj.value = "0";
                                                                            }
                                                                            if(obj.top_text==null && obj.bottom_text==null){
                                                                                obj.top_text = "No Data";
                                                                                obj.bottom_text = "Available";
                                                                            }
                                                                              $("#' . $box_code . '").addClass(category);
                                                                              $("#' . $box_code . '").addClass(range);
                                                                              $("#' . $box_code . '").append(obj.click_jump_script.jsScript);
                                                                              eval(document.getElementById(obj.click_jump_script.script_id));
                                                                            icon.addClass("icon-"+obj.icon);                                                                          
                                                                            icon.addClass("icon-"+obj.icon);
                                                                            h2.html(obj.value);
                                                                            font.html(obj.top_text+"<br>"+obj.bottom_text);
                                                                            //console.log("done");
                                                                            $("#loading_' . $box_code . '").hide();
                                                                            $("#quick-box-' . $box_code . '").show();
                                                                            //console.log($("#loading_' . $box_code . '").css("display"));
                                                                            //console.log($("#quick-box-' . $box_code . '").css("display"));
                                                                        }
                                                                    });

                                                                }
                                                                </script>';
                                                        }
                                                      }
                                                      if ($data_loading_type == 'realtime') {
                                                        if (in_array($box_code, $ent_box)) {
                                                  ?>
                                                          <script>
                                                            function aaa_session<?php echo $box_code; ?>() {
                                                              const aaa_ajax<?php echo $box_code; ?> = $.ajax({
                                                                url: "src/statistics/ALE_SESSION_API/real_time_index.php?distributor=<?php echo $user_distributor; ?>-G_P&ssid=all",
                                                                type: "GET",
                                                                //data : formData,
                                                                success: function(data) {
                                                                  $('#loading_<?php echo $box_code; ?>').hide();
                                                                  $('#box-icon1-<?php echo $box_code; ?>').removeClass(function(index, className) {
                                                                    return (className.match(/(^|\s)icon-\S+/g) || []).join(' ');
                                                                  });
                                                                  $('#box-icon1-<?php echo $box_code; ?>').addClass('icon-refresh');
                                                                  $('#box-font-<?php echo $box_code; ?>').html("Current<br>Sessions");
                                                                  $('#quick_box_h2<?php echo $box_code; ?>').html(data[1])
                                                                },
                                                                error: function(jqXHR, textStatus, errorThrown) {
                                                                  aaa_ajax<?php echo $box_code; ?>();
                                                                }
                                                              });
                                                            }

                                                            $(function() {
                                                              setInterval(function() {
                                                                aaa_session<?php echo $box_code; ?>();
                                                              }, 5000);
                                                              $('#loading_<?php echo $box_code; ?>').show();
                                                              //aaa_session();
                                                            })
                                                          </script>
                                                  <?php
                                                        }
                                                      }
                                                      echo '<div class="single_counter p-y-2 m-t-1">
                                    <img  id="loading_' . $box_code . '" src="img/rm_loading.gif" style="padding-bottom: 5px;width: 125px;display: ' . $loading_display . '">
                                    <div id="quick-box-' . $box_code . '" style="display: ' . $div_display . '" >';

                                                      //Top Icon or Top text//
                                                      if ($dash_quick_view_top_value == 'icon') {

                                                        $icon_array = explode(",", $icon);
                                                        echo '<i id="box-icon1-' . $box_code . '" class="show icon-' . $icon_array[0] . ' highlight" style="color:#fff;"></i>';

                                                        if (strlen($icon_array[1]) > 0) {
                                                          echo '&nbsp;<i id="box-icon2-' . $box_code . '" class="show icon-' . $icon_array[1] . '" style="color:#fff;"></i>';
                                                        }
                                                      } else {
                                                        echo $top_text;
                                                      }


                                                      //Value///
                                                      // echo '<h2 id="quick_box_h2'.$box_code.'" >'.$val_text.'</h2>';

                                                      echo '<h2 id="quick_box_h2' . $box_code . '" >' . $val_text . '</h2>';


                                                      if ($dash_quick_view_top_value == 'icon') {

                                                        echo '<br/><font id="box-font-' . $box_code . '" >' . $top_text . '<br> ' . $bottom_text . '</font>';
                                                      } else {

                                                        echo '<br/><font id="box-font-' . $box_code . ' >' . $bottom_text . '</font>';
                                                      }



                                                      echo '</div></div></div>';


                                                      $testi++;
                                                    }
                                                  }
                                                  ?>


                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <?php

                                          echo '<div class="mobile-menu">';
                                          for ($i = 0; $i < $testi; $i++) {

                                            if ($i == 0) {
                                              echo '<span class="clicked" onclick="set_btn(' . $i . ',this);">f</span>';
                                            } else {
                                              echo '<span onclick="set_btn(' . $i . ',this);">f</span>';
                                            }
                                          }

                                          echo '</div>';

                                          ?>
                                        </div>
                                      </section><!-- End of counter Section -->


                                    </div>

                                  <?php } ?>


                                  <!-- Jssor Slider End -->



                                  <!-- Tab Quick View End-->
                                </div>

                              <?php
                                $g++;
                              } //for1 
                              ?>

                              <script type="text/javascript">
                                $(function() {

                                  <?php echo $onclick_init; ?>

                                });
                              </script>
                            </div>
                            <!--tab content end-->




                          </div>
                        </div>
                        <!-- /widget-content -->

                      </div>
                    </div>
                  </div>

                <?php } //q

              } ////quick_view


              if ($section_code == 'NVI_TREE_SEC_ALT') {
                $bussiness_type = $db->getValueAsf("SELECT `bussiness_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
                if ($bussiness_type != 'ENT') {
                  $section_code = 'NVI_TREE_SEC';
                }
              }

              $get_boxes = $db->selectDB("SELECT `box_code`,`box_name`,`data_profile` FROM `dashboard_graph_box` WHERE section_code='$section_code'
AND is_enable='1'
ORDER BY `order_number` ASC");


              if ($get_boxes['rowCount'] > 0) { //if_box

                //w_box
                foreach ($get_boxes['data'] as $rowb) {

                  $box_code = $rowb[box_code];
                  $box_name = $rowb[box_name];
                  $data_profile = $rowb[data_profile];

                  if ($box_code == 'REAL_TIME_SESSION' && $property_business_type == 'ENT')
                    continue;

                  /*RUN Special Script for overview Graph URL*/
                  $NVI_TREE_SEC_load_url = $base_portal_url . '/src/statistics/Ruckus_API/overview_graph.php?update_overview_distributor=' . $user_distributor;

                  /*RUN Special Script for overview Graph*/
                  if ($box_code == 'THREE_GRAPH_BOX' || $box_code == 'THREE_GRAPH_BOX_ALT') {
                    CommonFunctions::httpGet($NVI_TREE_SEC_load_url);
                  }

                ?>
                  <!--DashBoard Content BOX Start-->
                  <div class="widget widget-nopad <?php echo $box_code; ?>">
                    <?php
                    if ($section_code == 'MOST_POP_FROM_ALL_SESSIONS') {
                      echo "<div style='display:none;' class='HEAD_MOST_POP'>Most popular</div><div style='width:90%;text-align: left;text-align: left;margin-top:20px' class='para'>";
                      echo "This section aggregates your visitors total sessions over time and will show you the most popular day of the week, hour of the day and month of the year.</div>";
                    }
                    ?>
                    <div class="widget-header ">
                      <div style="text-align:left;"><i class="icon-list-alt"></i>
                        <h2 style="width: 50%; display: inline-block" id="<?php echo $box_code; ?>" class="header-on"><?php echo $box_name; ?></h2>

                        <?php



                        if (in_array($box_code, $WLAN_select_graph_list) && $property_wired == '0') {

                          $wlan_select_id = 'wLan_list' . $box_code . str_replace(' ', '_', $box_name);

                          echo '<script>
                                var executed_arr' . $wlan_select_id . ' = {};
                                function update_executed' . $wlan_select_id . '() {
                                  //alert("asd");
                                  for(var key in executed_arr' . $wlan_select_id . '){
                                    executed_arr' . $wlan_select_id . '[key]();
                                    var elem = $(".graphTab"+key.substr(14));
                                    var elem2 = document.getElementById("li_a_"+key.substr(14));

                                    if(elem.hasClass(\'active\')){
                                        //alert(typeof elem2.onclick);
                                        if (typeof elem2.onclick == "function") {
                                            elem2.onclick.apply(elem2);
                                        }
                                        
                                    }
                                  }
                                }
                                </script>';

                          if ($WLAN_select_graph_list_des == 'li_drop_down' /*&& $property_wired=='0'*/) {
                            echo '<div class="ssid_l ssid_" style=" text-align: right; display: none; width: 49%; position: absolute; "><p style="display: inline-block;">SSID :&nbsp;&nbsp;</p>';
                          } else {
                            echo '<div class="ssid_l ssid_" style=" text-align: right; display: inline-block; width: 49%; position: absolute; "><p style="display: inline-block;">SSID :&nbsp;&nbsp;</p>';
                          }

                          echo '<select class="ssid_se" name="wLan_list" id="' . $wlan_select_id . '" onchange="update_executed' . $wlan_select_id . '()">
                                <option data-ssid="all" value="all">All</option>';
                          foreach ($network_names['data'] as $network_name) {
                            echo '<option data-ssid="' . $network_name["ssid"] . '" value="' . $network_name["wlan_name"] . '">' . $network_name["ssid"] . '</option>';
                          }
                          echo '</select></div>';
                        } ?>
                      </div>
                    </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                      <div class="widget big-stats-container">
                        <div class="widget-content">
                          <div id="big_stats" class="cf">



                            <div class="cf_min">


                              <?php
                              $keyString = '{"box_code":"' . $box_code . '","section_code":"' . $section_code . '","distributor_code":"' . $user_distributor . '"}';
                              $key = urlencode(cryptoJsAesEncrypt($data_secret, $keyString));

                              $Get_data_url = $base_portal_url . '/src/DashboardData/' . $data_profile . '/index.php?key=' . $key;

                              $data_string = CommonFunctions::httpGet($Get_data_url);
                              $dash_tabs_array = json_decode($data_string, true);
                              //print_r($dash_tabs_array);
                              /*$getf_tab_q="SELECT a.tab_name, g.`graph_type`, a.data, a.x, a.y, g.download_graph_size, g.tooltip_symbol,g.`graph_name`,g.graph_code
                        FROM `dashboard_final_graph_data` a,`dashboard_graphs` g
                        WHERE  a.`graph_code`=g.graph_code AND g.box_code='$box_code'  AND a.location_id='$user_distributor' ORDER BY a.tab_number";*/

                              //$get_tabs=mysql_query($getf_tab_q);

                              $no_of_dash_box_tabs = count($dash_tabs_array);
                              //echo $box_code;
                              if ($no_of_dash_box_tabs > 0) { //if1
                                //echo "test";
                                // echo $graphType;
                              ?>


                                <!-- Box Tabs -->
                                <ul id="myTabDASHBOX_<?php echo $box_code; ?>" class="nav nav-tabs dropdown_tabs linkgroup" style="float: right;">

                                  <?php

                                  $tab_set_key_count = 0;
                                  foreach ($dash_tabs_array as $tab_set_key => $tab_set_value) {

                                    $graph_number1 = $graph_number1 + 1;
                                    $dsf_param_ar = json_decode($tab_set_value[11], true);

                                    if (empty($dsf_param_ar['category']) || empty($dsf_param_ar['range'])) {
                                      $dsf_param_ar['category'] = uniqid('catClass');
                                      $dsf_param_ar['range'] = uniqid('ranClass');
                                    }

                                    if ($tab_set_key_count == 0) {
                                      $class = 'class="active ' . $dsf_param_ar['category'] . ' ' . $dsf_param_ar['range'] . ' graphTab' . $graph_number1 . '"';

                                      $tab_click = 'make_this_graph' . $graph_number1 . '();';
                                    } else {
                                      $class = 'class="' . $dsf_param_ar['category'] . ' ' . $dsf_param_ar['range'] . ' graphTab' . $graph_number1 . '"';
                                      $tab_click = 'make_this_graph' . $graph_number1 . '();';
                                    }
                                    $tab_name = $tab_set_value[0];

                                    switch ($tab_name) {
                                      case 'Last 24 Hours': {
                                          $$var24 .= '$("#li_a_' . $graph_number1 . '").click();';
                                          break;
                                        }
                                      case 'Last 7 Days': {
                                          $$var7 .= '$("#li_a_' . $graph_number1 . '").click();';
                                          break;
                                        }
                                      case 'Last 30 Days': {
                                          $$var30 .= '$("#li_a_' . $graph_number1 . '").click();';
                                          break;
                                        }
                                      case 'Last 12 Months': {
                                          $$var12 .= '$("#li_a_' . $graph_number1 . '").click();';
                                          break;
                                        }
                                      case 'Quarterly': {
                                          $$varqua .= '$("#li_a_' . $graph_number1 . '").click();';
                                          break;
                                        }
                                    }

                                    if ($tab_name != "no_tab") {
                                      echo '<li ' . $class . '><a id="li_a_' . $graph_number1 . '" href="#' . $tab_set_key . '" data-toggle="tab" onclick="' . $tab_click . '">' . $tab_name . '</a></li>';

                                      echo '<script type="text/javascript">
try{
    function ' . $dsf_param_ar['category'] . $dsf_param_ar['range'] . '() {
                  
                  $(\'html, body\').animate({
                        scrollTop: $("#' . $box_code . '").offset().top
                    }, 2000);
                  $(".' . $dsf_param_ar['category'] . '").removeClass( "in active" );
                  $(".' . $dsf_param_ar['category'] . '.' . $dsf_param_ar['range'] . '").addClass( " in active" );
                  
                ' . $tab_click . '
              }
}catch (e) {}     
                                        
</script>';
                                    }

                                    $tab_set_key_count++;
                                  }


                                  ?>

                                </ul>


                                <!--SSID-->
                                <?php

                                $new_design = 'yes';
                                if ($new_design == 'yes' && ($no_of_dash_box_tabs > 1) && ($home_dropdown_enable != 'no')) {

                                  echo '<script> $(document).ready( function(){ $("#myTabDASHBOX_' . $box_code . '").ulSelect(); });</script>';
                                }

                                if (in_array($box_code, $WLAN_select_graph_list) && $WLAN_select_graph_list_des == 'li_drop_down' && $property_wired == '0') {
                                  //if(in_array($box_code,$WLAN_select_graph_list_drop)){





                                  echo '<script> $(document).ready( function(){ $("#SSID_myTabDASHBOX_' . $box_code . '").ulSelect(); });</script>';

                                ?>
                                  <!-- <div class="ssid_load"> -->
                                  <ul id="SSID_myTabDASHBOX_<?php echo $box_code; ?>" class="nav nav-tabs" style="float: right;">
                                    <li class=" active" id="sli_a_31_all"><a id="sli_a_30" href="#" data-toggle="tab" onClick="change_ssid_<?php echo $box_code; ?>('all')">All</a></li>
                                    <?php foreach ($network_names['data'] as $network_name) {
                                      $networkNameLower = trim(strtolower($network_name["wlan_name"]));
                                      if (substr($networkNameLower, 0, strlen("register")) === "register") {
                                        continue;
                                      }
                                      ?>
                                      <li class="" id="sli_a_31_<?php echo $box_code; ?>"><a id="sli_a_<?php echo $box_code; ?>" href="#" data-toggle="tab" onClick="change_ssid_<?php echo $box_code; ?>('<?php echo $network_name["wlan_name"]; ?>')"><?php echo $network_name["ssid"]; ?></a></li>
                                    <?php } ?>
                                  </ul>
                                  <!-- </div> -->

                                <?php

                                }
                                ?>
                                <script>
                                  function change_ssid_<?php echo $box_code; ?>(wlan) {
                                    /* alert('#'+id); */
                                    //if($('#'+id).hasClass('active')){ alert()} 


                                    $("#<?php echo $wlan_select_id; ?>").val(wlan).change();
                                  }
                                </script>

                            </div>
                            <!--All Tabs Content Start -->
                            <div id="myTabContentDASH_<?php echo $box_code; ?>" class="tab-content home-inner-tab">


                              <?php
                                //print_r($dash_tabs_array);
                                $i = 0;

                                foreach ($dash_tabs_array as $key_tab_id => $value_tab_details) { //if1

                                  $graph_number = $graph_number + 1;

                                  $value_tab_name = $value_tab_details[0];
                                  $graphType = $value_tab_details[1];
                                  $graphName = $value_tab_details[2] . ' - ' . $value_tab_name;
                                  $graphName = "";
                                  $xAxisName = $value_tab_details[3];
                                  $yAxisName = $value_tab_details[4];
                                  $zAxisName = $value_tab_details[5];
                                  $tooltipSymbol = $value_tab_details[6];
                                  //$downloadGraphName=$value_tab_details[7];
                                  $downloadGraphName = $value_tab_name == 'no_tab' ? $box_name : $box_name . ' ' . $value_tab_name;
                                  $downloadGraphSize = $value_tab_details[8];

                                  $graph_val_x = $value_tab_details[9];

                                  $graph_ref_id = $value_tab_details[10];
                                  $graphData = $value_tab_details[11];
                                  $dsf_param_ar = json_decode($graphData, true);
                                  $graph_code = $value_tab_details[12];

                                  if ($i == 0) {
                                    $tab_fade = 'in active';
                                  } else {
                                    $tab_fade = 'fade';
                                  }


                                  if ($i == 0 && $b == 0) {
                                    $graph_width = '100';
                                  } else {
                                    $graph_width = '80';
                                  }

                              ?>



                                <div class="tab-pane <?php echo $tab_fade . ' ' . $dsf_param_ar['category'] . ' ' . $dsf_param_ar['range']; ?> " id="<?php echo $key_tab_id; ?>" align="center">
                                  <!--Box Tab content start-->


                                  <?php

                                  //$graph_title=$box_name."-".$value_tab_name;

                                  if ($graphType == 'BAR_COL_HORIZONTAL' || $graphType == 'PIE' || $graphType == 'BAR_COL_VERTICAL' || $graphType == 'BAR_COL_VERTICAL_ARRIS_API' || $graphType == 'BAR_COL_HORIZONTAL_ARRIS_API' || $graphType == 'SP_LINE' || $graphType == 'NVI_TREE_NODES') {
                                  } elseif ($graphType == 'MULTI_BAR_COL_VERTICAL') {
                                    //Multi_BAR_COL_VERTICAL


                                    $xAxisCategory = '';
                                    $get_xAxis_names = $db->selectDB("SELECT DISTINCT a.`val3` AS a
FROM `dashboard_graph_data` a,`dashboard_graphs` g WHERE
a.`graph_code`=g.graph_code AND g.box_code='$box_code'
AND a.`tab_name`='$value_tab_name' AND a.distributor='$user_distributor'
ORDER BY order_number ASC");
                                    $Xaxis_name_array = array();
                                    $z = 0;

                                    foreach ($get_xAxis_names['data'] as $rowC) {
                                      $Xaxis_name_array[$z] = $rowC[a];
                                      $xAxisCategory .= "'" . $rowC[a] . "',";
                                      $z++;
                                    }


                                    $xAxisCategory = rtrim($xAxisCategory, ",");

                                    $graphData = '';

                                    $get_graph_data = $db->selectDB("SELECT DISTINCT a.`val1` AS a ,c.`color_code` AS b
FROM `dashboard_graph_data` a,`dashboard_graphs` g,`dashboard_graph_color` c WHERE
a.`graph_code`=g.graph_code AND a.`graph_code`=c.`graph_id` AND a.`color_id`=c.`color_id` AND g.box_code='$box_code'
AND a.`tab_name`='$value_tab_name' AND a.distributor='$user_distributor'
ORDER BY order_number ASC");

                                    //wx
                                    foreach ($get_graph_data['data'] as $rowX) {
                                      $col_val = $rowX[a];
                                      $color_val = $rowX[b];

                                      $data_val = '';
                                      foreach ($Xaxis_name_array as $Xvalue_key => $Xvalue) { //f
                                        $count = $db->getValueAsf("SELECT a.`val2` AS f
FROM `dashboard_graph_data` a,`dashboard_graphs` g WHERE
a.`graph_code`=g.graph_code AND g.box_code='$box_code'
AND a.`tab_name`='$value_tab_name' AND a.distributor='$user_distributor' AND a.val1='$col_val'
AND a.`val3`='$Xvalue' LIMIT 1");



                                        if (strlen($count) == 0) {
                                          $count = 0;
                                        }
                                        $data_val .= $count . ',';
                                      } //f

                                      $graphData .= "{name:'" . $col_val . "',data:[" . rtrim($data_val, ",") . "],color:'" . $color_val . "'},";
                                    } //wx


                                    //full graph data//
                                    $graphData = rtrim($graphData, ",");
                                  } elseif ($graphType == 'LINE') {

                                    $xAxisCategory = '';
                                    $get_xAxis_names = $db->selectDB("SELECT DISTINCT a.`val3` AS a
FROM `dashboard_graph_data` a,`dashboard_graphs` g WHERE
a.`graph_code`=g.graph_code AND g.box_code='$box_code'
AND a.`tab_name`='$value_tab_name' AND a.distributor='$user_distributor'
ORDER BY order_number ASC");
                                    $Xaxis_name_array = array();
                                    $z = 0;

                                    foreach ($get_xAxis_names['data'] as $rowC) {
                                      $Xaxis_name_array[$z] = $rowC[a];
                                      $xAxisCategory .= "'" . $rowC[a] . "',";
                                      $z++;
                                    }


                                    $xAxisCategory = rtrim($xAxisCategory, ",");

                                    $graphData = '';

                                    $get_graph_data = $db->selectDB("SELECT DISTINCT a.`val1` AS a ,c.`color_code` AS b
FROM `dashboard_graph_data` a,`dashboard_graphs` g,`dashboard_graph_color` c WHERE
a.`graph_code`=g.graph_code AND a.`graph_code`=c.`graph_id` AND a.`color_id`=c.`color_id` AND g.box_code='$box_code'
AND a.`tab_name`='$value_tab_name' AND a.distributor='$user_distributor'
ORDER BY order_number ASC");

                                    //wx
                                    foreach ($get_graph_data['data'] as $rowX) {
                                      $col_val = $rowX[a];
                                      $color_val = $rowX[b];

                                      $data_val = '';
                                      foreach ($Xaxis_name_array as $Xvalue_key => $Xvalue) { //f
                                        $count = $db->getValueAsf("SELECT a.`val2` AS f
FROM `dashboard_graph_data` a,`dashboard_graphs` g WHERE
a.`graph_code`=g.graph_code AND g.box_code='$box_code'
AND a.`tab_name`='$value_tab_name' AND a.distributor='$user_distributor' AND a.val1='$col_val'
AND a.`val3`='$Xvalue' LIMIT 1");



                                        if (strlen($count) == 0) {
                                          $count = 0;
                                        }
                                        $data_val .= $count . ',';
                                      } //f

                                      $graphData .= "{name:'" . $col_val . "',data:[" . rtrim($data_val, ",") . "],color:'" . $color_val . "'},";
                                    } //wx


                                    //full graph data//
                                    $graphData = rtrim($graphData, ",");
                                  } elseif ($graphType == 'COL_STACKED') {


                                    $graphData = $graphDB->graphData(" SELECT
CONCAT('{name:\'',a.val1,'\',data:[',GROUP_CONCAT(a.`val2` ORDER BY a.`order_number` ASC SEPARATOR ',' ),'],color:\'',c.`color_code`,'\'}' ) AS a
FROM `dashboard_graph_data` a,`dashboard_graphs` g,`dashboard_graph_color` c WHERE
a.`graph_code`=c.`graph_id` AND a.`color_id`=c.`color_id` AND
a.`graph_code`=g.graph_code AND g.box_code='$box_code' AND a.`tab_name`='$value_tab_name' AND a.distributor='$user_distributor'
GROUP BY a.val1
");



                                    $xAxisCategory = $graphDB->xAxis("SELECT GROUP_CONCAT(DISTINCT CONCAT('\'',a.`val3`,'\'')  ORDER BY order_number ASC) AS a FROM `dashboard_graph_data` a,`dashboard_graphs` g WHERE
a.`graph_code`=g.graph_code AND g.box_code='$box_code'
AND a.`tab_name`='$value_tab_name' AND a.distributor='$user_distributor' ");
                                  } elseif ($graphType == 'MAP') {
                                    $graphData = "";
                                    $sql = "SELECT CONCAT(val3,\"/\",val1) AS a FROM `dashboard_graph_data` WHERE distributor='" . $user_distributor . "' AND tab_name='$value_tab_name'";
                                    $getgraphdata = $db->selectDB($sql);

                                    foreach ($getgraphdata['data'] as $graphdata) {
                                      $graphData = $graphData . "*" . $graphdata[a];
                                    }

                                    $xAxisCategory = $graphDB->xAxis("");

                                    $graphData = ltrim($graphData, "*");
                                  } elseif ($graphType == 'HTML_GRAPH') {


                                    $verify_num = $db->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'");
                                    $zone = $db->getValueAsf("SELECT `zone_id` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$verify_num'");

                                    $zone_name = $db->getValueAsf("SELECT `name` AS f FROM `exp_distributor_zones` WHERE `zoneid`='$zone'");

                                    $val1 = $db->getValueAsf("SELECT `val1` AS f FROM `dashboard_graph_data` WHERE distributor='" . $user_distributor . "' AND tab_name='$value_tab_name'");

                                    $q = "SELECT `api_url`
	FROM `exp_statistics_profile`
	WHERE `api_name`='HTMLGraphs'
	AND `is_enable`='1'";
                                    $get_details_r = $db->select1DB($q);
                                    //$get_details_r=mysql_fetch_array($get_details);
                                    //print_r($get_details_r);
                                    $host = $get_details_r['api_url'];

                                    $url = $host . "clients_by_os_pie?apzone=" . urlencode($zone_name) . "&by=" . $val1;


                                    //$url=$host."clients_by_os_pie?apzone=".$zone_name."&by=".$val1."&vlan=100";
                                    $result1 = get_web_page($url);

                                    $url1 = urlencode($url);

                                    //echo '<iframe>';
                                    //echo $page = $result1['content'];
                                    //echo '</iframe>';


                                    echo '<div id="load_' . $garphID . '"></div><div class="iframe_load" id="iframe_load_' . $garphID . '">Loading..</div>';

                                    echo '<script>
 setTimeout(function(){
 $.post( "ajax/home_html_graph.php", { iframe_id: "preview1_' . $garphID . '", src_data: "src/statistics/HTMLGraphs/os_graph.php?url=' . $url1 . '"}, function( data ) {
  $( "#load_' . $garphID . '" ).html( data );
  $("#preview1_' . $garphID . '").on("load", function(){
        $("#iframe_load_' . $garphID . '").hide();
    });
});
}, 100);


 </script>';
                                  }



                                  $garphID = $graphType . '_' . $key_tab_id;

                                  if ($graphType == 'TRE_NVI_TREE_NODES_NEW' || $graphType == 'TRE_NVI_TREE_NODES_ALT' || $graphType == 'WIFI_INFORMATION') {
                                    $statClass = 'TreeStat';
                                  } else {
                                    $statClass = '';
                                  }

                                  ?>
                                  <style>
                                    .span11 {
                                      margin-left: 0px !important;
                                      padding-right:
                                    }

                                    @media (min-width:950px) {
                                      .span11 {
                                        margin-left: 0px !important;
                                        width: 100% !important;
                                      }
                                    }

                                    .iframe_load {
                                      width: 100%;
                                      height: 100%;
                                      top: 40%;
                                      left: 0px;
                                      position: absolute;
                                      display: block;
                                      opacity: 0.8;
                                      background-color: #fff;
                                      z-index: 99;
                                      text-align: center;

                                    }

                                    @media (max-width: 979px) and (min-width: 768px) {
                                      .span11 {
                                        width: 720px !important;
                                      }
                                    }

                                    @media (max-width:768px) {
                                      iframe {
                                        width: 100%;
                                        height: 650px;
                                      }
                                    }

                                    @media (max-width:480px) {
                                      iframe {
                                        padding-top: 50px;
                                        width: 300px;
                                        height: 320px;
                                      }
                                    }

                                    @media (max-width:415px) {
                                      iframe {
                                        padding-top: 50px;
                                        width: 300px;
                                        height: 400px;
                                      }
                                    }

                                    @media (max-width:375px) {
                                      iframe {
                                        padding-top: 80px;
                                        width: 300px;
                                        height: 350px;
                                      }
                                    }

                                    @media (max-width:360px) {
                                      iframe {
                                        padding-top: 80px;
                                        width: 290px;
                                        height: 350px;
                                      }
                                    }

                                    @media (max-width:330px) {
                                      iframe {
                                        padding-top: 150px;
                                        width: 230px;
                                        height: 400px;
                                      }
                                    }
                                  </style>

                                  <!-- Element 1 -->
                                  <div class="stat <?php echo $statClass; ?>" id='<?php echo 'graph_stat_' . $graph_number; ?>'>
                                    <div class="">
                                      <div class="widget">

                                        <!-- /widget-header -->
                                        <div class="widget-content">

                                          <?php $check1 = substr($garphID, 0, 3);
                                          if ($check1 == "PIE") { ?>
                                            <div class="resize_charts_pie" style="">
                                            <?php } elseif ($check1 == "NVI") { ?>

                                              <div class="resize_charts">
                                                <div class="resize_charts_inner" id="resize_charts_inner<?php echo $graph_number; ?>"></div>

                                              <?php } else { ?>

                                                <div class="resize_charts" style="background-color: #0000">
                                                  <div class="resize_charts_inner"></div>

                                                <?php } ?>
                                                <div id="<?php echo $garphID; ?>" class="sami">



                                                  <?php if (strlen($graphData) == 0 && $graphType != 'WIFI_INFORMATION') { ?><img src="img/graph/NoDataAvailable.png" width="350" height="350" /> <?php }  ?>

                                                </div>
                                                <?php
                                                if (strlen($graphData) > 0 || $graphType == 'WIFI_INFORMATION') {

                                                  $check = substr($garphID, 0, 3);
                                                  if ($check == "PIE") {
                                                ?>

                                                    <script>
                                                      window.addEventListener("load", function() {
                                                        try {
                                                          var y = $('#myTabContentDASH').width();
                                                        } catch (err) {
                                                          var y = $('#myTabDash').width();
                                                        }
                                                        var windowWidth = (y - 20);

                                                        $("#<?php echo $garphID; ?>").highcharts().setSize(windowWidth, 300, false);

                                                      });

                                                      window.addEventListener("resize", function() {
                                                        try {
                                                          var y = $('#myTabContentDASH').width();
                                                        } catch (err) {
                                                          var y = $('#myTabDash').width();
                                                        }
                                                        var windowWidth = (y - 20);

                                                        $("#<?php echo $garphID; ?>").highcharts().setSize(windowWidth, 300, false);

                                                      });
                                                    </script>


                                                  <?php
                                                  } elseif ($check == "SP_") {
                                                    echo '<script>

    window.addEventListener("load",function(){

          try{
        var y = $("#myTabContentDASH").width();
        }catch(err){
          var y = $("#myTabDash").width();
        }

        var windowWidth = (y + 20);

        $("#' . $garphID . '").highcharts().setSize(windowWidth, 300, false);

    });

        window.addEventListener("resize",function(){

        try{
          var y = $("#myTabContentDASH").width();
        }catch(err){
          var y = $("#myTabDash").width();
        }

        var windowWidth = (y + 20);

        $("#' . $garphID . '").highcharts().setSize(windowWidth, 300, false);

    });

</script>';
                                                  } elseif ($check == "BAR_COL_HORIZONTAL") {

                                                  ?>

                                                    <script>
                                                      window.addEventListener("load", function() {
                                                        try {
                                                          var y = $('#myTabContentDASH').width();
                                                        } catch (err) {
                                                          var y = $('#myTabDash').width();
                                                        }
                                                        var windowWidth = (y - 20);

                                                        $("#<?php echo $garphID; ?>").highcharts().setSize(windowWidth, 300, false);

                                                      });

                                                      window.addEventListener("resize", function() {
                                                        try {
                                                          var y = $('#myTabContentDASH').width();
                                                        } catch (err) {
                                                          var y = $('#myTabDash').width();
                                                        }
                                                        var windowWidth = (y - 20);

                                                        $("#<?php echo $garphID; ?>").highcharts().setSize(windowWidth, 300, false);

                                                      });
                                                    </script>

                                                <?php
                                                  } else if ($check == "NVI") {

                                                    echo '<div id="canvasSizer"><p class="zoom-msg" style="display:none">In case you zoom in or out in your browser the text for the APs becomes distorted.Please refresh the page to reset the text.</p>
<a href="javascript:void(0);" onclick="overview_refresh(\'' . $garphID . '\',\'TREE_GRAPH_AP_NODE\',\'' . $user_distributor . '\');" class="innerCanvasContainer_refresh" style="float:  right;font-size:  16px;margin-top: 20px;z-index: 33;font-weight: 600;margin-right: 20px;">Refresh</a>

<img id="home_over_load" src="img/loading_ajax.gif" style="display:  none;text-align: center;position:  absolute;left: 48%;top: 50%;min-width: 30px;">
    <div class="innerCanvasContainer" id="innerCanvasContainer"><canvas id="myCanvas" width="500" height="550" style="margin: auto">

</canvas></div></div>';
                                                  } else if ($check == "TRE" && (strpos($garphID, 'TRE_NVI_TREE_NODES_COX_NEW') === false)) {

                                                    echo '<div id="canVasDiv" style="margin: auto;position: relative;">


<img class="home_over_load_img" id="home_over_load" src="img/loading_ajax.gif" style="margin: auto;display:  none;text-align: center;position:  absolute;left: 48%;top: 50%;min-width: 30px;">
    <div class="innerCanvasContainer" id="innerCanvasContainer"><canvas id="myCanvas" width="620" height="550" style="margin: auto; width: 100%; height: 100%;touch-action: none; -moz-user-select: none;"></div>

</canvas></div>';
                                                  } else if ($check == "TRE" && (strpos($garphID, 'TRE_NVI_TREE_NODES_COX_NEW') !== false)) {

                                                    echo '<div id="canVasDiv1" style="margin: auto;position: relative;">


<img class="home_over_load_img1" id="home_over_load1" src="img/loading_ajax.gif" style="margin: auto;display:  none;text-align: center;position:  absolute;left: 48%;top: 50%;min-width: 30px;">
    <div class="innerCanvasContainer1" id="innerCanvasContainer1"></div></div>';
                                                  }
                                                  //echo $garphID;
                                                  //echo $graphData;
                                                  // echo  "----------------------".$check;zz

                                                  if (($check == "BAR" || $check == 'PEK') && $i == 0) {

                                                    if ($graphType == 'BAR_COL_VERTICAL_ARRIS_API' || $graphType == 'BAR_COL_PIE_ARRIS_API' || $graphType == 'PEKE_DATA_ARRIS_API') {
                                                      echo '<script>  $(document).ready(function() { setTimeout(function(){ make_this_graph' . $graph_number . '(); }, 4000); }); </script>';
                                                    } else {
                                                      echo '<script> $(document).ready(function() { make_this_graph' . $graph_number . '(); }); </script>';
                                                    }
                                                  }

                                                  if ($graphType == 'BAR_COL_VERTICAL_ARRIS_API' || $graphType == 'BAR_COL_PIE_ARRIS_API' || $graphType == 'PEKE_DATA_ARRIS_API') {

                                                    echo '<img class="ajax-loader" id="loading_' . $graph_number . '" src="layout/' . $camp_layout . '/img/graph_loading.gif" >';
                                                  }


                                                  echo '<script>
try{
    executed_arr' . $wlan_select_id . '.updateExecuted' . $graph_number . '=function (){
        
        executed' . $graph_number . ' = false;
        
    };
    }catch(e){}
    function getWLanName' . $garphID . '(){
        try{
        return $("#' . $wlan_select_id . ' option:selected").val();
        }catch(e){}
    }
    function getSSID' . $garphID . '(){
        try{
        return $("#' . $wlan_select_id . ' option:selected").data("ssid");
        }catch(e){}
    }
</script>';
                                                  echo $graphDB->graphDesign($graphType, $graphName, $garphID, $graphData, $xAxisCategory, $xAxisName, $yAxisName, $zAxisName, $tooltipSymbol, $downloadGraphName, $downloadGraphSize, $graph_val_x, $graph_ref_id, $graph_code, $value_tab_name, $box_name, $user_distributor, $graph_number, $camp_layout, $overview_disabele);
                                                }
                                                ?>

                                                </div>
                                              </div>
                                              <!-- /widget-content -->
                                            </div>
                                            <!-- /widget -->

                                        </div>
                                        <!-- /span6 -->

                                      </div>
                                      <!-- /Element 1-->

                                      <?php

                                      ?>

                                      <!--Box Tab content end-->
                                    </div>

                                  <?php $i++;
                                } //f1 
                                  ?>





                                  </div>
                                  <!--All Tabs Content End -->




                                <?php

                              } //if1->No Tab Records
                              else {
                                echo '<div class="no_data"><img src="img/graph/NoDataAvailable.png" width="350" height="350" /></div></div>';
                              }
                                ?>



                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--DashBoard Content BOX End-->
                  <?php
                } //w_box
              } //if_box

                  ?>


                  <!-- End Tab 1-->



                    </div>

                    <script>
                      <?php if ($section_code == 'ARRIS_CDR_API_GRAPH') { ?>

                        function <?php echo $var24; ?>() {
                          $('.ARRIS_API_G_OS').show();
                          <?php echo $$var24; ?>
                        }

                        function <?php echo $var7; ?>() {
                          $('.ARRIS_API_G_OS').show();
                          <?php echo $$var7; ?>
                        }

                        function <?php echo $var30; ?>() {
                          $('.ARRIS_API_G_OS').show();
                          <?php echo $$var30; ?>
                        }

                        function <?php echo $var12; ?>() {
                          $('.ARRIS_API_G_OS').show();
                          <?php echo $$var12; ?>
                        }

                        function <?php echo $varqua; ?>() {
                          $('#dash_section_tab_2 #myTabContentQuick .tab-pane').removeClass('active');
                          $('#dash_tab_ARRIS_CDR_API_GRAPH_1_QUA2').addClass('active');
                          $('.ARRIS_API_G_OS').hide();
                          <?php echo $$varqua; ?>
                        }
                      <?php } elseif ($section_code == 'Gender_Age_Group_GENERIC') { ?>

                        function <?php echo $var24; ?>() {
                          $('.01_SES_GENDER_HOUR').show();
                          $('.01_SES_AGE_HOUR').show();
                          $('.01_SES_GENDER_DAY').hide();
                          $('.01_SES_GENDER_MONTH').hide();
                          $('.01_SES_AGE').hide();
                          $('.01_SES_AGE_MONTH').hide();
                          <?php echo $$var24; ?>
                        }

                        function <?php echo $var7; ?>() {
                          $('.01_SES_GENDER_HOUR').show();
                          $('.01_SES_GENDER_DAY').show();
                          $('.01_SES_AGE_HOUR').show();
                          $('.01_SES_AGE').show();
                          $('.01_SES_GENDER_MONTH').hide();
                          $('.01_SES_AGE_MONTH').hide();
                          <?php echo $$var7; ?>
                        }

                        function <?php echo $var30; ?>() {
                          $('.01_SES_GENDER_HOUR').show();
                          $('.01_SES_GENDER_DAY').show();
                          $('.01_SES_AGE_HOUR').show();
                          $('.01_SES_AGE').show();
                          $('.01_SES_GENDER_MONTH').hide();
                          $('.01_SES_AGE_MONTH').hide();
                          <?php echo $$var30; ?>
                        }

                        function <?php echo $var12; ?>() {
                          $('.01_SES_GENDER_HOUR').show();
                          $('.01_SES_GENDER_DAY').show();
                          $('.01_SES_GENDER_MONTH').show();
                          $('.01_SES_AGE_HOUR').show();
                          $('.01_SES_AGE').show();
                          $('.01_SES_AGE_MONTH').show();
                          <?php echo $$var12; ?>
                        }

                        function <?php echo $varqua; ?>() {
                          $('#dash_section_tab_3 #myTabContentQuick .tab-pane').removeClass('active');
                          $('#dash_tab_ARRIS_CDR_API_GRAPH_1_QUA3').addClass('active');
                          $('.01_SES_GENDER_HOUR').hide();
                          $('.01_SES_GENDER_DAY').hide();
                          $('.01_SES_GENDER_MONTH').hide();
                          $('.01_SES_AGE_HOUR').hide();
                          $('.01_SES_AGE').hide();
                          $('.01_SES_AGE_MONTH').hide();
                          <?php echo $$varqua; ?>
                        }

                      <?php } ?>
                    </script>


                  <?php
                  $b++;

                  //}
                } //section_body
                  ?>
                  <style>
                    .fadeInUp.old-style {
                      display: table;
                      width: 100%;
                      border-spacing: 25px;
                    }

                    .col-md-3.old-style {
                      width: 20%;
                      text-align: center;
                      box-sizing: border-box;
                      background: #0463a7;
                      color: white;
                      margin: 19px;
                      display: table-cell;
                      padding: 15px;
                    }

                    .quick-box {
                      cursor: pointer;
                    }
                  </style>

                  <?php


                  function get_web_page($url)
                  {
                    $options = array(
                      CURLOPT_RETURNTRANSFER => true,     // return web page
                      CURLOPT_HEADER         => false,    // don't return headers
                      CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                      CURLOPT_ENCODING       => "",       // handle all encodings
                      CURLOPT_USERAGENT      => "spider", // who am i
                      CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                      CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                      CURLOPT_TIMEOUT        => 120,      // timeout on response
                      CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
                    );

                    $ch      = curl_init($url);
                    curl_setopt_array($ch, $options);
                    $content = curl_exec($ch);
                    $err     = curl_errno($ch);
                    $errmsg  = curl_error($ch);
                    $header  = curl_getinfo($ch);
                    curl_close($ch);

                    $header['errno']   = $err;
                    $header['errmsg']  = $errmsg;
                    $header['content'] = $content;
                    return $header;
                  }



                  // $url="http://10.1.6.29:90/dashboards/clients_by_os?apzone=BITest&by=week";
                  //  $result1=get_web_page($url);
                  //echo $page = $result1['content'];
                  ?>



                  <!--
            </div>
          </div>


-->


                  <?php if ($dash_link_group == 'ENABLE') { ?>
                    <style>
                      .cf_min ul.linkgroup {
                        display: none !important;
                      }

                      .ARRIS_API_TOP10_OS .cf_min ul.linkgroup {
                        display: block !important;
                      }
                    </style>
                  <?php } ?>
                  </div>
                  <!--Dash Section End All Tabs-->




                  <script>
                    $(document).ready(function() {
                      $("section.counter").each(function() {
                        var x = $(this).find('.col-md-3');
                        $(x).css("width", 100 / x.length + '%');
                      });
                    });
                  </script>



            </div>
            <!-- /container -->
        </div>
        <!-- /main-inner -->
      </div>
      <!-- /main -->





























      <?php
      include 'footer.php';
      ?>
      <script type="text/javascript">
        function page_graph() {

          var graph_id = document.getElementById("duration").value;

          if (graph_id.length > 0) {
            window.location = "?graph_token=" + graph_id;

          }


        }

        function refresh_graph(graph_ob, graph_code, graph_tab) {
          var distributor = '<?php echo $user_distributor; ?>';
          var formData = {
            graph_code: graph_code,
            graph_tab: graph_tab,
            location: distributor
          };
          $.ajax({
            url: "ajax/getGraphData.php",
            type: "GET",
            data: formData,
            success: function(data) {
              //alert(data);
              var data_array = JSON.parse(data);
              var categories_ar = data_array.categories.split(',');
              //console.log(categories_ar);
              //alert(data_array.Categories);
              //graph_ob.xAxis[0].setCategories(['08:10','08:15','08:20','08:25','08:30','08:35','08:40','08:45','08:50','08:55','09:00','09:10']);
              graph_ob.xAxis[0].setCategories(categories_ar);

              var series_ar = data_array.series;
              var series_one_ar;
              for (var k = 0; k < series_ar.length; k++) {
                //alert(series_ar[k]);
                series_one_ar = series_ar[k].split(',').map(Number);
                //alert(series_one_ar);
                //console.log(series_one_ar);
                graph_ob.series[k].setData(series_one_ar);

              }
              //graph_ob.series[0].setData([0,0,0,5,0,0,0,0,0,0,0,0]);
              //graph_ob.series[0].setData(['08:05','08:10','08:15','08:20','08:25','08:30','08:35','08:40','08:45','08:50','08:55','09:00']);
            }
          });

        }
      </script>

      <!--  <script src="js/functions.js?v=76"></script> -->
      <!--<script src="js/overview.js?v=206"></script>-->

      <style type="text/css">
        ul[id*="THREE_GRAPH_BOX_NEW"] {
          border-bottom: none;
        }

        div[id*="THREE_GRAPH_BOX_NEW"] {
          border: none !important;
        }


        /* #canVasDiv .switch0.ap .node_txt, #canVasDiv .switch1.ap .node_txt, #canVasDiv .switch2.ap .node_txt, #canVasDiv .switch3.ap .node_txt{
      display: block;
    }

    #canVasDiv .switch0.ap ~ .switch0.ap .node_txt, #canVasDiv .switch1.ap ~ .switch1.ap .node_txt, #canVasDiv .switch2.ap ~ .switch2.ap .node_txt, #canVasDiv .switch3.ap ~ .switch3.ap .node_txt{
        display: none;
    }*/

        #big_stats .stat {
          left: 0px !important;
        }

        .guest {
          padding-top: 30px;
        }

        #canVasDiv a {
          width: 100%;
          float: left;
          text-align: left;
          color: #0565a9;
          position: relative;
          font-weight: normal;
        }

        @media screen and (min-width : 500px) {

          tbody td a.hide-details {
            min-width: 250px;
          }

        }

        .hide-t tr {
          display: none;
        }

        .hide-t tr:nth-child(1) {
          display: table-row;
        }

        #canVasDiv h4 {
          margin-bottom: 2px !important;
          font-size: 15px !important;
          font-weight: normal !important;
          color: #000 !important;
          margin-bottom: 5px !important;
        }

        #canVasDiv h3 {
          margin-bottom: 10px;
        }

        #canVasDiv table {
          width: 100%;
          text-align: left;
        }

        #canVasDiv table tr {
          border-top: 1px solid black;
        }

        #canVasDiv h5 {
          margin-bottom: 5px;
        }

        .zoom {
          display: none;
          position: absolute;
          width: 50px;
          height: 50px;
          bottom: 0px;
          z-index: 555555555555;
        }

        .zoom .up {
          width: 50px;
          height: 25px;
        }

        .zoom .up::after {
          content: "\2212";
        }

        .zoom .down {
          width: 50px;
          height: 25px;
        }

        .zoom .down::after {
          content: "\002b";
        }

        .canvas-container {
          margin: auto;
        }

        .hide-details {
          float: left;
          width: 100%;
          text-align: left;
          margin-bottom: 20px;
          margin-top: 20px;
        }

        .table .hide-details {
          margin-bottom: 0px;
          margin-top: 0px;
        }

        .guest td {
          padding: 10px;
        }

        .guest table {
          margin-top: 10px;
        }

        .hide-details::before {
          content: 'Hide Details';
        }

        .overview::before {
          content: "\f08e";
          font-family: FontAwesome;
          margin-right: 5px;
        }

        .hide-details::after {
          margin-left: 10px;
          font-size: 20px;
          content: "\f056";
          font-family: FontAwesome;
          color: #058ece;
          top: 0px;
          position: absolute;
        }

        .hide-details.a-hide::before {
          content: 'Show Details';
        }

        .hide-details.a-hide::after {
          margin-left: 10px;
          font-size: 20px;
          content: "\f055";
          font-family: FontAwesome;
          color: #058ece;
          top: 0px;
          position: absolute;
        }

        .tooltipGraph {
          position: absolute;
          display: none;
        }

        /* Tooltip text */
        .tooltipGraph .tooltiptext {
          width: 210px;
          background-color: white;
          color: #0560a1;
          text-align: center;
          padding: 5px 0;
          padding-left: 0px;
          border-radius: 6px;
          position: absolute;
          z-index: 1;
          border: 1px solid #056cb5;
          text-align: left;
          padding-left: 10px;
          list-style-type: none;
        }

        .details {
          display: none;
          /*position: absolute;*/
          top: 0px;
          width: 100%;
          vertical-align: middle;
          height: 100%;
          padding: 20px;
        }

        /*.table-bordered{
        border: none;
      }
      .table tr th:first-child {
    border-left: none;
}
.table tr td:first-child {
    border-left: none;
}*/
      </style>
      <?php
      /*
 <script type="text/javascript">

 var chart; // global

 function requestData() {
	    $.ajax({
	        url: 'ajax/live_server_graph_data.php',
	        success: function(point) {
	          //  var series = chart.series[0],
	           //     shift = series.data.length > 20; // shift if the series is
	                                                 // longer than 20

	            // add the point
	          //  chart.series[0].addPoint(point, true, shift);


				<?php

						$query_code = "SELECT ap_id ,`location_ssid`
											FROM `exp_locations_ap_ssid`
											WHERE `distributor`='$user_distributor'";

						$query_results_a=mysql_query($query_code);
						$rec_id = 0;
						$series = '';
						while($row=mysql_fetch_array($query_results_a)){
							$ap_code = $row[ap_id];

							$ap_code=str_replace("-","",$ap_code);
							$ap_short_description = $row[location_ssid];



							$discription= $ap_code;
							$x = time() * 1000;

?>


if(point['<?php echo $ap_code; ?>']==null){


	point['<?php echo $ap_code; ?>']='[<?php echo $x; ?>,0]';


}



<?php
								echo 'var series = chart.series['.$rec_id.'],shift = series.data.length > 20;'; // shift if the series is longer than 20
								echo 'chart.series['.$rec_id.'].addPoint(eval(point[\''.$ap_code.'\']), true, shift);';






							$series.= '{name: \''.$discription.'\',data: []},';
							$rec_id++;
						}

						?>





	            // call it again after one second
	            setTimeout(requestData, 5000);
	        },
	        cache: false
	    });
	}


 $(document).ready(function() {
	    chart = new Highcharts.Chart({
	        chart: {
	            renderTo: 'live_container',
	            defaultSeriesType: 'spline',
	            events: {
	                load: requestData
	            }
	        },
			credits: {
	            enabled: false
	                },
	        title: {
	            text: 'Live Users'
	        },
	        xAxis: {
	            type: 'datetime',
	            tickPixelInterval: 150,
	            maxZoom: 20 * 1000
	        },
	        yAxis: {
					min: 0,
                title: {
                    text: 'Online Count'
                },
	        },

	        series: [

	                 <?php echo $series;?>
		]
	    });
	});


</script> */
      ?>
</body>

</html>