<?php
/**
Get sponsor and downline information for members.
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

class Downline {

    public function __construct(string $username) {

        $this->username = $username;
    }

    public function getUsernameSponsor(string $username): array {

        return sponsorinfo;
    }

    public function getEachSponsorForEachLevel(int $level): array {


        return $allsponsorsinfo;
    }

    

}