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
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Product Update</th>
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
                    $dist_guest_prof_res=$db->selectDB($dist_guest_prof_q);
                    
                    foreach ($dist_guest_prof['data'] AS $row) {
                        $prof_id=$dist_guest_prof['id'];
                        echo "<tr><td>".$dist_guest_prof['product_name']."</td>";
                        // echo "<td>".$dist_guest_prof['QOS']." Mbps</td>";
                        //echo "<td>".$dist_guest_prof['QOS_up_link']." Mbps</td>";

                        echo "<td><form style='margin-bottom:0px !important;' action='?t=75' method='post'>
                                                                <select style='margin-bottom:0px !important;' name='qos_value' class='span3'>";

                        $qos_query ="SELECT `product_id`,`product_name` FROM `exp_products` WHERE `mno_id`='$distributor_mno' ";

                        $qos_query_ex =$db->selectDB($qos_query);

                       
                        foreach ($qos_query_ex['data'] AS $qos_query_result) {

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