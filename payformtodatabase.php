<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
Add user fields to database (sent vis JS fetch) before redirecting them to payment.
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/

require_once "config/Database.php";
require_once "classes/FormValidation.php";

// php://input here is the formfields in JSON format.
$formfields = file_get_contents('php://input');

if (!empty($formfields)) {
    $response = json_encode(validateFormFields($formfields));
    echo $response;
}

function validateFormFields(string $formfields)
{
    $formfieldsarray = json_decode($formfields, true);
    $usernamefieldforads = $formfieldsarray['usernamefieldforads'];
    if ($usernamefieldforads === "") {
        // Validate form fields:
        $formvalidation = new FormValidation($formfieldsarray);
        $errors = $formvalidation->validateAll($formfieldsarray);
        if ($errors) {
            $response = array(
                "errors" => $errors,
                "pendingId" => ''
            );
            return $response;
        }
    }
    $pendingId = addToDatabase($formfields);
    $response = array(
        "errors" => '',
        "pendingId" => $pendingId
    );
    return $response;
}

function addToDatabase(string $formfields)
{

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "insert into pendingpurchases (formfields, dateadded) values (?, NOW())";
    $q = $pdo->prepare($sql);
    $q->execute([$formfields]);
    $last_insert_id = $pdo->lastInsertId();
    Database::disconnect();
    return $last_insert_id;
}
