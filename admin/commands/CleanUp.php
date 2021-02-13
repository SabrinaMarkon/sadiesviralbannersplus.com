<?php
/**
 * CleanUp deletes old records from the database.
 * PHP 5.4+
 * @author Sabrina Markon
 * @copyright 2021 Sabrina Markon, PHPSiteScripts.com
 * @license LICENSE.md
 *
 */
require_once('../../config/Database.php');

class CleanUp
{
    private $pdo;

    private function __construct() {}

    public static function deleteExpiredPendingPurchases()
    {
        // get all mails that are marked as pending mailout.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "delete from pendingpurchases where dateadded < DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        $q = $pdo->query($sql);
        $q->execute();
        Database::disconnect();
    }
}

$cleanupPendingPurchases = CleanUp::deleteExpiredPendingPurchases();
