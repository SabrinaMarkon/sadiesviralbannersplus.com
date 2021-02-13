<?php

/**
 * MonthlyBonus assigns each member their free monthly bonus ads.
 * PHP 5.4+
 * @author Sabrina Markon
 * @copyright 2021 Sabrina Markon, PHPSiteScripts.com
 * @license LICENSE.md
 */
require_once('../../config/Database.php');
require_once('../../config/Settings.php');

class MonthlyBonus
{
    private $pdo;

    private function __construct()
    {
    }

    public static function giveMembersMonthlyBonuses(array $settings, TextAd $textad, Banner $banner, NetworkSolo $networksolo)
    {
        // get all mails that are marked as pending mailout.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "select * from members where verified!='' order by id";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $members = $q->fetchAll();

        if ($members) {

            foreach ($members as $member) {

                $username = $member["username"];
                $accounttype = $member["accounttype"];
                
                if ($accounttype === "Gold") {
                    if ($settings["goldmonthlybonustextads"] > 0) {

                        echo $username . " gets " . $settings["goldmonthlybonustextads"] . " text ads<br/>";
                        for($i = 0; $i < $settings["goldmonthlybonustextads"]; $i++) {
                            $textad->createBlankAd($username);
                        }
                    }
                    if ($settings["goldmonthlybonusbannerspaid"] > 0) {

                        echo $username . " gets " . $settings["goldmonthlybonusbannerspaid"] . " banners<br/>";
                        for($i = 0; $i < $settings["goldmonthlybonusbannerspaid"]; $i++) {
                            $banner->createBlankAd($username);
                        }
                    }
                    if ($settings["goldmonthlybonusnetworksolos"] > 0) {

                        echo $username . " gets " . $settings["goldmonthlybonusnetworksolos"] . " network solos<br/>";
                        for($i = 0; $i < $settings["goldmonthlybonusnetworksolos"]; $i++) {
                            $networksolo->createBlankAd($username);
                        }
                    }
                }
                elseif ($accounttype === "Pro") {
                    if ($settings["promonthlybonustextads"] > 0) {

                        echo $username . " gets " . $settings["promonthlybonustextads"] . " text ads<br/>";
                        for($i = 0; $i < $settings["promonthlybonustextads"]; $i++) {
                            $textad->createBlankAd($username);
                        }
                    }
                    if ($settings["promonthlybonusbannerspaid"] > 0) {

                        echo $username . " gets " . $settings["promonthlybonusbannerspaid"] . " banners<br/>";
                        for($i = 0; $i < $settings["promonthlybonusbannerspaid"]; $i++) {
                            $banner->createBlankAd($username);
                        }
                    }
                    if ($settings["promonthlybonusnetworksolos"] > 0) {

                        echo $username . " gets " . $settings["promonthlybonusnetworksolos"] . " network solos<br/>";
                        for($i = 0; $i < $settings["promonthlybonusnetworksolos"]; $i++) {
                            $networksolo->createBlankAd($username);
                        }
                    }
                }
                else {
                    if ($settings["freemonthlybonustextads"] > 0) {

                        echo $username . " gets " . $settings["freemonthlybonustextads"] . " text ads<br/>";
                        for($i = 0; $i < $settings["freemonthlybonustextads"]; $i++) {
                            $textad->createBlankAd($username);
                        }
                    }
                    if ($settings["freemonthlybonusbannerspaid"] > 0) {

                        echo $username . " gets " . $settings["freemonthlybonusbannerspaid"] . " banners<br/>";
                        for($i = 0; $i < $settings["freemonthlybonusbannerspaid"]; $i++) {
                            $banner->createBlankAd($username);
                        }
                    }
                    if ($settings["freemonthlybonusnetworksolos"] > 0) {

                        echo $username . " gets " . $settings["freemonthlybonusnetworksolos"] . " network solos<br/>";
                        for($i = 0; $i < $settings["freemonthlybonusnetworksolos"]; $i++) {
                            $networksolo->createBlankAd($username);
                        }
                    }
                }

            }
        }

        Database::disconnect();

        echo "<br />ONE Monthly Bonus Ads!!!<br />";
    }
}

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();

$monthlybonuses = MonthlyBonus::giveMembersMonthlyBonuses($settings, new TextAd("textad"), new Banner("bannerspaid"), new NetworkSolo("networksolo"));
