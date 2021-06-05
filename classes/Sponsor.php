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

            Database::disconnect();
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

        return $affiliatearray; // contains [user's own accounttype, user's referid, user's referid's accounttype] OR just empty []
    }

    // Get an array of a user's sponsors (referids) up N levels.
    public function getUsernamesReferidsUpToNthLevels(string $referid, int $highestlevel = 1): array {

        // array of all referids for levels 1 $referid thru the $highestlevel referid. Default each sponsor up to highest level as the admin.
        // 'free' is just default. Admin referids show admin default banners added from the Viral Banner admin area so accounttype of the admin doesn't matter:
        $alllevelreferids = [];
        for ($i = 1; $i <= $highestlevel; $i++) {
            $subarray = [$i, 'admin', 'free'];
            array_push($alllevelreferids, $subarray);
        }

        // temporary array to hold data for CURRENT referid (starting with parameter $referid at level 1) from getUsersAccounttypeReferidAndReferidAccounttype:
        $currentreferiddata = []; 

        for ($i = 1; $i <= $highestlevel; $i++) {

            $currentreferiddata = [];

            // We don't need to check accounttype or anything if referid is admin. It will already be the default in the $alllevelreferids array.
            if ($referid !== 'admin') {
                
                // contains [referid's own accounttype, referid's referid, referid's referid's accounttype] **OR** empty []:
                $currentreferiddata = $this->getUsersAccounttypeReferidAndReferidAccounttype($referid);

                if (count($currentreferiddata) === 3) {
                    $accounttype = lcfirst($currentreferiddata[0]); // first item is the referid's own accounttype
                    array_push($alllevelreferids, [$i, $referid, $accounttype]); // [level number, referid, referid's accounttype] as subarray. Add to main array.
                    $referid = $currentreferiddata[1]; // ** second item is the referid's referid, which is for the next loop. **

                } else {
                    // should be empty [] if we are here:
                    $referid = 'admin';
                    $currentreferiddata = [];
                    break; // Short-circuit the for loop because there is no reason to keep going up levels if this level referid is admin (since admin has no sponsor).
                }
                
                $currentreferiddata = [];
            }
            else {
                $referid = 'admin';
                $currentreferiddata = [];
                break; // Short-circuit the for loop because there is no reason to keep going up levels if this level referid is admin (since admin has no sponsor).
            }
        }

        return $alllevelreferids; // Array of arrays of [level $i, referid, referid's accounttype].
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
