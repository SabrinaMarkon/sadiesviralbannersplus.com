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

$level = lcfirst($accounttype);
$adclickstogettextad = $level . "adclickstogettextad";
$adclickstogetbannerspaid = $level . "adclickstogetbannerspaid";
$adclickstogetnetworksolo = $level . "adclickstogetnetworksolo";

?>
<div class="container pb-4">
    <figure>
        <img src="images/sadie-transparent-shadow-peace.png" alt="Welcome to Sadie's!" class="px-5">
        <div style="display:flex; flex-direction:column;">
            <figcaption>
                <div class="sadietalkbig"><span class="heart">&#10084;</span><span class="heart2">&#10084;</span><span class="heart3">&#10084;</span><span class="hiya">Hiya Peeps!</span> <span class="im">I'm</span> <span class="sadie">Sadie! </span><span class="heart">&#10084;</span><span class="heart2">&#10084;</span><span class="heart3">&#10084;</span></div><br />
                <div class="sadietalknormal">
                    <div style="font-weight: bold; text-align: center;">Welcome to my <strong>AWESOME APP</strong> where I will help your ads go totally <strong>VIRAL!</strong></div>
                </div>
            </figcaption>
            <div class="affiliateurl" style="font-weight: bold; text-align: center; font-size: 1.4rem;">Get Your Banners on Your Referrals' Banner Pages and Get PAID! <br /><a href="<?php echo $domain . "/" . $username; ?>" target="_blank"><?php echo $domain . "/" . $username; ?></a><br /><br />
                Show off Your Best Programs on your Own Special Banner URL! <br /><a href="<?php echo $domain . "/banners/" . $username; ?>" target="_blank"><?php echo $domain . "/banners/" . $username; ?></a><br /><br />
            </div>
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
                <div class="statcard">
                    <div class="statnumbers">
                        <p>We Owe You</p>
                        <h1 class="coral">$<?php echo $owed ?></h1>
                        <p>in Commissions!</p>
                    </div>
                </div>
                <div class="statcard">
                    <div class="statnumbers">
                        <p>We've Paid You</p>
                        <h1 class="coral">$<?php echo $paid ?></h1>
                        <p>in Commissions!</p>
                    </div>
                </div>
                <div class="statcard">
                    <div class="statnumbers">
                        <p>To Date You've Earned</p>
                        <h1 class="coral">$<?php echo sprintf("%01.2f", $owed + $paid); ?></h1>
                        <p>in Commissions!</p>
                    </div>
                </div>

                <?php
                if ($$adclickstogettextad > 0) {
                ?>
                    <div class="statcard">
                        <div class="statnumbers">
                            <p>You have clicked</p>
                            <h1><?php echo $textadclicks; ?>/<?php echo $$adclickstogettextad; ?></h1>
                            <p>Text Ads</p>
                            <p>towards a FREE Text Ad!</p>
                        </div>
                    </div>
                <?php
                }
                if ($$adclickstogettextad > 0) {
                ?>
                    <div class="statcard">
                        <div class="statnumbers">
                            <p>You have clicked</p>
                            <h1><?php echo $banneradclicks; ?>/<?php echo $$adclickstogetbannerspaid; ?></h1>
                            <p>Banners</p>
                            <p>towards a FREE Banner!</p>
                        </div>
                    </div>
                <?php
                }
                if ($$adclickstogettextad > 0) {
                ?>
                    <div class="statcard">
                        <div class="statnumbers">
                            <p>You have clicked</p>
                            <h1><?php echo $networksoloclicks; ?>/<?php echo $$adclickstogetnetworksolo; ?></h1>
                            <p>Network Solo Links</p>
                            <p>towards a FREE Network Solo!</p>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
        <?php
        if ($accounttype === 'Free' || $accounttype === 'Pro') {
                
            $upgrade = new UpgradeButton(new User(new Email()), $settings);
            if ($accounttype === 'Free') {
                # Upgrade to Pro pay buttons.
                $probuttons = $upgrade->showUpgradeButton('Pro', $username, $referid);
                echo $probuttons;
            }
            # Upgrade to Gold pay buttons.
            $goldbuttons = $upgrade->showUpgradeButton('Gold', $username, $referid);
            echo $goldbuttons;
        }
        ?>
    </figure>
</div>