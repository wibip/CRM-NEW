<?php
include 'header_new.php';
$page = "Order Templates";
?>
<!-- <link rel="stylesheet" href="css/bootstrap5.2.min.css" type="text/css" /> -->
<style>
    .del-button {
        padding: 0px !important;
    }
    .toggle-form {
        padding: 0px !important;
    }
    .copy-button {
        padding: 0px !important;
    }
    .remove {
        padding: 0px !important;
    }

    input[type=checkbox]+label{
        text-indent: 25px;
        overflow: visible;
        white-space: nowrap;
        position: relative;
    }

    input[type=checkbox]+label::after{
        position: absolute;
        top: 0;
    }



</style>
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
                className: "span4 form-control",
                label: "Property Name",
                placeholder: "",
                name: "first-name",
                required: true,
                type: "text"
            }, {
                className: "span4 form-control",
                label: "Service Type",
                name: "select-1454862249997",
                type: "select",
                multiple: "true",
                values: [{
                    label: 'Please select service type',
                    value: '0'
                    }, {
                    label: 'FRT-VYOS',
                    value: 'FRT-VYOS'
                    }, {
                    label: 'FRT AC Service TYPE',
                    value: 'FRT AC Service TYPE'
                    }, {
                    label: 'frt-vyos-vpt-acc-on',
                    value: 'frt-vyos-vpt-acc-on'
                    }
            ]
            },{
                className: "span4 form-control",
                label: "Contact Name",
                placeholder: "",
                name: "first-name",
                required: true,
                type: "text"
            },{
                className: "span4 form-control",
                label: "Contact Email",
                placeholder: "",
                name: "first-name",
                required: true,
                type: "text"
            },{
                className: "span4 form-control",
                label: "City",
                placeholder: "",
                name: "first-name",
                required: true,
                type: "text"
            },{
                className: "span4 form-control",
                label: "Unique Property ID",
                placeholder: "",
                name: "first-name",
                required: true,
                type: "text"
            },{
                className: "span4 form-control",
                label: "Contact Number",
                placeholder: "",
                name: "first-name",
                required: true,
                type: "text"
            },{
                className: "span4 form-control",
                label: "Address",
                placeholder: "",
                name: "first-name",
                required: true,
                type: "text"
            },{
                className: "span4 form-control",
                label: "Zip",
                placeholder: "",
                name: "first-name",
                required: true,
                type: "text"
            },
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