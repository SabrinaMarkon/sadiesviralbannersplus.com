<?php
/**
Controller for Banner Maker app.
PHP 7.4+
@author Sabrina Markon
@copyright 2021 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

class BannerMaker {

    /**
     * Show all banners a username made with the Banner Maker.
     * @param $username is the username of the member we want to get saved banners for.
     * @return $savedimages is the array of banners returned by the database query.
     */
    public function getAllUsernamesBannerMakerBanners(string $username): array {
    
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from bannermaker where username=? order by approved asc, id desc";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $savedimages = $q->fetchAll();

        $today = date("YmdHis");
        // Get the image library tree.
        $directory = "images/thumbnails";
        $foldertree = $this->folderTree($directory);

        Database::disconnect();

        return $savedimages;
    }

    /** Get any subfolders of the folder.
     * @param $topdir is the top root directory.
     * @return $subdirs are the subdirectories of the topdir root directory.
     */
    public function getSubdirectories(string $topdir): array {
        $subdirs = File::directories($topdir); // TODO: Fix this (not Laravel here)
        return $subdirs;
    }

    /**
     * Build the list of directories for the image library folder select box.
     * @param $directory is the top root directory.
     * @return $foldertree is the list of all directories in root with their subdirectories for the select box.
     */
    public function folderTree(string $directory): string {
        $foldertree = '';
        $dirs = $this->getSubdirectories($directory);
        foreach ($dirs as $dir) {
            $show_dir_array = explode('thumbnails/', $dir);
            $show_dir = $show_dir_array[1];
            $foldertree .= '<option value="' . $show_dir . '">' . $show_dir . '</option>';
//            // get any subdirs of dir:
//            $dirs2 = $this->getSubdirectories($dir);
//            foreach ($dirs2 as $dir2) {
//                $show_dir_array2 = explode('thumbnails/', $dir2);
//                $show_dir2 = $show_dir_array2[1];
//                $foldertree .=  '<option value="' . $show_dir2 . '">' . $show_dir2 . '</option>';
//            }
        }
        return $foldertree;
    }

    
}