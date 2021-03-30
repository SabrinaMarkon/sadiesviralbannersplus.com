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
        $sql = "select * from " . $this->adtable . " where username=? and bannerpageslot=? and approved=1 order by rand() limit 1";
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

    public function showBanner(array $banner, int $width, int $height, int $i): string {

        $id = $banner['id'];
        $alt = $banner['alt'];
        $imageurl = $banner['imageurl'];

        // Count hit (impression):
        $this->countBannerHit($id);

        // If banner will be clicked in Viral Banners members area, the click should open the modal to EDIT the Viral Banner instead of its URL.

        if ($i) {
            return '
            <div>
                <a href="#" data-toggle="modal" data-target="#viralbannerModal' . $i . '">
                    <img alt="' . $alt . '" src="' . $imageurl . '" width="' . $width . '" height="' . $height . '" />
                </a>
            </div>'; 
        }

        return '
        <div>
            <a href="/click/' . $this->adtable . '/' . $id . '" target="_blank">
                <img alt="' . $alt . '" src="' . $imageurl . '" width="' . $width . '" height="' . $height . '" />
            </a>
        </div>';  
    }

    public function countBannerHit(int $id): void {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update " . $this->adtable . " set hits=hits+1 where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        Database::disconnect();
    }

    public function showBannerPlaceholder(int $i, int $width, int $height, string $msg): string {
        
        $msguppercase = strtoupper($msg);
        $msguppercase = str_replace(" ", "+", $msguppercase);

        return '
        <div>
            <a style="width: ' . $width . 'px; height: ' . $height . 'px; background: #fff; margin: 1rem;" href="#" data-toggle="modal" data-target="#viralbannerModal' . $i . '">' . $msg . '</a>
        </div>';
    }
}
