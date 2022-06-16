<style>
#se_te .widget-content .tablesaw-bar {
    top: -40px !important;
}
#se_download{
 /*  margin-left: 35px; */
}


@media (max-width:400px){
  #se_download{
  /* margin-left: 0px; */
}

}

@media screen and (min-width: 980px){
  .se_ownload_cr {
    width: 200px !important; 
    text-align: center;
}
}

@media screen and (max-width: 675px){
  .paas_toogle {
    position: absolute !important;
    margin-top: -21px !important;
    right: 2px !important;
}
}

input::-ms-clear, input::-ms-reveal {
    display: none;
}

.pass_msg .help-block{
  display: block !important;
}
</style>


<style type="text/css">

    
    #ex-btn-div{
        text-align: center;
    }

    #ex-btn-div .tablesaw-bar{
        text-align: center;
        top: 30px;
    }

    #ex-btn-div .export-customer-a{
        margin-bottom: 20px;
    }

    .table_response{
        margin: auto;
    }
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
    padding-bottom: 35px;
    width: 960px;
    font-weight: bold !important;
    margin: auto;
    font-size: 25px;
    text-align: center;
    color: #5f5a5a;
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

.form-horizontal .controls{
    width: 310px;
    margin: auto;
}

#device_form .controls, #edit_customer_form .controls{
    width: auto;
    margin: auto;
}

@media screen and (min-width : 980px){
    
  .middle.form-horizontal .controls{
      width: 150px;
  }

  .middle.form-horizontal .middle-left.controls{
      width: 480px;
  }

  .middle.form-horizontal .middle-large .controls{
      display: inline-block;
      width: auto;
  }

  .middle.form-horizontal .middle-large{
      width: 51%;
      margin: auto;
      margin-bottom: auto;
      margin-bottom: 20px;
  }

}


.form-horizontal .contact.controls{
    width: 700px;
}

form.form-horizontal .form-actions{
    width: 350px;
    margin: auto;
    background-color: #fff;
    padding-left: 0px;
    margin-left: 0px;
}

form .qos-sync-button {
    float: none;
}

 
    .span11a{
      width: 45%;
    margin-left: 5%;
    }

    .span5a{
      width: 45%;
    }

@media (max-width: 979px){
    .form-horizontal .controls{
        width: 310px;
    }

    
    form.form-horizontal .form-actions{
        width: 300px;
    }

    .form-horizontal .contact.controls{
        width: 90%;
    }

    .tab-pane {
        padding-top: 0px !important;
    }
}

@media (max-width: 767px){
    .form-horizontal .controls{
        width: 280px;
    }

    .span5a,.span11a{
      width: 45%;
      margin-left: 28%;
    }


    form.form-horizontal .form-actions{
        width: 260px;
    }


    .form-horizontal .contact.controls{
        width: 100%;
    }

    select.inline-btn, input.inline-btn, button.inline-btn, a.inline-btn {
        display: block !important;
    }

    a.inline-btn, button.inline-btn, input[type="submit"].inline-btn {
        margin-top: 10px !important;
        margin-left: 0px !important;
    }

}

@media (max-width: 480px){
    form.form-horizontal .form-actions{
        width: 270px;
    }

    .span11a{
    	margin-top: -30px;
    }

    input.span5, textarea.span5, .uneditable-input.span5, input[class*="span"], div[class*="span4"], select[class*="span"], textarea[class*="span"], .uneditable-input{
		width: 100% !important;
	}

	.tab-content{
		display: block;
	}

    .span5a,.span11a{
      width: 100%;
      margin-left: 0%;
    }
}

.widget-content .tablesaw-bar{
  top: 30px;
}
</style>
<?php 
 /*Encryption script*/
 include_once 'classes/cryptojs-aes.php';
$data_secret = $db->setVal('data_secret','ADMIN');
$distributercode=$package_functions->getDistributorMONPackage($user_name);

?>


<?php 

 $us_property_type = $db->getValueAsf("SELECT `property_type` AS f FROM `mdu_mno_distributor` WHERE `distributor_code`='$mdu_distributor_id'");


function checkMac($string){
  $string=str_replace('-','',$string);
  $string=str_replace(':','',$string);
  $string=strtolower($string);

  $string_arry=str_split($string);

  //cannot exists
  $cannot_exists=array('1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f');

  foreach ($string_arry as $key=>$value){
    if(!in_array($value,$cannot_exists)){
      return false;
    }
  }

  $length=strlen($string);
  return $length==12;


}

function getMac($string){
  $string=str_replace('-','',$string);
  $string=str_replace(':','',$string);
  $string=strtolower($string);
  return $string;


}

function checkFormat($string){ //IF string is a MAC ,Return TRUE
        $regex_mac = '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$|[0-9A-Fa-f]{12}$/';

        //** check regex mach
        if (preg_match($regex_mac,$string))
        {
            return "mac";
        }

        //** php email regex checker
        elseif(filter_var($string, FILTER_VALIDATE_EMAIL)){
            return "email";
        }

        elseif(filter_var($string, FILTER_VALIDATE_IP)) {
            return "ip";
        }
        else
        {
            return "name";
        }

    }
function syncCustomeracc($Response2,$property_id){

  

  $bulk_profile_data2 = json_decode($Response2,true);
  //
        
      $bulk_profile_data=$bulk_profile_data2['Description'];

        if (empty($bulk_profile_data)) {
           $res_arr3 = array();
            
       }
       else{
        if ($bulk_profile_data['User-Name']) {
            $single_profile_data1=1;
            $bulk_profile_data[0]=$bulk_profile_data;
        }
        else{
             $single_profile_data1=sizeof($bulk_profile_data);
        }

        $res_arr3 = array();
        for($k=0;$k<$single_profile_data1;$k++){


            
            $single_profile_data_ar= $bulk_profile_data[$k];
                $User_Name = mysql_real_escape_string($single_profile_data_ar['User-Name']);
                $fname = mysql_real_escape_string($single_profile_data_ar['PAS-First-Name']);
                $lname = mysql_real_escape_string($single_profile_data_ar['PAS-Last-Name']);

                $newarray1=array("User_Name"=> $User_Name,
                                "F-Name" => $fname,
                                "L-Name" => $lname
                                );
                    
                array_push($res_arr3, $newarray1);
}}
    $resultArray = uniqueAssocArray($res_arr3, 'User_Name');
      
        return $resultArray;
                


}

function syncCustomerNew($Response2,$property_id,$acc_data){

  $bulk_profile_data2 = json_decode($Response2,true);
  //
        
      $bulk_profile_datasession=$bulk_profile_data2['Description'];
      $bulk_profile_datasession;

        if (empty($bulk_profile_datasession)) {
           $res_arr1 = array();
          $res_arr2 = array();
            
       }
       else{
        if ($bulk_profile_datasession['Session-Id']) {
            $single_profile_data1=1;
            $bulk_profile_datasession[0]=$bulk_profile_datasession;
        }
        else{
             $single_profile_data1=sizeof($bulk_profile_datasession);
        }

        $res_arr1 = array();
        $res_arr2 = array();
        for($k=0;$k<$single_profile_data1;$k++){


            
            $single_profile_data_ar= $bulk_profile_datasession[$k];
            //print_r($single_profile_data_ar);

            $ID = mysql_real_escape_string($single_profile_data_ar['Session-Id']);
                $CLIENTID = mysql_real_escape_string($single_profile_data_ar['Session-MAC']);
                $IP = mysql_real_escape_string($single_profile_data_ar['NAS-IP']);
                $STATE = mysql_real_escape_string($single_profile_data_ar['state']);
                $DURATION = mysql_real_escape_string($single_profile_data_ar['Session-Interim-Interval']);
                $START_TIME = mysql_real_escape_string($single_profile_data_ar['Session-Start-Time']);
                $Location_Id = mysql_real_escape_string($single_profile_data_ar['Location-Id']);
                $AAA_User_Name = mysql_real_escape_string($single_profile_data_ar['AAA-User-Name']);
                $Realm = mysql_real_escape_string($single_profile_data_ar['Access-Group']);
                $SESSION_TIMEOUT = mysql_real_escape_string($single_profile_data_ar['Session-Timeout']);
                $IDLE_TIME=mysql_real_escape_string($single_profile_data_ar['AAA-Session-Timeout']);
                $Sender_Type = mysql_real_escape_string($single_profile_data_ar['Sender-Type']);
                $cus_IP = mysql_real_escape_string($single_profile_data_ar['Session-IP']);

                if (!empty($acc_data)) {
                                            $res_arrr6=array();
                                            $res_arrr4=array();
                                            $res_arrr5=array();
                foreach ($acc_data as $value1) {
                                                $account_user_name=$value1['User_Name'];
                                                $acc_first=$value1['F-Name'];
                                                $acc_last=$value1['L-Name'];
                                                array_push($res_arrr6, $account_user_name);
                                                array_push($res_arrr4, $acc_first);
                                                array_push($res_arrr5, $acc_last);
                                            }
                                            

                if (in_array($AAA_User_Name, $res_arrr6))
                     {
                      $account_user_name=$AAA_User_Name;
                      $a=array_search($account_user_name,$res_arrr6,true);
                      $fname=$res_arrr4[$a];
                      $lname=$res_arrr5[$a];

                     }
                   }

                //$fname = mysql_real_escape_string($single_profile_data_ar['PAS-First-Name']);
                //$lname = mysql_real_escape_string($single_profile_data_ar['PAS-Last-Name']);

                $station = $single_profile_data_ar['Called-Station-Id'];
               $AP_Mac= substr($station, 0, 17);
              //$Account_State=mysql_real_escape_string($single_profile_data_ar['Account-State']);
                if ($single_profile_data_ar['Access-Profile']=='FULL') {
                $Account_State='Active';
              }
              else{
                  $Account_State='Inactive';
              }
                $Device_Type=mysql_real_escape_string($single_profile_data_ar['NAS-Port-Type']);
                $Gw_Type=mysql_real_escape_string($single_profile_data_ar['location_Nas-Type']);
                $USERNAME=mysql_real_escape_string($single_profile_data_ar['User-Name']);
                $Aptilo_Denied_Cause=mysql_real_escape_string($single_profile_data_ar['Aptilo-Denied-Cause']);

                $fullname=explode('@', $AAA_User_Name);
                if(count($fullname)==3){
                  $Email=$fullname['0'].'@'.$fullname['1'];
                  }
                  else{
                  $Email='';
                  }
                //$realm=$macc['1'];

               /* if($prop_type == 'VTENANT') {
                   if($Sender_Type=='Aptilo-AC' || $Sender_Type='Ruckus-SCG'){
                    if ($Account_State == 'Inactive') {
                        if ($Aptilo_Denied_Cause == '1') {

                        } else {
                            $Account_State = 'ignore';
                        }
                    } elseif ($Account_State == 'Active') {
                        if ($Aptilo_Denied_Cause == '99') {

                        } elseif (strlen($Aptilo_Denied_Cause) == 0) {

                        } else {
                            $Account_State = 'Inactive';
                        }
                    }
                   }else{
                        $Account_State = 'ignore';
                    }
                }*/
                   
                   /* $newarray1=array("Mac"=> $CLIENTID,
                                "Session_State"=> $Account_State,
                                "AAA_User_Name" => $AAA_User_Name,
                                "Session-Start-Time" => $START_TIME,
                                "Duration" => $DURATION,
                                "Idle_Time" => $IDLE_TIME,
                                "Device_Type" => $Device_Type,
                                "GW-Type" => $Gw_Type,
                                );*/

                    $newarray1=array("Mac"=> $CLIENTID,
                                "F-Name" => $fname,
                                "L-Name" => $lname,
                                "Email"=> $Email,
                                "Session_State"=> $Account_State,
                                "AAA_User_Name" => $AAA_User_Name,
                                "Session-Start-Time" => $START_TIME,
                                "Session-IP" => $cus_IP
                                );
                    
                array_push($res_arr1, $newarray1);
                
                $arraytest=array("Mac"=> $single_profile_data_ar['Session-MAC'],
                                  "Ses_token"=> $single_profile_data_ar['Session-Token']);
                array_push($res_arr2, $arraytest);
}}
		$resultArray = uniqueAssocArray($res_arr1, 'Mac', 'AAA_User_Name');
        $finalarray=array($resultArray,$res_arr2);
        //print_r($res_arr1);
        //print_r($res_arr2);


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




if(isset($_GET['tab'])){
    $active_tab=$_GET['tab'];
}else{
    $active_tab="account";
}

 /////FORM SUBMIT/////////////////////////////////////////
   if(isset($_POST['search_btn'])){ //1   

                                    
       if($_SESSION['FORM_SECRET'] == $_POST['form_secret']){//key validation

  $re_se=1;
$vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
$network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");


if (strlen($network_profile) > 0) {
require_once 'src/AAA/' . $network_profile . '/index.php';
$nf = new network_functions($vt_pro,'');
} else {
$nf = null;
}

$property_id = $_POST['property_id'];
$search_word = trim($_POST['search_word']);
$mac_address = trim($_POST['search_mac']);
$mac_address = str_replace(":","",$mac_address);
$mac_address = str_replace("-","",$mac_address);
$mac_address = str_replace("_","",$mac_address);
$mac_address = str_replace(" ","",$mac_address);

  
  $mac_address = strtolower($mac_address);
  
  $search_mac = $mac_address;
 $property_id = $_POST['property_id'];
 $search_word = trim($_POST['search_word']);
  

if(strlen($search_mac)>0){//1

$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
$rowe = mysql_fetch_array($br);
$search_id = $rowe['Auto_increment'];

$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");

if(!$Ex_insert){
$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
$rowe = mysql_fetch_array($br);
$search_id = $rowe['Auto_increment'];

$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");

}


//////////////////////////////////////////////////////////////////////////  

/*********APTILO Query & Show The Results*********************/
 

///////////////////////////////////////////////////////////////////////////// 


///Temp Case: query from table-result update from search id//////////////
//echo "SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set;
$find_customers=mysql_query("SELECT `customer_id` AS f FROM  `mdu_customer_devices`  WHERE `description` LIKE '%$search_mac%' ");

if(mysql_num_rows($find_customers)>0){
$record_found=1;
$customer_list = '';
while($row=mysql_fetch_array($find_customers)){
 
 $customer_id=$row['f'];
 //$customer_id=$row['f'];
 $customer_list .= ','.$customer_id;
 
 //$update_result=mysql_query("UPDATE `mdu_vetenant` SET`search_id` = '$search_id' WHERE `customer_id` = '$customer_id'");
 
 }

 $customer_list = trim($customer_list,',');
 $update_result=mysql_query("UPDATE `mdu_search_id` SET `customer_list` = '$customer_list' WHERE `id`='$search_id'");
 
}


}
else if(strlen($search_mac)==0){
/*if(strlen($search_word)>0){//1
  
  ////////////////START DATA TRANSFER//////////////////////

        if($property_id=='ALL') {


            $sql = "SELECT o.property_id,o.validity_time, o.ignore_on_search FROM mdu_system_user_organizations uo,mdu_organizations o 
              WHERE o.property_number=uo.property_id AND  uo.user_name = '$user_name'";*/

            /*$sql_r = $db->get_property($user_distributor); //mysql_query($sql);
            $search_id_up = uniqid($user_name);
            while ($sql_d = mysql_fetch_assoc($sql_r)) {

                $Response1 = $nf->findMasterUsers("Group", $sql_d['property_id'], "PAS-First-Name", $search_word);
                $updated1 = $customerOb->syncCustomer($Response1, $search_id_up);


                ///// Match With Last Name /////
                $Response2 = $nf->findMasterUsers("Group", $sql_d['property_id'], "PAS-Last-Name", $search_word);
                $updated2 = $customerOb->syncCustomer($Response2, $search_id_up);
                //parse_str($Response2);

                //syncCustomer($Response2,'');


                ///// Match With Email /////
                $Response3 = $nf->findMasterUsers("Group", $sql_d['property_id'], "Email", $search_word);
                $updated3 = $customerOb->syncCustomer($Response3, $search_id_up);
                //parse_str($Response3);
                //syncCustomer($Response3,'');

                
                  if($sql_d['ignore_on_search'] == 1){
                  }else{

                      $Response1 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"PAS-First-Name", $search_word);
                      $updated1 = $customerOb->syncCustomer($Response1, $search_id_up);


                      ///// Match With Last Name /////
                      $Response2 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"PAS-Last-Name", $search_word);
                      $updated2 = $customerOb->syncCustomer($Response2, $search_id_up);
                      //parse_str($Response2);

                      //syncCustomer($Response2,'');


                      ///// Match With Email /////
                      $Response3 = $nf->findMasterUsersByParams("Group",$sql_d['property_id'],"Validity-Time",$sql_d['validity_time'],"Email", $search_word);
                      $updated3 = $customerOb->syncCustomer($Response3, $search_id_up);
                      //parse_str($Response3);
                      //syncCustomer($Response3,'');
                  }
     


            }
            /////////// END DATA TRANSFER ////////////////
        }else{
            $Response1 = $nf->findMasterUsers("Group", $property_id, "PAS-First-Name", $search_word);
            $updated1 = $customerOb->syncCustomer($Response1, $search_id_up);


            ///// Match With Last Name /////
            $Response2 = $nf->findMasterUsers("Group", $property_id, "PAS-Last-Name", $search_word);
            $updated2 = $customerOb->syncCustomer($Response2, $search_id_up);
            //parse_str($Response2);

            //syncCustomer($Response2,'');


            ///// Match With Email /////
            $Response3 = $nf->findMasterUsers("Group", $property_id, "Email", $search_word);
            $updated3 = $customerOb->syncCustomer($Response3, $search_id_up);
        }
  
  }//1*/
  
  
  
  
  
  ////////////////////////////////////////////////////
  
  
  
  
  //Query Set////
  if($property_id =="ALL" && strlen($search_word)==0){  
    //$query_set="";
    //$query_set="WHERE ( property_id in (SELECT property_id FROM mdu_system_user_organizations WHERE user_name = '$user_name')) AND property_id <> '' ";
    //$query_set="WHERE ( property_id in (SELECT verification_number FROM exp_mno_distributor WHERE distributor_code = '$user_distributor')) AND property_id <> '' ";
    $query_set="WHERE property_id =( SELECT property_id FROM mdu_distributor_organizations WHERE distributor_code = '$user_distributor') AND property_id <> '' ";
    
    
    }
  elseif($property_id =="ALL" && strlen($search_word)>0){
      //$query_set="WHERE `first_name` LIKE '%$search_word%' OR `last_name` LIKE '%$search_word%' OR `email` LIKE '%$search_word%' OR `room_apt_no` LIKE '%$search_word%'";
      //$query_set="WHERE ( property_id in (SELECT property_id FROM mdu_system_user_organizations WHERE user_name = '$user_name')) AND (`first_name` = '$search_word' OR `last_name` = '$search_word' OR `email` = '$search_word' OR `room_apt_no` = '$search_word') AND property_id <> ''";
      //$query_set="WHERE ( property_id in (SELECT verification_number FROM exp_mno_distributor WHERE distributor_code = '$user_distributor')) AND (`first_name` LIKE '%$search_word%' OR `last_name` LIKE '%$search_word%' OR `email` LIKE '%$search_word%' OR `room_apt_no` LIKE '%$search_word%') AND property_id <> ''";
      $query_set="WHERE property_id =( SELECT property_id FROM mdu_distributor_organizations WHERE distributor_code = '$user_distributor') AND (`first_name` LIKE '%$search_word%' OR `last_name` LIKE '%$search_word%' OR `email` LIKE '%$search_word%' OR `room_apt_no` LIKE '%$search_word%') AND property_id <> ''";
        
      }
    elseif($property_id !="ALL" && strlen($search_word)>0){
      //$query_set="WHERE property_id='$property_id' AND `first_name` LIKE '%$search_word%' OR `last_name` LIKE '%$search_word%' OR `email` LIKE '%$search_word%' OR `room_apt_no` LIKE '%$search_word%'";
      //$query_set="WHERE (property_id='$property_id') AND (`first_name` = '$search_word' OR `last_name` = '$search_word' OR `email` = '$search_word' OR `room_apt_no` = '$search_word')";
      $query_set="WHERE (property_id='$property_id') AND (`first_name` LIKE '%$search_word%' OR `last_name` LIKE '%$search_word%' OR `email` LIKE '%$search_word%' OR `room_apt_no` = LIKE '%$search_word%')";
        
      }
    elseif($property_id !="ALL" && strlen($search_word)==0){
      $query_set="WHERE property_id='$property_id'";
      
      }
      

    
  $br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
  $rowe = mysql_fetch_array($br);
  $search_id = $rowe['Auto_increment'];
  
  $Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");
  
  if(!$Ex_insert){
  $br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
  $rowe = mysql_fetch_array($br);
  $search_id = $rowe['Auto_increment'];
  
  $Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");
    
    }
    
  
  //////////////////////////////////////////////////////////////////////////  
    
    /*********APTILO Query & Show The Results*********************/
      
    
  ///////////////////////////////////////////////////////////////////////////// 
  
  
  ///Temp Case: query from table-result update from search id//////////////
  //echo "SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set;
  $find_customers=mysql_query("SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set);
  if(mysql_num_rows($find_customers)>0){
    $record_found=1;
    $customer_list = '';
    while($row=mysql_fetch_array($find_customers)){
      
      $customer_id=$row['f'];
      //$customer_id=$row['f'];
      $customer_list .= ','.$customer_id;
      
      //$update_result=mysql_query("UPDATE `mdu_vetenant` SET`search_id` = '$search_id' WHERE `customer_id` = '$customer_id'");
      
      }
    
      $customer_list = trim($customer_list,',');
      $update_result=mysql_query("UPDATE `mdu_search_id` SET `customer_list` = '$customer_list' WHERE `id` = '$search_id'");
      
    
    
    
    
    }
    else{
      $record_found=0;
      $val_msg="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('tenant_acc_sync_no_recod','2004')."</strong></div>";
      
      
      }
  }else{
      $record_found=0;
      $val_msg="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('tenant_acc_sync_no_recod','2004')."</strong></div>";
      
      
      }
    

  }//key validation

 else{

    
    $val_msg="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>"."Oops, It seems you have refreshed the page. Please try again"."</strong></div>";
    $record_found=0;
      
          //header('Location: ');
          
          } 
      $record_found=1;
      $active = 'account'; 
                                    
                  
} //1
else{
  $re_se=1;
  $record_found=1;
  $query_set="WHERE property_id =( SELECT property_id FROM mdu_distributor_organizations WHERE distributor_code = '$user_distributor') AND property_id <> '' ";
    
  $br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
  $rowe = mysql_fetch_array($br);
  $search_id = $rowe['Auto_increment'];
  
  $Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");
  
  if(!$Ex_insert){
  $br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
  $rowe = mysql_fetch_array($br);
  $search_id = $rowe['Auto_increment'];
  
  $Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");
    
    }
    
  
  //////////////////////////////////////////////////////////////////////////  
    
    /*********APTILO Query & Show The Results*********************/
      
    
  ///////////////////////////////////////////////////////////////////////////// 
  
  
  ///Temp Case: query from table-result update from search id//////////////
  //echo "SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set;
  $find_customers=mysql_query("SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set);
  
  if(mysql_num_rows($find_customers)>0){
    $record_found=1;
    $customer_list = '';
    while($row=mysql_fetch_array($find_customers)){
      
      $customer_id=$row['f'];
      //$customer_id=$row['f'];
      $customer_list .= ','.$customer_id;
      
      //$update_result=mysql_query("UPDATE `mdu_vetenant` SET`search_id` = '$search_id' WHERE `customer_id` = '$customer_id'");
      
      }
    
      $customer_list = trim($customer_list,',');
      $update_result=mysql_query("UPDATE `mdu_search_id` SET `customer_list` = '$customer_list' WHERE `id` = '$search_id'");
      
    
    }
    
  
  //////////////////////////////////////////////////////////////////////////  
    
    /*********APTILO Query & Show The Results*********************/
      
    
  ///////////////////////////////////////////////////////////////////////////// 
  
  
  ///Temp Case: query from table-result update from search id//////////////
  //echo "SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set;
  $find_customers=mysql_query("SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set);
  
  if(mysql_num_rows($find_customers)>0){
    $record_found=1;
    $customer_list = '';
    while($row=mysql_fetch_array($find_customers)){
      
      $customer_id=$row['f'];
      //$customer_id=$row['f'];
      $customer_list .= ','.$customer_id;
      
      //$update_result=mysql_query("UPDATE `mdu_vetenant` SET`search_id` = '$search_id' WHERE `customer_id` = '$customer_id'");
      
      }
    
      $customer_list = trim($customer_list,',');
      $update_result=mysql_query("UPDATE `mdu_search_id` SET `customer_list` = '$customer_list' WHERE `id` = '$search_id'");
}

}

if(isset($_POST['mac_search_btn'])){ //1   

                                    
  if($_SESSION['FORM_SECRET'] == $_POST['form_secret']){//key validation

/* 

$vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);


$network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");


if (strlen($network_profile) > 0) {
require_once 'src/AAA/' . $network_profile . '/index.php';
$nf = new network_functions($vt_pro,'');
} else {
$nf = null;
} */

/* $property_id = $_POST['property_id']; */
$mac_address = trim($_POST['search_mac']);

$mac_address = str_replace(":","",$mac_address);
  $mac_address = str_replace("-","",$mac_address);
  $mac_address = str_replace("_","",$mac_address);
  $mac_address = str_replace(" ","",$mac_address);

  
  $mac_address = strtolower($mac_address);
  
  $search_mac = $mac_address;
  

if(strlen($search_mac)>0){//1





$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
$rowe = mysql_fetch_array($br);
$search_id = $rowe['Auto_increment'];

$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");

if(!$Ex_insert){
$br = mysql_query("SHOW TABLE STATUS LIKE 'mdu_search_id'");
$rowe = mysql_fetch_array($br);
$search_id = $rowe['Auto_increment'];

$Ex_insert=mysql_query("INSERT INTO `mdu_search_id` (`id`,`create_user`,`create_date`) 
VALUES('$search_id','$user_name',NOW())");

}


//////////////////////////////////////////////////////////////////////////  

/*********APTILO Query & Show The Results*********************/
 

///////////////////////////////////////////////////////////////////////////// 


///Temp Case: query from table-result update from search id//////////////
//echo "SELECT `customer_id` AS f FROM `mdu_vetenant` ".$query_set;
$find_customers=mysql_query("SELECT `customer_id` AS f FROM  `mdu_customer_devices`  WHERE `description` LIKE '%$search_mac%' ");

if(mysql_num_rows($find_customers)>0){
$record_found=1;
$customer_list = '';
while($row=mysql_fetch_array($find_customers)){
 
 $customer_id=$row['f'];
 //$customer_id=$row['f'];
 $customer_list .= ','.$customer_id;
 
 //$update_result=mysql_query("UPDATE `mdu_vetenant` SET`search_id` = '$search_id' WHERE `customer_id` = '$customer_id'");
 
 }

 $customer_list = trim($customer_list,',');
 $update_result=mysql_query("UPDATE `mdu_search_id` SET `customer_list` = '$customer_list' WHERE `id`='$search_id'");
 
}





}else{
 $record_found=0;
 $val_msg="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('tenant_acc_sync_no_recod','2004')."</strong></div>";
 
 
 }


}//key validation
else{
echo "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
     //header('Location: ');
     
     }  
                               
             
}
else if(isset($_POST['Delete_btn_device'])){//2 


  


 foreach ($_POST['customer_delete_id'] as $rm_customer_id) {


   
        
    if($_SESSION['FORM_SECRET']==$_POST['token']){



//include 'src/AAA/<network name>/index.php';
           /*  $admin_type=$db->getValueAsf("SELECT o.property_type AS f FROM mdu_system_user_organizations uo JOIN mdu_organizations o ON o.property_id=uo.property_id
WHERE uo.user_name='$user_name' LIMIT 1");


            $network_profile = $db->setValDistributor('NETWORK_NAME', $admin_type);
            if (strlen($network_profile) > 0) {
                require_once 'src/AAA/' . $network_profile . '/index.php';
                $nf = new network_functions();
            } else {
                $nf = null;
      } */
      

      $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
      $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");
    
    
    if (strlen($network_profile) > 0) {
      require_once 'src/AAA/' . $network_profile . '/index.php';
      $nf = new network_functions($vt_pro,'');
    } else {
      $nf = null;
    }



            $search_id = $_POST['search_id'];
  $record_found=1;
    //echo $rm_customer_id." ".$search_id."<br>";
    



  $cust_name_q = "SELECT CONCAT(`first_name`,' ',`last_name`) AS f FROM `mdu_vetenant` WHERE `customer_id`='$rm_customer_id' LIMIT 1";
  $cust_name=$db->getValueAsf($cust_name_q);;


   $cust_uname_q = "SELECT username AS f FROM `mdu_vetenant` WHERE `customer_id`='$rm_customer_id' LIMIT 1";
   $cust_user_name=$db->getValueAsf($cust_uname_q);
   
   $cust_property_id_q = "SELECT property_id AS f FROM `mdu_vetenant` WHERE `customer_id`='$rm_customer_id' LIMIT 1";
   $cust_property_id=$db->getValueAsf($cust_property_id_q);

   ////////////////APTILO API Call & Delete Customer //////
   $status_code = '';
   $status = '';

    /* Call Session API */

    $sub_ass_q = "SELECT `mac_address` AS 'net_user' FROM mdu_customer_devices WHERE customer_id = '$rm_customer_id'";
    $sub_ass_r = mysql_query($sub_ass_q);

   //delete sub acc**************************

        $not_del_sub_acc = array();
        $sub_del_respo = array();


        while ($devRow = mysql_fetch_assoc($sub_ass_r)){
         
            $sub_del = $nf->delUser($devRow['net_user']);
            parse_str($sub_del);
            $new_status=$status_code;

            if($status_code == 200 || $status_code == 404){
          $del_ses_response = $nf->getSessionsbymac($devRow['net_user']);
            
            $sessionstatus=json_decode($del_ses_response,true);
              //print_r($sessionstatus);
              $token=$sessionstatus['Description'];
              $status=$sessionstatus['status_code'];
              $ses_type=$sessionstatus['status'];

              if($status == 200){
                $query2 = sprintf("DELETE FROM mdu_customer_sessions where mac = %s",GetSQLValueString($customer_id,'text'));
                $del_response = $nf->disconnectDeviceSessions($token,$devRow['net_user']);
                parse_str($del_response);
                if($status_code == 204 || $status == 200){
                  $ex2 = mysql_query($query2);
                }

              }
            //print_r($sub_del_respo);
            if($new_status !=200 && $new_status !=404){
                array_push($not_del_sub_acc,$devRow['net_user']);
            }
      
          }
        }

        foreach ($not_del_sub_acc as $key => $net_user){
            $sub_del = $nf->delUser($net_user);
            parse_str($sub_del);
                   
            //parse_str($device_response);
                                       
          if($status_code == 200 || $status_code == 404){


            $del_ses_response = $nf->getSessionsbymac($net_user);

   $sessionstatus=json_decode($del_ses_response,true);
    //print_r($sessionstatus);
    $token=$sessionstatus['Description'];
    $status=$sessionstatus['status_code'];
    $ses_type=$sessionstatus['status'];

    if($status == 200){
      $query2 = sprintf("DELETE FROM mdu_customer_sessions where mac = %s",GetSQLValueString($customer_id,'text'));
      $del_response = $nf->disconnectDeviceSessions($token,$net_user);
      parse_str($del_response);
      if($status_code == 204 || $status == 200){
        $ex2 = mysql_query($query2);
      }
    }
    }
            
        }

     //*****************************************************

   //echo $rm_customer_id;
   $del_response = $nf->delUser($cust_user_name);
   parse_str($del_response);
   
   //$status_code=200;
   
    if($status_code == 200 || $status_code == 404){

      $query_aup ="UPDATE `mdu_aup_violation` SET ack_status=9 WHERE username='$cust_user_name'";
      $ex1 = mysql_query($query_aup);
    
    $cus_prperty_type= $db->getValueAsf("SELECT `property_type` AS f FROM `mdu_organizations` WHERE `property_id`='$cust_property_id'");

      
      $query0 = "DELETE FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'";
    $query_de = "DELETE FROM mdu_customer_devices WHERE `customer_id`='$rm_customer_id'";
      
      $del_vlanid = $db->getValueAsf("SELECT vlan_id as f FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'");
      $del_prop = $db->getValueAsf("SELECT property_id as f FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'");

      



      $vlanOb->addDeleteVlanID($del_prop,$del_vlanid);
      
      

      
      $archive_query = "INSERT INTO `mdu_customer_archive` 
    (`customer_id`,`first_name`,`last_name`,`email`,`username`,`password`,`first_login_date`,`last_login_date`,`property_id`,`room_apt_no`,`question_id`,`answer`,`company_name`,`address`,`city`,`state`,`postal_code`,`country`,`phone`,`is_enable`,`email_sent`,`registration_from`,`device_count`,`valid_from`,`valid_until`,`create_user`,`create_date`,`search_id`,`archived_by`)
    SELECT `customer_id`,`first_name`,`last_name`,`email`,`username`,`password`,`first_login_date`,`last_login_date`,`property_id`,`room_apt_no`,`question_id`,`answer`,`company_name`,`address`,`city`,`state`,`postal_code`,`country`,`phone`,`is_enable`,`email_sent`,`registration_from`,`device_count`,`valid_from`,`valid_until`,`create_user`,`create_date`,`search_id`,'$user_name'
    FROM `mdu_vetenant` WHERE `customer_id`='$rm_customer_id'";
      
      $arc_delete = mysql_query($archive_query);
      $ex_delete_de = mysql_query($query_de);
    
    if($ex_delete_de){
      $ex_delete = mysql_query($query0);
    }
      
      
   }
    
   ////////////////////////////////////////////////////////

  
  
   if($ex_delete){
  
      $_SESSION['msg']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
           <strong> ".$message_functions->showMessage('customer_delete_success','2002')."</strong></div>";
  
  
  }
  else{
      $_SESSION['msg']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button>
           <strong>".$message_functions->showMessage('customer_delete_failed','2002')."</strong></div>";
    
    }
    
    
  }else{
  //refresh page error     
       $_SESSION['msg']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('transaction_failed','2004')."</strong></div>";
       header('Location: manage_tenant.php');
  
  }
    
  }
}
else if(isset($_GET['rm_customer_id'])){//2


  //////////Customer Remove /////////////// 
  if($_SESSION['FORM_SECRET']==$_GET['token']){


//include 'src/AAA/<network name>/index.php';
       /*  $admin_type=$db->getValueAsf("SELECT o.property_type AS f FROM mdu_system_user_organizations uo JOIN mdu_organizations o ON o.property_id=uo.property_id
WHERE uo.user_name='$user_name' LIMIT 1");


        $network_profile = $db->setValDistributor('NETWORK_NAME', $admin_type);
        if (strlen($network_profile) > 0) {
            require_once 'src/AAA/' . $network_profile . '/index.php';
            $nf = new network_functions();
        } else {
            $nf = null;
    } */
    
    $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
    $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");
  
  
  if (strlen($network_profile) > 0) {
    require_once 'src/AAA/' . $network_profile . '/index.php';
    $nf = new network_functions($vt_pro,'');
  } else {
    $nf = null;
  }

        $rm_customer_id = $_GET['rm_customer_id'];
  $search_id = $_GET['search_id'];
  $record_found=1;



  $cust_name_q = "SELECT CONCAT(`first_name`,' ',`last_name`) AS f FROM `mdu_vetenant` WHERE `customer_id`='$rm_customer_id' LIMIT 1";
  $cust_name=$db->getValueAsf($cust_name_q);;


   $cust_uname_q = "SELECT username AS f FROM `mdu_vetenant` WHERE `customer_id`='$rm_customer_id' LIMIT 1";
   $cust_user_name=$db->getValueAsf($cust_uname_q);

   ////////////////APTILO API Call & Delete Customer //////
   $status_code = '';
   $status = '';
   
   $del_response = $nf->delUser($cust_user_name);
   parse_str($del_response);
   
   //$status_code=200;
   
 
   
    if($status_code == 200 || $status == 200){

      $query_aup ="UPDATE `mdu_aup_violation` SET ack_status=9 WHERE username='$cust_user_name'";
      $ex1 = mysql_query($query_aup);

        /* Call Session API */
        $url_base_mdu_sessions = $base_url.'/ajax/disconnect_account_sessions.php?account_type=account&account_user_name='.$cust_user_name.'&customer_id='.$rm_customer_id;
        httpGet($url_base_mdu_sessions);
        /* Call Session API */


      $query0 = "DELETE FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'";
    $query_de = "DELETE FROM mdu_customer_devices WHERE `customer_id`='$rm_customer_id'";
      
      $del_vlanid = $db->getValueAsf("SELECT vlan_id as f FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'");
      $del_prop = $db->getValueAsf("SELECT property_id as f FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'");

      //delete sub acc**************************

        $sub_ass_q = "SELECT `mac_address` AS 'net_user' FROM mdu_customer_devices WHERE customer_id = '$rm_customer_id'";
        $sub_ass_r = mysql_query($sub_ass_q);
        $not_del_sub_acc = array();
        $sub_del_respo = array();
        while ($devRow = mysql_fetch_assoc($sub_ass_r)){
         
            $sub_del = $nf->delUser($devRow['net_user']);
            parse_str($sub_del);
            $new_status=$status_code;

            if($status_code == 200 || $status_code == 404){
         $del_ses_response = $nf->getSessionsbymac($devRow['net_user']);
            
            $sessionstatus=json_decode($del_ses_response,true);
              //print_r($sessionstatus);
              $token=$sessionstatus['Description'];
              $status=$sessionstatus['status_code'];
              $ses_type=$sessionstatus['status'];

              if($status_code == 200 || $status == 200){
                $query2 = sprintf("DELETE FROM mdu_customer_sessions where mac = %s",GetSQLValueString($customer_id,'text'));
                $del_response = $nf->disconnectDeviceSessions($token,$devRow['net_user']);
                parse_str($del_response);
                if($status_code == 204 || $status == 200){
                  $ex2 = mysql_query($query2);
                }

              }
            //print_r($sub_del_respo);
            if($new_status !=200 && $new_status !=404){
                array_push($not_del_sub_acc,$devRow['net_user']);
            }
      
          }
        }

        foreach ($not_del_sub_acc as $key => $net_user){
            $sub_del = $nf->delUser($net_user);
            parse_str($sub_del);
                   
            //parse_str($device_response);
                                       
          if($status_code == 200 || $status_code == 404){


            $del_ses_response = $nf->getSessionsbymac($net_user);

   $sessionstatus=json_decode($del_ses_response,true);
    //print_r($sessionstatus);
    $token=$sessionstatus['Description'];
    $status=$sessionstatus['status_code'];
    $ses_type=$sessionstatus['status'];

    if($status_code == 200 || $status == 200){
      $query2 = sprintf("DELETE FROM mdu_customer_sessions where mac = %s",GetSQLValueString($customer_id,'text'));
      $del_response = $nf->disconnectDeviceSessions($token,$net_user);
      parse_str($del_response);
      if($status_code == 204 || $status == 200){
        $ex2 = mysql_query($query2);
      }
    }
    }
            
        }

        //*****************************************************



      $vlanOb->addDeleteVlanID($del_prop,$del_vlanid);
      

      
      $archive_query = "INSERT INTO `mdu_customer_archive` 
    (`customer_id`,`first_name`,`last_name`,`email`,`username`,`password`,`first_login_date`,`last_login_date`,`property_id`,`room_apt_no`,`question_id`,`answer`,`company_name`,`address`,`city`,`state`,`postal_code`,`country`,`phone`,`is_enable`,`email_sent`,`registration_from`,`device_count`,`valid_from`,`valid_until`,`create_user`,`create_date`,`search_id`,`archived_by`)
    SELECT `customer_id`,`first_name`,`last_name`,`email`,`username`,`password`,`first_login_date`,`last_login_date`,`property_id`,`room_apt_no`,`question_id`,`answer`,`company_name`,`address`,`city`,`state`,`postal_code`,`country`,`phone`,`is_enable`,`email_sent`,`registration_from`,`device_count`,`valid_from`,`valid_until`,`create_user`,`create_date`,`search_id`,'$user_name'
    FROM `mdu_vetenant` WHERE `customer_id`='$rm_customer_id'";
      
      $arc_delete = mysql_query($archive_query);
      $ex_delete_de = mysql_query($query_de);
    
    if($ex_delete_de){
      $ex_delete = mysql_query($query0);
    }
      
      
   }
    
   ////////////////////////////////////////////////////////

  
  
   if($ex_delete){
  
      $_SESSION['msg']= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
           <strong> Customer [".$cust_name."] has been successfully deleted</strong></div>";
  
  
  }
  else{
      $_SESSION['msg']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button>
           <strong>Deletion is failedaa</strong></div>";
    
    }
    
    
  }else{
  //refresh page error     
       $_SESSION['msg']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
       header('Location: manage_tenant.php');
  
  }


  
}//2

else if(isset($_GET['mg_customer_id'])){//3

  //////////Customer manage /////////////// 
  if($_SESSION['FORM_SECRET']==$_GET['token']){


      /*   $admin_type=$db->getValueAsf("SELECT o.property_type AS f FROM mdu_system_user_organizations uo JOIN mdu_organizations o ON o.property_id=uo.property_id
WHERE uo.user_name='$user_name' LIMIT 1");
 */

       /*  $network_profile = $db->setValDistributor('NETWORK_NAME', $admin_type);
        if (strlen($network_profile) > 0) {
            require_once 'src/AAA/' . $network_profile . '/index.php';
            $nf = new network_functions();
        } else {
            $nf = null;
    } */
    
    $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
    $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");
  
  
  if (strlen($network_profile) > 0) {
    require_once 'src/AAA/' . $network_profile . '/index.php';
    $nf = new network_functions($vt_pro,'');
  } else {
    $nf = null;
  }




        $mg_customer_id = $_GET['mg_customer_id'];
  $search_id = $_GET['search_id'];
  $record_found=1;
  $mg_email = $_GET['mg_email'];
  
  $q_go = mysql_query("SELECT username,property_id FROM `mdu_vetenant` WHERE `customer_id` = '$mg_customer_id' LIMIT 1");
  
  $rowc=mysql_fetch_array($q_go);
  $mg_uname=$rowc['username'];
  $mg_property=$rowc['property_id'];

  
  $manage_customer_enable=1;


        //$url_base_realm_sessions = $base_url.'/ajax/update_sessions.php?realm='.$mg_property;
        httpGet($url_base_realm_sessions); 
   
   ////////////////APTILO API Call & Get Connected Devices & Plan Details //////
   
  $device_response = $nf->findUsersByMaster($mg_uname);
   
   $customerOb -> syncCustomerDevices($device_response,$mg_uname,uniqid($mg_uname));
   ////////////////////////////////////////////////////////////////////////////////
    
  }else{
  //refresh page error     
       $_SESSION['msg']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>Oops, It seems you have refreshed the page. Please try again.</strong></div>";
       header('Location: manage_tenant.php');
  
  }


}//3
//
else if(isset($_POST['customer_submit'])){ //4  

    ////Customer Information Update///////////////////////////////////////// 
                                    
      if($_SESSION['FORM_SECRET'] == $_POST['form_secret']){//key validation   


//include 'src/AAA/<network name>/index.php';
        /*   $admin_type=$db->getValueAsf("SELECT o.property_type AS f FROM mdu_system_user_organizations uo JOIN mdu_organizations o ON o.property_id=uo.property_id
WHERE uo.user_name='$user_name' LIMIT 1");


          $network_profile = $db->setValDistributor('NETWORK_NAME', $admin_type);
          if (strlen($network_profile) > 0) {
              require_once 'src/AAA/' . $network_profile . '/index.php';
              $nf = new network_functions();
          } else {
              $nf = null;
          } */

      $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
      $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");
    
    
    if (strlen($network_profile) > 0) {
      require_once 'src/AAA/' . $network_profile . '/index.php';
      $nf = new network_functions($vt_pro,'');
    } else {
      $nf = null;
    }
    


          $mg_customer_id = $_POST['mg_customer_id'];
      $search_id = $_POST['search_id'];
      $record_found=1;
      $manage_customer_enable=1;

      $vlan_id=trim($_POST['vlan_id_details']);
      $first_name = mysql_real_escape_string(trim($_POST["first_name"]));
      $last_name = mysql_real_escape_string(trim($_POST["last_name"]));
      $property_id=$_POST['property_id'];
      $cust_uname = $_POST["edit_customer_uname"];
      $password = trim($_POST["password"]);
      $room = trim($_POST["room"]);
      $customer_email = $_POST["email"];
      $question = $_POST["question"];
      $answer = mysql_real_escape_string($_POST["answer"]);
      $comp_name=trim($_POST['comp_name']);
      $street_address=mysql_real_escape_string(trim($_POST['street_address']));
      $city=mysql_real_escape_string(trim($_POST['city']));
      $postal_code=trim($_POST['postal_code']);
      $country=$_POST['country'];
      $phone=trim($_POST['phone']);
      $state=mysql_real_escape_string(trim($_POST['state']));

                  
   $user_date_string = "usermessage=0&address2=".$room."&warning=0&country=".$country."&address=".$street_address."&violation=0&state=".$state."&zip=".$postal_code."&secret_question=".$question."&city=".$city."&secret_answer=".$answer."&company=".$comp_name;
                    
  
  /////////check customer email duplicate//////
  $chek_mail=mysql_query("SELECT * FROM `mdu_vetenant` WHERE `email`='$customer_email' AND customer_id <>'$mg_customer_id'");


  //if($password!=$db->getValueAsf("SELECT `password` AS f FROM `mdu_vetenant` WHERE `email`='$customer_email' AND customer_id ='$mg_customer_id'")) {
    //if (mysql_num_rows($chek_mail) == 0) {//mail


      // $email_sent=0;

      /////////////////////////////////////////////////////////////
      $query_0 = "SELECT * FROM `mdu_vetenant` WHERE username = '$cust_uname' AND `property_id` = '$property_id'";

      $result_0 = mysql_query($query_0);
      
      $result_load = mysql_fetch_array($result_0);
      
      if(empty($password)){
        $password=$result_load['password'];
        }
      //echo mysql_num_rows($result_0);
      if (mysql_num_rows($result_0) >= 1) {
        $query01 = "UPDATE `mdu_vetenant` SET
                customer_id = '$mg_customer_id',
                `email` = '$customer_email',
                `first_name` = '$first_name',
                `last_name` = '$last_name',
                username = '$cust_uname',
                `password` = '$password',
                room_apt_no = '$room',
                `question_id` = '$question',
                property_id = '$property_id',
                `answer` = '$answer',
                create_date = 'NOW()',
                email_sent = '$email_sent',
                create_user = '$user_name',
                search_id = '$search_id',
                company_name = '$comp_name',
                address = '$street_address',
                city = '$city',
                state = '$state',
                postal_code = '$postal_code',
                country = '$country',
                phone = '$phone'
                WHERE username = '$cust_uname' AND `property_id` = '$property_id'";
      } else {
        $query01 = "REPLACE INTO `mdu_vetenant` (customer_id,`email`,`first_name`,`last_name`,username,`password`,room_apt_no,`question_id`,property_id,`answer`,create_date,email_sent,create_user,search_id,company_name,address,city,state,postal_code,country,phone)
         VALUES('$mg_customer_id','$customer_email','$first_name','$last_name','$cust_uname','$password','$room', '$question','$property_id','$answer',NOW(),'$email_sent','$user_name','$search_id','$comp_name','$street_address','$city','$state','$postal_code','$country','$phone')";
      }


      /*$query0 = "REPLACE INTO `mdu_vetenant` (customer_id,`email`,`first_name`,`last_name`,username,`password`,room_apt_no,`question_id`,property_id,`answer`,create_date,email_sent,create_user,search_id,company_name,address,city,state,postal_code,country,phone)
            VALUES('$mg_customer_id','$customer_email','$first_name','$last_name','$user_name',$password,'$room', '$question','$property_id','$answer',NOW(),'$email_sent','$user_name','$search_id','$comp_name','$street_address','$city','$state','$postal_code','$country','$phone')";*/

      //////////////CALL APTILO API and updatecustomer  Account/////////////

      $response = $nf->modifyAcc($cust_uname, $customer_email,$password, $first_name, $last_name, $property_id, $phone, $user_date_string,$vlan_id);

      ///////////////////////////////////////////////////////////////////////


      parse_str($response);
      //$status_code=200;

      if ($status_code == 200 || $status == 200) {
        ///echo $query01;
        $ex0 = mysql_query($query01);
        $msg_edit = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
           <strong>".$message_functions->showMessage('tenant_acc_update_success','2002')."</strong></div>";

        if ($password != "") {
          $customer_full_name = $first_name . " " . $last_name;
          $to = $customer_email;
          //$subject = $db->setVal("short_title", "MANAGER") . ' Email Notification';

          //$from_email_add = strip_tags($db->setVal('FROM_EMAIL', $mdu_distributor_id));
          $mno_package=$package_functions->getDistributorMONPackage($user_name);
         // $MNO=$db->getValueAsf("SELECT mno_id AS f FROM exp_mno WHERE system_package='$mno_package'");
          
          
          $from=strip_tags($db->setVal("email", $mno_id));
          if (empty($from)) {
            $from=strip_tags($db->setVal("email", "ADMIN"));
          }
           
          // echo $mno_package=$package_functions->getDistributorMONPackage($user_name);

          //$title=$db->setVal("short_title", "ADMIN") ;
          $email_content = $db->getEmailTemplate('CUSTOMER_MAIL',$mno_package,'ADMIN');

        

          $a = $email_content[0]['text_details'];

          $subject = $email_content[0]['title'];


          /* $queryf = "SELECT email AS f FROM admin_portal_title WHERE user_name='$user_name'";
          $query_resultsf = mysql_query($queryf);
          while ($rowf = mysql_fetch_array($query_resultsf)) {
            $from_email_add = $rowf['f'];
          }


          if (strlen($from_email_add) == 0) {
            $from_email_add = strip_tags($db->setVal("email", "MANAGER"));
          } */


        /*  $headers = "From: " . $db->setVal("short_title", "MANAGER") . "<" . $from_email_add . ">\r\n";
          $headers .= "Reply-To: " . $from_email_add . "\r\n";
          $headers .= "MIME-Version: 1.0\r\n";

          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; */
          
          ////////////////////////////////////////
        
        $property_query ="SELECT `property_type` FROM `mdu_organizations` WHERE `property_id`='$property_id'; ";  
        $result_property = mysql_query($property_query);
      
        $result_load_property = mysql_fetch_array($result_property);
        
        $get_property_type =$result_load_property['property_type'];
        
        if($get_property_type=='VTENANT'){
          
          $act_link = $db->setVal("mdu_portal_base_url", "ADMIN");

          $act_link = str_replace('<GROUPNUMBER>', $property_id, $act_link);

          $link = '<a href="' . $act_link .'/user_checkpoint.php?realm='.$property_id. '">' . $act_link .'/user_checkpoint.php?realm='.$property_id. '</a>';
          
          }else if($get_property_type=='MDU'){
            
            
            //$act_link = $db->setVal("activation_link", "MANAGER");
            $act_link=$db->getValueAsf("SELECT tenant_portal_link AS f FROM mdu_organizations WHERE property_number='$property_id'");
            

          $act_link = str_replace('<GROUPNUMBER>', $property_id, $act_link);

          $link = '<a href="' . $act_link . '">' . $act_link . '</a>';
          
            }

          //////////////////////////////////////////////




          /* $a = $db->textVal('CUSTOMER_MAIL', 'MANAGER', $mdu_distributor_id);


          if(strlen($a)==0){
                                        
                                            
            $a = $db->textVal('CUSTOMER_MAIL','MANAGER',$package_functions->getAdminPackage());

            if(strlen($a)==0){
             
              $a = $db->textVal('CUSTOMER_MAIL', 'MANAGER', 'TEMPLATE');
            }
           
           }  */


          $vars = array(
            '{$user_full_name}' => $customer_full_name,
            '{$short_name}' => $db->setVal("short_title", "ADMIN"),
            '{$account_type}' => 'MNO',
            '{$user_name}' => $customer_email,
            '{$password}' => $password,
            '{$link}' => $link

          );

          $message_full = strtr($a, $vars);


          $message = $message_full;
                   /*  $emailSystem=$package_functions->getSectionType("EMAIL_SYSTEM",$package_functions->getAdminPackage());
                    if(strlen($emailSystem)>0){
                        require_once ('src/email/'.$emailSystem.'/index.php');
                        $emailSystemOb=new email(array('template'=>$emailTemplate));
                        $mail_sent=$emailSystemOb->sendEmail($from_email_add,$to,$subject,$message,'','');
                    }else {
                        $mail_sent = @mail($to, $subject, $message, $headers);
          } */
          

          
$email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
include_once 'src/email/'.$email_send_method.'/index.php';

//email template
$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
$cunst_var=array();
if($emailTemplateType=='child'){
  $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$mno_sys_package);
}elseif($emailTemplateType=='owen'){
  $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
}else{
  $cunst_var['template']=$emailTemplateType;
}

$mail_obj=new email($cunst_var);
$mail_obj->mno_system_package = $mno_package;
$mail_sent=$mail_obj->sendEmail($from,$to,$subject,$message_full,'',$title);



          
          if ($mail_sent) {
          mysql_query("UPDATE mdu_vetenant SET email_sent='1' WHERE customer_id='$cust_uname'");
          }
        }
      } else {
        $msg_edit = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('tenant_acc_update_failed','2002')."</strong></div>";

      }


    //}//mail
    /* else {


      $msg_edit = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>Error: This Email [" . $customer_email . "] is already exist</strong></div>";
      //header('Location: ');

    } */

  //}else{
//    $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>No changes to Update!</strong></div>";
//
//  }
    
                                                    
                                    
                                    
                                  }//key validation
                  else{
                    
          
          $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('transaction_failed','2004')."</strong></div>";
          //header('Location: ');
          
          }  
          
        
                                    
                  
} //4
//
else if(isset($_GET['rm_device_id'])){ //4  

    ////Customer Information Update///////////////////////////////////////// 
                                    
      if($_SESSION['FORM_SECRET'] == $_GET['token']){//key validation  

//include 'src/AAA/<network name>/index.php';
         /*  $admin_type=$db->getValueAsf("SELECT o.property_type AS f FROM mdu_system_user_organizations uo JOIN mdu_organizations o ON o.property_id=uo.property_id
WHERE uo.user_name='$user_name' LIMIT 1");


          $network_profile = $db->setValDistributor('NETWORK_NAME', $admin_type);
          if (strlen($network_profile) > 0) {
              require_once 'src/AAA/' . $network_profile . '/index.php';
              $nf = new network_functions();
          } else {
              $nf = null;
          } */

      $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
      $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");
    
    
    if (strlen($network_profile) > 0) {
      require_once 'src/AAA/' . $network_profile . '/index.php';
      $nf = new network_functions($vt_pro,'');
    } else {
      $nf = null;
    }





          $mg_customer_id = $_GET['customer_id'];
        $search_id = $_GET['search_id'];
        $rm_device_id = $_GET['rm_device_id'];
        $record_found=1;
        $manage_customer_enable=1;
                   
                                    
   $qd_get = "SELECT mac_address,description as d2 FROM mdu_customer_devices WHERE id = '$rm_device_id' LIMIT 1";
  $get_dev_name=mysql_query($qd_get);
  while($rowe=mysql_fetch_array($get_dev_name)){
     $mac_address=$rowe['mac_address'];
     $discription1=$rowe['d2'];
  }
  
  
  //exit();
  
  
  //////////////CALL APTILO API and delete connected device/////////////
    $query0 = "DELETE FROM mdu_customer_devices where id = '$rm_device_id'";
     
    $query_del_device ="INSERT INTO `mdu_customer_devices_archive` (`id`,`customer_id`,`email_address`,`nick_name`,`group`,`description`,`mac_address`,`user_name`,`create_user`,`create_date`,`archived_by`)
  SELECT `id`,`customer_id`,`email_address`,`nick_name`,`group`,`description`,`mac_address`,`user_name`,`create_user`,`create_date`,'$user_name'
  FROM `mdu_customer_devices` WHERE id = '$rm_device_id'";
  
  
    
    $cust_property_id_q = "SELECT property_id AS f FROM `mdu_vetenant` WHERE `customer_id`='$mg_customer_id' LIMIT 1";
    $cust_property_id=$db->getValueAsf($cust_property_id_q);

  $cus_property_type= $db->getValueAsf("SELECT `property_type` AS f FROM `mdu_organizations` WHERE `property_id`='$cust_property_id'");



    $del_response = $nf->delUser($mac_address);
     parse_str($del_response);
     

                             
     //parse_str($device_response);
                                
   if($status_code == 200 || $status == 200){

    sleep(3);
       /* Call Session API */
     $mac_ex=explode("@",$mac_address);
     $mac_address1=$mac_ex[0];
    $del_ses_response = $nf->getSessionsbymac($mac_address);

   $sessionstatus=json_decode($del_ses_response,true);
    //print_r($sessionstatus);
    $token=$sessionstatus['Description'];
    $status=$sessionstatus['status_code'];
    $ses_type=$sessionstatus['status'];

    if($status == 200){
      $query2 = sprintf("DELETE FROM mdu_customer_sessions where mac = %s",GetSQLValueString($customer_id,'text'));
      $del_response = $nf->disconnectDeviceSessions($token,$mac_address);
      parse_str($del_response);
      if($status_code == 204 || $status_code == 200){
        
        $ex2 = mysql_query($query2);
      }

    }
     // $url_base_mdu_sessions = $base_url.'/ajax/disconnect_account_sessions.php?account_place=group_admin_device_removes&account_user_name='.$mac_address1.'&customer_id='.$discription1.'&account_property='.$cus_property_type;
     //  // $base_url.'/ajax/delete_mac_sessions.php?mac='.$mac_original_val;
     //    httpGet($url_base_mdu_sessions);
     //   /* Call Session API */
      
     //   $ex_del = mysql_query($query_del_device);
        $ex0 = mysql_query($query0);
   }
  
  /////////////////////////////////////////////////////////////////////// 
  

  
      if($ex0){
  $msg_edit= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
           <strong>".$message_functions->showMessage('device_remove_success','2003')."</strong></div>";   
    }else{
      $msg_edit= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('device_remove_failed','2003')."</strong></div>";
      
      }
      

   }// key validation

  else{
                    
          
  $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('transaction_failed','2004')."</strong></div>";
  //header('Location: ');
  
  } 
          
                                                    
} //5
   //







else if(isset($_GET['rm_ses_id'])){ //4

  ////Customer Information Update/////////////////////////////////////////

  if($_SESSION['FORM_SECRET'] == $_GET['token']){//key validation

 $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
    $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");


if (strlen($network_profile) > 0) {
    require_once 'src/AAA/' . $network_profile . '/index.php';
    $nf = new network_functions($vt_pro,'');
} else {
    $nf = null;
}


  $mg_customer_id = $_GET['customer_id'];
  $search_id = $_GET['search_id'];
  //$rm_ses_id = $_GET['rm_ses_id'];
    $get_mac_id=$_GET['mac_id'];
  $record_found=1;
  $manage_customer_enable=1;

  $user_realm=$db->getValueAsf("SELECT property_id AS f FROM mdu_vetenant WHERE customer_id='$mg_customer_id' LIMIT 1");
    $uni_rms_customer=$db->getValueAsf("SELECT username AS f FROM mdu_vetenant WHERE customer_id='$mg_customer_id' LIMIT 1");
    $us_property_type = $db->getValueAsf("SELECT property_type AS f FROM mdu_organizations WHERE property_number ='$user_realm' LIMIT 1");
    
        /* Call Session API */

        $del_ses_response = $nf->getSessionsbymac($get_mac_id);

       $sessionstatus=json_decode($del_ses_response,true);
        //print_r($sessionstatus);
        $token=$sessionstatus['Description'];
        $status=$sessionstatus['status_code'];
        $ses_type=$sessionstatus['status'];

        if($status == 200){
          
          $del_response = $nf->disconnectDeviceSessions($token,$get_mac_id);
          parse_str($del_response);
          if($status_code == 204 || $status_code == 200){
            $ex0=mysql_query("DELETE FROM mdu_customer_sessions WHERE mac='$get_mac_id' AND realm='$user_realm'");
        }
      }

//  }

  ///////////////////////////////////////////////////////////////////////



  if($ex0){
    $msg_edit= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
           <strong>".$message_functions->showMessage('session_remove_success','2003')."</strong></div>";
  }else{
    $msg_edit= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('session_remove_failed','2003')."</strong></div>";

  }


}//key validation

else{

    
  $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('transaction_failed','2004')."</strong></div>";
  //header('Location: ');

}
  
 
} //5
//








else if(isset($_POST['device_submit'])){ //6  

  /* ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL); */
    ////Add new connected device///////////////////////////////////////// 

      if($_SESSION['FORM_SECRET'] == $_POST['form_secret']){//key validation




//include 'src/AAA/<network name>/index.php';
         /*  $admin_type=$db->getValueAsf("SELECT o.property_type AS f FROM mdu_system_user_organizations uo JOIN mdu_organizations o ON o.property_id=uo.property_id
WHERE uo.user_name='$user_name' LIMIT 1");


          $network_profile = $db->setValDistributor('NETWORK_NAME', $admin_type);
          if (strlen($network_profile) > 0) {
              require_once 'src/AAA/' . $network_profile . '/index.php';
              $nf = new network_functions();
          } else {
              $nf = null;
      } */
      

      $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
    $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");


if (strlen($network_profile) > 0) {
    require_once 'src/AAA/' . $network_profile . '/index.php';
    $nf = new network_functions($vt_pro,'');
} else {
    $nf = null;
}



          $record_found=1;
                              $manage_customer_enable=1;
                                                    
                $mg_customer_id = $_POST['mg_customer_id'];
                $search_id = $_POST['search_id'];
                $mac_address = $_POST['mac_address'];
                
                
                $nick_name = $_POST['nick_name'];
                $short_desc = $_POST['short_desc'];
                $email= $_POST['email'];
                
                
    ///get customer email////   
     //"SELECT c.*, o.property_type FROM `mdu_vetenant` c INNER JOIN mdu_organizations o ON c.property_id=o.property_id WHERE customer_id='$mg_customer_id' LIMIT 1";
          //$rowc=mysql_fetch_array($get_cust_mail);
          //$cust_email=$rowc['email'];
          $q = "SELECT c.*, o.property_type,o.append_realm FROM `mdu_vetenant` c INNER JOIN mdu_organizations o ON c.property_id=o.property_id WHERE customer_id='$mg_customer_id' LIMIT 1";
    $get_cust_mail=mysql_query($q);
  while($rowc=mysql_fetch_array($get_cust_mail)){
    $cust_email=$rowc['email'];
    $property_id=$rowc['property_id'];
    $username=$rowc['username'];
    $first_name=$rowc['first_name'];
    //$last_name=$rowc['last_name'];
    //Last Name equal to NIC Name
    $last_name = $nick_name;
    $phone=$rowc['phone'];
    $vlan_id_val=$rowc['vlan_id'];   
    $property_type=$rowc['property_type'];
        $append_realm = $rowc['append_realm'];
  }
   
   if($property_type=='VTENANT' && $vlan_id_val<1){
         include_once 'classes/VlanID.php';
         $VlanIDOb=new VlanID();
         $vlan_id_val=$VlanIDOb->getVlanID($property_id);
    if($vlan_id_val>0){

         $updated_vlan_q="UPDATE mdu_vetenant SET vlan_id='$vlan_id_val' WHERE username='$username'";
         mysql_query($updated_vlan_q);
    }
   }
  
  $property_number = $property_id;
  
  //if($vlan_id_val>0){
  
  //formalize the mac address
  $mac_address = str_replace(":","",$mac_address);
  $mac_address = str_replace("-","",$mac_address);
  $mac_address = str_replace("_","",$mac_address);
  $mac_address = str_replace(" ","",$mac_address);

  
  $mac_address = strtolower($mac_address);
  
  $original_mac = $mac_address;
  
  
  
  if(strlen($original_mac) == 12){
  /// REALM CHNAGE
  
  //PROPERTY Number
  //$mac_address = $mac_address.'@'.$property_number;
        $mac_address = $nf->getUserName($property_number,$mac_address,$append_realm);
  // Property ID
  //$mac_address = $property_id.'/'.$mac_address;

  /////////check mac addrees  duplicate//////
  $chek_mac=mysql_query("SELECT * FROM `mdu_customer_devices` WHERE user_name='$username' AND mac_address='$mac_address'");
  
  
  if(mysql_num_rows($chek_mac)==0){//mac
    
    //////////////////////////////////////////////////////////
        $query_0 = "SELECT * FROM `mdu_customer_devices` WHERE mac_address = '$mac_address' ";

        $result_0 = mysql_query($query_0);
        //echo mysql_num_rows($result_0);
        if(mysql_num_rows($result_0) >= 1){
            $query1 = "UPDATE `mdu_customer_devices` SET
                `customer_id`   = '$mg_customer_id',
                `email_address` = '$cust_email',
                `nick_name` = '$nick_name',
                user_name   = '$username',
                `group` = '$property_id',
                `description`   = '$original_mac',
                `mac_address`   = '$mac_address',
                create_user = '$user_name'
                WHERE mac_address = '$short_desc'";
        }else {
            $query1 = "REPLACE INTO `mdu_customer_devices` (`customer_id`,`email_address`,`group`,`nick_name`,user_name,`description`,`mac_address`,create_user,`create_date`) VALUES
        ('$mg_customer_id','$cust_email','$property_id','$nick_name','$username','$original_mac','$mac_address','$user_name',NOW())";
        }

    /*$query1 = "REPLACE INTO `mdu_customer_devices` (`customer_id`,`email_address`,`nick_name`,user_name,`description`,`mac_address`,create_user,`create_date`) VALUES
    ('$mg_customer_id','$email','$nick_name','$username','$short_desc','$mac_address','$user_name',NOW())";*/
    
  //////////////CALL APTILO API and Add new connected device  Account/////////////
  
//$property_type=$db->getValueAsf("SELECT property_type AS f FROM mdu_organizations WHERE property_number='$property_id'");

if($property_type=='MDU'){

  $device_response = $nf->subAcc($mac_address,$username,$property_id,$first_name,$last_name,$cust_email,$original_mac);

    parse_str($device_response);
    //$status_code = 200;
    if($status_code == 200 || $status == 200){

        sleep(3);

        $start_sessions_url=$base_url.'/ajax/session_start.php?start_session='.$mac_address.'&group='.$property_number;

        httpGet($start_sessions_url);

        if($mg_customer_id!=NULL || $mg_customer_id!=''){

            $ex1 = mysql_query($query1);
        }
    }
  
}
elseif($property_type=='VTENANT' && $vlan_id_val>0 ) {

     $device_response = $nf->subAcc($mac_address,$username,$property_id,$first_name,$last_name,$cust_email,$original_mac,$vlan_id_val);
     
  
    parse_str($device_response);
    //$status_code = 200;
    if($status_code == 200 || $status == 200){

        if($mg_customer_id!=NULL || $mg_customer_id!=''){

            //$url_base_mdu_sessions = $base_url.'/ajax/disconnect_account_sessions.php?account_place=group_admin_device_add&account_user_name='.$mac_address.'&customer_id='.$mg_customer_id.'&account_property='.$property_type;
            //httpGet($url_base_mdu_sessions);

            $ex1 = mysql_query($query1);

        }
    }

}else{
     $device_response = $nf->subAcc($mac_address,$username,$property_id,$first_name,$last_name,$cust_email,$original_mac);
    parse_str($device_response);
    //$status_code = 200;
    if($status_code == 200 || $status == 200){

        sleep(3);


        $start_sessions_url=$base_url.'/ajax/session_start.php?start_session='.$mac_address.'&group='.$property_number;

        httpGet($start_sessions_url);

        if($mg_customer_id!=NULL || $mg_customer_id!=''){

            $ex1 = mysql_query($query1);

        }
    }

}
  /////////////////////////////////////////////////////////////////////// 
    
//echo "".$status_code;
  
  
  if($ex1 && $status_code == 200 && ($mg_customer_id!=NULL || $mg_customer_id!='')){
  
       
       if($property_type=='VTENANT'){
         $msg_edit= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
       <strong>Device has been successfully added</strong></div><button style=\"display:none;\" type=\"button\" class=\"btn btn-info btn-lg\" data-toggle=\"modal\" data-target=\"#myModal\"id=\"auto_click\"></button>

            <!-- Modal -->
            <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
              <div class=\"modal-dialog\">

                             <!-- Modal content-->
                <div class=\"modal-content\">
                  <div class=\"modal-body\">
                    <img style=\"width: 100%;\" src=\"img/Modal Image.png\">
                  </div>
                  <div style=\"border-top: none; background-color: #FFFFFF\" class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">Close</button>
                  </div>
                </div>
                </div>
                </div>

                <script>
                  
                  $(document).ready(function(){ 
                  $('#auto_click').click();
                                 
                  }); 
                  </script>
                  ";
       }
       else{
        $msg_edit= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
       <strong>".$message_functions->showMessage('device_add_success','2001')."</strong></div>";
       }
       
  }elseif ($ex1){

    if($property_type=='VTENANT'){
         $msg_edit= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('device_add_session_failed','2001')."</strong></div><button style=\"display:none;\" type=\"button\" class=\"btn btn-info btn-lg\" data-toggle=\"modal\" data-target=\"#myModal\"id=\"auto_click\"></button>

            <!-- Modal -->
            <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
              <div class=\"modal-dialog\">

                             <!-- Modal content-->
                <div class=\"modal-content\">
                  <div class=\"modal-body\">
                    <img style=\"width: 100%;\" src=\"img/Modal Image.png\">
                  </div>
                  <div style=\"border-top: none; background-color: #FFFFFF\" class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">Close</button>
                  </div>
                </div>
                </div>
                </div>

                <script>
                  
                  $(document).ready(function(){ 
                  $('#auto_click').click();
                                 
                  }); 
                  </script>
                  ";
  
       }
       else{
        $msg_edit= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('device_add_session_failed','2001')."</strong></div>";
  
       }
    
    }
  
  else
  {
    if($status_code==409){
  $msg_edit= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showNameMessage('device_add_already_reg',$mac_address)."</strong></div>";        
    }else{
    $msg_edit= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('device_add_failed','2001')."</strong></div>";
    }
   }              
    
    
  }//mac
   else{
                    
          
          $msg_edit= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showNameMessage('device_add_already_reg',$mac_address)."</strong></div>";
          //header('Location: ');
          
          } 
    

  }else{
    $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('device_add_invalid_mac','2004')."</strong></div>";
    
  } 

  //}else{
//        $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>Device creation is failed. No VLAN IDs available in the VLAN pool</strong></div>";
//    }
                                    
                                    
                                  }//key validation
                  else{
                    
          
          $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('transaction_failed','2004')."</strong></div>";
          //header('Location: ');
          
          } 
          
          

          
          
           
                                    
                  
} //6


elseif(isset($_GET['up_customer_id'])){



//include 'src/AAA/<network name>/index.php';
   /*  $admin_type=$db->getValueAsf("SELECT o.property_type AS f FROM mdu_system_user_organizations uo JOIN mdu_organizations o ON o.property_id=uo.property_id
WHERE uo.user_name='$user_name' LIMIT 1");


    $network_profile = $db->setValDistributor('NETWORK_NAME', $admin_type);
    if (strlen($network_profile) > 0) {
        require_once 'src/AAA/' . $network_profile . '/index.php';
        $nf = new network_functions();
    } else {
        $nf = null;
    }
 */


$vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
$network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");


if (strlen($network_profile) > 0) {
require_once 'src/AAA/'.$network_profile.'/index.php';
$nf = new network_functions($vt_pro,'');
} else {
$nf = null;
}


    $record_found=1;
    $manage_customer_enable=1;
    $search_id=$_GET['search_id'];
    $new_profile=$_GET['profile_name'];
    $cecrot_val=$_GET['token'];
    $mg_customer_id=$_GET['up_customer_id'];
  $profile_type = strtoupper($_GET['type']);
  

    $sqlpro="SELECT email,username FROM  mdu_vetenant WHERE customer_id='".$mg_customer_id."'";
    $query_get_mail=mysql_query($sqlpro);
    $prof_mail=mysql_fetch_assoc($query_get_mail);
    //$mail=$prof_mail['email'];
  $mail=$prof_mail['username'];

    if($cecrot_val==$_SESSION['PROF_RAND']){

      /*//$device_remove_response=$nf->removeProfile($mail);
      parse_str($device_remove_response);
      if($status_code == 200 || $status == 200){
      $status_code ="" ;
      $status ="";*/
      //echo $new_profile;
           $device_response=$nf->modifyProfile($mail,$new_profile);
          parse_str($device_response);
          //$status_code = 200;
          if($status_code == 200 || $status == 200){
        $status_code ="" ;
        $status ="";

        $upprof_main = "UPDATE `mdu_vetenant` SET service_profile = '$new_profile',profile_type = '$profile_type' WHERE customer_id = '$mg_customer_id'";
        $prof_chang_ex = mysql_query($upprof_main);


        $upprof = "INSERT INTO `system_user_service_profile_assign` (  `customer_id`, `user_name`,profile_type,  `service_profile`, `create_user`, `create_date` )
           VALUES ( '" . $mg_customer_id . "','" . $mail . "','" . $profile_type . "','" . $new_profile . "', '" . $user_name . "',NOW() )";

        $prof_chang_q = mysql_query($upprof);

        if ($prof_chang_q) {

          $cust_user_name_q=mysql_query("SELECT `username`,`property_id` FROM `mdu_vetenant` WHERE `customer_id`='$mg_customer_id'");
          $cust_user_name_r=mysql_fetch_array($cust_user_name_q);
          $cust_user_name=$cust_user_name_r['username'];
          $cust_user_property_id=$cust_user_name_r['property_id'];

          $get_prperty_type_cus = $db->getValueAsf("SELECT `property_type` AS f FROM `mdu_organizations` WHERE `property_id`='$cust_user_property_id'");

          /* Call Session API */
          $url_base_mdu_sessions = $base_url.'/ajax/disconnect_account_sessions.php?account_place=group_admin_qos_toggle&account_user_name='.$cust_user_name.'&customer_id='.$mg_customer_id.'&account_property='.$get_prperty_type_cus;
          httpGet($url_base_mdu_sessions);
          /* Call Session API */


          $msg_edit = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
          <strong>".$message_functions->showMessage('service_pro_update_success','2002')."</strong></div>";

        }

          } else{
              $msg_edit= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('service_pro_update_failed','2002')."</strong></div>";
          }
                
      }
      
      /*else{
        $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('service_pro_update_failed','2002')."</strong></div>";
      }
      

    }*/ else{
        $msg_edit= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('transaction_failed','2002')." </strong></div>";
    }
}











else if($_GET['action']=='sync_data'){//8

//include 'src/AAA/<network name>/index.php';
   /*  $admin_type=$db->getValueAsf("SELECT o.property_type AS f FROM mdu_system_user_organizations uo JOIN mdu_organizations o ON o.property_id=uo.property_id
WHERE uo.user_name='$user_name' LIMIT 1");


    $network_profile = $db->setValDistributor('NETWORK_NAME', $admin_type);
    if (strlen($network_profile) > 0) {
        require_once 'src/AAA/' . $network_profile . '/index.php';
        $nf = new network_functions();
    } else {
        $nf = null;
    } */


  $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
  $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");


if (strlen($network_profile) > 0) {
  require_once 'src/AAA/' . $network_profile . '/index.php';
  $nf = new network_functions($vt_pro,'');
} else {
  $nf = null;
}


    $search_id_up = mt_rand(1,100000).time();
  $updated = 0; 
  
  // echo $key_query = "SELECT o.property_number,o.property_id,o.validity_time,ignore_on_search
  // FROM mdu_organizations o, mdu_system_user_organizations u
  // WHERE o.property_number = u.property_id AND u.user_name = '$user_name'";
  
  // $query_results=mysql_query($key_query);
   $group=$nf->network('api_acc_profile');

  $query_results = $db->get_property($user_distributor);
  $mas_accu_up_cou = 0;
  while($row=mysql_fetch_array($query_results)){
    
  //$property_id_a = $row['property_id'];
  $property_id_a = $row['property_number'];
  $property_id_b = $row['validity_time'];
  $property_id_c = $row['ignore_on_search'];
 
  if($property_id_c == 1){
       $Response1 = $nf->findUsers("Group", $group,$property_id_a);
     
    }else{
        $Response1 = $nf->findMasterUsers("Group", $group,"Validity-Time",$property_id_b);
        //print_r($Response1);
  }
  //echo $network_profile['Service-Profiles'];
    
         
         
        $updated = $customerOb->syncCustomer($Response1,$search_id_up,$property_id_a);
        $updated = $updated['master_acc'];
        $mas_accu_up_cou+=count($updated);
        $decoded=json_decode($Response1,true);
        if($decoded['status']='success'){
            $sync_del_q = "DELETE FROM mdu_vetenant WHERE property_id ='$property_id_a' AND search_id<>'$search_id_up'";
            mysql_query($sync_del_q);
        }

    }
  
  // $query_search_results = "SELECT * FROM `mdu_vetenant` WHERE search_id = '$search_id_up'";
//  $query_results=mysql_query($query_search_results);
//  $result_count = mysql_num_rows($query_results);

  if($mas_accu_up_cou > 0){
    $msg_sync= "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
           <strong>".$message_functions->showNameMessage('tenant_acc_sync_success',$mas_accu_up_cou)."</strong></div>";
  }else{
    $msg_sync= "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('tenant_acc_sync_failed','2004')."</strong></div>";
  
  } 

}//9





//
elseif(isset($_GET['searchid'])){//8
  
  ////Go BACK Link/////
  $search_id=$_GET['searchid'];
  $record_found=1;
  $mg_customer_id='';
  
  
}//8                


  


///////////////////////////////////////////////GET Customer INFO//////////////////////////////////////////////
 $qq_156 = "SELECT c.duration, c.profile_type, c.service_profile, c.vlan_id, c.`first_name`,c.`last_name`,c.`email`,c.username,c.`password`,c.room_apt_no,c.`property_id`,o.`org_name`,c.`question_id`,c.`answer`,c.company_name,c.address,c.city,c.state,c.postal_code,c.country,c.phone,o.property_type
FROM `mdu_vetenant` c,`mdu_organizations` o WHERE c.`property_id`=o.`property_number` AND c.`customer_id`='$mg_customer_id' LIMIT 1";
$get_cust_info=mysql_query($qq_156);

if(mysql_num_rows($get_cust_info)>0){
   $rowc=mysql_fetch_array($get_cust_info);
   $mg_first_name=$rowc['first_name'];
   $mg_last_name=$rowc['last_name'];
   $mg_email=$rowc['email'];
   $mg_username=$rowc['username'];
   $mg_password=$rowc['password'];
   $mg_property_id=$rowc['property_id'];
   $mg_property_type=$rowc['property_type'];
   $mg_org_name=$rowc['org_name'];
   $mg_answer=$rowc['answer'];
   $mg_question_id=$rowc['question_id'];
   $mg_room_apt_no=$rowc['room_apt_no'];
   
   $mg_company_name=$rowc['company_name'];
   $mg_address=$rowc['address'];
   $mg_city=$rowc['city'];
   $mg_state=$rowc['state'];
   $mg_postal_code=$rowc['postal_code'];
   $mg_country=$rowc['country'];
   $mg_phone=$rowc['phone'];
   $vlan_id_details =$rowc['vlan_id'];
   $get_profile_type =$rowc['profile_type'];
   $duration_details =$rowc['duration'];
   $service_profile_details =$rowc['service_profile'];
   
}

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

if(isset($_POST['search_btn_session'])){
  $search_btn_session = true;  
  $vanue_id = $_POST['vanue_id'];
}elseif(isset($_GET['search_btn_session'])) {
$search_btn_session = true;
$vanue_id = $_GET['vanue_id'];
}else{
  $search_btn_session = false;  
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($search_btn_session){
  $property=$_POST['property_id_session'];
  $search_word=$_POST['search_word'];
  $string_type=checkFormat($search_word);
  $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
  $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");
  //print_r($mno_package);
  if (strlen($network_profile) > 0) {
  require_once 'src/AAA/' . $network_profile . '/index.php';
  $nf = new network_functions($vt_pro,'');
  } else {
  $nf = null;
  }
$group=$nf->network('api_acc_profile');

  $query_results = $db->get_property($user_distributor);
  while($row=mysql_fetch_array($query_results)){
  $property_id_a = $row['property_id'];
 
  $Responseacc = $nf->findUsers("Group", $group,$property_id_a);
  $accdata=syncCustomeracc($Responseacc,$property_id_a);
  //print_r($accdata);
  
  }


if(strlen($search_word)>0){

  if ($string_type=='mac') {
    $mac = getMac($search_word);
    $Response = $nf->getSessions($mac,'User-Name');
    $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);
    # code...
  }
  elseif ($string_type=='email') {
    
    $Response = $nf->getSessions($search_word,'AAA-User-Name');
    $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);
    # code...
  }
  elseif ($string_type=='ip') {
    
    $Response = $nf->getSessions($search_word,'Session-IP');
    $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);
    # code...
  }
  elseif ($string_type=='name') {
    //$mac = getMac($search_word);
    $user_prop_list = $db->get_property($user_distributor);

    while($row_prop=mysql_fetch_assoc($user_prop_list)){
    $property_id = $row_prop[property_id];
}
    $Response = $nf->getSessions($property_id,'Access-Group');

    $newarray=syncCustomerNew($Response,$property_id,$accdata);
    $newarray1=$newarray[0];

    $res_array=array();
    foreach ($newarray1 as $value){
          if($value['F-Name']==$search_word || $value['L-Name']==$search_word){
                array_push($res_array, $value);
                break;
      }
    }
    
    // $Responseacc1 = $nf->findMasterUsers("Group", $property_id, "PAS-First-Name", $search_word);
    // $Responseacc2 = $nf->findMasterUsers("Group", $property_id, "PAS-Last-Name", $search_word);
    /*if (!empty($newarray1)) {
                                            $res_arrr6=array();
                                            $res_arrr4=array();
                                            $res_arrr5=array();
                foreach ($newarray1 as $value1) {
                                                //$user_name=$value1['AAA_User_Name'];
                                                $acc_first=$value1['F-Name'];
                                                $acc_last=$value1['L-Name'];
                                                array_push($res_arrr6, $value1);
                                                array_push($res_arrr4, $acc_first);
                                                array_push($res_arrr5, $acc_last);
                                            }
                

                                            
                $res_arr=array();
                if (in_array($search_word, $res_arrr4))
                     {
                      $account_user_name=$search_word;
                      $a=array_search($account_user_name,$res_arrr4,true);
                      $arraynew=$res_arrr6[$a];
                      array_push($res_arr, $arraynew);

                     }
                   
                if (in_array($search_word, $res_arrr5))
                     {
                      $account_user_name=$search_word;
                      $a=array_search($account_user_name,$res_arrr5,true);
                      $arraynew=$res_arrr6[$a];
                      array_push($res_arr, $arraynew);

                     }
                   }*/
    $newjsonvalue1=array($res_array,$newarray[1]);

   /* $Response1 = $nf->getSessions($search_word,'PAS-First-Name');
    $newjsonvalue1=syncCustomerNew($Response,$property_id,$accdata);

    $Response2 = $nf->getSessions($search_word,'PAS-Last-Name');
    $newjsonvalue2=syncCustomerNew($Response,$property_id,$accdata);*/

    $Response3 = $nf->getSessions($search_word,'AAA-User-Name');
    $newjsonvalue3=syncCustomerNew($Response3,$property_id,$accdata);

    $newarray2=array_merge($newjsonvalue1[0],$newjsonvalue3[0]);
    $newarray3=array_merge($newjsonvalue1[1],$newjsonvalue3[1]);

    $resultArray = uniqueAssocArray($newarray2, 'Mac', 'AAA_User_Name');

    $newjsonvalue = array($resultArray,$newarray3);
    # code...
  }
  else{
    if ($property='ALL'){
    $user_prop_list = $db->get_property($user_distributor);
    /*$user_prop_list=mysql_query("SELECT property_id FROM mdu_system_user_organizations WHERE `user_name` = '$user_name'");*/

    while($row_prop=mysql_fetch_assoc($user_prop_list)){
      
                            //update customers*********
    $property_id = $row_prop[property_id];

  $Response = $nf->getSessions($property_id,'Access-Group');

  $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);
}

  }

  else{
  $property_id=$_POST['property_id_session'];

   $Response = $nf->getSessions($property_id,'Access-Group');

  $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);

  }

  }
  

}

else{
  if ($property='ALL'){
    $user_prop_list = $db->get_property($user_distributor);
    /*$user_prop_list=mysql_query("SELECT property_id FROM mdu_system_user_organizations WHERE `user_name` = '$user_name'");*/
    $res_arr2=array();
    $res_arr1=array();
    while($row_prop=mysql_fetch_assoc($user_prop_list)){
      
                            //update customers*********
    $property_id = $row_prop[property_id];

  $Response = $nf->getSessions($property_id,'Access-Group');

  $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);
}
// array_merge($res_arr1,$newjsonvalue1[0]);
// array_merge($res_arr2,$newjsonvalue1[1]);
// $newjsonvalue=array($res_arr1,$res_arr2);

  }
  else{
  $property_id=$_POST['property_id_session'];

   $Response = $nf->getSessions($property_id,'Access-Group');

  $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);

  }


}
  $record_found = 2;
  if (empty($newjsonvalue[0])) {
    $record_found=0;
      $val_msg="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button><strong>".$message_functions->showMessage('tenant_ses_acc_no_recod','2004')."</strong></div>";
   
    # code...
  }
    /*$record_found = 2;
    include_once 'classes/sessionClass.php';
    $session_function = new session_functions();
    $session_query = $session_function->GetSessions($_POST['property_id'],$_POST['search_word'],$user_name,'USER',$network_profile);*/

    //echo $session_query;

}
else{
  $record_found = 2;
  $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);
  $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");
  //print_r($mno_package);
  if (strlen($network_profile) > 0) {
  require_once 'src/AAA/' . $network_profile . '/index.php';
  $nf = new network_functions($vt_pro,'');
  } else {
  $nf = null;
  }
if ($property='ALL'){
    $user_prop_list = $db->get_property($user_distributor);
    $user_prop_list=mysql_query("SELECT property_id FROM mdu_system_user_organizations WHERE `user_name` = '$user_name'");
    $res_arr2=array();
    $res_arr1=array();
    while($row_prop=mysql_fetch_assoc($user_prop_list)){
      
                            //update customers*********
    $property_id = $row_prop[property_id];

  $Response = $nf->getSessions($property_id,'Access-Group');

  $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);
}
/*array_merge($res_arr1,$newjsonvalue1[0]);
array_merge($res_arr2,$newjsonvalue1[1]);
$newjsonvalue=array($res_arr1,$res_arr2);*/

  }
  else{
  $property_id=$_POST['property_id'];

   $Response = $nf->getSessions($property_id,'Access-Group');

  $newjsonvalue=syncCustomerNew($Response,$property_id,$accdata);

  }
 

}



// --------------------Delete Sessions ----------------------------------
    if(isset($_GET['dl_id'])){
      $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE',$system_package);

 
      $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");
    
    
    if (strlen($network_profile) > 0) {
      require_once 'src/AAA/' . $network_profile . '/index.php';
      $nf = new network_functions($vt_pro,'');
    } else {
      $nf = null;
    }
      //echo '4444';
      
        $form_secreat3=$_GET['s3'];
        $search_id=$_GET['search_id'];
        $quary_type=$_GET['query_type'];
        if($form_secreat3==$_SESSION['FORM_SECRET_SES']){
            $dl_ses_id=$_GET['dl_id'];
       $uni_mac=$_GET['uni_mac'];
       $uni_realm=$_GET['realm'];
            $record_found=2;
            /* Call Session API*/

            $mac_address = $uni_mac.'@'.$uni_realm;

            //$uni_customer = $db->getValueAsf("SELECT user_name AS f FROM mdu_customer_devices WHERE mac_address='$mac_address'");
     
            /*$url_all_mdu_sessions = $base_url.'/ajax/disconnect_account_sessions.php?account_place=group_admin_individual_session_delete&account_user_name='.$uni_mac.'&customer_id='.$uni_customer.'&account_property='.$us_property_type;
            $response_session_disconnect = httpGet($url_all_mdu_sessions);*/

            $Response = $nf->disconnectUserSessions($quary_type,$mac_address);
            

            parse_str($Response,$res_array);
            //echo $se_disc_status;
           // print_r($res_array);

           $se_disc_status =  $res_array['status_code'];
            $se_disc_desc = $res_array['status'];

            /* Call Session API */


            if($se_disc_status == '200' || $se_disc_desc == 'SUCCESS' ){
                $dl_msg="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>
                                                    <strong>".$message_functions->showMessage('session_delete_success','2003')." </strong></div>";

            }
            else{
                $dl_msg="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button>
                                                    <strong>".$message_functions->showMessage('session_delete_failed','2003')." </strong></div>";
            }

        }else{
            $dl_msg="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button>
                                                    <strong>".$message_functions->showMessage('tenant_acc_sync_failed','2004')."</strong></div>";
        }
 
   }
    ?>

<body>
<div class="main">
    <div class="main-inner">
      <div class="container">
        <div class="row">
          <div class="span12">
            <div class="widget ">
             <!--  <div class="widget-header">
                               
                <h3>Add New Tenant Account</h3>
              </div> -->
              <!-- /widget-header -->

              <div class="widget-content" id="now">

                <div class="tabbable">
                  <ul class="nav nav-tabs">
                    <li <?php if($active_tab=="account"){echo "class=\"active\"";}?>><a href="#account" data-toggle="tab">Manage Tenants</a></li>
                    <li <?php if($active_tab == "session"){echo" class=\"active\"";}?>><a href="#session" data-toggle="tab">Sessions</a></li>

                    <!-- <li class="active"><a href="#account" data-toggle="tab">Account Details</a></li>
                    <li ><a href="#de_session" data-toggle="tab">Session</a></li> -->
                  </ul>
                  <br>





                  <div class="tab-content">


                    <?php 

                    echo $val_msg;
                     ?>

                                            <!-- ******************* tenant details ******************* -->
                      <div class="tab-pane <?php if($active_tab=="account"){echo"active";}?>" id="account">
                  




 <?php 
                   
                   $secret=md5(uniqid(rand(), true));
                   $_SESSION['FORM_SECRET'] = $secret;
                          
                  ?> 
                           
          
          <?php
         if(isset($msg_sync)){
           echo $msg_sync;
           $msg_sync='';
           }
          if(isset($_SESSION['msg'])){
                                 echo $_SESSION['msg'];
                                 unset($_SESSION['msg']);
                                 
                                 }
          ?>                                 
                           
                           
                           
         <?php if(isset($manage_customer_enable)){ //show manage customer area ?>  
         
         
         
         <?php
         if(isset($msg_edit)){
           echo $msg_edit;
           $msg_edit='';
           }
         
          ?>
         
         

                           
          <div class="">
         
          <div align="left" style="vertical-align:top;"><a href="manage_tenant.php?searchid=<?php echo $search_id;?>" class="btn btn-info btn-small btn-info-iefix" style="text-decoration:none"><i class="icon-white icon-chevron-left"></i> Go Back</a></div>
         
        <div align="center" style="vertical-align:top;">
         <h1 class="head" style="margin-top: 20px;padding-bottom: 15px;"><strong>Manage Tenants</strong></h2>
         </div>
         </div>
         <br>
         <br>
             <div class="span11a">
             
             <!-- /widget -->
             
             <!-- /widget -->
             <div class="widget">
              
               <!-- /widget-header -->
               <div class="widget-content">
               
               <form id="edit_customer_form" name="edit_customer_form?tab=account" action="manage_tenant.php" method="post"  class="form-horizontal" enctype="multipart/form-data" onchange="customer_submitenable()">
                         
                           <?php
         
                         echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" /><input type="hidden" name="search_id" id="search_id" value="'.$search_id.'" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="'.$mg_customer_id.'" />';
                                 
                         ?>
                         
                           <fieldset class="add_field">

                            <div class="control-group">
         
                                     <div class="controls form-group">

                             <div class="columns">
                                <h3><strong>Tenant Account Details</strong></h3>
                              </div>

                            </div>

                          </div>
         
                           
                             <div id="response_d1"></div>
                           
                                   <?php if($mg_property_type != 'MDU') { ?>
                                   
                                   <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">VLAN ID</label>
         
                                         <input class="span4 form-control" id="vlan_id_details" name="vlan_id_details" type="text" style="width:70%;"  value="<?php echo $vlan_id_details; ?>" readonly>
                                         
                                     
                                     </div>
                                   </div>
                                   
                                   <?php  } ?>
         
                             
                                  
         
                                   <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">First Name<sup><font color="#FF0000" >*</font></sup></label>
         
                                         <input class="span4 form-control" id="first_name" placeholder="Kim" name="first_name" type="text" style="display: block; width:70%;" value="<?php echo $mg_first_name; ?>">
                                         <script type="text/javascript">
                                           $("#first_name").keypress(function(event){
                                             var ew = event.which;
                                             //if(ew == 32)
         //                                     return true;
         //                                   if(48 <= ew && ew <= 57)
         //                                     return true;
                                             if(65 <= ew && ew <= 90)
                                               return true;
                                             if(97 <= ew && ew <= 122)
                                               return true;
                                             return false;
                                           });
                                           
                                           
                                           $('#first_name').bind("cut copy paste",function(e) {
                                               e.preventDefault();
                                              });
         
                                         </script>
                                       </div>
                                     
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->
         
         
         
                                   
                                   
                                   
                                   <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">Last Name<sup><font color="#FF0000" >*</font></sup></label>
         
                                         <input class="span4 form-control" id="last_name" placeholder="John" name="last_name" type="text" style="display: block;width:70%;" value="<?php echo $mg_last_name; ?>">
                                         <script type="text/javascript">
                                           $("#last_name").keypress(function(event){
                                             var ew = event.which;
                                             //if(ew == 32)
         //                                     return true;
         //                                   if(48 <= ew && ew <= 57)
         //                                     return true;
                                             if(65 <= ew && ew <= 90)
                                               return true;
                                             if(97 <= ew && ew <= 122)
                                               return true;
                                             return false;
                                           });
                                           
                                             $('#last_name').bind("cut copy paste",function(e) {
                                               e.preventDefault();
                                              });
                                         </script>
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->
                                   
                                   
                                   
                                   
                                                             
                                   
         
                                 <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">Email<sup><font color="#FF0000" >*</font></sup></label>
         
                                         <input class="span4 form-control" id="email" name="email" type="email" style="display: block;width:70%;"  value="<?php echo $mg_email; ?>" readonly >
                                         
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->                          
                                   
         
                                   
                                   
                                   
                                   
                                   <div class="control-group">
         
                                     <div class="controls form-group" style="position: relative;">
                                       
                                     <label class="" for="radiobtns">New Password<sup><font color="#FF0000" ></font></sup></label>
         
                                         <input class="span4 form-control pass_msg" id="password" placeholder="******" name="password" type="password" style="display: inline;width:70%;" onfocus="validatePass(document.getElementById('confirm_password'), this);" oninput="validatePass(document.getElementById('confirm_password'), this);"  value="" >
                                         <i toggle="#password" style="display:inline !important;margin-left: -25px; " class="paas_toogle btn-icon-only icon-eye-open toggle-password" id="n_pass"></i>

<script type="text/javascript">
                                         $(".toggle-password").click(function() {

$(this).toggleClass("icon-eye-close");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

</script> 
                                         <!-- <script type="text/javascript">
                                           $("#password").keypress(function(event){
                                             var ew = event.which;
                                             
                                             if(ew == 32)
                                               return true;
                                             if(48 <= ew && ew <= 57)
                                               return true;
                                             if(65 <= ew && ew <= 90)
                                               return true;
                                             if(97 <= ew && ew <= 122)
                                               return true;
                                             return false;
                                           });
                                         </script> -->
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->                          
                                   
         
         
         
                            <div class="control-group">
         
                                     <div class="controls form-group" style="position: relative;">
                                       
                               <label class="" for="radiobtns">Re-enter Password<sup><font color="#FF0000" ></font></sup></label>
         
                                       <input class="span4 form-control pass_msg" id="confirm_password" placeholder="******" name="confirm_password" type="password" onfocus="validatePass(document.getElementById('password'), this);" oninput="validatePass(document.getElementById('password'), this);"  value="" style="display: inline; width:70%;">
                                       <i toggle="#confirm_password" style="display:inline !important;margin-left: -25px; " class="paas_toogle btn-icon-only icon-eye-open com_toggle-password" id="n_pass"></i>

<script type="text/javascript">
                                         $(".com_toggle-password").click(function() {

$(this).toggleClass("icon-eye-close");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

</script> 
                                         <!-- <script type="text/javascript">
                                           $("#confirm_password").keypress(function(event){
                                             var ew = event.which;
                                             if(ew == 32)
                                               return true;
                                             if(48 <= ew && ew <= 57)
                                               return true;
                                             if(65 <= ew && ew <= 90)
                                               return true;
                                             if(97 <= ew && ew <= 122)
                                               return true;
                                             return false;
                                           });
                                         </script> -->
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->  
                                   
                                   
                                   
                                 <div class="control-group">
         
                                     <div class="controls form-group">
         
                                     <label class="" for="radiobtns">Property<sup><font color="#FF0000" >*</font></sup></label>

                                       <input class="span4 form-control" id="property_id" name="property_id" type="text" style="width:70%;"  value="<?php echo $mg_property_id; ?>" readonly >
         
         
         
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->
                                     
                                     
                                     
                                   <input id="room" name="room" type="hidden" value="<?php echo $mg_room_apt_no; ?>">
                                   <input id="comp_name" placeholder="" name="comp_name" type="hidden"  value="<?php echo $mg_company_name; ?>">
                                     
                                   
                                   
                                   <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">Street Address<sup><font color="#FF0000" >*</font></sup></label>
         
                                       <textarea name="street_address" id="street_address" cols="250" class="span4 form-control" style="display: block;width:70%;"><?php echo $mg_address; ?></textarea>
                                         <script type="text/javascript">
                                           $("#street_address").keypress(function(event){
                                             var ew = event.which;
                                             //alert (ew);
                                             if(ew == 32 || ew == 35  )
                                               return true;
                                             if(48 <= ew && ew <= 57)
                                               return true;
                                             if(65 <= ew && ew <= 90)
                                               return true;
                                             if(97 <= ew && ew <= 122)
                                               return true;
                                             return false;
                                           });
                                           $('#street_address').bind("cut copy paste",function(e) {
                                               e.preventDefault();
                                              });
                                         </script>
                                     
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->  
                              <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">Country<sup><font color="#FF0000" >*</font></sup></label>

                                     <select class="span4 form-control" name="country" id="country" style="display: block; width:72.5%;">
                <option value="">Select Country</option>
                                                    <?php
                                                    $count_results=mysql_query("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                                    UNION ALL
                                    SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");
                                                   while($row=mysql_fetch_array($count_results)){
                                                            if($row[a]==$mg_country || $row[a]== "US"){
                                                               $select="selected";
                                                            }else{
                                                                $select="";
                                                            }

                                                       echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';

                                                   }
                                                    ?>
                       </select>                              
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                <!-- /control-group --> 
          <script type="text/javascript">

// Countries
var country_arr = new Array( "United States of America","Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

// States
var s_a = new Array();
var s_a_val = new Array();
s_a[0] = "";
s_a_val[0] = "";
<?php

$get_regions=mysql_query("SELECT
        `states_code`,
        `description`
        FROM 
        `exp_country_states` ORDER BY description");

$s_a = '';
$s_a_val = '';

while($state=mysql_fetch_assoc($get_regions)){
$s_a .= $state['description'].'|';
$s_a_val .= $state['states_code'].'|';
}

$s_a = rtrim($s_a,"|");
$s_a_val = rtrim($s_a_val,"|");

?>
s_a[1] = "<?php echo $s_a; ?>";
s_a_val[1] = "<?php echo $s_a_val; ?>";
s_a[2] = "Others";
s_a[3] = "Others";
s_a[4] = "Others";
s_a[5] = "Others";
s_a[6] = "Others";
s_a[7] = "Others";
s_a[8] = "Others";
s_a[9] = "Others";
s_a[10] = "Others";
s_a[11] = "Others";
s_a[12] = "Others";
s_a[13] = "Others";
s_a[14] = "Others";
s_a[15] = "Others";
s_a[16] = "Others";
s_a[17] = "Others";
s_a[18] = "Others";
s_a[19] = "Others";
s_a[20] = "Others";
s_a[21] = "Others";
s_a[22] = "Others";
s_a[23] = "Others";
s_a[24] = "Others";
s_a[25] = "Others";
s_a[26] = "Others";
s_a[27] = "Others";
s_a[28] = "Others";
s_a[29] = "Others";
s_a[30] = "Others";
s_a[31] = "Others";
s_a[32] = "Others";
s_a[33] = "Others";
s_a[34] = "Others";
s_a[35] = "Others";
s_a[36] = "Others";
s_a[37] = "Others";
s_a[38] = "Others";
s_a[39] = "Others";
s_a[40] = "Others";
s_a[41] = "Others";
s_a[42] = "Others";
s_a[43] = "Others";
s_a[44] = "Others";
s_a[45] = "Others";
s_a[46] = "Others";
s_a[47] = "Others";
s_a[48] = "Others";
// <!-- -->
s_a[49] = "Others";
s_a[50] = "Others";
s_a[51] = "Others";
s_a[52] = "Others";
s_a[53] = "Others";
s_a[54] = "Others";
s_a[55] = "Others";
s_a[56] = "Others";
s_a[57] = "Others";
s_a[58] = "Others";
s_a[59] = "Others";
s_a[60] = "Others";
s_a[61] = "Others";
s_a[62] = "Others";
// <!-- -->
s_a[63] = "Others";
s_a[64] = "Others";
s_a[65] = "Others";
s_a[66] = "Others";
s_a[67] = "Others";
s_a[68] = "Others";
s_a[69] = "Others";
s_a[70] = "Others";
s_a[71] = "Others";
s_a[72] = "Others";
s_a[73] = "Others";
s_a[74] = "Others";
s_a[75] = "Others";
s_a[76] = "Others";
s_a[77] = "Others";
s_a[78] = "Others";
s_a[79] = "Others";
s_a[80] = "Others";
s_a[81] = "Others";
s_a[82] = "Others";
s_a[83] = "Others";
s_a[84] = "Others";
s_a[85] = "Others";
s_a[86] = "Others";
s_a[87] = "Others";
s_a[88] = "Others";
s_a[89] = "Others";
s_a[90] = "Others";
s_a[91] = "Others";
s_a[92] = "Others";
s_a[93] = "Others";
s_a[94] = "Others";
s_a[95] = "Others";
s_a[96] = "Others";
s_a[97] = "Others";
s_a[98] = "Others";
s_a[99] = "Others";
s_a[100] = "Others";
s_a[101] = "Others";
s_a[102] = "Others";
s_a[103] = "Others";
s_a[104] = "Others";
s_a[105] = "Others";
s_a[106] = "Others";
s_a[107] = "Others";
s_a[108] = "Others";
s_a[109] = "Others";
s_a[110] = "Others";
s_a[111] = "Others";
s_a[112] = "Others";
s_a[113] = "Others";
s_a[114] = "Others";
s_a[115] = "Others";
s_a[116] = "Others";
s_a[117] = "Others";
s_a[118] = "Others";
s_a[119] = "Others";
s_a[120] = "Others";
s_a[121] = "Others";
s_a[122] = "Others";
s_a[123] = "Others";
s_a[124] = "Others";
s_a[125] = "Others";
s_a[126] = "Others";
s_a[127] = "Others";
s_a[128] = "Others";
s_a[129] = "Others";
s_a[130] = "Others";
s_a[131] = "Others";
s_a[132] = "Others";
s_a[133] = "Others";
s_a[134] = "Others";
s_a[135] = "Others";
s_a[136] = "Others";
s_a[137] = "Others";
s_a[138] = "Others";
s_a[139] = "Others";
s_a[140] = "Others";
s_a[141] = "Others";
s_a[142] = "Others";
s_a[143] = "Others";
s_a[144] = "Others";
s_a[145] = "Others";
s_a[146] = "Others";
s_a[147] = "Others";
s_a[148] = "Others";
s_a[149] = "Others";
s_a[150] = "Others";
s_a[151] = "Others";
s_a[152] = "Others";
s_a[153] = "Others";
s_a[154] = "Others";
s_a[155] = "Others";
s_a[156] = "Others";
s_a[157] = "Others";
s_a[158] = "Others";
s_a[159] = "Others";
s_a[160] = "Others";
s_a[161] = "Others";
s_a[162] = "Others";
s_a[163] = "Others";
s_a[164] = "Others";
s_a[165] = "Others";
s_a[166] = "Others";
s_a[167] = "Others";
s_a[168] = "Others";
s_a[169] = "Others";
s_a[170] = "Others";
s_a[171] = "Others";
s_a[172] = "Others";
s_a[173] = "Others";
s_a[174] = "Others";
s_a[175] = "Others";
s_a[176] = "Others";
s_a[177] = "Others";
s_a[178] = "Others";
s_a[179] = "Others";
s_a[180] = "Others";
s_a[181] = "Others";
s_a[182] = "Others";
s_a[183] = "Others";
s_a[184] = "Others";
s_a[185] = "Others";
s_a[186] = "Others";
s_a[187] = "Others";
s_a[188] = "Others";
s_a[189] = "Others";
s_a[190] = "Others";
s_a[191] = "Others";
s_a[192] = "Others";
s_a[193] = "Others";
s_a[194] = "Others";
s_a[195] = "Others";
s_a[196] = "Others";
s_a[197] = "Others";
s_a[198] = "Others";
s_a[199] = "Others";
s_a[200] = "Others";
s_a[201] = "Others";
s_a[202] = "Others";
s_a[203] = "Others";
s_a[204] = "Others";
s_a[205] = "Others";
s_a[206] = "Others";
s_a[207] = "Others";
s_a[208] = "Others";
s_a[209] = "Others";
s_a[210] = "Others";
s_a[211] = "Others";
s_a[212] = "Others";
s_a[213] = "Others";
s_a[214] = "Others";
s_a[215] = "Others";
s_a[216] = "Others";
s_a[217] = "Others";
s_a[218] = "Others";
s_a[219] = "Others";
s_a[220] = "Others";
s_a[221] = "Others";
s_a[222] = "Others";
s_a[223] = "Others";
s_a[224] = "Others";
s_a[225] = "Others";
s_a[226] = "Others";
s_a[227] = "Others";
s_a[228] = "Others";
s_a[229] = "Others";
s_a[230] = "Others";
s_a[231] = "Others";
s_a[232] = "Others";
s_a[233] = "Others";
s_a[234] = "Others";
s_a[235] = "Others";
s_a[236] = "Others";
s_a[237] = "Others";
s_a[238] = "Others";
s_a[239] = "Others";
s_a[240] = "Others";
s_a[241] = "Others";
s_a[242] = "Others";
s_a[243] = "Others";
s_a[244] = "Others";
s_a[245] = "Others";
s_a[246] = "Others";
s_a[247] = "Others";
s_a[248] = "Others";
s_a[249] = "Others";
s_a[250] = "Others";
s_a[251] = "Others";
s_a[252] = "Others";


s_a_val[2] = "N/A";
s_a_val[3] = "N/A";
s_a_val[4] = "N/A";
s_a_val[5] = "N/A";
s_a_val[6] = "N/A";
s_a_val[7] = "N/A";
s_a_val[8] = "N/A";
s_a_val[9] = "N/A";
s_a_val[10] = "N/A";
s_a_val[11] = "N/A";
s_a_val[12] = "N/A";
s_a_val[13] = "N/A";
s_a_val[14] = "N/A";
s_a_val[15] = "N/A";
s_a_val[16] = "N/A";
s_a_val[17] = "N/A";
s_a_val[18] = "N/A";
s_a_val[19] = "N/A";
s_a_val[20] = "N/A";
s_a_val[21] = "N/A";
s_a_val[22] = "N/A";
s_a_val[23] = "N/A";
s_a_val[24] = "N/A";
s_a_val[25] = "N/A";
s_a_val[26] = "N/A";
s_a_val[27] = "N/A";
s_a_val[28] = "N/A";
s_a_val[29] = "N/A";
s_a_val[30] = "N/A";
s_a_val[31] = "N/A";
s_a_val[32] = "N/A";
s_a_val[33] = "N/A";
s_a_val[34] = "N/A";
s_a_val[35] = "N/A";
s_a_val[36] = "N/A";
s_a_val[37] = "N/A";
s_a_val[38] = "N/A";
s_a_val[39] = "N/A";
s_a_val[40] = "N/A";
s_a_val[41] = "N/A";
s_a_val[42] = "N/A";
s_a_val[43] = "N/A";
s_a_val[44] = "N/A";
s_a_val[45] = "N/A";
s_a_val[46] = "N/A";
s_a_val[47] = "N/A";
s_a_val[48] = "N/A";
// <!-- -->
s_a_val[49] = "N/A";
s_a_val[50] = "N/A";
s_a_val[51] = "N/A";
s_a_val[52] = "N/A";
s_a_val[53] = "N/A";
s_a_val[54] = "N/A";
s_a_val[55] = "N/A";
s_a_val[56] = "N/A";
s_a_val[57] = "N/A";
s_a_val[58] = "N/A";
s_a_val[59] = "N/A";
s_a_val[60] = "N/A";
s_a_val[61] = "N/A";
s_a_val[62] = "N/A";
// <!-- -->
s_a_val[63] = "N/A";
s_a_val[64] = "N/A";
s_a_val[65] = "N/A";
s_a_val[66] = "N/A";
s_a_val[67] = "N/A";
s_a_val[68] = "N/A";
s_a_val[69] = "N/A";
s_a_val[70] = "N/A";
s_a_val[71] = "N/A";
s_a_val[72] = "N/A";
s_a_val[73] = "N/A";
s_a_val[74] = "N/A";
s_a_val[75] = "N/A";
s_a_val[76] = "N/A";
s_a_val[77] = "N/A";
s_a_val[78] = "N/A";
s_a_val[79] = "N/A";
s_a_val[80] = "N/A";
s_a_val[81] = "N/A";
s_a_val[82] = "N/A";
s_a_val[83] = "N/A";
s_a_val[84] = "N/A";
s_a_val[85] = "N/A";
s_a_val[86] = "N/A";
s_a_val[87] = "N/A";
s_a_val[88] = "N/A";
s_a_val[89] = "N/A";
s_a_val[90] = "N/A";
s_a_val[91] = "N/A";
s_a_val[92] = "N/A";
s_a_val[93] = "N/A";
s_a_val[94] = "N/A";
s_a_val[95] = "N/A";
s_a_val[96] = "N/A";
s_a_val[97] = "N/A";
s_a_val[98] = "N/A";
s_a_val[99] = "N/A";
s_a_val[100] = "N/A";
s_a_val[101] = "N/A";
s_a_val[102] = "N/A";
s_a_val[103] = "N/A";
s_a_val[104] = "N/A";
s_a_val[105] = "N/A";
s_a_val[106] = "N/A";
s_a_val[107] = "N/A";
s_a_val[108] = "N/A";
s_a_val[109] = "N/A";
s_a_val[110] = "N/A";
s_a_val[111] = "N/A";
s_a_val[112] = "N/A";
s_a_val[113] = "N/A";
s_a_val[114] = "N/A";
s_a_val[115] = "N/A";
s_a_val[116] = "N/A";
s_a_val[117] = "N/A";
s_a_val[118] = "N/A";
s_a_val[119] = "N/A";
s_a_val[120] = "N/A";
s_a_val[121] = "N/A";
s_a_val[122] = "N/A";
s_a_val[123] = "N/A";
s_a_val[124] = "N/A";
s_a_val[125] = "N/A";
s_a_val[126] = "N/A";
s_a_val[127] = "N/A";
s_a_val[128] = "N/A";
s_a_val[129] = "N/A";
s_a_val[130] = "N/A";
s_a_val[131] = "N/A";
s_a_val[132] = "N/A";
s_a_val[133] = "N/A";
s_a_val[134] = "N/A";
s_a_val[135] = "N/A";
s_a_val[136] = "N/A";
s_a_val[137] = "N/A";
s_a_val[138] = "N/A";
s_a_val[139] = "N/A";
s_a_val[140] = "N/A";
s_a_val[141] = "N/A";
s_a_val[142] = "N/A";
s_a_val[143] = "N/A";
s_a_val[144] = "N/A";
s_a_val[145] = "N/A";
s_a_val[146] = "N/A";
s_a_val[147] = "N/A";
s_a_val[148] = "N/A";
s_a_val[149] = "N/A";
s_a_val[150] = "N/A";
s_a_val[151] = "N/A";
s_a_val[152] = "N/A";
s_a_val[153] = "N/A";
s_a_val[154] = "N/A";
s_a_val[155] = "N/A";
s_a_val[156] = "N/A";
s_a_val[157] = "N/A";
s_a_val[158] = "N/A";
s_a_val[159] = "N/A";
s_a_val[160] = "N/A";
s_a_val[161] = "N/A";
s_a_val[162] = "N/A";
s_a_val[163] = "N/A";
s_a_val[164] = "N/A";
s_a_val[165] = "N/A";
s_a_val[166] = "N/A";
s_a_val[167] = "N/A";
s_a_val[168] = "N/A";
s_a_val[169] = "N/A";
s_a_val[170] = "N/A";
s_a_val[171] = "N/A";
s_a_val[172] = "N/A";
s_a_val[173] = "N/A";
s_a_val[174] = "N/A";
s_a_val[175] = "N/A";
s_a_val[176] = "N/A";
s_a_val[177] = "N/A";
s_a_val[178] = "N/A";
s_a_val[179] = "N/A";
s_a_val[180] = "N/A";
s_a_val[181] = "N/A";
s_a_val[182] = "N/A";
s_a_val[183] = "N/A";
s_a_val[184] = "N/A";
s_a_val[185] = "N/A";
s_a_val[186] = "N/A";
s_a_val[187] = "N/A";
s_a_val[188] = "N/A";
s_a_val[189] = "N/A";
s_a_val[190] = "N/A";
s_a_val[191] = "N/A";
s_a_val[192] = "N/A";
s_a_val[193] = "N/A";
s_a_val[194] = "N/A";
s_a_val[195] = "N/A";
s_a_val[196] = "N/A";
s_a_val[197] = "N/A";
s_a_val[198] = "N/A";
s_a_val[199] = "N/A";
s_a_val[200] = "N/A";
s_a_val[201] = "N/A";
s_a_val[202] = "N/A";
s_a_val[203] = "N/A";
s_a_val[204] = "N/A";
s_a_val[205] = "N/A";
s_a_val[206] = "N/A";
s_a_val[207] = "N/A";
s_a_val[208] = "N/A";
s_a_val[209] = "N/A";
s_a_val[210] = "N/A";
s_a_val[211] = "N/A";
s_a_val[212] = "N/A";
s_a_val[213] = "N/A";
s_a_val[214] = "N/A";
s_a_val[215] = "N/A";
s_a_val[216] = "N/A";
s_a_val[217] = "N/A";
s_a_val[218] = "N/A";
s_a_val[219] = "N/A";
s_a_val[220] = "N/A";
s_a_val[221] = "N/A";
s_a_val[222] = "N/A";
s_a_val[223] = "N/A";
s_a_val[224] = "N/A";
s_a_val[225] = "N/A";
s_a_val[226] = "N/A";
s_a_val[227] = "N/A";
s_a_val[228] = "N/A";
s_a_val[229] = "N/A";
s_a_val[230] = "N/A";
s_a_val[231] = "N/A";
s_a_val[232] = "N/A";
s_a_val[233] = "N/A";
s_a_val[234] = "N/A";
s_a_val[235] = "N/A";
s_a_val[236] = "N/A";
s_a_val[237] = "N/A";
s_a_val[238] = "N/A";
s_a_val[239] = "N/A";
s_a_val[240] = "N/A";
s_a_val[241] = "N/A";
s_a_val[242] = "N/A";
s_a_val[243] = "N/A";
s_a_val[244] = "N/A";
s_a_val[245] = "N/A";
s_a_val[246] = "N/A";
s_a_val[247] = "N/A";
s_a_val[248] = "N/A";
s_a_val[249] = "N/A";
s_a_val[250] = "N/A";
s_a_val[251] = "N/A";
s_a_val[252] = "N/A";

function populateStates(countryElementId, stateElementId) {

var selectedCountryIndex = document.getElementById(countryElementId).selectedIndex;


var stateElement = document.getElementById(stateElementId);

stateElement.length = 0; // Fixed by Julian Woods
stateElement.options[0] = new Option('Select State', '');
stateElement.selectedIndex = 0;

var state_arr = s_a[selectedCountryIndex].split("|");
var state_arr_val = s_a_val[selectedCountryIndex].split("|");

if(selectedCountryIndex != 0){
for (var i = 0; i < state_arr.length; i++) {
stateElement.options[stateElement.length] = new Option(state_arr[i], state_arr_val[i]);
}
}

}

function populateCountries(countryElementId, stateElementId) {

var countryElement = document.getElementById(countryElementId);

if (stateElementId) {
countryElement.onchange = function () {
populateStates(countryElementId, stateElementId);
};
}
}

</script>

<script language="javascript">
populateCountries("country", "state");
// populateCountries("country");
</script>



                                  
        
        <div class="control-group">

            <div class="controls form-group">
              
            <label class="" for="radiobtns">State/Province<sup><font color="#FF0000" >*</font></sup></label>

                <select class="span4 form-control" id="state" name="state" style="display: block; width:72.5%;">
                <?php

$get_regions=mysql_query("SELECT
 `states_code`,
 `description`
FROM
`exp_country_states` ORDER BY description ASC");

echo '<option value="">Select State</option>';

while($state=mysql_fetch_assoc($get_regions)){
   //edit_state_region , get_edit_mno_state_region
   if($mg_state==$state['states_code']) {

     echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
   }else{

     echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
   }
}
//echo '<option value="other">Other</option>';


?>
                 </select>
                
              
            </div>
            <!-- /controls -->
          </div>
          <!-- /control-group --> 
             
             <script language="javascript">
              // populateCountries("country", "state");
              // populateCountries("country");
             </script>                        
                                     
                                   
         
         
         <script type="text/javascript">
         
    
         
           $( document ).ready(function() {
         
            // setTimeout(function(){ document.getElementById('country').value = '<?php echo $mg_country; ?>'; }, 1000);
            // setTimeout(function(){ populateStates("country", "state"); }, 1000);
            // setTimeout(function(){ document.getElementById('state').value = '<?php echo $mg_state; ?>'; }, 1000);
             
             
         
           });
         
         /* 
         
         $("#country").on('change',function(){
         
           var e = $("#country").val();
         
         
           if(e=='United States of America'){
         
             $("#postal_code").attr('maxlength','5');
         
           }else{
         
             $("#postal_code").attr('maxlength','10');
             
             }
           
         });
          */
         
         
         
         </script>                                               
          
                                                           
                                 
                                 <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">Postal Code<sup><font color="#FF0000" >*</font></sup></label>
         
                                         <input class="span4 form-control" id="postal_code" placeholder="xxxxx" name="postal_code" type="text" value="<?php echo $mg_postal_code; ?>"  maxlength="5" oninvalid="setCustomValidity('Invalid Postal Code')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"  style="display: block; width:70%;">
                                         
                                     
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->  
                                   
                                   <script>
           $('#postal_code').on('keydown', function(e){
             if(e.keyCode < 48 && e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 39){
               e.preventDefault();
             }else {
               if(e.keyCode > 105){
                 e.preventDefault();
               }else{
                 if(e.keyCode < 96 && e.keyCode > 57){
                   e.preventDefault();
                 }else{
         
                 }
               }
             }
           });
           
           $('#postal_code').bind("cut copy paste",function(e) {
                                               e.preventDefault();
                                              });
         </script>
         
         <script type="text/javascript">
                                           $("#postal_code").keypress(function(event){
                                             var ew = event.which;
                                             if(ew == 32)
                                               return true;
                                             if(48 <= ew && ew <= 57)
                                               return true;
                                             if(65 <= ew && ew <= 90)
                                               return true;
                                             if(97 <= ew && ew <= 122)
                                               return true;
                                             return false;
                                           });
                         </script>
                                
             
            
                                    <div class="control-group">
         
                                     <div class="controls form-group">
                                     
                                     <label class="" for="radiobtns">City<sup><font color="#FF0000" >*</font></sup></label>
         
                                         <input class="span4 form-control" id="city" placeholder="" name="city" type="text" maxlength="64"  value="<?php echo $mg_city; ?>" style="display: block; width:70%;">
                                         <script type="text/javascript">
                                           //$("#city").keypress(function(event){
         //                                   var ew = event.which;
         //                                   //if(ew == 32)
         ////                                     return true;
         ////                                   if(48 <= ew && ew <= 57)
         ////                                     return true;
         //                                   if(65 <= ew && ew <= 90)
         //                                     return true;
         //                                   if(97 <= ew && ew <= 122)
         //                                     return true;
         //                                   return false;
         //                                 });
         
         $('#city').bind("cut copy paste",function(e) {
                                               e.preventDefault();
                                              });
                                         </script>
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->   
            
                                   
                                <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">Mobile Number</label>
         
                                         <input class="span4 form-control" id="phone" placeholder="xxx-xxx-xxxx" name="phone" type="text" maxlength="12" value="<?php echo $mg_phone; ?>" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" style="display: block; width:70%;">
                                         
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->                              
                                   
                                   
                                             <script type="text/javascript">
         
                             $(document).ready(function() {
         
                              $('#phone').focus(function(){
                                 $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                               });
                               
         
                               $('#phone').keyup(function(){
                                 $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                               });
                               
                               $("#phone").keypress(function(event){
                                         var ew = event.which;
                                         //alert(ew);
                                         if(ew == 8||ew == 0||ew == 46||ew == 45)
                                           return true;
                                         if(48 <= ew && ew <= 57)
                                           return true;
                                         return false;
                                       });
                               
                               $("#phone").keydown(function (e) {
         
         
                                 var mac = $('#phone').val();
                                 var len = mac.length + 1;
                                 //console.log(e.keyCode);
                                 //console.log('len '+ len);
         
                                 if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                   mac1 = mac.replace(/[^0-9]/g, '');
         
         
                                   //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);
         
                                   //console.log(valu);
                                   //$('#phone_num_val').val(valu);
         
                                 }
                                 else{
                                  return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);
         
                                   /*if(len == 4){
                                     $('#phone').val(function() {
                                       return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                       //console.log('mac1 ' + mac);
         
                                     });
                                   }
                                   else if(len == 8 ){
                                     $('#phone').val(function() {
                                       return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                       //console.log('mac2 ' + mac);
         
                                     });
                                   }*/
                                 }
         
         
                                 // Allow: backspace, delete, tab, escape, enter, '-' and .
                                 if ($.inArray(e.keyCode, [8, 9, 27, 13]) !== -1 ||
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
                                 if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                   e.preventDefault();
         
                                 }
                               });
         
         
                             });
                               
                               $('#phone').bind("cut copy paste",function(e) {
                                               e.preventDefault();
                                              });
                             </script>
                       
                                 
                                 
                                   
                               <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">Secret Question<sup><font color="#FF0000" >*</font></sup></label>

                                         <select name="question" id="question" class="span4 form-control" style="display: block; width:72.5%;">
                             
                                         <?php 
                                         echo $key_query = "SELECT `question_id` AS a, `secret_question` AS b FROM `mdu_secret_questions` WHERE is_enable=1 AND  `secret_question`='".$mg_question_id."'";
                         
                                         $query_results=mysql_query($key_query);
                                         while($row=mysql_fetch_array($query_results)){
                                           $a = $row['a'];
                                           $b = $row['b'];
                                           
                                           echo '<option value="'.$b.'">'.$b.'</option>';
                                         }
                                         
                                         
                                         echo $key_query = "SELECT `question_id` AS a, `secret_question` AS b FROM `mdu_secret_questions` WHERE is_enable=1  ORDER BY `question_id` ASC";
                                         
                                         $query_results=mysql_query($key_query);
                                         while($row=mysql_fetch_array($query_results)){
                                           $a = $row['a'];
                                           $b = $row['b'];
                                             
                                           echo '<option value="'.$b.'">'.$b.'</option>';
                                         }
                                         ?>
                                         </select>                                
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->                          
                                   
                                   
                                   
                             
                               <div class="control-group">
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">Answer<sup><font color="#FF0000" >*</font></sup></label>
         
                                         <input class="span4 form-control" id="answer" placeholder="Answer" name="answer" type="text" style="display: block; width:70%;" value="<?php echo $mg_answer; ?>">
                                         
                                     
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->
         
                                       <script type="text/javascript">
                                           $("#answer").keypress(function(event){
                                             var ew = event.which;
                                             //alert (ew);
                                             if(ew == 32 || ew == 35   )
                                               return true;
                                             if(48 <= ew && ew <= 57)
                                               return true;
                                             if(65 <= ew && ew <= 90)
                                               return true;
                                             if(97 <= ew && ew <= 122)
                                               return true;
                                               
                                             return false;
                                           });
                                           $('#answer').bind("cut copy paste",function(e) {
                                               e.preventDefault();
                                              });
                                         </script>    
                                   
         
             
                                   <div class="form-actions" >
                                     <input type="hidden" name="edit_customer_uname" value="<?php echo $mg_username; ?>">
                                     <button type="submit" name="customer_submit" id="customer_submit" class="btn btn-primary">Update</button>&nbsp; <strong><font color="#FF0000">*</font><font size="-2"> Required Field</font></strong>
         
                                   </div>
                                   <!-- /form-actions -->
                                 </fieldset>
                               </form>
                               
                               <script>
         
         $(document).ready(function(){
          document.getElementById("customer_submit").disabled = true;
         });
         
         function customer_submitenable(){
           document.getElementById("customer_submit").disabled = false;
           }
         
         </script>
         
         
               </div>
               <!-- /widget-content --> 
             </div>
             <!-- /widget --> 
             </div>
             <!-- /span6 -->
             <div class="span5a" >
             <div class="widget">
               
               <!-- /widget-header -->
               <div class="widget-content">

               
             <div class="">
               <div class="widget">
                 <!-- <div class="widget-header"> <i class="icon-th-list"></i>
                   <h3> Service Profile</h3>
                 </div> -->
                 <div class="columns" style="margin-bottom: 5px">
               <h3><strong>Tenant Bandwidth Profile</strong></h3>
               </div>
                
                 <div class="widget-content">
         
                   <form id="profile_form" name="profile_form" action="manage_tenant.php?tab=account" method="post"  class="form-horizontal" enctype="multipart/form-data">
         
                   <?php
                     $_SESSION['PROF_RAND']=RAND();
                    
                     $get_tenant_profile="SELECT `service_profile` AS f FROM `mdu_vetenant` WHERE `customer_id`='".$mg_customer_id."' LIMIT 1";
                     /*$tenant_profile_arr=mysql_fetch_assoc(mysql_query($get_tenant_profile));
                     $tenant_profile=$tenant_profile_arr['service_profile']; */
                     $tenant_profile=$db->getValueAsf($get_tenant_profile);
                     //$tenant_profile_arry=explode(",",$tenant_profile);
                     
                     // user profile
                     
                     
                     
                     
                     
                     // default profile
                     /*$get_dist_profile="SELECT  p.product_code AS f FROM exp_products p JOIN  `mdu_organizations` o ON o.default_prof=p.product_id WHERE o.property_id='$mg_property_id'";*/
                    $query_service_profile = "SELECT `product_code`  
                    FROM `exp_products_distributor`
                    WHERE distributor_code='$user_distributor' AND `network_type` = 'VT-DEFAULT'";
                      
                      $query_results_profile=mysql_query($query_service_profile);
                      while($row_s=mysql_fetch_array($query_results_profile)){

                        $service_profile_product = $row_s['product_code'];
                      }
                                     //$profile_name_array=explode(",",$profile_name);
                             
                      if($profile_name=$tenant_profile) {
                        $match_value=1;
                      }
                      else{
                        $match_value=0;
                      }
                     //$dif1=array_diff($profile_name_array,$tenant_profile_arry);
                     //$dif2=array_diff($tenant_profile_arry,$profile_name_array);tenant_profile
                     // if(count($dif1)==0){
                     //   if(count($dif2)==0){
                     //     $match_value=1;
                     //   }else{
                     //     $match_value=0;
                     //   }
                     // }else{
                     //   $match_value=0;
                     // }
                     ?>
                     
                     <!-- <label class="control-label" for="switch">Default Profile <br><font size="1">(<?php foreach($user_distributor as $pr){ echo $pr;}?>) </font><sup><font color="#FF0000" >*</font></sup></label> -->
                      <!-- <label class="control-label" for="switch">Default Profile <br><font size="1">(<?php echo $service_profile_product; ?>)</font><sup><font color="#FF0000" >*</font></sup></label> -->
                      <label  for="switch"><?php echo $service_profile_product; ?></label>

                        
                                           
                     
                       <div class="controls">
                                                            
                         <?php
                         // if($get_profile_type=='DEFAULT'){

                        
                         //   echo "<input id=\"default_act\" type=\"checkbox\" data-toggle=\"toggle\" data-width=\"50\" data-height=\"20\" checked disabled=\"disabled\"  data-onstyle=\"success\" data-offstyle=\"warning\">";
                         // }else{
                                        
                         //   echo"<a id=\"default_act_i\"><input id=\"default_act\" type=\"checkbox\" data-toggle=\"toggle\" data-width=\"50\" data-height=\"20\" data-onstyle=\"success\" data-offstyle=\"warning\"> </a>";
                         // }
                         ?>
         
                       </div>
         
         <script type="text/javascript" src="js/bootstrap-toggle.min.js"></script>
                     <script>
                       $(document).ready(function() {
                         var secret='<?php echo$_SESSION['PROF_RAND'];?>';
                         var search_id='<?php echo$search_id?>';
                         var up_customer_id='<?php echo $mg_customer_id?>';
                         var up_profile='<?php echo$profile_name;?>';
         
                         $("#default_act_i").easyconfirm({
                           locale: {
                             title: 'Service Profile Active',
                             text: 'Are you sure you want to active this service profile?',
                             button: ['Cancel', ' Confirm'],
                             closeText: 'close'
                           }
                         });
                         $("#default_act_i").click(function () {
         
                           $('#default_act').bootstrapToggle('on');
                           $('#probation_act').bootstrapToggle('off');
                           $('#premium_act').bootstrapToggle('off');
         
                           window.location = "?token="+secret+"&search_id="+search_id+"&up_customer_id="+up_customer_id+"&profile_name="+up_profile+"&type=default"
                         });
         
         
                       });
         
                     </script>
         
         
                   <!-- /controls -->
                 <!--  <p><font size="2px">All tenants have this profile by default. It is set by the ISP.</font></p> -->
         <?php
                                 
                                 
                                 
                                 
                                 
                    // probation profile
                    $get_dist_profile = "SELECT `product_code`  
                    FROM `exp_products_distributor`
                    WHERE distributor_code='$user_distributor' AND `network_type` = 'VT-PROBATION'";

                    $query_results_profile=mysql_query($get_dist_profile);
                      while($row_s=mysql_fetch_array($query_results_profile)){

                        $profile_name = $row_s['product_code'];
                      }
                   
                     //$profile_name = $db->getValueAsf($get_dist_profile);
                                 
                                 //$profile_name_array=explode(",",$profile_name);
                                 if($profile_name=$tenant_profile) {
                                  $match_value=1;
                                }
                                else{
                                  $match_value=0;
                                }
                      /*
                                 $dif1=array_diff($profile_name,$tenant_profile_arry);
                                 $dif2=array_diff($tenant_profile_arry,$profile_name);
                                 if(count($dif1)==0){
                                   if(count($dif2)==0){
                                     $match_value=1;
                                   }else{
                                     $match_value=0;
                                   }
                                 }else{
                                   $match_value=0;
                                 }*/
                                 ?>
                                 
                              <!--  </br>
                               <label class="control-label" for="switch">Probation Profile <br><font size="1">(<?php echo $profile_name; ?>)</font><sup><font color="#FF0000" >*</font></sup></label>
                            
                               <div class="controls">
         
                                   <?php
                                   if($get_profile_type=='PROBATION' && $match_value==1){
                                     
                                     echo "<input id=\"probation_act\" type=\"checkbox\" data-toggle=\"toggle\"   data-width=\"50\" data-height=\"20\" checked disabled=\"disabled\" data-onstyle=\"success\" data-offstyle=\"warning\"> ";
                                   }else{
                                     echo"<a id=\"probation_act_i\"><input id=\"probation_act\" type=\"checkbox\" data-toggle=\"toggle\"   data-width=\"50\" data-height=\"20\" data-onstyle=\"success\" data-offstyle=\"warning\"></a>";
                                   }
                                   ?>
                               </div>
                               <script>
                                 $(document).ready(function() {
                                   var secret='<?php echo $_SESSION['PROF_RAND'];?>';
                                   var search_id='<?php echo $search_id?>';
                                   var up_customer_id='<?php echo $mg_customer_id?>';
                                   var up_profile='<?php echo $profile_name;?>';
         
                                   $("#probation_act_i").easyconfirm({
                                     locale: {
                                       title: 'Service Profile Active',
                                       text: 'Are you sure you want to activate this service profile?',
                                       button: ['Cancel', ' Confirm'],
                                       closeText: 'close'
                                     }
                                   });
                                   $("#probation_act_i").click(function () {
         
                                     $('#probation_act').bootstrapToggle('on');
                                     $('#default_act').bootstrapToggle('off');
                                    $('#premium_act').bootstrapToggle('off');
         
                                     window.location = "?token="+secret+"&search_id="+search_id+"&up_customer_id="+up_customer_id+"&profile_name="+up_profile+"&type=probation"
                                   });
         
         
                                 });
         
                               </script> -->
         
             
               <!-- /controls -->
                             
              <!-- <p><font size="2px">Activate the probation profile to temporarily reduce the tenants bandwidth.</font></p> -->
               
                     
                     
                     
                     
                     
                     
                     
                   <!--   
                    <?php    
                     // premium profile
                
                    $match_value=0;
                    
                    $profile_name_ar=array();
                    
                     $get_dist_profile="SELECT  p.product_code AS f FROM exp_products p JOIN  `mdu_organizations` o ON o.premium_profile=p.product_id WHERE o.property_id='$mg_property_id'";
                    $service_profile=mysql_query($get_dist_profile);
                    
                    while($dist_profile_arr=mysql_fetch_assoc($service_profile)){
                      $profile_name=$dist_profile_arr['f'];

                      //$prop_arr=explode(",", $profile_name);
                               
                      //array_push($profile_name_ar,$prop_arr[2]);
                    //  $duration_profile_name=$dist_profile_arr['duration_profile'];
                    }
                    //get list
                    
                    
                    
                   // $profile_name_array=explode(",",$profile_name);
                    
                   if($profile_name=$tenant_profile) {
                        $match_value=1;
                      }
                      else{
                        $match_value=0;
                      }
                    /*$dif1=array_diff($profile_name,$tenant_profile_arry);
                    $dif2=array_diff($tenant_profile_arry,$profile_name);
                    if(count($dif1)==0){
                      if(count($dif2)==0){
                        $match_value=1;
                      }else{
                        $match_value=0;
                      }
                    }else{
                      $match_value=0;
                    }*/
         
                   /*  echo "====================".count($dif1)." ".count($dif2)." ".$match_value."</br>";
                    print_r($tenant_profile_arry);
                    print_r($profile_name_array); */
                    
                    // $get_profile_type /  $duration_details / $service_profile_details
                    
                              
         
                                   if($get_profile_type=='PREMIUM' &&  $match_value==1){
                                     ?>
                            
                               <label class="control-label" for="switch">Premium Profile <br><font size="1">(<?php echo $profile_name;?>)</font><sup><font color="#FF0000" >*</font></sup></label>
                            
                               <div class="controls">
         
                                   <?php
                                 //  if($get_profile_type=='PREMIUM'){
                                     echo "<input id=\"premium_act\" type=\"checkbox\" data-toggle=\"toggle\"   data-width=\"50\" data-height=\"20\" checked disabled=\"disabled\"> ";
                                 //  }else{
                                   //  echo"<a id=\"premium_act_i\"><input id=\"premium_act\" type=\"checkbox\" data-toggle=\"toggle\"   data-width=\"50\" data-height=\"20\"></a>";
                                 //  }
                                   ?>
                               </div>
                                 <div class=""> <p  align="left"><font size="2px">This profile can be activated if the tenant has purchased a premium package.</font></p></div>
                          
         
                             
                             <?php }
                             else{
                               
                               
                               ?>
                                                
                                                  
                  <div class=""> <p  align="left"><font size="2px">Premium profile can be activated if the tenant has purchased a premium package.</font></p></div>
                                                
                               
                                                   
                                                   <?php
                                   }
                                   ?> -->
                             
               <!-- /controls -->
               
               
               
               
                     <!-- <div class="control-group">
                       <label class="control-label" for="radiobtns">Premium Profile<sup><font color="#FF0000" >*</font></sup></label>
         
                       <div class="controls">
                         <div class="">
         
                               <select name="premium_profile" id="premium_profile" required>  
                               
                               <?php                                
                                 $prof_array1 = $profile_name;
                                 //foreach ($prof_array1 as $key => $values){
                                   echo '<option value="'.$prof_array1.'">'.$prof_array1.'</option>';
                                 //}                                
                               ?>                                                             
                               </select>
                                                           
                         </div>
                       </div>
                       /controls 
                     </div> 
                     /control-group -->
                     
                     
         
                       <!-- <div class="form-actions" >
                                   
                         
                         <a onclick="premium();" name="device_submit" id="device_submit" class="btn btn-primary">
                         <?php if($get_profile_type=='PREMIUM') echo "Change"; else echo "Activate"; ?>
                         
                         </a>&nbsp; <strong><font color="#FF0000">*</font><font size="-2"> Required</font></strong>
                         
                                   
                      </div> -->
                     
                              <script>
                               function premium(){
                                   var secret1='<?php echo$_SESSION['PROF_RAND'];?>';
                                   var search_id1='<?php echo$search_id?>';
                                   var up_customer_id1='<?php echo $mg_customer_id?>';
         
                                   var e = document.getElementById("premium_profile");
                                   var up_profile1 = e.options[e.selectedIndex].value;
         
         
                                   $('#probation_act').bootstrapToggle('off');
                                   $('#default_act').bootstrapToggle('off');
                                   $('#premium_act').bootstrapToggle('on');
                                   
                                   if(up_profile1!=null || up_profile1!=''){
         
                                     window.location = "?token="+secret1+"&search_id="+search_id1+"&up_customer_id="+up_customer_id1+"&profile_name="+up_profile1+"&type=premium"
         
                                     }
                                     
                               }
         
                               </script>           
               
                     
                     
                     
               
              
                  </div>
                    
         
                     </fieldset>
                   </form>
         
         
                 </div>
               </div>

              <!--  device add -->

                <div class="">
             <div class="">
             
             <!-- /widget -->
             
             <!-- /widget -->
             <div class="widget">
         
               <div class="widget-content">
               
               <form id="device_form" name="device_form" action="manage_tenant.php?tab=account" method="post"  class="form-horizontal" style="margin: 0 0 -60px;" enctype="multipart/form-data">
                         
                           <?php
                         echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" /><input type="hidden" name="search_id" id="search_id" value="'.$search_id.'" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="'.$mg_customer_id.'" />';
                                 
                         ?>
                         
                           <fieldset class="se_main_field">
         
                           <div class="se_field">
                             <div id="response_d2"></div>

                             <div class="control-group">
         
                                     <div class="controls form-group">
                                       <div class="columns" style="margin-bottom: 5px">
                                          <h3><strong>Manually Add Tenant Devices</strong></h3>
                                       </div>
                                     </div>

                             </div>
                           
                                   
                                   
                                   
         
                                   <?php 
                                   
                                   $key_query = "SELECT device_limit AS f FROM `mdu_organizations` WHERE `property_number`='$mg_property_id'";
                                   
                                   $query_results=mysql_query($key_query);
                                   while($row=mysql_fetch_array($query_results)){
                                     $settings_value = $row[f]; 
                                     $max_allowed_devices_count = trim($settings_value);
                                     
                                   }
                                   
                                   //$max_allowed_devices_count = 10;
                                     $max_allowed_devices = $max_allowed_devices_count-1;
                                   
                                     if($number_of_results>$max_allowed_devices){
                                       echo '<font color="red">Max allowed device limit is reached and new devices can not be registered. </font><br>';
                                     }
                                   ?>
                                   
                                   
         
                                   <div class="control-group" >
         
                                     <div class="controls form-group">
                                       
                                     <label class="" for="radiobtns">MAC Address<sup><font color="#FF0000" >*</font></sup></label>
         
                                         <input class="span4 form-control"  id="mac_address" name="mac_address" maxlength="17" type="text" style="width:70%;"  oninvalid="setCustomValidity('Invalid MAC format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"  title="Format - xx:xx:xx:xx:xx:xx" pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$" >
                                         
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->
         <script type="text/javascript">
         
         function mac_val(element) {
         
           
         
             setTimeout(function () { 
               var mac = $('#mac_address').val();
         
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
         
               /*for (i = 0; i < len; i+=2) {
                 
         
                 
                 
                 if(i==10){
         
                   result+=mac.charAt(i)+mac.charAt(i+1);
                   
                   }else{   
           
                 result+=mac.charAt(i)+mac.charAt(i+1)+':';
         
                   }
                 
                 
                
               }*/
         
               var pattern = new RegExp( "[/-]", "g" );
               var mac = mac.replace(pattern,"");
               var pattern1 = new RegExp( "[/:]", "g" );
               mac = mac.replace(pattern1,"");
               
               var mac1 = mac.match(/.{1,2}/g).toString();
              
               var pattern = new RegExp( "[/,]", "g" );
               
               var mac2 = mac1.replace(pattern,":");
         
               
               document.getElementById('mac_address').value = mac2;
         
               $('#device_form').formValidation('revalidateField', 'mac_address');
         
         
                }
               
         
             }, 100);
         
         
         }
         
         $("#mac_address").on('paste',function(){
         
          mac_val(this.value);
           
         });
         
         
         </script>
                                   
                                   
                                   
         
                     <script type="text/javascript">
         
                             $(document).ready(function() {
         
                              $('#mac_address').change(function(){
         
                                 
                                 $(this).val($(this).val().replace(/(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})/,'$1:$2:$3:$4:$5:$6'))
                                   
        
                                });
         
                               
         
                               $('#mac_address').keyup(function(e){
                                 var mac = $('#mac_address').val();
                                 var len = mac.length + 1;
         
         
                                 if(e.keyCode != 8){
                                
                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac_address').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }
                                });
                                
         
                               $('#mac_address').keydown(function(e){
                                 var mac = $('#mac_address').val();
                                 var len = mac.length + 1;
         
         
                                 if(e.keyCode != 8){
         
                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac_address').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }
         
         
         
                                              
         
                                 // Allow: backspace, delete, tab, escape, enter, '-' and .
                                 if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
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
         
                             </script>
                                                 
                                   
         
         <script>
         /* $('#mac_address').on('keydown', function(){
           var mac = $('#mac_address').val();
           var len = mac.length + 1;
         
           if(len%3 == 0 && len != 0 && len < 18){
             $('#mac_address').val(function() {
               return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
               //i++;
             });
           }
         }); */
         </script>
                                   
                                   
                                   
                                   <div class="control-group">
         
                                     <div class="controls form-group">
                                     
                                     <label class="" for="radiobtns">Nickname<sup><font color="#FF0000" >*</font></sup></label>
         
                                         <input class="span4 form-control" id="nick_name"  name="nick_name" type="text" style="width:70%; ">
                                         
                                       
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->
                                   
                                   
                                       <script type="text/javascript">
                                           $("#nick_name").keypress(function(e){
         
                                             
                                             if (e.which>32 && e.which < 48 || 
                                                 (e.which > 57 && e.which < 65) || 
                                                 (e.which > 90 && e.which < 97) ||
                                                 e.which > 122) {
                                                 e.preventDefault();
                                               }
         
                                             
                                           });
                                         </script>                          
                                   
                                                             
                                   
         
                                     
                                   
                                   
                             
                                   
                           
             
                                   <div style="border-top: 1px solid #ddd;width:85%;">
                                   </div>
                                   <div class="form-actions" style="border-top: 0px !important;" >
                                   
                                     <?php 
                                     if($number_of_results>$max_allowed_devices){?>
                                     <button type="button" class="btn btn-primary" disabled="disabled">Register</button>&nbsp; <!-- <strong><font color="#FF0000">*</font><font size="-2"> Required</font></strong> -->
                                     <?php }                          
                                     else{ ?>
                                     <button type="submit" name="device_submit" id="device_submit" class="btn btn-primary">Register</button>&nbsp; <!-- <strong><font color="#FF0000">*</font><font size="-2"> Required</font></strong> -->
                                     <?php } ?>
                                   
                                   </div>
                                   <!-- /form-actions -->

                                   </div>
                                 </fieldset><br/><br/>
                               </form>
         
               
               </div>
               <!-- /widget-content --> 
            
             
             
             <!-- /widget --> 
             
             <!-- /widget -->
             </div> 
             
             
             <!-- /span6 --> 
           </div>
           <!-- /row -->
         
         
         
         
         
         
         
               </div>
               
               <!-- /widget-content --> 
<br>
<div class="control-group">
         
         <div class="controls form-group">
           <div class="columns" style="margin-bottom: 5px">
              <h3><strong>Tenant Device List</strong></h3>
           </div>
         </div>

 </div>
               <div class="table_response_half">
               <div style="overflow-x:auto">
              
              
              <table class="table table-striped table-bordered">
                                     <thead>
                                       <tr>
                                         <th>NICKNAME</th>
                                         <th>MAC ADDRESS</th>
                                         <th>DELETE DEVICE</th> 
                                         <th>ACTIVE SESSION</th>
                                         <!-- <th>DELETE SESSION</th> -->                  
                                       </tr>
                                     </thead>
                                     <tbody>
                         
                         
                         
                         
                   <?php
         
                    
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
         
                   $get_user_name=mysql_query("SELECT username AS f FROM `mdu_vetenant` WHERE `customer_id`='$mg_customer_id' LIMIT 1");
                   $rowd=mysql_fetch_array($get_user_name);
                   $cust_user_name=$rowd['f'];

         
                   $mg_property_query ="SELECT `property_type` FROM `mdu_organizations` WHERE `property_id`='$mg_property'";  
                   $result_mg_property = mysql_query($mg_property_query);
                   $result_mg_property_arr = mysql_fetch_array($result_mg_property);
                   $mg_property_type =$result_mg_property_arr['property_type'];
         
                   if($mg_property_type != 'MDU'){

         
                   $key_query="SELECT d.id,d.nick_name,d.email_address ,IF(d.description IS NULL ,t2.mac,d.description) AS description ,d.mac_address,IF(t2.mac IS NULL,'d','b') AS s_type ,
                         t2.start_time, t2.account_state,d.create_user,
                         t2.session_id
                         FROM `mdu_customer_devices` d LEFT JOIN
                         (SELECT s1.*
                          FROM mdu_customer_sessions s1 JOIN
                          (SELECT id
                           FROM mdu_customer_sessions
                           WHERE `realm`<>'' OR !ISNULL(`realm`)
                           GROUP BY realm,mac,`account_state`) AS s2
                            ON s1.id = s2.id
                          ORDER BY s1.id) t2
                           ON t2.realm = d.`group` AND t2.mac = d.description
                         WHERE d.user_name='$cust_user_name'
                         
                         UNION ALL
                         SELECT d.id, d.nick_name,d.email_address,IF(d.description IS NULL ,t2.mac,d.description) AS description,d.mac_address,'s' AS s_type ,
                         t2.start_time, t2.account_state,d.create_user,
                         t2.session_id
                         FROM `mdu_customer_devices` d RIGHT JOIN
                         (SELECT s1.*
                          FROM mdu_customer_sessions s1 JOIN
                          (SELECT id
                           FROM mdu_customer_sessions
                           WHERE `realm`<>'' OR  !ISNULL(`realm`)
                           GROUP BY realm,mac,`account_state`) AS s2
                            ON s1.id = s2.id
                          ORDER BY s1.id) t2
                           ON t2.realm = d.`group`
                         
                         WHERE t2.user_name='$cust_user_name' AND d.description IS NULL";
                   
         
                         /*
                           $key_query = "SELECT  id,`nick_name`,`email_address`,`description`,`mac_address` 
                           FROM `mdu_customer_devices` WHERE `user_name`='$cust_user_name'"; */
                   
                         
         
                         $query_results=mysql_query($key_query);
                         $number_of_results = mysql_num_rows($query_results);
                         $table_array=array();
                         $table_array_count=0;
                         while($row=mysql_fetch_array($query_results)) {
         
                           $id = $row['id'];
                           $nick_name = $row['nick_name'];
                           //$email_address = $row['email_address'];
                           $description = $row['description'];
                           $mac_id = $row['mac_address'];
                           $rec_type = $row['s_type'];
                           $session_id = $row['session_id'];
                           $account_state = $row['account_state'];
                           $acc_states = $row['create_user'];
         
         
                           if ($rec_type == 'd') {
                             $div_btn_disable = 'disabled="disabled"';
                           } elseif ($rec_type == 's') {
                             $ses_btn_disable = 'disabled="disabled"';
                           }
         
                           $mac_relm = explode('@', $mac_id);
                           /* print_r($mac_relm);
                           echo "<br>"; */
                           $table_array[$mac_relm[0]][id]=$id;
                           $table_array[$mac_relm[0]][nick]=$nick_name;
                           $table_array[$mac_relm[0]][stat]=$acc_states;
                           $table_array[$mac_relm[0]][rec]=$rec_type;
                           //$table_array[$mac_relm[1]][de]=$description;

                           
                           if($table_array_count>0){
                             if($table_array[$description][state]!='Active'){
                               $table_array[$description][state]=$account_state;
                             }
                           }else{
                             $table_array[$description][state]=$account_state;
                           }
         
         
         
                           $table_array_count++;
         
         
                         }
         
                //  print_r($table_array);
                         $count_device=0;
         
                         foreach ($table_array as $key=>$value){
                          $count_device=$count_device+1;
                         //  echo $key;
                                             
                           echo '<tr>
                           <td> '.$value[nick].' </td>
                         
                           <td> '.macDisplay($key).' </td>';
                           
                           echo '<td class="td_btn">';
                           if($value[rec]=='b' || $value[rec]=='d'){
         
                             echo '<a href="javascript:void();"  id="DR_'.$value[id].'"  class="btn  btn-small td_btn_last" >
                           <i class="btn-icon-only icon-trash"></i>Remove</a>
                           </td><script type="text/javascript">
                           $(document).ready(function() {
                           $(\'#DR_'.$value[id].'\').easyconfirm({locale: {
                               title: \'Remove Connected Device \',
                               text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                               button: [\'Cancel\',\' Confirm\'],
                               closeText: \'close\'
                              }});
                             $(\'#DR_'.$value[id].'\').click(function() {
                               window.location = "?tab=account&token='.$secret.'&customer_id='.$mg_customer_id.'&search_id='.$search_id.'&rm_device_id='.$value[id].'&mac_id='.$key.'"
                             });
                             });
                           </script>';
                           }
         
                           
                           /*
                           // Session Handling MDU //
                           $query_ses_count = "SELECT * FROM `mdu_customer_sessions` WHERE  `mac` = '$mac_relm[1]' ORDER BY ID DESC LIMIT 1";
                           $ex_mdu = mysql_query($query_ses_count);
                           while($rows=mysql_fetch_array($ex_mdu)){
                             $session_id = $rows['session_id'];
                           }
                           
                           */
                           if($value[stat]=='Active'){
                             $session_active = 'YES';
                           }
                           else{
                             $session_active = 'NO';
                           }
                           
                           echo '<td> '.$session_active.' </td>';
                           /*echo '<td class="td_btn">';
         
                           
                           if($session_active == 'YES'){
                             
                             echo '<a href="javascript:void();"  id="SR_'.$value[id].'"  class="btn btn-small td_btn_last">
                                                             <i class="btn-icon-only icon-trash"></i>Remove</a>
                             
                             </td><script type="text/javascript">
                             $(document).ready(function() {
                             $(\'#SR_'.$value[id].'\').easyconfirm({locale: {
                                 title: \'Remove Session \',
                                 text: \'Are you sure you want to delete this Session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                 button: [\'Cancel\',\' Confirm\'],
                                 closeText: \'close\'
                                }});
                               $(\'#SR_'.$value[id].'\').click(function() {
                                 window.location = "?tab=account&token='.$secret.'&customer_id='.$mg_customer_id.'&search_id='.$search_id.'&rm_ses_id='.$value[id].'&mac_id='.$key.'"
                               });
                               });
                             </script>';
                             
                           }
                           
                          echo '</td>';*/
                           
                           // End Session Handling MDU //
                           
                           
                         
                         }
         
                       }else{
         
                         $key_query = "SELECT  id,`nick_name`,`email_address`,`description`,`mac_address` 
                         FROM `mdu_customer_devices` WHERE `user_name`='$cust_user_name'";
                 
                       $query_results=mysql_query($key_query);
                       $number_of_results = mysql_num_rows($query_results);
                       while($row=mysql_fetch_array($query_results)){
                        $count_device+=$count_device;
                         $id = $row['id'];
                         $nick_name = $row['nick_name'];
                         //$email_address = $row['email_address'];
                         $description = $row['description'];
                        $mac_id = $row['mac_address'];
                         
                         $mac_relm = explode('@', $mac_id);
                         
         
                         
                                           
                         echo '<tr>
                         <td> '.$nick_name.' </td>
                       
                         <td> '.macDisplay($mac_relm[0]).' </td>';
                         
                         echo '<td>';                 
                         echo '<a href="javascript:void();"  id="DR_'.$id.'"  class="btn  btn-small">
                         <i class="btn-icon-only icon-trash"></i>Remove</a>
                         </td><script type="text/javascript">
                         $(document).ready(function() {
                         $(\'#DR_'.$id.'\').easyconfirm({locale: {
                             title: \'Remove Connected Device \',
                             text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                             button: [\'Cancel\',\' Confirm\'],
                             closeText: \'close\'
                            }});
                           $(\'#DR_'.$id.'\').click(function() {
                             window.location = "?tab=account&token='.$secret.'&customer_id='.$mg_customer_id.'&search_id='.$search_id.'&rm_device_id='.$id.'&mac_id='.$description.'"
                           });
                           });
                         </script>';
                         
                         
                         
                         // Session Handling MDU //
                         $query_ses_count = "SELECT * FROM `mdu_customer_sessions` WHERE  `mac` = '$mac_relm[0]' ORDER BY ID DESC LIMIT 1";
                         $ex_mdu = mysql_query($query_ses_count);
                         while($rows=mysql_fetch_array($ex_mdu)){
                           $session_id = $rows['session_id'];
                         }
                         
                         
                         if(mysql_num_rows($ex_mdu)>0){
                           $session_active = 'YES';
                         }
                         else{
                           $session_active = 'NO';
                         }
                         
                         echo '<td> '.$session_active.' </td>';
                         /*echo '<td>';
         
                         
                         if($session_active == 'YES'){
                           
                           echo '<a href="javascript:void();"  id="SR_'.$session_id.'"  class="btn btn-small">
                                                           <i class="btn-icon-only icon-trash"></i>Remove</a>
                           
                           </td><script type="text/javascript">
                           $(document).ready(function() {
                           $(\'#SR_'.$session_id.'\').easyconfirm({locale: {
                               title: \'Remove Session \',
                               text: \'Are you sure you want to delete this Session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                               button: [\'Cancel\',\' Confirm\'],
                               closeText: \'close\'
                              }});
                             $(\'#SR_'.$session_id.'\').click(function() {
                               window.location = "?tab=account&token='.$secret.'&customer_id='.$mg_customer_id.'&search_id='.$search_id.'&rm_ses_id='.$session_id.'&mac_id='.$description.'"
                             });
                             });
                           </script>';
                           
                         }
                         
                        echo '</td>';*/
                         
                         // End Session Handling MDU //
                         
                         
                       
                       }
         
                       }
         
                   ?>         
                         
                         
                         
             
                         
                         </tbody>
                     </table>
                     <strong><font style="margin-top: -18px; float: right;" size="-2"><?php echo $count_device; ?> of maximum 10 devices registered</font></strong> 
                     </div>
         </div>
         
             </div>
             <!-- /widget -->
             
             
             
         
             
             <!-- /widget -->
             
             <!-- /widget --> 
             
             <!-- /widget -->
             </div>
         
            <!--  </div> -->
         
         
         
             <!-- /span6 --> 
            </div> 
           <!-- /row --> 
                           
                             
                             
         <?php } else{ ?>      
                             
                              <h1 class="head"><span>
    Manage Tenants <!-- <img data-toggle="tooltip" title="Use the Search Tenant field to search for existing tenants that have contacted you for assistance with their account. This could include updating personal information, adding or removing devices, upgrading account to a premium service, resetting their account password and also permanently deleting an account." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"> --></span>
</h1>
                           
                    
                             
                             <div id="system_response"></div>
         
                       <form id="edit-profile" action="?tab=account" method="post" class="form-horizontal middle" >
                         
                         
                         <?php
                                               
                         echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
                                 
                         ?>
                         
                           <fieldset>
         
                           
                           
                           
                         
                           
                                    <!-- <div class="control-group">
                                     
         
                                     <div class="controls">
                                       
                                        
                                         <a  id="sync_all" name="sync_all" class="btn btn-default" style="text-decoration:none"><i class="btn-icon-only icon-refresh"></i> Sync Records</a>&nbsp;<img data-toggle="tooltip" title="If a tenant record appears to be missing from the search results, then click [Synch Records] to download missing records that you may have added manually." src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">
                           
                                       
                                     </div>

                                     <script type="text/javascript">
                                         $(document).ready(function() {
                                         $('#sync_all').easyconfirm({locale: {
                                            title: 'Sync Data',
                                             text: 'Are you sure you want to sync. It can take several <br> minutes depending on the number of accounts.?',
                                             button: ['Cancel',' Confirm'],
                                             closeText: 'close'
                                            }});
                                           $('#sync_all').click(function() {
                                            window.location = "?action=sync_data&tocken=<?php// echo $secret; ?>" 
                                           });
                                           });
                                         </script>
                                     
                                   </div> -->
            
                                   <div class="control-group" style="display: none;">
                                     
                                     <div class="controls">

                                      <label class="" for="radiobtns">Limit Search to <img data-toggle="tooltip" title="You can search a tenant across all your properties or limit the search to a specific property." src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>
         

                                       <div class="">
                                         <select name="property_id" id="property_id" required>  
                                         <option value="ALL">ALL Properties</option>
         
                                         <?php
                                         
                                      /*    $key_query = "SELECT o.property_number,o.property_id, o.org_name 
                                         FROM mdu_organizations o, mdu_system_user_organizations u
                                         WHERE o.property_number = u.property_id
                                         AND u.user_name = '$user_name'";
                                     
                                         $query_results=mysql_query($key_query); */
                                         $query_results = $db->get_property($user_distributor);
                                         while($row=mysql_fetch_array($query_results)){
                                           
                                           $property_number = $row[property_number];
                                           $property_id = $row[property_id];
                                           $org_name = $row[org_name];
                                           
                                           echo '<option value="'.$property_number.'">'.$org_name.'</option>';
                                         }
                                         
                                         ?>
                                         
                                         
                                         </select>
                                         
                                         <!-- &nbsp;<a href="?action=sync_data&tocken=<?php echo $secret; ?>" class="btn btn-default" style="text-decoration:none"><i class="btn-icon-only icon-refresh"></i> Sync Records</a> -->
                           
                                         
                                       </div>
                                     </div>
                                     <!-- /controls -->
                                   </div>
                                   <!-- /control-group -->
                                   
                                                         
                                   
                                   
                                   <div class="control-group middle-large">
                                     
                                     <div class="controls">

                                      <label class="" for="radiobtns">Search Tenants <img data-toggle="tooltip" title="You can search for a tenant using full or partial First Name, Last Name, or Email or use the Search MAC field." src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>
         

                                       <div class="">
                                         <input type="text" name="search_word" id="search_word" >
                                         &nbsp; <font size="4">or</font>
                                           
                                         <br />
                                         
                                        <!--  Note: You can search using First Name, Last Name or Email Address. --> 

                                                        
                                         
                                       </div>
                                     </div>
                                     <!-- /controls -->
                                     <div class="controls">

                                      <label class="" style="margin-top: 10px" for="radiobtns">Search MAC <img data-toggle="tooltip" title="You can search for a tenant using full or partial MAC address of a device or use the Search Tenant field." src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>
         

                                       <div class="">
                                         <input type="text"  name="search_mac" id="search_mac" type="text" maxlength="17"  / >
                                        
                                         <br />
                                       </div>

                                     </div>
                                   </div>
                                    <div class="controls middle-left">
                                   <div  class="">
                                   <div class="control-group">
                                     
         
                                     <div class="controls se_ownload_cr">
                                         <button class="btn" style="margin-bottom: 10px" type="submit" name="search_btn" id="search_btn">Search</button> <img data-toggle="tooltip" title="Click [SEARCH] to show a full list of tenants" src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">
                                         <br />
                                       

                                       
                                         <!-- <label class="" for="radiobtns">First Sync all Records</label> -->
                                         <?php
         
         
          if($re_se != 1){ 
            
         ?>    
                                         <a  id="sync_all" name="sync_all" class="btn btn-default" style="text-decoration:none"><i class="btn-icon-only icon-refresh"></i> Sync Records</a>&nbsp;<img data-toggle="tooltip" title="If a tenant record appears to be missing from the search results, then click [Synch Records] to download missing records that you may have added manually." src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">
                           
                                        
                                     
                                     <script type="text/javascript">
                                         $(document).ready(function() {
                                         $('#sync_all').easyconfirm({locale: {
                                            title: 'Sync Data',
                                             text: 'Are you sure you want to sync. It can take several <br> minutes depending on the number of accounts.?',
                                             button: ['Cancel',' Confirm'],
                                             closeText: 'close'
                                            }});
                                           $('#sync_all').click(function() {
                                            window.location = "?action=sync_data&tocken=<?php// echo $secret; ?>" 
                                           });
                                           });
                                         </script>
                                     
                                    
                                     <?php
         
                                          }
        ?>    
                                           </div>
                                           </div>
                                       </div>
                                       </div>
                                   <!-- /control-group -->   
                                   </form>      

                                  <!-- <form id="edit-profile1" action="?tab=account" method="post" class="form-horizontal" >       

 <?php
                                               
                                               echo '<input type="hidden" name="form_secret" id="form_secret1" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                       
                                               ?>
                                    <div class="control-group">
                                     
                                     <div class="controls">

                                      <label class="" for="radiobtns">Search MAC <img data-toggle="tooltip" title="" src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>
         

                                       <div class="">
                                         <input type="text"  name="search_mac" id="search_mac" type="text" maxlength="17"  / >
                                         <input type="text"  name="search_mac" id="search_mac" maxlength="17" type="text"   oninvalid="setCustomValidity('Invalid MAC format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"  title="Format - xx:xx:xx:xx:xx:xx" pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$" >



                                         <button class="btn" type="submit" name="mac_search_btn" id="search_btn">Search</button>
                                         <br />
                                                                  
                                         
                                       </div>
                                     </div>
                                   </div>                        
                             </fieldset>
                           </form> -->
                           <!-- 
                           <script type="text/javascript">
         
         function se_mac_val(element) {
         
           
         
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
         
               /*for (i = 0; i < len; i+=2) {
                 
         
                 
                 
                 if(i==10){
         
                   result+=mac.charAt(i)+mac.charAt(i+1);
                   
                   }else{   
           
                 result+=mac.charAt(i)+mac.charAt(i+1)+':';
         
                   }
                 
                 
                
               }*/
         
               var pattern = new RegExp( "[/-]", "g" );
               var mac = mac.replace(pattern,"");
               var pattern1 = new RegExp( "[/:]", "g" );
               mac = mac.replace(pattern1,"");
               
               var mac1 = mac.match(/.{1,2}/g).toString();
              
               var pattern = new RegExp( "[/,]", "g" );
               
               var mac2 = mac1.replace(pattern,":");
         
               
               document.getElementById('search_mac').value = mac2;
         
              // $('#device_form').formValidation('revalidateField', 'search_mac');
         
         
                }
               
         
             }, 100);
         
         
         }
         
         $("#search_mac").on('paste',function(){
         
          se_mac_val(this.value);
           
         });
         
         
         </script>
                                   
                                   
                                   
         
                     <script type="text/javascript">
         
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
                                 if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
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
         
                             </script> -->
                               
         <?php
         
         
         
         //echo $record_found;
         
         //if($record_found==1){ 
          if($re_se == 1){ 
            $re_se =0;
         ?>                     
         
             
                               
                          
                                 
         
                                 <div class="widget widget-table action-table" id="se_te">
                                 <form  action="manage_tenant.php" method="post"  class="form-horizontal" enctype="multipart/form-data">
                                 <div class="widget-header">
                                   <i class="icon-th-list"></i>
                                   <h3>Search Results</h3>
                                 </div>
                                 <!-- /widget-header -->
                                 <div style="margin-bottom: 20px;" id="se_download">
                                 <div class="control-group">
                                     
         
                                     <div class="controls se_ownload_cr">
         <?php 
         //$data_secret
          
                                                    

         if($us_property_type == 'MDU'){ 

            $customer_down_key_string = "task=mdu&searchid=".$search_id;
           }else{ 
          $customer_down_key_string = "task=vt&searchid=".$search_id;

          } 
         $customer_down_key =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string);
                                                    $customer_down_key =  urlencode($customer_down_key);
         ?>

         <a href="ajax/export_customer.php?key=<?php echo $customer_down_key?>" class="btn btn-info" style="text-decoration:none"><i class="btn-icon-only icon-download"></i> Download Search Results </a>
         
                                  <br>  <br>     
                                         <!-- <label class="" for="radiobtns">First Sync all Records</label> -->

                                         <a  id="sync_all" name="sync_all" class="btn btn-default" style="text-decoration:none"><i class="btn-icon-only icon-refresh"></i> Sync Records</a>&nbsp;<img data-toggle="tooltip" title="If a tenant record appears to be missing from the search results, then click [Synch Records] to download missing records that you may have added manually." src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">
                           
                                       
                                     

                                     <script type="text/javascript">
                                         $(document).ready(function() {
                                         $('#sync_all').easyconfirm({locale: {
                                            title: 'Sync Data',
                                             text: 'Are you sure you want to sync. It can take several <br> minutes depending on the number of accounts.?',
                                             button: ['Cancel',' Confirm'],
                                             closeText: 'close'
                                            }});
                                           $('#sync_all').click(function() {
                                            window.location = "?action=sync_data&tocken=<?php// echo $secret; ?>" 
                                           });
                                           });
                                         </script>
                                     </div>
                                     </div>
                                   </div>
         
         <br>  
                                 <div class="widget-content table_response">

                                   

              <?php
                               /* if(isset($_SESSION['msg'])){
                                 echo $_SESSION['msg'];
                                 unset($_SESSION['msg']);
                                 
                                 } */
                               $s_id = "SELECT `customer_list` FROM `mdu_search_id` WHERE id = '$search_id'";
                               $query_resultss=mysql_query($s_id);
                               $rows=mysql_fetch_array($query_resultss);
                               $customer_list = $rows['customer_list'];
                               $customer_list_array=explode(",",$customer_list);
                               $customer_list_array_count=count($customer_list_array);
         
                               $default_table_rows=$db->setVal('tbl_max_row_count','ADMIN');
         
                               if($default_table_rows=="" || $default_table_rows=="0"){
                                 $default_table_rows=100;
                               }
         
                               $page_count=ceil($customer_list_array_count/$default_table_rows);
         
                               if(isset($_GET['page_number'])){
                                 $page_number=$_GET['page_number'];
                               }else{
                                 $page_number=1;
                               }
                               $start_row_count=($page_number*$default_table_rows)-$default_table_rows;
                               $end_row_count=($page_number*$default_table_rows);
                               $view_customer_list="";
                               for($i=$start_row_count;$i<min($end_row_count,$customer_list_array_count);$i++) {
                                 $view_customer_list =$view_customer_list.",".$customer_list_array[$i];
                                 $last_row_number=$i;
                               }
                               //  echo $view_customer_list;
         
                               if($customer_list_array_count < 500){
                                 $per_page_menu = '[[10, 25, 50, -1], [10, 25, 50, "All"]]';
                               }
                               else{
                                 $default_table_rows= 100;
                                 $per_page_menu = '[[100, 250, 500, -1], [100, 250, 500, "All"]]';
                               }
                               
                               $view_customer_list=ltrim($view_customer_list,",");
                               $view_customer_list=rtrim($view_customer_list,",");
                               if($page_count!=1){
                               ?>
         
         
                               
                                   <?php
                                   //for ($i = 1; $i <= $page_count; $i++) {
         //                           if($page_number==$i){
         //                             $active="class=\"active\"";
         //                           }else{
         //                             $active="";
         //                           }
         //                           echo "<li ".$active."><a href=\"?page_number=".$i."&search_id=".$search_id."\">$i</a></li>";
         //
         //                         }
                                   }
                                   ?>

                                 <div style="overflow-x:auto">
         
                                   <style>
                                     .dataTables_length{
                                       padding: 5px;
                                       float: right !important;
                                     }
         
                                     .dataTables_length label{
                                       margin-bottom: 0px !important;
                                     }
                                     .dataTables_length select{
                                       margin-left: 5px !important;
                                       width: 80px !important;
                                     }
         
                                     #tenent_search_table th{
                                       border-top: 1px solid #ddd !important;
                                       background-color: #f4f4f4;
                                     }
           
                                     
                                     .dataTables_info{
                                       margin-left: 10px;
                                     }
                                   </style>
                                 
                                 
                                 <script type="text/javascript">
                                   $(document).ready(function(){
                                     $('#tenent_search_table').DataTable({
                                       "pageLength": <?php echo $default_table_rows; ?>,
                                       "columns": [
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         <?php if($us_property_type != 'MDU'){ ?>
                                         null,
                                         <?php } ?>
                                         null,
                                         { "orderable": false },
                                         { "orderable": false }
                                       ],
                                       "autoWidth": false,
                                       "language": {
                                          "emptyTable": "No Tenants Found"
                                        },
                                       /*"language": {
                                         "lengthMenu": "Per page _MENU_ "
                                      },
         */
                                      "bFilter" : false,  
         
                                       "lengthMenu": <?php echo $per_page_menu; ?>
         
                                     });
                                   });
                                 </script>
                                 
                                   <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap id="tenent_search_table">
                                     <thead>
                                       <tr>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><span>First Name</span></th>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><span>Last Name</span></th>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><span>Email</span></th>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10"><span>User Name</span></th>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3"><span>Property</span></th>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10"><span>Validity Time</span></th>
                                         <?php if($us_property_type != 'MDU'){ ?>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3"><span>VLAN ID</span></th>
                                         <?php } ?>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Devices Count</th>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Edit</th>
                                         <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Delete
                                        
                                         </th>
                                         
                                         
                                       </tr>
                                     </thead>
                                     <tbody>
                         
                   <?php 
         
         
                   
                    $key_query = "SELECT c.`customer_id`,c.`first_name`,c.`last_name`,c.`email`,c.`property_id`,c.`valid_from`,c.`room_apt_no`,c.`first_login_date`,c.`vlan_id`,c.`username`,c.validity_time,count(d.`mac_address`) AS countd
         FROM `mdu_vetenant` c LEFT JOIN `mdu_customer_devices` d ON c.`customer_id`= d.`customer_id` WHERE c.customer_id IN ($customer_list) GROUP BY c.customer_id ORDER BY c.first_name ASC ";
                   
                         
         
                         $query_results=mysql_query($key_query);
                         while($row=mysql_fetch_array($query_results)){
                           $customer_id = $row['customer_id'];
                           $first_name = $row['first_name'];
                           $last_name = $row['last_name'];
                           $email = $row['email'];
                           $property_id = $row['property_id'];
                           $room_apt_no = $row['room_apt_no'];
                           $first_login_date = $row['first_login_date'];
                           $vlan_id = $row['vlan_id'];
                           $Device_count = $row['countd'];
                           $username = $row['username'];
                           $validity_time = $row['validity_time'];
                           //$valid_from = $row['valid_from'];
                           
                           
                           $get_property_id_get=mysql_query("SELECT property_id,validity_time FROM `mdu_organizations` WHERE property_number='$property_id' LIMIT 1");
                           
                           while($rowe=mysql_fetch_array($get_property_id_get)){
                             $property_id_display = $rowe['property_id'];
                             //$validity_time_display = $rowe['validity_time'];
                           }
                           
                           
                             
                           
                                             
                           echo '<tr>
                           <td> '.$first_name.' </td>
                           <td> '.$last_name.' </td>
                           <td> '.$email.' </td>
                           <td> '.$username.' </td>
                           <td> '.$property_id_display.' </td>
                           <td> '.$validity_time.' </td>';
                           
                           if($us_property_type != "MDU"){
                           echo '<td> '.$vlan_id.' </td> ';}
                           
                           echo '<td> '.$Device_count.' </td>';
                           
                           
                           echo '<td class="td_btn">';              
                           echo '<a id="CM_'.$customer_id.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Edit</a>';
                         echo '<script type="text/javascript">
         $(document).ready(function() {
         $(\'#CM_'.$customer_id.'\').easyconfirm({locale: {
             title: \'Edit Tenant ['.mysql_real_escape_string($first_name).' '.mysql_real_escape_string($last_name).']\',
             text: \'Are you sure you want to edit this tenant?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
             button: [\'Cancel\',\' Confirm\'],
             closeText: \'close\'
            }});
           $(\'#CM_'.$customer_id.'\').click(function() {
             window.location = "?tab=account&token='.$secret.'&search_id='.$search_id.'&mg_email='.$email.'&mg_customer_id='.$customer_id.'"
           });
           });
         </script></td>';
         
         echo '<td class="td_btn">';
         echo '
         <input type="checkbox" name="customer_delete_id[]"  value="'.$customer_id.'" id="customer_delete_id">
         <input type="hidden" name="token"  value="'.$secret.'" id="token">
         <input type="hidden" name="search_id"  value="'.$search_id.'" id="search_id">';
         
         // echo '<a href="javascript:void();"  id="CR_'.$customer_id.'"  class="btn btn-danger btn-small td_btn_last"><i class="btn-icon-only icon-remove-circle"></i>Delete</a>';
         echo '</td>';
         
         
         
                           
                           
                         }
         
                   ?>         
                         
                         
                         
             
                         
                         </tbody>
                     </table>
                     
                     
                     
                     </div>
                                   
                               <br>
                                 <div align="right">
                                Select All &nbsp;&nbsp; <input type="checkbox" name="customer_delete_all"  value="" id="customer_delete_all">
                                        
                                 
         <button class="btn btn-info" type="submit" name="Delete_btn_device" id="Delete_btn_device">Delete</button>
         </div>    
                                 </div>
                                 
         
         <script type="text/javascript">
         $(document).ready(function() {
           
           $("#customer_delete_all").click(function(){      
                                          $('input[name="customer_delete_id[]"]').prop('checked', this.checked);      
                                          });
           
           $("#Delete_btn_device").easyconfirm({locale: {
             title: 'Delete Tenant',
             text: 'Are you sure you want to delete these tenants?  ',
             button: ['Cancel',' Confirm'],
             closeText: 'close'
            }});
           $("#customer_submit").click(function() {
           });
           
             
           
           
         
           
         });
         
         
         
         </script>
         </form>

        </div>

         <?php //} else if($record_found==0) {//echo $msg; 
          

                  ?>


                  
                  <?php 
                  
                  } ?>                               
                         
                         
                         
                     <?php } ?>
         




                    

                  </div>



<!-- </div> -->


                









                                            <!-- ******************* session ******************* -->
                    

<div class="tab-pane <?php if($active_tab=="session"){echo"active";}?>" id="session">
                  

                      
                      
                  <?php
      if($dl_msg){
        echo $dl_msg;
        $dl_msg='';
      }
      ?>
       <h1 class="head"><span>
    Session Search <img data-toggle="tooltip" title="You can search for a tenant's online sessions using Email, First Name, Last Name or device MAC Address. To get a list of all sessions, click the Search Button." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>

      <form id="edit-profile" action="?tab=session" method="post" class="form-horizontal" >
        <?php

        $_SESSION['FORM_SECRET_SES'] =  md5(uniqid(rand(), true));
        echo '<input type="hidden" name="form_secret_ses" id="form_secret_ses" value="'.$_SESSION['FORM_SECRET_SES'].'" />';

        ?>

        <fieldset>



          <div class="control-group" style="display: none;">
           
            <div class="controls">

               <label class="" for="radiobtns">Limit Search to</label>


              <div class="">
                <select name="property_id_session" id="property_id_session" required>
                  <option value="ALL">ALL Properties</option>

                  <?php

                  /* $key_query = "SELECT o.property_number,o.property_id, o.org_name
                            FROM mdu_organizations o, mdu_system_user_organizations u
                            WHERE o.property_number = u.property_id
                            AND u.user_name = '$user_name'";

                  $query_results=mysql_query($key_query); */
                  $query_results = $db->get_property($user_distributor);
                  while($row=mysql_fetch_array($query_results)){

                    $property_number = $row[property_number];
                    $property_id = $row[property_id];
                    $org_name = $row[org_name];

                    echo '<option value="'.$property_number.'">'.$org_name.'</option>';
                  }

                  ?>


                </select>



              </div>
            </div>
            <!-- /controls -->
          </div>
          <!-- /control-group -->




          <div class="control-group">
            
            <div class="controls">
              <label class="" for="radiobtns">Search Tenant <img data-toggle="tooltip" title="You can search using the First Name, Last Name, Email Address or a device MAC Address." src="layout/ARRIS/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>

              <div class="">
                <input type="text" name="search_word" id="search_word_session" >
                <button class="btn" type="submit" name="search_btn_session" id="search_btn_session">Search</button>
                <br />
                

              </div>
            </div>
            <!-- /controls -->
          </div>
          <!-- /control-group -->
        </fieldset>






        <?php

        
        #*********************************************************************
        
        if(isset($_GET['search_id']) && $_GET['tab']=='session') {
          $search_id = $_GET['search_id'];
          $form_secreat3 = $_GET['s3'];
          $realm=$_GET['realm'];
          if ($form_secreat3 == $_SESSION['FORM_SECRET3']) {
            $record_found=2;
          }
        }

        

        
        if($_GET['tab']=='session') {

        if (2 == 2) {

          $customer_down_key_string = "task=session_mdu&searchid=".$search_id;
          $customer_down_key =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string);
                                                    $customer_down_key =  urlencode($customer_down_key);

          ?>

          <script type="text/javascript">
             $(document).ready(function(){

                                    var table = $('#session_search_table').DataTable({
                                        dom: 'Bfrtip',
                                       "pageLength": 50,
                                       "language": {
                                          "emptyTable": "No Active Sessions"
                                        },
                                         buttons: [
                                            {
                                                extend: 'csvHtml5',
                                                title: 'Session Results',
                                                exportOptions: {
                                                    columns: [ 0, 1, 2, 3, 4 ]
                                                }
                                            }
                                         ]
                                        
                                     });

                                     $("#download-session").on("click", function() {
                                          table.button( '.buttons-csv' ).trigger();
                                      });

              });

          </script>

          <style type="text/css">
            .buttons-csv{
              display: none;
            }
          </style>
          
          <div class="widget widget-table action-table">
          <div class="widget-header">
            <i class="icon-th-list"></i>

            <h3>Search Results</h3>
          </div>
          <!-- /widget-header -->
          <div class="widget-content table_response">

            <a id="download-session" href="javascript:void(0);"
             class="btn btn-info" style="text-decoration:none"><i
                class="btn-icon-only icon-download"></i>
            Download Search Results</a>
          </br>
          </br>
          </br>

          <div style="overflow-x:auto">
          <table id="session_search_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
          <thead>
          <tr>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">MAC
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">First Name
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Last Name
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">EMAIL
            </th>
            <!--    <th>AAA User Name</th> -->
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Session State</th>
            <!--    <th>Realm</th>  -->
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Master Account</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Session Start
              Time
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="8">IP Address
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Delete</th>


          </tr>
          </thead>
          <tbody>
           
          <?php

          if($search_btn_session || isset($_GET['search_id'])){

            if ($newjsonvalue[0]) {
              $ses_dl=0;
                                            $res_arrr=array();
                                            $res_arrr2=array();
                                            foreach ($newjsonvalue[1] as $value1) {
                                                $session_mac=$value1['Mac'];
                                                $session_id=$value1['Ses_token'];
                                                array_push($res_arrr, $session_mac);
                                                array_push($res_arrr2, $session_id);
                                            }
                                            //print_r($res_arrr2);
                                            //echo $session_id;
                                           $session_row_count=0;
                                            foreach ($newjsonvalue[0] as $value2){
                                                //print_r($res_arrr);
                                                $session_row_count=$session_row_count+1;
                                                $ses_dl++;
                                                
                                                echo "<tr>";
                                                $mac=($value2['Mac']);
                                                $ssid=($value2['SSID']);
                                                $GW_ip=($value2['GW_ip']);
                                                $sh_realm=($value2['Realm']);
                                                $state=($value2['State']);
                                            
                                            if (in_array($mac, $res_arrr))
                                                  {
                                                  $session_mac=$mac;
                                                  $a=array_search($session_mac,$res_arrr,true);
                                                  $session_id=$res_arrr2[$a];
                                                  }

                                                
                                             foreach ($value2 as $key => $value) {
                                                //$session_row_count++;

                                                if (strlen($value)<1) {
                                                    $value="N/A";
                                                    # code...
                                                }
                                                echo "<td>".$value."</td>";
                                                

                                             }

                                                           echo '
                                          <td class="td_btn"> ';

                                if(strlen($session_id)>0 && $_GET['uni_mac']!=$mac){
                                echo '<a href="javascript:void(0);"  id="DL_' . $ses_dl . '"  class="btn  btn-small td_btn_last">
                                      <i class="btn-icon-only icon-trash"></i>Delete</a>
                                      </td><script type="text/javascript">
                                      $(document).ready(function() {
                                      $(\'#DL_' . $ses_dl . '\').easyconfirm({locale: {
                                          title: \'Delete Session \',
                                          text: \'Are you sure you want to delete session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                          button: [\'Cancel\',\' Confirm\'],
                                          closeText: \'close\'
                                           }});
                                        $(\'#DL_' . $ses_dl . '\').click(function() {
                                          window.location = "?tab=session&dl_id=' . $session_id . '&search_id=' . $search_id . '&s3=' . $_SESSION['FORM_SECRET_SES'] . '&realm=' . $sh_realm . '&query_type=' . $session_id . '&uni_mac='.$mac.'&search_btn_session=' . $search_btn_session .'"
                                        });
                                        });
                                      </script>';
                                    }
                                    elseif ($_GET['uni_mac']==$mac){
                                                        echo'<a disabled id=id="DL_' . $ses_dl . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
                                                        <script type="text/javascript">
                                                        var deleteSessionCheck'.$mac.' = function (){
                                                            checkSessionDeleted(\''.$sh_realm.'\',\''.$mac.'\',function(data){
                                                                
                                                            if(data == \'0\'){
                                                            alert(data);
                                                                $(\'#DL_' . $ses_dl .'\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
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
                                                            echo'<a disabled id=id="DL_' . $ses_dl . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Delete</a>';
                                                        }

              //
                                echo '</td></tr>';
                                            }

                                        }
                                         
                                          else{
                                            //echo "<td colspan=\"11\">No Active Sessions</td>";
                                        }
                                      }




            



        }





          $_SESSION['mac_array'] = $mac_array;
          ?>
                  </tbody>
                  </table>
                  </div>
            <?php
        /*  if ($session_count == 0) {

            echo "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button>
                        <strong>".$message_functions->showMessage('no_conncted_devices','2004')." </strong></div>";

          }*/
          ?>
                  </div>
                  
                  
                  
              </div>
              <?php

        }

        ?>
      </form>

                  
                
                  

                  

                </div>


                <!-- ******************* today sessions ******************* -->
                









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



<?php
include 'footer.php';
?>



<!-- <script src="js/jquery-1.7.2.min.js"></script>

  <script src="js/bootstrap.js"></script> -->
  <script src="js/base.js"></script>
  <script src="js/jquery.chained.js"></script>
  <!-- tool tip css -->
<link rel="stylesheet" type="text/css" href=    "css/tooltipster-shadow.css" />
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />

<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>



<script >
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

</script>

  <script type="text/javascript" charset="utf-8">

 $(document).ready(function() {
    $("#product_code").chained("#category");

  });
  </script>


  <script type="text/javascript">


  var xmlHttp5;

  function tableBox(type)
  {

    xmlHttp5=GetXmlHttpObject();
    if (xmlHttp5==null)
     {
       alert ("Browser does not support HTTP Request");
       return;
     }
    var loader = type+"_loader_1";
    var res_div = type+"_div";

    document.getElementById(loader).style.visibility= 'visible';
    var search_customer=document.getElementById("search_customer").value;

    var url="ajax/table_display.php";
    url=url+"?type="+type+"&q="+search_customer+"&dist=<?php echo $user_distributor;?>";


    xmlHttp5.onreadystatechange=stateChanged;
    xmlHttp5.open("GET",url,true);
    xmlHttp5.send(null);

    function stateChanged()
    {
      if (xmlHttp5.readyState==4 || xmlHttp5.readyState=="complete")
      {

        document.getElementById(res_div).innerHTML=xmlHttp5.responseText;
        document.getElementById(loader).style.visibility= 'hidden';
      }
    }
  }











function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

</script>



<!-- datatables js -->

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrapValidator.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {

        $('#edit_customer_form').bootstrapValidator({
        
        
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
                

                  fields: {

                    first_name: {
                          validators: {
                              <?php echo $db->validateField('notEmpty'); ?>
                          }
                      },
                      last_name: {
                          validators: {
                    <?php echo $db->validateField('notEmpty'); ?>
                          }
                      },
                      password: {
                          validators: {
                    //<?php echo $db->validateField('pass2_not_same'); ?>,
                    <?php echo $db->validateField('password_required'); ?>
                          }
                      },
                      email: {
                            validators: {
                                <?php echo $db->validateField('email'); ?>
                            }
                        },
                      phone: {
                          validators: {
                                     <?php echo $db->validateField('mobile_non_req'); ?>
                                    }
                      },
                      confirm_password: {
                    validators: {
                        <?php echo $db->validateField('pass_not_same'); ?>,
                        <?php echo $db->validateField('notEmpty'); ?>           
                  }
                },
                      property_id: {
                    validators: {
                    <?php echo $db->validateField('notEmpty'); ?>
                  }
                },
                street_address: {
                    validators: {
                    <?php echo $db->validateField('notEmpty'); ?>             
                  },
                          stringLength: {
                                  max: 256,
                                  message: 'The value must be less than 256 characters'
                          }
                },
                state: {
                    validators: {
                    <?php echo $db->validateField('notEmpty'); ?>           
                  }
                },
                postal_code: {
                    validators: {
                    <?php echo $db->validateField('notEmpty'); ?>             
                  },
              
                      stringLength: {
                                  max: 5,
                                  message: 'The value must be less than 5 characters'
                          }
                },
                city: {
                    validators: {
                    <?php echo $db->validateField('city_required'); ?>            
                  },
                          stringLength: {
                                  max: 100,
                                  message: 'The value must be less than 100 characters'
                          }
                },
                country: {
                    validators: {
                          <?php echo $db->validateField('notEmpty'); ?>             
                  }
                },
                answer: {
                    validators: {
                    <?php echo $db->validateField('notEmpty'); ?>            
                  },
                          stringLength: {
                                  max: 30,
                                  message: 'The value must be less than 30 characters'
                          }
                },
                question: {
                    validators: {
                    <?php echo $db->validateField('notEmpty'); ?>             
                  }
                }
                  }
                });


        $('input').on('blur keyup', function() {

          //check_val();
     
      });

      

    $('select').on('change', function() {

      //check_val();
    
      });  


    //check_val();

      });

    



  </script> 


    <script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="js/buttons.flash.min.js"></script>
     <script type="text/javascript" src="js/buttons.html5.min.js"></script>

<script type="text/javascript">


    var all_customers=$('#all_customers').DataTable({
        "ordering": false,
        "pageLength": 50,
        "paging":   false,
        "info":     false
    });


    $('#search_customer').on( 'keyup', function () {

    //all_customers.search( this.value ).draw();

      var new_input = " " + this.value;
      all_customers.search( new_input, false, false ).draw(); 

    
    } );

</script>


</body>