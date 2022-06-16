
<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />

<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />

<style type="text/css">

@media (max-width: 480px){
    #feild_gp_taddg_divt1 .form-group .net_div{
        width: 100%;
    }

    #feild_gp_taddg_divt1 .net_div .net_div_child:nth-child(1){
            width: 50%;
    margin-bottom: 10px;
    }

}

label img{
        margin-left: 10px;
}

</style>


 <?php
                                        /**
                                         * 3/25/2016 9:30:01 AM
                                         * alert if sync now success or failed
                                         */


                                       if(isset($_SESSION['tab7'])){
                                            echo$_SESSION['tab7'];
                                            unset($_SESSION['tab7']);
                                        }

                                        if(isset($_SESSION['tab75'])){
                                            echo$_SESSION['tab75'];
                                            unset($_SESSION['tab75']);
                                        }


                                         if(isset($_SESSION['tab2'])){
                                             echo $_SESSION['tab2'];
                                             unset($_SESSION['tab2']);
                                                }

                                            if(isset($_SESSION['tab9'])){
                                                echo$_SESSION['tab9'];
                                                unset($_SESSION['tab9']);
                                            }

                                            ?>


                                        <?php if(in_array("NET_PRODUCT",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($subtab75)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="tab_product">
                                            <!-- Tab 3 start-->




                                            <p>

                                                  <?php

/*
                                           $sup_data = $db->getSupportProfile($distributor_mno, $user_distributor);



                                          $sup_available=$sup_data[0][0];
                                           $sup_text=$sup_data[0][1];
                                           $sup_mobile=$sup_data[0][2]; */


                                                 $sup_mobile = $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package);


                                            ?>



                                                       <?php if($package_functions->getMessageOptions('IS_SUPPORT',$system_package)=='YES'){?>



                                                <?php }?>

                                            </p>



                                            <?php
                                            if($package_functions->getSectionType('CONTENT_FILTER_CHANGE',$system_package)=="YES" || $package_features=="all") {

                                                ?>
                                                    <form id="tab2_form1" name="tab2_form1" method="post"
                                                      class="form-horizontal">

                                                    <fieldset>

                                                        <input <?php

                                                        if ($content_filter == '1') echo "  checked   " ?>
                                                            onchange="contentFilter()" id="content_filter_check"
                                                            name="content_filter_check" type="checkbox"
                                                            data-toggle="toggle" data-on="On" data-off="Off"
                                                            data-width="30">
                                                        <script>
                                                            function contentFilter() {
                                                                var value = $('#content_filter_check:checked').val();
                                                                /*alert(value);*/
                                                                if (value == 'on') {
                                                                    window.location = '?content_filter=1&t=75&secret=<?php echo $secret; ?>';
                                                                } else {
                                                                    window.location = '?content_filter=0&t=75&secret=<?php echo $secret; ?>';
                                                                }
                                                            }
                                                        </script>
                                                    </fieldset>
                                                </form>
                                                <?php
                                            }
                                            ?>


                                             <div class="widget widget-table action-table">
                                                        <!--<div class="widget-header">
                                                             <i class="icon-th-list"></i>
                                                            <h3>Active Profiles</h3>
                                                        </div>-->
                                                        <h2 style="" id="GUEST_online">Bandwidth Profiles</h2>
                                                        <p>Your guests want great <?php echo __WIFI_TEXT__; ?> access with great Customer Service.</p>
                                                        <br/>
                                                        <p>You have the ability to manage the bandwidth allocation and active session duration per device. Use the chart below to review your current Guest Access Profile.


                                                If you'd like to increase or decrease the amount of bandwidth your guests can use, please contact us at customer care. </p>


                                                        <br>
                                                        <div class="widget-content table_response" id="product_tbl" style="margin-top: 20px">



                                                            <div style="overflow-x:auto;" >
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Active Product</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Product Update</th>
                                                               <!--  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">UL</th> -->

                                                            <?php if(getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                                            ?>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Active on</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Edit</th>
                                                            <?php } ?>

                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                            <?php
                                                                $dist_guest_prof_q="SELECT d.id,d.`product_name`,p.`QOS`,p.`QOS_up_link`,d.`time_gap` , d.`active_on`, d.`duration_prof_code`
                                                                                    FROM `exp_products_distributor` d ,`exp_products` p
                                                                                    WHERE d.`product_code`=p.`product_code` AND`distributor_code`='$user_distributor'
                                                                                    AND p.`mno_id`='$distributor_mno' AND d.`network_type`='GUEST' AND p.`network_type`='GUEST'
                                                                                    GROUP BY d.id";
                                                                $dist_guest_prof_res=mysql_query($dist_guest_prof_q);
                                                            while($dist_guest_prof=mysql_fetch_assoc($dist_guest_prof_res)){
                                                                $prof_id=$dist_guest_prof['id'];
                                                                echo "<tr><td>".$dist_guest_prof['product_name']."</td>";
                                                               // echo "<td>".$dist_guest_prof['QOS']." Mbps</td>";
                                                                //echo "<td>".$dist_guest_prof['QOS_up_link']." Mbps</td>";

                                                                echo "<td><form style='margin-bottom:0px !important;' action='?t=75' method='post'>
                                                                <select style='margin-bottom:0px !important;' name='qos_value' class='span3'>";

                                                                $qos_query ="SELECT `product_id`,`product_name` FROM `exp_products` WHERE `mno_id`='$distributor_mno' ";

                                                                $qos_query_ex =mysql_query($qos_query);

                                                                while($qos_query_result=mysql_fetch_assoc($qos_query_ex)){

                                                                    if($dist_guest_prof['product_name']==$qos_query_result['product_name']){

                                                                        $sel_0='selected';
                                                                    }else{

                                                                        $sel_0='';
                                                                    }

                                                            echo "<option ".$sel_0." value='".$qos_query_result['product_id']."'>".$qos_query_result['product_name']."</option>";

                                                                }



                                                        echo "</select>
                                                                ";

                                                echo '<input type="hidden" name="qos_id" value="'.$prof_id.'">';

                                                echo "<button style='margin-left: 5px; margin-top: 5px;float: right;'
                                                    type='submit' name='qos_change' id='qos_change' class='btn btn-small btn-primary'>Update</button></td>";


                                                        echo'</form> </td>';





                                                             if(getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                                                echo "<td>";
                                                                if($dist_guest_prof['active_on'] == 'all'){
                                                                    echo 'All Week';
                                                                }
                                                                else{
                                                                    echo $dist_guest_prof['active_on'];
                                                                }

                                                                echo "</td>";

                                                                echo  '<td><a href="javascript:void();" id="PROF_' . $prof_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>&nbsp;
                                                                        <img id="ap_loader_' . $prof_id . '" src="img/loading_ajax.gif" style="visibility: hidden;">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#PROF_' . $prof_id . '\').easyconfirm({locale: {
                                                                                title: \'Product Remove [' . $dist_guest_prof['product_name'] . ']\',
                                                                                text: \'Are you sure you want to remove this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#PROF_' . $prof_id . '\').click(function() {
                                                                                window.location = "?prof_rm_token=' . $_SESSION['FORM_SECRET'] . '&t=2&remove_prof_id=' . $prof_id . '"
                                                                            });
                                                                            });
                                                                        </script>
                                                                        <a href="javascript:void();" id="PROF_ED_' . $prof_id . '"  class="btn btn-small btn-info">
                                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a>&nbsp;
                                                                        <img id="ap_loader_' . $prof_id . '" src="img/loading_ajax.gif" style="visibility: hidden;">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#PROF_ED_' . $prof_id . '\').easyconfirm({locale: {
                                                                                title: \'Product Edit [' . $dist_guest_prof['product_name'] . ']\',
                                                                                text: \'Are you sure you want to edit this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#PROF_ED_' . $prof_id . '\').click(function() {
                                                                                window.location = "?prof_ed_token=' . $_SESSION['FORM_SECRET'] . '&t=5&edit_prof_id=' . $prof_id . '"
                                                                            });
                                                                            });
                                                                        </script>

                                                                        </td>'; }
                                                                echo'</tr></form>';
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>

                                                                </div>
                                                    </div>
                                                </div>

                                            <!-- Tab 3 End-->
                                        </div>
                                    <?php }  ?>


                                        <?php if(in_array("NET_GUEST_PASSCODE",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($subtab9)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guestnet_tab_9">

                                            <?php if ($tooltip_enable=='Yes') { ?> 

                                              <h2>Setting Passcodes <img data-toggle="tooltip" title="<?php echo $tooltip_arr['Passcode']; ?>" src="layout/FRONTIER/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" ></h2>
                                              <!-- <p><b><i>&nbsp;&nbsp;&nbsp;&nbsp;So your guests can easily identify and connect</i></b></p> -->
                                        <?php } else{ ?> 
                                            <h2>Setting Passcodes</h2>
                                            <?php }?> 


                                            
                                            <p>
                                               If you would like to restrict access to your Guest <?php echo __WIFI_TEXT__; ?> Network, you can set a passcode.<br/><br/>
                                            </p>
                                           
                                            <?php
                                            if ($ori_user_type!='SALES') {

                                            $manual_status=$db->getValueAsf("SELECT `voucher_status` AS f FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`='Manual'");
                                            $auto_status=$db->getValueAsf("SELECT `voucher_status` AS f FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`='Auto'");
                                        }
                                        else{
                                            $manual_status=$_SESSION['manual_status'];
                                            $auto_status=$_SESSION['auto_status'];
                                        }

                                            ?>

                                            <b><c style="font-size:24px;">Location</c></b>&nbsp;&nbsp;&nbsp;
                                            <!-- ////////////// -->



                                            <select name="location">
                                                <?php
                                                $key_query1 = "SELECT DISTINCT id,tag_name FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor' ORDER BY tag_name ASC";

                                                $query_results1=mysql_query($key_query1);

                                                while ($tag = mysql_fetch_assoc($query_results1)){
                                                ?>
                                                <option value="<?php echo$tag['id']; ?>"><?php echo$tag['tag_name']; ?></option>
                                                <?php } ?>
                                            </select>


                                            <br>
                                            <br>



                                            <b><c style="font-size:24px;">Manual Passcode Option</c></b>&nbsp;&nbsp;&nbsp;
                                            <!-- ////////////// -->



                                             <div class="toggle1">

                                             <input class="hide_checkbox" <?php if($manual_status=='1') echo "  checked   "?>  id="manual_passcode" type="checkbox">

                                             <?php if($manual_status=='1'){ ?>

                                             <span class="toggle1-on">ON</span>
                                             <a id="manual_passcode_link"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>

                                             <?php }else{ ?>
                                                <a id="manual_passcode_link"><span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                                             <span class="toggle1-off">OFF</span>

                                             <?php } ?>

                                            </div>


                                             <br>
                                             <br>

                                            <script>
                                                function changePasscodeM(value) {
                                                    if(value=='on'){
                                                        window.location ='?change_passcode=true&t=9&manual_passcode=1&secret=<?php echo $secret; ?>';
                                                    }else{
                                                        window.location ='?change_passcode=true&t=9&manual_passcode=0&secret=<?php echo $secret; ?>';
                                                    }
                                                }



                                            </script>

                                            <?php if($manual_status=='1'){ ?>
                                            <script type="text/javascript">

                                            $(document).ready(function() {
                                                $('#manual_passcode_link').easyconfirm({locale: {
                                                    title: 'Manual Passcode',
                                                    text: 'Are you sure you want to disable the Manual Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#manual_passcode_link').click(function() {
                                                    changePasscodeM("off");
                                                });
                                            });
                                            </script>
                                            <?php }else{ ?>

                                            <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('#manual_passcode_link').easyconfirm({locale: {
                                                    title: 'Manual Passcode',
                                                    text: 'Are you sure you want to enable the Manual Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#manual_passcode_link').click(function() {
                                                    changePasscodeM("on");
                                                });
                                            });
                                            </script>

                                            <?php } ?>

                                            <!-- //////////////////// -->


                                            <form id="tab5_form1" onkeyup="footer_submitfn();" onchange="footer_submitfn();" name="tab5_form1" method="post" action="?t=9" class="form-horizontal" autocomplete="off">

                                                <fieldset>

                                            <p>
                                                Your passcode must be between 8-32 characters, and
                                                you may enter a combination of numbers, letters, and the characters: $ ! # @.
                                            </p>

                                            <p>
                                                Your passcode remains valid until you replace it with a new passcode.
                                            </p>
                                                <br>

                                                    <div class="control-group" id="feild_gp_taddg_divt">
                                                        <label class="control-label" for="gt_mvnx">Passcode Prefix</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" name="passcode_number" maxlength="32" id="passcode_number" class="span2" required value="<?php
                                                            echo$passcode=$db->getValueAsf("SELECT `voucher_number` AS f FROM `exp_customer_vouchers` WHERE `voucher_type` = 'DISTRIBUTOR' AND reference = '$user_distributor' AND `type`='Manual'");
                                                            ?>">
                                                            <button type="submit" name="passcode_submit" id="passcode_submit"  class="btn btn-primary" disabled="disabled">Set Manual Passcode</button>

                                                           <script>
                                                            $('#passcode_number').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                    function footer_submitfn() {
                                                        //alert("fn");
                                                        if($("#passcode_number").val().length>7){
                                                            $("#passcode_submit").prop('disabled', false);
                                                        }
                                                    }
                                                     </script>


                                                            <input type="hidden" name="passcode_secret" value="<?php echo $_SESSION['FORM_SECRET'] ?>">
                                                            <script type="text/javascript">
                                                                $("#passcode_number").keypress(function(event){
                                                                    var ew = event.which;
                                                                    /*alert(ew);*/
                                                                    if(ew == 33 || ew == 35 || ew == 36 || ew ==  64 || ew==8 || ew==0 )
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;
                                                                    if(65 <= ew && ew <= 90)
                                                                        return true;
                                                                    if(97 <= ew && ew <= 122)
                                                                        return true;
                                                                    return false;
                                                                });


                                                                $("#passcode_number").keyup(function(event) {
                                                                    var passcode_number;
                                                                    passcode_number = $('#passcode_number').val();
                                                                    var lastChar = passcode_number.substr(passcode_number.length - 1);
                                                                    var lastCharCode = lastChar.charCodeAt(0);

                                                                    if (!(( lastCharCode == 8 ||lastCharCode == 0 ||lastCharCode == 36 ||lastCharCode == 33 ||lastCharCode == 64 ||lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                                        (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                        (97 <= lastCharCode && lastCharCode <= 122))) {
                                                                        $("#passcode_number").val(passcode_number.substring(0, passcode_number.length - 1));
                                                                    }
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>




                                            <form id="tab5_form2" name="tab5_form2" method="post" action="?t=9" class="form-horizontal" autocomplete="off">

                                                <fieldset>

                                            <b><c style="font-size:24px;">Automated Passcode Option</c></b>&nbsp;&nbsp;&nbsp;
<!-- ////////// -->



                                            <div class="toggle1">

                                            <input class="hide_checkbox" <?php if($auto_status=='1') echo "  checked   "?>  id="auto_passcode" type="checkbox">

                                            <?php if($auto_status=='1'){ ?>

                                            <span class="toggle1-on">ON</span>
                                            <a id="auto_passcode_link"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>

                                            <?php }else{ ?>
                                                <a id="auto_passcode_link"> <span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                                            <span class="toggle1-off">OFF</span>

                                            <?php } ?>

                                            </div>



                                            <br class="mobile-hide">
                                            <br>
                                            <script>
                                                function changePasscodeA(value) {
                                                    /*var value=$('#auto_passcode:checked').val();*/
                                                    /*alert(value);*/
                                                    if(value=='on'){
                                                        window.location ='?change_passcode&t=9&auto_passcode=1&secret=<?php echo $secret; ?>';
                                                    }else{
                                                        window.location ='?change_passcode&t=9&auto_passcode=0&secret=<?php echo $secret; ?>';
                                                    }
                                                }
                                            </script>
                                            <?php if($auto_status=='1'){ ?>
                                            <script type="text/javascript">

                                            $(document).ready(function() {
                                                $('#auto_passcode_link').easyconfirm({locale: {
                                                    title: 'Automated Passcode',
                                                    text: 'Are you sure you want to disable Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#auto_passcode_link').click(function() {
                                                    changePasscodeA("off");
                                                });
                                            });
                                            </script>
                                            <?php }else{ ?>

                                            <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('#auto_passcode_link').easyconfirm({locale: {
                                                    title: 'Automated Passcode',
                                                    text: 'Are you sure you want to enable Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#auto_passcode_link').click(function() {
                                                    changePasscodeA("on");
                                                });
                                            });
                                            </script>

                                            <?php } ?>

<!-- ////////// -->

                                                   <p>Create an optional passcode prefix that will be added to the beginning of randomly generated characters that will be attached to your prefix characters. </p>

                                                   <p>
                                                       The prefix can be a maximum of 16 characters consisting of numbers, letters, and the characters: $ ! # @.
                                                   </p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="prefix">Passcode Prefix</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="prefix" id="prefix" maxlength="16" >
                                                            <small id="prefix_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="prefix" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                        </div>
                                                    </div>


                                                            <script type="text/javascript">

                                                            $('#prefix').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                $("#prefix").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;
                                                                    if(65 <= ew && ew <= 90)
                                                                        return true;
                                                                    if(97 <= ew && ew <= 122)
                                                                        return true;
                                                                    return false;
                                                                });

                                                                $("#prefix").keyup(function(event) {
                                                                    var prefix;
                                                                    prefix = $('#prefix').val();
                                                                    var lastChar = prefix.substr(prefix.length - 1);
                                                                    var lastCharCode = lastChar.charCodeAt(0);

                                                                    if (!(( lastCharCode == 8 ||lastCharCode == 0 ||lastCharCode == 36 ||lastCharCode == 33 ||lastCharCode == 64 ||lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                                        (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                        (97 <= lastCharCode && lastCharCode <= 122))) {
                                                                        $("#prefix").val(prefix.substring(0, prefix.length - 1));
                                                                    }

                                                                    priflenchange();
                                                                });


                                                            </script>


                                            <script type="text/javascript">

                                            function priflenchange(){
                                                //alert("inprifchan");

                                                $('#passcode_length').empty();

                                                var prefix = document.getElementById('prefix').value;
                                                var le=32-prefix.length;

                                                var les=8-prefix.length;

                                                if(les<1){
                                                    les=1;
                                                    }

                                                $("#passcode_length").append('<option value=""> Select Length </option>');

                                                for (i = les; i <= le; i++) {
                                                    $("#passcode_length").append('<option value="'+i+'">'+i+'</option>');
                                                }


                                            }



                                            </script>

                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Number of characters in passcode</label>
                                                        <div class="controls col-lg-5 form-group">

                                                                    <select name="passcode_length" id="passcode_length" class="span4 form-control" >

                                                                    <option value="">Select between 8 & 32 characters</option>

                                                                    <?php
                                                                    for($i=8;$i<33;$i++){

                                                                    echo '<option value="'.$i.'">'.$i.'</option>';

                                                                    }

                                                                    ?>



                                                                    </select>
                                                            <small id="passcode_length_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>


                                                        </div>
                                                    </div>

                                                
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Time of day the new passcode is refreshed</label>
                                                        <div class="controls col-lg-5 form-group">

                                                                    <select name="passcode_renewal_time" id="passcode_renewal_time" class="span4 form-control">

                                                                    <option value="">Select time of day</option>

                                                                    <?php
                                                                    $dt = new DateTime('GMT');
                                                                    $dt->setTime(0, 0);
                                                                    echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                    for($i=0;$i<95;$i++){
                                                                        $dt->add(new DateInterval('PT15M'));
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                    }

                                                                    ?>

                                                                    </select>
                                                            <small id="passcode_renewal_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>


                                                        </div>
                                                    </div>


                                            <p>How often would you like your passcode refreshed?

                                                </p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">
                                                        <div class="net_div">
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="default_frequency" id="default_frequency1" value="Daily" style="display: inline-block">Daily&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="default_frequency" id="default_frequency2" value="Weekly" style="display: inline-block">Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        </div>
                                                        <div class="net_div">
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="default_frequency" id="default_frequency3" value="Bi-weekly" style="display: inline-block">Bi-Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="default_frequency" id="default_frequency4" value="Monthly" style="display: inline-block">Monthly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="net_div_child">
                                                            <input maxlength="3" type="text" class="span1" name="custom_frequency" id="custom_frequency"  style="display: inline-block">&nbsp;Days
                                                            <small id="frequency_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                            <small id="frequency_er1_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>Values starting with 0 are not valid. Valid values are 1-999</p></small>

                                                            <script>
                                                                $("#custom_frequency").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew==8 || ew==0)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;

                                                                    return false;
                                                                });
                                                            </script>
                                                        </div>
                                                        </div>
                                                        </div>
                                                    </div>

                                                 <!--   <p><strong> </strong>or set a customized frequency</p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="number" class="span1" min="1" name="custom_frequency" id="custom_frequency"  style="display: inline-block">&nbsp;Days
                                                        </div>
                                                    </div> -->

                                                    <p>By default, your automated passcode will expire at the same time of day that you choose to refresh with a new automated passcode.  You may choose to add an additional buffer that will increase the amount of time that the expiring passcode remains valid past the time the generation was enabled. 
                                                    </p>
                                            
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Passcode Expiration Buffer</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input maxlength="2" type="text" class="span1" name="buffer_time" id="buffer_time" style="display: inline-block">&nbsp;hours
                                                            <small id="buffer_time_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>Values starting with 0 are not valid. Valid values are 1-24</p></small>
                                                            <script>
                                                                $("#buffer_time").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew==8 || ew==0)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;

                                                                    return false;
                                                                });
                                                            </script>

                                                        </div>
                                                    </div>

                                                    <p>Please enter the email address you would like the automated passcodes to be sent. </p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Passcode delivery email address</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="set_mail" id="set_mail">
                                                            <small id="set_mail_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"></small>
                                                        </div>

                                                    </div>
                                                    <script>
                                                    $(document).ready(function(){
                                                     $('#set_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Validate email address</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="validate_mail" id="validate_mail">
                                                            <small id="validate_mail_er1_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                            <!-- <small id="validate_mail_er2_msg" data-bv-validator="notEmpty" data-bv-validator-for="passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>The email addresses you entered do not match</p></small> -->
                                                        </div>
                                                    </div>
                                                     <script>
                                                    $(document).ready(function(){
                                                     $('#validate_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>

                                                    </fieldset>

                                                    <div class="form-actions">
                                                        <input type="hidden" name="auto_pass_secret" value="<?php echo$secret ?>">
                                                        <button type="submit" name="auto_pass_submit" id="auto_pass_submit" class="btn btn-primary">Set Automated Passcode</button>

                                                    </div>


                                                <script>

                                                    function check_prev(x){

                                                        var net_ele = new Array("passcode_len","passcode_renewal", "frequency","buffer" ,"mail1","mail2");

                                                        /* if(x=='prefix'){
                                                               x='passcode_len';
                                                        }
 */
                                                        var a = net_ele.indexOf(x);

                                                        if(x=='mail1'){
                                                                $('#validate_mail').val('');
                                                                $('#validate_mail_er1_msg').css("display", "none");
                                                                //$('#validate_mail_er2_msg').css("display", "none");
                                                        }


                                                        for (i = 0; i <= parseInt(a); i++) {

                                                            var ab = net_ele[i];

                                                            CheckValues(ab);
                                                        }

                                                    }

                                                    function CheckValues(element)
                                                        {
                                                            var error=0;

                                                            if(element=='prefix'){

                                                                $('#prefix_er_msg').css("display", "none");

                                                                if($("#prefix").val() == ''){

                                                                    $('#prefix_er_msg').css("display", "inline-block");

                                                                }
                                                            }



                                                            // set button disabled
                                                            $('#auto_pass_submit').attr("disabled", true);

                                                            // email regex
                                                            var reg2 = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


                                                            // check first mail set
                                                            var setMail = $("#set_mail").val();


                                                            if(setMail==''){
                                                                error++;
                                                            }else if(setMail.length>128){
                                                            error++;
                                                                if(element=='mail1'){

                                                                    $('#set_mail_er_msg').html('<p>This field value is too long</p>');

                                                                    $('#set_mail_er_msg').css("display", "inline-block");
                                                                }
                                                        }else{
                                                                if (!reg2.test(setMail)) {

                                                                    if(element=='mail1'){

                                                                        $('#set_mail_er_msg').html('<p>This is not a valid email address</p>');
                                                                        $('#set_mail_er_msg').css("display", "inline-block");
                                                                    }
                                                                    error++

                                                                }else{
                                                                    if(element=='mail1') {
                                                                        $('#set_mail_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }



                                                            //check first mail  === second mail
                                                            var validate_mail = $('#validate_mail').val();
                                                            if(validate_mail!=''){

                                                                if(setMail===validate_mail){
                                                                    if(element=='mail2') {
                                                                        $('#validate_mail_er1_msg').css("display", "none");
                                                                        //$('#validate_mail_er2_msg').css("display", "none");
                                                                    }
                                                                }
                                                                else{
                                                                    if(element=='mail2') {
                                                                        //$('#validate_mail_er1_msg').css("display", "none");
                                                                        $('#validate_mail_er1_msg').html('<p>The email addresses you entered do not match</p>');
                                                                        $('#validate_mail_er1_msg').css("display", "inline-block");
                                                                    }
                                                                    error++;
                                                                }
                                                            }else{
                                                                if(element=='mail2') {
                                                                    $('#validate_mail_er1_msg').html('<p>This is a required field</p>');
                                                                    //$('#validate_mail_er2_msg').css("display", "none");
                                                                    $('#validate_mail_er1_msg').css("display", "inline-block");
                                                                }
                                                                error++;
                                                            }

                                                            // check frquency set
                                                            var cus_freq = $("#custom_frequency").val();
                                                            //alert(cus_freq);
                                                            if( $('input[name=default_frequency]:checked').val()!=undefined || cus_freq !='') {
                                                                //1-24 validate regex
                                                                if(cus_freq !=''){
                                                                    var reg3 = /^[1-9][0-9][0-9]$|^[1-9][0-9]$|^[1-9]$/;
                                                                    if (reg3.test(cus_freq)) {
                                                                        if (element == 'frequency') {
                                                                            $('#frequency_er1_msg').css("display", "none");
                                                                            $('#frequency_er_msg').css("display", "none");
                                                                        }
                                                                    } else {
                                                                        if (element == 'frequency') {
                                                                            $('#frequency_er1_msg').css("display", "inline-block");
                                                                            $('#frequency_er_msg').css("display", "none");
                                                                        }
                                                                        error++;
                                                                    }
                                                                }else{
                                                                    if (element == 'frequency') {
                                                                        $('#frequency_er1_msg').css("display", "none");
                                                                        $('#frequency_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }else{
                                                                if(element=='frequency') {
                                                                    $('#frequency_er_msg').css("display", "inline-block");
                                                                    $('#frequency_er1_msg').css("display", "none");
                                                                }
                                                                //$('#auto_pass_submit').attr("disabled", true);
                                                                error++;
                                                            }


                                                            //1-24 validate regex
                                                            var reg1 = /^[1-9]$|^1[0-9]$|^2[0-4]$/;

                                                            var buffer_time = $('#buffer_time').val();

                                                            if(buffer_time!=''){
                                                                if (!reg1.test(buffer_time)) {

                                                                    //alert('false');
                                                                    if(element=='buffer') {

                                                                        $('#buffer_time_er_msg').css("display", "inline-block");
                                                                    }
                                                                    error++;

                                                                }else{

                                                                    //alert('true');
                                                                    if(element=='buffer') {
                                                                        $('#buffer_time_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }else{
                                                                if(element=='buffer') {
                                                                    $('#buffer_time_er_msg').css("display", "none");
                                                                }
                                                            }


                                                            var passcode_length = $('#passcode_length').val();
                                                            //alert(passcode_length);


                                                            if(passcode_length==''){
                                                                if(element=='passcode_len') {
                                                                    $('#passcode_length_er_msg').css("display", "inline-block");
                                                                }

                                                                error++;

                                                            }else{
                                                                if(element=='passcode_len') {
                                                                    $('#passcode_length_er_msg').css("display", "none");
                                                                }
                                                            }


                                                            var passcode_renewal_time = $('#passcode_renewal_time').val();


                                                            if(passcode_renewal_time==''){
                                                                if(element=='passcode_renewal') {
                                                                    //alert();

                                                                    $('#passcode_renewal_er_msg').css("display", "inline-block");
                                                                }

                                                                error++;

                                                            }else{
                                                                if(element=='passcode_renewal') {
                                                                    $('#passcode_renewal_er_msg').css("display", "none");
                                                                }
                                                            }

                                                            if(error==0){

                                                                $('#auto_pass_submit').attr("disabled", false);
                                                            }


                                                        }



                                                    $(document).ready(function(){


                                                        $('#auto_pass_submit').attr("disabled", true);





                                                        $(".frequency").click(function(e){


                                                            //var res = e.target.id.split('_');

                                                            $("#custom_frequency").val(null);

                                                            check_prev('frequency');

                                                        });

                                                        $("#custom_frequency").change(function(e){
                                                            //var res = e.target.id.split('_');

                                                            $("#default_frequency1").prop('checked', false);
                                                            $("#default_frequency2").prop('checked', false);
                                                            $("#default_frequency3").prop('checked', false);
                                                            $("#default_frequency4").prop('checked', false);

                                                            check_prev('frequency');

                                                        });

                                                        $("#custom_frequency").keyup(function(e){
                                                            $("#default_frequency1").prop('checked', false);
                                                            $("#default_frequency2").prop('checked', false);
                                                            $("#default_frequency3").prop('checked', false);
                                                            $("#default_frequency4").prop('checked', false);

                                                            check_prev('frequency');
                                                        });


                                                        $("#set_mail").keyup(function(e){
                                                            check_prev('mail1');
                                                        });
                                                        $("#validate_mail").keyup(function(e){
                                                            check_prev('mail2');
                                                        });

                                                        $("#set_mail").on("change",function(e){
                                                            check_prev('mail1');
                                                        });
                                                        $("#validate_mail").on("change",function(e){
                                                            check_prev('mail2');
                                                        });
                                                        $("#buffer_time").on("change",function(e){
                                                            check_prev('buffer');
                                                        });

                                                        $("#buffer_time").on("keyup",function(e){
                                                            check_prev('buffer');
                                                        });
                                                        $("#prefix").on("change",function(e){
                                                            check_prev('prefix');
                                                        });

                                                        $("#prefix").on("keyup",function(e){
                                                            check_prev('prefix');
                                                        });
                                                        $("#passcode_length").on("change",function(e){
                                                            check_prev('passcode_len');
                                                        });

                                                        $("#passcode_renewal_time").on("change",function(e){
                                                            check_prev('passcode_renewal');
                                                        });


                                                    });
                                                </script>



                                            </form>





<hr/>


                                            <form method="post" action="?t=9" id="auto_passcode_email_update" name="auto_passcode_email_update" class="form-horizontal" autocomplete="off">


                                                <h2>Update Automated Passcode Delivery Email:</h2> <br>

                                                <p>
                                                    If you would like to update the email address used for Automated Passcode delivery, enter the new email address below and click, “update primary email.” If you would like to add an addition email address to receive your Automated Passcodes, click "Add Secondary Email" below.
                                                </p>

                                                <fieldset>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">New email address</label>
                                                        <div class="controls col-lg-5 form-group" id="update_mail_parent">
                                                            <input type="text" class="span4 form-control" name="update_mail" id="update_mail">
                                                        </div>
                                                    </div>
                                                    <script>
                                                    $(document).ready(function(){
                                                     $('#update_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Validate email address</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="validate_update_mail" id="validate_update_mail">

                                                        </div>
                                                    </div>
<script>
                                                    $(document).ready(function(){
                                                     $('#validate_update_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>
                                                    </fieldset>

                                                    <?php
                                                    $mail_count=0;
                                                    $auto_passcode_q1="SELECT * FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`IN('Auto','Buffer')";
                                                            $auto_passcode_q_res1=mysql_query($auto_passcode_q1);
                                                            while($auto_passcode_details1=mysql_fetch_assoc($auto_passcode_q_res1)){
                                                                $secemail_jary1 = $auto_passcode_details1['secondry_email'];
                                                                $secmails_array1=json_decode($secemail_jary1);

                                                            $mail_count = sizeof($secmails_array1);
                                                                    }

                                                    ?>

                                                    <div class="form-actions">
                                                        <input type="hidden" name="auto_pass_emailup_secret" value="<?php echo$secret ?>">
                                                        <button type="submit" name="auto_pass_email_update" onclick="pa_up(0);" id="auto_pass_email_update" value="0" class="btn btn-primary">Update Primary Email</button>

                                                        <?php if($mail_count < 5 ){ ?>

                                                        <button type="submit" name="auto_pass_email_update" onclick="pa_up(1);" id="auto_pass_sec_add" value="1" class="btn btn-danger inline-btn">Add Secondary Email</button>

                                                        <?php } ?>

                                                        <script type="text/javascript">
                                                            $(document).ready(function(){
                                                                function updatemailcheck(action) {

                                                                    if(action=='mail1'){
                                                                        $('#validate_update_mail').val('');
                                                                    }

                                                                    $('#auto_pass_email_update').attr("disabled", true);
                                                                    $('#auto_pass_sec_add').attr("disabled", true);

                                                                    var count = $('#tblAutomaticPasscodes tbody tr').length;
                                                                    //alert(count);
                                                                    if(count<1){
                                                                        return;
                                                                    }

                                                                    if($('#update_mail').val()!=''){
                                                                        if(($('#update_mail').val()==$('#validate_update_mail').val()) && !($("#update_mail_parent").hasClass("has-error")) ){
                                                                            $('#auto_pass_email_update').attr("disabled", false);
                                                                            $('#auto_pass_sec_add').attr("disabled", false);
                                                                        }
                                                                    }
                                                                }

                                                                updatemailcheck();

                                                                $('#update_mail').keyup(function (e) {
                                                                    updatemailcheck('mail1');
                                                                });
                                                                $('#validate_update_mail').keyup(function (e) {
                                                                    updatemailcheck('mail2');
                                                                    //$('#auto_passcode_email_update').bootstrapValidator('validate');
                                                                });

                                                            });


                                                            function pa_up(v){

                                                                //alert(v);

                                                                $('input[name="auto_pass_email_update"]').val(v);


                                                                }

                                                        </script>
                                                    </div>

                                            </form>


                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Active Passcode</h3>
                                                </div>

                                                <div class="widget-content table_response " id="product_tbl">
                                                    <div style="overflow-x:auto;" >
                                                        <table id="tblAutomaticPasscodes" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Passcode</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Email</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Frequency</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Valid From</th>

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Buffer</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Renewal Date</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Expiry Date</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Time Zone</th>


                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                            <?php


                                                            $offset_val=$db->getValueAsf("SELECT `offset_val` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");


                                                            $auto_passcode_q="SELECT *,
                                                            DATE_FORMAT(CONVERT_TZ(start_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS st_date,
                                                            DATE_FORMAT(CONVERT_TZ(refresh_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS en_date,
                                                            DATE_FORMAT(CONVERT_TZ(expire_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS ex_date
                                                            FROM `exp_customer_vouchers`
                                                            WHERE `reference`='$user_distributor' AND `type`IN('Auto','Buffer')";
                                                            $auto_passcode_q_res=mysql_query($auto_passcode_q);
                                                            while($auto_passcode_details=mysql_fetch_assoc($auto_passcode_q_res)){
                                                               // $prof_id=$auto_passcode_details['id'];
                                                                //`voucher_number``frequency``start_date``buffer_duration``refresh_date`
                                                                if($auto_passcode_details['frequency']!="Daily" && $auto_passcode_details['frequency']!="Weekly" && $auto_passcode_details['frequency']!="Bi-weekly" && $auto_passcode_details['frequency']!="Monthly"){
                                                                    $frequency_scale="Days";
                                                                }else{
                                                                    $frequency_scale="";
                                                                }
                                                                echo "<tr><td>".$auto_passcode_details['voucher_number']."</td>";

                                                                echo "<td>".strtolower($auto_passcode_details['reference_email']).' (Primary)';

                                                                $secemail_jary = $auto_passcode_details['secondry_email'];
                                                                $secmails_array=json_decode($secemail_jary);

                                                                foreach($secmails_array as $value){
                                                                    echo '<br/>'.strtolower($value).' '.'<a href="?t=9&rmv_sc=1&rm_sc_mail='.$value.'"><img src="img/trash-ico.png" style="max-height:20px;max-width;20px;"></a>';

                                                                }

                                                                echo "</td>";

                                                                echo "<td>".$auto_passcode_details['frequency']." ".$frequency_scale."</td>";

                                                                $start_date = $auto_passcode_details[st_date];
                                                                $refresh_date = $auto_passcode_details[en_date];
                                                                $expire_date = $auto_passcode_details[ex_date];
                                                                echo "<td>".$start_date."</td>";
                                                                echo "<td>".$auto_passcode_details['buffer_duration']."  Hours</td>";

                                                                echo "<td>".$refresh_date." </td>";
                                                                echo "<td>".$expire_date." </td>";
                                                                echo "<td>".$dis_time_zone." </td></tr>";


                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>


                                        <?php if(in_array("NET_GUEST_BULK_PASSCODE",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($subtab9_1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guestnet_tab_9_1">


                                         <!--    <h2>Setting Passcodes</h2> -->
                                           


                                          



                                            <form id="bulk_tab5_form2" name="bulk_tab5_form2" method="post" action="?t=9_1" class="form-horizontal" autocomplete="off">

                                                <fieldset>

                                            <!-- <b><c style="font-size:24px;">Automated Passcode</c></b>&nbsp;&nbsp;&nbsp;




                                            <div class="toggle1">

                                            <input class="hide_checkbox" <?php //if($auto_status=='1') echo "  checked   "?>  id="auto_passcode" type="checkbox">

                                            <?php // if($auto_status=='1'){ ?>

                                            <span class="toggle1-on">ON</span>
                                            <a id="auto_passcode_link"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span> </a>

                                            <?php //}else{ ?>
                                                <a id="auto_passcode_link"> <span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                                            <span class="toggle1-off">OFF</span>

                                            <?php // } ?>

                                            </div>



                                            <br>
                                            <br> -->
                                            <script>
                                                function changePasscodeA_bulk(value) {
                                                    /*var value=$('#auto_passcode:checked').val();*/
                                                    /*alert(value);*/
                                                    if(value=='on'){
                                                        window.location ='?change_passcode&t=9&auto_passcode=1&secret=<?php echo $secret; ?>';
                                                    }else{
                                                        window.location ='?change_passcode&t=9&auto_passcode=0&secret=<?php echo $secret; ?>';
                                                    }
                                                }
                                            </script>
                                            <?php if($auto_status=='1'){ ?>
                                            <script type="text/javascript">

                                            $(document).ready(function() {
                                                $('#auto_passcode_link').easyconfirm({locale: {
                                                    title: 'Automated Passcode',
                                                    text: 'Are you sure you want to disable Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#auto_passcode_link').click(function() {
                                                    changePasscodeA_bulk("off");
                                                });
                                            });
                                            </script>
                                            <?php }else{ ?>

                                            <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('#auto_passcode_link').easyconfirm({locale: {
                                                    title: 'Automated Passcode',
                                                    text: 'Are you sure you want to enable Automated Passcode?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                    button: ['Cancel',' Confirm'],
                                                    closeText: 'close'
                                                }});
                                                $('#auto_passcode_link').click(function() {
                                                    changePasscodeA_bulk("on");
                                                });
                                            });
                                            </script>

                                            <?php } ?>

<!-- ////////// -->

                                                   <p><strong>Step 1.</strong> You may choose to create an optional passcode "prefix" that will be added to the beginning of your generated passcode. This prefix will be added to the beginning of your automatically generated passcodes and helps make the passcode more readable. </p>

                                                   <p>
                                                       The prefix can be a maximum of 16 characters consisting of numbers, letters, and the characters: $ ! # @.
                                                   </p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="bulk_prefix">Prefix</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="bulk_prefix" id="bulk_prefix" maxlength="16" >
                                                            <small id="bulk_prefix_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_prefix" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                        </div>
                                                    </div>


                                                            <script type="text/javascript">

                                                            $('#bulk_prefix').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

                                                                $("#bulk_prefix").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 ||ew == 35)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;
                                                                    if(65 <= ew && ew <= 90)
                                                                        return true;
                                                                    if(97 <= ew && ew <= 122)
                                                                        return true;
                                                                    return false;
                                                                });

                                                                $("#bulk_prefix").keyup(function(event) {
                                                                    var prefix;
                                                                    prefix = $('#bulk_prefix').val();
                                                                    var lastChar = prefix.substr(prefix.length - 1);
                                                                    var lastCharCode = lastChar.charCodeAt(0);

                                                                    if (!(( lastCharCode == 8 ||lastCharCode == 0 ||lastCharCode == 36 ||lastCharCode == 33 ||lastCharCode == 64 ||lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                                        (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                        (97 <= lastCharCode && lastCharCode <= 122))) {
                                                                        $("#bulk_prefix").val(prefix.substring(0, prefix.length - 1));
                                                                    }

                                                                    bulk_priflenchange();
                                                                });


                                                            </script>


                                            <script type="text/javascript">

                                            function bulk_priflenchange(){
                                                //alert("inprifchan");

                                                $('#bulk_passcode_length').empty();

                                                var prefix = document.getElementById('prefix').value;
                                                var le=32-prefix.length;

                                                var les=8-prefix.length;

                                                if(les<1){
                                                    les=1;
                                                    }

                                                $("#bulk_passcode_length").append('<option value=""> Select Length </option>');

                                                for (i = les; i <= le; i++) {
                                                    $("#bulk_passcode_length").append('<option value="'+i+'">'+i+'</option>');
                                                }


                                            }



                                            </script>


                                                    <p><strong>Step 2. </strong>Select how long you’d like your auto-generated passcode to be. The total length of your passcode (prefix + auto-generated) may not exceed 32 characters.</strong></p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">

                                                                    <select name="bulk_passcode_length" id="bulk_passcode_length" class="span4 form-control" >

                                                                    <option value="">Select Length</option>

                                                                    <?php
                                                                    for($i=8;$i<33;$i++){

                                                                    echo '<option value="'.$i.'">'.$i.'</option>';

                                                                    }

                                                                    ?>



                                                                    </select>
                                                            <small id="bulk_passcode_length_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>


                                                        </div>
                                                    </div>

                                                <p><strong>Step 3. </strong>Select the time of day you would like for your passcode to be renewed.
                                                </p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">
                                                                    
                                                        <input class="span4 form-control" id="passcode_start_date" name="passcode_start_date"
                                                                   type="text" value="<?php //echo $ses_time_start_date; ?>" placeholder="mm/dd/yyyy">
                                                                   <br>
                                                                   <br>

                                                                    <select name="bulk_passcode_renewal_time" id="bulk_passcode_renewal_time" class="span4 form-control">

                                                                    <option value="">Select Time</option>

                                                                    <?php
                                                                    $dt = new DateTime('GMT');
                                                                    $dt->setTime(0, 0);
                                                                    echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                    for($i=0;$i<95;$i++){
                                                                        $dt->add(new DateInterval('PT15M'));
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                    }

                                                                    ?>

                                                                    </select>
                                                            <small id="bulk_passcode_renewal_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>


                                                        </div>
                                                    </div>


                                            <p><strong>
                                                    Step 4. </strong>Select how often you would like for your passcode to be renewed. Choose from the preset options below or choose a customized frequency in days.

                                                </p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">
                                                        <div class="net_div">
                                                        <!-- <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="bulk_default_frequency" id="bulk_default_frequency1" value="Daily" style="display: inline-block">Daily&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="bulk_default_frequency" id="bulk_default_frequency2" value="Weekly" style="display: inline-block">Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        </div>
                                                        <div class="net_div">
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="bulk_default_frequency" id="bulk_default_frequency3" value="Bi-weekly" style="display: inline-block">Bi-Weekly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="net_div_child">
                                                            <input type="radio" class="fixfreequency frequency" name="bulk_default_frequency" id="bulk_default_frequency4" value="Monthly" style="display: inline-block">Monthly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div> -->
                                                        <div class="net_div_child">
                                                            <input maxlength="2" max="60" type="text" class="span1" name="bulk_custom_frequency_val" id="bulk_custom_frequency_val"  style="display: inline-block">
                                                            <small id="bulk_frequency_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                            <small id="bulk_frequency_er1_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p> Values starting with 0 are not valid.Valid values are 1-60</p></small>

                                                            <script>
                                                                $("#bulk_custom_frequency_val").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew==8 || ew==0)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;

                                                                    return false;
                                                                });
                                                                $("#bulk_custom_frequency_val").keyup(function(){
                                                                    var value_p = document.getElementById("bulk_custom_frequency_val").value;
                                                                    //alert(value_p);
                                                                    if(value_p > 60){
                                                                        $('#bulk_frequency_er1_msg').css("display", "inline-block");
                                                                            //$('#bulk_frequency_er1_msg').css("display", "none");
                                                                    }else{
                                                                        $('#bulk_frequency_er1_msg').css("display", "none")
                                                                    }
                                                                   
                                                                    });
                                                            </script>
                                                        </div>
                                                        <div class="net_div_child">
                                                        <select name="bulk_custom_frequency" id="bulk_custom_frequency" class="span2 form-control">

                                                                    <option value="Days">Days</option>
                                                                    <option value="Hours">Hours</option>
                                                                    <option value="Minutes">Minutes</option>
                                                                    

                                                                    ?>

                                                                    </select>
                                                        </div>

                                                        </div>
                                                        </div>
                                                    </div>

                                                 <!--   <p><strong> </strong>or set a customized frequency</p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="number" class="span1" min="1" name="bulk_custom_frequency" id="bulk_custom_frequency"  style="display: inline-block">&nbsp;Days
                                                        </div>
                                                    </div> -->

                                                   <!--  <p><strong>Step 5. </strong> Your Automated Passcode will expire at the same time of day that the generation was enabled. You may choose to add an additional Passcode Expiration Buffer that will increase the amount of time that the expiring passcode remains valid past the time the generation was enabled.
                                                    </p>

                                                    <p>
                                                        For example, if your passcode is generated at 10:30 AM with a generation frequency of weekly, that passcode will expire at 10:30 AM on the 7th day. If you added a Passcode Expiration Buffer of 8 hours, the old passcode would still be valid for 8 hours after the new passcode is generated.
                                                    </p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Passcode Expiration Buffer</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input maxlength="2" type="text" class="span1" name="bulk_buffer_time" id="bulk_buffer_time" style="display: inline-block">&nbsp;Hours
                                                            <small id="bulk_buffer_time_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>Values starting with 0 are not valid. Valid values are 1-24</p></small>
                                                            <script>
                                                                $("#bulk_buffer_time").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew==8 || ew==0)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;

                                                                    return false;
                                                                });
                                                            </script>

                                                        </div>
                                                    </div> -->

                                                     <p><strong>Step 5. </strong> 
                                                    </p>

                                                    
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Number of Passcodes </label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input maxlength="3" max="100" type="text" class="span1" name="bulk_Passcodes_no" id="bulk_Passcodes_no" style="display: inline-block">
                                                            <small id="bulk_pass_no_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>Values starting with 0 are not valid. Valid values are 1-100</p></small> 
                                                            <script>
                                                                $("#bulk_Passcodes_no").keypress(function(event){
                                                                    var ew = event.which;
                                                                    if(ew==8 || ew==0)
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;

                                                                    return false;
                                                                });

                                                                 $("#bulk_Passcodes_no").keyup(function(){
                                                                    var value_p = document.getElementById("bulk_Passcodes_no").value;
                                                                    //alert(value_p);
                                                                    if(value_p > 100){
                                                                        $('#bulk_pass_no_er_msg').css("display", "inline-block");
                                                                            //$('#bulk_frequency_er1_msg').css("display", "none");
                                                                    }else{
                                                                        $('#bulk_pass_no_er_msg').css("display", "none")
                                                                    }
                                                                   
                                                                    });
                                                            </script>

                                                        </div>
                                                    </div>

                                                    <p><strong>Step 6. </strong>Enter the email address you would like to use for Automated Passcode delivery. If you would like to change the delivery email or add an additional email recipient at a later date, you may update it below.
                                                    </p>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Set Email</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="bulk_set_mail" id="bulk_set_mail">
                                                            <small id="bulk_set_mail_er_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"></small>
                                                        </div>

                                                    </div>
                                                    <script>
                                                    $(document).ready(function(){
                                                     $('#bulk_set_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Validate Email</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="bulk_validate_mail" id="bulk_validate_mail">
                                                            <small id="bulk_validate_mail_er1_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>This is a required field</p></small>
                                                            <!-- <small id="bulk_validate_mail_er2_msg" data-bv-validator="notEmpty" data-bv-validator-for="bulk_passcode_number" class="help-block error-wrapper bubble-pointer mbubble-pointer" style="display: none;"><p>The email addresses you entered do not match</p></small> -->
                                                        </div>
                                                    </div>
                                                     <script>
                                                    $(document).ready(function(){
                                                     $('#bulk_validate_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>

                                                    </fieldset>

                                                    <div class="form-actions">
                                                        <input type="hidden" name="bulk_auto_pass_secret" value="<?php echo$secret ?>">
                                                        <button type="submit" name="bulk_auto_pass_submit" id="bulk_auto_pass_submit" class="btn btn-primary">Set Bulk Passcodes</button>

                                                    </div>


                                                <script>

                                                    function bulk_check_prev(x){

                                                        var net_ele = new Array("passcode_len","passcode_renewal", "frequency","buffer" ,"mail1","mail2");

                                                        /* if(x=='prefix'){
                                                               x='passcode_len';
                                                        }
 */
                                                        var a = net_ele.indexOf(x);

                                                        if(x=='mail1'){
                                                                $('#bulk_validate_mail').val('');
                                                                $('#bulk_validate_mail_er1_msg').css("display", "none");
                                                                //$('#bulk_validate_mail_er2_msg').css("display", "none");
                                                        }


                                                        for (i = 0; i <= parseInt(a); i++) {

                                                            var ab = net_ele[i];

                                                            bulk_CheckValues(ab);
                                                        }

                                                    }

                                                    function bulk_CheckValues(element)
                                                        {
                                                            var error=0;

                                                            if(element=='prefix'){

                                                                $('#bulk_prefix_er_msg').css("display", "none");

                                                                if($("#bulk_prefix").val() == ''){

                                                                    $('#bulk_prefix_er_msg').css("display", "inline-block");

                                                                }
                                                            }



                                                            // set button disabled
                                                           // $('#bulk_auto_pass_submit').attr("disabled", true);

                                                            // email regex
                                                            var reg2 = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


                                                            // check first mail set
                                                            var setMail = $("#bulk_set_mail").val();


                                                            if(setMail==''){
                                                                error++;
                                                            }else if(setMail.length>128){
                                                            error++;
                                                                if(element=='mail1'){

                                                                    $('#bulk_set_mail_er_msg').html('<p>This field value is too long</p>');

                                                                    $('#bulk_set_mail_er_msg').css("display", "inline-block");
                                                                }
                                                        }else{
                                                                if (!reg2.test(setMail)) {

                                                                    if(element=='mail1'){

                                                                        $('#bulk_set_mail_er_msg').html('<p>This is not a valid email address</p>');
                                                                        $('#bulk_set_mail_er_msg').css("display", "inline-block");
                                                                    }
                                                                    error++

                                                                }else{
                                                                    if(element=='mail1') {
                                                                        $('#bulk_set_mail_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }



                                                            //check first mail  === second mail
                                                            var bulk_validate_mail = $('#bulk_validate_mail').val();
                                                            if(bulk_validate_mail!=''){

                                                                if(setMail===bulk_validate_mail){
                                                                    if(element=='mail2') {
                                                                        $('#bulk_validate_mail_er1_msg').css("display", "none");
                                                                        //$('#bulk_validate_mail_er2_msg').css("display", "none");
                                                                    }
                                                                }
                                                                else{
                                                                    if(element=='mail2') {
                                                                        //$('#bulk_validate_mail_er1_msg').css("display", "none");
                                                                        $('#bulk_validate_mail_er1_msg').html('<p>The email addresses you entered do not match</p>');
                                                                        $('#bulk_validate_mail_er1_msg').css("display", "inline-block");
                                                                    }
                                                                    error++;
                                                                }
                                                            }else{
                                                                if(element=='mail2') {
                                                                    $('#bulk_validate_mail_er1_msg').html('<p>This is a required field</p>');
                                                                    //$('#bulk_validate_mail_er2_msg').css("display", "none");
                                                                    $('#bulk_validate_mail_er1_msg').css("display", "inline-block");
                                                                }
                                                                error++;
                                                            }

                                                            // check frquency set
                                                            var cus_freq = $("#bulk_custom_frequency").val();
                                                            //alert(cus_freq);
                                                            if( $('input[name=bulk_default_frequency]:checked').val()!=undefined || cus_freq !='') {
                                                                //1-24 validate regex
                                                                if(cus_freq !=''){
                                                                    var reg3 = /^[1-9][0-9][0-9]$|^[1-9][0-9]$|^[1-9]$/;
                                                                    if (reg3.test(cus_freq)) {
                                                                        if (element == 'frequency') {
                                                                            $('#bulk_frequency_er1_msg').css("display", "none");
                                                                            $('#bulk_frequency_er_msg').css("display", "none");
                                                                        }
                                                                    } else {
                                                                        if (element == 'frequency') {
                                                                            $('#bulk_frequency_er1_msg').css("display", "inline-block");
                                                                            $('#bulk_frequency_er_msg').css("display", "none");
                                                                        }
                                                                        error++;
                                                                    }
                                                                }else{
                                                                    if (element == 'frequency') {
                                                                        $('#bulk_frequency_er1_msg').css("display", "none");
                                                                        $('#bulk_frequency_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }else{
                                                                if(element=='frequency') {
                                                                    $('#bulk_frequency_er_msg').css("display", "inline-block");
                                                                    $('#bulk_frequency_er1_msg').css("display", "none");
                                                                }
                                                                //$('#bulk_auto_pass_submit').attr("disabled", true);
                                                                error++;
                                                            }


                                                            //1-24 validate regex
                                                            var reg1 = /^[1-9]$|^1[0-9]$|^2[0-4]$/;

                                                            var bulk_buffer_time = $('#bulk_buffer_time').val();

                                                            if(bulk_buffer_time!=''){
                                                                if (!reg1.test(bulk_buffer_time)) {

                                                                    //alert('false');
                                                                    if(element=='buffer') {

                                                                        $('#bulk_buffer_time_er_msg').css("display", "inline-block");
                                                                    }
                                                                    error++;

                                                                }else{

                                                                    //alert('true');
                                                                    if(element=='buffer') {
                                                                        $('#bulk_buffer_time_er_msg').css("display", "none");
                                                                    }
                                                                }
                                                            }else{
                                                                if(element=='buffer') {
                                                                    $('#bulk_buffer_time_er_msg').css("display", "none");
                                                                }
                                                            }


                                                            var bulk_passcode_length = $('#bulk_passcode_length').val();
                                                            //alert(bulk_passcode_length);


                                                            if(bulk_passcode_length==''){
                                                                if(element=='passcode_len') {
                                                                    $('#bulk_passcode_length_er_msg').css("display", "inline-block");
                                                                }

                                                                error++;

                                                            }else{
                                                                if(element=='passcode_len') {
                                                                    $('#bulk_passcode_length_er_msg').css("display", "none");
                                                                }
                                                            }


                                                            var bulk_passcode_renewal_time = $('#bulk_passcode_renewal_time').val();


                                                            if(bulk_passcode_renewal_time==''){
                                                                if(element=='passcode_renewal') {
                                                                    //alert();

                                                                    $('#bulk_passcode_renewal_er_msg').css("display", "inline-block");
                                                                }

                                                                error++;

                                                            }else{
                                                                if(element=='passcode_renewal') {
                                                                    $('#bulk_passcode_renewal_er_msg').css("display", "none");
                                                                }
                                                            }

                                                            if(error==0){

                                                                //$('#bulk_auto_pass_submit').attr("disabled", false);
                                                            }


                                                        }



                                                    $(document).ready(function(){


                                                        //$('#bulk_auto_pass_submit').attr("disabled", true);





                                                        $(".frequency").click(function(e){


                                                            //var res = e.target.id.split('_');

                                                            $("#bulk_custom_frequency").val(null);

                                                            bulk_check_prev('frequency');

                                                        });

                                                        $("#bulk_custom_frequency").change(function(e){
                                                            //var res = e.target.id.split('_');

                                                            $("#bulk_default_frequency1").prop('checked', false);
                                                            $("#bulk_default_frequency2").prop('checked', false);
                                                            $("#bulk_default_frequency3").prop('checked', false);
                                                            $("#bulk_default_frequency4").prop('checked', false);

                                                            bulk_check_prev('frequency');

                                                        });

                                                        $("#bulk_custom_frequency").keyup(function(e){
                                                            $("#bulk_default_frequency1").prop('checked', false);
                                                            $("#bulk_default_frequency2").prop('checked', false);
                                                            $("#bulk_default_frequency3").prop('checked', false);
                                                            $("#bulk_default_frequency4").prop('checked', false);

                                                            bulk_check_prev('frequency');
                                                        });


                                                        $("#bulk_set_mail").keyup(function(e){
                                                            bulk_check_prev('mail1');
                                                        });
                                                        $("#bulk_validate_mail").keyup(function(e){
                                                            bulk_check_prev('mail2');
                                                        });

                                                        $("#bulk_set_mail").on("change",function(e){
                                                            bulk_check_prev('mail1');
                                                        });
                                                        $("#bulk_validate_mail").on("change",function(e){
                                                            bulk_check_prev('mail2');
                                                        });
                                                        $("#bulk_buffer_time").on("change",function(e){
                                                            bulk_check_prev('buffer');
                                                        });

                                                        $("#bulk_buffer_time").on("keyup",function(e){
                                                            bulk_check_prev('buffer');
                                                        });
                                                        $("#bulk_prefix").on("change",function(e){
                                                            bulk_check_prev('prefix');
                                                        });

                                                        $("#bulk_prefix").on("keyup",function(e){
                                                            bulk_check_prev('prefix');
                                                        });
                                                        $("#bulk_passcode_length").on("change",function(e){
                                                            bulk_check_prev('passcode_len');
                                                        });

                                                        $("#bulk_passcode_renewal_time").on("change",function(e){
                                                            bulk_check_prev('passcode_renewal');
                                                        });


                                                    });
                                                </script>



                                            </form>





<hr/>


                                            <!-- <form method="post" action="?t=9_1" id="bulk_auto_passcode_email_update" name="bulk_auto_passcode_email_update" class="form-horizontal" autocomplete="off">


                                                <h2>Update Automated Passcode Delivery Email:</h2>

                                                <p>
                                                    If you would like to update the email address used for Automated Passcode delivery, enter the new email address below. If you would like to add another email address to receive your Automated Passcodes, select "Add Secondary Email" below.
                                                </p>

                                                <fieldset>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">New Email</label>
                                                        <div class="controls col-lg-5 form-group" id="bulk_update_mail_parent">
                                                            <input type="text" class="span4 form-control" name="bulk_update_mail" id="bulk_update_mail">
                                                        </div>
                                                    </div>
                                                    <script>
                                                    $(document).ready(function(){
                                                     $('#bulk_update_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <label class="control-label" for="gt_mvnx">Validate New Email</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="text" class="span4 form-control" name="bulk_validate_update_mail" id="bulk_validate_update_mail">

                                                        </div>
                                                    </div>
<script>
                                                    $(document).ready(function(){
                                                     $('#bulk_validate_update_mail').bind("cut copy paste",function(e) {
                                                          e.preventDefault();
                                                         });
                                                            });
                                                    </script>
                                                    </fieldset>

                                                    <?php
                                                    /* $mail_count=0;
                                                    $auto_passcode_q1="SELECT * FROM `exp_customer_vouchers` WHERE `reference`='$user_distributor' AND `type`IN('Auto','Buffer')";
                                                            $auto_passcode_q_res1=mysql_query($auto_passcode_q1);
                                                            while($auto_passcode_details1=mysql_fetch_assoc($auto_passcode_q_res1)){
                                                                $secemail_jary1 = $auto_passcode_details1['secondry_email'];
                                                                $secmails_array1=json_decode($secemail_jary1);

                                                            $mail_count = sizeof($secmails_array1);
                                                                    }
 */
                                                    ?>

                                                    <div class="form-actions">
                                                        <input type="hidden" name="bulk_auto_pass_emailup_secret" value="<?php echo$secret ?>">
                                                        <button type="submit" name="bulk_auto_pass_email_update" onclick="pa_up(0);" id="bulk_auto_pass_email_update" value="0" class="btn btn-primary">Update Primary Email</button>

                                                        <?php //if($mail_count < 5 ){ ?>

                                                        <button type="submit" name="bulk_auto_pass_email_update" onclick="pa_up(1);" id="bulk_auto_pass_sec_add" value="1" class="btn btn-danger inline-btn">Add Secondary Email</button>

                                                        <?php //} ?>

                                                        <script type="text/javascript">
                                                            $(document).ready(function(){
                                                                function updatemailcheck(action) {

                                                                    if(action=='mail1'){
                                                                        $('#bulk_validate_update_mail').val('');
                                                                    }

                                                                    $('#bulk_auto_pass_email_update').attr("disabled", true);
                                                                    $('#bulk_auto_pass_sec_add').attr("disabled", true);

                                                                    var count = $('#bulk_tblAutomaticPasscodes tbody tr').length;
                                                                    //alert(count);
                                                                    if(count<1){
                                                                        return;
                                                                    }

                                                                    if($('#bulk_update_mail').val()!=''){
                                                                        if(($('#bulk_update_mail').val()==$('#bulk_validate_update_mail').val()) && !($("#bulk_update_mail_parent").hasClass("has-error")) ){
                                                                            $('#bulk_auto_pass_email_update').attr("disabled", false);
                                                                            $('#bulk_auto_pass_sec_add').attr("disabled", false);
                                                                        }
                                                                    }
                                                                }

                                                                updatemailcheck();

                                                                $('#bulk_update_mail').keyup(function (e) {
                                                                    updatemailcheck('mail1');
                                                                });
                                                                $('#bulk_validate_update_mail').keyup(function (e) {
                                                                    updatemailcheck('mail2');
                                                                    //$('#bulk_auto_passcode_email_update').bootstrapValidator('validate');
                                                                });

                                                            });


                                                            function pa_up(v){

                                                                //alert(v);

                                                                $('input[name="bulk_auto_pass_email_update"]').val(v);


                                                                }

                                                        </script>
                                                    </div>

                                            </form> -->


                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Active Passcode</h3>
                                                </div>

                                                <div class="widget-content table_response " id="product_tbl">
                                                    <div style="overflow-x:auto;" >
                                                        <table id="bulk_tblAutomaticPasscodes" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Number of Passcode</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Email</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Frequency</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Valid From</th>

                                                                <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Buffer</th> -->
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Renewal Date</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Expiry Date</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Donload</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Time Zone</th>


                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                            <?php

                                                                
                                                            $offset_val=$db->getValueAsf("SELECT `offset_val` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor' LIMIT 1");


                                                            $auto_passcode_q="SELECT *,
                                                            DATE_FORMAT(CONVERT_TZ(start_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS st_date,
                                                            DATE_FORMAT(CONVERT_TZ(refresh_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS en_date,
                                                            DATE_FORMAT(CONVERT_TZ(expire_date,'SYSTEM','$offset_val'),'%m/%d/%Y %h:%i %p') AS ex_date
                                                            FROM `exp_customer_bulk_vouchers`
                                                            WHERE `reference`='$user_distributor' ";
                                                            $auto_passcode_q_res=mysql_query($auto_passcode_q);
                                                            while($auto_passcode_details=mysql_fetch_assoc($auto_passcode_q_res)){
                                                               // $prof_id=$auto_passcode_details['id'];
                                                                //`voucher_number``frequency``start_date``buffer_duration``refresh_date`
                                                                if($auto_passcode_details['frequency']!="Daily" && $auto_passcode_details['frequency']!="Weekly" && $auto_passcode_details['frequency']!="Bi-weekly" && $auto_passcode_details['frequency']!="Monthly"){
                                                                    $frequency_scale="Days";
                                                                }else{
                                                                    $frequency_scale="";
                                                                }
                                                                echo "<tr><td>".$auto_passcode_details['voucher_no']."</td>";
                                                                echo "<td>".$auto_passcode_details['email']."</td>";

                                                                /* echo "<td>".strtolower($auto_passcode_details['reference_email']).' (Primary)';

                                                                $secemail_jary = $auto_passcode_details['secondry_email'];
                                                                $secmails_array=json_decode($secemail_jary);

                                                                foreach($secmails_array as $value){
                                                                    echo '<br/>'.strtolower($value).' '.'<a href="?t=9&rmv_sc=1&rm_sc_mail='.$value.'"><img src="img/trash-ico.png" style="max-height:20px;max-width;20px;"></a>';

                                                                }

                                                                echo "</td>"; */

                                                                echo "<td>".$auto_passcode_details['frequency']." ".$frequency_scale."</td>";

                                                                $start_date = $auto_passcode_details[st_date];
                                                                $refresh_date = $auto_passcode_details[en_date];
                                                                $expire_date = $auto_passcode_details[ex_date];
                                                                $bulk_id = $auto_passcode_details[bulk_id];

                                                                $bulk_down_key_string = "task=bulk_passcode&bulk_id=".$bulk_id;
                                                                $bulk_down_key =  cryptoJsAesEncrypt($data_secret,$bulk_down_key_string);
                                                                $bulk_down_key =  urlencode($bulk_down_key);


                                                                echo "<td>".$start_date."</td>";
                                                               /*  echo "<td>".$auto_passcode_details['buffer_duration']."  Hours</td>"; */

                                                                echo "<td>".$refresh_date." </td>";
                                                                echo "<td>".$expire_date." </td>";
                                                                echo "<td><a href='ajax/export_customer.php?key=".$bulk_down_key."'>Download</a></td>";
                                                                echo "<td>".$dis_time_zone." </td></tr>";

                                                   
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>                                        

                                        <?php  if(in_array("NET_GUEST_INTRO",$features_array) || $package_features=="all"){ ?>
                                              <div style="font-size: medium" <?php if(isset($subtab8)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_intruduct">


 <?php  

 $gst_wifi_intro=$message_functions->getPageContent('guest_wifi_introduction_content',$system_package);

    $txt_replace = array(

        '{$wifi_txt}' => __WIFI_TEXT__,
        '{$theme}' => __THEME_TEXT__,
        '{$themeUpper}' =>  ucwords(__THEME_TEXT__)
    );

    $gst_wifi_intro = strtr($gst_wifi_intro, $txt_replace);
    echo $gst_wifi_intro;
 ?>




                                                  </div>
                                        <?php } ?>
                                        <?php  if(in_array("NET_GUEST_SSID",$features_array) || $package_features=="all"){?>
                                          <div <?php if(isset($subtab7)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_1">
                                        <!-- Tab 1 start-->





                                        <div id="guest_modify_network"></div>

                                        <?php if ($tooltip_enable=='Yes') { ?> 

                                              <h2>SSID Name <img data-toggle="tooltip" title="<?php echo $tooltip_arr['SSID_name']; ?>" src="layout/FRONTIER/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" ></h2>
                                              <!-- <p><b><i>&nbsp;&nbsp;&nbsp;&nbsp;So your guests can easily identify and connect</i></b></p> -->
                                        <?php } else{ ?> 
                                            <h2>SSID Name</h2>
                                            <?php }?> 

                                              <p>
                                                  Name your network so your guests can easily identify and connect. Select the current SSID name from the dropdown below. Then enter the new name of your Guest <?php echo __WIFI_TEXT__; ?> Network.
                                                  </p>


                                                    <br/>

                                              <?php if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='NO' ) {

                                              ?>

                                            <div class="controls col-lg-5 form-group">
                                                <a href="?t=7&st=7&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary mar-top" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                            </div>
                                             <br/>
                                              </br>

                                              <?php } ?>


                                              <div style="display: none" class='alert alert-danger all_na'><button type='button' class='close' data-dismiss='alert'>×</button><strong>


                                              <?php echo $system_package; echo $message_functions->showMessage('no_aps_installed'); ?>

                                              </strong>
                                        </div>



                                              <form id="update_default_qos_table" name="update_default_qos_table" class="form-horizontal" action="?t=7" method="post">

                                                  <div class="widget widget-table action-table" >
                                                      <div class="widget-header">
                                                          <!-- <i class="icon-th-list"></i> -->
                                                          <h3></h3>
                                                      </div>
                                                    <div class="widget-content table_response" id="ssid_tbl">
                                                        <div style="overflow-x:auto;" >
                                                      <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap >
                                                          <thead>
                                                              <tr>

                                                               <!-- <th>AP MAC Address</th> -->
                                                              <!--    <th>WLAN Name</th>  -->
                                                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Guest SSID</th>
                                                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Location Name</th>
                                                                  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Service Address</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                          <?php
                                                         /* $ssid_q="SELECT d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.`ssid`,s.`network_id`, l.`group_tag`
                                                                    FROM `exp_locations_ssid` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d,`exp_locations_ap_ssid` l
                                                                  WHERE s.`distributor`=d.`distributor_code`
                                                                  AND s.`distributor`= a.`distributor_code`
                                                                  AND a.`ap_code`=l.`ap_id`
                                                                  AND s.`distributor`='$user_distributor'
                                                                  AND l.`distributor`='$user_distributor'
                                                              --    GROUP  BY  a.`ap_code`
                                                          GROUP  BY   s.`ssid`";  */

                                                          $all_na = '2';

                                                          $ssid_q="SELECT d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.`ssid`,s.`network_id` ,l.`group_tag`,d.bussiness_address1,d.state_region,d.bussiness_address2
                                                                FROM
                                                                `exp_mno_distributor` d
                                                                LEFT JOIN
                                                                `exp_locations_ssid` s
                                                                ON s.`distributor`=d.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_mno_distributor_aps` a
                                                                ON s.`distributor`= a.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_locations_ap_ssid` l
                                                                ON a.`ap_code`=l.`ap_id`

                                                                WHERE  d.`distributor_code`='$user_distributor'
                                                                GROUP  BY   s.`ssid`";
                                                          $ssid_res=mysql_query($ssid_q);
                                                          $i=0;

                                                          if(mysql_num_rows($ssid_res) > 0){

                                                          while($ssid_name=mysql_fetch_assoc($ssid_res)){
                                                           //   echo'<input type="hidden" name="network_id" value="'.$ssid_name['network_id'].'">';
                                                           //   echo'<input type="hidden" name="description" value="'.$ssid_name['description'].'">';
                                                          //    echo "<tr><td>".$ssid_name['ap_code']."</td>";

                                                              $gorup_tag = $ssid_name['group_tag'];

                                                              if(strlen($gorup_tag) < 1){
                                                                  $location_id = 'N/A';
                                                              }else{
                                                                  $location_id = $gorup_tag;
                                                                  $all_na = "0";
                                                              }

                                                            echo  "<td>".$ssid_name['ssid']."</td>";

                                                            echo    "<td>".$location_id."</td>";
                                                            echo    "<td>".$ssid_name['bussiness_address1']."&nbsp;,&nbsp;".$ssid_name['bussiness_address2']."&nbsp;".$ssid_name['state_region']."</td>";

                                                             echo "<input type='hidden' name='ap[$i]' value='$ssid_name[ap_code]'/>";

                                                            echo"</tr>";
                                                            //  $ssidName=$ssid_name['ssid'];
                                                            //  $wlanId=$ssid_name['wlan_name'];


                                                              $i++;
                                                          }

                                                          if($all_na != "0"){

                                                            echo '<style> .all_na{ display: block !important; } </style>';

                                                          }

                                                        }

                                                          ?>
                                                          </tbody>
                                                          </table>
                                                            </div>
                                                  </div>
                                              </div><br/>

                                                      <fieldset>
                                                          <div class="control-group">
                                                              <label class="control-label" for="ssid_name">Current SSID Name : </label>
                                                              <div class="controls col-lg-5 form-group">



                                                                      <select required class="span4 form-control" id="ssid_name" name="ssid_name" <?php echo $ssidName; ?> onchange="loadSSIDForm(this.value)">
                                                                          <option value="">Select SSID</option>
                                                                          <?php
                                                                          $ssid_q="SELECT s.`ssid`
                                                                                    FROM
                                                                                    `exp_mno_distributor` d
                                                                                    LEFT JOIN
                                                                                    `exp_locations_ssid` s
                                                                                    ON s.`distributor`=d.`distributor_code`
                                                                                    LEFT JOIN
                                                                                    `exp_mno_distributor_aps` a
                                                                                    ON s.`distributor`= a.`distributor_code`
                                                                                    LEFT JOIN
                                                                                    `exp_locations_ap_ssid` l
                                                                                    ON a.`ap_code`=l.`ap_id`

                                                                                    WHERE  d.`distributor_code`='$user_distributor' AND s.ssid<>''
                                                                                    GROUP  BY   s.`ssid`";
                                                                          $ssid_res=mysql_query($ssid_q);
                                                                          while($ssid_names=mysql_fetch_assoc($ssid_res)){
                                                                              echo'<option value="'.$ssid_names[ssid].'">'.$ssid_names[ssid].'</option>';
                                                                          }
                                                                          ?>
                                                                      </select>
                                                                      <script>
                                                                          function loadSSIDForm(ssid){

                                                                            /*  alert(ssid);    */
                                                                              var ssid=ssid;
                                                                              var formData={ssid:ssid,dis:"<?php echo $user_distributor; ?>"};
                                                                              $.ajax({
                                                                                  url : "ajax/getSsidDetails.php",
                                                                                  type: "POST",
                                                                                  data : formData,
                                                                                  success: function(data)
                                                                                  {
                                                                                   /*   alert(data);   */
                                                                                      var data_array = data.split(',');

                                                                                      document.getElementById("network_id").value=data_array[1];
                                                                                      document.getElementById("wlan_name").value=data_array[0];
                                                                                  },
                                                                                  error: function (jqXHR, textStatus, errorThrown)
                                                                                  {

                                                                                  }
                                                                              });



                                                                          }
                                                                      </script>
                                                                      <input  id="wlan_name" name="wlan_name" type="hidden" value="" >
                                                                      <input  id="network_id" name="network_id" type="hidden" value="" >


                                                              </div>
                                                          </div>
                                                          <div class="control-group">
                                                              <label class="control-label" for="mod_ssid_name">New SSID Name : </label>
                                                              <div >
                                                                  <div class="controls col-lg-5 form-group">
                                                                      <input required class="span4 form-control" id="mod_ssid_name" name="mod_ssid_name" type="text" maxlength="32" value="<?php echo ''; ?>">
                                                                      <small id="invalid_ssid" style="display: none;" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>SSID Name is invalid</p></small>

                                                                      <script type="text/javascript">
                                                                          $(document).ready(function () {
                                                                              $('#mod_ssid_name').bind("cut copy paste", function (e) {
                                                                                  e.preventDefault();
                                                                              });


                                                                              $("#mod_ssid_name").keypress(function (event) {
                                                                                  var ew = event.which;
                                                                                  if (ew == 8 || ew == 0 || ew == 45 || ew == 95)
                                                                                      return true;
                                                                                  if (48 <= ew && ew <= 57)
                                                                                      return true;
                                                                                  if (65 <= ew && ew <= 90)
                                                                                      return true;
                                                                                  if (97 <= ew && ew <= 122)
                                                                                      return true;
                                                                                  return false;


                                                                              });

                                                                              $("#mod_ssid_name").blur(function (event) {
                                                                                  var temp_ssid_name = $('#mod_ssid_name').val();
                                                                                  if (checkWords(temp_ssid_name.toLowerCase())) {

                                                                                      $("#mod_ssid_name").val("");
                                                                                      $('#invalid_ssid').css('display', 'inline-block');
                                                                                      $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                      $('#update_ssid').attr('disabled', true);
                                                                                  } else {
                                                                                      $('#invalid_ssid').hide();
                                                                                  }
                                                                              });

                                                                              $("#mod_ssid_name").keyup(function (event) {

                                                                                  var temp_ssid_name;
                                                                                  temp_ssid_name = $('#mod_ssid_name').val();
                                                                                  var lastChar = temp_ssid_name.substr(temp_ssid_name.length - 1);
                                                                                  var lastCharCode = lastChar.charCodeAt(0);

                                                                                  if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 45 || lastCharCode == 95) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                                                      (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                                      (97 <= lastCharCode && lastCharCode <= 122))) {
                                                                                      $("#mod_ssid_name").val(temp_ssid_name.substring(0, temp_ssid_name.length - 1));
                                                                                  }

                                                                                  temp_ssid_name = $('#mod_ssid_name').val();
                                                                                  if (checkWords(temp_ssid_name.toLowerCase())) {

                                                                                      $("#mod_ssid_name").val("");
                                                                                      $('#invalid_ssid').css('display', 'inline-block');
                                                                                      $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                      $('#update_ssid').attr('disabled', true);
                                                                                  } else {
                                                                                      $('#invalid_ssid').hide();
                                                                                  }
                                                                              });


                                                                              function past() {

                                                                                  setTimeout(function () {

                                                                                      var temp_ssid_name = $('#mod_ssid_name').val();


                                                                                      if (checkWords(temp_ssid_name.toLowerCase())) {

                                                                                          $("#mod_ssid_name").val("");
                                                                                          $('#invalid_ssid').css('display', 'inline-block');

                                                                                          $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");

                                                                                          $('#update_ssid').attr('disabled', true);
                                                                                      } else {
                                                                                          $('#invalid_ssid').hide();
                                                                                      }


                                                                                  }, 100);

                                                                              }


                                                                              function checkWords(inword) {

                                                                                  var words =<?php
                                                                                      $words = $db->getValueAsf("SELECT `policies` AS f FROM `exp_policies` WHERE `policy_code`='SSID_name'");
                                                                                      $words_ar = explode(",", $words);
                                                                                      $script_ar = '[';
                                                                                      for ($i = 0; $i < count($words_ar); $i++) {
                                                                                          $script_ar .= "\"" . $words_ar[$i] . "\",";
                                                                                      }

                                                                                      $script_ar = rtrim($script_ar, ",");
                                                                                      $script_ar .= "]";
                                                                                      echo $script_ar;

                                                                                      ?>;

                                                                                  if (words.indexOf(inword) >= 0) {

                                                                                      return true;

                                                                                  }
                                                                                  else {

                                                                                      var regex = /^[a-zA-Z0-9_-]+$/;

                                                                                      if (regex.test(inword) == false) {

                                                                                          $('#update_ssid').attr('disabled', true);
                                                                                      }

                                                                                      return false;

                                                                                  }


                                                                              }
                                                                          });
                                                                      </script>

                                                                  </div>
                                                                  <br>
                                                                  <small>
                                                                     <b>Note: The SSID Name is limited to 32 characters and may use a combination of letters, numbers and special characters. The only special characters that may be used are the underscore symbol [_] or the hyphen symbol [-]. Other special characters are not available for SSID names. The SSID Name can not start with prohibited words such as "guest," "administrative," "admin," "test," "demo," or "production." These words cannot be used without other descriptive words. </b>
                                                                  </small>
                                                              </div>
                                                          </div>
                                                          <?php
                                                            if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='YES' || $package_features=="all") {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns">Use
                                                                        Existing Location : </label>

                                                                    <div class="controls col-lg-5 form-group">
                                                                        <div>
                                                                            <select class="span4 form-control" id="old_location_name"
                                                                                    name="old_location_name"
                                                                                    onchange="setNewSSID(this.value)">
                                                                                <option value="">SELECT LOCATION
                                                                                </option>
                                                                                <?php
                                                                                $get_group_tag_q = "SELECT `tag_name` FROM `exp_mno_distributor_group_tag` WHERE `distributor`='$user_distributor' GROUP BY `tag_name`";
                                                                                $get_group_tag_r = mysql_query($get_group_tag_q);
                                                                                while ($get_group_tag = mysql_fetch_assoc($get_group_tag_r)) {
                                                                                    echo '<option value="' . $get_group_tag['tag_name'] . '">' . $get_group_tag['tag_name'] . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select> &nbsp;Or
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <script>
                                                                    function setNewSSID(grout_tag) {
                                                                        if (grout_tag == '') {
                                                                            document.getElementById("location_name").value = '';
                                                                            document.getElementById("location_name").readOnly = false;
                                                                            document.getElementById("loc_label").innerHTML = 'Create a New Location :';
                                                                        } else {
                                                                            document.getElementById("location_name").value = grout_tag;
                                                                            document.getElementById("location_name").readOnly = true;
                                                                            document.getElementById("loc_label").innerHTML = 'Assign Location :';
                                                                        }
                                                                    }
                                                                </script>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns"
                                                                           id="loc_label">Create a New Location
                                                                        : </label>

                                                                    <div>
                                                                        <div class="controls col-lg-5 form-group">
                                                                            <input class="span4 form-control" id="location_name"
                                                                                   name="location_name" type="text"
                                                                                   value="<?php echo ''; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                            }
                                                          ?>
                                                      </fieldset>


                                                      <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET'];?>">
                                                      <div class="form-actions">
                                                          <button type="submit" name="update_ssid" id="update_ssid" class="btn btn-primary">Update</button>

                                                      </div>

                                                  </form>


<h2>SSID Enable</h2>

                                            <?php if(strpos($system_package, 'COX')>-1){ ?>

                                              <p>Choose when you would like for your Guest <?php echo __WIFI_TEXT__; ?> Network to be enabled. Select the correct SSID from the dropdown menu and then choose "Always On" or "Always Off" to manage your Power Schedule under the Configuration menu.</p>

                                              <p>If you enable a Power Schedule, your "Always On" option will be replaced by your "Power Schedule" option. If you disable a Power Schedule, the "Power Schedule" option will be replaced by "Always On" option.</p>
                                               <?php } else{ ?>

                                              <p>Choose when you would like for your Guest <?php echo __WIFI_TEXT__; ?> Network to be enabled. Select the correct SSID from the dropdown menu and then choose "Always On" or "Always Off" to manage your Network Schedule under the Configuration menu.</p>

                                              <p>If you enable a Network Schedule, your "Always On" option will be replaced by your "Network Schedule" option. If you disable a Network Schedule, the "Network Schedule" option will be replaced by "Always On" option.</p> <?php }  ?>
                                                  <div class="widget widget-table action-table">
                                                      <div class="widget-header">
                                                          <!-- <i class="icon-th-list"></i> -->
                                                          <h3></h3>
                                                      </div>
                                                      <div class="widget-content table_response" id="ssid_tb2">


                                                          <div style="overflow-x:auto;" >

                                                      <table class="table table-striped table-bordered" >
                                                          <thead>

                                                          <tr>
                                                              <th>Guest SSID</th>
                                                              <th>SSID Status</th>


                                                          </tr>

                                                          </thead>

                                                          <tbody>
                                                          <?php

                                                          $delete_from_schedule_assign="DELETE FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND `network_method`='GUEST'";
                                                          mysql_query($delete_from_schedule_assign);

                                                          $insert_schedule_assign_guest="INSERT INTO `exp_distributor_network_schedul_assign`(`network_id`,`ssid`,`distributor`,`network_method`,`create_date`,`create_user`)
                                                                                          SELECT  `network_id`,`ssid`,`distributor`,'GUEST',NOW(),'system' FROM `exp_locations_ssid` WHERE `distributor`='$user_distributor'";

                                                          mysql_query($insert_schedule_assign_guest);


                                                          $ssid_assign_q="SELECT ssid,ssid_broadcast,network_id FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND network_method='GUEST'";
                                                          $get_private_ssid_res_assign=mysql_query($ssid_assign_q);

                                                          while($row=mysql_fetch_assoc($get_private_ssid_res_assign)){

                                                            $ssid_name_a=$row['ssid'];
                                                            $b_cast=$row['ssid_broadcast'];
                                                            $netid=$row['network_id'];

                                                           // $zone_id = $db->getValueAsf("SELECT `zone_id` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

                                                            $network_sche_data=$wag_obj->retrieveOneNetwork($zone_id,$netid);

                                                            parse_str($network_sche_data);


                                                            $obj = (array)json_decode(urldecode($Description));
                                                            $she_ar=$obj['schedule'];
                                                            $api_ssid = $obj['ssid'];

                                                            $vlan_ar=$obj['vlan'];
                                                            $vl_ar = json_decode(json_encode($vlan_ar), True);
                                                            $vlanac=$vl_ar[accessVlan];



                                                            $data = get_object_vars($she_ar);

                                                          //  $data['type'];

                                                            //$ssid_name_a

                                                              if($data['id']==NULL){
                                                                  $data['id']="";
                                                              }
                                                              // $data['type'];
                                                              $assign_schedule_update="UPDATE `exp_distributor_network_schedul_assign`
                                                                            SET `ssid_broadcast`='".$data['type']."',`shedule_uniqu_id`='".$data['id']."'
                                                                            WHERE `network_id`='$netid' AND `distributor`='$user_distributor'";
                                                              mysql_query($assign_schedule_update);

                                                              echo'<tr><td>'.$ssid_name_a.'</td>';
                                                              echo'<td data-id="'.$netid.'" data-value="'.$data['type'].'">';

                                                              if($data['type']=='Customized'){

                                                                echo 'Power Schedule';

                                                              }else{

                                                                echo $data['type'];
                                                              }



                                                              echo '</td>';
                                                              echo '</tr>';

                                                              $vlan_upq="UPDATE `exp_locations_ssid` SET `vlan` = '$vlanac' WHERE `network_id`='$netid'";

                                                              $vlan_upq_exe=mysql_query($vlan_upq);

                                                          }

                                                          //echo $vlanac;

                                                          ?>

                                                          </tbody>
                                                          </table>
                                                              </div>
                                                      </div>

                                              </div>



                                    <form id="modify_gst_ssid_broadcast_f" name="modify_gst_ssid_broadcast_f" class="form-horizontal" action="?t=7" method="post">

                                    <fieldset>


                                                          <div class="control-group">
                                                              <label class="control-label" for="radiobtns">Select SSID</label>
                                                              <div >
                                                                  <div class="controls col-lg-5 form-group">
                                                                      <select class="span4 form-control" id="sel_ssid_name" onchange="set_rad(this.value);" name="sel_ssid_name" <?php echo $ssidName; ?> required onchange="loadSSIDForm(this.value)">
                                                                          <option value="">Select SSID</option>
                                                                          <?php
                                                                          $ssid_q="SELECT s.`ssid`,s.`network_id`
                                                                                    FROM
                                                                                        `exp_mno_distributor` d
                                                                                        LEFT JOIN
                                                                                        `exp_locations_ssid` s
                                                                                        ON s.`distributor`=d.`distributor_code`
                                                                                        LEFT JOIN
                                                                                        `exp_mno_distributor_aps` a
                                                                                        ON s.`distributor`= a.`distributor_code`
                                                                                        LEFT JOIN
                                                                                        `exp_locations_ap_ssid` l
                                                                                        ON a.`ap_code`=l.`ap_id`

                                                                                        WHERE  d.`distributor_code`='$user_distributor' AND s.ssid<>''
                                                                                        GROUP  BY   s.`ssid`";
                                                                          $ssid_res=mysql_query($ssid_q);
                                                                          while($ssid_names=mysql_fetch_assoc($ssid_res)){
                                                                              echo'<option value="'.$ssid_names[network_id].'">'.$ssid_names[ssid].'</option>';
                                                                          }
                                                                          ?>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>


                                                          <div class="control-group">
                                                              <label class="control-label" for="radiobtns">SSID Enable</label>
                                                              <div >
                                                                  <div class="controls ">

                                                                      <?php

                                                                      $active_schedule=$db->getValueAsf("SELECT s.uniqu_id AS f  FROM exp_distributor_network_schedul s
                                                                                WHERE s.is_enable='1' AND s.distributor_id='$user_distributor' GROUP BY s.uniqu_id");

                                                                      if($active_schedule==''){
                                                                          ?>
                                                                          <input type="radio" name="ssid_broadcast" id="AlwaysOn" value="AlwaysOn"> Always On &nbsp;

                                                                          <?php
                                                                      }else{
                                                                          ?>
                                                                          <input type="radio" name="ssid_broadcast" id="Customized" value="<?php echo $active_schedule; ?>"> Power Schedule &nbsp;
                                                                          <?php
                                                                      }

                                                                      ?>
                                                              <input type="radio" name="ssid_broadcast" id="AlwaysOff" value="AlwaysOff"> Always Off
                                                              <!-- &nbsp;
                                                              <input type="radio" name="ssid_broadcast" value="Customized"> Use Network Schedule  -->


                                                                  </div>
                                                              </div>
                                                          </div>

                                                        </fieldset>




                                                      <div class="form-actions">
                                                          <button type="submit" name="modify_gst_ssid_broadcast" id="modify_gst_ssid_broadcast" class="btn btn-primary">Update</button>

                                                          <script type="text/javascript">


                                                              $(document).ready(function(){
                                                                  function broadcastSSIDcheck() {

                                                                      $('#modify_gst_ssid_broadcast').attr("disabled", true);

                                                                      if($('#sel_ssid_name').val() !=''){

                                                                          $('#modify_gst_ssid_broadcast').attr("disabled", false);

                                                                      }else{
                                                                          document.getElementById("modify_gst_ssid_broadcast").disabled = true;
                                                                      }
                                                                  }

                                                                  broadcastSSIDcheck();


                                                                  $('#sel_ssid_name').change(function () {
                                                                      broadcastSSIDcheck();
                                                                  });

                                                              });

                                                          </script>
                                                      </div>



                                                </form>





                                              </div>
                                                <!-- Tab 1 End-->
                                        <?php  }

                                        ?>
                                        <?php if(in_array("NET_GUEST_BANDWITH",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($subtab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guestnet_tab_2">
                                            <!-- Tab 7 start-->
                                            <div id="response_d1">

                                            </div>
                                            <h2 style="" id="GUEST_online">Bandwidth Profiles</h2>
                                           <!--  <p>Your guests want great <?php //echo __WIFI_TEXT__; ?> access with great Customer Service.</p>
                                            <br/> -->
                                            <?php if(getOptions('NET_GUEST_BANDWIDTH_TEXT',$system_package,$user_type)=="COX_COMPLEX_001" || $package_features=="all"){?>
                                            <p><b>Step 1.</b> Set your SSID name, confirm bandwidth allocation and conserve
                                                energy by setting the hours
                                                of the day for when your customers can connect.
                                                <br/>
                                               <b><i> EX. Your plan is 50Mbps, allocate 40Mbps to Guest <?php echo __WIFI_TEXT__; ?>, and 10Mbps to Private <?php echo __WIFI_TEXT__; ?></i></b>
                                                </p><p>
                                                <br/>
                                                <b>Step 2.</b> Set the duration of the Free Internet session, you can set values from minutes,
                                                hours to days, months or even years. When a guest session expires, the guest is redirected
                                                to your captive portal and will be bale to activate a new session.
                                                <br/>
                                                <b><i>  EX. 30 minutes</i></b>
                                                <br/>
                                            </p><p>
                                                <b>Step 3.</b> Optionally you can create multiple bandwidth profiles and set the days of the week
                                                that each of the profiles should be applied.
                                                <br/>
                                                <b><i>  EX. 1h session on weekdays and 8h sessions on weekends </i></b>
                                            </p>
                                            <br>
                                                <?php }

                                            if(getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                            ?>

                                            <form id="guest_profile" name="guest_profile" class="form-horizontal" method="post" action="?t=2" >
                                                <fieldset>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Bandwidth Profile Name : </label>
                                                        <div >
                                                            <div class="controls ">
                                                                <input class="span4 form-control" id="guest_profile_name" name="guest_profile_name" type="text" value="<?php echo ''; ?>" required >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                  /*  $get_default_Prof_q="SELECT p.`QOS`  FROM `exp_products_distributor` d , `exp_products` p
                                                                                                WHERE p.`product_code`=d.`product_code` AND d.`distributor_code`='$user_distributor'
                                                                                                AND d.network_type='PRIVATE' AND p.`mno_id`='$distributor_mno' LIMIT 1";
                                                    $get_default_Prof=mysql_query($get_default_Prof_q);
                                                    $default_QOS= mysql_fetch_assoc($get_default_Prof)['QOS']." Mbps"; */


                                                 /*   echo"SELECT p.`QOS` AS f FROM `exp_products_distributor` d , `exp_products` p
                                                                                                WHERE p.`product_code`=d.`product_code` AND d.`distributor_code`='$user_distributor'
                                                                                                AND d.network_type='PRIVATE' AND p.`mno_id`='$distributor_mno' LIMIT 1";
                                                 */

                                                    $default_QOS =$db->getValueAsf("SELECT p.`QOS` AS f FROM `exp_products_distributor` d , `exp_products` p
                                                                                                WHERE p.`product_code`=d.`product_code` AND d.`distributor_code`='$user_distributor'
                                                                                                AND d.network_type='PRIVATE' AND p.`mno_id`='$distributor_mno' LIMIT 1");


                                                    ?>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Bandwidth Allocation : </label>
                                                        <div >
                                                            <div class="controls " style="display: inline-block;margin-left:20px">
                                                                <select class="span2" id="guest_profile_bandwidth" name="guest_profile_bandwidth"  required >
                                                                    <option value="">Select Option</option>
                                                                    <?php
                                                                        $valid_Guest_QOS=(int)$default_QOS-5;
                                                                        $get_guest_prof_q="SELECT   `product_code`,`QOS` FROM `exp_products` WHERE `network_type`='GUEST'  AND `mno_id`='$distributor_mno' AND `QOS`<$valid_Guest_QOS";
                                                                       // $get_guest_prof_q="SELECT `product_code`,`QOS` FROM `exp_products` WHERE `network_type`='GUEST'  AND `mno_id`='$distributor_mno'";

                                                                        $get_guest_prof_res=mysql_query($get_guest_prof_q);
                                                                        while($get_guest_prof=mysql_fetch_assoc($get_guest_prof_res)){
                                                                            echo"<option value=\"".$get_guest_prof[product_code]."/".$get_guest_prof[QOS]."\">".$get_guest_prof[QOS]."</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <strong>&nbsp;&nbsp;Mbps</strong>
                                                            </div><div  style="display: inline-block"><strong>{ Your Current Plan <?php echo $default_QOS." Mbps";  ?>}</strong></div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Internet Session Duration : </label>
                                                        <div >
                                                            <div class="controls ">
                                                                <input class="span1" id="session_time1" name="session_time1" type="number"  required max="30" min="0" onchange="setTimeGap()">
                                                                <select  class="span1" name="session_time_type" id="session_time_type" onchange="setTimeGap()">
                                                                    <option value="D">Days</option>
                                                                    <option value="M">Months</option>
                                                                    <option value="Y">Years</option>
                                                                </select>
                                                                <input class="span1" id="session_time2" name="session_time2" type="number"  required max="60" min="0" onchange="setTimeGap()">
                                                                <select class="span1" name="session_time2_type" id="session_time2_type" onchange="setTimeGap()">
                                                                    <option value="M">Mins</option>
                                                                    <option value="H">Hours</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="active_on">
                                                        <label class="control-label" for="radiobtns">Active : </label>
                                                        <div >
                                                            <script>
                                                                $(document).ready(function(){
                                                                    $("#active_all").click(function(){
                                                                        $("#a :input").prop('checked', this.checked);
                                                                    });

                                                                    $("#a :input").click(function(){
                                                                        if($('.x:checked').length == $('.x').length){
                                                                            $("#active_all").prop('checked', this.checked);
                                                                        }
                                                                        else{
                                                                            $('#active_all').attr('checked', false);
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                            <?php
                                                            $active_guest_on_q="SELECT  d.`active_on`
                                                                                    FROM `exp_products_distributor` d ,`exp_products` p
                                                                                    WHERE d.`product_code`=p.`product_code` AND`distributor_code`='$user_distributor'
                                                                                    AND p.`mno_id`='$distributor_mno' AND d.`network_type`='GUEST'";
                                                            $active_guest_on=mysql_query($active_guest_on_q);
                                                            $active_on=array();
                                                            while($activeon=mysql_fetch_assoc($active_guest_on)){
                                                                array_push($active_on,$activeon['active_on']);
                                                            }
                                                          //  print_r($active_on);
                                                            ?>
                                                            <div class="controls ">
                                                                <input  id="active_all" name="active_all" type="checkbox"  value="all" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(count($active_on)>0){echo "disabled";}?> ><strong>&nbsp;&nbsp;All Week</strong></br>
                                                                <div id="a">
                                                                    <input  id="active_mon" name="active_mon" type="checkbox" class="x" value="Monday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Monday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Mon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_tue" name="active_tue" type="checkbox" class="x" value="Tuesday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Tuesday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Tue&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_wed" name="active_wed" type="checkbox" class="x" value="Wednesday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Wednesday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Wed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_thu" name="active_thu" type="checkbox" class="x" value="Thursday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Thursday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Thu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_fri" name="active_fri" type="checkbox" class="x" value="friday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("friday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Fri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_sat" name="active_sat" type="checkbox" class="x" value="Saturday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Saturday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Sat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                    <input  id="active_sun" name="active_sun" type="checkbox" class="x" value="Sunday" <?php if(in_array('all',$active_on)){echo "checked disabled";}elseif(in_array("Sunday",$active_on)){echo "disabled";}?>><strong>&nbsp;&nbsp;Sun&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="guest_prof_secret" value="<?php echo $_SESSION['FORM_SECRET']?>"/>
                                                    <input type="hidden" name="guest_prof_timegap" id="guest_prof_timegap" value=""/>

                                                    <div class="form-actions">
                                                        <button type="submit" name="set_guest_prof" id="set_guest_prof" class="btn btn-primary">Set</button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                            <?php }


                                            if(getOptions('NET_GUEST_BANDWIDTH_TEXT',$system_package,$user_type)=="COX_SIMPLE_001"){
                                            ?>

                                               <p>You have the ability to manage the bandwidth allocation and active session duration per device. Use the chart below to review your current Guest Access Profile. 

                                                <?php if($sup_available=='YES'){?>

                                                    If you'd like to increase or decrease the amount of bandwidth your guests can use, please contact us at <?php if(strlen($sup_mobile)){echo 'at '.$sup_mobile;} ?>.

                                                <?php }?>


                                                   </p>
                                                   <br>
                                            <?php } ?>

                                            <!-- <h2>Active Profiles</h2>  -->
                                        <br>

                                                    <div class="widget widget-table action-table">
                                                        <div class="widget-header">
                                                            <!-- <i class="icon-th-list"></i> -->
                                                            <h3>Active Profiles</h3>
                                                        </div>

                                                        <div class="widget-content table_response" id="product_tbl">

                                                            <div style="overflow-x:auto;" >
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Download</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Upload</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Active Session Duration</th>
                                                            <?php if(getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                                            ?>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Active on</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Edit</th>
                                                            <?php } ?>

                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                            <?php
                                                                $dist_guest_prof_q="SELECT d.id,d.`product_name`,p.`QOS`,p.`QOS_up_link`,d.`time_gap` , d.`active_on`, d.`duration_prof_code`
                                                                                    FROM `exp_products_distributor` d ,`exp_products` p
                                                                                    WHERE d.`product_code`=p.`product_code` AND`distributor_code`='$user_distributor'
                                                                                    AND p.`mno_id`='$distributor_mno' AND d.`network_type`='GUEST' AND p.`network_type`='GUEST'
                                                                                    GROUP BY d.id";
                                                                $dist_guest_prof_res=mysql_query($dist_guest_prof_q);
                                                            while($dist_guest_prof=mysql_fetch_assoc($dist_guest_prof_res)){
                                                                $prof_id=$dist_guest_prof['id'];
                                                                echo "<tr><td>".$dist_guest_prof['product_name']."</td>";
                                                                echo "<td>".$dist_guest_prof['QOS']." Mbps</td>";
                                                                echo "<td>".$dist_guest_prof['QOS_up_link']." Mbps</td>";

                                                                $timegap1=$dist_guest_prof['time_gap'];
                                                                $du_pro_code=$dist_guest_prof['duration_prof_code'];


                                                                $d_proq="SELECT `duration`,profile_code
                                                                        FROM `exp_products_duration`
                                                                        WHERE `profile_code`='$du_pro_code'";
                                                                $dpro_exe=mysql_query($d_proq);
                                                                while($dup=mysql_fetch_assoc($dpro_exe)){

                                                                    $timegap=$dup['duration'];
                                                                    $profile_code=$dup['profile_code'];

                                                                }


                                                                $gap = "";
                                                                if($timegap != ''){

                                                                    $interval = new DateInterval($timegap);
                                                                    //echo $interval->m;



                                                                    if($interval->y != 0){
                                                                        $gap .= $interval->y.' Years ';
                                                                    }
                                                                    if($interval->m != 0){
                                                                        $gap .= $interval->m.' Months ';
                                                                    }
                                                                    if($interval->d != 0){
                                                                        $gap .= $interval->d.' Days ';
                                                                    }
                                                                    if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
                                                                        $gap .= ' And ';
                                                                    }
                                                                    if($interval->h != 0){
                                                                        $gap .= $interval->h.' Hours ';
                                                                    }
                                                                    if($interval->i != 0){
                                                                        $gap .= $interval->i.' Minutes ';
                                                                    }

                                                                }

                                                                echo "<td><form style='margin-bottom:0px !important;' action='?t=2' method='post'>
                                                                        <select style='margin-bottom:0px !important;' name='du_value' class='span2'>";


                                                                if($timegap1==$timegap){

                                                                    $sel_0='selected';
                                                                }else{

                                                                    $sel_0='';
                                                                }

                                                                    echo "<option ".$sel_0." value='".$profile_code."'>".$gap."</option>";

                                                            $def_durationq="SELECT * FROM `exp_products_duration` WHERE `is_default`='1' AND `distributor`='$distributor_mno'";

                                                            $def_durationq_exe=mysql_query($def_durationq);
                                                            while($defduraw=mysql_fetch_assoc($def_durationq_exe)){

                                                                $de_du=$defduraw['duration'];
                                                                $de_du_code=$defduraw['profile_code'];
                                                                if($timegap==$de_du){
                                                                    continue;
                                                                }


                                                                if($timegap1==$de_du){

                                                                    $sel_1='selected';

                                                                }else{

                                                                    $sel_1='';

                                                                }



                                                                $gap = "";
                                                                if($de_du != ''){

                                                                    $interval = new DateInterval($de_du);
                                                                    //echo $interval->m;



                                                                    if($interval->y != 0){
                                                                        $gap .= $interval->y.' Years ';
                                                                    }
                                                                    if($interval->m != 0){
                                                                        $gap .= $interval->m.' Months ';
                                                                    }
                                                                    if($interval->d != 0){
                                                                        $gap .= $interval->d.' Days ';
                                                                    }
                                                                    if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
                                                                        $gap .= ' And ';
                                                                    }
                                                                    if($interval->i != 0){
                                                                        $gap .= $interval->i.' Minutes ';
                                                                    }
                                                                    if($interval->h != 0){
                                                                        $gap .= $interval->h.' Hours ';
                                                                    }
                                                                }


                                                                echo "<option ".$sel_1." value='".$de_du_code."'>".$gap."</option>";



                                                            }



                                                                echo "</select>
                                                                        ";

                                                        echo '<input type="hidden" name="du_id" value="'.$prof_id.'">';

                                                        echo "<button style='margin-left: 5px; margin-top: 5px;float: right;'
                                                            type='submit' name='du_pro_change' id='du_pro_change' class='btn btn-small btn-primary'>Update</button></td>";

                                                             if(getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                                                echo "<td>";
                                                                if($dist_guest_prof['active_on'] == 'all'){
                                                                    echo 'All Week';
                                                                }
                                                                else{
                                                                    echo $dist_guest_prof['active_on'];
                                                                }

                                                                echo "</td>";

                                                                echo  '<td><a href="javascript:void();" id="PROF_' . $prof_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>&nbsp;
                                                                        <img id="ap_loader_' . $prof_id . '" src="img/loading_ajax.gif" style="visibility: hidden;">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#PROF_' . $prof_id . '\').easyconfirm({locale: {
                                                                                title: \'Product Remove [' . $dist_guest_prof['product_name'] . ']\',
                                                                                text: \'Are you sure you want to remove this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#PROF_' . $prof_id . '\').click(function() {
                                                                                window.location = "?prof_rm_token=' . $_SESSION['FORM_SECRET'] . '&t=2&remove_prof_id=' . $prof_id . '"
                                                                            });
                                                                            });
                                                                        </script>
                                                                        <a href="javascript:void();" id="PROF_ED_' . $prof_id . '"  class="btn btn-small btn-info">
                                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a>&nbsp;
                                                                        <img id="ap_loader_' . $prof_id . '" src="img/loading_ajax.gif" style="visibility: hidden;">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#PROF_ED_' . $prof_id . '\').easyconfirm({locale: {
                                                                                title: \'Product Edit [' . $dist_guest_prof['product_name'] . ']\',
                                                                                text: \'Are you sure you want to edit this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#PROF_ED_' . $prof_id . '\').click(function() {
                                                                                window.location = "?prof_ed_token=' . $_SESSION['FORM_SECRET'] . '&t=5&edit_prof_id=' . $prof_id . '"
                                                                            });
                                                                            });
                                                                        </script>

                                                                        </td>'; }
                                                                echo'</tr></form>';
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>

                                                                </div>
                                                    </div>
                                                </div>

                                            <!-- Tab 7 start-->
                                        </div>
                                        <?php } ?>
                                        <!-- manage_product time gap -->
                                        <?php if($edit_prof_timegap==1 || $edit_prof==1){
                                       ?>
                                        <div <?php if(isset($subtab5)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="edit_product">
                                            <form class="form-horizontal" method="post" action="?t=2" novalidate>
                                                <fieldset>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Profile Code : </label>
                                                        <div >
                                                            <div class="controls ">
                                                                <input readonly class="span4 form-control" id="guest_profile_name" name="guest_profile_name" type="text" value="<?php echo $edit_product_code; ?>" required >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Profile Name : </label>
                                                        <div >
                                                            <div class="controls ">
                                                                <input readonly class="span4 form-control" id="guest_profile_name" name="guest_profile_name" type="text" value="<?php echo $edit_product_name; ?>" required >
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    $mg_num1 = 0;
                                                    $mg_num2 = 0;
                                                    $gap = "";
                                                    if($edit_product_time != ''){

                                                    $interval = new DateInterval($edit_product_time);
                                                    //                var_dump($interval) ;



                                                    if($interval->y != 0){
                                                    $mg_select1 = 'Y';
                                                    $mg_num1 = $interval->y;
                                                    }
                                                    if($interval->m != 0){
                                                    $mg_select1 = 'M';
                                                    $mg_num1 = $interval->m;
                                                    }

                                                    if($interval->d != 0){
                                                    $mg_select1 = 'D';
                                                    $mg_num1 = $interval->d;
                                                    }

                                                    if($interval->i != 0){
                                                    $mg_select2 = 'M';
                                                    $mg_num2 = $interval->i;
                                                    }
                                                    if($interval->h != 0){
                                                    $mg_select2 = 'H';
                                                    $mg_num2 = $interval->h;
                                                    }
                                                    }

                                                ?>
                                                    <div class="control-group">
                                                        <label class="control-label" for="radiobtns">Internet Session Duration : </label>
                                                        <div >
                                                            <div class="controls ">
                                                                <input class="span1" id="edit_session_time1" name="session_time1" type="number" value="<?php echo $mg_num1?>" required max="30" min="0" onchange="setTimeGapEditProduct()">
                                                                <select  class="span1" name="session_time_type" id="edit_session_time_type" onchange="setTimeGapEditProduct()">
                                                                    <?php
                                                                    if($mg_dis_select1 == "D"){
                                                                        echo '<option value="D" selected>Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y">Years</option>';
                                                                    }
                                                                    else if($mg_dis_select1 == "M"){
                                                                        echo '<option value="D">Days</option>
                                                                                            <option value="M" selected>Months</option>
                                                                                            <option value="Y">Years</option>';
                                                                    }
                                                                    else if($mg_dis_select1 == "Y"){
                                                                        echo '<option value="D">Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y" selected>Years</option>';
                                                                    }else{
                                                                        echo '<option value="D">Days</option>
                                                                                            <option value="M">Months</option>
                                                                                            <option value="Y">Years</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <input class="span1" id="edit_session_time2" name="session_time2" type="number" value="<?php echo $mg_num2?>" required max="60" min="0" onchange="setTimeGapEditProduct()">
                                                                <select class="span1" name="session_time2_type" id="edit_session_time2_type" onchange="setTimeGapEditProduct()">
                                                                    <?php
                                                                    if($mg_dis_select2 == "M"){

                                                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H">Hours</option>';
                                                                    }
                                                                    else if($mg_dis_select2 == "H"){

                                                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H" selected>Hours</option>';
                                                                    }else{

                                                                        echo '<option value="M" selected>Minutes</option>
                                                                                        <option value="H" selected>Hours</option>';
                                                                    }

                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="new_time_gap" id="new_time_gap" value="<?php echo $edit_product_time;?>">
                                                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $edit_prof_id;?>">
                                                    <input type="hidden" name="form_secret" id="form_secret" value="<?php echo $_SESSION['FORM_SECRET'];?>" >
                                                    <div class="form-actions">
                                                        <button type="submit" name="mg_product_edit2" id="mg_product_edit2" class="btn btn-primary">Update</button>
                                                    </div>

                                                </fieldset>
                                            </form>
                                        </div>
                                        <?php
                                        } ?>

<!-- /////////////////////////////////////////// -->

                                     <?php  if(in_array("NET_AP_NAME",$features_array) || $package_features=="all"){?>
                                          <div <?php if(isset($subtab15)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_15">
                                        <!-- Tab 1 start-->

                                        <?php
                                        /**
                                         * 3/25/2016 9:30:01 AM
                                         * alert if sync now success or failed
                                         */
                                        if(isset($_SESSION['tab15'])){
                                            echo$_SESSION['tab15'];
                                            unset($_SESSION['tab15']);
                                        }

                                        ?>




                                        <div id="guest_modify_network"></div>

                                              <h2>SSID Name Modification</h2>
                                              <p><b><i>&nbsp;&nbsp;&nbsp;&nbsp;So your guests can easily identify and connect</i></b></p><br/>

                                              <p>
                                                  <b> Step 1.</b> Review and [optional] modify the SSID Name.
                                                  If this is your first log-in, the SSID shown in the table below is the one provided with your order,
                                                  else it is the name you modified last.
                                                  Note: The Location field is your ICOMS number.

                                              </p>
                                              <b><i>EX. 9th Avenue</i></b>
                                                    <br/>
                                                    <br/>

                                              <?php if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='NO' ) {

                                              ?>

                                            <div class="controls col-lg-5 form-group" style="display:inline-block;">
                                                <a href="?t=15&st=15&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                            </div>
                                             <br/>
                                              </br>

                                              <?php } ?>

                                              <form id="update_default_qos_table" name="update_default_qos_table" class="form-horizontal" action="?t=15" method="post">

                                                  <div class="widget widget-table action-table">
                                                      <div class="widget-header">
                                                          <!-- <i class="icon-th-list"></i> -->
                                                          <h3></h3>
                                                      </div>
                                                    <div class="widget-content table_response" id="ssid_tbl">
                                                        <div style="overflow-x:auto;" >
                                                      <table class="table table-striped table-bordered" >
                                                          <thead>
                                                              <tr>

                                                               <!-- <th>AP MAC Address</th> -->
                                                              <!--    <th>WLAN Name</th>  -->
                                                                  <th>Guest SSID</th>
                                                                  <th>AP Code</th>
                                                                  <th>ICOMS #</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                          <?php
                                                          $ssid_q="SELECT `ap_id`,`location_ssid`,`group_tag`
                                                                        FROM `exp_locations_ap_ssid`
                                                                        WHERE `distributor`='$user_distributor'";
                                                          $ssid_res=mysql_query($ssid_q);
                                                          $i=0;
                                                          while($ssid_name=mysql_fetch_assoc($ssid_res)){
                                                           //   echo'<input type="hidden" name="network_id" value="'.$ssid_name['network_id'].'">';
                                                           //   echo'<input type="hidden" name="description" value="'.$ssid_name['description'].'">';
                                                          //    echo "<tr><td>".$ssid_name['ap_code']."</td>";

                                                            echo "<input type='hidden' name='ap[$i]' value='$ssid_name[ap_code]'/>";

                                                            echo  "<td>".$ssid_name['location_ssid']."</td>";
                                                            echo  "<td>".$ssid_name['ap_id']."</td>";
                                                            echo    "<td>".$ssid_name['group_tag']."</td></tr>";
                                                            //  $ssidName=$ssid_name['ssid'];
                                                            //  $wlanId=$ssid_name['wlan_name'];


                                                              $i++;
                                                          }

                                                          ?>
                                                          </tbody>
                                                          </table>
                                                            </div>
                                                  </div>
                                              </div><br/>

                                                      <fieldset>
                                                          <div class="control-group">
                                                              <label class="control-label" for="ssid_name">Current SSID Name : </label>
                                                              <div class="controls col-lg-5 form-group">



                                                                      <select required class="span4 form-control" id="ssid_name" name="ssid_name" <?php echo $ssidName; ?> onchange="loadSSIDForm(this.value)">
                                                                          <option value="">Select SSID</option>
                                                                          <?php
                                                                          $ssid_q="SELECT s.`ssid`
                                                                                    FROM `exp_locations_ssid` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d
                                                                                  WHERE s.`distributor`=d.`distributor_code` AND s.`distributor`= a.`distributor_code` AND s.`distributor`='$user_distributor' GROUP BY s.`ssid`";
                                                                          $ssid_res=mysql_query($ssid_q);
                                                                          while($ssid_names=mysql_fetch_assoc($ssid_res)){
                                                                              echo'<option value="'.$ssid_names[ssid].'">'.$ssid_names[ssid].'</option>';
                                                                          }
                                                                          ?>
                                                                      </select>
                                                                      <script>
                                                                          function loadSSIDForm(ssid){
                                                                            /*  alert(ssid);    */
                                                                              var ssid=ssid;
                                                                              var formData={ssid:ssid,dis:"<?php echo $user_distributor; ?>"};
                                                                              $.ajax({
                                                                                  url : "ajax/getSsidDetails.php",
                                                                                  type: "POST",
                                                                                  data : formData,
                                                                                  success: function(data)
                                                                                  {
                                                                                   /*   alert(data);   */
                                                                                      var data_array = data.split(',');

                                                                                      document.getElementById("network_id").value=data_array[1];
                                                                                      document.getElementById("wlan_name").value=data_array[0];
                                                                                  },
                                                                                  error: function (jqXHR, textStatus, errorThrown)
                                                                                  {

                                                                                  }
                                                                              });
                                                                          }
                                                                      </script>
                                                                      <input  id="wlan_name" name="wlan_name" type="hidden" value="" >
                                                                      <input  id="network_id" name="network_id" type="hidden" value="" >


                                                              </div>
                                                          </div>
                                                          <div class="control-group">
                                                              <label class="control-label" for="mod_ssid_name">New SSID Name : </label>
                                                              <div >
                                                                  <div class="controls col-lg-5 form-group">
                                                                      <input required class="span4 form-control" id="mod_ssid_name" name="mod_ssid_name" type="text" value="<?php echo ''; ?>">
                                                                      <script type="text/javascript">

                                                                          $("#mod_ssid_name").keypress(function(event){
                                                                              var ew = event.which;
                                                                              if(ew==8 || ew==0 )
                                                                                  return true;
                                                                              if(48 <= ew && ew <= 57)
                                                                                  return true;
                                                                              if(65 <= ew && ew <= 90)
                                                                                  return true;
                                                                              if(97 <= ew && ew <= 122)
                                                                                  return true;
                                                                              return false;


                                                                          });

                                                                          $("#mod_ssid_name").blur(function(event){
                                                                              var temp_ssid_name=$('#mod_ssid_name').val();
                                                                              if(checkWords(temp_ssid_name.toLowerCase())){

                                                                                  $("#mod_ssid_name").val("");
                                                                                  $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                  $('#update_ssid').attr('disabled', true);
                                                                              }
                                                                          });

                                                                          $("#mod_ssid_name").keyup(function(event){

                                                                              var temp_ssid_name;
                                                                              temp_ssid_name=$('#mod_ssid_name').val();
                                                                              var lastChar = temp_ssid_name.substr(temp_ssid_name.length - 1);
                                                                              var lastCharCode = lastChar.charCodeAt(0);

                                                                              if(!((lastCharCode==8 || lastCharCode==0 )||(48 <= lastCharCode && lastCharCode <= 57) ||
                                                                                  (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                                  (97 <= lastCharCode && lastCharCode <= 122))){
                                                                                  $("#mod_ssid_name").val(temp_ssid_name.substring(0, temp_ssid_name.length-1));
                                                                              }

                                                                              temp_ssid_name=$('#mod_ssid_name').val();
                                                                              if(checkWords(temp_ssid_name.toLowerCase())){

                                                                                  $("#mod_ssid_name").val("");
                                                                                  $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                  $('#update_ssid').attr('disabled', true);
                                                                              }
                                                                          });


                                                                          function past(){

                                                                              setTimeout(function () {

                                                                                  var temp_ssid_name=$('#mod_ssid_name').val();
                                                                                  if(checkWords(temp_ssid_name.toLowerCase())){

                                                                                      $("#mod_ssid_name").val("");
                                                                                      $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                                                      $('#update_ssid').attr('disabled', true);
                                                                                  }

                                                                              }, 0);

                                                                          }


                                                                          function checkWords(inword){

                                                                              var words =<?php
                                                                                  $words=$db->getValueAsf("SELECT `policies` AS f FROM `exp_policies` WHERE `policy_code`='SSID_name'");
                                                                                  $words_ar=explode(",",$words);
                                                                                  $script_ar='[';
                                                                                  for($i=0;$i<count($words_ar);$i++){
                                                                                      $script_ar.="\"".$words_ar[$i]."\",";
                                                                                  }

                                                                                  $script_ar=rtrim($script_ar,",");
                                                                                  $script_ar.="]";
                                                                                  echo$script_ar;

                                                                                  ?>;

                                                                              if(words.indexOf(inword)>=0)
                                                                                  return true;
                                                                              return false;
                                                                          }
                                                                      </script>

                                                                  </div>
                                                              </div>
                                                          </div>

                                                          <div class="control-group">
                                                              <label class="control-label" for="ssid_name">AP Code : </label>
                                                              <div class="controls col-lg-5 form-group">



                                                                      <select required class="span4 form-control" id="ap_code" name="ap_code">
                                                                          <option value="">SELECT AP</option>
                                                                          <?php
                                                                          $ap_q="SELECT a.`ap_code`
                                                                                    FROM `exp_locations_ssid` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d
                                                                                  WHERE s.`distributor`=d.`distributor_code` AND s.`distributor`= a.`distributor_code` AND s.`distributor`='$user_distributor' GROUP BY a.`ap_code`";
                                                                          $ap_res=mysql_query($ap_q);
                                                                          while($ssid_names=mysql_fetch_assoc($ap_res)){
                                                                              echo'<option value="'.$ssid_names[ap_code].'">'.$ssid_names[ap_code].'</option>';
                                                                          }
                                                                          ?>
                                                                      </select>


                                                              </div>
                                                          </div>


                                                          <?php
                                                            if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='YES' || $package_features=="all") {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns">Use
                                                                        Existing Location : </label>

                                                                    <div class="controls col-lg-5 form-group">
                                                                        <div>
                                                                            <select class="span4 form-control" id="old_location_name"
                                                                                    name="old_location_name"
                                                                                    onchange="setNewSSID1(this.value)">
                                                                                <option value="">SELECT LOCATION
                                                                                </option>
                                                                                <?php
                                                                                $get_group_tag_q = "SELECT `tag_name` FROM `exp_mno_distributor_group_tag` WHERE `distributor`='$user_distributor' GROUP BY `tag_name`";
                                                                                $get_group_tag_r = mysql_query($get_group_tag_q);
                                                                                while ($get_group_tag = mysql_fetch_assoc($get_group_tag_r)) {
                                                                                    echo '<option value="' . $get_group_tag['tag_name'] . '">' . $get_group_tag['tag_name'] . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select> &nbsp;Or
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <script>
                                                                    function setNewSSID1(grout_tag) {
                                                                        if (grout_tag == '') {
                                                                            document.getElementById("location_name1").value = '';
                                                                            document.getElementById("location_name1").readOnly = false;
                                                                            document.getElementById("loc_label1").innerHTML = 'Create a New Location :';
                                                                        } else {
                                                                            document.getElementById("location_name1").value = grout_tag;
                                                                            document.getElementById("location_name1").readOnly = true;
                                                                            document.getElementById("loc_label1").innerHTML = 'Assign Location :';
                                                                        }
                                                                    }
                                                                </script>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns"
                                                                           id="loc_label1">Create a New Location
                                                                        : </label>

                                                                    <div>
                                                                        <div class="controls col-lg-5 form-group">
                                                                            <input class="span4 form-control" id="location_name1"
                                                                                   name="location_name" type="text"
                                                                                   value="<?php echo ''; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                            }
                                                          ?>
                                                      </fieldset>
                                              </br>

                                                      <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET'];?>">
                                                      <div class="form-actions">
                                                          <button type="submit" name="update_ssid_ap" id="update_ssid_ap" class="btn btn-primary">Update</button>
                                                      </div>

                                                  </form>



                                              </div>
                                                <!-- Tab 1 End-->
                                        <?php  }

                                    ?>
