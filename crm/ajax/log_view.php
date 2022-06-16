<!DOCTYPE html>
<html lang="en">
<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_WARNING);*/
//require_once('../db/config.php');

/* No cache*/
header("Cache-Control: no-cache, must-revalidate");


/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();

include_once '../classes/systemPackageClass.php';
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);

// $module_array include the access page name.
$module_array = array('logs','ale_logs','dsf_logs','ruckus_logs','venue_support');

if(!$package_functions->ajaxAccess($module_array,$system_package)){
    http_response_code(401);
    echo 'Unauthorized Request';
    exit();
}

/*Log*/
require_once '../src/LOG/Logger.php';
/**/


?>



<head>
  <meta charset="utf-8">
  <title>View Logs</title>

  <style>
    pre {
      white-space: pre-wrap;       /* CSS 3 */
      white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
      white-space: -pre-wrap;      /* Opera 4-6 */
      white-space: -o-pre-wrap;    /* Opera 7 */
      word-wrap: break-word;       /* Internet Explorer 5.5+ */
    }

    .log-heading{
      font-size: 21px;
    }
  </style>
</head>
<body>
<?php
if(isset($_GET['ses_log_id'])){
    $id= urldecode($_GET['ses_log_id']);
    $log_details = Logger::getLogger()->ReadLog($id,'session');

    
?>
  <h2 class="log-heading">Log ID :<?php echo$id= htmlentities( $log_details->getID(), ENT_QUOTES, 'utf-8' ); ?>  (Session Logs)</h2>

    <p>
      <?php 

        $timestamp=$log_details->getUnixtimestamp();
        $realm=$log_details->getRealm();
        $method=$log_details->getApiMethod();
        $ale_username=$log_details->getAleusername();         

        echo '<pre>Timestamp: '.$timestamp.'<br>';
        echo 'Realm: '.$realm.'<br>';
        echo 'API UserName: '.$ale_username.'<br>';
        echo 'BI System: '.$_SERVER['SERVER_NAME'].'</pre>';
      ?>
    </p>


  <p>
      <?php
      $url=$log_details->getDescription();
      echo '<h2 class="log-heading">URL</h2><pre>' . strtoupper($method).'<br>'.htmlspecialchars($url , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <p>
      <?php
      $request=$log_details->getApiData();
      echo '<h2 class="log-heading">Request</h2><pre>' . htmlspecialchars($request , ENT_QUOTES) . '</pre>';
      ?>
    </p>

    <p>
      <?php
      $response=$log_details->getApiDescription();
      $response=str_replace(array("\\n","\\r", "\\", " "),'',$response);
      if(empty($response))
          $response='No content response';
      echo '<h2 class="log-heading">Response</h2><pre>' . htmlspecialchars($response , ENT_QUOTES) . '</pre>';
      ?>
    </p>
<?php }
elseif(isset($_GET['other_log_id'])){
    $id= urldecode($_GET[other_log_id]);
    $log_details = Logger::getLogger()->ReadLog($id,'other');

    ?>
    <h2 class="log-heading">Log ID : <?php echo$id= htmlentities( $log_details->getID(), ENT_QUOTES, 'utf-8' ); ?>  (Other Logs)</h2>

      <p>
        <?php 

        $timestamp=$log_details->getUnixtimestamp();
        $realm=$log_details->getRealm();
        //$method= $log_details->getApiMethod();
        //$ale_username=$log_details->getAleusername();


          echo '<pre>Timestamp: '.$timestamp.'<br>';
          echo 'Realm: '.$realm.'<br>';
          echo 'BI System: '.$_SERVER['SERVER_NAME'].'</pre>';
        ?>
      </p>

     <p>
      <?php
      $url=$log_details->getApiUrl();
      echo '<h2 class="log-heading">URL</h2><pre><br>'.htmlspecialchars($url , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <p>
      <?php
      $request=$log_details->getApiData();
      echo '<h2 class="log-heading">Request</h2><pre>' . htmlspecialchars($request , ENT_QUOTES) . '</pre>';
      ?>
    </p>

    <p>
      <?php
      $response=$log_details->getApiDescription();
      $response=str_replace(array("\\n","\\r", "\\", " "),'',$response); 
      echo '<h2 class="log-heading">Response</h2><pre>' . htmlspecialchars($response , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <?php
  }
  elseif(isset($_GET['aaa_log_id'])){
    $id= urldecode($_GET[aaa_log_id]);
    $log_details = Logger::getLogger()->ReadLog($id,'aaa');

    ?>
    <h2 class="log-heading">Log ID : <?php echo$id= htmlentities( $log_details->getID(), ENT_QUOTES, 'utf-8' ); ?>  (AAA Logs)</h2>

      <p>
        <?php 

        $timestamp=$log_details->getUnixtimestamp();
        $realm=$log_details->getgroupid();
        $method=$log_details->getApiMethod();
        $ale_username=$log_details->getAleusername();


          echo '<pre>Timestamp: '.$timestamp.'<br>';
          echo 'Realm: '.$realm.'<br>';
          echo 'API UserName: '.$ale_username.'<br>';
          echo 'BI System: '.$_SERVER['SERVER_NAME'].'</pre>';
        ?>
      </p>

     <p>
      <?php
      $url=$log_details->getDescription();
      echo '<h2 class="log-heading">URL</h2><pre>' . strtoupper($method).'<br>'.htmlspecialchars($url , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <p>
      <?php
      $request=$log_details->getApiData();
      echo '<h2 class="log-heading">Request</h2><pre>' . htmlspecialchars($request , ENT_QUOTES) . '</pre>';
      ?>
    </p>

    <p>
      <?php
      $response=$log_details->getApiDescription();
      $response=str_replace(array("\\n","\\r", "\\", " "),'',$response); 
      echo '<h2 class="log-heading">Response</h2><pre>' . htmlspecialchars($response , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <?php
  }
  elseif(isset($_GET['ap_log_id'])){
      $id= urldecode($_GET[ap_log_id]);
      $log_details = Logger::getLogger()->ReadLog($id,'vsz');

    ?>
    <h2 class="log-heading">Log ID : <?php echo htmlentities( $log_details->getID(), ENT_QUOTES, 'utf-8' ); ?> (VSZ Logs)</h2>

    <p>
      <?php 

      	$timestamp=$log_details->getUnixtimestamp();
      	$realm=$log_details->getRealm();
        echo '<pre>Timestamp: '.$timestamp.'<br>';
        echo 'Realm: '.$realm.'<br>';
        echo 'BI System: '.$_SERVER['SERVER_NAME'].'</pre>'; 
      ?>
    </p>
	
	 <?php
      $description=$log_details->getDescription();
      $method=$log_details->getApiMethod();
      //echo htmlspecialchars($description , ENT_QUOTES);
      echo '<h2 class="log-heading">URL</h2><pre>'.strtoupper($method).'<br>'.htmlspecialchars($description , ENT_QUOTES) . '</pre>';
      ?>
    <p>
    <p>
      <?php
      $request=$log_details->getApiData();
      echo '<h2 class="log-heading">Request</h2><pre>' . htmlspecialchars($request , ENT_QUOTES) . '</pre>';
      ?>
    </p>
      <?php
      $response=$log_details->getApiDescription();
      echo '<h2 class="log-heading">Response</h2><pre>' . htmlspecialchars($response , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <?php
  }
  elseif(isset($_GET['firwall_log_id'])){
    $id= urldecode($_GET['firwall_log_id']);
    $log_details = Logger::getLogger()->ReadLog($id,'Firwall');

  ?>
  <h2 class="log-heading">Log ID : <?php echo htmlentities( $log_details->getID(), ENT_QUOTES, 'utf-8' ); ?> (Firewall Logs)</h2>

  <p>
    <?php 

      $timestamp=$log_details->getUnixtimestamp();
      $realm=$log_details->getRealm();
      echo '<pre>Timestamp: '.$timestamp.'<br>';
      echo 'Realm: '.$realm.'<br>';
      echo 'BI System: '.$_SERVER['SERVER_NAME'].'</pre>'; 
    ?>
  </p>

 <?php
    $description=$log_details->getDescription();
    $method=$log_details->getApiMethod();
    //echo htmlspecialchars($description , ENT_QUOTES);
    echo '<h2 class="log-heading">URL</h2><pre>'.strtoupper($method).'<br>'.htmlspecialchars($description , ENT_QUOTES) . '</pre>';
    ?>
  <p>
  <p>
    <?php
    $request=$log_details->getApiData();
    echo '<h2 class="log-heading">Request</h2><pre>' . htmlspecialchars($request , ENT_QUOTES) . '</pre>';
    ?>
  </p>
    <?php
    $response=$log_details->getApiDescription();
    echo '<h2 class="log-heading">Response</h2><pre>' . htmlspecialchars($response , ENT_QUOTES) . '</pre>';
    ?>
  </p>
  <?php
}
  elseif(isset($_GET['dsf_api_log_id'])){

    $id= urldecode($_GET['dsf_api_log_id']);
    $log_details = Logger::getLogger()->ReadLog($id,'dsf');
    
    ?>
    <h2 class="log-heading">Log ID : <?php echo htmlentities( $log_details->getID(), ENT_QUOTES, 'utf-8' ); ?> (DSF Logs)</h2>

      <p>
        <?php 
        
        $record_count_text = '';
        if($log_details->getUnixtimestamp() == 'getSessions'){
          $record_count_text = 'Records Count:';
        }

        $timestamp=$log_details->getUnixtimestamp();
        $realm=$log_details->getRealm();
        $method=$log_details->getApiMethod();
        
        echo '<pre>Timestamp: '.$timestamp.'<br>';
        echo 'Realm: '.$realm.'<br>';
        echo 'BI System: '.$_SERVER['SERVER_NAME'].'</pre>';
        
        ?>
      </p>

    

    <p>
      <?php
      $url=$log_details->getDescription();
      echo '<h2 class="log-heading">URL</h2><pre>' . strtoupper($method).'<br>'.htmlspecialchars($url , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <p>
      <?php
      $request=$log_details->getApiData();
      echo '<h2 class="log-heading">Request</h2><pre>' . htmlspecialchars($request , ENT_QUOTES) . '</pre>';
      ?>
    </p>

    <p>
      <?php
      $response=$log_details->getApiDescription();
      $response=str_replace(array("\\n","\\r", "\\", " "),'',$response); 
      echo '<h2 class="log-heading">Response</h2><pre>' .$record_count_text. htmlspecialchars($response , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <?php
  }elseif(isset($_GET['zabbix_api_log_id'])){

    $id= urldecode($_GET['zabbix_api_log_id']);
    $log_details = Logger::getLogger()->ReadLog($id,'zabbix');
    
    ?>
    <h2 class="log-heading">Log ID : <?php echo htmlentities( $log_details->getID(), ENT_QUOTES, 'utf-8' ); ?> (Zabbix Logs)</h2>

      <p>
        <?php 
        
        $record_count_text = '';
        if($log_details->getUnixtimestamp() == 'getSessions'){
          $record_count_text = 'Records Count:';
        }

        $timestamp=$log_details->getUnixtimestamp();
        $realm=$log_details->getRealm();
        $method=$log_details->getApiMethod();
        
        echo '<pre>Timestamp: '.$timestamp.'<br>';
        echo 'Realm: '.$realm.'<br>';
        echo 'BI System: '.$_SERVER['SERVER_NAME'].'</pre>';
        
        ?>
      </p>

    

    <p>
      <?php
      $url=$log_details->getDescription();
      echo '<h2 class="log-heading">URL</h2><pre>' . strtoupper($method).'<br>'.htmlspecialchars($url , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <p>
      <?php
      $request=$log_details->getApiData();
      echo '<h2 class="log-heading">Request</h2><pre>' . htmlspecialchars($request , ENT_QUOTES) . '</pre>';
      ?>
    </p>

    <p>
      <?php
      $response=$log_details->getApiDescription();
      $response=str_replace(array("\\n","\\r", "\\", " "),'',$response); 
      echo '<h2 class="log-heading">Response</h2><pre>' .$record_count_text. htmlspecialchars($response , ENT_QUOTES) . '</pre>';
      ?>
    </p>
    <?php
  }
  else{
    echo "ID is empty!. Try again.";
  }?>
</body>
