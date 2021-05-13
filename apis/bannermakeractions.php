
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
 * Get the images for the folder the username selects from the dropdown in the Banner Maker app.
 * OR get the usernames's own uploaded image list from the myimages folder.
 * OR delete one of the user's banners in the Banner Maker.
 * OR edit one of the username's banners in the Banner Maker.
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
if (!empty($_POST)) {
    
    $action = $_POST['action'];
    $id = $_POST['id'];

    require_once('../config/Database.php');
    require_once('../classes/BannerMaker.php');
    $bannermaker = new BannerMaker();

    if ($action === 'delete') {
        echo $bannermaker->deleteBanner($id);
    }
    elseif ($action === 'edit') {
        $banner = $bannermaker->showBanner($id);
        echo json_encode($banner);
    }
    else {
        print_r($_POST);
    }
} else {
    echo "duh";
}