<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

$levels = ["gold", "pro", "free"];
foreach ($levels as $level) {
    $bannerclickstosignup = $level . "bannerclickstosignup";
    $refersproearn = $level . "refersproearn";
    $refersgoldearn = $level . "refersgoldearn";
    $signupbonustextads = $level . "signupbonustextads";
    $signupbonusbannerspaid = $level . "signupbonusbannerspaid";
    $signupbonusnetworksolos = $level . "signupbonusnetworksolos";
    $monthlybonustextads = $level . "monthlybonustextads";
    $monthlybonusbannerspaid = $level . "monthlybonusbannerspaid";
    $monthlybonusnetworksolos = $level . "monthlybonusnetworksolos";
    $bannerslots = $level . "bannerslots";
    $adclickstogettextad = $level . "adclickstogettextad";
    $adclickstogetbannerspaid = $level . "adclickstogetbannerspaid";
    $adclickstogetnetworksolo = $level . "adclickstogetnetworksolo";

    $features = $level . "features";
    $$features = "";

    $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>Editable Banner Creations (plus more to come!)</li>';
    $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>Viral Banners to <strong>EXPLODE</strong> Your Traffic!</li>';

    if ($$bannerclickstosignup > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>Before joining, new <strong>' . strtoupper($level) . '</strong> members must click and visit <strong>' . $$bannerclickstosignup . '</strong> of their sponsor\'s Viral Banners!</li>';
    }
    if ($$refersproearn > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i><strong>GET PAID</strong> $' . $$refersproearn . ' for referring <strong>PRO</strong> members!</li>';
    }
    if ($$refersgoldearn > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i><strong>GET PAID</strong> $' . $$refersgoldearn . ' for referring <strong>GOLD</strong> members!</li>';
    }
    if ($$signupbonustextads > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>FREE</strong> sign up bonus of ' . $$signupbonustextads . ' <strong>SITE WIDE</strong> text ads!</li>';
    }
    if ($$signupbonusbannerspaid > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>FREE</strong> sign up bonus of ' . $$signupbonusbannerspaid . ' banners in my special <strong>PAID-ONLY</strong> rotator!</li>';
    }
    if ($$signupbonusnetworksolos > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>FREE</strong> sign up bonus of ' . $$signupbonusnetworksolos . ' <strong>HUMONGOUS NETWORK SOLOS!</strong></li>';
    }
    if ($$monthlybonustextads > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>FREE</strong> monthly bonus of ' . $$monthlybonustextads . ' <strong>SITE WIDE</strong> text ads!</li>';
    }
    if ($$monthlybonusbannerspaid > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>FREE</strong> monthly bonus of ' . $$monthlybonusbannerspaid . ' banners in my special <strong>PAID-ONLY</strong> rotator!</li>';
    }
    if ($$monthlybonusnetworksolos > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>A <strong>FREE</strong> monthly bonus of ' . $$monthlybonusnetworksolos . ' <strong>HUMONGOUS NETWORK SOLOS!</strong></li>';
    }
    if (!empty($$bannerslots)) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>Your favorite <strong>OVERSIZED</strong> 728 x 90 BANNERS in the <strong>VIRAL</strong> banner slots # ' . $$bannerslots . ' of your very own <strong>VIRAL BANNER AD PAGE!</strong></li>';
    }

    for ($i = 1; $i <= 6; $i++) {
        $levelname = "";
        switch ($i) {
            case 1:
                $levelname = "FIRST";
                break;
            case 2:
                $levelname = "SECOND";
                break;
            case 3:
                $levelname = "THIRD";
                break;
            case 4:
                $levelname = "FOURTH";
                break;
            case 5:
                $levelname = "FIFTH";
                break;
            case 6:
                $levelname = "SIXTH";
                break;
            default:
                $levelname = "FIRST";
        }
        $refersfreebannerslots = $level . "refersfreebannerslots" . $i;
        $refersprobannerslots = $level . "refersprobannerslots" . $i;
        $refersgoldbannerslots = $level . "refersgoldbannerslots" . $i;
        if (!empty($$refersfreebannerslots)) {
            $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>More of <strong>YOUR</strong> banners in slots # ' . $$refersfreebannerslots . ' on <strong>EVERY</strong> single one of your <strong>' . $levelname . ' LEVEL FREE REFERRALS\'</strong> viral banner pages!</li>';
        }
        if (!empty($$refersprobannerslots)) {
            $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>More of <strong>YOUR</strong> banners in slots # ' . $$refersprobannerslots . ' on <strong>EVERY</strong> single one of your <strong>' . $levelname . ' LEVEL PRO REFERRALS\'</strong> viral banner pages!</li>';
        }
        if (!empty($$refersgoldbannerslots)) {
            $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>More of <strong>YOUR</strong> banners in slots # ' . $$refersgoldbannerslots . ' on <strong>EVERY</strong> single one of your <strong>' . $levelname . ' LEVEL GOLD REFERRALS\'</strong> viral banner pages!</li>';
        }
    }

    if ($$adclickstogettextad > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>Click ' . $$adclickstogettextad . ' text ads to get a <strong>FREE BONUS</strong> text ad in our awesome <strong>SITE WIDE</strong> text ad rotation!</li>';
    }
    if ($$adclickstogetbannerspaid > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>Click ' . $$adclickstogetbannerspaid . ' banners to get a <strong>FREE BONUS</strong> banner in our exclusive <strong>PAID-ONLY</strong> rotator!</li>';
    }
    if ($$adclickstogetnetworksolo > 0) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>Click ' . $$adclickstogetnetworksolo . ' links in network solo ads to get your own <strong>FREE MASSIVE (800,000+!) SUPER SOLO!</strong></li>';
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
<section id="howitworks" class="pricing-area">
    <div class="mx-5">

        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 col-md-10">
                <div class="section-title text-center">
                    <h3 class="title">How It Works <i class="fas fa-star fa-xs"></i></h3>
                    <!-- <p class="text"><strong>Stop wasting time and money designing and managing banners that don't get results! Happiness guaranteed!</strong></p> -->
                    <br>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->

        <figure class="mx-5 mt-3 align-items-start">
            <div style="display:flex; flex-direction:column;">
                <figcaption class="ml-5">
                    <div class="sadietalkbig sadietalkbig-24em mb-4">
                        <span class="sadietalk-pink"><span class="heart4">&#10084;</span>&nbsp;Checkout My Members' Awesome Viral Banners!!!</span>&nbsp;<span class="heart4">&#10084;</span>
                        <br />
                    </div>
                    <div class="sadietalknormal">
                        <div style="font-weight: bold;" class="center mb-4">As a new member of my Viral Banner app, first visit my members' Viral Banners below! For each one, allow the timed countdown to complete, then choose the <a class="page-scroll" href="/#memberships">MEMBERSHIP</a> you want to register for once you have enough Viral Banner clicks!</div>

                        <div style="font-weight: bold;" class="center mb-4">The number of Viral Banners you gotta visit to register depends on which membership level you want!</div>

                        <div style="font-weight: bold;" class="mb-4 ml-5">
                            <ul>
                                <li>Click <span class="sadietalk-pink"><?php echo $freebannerclickstosignup; ?></span> Viral Banners to join <span class="sadietalk-blue">FREE</span></li>
                                <li>Click <span class="sadietalk-pink"><?php echo $probannerclickstosignup; ?></span> Viral Banners to join <span class="sadietalk-blue">PRO</span></li>
                                <li>Click <span class="sadietalk-pink"><?php echo $goldbannerclickstosignup; ?></span> Viral Banners to join <span class="sadietalk-blue">GOLD</span></li>
                            </ul>
                        </div>

                        <div style="font-weight: bold;" class="center mb-4"><strong><span class="sadietalk-pink">You've <span class="sadietalk-blue">ALREADY</span>&nbsp;<span class="sadietalk-pink">clicked</span>&nbsp;<span id="alreadyclicked" class="sadietalk-blue"></span>&nbsp;<span class="sadietalk-pink">Viral Banners!</span></strong></div>

                        <div style="font-weight: bold;" class="center">After you validate your email and login, you can immediately add your <span class="sadietalk-pink"><strong>OWN</strong></span> Viral Banners! <span class="heart">&#10084;</span></div>
                    </div>
                </figcaption>
            </div>
            <img src="images/sadie-sitting-SM-faceleft.png" alt="Hi! I'm Sadie!" class="mr-4 pt-2 pb-4 responsive">
        </figure>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="section-title text-center">
                    <h3 class="title">My Members' Viral Banners! <i class="fas fa-star fa-xs"></i></h3>
                    <!-- <p class="text"><strong>Stop wasting time and money designing and managing banners that don't get results! Happiness guaranteed!</strong></p> -->
                    <br>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->

        <span id="banners"></span>

        <?php
        include "viralbannersinclude.php";
        ?>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div id="getstarted" class="section-title text-center">
                    <h3 class="title">Membership Plans <i class="fas fa-star fa-xs"></i></h3>
                    <!-- <p class="text"><strong>Stop wasting time and money designing and managing banners that don't get results! Happiness guaranteed!</strong></p> -->
                    <br>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->

        <div id="memberships" class="flexcards-equalheight row justify-content-center">
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

<script src="js/viralbannertimer.js"></script>
<script>
    const howManyClicked = howManyWereClicked();
    document.getElementById('alreadyclicked').innerHTML = howManyClicked;
</script>
