<div class="tab-pane <?php echo isset($tab_tenant_account) ? 'in active' : ''; ?>" id="tenant_account">
  <script type="text/javascript">
    function checkSessionDeleted(realm, mac, callback) {
      //alert('aa');
      var URL = 'ajax/checkSessionDeleted.php';
      var method = 'vtenant';
      var init_auth_data = {
        realm: realm,
        mac: mac,
        method: method
      };
      init_auth_data = JSON.stringify(init_auth_data);
      init_auth_data = CryptoJS.AES.encrypt(JSON.stringify(init_auth_data), '<?php echo $hgtadle67; ?>', {
        format: CryptoJSAesJson
      }).toString();
      var returnData;
      $.ajax({
        url: URL,
        type: "POST",
        data: {
          key: init_auth_data
        },
        success: function(msg, status, jqXHR) {
          //alert(msg);
          callback(msg);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert("Network Error");
        }
      });

    }
  </script>
  <?php if (isset($manage_customer_enable)) { //show manage customer area 
  ?>
    <script type="text/javascript">
      $(document).ready(function() {

        Tablesaw.init();
        $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block;'></label>");

      });
    </script>


    <?php
    if (isset($msg_edit)) {
      echo $msg_edit;
      $msg_edit = '';
    }
    $user_namen = $db->getValueAsf("SELECT username AS f FROM `mdu_vetenant` WHERE `customer_id`='$mg_customer_id' LIMIT 1");
    $device_count = $db->getValueAsf("SELECT  count(`mac_address`) as f FROM `mdu_customer_devices` WHERE `user_name`='$user_namen'");
    $max_count = $db->getValueAsf("SELECT  `device_limit` as f FROM `mdu_organizations` WHERE `property_id`='$mg_property_id'");
    ?>



    <div class="">

      <div class='acc_back' align="left" style="vertical-align:top;"><a href="manage_tenant.php?searchid=<?php echo $search_id; ?>" class="btn btn-info" style="text-decoration:none"><i class="icon-white icon-chevron-left"></i> Go Back</a></div>

      <div align="center" style="vertical-align:top;">
        <h2 style="font-size: 28px;"><strong>Manage Residents</strong></h2>
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

          <form id="edit_customer_form" name="edit_customer_form" action="manage_tenant.php" method="post" class="form-horizontal" enctype="multipart/form-data" onchange="customer_submitenable()">

            <?php

            echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" /><input type="hidden" name="search_id" id="search_id" value="' . $search_id . '" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="' . $mg_customer_id . '" />';

            ?>

            <fieldset class="add_field">

              <div class="columns">
                <h3><strong>Resident Account Details</strong></h3>
              </div>



              <div id="response_d1"></div>

              <?php if ($mg_property_type != 'MDU') { ?>

                <div class="control-group">

                  <div class="controls form-group">

                    <label class="" for="radiobtns">VLAN ID</label>

                    <input class="span4 form-control" id="vlan_id_details" name="vlan_id_details" type="text" style="width:70%;" value="<?php echo $vlan_id_details; ?>" readonly>


                  </div>
                </div>

              <?php  } ?>




              <div class="control-group">

                <div class="controls form-group">

                  <label class="" for="radiobtns">First Name<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <input class="span4 form-control" id="first_name" placeholder="Kim" name="first_name" type="text" style="display: block; width:70%;" value="<?php echo $mg_first_name; ?>">
                  <script type="text/javascript">
                    $("#first_name").keypress(function(event) {
                      var ew = event.which;
                      //if(ew == 32)
                      //                                     return true;
                      //                                   if(48 <= ew && ew <= 57)
                      //                                     return true;
                      if (ew == 39)
                        return true;
                      if (65 <= ew && ew <= 90)
                        return true;
                      if (97 <= ew && ew <= 122)
                        return true;
                      return false;
                    });


                    $('#first_name').bind("cut copy paste", function(e) {
                      e.preventDefault();
                    });
                  </script>
                </div>

                <!-- /controls -->
              </div>
              <!-- /control-group -->






              <div class="control-group">

                <div class="controls form-group">

                  <label class="" for="radiobtns">Last Name<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <input class="span4 form-control" id="last_name" placeholder="John" name="last_name" type="text" style="display: block;width:70%;" value="<?php echo $mg_last_name; ?>">
                  <script type="text/javascript">
                    $("#last_name").keypress(function(event) {
                      var ew = event.which;
                      //if(ew == 32)
                      //                                     return true;
                      //                                   if(48 <= ew && ew <= 57)
                      //                                     return true;
                      if (ew == 39)
                        return true;
                      if (65 <= ew && ew <= 90)
                        return true;
                      if (97 <= ew && ew <= 122)
                        return true;
                      return false;
                    });

                    $('#last_name').bind("cut copy paste", function(e) {
                      e.preventDefault();
                    });
                  </script>

                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->







              <div class="control-group">

                <div class="controls form-group">

                  <label class="" for="radiobtns">Email</label>

                  <input class="span4 form-control tenant_email" id="email" name="email" type="email" style="display: block;width:70%;" value="<?php echo $mg_email; ?>" readonly>


                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->






              <div class="control-group">

                <div class="controls form-group" style="position: relative;">

                  <label class="" for="radiobtns">New Account Password<sup>
                      <font color="#FF0000"></font>
                    </sup></label>

                  <input class="span4 form-control pass_msg" id="password" placeholder="******" name="password" type="password" style="display: inline;width:70% !important;" value="" autocomplete="new-password">
                  <i toggle="#password" style="display:inline !important;margin-left: -25px;position: relative !important;top: 0px !important; " class="paas_toogle btn-icon-only icon-eye-open toggle-password" id="n_pass"></i>

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

                <div class="controls form-group">

                  <label class="" for="radiobtns">Property</label>

                  <input class="span4 form-control" id="property_id" name="property_id" type="text" style="width:70%;" value="<?php echo $mg_property_id; ?>" readonly>




                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->



              <input id="room" name="room" type="hidden" value="<?php echo $mg_room_apt_no; ?>">
              <input id="comp_name" placeholder="" name="comp_name" type="hidden" value="<?php echo $mg_company_name; ?>">



              <div class="control-group">

                <div class="controls form-group">

                  <label class="" for="radiobtns">Street Address<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <textarea name="street_address" id="street_address" cols="250" class="span4 form-control" style="display: block;width:70%;"><?php echo $mg_address; ?></textarea>
                  <script type="text/javascript">
                    $("#street_address").keypress(function(event) {
                      var ew = event.which;
                      //alert (ew);
                      if (ew == 32 || ew == 35)
                        return true;
                      if (48 <= ew && ew <= 57)
                        return true;
                      if (65 <= ew && ew <= 90)
                        return true;
                      if (97 <= ew && ew <= 122)
                        return true;
                      return false;
                    });
                    $('#street_address').bind("cut copy paste", function(e) {
                      e.preventDefault();
                    });
                  </script>

                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->
              <div class="control-group">

                <div class="controls form-group">

                  <label class="" for="radiobtns">Country<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <select class="span4 form-control" name="country" id="country" style="display: block; width:72.5%;">
                    <option value="">Select Country</option>
                    <?php
                    $count_results = $db->selectDB("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                                    UNION ALL
                                    SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");
                    foreach ($count_results['data'] as $row) {
                      if ($row[a] == $mg_country || $row[a] == "US") {
                        $select = "selected";
                      } else {
                        $select = "";
                      }

                      echo '<option value="' . $row[a] . '" ' . $select . '>' . $row[b] . '</option>';
                    }
                    ?>
                  </select>

                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->
              <script type="text/javascript">
                // Countries
                var country_arr = new Array("United States of America", "Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

                // States
                var s_a = new Array();
                var s_a_val = new Array();
                s_a[0] = "";
                s_a_val[0] = "";
                <?php

                $get_regions = $db->selectDB("SELECT
        `states_code`,
        `description`
        FROM 
        `exp_country_states` ORDER BY description");

                $s_a = '';
                $s_a_val = '';

                foreach ($get_regions['data'] as $state) {
                  $s_a .= $state['description'] . '|';
                  $s_a_val .= $state['states_code'] . '|';
                }

                $s_a = rtrim($s_a, "|");
                $s_a_val = rtrim($s_a_val, "|");

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

                  if (selectedCountryIndex != 0) {
                    for (var i = 0; i < state_arr.length; i++) {
                      stateElement.options[stateElement.length] = new Option(state_arr[i], state_arr_val[i]);
                    }
                  }

                }

                function populateCountries(countryElementId, stateElementId) {

                  var countryElement = document.getElementById(countryElementId);

                  if (stateElementId) {
                    countryElement.onchange = function() {
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

                  <label class="" for="radiobtns">State/Province<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <select class="span4 form-control" id="state" name="state" style="display: block; width:72.5%;">
                    <?php

                    $get_regions = $db->selectDB("SELECT
 `states_code`,
 `description`
FROM
`exp_country_states` ORDER BY description ASC");

                    echo '<option value="">Select State</option>';

                    if ($mg_state == 'N/A') {
                      echo '<option selected value="N/A">Others</option>';
                    } else {
                      foreach ($get_regions['data'] as $state) {
                        //edit_state_region , get_edit_mno_state_region
                        if ($mg_state == $state['states_code']) {
                          echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                        } else {
                          echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                        }
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
                $(document).ready(function() {

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

                  <label class="" for="radiobtns">Postal Code<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <input class="span4 form-control" id="postal_code" placeholder="xxxxx" name="postal_code" type="text" value="<?php echo $mg_postal_code; ?>" maxlength="5" oninvalid="setCustomValidity('Invalid Postal Code')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" style="display: block; width:70%;">


                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->

              <script>
                $('#postal_code').on('keydown', function(e) {
                  if (e.keyCode < 48 && e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 39) {
                    e.preventDefault();
                  } else {
                    if (e.keyCode > 105) {
                      e.preventDefault();
                    } else {
                      if (e.keyCode < 96 && e.keyCode > 57) {
                        e.preventDefault();
                      } else {

                      }
                    }
                  }
                });

                $('#postal_code').bind("cut copy paste", function(e) {
                  e.preventDefault();
                });
              </script>

              <script type="text/javascript">
                $("#postal_code").keypress(function(event) {
                  var ew = event.which;
                  if (ew == 32)
                    return true;
                  if (48 <= ew && ew <= 57)
                    return true;
                  if (65 <= ew && ew <= 90)
                    return true;
                  if (97 <= ew && ew <= 122)
                    return true;
                  return false;
                });
              </script>



              <div class="control-group">

                <div class="controls form-group">

                  <label class="" for="radiobtns">City<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <input class="span4 form-control" id="city" placeholder="" name="city" type="text" maxlength="64" value="<?php echo $mg_city; ?>" style="display: block; width:70%;">
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

                    $('#city').bind("cut copy paste", function(e) {
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

                  <input class="span4 form-control mobile1_vali" id="phone" placeholder="xxx-xxx-xxxx" name="phone" type="text" maxlength="14" value="<?php echo $mg_phone; ?>" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" style="display: block; width:70%;">



                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->


              <script type="text/javascript">
                $(document).ready(function() {

                  $('#phone').focus(function() {
                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                  });


                  $('#phone').keyup(function() {

                    var phone_1 = $(this).val().replace(/[^\d]/g, "");
                    if (phone_1.length > 9) {
                      //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
                      var phone2 = phone_1.length;
                      if (phone_1.length > 10) {
                        var phone2 = phone_1.length;
                        $('#edit_customer_form')
                          .bootstrapValidator('enableFieldValidators', 'phone', false)
                        var phone_1 = phone_1.slice(0, 10);

                      }
                      $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                      //console.log(phone_1+'sss');
                      if (phone2 == 10) {
                        $('#edit_customer_form')
                          .bootstrapValidator('enableFieldValidators', 'phone', true);
                      }

                    } else {
                      $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                      $('#edit_customer_form')
                        .bootstrapValidator('enableFieldValidators', 'phone', true)
                    }

                    $('#edit_customer_form').bootstrapValidator('revalidateField', 'phone');
                  });

                  $("#phone").keypress(function(event) {
                    var ew = event.which;
                    //alert(ew);
                    if (ew == 8 || ew == 0 || ew == 46 || ew == 45)
                      return true;
                    if (48 <= ew && ew <= 57)
                      return true;
                    return false;
                  });

                  $("#phone").keydown(function(e) {


                    var mac = $('#phone').val();
                    var len = mac.length + 1;
                    //console.log(e.keyCode);
                    //console.log('len '+ len);

                    if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                      mac1 = mac.replace(/[^0-9]/g, '');


                      //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                      //console.log(valu);
                      //$('#phone_num_val').val(valu);

                    } else {
                      return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7, 4);

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
                      (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                      // Allow: Ctrl+C, Command+C
                      (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                      // Allow: Ctrl+x, Command+x
                      (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                      // Allow: Ctrl+V, Command+V
                      (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
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

                  $('.mobile1_vali').focus(function() {
                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                    $('#edit_customer_form').data('bootstrapValidator').updateStatus('phone', 'NOT_VALIDATED').validateField('phone');

                  });

                  $('.mobile1_vali').keyup(function() {

                    $('#edit_customer_form').data('bootstrapValidator').updateStatus('phone', 'NOT_VALIDATED').validateField('phone');

                  });


                });

                $('#phone').bind("cut copy paste", function(e) {
                  //e.preventDefault();
                });
              </script>

              <div class="control-group">

                <div class="controls form-group">

                  <label class="" for="radiobtns">Secret Question<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <select name="question" id="question" class="span4 form-control" style="display: block; width:72.5%;">

                    <?php
                    $key_query = "SELECT `question_id` AS a, `secret_question` AS b FROM `mdu_secret_questions` WHERE is_enable=1 OR  `secret_question`='$mg_question_id'  ORDER BY `question_id` ASC";

                    $query_results = $db->selectDB($key_query);

                    foreach ($query_results['data'] as $row) {
                      $a = $row['a'];
                      $b = $row['b'];
                      if ($b == $mg_question_id) {
                        echo '<option value="' . $b . '" selected>' . $b . '</option>';
                      } else {
                        echo '<option value="' . $b . '">' . $b . '</option>';
                      }
                    }


                    ?>
                  </select>

                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->




              <div class="control-group">

                <div class="controls form-group">

                  <label class="" for="radiobtns">Answer<sup>
                      <font color="#FF0000">*</font>
                    </sup></label>

                  <input class="span4 form-control" id="answer" placeholder="Answer" name="answer" type="text" style="display: block; width:70%;" value="<?php echo $mg_answer; ?>">


                </div>
                <!-- /controls -->
              </div>
              <!-- /control-group -->

              <script type="text/javascript">
                $("#answer").keypress(function(event) {
                  var ew = event.which;
                  //alert (ew);
                  if (ew == 32 || ew == 35)
                    return true;
                  if (48 <= ew && ew <= 57)
                    return true;
                  if (65 <= ew && ew <= 90)
                    return true;
                  if (97 <= ew && ew <= 122)
                    return true;

                  return false;
                });
                $('#answer').bind("cut copy paste", function(e) {
                  e.preventDefault();
                });
              </script>


              <div class="form-actions">
                <input type="hidden" name="edit_customer_uname" value="<?php echo $mg_username; ?>">
                <button type="submit" name="customer_submit" id="customer_submit" class="btn btn-primary">Update Account</button> <br>&nbsp; <strong>
                  <font color="#FF0000">*</font>
                  <font size="-2"> Required Field</font>
                </strong>

              </div>
              <!-- /form-actions -->
            </fieldset>
          </form>

          <script>
            $(document).ready(function() {
              document.getElementById("customer_submit").disabled = true;
            });

            function customer_submitenable() {
              document.getElementById("customer_submit").disabled = false;
            }
          </script>


        </div>
        <!-- /widget-content -->
      </div>
      <!-- /widget -->
    </div>
    <!-- /span6 -->
    <div class="span5a">
      <div class="widget">

        <!-- /widget-header -->
        <div class="widget-content">


          <div class="">
            <div class="widget">
              <!-- <div class="widget-header"> <i class="icon-th-list"></i>
                   <h3> Service Profile</h3>
                 </div> -->
              <div class="columns" style="margin-bottom: 5px">
                <h3><strong>Resident QoS Profile</strong></h3>
              </div>

              <div class="widget-content">

                <form id="profile_form" name="profile_form" action="manage_tenant.php?t=tenant_account" method="post" class="form-horizontal s_toggle" enctype="multipart/form-data">
                  <div class="control-group" style="margin-bottom: 30px;">
                    <?php
                    $_SESSION['PROF_RAND'] = RAND();

                    $get_tenant_profile = "SELECT `service_profile` AS f FROM `mdu_vetenant` WHERE `customer_id`='" . $mg_customer_id . "' LIMIT 1";
                    $tenant_profile = $db->getValueAsf($get_tenant_profile);
                    $get_tenant = "SELECT `qos_override` AS f FROM `mdu_vetenant` WHERE `customer_id`='" . $mg_customer_id . "' LIMIT 1";
                    $tenant_qos_profile = $tenant_profile = $db->getValueAsf($get_tenant);
                    //$tenant_profile_arry=explode(",",$tenant_profile);

                    // user profile

                    // default profile
                    /*$get_dist_profile="SELECT  p.product_code AS f FROM exp_products p JOIN  `mdu_organizations` o ON o.default_prof=p.product_id WHERE o.property_id='$mg_property_id'";*/
                    $query_service_profilen = "SELECT `product_code` as f  
                    FROM `exp_products_distributor`
                    WHERE distributor_code='$user_distributor' AND `network_type` = 'VT-DEFAULT'";

                    $query_product_id = "SELECT `product_id` as f  
                    FROM `exp_products_distributor`
                    WHERE distributor_code='$user_distributor' AND `network_type` = 'VT-DEFAULT'";

                    $get_dist_profile = "SELECT count(*) as count FROM exp_qos_distributor d LEFT JOIN exp_qos q ON d.`qos_id`=q.`qos_id`
                              WHERE distributor_code='$user_distributor'";

                    $resultArr = $db->select1DB($get_dist_profile);
                    $count = $resultArr[count];


                    if (strlen($edit_aleproduct) > 0) {
                      $service_profile_product = $edit_aleproduct;
                    } else {
                      $service_profile_product = $db->getValueAsf($query_service_profilen);
                    }
                    $service_profile_productn = $service_profile_product;
                    $service_product_id = $db->getValueAsf($query_product_id);


                    $service_profile_qos = $db->getValueAsf("SELECT `QOS` as f FROM `exp_products`
                    WHERE `network_type`='GUEST' AND `mno_id`='$mno_id' AND `product_id`='$service_product_id'");
                    //$profile_name_array=explode(",",$profile_name);

                    if ($service_profile_product = $tenant_profile) {
                      $match_value = 1;
                    } else {
                      $match_value = 0;
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
                    if ($count > 0) {
                      if ($get_profile_type == 'DEFAULT' && strlen($get_qos_override) < 1) {


                        echo "<input id=\"default_act\" type=\"checkbox\" data-toggle=\"toggle\" data-width=\"30\" data-height=\"20\" checked disabled=\"disabled\"  data-onstyle=\"success\" data-offstyle=\"warning\">";
                      } else {

                        echo "<a id=\"default_act_i\"><input id=\"default_act\" type=\"checkbox\" data-toggle=\"toggle\" data-width=\"30\" data-height=\"20\" data-onstyle=\"success\" data-offstyle=\"warning\"> </a>";
                      }

                      /*                         echo " <span class='txt_qos'>Default QoS [".$service_profile_qos."] <br>";
                      echo " Default Product [".$service_profile_productn."]</span>";*/
                      echo " Default Product [" . $service_profile_productn . "]";
                    } else {
                      /*                        echo " <span class='txt_qos_new'>Default QoS [".$service_profile_qos."] </span><br>";
*/
                      echo " <div class='txt_qos_new'>Default Product [" . $service_profile_productn . "]</div>";
                    }
                    ?>

                    <!-- <label class="control-label" for="switch">Default Profile <br><font size="1">(<?php foreach ($user_distributor as $pr) {
                                                                                                          echo $pr;
                                                                                                        } ?>) </font><sup><font color="#FF0000" >*</font></sup></label> -->
                    <!-- <label class="control-label" for="switch">Default Profile <br><font size="1">(<?php echo $service_profile_product; ?>)</font><sup><font color="#FF0000" >*</font></sup></label> service_profile_product -->



                    <script type="text/javascript" src="js/bootstrap-toggle.min.js"></script>
                    <script>
                      $(document).ready(function() {
                        var secret = '<?php echo $_SESSION['PROF_RAND']; ?>';
                        var search_id = '<?php echo $search_id ?>';
                        var up_customer_id = '<?php echo $mg_customer_id ?>';
                        var up_profile = '<?php echo $service_profile_product ?>';

                        $("#default_act_i").easyconfirm({
                          locale: {
                            title: 'Service Profile Active',
                            text: 'Are you sure you want to active this service profile?',
                            button: ['Cancel', ' Confirm'],
                            closeText: 'close'
                          }
                        });
                        $("#default_act_i").click(function() {

                          $('#default_act').bootstrapToggle('on');
                          $('#probation_act').bootstrapToggle('off');
                          $('#premium_act').bootstrapToggle('off');

                          window.location = "?token=" + secret + "&search_id=" + search_id + "&up_customer_id=" + up_customer_id + "&profile_name=" + up_profile + "&type=default"
                        });


                      });
                    </script>

                  </div>
                  <!-- /controls -->
                  <!--  <p><font size="2px">All tenants have this profile by default. It is set by the ISP.</font></p> -->
                  <?php
                  $get_dist_profile = "SELECT d.`id`,d.`qos_code`,q.`qos_name`,q.`network_type`,d.`qos_id` as qos FROM exp_qos_distributor d LEFT JOIN exp_qos q ON d.`qos_id`=q.`qos_id`
                              WHERE distributor_code='$user_distributor'";

                  $query_results_profile = $db->selectDB($get_dist_profile);

                  $row_count = $query_results_profile['rowCount'];

                  // if($row_count != 0){
                  //   echo '<div style="margin-bottom: 5px;"><b>Override QOS Profile</b><img data-toggle="tooltip" title="Use the Search Tenant field to search for existing tenants that have contacted you for assistance with their account. This could include updating personal information, adding or removing devices, upgrading account to a premium service, resetting their account password and also permanently deleting an account." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></div>'; 
                  // }




                  // probation profile

                  $flag = 0;
                  $dis_detail = $db->select1DB("SELECT other_settings FROM exp_mno_distributor WHERE distributor_code='$user_distributor' ORDER BY `id` DESC LIMIT 1");
                  $group_qos_enable = json_decode($dis_detail['other_settings'], true)['vt_product_group'];

                  if ($group_qos_enable != 1) {

                    foreach ($query_results_profile['data'] as $row_s) {

                      $qos_idd = $row_s['qos'];
                      $qos_name = $row_s['qos_name'];
                      $qos_code = $row_s['qos_code'];
                      $qos_id = $row_s['qos'];
                      $id = $row_s['id'];
                      $up_type = $row_s['network_type'];
                      if ($up_type == 'VT-Probation') {
                        $qos_type = 'probation';
                      }
                      if ($up_type == 'VT-Premium') {
                        $qos_type = 'premium';
                      }


                      if ($qos_idd == $tenant_qos_profile) {
                        $match_value = 1;
                        $flag = 1;
                        $qo_name = $qos_name;
                        $qo_code = $qos_code;
                        $qo_id = $id;
                        $qo_qos_id = $qos_id;
                        $qo_type = $qos_type;
                      } else {
                        $match_value = 0;
                      }

                      if ($match_value == 1) {


                        //echo "<input id=\"probation_act\" type=\"checkbox\" data-toggle=\"toggle\"   data-width=\"30\" data-height=\"20\" checked disabled=\"disabled\" data-onstyle=\"success\" data-offstyle=\"warning\"> ";
                      } else {
                        echo '<div class="control-group" style="margin-bottom:10px;">';

                        echo "<a id=\"probation_act_" . $id . "\"><input id=\"probation_acti\" type=\"checkbox\" data-toggle=\"toggle\"   data-width=\"30\" data-height=\"20\" data-onstyle=\"success\" data-offstyle=\"warning\" value=\"<?php echo $id;?>\"></a>";

                        $test = ' ' . $qos_name . ' [' . $qos_code . ']';
                        echo $test;
                        echo '</div>';

                  ?>
                        <script>
                          $(document).ready(function() {

                            var secret = '<?php echo $_SESSION['PROF_RAND']; ?>';
                            var id = '<?php echo $id; ?>';
                            var search_id = '<?php echo $search_id ?>';
                            var up_customer_id = '<?php echo $mg_customer_id ?>';
                            var up_profile = '<?php echo $qos_id; ?>';
                            var up_type = '<?php echo $qos_type; ?>';
                            var up_code = '<?php echo $qos_code; ?>';

                            $("#probation_act_" + id).easyconfirm({
                              locale: {
                                title: 'Service Profile Active',
                                text: 'Are you sure you want to activate this service profile?',
                                button: ['Cancel', ' Confirm'],
                                closeText: 'close'
                              }
                            });
                            $("#probation_act_" + id).click(function() {

                              $('#probation_act').bootstrapToggle('on');
                              $('#default_act').bootstrapToggle('off');
                              $('#premium_act').bootstrapToggle('off');

                              window.location = "?token=" + secret + "&search_id=" + search_id + "&up_customer_id=" + up_customer_id + "&profile_name=" + up_profile + "&type=" + up_type + "&qos_code=" + up_code
                            });


                          });
                        </script>
                    <?php }
                    }
                  }

                  if ($flag == 1) {

                    echo '<div style="margin-bottom: 5px;" id="q_override"><b>Override QoS Profile</b><img data-toggle="tooltip" title="Use the Search Resident field to search for existing residents that have contacted you for assistance with their account. This could include updating personal information, adding or removing devices, upgrading account to a premium service, resetting their account password and also permanently deleting an account." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></div>';

                    echo '<div class="control-group" style="margin-bottom:10px;">';

                    echo "<input id=\"probation_act\" type=\"checkbox\" data-toggle=\"toggle\"   data-width=\"30\" data-height=\"20\" checked disabled=\"disabled\" data-onstyle=\"success\" data-offstyle=\"warning\"> ";



                    $qo_test = ' ' . $qo_name . ' [' . $qo_code . ']';
                    echo $qo_test;
                    echo '</div>';

                    ?>


                    <script>
                      $(document).ready(function() {

                        var secret = '<?php echo $_SESSION['PROF_RAND']; ?>';
                        var id = '<?php echo $qo_id; ?>';
                        var search_id = '<?php echo $search_id ?>';
                        var up_customer_id = '<?php echo $mg_customer_id ?>';
                        var up_profile = '<?php echo $qo_qos_id; ?>';
                        var up_type = '<?php echo $qo_type; ?>';
                        var up_code = '<?php echo $qo_code; ?>';

                        $("#probation_act_" + id).easyconfirm({
                          locale: {
                            title: 'Service Profile Active',
                            text: 'Are you sure you want to activate this service profile?',
                            button: ['Cancel', ' Confirm'],
                            closeText: 'close'
                          }
                        });
                        $("#probation_act_" + id).click(function() {

                          $('#probation_act').bootstrapToggle('on');
                          $('#default_act').bootstrapToggle('off');
                          $('#premium_act').bootstrapToggle('off');

                          window.location = "?token=" + secret + "&search_id=" + search_id + "&up_customer_id=" + up_customer_id + "&profile_name=" + up_profile + "&type=" + up_type + "&qos_code=" + up_code
                        });


                      });
                    </script>

                  <?php  } ?>

















                  <!-- <div class="form-actions" >
                                   
                         
                         <a onclick="premium();" name="device_submit" id="device_submit" class="btn btn-primary">
                         <?php if ($get_profile_type == 'PREMIUM') echo "Change";
                          else echo "Activate"; ?>
                         
                         </a>&nbsp; <strong><font color="#FF0000">*</font><font size="-2"> Required</font></strong>
                         
                                   
                      </div> -->

                  <script>
                    function premium() {
                      var secret1 = '<?php echo $_SESSION['PROF_RAND']; ?>';
                      var search_id1 = '<?php echo $search_id ?>';
                      var up_customer_id1 = '<?php echo $mg_customer_id ?>';

                      var e = document.getElementById("premium_profile");
                      var up_profile1 = e.options[e.selectedIndex].value;


                      $('#probation_act').bootstrapToggle('off');
                      $('#default_act').bootstrapToggle('off');
                      $('#premium_act').bootstrapToggle('on');

                      if (up_profile1 != null || up_profile1 != '') {

                        window.location = "?token=" + secret1 + "&search_id=" + search_id1 + "&up_customer_id=" + up_customer_id1 + "&profile_name=" + up_profile1 + "&type=premium"

                      }

                    }
                  </script>






              </div>


              </fieldset>
              </form>


            </div>
          </div>

          <!--  device add -->

          <div class="row">
            <div class="span6a">

              <!-- /widget -->

              <!-- /widget -->
              <div class="widget">

                <div class="widget-content">


                  <?php if ($dpsk_enable) { ?>
                    <div>

                      <h3><strong>Unique Wi-Fi Password</strong></h3>
                      <br>
                      <form id="device_pass_form" name="device_pass_form" action="manage_tenant.php?t=tenant_account" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">




                        <?php
                        echo '<input type="hidden" name="form_secret" id="form_secret2" value="' . $_SESSION['FORM_SECRET'] . '" /><input type="hidden" name="search_id" id="search_id1" value="' . $search_id . '" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="' . $mg_customer_id . '" />';

                        ?>

                        <fieldset>


                          <div class="control-group">

                            <div class="controls form-group">

                              <?php
                              if ($dpsk_type == 'CLOUD_PATH_DPSK') {
                                $pass_tool = "Updating the password by either auto-generate or manually create a new password. Once you update the password all your wireless (Wi-Fi) devices will be disconnected and you will need to re-connect to the secure WI-Fi network using your updated passcode.                  ";
                              } else {
                                $pass_tool = "Connected devices will remain connected to Wi-Fi. After you disconnect a device, use your new password to reconnect to Wi-Fi.";
                              }
                              ?>
                              <label class="" for="radiobtns">New Unique Wi-Fi Password<img data-toggle="tooltip" class="tooltips" title="<?php echo $pass_tool; ?>" src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>

                              <div class="pass_de">
                                <div class="pass_inner"><i toggle="#passcode_key_de" style="display:inline !important; right: 2px !important;" class="paas_toogle btn-icon-only icon-eye-open com_toggle-password_de" id="de_pass"></i>



                                  <input class="span3 form-control " id="passcode_key_de" placeholder="******" name="passcode_key" type="password">
                                </div> &nbsp;
                                <i class=" btn-icon-only icon-refresh " id="auto_gen" style="display:inline  !important;"></i> &nbsp;
                                <button type="submit" name="device_pass_submit" id="device_pass_submit" style="display: inline-block; font-size: 14px;" class="btn btn-primary" disabled>Update Wi-Fi Password </button>
                              </div>

                              <?php if ($dpsk_type == 'CLOUD_PATH_DPSK') {
                                echo "<p>Once a  device has been registered via the self-care portal or by using the New Account Wi-Fi Network registration process, the resident uses this unique Wi-Fi password to logon to the Resident Wi-Fi Network. The password must at a minimum contain 8 characters (can be upper or lower case letters or both) plus 1 special character such as ~!@#$%^&*()_-</p>";
                              } else {
                                echo "<p>Once a  device has been registered via the self-care portal or by using the New Account Wi-Fi Network registration process, the resident uses this unique Wi-Fi password to logon to the Resident Wi-Fi Network. The password must be a at least 8 characters long.</p>";
                              } ?>

                            </div>
                            <!-- /controls -->
                          </div>
                          <!-- /control-group -->
                          <?php // $mno_id 
                          $voucher_patten_data = $vtenant_model->getVouchers($mno_id, 'PASSWORD');

                          if (empty($voucher_patten_data->min_length)) {
                            $voucher_patten_data = $vtenant_model->getVouchers('ADMIN', 'PASSWORD');
                          }

                          ?>

                          <script>
                            $("#auto_gen").click(function() {

                              // var seperator = document.getElementById('pass_seperator').value;
                              // var pass_min_length = document.getElementById('pass_min_length').value;
                              // var pass_max_length = document.getElementById('pass_max_length').value;
                              // var word_count = document.getElementById('pass_w_count').value;

                              var seperator = "<?php echo $voucher_patten_data->seperator; ?>";
                              var pass_min_length = "<?php echo $voucher_patten_data->min_length; ?>";
                              var pass_max_length = "<?php echo $voucher_patten_data->max_length; ?>";
                              var word_count = "<?php echo $voucher_patten_data->word_count; ?>";




                              $.ajax({
                                type: 'POST',
                                url: 'ajax/generater/keys_gen.php',
                                data: {
                                  seperator: seperator,
                                  pass_min_length: pass_min_length,
                                  pass_max_length: pass_max_length,
                                  word_count: word_count,
                                  generate_count: '1',
                                  generate_type: 'wifikey'
                                },
                                success: function(data) {

                                  //alert(data); 
                                  document.getElementById('passcode_key_de').value = data;
                                  $("#device_pass_submit").prop("disabled", false);

                                  //$('#device_pass_form').data('bootstrapValidator').revalidation();
                                  $('#device_pass_form').data('bootstrapValidator').resetForm();

                                },
                                error: function() {

                                }

                              });


                            });
                          </script>

                          <script type="text/javascript">
                            $(".com_toggle-password_de").click(function() {

                              $(this).toggleClass("icon-eye-close");
                              var input = $($(this).attr("toggle"));
                              if (input.attr("type") == "password") {
                                $('#passcode_key_de').attr("type", "text");
                              } else {
                                $('#passcode_key_de').attr("type", "password");
                              }
                            });
                          </script>

                          <!-- /form-actions -->
                        </fieldset>
                      </form>

                      <script type="text/javascript">
                        // function show_pass_buttton(pass_val,pass_id){
                        //                           //alert(pass_val.length);
                        //   if(pass_val.length==0){
                        //     document.getElementById(pass_id).style.display = "none";

                        //   }else{
                        //     document.getElementById(pass_id).style.display = "block";
                        //     }
                        //   }

                        // function show_pass(refer){ alert($('#'+refer).attr('type'));

                        //   if($('#'+refer).attr('type') != 'password'){ 
                        //     $('#'+refer).attr('type','password');
                        //   }
                        //   else{

                        //     $('#'+refer).attr('type','text');
                        //   }

                        // }
                      </script>




                    </div><br>
                  <?php } ?>




                  <?php
                  if ($dpsk_enable) {

                    $key_query = "SELECT device_limit AS f FROM `mdu_organizations` WHERE `property_number`='$mg_property_id'";

                    $query_results = $db->selectDB($key_query);
                    foreach ($query_results['data'] as $row) {
                      $settings_value = $row[f];
                      $max_allowed_devices_count = trim($settings_value);
                    }

                    //$max_allowed_devices_count = 10;
                    $max_allowed_devices = $max_allowed_devices_count;




                  ?>
                    <h3><strong>Device List</strong></h3>
                    <?php if ($device_count >= $max_count) {
                      echo '<font color="red">Max allowed device limit is reached and new devices can not be registered. </font><br><br>';
                    }

                    ?>
                    </br>

                    <script>
                      $(window).on("load resize", function() {
                        $(".device_table").css("width", $('.span5a').width());
                      });
                    </script>
                    <div class="widget widget-table action-table">
                      <div class="widget-content device_table">
                        <div style="overflow-x:auto">


                          <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap id="device_table">
                            <thead>
                              <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">#
                                </th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">NICKNAME
                                </th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC ID
                                </th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Add/REMOVE
                                </th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">ACTIVE SESSION
                                </th>
                                <?php if ($user_wired != 1) { ?>
                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Host Name
                                  </th>
                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">OS Vendor
                                  </th>
                                  <?php if ($deviceType_exist || $modelName_exist) { ?>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Model Name
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Device Type
                                    </th>
                                  <?php } ?>
                                  <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Uplink
                          </th>
                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Downlink
                          </th> -->
                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">IP Address
                                  </th>
                                <?php } ?>
                              </tr>
                            </thead>
                            <tbody>


                              <?php
                              $device_count_d = 0;
                              $no = 0;

                              // $key_query_d = "SELECT  id,`nick_name`,`email_address`,`description`,`mac_address`,`dpsk_key` 
                              //                   FROM `mdu_customer_devices` WHERE `user_name`='$user_name'";

                              $rowd = $db->select1DB("SELECT username AS f FROM `mdu_vetenant` WHERE `customer_id`='$mg_customer_id' LIMIT 1");
                              $cust_user_name = $rowd['f'];


                              $mg_property_query = "SELECT `property_type` FROM `mdu_organizations` WHERE `property_id`='$mg_property'";
                              $result_mg_property_arr = $db->select1DB($mg_property_query);
                              $mg_property_type = $result_mg_property_arr['property_type'];

                              if ($mg_property_type != 'MDU') {

                                $key_query_d = "SELECT d.id,d.nick_name,d.email_address,d.dpsk_key,d.cloutpath_id,d.is_wireless ,IF(d.description IS NULL ,t2.mac,d.description) AS description ,d.mac_address,IF(t2.mac IS NULL,'d','b') AS s_type ,
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
                         SELECT d.id, d.nick_name,d.email_address,d.dpsk_key,d.cloutpath_id,d.is_wireless,IF(d.description IS NULL ,t2.mac,d.description) AS description,d.mac_address,'s' AS s_type ,
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
                              } else {
                                $key_query_d = "SELECT  id,`nick_name`,`email_address`,`description`,`mac_address`,`dpsk_key`,`cloutpath_id`,`is_wireless`
                    FROM `mdu_customer_devices` WHERE `user_name`='$cust_user_name'";
                              }

                              $query_results_d = $db->selectDB($key_query_d);
                              foreach ($query_results_d['data'] as $row) {

                                $no++;
                                $id = $row['id'];
                                $nick_name = $row['nick_name'];
                                //$email_address = $row['email_address'];
                                $description = $row['description'];
                                $mac_id = $row['mac_address'];
                                $dpsk_key = $row['dpsk_key'];
                                $cloutpath_id = $row['cloutpath_id'];
                                $is_wireless = $row['is_wireless'];
                                $other_parameters = json_decode($row['other_parameters'], true);
                                $Session_IP = $other_parameters['Session_IP'];
                                $device_Type = $other_parameters['Device-Family'];

                                $mac_relm = explode('@', $mac_id);

                                $device_count_d++;


                                if ($mg_property_type != 'MDU') {
                                  $account_state = $row['create_user'];

                                  // if (empty($nick_name) || $nick_name == 'Field is Empty' || $nick_name == 'N/A') {
                                  //   $nick_name = "";
                                  // }


                                  if ($account_state == 'Active') {
                                    $session_active = 'YES';
                                  } else {
                                    $account_state = $row['create_user'];
                                    if ($account_state == 'Active') {
                                      $session_active = 'YES';
                                    } else {
                                      $session_active = 'NO';
                                    }
                                  }
                                } else {
                                  $query_ses_count = "SELECT * FROM `mdu_customer_sessions` WHERE  `mac` = '$mac_relm[0]' ORDER BY ID DESC LIMIT 1";
                                  $ex_mdu = $db->selectDB($query_ses_count);
                                  foreach ($ex_mdu['data'] as $rows) {
                                    $session_id = $rows['session_id'];
                                  }


                                  if ($ex_mdu['rowCount'] > 0) {
                                    $session_active = 'YES';
                                  } else {
                                    $session_active = 'NO';
                                  }
                                }

                                if (empty($nick_name) || $nick_name == 'Field is Empty' || $nick_name == 'N/A') {
                                  $nick_name = "";
                                }

                                $device_wa = '';
                                //$dpsk_device_up=='1';
                                if (empty($cloutpath_id) && $is_wireless == '1' && $dpsk_type == 'CLOUD_PATH_DPSK') {
                                  $device_wa = '<i data-toggle="tooltip" class=" btn-icon-only icon-warning-sign tooltips tooltipstered cld-warning"  style="display:inline !important; color: red;"  title="Please reconnect this device to the Resident Wi-Fi SSID using your new Wi-Fi password.  If you do not recognize the device, you can remove it by clicking “REMOVE”."></i>';
                                }

                                //if ($_GET['ed_device_id'] == $id) {
                                //if (empty($nick_name) || $nick_name == 'Field is Empty' || $nick_name == "" || $nick_name == 'N/A') {
                                if (true) {
                              ?>
                                  <tr>

                                    <td style="min-width: 42px;"><?php echo $device_wa . $no; ?>
                                      <form id="device_edit_form<?php echo $id; ?>" name="device_edit_submit<?php echo $id; ?>" action="manage_tenant.php?t=tenant_account" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onsubmit="return edit_validateForm<?php echo $id; ?>()">
                                    </td>
                                    <td>
                                      <div class="form-group" id="td_nick_name<?php echo $id; ?>"> <input class="span2 form-controls nick_name" type='text' id="nick_name<?php echo $id; ?>" name='nick_name' value="<?php echo $nick_name; ?>">
                                        <small class=" help-block" id="msg_nick_name<?php echo $id; ?>" style="display: none;"></small>

                                      </div>

                                    </td>






                                    <td><?php echo $db->macFormat($mac_relm[0], $mac_format); ?></td>

                                    <?php //if($dpsk_enable){
                                    ?>
                                    <!-- <td> 
            <div class="form-group" id="td_dpsk<?php //echo $id; 
                                                ?>"><input class="span4 form-controls" type='text' id="div_passcode_key<?php //echo $id; 
                                                                                                                        ?>" name='div_passcode_key' value="<?php //echo $dpsk_key; 
                                                                                                                                                            ?>"> 
            <small class=" help-block"  id="msg_dpsk<?php //echo $id; 
                                                    ?>"   style="display: none;"></small>

          </div>
            </td> -->
                                    <?php //} 
                                    ?>
                                    <td>
                                      <?php echo '<input type="hidden" name="form_secret" id="form_secret' . $id . '" value="' . $_SESSION['FORM_SECRET'] . '" /><input type="hidden" name="search_id" id="search_id1" value="' . $search_id . '" />
                    <input type="hidden" name="mac_address" id="mac_address" value="' . macDisplay($mac_relm[0]) . '" /><input type="hidden" name="divice_id" id="divice_id" value="' . $id . '" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="' . $mg_customer_id . '" />'; ?>


                                      <button type="submit" style="border-radius: 0px;padding-bottom: 4px !important; padding-top: 4px !important; min-width: 0 ;" href="javascript:void();" id="device_edit_submit<?php echo $id; ?>" name="device_edit_submit" class="btn btn-primary btn-small">
                                        Update</button> / <?php


                                                          echo ' <a  style="border-radius: 0px;" href="javascript:void();"  id="DR_' . $id . '"  class="btn btn-small">
           <i class="btn-icon-only icon-trash"></i>Remove</a>
           
           <script type="text/javascript">
$(document).ready(function() {
$(\'#DR_' . $id . '\').easyconfirm({locale: {
    title: \'Remove Connected Device \',
    text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
    button: [\'Cancel\',\' Confirm\'],
    closeText: \'close\'
       }});
  $(\'#DR_' . $id . '\').click(function() {
    
    window.location = "?t=tenant_account&token=' . $secret . '&customer_id=' . $mg_customer_id . '&search_id=' . $search_id . '&rm_device_id=' . $id . '&mac_id=' . $description . '"
                           
  });
  });
</script>';

                                                          ?>
                                      <script type="text/javascript">
                                        $(document).ready(function() {
                                          $('#device_edit_submit<?php echo $id; ?>').easyconfirm({
                                            locale: {
                                              title: 'Update Device ',
                                              text: 'Are you sure you want to update this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                              button: ['Cancel', ' Confirm'],
                                              closeText: 'close'
                                            }
                                          });
                                          $('#device_edit_submit<?php echo $id; ?>').click(function() {

                                          });
                                        });
                                      </script>
                                    </td>

                                    <td><?php echo $session_active; ?>
                                      <script type="text/javascript">
                                        $("#nick_name<?php echo $id; ?>").keyup(function() {
                                          document.getElementById("device_edit_submit<?php echo $id; ?>").disabled = false;

                                          var nic_val = false;
                                          nic_msg = "";

                                          if ($("#nick_name<?php echo $id; ?>").val() != "") {
                                            nic_val = true;
                                          } else {
                                            nic_msg = "This field is required";
                                          }


                                          if (!nic_val) {

                                            $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                            $("#td_nick_name<?php echo $id; ?>").addClass("has-error");
                                            $("#msg_nick_name<?php echo $id; ?>").css("display", "block");
                                          } else {
                                            $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                            $("#td_nick_name<?php echo $id; ?>").removeClass("has-error");
                                            $("#msg_nick_name<?php echo $id; ?>").css("display", "none");
                                          }

                                        });

                                        function edit_validateForm<?php echo $id; ?>() {

                                          var nic_val = false;
                                          var mac_val = false;
                                          var dpsk_val = false;

                                          nic_msg = "";

                                          dpsk_msg = "";

                                          //------------ Nic name validate --------------
                                          if ($("#nick_name<?php echo $id; ?>").val() != "") {
                                            nic_val = true;
                                          } else {
                                            nic_msg = "This field is required";
                                          }



                                          //------------ Device Pass Show --------------

                                          // if($("#div_passcode_key<?php //echo $id; 
                                                                    ?>" ).val()!=""){

                                          //  var dpsk_value = $("#div_passcode_key<?php //echo $id; 
                                                                                    ?>" ).val();

                                          //  var formData = {user_distributor: '<?php //echo $user_distributor 
                                                                                  ?>',div_passcode_key:dpsk_value,div_id: '<?php //echo $id 
                                                                                                                            ?>'};
                                          //                                                                         $.ajax({
                                          //                                                                             url: "ajax/dpsk_val.php",
                                          //                                                                             type: "POST",
                                          //                                      async: false,
                                          //                                                                             data: formData,
                                          //                                                                             success: function (data) {


                                          //                                         if (data == '{ "valid": true }') {
                                          //                                          dpsk_val = true;
                                          //                                        } else {
                                          //                                          dpsk_msg = "This Passcode Key already exists";

                                          //                                        }

                                          //                                                                             }
                                          //                                                                         });


                                          // }else{
                                          //  dpsk_msg = "This field is required";
                                          // }

                                          //------------ Msg Show --------------
                                          // if(nic_val && dpsk_val){
                                          if (nic_val) {
                                            return true;
                                          } else {

                                            if (!nic_val) {

                                              $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                              $("#td_nick_name<?php echo $id; ?>").addClass("has-error");
                                              $("#msg_nick_name<?php echo $id; ?>").css("display", "block");
                                            } else {
                                              $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                              $("#td_nick_name<?php echo $id; ?>").removeClass("has-error");
                                              $("#msg_nick_name<?php echo $id; ?>").css("display", "none");
                                            }


                                            //  if(!dpsk_val){

                                            //  $("#msg_dpsk<?php //echo $id; 
                                                            ?>" ).text( dpsk_msg );
                                            //  $("#td_dpsk<?php //echo $id; 
                                                            ?>").addClass("has-error");      
                                            //  $("#msg_dpsk<?php //echo $id; 
                                                            ?>").css("display", "block");
                                            // }else{
                                            //  $("#msg_dpsk<?php //echo $id; 
                                                            ?>" ).text( dpsk_msg );
                                            //  $("#td_dpsk<?php //echo $id; 
                                                            ?>").removeClass("has-error");     
                                            //  $("#msg_dpsk<?php //echo $id; 
                                                            ?>").css("display", "none");
                                            // }
                                            return false;
                                          }

                                          //return false;
                                        }
                                      </script>
                                      </form>
                                    </td>


                                    <?php
                                    if ($user_wired != 1) {
                                      $key = $description;
                                      $hostname = $device_data_arr[$key]['hostname'];
                                      $osVendorType = $device_data_arr[$key]['osVendorType'];
                                      $modelName = $device_data_arr[$key]['modelName'];
                                      $deviceType = $device_data_arr[$key]['deviceType'];
                                      $uplink = $device_data_arr[$key]['uplink'];
                                      $downlink = $device_data_arr[$key]['downlink'];
                                      $ipAddress = $device_data_arr[$key]['ipAddress'];
                                      if (strlen($hostname) < 1) {
                                        $hostname = "N/A";
                                      }
                                      if (strlen($modelName) < 1) {
                                        $modelName = "N/A";
                                      }
                                      if (strlen($osVendorType) < 1) {
                                        $osVendorType = "N/A";
                                      }
                                      if (strlen($deviceType) < 1) {
                                        if (strlen($device_Type) < 1) {
                                          $deviceType = "N/A";
                                        } else {
                                          $deviceType = $device_Type;
                                        }
                                      }
                                      if (strlen($uplink) < 1) {
                                        $uplink = "N/A";
                                      }
                                      if (strlen($downlink) < 1) {
                                        $downlink = "N/A";
                                      }
                                      if (strlen($ipAddress) < 1) {
                                        if (strlen($Session_IP) < 1) {
                                          $ipAddress = "N/A";
                                        } else {
                                          $ipAddress = $Session_IP;
                                        }
                                      }
                                      echo '<td> ' . $hostname . ' </td>';
                                      echo '<td> ' . $osVendorType . ' </td>';
                                      if ($deviceType_exist || $modelName_exist) {
                                        echo '<td> ' . $modelName . ' </td>';
                                        echo '<td> ' . $deviceType . ' </td>';
                                      }
                                      //echo '<td> ' . $uplink . ' </td>';
                                      //echo '<td> ' . $downlink . ' </td>';
                                      echo '<td> ' . $ipAddress . ' </td>';
                                    } ?>
                                  </tr>

                                <?php

                                } else {


                                  echo '<tr>
                  <td style="width: 100%;"> ' . $device_wa . $no . ' </td>
                  <td> ' . $nick_name . ' </td>               
                  <td> ' . $db->macFormat($mac_relm[0], $mac_format) . ' </td>';


                                  echo '<td>';





                                  echo ' <a  style="border-radius: 0px;" href="javascript:void();"  id="DR_' . $id . '"  class="btn btn-small">
           <i class="btn-icon-only icon-trash"></i>Remove</a>
           
           </td>
           
           <script type="text/javascript">
$(document).ready(function() {
$(\'#DR_' . $id . '\').easyconfirm({locale: {
    title: \'Remove Connected Device \',
    text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
    button: [\'Cancel\',\' Confirm\'],
    closeText: \'close\'
       }});
  $(\'#DR_' . $id . '\').click(function() {
    
    window.location = "?t=tenant_account&token=' . $secret . '&customer_id=' . $mg_customer_id . '&search_id=' . $search_id . '&rm_device_id=' . $id . '&mac_id=' . $description . '"
                           
  });
  });
</script>';

                                  echo '<td> ' . $session_active . ' </td>';
                                  if ($user_wired != 1) {
                                    $key = $description;
                                    $hostname = $device_data_arr[$key]['hostname'];
                                    $osVendorType = $device_data_arr[$key]['osVendorType'];
                                    $modelName = $device_data_arr[$key]['modelName'];
                                    $deviceType = $device_data_arr[$key]['deviceType'];
                                    $uplink = $device_data_arr[$key]['uplink'];
                                    $downlink = $device_data_arr[$key]['downlink'];
                                    $ipAddress = $device_data_arr[$key]['ipAddress'];
                                    if (strlen($hostname) < 1) {
                                      $hostname = "N/A";
                                    }
                                    if (strlen($modelName) < 1) {
                                      $modelName = "N/A";
                                    }
                                    if (strlen($osVendorType) < 1) {
                                      $osVendorType = "N/A";
                                    }
                                    if (strlen($deviceType) < 1) {
                                      if (strlen($device_Type) < 1) {
                                        $deviceType = "N/A";
                                      } else {
                                        $deviceType = $device_Type;
                                      }
                                    }
                                    if (strlen($uplink) < 1) {
                                      $uplink = "N/A";
                                    }
                                    if (strlen($downlink) < 1) {
                                      $downlink = "N/A666666";
                                    }
                                    if (strlen($ipAddress) < 1) {
                                      if (strlen($Session_IP) < 1) {
                                        $ipAddress = "N/A";
                                      } else {
                                        $ipAddress = $Session_IP;
                                      }
                                    }
                                    echo '<td> ' . $hostname . ' </td>';
                                    echo '<td> ' . $osVendorType . ' </td>';
                                    if ($deviceType_exist || $modelName_exist) {
                                      echo '<td> ' . $modelName . ' </td>';
                                      echo '<td> ' . $deviceType . ' </td>';
                                    }
                                    //echo '<td> ' . $uplink . ' </td>';
                                    //echo '<td> ' . $downlink . ' </td>';
                                    echo '<td> ' . $ipAddress . ' </td>';
                                  }
                                }
                              }

                              for ($di = 1; $di <= ($max_allowed_devices - $device_count_d); $di++) {
                                $no++;
                                ?>

                                <tr>

                                  <td><?php echo $no; ?>
                                    <form id="device_form<?php echo $di; ?>" name="device_form<?php echo $di; ?>" action="manage_tenant.php?t=tenant_account" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateForm<?php echo $di; ?>()">
                                  </td>
                                  <td>
                                    <div class="form-group" id="td_nick_name<?php echo $di; ?>"> <input class="span2 form-controls nick_name" type='text' id="nick_name<?php echo $di; ?>" name='nick_name'>
                                      <small class=" help-block" id="msg_nick_name<?php echo $di; ?>" style="display: none;"></small>
                                    </div>
                                    <?php
                                    echo '<input type="hidden" name="form_secret" id="form_secret_1' . $di . '" value="' . $_SESSION['FORM_SECRET'] . '" />
                <input type="hidden" name="search_id" id="search_id1' . $di . '" value="' . $search_id . '" />
                <input type="hidden" name="mg_customer_id" id="mg_customer_id1' . $di . '" value="' . $mg_customer_id . '" />';

                                    ?>
                                  </td>

                                  <td>
                                    <div class="form-group" id="td_mac<?php echo $di; ?>"> <input class="span2 form-controls" type='text' id="mac_address<?php echo $di; ?>" name='mac_address'>
                                      <small class=" help-block" id="msg_mac<?php echo $di; ?>" style="display: none;"></small>

                                    </div>
                                  </td>

                                  <?php //if($dpsk_enable){
                                  ?>
                                  <!-- <td> 
            <div class="form-group" id="td_dpsk<?php echo $di; ?>"><input class="span4 form-controls" type='text' id="div_passcode_key<?php echo $di; ?>" name='div_passcode_key' >
            <small class=" help-block"  id="msg_dpsk<?php echo $di; ?>"   style="display: none;"></small>
          </div>
            </td> -->
                                  <?php //} 
                                  ?>
                                  <td>

                                    <button type="submit" style="border-radius: 0px;padding-bottom: 4px !important; padding-top: 4px !important; min-width: 0 ;" href="javascript:void();" id="device_submit<?php echo $di; ?>" name="device_submit" class="btn btn-primary btn-small">
                                      Add</button>
                                    <script type="text/javascript">
                                      $(document).ready(function() {
                                        $('#device_submit<?php echo $di; ?>').easyconfirm({
                                          locale: {
                                            title: 'Add Device ',
                                            text: 'Are you sure you want to add this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                            button: ['Cancel', ' Confirm'],
                                            closeText: 'close'
                                          }
                                        });
                                        $('#device_submit<?php echo $di; ?>').click(function() {

                                        });
                                      });
                                    </script>
                                  </td>
                                  <td></td>
                                  <?php
                                  if ($user_wired != 1) {
                                    if ($deviceType_exist || $modelName_exist) { ?>
                                      <td></td>
                                      <td></td> <?php } ?>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      </form>
                                    </td>
                                  <?php } ?>

                                  <script type="text/javascript">
                                    $("#nick_name<?php echo $di; ?>").keyup(function() {
                                      document.getElementById("device_submit<?php echo $di; ?>").disabled = false;

                                      var nic_val = false;
                                      nic_msg = "";


                                      if ($("#nick_name<?php echo $di; ?>").val() != "") {
                                        nic_val = true;
                                      } else {
                                        nic_msg = "This field is required";
                                      }


                                      if (!nic_val) {

                                        $("#msg_nick_name<?php echo $di; ?>").text(nic_msg);
                                        $("#td_nick_name<?php echo $di; ?>").addClass("has-error");
                                        $("#msg_nick_name<?php echo $di; ?>").css("display", "block");
                                      } else {
                                        $("#msg_nick_name<?php echo $di; ?>").text(nic_msg);
                                        $("#td_nick_name<?php echo $di; ?>").removeClass("has-error");
                                        $("#msg_nick_name<?php echo $di; ?>").css("display", "none");
                                      }

                                    });




                                    $(document).ready(function() {
                                      $("#mac_address<?php echo $di; ?>").keyup(function() {


                                        document.getElementById("device_submit<?php echo $di; ?>").disabled = true;

                                        var mac_val = false;
                                        mac_msg = "";

                                        if ($("#mac_address<?php echo $di; ?>").val() != "") {

                                          var mac_value = $("#mac_address<?php echo $di; ?>").val();


                                          var macRGEX = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$|^([0-9A-Fa-f]{2}){5}([0-9A-Fa-f]{2})$/;

                                          var macResult = macRGEX.test(mac_value);

                                          if (macResult == false) {
                                            //mac_val = false;
                                            mac_msg = "Please enter a valid MAC address matching the pattern with the value range from 0-9, A-F";

                                          } else {
                                            document.getElementById("device_submit<?php echo $di; ?>").disabled = false;
                                            mac_val = true;
                                          }

                                        } else {
                                          mac_msg = "This field is required";
                                        }

                                        if (!mac_val) {

                                          $("#msg_mac<?php echo $di; ?>").text(mac_msg);
                                          $("#td_mac<?php echo $di; ?>").addClass("has-error");
                                          $("#msg_mac<?php echo $di; ?>").css("display", "block");
                                        } else {
                                          $("#msg_mac<?php echo $di; ?>").text(mac_msg);
                                          $("#td_mac<?php echo $di; ?>").removeClass("has-error");
                                          $("#msg_mac<?php echo $di; ?>").css("display", "none");
                                        }

                                      });
                                    });




                                    function validateForm<?php echo $di; ?>() {

                                      var nic_val = false;
                                      var mac_val = false;
                                      var dpsk_val = false;

                                      nic_msg = "";
                                      mac_msg = "";
                                      dpsk_msg = "";

                                      //------------ Nic name validate --------------
                                      if ($("#nick_name<?php echo $di; ?>").val() != "") {
                                        nic_val = true;
                                      } else {
                                        nic_msg = "This field is required";
                                      }

                                      //------------ MAC validate --------------
                                      if ($("#mac_address<?php echo $di; ?>").val() != "") {

                                        var mac_value = $("#mac_address<?php echo $di; ?>").val();



                                        var macRGEX = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$|^([0-9A-Fa-f]{2}){5}([0-9A-Fa-f]{2})$/;

                                        var macResult = macRGEX.test(mac_value);

                                        if (macResult == false) {
                                          //mac_val = false;
                                          mac_msg = "Please enter a valid MAC address matching the pattern with the value range from 0-9, A-F";

                                        } else {

                                          mac_val = true;
                                        }

                                      } else {
                                        mac_msg = "This field is required";
                                      }

                                      if (nic_val && mac_val) {
                                        return true;
                                      } else {

                                        if (!nic_val) {

                                          $("#msg_nick_name<?php echo $di; ?>").text(nic_msg);
                                          $("#td_nick_name<?php echo $di; ?>").addClass("has-error");
                                          $("#msg_nick_name<?php echo $di; ?>").css("display", "block");
                                        } else {
                                          $("#msg_nick_name<?php echo $di; ?>").text(nic_msg);
                                          $("#td_nick_name<?php echo $di; ?>").removeClass("has-error");
                                          $("#msg_nick_name<?php echo $di; ?>").css("display", "none");
                                        }

                                        if (!mac_val) {

                                          $("#msg_mac<?php echo $di; ?>").text(mac_msg);
                                          $("#td_mac<?php echo $di; ?>").addClass("has-error");
                                          $("#msg_mac<?php echo $di; ?>").css("display", "block");
                                        } else {
                                          $("#msg_mac<?php echo $di; ?>").text(mac_msg);
                                          $("#td_mac<?php echo $di; ?>").removeClass("has-error");
                                          $("#msg_mac<?php echo $di; ?>").css("display", "none");
                                        }


                                        return false;
                                      }

                                      //return false;
                                    }
                                  </script>
                                  </td>

                                </tr>


                              <?php } ?>
                            </tbody>
                          </table>


                          <?php
                          if ($db->getNumRows($key_query_d) >= 30) {
                          ?>
                            <p style="color: red;" class="dpsk_device_alert" id="dpsk_device_alert">You have reached your device limit. Please click the link below to log into your account and remove unused devices. Then you can add more devices.</p>
                          <?php } ?>

                        </div>

                      </div>
                    </div>
                    <script type="text/javascript">
                      $(".nick_name").keypress(function(event) {
                        var ew = event.which;
                        if (ew == 32 || ew == 8 || ew == 0)
                          return true;
                        if (48 <= ew && ew <= 57)
                          return true;
                        if (65 <= ew && ew <= 90)
                          return true;
                        if (97 <= ew && ew <= 122)
                          return true;
                        return false;
                      });
                    </script>

                    <!-- --------------------------end dpsk------------------------------------------- -->


                  <?php } else { ?>

                    <form id="device_form" name="device_form" action="manage_tenant.php?t=tenant_account" method="post" class="form-horizontal" style="margin: 0 0 -60px;" enctype="multipart/form-data">

                      <?php
                      echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" /><input type="hidden" name="search_id" id="search_id" value="' . $search_id . '" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="' . $mg_customer_id . '" />';

                      ?>

                      <fieldset class="se_main_field">

                        <div class="se_field">
                          <div id="response_d2"></div>

                          <div class="control-group">

                            <div class="controls form-group">
                              <div class="columns" style="margin-bottom: 5px">
                                <h3><strong style="padding-left: 3%;">Manually Add Resident Devices</strong></h3>
                              </div>
                            </div>

                          </div>





                          <?php

                          $key_query = "SELECT device_limit AS f FROM `mdu_organizations` WHERE `property_number`='$mg_property_id'";

                          $query_results = $db->selectDB($key_query);
                          foreach ($query_results['data'] as $row) {
                            $settings_value = $row[f];
                            $max_allowed_devices_count = trim($settings_value);
                          }

                          //$max_allowed_devices_count = 10;
                          $max_allowed_devices = $max_allowed_devices_count - 1;

                          if ($device_count >= $max_count) {
                            echo '<font color="red">Max allowed device limit is reached and new devices can not be registered. </font><br>';
                          }
                          ?>



                          <div class="control-group" style=" margin-left: 10px;">

                            <div class="controls form-group">

                              <label class="" for="radiobtns">MAC Address<sup>
                                  <font color="#FF0000">*</font>
                                </sup></label>

                              <input class=" form-control" id="mac_address" name="mac_address" maxlength="17" type="text" style="width:82%;">


                            </div>
                            <!-- /controls -->
                          </div>
                          <!-- /control-group -->
                          <script type="text/javascript">
                            function mac_val(element) {



                              setTimeout(function() {
                                var mac = $('#mac_address').val();

                                var pattern = new RegExp("[/-]", "g");
                                var mac = mac.replace(pattern, "");

                                // alert(mac);
                                var result = '';
                                var len = mac.length;

                                // alert(len);

                                var regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;



                                if (regex.test(mac) == true) {

                                  //  if( (len<5 && mac.charAt(3)==':') || (len<8 && mac.charAt(3)==':' && mac.charAt(6)==':') || (len<11 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':') || (len<14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':') || (len>14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':' && && mac.charAt(15)==':') ){

                                } else {

                                  /*for (i = 0; i < len; i+=2) {
                 
         
                 
                 
                 if(i==10){
         
                   result+=mac.charAt(i)+mac.charAt(i+1);
                   
                   }else{   
           
                 result+=mac.charAt(i)+mac.charAt(i+1)+':';
         
                   }
                 
                 
                
               }*/

                                  var pattern = new RegExp("[/-]", "g");
                                  var mac = mac.replace(pattern, "");
                                  var pattern1 = new RegExp("[/:]", "g");
                                  mac = mac.replace(pattern1, "");

                                  var mac1 = mac.match(/.{1,2}/g).toString();

                                  var pattern = new RegExp("[/,]", "g");

                                  var mac2 = mac1.replace(pattern, ":");


                                  document.getElementById('mac_address').value = mac2;

                                  $('#device_form').bootstrapValidator('revalidateField', 'mac_address');


                                }


                              }, 100);


                            }

                            $("#mac_address").on('paste', function() {

                              mac_val(this.value);

                            });
                          </script>




                          <script type="text/javascript">
                            $(document).ready(function() {

                              $('#mac_address').change(function() {


                                $(this).val($(this).val().replace(/(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})/, '$1:$2:$3:$4:$5:$6'))


                              });



                              $('#mac_address').keyup(function(e) {
                                var mac = $('#mac_address').val();
                                var len = mac.length + 1;


                                if (e.keyCode != 8) {

                                  if (len % 3 == 0 && len != 0 && len < 18) {
                                    $('#mac_address').val(function() {
                                      return $(this).val().substr(0, len) + ':' + $(this).val().substr(len);
                                      //i++;
                                    });
                                  }
                                }
                              });


                              $('#mac_address').keydown(function(e) {
                                var mac = $('#mac_address').val();
                                var len = mac.length + 1;


                                if (e.keyCode != 8) {

                                  if (len % 3 == 0 && len != 0 && len < 18) {
                                    $('#mac_address').val(function() {
                                      return $(this).val().substr(0, len) + ':' + $(this).val().substr(len);
                                      //i++;
                                    });
                                  }
                                }





                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
                                  // Allow: Ctrl+A, Command+A
                                  (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                  // Allow: Ctrl+C, Command+C
                                  (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                                  // Allow: Ctrl+x, Command+x
                                  (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                                  // Allow: Ctrl+V, Command+V
                                  (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
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



                          <div class="control-group" style=" margin-left: 10px;">

                            <div class="controls form-group">

                              <label class="" for="radiobtns">Nickname<sup>
                                  <font color="#FF0000">*</font>
                                </sup></label>

                              <input class=" form-control" id="nick_name" name="nick_name" type="text" style="width:82%; ">


                            </div>
                            <!-- /controls -->
                          </div>
                          <!-- /control-group -->


                          <script type="text/javascript">
                            $("#nick_name").keypress(function(e) {


                              if (e.which > 32 && e.which < 48 ||
                                (e.which > 57 && e.which < 65) ||
                                (e.which > 90 && e.which < 97) ||
                                e.which > 122) {
                                e.preventDefault();
                              }


                            });
                          </script>











                          <div style="border-top: 1px solid #ddd;width:85%; margin-left: 10px; ">
                          </div>
                          <div class="form-actions" style="border-top: 0px !important; margin-left: 10px;">
                            <br>
                            <?php
                            if ($device_count >= $max_count) { ?>
                              <button type="button" class="btn btn-primary" disabled="disabled">Register</button>&nbsp;
                              <!-- <strong><font color="#FF0000">*</font><font size="-2"> Required</font></strong> -->
                            <?php } else { ?>
                              <button type="submit" name="device_submit" id="device_submit" class="btn btn-primary">Register</button>&nbsp;
                              <!-- <strong><font color="#FF0000">*</font><font size="-2"> Required</font></strong> -->
                            <?php } ?>

                          </div>
                          <!-- /form-actions -->

                        </div>
                      </fieldset><br /><br />
                    </form>
                  <?php } ?>

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
          <?php if (!$dpsk_enable) { ?>
            <div class="control-group">

              <div class="controls form-group">
                <div class="columns" style="margin-bottom: 5px">
                  <h3><strong>Resident Device List</strong></h3>
                </div>
              </div>

            </div>
          <?php } ?>
          <div class="widget widget-table action-table">
            <div class="table_response_half">

              <div style="overflow-x:auto">
                <?php if (!$dpsk_enable) { ?>
                  <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                    <thead>
                      <tr>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">NICKNAME
                        </th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">MAC ADDRESS
                        </th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Add/REMOVE
                        </th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">ACTIVE SESSION
                        </th>
                        <?php if ($user_wired != 1) { ?>
                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Host Name
                          </th>
                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">OS Vendor
                          </th>
                          <?php if ($deviceType_exist || $modelName_exist) { ?>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Model Name
                            </th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Device Type
                            </th>
                          <?php } ?>
                          <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Uplink
                          </th>
                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Downlink
                          </th> -->
                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">IP Address
                          </th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>




                      <?php



                      $rowd = $db->select1DB("SELECT username AS f FROM `mdu_vetenant` WHERE `customer_id`='$mg_customer_id' LIMIT 1");
                      $cust_user_name = $rowd['f'];


                      $mg_property_query = "SELECT `property_type` FROM `mdu_organizations` WHERE `property_id`='$mg_property'";
                      $result_mg_property_arr = $db->select1DB($mg_property_query);
                      $mg_property_type = $result_mg_property_arr['property_type'];

                      if ($mg_property_type != 'MDU') {


                        $key_query = "SELECT d.id,d.nick_name,d.email_address ,IF(d.description IS NULL ,t2.mac,d.description) AS description ,d.mac_address,IF(t2.mac IS NULL,'d','b') AS s_type ,
                         t2.start_time, t2.account_state,d.create_user,d.other_parameters,
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
                         t2.start_time, t2.account_state,d.create_user,d.other_parameters,
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



                        $query_results = $db->selectDB($key_query);
                        $number_of_results = $query_results['rowCount'];
                        $table_array = array();
                        $table_array_count = 0;
                        foreach ($query_results['data'] as $row) {

                          $id = $row['id'];
                          $nick_name = $row['nick_name'];
                          //$email_address = $row['email_address'];
                          $description = $row['description'];
                          $mac_id = $row['mac_address'];
                          $rec_type = $row['s_type'];
                          $session_id = $row['session_id'];
                          $account_state = $row['account_state'];
                          $acc_states = $row['create_user'];
                          $other_parameters = json_decode($row['other_parameters'], true);
                          $Session_IP = $other_parameters['Session_IP'];
                          $device_Type = $other_parameters['Device-Family'];


                          if ($rec_type == 'd') {
                            $div_btn_disable = 'disabled="disabled"';
                          } elseif ($rec_type == 's') {
                            $ses_btn_disable = 'disabled="disabled"';
                          }

                          $mac_relm = explode('@', $mac_id);
                          /* print_r($mac_relm);
                           echo "<br>"; */
                          $table_array[$mac_relm[0]][id] = $id;
                          $table_array[$mac_relm[0]][nick] = $nick_name;
                          $table_array[$mac_relm[0]][stat] = $acc_states;
                          $table_array[$mac_relm[0]][rec] = $rec_type;
                          $table_array[$mac_relm[0]][ip] = $Session_IP;
                          $table_array[$mac_relm[0]][type] = $device_Type;
                          //$table_array[$mac_relm[1]][de]=$description;


                          if ($table_array_count > 0) {
                            if ($table_array[$description][state] != 'Active') {
                              $table_array[$description][state] = $account_state;
                            }
                          } else {
                            $table_array[$description][state] = $account_state;
                          }



                          $table_array_count++;
                        }

                        //  print_r($table_array);
                        $count_device = 0;

                        foreach ($table_array as $key => $value) {
                          $count_device = $count_device + 1;
                          //  echo $key;
                          $id = $value['id'];
                          $Session_IP = $value['ip'];
                          $device_Type = $value['type'];

                          $nick_name_des = $value['nick'];

                          if ($value['stat'] == 'Active') {
                            $session_active = 'YES';
                          } else {
                            $session_active = 'NO';
                          }

                          if (empty($nick_name_des) || $nick_name_des == 'Field is Empty' || $nick_name_des == 'N/A') {
                            $nick_name_des = "";
                          }

                          // if (empty($nick_name_des) || $nick_name_des == 'Field is Empty' || $nick_name_des == "" || $nick_name_des == 'N/A') {
                          if (true) {
                      ?>


                            <tr>


                              <td>
                                <form id="device_edit_form<?php echo $id; ?>" name="device_edit_submit<?php echo $id; ?>" action="manage_tenant.php?t=tenant_account" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onsubmit="return edit_validateForm<?php echo $id; ?>()">
                                  <div class="form-group" id="td_nick_name<?php echo $id; ?>"> <input class="span2 form-controls nick_name" type='text' id="nick_name<?php echo $id; ?>" name='nick_name' value="<?php echo $nick_name_des; ?>">
                                    <small class=" help-block" id="msg_nick_name<?php echo $id; ?>" style="display: none;"></small>

                                  </div>
                                  <?php
                                  echo '<input type="hidden" name="form_secret" id="form_secret' . $id . '" value="' . $_SESSION['FORM_SECRET'] . '" /><input type="hidden" name="search_id" id="search_id1" value="' . $search_id . '" />
                    <input type="hidden" name="mac_address" id="mac_address" value="' . macDisplay($key) . '" /><input type="hidden" name="divice_id" id="divice_id" value="' . $id . '" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="' . $mg_customer_id . '" />';

                                  ?>
                              </td>
                              <td><?php echo  $db->macFormat($key, $mac_format); ?></td>


                              <td>



                                <button type="submit" style="border-radius: 0px;padding-bottom: 4px !important; padding-top: 4px !important; min-width: 0 ;" href="javascript:void();" id="device_edit_submit<?php echo $id; ?>" name="device_edit_submit" class="btn btn-primary btn-small">
                                  Update</button> / <?php

                                                    echo ' <a  style="border-radius: 0px;" href="javascript:void();"  id="DR_' . $id . '"  class="btn btn-small">
                        <i class="btn-icon-only icon-trash"></i>Remove</a>
                        
                        <script type="text/javascript">
              $(document).ready(function() {
              $(\'#DR_' . $id . '\').easyconfirm({locale: {
                  title: \'Remove Connected Device \',
                  text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                  button: [\'Cancel\',\' Confirm\'],
                  closeText: \'close\'
                    }});
                $(\'#DR_' . $id . '\').click(function() {
                
                  window.location = "?t=tenant_account&token=' . $secret . '&customer_id=' . $mg_customer_id . '&search_id=' . $search_id . '&rm_device_id=' . $id . '&mac_id=' . $key . '"
                                        
                });
                });
              </script>';

                                                    ?>
                                <script type="text/javascript">
                                  $(document).ready(function() {
                                    $('#device_edit_submit<?php echo $id; ?>').easyconfirm({
                                      locale: {
                                        title: 'Update Device ',
                                        text: 'Are you sure you want to update this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                        button: ['Cancel', ' Confirm'],
                                        closeText: 'close'
                                      }
                                    });
                                    $('#device_edit_submit<?php echo $id; ?>').click(function() {

                                    });
                                  });
                                </script>
                              </td>
                              <?php

                              echo '<td> ' . $session_active;

                              ?>

                              <script type="text/javascript">
                                $("#nick_name<?php echo $id; ?>").keyup(function() {
                                  document.getElementById("device_edit_submit<?php echo $id; ?>").disabled = false;

                                  var nic_val = false;
                                  nic_msg = "";

                                  if ($("#nick_name<?php echo $id; ?>").val() != "") {
                                    nic_val = true;
                                  } else {
                                    nic_msg = "This field is required";
                                  }


                                  if (!nic_val) {

                                    $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                    $("#td_nick_name<?php echo $id; ?>").addClass("has-error");
                                    $("#msg_nick_name<?php echo $id; ?>").css("display", "block");
                                  } else {
                                    $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                    $("#td_nick_name<?php echo $id; ?>").removeClass("has-error");
                                    $("#msg_nick_name<?php echo $id; ?>").css("display", "none");
                                  }

                                });

                                function edit_validateForm<?php echo $id; ?>() {

                                  var nic_val = false;
                                  var mac_val = false;
                                  var dpsk_val = false;

                                  nic_msg = "";

                                  dpsk_msg = "";

                                  //------------ Nic name validate --------------
                                  if ($("#nick_name<?php echo $id; ?>").val() != "") {
                                    nic_val = true;
                                  } else {
                                    nic_msg = "This field is required";
                                  }



                                  //------------ Msg Show --------------
                                  // if(nic_val && dpsk_val){
                                  if (nic_val) {
                                    return true;
                                  } else {

                                    if (!nic_val) {

                                      $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                      $("#td_nick_name<?php echo $id; ?>").addClass("has-error");
                                      $("#msg_nick_name<?php echo $id; ?>").css("display", "block");
                                    } else {
                                      $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                      $("#td_nick_name<?php echo $id; ?>").removeClass("has-error");
                                      $("#msg_nick_name<?php echo $id; ?>").css("display", "none");
                                    }


                                    //  if(!dpsk_val){

                                    //  $("#msg_dpsk<?php //echo $id; 
                                                    ?>" ).text( dpsk_msg );
                                    //  $("#td_dpsk<?php //echo $id; 
                                                    ?>").addClass("has-error");      
                                    //  $("#msg_dpsk<?php //echo $id; 
                                                    ?>").css("display", "block");
                                    // }else{
                                    //  $("#msg_dpsk<?php //echo $id; 
                                                    ?>" ).text( dpsk_msg );
                                    //  $("#td_dpsk<?php //echo $id; 
                                                    ?>").removeClass("has-error");     
                                    //  $("#msg_dpsk<?php //echo $id; 
                                                    ?>").css("display", "none");
                                    // }
                                    return false;
                                  }

                                  //return false;
                                }
                              </script>

                              </form>
                              </td>

                              <?php if ($user_wired != 1) {
                                $hostname = $device_data_arr[$key]['hostname'];
                                $osVendorType = $device_data_arr[$key]['osVendorType'];
                                $modelName = $device_data_arr[$key]['modelName'];
                                $deviceType = $device_data_arr[$key]['deviceType'];
                                $uplink = $device_data_arr[$key]['uplink'];
                                $downlink = $device_data_arr[$key]['downlink'];
                                $ipAddress = $device_data_arr[$key]['ipAddress'];
                                if (strlen($hostname) < 1) {
                                  $hostname = "N/A";
                                }
                                if (strlen($modelName) < 1) {
                                  $modelName = "N/A";
                                }
                                if (strlen($osVendorType) < 1) {
                                  $osVendorType = "N/A";
                                }
                                if (strlen($deviceType) < 1) {
                                  if (strlen($device_Type) < 1) {
                                    $deviceType = "N/A";
                                  } else {
                                    $deviceType = $device_Type;
                                  }
                                }
                                if (strlen($uplink) < 1) {
                                  $uplink = "N/A";
                                }
                                if (strlen($downlink) < 1) {
                                  $downlink = "N/A";
                                }
                                if (strlen($ipAddress) < 1) {
                                  if (strlen($Session_IP) < 1) {
                                    $ipAddress = "N/A";
                                  } else {
                                    $ipAddress = $Session_IP;
                                  }
                                }
                                echo '<td> ' . $hostname . ' </td>';
                                echo '<td> ' . $osVendorType . ' </td>';
                                if ($deviceType_exist || $modelName_exist) {
                                  echo '<td> ' . $modelName . ' </td>';
                                  echo '<td> ' . $deviceType . ' </td>';
                                }
                                //echo '<td> ' . $uplink . ' </td>';
                                //echo '<td> ' . $downlink . ' </td>';
                                echo '<td> ' . $ipAddress . ' </td>';
                              }
                              ?>
                            </tr>



                          <?php

                          } else {



                            echo '<tr>
                           <td> ' . $value[nick] . ' </td>
                         
                           <td> ' . $db->macFormat($key, $mac_format) . ' </td>';

                            echo '<td class="td_btn">';
                            if ($value[rec] == 'b' || $value[rec] == 'd') {
                              echo '<a href="javascript:void();"  id="DR_' . $value[id] . '"  class="btn  btn-small td_btn_last" >
                           <i class="btn-icon-only icon-trash"></i>Remove</a>
                           </td><script type="text/javascript">
                           $(document).ready(function() {
                           $(\'#DR_' . $value[id] . '\').easyconfirm({locale: {
                               title: \'Remove Connected Device \',
                               text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                               button: [\'Cancel\',\' Confirm\'],
                               closeText: \'close\'
                              }});
                             $(\'#DR_' . $value[id] . '\').click(function() {
                               window.location = "?t=tenant_account&token=' . $secret . '&customer_id=' . $mg_customer_id . '&search_id=' . $search_id . '&rm_device_id=' . $value[id] . '&mac_id=' . $key . '"
                             });
                             });
                           </script>';
                            }



                            echo '<td> ' . $session_active . ' </td>';
                            if ($user_wired != 1) {
                              $hostname = $device_data_arr[$key]['hostname'];
                              $osVendorType = $device_data_arr[$key]['osVendorType'];
                              $modelName = $device_data_arr[$key]['modelName'];
                              $deviceType = $device_data_arr[$key]['deviceType'];
                              $uplink = $device_data_arr[$key]['uplink'];
                              $downlink = $device_data_arr[$key]['downlink'];
                              $ipAddress = $device_data_arr[$key]['ipAddress'];
                              if (strlen($hostname) < 1) {
                                $hostname = "N/A";
                              }
                              if (strlen($modelName) < 1) {
                                $modelName = "N/A";
                              }
                              if (strlen($osVendorType) < 1) {
                                $osVendorType = "N/A";
                              }
                              if (strlen($deviceType) < 1) {
                                if (strlen($device_Type) < 1) {
                                  $deviceType = "N/A";
                                } else {
                                  $deviceType = $device_Type;
                                }
                              }
                              if (strlen($uplink) < 1) {
                                $uplink = "N/A";
                              }
                              if (strlen($downlink) < 1) {
                                $downlink = "N/A";
                              }
                              if (strlen($ipAddress) < 1) {
                                if (strlen($Session_IP) < 1) {
                                  $ipAddress = "N/A";
                                } else {
                                  $ipAddress = $Session_IP;
                                }
                              }
                              echo '<td> ' . $hostname . ' </td>';
                              echo '<td> ' . $osVendorType . ' </td>';
                              if ($deviceType_exist || $modelName_exist) {
                                echo '<td> ' . $modelName . ' </td>';
                                echo '<td> ' . $deviceType . ' </td>';
                              }
                              //echo '<td> ' . $uplink . ' </td>';
                              ///echo '<td> ' . $downlink . ' </td>';
                              echo '<td> ' . $ipAddress . ' </td>';
                            }
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
                                   window.location = "?t=tenant_account&token='.$secret.'&customer_id='.$mg_customer_id.'&search_id='.$search_id.'&rm_ses_id='.$value[id].'&mac_id='.$key.'"
                                 });
                                 });
                               </script>';

                             }

                            echo '</td>';*/

                            // End Session Handling MDU //
                          }
                        }
                      } else {


                        $key_query = "SELECT d.id,d.nick_name,d.email_address ,IF(d.description IS NULL ,t2.mac,d.description) AS description ,d.mac_address,IF(t2.mac IS NULL,'d','b') AS s_type ,
                         t2.start_time, t2.account_state,d.create_user,d.other_parameters,
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
                         t2.start_time, t2.account_state,d.create_user,d.other_parameters,
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



                        $query_results = $db->selectDB($key_query);
                        $number_of_results = $query_results['rowCount'];
                        $table_array = array();
                        $table_array_count = 0;
                        foreach ($query_results['data'] as $row) {

                          $id = $row['id'];
                          $nick_name = $row['nick_name'];
                          //$email_address = $row['email_address'];
                          $description = $row['description'];
                          $mac_id = $row['mac_address'];
                          $rec_type = $row['s_type'];
                          $session_id = $row['session_id'];
                          $account_state = $row['account_state'];
                          $acc_states = $row['create_user'];
                          $other_parameters = json_decode($row['other_parameters'], true);
                          $Session_IP = $other_parameters['Session_IP'];
                          $device_Type = $other_parameters['Device-Family'];


                          if ($rec_type == 'd') {
                            $div_btn_disable = 'disabled="disabled"';
                          } elseif ($rec_type == 's') {
                            $ses_btn_disable = 'disabled="disabled"';
                          }

                          $mac_relm = explode('@', $mac_id);
                          /* print_r($mac_relm);
                           echo "<br>"; */
                          $table_array[$mac_relm[0]][id] = $id;
                          $table_array[$mac_relm[0]][nick] = $nick_name;
                          $table_array[$mac_relm[0]][stat] = $acc_states;
                          $table_array[$mac_relm[0]][rec] = $rec_type;
                          $table_array[$mac_relm[0]][ip] = $Session_IP;
                          $table_array[$mac_relm[0]][type] = $device_Type;
                          //$table_array[$mac_relm[1]][de]=$description;


                          if ($table_array_count > 0) {
                            if ($table_array[$description][state] != 'Active') {
                              $table_array[$description][state] = $account_state;
                            }
                          } else {
                            $table_array[$description][state] = $account_state;
                          }



                          $table_array_count++;
                        }

                        //  print_r($table_array);
                        $count_device = 0;

                        foreach ($table_array as $key => $value) {
                          $count_device = $count_device + 1;
                          //  echo $key;

                          $id = $value['id'];
                          $Session_IP = $value['ip'];
                          $device_Type = $value['type'];

                          $nick_name_des = $value[nick];

                          if ($value['stat'] == 'Active') {
                            $session_active = 'YES';
                          } else {
                            $session_active = 'NO';
                          }


                          if (empty($nick_name_des) || $nick_name_des == 'Field is Empty' || $nick_name_des == 'N/A') {
                            $nick_name_des = "";
                          }

                          //if (empty($nick_name_des) || $nick_name_des == 'Field is Empty' || $nick_name_des == "" || $nick_name_des == 'N/A') {
                          if (true) {
                          ?>
                            <tr>
                              <td>
                                <form id="device_edit_form<?php echo $id; ?>" name="device_edit_submit<?php echo $id; ?>" action="manage_tenant.php?t=tenant_account" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onsubmit="return edit_validateForm<?php echo $id; ?>()">
                                  <div class="form-group" id="td_nick_name<?php echo $id; ?>"> <input class="span2 form-controls nick_name" type='text' id="nick_name<?php echo $id; ?>" name='nick_name' value="<?php echo $nick_name_des; ?>">
                                    <small class=" help-block" id="msg_nick_name<?php echo $id; ?>" style="display: none;"></small>

                                  </div>
                                  <?php
                                  echo '<input type="hidden" name="form_secret" id="form_secret' . $id . '" value="' . $_SESSION['FORM_SECRET'] . '" /><input type="hidden" name="search_id" id="search_id1" value="' . $search_id . '" />
                    <input type="hidden" name="mac_address" id="mac_address" value="' . macDisplay($key) . '" /><input type="hidden" name="divice_id" id="divice_id" value="' . $id . '" /><input type="hidden" name="mg_customer_id" id="mg_customer_id" value="' . $mg_customer_id . '" />';

                                  ?>
                              </td>


                              <td><?php echo  $db->macFormat($key, $mac_format); ?></td>


                              <td>



                                <button type="submit" style="border-radius: 0px;padding-bottom: 4px !important; padding-top: 4px !important; min-width: 0 ;" href="javascript:void();" id="device_edit_submit<?php echo $id; ?>" name="device_edit_submit" class="btn btn-primary btn-small">
                                  Update</button> / <?php

                                                    echo ' <a  style="border-radius: 0px;" href="javascript:void();"  id="DR_' . $id . '"  class="btn btn-small">
                        <i class="btn-icon-only icon-trash"></i>Remove</a>
                        
                        
                        <script type="text/javascript">
              $(document).ready(function() {
              $(\'#DR_' . $id . '\').easyconfirm({locale: {
                  title: \'Remove Connected Device \',
                  text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                  button: [\'Cancel\',\' Confirm\'],
                  closeText: \'close\'
                    }});
                $(\'#DR_' . $id . '\').click(function() {
                
                  window.location = "?t=tenant_account&token=' . $secret . '&customer_id=' . $mg_customer_id . '&search_id=' . $search_id . '&rm_device_id=' . $id . '&mac_id=' . $key . '"
                                        
                });
                });
              </script>';

                                                    ?>
                                <script type="text/javascript">
                                  $(document).ready(function() {
                                    $('#device_edit_submit<?php echo $id; ?>').easyconfirm({
                                      locale: {
                                        title: 'Update Device ',
                                        text: 'Are you sure you want to update this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                        button: ['Cancel', ' Confirm'],
                                        closeText: 'close'
                                      }
                                    });
                                    $('#device_edit_submit<?php echo $id; ?>').click(function() {

                                    });
                                  });
                                </script>
                              </td>

                              <?php

                              echo '<td> ' . $session_active . ' </td>';
                              if ($user_wired != 1) {
                                $hostname = $device_data_arr[$key]['hostname'];
                                $osVendorType = $device_data_arr[$key]['osVendorType'];
                                $modelName = $device_data_arr[$key]['modelName'];
                                $deviceType = $device_data_arr[$key]['deviceType'];
                                $uplink = $device_data_arr[$key]['uplink'];
                                $downlink = $device_data_arr[$key]['downlink'];
                                $ipAddress = $device_data_arr[$key]['ipAddress'];
                                if (strlen($hostname) < 1) {
                                  $hostname = "N/A";
                                }
                                if (strlen($modelName) < 1) {
                                  $modelName = "N/A";
                                }
                                if (strlen($osVendorType) < 1) {
                                  $osVendorType = "N/A";
                                }
                                if (strlen($deviceType) < 1) {
                                  if (strlen($device_Type) < 1) {
                                    $deviceType = "N/A";
                                  } else {
                                    $deviceType = $device_Type;
                                  }
                                }
                                if (strlen($uplink) < 1) {
                                  $uplink = "N/A";
                                }
                                if (strlen($downlink) < 1) {
                                  $downlink = "N/A";
                                }
                                if (strlen($ipAddress) < 1) {
                                  if (strlen($Session_IP) < 1) {
                                    $ipAddress = "N/A";
                                  } else {
                                    $ipAddress = $Session_IP;
                                  }
                                }
                                echo '<td> ' . $hostname . ' </td>';
                                echo '<td> ' . $osVendorType . ' </td>';
                                if ($deviceType_exist || $modelName_exist) {
                                  echo '<td> ' . $modelName . ' </td>';
                                  echo '<td> ' . $deviceType . ' </td>';
                                }
                                //echo '<td> ' . $uplink . ' </td>';
                                //echo '<td> ' . $downlink . ' </td>';
                                echo '<td> ' . $ipAddress;
                              } ?>

                              </form>


                              <script type="text/javascript">
                                $("#nick_name<?php echo $id; ?>").keyup(function() {
                                  document.getElementById("device_edit_submit<?php echo $id; ?>").disabled = false;

                                  var nic_val = false;
                                  nic_msg = "";

                                  if ($("#nick_name<?php echo $id; ?>").val() != "") {
                                    nic_val = true;
                                  } else {
                                    nic_msg = "This field is required";
                                  }


                                  if (!nic_val) {

                                    $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                    $("#td_nick_name<?php echo $id; ?>").addClass("has-error");
                                    $("#msg_nick_name<?php echo $id; ?>").css("display", "block");
                                  } else {
                                    $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                    $("#td_nick_name<?php echo $id; ?>").removeClass("has-error");
                                    $("#msg_nick_name<?php echo $id; ?>").css("display", "none");
                                  }

                                });

                                function edit_validateForm<?php echo $id; ?>() {

                                  var nic_val = false;
                                  var mac_val = false;
                                  var dpsk_val = false;

                                  nic_msg = "";

                                  dpsk_msg = "";

                                  //------------ Nic name validate --------------
                                  if ($("#nick_name<?php echo $id; ?>").val() != "") {
                                    nic_val = true;
                                  } else {
                                    nic_msg = "This field is required";
                                  }



                                  //------------ Msg Show --------------
                                  // if(nic_val && dpsk_val){
                                  if (nic_val) {
                                    return true;
                                  } else {

                                    if (!nic_val) {

                                      $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                      $("#td_nick_name<?php echo $id; ?>").addClass("has-error");
                                      $("#msg_nick_name<?php echo $id; ?>").css("display", "block");
                                    } else {
                                      $("#msg_nick_name<?php echo $id; ?>").text(nic_msg);
                                      $("#td_nick_name<?php echo $id; ?>").removeClass("has-error");
                                      $("#msg_nick_name<?php echo $id; ?>").css("display", "none");
                                    }


                                    //  if(!dpsk_val){

                                    //  $("#msg_dpsk<?php //echo $id; 
                                                    ?>" ).text( dpsk_msg );
                                    //  $("#td_dpsk<?php //echo $id; 
                                                    ?>").addClass("has-error");      
                                    //  $("#msg_dpsk<?php //echo $id; 
                                                    ?>").css("display", "block");
                                    // }else{
                                    //  $("#msg_dpsk<?php //echo $id; 
                                                    ?>" ).text( dpsk_msg );
                                    //  $("#td_dpsk<?php //echo $id; 
                                                    ?>").removeClass("has-error");     
                                    //  $("#msg_dpsk<?php //echo $id; 
                                                    ?>").css("display", "none");
                                    // }
                                    return false;
                                  }

                                  //return false;
                                }
                              </script>
                              </td>

                            </tr>

                      <?php

                          } else {






                            echo '<tr> 
                           <td> ' . $value[nick] . ' </td>
                         
                           <td> ' . $db->macFormat($key, $mac_format) . ' </td>';

                            echo '<td class="td_btn">';
                            if ($value[rec] == 'b' || $value[rec] == 'd') {
                              echo '<a href="javascript:void();"  id="DR_' . $value[id] . '"  class="btn  btn-small td_btn_last" >
                           <i class="btn-icon-only icon-trash"></i>Remove</a>
                           </td><script type="text/javascript">
                           $(document).ready(function() {
                           $(\'#DR_' . $value[id] . '\').easyconfirm({locale: {
                               title: \'Remove Connected Device \',
                               text: \'Are you sure you want to delete this connected device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                               button: [\'Cancel\',\' Confirm\'],
                               closeText: \'close\'
                              }});
                             $(\'#DR_' . $value[id] . '\').click(function() {
                               window.location = "?t=tenant_account&token=' . $secret . '&customer_id=' . $mg_customer_id . '&search_id=' . $search_id . '&rm_device_id=' . $value[id] . '&mac_id=' . $key . '"
                             });
                             });
                           </script>';
                            }



                            echo '<td> ' . $session_active . ' </td>';
                            if ($user_wired != 1) {
                              $hostname = $device_data_arr[$key]['hostname'];
                              $osVendorType = $device_data_arr[$key]['osVendorType'];
                              $modelName = $device_data_arr[$key]['modelName'];
                              $deviceType = $device_data_arr[$key]['deviceType'];
                              $uplink = $device_data_arr[$key]['uplink'];
                              $downlink = $device_data_arr[$key]['downlink'];
                              $ipAddress = $device_data_arr[$key]['ipAddress'];
                              if (strlen($hostname) < 1) {
                                $hostname = "N/A";
                              }
                              if (strlen($modelName) < 1) {
                                $modelName = "N/A";
                              }
                              if (strlen($osVendorType) < 1) {
                                $osVendorType = "N/A";
                              }
                              if (strlen($deviceType) < 1) {
                                if (strlen($device_Type) < 1) {
                                  $deviceType = "N/A";
                                } else {
                                  $deviceType = $device_Type;
                                }
                              }
                              if (strlen($uplink) < 1) {
                                $uplink = "N/A";
                              }
                              if (strlen($downlink) < 1) {
                                $downlink = "N/A";
                              }
                              if (strlen($ipAddress) < 1) {
                                if (strlen($Session_IP) < 1) {
                                  $ipAddress = "N/A";
                                } else {
                                  $ipAddress = $Session_IP;
                                }
                              }
                              echo '<td> ' . $hostname . ' </td>';
                              echo '<td> ' . $osVendorType . ' </td>';
                              if ($deviceType_exist || $modelName_exist) {
                                echo '<td> ' . $modelName . ' </td>';
                                echo '<td> ' . $deviceType . ' </td>';
                              }
                              //echo '<td> ' . $uplink . ' </td>';
                              //echo '<td> ' . $downlink . ' </td>';
                              echo '<td> ' . $ipAddress . ' </td>';
                            }
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
                                   window.location = "?t=tenant_account&token='.$secret.'&customer_id='.$mg_customer_id.'&search_id='.$search_id.'&rm_ses_id='.$value[id].'&mac_id='.$key.'"
                                 });
                                 });
                               </script>';

                             }

                            echo '</td>';*/

                            // End Session Handling MDU //
                          }
                        }
                      }

                      ?>





                    </tbody>
                  </table>
                  <br>
                  <strong>
                    <font style=" float: right;" size="-2"><?php echo $count_device; ?> of maximum <?php echo $max_count; ?> devices registered5</font>
                  </strong>
                <?php } ?>

              </div>
            </div>
          </div>

          <br>
          <div class="control-group">

            <div class="widget-content">
              <div class="dis_content_sub">
                <h3><strong>Add or Remove a Device</strong></h3>
                <ul style="line-height: 22px">
                  <li style="line-height: 22px">Your registered devices are listed in the table above. </li>
                  <li style="line-height: 22px">You can register up to <?php echo $max_count; ?> devices. </li>
                  <li style="line-height: 22px">To manually register a device fill in the MAC address and click “Register".</li>
                  <li style="line-height: 22px">The MAC address can usually be found on the back or bottom of the device and looks similar to 58:19:F8:B7:06:3F or 5819f8b7063f.</li>
                  <li style="line-height: 22px">If you do not know how to find your MAC address, then search “How can I find the MAC address on my [product name]?.</li>
                </ul>

              </div>
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



  <?php } else {
    $query_results = $db->get_property($user_distributor);
    foreach ($query_results as $row) {
      $property_id = $row['property_id'];
    }
    $cus_property_type = $db->getValueAsf("SELECT `property_type` AS f FROM `mdu_organizations` WHERE `property_id`='$property_id'");
  ?>

    <h1 class="head"><span>
        Manage Residents
        <!-- <img data-toggle="tooltip" title="Use the Search Tenant field to search for existing tenants that have contacted you for assistance with their account. This could include updating personal information, adding or removing devices, upgrading account to a premium service, resetting their account password and also permanently deleting an account." src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"> -->
      </span>
    </h1>



    <div id="system_response"></div>

    <form id="edit-profile" action="?t=tenant_account" method="post" class="form-horizontal middle">


      <?php

      echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

      ?>

      <fieldset>






        <!-- <div class="control-group">
                                     
         
                                     <div class="controls">
                                       
                                        
                                         <a  id="sync_all" name="sync_all" class="btn btn-default" style="text-decoration:none"><i class="btn-icon-only icon-refresh"></i> Sync Records</a>&nbsp;<img data-toggle="tooltip" title="If a tenant record appears to be missing from the search results, then click [Sync Records] to download missing records that you may have added manually." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">
                           
                                       
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
                                            window.location = "?action=sync_data&tocken=<? php // echo $secret; 
                                                                                        ?>" 
                                           });
                                           });
                                         </script>
                                     
                                   </div> -->

        <div class="control-group" style="display: none;">

          <div class="controls">

            <label class="" for="radiobtns">Limit Search to <img data-toggle="tooltip" title="You can search a resident across all your properties or limit the search to a specific property." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>


            <div class="">
              <select name="property_id" id="property_id" required>
                <option value="ALL">ALL Properties</option>

                <?php
                $query_results = $db->get_property($user_distributor);
                foreach ($query_results as $row) {

                  $property_number = $row[property_number];
                  $property_id = $row[property_id];
                  $org_name = $row[org_name];

                  echo '<option selected value="' . $property_number . '">' . $org_name . '</option>';
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

            <label class="" for="radiobtns">Search Residents <img data-toggle="tooltip" title="You can search for resident using full or partial First Name, Last Name, or Email or Unit# or Mobile Number or use the Search MAC field." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>


            <div class="">
              <input type="text" name="search_word" id="search_word">
              &nbsp; <font size="4">or</font>

              <br />

              <!--  Note: You can search using First Name, Last Name or Email Address. -->



            </div>
          </div>
          <!-- /controls -->
          <div class="controls">

            <label class="" style="margin-top: 10px" for="radiobtns">Search MAC <img data-toggle="tooltip" title="You can search for resident using full or partial MAC address of a device or use the Search Resident field." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>


            <div class="">
              <input type="text" name="search_mac" id="search_mac" type="text" maxlength="17" />

              <br />
            </div>

          </div>
          <div class="controls">

            <button class="btn" style="" type="submit" name="search_btn" id="search_btn">Search</button> <img data-toggle="tooltip" title="Click [SEARCH] to show a full list of residents." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">



          </div>
        </div>
        <div class="controls middle-left">
          <div class="">
            <div class="control-group">


              <div class="controls se_ownload_cr">

                <br />



                <!-- <label class="" for="radiobtns">First Sync all Records</label> -->
                <?php


                if ($re_se != 1) {

                ?>
                  <a id="sync_all" name="sync_all" class="btn btn-default" style="text-decoration:none"><i class="btn-icon-only icon-refresh"></i> Sync Records</a>&nbsp;<img data-toggle="tooltip" title="If a resident record appears to be missing from the search results, then click [Sync Records] to download missing records that you may have added manually." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">



                  <script type="text/javascript">
                    $(document).ready(function() {
                      $('#sync_all').easyconfirm({
                        locale: {
                          title: 'Sync Data',
                          text: 'Are you sure you want to sync. It can take several <br> minutes depending on the number of accounts.?',
                          button: ['Cancel', ' Confirm'],
                          closeText: 'close'
                        }
                      });
                      $('#sync_all').click(function() {
                        window.location = "?action=sync_data"
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

    <!-- <form id="edit-profile1" action="?t=tenant_account" method="post" class="form-horizontal" >       

 <?php

    echo '<input type="hidden" name="form_secret" id="form_secret1" value="' . $_SESSION['FORM_SECRET'] . '" />';

  ?>
                                    <div class="control-group">
                                     
                                     <div class="controls">

                                      <label class="" for="radiobtns">Search MAC <img data-toggle="tooltip" title="" src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>
         

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
    if ($re_se == 1) {
      $re_se = 0;
    ?>






      <div class="widget widget-table action-table" id="se_te">
        <form action="manage_tenant.php" method="post" class="form-horizontal" enctype="multipart/form-data">
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



                if ($cus_property_type == 'MDU') {

                  $customer_down_key_string = "task=mdu&searchid=" . $search_id;
                } else {
                  $customer_down_key_string = "task=vt&searchid=" . $search_id;
                }
                $customer_down_key =  cryptoJsAesEncrypt($data_secret, $customer_down_key_string);
                $customer_down_key =  urlencode($customer_down_key);
                ?>

                <a href="ajax/export_customer.php?key=<?php echo $customer_down_key ?>" class="btn btn-info" style="text-decoration:none"><i class="btn-icon-only icon-download"></i> Download Search Results </a>

                <!-- <label class="" for="radiobtns">First Sync all Records</label> -->

                <a id="sync_all" name="sync_all" class="btn btn-default" style="text-decoration:none"><i class="btn-icon-only icon-refresh"></i> Sync Records</a>&nbsp;<img data-toggle="tooltip" title="If a resident record appears to be missing from the search results, then click [Sync Records] to download missing records that you may have added manually." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">




                <script type="text/javascript">
                  $(document).ready(function() {
                    $('#sync_all').easyconfirm({
                      locale: {
                        title: 'Sync Data',
                        text: 'Are you sure you want to sync. It can take several <br> minutes depending on the number of accounts.?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                      }
                    });
                    $('#sync_all').click(function() {
                      window.location = "?action=sync_data"
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
            $rows = $db->select1DB($s_id);
            $customer_list = $rows['customer_list'];
            $customer_list_array = explode(",", $customer_list);
            $customer_list_array_count = count($customer_list_array);

            $default_table_rows = $db->setVal('tbl_max_row_count', 'ADMIN');

            if ($default_table_rows == "" || $default_table_rows == "0") {
              $default_table_rows = 100;
            }

            $page_count = ceil($customer_list_array_count / $default_table_rows);

            if (isset($_GET['page_number'])) {
              $page_number = $_GET['page_number'];
            } else {
              $page_number = 1;
            }
            $start_row_count = ($page_number * $default_table_rows) - $default_table_rows;
            $end_row_count = ($page_number * $default_table_rows);
            $view_customer_list = "";
            for ($i = $start_row_count; $i < min($end_row_count, $customer_list_array_count); $i++) {
              $view_customer_list = $view_customer_list . "," . $customer_list_array[$i];
              $last_row_number = $i;
            }
            //  echo $view_customer_list;

            if ($customer_list_array_count < 500) {
              $per_page_menu = '[[10, 25, 50, -1], [10, 25, 50, "All"]]';
            } else {
              $default_table_rows = 100;
              $per_page_menu = '[[100, 250, 500, -1], [100, 250, 500, "All"]]';
            }

            $view_customer_list = ltrim($view_customer_list, ",");
            $view_customer_list = rtrim($view_customer_list, ",");
            if ($page_count != 1) {
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
                .dataTables_length {
                  padding: 5px;
                  float: right !important;
                }

                .dataTables_length label {
                  margin-bottom: 0px !important;
                }

                .dataTables_length select {
                  margin-left: 5px !important;
                  width: 80px !important;
                }

                #tenent_search_table th {
                  border-top: 1px solid #ddd !important;
                  background-color: #f4f4f4;
                }


                .dataTables_info {
                  margin-left: 10px;
                }
              </style>

              <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap id="tenent_search_table">
                <thead>
                  <tr>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><span>First Name</span></th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><span>Last Name</span></th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><span>Email</span></th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10"><span>User Name</span></th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3"><span>Property</span></th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10"><span>Expiration Date</span></th>
                    <?php if ($cus_property_type != 'MDU') { ?>
                      <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3"><span>VLAN ID</span></th>
                    <?php } ?>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Devices Count</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Edit</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Delete

                    </th>


                  </tr>
                </thead>
                <tbody>

                  <?php



                  $key_query = "SELECT c.`customer_id`,c.`first_name`,c.`last_name`,c.`email`,c.`property_id`,c.`valid_from`,c.`room_apt_no`,c.`first_login_date`,c.`vlan_id`,c.`username`,FROM_UNIXTIME(LEFT(c.`valid_until`, 10),'%m/%d/%Y %h:%i %p') AS expire_time,c.valid_until,c.valid_from,c.`validity_time`,count(d.`mac_address`) AS countd
         FROM `mdu_vetenant` c LEFT JOIN `mdu_customer_devices` d ON c.`customer_id`= d.`customer_id` and c.`username` = d.`user_name` WHERE c.customer_id IN ($customer_list) GROUP BY c.customer_id ORDER BY c.first_name ASC ";

                  $tb_arr_data = [];

                  $query_results = $db->selectDB($key_query);
                  foreach ($query_results['data'] as $row) {
                    $tb_arr = [];
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
                    $valid_until = $row['valid_until'];
                    $valid_from = $row['valid_from'];
                    $expire_time = $row['expire_time'];
                    //$validity_time = $row['validity_time'];
                    //$valid_from = $row['valid_from'];

                    $validity_time = $valid_until - $valid_from;


                    /*if(empty($validity_time)){
                            $validity_time = "N/A";
                           }*/
                    $validity_time = $expire_time;
                    if (strtolower($validity_time) < 1) {
                      $validity_time = "N/A";
                    }
                    $get_property_id_get = $db->selectDB("SELECT property_id,validity_time FROM `mdu_organizations` WHERE property_number='$property_id' LIMIT 1");

                    foreach ($get_property_id_get['data'] as $rowe) {
                      $property_id_display = $rowe['property_id'];
                      //$validity_time_display = $rowe['validity_time'];
                    }


                    array_push($tb_arr, $first_name);
                    array_push($tb_arr, $last_name);
                    array_push($tb_arr, $email);
                    array_push($tb_arr, $username);
                    array_push($tb_arr, $property_id_display);
                    array_push($tb_arr, $validity_time);

                    if ($cus_property_type != "MDU") {
                      array_push($tb_arr, $vlan_id);
                    }

                    array_push($tb_arr, $Device_count);

                    $a = '<a id="CM_' . $customer_id . '"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Edit</a>';
                    $a .= '<script type="text/javascript">
         
         $(\'#CM_' . $customer_id . '\').easyconfirm({locale: {
             title: \'Edit Resident [' . $db->escapeDB($first_name) . ' ' . $db->escapeDB($last_name) . ']\',
             text: \'Are you sure you want to edit this resident?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
             button: [\'Cancel\',\' Confirm\'],
             closeText: \'close\'
            }});
           $(\'#CM_' . $customer_id . '\').click(function() {
             window.location = "?t=tenant_account&token=' . $secret . '&search_id=' . $search_id . '&mg_customer_id=' . $customer_id . '"
           });
           
         </script></td>';

                    array_push($tb_arr, $a);

                    //echo '<td class="td_btn " style="position: relative;">';
                    $b = '
         <input type="checkbox" class="customer_delete_id' . $customer_id . '" name="customer_delete_id[]"  value="' . $customer_id . '" id="customer_delete_id">
         <input type="hidden" name="token"  value="' . $secret . '" id="token">
         <input type="hidden" name="search_id"  value="' . $search_id . '" id="search_id">

         <script type="text/javascript">
         $(".customer_delete_id' . $customer_id . '").click(function(){      
          if($(this).prop("checked") == true){
            $("#Delete_btn_device").attr("disabled", false); 
          }
                                        });
         
         </script>
         ';

                    array_push($tb_arr, $b);

                    // echo '<a href="javascript:void();"  id="CR_'.$customer_id.'"  class="btn btn-danger btn-small td_btn_last"><i class="btn-icon-only icon-remove-circle"></i>Delete</a>';
                    // echo '</td>';

                    array_push($tb_arr_data, $tb_arr);
                  }

                  ?>





                </tbody>
              </table>

              <script type="text/javascript">
                $(document).ready(function() {
                  $('#tenent_search_table').DataTable({
                    "pageLength": <?php echo $default_table_rows; ?>,
                    "deferRender": true,
                    "data": <?php echo json_encode($tb_arr_data) ?>,
                    "columns": [
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      <?php if ($cus_property_type != 'MDU') { ?>
                        null,
                      <?php } ?>
                      null,
                      {
                        "orderable": false
                      },
                      {
                        "orderable": false
                      }
                    ],
                    "autoWidth": false,
                    "language": {
                      "emptyTable": "No Residents Found"
                    },
                    "drawCallback": function() {
                      new Tablesaw.Table("#tenent_search_table").destroy();
                      Tablesaw.init();
                      $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;'></label>");
                    },
                    /*"language": {
                                         "lengthMenu": "Per page _MENU_ "
                                      },
         */
                    "bFilter": false,

                    "lengthMenu": <?php echo $per_page_menu; ?>

                  });
                });
              </script>

            </div>

            <br>
            <div align="right">
              Select All &nbsp;&nbsp; <input type="checkbox" name="customer_delete_all" value="" id="customer_delete_all">


              <button class="btn btn-info" type="submit" name="Delete_btn_device" id="Delete_btn_device" disabled>Delete</button>
            </div>
          </div>


          <script type="text/javascript">
            $(document).ready(function() {



              $("#customer_delete_all").click(function() {
                $('input[name="customer_delete_id[]"]').prop('checked', this.checked);

                if ($(this).prop("checked") == true) {
                  $('#Delete_btn_device').attr("disabled", false);
                } else {
                  $('#Delete_btn_device').attr("disabled", true);
                }
              });

              $("#Delete_btn_device").easyconfirm({
                locale: {
                  title: 'Delete Resident',
                  text: 'Are you sure you want to delete these residents?  ',
                  button: ['Cancel', ' Confirm'],
                  closeText: 'close'
                }
              });
              $("#customer_submit").click(function() {});






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