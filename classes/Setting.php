<?php
/**
Handles admin changing site settings.
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

class Setting
{

    public function saveSettings($adminuser, $adminpass) {

        $newadminuser = $_POST['adminuser'];
        $newadminpass = $_POST['adminpass'];
        $newadminname = $_POST['adminname'];
        $newadminemail = $_POST['adminemail'];
        $newadminpaypal = $_POST['adminpaypal'];
        $newsitename = $_POST['sitename'];
        $newdomain = $_POST['domain'];
        $newmetadescription = $_POST['metadescription'];
        $newmetatitle = $_POST['metatitle'];
        $newadminautoapprove = $_POST['adminautoapprove'];
        $newadclickstogetad = $_POST['adclickstogetad'];
        $newproprice = $_POST['proprice'];
        $newpropayinterval = $_POST['propayinterval'];
        $newgoldprice = $_POST['proprice'];
        $newgoldpayinterval = $_POST['propayinterval'];

        # if either username or password changed, update session.
        if (($adminuser !== $newadminuser) or ($adminpass !== $newadminpass)) {
            
            $_SESSION['adminusername'] = $newadminuser;
            $_SESSION['adminpassword'] = $newadminpass;
        }

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "update adminsettings set adminuser=?, adminpass=?, adminname=?, adminemail=?, adminpaypal=?, sitename=?, 
        domain=?, metadescription=?, metatitle=?, adminautoapprove=?, adclickstogetad=?, proprice=?, propayinterval=?, goldprice=?, goldpayinterval=?";
        $q = $pdo->prepare($sql);
        $q-> execute(array($newadminuser, $newadminpass, $newadminname, $newadminemail, $newadminpaypal, $newsitename, 
        $newdomain, $newmetadescription, $newmetatitle, $newadminautoapprove, $newadclickstogetad, $newproprice, $newpropayinterval, $newgoldprice, $newgoldpayinterval));
        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Site Settings Were Saved!</strong></div>";
    }

}