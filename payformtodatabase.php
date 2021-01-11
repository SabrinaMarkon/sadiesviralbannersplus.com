<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "config/Database.php";

if (!empty($_POST)) {
   $pendingId = addToDatabase();
   return $pendingId;
} else {
    return null;
}

function addToDatabase() {
    
    $formfields = serialize([$_POST]);
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql = "insert into pendingpurchases (formfields) values (?)";
    $q = $pdo->prepare($sql);
    $q->execute([$formfields]);
    $last_insert_id = $pdo->lastInsertId();
    Database::disconnect();
    return $last_insert_id;
}

?>