<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit;
}

if (isset($showregister)) {
	echo $showregister;
	$showcontent = new PageContent();
	echo $showcontent->showPage('Thank You Page - New Member Signup');
	$Layout = new Layout();
	$Layout->showFooter();
	exit;
}

$showcontent = new PageContent();
echo $showcontent->showPage('Registration Page');

// Set up payment buttons if membership level is paid.
if (!empty($level)) {

	$price = $level . "price";
	$payinterval = $level . "payinterval";
	$itemname = ucfirst($level) . " Membership";
	$paymentdata = array(
		"itemname" => $itemname,
		"price" => $$price,
		"payinterval" => $$payinterval,
		"adminemail" => $adminemail,
		"sitename" => $sitename,
		"domain" => $domain,
		"username" => "",
		"referid" => $_SESSION['referid']
	);
	$user = new User();
	$paypal = new PaypalCheckout($paymentdata, $user);
	$paymentbuttons = $paypal->getPayButton();
} else {
	$level = "";
}

?>

<div class="container">

	<h1 class="ja-bottompadding">Sign Up</h1>

	<!-- 
This form does NOT submit for PAID MEMBERSHIPS. Rather, we just want the field values with JS. 
We submit the PAYMENT forms after getting these field values to store in the db. 
For FREE memberships we submit this form normally though.
-->
	<?php
		if (!empty($paymentbuttons)) {
			?>
			<form id="userform" accept-charset="utf-8" class="form" role="form">
			<?php
		} else {
				?>
				<form action="/register" method="post" accept-charset="utf-8" class="form" role="form">
				<?php
		}
	?>

			<div class="row">
				<div class="col-xs-6 col-md-6">
					<label for="firstname" class="ja-toppadding">First Name:</label>
					<input type="text" id="firstname" name="firstname" value="" class="form-control input-lg" placeholder="First Name" required>
				</div>
				<div class="col-xs-6 col-md-6">
					<label for="lastname" class="ja-toppadding">Last Name:</label>
					<input type="text" id="lastname" name="lastname" value="" class="form-control input-lg" placeholder="Last Name" required>
				</div>
			</div>

			<label for="email" class="ja-toppadding">Your Email:</label>
			<input type="email" id="email" name="email" value="" class="form-control input-lg" placeholder="Your Email" required>

			<label for="username" class="ja-toppadding">Username:</label>
			<input type="text" id="username" name="username" value="" class="form-control input-lg" placeholder="Username" required>

			<label for="password" class="ja-toppadding">Password:</label>
			<input type="password" id="password" name="password" value="" class="form-control input-lg" placeholder="Password" required>

			<label for="confirm_password" class="ja-toppadding">Confirm Password:</label>
			<input type="password" id="confirm_password" name="confirm_password" value="" class="form-control input-lg" placeholder="Confirm Password" required>

			<label for="paypal" class="ja-toppadding">Paypal Email:</label>
			<input type="email" id="paypal" name="paypal" value="" class="form-control input-lg" placeholder="Paypal Email">

			<label for="country" class="ja-toppadding">Country:</label>
			<select id="country" name="country" class="form-control input-lg">
				<option value="Canada">Canada</option>
				<option value="United States">United States</option>
				<?php
				$country = '';
				$countrylist = new Countries();
				echo $countrylist->showCountries($country);
				?>
			</select>

			<label for="referid" class="ja-toppadding">Your Sponsor:</label>
			<input type="text" id="referid" name="referid" value="<?php echo $_SESSION['referid']; ?>" class="form-control input-lg" placeholder="<?php echo $_SESSION['referid']; ?>" required>

			<input type="hidden" id="signupip" name="signupip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">

			<span class="help-block">By creating an account, you agree to our <a href="#" data-toggle="modal" data-target="#termsModal">Terms</a></span>

			<div class="ja-bottompadding"></div>

			<div id="errormsg"></diV>

			<?php
			if (!empty($paymentbuttons)) {
				echo "</form>"; // End user fields form
				echo $paymentbuttons; // Payment button forms
			} else {
			?>
					<button class="btn btn-lg btn-primary" type="submit" name="register">
						Create Free Account!
					</button>
				</form> <!-- End Free signup form -->
			<?php
			}
			?>

			</form>

			<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModal" aria-hidden="true">
				<div class="modal-dialog ja-modal-width">
					<div class="modal-content ja-modal">
						<div class="modal-body">

							<?php
							$terms = new PageContent();
							$showterms = $terms->showPage('Terms Page');
							echo $showterms;
							?>

						</div>
						<div class="modal-footer">
							<button class="btn btn-lg btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Close</button>
						</div>
					</div>
				</div>
			</div>

			<div class="ja-bottompadding"></div>

</div>