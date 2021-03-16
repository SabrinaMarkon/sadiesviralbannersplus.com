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

$showcontent = new PageContent();
echo $showcontent->showPage('Members Area Viral Banners Page');

$adtable = 'viralbanners';
$banner = new ViralBanner('viralbanners');

$prefix = lcfirst($accounttype);
$bannerslotsvar = $prefix . 'bannerslots';
$bannerslots = $banner->getVarArray($bannerslotsvar, $settings);
$refersfreebannerslotsvar = $prefix . 'refersfreebannerslots';
$refersfreebannerslots = $banner->getVarArray($refersfreebannerslotsvar, $settings);
$refersprobannerslotsvar = $prefix . 'refersprobannerslots';
$refersprobannerslots = $banner->getVarArray($refersprobannerslotsvar, $settings);
$refersgoldbannerslotsvar = $prefix . 'refersgoldbannerslots';
$refersgoldbannerslots = $banner->getVarArray($refersgoldbannerslotsvar, $settings);
?>

<div class="container">
	<h1 class="ja-bottompadding">Add Your Viral Banners!</h1>
	
	<div class="ja-bottompadding mb-5">Your Viral URL: <a href="<?php echo $domain ?>/banners/<?php echo $username ?>" target="_blank"><?php echo $domain ?>/banners/<?php echo $username ?></a></div>

	<div class="ja-bottompadding mb-5">Your 728 x 90 Banners</div>
	<?php
	for ($i = 1; $i <= 8; $i++) {
		if (in_array($i, $bannerslots)) {

			// These are the member's banners that show on their own url. Mention this.

		} else {

			// These are the member's banners that show on their referrals' urls. Say which level referrals each shows on depending on variables above.
			
		}
	}
	?>

	<div class="ja-bottompadding mb-5">Your 468 x 60 Banners</div>
	
	<?php

	// Random rotation.


	// Random rotation.


	// Banner that shows on referrals' urls.

	// Random or paid rotation.
	?>


	<div class="ja-bottompadding ja-toppadding"></div>


</div>