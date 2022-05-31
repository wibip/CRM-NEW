<div
    <?php if (isset($tab_active_mno)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
    id="active_mno">

    <div class="" style="display:none;">
        <div class="header_hr"></div>
        <div class="header_f1" style="width: 100%;">
            Historical Sessions
        </div>
        <br class="hide-sm"><br class="hide-sm">
        <div class="header_f2" style="width: 100%;"></div>
    </div>


    <div id="response_d1">


    </div>
    <div class="widget widget-table action-table">

        <div class="widget-header">

            <!-- <i class="icon-th-list"></i> -->

            <h3>
                Active <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'"); ?></h3>

        </div>

        <!-- /widget-header -->

        <div class="widget-content table_response">
            <div style="overflow-x:auto">

                <table class="table table-striped table-bordered tablesaw"
                       data-tablesaw-mode="columntoggle"
                       data-tablesaw-minimap>

                    <thead>

                    <tr>

                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="persist"><?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'"); ?></th>

                        <!--    <th><?php //echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'");
                        ?> Code</th>

                                                                <th>Full Name</th>

                                                                <th>Email</th> -->

                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="1">Controller
                        </th>

                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="2">Edit
                        </th>
                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="3">Remove
                        </th>


                    </tr>

                    </thead>

                    <tbody>


                    <?php

if ($user_type == 'RESELLER_ADMIN') {

    $key_query = "SELECT m.mno_description,m.mno_id,u.full_name, u.email , u.verification_number
    FROM exp_mno m, admin_users u
    WHERE u.user_type = 'MNO' AND u.user_distributor = m.mno_id AND u.`is_enable`=1 AND u.`access_role`='admin' and u.`admin`='RESELLER_ADMIN' 
    GROUP BY m.mno_id
    ORDER BY mno_description ";

}else{
                    $key_query = "SELECT m.mno_description,m.mno_id,u.full_name, u.email , u.verification_number
FROM exp_mno m, admin_users u
WHERE u.user_type IN ('MNO','RESELLER_ADMIN') AND u.user_distributor = m.mno_id AND u.`is_enable`=1 AND u.`access_role`='admin' 
GROUP BY m.mno_id
ORDER BY mno_description ";
}

                    $query_results = $db->selectDB($key_query);

                    foreach ($query_results['data'] AS $row) {

                        $mno_description = $row[mno_description];
                        $mno_id = $row[mno_id];
                        $full_name = $row[full_name];
                        $email = $row[email];
                        $s = $row[s];
                        $is_enable = $row[is_enable];
                        $icomm_num = $row[verification_number];


                        $key_query01 = "SELECT ap_controller
                                                                            FROM exp_mno_ap_controller
                                                                            WHERE mno_id='$mno_id'";

                        $query_results01 = $db->selectDB($key_query01);

                        $ap_c = "";

                        
                        foreach ($query_results01['data'] AS $row1) {

                            $apc = $row1[ap_controller];

                            $ap_c .= $apc . ',';


                        }


                        echo '<tr>

                                                                    <td> ' . $mno_description . ' </td>
                                                                    <td> ' . trim($ap_c, ",") . ' </td> ';


                        //echo '<td> '.$mno_id.' </td><td> '.$full_name.' </td><td> '.$email.' </td>';


                        echo '<td> ' .

                            //******************************** Edit ************************************
                            '<a href="javascript:void();" id="EDITMNOACC_' . $mno_id . '"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITMNOACC_' . $mno_id . '\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITMNOACC_' . $mno_id . '\').click(function() {
                                                            window.location = "?token10=' . $secret . '&t=create_mno&edit_mno_id=' . $mno_id . '"

                                                        });

                                                        });

                                                    </script></td>';


                        $distributor_exi = "SELECT * FROM `exp_mno_distributor` WHERE mno_id = '$mno_id'";

                        $query_results01 = $db->selectDB($distributor_exi);
                        $count_records_exi = $query_results01['rowCount'];


                        if ($count_records_exi == 0) {

                            //*********************************** Remove  *****************************************
                            echo '<td><a href="javascript:void();" id="REMMNOACC_' . $mno_id . '"  class="btn btn-small btn-danger">

                                                 <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                                        $(document).ready(function() {
                                                                        $(\'#REMMNOACC_' . $mno_id . '\').easyconfirm({locale: {
                                                                                title: \'Account Remove\',
                                                                                text: \'Are you sure you want to remove[ ' . $db->escapeDB($mno_description) . ' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});

                                                                            $(\'#REMMNOACC_' . $mno_id . '\').click(function() {
                                                                                window.location = "?token10=' . $secret . '&t=active_mno&remove_mno_id=' . $mno_id . '"

                                                     });
                                                    });
                                                   </script>';


                        } else {

                            echo '<td><a class="btn btn-small btn-warning" disabled >&nbsp;<i class="btn-icon-only icon icon-lock"></i>Remove</a></center>';
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