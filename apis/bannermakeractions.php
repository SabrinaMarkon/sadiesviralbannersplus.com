
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
require_once('../config/Database.php');
require_once('../classes/BannerMaker.php');
$bannermaker = new BannerMaker();

if (!empty($_POST) && empty($_FILES)) {
    
    $action = '';
    $id = '';
    if (!empty($_POST['action']) && !empty($_POST['id'])) {

        $action = $_POST['action'];
        $id = $_POST['id'];
    
        if ($action === 'delete' && !empty($id)) {
            echo $bannermaker->deleteBanner($id);
        }
        elseif ($action === 'edit' && !empty($id)) {
            $banner = $bannermaker->showBanner($id);
            echo json_encode($banner);
        }
        else {
            echo "Missing data";
        }
    } else {
        echo "Nothing posted";
    }

} elseif (!empty($_FILES['imageuploads']['name'])) {

    // print_r($_FILES['imageuploads']);

    $username = $_POST['username'];
    $imageuploads = $_FILES['imageuploads']['name'];

    $uploadresult = $bannermaker->uploadImages($username, $imageuploads);

    echo $uploadresult;

} else {
    echo "Error: No data was posted or uploaded.";
}