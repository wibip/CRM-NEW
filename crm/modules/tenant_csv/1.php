<?php

?>
<div class="tab-pane <?php echo isset($tab_add_tenant_csv) ? 'in active' : ''; ?>" id="add_tenant_csv">
    <!-- 	<form id="edit-profile" class="form-horizontal" onsubmit="tableBox('customer'); return false;"> -->



    <!-- </form> -->
    <form autocomplete="nope" id="customer_form_csv" name="customer_form_csv" action="add_tenant?t=add_tenant_csv" method="post" class="form-horizontal" enctype="multipart/form-data">

        <?php if ($dpsk_enable) {
            $csv_sample = 'export/csv/tenant_account.csv';
        } else {
            $csv_sample = 'export/csv/tenant_account.csv';
        } ?>



        <h1 class="head en_display">Mass Account Creation
        </h1>


        <?php

        ?>

        <fieldset>


            <div id="response_d1"></div>

            <input id="room" name="room" type="hidden">
            <input id="comp_name" name="comp_name" type="hidden">

            <div class="control-group" style="width: 100%;">

                <div class="controls form-group" style="width: 100%; margin-left: 50px;">
                    <div class="" style="position: relative;">
                        <span>Step-1: &nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <a href='<?php echo $csv_sample; ?>' class="btn btn-default">
                            Download Template
                        </a>
                        <img id="tooltip1" class="tooltips" data-toggle="tooltip" title="Use this CSV template to create multiple resident accounts at once. Then save the template as a CSV file on your computer.<br><br><b>IMPORTANT: Use the two letter abbreviation for the state or the account will fail to be created.</b><br><br>If one or more accounts fail to be created, a link to download a CSV file with the failed accounts will appear at the top of the page." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">

                    </div>

                </div>

            </div>
            <div class="control-group" style="width: 100%;">

                <div class="controls form-group" style="width: 100%; margin-left: 50px;">

                    <div class="csv_parent" style="position: relative;">
                        <span>Step-2: &nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <input type="file" class="btn btn-primary" name="tenant_account_list" id="tenant_account_list">
                        <label for="tenant_account_list" class="btn btn-primary tenant_account_list_label">Select CSV File</label>
                        <span id="selected_name"></span>

                    </div>

                </div>

            </div>
            <div class="control-group" style="width: 100%; margin-top: 10px;">

                <div class="controls form-group" style="width: 100%; margin-left: 50px;">
                    <div class="" style="position: relative;">
                        <span>Step-3: &nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <button type="submit" name="csv_update" id="csv_update" class="btn btn-primary">Save and Send Email Invitation
                        </button>
                        <span id="csv_loading"><img style="display:none;" src="img/loading_ajax.gif"></span>
                    </div>

                </div>

            </div>

        </fieldset>
    </form>
    <style type="text/css">
        .nav-tabs>li:last-child>a {
            border-right: none !important;
        }


        /* input[name="tenant_account_list"]::before {
            width: 250px;
            height: 30px;
            color: #fff;
            content: 'Select CSV file';
            background-color: #0569ae !important;
            box-shadow: none !important;
            text-shadow: none !important;
            padding: 4px 15px;
            min-width: 70px !important;
            cursor: pointer;
            font-size: 19px;
            line-height: 22px;
            text-indent: 0px;
            position: absolute;
            left: 0;
        } */

        input[name="tenant_account_list"] {
            position: absolute;
            z-index: -1;
        }

        .tenant_account_list_label {}

        input[type=file] {
            height: 24px !important;
            line-height: 22px !important;
        }
    </style>




</div>


<!-- <script src="js/jquery-1.7.2.min.js"></script> -->

<!-- <script src="js/bootstrap.js"></script> -->
<script src="js/base.js"></script>
<script src="js/jquery.chained.js"></script>
<!-- tool tip css -->
<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />

<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>





<!-- datatables js -->

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrapValidator.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $("#customer_form_csv").submit(function() {
            var bootstrapValidator = $('#customer_form_csv').data('bootstrapValidator');
            if(bootstrapValidator.isValid()){
                $('#csv_loading img').show();
            }
        });

        $('#tenant_account_list').change(function(e) {
            $('#selected_name').html(e.target.files[0].name);
        });

        $('#customer_form_csv').bootstrapValidator({
            framework: 'bootstrap',
            fields: {
                tenant_account_list: {
                    excluded: false,
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        });

        $('select').on('change', function() {

            //check_val();

        });


        //check_val();

    });
</script>