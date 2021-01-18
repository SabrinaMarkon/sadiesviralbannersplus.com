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
	private $pdo;
	private $username;
	private $password;
	private $firstname;
	private $lastname;
	private $email;
	private $paypal;
	private $country;
	private $signupip;
	private $referid;
	private $emailhash;
	private $gravatarimagelg;
	private $usernameoremail;

	public function newSignup($settings,$post) {

		$username = $post['username'];
		$password = $post['password'];
		$firstname = $post['firstname'];
		$lastname = $post['lastname'];
		$email = $post['email'];
		$paypal = $post['paypal'];
		$country = $post['country'];
		$signupip = $_SERVER['REMOTE_ADDR'];
		$referid = $post['referid'];

		if ($referid === '') {
			
			$referid = 'admin';
		}
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = "select * from members where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($username));
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$data = $q->fetch();
		if (!empty($data['username']) && $data['username'] == $username) {
				
			Database::disconnect();
	
			return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The username you chose isn't available.</strong></div>";
		}
		else
		{
				$verificationcode = time() . mt_rand(10, 100);
	
				$sql = "insert into members (username,password,firstname,lastname,email,paypal,country,referid,signupdate,signupip,verificationcode) 
				values (?,?,?,?,?,?,?,?,NOW(),?,?)";
				$q = $pdo->prepare($sql);
				$q->execute([$username,$password,$firstname,$lastname,$email,$paypal,$country,$referid,$signupip,$verificationcode]);
	
				Database::disconnect();
	
				$subject = "Welcome to " . $settings['sitename'] . "!";
				$message = "Click to Verify your Email: " . $settings['domain'] . "/verify/" . $verificationcode . "\n\n";
				$message .= "Login URL: " . $settings['domain'] . "/login\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
				$message .= "Your Referral URL: " . $settings['domain'] . "/r/" . $username . "\n\n";
	
				$sendsiteemail = new Email();
				$send = $sendsiteemail->sendEmail($email, $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');
	
				return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Success! Thanks for Joining!</strong>
				<p>Please click the link in the email we sent to you to verify your email address.</p></div>";
	
				$username = null;
				$password = null;
				$firstname = null;
				$lastname = null;
				$email = null;
				$country = null;
				$referid = null;
				$signupip = null;
		}
	}

	public function userLogin($username,$password) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = "select * from members where username=? and password=? limit 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($username,$password));
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
		else {
			# incorrect login.
			return false;
			}
		Database::disconnect();

	}

	public function verifyUser($verificationcode) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
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
			return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your email address was verified!</strong></div>";
		} else {
			return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>Your verification code was invalid. Please check the link in the welcome email.</strong></div>";
		}	
	}

	public function resendVerify($username,$password,$email,$settings) {

		$verificationcode = time() . mt_rand(10, 100);

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = "update members set verified='', verificationcode=? where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($verificationcode, $username));
		Database::disconnect();
		
		$subject = "Welcome to " . $settings['sitename'] . "!";
		$message = "Click to Verify your Email: " . $settings['domain'] . "/verify/" . $verificationcode . "\n\n";
		$message .= "Login URL: " . $settings['domain'] . "/login\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
		$message .= "Your Referral URL: " . $settings['domain'] . "/r/" . $username . "\n\n";
		$sendsiteemail = new Email();
		$send = $sendsiteemail->sendEmail($email, $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');

		return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your verification email was resent!</strong></div>";
	}

	public function forgotLogin($sitename,$domain,$adminemail,$post) {

		$usernameoremail = $post['usernameoremail'];
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = "select * from members where username=? or email=? limit 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($usernameoremail,$usernameoremail));
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$data = $q->fetch();
		if (!empty($data))
		{
			$email = $data['email'];
			$username = $data['username'];
			$password = $data['password'];
			$subject = "Your " . $sitename . " Login Details";
			$message = "Login URL: " . $domain . "\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
			
			$sendsiteemail = new Email();
			$send = $sendsiteemail->sendEmail($email,$adminemail,$subject,$message,$sitename,$adminemail, '');
			
			Database::disconnect();
			return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your login details were sent to your email address.</strong></div>";
		}
		else
		{
			Database::disconnect();
			return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The username or email address you entered was not found.</strong></div>";
		}

	}

	public function getGravatar($username,$email) {

		$emailhash = trim($email);
		$emailhash = md5($emailhash);
		$gravatarimagelg = "<img src=\"https://gravatar.com/avatar/" . $emailhash . "?s=130\" alt=\"" . $username . "\" class=\"avatar img-circle img-thumbnail gravatar-lg\">";
		return $gravatarimagelg;
		
	}

	public function saveProfile($username,$settings,$post) {

		$password = $post['password'];
		$firstname = $post['firstname'];
		$lastname = $post['lastname'];
		$email = $post['email'];
		$oldemail = $post['oldemail'];
		$paypal = $post['paypal'];
		$country = $post['country'];
		$signupip = $_SERVER['REMOTE_ADDR'];

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = "update members set password=?, firstname=?, lastname=?, email=?, paypal=?, country=?, signupip=? where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($password, $firstname, $lastname, $email, $paypal, $country, $signupip, $username));

		if ($email !== $oldemail) {
			
			$verificationcode = time() . mt_rand(10, 100);

			$sql = "update members set verified='', verificationcode=? where username=?";
			$q = $pdo->prepare($sql);
			$q->execute(array($verificationcode, $username));

			$subject = "Welcome to " . $settings['sitename'] . "!";
			$message = "Click to Verify your Email: " . $settings['domain'] . "/verify/" . $verificationcode . "\n\n";
			$message .= "Login URL: " . $settings['domain'] . "/login\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
			$message .= "Your Referral URL: " . $settings['domain'] . "/r/" . $username . "\n\n";
			$sendsiteemail = new Email();
			$send = $sendsiteemail->sendEmail($email, $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');

		}

		Database::disconnect();

		$_SESSION['password'] = $password;
		$_SESSION['firstname'] = $firstname;
		$_SESSION['lastname'] = $lastname;
		$_SESSION['email'] = $email;
		$_SESSION['paypal'] = $paypal;
		$_SESSION['country'] = $country;
		$_SESSION['signupip'] = $signupip;

		return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Account Details Were Saved!</strong><p>If you changed your email address, you will need to re-verify your account.</p></div>";

	}

	public function userLogout() {

		session_unset();
		return;

	}

	public function deleteUser($username) {
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		# delete ads.
		$sql = "delete from ads where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($username));

		# delete transactions.
		$sql = "delete from transactions where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($username));

		# delete account.
		$sql = "delete from members where id=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));

		$sql = "delete from members where username=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($username));

		Database::disconnect();
		
		return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Account " . $username . " Was Deleted</strong></div>";

	}
}
