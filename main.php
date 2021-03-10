<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$levels = ["gold", "pro", "free"];
foreach($levels as $level) {
    $signupbonustextads = $level . "signupbonustextads";
    $signupbonusbannerspaid = $level . "signupbonusbannerspaid";
    $signupbonusnetworksolos = $level . "signupbonusnetworksolos";
    $monthlybonustextads = $level . "monthlybonustextads";
    $monthlybonusbannerspaid = $level . "monthlybonusbannerspaid";
    $monthlybonusnetworksolos = $level . "monthlybonusnetworksolos";
    $features = $level . "features";
    $$features = "";

    if ($$signupbonustextads > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>free</strong> sign up bonus of ' . $$signupbonustextads . ' FRONT PAGE text ads!</li>';
    }
    if ($$signupbonusbannerspaid > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>free</strong> sign up bonus of ' . $$signupbonusbannerspaid . ' banners in my special PAID-ONLY rotator!</li>';
    }
    if ($$signupbonusnetworksolos > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>free</strong> sign up bonus of ' . $$signupbonusnetworksolos . ' HUMONGOUS NETWORK SOLOS!</li>';
    }
    if ($$monthlybonustextads > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>free</strong> monthly bonus of ' . $$monthlybonustextads . ' FRONT PAGE text ads!</li>';
    }
    if ($$monthlybonusbannerspaid > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>free</strong> monthly bonus of ' . $$monthlybonusbannerspaid . ' banner in my special PAID-ONLY rotator!</li>';
    }
    if ($$monthlybonusnetworksolos > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>free</strong> monthly bonus of ' . $$monthlybonusnetworksolos . ' HUMONGOUS NETWORK SOLOS!</li>';
    }
}
?>

<!-- Paid Banner Rotators -->
<section id="bannerspaid" class="bannerspaid-area">
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

<!-- Home page content written by admin -->
<?php
$showcontent = new PageContent();
if (!empty($showcontent->showPage('Home Page'))) {
?>
    <section id="homecontent">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="centered">
                        <section>

                            <?php
                            echo $showcontent->showPage('Home Page');
                            ?>

                        </section>
                    </div>
                </div>
            </div>
    </section>
<?php
}
?>

<!-- Different Membership Levels -->
<section id="memberships" class="pricing-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div id="getstarted" class="section-title text-center">
                    <h3 class="title">Membership Plans <i class="fas fa-star fa-xs"></i></h3>
                    <p class="text"><strong>Stop wasting time and money designing and managing banners that don't get results. Happiness guaranteed!</strong></p>
                    <p class="text"><strong>Choose your membership!</strong></p><br>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="flexcards-equalheight row justify-content-center">
            <div class="flexcard col-lg-4 col-md-7 col-sm-9">
                <div class="flexcard-content pricing-style mt-30">
                    <div class="pricing-icon text-center">
                        <img src="images/rocket-red.png" alt="">
                    </div>
                    <div class="pricing-header text-center">
                        <h5 class="sub-title">Free Member</h5>
                        <p class="month"><span class="price">$0</span></p>
                    </div>
                    <div class="flexcard-list pricing-list">
                        <ul>
                            <li><i class="membership-checkbox fas fa-check-circle"></i><strong>Get paid</strong> $<?php echo $freerefersproearn ?> for referring Pro members!</li>
                            <li><i class="membership-checkbox fas fa-check-circle"></i><strong>Get paid</strong> $<?php echo $freerefersgoldearn ?> for referring Gold members!</li>
                            <?php echo $freefeatures; ?>
                        </ul>
                    </div>
                    <div class="pricing-btn rounded-buttons text-center">
                        <a class="main-btn rounded-one" href="/register">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>

            <div class="flexcard col-lg-4 col-md-7 col-sm-9">
                <div class="flexcard-content pricing-style mt-30">
                    <div class="pricing-icon text-center">
                        <img src="images/rocket-yellow.png" alt="">
                    </div>
                    <div class="pricing-header text-center">
                        <h5 class="sub-title">Pro Member</h5>
                        <p class="month"><span class="price">$ <?php echo $proprice ?></span>
                            <?php
                            echo $propayinterval === 'lifetime' ? 'lifetime' : '/' . $propayinterval;
                            ?>
                        </p>
                    </div>
                    <div class="flexcard-list pricing-list">
                        <ul>
                        <li><i class="membership-checkbox fas fa-check-circle"></i><strong>Get paid</strong> $<?php echo $prorefersproearn ?> for referring Pro members!</li>
                            <li><i class="membership-checkbox fas fa-check-circle"></i><strong>Get paid</strong> $<?php echo $prorefersgoldearn ?> for referring Gold members!</li>
                            <?php echo $profeatures; ?>
                        </ul>
                    </div>
                    <div class="pricing-btn rounded-buttons text-center">
                        <a class="main-btn rounded-one" href="/pro">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>

            <div class="flexcard col-lg-4 col-md-7 col-sm-9">
                <div class="flexcard-content pricing-style mt-30">
                    <div class="pricing-icon text-center">
                        <img src="images/rocket-blue.png" alt="">
                    </div>
                    <div class="pricing-header text-center">
                        <h5 class="sub-title">Gold Member</h5>
                        <p class="month"><span class="price">$ <?php echo $goldprice ?></span>
                            <?php
                            echo $goldpayinterval === 'lifetime' ? 'lifetime' : '/' . $goldpayinterval;
                            ?>
                        </p>
                    </div>
                    <div class="flexcard-list pricing-list">
                        <ul>
                        <li><i class="membership-checkbox fas fa-check-circle"></i><strong>Get paid</strong> $<?php echo $goldrefersproearn ?> for referring Pro members!</li>
                            <li><i class="membership-checkbox fas fa-check-circle"></i><strong>Get paid</strong> $<?php echo $goldrefersgoldearn ?> for referring Gold members!</li>
                            <?php echo $goldfeatures; ?>
                        </ul>
                    </div>
                    <div class="pricing-btn rounded-buttons text-center">
                        <a class="main-btn rounded-one" href="/gold">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!-- Text ad rotator -->
<section id="textads" class="textads-area">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="centered">
                    <section class="cards">

                        <?php include_once 'rotatortextads.php'; ?>

                    </section>
                </div>
            </div>
        </div>
</section>

<!-- Contact -->

<section id="contact" class="c">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="section-title text-center pb-30">
                    <h3 class="title">Contact <i class="fas fa-star fa-xs"></i></h3>
                    <?php
                    if (isset($showcontact)) {
                        echo '<div class="ja-bottompadding"></div>';
                        echo $showcontact;
                    } else {
                        echo '<p class="text"><strong>Please send us a message if you need help or have any questions.</strong></p>';
                        echo '<div class="ja-bottompadding"></div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="contact-wrapper form-style-two pt-15">
                    <form action="/#contact" method="post" accept-charset="utf-8" class="form" role="form">

                        <label class="sr-only" for="username">Name or Username</label>
                        <input type="text" name="username" value="<?php if (isset($_SESSION['username'])) {
                                                                        echo $_SESSION['username'];
                                                                    } ?>" class="form-control input-lg" placeholder="Name or Username">

                        <label class="sr-only" for="email">Email</label>
                        <input type="email" name="email" value="<?php if (isset($_SESSION['email'])) {
                                                                    echo $_SESSION['email'];
                                                                } ?>" class="form-control input-lg" placeholder="Email" required>

                        <label class="sr-only" for="subject">Subject</label>
                        <input type="text" name="subject" value="" class="form-control input-lg" placeholder="Subject" required>

                        <label class="sr-only" for="message">Message</label>
                        <textarea name="message" value="" class="form-control input-lg" rows="10" placeholder="Message" required></textarea>

                        <div class="ja-bottompadding"></div>

                        <div class="form-input light-rounded-buttons mt-30">
                            <button class="mail-btn light-rounded-two" type="submit" name="contactus">Send Message</button>
                        </div>

                    </form>
                </div> <!-- contact wrapper form -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>