<?php
error_reporting(E_ALL);
/**
Paypal payment module.
PHP 7.4+
@author Sabrina Markon
@copyright 2020 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

class PaypalCheckout extends PaymentGateway
{
    protected
        $user,
        $paymentdata,
        $postdata,
        $paybutton,
        $usernamefieldforads,
        $payperiod,
        $payintervalcode,
        $formfields,
        $isexistinguser,
        $transaction,
        $error_msg,
        $adminemail;

    public function __construct(array $paymentdata = [], User $user, array $postdata = [], array $settings = [])
    {

        $this->user = $user;
        $this->settings = $settings;
        $this->postdata = $postdata;

        if (sizeof($paymentdata) > 0) {
            $this->itemname = $paymentdata['itemname'];
            $this->price = $paymentdata['price'];
            $this->payinterval = $paymentdata['payinterval'];
            $this->username = $paymentdata['username'];
            $this->referid = $paymentdata['referid'];
        }
    }

    public function getPayButton(): string
    {
        return $this->_payButton();
    }

    protected function _payButton(): string
    {
        if ($this->payinterval === 'monthly' || $this->payinterval === 'annually') {

            if ($this->payinterval === 'monthly') {
                $payperiod = 'M';
            } else {
                $payperiod = 'Y';
            }
            $payintervalcode = '
            <input name="a3" type="hidden" value="' . $this->price . '">
            <input name="cmd" type="hidden" value="_xclick-subscriptions">
            <input name="p3" type="hidden" value="1">
            <input name="t3" type="hidden" value="' . $payperiod . '">
            <input name="src" type="hidden" value="1">
            <input name="sra" type="hidden" value="1">';
        } else {
            $payintervalcode = '
            <input name="amount" type="hidden" value="' . $this->price . '">
            <input name="cmd" type="hidden" value="_xclick">';
        }

        if ($this->itemname === "Pro Membership" || $this->itemname === "Gold Membership") {
            $usernamefieldforads = "";
        } else {
            $usernamefieldforads = '<input type="hidden" id="paypalusernamefieldforads" value="' . $this->username . '">';
        }

        $paybutton = '
            <form method="POST" id="paypalbuttonform" action="https://www.paypal.com/cgi-bin/webscr" accept-charset="UTF-8" class="form-horizontal form-page-small">'
            . $payintervalcode .
            $usernamefieldforads .
            '<input name="business" type="hidden" value="' . $this->settings['adminpaypal'] . '">
            <input name="item_name" type="hidden" value="' . $this->settings['sitename'] . ' - ' . $this->itemname . '">
            <input name="no_note" type="hidden" value="1">
            <input name="page_style" type="hidden" value="PayPal">
            <input name="no_shipping" type="hidden" value="1">
            <input name="return" type="hidden" value="' . $this->settings['domain'] . '/thankyou">
            <input name="cancel" type="hidden" value="' . $this->settings['domain'] . '">
            <input name="currency_code" type="hidden" value="USD">
            <input name="lc" type="hidden" value="US">
            <input name="bn" type="hidden" value="PP-BuyNowBF">
            <input name="on0" type="hidden" value="Purchase ID">
            <input name="os0" id="paypalpendingId" type="hidden" value="">
            <input name="notify_url" type="hidden" value="' . $this->settings['domain'] . '/ipn/paypal">
            <button class="btn btn-lg btn-primary" type="button" name="paypalbutton" id="paypalbutton">
            Buy ' . $this->itemname . ' for $' . $this->price . ' with Paypal!</button>
            </form>';
        return $paybutton;
    }

    public function errorAndDie(string $error_msg, string $pp_debug_email): void
    {
        $report = 'Error: ' . $error_msg . "\n\n";
        $report .= "POST Data\n\n";
        foreach ($_POST as $k => $v) {
            $report .= "|$k| = |$v|\n";
            // mail($pp_debug_email, 'Paypal IPN Error', $report);
        }
        die('IPN Error: ' . $error_msg);
    }

    public function getIPN(Sponsor $commission, Money $money): void
    {
        $this->_ipn($commission, $money);
    }

    protected function _ipn(Sponsor $commission, Money $money): void
    {

        // STEP 1: Read POST data:

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // STEP 2: Post IPN data back to paypal to validate:

        $ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if (!($res = curl_exec($ch))) {
            error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        // STEP 3: Inspect IPN validation result and act accordingly

        if (strcmp($res, "VERIFIED") == 0) {
            echo "VERIFIED";

            $payment_status = $this->postdata['payment_status'];
            $amount = $this->postdata['mc_gross'];
            $payment_currency = $this->postdata['mc_currency'];
            $txn_id = $this->postdata['txn_id'];
            $receiver_email = $this->postdata['receiver_email'];
            $paypal = $this->postdata['payer_email'];
            $quantity = $this->postdata['quantity'];
            $pendingId = $this->postdata['option_selection1'];
            $item_name = $this->postdata['item_name'];

            if ($payment_status === "Completed") {

                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Get buyer info from pendingpurchases table with pendingId returned by Paypal:
                $sql = "select * from pendingpurchases where id=?";
                $q = $pdo->prepare($sql);
                $q->execute(array($pendingId));
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $data = $q->fetch();
                if (!empty($data)) {

                    $formfields = $data['formfields'];
                    $formfields = json_decode($formfields);
                    $username = $formfields['username'];
                    $referid = $formfields['referid'];
                } else {
                    // Temporary purchase ID not found.
                    exit;
                }
                // Check if buyer is an existing user (need to know if it is a new signup or an existing member upgrading)
                $sql = "select * from members where username=?";
                $q = $pdo->prepare($sql);
                $q->execute(array($username));
                $isexistinguser = $q->rowCount();

                // User purchased pro or gold paid membership. Commission and transaction done in User class.
                if ($item_name === $this->settings['sitename'] . ' - Pro Membership') {
                    if ($isexistinguser < 1) {
                        $this->user->newSignup($this->settings, $formfields, 'Pro', $commission);
                    } else {
                        $this->user->upgradeUser($this->settings, $username, $referid, 'Pro', $commission);
                    }
                    // commission
                    $commission->addNewReferralCommission($referid, 'Pro');
                }

                if ($item_name === $this->settings['sitename'] . ' - Gold Membership') {
                    if (empty($isexistinguser)) {
                        $this->user->newSignup($this->settings, $formfields, 'Gold', $commission);
                    } else {
                        $this->user->upgradeUser($this->settings, $username, $referid, 'Gold', $commission);
                    }
                    // commission
                    $commission->addNewReferralCommission($referid, 'Gold');
                }

                // User purchased text ad.
                if ($item_name === $this->settings['sitename'] . ' - Text Ad') {
                    $adtable = "textads";
                    $create = new TextAd($adtable);
                    $create->createAd(0, $this->settings['adminautoapprove'], 'ipn', [$username]);
                }

                // User purchased network solo.
                if ($item_name === $this->settings['sitename'] . ' - Network Solo') {
                    $adtable = "networksolos";
                    $create = new NetworkSolo($adtable);
                    $create->createAd(0, $this->settings['adminautoapprove'], 'ipn', [$username]);
                }

                // User purchased banner.
                if ($item_name === $this->settings['sitename'] . ' - Banner') {
                    $adtable = "bannerspaid";
                    $create = new Banner($adtable);
                    $create->createAd(0, $this->settings['adminautoapprove'], 'ipn', [$username]);
                }

                // Add transaction record.
                $transaction = [
                    "item" => $item_name,
                    "username" => $username,
                    "amount" => $amount,
                    "datepaid" => date("M d, Y"),
                    "paymethod" => "Paypal",
                    "transaction" => $txn_id
                ];
                $money->addTransaction($transaction);

                Database::disconnect();
            } else {
                // Status is NOT completed. Cancellation of subscription?
                $error_msg = "Payment/subscription failed";
                $adminemail = $this->settings['adminemail'];
                errorAndDie($error_msg, $adminemail);
                exit;
            }
        } else if (strcmp($res, "INVALID") == 0) {

            $error_msg = "Invalid Transaction";
            $adminemail = $this->settings['adminemail'];
            errorAndDie($error_msg, $adminemail);
            exit;
        }
    }
}
