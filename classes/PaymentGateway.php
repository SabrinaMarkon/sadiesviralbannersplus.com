<?php
error_reporting(E_ALL);
/**
Payment gateway abstract class.
PHP 7.4+
@author Sabrina Markon
@copyright 2020 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
// if (count(get_included_files()) === 1) { exit('Direct Access is not Permitted'); }
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

abstract class PaymentGateway {
    abstract protected function _payButton();
    abstract public function getIPN(Commission $commission);
    abstract protected function _ipn(Commission $commission);
}