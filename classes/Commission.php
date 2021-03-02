<?php

/**
Apply commission earnings to a user.
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

class Commission extends Sponsor
{

    public function addNewReferralCommission(string $referid, string $accounttype): void
    {
        // get sponsor's account level to compute correct commissions.
        $data = $this->getReferidAndAccounttypes($referid);

        if (!empty($data['accounttype'])) {
            $referidaccounttype = $data['accounttype'];
            $prefix = lcfirst($referidaccounttype);
            $levelreferred = lcfirst($accounttype);
            $commissionvarname = $prefix . "refers" . $levelreferred . "earn";

            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "update members set owed=owed+? where username=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($$commissionvarname, $referid));
        }

        Database::disconnect();
    }
}
