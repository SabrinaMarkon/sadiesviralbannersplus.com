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
    private $viralbanner, $username, $varvalue, $vararray;

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

    public function showBanner(array $banner): string {

        $bannerslot = $banner['bannerslot'] ?? null;
        $id = $banner['id'];
        $alt = $banner['alt'];
        $imageurl = $banner['imageurl'];
        $width = $banner['width'];
        $height = $banner['height'];
        $source = $banner['source'];
        $showinmodal = $banner['showinmodal'] ?? null;

        if ($source === 'memberarea') {
            // The Viral Banner was clicked in the members area, so the click should open the modal to EDIT the Viral Banner instead of its URL.
            // return '
            // <div>
            //     <a class="placeholder-img" href="#" data-toggle="modal" data-target="#viralbannerModal' . $bannerslot . '">
            //         <img alt="' . $alt . '" src="' . $imageurl . '" width="' . $width . '" height="' . $height . '" />
            //     </a>
            // </div>'; 
            return '
            <div>
                <a href="#' . $showinmodal . '" data-banner="' . json_encode($banner) . '" data-toggle="modal" class="openmodal placeholder-img">
                    <img alt="' . $alt . '" src="' . $imageurl . '" width="' . $width . '" height="' . $height . '" />
                </a>
            </div>';
        }
        elseif ($source === 'adminarea') {
            // The Viral Banner was clicked in the admin area.
            return '
            <div id="viralbanner' . $id . '">
                <a class="placeholder-img" href="/click/' . $this->adtable . '/' . $id . '" target="_blank">
                    <img alt="' . $alt . '" src="' . $imageurl . '" width="' . $width . '" height="' . $height . '" />
                </a>
            </div>';  
        }
        else {
            // The Viral Banner was clicked on the Viral Banners URL. ($source = 'viralbannerpage')

            // Count hit (impression):
            $this->countBannerHit($id);

            return '
            <div class="viralbanner-withclickbox">
                <div id="viralbanner' . $bannerslot . '" class="viralbanner-placeholder" style="width: ' . $width . 'px;">
                    Clicked!
                </div>
                <div>
                    <a class="placeholder-img" href="/click/' . $this->adtable . '/' . $id . '/' . $bannerslot . '">
                        <img alt="' . $alt . '" src="' . $imageurl . '" width="' . $width . '" height="' . $height . '" />
                    </a>
                </div>
            </div>';  
        }
    }

    public function countBannerHit(int $id): void {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update " . $this->adtable . " set hits=hits+1 where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        Database::disconnect();
    }

    public function showBannerPlaceholder(array $banner): string {
        
        $width = $banner['width'];
        $height = $banner['height'];
        $source = $banner['source'];
        $showinmodal = $banner['showinmodal'] ?? null;
        $msg = $banner['msg'];
        $msg = str_replace('\n', '<br>', $msg); // So line breaks in the message appear in the html properly.

        if ($source === 'adminarea') {
            return '
            <div>
                <a class="placeholder" style="width: ' . $width . 'px; height: ' . $height . 'px;" href="/admin/viralbanners#createad">' . $msg . '</a>
            </div>';
        } else {
            // $showinmodal is also the id of the correct modal dialog to show!
            return '
            <div>
                <a href="#' . $showinmodal . '" data-banner="' . json_encode($banner) . '" style="width: ' . $width . 'px; height: ' . $height . 'px;" data-toggle="modal" class="openmodal placeholder">' . $msg . '</a>
            </div>';
        }
    }
    
     public function showClickIFrame(int $bannerslot, string $clickurl, array $settings): string {

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
            countdown(' . $settings['clicktimer'] . ', ' . $bannerslot . ');
        </script>';
        
        return '
        <!doctype html>
        <html lang="en">
        <head>
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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

    public function buildFormFieldsForAdminSettingsBonusSlots(string $referidaccounttype = "Free", $referralaccounttype = "Free", array $settings): string {
        
        $htmltoreturn = "";
        $referidacct = lcfirst($referidaccounttype);
        $referralacct = lcfirst($referralaccounttype);
        $settingnameupgradenumber = $referidacct . "downlineupgradestogetbonusslotson" . $referralacct . "referralpages";
        $settingnamebonusslots = $referidacct . "downlineupgradeswhichbonusslotson" . $referralacct . "referralpages";

        $htmltoreturn .= '<div>
        <label for="' . $settingnameupgradenumber . '" class="mt-2">How many total downline upgrades a ' . $referidaccounttype . ' member needs to get <strong>BONUS SLOTS</strong> on their ' . $referralaccounttype . '  referral\'s page:</label>
        <input type="number" min="0" step="1" name="' . $settingnameupgradenumber . '" value="' . $settings[$settingnameupgradenumber] . '" class="form-control smallselect" required>
        </div>';

        $htmltoreturn .= '<label class="mt-2"><strong>BONUS SLOTS</strong> a ' . $referidaccounttype . ' member gets on their ' . $referralaccounttype . '  referral\'s page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">';

        for ($i = 1; $i <= 16; $i += 4) {

            $htmltoreturn .= '<div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">';

                for ($j = $i; $j <= $i + 3; $j++) {

                    $htmltoreturn .= '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="' . $settingnamebonusslots . '[' . $j . ']' . '" 
                        value="' . $j . '"';

                        if (in_array($j, explode(',', $settings[$settingnamebonusslots]))) {
                            $htmltoreturn .= ' checked';
                        }

                        $htmltoreturn .= '>
                        <label class="form-check-label" for="' . $settingnamebonusslots . '[' . $j . ']' . '">Slot ' . $j. '</label>
                    </div>';
                }
            
            $htmltoreturn .= '</div>';
        }

        $htmltoreturn .= '</div>';

        return $htmltoreturn;
    }

    public function buildFormFieldsForAdminSettingsSlots(int $levelreferred = 1, string $referidaccounttype = "Free", $referralaccounttype = "Free", array $settings): string {

        $htmltoreturn = "";
        $levelreferredtext = "";
        $referidacct = lcfirst($referidaccounttype);
        $referralacct = lcfirst($referralaccounttype);
        $settingname = $referidacct . "refers" . $referralacct . "bannerslots" . $levelreferred;

        switch($levelreferred) {
            case 1:
                $levelreferredtext = "FIRST";
                break;
            case 2:
                $levelreferredtext = "SECOND";
                break;
            case 3:
                $levelreferredtext = "THIRD";
                break;
            case 4:
                $levelreferredtext = "FOURTH";
                break;
            case 5:
                $levelreferredtext = "FIFTH";
                break;
            case 6:
                $levelreferredtext = "SIXTH";
                break;
            default:
            $levelreferredtext = "FIRST";        
        }


        $htmltoreturn .= '<label class="mt-2">Banner slots a ' . $referidaccounttype . ' member gets on their <strong>' . $levelreferredtext . ' LEVEL</strong>  ' . $referralaccounttype . '  referral\'s page:</label>
        <div class="bannerslot-checkboxes mb-3" style="display: flex;">';

        for ($i = 1; $i <= 16; $i += 4) {

            $htmltoreturn .= '<div class="bannerslot-checkboxes-column mr-4" style="display: flex; flex-direction: column;">';

                for ($j = $i; $j <= $i + 3; $j++) {

                    $htmltoreturn .= '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="' . $settingname . '[' . $j . ']' . '" 
                        value="' . $j . '"';

                        if (in_array($j, explode(',', $settings[$settingname]))) {
                            $htmltoreturn .= ' checked';
                        }

                        $htmltoreturn .= '>
                        <label class="form-check-label" for="' . $settingname . '[' . $j . ']' . '">Slot ' . $j. '</label>
                    </div>';
                }
            
            $htmltoreturn .= '</div>';
        }

        $htmltoreturn .= '</div>';

        return $htmltoreturn;
    }
    
}
