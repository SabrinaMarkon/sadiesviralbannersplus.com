<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit;
}

require "control.php";
if (isset($showad)) {
	echo $showad;
}

$showcontent = new PageContent();
echo $showcontent->showPage('Members Area Viral Banners Page');

$adtable = 'viralbanners';
$banner = new ViralBanner('viralbanners');

$prefix = lcfirst($accounttype);
$bannerslotsvar = $prefix . 'bannerslots';
$bannerslots = $banner->getVarArray($bannerslotsvar, $settings);
$refersfreebannerslotsvar = $prefix . 'refersfreebannerslots';
$refersfreebannerslots = $banner->getVarArray($refersfreebannerslotsvar, $settings);
$refersprobannerslotsvar = $prefix . 'refersprobannerslots';
$refersprobannerslots = $banner->getVarArray($refersprobannerslotsvar, $settings);
$refersgoldbannerslotsvar = $prefix . 'refersgoldbannerslots';
$refersgoldbannerslots = $banner->getVarArray($refersgoldbannerslotsvar, $settings);
?>

<div class="container">
	<h1 class="ja-bottompadding">Add Your Viral Banners!</h1>

	<div class="ja-bottompadding mb-5">Your Viral URL: <a href="<?php echo $domain ?>/banners/<?php echo $username ?>" target="_blank"><?php echo $domain ?>/banners/<?php echo $username ?></a></div>

	<?php
	for ($i = 1; $i <= 12; $i++) {

		if ($i === 1) {
			?>
			<div class="ja-bottompadding mb-5">Your 728 x 90 Viral Banners</div>
			<?php
		}
		if ($i === 9) {
			?>
			<div class="ja-bottompadding mb-5">Your 468 x 60 Viral Banners</div>
			<?php
		}

		if ($i <= 8) {
			$width = 728;
			$height = 90;
		} else {
			$width = 468;
			$height = 60;
		}

		if (in_array($i, $bannerslots)) {

			// Is this banner one that appears on this user's OWN url?
            $usershowbanner = $banner->getViralBanner($username, $i);
            if (!empty($usershowbanner)) {

                $userbanner = $banner->showBanner($usershowbanner, $width, $height);
                echo $userbanner;

            } else {

                // Show blank banner for this position with fields for the user to add their own.
                echo $banner->showBannerPlaceholder($i, $width, $height);
            }

		} elseif (in_array($i, $refersfreebannerslots)) {

			// Does this banner appear on this user's FREE referral's urls?
            $usershowbanner = $banner->getViralBanner($username, $i);
            if (!empty($usershowbanner)) {

                $userbanner = $banner->showBanner($usershowbanner, $width, $height);
                echo $userbanner;

            } else {

                // Show blank banner for this position with fields for the user to add their own.
                echo $banner->showBannerPlaceholder($i, $width, $height);
            }

		} elseif (in_array($i, $refersprobannerslots)) {

			// Does this banner appear on this user's PRO referral's urls?
            $usershowbanner = $banner->getViralBanner($username, $i);
            if (!empty($usershowbanner)) {

                $userbanner = $banner->showBanner($usershowbanner, $width, $height);
                echo $userbanner;

            } else {

                // Show blank banner for this position with fields for the user to add their own.
                echo $banner->showBannerPlaceholder($i, $width, $height);
            }

		} elseif (in_array($i, $refersgoldbannerslots)) {
			
			// Does this banner appear on this user's PRO referral's urls?
            $usershowbanner = $banner->getViralBanner($username, $i);
            if (!empty($usershowbanner)) {

                $userbanner = $banner->showBanner($usershowbanner, $width, $height);
                echo $userbanner;

            } else {

                // Show blank banner for this position with fields for the user to add their own.
                echo $banner->showBannerPlaceholder($i, $width, $height):
            }

		}
		else {
			// this banner is unavailable to this user's membership level.
			// Is it available if the member upgrades to PRO?


			// Is it available if the member upgrades to GOLD?


			// This banner is not available to any membership levels so is a paid only banner rotator.
		}
	}

	?>

	<div class="ja-bottompadding mb-5">Your 468 x 60 Banners</div>

	<?php

	// Random rotation.


	// Random rotation.


	// Banner that shows on referrals' urls.

	// Random or paid rotation.
	?>


	<div class="ja-bottompadding ja-toppadding"></div>


</div>