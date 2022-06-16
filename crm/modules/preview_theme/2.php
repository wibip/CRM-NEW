<!-- ******************* Preview ********************* --> 
<!-- Att -->

<div class="tab-pane <?php if($active_tab == 'preview') echo 'active'; ?>" id="preview_theme">



<?php

if(isset($_SESSION['msg_up'])){

    echo $_SESSION['msg_up'];

    unset($_SESSION['msg_up']);





}?>

                                                  <h1 class="head">
First impressions last,
make yours a splash page. <img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable captive portal upon connection to your Guest <?php echo __WIFI_TEXT__; ?> network. Create multiple portal themes for your location and easily enable/disable stored portal themes from the “Manage” tab.' src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>



<div class="widget widget-table action-table">







    <form id="tag_form" class="form-horizontal">

        <fieldset>



            <div class="control-group">

                



                <div class="controls">

                    <!-- <label class="control-label" for="radiobtns">Theme</label> -->

                    <h3 style="display: inline-block;">Theme</h3>

                    <div class="input-prepend input-append">

                        <select name="theme_id" class="span5" id="theme_id" onchange="loadap1();">

                        <option value="-1">Select Theme</option>

                        <?php

                        $key_query = "SELECT theme_id,theme_name FROM exp_themes WHERE distributor = '$user_distributor'";



                        $query_results=$db->selectDB($key_query);

                        
                        foreach ($query_results['data'] AS $row) {

                            $theme_id = $row[theme_id];

                            $theme_name = $row[theme_name];



                            echo '<option value="'.$theme_id.'">'.$theme_name.'</option>';

                        }

                        ?>

                        </select>

                        <div id="error_msg" style="display: none;" class="error-wrapper bubble-pointer mbubble-pointer"><p>Please select a theme.</p></div>

                    </div>

                </div>

                <!-- /controls -->

            </div>

            <!-- /control-group -->





            <div class="control-group" id="type_div">

            



                <div class="controls">

                    <h3 style="display: inline-block;">Type</h3>

                    <div class="input-prepend input-append">

                        <select name="theme_type" class="span5" id="theme_type" required>

                        <option value="new">New User</option>

                        <option value="return">Return User</option>



                        </select>

                    </div>

                </div>

                <!-- /controls -->

            </div>

            <!-- /control-group -->




            <?php if($package_functions->getSectionType("THEME_PRIVIEW_SSID",$system_package,$user_type)=="multy" || $package_features=="all"){ ?>
            <div class="control-group">
                <label class="control-label" for="radiobtns">SSID / AP</label>
                <div class="controls">
                    <div class="input-prepend input-append" id="aps_list">
                        <select name="theme_ssid" id="theme_ssid" required>
                        <option value="-1">Select SSID and AP</option>
                        <?php

                         $key_query = "SELECT concat(location_ssid,'|',ap_id) as id, CONCAT(location_ssid,' - ',ap_id) AS detail
                        FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor'";

                        $query_results=$db->selectDB($key_query);

                        
                        foreach ($query_results['data'] AS $row) {

                            $id = $row[id];

                            $detail = $row[detail];

                            echo '<option value="'.$id.'">'.$detail.'</option>';
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <!-- /controls -->
            </div>
            <!-- /control-group -->
            <?php } ?>


            <?php if($package_functions->getSectionType("THEME_PRIVIEW_SSID",$system_package,$user_type)=="single"){ ?>

                    <div class="input-prepend input-append" id="aps_list">
                        <input type="hidden"  name="theme_ssid" id="theme_ssid" required  value="<?php

                         $key_query = "SELECT concat(location_ssid,'|',ap_id) as id, CONCAT(location_ssid,' - ',ap_id) AS detail
                        FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor' LIMIT 1";

                        $query_results=$db->selectDB($key_query);

                        
                        foreach ($query_results['data'] AS $row) {

                            $id = $row[id];

                            $detail = $row[detail];

                            echo urlencode($id);
                        }
                        ?>" >
                    </div>
                <!-- /controls -->

            <!-- /control-group -->
            <?php } ?>










            <div class="form-actions" >

                <button disabled="disabled" id="preview_btn" type="button" name="submit" onclick="preview();"

                    class="btn btn-primary inline-btn" data-toggle="tooltip" title="The PREVIEW button will allow you to visualize the mobile view of the captive portal.">
                    Preview
                    </button>



                <button disabled="disabled" type="button" name="submit" id="gen_url" onclick="url_creation();"

                    class="btn btn-danger" data-toggle="tooltip" title="The GENERATE URL button creates a URL that can be shared electronically and will allow the recipient to test the captive portal layout natively on any device or browser.">
                    Generate URL</button>


                     <script>

                                                                                                                                        $(document).ready(function() {
                                                                                                                                                function checkthemeselect(){
                                                                                                                                                        var a =$('#theme_id').val();
                                                                                                                                                        if(a==-1){

                                                                                                                                                                $('#preview_btn').prop('disabled', true);
                                                                                                                                                                $('#gen_url').prop('disabled', true);
                                                                                                                                                        }else{

                                                                                                                                                                $('#preview_btn').prop('disabled', false);
                                                                                                                                                                $('#gen_url').prop('disabled', false);
                                                                                                                                                        }
                                                                                                                                                    }

                                                                                                                                                    checkthemeselect();

                                                                                                                                               $( "#theme_id" ).on('change',function() {
                                                                                                                                                                      checkthemeselect();
                                                                                                                                                                    });
                                                                                                                                        });

                                                                                                                                </script>



         <div id="new_div" class="inline-btn" style=""></div>



            <img  id="tag_loader" src="img/loading_ajax.gif" style="visibility: hidden;">





            </div>

            <!-- /form-actions -->

        </fieldset>

    </form>



    <?php



        /* Generate DEMO URL */



        /* function strToHex($string)

        {

            $hex='';

            for ($i=0; $i < strlen($string); $i++)

            {

            $hex .= dechex(ord($string[$i]));

            }

            return $hex;

        }



        $key_query = "SELECT location_ssid,ap_id,group_tag FROM exp_locations_ap_ssid WHERE distributor = '$user_distributor' LIMIT 1";



        $query_results=mysql_query($key_query);

        while($row=mysql_fetch_array($query_results)){

            $ssid = $row[location_ssid];

            $ap_id = $row[ap_id];

            $group_tag = $row[group_tag];



        }	 */



        /*

        $mac = "DEMO_MAC";

        $ascii = "WLAN:wlandemo:30:".$ssid.":zf7762:".$ap_id.":DEMO_MAC";

        $network_key = "network-demo";

        echo $hex_option_82 = strToHex($ascii); */



        ///network name////

        $network_name = trim($db->setVal('network_name','ADMIN'),"/");



        //get parameters//

        $row3=$db->select1DB("SELECT p.`redirect_method`,p.`mac_parameter`,p.`ap_parameter`,p.`ssid_parameter`,p.`loc_string_parameter`,p.`network_ses_parameter` ,p.`ip_parameter`

        FROM `exp_network_profile` p WHERE p.`network_profile`='$network_name' LIMIT 1");



        //$row3=mysql_fetch_array($get_parametrs);



        $redirect_method=$row3['redirect_method'];

        $mac_parameter=$row3['mac_parameter'];

        $ap_parameter=$row3['ap_parameter'];

        $ssid_parameter=$row3['ssid_parameter'];

        $loc_string_parameter=$row3['loc_string_parameter'];

        $network_ses_parameter=$row3['network_ses_parameter'];

        $ip_parameter=$row3['ip_parameter'];


        /*Page URL */
        //$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

        function siteURL()
        {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName = $_SERVER['HTTP_HOST'].'/';
            return $protocol;
        }
        define( 'SITE_URL', siteURL() );

    /*
        if( isset($_SERVER['HTTPS'] ) ) {

            $pageURL = "https://";;
        }else{

            $pageURL = "http://";;
        }*/
$SSL_ON=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='SSL_ON' LIMIT 1");

   // $pageURL = "https://";


   // if( !isset($_SERVER['HTTPS'] ) ) {

        //$pageURL = "http://";;
   // }

    //$pageURL = SITE_URL;

//echo $SSL_ON;

if($SSL_ON!='1'){

    $pageURL = "http://";

}else{

    $pageURL = "https://";


}


        if ($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        }
        else
        {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        /* */


        $base_folder_path_preview = $db->setVal('portal_base_folder', 'ADMIN');

    ?>









    <script type="text/javascript">



        function url_creation(){

            var theme_id=document.getElementById("theme_id").value;

            var theme_type=document.getElementById("theme_type").value;

            var theme_ssid=document.getElementById("theme_ssid").value;

            var ap_ssid = theme_ssid.split('|');



            var mac = "DEMO_MAC";

            var ascii = "WLAN:wlandemo:30:"+ap_ssid[0]+":zf7762:"+ap_ssid[1]+":DEMO_MAC";

            var network_key = "network-demo";

            var hex_option_82 = toHex(ascii);





            var redirect_method="<?php echo $redirect_method; ?>";

            var mac_parameter="<?php echo $mac_parameter; ?>";

            var ap_parameter="<?php echo $ap_parameter; ?>";

            var ssid_parameter="<?php echo $ssid_parameter; ?>";

            var loc_string_parameter="<?php echo $loc_string_parameter; ?>";

            var network_ses_parameter="<?php echo $network_ses_parameter; ?>";

            var ip_parameter="<?php echo $ip_parameter; ?>";







            if(theme_type=='new'){



                if(redirect_method=='OPTION82_STRING'){

                    loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



                }else if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



                    loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

                }

                else{



                    loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

                }


                var url_base = '<?php echo $pageURL; ?>';
                var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);
                //var myDir2 = myDir.substring( 0, myDir.lastIndexOf( "/" ) + 1);
                //alert(myDir);

                    loc = myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;



            }

        else if(theme_type=='return'){





            if(redirect_method=='OPTION82_STRING'){

                    loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



                }else if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



                    loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

                }

                else{



                    loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

                }


            var url_base = '<?php echo $pageURL; ?>';
            var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

                    loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;





            }


            loc=loc+"&<?php echo $rederect_prm_1=$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile");?>=<?php echo $db->getValueAsf("SELECT `verification_number` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");?>";




            if(theme_id != -1){

                document.getElementById('preview_url').innerHTML = 'You can copy and paste the below URL in an email, messenger etc., to allow anyone anywhere to test the end-to-end experience on a device of their choice. <br><textarea readonly id="genUrlTextArea" rows="3" style="margin: 0px 0px 9px; width: 95%; height: 79px;">'+loc+'</textarea><br><br>';

                document.getElementById('new_div').innerHTML = '<a href="'+loc+'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="The OPEN URL IN A NEW TAB button will allow you to launch the captive portal natively on the device and browser you are currently using.">Open URL in new tab</a>';

                var copyText = document.getElementById("genUrlTextArea");
                copyText.select();
                document.execCommand("Copy");


                $("#error_msg").hide();
                eval(document.getElementById('tootip_script').innerHTML);


            }

            else{

                /*document.getElementById('new_div').innerHTML = '<font size="small" color="brown"> Please select a theme.</font>';*/
                document.getElementById("error_msg").style = "display: inline-block";



            }

        }























        function preview(){







            var theme_id=document.getElementById("theme_id").value;

            var theme_type=document.getElementById("theme_type").value;

            var theme_ssid=document.getElementById("theme_ssid").value;

            var ap_ssid = theme_ssid.split('|');

            try {

                $('iframe').contents().find('#loading_img').show();
            
            } catch (error) {
                
            }
            


            var mac = "DEMO_MAC";

            var ascii = "WLAN:wlandemo:30:"+ap_ssid[0]+":zf7762:"+ap_ssid[1]+":DEMO_MAC";

            var network_key = "network-demo";

            var hex_option_82 = toHex(ascii);





            var redirect_method="<?php echo $redirect_method; ?>";

            var mac_parameter="<?php echo $mac_parameter; ?>";

            var ap_parameter="<?php echo $ap_parameter; ?>";

            var ssid_parameter="<?php echo $ssid_parameter; ?>";

            var loc_string_parameter="<?php echo $loc_string_parameter; ?>";

            var network_ses_parameter="<?php echo $network_ses_parameter; ?>";

            var ip_parameter="<?php echo $ip_parameter; ?>";





            if(theme_type=='new'){



                if(redirect_method=='OPTION82_STRING'){

                    loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



                }else  if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



                    loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

                }

                else{



                    loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

                }


                var url_base = '<?php echo $pageURL; ?>';
                var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

                    loc =myDir+"<?php echo $base_folder_path_preview; ?>/checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;



            }

        else if(theme_type=='return'){





            if(redirect_method=='OPTION82_STRING'){

                    loc =mac_parameter+"="+mac+"&"+network_ses_parameter+"="+network_key+"&"+ip_parameter+"=10.1.1.45&"+loc_string_parameter+"="+hex_option_82;



                }else  if(redirect_method=='AP_SSID' || redirect_method=='AP_SSID_NEW_RETURN' || redirect_method=='API'){



                    loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

                }

                else{



                    loc = mac_parameter+"="+mac+"&"+ap_parameter+"="+ap_ssid[1]+"&"+ssid_parameter+"="+ap_ssid[0]+"&"+ip_parameter+"=10.1.1.45";

                }


            var url_base = '<?php echo $pageURL; ?>';
            var myDir = url_base.substring( 0, url_base.lastIndexOf( "/" ) + 1);

                    loc =myDir+"<?php echo $base_folder_path_preview; ?>/ex_checkpoint<?php echo $extension; ?>?"+loc+"&theme="+theme_id;





            }

loc=loc+"&<?php echo $rederect_prm_1=$db->getValueAsf("SELECT n.group_parameter AS f  FROM exp_network_profile n , exp_settings s WHERE s.settings_value = n.network_profile");?>=<?php echo $db->getValueAsf("SELECT `group_number` AS f FROM `exp_distributor_groups` WHERE `distributor`='$user_distributor' LIMIT 1");?>";







            //	alert(loc);

            if(theme_id != -1){

                document.getElementById('preview1').src = loc;

                document.getElementById('preview2').src = loc;

                document.getElementById('preview3').src = loc;

                try {
                    document.getElementById('preview4').src = loc;
                }
                catch(err) {
                    //document.getElementById("demo").innerHTML = err.message;
                }


                document.getElementById('new_div').innerHTML = '<a href="'+loc+'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="The OPEN URL IN A NEW TAB button will allow you to launch the captive portal natively on the device and browser you are currently using.">Open URL in new tab</a>';

                $("#error_msg").hide();
                eval(document.getElementById('tootip_script').innerHTML);

            }

            else{

                /*document.getElementById('new_div').innerHTML = '<font size="small" color="brown"> Please select a theme.</font>';*/

                document.getElementById("error_msg").style = "display: inline-block";

            }

        }







        function toHex(str) {

            var hex = '';

            for(var i=0;i<str.length;i++) {

                hex += ''+str.charCodeAt(i).toString(16);

            }

            return hex;

        }

    </script>







    <div id="preview_url"></div>



    <center>

        <div id="devices">




        <div style="overflow-x: auto" class="table_response">
            <div class="device-node" align="center" style="margin-left:320px;">

            <h4>Phone - 240 x 320</h4>

            <div style="width:240px; height:320px; overflow:hidden"><iframe name="preview1" id="preview1" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="240" height="320"></iframe></div>

            </div>
        </div>




        <div style="overflow-x: auto" class="table_response">
            <div class="device-node" style="margin-left:280px;">

            <h4>iPhone - 320 x 480</h4>

            <div style="width:320px; height:480px; overflow:hidden"><iframe scrolling="yes" name="preview2" id="preview2" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="320" height="480"></iframe></div>

            </div>
        </div>






        <div style="overflow-x: auto" class="table_response">
            <div class="device-node" style="margin-left:200px;">

            <h4>Tablet - 480 x 640</h4>

            <div  style="width:480px; height:640px;overflow:hidden"><iframe scrolling="yes" name="preview3" id="preview3" src="ajax/waiting.php?layout=<?php echo $camp_layout; ?>" width="480" height="640"></iframe></div>

            </div>
        </div>




<!-- <center>

            <div class="device-node" style="margin-left:80px;">

            <h4>iPad - 768 x 1024</h4>

            <div style="width:768px; height:1024px; overflow:hidden"><iframe name="preview4" id="preview4" src="ajax/waiting.php" width="768" height="1024"></iframe></div>

            </div>

            </center> -->




        </div>

    </center>

    <script>


    </script>



    <!-- /widget-content -->

</div>

<!-- /widget -->



</div>