
<?php ob_start();?>
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
$db = new db_functions();

require_once 'classes/CommonFunctions.php';
?> 
<head>
<meta charset="utf-8">
<title>Manage APIs</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<!--Alert message css--> 
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<!--    <link rel="stylesheet" href="css/bootstrapValidator.css"/> -->
<link rel="stylesheet" type="text/css" href="css/formValidation.css">
<link rel="stylesheet" href="css/tablesaw.css?v1.0">
<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/locationpicker.jquery.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--table colimn show hide-->
<script type="text/javascript" src="js/tablesaw.js"></script>
<script type="text/javascript" src="js/tablesaw-init.js"></script>
<!--table colimn show hide-->
 <!--Encryption -->
<script type="text/javascript" src="js/aes.js"></script>
<script type="text/javascript" src="js/aes-json-format.js"></script>
<?php
include 'header.php';
if($user_type == 'ADMIN'){
$tab8 = "set";
}
if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE'){
    $tab5 = "set";
}
require_once './classes/systemPackageClass.php';
$package_functions = new package_functions();
//load countries
$country_sql="SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                            UNION ALL
                            SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b";
$country_result = $db->selectDB($country_sql);
// var_dump($country_result);
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
?>
<style>
#live_camp .tablesaw-columntoggle-popup .btn-group > label {
    float: left !important;
}
</style>
<script language="javascript">
  // Countries
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
<div class="main" >
		<div class="main-inner" >
			<div class="container">
				<div class="row">
					<div class="span12">
                   
						<div class="widget ">

							<div class="widget-content">
								<div class="tabbable">
									<ul class="nav nav-tabs">
                                    <?php
                                    if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE'){
									?>
											<li <?php if(isset($tab9)){?>class="active" <?php }?>><a href="#active_op" data-toggle="tab">Activate</a></li>
									<?php
										}
                                        if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE'){
                                            if(!in_array('support', $access_modules_list) || $edit_account=='1') {
                                    ?>
                                            <li <?php if (isset($tab5)){ ?>class="active" <?php } ?>><a href="#create_operation" data-toggle="tab"><?php if ($edit_account == '1') echo 'Edit SMB Account'; else echo 'Create'; ?></a></li>
                                    <?php
                                            }

                                            if(in_array('support', $access_modules_list) && isset($_GET['assign_loc_admin'])) {
                                    ?>
                                                <li class="active" ><a  href="#assign_loc_admin" data-toggle="tab">Assign Property Admin</a></li>
                                    <?php
                                            }
                                        }
                                     if($user_type == 'ADMIN'){ ?>
                                        <li <?php if(isset($tab8)){?>class="active" <?php }?>><a href="#active_operations" data-toggle="tab">Active Operations</a></li>
                                    <?php }
										if($user_type == 'ADMIN'){
									?>
										<li <?php if(isset($tab6)){?>class="active" <?php }?>><a href="#operation_account" data-toggle="tab"><?php if($mno_edit==1){echo"Edit Operations Account";}else{echo"Create Operations Account";};?></a></li>
									<?php }
                                        if($user_type == 'ADMIN'){
                                    ?>
                                        <!--<li < ?php if(isset($tab11)){?>class="active" < ?php }?>><a href="#saved_mno" data-toggle="tab">Pending Account Activation Operations</a></li>-->
                                    <?php } ?>
									</ul>
									<br>
									<div class="tab-content">
                                        <!-- **************Create Operations Account********************** -->
                                        <div <?php if(isset($tab6)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="operation_account">

                                            <form onkeyup="submit_mno_formfn();" onchange="submit_mno_formfn();" id="mno_form" name="mno_form" class="form-horizontal" method="POST" action="location.php?<?php if($mno_edit==1){echo "t=8&mno_edit=1&mno_edit_id=$edit_mno_id";}else{echo "t=6";}?>" >
                                                <?php
                                                echo '<input type="hidden" name="form_secret6" id="form_secret6" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                ?>

                                                <fieldset>

                                                <div id="response_mno">

                                                </div>
                                                <style type="text/css">
                                                    .ms-container{
                                                        display: inline-block !important;
                                                    }
                                                </style>
                                                    <div class="control-group mno_feature" style="">
                                                        <label class="control-label" for="api_profile">API Profile<sup>
                                                                <font color="#FF0000"></font>
                                                            </sup></label>
                                                        <div class="controls col-lg-5 form-group" readonly>
                                                            <select onchange="add_module(this)" multiple="multiple" name="api_profile[]" id="api_profile" class="span4 form-control">
                                                                <option>DMZ Demo - Frontier</option>
                                                                <option>DMZ Demo - AT&T</option>
                                                                <option>DMZ Demo - Co</option>
                                                            </select>
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_account_name">Operations Name<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control form-control" id="mno_account_name" placeholder="Frontier" name="mno_account_name" type="text" value="<?php echo $get_edit_mno_description;?>">
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->
                                                    <!-- /control-group -->
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_account_name">BI System Name<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control form-control" id="mno_account_name" placeholder="Frontier DMZ" name="mno_account_name" type="text" value="<?php echo$get_edit_mno_description;?>">
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->
                                                    
                                                    <?php
                                                    $mno_operator_check="SELECT p.product_code,p.`product_name`,c.options
                                                                            FROM `admin_product` p LEFT JOIN admin_product_controls c ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                                                            WHERE `is_enable` = '1' AND p.`user_type` = 'MNO'";

                                                    $mno_op=$db->selectDB($mno_operator_check);

                                                    if ($mno_op['rowCount']>1) {
                                                    ?>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_sys_package">Operations Type<sup><font color="#FF0000"></font></sup></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <select name="mno_sys_package" id="mno_sys_package"  class="span4 form-control form-control" <?php if($mno_edit==1) echo "readonly";?>>
                                                                    <option value="">Select Type of Operator</option>
                                                                    <?php
                                                                        if($user_type == 'ADMIN'){
                                                                            foreach($mno_op['data'] AS $mno_op_row){
                                                                                if($get_edit_mno_sys_pack==$mno_op_row[product_code]){
                                                                                    $select="selected";
                                                                                }else{
                                                                                    $select="";
                                                                                }
                                                                                echo '<option '.$select.' value='.$mno_op_row[product_code].' data-vt="'.$mno_op_row[options].'" >'.$mno_op_row[product_name].'</option>';
                                                                            }
                                                                          }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->
                                                        <?php
                                                    }

                                                    ?>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_first_name">Admin First Name<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_first_name" maxlength="12" placeholder="First Name" name="mno_first_name" type="text" value="<?php echo$get_edit_mno_first_name;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_last_name">Admin Last Name<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_last_name" maxlength="12" placeholder="Last Name" name="mno_last_name" type="text" value="<?php echo$get_edit_mno_last_name;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_email">Admin Email<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com" value="<?php echo$get_edit_mno_email;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_address_1">Address<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo$get_edit_mno_ad1;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_address_2">City<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo $get_edit_mno_ad2;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_country" >Country<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off">
                                                                <option value="">Select Country</option>
                                                                <?php
                                                                $select="";
                                                                foreach ($country_result['data'] as $row) {
                                                                    // if($row[a]==$get_edit_mno_country || $row[a]== "US"){
                                                                    //     $select="selected";
                                                                    // }
                                                                    echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <script language="javascript">
                                                       populateCountries("mno_country", "mno_state");
                                                    </script>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                        <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
                                                            <?php
                                                                echo '<option value="">Select State</option>';
                                                                foreach ($get_regions as $state) {
                                                                    //edit_state_region , get_edit_mno_state_region
                                                                    // if($get_edit_mno_state_region==$state['states_code']) {
                                                                    //     echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                    // }else{
                                                                        echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                    // }
                                                                }
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_region">ZIP Code<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                        <script type="text/javascript">
                                                        $(document).ready(function() {
                                                            $("#mno_zip_code").keydown(function (e) {
                                                                var mac = $('#mno_zip_code').val();
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

                                                        <div class="control-group">
                                                                <label class="control-label" for="mno_mobile">Phone Number 1<sup><font color="#FF0000"></font></sup></label>
                                                                <div class="controls col-lg-5 form-group">
                                                                    <input class="span4 form-control" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_mobile?>" autocomplete="off">
                                                                </div>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(document).ready(function() {
                                                                $('#mno_form #mno_mobile_1').focus(function(){
                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                });

                                                                $('#mno_form #mno_mobile_1').keyup(function(){
                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                });

                                                                $("#mno_form #mno_mobile_1").keydown(function (e) {
                                                                    var mac = $('#mno_form #mno_mobile_1').val();
                                                                    var len = mac.length + 1;
                                                                    if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                        mac1 = mac.replace(/[^0-9]/g, '');
                                                                    }
                                                                    else{
                                                                        return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);

                                                                        if(len == 4){
                                                                            $('#mno_form #mno_mobile_1').val(function() {
                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                                //console.log('mac1 ' + mac);

                                                                            });
                                                                        }
                                                                        else if(len == 8 ){
                                                                            $('#mno_form #mno_mobile_1').val(function() {
                                                                                return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                                //console.log('mac2 ' + mac);

                                                                            });
                                                                        }
                                                                    }

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
                                                            <div class="control-group">
                                                                <label class="control-label" for="mno_mobile">Phone Number 2<sup><font color="#FF0000"></font></sup></label>
                                                                <div class="controls col-lg-5 form-group">

                                                                    <input class="span4 form-control" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone2?>" autocomplete="off" >
                                                                </div>
                                                            </div>

                                                            <script type="text/javascript">

                                                                $(document).ready(function() {
                                                                    $('#mno_mobile_2').focus(function(){
                                                                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                    });
                                                                    $('#mno_mobile_2').keyup(function(){
                                                                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                    });
                                                                    $("#mno_mobile_2").keydown(function (e) {
                                                                        var mac = $('#mno_mobile_2').val();
                                                                        var len = mac.length + 1;
                                                                        if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                            mac1 = mac.replace(/[^0-9]/g, '');
                                                                        }
                                                                        else{
                                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);
                                                                        }
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
                                                                <div class="control-group">
                                                                        <label class="control-label" for="mno_mobile">Phone Number 3<sup><font color="#FF0000"></font></sup></label>
                                                                        <div class="controls col-lg-5 form-group">
                                                                            <input class="span4 form-control" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone3?>" autocomplete="off">
                                                                        </div>
                                                                    </div>

                                                                    <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                            $('#mno_mobile_3').focus(function(){
                                                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                            });
                                                                            $('#mno_mobile_3').keyup(function(){
                                                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                            });
                                                                            $("#mno_mobile_3").keydown(function (e) {
                                                                                var mac = $('#mno_mobile_3').val();
                                                                                var len = mac.length + 1;
                                                                                if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                                    mac1 = mac.replace(/[^0-9]/g, '');
                                                                                }
                                                                                else{
                                                                                    return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);
                                                                                    }
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

                                                                        <div class="control-group">
                                                                            <label class="control-label" for="mno_timezone">Time Zone<sup><font color="#FF0000"></font></sup></label>
                                                                            <div class="controls col-lg-5 form-group">
                                                                                <select class="span4 form-control" id="mno_time_zone" name="mno_time_zone" autocomplete="off">
                                                                                    <option value="">Select Time Zone</option>
                                                                                    <?php
                                                                                    foreach ($priority_zone_array as $tz){
                                                                                        $current_tz = new DateTimeZone($tz);
                                                                                        $offset =  $current_tz->getOffset($dt);
                                                                                        $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                                        $abbr = $transition[0]['abbr'];
                                                                                        if($get_edit_mno_timezones==$tz){
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
                                                                                        /*if($abbr=="EST" || $abbr=="CT" || $abbr=="MT" || $abbr=="PST" || $abbr=="AKST" || $abbr=="HST" || $abbr=="EDT"){
                                                                                        echo $get_edit_mno_timezones;*/
                                                                                        if($get_edit_mno_timezones==$tz){
                                                                                            $select="selected";
                                                                                        }else{
                                                                                            $select="";
                                                                                        }
                                                                                        echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                                        // $select="";
                                                                                        /*}*/
                                                                                    }

                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-actions">
                                                                                <button disabled type="submit" id="submit_mno_form" name="submit_mno_form" class="btn btn-primary"><?php if($mno_edit==1){echo "Update Account";}else{echo "Create Account";}?></button>
                                                                                <?php if($mno_edit==1){ ?> <button type="button" class="btn btn-info inline-btn"  onclick="goto();" class="btn btn-danger">Cancel</button> <?php } ?>
                                                                        </div>
                                                                        <script>
                                                                            function submit_mno_formfn() {
                                                                                //alert("fn");
                                                                                $("#submit_mno_form").prop('disabled', false);
                                                                            }

                                                                            function goto(url){
                                                                            window.location = "?";
                                                                            }
                                                                        </script>
                                                            <!-- /form-actions -->
                                                                </fieldset>
                                                        </form>
                                                <!-- /widget -->
                                            </div>
                                        
                                        <!-- ***************Activate Accounts List******************* -->
                                        <div <?php if(isset($tab8)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="active_operations">
											<div id="response_d1"></div>
											<div class="widget widget-table action-table">
												<div class="widget-header">
													<h3>Active Operations</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
                                                    <div style="overflow-x:auto">
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Operations</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Controller</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Edit</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Remove</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $key_query = "SELECT m.mno_description,m.mno_id,u.full_name, u.email , u.verification_number
                                                                                    FROM exp_mno m, admin_users u
                                                                                    WHERE u.user_type = 'MNO' AND u.user_distributor = m.mno_id AND u.`is_enable`=1 AND u.`access_role`='admin'
                                                                                    GROUP BY m.mno_id
                                                                                    ORDER BY mno_description ";
                                                                    $query_results = $db->selectDB($key_queryq1);
                                                                    foreach ($query_results['data'] as $row) {
                                                                        $mno_description = $row[mno_description];
                                                                        $mno_id = $row[mno_id];
                                                                        $full_name = $row[full_name];
                                                                        $email = $row[email];
                                                                        $s= $row[s];
                                                                        $is_enable= $row[is_enable];
                                                                        $icomm_num=$row[verification_number];

                                                                        $key_query01 = "SELECT ap_controller
                                                                                    FROM exp_mno_ap_controller
                                                                                    WHERE mno_id='$mno_id'";
                                                                        $query_results01 = $db->selectDB($key_query01);
                                                                        $ap_c="";
                                                                        foreach ($query_results01 as $row1) {
                                                                            $apc=$row1[ap_controller];
                                                                            $ap_c.=$apc.',';
                                                                        }
                                                                        echo '<tr>
                                                                        <td> '.$mno_description.' </td>
                                                                        <td> '.trim($ap_c, ",").' </td>	';
                                                                        echo '<td> '.

                                                                            //******************************** Edit ************************************
                                                                            '<a href="javascript:void();" id="EDITMNOACC_'.$mno_id.'"  class="btn btn-small btn-info">
                                                                            <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
                                                                            $(document).ready(function() {
                                                                                $(\'#EDITMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                                                    title: \'Account Edit\',
                                                                                    text: \'Are you sure you want to edit this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                                    closeText: \'close\'
                                                                                    }});

                                                                                $(\'#EDITMNOACC_'.$mno_id.'\').click(function() {
                                                                                    window.location = "?token10='.$secret.'&t=6&edit_mno_id='.$mno_id.'"
                                                                                });
                                                                            });

                                                                            </script></td>';
                                                                            $distributor_exi = "SELECT * FROM `exp_mno_distributor` WHERE mno_id = '$mno_id'";
                                                                            $query_results01 = $db->selectDB($distributor_exi);
                                                                            $count_records_exi = count($query_results01);
                                                                            if($count_records_exi == 0){

                                                                            //*********************************** Remove  *****************************************
                                                                            echo '<td><a href="javascript:void();" id="REMMNOACC_'.$mno_id.'"  class="btn btn-small btn-danger">

                                                                            <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                                                                    $(document).ready(function() {
                                                                                                    $(\'#REMMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                                                                            title: \'Account Remove\',
                                                                                                            text: \'Are you sure you want to remove this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                            button: [\'Cancel\',\' Confirm\'],
                                                                                                            closeText: \'close\'
                                                                                                            }});

                                                                                                        $(\'#REMMNOACC_'.$mno_id.'\').click(function() {
                                                                                                            window.location = "?token10='.$secret.'&t=8&remove_mno_id='.$mno_id.'"

                                                                                });
                                                                                });
                                                                            </script>';


                                                                            }else{

                                                                                echo '<td><a class="btn btn-small btn-warning" disabled >&nbsp;<i class="icon icon-lock"></i>Remove</a></center>';
                                                                            }
                                                                        //****************************************************************************************
                                                                        echo ' </td>';
                                                                        echo '</tr>';
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

                                        <!-- ***************Operation Account Create********************** -->
                                        <div <?php if(isset($tab5)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="create_operation">
                                            <div class="support_head_visible" style="display:none;"><div class="header_hr"></div><div class="header_f1" style="width: 100%;">Account Info</div>
                                                <br class="hide-sm"><br class="hide-sm"><div class="header_f2" style="width: 100%;"> </div></div>
                                                <form onkeyup="location_formfn();" onchange="location_formfn();"   autocomplete="off"   id="location_form" name="location_form" method="post" class="form-horizontal"   action="<?php if($_POST['p_update_button_action']=='add_location' || isset($_GET['location_parent_id'])){echo '?token7='.$secret.'&t=edit_parent&edit_parent_id='.$edit_parent_id;}else{echo'?t=active_properties';} ?>" >
                                                    <?php
                                                    echo '<input type="hidden" name="form_secret5" id="form_secret5" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                    ?>
                                                    <fieldset>
                                                        <div id="response_d1"></div>
                                                        <br>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_first_name">First Name<?php if($field_array['f_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input <?php if(isset($edit_first_name)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_first_name" placeholder="First Name" name="mno_first_name" type="text" maxlength="30" value="<?php echo $edit_first_name; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_last_name">Last Name<?php if($field_array['l_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input <?php if(isset($edit_last_name)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_last_name" placeholder="Last Name" name="mno_last_name" maxlength="30" type="text" value="<?php echo $edit_last_name; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_email">Email<?php if($field_array['email']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input <?php if(isset($edit_email)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com"   value="<?php echo $edit_email; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_address_1">Address<?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input <?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text"   value="<?php echo $edit_bussiness_address1; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_address_2">City<?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input <?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text"   value="<?php echo $edit_bussiness_address2; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_country" >Country<?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <select <?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> name="mno_country" id="country" class="span4 form-control">
                                                                    <option value="">Select Country</option>
                                                                    <?php
                                                                    $select="";
                                                                    foreach ($country_result['data'] AS $row) {
                                                                        // if($row[a]==$edit_country_code || $row[a]== "US"){
                                                                        //     $select="selected";
                                                                        // }
                                                                        echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <script language="javascript">
                                                            populateCountries("country", "state");
                                                        </script>
                                                        <!-- /controls -->
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_state">State/Region<?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="state" placeholder="State or Region" name="mno_state" >
                                                                    <option value="">Select State</option>
                                                                    <?php
                                                                    foreach ($get_regions['data'] AS $state) {
                                                                        if($edit_state_region==$state['states_code']) {
                                                                            echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                        }else{

                                                                            echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_region">ZIP Code<?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input <?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control zip_vali" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $edit_zip; ?>">
                                                            </div>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(document).ready(function() {
                                                                $(".zip_vali").keydown(function (e) {
                                                                    var mac = $('.zip_vali').val();
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
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_timezone">Time Zone <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <select <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_time_zone" name="mno_time_zone" >
                                                                    <option value="">Select Time Zone</option>
                                                                    <?php
                                                                    foreach ($priority_zone_array as $tz){
                                                                        $current_tz = new DateTimeZone($tz);
                                                                        $offset =  $current_tz->getOffset($dt);
                                                                        $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                        $abbr = $transition[0]['abbr'];
                                                                        if($edit_timezone==$tz){
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
                                                                        if($edit_timezone==$tz){
                                                                            $select="selected";
                                                                        }
                                                                        echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                        $select="";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-actions">
                                                            <?php if($edit_account=='1')$btn_name='Update Location & Save';else $btn_name='Add Location & Save';
                                                            if($create_operation_btn_action=='create_operation_next' || $create_operation_btn_action=='add_location_next'  || $_POST['p_update_button_action']=='add_location' || $edit_account=='1'){
                                                                echo '<button onmouseover="btn_action_change(\'add_location_submit\');" disabled type="submit" name="add_location_submit" id="add_location_submit" class="btn btn-primary">'.$btn_name.'</button><strong><font color="#FF0000"></font> </strong>';
                                                                $location_count = $db->getValueAsf("SELECT count(id) as f FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'");
                                                                if($location_count<1000  && !isset($_GET['edit_loc_id']) && !isset($_POST['p_update_button_action']) ){
                                                                    echo '<button onmouseover="btn_action_change(\'add_location_next\');"  disabled type="submit" name="add_location_next" id="add_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';
                                                                }
                                                            }else{
                                                                echo '<button onmouseover="btn_action_change(\'create_operation_submit\');"  disabled type="submit" name="create_operation_submit" id="create_operation_submit"
                                                                                                    class="btn btn-primary">Create Account & Save</button><strong><font color="#FF0000"></font> </strong>';

                                                                echo '<button onmouseover="btn_action_change(\'create_operation_next\');"  disabled type="submit" name="create_operation_next" id="create_operation_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';

                                                            }

                                                            if($edit_account=='1' || $_POST['p_update_button_action']=='add_location' || $_POST['btn_action']=='add_location_next'){?>
                                                                <a href="?token7=<?php echo $secret;?>&t=edit_parent&edit_parent_id=<?php echo $edit_parent_id  ;?>" style="text-decoration:none;" class="btn btn-info inline-btn" >Cancel</a>
                                                            <?php } ?>
                                                            <input type="hidden" name="edit_account" value="<?php echo $edit_account; ?>" />
                                                            <input type="hidden" name="edit_distributor_code" value="<?php echo $edit_distributor_code; ?>" />
                                                            <input type="hidden" name="edit_distributor_id" value="<?php echo $edit_loc_id; ?>" />
                                                            <input type="hidden" name="btn_action"  id = "btn_action" value="create_operation_submit" />
                                                            <input type="hidden" name="add_new_location"  value="<?php echo  $_POST['p_update_button_action']=='add_location'?'1':'0' ?>" />
                                                            <script type="text/javascript">
                                                                function btn_action_change(action) {
                                                                    $('#btn_action').val(action);
                                                                }

                                                                $(document).ready(function() {
                                                                    $(window).keydown(function(event){
                                                                        if(event.keyCode == 13) {
                                                                            event.preventDefault();
                                                                            return false;
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <!-- /form-actions -->
                                                </fieldset>
                                            </form>
                                        </div>

                                        <!-- ***************Operation Accounts List********************** -->
                                        <div <?php if(isset($tab9)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="active_op">
                                            <div id="response_d1"></div>
                                            <div class="widget-content table_response">
                                                <div style="overflow-x:auto">
                                                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Business ID</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Customer Account#
                                                                </th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Serial</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Model</th>
                                                                <?php // echo$package_functions->getSectionType('AP_ACTIONS',$system_package);
                                                                if ($package_functions->getSectionType('AP_ACTIONS', $system_package) == '1' || $system_package == 'N/A') { ?>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Actions</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $key_query = "SELECT l.serial,l.model, l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`,a.`distributor_name`,a.`verification_number`
                                                                                                                FROM `exp_mno_distributor` a LEFT JOIN `exp_mno_distributor_aps` d  ON a.`distributor_code`=d.`distributor_code` LEFT JOIN `exp_locations_ap` l ON d.`ap_code`= l.`ap_code`
                                                                                                                WHERE a.parent_id='$view_loc_code' GROUP BY d.`ap_code`,a.verification_number";

                                                            $query_results = $db->selectDB($key_query);
                                                            foreach ($query_results['data'] AS $row) {

                                                                $cpe_id = $row[id];
                                                                $cpe_name = $row[ap_code];
                                                                $ip = $row[distributor_name];

                                                                if (empty($row[verification_number])) {
                                                                    $icoms = "N/A";
                                                                } else {
                                                                    $icoms = $row[verification_number];
                                                                }

                                                                if (empty($row[mac_address])) {
                                                                    $mac_address = "N/A";
                                                                } else {
                                                                    $mac_address = $row[mac_address];
                                                                }

                                                                if (empty($row[create_date])) {
                                                                    $created_date = "N/A";
                                                                } else {
                                                                    $created_date = $row[create_date];
                                                                }

                                                                if (empty($row[serial])) {
                                                                    $serial = "N/A";
                                                                } else {
                                                                    $serial = $row[serial];
                                                                }

                                                                if (empty($row[model])) {
                                                                    $model = "N/A";
                                                                } else {
                                                                    $model = $row[model];
                                                                }


                                                                echo '<tr>
                                                                        <td> ' . $view_loc_code . ' </td>
                                                                        <td> ' . $icoms . ' </td>
                                                                        <td> ' . $mac_address . ' </td>
                                                                        <td> ' . $serial . ' </td>

                                                                        <td> ' . $model . ' </td>';
                                                            if ($package_functions->getSectionType('AP_ACTIONS', $system_package) == '1' || $system_package == 'N/A') {
                                                                echo '<td>';
                                                                $action_event = (array)json_decode($package_functions->getOptions('AP_ACTIONS', $system_package));

                                                                if (in_array('edit', $action_event) || $system_package == 'N/A') {
                                                                    echo '<a href="javascript:void();" id="EDITAP_' . $cpe_id . '"  class="btn btn-small btn-info">
                                                                                            <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
                                                                                        $(document).ready(function() {
                                                                                        $(\'#EDITAP_' . $cpe_id . '\').easyconfirm({locale: {
                                                                                                title: \'CPE Edit\',
                                                                                                text: \'Are you sure,you want to edit this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                                closeText: \'close\'
                                                                                                }});

                                                                                            $(\'#EDITAP_' . $cpe_id . '\').click(function() {
                                                                                                window.location = "?token7=' . $secret . '&t=2&edit_ap_id=' . $cpe_id . '&edit_loc_code=' . $view_loc_code . '&edit_loc_name=' . $view_loc_name . '"

                                                                                            });

                                                                                            });

                                                                                        </script>&nbsp;&nbsp;';
                                                                }
                                                                if (in_array('remove', $action_event) || $system_package == 'N/A') {
                                                                    echo '<a href="javascript:void();" id="REMAP_' . $cpe_id . '"  class="btn btn-small btn-danger">
                                                                                            <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">
                                                                                        $(document).ready(function() {
                                                                                        $(\'#REMAP_' . $cpe_id . '\').easyconfirm({locale: {
                                                                                                title: \'CPE Remove\',
                                                                                                text: \'Are you sure,you want to remove this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                                closeText: \'close\'
                                                                                                }});

                                                                                            $(\'#REMAP_' . $cpe_id . '\').click(function() {
                                                                                                window.location = "?token7=' . $secret . '&t=active_properties&view_loc_name=' . $view_loc_name . '&remove_ap_name=' . $cpe_name . '&rem_ap_id=' . $cpe_id . '&view_loc_code=' . $view_loc_code . '"

                                                                                            });

                                                                                            });

                                                                                        </script>';
                                                                                                    }

                                                                                                    echo '</td>';
                                                                                                }
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
					<!-- /span8 -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /main-inner -->
	</div>
	<!-- /main -->

<style type="text/css">

</style>
<!-- /widget -->
<script src="js/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#api_profile').multiSelect();  
    });
  </script>
