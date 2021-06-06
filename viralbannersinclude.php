<?php
/** 
 * The visitor to this page should see the referid's banners in the appropriate slots,
 *  as well as the referid's sponsors up six level in the correct slots. 
 * */

# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$highestlevel = 6; // How many levels of referrals/sponsors.

$sponsor = new Sponsor();
$banner = new ViralBanner('viralbanners');

// Get the page referid if there is one.
$usernamespage = isset($_SESSION['referid']) ? $_SESSION['referid'] : 'admin';

// We don't need the below variables if the page owner is admin:
if ($usernamespage !== 'admin') {
    $usernamesaccounttypeandreferid = $sponsor->getReferidAndAccounttypes($usernamespage);
    $usernamesaccounttype = $usernamesaccounttypeandreferid['accounttype'];
    $usernamesreferid = $usernamesaccounttypeandreferid['referid'];
    // Get the bannerslots that the referid can occupy on their own page. The rest of the slots will be from their upline, admin, or paid banner rotators:
    $usernamesbannerslots = $usernamesaccounttype . 'bannerslots';
    $usernamesbannerslotsarray = $banner->getVarArray($usernamesbannerslots, $settings); // From csv list in database.
}

// What goes in each Viral Banner slot?
?>

<div class="viralbannerscontainer">
<div class="viralbanners">

<!-- TODO: ADMIN NEEDS TO INDICATE IN ADMIN VB SETTINGS WHiCH SLOTS ARE PAID BANNER ROTATORS OTHERWISE ADMIN BANNERS SHOW INSTEAD BY DEFAULT!!! -->

<?php
for ($slot = 1; $slot <= 16; $slot++) {

    if ($slot <= 5 || $slot === 16) { // Note: slot 16 will still be 468 x 60 if it is a paid banner rotator!
        $width = 728;
        $height = 90;
    } else {
        $width = 468;
        $height = 60;
    }
    
    $showbanner = [];

    // 1) no need to compute up 6 levels since the page owner is the admin. Just get the default admin Viral Banner to show in this slot, 
    // or a paid banner rotator if no admin banner.
    if ($usernamespage === 'admin') {
        $showbanner = $banner->getViralBanner('admin', $slot);
    }

    // The page owner is not the admin, so figure out what goes in this Viral Banner slot:
    
    // 2) Check if this slot is one that the page owner gets to have their own banner in:
    elseif (in_array($slot, $usernamesbannerslotsarray)) {
        // See if the page owner, $usernamepage, has a banner for this slot ID:
        $showbanner = $banner->getViralBanner($usernamespage, $slot);
        //echo "TESTING: showbanner is user's own slot $slot";
    }

    // 3) Check through every sponsor level above the page owner to see if they get their Viral Banner in this slot. 
    // The closest upline sponsor's banner has priority over the second level upline sponsor, who has priority over the third level sponsor, etc. in the event of a conflict.
    else {
        // Get the array of subarrays of each level's [level of referid, referid, referid's accounttype] to know which slot variables are needed:
        $sponsorarrays = getUsernamesReferidsUpToNthLevels($usernamesreferid, $highestlevel);

        // Get each level's referid and their accountype.
        foreach ($sponsorarrays as $sponsorarray) {

            // $sponsorarray is [level of referid, referid, referid's accounttype] **OR** [level of referid, 'admin', 'free'] 
            $level = $sponsorarray[0]; // sponsor upline level: ie. 1, 2, 3, 4, 5, 6...
            $referidofthislevel = $sponsorarray[1];
            $referidofthislevelaccounttype = $sponsorarray[2];

            if ($referidofthislevel === 'admin') {
                // Show admin banner or paid banner rotator in this slot, $slot, because this level's referid is admin.
                $showbanner = $banner->getViralBanner('admin', $slot);
                break;
            } 
            else {
                // Find the proper slot setting variable to check from this referid's account type and sponsor $level.
                $slotvarname = $referidofthislevelaccounttype . 'refers' . $usernamesaccounttype . 'bannerslots' . $slot;
                $slotvarnamefromcsvstring = $banner->getVarArray($slotvarname, $settings);

                if (in_array($slot, $slotvarnamefromcsvstring)) {
                    // Get any Viral Banners referidofthislevel has for this slot and show them.
                    $showbanner = $banner->getViralBanner($referidofthislevel, $slot);
                    break;
                } else {
                    // The slot array setting doesn't include this particular slot for this referidofthislevel, so show admin default or paid banner rotator.
                    $showbanner = $banner->getViralBanner('admin', $slot);
                    break;
                }
            } // end else
        } // end foreach ($sponsorarrays as $sponsorarray)
    } // end else

    if (!empty($showbanner['id'])) {
        // SHOW THE VIRAL BANNER:
        //echo "TESTING: showbanner EXISTS (and might be empty) so display it slot $i";
        $showbanner['bannerslot'] = $slot;
        $showbanner['width'] = $width;
        $showbanner['height'] = $height;
        $showbanner ['source'] = 'viralbannerpage';

        echo $banner->showBanner($showbanner);
    }
    else {
        // SHOW PAID BANNER ROTATOR (NOTHING ELSE AVAILABLE):
        //echo "TESTING: paid banner rotator because nothing else for this slot $slot";
        echo '<div class="viralbanner-withclickbox mt-3">';
        echo '<div id="viralbanner' . $slot . '" class="viralbanner-placeholder" style="width: ' . $width . ';">
        Clicked!</div>';
        include 'rotatorbannerspaid.php';
        echo '</div>';
    }

} // end for ($slot = 1; $slot <= 16; $slot++)

?>
</div>
</div>

<script src="js/viralbannertimer.js"></script>
<script>
    whichOnesWereClickedAlready();
</script>