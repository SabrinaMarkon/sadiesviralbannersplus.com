<?php

/**
Get sponsor information for a user.
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

class Sponsor
{

    // Get the referid and accounttype for a user.
    public function getReferidAndAccounttypes(string $username): array
    {
        // get a user's referid and accounttype.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select accounttype, referid from members where username=? limit 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetch();

        if (!empty($data)) {
            return $data;
        }

        Database::disconnect();

        return [];
    }


    // Get an array with the user's referid, the user's accounttype, and the user's referid's accounttype.
    public function getUsersAccounttypeReferidAndReferidAccounttype(string $username): array
    {

        // get user's referid and user's accounttype.
        $data = $this->getReferidAndAccounttypes($username);

        $affiliatearray = [];

        if (!empty($data)) {

            $accounttype = $data['accounttype']; // accounttype of the user.
            $referid = $data['referid']; // referid of the user.
            array_push($affiliatearray, $accounttype, $referid);

            // Now add the user's referid's own accounttype.
            $data = $this->getReferidAndAccounttypes($referid);

            if (!empty($data['accounttype'])) {
                $referidaccounttype = $data['accounttype']; // accounttype of the user's referid.
                array_push($affiliatearray, $referidaccounttype);
            }
        }

        Database::disconnect();

        return $affiliatearray;
    }

    public function getRandomUsername(string $accounttype = "Free"): string {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select username from members where accounttype=? order by rand() limit 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($accounttype));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetch();

        if (!empty($data['username'])) {
            return $data['username'];
        }

        Database::disconnect();

        return ''; 
    }

    public function getReferralCount(string $username, string $accounttype): int {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select count(id) as count from members where referid=? and accounttype=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username, $accounttype));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetch();

        if (!empty($data['count'])) {
            return $data['count'];
        }

        Database::disconnect();

        return 0;
    }
}