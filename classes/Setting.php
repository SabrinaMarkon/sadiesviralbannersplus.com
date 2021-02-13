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

    public function saveSettings(string $adminuser, string $adminpass)
    {


        $newadminuser = $_POST['adminuser'];
        $newadminpass = $_POST['adminpass'];
        $newadminname = $_POST['adminname'];
        $newadminemail = $_POST['adminemail'];
        $newadminpaypal = $_POST['adminpaypal'];
        $newadmincoinpayments = $_POST['admincoinpayments'];
        $newsitename = $_POST['sitename'];
        $newdomain = $_POST['domain'];
        $newmetadescription = $_POST['metadescription'];
        $newmetatitle = $_POST['metatitle'];
        $newadminautoapprove = $_POST['adminautoapprove'];
        $newproprice = $_POST['proprice'];
        $newpropayinterval = $_POST['propayinterval'];
        $newgoldprice = $_POST['goldprice'];
        $newgoldpayinterval = $_POST['goldpayinterval'];
        $newfreerefersproearn = $_POST['freerefersproearn'];
        $newfreerefersgoldearn = $_POST['freerefersgoldearn'];
        $newfreeadclickstogettextad = $_POST['freeadclickstogettextad'];
        $newfreeadclickstogetbannerspaid = $_POST['freeadclickstogetbannerspaid'];
        $newfreeadclickstogetnetworksolo = $_POST['freeadclickstogetnetworksolo'];
        $newprorefersproearn = $_POST['prorefersproearn'];
        $newprorefersgoldearn = $_POST['prorefersgoldearn'];
        $newproadclickstogettextad = $_POST['proadclickstogettextad'];
        $newproadclickstogetbannerspaid = $_POST['proadclickstogetbannerspaid'];
        $newproadclickstogetnetworksolo = $_POST['proadclickstogetnetworksolo'];
        $newgoldrefersproearn = $_POST['goldrefersproearn'];
        $newgoldrefersgoldearn = $_POST['goldrefersgoldearn'];
        $newgoldadclickstogettextad = $_POST['goldadclickstogettextad'];
        $newgoldadclickstogetbannerspaid = $_POST['goldadclickstogetbannerspaid'];
        $newgoldadclickstogetnetworksolo = $_POST['goldadclickstogetnetworksolo'];
        $newfreesignupbonustextads = $_POST['freesignupbonustextads'];
        $newfreesignupbonusbannerspaid = $_POST['freesignupbonusbannerspaid'];
        $newfreesignupbonusnetworksolos = $_POST['freesignupbonusnetworksolos'];
        $newfreemonthlybonustextads = $_POST['freemonthlybonustextads'];
        $newfreemonthlybonusbannerspaid = $_POST['freemonthlybonusbannerspaid'];
        $newfreemonthlybonusnetworksolos = $_POST['freemonthlybonusnetworksolos'];
        $newprosignupbonustextads = $_POST['prosignupbonustextads'];
        $newprosignupbonusbannerspaid = $_POST['prosignupbonusbannerspaid'];
        $newprosignupbonusnetworksolos = $_POST['prosignupbonusnetworksolos'];
        $newpromonthlybonustextads = $_POST['promonthlybonustextads'];
        $newpromonthlybonusbannerspaid = $_POST['promonthlybonusbannerspaid'];
        $newpromonthlybonusnetworksolos = $_POST['promonthlybonusnetworksolos'];
        $newgoldsignupbonustextads = $_POST['goldsignupbonustextads'];
        $newgoldsignupbonusbannerspaid = $_POST['goldsignupbonusbannerspaid'];
        $newgoldsignupbonusnetworksolos = $_POST['goldsignupbonusnetworksolos'];
        $newgoldmonthlybonustextads = $_POST['goldmonthlybonustextads'];
        $newgoldmonthlybonusbannerspaid = $_POST['goldmonthlybonusbannerspaid'];
        $newgoldmonthlybonusnetworksolos = $_POST['goldmonthlybonusnetworksolos'];

        # if either username or password changed, update session.
        if (($adminuser !== $newadminuser) or ($adminpass !== $newadminpass)) {

            $_SESSION['adminusername'] = $newadminuser;
            $_SESSION['adminpassword'] = $newadminpass;
        }

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Form validation of admin areas called from admin/index.php.

        $sql = "update adminsettings set adminuser=?, adminpass=?, adminname=?, adminemail=?, adminpaypal=?, admincoinpayments=?, sitename=?, 
        domain=?, metadescription=?, metatitle=?, adminautoapprove=?, proprice=?, propayinterval=?, goldprice=?, goldpayinterval=?, freerefersproearn=?, freerefersgoldearn=?, freeadclickstogettextad=?, freeadclickstogetbannerspaid=?, freeadclickstogetnetworksolo=?, prorefersproearn=?, prorefersgoldearn=?, proadclickstogettextad=?, proadclickstogetbannerspaid=?, proadclickstogetnetworksolo=?, goldrefersproearn=?, goldrefersgoldearn=?, goldadclickstogettextad=?, goldadclickstogetbannerspaid=?, goldadclickstogetnetworksolo=?, freesignupbonustextads=?, freesignupbonusbannerspaid=?, freesignupbonusnetworksolos=?, freemonthlybonustextads=?, freemonthlybonusbannerspaid=?, freemonthlybonusnetworksolos=?, prosignupbonustextads=?, prosignupbonusbannerspaid=?, prosignupbonusnetworksolos=?, promonthlybonustextads=?, promonthlybonusbannerspaid=?, promonthlybonusnetworksolos=?, goldsignupbonustextads=?, goldsignupbonusbannerspaid=?, goldsignupbonusnetworksolos=?, goldmonthlybonustextads=?, goldmonthlybonusbannerspaid=?, goldmonthlybonusnetworksolos=?";
        $q = $pdo->prepare($sql);
        $q->execute(array(
            $newadminuser, $newadminpass, $newadminname, $newadminemail, $newadminpaypal, $newadmincoinpayments, $newsitename,
            $newdomain, $newmetadescription, $newmetatitle, $newadminautoapprove, $newproprice, $newpropayinterval, $newgoldprice, $newgoldpayinterval, $newfreerefersproearn, $newfreerefersgoldearn, $newfreeadclickstogettextad, $newfreeadclickstogetbannerspaid, $newfreeadclickstogetnetworksolo, $newprorefersproearn, $newprorefersgoldearn, $newproadclickstogettextad, $newproadclickstogetbannerspaid, $newproadclickstogetnetworksolo, $newgoldrefersproearn, $newgoldrefersgoldearn, $newgoldadclickstogettextad, $newgoldadclickstogetbannerspaid, $newgoldadclickstogetnetworksolo, $newfreesignupbonustextads, $newfreesignupbonusbannerspaid, $newfreesignupbonusnetworksolos, $newfreemonthlybonustextads, $newfreemonthlybonusbannerspaid, $newfreemonthlybonusnetworksolos, $newprosignupbonustextads, $newprosignupbonusbannerspaid, $newprosignupbonusnetworksolos, $newpromonthlybonustextads, $newpromonthlybonusbannerspaid, $newpromonthlybonusnetworksolos, $newgoldsignupbonustextads, $newgoldsignupbonusbannerspaid, $newgoldsignupbonusnetworksolos, $newgoldmonthlybonustextads, $newgoldmonthlybonusbannerspaid, $newgoldmonthlybonusnetworksolos
        ));
        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Site Settings Were Saved!</strong></div>";
    }
}
