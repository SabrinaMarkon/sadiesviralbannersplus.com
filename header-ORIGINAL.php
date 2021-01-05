<!doctype html>
<html class="no-js" lang="en">

  <head>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="<?php echo $metadescription ?>" />
	<meta name="author" content="Sabrina Markon" />
	<base href = "/" />

  <title><?php echo $metatitle ?></title>

    <!-- Bootstrap core CSS -->
	  <link href="js/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" />
    
    <!-- Custom styles -->
    <link href="css/custom.css" rel="stylesheet" />
    <link href="css/imagemaker.css" rel="stylesheet">
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/">Sadie's Viral Banners Plus</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">

			<?php
			if ((isset($_SESSION['username'])) && (isset($_SESSION['password']))) {

        ?>
        <li class="nav-item active">
          <a class="nav-link" href="/members">Main
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/profile">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/banners">Your Banners</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/textads">Buy Text Ads</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/promotional">Promote</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/faq">FAQ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/terms">Terms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/contact">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/logout">Logout</a>
        </li>
        <?php
			}	else {

        ?>
        <li class="nav-item active">
          <a class="nav-link" href="/">Home
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/faq">FAQ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/terms">Terms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/contact">Contact</a>
        </li>
        <?php
			}
			?>
					
          </ul>
        </div>
      </div>
    </nav>

    <!-- Header with Background Image -->
    <?php
    $urlfile = basename($_SERVER['REQUEST_URI']);
    if ($urlfile === '/' || $urlfile === '') {
      ?>
      <header class="ja-headerimage">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <h1 class="title display-3 text-center text-white mt-4">Sadie's Viral Banners Plus</h1>
            </div>
          </div>
        </div>
      </header>
      <?php
    } else {
      ?>
      <div class="ja-toppadding2"></div>
      <?php
    }
    ?>

    <!-- Page Content -->
    <div class="container">

		<div class="row">
			<div class="col-sm-12">		

<!-- CENTRAL PAGE CONTENT APPEARS BELOW HERE -->		
