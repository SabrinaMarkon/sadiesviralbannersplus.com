<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}
?>

<!-- Home page content written by admin -->
<section>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="centered">
                    <section class="cards">

                        <?php
                        $showcontent = new PageContent();
                        echo $showcontent->showPage('Home Page');
                        ?>

                    </section>
                </div>
            </div>
        </div>
</section>

<!-- Different Membership Levels -->
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
                        <img src="images/free.svg" alt="">
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
                        <a class="main-btn rounded-one" href="/free">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>

            <div class="col-lg-4 col-md-7 col-sm-9">
                <div class="pricing-style mt-30">
                    <div class="pricing-icon text-center">
                        <img src="images/pro.svg" alt="">
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
                        <a class="main-btn rounded-one" href="/pro">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>

            <div class="col-lg-4 col-md-7 col-sm-9">
                <div class="pricing-style mt-30">
                    <div class="pricing-icon text-center">
                        <img src="images/gold.svg" alt="">
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
                        <a class="main-btn rounded-one" href="/gold">GET STARTED</a>
                    </div>
                </div> <!-- pricing style one -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

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
            </div>
        </div>
</section>

<!-- Contact -->

<section id="contact" class="contact-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="section-title text-center pb-30">
                    <h3 class="title">Contact</h3>
                    <p class="text">Please contact us if you need help or have any questions.</p>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="contact-wrapper form-style-two pt-15">
                    <h4 class="contact-title pb-10"><i class="lni lni-envelope"></i> Leave <span>A Message.</span></h4>

                    <form id="contact-form" action="/#contact.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-input mt-25">
                                    <label>Name or Username</label>
                                    <div class="input-items default">
                                        <input name="username" type="text" placeholder="Name or Username" required>
                                        <i class="lni lni-user"></i>
                                    </div>
                                </div> <!-- form input -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-input mt-25">
                                    <label>Email</label>
                                    <div class="input-items default">
                                        <input type="email" name="email" placeholder="Email" required>
                                        <i class="lni lni-envelope"></i>
                                    </div>
                                </div> <!-- form input -->
                            </div>
                            <div class="col-md-12">
                                <div class="form-input mt-25">
                                    <label>Subject</label>
                                    <div class="input-items default">
                                        <input type="text" name="subject" placeholder="Subject" required>
                                        <i class="lni lni-pencil-alt"></i>
                                    </div>
                                </div> <!-- form input -->
                                <div class="col-md-12">
                                    <div class="form-input mt-25">
                                        <label>Message</label>
                                        <div class="input-items default">
                                            <textarea name="message" placeholder="Message" required></textarea>
                                            <i class="lni lni-pencil-alt"></i>
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <p class="form-message"></p>
                                <div class="col-md-12">
                                    <div class="form-input light-rounded-buttons mt-30">
                                        <button class="main-btn light-rounded-two">Send Message</button>
                                    </div> <!-- form input -->
                                </div>
                            </div> <!-- row -->
                    </form>
                </div> <!-- contact wrapper form -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>