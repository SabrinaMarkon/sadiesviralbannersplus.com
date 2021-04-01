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

$itemname = "Text Ad";
$paymentdata = array(
	"itemname" => $itemname,
	"price" => $textadprice,
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
echo $showcontent->showPage('Members Area Text Ads Page');

$adtable = 'textads';
$ads = new TextAd($adtable);

# see if the user has any blank ads, and if so, get the first one (by id).
$oneblankad = $ads->getBlankAd($username);

# get all the user's active ads (to see clicks,hits,edit,etc.)
$activeads = $ads->getAllUsersAds($username);

?>

<div class="container">
	<h1 class="mb-4">Create Text Ad</h1>
	<?php
	if (empty($oneblankad)) {

		echo "<div class=\"my-4\">You have no additional blank text ads available. Please purchase one below!</div>";
		if (!empty($paymentbuttons)) {
			echo $paymentbuttons;
			echo "<div class=\"mb-5\"></div>";
		}
		
	} else {

		echo "<div class=\"ja-toppadding mb-5\">Please purchase a text ad below, or set up an existing ad using the form!</div>";
		if (!empty($paymentbuttons)) {
			echo $paymentbuttons;
			echo "<div class=\"mb-5\"></div>";
		}

		# the user has at least one blank ad they can submit.
		# get the ad's id for the adid.
		$adid = $oneblankad['id'];

	?>
		<form action="/textads/<?php echo $adid ?>" method="post" accept-charset="utf-8" class="form" role="form">

			<label for="name">Name of Ad (only you see):</label>
			<input type="text" name="name" id="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"]: ''; ?>" class="form-control input-lg" placeholder="Name" required>

			<label for="title">Ad Title:</label>
			<input type="text" name="title" id="title" value="<?php echo isset($_POST["title"]) ? $_POST["title"]: ''; ?>" class="form-control input-lg" placeholder="Ad Title" maxlength="12" required>

			<label for="url">Click-Thru URL:</label>
			<input type="url" name="url" id="url" value="<?php echo isset($_POST["url"]) ? $_POST["url"]: ''; ?>" class="form-control input-lg" placeholder="Click-Thru URL" required>

			<label for="description">Ad Text:</label>
			<input type="text" name="description" id="description" value="<?php echo isset($_POST["description"]) ? $_POST["description"]: ''; ?>" class="form-control input-lg" placeholder="Ad Text" maxlength="20" required>

			<label for="imageurl">Image URL: (125 x 125 pixels only)</label>
			<input type="url" name="imageurl" id="imageurl" value="<?php echo isset($_POST["imageurl"]) ? $_POST["imageurl"]: ''; ?>" class="form-control input-lg" placeholder="Image URL" required>

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

	<h1 class="ja-bottompadding ja-toppadding">Your Text Ads</h1>

	<?php
	# does the user have existing ads in the rotation already?
	if (empty($activeads)) {

		# the person has no ads yet. Say so, and tell them once they've paid they can create one.
		echo "<div class=\"ja-bottompadding ja-topadding mb-5\">You have no text ads you've added to the system yet.</div>";
	} else {

		# person has at least one ad they paid for, and have added it to the system.
		# show those ads and allow edit, save, delete.

	?>
		<div class="admintable-wrap mt-4">
			<table id="admintable" class="table table-hover text-center table-sm">
				<thead>
					<tr>
						<th class="text-center small">Ad&nbsp;#</th>
						<th class="text-center small" style="min-width: 125px;">Image</th>
						<th class="text-center small" style="min-width: 100px;">Name</th>
						<th class="text-center small" style="min-width: 100px;">Title</th>
						<th class="text-center small" style="min-width: 200px;">Click-Thru&nbsp;URL</th>
						<th class="text-center small">Short&nbsp;URL</th>
						<th class="text-center small" style="min-width: 200px;">Ad&nbsp;Text</th>
						<th class="text-center small" style="min-width: 200px;">Image&nbsp;URL</th>
						<th class="text-center small">Approved</th>
						<th class="text-center small">Impressions</th>
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
							<form action="/textads/<?php echo $activead['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
								<td class="small"><?php echo $activead['id']; ?>
								</td>
								<td class="small">
									<img src="<?php echo $activead['imageurl']; ?>" alt="<?php echo $activead['title'] ?>" class="textad-image">
								</td>
								<td class="small">
									<input type="text" name="name" value="<?php echo $activead['name']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Name" required>
								</td>
								<td class="small">
									<input type="text" name="title" value="<?php echo $activead['title']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Title" maxlength="12" required>
								</td>
								<td>
									<input type="url" name="url" value="<?php echo $activead['url']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="http://" required>
								</td>
								<td>
									<a href="<?php echo $activead['shorturl'] ?>" target="_blank"><?php echo $activead['shorturl'] ?></a>
								</td>
								<td>
									<input type="text" name="description" value="<?php echo $activead['description']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Ad Text" maxlength="20" required>
								</td>
								<td>
									<input type="url" name="imageurl" value="<?php echo $activead['imageurl']; ?>" class="form-control input-sm widetableinput" size="60" placeholder="http://" required>
								</td>
								<td class="small">
									<?php
									if ($activead['approved'] == 1) {
										echo "Yes";
									} else {
										echo "No";
									}
									?>
								</td>
								<td class="small">
									<?php echo $activead['hits']; ?>
								</td>
								<td class="small">
									<?php echo $activead['clicks']; ?>
								</td>
								<td class="small">
									<?php echo $dateadadded ?>
								</td>
								<td>
									<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
									<input type="hidden" name="_method" value="PATCH">
									<input type="hidden" name="username" value="<?php echo $username ?>">
									<button class="btn btn-sm btn-primary" type="submit" name="savead">SAVE</button>
								</td>
							</form>
							<td>
								<form action="/textads/<?php echo $activead['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
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