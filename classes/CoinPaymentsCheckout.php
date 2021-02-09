<?php
error_reporting(E_ALL);
/**
Coinpayments.net payment module.
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

class CoinPaymentsCheckout extends PaymentGateway
{
    protected
        $api,
        $user,
        $paymentdata,
        $postdata,
        $paybutton,
        $usernamefieldforads,
        $payperiod,
        $payintervalcode,
        $formfields,
        $isexistinguser,
        $transaction;

    public function __construct(array $paymentdata = [], User $user, array $postdata = [], array $settings = [], CoinPaymentsAPI $api = null)
    {
        if ($api !== null) {
            $this->api = $api;
        }
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

        if ($this->itemname === "Pro Membership" || $this->itemname === "Gold Membership") {
            $usernamefieldforads = "";
        } else {
            $usernamefieldforads = '<input type="hidden" id="usernamefieldforads" value="' . $this->username . '">';
        }

        // TODO: IMPORTANT - Coinpayments does not have automatic subscriptions!! Need to keep track of when next payment is due for users and send invoice every time.
        $paybutton = '
            <form method="post" id="coinpaymentsbuttonform" action="https://www.coinpayments.net/index.php" accept-charset="UTF-8" class="form-horizontal form-page-small">'
            . $usernamefieldforads .
            '<input type="hidden" name="cmd" value="_pay_simple">
            <input type="hidden" name="reset" value="1">
            <input type="hidden" name="merchant" value="' . $this->settings['admincoinpayments'] . '">
            <input type="hidden" name="item_name" value="' . $this->settings['sitename'] . ' - ' . $this->itemname . '">
            <input type="hidden" name="currency" value="USD">
            <input type="hidden" name="currency1" value="USD">
            <input type="hidden" name="amountf" value="' . $this->price . '">
            <input type="hidden" name="want_shipping" value="0">
            <input type="hidden" name="success_url" value="' . $this->settings['domain'] . '/thankyou">
            <input type="hidden" name="cancel_url" value="' . $this->settings['domain'] . '">
            <input type="hidden" name="ipn_url" value="' . $this->settings['domain'] . '/ipn/coinpayments">
            <input type="hidden" name="invoice" value="">
            <input type="hidden" name="custom" id="pendingId" value="">
            <button class="btn btn-lg btn-primary" type="button" name="coinpaymentsbutton" id="coinpaymentsbutton">
            Buy ' . $this->itemname . ' for $' . $this->price . ' with CoinPayments!</button>
            </form>';

        return $paybutton;
    }

    public function getIPN(Commission $commission, Money $money): void
    {
        $this->_ipn($commission, $money);
    }

    protected function _ipn(Commission $commission, Money $money): void
    {

        if (empty($this->api)) {
            exit;
        }

        $admincoinpaymentspublickey = $this->settings['admincoinpaymentspublickey'];
        $admincoinpaymentsprivatekey = $this->settings['admincoinpaymentsprivatekey'];
        $this->api->Setup($admincoinpaymentsprivatekey, $admincoinpaymentspublickey);

        if ($_POST['ipn_mode'] === 'hmac') {

            $cp_merchant_id = $this->settings['admincoinpaymentsapikey'];
            $cp_ipn_secret = $this->settings['admincoinpaymentsapisecret'];
            $order_currency = 'USD';
            $adminemail = $this->settings['adminemail'];

            function errorAndDie(string $error_msg, string $cp_debug_email)
            {
                $report = 'Error: ' . $error_msg . "\n\n";
                $report .= "POST Data\n\n";
                foreach ($_POST as $k => $v) {
                    $report .= "|$k| = |$v|\n";
                    // mail($cp_debug_email, 'CoinPayments IPN Error', $report);
                }
                die('IPN Error: ' . $error_msg);
            }

            if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] !== 'hmac') {
                errorAndDie('IPN Mode is not HMAC', $adminemail);
            }

            if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
                errorAndDie('No HMAC signature sent.', $adminemail);
            }

            // Get the posted variables.
            $request = file_get_contents('php://input');
            if ($request === FALSE || empty($request)) {
                errorAndDie('Error reading POST data', $adminemail);
            }

            if (!isset($_POST['merchant']) || $_POST['merchant'] !== trim($cp_merchant_id)) {
                errorAndDie('No or incorrect Merchant ID passed', $adminemail);
            }

            $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
            if ($hmac !== $_SERVER['HTTP_HMAC']) {
                errorAndDie('HMAC signature does not match', $adminemail);
            }

            // HMAC Signature verified at this point, load some variables. 

            $txn_id = $_POST['txn_id'];
            $item_name = $_POST['item_name'];
            $currency1 = $_POST['currency1']; // Seller's chosen currency/coin.
            $currency2 = $_POST['currency2']; // Buyer's chosen currency/coin.
            $amount1 = floatval($_POST['amount1']); // Total payment in seller's chosen currency/coin.
            $amount2 = floatval($_POST['amount2']); // Total payment in buyer's chosen currency/coin.
            $status = (int)$_POST['status'];
            $pendingId = (int)$_POST['custom'];

            // Check the original currency to make sure the buyer didn't change it.
            if ($currency1 != $order_currency) {
                errorAndDie('Original currency mismatch!', $adminemail);
            }

            // Successful payment:
            if ($status >= 100) {

                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Get buyer info from pendingpurchases table with pendingId returned by Coinpayments.net:
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
                    // Temporary purchase ID not found?
                    exit;
                }

                // User purchased pro or gold paid membership. Commission and transaction done in User class.
                if ($item_name === $this->settings['sitename'] . ' - Pro Membership') {

                    // Check if buyer is an existing user (need to know if it is a new signup or an existing member upgrading)
                    $sql = "select * from members where username=?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($username));
                    $isexistinguser = $q->rowCount();

                    // Check amount against order total
                    if ($amount1 < $this->settings['proprice']) {
                        errorAndDie('Amount is less than order total!', $adminemail);
                    }

                    if ($isexistinguser < 1) {
                        $this->user->newSignup($this->settings, $formfields, 'Pro', $commission);
                    } else {
                        $this->user->upgradeUser($this->settings, $username, $referid, 'Pro', $commission);
                    }

                    // commission
                    $commission->addNewReferralCommission($referid, 'Pro');
                }

                if ($item_name === $this->settings['sitename'] . ' - Gold Membership') {

                    // Check if buyer is an existing user (need to know if it is a new signup or an existing member upgrading)
                    $sql = "select * from members where username=?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($username));
                    $isexistinguser = $q->rowCount();

                    // Check amount against order total
                    if ($amount1 < $this->settings['goldprice']) {
                        errorAndDie('Amount is less than order total!', $adminemail);
                    }

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
                    $create = new Ad($adtable);
                    $create->createAd(0, $this->settings['adminautoapprove'], 'ipn', [$username]);
                }

                // User purchased network solo.
                if ($item_name === $this->settings['sitename'] . ' - Network Solo') {
                    $adtable = "networksolos";
                    $create = new Ad($adtable);
                    $create->createAd(0, $this->settings['adminautoapprove'], 'ipn', [$username]);
                }

                // User purchased network banner.
                if ($item_name === $this->settings['sitename'] . ' - Banner') {
                    $adtable = "banners";
                    $create = new Ad($adtable);
                    $create->createAd(0, $this->settings['adminautoapprove'], 'ipn', [$username]);
                }

                // Add transaction record.
                $transaction = [
                    "item" => $item_name,
                    "username" => $username,
                    "amount" => $amount1,
                    "datepaid" => date("M d, Y"),
                    "paymethod" => "Coinpayments",
                    "transaction" => $txn_id
                ];
                $money->addTransaction($transaction);

                Database::disconnect();
            }
        }
    }
}
