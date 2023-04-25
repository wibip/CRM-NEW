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
                                        <div id="ot-editor"></div>                            
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script> -->
<script src="js/jquery-ui.min.js"></script>
<script src="js/form-builder.min.js"></script>
<script>
jQuery(function($) {
    var options = {
        defaultFields: [{
                className: "form-control",
                label: "First Name",
                placeholder: "Enter your first name",
                name: "first-name",
                required: true,
                type: "text"
            }, {
                className: "form-control",
                label: "Select",
                name: "select-1454862249997",
                type: "select",
                multiple: "true",
                values: [{
                label: 'Custom Option 1',
                value: 'test-value'
                }, {
                label: 'Custom Option 2',
                value: 'test-value-2'
                }]
            }, {
                label: "Radio",
                name: "select-1454862249997",
                type: "radio-group"
            }
        ],
        disableFields: ['autocomplete',
                        'button',
                        'date',
                        'file',
                        'header',
                        'hidden',
                        'starRating'
        ],
        controlOrder: [
            'text',
            'textarea',
            'select',
            'checkbox-group',
            'radio-group',
            'paragraph',
            'number'
        ]
    };
    $(document.getElementById('ot-editor')).formBuilder(options);
});
</script>