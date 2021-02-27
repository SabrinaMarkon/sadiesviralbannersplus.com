<?php
/*
 * SendEmails handles admin or member submitted mail outs and should be called as a scheduled job.
 * PHP 5.4+
 * @author Sabrina Markon
 * @copyright 2018 Sabrina Markon, PHPSiteScripts.com
 * @license LICENSE.md
 *
 * @param $domain The main url of the website.
 * @param $sitename The name of the website
 * @param $adminemail The website admin's support email address.
 * @param @adminname The name of the website admin.
 */
require_once('../../config/Database.php');
require_once('../../config/Settings.php');
require_once('../../classes/Email.php');

class SubmitNetworkSolos
{

    private $email;
    private $url;
    private $subject;
    private $message;
    private $headers;
    private $pdo;

    private function __construct()
    {
    }

    public static function sendMails(array $settings): void
    {

        // get all mails that are marked as pending mailout.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from networksolos where added=1 and approved=1 and sent!='Not Yet' order by id";
        $q = $pdo->query($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $sendmails = $q->fetchAll();

        if (!empty($sendmails)) {

            foreach ($sendmails as $sendmail) {

                $id = $sendmail['id'];
                $senderuserid = $sendmail['username'];
                $subject = $sendmail['subject'];
                $message = $sendmail['message'];
                $url = $sendmail['url'];
                $shorturl = $sendmail['shorturl'];
                $networkclickurl = $settings['domain'] . '/click/networksolos/' . $id;

                $sent = date('Y-m-d');

                // 1) Post to the network:
                $posturl = "http://pearlsofwealth.com/soloadd.php";
                $postdata = [
                    "soloemail" => $settings['adminemail'],
                    "solotransaction" => $settings['sitename'],
                    "solourl" => $networkclickurl,
                    "solosubject" => $subject,
                    "solomessage" => $message,
                    "format" => "html",
                    "soloconfirm" => "yes",
                    "autojoin" => "no"
                ];
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $posturl);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postdata));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_exec($curl);
                curl_close($curl);

                // 2) Send to site members:
                $sql = "select * from members where verified!='' order by id";
                $q = $pdo->prepare($sql);
                $q->execute();
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $members = $q->fetchAll();

                if ($members) {

                    foreach ($members as $member) {

                        $username = $member['username'];
                        $firstname = $member['firstname'];
                        $lastname = $member['lastname'];
                        $email = $member['email'];
                        $fullname = $firstname . ' ' . $lastname;

                        // message tracked url:
                        $clickurl = "Click to Visit! <a href='" . $networkclickurl . "'>" . $url . "</a>";

                        // message disclaimer:
                        $disclaimer = "--------------------------------------------------------------<br><br>";
                        $disclaimer .= "This is a paid Super Network Solo from " . $settings['sitename'] . ".<br><br>";
                        $disclaimer .= "Login to your account to purchase one of your own sent to 300+ double-optin safelists on the Pearls of Wealth network! Exclusive to " . $settings['sitename'] . " members!<br><br>";
                        $disclaimer .= "You are receiving this because you are a double opted-in member of " . $settings['sitename'] . " with username " . $username . "<br><br>";
                        $disclaimer .= "You can opt out of receiving all emails from this website by logging in and deleting your account here:<br><br><a href=\"" . $settings['domain'] . "/login\">" . $settings['domain'] . "/login</a><br><br>";
                        $disclaimer .= "Kindly allow up to 24 hours to stop receiving mail once you delete your account.<br><br>";
                        $disclaimer .= "Thank you,<br>" . $settings['adminname'] . "<br>" . $settings['sitename'] . "<br><br><br>";
                        $disclaimer .= "Live Removal Assistance or Questions: <a href=\"mailto:" . $settings['adminemail'] . "\">" . $settings['adminemail'] . "</a><br><br>";
                        $disclaimer .= "This email is sent in strict compliance with International spam laws.<br><br>";

                        // full message and subject with disclaimer as well as this member's substitution:
                        $html = $message . "<br><br>" . $clickurl . "<br><br><br>" . $disclaimer;
                        $html = str_replace("~USERID~", $username, $html);
                        $html = str_replace("~FULLNAME~", $fullname, $html);
                        $html = str_replace("~FIRSTNAME~", $firstname, $html);
                        $html = str_replace("~LASTNAME~", $lastname, $html);
                        $html = str_replace("~EMAIL~", $email, $html);
                        $html = $html . "<br><br>Sent by: " . $senderuserid;
                        $subject = str_replace("~USERID~", $username, $subject);
                        $subject = str_replace("~FULLNAME~", $fullname, $subject);
                        $subject = str_replace("~FIRSTNAME~", $firstname, $subject);
                        $subject = str_replace("~LASTNAME~", $lastname, $subject);
                        $subject = str_replace("~EMAIL~", $email, $subject);

                        $htmlheader = "Content-Type: text/html; charset=windows-1252\n";

                        $sendsiteemail = new Email();
                        $sendsiteemail->sendEmail($email, $settings['adminemail'], $subject, $html, $settings['sitename'], $settings['adminemail'], $htmlheader);

                        if ($senderuserid === 'admin') {

                            # if the admin sent it, send a copy to the default admin email account.
                            $sendsiteemail->sendEmail($settings['adminemail'], $settings['adminemail'], $subject, $html, $settings['sitename'], $settings['adminemail'], $htmlheader);
                        }
                    }
                }

                // update the mail record to show it has been sent:
                $sql = "update networksolos set sent=? where id=?";
                $q = $pdo->prepare($sql);
                $q->execute([$sent, $id]);
            }
        }

        Database::disconnect();
    }
}

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
    $$key = $value;
}

$mail = SubmitNetworkSolos::sendMails($settings);
