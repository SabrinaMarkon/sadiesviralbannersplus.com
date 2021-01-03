<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require "control.php";
if (isset($show)) {
    echo $show;
}
$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
    $$key = $value;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h1 class="ja-bottompadding">Site Settings</h1>

            <form action="/admin/settings" method="post" accept-charset="utf-8" class="form" role="form">

                <label for="adminuser">Admin Username:</label>
                <input type="text" name="adminuser" value="<?php echo $adminuser ?>" class="form-control input-lg" placeholder="Admin Username" maxlength="50" required>

                <label for="adminpass" class="ja-toppadding">Admin Password:</label>
                <input type="password" name="adminpass" id="adminpass" value="<?php echo $adminpass ?>" class="form-control input-lg" placeholder="Admin Password" maxlength="50" required>

                <label for="confirm_adminpass" class="ja-toppadding">Confirm Password:</label>
                <input type="password" name="confirm_adminpass" id="confirm_adminpass" value="<?php echo $adminpass ?>" class="form-control input-lg" placeholder="Confirm Password" maxlength="50" required>

                <label for="adminname" class="ja-toppadding">Admin Name:</label>
                <input type="text" name="adminname" value="<?php echo $adminname ?>" class="form-control input-lg" placeholder="Admin Name" maxlength="50" required>

                <label for="adminemail" class="ja-toppadding">Your Admin Email:</label>
                <input type="text" name="adminemail" value="<?php echo $adminemail ?>" class="form-control input-lg" placeholder="Admin Email" maxlength="300" required>

                <label for="adminpaypal" class="ja-toppadding">Your Paypal Email:</label>
                <input type="text" name="adminpaypal" value="<?php echo $adminpaypal ?>" class="form-control input-lg" placeholder="Paypal Email" maxlength="300">

                <label for="sitename" class="ja-toppadding">Your Website Name:</label>
                <input type="text" name="sitename" value="<?php echo $sitename ?>" class="form-control input-lg" placeholder="Website Name" maxlength="50" required>

                <label for="domain" class="ja-toppadding">Your Domain:</label>
                <input type="url" name="domain" value="<?php echo $domain ?>" class="form-control input-lg" placeholder="Website URL (start with http://)" maxlength="300" required>

                <label for="metatitle" class="ja-toppadding">SEO: Meta Title:</label>
                <input type="text" name="metatitle" value="<?php echo $metatitle ?>" class="form-control input-lg" placeholder="SEO meta title for search engines"  maxlength="60" required>

                <label for="metadescription" class="ja-toppadding">SEO: Meta Description:</label>
                <input type="text" name="metadescription" value="<?php echo $metadescription ?>" class="form-control input-lg" placeholder="SEO meta description for search engines"  maxlength="160" required>

                <div>
                    <label for="adminautoapprove" class="ja-toppadding">Auto-approve Ads:</label>
                    <select name="adminautoapprove" class="form-control smallselect">
                        <option value="1" <?php if (intval($adminautoapprove) === 1) {
                                                echo "selected";
                                            } ?>>Yes</option>
                        <option value="0" <?php if (intval($adminautoapprove) !== 1) {
                                                echo "selected";
                                            } ?>>No</option>
                    </select>
                </div>

                <label for="adclickstogetad" class="ja-toppadding">Click How Many Ads to get another Free Ad:</label>
                $&nbsp;<input type="number" min="1" step="1" name="adclickstogetad" value="<?php echo $adclickstogetad ?>" class="form-control smallselect" required>

                <div class="ja-bottompadding"></div>

                <button class="btn btn-lg btn-primary" type="submit" name="savesettings">Save Settings</button>

            </form>

            <div class="ja-bottompadding"></div>

        </div>
    </div>
</div>