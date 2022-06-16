                                        <div <?php if (isset($tab_prepaid_plan)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
                                            id="prepaid_plan">

                                            <div class="span4">

                                                <div class="widget">
                                                    <div class="widget-content">

                                                        <h2>Prepaid Report</h2>
                                                        <form method="GET" name="property_prepaid_submit"
                                                              id="property_prepaid_submit" action="ajax/export_report.php">

                                                            <input id="dist" type="hidden" name="dist"
                                                                   value="<?php echo $user_distributor; ?>">
                                                            <input id="user_timestamp" type="hidden" name="user_timestamp"
                                                                   value="<?php echo $log_time_zone; ?>">
                                                            <input id="dist_type" type="hidden" name="dist_type"
                                                                   value="<?php echo in_array('support', $access_modules_list)?'SUPPORT':'MNO';  ?>">

                                                            <fieldset>
                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns">   
                                                                        Date (From)</label>

                                                                    <div class="controls form-group">


                                                                        <input onchange="sf_reports()" class="span3" type="text"
                                                                               name="from_date_prepaid" id="from_date_prepaid"
                                                                               placeholder="mm/yyyy">

                                                                    </div>
                                                                    <!-- /controls -->
                                                                </div>
                                                                <!-- /control-group -->

                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns">
                                                                        Date (To)</label>

                                                                    <div class="controls form-group">


                                                                        <input onchange="sf_reports()" class="span3" type="text"
                                                                               name="to_date_prepaid" id="to_date_prepaid"
                                                                               placeholder="mm/yyyy">

                                                                    </div>
                                                                    <!-- /controls -->
                                                                </div>
                                                                <!-- /control-group -->
                                                                <script type="text/javascript">
                                                                    function sf_reports() {
                                                                    var element = document.getElementById("plan_activation");
                                                                    element.classList.remove("disabled");
                                                                      document.getElementById("plan_activation").disabled = false;
                                                                    }
                                                                </script>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns"></label>

                                                                    <div class="controls form-group">


                                                                        <button name="plan_activation"
                                                                                id="plan_activation" type="submit"
                                                                                class="btn btn-info">Download Report
                                                                        </button>


                                                                    </div>
                                                                    <!-- /controls -->
                                                                </div>
                                                            </fieldset>
                                                        </form>
                                                        <p></p>

                                                    </div> <!-- /widget-content -->
                                                </div> <!-- /widget -->

                                            </div>
                                        </div>