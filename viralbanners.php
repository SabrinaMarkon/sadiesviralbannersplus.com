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
	
	<h1 class="ja-bottompadding mb-4">Add Your Viral Banners!</h1>

	<div class="ja-bottompadding">Your Viral URL: <a href="<?php echo $domain ?>/banners/<?php echo $username ?>" target="_blank"><?php echo $domain ?>/banners/<?php echo $username ?></a></div>

	<div class="viralbanners">

	<?php
	for ($i = 1; $i <= 12; $i++) {

		if ($i === 1) {
			?>
			<div class="ja-bottompadding my-3">Your 728 x 90 Viral Banners</div>
			<?php
		}
		if ($i === 9) {
			?>
			<div class="ja-bottompadding my-3">Your 468 x 60 Viral Banners</div>
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
                echo $banner->showBannerPlaceholder($width, $height, 'Click to add your Viral Banner for Slot ' . $i);
            }

		} elseif (in_array($i, $refersfreebannerslots)) {

			// Does this banner appear on this user's FREE referral's urls?
            $usershowbanner = $banner->getViralBanner($username, $i);
            if (!empty($usershowbanner)) {

                $userbanner = $banner->showBanner($usershowbanner, $width, $height);
                echo $userbanner;

            } else {

                // Show blank banner for this position with fields for the user to add their own.
                echo $banner->showBannerPlaceholder($width, $height, 'Click to add your Viral Banner for Slot ' . $i);
            }

		} elseif (in_array($i, $refersprobannerslots)) {

			// Does this banner appear on this user's PRO referral's urls?
            $usershowbanner = $banner->getViralBanner($username, $i);
            if (!empty($usershowbanner)) {

                $userbanner = $banner->showBanner($usershowbanner, $width, $height);
                echo $userbanner;

            } else {

                // Show blank banner for this position with fields for the user to add their own.
                echo $banner->showBannerPlaceholder($width, $height, 'Click to add your Viral Banner for Slot ' . $i);
            }

		} elseif (in_array($i, $refersgoldbannerslots)) {
			
			// Does this banner appear on this user's PRO referral's urls?
            $usershowbanner = $banner->getViralBanner($username, $i);
            if (!empty($usershowbanner)) {

                $userbanner = $banner->showBanner($usershowbanner, $width, $height);
                echo $userbanner;

            } else {

                // Show blank banner for this position with fields for the user to add their own.
                echo $banner->showBannerPlaceholder($width, $height, 'Click to add your Viral Banner for Slot ' . $i);
            }

		}
		else {
			// this banner is unavailable to this user's membership level.
			// Is this a paid only banner?
			$freebannerslotsarr = $banner->getVarArray('freebannerslots', $settings);
			$freerefersfreebannerslotsarr = $banner->getVarArray('freerefersfreebannerslots', $settings);
			$freerefersprobannerslotsarr = $banner->getVarArray('freerefersprobannerslots', $settings);
			$freerefersgoldbannerslotsarr = $banner->getVarArray('freerefersgoldbannerslots', $settings);
			$probannerslotsarr = $banner->getVarArray('probannerslots', $settings);
			$prorefersfreebannerslotsarr = $banner->getVarArray('prorefersfreebannerslots', $settings);
			$prorefersprobannerslotsarr = $banner->getVarArray('prorefersprobannerslots', $settings);
			$prorefersgoldbannerslotsarr = $banner->getVarArray('prorefersgoldbannerslots', $settings);
			$goldbannerslotsarr = $banner->getVarArray('goldbannerslots', $settings);
			$goldrefersfreebannerslotsarr = $banner->getVarArray('goldrefersfreebannerslots', $settings);
			$goldrefersprobannerslotsarr = $banner->getVarArray('goldrefersprobannerslots', $settings);
			$goldrefersgoldbannerslotsarr = $banner->getVarArray('goldrefersgoldbannerslots', $settings);
			if (
				!in_array($i, $freebannerslotsarr) &&
				!in_array($i, $freerefersfreebannerslotsarr) &&
				!in_array($i, $freerefersprobannerslotsarr) &&
				!in_array($i, $freerefersgoldbannerslotsarr) &&
				!in_array($i, $probannerslotsarr) &&
				!in_array($i, $prorefersfreebannerslotsarr) &&
				!in_array($i, $prorefersprobannerslotsarr) &&
				!in_array($i, $prorefersgoldbannerslotsarr) &&
				!in_array($i, $goldbannerslotsarr) &&
				!in_array($i, $goldrefersfreebannerslotsarr) &&
				!in_array($i, $goldrefersprobannerslotsarr) &&
				!in_array($i, $goldrefersgoldbannerslotsarr)
			) {
				// This can only be a paid banner rotator. Show link to buy one.
				echo $banner->showBannerPlaceholder($width, $height, 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i);			
			}
			else {
				if ($accounttype === "Free") {
					// Upgrade button for both pro and gold.
					echo $banner->showBannerPlaceholder($width, $height, 'Upgrade to Pro or Gold to add your banner to Slot ' . $i);
				}
				elseif ($accounttype === "Pro") {
					// Upgrade button for gold.
					echo $banner->showBannerPlaceholder($width, $height, 'Upgrade to Gold to add your banner to Slot ' . $i);
				}
				else {
					// This can only be a paid banner rotator. Show link to buy one.
					echo $banner->showBannerPlaceholder($width, $height, 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i);	
				}
			}
		}
	}

	?>
	</div>

	<div class="ja-bottompadding ja-toppadding"></div>


</div>