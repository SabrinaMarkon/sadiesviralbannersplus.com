<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
 * Get the images for the folder the user selects from the dropdown in the Banner Maker app.
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/

// php://input here is the folder as a property value.
$folder = file_get_contents('php://input');

if (!empty($folder)) {

    require_once('../classes/BannerMaker.php');
    $bannermaker = new BannerMaker();
    echo $bannermaker->fileTree($folder);

}


