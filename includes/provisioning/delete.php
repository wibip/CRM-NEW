<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);*/
/// Create Account  or Edit Account/////

if (isset($_GET['delete_service'])) {

    if ($_SESSION['FORM_SECRET'] == $_GET['token']) {

        $result = $provisioning->delete($_GET['service_id']);

        if ($result) {
            $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('service_type_delete_success', '2004') . "</strong></div>";
        } else {
            $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('service_type_delete_fail', '2004') . "</strong></div>";
        }
    }
}
