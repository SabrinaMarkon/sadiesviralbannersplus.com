<?php
error_reporting(E_ALL);
/**
Value checking for form input.
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

class FormValidation
{

    private
        $pdo,
        $post,
        $errors;

    const PRETTY_VARNAMES = [

        'username' => 'username',
        'password' => 'password',
        'confirm_password' => 'password confirmation',
        'adminpass' => 'admin password',
        'confirm_adminpass' => 'admin password confirmation',
        'adminuser' => 'admin username',
        'referid' => 'referid',
        'sitename' => 'site name',
        'transaction' => 'transaction',
        'slug' => 'slug',
        'title' => 'title',
        'firstname' => 'first name',
        'lastname' => 'last name',
        'name' => 'name',
        'subject' => 'subject',
        'country' => 'country',
        'adminname' => 'admin name',
        'description' => 'ad description',
        'message' => 'message',
        'email' => 'email',
        'paypal' => 'paypal',
        'adminpaypal' => 'admin paypal',
        'admincoinpayments' => 'admin coinpayments.net api',
        'adminemail' => 'admin email',
        'url' => 'URL',
        'imageurl' => 'image URL',
        'domain' => 'domain',
        'metatitle' => 'meta title',
        'metadescription' => 'meta description',
        'adminautoapprove' => 'for auto approve ads',
        'signupip' => 'signup IP',
        'id' => 'id',
        'amount' => 'amount',
        'type' => 'ad type',
        'promotionalimage' => 'promotional banner image URL',
        'promotionalsubject' => 'promotional email ad subject',
        'promotionaladbody' => 'promotional email ad message',
        'downloadname' => 'download name',
        'downloadtype' => 'type of download',
        'downloaddescription' => 'download description',
        'downloadurl' => 'download url',
        'downloadfile' => 'file to upload',
        'downloadsfolder' => 'path to downloads folder',
        'question' => 'faq question',
        'answer' => 'faq answer',
        'position' => 'faq order position',
        'textadprice' => 'price to buy a text ad',
        'textadhits' => 'number of impressions per text ad',
        'bannerprice' => 'price to buy a banner ad',
        'bannerhits' => 'number of impressions per banner ad',
        'networksoloprice' => 'price to buy a network solo ad',
        'proprice' => 'price of a pro membership',
        'propayinterval' => 'how often members pay for a pro membership',
        'goldprice' => 'price of a gold membership',
        'goldpayinterval' => 'how often members pay for a gold membership',
        'freebannerclickstosignup' => 'banner clicks for free members to sign up',
        'freerefersproearn' => 'how much a free member is paid for referring a pro member',
        'freerefersgoldearn' => 'how much a free member is paid for referring a gold member',
        'freeadclickstogettextad' => 'text ads to click for a free member to get a free text ad',
        'freeadclickstogetbannerspaid' => 'banners to click for a free member to get a free banner',
        'freeadclickstogetnetworksolo' => 'network solo links to click for a free member to get a network solo',
        'probannerclickstosignup' => 'banner clicks for pro members to sign up',
        'prorefersproearn' => 'how much a pro member is paid for referring a pro member',
        'prorefersgoldearn' => 'how much a pro member is paid for referring a gold member',
        'proadclickstogettextad' => 'text ads to click for a pro member to get a free text ad',
        'proadclickstogetbannerspaid' => 'banners to click for a pro member to get a free banner',
        'proadclickstogetnetworksolo' => 'network solo links to click for a pro member to get a network solo',
        'goldbannerclickstosignup' => 'banner clicks for gold members to sign up',
        'goldrefersproearn' => 'how much a gold member is paid for referring a pro member',
        'goldrefersgoldearn' => 'how much a gold member is paid for referring a gold member',
        'goldadclickstogettextad' => 'text ads to click for a gold member to get a free text ad',
        'goldadclickstogetbannerspaid' => 'banners to click for a gold member to get a free banner',
        'goldadclickstogetnetworksolo' => 'network solo links to click for a gold member to get a network solo',
        'freesignupbonustextads' => 'how many text ads a free member gets as a signup bonus',
        'freesignupbonusbannerspaid' => 'how many paid banners a free member gets as a signup bonus',
        'freesignupbonusnetworksolos' => 'how many network solos a free member gets as a signup bonus',
        'freemonthlybonustextads' => 'how many bonus text ads a free member gets per month',
        'freemonthlybonusbannerspaid' => 'how many bonus paid banner ads a free member gets per month',
        'freemonthlybonusnetworksolos' => 'how many bonus network solos a free member gets per month',
        'prosignupbonustextads' => 'how many text ads a pro member gets as a signup bonus',
        'prosignupbonusbannerspaid' => 'how many paid banners a pro member gets as a signup bonus',
        'prosignupbonusnetworksolos' => 'how many network solos a pro member gets as a signup bonus',
        'promonthlybonustextads' => 'how many bonus text ads a pro member gets per month',
        'promonthlybonusbannerspaid' => 'how many bonus paid banner ads a pro member gets per month',
        'promonthlybonusnetworksolos' => 'how many bonus network solos a pro member gets per month',
        'goldsignupbonustextads' => 'how many text ads a gold member gets as a signup bonus',
        'goldsignupbonusbannerspaid' => 'how many paid banners a gold member gets as a signup bonus',
        'goldsignupbonusnetworksolos' => 'how many network solos a gold member gets as a signup bonus',
        'goldmonthlybonustextads' => 'how many bonus text ads a gold member gets per month',
        'goldmonthlybonusbannerspaid' => 'how many bonus paid banner ads a gold member gets per month',
        'goldmonthlybonusnetworksolos' => 'how many bonus network solos a gold member gets per month'
    ];

    public function validateAll(array $post)
    {

        $errors = '';

        $errors = $this->checkLength($post, $errors);

        if (isset($post['username'])) {

            if (isset($post['addmember']) || isset($post['adminaddmember']) || isset($post['savemember']) || isset($post['register'])) {

                # if a username was submitted for registration or added in admin, does it already exist in the system?
                $errors = $this->checkUsernameDuplicates($post['username'], $errors);
            } elseif (isset($post['addtransaction']) || isset($post['savetransaction']) || isset($post['createad']) || isset($post['savead'])) {

                # if a username was submitted to add a transaction for them, that username should already exist in the system.
                $errors = $this->checkUserExists($post['username'], 'username', $errors);
            }
        }
        if (isset($post['password']) && isset($post['confirm_password'])) {

            # if password fields were submitted, are they the same?
            $errors = $this->checkPasswordsMatch($post['password'], $post['confirm_password'], $errors);
        }
        if (isset($post['adminpass']) && isset($post['confirm_adminpass'])) {

            # if admin password fields were submitted, are they the same?
            $errors = $this->checkPasswordsMatch($post['adminpass'], $post['confirm_adminpass'], $errors);
        }
        if (isset($post['referid'])) {

            # if a referid was submitted, does it exist?
            $errors = $this->checkReferidExists($post['referid'], $errors);
        }
        if (isset($post['type'])) {

            # A promotional ad was created or saved.
            $errors = $this->checkPromotionalValidation($post, $errors);
        }
        if (isset($post['downloadtype'])) {

            # A download was created or saved.
            $errors = $this->checkDownloadValidation($post, $errors);
        }
        if (!empty($errors)) {

            return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>" . $errors . "</strong></div>";
        } else {

            return;
        }
    }


    # check the size limitations for each variable that was submitted.
    public function checkLength(array $post, string $errors)
    {

        foreach ($post as $varname => $varvalue) {

            # user's username, password, confirm_password.
            # admin's username, password, confirm_password, sitename.
            # admin money area's transaction.

            if (array_key_exists($varname, self::PRETTY_VARNAMES)) {

                $pretty_varname = self::PRETTY_VARNAMES[$varname];
            } else {

                $pretty_varname = $varname;
            }

            if (
                $varname === 'username' || $varname === 'password' || $varname === 'confirm_password' ||
                $varname === 'adminuser' || $varname === 'adminpass' || $varname === 'confirm_adminpass'
                || $varname === 'sitename' || $varname === 'transaction'
            ) {

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_STRING);
                $numchars = strlen($varvalue);

                if ($numchars < 5) {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " must be 5 or more characters.</strong></div>";
                } elseif ($numchars === 0) {

                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                } elseif ($numchars > 50) {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " must be 50 or less characters.</strong></div>";
                }
            } elseif (
                $varname === 'firstname' || $varname === 'lastname' || $varname === 'name' || $varname === 'subject' || $varname === 'country' ||
                $varname === 'adminname' || $varname === 'downloadname'
            ) {

                # user's firstname, lastname.
                # user's country.
                # ad's name.
                # admin email's subject.
                # admin's name.
                # page name.
                # promotional ad's name.
                # download name.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_STRING);
                $numchars = strlen($varvalue);

                if ($numchars === 0) {

                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                } elseif ($numchars > 50) {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " must be 50 or less characters.</strong></div>";
                }
            } elseif ($varname === 'title' || $varname === 'slug') {

                # ad's title.
                # page slug.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_STRING);
                $numchars = strlen($varvalue);

                if ($numchars === 0) {

                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                } elseif ($numchars > 12) {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " must be 12 or less characters.</strong></div>";
                }
            } elseif ($varname === 'description') {

                # ad's description.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_STRING);
                $numchars = strlen($varvalue);

                if (empty($varvalue)) {

                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                } elseif ($numchars > 20) {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " must be 20 or less characters.</strong></div>";
                }
            } elseif ($varname === 'message' || $varname === 'question' || $varname === 'answer' || $varname === 'downloaddescription') {

                # admin email message body.
                # faq question or answer.
                # download description.

                if (empty($varvalue)) {

                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                }
            } elseif ($varname === 'email' || $varname === 'adminemail') {

                # user's or admin's email address.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_EMAIL);
                $numchars = strlen($varvalue);

                if ($numchars === 0) {

                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                } elseif ($numchars < 8) {

                    $errors .= "<div><strong>" . $pretty_varname . " must be 8 or more characters.</strong></div>";
                } elseif ($numchars > 300) {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " must be 300 or less characters.</strong></div>";
                } elseif (!filter_var($varvalue, FILTER_VALIDATE_EMAIL)) {

                    $errors .= "<div><strong>The value of " . $pretty_varname . " must be a valid email address.</strong></div>";
                }
            } elseif ($varname === 'paypal' || $varname === 'adminpaypal' || $varname === 'admincoinpayments' || $varname === 'downloadsfolder') {

                # user's or admin's paypal email or coinpayments key.
                # the path to the downloads folder.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_EMAIL);
                $numchars = strlen($varvalue);

                if ($varvalue !== '') {
                    if ($numchars === 0) {

                        $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                    } elseif ($numchars < 8) {

                        $errors .= "<div><strong>" . $pretty_varname . " must be 8 or more characters.</strong></div>";
                    } elseif ($numchars > 300) {

                        $errors .= "<div><strong>The size of " . $pretty_varname . " must be 300 or less characters.</strong></div>";
                    } elseif (!filter_var($varvalue, FILTER_VALIDATE_EMAIL) && $varname !== 'admincoinpayments' && $varname !== 'downloadsfolder') {

                        $errors .= "<div><strong>The value of " . $pretty_varname . " must be a valid email address.</strong></div>";
                    }
                }
            } elseif ($varname === 'url' || $varname === 'imageurl' || $varname === 'domain') {

                # ad's url or image url.
                # admin's emailed url.
                # admin setting's domain.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_URL);
                $numchars = strlen($varvalue);

                if ($numchars === 0) {

                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                } elseif ($numchars < 8) {

                    $errors .= "<div><strong>" . $pretty_varname . " must be 8 or more characters.</strong></div>";
                } elseif ($numchars > 300) {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " must be 300 or less characters.</strong></div>";
                } elseif (!filter_var($varvalue, FILTER_VALIDATE_URL)) {

                    $errors .= "<div><strong>The value of " . $pretty_varname . " must be a valid URL.</strong></div>";
                }
            } elseif ($varname === 'metadescription' || $varname === 'metatitle') {

                # meta description for site.
                $varvalue = filter_var($varvalue, FILTER_SANITIZE_URL);
                $numchars = strlen($varvalue);
                if ($numchars === 0) {

                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                } elseif ($numchars < 8) {

                    $errors .= "<div><strong>" . $pretty_varname . " must be 8 or more characters.</strong></div>";
                } elseif ($numchars >= 160 && $varname === 'metadescription') {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " should always be 160 or less characters for best SEO practices.</strong></div>";
                } elseif ($numchars >= 60 && $varname === 'metatitle') {

                    $errors .= "<div><strong>The size of " . $pretty_varname . " should always be 60 or less characters for best SEO practices.</strong></div>";
                }
            } elseif ($varname === 'type') {

                # whether a promotional ad is a banner or email.
                if ($varvalue !== 'banner' && $varvalue !== 'email') {

                    $errors .= "<div><strong>The type of promotional ad resource must be either a banner or an email.</strong></div>";
                }
            } elseif ($varname === 'downloadtype') {

                # whether a download is a link or a file.
                if ($varvalue !== 'link' && $varvalue !== 'file') {

                    $errors .= "<div><strong>The type of download must be either a link or an file.</strong></div>";
                }
            } elseif ($varname === 'adminautoapprove') {

                # make sure the flag to auto-approve ads are boolean values.

                if ($varvalue !== '0' && $varvalue !== '1') {

                    $errors .= "<div><strong>The value " . $pretty_varname . " must be Yes or No. </strong></div>";
                }
            } elseif (stripos($varname, "adclickstoget") !== false || stripos($varname, "monthlybonus") !== false || stripos($varname, "signupbonus") !== false || stripos($varname, "bannerclickstosignup") !== false  || $varname === 'positionnumber') {

                # make sure that the number of ads clicked to get a free ad is an integer greater than or equal to 0 (0 means disabled).
                if ($varvalue < 0) {

                    $errors .= "<div><strong>The value of " . $pretty_varname . " must be an integer greater than or equal to 0. </strong></div>";
                }
            } elseif ($varname === 'signupip') {

                # admin area signupip for members.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_STRING);

                if (!filter_var($varvalue, FILTER_VALIDATE_IP)) {

                    $errors .= "<div><strong>The value of " . $pretty_varname . " must be an IP address. </strong></div>";
                }
            } elseif ($varname === 'id' || $varname === 'textadhits' || $varname === 'bannerhits') {

                # any posted id value for a database record.
                # number of hits for sold banners or textads.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_NUMBER_INT);

                if (!filter_var($varvalue, FILTER_VALIDATE_INT) || $varvalue <= 0) {

                    $errors .= "<div><strong>The value of " . $pretty_varname . " must be an integer greater than 0. </strong></div>";
                }
            } elseif ($varname === 'amount' || $varname === 'textadprice' || $varname === 'bannnerprice' || $varname === 'networksoloprice' || $varname === 'proprice' || $varname === 'goldprice' || $varname === 'freerefersproearn' || $varname === 'freerefersgoldearn' || $varname === 'prorefersproearn' || $varname === 'prorefersgoldearn' || $varname === 'goldrefersproearn' || $varname === 'goldrefersgoldearn') {

                # amount owed to a recipient in the transactions money table.
                # prices for different kinds of advertising.
                # prices for pro or gold membership.
                # referral earnings.

                $varvalue = filter_var($varvalue, FILTER_SANITIZE_NUMBER_FLOAT);

                if (!filter_var($varvalue, FILTER_VALIDATE_FLOAT)) {

                    $errors .= "<div><strong>The value of " . $pretty_varname . " must be a dollar figure (optionally with a decimal i.e. 5.42). </strong></div>";
                }
            } elseif ($varname === 'propayinterval' || $varname === 'goldpayinterval') {
                if ($varvalue !== 'lifetime' && $varvalue !== 'monthly' && $varvalue !== 'annually') {

                    # payment intervals for pro or gold membership.
                    $errors .= "<div><strong>The value of " . $pretty_varname . " needs to be either lifetime, monthly, or annually. </strong></div>";
                }
            }
        }

        return $errors;
    }

    # validate promotional ads separately because some fields should be blank depending on type of ad.
    public function checkPromotionalValidation(array $post, string $errors)
    {

        if (!isset($post['type'])) {

            # check for promotional ad type.
            $pretty_varname = self::PRETTY_VARNAMES['type'];
            $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
        } else {

            $type = $post['type'];

            # check for promotional ad name field.
            if (!isset($post['name'])) {

                $pretty_varname = self::PRETTY_VARNAMES['name'];
                $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
            } else {

                $name = $post['name'];
            }

            # check fields dependent on promotional ad type.
            if ($type === 'banner') {

                if (isset($post['promotionalimage'])) {

                    $pretty_varname = self::PRETTY_VARNAMES['promotionalimage'];
                    $promotionalimage = $post['promotionalimage'];

                    $promotionalimage = filter_var($promotionalimage, FILTER_SANITIZE_URL);
                    $numchars = strlen($promotionalimage);

                    if ($numchars === 0) {

                        $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                    } elseif ($numchars < 8) {

                        $errors .= "<div><strong>" . $pretty_varname . " must be 8 or more characters.</strong></div>";
                    } elseif ($numchars > 300) {

                        $errors .= "<div><strong>The size of " . $pretty_varname . " must be 300 or less characters.</strong></div>";
                    } elseif (!filter_var($promotionalimage, FILTER_VALIDATE_URL)) {

                        $errors .= "<div><strong>The value of " . $pretty_varname . " must be a valid URL.</strong></div>";
                    }
                } else {

                    $pretty_varname = self::PRETTY_VARNAMES['promotionalimage'];
                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                }
            } elseif ($type === 'email') {

                if (isset($post['promotionalsubject'])) {

                    $pretty_varname = self::PRETTY_VARNAMES['promotionalsubject'];

                    $promotionalsubject = $post['promotionalsubject'];
                    $promotionalsubject = filter_var($promotionalsubject, FILTER_SANITIZE_STRING);
                    $numchars = strlen($promotionalsubject);

                    if ($numchars === 0) {

                        $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                    } elseif ($numchars > 50) {

                        $errors .= "<div><strong>The size of " . $pretty_varname . " must be 50 or less characters.</strong></div>";
                    }
                } else {

                    $pretty_varname = self::PRETTY_VARNAMES['promotionalsubject'];
                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                }

                if (isset($post['promotionaladbody'])) {

                    $pretty_varname = self::PRETTY_VARNAMES['promotionaladbody'];

                    $promotionaladbody = $post['promotionaladbody'];

                    if (empty($promotionaladbody)) {

                        $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                    }
                } else {

                    $pretty_varname = self::PRETTY_VARNAMES['promotionaladbody'];
                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                }
            }
        }

        return $errors;
    }




    # validate downloads separately because some fields should be blank depending on type of ad.
    public function checkDownloadValidation(array $post, string $errors)
    {

        if (!isset($post['downloadtype'])) {

            # check for download type.
            $pretty_varname = self::PRETTY_VARNAMES['downloadtype'];
            $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
        } else {

            $downloadtype = $post['downloadtype'];

            # check for download name field.
            if (!isset($post['downloadname'])) {

                $pretty_varname = self::PRETTY_VARNAMES['downloadname'];
                $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
            }

            # check fields dependent on download type.
            if ($downloadtype === 'link') {

                if (isset($post['downloadurl'])) {

                    $pretty_varname = self::PRETTY_VARNAMES['downloadurl'];
                    $downloadurl = $post['downloadurl'];

                    $downloadurl = filter_var($downloadurl, FILTER_SANITIZE_URL);
                    $numchars = strlen($downloadurl);

                    if ($numchars === 0) {

                        $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                    } elseif ($numchars < 8) {

                        $errors .= "<div><strong>" . $pretty_varname . " must be 8 or more characters.</strong></div>";
                    } elseif ($numchars > 300) {

                        $errors .= "<div><strong>The size of " . $pretty_varname . " must be 300 or less characters.</strong></div>";
                    } elseif (!filter_var($downloadurl, FILTER_VALIDATE_URL)) {

                        $errors .= "<div><strong>The value of " . $pretty_varname . " must be a valid URL.</strong></div>";
                    }
                } else {

                    $pretty_varname = self::PRETTY_VARNAMES['downloadurl'];
                    $errors .= "<div><strong>" . $pretty_varname . " cannot be blank.</strong></div>";
                }
            } elseif ($downloadtype === 'file') {

                $downloadfile_name = $_FILES['downloadfile']['name'];
                $downloadfile_name = filter_var($downloadfile_name, FILTER_SANITIZE_STRING);
                $pretty_varname = self::PRETTY_VARNAMES['downloadfile'];
                $filenamesize = strlen($downloadfile_name);

                if (isset($_POST['adddownload'])) {

                    if ($filenamesize === 0) {
                        // File upload was empty.
                        $errors .= "<div><strong>You need to include a " . $pretty_varname . ".</strong></div>";
                    }
                } else {

                    if ($filenamesize === 0 && empty($post['olddownloadfile'])) {
                        // File upload was empty BUT there was no old filename. The admin either forgot to include a file upload
                        // when saving OR didn't include a file upload after changing a link type download to a file type.
                        $errors .= "<div><strong>You need to include a " . $pretty_varname . ".</strong></div>"; 
                    }
                }
            }
        }

        return $errors;
    }


    # check if a username/recipient/referid exists.
    public function invalidMemberCheck(string $username, string $errors)
    {

        # create db connection.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from members where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetch();
        if (empty($data)) {

            # username does not exist.
            $errors .= "<div><strong>The username you entered, " . $username . " does not exist yet. Please sign them up first before adding to their account.</strong></div>";
        }

        return $errors;
    }

    # make sure the new username isn't already in the database.
    public function checkUsernameDuplicates(string $username, string $errors)
    {

        # create db connection.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from members where username=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetch();
        if (!empty($data['username']) && $data['username'] === $username) {
            $errors .= "<div><strong>The username you chose isn't available.</strong></div>";
        }

        return $errors;
    }

    # make sure that password and confirm password match.
    public function checkPasswordsMatch(string $password, string $confirm, string $errors)
    {

        if ($password !== $confirm) {

            $errors .= "<div><strong>Your passwords do not match.</strong></div>";
        }

        return $errors;
    }

    # make sure that a non-admin referring member exists in the database.
    public function checkReferidExists(string $referid, string $errors)
    {

        if ($referid !== 'admin') {

            # create db connection.
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from members where username=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($referid));
            $q->setFetchMode(PDO::FETCH_ASSOC);
            $data = $q->fetch();
            if (empty($data['referid'])) {

                $errors .= "<div><strong>The sponsor you entered does not exist in the system. Please check your spelling, or please just use 'admin' in the field if you are unsure.</strong></div>";
            }
        }

        return $errors;
    }

    # make sure that a user exists in the system.
    public function checkUserExists(string $username, string $usertype, string $errors)
    {

        if ($username !== 'admin') {

            # create db connection.
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from members where username=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($username));
            $q->setFetchMode(PDO::FETCH_ASSOC);
            $data = $q->fetch();
            if (empty($data['username'])) {

                $errors .= "<div><strong>The " . $usertype . " you entered does not exist in the system. Please check the spelling.</strong></div>";
            }
        }

        return $errors;
    }

    # close database connection.
    public function __destruct()
    {

        Database::disconnect();
    }
}
