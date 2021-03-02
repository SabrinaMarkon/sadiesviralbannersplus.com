<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

// Get this page's referring member $_SESSION['referid']'s banners:
$banner = new Banner('bannersformembers');
$referidbanners = $banner->getAllApprovedUsersAds($_SESSION['referid']);

// Get this page's referring member's own sponsor and sponsor's accounttype.
$referidssponsor = new Sponsor();
$referidssponsor = $referidssponsor->getUsersAccounttypeReferidAndReferidAccounttype($_SESSION['referid']);

if (count($sponsorarray) > 0) {

    $useraccounttype = $sponsorarray[0];
    $sponsorusername = $sponsorarray[1];
    $sponsoraccounttype = $sponsorarray[2]; // Which of the sponsor's (of this urls referring username) show depends on the sponsor's accounttype.

    // Get user's sponsor's banners:
    $sponsorbanners = $banner->getAllApprovedUsersAds($sponsorusername);
}
else {
    $useraccounttype = "Free";
}


?>
<div class="container">

<!-- The Eight 728px x 90px BANNERS -->




<!-- The Four 468px x 60px BANNERS -->

<!-- #9 - 468px x 60px - Rotator for all gold member banners. -->
<section class="bannerspaid-area">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="centered">
                    <section class="cards">

                        <?php include 'rotatorbannerspaid.php'; ?>

                    </section>
                </div>
            </div>
        </div>
</section>

<!-- #10 - 468px x 60px - Rotator for all pro member banners. -->
<section class="bannerspaid-area">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="centered">
                    <section class="cards">

                        <?php include 'rotatorbannerspaid.php'; ?>

                    </section>
                </div>
            </div>
        </div>
</section>

<!-- #11 - 468px x 60px - The referid has a sponsor themselves, and this is one of that sponsor's banners. -->
<section class="bannerspaid-area">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="centered">
                    <section class="cards">

                        <?php include 'rotatorbannerspaid.php'; ?>

                    </section>
                </div>
            </div>
        </div>
</section>


<!-- #12 - 468px x 60px - Paid Banner Rotator -->
<section class="bannerspaid-area">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="centered">
                    <section class="cards">

                        <?php include 'rotatorbannerspaid.php'; ?>

                    </section>
                </div>
            </div>
        </div>
</section>

</div>