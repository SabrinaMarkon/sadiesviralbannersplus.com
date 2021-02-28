<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$adtable = $_GET['adtable'] ?? '';
$id = $_GET['id'] ?? '';

if (!empty($id) && ($adtable === 'textads' || $adtable === 'bannerspaid' || $adtable === 'bannersformembers' || $adtable === 'networksolos')) {

    $rotator = new Rotator($adtable, $settings);
    $click = $rotator->giveClick($id);
    if ($click) {
        # If it was a member who clicked, add a click to their counters towards a free ad and check if they get a free ad.
        if (isset($_SESSION['username'])) {
            $rotator->countMemberClick($_SESSION['username']);
        }
        header('Location: ' . $click);
        exit;
    } else {
        echo "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The URL for this ad was invalid.</strong></div>";
    }
}
echo "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The URL for this ad was invalid.</strong></div>";
exit;
