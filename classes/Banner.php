<?php

/**
Child class to handle banner ad specifics.
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

class Banner extends Ad
{

    // Constructor is inherited from Ad parent class.
    public function __construct(string $adtable) {
        parent::__construct($adtable);
    }
    
    /* Call this when the user or admin submits their ad. */
    public function createAd(int $id, int $adminautoapprove, string $source, array $post): ?string
    {

        $username = $post['username'];
        $name = $post['name'];
        $alt = $post['alt'];
        $url = $post['url'];
        $imageurl = $post['imageurl'];

        # TODO: generate shorturl 
        $shorturl = '';

        if (empty($username)) {
            $username = 'admin';
        }

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        # is it a user or the admin posting the ad?
        if ($source === 'admin') {

            if ($this->adtable === 'bannersformembers') {

                $bannerpageslot = $post['bannerpageslot'];

                $sql = "insert into ". $this->adtable . " (username,name,alt,url,shorturl,imageurl,bannerpageslot,added,approved,adddate) values (?,?,?,?,?,?,?,1,1,NOW())";
                $q = $pdo->prepare($sql);
                $q->execute([$username, $name, $alt, $url, $shorturl, $imageurl, $bannerpageslot]);
            } else {
                $sql = "insert into ". $this->adtable . " (username,name,alt,url,shorturl,imageurl,added,approved,adddate) values (?,?,?,?,?,?,1,1,NOW())";
                $q = $pdo->prepare($sql);
                $q->execute([$username, $name, $alt, $url, $shorturl, $imageurl]);
            }
            Database::disconnect();

            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Ad " . $name . " was Created!</strong></div>";
        } elseif ($source === 'ipn') {

            $sql = "insert into ". $this->adtable . " (username) values (?)";
            $q = $pdo->prepare($sql);
            $q->execute([$username]);
            Database::disconnect();
            return null;
        } elseif ($source === 'viralbanner') {

            $bannerpageslot = $post['bannerpageslot'];
          
            $sql = "insert into ". $this->adtable . " (username,name,alt,url,shorturl,imageurl,bannerpageslot,added,approved,adddate) values (?,?,?,?,?,?,?,1,0,NOW())";
            $q = $pdo->prepare($sql);
            $q->execute([$username, $name, $alt, $url, $shorturl, $imageurl, $bannerpageslot]);
            Database::disconnect();

            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Ad " . $name . " was Created!</strong></div>";
        } else {

            $sql = "update ". $this->adtable . " set name=?,alt=?,url=?,imageurl=?,shorturl=?,added=1,approved=?,hits=0,clicks=0,adddate=NOW() where id=?";
            $q = $pdo->prepare($sql);
            $q->execute([$name, $alt, $url, $imageurl, $shorturl, $adminautoapprove, $id]);
            Database::disconnect();
            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Ad " . $name . " was Created!</strong></div>";
        }
    }

    /* Call this when the user edits their existing ad. */
    public function saveAd(int $id, int $adminautoapprove, int $isadmin, array $post): string
    {

        $username = $post['username'];
        $name = $post['name'];
        $alt = $post['alt'];
        $url = $post['url'];
        $imageurl = $post['imageurl'];

        # generate shorturl - FIREBASE LINKS ****
        $shorturl = '';

        if (empty($username)) {
            $username = 'admin';
        }
        
        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($isadmin) {

            # admin has the option to choose to approve right away or not.
            $autoapprove = $post['approved'];
        } else {

            $autoapprove = $adminautoapprove;
        }

        if ($this->adtable === 'bannersformembers') {

            $bannerpageslot = $post['bannerpageslot'];

            $sql = "update ". $this->adtable . " set username=?,name=?,alt=?,url=?,imageurl=?,shorturl=?,bannerpageslot=?,added=1,approved=? where id=?";
            $q = $pdo->prepare($sql);
            $q->execute([$username, $name, $alt, $url, $imageurl, $shorturl, $bannerpageslot, $autoapprove, $id]);
        } else {
            
            $sql = "update ". $this->adtable . " set username=?,name=?,alt=?,url=?,imageurl=?,shorturl=?,added=1,approved=? where id=?";
            $q = $pdo->prepare($sql);
            $q->execute([$username, $name, $alt, $url, $imageurl, $shorturl, $autoapprove, $id]);   
        }

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Ad " . $name . " was Saved!</strong></div>";
    }
}
