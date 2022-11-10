<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_WARNING);*/
include 'header_top.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
/* No cache*/
header("Cache-Control: no-cache, must-revalidate");
/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();

$users = [];
if(isset($_GET['section'])){
    $userSql = "SELECT id,full_name FROM admin_users WHERE user_type='".$_GET['section']."'";
    $userResults =$db->selectDB($userSql);
    $users = $userResults['data'];
}

?>
<head>
	<meta charset="utf-8">
	<title>Changing Portal</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<!--Alert message css-->
	<link rel="stylesheet" type="text/css" href="css/formValidation.css">
	<link rel="stylesheet" href="css/tablesaw.css">
	<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
	<!-- Add jQuery library -->
	<!-- <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	<!-- tool tip css -->
	<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
	<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
	<style>
		.ui-datepicker-calendar td>a {
			min-width: 0px !important;
		}
		.tooltipster-content p {

			width: 200px !important;
		}
	</style>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<!--table colimn show hide-->
	<script type="text/javascript" src="js/tablesaw.js"></script>
	<script type="text/javascript" src="js/tablesaw-init.js"></script>

	<?php
	include 'header.php';
	?>
		<div class="main">
			<div class="custom-tabs"></div>
			<div class="main-inner">
				<div class="container">
					<div class="row">
						<div class="span12">
                            <?php if(isset($_GET['section'])) { ?>
                            <div>
                                <select>
                                    <option value='0'>Select <?=$_GET['section']?> Account</option>
                                    <?php 
                                        if(!empty($users)) {
                                            foreach($users as $user) {
                                    ?>
                                                <option value='<?=$user['id']?>'><?=$user['full_name']?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <?php } ?>
                        </div>
						<!-- /span12 -->
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
	</body>
</html>