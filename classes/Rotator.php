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

    private 
    $pdo,
    $sql,
    $q,
    $data,
    $url;

    public function __construct(string $adtable, array $settings)
    {
        $this->adtable = $adtable;
        $this->settings = $settings;
    }

    public function giveClick(int $id): ?string
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

            return null;
        }
    }

    public function giveHit(int $id): void
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update " . $this->adtable . " set hits=hits+1 where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        Database::disconnect();
    }

    public function countMemberClick(string $username, int $id): void
    {
        
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "select accounttype from members where username=?";
        $q = $pdo->prepare($sql);
        $q->execute([$username]);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetch();
        if (!empty($data['accounttype'])) {

            $accounttype = $data['accounttype'];
            $accounttypelc = strtolower($accounttype);
            $adclickstogettextad = $accounttypelc . "adclickstogettextad";
            $adclickstogettextad = $this->settings[$adclickstogettextad];
            $adclickstogetbannerspaid = $accounttypelc . "adclickstogetbannerspaid";
            $adclickstogetbannerspaid = $this->settings[$adclickstogetbannerspaid];
            $adclickstogetnetworksolo = $accounttypelc . "adclickstogetnetworksolo";
            $adclickstogetnetworksolo = $this->settings[$adclickstogetnetworksolo];

            if ($adclickstogettextad > 0 && $this->adtable === 'textads') {
                $sql = "update members set textadclicks=textadclicks+1 where username=?";
            }
            if ($adclickstogetbannerspaid > 0 && ($this->adtable === 'bannerspaid' || $this->adtable === 'viralbanners')) {
                $sql = "update members set banneradclicks=banneradclicks+1 where username=?";
            }
            if ($adclickstogetnetworksolo > 0 && $this->adtable === 'networksolos') {
                $sql = "update members set networksoloclicks=networksoloclicks+1 where username=?";
            }
            $q = $pdo->prepare($sql);
            $q->execute([$username]);

            // Does the member get a free ad?
            $sql = "select textadclicks, banneradclicks, networksoloclicks from members where username=?";
            $q = $pdo->prepare($sql);
            $q->execute([$username]);
            $q->setFetchMode(PDO::FETCH_ASSOC);
            $res = $q->fetch();
            if ($res) {
                $textadclicks = $res['textadclicks'];
                if ($textadclicks >= $adclickstogettextad && $adclickstogettextad > 0) {
                    $ad = new Banner($this->adtable);
                    $ad->createBlankAd($username, '');
                    // Reset click counter:
                    $sql = "update members set textadclicks=textadclicks-? where username=?";
                    $q = $pdo->prepare($sql);
                    $q->execute([$adclickstogettextad, $username]);
                }
                $banneradclicks = $res['banneradclicks'];
                if ($banneradclicks >= $adclickstogetbannerspaid && $adclickstogetbannerspaid > 0) {
                    $ad = new TextAd($this->adtable);
                    $ad->createBlankAd($username, '');
                    // Reset click counter:
                    $sql = "update members set banneradclicks=banneradclicks-? where username=?";
                    $q = $pdo->prepare($sql);
                    $q->execute([$adclickstogetbannerspaid, $username]);
                }
                $networksoloclicks = $res['networksoloclicks'];
                if ($networksoloclicks >= $adclickstogetnetworksolo && $adclickstogetnetworksolo > 0) {
                    $ad = new NetworkSolo($this->adtable);
                    $ad->createBlankAd($username, '');
                    // Reset click counter:
                    $sql = "update members set networksoloclicks=networksoloclicks-? where username=?";
                    $q = $pdo->prepare($sql);
                    $q->execute([$adclickstogetnetworksolo, $username]);
                }
            }
        }

        Database::disconnect();
    }

    public function getAds(int $limit): ?array
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($this->adtable === 'networksolos') {
            $sql = "select * from " . $this->adtable . " where added=1 and approved=1 and sent!='Not Yet' order by rand() limit " . $limit;
        } else {
            $sql = "select * from " . $this->adtable . " where added=1 and approved=1 order by rand() limit " . $limit;
        }
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ads = $q->fetchAll();

        if ($ads) {

            return $ads;
        }

        Database::disconnect();

        return null;
    }
}
