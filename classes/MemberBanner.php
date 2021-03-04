<?php

/**
Child class to handle individual member banners only.
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

class MemberBanner extends Banner
{
    private $pdo, $q, $sql, $memberbanner;

    public function getMemberBanner(string $username, int $slot): array
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " where username=? and bannerpageslot=? and approved=1 limit 1";
        $q = $pdo->prepare($sql);
        $q->execute([$username, $slot]);
        $memberbanner = $q->fetch();

        Database::disconnect();

        if ($memberbanner) {

            return $memberbanner;
        }

        return [];
    }

    public function getRandomBannerOfCertainMembershipLevel(Sponsor $sponsor, string $accounttype, int $slot): array
    {
        $username = $sponsor->getRandomUsername($accounttype);

        if (!empty($username)) {

            $pdo = DATABASE::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from " . $this->adtable . " where username=? and bannerpageslot=? and approved=1 limit 1";
            $q = $pdo->prepare($sql);
            $q->execute([$username, $slot]);
            $memberbanner = $q->fetch();

            Database::disconnect();

            if ($memberbanner) {

                return $memberbanner;
            }
        }

        return [];
    }

    // Get an array of the csv string for a banner slot admin setting.
    public function getVarArray(string $varname): array
    {

        $varvalue = $$varname;
        $vararray = [];

        if (!empty($varvalue)) {
            $vararray = explode(',', $varvalue);
        }

        return $vararray;
    }

}
