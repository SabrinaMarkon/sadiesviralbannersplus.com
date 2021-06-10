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

// ARRAY OF ALL *UNIQUE* SLOTS THE USER HAS ACCESS TO FROM ALL ADMIN VARIABLES:
$freeslotsarray = [];
$proslotsarray = [];
$goldslotsarray = [];

$allslotsarray = [];

// BUILD THE ARRAYS OF ADMIN SETTINGS FOR THE BANNER SLOTS TO USE //
$freeslotvarnames = ['freebannerslots', 'freedownlineupgradeswhichbonusslotsonfreereferralpages', 'freedownlineupgradeswhichbonusslotsonproreferralpages', 'freedownlineupgradeswhichbonusslotsongoldreferralpages'];
$proslotvarnames = ['probannerslots', 'prodownlineupgradeswhichbonusslotsonfreereferralpages', 'prodownlineupgradeswhichbonusslotsonproreferralpages', 'prodownlineupgradeswhichbonusslotsongoldreferralpages'];
$goldslotvarnames = ['goldbannerslots', 'golddownlineupgradeswhichbonusslotsonfreereferralpages', 'golddownlineupgradeswhichbonusslotsonproreferralpages', 'golddownlineupgradeswhichbonusslotsongoldreferralpages'];
// Get all the Viral Banner slot variables from adminsettings.
for ($i = 1; $i <= 6; $i++) {
    // FREE:
	$freerefersfreebannerslots = 'freerefersfreebannerslots' . $i;
	$freerefersprobannerslots = 'freerefersprobannerslots' . $i;
	$freerefersgoldbannerslots = 'freerefersgoldbannerslots' . $i;
	array_push($freeslotvarnames, 
		$freerefersfreebannerslots, 
		$freerefersprobannerslots, 
		$freerefersgoldbannerslots
	);
    // PRO:
    $prorefersfreebannerslots = 'prorefersfreebannerslots' . $i;
	$prorefersprobannerslots = 'prorefersprobannerslots' . $i;
	$prorefersgoldbannerslots = 'prorefersgoldbannerslots' . $i;
	array_push($proslotvarnames, 
		$prorefersfreebannerslots, 
		$prorefersprobannerslots, 
		$prorefersgoldbannerslots
	);
    // GOLD:
    $goldrefersfreebannerslots = 'goldrefersfreebannerslots' . $i;
    $goldrefersprobannerslots = 'goldrefersprobannerslots' . $i;
    $goldrefersgoldbannerslots = 'goldrefersgoldbannerslots' . $i;
    array_push($goldslotvarnames, 
        $goldrefersfreebannerslots, 
        $goldrefersprobannerslots, 
        $goldrefersgoldbannerslots
    );
}

// TODO: Fit the below foreach codes into the above (less computation - better performance). Also put all this into a method.
// Get the Viral Banner slot admin variables.
// FREE:
foreach ($freeslotvarnames as $freeslotvarname) {
    // Get each slot number from this admin variable and push it onto the freeslotsarray variable.
    $slotarray = explode(',', $$freeslotvarname); // $$freeslotvarname is the csv string from the database.
    foreach ($slotarray as $slot) {
        if (!in_array($slot, $freeslotsarray)) {
            array_push($freeslotsarray, $slot);
        } 
    }
}
// PRO:
foreach ($proslotvarnames as $proslotvarname) {
    // Get each slot number from this admin variable and push it onto the proslotsarray variable.
    $slotarray = explode(',', $$proslotvarname); // $$proslotvarname is the csv string from the database.
    foreach ($slotarray as $slot) {
        if (!in_array($slot, $proslotsarray)) {
            array_push($proslotsarray, $slot);
        } 
    }
}
// GOLD:
foreach ($goldslotvarnames as $goldslotvarname) {
    // Get each slot number from this admin variable and push it onto the freeslotsarray variable.
    $slotarray = explode(',', $$goldslotvarname); // $$goldslotvarname is the csv string from the database.
    foreach ($slotarray as $slot) {
        if (!in_array($slot, $goldslotsarray)) {
            array_push($goldslotsarray, $slot);
        } 
    }
}

if ($accounttype === "Gold") {
    $allslotsarray = $goldslotsarray;
}
elseif ($accounttype === "Pro") {
    $allslotsarray = $proslotsarray;
}
else {
    $allslotsarray = $freeslotsarray;
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

            // Is the member allowed to add a Viral Banner to this slot?
            if (in_array($i, $allslotsarray)) {

                // YES!

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

            } // if (in_array($i, $allslotsarray))
            else {

                // NO!

                $showbanner['bannerslot'] = $i;
                $showbanner['width'] = $width;
                $showbanner['height'] = $height;
                $showbanner ['source'] = 'memberarea';

                $free = false;
                $pro = false;
                $gold = false;

                if (in_array($i, $freeslotsarray)) {
                    $free = true; // Free members can use this slot.
                }
                if (in_array($i, $proslotsarray)) {
                    $pro = true; // Pro members can use this slot.
                }
                if (in_array($i, $goldslotsarray)) {
                    $gold = true; // Gold members can use this slot.
                }

                if ($accounttype === 'Free') {
                    
                    // Free members can't use this slot. 
                    // Can Pro members?
                    // Can Gold members?

                    if ($pro && $gold) {
                        // Upgrade to pro or gold modal.
                        $showbanner['showinmodal'] = 'upgradeproandgold';
						$showbanner['msg'] = 'Upgrade to Pro or Gold to add your banner to Slot ' . $i;
                    }
                    elseif ($pro && !$gold) {
                        // Message that slot is only for pro members. Modal offers upgrade to pro or gold however.
                        $showbanner['showinmodal'] = 'upgradeproandgold';
						$showbanner['msg'] = 'Upgrade to Pro to add your banner to Slot ' . $i . '\nThis slot is ONLY for Pro';
                    }
                    elseif (!$pro && $gold) {
                        // Upgrade to gold only modal.
                        $showbanner['showinmodal'] = 'upgradegold';
						$showbanner['msg'] = 'Upgrade to Gold to add your banner to Slot ' . $i . '\nThis slot is ONLY for Gold';
                    }
                    else {
                        // Paid-only banner rotator modal.
                        $showbanner['showinmodal'] = 'paidonly';
						$showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
                    }
                    

                } // accounttype is Free
                elseif ($accounttype === "Pro") {

                    // Pro members can't use this slot. 
                    // Can Free members?
                    // Can Gold members?

                    if ($free && $gold) {
                        // Upgrade to gold modal. Free members can access too, but it is pointless to mention to pros.
                        $showbanner['showinmodal'] = 'upgradegold';
						$showbanner['msg'] = 'Upgrade to Gold to add your banner to Slot ' . $i;
                    }
                    elseif ($free && !$gold) {
                        // Message that slot is only for free members. Modal is for upgrading to gold anyway to encourage upgrading even if they can't use this slot.
                        $showbanner['showinmodal'] = 'upgradegold'; 
						$showbanner['msg'] = 'Only Free members can add their banner to Slot ' . $i . '\nUpgrade to Gold to access more slots';
						echo $banner->showBannerPlaceholder($showbanner);
                    }
                    elseif (!$free && $gold) {
                        // Upgrade to gold only modal.
                        $showbanner['showinmodal'] = 'upgradegold';
						$showbanner['msg'] = 'Upgrade to Gold to add your banner to Slot ' . $i;
                    }
                    else {
                        // Paid-only banner rotator modal.
                        $showbanner['showinmodal'] = 'paidonly';
						$showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
                    }

                } // accounttype is Pro
                elseif ($accounttype === "Gold") {

                    // Gold members can't use this slot. 
                    // Can Free members?
                    // Can Pro members?

                    if ($free && $pro) {
                        // Message that slot is only for free or pro members. Modal is for paid-only banners.
                        $showbanner['showinmodal'] = 'paidonly'; 
						$showbanner['msg'] = 'Only Free or Pro members can add their banner to Slot ' . $i;
                    }
                    elseif ($free && !$pro) {
                        // Message that slot is only for free members. Modal is for paid-only banners.
                        $showbanner['showinmodal'] = 'paidonly'; 
						$showbanner['msg'] = 'Only Free members can add their banner to Slot ' . $i;
                    }
                    elseif (!$free && $pro) {
                        // Message that slot is only for pro members. Modal is for paid-only banners.
                        $showbanner['showinmodal'] = 'paidonly'; 
						$showbanner['msg'] = 'Only Pro members can add their banner to Slot ' . $i;
                    }
                    else {
                        // Paid-only banner rotator modal.
                        $showbanner['showinmodal'] = 'paidonly';
						$showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
                    }

                } // accounttype is Gold
                else {
                    
                    // Bug? No accounttype detected. Show paid-only banner modal by default.
                    $showbanner['showinmodal'] = 'paidonly';
                    $showbanner['msg'] = 'Click for our exclusive paid-only Viral Rotator in Slot ' . $i;
                }
                  
                // Show our computed view:
                echo $banner->showBannerPlaceholder($showbanner);

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