// Countdown timer for Viral Banner ad views.
function countdown(counter, id) {

    let whichsadie = Math.floor(Math.random() * 3) + 1;

    async function countDown() {
        if (counter > 0) {
            document.getElementById("timerbar").innerHTML = '<img src="images/sadie-expression-' + whichsadie + '.png"><span class="sadietalknormal"><span class="sadietalk-blue"><strong>Hi there!</strong></span> Please check out the <strong>exciting opportunity</strong> below for <strong>&nbsp;<span class="sadietalk-pink">' + counter + '<strong></span>&nbsp;<span class="sadietalk-blue"><strong> seconds!<strong></span></span>';
            counter--;
        } else {
            clearInterval(timer);
            let viralBannerClicksArray = [];
            
            if(localStorage.viralBannerClicks) {
                viralBannerClicksArray = JSON.parse(localStorage.viralBannerClicks);
            }

            // If this Viral Banner is already in the localStorage array, we don't need to add it again.
            if (!viralBannerClicksArray.includes(id)) {
                viralBannerClicksArray.push(id);
            }

            // Write the array back into localStorage as a JSON string.
            localStorage.setItem("viralBannerClicks", JSON.stringify(viralBannerClicksArray));

            // 4) In banners.php, Get the key from localstorage and JSON.parse into an array. For each value in array, mark it clicked for the banner slot shown.

            // 5) In registration, get key from localsorage and JSON.parse into an array. Check size of array. If large enough, user has clicked enough banners and 
            // signup button should be added to form! 
            // 6) After signup, create username record in viralbannerclicks table with their local storage array (JSON.parse again).
            // 7) Remove key from localStorage (in case someone else uses the same computer and wants to sign up!)

            document.getElementById("timerbar").innerHTML = '<img src="images/sadie-expression-' + whichsadie + '.png"><span class="sadietalknormal"><strong><span class="sadietalk-blue">DONE!</span></strong>&nbsp;Your visit was <strong>counted!</strong> I hope you browse more! But you can <strong><span><a href="/banners">RETURN</a></strong> now if you like!</span></span>'; // ANNOUNCE HOW MANY MORE BANNERS THEY NEED TO CLICK! If done, say so!
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