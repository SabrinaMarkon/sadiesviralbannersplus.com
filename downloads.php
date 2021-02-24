<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require "control.php";
if (isset($show)) {
    echo $show;
}

$showcontent = new PageContent();
echo $showcontent->showPage('Members Area Downloads Page');

$alldownloads = new Download();
$downloads = $alldownloads->getAllUserDownloads($username);

?>
<div class="container">

    <h1 class="text-center mb-5">Your Downloads</h1>

    <?php

    if (count($downloads) === 0) {

        echo "<div class=\"ja-bottompadding ja-topadding mb-5\">You don't have access to any downloads currently.</div>";
    } else {

        # show links and file downloads that the user is allowed access to.
    ?>
        <div id="downloadpanel" class="downloadpanel">
            <?php

            foreach ($downloads as $downloadid) {

                $downloadinfo = $alldownloads->getOneDownload($downloadid);

                $name = $downloadinfo['name'];
                $type = $downloadinfo['type'];
                $description = $downloadinfo['description'];
                $url = $downloadinfo['url'];
                $file = $downloadinfo['file'];

            ?>
                <div class="download mb-4">
                    <h5 class="download-heading">
                        <?php
                        if ($type === "link") {
                        ?>
                            <a href="<?php echo $url ?>" target="_blank"><?php echo $name ?></a>
                        <?php
                        }

                        if ($type === "file") {
                        ?>
                            <a href=".<?php echo $downloadsfolder . $file ?>"><?php echo $name ?></a>
                        <?php
                        }
                        ?>
                    </h5>

                    <div>
                        <div class="download-body p-3">
                            <p>
                                <?php echo $description ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php

            }
            ?>
        </div>
    <?php
    }
    ?>
    <div class="ja-bottompadding"></div>

</div>