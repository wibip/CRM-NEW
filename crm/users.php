<link rel="stylesheet" href="css/multi-select.css">
<?php

include 'header_new.php';

require_once 'classes/CommonFunctions.php';
$common_functions = new CommonFunctions();
require_once 'classes/userClass.php';
$usersData = new Users();
require_once 'classes/hierarchyClass.php';
$hierarchy = new Hierarchy();
$url_mod_override = $db->setVal('url_mod_override', 'ADMIN');
$page = 'User';

// Get languages
$key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";
$language_results=$db->selectDB($key_query);

// Get active operators
$activeOperators = $usersData->getAllOperators();
// var_dump($activeOperators);
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
	.custom-tooltip {
		--bs-tooltip-bg: var(--bs-primary);
	}

	.tooltip.show li {
		text-align:left;
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
$(function () {
 $('[data-bs-toggle="tooltip"]').tooltip()
//   document.getElementById('tt').setAttribute('data-bs-original-title', 'New Tooltip Title');
})

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
	function userUpdateLog($user_id, $action_type, $action_by,$db){
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

	if (isset($_POST['submit_user'])) {
		$userId = $_POST['id'];
		$full_name = $_POST['full_name'];
		$group = $_POST['radio_user_group']; 
		$operator = $_POST['operator']; 
		$category = $_POST['category']; 
		$parent = $_POST['parent']; 
		$email = $_POST['email'];
		$language = $_POST['language'];
		$timezone = $_POST['timezone'];
		$address = $_POST['address'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$mobile = $_POST['mobile'];
		$user_type = $group;
		$user_distributor = $usersData->userDistributors($group);

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
					$db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Modify User',$id,'3001',$message_response);
					// $create_log->save('3001', $message_functions->showNameMessage('role_edit_success', $edit_user_name), '');
					$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				} else {
					$message_response = $message_functions->showMessage('role_edit_failed', '2002');
					$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Modify User',$id,'2002',$message_response);
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				}
			} else {
				$message_response = $message_functions->showMessage('role_edit_failed', '2002');
				$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Modify User',$id,'2002',$message_response);
				$db->userErrorLog('2002', $user_name, 'script - ' . $script);
				// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
				$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
			}
		} else {
			$tbl_status_sql = "SHOW TABLE STATUS LIKE 'admin_users'";
			$tbl_status_result=$db->selectDB($tbl_status_sql);

			foreach($tbl_status_result['data'] AS $rowe){
				$auto_inc = $rowe['Auto_increment'];
			}

			$new_user_name = str_replace(' ', '_', strtolower(substr($full_name, 0, 5) . 'u' . $auto_inc));
			$password  = CommonFunctions::randomPassword();

			// $user_type = $common_functions->getUserTypeFromAccessType($group);
			// $user_distributor = $db->getValueAsf("SELECT u.distributor AS f FROM admin_access_roles u WHERE u.access_role='$access_role' LIMIT 1");

			$pw_query = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(\"$password\"))))) AS f";
			$updated_pw='';
			$pw_results=$db->selectDB($pw_query);
			foreach($pw_results['data'] AS $row){
				$updated_pw = strtoupper($row['f']);
			}

			$query = "INSERT INTO admin_users(user_name, `password`, user_type, `group`, user_distributor, full_name, email,`address`,`country`,`state_region`,`zip`, `language`, `timezone`, mobile, is_enable, create_date,create_user)
					VALUES ('$new_user_name','$updated_pw','$user_type', '$group','$user_distributor','$full_name','$email','$address','$country','$state','$zip', '$language' ,'$timezone', '$mobile','1',now(),'".$user_name."')";
			// echo $query;
			// die;
			$ex =$db->execDB($query);

			if ($ex ==true) {
				$idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");

				if($group == 'sales_manager' || $group == 'ordering_agent'){
					$return = $hierarchy->userHierarchySave($operator,$category,$idContAutoInc,$parent,$user_name);
					if ($return ==true) {
						$db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Create User Hierarchy',$idContAutoInc,'','User hierarchy creatioin success');
					} else {
						$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Create User Hierarchy',0,'2001','User hierarchy creatioin failed');
					}
				}
				$message_response = $message_functions->showNameMessage('user_create_success', $new_user_name);
				$db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Create User',$idContAutoInc,'',$message_response);
				$_SESSION['msg2'] =  '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $message_response . '</strong></div>';
			} else {
				$message_response = $message_functions->showMessage('user_create_fail', '2001');
				$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Create User',0,'2001',$message_response);
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$_SESSION['msg2'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $message_response . '</strong></div>';
			}
		}
	}
	//  to the form edit user
	elseif (isset($_GET['edit_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
			$edit_id = $_GET['edit_id'];
			$userData = $usersData->getUser($edit_id);
			if($userData['rowCount'] > 0){
				$edit_user_data = $userData['data'][0];
			}
		} else {
			$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Load User',$_GET['edit_id'],'2004','Oops, It seems you have refreshed the page. Please try again');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
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
						$db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Modify User',$id,'3001',$message_response);
						// $create_log->save('3001', $message_functions->showNameMessage('role_edit_success', $edit_user_name), '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					} else {
						$message_response = $message_functions->showMessage('role_edit_failed', '2002');
						$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Modify User',$id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('role_edit_failed', '2002');
					$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Modify User',$id,'2002',$message_response);
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Modify User',$id,'2004',$message_response);
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
							$db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'User Password Reset',$id,'3001',$message_response);
							// $create_log->save('3001', $message_functions->showNameMessage('role_password_edit_success', $user_full_name), '');
							$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						} else {
							$message_response = $message_functions->showMessage('role_password_edit_failed', '2002');
							$db->addLogs($user_name, 'ERROR',$user_group, $page, 'User Password Reset',$id,'2002',$message_response);
							$db->userErrorLog('2002', $user_name, 'script - ' . $script);
							// $create_log->save('2002', $message_functions->showMessage('role_password_edit_failed', '2002'), '');
							$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						}
					} else {
						$message_response = $message_functions->showMessage('role_password_edit_failed', '2002');
						$db->addLogs($user_name, 'ERROR',$user_group, $page, 'User Password Reset',$id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2002', $message_functions->showMessage('role_password_edit_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('role_password_edit_failed', '2006');
					$db->addLogs($user_name, 'ERROR',$user_group, $page, 'User Password Reset',$id,'2006',$message_response);
					$db->userErrorLog('2006', $user_name, 'script - ' . $script);
					// $create_log->save('2006', $message_functions->showMessage('role_password_edit_failed', '2006'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					//Password confirmation failed
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_group, $page, 'User Password Reset',$id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	}
	//user status change////
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

						$db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'User status change',$status_change_id,'3001',$message_response);
						// $create_log->save('3001', $susmsg, '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . " </strong></div>";

						//Activity log
						// $db->userLog($user_name, $script, $en_dis_msg . ' User', $usr_name);
					} else {
						$message_response = $message_functions->showMessage('role_user_name_enable_failed', '2001');
						$db->addLogs($user_name, 'ERROR',$user_group, $page, 'User status change',$status_change_id,'2001',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2001', $message_functions->showMessage('role_user_name_enable_failed', '2001'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$db->addLogs($user_name, 'ERROR',$user_group, $page, 'User status change',$status_change_id,'2002','Something went wrong,please try again');
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong> [2002] Something went wrong,please try again</strong></div>";
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_group, $page, 'User status change',$status_change_id,'2004',$message_response);
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
						$db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Remove User',$user_rm_id,'3001',$message_response);
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";

						//Activity log
						// $db->userLog($user_name, $script, 'Remove User', $usr_name);
					} else {
						$message_response = $message_functions->showMessage('user_remove_fail', '2002');
						$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Remove User',$user_rm_id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('user_remove_fail', '2002');
					$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Remove User',$user_rm_id,'2002',$message_response);
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_group, $page, 'Remove User',$user_rm_id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
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
												?>
												<!-- action="controller/User_Controller.php" -->
												<div class="border card">
													<div class="border-bottom card-header p-4">
														<div class="g-3 row">
															<span class="fs-5"><?=(isset($_GET['edit_id'])? "Update" : "Create")?> User</span>
														</div>
													</div>
													<form autocomplete="off" name="user_profile" id="user_profile" action="users.php" method="post" class="row g-3 p-4">
														<input type="hidden" name="user_group" id="user_group" value="<?=$user_group?>" />
														<input type="hidden" name="loation" id="loation1" value="<?=$user_distributor?>" />
														<input type="hidden" name="id" id="id" value="<?=(isset($_GET['edit_id']) && $edit_user_data != null) ? $edit_user_data['id'] : 0?>" />
														<div class="col-md-12">
															<label class="control-label" for="access_role_1">User Group<sup><font color="#FF0000"></font></sup></label><br/>
															<div class="btn-group" id="btn-group" role="group">
																<?php 
																foreach(ACCESS as $key => $value){
																	$userGroupName = strtoupper(str_replace("_"," ",$key));
																	$selected = (isset($_GET['edit_id']) && $edit_user_data != null && $key == $edit_user_data['group']) ? "checked" : "";
																	$accessPage = "";
																	foreach($value['modules'] as $pageName => $pageActions){
																		$accessPage .= "<li align='left'>".ucwords(str_replace("_"," ",$pageName))."</li>";
																	}
																?>
																<input type="radio" class="btn-check hide_rad radio_user_group" name="radio_user_group" id="<?=$key?>" value="<?=$key?>" autocomplete="off" <?=$selected?>>
																<label class="btn btn-outline-primary normalize" data-bs-toggle="tooltip" data-bs-html="true" title="<b>Permitted Pages</b><ul align='left'><?=$accessPage?></ul>" for="<?=$key?>"><?=$userGroupName?></label>
																<?php
																}
																?>
															</div>
														</div>
														<div class="col-md-6" id="operator_div">
															<label class="control-label" for="full_name">Operator<sup><font color="#FF0000"></font></sup></label>
															<select class="form-control span4" name="operator" id="operator">
																<option value="">Select Operator</option>
																<?php 
																	if($activeOperators['rowCount'] > 0){
																		foreach($activeOperators['data'] AS $operator){ 
																			$selected = '';
																?>
																			<option value='<?=$operator['mno_id']?>' <?=$selected?>><?=$operator['mno_description']?></option>
																<?php 	}
																	} 
																?>
															</select>
														</div>												
														<div class="col-md-6" id="parent_cat_div">
															<label class="control-label" for="category">Parent Category<sup><font color="#FF0000"></font></sup></label>
															<select class="form-control span4" name="category" id="category" >
																<option value="">Select Category</option>
															</select>
														</div>		
														<div class="col-md-6" id="parent_div">
															<label class="control-label" for="parent">Parent<sup><font color="#FF0000"></font></sup></label>
															<select class="form-control span4" name="parent" id="parent" >
																<option value="">Select Parent</option>
															</select>
														</div>												
														<div class="col-md-6">
															<label class="control-label" for="full_name">Full Name<sup><font color="#FF0000"></font></sup></label>
															<input class="form-control span4" id="full_name" name="full_name" maxlength="25" type="text" value="<?=(isset($_GET['edit_id']) && $edit_user_data != null) ? $edit_user_data['full_name'] : ''?>">
														</div>												
														<div class="col-md-6">
															<label class="control-label" for="email">Email<sup><font color="#FF0000"></font></sup></label>
															<input class="form-control span4" id="email" name="email"  value="<?=(isset($_GET['edit_id']) && $edit_user_data != null) ? $edit_user_data['email'] : ''?>">
														</div>
														<div class="col-md-6">
															<label class="control-label" for="language">Language</label>
															<select class="form-control span4" name="language" id="language">
																<?php
																	foreach($language_results['data'] AS $row){
																		$language_code = $row['language_code'];
																		$language = $row['language'];
																		$selected = (isset($_GET['edit_id']) && $edit_user_data != null && $language_code == $edit_user_data['language']) ? "selected" : "";
																?>
																	<option value='<?=$language_code?>' <?=$selected?>><?=$language?></option>
																<?php
																	}
																?>
															</select>
														</div>														
														<div class="col-md-6">
															<label class="control-label" for="timezone">Time Zone<sup><font color="#FF0000"></font></sup></label>
															<select class="span4 form-control" id="timezone" name="timezone" autocomplete="off">
																<option value="">Select Time Zone</option>
																<?php
																	$utc = new DateTimeZone('UTC');
																	$dt = new DateTime('now', $utc);
																	foreach ($priority_zone_array as $tz){
																		$current_tz = new DateTimeZone($tz);
																		$offset =  $current_tz->getOffset($dt);
																		$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
																		$abbr = $transition[0]['abbr'];
																		$selected = (isset($_GET['edit_id']) && $edit_user_data != null && $tz == $edit_user_data['timezone']) ? "selected" : "";
																		echo '<option '.$selected.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
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
															<label class="control-label" for="address">Address<sup><font color="#FF0000"></font></sup></label>
															<input class="form-control span4" id="address" name="address" maxlength="25" type="text" value="<?=(isset($_GET['edit_id']) && $edit_user_data != null) ? $edit_user_data['address'] : ''?>">
														</div>
														<div class="col-md-6">
															<label class="control-label" for="country" >Country<font color="#FF0000"></font></sup></label>
															<select name="country" id="country" class="span4 form-control" autocomplete="off" required>
																<option value="">Select Country</option>
																<?php
																	if($country_result['rowCount']>1) {
																		foreach ($country_result['data'] as $row) {
																			$selected = (isset($_GET['edit_id']) && $edit_user_data != null && $row['a'] == $edit_user_data['country']) ? "selected" : "";
																			echo '<option value="'.$row['a'].'" '.$selected.'>'.$row['b'].'</option>';
																		}
																	}
																?>
															</select>
														</div>
														<script language="javascript">
															populateCountries("country", "state");
														</script>
														<div class="col-md-6">
															<label class="control-label" for="state">State/Region<font color="#FF0000"></font></sup></label>
															<select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="state" placeholder="State or Region" name="state" required autocomplete="off">
																<option value="">Select State</option>
																<?php
																	if($get_regions['rowCount']>1) {
																		foreach ($get_regions['data'] AS $state) {
																			if($edit_user_data['state_region'] == 'N/A') {
																				echo '<option selected value="N/A">Others</option>';
																			} else {
																				$selected = (isset($_GET['edit_id']) && $edit_user_data != null && $state['states_code'] == $edit_user_data['state_region']) ? "selected" : "";
		
																				echo '<option '.$selected.' value="' . $state['states_code'] . '">' . $state['description'] . '</option>';

																			}
																		}
																	}
																?>
															</select>
														</div>
														<div class="col-md-6">
															<label class="control-label" for="zip">ZIP Code</label>
															<input class="span4 form-control" id="zip" maxlength="5" placeholder="XXXXX" name="zip" type="text" value="<?=(isset($_GET['edit_id']) && $edit_user_data != null ) ? $edit_user_data['zip'] : ''?>" autocomplete="off" required>
														</div>
														
														<div class="col-md-6">
															<label class="control-label" for="mobile">Phone Number<sup><font color="#FF0000"></font></sup></label>
															<input class="form-control span4" id="mobile" name="mobile" type="text" placeholder="xxx-xxx-xxxx" value="<?=(isset($_GET['edit_id']) && $edit_user_data != null ) ? $edit_user_data['mobile'] : ''?>" maxlength="12">
														</div>
														
														<div class="col-md-12">
															<button type="submit" name="submit_user" id="submit_user" data-name="<?=(isset($_GET['edit_id'])? "update" : "save")?>" class="btn btn-primary"><?=(isset($_GET['edit_id'])? "Update" : "Save")?></button>
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
															echo '<input type="hidden" name="user_group" id="user_group" value="' . $user_group . '">';
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
															<th>User Group</th>
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
														$active_users = $usersData->get_activeUseres($data);
														foreach ($active_users['data'] as $row) {
															$id = $row['id'];
															$user_name = $row['user_name'];
															$full_name = $row['full_name'];
															$group = $row['group'];
															$email = $row['email'];
															$is_enable = $row['is_enable'];
															$create_user =$row['create_user'];

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
																	<td> ' . $user_name . ' </td>
																	<td> ' . $group . ' </td>
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
	<?php
	include 'footer.php';
	?>
	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>

	<!-- Alert messages js-->
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#operator_div').hide();
			$('#parent_cat_div').hide();
			$('#parent_div').hide();
			$("#category").prop("disabled", true);
			$("#parent").prop("disabled", true);
			$("#loation").chained("#radio_user_group");

			$('input[name="radio_user_group"]').on('hover', function(e) {
				var manageradiorel = e.target.value;
				alert(manageradiorel);
			});

			$("input[name='radio_user_group']").change(function(){
				var groupName = $(this).val();
				$('#operator option:selected').prop('selected', false);
				if(groupName != 'super_admin' && groupName != 'admin' && groupName != 'operation') {
					$('#operator_div').show();//parent_div
					$('#parent_cat_div').show();
					$("#category").empty();
					$('#category').append($('<option>', { 
						value: 0,
						text : "Select Category" 
					}));
					$("#category").prop("disabled", true);
				} else {
					$('#operator_div').hide();
					$('#parent_cat_div').hide();
					$('#parent_div').hide();
				}
			});

			$('#category').on('change', function() {
				var operatorValue = $('#operator').val();
				var categoryValue = $(this).val();
				var groupValue = $("input[name='user_group']:checked").val();

				if(operatorValue != "" && categoryValue != ""){
					$("#overlay").css("display","block");
					$.ajax({	
						type: "POST",
						url: "ajax/load_parents.php",
						data: {
							operator_id: operatorValue,
							category_id: categoryValue,
							group_value: groupValue,
						},
						success: function(responseData) {
							responseData = JSON.parse(responseData);
							$("#parent").empty();
							$('#parent').append($('<option>', { 
								value: 0,
								text : "No Parent" 
							}));
							if(responseData['rowCount'] > 0){
								$.each(responseData['data'], function (i, item) {
									// console.log(item.category);
									$('#parent').append($('<option>', { 
										value: item.id,
										text : item.full_name 
									}));
								});
								$("#parent").prop("disabled", false);								
								$('#parent_div').show();
							} else {}
							$("#overlay").css("display","none");
						},
						error: function() {
							$("#overlay").css("display","none");
						}
					});
				}
			});

			$("#operator").change(function(){
				var operatorValue = $(this).val();
				if(operatorValue != ""){
					$("#overlay").css("display","block");
					$.ajax({	
						type: "POST",
						url: "ajax/load_categories.php",
						data: {
							operator_id: operatorValue,
						},
						success: function(responseData) {
							responseData = JSON.parse(responseData);
							// console.log(responseData);
							if(responseData['rowCount'] > 0){
								$("#category").empty();
								$.each(responseData['data'], function (i, item) {
									// console.log(item.category);
									$('#category').append($('<option>', { 
										value: item.id,
										text : item.category 
									}));
								});
								$("#category").prop("disabled", false);
							} else {

							}
							$("#overlay").css("display","none");
						},
						error: function() {
							$("#overlay").css("display","none");
						}
					});
				}
			});

			$("#submit_user").click(function(){
				let dataName = $(this).attr("data-name");
				$("form[name='user_profile']").validate({
					rules: {
						user_group: { 
							required: true
						},
						operator: { required: true },
						category: { required: true },
						full_name: { required: true },
						email: {
							required: true,
							email: true
						},
						language: { required: true },
						timezone: { required: true },
						address: { required: true },
						country: { required: true },
						state: { required: true },
						zip: { required: true },
						mobile: {
							required: true,
							digits: true,
							// phoneUS: true
						}
					},
					messages: {
						user_group: { 
							required: "Please select User Group"
						},
						operator: { 
							required: "Please select Operator"
						},
						category: { 
							required: "Please select Parent Category"
						},
						full_name: { 
							required: "Please enter your Full Name"
						},
						email: {
							required: "Please enter email address",
							email: "Please enter a valid email address"
						},
						language: { 
							required: "Please select Language"
						},
						timezone: { 
							required: "Please select Time Zone"
						},
						address: { 
							required: "Please enter Address"
						},
						country: { 
							required: "Please select Country"
						},
						state: { 
							required: "Please select State/Region"
						},
						zip: { 
							required: "Please enter Zip code"
						},
						mobile: {
							required: "Please enter Phone Number",
							digits: "Please enter valid Phone Number",
							phoneUS: "Please enter valid Phone Number"
						}
					},
					submitHandler: function(form) {
						form.submit();
						// alert(dataName);
						if(dataName == 'save'){
							var title = 'New User Account';
							var text = 'Are you sure you want to create user?';
						} else {
							var title = 'Edit User';
							var text = 'Are you sure you want to update this user?';
						}

						// $(form).easyconfirm({
						// 	locale: {
						// 		title: title,
						// 		text: text,
						// 		button: ['Cancel', ' Confirm'],
						// 		closeText: 'close'
						// 	}
						// });
						// $(form).click(function() {});
					},
					// errorPlacement: function(error, element) {
					// 	console.log(error);
					// }
				});
			});

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
	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	</body>

</html>