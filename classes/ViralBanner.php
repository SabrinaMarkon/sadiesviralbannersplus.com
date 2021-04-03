<?php

/**
Child class to handle individual member banners only.
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

class ViralBanner extends Banner
{
    private $viralbanner;

    public function getViralBanner(string $username, int $slot): array
    {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from " . $this->adtable . " where username=? and bannerpageslot=? and approved=1 order by rand() limit 1";
        $q = $pdo->prepare($sql);
        $q->execute([$username, $slot]);
        $viralbanner = $q->fetch();

        Database::disconnect();

        if ($viralbanner) {

            return $viralbanner;
        }

        return [];
    }

    public function getRandomBannerOfCertainMembershipLevel(Sponsor $sponsor, string $accounttype, int $slot): array
    {
        $username = $sponsor->getRandomUsername($accounttype);

        if (!empty($username)) {

            $pdo = DATABASE::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from " . $this->adtable . " where username=? and bannerpageslot=? and approved=1 limit 1";
            $q = $pdo->prepare($sql);
            $q->execute([$username, $slot]);
            $viralbanner = $q->fetch();

            Database::disconnect();

            if ($viralbanner) {

                return $viralbanner;
            }

            return [];
        }

        return [];
    }

    // Get an array of the csv string for a banner slot admin setting.
    public function getVarArray(string $varname, array $settings): array
    {

        $varvalue = $settings[$varname];

        $vararray = [];

        if (!empty($varvalue)) {
            $vararray = explode(',', $varvalue);
        }

        return $vararray;
    }

    public function showBanner(array $banner, int $width, int $height, int $i): string {

        $id = $banner['id'];
        $alt = $banner['alt'];
        $imageurl = $banner['imageurl'];
        $clicks = $banner['clicks'];
        $hits = $banner['hits'];

        // Count hit (impression):
        $this->countBannerHit($id);

        // If banner will be clicked in Viral Banners members area, the click should open the modal to EDIT the Viral Banner instead of its URL.

        if ($i) {
            return '
            <div>
                <a class="placeholder-img" href="#" data-toggle="modal" data-target="#viralbannerModal' . $i . '">
                    <img alt="' . $alt . '" src="' . $imageurl . '" width="' . $width . '" height="' . $height . '" />
                </a>
            </div>'; 
        }

        return '
        <div>
            <a class="placeholder-img" href="/click/' . $this->adtable . '/' . $id . '" target="_blank">
                <img alt="' . $alt . '" src="' . $imageurl . '" width="' . $width . '" height="' . $height . '" />
            </a>
        </div>';  
    }

    public function countBannerHit(int $id): void {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update " . $this->adtable . " set hits=hits+1 where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        Database::disconnect();
    }

    public function showBannerPlaceholder(int $i, int $width, int $height, string $msg): string {
        
        $msguppercase = strtoupper($msg);
        $msguppercase = str_replace(" ", "+", $msguppercase);

        return '
        <div>
            <a class="placeholder" style="width: ' . $width . 'px; height: ' . $height . 'px;" href="#" data-toggle="modal" data-target="#viralbannerModal' . $i . '">' . $msg . '</a>
        </div>';
    }
    
     public function showClickIFrame(string $clickurl, array $settings): string {

        // Change click URL to https.
        $clickurl = str_replace('http:', 'https:', $clickurl);

        // $preloader goes right after <body> if we use it. 
        // It seems SLOWER than NOT using it because it waits for entire page to load (including ifram url) before showing page all at once.
        // Hence, it is not included by default.
        $preloader = '
        <!-- Preloader -->
        <div class="preloader">
            <div class="loader">
                <div class="ytp-spinner">
                    <div class="ytp-spinner-container">
                        <div class="ytp-spinner-rotator">
                            <div class="ytp-spinner-left">
                                <div class="ytp-spinner-circle"></div>
                            </div>
                            <div class="ytp-spinner-right">
                                <div class="ytp-spinner-circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        // $preloaderjs goes before </body> if we use it.
        $preloaderjs = '
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script>
        // Preloader:
        $(window).on("load", function (event) {
            $(".preloader").delay(500).fadeOut(500);
            });
        </script>';

        $timer = '
        <script src="js/viralbannertimer.js"></script>
        <script>
            countdown(' . $settings['clicktimer'] . ', "' . $clickurl . '");
        </script>';
        
        return '
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="' . $settings['metadescription'] . '" />
            <meta name="author" content="Sabrina Markon" />
            <base href="/" />
            <title>' . $settings['metatitle'] . '</title>
            <link rel="shortcut icon" href="images/favicon.png" type="image/png">
            <link rel="stylesheet" href="css/style.css">
            <link href="css/custom.css" rel="stylesheet" />
            </head>
            <body>

                <div class="clickframe">
                    <header class="clickframe-timerbar" id="timerbar"></header>
                    <iframe class="clickframe-iframe" src="' . $clickurl . '"></iframe>
                </div>

                ' . $timer . '

            </body>
            </html>';
    }
    
}
