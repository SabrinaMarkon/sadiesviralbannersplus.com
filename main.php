<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

// TODO: Put this somewhere nicer.
$showcontent = new PageContent();
echo $showcontent->showPage('Home Page');
?>

<!-- Text ad rotator -->
<section>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="centered">
                    <section class="cards">

                        <?php include_once 'rotatortextads.php'; ?>

                    </section>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
</section>

<!-- Different Membership Levels -->
<!-- TODO: CHANGE BUTTONS TO PAYPAL BUTTONS! -->

<section id="memberships" class="pricing-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="section-title text-center">
                    <h3 class="title">Membership Plans</h3>
                    <p class="text">Stop wasting time and money designing and managing banners that don't get results. Happiness guaranteed!</p><br>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-7 col-sm-9">
                <div class="pricing-style mt-30">
                    <div class="pricing-icon text-center">
                        <img src="assets/images/basic.svg" alt="">
                    </div>
                    <div class="pricing-header text-center">
                        <h5 class="sub-title">Free</h5>
                        <p class="month"><span class="price">$0</span></p>
                    </div>
                    <div class="pricing-list">
                        <ul>
                            <li><i class="lni lni-check-mark-circle"></i> Feature 1</li>
                            <li><i class="lni lni-check-mark-circle"></i> Feature 2</li>
                        </ul>
                    </div>
                    <div class="pricing-btn rounded-buttons text-center">
                        <a class="main-btn rounded-one" href="/register">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>

            <div class="col-lg-4 col-md-7 col-sm-9">
                <div class="pricing-style mt-30">
                    <div class="pricing-icon text-center">
                        <img src="assets/images/pro.svg" alt="">
                    </div>
                    <div class="pricing-header text-center">
                        <h5 class="sub-title">Pro</h5>
                        <p class="month"><span class="price">$ 11</span>/month</p>
                    </div>
                    <div class="pricing-list">
                        <ul>
                            <li><i class="lni lni-check-mark-circle"></i> Feature 1</li>
                            <li><i class="lni lni-check-mark-circle"></i> Feature 2</li>
                        </ul>
                    </div>
                    <div class="pricing-btn rounded-buttons text-center">
                        <a class="main-btn rounded-one" href="/register">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>

            <div class="col-lg-4 col-md-7 col-sm-9">
                <div class="pricing-style mt-30">
                    <div class="pricing-icon text-center">
                        <img src="assets/images/enterprise.svg" alt="">
                    </div>
                    <div class="pricing-header text-center">
                        <h5 class="sub-title">Gold</h5>
                        <p class="month"><span class="price">$ 15</span>/month</p>
                    </div>
                    <div class="pricing-list">
                        <ul>
                            <li><i class="lni lni-check-mark-circle"></i> Feature 1</li>
                            <li><i class="lni lni-check-mark-circle"></i> Feature 2</li>
                        </ul>
                    </div>
                    <div class="pricing-btn rounded-buttons text-center">
                        <a class="main-btn rounded-one" href="#">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>