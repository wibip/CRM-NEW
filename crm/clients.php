<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'header_top.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
/* No cache*/
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

/*classes & libraries*/
require_once 'classes/dbClass.php';
require_once './classes/CommonFunctions.php';
$db = new db_functions();
require_once dirname(__FILE__) . '/models/userMainModel.php';
$user_model = new userMainModel();
require_once dirname(__FILE__) . '/models/clientUserModel.php';
$client_model = new clientUserModel();
$url_mod_override = $db->setVal('url_mod_override', 'ADMIN');
$CommonFunctions = new CommonFunctions();
/*Get selected API profiles*/
$apiIds = $CommonFunctions->getSelectedApis($_SESSION['user_distributor']);
$api_profiles = null;
if (!empty($apiIds)) {
	$api_profiles = $CommonFunctions->getApiProfiles($apiIds);
}
$is_edit = false;
$showProperty = false;
$showLocation = false;
if(isset($_GET['property_id']) && $_GET['property_id'] > 0){
	$showProperty = true;
}
//load countries
$country_sql="SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                            UNION ALL
                            SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b";
$country_result = $db->selectDB($country_sql);

//load country states
$regions_sql="SELECT `states_code`, `description` FROM `exp_country_states` ORDER BY description";
$get_regions = $db->selectDB($regions_sql);
$s_a = '';
$s_a_val = '';
foreach ($get_regions['data'] as $state) {
    $s_a .= $state['description'].'|';
    $s_a_val .= $state['states_code'].'|';
}

$utc = new DateTimeZone('UTC');
$dt = new DateTime('now', $utc);

$page = 'Client';

?>

<head>
	<meta charset="utf-8">
	<title>Clients Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/formValidation.css">
	<!--Alert message css-->
	<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
	<!-- tool tip css -->
	<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
	<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
	<!--toggle column-->
	<link rel="stylesheet" href="css/tablesaw.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<!-- tool tip js -->
	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

	<style>
		.disabled {
			background-color: #eee;
			color: #aaa;
			cursor: text;
		}

		.pop-up{
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: none;
            z-index: 122;
        }
        .pop-up.show{
            display: block;
        }
        .pop-up-bg{
            background-color: rgba(76, 78, 100, 0.5);
            position: fixed;
            width: 100%;
            top: 0;
            bottom: 0;
            z-index: -1;
        }
        .pop-up-main{
            height: 100%;
        overflow: auto;
        text-align: center;
        width: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        }
        .pop-up-content{
            background: #fff;
        margin: auto;
        box-shadow: rgb(76 78 100 / 20%) 0px 6px 6px -3px;
        border-radius: 10px;
        padding: 40px;
        max-width: 800px;
        width: 100%;
        box-sizing: border-box;
        }
        .pop-up-content .form-double{
            display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
            -ms-flex-flow: row wrap;
                flex-flow: row wrap;
        -webkit-box-pack: justify;
            -ms-flex-pack: justify;
                justify-content: space-between;
        }
        .pop-up-content .form-double .control-group{
            width: 50%;
            text-align: left;
        }
        .pop-up-content .form-double .control-group input{
            width: 90% !important;
        }
        .pop-up-content form{
            margin-bottom: 0;
        }
        .pop-up-content form .actions{
            text-align: right;
        margin-top: 20px;
        }
        .pop-up-content form .actions button{
            margin-left: 5px;
        }.control-group.mask .controls div{
            position: relative;
            overflow: hidden;
        }
        .control-group.mask span{
            position: absolute;
            left: 0;
            height: 100%;
            background: #e4e4e4;
            border-radius: 10px;
            padding: 8px;
            box-sizing: border-box;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .control-group.mask input{
            /* padding-left: 50px; */
        }
	</style>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!--table colimn show hide-->
	<script type="text/javascript" src="js/tablesaw.js"></script>
	<script type="text/javascript" src="js/tablesaw-init.js"></script>
	<script type="text/javascript">

		var country_arr = new Array( "United States of America","Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

		// States
		var s_a = new Array();
		var s_a_val = new Array();
		s_a[0] = "";
		s_a_val[0] = "";
		<?php
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
	<?php
	include 'header.php';
	
	require_once 'layout/' . $camp_layout . '/config.php';

	// var_dump($script);
	// var_dump($user_distributor);
	// TAB Organization
	if (isset($_GET['t'])) {
		$variable_tab = 'tab' . $_GET['t'];
		$$variable_tab = 'set';
	} else {
		//initially page loading///
		$tab1 = "set";
	}

	$priority_zone_array = array(
		"America/New_York",
		"America/Chicago",
		"America/Denver",
		"America/Los_Angeles",
		"America/Anchorage",
		"Pacific/Honolulu",
	);

function userUpdateLog($user_id, $action_type, $action_by,$db)
{
		$update_query = "INSERT INTO `admin_users_update` (
															`user_name`,
															`password`,
															`access_role`,
															`user_type`,
															`user_distributor`,
															`full_name`,
															`email`,
															`language`,
															`mobile`,
															`is_enable`,
															`create_date`,
															`create_user`,
															`update_type`,
															`update_by`,
															`update_date`
															)(SELECT
															`user_name`,
															`password`,
															`access_role`,
															`user_type`,
															`user_distributor`,
															`full_name`,
															`email`,
															`language`,
															`mobile`,
															`is_enable`,
															`create_date`,
															`create_user`,
															'$action_type',
															'$action_by',
															NOW()
															FROM
															`crm_clients`
															WHERE id='$user_id')";
		$ex_update_log = $db->execDB($update_query);
		return $ex_update_log;
	}

	if (isset($_POST['submit_1'])) {
			if($_POST['is_edit'] == true) {
					$id = $_POST['id'];
					//$user_type = $_POST['user_type'];
					$api_profile = $_POST['api_profile'];
					$full_name = $_POST['full_name_1'];
					$email = htmlspecialchars($_POST['email_1']);
					$language = $_POST['language_1'];
					$timezone = $_POST['timezone_1'];
					$address_1 = htmlspecialchars($_POST['address_1']);
					$address_2 = htmlspecialchars($_POST['address_2']);
					$country = $_POST['country'];
					$state = $_POST['state'];
					$zip_code = htmlspecialchars($_POST['zip_code']);
					$mobile = htmlspecialchars($_POST['mobile_1']);		
					//update log//
					$ex_log = userUpdateLog($id, 'EDIT_PROFILE', $user_name,$db);

					if ($ex_log===true) {
						$get_user_detail_q = "SELECT u.user_name, u.email, u.user_name FROM crm_clients u WHERE u.id='$id' LIMIT 1";
						$user_details = $db->select1DB($get_user_detail_q);
						$edit_user_name = $user_details['user_name'];
						$old_email = $user_details['email'];
						$archive_q = "INSERT INTO `crm_clients_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
									SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$edit_user_name',NOW(),last_update,'update'
									FROM `crm_clients` WHERE id='$id'";
						$archive_result = $db->execDB($archive_q);

						$edit_query = 'UPDATE `crm_clients`
										SET `full_name` ="'.$full_name.'",
										`email` = "'.$email.'",
										`language` = "'.$language.'",
										`timezone` = "'.$timezone.'",
										`mobile` =  "'.$mobile.'",
										`bussiness_address1` = "'.$address_1.'",
										`bussiness_address2` = "'.$address_2.'",
										`country` = "'.$country.'",
										`state_region` = "'.$state.'",
										`zip` = "'.$zip_code.'",
										`api_profile` = "'.$api_profile.'" 
										WHERE `id` = '.$id;
										
						$edit_result = $db->execDB($edit_query);

						if ($email != $old_email && $edit_result===true) {
							$t = date("ymdhis", time());
							$string = $edit_user_name . '|' . $t . '|' . $email;
							$encript_resetkey = $app->encrypt_decrypt('encrypt', $string);
							$unique_key = $db->getValueAsf("SELECT REPLACE(UUID(),'-','') as f");
							$qq = "UPDATE admin_reset_password SET status = 'cancel' WHERE user_name='$edit_user_name' AND status='pending'";
							$rr = $db->execDB($qq);

							if ($rr===true) {
								$ip = $_SERVER['REMOTE_ADDR'];
								$q1 = "INSERT INTO admin_reset_password (user_name, status, security_key,unique_key, ip, create_date) VALUES('$edit_user_name', 'pending', '$encript_resetkey','$unique_key', '$ip', NOW())";
								//$r1 = mysql_query($q1);
								$r1 = $db->execDB($q1);
							}
							$support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package,$property_business_type);
						}

						if ($edit_result) {
							$message_response = str_replace("user","client",$message_functions->showNameMessage('role_edit_success', $edit_user_name));
							$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Modify Client',$id,'3001',$message_response);
							// $create_log->save('3001', $message_response, '');
							$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						} else {
							// $db->userErrorLog('2002', $user_name, 'script - ' . $script);
							$message_response = str_replace("user","client",$message_functions->showMessage('role_edit_failed', '2002'));
							$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify Client',$id,'2002',$message_response);
							$create_log->save('2002', $message_response, '');
							$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						}
					} else {
						$message_response = str_replace("user","client",$message_functions->showMessage('role_edit_failed', '2002'));
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify Client',$id,'2002',$message_response);
						// $db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$create_log->save('2002', $message_response, '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
					
					$tab2 = "set";
					$tab1 = "not";
			} else {
				$full_name = $_POST['full_name_1'];
				//get table auto increment
				$br_q = "SHOW TABLE STATUS LIKE 'crm_clients'";
				$result2=$db->selectDB($br_q);
		
				foreach($result2['data'] AS $rowe){
					$auto_inc = $rowe['Auto_increment'];
				}

				$new_user_name = htmlspecialchars(str_replace(' ', '_', strtolower(substr($full_name, 0, 5) . 'u' . $auto_inc)));
				$password  = CommonFunctions::randomPassword();

				$access_role = 'admin';
				$user_type = 'PROVISIONING';
				$api_profile = $_POST['api_profile'];
				$email = htmlspecialchars($_POST['email_1']);
				$language = $_POST['language_1'];
				$timezone = $_POST['timezone_1'];
				$address_1 = htmlspecialchars($_POST['address_1']);
				$address_2 = htmlspecialchars($_POST['address_2']);
				$country = $_POST['country'];
				$state = $_POST['state'];
				$zip_code = htmlspecialchars($_POST['zip_code']);
				$mobile = htmlspecialchars($_POST['mobile_1']);

				$pw_query = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(\"$password\"))))) AS f";
				$updated_pw='';
				$pw_results=$db->selectDB($pw_query);
				foreach($pw_results['data'] AS $row){
					$updated_pw = strtoupper($row['f']);
				}

				$query = "INSERT INTO admin_users
						(user_name, `password`, access_role, user_type, user_distributor, full_name, email, `language`, `timezone`,mobile, is_enable, create_date,create_user)
						VALUES ('$new_user_name','$updated_pw','$access_role','$user_type','$user_distributor','$full_name','$email', '$language' ,'$timezone', '$mobile','1',now(),'$user_name')";
				$ex =$db->execDB($query);

				if ($ex===true) {
					$idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
					$query_clients = 'INSERT INTO crm_clients
							(user_id,`api_profile`,user_name, `password`, access_role, user_type, user_distributor, full_name, email, `language`, `timezone`,`bussiness_address1`,`bussiness_address2`,`country`,`state_region`,`zip`, mobile, is_enable, create_date,create_user)
							VALUES ('.$idContAutoInc.',
									"'.$api_profile.'",
									"'.$new_user_name.'",
									"'.$updated_pw.'",
									"'.$access_role.'",
									"'.$user_type.'",
									"'.$user_distributor.'",
									"'.$full_name.'",
									"'.$email.'", 
									"'.$language.'" ,
									"'.$timezone.'",
									"'.$address_1.'", 
									"'.$address_2.'", 
									"'.$country.'", 
									"'.$state.'",
									"'.$zip_code.'", 
									"'.$mobile.'",
									2,
									now(),
									"'.$user_name.'")';
			    
					$result_clients =$db->execDB($query_clients);
					$message_response = str_replace("user","client",$message_functions->showNameMessage('user_create_success', $new_user_name));
					$_SESSION['msg2'] =  '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $message_response . '</strong></div>';
					//Activity log
					$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create Client',$idContAutoInc,'',$message_response);
				} else {
					$message_response = str_replace("user","client",$message_functions->showMessage('user_create_fail', '2001'));
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Client',0,'2001',$message_response." ".$ex);
					$_SESSION['msg2'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $message_response . '</strong></div>';
				} 
			}	
	}
	//  to the form edit user
	elseif (isset($_GET['edit_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
			$is_edit = true;
			$edit_id = $_GET['edit_id'];
			$edit_user_data = $client_model->getClient($edit_id);
			$tab2 = "set";
		} else {
			// var_dump('test');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Edit Client load',$_GET['edit_id'],'2002','Oops, It seems you have refreshed the page. Please try again');
			// $db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
			//header('Location: location.php?t=3');
			$tab2 = "set";
		}
	}
	 elseif (isset($_POST['edit-submita-pass'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
				$id = $_POST['id'];
				$passwd = $_POST['passwd'];
				$passwd_2 = $_POST['passwd_2'];
				if ($passwd == $passwd_2) {
					$user_id = $db->getValueAsf("SELECT u.user_id AS f FROM crm_clients u WHERE u.id='$id' LIMIT 1");
					$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM crm_clients u WHERE u.id='$id' LIMIT 1");
					//update log//
					$ex_log = userUpdateLog($id, 'RESET_PASSWORD', $user_name,$db);
					if ($ex_log===true) {
						$pw_query = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(\"$passwd\"))))) AS f";
						$updated_pw='';
						$pw_results=$db->selectDB($pw_query);

						foreach($pw_results['data'] AS $row){
							$updated_pw = strtoupper($row['f']);
						}

						$edit_query = "UPDATE `admin_users`
										SET `password` = '$updated_pw'
										WHERE `id` = '$user_id'";
						$edit_result = $db->execDB($edit_query);

						$edit_client_query = "UPDATE `crm_clients`
										SET `password` = '$updated_pw'
										WHERE `id` = '$id'";
						$edit_client_result = $db->execDB($edit_client_query);

						if ($edit_result===true) {
							$message_response = str_replace("user","client",$message_functions->showNameMessage('role_password_edit_success', $user_full_name));
							$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Client Password Reset',$id,'3001',$message_response);
							$create_log->save('3001', $message_response, '');
							$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						} else {
							$message_response = str_replace("user","client",$message_functions->showMessage('role_password_edit_failed', '2002'));
							$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Client Password Reset',$id,'2002',$message_response);
							// $db->userErrorLog('2002', $user_name, 'script - ' . $script);
							$create_log->save('2002', $message_response, '');
							$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						}
					} else {
						$message_response = str_replace("user","client",$message_functions->showMessage('role_password_edit_failed', '2002'));
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Client Password Reset',$id,'2002',$message_response);
						// $db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$create_log->save('2002', $message_response , '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response  . "</strong></div>";
					}
				} else {
					$message_response = str_replace("user","client",$message_functions->showMessage('role_password_edit_failed', '2006'));
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Client Password Reset',$id,'2006',$message_response);
					// $db->userErrorLog('2006', $user_name, 'script - ' . $script);
					$create_log->save('2006', $message_response, '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					//Password confirmation failed
				}
		} else {
			$message_response =  str_replace("user","client",$message_functions->showMessage('transection_fail', '2004'));
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Client Password Reset',$id,'2004',$message_response);
			// $db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $message_response, '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	}
	//login status change////
	elseif (isset($_GET['status_change_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) { 
				$status_change_id = $_GET['status_change_id'];
				$action_sts = $_GET['action_sts'];
				$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM crm_clients u WHERE u.id='$status_change_id' LIMIT 1");
				$usr_name = $db->getValueAsf("SELECT u.user_name AS f FROM crm_clients u WHERE u.id='$status_change_id' LIMIT 1");

				if ($action_sts == '1') {
					$action_type = "ACCOUNT_ENABLE";
					$set = 'enabled';
				} else {
					$action_type = "ACCOUNT_DISABLE";
					$set = 'disabled';
				}
				//update log//
				$ex_log = userUpdateLog($status_change_id, $action_type, $user_name,$db);

				if ($ex_log===true) {
					$archive_q = "INSERT INTO `crm_clients_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
								SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$user_name',NOW(),last_update,'status_change'
								FROM `crm_clients` WHERE id='$status_change_id'";
					$archive_result = $db->execDB($archive_q);

					$edit_query = "UPDATE  `crm_clients` SET `is_enable` = '$action_sts' WHERE `id` = '$status_change_id'";
					$edit_result = $db->execDB($edit_query);

					if ($edit_result===true) {
						$en_dis_msg = '';
						if ($set == 'enabled') {
							$message_response = str_replace("User","Client",$message_functions->showNameMessage('role_user_name_enable_success', $user_full_name));
							$en_dis_msg = 'Enable';
						} elseif ($set == 'disabled') {
							$message_response = str_replace("User","Client",$message_functions->showNameMessage('role_user_name_disable_success', $user_full_name));
							$en_dis_msg = 'Disable';
						}

						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Client Status Change',$status_change_id,'3001',$message_response);
						$create_log->save('3001', $message_response, '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . " </strong></div>";
					} else {
						$message_response = str_replace("User","Client",$message_functions->showMessage('role_user_name_enable_failed', '2001'));						
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Status Change',$status_change_id,'2001',$message_response);
						// $db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$create_log->save('2001', $message_response, '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					}
				} else {						
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Client Status Change',$status_change_id,'2002','[2002] Something went wrong,please try again');
					// $db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong> [2002] Something went wrong,please try again</strong></div>";
				}
		} else {
			$message_response = str_replace("User","Client",$message_functions->showMessage('transection_fail', '2004'));						
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Client Status Change',$status_change_id,'2004',$message_response);
			// $db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $message_response, '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>�</button><strong>" . $message_response . "</strong></div>";
		}
	}
	//client remove////
	elseif (isset($_GET['user_rm_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) { 
				$user_rm_id = $_GET['user_rm_id'];
				$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM crm_clients u WHERE u.id='$user_rm_id' LIMIT 1");
				$usr_name = $db->getValueAsf("SELECT u.user_name AS f FROM crm_clients u WHERE u.id='$user_rm_id' LIMIT 1");

				$archive_record = "INSERT INTO `crm_clients_archive` (
																		`id`,
																		`user_name`,
																		`password`,
																		`access_role`,
																		`user_type`,
																		`full_name`,
																		`email`,
																		`language`,
																		`mobile`,
																		`is_enable`,
																		`create_date`,
																		`create_user`,
																		`archive_by`,
																		`archive_date`
																		) (SELECT id,
																		`user_name`,
																		`password`,
																		`access_role`,
																		`user_type`,
																		`full_name`,
																		`email`,
																		`language`,
																		`mobile`,
																		`is_enable`,
																		`create_date`,
																		`create_user`,
																		'$user_name',
																		NOW()
																		FROM
																		`crm_clients`
																		WHERE id='$user_rm_id')";
				$archive_record = $db->execDB($archive_record);

                //print_r($archive_record);echo'--';
				if ($archive_record===true) {
					$edit_query = "DELETE FROM `crm_clients`  WHERE `id` = '$user_rm_id'";
					//$edit_result = mysql_query($edit_query);
					$edit_result = $db->execDB($edit_query);

					if ($edit_result===true) {
						$message_response = str_replace("User","Client",$message_functions->showNameMessage('user_remove_success', $user_full_name));
						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Remove Client',$user_rm_id,'3001',$message_response);
						$create_log->save('3001', $message_response, '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					} else {
						$message_response = str_replace("User","Client",$message_functions->showMessage('user_remove_success', '2002'));
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove Client',$user_rm_id,'2002',$message_response);
						// $db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$create_log->save('2002', $message_response, '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = str_replace("User","Client",$message_functions->showMessage('user_remove_success', '2002'));
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove Client',$user_rm_id,'2002',$message_response);
					// $db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$create_log->save('2002', $message_response, '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
				}
		} else {
			$message_response = str_replace("User","Client",$message_functions->showMessage('transection_fail', '2004'));
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove Client',$user_rm_id,'2004',$message_response);
			// $db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $message_response, '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
		}
	} 

	if (isset($_GET['property_edit'])) {
        $edit = true;
        $id = $_GET['property_id'];
        $result = $db->select1DB("SELECT * FROM exp_crm WHERE id = '$id'");
        $get_service_type = $result['service_type'];
        $get_business_name = $result['business_name'];
        $get_business_id = $result['business_id'];
        $get_contact_name = $result['contact_name'];
        $get_contact_phone = $result['contact_number'];
        $get_contact_email = $result['contact_email'];
        $get_order_number = $result['order_number'];
        $get_city = $result['city'];
        $get_zip = $result['zip'];
        $get_timezone = $result['timezone'];
        $get_account_number = $result['account_number'];
        $get_street = $result['street'];
        $get_state = $result['state'];
        $get_status= $result['status'];
        $wifi_unique = $result['property_id'];
        $get_wifi_unique = str_replace($get_opt_code, "", $wifi_unique);

        $result_wifi = json_decode($result['wifi_information'], true);
        $get_more_than_one_sites = $result_wifi['more_than_one_sites'];
        $get_guest_ssid = $result_wifi['guest_ssid'];
        $get_wifi_street = $result_wifi['wifi_street'];
        $get_wifi_state = $result_wifi['wifi_state'];
        $get_wifi_contact = $result_wifi['wifi_contact'];
        $get_wifi_email = $result_wifi['wifi_email'];
        $get_wifi_ins_time = $result_wifi['wifi_ins_time'];
        $get_wifi_site_name = $result_wifi['wifi_site_name'];
        $get_private_ssid = $result_wifi['private_ssid'];
        $get_wifi_city = $result_wifi['wifi_city'];
        $get_wifi_zip = $result_wifi['wifi_zip'];
        $get_wifi_phone = $result_wifi['wifi_phone'];
        $get_wifi_prop_type = $result_wifi['wifi_prop_type'];
        $get_wifi_ins_date = $result_wifi['wifi_ins_date'];
        $get_wifi_ins_start = $result_wifi['wifi_ins_start'];

        $result_product = json_decode($result['product_information'], true);
        $get_prod_order_type = $result_product['prod_order_type'];
        $get_prod_in_ap_quant = $result_product['prod_in_ap_quant'];
        $get_prod_content_filter = $result_product['prod_content_filter'];
        $get_prod_circuit_type = $result_product['prod_circuit_type'];
        $get_prod_guest = $result_product['prod_guest'];
        $get_prod_telco = $result_product['prod_telco'];
        $get_prod_cabling = $result_product['prod_cabling'];
        $get_prod_flow_plan = $result_product['prod_flow_plan'];
        $get_prod_cover_area = $result_product['prod_cover_area'];
        $get_prod_square_footage = $result_product['prod_square_footage'];
        $get_prod_outdoor = $result_product['prod_outdoor'];
        $get_prod_guest_capacity = $result_product['prod_guest_capacity'];
        $get_prod_circuit_size = $result_product['prod_circuit_size'];
        $get_prod_private = $result_product['prod_private'];
        $get_prod_rack_space = $result_product['prod_rack_space'];
        $get_prod_wiring_paths = $result_product['prod_wiring_paths'];
        $get_prod_telco_room = $result_product['prod_telco_room'];

        $result_qq = json_decode($result['qualifying_questions'], true);
        $get_qq_ceiling_hight = $result_qq['qq_ceiling_hight'];
        $get_qq_int_wall = $result_qq['qq_int_wall'];
        $get_qq_communicate_other = $result_qq['qq_communicate_other'];
        $get_qq_residential = $result_qq['qq_residential'];
        $get_qq_atmospheric = $result_qq['qq_atmospheric'];
        $get_qq_ceiling_type = $result_qq['qq_ceiling_type'];
        $get_qq_ext_wall = $result_qq['qq_ext_wall'];
        $get_qq_customizable_ui = $result_qq['qq_customizable_ui'];
        $get_qq_warehouse = $result_qq['qq_warehouse'];
        $get_qq_IoT_devices = $result_qq['qq-IoT-devices'];
    }
	//Form Refreshing avoid secret key/////
	$secret = md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;
	$users_mid = 'layout/' . $camp_layout . '/views/users_mid.php';
	if (($new_design == 'yes') && file_exists($users_mid)) {
		include_once $users_mid;
	} else {
	?>
		<div class="main">
			<div class="custom-tabs"></div>
			<div class="main-inner">
				<div class="container">
					<div class="row">
						<div class="span12">
							<div class="widget ">
								<div class="widget-header">
									<!-- <i class="icon-user"></i> -->
									<h3>Client Management</h3>
								</div>
								<!-- /widget-header -->
								<div class="widget-content">
									<div class="tabbable">
										<ul class="nav nav-tabs newTabs">
											<?php if ($showProperty == false && $showLocation == false ) { ?>
											<li <?php if (isset($tab1)) { ?>class="active" <?php } ?>><a href="#show_clients" data-toggle="tab">Manage Clients</a></li>
											<li <?php if (isset($tab2)) { ?>class="active" <?php } ?>><a href="#create_clients" data-toggle="tab"> <?=(isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? "Update" : "Create") ?> Clients</a></li>
											<?php } elseif($showProperty == true && $showLocation == false ) { ?>
											<li <?php if (isset($tab3) ) { ?>class="active" <?php } ?>><a href="#show_proprty" data-toggle="tab">Show Property</a></li>
											<?php } ?>
											<?php if($showLocation == true) { ?>
											<li <?php if (isset($tab4) ) { ?>class="active" <?php } ?>><a href="#show_location" data-toggle="tab">Show Location</a></li>
											<?php } ?>
										</ul>
										<br>
										<div class="tab-content">
											<!-- +++++++++++++++++++++++++++++ client list ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab1)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="show_clients">
												<h1 class="head">Manage Clients</h1>	
												<div id="response_d3"></div>
												<?php
													if(isset($tab1)){
														if (isset($_SESSION['msg5'])) {
															echo $_SESSION['msg5'];
															unset($_SESSION['msg5']);
														}

														if (isset($_SESSION['msg1'])) {
															echo $_SESSION['msg1'];
															unset($_SESSION['msg1']);
														}

														if (isset($_SESSION['msg2'])) {
															echo $_SESSION['msg2'];
															unset($_SESSION['msg2']);
														}

														if (isset($_SESSION['msg3'])) {
															echo $_SESSION['msg3'];
															unset($_SESSION['msg3']);
														}

														if (isset($_SESSION['msg6'])) {
															echo $_SESSION['msg6'];
															unset($_SESSION['msg6']);
														}
													}
												?>
												<div class="widget widget-table action-table">
													<div class="widget-header">
														<!-- <i class="icon-th-list"></i> -->
														<h3>Active Clients</h3>
													</div>
													<!-- /widget-header -->
													<div class="widget-content table_response">
														<div style="overflow-x:auto;">
															<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																<thead>
																	<tr>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Username</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Full Name</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Email</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Created By</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Edit</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Disable</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$query_results = $client_model->get_activeClients($user_distributor);
																	if(isset($query_results['rowCount']) && $query_results['rowCount'] > 0) {
																		foreach ($query_results['data'] as $row) {
																			$id = $row['id'];
																			$user_name1 = $row['user_name'];
																			$full_name = $row['full_name'];
																			$access_role = $row['access_role'];
																			$access_role_desc = $row['description'];
																			$user_distributor1 = $row['user_distributor'];
																			$email = $row['email'];
																			$is_enable = $row['is_enable'];
																			$create_user = $row['create_user'];

																			if ($is_enable == '1' || $is_enable == '2') {
																				$btn_icon = 'thumbs-down';
																				$show_value = '<font color="#00CC00"><strong>Enable</strong></font>';
																				$btn_color = 'warning';
																				$btn_title = 'disable';
																				$action_status = 0;
																			} else {
																				$btn_icon = 'thumbs-up';
																				$show_value = '<font color="#FF0000"><strong>Disable</strong></font>';
																				$btn_color = 'success';
																				$btn_title = 'enable';
																				$action_status = 1;
																			}

																			echo '<tr>
																					<td> ' . $user_name1 . ' </td>
																					<td> ' . $full_name . ' </td>
																					<td> ' . $email . ' </td>
																					<td> ' . $create_user . ' </td>';

																			echo '<td><a href="javascript:void();" id="APE_' . $id . '"  class="btn btn-small btn-primary">
																					<i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#APE_' . $id . '\').easyconfirm({locale: {
																							title: \'Edit Client\',
																							text: \'Are you sure you want to edit this client?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#APE_' . $id . '\').click(function() {
																							window.location = "?token=' . $secret . '&t=2&edit_id=' . $id . '"
																						});
																						});
																					</script></td><td><a href="javascript:void();" id="LS_' . $id . '"  class="btn btn-small btn-' . $btn_color . '">
																					<i class="btn-icon-only icon-' . $btn_icon . '"></i>&nbsp;' . ucfirst($btn_title) . '</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#LS_' . $id . '\').easyconfirm({locale: {
																							title: \'' . ucfirst($btn_title) . ' Client\',
																							text: \'Are you sure you want to ' . $btn_title . ' this client?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#LS_' . $id . '\').click(function() {
																							window.location = "?token=' . $secret . '&t=1&status_change_id=' . $id . '&action_sts=' . $action_status . '"
																						});
																						});
																					</script></td><td><a href="javascript:void();" id="RU_' . $id . '"  class="btn btn-small btn-danger">
																					<i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#RU_' . $id . '\').easyconfirm({locale: {
																							title: \'Remove Client\',
																							text: \'Are you sure you want to remove [' . $user_name1 . '] client?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#RU_' . $id . '\').click(function() {
																							window.location = "?token=' . $secret . '&t=1&user_rm_id=' . $id . '"
																						});
																						});
																					</script></td>';		
																			echo '</tr>';
																		}
																	} else {
																		echo '<tr><td colspan="6" style="text-align: center;">Results not found</td></tr>';
																	}
																	
																	?>
																</tbody>
															</table>
														</div>
													</div>
													<!-- /widget-content -->
												</div>
												<!-- /widget -->
											</div>

											<!-- +++++++++++++++++++++++++++++ create / update clients ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab2)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="create_clients">
												<h1 class="head"> <?=(isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? "Update": "Create")?> Clients</h1>
												<div id="response_d3"></div>
												<?php
													if(isset($tab2)){
														if (isset($_SESSION['msg5'])) {
															echo $_SESSION['msg5'];
															unset($_SESSION['msg5']);
														}

														if (isset($_SESSION['msg1'])) {
															echo $_SESSION['msg1'];
															unset($_SESSION['msg1']);
														}

														if (isset($_SESSION['msg2'])) {
															echo $_SESSION['msg2'];
															unset($_SESSION['msg2']);
														}

														if (isset($_SESSION['msg3'])) {
															echo $_SESSION['msg3'];
															unset($_SESSION['msg3']);
														}

														if (isset($_SESSION['msg6'])) {
															echo $_SESSION['msg6'];
															unset($_SESSION['msg6']);
														}
													}
												
														$id = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['id'] : 0);
														$user_name =  (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['user_name'] : "");
														$full_name = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['full_name'] : "");
														$email = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['email'] : "");
														$language_set = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['language'] : "");
														$timezone_set = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['timezone'] : "");
														$bussiness_address1 = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['bussiness_address1'] : "");													
														$bussiness_address2 = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['bussiness_address2'] : "");
														$country = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['country'] : "");
														$state_region = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['state_region'] : "");
														$zip = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['zip'] : "");
														$mobile = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['mobile'] : ""); 
														$selected_profile = (isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ? $edit_user_data[0]['api_profile'] : ""); 

													echo '<input type="hidden" name="form_secret" id="form_secret1" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<!-- action="controller/User_Controller.php" -->
												<form autocomplete="off" id="edit_profile" action="clients.php" method="post" class="form-horizontal">
													<fieldset>
														<input type="hidden" name="id" id="id" value="<?=$edit_id?>">
														<input type="hidden" name="is_edit" id="is_edit" value=<?=$is_edit?>">
														<input type="hidden" name="user_type" id="user_type1" value="<?=$user_type?>">
														<input type="hidden" name="loation" id="loation1" value="<?=$user_distributor?>">
														<!-- /control-group -->
														<div class="control-group">
															<label class="control-label" for="language_1">API profile</label>
															<div class="controls form-group col-lg-5">
																<select class="form-control span4" name="api_profile" id="api_profile">
																	<option value="">Select API profile</option>
																	<?php
																	foreach($api_profiles['data'] AS $row){
																		$apiId = $row['id'];
																		$profile = $row['api_profile'];
																		if ($apiId == $selected_profile) {
																			echo '<option value="'.$apiId.'" selected>' . $profile . '</option>';
																		} else {
																			echo '<option value="'.$apiId.'">' . $profile . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="control-group">
															<label class="control-label" for="full_name_1">Full Name<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5 form-group">
																<input class="form-control span4" id="full_name_1" name="full_name_1" maxlength="25" type="text" value="<?=$full_name?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
												
														<div class="control-group">
															<label class="control-label" for="email_1">Email<sup><font color="#FF0000"></font></sup></label>
															<div class="controls form-group col-lg-5">
																<input class="form-control span4" id="email_1" name="email_1" placeholder="name@mycompany.com" value="<?=$email?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->

														<div class="control-group">
															<label class="control-label" for="language_1">Language</label>
															<div class="controls form-group col-lg-5">
																<select class="form-control span4" name="language_1" id="language_1">
																	<?php
																	$key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";
																	$query_results=$db->selectDB($key_query);
																	foreach($query_results['data'] AS $row){
																		$language_code = $row['language_code'];
																		$language = $row['language'];
																		if ($language_code == $language_set) {
																			echo '<option value="' . $language_code . '" selected>' . $language . '</option>';
																		} else {
																			echo '<option value="' . $language_code . '">' . $language . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="control-group">
                                                            <label class="control-label" for="timezone_1">Time Zone<sup><font color="#FF0000"></font></sup></label>
                                                        	<div class="controls col-lg-5 form-group">
																<select class="span4 form-control" id="timezone_1" name="timezone_1" autocomplete="off">
																	<option value="">Select Time Zone</option>
																	<?php
																	$utc = new DateTimeZone('UTC');
																	$dt = new DateTime('now', $utc);

																	foreach ($priority_zone_array as $tz){
																		$current_tz = new DateTimeZone($tz);
																		$offset =  $current_tz->getOffset($dt);
																		$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
																		$abbr = $transition[0]['abbr'];
																		if($timezone_set==$tz){
																			$select="selected";
																		}else{
																			$select="";
																		}
																		echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
																	}
																	foreach(DateTimeZone::listIdentifiers() as $tz) {
																		//Skip
																		if(in_array($tz,$priority_zone_array))
																			continue;

																		$current_tz = new DateTimeZone($tz);
																		$offset =  $current_tz->getOffset($dt);
																		$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
																		$abbr = $transition[0]['abbr'];
																		
																		if($timezone_set==$tz){
																		$select="selected";
																		}else{
																			$select="";
																		}
																		echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
																	}
																	?>
																</select>
                                                             </div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="control-group">
															<label class="control-label" for="mobile_1">Phone Number<sup><font color="#FF0000"></font></sup></label>
															<div class="controls form-group col-lg-5">
																<input class="form-control span4" id="mobile_1" name="mobile_1" type="text" placeholder="xxx-xxx-xxxx" maxlength="12" value="<?=$mobile?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<script type="text/javascript">
															$(document).ready(function() {
																$("#mobile_1").keypress(function(event) {
																	var ew = event.which;
																	//alert(ew);
																	//if(ew == 8||ew == 0||ew == 46||ew == 45)
																	//if(ew == 8||ew == 0||ew == 45)
																	if (ew == 8 || ew == 0)
																		return true;
																	if (48 <= ew && ew <= 57)
																		return true;
																	return false;
																});

																$('#mobile_1').focus(function() {
																	$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
																	$('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
																});

																$('#mobile_1').keyup(function() {
																	$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
																	$('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
																});

																$("#mobile_1").keydown(function(e) {
																	var mac = $('#mobile_1').val();
																	var len = mac.length + 1;
																	if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
																		mac1 = mac.replace(/[^0-9]/g, '');
																	} else {
																		if (len == 4) {
																			$('#mobile_1').val(function() {
																				return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
																			});
																		} else if (len == 8) {
																			$('#mobile_1').val(function() {
																				return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
																				//console.log('mac2 ' + mac);

																			});
																		}
																	}
																	$('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
																});
															});
														</script>
														<div class="control-group">
															<label class="control-label" for="address_1">Address<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5 form-group">
																<input class="span4 form-control" id="address_1" placeholder="Address" name="address_1" type="text" value="<?=$bussiness_address1?>" autocomplete="off">
															</div>
														</div>
														<div class="control-group">
															<label class="control-label" for="address_2">City<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5 form-group">
																<input class="span4 form-control" id="address_2" placeholder="City" name="address_2" type="text" value="<?=$bussiness_address2?>" autocomplete="off">
															</div>
														</div>
														<div class="control-group">
															<label class="control-label" for="country" >Country<font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5 form-group">
																<select name="country" id="country" class="span4 form-control" autocomplete="off">
																	<option value="">Select Country</option>
																	<?php
																	
																	foreach ($country_result['data'] as $row) {
																		$select="";
																		if($row['a']==$country){
																			$select="selected";
																		}
																		echo '<option value="'.$row['a'].'" '.$select.'>'.$row['b'].'</option>';
																	}
																	?>
																</select>
															</div>
														</div>
														<script language="javascript">
															populateCountries("country", "state");
														</script>
														<div class="control-group">
															<label class="control-label" for="state">State/Region<font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5 form-group">
															<select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="state" placeholder="State or Region" name="state" required autocomplete="off">
																<?php
																	echo '<option value="">Select State</option>';
																	// var_dump($get_regions['data']);
																	foreach ($get_regions['data'] AS $state) {
																		//edit_state_region , get_edit_state_region
																		if($get_edit_state_region == 'N/A') {
																			echo '<option selected value="N/A">Others</option>';
																		} else {
																			if ($state_region == $state['states_code']) {
																				echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
																			} else {
																				echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
																			}
																		}
																		
																	}
																?>
																</select>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label" for="region">ZIP Code<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5 form-group">
																<input class="span4 form-control" id="zip_code" maxlength="5" placeholder="XXXXX" name="zip_code" type="text" value="<?=$zip?>" autocomplete="off">
															</div>
														</div>
														<script type="text/javascript">
															$(document).ready(function() {
																$("#zip_code").keydown(function (e) {
																	var mac = $('#zip_code').val();
																	var len = mac.length + 1;
																	// Allow: backspace, delete, tab, escape, enter, '-' and .
																	if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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
														</script>

														<div class="form-actions">
															<button type="submit" name="submit_1" id="submit_1" class="btn btn-primary"><?=(isset($_GET['edit_id']) ? "Update" : "Create")?> Account</button>&nbsp; <strong>
																<font color="#FF0000"></font><small></small>
															</strong>
															<?php if($is_edit == true){ ?> <button type="button" class="btn btn-info inline-btn"  onclick="goto();" class="btn btn-danger">Cancel</button> <?php } ?>
														</div>
														<!-- /form-actions -->
													</fieldset>
												</form>
												<script type="text/javascript">
													$(document).ready(function() {
														var editClient = <?php echo ($is_edit == true ? "true" : "false"); ?>;
														if(editClient == "false") {
															document.getElementById("submit_1").disabled = true;	
														} else {
															document.getElementById("submit_1").disabled = false;
														}
													});

													function goto(url){
														window.location = "?";
													}
												</script>
												<?php if(isset($_GET['edit_id']) && $_GET['edit_id'] > 0 ) { ?>
												<form onkeyup="footer_submitfn1();" onchange="footer_submitfn1();" autocomplete="off" id="edit-user-password" action="?t=1" method="post" class="form-horizontal">
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret2" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>
													<fieldset>
														<legend>Reset Password</legend>
														<?php
														echo '<input type="hidden" name="user_type" id="user_type3" value="' . $user_type . '">';
														echo '<input type="hidden" name="loation" id="loation3" value="' . $user_distributor . '">';
														echo '<input type="hidden" name="id" id="id1" value="' . $id . '">';
														?>
														<div class="control-group">
															<label class="control-label" for="full_name_2" _1>Password<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5">
																<input class="span4" id="passwd" name="passwd" type="password" required>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="control-group">
															<label class="control-label" for="email_2">Confirm Password<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5">
																<input class="span4" id="passwd_2" name="passwd_2" type="password" required="required">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="form-actions">
															<button type="submit" name="edit-submita-pass" id="edit-submita-pass" class="btn btn-primary" disabled="disabled">Save</button>&nbsp; <strong>
																<font color="#FF0000"></font><small></small>
															</strong>
															<button type="button" onclick="goto('?t=1')" class="btn btn-danger">Cancel</button>&nbsp;
														</div>
														<!-- /form-actions -->
													</fieldset>
												</form>

												<script>
													function footer_submitfn1() {
														$("#edit-submita-pass").prop('disabled', false);
													}
												</script>

												<!-- +++++++++++++++++++++++++++++ Show Property List ++++++++++++++++++++++++++++++++ -->
												<div class="widget widget-table action-table" style="padding-top: 35px;">
													<div class="widget-header">
														<i class="icon-th-list"></i>
														<h3>Active Properties</h3>
													</div>
													<!-- /widget-header -->
													<div class="widget-content table_response ">
														<div style="overflow-x:auto;" >
															<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																<thead>
																	<tr>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Unique Property ID</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Business Name</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Status</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Show Details</th>
																		<!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th> -->
																	</tr>
																</thead>
																<tbody>
																	<?php
																		$clientId = $_GET['edit_id'];
																		$clientUserName = '';
																		$user_details = $CommonFunctions->getAdminUserDetailsFromClient($clientId,'user_name');
																		if(!empty($user_details['data'])) {
																			$clientUserName = $user_details['data'][0]['user_name'];
																		}
																		
																	 	$propertyQuery = "SELECT id,business_name,property_id,`status` FROM exp_crm WHERE mno_id='$user_distributor' AND create_user = '".$clientUserName."' ORDER BY id DESC";
																		$query_results = $db->selectDB($propertyQuery);
																		if($query_results['rowCount'] > 0) {
																			foreach($query_results['data'] AS $row){
																				echo '<tr>
																				<td> '.$row['property_id'].' </td>
																				<td> '.$row['business_name'].' </td>
																				<td> '.$row['status'].' </td>';
																				echo '<td><a href="javascript:void();" id="VIEWACC_'.$row['id'].'"  class="btn btn-small btn-info">
																					<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
																					$(document).ready(function() {
																						$(\'#VIEWACC_' .$row['id'].'\').easyconfirm({
																							locale: {
																								title: \'Property View\',
																								text: \'Are you sure you want to view this property?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																								button: [\'Cancel\', \' Confirm\'],
																								closeText: \'close\'
																							}
																						});
																						$(\'#VIEWACC_'.$row['id'].'\').click(function () {
																							window.location = "?t=3&token='. $secret.'&property_edit&property_id='.$row['id'].'&client_id='.$_GET['edit_id'].'";
																						});
																					});
																					</script></td>';
																				
																				// if($_SESSION['SADMIN'] == true) {
																				// 	echo '<td><a href="javascript:void();" id="remove_api_'.$row['id'].'"  class="btn btn-small btn-danger">
																				// 	<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
																				// 	<script type="text/javascript">
																				// 		$(document).ready(function() {
																				// 			$(\'#remove_api_'.$row['id'].'\').easyconfirm({locale: {
																				// 					title: \'Remove Property\',
																				// 					text: \'Are you sure you want to remove this Property?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																				// 					button: [\'Cancel\',\' Confirm\'],
																				// 					closeText: \'close\'
																				// 			}});
																				// 			$(\'#remove_api_'.$row['id'].'\').click(function() {                                                                                        
																				// 				$("#overlay").css("display","block");
																				// 				window.location = "?token='.$secret.'&id='.$id.'&remove_location&location_id='.$locationId.'&location_unique='.$locationUnique.'&business_id='.$businessID.'"
																				// 			});
																				// 		});
																				// 	</script></td>';
																				// }
																				echo '</tr>';
																			}
																		} else {
																		?>
																		<tr>
																			<td colspan="6" style="text-align: center;">Properties not found</td>
																		</tr>
																		<?php
																		}	
																		
																		?>		
																</tbody>
															</table>
														</div>
													</div>
														<!-- /widget-content -->
													</div>
												<?php } ?>
											</div>

											<!-- +++++++++++++++++++++++++++++ Show Property details ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab3)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="show_proprties">
												<?php
													foreach ($modules["PROVISIONING"]["crm"] as $value) {
														//echo 'modules/'.$value['module'].'.php';
														$crmForm = './modules/' . $value['module'] . '.php';
														if($value['id'] == "crm_create") {
															include_once $crmForm ;
														}
													}

													if (isset($_GET['property_edit']) && $get_status == "Completed") {
													echo 'Test';
													?>
														<div class="widget widget-table action-table" style="padding-top: 35px;">
															<div class="widget-header">
																<i class="icon-th-list"></i>
																<h3>Active Profiles</h3>
															</div>
															<!-- /widget-header -->
															<div class="widget-content table_response ">
																<div style="overflow-x:auto;" >
																	<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																		<thead>
																			<tr>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Contact Name</th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">City</th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Zip</th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Status</th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th> 
																				<?php if($_SESSION['SADMIN'] == true) { ?>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>
																				<?php } ?>
																			</tr>
																		</thead>
																		<tbody>
																			<?php
																				$key_query="SELECT ceml.*,ec.business_id FROM crm_exp_mno_locations AS ceml INNER JOIN exp_crm AS ec ON ec.id = ceml.crm_id 
																				WHERE ceml.crm_id='".$_GET['property_id']."' ORDER BY ceml.id DESC";
																				$query_results = $db->selectDB($key_query);
																				if($query_results['rowCount'] > 0) {
																					foreach($query_results['data'] AS $row){
																						$contact_name = $row['contact_name'];
																						$city = $row['city'];
																						$zip = $row['zip'];
																						$businessID = $row['business_id'];
																						$locationUnique = $row['location_unique'];
				
																						switch($row['is_enable'] ) {
																							case 0 :
																								$is_enable = "Inactive";
																							break;
																							case 1 :
																								$is_enable = "Active";
																							break;
																							case 2 :
																								$is_enable = "Processing";
																							break;
																							default :
																								$is_enable = "Inactive";
																						}
				
																						$locationId = $row['id'];
				
																						echo '<tr>
																						<td> '.$contact_name.' </td>
																						<td> '.$city.' </td>
																						<td> '.$zip.' </td>
																						<td> '.$is_enable.' </td>';
																						echo '<td><a href="javascript:void();" id="AP_'.$locationId.'"  class="btn btn-small btn-info">
																							<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
																							$(document).ready(function() {
																							$(\'#AP_'.$locationId.'\').easyconfirm({locale: {
																									title: \'API Location\',
																									text: \'Are you sure you want to edit this API Location?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																									button: [\'Cancel\',\' Confirm\'],
																									closeText: \'close\'
																									}});
																								$(\'#AP_'.$locationId.'\').click(function() {
																										$("#overlay").css("display","block");
																										$(".pop-up .head").html("Update location");
																										$(".pop-up").addClass("show");
																										$.ajax({
																											type: "POST",
																											url: "ajax/load_location_details.php",
																											data: {
																												api_id: "'.$api_id.'",
																												system_package: "'.$system_package.'",
																												business_id: "'.$businessID.'",
																												location_id: "'.$locationUnique.'"
																											},
																											success: function(data) {
																												data = JSON.parse(data);
																												console.log(data);
																												if(data == false){
																													$("#overlay").css("display","none");
																													$(".pop-up").removeClass("show");
																													$("body").css("overflow","auto");                                                                                                    
																												} else {
																													
																													$("#locationForm #wifi_unique").attr("value","'.$wifi_unique.'");
																													$("#locationForm #business_id").attr("value","'.$get_business_id.'");
																													$("#locationForm #location_name").attr("value", data["locations"]["0"]["name"]);
																													$("#locationForm #location_unique").attr("value", data["locations"]["0"]["id"]);
																													$("#locationForm #location_unique").attr("name", "location_unique_display");
																													$("#locationForm input[name=location_unique_display]").attr("id", "location_unique_display");
																													$("#locationForm #location_unique_display").attr("disabled", true) ;
																													$("<input>").attr({
																														type: "hidden",
																														id: "location_id",
																														name: "location_id",
																														value: "'.$locationId.'"
																													}).appendTo("#locationForm");
																													$("<input>").attr({
																														type: "hidden",
																														id: "location_unique",
																														name: "location_unique",
																														value: data["locations"]["0"]["id"]
																													}).appendTo("#locationForm");
				
																													$("#locationForm #contact").attr("value", data["locations"]["0"]["contact"]["name"]);
																													$("#locationForm #contact_email").attr("value",data["locations"]["0"]["contact"]["email"]);
																													$("#locationForm #street").attr("value",data["locations"]["0"]["address"]["street"]);
																													$("#locationForm #city").attr("value",data["locations"]["0"]["address"]["city"]);
																													$("#locationForm #state option[value="+data["locations"]["0"]["address"]["state"]+"]").attr("selected", "selected");
																													$("#locationForm #zip").attr("value",data["locations"]["0"]["address"]["zip"]);
																													$(".popup_submit").html("Update");
																													$(".popup_submit").attr("name", "update_location_submit");
																													$(".popup_submit").attr("id", "update_location_submit");
																													$("#overlay").css("display","none");
																												}
																											},
																											error: function() {
																												$("#overlay").css("display","none");
																												$(".pop-up").removeClass("show");
																												$("body").css("overflow","auto"); 
																											}
																										});
																										$("body").css("overflow","hidden");
																								});
																								});
																							</script></td>';
																						
																						if($_SESSION['SADMIN'] == true) {
																							echo '<td><a href="javascript:void();" id="remove_api_'.$locationId.'"  class="btn btn-small btn-danger">
																							<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
																							<script type="text/javascript">
																								$(document).ready(function() {
																									$(\'#remove_api_'.$locationId.'\').easyconfirm({locale: {
																											title: \'API Location\',
																											text: \'Are you sure you want to remove this API Location?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																											button: [\'Cancel\',\' Confirm\'],
																											closeText: \'close\'
																									}});
																									$(\'#remove_api_'.$locationId.'\').click(function() {                                                                                        
																										$("#overlay").css("display","block");
																										window.location = "?token='.$secret.'&id='.$id.'&remove_location&location_id='.$locationId.'&location_unique='.$locationUnique.'&business_id='.$businessID.'"
																									});
																								});
																							</script></td>';
																						}
																						echo '</tr>';
																					}
																				} else {
																				?>
																				<tr>
																					<td colspan="6" style="text-align: center;">Locations not found</td>
																				</tr>
																				<?php
																				}	
																				
																				?>		
																		</tbody>
																	</table>
																</div>
															</div>
																<!-- /widget-content -->
														</div>
													<?php
													}
													?>
											</div>
										</div>
									</div>
									<!-- /widget-content -->
								</div>
							</div>
							<!-- /widget -->
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
	<?php } ?>
	<div class="pop-up">
        <div class="pop-up-bg"></div>
        <div class="pop-up-main">
            <div class="pop-up-content">Test</div>
		</div>
	</div>
	<script type="text/javascript" src="js/formValidation.js"></script>
	<script type="text/javascript" src="js/bootstrap_form.js"></script>
	<script type="text/javascript" src="js/bootstrapValidator_new.js?v=14"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			//create user form validation
			$('#edit_profile').bootstrapValidator({
				framework: 'bootstrap',
				xcluded: [':disabled', '[readonly]',':hidden', ':not(:visible)'],
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					full_name_1: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php echo $db->validateField('person_full_name'); ?>,
							<?php echo $db->validateField('not_require_special_character'); ?>
						}
					},
					email_1: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php echo $db->validateField('email_cant_upper'); ?>
							<?php echo $db->validateField('email'); ?>
						}
					},
					timezone_1: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					mobile_1: {
						validators: {
							<?php echo $db->validateField('mobile'); ?>
						}
					}
				}
			}).on('status.field.bv', function(e, data) {
				var editClient = <?php echo ($is_edit == true ? "true" : "false"); ?>;
				if(editClient == "false") {
					if ($('#edit_profile').data('bootstrapValidator').isValid()) {
						data.bv.disableSubmitButtons(false);
					} else {
						data.bv.disableSubmitButtons(true);
					}
				}
				
			});
		});

		$('.pop-up').addClass('show');
	</script>

	<?php
	include 'footer.php';
	?>

	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$("#loation").chained("#user_type");
		});
	</script>

	<!-- Alert messages js-->
	<script type="text/javascript" src="js/jquery.form.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#submit_1").easyconfirm({
				locale: {
					title: '<?=($is_edit == true ? "Edit" : "New")?> Client Account',
					text: 'Are you sure you want to <?=($is_edit == true ? "update" : "save")?> this client?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#submit_1").click(function() {});

			$("#edit-submita-pass").easyconfirm({
				locale: {
					title: 'Password Reset',
					text: 'Are you sure you want to update this password?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#edit-submita-pass").click(function() {});
		});
	</script>
	<style type="text/css">
		.ms-container {
			display: inline-block !important;
		}
	</style>

	<script type="text/javascript">
		function GetXmlHttpObject() {
			var xmlHttp = null;
			try {
				// Firefox, Opera 8.0+, Safari
				xmlHttp = new XMLHttpRequest();
			} catch (e) {
				//Internet Explorer
				try {
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
			}
			return xmlHttp;
		}
	</script>

	<script src="js/jquery.multi-select.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			checkModules();
		});

		function checkModules() {
		}
	</script>

	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	</body>

</html>