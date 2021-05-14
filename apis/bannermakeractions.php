
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
    $numberofimages = count($imageuploads);

    for ($i = 0; $i < $numberofimages; $i++) {

        // Data for each uploaded image file:
        $image_name = $_FILES['imageuploads']['name'][$i];
        $image_extension = explode(".", $image_name)[1];
        $image_type = $_FILES['imageuploads']['type'][$i]; // mime type (ie. image/jpeg).
        $image_tmp_name = $_FILES['imageuploads']['tmp_name'][$i]; // server temp filename (ie. /tmp/phpuI8wMW).
        $image_error = $_FILES['imageuploads']['error'][$i]; // 0 if no error.
        $image_size = $_FILES['imageuploads']['size'][$i];

        // SERVER-SIDE VALIDATION (JS does client side before this point as well)


        // UPLOAD FILE NOW:

        //Save the image with a random filename.
        $filenamelong = md5(rand(0,9999999));
        $filenameshort = substr($filenamelong, 0, 12);
        $today = date("YmdHis");
        $filename = $today . $filenameshort . "." . $image_extension;
        $filepath = '../myimages/' . $filename;

        // write the file to the server.
        $uploaded = move_uploaded_file($image_tmp_name, $filepath);

        // Save image into the bannermakerimageuploads database table.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into bannermakerimageuploads (username, filename, filesize, filetype, adddate) values (?, ?, ?, ?, NOW())";
        $q = $pdo->prepare($sql);
        $q->execute(array($username, $filename, $image_size, $image_type));

        Database::disconnect();
    }

} else {
    echo "Error: No data was posted or uploaded.";
}