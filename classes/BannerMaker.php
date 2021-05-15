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
     * @param string $username is the username of the member we want to get saved banners for.
     * @return array $savedimages is the array of banners returned by the database query.
     */
    public function getAllBannersForUsername(string $username): array {
    
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from bannermaker where username=? order by width asc, height asc, id desc";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $savedimages = $q->fetchAll();

        Database::disconnect();

        return $savedimages;
    }

    /** Get any subfolders of the folder.
     * @param string $topdir is the top root directory.
     * @return array $subdirs are the subdirectories of the topdir root directory.
     */
    public function getSubdirectories(string $topdir): array {

        $subdirs = array_diff(scandir($topdir), array('..', '.'));
        return $subdirs;
    }

    /**
     * Build the list of directories for the image library folder select box.
     * @param string $directory is the top root directory.
     * @return string $foldertree is the HTML option list of all directories in root with their subdirectories for the select box.
     */
    public function folderTree(string $directory): string {

        $foldertree = '';
        $dirs = $this->getSubdirectories($directory);
        foreach ($dirs as $dir) {
            $foldertree .= '<option value="' . $dir . '">' . $dir . '</option>';
        }
        return $foldertree;
    }

    /**
     * Get the list of files for the image library chooser depending on which category (folder) was chosen.
     * @param string $folder is the chosen image folder.
     * @return string $filetree is the HTML image list of all files in the chosen directory.
     */
    public function fileTree(string $folder): string {

        $folder = "../images/thumbnails/" . $folder;
        $filetree = '';
        $files = array_diff(scandir($folder), array('..', '.'));
        foreach ($files as $file)
        {
            $resize = '';
            // make sure the file is an image.
            $filepartsarray = explode('.', $file);
            $extension = end($filepartsarray);
            $fileidvalue = reset($filepartsarray);
            if ($extension === 'gif' || $extension === 'png' || $extension === 'jpg' || $extension === 'jpeg' || $extension === 'wps' || $extension === 'webp' || $extension === 'svg') {
                $filepath = $folder . '/' . $file;
                $filedata = getimagesize($filepath);
                $width = $filedata[0];
                $height = $filedata[1];
                if ($width > 200) {
                    $resize = ' previewshrink';
                }
                $filetree .= '<img  id="' . $file . '" class="imagepreviewdiv ui-widget-content' . $resize . '" src="' . (string)$filepath . '"><br>';
            }
        }

        return $filetree;
    }

    /**
     * Get the list of files for the image library chooser from the username's own uploaded files.
     * @param string $username is the username whose uploaded files we need to get.
     * @return string $filetree is the HTML image list of all files in the chosen directory.
     */
    public function UsernamesUploadedImagesFileTree(string $username): string {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from bannermakerimageuploads where username=? order by id desc";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $savedimages = $q->fetchAll();

        $uploadedfiletree = '';
        foreach ($savedimages as $savedimage) {

            $file = $savedimage['filename'];
            $folder = "../myimages";
            $resize = '';
            $filepath = $folder . '/' . $file;
            $filedata = getimagesize($filepath);
            $width = $filedata[0];
            $height = $filedata[1];
            if ($width > 200) {
                $resize = ' previewshrink';
            }
            $uploadedfiletree .= '<img  id="' . $file . '" class="imagepreviewdiv ui-widget-content' . $resize . '" src="' . (string)$filepath . '"><br>';
        }

        Database::disconnect();

        return $uploadedfiletree;
    }

    /**
     * Save a Banner Maker banner.
     * @param string $username is the current logged in user.
     * @param array $post are the banner details.
     * @return string $show is the message shown to the user after saving the banner.
     */
    public function saveBanner(string $username, array $post): string {
        
        // First get the base-64 string from data
        $img_val = $post['img_val'];
        $filteredData = substr($img_val, strpos($img_val, ",")+1);
        //Decode the string
        $unencodedData = base64_decode($filteredData);
        // get the background and border setting values from img_obj
        $img_obj = $post['img_obj'];
        //var_dump(json_decode($img_obj));
        $img_obj = json_decode($img_obj);

        // Get fields for database:

        // remove resize handles from htmlcode:
        $htmlcode = trim($post['htmlcode']);
        // save the fields in the object img_obj:
        $width = $img_obj->width;
        $height = $img_obj->height;
        $bgcolor = $img_obj->bgcolor;
        $bgimage = $img_obj->bgimage;
        $bordercolor = $img_obj->bordercolor;
        $borderwidth = $img_obj->borderwidth;
        $borderstyle = $img_obj->borderstyle;

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if this is an existing banner or a new banner:
        $editingexistingimageid = $post['editingexistingimageid'];

        if ($editingexistingimageid !== '') {
            // This is an existing banner that we need to update.

            // Get the banner filename to delete.
            $banner = $this->showBanner($editingexistingimageid);
            $filename = $banner['filename'];
            $filepath = 'mybanners/' . $filename;
            @unlink($filepath);

            // RECREATE the file on the server:
            file_put_contents($filepath, $unencodedData);

            // Save image into the banners database table.
            $sql = "update bannermaker set filename=?, htmlcode=?, width=?, height=?, bgcolor=?, bgimage=?, bordercolor=?, borderwidth=?, borderstyle=? where id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($filename, $htmlcode, $width, $height, $bgcolor, $bgimage, $bordercolor, $borderwidth, $borderstyle, $editingexistingimageid));

        } else {
            // This is a new banner to create.

            //Save the image with a random filename.
            $filenamelong = md5(rand(0,9999999));
            $filenameshort = substr($filenamelong, 0, 12);
            $today = date("YmdHis");
            $filename = $today . $filenameshort . ".png";
            $filepath = 'mybanners/' . $filename;

            // write the file to the server.
            file_put_contents($filepath, $unencodedData);

            // Save image into the banners database table.
            $sql = "insert into bannermaker (username, filename, htmlcode, width, height, bgcolor, bgimage, bordercolor, borderwidth, borderstyle, adddate) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $q = $pdo->prepare($sql);
            $q->execute(array($username, $filename, $htmlcode, $width, $height, $bgcolor, $bgimage, $bordercolor, $borderwidth, $borderstyle));

        }

        Database::disconnect();

        return "<div id=\"bannersavedmsg\" class=\"mx-3 pt-3 message-pink\">Your Banner was Saved!</div>";
    }

    /**
     * Check to see if the user has purchased the license or not. If not, their banners should be watermarked.
     * @param string $username is the username we want to look up licenses for.
     * @return bool $watermark is whether the username has a license for unwatermarked images.
     */
    // public function licenseCheck(string $username = null): bool {
    //
    //     // TODO: need LICENSE class
    //     $license = License::where('username', '=', $username)->where('licenseenddate', '>=', new DateTime('now'))->orderBy('id', 'desc')->first();
    //     $watermark = true; // default is to have a watermark.
    //     if ($license) {
    //         // the user has a license so no watermark on images.
    //         $watermark = false;
    //     } else {
    //         // is the user an admin?
    //         $admin = Member::where('username', '=', $request->get('username'))->where('admin', '=', 1)->first();
    //         if ($admin) {
    //             // admin doesn't have a watermark:
    //             $watermark = false;
    //         } else {
    //             // the user doesn't have an active license and is not an admin, so images they create need the watermark.
    //             $watermark = true;
    //         }
    //     }
    //     return $watermark;
    // }

    /**
     * Display the specified image.
     * @param int $id is the id in the database of the image.
     * @return object $banner is the saved Banner Maker banner in the database that matches the id parameter.
     */
    public function showBanner(int $id): array
    {
        // get the banner content for this id.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from bannermaker where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $banner = $q->fetch();

        return $banner;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id is the database id of the banner.
     * @return string $banner is the message showing the results of the deletion.
     */
    public function deleteBanner(int $id): string
    {
        // Get the banner filename to delete.
        $banner = $this->showBanner($id);
        $filename = $banner['filename'];
        $filepath = '../mybanners/' . $filename;
        unlink($filepath);

        // delete the banner database record.
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from bannermaker where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Banner was Deleted</strong></div>";
    }

    /**
     * User uploads images from Banner Maker app.
     * @param string $username is the current logged in user.
     * @param array $imageuploads is the $_FILE data of images uploaded by the user.
     * @return string $banner is the message showing the results of the deletion.
     */
    public function uploadImages(string $username, array $imageuploads): string
    {

        $numberofimages = count($imageuploads);

        if ($numberofimages < 1) {
            return "You didn't select any images.";
        }

        for ($i = 0; $i < $numberofimages; $i++) {
    
            // Data for each uploaded image file:
            $image_name = $_FILES['imageuploads']['name'][$i];
            $image_name_last_period = strrpos($image_name, '.'); // index of last period in filename.
            $image_extension = substr($image_name, $image_name_last_period + 1);
            $image_type = $_FILES['imageuploads']['type'][$i]; // mime type (ie. image/jpeg).
            $image_tmp_name = $_FILES['imageuploads']['tmp_name'][$i]; // server temp filename (ie. /tmp/phpuI8wMW).
            $image_error = $_FILES['imageuploads']['error'][$i]; // 0 if no error.
            $image_size = $_FILES['imageuploads']['size'][$i];
    
            // SERVER-SIDE VALIDATION (JS does client side before this point as well)
            if ($image_name === '' || $image_tmp_name === '') {
                return "File cannot be blank.";
            }
            $allowedextensions = ['gif', 'jpg', 'jpeg', 'jfif', 'png', 'svg', 'webp'];
            if (!in_array($image_extension, $allowedextensions)) {
                return "File type must be gif, jpg, png, svg, or webp.";
            }
            if ($image_size > 5 * 1024 * 1024) {
                return "File size can be maximum 5 MB.";
            }
    
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

        return "Upload successful!";
    }
}