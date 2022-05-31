    
<style type="text/css">

      .widget-header{
        display: none;
  }
  .widget-content{
    padding: 0px !important;
    border: 1px solid #ffffff !important;
  }
  .intro_page{
    z-index: -4;
  }
  .nav-tabs{
    padding-left: 30% !important;
  }
  body .nav-tabs>.active>a, body .nav-tabs>.active>a:hover{
        background-color: #000000;
    border: none;
  }

  .nav-tabs>li>a{
    border-radius: 0px 0px 0 0 !important;
  }

 

  body {
    background: #ffffff !important;
}


h3 {
    color: #00c5aa;
    margin-bottom: 15px;
    margin-top: 15px;
}



/*footer styles*/

.contact{
    font-size: 16px;
    font-family: Rregular;
    color: #fff;
        margin-right: 50px;
}

.call span:not(.glyph), .footer-live-chat-link span:not(.glyph){
    font-family: Rmedium;
    font-size: 20px;
    color: #fff;
}

.number{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-live-chat-link{
        display: inline-block;
    margin-left: 50px;
}

.call a{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-inner a:hover{
    text-decoration: none !important;
    color: #fff;
}

.main-inner{
    position: relative;
}

.main {
    padding-bottom: 0 !important;
}

    /*network styles
*/

.tab-pane{
    padding-bottom: 50px;
/*  padding-top: 50px;*/
    /*border-bottom: 1px solid #000000;*/
}

.tab-pane:nth-child(1){
    padding-top: 0px;
}

.tab-pane:last-child{
    border-bottom: none;
}

.alert {
  /*position: absolute;
    top: 60px;*/
    width: 100%;
}

@media screen and (max-width: 979px) and (min-width: 521px) {

    .header_f1{
        font-size: 48px !important;
        margin-top: 0px !important;
    }
}


</style>
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<div class="main">
	<div class="main-inner">
        <div class="custom-tabs"></div>
	    <div class="container">
	        <div class="row">
	      	<div class="span12">

	      		<div class="widget ">
						
							
							<div class="widget-content" id="now">

								<div class="tabbable">
									<ul class="nav nav-tabs newTabs">
										<li class="active"><a href="#create_acc" data-toggle="tab">Campaign Report</a></li>

									</ul>
									<br>

									<div class="tab-content">


                                            <!-- ******************* create camp ******************* -->
										<div class="tab-pane active" id="create_acc">

         	

            <div class="span12">

	      		<div class="widget">
	      			<div class="widget-content">
                        <div class="header_hr" style="top: -20px !important;left: 0px !important"></div>
			      		<div class="header_f1" style="margin-bottom: 20px;width: 100%;">Campaign Report</div>

			      		<p>

			      		<form method="GET" name="camp_submit" action="ajax/export_report.php">



                            <div class="control-group">
                                <label class="control-label" for="radiobtns">Created Date (From)</label>

                                <div class="controls">
                                    <div class="input-prepend input-append">

                                    <input class="span3" type="text" name="from_date_camp" id="from_date_camp" placeholder="mm/dd/yyyy" >
                                    </div>
                                </div>
                                <!-- /controls -->
                            </div>
                            <!-- /control-group -->




                                <input id="dist" type="hidden" name="dist" value="<?php echo $user_distributor; ?>">

                            <div class="control-group">
                                <label class="control-label" for="radiobtns">Created Date (To)</label>

                                <div class="controls">
                                    <div class="input-prepend input-append">

                                    <input class="span3" type="text" name="to_date_camp" id="to_date_camp"  placeholder="mm/dd/yyyy">
                                    </div>
                                </div>
                                <!-- /controls -->
                            </div>
                            <!-- /control-group -->




                            <div class="control-group">
                                <label class="control-label" for="radiobtns"></label>

                                <div class="controls">
                                    <div class="input-prepend input-append">

                                    <button name="camp_submit" id="camp_submit" type="submit" class="btn btn-info">Download Report</button>

                                    </div>
                                </div>
                                <!-- /controls -->
                            </div>
			      		</form>
			      		</p>

		      		</div> <!-- /widget-content -->
            </div> <!-- /widget -->

      		</div> <!-- /span6 -->


</div>
         </div> 
         </div>
        </div>
         </div> 
         </div>
         </div> 
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->


<?php
include 'footer.php';
?>






<!-- <script src="js/jquery-1.7.2.min.js"></script> -->
<script src="js/excanvas.min.js"></script>
<script src="js/chart.min.js" type="text/javascript"></script>
<!-- <script src="js/bootstrap.js"></script> -->
<script src="js/base.js"></script>
<script>

<?php

if($user_type == 'MVNO' || $user_type == 'MVNE'){

	$qg1 = "SELECT concat('\"',SUBSTRING(MONTHNAME(session_starting_time),1,3),'\"') as d1, COUNT(DISTINCT l.customer_id) as c1 FROM exp_customer l, exp_customer_session s
	WHERE l.customer_id = s.customer_id AND s.location_id = '$user_distributor'
	AND s.session_status = '2'
	AND session_starting_time > DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
	GROUP BY YEAR(session_starting_time), MONTH(session_starting_time)";

	$qg2 = "SELECT concat('\"',SUBSTRING(MONTHNAME(session_starting_time),1,3),'\"') as d2, COUNT(*) as c2 from exp_customer_session s
	WHERE s.location_id = '$user_distributor'
	AND s.session_status = '2'
	AND session_starting_time > DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
	GROUP BY YEAR(session_starting_time), MONTH(session_starting_time)";

	$qg3 = "SELECT concat('\"',SUBSTRING(MONTHNAME(create_date),1,3),'\"') as d3, COUNT(*) as c3 FROM exp_camphaign_logs l, exp_customer_session s
	WHERE l.token = s.token_id AND s.location_id = '$user_distributor'
	AND s.session_status = '2'
	AND create_date > DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
	GROUP BY YEAR(create_date), MONTH(create_date)";

}


if($user_type == 'MNO'){

	$qg1 = "SELECT concat('\"',SUBSTRING(MONTHNAME(session_starting_time),1,3),'\"') as d1, COUNT(DISTINCT l.customer_id) as c1 FROM exp_customer l, exp_customer_session s
	WHERE l.customer_id = s.customer_id AND s.mno = '$user_distributor'
	AND s.session_status = '2'
	AND session_starting_time > DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
	GROUP BY YEAR(session_starting_time), MONTH(session_starting_time)";

	$qg2 = "SELECT concat('\"',SUBSTRING(MONTHNAME(session_starting_time),1,3),'\"') as d2, COUNT(*) as c2 from exp_customer_session s
	WHERE s.mno = '$user_distributor'
	AND s.session_status = '2'
	AND session_starting_time > DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
	GROUP BY YEAR(session_starting_time), MONTH(session_starting_time)";

	$qg3 = "SELECT concat('\"',SUBSTRING(MONTHNAME(create_date),1,3),'\"') as d3, COUNT(*) as c3 FROM exp_camphaign_logs l, exp_customer_session s
	WHERE l.token = s.token_id AND s.mno = '$user_distributor'
	AND s.session_status = '2'
	AND create_date > DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
	GROUP BY YEAR(create_date), MONTH(create_date)";

}


$query_results1=mysql_query($qg1);
if(mysql_num_rows($query_results1)==1){
	$d1 = '" ",';
	$c1 = '0,';
}
while($row1=mysql_fetch_array($query_results1)){
//	$d1 .= substr($row1[d1],1,3).',';
    $d1 .= $row1[d1].',';
	$c1 .= $row1[c1].',';

}







$query_results2=mysql_query($qg2);
if(mysql_num_rows($query_results2)==1){
	$d2 = '" ",';
	$c2 = '0,';
}
while($row2=mysql_fetch_array($query_results2)){
	$d2 .= $row2[d2].',';
	$c2 .= $row2[c2].',';

}








$query_results3=mysql_query($qg3);
if(mysql_num_rows($query_results3)==1){
	$d3 = '" ",';
	$c3 = '0,';
}
while($row2=mysql_fetch_array($query_results3)){
	$d3 .= $row2[d3].',';
	$c3 .= $row2[c3].',';

}

?>


var barChartData1 = {
        labels: [ <?php echo trim($d1,','); ?>],
        datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    data: [<?php echo trim($c1,','); ?>]
				}
			]

    }



    var barChartData2 = {
            labels: [ <?php echo trim($d2,','); ?>],
            datasets: [
    				{
    				    fillColor: "rgba(220,220,220,0.5)",
    				    strokeColor: "rgba(220,220,220,1)",
    				    data: [<?php echo trim($c2,','); ?>]
    				}
    			]

        }





    var barChartData3 = {
            labels: [ <?php echo trim($d3,','); ?>],
            datasets: [
    				{
    				    fillColor: "rgba(220,220,220,0.5)",
    				    strokeColor: "rgba(220,220,220,1)",
    				    data: [<?php echo trim($c3,','); ?>]
    				}
    			]

        }

	var myLine = new Chart(document.getElementById("bar-chart1").getContext("2d")).Bar(barChartData1);
	var myLine = new Chart(document.getElementById("bar-chart2").getContext("2d")).Bar(barChartData2);
	var myLine = new Chart(document.getElementById("bar-chart3").getContext("2d")).Bar(barChartData3);

	</script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

<script type="text/javascript">

        $('#from_date_camp').on('change',function(){
                $( function() {
                    $( "#to_date_camp").datepicker( "option", "minDate", $( "#from_date_camp" ).datepicker( "getDate" ));
                    $( "#from_date_camp").datepicker( "option", "maxDate", $( "#to_date_camp" ).datepicker( "getDate" ));
                                                                
                } );
        });

        $('#to_date_camp').on('change',function(){
            $( function() {
                $( "#to_date_camp").datepicker( "option", "minDate", $( "#from_date_camp" ).datepicker( "getDate" ));
                $( "#from_date_camp").datepicker( "option", "maxDate", $( "#to_date_camp" ).datepicker( "getDate" ));
                                                            
            } );
        });
                                                                                                       
</script>


                            <script>
                                $( function() {
                                    $( "#from_date_camp" ).datepicker({
                                        dateFormat: "yy-mm-dd",
                                        //minDate: '-6M',
                                        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
                                        maxDate: '0'
                                    });
                                } );
                            </script>
                            <script>
                                                                    $( function() {
                                                                        $( "#to_date_camp" ).datepicker({
                                                                            dateFormat: "yy-mm-dd",
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
        maxDate: '0',
         beforeShow: function(input, inst) {
          var minDate = $('#from_date_camp').datepicker('getDate');
          $('#to_date_camp').datepicker('option', 'minDate', minDate);
        }

                                                                        });
                                                                    } );
                                                                </script>



  </body>