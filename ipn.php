<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
Paypal payment IPN file to receive notifications from Paypal and update database purchase to paid status.
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
# Prevent direct access to this file. Show browser's default 404 error instead.
// TODO: UNCOMMENT BELOW WHEN DONE TESTING!
// if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
//     header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
//     exit;
// }

# get the end part of the url, which is normally the referid for the main site files (set in index.php), 
# but will be actually the name of the payment company for this file only.
$paidwith = $_SESSION['referid'];

$paymentcompanies = ["paypal", "coinpayments"];

if (in_array($paidwith, $paymentcompanies)) {
    
    unset($_SESSION['referid']); // We don't need to remember this anymore now that we know the value of paidwith.

    $user = new User();
    $commission = new Commission();

    if ($paidwith === "paypal") {
        // Note below that the paymentdata array (first parameter) isn't needed for ipn (it is only for storing the data in pendingpurchases to retrieve.)
        $pay = new PaypalCheckout([], $user, $_POST, $settings); 
        $pay->getIPN($commission);
    }

    elseif ($paidwith === "coinpayments") {
        $api = new CoinPaymentsAPI();
        $pay = new CoinPaymentsCheckout([], $user, $_POST, $settings, $api); 
        $pay->getIPN($commission);
    }

    else {
        exit;
    }

}


