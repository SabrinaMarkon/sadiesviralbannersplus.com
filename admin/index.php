<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
if (!isset($_SESSION)) {
    session_start();
}
require_once "../config/Database.php";
require_once "../config/Settings.php";
require_once "../config/Layout.php";

function autoloader($class)
{
    require '../classes/' . $class . ".php";
}
spl_autoload_register("autoloader");

# get main site settings.
$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value) {
    $$key = $value;
}

# id variable is for the id of a single member, mail, etc. to update in the database.
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
} else {
    $id = "";
}

# get the Layout template.
$Layout = new Layout();

$show = '';
$errors = '';

# get the form validation class instance to use for all the pages that post.
if (isset($_POST)) {

    $formvalidation = new FormValidation($_POST);
}

if (isset($_POST['login'])) {

    # admin clicked the login button.

    $_SESSION['adminusername'] = $_REQUEST['adminuser'];
    $_SESSION['adminpassword'] = $_REQUEST['adminpass'];

    $logincheck = new Admin($_POST);
    $newlogin = $logincheck->adminLogin($_SESSION['adminusername'], $_SESSION['adminpassword']);

    if ($newlogin === false) {

        # failed login.
        $logout = new Admin();
        $logout->adminLogout();
        $Layout->showHeader($metatitle, $metadescription);
        $showcontent = new AdminLoginForm();
        echo $showcontent->showLoginForm(1);
        $Layout->showFooter();
        exit;
    } else {

        # successful admin login. Show the admin menu (in the header if the session vars are present).
        $Layout->showHeader($metatitle, $metadescription);
        $showgravatar = $logincheck->getGravatar($adminemail);
        include 'main.php';
        $Layout->showFooter();
        exit;
    }
} else {

    if (isset($_POST['saveadminnotes'])) {

        # admin clicked to save the admin notes.
        $update = new AdminNote();
        $show = $update->setAdminNote($_POST['htmlcode']);
    }

    if (isset($_POST['savesettings'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin clicked the button to save main settings.
            $update = new Setting();
            if (isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword'])) {
                $show = $update->saveSettings($_SESSION['adminusername'], $_SESSION['adminpassword']);
            } else {
                # failed login.
                $logout = new Admin();
                $logout->adminLogout();
                $Layout->showHeader($metatitle, $metadescription);
                $showcontent = new AdminLoginForm();
                echo $showcontent->showLoginForm(1);
                $Layout->showFooter();
                exit;
            }
        }
    }

    if (isset($_POST['editmail'])) {

        # admin clicked to edit a saved email.
        $editmail = new Mail();
        $showeditmail = $editmail->editMail($id);
    }

    if (isset($_POST['addmail'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin added a new email.
            $update = new Mail();
            $show = $update->addMail($_POST);
        }
    }

    if (isset($_POST['savemail'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin saved an existing email they were editing. 
            $update = new Mail();
            $show = $update->saveMail($_POST);
        }
    }

    if (isset($_POST['sendverifications'])) {

        # admin resent verification emails to all unverified members.
        $verify = new Mail();
        $show = $verify->sendVerifications($settings);
    }

    if (isset($_POST['deletemail'])) {

        # admin deleted an email.
        $delete = new Mail();
        $show = $delete->deleteMail($id);
    }

    if (isset($_POST['sendmail'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin clicked to send an email.
            $send = new Mail();
            $show = $send->sendMail($_POST);
        }
    }

    if (isset($_POST['editpage'])) {

        # admin selected an existing page to edit.
        $editpage = new Page();
        $showeditpage = $editpage->editPage($id);
    }

    if (isset($_POST['addpage'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin added a new page.
            $update = new Page();
            $show = $update->addPage($domain);
        }
    }

    if (isset($_POST['savepage'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin saved a page they were editing.
            $update = new Page();
            $show = $update->savePage($id);
        }
    }

    if (isset($_POST['deletepage'])) {

        # admin deleted a page.
        $delete = new Page();
        $show = $delete->deletePage($id);
    }

    if (isset($_POST['createfaq'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin added a new faq.
            $add = new Faq();
            $show = $add->createFaq($_POST);
        }
    }

    if (isset($_POST['savefaq'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin edited and saved an faq.
            $update = new Faq();
            $show = $update->saveFaq($_POST);
        }
    }

    if (isset($_POST['deletefaq'])) {

        # admin deleted an faq.
        $delete = new Faq();
        $show = $delete->deleteFaq($id);
    }


    if (isset($_POST['givedownload'])) {

        # admin gave one or more downloads to a specific member.
        $give = new Download();
        $show = $give->giveDownload($_POST);
    }

    if (isset($_POST['adddownload'])) {

        // print_r($_FILES);
        // exit;

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin added a new download.
            $add = new Download();
            $show = $add->addDownload($_POST);
        }
    }

    if (isset($_POST['savedownload'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin edited and saved a download.
            $update = new Download();
            $show = $update->saveDownload($_POST);
        }
    }

    if (isset($_POST['deletedownload'])) {

        # admin deleted a downloads.
        $delete = new Download();
        $show = $delete->deleteDownload($_POST);
    }


    if (isset($_POST['adminaddmember'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin added a new member.
            $add = new Member();
            $show = $add->addMember($settings);
        }
    }

    if (isset($_POST['adminsavemember'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin saved a member they edited.
            $update = new Member();
            $show = $update->saveMember($id);
        }
    }

    if (isset($_POST['admindeletemember'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin deleted a member and their ads and positions.
            $delete = new Member();
            $show = $delete->deleteMember($id);
        }
    }

    if (isset($_POST['addtransaction'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin added a new transaction (invoice).
            $create = new Money();
            $show = $create->addTransaction($_POST);
        }
    }

    if (isset($_POST['savetransaction'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin saved a transaction they were editing.
            $update = new Money();
            $show = $update->saveTransaction($id);
        }
    }

    if (isset($_POST['deletetransaction'])) {

        # admin deleted a transaction.
        $delete = new Money();
        $show = $delete->deleteTransaction($id);
    }

    if (isset($_POST['addpromotional'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin added a new promotional ad.
            $add = new Promotional();
            $show = $add->addPromotional($_POST);
        }
    }

    if (isset($_POST['savepromotional'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $show = $errors;
        } else {

            # admin saved a promotional ad they edited.
            $update = new Promotional();
            $show = $update->savePromotional($id, $_POST);
        }
    }

    if (isset($_POST['deletepromotional'])) {

        # admin deleted a promotional ad
        $delete = new Promotional();
        $show = $delete->deletePromotional($id);
    }

    if (isset($_POST['saveadsettings'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $showad = $errors;
        } else {

            # admin clicked the button to save main settings.
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
                $showad = $ad->saveAdSettings($_POST);
            }
        }
    }

    if (isset($_POST['givememberblankad'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $showad = $errors;
        } else {

            # give a user one or more blank ads from admin.
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
            }
            if ($ad) {
                if (isset($_POST['givememberblankad'])) {

                    $givememberblankad = $_POST['givememberblankad'];
                    for ($i = 1; $i <= $givememberblankad; $i++) {

                        $showad = $ad->createBlankAd($_POST['username'], $givememberblankad);
                    }
                } else {
                    $showad = $ad->createBlankAd($_POST['username'], '');
                }                
            }
        }
    }

    if (isset($_POST['createad'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $showad = $errors;
        } else {

            # user submitted a new ad.
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
                $showad = $ad->createAd($id, $adminautoapprove, 'admin', $_POST);
            }
        }
    }

    if (isset($_POST['savead'])) {

        $errors = $formvalidation->validateAll($_POST);
        if (!empty($errors)) {

            $showad = $errors;
        } else {

            # user saved changes made to their ad.
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
            }
            if ($ad) {
                $showad = $ad->saveAd($id, $adminautoapprove, 1, $_POST);
            }
        }
    }

    if (isset($_POST['deletead'])) {
        $adtable = $_POST['adtable'];
        $delete = new Ad($adtable);
        $showad = $delete->deleteAd($id, $_POST['name']);
    }

    if ((empty($_REQUEST['page'])) or
        ((!empty($_REQUEST['page']) and ($_REQUEST['page'] === 'index' or $_REQUEST['page'] === 'logout' or $_REQUEST['page'] === 'forgot' or $_REQUEST['page'] === 'control'))) or
        ((!empty($_GET['page'])) and ((!file_exists($_GET['page'] . ".php"))))
    ) {

        # 1 - the URL is simply /admin without a /page on the end, so just go to the login form.
        # 2 - OR the URL has a page like /admin/page, but that page is /admin/index (this file).
        # 3 - OR the URL has a page like /admin/page, but that page is /admin/logout.
        # 4 - OR the URL has a page like /admin/page, but that page is /admin/forgot (which doesn't have its own view. It sends an email than shows the login form again).
        # 5 - OR a page was requested like /admin/page, but the filename to match does not exist ie. /admin/blahblah.
        # 6 - OR the session control.php file was requested.
        ### going to admin/index (this file) or /admin/logout or /admin/forgot or /admin/adfadsfadslkjal or /admin/control is the same as going to admin/ and killing the login session.
        $logout = new Admin();
        $logout->adminLogout();
        $showcontent = new AdminLoginForm();

        $Layout->showHeader($metatitle, $metadescription);

        # admin clicked the forgotten password link.
        if ((!empty($_REQUEST['page']) and $_REQUEST['page'] === 'forgot')) {

            # we need to email the forgotten login details, and say so before we show the login form.
            echo $logout->forgotLogin($sitename, $domain, $adminemail, $adminuser, $adminpass);
        }

        echo $showcontent->showLoginForm(0);
    } elseif ((!empty($_GET['page'])) and ((file_exists($_GET['page'] . ".php")))) {

        # there is a page.php that exists, and is not /admin/index (this file) or /admin/logout or /admin/forgot or some non-existent file. 
        $Layout->showHeader($metatitle, $metadescription);
        $page = $_REQUEST['page'];
        include $page . ".php";
    } else {

        # show the main admin area page because everything was ok to login, but no specific admin page was specified in the request.
        $Layout->showHeader($metatitle, $metadescription);
        include "main.php";
    }

    # show the admin footer design.
    $Layout->showFooter();
}





// IGNORE BELOW for now (works without but it would be nicer is all)
// REFACTOR LATER to make better routes etc.
// BASICALLY I NEED TO un-Spaghettify this file...
//if (isset($_POST['_method'])) {
//
//    $_method = $_POST['_method'];
//    if($_method === 'DELETE') {
//
//        $delete = new Money();
//        $showdelete = $delete->deleteTransaction($id);
//
//    }
//    elseif($_method === 'PATCH')
//    {
//
//        $update = new Money();
//        $show = $update->saveTransaction($id);
//    }
//}

######################################