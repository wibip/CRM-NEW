<?php
include 'header_new.php';
$page = "Order Templates";
?>
<link href="assets/css/custom.css" rel="stylesheet">
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-content">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="order_templates" data-bs-toggle="tab" data-bs-target="#order-templates-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Order Templates</button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div div class="tab-pane fade show active" id="order-templates-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                        <h1 class="head">Order Templates</h1>
                                        <div class="border card my-4">
                                            <!-- Components -->
                                            <div class="col-md-6">
                                                <h5>Drag & Drop components</h5>
                                                <hr>
                                                <div class="tabbable">
                                                    <ul class="nav nav-tabs" id="formtabs"></ul>
                                                    <form class="form-horizontal" id="components" role="form">
                                                        <fieldset>
                                                            <div class="tab-content"></div>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- / Components -->
                                            <!-- Building Form. -->
                                            <div class="col-md-6">
                                                <h5>Your Form</h5>
                                                <hr>
                                                <div id="build">
                                                    <form id="target" class="form-horizontal"></form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /widget-content -->
                    </div>
                    <!-- /widget -->
                </div>
                <!-- /span8 -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /main-inner -->
</div>
<!-- /main -->
<script data-main="assets/js/main-built.js" src="assets/js/lib/require.js" ></script>
<script>
    $(document).ready(function () {
        // $('#operator-table').dataTable();
    });
</script>