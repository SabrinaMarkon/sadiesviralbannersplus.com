<?php

/**
Handles user advertising.
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

abstract class Ad
{

    // TODO: Extract database stuff to the Database class instead of in all the classes ->>>> not DRY at all!!!
    protected $pdo, $q, $sql;

    public function __construct(string $adtable)
    {
        $this->adtable = $adtable; // Name of database table for this kind of ad (ie. banners, textads, etc.)
    }

    // Child classes each need to be able to create an ad or edit and save an ad.
    abstract function createAd(int $id, int $adminautoapprove, string $source, array $post): ?string;
    abstract function saveAd(int $id, int $adminautoapprove, int $isadmin, array $post): string;

    /* Get all the ads for all members. */
    public function getAllAds(): array
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " order by approved asc, id desc";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ads = $q->fetchAll();

        Database::disconnect();

        return $ads;
    }

    /* Get all the ads for one member. */
    public function getAllUsersAds(string $username): ?array //TODO: See if we can return an empty array instead of null so don't need the ?
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " where username=? and added=1 order by approved, id desc";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ads = $q->fetchAll();

        Database::disconnect();

        if ($ads) {

            return $ads;
        }

        return null;
    }

    /* Get all the approved ads for one member. */
    public function getAllApprovedUsersAds(string $username): array
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " where username=? and approved=1 order by id desc";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ads = $q->fetchAll();

        Database::disconnect();

        if ($ads) {

            return $ads;
        }

        return [];
    }

    /* Call this when we need to get the member a blank ad to create a new ad in the form. */
    public function getBlankAd(string $username): ?array
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " where username=? and added=0 order by id limit 1";
        $q = $pdo->prepare($sql);
        $q->execute([$username]);
        $blankad = $q->fetch();

        Database::disconnect();

        if ($blankad) {

            return $blankad;
        }

        return null;
    }

    /* When a user has paid for an ad and we receive the IPN notification, we create a blank ad for that user. */
    public function createBlankAd(string $username, string $givememberblankad)
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "insert into " . $this->adtable . " (username,adddate) values (?,NOW())";
        $q = $pdo->prepare($sql);
        $q->execute([$username]);

        # get the adid of the newly inserted blank ad.
        $adid = $pdo->lastInsertId();

        Database::disconnect();

        if ($givememberblankad) {
            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>" . $givememberblankad . " blank ads were given to username " . $username . "</strong></div>";
        }

        return $adid;
    }

    /* Call this to delete an ad. */
    public function deleteAd(int $id, string $name): string
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from " . $this->adtable . " where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));

        /* We don't do this below because the viralbannersclicks table is ONLY to count how many clicks
           a new member has made to meet the requirement to click x viralbanners before having membership confirmed.
        */
        // if ($this->adtable === 'viralbanners') {
        //     $sql = "delete from viralbannersclicks where bannerid=?";
        //     $q = $pdo->prepare($sql);
        //     $q->execute(array($id));
        // }

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Ad " . $name . " was Deleted</strong></div>";
    }

    /* Save ad settings */
    public function saveAdSettings(array $post): string
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($this->adtable === "textads") {
            $adprice = $post['textadprice'];
            $adhits = $post['textadhits'];
            $sql = "update adminsettings set textadprice=?, textadhits=?";
            $q = $pdo->prepare($sql);
            $q->execute([$adprice, $adhits]);
        }
        if ($this->adtable === "bannerspaid") {
            $adprice = $post['bannerprice'];
            $adhits = $post['bannerhits'];
            $sql = "update adminsettings set bannerprice=?, bannerhits=?";
            $q = $pdo->prepare($sql);
            $q->execute([$adprice, $adhits]);
        }
        if ($this->adtable === "viralbanners") {
            
            // checkbox arrays - store as csvs in database.
            $newfreebannerslots = '';
            if (isset($post['freebannerslots'])) {
                $newfreebannerslots = implode(',', $post['freebannerslots']);
            }
            $newfreerefersfreebannerslots = '';
            if (isset($post['freerefersfreebannerslots'])) {
                $newfreerefersfreebannerslots = implode(',', $post['freerefersfreebannerslots']);
            }
            $newfreerefersprobannerslots = '';
            if (isset($post['freerefersprobannerslots'])) {
                $newfreerefersprobannerslots = implode(',', $post['freerefersprobannerslots']);
            }
            $newfreerefersgoldbannerslots = '';
            if (isset($post['freerefersgoldbannerslots'])) {
                $newfreerefersgoldbannerslots = implode(',', $post['freerefersgoldbannerslots']);
            }
            $newprobannerslots = '';
            if (isset($post['probannerslots'])) {
                $newprobannerslots = implode(',', $post['probannerslots']);
            }
            $newprorefersfreebannerslots = '';
            if (isset($post['prorefersfreebannerslots'])) {
                $newprorefersfreebannerslots = implode(',', $post['prorefersfreebannerslots']);
            }
            $newprorefersprobannerslots = '';
            if (isset($post['prorefersprobannerslots'])) {
                $newprorefersprobannerslots = implode(',', $post['prorefersprobannerslots']);
            }
            $newprorefersgoldbannerslots = '';
            if (isset($post['prorefersgoldbannerslots'])) {
                $newprorefersgoldbannerslots = implode(',', $post['prorefersgoldbannerslots']);
            }
            $newgoldbannerslots = '';
            if (isset($post['goldbannerslots'])) {
                $newgoldbannerslots = implode(',', $post['goldbannerslots']);
            }
            $newgoldrefersfreebannerslots = '';
            if (isset($post['goldrefersfreebannerslots'])) {
                $newgoldrefersfreebannerslots = implode(',', $post['goldrefersfreebannerslots']);
            }
            $newgoldrefersprobannerslots = '';
            if (isset($post['goldrefersprobannerslots'])) {
                $newgoldrefersprobannerslots = implode(',', $post['goldrefersprobannerslots']);
            }
            $newgoldrefersgoldbannerslots = '';
            if (isset($post['goldrefersgoldbannerslots'])) {
                $newgoldrefersgoldbannerslots = implode(',', $post['goldrefersgoldbannerslots']);
            }

            $sql = "update adminsettings set freebannerslots=?, freerefersfreebannerslots=?, freerefersprobannerslots=?, freerefersgoldbannerslots=?, probannerslots=?, prorefersfreebannerslots=?, prorefersprobannerslots=?, prorefersgoldbannerslots=?, goldbannerslots=?, goldrefersfreebannerslots=?, goldrefersprobannerslots=?, goldrefersgoldbannerslots=?";
            $q = $pdo->prepare($sql);
            $q->execute([$newfreebannerslots, $newfreerefersfreebannerslots, $newfreerefersprobannerslots, $newfreerefersgoldbannerslots, $newprobannerslots, $newprorefersfreebannerslots, $newprorefersprobannerslots, $newprorefersgoldbannerslots, $newgoldbannerslots, $newgoldrefersfreebannerslots, $newgoldrefersprobannerslots, $newgoldrefersgoldbannerslots]);
        }
        if ($this->adtable === "networksolos") {
            $adprice = $post['networksoloprice'];
            $sql = "update adminsettings set networksoloprice=?";
            $q = $pdo->prepare($sql);
            $q->execute([$adprice]);
        }

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Ad Settings Saved!</strong></div>";
    }
}
