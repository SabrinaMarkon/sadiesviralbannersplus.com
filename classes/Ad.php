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
    public function createBlankAd(string $username, string $howmanytogive)
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        for ($i = 0; $i < $howmanytogive; $i++) {
            $sql = "insert into " . $this->adtable . " (username,adddate) values (?,NOW())";
            $q = $pdo->prepare($sql);
            $q->execute([$username]);
        }

        # get the adid of the newly inserted blank ad.
        $adid = $pdo->lastInsertId();

        Database::disconnect();

        if ($howmanytogive) {
            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>" . $howmanytogive . " blank ads were given to username " . $username . "</strong></div>";
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

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Ad " . $name . " was Deleted</strong></div>";
    }

    /* Call this to approve all member ads of a certain type. */
    public function approveAllAds(): string {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update " . $this->adtable . " set approved=1";
        $q = $pdo->prepare($sql);
        $q->execute();

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>All Ads were Approved!</strong></div>"; 
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
            
            $sql = "update adminsettings set ";
            $pdoarray = [];

            $newfreebannerclickstosignup = $post['freebannerclickstosignup'];
            $newprobannerclickstosignup = $post['probannerclickstosignup'];
            $newgoldbannerclickstosignup = $post['goldbannerclickstosignup'];
            $newfreebannerclickstologin = $post['freebannerclickstologin'];
            $newprobannerclickstologin = $post['probannerclickstologin'];
            $newgoldbannerclickstologin = $post['goldbannerclickstologin'];

            $sql .= "freebannerclickstosignup=?, probannerclickstosignup=?, goldbannerclickstosignup=?, freebannerclickstologin=?, probannerclickstologin=?, goldbannerclickstologin=?, ";
            array_push($pdoarray, $newfreebannerclickstosignup, $newprobannerclickstosignup, $newgoldbannerclickstosignup, $newfreebannerclickstologin, $newprobannerclickstologin, $newgoldbannerclickstologin);

            // checkbox arrays - store as csvs in database:

            ## FREE REFERRALS: ##
            $newfreebannerslots = '';
            if (isset($post['freebannerslots'])) {
                $newfreebannerslots = implode(',', $post['freebannerslots']);
            }
            $sql .= "freebannerslots=?, ";
            array_push($pdoarray, $newfreebannerslots);

            // free bonus slots rewards for upgraded downline member count:
            $newfreedownlineupgradestogetbonusslotsonfreereferralpages = $post['freedownlineupgradestogetbonusslotsonfreereferralpages'];
            $newfreedownlineupgradestogetbonusslotsonproreferralpages = $post['freedownlineupgradestogetbonusslotsonproreferralpages'];
            $newfreedownlineupgradestogetbonusslotsongoldreferralpages = $post['freedownlineupgradestogetbonusslotsongoldreferralpages'];
            $sql .= "freedownlineupgradestogetbonusslotsonfreereferralpages=?, freedownlineupgradestogetbonusslotsonproreferralpages=?, freedownlineupgradestogetbonusslotsongoldreferralpages=?, ";
            array_push($pdoarray, $newfreedownlineupgradestogetbonusslotsonfreereferralpages, $newfreedownlineupgradestogetbonusslotsonproreferralpages, $newfreedownlineupgradestogetbonusslotsongoldreferralpages);      

            $newfreedownlineupgradeswhichbonusslotsonfreereferralpages = '';
            if (isset($post['freedownlineupgradeswhichbonusslotsonfreereferralpages'])) {
                $newfreedownlineupgradeswhichbonusslotsonfreereferralpages = implode(',', $post['freedownlineupgradeswhichbonusslotsonfreereferralpages']);
            }
            $sql .= "freedownlineupgradeswhichbonusslotsonfreereferralpages=?, ";
            array_push($pdoarray, $newfreedownlineupgradeswhichbonusslotsonfreereferralpages);
            $newfreedownlineupgradeswhichbonusslotsonproreferralpages = '';
            if (isset($post['freedownlineupgradeswhichbonusslotsonproreferralpages'])) {
                $newfreedownlineupgradeswhichbonusslotsonproreferralpages = implode(',', $post['freedownlineupgradeswhichbonusslotsonproreferralpages']);
            }
            $sql .= "freedownlineupgradeswhichbonusslotsonproreferralpages=?, ";
            array_push($pdoarray, $newfreedownlineupgradeswhichbonusslotsonproreferralpages);
            $newfreedownlineupgradeswhichbonusslotsongoldreferralpages = '';
            if (isset($post['freedownlineupgradeswhichbonusslotsongoldreferralpages'])) {
                $newfreedownlineupgradeswhichbonusslotsongoldreferralpages = implode(',', $post['freedownlineupgradeswhichbonusslotsongoldreferralpages']);
            }
            $sql .= "freedownlineupgradeswhichbonusslotsongoldreferralpages=?, ";
            array_push($pdoarray, $newfreedownlineupgradeswhichbonusslotsongoldreferralpages);

            // free refers free referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $freerefersfreebannerslots = 'freerefersfreebannerslots' . $i;
                // $newfreerefersfreebannerslots = 'newfreerefersfreebannerslots' . $i;
                $newfreerefersfreebannerslots = '';
                if (isset($post[$freerefersfreebannerslots])) {
                    $newfreerefersfreebannerslots = implode(',', $post[$freerefersfreebannerslots]);
                }
                $sql .= $freerefersfreebannerslots . "=?, ";
                array_push($pdoarray, $newfreerefersfreebannerslots);
            }
            // free refers pro referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $freerefersprobannerslots = 'freerefersprobannerslots' . $i;
                // $newfreerefersprobannerslots = 'newfreerefersprobannerslots' . $i;
                $newfreerefersprobannerslots = '';
                if (isset($post[$freerefersprobannerslots])) {
                    $newfreerefersprobannerslots = implode(',', $post[$freerefersprobannerslots]);
                }
                $sql .= $freerefersprobannerslots . "=?, ";
                array_push($pdoarray, $newfreerefersprobannerslots);
            }
            // free refers gold referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $freerefersgoldbannerslots = 'freerefersgoldbannerslots' . $i;
                // $newfreerefersgoldbannerslots = 'newfreerefersgoldbannerslots' . $i;
                $newfreerefersgoldbannerslots = '';
                if (isset($post[$freerefersgoldbannerslots])) {
                    $newfreerefersgoldbannerslots = implode(',', $post[$freerefersgoldbannerslots]);
                }
                $sql .= $freerefersgoldbannerslots . "=?, ";
                array_push($pdoarray, $newfreerefersgoldbannerslots);
            }

            ## PRO REFERRALS: ##
            $newprobannerslots = '';
            if (isset($post['probannerslots'])) {
                $newprobannerslots = implode(',', $post['probannerslots']);
            }
            $sql .= "probannerslots=?, ";
            array_push($pdoarray, $newprobannerslots);

            // pro bonus slots rewards for upgraded downline member count:
            $newprodownlineupgradestogetbonusslotsonfreereferralpages = $post['prodownlineupgradestogetbonusslotsonfreereferralpages'];
            $newprodownlineupgradestogetbonusslotsonproreferralpages = $post['prodownlineupgradestogetbonusslotsonproreferralpages'];
            $newprodownlineupgradestogetbonusslotsongoldreferralpages = $post['prodownlineupgradestogetbonusslotsongoldreferralpages'];
            $sql .= "prodownlineupgradestogetbonusslotsonfreereferralpages=?, prodownlineupgradestogetbonusslotsonproreferralpages=?, prodownlineupgradestogetbonusslotsongoldreferralpages=?, ";
            array_push($pdoarray, $newprodownlineupgradestogetbonusslotsonfreereferralpages, $newprodownlineupgradestogetbonusslotsonproreferralpages, $newprodownlineupgradestogetbonusslotsongoldreferralpages);   

            $newprodownlineupgradeswhichbonusslotsonfreereferralpages = '';
            if (isset($post['prodownlineupgradeswhichbonusslotsonfreereferralpages'])) {
                $newprodownlineupgradeswhichbonusslotsonfreereferralpages = implode(',', $post['prodownlineupgradeswhichbonusslotsonfreereferralpages']);
            }
            $sql .= "prodownlineupgradeswhichbonusslotsonfreereferralpages=?, ";
            array_push($pdoarray, $newprodownlineupgradeswhichbonusslotsonfreereferralpages);
            $newprodownlineupgradeswhichbonusslotsonproreferralpages = '';
            if (isset($post['prodownlineupgradeswhichbonusslotsonproreferralpages'])) {
                $newprodownlineupgradeswhichbonusslotsonproreferralpages = implode(',', $post['prodownlineupgradeswhichbonusslotsonproreferralpages']);
            }
            $sql .= "prodownlineupgradeswhichbonusslotsonproreferralpages=?, ";
            array_push($pdoarray, $newprodownlineupgradeswhichbonusslotsonproreferralpages);
            $newprodownlineupgradeswhichbonusslotsongoldreferralpages = '';
            if (isset($post['prodownlineupgradeswhichbonusslotsongoldreferralpages'])) {
                $newprodownlineupgradeswhichbonusslotsongoldreferralpages = implode(',', $post['prodownlineupgradeswhichbonusslotsongoldreferralpages']);
            }
            $sql .= "prodownlineupgradeswhichbonusslotsongoldreferralpages=?, ";
            array_push($pdoarray, $newprodownlineupgradeswhichbonusslotsongoldreferralpages);

            // pro refers free referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $prorefersfreebannerslots = 'prorefersfreebannerslots' . $i;
                // $newprorefersfreebannerslots = 'newprorefersfreebannerslots' . $i;
                $newprorefersfreebannerslots = '';
                if (isset($post[$prorefersfreebannerslots])) {
                    $newprorefersfreebannerslots = implode(',', $post[$prorefersfreebannerslots]);
                }
                $sql .= $prorefersfreebannerslots . "=?, ";
                array_push($pdoarray, $newprorefersfreebannerslots);
            }
            // pro refers pro referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $prorefersprobannerslots = 'prorefersprobannerslots' . $i;
                // $newprorefersprobannerslots = 'newprorefersprobannerslots' . $i;
                $newprorefersprobannerslots = '';
                if (isset($post[$prorefersprobannerslots])) {
                    $newprorefersprobannerslots = implode(',', $post[$prorefersprobannerslots]);
                }
                $sql .= $prorefersprobannerslots . "=?, ";
                array_push($pdoarray, $newprorefersprobannerslots);
            }
            // pro refers gold referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $prorefersgoldbannerslots = 'prorefersgoldbannerslots' . $i;
                // $newprorefersgoldbannerslots = 'newprorefersgoldbannerslots' . $i;
                $newprorefersgoldbannerslots = '';
                if (isset($post[$prorefersgoldbannerslots])) {
                    $newprorefersgoldbannerslots = implode(',', $post[$prorefersgoldbannerslots]);
                }
                $sql .= $prorefersgoldbannerslots . "=?, ";
                array_push($pdoarray, $newprorefersgoldbannerslots);
            }

            ## GOLD REFERRALS: ##
            $newgoldbannerslots = '';
            if (isset($post['goldbannerslots'])) {
                $newgoldbannerslots = implode(',', $post['goldbannerslots']);
            }
            $sql .= "goldbannerslots=?, ";
            array_push($pdoarray, $newgoldbannerslots);

            // gold bonus slots rewards for upgraded downline member count:
            $newgolddownlineupgradestogetbonusslotsonfreereferralpages = $post['golddownlineupgradestogetbonusslotsonfreereferralpages'];
            $newgolddownlineupgradestogetbonusslotsonproreferralpages = $post['golddownlineupgradestogetbonusslotsonproreferralpages'];
            $newgolddownlineupgradestogetbonusslotsongoldreferralpages = $post['golddownlineupgradestogetbonusslotsongoldreferralpages'];
            $sql .= "golddownlineupgradestogetbonusslotsonfreereferralpages=?, golddownlineupgradestogetbonusslotsonproreferralpages=?, golddownlineupgradestogetbonusslotsongoldreferralpages=?, ";
            array_push($pdoarray, $newgolddownlineupgradestogetbonusslotsonfreereferralpages, $newgolddownlineupgradestogetbonusslotsonproreferralpages, $newgolddownlineupgradestogetbonusslotsongoldreferralpages);  

            $newgolddownlineupgradeswhichbonusslotsonfreereferralpages = '';
            if (isset($post['golddownlineupgradeswhichbonusslotsonfreereferralpages'])) {
                $newgolddownlineupgradeswhichbonusslotsonfreereferralpages = implode(',', $post['golddownlineupgradeswhichbonusslotsonfreereferralpages']);
            }
            $sql .= "golddownlineupgradeswhichbonusslotsonfreereferralpages=?, ";
            array_push($pdoarray, $newgolddownlineupgradeswhichbonusslotsonfreereferralpages);
            $newgolddownlineupgradeswhichbonusslotsonproreferralpages = '';
            if (isset($post['golddownlineupgradeswhichbonusslotsonproreferralpages'])) {
                $newgolddownlineupgradeswhichbonusslotsonproreferralpages = implode(',', $post['golddownlineupgradeswhichbonusslotsonproreferralpages']);
            }
            $sql .= "golddownlineupgradeswhichbonusslotsonproreferralpages=?, ";
            array_push($pdoarray, $newgolddownlineupgradeswhichbonusslotsonproreferralpages);
            $newgolddownlineupgradeswhichbonusslotsongoldreferralpages = '';
            if (isset($post['golddownlineupgradeswhichbonusslotsongoldreferralpages'])) {
                $newgolddownlineupgradeswhichbonusslotsongoldreferralpages = implode(',', $post['golddownlineupgradeswhichbonusslotsongoldreferralpages']);
            }
            $sql .= "golddownlineupgradeswhichbonusslotsongoldreferralpages=?, ";
            array_push($pdoarray, $newgolddownlineupgradeswhichbonusslotsongoldreferralpages);

            // gold refers free referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $goldrefersfreebannerslots = 'goldrefersfreebannerslots' . $i;
                // $newgoldrefersfreebannerslots = 'newgoldrefersfreebannerslots' . $i;
                $newgoldrefersfreebannerslots = '';
                if (isset($post[$goldrefersfreebannerslots])) {
                    $newgoldrefersfreebannerslots = implode(',', $post[$goldrefersfreebannerslots]);
                }
                $sql .= $goldrefersfreebannerslots . "=?, ";
                array_push($pdoarray, $newgoldrefersfreebannerslots);
            }
            // gold refers pro referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $goldrefersprobannerslots = 'goldrefersprobannerslots' . $i;
                // $newgoldrefersprobannerslots = 'newgoldrefersprobannerslots' . $i;
                $newgoldrefersprobannerslots = '';
                if (isset($post[$goldrefersprobannerslots])) {
                    $newgoldrefersprobannerslots = implode(',', $post[$goldrefersprobannerslots]);
                }
                $sql .= $goldrefersprobannerslots . "=?, ";
                array_push($pdoarray, $newgoldrefersprobannerslots);
            }
            // gold refers gold referral chain:
            for ($i = 1; $i <= 6; $i++) {
                $goldrefersgoldbannerslots = 'goldrefersgoldbannerslots' . $i;
                // $newgoldrefersgoldbannerslots = 'newgoldrefersgoldbannerslots' . $i;
                $newgoldrefersgoldbannerslots = '';
                if (isset($post[$goldrefersgoldbannerslots])) {
                    $newgoldrefersgoldbannerslots = implode(',', $post[$goldrefersgoldbannerslots]);
                }
                $sql .= $goldrefersgoldbannerslots . "=?, ";
                array_push($pdoarray, $newgoldrefersgoldbannerslots);
            }
            
            $sql = mb_substr($sql, 0, -2); // Remove last comma and space.
            $q = $pdo->prepare($sql);
            $q->execute($pdoarray);
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