<link rel="stylesheet" href="css/multi-select.css">
<?php
include 'header_new.php';

require_once 'classes/CommonFunctions.php';
$common_functions = new CommonFunctions();
require_once dirname(__FILE__) . '/models/userMainModel.php';
$user_model = new userMainModel();
$url_mod_override = $db->setVal('url_mod_override', 'ADMIN');
$page = 'User';

foreach(ACCESS as $key => $value){
	var_dump($key);
}
?>

<style>
	.disabled {
		background-color: #eee;
		color: #aaa;
		cursor: text;
	}
	.fieldgroup{
		float: left;
		width: auto;
		margin-right: 3em;
	}
</style>
<?php
	// TAB Organization
	if (isset($_GET['t'])) {
		$variable_tab = 'tab' . $_GET['t'];
		$$variable_tab = 'set';
	} else {
		//initially page loading///
		$tab1 = "set";
	}

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

	$priority_zone_array = array(
									"America/New_York",
									"America/Chicago",
									"America/Denver",
									"America/Los_Angeles",
									"America/Anchorage",
									"Pacific/Honolulu",
								);
?>
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
<?php
$role_edit_id  = 0;
$role_array = [];
$other_array = [];
$account_array = [];
$role_name = "";
$access_role = "";
$full_name = "";
$email = "";
$language = "";
$timezone = "";
$mobile = "";
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
															`admin_users`
															WHERE id='$user_id')";
		$ex_update_log = $db->execDB($update_query);
		return $ex_update_log;
	}


if ($system_package == 'N/A') {
	$q1 = "SELECT `module_name` ,`name_group` FROM `admin_access_modules` WHERE `user_type` ='$user_type' AND `module_name`  NOT IN ('users','profile','change_portal') AND is_enable=1  ORDER BY module_name";
	$modules1 = $db->selectDB($q1);
	$modules = $modules1['data'];
} else {
	$q11 = "SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a WHERE a.`user_type` ='$user_type' AND a.`module_name`  NOT IN ('users','profile','change_portal') AND a.is_enable=1 ORDER BY module_name";
	// echo $q11;
	$modules1 = $db->selectDB($q11);

	$modules = $modules1['data'];
}

	if (isset($_POST['submit_user'])) {
		if($_POST['id'] != 0) {
			$id = $_POST['id'];
			$access_role = $_POST['access_role_2'];
			$full_name = $_POST['full_name_2'];
			$email = $_POST['email_2'];
			$language = $_POST['language_2'];
			$timezone = $_POST['timezone_2'];
			$mobile = $_POST['mobile_2'];
			
			$access_role = ($access_role=='Master Support Admin'|| $access_role=='Master Admin Peer')?'admin':$access_role;			
			//update log//
			$ex_log = userUpdateLog($id, 'EDIT_PROFILE', $user_name,$db);

			if ($ex_log===true) {
				$get_user_detail_q = "SELECT u.user_name, u.email, u.user_name FROM admin_users u WHERE u.id='$id' LIMIT 1";
				$user_details = $db->select1DB($get_user_detail_q);
				$edit_user_name = $user_details['user_name'];
				$old_email = $user_details['email'];
				$archive_q = "INSERT INTO `admin_users_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
							SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$edit_user_name',NOW(),last_update,'update'
							FROM `admin_users` WHERE id='$id'";
				$archive_result = $db->execDB($archive_q);

				$edit_query = "UPDATE `admin_users`
								SET `access_role` = '$access_role',
								`full_name` ='$full_name',
								`email` = '$email',
								`language` = '$language',
								`timezone` = '$timezone',
								`mobile` =  '$mobile'
								WHERE `id` = '$id'";
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

					if ($r1===true) {
						if ($package_functions->getSectionType('EMAIL_USER_TEMPLATE', $system_package) == "own") {
							$email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL', $system_package, 'MNO', $user_distributor);
							$a = $email_content[0]['text_details'];
							$subject = $email_content[0]['title'];

							if (strlen($subject) == '0') {
								$email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL', $package_functions->getAdminPackage(), 'ADMIN');
								$a = $email_content[0]['text_details'];
								$subject = $email_content[0]['title'];
							}
						} else {
							$a = $db->textVal('PASSWORD_RESET_MAIL', 'ADMIN');
							$subject = $db->textTitle('PASSWORD_RESET_MAIL', 'ADMIN');
						}

						$login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
						$link = $db->getSystemURL('reset_pwd', $login_design, $unique_key);
						$vars = array(
							'{$user_full_name}' => $full_name,
							'{$short_name}' => $db->setVal("short_title", $user_distributor),
							'{$account_type}' => $user_type,
							'{$link}' => $link,
							'{$support_number}' => $support_number,
							'{$user_ID}' => $edit_user_name
						);

						$message_full = strtr($a, $vars);
						$message = $message_full;

						$from = strip_tags($db->setVal("email", $user_distributor));
						if (empty($from)) {
							$from = strip_tags($db->setVal("email", "ADMIN"));
						}

						$title = $db->setVal("short_title", $user_distributor);

						$email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
						include_once 'src/email/' . $email_send_method . '/index.php';
						$cunst_var = array();
						//$cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
						$cunst_var['system_package'] = $system_package;
						$cunst_var['mno_package'] = $system_package;
						$cunst_var['mno_id'] = $mno_id;
						$cunst_var['verticle'] = $property_business_type;
						$mail_obj = new email($cunst_var);
						$mail_obj->mno_system_package = $system_package;
						$mail_sent = $mail_obj->sendEmail($from, $email, $subject, $message_full, '', $title);
					}
				}

				if ($edit_result) {
					$message_response = $message_functions->showNameMessage('role_edit_success', $edit_user_name);
					$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Modify User',$id,'3001',$message_response);
					// $create_log->save('3001', $message_functions->showNameMessage('role_edit_success', $edit_user_name), '');
					$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				} else {
					$message_response = $message_functions->showMessage('role_edit_failed', '2002');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'2002',$message_response);
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				}
			} else {
				$message_response = $message_functions->showMessage('role_edit_failed', '2002');
				$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'2002',$message_response);
				$db->userErrorLog('2002', $user_name, 'script - ' . $script);
				// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
				$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
			}
		} else {
			$full_name = $_POST['full_name_1'];
			$br_q = "SHOW TABLE STATUS LIKE 'admin_users'";
			$result2=$db->selectDB($br_q);

			foreach($result2['data'] AS $rowe){
				$auto_inc = $rowe['Auto_increment'];
			}

			$new_user_name = str_replace(' ', '_', strtolower(substr($full_name, 0, 5) . 'u' . $auto_inc));
			$password  = CommonFunctions::randomPassword();

			$access_role = $_POST['access_role_1']; 
			$user_type = $common_functions->getUserTypeFromAccessType($access_role);
			// $user_type = ($access_role == "SADMIN001") ? "SADMIN" : $_POST['user_type'];
			$loation = $_POST['loation'];
			$email = $_POST['email_1'];
			$language = $_POST['language_1'];
			$timezone = $_POST['timezone_1'];
			$mobile = $_POST['mobile_1'];

			$user_distributor = $db->getValueAsf("SELECT u.distributor AS f FROM admin_access_roles u WHERE u.access_role='$access_role' LIMIT 1");

			$pw_query = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(\"$password\"))))) AS f";
			$updated_pw='';
			$pw_results=$db->selectDB($pw_query);
			foreach($pw_results['data'] AS $row){
				$updated_pw = strtoupper($row['f']);
			}

			$query = "INSERT INTO admin_users
					(user_name, `password`, access_role, user_type, user_distributor, full_name, email, `language`, `timezone`, mobile, is_enable, create_date,create_user)
					VALUES ('$new_user_name','$updated_pw','$access_role','$user_type','$user_distributor','$full_name','$email', '$language' ,'$timezone', '$mobile','1',now(),'$user_name')";
			// echo $query;
			$ex =$db->execDB($query);
			if ($ex ==true) {
				$idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
				$message_response = $message_functions->showNameMessage('user_create_success', $new_user_name);
				$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create User',$idContAutoInc,'',$message_response);
				$_SESSION['msg2'] =  '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $message_response . '</strong></div>';

			} else {
				$message_response = $message_functions->showMessage('user_create_fail', '2001');
				$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create User',0,'2001',$message_response);
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$_SESSION['msg2'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $message_response . '</strong></div>';
			}
		}
	}
	//  to the form edit user
	elseif (isset($_GET['edit_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
			$edit_id = $_GET['edit_id'];
			$edit_user_data = $user_model->getUser($edit_id);
			// var_dump($edit_user_data);
			$tab2 = "set";
			$tab5 = "not";
		} else {
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Load User',$_GET['edit_id'],'2004','Oops, It seems you have refreshed the page. Please try again');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
			//header('Location: location.php?t=3');
			$tab2 = "set";
			$tab5 = "not";
		}
	}
	//edit user
	elseif (isset($_POST['edit-submita'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) { //refresh validate
				$id = $_POST['id'];
				$access_role = $_POST['access_role_2'];
				//$user_type = $_POST['user_type'];
				//$loation = $_POST['loation'];
				$full_name = $_POST['full_name_2'];
				$email = $_POST['email_2'];
				$language = $_POST['language_2'];
				$timezone = $_POST['timezone_2'];
				$mobile = $_POST['mobile_2'];
				// $sub_user_type = ($access_role=='Master Support Admin')?'SUPPORT':'MNO';
				$access_role = ($access_role=='Master Support Admin'|| $access_role=='Master Admin Peer')?'admin':$access_role;			
				//update log//
				$ex_log = userUpdateLog($id, 'EDIT_PROFILE', $user_name,$db);

				if ($ex_log===true) {
					$get_user_detail_q = "SELECT u.user_name, u.email, u.user_name FROM admin_users u WHERE u.id='$id' LIMIT 1";
					$user_details = $db->select1DB($get_user_detail_q);
					$edit_user_name = $user_details['user_name'];
					$old_email = $user_details['email'];
					$archive_q = "INSERT INTO `admin_users_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
								SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$edit_user_name',NOW(),last_update,'update'
								FROM `admin_users` WHERE id='$id'";
					$archive_result = $db->execDB($archive_q);

					$edit_query = "UPDATE `admin_users`
									SET `access_role` = '$access_role',
									`full_name` ='$full_name',
									`email` = '$email',
									`language` = '$language',
									`timezone` = '$timezone',
									`mobile` =  '$mobile'
									WHERE `id` = '$id'";
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

						if ($r1===true) {
							if ($package_functions->getSectionType('EMAIL_USER_TEMPLATE', $system_package) == "own") {
								$email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL', $system_package, 'MNO', $user_distributor);
								$a = $email_content[0]['text_details'];
								$subject = $email_content[0]['title'];

								if (strlen($subject) == '0') {
									$email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL', $package_functions->getAdminPackage(), 'ADMIN');
									$a = $email_content[0]['text_details'];
									$subject = $email_content[0]['title'];
								}
							} else {
								$a = $db->textVal('PASSWORD_RESET_MAIL', 'ADMIN');
								$subject = $db->textTitle('PASSWORD_RESET_MAIL', 'ADMIN');
							}

							$login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
							$link = $db->getSystemURL('reset_pwd', $login_design, $unique_key);
							$vars = array(
								'{$user_full_name}' => $full_name,
								'{$short_name}' => $db->setVal("short_title", $user_distributor),
								'{$account_type}' => $user_type,
								'{$link}' => $link,
								'{$support_number}' => $support_number,
								'{$user_ID}' => $edit_user_name

							);

							$message_full = strtr($a, $vars);
							$message = $message_full;

							$from = strip_tags($db->setVal("email", $user_distributor));
							if (empty($from)) {
								$from = strip_tags($db->setVal("email", "ADMIN"));
							}

							$title = $db->setVal("short_title", $user_distributor);

							$email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
							include_once 'src/email/' . $email_send_method . '/index.php';
							$cunst_var = array();
							//$cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
							$cunst_var['system_package'] = $system_package;
			                $cunst_var['mno_package'] = $system_package;
			                $cunst_var['mno_id'] = $mno_id;
			                $cunst_var['verticle'] = $property_business_type;
							$mail_obj = new email($cunst_var);
							$mail_obj->mno_system_package = $system_package;
							$mail_sent = $mail_obj->sendEmail($from, $email, $subject, $message_full, '', $title);
						}
					}

					if ($edit_result) {
						$message_response = $message_functions->showNameMessage('role_edit_success', $edit_user_name);
						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Modify User',$id,'3001',$message_response);
						// $create_log->save('3001', $message_functions->showNameMessage('role_edit_success', $edit_user_name), '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					} else {
						$message_response = $message_functions->showMessage('role_edit_failed', '2002');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('role_edit_failed', '2002');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'2002',$message_response);
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	} 
	elseif (isset($_POST['edit-submita-pass'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) { 
				$id = $_POST['id'];
				$passwd = $_POST['passwd'];
				$passwd_2 = $_POST['passwd_2'];
				if ($passwd == $passwd_2) {
					$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM admin_users u WHERE u.id='$id' LIMIT 1");
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
										WHERE `id` = '$id'";
						$edit_result = $db->execDB($edit_query);

						if ($edit_result===true) {
							$message_response = $message_functions->showNameMessage('role_password_edit_success', $user_full_name);
							$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'User Password Reset',$id,'3001',$message_response);
							// $create_log->save('3001', $message_functions->showNameMessage('role_password_edit_success', $user_full_name), '');
							$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						} else {
							$message_response = $message_functions->showMessage('role_password_edit_failed', '2002');
							$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User Password Reset',$id,'2002',$message_response);
							$db->userErrorLog('2002', $user_name, 'script - ' . $script);
							// $create_log->save('2002', $message_functions->showMessage('role_password_edit_failed', '2002'), '');
							$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						}
					} else {
						$message_response = $message_functions->showMessage('role_password_edit_failed', '2002');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User Password Reset',$id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2002', $message_functions->showMessage('role_password_edit_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('role_password_edit_failed', '2006');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User Password Reset',$id,'2006',$message_response);
					$db->userErrorLog('2006', $user_name, 'script - ' . $script);
					// $create_log->save('2006', $message_functions->showMessage('role_password_edit_failed', '2006'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					//Password confirmation failed
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User Password Reset',$id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	}
	//login status change////
	elseif (isset($_GET['status_change_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
				$status_change_id = $_GET['status_change_id'];
				$action_sts = $_GET['action_sts'];
				$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM admin_users u WHERE u.id='$status_change_id' LIMIT 1");
				$usr_name = $db->getValueAsf("SELECT u.user_name AS f FROM admin_users u WHERE u.id='$status_change_id' LIMIT 1");

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
					$archive_q = "INSERT INTO `admin_users_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
								SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$user_name',NOW(),last_update,'status_change'
								FROM `admin_users` WHERE id='$status_change_id'";
					$archive_result = $db->execDB($archive_q);

					$edit_query = "UPDATE  `admin_users` SET `is_enable` = '$action_sts' WHERE `id` = '$status_change_id'";
					$edit_result = $db->execDB($edit_query);

					if ($edit_result===true) {
						$en_dis_msg = '';
						if ($set == 'enabled') {
							$message_response = $message_functions->showNameMessage('role_user_name_enable_success', $user_full_name);
							$en_dis_msg = 'Enable';
						} elseif ($set == 'disabled') {
							$message_response = $message_functions->showNameMessage('role_user_name_disable_success', $user_full_name);
							$en_dis_msg = 'Disable';
						}

						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'User status change',$status_change_id,'3001',$message_response);
						// $create_log->save('3001', $susmsg, '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . " </strong></div>";

						//Activity log
						// $db->userLog($user_name, $script, $en_dis_msg . ' User', $usr_name);
					} else {
						$message_response = $message_functions->showMessage('role_user_name_enable_failed', '2001');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User status change',$status_change_id,'2001',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2001', $message_functions->showMessage('role_user_name_enable_failed', '2001'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User status change',$status_change_id,'2002','Something went wrong,please try again');
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong> [2002] Something went wrong,please try again</strong></div>";
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User status change',$status_change_id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>�</button><strong>" . $message_response . "</strong></div>";
		}
	}
	//user remove////
	elseif (isset($_GET['user_rm_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
				$user_rm_id = $_GET['user_rm_id'];
				$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM admin_users u WHERE u.id='$user_rm_id' LIMIT 1");
				$usr_name = $db->getValueAsf("SELECT u.user_name AS f FROM admin_users u WHERE u.id='$user_rm_id' LIMIT 1");

				$archive_record = "INSERT INTO `admin_users_archive` (
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
																		`admin_users`
																		WHERE id='$user_rm_id')";
				$archive_record = $db->execDB($archive_record);

                //print_r($archive_record);echo'--';
				if ($archive_record===true) {
					$edit_query = "DELETE FROM `admin_users`  WHERE `id` = '$user_rm_id'";
					//$edit_result = mysql_query($edit_query);
					$edit_result = $db->execDB($edit_query);

					if ($edit_result===true) {
						$message_response = $message_functions->showNameMessage('user_remove_success', $user_full_name);
						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Remove User',$user_rm_id,'3001',$message_response);
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";

						//Activity log
						// $db->userLog($user_name, $script, 'Remove User', $usr_name);
					} else {
						$message_response = $message_functions->showMessage('user_remove_fail', '2002');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove User',$user_rm_id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('user_remove_fail', '2002');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove User',$user_rm_id,'2002',$message_response);
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove User',$user_rm_id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
		}
	} 
	//create and assign Roles
	elseif (isset($_POST['assign_roles_submita'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) { //refresh validate
			$access_role_id = isset($_POST['access_role_id']) ? $_POST['access_role_id'] : 0;
			$role_edit_id = isset($_POST['role_edit_id']) ? $_POST['role_edit_id'] : 0;
			$access_role_name = trim($_POST['access_role_name']);
			$oid_group = trim($_POST['oid_group']);
			$role_type = $_POST['role_type'];

			if($role_edit_id == 0) {
				switch($role_type){
					case 'sadmin':
						$user_distributor = 'SADMIN';
					break;
					// case 'salesmanager':
					// 	$user_distributor = 'SMAN';
					// break;
					case 'nadmin':
						$user_distributor = 'ADMIN';
					break;
					default:
						$user_distributor = 'ADMIN';
				}
				$access_role_id = time() . $role_type . $user_distributor;
				if (strtoupper($access_role_name) == "ADMIN") {
					$message_response = $message_functions->showMessage('user_admin_not_allow');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',0,'',$message_response);
					// $msg = $message_functions->showMessage('user_admin_not_allow');
					$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				} else {
					$query0 = "INSERT INTO `admin_access_roles` (`access_role`,`oid_group`,`description`,`distributor`,`role_type` ,`create_user`,`create_date`)
				 				VALUES ('$access_role_id', '$oid_group', '$access_role_name', '$user_distributor', '$role_type', '$user_name',now())";
					$result0 =$db->execDB($query0);

					foreach ($_POST['my_select'] as $selectedOption) {
						$module_name = $selectedOption;
						$query1 = "REPLACE INTO `admin_access_roles_modules`
									(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
									VALUES ('$access_role_id', '$module_name', '$user_distributor', 'default', '$user_name', now())";
						$result1 = $db->execDB($query1);
					}

					// if($role_type == 'salesmanager'){
					// 	$query1 = "REPLACE INTO `admin_access_roles_modules`
					// 				(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
					// 				VALUES ('$access_role_id', 'sales_crm', '$user_distributor', 'default', '$user_name', now())";
					// 	$result1 = $db->execDB($query1);
					// }

					if($role_type == 'sadmin' ) { // || $role_type == 'salesmanager'
						if($role_type == 'sadmin'){
							foreach ($_POST['other_modules'] as $selectedOption) {
								$other_name = $selectedOption;
								$queryOther = "REPLACE INTO `admin_access_roles_modules`
												(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
												VALUES ('$access_role_id', '$other_name', '$user_distributor', 'other', '$user_name', now())";
								// echo $queryOther."<br/>";
								$resultOther = $db->execDB($queryOther);
							}
						}
						
						foreach ($_POST['operations'] as $selectedOperation) {
							$operationId = $selectedOperation;
							$queryOperation = "REPLACE INTO `admin_access_account`
											(`access_role`, `operation_id`, `create_user`, `create_date`)
											VALUES ('$access_role_id', '$operationId', '$user_name', now())";
							// echo $queryOperation."<br/>";
							$resultOperation = $db->execDB($queryOperation);
						}
					}
					

					if ($result1===true) {
						$idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
						
						$query12 = "INSERT INTO `admin_access_roles_modules`
									(`access_role`, `module_name`, `distributor` ,`module_type`, `create_user`, `create_date`)
									VALUES ('$access_role_id', 'profile', '$user_distributor', '$module_type', '$user_name', now())";
						$result12 =$db->execDB($query12);
					}

					if ($result0===true) {
						$message_response = $message_functions->showNameMessage('role_role_create_success', $access_role_name);
						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create Access Role',$idContAutoInc,'3001',$message_response);
						// $create_log->save('3001', $message_functions->showNameMessage('role_role_create_success', $access_role_name), '');
						$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";

					} else {
						$message_response = $message_functions->showMessage('role_role_create_failed', '2001');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',$idContAutoInc,'2001',$message_response);
						$db->userErrorLog('2001', $user_name, 'script - ' . $script);
						// $create_log->save('2001', $message_functions->showMessage('role_role_create_failed', '2001'), '');
						$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
				} 
			}else {
				$roleUpdateSql = "UPDATE admin_access_roles SET oid_group='$oid_group' WHERE id=$role_edit_id";
				$roleUpdateResult =$db->execDB($roleUpdateSql);

				$getModRol_q = "SELECT * FROM `admin_access_roles_modules` WHERE `access_role`='$access_role_id'";
				$getModRol_r=$db->selectDB($getModRol_q);

				foreach($getModRol_r['data'] AS $row){
					$qq1 = "INSERT INTO `admin_access_roles_modules_archive`
					(`access_role`, `module_name`, `distributor`, `create_user`, `archive_by`, `archive_date`)
					(SELECT  `access_role`, `module_name`, `distributor`, `create_user`, '$user_name', NOW()
					FROM `admin_access_roles_modules` WHERE `id`='".$row["id"]."' LIMIT 1)";
					$rr1=$db->execDB($qq1);

					$sqlRecordDelete = "DELETE FROM `admin_access_roles_modules` WHERE `id`='".$row["id"]."'";
					$resultRecordDelete=$db->execDB($sqlRecordDelete);
				}

				$sqlAccountDelete = "DELETE FROM `admin_access_account` WHERE `access_role`='".$access_role_id."'";
				$resultAccountDelete=$db->execDB($sqlAccountDelete);

				foreach ($_POST['my_select'] as $selectedOption) {
					$module_name = $selectedOption;
					$query1 = "REPLACE INTO `admin_access_roles_modules`
								(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
								VALUES ('$access_role_id', '$module_name', '$user_distributor', 'default', '$user_name', now())";
					$result1 = $db->execDB($query1);
				}

				if($role_type == 'sadmin') {
					foreach ($_POST['other_modules'] as $selectedOption) {
						$other_name = $selectedOption;
						$queryOther = "REPLACE INTO `admin_access_roles_modules`
										(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
										VALUES ('$access_role_id', '$other_name', '$user_distributor', 'other', '$user_name', now())";
						$resultOther = $db->execDB($queryOther);
					}

					foreach ($_POST['operations'] as $selectedOperation) {
						$operationId = $selectedOperation;
						$queryOperation = "REPLACE INTO `admin_access_account`
										(`access_role`, `operation_id`, `create_user`, `create_date`)
										VALUES ('$access_role_id', '$operationId', '$user_name', now())";
						$resultOperation = $db->execDB($queryOperation);
					}
				}
			}
				
		} //key validation
		else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',0,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	} 
	//remove Roles
	elseif (isset($_GET['remove_id']) && isset($_GET['remove_access_role'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token2']) {
				$remove_id = $_GET['remove_id'];
				$remove_access_role = $_GET['remove_access_role'];
				$role_name = $_GET['description'];
				$cnt = "SELECT COUNT(*) AS f FROM `admin_users` WHERE `access_role` = '$remove_access_role' AND `user_distributor` = '$user_distributor'";
				$count_result = $db->getValueAsf($cnt);

				if ($count_result > 0) {
					$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> Access Role is already assigned</strong></div>";
				} else {
					$q_remove_archive = "INSERT INTO `admin_access_roles_archive`
										(`access_role`, `description`, `distributor`, `create_user`, `archive_by`, `archive_date`)
										(SELECT  `access_role`, `description`, `distributor`, `create_user`, '$user_name', NOW()
										FROM `admin_access_roles` WHERE `id`='$remove_id' LIMIT 1)";
					$result_remove_archive = $db->execDB($q_remove_archive);

					$getMod_q = "SELECT * FROM `admin_access_roles` WHERE `id`='$remove_id'";
					$getMod_r=$db->selectDB($getMod_q);
					
  					foreach($getMod_r['data'] AS $row){
						$access_role = $row['access_role'];
						$getModRol_q = "SELECT * FROM `admin_access_roles_modules` WHERE `access_role`='$access_role'";
						$getModRol_r=$db->selectDB($getModRol_q);
	
						foreach($getModRol_r['data'] AS $row){
							$qq1 = "INSERT INTO `admin_access_roles_modules_archive`
									(`access_role`, `module_name`, `distributor`, `create_user`, `archive_by`, `archive_date`)
									(SELECT  `access_role`, `module_name`, `distributor`, `create_user`, '$user_name', NOW()
									FROM `admin_access_roles_modules` WHERE `access_role`='$access_role' LIMIT 1)";
							//$rr1 = mysql_query($qq1);
							$rr1=$db->execDB($qq1);
						}
					}

					// var_dump($result_remove_archive);
					if ($result_remove_archive===true) {
						$q_remove_dis = "DELETE FROM `admin_access_roles` WHERE `id`='$remove_id'";
						$result_remove_dis = $db->execDB($q_remove_dis);

						$q_remove = "DELETE FROM `admin_access_roles_modules`
									WHERE `access_role`='$remove_access_role' AND `distributor` = '$user_distributor'";
						$result_remove = $db->execDB($q_remove);
						// $msg = $message_functions->showMessage('user_remove_success');
						if ($result_remove_dis) {
							$message_response = $message_functions->showMessage('user_remove_success');
							$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Remove Access Role',$remove_id,'3001',$message_response);
							$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
							//Activity log
							// $db->userLog($user_name, $script, 'Remove Access Role', $role_name);
						} else {
							$message_response = $message_functions->showMessage('user_remove_fail', '2003');
							$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',$remove_id,'2003',$message_response);
							// $msg = $message_functions->showMessage('user_remove_fail', '2003');
							$db->userErrorLog('2003', $user_name, 'script - ' . $script);
							$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						}
					}
				}
		} else {
			$message_response = $message_functions->showMessage('transection_is_failed', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',$remove_id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $msg = $message_functions->showMessage('transection_is_failed', '2004');
			$_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	} 
	//Load edit role
	elseif (isset($_GET['role_ID'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['form_secreat']) {
			$role_edit_id = $_GET['role_edit_id'];
			$access_role_id = $_GET['role_ID'];
			$i = $a = $o = 0;

			//get role name and type
			$roleData = $db->selectDB("SELECT `oid_group`,`description`,role_type FROM `admin_access_roles` WHERE `id`='$role_edit_id'");
			$oid_group = $roleData['data'][0]['oid_group'];
			$role_name = $roleData['data'][0]['description'];
			$roleType = $roleData['data'][0]['role_type'];
			//check role type
			if($roleType == "sadmin"){ //  || $roleType == 'salesmanager'
				//get selected other modules
				$other_result = $db->selectDB("SELECT `module_name` FROM `admin_access_roles_modules` WHERE `access_role`='$access_role_id' AND module_type='other'");
				foreach($other_result['data'] AS $otherRole){
					$other_array[$o] = $otherRole['module_name'];
					$o++;
				}

				//get selected operation accounts
				$account_result = $db->selectDB("SELECT `operation_id` FROM `admin_access_account` WHERE `access_role`='$access_role_id'");
				foreach($account_result['data'] AS $account){
					$account_array[$a] = $account['operation_id'];
					$a++;
				}
			}

			//get selected default modules
			$role_result = $db->selectDB("SELECT `module_name` FROM `admin_access_roles_modules` WHERE `access_role`='$access_role_id' AND module_type='default'");
			foreach($role_result['data'] AS $role){
				$role_array[$i] = $role['module_name'];
				$i++;
			}
				$i = 0;
		} else {
			$_SESSION['msg3'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
		}
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
								<div class="widget-content">
									<div class="tabbable">
										<ul class="nav nav-tabs">
											<li class="nav-item" role="presentation">
												<button class="nav-link active" id="users" data-bs-toggle="tab" data-bs-target="#users-tab-pane" type="button" role="tab" aria-controls="users" aria-selected="true">Users</button>
											</li>
											<!-- <li class="nav-item" role="">
												<button class="nav-link" id="roles" data-bs-toggle="tab" data-bs-target="#roles-tab-pane" type="button" role="tab" aria-controls="roles" aria-selected="false">Manage Roles</button>
											</li> -->
										</ul>
										<div class="tab-content">
											<div div class="tab-pane fade show active" id="users-tab-pane" role="tabpanel" aria-labelledby="users" tabindex="0">
												<?php
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

													$id = 0;
													if(isset($_GET['edit_id']) && $edit_user_data != null){
														$id = $edit_user_data[0]->getId();
														// $user_name =  $edit_user_data[0]->getUserName();
														$access_role_set = $edit_user_data[0]->getAccessRole();
														$full_name = $edit_user_data[0]->getFullName();
														$email = $edit_user_data[0]->getEmail();
														$language_set = $edit_user_data[0]->getLanguage();
														$user_type_set = $edit_user_data[0]->getUserType();
														$timezone_set = $edit_user_data[0]->getTimezones();
														$mobile = $edit_user_data[0]->getMobile(); 

														if ($access_role_set=='admin' && $user_type_set =='SUPPORT') {
															$access_role_s="Master Support Admin";
														}
														elseif ($access_role_set=='admin' && $user_type_set =='TECH') {
															$access_role_s='Master Tech Admin';
														}
														elseif ($access_role_set=='admin') {
															$access_role_s='Master Admin Peer';
														}
														else{
															$access_role_s='Admin';
														}
													}
												?>
												<!-- action="controller/User_Controller.php" -->
												<div class="border card">
													<div class="border-bottom card-header p-4">
														<div class="g-3 row">
															<span class="fs-5">Create User</span>
														</div>
													</div>
													<form autocomplete="off" id="edit_profile" action="users.php" method="post" class="row g-3 p-4">
														<?php
														echo '<input type="hidden" name="user_type" id="user_type1" value="' . $user_type . '">';
														echo '<input type="hidden" name="loation" id="loation1" value="' . $user_distributor . '">';
														echo '<input type="hidden" name="id" id="id" value="' . $id . '">';
														?>
														<div class="col-md-12">
															<label class="control-label" for="access_role_1">User Group<sup><font color="#FF0000"></font></sup></label><br/>
															<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
																<?php 
																foreach(ACCESS as $key => $value){
																	$userGroupName = strtoupper(str_replace("_"," ",$key));
																?>
																<input type="radio" class="btn-check" name="user_group" id="user_group" id="<?=$key?>" autocomplete="off">
																<label class="btn btn-outline-primary" for="<?=$key?>"><?=$userGroupName?></label>
																<?php
																}
																?>
															</div>
															<!-- <select class="span4 form-control" name="access_role_1" id="access_role_1">
																<option value="">Select User Group</option>
																< ?php
																	$userRoleArray = ['Super Admin', 'Admin', 'Operator', 'Sales Manager', 'Service Delivery'];
																	foreach($userRoleArray AS $row){	
																?>
																		<option value='< ?=$row?>'>< #mobile_1?=$row?></option>
																< ?php																	
																	}
																?>
															</select> -->
														</div>
														
														<div class="col-md-6">
															<label class="control-label" for="full_name_1">Full Name<sup><font color="#FF0000"></font></sup></label>
															<input class="form-control span4" id="full_name_1" name="full_name_1" maxlength="25" type="text" value="<?php echo $full_name ?>">
														</div>
												
														<div class="col-md-6">
															<label class="control-label" for="email_1">Email<sup><font color="#FF0000"></font></sup></label>
															<input class="form-control span4" id="email_1" name="email_1"  value="<?php echo $email ?>">
														</div>

														<div class="col-md-6">
															<label class="control-label" for="language_1">Language</label>
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
														
														<div class="col-md-6">
															<label class="control-label" for="timezone_1">Time Zone<sup><font color="#FF0000"></font></sup></label>
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
														<div class="col-md-6">
															<label class="control-label" for="mno_country" >Country<font color="#FF0000"></font></sup></label>
															<select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off" required>
																<option value="">Select Country</option>
																<?php
																	if($country_result['rowCount']>1) {
																		foreach ($country_result['data'] as $row) {
																			$select="";
																			if($row['a']==$get_edit_mno_country){
																				$select="selected";
																			}
																			echo '<option value="'.$row['a'].'" '.$select.'>'.$row['b'].'</option>';
																		}
																	}
																?>
															</select>
														</div>
														<script language="javascript">
															populateCountries("mno_country", "mno_state");
														</script>
														<div class="col-md-6">
															<label class="control-label" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
															<select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
																<option value="">Select State</option>
																<?php
																	if($get_regions['rowCount']>1) {
																		foreach ($get_regions['data'] AS $state) {
																			//edit_state_region , get_edit_mno_state_region
																			if($get_edit_mno_state_region == 'N/A') {
																				echo '<option selected value="N/A">Others</option>';
																			} else {
																				if ($get_edit_mno_state_region == $state['states_code']) {
																					echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
																				} else {
																					echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
																				}
																			}
																		}
																	}
																?>
															</select>
														</div>
														<div class="col-md-6">
															<label class="control-label" for="mno_region">ZIP Code</label>
															<input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip?>" autocomplete="off" required>
														</div>
														
														<div class="col-md-6">
															<label class="control-label" for="mobile_1">Phone Number<sup><font color="#FF0000"></font></sup></label>
															<input class="form-control span4" id="mobile_1" name="mobile_1" type="text" placeholder="xxx-xxx-xxxx" value="<?php echo $mobile ?>" maxlength="12">
														</div>
														
														<div class="col-md-12">
															<button type="submit" name="submit_user" id="submit_user" class="btn btn-primary">Save</button>
														</div>
													</form>
												</div>
												<br/>
												<?php if (isset($_GET['edit_id']) && $edit_user_data != null) { ?>
												<div class="border card">
													<div class="border-bottom card-header p-4">
														<div class="g-3 row">
															<span class="fs-5">Reset Password</span>
														</div>
													</div>
													<form onkeyup="footer_submitfn1();" onchange="footer_submitfn1();" autocomplete="off" id="edit-user-password" action="?t=1" method="post" class="row g-3 p-4">
														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret2" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>
															<?php
															echo '<input type="hidden" name="user_type" id="user_type3" value="' . $user_type . '">';
															echo '<input type="hidden" name="loation" id="loation3" value="' . $user_distributor . '">';
															echo '<input type="hidden" name="id" id="id1" value="' . $id . '">';
															?>
															<div class="col-md-6">
																<label class="control-label" for="full_name_2" _1>Password<sup><font color="#FF0000"></font></sup></label>
																<input class="form-control span4" id="passwd" name="passwd" type="password" required>
															</div>
															<!-- /control-group -->
															<div class="col-md-6">
																<label class="control-label" for="email_2">Confirm Password<sup><font color="#FF0000"></font></sup></label>
																<input class="form-control span4" id="passwd_2" name="passwd_2" type="password" required="required">
															</div>
															<!-- /control-group -->
															<div  class="col-md-12">
																<button type="submit" name="edit-submita-pass" id="edit-submita-pass" class="btn btn-primary" disabled="disabled">Save</button>&nbsp; <strong>
																	<font color="#FF0000"></font><small></small>
																</strong>
																<button type="button" onclick="goto('/')" class="btn btn-danger">Cancel</button>&nbsp;
															</div>
													</form>
												</div>
												<?php } ?>
												<script type="text/javascript">
												</script>
												<br/>
												<h5 class="head">Users</h5>
                                        		<table class="table table-striped" style="width:100%" id="manage_users-table">
													<thead>
														<tr>
															<th>Username</th>																		
															<th>Access Role</th>
															<th>Full Name</th>
															<th>Email</th>
															<th>Created By</th>
															<th>Edit</th>
															<th>Disable</th>
															<th>Remove</th>
														</tr>
													</thead>
													<tbody>
														<?php
														require_once dirname(__FILE__) . '/DTO/User.php';
														$data = new User();
														$data->user_type = $user_type;
														$data->user_distributor = $user_distributor;
														$data->user_name = $user_name;
														$query_results = $user_model->get_activeUseres($data);
														foreach ($query_results as $row) {
															$id = $row->id; //$row[id];
															$user_name1 = $row->user_name; //$row[user_name];
															$full_name = $row->full_name; //$row[full_name];
															$access_role = $row->access_role; //$row[access_role];
															$access_role_desc = $row->description; //$row['description'];
															$user_type1 = $row->user_type; //$row[user_type];
															$user_distributor1 = $row->user_distributor; //$row[user_distributor];
															$email = $row->email; //$row[email];
															$is_enable = $row->is_enable; //$row[is_enable];
															$create_user = $row->create_user; //$row[create_user];
															if ($user_type1 == 'TECH') {
																$access_role_desc = 'Tech Admin';
															} else if ($user_type1 == 'SUPPORT' && $access_role=='admin') {
																$access_role_desc = 'Support Admin';
															}

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
																	<td> ' . $access_role_desc . ' </td>
																	<td> ' . $full_name . ' </td>
																	<td> ' . $email . ' </td>
																	<td> ' . $create_user . ' </td>';

															echo '<td><a href="javascript:void();" id="APE_' . $id . '"  class="btn btn-small btn-primary">
																	<i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
																	$(document).ready(function() {
																	$(\'#APE_' . $id . '\').easyconfirm({locale: {
																			title: \'Edit User\',
																			text: \'Are you sure you want to edit this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																			button: [\'Cancel\',\' Confirm\'],
																			closeText: \'close\'
																			}});
																		$(\'#APE_' . $id . '\').click(function() {
																			window.location = "?token=' . $secret . '&t=5&edit_id=' . $id . '"
																		});
																		});
																	</script></td><td><a href="javascript:void();" id="LS_' . $id . '"  class="btn btn-small btn-' . $btn_color . '">
																	<i class="btn-icon-only icon-' . $btn_icon . '"></i>&nbsp;' . ucfirst($btn_title) . '</a><script type="text/javascript">
																	$(document).ready(function() {
																	$(\'#LS_' . $id . '\').easyconfirm({locale: {
																			title: \'' . ucfirst($btn_title) . ' User\',
																			text: \'Are you sure you want to ' . $btn_title . ' this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
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
																			title: \'Remove User\',
																			text: \'Are you sure you want to remove [' . $user_name1 . '] user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
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
														?>
													</tbody>
												</table>
												<!-- /widget -->
											</div>
											
											<!-- +++++++++++++++++++++++++++++ create Roles ++++++++++++++++++++++++++++++++ -->
											<div div class="tab-pane fade show" id="roles-tab-pane" role="tabpanel" aria-labelledby="roles" tabindex="0">
												<h1 class="head">Manage Roles</h1>
												<?php
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
												?>
												<div class="border card">
													<div class="border-bottom card-header p-4">
														<div class="g-3 row">
															<span class="fs-5">Create Role</span>
														</div>
													</div>
													<form autocomplete="off" id="assign_roles_submit" name="assign_roles_submit" method="post" class="row g-3 p-4"" action="?t=3">
															
															<?php
															echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'] .'" />';
															echo '<input type="hidden" name="role_edit_id" id="role_edit_id" value="'.$role_edit_id.'" />';
															echo '<input type="hidden" name="access_role_id" id="access_role_id" value="'.$access_role_id.'" />';
															if($role_edit_id != 0) {
																echo '<input type="hidden" name="role_type" id="role_type" value="'.$roleType.'" />';
															}
															?>
															<div class="col-md-12">
																<label class="control-label" for="role_type">Role Type</label>
																<fieldset id="role_types" class="flex">
																	<div class="fieldgroup flex">
																		<input type="radio" name="role_type" id="role_type" value="nadmin" <?=(($roleType == 'nadmin'  || $role_edit_id == 0 )? 'checked' : '')?> <?=($role_edit_id != 0 ? "disabled" : "")?>><label for= "nadmin">Admin</label>
																	</div>
																	<!-- <div class="fieldgroup">
																		<input type="radio" name="role_type" id="role_type" value="salesmanager" < ?=($roleType == 'salesmanager' ? 'checked' : '')?> <  ?=($role_edit_id != 0 ? "disabled" : "")?>><label for= "nadmin">Sales Manager</label>
																	</div> -->
																	<div class="fieldgroup flex">
																		<input type="radio" name="role_type" id="role_type" value="sadmin" <?=($roleType == 'sadmin' ? 'checked' : '')?> <?=($role_edit_id != 0 ? "disabled" : "")?>><label for= "sadmin">Super Admin</label>
																	</div>
																</fieldset>	
															</div>
															<div class="col-md-6">
																<label class="control-label" for="access_role_name">Access Role Name</label>
																<input class="form-control span2" id="access_role_name" name="access_role_name" type="text" value="<?=$role_name?>" <?=($role_edit_id != 0 ? "disabled" : "")?>>
															</div>
															<div class="col-md-6">
																<label class="control-label" for="oid_group">OID group</label>
																<input class="form-control span2" id="oid_group" name="oid_group" type="text" value="<?=$oid_group?>" >
															</div>
															
															<div class="col-md-6" id="sadmin_operations">
																<label class="control-label" for="my_select">Assign Operators</label>
																<select class="form-control span4" multiple="multiple" id="operations" name="operations[]">
																	<option value="" disabled="disabled"> Choose Operation(s)</option>
																	<?php
																		$q12 = "SELECT id,full_name FROM admin_users WHERE user_type='MNO'";
																		$operations = $db->selectDB($q12);
																		foreach ($operations['data'] as $row) {
																			$operation_id = $row['id'];
																			$operation_name = $row['full_name'];
																			$selected = "";
																			if (in_array($operation_id, $account_array )) {
																				$selected = "selected";
																			} 
																			echo "<option " . $selected . " value='" . $operation_id . "'>" . $operation_name . "</option>";
																		}
																	?>
																</select>
															</div>
															<!-- /control-group -->
															
															<div class="col-md-6" id="admin_operations">
																<label class="control-label" for="my_select"><?=($_SESSION['SADMIN'] == true ? "Admin " : "")?>Modules</label>
																<select class="form-control span4" multiple="multiple" id="my_select" name="my_select[]">
																	<option value="" disabled="disabled"> Choose Module(s)</option>
																	<?php
																	foreach ($modules as $key => $row) {
																		$module_name = $row['module_name'];
																		$module = $row['name_group'];
																		$selected = "";
																		if (in_array($module_name, $role_array)) {
																			$selected = "selected";
																		} 
																		echo "<option " . $selected . " value='" . $module_name . "'>" . $module . "</option>";
																	}
																	?>
																</select>
															</div>

															<div class="col-md-6" id="sadmin-omodules">
																<label class="control-label" for="my_select">Non Admin Modules</label>
																<select class="form-control span4" multiple="multiple" id="other_modules" name="other_modules[]">
																	<option value="" disabled="disabled"> Choose Module(s)</option>
																	<?php
																		if ($system_package == 'N/A') {
																			$q1 = "SELECT `module_name` ,`name_group` FROM `admin_access_modules` WHERE (`user_type` = 'MNO' || `user_type` = 'PROVISIONING') AND `module_name`  NOT IN ('users','profile','change_portal') AND is_enable=1 ORDER BY module_name";

																			$modules1 = $db->selectDB($q1);
																			$modules = $modules1['data'];
																		} else {
																			$q11 = "SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a WHERE (a.`user_type` = 'MNO' || a.`user_type` = 'PROVISIONING') AND a.`module_name` NOT IN ('users','profile','change_portal') AND a.is_enable=1  ORDER BY module_name";
																			$modules1 = $db->selectDB($q11);
																			$q12 = "SELECT options FROM admin_product_controls WHERE product_code='$system_package' AND feature_code='ALLOWED_PAGE'";
																			$allow_pages = $package_functions->getOptions('ALLOWED_PAGE',$system_package);
																			$modules2 = json_decode($allow_pages);
																			foreach ($modules1['data'] as $key => $value) {
																				if (!in_array($value['module_name'], $modules2)) {
																					unset($modules1['data'][$key]);
																				}
																			}
																			$modules = $modules1['data'];
																		}

																	foreach ($modules as $row) {
																		$module_name = $row['module_name'];
																		$module = $row['name_group'];
																		$selected = "";
																		if (in_array($module_name, $other_array)) {
																			$selected = "selected";
																		}
																		echo "<option " . $selected . " value='" . $module_name . "'>" . $module . "</option>";
																	}
																	?>
																</select>
															</div>
															<!-- /control-group -->

															<div class="col-md-12">
																<button type="submit" name="assign_roles_submita" id="assign_roles_submita" class="btn btn-primary">Save</button>
															</div>
													</form>
												</div>
													<script type="text/javascript">
														$(document).ready(function() {
															// document.getElementById("assign_roles_submita").disabled = true;
														});
													</script>
												<br/>
												<h1 class="head">Admin Roles</h1>	
												<table class="table table-striped" style="width:100%" id="role-table">
													<thead>
														<tr>
															<th>Access Role</th>
															<th>Modules Assigned</th>
															<th>Created Date</th>
															<th>Edit</th>
															<th>Remove</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$key_query = "SELECT r.id, r.`access_role`,r.`description`, GROUP_CONCAT(CONCAT('<li>',a.`name_group`,'</li>') SEPARATOR '') AS m_list,m.`module_name`,DATE_FORMAT(r.`create_date`,'%m/%d/%Y %h:%i %p') AS create_date 
																			FROM `admin_access_roles_modules` m LEFT JOIN `admin_access_roles` r
																			ON r.`access_role`=m.`access_role`,
																			`admin_access_modules` a
																			WHERE a.`module_name`=m.`module_name`
																			GROUP BY r.access_role
																			ORDER BY r.`id` DESC";
															if($user_type != 'SADMIN') {
																$key_query = " AND r.`create_user`='$user_name'";
															}
														$query_results=$db->selectDB($key_query);
														foreach($query_results['data'] AS $row){
															$access_role = $row['access_role'];
															$description = $row['description'];
															$create_date = $row['create_date'];
															$id_access_role = $row['id'];
															$m_list = $row['m_list'];

															//check access Role use or not//
															$check_role = $db->SelectDB("SELECT * FROM `admin_users` u WHERE u.`access_role`='$access_role'");

															echo '<tr>
																	<td> ' . $description . ' </td>
																	<td >  <a class="btn" id="' . $access_role . '"> View </a> ';
																						echo '<script>
																		$(document).ready(function() {
																			$(\'#' . $access_role . '\').tooltipster({
																				content: $("' . $m_list . '"),
																				theme: \'tooltipster-shadow\',
																				animation: \'grow\',
																				onlyOne: true,
																				trigger: \'click\'
																			});
																		});
																	</script></td>' .
																'<td> ' . $create_date . ' </td>';
															/////////////////////////////////////////////
															echo '<td>';
															echo '<a href="javascript:void();" id="RE_' . $id_access_role . '"  class="btn btn-small btn-primary">
																	<i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
																	$(document).ready(function() {
																	$(\'#RE_' . $id_access_role . '\').easyconfirm({locale: {
																			title: \'Role Edit\',
																			text: \'Are you sure you want to edit this Role?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																			button: [\'Cancel\',\' Confirm\'],
																			closeText: \'close\'
																			}});
																		$(\'#RE_' . $id_access_role . '\').click(function() {
																			window.location = "?form_secreat=' . $secret . '&t=3&role_ID=' . $access_role . '&role_edit_id=' . $id_access_role . '"
																		});
																		});
																	</script>';
															echo '</td>';
															echo '<td>';
															if ($check_role['rowCount'] == 0) {
																echo '<a href="javascript:void();" id="AP_' . $id_access_role . '"  class="btn btn-small btn-primary">
																		<i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">
																		$(document).ready(function() {
																		$(\'#AP_' . $id_access_role . '\').easyconfirm({locale: {
																				title: \'Role Remove\',
																				text: \'Are you sure you want to remove this Role?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				}});
																			$(\'#AP_' . $id_access_role . '\').click(function() {
																				window.location = "?token2=' . $secret . '&t=3&remove_access_role=' . $access_role . '&description=' . $description . '&remove_id=' . $id_access_role . '"
																			});
																			});
																		</script>';
															} else {
																echo	'<a class="btn btn-small btn-primary" disabled>
																		<i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a>';
															}
															echo '</td>';
														}
														?>
													</tbody>
												</table>
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
	<script type="text/javascript" src="js/formValidation.js"></script>
	<script type="text/javascript" src="js/bootstrap_form.js"></script>
	<script type="text/javascript" src="js/bootstrapValidator_new.js?v=14"></script>

	<script type="text/javascript">

		function footer_submitfn1() {
			$("#edit-submita-pass").prop('disabled', false);
		}
		$(document).ready(function() {
			$('#manage_users-table').dataTable();//role-table
			$('#role-table').dataTable();

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
							<?php echo $db->validateField('person_full_name'); ?>,
							<?php echo $db->validateField('not_require_special_character'); ?>
						}
					},
					email_1: {
						validators: {
							<?php echo $db->validateField('email_cant_upper'); ?>,
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
				if ($('#edit_profile').data('bootstrapValidator').isValid()) {
					data.bv.disableSubmitButtons(false);
				} else {
					data.bv.disableSubmitButtons(true);
				}
			});
			$('#edit-user-profile').bootstrapValidator({
				framework: 'bootstrap',
				xcluded: [':disabled', '[readonly]',':hidden', ':not(:visible)'],
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					access_role_2: {
						validators: {
							<?php echo $db -> validateField('dropdown'); ?>
						}
					},
					full_name_2: {
						validators: {
							<?php echo $db -> validateField('person_full_name'); ?> ,
							<?php echo $db -> validateField('not_require_special_character'); ?>
						}
					},
					email_2: {
						validators: {
							<?php echo $db -> validateField('email_cant_upper'); ?>,
							<?php echo $db->validateField('email'); ?>
						}
					},
					timezone_2: {
						validators: {
							<?php echo $db -> validateField('notEmpty'); ?>
						}
					},
					mobile_2: {
						validators: {
							<?php echo $db -> validateField('mobile'); ?>
						}
					}
				}
			}).bootstrapValidator('validate').on('status.field.bv', function(e, data) {
				if ($('#edit-user-profile').data('bootstrapValidator').isValid()) {
					data.bv.disableSubmitButtons(false);
				} else {
					data.bv.disableSubmitButtons(true);
				}
			});


		});
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
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#submit_user").easyconfirm({
				locale: {
					title: 'New User Account',
					text: 'Are you sure you want to create user?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#submit_user").click(function() {});

			$("#edit-submita").easyconfirm({
				locale: {
					title: 'Edit User',
					text: 'Are you sure you want to update this profile?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#edit-submita").click(function() {});

			$("#edit-submita-pass").easyconfirm({
				locale: {
					title: 'Password Reset',
					text: 'Are you sure you want to update this password?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#edit-submita-pass").click(function() {});

			$("#assign_roles_submita").easyconfirm({
				locale: {
					title: 'Role Creation',
					text: 'Are you sure you want to save this Role?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
		});
	</script>

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
			
			//sadmin_operations sadmin-omodules
			<?php if ( ($role_edit_id != 0 && $roleType == 'sadmin')) { ?>
				$('#admin_operations').show();	
				$('#sadmin_operations').show();
				$('#sadmin-omodules').show();
			<?php //} elseif($role_edit_id != 0 && $roleType == 'salesmanager') { ?>
				// $('#admin_operations').hide();
				// $('#sadmin_operations').show();
				// $('#sadmin-omodules').hide();
			<?php
				} elseif($role_edit_id == 0) {
			?>
				$('#admin_operations').show();
				$('#sadmin_operations').hide();
				$('#sadmin-omodules').hide();
			<?php
				} else {
			?>
				$('#admin_operations').show();
				$('#sadmin_operations').hide();
				$('#sadmin-omodules').hide();
			<?php
				}
			?>
			 
			$('#my_select').multiSelect(); 
			$('#my_select_roles').multiSelect();
			$('#other_modules').multiSelect(); 
			$('#operations').multiSelect();

			$('input[type=radio][name=role_type]').change(function() {
				switch ($(this).val()) {
					case "sadmin":
						$('#admin_operations').show();
						$('#sadmin_operations').show();
						$('#sadmin-omodules').show();
					break;
					// case "salesmanager":
					// 	$('#admin_operations').hide();
					// 	$('#sadmin_operations').show();
					// 	$('#sadmin-omodules').hide();
					// break;
					case "nadmin":
						$('#admin_operations').show();
						$('#sadmin_operations').hide();
						$('#sadmin-omodules').hide();
					break;
				}
			});
		});
	</script>

	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	</body>

</html>