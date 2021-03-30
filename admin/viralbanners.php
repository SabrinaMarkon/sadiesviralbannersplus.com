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

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
    $$key = $value;
}

$allmembers = new Member();
$members = $allmembers->getAllMembers();

$adtable = 'viralbanners';
$banner = new ViralBanner($adtable);
$ads = $banner->getAllAds();
?>

<div class="container">

    <h2 class="pt-4">Viral Banners</h2>

    <div class="ja-toppadding mb-4"></div>

    <p>Depending on their membership level, members can add their banners to both their own and their referrals' Viral Banner Pages.</p>

    <div class="ja-toppadding mb-2"></div>

    <h2 class="pt-4">Viral Banner Settings</h2>

    <div class="ja-toppadding mb-4"></div>

    <p>Every member has a Viral Banner Page that has 12 slots for banners. You can check which slots members or their sponsors can add their banners to here.</p>

    <div class="ja-toppadding mb-4"></div>

    <form action="/admin/viralbanners" method="post" class="form" role="form">

        <h3>Free Member Banner Page Settings</h3>

        <label for="freebannerclickstosignup" class="mt-4">Member banners a new Free member has to click to signup:</label>
        <input type="number" min="0" step="1" name="freebannerclickstosignup" value="<?php echo $freebannerclickstosignup ?>" class="form-control smallselect" required>

        <label class="mt-2">Banner slots included with Free membership:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="freebannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $freebannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="freebannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Free member gets on their Free referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="freerefersfreebannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $freerefersfreebannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="freerefersfreebannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Free member gets on their Pro referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="freerefersprobannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $freerefersprobannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="freerefersprobannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Free member gets on their Gold referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="freerefersgoldbannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $freerefersgoldbannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="freerefersgoldbannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>


        <br /><br />
        <h3>Pro Member Banner Page Settings</h3>

        <label for="probannerclickstosignup" class="mt-4">Member banners a new Pro member has to click to signup:</label>
        <input type="number" min="0" step="1" name="probannerclickstosignup" value="<?php echo $probannerclickstosignup ?>" class="form-control smallselect" required>

        <label class="mt-2">Banner slots included with Pro membership:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="probannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $probannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="probannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Pro member gets on their Free referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="prorefersfreebannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $prorefersfreebannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="prorefersfreebannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Pro member gets on their Pro referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="prorefersprobannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $prorefersprobannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="prorefersprobannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Pro member gets on their Gold referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="prorefersgoldbannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $prorefersgoldbannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="prorefersgoldbannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>


        <br /><br />
        <h3>Gold Member Banner Page Settings</h3>

        <label for="goldbannerclickstosignup" class="mt-4">Member banners a new Gold member has to click to signup:</label>
        <input type="number" min="0" step="1" name="goldbannerclickstosignup" value="<?php echo $goldbannerclickstosignup ?>" class="form-control smallselect" required>

        <label class="mt-2">Banner slots included with Gold membership:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="goldbannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $goldbannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="goldbannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Gold member gets on their Free referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="goldrefersfreebannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $goldrefersfreebannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="goldrefersfreebannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Gold member gets on their Pro referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="goldrefersprobannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $goldrefersprobannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="goldrefersprobannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <label class="mt-2">Banner slots a Gold member gets on their Gold referral's page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">
        <?php
        for ($i = 1; $i <= 12; $i += 3) {
        ?>
            <div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">
                <?php
                for ($j = $i; $j <= $i + 2; $j++) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="goldrefersgoldbannerslots[<?php echo $j ?>]" 
                        value="<?php echo $j ?>" 
                        <?php
                        if (in_array($j, explode(',', $goldrefersgoldbannerslots))) {
                            echo " checked";
                        }
                        ?>>
                        <label class="form-check-label" for="goldrefersgoldbannerslots[<?php echo $j ?>]">Slot #<?php echo $j ?></label>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        </div>

        <div class="ja-bottompadding"></div>

        <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
        <button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="saveadsettings">SAVE SETTINGS</button>

    </form>

    

    <h2 class="ja-bottompadding ja-toppadding mb-4">Default Admin Viral Banners</h2>

    <p>Admin banners show on members' Viral Banner Pages when neither a member nor their sponsor have saved a banner for any of their slots. The form below lets you add a default admin viral banner for each slot. Underneath the form, you can also see which slots you already have saved default banners for.</p>

    <div class="ja-toppadding mb-4"></div>

    <h3 class="ja-bottompadding" id="createad">Create Viral Banner</h3>

	<form action="/admin/viralbanners" method="post" accept-charset="utf-8" class="form" role="form">

		<label for="username">For Username:</label>
        <select name="username" class="form-control input-lg">
            <option value="admin">admin</option>
            <?php
            foreach ($members as $member) {
                $username = $member['username'];
                ?>
                <option value="<?php echo $username ?>"><?php echo $username ?></options>
                <?php
                }
                ?>
        </select>

        <label for="bannerpageslot">Viral Banner Slot:</label>
        <select name="bannerpageslot" class="form-control widetableselect">
            <?php
            for ($i = 1; $i <= 12; $i++) {
                ?>
                <option value="<?php echo $i ?>">
                    <?php echo $i ?>
                </option>
                <?php
            }
            ?>
        </select>

		<label for="name">Name of Ad:</label>
		<input type="text" name="name" id="name" class="form-control input-lg" placeholder="Name" required>

		<label for="title">Alt Text:</label>
		<input type="text" name="alt" id="alt" class="form-control input-lg" placeholder="Alt Text" required>

		<label for="url">Click-Thru URL:</label>
		<input type="url" name="url" id="url" class="form-control input-lg" placeholder="Click-Thru URL" required>

		<label for="imageurl">Image URL: (slots 1-8 are 728 x 90 only, and slots 9-12 are 468 x 60 only)</label>
		<input type="url" name="imageurl" id="imageurl" class="form-control input-lg" placeholder="Image URL" required>

		<div class="ja-bottompadding"></div>

		<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
		<button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="createad">CREATE AD</button>

	</form>

    <div class="ja-toppadding mb-4"></div>

    <h3 class="ja-bottompadding">Admin Viral Banner List</h3>

    <div class="viralbanners">
        <?php
        for ($i = 1; $i <= 8; $i++) {

            // Set up default admin 728 x 90 banners.
            $adminshowbanner = $banner->getViralBanner('admin', $i);
            if (!empty($adminshowbanner)) {

                $adminbanner = $banner->showBanner($adminshowbanner, 728, 90, 1);
                echo $adminbanner;

            } else {

                // Show blank banner for this position with fields for the admin to add one.
                echo '
                <div>
                    <a href="#createad">
                    <img src="https://via.placeholder.com/728x90/ffffff/121212?text=DEFAULT+ADMIN+BANNER+FOR+VIRAL+BANNER+SLOT+' . $i . '" alt="Default Admin Banner for Viral Banner Slot# <?php echo $i ?>">
                    </a>
                </div>';
            }
        }
        for ($i = 9; $i <= 12; $i++) {

            // Set up default admin 468 x 60 banners.
            $adminshowbanner = $banner->getViralBanner('admin', $i);
            if (!empty($adminshowbanner)) {

                $adminbanner = $banner->showBanner($adminshowbanner, 468, 60, 1);
                echo $adminbanner;

            } else {

                // Show blank banner for this position with fields for the admin to add one.
                echo '
                <div>
                    <a href="#createad">
                    <img src="https://via.placeholder.com/468x60/ffffff/121212?text=DEFAULT+ADMIN+BANNER+FOR+VIRAL+BANNER+SLOT+' . $i . '" alt="Default Admin Banner for Viral Banner Slot# <?php echo $i ?>">
                    </a>
                </div>';
            }
        }
        ?>
    </div>

    <div class="ja-toppadding mb-4"></div>

    <h2 class="ja-bottompadding ja-toppadding mb-4">All Member Viral Banners</h2>

    <p>You can see, change, or even delete both your admin and members' Viral Banners in the list below.</p>

    <form action="/admin/viralbanners" method="post" accept-charset="utf-8" class="form" role="form">
    <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
    <button class="btn btn-lg btn-primary mt-4 mb-3" type="submit" name="approveallads">APPROVE ALL</button>
    </form>

</div>

<div class="mt-4">
    <table id="admintable" class="table table-hover text-center table-sm">
        <thead>
            <tr>
                <th class="text-center small">Ad&nbsp;#</th>
                <th class="text-center small">Approved</th>
                <th class="text-center small" style="min-width: 200px;">Image</th>
                <th class="text-center small" style="min-width: 100px;">Username</th>
                <th class="text-center small" style="min-width: 100px;">Banner&nbsp;Slot</th>
                <th class="text-center small" style="min-width: 100px;">Name</th>
                <th class="text-center small" style="min-width: 100px;">Alt</th>
                <th class="text-center small" style="min-width: 200px;">Click-Thru&nbsp;URL</th>
                <th class="text-center small">Short&nbsp;URL</th>
                <th class="text-center small" style="min-width: 200px;">Image&nbsp;URL</th>
                <th class="text-center small">Impressions</th>
                <th class="text-center small">Clicks</th>
                <th class="text-center small" style="min-width: 150px;">Date</th>
                <th class="text-center small">Save</th>
                <th class="text-center small">Delete</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (!$ads) {
            } else {

                foreach ($ads as $ad) {

                    $adddate = $ad['adddate'];

                    if (trim($adddate) == '' || substr($adddate, 0, 10) == '0000-00-00') {

                        $dateadadded = 'Not Yet';
                    } else {

                        $dateadadded = date('Y-m-d');
                    }
            ?>
                    <tr>
                        <form action="/admin/viralbanners/<?php echo $ad['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                            <td class="small"><?php echo $ad['id']; ?>
                            </td>
                            <td class="small<?php if ($ad['approved'] !== "1") { echo ' ja-coralbg'; } ?>">
                                <select name="approved" class="form-control widetableselect">
                                    <option value="0" <?php if ($ad['approved'] !== "1") {
                                                            echo "selected";
                                                        } ?>>No</option>
                                    <option value="1" <?php if ($ad['approved'] === "1") {
                                                            echo "selected";
                                                        } ?>>Yes</option>
                                </select>
                            </td>
                            <td class="small">
                                <?php
                                if ($ad['imageurl']) {
                                ?>
                                    <img src="<?php echo $ad['imageurl']; ?>" alt="<?php echo $ad['alt'] ?>" class="mini-banner-image">
                                <?php
                                } else {
                                ?>
                                    <img src="https://via.placeholder.com/200x26/0067f4/ffffff?text=NOT+ADDED" alt="Not Added" class="mini-banner-image">
                                <?php
                                }
                                ?>
                            </td>
                            <td class="small">
                                <select name="username" class="form-control input-sm widetableinput">
                                    <option value="admin"<?php if ($ad['username'] === 'admin') { echo " selected"; } ?>>admin</option>
                                    <?php
                                    foreach ($members as $member) {
                                        $username = $member['username'];
                                        ?>
                                        <option value="<?php echo $username ?>"<?php if ($ad['username'] === $username) { echo " selected"; } ?>><?php echo $username ?></options>
                                        <?php
                                        }
                                        ?>
                                </select>
                            </td>
                            <td class="small">
                                <select name="bannerpageslot" class="form-control widetableselect">
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        ?>
                                        <option value="<?php echo $i ?>"<?php if ($ad['bannerpageslot'] == $i) { echo " selected"; } ?>>
                                            <?php echo $i; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="small">
                                <input type="text" name="name" value="<?php echo $ad['name']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Name" required>
                            </td>
                            <td class="small">
                                <input type="text" name="alt" value="<?php echo $ad['alt']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Alt Text" required>
                            </td>
                            <td>
                                <input type="url" name="url" value="<?php echo $ad['url']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="http://" required>
                            </td>
                            <td>
                                <a href="<?php echo $ad['shorturl'] ?>" target="_blank"><?php echo $ad['shorturl'] ?></a>
                            </td>
                            <td>
                                <input type="url" name="imageurl" value="<?php echo $ad['imageurl']; ?>" class="form-control input-sm widetableinput" size="60" placeholder="http://" required>
                            </td>
                            <td class="small">
                                <?php echo $ad['hits']; ?>
                            </td>
                            <td class="small">
                                <?php echo $ad['clicks']; ?>
                            </td>
                            <td class="small">
                                <?php echo $dateadadded ?>
                            </td>
                            <td>
                                <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
                                <input type="hidden" name="_method" value="PATCH">
                                <button class="btn btn-sm btn-primary" type="submit" name="savead">SAVE</button>
                            </td>
                        </form>
                        <td>
                            <form action="/admin/viralbanners/<?php echo $ad['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="name" value="<?php echo $ad['name']; ?>">
                                <button class="btn btn-sm btn-primary" type="submit" name="deletead">DELETE</button>
                            </form>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>

        </tbody>
    </table>
</div>

<div class="ja-bottompadding"></div>
