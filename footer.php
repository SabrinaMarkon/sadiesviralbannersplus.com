<!-- CENTRAL PAGE CONTENT APPEARS ABOVE HERE -->
</div>
</div>
<!-- /.row -->

</main>

<?php 
if (basename($_SERVER['REQUEST_URI']) === 'bannermaker') {
  ?>
  <!-- Footer -->
  </div> <!-- / #page-wrapper -->
  
  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  
  <!-- <script src="https://unpkg.com/@popperjs/core@2"></script> -->
  <script src="js/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script src="js/modernizr-3.7.1.min.js"></script>
  
  <!-- jQuery UI CSS, Libraries to help with Drag & Drop in FAQ admin and banner maker -->
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  
  <!------ START SCRIPTS ONLY FOR BANNER MAKER ------->

  <!-- For upload progress bar: -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
  <script src="js/draganddrop/kinetic-v3.9.3.js"></script>
  <!-- <script type="text/javascript" src="../js/draganddrop/version1.js"></script> TODO: gives error - needed for banner maker or not? --> 
  <script src="js/html2canvas/html2canvas.js"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="https://cdn.jsdelivr.net/es6-promise/latest/es6-promise.auto.min.js"></script> <!-- IE support -->
  <script src="js/sweetalert2/sweetalert2.js"></script>
  <link rel="stylesheet" href="css/sweetalert2.min.css">

  <script src="js/bannermaker.js"></script>
  <!------ END SCRIPTS ONLY FOR BANNER MAKER ------->

  <!-- Custom JavaScript -->
  <script src="js/customjs.js"></script>
  
  </body>
  </html>
  <?php
} else {
  ?>
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
  
  <!-- Footer -->
  <section class="footer-area footer-dark">
    <div class="container">
      <div class="row justify-content-center">
        <div class="footer-links col-lg-6 text-center">
          <a href="/about" class="footer-link">About</a>
          <a href="/faq" class="footer-link">FAQ</a>
          <a href="/terms" class="footer-link">Terms</a>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="footer-logo text-center">
            <a href="/">
              <span class="logo">Sadie's <i class="fas fa-star fa-xs"></i></span>
            </a>
          </div> <!-- footer logo -->
  
          <!--        <ul class="social text-center mt-60">
                          <li><a href="https://facebook.com/uideckHQ"><i class="lni lni-facebook-filled"></i></a></li>
                          <li><a href="https://twitter.com/uideckHQ"><i class="lni lni-twitter-original"></i></a></li>
                          <li><a href="https://instagram.com/uideckHQ"><i class="lni lni-instagram-original"></i></a></li>
                          <li><a href="#"><i class="lni lni-linkedin-original"></i></a></li>
                      </ul> -->
          <!-- social -->
          <!-- <div class="footer-support text-center">
            <span class="mail"></span>
          </div> -->
  
          <div class="copyright text-center mt-35">
            <p class="text">&copy;2021 <a href="https://sadiesviralbannersplus.com" target="_blank" rel="nofollow">SadiesViralBannersPlus.com</a><br />Made with <span class="heart">&#10084;</span> by <a rel="nofollow" href="https://sabrinamarkon.com" target="_blank">Sabrina Markon</a></p>
          </div> <!--  copyright -->
        </div>
      </div> <!-- row -->
    </div> <!-- container -->
  </section>
  
  </div> <!-- / #page-wrapper -->
  
  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <!-- <script src="https://unpkg.com/@popperjs/core@2"></script> -->
  <script src="js/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script src="js/modernizr-3.7.1.min.js"></script>
  
  <!-- jQuery UI CSS, Libraries to help with Drag & Drop in FAQ admin and banner maker -->
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

  <!-- Isotope js -->
  <script src="js/imagesloaded.pkgd.min.js"></script>
  <script src="js/isotope.pkgd.min.js"></script>
  
  <!-- Scrolling Nav js -->
  <script src="js/jquery.easing.min.js"></script>
  <script src="js/scrolling-nav.js"></script>
  
  <!-- Custom JavaScript -->
  <script src="js/customjs.js"></script>
  
  <?php
  if (basename($_SERVER['REQUEST_URI']) === 'viralbanners') {
  ?>
    <!-- For the modal dialogs in the members area Viral Banner set up page. -->
    <script src="js/viralbannermodal.js"></script>
  <?php
  }
  ?>
  </body>
  </html>
  <?php
}
