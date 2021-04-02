<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$adtable = $_GET['adtable'] ?? '';
$id = $_GET['id'] ?? '';

if (!empty($id) && ($adtable === 'textads' || $adtable === 'bannerspaid' || $adtable === 'viralbanners' || $adtable === 'networksolos')) {

    $rotator = new Rotator($adtable, $settings);
    $click = $rotator->giveClick($id);
    if ($click) {
        # If it was a member who clicked, add a click to their counters towards a free ad and check if they get a free ad.
        if (isset($_SESSION['username'])) {
            $rotator->countMemberClick($_SESSION['username'], $id);
        }
        if ($adtable === 'viralbanners') {
            // Need to have a timer countdown and the URL!

            // 1) Show iframe + url.
            // 2) In iframe, show countdown.
            // 3) At end of countdown, show success and SAVE viral banner ID to cookie or database! OR CODE!!!

            // Need body, etc. for background color. 
            // TODO:  make sure sponsor banners show up!!!
            ?>
            <div style="display: flex; flex-direction: column; height: 100vh;">
                <header class="header" style="position: sticky; top: 0; height: 50px; background: pink;">
                    TIMER
                </header>
                <main>
                    <iframe src="<?php echo $click ?>" style="height: 100vh; width: 100%;"></iframe>.
                </main>
            </div>
            <?php
        } else {
            @header('Location: ' . $click);
        }
    } else {
        echo "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The URL for this ad was invalid.</strong></div>";
    }
} else {
    echo "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The URL for this ad was invalid.</strong></div>";
}
