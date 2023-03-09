<?php
//include_once("connect.php");

require_once dirname(__FILE__) . '/../db/dbTasks.php';
require_once __DIR__ . '/systemPackageClass.php';

class db_functions extends dbTasks
{

	private $packageClass;
	//public  $dbCon;

	public function __construct()
	{
		//Connect::getConnect();
		parent::__construct();

		/*global $dbConnection;
		$this->dbCon=& $dbConnection;*/
	}

	private function get_package_class()
	{
		if (is_null($this->packageClass))
			$this->packageClass = new package_functions();

		return $this->packageClass;
	}

	///////////////////////////////////////////////////////////

	public function userErrorLog($error_id, $user_name, $error_details = null)
	{

		//$q1 = "INSERT INTO `admin_error_log` (`error_id`, `user_name`, `error_details`, `create_date`) VALUES ('$error_id', '$user_name', '$error_details', now())";
		$data = [
			'error_id' => $error_id,
			'user_name' => $user_name,
			'error_details' => $error_details,
			'create_date' => ['SQL' => 'NOW()'],
		];
		$re1 = $this->insertData('admin_error_log', $data);
		return 1;
	}

	//////////////////////////////////////////////////////////////////////////////

	public function updateSetVal($setting_code, $setting_val, $user = 'ADMIN')
	{

		$update_setting = $this->execDB("UPDATE
					  `exp_settings`
					SET
					  `settings_value` = '$setting_val',
					  `last_update` = NOW()
					WHERE `settings_code` = '$setting_code'
					AND `distributor` = '$user'");
		if ($update_setting === true) {
			return true;
		} else {
			return false;
		}
	}

	function numRows($query)
	{
		return $this->getNumRows($query);
	}



	public function createTemplate($src, $uni_id, $name)
	{
		$template_id = $uni_id;
		$template_name = $name . ' Business Default';
		$src1 = $src . 'dynamic_default';
		$des = $src . $template_id;
		self::recurse_copy($src1, $des);

		$tem_q = "INSERT INTO `exp_template` (`template_id`, `name`, `is_enable`, `image_up_type`, `logo_details`, `hide_divs`, `create_date`, `options`, `cash_clear`, `default_theme`, `last_update`, `updated_by`) 
		VALUES ('$template_id', '$template_name', '1', '{\"upload1\":\"1\",\"upload2\":\"1\",\"verticle\":\"0\",\"horizontal\":\"0\"}', '{\"upload1_name\":\"Background\",\"upload1_desc\":\"(GIF, JPEG or PNG, Recommended 1600px*1000px)\",\"upload2_name\":\"Logo\",\"upload2_desc\":\"(GIF, JPEG or PNG, Recommended 130px*60px)\"}', 'ios,ios2,backcolor1n2,st3img,other_parameters,wback,footera,greeting_txt_div,backcolor,banner-def-txt,step5,hrcolor,logo_1_txt_div', '2018-03-09 01:39:30', '{\"text\":[{\"id\":\"fontcolor_txt\",\"text\":\"Banner Font Color\"},{\"id\":\"logo_1_title\",\"text\":\"Background or Background Color\"},{\"id\":\"banner-under-txt\",\"text\":\"Up to 30 characters including space\"},{\"id\":\"logo_2_title\",\"text\":\"Logo\"},{\"id\":\"alttxt2 .control-label\",\"text\":\"Logo Alternative Text\"},{\"id\":\"mregbtn .control-label\",\"text\":\"Button Text\"},{\"id\":\"logo2_img_note\",\"text\":\"Note: Best fit image ratio 7:4 and maximum image size 200kb.\"}],\"placeholder\":[{\"id\":\"welcome\",\"placeholder\":\"Banner Text\"}],\"no_validate\":[{\"id\":\"logo1_up_bc\"}]}\r\n', 'dev', '$template_id', NOW(), NULL)";

		$query = "INSERT INTO `exp_themes` (
			  `theme_id`,
			  `theme_name`,
			  `theme_type`,
			  `splash_url`,
			  `redirect_type`,
			  `template_name`,
			  `ref_id`,
			  `location_ssid`,
			  `distributor`,
			  `language`,
			  `language_string`,
			  `title`,
			  `registration_type`,
			  `social_login_txt`,
			  `manual_login_txt`,
			  `welcome_txt`,
			  `greeting_txt`,
			  `toc_txt`,
			  `loading_txt`,
			  `welcome_back_txt`,
			  `registration_btn`,
			  `connect_btn`,
			  `fb_btn`,
			  `first_name_text`,
			  `last_name_text`,
			  `male_field`,
			  `female_field`,
			  `email_field`,
			  `age_group_field`,
			  `gender_field`,
			  `manual_login_fields`,
			   mobile_number_fields,
			   other_fields,
			   extra_fields,
			  `login_name_field`,
			  `login_secret_field`,
			  `accept_text`,
			  `cna_page_text`,
			  `cna_button_text`,
			  `btn_color`,
			  `btn_color_disable`,
			  `btn_border`,
			  `btn_text_color`,
			  `bg_color_1`,
			  `bg_color_2`,
			  `hr_color`,
			  `theme_logo`,
			  `theme_bg_image`,
			  `theme_horizontal_image`,
			  `theme_verticle_image`,
			  `duotone_bg_color`,
			  `duotone_form_color`,
			  `theme_details_id`,
			  `is_enable`,
			  `create_date`,
			  `last_update`,
			  `updated_by`
			)
			SELECT
			  '$template_id',
			  '$template_name',
			  `theme_type`,
			  `splash_url`,
			  `redirect_type`,
			  '$template_id',
			  `ref_id`,
			  `location_ssid`,
			  `distributor`,
			  `language`,
			  `language_string`,
			  `title`,
			  `registration_type`,
			  `social_login_txt`,
			  `manual_login_txt`,
			  `welcome_txt`,
			  `greeting_txt`,
			  `toc_txt`,
			  `loading_txt`,
			  `welcome_back_txt`,
			  `registration_btn`,
			  `connect_btn`,
			  `fb_btn`,
			  `first_name_text`,
			  `last_name_text`,
			  `male_field`,
			  `female_field`,
			  `email_field`,
			  `age_group_field`,
			  `gender_field`,
			  `manual_login_fields`,
			   mobile_number_fields,
			   other_fields,
			   extra_fields,
			  `login_name_field`,
			  `login_secret_field`,
			  `accept_text`,
			  `cna_page_text`,
			  `cna_button_text`,
			  `btn_color`,
			  `btn_color_disable`,
			  `btn_border`,
			  `btn_text_color`,
			  `bg_color_1`,
			  `bg_color_2`,
			  `hr_color`,
			  `theme_logo`,
			  `theme_bg_image`,
			  `theme_horizontal_image`,
			  `theme_verticle_image`,
			  `duotone_bg_color`,
			  `duotone_form_color`,
			  '$template_id',
			  `is_enable`,
			  `create_date`,
			  `last_update`,
			  `updated_by`
			FROM
			  `exp_themes`
			WHERE
			 `theme_id` ='dynamic_default_new'";

		$row = $this->select1DB("SELECT theme_data FROM exp_themes_details
			 WHERE  unique_id='dynamic_default_new'");

		$theme_q = $row['theme_data'];

		$isDynamic = package_functions::isDynamic($uni_id);
		$primary_color = '';
		if ($isDynamic) {
			$primary_color = $this->get_package_class()->getOptionsBranding('PRIMARY_COLOR', $uni_id);
		}

		$theme_vars = array(
			'{$primary_color}' => $primary_color
		);

		$theme_data = strtr($theme_q, $theme_vars);

		$query1 = "INSERT INTO exp_themes_details
		(unique_id, theme_data,completed,create_date,updated_by)
		VALUES ('$template_id', '$theme_data',1,NOW(),'admin')";

		$query_results = $this->execDB($query);
		$query_results1 = $this->execDB($tem_q);
		$query_results2 = $this->execDB($query1);

		if ($query_results === true && $query_results1 === true && $query_results2 === true) {
			return true;
		} else {
			return false;
		}
	}

	public function addLogs($user_name, $log_type, $user_type, $page, $section, $related_id=0,$detail_id=0, $log_details = null){
		$data = [
			'user_name' => $user_name,
			'log_type' => $log_type,
			'user_type' => $user_type,
			'page' => $page,
			'section' => $section,
			'related_id' => $related_id,
			'detail_id' => $detail_id,
			'log_details' => $log_details,
			'create_date' => ['SQL' => 'NOW()'],
		];
		$re1 = $this->insertData('crm_user_logs', $data);
		return 1;
	}

	public function addApiLogs($name,$description, $log_type, $section, $url,$request, $response, $status_code, $create_user=null){
		$data = [
			'name' => $name,
			'section' => $section,
			'log_type' => $log_type,
			'description' => $description,
			'url' => $url,
			'request' => $request,
			'response' => $response,
			'status_code' => $status_code,
			'create_user' =>$create_user,
			'create_date' => ['SQL' => 'NOW()'],
		];
		$re1 = $this->insertData('crm_api_logs', $data);
		return 1;
	}

	public function getDataFromLogsField($field){
		$sql = "SELECT DISTINCT ".$field." FROM crm_user_logs";
		$result = $this->selectDB($sql);
		// var_dump($result['data']);
		if($result['rowCount'] > 0) {
			return $result['data'];
		} else {
			return false;
		}
		
	}

	public function getDataFromApiLogsField($field, $groupBy = null){
		$sql = "SELECT DISTINCT ".$field." FROM crm_api_logs";
		if($groupBy != null) {
			$sql .= " GROUP BY ".$groupBy;
		}
		// echo $sql;
		$result = $this->selectDB($sql);
		// var_dump($result['data']);
		if($result['rowCount'] > 0) {
			return $result['data'];
		} else {
			return false;
		}
		
	}

	public function getLogsByFilters($start_date,$end_date,$limit=50,$userName = null,$logType=null,$page=null) {
		$sql = "SELECT user_name,log_type,page,log_details,create_date FROM crm_user_logs 
				WHERE TRUE ";

		if ($start_date != null && $end_date != null) {
			$sql.=" AND create_date BETWEEN '".$start_date."' AND '".$end_date."'";
		}

		if($userName != null) {
			$sql.=" AND user_name='".$userName."'";
		}
		if($logType != null) {
			$sql.=" AND log_type='".$logType."'";
		}
		if($page != null) {
			$sql.=" AND page='".$page."'";
		}
		$sql.=" ORDER BY id DESC";
        $sql.=" LIMIT ".$limit;
// echo $sql;
		$data = $this->selectDB($sql);

		return $data['data'];
	}


	public function getApiLogsByFilters($start_date,$end_date,$limit=50,$name = null,$logType=null,$section=null) {
		$sql = "SELECT name,section,log_type,description,create_date FROM crm_api_logs 
				WHERE TRUE ";

		if ($start_date != null && $end_date != null) {
			$sql.=" AND create_date BETWEEN '".$start_date."' AND '".$end_date."'";
		}
		if($name != null) {
			$sql.=" AND `name`='".$name."'";
		}
		if($logType != null) {
			$sql.=" AND log_type='".$logType."'";
		}
		if($section != null) {
			$sql.=" AND section='".$section."'";
		}

		$sql.=" ORDER BY id DESC";
        $sql.=" LIMIT ".$limit;

		$data = $this->selectDB($sql);

		return $data['data'];
	}


	private static function recurse_copy($src, $dst)
	{
		$dir = opendir($src);
		@mkdir($dst);
		while (false !== ($file = readdir($dir))) {
			if (($file != '.') && ($file != '..')) {
				if (is_dir($src . '/' . $file)) {
					self::recurse_copy($src . '/' . $file, $dst . '/' . $file);
				} else {
					copy($src . '/' . $file, $dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}
}
