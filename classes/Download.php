<?php

/**
Download library for members of files and links uploaded by admin.
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

class Download
{

    private $pdo, $sql, $q, $count, $downloadpostedvariablename;

    public function getAllDownloads(): array
    {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from downloads order by id";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $downloads = $q->fetchAll();
        $downloadsarray = array();
        foreach ($downloads as $download) {
            array_push($downloadsarray, $download);
        }

        Database::disconnect();

        return $downloadsarray;
    }

    public function getAllUserDownloads(string $username): array 
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from downloadaccess where username=? order by id";
        $q = $pdo->prepare($sql);
        $q->execute([$username]);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $downloads = $q->fetchAll();
        $downloadidarray = array();
        foreach ($downloads as $download) {
            array_push($downloadidarray, $download['downloadid']);
        }

        Database::disconnect();

        return $downloadidarray;
    }

    public function getOneDownload(int $downloadid): array {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from downloads where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$downloadid]);
        $download = $q->fetch();

        return $download;
    }

    public function giveDownload(array $post): string
    {
        $username = $post["username"];

        $downloads = $this->getAllDownloads();

        if (empty($downloads)) {

            return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>There are no downloads in the system yet.</strong></div>";
        }

        foreach ($downloads as $download) {

            $downloadid = $download["id"];
            $downloadpostedvariablename = "download-" . $downloadid;
            $downloadtogive = $_POST[$downloadpostedvariablename];
            if ($downloadtogive == "yes") {

                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "select count(*) from downloadaccess where downloadid=? and username=?";
                $q = $pdo->prepare($sql);
                $q->execute([$downloadid, $username]);
                $count = $q->fetchColumn();

                if ($count == 0) {
                    $sql = "insert into downloadaccess (downloadid,username,dategiven) values (?,?,NOW())";
                    $q = $pdo->prepare($sql);
                    $q->execute([$downloadid, $username]);
                }

                Database::disconnect();
            }
        }

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Download(s) Added for Member " . $username . "</strong></div>";
    }

    public function addDownload(array $post): string
    {

        $downloadsfolder = $post["downloadsfolder"];
        $name = $post["downloadname"];
        $type = $post["downloadtype"];
        $description = $post["downloaddescription"];

        if ($type === "link") {

            $url = $post["downloadurl"];
            $file_name = "";
            $file_size = "";
            $file_type = "";
        }

        if ($type === "file") {

            $url = "";
            $file_name = $_FILES['downloadfile']['name'];
            $file_size = $_FILES['downloadfile']['size'];
            $file_type = $_FILES['downloadfile']['type'];

            if (file_exists(".." . $downloadsfolder . $file_name)) {
                return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The file already exists!</strong></div>";
            } else {
                @unlink(".." . $downloadsfolder . $file_name);
            }

            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $temp = ".." . $downloadsfolder . $file_name;

            if (@move_uploaded_file($_FILES['downloadfile']['tmp_name'], $temp)) {
                @chmod($temp, 0755);
            } else {
                return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>There was a problem uploading the file!</strong></div>";
            }
        }

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into downloads (name,type,description,url,file,filesize,filetype,dateadded) values (?,?,?,?,?,?,?, NOW())";
        $q = $pdo->prepare($sql);
        $q->execute([$name, $type, $description, $url, $file_name, $file_size, $file_type]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Download was Added!</strong></div>";
    }

    public function saveDownload(array $post): string
    {

        $downloadsfolder = $post["downloadsfolder"];
        $id = $post["id"];
        $name = $post["downloadname"];
        $type = $post["downloadtype"];
        $description = $post["downloaddescription"];

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($type === "link") {

            $url = $post["downloadurl"];
            $file_name = "";
            $file_size = "";
            $file_type = "";

            if (!empty($post['olddownloadfile'])) {
                @unlink(".." . $downloadsfolder . $post['olddownloadfile']);
            }

            $sql = "update downloads set name=?,type=?,description=?,url=?,file=?,filesize=?,filetype=? where id=?";
            $q = $pdo->prepare($sql);
            $q->execute([$name, $type, $description, $url, $file_name, $file_size, $file_type, $id]);    
        }

        if ($type === "file") {

            $url = "";
            $file_name = $_FILES['downloadfile']['name'];
            $file_size = $_FILES['downloadfile']['size'];
            $file_type = $_FILES['downloadfile']['type'];
            $olddownloadfile = $post["olddownloadfile"];

            if ((empty($file_name) && !empty($olddownloadfile)) || ($file_name === $olddownloadfile)) {

                // There is no file upload but there is already an existing filename for this record.
                // OR
                // The file upload name is the same as the one already in the database. 
                // Means nothing is changed with the file.
                $sql = "update downloads set name=?,type=?,description=?,url=? where id=?";
                $q = $pdo->prepare($sql);
                $q->execute([$name, $type, $description, $url, $id]);      

            } else {

                // The filename has changed.
                if (file_exists(".." . $downloadsfolder . $file_name) && !empty($filename)) {

                    // The admin tried to upload a file that is already present on the server.
                    return "<div class=\"alert alert-danger\" style=\"width:75%;\"><strong>The file already exists!</strong></div>";
                } else {

                    // Remove the old file.
                    @unlink(".." . $downloadsfolder . $olddownloadfile);

                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    // TODO: Decide which extensions are allowed:
                    // $disallowed = ['exe', 'bat', 'php', 'pl', 'cgi'];            
                    // $allowed = array('gif', 'png', 'jpg');
                    // $filename = $_FILES['video_file']['name'];
                    // $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    // if (!in_array($ext, $allowed)) {
                    //     echo 'error';
                    // }
                    
                    // Then upload the new one.
                    $temp = ".." . $downloadsfolder . $file_name;

                    if (@move_uploaded_file($_FILES['downloadfile']['tmp_name'], $temp)) {
                        @chmod($temp, 0755);
                    }

                    $sql = "update downloads set name=?,type=?,description=?,url=?,file=?,filesize=?,filetype=? where id=?";
                    $q = $pdo->prepare($sql);
                    $q->execute([$name, $type, $description, $url, $file_name, $file_size, $file_type, $id]);            
                }
            }
        }

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Download was Saved!</strong></div>";
    }

    public function deleteDownload(array $post): string
    {

        $downloadsfolder = $post["downloadsfolder"];
        $deletedownloadfile = $post["deletedownloadfile"];
        $id = $post["id"];

        if (!empty($downloadsfolder) && !empty($deletedownloadfile)) {
            @unlink(".." . $downloadsfolder . $deletedownloadfile);
        }

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from downloads where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        $sql = "delete from downloadaccess where downloadid=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Download was Deleted from the Library</strong></div>";
    }
}
