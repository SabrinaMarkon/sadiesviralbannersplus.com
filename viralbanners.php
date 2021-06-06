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

$bannerslotvarnames = ['freebannerslots', 'probannerslots', 'goldbannerslots'];

// Get all the Viral Banner slot variables from adminsettings to search through for a username's banners.
for ($i = 1; $i <= 6; $i++) {

	$refersfreebannerslots = $prefix . 'refersfreebannerslots' . $i;
	$refersprobannerslots = $prefix . 'refersprobannerslots' . $i;
	$refersgoldbannerslots = $prefix . 'refersgoldbannerslots' . $i;

	array_push($bannerslotvarnames, 
		$refersfreebannerslots, 
		$refersprobannerslots, 
		$refersgoldbannerslots
	);
}

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
		for ($i = 1; $i <= 16; $i++) {

			// // Show either a modal to add or edit banner, upgrade buttons, or link to paid only banner rotator.
			// $showinmodal added to the $banner array can be: 'edit', 'add', 'paidonly', 'upgradegold', or 'upgradeproandgold'

			if ($i === 1) {
			?>
				<h2 class="ja-bottompadding my-3">Your 728 x 90 Viral Banners</h2>
			<?php
			}
			if ($i === 6) {
			?>
				<h2 class="ja-bottompadding my-3">Your 468 x 60 Viral Banners</h2>
			<?php
			}
			if ($i == 16) {
			?>
				<h2 class="ja-bottompadding my-3">Extra 728 x 90 Viral Banner</h2>
			<?php	
			}

			if ($i <= 5 || $i == 16) {
				$width = 728;
				$height = 90;
			} else {
				$width = 468;
				$height = 60;
			}

			$showbanner = [];
			$foundslot = false;

			foreach ($bannerslotvarnames as $bannerslotvarname) {

				// First convert the csv string from the database to an array of Viral Banner slot ids:
				$bannerslotarrayfromcsvstring = $banner->getVarArray($bannerslotvarname, $settings);

				// strpos makes sure the admin setting varname is one meant for this member's accounttype.
				// in_array make sure a slot is checked off in this adminsetting.
				if (in_array($i, $bannerslotarrayfromcsvstring) && strpos($bannerslotvarname, $prefix) == 0) {

					// Is this banner one that appears on this user's OWN url?
					$showbanner = $banner->getViralBanner($username, $i);
					if (!empty($showbanner['id'])) {
	
						// User already has a banner saved for this slot.
						$showbanner['showinmodal'] = 'edit';
						$showbanner['bannerslot'] = $i;
						$showbanner['width'] = $width;
						$showbanner['height'] = $height;
						$showbanner ['source'] = 'memberarea';
						echo $banner->showBanner($showbanner);

					} else {
	
						// Show blank banner for this position with fields for the user to add their own.
						$showbanner['showinmodal'] = 'add';
						$showbanner['bannerslot'] = $i;
						$showbanner['width'] = $width;
						$showbanner['height'] = $height;
						$showbanner ['source'] = 'memberarea';
						$showbanner['msg'] = 'Click to add your Viral Banner for Slot ' . $i;
						echo $banner->showBannerPlaceholder($showbanner);
					}
					
					$foundslot = true;
					break; // slot was found in this array so no need to check any other slot arrays (from adminsettings).
				}
			}

			if ($foundslot === false) {
				// this banner is unavailable to this user's membership level.
				// Is this a paid only banner?

				$showbanner['bannerslot'] = $i;
				$showbanner['width'] = $width;
				$showbanner['height'] = $height;
				$showbanner ['source'] = 'memberarea';

				if ($accounttype === "Free") {
					// Upgrade button for both pro and gold.
					$showbanner['showinmodal'] = 'upgradeproandgold';
					$showbanner['msg'] = 'Upgrade to Pro or Gold to add your banner to Slot ' . $i;
					echo $banner->showBannerPlaceholder($showbanner);

				} elseif ($accounttype === "Pro") {
					// Upgrade button for gold.
					$showbanner['showinmodal'] = 'upgradegold';
					$showbanner['msg'] = 'Upgrade to Gold to add your banner to Slot ' . $i;
					echo $banner->showBannerPlaceholder($showbanner);

				} else {
					// This can only be a paid banner rotator. Show link to buy one.
					$showbanner['showinmodal'] = 'paidonly';
					$showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
					echo $banner->showBannerPlaceholder($showbanner);
				}
			}
			?>
<?php
		}
?>

<!-- MODAL 1: ADD VIRAL BANNER -->
<div class="modal fade viralBannerModal" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h2>Add Your Viral Banner to Slot <span id="addbannerslot"></span></h2>
				<form action="/viralbanners" method="post" accept-charset="utf-8" class="form" role="form">
					<label for="name">Name of Viral Banner (only you see):</label>
					<input type="text" id="addname" name="name" value="" class="form-control input-lg" placeholder="Name" required>

					<label for="title">Alt Text:</label>
					<input type="text" id="addalt" name="alt" value="" class="form-control input-lg" placeholder="Alt Text" required>

					<label for="url">Click-Thru URL:</label>
					<input type="url" id="addurl" name="url" value="" class="form-control input-lg" placeholder="Click-Thru URL" required>

					<label for="imageurl">Image URL: (<?php echo $width ?> x <?php echo $height ?> pixels only)</label>
					<input type="url" id="addimageurl" name="imageurl" value="" class="form-control input-lg" placeholder="Image URL" required>

					<div class="ja-bottompadding"></div>

					<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
					<input type="hidden" id="addbannerpageslot" name="bannerpageslot" value="">
					<input type="hidden" name="username" value="<?php echo $username ?>">
					<button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="createad">CREATE!</button>
				</form>
			</div> <!-- modal-body -->
			<div class="modal-footer">
				<button class="btn btn-lg btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
			</div> <!-- modal-footer -->
		</div> <!-- modal-content -->
	</div> <!-- modal-dialog -->
</div> <!-- modal class -->		
<!-- END - MODAL 1: ADD VIRAL BANNER -->

<!-- MODAL 2: EDIT VIRAL BANNER -->
<div class="modal fade viralBannerModal" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h2>Update Your Slot <span id="editbannerslot"></span> Viral Banner</h2>
				<form id="editform" action="" method="post" accept-charset="utf-8" class="form" role="form">

				<!-- TODO: Show instructions on how to see banner stats -->
					<p class="mb-3">Hits/Impressions: <strong><span id="edithits"></span></strong></p>
					<p class="mb-3">Clicks: <strong><span id="editclicks"></span></strong></p>

					<label for="name">Name of Viral Banner (only you see):</label>
					<input type="text" id="editname" name="name" class="form-control input-lg" placeholder="Name" value="" required>

					<label for="title">Alt Text:</label>
					<input type="text" id="editalt" name="alt" class="form-control input-lg" placeholder="Alt Text" value="" required>

					<label for="url">Click-Thru URL:</label>
					<input type="url" id="editurl" name="url" class="form-control input-lg" placeholder="Click-Thru URL" value="" required>

					<label for="imageurl">Image URL: (<?php echo $width ?> x <?php echo $height ?> pixels only)</label>
					<input type="url" id="editimageurl" name="imageurl" class="form-control input-lg" placeholder="Image URL" value="" required>

					<div class=" ja-bottompadding"></div>

					<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
					<input type="hidden" name="editbannerpageslot" value="">
					<input type="hidden" name="username" value="<?php echo $username ?>">
					<button id="savebutton" class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="savead">SAVE!</button>
				</form>

				<form id="deleteform" action="" method="POST" accept-charset="utf-8" class="form" role="form">
					<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
					<input type="hidden" name="_method" value="DELETE">
					<input type="hidden" id="deletename" name="name" value="">
					<button class="btn btn-lg btn-danger ja-bottompadding ja-toppadding" type="submit" name="deletead">DELETE</button>
				</form>
			</div> <!-- modal-body -->
			<div class="modal-footer">
				<button class="btn btn-lg btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
			</div> <!-- modal-footer -->
		</div> <!-- modal-content -->
	</div> <!-- modal-dialog -->
</div> <!-- modal class -->		
<!-- END - MODAL 2: EDIT VIRAL BANNER -->

<!-- MODAL 3: UPGRADE TO PRO OR GOLD MEMBERSHIP -->
<div class="modal fade viralBannerModal" id="upgradeproandgold" tabindex="-1" role="dialog" aria-labelledby="upgradeproandgold" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
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
			</div> <!-- modal-body -->
			<div class="modal-footer">
				<button class="btn btn-lg btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
			</div> <!-- modal-footer -->
		</div> <!-- modal-content -->
	</div> <!-- modal-dialog -->
</div> <!-- modal class -->		
<!-- END - MODAL 3: UPGRADE TO PRO OR GOLD MEMBERSHIP -->

<!-- MODAL 4: UPGRADE TO GOLD MEMBERSHIP -->
<div class="modal fade viralBannerModal" id="upgradegold" tabindex="-1" role="dialog" aria-labelledby="upgradegold" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<section id="upgrade" class="paybuttons">
					<h2>Upgrade Your Membership</h2>
					<?php
						$upgrade = new UpgradeButton(new User(new Email()), $settings);
						# Upgrade to Gold pay buttons.
						$goldbuttons = $upgrade->showUpgradeButton('Gold', $username, $referid);
						echo $goldbuttons;
					?>
				</section>
			</div> <!-- modal-body -->
			<div class="modal-footer">
				<button class="btn btn-lg btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
			</div> <!-- modal-footer -->
		</div> <!-- modal-content -->
	</div> <!-- modal-dialog -->
</div> <!-- modal class -->		
<!-- END - MODAL 4: UPGRADE TO GOLD MEMBERSHIP -->

<!-- MODAL 5: PURCHASE A PAID-ONLY BANNER -->
<div class="modal fade viralBannerModal" id="paidonly" tabindex="-1" role="dialog" aria-labelledby="paidonly" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<?php
				$modal = 1;
				echo '<div class="ja-toppadding2"></div>';
				include "bannerspaid.php";
				?>
			</div> <!-- modal-body -->
			<div class="modal-footer">
				<button class="btn btn-lg btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
			</div> <!-- modal-footer -->
		</div> <!-- modal-content -->
	</div> <!-- modal-dialog -->
</div> <!-- modal class -->		
<!-- END - MODAL 5: PURCHASE A PAID-ONLY BANNER -->

</div> <!-- viralbanners class -->

<div class="ja-bottompadding ja-toppadding"></div>

</div> <!-- container class -->