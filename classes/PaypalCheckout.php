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

class PaypalCheckout
{
    private
        $paybutton,
        $paymentdata,
        $payperiod,
        $payintervalcode;

    public function __construct($paymentdata)
    {
        $this->itemname = $paymentdata->itemname;
        $this->price = $paymentdata->price;
        $this->payinterval = $paymentdata->payinterval;
        $this->adminemail = $paymentdata->adminemail;
        $this->sitename = $paymentdata->sitename;
        $this->domain = $paymentdata->domain;
        $this->buyerusername = $paymentdata->buyerusername;
    }

    private function paybutton()
    {
        if ($this->payinterval === 'monthly' || $this->payinterval === 'annually') {
            
            if ($this->payinterval === 'monthly') {
                $payperiod = 'M';
            } else {
                $payperiod = 'Y';
            }
            $payintervalcode = '<input name="a3" type="hidden" value="' . $this->price . '">
            <input name="cmd" type="hidden" value="_xclick-subscriptions">
            <input name="p3" type="hidden" value="1">
            <input name="t3" type="hidden" value="' . $payperiod . '">
            <input name="src" type="hidden" value="1">
            <input name="sra" type="hidden" value="1">';
        }
        else
        {
            $payintervalcode = '<input name="amount" type="hidden" value="' . $this->price . '">
            <input name="cmd" type="hidden" value="_xclick">';
        }

        $paybutton = '
            <form method="POST" action="https://www.paypal.com/cgi-bin/webscr" accept-charset="UTF-8" class="form-horizontal form-page-small">'
                . $payintervalcode . 
            '<input name="business" type="hidden" value="' . $this->adminemail . '">
            <input name="item_name" type="hidden" value="' . $this->sitename . ' - ' . $this->sitemname . '">
            <input name="no_note" type="hidden" value="1">
            <input name="page_style" type="hidden" value="PayPal">
            <input name="no_shipping" type="hidden" value="1">
            <input name="return" type="hidden" value="' . $this->domain . '/thankyou">
            <input name="cancel" type="hidden" value="' . $this->domain . '">
            <input name="currency_code" type="hidden" value="USD">
            <input name="lc" type="hidden" value="US">
            <input name="bn" type="hidden" value="PP-BuyNowBF">
            <input name="on0" type="hidden" value="User ID">
            <input name="os0" type="hidden" value="' . $this->buyerusername . '">
            <input name="on1" type="hidden" value="Item Name">
            <input name="os1" type="hidden" value="' . $this->payinterval . '">
            <input name="notify_url" type="hidden" value="' . $this->domain . '/ipn">
            <input type="image" name="submit" src="images/paypal.gif">
            </form>';
        return $paybutton;
    }
}
