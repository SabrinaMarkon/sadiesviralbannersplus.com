<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
 * Make sure order of FAQ positinnumbers matches what the admin has dragged and dropped in the FAQ admin (sent vis JS fetch) from /admin/faq.
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/

require_once "../config/Database.php";

// php://input here is the order of the ids in the FAQ drag and drop form.
$positionnumberIdsArray = file_get_contents('php://input');

if (!empty($positionnumberIdsArray)) {

    $positionnumberIdsArray = json_decode($positionnumberIdsArray);

    $pdo = DATABASE::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Reorder position numbers:
    $positioncount = 1;
    foreach ($positionnumberIdsArray as $id) {
        $sql = "update faqs set positionnumber=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$positioncount, $id]);
        // echo $id . " ";
        $positioncount++;
    }

    Database::disconnect();

    echo "success!";
}


