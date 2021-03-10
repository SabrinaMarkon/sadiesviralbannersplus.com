<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require "control.php";
$showcontent = new PageContent();
echo $showcontent->showPage('Members Area Main Page');

$sponsor = new Sponsor();
$freereferrals = $sponsor->getReferralCount($username, 'Free');
$proreferrals = $sponsor->getReferralCount($username, 'Pro');
$goldreferrals = $sponsor->getReferralCount($username, 'Gold');

?>
<div class="container pb-4">
    <figure>
        <img src="images/sadie-transparent-shadow-peace.png" alt="Welcome to Sadie's!">
        <div style="display:flex; flex-direction:column;">
            <figcaption>
                <div class="sadietalkbig"><span class="heart">&#10084;</span><span class="heart2">&#10084;</span><span class="heart3">&#10084;</span><span class="hiya">Hiya Peeps!</span> <span class="im">I'm</span> <span class="sadie">Sadie! </span><span class="heart">&#10084;</span><span class="heart2">&#10084;</span><span class="heart3">&#10084;</span></div><br />
                <div class="sadietalknormal">
                    <div style="text-align: center; font-weight: bold;">Welcome to my awesome app where I will help your ads go viral!</div>
                </div>
            </figcaption>
            <div class="memberstats">
                <div class="statcard">
                    <img src="images/rocket-red-sm.png" alt="Your Free Referrals">
                    <div class="statnumbers">
                        <p>You have</p>
                        <h1><?php echo $freereferrals ?></h1>
                        <p>Free Referrals</p>
                    </div>
                </div>
                <div class="statcard">
                    <img src="images/rocket-yellow-sm.png" alt="Pro Referrals">
                    <div class="statnumbers">
                        <p>You have</p>
                        <h1 class="sadie"><?php echo $proreferrals ?></h1>
                        <p>Pro Referrals</p>
                    </div>
                </div>
                <div class="statcard">
                    <img src="images/rocket-blue-sm.png" alt="Gold Referrals">
                    <div class="statnumbers">
                        <p>You have</p>
                        <h1><?php echo $goldreferrals ?></h1>
                        <p>Gold Referrals</p>
                    </div>
                </div>
            </div>
        </div>
    </figure>
</div>