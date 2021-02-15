<!doctype html>
<html class="no-js" lang="en">

<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> -->
  <meta name="description" content="<?php echo $metadescription ?>" />
  <meta name="author" content="Sabrina Markon" />
  <base href="/" />

  <title><?php echo $metatitle ?></title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="../images/favicon.png" type="image/png">

  <!-- Bootstrap core CSS -->
  <link href="../js/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" />

  <!-- Style CSS -->
  <link rel="stylesheet" href="../css/style.css">

  <!-- Custom styles -->
  <link href="../css/custom.css" rel="stylesheet" />

</head>

<body style="padding-top: 0;">

  <div id="page-wrapper">
    <main>

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
      <section class="navbar-area px-5">
        <div class="row">
          <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg">

              <a class="navbar-brand" href="/" target="_blank">
                <span class="logo-small">Sadie's <i class="fas fa-star fa-xs"></i></span>
              </a>

              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTwo" aria-controls="navbarTwo" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
              </button>

              <?php
              if ((isset($_SESSION['adminusername'])) && (isset($_SESSION['adminpassword']))) {
              ?>
                <div class="collapse navbar-collapse sub-menu-bar" id="navbarTwo">
                  <ul class="navbar-nav m-auto">
                    <li class="nav-item"><a href="/admin/main">Main</a></li>
                    <li class="nav-item"><a href="/admin/settings">Settings</a></li>
                    <li class="nav-item"><a href="/admin/members">Members</a></li>
                    <li class="nav-item"><a href="/admin/money">Money</a></li>
                    <li class="nav-item"><a href="/admin/mail">Mail</a></li>
                    <li class="nav-item"><a href="/admin/pages">Pages</a></li>
                    <li class="nav-item"><a href="/admin/promotional">Promotional</a></li>
                    <li class="nav-item"><a href="/admin/faq">FAQ&nbsp;Builder</a></li>
                    <li class="nav-item"><a href="/admin/bannerspaid">Paid&nbsp;Banners</a></li>
                    <li class="nav-item"><a href="/admin/networksolos">Network&nbsp;Solos</a></li>
                    <li class="nav-item"><a href="/admin/textads">Text&nbsp;Ads</a></li>
                  </ul>
                </div>

                <div class="navbar-btn d-none d-sm-inline-block">
                  <ul>
                    <li><a class="solid" href="/admin/logout">Logout</a></li>
                  </ul>
                </div>
              <?php
              }
              ?>
            </nav> <!-- navbar -->
          </div>
        </div> <!-- row -->
      </section>

      <!-- Page Content -->
      <div class="ja-toppadding3" id="home"></div>

      <div class="row">
        <div class="col-sm-12 py-5">

          <!-- CENTRAL PAGE CONTENT APPEARS BELOW HERE -->