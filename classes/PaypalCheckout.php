<?php
error_reporting(E_ALL);
/**
Paypal payments module.
PHP 7.4+
@author Sabrina Markon
@copyright 2020 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
// if (count(get_included_files()) === 1) { exit('Direct Access is not Permitted'); }
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
        $paybutton,
        $payperiod,
        $payintervalcode;

    public function __construct(array $paymentdata, User $user)
    {
        $this->user = $user;
        $this->itemname = $paymentdata['itemname'];
        $this->price = $paymentdata['price'];
        $this->payinterval = $paymentdata['payinterval'];
        $this->adminemail = $paymentdata['adminemail'];
        $this->sitename = $paymentdata['sitename'];
        $this->domain = $paymentdata['domain'];
        $this->username = $paymentdata['username'];
        $this->referid = $paymentdata['referid'];
    }

    public function getPayButton()
    {
        return $this->_payButton();
    }

    protected function _payButton()
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

        $paybutton = '
            <form method="POST" id="paypalbuttonform" action="https://www.paypal.com/cgi-bin/webscr" accept-charset="UTF-8" class="form-horizontal form-page-small">'
            . $payintervalcode .
            '<input name="business" type="hidden" value="' . $this->adminemail . '">
            <input name="item_name" type="hidden" value="' . $this->sitename . ' - ' . $this->itemname . '">
            <input name="no_note" type="hidden" value="1">
            <input name="page_style" type="hidden" value="PayPal">
            <input name="no_shipping" type="hidden" value="1">
            <input name="return" type="hidden" value="' . $this->domain . '/thankyou">
            <input name="cancel" type="hidden" value="' . $this->domain . '">
            <input name="currency_code" type="hidden" value="USD">
            <input name="lc" type="hidden" value="US">
            <input name="bn" type="hidden" value="PP-BuyNowBF">
            <input name="on0" type="hidden" value="Purchase ID">
            <input name="os0" id="pendingId" type="hidden" value="">
            <input name="notify_url" type="hidden" value="' . $this->domain . '/ipn">
            <button class="btn btn-lg btn-primary" type="button" name="paypalbutton" id="paypalbutton">
            Buy ' . $this->itemname . ' for $' . $this->price . ' with Paypal!</button>
            </form>';
        return $paybutton;
    }

    protected function _ipn()
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

            $payment_status = $_POST['payment_status'];
            $amount = $_POST['mc_gross'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id = $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $paypal = $_POST['payer_email'];
            $quantity = $_POST['quantity'];
            $pendingId = $_POST['option_selection1'];
            $item_name = $_POST['item_name'];

            if ($payment_status === "Completed") {

                // Get buyer info from pendingpurchases table with pendingId returned by Paypal:
                
                // User purchased pro or gold paid membership.
                if ($item_name === 'Pro Membership') {

                    // commission:
                }
                if ($item_name === 'Gold Membership') {

                    // commission:
                }

                // User purchased text ad.
                if ($item_name === 'Text Ad') {
                }

                // User purchased network solo.
                if ($item_name === 'Network Solo') {
                }

                // User purchased network banner.
                if ($item_name === 'Network Banner') {
                }
            } else {
                // Status is NOT completed. Cancellation of subscription?
            }
        } else if (strcmp($res, "INVALID") == 0) {
            echo "INVALID TRANSACTION";
            exit;
        }
    }
}
