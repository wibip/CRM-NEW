<?php ob_start(); ?>
<!DOCTYPE html>

<html lang="en">

<?php
session_start();
include 'header_top.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

/* No cache*/
//header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();
require_once 'classes/systemPackageClass.php';
$package_functions = new package_functions();


require_once 'classes/CommonFunctions.php';

/*Encryption script*/
include_once 'classes/cryptojs-aes.php';

?>

<head>

    <meta charset="utf-8">
    <title>Provisioning</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css?v=1" rel="stylesheet">
    <link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="js/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="css/select2-bootstrap/select2-bootstrap.css" />
    <link href="css/bootstrap-colorpicker.css?v=19" rel="stylesheet">
    <link href="plugins/img_upload/assets/css/croppic.css" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap-toggle.min.css" />
    <link rel="stylesheet" href="css/tablesaw.css?v1.2">

    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script src="js/locationpicker.jquery.js"></script>

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-toggle.min.js"></script>


    <!--Ajax File Uploading Function-->


    <!--table colimn show hide-->
    <script type="text/javascript" src="js/tablesawNew.js"></script>
    <!--Encryption -->
    <script type="text/javascript" src="js/aes.js"></script>
    <script type="text/javascript" src="js/aes-json-format.js"></script>

    <link rel="stylesheet" href="css/bootstrapValidator.css" />


    <?php
    $data_secret = $db->setVal('data_secret', 'ADMIN');
    include 'header.php';

    require_once 'layout/' . $camp_layout . '/config.php';


    if (isset($_GET['edit'])) {
        if ($_GET['token'] == $_SESSION['FORM_SECRET']) {
            $id = $_GET['id'];

            $q = "SELECT property_details,status FROM exp_provisioning_properties WHERE mno_id='$user_distributor' AND id='$id' AND status<>'4'";

            $data = $db->select1DB($q);
            //print_r($data);
            if(count($data)>0){
                $edit = true;
                //$_GET['t']='provision_create';
                $prop_details = json_decode($data['property_details'],true);
                $parent_properties_count = count($prop_details['property']);
                $prop_details_new = $prop_details['property'][0];
                $prop_service_type = $prop_details['location_info'][0]['service_type'];
                /*Service type options*/
//                $q2 = "SELECT `setting` FROM exp_provisioning_setting WHERE id='$prop_service_type' AND `mno_id`='$user_distributor'";
//                $service_details = json_decode($db->select1DB($q2)['setting'],true);
                //print_r($service_details);
                $edit_acc_state = $data['status'];

            }
        }
    }

    if(isset($_GET['remove_id'])){
        if ($_GET['token'] == $_SESSION['FORM_SECRET']) {
            $remove_id = $_GET['remove_id'];
            $select_info_q = "SELECT property_details FROM exp_provisioning_properties WHERE id='$remove_id' AND status<>'4'";
            $select_info = $db->select1DB($select_info_q);
            $property_details = json_decode($select_info['property_details'],true);
            $delete_bus_id = $property_details['account_info']['business_id'];
            $delete_loc_id = $property_details['location_info'][0]['location_id'];
            $delete_vt_id = $property_details['location_info'][0]['vt_location_id'];
            $q = "DELETE FROM exp_provisioning_properties WHERE mno_id='$user_distributor' AND id='$remove_id'";
            if(strlen($delete_loc_id)>0){
                //delete form user
                $db->execDB("DELETE FROM admin_users WHERE verification_number='$delete_loc_id'");
            }
            if(strlen($delete_vt_id)>0){
                //delete form property
                $db->execDB("DELETE FROM mdu_distributor_organizations WHERE property_id='$delete_vt_id'");
            }
            $delete = $db->execDB($q);
            if($delete===true){
                //delete form user
                $db->execDB("DELETE FROM admin_users WHERE verification_number='$delete_bus_id'");
                $_SESSION['msg20']='<div class="alert alert-success"> <strong>Provisioning Business ID['.$delete_bus_id.'] is deleted successfully.</strong></div>';
            }else{
                $_SESSION['msg20']='<div class="alert alert-danger"> <strong>Provisioning Business ID['.$delete_bus_id.'] deleting is failed.</strong></div>';
            }
        }
    }
    foreach ($modules[$user_type][$script] as $value) {
        $submit_form = 'modules/' . $value['submit'] . '.php';
        if (file_exists($submit_form)) {
            //require_once 'modules/' . $modules['tab_menu']['submit'] . '.php';
            require_once $submit_form;
        }
    }

    // TAB Organization
    if (isset($_GET['t'])) {
        $variable_tab = 'tab_' . $_GET['t'];
        $$variable_tab = 'set';
    }

    //Form Refreshing avoid secret key/////
    $secret = md5(uniqid(rand(), true));
    $_SESSION['FORM_SECRET'] = $secret;

    ?>
    <div class="main">
        <div class="custom-tabs"></div>
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <br class="hideBr"><br class="hideBr">
                        <div class="widget ">


                            <div class="widget-header">

                                <h3>View and Manage Properties</h3>


                            </div><!-- /widget-header -->


                            <div class="widget-content">
                                <div class="tabbable">
                                    <?php require_once 'modules/' . $modules['tab_menu']['module'] . '.php'; ?>
                                    <div class="tab-content">

                                        <?php

                                        if (isset($_SESSION['msg20'])) {
                                            echo $_SESSION['msg20'];
                                            unset($_SESSION['msg20']);
                                        }
                                        if (isset($_SESSION['msg5'])) {
                                            echo $_SESSION['msg5'];
                                            unset($_SESSION['msg5']);
                                        }
                                        //if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE' || $user_type == 'SUPPORT' || $user_type == 'SALES'){
                                        foreach ($modules[$user_type][$script] as $value) {
                                            //echo 'modules/'.$value['module'].'.php';
                                            include_once 'modules/' . $value['module'] . '.php';
                                        }
                                        //}
                                        ?>

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

    <script type="text/javascript" src="js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator_new.js?v=1"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#location_form').bootstrapValidator({

                framework: 'bootstrap',
                excluded: [':disabled',function($field, validator) {
                    return (!$field.is(':visible') || $field.is(':hidden'));
                }],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    business_id: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>,
                            <?php echo $db->validateField('parent_id'); ?>,
                            <?php if($edit!==true){ ?>
                                remote: {
                                    url: 'ajax/validateIcom.php',
                                    data: function(validator, $field, value) {
                                        return {
                                            parent_id: validator.getFieldElements('business_id').val(),
                                        };
                                    },
                                    message: '<p>Business ID Account Exists</p>',
                                    type: 'POST'
                                },
                            <?php } ?>
                        }
                    },
                    business_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    admin_f_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    admin_f_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    admin_l_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    verify_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>,
                            <?php echo $db->validateField('email_not_same'); ?>
                            
                        }
                    },
                    admin_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>,
                            <?php echo $db->validateField('email_not_same_c'); ?>
                        }
                    },
                    service_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    location_id: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    location_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    address: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    city: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    country: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    state: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    time_zone: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    zip_code: {
                        validators: {
                            <?php echo $db->validateField('zip_code'); ?>
                        }
                    },
                    phone_number: {
                        validators: {
                            <?php echo $db->validateField('mobile'); ?>
                        }
                    },
                    no_of_guest_ssid: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    no_of_pvt_ssid: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    vt_location_id: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    }
                    
                }
            });
            });
    </script>
        <?php


        include 'footer.php';

        ?>

            <!--Alert message-->
            <link rel = "stylesheet"
        href = "css/jquery-ui-alert.css"
        type = "text/css" />

            <!--tool tip css-->
            <link rel = "stylesheet"
        type = "text/css"
        href = "css/tooltipster-shadow.css" />
            <link rel = "stylesheet"
        type = "text/css"
        href = "css/tooltipster.css" />


            <!--jquery code for upload browse button-->
        <script src = "js/jquery.filestyle.js"
        type = "text/javascript"
        charset = "utf-8" >
    </script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
    <script src="js/select2-3.5.2/select2.min.js"></script>