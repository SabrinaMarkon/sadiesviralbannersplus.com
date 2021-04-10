<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require "control.php";
if (isset($showad)) {
    echo $showad;
}

$showcontent = new PageContent();
// echo $showcontent->showPage('Members Area Banner Maker Page');
?>
<div class="bannermaker">

    <!-- Backdrop -->
    <div class="bannermaker__overlay"></div>

    <!-- Sidebar -->
    <div class="bannermaker__sidebar">
        ...
    </div>
    

    <div class="ja-bottompadding"></div>
</div>

<script src="js/bannermaker.js"></script>
