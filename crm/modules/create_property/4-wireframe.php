  <!-- Att -->
  <!-- ******************************************************* -->

  <?php
  $isDynamic = package_functions::isDynamic($system_package);
  $qfn = "SELECT `service_id`,`service_name` FROM `exp_service_activation_features`  WHERE `service_type`='MNO_FEATURES' AND `service_id`='CAMPAIGN_MODULE'";

  $campaign_feature = $db->select1DB($qfn);

  $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='$system_package'");
  $configFileArr = json_decode($getJson, true);
 ?>
   <div <?php if(isset($tab_create_property)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="create_property">



<form onkeyup="location_formfn();" onchange="location_formfn();"   autocomplete="off"   id="location_form" name="location_form" method="post" class="form-horizontal"	action="<?php if($_POST['p_update_button_action']=='add_location' || isset($_GET['location_parent_id'])){echo '?token7='.$secret.'&t=edit_parent&edit_parent_id='.$edit_parent_id;}else{echo'?t=active_properties';} ?>" >

        <?php
          echo '<input type="hidden" name="form_secret5" id="form_secret5" value="'.$_SESSION['FORM_SECRET'].'" />';
        ?>

        <fieldset>
                    <div id="response_d1">

                    </div>

            <div class="row">
                <div class="create_l">


                    <?php
                    //***************Field Filtor******************
                    //echo $system_package;
                    $json_fields=$package_functions->getOptions('VENUE_ACC_CREAT_FIELDS',$system_package);
                    $field_array=json_decode($json_fields,true);
                  //  print_r($field_array);
                    ?>

                    <div class="control-group">
                    <div class="controls col-lg-5 form-group">

                    <h3>Account Info</h3>

                </div>
            </div>


                <?php
                        if(array_key_exists('parent_id',$field_array) || $package_features=="all"){
                    ?>


                <div class="control-group">
                    <div class="controls col-lg-5 form-group">
                    <label for="customer_type">Business ID<?php if($field_array['parent_id']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                        <input <?php if(isset($edit_parent_id)){ ?>readonly<?php } ?> maxlength="12" type='text' class="span4 form-control" placeholder="SAN123456789" name='parent_id' id='parent_id' value="<?php echo $edit_parent_id; ?>" data-toggle="tooltip" title="The Business ID format: 3 alpha characters followed by 3-9 numeric characters. EX. SAN123 or SAN123456789">
                    </div>
                    <script type="text/javascript">
                      $("#parent_id").keypress(function(event){
                        var ew = event.which;
                        //alert(ew);
                        // if(ew == 32)
                        //   return true;
                        if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 96 <= ew && ew <= 122  || ew == 0  || ew == 8 || ew == 189)
                          return true;
                        return false; 
                      });
                    </script> 
                </div>
                    <?php }

                        if(array_key_exists('parent_ac_name',$field_array) || $package_features=="all"){
                    ?>


                <div class="control-group">
                    <div class="controls col-lg-5 form-group">
                    <label for="customer_type">Business Account Name<?php if($field_array['parent_ac_name']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                        <input <?php if(isset($edit_parent_ac_name)){ ?>readonly<?php } ?> type='text' class="span4 form-control" placeholder="joey's pizza" name='parent_ac_name' id='parent_ac_name' value="<?php echo str_replace("\\",'',$edit_parent_ac_name); ?>">
                    </div>
                </div>
                    <?php }

                        if(array_key_exists('f_name',$field_array) || $package_features=="all"){
                            ?>

                     <div class="control-group">
                            <div class="controls col-lg-5 form-group">
                            <label for="mno_first_name">Admin First Name<?php if($field_array['f_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                <input <?php if(isset($edit_first_name)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_first_name" placeholder="First Name" name="mno_first_name" type="text" maxlength="30" value="<?php echo $edit_first_name; ?>">
                            </div>
                        </div>
                        <?php }
                        if(array_key_exists('l_name',$field_array) || $package_features=="all"){
                            ?>
                         <div class="control-group">
                            <div class="controls col-lg-5 form-group">
                            <label for="mno_last_name">Admin Last Name<?php if($field_array['l_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                <input <?php if(isset($edit_last_name)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_last_name" placeholder="Last Name" name="mno_last_name" maxlength="30" type="text" value="<?php echo $edit_last_name; ?>">
                            </div>
                        </div>
                        <?php }


                        if(array_key_exists('email',$field_array) || $package_features=="all"){
                                    ?>
                                 <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                    <label for="mno_email">Admin Email<?php if($field_array['email']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                        <input <?php if(isset($edit_email)){ ?>readonly<?php } ?> class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com"   value="<?php echo $edit_email; ?>">
                                    </div>
                                </div>
                                <?php }
                                //print_r($field_array);
                            if((array_key_exists('new_features',$field_array) || $package_features=="all") && $edit_account!=1){
                                    ?>
                                 <div class="control-group" >
                                    <div class="controls col-lg-5 form-group">
                                    <label for="mno_features">Admin Features<?php if($field_array['new_features']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                        <select onchange="feature_config();" class="form-control span4" multiple="multiple" id="admin_features" name="admin_features[]">
                            <option value="" disabled="disabled"> Choose Feature(s)</option>

                            <?php 

                            $fearuresjson=$db->getValueAsf("SELECT features as f FROM `exp_mno` WHERE mno_id='$user_distributor'");
                            $mno_feature=json_decode($fearuresjson);

                            $qf = "SELECT `service_id`,`service_name`,`mno_feature`,`feature_json` FROM `exp_service_activation_features`  WHERE `service_type`='MVNO_ADMIN_FEATURES'
                           ORDER BY `service_id`";

                           $featureaccess=array();
                           $query_resultsf=$db->selectDB($qf);
                           foreach($query_resultsf['data'] AS $row) {

                            $feature_code = $row[service_id];
                            $feature_name = $row[service_name];
                            $m_features = $row[mno_feature];
                            $feature_json = $row[feature_json];

                            if (in_array($m_features, $mno_feature) || (strlen($m_features)<1)) {
                                $fearurearr=array();
                                $fearurear=json_decode($feature_json,true); 
                                $fearurearr[$feature_code]=$fearurear;
                                if ((!$isDynamic && $feature_code!="CAMPAIGN_MODULE") || ($isDynamic)) {
                                if (array_key_exists($feature_code, $edit_admin_features)) {
                                    echo "<option selected value='" . $feature_code . "'>".  $feature_name . "</option>";
                                }
                                else{
                                    echo "<option value='" . $feature_code . "'>".  $feature_name . "</option>";
                                }
                                if (!empty($fearurear)) {
                                    array_push($featureaccess, $fearurearr);
                                }
                                }
                            }
                            
                            }
                            $featureaccess=json_encode($featureaccess);
                             ?>

                            
                        </select>
                                    </div>
                                    
                                </div>
                                <div id="fearure_ar"></div>
                                <script type="text/javascript">

                function feature_config() {
                                    

                                   var admin_features_val = $('#admin_features').val();
                                   var features_arr = '<?php echo $featureaccess ?>';
                                   var array_new = JSON.parse(features_arr);
                                   var result='';
                                   var resultnew='';
                                   var dpsk ='DPSK';
                                    //console.log(admin_features_val);
                                  $('#vt_voucher_div').empty();

                                   for (var key in admin_features_val) {

                                    if (admin_features_val[key]==dpsk) { 
                                      resultnew+='<div class="controls col-lg-5 form-group"><label for="dpsk_voucher">Vtenant Account Creation Voucher <i  title="All tenants will need a voucher to enable them to create an account. depending on level of security you can select from two options: <br> 1.Shared voucher means all tenant use the same voucher code for account creation  <br>                    2.Single-use voucher means each tenant gets a unique one time voucher for account creation " class="icon icon-question-sign tooltips" style="color : #0568ea;margin-top: 3px; display:inline-block !important; font-size: 18px"></i> </label><input type="radio" checked name="dpsk_voucher" value="SHARED"><label style="display :inline-block;min-width: 29%; max-width: 100%;">Shared</label><input type="radio" name="dpsk_voucher" value="SINGLEUSE"><label style="display :inline-block;">Single Use</label></div>';
                                      //$('#vt_voucher_div').empty();

                                      $('#vt_voucher_div').html(resultnew);
                                      $('.tooltips').tooltipster({
                contentAsHTML: true,
                maxWidth: 350
                
            });
                                    }
                                   }
                                  
                                   for (var i = 0; i < array_new.length; i++) {
                                       //array_new[i];
                                           //console.log(admin_features_val);

                                       for (var key in array_new[i]) {
                                       if (admin_features_val) {
                                       var a = admin_features_val.indexOf(key); }
                                       //console.log(a);
                                       if (a>-1) {
                                           
                                       var value=array_new[i][key];
                                       var type=value['type'];
                                       var name=value['id'];
                                       var label=value['label'];
                                       var check1=value['value']['operator'];
                                       var check2=value['value']['parent'];

                                       var checked=check1['selected'];
                                       var label_n=check1['label'];
                                       var enable=check1['enable'];
                                       var checkedp=check2['selected'];
                                       var label_np=check2['label'];
                                       var enablep=check2['enable'];

                                    result+='<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">'+label+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checked+' value="'+enable+'"><label style="display :inline-block;min-width: 29%; max-width: 100%;">'+label_n+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checkedp+' value="'+enablep+'"><label style="display :inline-block;">'+label_np+'</label></div></div>';
                                    
                                    
                                    
                                      }
                                  }

                                       
                                   }
                                   $('#fearure_ar').empty();

                                    $('#fearure_ar').html(result);
                                   // $('#device_arr').html(resultsn);
                                }
               </script> 
                                <?php }

                            $parent_package=$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);
                            $parent_package_array =explode(',',$parent_package);
                            //print_r($parent_package_array);
                            if(count($parent_package_array)>1){

                                ?>

                                 <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                    <label for="parent_package_type">Admin Type</label>
                                        
                                        <?php 
                                            echo'<select class="span4 form-control" id="parent_package1" name="parent_package_type">';
                                            echo '<option value="">Select Business ID type</option>';

                                            foreach($parent_package_array as $value){
                                                $parent_package_name = $db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");
                                                if ($edit_parent_package==$value) {
                                                  echo '<option selected value="'.$value.'">'.$parent_package_name.'</option>';
                                                }else{
                                                echo '<option value="'.$value.'">'.$parent_package_name.'</option>';
                                            }
                                            }
                                                 echo '</select>';
                                        ?>
                                    </div>
                                 </div>
                            <?php }else{

                                echo '<div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control"  id="parent_package1" name="parent_package_type" type="hidden" value="'.$parent_package_array[0].'">
                                </div>
                                 </div>
                                ';
                            }

                            ?>




<hr>

          <div id="location_info_div" style="">

            <div class="control-group">
                <div class="controls col-lg-5 form-group">
                    <h3>Location Address</h3>

                </div>
            </div>


            

               <?php if(array_key_exists('business_type',$field_array)){
                ?>

                    <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="location_name1">Business Vertical<?php if($field_array['business_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                            <select <?php if($field_array['business_type']=="mandatory" ){ ?>required<?php } ?> class="span4 form-control" id="business_type" name="business_type" >
                                <option value="">Select Business Type</option>
                                <?php

                             if(empty($edit_distributor_business_type)){
                                                $edit_distributor_business_type ="Retail";
                                            }

                                $get_businesses_q="SELECT `business_type`,`discription` FROM `exp_business_types` WHERE `is_enable`='1'";
                                $get_businesses_r=$db->selectDB($get_businesses_q);
                                
                                foreach ($get_businesses_r['data'] AS $get_businesses) {
                                    $get_business=$get_businesses['business_type'];
                                    if($edit_distributor_business_type==$get_business){
                                        ?>
                                        <option selected value="<?php echo$get_business;?>"><?php echo$get_businesses['discription'];?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?php echo$get_business;?>"><?php echo$get_businesses['discription'];?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                <?php }

                 if(array_key_exists('account_name',$field_array) || $package_features=="all"){
                ?>



                    <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="location_name1">Account Name<?php if($field_array['account_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                            <input <?php if($field_array['account_name']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="location_name1" placeholder="ABC Shopping Mall" name="location_name1" type="text" value="<?php echo str_replace("\\",'',$edit_distributor_name); ?>" />

                        </div>
                    </div>
                <?php }




                    if(array_key_exists('add1',$field_array) || $package_features=="all"){
                        ?>
                    <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="mno_address_1">Address<?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                            <input <?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text"   value="<?php echo $edit_bussiness_address1; ?>">
                        </div>
                    </div>
                    <?php }
                    if(array_key_exists('add2',$field_array) || $package_features=="all"){
                        ?>

                    <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="mno_address_2">City<?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                            <input <?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text"   value="<?php echo $edit_bussiness_address2; ?>">
                        </div>
                    </div>
                    <?php }
                    if(array_key_exists('add3',$field_array) || $package_features=="all"){
                        ?>
                     <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="mno_address_3">Address 3<?php if($field_array['add3']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                            <input <?php if($field_array['add3']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_address_3" placeholder="Address Line 3" name="mno_address_3" type="text"   value="<?php echo $edit_bussiness_address3; ?>">
                        </div>
                    </div>
                    <?php }
                    if(array_key_exists('country',$field_array) || $package_features=="all"){
                        ?>
                    <div class="control-group">

                <div class="controls col-lg-5 form-group">
                <label for="mno_country" >Country<?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                <select <?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> name="mno_country" id="country" class="span4 form-control">
                    <option value="">Select Country</option>
                <?php

                // if(isset($edit_country_code)){
                // 	echo '<option value="'.$edit_country_code.'">'.$edit_country_name.'</option>';
                // 	}

                $count_results=$db->selectDB("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
UNION ALL
SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");
               
                foreach ($count_results['data'] AS $row) {

                if($row[a]==$edit_country_code || $row[a]== "US"){
                       $select="selected";
                    }else{
                        $select="";
                    }
                        echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';

                        }
                ?>


              </select>


                </div>
            </div>

            <script type="text/javascript">

              // Countries
var country_arr = new Array( "United States of America","Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

// States
var s_a = new Array();
var s_a_val = new Array();
s_a[0] = "";
s_a_val[0] = "";
<?php

$get_regions=$db->selectDB("SELECT
                              `states_code`,
                              `description`
                            FROM 
                            `exp_country_states` ORDER BY description");

$s_a = '';
$s_a_val = '';


foreach ($get_regions['data'] AS $state) {
$s_a .= $state['description'].'|';
$s_a_val .= $state['states_code'].'|';
}

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

            <script language="javascript">
populateCountries("country", "state");
// populateCountries("country");
</script>
       <!-- /controls -->
                    <?php }
                    if(array_key_exists('region',$field_array) || $package_features=="all"){
                        ?>
                    <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="mno_state">State/Region<?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                            <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="state" placeholder="State or Region" name="mno_state" >
                            <option value="">Select State</option>
                                <?php
                             $get_regions=$db->selectDB("SELECT
                              `states_code`,
                              `description`
                            FROM
                            `exp_country_states` ORDER BY description ASC");

                            
                            foreach ($get_regions['data'] AS $state) {
                                if($edit_state_region==$state['states_code']) {
                                    echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                }else{

                                    echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                }
                            }
                            //echo '<option value="other">Other</option>';
                            ?>
                            </select>
                        </div>
                    </div>

                    <?php }
                    if(array_key_exists('zip_code',$field_array) || $package_features=="all"){
                        ?>

                     <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="mno_region">ZIP Code<?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                            <input <?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control zip_vali" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $edit_zip; ?>">
                        </div>
                    </div>

                    <script type="text/javascript">

                    $(document).ready(function() {



                        $(".zip_vali").keydown(function (e) {


                            var mac = $('.zip_vali').val();
                            var len = mac.length + 1;
                            //console.log(e.keyCode);
                            //console.log('len '+ len);


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

                    <?php }
                    if(array_key_exists('phone1',$field_array) || $package_features=="all"){
                        ?>
                    <div class="control-group">
                            <div class="controls col-lg-5 form-group">
                            <label for="mno_mobile">Phone Number 1<?php if($field_array['phone1']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></sup></label>
                                <input <?php if($field_array['phone1']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control mobile1_vali" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12"  value="<?php echo $edit_phone1; ?>">
                            </div>
                        </div>

                <script type="text/javascript">

                    $(document).ready(function() {

                        $('.mobile1_vali').focus(function(){
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                            $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                        });

                        $('.mobile1_vali').keyup(function(){
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                             $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                        });
                        //$('#mno_mobile_1').val($('#mno_mobile_1').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));

                        $(".mobile1_vali").keydown(function (e) {


                            var mac = $('.mobile1_vali').val();
                            var len = mac.length + 1;
                            //console.log(e.keyCode);
                            //console.log('len '+ len);

                            if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                mac1 = mac.replace(/[^0-9]/g, '');


                                //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                //console.log(valu);
                                //$('#phone_num_val').val(valu);

                            }
                            else{

                                if(len == 4){
                                    $('.mobile1_vali').val(function() {
                                        return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                        //console.log('mac1 ' + mac);

                                    });
                                }
                                else if(len == 8 ){
                                    $('.mobile1_vali').val(function() {
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

                             $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                        });


                    });

                    </script>

                    <?php }
                    if(array_key_exists('phone2',$field_array) || $package_features=="all"){
                        ?>

                   <div class="control-group">
                            <div class="controls col-lg-5 form-group">
                            <label for="mno_mobile">Phone Number 2<?php if($field_array['phone2']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                <input <?php if($field_array['phone2']=="mandatory"){ ?>required<?php } ?> class="span4 form-control mobile2_vali" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $edit_phone2; ?>">
                            </div>
                        </div>

                <script type="text/javascript">

                    $(document).ready(function() {

                        $('.mobile2_vali').focus(function(){
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                             $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');

                        });

                        $('.mobile2_vali').keyup(function(){
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                             $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');

                        });

                        //$('#mno_mobile_2').val($('#mno_mobile_2').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));


                        $(".mobile2_vali").keydown(function (e) {


                            var mac = $('.mobile2_vali').val();
                            var len = mac.length + 1;
                            //console.log(e.keyCode);
                            //console.log('len '+ len);

                            if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                mac1 = mac.replace(/[^0-9]/g, '');


                                //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                //console.log(valu);
                                //$('#phone_num_val').val(valu);

                            }
                            else{

                                if(len == 4){
                                    $('.mobile2_vali').val(function() {
                                        return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                        //console.log('mac1 ' + mac);

                                    });
                                }
                                else if(len == 8 ){
                                    $('.mobile2_vali').val(function() {
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
                            $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');
                        });


                    });

                    </script>

                    <?php }
                    if(array_key_exists('phone3',$field_array) || $package_features=="all"){
                        ?>
                       <div class="control-group">
                            <div class="controls col-lg-5 form-group">
                            <label for="mno_mobile">Phone Number 3<?php if($field_array['phone3']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                <input <?php if($field_array['phone3']=="mandatory"){ ?>required<?php } ?> class="span4 form-control mobile3_vali" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $edit_phone3; ?>">
                            </div>
                        </div>

                <script type="text/javascript">

                    $(document).ready(function() {

                        $('.mobile3_vali').focus(function(){
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                            $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                        });

                        $('.mobile3_vali').keyup(function(){
                            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                            $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                        });

                        //$('#mno_mobile_3').val($('#mno_mobile_3').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));


                        $(".mobile3_vali").keydown(function (e) {


                            var mac = $('.mobile3_vali').val();
                            var len = mac.length + 1;
                            //console.log(e.keyCode);
                            //console.log('len '+ len);

                            if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                mac1 = mac.replace(/[^0-9]/g, '');


                                //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                //console.log(valu);
                                //$('#phone_num_val').val(valu);

                            }
                            else{

                                if(len == 4){
                                    $('.mobile3_vali').val(function() {
                                        return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                        //console.log('mac1 ' + mac);

                                    });
                                }
                                else if(len == 8 ){
                                    $('.mobile3_vali').val(function() {
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
                            $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                        });


                    });

                    </script>

                    <?php }
                    if(array_key_exists('time_zone',$field_array) || $package_features=="all"){
                        ?>
                             <div class="control-group">
                                 <div class="controls col-lg-5 form-group">
                                 <label for="mno_timezone">Time Zone <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                     <select <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_time_zone" name="mno_time_zone" >
                                         <option value="">Select Time Zone</option>
                                         <?php

                                         $utc = new DateTimeZone('UTC');
                                         $dt = new DateTime('now', $utc);
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

                                    /*

                                         foreach(DateTimeZone::listIdentifiers() as $tz) {
                                             $current_tz = new DateTimeZone($tz);
                                             $offset =  $current_tz->getOffset($dt);
                                             $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                             $abbr = $transition[0]['abbr'];
                                             if($abbr!="EST" || $abbr!="CT" || $abbr!="MT" || $abbr!="PST" || $abbr!="AKST" || $abbr!="HST" || $abbr!="EDT"){
                                             if($edit_timezone==$tz){
                                                 $select="selected";
                                             }
                                             echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. formatOffset($offset). ']</option>';
                                                $select="";

                                            }
                                         }*/

                                         ?>
                                     </select>
                                 </div>
                             </div>

                 <?php }

            


            if(array_key_exists('p_QOS',$field_array) || array_key_exists('g_QOS',$field_array) || ($package_functions->getOptions('VTENANT_MODULE',$system_package)=='Vtenant') ||  $package_features=="all") {
                ?>

                <div class="control-group" >
                        
                        <div class="controls col-lg-5 form-group">

                <h3 id="pg_prof">Assign QoS Profiles</h3>

                <?php

                $json_sync_fields = $package_functions->getOptions('SYNC_PRODUCTS_FROM_AAA', $system_package);
                $sync_array = json_decode($json_sync_fields, true);

                ?>
                <style>
                    @media (max-width: 520px){
                        .qos-sync-button {
                            margin-bottom: 15px; !important;
                        }
                    }
                    @media (min-width: 520px){
                        .qos-sync-button {
                           /* margin-top: 20px; !important;
                            float:right;
                            margin-right: 22%;*/
							 margin-top: -16px; !important;
                        }
                    }
                </style>

                <!--<a <?php //if ($sync_array['g_QOS_sync'] == 'display') {
                    //echo 'style="display: inline-block;padding: 6px 20px !important;"';
                //} else {
                    //echo 'style="display:none"';
                //} ?> onclick="gotoSync();"
                     class="btn btn-primary qos-sync-button"
                     style="align: left;"><i
                            class="btn-icon-only icon-refresh"></i>
                    Sync</a>
                <div style="display: inline-block"
                     id="sync_loader"></div>-->

            </div>
        </div>
        <script type="text/javascript">
            function gotoSync(){

//var a = scrt_var.length;


document.getElementById("sync_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
//window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

$.ajax({
type: 'POST',
dataType: 'JSON',
url: 'ajax/get_profile.php',
data: { user_distributor: "<?php echo $user_distributor; ?>",sync_type : "product_ale5",system_package: "<?php echo $system_package; ?>",user_name: "<?php echo $user_name; ?>" },
success: function(data) {
  //parse.json(data);
console.log(data.guest_data);
//alert(data); 
$('#AP_contrl_guest').empty();
$("#AP_contrl_guest").append(data.guest_data);

$('#vt_guest_pri_id').empty();
$("#vt_guest_pri_id").append(data.guest_data);

$('#vt_guest_def_id').empty();
$("#vt_guest_def_id").append(data.vtenant_data);

$('#vt_guest_pro_id').empty();
$("#vt_guest_pro_id").append(data.vtenant_data);


document.getElementById("sync_loader").innerHTML = "";

},
error: function(){
document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
}

});





}  
        </script>

                <br>
                
                <?php
                if (array_key_exists('p_QOS', $field_array) || $package_features == "all") {
                    ?>

                    <div class="control-group"
                         id="p_prof2" <?php if ($field_array['p_QOS'] == 'display_none') {
                        echo 'style="display:none"';
                    } ?>>
                        
                        <div class="controls col-lg-5 form-group">

                            <label
                               for="AP_contrl">Private QoS
                            Profile<?php if ($field_array['p_QOS'] == "mandatory") { ?>
                                <font color="#FF0000"></font></sup><?php } ?>
                        </label>

                            <select
                                <?php if ($field_array['p_QOS'] == "mandatory"){ ?>required<?php } ?>
                                name="AP_contrl" id="AP_contrl"
                                class="span4 form-control">
                                <option value="">Select
                                    Profile
                                </option>
                                <?php
                                $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='private' AND mno_id='$user_distributor'";

                                $query_results = $db->selectDB($q1);
                                
                                foreach ($query_results['data'] AS $row) {
                                    $dis_code = $row[product_code];
                                    $dis_id = $row[product_id];
                                    $dis_name = $row[product_name];
                                    $dis_QOS = $row[QOS];

                                    if ($edit_distributor_product_id_p == $dis_id) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }

                                    echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_code . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->


                    <div class="control-group"
                         id="pd_prof" <?php if ($field_array['pd_QOS'] == 'display_none') {
                        echo 'style="display:none"';
                    } ?>>
                        
                        <div class="controls col-lg-5 form-group">

                            <label
                               for="AP_contrl">Duration
                            Profile<?php if ($field_array['pd_QOS'] == "mandatory") { ?>
                                <font color="#FF0000"></font></sup><?php } ?>
                        </label>

                            <select
                                <?php if ($field_array['pd_QOS'] == "mandatory"){ ?>required<?php } ?>
                                name="AP_contrl_time"
                                id="AP_contrl_time"
                                class="span4 form-control">
                                <option value="">Select
                                    Profile
                                </option>
                                <?php
                                $q1 = "SELECT id,profile_code,profile_name,duration,profile_type
                                                        FROM exp_products_duration
                                                        WHERE profile_type IN('2','3') AND distributor='$user_distributor'";

                                $query_results = $db->selectDB($q1);
                                
                                foreach ($query_results['data'] AS $row) {
                                    $select = "";
                                    $dis_id = $row[id];
                                    echo $dis_code = $row[profile_code];
                                    $dis_name = $row[profile_name];
                                    $timegap = $row[duration];
                                    $gap = "";
                                    if ($timegap != '') {

                                        $interval = new DateInterval($timegap);

                                        if ($interval->y != 0) {
                                            $gap .= $interval->y . ' Years';
                                        }
                                        if ($interval->m != 0) {
                                            $gap .= $interval->m . ' Months';
                                        }
                                        if ($interval->d != 0) {
                                            $gap .= $interval->d . ' Days';
                                        }
                                        if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0 || $interval->h != 0)) {
                                            $gap .= ' And ';
                                        }
                                        if ($interval->i != 0) {
                                            $gap .= $interval->i . ' Minutes';
                                        }
                                        if ($interval->h != 0) {
                                            $gap .= $interval->h . ' Hours';
                                        }

                                    }
                                    if ($edit_distributor_product_id_p_time == $dis_code) {
                                        $select = "selected";
                                    }

                                    echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_name . " (" . $gap . ")" . "</option>";
                                }
                                ?>
                            </select>


                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->

                <?php }
                if (array_key_exists('g_QOS', $field_array) || $package_features == "all") {
                    ?>

                    <div class="control-group" id="g_prof2">
                        
                        <div class="controls col-lg-5 form-group">

                            <label 
                               for="AP_contrl_guest">Guest Product
                               <?php if ($field_array['g_QOS'] == "mandatory") { ?>
                                <font color="#FF0000"></font></sup><?php } ?>
                        </label>

                            <select
                                <?php if ($field_array['g_QOS'] == "mandatory"){ ?>required<?php } ?>
                                name="AP_contrl_guest"
                                id="AP_contrl_guest"
                                class="span4 form-control"
                                style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                <option value="">Select Guest
                                    Profile
                                </option>
                                <?php

                                $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor'";

                                $query_results = $db->selectDB($q1);
                                
                                foreach ($query_results['data'] AS $row) {
                                    $select = "";
                                    $dis_code = $row[product_code];
                                    $dis_g_id = $row[product_id];
                                    $dis_name = $row[product_name];
                                    $dis_QOS = $row[QOS];

                                    if ($edit_distributor_product_id_g == $dis_g_id) {
                                        $select = "selected";
                                    }

                                    echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code ." [".$dis_QOS."]</option>";
                                }
                                ?>
                            </select>
							 <a <?php if ($sync_array['g_QOS_sync'] == 'display') {
								echo 'style="display: inline-block;padding: 6px 20px !important;"';
							} else {
								echo 'style="display:none"';
							} ?> onclick="gotoSync();"
								 class="btn btn-primary qos-sync-button"
								 style="align: left;"><i
										class="btn-icon-only icon-refresh"></i>
								Sync</a>
							<div style="display: inline-block"
								 id="sync_loader"></div>
                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->


                    <?php if ($field_array['g_QOS_du'] == 'display_none') { ?>
                        <style>
                            #gd_prof {
                                display: none !important;

                            }
                        </style>

                    <?php } ?>

                    <div class="control-group" id="gd_prof">
                        
                        <div class="controls col-lg-5 form-group">

                            <label
                               for="AP_contrl">Duration
                            Profile<?php if ($field_array['p_QOS'] == "mandatory") { ?>
                                <font color="#FF0000"></font></sup><?php } ?>
                        </label>

                            <select
                                <?php if ($field_array['g_QOS'] == "mandatory" && $field_array['g_QOS_du'] != 'display_none'){ ?>required<?php } ?>
                                name="AP_contrl_guest_time"
                                id="AP_contrl_guest_time"
                                class="span4 form-control">
                                <option value="">Select
                                    Profile
                                </option>
                                <?php
                                $q1 = "SELECT id,profile_code,profile_name,duration,profile_type
                                                        FROM exp_products_duration
                                                        WHERE profile_type IN('1','3') AND distributor='$user_distributor'";

                                $query_results = $db->selectDB($q1);
                               
                                foreach ($query_results['data'] AS $row) {
                                    $select = "";
                                    $dis_id = $row[id];
                                    $dis_code = $row[profile_code];
                                    $dis_name = $row[profile_name];
                                    $timegap = $row[duration];
                                    $gap = "";
                                    if ($timegap != '') {

                                        $interval = new DateInterval($timegap);

                                        if ($interval->y != 0) {
                                            $gap .= $interval->y . ' Years ';
                                        }
                                        if ($interval->m != 0) {
                                            $gap .= $interval->m . ' Months ';
                                        }
                                        if ($interval->d != 0) {
                                            $gap .= $interval->d . ' Days ';
                                        }
                                        if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0 || $interval->h != 0)) {
                                            $gap .= ' And ';
                                        }
                                        if ($interval->h != 0) {
                                            $gap .= $interval->h . ' Hours ';
                                        }
                                        if ($interval->i != 0) {
                                            $gap .= $interval->i . ' Minutes';
                                        }


                                    }
                                    if ($edit_distributor_product_id_g_time == $dis_code) {
                                        $select = "selected";
                                    }
                                    echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_name . " (" . $gap . ")" . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->

                <?php }
                if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") {
                    ?>

                    <div class="control-group"
                         id="vt_guest_def">
                        
                        <div class="controls col-lg-5 form-group">

                            <label
                               for="AP_contrl_guest">vTenant
                            default Product
                        </label>

                            <select
                                <?php if ($field_array['vt_QOS_def'] == "mandatory"){ ?>required<?php } ?>
                                name="vt_guest_def"
                                id="vt_guest_def_id"
                                class="span4 form-control"
                                style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                <option value="">Select vTenant
                                    Profile
                                </option>
                                <?php

                                $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='VTENANT' AND mno_id='$user_distributor'";

                                $query_results = $db->selectDB($q1);
                                
                                foreach ($query_results['data'] AS $row) {
                                    $select = "";
                                    $dis_code = $row[product_code];
                                    $dis_g_id = $row[product_id];
                                    $dis_name = $row[product_name];
                                    $dis_QOS = $row[QOS];

                                    if ($edit_distributor_product_id_def == $dis_g_id) {
                                        $select = "selected";
                                    }

                                    echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code ." [".$dis_QOS."]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- /controls -->
                        <div class="controls col-lg-5 form-group">

                            <label
                               for="AP_contrl_guest">vTenant
                            additional Override QoS Profile [<font color="red">optional</font>]
                        </label>
                        <?php
                        if($edit_account=='1'){
                            $assign_qos=array();
                            $edit_acc_realm=$vtenant_model->getDistributorVtenant($edit_distributor_code);
                                if($edit_acc_realm!==false){$vt_type = $edit_acc_realm->getType()=='VTENANT'?'(VT)':'(MDU)';
                                $realmvt=$edit_acc_realm->getRealm();

                               // echo $edit_acc_realm;
                                $selectQ="SELECT `qos_override`
                                        FROM mdu_vetenant 
                                        WHERE property_id='$realmvt' AND LENGTH (qos_override) > 0";
                                $query_Q=$db->selectDB($selectQ);

                                foreach($query_Q['data'] AS $datanew) {
                                    array_push($assign_qos, $datanew['qos_override']);
                                }}
                            }
                         $key_query = "SELECT `id`,`qos_id`,`qos_code`,`qos_name`,`network_type`
                                        FROM exp_qos 
                                        WHERE network_type <> 'VTENANT' AND mno_id='$user_distributor'";
                            $query_results=$db->selectDB($key_query);
                         $qos_defult=$db->getValueAsf("SELECT QOS as f
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor'");
                         if (strlen($edit_distributor_code)!=0) {
                         $key_queryn = "SELECT qos_id,qos_code
                                        FROM exp_qos_distributor
                                        WHERE `distributor_code`='$edit_distributor_code'";
                            $query_resultsn=$db->selectDB($key_queryn);
                                    }
                            $selected_qos=array();
                            foreach($query_resultsn['data'] AS $row) {
                                array_push($selected_qos, $row['qos_id']);
                            }
                            
                            foreach($query_results['data'] AS $row) {
                                //print_r($row);
                                if($row['qos_code']!=$qos_defult){
                                if (in_array($row['qos_id'], $selected_qos) AND in_array($row['qos_id'], $assign_qos)){
                                    $checked='checked';
                                    $disabled='readonly';
                                ?>
                              <div style="margin-bottom: -15px;">
                              <div class="checkbox-disable"> </div>
                            <input <?php echo $checked; ?> <?php echo $disabled; ?> class="span4 form-control <?php echo $disabled; ?>" onclick="" name="qos_probation[]" type="checkbox" value="<?php echo $row['id']; ?>">
                            <?php echo $row['qos_name']; ?>
                          </div>
                        <?php } elseif (in_array($row['qos_id'], $selected_qos)) {
                                    $checked='checked';
                         ?>
                            <input <?php echo $checked; ?> class="span4 form-control" onclick="" name="qos_probation[]" type="checkbox" value="<?php echo $row['id']; ?>">
                            <?php echo $row['qos_name']; ?>
                            <?php }
                                else{ ?>
                            <input class="span4 form-control" onclick="" name="qos_probation[]" type="checkbox" value="<?php echo $row['id']; ?>">
                            <?php echo $row['qos_name']; ?>
                                <?php 
                            }  ?>
                        
                    <?php //echo $row['qos_name'];
                    echo "</br>"; 
                }
            }
            ?>
                        </div>
                    </div>
                    <!-- /control-group -->

                <?php }
                if ($package_functions->getSectionType('VTENANT_TYPE',$system_package)!='1' && (array_key_exists('vt_QOS_pro', $field_array) || $package_features == "all")) {

                    ?>

                    <div class="control-group"
                         id="vt_guest_pro">
                        
                        <div class="controls col-lg-5 form-group">

                            <label
                               for="AP_contrl_guest">vTenant
                            probation QoS Profile
                        </label>

                            <select
                                <?php if ($field_array['vt_QOS_pro'] == "mandatory"){ ?>required<?php } ?>
                                name="vt_guest_pro"
                                id="vt_guest_pro_id"
                                class="span4 form-control"
                                style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                <option value="">Select
                                    Profile
                                </option>
                                <?php

                                $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor'";

                                $query_results = $db->selectDB($q1);
                                
                                foreach ($query_results['data'] AS $row) {
                                    $select = "";
                                    $dis_code = $row[product_code];
                                    $dis_g_id = $row[product_id];
                                    $dis_name = $row[product_name];
                                    $dis_QOS = $row[QOS];

                                    if ($edit_distributor_product_id_pro == $dis_g_id) {
                                        $select = "selected";
                                    }

                                    echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->

                <?php }
                if ($package_functions->getSectionType('VTENANT_TYPE',$system_package)!='1' && (array_key_exists('vt_QOS_pri', $field_array) || $package_features == "all")) {
                    ?>

                    <div class="control-group"
                         id="vt_guest_pri">
                       
                        <div class="controls col-lg-5 form-group">

                             <label 
                               for="AP_contrl_guest">vTenant
                            premium QoS Profile
                        </label>

                            <select
                                <?php if ($field_array['vt_QOS_pri'] == "mandatory"){ ?>required<?php } ?>
                                name="vt_guest_pri"
                                id="vt_guest_pri_id"
                                class="span4 form-control"
                                style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                <option value="">Select
                                    Profile
                                </option>
                                <?php

                                $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor'";

                                $query_results = $db->selectDB($q1);
                                
                                foreach ($query_results['data'] AS $row) {
                                    $select = "";
                                    $dis_code = $row[product_code];
                                    $dis_g_id = $row[product_id];
                                    $dis_name = $row[product_name];
                                    $dis_QOS = $row[QOS];

                                    if ($edit_distributor_product_id_pri == $dis_g_id) {
                                        $select = "selected";
                                    }

                                    echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->

                <?php }

            }
            if(array_key_exists('content_filter_dns',$field_array) ||  $package_features=="all"){
            ?>
			<br>
            <div class="control-group" >
                        
                        <div class="controls col-lg-5 form-group">

                <h3 id="pg_prof">Optional Features</h3>

            </div>
        </div>

        

        <div class="control-group" >
                        
                        <div class="controls col-lg-5 form-group">

                            <label  for="optona feature content filtering">Content Filtering<?php if($field_array['g_QOS']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>

                            <select <?php if($field_array['content_filter_dns']=="mandatory"){ ?>required<?php } ?> name="DNS_profile" id="DNS_profile"  class="span4 form-control" style="margin-right:16px">
                                <?php echo'<option value="">Select Option</option>';

                                if($edit_distributor_dns_profile){
                                    $sel_ap="AND  w.`controller`='$edit_distributor_ap_controller'";
                                }else{
                                    $sel_ap='';
                                }

                                $get_wags_per_controller="SELECT w.`profile_code`,w.`name` FROM `exp_controller_dns` w , `exp_mno_ap_controller` c
                                                            WHERE w.`controller`=c.`ap_controller` ".$sel_ap." AND c.`mno_id`='$user_distributor' GROUP BY w.`profile_code`";

                                $get_wags_per_controller_r=$db->selectDB($get_wags_per_controller);
                                
                                foreach ($get_wags_per_controller_r['data'] AS $get_wags_per_controller_d) {
                                    if($edit_distributor_dns_profile==$get_wags_per_controller_d[profile_code]){
                                        $wag_select="selected";
                                    }else{
                                        $wag_select='';
                                    }
                                    echo'<option '.$wag_select.' value="'.$get_wags_per_controller_d[profile_code].'">'.$get_wags_per_controller_d[name].'</option>';
                                }
                                ?>
                            </select>
                            
                            <input id="DNS_profile_control" name="DNS_profile_control" value="on" onchange="dns_control()" type="checkbox" data-size="mini" <?php if($edit_distributor_dns_profile_enable == 1 ){echo 'checked'; }?> data-toggle="toggle" data-onstyle="success" data-offstyle="warning">
                                <script>
                                    
                                
                                function dns_control(){
                                   /*  var add_ap_form_validator = $('#location_form').data('bootstrapValidator');
                                    var dnscheckBox = document.getElementById("DNS_profile_control");
                                       // alert(dnscheckBox);
                                 if (dnscheckBox.checked == true){
                                    add_ap_form_validator.enableFieldValidators('DNS_profile', true);
                                 } else {
                                    add_ap_form_validator.enableFieldValidators('DNS_profile', false);
                                              } */
                                    
                                }

                                </script>
                            <script>

                                function seldns(scrt_var){


                                    var a = scrt_var.length;


                                    // document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";

                                    //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                    $.ajax({
                                        type: 'POST',
                                        url: 'ajax/refreshDNSProfiles.php',
                                        data: { loc_GRE: "yes", ap_control_var: scrt_var,user: '<?php echo $user_distributor; ?>' },
                                        success: function(data) {

                                            //alert(data);
                                            $('#DNS_profile').empty();

                                            $("#DNS_profile").append(data);


                                            // document.getElementById("zones_loader").innerHTML = "";

                                        }

                                    });



                                }

                            </script>
                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->

            <?php
                } ?>

    </div>

  </div>

  <div class="create_r">

    <div class="control-group">
          <div class="controls col-lg-5 form-group">
              <h3>Location Info</h3>

          </div>
      </div>

    <?php
             if(array_key_exists('account_type',$field_array)){

                 $js_array=array();


                 foreach ($parent_package_array as $value){

                     //$package_functions->getOptions('LOCATION_PACKAGE',$value);

                     $location_package_ar=explode(',',$package_functions->getOptions('LOCATION_PACKAGE',$value));
                     $produts = "'" . implode("','", $location_package_ar) . "'";
                     $get_types_q="SELECT p.`product_name`,p.`product_code`,c.options FROM `admin_product` p LEFT JOIN admin_product_controls c
                                        ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                    WHERE `is_enable`='1' AND p.user_type='VENUE' AND p.product_code IN( $produts)";
                     //"SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
                     $get_types_r=$db->selectDB($get_types_q);

                     $location_detail_ar = array();
                     foreach($get_types_r['data'] as $get_types){
                         array_push($location_detail_ar ,array("code"=>$get_types[product_code],"name"=>$get_types[product_name],"vt"=>$get_types[options]));
                     }

                     $js_array[$value] = $location_detail_ar;

                 }
                 //print_r(json_encode($js_array));

                ?>


            <div class="control-group">
                <div class="controls col-lg-5 form-group">
                <label for="customer_type">Account Type<?php if($field_array['account_type']=="mandatory"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                    <select name="customer_type" id="customer_type" class="span4 form-control" <?php if($field_array['account_type']=="mandatory"){ ?>required<?php } ?>>
                        <option value="">Select Type</option>
                        <?php
                        //echo'**'. $edit_parent_package.'**';
                        //print_r($js_array[$edit_parent_package]);
                            if(isset($edit_parent_package)) {
                                $produts = $js_array[$edit_parent_package] ;
                                foreach($produts as $value){

                                    if($edit_distributor_system_package==$value['code']){
                                        ?>
                                        <option selected value="<?php echo$value['code'];?>" data-vt="<?php echo$value['vt'];?>"><?php echo$value['name'];?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?php echo$value['code'];?>" data-vt="<?php echo$value['vt'];?>"><?php echo$value['name'];?></option>
                                        <?php
                                    }
                                }
                            }elseif(count($js_array)==1){
                                foreach($js_array as $adminValue) {

                                    foreach ($adminValue as $value) {
                                            ?>
                                            <option value="<?php echo $value['code']; ?>" data-vt="<?php echo$value['vt'];?>"><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                }
                            }
                            //$get_types_q="SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
                            //$get_types_r=mysql_query($get_types_q);
                            //while($get_types=mysql_fetch_assoc($get_types_r)){

                        ?>
                    </select>

                </div>
            </div>
                <?php //if(!isset($edit_parent_package)){    ?>
                    <script>
                        $(document).ready(function() {
                            var product_json = '<?php echo json_encode($js_array); ?>';
                            var product_array = JSON.parse(product_json);


                            $('#parent_package1').change(function () {
                                //alert('sssssssss');
                                var value = $(this).val();

                                if(value){
                                $('#customer_type').children('option:not(:first)').remove();
                                var apend_ob = product_array[value];
                                

                                apend_ob.forEach(function(element) {
                                    //alert(element['code']);
                                    $("#customer_type").append('<option value="'+element['code']+'" data-vt="'+element['vt']+'">'+element['name']+'</option>');

                                });
                                }
                            });

                        });
                    </script>
                <?php    } //}





            if(array_key_exists('network_type',$field_array)){ ?>
                <input type="hidden"  id="old_network_type" name="old_network_type"  value="<?php echo $edit_distributor_network_type;?>" >
            
                <div class="control-group">
                    <div class="controls col-lg-5 form-group">
                    <label for="location_name1">Package Type<?php if($field_array['network_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                      <select class="form-control span4" multiple="multiple" id="network_type" name="network_type[]">
                            <option value="" disabled="disabled"> Choose Package(s)</option>

                            <?php
                                $operator_vt_option = $package_functions->getOptions('VTENANT_MODULE',$system_package);
                                if($operator_vt_option == 'Vtenant'){
                            ?>
                            <option <?php if(($edit_distributor_network_type=='VT') || ($edit_distributor_network_type=='VT-BOTH')|| ($edit_distributor_network_type=='VT-PRIVATE')|| ($edit_distributor_network_type=='VT-GUEST')){ echo 'selected'; }else{
                                echo '';
                            } ?> value="VT">VTenant</option>
                        <?php } ?>
                            <option <?php if(($edit_distributor_network_type=='GUEST') || ($edit_distributor_network_type=='VT-BOTH') || ($edit_distributor_network_type=='BOTH') || ($edit_distributor_network_type=='VT-GUEST')){ echo 'selected'; }else{
                                echo '';
                            } ?> value="GUEST">Guest</option>
                            <option  <?php if(($edit_distributor_network_type=='PRIVATE') || ($edit_distributor_network_type=='VT-BOTH') || ($edit_distributor_network_type=='BOTH') || ($edit_distributor_network_type=='VT-PRIVATE')){ echo 'selected'; }else{
                                echo '';
                            } ?> value="PRIVATE">Private</option>
                        </select>


                    </div>
                </div>
            <?php }
            if(array_key_exists('icomms_number',$field_array)){ ?>
                    <div class="control-group" id="icomme_div">
                        <div class="controls col-lg-5 form-group">
                        <label for="customer_type">Customer Account Number<?php if($field_array['icomms_number']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                            <input type="text" class="span4 form-control" id="icomme" name="icomme" onblur="check_icom(this)" value="<?php echo$edit_distributor_verification_number;?>" <?php if($edit_account==1){ ?>readonly<?php } ?>>
                            <div style="display: inline-block" id="img_icom"></div>
                        </div>
                        <script type="text/javascript">

                            $(document).ready(function() {



                                $("#icomme").keypress(function (e) {

                                    var ew = event.which;
                                    
                        //alert(ew);
                        // if(ew == 32)
                        //   return true;

                        if(ew == 45 || ew==95){ /*allow - and _ characters */
                            return true;
                        } 

                        if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122  || ew == 0  || ew == 8 || ew == 189 ){
                            return true;
                        }else{
                            return false; 
                        }


                                    /*var mac = $('#icomme').val();
                                    var len = mac.length + 1;
                                    // console.log(e.keyCode);
                                    //console.log('len '+ len);


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
                                        //  (e.keyCode == 190 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                        // Allow: home, end, left, right, down, up
                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                        // let it happen, don't do anything
                                        return;
                                    }
                                    // Ensure that it is a number and stop the keypress
                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                        e.preventDefault();

                                    }*/
                                });


                            });

                        </script>
                    </div>

                <div class="control-group" id="vt_icomme_div">
                    <div class="controls col-lg-5 form-group">
                    <label for="customer_type">vTenant Account Number<?php if($field_array['icomms_number']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                        <?php if($edit_account==1){ echo '<div class="sele-disable span4" ></div>';} ?>
                        <select type="text" onchange="fillrealm(this);" class="span4 form-control" id="vt_icomme" name="vt_icomme" <?php if($edit_account==1){ ?><?php } ?>>
                            <option value="">Select Option</option>
                            <?php
                            if($edit_account=='1'){
                                $edit_acc_realm=$vtenant_model->getDistributorVtenant($edit_distributor_code);
                                if($edit_acc_realm!==false){$vt_type = $edit_acc_realm->getType()=='VTENANT'?'(VT)':'(MDU)';
                                echo '<option selected value="'.$edit_acc_realm->getRealm().'">'.$edit_acc_realm->getRealm().$vt_type.'</option>';}
                            }
                            $mno_vtenants = $vtenant_model->getUnusedMNOVtenants($user_distributor);
                            foreach ($mno_vtenants as $vtenant){
                                $vt_type = $vtenant->getType()=='VTENANT'?'(VT)':'(MDU)';
                                echo '<option value="'.$vtenant->getRealm().'">'.$vtenant->getRealm().$vt_type.'</option>';

                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="control-group" id="vt_voucher_div">
                    <?php
                    if($edit_account=='1' && $edit_dpsk_enable){
                    if ($edit_dpsk_voucher=='SINGLEUSE') {
                       $selectsn='checked';
                     }else{
                      $selectsh='checked';

                     } ?>
                      <div class="controls col-lg-5 form-group"><label for="dpsk_voucher">Vtenant Account Creation Voucher <i title="All tenants will need a voucher to enable them to create an account. depending on level of security you can select from two options: <br>
                      1.Shared voucher means all tenant use the same voucher code for account creation <br>
                      2.Single-use voucher means each tenant gets a unique one time voucher for account creation " class="icon icon-question-sign tooltips" style="color : #0568ea;margin-top: 3px; display:inline-block !important; font-size: 18px"></i> </label><input type="radio" name="dpsk_voucher" value="SHARED" <?php echo $selectsh; ?> ><label style="display :inline-block;min-width: 29%; max-width: 100%; ">Shared</label><input type="radio" name="dpsk_voucher" value="SINGLEUSE" <?php echo $selectsn; ?> ><label style="display :inline-block;">Single Use</label></div>
                      <!-- $edit_distributor_network_type -->

                    <?php } ?>
                </div>

                <?php }

            if(array_key_exists('gateway_type',$field_array)){
                ?>
                <div class="control-group" id="gu_geteway_div">
                    <div class="controls col-lg-5 form-group">
                    <label for="gateway_type">Guest Gateway Type<?php if($field_array['gateway_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                        <select <?php if($field_array['gateway_type']=="mandatory" ){ ?>required<?php } ?> class="span4 form-control" id="gateway_type" name="gateway_type" >

                            <option value="">Select Gateway Type</option>
                            <?php

                            if(empty($edit_distributor_gateway_type)){
                                $edit_distributor_gateway_type ="VSZ";
                            }

                                    $get_gatw_type_q="select gs.gateway_name ,gs.description from exp_gateways gs where `is_enable` ='1'";
                                    $get_gatw_type_r=$db->selectDB($get_gatw_type_q);
                                    
                                    foreach ($get_gatw_type_r['data'] AS $gatw_row) {
                                            $gatw_row_gtw=$gatw_row['gateway_name'];
                                            $gatw_row_dis=$gatw_row['description'];
                                            ?>
                                                    <option <?php $edit_distributor_gateway_type==$gatw_row_gtw ? print(" selected ") :print (""); ?> value="<?php echo $gatw_row_gtw ;?>"> <?php echo $gatw_row_dis; ?> </option>;

                            <?php } ?>
                        </select>


                    </div>
                </div>
            <?php }

            if(array_key_exists('pr_gateway_type',$field_array)){ ?>
                <div class="control-group" id="pr_geteway_div">
                    <div class="controls col-lg-5 form-group">
                    <label for="pr_gateway_type">Private Gateway Type<?php if($field_array['pr_gateway_type']=="mandatory" ){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                        <select class="span4 form-control" id="pr_gateway_type" name="pr_gateway_type" >

                            <option value="">Select Gateway Type</option>
                            <?php
                                            if(empty($edit_distributor_pr_gateway_type)){
                                                $edit_distributor_pr_gateway_type ="VSZ";
                                            }

                                    $get_gatw_type_q="select gs.gateway_name ,gs.description from exp_gateways gs where `is_enable` ='1'";
                                    $get_gatw_type_r=$db->selectDB($get_gatw_type_q);
                                    
                                    foreach ($get_gatw_type_r['data'] AS $gatw_row) {
                                            $gatw_row_gtw=$gatw_row['gateway_name'];
                                            $gatw_row_dis=$gatw_row['description'];
                                            ?>
                                                    <option <?php $edit_distributor_pr_gateway_type==$gatw_row_gtw ? print(" selected ") :print (""); ?> value="<?php echo $gatw_row_gtw.'">'.$gatw_row_dis.'</option>';
                                    }

                            ?>

                        </select>


                    </div>
                </div>
            <?php  }

            if(array_key_exists('uui_number',$field_array)){
                    ?>
                    <div class="control-group" id="icomme_div">
                        <div class="controls col-lg-5 form-group">
                        <label for="uui_number">UUI Number<?php if($field_array['uui_number']=="mandatory"){ ?><font color="#FF0000"></font></sup><?php } ?></label>
                            <input <?php if($field_array['uui_number']=="mandatory"){ ?>required<?php } ?> type="text" class="span4 form-control" id="icomme" onblur="check_icom(this)" name="icomme" value="<?php echo$edit_distributor_verification_number;?>" <?php if($edit_account==1){ ?>readonly<?php } ?>>
                            <div style="display: inline-block" id="img_icom"></div>
                        </div>
                    </div>
                    <script type="text/javascript">

                        $(document).ready(function() {



                            $("#icomme").keydown(function (event) {

                                var ew = event.which;
                        //alert(ew);
                        // if(ew == 32)
                        //   return true;
                        if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 96 <= ew && ew <= 122  || ew == 0  || ew == 8 || ew == 189)
                          return true;
                        return false; 


                               /* var mac = $('#icomme').val();
                                var len = mac.length + 1;
                                //console.log(e.keyCode);
                                //console.log('len '+ len);


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

                                }*/
                            });


                        });

                    </script>
                    <?php
                }
                ?>

<script type="text/javascript">


$('#icomme').on('keyup change', function () {
$("#icomme_div small[data-bv-validator='notEmpty']").html('<p>This is a required field</p>');
});

function check_icom(icomval)
{

if ( $('#icomme').is('[readonly]') ) {


}else{

var valic = icomval.value;
var valic = valic.trim();



 if(valic!="") {
     document.getElementById("img_icom").innerHTML = "<img src=\"img/loading_ajax.gif\">";
     var formData = {icom: valic};
     $.ajax({
         url: "ajax/validateIcom.php",
         type: "POST",
         data: formData,
         success: function (data) {
             /*  if:new ok->1
              * if:new exist->2 */


             if (data == '1') {
              /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                 document.getElementById("img_icom").innerHTML ="";
                 document.getElementById("realm").value =valic;
                 <?php if($field_array['network_config']=='display_none'){ ?>
                 document.getElementById("zone_name").value =valic;
                 document.getElementById("zone_dec").value =valic;
                 <?php } ?>


             } else if (data == '2') {
                //alert(data);
                document.getElementById("img_icom").innerHTML ="";
                 document.getElementById('icomme').value = "";
                 document.getElementById("realm").value ="";
                 <?php if($field_array['network_config']=='display_none'){ ?>
                 document.getElementById("zone_name").value ="";
                 document.getElementById("zone_dec").value ="";
                 <?php } ?>
                 /* $('#mno_account_name').removeAttr('value'); */
                 document.getElementById('icomme').placeholder = "Please enter new Customer Account number";
             }


             $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic +' - Customer Account exists.</p>');

             $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');


         },
         error: function (jqXHR, textStatus, errorThrown) {
             alert("error");
             document.getElementById('icomme').value = "";
             document.getElementById("realm").value ="";
             <?php if($field_array['network_config']=='display_none'){ ?>
             document.getElementById("zone_name").value ="";
             document.getElementById("zone_dec").value ="";
             <?php } ?>


                $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic +' - Customer Account exists.</p>');


                $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');


              }



     });
     var bootstrapValidator2 = $('#location_form').data('bootstrapValidator');
     bootstrapValidator2.enableFieldValidators('realm', true);
     <?php if($field_array['network_config']=='display_none'){ ?>
     bootstrapValidator2.enableFieldValidators('zone_name', true);
     bootstrapValidator2.enableFieldValidators('zone_dec', true);

     <?php } ?>
 }


}





}

</script>



                <?php
                if(array_key_exists('location_type',$field_array) || $package_features=="all"){
                ?>

                    <div class="control-group" <?php if(array_key_exists('network_type',$field_array)){echo 'style="display:none"';} ?> >
                        <div class="controls col-lg-5 form-group">
                        <label for="user_type">Property Type<?php if($field_array['location_type']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>

                                <select <?php if($field_array['location_type']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> name="user_type" id="user_type" class="span4 form-control" <?php  if(isset($edit_distributor_type)){ echo 'disabled';} ?>>

                                    <option value=''>Select Account Type</option>
                                    <?php // } ?>




                                <?php

                                    if($user_type == 'MNO'){

                                        if(array_key_exists('network_type',$field_array)){ $edit_distributor_type='MVNO';}
                                        $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=3 AND `is_enable`=1";
                                        $mno_flow=$db->selectDB($mno_flow_q);
                                        
                                        foreach ($mno_flow['data'] AS $mno_flow_row) {
                                            if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                $select="selected";
                                            }else{
                                                $select="";
                                            }
                                            echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                        }


                                        /*echo '
                                        <option value="MVNA">MVNA - Re Seller</option>
                                        <option value="MVNE">MVNE - Hoster</option>
                                        <option value="MVNO">MVNO - Service Provider</option>';*/
                                    }

                                    else if($user_type == 'MVNA'){

                                        $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=3 AND `is_enable`=1";
                                        $mno_flow=$db->selectDB($mno_flow_q);
                                        
                                        foreach ($mno_flow['data'] AS $mno_flow_row) {
                                            if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                $select="selected";
                                            }else{
                                                $select="";
                                            }
                                            echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                        }

                                        //echo '<option value="MVNO">MVNO - Service Provider</option>';
                                    }

                                    else if($user_type == 'MVNE'){

                                        $mno_flow_q="SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=2 AND `is_enable`=1";
                                        $mno_flow=$db->selectDB($mno_flow_q);
                                        
                                        foreach ($mno_flow['data'] AS $mno_flow_row) {
                                            if($edit_distributor_type==$mno_flow_row[flow_type]){
                                                $select="selected";
                                            }else{
                                                $select="";
                                            }
                                            echo '<option '.$select.' value='.$mno_flow_row[flow_type].'>'.$mno_flow_row[flow_name].'-'.$mno_flow_row[description].'</option>';
                                        }


                                        //echo '<option value="MVNO">MVNO - Service Provider</option>';
                                    }
                                ?>

                                </select>

                        </div>
                    </div>
                <?php } 


                if(array_key_exists('network_config',$field_array)){

            ?>

            <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                    <h3>Assign Network</h3>

                </div>
            </div>
            <div class="control-group">
                        <div class="controls col-lg-5 form-group">
            <label >Automation <font color="#FF0000"></font></sup> 
                <input id="automation_property" name="automation_property" onchange="automation_control()" type="checkbox" data-size="mini" checked="checked" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">
              </label>
</div>
            </div>



<?php
//echo $_SESSION['s_token'].'***********';
//print_r($access_modules_list);
if(!in_array('support', $access_modules_list)){
?>

                    <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="conroller">AP Controller<sup><font color="#FF0000"></font></sup></label>
                            <select onchange="updatevariable(); selwags(this.value);gotoNode(this.value);seldns(this.value);" name="conroller" id="conroller"  class="span4 form-control con_c" required>
                                <option value="">Select AP Controller</option>
                               <?php
                                            $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='AP'";

                                            $query_results=$db->selectDB($q1);
                                            
                                            foreach ($query_results['data'] AS $row) {

                                                //$mnoid=$row[mno_id];
                                                $apc=$row[ap_controller];

                                                $ap_controller = preg_replace('/\s+/', '', $apc);
                                                if($edit_distributor_ap_controller==$apc){
                                                    $controller_sel='selected';
                                                }else{
                                                    $controller_sel='';
                                                }

                                                echo "<option   ".$controller_sel."  class='".$ap_controller."' value='".$apc."'>".$apc."</option>";
                                            }
                                            ?>
                            </select>

                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->

<?php
if(isset($edit_distributor_ap_controller)){



?>

<script>
$(document).ready(function() {
gotoNode_edit('<?php echo $edit_distributor_ap_controller;?>','<?php echo $edit_distributor_zone_id; ?>');
});

function gotoNode_edit(scrt_var,edit_zone){



var a = scrt_var.length;

if(a==0){

alert('Please Select Controller before Refresh!');

}else{
document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
//window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

$.ajax({
type: 'POST',
url: 'ajax/get_zones.php',
data: { wag_ap_name: "<?php echo $wag_ap_name; ?>", ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,mno:"<?php echo $user_distributor; ?>",mvno:"<?php echo $edit_distributor_code; ?>",edit_zone:edit_zone },
success: function(data) {

/* alert(data); */
$('#zone').empty();

$("#zone").append(data);


document.getElementById("zones_loader").innerHTML = "";

},
error: function(){
document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
}

});



}

}
</script>
<?php
}
?>

                    <script type="text/javascript">
var value = "test";
function updatevariable() {
var conceptName = $( "#conroller" ).val();
value = conceptName;
scrt_var = conceptName;

$("#zone").select2();

}

$(document).ready(function() {
updatevariable();
});







function gotoNode(scrt_var){


var a = scrt_var.length;

if(a==0){

alert('Please Select Controller before Refresh!');

}else{
document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
//window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

$.ajax({
type: 'POST',
url: 'ajax/get_zones.php',
data: { wag_ap_name: "<?php echo $wag_ap_name; ?>", ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,mno:"<?php echo $user_distributor; ?>",mvno:"<?php echo $edit_distributor_code; ?>" },
success: function(data) {

/* alert(data); */
$('#zone').empty();

$("#zone").append(data);


document.getElementById("zones_loader").innerHTML = "";

},
error: function(){
 document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
}

});



}

}



/*function gotoSync(){

//var a = scrt_var.length;
alert('test');


document.getElementById("sync_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
//window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

$.ajax({
type: 'POST',
url: 'ajax/get_profile.php',
data: { user_distributor: "<?php echo $user_distributor; ?>",system_package: "<?php echo $system_package; ?>",user_name: "<?php echo $user_name; ?>" },
success: function(data) {

//alert(data); 
$('#AP_contrl_guest').empty();
$("#AP_contrl_guest").append(data);

$('#vt_guest_pri_id').empty();
$("#vt_guest_pri_id").append(data);

$('#vt_guest_def_id').empty();
$("#vt_guest_def_id").append(data);

$('#vt_guest_pro_id').empty();
$("#vt_guest_pro_id").append(data);


document.getElementById("sync_loader").innerHTML = "";

},
error: function(){
document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
}

});





}   */


</script>



<script src="js/select2-3.5.2/select2.min.js"></script>
<link rel="stylesheet" href="js/select2-3.5.2/select2.css" />
<link rel="stylesheet" href="css/select2-bootstrap/select2-bootstrap.css" />
<script type="text/javascript">
$(document).ready(function() {
$("#zone").select2();
});
</script>





                <div id="zone_div" class="control-group" style="margin-bottom: 3px !important;">
                    <div class="controls col-lg-5 form-group">
                    <label for="zone">Zones<sup><font color="#FF0000"></font></sup></label>
                        <select  name="zone" id="zone"  class="span4 form-control zone_c" >
                            <option value="">Select Zone</option>
                            <?php
                            $q1 = "SELECT t1. zname AS name, t1.zid AS zoneid , t1.controller AS ap_controller,t1.`bzname` FROM
                                                    (SELECT IFNULL(bz.name,'1') AS bzname, z.`name` AS zname, z.zoneid AS zid, z.ap_controller AS controller, IFNULL(d.`distributor_code`,'1') AS ok
                                                    FROM `exp_mno_ap_controller` c,
                                                    exp_distributor_zones z LEFT JOIN  `exp_mno_distributor` d ON z.`zoneid`=d.`zone_id`
                                                    LEFT JOIN `exp_distributor_block_zones` bz ON bz.`name`=z.`name`
                                                    WHERE z.`ap_controller` = c.`ap_controller`
                                                    AND c.`mno_id` = '$user_distributor') t1
                                                    WHERE t1.bzname='1' AND t1.ok";//='1'";
                            if(isset($edit_distributor_zone_id)){
                                $q1.=" IN('1','$edit_distributor_code')";
                            }else{
                                $q1.=" ='1'";
                            }


                            $query_results=$db->selectDB($q1);
                            
                            foreach ($query_results['data'] AS $row) {
                                $zonename = $row[name];
                                $zoneid=$row[zoneid];
                                $ap_controller=$row[ap_controller];

                                $ap_controller = str_replace(' ', '', $ap_controller);

                                if($edit_distributor_zone_id==$zoneid){
                                    $select="selected";
                                    $edit_distributor_zone_name = $zonename;
                                }else{
                                    $select="";
                                    continue;

                                }

                                echo "<option ".$select." class='selectors ".$ap_controller."' value='".$zoneid."'>".$zonename."</option>";
                            }
                            //echo $q1;
                            ?>
                        </select>




                        <a style="display: inline-block; padding: 6px 20px !important;margin-bottom: 10px !important;" onclick="updatevariable();gotoNode(''+ scrt_var +'');" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                        <div style="display: inline-block" id="zones_loader"></div>


                        <style>
                            .select2-container{
                                margin-right: 20px !important;
                                margin-bottom: 15px !important;
                            }
                        </style>



                    </div>

                    <!-- /controls -->
                </div>
                <!-- /control-group -->
            <?php if(isset($edit_distributor_zone_id)){ ?>
                <div style="margin-top: -3px;" class="control-group"  <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?>  >
                    <div style="margin-top: 0px;" class="controls col-lg-5 form-group">

                        <small>Current Zone : <b><?php
                                echo empty($edit_distributor_zone_name)?
                                    '<font color="red">Zone does not exists</font>'
                                    :$edit_distributor_zone_name;
                                ?></b></small>

                    </div>
                </div>
            <?php } ?>

                <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="conrollernew">SW Controller<sup><font color="#FF0000"></font></sup></label>
                            <select onchange="updateSWvariable();gotoSWNode(this.value);"  name="conrollernew" id="conrollernew"  class="span4 form-control sw_con_c">
                                <option value="">Select SW Controller</option>
                               <?php
                                           $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='SW'";

                                            $query_results=$db->selectDB($q1);
                                            
                                            foreach ($query_results['data'] AS $row) {

                                                //$mnoid=$row[mno_id];
                                                $apc=$row[ap_controller];

                                                $ap_controller = preg_replace('/\s+/', '', $apc);
                                                if($edit_distributor_ap_controller==$apc){
                                                    $controller_sel='selected';
                                                }else{
                                                    $controller_sel='';
                                                }

                                                echo "<option   ".$controller_sel."  class='".$ap_controller."' value='".$apc."'>".$apc."</option>";
                                            }
                                            ?>
                            </select>

                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->

                <script type="text/javascript">
                var value = "test";
                function updateSWvariable() {
                    var sw_data = $( "#sw_conroller" ).val();
                    sw_value = sw_data;
                    sw_scrt_var = sw_data;
                    $("#groups").select2();

                }

                $(document).ready(function() {
                    updateSWvariable();
                });






                function gotoSWNode(sw_scrt_var){


                    var a = sw_scrt_var.length;

                    if(a==0){

                        alert('Please Select Controller before Refresh!');

                    }else{
                        document.getElementById("group_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                        //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                        $.ajax({
                            type: 'POST',
                            url: 'ajax/get_swGroups.php',
                            data: { wag_ap_name: "<?php echo $wag_ap_name; ?>", ap_control_var: "<?php echo $ap_control_var; ?>",ackey:sw_scrt_var,mno:"<?php echo $user_distributor; ?>",mvno:"<?php echo $edit_distributor_code; ?>" },
                            success: function(data) {

                                /* alert(data); */
                                $('#groups').empty();

                                $("#groups").append(data);


                                document.getElementById("group_loader").innerHTML = "";

                            },
                            error: function(){
                                document.getElementById("group_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                            }

                        });



                    }

                }

                </script>

<script type="text/javascript">
$(document).ready(function() {
$("#groups").select2();
});
</script>

                <div id="group_div" class="control-group" style="margin-bottom: 3px !important;">
                    <div class="controls col-lg-5 form-group">
                    <label for="groups">Groups<sup><font color="#FF0000"></font></sup></label>
                        <select  name="groups" id="groups"  class="span4 form-control group_c" >
                            <option value="">Select Group</option>
                            <?php
                            if(!empty($edit_distributor_sw_group_id)) {
                                include_once 'classes/ICXSwitch.php';
                                $sync_obj = Sync_sw_group::withVerificationNumber($edit_distributor_verification_number);
                                try {
                                    $sync_obj->syncGroupById($edit_distributor_sw_group_id);
                                } catch (Exception $e) {
                                }
                            }

                            $q1 = "SELECT DISTINCT t1.zid AS zoneid , t1. zname AS name,  t1.controller AS ap_controller,t1.`bzname` FROM
(SELECT IFNULL(bz.name,'1') AS bzname, g.`name` AS zname, g.groupid AS zid, g.ap_controller AS controller, IFNULL(d.`distributor_code`,'1') AS ok
FROM `exp_mno_ap_controller` c,
exp_distributor_switch_groups g LEFT JOIN  `exp_mno_distributor` d ON g.`groupid`=d.switch_group_id
LEFT JOIN `exp_distributor_block_zones` bz ON bz.`name`=g.`name`
WHERE g.`ap_controller` = c.`ap_controller`
AND c.`mno_id` = '$user_distributor') t1
WHERE t1.bzname='1' AND t1.ok";
                            if(isset($edit_distributor_sw_group_id)){
                                $q1.=" IN('1','$edit_distributor_code') AND t1.controller='".$edit_distributor_sw_controller."'";
                                $query_results=$db->selectDB($q1);
                            }/*else{
                                $q1.=" ='1'";
                            }*/


                            $query_results=$db->selectDB($q1);
                           
                            foreach ($query_results['data'] AS $row) {
                                $zonename = $row[name];
                                $zoneid=$row[zoneid];
                                $ap_controller=$row[ap_controller];

                                $ap_controller = str_replace(' ', '', $ap_controller);

                                if($edit_distributor_sw_group_id==$zoneid){
                                    $select="selected";
                                    $edit_distributor_zone_name = $zonename;
                                }else{
                                    $select="";

                                }

                                echo "<option ".$select." class='selectors ".$ap_controller."' value='".$zoneid."'>".$zonename."</option>";
                            }
                            //echo $q1;
                            ?>
                        </select>




                        <a style="display: inline-block; padding: 6px 20px !important;margin-bottom: 10px !important;" onclick="updateSWvariable();gotoSWNode(sw_scrt_var);" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                        <div style="display: inline-block" id="group_loader"></div>


                        <style>
                            .select2-container{
                                margin-right: 20px !important;
                                margin-bottom: 15px !important;
                            }
                        </style>



                    </div>

                    <!-- /controls -->
                </div>
                <!-- /control-group -->






<script>

function selwags(scrt_var){


var a = scrt_var.length;


// document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";

//window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

$.ajax({
type: 'POST',
url: 'ajax/refreshGREProfiles.php',
data: { loc_GRE: "yes", ap_control_var: scrt_var,user: '<?php echo $user_distributor; ?>' },
success: function(data) {

//alert(data);
$('#wag_name').empty();

$("#wag_name").append(data);


// document.getElementById("zones_loader").innerHTML = "";

},
error: function(){
 // document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
}

});



}

</script>


                <div class="control-group"  id="gateway" <?php  if($edit_distributor_gateway_type=='ac' || $field_array['ne_WAG']=='display_none' ){echo 'style="display: none; margin-bottom: 3px !important;"';}else{echo 'style="margin-bottom: 3px !important;"';}?> >
                    <div class="controls col-lg-5 form-group">
                    <label for="zone_name">WAG<sup><font color="#FF0000"></font></label>
                        <select  class="span4 form-control" id="wag_name" name="wag_name" style="display: inline-block">
                           <?php echo'<option value="">Select Option</option>';

                           if($edit_distributor_wag_profile){

                            $sel_ap="AND  w.`ap_controller`='$edit_distributor_ap_controller'";

                           }else{

                            $sel_ap='';

                           }

                            $get_wags_per_controller="SELECT w.`wag_code`,w.`wag_name` FROM `exp_wag_profile` w , `exp_mno_ap_controller` c
                                                            WHERE w.`ap_controller`=c.`ap_controller` ".$sel_ap." AND c.`mno_id`='$user_distributor' GROUP BY w.`wag_code`";

                            $get_wags_per_controller_r=$db->selectDB($get_wags_per_controller);
                           
                            foreach ($get_wags_per_controller_r['data'] AS $get_wags_per_controller_d) {
                                if($edit_distributor_wag_profile==$get_wags_per_controller_d[wag_code]){
                                    $wag_select="selected";
                                }else{
                                    $wag_select='';
                                }
                                echo'<option '.$wag_select.' value="'.$get_wags_per_controller_d[wag_code].'">'.$get_wags_per_controller_d[wag_name].'</option>';
                            }
                            ?>
                        </select><input type="checkbox" <?php if($edit_distributor_wag_profile_enable=='1' || $edit_distributor_wag_profile_enable=='on' ){echo 'checked'; }?> name="content_filter" class="hide_checkbox" style="display: inline-block;" data-toggle="toggle" >
                    </div>
                    <small>Note: Turn switch to ON to enable content filtering</small>
                </div>

                <style>
                            #wag_name{
                                margin-right: 20px !important;
                                margin-bottom: 15px !important;
                            }

                            div.toggle{
                                margin-bottom: 15px !important;
                            }

                        </style>




                <div class="control-group"  <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?>  >
                    <div class="controls col-lg-5 form-group">
                    <label for="zone_name">Unique Property ID<sup><font color="#FF0000"></font></label>
                        <input class="span4 form-control" id="zone_name" name="zone_name" type="text" placeholder="Circuit ID#" maxlength="32" value="<?php echo$edit_distributor_property_id;?>">
                    </div>
                </div>

                            <script type="text/javascript">
                      $("#zone_name").keypress(function(event){
                         
                        var ew = event.which;
                       // alert(ew);
                       if(ew == 45 || ew == 95 || ew == 189)
                          return true;
                        if(ew == 32)
                          return true;
                        if(ew == 47)
                          return true;
                        if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 96 <= ew && ew <= 122 || ew == 0  || ew == 8 || ew == 189)
                          return true;
                        return false;
                      });
                    </script>


                <div class="control-group"  <?php if($field_array['network_config_des']=='display_none'){echo 'style="display:none"';} ?>  >
                    <div class="controls col-lg-5 form-group">
                    <label for="zone_dec">Description<sup><font color="#FF0000"></font></label>
                        <input class="span4 form-control" id="zone_dec" name="zone_dec" type="text" placeholder="Coffeeshop chain" value="<?php echo$edit_distributor_group_description;?>">
                    </div>
                </div>

                <div class="control-group" <?php if($field_array['network_config_realm']=='display_none'){echo 'style="display:none"';} ?>  >
                    <div class="controls col-lg-5 form-group">
                    <label for="zone_dec">Realm<sup><font color="#FF0000"></font></label>
                        <input required  style="display: inline-block" class="span4 form-control" id="realm" name="realm" type="text" placeholder="123456789" onblur="vali_realm(this)" value="<?php echo $edit_distributor_realm;?>" <?php if(array_key_exists('icomms_number',$field_array)){ if($edit_account==1) echo "readonly"; } ?>>
                        <div style="display: inline-block" id="img"></div>
                    </div>
                </div>

                <script>

                    $(document).ready(function() {
                        $("#zone_uid_nouse").keydown(function (e) {
                            // Allow: backspace, delete, tab, escape, enter and .
                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                    // Allow: Ctrl+A, Command+A
                                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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
            <?php if($edit_account!=1){   ?>
                <script>
                    function vali_realm(rlm) {
                        var val = rlm.value;
                        var val = val.trim();



                        if(val!="") {
                            document.getElementById("img").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                            var formData = {realm: val};
                            $.ajax({
                                url: "ajax/validateRealm.php",
                                type: "POST",
                                data: formData,
                                success: function (data) {
                                    /*  if:new ok->1
                                     * if:new exist->2 */
                                    /* alert(data);*/

                                    if (data == '1') {
                                        /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                        document.getElementById("img").innerHTML ="";

                                    } else if (data == '2') {

                                        document.getElementById("img").innerHTML = "<p style=\"display: inline-block; color:red\">"+val+" - Realm is already exists.</p>";
                                        document.getElementById('realm').value = "";
                                        /* $('#mno_account_name').removeAttr('value'); */
                                        document.getElementById('realm').placeholder = "Please enter new realm";
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    alert("error");
                                    document.getElementById('realm').value = "";
                                }
                            });
                        }
                    }
                </script>
            <?php }

             }
            else{
?>
                <div class="control-group">
                    <div class="controls col-lg-5 form-group">
                    <label for="conroller">Controller<sup><font color="#FF0000"></font></sup></label>
                        <input readonly value="<?php echo $edit_distributor_ap_controller; ?>"  name="conroller" id="conroller"  class="span4 form-control "  required>
                    </div>
                    <!-- /controls -->
                </div>
                <!-- /control-group -->

                    <div class="control-group">
                        <div class="controls col-lg-5 form-group">
                        <label for="zone">Zones<sup><font color="#FF0000"></font></sup></label>
                            <input type="text" readonly value="<?php echo $db->getValueAsf("SELECT `name` AS f FROM `exp_distributor_zones` WHERE `zoneid`='$edit_distributor_zone_id'");?>"    class="span4 form-control" >
                            <input type="hidden" readonly value="<?php echo $edit_distributor_zone_id;?>"  name="zone" id="zone"  >
                        </div>
                        <!-- /controls -->
                    </div>
                    <!-- /control-group -->





                <div class="control-group" <?php  if($edit_distributor_gateway_type=='ac' || $field_array['ne_WAG']=='display_none' ){echo 'style="display: none; margin-bottom: 3px !important;"';}else{echo 'style="margin-bottom: 3px !important;"';}?> >
                    <div class="controls col-lg-5 form-group">
                    <label for="zone_name">WAG<sup><font color="#FF0000"></font></label>
                        <input readonly type="text"  value="<?php echo $db->getValueAsf("SELECT `wag_name` AS f FROM `exp_wag_profile` WHERE `wag_code`='$edit_distributor_wag_profile'"); ?>" required class="span4 form-control" style="display: inline-block">
                        <input readonly type="hidden"  value="<?php echo $edit_distributor_wag_profile; ?>" id="wag_name" name="wag_name" style="display: inline-block">
                             <input  type="checkbox" <?php if($edit_distributor_wag_profile_enable=='1'){echo 'checked'; }?> name="content_filter" class="hide_checkbox" style="display: inline-block" data-toggle="toggle" >
                    </div>
                        <small>Note: Turn switch to ON to enable content filtering</small>
                </div>




                <div class="control-group" <?php if($field_array['network_config']=='display_none'){echo 'style="display:none"';} ?> >
                            <div class="controls col-lg-5 form-group">
                            <label for="zone_name">Unique Property ID<sup><font color="#FF0000"></font></label>
                                <input readonly class="span4 form-control" id="zone_name" name="zone_name" type="text" placeholder="Circuit ID#" value="<?php echo$edit_distributor_property_id;?>">
                            </div>
                        </div>




<div class="control-group" <?php if($field_array['network_config_des']=='display_none'){echo 'style="display:none"';} ?> >
                            <div class="controls col-lg-5 form-group">
                            <label for="zone_dec">Description<sup><font color="#FF0000"></font></label>
                                <input readonly class="span4 form-control" id="zone_dec" name="zone_dec" type="text" placeholder="Coffeeshop chain" value="<?php echo$edit_distributor_group_description;?>">
                            </div>
                        </div>

                <div class="control-group"  <?php if($field_array['network_config_realm']=='display_none'){echo 'style="display:none"';} ?> >
                    <div class="controls col-lg-5 form-group">
                    <label for="zone_dec">Realm<sup><font color="#FF0000"></font></label>
                        <input required  style="display: inline-block" class="span4 form-control" id="realm" name="realm" type="text" placeholder="123456789"  value="<?php echo $edit_distributor_realm;?>" <?php if(array_key_exists('icomms_number',$field_array)){ if($edit_account==1) echo "readonly"; } ?>>
                    </div>
                </div>



                <?php
            }
                $get_tunnel_q="SELECT CONCAT('{',GROUP_CONCAT('\"',g.gateway_name,'\":',g.tunnels),'}') AS a FROM exp_gateways g GROUP BY g.is_enable";

                $get_tunnels=$db->selectDB($get_tunnel_q);
                
                foreach ($get_tunnels['data'] AS $tunnels) {
                    $tunnelsa=$tunnels[a];
                }



                 } ?>

               
<div id="ap_switch_div">
<h3>AP/Switch Controllers <button onclick="openApForm()" class="btn btn-info inline-btn" type="button" data-toggle="modal" data-target="#wlanframe_ap">Edit</button></h3> 

<div style="display: none;" id="wlanframe_ap" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>AP/Switch Controller Config</b> </h4>
      </div>
      <form  method="post">
        <div class="modal-body">
            <div class="control-group">
                <div class="controls form-group">
                    <label for="ap_controller_url">Ap Controller URL:</label>
                    <select  name="ap_controller_url" id="ap_controller_url"  class="span4 form-control" >
                    <option value="">Select AP Controller</option>
                               <?php
                                            $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='AP'";

                                            $query_results=$db->selectDB($q1);
                                            
                                            foreach ($query_results['data'] AS $row) {

                                                //$mnoid=$row[mno_id];
                                                $apc=$row[ap_controller];

                                                $ap_controller = preg_replace('/\s+/', '', $apc);
                                                if($edit_distributor_ap_controller==$apc){
                                                    $controller_sel='selected';
                                                }else{
                                                    $controller_sel='';
                                                }

                                                echo "<option   ".$controller_sel."  class='".$ap_controller."' value='".$apc."'>".$apc."</option>";
                                            }
                                            ?>
                  </select>
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="ap_zone_template">Zone Template:</label>
                    <select  name="ap_zone_template" id="ap_zone_template"  class="span4 form-control" >
                    <option value="">Select Zone Template</option>
                  </select>
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="ap_zone_name">Zone Name:</label>
                    <input type="text" name="ap_zone_name" id="ap_zone_name" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="ap_controller_url">Switch Controller URL:</label>
                    <select  name="ap_controller_url" id="ap_controller_url"  class="span4 form-control" >
                    <option value="">Select SW Controller</option>
                               <?php
                                           $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='SW'";

                                            $query_results=$db->selectDB($q1);
                                            
                                            foreach ($query_results['data'] AS $row) {

                                                //$mnoid=$row[mno_id];
                                                $apc=$row[ap_controller];

                                                $ap_controller = preg_replace('/\s+/', '', $apc);
                                                if($edit_distributor_ap_controller==$apc){
                                                    $controller_sel='selected';
                                                }else{
                                                    $controller_sel='';
                                                }

                                                echo "<option   ".$controller_sel."  class='".$ap_controller."' value='".$apc."'>".$apc."</option>";
                                            }
                                            ?>
                            </select>
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="sw_group_template">Group Template:</label>
                    <select  name="sw_group_template" id="sw_group_template"  class="span4 form-control" >
                    <option value="">Select Group Template</option>
                  </select>
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="sw_group_name">Group Name:</label>
                    <input type="text" name="sw_group_name" id="sw_group_name" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="btn_change_ap">Change</button>
          <button type="button" onclick="closeApForm()" class="btn btn-info" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>

  </div>
</div>

                


<!--<div id="ap_switch_table" class="controls col-lg-5 form-group" style="margin-left: 0px; margin-top: 33px;">
                  <div class="widget widget-table action-table">
                    
                  <div class="widget-content ">
                      <div style="overflow-x:auto;">
                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                          <thead>
                            <th></th>
                            <th></th>
                          </thead>
                          <tbody id="">

                            <tr>
                              <td>AP</td>
                              <td>SW</td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                            </tr>                     

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>   
                </div>-->
<table style="border: 1px solid black;border-collapse: collapse;width: 100%">
    <tbody id="ap_details">
    <tr>
      <td>AP:</td>
      <td>SW:</td>
    </tr>
    <tr>
      <td>Zone Template:</td>
      <td>Group Template:</td>
    </tr>
    <tr>
      <td>Name:</td>
      <td>Name:</td>
    </tr> 
    </tbody>                  

</table>
<br>
</div>

<div id="vTenant_div" >
<h3>vTenant Network <button onclick="openVTForm()" class="btn btn-info inline-btn" type="button" data-toggle="modal" data-target="#wlanframe_vt">Edit</button></h3>

<div style="display: none;" id="wlanframe_vt" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>vTenant Network Setup</b></h4>
      </div>
      <form method="post">
        <div class="modal-body">
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_property_type">Property Type:</label>
                    <input type="radio" name="vt_property_type" id="vt_property_type" value="MDU" class="span4 form-control" >MDU
                    <input type="radio" name="vt_property_type" id="vt_property_type" value="VTENANT" checked="checked" class="span4 form-control" >VTENANT
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_acc_access">Account Creation by Resident:</label>
                    <input type="radio" name="vt_acc_access" id="vt_acc_access" value="yes" class="span4 form-control" > YES
                    <input type="radio" name="vt_acc_access" id="vt_acc_access" value="yes" class="span4 form-control" checked="checked"> NO
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_res_expire">Resident Account Expiration:</label>
                    <input type="radio" name="vt_res_expire" id="vt_res_expire" value="Fixed" class="span4 form-control" >Fixed
                    <input type="radio" name="vt_res_expire" id="vt_res_expire" value="Scheduled" class="span4 form-control" checked="checked">Scheduled
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_schdule_date">Scheduled Date:</label>
                    <input type="date" name="vt_schdule_date" id="vt_schdule_date" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_account_perge">Account Auto Perge:</label>
                    <input type="text" name="vt_account_perge" id="vt_account_perge" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_device_perge">Device Auto Perge:</label>
                    <input type="text" name="vt_device_perge" id="vt_device_perge" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_device_limit">Device Limited By Resident:</label>
                    <input type="text" name="vt_device_limit" id="vt_device_limit" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_portal_footer">Portal Footer:</label>
                    <input type="text" name="vt_portal_footer" id="vt_portal_footer" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="vt_onboarding_network">Onboarding Network VLAN:</label>
                    <input type="text" name="vt_onboarding_network" id="vt_onboarding_network" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <h3>Secure Network VLAN Ranges</h3>
                    <label for="vt_exis_range">Existing Ranges</label>
                    <input type="text" name="vt_exis_range" id="vt_exis_range" value="" placeholder="" class="span4 form-control" >
                    <label for="vt_new_range">New Ranges</label>
                    <input type="text" name="vt_new_range" id="vt_new_range" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="btn_vt_wlan">Change</button>
          <button type="button" onclick="closeVTForm()" class="btn btn-info" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>

  </div>
  
</div>
<div class="controls form-group">
    <label for="vt_nu_of_network">Select Number Of Network</label>

    <select required="" class="span4 form-control" id="vt_nu_of_network" name="vt_nu_of_network" >
    <option value="">Select Number Of Network</option>
                <option value="1"> 1 </option>;

    </select>
    </div>

<table style="border: 1px solid black;border-collapse: collapse;width: 100%">
    <tbody id="vt_details">
    <tr>
      <td>Property Type:</td>
      <td>Device Limit:</td>
    </tr>
    <tr>
      <td>Account Creation:</td>
      <td>Tiny Url:</td>
    </tr>
    <tr>
      <td>Account Expiration:</td>
      <td>Onboarding WIFI VLAN:</td>
    </tr> 
    <tr>
      <td>Account Purge:</td>
      <td>VLAN Start:</td>
    </tr>   
    </tbody>                 

</table>
<br>
</div>

<div id="guest_div" >
<h3>Guest Network <button onclick="openGuestForm()" class="btn btn-info inline-btn" type="button" data-toggle="modal" data-target="#wlanframe_guest">Edit</button></h3>

<div style="display: none;" id="wlanframe_guest" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Guest Network Config</b></h4>
      </div>
      <form method="post">
        <div class="modal-body">
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_dhcp_vlan">DHCP Pool VLAN:</label>
                    <input type="text" name="guest_dhcp_vlan" id="guest_dhcp_vlan" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_subnet">Subnet:</label>
                    <input type="text" name="guest_subnet" id="guest_subnet" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_subnet">Subnet Mask:</label>
                    <input type="text" name="guest_subnet" id="guest_subnet" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="create_l">
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_subnet_start">Subnet Strat:</label>
                    <input type="text" name="guest_subnet_start" id="guest_subnet_start" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_primary_dns">Primary DNS:</label>
                    <input type="text" name="guest_primary_dns" id="guest_primary_dns" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_primary_filter">Primary Filter DNS:</label>
                    <input type="text" name="guest_primary_filter" id="guest_primary_filter" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_lease_hour">Lease Time(hour):</label>
                    <input type="text" name="guest_lease_hour" id="guest_lease_hour" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
          </div>
          <div class="create_r">
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_subnet_end">Subnet End:</label>
                    <input type="text" name="guest_subnet_end" id="guest_subnet_end" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_secondary_dns">Secondary DNS:</label>
                    <input type="text" name="guest_secondary_dns" id="guest_secondary_dns" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_secondary_filter">Secondary Filter DNS:</label>
                    <input type="text" name="guest_secondary_filter" id="guest_secondary_filter" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_lease_min">Lease Time(min):</label>
                    <input type="text" name="guest_lease_min" id="guest_lease_min" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
          </div>

           <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_vlan_start">Vlan Start:</label>
                    <input type="text" name="guest_vlan_start" id="guest_vlan_start" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="btn_guest_config">Change</button>
          <button type="button" onclick="closeGuestForm()" class="btn btn-info" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</br>
</div>
<div class="controls form-group">
    <label for="g_nu_of_network">Select Number Of Network</label>

    <select required="" class="span4 form-control" id="g_nu_of_network" name="g_nu_of_network" >
    <option value="">Select Number Of Network</option>
                <option value="1"> 1 </option>;

                <option value="2"> 2 </option>;

                <option value="3"> 3 </option>;

    </select>
    </div>
<table style="border: 1px solid black;border-collapse: collapse;width: 100%">
  <tbody id="guest_details">
    <tr>
      <td>DHCP Pool VLAN:</td>
      <td>Primary DNS:</td>
    </tr>
    <tr>
      <td>Subnet:</td>
      <td>Secondary DNS:</td>
    </tr>
    <tr>
      <td>Subnet Mask:</td>
      <td>Primary Filter DNS:</td>
    </tr> 
    <tr>
      <td>Subnet Strat:</td>
      <td>Secondary Filter DNS:</td>
    </tr>
    <tr>
      <td>Subnet End:</td>
      <td>DHCP Lease Time:</td>
    </tr> 
    <tr>
      <td>Encryption:</td>
      <td>VLAN Start:</td>
    </tr>
    </tbody>                    

</table>
<br>
</div>
<div id="private_div" >
<h3>Private Network <button onclick="openPrivateForm()" class="btn btn-info inline-btn" type="button" data-toggle="modal" data-target="#wlanframe_private">Edit</button></h3>
<div style="display: none;" id="wlanframe_private" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Private Network Config</b></h4>
      </div>
      <form method="post">
        <div class="modal-body">
            <div class="control-group">
                <div class="controls form-group">
                    <label for="guest_dhcp_vlan">Encryption Type:</label>
                    <select class="span4 form-control" id="encryption_type" name="encryption_type" required="" data-bv-field="encryption_type">
                     <option value="WPA2/AES"> WPA2/AES</option>
                    </select>
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="pvt_vlan_start">Vlan Start:</label>
                    <input type="text" name="pvt_vlan_start" id="pvt_vlan_start" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="btn_pvt_config">Change</button>
          <button type="button" onclick="closePrivateForm()" class="btn btn-info" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="controls form-group">
    <label for="pr_nu_of_network">Select Number Of Network</label>

    <select required="" class="span4 form-control" id="pr_nu_of_network" name="pr_nu_of_network" >
    <option value="">Select Number Of Network</option>
                <option value="1"> 1 </option>;

                <option value="2"> 2 </option>;

                <option value="3"> 3 </option>;

    </select>
    </div>
<table style="border: 1px solid black;border-collapse: collapse;width: 100%">
<tbody id="pvt_details">
    <tr>
      <td>Encryption:</td>
      <td>VLAN Start:</td>
    </tr>  
</tbody>                   

</table>
<br>
</div>

</sup>
  </div>
</div>
    
  
             <div class="control-group" >
                <div style="text-align: center;" >
                <h3 >Match Table Parameters Guest Network</h3>
                <br>

                
                <div id="wlan_sync">
                <label >Wlan to Property Zone Mapping <font color="#FF0000"></font></sup> <a onclick="gotorelm_matchtabel();"
                 class="btn btn-primary qos-sync-button"
                 style="align: left;"><i
                    class="btn-icon-only icon-refresh"></i>
                Sync WLANs</a>
              <div style="display: inline-block"
                 id="re_mapp_loader"></div></label> </div>
              
               <script>
                $(document).ready(function() { 
                  document.getElementById("wlanframe").style.display = "none";
                });
                                    
                                
                                function automation_control(){
                                  
                                  var automation_control = document.getElementById("automation_property").checked;
                                  if (automation_control) {
                                    $('#zone_div').show();
                                    $('#group_div').show();
                                    $('#wlan_sync').show();
                                    $('#match_entry_tabel').show();
                                    $('#add_wlan').hide();
                                  }else{
                                    $('#zone_div').hide();
                                    $('#group_div').hide();
                                    $('#wlan_sync').hide();
                                    $('#match_entry_tabel').hide();
                                    $('#add_wlan').show();
                                  }
                                    
                                }


                                function openWlanForm() {
                                    document.getElementById("wlanframe").style.display = "block";
                                    document.getElementById("add_wlan").style.display = "none";
                                  }

                                  function closeWlanForm() {
                                    document.getElementById("wlanframe").style.display = "none";
                                    document.getElementById("add_wlan").style.display = "block";
                                  }

                                   function openApForm() {
                                    document.getElementById("wlanframe_ap").style.display = "block";
                                  }

                                  function closeApForm() {
                                    document.getElementById("wlanframe_ap").style.display = "none";
                                  }
                                   function openVTForm() {
                                    document.getElementById("wlanframe_vt").style.display = "block";
                                  }

                                  function closeVTForm() {
                                    document.getElementById("wlanframe_vt").style.display = "none";
                                  }
                                   function openGuestForm() {
                                    document.getElementById("wlanframe_guest").style.display = "block";
                                  }

                                  function closeGuestForm() {
                                    document.getElementById("wlanframe_guest").style.display = "none";
                                  }
                                   function openPrivateForm() {
                                    document.getElementById("wlanframe_private").style.display = "block";
                                  }

                                  function closePrivateForm() {
                                    document.getElementById("wlanframe_private").style.display = "none";
                                  }

                                </script>
              <div id="add_wlan" onclick="openWlanForm()" style="display: none;">
                <button class="btn btn-info inline-btn" type="button" data-toggle="modal" data-target="#wlanframe">Create Wlan</button>
              </div>

              <!--<iframe id="wlanframe" style="display: none;"></iframe>-->


                
              </div>
              <div id="match_entry_tabel" class="controls col-lg-5 form-group" style="margin-left: 0px; margin-top: 33px;">
                        <div class="widget widget-table action-table">
                          
                        <div class="widget-content ">
                            <div style="overflow-x:auto;">
                              <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                <thead>
                                  <tr>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Network Name</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">vlan</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Access Group</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Match Table Entry</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Edit</th>
                                  </tr>
                                </thead>
                                <tbody id="realm_mapp">

                                                            <?php
                                                            
                                                            if($edit_account=='1'){
                                                            $get_map_q = "SELECT * FROM `exp_network_realm` WHERE `realm` = '$edit_distributor_verification_number'  ORDER BY `wLan_name` ASC";
$get_map = $db->selectDB($get_map_q); }
//print_r($get_apGroup);
if($get_map['rowCount']>0)
{
    foreach ($get_map['data'] as $row)
    {
       echo $result = "<tr>
        <td>".$row['wLan_name']."</td>
        <td>".$row['vLan_id']."</td>
        <td>".$row['network_realm']."</td>
        <td>".$row['match_entry']."</td>
        <td>EDIT</td>
        </tr>";


    }}

                                                            
                                                            ?>


                                </tbody>
                              </table>
                            </div>
                                                    </div>
                                                </div>   
                        </div>
                        <!-- /controls -->


        </div>

         <script>
function gotorelm_matchtabel(){

var zone_id = document.getElementById("zone").value;
var icomme = document.getElementById("icomme").value;

var a = zone_id.length;
var b = icomme.length;

if(a==0 || b==0){

    alert('Please Select Zone and Customer Account Number');

}else{
        document.getElementById("re_mapp_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
    //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

    $.ajax({
        type: 'POST',
        url: 'ajax/get_wlan_matchtable.php',
        data: { wag_ap_name: "<?php echo $wag_ap_name; ?>", ap_control_var: "<?php echo $ap_control_var; ?>",ackey: scrt_var,mno:"<?php echo $user_distributor; ?>",mvno:"<?php echo $edit_distributor_code; ?>",zone_id:zone_id,icomme:icomme },
        success: function(data) {

           // alert(data); 
            $('#realm_mapp').empty();

            $("#realm_mapp").append(data);


            document.getElementById("re_mapp_loader").innerHTML = "";

        },
        error: function(){
            document.getElementById("re_mapp_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
        }

    });



}

}
                        </script>


            <div class="form-actions">

                <?php if($edit_account=='1')$btn_name='Update Location & Save';else $btn_name='Add Location & Save';

                    if($create_location_btn_action=='create_location_next' || $create_location_btn_action=='add_location_next'  || $_POST['p_update_button_action']=='add_location' || $edit_account=='1'){
                        echo '<button onmouseover="btn_action_change(\'add_location_submit\');" disabled type="submit" name="add_location_submit" id="add_location_submit" class="btn btn-primary">'.$btn_name.'</button><strong><font color="#FF0000"></font> </strong>';
                        $location_count = $db->getValueAsf("SELECT count(id) as f FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'");
                        if($location_count<1000  && !isset($_GET['edit_loc_id']) && !isset($_POST['p_update_button_action']) ){
                            echo '<button onmouseover="btn_action_change(\'add_location_next\');"  disabled type="submit" name="add_location_next" id="add_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';
                        }

                    }else{


                        echo '<button onmouseover="btn_action_change(\'create_location_submit\');"  disabled type="submit" name="create_location_submit" id="create_location_submit"
                class="btn btn-primary">Create Account & Save</button><strong><font color="#FF0000"></font> </strong>';

                        echo '<button onmouseover="btn_action_change(\'create_location_next\');" style="margin-top: 0px !important;" disabled type="submit" name="create_location_next" id="create_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';

                    }


                    if($edit_account=='1' || $_POST['p_update_button_action']=='add_location' || $_POST['btn_action']=='add_location_next'){?>
                    <a href="?token7=<?php echo $secret;?>&t=edit_parent&edit_parent_id=<?php echo $edit_parent_id  ;?>" style="text-decoration:none;margin-top: 0px !important;" class="btn btn-info inline-btn" >Cancel</a>
                <?php } ?>


                    <input type="hidden" name="edit_account" value="<?php echo $edit_account; ?>" />
                    <input type="hidden" name="edit_distributor_code" value="<?php echo $edit_distributor_code; ?>" />
                    <input type="hidden" name="edit_distributor_id" value="<?php echo $edit_loc_id; ?>" />
                    <input type="hidden" name="btn_action"  id = "btn_action" value="" />
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

            

<!-- /form-actions -->
</fieldset>
</form>

<script type="text/javascript">

function location_formfn() {

//document.getElementById("create_location_submit").disabled = false;

}

</script>


<?php if(isset($_GET['create_location_next']) || isset($_GET['add_location_next']) ) {

$props_q = "SELECT id,distributor_code,verification_number,property_id FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'";
$props_r = $db->selectDB($props_q);

?>
<div class="widget widget-table action-table">
<div class="widget-header">
<!-- <i class="icon-th-list"></i> -->
<h3>Account Locations</h3>

</div>

<!-- /widget-header -->

<div class="widget-content table_response">

<div style="overflow-x:auto">

<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
    <thead>
    <tr>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Business ID</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Customer Account#</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Property ID</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">APS</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Remove</th>

    </tr>

    </thead>
    <tbody>
    <?php

    foreach ($props_r['data'] AS $props_row) {
        $cus_ac_num = $props_row['verification_number'];
        $cus_prop_id =  $props_row['property_id'];
        $cus_id = $props_row['id'];
        $cus_code = $props_row['distributor_code'];

        echo '<tr>';
            echo '<td>';
                echo $edit_parent_id;
            echo '</td>';
            echo '<td>';
                echo $cus_ac_num;
            echo '</td>';
            echo '<td>';
                echo $cus_prop_id;
            echo '</td>';
            echo '<td>';
                echo 'view';
            echo '</td>';
            echo '<td>';
                echo 'edit';
            echo '</td>';
            echo '<td>';
                echo 'remove';
            echo '</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>
</div>
</div>
</div>

<?php } ?>
</div>


<!-- Modal -->
<div id="wlanframe" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Add WLAN</b></h4>
      </div>
      <form method="post">
        <div class="modal-body">
            <div class="control-group">
                <div class="controls form-group">
                    <label for="lookup_key">Lookup Key:</label>
                    <input type="text" name="lookup_key" id="lookup_key" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="location_id">Location ID:</label>
                    <input type="text" name="location_id" id="location_id" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="redirect_url">Redirect-URL:</label>
                    <input type="text" name="redirect_url" id="redirect_url" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="description">Description:</label>
                    <input type="text" name="description" id="description" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
            <div class="control-group">
                <div class="controls form-group">
                    <label for="cutom_para">Custom Parameter:</label>
                    <input type="text" name="cutom_para" id="cutom_para" value="" placeholder="" class="span4 form-control" >
                </div>
                <!-- /controls -->
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="btn_add_wlan">Add</button>
          <button type="button" onclick="closeWlanForm()" class="btn btn-info" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>

  </div>
</div>







<script>
        /*$(document).ready(function() {
            $('.tooltips').tooltipster({
              //content: $('#secure_tooltip_content'),
                //contentCloning: false
                contentAsHTML: true,
                maxWidth: 350
                
            });
          });*/
</script>

<style>
h3{
margin-bottom: 10px;
}
table {
  margin-top: 15px;
}
.row {
    margin-left: 0px;
}
.create_l{
  width: 49%;
  float: left;
}

.create_r{
  width: 49%;
  float: right;
}
.row:after {
    content: "";
    display: table;
    clear: both;
}
.form-horizontal .create_l .controls, .form-horizontal .create_r .controls {
    margin-left: 0px !important;
}


.tooltipster-fade-show, .tooltipster-default{
	border: 2px solid #fff !important;
	-webkit-box-shadow: 0 0 5px #aaa;
    box-shadow: 0 0 5px #aaa;
}
.tooltipster-arrow{
	display: none !important;
}
.tooltipster-default{
	background: #fff !important;
    color: #333 !important;
}
.tooltipster-content{
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif !important;
    font-size: 16px !important;
}
.toggle.btn.btn-xs{
	height: 20px !important;
}
.modal-backdrop, .modal-backdrop.fade.in {
    opacity: 0;
}
.modal-backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    background-color: #fff;
}

.modal.fade{
    position: absolute !important;
    right: 0% !important;
    bottom: 25% !important;
    top: unset !important;
    left: unset !important;
    width: 420px !important;
}

.modal-footer{
  text-align: left;
}
.modal-body input{
  width: -webkit-fill-available;
}
</style>