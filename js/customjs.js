// Copy to clipboard:
const copyToClipboard = (str) => {
  const el = document.createElement('textarea');  // Create a <textarea> element
  el.value = str;                                 // Set its value to the string that you want copied
  el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
  el.style.position = 'absolute';                 
  el.style.left = '-9999px';                      // Move outside the screen to make it invisible
  document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
  const selected =            
    document.getSelection().rangeCount > 0        // Check if there is any content selected previously
      ? document.getSelection().getRangeAt(0)     // Store selection if found
      : false;                                    // Mark as false to know no selection existed before
  el.select();                                    // Select the <textarea> content
  document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
  document.body.removeChild(el);                  // Remove the <textarea> element
  if (selected) {                                 // If a selection existed before copying
    document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
    document.getSelection().addRange(selected);   // Restore the original selection
  }
};

// building the form for the admin promotional page depending on what was selected.
function setuppromotional(ans) {

  if (ans != "") {

    var litfields = '';
    if (ans == "banner") {
      litfields = litfields + '<label for="promotionalimage">Image URL:</label><input type="text" name="promotionalimage" id="promotionalimage" size="55" maxlength="255" class="form-control w-50">';
      document.getElementById('previewfield').style.visibility = 'visible';
      document.getElementById('previewfield').style.display = 'block';
      document.getElementById('promotionaloptionsfields').style.visibility = 'visible';
      document.getElementById('promotionaloptionsfields').innerHTML=litfields;
      tinyMCE.execCommand('mceFocus', false, 'promotionaladbody');                    
      tinyMCE.execCommand('mceRemoveEditor', false, 'promotionaladbody');
      document.getElementById('type').focus();
    }

    if (ans == "email") {
      litfields = litfields + '<label for="promotionalsubject">Email Subject:</label><input type="text" name="promotionalsubject" size="55" maxlength="255" class="form-control w-50">';
      litfields += '<label for="promotionaladbody">Email Message:</label><br><textarea name="promotionaladbody" id="promotionaladbody" rows="20"></textarea>';
      document.getElementById('previewfield').style.visibility = 'hidden';
      document.getElementById('previewfield').style.display = 'none';
      document.getElementById('promotionaloptionsfields').style.visibility = 'visible';
      document.getElementById('promotionaloptionsfields').innerHTML=litfields;
      tinyMCE.execCommand('mceAddEditor', true, 'promotionaladbody');
      document.getElementById('type').focus();
    }

  }

  if (ans == "") {
    
    document.getElementById('previewfield').style.visibility = 'hidden';
    document.getElementById('previewfield').style.display = 'none';
    tinyMCE.execCommand('mceFocus', false, 'promotionaladbody');                    
    tinyMCE.execCommand('mceRemoveEditor', false, 'promotionaladbody');
    document.getElementById('promotionaloptionsfields').style.visibility = 'hidden';
    document.getElementById('promotionaloptionsfields').innerHTML='';
    document.getElementById('type').focus();
  }
}

// Text field character counter:
var text_max = 200;
$('#count_message').html(text_max + ' remaining');

$('#text').keyup(function() {
  var text_length = $('#text').val().length;
  var text_remaining = text_max - text_length;
  
  $('#count_message').html(text_remaining + ' remaining');
});

// Preloader:
$(window).on('load', function(event) {
  $('.preloader').delay(500).fadeOut(500);
});

// Sticky Nav:
$(window).on('scroll', function (event) {
  var scroll = $(window).scrollTop();
  if (scroll < 20) {
      $(".navbar-area").removeClass("sticky");
      $(".navbar-area img").attr("src", "images/sadieslogoSM.png");
<!--             $(".navbar-area img").css("border", "3px solid #0067f4"); -->
  } else {
      $(".navbar-area").addClass("sticky");
      $(".navbar-area img").attr("src", "images/sadieslogoSM.png");
  }
});

// Section Menu Active:
var scrollLink = $('.page-scroll');
// Active link switching
$(window).scroll(function () {
    var scrollbarLocation = $(this).scrollTop();

    scrollLink.each(function () {

        var sectionOffset = $(this.hash).offset().top - 73;

        if (sectionOffset <= scrollbarLocation) {
            $(this).parent().addClass('active');
            $(this).parent().siblings().removeClass('active');
        }
    });
});

// Close navbar-collapse when 'a' clicked:
$(".navbar-nav a").on('click', function () {
    $(".navbar-collapse").removeClass("show");
});

$(".navbar-toggler").on('click', function () {
    $(this).toggleClass("active");
});

$(".navbar-nav a").on('click', function () {
    $(".navbar-toggler").removeClass('active');
});

// Sidebar:
$('[href="#side-menu-left"], .overlay-left').on('click', function (event) {
  $('.sidebar-left, .overlay-left').addClass('open');
});

$('[href="#close"], .overlay-left').on('click', function (event) {
  $('.sidebar-left, .overlay-left').removeClass('open');
});

// Back to Top:
// Show or hide the sticky footer button
$(window).on('scroll', function(event) {
  if($(this).scrollTop() > 600){
      $('.back-to-top').fadeIn(200)
  } else{
      $('.back-to-top').fadeOut(200)
  }
});

// Animate the scroll to top:
$('.back-to-top').on('click', function(event) {
  event.preventDefault();
  
  $('html, body').animate({
      scrollTop: 0,
  }, 1500);
});