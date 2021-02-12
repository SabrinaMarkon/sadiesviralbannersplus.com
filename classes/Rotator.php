<?php

/**
Ad rotator.
PHP 7.4+
@author Sabrina Markon
@copyright 2018 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

class Rotator
{

    private $pdo;

    public function __construct(string $adtable, array $settings)
    {
        $this->adtable = $adtable;
        $this->settings = $settings;
    }

    public function giveClick(int $id)
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select url from " . $this->adtable . " where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);
        $url = $q->fetchColumn();

        if ($url) {

            $sql = "update " . $this->adtable . " set clicks=clicks+1 where id=?";
            $q = $pdo->prepare($sql);
            $q->execute([$id]);

            Database::disconnect();

            return $url;
        } else {

            Database::disconnect();
            return;
        }
    }

    public function giveHit(int $id)
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update " . $this->adtable . " set hits=hits+1 where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        Database::disconnect();
    }

    public function countMemberClick(string $username): void
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($this->settings['adclickstogettextad'] > 0 && $this->adtable === 'textads') {
            $sql = "update members set textadclicks=textadclicks+1 where username=?";
        }
        if ($this->settings['adclickstogetbannerspaidad'] > 0 && ($this->adtable === 'bannerspaid' || $this->adtable === 'banners')) {
            $sql = "update members set banneradclicks=banneradclicks+1 where username=?";
        }

        $q = $pdo->prepare($sql);
        $q->execute([$username]);

        // Does the member get a free ad?
        $sql = "select textadclicks, banneradclicks from members where username=?";
        $q = $pdo->prepare($sql);
        $q->execute([$username]);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $res = $q->fetch();
        if ($res) {
            $textadclicks = $res['textadclicks'];
            if ($textadclicks >= $this->settings['adclickstogettextad'] && $this->settings['adclickstogettextad'] > 0) {
                $ad = new Banner($this->adtable);
                $ad->createBlankAd($username);
                // Reset click counter:
                $sql = "update members set textadclicks=textadclicks-? where username=?";
                $q = $pdo->prepare($sql);
                $q->execute([$this->settings['adclickstogettextad'], $username]);
            }
            $banneradclicks = $res['banneradclicks'];
            if ($banneradclicks >= $this->settings['adclickstogetbannerspaidad'] && $this->settings['adclickstogetbannerspaidad'] > 0) {
                $ad = new TextAd($this->adtable);
                $ad->createBlankAd($username);
                // Reset click counter:
                $sql = "update members set banneradclicks=banneradclicks-? where username=?";
                $q = $pdo->prepare($sql);
                $q->execute([$this->settings['adclickstogetbannerspaidad'], $username]);
            }
        }

        Database::disconnect();
    }

    public function getAds()
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " where added=1 and approved=1 order by rand() limit 6";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ads = $q->fetchAll();

        if ($ads) {

            return $ads;
        }

        Database::disconnect();
    }
}
