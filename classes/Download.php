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

    private $pdo, $sql, $q, $downloadpostedvariablename;

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
                $sql = "insert into downloadaccess (downloadid,username,dategiven) values (?,?,NOW())";
                $q = $pdo->prepare($sql);
                $q->execute([$downloadid, $username]);
        
                Database::disconnect();
            }
        }

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>Download(s) Added for Member " . $username . "</strong></div>";
    }

    public function addDOwnload(array $post): string
    {

        $name = $post["downloadname"];
        $type = $post["downloadtype"];
        $description = $post["downloaddescription"];
        $url = $post["downloadurl"];
        $file_name = $_FILES['downloadfile']['name'];
        $file_size = $_FILES['downloadfile']['size'];
        $file_type = $_FILES['downloadfile']['type'];

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

        $id = $post["id"];
        $name = $post["downloadname"];
        $type = $post["downloadtype"];
        $description = $post["downloaddescription"];
        $url = $post["downloadurl"];
        $file_name = $_FILES['downloadfile']['name'];
        $file_size = $_FILES['downloadfile']['size'];
        $file_type = $_FILES['downloadfile']['type'];

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update downloads set name=?,type=?,description=?,url=?,file=?,filesize=?,filetype=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$name, $type, $description, $url, $file_name, $file_size, $file_type, $id]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Download was Saved!</strong></div>";
    }

    public function deleteDownload(int $id): string
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from downloads where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The Download was Deleted from the Library</strong></div>";
    }
}
