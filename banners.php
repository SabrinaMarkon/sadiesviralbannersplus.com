<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

function getVarArray(string $varname): array
{

    $varvalue = $$varname;
    $vararray = [];

    if (!empty($varvalue)) {
        $vararray = explode(',', $varvalue);
    }

    return $vararray;
}

// Get this page's referring member $_SESSION['referid']'s banners:
$banner = new MemberBanner('bannersformembers');
$referidbanners = $banner->getAllApprovedUsersAds($_SESSION['referid']);

// Get this page's referring member's own sponsor and sponsor's accounttype.
$sponsor = new Sponsor();
$referidssponsorarray = $sponsor->getUsersAccounttypeReferidAndReferidAccounttype($_SESSION['referid']);

if (count($referidssponsorarray) > 0) {

    // [useraccounttype, userreferid, referidaccounttype]

    $useraccounttype = $referidssponsorarray[0];
    $sponsorusername = $referidssponsorarray[1];
    if (count($referidssponsorarray) === 3) {
        $sponsoraccounttype = $referidssponsorarray[2]; // Which of the sponsor's (of this urls referring username) show depends on the sponsor's accounttype.
    } else {
        $sponsoraccounttype = "Free";
    }

    // Assign the correct variables from the admin settings:
    $referidprefix = lcfirst($useraccounttype);
    $sponsorprefix = lcfirst($sponsoraccounttype);
    $referidbannerslotsvar = $referidprefix . 'bannerslots';
    $sponsorrefersbannerslotsvar = $sponsorprefix . 'refers' . $referidprefix . 'bannerslots';

    // $freebannerslots
    // $freerefersfreebannerslots
    // $freerefersprobannerslots
    // $freerefersgoldbannerslots
    // $probannerslots
    // $prorefersfreebannerslots
    // $prorefersprobannerslots
    // $prorefersgoldbannerslots
    // $goldbannerslots
    // $goldrefersfreebannerslots
    // $goldrefersprobannerslots
    // $goldrefersgoldbannerslots

    // Get user's sponsor's banners:
    $sponsorbanners = $banner->getAllApprovedUsersAds($sponsorusername);
} else {
    // For some reason no record was found for the user to get their sponsor or accounttype?
    $useraccounttype = "Free";
    $referidbannerslotsvar = 'freebannerslots';
    $sponsorrefersbannerslotsvar = '';
}

$referidbannerslots = getVarArray($referidbannerslotsvar);
$sponsorrefersbannerslots = getVarArray($sponsorrefersbannerslotsvar);

?>
<div class="container">

    <!-- The Eight 728px x 90px BANNERS -->

    <?php
    for ($i = 1; $i <= 8; $i++) {
        // $referidbannerslots are the position slots that the user referid is allowed to show for their membership level:
        if (in_array($i, $referidbannerslots)) {
            // See if the user, referid, has a banner for this position. Positions over 8 are for the smaller banners below.
            $showbanner = $banner->getMemberBanner($_SESSION['referid'], $i);
        } else {
            // $sponsorrefersbannerslots are the position slots that the user referid's sponsor is allowed to show on their referral's (referid's) page.
            if (in_array($i, $sponsorrefersbannerslots) && !empty($sponsorusername)) {
                // See if the user's sponsor (referid's referid), has a banner saved for this position.
                $showbanner = $banner->getMemberBanner($sponsorusername, $i);
            }
        }

        // SHOW:



    }
    ?>


    <!-- The Four 468px x 60px BANNERS -->

    <!-- #9 - 468px x 60px - Rotator for all members of certain level(s) - default to gold members only. -->
    <?php
    $allowedaccounttypearray = [];
    if (in_array(9, $freebannerslots)) {
        array_push($allowedaccounttypearray, "Free");
    }
    if (in_array(9, $probannerslots)) {
        array_push($allowedaccounttypearray, "Pro");
    }
    if (in_array(9, $goldbannerslots)) {
        array_push($allowedaccounttypearray, "Gold");
    }
    $randomaccounttype = mt_rand(0, count($allowedaccounttypearray) - 1); // Random membership level among those permitted by admin settings.
    $showbanner = $banner->getRandomBannerOfCertainMembershipLevel($sponsor, $allowedaccounttype, 9);
    if (!empty($showbanner)) {

        // SHOW:




    }
    ?>


    <!-- #10 - 468px x 60px - Rotator for all members of certain level(s) - default to pro members only. -->
    <?php
    $allowedaccounttypearray = [];
    if (in_array(10, $freebannerslots)) {
        array_push($allowedaccounttypearray, "Free");
    }
    if (in_array(10, $probannerslots)) {
        array_push($allowedaccounttypearray, "Pro");
    }
    if (in_array(10, $goldbannerslots)) {
        array_push($allowedaccounttypearray, "Gold");
    }
    $randomaccounttype = mt_rand(0, count($allowedaccounttypearray) - 1); // Random membership level among those permitted by admin settings.
    $showbanner = $banner->getRandomBannerOfCertainMembershipLevel($sponsor, $allowedaccounttype, 9);
    if (!empty($showbanner)) {

        // SHOW:




    }
    ?>


    <!-- #11 - 468px x 60px - The referid has a sponsor themselves and this is one of that sponsor's banners, if they have one. -->
    <?php
    if (in_array(11, $sponsorrefersbannerslots) && !empty($sponsorusername)) {

        $showbanner = $banner->getMemberBanner($sponsorusername, 11);

        // SHOW:


    }
    ?>

    <!-- #12 - 468px x 60px - Paid banner rotator if no membership levels get this slot. -->

    <?php
    $allowedaccounttypearray = [];
    if (in_array(12, $freebannerslots)) {
        array_push($allowedaccounttypearray, "Free");
    }
    if (in_array(12, $probannerslots)) {
        array_push($allowedaccounttypearray, "Pro");
    }
    if (in_array(12, $goldbannerslots)) {
        array_push($allowedaccounttypearray, "Gold");
    }
    $randomaccounttype = mt_rand(0, count($allowedaccounttypearray) - 1); // Random membership level among those permitted by admin settings.
    $showbanner = $banner->getRandomBannerOfCertainMembershipLevel($sponsor, $allowedaccounttype, 9);
    if (!empty($showbanner)) {

        // SHOW:


    } else {

        // SHOW PAID BANNER ROTATOR:
    ?>
        <section class="bannerspaid-area">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="centered">
                            <section class="cards">

                                <?php include 'rotatorbannerspaid.php'; ?>

                            </section>
                        </div>
                    </div>
                </div>
        </section>
    <?php
    }
    ?>



</div>