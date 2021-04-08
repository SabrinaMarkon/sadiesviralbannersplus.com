// Countdown timer for Viral Banner ad views.
function countdown(counter, bannerslot) {

    let whichsadie = Math.floor(Math.random() * 3) + 1;

    async function countDown() {
        if (counter > 0) {
            document.getElementById("timerbar").innerHTML = '<img src="images/sadie-expression-' + whichsadie + '.png"><span class="sadietalknormal"><span class="sadietalk-blue"><strong>Hi there!</strong></span> Please check out the <strong>exciting opportunity</strong> below for <strong><span class="sadietalk-pink">' + counter + '<strong></span>&nbsp;<span class="sadietalk-blue"><strong> seconds!<strong></span></span>';
            counter--;
        } else {
            clearInterval(timer);
            let viralBannerClicksArray = [];
            
            if(localStorage.viralBannerClicks) {
                viralBannerClicksArray = JSON.parse(localStorage.viralBannerClicks);
            }

            // If this Viral Banner is already in the localStorage array, we don't need to add it again.
            if (!viralBannerClicksArray.includes(bannerslot)) {
                viralBannerClicksArray.push(bannerslot);
            }

            // Write the array back into localStorage as a JSON string.
            localStorage.setItem("viralBannerClicks", JSON.stringify(viralBannerClicksArray));


            // 6) After signup, create username record in viralbannerclicks table with their local storage array (JSON.parse again).
            // 7) Remove key from localStorage (in case someone else uses the same computer and wants to sign up!)

            // TODO: Vary the words SADIE says!

            document.getElementById("timerbar").innerHTML = '<img src="images/sadie-expression-' + whichsadie + '.png"><span class="sadietalknormal"><strong><span class="sadietalk-blue">DONE!</span></strong>&nbsp;Your visit was <strong>counted!</strong> I hope you browse more! But you can <strong><span><a href="javascript:window.history.back();">RETURN</a></strong> now if you like!</span></span>'; // TODO: ANNOUNCE HOW MANY MORE BANNERS THEY NEED TO CLICK! If done, say so!
        }
    }

    let timer = setInterval(countDown, 1000);

}

function whichOnesWereClickedAlready() {

    // Get the key from localStorage and JSON.parse into an array. For each value in array, mark it clicked for that value banner slot number so user can see they already clicked.
    let viralBannerClicksArray = [];
            
    if(localStorage.viralBannerClicks) {
        
        viralBannerClicksArray = JSON.parse(localStorage.getItem("viralBannerClicks"));

        if (viralBannerClicksArray.length > 0) {

            viralBannerClicksArray.forEach(item => {
    
                let varname = 'viralbanner' + item;
                document.getElementById(varname).style.display = 'block';
                document.getElementById(varname).style.visibility = 'visible';
            });
        }
    }

    return viralBannerClicksArray; // Return so we can get the array from a successful signup to store in the database.
}

function howManyWereClicked() {

        // Get the key from localStorage and JSON.parse into an array, then check how many items are in the array to see if the user has met the requirements to sign up.
        if(localStorage.viralBannerClicks) {
            
            viralBannerClicksArray = JSON.parse(localStorage.getItem("viralBannerClicks"));
            return viralBannerClicksArray.length;
      
        }
        return 0;
}

function showSignupButtonOrPaymentButtons(paidlevel, bannerclickstosignup) {

    const howManyClicked = howManyWereClicked();

    if(howManyClicked === bannerclickstosignup) {

        // Enough Viral Banners were clicked, so show the sign up (or payment) buttons!
        if (paidlevel === 'paid') {
            return 'showpaymentbuttons';
        } else {
            return 'showfreessubmitbutton';
        }
    } else {

        // The user hasn't clicked enough Viral Banners to sign up, so make sure the sign up button is missing and tell the user
        // how many more they need to click before it shows.
        return 'showneedmoreclicksmessage';

    }
}

function clearLocalStorage() {

    localStorage.removeItem("viralBannerClicks");
}