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

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
	$$key = $value;
}

$adtable = 'bannerspaid';
$allads = new Banner($adtable);
$ads = $allads->getAllAds();
?>

<div class="container">

	<h1 class="mb-2 pt-4">Sell Extra Paid-Only Banners</h1>

	<form action="/admin/bannerspaid" method="post" class="form" role="form">

		<label for="bannerprice" class="ja-toppadding">Price to Buy a Banner:</label>
		<input type="text" name="bannerprice" value="<?php echo $bannerprice ?>" class="form-control input-lg" placeholder="Price to Buy a Banner" maxlength="8" required>

		<label for="bannerhits" class="ja-toppadding">Number of Impressions per Banner:</label>
		<input type="text" name="bannerhits" value="<?php echo $bannerhits ?>" class="form-control input-lg" placeholder="Number of Impressions per Banner" maxlength="8" required>

		<div class="ja-bottompadding"></div>

		<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
		<button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="saveadsettings">SAVE SETTINGS</button>

	</form>

	<div class="ja-toppadding mb-4"></div>

	<h1 class="mb-2">Give Member Blank Banners (paid rotation only)</h1>

	<form action="/admin/bannerspaid" method="post" class="form" role="form">

		<label for="username" class="ja-toppadding">Username:</label>
		<input type="text" name="username" class="form-control input-lg" placeholder="Username" maxlength="32" required>

		<label for="howmanytogive" class="ja-toppadding">How many?:</label>
		<input type="number" min="1" step="1" value="1" name="howmanytogive" class="form-control smallselect" required>

		<div class="ja-bottompadding"></div>

		<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
		<button class="btn btn-lg btn-primary ja-bottompadding mt-2" type="submit" name="givememberblankad">GIVE BLANK ADS</button>

	</form>

	<div class="ja-toppadding mb-4"></div>

	<h1 class="ja-bottompadding">Create Banner</h1>

	<form action="/admin/bannerspaid" method="post" accept-charset="utf-8" class="form" role="form">

		<label for="name">For Username (blank for admin):</label>
		<input type="text" name="username" class="form-control input-lg" placeholder="For Username" required>

		<label for="name">Name of Ad:</label>
		<input type="text" name="name" id="name" class="form-control input-lg" placeholder="Name" required>

		<label for="title">Alt Text:</label>
		<input type="text" name="alt" id="alt" class="form-control input-lg" placeholder="Alt Text" required>

		<label for="url">Click-Thru URL:</label>
		<input type="url" name="url" id="url" class="form-control input-lg" placeholder="Click-Thru URL" required>

		<label for="imageurl">Image URL: (468 x 60 pixels only)</label>
		<input type="url" name="imageurl" id="imageurl" class="form-control input-lg" placeholder="Image URL" required>

		<div class="ja-bottompadding"></div>

		<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
		<button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="createad">CREATE AD</button>

	</form>

	<div class="ja-toppadding mb-4"></div>

	<h1 class="ja-bottompadding ja-toppadding mb-4">All Member Paid Banners</h1>

	<div class="table-responsive">
		<table id="admintable" class="table table-hover text-center table-sm">
			<thead>
				<tr>
					<th class="text-center small">Ad&nbsp;#</th>
					<th class="text-center small" style="min-width: 100px;">Image</th>
					<th class="text-center small" style="min-width: 100px;">Username</th>
					<th class="text-center small" style="min-width: 100px;">Name</th>
					<th class="text-center small" style="min-width: 100px;">Alt</th>
					<th class="text-center small" style="min-width: 200px;">Click-Thru&nbsp;URL</th>
					<th class="text-center small">Short&nbsp;URL</th>
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
				if (!$ads) {
				} else {

					foreach ($ads as $ad) {

						$adddate = $ad['adddate'];

						if (trim($adddate) == '' || substr($adddate, 0, 10) == '0000-00-00') {

							$dateadadded = 'Not Yet';
						} else {

							$dateadadded = date('Y-m-d');
						}
				?>
						<tr>
							<form action="/admin/bannerspaid/<?php echo $ad['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
								<td class="small"><?php echo $ad['id']; ?>
								</td>
								<td class="small">
									<img src="<?php echo $ad['imageurl']; ?>" alt="<?php echo $ad['alt'] ?>" class="mini-banner-image">
								</td>
								<td class="small">
									<input type="text" name="username" value="<?php echo $ad['username']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Username" required>
								</td>
								<td class="small">
									<input type="text" name="name" value="<?php echo $ad['name']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Name" required>
								</td>
								<td class="small">
									<input type="text" name="alt" value="<?php echo $ad['alt']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Alt Text" required>
								</td>
								<td>
									<input type="url" name="url" value="<?php echo $ad['url']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="http://" required>
								</td>
								<td>
									<a href="<?php echo $ad['shorturl'] ?>" target="_blank"><?php echo $ad['shorturl'] ?></a>
								</td>
								<td>
									<input type="url" name="imageurl" value="<?php echo $ad['imageurl']; ?>" class="form-control input-sm widetableinput" size="60" placeholder="http://" required>
								</td>
								<td class="small">
									<select name="approved" class="form-control widetableselect<?php if ($ad['approved'] !== "1") {
																									echo ' ja-yellowbg';
																								} ?>">
										<option value="0" <?php if ($ad['approved'] !== "1") {
																echo "selected";
															} ?>>No</option>
										<option value="1" <?php if ($ad['approved'] === "1") {
																echo "selected";
															} ?>>Yes</option>
									</select>
								</td>
								<td class="small">
									<?php echo $ad['hits']; ?>
								</td>
								<td class="small">
									<?php echo $ad['clicks']; ?>
								</td>
								<td class="small">
									<?php echo $dateadadded ?>
								</td>
								<td>
									<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
									<input type="hidden" name="_method" value="PATCH">
									<button class="btn btn-sm btn-primary" type="submit" name="savead">SAVE</button>
								</td>
							</form>
							<td>
								<form action="/admin/bannerspaid/<?php echo $ad['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
									<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="name" value="<?php echo $ad['name']; ?>">
									<button class="btn btn-sm btn-primary" type="submit" name="deletead">DELETE</button>
								</form>
							</td>
						</tr>
				<?php
					}
				}
				?>

			</tbody>
		</table>
	</div>

	<div class="ja-bottompadding"></div>

</div>