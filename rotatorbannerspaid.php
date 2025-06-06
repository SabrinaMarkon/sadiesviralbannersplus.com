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

$adtable = 'bannerspaid';

$rotator = new Rotator($adtable, $settings);
$allrotators = $rotator->getAds(1);

if ($allrotators) {

    foreach ($allrotators as $ad) {

        $rid = $ad['id'];
        $ralt = $ad['alt'];
        $rurl = $ad['url'];
        $rshorturl = $ad['shorturl']; // TODO: use short url if available.
        $rimageurl = $ad['imageurl'];

        $rotator->giveHit($rid);
        # get clicks when people click too.

        if (!empty($slot) && $slot> 0) {
            // The banner is a paid banner rotation in the Viral Banner box.
        ?>
            <div><a class="placeholder-img" href="/click/<?php echo $adtable ?>/<?php echo $rid ?>/<?php echo $slot ?>"><img alt="<?php echo $ralt; ?>" src="<?php echo $rimageurl; ?>" width="468" height="60" /></a></div>
        <?php
        } else {
            // The banner is a paid banner rotation in the regular rotator.
        ?>
            <div class="mb-3"><a id="bannerad" href="/click/<?php echo $adtable ?>/<?php echo $rid ?>" target="_blank"><img alt="<?php echo $ralt; ?>" src="<?php echo $rimageurl; ?>" width="468" height="60" /></a></div>
        <?php
        }
    }
}
