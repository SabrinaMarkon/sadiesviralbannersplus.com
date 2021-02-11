<?php

/**
Child class to handle network solo ad specifics.
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

class NetworkSolo extends Ad
{

    // Constructor is inherited from Ad parent class.
    public function __construct(string $adtable)
    {
        parent::__construct($adtable);
    }

    /* Call this when the user or admin submits their ad. */
    public function createAd(int $id, int $adminautoapprove, string $source, array $post): ?string
    {

        $username = $post['username'];
        $name = $post['name'];
        $subject = $post['subject'];
        $url = $post['url'];
        $message = $post['message'];

        # TODO: generate shorturl - FIREBASE LINKS ****
        $shorturl = '';

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        # is it a user or the admin posting the ad?
        if ($source === 'admin') {

            $sql = "insert into networksolos (username,name,subject,url,shorturl,message,added,approved,adddate) values ('admin',?,?,?,?,?,1,1,NOW())";
            $q = $pdo->prepare($sql);
            $q->execute([$name, $subject, $url, $shorturl, $message]);
            Database::disconnect();

            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Ad " . $name . " was Created!</strong></div>";
        } elseif ($source === 'ipn') {

            $sql = "insert into networksolos (username) values (?)";
            $q = $pdo->prepare($sql);
            $q->execute([$username]);
            Database::disconnect();
            return null;
        } else {

            $sql = "update networksolos set name=?,subject=?,url=?,message=?,shorturl=?,added=1,approved=?,clicks=0,adddate=NOW() where id=?";
            $q = $pdo->prepare($sql);
            $q->execute([$name, $subject, $url, $message, $shorturl, $adminautoapprove, $id]);
            Database::disconnect();
            return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Ad " . $name . " was Created!</strong></div>";
        }
    }

    /* Call this when the user edits their existing ad. */
    public function saveAd(int $id, int $adminautoapprove, int $isadmin, array $post): string
    {

        $name = $post['name'];
        $subject = $post['subject'];
        $url = $post['url'];
        $message = $post['message'];

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

        $sql = "update networksolos set name=?,subject=?,url=?,message=?,shorturl=?,added=1,approved=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$name, $subject, $url, $message, $shorturl, $autoapprove, $id]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Ad " . $name . " was Saved!</strong></div>";
    }
}
