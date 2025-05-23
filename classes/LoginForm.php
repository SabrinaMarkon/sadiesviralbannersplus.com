<?php

/**
Login form for members.
PHP 7.4+
@author Sabrina Markon
@copyright 2018 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
// if (count(get_included_files()) === 1) { exit('Direct Access is not Permitted'); }
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit;
}

class LoginForm
{
	public $loginerror;
	public $showloginerror;
	public $content;

	public function showLoginForm(string $loginerror)
	{

		$showloginerror = "";
		if ($loginerror == 1) {
			$showloginerror = "<div class=\"alert alert-danger mb-3\"><strong>Incorrect Login</strong></div>";
		}
		if ($loginerror == 2) {
			$showloginerror = "<div class=\"alert alert-danger mb-3\"><strong>Please Verify Your Email Address to Login<br /><a href=\"/resend\">Resend Verification Email</a></strong></div>";
		}

		$content = <<<HEREDOC
	<div class="container">
		<div class="row">
			<div class="col-md-6 center">
				
			<h1 class="ja-bottompadding">Login</h1>

			<form action="/members" method="post" accept-charset="utf-8" class="form" role="form">

				$showloginerror

				<label class="sr-only" for="username">Username</label>
				<input type="text" name="username" value="" class="form-control input-lg" placeholder="Username">

				<label class="sr-only" for="password">Password</label>
				<input type="password" name="password" value="" class="form-control input-lg" placeholder="Password">

				<button class="btn btn-lg btn-primary" type="submit" name="login">Login</button>

				<span class="help-block"><a href="/forgot">Forgot Password?</a></span>
				
			</form>

			<div class="ja-bottompadding"></div>

			</div>
		</div>
	</div>
HEREDOC;

		return $content;
	}
}
