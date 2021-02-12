<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$adtable = 'bannerspaid';

$rotator = new Rotator($adtable);
$allrotators = $rotator->getAds();

if ($allrotators) {

    foreach ($allrotators as $ad) {

        $rid = $ad['id'];
        $ralt = $ad['alt'];
        $rurl = $ad['url'];
        $rshorturl = $ad['shorturl']; // TODO: use short url if available.
        $rimageurl = $ad['imageurl'];

        $rotator->giveHit($rid);
        # get clicks when people click too.
?>
        <div><a id="bannerad" href="/click/<?php echo $adtable ?>/<?php echo $rid ?>" target="_blank"><img alt="<?php echo $ralt; ?>" src="<?php echo $rimageurl; ?>" width="468" height="60" /></a></div>
<?php
    }
}
