<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
if (!isset($_SESSION)) {
	session_start();
}
require_once "config/Database.php";
require_once "config/Settings.php";
require_once "config/Layout.php";

function autoloader($class)
{
	require "classes/" . $class . ".php";
}
spl_autoload_register("autoloader");

function makeAdObject(string $adtable): ?object {
    switch ($adtable) {
        case "textads":
            $ad = new TextAd($adtable);
            break;
        case "bannerspaid":
            $ad = new Banner($adtable);
            break;
        case "viralbanners":
            $ad = new ViralBanner($adtable);
            break;
        case "networksolos":
            $ad = new NetworkSolo($adtable);
            break;
        default:
            $ad = null;
    }
    return $ad;
}

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
	$$key = $value;
}

# Get the sponsor if there is one.
if (isset($_GET['referid'])) {
	$_SESSION['referid'] = $_GET['referid'];
} elseif (!isset($_SESSION['referid'])) {
	$_SESSION['referid'] = 'admin';
}

# id variable is for the id of a single member, mail, etc. to update in the database.
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
} else {
	$id = "";
}

$show = '';
$errors = '';

# get the form validation class instance to use for all the pages that post.
if (isset($_POST)) {
	$formvalidation = new FormValidation($_POST);
}

######################################
if (isset($_POST['login'])) {

	$_SESSION['username'] = $_REQUEST['username'];
	$_SESSION['password'] = $_REQUEST['password'];
	$sendsiteemail = new Email();
	$logincheck = new User($sendsiteemail);
	$newlogin = $logincheck->userLogin($_SESSION['username'], $_SESSION['password']);
	if ($newlogin === null) {
		$logout = new User($sendsiteemail);
		$logout->userLogout();
	} else {
		# returned member details.
		foreach ($newlogin as $key => $value) {
			$$key = $value;
			$_SESSION[$key] = $value;
		}
		# user gravatar. TODO: Maybe use social media instead? (wondering if Gravatar is out-dated compared to Facebook profile pics)
		$showgravatar = $logincheck->getGravatar($_SESSION['username'], $_SESSION['email']);
		# reset the member's viral banner login counter to 0.
		$viralbanner = new ViralBanner('viralbanner');
		$viralbanner->setMemberViralBannerLoginClicks($_SESSION['username'], 0);
	}
}
###################################### Want to refactor below.

if (isset($_POST['forgotlogin'])) {

	// $errors = $formvalidation->validateAll($_POST);
	$errors = '';
	if (!empty($errors)) {

		$showforgot = $errors;
	} else {

		# member clicked button to recover login details.
		$sendsiteemail = new Email();
		$forgot = new User($sendsiteemail);
		$showforgot = $forgot->forgotLogin($sitename, $domain, $adminemail, $_POST);
	}
}

if (isset($_POST['userresendverification'])) {

	// $errors = $formvalidation->validateAll($_POST);
	$errors = '';
	if (!empty($errors)) {

		$show = $errors;
	} else {

		# member clicked button to resend their verification email.
		$sendsiteemail = new Email();
		$resend = new User($sendsiteemail);
		$show = $resend->resendForm($_POST['usernameoremail'], $settings);
	}
}

if (isset($_POST['contactus'])) {

	$errors = $formvalidation->validateAll($_POST);
	if (!empty($errors)) {

		$showcontact = $errors;
	} else {

		# someone clicked to send a contact email to the admin.
		$contact = new Contact();
		$showcontact = $contact->sendContact($settings);
	}
}

if (isset($_POST['register'])) {

	$errors = $formvalidation->validateAll($_POST);
	if (!empty($errors)) {

		$showregister = $errors;
	} else {

		# new signup clicked to submit registration.
		$sendsiteemail = new Email();
		$register = new User($sendsiteemail);
		$showregister = $register->newSignup($settings, $_POST, 'Free');
	}
}

if (isset($_GET['page']) && ($_GET['page'] === "verify")) {

	# user clicked their email verification link.
	$sendsiteemail = new Email();
	$verify = new User($sendsiteemail);
	# the last part of the url is code this time not referid like other urls. Don't fix cuz it ain't broke.
	$verificationcode = $_SESSION['referid'];
	$showverify = $verify->verifyUser($verificationcode);
}

if (isset($_POST['saveprofile'])) {

	$errors = $formvalidation->validateAll($_POST);
	if (!empty($errors)) {

		$showsaveprofile = $errors;
	} else {

		# user clicked to submit profile updates.
		$sendsiteemail = new Email();
		$update = new User($sendsiteemail);
		$showsaveprofile = $update->saveProfile($_SESSION['username'], $settings, $_POST);
	}
}

if (isset($_POST['resendverification'])) {

	$sendsiteemail = new Email();
	$resend = new User($sendsiteemail);
	$showresend = $resend->resendVerify($_SESSION['username'], $_SESSION['password'], $_SESSION['email'], $settings);
}

if (isset($_POST['createad'])) {

	$errors = $formvalidation->validateAll($_POST);
	if (!empty($errors)) {

		$showad = $errors;
	} else {

		# user submitted a new ad.
		$adtable = $_POST['adtable'];
		$ad = makeAdObject($adtable);
		if ($adtable === 'viralbanners') {
			$source = 'viralbanner';
		} else {
			$source = 'member';
		}
		if ($ad) {
			if ($ad) {
				if (empty($id)) {
					$id = 0;
				}
				$showad = $ad->createAd($id, $adminautoapprove, $source, $_POST);
			}
		}
	}
}

if (isset($_POST['savead'])) {

	$id = $_SESSION['referid']; // the var name referid is what is in the url, but it has the id of the ad in this case.

	$errors = $formvalidation->validateAll($_POST);
	if (!empty($errors)) {

		$showad = $errors;
	} else {

		# user saved changes made to their ad.
		$adtable = $_POST['adtable'];
		$ad = makeAdObject($adtable);

		if ($ad) {
			$showad = $ad->saveAd($id, $adminautoapprove, 0, $_POST);
		}
	}
}

if (isset($_POST['deletead'])) {

	$id = $_SESSION['referid']; // the var name referid is what is in the url, but it has the id of the ad in this case.

	$ad = "";
	$adtable = $_POST['adtable'];
	switch ($adtable) {
		case "textads":
			$ad = new TextAd($adtable);
			break;
		case "bannerspaid":
			$ad = new Banner($adtable);
			break;
		case "networksolos":
			$ad = new NetworkSolo($adtable);
			break;
	}
	if ($ad) {
		$showad = $ad->deleteAd($id, $_POST['name']);
	}
}

if (isset($_POST['savebannermaker'])) {

		# save a banner made in the banner maker app.
		$ad = new BannerMaker();
		if ($ad) {
			$show = $ad->saveBanner($_SESSION['username'], $_POST);
		}
}

if (isset($_GET['page']) && ($_GET['page'] === "logout")) {

	$sendsiteemail = new Email();
	$logout = new User($sendsiteemail);
	$logout->userLogout();
	$logoutpage = new PageContent();
	$show = $logoutpage->showPage('Logout Page');
}
######################################

# if an ad is clicked (we don't want a header.php)
if (isset($_GET['page']) && ($_GET['page'] === 'click')) {

	include "click.php";
	exit;
}

# if we are receiving an ipn notification from a payment processor (we don't want header.php).
if (isset($_POST['page']) && ($_POST['page'] === 'ipn')) {

	include "ipn.php";
	exit;
}

$Layout = new Layout();
$Layout->showHeader($metatitle, $metadescription);

if ((!empty($_GET['page'])) && ((file_exists($_GET['page'] . ".php") && ($_GET['page'] !== "index")))) {

	$page = $_REQUEST['page'];
	include $page . ".php";
} elseif ((!empty($_GET['page'])) && (!file_exists($_GET['page'] . ".php"))) {

	# show the dynamic page file that shows pages the admin has created from the admin area.
	$page = $_GET['page'];
	include "dynamic.php";
} else {

	include "main.php";
}

$Layout->showFooter();
