// Countdown timer for Viral Banner ad views.
function countdown(counter, redirecturl) {

    function countDown() {
        if (counter > 0) {
            document.getElementById("timerbar").innerHTML = '<div class="sadietalknormal"><strong><span class="sadietalk-pink">' + counter + '</span>&nbsp;<span class="sadietalk-blue"> seconds</span></strong></div>';
            counter--;
        } else {
            clearInterval(timer);
            // window.location = redirecturl;
            document.getElementById("timerbar").innerHTML = '<div class="sadietalknormal"><strong><span class="sadietalk-pink">22</span>&nbsp;<span class="sadietalk-blue"> seconds</span></strong></div>';
        }
    }

    let timer = setInterval(countDown, 1000);

}