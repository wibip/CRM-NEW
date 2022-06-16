<div
    <?php if (isset($tab_pending_mno)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
    id="pending_mno">

    <div class="" style="display:none;">
        <div class="header_hr"></div>
        <div class="header_f1" style="width: 100%;">
            Historical Sessions
        </div>
        <br class="hide-sm"><br class="hide-sm">
        <div class="header_f2" style="width: 100%;"></div>
    </div>


    <p>To send an automatic email invitation to the Operations Manager,
        click on "Email" link.This email contains the Operations Admin
        account activation information.</p>
    <div class="widget widget-table action-table">

        <div class="widget-header">

            <!--  <i class="icon-th-list"></i> -->

            <h3>
                Saved <?php echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'"); ?></h3>

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


                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="5">CONTROLLER
                        </th>
                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="3">ADMIN
                        </th>

                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="4">Email
                        </th>


                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="6">Remove
                        </th>
                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="2">Edit
                        </th>

                        <th scope="col" data-tablesaw-sortable-col
                            data-tablesaw-priority="1">SEND
                        </th>


                    </tr>

                    </thead>

                    <tbody>


                    <?php

if ($user_type == 'RESELLER_ADMIN') {


    
    $key_query="SELECT GROUP_CONCAT(DISTINCT c.ap_controller ) AS ap_cont, m.mno_description,m.mno_id,t.full_name, t.email,t.is_enable,'In Active' AS s FROM exp_mno m LEFT JOIN `exp_mno_ap_controller` c ON c.mno_id=m.mno_id 
    LEFT JOIN (SELECT DISTINCT u.user_distributor AS mno,u.full_name, u.email,u.is_enable,u.id,u.`admin` FROM admin_users u WHERE u.user_type = 'MNO' AND u.`access_role`='admin'  GROUP BY u.user_distributor ORDER BY u.id) t  ON t.mno = m.mno_id
    WHERE t.`is_enable`=2 and t.`admin`='RESELLER_ADMIN'  GROUP BY m.mno_id ORDER BY mno_description";

}else{

                    $key_query="SELECT GROUP_CONCAT(DISTINCT c.ap_controller ) AS ap_cont, m.mno_description,m.mno_id,t.full_name, t.email,t.is_enable,'In Active' AS s FROM exp_mno m LEFT JOIN `exp_mno_ap_controller` c ON c.mno_id=m.mno_id 
                         LEFT JOIN (SELECT DISTINCT u.user_distributor AS mno,u.full_name, u.email,u.is_enable,u.id FROM admin_users u WHERE u.user_type IN ('MNO','RESELLER_ADMIN') AND u.`access_role`='admin'  GROUP BY u.user_distributor ORDER BY u.id) t  ON t.mno = m.mno_id
                         WHERE t.`is_enable`=2 GROUP BY m.mno_id ORDER BY mno_description";

}
                   /*$key_query = "SELECT group_concat(DISTINCT c.ap_controller ) AS ap_cont, m.mno_description,m.mno_id,u.full_name, u.email,u.is_enable,'In Active' AS s
                        FROM exp_mno m LEFT JOIN `exp_mno_ap_controller` c ON c.mno_id=m.mno_id, admin_users u
                        WHERE u.user_type = 'MNO' AND u.user_distributor = m.mno_id AND u.`access_role`='admin' AND m.`is_enable`=2
                        GROUP BY m.mno_id
                        ORDER BY mno_description";*/

                    $query_results = $db->selectDB($key_query);

                    foreach ($query_results['data'] AS $row) {

                        $mno_description = $row[mno_description];
                        $mno_id = $row[mno_id];
                        $full_name = $row[full_name];
                        $email = $row[email];
                        $s = $row[s];
                        $is_enable = $row[is_enable];
                        $ap_cont = $row[ap_cont];


                        echo '<tr>

                        <td> ' . $mno_description . ' </td>
                        <td> ' . $ap_cont . ' </td>

                        <td> ' . $full_name . ' </td>
                        <td> ' . $email . ' </td>';

                        echo '<td><a href="javascript:void();" id="REMMNOACC_' . $mno_id . '"  class="btn btn-small btn-primary">

                                                                <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                            $(document).ready(function() {
                                                            $(\'#REMMNOACC_' . $mno_id . '\').easyconfirm({locale: {
                                                                    title: \'Account Remove\',
                                                                    text: \'Are you sure you want to remove[ ' . $db->escapeDB($mno_description) . ' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});

                                                                $(\'#REMMNOACC_' . $mno_id . '\').click(function() {
                                                                    window.location = "?token10=' . $secret . '&t=pending_mno&remove_mno_id=' . $mno_id . '"

                                                                });

                                                                });

                                                            </script></td>
                        ' .
                            //*********************************** Remove  *****************************************

                            '<td><a href="javascript:void();" id="EDITMNOACC2_' . $mno_id . '" class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITMNOACC2_' . $mno_id . '\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITMNOACC2_' . $mno_id . '\').click(function() {
                                                            window.location = "?token10=' . $secret . '&t=create_mno&edit_mno_id=' . $mno_id . '"

                                                        });

                                                        });

                                                    </script></td>' .
                            '<td>
                        <a href="javascript:void();" id="MAIL_' . $mno_id . '"  class="btn btn-danger btn-small">

                                                                <i class="btn-icon-only icon-envelope"></i>&nbsp;Email</a><script type="text/javascript">

                                                            $(document).ready(function() {
                                                            $(\'#MAIL_' . $mno_id . '\').easyconfirm({locale: {
                                                                    title: \'Send Mail\',
                                                                    text: \'Are you sure you want to send mail?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});

                                                                $(\'#MAIL_' . $mno_id . '\').click(function() {
                                                                    window.location = "?t=pending_mno&tokenmail=' . $secret . '&send_mail_mno_id=' . $mno_id . '"

                                                                });

                                                                });

                                                            </script></td>'//****************************************************************************************
                        ;


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