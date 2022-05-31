<?php

session_start();
header("Cache-Control: no-cache, must-revalidate");
error_reporting(E_ALL & E_NOTICE & E_WARNING);

require_once '../classes/dbClass.php';
require_once '../classes/systemPackageClass.php';

$package_functions=new package_functions();

$db = new db_functions();


$user_distributor = $_POST['user_distributor'];
$realm = $_POST['vertical'];
$system_package = $_POST['system_package'];

$user_name = $_POST['user_name'];
$user_type = $_POST['user_type'];


?>

<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>


<script id="ajax_load_tc">


tinymce.init({

selector: "textarea.submit_tocta",

theme: "modern",

removed_menuitems: 'visualaid',

height: 250,

plugins: [

	"lists charmap",

	"searchreplace wordcount code nonbreaking",

	"contextmenu directionality paste textcolor"

],



toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

font_formats: "Andale Mono=andale mono,times;"+

"Arial=arial,helvetica,sans-serif;"+

"Arial Black=arial black,avant garde;"+

"Book Antiqua=book antiqua,palatino;"+

"Comic Sans MS=comic sans ms,sans-serif;"+

"Courier New=courier new,courier;"+

"Georgia=georgia,palatino;"+

"Helvetica=helvetica;"+

"Impact=impact,chicago;"+

"Symbol=symbol;"+

"Tahoma=tahoma,arial,helvetica,sans-serif;"+

"Terminal=terminal,monaco;"+

"Times New Roman=times new roman,times;"+

"Trebuchet MS=trebuchet ms,geneva;"+

"Verdana=verdana,geneva;"+

"Webdings=webdings;"+

"Wingdings=wingdings,zapf dingbats",

		
init_instance_callback: function (editor) {
editor.on('change', function (e) {
		submit_tocfn();
});
}

});

</script>

<?php

if ($user_type == 'MVNO' || $user_type == 'MVNE') {
	$system_package=$package_functions->getDistributorMONPackage($user_name);
}


 if($package_functions->getSectionType('CAPTIVE_TOC_TYPE',$system_package)=="checkbox"){
	$text_arr = $db->textVal_vertical('TOC',$user_distributor,$realm);
	

		if(empty($text_arr)){
			$text_arr = $db->textVal_vertical('TOC', $user_distributor, 'ALL');
			if(empty($text_arr)){
			$text_arr = $db->textVal('TOC',$system_package);
		}
		}
	
	$text_arr1 = json_decode($text_arr, true);
	
echo '



			<div class="control-group" id="feild_gp_taddg_divt1">
				<label class="control-label" for="gt_mvnx">TOC 1</label>

								<div class="controls col-lg-5 ">
								  <textarea width="100%" id="toc1" name="toc1" class="span6">'. print_r($text_arr1['toc1']) .'</textarea>
			</div>
							</div>
							<div class="control-group" id="feild_gp_taddg_divt1">
								<label class="control-label" for="gt_mvnx">TOC 2</label>
								<div class="controls col-lg-5 ">
								<textarea width="100%" id="toc2" name="toc2" class="span6">'. print_r($text_arr1['toc2']) .'</textarea>
			</div>
							</div>
							<div class="control-group" id="feild_gp_taddg_divt1">
								<label class="control-label" for="gt_mvnx">TOC 3</label>
								<div class="controls col-lg-5 ">
								  <textarea width="100%" id="toc3" name="toc3" class="span6">'. print_r($text_arr1['toc3']) .'</textarea>
			</div>
							</div>
							<div class="control-group" id="feild_gp_taddg_divt1">
								<label class="control-label" for="gt_mvnx">TOC 4</label>
								<div class="controls col-lg-5 ">
								 <textarea width="100%" id="toc4" name="toc4" class="span6">'. print_r($text_arr1['toc4']) .'</textarea>
			</div>
							</div>
							<div class="control-group" id="feild_gp_taddg_divt1">
								<label class="control-label" for="gt_mvnx">TOC 5</label>
								<div class="controls col-lg-5 ">
								 <textarea width="100%" id="toc5" name="toc5" class="span6">'. print_r($text_arr1['toc5']) .'</textarea>
			</div>
							</div>
							<div class="control-group" id="feild_gp_taddg_divt1">
								<label class="control-label" for="gt_mvnx">SUBMIT</label>
								<div class="controls col-lg-5 ">
								<textarea width="100%" id="submit" name="submit" class="span6">'. print_r($text_arr1['submit']) .'</textarea>
			</div>
							</div>
							<div class="control-group" id="feild_gp_taddg_divt1">
								<label class="control-label" for="gt_mvnx">CANCEL</label>
								<div class="controls col-lg-5">
							   <textarea width="100%" id="cancel" name="cancel" class="span6">'. print_r($text_arr1['cancel']) .'</textarea>
</div>
							</div>


'; }else{
	

	//if($vertical != 'All'){
	$text_arr = $db->textVal_vertical('TOC',$user_distributor,$realm);
	

	
		if(empty($text_arr)){
			$text_arr = $db->textVal_vertical('TOC', $user_distributor, 'ALL');
			if(empty($text_arr)){
			$text_arr = $db->textVal('TOC',$system_package);
		}
		}

		echo	'	<textarea width="100%" id="toc1" name="toc1" class="submit_tocta">'. $text_arr .'</textarea>














';

 }

?>



