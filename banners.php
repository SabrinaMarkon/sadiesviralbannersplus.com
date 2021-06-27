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
    $refersfreebannerslots = $level . "refersfreebannerslots";
    $refersprobannerslots = $level . "refersprobannerslots";
    $refersgoldbannerslots = $level . "refersgoldbannerslots";
    $adclickstogettextad = $level . "adclickstogettextad";
    $adclickstogetbannerspaid = $level . "adclickstogetbannerspaid";
    $adclickstogetnetworksolo = $level . "adclickstogetnetworksolo";

    $features = $level . "features";
    $$features = "";

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
    if (!empty($$refersfreebannerslots)) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>More of <strong>YOUR</strong> banners in slots # ' . $$refersfreebannerslots . ' on <strong>EVERY</strong> single one of your <strong>FREE REFERRALS\'</strong> viral banner pages!</li>';
    }
    if (!empty($$refersprobannerslots)) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>More of <strong>YOUR</strong> banners in slots # ' . $$refersprobannerslots . ' on <strong>EVERY</strong> single one of your <strong>PRO REFERRALS\'</strong> viral banner pages!</li>';
    }
    if (!empty($$refersgoldbannerslots)) {
        $$features .= '<li><i class="membership-checkbox fas fa-check-circle"></i>More of <strong>YOUR</strong> banners in slots # ' . $$refersgoldbannerslots . ' on <strong>EVERY</strong> single one of your <strong>GOLD REFERRALS\'</strong> viral banner pages!</li>';
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

<!-- Different Membership Levels -->
<section id="howitworks" class="pricing-area">
    <div class="mx-5">

        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 col-md-10">
                <div class="section-title text-center">
                    <h3 class="title">Get Your Own Viral Page Here!&nbsp;<i class="fas fa-star fa-xs"></i></h3>
                    <br>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->

        <figure class="mx-5 align-items-start">
            <img src="images/sadie-sitting.png" alt="Click Viral Banners to Join!" class="mr-4 pt-5 pb-4">

            <span id="banners"></span>

<?php
include "viralbannersinclude.php";
?>

            <div style="display:flex; flex-direction:column;">
                <figcaption class="ml-5 py-5">
                    <div class="sadietalkbig"><span class="heart">&#10084;</span><span class="heart2">&#10084;</span><span class="heart3">&#10084;</span>&nbsp;<span class="hiya">I'm So Happy to Meet You!</span><span class="heart">&#10084;</span><span class="heart2">&#10084;</span><span class="heart3">&#10084;</span>
                    <br />
                    <strong><span class="im">I'm</span></strong><br /><span class="sadie">Sadie! </span></div>
                    
                    <?php
                    if ($_SESSION['referid'] !== 'admin') {
                        ?>
                        <div class="sadietalknormal mt-3">
                            <div style="font-weight: bold; text-align: center;"><strong>Warmest Welcomes from Me AND...</strong></div><br />
                            <div style="font-weight: bold; text-align: center;"><strong><span class="sadietalk-blue">...Your Wonderful Sponsor (one of my BFFs!):</span>&nbsp;<span class="sadietalk-pink"><?php echo $_SESSION['referid']; ?>!</span></strong></div>
                        </div>
                        <br />
                        <?php
                    }
                    ?>

                    <div class="sadietalknormal">
                        <div style="font-weight: bold; text-align: center;">Welcome to my <strong><span class="sadietalk-pink">AWESOME APP</span></strong> where I will help your ads go totally <strong><span class="sadietalk-pink">VIRAL</span></strong> on your <strong><span class="sadietalk-pink">OWN</span></strong> Sadie Page (featuring <strong><span class="sadietalk-blue">ME</span></strong>!) with <strong><span class="sadietalk-pink">YOUR</span></strong> Banners!</div>
                        <br />
                        <div style="font-weight: bold; text-align: center;"><strong><span class="sadietalk-blue">...AND!</span></strong> Your Viral Banners will also show up on <strong><span class="sadietalk-blue">ALL</span></strong> your referrals' pages in special slots just for you, while making you <strong>extra MOOLA</span></strong> at the same time!</div>
                    </div>
                </figcaption>
            </div>
            
        </figure>

        <figure class="mx-5 mt-3 align-items-end">
            <img src="images/sadie-transparent-shadow-peace.png" alt="Welcome to Sadie's!" class="px-3 pb-4">
            <div style="display:flex; flex-direction:column;">
                <figcaption class="py-5">
                    <div class="sadietalknormal">
                        <div class="sadietalkbig sadietalkbig-24em mb-4">
                            <span class="sadietalk-pink"><span class="heart4">&#10084;</span>&nbsp;Checkout My Members' Awesome Viral Banners!!!</span>&nbsp;<span class="heart4">&#10084;</span>
                            <br />
                        </div>
                        <div style="font-weight: bold;" class="center mb-4">As a new member of my Viral Banner app, <strong><span class="sadietalk-blue">FIRST</span></strong> visit my members' Viral Banners <strong><span class="sadietalk-pink">ABOVE!</span></strong>&nbsp;</span>For each one, allow the timed countdown to complete, then choose the <strong><a class="page-scroll" href="banners/#memberships">MEMBERSHIP</a></strong> you want to register for once you have enough Viral Banner clicks!</div>

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

                        <div class="sadietalkbig sadietalkbig-2em mt-4">
                        <span class="sadietalk-pink"><span class="heart4">&#10084;</span>&nbsp;Just Lookit&nbsp;<span class="sadietalk-blue">Below!</span>&nbsp;at all the&nbsp;<strong><span class="sadietalk-blue">Goodies</span></strong>&nbsp;you get with My Memberships!&nbsp;<span class="heart4">&#10084;</span></span>
                        <br />
                    </div>
                    </div>
                    </div>
                </figcaption>
            </div>
        </figure>

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

<script src="js/viralbannertimer.js"></script>
<script>
    const howManyClicked = howManyWereClicked();
    document.getElementById('alreadyclicked').innerHTML = howManyClicked;
</script>