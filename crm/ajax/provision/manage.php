<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & E_NOTICE & E_WARNING);

session_start();
include_once '../../classes/dbClass.php';
include_once '../../classes/appClass.php';
include_once '../../classes/systemPackageClass.php';
require_once '../../classes/messageClass.php';

$db = new db_functions();
$package_functions = new package_functions();
$app = new app_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);
$message_functions=new message_functions($system_package);

//security layer
$package_functions->ajaxAccess(['provision'],$system_package);


include_once '../../classes/cryptojs-aes.php';

$data_secret = $db->setVal('data_secret','ADMIN');

$return_json = json_encode(array('error'=>'Error','data'=>''));

$main_key = $_POST['key'];
$request_data_ar = cryptoJsAesDecrypt($data_secret, $main_key);
//print_r($request_data_ar);

if(count($request_data_ar)>0){}else{echo $return_json;exit();}

function setPaginationView($count,$nextPage,$max){

	if($count > 1){

		if(round($max/2)<($nextPage+1)){
			$first = (($nextPage+1)-round($max/2));
			$x = '<li class="disabled"><a href="#">...</a></li>';
		}else{
			$first = 0;
			$x = '';
		}

		$last = $first + $max;
		$predis = '';
		$nxtdis = '';
		if($nextPage==0){
			$predis = 'disabled';
		}elseif($nextPage==($count-1)){
			$nxtdis = 'disabled';
		}else{ }

		for ($i=$first; $i < (int)$last; $i++) {
			if($count> $i){
				if($nextPage==$i){
					$active = 'btn btn';
				}else{
					$active = '';
				}
				$x .= '<li><a href="#" class="'.$active.'" data-pageNum="'.$i.'">'.($i+1).'</a></li>';
			}
		}

		if($count> ($last+1)){
			$x .= '<li class="disabled"><a href="#">...</a></li>';
		}

		if($count> $last){
			$x .= '<li><a href="#" data-pageNum="'.($count-1).'">'.$count.'</a></li>';
		}

		 $view = '<ul class="cusPagination"><li class="pre '.$predis.'"><a href="#" data-pageNum="'.($nextPage-1).'">Previous</a></li>'.$x.'<li class="nxt '.$nxtdis.'"><a href="#"  data-pageNum="'.($nextPage+1).'">Next</a></li></ul>';
	}else{
		$view = '';
	}

	return $view;
}

function setQuery($db,$fullCountQuery,$nextPage,$pageLength){
    $fullCountQueryResult = $db->selectDB($fullCountQuery);
    $fullcount = $fullCountQueryResult['rowCount'];
    $queryString = $fullCountQuery." LIMIT $pageLength";
    $pageCount = ceil($fullcount/$pageLength);
    $queryResult = array_slice($fullCountQueryResult['data'], ((int)$nextPage*$pageLength),$pageLength);
    return array('qData'=>$queryResult,'paginate'=>setPaginationView($pageCount,$nextPage,3));
}
//serror_log($request_data_ar);
$nextPage = 0;
$nextPage = $request_data_ar['nextPage'];
$pageLength = $request_data_ar['listsize'];
$user_name = $request_data_ar['user_name'];
$user_distributor = $request_data_ar['user_distributor'];
$type = $request_data_ar['type'];
$user_type = $request_data_ar['user_type'];
$system_package = $request_data_ar['system_package'];
$busId = $request_data_ar['busId'];
$accName = $request_data_ar['accName'];
$tblArr = array();
$like = "";
session_write_close();
if ($type == 'crmActiveAccounts') {
 $fullCountQuery = "SELECT id,business_name,property_id,`status` FROM exp_crm WHERE mno_id='$user_distributor' ";

	if (strlen($accName)>0) {
		$fullCountQuery .= " AND business_name = '".$accName."'";
	}if (strlen($busId)>0) {
		$fullCountQuery .= " AND property_id = '".$busId."'";
	}
	if($user_name != null){
		$fullCountQuery .= " AND create_user = '".$user_name."'";
	}
	$queryResult = setQuery($db,$fullCountQuery,$nextPage,$pageLength);
	foreach($queryResult['qData'] AS $row){
		$id = $row['id'];
		$status = $row['status'];
		$property_name = $row['business_name'];
		$property_id = $row['property_id'];

		if (strlen($status) < 1) {
		$status = 'Pending';
		}
		$dataArr = array($property_id,$property_name,$status,$id);
	    array_push($tblArr,$dataArr);
	}

}else{

$fullCountQuery = "SELECT id,property_details,`status` FROM exp_provisioning_properties WHERE mno_id='$user_distributor' AND `status`<>9 AND `status`<>4";
if($user_name != null){
	$fullCountQuery .= " AND create_user = '".$user_name."'";
}

$queryResult = setQuery($db,$fullCountQuery,$nextPage,$pageLength);

foreach($queryResult['qData'] AS $row){

    $property_details = json_decode($row['property_details'],true);

    $parent_tbl_id = $row['id'];

    $parent_id = $property_details['account_info']['business_id'];
    $parent_full_name = $property_details['account_info']['business_name'];

    if(strlen($busId)>0 && strlen($accName)>0){
        $pos1 = strpos($parent_id, $busId);
        $pos2 = strpos($parent_full_name, $accName);
        if($pos1 === false || $pos2 === false) {
            continue;
        }
    }
    else if(strlen($busId)>0){
        $pos1 = strpos($parent_id, $busId);
        if($pos1 === false) {
            continue;
        }
    }
    else if(strlen($accName)>0){
        $pos2 = strpos($parent_full_name, $accName);
        if($pos2 === false) {
            continue;
        }
    }

	$status;
	switch($row['status']){
		case 1:
			$status='Account Setup';
			break;
		case 2:
			$status='Location Setup';
			break;
		case 3:
			$status='Network Setup';
			break;
        case 4:
            $status = 'Provisioning Finished';
	}

    $parent_ac_name = htmlentities(str_replace("\\",'',$property_details['account_info']['business_name']));
    $parent_properties = count($property_details['property']);
    $dataArr = array($parent_id,$parent_ac_name,$parent_properties,$parent_tbl_id,$parent_full_name,$status);
    array_push($tblArr,$dataArr);
}
}
$return_json = json_encode(array("table"=>$tblArr,"paginate"=>$queryResult['paginate']));

echo cryptoJsAesEncrypt($data_secret,$return_json);
