<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit;
}

if (!empty($_SESSION['username']) && !empty($_SESSION['password'])) {

	$sendsiteemail = new Email();
	$logincheck = new User($sendsiteemail);
	$newlogin = $logincheck->userLogin($_SESSION['username'], $_SESSION['password']);
	if (empty($newlogin)) {
		header('Location: /login?err=1');
		exit;
	} else {
		# returned member details.
		foreach ($newlogin as $key => $value) {
			$$key = $value;
			$_SESSION[$key] = $value;
		}
		if (empty($verified)) {
			header('Location: /login?err=2');
			exit;
		}
		$showgravatar = $logincheck->getGravatar($username, $email);
	}
} else {
	header('Location: /login?err=1');
	exit;
}
