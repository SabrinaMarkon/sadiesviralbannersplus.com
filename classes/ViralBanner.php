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

class ViralBanner extends Banner
{
    private $viralbanner;

    public function getViralBanner(string $username, int $slot): array
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " where username=? and bannerpageslot=? and approved=1 limit 1";
        $q = $pdo->prepare($sql);
        $q->execute([$username, $slot]);
        $viralbanner = $q->fetch();

        Database::disconnect();

        if ($viralbanner) {

            return $viralbanner;
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
            $viralbanner = $q->fetch();

            Database::disconnect();

            if ($viralbanner) {

                return $viralbanner;
            }

            return [];
        }

        return [];
    }

    // Get an array of the csv string for a banner slot admin setting.
    public function getVarArray(string $varname, array $settings): array
    {

        $varvalue = $settings[$varname];

        $vararray = [];

        if (!empty($varvalue)) {
            $vararray = explode(',', $varvalue);
        }

        return $vararray;
    }

    public function showBanner(array $banner, int $width, int $height): string {

        $id = $banner['id'];
        $alt = $banner['alt'];
        $imageurl = $banner['imageurl'];

        $showbanner = '
        <div>
            <a href="/click/' . $this->adtable . '/' . $id . '" target="_blank">
                <img alt="' . $alt . '" src="' . $imageurl . '>" width="' . $width . '" height="' . $height . '" />
            </a>
        </div>';

        return $showbanner;
    }

}