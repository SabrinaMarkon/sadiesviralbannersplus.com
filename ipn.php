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
// if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
//     header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
//     exit;
// }

# get the end part of the url, which is normally the referid for the main site files, but will be actually the name of the payment company for this file only.
$paidwith = $_SESSION['referid'];
echo $paidwith;

// require_once "classes/User.php"; // TODO: We need to check for duplicate usernames/emails.
// require_once "classes/PaypalCheckout.php"; // Paypal.
// require_once "classes/FormValidation.php"; // Check that username isn't duplicate if this is a new signup. Don't do for upgrades.

// $user = new User();
// $validator = new FormValidation();
// $paypal = new PaypalCheckout($paymentdata, $user);
// $paypalIPN = $paypal->getIPN();


