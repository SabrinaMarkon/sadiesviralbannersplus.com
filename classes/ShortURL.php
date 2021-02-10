<?php
/**
Handles user interactions with the application.
PHP 7.4+
@author Sabrina Markon
@copyright 2018 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
**/
// if (count(get_included_files()) === 1) { exit('Direct Access is not Permitted'); }
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

class ShortURL {

    private $pdo;

    private function createURL(string $username) {

        # FIREBASE. // TODO: AUTOGENERATE these for ad urls and put them in the saved record for the ad automatically if people want to use them.

        // TODO: NOT HERE but I need to add wallet info to member accounts. Also show earnings in members area etc.

        // Screenshots of APP or animated gifs for main page!

    }

}