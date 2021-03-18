<?php
/**
Upgrade buttons.
PHP 7.4+
@author Sabrina Markon
@copyright 2018 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
**/
// if (count(get_included_files()) === 1) { exit('Direct Access is not Permitted'); }
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

class UpgradeButton
{
	private $paymentbuttons, $price, $payinterval, $itemname, $paymentdata, $paypal, $coinpayments;

	public function __construct(User $user, array $settings = []) {
		$this->settings = $settings;
		$this->user = $user;
	}

	public function showUpgradeButton(string $level, string $username, string $referid): string {

		$price = lcfirst($level) . "price";
		$payinterval = lcfirst($level) . "payinterval";
		$itemname = $level . " Upgrade";
		$paymentdata = array(
			"itemname" => $itemname,
			"price" => $this->settings[$price],
			"payinterval" => $this->settings[$payinterval],
			"username" => $username,
			"referid" => $referid
		);

		$paymentbuttons = "";

		if (!empty($this->settings['adminpaypal'])) {
			$paypal = new PaypalCheckout($paymentdata, $this->user, [], $this->settings);
			$paymentbuttons .= $paypal->getPayButton();
		}
		if (!empty($this->settings['admincoinpayments'])) {
			$api = new CoinPaymentsAPI();
			$coinpayments = new CoinPaymentsCheckout($paymentdata, $this->user, [], $this->settings, $api);
			$paymentbuttons .= $coinpayments->getPayButton();
		}

		return $paymentbuttons;
	}
}
