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
<div class="container">

    

    <div class="ja-bottompadding"></div>
</div>