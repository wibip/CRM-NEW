<div <?php if(isset($tab_active_sessions)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="active_sessions">



                                                
                                                <p>

                                                </p>

                                                <form id="edit-profile" action="?t=active_sessions" method="post" class="form-horizontal" >


                                                    <fieldset>



                                                        <div class="control-group">
                                                            

                                                            <div class="controls">
                                                                <h3>Session Search</h3>
                                                                <br>
                                                                <label class="" for="radiobtns">Limit Search to</label>

                                                                <div class="input-prepend input-append">
                                                                    <select style="    margin-right: 20px;    margin-bottom: 15px;" class="span4" name="vanue_id" id="vanue_id" required>
                                                                        <option value="all">ALL Venues</option>

                                                                        <?php

                                                                        $key_query = "SELECT d.`distributor_name`,d.`distributor_code`,d.`verification_number` FROM `exp_mno_distributor` d,`exp_distributor_groups` g
                                                                                WHERE d.`distributor_code`=g.`distributor`
                                                                                AND `mno_id`='$user_distributor' ORDER BY d.`verification_number` ASC";

                                                                        $query_results=$db->selectDB($key_query);
                                                                        foreach ($query_results['data'] as $row) {
                                                                            $distributor_code = $row[distributor_code];
                                                                            $distributor_name = $row[verification_number];

                                                                            echo '<option value="'.$distributor_name.'">'.$distributor_name.'</option>';
                                                                        }

                                                                        ?>


                                                                    </select>
                                                                    <button style="    padding: 6px 20px !important;
    margin-bottom: 15px;" class="btn btn-primary" type="submit" name="search_btn_session" id="search_btn_session">Search</button>

                                                                </div>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                    </fieldset>


                                    <?php if($search_btn_session|| isset($_GET['search_id'])){
                                        if(isset($_GET['search_id'])){
                                            $vanue_id= $_GET['search_id'];
                                        }

                                        ?>
                                                    <div class="widget widget-table action-table">
                                                        <div class="widget-header">
                                                           <!--  <i class="icon-th-list"></i> -->

                                                            <h3>Session Search Result</h3>
                                                        </div>
                                                        <!-- /widget-header -->
                                                        <div class="widget-content table_response">
                                                            <div style="overflow-x:auto">           
                                                            <table id="session_search_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">DEVICE MAC</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">AP MAC/GW MAC</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Session State</th>
                                                                    <?php if($private_module==1){ ?>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Session Type</th>
                                                                    <?php } ?>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">START TIME</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">SSID</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Customer Account# (realm)</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">GATEWAY IP</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">GATEWAY TYPE</th>


                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Delete
                                                                        <img id="tooltip1" data-toggle="tooltip" title="Redirect Session deletion may take up to several minutes to be recognized and removed from the table. If deletion is a success wait 2 minutes and then refresh this page." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 0px;cursor: pointer;display:  inline-block;"></th>


                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php

                       
                                       
                                        if($search_btn_session || isset($_GET['search_id'])){

                                           
                                           //print_r($newjsonvalue[0]);
                                           if ($newjsonvalue) {
                                            $res_arrr=array();
                                            
                                            
                                            //print_r($res_arrr2);
                                            //echo $session_id;
                                           $session_row_count=0;
                                            foreach ($newjsonvalue as $value2){
                                                //print_r($res_arrr);
                                                $session_row_count=$session_row_count+1;
                                                
                                                echo "<tr>";
                                                $mac=($value2['Mac']);
                                                $AP_Mac=($value2['AP_Mac']);
                                                $nas_type=($value2['Nas-Type']);
                                                $ssid=($value2['SSID']);
                                                $GW_ip=($value2['GW_ip']);
                                                $sh_realm=($value2['Realm']);
                                                $GW_Type=($value2['GW-Type']);
                                                $start_time=(date_convert($value2['Session-Start-Time']));
                                                $newstatus=$value2['State'];
                                                $type= $value2['TYPE'];
                                                $session_id= $value2['Ses_token'];
                                            
                                                 if (strlen($mac)<1) {
                                                            $mac="N/A"; }
                                                if (strlen($AP_Mac)<1) {
                                                            $AP_Mac="N/A"; }
                                                if (strlen($ssid)<1) {
                                                            $ssid="N/A"; }
                                                if (strlen($GW_ip)<1) {
                                                            $GW_ip="N/A"; }
                                                if (strlen($sh_realm)<1) {
                                                            $sh_realm="N/A"; }
                                                if (strlen($GW_Type)<1) {
                                                            $GW_Type="N/A"; }
                                                if (strlen($start_time)<1) {
                                                            $start_time="N/A"; }

                                                echo "<td>".$mac."</td>";
                                                echo "<td>".$AP_Mac."</td>";
                                                echo "<td>".$newstatus."</td>";
                                                if($private_module==1){
                                                     echo "<td>".$type."</td>";
                                                    }
                                                echo "<td>".$start_time."</td>";
                                                echo "<td>".$ssid."</td>";
                                                echo "<td>".$sh_realm."</td>";
                                                echo "<td>".$GW_ip."</td>";
                                                echo "<td>".$GW_Type."</td>";
                                                
                                                
                                             /*foreach ($value2 as $key => $value) {
                                                //$session_row_count++;

                                                if (strlen($value)<1) {
                                                    $value="N/A";
                                                    # code...
                                                }
                                                echo "<td>".$value."</td>";
                                                

                                             }*/

                                             echo '<td>';
                                             if ($newstatus=='Inactive' && $nas_type=='ac') {
                                                 echo '<a  class="btn  btn-small td_btn_last disabled" data-toggle="tooltip" title="The system does not allow to delete inactive sessions">
                                      <i class="btn-icon-only icon-trash"></i>Delete</a>';
                                             }
                                             else{
                                             if(strlen($session_id)>0 && $_GET['mac_id']!=$mac){
                                             echo '<center><a href="javascript:void();"  id="DL_' . $session_row_count . '"  class="btn  btn-small">
                                                                            <i class="btn-icon-only icon-trash"></i>Delete</a></center>
                                                                            </td><script type="text/javascript">
                                                                            $(document).ready(function() {
                                                                            $(\'#DL_' . $session_row_count . '\').easyconfirm({locale: {
                                                                                    title: \'Delete Session \',
                                                                                    text: \'Are you sure you want to delete session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                                    closeText: \'close\'
                                                                                     }});
                                                                                $(\'#DL_' . $session_row_count . '\').click(function() {
                                                                                    window.location = "?t=active_sessions&dl_id=' . $session_row_count . '&mac_id='.$mac.'&session_token='.$session_id.'&search_id=' . $sh_realm . '&s3=' . $_SESSION['FORM_SECRET3'].'&vanue_id=' . $vanue_id .'&search_btn_session=' . $search_btn_session .'"
                                                                                });
                                                                                });
                                            </script>';}
                                            elseif ($_GET['mac_id']==$mac){
                                                        echo'<a disabled id="DL_' . $session_row_count . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
                                                        <script type="text/javascript">
                                                        var deleteSessionCheck'.$mac.' = function (){
                                                            checkSessionDeleted(\''.$sh_realm.'\',\''.$mac.'\',function(data){
                                                                
                                                            if(data == \'0\'){
                                                                
                                                                $(\'#DL_' . $session_row_count .'\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
                                                            }else{
                                                                deleteSessionCheck'.$mac.'();
                                                            }   
                                                        });
                                                            
                                                        }
                                                        deleteSessionCheck'.$mac.'();
                                                        </script>
                                                        ';

                                                    }
                                                        else{
                                                            echo'<a disabled id=id="DL_' . $session_row_count . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-trash"></i>&nbsp;Delete</a>';
                                                        }
                                                    }
                                             echo'</td>';
                                             
                                             echo "</tr>";
                                            }

                                        }
                                        else{
                                            echo "<td colspan=\"11\">No Active Sessions</td>";
                                        }

                                        
                                        }
                                        

                                        ?>

                                        </tbody>

                                                            </table>
                                                            

                                                                </div>
                                                                </div>
                                                        </div>
                                                    <?php } ?>
                                                </form>
                                                <!--********************************-->
                                            </div><!--tab end-->