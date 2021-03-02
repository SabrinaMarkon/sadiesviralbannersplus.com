<?php

/**
Child class to handle banner ad specifics.
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

class MemberBanner extends Banner
{
    
        // Constructor is inherited from Banner->Ad parent class.
        public function __construct(string $adtable) {
            parent::__construct($adtable);
        }

        /* Get all the member banners for one member. */
        public function getAllUsersApprovedMemberBanners(string $username): ?array
        {
    
            $pdo = DATABASE::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from " . $this->adtable . " where username=? and approved=? order by id desc";
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
}
