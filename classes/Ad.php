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

class Ad
{

    private $pdo;

    public function __construct(string $adtable)
    {
        $this->adtable = $adtable; // Name of database table for this kind of ad (ie. banners, textads, etc.)
    }

    /* Get all the ads for all members. */
    public function getAllAds(): array
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " order by approved asc, id desc";
        $q = $pdo->prepare($sql);
        // $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ads = $q->fetchAll();

        Database::disconnect();

        return $ads;
    }

    /* Get all the ads for one member. */
    public function getAllUsersAds(string $username): ?array
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " where username=? and added=1 order by id desc";
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

    /* Call this when the user or admin submits their ad. */
    public function createAd(int $id, int $adminautoapprove, string $source, array $post): ?string
    {

        $username = $post['username'];
        $name = $post['name'];
        $title = $post['title'];
        $alt = $post['alt'];
        $url = $post['url'];
        $description = $post['description'];
        $imageurl = $post['imageurl'];

        # TODO: generate shorturl - FIREBASE LINKS ****
        $shorturl = '';

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        # is it a user or the admin posting the ad?
        if ($source === 'admin') {

            $sql = "insert into " . $this->adtable . " (username,name,title,url,shorturl,description,imageurl,added,approved,adddate) values ('admin',?,?,?,?,?,?,1,1,NOW())";
            $q = $pdo->prepare($sql);
            $q->execute([$name, $title, $url, $shorturl, $description, $imageurl]);
            Database::disconnect();

            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Ad " . $name . " was Created!</strong></div>";
        } elseif ($source === 'ipn') {

            $sql = "insert into " . $this->adtable . " (username) values (?)";
            $q = $pdo->prepare($sql);
            $q->execute([$username]);
            Database::disconnect();
            return null;
        } else {

            $sql = "update " . $this->adtable . " set name=?,title=?,url=?,description=?,imageurl=?,shorturl=?,added=1,approved=?,hits=0,clicks=0,adddate=NOW() where id=?";
            $q = $pdo->prepare($sql);
            $q->execute([$name, $title, $url, $description, $imageurl, $shorturl, $adminautoapprove, $id]);
            Database::disconnect();
            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Ad " . $name . " was Created!</strong></div>";
        }
    }

    /* When a user has paid for an ad and we receive the IPN notification, we create a blank ad for that user. */
    public function createBlankAd(string $username): int
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into " . $this->adtable . " (username,adddate) values (?,NOW())";
        $q = $pdo->prepare($sql);
        $q->execute([$username]);

        # get the adid of the newly inserted blank ad.
        $adid = $pdo->lastInsertId();

        Database::disconnect();

        return $adid;
    }

    /* Call this when the user edits their existing ad. */
    public function saveAd(int $id, int $adminautoapprove, int $isadmin, array $post): string
    {

        $name = $post['name'];
        $title = $post['title'];
        $url = $post['url'];
        $description = $post['description'];
        $imageurl = $post['imageurl'];

        # generate shorturl - FIREBASE LINKS ****
        $shorturl = '';

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($isadmin) {

            # admin has the option to choose to approve right away or not.
            $autoapprove = $post['approved'];
        } else {

            $autoapprove = $adminautoapprove;
        }
        $sql = "update " . $this->adtable . " set name=?,title=?,url=?,description=?,imageurl=?,shorturl=?,added=1,approved=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$name, $title, $url, $description, $imageurl, $shorturl, $autoapprove, $id]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Ad " . $name . " was Saved!</strong></div>";
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

    /* Save ad settings */
    public function saveAdSettings(array $post): string
    {
        if ($this->adtable === "textads") {
            $adprice = $post['textadprice'];
            $adhits = $post['textadhits'];
            $sql = "update adminsettings set textadprice=?, textadhits=?";
        }
        if ($this->adtable === "bannerspaid") {
            $adprice = $post['bannerprice'];
            $adhits = $post['bannerhits'];
            $sql = "update adminsettings set bannerprice=?, bannerhits=?";
        }
        if ($this->adtable === "networksolos") {
            $adprice = $post['networksoloprice'];
            $sql = "update adminsettings set networksoloprice=?";
        }

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $q = $pdo->prepare($sql);
        $q->execute([$adprice, $adhits]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Ad Settings Saved!</strong></div>";
    }
}
