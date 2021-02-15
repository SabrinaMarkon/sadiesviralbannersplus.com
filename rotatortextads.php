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

$adtable = 'textads';

$rotator = new Rotator($adtable, $settings);
$allrotators = $rotator->getAds();

if ($allrotators) {

    foreach ($allrotators as $ad) {

        $rid = $ad['id'];
        $rtitle = $ad['title'];
        $rurl = $ad['url'];
        $rshorturl = $ad['shorturl']; // TODO: use short url if available.
        $rdescription = $ad['description'];
        $rimageurl = $ad['imageurl'];

        $rotator->giveHit($rid);
        # get clicks when people click too.
        ?>
        <article class="card">
            
            <div class="text-center"><img class="card-image" alt="<?php echo $rtitle; ?>" src="<?php echo $rimageurl; ?>" /></div>
            <p><div><a id="textad" href="/click/<?php echo $adtable ?>/<?php echo $rid ?>" target="_blank"><?php echo $rtitle; ?></a></div><div><?php echo $rdescription; ?></div></p>

        </article>
        <?php
    }
}

