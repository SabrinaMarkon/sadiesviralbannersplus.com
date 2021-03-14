<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
	$$key = $value;
}

$adtable = 'networksolos';

$rotator = new Rotator($adtable, $settings);
$allrotators = $rotator->getAds(1);

if ($allrotators) {

    foreach ($allrotators as $ad) {

        $rid = $ad['id'];
        $rsubject = $ad['subject'];
        $rurl = $ad['url'];
        $rshorturl = $ad['shorturl']; // TODO: use short url if available.
        $rmessage = $ad['message'];

        # get clicks to url when people click on subject or message.
?>

<div class="container">


</div>

<?php
    }
}
