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

$itemname = "Network Solo";
$paymentdata = array(
	"itemname" => $itemname,
	"price" => $networksoloprice,
	"payinterval" => "",
	"username" => $username,
	"referid" => $referid
);
$sendsiteemail = new Email();
$user = new User($sendsiteemail);
$paymentbuttons = "";
if (!empty($adminpaypal)) {
	$paypal = new PaypalCheckout($paymentdata, $user, [], $settings);
	$paymentbuttons .= $paypal->getPayButton();
}
if (!empty($admincoinpayments)) {
	$api = new CoinPaymentsAPI();
	$coinpayments = new CoinPaymentsCheckout($paymentdata, $user, [], $settings, $api);
	$paymentbuttons .= $coinpayments->getPayButton();
}

$showcontent = new PageContent();
echo $showcontent->showPage('Members Area Network Solos Page');

$adtable = 'networksolos';
$ads = new NetworkSolo($adtable);

# see if the user has any blank ads, and if so, get the first one (by id).
$oneblankad = $ads->getBlankAd($username);

# get all the user's active ads (to see clicks,hits,edit,etc.)
$activeads = $ads->getAllUsersAds($username);

?>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
	tinymce.init({
		setup: function(ed) {
			ed.on('init', function() {
				this.getDoc().body.style.fontSize = '22px';
				this.getDoc().body.style.fontFamily = 'Calibri';
				this.getDoc().body.style.backgroundColor = $('.ja-content').css('background-color');
				this.getDoc().body.style.color = $('.ja-content').css('color');
			});
		},
		selector: 'textarea', // change this value according to your HTML
		body_id: 'elm1=htmlcode',
		body_class: 'elm1=ja-content',
		// height: 600,
		theme: 'modern',
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools'
		],
		toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		toolbar2: 'print preview media | forecolor backcolor emoticons',
		image_advtab: true,
		templates: [{
				title: 'Test template 1',
				content: 'Test 1'
			},
			{
				title: 'Test template 2',
				content: 'Test 2'
			}
		],
		content_css: [
			//            '/../css/bootstrap.min.css',
			//            '/../css/bootstrap-theme.min.css',
			//            '/../css/custom.css'
		]
	});
</script>
<!-- /tinyMCE -->

<div class="container">
	<h1 class="mb-4">Create Network Solo Ad</h1>
	<?php
	if (empty($oneblankad)) {

		echo "<div class=\"my-4\">You have no additional blank network solo ads available. Please purchase one below!</div>";
		if (!empty($paymentbuttons)) {
			echo $paymentbuttons;
			echo "<div class=\"mb-5\"></div>";
		}
	} else {

		echo "<div class=\"ja-bottompadding ja-topadding mb-5\">Please purchase a network solo ad below!</div>";
		if (!empty($paymentbuttons)) {
			echo $paymentbuttons;
			echo "<div class=\"mb-5\"></div>";
		}

		# the user has at least one blank ad they can submit.
		# get the ad's id for the adid.
		$adid = $oneblankad['id'];

	?>
		<form action="/networksolos/<?php echo $adid ?>" method="post" accept-charset="utf-8" class="form" role="form">

			<label for="name">Name of Ad (only you see):</label>
			<input type="text" name="name" id="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"]: ''; ?>" class="form-control input-lg" placeholder="Name" required>

			<label for="title">Subject:</label>
			<input type="text" name="subject" id="subject" value="<?php echo isset($_POST["subject"]) ? $_POST["subject"]: ''; ?>" class="form-control input-lg" placeholder="Subject" required>

			<label for="url">URL:</label>
			<input type="url" name="url" id="url" value="<?php echo isset($_POST["url"]) ? $_POST["url"]: ''; ?>" class="form-control input-lg" placeholder="URL" required>

			<label for="description">Message:</label>
			<textarea name="message" class="form-control input-lg" rows="50" placeholder="Message" style="height: 600px;"><?php echo isset($_POST["message"]) ? $_POST["message"]: ''; ?></textarea>

			<div class="ja-bottompadding"></div>

			<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
			<input type="hidden" name="id" value="<?php echo $adid ?>">
			<input type="hidden" name="username" value="<?php echo $username ?>">
			<button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="createad">CREATE AD</button>

		</form>
	<?php
	}
	echo "<div class=\"ja-bottompadding mb-5\"></div>";
	?>

	<div class="ja-bottompadding ja-toppadding"></div>

	<h1 class="ja-bottompadding ja-toppadding">Your Network Solo Ads</h1>

	<?php
	# does the user have existing ads in the rotation already?
	if (empty($activeads)) {

		# the person has no ads yet. Say so, and tell them once they've paid they can create one.
		echo "<div class=\"ja-bottompadding ja-topadding mb-5\">You have no network solo ads yet.</div>";
	} else {

		# person has at least one ad they paid for, and have added it to the system.
		# show those ads and allow edit, save, delete.

	?>
		<div class="admintable-wrap mt-4">
			<table id="admintable" class="table table-hover text-center table-sm">
				<thead>
					<tr>
						<th class="text-center small">Ad&nbsp;#</th>
						<th class="text-center small" style="min-width: 100px;">Name</th>
						<th class="text-center small" style="min-width: 100px;">Subject</th>
						<th class="text-center small" style="min-width: 200px;">URL</th>
						<th class="text-center small">Short&nbsp;URL</th>
						<th class="text-center small" style="min-width: 400px;">Message</th>
						<th class="text-center small">Approved</th>
						<th class="text-center small">Sent</th>
						<th class="text-center small">Clicks</th>
						<th class="text-center small">Date</th>
						<th class="text-center small">Save</th>
						<th class="text-center small">Delete</th>
					</tr>
				</thead>
				<tbody>

					<?php
					foreach ($activeads as $activead) {

						$adddate = $activead['adddate'];
						$dateadadded = date('Y-m-d');
					?>
						<tr>
							<form action="/networksolos/<?php echo $activead['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
								<td class="small align-baseline"><?php echo $activead['id']; ?>
								</td>
								<td class="small align-baseline">
									<input type="text" name="name" value="<?php echo $activead['name']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Name" required>
								</td>
								<td class="small align-baseline">
									<input type="text" name="subject" value="<?php echo $activead['subject']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Subject" required>
								</td>
								<td class="align-baseline">
									<input type="url" name="url" value="<?php echo $activead['url']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="http://" required>
								</td>
								<td class="align-baseline">
									<a href="<?php echo $activead['shorturl'] ?>" target="_blank"><?php echo $activead['shorturl'] ?></a>
								</td>
								<td class="align-baseline">
									<textarea class="form-control input-sm widetableinput" name="message" id="message" style="width: 400px; height: 150px;" placeholder="Message"><?php echo $activead['message'] ?></textarea>
								</td>
								<td class="small align-baseline">
									<?php
									if ($activead['approved'] == 1) {
										echo "Yes";
									} else {
										echo "No";
									}
									?>
								</td>
								<td class="small align-baseline">
									<?php echo $activead['sent']; ?>
								</td>
								<td class="small align-baseline">
									<?php echo $activead['clicks']; ?>
								</td>
								<td class="small align-baseline">
									<?php echo $dateadadded ?>
								</td>
								<td class="align-baseline">
									<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
									<input type="hidden" name="_method" value="PATCH">
									<input type="hidden" name="username" value="<?php echo $username ?>">
									<button class="btn btn-sm btn-primary" type="submit" name="savead">SAVE</button>
								</td>
							</form>
							<td class="align-baseline">
								<form action="/networksolos/<?php echo $activead['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
									<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="name" value="<?php echo $activead['name']; ?>">
									<button class="btn btn-sm btn-primary" type="submit" name="deletead">DELETE</button>
								</form>
							</td>
						</tr>
					<?php
					}
					?>

				</tbody>
			</table>
		</div>
	<?php
	}
	?>
	<div class="ja-bottompadding"></div>

</div>