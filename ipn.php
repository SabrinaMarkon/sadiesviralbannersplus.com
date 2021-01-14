<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
Payment IPN file to receive notifications from payment processing companies and update database purchase to paid status.
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
// if (count(get_included_files()) === 1) { exit('Direct Access is not Permitted'); }
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require_once "config/Database.php";
require_once "classes/User.php"; // TODO: We need to check for duplicate usernames/emails.
require_once "classes/PaypalCheckout.php"; // Paypal.

$user = new User();
$paypal = new PaypalCheckout($paymentdata, $user);
$paypalIPN = $paypal->getIPN();

