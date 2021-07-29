<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit;
}

if ((isset($_SESSION['username'])) && (isset($_SESSION['password']))) {

	$sendsiteemail = new Email();
	$logincheck = new User($sendsiteemail);
	$newlogin = $logincheck->userLogin($_SESSION['username'], $_SESSION['password']);

	if (empty($newlogin)) {

		$showcontent = new LoginForm();
		echo $showcontent->showLoginForm(1);
		$Layout = new Layout();
		$Layout->showFooter();
		exit;

	} else {

		foreach ($newlogin as $key => $value) {
			$$key = $value;
			$_SESSION[$key] = $value;
		}

		// Has member verified their email address?
		if (empty($verified)) {
			$showcontent = new LoginForm();
			echo $showcontent->showLoginForm(2);
			$Layout = new Layout();
			$Layout->showFooter();
			exit;
		}

		// Has member clicked all the viral banners they are required in order to login?
		$showviralbanners = false;
		$level = lcfirst($accounttype);
		$bannerclickstologin = $level . 'bannerclickstologin';
		if ($viralbannerloginclicks < $$bannerclickstologin) {
			// Show viral banner page.
			$showviralbanners = true;
		}

		$showgravatar = $logincheck->getGravatar($username, $email);
	}
} else {

	$showcontent = new LoginForm();
	echo $showcontent->showLoginForm(1);
	$Layout = new Layout();
	$Layout->showFooter();
	exit;
}