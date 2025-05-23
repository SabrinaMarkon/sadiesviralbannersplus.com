<?php

/**
Handles user interactions with the application.
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

class User
{
	protected $pdo;
	protected $username;
	protected $password;
	protected $accounttype;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $paypal;
	protected $bitcoin;
	protected $country;
	protected $signupip;
	protected $referid;
	protected $emailhash;
	protected $gravatarimagelg;
	protected $usernameoremail;

	public function __construct(Email $sendsiteemail)
	{
		$this->sendsiteemail = $sendsiteemail;
	}

	/**
	 * @param settings[] $settings An array of admin settings.
	 * @param post[] $post An array of values originally posted from the registration form.
	 */
	public function newSignup(array $settings, array $post, string $accounttype): ?string
	{

		$username = $post['username'];
		$password = $post['password'];
		$firstname = $post['firstname'];
		$lastname = $post['lastname'];
		$email = $post['email'];
		$paypal = $post['paypal'];
		$bitcoin = $post['bitcoin'];
		$country = $post['country'];
		$signupip = $_SERVER['REMOTE_ADDR'];
		$referid = $post['referid'];

		if ($referid === '') {

			$referid = 'admin';
		}

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "select * from members where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($username));
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$data = $q->fetch();
		if (!empty($data['username']) && $data['username'] == $username) {

			Database::disconnect();

			if ($accounttype === "Free") {
				return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The username you chose isn't available.</strong></div>";
			}
		} else {
			$verificationcode = time() . mt_rand(10, 100);

			$sql = "insert into members (username,password,accounttype,firstname,lastname,email,paypal,bitcoin,country,referid,signupdate,signupip,verificationcode) 
				values (?,?,?,?,?,?,?,?,?,?,NOW(),?,?)";
			$q = $pdo->prepare($sql);
			$q->execute([$username, $password, $accounttype, $firstname, $lastname, $email, $paypal, $bitcoin, $country, $referid, $signupip, $verificationcode]);

			Database::disconnect();

			$subject = "Welcome to your " . $accounttype . " " . $settings['sitename'] . " membership!";
			$message = "Click to Verify your Email: " . $settings['domain'] . "/verify/" . $verificationcode . "\n\n";
			$message .= "Login URL: " . $settings['domain'] . "/login\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
			$message .= "Your Referral URL: " . $settings['domain'] . "/r/" . $username . "\n\n";
			$this->sendsiteemail->sendEmail($email, $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');

			// send email to admin:
			$subject = "A new " . $accounttype . " member has joined " . $settings['sitename'] . "!";
			$message = "Username: " . $username . "\n";
			$message .= "Email: " . $email . "\n";
			$message .= "Membership Level: " . $accounttype . "\n\n";
			$this->sendsiteemail->sendEmail($settings['adminemail'], $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');

			if ($accounttype === "Free") {
				return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Success! Thanks for Joining!</strong>
				<p>Please click the link in the email we sent to you to verify your email address.</p></div>";
			}

			$username = null;
			$password = null;
			$accounttype = null;
			$firstname = null;
			$lastname = null;
			$email = null;
			$country = null;
			$referid = null;
			$signupip = null;
		}
	}

	/**
	 * @param settings[] $settings An array of admin settings.
	 */
	public function upgradeUser(array $settings, string $username, string $referid, string $accounttype): void
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "update members set accounttype=? where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($accounttype, $username));

		// send email to admin:
		$subject = "A member has upgraded to " . $accounttype . " at " . $settings['sitename'] . "!";
		$message = "Username: " . $username . "\n";
		$message .= "Membership Level: " . $accounttype . "\n\n";
		$this->sendsiteemail->sendEmail($settings['adminemail'], $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');
	}

	public function userLogin(string $username, string $password): ?array
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "select * from members where username=? and password=? limit 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($username, $password));
		$valid = $q->rowCount();
		if ($valid > 0) {
			# successful login.
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$memberdetails = $q->fetch();
			# update last login.
			$sql = "update members set lastlogin=NOW() where username=?";
			$q = $pdo->prepare($sql);
			$q->execute(array($username));
			return $memberdetails;
		}
		Database::disconnect();
		return null;
	}

	public function verifyUser(string $verificationcode): string
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "select * from members where verificationcode=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($verificationcode));
		$valid = $q->rowCount();
		if ($valid) {
			# successful email validation. Add time to verified field so we know when it happened.
			$sql = "update members set verified=" . time() . " where verificationcode=?";
			$q = $pdo->prepare($sql);
			$q->execute(array($verificationcode));
			Database::disconnect();
			return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your email address was verified!<br /><a href=\"/login\">Click to Login</a></strong></div>";
		} else {
			return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>Your verification code was invalid. Please check the link in the welcome email.</strong></div>";
		}
	}

	public function resendForm(string $usernameoremail, array $settings): string
	{

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "select * from members where username=? or email=? limit 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($usernameoremail, $usernameoremail));
		$valid = $q->rowCount();
		if ($valid > 0) {
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$memberdetails = $q->fetch();
			$username = $memberdetails['username'];
			$password = $memberdetails['password'];
			$email = $memberdetails['email'];
			$resent = $this->resendVerify($username, $password, $email, $settings);
			
			return $resent;
		} else {

			return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The username or email address you entered was not found.</strong></div>";
		}
	}

	public function resendVerify(string $username, string $password, string $email, array $settings): string
	{

		$verificationcode = time() . mt_rand(10, 100);

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "update members set verified='', verificationcode=? where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($verificationcode, $username));
		Database::disconnect();

		$subject = "Welcome to " . $settings['sitename'] . "!";
		$message = "Click to Verify your Email: " . $settings['domain'] . "/verify/" . $verificationcode . "\n\n";
		$message .= "Login URL: " . $settings['domain'] . "/login\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
		$message .= "Your Referral URL: " . $settings['domain'] . "/r/" . $username . "\n\n";
		$this->sendsiteemail->sendEmail($email, $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');

		return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your verification email was resent!</strong></div>";
	}

	/**
	 * @param post[] $post An array of values originally posted from the forgot login form.
	 */
	public function forgotLogin(string $sitename, string $domain, string $adminemail, array $post): string
	{

		$usernameoremail = $post['usernameoremail'];

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "select * from members where username=? or email=? limit 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($usernameoremail, $usernameoremail));
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$data = $q->fetch();
		if (!empty($data)) {
			$email = $data['email'];
			$username = $data['username'];
			$password = $data['password'];
			$subject = "Your " . $sitename . " Login Details";
			$message = "Login URL: " . $domain . "\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
			$this->sendsiteemail->sendEmail($email, $adminemail, $subject, $message, $sitename, $adminemail, '');

			Database::disconnect();
			return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your login details were sent to your email address.</strong></div>";
		} else {
			Database::disconnect();
			return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The username or email address you entered was not found.</strong></div>";
		}
	}

	public function getGravatar(string $username, string $email): string
	{

		$emailhash = trim($email);
		$emailhash = md5($emailhash);
		$gravatarimagelg = "<img src=\"https://gravatar.com/avatar/" . $emailhash . "?s=130\" alt=\"" . $username . "\" class=\"avatar img-circle img-thumbnail gravatar-lg\">";
		return $gravatarimagelg;
	}

	/**
	 * @param settings[] $settings An array of admin settings.
	 * @param post[] $post An array of values originally posted from the profile form.
	 */
	public function saveProfile(string $username, array $settings, array $post): string
	{

		$password = $post['password'];
		$firstname = $post['firstname'];
		$lastname = $post['lastname'];
		$email = $post['email'];
		$oldemail = $post['oldemail'];
		$paypal = $post['paypal'];
		$bitcoin = $post['bitcoin'];
		$country = $post['country'];
		$signupip = $_SERVER['REMOTE_ADDR'];

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "update members set password=?, firstname=?, lastname=?, email=?, paypal=?, bitcoin=?, country=?, signupip=? where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($password, $firstname, $lastname, $email, $paypal, $bitcoin, $country, $signupip, $username));

		if ($email !== $oldemail) {

			$verificationcode = time() . mt_rand(10, 100);

			$sql = "update members set verified='', verificationcode=? where username=?";
			$q = $pdo->prepare($sql);
			$q->execute(array($verificationcode, $username));

			$subject = "Welcome to " . $settings['sitename'] . "!";
			$message = "Click to Verify your Email: " . $settings['domain'] . "/verify/" . $verificationcode . "\n\n";
			$message .= "Login URL: " . $settings['domain'] . "/login\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
			$message .= "Your Referral URL: " . $settings['domain'] . "/r/" . $username . "\n\n";
			$this->sendsiteemail->sendEmail($email, $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');
		}

		Database::disconnect();

		$_SESSION['password'] = $password;
		$_SESSION['firstname'] = $firstname;
		$_SESSION['lastname'] = $lastname;
		$_SESSION['email'] = $email;
		$_SESSION['paypal'] = $paypal;
		$_SESSION['bitcoin'] = $bitcoin;
		$_SESSION['country'] = $country;
		$_SESSION['signupip'] = $signupip;

		return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Account Details Were Saved!</strong><p>If you changed your email address, you will need to re-verify your account.</p></div>";
	}

	public function userLogout(): void
	{

		session_unset();
		return;
	}

	public function deleteUser(): string
	{

        $username = $_POST['username'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        # delete text ads.
        $sql = "delete from textads where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));

        # delete network solos.
        $sql = "delete from networksolos where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));

        # delete paid banners.
        $sql = "delete from bannerspaid where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));

        # delete from banner maker saved banners.
        $sql = "delete from banners where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));

        # delete from member banners.
        $sql = "select * from viralbanners where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $usersbanners = $q->fetchAll();

		# delete download access.
        $sql = "delete from downloadaccess where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));

        # delete mails.
        $sql = "delete from mail where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));

        # delete transactions.
        $sql = "delete from transactions where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));

        # delete account.
        $sql = "delete from members where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));

		Database::disconnect();

		return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Account " . $username . " Was Deleted</strong></div>";
	}
}
