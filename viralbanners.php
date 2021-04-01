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

	<div class="affiliateurl mb-4 pt-3" style="font-weight: bold; text-align: center; font-size: 1.4rem;">
		Show off Your Best Programs on your Own Personal VIRAL Banner App! <br /><a href="<?php echo $domain . "/banners/" . $username; ?>" target="_blank"><?php echo $domain . "/banners/" . $username; ?></a>
	</div>

	<div class="viralbanners">

		<?php
		for ($i = 1; $i <= 12; $i++) {

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
					echo $banner->showBanner($usershowbanner, $width, $height, $i);
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i);
				}
			} elseif (in_array($i, $refersfreebannerslots)) {

				// Does this banner appear on this user's FREE referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i);
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i);
				}
			} elseif (in_array($i, $refersprobannerslots)) {

				// Does this banner appear on this user's PRO referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i);
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i);
				}
			} elseif (in_array($i, $refersgoldbannerslots)) {

				// Does this banner appear on this user's PRO referral's urls?
				$usershowbanner = $banner->getViralBanner($username, $i);
				if (!empty($usershowbanner)) {

					// User already has a banner saved for this slot.
					$showinmodal = 'edit';
					echo $banner->showBanner($usershowbanner, $width, $height, $i);
				} else {

					// Show blank banner for this position with fields for the user to add their own.
					$showinmodal = 'add';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click to add your Viral Banner for Slot ' . $i);
				}
			} else {
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
					$showinmodal = 'paidonly';
					echo $banner->showBannerPlaceholder($i, $width, $height, 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i);
				} else {
					if ($accounttype === "Free") {
						// Upgrade button for both pro and gold.
						$showinmodal = 'upgradeproandgold';
						echo $banner->showBannerPlaceholder($i, $width, $height, 'Upgrade to Pro or Gold to add your banner to Slot ' . $i);
					} elseif ($accounttype === "Pro") {
						// Upgrade button for gold.
						$showinmodal = 'upgradegold';
						echo $banner->showBannerPlaceholder($i, $width, $height, 'Upgrade to Gold to add your banner to Slot ' . $i);
					} else {
						// This can only be a paid banner rotator. Show link to buy one.
						$showinmodal = 'paidonly';
						echo $banner->showBannerPlaceholder($i, $width, $height, 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i);
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
								<h2>Add Your Viral Banner to Slot #<?php echo $i ?></h2>

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
								<h2>Update Your Slot #<?php echo $i ?> Viral Banner</h2>

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
								include_once "bannerspaid.php";
								break;

							default:
								$modal = 1;
								echo '<div class="ja-toppadding2"></div>';
								include_once "bannerspaid.php";
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