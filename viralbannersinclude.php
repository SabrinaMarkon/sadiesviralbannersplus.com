<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

// Get this page's referring member $_SESSION['referid']'s banners:
$banner = new ViralBanner('viralbanners');
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

    // Get user's sponsor's banners:
    $sponsorbanners = $banner->getAllApprovedUsersAds($sponsorusername);
} else {
    // For some reason no record was found for the user to get their sponsor or accounttype?
    $useraccounttype = "Free";
    $referidbannerslotsvar = 'freebannerslots';
    $sponsorrefersbannerslotsvar = '';
}

if ($referidbannerslotsvar) {
    $referidbannerslots = $banner->getVarArray($referidbannerslotsvar, $settings);
} else {
    $referidbannerslots = [];
}
if ($sponsorrefersbannerslotsvar) {
    $sponsorrefersbannerslots = $banner->getVarArray($sponsorrefersbannerslotsvar, $settings);
} else {
    $sponsorrefersbannerslots = [];
}

$freebannerslotsarray = $banner->getVarArray('freebannerslots', $settings);
$probannerslotsarray = $banner->getVarArray('probannerslots', $settings);
$goldbannerslotsarray = $banner->getVarArray('goldbannerslots', $settings);

?>
<div class="viralbannerscontainer">

    <div class="viralbanners">

        <!-- The Eight 728px x 90px BANNERS -->

        <?php
        for ($i = 1; $i <= 8; $i++) {

            // $referidbannerslots are the position slots that the user referid is allowed to show for their membership level:
            if (in_array($i, $referidbannerslots)) {
                // See if the user, referid, has a banner for this position. Positions over 8 are for the smaller banners below.
                $showbanner = $banner->getViralBanner($_SESSION['referid'], $i);
                //echo "TESTING: showbanner is user's own slot $i";
            } 
            // $sponsorrefersbannerslots are the position slots that the user referid's sponsor is allowed to show on their referral's (referid's) page.
            elseif (in_array($i, $sponsorrefersbannerslots) && !empty($sponsorusername)) {
            
                // See if the user's sponsor (referid's referid), has a banner saved for this position.
                $showbanner = $banner->getViralBanner($sponsorusername, $i);
                //echo "TESTING: showbanner is user's sponsor slot $i";
            }
            else {
                $showbanner = '';
                //echo "TESTING: showbanner has nothing for user or user's sponsor slot $i";
            }
            
            // SHOW:
            if (!empty($showbanner)) {

                // SHOW:
                //echo "TESTING: showbanner EXISTS (and might be empty) so display it slot $i";
                echo $banner->showBanner($showbanner, 728, 90, $i, 'viralbannerpage');
            } else {

                // There is no banner for either the referid OR their sponsor. Does the admin have a default banner for this slot?
                $adminshowbanner = $banner->getViralBanner('admin', $i);

                if (!empty($adminshowbanner)) {

                    // SHOW:
                    //echo "TESTING: admin slot because user or sponsor doesn't have a banner for this slot $i";
                    echo $banner->showBanner($adminshowbanner, 728, 90, $i, 'viralbannerpage');
                } else {

                    // SHOW PAID BANNER ROTATOR (NOTHING ELSE AVAILABLE):
                    //echo "TESTING: paid banner rotator because nothing else for this slot $i";
                    echo '<div class="placeholder-img viralbanner-withclickbox">';
                    include 'rotatorbannerspaid.php';
                    echo '</div>';
                }
            }
        }
        ?>


        <!-- The SIX 468px x 60px BANNERS -->
        <!-- DEFAULTS: -->
        <!-- #9 - 468px x 60px - Rotator for all members of certain level(s) - default to gold members only. -->
        <!-- #10 - 468px x 60px - Rotator for all members of certain level(s) - default to pro members only. -->
        <!-- #11 - 468px x 60px - The referid has a sponsor themselves and this is one of that sponsor's banners, if they have one. -->
        <!-- #12 - 468px x 60px - Paid banner rotator if no membership levels get this slot. -->
        <!-- #13 - 468px x 60px - Paid banner rotator if no membership levels get this slot. -->
        <!-- #14 - 468px x 60px - Paid banner rotator if no membership levels get this slot. -->

        <?php
        for ($i = 9; $i <= 14; $i++) {

            $allowedaccounttypearray = [];
            if (in_array($i, $freebannerslotsarray)) {
                array_push($allowedaccounttypearray, "Free");
            }
            if (in_array($i, $probannerslotsarray)) {
                array_push($allowedaccounttypearray, "Pro");
            }
            if (in_array($i, $goldbannerslotsarray)) {
                array_push($allowedaccounttypearray, "Gold");
            }
            if (count($allowedaccounttypearray) > 0) {
                $allowedaccounttypeindex = mt_rand(0, count($allowedaccounttypearray) - 1); // Random membership level among those permitted by admin settings.
                $allowedaccounttype = $allowedaccounttypearray[$allowedaccounttypeindex];
                $showbanner = $banner->getRandomBannerOfCertainMembershipLevel($sponsor, $allowedaccounttype, $i);
            }
            if (!empty($showbanner)) {
    
                // SHOW:
                echo $banner->showBanner($showbanner, 468, 60, $i, 'viralbannerpage');
            } else {
    
                    // There is no available banners from members for this rotator. Does the admin have a default banner for this slot?
                    $adminshowbanner = $banner->getViralBanner('admin', $i);
    
                    if (!empty($adminshowbanner)) {
    
                        // SHOW:
                        echo $banner->showBanner($adminshowbanner, 468, 60, $i, 'viralbannerpage');
                    } else {
    
                        // SHOW PAID BANNER ROTATOR (NOTHING ELSE AVAILABLE):
                        echo '<div class="placeholder-img viralbanner-withclickbox">';
                        include 'rotatorbannerspaid.php';
                        echo '</div>';
                    }
            }
        }
        ?>

    </div>

</div>

<script src="js/viralbannertimer.js"></script>
<script>
    whichOnesWereClickedAlready();
</script>
