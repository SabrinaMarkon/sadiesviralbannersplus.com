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

			foreach ($bannerslotvarnames as $bannerslotvarname) {

				// First convert the csv string from the database to an array of Viral Banner slot ids:
				$bannerslotarrayfromcsvstring = $banner->getVarArray($bannerslotvarname, $settings);


// `freebannerslots` varchar(32) not null default '1,2,3',
// `freedownlineupgradestogetbonusslotsonfreereferralpages` integer unsigned not null default '5',
// `freedownlineupgradeswhichbonusslotsonfreereferralpages` varchar(32) not null default '3',
// `freedownlineupgradestogetbonusslotsonproreferralpages` integer unsigned not null default '8',
// `freedownlineupgradeswhichbonusslotsonproreferralpages` varchar(32) not null default '4',
// `freedownlineupgradestogetbonusslotsongoldreferralpages` integer unsigned not null default '0',
// `freedownlineupgradeswhichbonusslotsongoldreferralpages` varchar(32) not null default '',
// `freerefersfreebannerslots1` varchar(32) not null default '4,5,6,7,8,11',
// `freerefersprobannerslots1` varchar(32) not null default '7,8,11',
// `freerefersgoldbannerslots1` varchar(32) not null default '11',
// `freerefersfreebannerslots2` varchar(32) not null default '',
// `freerefersprobannerslots2` varchar(32) not null default '',
// `freerefersgoldbannerslots2` varchar(32) not null default '',
// `freerefersfreebannerslots3` varchar(32) not null default '',
// `freerefersprobannerslots3` varchar(32) not null default '',
// `freerefersgoldbannerslots3` varchar(32) not null default '',
// `freerefersfreebannerslots4` varchar(32) not null default '',
// `freerefersprobannerslots4` varchar(32) not null default '',
// `freerefersgoldbannerslots4` varchar(32) not null default '',
// `freerefersfreebannerslots5` varchar(32) not null default '',
// `freerefersprobannerslots5` varchar(32) not null default '',
// `freerefersgoldbannerslots5` varchar(32) not null default '',
// `freerefersfreebannerslots6` varchar(32) not null default '',
// `freerefersprobannerslots6` varchar(32) not null default '',
// `freerefersgoldbannerslots6` varchar(32) not null default '',


				// 1) strpos makes sure the admin setting varname is one meant for this member's accounttype.
				// in_array make sure a slot is checked off in this adminsetting.
				// So, is this slot available to this member's accounttype level?
				if (in_array($i, $bannerslotarrayfromcsvstring) && strpos($bannerslotvarname, $prefix) === 0) {

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

					echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . ' - ' . strpos($bannerslotvarname, $prefix) . " CATS<hr>";

					break; // slot was found in this array so no need to check any other slot arrays (from adminsettings).
				}

				// 2) This slot is unavailable to members of this accounttype, but IS availalbe to one or both of the other accounttypes.
				elseif (in_array($i, $bannerslotarrayfromcsvstring) && strpos($bannerslotvarname, $prefix) === false) {
					/*
					POSSIBLE COMBINATIONS (the ones for the member's OWN accounttype were checked FIRST at the beginning of the loop, 
					so if we are here, it means we check combinations that do not include their own accounttype):
					- Free only (member is pro or gold)
					- Pro only (member is free or gold)
					- Gold only (member is free or pro)
					- Free + Pro (member is gold)
					- Free + gold (member is pro)
					- Pro + Gold (member is free)
					*/
					$showbanner['bannerslot'] = $i;
					$showbanner['width'] = $width;
					$showbanner['height'] = $height;
					$showbanner ['source'] = 'memberarea';

					// Only free members can access this slot:
					if (strpos($bannerslotvarname, 'free') === 0 && strpos($bannerslotvarname, 'pro') === false && strpos($bannerslotvarname, 'gold') === false) {
						// Upgrade button for both pro and gold.
						$showbanner['showinmodal'] = 'upgradeproandgold'; // Show upgrade modal anyway if the member clicks it to encourage upgrading.
						$showbanner['msg'] = 'Only Free members can add their banner to Slot ' . $i;
						echo $banner->showBannerPlaceholder($showbanner);
						echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BIRDS1 <hr>";	
						break; // slot was found in this array for one or more membership levels that aren't the same as the member's own, so no need to check any other slot arrays (from adminsettings).
					}
					// Only free or pro members can access this slot (member is definitely a GOLD member since both free and pro can already access and gold is the only one left):
					elseif ((strpos($bannerslotvarname, 'free') === 0 || strpos($bannerslotvarname, 'pro') === 0) && strpos($bannerslotvarname, 'gold') === false) {
						// Upgrade button for pro and message that free members can access too.
						$showbanner['showinmodal'] = 'paidonly'; // member is already a gold member so no upgrade buttons are needed! But we can still sell paid-only banners.
						// $showbanner['msg'] = 'Only Free or Pro members can add their banner to Slot ' . $i;
						$showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
						echo $banner->showBannerPlaceholder($showbanner);
						echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BIRDS2 <hr>";	
						break;
					}
					// Only free or gold members can access this slot (member is definitely a PRO member since both free and gold can already access and pro is the only one left):
					elseif ((strpos($bannerslotvarname, 'free') === 0 || strpos($bannerslotvarname, 'gold') === 0) && strpos($bannerslotvarname, 'pro') === false) {
						// Upgrade button for gold and message that free members can access too. Member is ALREADY pro so only n eeds an upgrade to gold button.
						$showbanner['showinmodal'] = 'upgradegold';
						$showbanner['msg'] = 'Upgrade to Gold to add your banner to Slot ' . $i;
						echo $banner->showBannerPlaceholder($showbanner);
						echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BIRDS3 <hr>";	
						break;
					}
					// Only pro members can access this slot:
					elseif (strpos($bannerslotvarname, 'pro') === 0 && strpos($bannerslotvarname, 'free') === false && strpos($bannerslotvarname, 'gold') === false) {
						// Upgrade button for both pro and gold, but say the banner is only available for pro (since upgrading to gold would also make it unavailable).
						$showbanner['showinmodal'] = 'upgradeproandgold'; // Show gold upgrade button along with pro anyway even though slot is unavailable to gold to encourage gold upgrade.
						$showbanner['msg'] = 'Upgrade to Pro to add your banner to Slot ' . $i . " (Note this slot is ONLY for Pro)";
						echo $banner->showBannerPlaceholder($showbanner);
						echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BIRDS4 <hr>";	
						break;
					}
					// Only pro or gold members can access this slot (member is definitely a FREE member since both pro and gold can already access and free is the only one left):
					elseif ((strpos($bannerslotvarname, 'pro') === 0 || strpos($bannerslotvarname, 'gold') === 0) && strpos($bannerslotvarname, 'free') === false) {
						// Upgrade button for both pro and gold.
						$showbanner['showinmodal'] = 'upgradeproandgold';
						$showbanner['msg'] = 'Upgrade to Pro or Gold to add your banner to Slot ' . $i;
						echo $banner->showBannerPlaceholder($showbanner);
						echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BIRDS5 <hr>";	
						break;
					}
					// Only gold members can access this slot:
					elseif (strpos($bannerslotvarname, 'gold') === 0 && strpos($bannerslotvarname, 'free') === false && strpos($bannerslotvarname, 'pro') === false) {
						// Upgrade button for gold.
						$showbanner['showinmodal'] = 'upgradegold';
						$showbanner['msg'] = 'Upgrade to Gold to add your banner to Slot ' . $i . " (Note this slot is ONLY for Gold)";
						echo $banner->showBannerPlaceholder($showbanner);
						echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BIRDS6 <hr>";	
						break;
					}
					// No membership levels can access this slot, so it is a paid-only banner (but has something checked for some reason anyway (?)):
					else {
						// Bug? So show paid-only banner order form.
						$showbanner['showinmodal'] = 'paidonly';
						$showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
						echo $banner->showBannerPlaceholder($showbanner);
						echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BIRDS7 <hr>";	
						break;
					}
				}

				// 3) This slot is unavailable to members of this accounttype.
				// Is it available to ANY accounttypes though?
				// If this slot is not in an array at all, show the paid-only banner modal.
				// elseif (!in_array($i, $bannerslotarrayfromcsvstring)) {
				// 	// It isn't available for any membership level.
				// 	// This can only be a paid banner rotator. Show link to buy one.
				// 	$showbanner['bannerslot'] = $i;
				// 	$showbanner['width'] = $width;
				// 	$showbanner['height'] = $height;
				// 	$showbanner ['source'] = 'memberarea';
				// 	$showbanner['showinmodal'] = 'paidonly';
				// 	$showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
				// 	echo $banner->showBannerPlaceholder($showbanner);

				// 	echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BUNNIES<br>";

				// 	break; // slot was NOT found in this array for any membership level so no need to check any other slot arrays (from adminsettings).					
				// }

				else {
					// It isn't available for any membership level.
					// This can only be a paid banner rotator. Show link to buy one.
					$showbanner['bannerslot'] = $i;
					$showbanner['width'] = $width;
					$showbanner['height'] = $height;
					$showbanner ['source'] = 'memberarea';
					$showbanner['showinmodal'] = 'paidonly';
					$showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
					echo $banner->showBannerPlaceholder($showbanner);

					echo $i . " - " . $bannerslotvarname . ' - ' . $$bannerslotvarname . " BUNNIES<br>";
					break;
				}
			} // end foreach admin setting variable.
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