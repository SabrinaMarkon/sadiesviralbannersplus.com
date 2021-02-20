// Purchase handling:
const userForm = document.getElementById("userform");
const paypalButtonForm = document.getElementById("paypalbuttonform");
const paypalButton = document.getElementById("paypalbutton");
const coinpaymentsButtonForm = document.getElementById(
  "coinpaymentsbuttonform"
);
const coinpaymentsButton = document.getElementById("coinpaymentsbutton");
let errormsg = document.getElementById("errormsg");

// Listen for submission of payment button forms.
// The only values that are == null are null and undefined (!=)
if (paypalButtonForm != null && paypalButton != null) {
  paypalButton.addEventListener("click", formFieldsToJSON);
}
if (coinpaymentsButtonForm != null && coinpaymentsButton != null) {
  coinpaymentsButton.addEventListener("click", formFieldsToJSON);
}

function formFieldsToJSON() {
  const buttonId = this.id;

  if (errormsg != null) {
    document.getElementById("errormsg").innerHTML = "";
    document.getElementById("errormsg").style.display = "hidden";
  }

  let formattedFormFields = "";

  // Possible form fields:
  let username =
    document.getElementById("username") != null
      ? document.getElementById("username").value
      : "";
  let password =
    document.getElementById("password") != null
      ? document.getElementById("password").value
      : "";
  let confirm_password =
    document.getElementById("confirm_password") != null
      ? document.getElementById("confirm_password").value
      : "";
  let firstname =
    document.getElementById("firstname") != null
      ? document.getElementById("firstname").value
      : "";
  let lastname =
    document.getElementById("lastname") != null
      ? document.getElementById("lastname").value
      : "";
  let email =
    document.getElementById("email") != null
      ? document.getElementById("email").value
      : "";
  let paypal =
    document.getElementById("paypal") != null
      ? document.getElementById("paypal").value
      : "";
  let country =
    document.getElementById("country") != null
      ? document.getElementById("country").value
      : "";
  let signupip =
    document.getElementById("signupip") != null
      ? document.getElementById("signupip").value
      : "";
  let referid =
    document.getElementById("referid") != null
      ? document.getElementById("referid").value
      : "admin";

  // For ads username is hidden field in pay forms. Use also for upgrade pay buttons:
  let usernamefieldforads = "";
  if (buttonId === "paypalbutton") {
    usernamefieldforads =
      document.getElementById("paypalusernamefieldforads") != null
        ? document.getElementById("paypalusernamefieldforads").value
        : "";
  }
  if (buttonId === "coinpaymentsbutton") {
    usernamefieldforads =
      document.getElementById("coinpaymentsusernamefieldforads") != null
        ? document.getElementById("coinpaymentsusernamefieldforads").value
        : "";
  }

  // TODO: Make sure that upgrade form in members area includes username!!!!!!to add to the formFields below!!!

  // Build the JSON object out of the form fields that are NOT null (exist on the page):
  let formFields = {
    usernamefieldforads,
    username,
    password,
    confirm_password,
    firstname,
    lastname,
    email,
    paypal,
    country,
    signupip,
    referid,
  };

  formattedFormFields = JSON.stringify(formFields);
  // console.log(formattedFormFields);
  handlePayForm(formattedFormFields, buttonId);
}

async function handlePayForm(formattedFormFields, buttonId) {
  // First, save the purchase data into the database to retrieve after successful payment.
  const response = await fetch("apis/payformtodatabase.php", {
    method: "POST",
    body: formattedFormFields,
  });
  let idOrError = await response.text();
  idOrError = await JSON.parse(idOrError);

  if (idOrError["pendingId"] != "") {
    // Submit the pay button (even the id fails so the user can still purchase, but will need help from admin to give them their order if no purchase ID).
    // TODO: there are csp errors on the paypal site in the console.

    if (buttonId === "paypalbutton") {
      // Add the purchase id to the paypal button's custom form field.
      document.getElementById("paypalpendingId").value = idOrError["pendingId"];
      paypalButtonForm.submit();
    }
    if (buttonId === "coinpaymentsbutton") {
      // Add the purchase id to the coinpayments button's custom form field.
      document.getElementById("coinpaymentspendingId").value =
        idOrError["pendingId"];
      coinpaymentsButtonForm.submit();
    }
  } else {
    if (errormsg != null) {
      document.getElementById(
        "errormsg"
      ).innerHTML = `<div class="ja-bottompadding"></div>${idOrError["errors"]}`;
      document.getElementById("errormsg").style.display = "block";
    }
  }
}

// reorder the FAQ position numbers.
$(document).ready(() => {
  $("tbody.faqtable").sortable({
    opacity: 0.6,
    cursor: "move",
    stop: async function (event, ui) {
      let positionnumberIdsArray = [];
      $(this)
        .find("tr")
        .each(function (i) {
          // update the text in the order column to show the order that the faqs will appear to people:
          let pn = i + 1; // New position number for this record.
          $(this).find("td:nth-last-child(3)").text(pn);

          // Create array with the order the id's should be in in the database:
          let id = $(this).find("input[type=hidden]:eq(1)").val(); // id field.
          positionnumberIdsArray.push(id);
        });
      // Post to the database.
      formattedPositionnumberIdsArray = JSON.stringify(positionnumberIdsArray);
      const response = await fetch("apis/faqformtodatabase.php", {
        method: "POST",
        body: formattedPositionnumberIdsArray,
      });
      let res = await response.text();
      // console.log(res);
    },
  });
});

// Copy to clipboard:
const copyToClipboard = (str) => {
  const el = document.createElement("textarea"); // Create a <textarea> element
  el.value = str; // Set its value to the string that you want copied
  el.setAttribute("readonly", ""); // Make it readonly to be tamper-proof
  el.style.position = "absolute";
  el.style.left = "-9999px"; // Move outside the screen to make it invisible
  document.body.appendChild(el); // Append the <textarea> element to the HTML document
  const selected =
    document.getSelection().rangeCount > 0 // Check if there is any content selected previously
      ? document.getSelection().getRangeAt(0) // Store selection if found
      : false; // Mark as false to know no selection existed before
  el.select(); // Select the <textarea> content
  document.execCommand("copy"); // Copy - only works as a result of a user action (e.g. click events)
  document.body.removeChild(el); // Remove the <textarea> element
  if (selected) {
    // If a selection existed before copying
    document.getSelection().removeAllRanges(); // Unselect everything on the HTML document
    document.getSelection().addRange(selected); // Restore the original selection
  }
};

// building the form for the admin promotional or download page depending on what was selected.
function setupExtraFields(ans) {
  if (ans != "") {
    let litfields = "";

    let previewfield = document.getElementById("previewfield");
    let promotionaloptionsfields = document.getElementById(
      "promotionaloptionsfields"
    );
    let downloadoptionsfields = document.getElementById(
      "downloadoptionsfields"
    );

    // Admin promotional material:
    if (ans == "banner") {
      litfields =
        litfields +
        '<label for="promotionalimage">Image URL:</label><input type="text" name="promotionalimage" id="promotionalimage" size="55" maxlength="255" class="form-control w-50">';
      previewfield.style.visibility = "visible";
      previewfield.style.display = "block";
      promotionaloptionsfields.style.visibility = "visible";
      promotionaloptionsfields.innerHTML = litfields;
      tinyMCE.execCommand("mceFocus", false, "promotionaladbody");
      tinyMCE.execCommand("mceRemoveEditor", false, "promotionaladbody");
      document.getElementById("type").focus();
    }
    if (ans == "email") {
      litfields =
        litfields +
        '<label for="promotionalsubject">Email Subject:</label><input type="text" name="promotionalsubject" size="55" maxlength="255" class="form-control w-50">';
      litfields +=
        '<label for="promotionaladbody">Email Message:</label><br><textarea name="promotionaladbody" id="promotionaladbody" rows="20"></textarea>';
      previewfield.style.visibility = "hidden";
      previewfield.style.display = "none";
      promotionaloptionsfields.style.visibility = "visible";
      promotionaloptionsfields.innerHTML = litfields;
      tinyMCE.execCommand("mceAddEditor", true, "promotionaladbody");
      document.getElementById("type").focus();
    }

    // Admin download library:
    if (ans == "link") {
      litfields =
        litfields +
        '<label for="url">Download URL:</label><input type="text" name="url" size="55" maxlength="255" class="form-control w-50" placeholder="Download URL">';
      downloadoptionsfields.style.visibility = "visible";
      downloadoptionsfields.style.display = "block";
      downloadoptionsfields.innerHTML = litfields;
    }
    if (ans == "file") {
      litfields =
        litfields +
        '<label for="file">Download File:</label><input type="file" name="file" size="55" maxlength="255" class="form-control w-50" placeholder="Download File">';
      downloadoptionsfields.style.visibility = "visible";
      downloadoptionsfields.style.display = "block";
      downloadoptionsfields.innerHTML = litfields;
    }
  }

  if (ans == "") {
    if (previewfield && promotionaloptionsfields) {
      previewfield.style.visibility = "hidden";
      previewfield.style.display = "none";
      tinyMCE.execCommand("mceFocus", false, "promotionaladbody");
      tinyMCE.execCommand("mceRemoveEditor", false, "promotionaladbody");
      promotionaloptionsfields.style.visibility = "hidden";
      promotionaloptionsfields.innerHTML = "";
    }
    if (downloadoptionsfields) {
      downloadoptionsfields.style.visibility = "hidden";
      downloadoptionsfields.style.display = "none";
      downloadoptionsfields.innerHTML = "";
    }
    document.getElementById("type").focus();
  }
}

// Text field character counter:
var text_max = 200;
$("#count_message").html(text_max + " remaining");

$("#text").keyup(function () {
  var text_length = $("#text").val().length;
  var text_remaining = text_max - text_length;

  $("#count_message").html(text_remaining + " remaining");
});

// Preloader:
$(window).on("load", function (event) {
  $(".preloader").delay(500).fadeOut(500);
});

// Sticky Nav:
$(window).on("scroll", function (event) {
  var scroll = $(window).scrollTop();
  if (scroll < 20) {
    $(".navbar-area").removeClass("sticky");
    $(".navbar-area img").attr("src", "images/sadieslogoSM.png");
    $(".navbar-area img").css("border", "3px solid #0067f4");
  } else {
    $(".navbar-area").addClass("sticky");
    $(".navbar-area img").attr("src", "images/sadieslogoSM.png");
  }
});

// Section Menu Active:
// Nice scrolling from menu is for main.php only."
const currentUrl = window.location.pathname;
const currentRoute = currentUrl.substring(currentUrl.lastIndexOf("/") + 1);
if (currentRoute === "") {
  var scrollLink = $(".page-scroll");
  // Active link switching
  $(window).scroll(function () {
    var scrollbarLocation = $(this).scrollTop();
    scrollLink.each(function () {
      var sectionOffset = $(this).offset().top - 73;
      if (sectionOffset <= scrollbarLocation) {
        $(this).parent().addClass("active");
        $(this).parent().siblings().removeClass("active");
      }
    });
  });
}

// Close navbar-collapse when 'a' clicked:
$(".navbar-nav a").on("click", function () {
  $(".navbar-collapse").removeClass("show");
});

$(".navbar-toggler").on("click", function () {
  $(this).toggleClass("active");
});

$(".navbar-nav a").on("click", function () {
  $(".navbar-toggler").removeClass("active");
});

// Sidebar:
$('[href="#side-menu-left"], .overlay-left').on("click", function (event) {
  $(".sidebar-left, .overlay-left").addClass("open");
});

$('[href="#close"], .overlay-left').on("click", function (event) {
  $(".sidebar-left, .overlay-left").removeClass("open");
});

// Back to Top:
// Show or hide the sticky footer button
$(window).on("scroll", function (event) {
  if ($(this).scrollTop() > 600) {
    $(".back-to-top").fadeIn(200);
  } else {
    $(".back-to-top").fadeOut(200);
  }
});

// Animate the scroll to top:
$(".back-to-top").on("click", function (event) {
  event.preventDefault();

  $("html, body").animate(
    {
      scrollTop: 0,
    },
    1500
  );
});
