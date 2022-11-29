<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); */
require_once dirname(__FILE__).'/../src/LOG/logObjectProvider.php';
require_once dirname(__FILE__).'/../src/LOG/Logger.php';
require_once dirname(__FILE__).'/../DTO/FeatureChange.php';
require dirname(__FILE__).'/../db/constatnts.php';
$dbConnection;
switch (DB_DRIVER) {
    case "mysqli":
        require dirname(__FILE__).'/mysql/mysqliDB.php';
        $dbConnection=new mysqliDB();
        break;
    case "mysql":
        require dirname(__FILE__).'/mysql/mysqlDB.php';
        $dbConnection=new mysqlDB();
        break;
    default:
        require dirname(__FILE__).'/mysql/mysqlDB.php';
        $dbConnection=new mysqlDB();
}



class dbTasks
{

    private $dbCon;


    public function __construct()
    {
        global $dbConnection;
        $this->dbCon=& $dbConnection;
    }
	
	////////////////////////////////////////////////////////////////////////  

	public function getNumRows($query)
	{
		if(!empty($query)){
			$num_rows = $this->dbCon->num_rows($query);
			return $num_rows;
		}else{
			return 'Query is empty';
		}

	} 
	//////////////////////////////////////////////////////////////////////// 

	public function selectDB($query)
	{
		if(!empty($query)){
			$result_array = array();

			$results = $this->dbCon->query($query);
			if(is_array($results)){
				$i=0;
		 		foreach ($results as $row){
		     		$columns = array_keys((array)$row);

		     		$recode_array = array();
		     		foreach($columns as $column){
		         		$recode_array[$column] = $row[$column];
		     		}

		     		array_push($result_array,$recode_array);

		     		$i++;
		 		}
		 		return $resp_arr = array('rowCount' => $i, 'data' => $result_array);
			}else{
				return $resp_arr = array('rowCount' => 0, 'data' => $results);
			}

	 		
		}else{
			return $resp_arr = array('rowCount' => 0, 'data' => 'Query is empty');
		}
		
	}

	public function selectDBwithFields($query)
	{
		if(!empty($query)){
			$result_array = array();

			$results = $this->dbCon->query($query);
			if(is_array($results)){
				$i=0;
		 		foreach ($results as $row){
		     		$columns = array_keys((array)$row);

		     		$recode_array = array();
		     		$j=0;
		     		foreach($columns as $column){
		         		$recode_array[$column] = $row[$column];
		         		$j++;
		     		}

		     		array_push($result_array,$recode_array);

		     		$i++;
		 		}
		 		return $resp_arr = array('rowCount' => $i, 'fieldCount' => $j, 'data' => $result_array, 'fieldNames' => $columns);
			}else{
				$columns = array_keys($results);
				return $resp_arr = array('rowCount' => 0, 'fieldCount' => 0, 'data' => $results, 'fieldNames' => $columns);
			}

	 		
		}else{
			return $resp_arr = array('rowCount' => 0, 'fieldCount' => 0, 'data' => 'Query is empty', 'fieldNames' => 'Query is empty');
		}
		
	}

	public function select($table,$column='*',array $conditions=[]){
        return $results = $this->dbCon->select($table,$column,$conditions);
    }

	public function selectDBwithSeekPointer($query,$pointer)
	{
		if(!empty($query) || !empty($pointer)){
			$result_array = array();

			$results = $this->dbCon->queryWithSeekPointer($query,$pointer);
			if(is_array($results)){
				$i=0;
		 		foreach ($results as $row){
		     		$columns = array_keys((array)$row);

		     		$recode_array = array();
		     		foreach($columns as $column){
		         		$recode_array[$column] = $row[$column];
		     		}

		     		array_push($result_array,$recode_array);

		     		$i++;
		 		}
		 		return $resp_arr = array('rowCount' => $i, 'data' => $result_array);
			}else{
				return $resp_arr = array('rowCount' => 0, 'data' => $results);
			}

	 		
		}else{
			return $resp_arr = array('rowCount' => 0, 'data' => 'Query or Pointer is empty');
		}
		
	}

	/////////////////////////Insert data to the DB///////////////////////////////////////////////
	public function insertData($table,$dataArray)
	{
		if(!empty($table) && !empty($dataArray)){
			$inserted = $this->dbCon->insert($table,$dataArray);
			if($inserted=='1'){
		 		return true;
			}else{
				return $inserted;
			}
		}else{
			return 'Table name or data array is Empty';
		}
		
	}


	////////////////////////////////////////////////////////////////////////

	/////////////////////////Update data from the DB///////////////////////////////////////////////
	public function updateData($table,$dataArray,$whereArray)
	{
		if(!empty($table) && !empty($dataArray) && !empty($whereArray)){
			$updated = $this->dbCon->update($table,$dataArray,$whereArray);
			if($updated=='1'){
		 		return true;
			}else{
				return $updated;
			}
		}else{
			return 'Table name,data array or where_clause is Empty';
		}
		
	}


	////////////////////////////////////////////////////////////////////////

	/////////////////////////Delete data from the DB///////////////////////////////////////////////
	public function deleteData($table,$whereArray)
	{
		if(!empty($table) && !empty($whereArray)){
			$deleted = $this->dbCon->delete($table,$whereArray);
			if($deleted=='1'){
		 		return true;
			}else{
				return $deleted;
			}
		}else{
			return 'Table name or where_clause is Empty';
		}
		
	}


	////////////////////////////////////////////////////////////////////////


	public function select1DB($query)
	{
		$recode_array = array();
	   
	    if(!empty($query)){
	    	$row = $this->dbCon->get_row($query);

	    	if(is_array($row)){
	    		$columns = array_keys((array)$row);
			   	foreach($columns as $column){
		            $recode_array[$column] = $row[$column];
		        }
        	    return $recode_array;
	    	}else{
	    		return $row;
	    	}
	    	
	    }else{
	    	return array('data' => 'Query is empty');
	    }

	}

	public function select1DBArray($query)
	{
		$recode_array = array();
	   
	    if(!empty($query)){
	    	$row = $this->dbCon->get_row_array($query);

	    	if(is_array($row)){
	    		$columns = array_keys((array)$row);
			   	foreach($columns as $column){
		            $recode_array[$column] = $row[$column];
		        }
        	    return $recode_array;
	    	}else{
	    		return $row;
	    	}
	    	
	    }else{
	    	return array('data' => 'Query is empty');
	    }

	}

///////////////////////////////////////////////////////////////////////
//{symbol:':'}
public function macFormat($mac,$pattern = '[]'){
	    $pattern = json_decode($pattern,true);

    if(key_exists("charCase",$pattern)){
        if($pattern["charCase"]=="upperCase"){
            $mac = strtoupper($mac);
		}elseif ($pattern['charCase']=="lowerCase"){
            $mac = strtolower($mac);
        }
    }
    if(key_exists("symbol",$pattern)){

        $mac = str_replace('-','',$mac);
        $mac = str_replace(':','',$mac);

        $mac_array = $mac;
        $mac = '';

        for($i=0;$i<=5;$i++){
            $mac.=$mac_array[($i*2)].$mac_array[(($i*2)+1)].$pattern['symbol'];
        }
        $mac = trim($mac,$pattern['symbol']);
    }
    if(key_exists('mask',$pattern)){
        if(key_exists('begin',$pattern['mask']) && key_exists('end',$pattern['mask']) && key_exists('symbol',$pattern['mask'])){
            //"begin"=>"1","end"=>"8","symbol"=>"*"   AA:AA:AA:AA:AA:AA
            $mac_values = 0;
            for($x=0;$x<=strlen($mac)-1;$x++){

                //$new_mac = '';
                if(preg_match('/^[a-fA-F0-9]$/',$mac[$x])){

                    $mac_values ++;
                    if($pattern['mask']['begin']==$mac_values || $mac_values==$pattern['mask']['end']){

                        $mac[$x] =  $pattern['mask']['symbol'];

                    }elseif($pattern['mask']['begin']<$mac_values && $mac_values<$pattern['mask']['end']){
                        $mac[$x]='!';
                        //$mac = substr_replace($mac,"",$x,1);
                    }
                }elseif($pattern['mask']['begin']<=$mac_values && $mac_values<=$pattern['mask']['end']){
                    //$mac[$x] =  "";
                }
            }
        }
        $mac = str_replace("!",'',$mac);
    }

    return $mac;

}


////////////////////////////////////////////////////////////////////////

public function setValDistributor($key,$distributor)
{
	if($key !== '' && $distributor!== ''){
		$query = "SELECT settings_value AS f FROM exp_settings WHERE settings_code = '$key' AND `distributor`='$distributor'";
		$query_results = $this->dbCon->query($query);
		if(is_array($query_results)){
			foreach ($query_results as $row){
				return $row['f'];
			}
		}else{
			return $query_results;
		}
	}else{
		return 'Key or Distributor is Empty';
	}
	
}

public function getNetwork($network,$field){
		

	if($field !== '' && $network!== ''){
		$query = "SELECT $field AS f FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";
		$query_results = $this->dbCon->query($query);
		if(is_array($query_results)){
			foreach ($query_results as $row){
				return $row['f'];
			}
		}else{
			return $query_results;
		}
	}else{
		return 'Field or Network is Empty';
	}
		
}


	
			

	public function execDB($query)
	{

		if(!empty($query)){
        	$ex = $this->dbCon->executeQuery($query);
      		// if($ex=='1'){
      		// 	return true;
      		// }else{
      		// 	return $ex;
			  // }
			  return $ex;

        }else{
        	return 'Query is Empty';
        }
	        
	}	

	public function escapeDB($query)
	{
	    
        if(!empty($query)){
        	$result = $this->dbCon->escape_string($query);
      		return $result;
        }else{
        	return $query;
        }

	}

	public function changeFeature(FeatureChange $dto){

	    /*$q = "INSERT INTO exp_service_activation_details(service_id,activation_type,distributor,distributor_type,reference,create_date,create_user,last_update,unixtimestamp)
VALUES('$dto->getServiceId()','$dto->getActivationType()','$dto->getDistributor()','$dto->getDistributor()','$dto->getDistributorType()','$dto->getReference()',NOW(),'$_SESSION[user_name]',UNIX_TIMESTAMP()) ";
	    $this->execDB($q);*/

	    require_once dirname(__FILE__).'/../models/serviceActivationController.php';
	    require_once dirname(__FILE__).'/../entity/service_activation_details.php';
	    $entity = new service_activation_details(
            null,
            $dto->getServiceId(),
            $dto->getActivationType(),
            $dto->getDistributor(),
            $dto->getDistributorType(),
            $dto->getReference(),
            date(''),
            $_SESSION['user_name'],
            null,
            null
        );

	    $dao = new serviceActivationController();
	    $dao->create_ServiceActivationDetails($entity);

    }

    ///////////////////////////
    public function ajaxAccess(array $modules,$product){
	    $allowed_page_q = "SELECT options FROM admin_product_controls WHERE feature_code='ALLOWED_PAGE' AND product_code='$product'";
	    $result = $this->select1DB($allowed_page_q)['options'];
        $allowed_pages = json_decode($result,true);
        $intersect = array_intersect($modules,$allowed_pages);

        if(count($intersect)>0){
            return true;
        }else{
            return false;
        }

    }


	////////////////////////////////////////////////////////////////////////

	public function setVal($key,$distributor)
	{
		
		if($key !== '' && $distributor!== ''){
		$query = "SELECT settings_value AS f FROM exp_settings WHERE distributor = '$distributor' AND settings_code = '$key'";
		$query_results = $this->dbCon->query($query);
			if(is_array($query_results)){
				foreach ($query_results as $row){
					return $row['f'];
				}
			}else{
				return $query_results;
			}
		}else{
			return 'Key or Distributor is Empty';
		}
	}

/////////////////////////////////////////////////////////
public function textTitle_vertical($key,$user_type,$vertical)
{
	
	if($key !== '' && $user_type!== '' && $vertical!== ''){
		$query = "SELECT title AS f FROM exp_texts WHERE distributor = '$user_type' AND text_code = '$key' AND vertical = '$vertical'";
		$query_results = $this->dbCon->query($query);
			if(is_array($query_results)){
				foreach ($query_results as $row){
					return $row['f'];
				}
			}else{
				return $query_results;
			}
		}else{
			return 'Key ,user_type or vertical is Empty';
		}
}

/////////////////////////////////////////////////////////
public function textVal_vertical($key,$user_type,$vertical)
{
	
	if($key !== '' && $user_type!== '' && $vertical!== ''){
		$query = "SELECT text_details AS f FROM exp_texts WHERE distributor = '$user_type' AND text_code = '$key' AND vertical = '$vertical'";
	$query_results = $this->dbCon->query($query);
		if(is_array($query_results)){
			foreach ($query_results as $row){
				return $row['f'];
			}
		}else{
			return $query_results;
		}
	}else{
		return 'Key ,user_type or vertical is Empty';
	}
}

	/////////////////////////////////////////////////////////
	
	
	/////////////////////////////////////////////////////////
	public function getSystemURL($url_type,$login_design,$reference = NULL)
	{
		$url_mod_override = strip_tags($this->setVal("url_mod_override", 'ADMIN'));
		$global_base_url = trim($this->setVal('global_url','ADMIN'),"/");
		$extension = $this->setVal('extentions','ADMIN');
		
		switch($url_type){
			
			case 'login':
				if($url_mod_override == 'ON' && (strlen($login_design)>0)){      
					$final_url = '/'.$login_design.'/login';
				}
				else if(strlen($login_design)==0){
					$final_url = '/';	
				}
				else{				
					$final_url = '/?login='.$login_design;
				}
				break;

			case 'verification':
				if($url_mod_override == 'ON' && (strlen($login_design)>0)){      
					$final_url = '/'.$login_design.'/verification';
				}
				else if(strlen($login_design)==0){
					$final_url = '/verification_login'.$extension;	
				}
				else{				
					$final_url = '/verification_login'.$extension.'?login='.$login_design;
				}
				break;
				
			case 'reset_pwd':
				if(strlen($reference)>0){
					if($url_mod_override == 'ON' && (strlen($login_design)>0)){      
						//$final_url = '/'.$login_design.'/reset_pwd'; //HTACCESS PENDING DEV
					 	$final_url = '/reset_password'.$extension.'?login='.$login_design.'&reset=pwd&reset_key='.$reference;						
					}
					else if(strlen($login_design)==0){
						$final_url = '/reset_password'.$extension.'?reset=pwd&reset_key='.$reference;
					}
					else{				
						$final_url = '/reset_password'.$extension.'?login='.$login_design.'&reset=pwd&reset_key='.$reference;
					}
					break;
				}
				else{
					if($url_mod_override == 'ON' && (strlen($login_design)>0)){      
						$final_url = '/'.$login_design.'/reset_pwd';
					}
					else if(strlen($login_design)==0){
						$final_url = '/reset_password'.$extension;
					}
					else{				
						$final_url = '/reset_password'.$extension.'?login='.$login_design;
					}
					break;
				}
				
			case 'reset_admin':
				if(strlen($reference)>0){
					if($url_mod_override == 'ON' && (strlen($login_design)>0)){      
						// $final_url = '/'.$login_design.'/reset_admin'; //HTACCESS PENDING DEV
						$final_url = '/reset_password_admin'.$extension.'?login='.$login_design.'&reset=pwd&reset_key='.$reference;
						
					}
					else if(strlen($login_design)==0){
						$final_url = '/reset_password_admin'.$extension.'&reset=pwd&reset_key='.$reference;
					}
					else{				
						$final_url = '/reset_password_admin'.$extension.'?login='.$login_design.'&reset=pwd&reset_key='.$reference;
					}
					break;					
				}
				else{
					if($url_mod_override == 'ON' && (strlen($login_design)>0)){      
						$final_url = '/'.$login_design.'/reset_admin';
					}
					else if(strlen($login_design)==0){
						$final_url = '/reset_password_admin'.$extension;
					}
					else{				
						$final_url = '/reset_password_admin'.$extension.'?login='.$login_design;
					}
					break;
				}
				
			
			case 'default':
				$final_url = '/';
				break;
				
		}
		return $global_base_url.$final_url;		
	}


	/////////////////////////////////////////////////////////
	
	
	
	/////////////////////////////////////////////////////////
	public function textVal($key,$user_type)
	{
		
		if($key !== '' && $user_type!== ''){
		$query = "SELECT text_details AS f FROM exp_texts WHERE distributor = '$user_type' AND text_code = '$key'";
		$query_results = $this->dbCon->query($query);
			if(is_array($query_results)){
				if (empty($query_results)) {
					$query = "SELECT text_details AS f FROM exp_texts WHERE distributor = 'N/A' AND text_code = '$key'";
					$query_results = $this->dbCon->query($query);
				}
				foreach ($query_results as $row){
					return $row['f'];
				}
			}else{
				return $query_results;
			}
		}else{
			return 'Key or user_type is Empty';
		}
	}


	/////////////////////////////////////////////////////////
	public function textTitle($key,$user_type)
	{
		
		if($key !== '' && $user_type!== ''){
		$query = "SELECT title AS f FROM exp_texts WHERE distributor = '$user_type' AND text_code = '$key'";
		$query_results = $this->dbCon->query($query);
			if(is_array($query_results)){
				foreach ($query_results as $row){
					return $row['f'];
				}
			}else{
				return $query_results;
			}
		}else{
			return 'Key or user_type is Empty';
		}
	}

	////////////////////////////////////////////////////////////////////////

	public function getValueAsf($query_as_f)
	{

		if($query_as_f !== ''){
		$query_results = $this->dbCon->query($query_as_f);
			if(is_array($query_results)){
				foreach ($query_results as $row){
					return $row['f'];
				}
			}else{
				return $query_results;
			}
		}else{
			return 'Query is Empty';
		}
	}


	
	
	////////////////////////////////////////////////////////////////////////

	public function userLog($user_name,$script,$task,$ref)
	{
	if(isset($_SESSION['remote'])){
		$user_name = $_SESSION['ori_user_uname'];
	}
	if(isset($_SESSION['p_token'])){
        parse_str($_SESSION['p_detail'],$parent_details);
        $user_name = $parent_details['s_uname'];
	}
	if(isset($_SESSION['s_token'])){
        parse_str($_SESSION['s_detail'],$support_details);
		$user_name = $support_details['s_uname'];
	}
	if(isset($_SESSION['user_distributor'])){
		$user_distributor = $_SESSION['user_distributor'];
	}	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

	

		$log = Logger::getLogger()->getObjectProvider()->getObjectUser();

		$log->setUsername($user_name);
		$log->setModuleId($script);
		$log->setTask($task);
		$log->setReference($ref);
		$log->setIP($ip);
		$log->setUserDistributor($user_distributor);

		Logger::getLogger()->InsertLog($log);
		return '1';
	}	

	public function queryLog($affected_property_id,$owner_user_distributor,$affected_user_distributor,$query_data,$task,$type,$error_description){

		$query_data = $this->escapeDB($query_data);
		$error_description = $this->escapeDB($error_description);

		$log_query = "INSERT INTO `query_error_logs` (
					  `affected_property_id`,
					  `owner_user_distributor`,
					  `affected_user_distributor`,
					  `query_data`,
					  `error_description`,
					  `task`,
					  `type`,
					  `create_date`,
					  `unixtimestamp`
					)
					VALUES
					  (
					    '$affected_property_id',
					    '$owner_user_distributor',
					    '$affected_user_distributor',
					    '$query_data',
					    '$error_description',
					    '$task',
					    '$type',
					    now(),
					    UNIX_TIMESTAMP()
					  )";

					$query_ex_log=$this->execDB($log_query);
	
					if(strlen($query_ex_log) > 0){
						return '0';
					}
					else{
						return '1';
					}
	}
	
	
	


	////////////////////////////////////////////////////////////////////////

	public function getTheme($theme_id,$language=NULL) {

		if(is_null($language)){
			$query =  "SELECT * FROM exp_themes WHERE theme_id = '$theme_id'";
		}
		else{
			$query =  "SELECT * FROM exp_themes WHERE theme_id = '$theme_id' AND `language` = '$language'";
		}
		if($theme_id !== ''){
		
		$query_results = $this->dbCon->query($query);
			if(is_array($query_results)){
				foreach ($query_results as $row){
					$result[] = $row;
				}
				return $result;
			}else{
				return $query_results;
			}
		}else{
			return 'Theme_id is Empty';
		}
	}


	////////////////////////////////////////////////////////////////////////

	public function setSocialVal($social_media,$key,$distributor)
	{
		

		if($social_media !== '' && $key !== '' && $distributor !== ''){
		$query = "SELECT `$key` AS f FROM exp_social_profile WHERE distributor = '$distributor' AND social_media = '$social_media'";
		$query_results = $this->dbCon->query($query);
			if(is_array($query_results)){
				foreach ($query_results as $row){
					return $row['f'];
				}
			}else{
				return $query_results;
			}
		}else{
			return 'Social_media,key or distributor is Empty';
		}
	}


	/////////////////////////////////////////////////////////////////////////
	public function getLogin($settings_code){
	
		if($settings_code !== ''){
		$query = "SELECT `settings_value` FROM `exp_settings` WHERE `settings_code` = '$settings_code' AND distributor = 'ADMIN'";
		$query_results = $this->dbCon->query($query);
			if(is_array($query_results)){
				foreach ($query_results as $row){
					return $row['settings_value'];
				}
			}else{
				return $query_results;
			}
		}else{
			return 'Settings code is Empty';
		}
	}


	
	


    /////////////////////////////////////////////////////////////////////////

    public function validateField($tag_id){

    	if($tag_id !== ''){
		$query = "SELECT validation FROM `admin_front_end_validation` WHERE `tag_id` = '$tag_id'";
		$query_results = $this->dbCon->query($query);
			if(is_array($query_results)){
				foreach ($query_results as $row){
					return $row['validation'];
				}
			}else{
				return $query_results;
			}
		}else{
			return 'Tag ID is Empty';
		}

    }

	//////////////////////////////////////////////////////////////////////////////////////////
	
	public function get_property($user)
	{
		
		if($user !== ''){

		$query = "SELECT o.property_number,o.property_id,o.ignore_on_search,o.validity_time, o.org_name 
		FROM mdu_organizations o, mdu_distributor_organizations u
		WHERE o.property_number = u.property_id
		AND u.distributor_code = '$user' AND NOT o.`delete_status` = '6'";

		// $query_results=mysql_query($query);
		
		// return $query_results;


		$query_results = $this->dbCon->query($query);
			
				return $query_results;
			

		}else{
			return 'Distributor code is Empty';
		}

	}

/////////////////////////////////////////////////////////
	
// public function getEmailTemplate($text_code,$product,$type,$distributor=NULL)
// 	{
// 		$count = 0;
// 		if(isset($distributor)){
// 		$query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' AND distributor = '$distributor'";
// 		$query_results=mysql_query($query);
// 		$count = mysql_num_rows($query_results);
// 		}
// 		if($count=='0'){
// 			$query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' AND distributor = '$product'";
// 			$query_results=mysql_query($query);
			
// 			if(mysql_num_rows($query_results)=='0'){
// 				$query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' AND distributor = '$type'";
// 				$query_results=mysql_query($query);
// 			}
// 		}
		
	

// 		$query_results = $this->dbCon->query($query);
// 		if(is_array($query_results)){
// 			foreach ($query_results as $row){
// 				$result[] = $row;
// 			}
// 			return $result;
// 		}else{
// 			return $query_results;
// 		}


// 	}	
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////

    
    public function getSupportProfile($mno, $distributor){
    	
    	if(!empty($mno) && !empty($distributor)){
    		$q1 = "SELECT sup_availability,sup_text,sup_mobile,sup_email FROM exp_support_profile WHERE distributor='$distributor'";
    		$re1 = $this->dbCon->query($q1);
    		if($this->dbCon->num_rows($q1)==0){
    			$q1 = "SELECT sup_availability,sup_text,sup_mobile,sup_email FROM exp_support_profile WHERE distributor='$mno'";
    			$re1 = $this->dbCon->query($q1);
    		}
    		if($this->dbCon->num_rows($q1)==0){
    			$q1 = "SELECT sup_availability,sup_text,sup_mobile,sup_email FROM exp_support_profile WHERE distributor='ADMIN'";
    			$re1 = $this->dbCon->query($q1);
    		}

    		foreach ($re1 as $row){
    		
    		    $result[] = $row;
    	    }
    	    return $result;
    	}else{
    		return 'MNO or distributor is Empty';
    	}
    	
    }

public function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}

		$theValue = $this->dbCon->escape_string($theValue);

		switch ($theType) {
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
			case "double":
				$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				break;
			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined":
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}


    public function getEmailTemplate($text_code,$product,$type,$distributor=NULL)
    {
        $count = 0;
        // if(isset($distributor)){
            $query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' ";
            //$query_results=mysql_query($query);
			// var_dump($query);die;
            $query_results=$this->dbCon->query($query);
			return $query_results;
			// var_dump($query_results);die;
        //    $count = $this->dbCon->num_rows($query);//mysql_num_rows($query_results);
        // }
        // if($count==0){
        //     $query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' AND distributor = '$product'";
        //     $query_results=$this->dbCon->query($query);

        //    if($this->dbCon->num_rows($query)==0){
        //         $query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' AND distributor = '$type'";
        //         $query_results=$this->dbCon->query($query);
        //     }
        // }

    //    foreach ($query_results as $row){
    //         $result[] = $row;
    //     }
    //     return $result;
    }

    public function getEmailTemplateVertical($text_code,$product,$type,$vertical,$distributor=NULL)
    {
        $result = $this->getEmailTemplateVerticalCheck($text_code,$product,$type,$vertical,$distributor);
		if(empty($result)){
			$result = $this->getEmailTemplateVerticalCheck($text_code,$product,$type,'All',$distributor);
		}
		return $result;
    }

	public function getEmailTemplateVerticalCheck($text_code,$product,$type,$vertical,$distributor=NULL){
		$count = 0;
        if(isset($distributor)){
            $query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' AND vertical='$vertical' AND distributor = '$distributor'";
            //$query_results=mysql_query($query);
            $query_results=$this->dbCon->query($query);
           $count = $this->dbCon->num_rows($query);//mysql_num_rows($query_results);
        }
        if($count==0){
            $query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' AND vertical='$vertical' AND distributor = '$product'";
            $query_results=$this->dbCon->query($query);

           if($this->dbCon->num_rows($query)==0){
                $query = "SELECT title, text_details FROM exp_texts WHERE text_code = '$text_code' AND vertical='$vertical' AND distributor = '$type'";
                $query_results=$this->dbCon->query($query);
            }
        }

       foreach ($query_results as $row){
            $result[] = $row;
        }
        return $result;
	}

    public function getManualReg($field, $mno, $distributor){ 

		$q1 = "SELECT `$field` FROM `exp_manual_reg_profile` WHERE `distributor` = '$distributor'";
		$re1 = $this->dbCon->query($q1);

		if($this->dbCon->num_rows($q1)==0){
			$q1 = "SELECT `$field` FROM `exp_manual_reg_profile` WHERE `distributor` = '$mno'";
			$re1 = $this->dbCon->query($q1);
		}

		if($this->dbCon->num_rows($q1)==0){
			$q1 = "SELECT `$field` FROM `exp_manual_reg_profile` WHERE `distributor` = 'ADMIN'";
			$re1 = $this->dbCon->query($q1);
		}


		
		foreach ($re1 as $row){
			$result = $row[$field];
		}
		return $result;
	}

    public function autoCommit()
	{

    	$ex = $this->dbCon->setAutoCommit();

		return $ex;
	        
	}

	public function commit()
	{

    	$ex = $this->dbCon->commit();

		return $ex;
	        
	}

	public function rollback()
	{

    	$ex = $this->dbCon->rollback();

		return $ex;
	        
	}

	public function insert_id(){
        return $this->dbCon->insert_id();
    }

}
