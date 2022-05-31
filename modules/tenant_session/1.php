<div class="tab-pane <?php echo isset($tab_tenant_session)?'in active':''; ?>" id="tenant_session">

       <h1 class="head"><span>
    Session Search <img data-toggle="tooltip" title="You can search for a residents online sessions using Email, First Name or device MAC Address. To get a list of all sessions, click the Search Button." src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>
<form id="edit-profile" action="?t=tenant_session" method="post" class="form-horizontal middle" >
        <?php

        $_SESSION['FORM_SECRET_SES'] =  md5(uniqid(rand(), true));
        echo '<input type="hidden" name="form_secret_ses" id="form_secret_ses" value="'.$_SESSION['FORM_SECRET_SES'].'" />';

        ?>

        <fieldset>



          <div class="control-group" style="display: none;">
           
            <div class="controls">

               <label class="" for="radiobtns">Limit Search to</label>


              <div class="">
                <select name="property_id_session" id="property_id_session" required>
                  <option value="ALL">ALL Properties</option>

                  <?php

                  /* $key_query = "SELECT o.property_number,o.property_id, o.org_name
                            FROM mdu_organizations o, mdu_system_user_organizations u
                            WHERE o.property_number = u.property_id
                            AND u.user_name = '$user_name'";

                  $query_results=mysql_query($key_query); */
                  $query_results = $db->get_property($user_distributor);
                  foreach($query_results as $row){

                    $property_number = $row[property_number];
                    $property_id = $row[property_id];
                    $org_name = $row[org_name];

                    echo '<option selected value="'.$property_number.'">'.$org_name.'</option>';
                  }

                  ?>


                </select>



              </div>
            </div>
            <!-- /controls -->
          </div>
          <!-- /control-group -->

          <div class="control-group middle-large">
                                     
                                     <div class="controls">

                                      <label class="" for="radiobtns">Search Residents <img data-toggle="tooltip" title="You can search for resident sessions using full or First Name or Email or use the Search MAC field." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>
         

                                       <div class="">
                                         <input type="text" name="search_word" id="search_word" >
                                         &nbsp; <font size="4">or</font>
                                           
                                         <br />
                                         
                                        <!--  Note: You can search using First Name, Last Name or Email Address. --> 

                                                        
                                         
                                       </div>
                                     </div>
                                     <!-- /controls -->
                                     <div class="controls">

                                      <label class="" style="margin-top: 10px" for="radiobtns">Search MAC <img data-toggle="tooltip" title="You can search for resident sessions using MAC address of a device or use the Search Resident field." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label>
         

                                       <div class="">
                                         <input type="text"  name="search_mac" id="search_mac" type="text" maxlength="17"  / >

                                         <button align='center' class="btn" type="submit" name="search_btn_session" id="search_btn_session">Search</button>
                                        
                                         <br />
                                       </div>

                                     </div>


       </div>


       <div class="controls middle-left">
         <div  class="">

          <div class="control-group">
            
            <!-- <div class="controls">
              <label class="" for="radiobtns">Search Tenant <img data-toggle="tooltip" title="You can search using the First Name, Last Name, Email Address or a device MAC Address." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></label> -->

              <div class="controls se_ownload_cr">
                <!-- <input type="text" name="search_word" id="search_word_session" > -->
                <!-- <button align='center' class="btn" type="submit" name="search_btn_session" id="search_btn_session">Search</button> -->
                <br />  <br />
                <a id="download-session" href="javascript:void(0);"
             class="btn btn-info" style="text-decoration:none"><i
                class="btn-icon-only icon-download"></i>
            Download Search Results</a>

              </div>
           <!--  </div>
            /controls -->
          </div>
          </div>
        </div>
          <!-- /control-group -->
        </fieldset>






        <?php

        
        #*********************************************************************
        
        if(isset($_GET['search_id']) && $_GET['t']=='tenant_session') {
          $search_id = $_GET['search_id'];
          $form_secreat3 = $_GET['s3'];
          $realm=$_GET['realm'];
          if ($form_secreat3 == $_SESSION['FORM_SECRET3']) {
            $record_found=2;
          }
        }

        

        
        if($_GET['t']=='tenant_session') {

        if (2 == 2) {

          $customer_down_key_string = "task=session_mdu&searchid=".$search_id;
          $customer_down_key =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string);
                                                    $customer_down_key =  urlencode($customer_down_key);

          ?>

          <script type="text/javascript">
             $(document).ready(function(){
                                      $("#download-session").show();

                                    var table = $('#session_search_table').DataTable({
                                        dom: 'Bfrtip',
                                       "pageLength": 50,
                                       "language": {
                                          "emptyTable": "No Active Sessions"
                                        },
                                         buttons: [
                                            {
                                                extend: 'csvHtml5',
                                                title: 'Session Results',
                                                exportOptions: {
                                                    //columns: [ 0, 1, 2, 3, 4 ]
                                                }
                                            }
                                         ]
                                        
                                     });

                                     $("#download-session").on("click", function() {
                                          table.button( '.buttons-csv' ).trigger();
                                      });

              });

          </script>

          <style type="text/css">
            .buttons-csv{
              display: none;
            }
          </style>
          
          <div class="widget widget-table action-table">
          <div class="widget-header">
            <i class="icon-th-list"></i>

            <h3>Search Results</h3>
          </div>
          <!-- /widget-header -->
          <div class="widget-content table_response">

            
          </br>
          </br>
          </br>

          <div style="overflow-x:auto">
          <table id="session_search_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
          <thead>
          <tr>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">MAC
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">First Name
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Last Name
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">EMAIL
            </th>
            <!--    <th>AAA User Name</th> -->
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Session State</th>
            <!--    <th>Realm</th>  -->
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Master Account</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Session Start
              Time
            </th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="8">IP Address
            </th>
            <?php if ($user_wired != 1) {?>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Host Name
              </th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">OS Vendor
              </th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Model Name
              </th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Device Type
              </th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Uplink
              </th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Downlink
              </th>
            <?php } ?>
            
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Delete</th>


          </tr>
          </thead>
          <tbody>
           
          <?php

          if($search_btn_session || isset($_GET['search_id'])){

            if ($newjsonvalue[0]) {
              $ses_dl=0;
                                            $res_arrr=array();
                                            $res_arrr2=array();
                                            $res_arrr3=array();
                                            $res_arrr4=array();
                                            foreach ($newjsonvalue[1] as $value1) {
                                                $session_mac=$value1['Mac'];
                                                $session_id=$value1['Ses_token'];
                                                $Realm=$value1['Realm'];
                                                $Nas_Type=$value1['Nas-type'];
                                                array_push($res_arrr,$session_mac);//$db->macFormat($session_mac,$mac_format));
                                                array_push($res_arrr2, $session_id);
                                                array_push($res_arrr3, $Realm);
                                                array_push($res_arrr4, $Nas_Type);
                                            }
                                            //print_r($res_arrr2);
                                            //echo $session_id;
                                           $session_row_count=0;
                                            foreach ($newjsonvalue[0] as $value2){
                                                //print_r($res_arrr);
                                                $session_row_count=$session_row_count+1;
                                                $ses_dl++;
                                                
                                                echo "<tr>";
                                                $mac=($value2['Mac']);
                                                $ssid=($value2['SSID']);
                                                $GW_ip=($value2['GW_ip']);
                                                //$sh_realm=($value2['Realm']);
                                                $state=($value2['State']);
                                                $session_state = $value2['Session_State'];
                                            
                                            if (in_array($mac, $res_arrr))
                                                  {
                                                  $session_mac=$mac;
                                                  $a=array_search($session_mac,$res_arrr,true);
                                                  $session_id=$res_arrr2[$a];
                                                  $sh_realm=$res_arrr3[$a];
                                                  $Nas_Type=$res_arrr4[$a];
                                                  }


                                             foreach ($value2 as $key => $value) {
                                                //$session_row_count++;

                                                if (strlen($value)<1) {
                                                    $value="N/A";
                                                    # code...
                                                }
                                                echo "<td>".$value."</td>";
                                                

                                             }

                                                           echo '<td class="td_btn"> ';

                                /*if(strlen($session_id)>0 && $_GET['uni_mac']!=$mac){
                                echo '<a href="javascript:void(0);"  id="DL_' . $ses_dl . '"  class="btn  btn-small td_btn_last">
                                      <i class="btn-icon-only icon-trash"></i>Delete</a>
                                      </td><script type="text/javascript">
                                      $(document).ready(function() {
                                      $(\'#DL_' . $ses_dl . '\').easyconfirm({locale: {
                                          title: \'Delete Session \',
                                          text: \'Are you sure you want to delete session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                          button: [\'Cancel\',\' Confirm\'],
                                          closeText: \'close\'
                                           }});
                                        $(\'#DL_' . $ses_dl . '\').click(function() {
                                          window.location = "?t=tenant_session&dl_id=' . $session_id . '&search_id=' . $search_id . '&s3=' . $_SESSION['FORM_SECRET_SES'] . '&realm=' . $sh_realm . '&query_type=' . $session_id . '&uni_mac='.$mac.'&search_btn_session=' . $search_btn_session .'"
                                        });
                                        });
                                      </script>';
                                    }
                                    elseif ($_GET['uni_mac']==$mac){
                                                        echo'<a disabled id="DL_' . $ses_dl . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
                                                        <script type="text/javascript">
                                                        var deleteSessionCheck'.$mac.' = function (){
                                                            checkSessionDeleted(\''.$sh_realm.'\',\''.$mac.'\',function(data){
                                                                
                                                            if(data == \'0\'){
                                                            //alert(data);
                                                                $(\'#DL_' . $ses_dl .'\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
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
                                                            echo'<a disabled id=id="DL_' . $ses_dl . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Delete</a>';
                                                        }
*/
              //
                                                if($session_state =='Inactive' && $Nas_Type == 'ac'){
                                                  echo '<a  class="btn  btn-small td_btn_last disabled" data-toggle="tooltip" title="The system does not allow to delete inactive sessions">
                                      <i class="btn-icon-only icon-trash"></i>Delete</a>
                                      </td>';
                                                }else{

                              echo '<a href="javascript:void(0);"  id="DL_' . $ses_dl . '"  class="btn  btn-small td_btn_last">
                                      <i class="btn-icon-only icon-trash"></i>Delete</a>
                                      </td><script type="text/javascript">
                                      $(document).ready(function() {
                                      $(\'#DL_' . $ses_dl . '\').easyconfirm({locale: {
                                          title: \'Delete Session \',
                                          text: \'Are you sure you want to delete session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                          button: [\'Cancel\',\' Confirm\'],
                                          closeText: \'close\'
                                           }});
                                        $(\'#DL_' . $ses_dl . '\').click(function() {
                                          window.location = "?t=tenant_session&dl_id=' . $session_id . '&search_id=' . $search_id . '&s3=' . $_SESSION['FORM_SECRET_SES'] . '&realm=' . $sh_realm . '&query_type=' . $session_id . '&uni_mac='.$mac.'&search_btn_session=' . $search_btn_session .'"
                                        });
                                        });
                                      </script>';
                                                }
                                echo '</tr>';
                                            }

                                        }
                                         
                                          else{
                                            //echo "<td colspan=\"11\">No Active Sessions</td>";
                                        }
                                      }




            



        }





          $_SESSION['mac_array'] = $mac_array;
          ?>
                  </tbody>
                  </table>
                  </div>
            <?php
        /*  if ($session_count == 0) {

            echo "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>X</button>
                        <strong>".$message_functions->showMessage('no_conncted_devices','2004')." </strong></div>";

          }*/
          ?>
                  </div>
                  
                  
                  
              </div>
              <?php

        }

        ?>
      </form>
      </div>