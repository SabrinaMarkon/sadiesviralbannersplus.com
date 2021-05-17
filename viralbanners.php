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

$refersfreebannerslotsvar1 = $prefix . 'refersfreebannerslots1';
$refersfreebannerslots1 = $banner->getVarArray($refersfreebannerslotsvar1, $settings);
$refersprobannerslotsvar1 = $prefix . 'refersprobannerslots1';
$refersprobannerslots1 = $banner->getVarArray($refersprobannerslotsvar1, $settings);
$refersgoldbannerslotsvar1 = $prefix . 'refersgoldbannerslots1';
$refersgoldbannerslots1 = $banner->getVarArray($refersgoldbannerslotsvar1, $settings);

$refersfreebannerslotsvar2 = $prefix . 'refersfreebannerslots2';
$refersfreebannerslots2 = $banner->getVarArray($refersfreebannerslotsvar2, $settings);
$refersprobannerslotsvar2 = $prefix . 'refersprobannerslots2';
$refersprobannerslots2 = $banner->getVarArray($refersprobannerslotsvar2, $settings);
$refersgoldbannerslotsvar2 = $prefix . 'refersgoldbannerslots2';
$refersgoldbannerslots2 = $banner->getVarArray($refersgoldbannerslotsvar2, $settings);

$refersfreebannerslotsvar3 = $prefix . 'refersfreebannerslots3';
$refersfreebannerslots3 = $banner->getVarArray($refersfreebannerslotsvar3, $settings);
$refersprobannerslotsvar3 = $prefix . 'refersprobannerslots3';
$refersprobannerslots3 = $banner->getVarArray($refersprobannerslotsvar3, $settings);
$refersgoldbannerslotsvar3 = $prefix . 'refersgoldbannerslots3';
$refersgoldbannerslots3 = $banner->getVarArray($refersgoldbannerslotsvar3, $settings);

$refersfreebannerslotsvar4 = $prefix . 'refersfreebannerslots4';
$refersfreebannerslots4 = $banner->getVarArray($refersfreebannerslotsvar4, $settings);
$refersprobannerslotsvar4 = $prefix . 'refersprobannerslots4';
$refersprobannerslots4 = $banner->getVarArray($refersprobannerslotsvar4, $settings);
$refersgoldbannerslotsvar4 = $prefix . 'refersgoldbannerslots4';
$refersgoldbannerslots4 = $banner->getVarArray($refersgoldbannerslotsvar4, $settings);

$refersfreebannerslotsvar5 = $prefix . 'refersfreebannerslots5';
$refersfreebannerslots5 = $banner->getVarArray($refersfreebannerslotsvar5, $settings);
$refersprobannerslotsvar5 = $prefix . 'refersprobannerslots5';
$refersprobannerslots5 = $banner->getVarArray($refersprobannerslotsvar5, $settings);
$refersgoldbannerslotsvar5 = $prefix . 'refersgoldbannerslots5';
$refersgoldbannerslots5 = $banner->getVarArray($refersgoldbannerslotsvar5, $settings);

$refersfreebannerslotsvar6 = $prefix . 'refersfreebannerslots6';
$refersfreebannerslots6 = $banner->getVarArray($refersfreebannerslotsvar6, $settings);
$refersprobannerslotsvar6 = $prefix . 'refersprobannerslots6';
$refersprobannerslots6 = $banner->getVarArray($refersprobannerslotsvar6, $settings);
$refersgoldbannerslotsvar6 = $prefix . 'refersgoldbannerslots6';
$refersgoldbannerslots6 = $banner->getVarArray($refersgoldbannerslotsvar6, $settings);
?>

<div class="container">

	<h1 class="ja-bottompadding mb-4">Add Your Viral Banners!</h1>

	<div class="affiliateurl mb-4 pt-3" style="font-weight: bold; text-align: center; font-size: 1.4rem;">
		Show off Your Best Programs on your Own Personal VIRAL Banner App! <br /><a href="<?php echo $domain . "/banners/" . $username; ?>" target="_blank"><?php echo $domain . "/banners/" . $username; ?></a>
	</div>
	<div class="affiliateurl mb-4 pt-3" style="font-weight: bold; text-align: center; font-size: 1.4rem;">
		Click each Viral Banner slot you have to add your own banners, edit them, or see their click and impression stats!
	</div>

	<div class="viralbanners">

		<?php
		for ($i = 1; $i <= 14; $i++) {

			// Show either a modal to add or edit banner, upgrade buttons, or link to paid only banner rotator.
			$showinmodal = '';

			if ($i === 1) {
		?>
				<h2 class="ja-bottompadding my-3">Your 728 x 90 Viral Banners</h2>
			<?php
			}
			if ($i === 9) {
			?>
				<h2 class="ja-bottompadding my-3">Your 468 x 60 Viral Banners</h2>
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

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersfreebannerslots1)) {

				// Does this banner appear on this user's FIRST LEVEL FREE referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersprobannerslots1)) {

				// Does this banner appear on this user's FIRST LEVEL PRO referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersgoldbannerslots1)) {

				// Does this banner appear on this user's FIRST LEVEL GOLD referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			}  elseif (in_array($i, $refersfreebannerslots2)) {

				// Does this banner appear on this user's SECOND LEVEL FREE referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersprobannerslots2)) {

				// Does this banner appear on this user's SECOND LEVEL PRO referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersgoldbannerslots2)) {

				// Does this banner appear on this user's SECOND LEVEL GOLD referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			}  elseif (in_array($i, $refersfreebannerslots3)) {

				// Does this banner appear on this user's THIRD LEVEL FREE referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersprobannerslots3)) {

				// Does this banner appear on this user's THIRD LEVEL PRO referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersgoldbannerslots3)) {

				// Does this banner appear on this user's THIRD LEVEL GOLD referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			}  elseif (in_array($i, $refersfreebannerslots4)) {

				// Does this banner appear on this user's FOURTH LEVEL FREE referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersprobannerslots4)) {

				// Does this banner appear on this user's FOURTH LEVEL PRO referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersgoldbannerslots4)) {

				// Does this banner appear on this user's FOURTH LEVEL GOLD referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			}  elseif (in_array($i, $refersfreebannerslots5)) {

				// Does this banner appear on this user's FIFTH LEVEL FREE referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersprobannerslots5)) {

				// Does this banner appear on this user's FIFTH LEVEL PRO referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersgoldbannerslots5)) {

				// Does this banner appear on this user's FIFTH LEVEL GOLD referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			}  elseif (in_array($i, $refersfreebannerslots6)) {

				// Does this banner appear on this user's SIXTH LEVEL FREE referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersprobannerslots6)) {

				// Does this banner appear on this user's SIXTH LEVEL PRO referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} elseif (in_array($i, $refersgoldbannerslots6)) {

				// Does this banner appear on this user's SIXTH LEVEL GOLD referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i, 'memberarea');
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i, 'memberarea');
				}
			} else {
				// this banner is unavailable to this user's membership level.
				// Is this a paid only banner?
				$freebannerslotsarr = $banner->getVarArray('freebannerslots', $settings);
				$freerefersfreebannerslotsarr1 = $banner->getVarArray('freerefersfreebannerslots1', $settings);
				$freerefersprobannerslotsarr1 = $banner->getVarArray('freerefersprobannerslots1', $settings);
				$freerefersgoldbannerslotsarr1 = $banner->getVarArray('freerefersgoldbannerslots1', $settings);
				$freerefersfreebannerslotsarr2 = $banner->getVarArray('freerefersfreebannerslots2', $settings);
				$freerefersprobannerslotsarr2 = $banner->getVarArray('freerefersprobannerslots2', $settings);
				$freerefersgoldbannerslotsarr2 = $banner->getVarArray('freerefersgoldbannerslots2', $settings);
				$freerefersfreebannerslotsarr3 = $banner->getVarArray('freerefersfreebannerslots3', $settings);
				$freerefersprobannerslotsarr3 = $banner->getVarArray('freerefersprobannerslots3', $settings);
				$freerefersgoldbannerslotsarr3 = $banner->getVarArray('freerefersgoldbannerslots3', $settings);
				$freerefersfreebannerslotsarr4 = $banner->getVarArray('freerefersfreebannerslots4', $settings);
				$freerefersprobannerslotsarr4 = $banner->getVarArray('freerefersprobannerslots4', $settings);
				$freerefersgoldbannerslotsarr4 = $banner->getVarArray('freerefersgoldbannerslots4', $settings);
				$freerefersfreebannerslotsarr5 = $banner->getVarArray('freerefersfreebannerslots5', $settings);
				$freerefersprobannerslotsarr5 = $banner->getVarArray('freerefersprobannerslots5', $settings);
				$freerefersgoldbannerslotsarr5 = $banner->getVarArray('freerefersgoldbannerslots5', $settings);
				$freerefersfreebannerslotsarr6 = $banner->getVarArray('freerefersfreebannerslots6', $settings);
				$freerefersprobannerslotsarr6 = $banner->getVarArray('freerefersprobannerslots6', $settings);
				$freerefersgoldbannerslotsarr6 = $banner->getVarArray('freerefersgoldbannerslots6', $settings);
				$probannerslotsarr = $banner->getVarArray('probannerslots', $settings);
				$prorefersfreebannerslotsarr1 = $banner->getVarArray('prorefersfreebannerslots1', $settings);
				$prorefersprobannerslotsarr1 = $banner->getVarArray('prorefersprobannerslots1', $settings);
				$prorefersgoldbannerslotsarr1 = $banner->getVarArray('prorefersgoldbannerslots1', $settings);
				$prorefersfreebannerslotsarr2 = $banner->getVarArray('prorefersfreebannerslots2', $settings);
				$prorefersprobannerslotsarr2 = $banner->getVarArray('prorefersprobannerslots2', $settings);
				$prorefersgoldbannerslotsarr2 = $banner->getVarArray('prorefersgoldbannerslots2', $settings);
				$prorefersfreebannerslotsarr3 = $banner->getVarArray('prorefersfreebannerslots3', $settings);
				$prorefersprobannerslotsarr3 = $banner->getVarArray('prorefersprobannerslots3', $settings);
				$prorefersgoldbannerslotsarr3 = $banner->getVarArray('prorefersgoldbannerslots3', $settings);
				$prorefersfreebannerslotsarr4 = $banner->getVarArray('prorefersfreebannerslots4', $settings);
				$prorefersprobannerslotsarr4 = $banner->getVarArray('prorefersprobannerslots4', $settings);
				$prorefersgoldbannerslotsarr4 = $banner->getVarArray('prorefersgoldbannerslots4', $settings);
				$prorefersfreebannerslotsarr5 = $banner->getVarArray('prorefersfreebannerslots5', $settings);
				$prorefersprobannerslotsarr5 = $banner->getVarArray('prorefersprobannerslots5', $settings);
				$prorefersgoldbannerslotsarr5 = $banner->getVarArray('prorefersgoldbannerslots5', $settings);
				$prorefersfreebannerslotsarr6 = $banner->getVarArray('prorefersfreebannerslots6', $settings);
				$prorefersprobannerslotsarr6 = $banner->getVarArray('prorefersprobannerslots6', $settings);
				$prorefersgoldbannerslotsarr6 = $banner->getVarArray('prorefersgoldbannerslots6', $settings);
				$goldbannerslotsarr = $banner->getVarArray('goldbannerslots', $settings);
				$goldrefersfreebannerslotsarr1 = $banner->getVarArray('goldrefersfreebannerslots1', $settings);
				$goldrefersprobannerslotsarr1 = $banner->getVarArray('goldrefersprobannerslots1', $settings);
				$goldrefersgoldbannerslotsarr1 = $banner->getVarArray('goldrefersgoldbannerslots1', $settings);
				$goldrefersfreebannerslotsarr2 = $banner->getVarArray('goldrefersfreebannerslots2', $settings);
				$goldrefersprobannerslotsarr2 = $banner->getVarArray('goldrefersprobannerslots2', $settings);
				$goldrefersgoldbannerslotsarr2 = $banner->getVarArray('goldrefersgoldbannerslots2', $settings);
				$goldrefersfreebannerslotsarr3 = $banner->getVarArray('goldrefersfreebannerslots3', $settings);
				$goldrefersprobannerslotsarr3 = $banner->getVarArray('goldrefersprobannerslots3', $settings);
				$goldrefersgoldbannerslotsarr3 = $banner->getVarArray('goldrefersgoldbannerslots3', $settings);
				$goldrefersfreebannerslotsarr4 = $banner->getVarArray('goldrefersfreebannerslots4', $settings);
				$goldrefersprobannerslotsarr4 = $banner->getVarArray('goldrefersprobannerslots4', $settings);
				$goldrefersgoldbannerslotsarr4 = $banner->getVarArray('goldrefersgoldbannerslots4', $settings);
				$goldrefersfreebannerslotsarr5 = $banner->getVarArray('goldrefersfreebannerslots5', $settings);
				$goldrefersprobannerslotsarr5 = $banner->getVarArray('goldrefersprobannerslots5', $settings);
				$goldrefersgoldbannerslotsarr5 = $banner->getVarArray('goldrefersgoldbannerslots5', $settings);
				$goldrefersfreebannerslotsarr6 = $banner->getVarArray('goldrefersfreebannerslots6', $settings);
				$goldrefersprobannerslotsarr6 = $banner->getVarArray('goldrefersprobannerslots6', $settings);
				$goldrefersgoldbannerslotsarr6 = $banner->getVarArray('goldrefersgoldbannerslots6', $settings);

				if (
					!in_array($i, $freebannerslotsarr) &&
					!in_array($i, $freerefersfreebannerslotsarr1) &&
					!in_array($i, $freerefersprobannerslotsarr1) &&
					!in_array($i, $freerefersgoldbannerslotsarr1) &&
					!in_array($i, $freerefersfreebannerslotsarr2) &&
					!in_array($i, $freerefersprobannerslotsarr2) &&
					!in_array($i, $freerefersgoldbannerslotsarr2) &&
					!in_array($i, $freerefersfreebannerslotsarr3) &&
					!in_array($i, $freerefersprobannerslotsarr3) &&
					!in_array($i, $freerefersgoldbannerslotsarr3) &&
					!in_array($i, $freerefersfreebannerslotsarr4) &&
					!in_array($i, $freerefersprobannerslotsarr4) &&
					!in_array($i, $freerefersgoldbannerslotsarr4) &&
					!in_array($i, $freerefersfreebannerslotsarr5) &&
					!in_array($i, $freerefersprobannerslotsarr5) &&
					!in_array($i, $freerefersgoldbannerslotsarr5) &&
					!in_array($i, $freerefersfreebannerslotsarr6) &&
					!in_array($i, $freerefersprobannerslotsarr6) &&
					!in_array($i, $freerefersgoldbannerslotsarr6) &&
					!in_array($i, $probannerslotsarr) &&
					!in_array($i, $prorefersfreebannerslotsarr1) &&
					!in_array($i, $prorefersprobannerslotsarr1) &&
					!in_array($i, $prorefersgoldbannerslotsarr1) &&
					!in_array($i, $prorefersfreebannerslotsarr2) &&
					!in_array($i, $prorefersprobannerslotsarr2) &&
					!in_array($i, $prorefersgoldbannerslotsarr2) &&
					!in_array($i, $prorefersfreebannerslotsarr3) &&
					!in_array($i, $prorefersprobannerslotsarr3) &&
					!in_array($i, $prorefersgoldbannerslotsarr3) &&
					!in_array($i, $prorefersfreebannerslotsarr4) &&
					!in_array($i, $prorefersprobannerslotsarr4) &&
					!in_array($i, $prorefersgoldbannerslotsarr4) &&
					!in_array($i, $prorefersfreebannerslotsarr5) &&
					!in_array($i, $prorefersprobannerslotsarr5) &&
					!in_array($i, $prorefersgoldbannerslotsarr5) &&
					!in_array($i, $prorefersfreebannerslotsarr6) &&
					!in_array($i, $prorefersprobannerslotsarr6) &&
					!in_array($i, $prorefersgoldbannerslotsarr6) &&
					!in_array($i, $goldbannerslotsarr) &&
					!in_array($i, $goldrefersfreebannerslotsarr1) &&
					!in_array($i, $goldrefersprobannerslotsarr1) &&
					!in_array($i, $goldrefersgoldbannerslotsarr1) &&
					!in_array($i, $goldrefersfreebannerslotsarr2) &&
					!in_array($i, $goldrefersprobannerslotsarr2) &&
					!in_array($i, $goldrefersgoldbannerslotsarr2) &&
					!in_array($i, $goldrefersfreebannerslotsarr3) &&
					!in_array($i, $goldrefersprobannerslotsarr3) &&
					!in_array($i, $goldrefersgoldbannerslotsarr3) &&
					!in_array($i, $goldrefersfreebannerslotsarr4) &&
					!in_array($i, $goldrefersprobannerslotsarr4) &&
					!in_array($i, $goldrefersgoldbannerslotsarr4) &&
					!in_array($i, $goldrefersfreebannerslotsarr5) &&
					!in_array($i, $goldrefersprobannerslotsarr5) &&
					!in_array($i, $goldrefersgoldbannerslotsarr5) &&
					!in_array($i, $goldrefersfreebannerslotsarr6) &&
					!in_array($i, $goldrefersprobannerslotsarr6) &&
					!in_array($i, $goldrefersgoldbannerslotsarr6)
				) {
					// This can only be a paid banner rotator. Show link to buy one.
					$showinmodal = 'paidonly';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i, 'memberarea');
				} else {
					if ($accounttype === "Free") {
						// Upgrade button for both pro and gold.
						$showinmodal = 'upgradeproandgold';
						echo $banner->showBannerPlaceholder($i, $width, $height, 'Upgrade to Pro or Gold to add your banner to Slot ' . $i, 'memberarea');
					} elseif ($accounttype === "Pro") {
						// Upgrade button for gold.
						$showinmodal = 'upgradegold';
						echo $banner->showBannerPlaceholder($i, $width, $height, 'Upgrade to Gold to add your banner to Slot ' . $i, 'memberarea');
					} else {
						// This can only be a paid banner rotator. Show link to buy one.
						$showinmodal = 'paidonly';
						echo $banner->showBannerPlaceholder($i, $width, $height, 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i, 'memberarea');
					}
				}
			}

			?>
			<div class="modal fade" id="viralbannerModal<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="viralbannerModal<?php echo $i ?>" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">

						<?php
						switch ($showinmodal) {

							case "add":
							?>
								<h2>Add Your Viral Banner to Slot <?php echo $i ?></h2>

								<form action="/viralbanners" method="post" accept-charset="utf-8" class="form" role="form">
									<label for="name">Name of Viral Banner (only you see):</label>
									<input type="text" name="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"]: ''; ?>" class="form-control input-lg" placeholder="Name" required>

									<label for="title">Alt Text:</label>
									<input type="text" name="alt" value="<?php echo isset($_POST["alt"]) ? $_POST["alt"]: ''; ?>" class="form-control input-lg" placeholder="Alt Text" required>

									<label for="url">Click-Thru URL:</label>
									<input type="url" name="url" value="<?php echo isset($_POST["url"]) ? $_POST["url"]: ''; ?>" class="form-control input-lg" placeholder="Click-Thru URL" required>

									<label for="imageurl">Image URL: (<?php echo $width ?> x <?php echo $height ?> pixels only)</label>
									<input type="url" name="imageurl" value="<?php echo isset($_POST["imageurl"]) ? $_POST["imageurl"]: ''; ?>" class="form-control input-lg" placeholder="Image URL" required>

									<div class="ja-bottompadding"></div>

									<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
									<input type="hidden" name="bannerpageslot" value="<?php echo $i ?>">
									<input type="hidden" name="username" value="<?php echo $username ?>">
									<button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="createad">CREATE!</button>
								</form>
							<?php
							break;

							case "edit":
							?>
								<h2>Update Your Slot <?php echo $i ?> Viral Banner</h2>

								<form action="/viralbanners/<?php echo $usershowbanner['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">

								<!-- TODO: Show instructions on how to see banner stats by clicking!  -->
									<p class="mb-3">Hits/Impressions: <strong><?php echo $usershowbanner['hits']; ?></strong></p>
									<p class="mb-3">Clicks: <strong><?php echo $usershowbanner['clicks']; ?></strong></p>

									<label for="name">Name of Viral Banner (only you see):</label>
									<input type="text" name="name" class="form-control input-lg" placeholder="Name" value="<?php echo $usershowbanner['name']; ?>" required>

									<label for="title">Alt Text:</label>
									<input type="text" name="alt" class="form-control input-lg" placeholder="Alt Text" value="<?php echo $usershowbanner['alt']; ?>" required>

									<label for="url">Click-Thru URL:</label>
									<input type="url" name="url" class="form-control input-lg" placeholder="Click-Thru URL" value="<?php echo $usershowbanner['url']; ?>"" required>

									<label for="imageurl">Image URL: (<?php echo $width ?> x <?php echo $height ?> pixels only)</label>
									<input type="url" name="imageurl" class="form-control input-lg" placeholder="Image URL" value="<?php echo $usershowbanner['imageurl']; ?>"" required>

									<div class=" ja-bottompadding"></div>

									<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
									<input type="hidden" name="bannerpageslot" value="<?php echo $i ?>">
									<input type="hidden" name="username" value="<?php echo $username ?>">
									<button id="savebutton" class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="savead">SAVE!</button>
								</form>

								<form action="/viralbanners/<?php echo $usershowbanner['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
									<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="name" value="<?php echo $usershowbanner['name']; ?>">
									<button class="btn btn-lg btn-danger ja-bottompadding ja-toppadding" type="submit" name="deletead">DELETE</button>
								</form>
							<?php
							break;

							case "upgradeproandgold":
							?>
								<section id="upgrade" class="paybuttons">
									<h2>Upgrade Your Membership</h2>
									<?php
										$upgrade = new UpgradeButton(new User(new Email()), $settings);
										# Upgrade to Pro pay buttons.
										echo $upgrade->showUpgradeButton('Pro', $username, $referid);
										# Upgrade to Gold pay buttons.
										echo $upgrade->showUpgradeButton('Gold', $username, $referid);
									?>
								</section>
							<?php
							break;

							case "upgradegold":
							?>
								<section id="upgrade" class="paybuttons">
									<h2>Upgrade Your Membership</h2>
									<?php
										$upgrade = new UpgradeButton(new User(new Email()), $settings);
										# Upgrade to Gold pay buttons.
										$goldbuttons = $upgrade->showUpgradeButton('Gold', $username, $referid);
										echo $goldbuttons;
									?>
								</section>
							<?php
							break;
							
							case "paidonly":
								$modal = 1;
								echo '<div class="ja-toppadding2"></div>';
								include "bannerspaid.php";
								break;

							default:
								$modal = 1;
								echo '<div class="ja-toppadding2"></div>';
								include "bannerspaid.php";
								break;
								
						} // switch
						?>

						</div> <!-- modal-body -->

						<div class="modal-footer">
							<button class="btn btn-lg btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
						</div> <!-- modal-footer -->

					</div> <!-- modal-content -->
				</div> <!-- modal-dialog -->
			</div> <!-- modal class -->
<?php
		}
?>
	</div> <!-- viralbanners class -->

<div class="ja-bottompadding ja-toppadding"></div>

</div> <!-- container class -->