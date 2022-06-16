                                        <div <?php if (isset($tab_cf_reports)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
                                            id="cf_reports">

                                            <div class="span4">

                                                <div class="widget">
                                                    <div class="widget-content">

                                                        <h2>Property Report</h2>
                                                        <form method="GET" name="property_camp_submit"
                                                              id="property_camp_submit" action="ajax/export_report.php">

                                                            <input id="dist" type="hidden" name="dist"
                                                                   value="<?php echo $user_distributor; ?>">
                                                            <input id="dist_type" type="hidden" name="dist_type"
                                                                   value="<?php echo in_array('support', $access_modules_list)?'SUPPORT':'MNO';  ?>">

                                                            <fieldset>
                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns">Created
                                                                        Date (From)</label>

                                                                    <div class="controls form-group">


                                                                        <input onchange="cf_reports()" class="span3" type="text"
                                                                               name="from_date_camp" id="from_date_camp"
                                                                               placeholder="mm/yyyy">

                                                                    </div>
                                                                    <!-- /controls -->
                                                                </div>
                                                                <!-- /control-group -->

                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns">Created
                                                                        Date (To)</label>

                                                                    <div class="controls form-group">


                                                                        <input onchange="cf_reports()" class="span3" type="text"
                                                                               name="to_date_camp" id="to_date_camp"
                                                                               placeholder="mm/yyyy">

                                                                    </div>
                                                                    <!-- /controls -->
                                                                </div>
                                                                <!-- /control-group -->
                                                                <script type="text/javascript">
                                                                    function cf_reports() {
                                                                    var element = document.getElementById("property_activation");
                                                                    element.classList.remove("disabled");
                                                                      document.getElementById("property_activation").disabled = false;
                                                                    }
                                                                </script>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="radiobtns"></label>

                                                                    <div class="controls form-group">


                                                                        <button name="property_activation"
                                                                                id="property_activation" type="submit"
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