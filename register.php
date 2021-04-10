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

$paymentbuttons = "";
// Set up payment buttons if membership level is paid.
if (!empty($level) && ($level === 'free' || $level === 'pro' || $level === 'gold')) {

	$price = $level . "price";
	$payinterval = $level . "payinterval";
	$itemname = ucfirst($level) . " Membership";
	$paymentdata = array(
		"itemname" => $itemname,
		"price" => $$price,
		"payinterval" => $$payinterval,
		"username" => "",
		"referid" => $_SESSION['referid']
	);
	$sendsiteemail = new Email();
	$user = new User($sendsiteemail);
	if (!empty($adminpaypal)) {
		$paypal = new PaypalCheckout($paymentdata, $user, [], $settings);
		$paymentbuttons .= $paypal->getPayButton();
	}
	if (!empty($admincoinpayments)) {
		$api = new CoinPaymentsAPI();
		$coinpayments = new CoinPaymentsCheckout($paymentdata, $user, [], $settings, $api);
		$paymentbuttons .= $coinpayments->getPayButton();
	}

	$bannerclickstosignup = $level . 'bannerclickstosignup';

} else {
	$level = "free";
	$bannerclickstosignup = 'freebannerclickstosignup';
}

// User must click banners depending on membership level before signup is accepted.
?>

<div class="container">

	<figure>
		<img src="images/sadie-sitting.png" alt="Click Viral Banners to Join!" class="mr-4">
		<div style="display:flex; flex-direction:column;">
			<figcaption>
				<div class="sadietalkbig sadietalkbig-2em mb-4">
					<span class="sadietalk-pink">First Click</span>&nbsp;<span class="sadietalk-blue"><?php echo $$bannerclickstosignup ?></span>&nbsp;<span class="sadietalk-pink"> Member Viral Banners to Register!</span><br />
				</div>
				<div class="sadietalknormal">
					<div style="font-weight: bold;" class="center mb-4">As a new <span class="sadietalk-pink text-uppercase"><?php echo $level; ?></span> member of my Viral Banner app, first visit <span class="sadietalk-pink"><?php echo $$bannerclickstosignup ?></span> of my members' Viral Banners below! For each one, allow the timed countdown to complete, then complete and submit the registration form once you're done!</div>
					<div style="font-weight: bold;" class="center mb-4"><strong><span class="sadietalk-pink">You've <span class="sadietalk-blue">ALREADY</span>&nbsp;<span class="sadietalk-pink">clicked</span>&nbsp;<span id="alreadyclicked" class="sadietalk-blue"></span>&nbsp;<span class="sadietalk-pink">Viral Banners!</span></strong></div>
					<div style="font-weight: bold;" class="center">After you validate your email and login, you can immediately add your <span class="sadietalk-pink">OWN</span> Viral Banners! <span class="heart">&#10084;</span></div>
				</div>
			</figcaption>
		</div>
	</figure>

	<div class="row justify-content-center mb-4">
		<div class="col-lg-6 col-md-10">
			<div class="section-title text-center">
				<h3 class="title">First&nbsp;...&nbsp;Click&nbsp;Banners!&nbsp;<i class="fas fa-star fa-xs"></i></h3>
				<!-- <p class="text"><strong>Stop wasting time and money designing and managing banners that don't get results! Happiness guaranteed!</strong></p> -->
				<br>
			</div> <!-- section title -->
		</div>
	</div> <!-- row -->

	<?php
	include "viralbannersinclude.php";
	?>

	<div class="row justify-content-center">
		<div class="col-lg-6 col-md-10">
			<div id="getstarted" class="section-title text-center">
				<h3 class="title">Then&nbsp;...&nbsp;Sign&nbsp;Up!&nbsp;<i class="fas fa-star fa-xs"></i></h3>
				<!-- <p class="text"><strong>Stop wasting time and money designing and managing banners that don't get results! Happiness guaranteed!</strong></p> -->
				<br>
			</div> <!-- section title -->
		</div>
	</div> <!-- row -->

	<!-- 
	This form does NOT submit for PAID MEMBERSHIPS. Rather, we just want the field values with JS. 
	We submit the PAYMENT forms after getting these field values to store in the db. 
	For FREE memberships we submit this form normally though (the post is picked up by index.php).
	-->

	<!-- TODO: Check that banners are clicked  -->
	<fieldset id="registrationfieldset" disabled="disabled">

		<?php
			if (!empty($paymentbuttons)) {
				?>
				<form id="userform" accept-charset="utf-8" class="form" role="form">
				<?php
			} else {
					?>
					<form id="freeuserform" action="/register" method="post" accept-charset="utf-8" class="form" role="form">
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

			<label for="bitcoin" class="ja-toppadding">Bitcoin Wallet ID:</label>
			<input type="text" id="bitcoin" name="bitcoin" value="" class="form-control input-lg" placeholder="Bitcoin Wallet ID">

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

			<span id="signupformbuttonormessage"></span>

	</fieldset>

			<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModal" aria-hidden="true">
				<div class="modal-dialog ja-modal-width">
					<div class="modal-content ja-modal">
						<div class="modal-body">

							<?php
							$terms = new PageContent();
							$showterms = $terms->showPage('Terms Page');
							$showterms = str_ireplace('~SITENAME~', $sitename, $showterms);
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

<script src="js/viralbannertimer.js"></script>
<script>
    // How many Viral Banners has the user clicked?
	const howManyClicked = howManyWereClicked();
    document.getElementById('alreadyclicked').innerHTML = howManyClicked;
	
	// Show submit/payment buttons or message to click more banners?
	const paidlevel = "<?php echo $level ?>";
	const bannerclickstosignup = "<?php echo $$bannerclickstosignup ?>";
	const canRegister = showSignupButtonOrPaymentButtons(paidlevel, bannerclickstosignup);

	if (canRegister === 'showpaymentbuttons') {

		// Enable the form fields.
		document.getElementById('registrationfieldset').disabled = false;
		// Show the pay buttons for paid memberships.
		const paymentbuttons = `<?php echo $paymentbuttons ?>`;
		if (paymentbuttons) {
			// document.getElementById('signupformbuttonormessage').innerHTML = '</form>' + paymentbuttons + '<div class="mb-3"></div>';

			document.getElementById('signupformbuttonormessage').innerHTML = `<figure class="mt-3">
            <div style="display:flex; flex-direction:column;"><figcaption><span class="sadietalknormal"><strong><span class="sadietalk-pink">Horray!!!</span>&nbsp;<span class="sadietalk-blue">You've Clicked&nbsp;<span class="sadietalk-pink">${bannerclickstosignup}</span>&nbsp;Viral Banners! Please register now and&nbsp;<span class="sadietalk-pink">JOIN US!</span>&nbsp;</span></strong></span></figcaption></form>${paymentbuttons}</div><img src="images/sadie-cartwheel-small.png" alt="You Can Register!"></figure>`;
		}

	} else if (canRegister === 'showfreessubmitbutton') {

		// Enable the form fields.
		document.getElementById('registrationfieldset').disabled = false;
		// Show the submit button for free membership.
		document.getElementById('signupformbuttonormessage').innerHTML = `<figure class="mt-3">
            <div style="display:flex; flex-direction:column;"><figcaption><span class="sadietalknormal"><strong><span class="sadietalk-pink">Horray!!!</span>&nbsp;<span class="sadietalk-blue">You've Clicked&nbsp;<span class="sadietalk-pink">${bannerclickstosignup}</span>&nbsp;Viral Banners! Please register now and&nbsp;<span class="sadietalk-pink">JOIN US!</span>&nbsp;</span></strong></span></figcaption><button class="btn btn-lg btn-primary mb-3" type="submit" name="register">Create Free Account!</button></form></div><img src="images/sadie-cartwheel-small.png" alt="You Can Register!"></figure>`;

	} else {

		// DISABLE the form fields.
		document.getElementById('registrationfieldset').disabled = true;
		// Show the error message that they have to click more Viral Banners to signup.
		document.getElementById('signupformbuttonormessage').innerHTML = `<figure class="mt-3">
            <div style="display:flex; flex-direction:column;"><figcaption><span class="sadietalknormal"><strong><span class="sadietalk-blue">You Still Need to Click <span class="sadietalk-pink">${bannerclickstosignup-howManyClicked}</span> More Viral Banners Before You Can Signup!</span></strong></figcaption></div><img src="images/sadie-shrug-small.png" alt="You Need to Click More VIral Banners to Join!"></figure>`;

	}
</script>
