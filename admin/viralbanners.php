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

// if (isset($_GET['showad'])) {
// 	echo $showad;
// }

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

    <h2 class="py-4">Viral Banners</h2>

    <p class="pb-4">Depending on their membership level, members can add their banners to both their own and their referrals' Viral Banner Pages.</p>

    <h2 class="pb-4">Viral Banner Settings</h2>

    <p class="pb-4">Every member has a Viral Banner Page that has 14 slots for banners. You can check which slots members or their sponsors can add their banners to here.<br />If a banner has no check for any membership level, it will be a paid banner rotator.</p>

    <form action="/admin/viralbanners" method="post" class="form" role="form">
        <div id="viralbannerpanel" class="viralbannerpanel mt-3" role="tablist" aria-multiselectable="true">

                <div class="mb-4">
                    <h5 class="viralbanner-heading" role="tab" id="headingfree">
                        <a data-toggle="collapse" data-parent="#viralbannerpanel" href="#collapsefree" aria-expanded="true" aria-controls="collapsefree" class="d-block collapsed">
                            <i class="fa fa-chevron-down"></i> Free Member Viral Banner Page Settings
                        </a>
                    </h5>
                    <div id="collapsefree" class="collapse" role="tabpanel" aria-labelledby="headingfree">
                        <div class="viralbanner-body px-5">
                            <div>
                                <label for="freebannerclickstosignup" class="mt-4">Member banners a new Free member has to click to signup:</label>
                                <input type="number" min="0" step="1" name="freebannerclickstosignup" value="<?php echo $freebannerclickstosignup ?>" class="form-control smallselect" required>
                            </div>
                            <label class="mt-2">Banner slots included with Free membership:</label>
                            <div class="bannerslot-checkboxes mb-3" style="display: flex;">
                            <?php
                            for ($i = 1; $i <= 14; $i += 3) {
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
                                            <label class="form-check-label" for="freebannerslots[<?php echo $j ?>]">Slot <?php echo $j ?></label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                            </div>
                            <?php
                                echo "<div class=\"blackstrong\">Free Members: Banner Slots on Free Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Free", "Free", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Free", "Free", $settings);
                                }

                                echo "<div class=\"blackstrong\">Free Members: Banner Slots on Pro Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Free", "Pro", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Free", "Pro", $settings);
                                }

                                echo "<div class=\"blackstrong\">Free Members: Banner Slots on Gold Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Free", "Gold", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Free", "Gold", $settings);
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="viralbanner-heading" role="tab" id="headingpro">
                        <a data-toggle="collapse" data-parent="#viralbannerpanel" href="#collapsepro" aria-expanded="true" aria-controls="collapsepro" class="d-block collapsed">
                            <i class="fa fa-chevron-down"></i> Pro Member Viral Banner Page Settings
                        </a>
                    </h5>
                    <div id="collapsepro" class="collapse" role="tabpanel" aria-labelledby="headingpro">
                        <div class="viralbanner-body px-5">
                            <div>
                                <label for="probannerclickstosignup" class="mt-4">Member banners a new Pro member has to click to signup:</label>
                                <input type="number" min="0" step="1" name="probannerclickstosignup" value="<?php echo $probannerclickstosignup ?>" class="form-control smallselect" required>
                            </div>

                            <label class="mt-2">Banner slots included with Pro membership:</label>
                            <div class="bannerslot-checkboxes mb-3" style="display: flex;">
                            <?php
                            for ($i = 1; $i <= 14; $i += 3) {
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
                                            <label class="form-check-label" for="probannerslots[<?php echo $j ?>]">Slot <?php echo $j ?></label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                            </div>
                            <?php
                                echo "<div class=\"blackstrong\">Pro Members: Banner Slots on Free Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Pro", "Free", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Pro", "Free", $settings);
                                }

                                echo "<div class=\"blackstrong\">Pro Members: Banner Slots on Pro Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Pro", "Pro", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Pro", "Pro", $settings);
                                }

                                echo "<div class=\"blackstrong\">Pro Members: Banner Slots on Gold Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Pro", "Gold", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Pro", "Gold", $settings);
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="viralbanner-heading" role="tab" id="headinggold">
                        <a data-toggle="collapse" data-parent="#viralbannerpanel" href="#collapsegold" aria-expanded="true" aria-controls="collapsegold" class="d-block collapsed">
                            <i class="fa fa-chevron-down"></i> Gold Member Viral Banner Page Settings
                        </a>
                    </h5>
                    <div id="collapsegold" class="collapse" role="tabpanel" aria-labelledby="headinggold">
                        <div class="viralbanner-body px-5">
                            <div>
                                <label for="goldbannerclickstosignup" class="mt-4">Member banners a new Gold member has to click to signup:</label>
                                <input type="number" min="0" step="1" name="goldbannerclickstosignup" value="<?php echo $goldbannerclickstosignup ?>" class="form-control smallselect" required>
                            </div>
                            <label class="mt-2">Banner slots included with Gold membership:</label>
                            <div class="bannerslot-checkboxes mb-3" style="display: flex;">
                            <?php
                            for ($i = 1; $i <= 14; $i += 3) {
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
                                            <label class="form-check-label" for="goldbannerslots[<?php echo $j ?>]">Slot <?php echo $j ?></label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                            </div>
                            <?php
                                echo "<div class=\"blackstrong\">Gold Members: Banner Slots on Free Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Gold", "Free", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Gold", "Free", $settings);
                                }

                                echo "<div class=\"blackstrong\">Gold Members: Banner Slots on Pro Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Gold", "Pro", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Gold", "Pro", $settings);
                                }

                                echo "<div class=\"blackstrong\">Gold Members: Banner Slots on Gold Referral Pages</div>";
                                echo $banner->buildFormFieldsForAdminSettingsBonusSlots("Gold", "Gold", $settings);
                                for ($k = 1; $k <= 6; $k++) {
                                    echo $banner->buildFormFieldsForAdminSettingsSlots($k, "Gold", "Gold", $settings);
                                }
                            ?>
                        </div>
                    </div>
                </div>

            <div class="mb-2"></div>

            <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
            <button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="saveadsettings">SAVE SETTINGS</button>

        </div>
    </form>


    <h2 class="my-4">Default Admin Viral Banners</h2>

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
                $selected = "";
				if (isset($_POST['username'])) {
					if ($_POST['username'] === $username) {
						$selected = " selected";
					}
				}
                ?>
                <option value="<?php echo $username ?>"<?php echo $selected; ?>><?php echo $username ?></options>
                <?php
                }
                ?>
        </select>

        <label for="bannerpageslot">Viral Banner Slot:</label>
        <select name="bannerpageslot" class="form-control widetableselect">
            <?php
            for ($i = 1; $i <= 14; $i++) {
                $selected = "";
				if (isset($_POST['bannerpageslot'])) {
					if ($_POST['bannerpageslot'] === $i) {
						$selected = " selected";
					}
				}
                ?>
                <option value="<?php echo $i ?>"<?php echo $selected; ?>>
                    <?php echo $i ?>
                </option>
                <?php
            }
            ?>
        </select>

		<label for="name">Name of Ad:</label>
		<input type="text" name="name" id="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"]: ''; ?>" class="form-control input-lg" placeholder="Name" required>

		<label for="title">Alt Text:</label>
		<input type="text" name="alt" id="alt" value="<?php echo isset($_POST["alt"]) ? $_POST["alt"]: ''; ?>" class="form-control input-lg" placeholder="Alt Text" required>

		<label for="url">Click-Thru URL:</label>
		<input type="url" name="url" id="url" value="<?php echo isset($_POST["url"]) ? $_POST["url"]: ''; ?>" class="form-control input-lg" placeholder="Click-Thru URL" required>

		<label for="imageurl">Image URL: (slots 1-8 are 728 x 90 only, and slots 9-12 are 468 x 60 only)</label>
		<input type="url" name="imageurl" id="imageurl" value="<?php echo isset($_POST["imageurl"]) ? $_POST["imageurl"]: ''; ?>" class="form-control input-lg" placeholder="Image URL" required>

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

                $adminbanner = $banner->showBanner($adminshowbanner, 728, 90, $i, 'adminarea');
                echo $adminbanner;

            } else {

                // Show blank banner for this position with fields for the admin to add one.
                echo '<div class="large-banner-image placeholder">NOT ADDED</div>';
                
            }
        }
        for ($i = 9; $i <= 14; $i++) {

            // Set up default admin 468 x 60 banners.
            $adminshowbanner = $banner->getViralBanner('admin', $i);
            if (!empty($adminshowbanner)) {

                $adminbanner = $banner->showBanner($adminshowbanner, 468, 60, $i, 'adminarea');
                echo $adminbanner;

            } else {

                // Show blank banner for this position with fields for the admin to add one.
                echo $banner->showBannerPlaceholder($i, 468, 60, 'Default Admin Banner for Viral Banner Slot ' . $i, 'adminarea');
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

<div class="admintable-wrap mt-4">
    <table id="admintable" class="table table-hover text-center table-sm">
        <thead>
            <tr>
                <th scope="col" class="text-center small">Ad&nbsp;#</th>
                <th scope="col" class="text-center small">Approved</th>
                <th scope="col" class="text-center small" style="min-width: 200px;">Image</th>
                <th scope="col" class="text-center small" style="min-width: 100px;">Username</th>
                <th scope="col" class="text-center small" style="min-width: 100px;">Banner&nbsp;Slot</th>
                <th scope="col" class="text-center small" style="min-width: 100px;">Name</th>
                <th scope="col" class="text-center small" style="min-width: 100px;">Alt</th>
                <th scope="col" class="text-center small" style="min-width: 200px;">Click-Thru&nbsp;URL</th>
                <th scope="col" class="text-center small">Short&nbsp;URL</th>
                <th scope="col" class="text-center small" style="min-width: 200px;">Image&nbsp;URL</th>
                <th scope="col" class="text-center small">Impressions</th>
                <th scope="col" class="text-center small">Clicks</th>
                <th scope="col" class="text-center small" style="min-width: 150px;">Date</th>
                <th scope="col" class="text-center small">Save</th>
                <th scope="col" class="text-center small">Delete</th>
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
                                    <div class="mini-banner-image placeholder">NOT ADDED</div>
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
                                    for ($i = 1; $i <= 14; $i++) {
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
                                <input type="hidden" name="added" value="<?php echo $ad['added']; ?>">
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

