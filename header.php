<!doctype html>
<html class="no-js" lang="en">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $metadescription ?>" />
    <meta name="author" content="Sabrina Markon" />
    <base href="/" />

    <title><?php echo $metatitle ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.png" type="image/png">

    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" />

    <!-- Magnific Popup CSS -->
    <!-- <link rel="stylesheet" href="css/magnific-popup.css"> -->

    <!-- Slick CSS -->
    <!-- <link rel="stylesheet" href="css/slick.css"> -->

    <!-- Line Icons CSS -->
    <!-- <link rel="stylesheet" href="css/LineIcons.css"> -->

    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Custom styles -->
    <link href="css/custom.css" rel="stylesheet" />
    <link href="css/imagemaker.css" rel="stylesheet">
</head>

<?php
$urlfile = basename($_SERVER['REQUEST_URI']);
$referurl = dirname($_SERVER['REQUEST_URI']);
?>

<body <?php if ($urlfile !== '/' && $urlfile !== '' && $referurl !== '/r') {
            echo 'style="padding-top: 100px;"';
        } else {
            echo 'style="padding-top: 0;"';
        }
        ?>>

    <!-- Preloader -->
    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <section class="navbar-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">

                        <a class="navbar-brand" href="#">
                            <!-- <img src="images/sadieslogoSM.png" alt="Sadie's Viral Banners Plus Logo" style="border: 5px solid #fff; border-radius: 3px; width: 75px;"> -->
                            <span class="logo-small">Sadie's <i class="fas fa-star fa-xs"></i></span>
                        </a>

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTwo" aria-controls="navbarTwo" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>

                        <?php
                        if ((isset($_SESSION['username'])) && (isset($_SESSION['password']))) {
                        ?>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarTwo">
                                <ul class="navbar-nav m-auto">
                                    <li class="nav-item"><a class="page-scroll" href="/members">Main</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/profile">Profile</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/banners">Your Banners</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/textads">Buy Text Ads</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/promotional">Earn Money</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/faq">FAQ</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/terms">Terms</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/contact">Contact</a></li>
                                </ul>
                            </div>

                            <div class="navbar-btn d-none d-sm-inline-block">
                                <ul>
                                    <li><a class="solid" href="/logout">Logout</a></li>
                                </ul>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarTwo">
                                <ul class="navbar-nav m-auto">
                                    <li class="nav-item"><a class="page-scroll" href="/">Home</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/#memberships">Memberships</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/ads">Banners</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/about">About</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/faq">FAQ</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/terms">Terms</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="/#contact">Contact</a></li>
                                </ul>
                            </div>

                            <div class="navbar-btn d-none d-sm-inline-block">
                                <ul>
                                    <li><a class="solid" href="/login">Login</a></li>
                                    <li><a class="solid" href="/register">Register</a></li>
                                </ul>
                            </div>
                        <?php
                        }
                        ?>
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!-- Header with Background Image -->
    <?php
    if ($urlfile === '/' || $urlfile === '' || $referurl === '/r') {
    ?>
        <section id="home" class="slider_area">
            <div id="carouselThree" class="carousel slide" data-interval="false" data-ride="carousel">
                <!--             <ol class="carousel-indicators">
                <li data-target="#carouselThree" data-slide-to="0" class="active"></li>
                <li data-target="#carouselThree" data-slide-to="1"></li>
                <li data-target="#carouselThree" data-slide-to="2"></li>
            </ol> -->

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="slider-content">
                                        <h1 class="title">Sadie's Viral Banners Plus</h1>
                                        <p class="text">Jetting Your's Around The Globe Free!</p>
                                        <ul class="slider-btn rounded-buttons">
                                            <li><a class="main-btn rounded-one" href="/free">GET STARTED FREE!</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> <!-- row -->
                        </div> <!-- container -->
                        <div class="slider-image-box d-none d-lg-flex align-items-center">
                            <div class="slider-image">
                                <img src="images/globeandairplaneandstars.png" alt="Sadie's Viral Banners Plus!">
                            </div> <!-- slider-imgae -->
                        </div> <!-- slider-imgae box -->
                    </div> <!-- carousel-item -->
                </div>
        </section>
    <?php
    } else {
    ?>
        <div class="ja-toppadding2"></div>
    <?php
    }
    ?>



    <!-- Page Content -->
    <div class="row">
        <div class="col-sm-12">

            <!-- CENTRAL PAGE CONTENT APPEARS BELOW HERE -->