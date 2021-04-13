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
     * @param string $topdir is the top root directory.
     * @return array $subdirs are the subdirectories of the topdir root directory.
     */
    public function getSubdirectories(string $topdir): array {

        $subdirs = File::directories($topdir); // TODO: Fix this (not Laravel here)
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

    /**
     * Get the list of files for the image library chooser depending on which category (folder) was chosen.
     * @param string $folder is the chosen image folder.
     * @return string $filetree is the HTML image list of all files in the chosen directory.
     */
    public function fileTree(string $folder = null): string {
        $folder = "images/thumbnails/" . $folder;
        $filetree = '';
        $resize = '';
        $files = File::files($folder); // TODO: Fix this (not Laravel here)
        foreach ($files as $file)
        {
            // make sure the file is an image.
            $extension = File::extension($file); // TODO: Fix this (not Laravel here)
            if ($extension === 'gif' || $extension === 'png' || $extension === 'jpg' || $extension === 'jpeg' || $extension === 'wps' || $extension === 'webp' || $extension === 'svg') {
                $file_fullpath_array = explode("/", $file);
                $filename = end($file_fullpath_array);
                $filedata = getimagesize($file);
                $width = $filedata[0];
                $height = $filedata[1];
                if ($width > 200) {
                    $resize = ' previewshrink';
                }
                $filetree .= '<img  id="' . $filename . '" class="imagepreviewdiv ui-widget-content' . $resize . '" src="' . (string)$file . '"><br>';
            }
        }
        return $filetree;
    }

    /**
     * Save a Banner Maker banner.
     * @return string $show is the message shown to the user after saving the banner.
     */
    public function getbanner(): string {
        // First get the base-64 string from data
        $img_val = $request->get('img_val'); // TODO: Fix
        $filteredData = substr($img_val, strpos($img_val, ",")+1);
        //Decode the string
        $unencodedData = base64_decode($filteredData);
        // get the background and border setting values from img_obj
        $img_obj = $request->get('img_obj'); // TODO: Fix
        //var_dump(json_decode($img_obj));
        $img_obj = json_decode($img_obj);

        // Check if this is an existing banner or a new banner:
        $editingexistingimageid = $request->get('editingexistingimageid'); // TODO: Fix
        if ($editingexistingimageid !== '') {
            // existing banner we need to update:
            // we need to get the existing filename:
            $banner = Banner::find($editingexistingimageid); // TODO: Fix
            $dlfile = $banner->filename;
            // we need to delete the old copy of the file from the server:
            $dlfilepath = 'mybanners/' . $dlfile;
            File::delete($dlfilepath); // TODO: Fix
            // we need to create that filename again on the server with the new data:
            file_put_contents('mybanners/' . $dlfile, $unencodedData);
        } else {
            // new banner to create.
            //Save the image with a random filename.
            $dlfilelong = md5(rand(0,9999999));
            $dlfileshort = substr($dlfilelong, 0, 12);
            $today = date("YmdHis");
            $dlfile = $today . $dlfileshort . ".png";
            $dlfilepath = 'mybanners/' . $dlfile;
            // write the file to the server.
            file_put_contents('mybanners/' . $dlfile, $unencodedData);
            $banner = new Banner();
            $banner->userid = Session::get('user')->userid; // TODO: Fix by changing to string message.
        }

        // remove resize handles from htmlcode:
        $banner->htmlcode = trim($request->get('htmlcode'));
        $banner->filename = $dlfile;
        // save the fields in the object img_obj:
        $banner->width = $img_obj->width;
        $banner->height = $img_obj->height;
        $banner->bgcolor = $img_obj->bgcolor;
        $banner->bgimage = $img_obj->bgimage;
        $banner->bordercolor = $img_obj->bordercolor;
        $banner->borderwidth = $img_obj->borderwidth;
        $banner->borderstyle = $img_obj->borderstyle;
        // save image into the banners database table.
        $banner->save();
        Session::flash('message', 'Successfully saved your banner!'); // TODO: Fix by changing to string message.
        return Redirect::to('banners');  // TODO: Fix by changing to string message.
    }

    /**
     * Check to see if the user has purchased the license or not. If not, their banners should be watermarked.
     * @param string $userid is the username we want to look up licenses for.
     * @return bool $watermark is whether the userid has a license for unwatermarked images.
     */
    public function licenseCheck(string $userid = null): bool {
        // TODO: need LICENSE class (but not needed for THIS site)
        $license = License::where('userid', '=', $userid)->where('licenseenddate', '>=', new DateTime('now'))->orderBy('id', 'desc')->first();
        $watermark = true; // default is to have a watermark.
        if ($license) {
            // the user has a license so no watermark on images.
            $watermark = false;
        } else {
            // is the user an admin?
            $admin = Member::where('userid', '=', $request->get('userid'))->where('admin', '=', 1)->first();
            if ($admin) {
                // admin doesn't have a watermark:
                $watermark = false;
            } else {
                // the user doesn't have an active license and is not an admin, so images they create need the watermark.
                $watermark = true;
            }
        }
        return $watermark;
    }

    /**
     * Display the specified image.
     * @param int $id is the id in the database of the image.
     * @return object $banner is the saved Banner Maker banner in the database that matches the id parameter.
     */
    public function showBanner(int $id): object
    {
        // get the page content for this id.
        $banner = Banner::find($id);
        return $banner;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return string $banner is the message showing the results of the deletion.
     */
    public function deleteBannerImageFile(int $id): string
    {
        $banner = Banner::find($id);
        // delete the file:
        $filename = $banner->filename;
        $filepath = 'mybanners/' . $filename;
        File::delete($filepath);
        // delete the record:
        $banner->delete();
        return $banner;
    }
}