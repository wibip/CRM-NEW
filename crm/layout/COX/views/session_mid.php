<?php
$months_count=0;
$btn_count=0;
$act_count=0;
function month_difference($from, $to) {

        $fromYear = date("Y", strtotime($from));
        $fromMonth = date("m", strtotime($from));
        $toYear = date("Y", strtotime($to));
        $toMonth = date("m", strtotime($to));
        if ($fromYear == $toYear) {
            return ($toMonth-$fromMonth)+1;
        } else {
            return (12-$fromMonth)+1+$toMonth;
        }

}

function getMonthsInRange($startDate, $endDate) {
    $months = array();
    while (strtotime($startDate) <= strtotime($endDate)) {
        $months[] = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)), );
        $startDate = date('d M Y', strtotime($startDate.
            '+ 1 month'));
    }

    return $months;
}

function lastday($month = '', $year = '') {
   if (empty($month)) {
      $month = date('m');
   }
   if (empty($year)) {
      $year = date('Y');
   }
   $result = strtotime("{$year}-{$month}-01");
   $result = strtotime('-1 second', strtotime('+1 month', $result));
   return date('Y-m-d', $result);
}

function firstDay($month = '', $year = '')
{
    if (empty($month)) {
      $month = date('m');
   }
   if (empty($year)) {
      $year = date('Y');
   }
   $result = strtotime("{$year}-{$month}-01");
   return date('Y-m-d', $result);
}


$mno_time_zone = $db->getValueAsf("SELECT timezones AS f from exp_mno WHERE mno_id='$user_distributor'");

$private_module=$package_functions->getSectionType('private_module',$package_functions->getAdminPackage());

function syncCustomer($Response2){
    
    $bulk_profile_data2 = json_decode($Response2,true);
    $bulk_profile_datasession=$bulk_profile_data2['Description'];

    $finalarray=$bulk_profile_datasession;
    if (empty($finalarray)) {
      $finalarray=array();
    }
        

    return $finalarray;
    }

    function uniqueAssocArray($array, $uniqueKey, $uniqueKey2) {
  if (!is_array($array)) {
    return array();
  }
  $uniqueKeys = array();
  foreach ($array as $key => $item) {
    if ((!in_array($item[$uniqueKey], $uniqueKeys)) AND (!in_array($item[$uniqueKey2], $uniqueKeys))) {
      $uniqueKeys[$item[$uniqueKey]] = $item;
    }
  }
  return $uniqueKeys;
}


    // TAB Organization
    if(isset($_GET['t'])){
        $variable_tab='tab'.$_GET['t'];
        $$variable_tab='set';
    }else{
        //initially page loading///
        if($user_type == 'ADMIN'){
            $tab8="set";

        }else if($user_type == 'MVNA'){
            $tab5="set";

        }else {

            $tab1="set";

        }
    }

  

  $mno_package = $db->select1DB("SELECT system_package FROM exp_mno WHERE mno_id='$user_distributor' LIMIT 1");
$mno_package = $mno_package[system_package];
//echo $user_distributor;

 $network_name = $package_functions->getOptions('NETWORK_PROFILE',$mno_package);


if(strlen($network_name) == 0){
  $network_name = $db->setVal('network_name','ADMIN');
}

$base_url=$db->setVal('global_url','ADMIN');
$internal_url = $db->setVal('camp_base_url','ADMIN');

 $session_profile=$db->getValueAsf("SELECT ses_creation_method as f FROM exp_network_profile WHERE network_profile='$network_name'");
 $aaa_profile=$db->getValueAsf("SELECT ses_creation_method as f FROM exp_network_profile WHERE network_profile='$network_name'");
 $network_profile=$db->getValueAsf("SELECT api_network_auth_method as f FROM exp_network_profile WHERE network_profile='$network_name'");
require_once('src/sessions/'.$session_profile.'/index.php');
$ale=new session_profile($network_name,$session_profile,$internal_url,$system_package);

require_once('src/AAA/'.$network_profile.'/index.php');
$nf=new aaa($network_name,'');

//$mno_time_zone = $db->getValueAsf("SELECT timezones AS f from exp_mno WHERE mno_id='$user_distributor'");

$private_module=$package_functions->getSectionType('private_module',$package_functions->getAdminPackage());

function httpGet($url)
{
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //  curl_setopt($ch,CURLOPT_HEADER, false);

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}

function macDisplay($mac_relm){

    $mac_relm = str_replace(':', '', $mac_relm);
    $mac_relm = str_replace('-', '', $mac_relm);

    $arr1 = str_split($mac_relm);

    $i = -1;

    foreach ($arr1 as $key => $value){
        $mac .= $value;
        if($i % 2 == 0){
            $mac .= ":";
        }
        $i++;
    }

    return trim($mac,':');
}

$key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'camp_base_url'";

$query_results=mysql_query($key_query);
while($row=mysql_fetch_array($query_results)){

    $settings_value = $row[settings_value];
    $base_url = trim($settings_value,"/");
}
$base_folder=$db->setVal('portal_base_folder','ADMIN');



//admin -> Service Provider form type
$key_query2 = "SELECT settings_value FROM exp_settings WHERE settings_code = 'service_account_form' LIMIT 1";
$query_result2=mysql_query($key_query2);
$row2=mysql_fetch_array($query_result2);
$mno_form_type = $row2[settings_value];

$session_profile = $db->setVal("session_network","ADMIN");

if(isset($_POST['search_btn_session'])){
  $search_btn_session = true;  
  $vanue_id = $_POST['vanue_id'];
}elseif(isset($_GET['search_btn_session'])) {
$search_btn_session = true;
$vanue_id = $_GET['vanue_id'];
}else{
  $search_btn_session = false;  
}

    if($search_btn_session) {

        
        
                if ($vanue_id == "all") {
                    $sessionresult=$ale->getallSessions($user_distributor,$mno_time_zone);
                    $newjsonvalue=syncCustomer($sessionresult);

                } else {
                    $sessionresult=$ale->getSessionsbyrealm($vanue_id,$mno_time_zone);

                    $newjsonvalue=syncCustomer($sessionresult);
                    

                }


    

    }

?>
    <!--***************Delete Sessions ***************-->
    <?php
    if(isset($_GET['dl_id'])){
         //$session_profile='ALE_REST_5';
        //$session_profile = $db->setVal("session_network","ADMIN");
        $form_secreat3=$_GET['s3'];
             
             $state=$_GET['uni_account_state'];
             $token=$_GET['token'];
             
        if($form_secreat3==$_SESSION['FORM_SECRET3']){
            $dl_ses_id=$_GET['dl_id'];
            
           
            $rm_session_realm=$_GET['search_id'];

            $mac=$_GET['mac_id'];
            $state=$_GET['state'];
            $session_token=$_GET['session_token'];

            

                if(strlen($rm_session_realm)>0){

                   $responce=$ale->delSessions($mac,$rm_session_realm,$session_token);
                   //print_r($responce);
                    $newarray= json_decode($responce,true);

                    if($newarray['status_code']=='200'){
                        mysql_query("DELETE FROM `exp_customer_aaa_sessions` WHERE `session_id`='$rm_session_mac'");
                        $_SESSION['add_msg3'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'> x </button><strong>".$message_functions->showMessage('session_remove_success')."</strong></div>";

                    }
                    else{
                        $failed = 1;
                        $_SESSION['add_msg3'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> x </button><strong>".$message_functions->showMessage('session_remove_fail','2009')."</strong></div>";

                    }

            }

        }else{
            $_SESSION['msg1']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                                                <strong>".$message_functions->showMessage('transection_fail')."</strong></div>";
        }
    }




    elseif(isset($_POST['li_view'])){

        $form_secret=$_POST['secret'];
        if($form_secret==$_SESSION['FORM_SECRET']){

          $li_param=array();
            $selected_end_date='';
            $selected_end_date=$_POST['to'];

            
            $months_count=month_difference($_POST['from'], $_POST['to']);
            
            $months_array_o=array();

            $months_array=getMonthsInRange($_POST['from'], $_POST['to']);
            //$months_array=array_reverse($months_array);
            
           


            $stat_source=$package_functions->getSectionType('ABUSE_REPORT_SOURCE', $admin_system_package=$db->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='ADMIN'"));
            if (empty($stat_source)) {
                $stat_source='ABUSE_API';
            }

            if($months_count>1){// If there are more than one month selected, set end point to last day of month

              $selected_year = date('Y', strtotime($_POST['from']));
        $selected_month = date('F', strtotime($_POST['from']));

              //$li_param['to']=lastday($selected_month, $selected_year);

        $success_count=0;
              for($i=1; $i<=$months_count;$i++){ 

                if($i ==1){
                  $first_day=date('m/d/Y', strtotime($_POST['from']));
                }else{
                  $first_day=firstDay($months_array[$i-1]['month'], $months_array[$i-1]['year']);
                        $first_day=date('m/d/Y', strtotime($first_day));
                }

                if($i == $months_count){
                  $last_day= date('m/d/Y', strtotime($selected_end_date));
                }else{
                  $last_day=lastday($months_array[$i-1]['month'], $months_array[$i-1]['year']);
                        $last_day=date('m/d/Y', strtotime($last_day));
                }
                    
                    

                $li_param=array(

                  'ipaddress' => $_POST['ipaddress'],
                  'from' => $first_day,
                  'to' => $last_day,
                  'from_time' => $_POST['from_time'],
                  'to_time' => $_POST['to_time'],
                  'port_number_from' => $_POST['port_number_from'],
                  'search_type' => $_POST['search_type']

                );
                    
                    //print_r($li_param);echo '<br>';

                $li_param_json=json_encode($li_param);

                $li_url=$base_url.'/src/statistics/'.$stat_source.'/index.php?task=li_list&system_package='.$system_package.'&li_param='.$li_param_json;
                $li_response=httpGet($li_url);
                    
                    

                $li_response_r=explode('-',$li_response);
                $li_success=$li_response_r[0];
                    
                if($li_success=='success'){
                        
                        $success_count= $success_count + 1;
                        
                  $li_view_id=$li_response_r['1'];
                  
                  $_SESSION['li_download_id']=$li_view_id;
                  $btn_count = $i;
                        break;

                }

              }

                if($success_count > 0){
                    
                    $last_date_of_array='';$f_time='';$t_time='';$ip_addr='';
                    $last_date_of_array=$selected_end_date;
                    $f_time= $_POST['from_time'];
                    $e_time= $_POST['to_time'];
                    $ip_addr=$_POST['ipaddress'];
                    
                   mysql_query("INSERT INTO `exp_li_report_log` (
                        `unique_id`,
                        `type`,
                        `create_user`,
                        `create_date`
                        ) 
                        VALUES
                        (
                        '$li_view_id',
                        'view',
                        '$user_name',
                        NOW()
                        ) 
                        ");
                }else{
                    
                    mysql_query("INSERT INTO `exp_li_report_log` (
                  `unique_id`,
                  `type`,
                  `create_user`,
                  `create_date`
                  ) 
                  VALUES
                  (
                  'no results',
                  'view',
                  '$user_name',
                  NOW()
                  ) 
                  ");


                $_SESSION['msg_2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                <strong>".$message_functions->showMessage('li_report_no_results')."</strong></div>";
                }
            }else{
                
                $li_param=array(

                    'ipaddress' => $_POST['ipaddress'],
                    'from' => $_POST['from'],
                    'to' => $_POST['to'],
                    'from_time' => $_POST['from_time'],
                    'to_time' => $_POST['to_time'],
                    'port_number_from' => $_POST['port_number_from'],
                    'search_type' => $_POST['search_type']

                );
                 //print_r($li_param);echo '<br>';
              $li_param_json=json_encode($li_param);

              $li_url=$base_url.'/src/statistics/'.$stat_source.'/index.php?task=li_list&system_package='.$system_package.'&li_param='.$li_param_json;
              $li_response=httpGet($li_url);


              $li_response_r=explode('-',$li_response);
              $li_success=$li_response_r[0];
              if($li_success=='success'){
                $li_view_id=$li_response_r['1'];
                $last_date_of_array='';$f_time='';$t_time='';$ip_addr='';
                $last_date_of_array=$selected_end_date;
                $f_time= $_POST['from_time'];
                $e_time= $_POST['to_time'];
                $ip_addr=$_POST['ipaddress'];
                $_SESSION['li_download_id']=$li_view_id;
                mysql_query("INSERT INTO `exp_li_report_log` (
                  `unique_id`,
                  `type`,
                  `create_user`,
                  `create_date`
                  ) 
                  VALUES
                  (
                  '$li_view_id',
                  'view',
                  '$user_name',
                  NOW()
                  ) 
                  ");
              }elseif ($li_success=='fail'){

                mysql_query("INSERT INTO `exp_li_report_log` (
                  `unique_id`,
                  `type`,
                  `create_user`,
                  `create_date`
                  ) 
                  VALUES
                  (
                  'no results',
                  'view',
                  '$user_name',
                  NOW()
                  ) 
                  ");


                $_SESSION['msg_2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                <strong>".$message_functions->showMessage('li_report_no_results')."</strong></div>";

              }
            }

            

        }else{
            $_SESSION['msg_2']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                                                <strong>".$message_functions->showMessage('transection_fail')."</strong></div>";
        }
    }

    elseif(isset($_POST['li_view2'])){

          $form_secret=$_POST['secret2'];
       
          if($form_secret==$_SESSION['FORM_SECRET']){
              
              $li_param=array();
              $li_param['ipaddress']=$_POST['ipaddress2'];
              $li_param['period']=$_POST['session_period'];
  
              $li_param_json=json_encode($li_param);
  
              $stat_source=$package_functions->getSectionType('ABUSE_REPORT_SOURCE', $admin_system_package=$db->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='ADMIN'"));
  
              //$li_url=$base_url.'/src/statistics/'.$stat_source.'/index.php?task=li_list2&li_param='.$li_param_json;

              $li_url=$base_url.'/src/statistics/'.$stat_source.'/index.php?task=li_list2&system_package='.$system_package.'&li_param='.$li_param_json;
  
              $li_response=httpGet($li_url);
  
              //print_r($li_response); die();
  
              $li_response_r=explode('-',$li_response);
              $li_success2=$li_response_r[0];
  
              if($li_success2=='success'){
                  
                  $li_view_id2=$li_response_r['1'];
                  $_SESSION['li_download_id2']=$li_view_id2;
                  mysql_query("INSERT INTO `exp_li_report_log` (
                                `unique_id`,
                                `type`,
                                `create_user`,
                                `create_date`
                              ) 
                              VALUES
                                (
                                  '$li_view_id',
                                  'view',
                                  '$user_name',
                                  NOW()
                                ) 
                              ");
              }elseif ($li_success2=='fail'){
  
                  mysql_query("INSERT INTO `exp_li_report_log` (
                                `unique_id`,
                                `type`,
                                `create_user`,
                                `create_date`
                              ) 
                              VALUES
                                (
                                  'no results',
                                  'view',
                                  '$user_name',
                                  NOW()
                                ) 
                              ");
  
  
                  $_SESSION['msg_2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                                  <strong>".$message_functions->showMessage('li_report_no_results')."</strong></div>";
  
              }
          }else{ 
              $_SESSION['msg_2']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                                                  <strong>".$message_functions->showMessage('transection_fail')."</strong></div>";
          }
      }
      

elseif (isset($_POST['blacklist'])){
    $form_secret=$_POST['black_form_secret'];
    if($form_secret==$_SESSION['FORM_SECRET']){
        $do_blacklist_mac = $_POST['black_mac'];

        //clear mac
        $do_blacklist_mac = str_replace(':','',$do_blacklist_mac);
        $do_blacklist_mac = str_replace('-','',$do_blacklist_mac);
        $do_blacklist_mac = strtolower($do_blacklist_mac);

        $do_black_period = $_POST['blacklist_period'];

        //calculate whitelist date

        if($do_black_period!='indefinite'){

            $diff_time = new DateInterval($do_black_period);
            $current_time = new DateTime();

            $do_black_time= $current_time->format('U');

        $do_white_time=$current_time->add($diff_time);
        $do_white_time = $do_white_time->format('U');
        }else{
            $current_time = new DateTime();
            $do_black_time= $current_time->format('U');
            $do_white_time = 'indefinite';
           
        }
        
        $period_view=$period_array[$do_black_period];

        //$customer_realm=$db->getValueAsf("SELECT realm AS f FROM exp_customer_sessions_mac WHERE mac='$do_blacklist_mac'");
        $q_rlm = "SELECT DISTINCT s.realm FROM exp_customer_sessions_mac s JOIN exp_mno_distributor d ON s.distributor_code=d.distributor_code
                                WHERE d.mno_id = '".$user_distributor."' AND s.realm <>'' AND s.realm IS NOT NULL";
        $rlm_data = $db->selectDB($q_rlm);

        if($rlm_data['rowCount']>0) {
            foreach ($rlm_data['data'] as $rlm_datum) {
                $customer_realm = $rlm_datum['realm'];
                $remove_aaa_acc = $nf->deleteAccount($do_blacklist_mac, $customer_realm);


                parse_str($remove_aaa_acc, $remove_aaa_acc);
                //$sessionresult=$ale->getSessionsbymac($do_blacklist_mac,$customer_realm);
            }
        }

        $period_view=$period_array[$do_black_period];

        $blacklist_mac_q="REPLACE INTO exp_customer_blacklist (is_enable,mac, period, period_view, bl_timestamp, wl_timestamp, mno, create_date) VALUES ('1','$do_blacklist_mac','$do_black_period','$period_view','$do_black_time','$do_white_time','$user_distributor',NOW())";
        $blacklist_r=mysql_query($blacklist_mac_q);

        

        if($blacklist_r){
            $_SESSION['msg_2']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showNameMessage('blacklist_mac_success',$_POST['black_mac'])."</strong></div>";
        }else{
            $_SESSION['msg_2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showNameMessage('blacklist_mac_fail',$_POST['black_mac'],'2001')."</strong></div>";
        }


    }else{
        $_SESSION['msg_2']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                            <strong>".$message_functions->showMessage('transection_fail')."</strong></div>";
    }
}elseif (isset($_GET['wl_id'])){
    if($_SESSION['FORM_SECRET']==$_GET['wl_secret']){
        $wl_mac_id = $_GET['wl_id'];

        $wl_mac_archive_q = "INSERT INTO exp_customer_blacklist_archive (mac, period, bl_timestamp, wl_timestamp, create_date, last_update, mno)
                    SELECT mac, period, bl_timestamp, wl_timestamp, create_date, last_update, mno FROM exp_customer_blacklist WHERE id='$wl_mac_id'";
        $wl_mac_archive_r = mysql_query($wl_mac_archive_q);
        if($wl_mac_archive_r){
            $wl_q = "DELETE FROM exp_customer_blacklist WHERE id='$wl_mac_id'";
            $wl_r = mysql_query($wl_q);
            if($wl_r){
                $_SESSION['msg_2']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showMessage('whitelist_mac_success',$wl_mac_id)."</strong></div>";
            }else{
                $_SESSION['msg_2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showMessage('whitelist_mac_fail',$wl_mac_id,'2003')."</strong></div>";
            }
        }else{
            $_SESSION['msg_2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showMessage('whitelist_mac_fail',$wl_mac_id,'2001')."</strong></div>";
        }
    }else{
        $_SESSION['msg_2']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                            <strong>".$message_functions->showMessage('transection_fail')."</strong></div>";

    }

}



if (isset($_GET['modify_bl_en'])){
    
    $modd_type=$_GET['modify_bl_en'];
    $modd_id=$_GET['id'];
    
    $mod_is_en=$_GET['is_enable'];
    
    if($mod_is_en=='0'){
        
        $modd_msg='Enabling';
    }else{
        
        $modd_msg='Disabling';
    }
    
    
    ///////////
    $key_query11 = "SELECT mac FROM `exp_customer_blacklist` WHERE id = '$modd_id'";
    $query_results11=mysql_query($key_query11);
    while($row11=mysql_fetch_array($query_results11)){
        $rm_session_mac_mac = $db->macFormat($row11[mac],$mac_format);
    }
    
     //$modd_q = "UPDATE `exp_customer_blacklist` SET `is_enable`='$mod_is_en' WHERE `id`='$modd_id'";
    // $modd_q_exe = mysql_query($modd_q);
     
     
     $this_time_stamp = time();
         $arc_1 = "INSERT INTO exp_customer_blacklist_archive
            (`type`,`mac`,`period`,`bl_timestamp`,`wl_timestamp`,`mno`,`create_date`)
            SELECT 'Manual',`mac`,`period`,`bl_timestamp`,'$this_time_stamp',`mno`,`create_date` FROM `exp_customer_blacklist`
            WHERE id = '$modd_id'";
                $ex1 = mysql_query($arc_1);
     
            $arc_2 = "DELETE FROM `exp_customer_blacklist` WHERE id = '$modd_id'";
            $ex2 = mysql_query($arc_2);     
                
    
            if($ex2){
                $_SESSION['msg_2']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showNameMessage('whitelist_mac_success',$rm_session_mac_mac)."</strong></div>";
            }else{
                $_SESSION['msg_2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showNameMessage('whitelist_mac_fail',$rm_session_mac_mac,'2001')."</strong></div>";
            }   
    
    
    
}


    //Form Refreshing avoid secret key/////
    $secret=md5(uniqid(rand(), true));
    $_SESSION['FORM_SECRET'] = $secret;




?>
<script type="text/javascript">
    function checkSessionDeleted(realm,mac,callback) {
        var URL = 'ajax/checkSessionDeleted.php';

        var init_auth_data = {realm:realm,mac:mac};
        init_auth_data= JSON.stringify(init_auth_data);
        init_auth_data = CryptoJS.AES.encrypt(JSON.stringify(init_auth_data), '<?php echo $hgtadle67; ?>', {format: CryptoJSAesJson}).toString();
        var returnData;
        $.ajax({
            url : URL,
            type: "POST",
            data : {key:init_auth_data},
            success: function(msg, status, jqXHR)
            {
                //alert(msg);
                callback(msg);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert("Network Error");
            }
        });

    }

</script>

<div class="main" >
        <div class="main-inner" >
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget ">

                            <div class="widget-header">
                                <!-- <i class="icon-sitemap"></i> -->
                                <h3>Reports</h3>
                            </div><!-- /widget-header -->
                            
                                        <?php

                                            if(isset($_SESSION['msg1'])){
                                                echo $_SESSION['msg1'];
                                                unset($_SESSION['msg1']);

                                            }


                                            if(isset($_SESSION['msg_2'])){
                                                echo $_SESSION['msg_2'];
                                                unset($_SESSION['msg_2']);
                                            }
                                                    if(isset($_SESSION['add_msg3'])){
                                                        echo $_SESSION['add_msg3'];
                                                        unset($_SESSION['add_msg3']);
                                                    }

                                                ?>

                            <div class="widget-content">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs">

                                    

                                        
                                                <li <?php if (isset($tab1)){ ?>class="active" <?php } ?>><a href="#tab1" data-toggle="tab">Active Sessions</a></li>

                                                <li <?php if (isset($tab2)){ ?>class="active" <?php } ?>><a href="#tab2" data-toggle="tab">Historical Sessions</a></li>
                                                <?php if(in_array("QUARTER_SESSIONS",$features_array) || $package_features=="all"){ ?> <li <?php if (isset($tab4)){ ?>class="active" <?php } ?>><a href="#tab4" data-toggle="tab">Quarterly Historical Sessions</a></li> <?php } ?>
                                                <li <?php if (isset($tab3)){ ?>class="active" <?php } ?>><a href="#tab3" data-toggle="tab">Manage MAC Addresses</a></li>


                                    </ul>
                                    <br>


                                    <div class="tab-content">


                                            <!-- ******************************************************* -->

                                        <div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="tab1">



                                                <h3>Session Search</h3>
                                                <p>

                                                </p>

                                                <form id="edit-profile" action="?t=1" method="post" class="form-horizontal" >


                                                    <fieldset>



                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">Limit Search to</label>

                                                            <div class="controls">
                                                                <div class="input-prepend input-append">
                                                                    <select style="    margin-right: 20px;    margin-bottom: 15px;" class="span4" name="vanue_id" id="vanue_id" required>
                                                                        <option value="all">ALL Venues</option>

                                                                        <?php

                                                                        $key_query = "SELECT d.`distributor_name`,d.`distributor_code`,g.`group_number` FROM `exp_mno_distributor` d,`exp_distributor_groups` g
                                                                                WHERE d.`distributor_code`=g.`distributor`
                                                                                AND `mno_id`='$user_distributor' ORDER BY g.`group_number` ASC";

                                                                        $query_results=mysql_query($key_query);
                                                                        while($row=mysql_fetch_array($query_results)){
                                                                            $distributor_code = $row[distributor_code];
                                                                            $distributor_name = $row[group_number];

                                                                            echo '<option value="'.$distributor_name.'">'.$distributor_name.'</option>';
                                                                        }

                                                                        ?>


                                                                    </select>
                                                                    <button style="    padding: 6px 20px !important;
    margin-bottom: 15px;" class="btn btn-primary" type="submit" name="search_btn_session" id="search_btn">Search</button>

                                                                </div>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                    </fieldset>


                                    <?php if(isset($search_btn_session)|| isset($_GET['search_id'])){

                                        if(isset($_GET['search_id'])){
                                            $vanue_id= $_GET['search_id'];
                                        }

                                        ?>
                                                    <div class="widget widget-table action-table">
                                                        <div class="widget-header">
                                                           <!--  <i class="icon-th-list"></i> -->

                                                            <h3>Session Search</h3>
                                                        </div>
                                                        <!-- /widget-header -->
                                                        <div class="widget-content table_response">
                                                            <div style="overflow-x:auto">           
                                                            <table id="session_search_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">DEVICE MAC</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">AP MAC/GW MAC</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Session State</th>
                                                                    <?php if($private_module==1){ ?>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Session Type</th>
                                                                    <?php } ?>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">START TIME</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">SSID</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Customer Account# (realm)</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">GATEWAY IP</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">GATEWAY TYPE</th>


                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Remove Sessions</th>


                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                       
                                        if($search_btn_session || isset($_GET['search_id'])){
                                           
                                           //print_r($newjsonvalue[0]);
                                           if ($newjsonvalue) {
                                            $res_arrr=array();
                                            
                                            
                                            //print_r($res_arrr2);
                                            //echo $session_id;
                                           $session_row_count=0;
                                            foreach ($newjsonvalue as $value2){
                                                //print_r($res_arrr);
                                                $session_row_count=$session_row_count+1;
                                                
                                                echo "<tr>";
                                                $mac=($value2['Mac']);
                                                $AP_Mac=($value2['AP_Mac']);
                                                $ssid=($value2['SSID']);
                                                $GW_ip=($value2['GW_ip']);
                                                $sh_realm=($value2['Realm']);
                                                $GW_Type=($value2['GW-Type']);
                                                $start_time=($value2['Session-Start-Time']);
                                                $newstatus=$value2['State'];
                                                $type= $value2['TYPE'];
                                                $session_id= $value2['Ses_token'];
                                            
                                                 if (strlen($mac)<1) {
                                                            $mac="N/A"; }
                                                if (strlen($AP_Mac)<1) {
                                                            $AP_Mac="N/A"; }
                                                if (strlen($ssid)<1) {
                                                            $ssid="N/A"; }
                                                if (strlen($GW_ip)<1) {
                                                            $GW_ip="N/A"; }
                                                if (strlen($sh_realm)<1) {
                                                            $sh_realm="N/A"; }
                                                if (strlen($GW_Type)<1) {
                                                            $GW_Type="N/A"; }
                                                if (strlen($start_time)<1) {
                                                            $start_time="N/A"; }

                                                echo "<td>".$mac."</td>";
                                                echo "<td>".$AP_Mac."</td>";
                                                echo "<td>".$newstatus."</td>";
                                                if($private_module==1){
                                                     echo "<td>".$type."</td>";
                                                    }
                                                echo "<td>".$start_time."</td>";
                                                echo "<td>".$ssid."</td>";
                                                echo "<td>".$sh_realm."</td>";
                                                echo "<td>".$GW_ip."</td>";
                                                echo "<td>".$GW_Type."</td>";
                                                
                                                
                                             /*foreach ($value2 as $key => $value) {
                                                //$session_row_count++;

                                                if (strlen($value)<1) {
                                                    $value="N/A";
                                                    # code...
                                                }
                                                echo "<td>".$value."</td>";
                                                

                                             }*/

                                             echo '<td>';
                                             if(strlen($session_id)>0 && $_GET['mac_id']!=$mac){
                                             echo '<center><a href="javascript:void();"  id="DL_' . $session_row_count . '"  class="btn  btn-small">
                                                                            <i class="btn-icon-only icon-trash"></i>Delete</a></center>
                                                                            </td><script type="text/javascript">
                                                                            $(document).ready(function() {
                                                                            $(\'#DL_' . $session_row_count . '\').easyconfirm({locale: {
                                                                                    title: \'Delete Session \',
                                                                                    text: \'Are you sure you want to delete session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                                    closeText: \'close\'
                                                                                     }});
                                                                                $(\'#DL_' . $session_row_count . '\').click(function() {
                                                                                    window.location = "?t=1&dl_id=' . $session_row_count . '&mac_id='.$mac.'&session_token='.$session_id.'&search_id=' . $sh_realm . '&s3=' . $_SESSION['FORM_SECRET3'].'&vanue_id=' . $vanue_id .'&search_btn_session=' . $search_btn_session .'"
                                                                                });
                                                                                });
                                            </script>';}
                                            elseif ($_GET['mac_id']==$mac){
                                                        echo'<a disabled id="DL_' . $session_row_count . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
                                                        <script type="text/javascript">
                                                        var deleteSessionCheck'.$mac.' = function (){
                                                            checkSessionDeleted(\''.$sh_realm.'\',\''.$mac.'\',function(data){
                                                                
                                                            if(data == \'0\'){
                                                            //alert(data);
                                                                $(\'#DL_' . $session_row_count .'\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
                                                            }else{
                                                                deleteSessionCheck'.$mac.'();
                                                            }   
                                                        });
                                                            
                                                        }
                                                        deleteSessionCheck'.$mac.'();
                                                        </script>
                                                        ';

                                                    }
                                                        else{
                                                            echo'<a disabled id=id="DL_' . $session_row_count . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Delete</a>';
                                                        }

                                             echo'</td>';
                                             
                                             echo "</tr>";
                                            }

                                        }
                                        else{
                                            echo "<td colspan=\"11\">No Active Sessions</td>";
                                        }

                                        }
                                        

                                        ?>

                                        </tbody>

                                                            </table>
                                                            

                                                                </div>
                                                                </div>
                                                        </div>
                                                    <?php 
                                    } ?>
                                                </form>
                                                <!--********************************-->
                                            </div><!--tab end-->
                                            <!--**********LI tab-->

                                            <div <?php if(isset($tab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="tab2">

                                <!--            <p>
                                            Lawful interception (LI) is obtaining communications network data pursuant to lawful authority for the purpose of analysis or evidence. Such data generally consist of signalling or network management information or, in fewer instances, the content of the communications.                                                <br/>
                                        <br>   <font color="#19bc9c"> Step 1.</font> Enter the Public IP address provided in the Lawful Intercept (LI) request (Ex. 122.122.122.12)  <br/>
                                            <font color="#19bc9c">    Step 2.</font> Set the Date Period requested In the LI request. Our records are stored on a 12 month rolling schedule. (Ex. 01/01/2016 to 02/01/2016)  <br/>
                                            <font color="#19bc9c">    Step 3.</font> [Optional] Provide the CGN Port Number if provided in the LI Request. It will be a number between 1-65535. (Do not use spaces or comma in the number)<br/>
                                            <font color="#19bc9c">    Step 4.</font> Click the "Download as CSV" button. The report will be generated automatically and downloaded to your computer as a "comma-separated values" file for post processing.<br/>
                                        
                                            </p> --> 

                                     <form name="lawful_form" id="lawful_form" class="form-horizontal" method="post" action="?t=2" onchange="change_li_view()">
                                                <div class="form-group">
                                                   <fieldset>



                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">Public IP Address</label>

                                                            <div class="controls col-lg-5 form-group">
                                                                
                                                                    <input autocomplete="off" type="text" id="ipaddress" name="ipaddress" class="span2 li_download_class form-control">

                                                                    

                                                                     </div>

                                                                    <!-- <script>
                                                                        var pattern = /\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/;
                                                                       var x_ip = 46;
                                                                        $('#ipaddress').keypress(function (e) {
                                                                            if (e.which != 8 && e.which != 0 && e.which != x_ip && (e.which < 48 || e.which > 57)) {
                                                                                /*console.log(e.which);*/
                                                                                return false;
                                                                            }
                                                                        }).keyup(function () {
                                                                            var this1_ip = $(this);
                                                                            if (!pattern.test(this1_ip.val())) {
                                                                                $('[data-fv-for=ipaddress]').css("display", "inline-block");
                                                                               
                                                                                while (this1_ip.val().indexOf("..") !== -1) {
                                                                                    this1_ip.val(this1_ip.val().replace('..', '.'));
                                                                                }
                                                                                x_ip = 46;
                                                                            } else {
                                                                                x_ip = 0;
                                                                                var lastChar_ip = this1_ip.val().substr(this1_ip.val().length - 1);
                                                                                if (lastChar_ip == '.') {
                                                                                    this1_ip.val(this1_ip.val().slice(0, -1));
                                                                                }
                                                                                var ip_ip = this1_ip.val().split('.');
                                                                                if (ip_ip.length == 4) {
                                                                                    $('[data-fv-for=ipaddress]').css("display", "none");
                                                                                    
                                                                                }
                                                                            }
                                                                        });
                                                                    </script> -->
                                                                    
                                                               
                                                                <!-- <small style="font: xx-small; color: red" id="validate_ip"></small> -->
                                                                                                                        <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

<?php /* ?>
                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">Search Type</label>

                                                            <div class="controls">
                                                                <div class="input-prepend input-append">
                                                                    <select name="search_type" id="search_type">
                                                                        <option value="days">Date Range</option>
                                                                        <option value="time">Time Range</option>
                                                                    </select>
                                                                    <script>
                                                                        $('#search_type').on('change',function () {
                                                                            if($('#search_type').val()=='days'){

                                                                                $('#search_time_range').hide();
                                                                                $('#search_date_range').show();
                                                                            }else{
                                                                                $('#search_date_range').hide();
                                                                                $('#search_time_range').show();
                                                                            }
                                                                        });
                                                                    </script>

                                                                </div>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->
                                                        
                                                        
                                                        <?php */ ?>
                                                        



                                                       <div class="control-group">
                                                            <label class="control-label" for="radiobtns">Date Range (GMT)</label>

                                                            <div class="controls col-lg-5 form-group" style="margin-bottom: 10px;">
                                                               
                                                                    <input autocomplete="off" type="text" class="inline_error inline_error_1 span2 li_download_class form-control li-time" name="from" id="from_li_date" placeholder="mm/dd/yyyy">

                                                                     To
                                                                     
                                                                    <input autocomplete="off" type="text" class="inline_error inline_error_2 span2 li_download_class form-control li-time" name="to" id="to_li_date" placeholder="mm/dd/yyyy">
                                                                    <input class="li-time" type="hidden" name="dob" />
                                                                    </div>
                                                                    
                                                              
                                                                <script>
                                                                    $( function() {
                                                                        $( "#from_li_date" ).datepicker({
                                                                            dateFormat: "mm/dd/yy",
                                                                            //minDate: '-6M',
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
        maxDate: '0'
                                                                        });
                                                                    } );
                                                                </script>
                                                                <script>
                                                                    $( function() {
                                                                        $( "#to_li_date" ).datepicker({
                                                                            dateFormat: "mm/dd/yy",
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
         beforeShow: function(input, inst) {
          var minDate = $('#from_li_date').datepicker('getDate');
          $('#to_li_date').datepicker('option', 'minDate', minDate);
          var maxDate = new Date(minDate.valueOf());
          maxDate.setDate(maxDate.getDate()+ 365);
          var dat = new Date();
          if (maxDate > dat) {
            $('#to_li_date').datepicker('option', 'maxDate', dat);
          }
          else{
            $('#to_li_date').datepicker('option', 'maxDate', maxDate);
          }
        }

                                                                        });
                                                                    } );
                                                                </script>
                                                            </div>
                                                            <!-- /controls -->
                                                                                                                <!-- /control-group -->





                                                       <div class="control-group" id="search_time_range" >
                                                            <label class="control-label" for="radiobtns">Time Range (GMT)</label>

                                                            <div class="controls col-lg-5 form-group">



                                                                    <select autocomplete="off" class="span2 li_download_class li-time" name="from_time" id="from_li_time">
                                                                        <?php
                                                                        $dt = new DateTime('GMT');
                                                                        $dt->setTime(0, 0);
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        for($i=0;$i<23;$i++){
                                                                            $dt->add(new DateInterval('PT1H'));
                                                                            echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>  To
                                                                    <select autocomplete="off" class="span2 li_download_class li-time" name="to_time" id="to_li_time">
                                                                        <?php
                                                                        $dt = new DateTime('GMT');
                                                                        $dt->setTime(0, 0);
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        for($i=0;$i<23;$i++){
                                                                            $dt->add(new DateInterval('PT1H'));
                                                                            echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        }
                                                                        $dt->add(new DateInterval('PT59M59S'));
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        ?>
                                                                    </select>
                                                                <input type="hidden" name="timeValidation" id="timeValidation" value="valid">
                                                            </div>
                                                           <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->



                                                       <div class="control-group">
                                                            <label class="control-label" for="radiobtns">CGN Port Number</label>

                                                            <div class="controls col-lg-5 form-group">

                                                                    <input autocomplete="off"  class="span2 form-control" name="port_number_from" id="port_number">  [1-65535] <!--  &nbsp; to
                                                                    <input type="number" min="2" max="65000" class="span2 li_download_class" name="port_number_to" id="port_number">-->
                                                                <script>
                                                                    $("#port_number").keypress(function(event){
                                                                        var ew = event.which;
                                                                        if(ew==8 || ew==0)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57)
                                                                            return true;

                                                                        return false;
                                                                    });
                                                                </script>


                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                        <script type="text/javascript">
                                                            $('.inline_error').on('change',function(){
                                                                $( function() {
                                                                    $( "#to_li_date").datepicker( "option", "minDate", $( "#from_li_date" ).datepicker( "getDate" ));
                                                                    $( "#from_li_date").datepicker( "option", "maxDate", $( "#to_li_date" ).datepicker( "getDate" ));
                                                                   $('#lawful_form').formValidation('revalidateField', 'dob');
                                                                } );



                                                            });
                                                           
                                                        



                                                        </script>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                         <div class="form-actions">
                                                            <input type="hidden" name="secret" value="<?php echo $secret;?>">
                                                                <button name="li_view" id="li_view"  type="submit" class="btn btn-primary" style="text-decoration:none">
                                                                <i class="btn-icon-only icon-download"></i> Generate Report

                                                                <?php if($camp_layout!="COX"){ ?>
                                                                    <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                            $("#li_view").easyconfirm({locale: {
                                                                            title: 'Historical Sessions',
                                                                            text: 'Are you sure you want to view the historical session report?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                                            button: ['Cancel',' Confirm'],
                                                                            closeText: 'close'
                                                                            }});
                                                                            $("#li_view").click(function() {

                                                                            });
                                                                        });
                                                                    </script>

                                                                    <?php } ?>
                                                    </button>

                                                            <?php
                                                            if($li_success=='success'){
                                                            ?>
                                                            <a id="li_download" href="ajax/export_report.php?li_report=<?php echo $li_view_id; ?>&user_name=<?php echo $user_name; ?>" class="btn btn-info" style="text-decoration:none">
                                                                <i class="btn-icon-only icon-download"></i> Download as CSV</a>
                                                            <?php }  ?>
                                                            </div>
                                                        
                                                        
                                                        
                                                        

                                                       <?php
                                                            if($li_success=='success'){
                                                       ?>

                                                       <div class="widget widget-table action-table">
                                                           <div class="widget-header">
                                                               <h3>Historical Sessions Report</h3>
                                                           </div>

                                                           <div class="widget-content table_response">
                                                               <div style="overflow-x:auto;" >
                                                                   <table id="ab_t"  class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                                       <thead>
                                                                       <tr>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">PUBLIC IP</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CUSTOMER ACCOUNT NUMBER</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">START Time</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">End Time</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">DURATION (Sec)</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">DEVICE MAC</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">AP/AC MAC</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">AC/WAG</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">VLAN</th>
                                                                          
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">DL (Bytes)</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">UP (Bytes)</th>
                                                                           
                                                                           <!--<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">PROPERTY ID</th> -->
                                                                           
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">SSID/Network</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Port Range From</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Port Range To</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Internal IP</th>
                                                                       </tr>
                                                                       </thead>
                                                                       <tbody id="histo_tbody">
                                                                       <?php
                                                                      //$system_package1 = substr($system_package, 0, 3);
                                                                      $key_query="SELECT
                                                                                  IF(nas_type = 'ac',l.nas_ip_address,l.`framed_ip_address`) AS public_ip,
                                                                                  IF(nas_type = 'ac',l.framed_ip_address,'') AS internal_ip,
                                                                                  FROM_UNIXTIME(LEFT(l.`session_start_time`, 10),'%m/%d/%Y %h:%i %p') AS 'Session_start_time',
                                                                                  FROM_UNIXTIME(LEFT(l.`session_end_time`, 10),'%m/%d/%Y %h:%i %p') AS 'Session_End_Time',
                                                                                  l.`acct_session_time` AS 'Duration',
                                                                                  l.`vlan_id` AS 'VLAN',
                                                                                  l.`nas_type` AS 'AC_WAG',
                                                                                  l.`session_mac` AS 'MAC',
                                                                                  l.`acct_input_octets` AS 'Down',
                                                                                  l.`acct_output_octets` AS 'Up',
                                                                                  l.`grp_realm` AS 'ICOMS',
                                                                                  l.`grp` AS 'Property_Name',
                                                                                  l.`realm` AS 'Customer_account_number',
                                                                                  d.`property_id` AS 'Property_ID',
                                                                                  l.`called_station_id` AS 'AP_MAC',
                                                                                  l.`nas_port_id` AS 'SSID',
                                                                                  l.`nas_port_range` AS 'Port_Range',
                                                                                  l.`dhcp_ip` AS 'dhcp_ip'
                                                                                  
                                                                                FROM
                                                                                  `exp_li_report` l LEFT JOIN `exp_mno_distributor` d
                                                                                  ON l.`realm`=d.`verification_number`
                                                                                WHERE
                                                                                `uniqid_id`='$li_view_id'";

                                                                                /*IF(nas_type = 'ac',l.nas_ip_address,l.`framed_ip_address`) AS public_ip,*/


                                                                       $query_results=mysql_query($key_query);
                                                                       while($row=mysql_fetch_array($query_results)){

                                                                        
                                                                        $public_ip_display = $row[public_ip];
                                                                        $Session_start_time_display = $row[Session_start_time];
                                                                        $Session_End_Time_display = $row[Session_End_Time];
                                                                        $Duration_display = $row[Duration];
                                                                        $VLAN_display = $row[VLAN];
                                                                        $AC_WAG = $row[AC_WAG];
                                                                        $MAC_display = $row[MAC];
                                                                        $Down_display = $row[Down];
                                                                        $Up_display = $row[Up];
                                                                        $ICOMS_display = $row[ICOMS];
                                                                        $Customer_account_number = $row[Customer_account_number];
                                                                        $Property_ID_display = $row[Property_ID];
                                                                        $AP_MAC_display = $row[AP_MAC];
                                                                        $SSID_display = $row[SSID];
                                                                        $Port_Range_display = $row[Port_Range];
                                                                        //$internal_ip_display = $row[internal_ip];
                                                                         $Property_Name = $row[Property_Name];
                                                                        $internal_ip_display = $row[dhcp_ip];

                                                                        if($Customer_account_number == 'null' || (strlen($Customer_account_number) < 1)){
                                                                              $Customer_account_number = 'N/A';
                                                                            }
                                                                        
                                                                        if(strlen($public_ip_display)==0){
                                                                            $public_ip_display = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        if($AC_WAG==ac){
                                                                            $AC_WAG = 'AC';
                                                                        }
                                                                        if($AC_WAG==wag){
                                                                            $AC_WAG = 'WAG';
                                                                        }
                                                                        
                                                                        if(strlen($AC_WAG)==0){
                                                                            $AC_WAG = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        if(strlen($Session_start_time_display)==0){
                                                                            $Session_start_time_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Session_End_Time_display)==0){
                                                                            $Session_End_Time_display = 'N/A';
                                                                        }                                                                           
                                                                        if(strlen($Duration_display)==0){
                                                                            $Duration_display = 'N/A';
                                                                        }
                                                                        if(strlen($VLAN_display)==0){
                                                                            $VLAN_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($MAC_display)==0){
                                                                            $MAC_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Down_display)==0){
                                                                            $Down_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Up_display)==0){
                                                                            $Up_display = 'N/A';
                                                                        }   
                                                                        if(strlen($ICOMS_display)==0){
                                                                            $ICOMS_display = 'N/A';
                                                                        }   
                                                                        if(strlen($Property_ID_display)==0){
                                                                            $Property_ID_display = 'N/A';
                                                                        }   
                                                                        if(strlen($AP_MAC_display)==0){
                                                                            $AP_MAC_display = 'N/A';
                                                                        }   
                                                                        if(strlen($SSID_display)==0){
                                                                            $SSID_display = 'N/A';
                                                                        }   
                                                                       
                                                                        
                                                                        if(strlen($internal_ip_display)==0){
                                                                            $internal_ip_display = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        $row_ar=explode('-',$row[Port_Range]);
                                                                        
                                                                        if(strlen($row_ar[0])==0){
                                                                            $row_ar[0] = 'N/A';
                                                                        }
                                                                        if(strlen($row_ar[1])==0){
                                                                            $row_ar[1] = 'N/A';
                                                                        }
                                                                        
                                                                           echo '<tr>';
                                                                           echo '<td>'.$public_ip_display.'</td>';
                                                                           echo '<td>'.$Customer_account_number.'</td>';
                                                                           echo '<td>'.$Session_start_time_display.'</td>';
                                                                           echo '<td>'.$Session_End_Time_display.'</td>';
                                                                           echo '<td>'.$Duration_display.'</td>';
                                                                           echo '<td>'.$MAC_display.'</td>';
                                                                           echo '<td>'.$AP_MAC_display.'</td>';
                                                                           echo '<td>'.$AC_WAG.'</td>';
                                                                           
                                                                           echo '<td>'.$VLAN_display.'</td>';
                                                                          
                                                                           echo '<td>'.$Down_display.'</td>';
                                                                           echo '<td>'.$Up_display.'</td>';
                                                                           
                                                                           //echo '<td>'.$Property_ID_display.'</td>';
                                                                          
                                                                           echo '<td>'.$SSID_display.'</td>';
                                                                           
                                                                           echo '<td>'.$row_ar[0].'</td>';
                                                                           echo '<td>'.$row_ar[1].'</td>';
                                                                           echo '<td>'.$internal_ip_display.'</td>';
                                                                           echo '</tr>';
                                                                       }

                                                                       ?>

                                                                       </tbody>
                                                                   </table>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <?php 

                                                       if($months_count >0){
                                                          $act_count=$months_count-$btn_count; 
                                                        for($i=1; $i<=$act_count;$i++){

                                                            //$months_array[$i-1]['month']
                                                            //$months_array[$i-1]['year']
                                                            //if($i==1)
                                                              //continue;

                                                            $first_day=firstDay($months_array[$btn_count+$i-1]['month'], $months_array[$btn_count+$i-1]['year']);
                                                            $first_day=date('m/d/Y', strtotime($first_day));

                                                            if($i == $act_count){
                                                              $last_day= date('m/d/Y', strtotime($last_date_of_array));
                                                            }else{
                                                              $last_day=lastday($months_array[$btn_count+$i-1]['month'], $months_array[$btn_count+$i-1]['year']);
                                                                $last_day=date('m/d/Y', strtotime($last_day));
                                                            }
                                                            

                                                      ?>
                                                        <button id="abuse_report_<?php echo $i; ?>" type="button" class="pagin btn btn-info abuse_btn"><?php echo $i; ?></button>&nbsp;

                                                        <input type="hidden" id="abuse_first_day_<?php echo $i; ?>" value="<?php echo $first_day; ?>">
                                                        <input type="hidden" id="abuse_last_day_<?php echo $i; ?>" value="<?php echo $last_day; ?>">
                                                        <input type="hidden" id="f_time" value="<?php echo $f_time; ?>">
                                                        <input type="hidden" id="e_time" value="<?php echo $e_time; ?>">
                                                        <input type="hidden" id="ip_addr" value="<?php echo $ip_addr; ?>">
                                                        <input type="hidden" id="system_package" value="<?php echo $system_package; ?>">
                                                        <input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
                                                      <?php
                                                        }
                                                      }

                                                     }
                                                                else{
                                                                    echo '';
                                                                }
                                                       ?>
                                                       


                                                            <!-- /form-actions -->



                                                    </fieldset> 
                                                    </div>
                                                </form>
                                                <style>
                                                
                                                .btn-info.clicked{
                                                    background: #03406A !important;
                                                }
                                                
                                                
                                                .btn-info.clicked:hover{
                                                    background: #03406A !important;
                                                }
                                                    
                                                </style>

<script type="text/javascript">

                                                                $(document).ready(function() {
                                                                    
                                                                    document.getElementById("li_view").disabled = true;


                                                                    var abuse_months_count= parseInt('<?php echo $months_count; ?>');
                                                                    //alert(abuse_months_count);
                                                                    if(abuse_months_count>0){
                                                                      for(var i=1; i<=abuse_months_count;i++){

                                                                        $("#abuse_report_"+ i ).on('click', {'idx': i} ,function(e){

                                                                              //alert('You clicked '+ e.data.idx);
                                                                              var URL = 'ajax/abuse_report_pages.php';
                                                                              
                                                                              $(".pagin").removeClass("clicked");
                                                                              $(this).addClass("clicked");
                                                                              $('.abuse_btn').prop('disabled', true);
                                                                              
                                                                              
                                                                                           
                                                                              /*for(var j=1; j<=abuse_months_count; j++){
                                                                                  if( (j != i) && ($("#abuse_report_"+ j ).hasClass("btn-primary"))){
                                                                                    $("#abuse_report_"+ j ).removeClass("btn-primary");
                                                                                    $("#abuse_report_"+ j).addClass("btn-info");
                                                                                  }
                                                                              }*/
                                                                              
                                                                              

                                                                              var first_date=$("#abuse_first_day_" + e.data.idx).val();
                                                                              var last_date=$("#abuse_last_day_" + e.data.idx).val();

                                                                              var st_time=$("#f_time").val();
                                                                              var ed_time=$("#e_time").val();
                                                                              var ip_addr=$("#ip_addr").val();
                                                                              var system_package=$("#system_package").val();
                                                                              var base_url=$("#base_url").val();
                                                                              
                                                                              //$("#histo_tbody").html('<tr><td colspan="7">Please wait a while before we compile the search results for you.</td>&nbsp;<td>&nbsp;</td>&nbsp;<td>&nbsp;</td>&nbsp;<td>&nbsp;</td>&nbsp;<td>&nbsp;</td>&nbsp;<td>&nbsp;</td>&nbsp;<td>&nbsp;</td>&nbsp;</tr>');
                                                                                
                                                                              $.ajax({
                                                                                url : URL,
                                                                                type: "POST",
                                                                                data : {fdate:first_date,ldate:last_date,st_time:st_time,ed_time:ed_time,ip_addr:ip_addr,system_package:system_package,base_url:base_url},
                                                                                 dataType: "json",
                                                                                success: function(response) {
                                                                                    //alert(response.li_view_id);
                                                                                    if(response.li_view_id != ''){
                                                                                      $("#histo_tbody").html(response.table_html);
                                                                                      $(window).scrollTop(0); 
                                                                                      var li_view_id= response.li_view_id;
                                                                                      var user_name = '<?php echo $user_name; ?>';
                                                                                      $("#li_download").attr("href", "ajax/export_report.php?li_report="+li_view_id+"&user_name="+user_name);
                                                                                      console.log('Table Updated...');
                                                                                    }else{
                                                                                        var EmptyData='<tr><td>No data in the table</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                                                                                        
                                                                                      //$('#ab_t').find('tbody').remove();
                                                                                      $("#histo_tbody").html(EmptyData);
                                                                                      console.log('Data Empty...');
                                                                                    }
                                                                                    
                                                                                    $('.abuse_btn').prop('disabled', false);
                                                                                },
                                                                                
                                                                               error: function (jqXHR, textStatus, errorThrown)
                                                                               {
                                                                                 alert("Network Error");
                                                                               }    
                                                                              });
                                                                            });
                                                                      }

                                                                    }
                                                                    
                                                                });


                                                                $('#ipaddress').keyup(function (e) {
                                                                    
                                                                    change_li_view();
                                                                });


                                                                $('#from_li_date').keyup(function (e) {
                                                                    
                                                                    change_li_view();
                                                                });


                                                                $('#to_li_date').keyup(function (e) {
                                                                    
                                                                    change_li_view();
                                                                });

                                                                
                                                                function change_li_view(){

                                                                    if(($('#ipaddress').val()!='')&&($('#from_li_date').val()!='')&&($('#to_li_date').val()!='')){
                                                                        document.getElementById("li_view").disabled = false;
                                                                        //console.log('f');
                                                                        }
                                                                    else{
                                                                        document.getElementById("li_view").disabled = true;
                                                                        //console.log('t');
                                                                    }
                                                                        }
                                                                
                                                                </script>

                                            </div>


                                            
                                            <div <?php if(isset($tab4)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="tab4">






                                     <form name="lawful_form2" id="lawful_form2" class="form-horizontal" method="post" action="?t=4" onchange="change_li_view()">
                                                <div class="form-group">
                                                   <fieldset>



                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">Public IP Address</label>

                                                            <div class="controls col-lg-5 form-group">
                                                                
                                                                    <input autocomplete="off" type="text" id="ipaddress2" name="ipaddress2" class="span2 li_download_class form-control">

                                                                    

                                                                     </div>

                                                        </div>
                                                        <!-- /control-group -->

                                                        <div class="control-group" id="search_time_range" >
                                                            <label class="control-label" for="radiobtns">Period</label>

                                                            <div class="controls">
                                                                <div class="input-prepend input-append">
                                                                    <select autocomplete="off" class="span2" name="session_period" id="session_period">
                                                                        
                                                                        <option value="PT24H">Last 24 Hours</option>
                                                                        <option value="PT7D">Last 7 Days</option>
                                                                        <option value="PT30D">Last 30 Days</option>
                                                                        <option value="PT3M">Last 3 Months</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                        <script type="text/javascript">
                                                            $('.inline_error').on('change',function(){
                                                                $( function() {
                                                                    $( "#to_li_date2").datepicker( "option", "minDate", $( "#from_li_date2" ).datepicker( "getDate" ));
                                                                    $( "#from_li_date2").datepicker( "option", "maxDate", $( "#to_li_date2" ).datepicker( "getDate" ));
                                                                   $('#lawful_form2').formValidation('revalidateField', 'dob');
                                                                } );



                                                            });
                                                           
                                                        



                                                        </script>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                         <div class="form-actions">
                                                            <input type="hidden" name="secret2" value="<?php echo $secret;?>">
                                                                <button name="li_view2" id="li_view2"  type="submit" class="btn btn-primary" style="text-decoration:none">
                                                                <i class="btn-icon-only icon-download"></i> Generate Report

                                                                <?php if($camp_layout!="COX"){ ?>
                                                                    <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                            $("#li_view2").easyconfirm({locale: {
                                                                            title: 'Historical Sessions',
                                                                            text: 'Are you sure you want to view the historical session report?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                                            button: ['Cancel',' Confirm'],
                                                                            closeText: 'close'
                                                                            }});
                                                                            $("#li_view2").click(function() {

                                                                            });
                                                                        });
                                                                    </script>

                                                                    <?php } ?>
                                                    </button>

                                                            <?php
                                                            if($li_success2=='success'){
                                                            ?>
                                                            <a id="li_download2" href="ajax/export_report.php?li_report_q=<?php echo $li_view_id2; ?>&user_name=<?php echo $user_name; ?>" class="btn btn-info" style="text-decoration:none">
                                                                <i class="btn-icon-only icon-download"></i> Download as CSV</a>
                                                            <?php }  ?>
                                                            </div>
                                                        
                                                        
                                                        
                                                        

                                                       <?php
                                                            if($li_success2=='success'){
                                                       ?>

                                                       <div class="widget widget-table action-table">
                                                           <div class="widget-header">
                                                               <h3>Quarterly Historical Sessions Report</h3>
                                                           </div>

                                                           <div class="widget-content table_response">
                                                               <div style="overflow-x:auto;" >
                                                                   <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                                       <thead>
                                                                       <tr>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">PUBLIC IP</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CUSTOMER ACCOUNT NUMBER</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">START Time</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">End Time</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">DURATION (Sec)</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">DEVICE MAC</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">AP/AC MAC</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">AC/WAG</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">VLAN</th>
                                                                          
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">DL (Bytes)</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">UP (Bytes)</th>
                                                                           
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">PROPERTY ID</th>
                                                                           
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">SSID/Network</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Port Range From</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Port Range To</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Internal IP</th>
                                                                       </tr>
                                                                       </thead>
                                                                       <tbody>
                                                                       <?php

                                                                      $key_query="SELECT
                                                                                  IF(nas_type = 'ac',l.nas_ip_address,l.`framed_ip_address`) AS public_ip,
                                                                                  IF(nas_type = 'ac',l.framed_ip_address,'') AS internal_ip,
                                                                                  IF(l.`session_start_time`='0','',FROM_UNIXTIME(l.`session_start_time`,'%m/%d/%Y %h:%i %p')) AS 'Session_start_time',
                                                                                  FROM_UNIXTIME(l.`unixtimestamp` / 1000, '%m/%d/%Y %h:%i %p') AS 'Session_End_Time',
                                                                                  l.`acct_session_time` AS 'Duration',
                                                                                  l.`vlan_id` AS 'VLAN',
                                                                                  l.`nas_identifier1` AS 'AC_WAG',
                                                                                  l.`session_mac` AS 'MAC',
                                                                                  l.`acct_input_octets` AS 'Down',
                                                                                  l.`acct_output_octets` AS 'Up',
                                                                                  l.`grp_realm` AS 'ICOMS',
                                                                                  d.`property_id` AS 'Property_ID',
                                                                                  l.`called_station_id` AS 'AP_MAC',
                                                                                  l.`nas_port_id` AS 'SSID',
                                                                                  l.`nas_port_range` AS 'Port_Range',
                                                                                  l.`dhcp_ip` AS 'dhcp_ip'
                                                                                  
                                                                                FROM
                                                                                  `exp_li_report` l LEFT JOIN `exp_mno_distributor` d
                                                                                  ON l.`grp`=d.`verification_number`
                                                                                WHERE
                                                                                `uniqid_id`='$li_view_id2'";

                                                                                //echo $key_query; die();


                                                                       $query_results=mysql_query($key_query);
                                                                       while($row=mysql_fetch_array($query_results)){

                                                                        
                                                                        $public_ip_display = $row[public_ip];
                                                                        $Session_start_time_display = $row[Session_start_time];
                                                                        $Session_End_Time_display = $row[Session_End_Time];
                                                                        $Duration_display = $row[Duration];
                                                                        $VLAN_display = $row[VLAN];
                                                                        $AC_WAG = $row[AC_WAG];
                                                                        $MAC_display = $row[MAC];
                                                                        $Down_display = $row[Down];
                                                                        $Up_display = $row[Up];
                                                                        $ICOMS_display = $row[ICOMS];
                                                                        $Property_ID_display = $row[Property_ID];
                                                                        $AP_MAC_display = $row[AP_MAC];
                                                                        $SSID_display = $row[SSID];
                                                                        $Port_Range_display = $row[Port_Range];
                                                                        $internal_ip_display = $row[internal_ip];
                                                                        
                                                                        if(strlen($public_ip_display)==0){
                                                                            $public_ip_display = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        if($AC_WAG==ac){
                                                                            $AC_WAG = 'AC';
                                                                        }
                                                                        if($AC_WAG==wag){
                                                                            $AC_WAG = 'WAG';
                                                                        }
                                                                        
                                                                        if(strlen($AC_WAG)==0){
                                                                            $AC_WAG = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        if(strlen($Session_start_time_display)==0){
                                                                            $Session_start_time_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Session_End_Time_display)==0){
                                                                            $Session_End_Time_display = 'N/A';
                                                                        }                                                                           
                                                                        if(strlen($Duration_display)==0){
                                                                            $Duration_display = 'N/A';
                                                                        }
                                                                        if(strlen($VLAN_display)==0){
                                                                            $VLAN_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($MAC_display)==0){
                                                                            $MAC_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Down_display)==0){
                                                                            $Down_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Up_display)==0){
                                                                            $Up_display = 'N/A';
                                                                        }   
                                                                        if(strlen($ICOMS_display)==0){
                                                                            $ICOMS_display = 'N/A';
                                                                        }   
                                                                        if(strlen($Property_ID_display)==0){
                                                                            $Property_ID_display = 'N/A';
                                                                        }   
                                                                        if(strlen($AP_MAC_display)==0){
                                                                            $AP_MAC_display = 'N/A';
                                                                        }   
                                                                        if(strlen($SSID_display)==0){
                                                                            $SSID_display = 'N/A';
                                                                        }   
                                                                       
                                                                        
                                                                        if(strlen($internal_ip_display)==0){
                                                                            $internal_ip_display = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        $row_ar=explode('-',$row[Port_Range]);
                                                                        
                                                                        if(strlen($row_ar[0])==0){
                                                                            $row_ar[0] = 'N/A';
                                                                        }
                                                                        if(strlen($row_ar[1])==0){
                                                                            $row_ar[1] = 'N/A';
                                                                        }
                                                                        
                                                                           echo '<tr>';
                                                                           echo '<td>'.$public_ip_display.'</td>';
                                                                           echo '<td>'.$ICOMS_display.'</td>';
                                                                           echo '<td>'.$Session_start_time_display.'</td>';
                                                                           echo '<td>'.$Session_End_Time_display.'</td>';
                                                                           echo '<td>'.$Duration_display.'</td>';
                                                                           echo '<td>'.$MAC_display.'</td>';
                                                                           echo '<td>'.$AP_MAC_display.'</td>';
                                                                           echo '<td>'.$AC_WAG.'</td>';
                                                                           
                                                                           echo '<td>'.$VLAN_display.'</td>';
                                                                          
                                                                           echo '<td>'.$Down_display.'</td>';
                                                                           echo '<td>'.$Up_display.'</td>';
                                                                           
                                                                           echo '<td>'.$Property_ID_display.'</td>';
                                                                          
                                                                           echo '<td>'.$SSID_display.'</td>';
                                                                           
                                                                           echo '<td>'.$row_ar[0].'</td>';
                                                                           echo '<td>'.$row_ar[1].'</td>';
                                                                           echo '<td>'.$internal_ip_display.'</td>';
                                                                           echo '</tr>';
                                                                       }

                                                                       ?>

                                                                       </tbody>
                                                                   </table>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <?php }
                                                                else{
                                                                    echo '';
                                                                }
                                                       ?>
                                                       


                                                            <!-- /form-actions -->



                                                    </fieldset> 
                                                    </div>
                                                </form>

<script type="text/javascript">

                                                                $(document).ready(function() {
                                                                    
                                                                    document.getElementById("li_view2").disabled = true;
                                                                    
                                                                });


                                                                $('#ipaddress2').keyup(function (e) {
                                                                    
                                                                    change_li_view2();
                                                                });


                                                                $('#from_li_date2').keyup(function (e) {
                                                                    
                                                                    change_li_view2();
                                                                });


                                                                $('#to_li_date2').keyup(function (e) {
                                                                    
                                                                    change_li_view2();
                                                                });

                                                                
                                                                function change_li_view2(){

                                                                    if(($('#ipaddress2').val()!='')&&($('#from_li_date2').val()!='')&&($('#to_li_date2').val()!='')){
                                                                        document.getElementById("li_view2").disabled = false;
                                                                        //console.log('f');
                                                                        }
                                                                    else{
                                                                        document.getElementById("li_view2").disabled = true;
                                                                        //console.log('t');
                                                                    }
                                                                        }
                                                                
                                                                </script>

                                            

                                            </div>


                                            <!--**********blacklist tab-->

                                            <div <?php if(isset($tab3)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="tab3">



                                                <!--whitelist form-->

                                                <form name="whitelist_form" id="whitelist_form" class="form-horizontal" method="post" action="?t=3">
                                                <div class="form-group">
                                                
                                                
                                                
                                                   <fieldset>

                                                       <input type="hidden" id="check_post_val" name="blacklist_all_search_dis">

                                                       <h3>Search MAC Address</h3>

                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">MAC Address</label>

                                                            <div class="controls col-lg-5 form-group">

                                                                <!--pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$"-->

                                                                    <input maxlength="17" autocomplete="off" type="text" id="search_mac" name="search_mac" class="span4" data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. The system will autoformat the MAC Address to either aa:bb:cc:dd:ee:ff or AA:BB:CC:DD:EE:FF.">





                                                            
                                                                <script type="text/javascript">
/*
                                                                    function mac_val1(element) {

                                                                        setTimeout(function () {
                                                                            var mac = $('#search_mac').val();

                                                                            var pattern = new RegExp( "[/-]", "g" );
                                                                            var mac = mac.replace(pattern,"");

                                                                            // alert(mac);
                                                                            var result ='';
                                                                            var len = mac.length;

                                                                            // alert(len);

                                                                            var regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;



                                                                            if(regex.test(mac)==true){

                                                                                //  if( (len<5 && mac.charAt(3)==':') || (len<8 && mac.charAt(3)==':' && mac.charAt(6)==':') || (len<11 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':') || (len<14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':') || (len>14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':' && && mac.charAt(15)==':') ){

                                                                            }else{

                                                                                for (i = 0; i < len; i+=2) {


                                                                                    // alert(mac.charAt(i));

                                                                                    if(i==10){

                                                                                        result+=mac.charAt(i)+mac.charAt(i+1);

                                                                                    }else{

                                                                                        result+=mac.charAt(i)+mac.charAt(i+1)+':';

                                                                                    }

                                                                                    //alert(i);

                                                                                }


                                                                                document.getElementById('search_mac').value = result.toLowerCase();
                                                                                $('#whitelist_form').formValidation('revalidateField', 'search_mac');

                                                                            }


                                                                        }, 100);


                                                                    }

                                                                    $("#search_mac").on('paste',function(){

                                                                        mac_val1(this.value);

                                                                    });


                                                                    $(document).ready(function() {

                                                                        $('#search_mac').change(function(){


                                                                            $(this).val($(this).val().replace(/(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})/,'$1:$2:$3:$4:$5:$6'))


                                                                        });



                                                                        $('#search_mac').keyup(function(e){

                                                                             var mac = $('#search_mac').val();
                                                                            var len = mac.length + 1;

                                                                            

                                                                            if(e.keyCode != 8){

                                                                                if(len%3 == 0 && len != 0 && len < 18){
                                                                                    $('#search_mac').val(function() {
                                                                                        return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                                                                        //i++;
                                                                                    });
                                                                                }
                                                                            }

                                                                        });


                                                                        $('#search_mac').keydown(function(e){
                                                                             var mac = $('#search_mac').val();
                                                                            var len = mac.length + 1;


                                                                            if(e.keyCode != 8){

                                                                                if(len%3 == 0 && len != 0 && len < 18){
                                                                                    $('#search_mac').val(function() {
                                                                                        return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                                                                        //i++;
                                                                                    });
                                                                                }
                                                                            }

                                                                           


                                                                            // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                            if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190,59]) !== -1 ||
                                                                                // Allow: Ctrl+A, Command+A
                                                                                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                // Allow: Ctrl+C, Command+C
                                                                                (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                // Allow: Ctrl+x, Command+x
                                                                                (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                // Allow: Ctrl+V, Command+V
                                                                                (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                // Allow: home, end, left, right, down, up
                                                                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                                // let it happen, don't do anything
                                                                                return;
                                                                            }
                                                                            // Ensure that it is a number and stop the keypress
                                                                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 65 || e.keyCode > 70)) {
                                                                                e.preventDefault();

                                                                            }
                                                                        });


                                                                    });
*/
                                                                </script>
                                                            

                                                            </div>
                                                        </div>
                                                        
                                                        
                                                         <div class="form-actions border-non">
                                                        
                                                        
                                                                    <button name="blacklist_mac_search" id="blacklist_mac_search" type="submit" class="btn btn-primary" style="text-decoration:none">Search</button>
                                                                    <button id="blacklist_all_search" type="submit" class="btn btn-info inline-btn" style="text-decoration:none">List all disabled MACs</button>
                                                        
                                                        </div>
                                                        
                                                    </fieldset>
                                                </div>
                                                     </form>




                                                <!--blacklist form-->
                                                <h2>Manage MAC Addresses</h2>

                                                <br>

                                                <form name="blacklist_form" id="blacklist_form" class="form-horizontal" method="post" action="?t=3">
                                                <div class="form-group">
                                                   <fieldset>

                                                            <h3>Add MAC Address</h3>


                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">MAC Address</label>

                                                            <div class="controls col-lg-5 form-group">

                                                                    <input maxlength="17" data-toggle="tooltip"  autocomplete="off" type="text" id="black_mac" name="black_mac" class="span4" title="The MAC Address can be added manually or you can paste in an address. The system will autoformat the MAC Address to either aa:bb:cc:dd:ee:ff or AA:BB:CC:DD:EE:FF.">
                                                                <small id="bl_mac_ext" class="help-block" style="display: none;"></small>

                                                                <script type="text/javascript">

                                                                $(document).ready(function() {
                                                                    
                                                                     $('#black_mac').tooltip(); 
                                                                     $('#search_mac').tooltip(); 

                                                                });

                                                                    function vali_blacklist(rlm) {

                                                                        var val = rlm.value;
                                                                        var val = val.trim();



                                                                        if(val!="") {
                                                                            document.getElementById("bl_mac_ext").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                                            var formData = {blmac: val, user: "<?php echo $user_distributor; ?>"};
                                                                            $.ajax({
                                                                                url: "ajax/validateblacklist.php",
                                                                                type: "POST",
                                                                                data: formData,
                                                                                success: function (data) {
                                                                                   

                                                                                    if (data == '1') {
                                                                                        /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                                                        document.getElementById("bl_mac_ext").innerHTML ="";
                                                                                        $('#bl_mac_ext').hide();
                                                                                        

                                                                                    } else if (data == '2') {
                                                                                        //inline-block
                                                                                        
                                                                                        $('#bl_mac_ext').css('display', 'inline-block');
                                                                                        document.getElementById("bl_mac_ext").innerHTML = "<p>The MAC ["+val+"] you are trying to add is already disabled, please try a different MAC.</p>";
                                                                                        document.getElementById('black_mac').value = "";
                                                                                        /* $('#mno_account_name').removeAttr('value'); */
                                                                                        document.getElementById('black_mac').placeholder = "Please enter new MAC";
                                                                                    }
                                                                                },
                                                                                error: function (jqXHR, textStatus, errorThrown) {
                                                                                    //alert("error");
                                                                                    document.getElementById('black_mac').value = "";
                                                                                }
                                                                            });
                                                                        }
                                                                    }
                                                                    
                                                                    

                                                                </script>

                                                            </div>
                                                            
                                                        </div>
                                                        
                                                         <div class="control-group">
                                                            <div class="controls col-lg-5 form-group">
                                                            <!-- <div style="display: none" id="bl_mac_ext"></div> -->
                                                            </div>
                                                            </div>
                                                        
                                                        <!-- /control-group -->



                                                       <div class="control-group" id="search_time_range" >
                                                            <label class="control-label" for="radiobtns">Suspension Period</label>

                                                            <div class="controls">
                                                                <div class="input-prepend input-append">
                                                                    <select autocomplete="off" class="span4" name="blacklist_period" id="blacklist_period">
                                                                        
                                                                    <option value="PT24H">24 Hours</option>
                                                                        <option value="PT48H">48 Hours</option>
                                                                        <option value="P7D">1 Week</option>
                                                                        <option value="P14D">2 Weeks</option>
                                                                        <option value="P28D">4 Weeks</option>
                                                                        <option value="P91D">13 Weeks</option>
                                                                        <option value="P182D">26 Weeks</option>
                                                                        <option value="P364D">52 Weeks</option>
                                                                        <option value="P21D">21 Days</option>
                                                                        <option value="P180D">180 Days</option>
                                                                        <option value="P3Y">3 Years</option>
                                                                        <option value="indefinite">Indefinite</option
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                       <div class="form-actions border-non">

                                                           <input type="hidden" name="black_form_secret" value="<?php echo $secret; ?>">
                                                           <br><br>
                                                           <button disabled name="blacklist" id="blacklist" type="submit" class="btn btn-primary" style="text-decoration:none">
                                                               <i class="btn-icon-only icon-download"></i> Add MAC Address

                                                           </button>

                                                            <?php
                                                           $customer_down_key_string = "task=all_blacklist&mno_id=".$user_distributor."&user=cox";
                                                           $customer_down_key =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string);
                                                           $customer_down_key =  urlencode($customer_down_key);
                                                           ?>
                                                           &nbsp;&nbsp;<a href="ajax/export_customer.php?key=<?php echo $customer_down_key?>" class="btn btn-primary" style="text-decoration:none">
                                                               <i class="btn-icon-only icon-download"></i>Download all blocked MACs
                                                           </a>

                                                       </div>
                                                    </fieldset>
                                                    </div>
                                                </form>





                                                    <div class="widget widget-table action-table">
                                                    <div class="widget-header">
                                                        <!--  <i class="icon-th-list"></i> -->

                                                        <h3>Session Search Result</h3>
                                                    </div>
                                                    <!-- /widget-header -->
                                                    <div class="widget-content table_response">
                                                        <div style="overflow-x:auto">
                                                            <table id="blacklist_search_table" class="table table-striped table-bordered tablesaw" cellspacing="0" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Device MAC</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Blacklist Date</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Suspension</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Whitelist Date</th>
                                                                   <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">remove MAC</th> -->
                                                                  
                                                                  <?php if(isset($_POST[blacklist_mac_search])){ ?>
                                                                   <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Whitelist type</th> -->
                                                                  
                                                                  
                                                                  <?php }?>
                                                                  
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">WIFI</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                
                                                                if(isset($_POST[blacklist_all_search])){
                                                                    
                                                                    $get_blacklist_q="SELECT *,'main' as ar FROM exp_customer_blacklist WHERE mno='$user_distributor'";
                                                                    
                                                                }elseif(isset($_POST[blacklist_mac_search])){
                                                                    
                                                                $ser_mac=$_POST[search_mac];
                                                                $ser_mac = str_replace(':', '', $ser_mac);
                                                                $ser_mac = str_replace('-', '', $ser_mac);

                                                                $get_blacklist_q="SELECT *,'main' as ar, type as type1 FROM exp_customer_blacklist WHERE mno='$user_distributor' and mac='$ser_mac'";
                                                                /*$new_get_blacklist_q="SELECT *,'arc' as ar, IF(type='Manual', 'Manual', 'Automatic') as type1 FROM exp_customer_blacklist_archive WHERE mno='$user_distributor' and mac='$ser_mac'";
                                                                $get_blacklist_new = mysql_query($new_get_blacklist_q);
                                                                while ($blacklist_row_new = mysql_fetch_assoc($get_blacklist_new)){
                                                                        $whitelist_type=$blacklist_row_new['type1'];
                                                                      }*/

                                                                    
                                                                }else{
                                                                    $get_blacklist_q="";
                                                                    
                                                                }
                                                                


                                                                //$get_blacklist_q="SELECT * FROM exp_customer_blacklist WHERE mno='$user_distributor'";
                                                                $get_blacklist_r = mysql_query($get_blacklist_q);

                                                                    while ($blacklist_row = mysql_fetch_assoc($get_blacklist_r)){
                                                                        $device_mac=$blacklist_row['mac'];
                                                                        $device_mac_display = $db->macFormat($device_mac,$mac_format);
                                                                        
                                                                        $rwid=$blacklist_row['id'];

                                                                        $tz = new DateTimeZone($mno_time_zone);

                                                                        //convert blacklist date
                                                                        $blacklist_date = date_create();
                                                                        date_timestamp_set($blacklist_date, $blacklist_row['bl_timestamp']);
                                                                        $blacklist_date->setTimezone($tz);
                                                                        $blacklist_date=$blacklist_date->format('m/d/Y h:i A');


                                                                        //convert whitelist name
                                                                        $whitelist_date  = date_create();
                                                                        date_timestamp_set($whitelist_date, $blacklist_row['wl_timestamp']);
                                                                        $whitelist_date->setTimezone($tz);
                                                                        $whitelist_date=$whitelist_date->format('m/d/Y h:i A');


                                                                        $suspension=$blacklist_row['period'];
                                                                        
                                                                        if($suspension=='indefinite'){
                                                                            
                                                                            $gap='Indefinite';
                                                                            $whitelist_date='N/A';
                                                                        }else{

                                                                        $gap = "";
                                                                        if($suspension != ''){

                                                                            $interval = new DateInterval($suspension);

                                                                            if($interval->y != 0){
                                                                                $gap .= $interval->y.' Years ';
                                                                            }
                                                                            if($interval->m != 0){
                                                                                $gap .= $interval->m.' Months ';
                                                                            }
                                                                            if($interval->d != 0){
                                                                                $gap .= $interval->d.' Days ';
                                                                            }
                                                                            if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
                                                                                $gap .= ' And ';
                                                                            }
                                                                            if($interval->h != 0){
                                                                                $gap .= $interval->h.' Hours ';
                                                                            }
                                                                            if($interval->i != 0){
                                                                                $gap .= $interval->i.' Minutes ';
                                                                            }

                                                                        }
                                                                        
                                                                        }

                                                                        $remove_mac='<a href="javascript:void();" id="do_white_mac'.$blacklist_row["id"].'" class="btn btn-small btn-primary">
                                                                                        <i class="btn-icon-only icon-info-sign"></i>&nbsp;Remove</a>
                                                                                        <script type="text/javascript">
                                                                                            $(document).ready(function() {
                                                                                            $(\'#do_white_mac'.$blacklist_row["id"].'\').easyconfirm({locale: {
                                                                                                    title: \'Whitelist MAC\',
                                                                                                    text: \'Are you sure you want to whitelist this MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                                                    closeText: \'close\'
                                                                                                     }});
                                        
                                                                                                $(\'#do_white_mac'.$blacklist_row["id"].'\').click(function() {
                                                                                                    window.location = "?wl_secret='.$secret.'&t=3&wl_id='.$blacklist_row["id"].'"
                                        
                                                                                                });
                                        
                                                                                                });
                                        
                                                                                            </script>
                                                                                        ';
                                                                        echo'<tr>
                                                                            <td>'.$device_mac_display.'</td>
                                                                            <td>'.$blacklist_date.'</td>
                                                                            <td>'.$gap.'</td>
                                                                            <td>'.$whitelist_date.'</td>';

                                                                        /*if(isset($_POST[blacklist_mac_search])){
                                                                          
                                                                           echo '<td>'.$whitelist_type.'</td>';
                                                                           
                                                                        }*/
                                                                        
                                                                        $isenn=$blacklist_row['is_enable'];
                                                                        $main_tbl=$blacklist_row['ar'];
                                                                        
                                                                        echo '<td>';
                                                                        
                                                                        if($main_tbl=='main'){
                                                                            
                                                                            
                                                                        if($isenn=='1'){

                                                                   /* echo   '<div class="toggle2"><input onchange="" type="checkbox" class="hide_checkbox">
                                                                             <a href="javascript:void();" id="ST_'.$rwid.'"><span class="toggle2-on-dis">Enable</span></a>
                                                                    <span class="toggle2-off">Disable</span>
                                                                    </div>'; */

                                                                    echo '<a class="btn btn-info" href="javascript:void();" id="ST_'.$rwid.'">Enable</a>';
                                                                             
                                                                          

                                                                    echo '<script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#ST_'.$rwid.'\').easyconfirm({locale: {

                                                                            title: \'Enable MAC\',

                                                                            text: \'Are you sure you want to enable this MAC?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#ST_'.$rwid.'\').click(function() {



                                                                        window.location = "?t=3&modify_bl_en=2&is_enable=0&id='.$rwid.'"

                                                                        });

                                                                        });

                                                                    </script>';
                                                                        
                                                                        
                                                                            
                                                                        }else{
                                                                            echo  '<div class="toggle2"><input checked onchange="" href="javascript:void();" id="ST_'.$rwid.'" type="checkbox" class="hide_checkbox"><span class="toggle2-on">Enable</span>
                                                                            <a href="javascript:void();" id="CE_'.$rwid.'"><span class="toggle2-off-dis">Disable</span></a>
                                                                        </div>'; 
                                                                     

                                                                    
                                                              echo '<script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#CE_'.$rwid.'\').easyconfirm({locale: {

                                                                            title: \'Disable MAC\',

                                                                            text: \'Are you sure you want to disable this  MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#CE_'.$rwid.'\').click(function() {

                                                                            window.location = "?t=3&modify_bl_en=2&is_enable=1&id='.$rwid.'"

                                                                        });

                                                                        });

                                                                    </script>';
                                                                            
                                                                            
                                                                        }
                                                                            
                                                                            
                                                                        }else{
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    echo '</td>';

                                                                            
                                                                            
                                                                            echo '</tr>';
                                                                    }

                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                </div>
                                               
                                            </div>

                        </div>
                        <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                        </div>


                                    </div>
                                </div>
                            </div>

                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                    <!-- /span8 -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /main-inner -->
    </div>
    <!-- /main -->



<script type="text/javascript" src="js/formValidation.js"></script>
 <script type="text/javascript" src="js/bootstrap_form.js"></script>
<script type="text/javascript">

    $('#blacklist_all_search').click(function (e) { 
        $('#check_post_val').attr('name', 'blacklist_all_search');
    });

    $(document).ready(function() {
        $('#lawful_form').formValidation({
            framework: 'bootstrap',
            fields: {

                ipaddress: {
                    validators: {
                        <?php echo $db->validateField('ipaddress'); ?>
                    }
                },
                dob: {
                    excluded: false,
                    validators: {
                         <?php echo $db->validateField('dob'); ?>
                    }
                },
                timeValidation: {
                    excluded: false,
                    validators: {
                        notEmpty: {
                            message: '<p>Invalid time</p>'
                        }
                    }
                },
                port_number_from: {
                    validators: {
                        between: {
                            min: 1,
                            max: 65535,
                            message: '<p>Values starting with 0 are not valid. Valid values are 1-65535</p>'
                        },
                        regexp: {
                            regexp: /^(?:[1-9]\d*|0)$/,
                            message: '<p>Values starting with 0 are not valid. Valid values are 1-65535</p>'
                        }
                    }
                }
            }
        }).on('change', 'input[name="from"], input[name="to"]', function(e) {
            var from = $('#lawful_form').find('[name="from"]').val(),
                to = $('#lawful_form').find('[name="to"]').val();

            // Set the dob field value
            $('#lawful_form').find('[name="dob"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

            // Revalidate it
            $('#lawful_form').formValidation('revalidateField', 'dob');

        }).on('change','.li-time', function(e) {
            var timeval1 = $('#from_li_time').val();
            var timeval2 = $('#to_li_time').val();
            var timeval3 = $('#from_li_date').val();
            var timeval4 = $('#to_li_date').val();

            var df = new Date(timeval3+' '+timeval1);
            var dt = new Date(timeval4+' '+timeval2);

            // from > to -> error
            //alert(d1.getTime()+' '+d2.getTime());
            if( df.getTime() >= dt.getTime() ){
                //alert(df+' '+dt);
                $('#timeValidation').val('');
            }else{
                $('#timeValidation').val('valid');

            }

            // Revalidate it
            $('#lawful_form').formValidation('revalidateField', 'timeValidation');

        });



        $('#blacklist_form').formValidation({
            framework: 'bootstrap',
            fields: {

                black_mac: {
                    validators: {
                        <?php echo $db->validateField('mac'); ?>
                        remote: {
                            url: 'ajax/validateblacklist.php',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator, $field, value) {
                                return {
                                    blmac: validator.getFieldElements('black_mac').val(),
                                    user: "<?php echo $user_distributor; ?>"
                                };
                            },
                            message:'<p>The MAC Address you are trying to add has already been disabled. Please try with a different MAC Address.</p>',
                            type: 'POST'
                        }
                    }
                },
                blacklist_period: {
                    excluded: false,
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        });

        $('#whitelist_form').formValidation({
            framework: 'bootstrap',
            button: {
                selector: '#blacklist_mac_search',
                disabled: 'disabled'
            },
            fields: {

                search_mac: {
                    validators: {
                        <?php echo $db->validateField('mac'); ?>
                    }
                }
            }
        });

         $('#lawful_form2').formValidation({
            framework: 'bootstrap',
            fields: {

                ipaddress2: {
                    validators: {
                        <?php echo $db->validateField('ipaddress'); ?>
                    }
                }
            }
        });
    });
</script>
<script src="js/jquery.multi-select.js" type="text/javascript"></script>




<?php

include 'footer.php';

?>

<!--Alert message -->
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />

<!-- tool tip css -->
<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />



<!--jquery code for upload browse button-->
<script src="js/jquery.filestyle.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<!-- datatables js -->

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>

<script>

    $(function () {

        $('#session_search_table').dataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
        "fnDrawCallback": function(oSettings) {
          if ($(this).find("tr").length < 10) {
              var this_id = $(this).attr('id') ;
              var this_info_id = "#"+this_id+"_info";
              var this_paginate_id = "#"+this_id+"_paginate";

              $(this_info_id).hide();
              $(this_paginate_id).hide();
              
          }
          },

          "order": [[ 3, "desc" ]],
          "columnDefs": [
            { "orderable": false, "targets": [0,1,2,4,5,6,7]}
          ]

        });

  });
</script>
    <script type="text/javascript">


        var blacklist_tbl=$('#blacklist_search_table').DataTable({
            "ordering": false,
            "pageLength": 50,
            "paging":   false,
            "info":     false
        });

        <?php if(isset($_POST[blacklist_all_search]) || isset($_GET[blacklist_all_search])){ ?>

        $('#search_mac').on( 'keyup', function () {
            blacklist_tbl.search( this.value ).draw();
        } );

        <?php } ?>

    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#blacklist").easyconfirm({locale: {
                title: 'Blacklist MAC',
                text: 'Are you sure you want to disable Wi-Fi access for this MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                button: ['Cancel',' Confirm'],
                closeText: 'close'
            }});
            $("#blacklist").click(function() {

            });
        });
    </script>


</body>
