<?php

$pagePath = explode('/wp-content/', dirname(__FILE__));
include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));

require_once( OVA_PLUGIN_PATH.'/inc/Ova_PaypalIPN.php' );

// Set this to true to use the sandbox endpoint during testing:
$enable_sandbox = ( OVAEM_Settings::paypal_envi() == 'live' ) ? false : true;

// Set this to true to save a log file:
$save_log_file = OVAEM_Settings::paypal_save_log();
$log_file_dir = OVA_PLUGIN_PATH . "/logs";


$ipn = new PaypalIPN();
if ($enable_sandbox) {
    $ipn->useSandbox();
}
$verified = $ipn->verifyIPN();

$data_text = "";
foreach ($_POST as $key => $value) {
    $data_text .= $key . " = " . $value . "\r\n";
}

$test_text = "";
if ($_POST["test_ipn"] == 1) {
    $test_text = "Test ";
}
$receiver_email_found = true;

list($year, $month, $day, $hour, $minute, $second, $timezone) = explode(":", date("Y:m:d:H:i:s:T"));
$date = $year . "-" . $month . "-" . $day;
$timestamp = $date . " " . $hour . ":" . $minute . ":" . $second . " " . $timezone;
$dated_log_file_dir = $log_file_dir . "/" . $year . "/" . $month;

$paypal_ipn_status = "VERIFICATION FAILED";
if ($verified) {
    $paypal_ipn_status = "RECEIVER EMAIL MISMATCH";
    if ($receiver_email_found) {
        $paypal_ipn_status = "Completed Successfully";

        // Process IPN
        // A list of variables are available here:
        // https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/

        // Update Order: Status, Gateway
        $order_id = $_POST['custom'];
        $gateway = 'Paypal';
        $payment_status = $_POST['payment_status'];
        $transaction_id = $_POST['txn_id'];
        $payer_email = $_POST['payer_email'];
        OVA_Add_Order::ova_update_order( $order_id , $gateway, $payment_status, $transaction_id, $payer_email );


    }
}elseif ($enable_sandbox) {
    if ($_POST["test_ipn"] != 1) {
        $paypal_ipn_status = "RECEIVED FROM LIVE WHILE SANDBOXED";
    }
} elseif ($_POST["test_ipn"] == 1) {
    $paypal_ipn_status = "RECEIVED FROM SANDBOX WHILE LIVE";
}


// Save Log file
if ($save_log_file == 'true') {
    // Create log file directory
    if (!is_dir($dated_log_file_dir)) {
        if (!file_exists($dated_log_file_dir)) {
            mkdir($dated_log_file_dir, 0777, true);
            if (!is_dir($dated_log_file_dir)) {
                $save_log_file = 'false';
            }
        } else {
            $save_log_file = 'false';
        }
    }
    // Restrict web access to files in the log file directory
    $htaccess_body = "RewriteEngine On" . "\r\n" . "RewriteRule .* - [L,R=404]";
    if ($save_log_file == 'true' && (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body)) {
        if (!is_dir($log_file_dir . "/.htaccess")) {
            file_put_contents($log_file_dir . "/.htaccess", $htaccess_body);
            if (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body) {
                $save_log_file = 'false';
            }
        } else {
            $save_log_file = 'false';
        }
    }
    if ($save_log_file == 'true') {
        // Save data to text file
        file_put_contents($dated_log_file_dir . "/" . $test_text . "paypal_ipn_" . $date . ".txt", "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text . "\r\n", FILE_APPEND);
    }
}



// Reply with an empty 200 response to indicate to paypal the IPN was received correctly
header("HTTP/1.1 200 OK");
