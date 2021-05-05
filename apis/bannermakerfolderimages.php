<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
 * Get the images for the folder the user selects from the dropdown in the Banner Maker app OR their own folder uploads
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/

 if (!empty($_POST)) {

    require_once('../config/Database.php');
    require_once('../classes/BannerMaker.php');
    $bannermaker = new BannerMaker();

    if (!empty($_POST['folder'])) {

        $folder = $_POST['folder'];

        if ($folder === 'member') {
            // Username's own image uploads.
            $username = $_POST['username'];
            echo $bannermaker->UsernamesUploadedImagesFileTree($username);

        } else {
            // Normal image folder:
            echo $bannermaker->fileTree($folder);
        }

    }
}