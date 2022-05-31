<?php


$tabNameTxt = (empty($moduleTxt['tabName'])?"Total Customers":$moduleTxt['tabName']);
$search_customer_input_label = (empty($moduleTxt['search_customer_input_label'])?"Search Customer":$moduleTxt['search_customer_input_label']);
$search_btn_tooltip = (empty($moduleTxt['search_btn_tooltip'])?" ":$moduleTxt['search_btn_tooltip']);
$download_btn_txt = (empty($moduleTxt['download_btn_txt'])?"Download all Visitors":$moduleTxt['download_btn_txt']);
$header_display = (empty($moduleTxt['header_hide'])?"":"style='display: none;'");

if($user_type == 'ADMIN'){
	$log_time_zone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='ADMIN'");
}
else if($user_type=="MNO"){

	$log_time_zone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
}
else{
	$log_time_zone=$db->getValueAsf("SELECT `time_zone` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
	$query_arr = $db->selectDB("SELECT `offset_val`,`verification_number` FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
		if($query_arr['rowCount']>0){
			foreach ($query_arr['data'] as $row){
				$offset_val=$row['offset_val'];
				$verification_number=$row['verification_number'];
			}
		}
}

if( empty($log_time_zone) ||  $log_time_zone == '' ){
	$log_time_zone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='ADMIN'");
}

?>

<div class="tab-pane <?php if (isset($tab_customer_report )){ echo 'active'; } ?>" id="customer_report">
										<!-- 	<form id="edit-profile" class="form-horizontal" onsubmit="tableBox('customer'); return false;"> -->
										<div class="header_hr" style="display: none;"></div>	
                                        <h1 class="head" <?php echo $header_display; ?>>
    Customer Details <img data-toggle="tooltip" title="Based on the type of splash page theme you have active, data is collected about your visitors. If the splash page theme is using Manual Only template demographic data such as name, email, mobile phone, gender and age group are collected. In case you using a Click &amp; Connect or Passcode Authentication template no data is collected outside of the MAC Address of the device used" src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1>

                                              <div class="header_f1" style="display: none;float: none;">Total Visitors</div>

											  <?php
											if(isset($_SESSION['customer_report'])){
												echo$_SESSION['customer_report'];
												unset($_SESSION['customer_report']);
											}
											?>

										<div  id="edit-profile" class="form-horizontal">


									            <fieldset>

													<div class="control-group">
														<label class="control-label" for="radiobtns"> <?php echo $search_customer_input_label; ?></label>

														<div class="controls">
                                                            <div class="input-prepend input-append">
																<input class="span2 m-wrap" id="search_customer_input" name="search_customer_input">
																<a href="javascript:void(0);" data-toggle="tooltip" id="search_customer" <?php echo ($search_btn_tooltip!=" "?'title="'.$search_btn_tooltip.'"':''); ?>  class="btn btn-info tooltip_hide tooltips tooltipstered">Search</a>
																<img id="loading_ajax" src="img/loading_ajax.gif" style="display: none;margin-left: 10px;">
															</div>
														</div>
														<!-- /controls -->

													</div>
													<!-- /control-group -->

													<!-- /form-actions -->
												</fieldset>
												</div>
											<!-- </form> -->

											<?php
										//	$admin_timezone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");
											$product_code=$package_functions->getSectionType('CUSTOMER_TABLE',$system_package);
											$value_access=$package_functions->getOptions('CUSTOMER_TABLE',$system_package);
											//$newarray=json_decode($collumarray,true);
                                                    $customer_down_key_string = "dist=".$user_distributor."&log_time_zone=".$log_time_zone."&product_code=".$product_code."&value_access=".$value_access;
                                                    $customer_down_key =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string);
                                                    $customer_down_key =  urlencode($customer_down_key);
                                            ?>


											<a href="ajax/export_customer.php?key=<?php echo $customer_down_key;?>" class="btn btn-info"> <?php echo $download_btn_txt; ?></a>
											<br /><br /><br /><br />
											<?php if($package_functions->getSectionType('PURGE_CUSTOMER_SELECT',$system_package) =='YES'){ ?>
											<br>
											<form name="purge" action="" method="post" class="form-horizontal">
												<?php echo '<input type="hidden" name="token" value="'.$secret.'">'; ?>
												<div class="control-group">
														<label class="control-label" for="radiobtns">Purge <?php echo $customerTxt; ?>s</label>
														<div class="controls">
															<select name="interval" id="interval" class="span2" style="margin-bottom:0px">
																<option value="30">Older than 30 days</option>
																<option value="60">Older than 60 days</option>
																<option value="90">Older than 90 days</option>
																<option value="180">Older than 180 days</option>
																<option value="360">Older than 360 days</option>
															</select>
																<button type="submit" id="purge_customer" id="purge_customer" class="btn btn-info">Purge</button>
														</div>
												</div>
											</form>

											<?php
											}
											if($package_functions->getSectionType('CUSTOMER_TABLE',$system_package)=='YES'){ ?>
											<div class="widget widget-table action-table">
												
												<!-- /widget-header -->
												<div class="widget-content table_response" id="customer_div">

													<div style="overflow-x:auto;" >
													<table id="all_customers" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap >
														<thead>
															<tr>
																<?php $collumarray=$package_functions->getOptions('CUSTOMER_TABLE',$system_package);

																$spo = false;
																$advanced = json_decode($db->getValueAsf("SELECT advanced_features AS f FROM exp_mno_distributor WHERE distributor_code='$user_distributor'"),true);
                        
																if(array_key_exists('SPONSORED', $advanced) && $advanced['SPONSORED']==1){
																	$spo = true;
																}
																	$newarray=json_decode($collumarray,true);
																	//$collum_access=$newarray['Key'];
																	//print_r($collum_access);
																	$i=1;
																	foreach ($newarray as $key => $value) {
																		if($key=="zip_code" && !$spo){
																			continue;
																		}
																		$i=$i+1;
																		echo "<th scope='col' data-tablesaw-sortable-col data-tablesaw-priority='$i'>".$value."</th>";																			
																	}
																	?>

                                                                <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">MAC</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">First Login Date</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Last Login Date</th> -->
															</tr>
														</thead>

															<script type="text/javascript">
																$(document).ready(function() {
																	$('#loading_ajax').show();
																	$.post('ajax/customer_search.php', {column: 'db',user_distributor: '<?php echo $user_distributor; ?>'}, function(data, textStatus, xhr) {
																		var data = JSON.parse(data);
																		var table = data.table;
																		var paginate = data.paginate;
																		$('#paginate').html(paginate);
																		$('#all_customer_tbody').html(table);
																		$('#loading_ajax').hide();
                                                                        Tablesaw.init();
                                                                        $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").after("<label style='display: inline-block; margin-top: 10px;''></label>");
																	});
															
																
																
																	$('#search_customer').click(function(event) {
																		$('#loading_ajax').show();
																		$.post('ajax/customer_search.php', {column: 'db',user_distributor: '<?php echo $user_distributor; ?>',customer: $('#search_customer_input').val()}, function(data, textStatus, xhr) {
																		var data = JSON.parse(data);
																		var paginate = data.paginate;
																		var table = data.table;
																		$('#paginate').html(paginate);
																		$('#all_customer_tbody').html(table);
																		$('#loading_ajax').hide();
                                                                            Tablesaw.init();
                                                                            $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").after("<label style='display: inline-block; margin-top: 10px;''></label>");
																	});
																	});
																

								$('#search_customer_input').keydown(function (e){

                                if(e.keyCode == 13){
                                    event.preventDefault ? event.preventDefault() : (event.returnValue = false);

                                     $.post('ajax/customer_search.php', {column: 'db',user_distributor: '<?php echo $user_distributor; ?>',customer: $('#search_customer_input').val()}, function(data, textStatus, xhr) {
											var data = JSON.parse(data);
											var table = data.table;
											var paginate = data.paginate;
											$('#paginate').html(paginate);
											$('#all_customer_tbody').html(table);
                                         Tablesaw.init();
                                         $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").after("<label style='display: inline-block; margin-top: 10px;''></label>");
									 });

                                }
                            });
																
																	});
																	
																	
																		$(document).on("click", ".cusPagination li:not(.disabled) a", function(){
																	$('#all_customer_tbl_img').show();
																		$.post('ajax/customer_search.php', {column: 'db',user_distributor: '<?php echo $user_distributor; ?>',nextPage: $(this).data('pagenum'),customer: $('#search_customer_input').val()}, function(data, textStatus, xhr) {
																		var data = JSON.parse(data);
																		var table = data.table;
																		var paginate = data.paginate;
																		$('#all_customer_tbl').html(table);
																		$('#all_customer_tbody').html(table);

																		/*Tablesaw.init();
																		 $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").after("<label style='display: inline-block; margin-top: 10px;></label>");*/
																		$('#all_customer_tbl_img').hide();
																		$('#paginate').html(paginate);
                                                                            Tablesaw.init();
                                                                            $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").after("<label style='display: inline-block; margin-top: 10px;''></label>");
																	});
																	});
															</script>

														<tbody id="all_customer_tbody">

														
								                        </tbody>
													</table>
												</div>
												<div id="paginate"></div>
													</div>
												<!-- /widget-content -->
											</div><?php } 
											else{ ?>
											<div class="widget widget-table action-table">
												<div class="widget-header">
													
													<h3>Total <?php echo $customerTxt; ?>s</h3>

												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response" id="customer_div">
													<style type="text/css">
														.cusPagination{
															-webkit-box-pack: end;
														    -webkit-justify-content: flex-end;
														    -ms-flex-pack: end;
														    justify-content: flex-end;
														    display: -ms-flexbox;
														    display: flex;
														    margin-top: 20px;
														    padding-left: 0;
														    list-style: none;
														    border-radius: .25rem;
														}

														.cusPagination a{
															min-width: 11px;
    														text-align: center;
															text-decoration: none;
														    -webkit-transition: all .2s linear;
														    -o-transition: all .2s linear;
														    transition: all .2s linear;
														    -webkit-border-radius: 0px !important;
														    border-radius: 0px !important;
														    position: relative;
														    display: block;
														    padding: .5rem .75rem;
														    margin-left: -1px;
														    line-height: 20px;
														    border-width: 0px;
														}
														.cusPagination a:hover{
															text-decoration: none;
															background-color: #eee;
														}

														.cusPagination .disabled a{
														    color: #6c757d;
														    pointer-events: none;
														    cursor: auto;
														    border-color: #dee2e6;
														}
														.cusPagination .disabled{
															pointer-events: none!important;
														}
														.cusPagination li{
															border: 1px solid #dee2e6;
    														margin-left: -1px;
														}
														.cusPagination li.pre{
															border-top-left-radius: 3px;
    														border-bottom-left-radius: 4px;
    														margin-left: 0px;
														}
														.cusPagination li.nxt{
															border-top-right-radius: 3px;
    														border-bottom-right-radius: 4px;
														}
													</style>
													<div style="overflow-x:auto;" >
														<div id="all_customer_tbl_img" style="width: 100%;height: 100%;text-align: center;position: absolute;background: #ffffff99;display: none;"><img  src="img/loading_ajax.gif"></div>
														<div id="all_customer_tbl">
															
														</div>
													
														<script type="text/javascript">
																$(document).ready(function() {
																	$('#all_customer_tbl_img').show();
																	$.post('ajax/customer_search.php', {column: 'ex',user_distributor: '<?php echo $user_distributor; ?>'}, function(data, textStatus, xhr) {
																		var data = JSON.parse(data);
																		var table = data.table;
																		var paginate = data.paginate;
																		$('#all_customer_tbl').html(table);
																		/*Tablesaw.init();
																		
																			 $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").append("<label style='display: inline-block; margin-top: 10px;></label>");*/

																		$('#all_customer_tbl_img').hide();
																		$('#paginate').html(paginate);
																	});

																	$('#search_customer').click(function(event) {
																		$('#all_customer_tbl_img').show();
																		$.post('ajax/customer_search.php', {column: 'ex',user_distributor: '<?php echo $user_distributor; ?>',customer: $('#search_customer_input').val()}, function(data, textStatus, xhr) {
																		var data = JSON.parse(data);
																		var table = data.table;
																		var paginate = data.paginate;
																		$('#all_customer_tbl').html(table);
																		// Tablesaw.init();
																		//  $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").after("<label style='display: inline-block; margin-top: 10px;></label>");
																		$('#all_customer_tbl_img').hide();
																		$('#paginate').html(paginate);
																	});
																	});

						$('#search_customer_input').keydown(function (e){

                                if(e.keyCode == 13){
                                    event.preventDefault ? event.preventDefault() : (event.returnValue = false);

									 $('#all_customer_tbl_img').show();
									 $.post('ajax/customer_search.php', {column: 'ex',user_distributor: '<?php echo $user_distributor; ?>',customer: $('#search_customer_input').val()}, function(data, textStatus, xhr) {
												var data = JSON.parse(data);
												var table = data.table;
												var paginate = data.paginate;
												$('#all_customer_tbl').html(table);
												// Tablesaw.init();
												//  $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").after("<label style='display: inline-block; margin-top: 10px;></label>");
												$('#all_customer_tbl_img').hide();
												$('#paginate').html(paginate);
											});

                                }
                            })



																});

																$(document).on("click", ".cusPagination li:not(.disabled) a", function(){
																	$('#all_customer_tbl_img').show();
																		$.post('ajax/customer_search.php', {column: 'ex',user_distributor: '<?php echo $user_distributor; ?>',nextPage: $(this).data('pagenum'),customer: $('#search_customer_input').val()}, function(data, textStatus, xhr) {
																		var data = JSON.parse(data);
																		var table = data.table;
																		var paginate = data.paginate;
																		$('#all_customer_tbl').html(table);
																		/*Tablesaw.init();
																		 $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4)").after("<label style='display: inline-block; margin-top: 10px;></label>");*/
																		$('#all_customer_tbl_img').hide();
																		$('#paginate').html(paginate);
																	});
																	});
															</script>

													
												</div>
												<div id="paginate"></div>
													</div>
												<!-- /widget-content -->
											</div><?php } ?>

                                            <script >
$(document).ready(function(){

	$('body').on('click', '.tablesaw-columntoggle-btnwrap', function(){ 
		if($(this).hasClass('visible') && ($('#all_customers tbody tr').length < 3)){
			$('#all_customers').css('margin-bottom','250px');
		}else{
			$('#all_customers').css('margin-bottom','0px');
		}
	});
});

var xmlHttp5;

function tableBox(type)
{

    xmlHttp5=GetXmlHttpObject();
    if (xmlHttp5==null)
     {
         alert ("Browser does not support HTTP Request");
         return;
     }
    var loader = type+"_loader_1";
    var res_div = type+"_div";

    document.getElementById(loader).style.visibility= 'visible';
    var search_customer=document.getElementById("search_customer").value;

    var url="ajax/table_display.php";
    url=url+"?type="+type+"&q="+search_customer+"&dist=<?php echo $user_distributor;?>";


    xmlHttp5.onreadystatechange=stateChanged;
    xmlHttp5.open("GET",url,true);
    xmlHttp5.send(null);

    function stateChanged()
    {
        if (xmlHttp5.readyState==4 || xmlHttp5.readyState=="complete")
        {

            document.getElementById(res_div).innerHTML=xmlHttp5.responseText;
            document.getElementById(loader).style.visibility= 'hidden';
        }
    }
}


function GetXmlHttpObject()
{
var xmlHttp=null;
try
{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e)
{
//Internet Explorer
try
{
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
}
}
return xmlHttp;
}
</script>
<style>
@media screen and (max-width: 480px) {
    .tablesaw-advance-dots{
		display: none !important;
    }
}

</style>
<style type="text/css">
.paginate_img{
width: 100%;
bottom: 0;
text-align: center;
position: absolute;
background: #ffffff99;
display: none;
top:-40px;
z-index:55555;
}
.cusPagination{
-webkit-box-pack: end;
-webkit-justify-content: flex-end;
-ms-flex-pack: end;
justify-content: flex-end;
display: -ms-flexbox;
display: flex;
margin-top: 20px;
padding-left: 0;
list-style: none;
border-radius: .25rem;
}

.cusPagination a{
min-width: 11px;
text-align: center;
text-decoration: none;
-webkit-transition: all .2s linear;
-o-transition: all .2s linear;
transition: all .2s linear;
-webkit-border-radius: 0px !important;
border-radius: 0px !important;
position: relative;
display: block;
padding: .5rem .75rem;
margin-left: -1px;
line-height: 20px;
border-width: 0px;
}
.cusPagination a:hover{
text-decoration: none;
background-color: #eee;
}

.cusPagination .disabled a{
color: #6c757d;
pointer-events: none;
cursor: auto;
border-color: #dee2e6;
}
.cusPagination .disabled{
pointer-events: none!important;
}
.cusPagination li{
border: 1px solid #dee2e6;
margin-left: -1px;
}
.cusPagination li.pre{
border-top-left-radius: 3px;
border-bottom-left-radius: 4px;
margin-left: 0px;
}
.cusPagination li.nxt{
border-top-right-radius: 3px;
border-bottom-right-radius: 4px;
}
.perpage{
position: absolute;
top: -37px;
right: 140px;
z-index: 2;
}
.perpage select{
margin-bottom: 0px
}

</style>
										</div>