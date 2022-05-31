<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);*/
if ($user_type == 'MVNO') {
    $user_distributor_new = $db->getValueAsf("SELECT `parent_id` as f FROM exp_mno_distributor WHERE `distributor_code` = '$user_distributor'");
    
}else{
    $mno_time_zone = $db->getValueAsf("SELECT timezones AS f from exp_mno WHERE mno_id='$user_distributor'");
    $user_distributor_new = $user_distributor;
}

if (empty($mno_time_zone)) {
    $mno_time_zone = $db->getValueAsf("SELECT timezones AS f from exp_mno WHERE mno_id='$mno_id'");
    if (empty($mno_time_zone)) {
        $mno_time_zone = $user_timezone;
    }
}

if (isset($_POST['whitelist'])){

    $form_secret=$_POST['white_form_secret'];
    if($form_secret==$_POST['white_form_secret']){
        $do_whitelist_mac = $_POST['white_mac'];

        //clear mac
        $do_whitelist_mac = str_replace(':','',$do_whitelist_mac);
        $do_whitelist_mac = str_replace('-','',$do_whitelist_mac);
        $do_whitelist_mac = strtolower($do_whitelist_mac);



        $whitelist_mac_q = "DELETE FROM exp_customer_blacklist WHERE mac='$do_whitelist_mac' AND `mno` = '$user_distributor_new'";
        $whitelist_r=$db->execDB($whitelist_mac_q);

        if($whitelist_r===true){
            $_SESSION['msg8']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showNameMessage('whitelist_mac_success',$_POST['white_mac'])."</strong></div>";
        }else{
            $_SESSION['msg8']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>".$message_functions->showNameMessage('whitelist_mac_fail',$_POST['white_mac'],'2001')."</strong></div>";
        }


    }else{
        $_SESSION['msg8']="<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                            <strong>".$message_functions->showMessage('transection_fail')."</strong></div>";
    }
}

if (isset($_POST['csv_update_whitelist'])) {

            $configArr = array();
            $keyArr = array();
            $path = "import/api_config/";
            $name_whitelist = $_FILES['whitelist_mac_list']['name'];
            $size_whitelist = $_FILES['whitelist_mac_list']['size'];
            $tmp_whitelist = $_FILES['whitelist_mac_list']['tmp_name'];
            $maxSize = 1000;
            $whitelist_valid_formats = array("csv", "txt");
            $valid_formats = array("csv");
            $valid_value = 'yes';
            $valid_key = 'yes';

            if (strlen($name_whitelist)) {
                $status_code_whitelist = '200';

                $replace_arr_new = array("%", "@", "&", "}", "{", "#", "^");
                $name_whitelist = str_replace($replace_arr_new, '0', $name_whitelist);
                $parts = explode('.', $name_whitelist);
                $last = array_pop($parts);
                $parts = array(implode('.', $parts), $last);
                $txt = $parts[0];
                $ext = $parts[1];

                if (in_array($ext, $whitelist_valid_formats)) {
                    $whitelist_file = 'yes';
                    if ($size_whitelist < (1024 * $maxSize)) {

                        $csv_name_whitelist = "whitelist_mac_" . time() . "." . $ext;

                        if (move_uploaded_file($tmp_whitelist, $path . $csv_name_whitelist)) {

                            $row = 1;
                            if (($handle = fopen($path . $csv_name_whitelist, "r")) !== FALSE) {
                                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                    $num = count($data);
                                        $macarr = explode(',', $data[0]);

                                        $do_whitelist_mac = $macarr['0'];

                                        $do_whitelist_mac = str_replace(':','',$do_whitelist_mac);
                                        $do_whitelist_mac = str_replace('-','',$do_whitelist_mac);
                                        $do_whitelist_mac = strtolower($do_whitelist_mac);

                                        
                                        //calculate whitelist date
                                        if(strlen($do_whitelist_mac) >0){
                                        
                                        $whitelist_mac_q = "DELETE FROM exp_customer_blacklist WHERE mac='$do_whitelist_mac' AND `mno` = '$user_distributor_new'";
                                        
                                        $whitelist_r=$db->execDB($whitelist_mac_q);
                                    }else{
                                        $status_code_whitelist = '400';
                                        $response = 'Update has failed. Can`t read file.';
                                    }
                                    $row++;
                                }
                                fclose($handle);
                            }
                            

                        } else {
                            $status_code_whitelist = '400';
                            $response = 'Update has failed. Can`t write file.';
                        }
                    } else {
                        $status_code_whitelist = '400';
                        $response = 'Image file size max ' . $maxSize . ' KB.';
                    }
                } else {

                    $status_code_whitelist = '400';
                    $response = 'Invalid format. Acceptable formats: CSV.';
                }

            } else {
                $status_code_whitelist = '400';
                $response = 'Please select a file';
            }

           
            if ($status_code_whitelist == '200') {
                $show_msg = $message_functions->showMessage('api_network_profile_update_succe');
                $create_log->save('3009', $show_msg, "");
                $_SESSION['msg8'] = "<div class='alert alert-success'>
                                        <button type='button' class='close' data-dismiss='alert'>×</button>
                                        <strong>" . $show_msg . "</strong></div>";
            } else {

                $show_msg = $message_functions->showMessage('api_network_profile_update_faile');
                $create_log->save('3009', $show_msg, "");
                $_SESSION['msg8'] = "<div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert'>×</button>
                                        <strong>" . $response . "</strong></div>";

            }

    
}

 ?>
<?php  if(isset($_SESSION['msg8'])){
echo $_SESSION['msg8'];
unset($_SESSION['msg8']);

} ?>
<div <?php if(isset($tab_whitelist_mac)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="whitelist_mac">

<div >

</div>
<style type="text/css">
    @media (min-width: 1200px){
   
    .form-horizontal .controls {
        margin-left : 0px !important;
    }
    .icon-question-sign {
    	    background-position: -96px -96px;

	}
	.ui-tooltip {
        white-space: pre-line;
    }

</style>
<br>
									<h1 class="head" style="display: none;">Manage Whitelist</h1>
                                                      
                                               <form name="whitelist_formn" id="whitelist_formn" class="form-horizontal" method="post" action="?t=whitelist_mac">
                                                <div class="form-group">
                                                   <fieldset>


                                                        <div class="control-group">

                                                            <div class="controls col-lg-5 form-group">

                                                                <h3>Remove From Blacklist<!--Whitelisted Device--></h3>
                                                                
                                                            <div class="" for="radiobtns">MAC Address 
                                                            </div>

                                                                    <input maxlength="17" data-toggle="tooltip"  autocomplete="off" type="text" id="white_mac" name="white_mac" class="span4" title="The MAC Address can be added manually or you can paste in an address. The system will autoformat the MAC Address to either aa:bb:cc:dd:ee:ff or AA:BB:CC:DD:EE:FF.">

                                                                    <input type="hidden" name="white_form_secret" value="<?php echo $secret; ?>">

                                                                   <button disabled name="whitelist" id="whitelist" type="submit" class="btn btn-primary" style="text-decoration:none">
                                                                       <i class="btn-icon-only icon-download"></i> Enable Mac Address

                                                                   </button>
                                                                <small id="wl_mac_ext" class="help-block" style="display: none;"></small>

                                                                <script type="text/javascript">

                                                                $(document).ready(function() {
                                                                    
                                                                     $('#white_mac').tooltip();

                                                                });

                                                                    function vali_whitelist(rlm) {

                                                                        var val = rlm.value;
                                                                        var val = val.trim();



                                                                        if(val!="") {
                                                                            document.getElementById("wl_mac_ext").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                                            var formData = {blmac: val, user: "<?php echo $user_distributor_new; ?>"};
                                                                            $.ajax({
                                                                                url: "ajax/validateblacklist.php",
                                                                                type: "POST",
                                                                                data: formData,
                                                                                success: function (data) {
                                                                                   

                                                                                    if (data == '1') {
                                                                                        /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                                                        document.getElementById("wl_mac_ext").innerHTML ="";
                                                                                        $('#wl_mac_ext').hide();
                                                                                        

                                                                                    } else if (data == '2') {
                                                                                        //inline-block
                                                                                        
                                                                                        $('#wl_mac_ext').css('display', 'inline-block');
                                                                                        document.getElementById("wl_mac_ext").innerHTML = "<p>The MAC ["+val+"] you are trying to add is already disabled, please try a different MAC.</p>";
                                                                                        document.getElementById('white_mac').value = "";
                                                                                        /* $('#mno_account_name').removeAttr('value'); */
                                                                                        document.getElementById('white_mac').placeholder = "Please enter new MAC";
                                                                                    }
                                                                                },
                                                                                error: function (jqXHR, textStatus, errorThrown) {
                                                                                    //alert("error");
                                                                                    document.getElementById('white_mac').value = "";
                                                                                }
                                                                            });
                                                                        }
                                                                    }
                                                                    
                                                                    

                                                                </script>

                                                            </div>
                                                            
                                                             
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                       
                                                    </fieldset>
                                                    </div>
                                                </form>        

                                                <form name="upload_csvn" id="upload_csvn" class="form-horizontal" method="post" action="?t=whitelist_mac" enctype="multipart/form-data">
                                                <div class="form-group">

                                                   <fieldset>
                                                    <?php

                                                    echo '<input type="hidden" name="update_csv_secret2" id="update_api_secret2" value="' . $_SESSION['FORM_SECRET'] . '" />';

                                                    ?>
                                                    <div class="control-group">
                                                    <div class="controls col-lg-5 form-group">
                                                   
                                                                <br>
                                                    <h3>Remove From Blacklist</h3>
                                                    </div>
                                                    </div>
                                                    

                                                    <div class="control-group">

                                                        <div class="controls form-group">
                                                            <label class="" for="radiobtns">Add Mac List</label>
                                                            <div class="">

                                                                <input type="file" class="span4 form-control"
                                                                       name="whitelist_mac_list" id="whitelist_mac_list">
                                                                
                                                                <img  data-placement="top" id="tooltip1" data-toggle="tooltip"
                                                                title="You can blacklist or whitelist multiple devices by downloading and using our CSV template.

                                                                To blacklist a device add the MAC Address and specify the time_range.

                                                                To whitelist a blacklisted device only add the MAC Address and leave the time_range empty.

                                                                Valid Time Range Formats are: 24 Hours, 48 Hours, 7 Days,14 Days, 21 Days, 180 Days, Indefinite." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">
                                                                <button disabled type="submit" name="csv_update_whitelist" id="csv_update_whitelist"

                                                                class="btn btn-primary">Enable Mac Address List
                                                                </button>

                                                                <a href='export/csv/whitelist.csv' class="btn btn-primary" >
                                                        <i class="btn btn-primary icon-download"></i> Download Template
                                                    </a>

                                                            </div>

                                                        </div>

                                                    </div>

                                                        <!-- /control-group -->


                                                    </fieldset>
                                                    </div>
                                                </form>

                                                
                                                <style type="text/css">
                                                
                                                .nav-tabs>li:last-child>a{
                                                                border-right: none !important;
                                                            }
                                                    input[name="whitelist_mac_list"]::before {
                                                        width: 250px;
                                                        height: 30px;
                                                        color: #fff;
                                                        content: 'Select CSV file';
                                                        background-color: #45bea7 !important;
                                                        box-shadow: none !important;
                                                        text-shadow: none !important;
                                                        border-radius: 8px !important;
                                                        padding: 4px 15px;
                                                        min-width: 70px !important;
                                                        cursor: pointer;
                                                        font-size: 14px;
                                                        line-height: 22px;
                                                        font-family: 'Open Sans';
                                                    }

                                                    input[name="whitelist_mac_list"] {
                                                        color: transparent;
                                                        outline: 0 !important;
                                                        top: 0px;
                                                        right: 0px;
                                                        width: 120px !important;
                                                    }


                                                    input[name="whitelist_mac_list"]:hover:before{
                                                        background-color: #369a87!important;
                                                    }

                                                </style>

                                                </div>
<script type="text/javascript" src="js/formValidation.js"></script>
 <script type="text/javascript" src="js/bootstrap_form.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
     $('#upload_csvn').formValidation({
            framework: 'bootstrap',
            fields: {
                whitelist_mac_list: {
                    excluded: false,
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        });
     $('#whitelist_formn').formValidation({
            framework: 'bootstrap',
            fields: {

                white_mac: {
                    validators: {
                        <?php echo $db->validateField('mac'); ?>
                       
                    }
                }
                
            }
        });
   
 });

 $(document).ready(function() {
            $("#whitelist").easyconfirm({locale: {
                title: 'WHitelist MAC',
                text: 'Are you sure you want to enable Wi-Fi access for this MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                button: ['Cancel',' Confirm'],
                closeText: 'close'
            }});
            $("#whitelist").click(function() {

            });
        });
</script>

