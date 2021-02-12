<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$adtable = $_GET['adtable'] ?? '';
$id = $_GET['id'] ?? '';

if (!empty($id) && ($adtable === 'textads' || $adtable === 'bannerspaid')) {
    $rotator = new Rotator($adtable);
    $click = $rotator->giveClick($id);
    if ($click) {
        header('Location: ' . $click);
        exit;
    }
}
echo "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The URL for this ad was invalid.</strong></div>";
exit;

