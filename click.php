<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$adtable = $_GET['adtable'] ?? '';
$id = $_GET['id'] ?? '';
$bannerslot = $_GET['bannerslot'] ?? '';

if (!empty($id) && ($adtable === 'textads' || $adtable === 'bannerspaid' || $adtable === 'viralbanners' || $adtable === 'networksolos')) {

    $rotator = new Rotator($adtable, $settings);
    $clickurl = $rotator->giveClick($id);
    if ($clickurl) {
        # If it was a member who clicked, add a click to their counters towards a free ad and check if they get a free ad.
        if (isset($_SESSION['username'])) {
            $rotator->countMemberClick($_SESSION['username'], $id);
        }

        if (($adtable === 'viralbanners' || $adtable === 'bannerspaid') && $bannerslot > 0) {

            // If it was a viral banner click by a site visitor.
            $viralbanner = new ViralBanner($adtable);
            echo $viralbanner->showClickIFrame($bannerslot, $clickurl, $settings);
        }
        else {
            // It was a viral banner click in the admin area OR one of the other ad types.
            @header('Location: ' . $clickurl);
        }
    } else {
        echo "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The URL for this ad was invalid.</strong></div>";
    }
} else {
    echo "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The URL for this ad was invalid.</strong></div>";
}
