<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}


require "control.php";
if (isset($show))
{
    echo $show;
}
$adminnote = new AdminNote();
$htmlcode = $adminnote->getAdminNote();
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h1 class="ja-bottompadding">Welcome to your Admin Area, <?php echo $adminname ?></h1>

            <p class="text-left">You may use the text area below to save notes which are only visible to you.</p>

            <form method="post" accept-charset="utf-8" class="form" role="form">

                <label class="sr-only" for="adminnotes">Your Admin Notes</label>

                <input type="text" name="htmlcode" value="<?php echo $htmlcode['htmlcode']; ?>" class="form-control input-lg" placeholder="Admin Notes">

                <div class="ja-bottompadding"></div>

                <button class="btn btn-lg btn-primary" type="submit" name="saveadminnotes">Save Your Notes</button>

            </form>

            <div class="ja-bottompadding"></div>

        </div>
    </div>
</div>