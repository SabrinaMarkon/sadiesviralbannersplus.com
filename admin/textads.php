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

// if (isset($_GET['showad'])) {
// 	echo $showad;
// }

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
	$$key = $value;
}

$allmembers = new Member();
$members = $allmembers->getAllMembers();

$adtable = 'textads';
$allads = new TextAd($adtable);
$ads = $allads->getAllAds();
?>

<div class="container">

	<h1 class="mb-2 pt-4">Sell Text Ads</h1>

	<form action="/admin/textads" method="post" class="form" role="form">

		<label for="textadprice" class="ja-toppadding">Price to Buy a Text Ad:</label>
		<input type="text" name="textadprice" value="<?php echo $textadprice ?>" class="form-control input-lg" placeholder="Price to Buy a Text Ad" maxlength="8" required>

		<label for="textadhits" class="ja-toppadding">Number of Impressions per Text Ad:</label>
		<input type="text" name="textadhits" value="<?php echo $textadhits ?>" class="form-control input-lg" placeholder="Number of Impressions per Text Ad" maxlength="8" required>

		<div class="ja-bottompadding"></div>

		<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
		<button class="btn btn-lg btn-primary ja-bottompadding ja-toppadding" type="submit" name="saveadsettings">SAVE SETTINGS</button>

	</form>

	<div class="ja-bottompadding mb-4"></div>

	<h1 class="mb-2">Give Member Blank Text Ads</h1>

	<form action="/admin/textads" method="post" class="form" role="form">

		<label for="username" class="ja-toppadding">Username:</label>
        <select name="username" class="form-control input-lg">
            <?php
            foreach ($members as $member) {
                $username = $member['username'];
                ?>
                <option value="<?php echo $username ?>"><?php echo $username ?></options>
                <?php
                }
                ?>
        </select>

		<label for="howmanytogive" class="ja-toppadding">How many?:</label>
		<input type="number" min="1" step="1" value="1" name="howmanytogive" class="form-control smallselect" required>

		<div class="ja-bottompadding"></div>

		<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
		<button class="btn btn-lg btn-primary ja-bottompadding" type="submit" name="givememberblankad">GIVE BLANK ADS</button>

	</form>

	<div class="ja-bottompadding mb-4"></div>

	<h1 class="mb-2">Create Text Ad</h1>

	<form action="/admin/textads" method="post" accept-charset="utf-8" class="form" role="form">

		<label for="username">For Username:</label>
        <select name="username" class="form-control input-lg">
            <option value="admin">admin</option>
            <?php
            foreach ($members as $member) {
                $username = $member['username'];
				$selected = "";
				if (isset($_POST['username'])) {
					if ($_POST['username'] === $username) {
						$selected = " selected";
					}
				}
                ?>
                <option value="<?php echo $username ?>"<?php echo $selected; ?>><?php echo $username ?></options>
                <?php
                }
                ?>
        </select>

		<label for="name">Name of Ad:</label>
		<input type="text" name="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"]: ''; ?>" class="form-control input-lg" placeholder="Name of Ad" required>

		<label for="title">Ad Title:</label>
		<input type="text" name="title" value="<?php echo isset($_POST["title"]) ? $_POST["title"]: ''; ?>" class="form-control input-lg" placeholder="Ad Title" maxlength="12" required>

		<label for="url">Click-Thru URL:</label>
		<input type="url" name="url" value="<?php echo isset($_POST["url"]) ? $_POST["url"]: ''; ?>" class="form-control input-lg" placeholder="Click-Thru URL" required>

		<label for="description">Ad Text:</label>
		<input type="text" name="description" value="<?php echo isset($_POST["description"]) ? $_POST["description"]: ''; ?>" class="form-control input-lg" placeholder="Ad Text" maxlength="20" required>

		<label for="imageurl">Image URL: (125 x 125 pixels only)</label>
		<input type="url" name="imageurl" value="<?php echo isset($_POST["imageurl"]) ? $_POST["imageurl"]: ''; ?>" class="form-control input-lg" placeholder="Image URL" required>

		<div class="ja-bottompadding"></div>

		<input type="hidden" name="adtable" value="<?php echo $adtable ?>">
		<button class="btn btn-lg btn-primary ja-bottompadding" type="submit" name="createad">CREATE AD</button>

	</form>

	<div class="ja-bottompadding mb-4"></div>

	<h1 class="ja-bottompadding ja-toppadding mb-4">All Member Text Ads</h1>

	<form action="/admin/textads" method="post" accept-charset="utf-8" class="form" role="form">
    <input type="hidden" name="adtable" value="<?php echo $adtable ?>">
    <button class="btn btn-lg btn-primary mt-3 mb-5" type="submit" name="approveallads">APPROVE ALL</button>
    </form>

</div>

<div class="admintable-wrap mt-4">
	<table id="admintable" class="table table-hover text-center table-sm">
		<thead>
			<tr>
				<th class="text-center small">Ad&nbsp;#</th>
				<th class="text-center small">Approved</th>
				<th class="text-center small" style="min-width: 125px;">Image</th>
				<th class="text-center small" style="min-width: 100px;">Username</th>
				<th class="text-center small" style="min-width: 100px;">Name</th>
				<th class="text-center small" style="min-width: 100px;">Title</th>
				<th class="text-center small" style="min-width: 200px;">Click-Thru&nbsp;URL</th>
				<th class="text-center small">Short&nbsp;URL</th>
				<th class="text-center small" style="min-width: 200px;">Ad&nbsp;Text</th>
				<th class="text-center small" style="min-width: 200px;">Image&nbsp;URL</th>
				<th class="text-center small">Impressions</th>
				<th class="text-center small">Clicks</th>
				<th class="text-center small" style="min-width: 150px;">Date</th>
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
						<form action="/admin/textads/<?php echo $ad['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
							<td class="small"><?php echo $ad['id']; ?>
							</td>
							<td class="small<?php if ($ad['approved'] !== "1") { echo ' ja-coralbg'; } ?>">
								<select name="approved" class="form-control widetableselect">
									<option value="0" <?php if ($ad['approved'] !== "1") {
															echo "selected";
														} ?>>No</option>
									<option value="1" <?php if ($ad['approved'] === "1") {
															echo "selected";
														} ?>>Yes</option>
								</select>
							</td>
							<td class="small">
								<?php
								if ($ad['imageurl']) {
									?>
										<img src="<?php echo $ad['imageurl']; ?>" alt="<?php echo $ad['title'] ?>" class="textad-image">
									<?php
								} else {
									?>
										<div class="placeholder">NOT ADDED</div>
									<?php
								}
								?>
							</td>
							<td class="small">
								<select name="username" class="form-control input-sm widetableinput">
									<option value="admin"<?php if ($ad['username'] === 'admin') { echo " selected"; } ?>>admin</option>
									<?php
									foreach ($members as $member) {
										$username = $member['username'];
										?>
										<option value="<?php echo $username ?>"<?php if ($ad['username'] === $username) { echo " selected"; } ?>><?php echo $username ?></options>
										<?php
										}
										?>
								</select>
							</td>
							<td class="small">
								<input type="text" name="name" value="<?php echo $ad['name']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Name" required>
							</td>
							<td class="small">
								<input type="text" name="title" value="<?php echo $ad['title']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Title" maxlength="12" required>
							</td>
							<td>
								<input type="url" name="url" value="<?php echo $ad['url']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="http://" required>
							</td>
							<td>
								<a href="<?php echo $ad['shorturl'] ?>" target="_blank"><?php echo $ad['shorturl'] ?></a>
							</td>
							<td>
								<input type="text" name="description" value="<?php echo $ad['description']; ?>" class="form-control input-sm widetableinput" size="40" placeholder="Ad Text" maxlength="20" required>
							</td>
							<td>
								<input type="url" name="imageurl" value="<?php echo $ad['imageurl']; ?>" class="form-control input-sm widetableinput" size="60" placeholder="http://" required>
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
								<input type="hidden" name="added" value="<?php echo $ad['added']; ?>">
								<input type="hidden" name="_method" value="PATCH">
								<button class="btn btn-sm btn-primary" type="submit" name="savead">SAVE</button>
							</td>
						</form>
						<td>
							<form action="/admin/textads/<?php echo $ad['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
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
