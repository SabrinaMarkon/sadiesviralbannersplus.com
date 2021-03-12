<?php

/**
Handles admin adding, updating, or deleting members.
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

class Member
{
    private $pdo, $username, $password, $firstname, $lastname, $country, $email, $signupip, $referid;

    public function getAllMembers(): array
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from members order by username";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $members = $q->fetchAll();
        $memberarray = array();
        foreach ($members as $member) {
            array_push($memberarray, $member);
        }
        //        print_r($memberarray);
        //        exit;
        return $memberarray;
    }

    public function addMember(array $settings): string
    {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $accounttype = $_POST['accounttype'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $country = $_POST['country'];
        $email = $_POST['email'];
        $paypal = $_POST['paypal'];
        $signupip = $_SERVER['REMOTE_ADDR'];
        $referid = $_POST['referid'];

        if (empty($referid)) {

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

            return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The username you chose isn't available.</strong></div>";
        }

        $verificationcode = time() . mt_rand(10, 100);

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into members (username,password,accounttype,firstname,lastname,email,paypal,country,referid,signupdate,signupip,verificationcode) values (?,?,?,?,?,?,?,?,NOW(),?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($username, $password, $accounttype, $firstname, $lastname, $email, $paypal, $country, $referid, $signupip, $verificationcode));

        Database::disconnect();

        $subject = "Welcome to " . $settings['sitename'] . "!";
        $message = "Click to Verify your Email: " . $settings['domain'] . "/verify/" . $verificationcode . "\n\n";
        $message .= "Login URL: " . $settings['domain'] . "/login\nUsername: " . $username . "\nPassword: " . $password . "\n\n";
        $message .= "Your Referral URL: " . $settings['domain'] . "/r/" . $username . "\n\n";

        $sendsiteemail = new Email();
        $sendsiteemail->sendEmail($email, $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['adminemail'], '');

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Member " . $username . " was Added!</strong></div>";
    }

    public function saveMember(int $id): string
    {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $accounttype = $_POST['accounttype'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $country = $_POST['country'];
        $email = $_POST['email'];
        $paypal = $_POST['paypal'];
        $signupip = $_POST['signupip'];
        $referid = $_POST['referid'];
        $owed = $_POST['owed'];
        $paid = $_POST['paid'];

        if (empty($referid)) {

            $referid = 'admin';
        }

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update `members` set username=?, password=?, accounttype=?, firstname=?, lastname=?, country=?, email=?, paypal=?, signupip=?, referid=?, owed=?, paid=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username, $password, $accounttype, $firstname, $lastname, $country, $email, $paypal, $signupip, $referid, $owed, $paid, $id));

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Member " . $username . " was Saved!</strong></div>";
    }
}
