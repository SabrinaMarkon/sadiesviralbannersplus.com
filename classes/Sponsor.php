<?php

/**
Handles user interactions with the application.
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
    
    public function getReferidAndAccounttypes(string $username): array
	{

         // get sponsor's account level to compute correct commissions or figure out banner page slots.
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "select accounttype, referid from members where username=? limit 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($username));
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$data = $q->fetch();

        $affiliatearray = [];

        if (!empty($data)) {

            $accounttype = $data['accounttype']; // accounttype of the member.
			$referid = $data['referid']; // referid of the member.
            array_push($affiliatearray, $accounttype, $referid);

            // Get referrer's accounttype now:
			$sql = "select accounttype from members where username=?";
			$q = $pdo->prepare($sql);
			$q->execute(array($referid));
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$data = $q->fetch();
			if (!empty($data['accounttype']))
            {
				$referidaccounttype = $data['accounttype']; // accounttype of the member's referid.
				array_push($affiliatearray, $referidaccounttype);
			}
		}

		Database::disconnect();
		
        return $affiliatearray;
	}

    public function addNewReferralCommission(string $referid, string $accounttype): void
    {
        // get sponsor's account level to compute correct commissions.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select accounttype from members where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($referid));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetch();
        if (!empty($data['accounttype'])) {
            $referidaccounttype = $data['accounttype'];
            $prefix = lcfirst($referidaccounttype);
            $levelreferred = lcfirst($accounttype);
            $commissionvarname = $prefix . "refers" . $levelreferred . "earn";
            $sql = "update members set owed=owed+? where username=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($$commissionvarname, $referid));
        }
        
        Database::disconnect();
    }
}
