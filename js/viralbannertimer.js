// Countdown timer for Viral Banner ad views.
function countdown(counter, id) {

    let whichsadie = Math.floor(Math.random() * 3) + 1;

    async function countDown() {
        if (counter > 0) {
            document.getElementById("timerbar").innerHTML = '<img src="images/sadie-expression-' + whichsadie + '.png"><span class="sadietalknormal"><strong><span class="sadietalk-pink">' + counter + '</span>&nbsp;<span class="sadietalk-blue"> seconds</span></strong></span>';
            counter--;
        } else {
            clearInterval(timer);
            let viralBannerClicksArray = [];
            if(localStorage.viralBannerClicks) {
                viralBannerClicksArray = JSON.parse(localStorage.viralBannerClicks);
            }
            viralBannerClicksArray.push(id);
            localStorage.setItem("viralBannerClicks", JSON.stringify(viralBannerClicksArray));

            // 1) Check if the visitor already has a key in their local storage.
            // 2) NO - Make array with this bannerslot ID as the only item, JSON.stringify the array, then add to Local Storage.
            // 3) YES - JSON.parse what they have in localstorage for the key already into an array. Push this bannerslot id onto the array. JSON.stringify the array and
            // add it to local storage key again.

            // 4) In banners.php, Get the key from localstorage and JSON.parse into an array. For each value in array, mark it clicked for the banner slot shown.

            // ???? how to do in banners.php???? DELETE viralbannerclicks table I think we don't need this.
            // 5) In registration, get key from localsorage and JSON.parse into an array. Check size of array. If large enough, user has clicked enough banners and 
            // signup button should be added to form! 
            // 6) After signup, create username record in viralbannerclicks table with their local storage array (JSON.parse again).
            // 7) Remove key from localStorage (in case someone else uses the same computer and wants to sign up!)

            document.getElementById("timerbar").innerHTML = '<img src="images/sadie-expression-' + whichsadie + '.png"><span class="sadietalknormal"><strong><span class="sadietalk-blue">DONE!</span></strong></span>'; // ANNOUNCE HOW MANY MORE BANNERS THEY NEED TO CLICK! If done, say so!
        }
    }

    let timer = setInterval(countDown, 1000);

}

function whichOnesWereClickedAlready() {

    // Get the key from localStorage and JSON.parse into an array. For each value in array, mark it clicked for that value banner slot number so user can see they already clicked.
    let viralBannerClicksArray = JSON.parse(localStorage.getItem("viralBannerClicks"));
    if (viralBannerClicksArray.length > 0) {

        viralBannerClicksArray.forEach(item => {

            document.getElementById('viralbanner' + item).style('display', 'none');
            document.getElementById('viralbanner' + item).style('visibility', 'visible');
        });
    }
}