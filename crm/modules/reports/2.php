<div class="tab-pane <?php if (isset($tab_campaign_report)) {
                            echo 'active';
                        } ?>" id="campaign_report">

    <?php

    if (isset($_SESSION['campaign_report'])) {

        echo $_SESSION['campaign_report'];

        unset($_SESSION['campaign_report']);
    }
    ?>

<h1 class="head"><span>
    Reports <img data-toggle="tooltip" src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" title="The report contains information collected from the guests interaction with the campaign. The amount of data collected depends both on the type of campaign and the type of captive portal you have active."></span>
</h1>
<br>
    <form method="GET" name="camp_submit" action="ajax/export_report.php" class="form-horizontal" autocomplete="off">

        <div class="control-group">


            <div class="controls">
                <label class="" for="radiobtns">Created Date (From)</label>

                <input class="span3" type="text" name="from_date_camp" id="from_date_camp" placeholder="mm/dd/yyyy">
            </div>
            <!-- /controls -->
        </div>
        <!-- /control-group -->


        <input id="dist" type="hidden" name="dist" value="<?php echo $user_distributor; ?>">

        <div class="control-group">

            <div class="controls">
                <label class="" for="radiobtns">Created Date (To)</label>

                <input class="span3" type="text" name="to_date_camp" id="to_date_camp" placeholder="mm/dd/yyyy">
            </div>
            <!-- /controls -->

        </div>
        <!-- /control-group -->

        <div class="control-group">

            <div class="controls">
                <label class="" for="radiobtns"></label>

                <button name="camp_submit" id="camp_submit" type="submit" class="btn btn-info"> Download Report</button>

            </div>
            <!-- /controls -->
        </div>

    </form>
    <style>
    h1.head{
        padding: 27px;
    }
    </style>
</div>