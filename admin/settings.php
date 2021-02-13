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

                <label for="admincoinpayments" class="ja-toppadding">Your CoinPayments Merchant ID:</label>
                <input type="text" name="admincoinpayments" value="<?php echo $admincoinpayments ?>" class="form-control input-lg" placeholder="CoinPayments Merchant ID" maxlength="300">

                <label for="sitename" class="ja-toppadding">Your Website Name:</label>
                <input type="text" name="sitename" value="<?php echo $sitename ?>" class="form-control input-lg" placeholder="Website Name" maxlength="50" required>

                <label for="domain" class="ja-toppadding">Your Domain:</label>
                <input type="url" name="domain" value="<?php echo $domain ?>" class="form-control input-lg" placeholder="Website URL (start with http://)" maxlength="300" required>

                <label for="metatitle" class="ja-toppadding">SEO: Meta Title:</label>
                <input type="text" name="metatitle" value="<?php echo $metatitle ?>" class="form-control input-lg" placeholder="SEO meta title for search engines" maxlength="60" required>

                <label for="metadescription" class="ja-toppadding">SEO: Meta Description:</label>
                <input type="text" name="metadescription" value="<?php echo $metadescription ?>" class="form-control input-lg" placeholder="SEO meta description for search engines" maxlength="160" required>

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

                <br /><br />
                <h1>Basic Settings for Free Members</h1>

                <label for="freerefersproearn" class="ja-toppadding">Commission when Free members sponsor a Pro member:</label>
                <input type="text" name="freerefersproearn" value="<?php echo $freerefersproearn ?>" class="form-control input-lg" placeholder="Commission when Free members sponsor a Pro member" maxlength="8" required>
                
                <label for="freerefersgoldearn" class="ja-toppadding">Commission when Free members sponsor a Gold member:</label>
                <input type="text" name="freerefersgoldearn" value="<?php echo $freerefersgoldearn ?>" class="form-control input-lg" placeholder="Commission when Free members sponsor a Gold member" maxlength="8" required>
                
                <label for="freeadclickstogettextad" class="ja-toppadding">Clicks on Text Ads for a Free member to get a Free Text Ad (0 to disable):</label>
                <input type="number" min="0" step="1" name="freeadclickstogettextad" value="<?php echo $freeadclickstogettextad ?>" class="form-control smallselect" required>
                
                <label for="freeadclickstogetbannerspaid" class="ja-toppadding">Clicks on Banners for a Free member to get a Free Banner (0 to disable):</label>
                <input type="number" min="0" step="1" name="freeadclickstogetbannerspaid" value="<?php echo $freeadclickstogetbannerspaid ?>" class="form-control smallselect" required>
                
                <label for="freeadclickstogetnetworksolo" class="ja-toppadding">Clicks on Network Solo links for a Free member to get a Free Network Solo (0 to disable):</label>
                <input type="number" min="0" step="1" name="freeadclickstogetnetworksolo" value="<?php echo $freeadclickstogetnetworksolo ?>" class="form-control smallselect" required>

                <br /><br />
                <h1>Basic Settings for Pro Members</h1>

                <label for="proprice" class="ja-toppadding">Price for Pro Membership:</label>
                <input type="text" name="proprice" value="<?php echo $proprice ?>" class="form-control input-lg" placeholder="Price for Pro Membership" maxlength="8" required>

                <div>
                    <label for="propayinterval" class="ja-toppadding">Pay Interval for Pro Membership:</label>
                    <select name="propayinterval" class="form-control input-lg">
                        <option value="lifetime" <?php if ($propayinterval === "lifetime") {
                                                        echo "selected";
                                                    } ?>>Lifetime</option>
                        <option value="monthly" <?php if ($propayinterval === "monthly") {
                                                    echo "selected";
                                                } ?>>Monthly</option>
                        <option value="annually" <?php if ($propayinterval === "annually") {
                                                        echo "selected";
                                                    } ?>>Annually</option>
                    </select>
                </div>

                <label for="prorefersproearn" class="ja-toppadding">Commission when Pro members sponsor a Pro member:</label>
                <input type="text" name="prorefersproearn" value="<?php echo $prorefersproearn ?>" class="form-control input-lg" placeholder="Commission when Pro members sponsor a Pro member" maxlength="8" required>
                
                <label for="prorefersgoldearn" class="ja-toppadding">Commission when Pro members sponsor a Gold member:</label>
                <input type="text" name="prorefersgoldearn" value="<?php echo $prorefersgoldearn ?>" class="form-control input-lg" placeholder="Commission when Pro members sponsor a Gold member" maxlength="8" required>

                <label for="proadclickstogettextad" class="ja-toppadding">Clicks on Text Ads for a Pro member to get a Free Text Ad (0 to disable):</label>
                <input type="number" min="0" step="1" name="proadclickstogettextad" value="<?php echo $proadclickstogettextad ?>" class="form-control smallselect" required>
                
                <label for="proadclickstogetbannerspaid" class="ja-toppadding">Clicks on Banners for a Pro member to get a Free Banner (0 to disable):</label>
                <input type="number" min="0" step="1" name="proadclickstogetbannerspaid" value="<?php echo $proadclickstogetbannerspaid ?>" class="form-control smallselect" required>
                
                <label for="proadclickstogetnetworksolo" class="ja-toppadding">Clicks on Network Solo links for a Pro member to get a Free Network Solo (0 to disable):</label>
                <input type="number" min="0" step="1" name="proadclickstogetnetworksolo" value="<?php echo $proadclickstogetnetworksolo ?>" class="form-control smallselect" required>

                <br /><br />
                <h1>Basic Settings for Gold Members</h1>

                <label for="goldprice" class="ja-toppadding">Price for Gold Membership:</label>
                <input type="text" name="goldprice" value="<?php echo $goldprice ?>" class="form-control input-lg" placeholder="Price for Gold Membership" maxlength="8" required>

                <div>
                    <label for="goldpayinterval" class="ja-toppadding">Pay Interval for Gold Membership:</label>
                    <select name="goldpayinterval" class="form-control input-lg">
                        <option value="lifetime" <?php if ($goldpayinterval === "lifetime") {
                                                        echo "selected";
                                                    } ?>>Lifetime</option>
                        <option value="monthly" <?php if ($goldpayinterval === "monthly") {
                                                    echo "selected";
                                                } ?>>Monthly</option>
                        <option value="annually" <?php if ($goldpayinterval === "annually") {
                                                        echo "selected";
                                                    } ?>>Annually</option>
                    </select>
                </div>

                <label for="goldrefersproearn" class="ja-toppadding">Commission when Gold members sponsor a Pro member:</label>
                <input type="text" name="goldrefersproearn" value="<?php echo $goldrefersproearn ?>" class="form-control input-lg" placeholder="Commission when Gold members sponsor a Pro member" maxlength="8" required>
                
                <label for="goldrefersgoldearn" class="ja-toppadding">Commission when Gold members sponsor a Gold member:</label>
                <input type="text" name="goldrefersgoldearn" value="<?php echo $goldrefersgoldearn ?>" class="form-control input-lg" placeholder="Commission when Gold members sponsor a Gold member" maxlength="8" required>

                <label for="goldadclickstogettextad" class="ja-toppadding">Clicks on Text Ads for a Gold member to get a Free Text Ad (0 to disable):</label>
                <input type="number" min="0" step="1" name="goldadclickstogettextad" value="<?php echo $goldadclickstogettextad ?>" class="form-control smallselect" required>
                
                <label for="goldadclickstogetbannerspaid" class="ja-toppadding">Clicks on Banners for a Gold member to get a Free Banner (0 to disable):</label>
                <input type="number" min="0" step="1" name="goldadclickstogetbannerspaid" value="<?php echo $goldadclickstogetbannerspaid ?>" class="form-control smallselect" required>
                
                <label for="goldadclickstogetnetworksolo" class="ja-toppadding">Clicks on Network Solo links for a Gold member to get a Free Network Solo (0 to disable):</label>
                <input type="number" min="0" step="1" name="goldadclickstogetnetworksolo" value="<?php echo $goldadclickstogetnetworksolo ?>" class="form-control smallselect" required>

                <br /><br />
                <h1>Sign Up Bonuses</h1>

                <label for="freesignupbonustextads" class="ja-toppadding">Free Text Ads a Free member gets as a sign up bonus :</label>
                <input type="number" min="0" step="1" name="freesignupbonustextads" value="<?php echo $freesignupbonustextads ?>" class="form-control smallselect" required>
                <label for="freesignupbonusbannerspaid" class="ja-toppadding">Free Banners a Free member gets as a sign up bonus :</label>
                <input type="number" min="0" step="1" name="freesignupbonusbannerspaid" value="<?php echo $freesignupbonusbannerspaid ?>" class="form-control smallselect" required>
                <label for="freesignupbonusnetworksolos" class="ja-toppadding">Free Network Solos a Free member gets as a sign up bonus :</label>
                <input type="number" min="0" step="1" name="freesignupbonusnetworksolos" value="<?php echo $freesignupbonusnetworksolos ?>" class="form-control smallselect" required>

                <label for="prosignupbonustextads" class="ja-toppadding">Free Text Ads a Pro member gets as a sign up bonus :</label>
                <input type="number" min="0" step="1" name="prosignupbonustextads" value="<?php echo $prosignupbonustextads ?>" class="form-control smallselect" required>
                <label for="prosignupbonusbannerspaid" class="ja-toppadding">Free Banners a Pro member gets as a sign up bonus :</label>
                <input type="number" min="0" step="1" name="prosignupbonusbannerspaid" value="<?php echo $prosignupbonusbannerspaid ?>" class="form-control smallselect" required>
                <label for="prosignupbonusnetworksolos" class="ja-toppadding">Free Network Solos a Pro member gets as a sign up bonus :</label>
                <input type="number" min="0" step="1" name="prosignupbonusnetworksolos" value="<?php echo $prosignupbonusnetworksolos ?>" class="form-control smallselect" required>

                <label for="goldsignupbonustextads" class="ja-toppadding">Free Text Ads a Gold member gets as a sign up bonus :</label>
                <input type="number" min="0" step="1" name="goldsignupbonustextads" value="<?php echo $goldsignupbonustextads ?>" class="form-control smallselect" required>
                <label for="goldsignupbonusbannerspaid" class="ja-toppadding">Free Banners a Gold member gets as a sign up bonus :</label>
                <input type="number" min="0" step="1" name="goldsignupbonusbannerspaid" value="<?php echo $goldsignupbonusbannerspaid ?>" class="form-control smallselect" required>
                <label for="goldsignupbonusnetworksolos" class="ja-toppadding">Free Network Solos a Gold member as for a sign up bonus :</label>
                <input type="number" min="0" step="1" name="goldsignupbonusnetworksolos" value="<?php echo $goldsignupbonusnetworksolos ?>" class="form-control smallselect" required>

                <br /><br />
                <h1>Monthly Bonuses</h1>

                <label for="freemonthlybonustextads" class="ja-toppadding">Free Text Ads a Free member gets as a monthly bonus :</label>
                <input type="number" min="0" step="1" name="freemonthlybonustextads" value="<?php echo $freemonthlybonustextads ?>" class="form-control smallselect" required>
                <label for="freemonthlybonusbannerspaid" class="ja-toppadding">Free Banners a Free member gets as a monthly bonus :</label>
                <input type="number" min="0" step="1" name="freemonthlybonusbannerspaid" value="<?php echo $freemonthlybonusbannerspaid ?>" class="form-control smallselect" required>
                <label for="freemonthlybonusnetworksolos" class="ja-toppadding">Free Network Solos a Free member gets as a monthly bonus :</label>
                <input type="number" min="0" step="1" name="freemonthlybonusnetworksolos" value="<?php echo $freemonthlybonusnetworksolos ?>" class="form-control smallselect" required>

                <label for="promonthlybonustextads" class="ja-toppadding">Free Text Ads a Pro member gets as a monthly bonus :</label>
                <input type="number" min="0" step="1" name="promonthlybonustextads" value="<?php echo $promonthlybonustextads ?>" class="form-control smallselect" required>
                <label for="promonthlybonusbannerspaid" class="ja-toppadding">Free Banners a Pro member gets as a monthly bonus :</label>
                <input type="number" min="0" step="1" name="promonthlybonusbannerspaid" value="<?php echo $promonthlybonusbannerspaid ?>" class="form-control smallselect" required>
                <label for="promonthlybonusnetworksolos" class="ja-toppadding">Free Network Solos a Pro member gets as a monthly bonus :</label>
                <input type="number" min="0" step="1" name="promonthlybonusnetworksolos" value="<?php echo $promonthlybonusnetworksolos ?>" class="form-control smallselect" required>

                <label for="goldmonthlybonustextads" class="ja-toppadding">Free Text Ads a Gold member gets as a monthly bonus :</label>
                <input type="number" min="0" step="1" name="goldmonthlybonustextads" value="<?php echo $goldmonthlybonustextads ?>" class="form-control smallselect" required>
                <label for="goldmonthlybonusbannerspaid" class="ja-toppadding">Free Banners a Gold member gets as a monthly bonus :</label>
                <input type="number" min="0" step="1" name="goldmonthlybonusbannerspaid" value="<?php echo $goldmonthlybonusbannerspaid ?>" class="form-control smallselect" required>
                <label for="goldmonthlybonusnetworksolos" class="ja-toppadding">Free Network Solos a Gold member as for a monthly bonus :</label>
                <input type="number" min="0" step="1" name="goldmonthlybonusnetworksolos" value="<?php echo $goldmonthlybonusnetworksolos ?>" class="form-control smallselect" required>

                <div class="ja-bottompadding"></div>

                <button class="btn btn-lg btn-primary" type="submit" name="savesettings">Save Settings</button>

            </form>

            <div class="ja-bottompadding"></div>

        </div>
    </div>
</div>